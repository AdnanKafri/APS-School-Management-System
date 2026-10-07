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
            $table->string('view_password')->nullable();
            $table->string('remember_token')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id'); $table->string('name'); $table->text('permissions')->nullable();
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

        require_once database_path('migrations/2026_10_06_000001_add_student_identifier_to_complaints.php');
        (new \AddStudentIdentifierToComplaints)->up();
        require_once database_path('migrations/2026_10_06_000002_add_complaint_officer_foundation.php');
        (new \AddComplaintOfficerFoundation)->up();
        $this->withSession(['complaint_auth_version' => 1]);

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

    public function test_notification_receipts_are_idempotent_and_isolated_per_officer()
    {
        $adminA = $this->admin('a');
        $adminB = $this->admin('b');
        $complaint = $this->complaint();
        $service = app(AdminComplaintNotificationService::class);

        $service->notifyAuthorizedOfficers($complaint);
        $service->notifyAuthorizedOfficers($complaint);

        $this->assertSame(2, AdminComplaintNotification::count());
        $this->assertSame(1, $service->summaryFor($adminA)['unread_count']);
        $this->assertSame(1, $service->summaryFor($adminB)['unread_count']);

        $service->openFor($adminA, AdminComplaintNotification::where('admin_id', $adminA->id)->value('id'));

        $this->assertSame(0, $service->summaryFor($adminA)['unread_count']);
        $this->assertSame(1, $service->summaryFor($adminB)['unread_count']);
    }

    public function test_complaint_remains_persisted_when_notification_generation_fails()
    {
        $service = \Mockery::mock(AdminComplaintNotificationService::class);
        $service->shouldReceive('notifyAuthorizedOfficers')->once()->andThrow(new \RuntimeException('notification failure'));
        $service->shouldReceive('safeFailureLog')->once();
        $this->app->instance(AdminComplaintNotificationService::class, $service);

        $response = $this->post('/complaints', [
            'type' => 'academic',
            'student_name' => 'Student',
            'student_identifier' => '233/3',
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

    public function test_officer_status_endpoint_updates_workflow_fields_and_blocks_invalid_transition()
    {
        $admin = $this->admin('transition');
        $complaint = $this->complaint();
        $this->from('/complaint-portal/complaints/' . $complaint->id);

        $this->actingAs($admin)->post('/complaint-portal/complaints/' . $complaint->id . '/status', [
            'status' => 'in_progress',
        ])->assertRedirect('/complaint-portal/complaints/' . $complaint->id);

        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'status' => 'in_progress',
            'handled_by' => $admin->id,
        ]);

        $this->actingAs($admin)->post('/complaint-portal/complaints/' . $complaint->id . '/status', [
            'status' => 'resolved',
        ])->assertRedirect('/complaint-portal/complaints/' . $complaint->id);

        $this->assertNotNull(Complaint::find($complaint->id)->resolved_at);

        $this->actingAs($admin)->post('/complaint-portal/complaints/' . $complaint->id . '/status', [
            'status' => 'viewed',
        ])->assertRedirect('/complaint-portal/complaints/' . $complaint->id)
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
        app(AdminComplaintNotificationService::class)->notifyAuthorizedOfficers($complaint);

        $response = $this->actingAs($admin)
            ->get('/complaint-portal/notifications');

        $response->assertOk()->assertJsonStructure(['unread_count', 'recent']);
        $response->assertDontSee($complaint->student_name);
        $response->assertDontSee($complaint->complaint_text);
    }

    public function test_public_complaint_is_persisted_and_notifies_officers()
    {
        $this->admin('public-a');
        $this->admin('public-b');

        $response = $this->post('/complaints', [
            'type' => 'academic',
            'student_name' => 'طالب الاختبار',
            'student_identifier' => '233-2',
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

    /** @dataProvider validStudentIdentifiers */
    public function test_student_identifier_is_preserved_for_both_complaint_types($identifier, $stored)
    {
        foreach (['academic', 'transport'] as $type) {
            $this->post('/complaints', $this->submission($type, $identifier))
                ->assertRedirect('/complaints')->assertSessionHasNoErrors();
            $this->assertDatabaseHas('complaints', ['type' => $type, 'student_identifier' => $stored]);
        }
    }

    public function validStudentIdentifiers()
    {
        return [['233/3', '233/3'], ['233-2', '233-2'], ['001/4', '001/4'], ['999-9', '999-9'], [' 233/3 ', '233/3']];
    }

    /** @dataProvider invalidStudentIdentifiers */
    public function test_invalid_student_identifier_does_not_create_records($identifier)
    {
        foreach (['academic', 'transport'] as $type) {
            $this->post('/complaints', $this->submission($type, $identifier))
                ->assertSessionHasErrors('student_identifier');
        }
        $this->assertSame(0, Complaint::count());
        $this->assertSame(0, AdminComplaintNotification::count());
    }

    public function invalidStudentIdentifiers()
    {
        return [['23/3'], ['2333/3'], ['233/33'], ['233 3'], ['233_3'], ['abc/3'], [''], [null], [['233/3']], ["233/3\nextra"]];
    }

    public function test_identifier_validation_retains_old_input()
    {
        $this->post('/complaints', $this->submission('academic', '23/3'))
            ->assertSessionHasErrors('student_identifier')
            ->assertSessionHas('_old_input.student_identifier', '23/3');
    }

    public function test_old_complaint_without_identifier_keeps_existing_workflow()
    {
        $complaint = $this->complaint();
        $this->assertNull($complaint->fresh()->student_identifier);
        $admin = $this->admin('legacy');
        $this->actingAs($admin)->post('/complaint-portal/complaints/' . $complaint->id . '/status', ['status' => 'viewed'])
            ->assertRedirect('/complaint-portal/complaints/' . $complaint->id);
        $this->assertSame('viewed', $complaint->fresh()->status);
        $this->actingAs($admin)->post('/complaint-portal/complaints/' . $complaint->id . '/archive')
            ->assertRedirect('/complaint-portal/complaints/' . $complaint->id);
        $this->assertSame('archived', $complaint->fresh()->status);
        $this->assertNull($complaint->fresh()->student_identifier);
    }

    public function test_officer_can_render_list_and_detail_without_admin_navigation()
    {
        $officer = $this->admin('render');
        $complaint = $this->complaint();
        app(\App\Services\AdminComplaintNotificationService::class)->notifyAuthorizedOfficers($complaint);
        $this->actingAs($officer)->get('/complaint-portal')->assertOk()->assertSee($complaint->student_name)
            ->assertDontSee('/SMT/admin/students')->assertDontSee('/SMT/admin/users');
        $this->get('/complaint-portal/complaints/' . $complaint->id)->assertOk()->assertSee($complaint->complaint_text);
        $this->get('/complaint-portal?status=archived')->assertOk()->assertDontSee('cp-record')->assertSee(__('complaint_portal.reset'));
        $this->get('/complaint-portal/complaints/99999')->assertNotFound();
    }

    public function test_officer_is_denied_admin_school_and_account_routes()
    {
        $this->actingAs($this->admin('isolation'));
        foreach (['/SMT/admin/students', '/SMT/admin/users', '/SMT/admin/complaints', '/SMT/admin/complaint-officers', '/SMT/admin/students/financial', '/SMARMANger/teacher'] as $path) {
            $this->get($path)->assertForbidden();
        }
        $this->post('/SMT/admin/complaint-officers', ['type' => '2'])->assertForbidden();
        $this->assertFalse(\Illuminate\Support\Facades\Gate::allows('students'));
    }

    public function test_dedicated_login_session_redirect_and_logout()
    {
        $officer = $this->admin('login');
        $officer->save();
        $this->post('/complaint-portal/login', ['email' => $officer->email, 'password' => 'Isolated-password-123'])
            ->assertRedirect('/complaint-portal')->assertSessionHas('complaint_auth_version', 1);
        $this->assertAuthenticatedAs($officer);
        $this->get('/complaint-portal')->assertOk();
        $this->get('/SMARMANger')->assertRedirect('/complaint-portal');
        $this->post('/complaint-portal/logout')->assertRedirect('/complaint-portal/login');
        $this->assertGuest();
        $this->get('/complaint-portal')->assertRedirect('/complaint-portal/login');
    }

    public function test_generic_website_login_supports_officers_without_admin_redirect()
    {
        $officer = $this->admin('generic');
        $officer->save();
        $this->post('/login1', ['email' => $officer->email, 'password' => 'Isolated-password-123'])
            ->assertRedirect('/complaint-portal')->assertSessionHas('complaint_auth_version', 1);
        $this->get('/complaint-portal')->assertOk();
        $this->get('/login')->assertRedirect('/complaint-portal');
    }

    public function test_inactive_and_revoked_officer_sessions_cannot_access_portal()
    {
        $officer = $this->admin('inactive');
        $officer->complaint_officer_active = false;
        $officer->save();
        $this->post('/complaint-portal/login', ['email' => $officer->email, 'password' => 'Isolated-password-123'])->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->actingAs($officer)->get('/complaint-portal')->assertRedirect('/complaint-portal/login');
        $officer->complaint_officer_active = true;
        $officer->complaint_auth_version = 2;
        $officer->save();
        $this->withSession(['complaint_auth_version' => 1])->actingAs($officer)->get('/complaint-portal')->assertRedirect('/complaint-portal/login');
        $this->assertGuest();
    }

    public function test_notification_open_is_post_only_and_owned_by_recipient()
    {
        $a = $this->admin('receipt-a');
        $b = $this->admin('receipt-b');
        $complaint = $this->complaint();
        app(AdminComplaintNotificationService::class)->notifyAuthorizedOfficers($complaint);
        $receipt = AdminComplaintNotification::where('admin_id', $a->id)->first();
        $this->actingAs($b)->post('/complaint-portal/notifications/' . $receipt->id . '/open')->assertNotFound();
        $this->assertNull($receipt->fresh()->read_at);
        $this->actingAs($a)->get('/complaint-portal/notifications/' . $receipt->id . '/open')->assertStatus(405);
        $this->post('/complaint-portal/notifications/' . $receipt->id . '/open')->assertRedirect('/complaint-portal/complaints/' . $complaint->id);
        $this->assertNotNull($receipt->fresh()->read_at);
        $this->assertNull(AdminComplaintNotification::where('admin_id', $b->id)->first()->read_at);
    }

    public function test_status_and_archive_audit_is_atomic_and_retries_are_idempotent()
    {
        $a = $this->admin('audit-a'); $b = $this->admin('audit-b');
        $complaint = $this->complaint();
        $workflow = app(\App\Services\ComplaintWorkflowService::class);
        $workflow->transition($a, $complaint->id, 'in_progress');
        $workflow->transition($b, $complaint->id, 'in_progress');
        $this->assertSame(1, DB::table('complaint_action_audits')->count());
        $workflow->transition($b, $complaint->id, 'resolved');
        $this->assertSame((int) $a->id, (int) $complaint->fresh()->handled_by);
        $this->assertDatabaseHas('complaint_action_audits', ['actor_id' => $b->id, 'previous_status' => 'in_progress', 'new_status' => 'resolved']);
        $workflow->transition($b, $complaint->id, 'archived');
        $this->assertSame(3, DB::table('complaint_action_audits')->count());
        $this->actingAs($a)->post('/complaint-portal/complaints/' . $complaint->id . '/status', ['status' => 'viewed'])->assertSessionHasErrors('status');
        $this->assertSame('archived', $complaint->fresh()->status);
        $this->assertSame(3, DB::table('complaint_action_audits')->count());
    }

    public function test_permissions_cannot_be_bypassed_or_promoted_by_role_changes()
    {
        $officer = $this->admin('permissions');
        $officer->role->permissions = json_encode(['view_complaints', 'students', 'manage_complaint_officers']);
        $officer->role->save();
        $this->actingAs($officer);
        $complaint = $this->complaint();
        $this->get('/complaint-portal')->assertOk();
        $this->post('/complaint-portal/complaints/' . $complaint->id . '/status', ['status' => 'in_progress'])->assertForbidden();
        $this->post('/complaint-portal/complaints/' . $complaint->id . '/archive')->assertForbidden();
        $this->get('/complaint-portal/notifications')->assertForbidden();
        $this->assertFalse(\Illuminate\Support\Facades\Gate::allows('students'));
        $this->assertSame('new', $complaint->fresh()->status);
    }

    public function test_only_active_authorized_officers_receive_new_receipts_not_admins()
    {
        $active = $this->admin('recipient');
        $inactive = $this->admin('disabled-recipient'); $inactive->complaint_officer_active = false; $inactive->save();
        $withoutPermission = $this->admin('no-permission'); $withoutPermission->role_id = null; $withoutPermission->save();
        User::create(['name' => 'Full Admin', 'email' => 'full-admin@example.test', 'password' => 'secret', 'type' => '2']);
        app(AdminComplaintNotificationService::class)->notifyAuthorizedOfficers($this->complaint());
        $this->assertSame(1, AdminComplaintNotification::count());
        $this->assertSame((int) $active->id, (int) AdminComplaintNotification::first()->admin_id);
    }

    public function test_full_admin_manages_officers_but_cannot_inject_type_role_or_plaintext_password()
    {
        $admin = User::create(['name' => 'Full Admin', 'email' => 'manager@example.test', 'password' => 'secret', 'type' => '2']);
        $this->actingAs($admin)->post('/SMT/admin/complaint-officers', [
            'name' => 'Officer', 'email' => 'new-officer@example.test', 'password' => 'Isolated-password-123',
            'password_confirmation' => 'Isolated-password-123', 'type' => '2', 'role_id' => 999, 'view_password' => 'plain',
        ])->assertSessionHasNoErrors();
        $officer = User::where('email', 'new-officer@example.test')->firstOrFail();
        $this->assertSame('8', $officer->type);
        $this->assertNull($officer->view_password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('Isolated-password-123', $officer->password));
        $this->assertSame(\App\Services\ComplaintAccess::PERMISSIONS, $officer->role->permissions);
        $this->post('/SMT/admin/complaint-officers/' . $officer->id . '/update', ['name' => 'Edited officer', 'email' => $officer->email, 'type' => '2', 'role_id' => 999])->assertSessionHasNoErrors();
        $this->assertSame('8', $officer->fresh()->type);
        $this->post('/SMT/admin/complaint-officers/' . $admin->id . '/state', ['active' => 0])->assertNotFound();
        $this->post('/SMT/admin/complaint-officers/' . $officer->id . '/state', ['active' => 0])->assertSessionHasNoErrors();
        $this->assertFalse((bool) $officer->fresh()->complaint_officer_active);
        $this->assertSame(2, (int) $officer->fresh()->complaint_auth_version);
        $this->post('/SMT/admin/complaint-officers/' . $officer->id . '/password', ['password' => 'Changed-password-456', 'password_confirmation' => 'Changed-password-456'])->assertSessionHasNoErrors();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('Changed-password-456', $officer->fresh()->password));
        $this->assertSame(3, (int) $officer->fresh()->complaint_auth_version);
        $this->post('/SMT/admin/complaint-officers/' . $officer->id . '/state', ['active' => 1])->assertSessionHasNoErrors();
        $this->assertTrue((bool) $officer->fresh()->complaint_officer_active);
    }

    public function test_admin_complaint_access_and_legacy_bookmarks_are_retired()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'legacy-admin@example.test', 'password' => 'secret', 'type' => '2']);
        $complaint = $this->complaint();
        config(['app.debug' => true]);
        $response = $this->actingAs($admin)->get('/SMT/admin/complaints');
        $response->assertNotFound()->assertSee('Page Not Found | Aladham Private School')
            ->assertDontSee($complaint->complaint_text)
            ->assertDontSee('Symfony\\Component\\HttpKernel\\Exception\\HttpException')
            ->assertDontSee('/complaint-portal');
        $this->assertFalse($response->headers->has('Location'));
        config(['app.debug' => false]);
        $this->get('/SMT/admin/complaints/' . $complaint->id)->assertStatus(410);
        $this->get('/SMT/admin/complaints/notifications/1/open')->assertStatus(410);
        $this->post('/SMT/admin/complaints/' . $complaint->id . '/status', ['status' => 'in_progress'])->assertStatus(410);
        $this->assertSame('new', $complaint->fresh()->status);
        $this->get('/complaint-portal')->assertForbidden();
        $this->get('/complaint-portal/complaints/' . $complaint->id)->assertForbidden();
        $this->get('/complaint-portal/notifications')->assertForbidden();
        $this->post('/complaint-portal/notifications/1/open')->assertForbidden();
        $this->post('/complaint-portal/complaints/' . $complaint->id . '/status', ['status' => 'in_progress'])->assertForbidden();
        $this->post('/complaint-portal/complaints/' . $complaint->id . '/archive')->assertForbidden();
        $this->assertSame('new', $complaint->fresh()->status);
    }

    public function test_non_officer_and_guests_cannot_manage_complaints()
    {
        $complaint = $this->complaint();
        $this->get('/complaint-portal')->assertRedirect('/complaint-portal/login');
        foreach (['0', '1', '3', '4', '5', '6', '7'] as $type) {
            $user = User::create(['name' => 'Other account', 'email' => 'other-'.$type.'@example.test', 'password' => 'secret', 'type' => $type]);
            $this->actingAs($user)->get('/complaint-portal')->assertForbidden();
            $this->post('/complaint-portal/complaints/' . $complaint->id . '/status', ['status' => 'in_progress'])->assertForbidden();
        }
        $this->assertSame('new', $complaint->fresh()->status);
    }

    public function test_complaint_mutations_require_csrf_tokens()
    {
        $officer = $this->admin('csrf'); $complaint = $this->complaint();
        $this->actingAs($officer)->withSession(['_token' => 'isolated-csrf-token']);
        $this->app['env'] = 'local'; // Exercise the real middleware, not PHPUnit's bypass.
        try {
            $this->post('/complaint-portal/complaints/' . $complaint->id . '/status', ['status' => 'in_progress'])->assertRedirect('/complaint-portal/login');
            $this->assertSame('new', $complaint->fresh()->status);
            $this->post('/complaint-portal/complaints/' . $complaint->id . '/status', ['status' => 'in_progress', '_token' => 'isolated-csrf-token'])->assertRedirect('/complaint-portal/complaints/' . $complaint->id);
        } finally {
            $this->app['env'] = 'testing';
        }
        $this->assertSame('in_progress', $complaint->fresh()->status);
    }

    public function test_legacy_account_saves_cannot_expose_officer_password_or_elevate_type()
    {
        $officer = $this->admin('legacy-identity');
        $officer->password = \Illuminate\Support\Facades\Hash::make('Changed-password-456');
        $officer->view_password = 'Changed-password-456';
        $officer->save();
        $this->assertNull($officer->fresh()->view_password);
        $this->assertSame(2, $officer->fresh()->complaint_auth_version);
        $officer->type = '2';
        try { $officer->save(); $this->fail('Officer type escalation was accepted'); }
        catch (\Illuminate\Validation\ValidationException $e) { $this->assertArrayHasKey('account', $e->errors()); }
        $this->assertSame('8', $officer->fresh()->type);
        try { $officer->fresh()->delete(); $this->fail('Officer deletion was accepted'); }
        catch (\Illuminate\Validation\ValidationException $e) { $this->assertArrayHasKey('account', $e->errors()); }
        $this->assertDatabaseHas('users', ['id' => $officer->id, 'type' => '8']);
    }

    public function test_existing_student_teacher_and_admin_website_login_destinations_are_unchanged()
    {
        foreach (['0' => '/SMARMANger/dashboard/student', '1' => '/SMARMANger/teacher', '2' => '/SMT/admin/index'] as $type => $destination) {
            $user = User::create(['name' => 'Existing account', 'email' => 'regression-'.$type.'@example.test', 'type' => (string) $type, 'password' => \Illuminate\Support\Facades\Hash::make('Isolated-password-123')]);
            $this->post('/login1', ['email' => $user->email, 'password' => 'Isolated-password-123'])->assertRedirect($destination);
            $this->assertAuthenticatedAs($user);
            $this->assertTrue(\Illuminate\Support\Facades\Hash::check('Isolated-password-123', $user->fresh()->password));
            \Illuminate\Support\Facades\Auth::logout();
        }
    }

    public function test_foundation_migration_is_repeatable_without_data_loss()
    {
        $officer = $this->admin('repeat-migration'); $complaint = $this->complaint();
        app(\App\Services\ComplaintWorkflowService::class)->transition($officer, $complaint->id, 'viewed');
        (new \AddComplaintOfficerFoundation)->up();
        $this->assertSame('viewed', $complaint->fresh()->status);
        $this->assertSame(1, DB::table('complaint_action_audits')->count());
        $this->assertDatabaseHas('users', ['id' => $officer->id, 'type' => '8']);
    }

    public function test_officer_login_attempts_are_throttled_on_dedicated_and_generic_entry()
    {
        $officer = $this->admin('throttle');
        for ($i = 0; $i < 5; $i++) {
            $this->post($i % 2 ? '/login1' : '/complaint-portal/login', ['email' => $officer->email, 'password' => 'wrong-password'])->assertSessionHasErrors('email');
        }
        $this->postJson('/complaint-portal/login', ['email' => $officer->email, 'password' => 'Isolated-password-123'])->assertStatus(429);
        $this->assertGuest();
    }

    public function test_missing_or_invalid_officer_role_fails_closed_without_runtime_error()
    {
        $officer = $this->admin('invalid-role');
        $officer->role->permissions = null; $officer->role->save();
        $this->actingAs($officer)->get('/complaint-portal')->assertForbidden();
        $this->post('/complaint-portal/complaints/99999/status', ['status' => 'viewed'])->assertForbidden();
        $this->post('/complaint-portal/logout')->assertRedirect('/complaint-portal/login');
        $this->assertGuest();
    }

    private function submission($type, $identifier)
    {
        return [
            'type' => $type,
            'student_identifier' => $identifier,
            'student_name' => 'Test student',
            'applicant_name' => 'Test guardian',
            'phone' => '0900000000',
            'class_name' => 'Grade 1',
            'section_name' => 'Section A',
            'bus_number' => $type === 'transport' ? '1' : null,
            'complaint_text' => 'An isolated test complaint with sufficient details.',
        ];
    }

    private function admin($suffix)
    {
        $role = \App\Role::firstOrCreate(['name' => 'Complaint Officers'], ['permissions' => json_encode(\App\Services\ComplaintAccess::PERMISSIONS)]);
        return User::create([
            'name' => 'Admin ' . $suffix,
            'email' => $suffix . '@example.test',
            'password' => \Illuminate\Support\Facades\Hash::make('Isolated-password-123'),
            'type' => '8',
            'role_id' => $role->id,
        ])->fresh();
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
