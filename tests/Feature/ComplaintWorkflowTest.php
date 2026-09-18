<?php

namespace Tests\Feature;

use App\AdminComplaintNotification;
use App\Complaint;
use App\Services\AdminComplaintNotificationService;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ComplaintWorkflowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->assertSame('sqlite', DB::connection()->getDriverName());

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('type')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->timestamps();
        });

        Schema::create('complaints', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 20)->index();
            $table->string('student_name');
            $table->string('applicant_name');
            $table->string('phone', 50);
            $table->string('class_name');
            $table->string('section_name');
            $table->string('bus_number')->nullable();
            $table->text('complaint_text');
            $table->string('status', 20)->default('new')->index();
            $table->timestamp('viewed_at')->nullable()->index();
            $table->timestamp('archived_at')->nullable()->index();
            $table->timestamp('resolved_at')->nullable()->index();
            $table->unsignedBigInteger('handled_by')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('admin_complaint_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('admin_id');
            $table->timestamp('read_at')->nullable()->index();
            $table->timestamps();
            $table->unique(['complaint_id', 'admin_id']);
            $table->index(['admin_id', 'read_at']);
        });
    }

    public function test_notification_receipts_are_idempotent_and_isolated_per_admin()
    {
        $adminA = $this->admin('a');
        $adminB = $this->admin('b');
        $complaint = $this->complaint();
        $service = app(AdminComplaintNotificationService::class);

        $service->notifyAuthorizedAdmins($complaint);
        $service->notifyAuthorizedAdmins($complaint);

        $this->assertSame(2, AdminComplaintNotification::count());
        $this->assertSame(1, $service->summaryFor($adminA)['unread_count']);
        $this->assertSame(1, $service->summaryFor($adminB)['unread_count']);

        $service->markReadForAdmin(
            AdminComplaintNotification::where('admin_id', $adminA->id)->value('id'),
            $adminA->id
        );

        $this->assertSame(0, $service->summaryFor($adminA)['unread_count']);
        $this->assertSame(1, $service->summaryFor($adminB)['unread_count']);
    }

    public function test_complaint_remains_persisted_when_notification_generation_fails()
    {
        $service = \Mockery::mock(AdminComplaintNotificationService::class);
        $service->shouldReceive('notifyAuthorizedAdmins')->once()->andThrow(new \RuntimeException('notification failure'));
        $service->shouldReceive('safeFailureLog')->once();
        $this->app->instance(AdminComplaintNotificationService::class, $service);

        $response = $this->post('/complaints', [
            'type' => 'academic',
            'student_name' => 'Student',
            'applicant_name' => 'Parent',
            'phone' => '0900000000',
            'class_name' => 'Grade 1',
            'section_name' => 'Section A',
            'complaint_text' => 'This complaint must remain saved if notifications fail.',
        ]);

        $response->assertRedirect('/complaints');
        $this->assertSame(1, Complaint::count());
        $this->assertDatabaseHas('complaints', ['status' => 'new']);
    }

    public function test_status_transitions_are_restricted_server_side()
    {
        $complaint = $this->complaint();

        $this->assertTrue($complaint->canTransitionTo('viewed'));
        $this->assertTrue($complaint->canTransitionTo('in_progress'));
        $this->assertFalse($complaint->canTransitionTo('resolved'));

        $complaint->status = 'in_progress';
        $this->assertTrue($complaint->canTransitionTo('resolved'));
        $complaint->status = 'archived';
        $this->assertFalse($complaint->canTransitionTo('resolved'));
    }

    public function test_admin_status_endpoint_updates_workflow_fields_and_blocks_invalid_transition()
    {
        $admin = $this->admin('transition');
        $complaint = $this->complaint();

        $this->actingAs($admin)->post('/SMT/admin/complaints/' . $complaint->id . '/status', [
            'status' => 'in_progress',
        ])->assertRedirect('/SMT/admin/complaints/' . $complaint->id);

        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'status' => 'in_progress',
            'handled_by' => $admin->id,
        ]);

        $this->actingAs($admin)->post('/SMT/admin/complaints/' . $complaint->id . '/status', [
            'status' => 'resolved',
        ])->assertRedirect('/SMT/admin/complaints/' . $complaint->id);

        $this->assertNotNull(Complaint::find($complaint->id)->resolved_at);

        $this->actingAs($admin)->post('/SMT/admin/complaints/' . $complaint->id . '/status', [
            'status' => 'viewed',
        ])->assertRedirect('/SMT/admin/complaints/' . $complaint->id)
            ->assertSessionHasErrors('status');

        $this->assertSame('resolved', Complaint::find($complaint->id)->status);
    }

    public function test_non_admin_cannot_poll_complaint_notifications()
    {
        $student = User::create([
            'name' => 'Student',
            'email' => 'student@example.test',
            'password' => 'secret',
            'type' => '0',
        ]);

        $this->actingAs($student)->get('/SMT/admin/complaints/notifications/poll')
            ->assertRedirect('/SMARMANger');
    }

    public function test_notification_poll_is_private_and_contains_no_complaint_pii()
    {
        $admin = $this->admin('poll');
        $complaint = $this->complaint();
        app(AdminComplaintNotificationService::class)->notifyAuthorizedAdmins($complaint);

        $response = $this->actingAs($admin)
            ->get('/SMT/admin/complaints/notifications/poll');

        $response->assertOk()->assertJsonStructure(['unread_count', 'recent']);
        $response->assertDontSee($complaint->student_name);
        $response->assertDontSee($complaint->complaint_text);
    }

    public function test_public_complaint_is_persisted_and_notifies_admins()
    {
        $this->admin('public-a');
        $this->admin('public-b');

        $response = $this->post('/complaints', [
            'type' => 'academic',
            'student_name' => 'طالب الاختبار',
            'applicant_name' => 'ولي الأمر',
            'phone' => '0900000000',
            'class_name' => 'الصف الأول',
            'section_name' => 'الشعبة أ',
            'complaint_text' => 'هذه شكوى اختبارية تحتوي على تفاصيل كافية للحفظ.',
            'website_url' => '',
        ]);

        $response->assertRedirect('/complaints');
        $this->assertSame(1, Complaint::count());
        $this->assertSame(2, AdminComplaintNotification::count());
    }

    public function test_honeypot_rejects_a_submission_without_creating_a_complaint()
    {
        $response = $this->post('/complaints', [
            'type' => 'transport',
            'student_name' => 'طالب آلي',
            'applicant_name' => 'ولي آلي',
            'phone' => '0900000000',
            'class_name' => 'الصف الأول',
            'section_name' => 'الشعبة أ',
            'bus_number' => '1',
            'complaint_text' => 'هذه شكوى آلية يجب رفضها دون إنشاء سجل.',
            'website_url' => 'https://bot.invalid',
        ]);

        $response->assertRedirect('/complaints')->assertSessionHasErrors('complaint');
        $this->assertSame(0, Complaint::count());
    }

    private function admin($suffix)
    {
        return User::create([
            'name' => 'Admin ' . $suffix,
            'email' => $suffix . '@example.test',
            'password' => 'secret',
            'type' => '2',
        ]);
    }

    private function complaint()
    {
        return Complaint::create([
            'type' => 'academic',
            'student_name' => 'Student Private Name',
            'applicant_name' => 'Parent Private Name',
            'phone' => '0900000000',
            'class_name' => 'Grade 1',
            'section_name' => 'Section A',
            'complaint_text' => 'This is a private complaint with enough detail.',
            'status' => 'new',
        ]);
    }
}
