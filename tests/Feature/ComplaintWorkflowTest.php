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

        // CLI route registration has no locale prefix; localized URLs are verified over HTTP.
        $this->withoutMiddleware([
            \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        ]);

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
            $table->string('student_name')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('phone', 50);
            $table->string('class_name')->nullable();
            $table->string('section_name')->nullable();
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
        require_once database_path('migrations/2026_10_11_000001_add_staff_feedback_to_complaints.php');
        (new \AddStaffFeedbackToComplaints)->up();
        require_once database_path('migrations/2026_10_18_000001_add_public_tracking_hash_to_complaints.php');
        (new \AddPublicTrackingHashToComplaints)->up();
        require_once database_path('migrations/2026_10_19_000001_add_staff_reference_to_complaints.php');
        (new \AddStaffReferenceToComplaints)->up();
        require_once database_path('migrations/2026_10_06_000002_add_complaint_officer_foundation.php');
        (new \AddComplaintOfficerFoundation)->up();
        $this->withSession(['complaint_auth_version' => 1]);

        Schema::create('school_data', function (Blueprint $table) { $table->bigIncrements('id'); });
        Schema::create('footer_website', function (Blueprint $table) {
            $table->bigIncrements('id'); $table->string('title')->nullable();
            $table->string('address')->nullable(); $table->string('phone')->nullable();
            $table->string('email')->nullable(); $table->string('facebook')->nullable();
            $table->string('twitter')->nullable(); $table->string('linkedin')->nullable();
            $table->string('instgram')->nullable();
        });
        DB::table('footer_website')->insert(['title' => 'School']);

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

        $response->assertRedirect(route('website.complaints.confirmation', [], false));
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

        $response->assertRedirect(route('website.complaints.confirmation', [], false));
        $this->assertSame(1, Complaint::count());
        $this->assertSame(2, AdminComplaintNotification::count());
    }

    public function test_tracking_confirmation_and_private_lookup_follow_successful_submission()
    {
        $payload = $this->submission('academic', ' 233/3 ');
        $this->post('/complaints', $payload)
            ->assertRedirect(route('website.complaints.confirmation', [], false));
        $complaint = Complaint::firstOrFail();
        $reference = session('complaint_confirmation.reference');
        $this->assertRegExp('/\AC-[23456789ABCDEFGHJKMNPQRSTUVWXYZ]{4}(?:-[23456789ABCDEFGHJKMNPQRSTUVWXYZ]{4}){2}\z/', $reference);
        $this->assertSame(hash('sha256', $reference), $complaint->public_tracking_hash);
        $this->assertSame('233/3', $complaint->student_identifier);
        $confirmation = $this->get('/complaints/confirmation')->assertOk()
            ->assertSee($reference)->assertDontSee($complaint->complaint_text);
        $this->assertStringContainsString('no-store', $confirmation->headers->get('Cache-Control'));
        $this->get('/complaints/confirmation')->assertOk()->assertSee($reference);
        $this->assertSame(1, Complaint::count());
        $result = $this->post('/complaints/track', [
            'reference' => strtolower($reference), 'student_identifier' => ' 233/3 ',
        ])->assertOk()->assertSee($reference)->assertSee(__('complaint_tracking.status.new'));
        $this->assertSame('noindex, nofollow, noarchive', $result->headers->get('X-Robots-Tag'));
        $result->assertDontSee($complaint->student_name)->assertDontSee($complaint->applicant_name)
            ->assertDontSee($complaint->phone)->assertDontSee($complaint->complaint_text);
    }

    public function test_tracking_lookup_is_uniform_rate_limited_and_excludes_legacy_and_staff()
    {
        $this->post('/complaints', $this->submission('academic', '233/3'));
        $reference = session('complaint_confirmation.reference');
        $wrongIdentifier = $this->post('/complaints/track', [
            'reference' => $reference, 'student_identifier' => '233/4',
        ])->assertOk()->assertSee(__('complaint_tracking.invalid'));
        $wrongReference = $this->post('/complaints/track', [
            'reference' => 'C-' . str_repeat('F', 40), 'student_identifier' => '233/3',
        ])->assertOk()->assertSee(__('complaint_tracking.invalid'));
        $this->assertSame($wrongIdentifier->getContent(), $wrongReference->getContent());
        $this->post('/complaints/track', ['reference' => ['invalid'], 'student_identifier' => ['invalid']])
            ->assertOk()->assertSee(__('complaint_tracking.invalid'));
        for ($attempt = 0; $attempt < 4; $attempt++) {
            $this->post('/complaints/track', ['reference' => $reference, 'student_identifier' => '233/4'])->assertOk();
        }
        $this->post('/complaints/track', ['reference' => $reference, 'student_identifier' => '233/4'])
            ->assertStatus(429)->assertSee(__('complaint_tracking.rate_limited'));

        $legacy = $this->complaint();
        $this->assertNull($legacy->public_tracking_hash);
        $staffReference = 'C-' . str_repeat('A', 40);
        Complaint::create([
            'source' => 'staff', 'type' => 'staff_feedback', 'staff_name' => 'Private staff',
            'phone' => '0900000000', 'complaint_text' => 'A staff message that stays private.',
            'student_identifier' => '999/9', 'public_tracking_hash' => hash('sha256', $staffReference),
        ]);
        $this->post('/complaints/track', ['reference' => $staffReference, 'student_identifier' => '999/9'])
            ->assertOk()->assertSee(__('complaint_tracking.invalid'))->assertDontSee('Private staff');
    }

    public function test_existing_long_parent_reference_still_tracks_without_rewriting_its_hash()
    {
        $reference = 'C-' . str_repeat('A9', 20);
        $complaint = $this->complaint();
        $complaint->student_identifier = '233/3';
        $complaint->public_tracking_hash = hash('sha256', $reference);
        $complaint->save();

        $this->post('/complaints/track', [
            'reference' => strtolower($reference), 'student_identifier' => '233/3',
        ])->assertOk()->assertSee($reference)->assertSee(__('complaint_tracking.status.new'));
        $this->assertSame(hash('sha256', $reference), $complaint->fresh()->public_tracking_hash);
        $this->assertSame(1, Complaint::count());
    }

    public function test_short_reference_generator_uses_unambiguous_random_characters()
    {
        $generator = app(\App\Services\ComplaintReferenceGenerator::class);
        $references = [];
        for ($index = 0; $index < 100; $index++) {
            $reference = $generator->generate();
            $this->assertRegExp('/\AC-[23456789ABCDEFGHJKMNPQRSTUVWXYZ]{4}(?:-[23456789ABCDEFGHJKMNPQRSTUVWXYZ]{4}){2}\z/', $reference);
            $this->assertTrue($generator->isSupported($reference));
            $references[] = $reference;
        }
        $this->assertCount(100, array_unique($references));
        $this->assertTrue($generator->isSupported('C-' . str_repeat('A9', 20)));
        $this->assertFalse($generator->isSupported('C-0000-AAAA-1111'));
    }

    public function test_staff_reference_confirmation_is_private_and_never_publicly_trackable()
    {
        $this->post('/ar/staff-feedback', [
            'staff_name' => 'Teacher Example', 'phone' => '0900000000',
            'complaint_text' => 'A staff message with enough detail for submission.',
        ])->assertRedirect('/ar/staff-feedback/confirmation');
        $staff = Complaint::firstOrFail();
        $reference = session('staff_feedback_confirmation.reference');
        $this->assertRegExp('/\AC-[23456789ABCDEFGHJKMNPQRSTUVWXYZ]{4}(?:-[23456789ABCDEFGHJKMNPQRSTUVWXYZ]{4}){2}\z/', $reference);
        $this->assertSame($reference, $staff->staff_reference);
        $this->assertSame(hash('sha256', $reference), $staff->public_tracking_hash);

        $confirmation = $this->get('/ar/staff-feedback/confirmation')->assertOk()
            ->assertSee($reference)->assertSee(__('staff_feedback.save_reference'))
            ->assertDontSee($staff->complaint_text)->assertDontSee('complaints/track');
        $this->assertStringContainsString('no-store', $confirmation->headers->get('Cache-Control'));
        $this->get('/ar/staff-feedback/confirmation')->assertOk()->assertSee($reference);
        $this->assertSame(1, Complaint::count());
        $this->post('/complaints/track', [
            'reference' => $reference, 'student_identifier' => '233/3',
        ])->assertOk()->assertSee(__('complaint_tracking.invalid'));
    }

    public function test_references_are_distinct_and_sessions_do_not_expose_other_complaints()
    {
        $this->post('/complaints', $this->submission('academic', '233/3'));
        $firstReference = session('complaint_confirmation.reference');
        $first = Complaint::firstOrFail();
        $this->post('/complaints', $this->submission('transport', '233-2'));
        $secondReference = session('complaint_confirmation.reference');
        $this->assertNotSame($firstReference, $secondReference);
        $this->assertSame(2, Complaint::count());

        $this->get('/complaints/confirmation')->assertOk()
            ->assertSee($secondReference)->assertDontSee($firstReference);
        $this->post('/complaints/track', [
            'reference' => $firstReference, 'student_identifier' => '233-2',
        ])->assertOk()->assertSee(__('complaint_tracking.invalid'));
        $this->post('/complaints/track', [
            'reference' => $firstReference, 'student_identifier' => '233/3',
        ])->assertOk()->assertSee($firstReference)->assertDontSee($secondReference);
        $this->assertSame(hash('sha256', $firstReference), $first->fresh()->public_tracking_hash);

        $this->withSession(['complaint_confirmation' => [
            'reference' => $secondReference, 'issued_at' => now()->subMinutes(31)->timestamp,
        ]])->get('/complaints/confirmation')->assertRedirect(route('website.complaints', [], false));
        $this->assertSame(2, Complaint::count());
    }

    public function test_public_status_mapping_and_locale_pages_do_not_publish_internal_details()
    {
        $this->post('/complaints', $this->submission('transport', '233-2'));
        $complaint = Complaint::firstOrFail();
        $reference = session('complaint_confirmation.reference');
        $this->assertNotNull($reference);
        $this->get('/complaints')->assertOk()->assertSee('هل سبق أن قدمت شكوى؟');
        $this->get('/complaints/track')->assertOk()->assertSee('متابعة شكوى');
        $this->assertSame('Already submitted a complaint?', __('complaint_tracking.previous_title', [], 'en'));
        $this->assertSame('Track a complaint', __('complaint_tracking.track_title', [], 'en'));
        foreach (['new', 'viewed', 'in_progress', 'resolved', 'archived'] as $status) {
            $this->assertNotEmpty(app(\App\Services\PublicComplaintTrackingService::class)->publicStatus($status));
        }
        $complaint->status = 'archived';
        $complaint->save();
        $this->post('/complaints/track', ['reference' => $reference, 'student_identifier' => '233-2'])
            ->assertOk()->assertSee(__('complaint_tracking.status.archived'))
            ->assertDontSee($complaint->complaint_text)->assertDontSee($complaint->student_name);
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
                ->assertRedirect(route('website.complaints.confirmation', [], false))->assertSessionHasNoErrors();
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

    public function test_portal_defaults_to_new_only_when_status_is_absent()
    {
        $officer = $this->admin('default-status');
        $records = [];
        foreach (['new', 'viewed', 'in_progress', 'resolved', 'archived'] as $status) {
            $record = $this->complaint();
            $record->status = $status;
            $record->save();
            $records[$status] = $record->id;
        }
        $before = Complaint::orderBy('id')->get()->toArray();
        $this->actingAs($officer)->get('/complaint-portal')->assertOk()
            ->assertViewHas('statusFilter', 'new')
            ->assertViewHas('complaints', function ($rows) use ($records) { return $rows->pluck('id')->all() === [$records['new']]; })
            ->assertSee('value="new" selected', false)->assertSee(__('complaint_portal.new_filter'));
        $all = $this->get('/complaint-portal?status=all')->assertOk()
            ->assertViewHas('statusFilter', 'all')
            ->assertViewHas('complaints', function ($rows) { return $rows->total() === 5; })
            ->assertSee('value="all" selected', false)->assertSee(__('complaint_portal.reset'));
        $this->assertStringContainsString('href="'.route('complaint-portal.index').'"', $all->getContent());
        foreach ($records as $status => $id) {
            $this->get('/complaint-portal?status='.$status)->assertOk()
                ->assertViewHas('complaints', function ($rows) use ($id) { return $rows->pluck('id')->all() === [$id]; });
        }
        $this->get('/complaint-portal?status=')->assertOk()
            ->assertViewHas('complaints', function ($rows) { return $rows->total() === 5; });
        $this->get('/complaint-portal')->assertViewHas('statusFilter', 'new');
        $this->assertSame($before, Complaint::orderBy('id')->get()->toArray());
    }

    public function test_default_new_combines_with_source_category_and_pagination()
    {
        $officer = $this->admin('default-pages');
        for ($i = 0; $i < 16; $i++) {
            Complaint::create(['source' => 'staff', 'type' => 'staff_feedback', 'staff_name' => 'Staff '.$i,
                'phone' => '0900000000', 'complaint_text' => 'Staff feedback for pagination verification.']);
        }
        $parent = $this->complaint();
        $archived = $this->complaint();
        $archived->status = 'archived';
        $archived->save();
        $this->actingAs($officer)->get('/complaint-portal?source=staff')->assertOk()
            ->assertViewHas('statusFilter', 'new')
            ->assertViewHas('complaints', function ($rows) { return $rows->total() === 16; })
            ->assertSee('source=staff')->assertSee('status=new')->assertSee('page=2');
        $this->get('/complaint-portal?source=staff&status=new&page=2')->assertOk()
            ->assertViewHas('statusFilter', 'new')
            ->assertViewHas('complaints', function ($rows) { return $rows->count() === 1 && $rows->first()->source === 'staff'; });
        $this->get('/complaint-portal?source=parent&type=academic')->assertOk()
            ->assertViewHas('complaints', function ($rows) use ($parent) { return $rows->pluck('id')->all() === [$parent->id]; });
        $this->get('/complaint-portal?source=parent&type=academic&status=all')->assertOk()
            ->assertViewHas('complaints', function ($rows) { return $rows->total() === 2; });
        $this->get('/complaint-portal?source=parent&type=academic&status=archived')->assertOk()
            ->assertViewHas('complaints', function ($rows) use ($archived) { return $rows->pluck('id')->all() === [$archived->id]; });
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

    public function test_admin_session_has_clear_denial_and_explicit_account_switch()
    {
        $admin = User::create(['name' => 'School Admin', 'email' => 'switch-admin@example.test', 'password' => 'secret', 'type' => '2']);
        $officer = $this->admin('switch-officer');
        $this->actingAs($admin)->get('/complaint-portal')->assertForbidden()
            ->assertSee(__('complaint_portal.switch_account'))->assertDontSee('cp-notification-list');
        $this->get('/complaint-portal/login')->assertForbidden()->assertSee(__('complaint_portal.access_denied_title'));
        $this->post('/complaint-portal/login', ['email' => $officer->email, 'password' => 'Isolated-password-123'])
            ->assertForbidden();
        $this->assertAuthenticatedAs($admin);
        $this->post('/complaint-portal/switch-account')->assertRedirect('/complaint-portal/login');
        $this->assertGuest();
        $this->get('/complaint-portal/login')->assertOk();
        $this->post('/complaint-portal/login', ['email' => $officer->email, 'password' => 'Isolated-password-123'])
            ->assertRedirect('/complaint-portal');
        $this->get('/complaint-portal')->assertOk();
    }

    public function test_invalid_and_unpermitted_officer_logins_have_recovery()
    {
        $officer = $this->admin('unpermitted');
        $this->post('/complaint-portal/login', ['email' => $officer->email, 'password' => 'wrong-password'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
        $officer->role->permissions = null;
        $officer->role->save();
        $this->post('/complaint-portal/login', ['email' => $officer->email, 'password' => 'Isolated-password-123'])
            ->assertForbidden()->assertSee(__('complaint_portal.switch_account'));
        $this->assertAuthenticatedAs($officer);
        $this->get('/complaint-portal/login')->assertForbidden();
        $this->post('/complaint-portal/switch-account')->assertRedirect('/complaint-portal/login');
        $this->assertGuest();
    }

    public function test_inactive_officer_gets_specific_error_only_with_correct_password()
    {
        $officer = $this->admin('inactive-recovery');
        $officer->complaint_officer_active = false;
        $officer->save();
        $this->post('/complaint-portal/login', ['email' => $officer->email, 'password' => 'wrong-password'])
            ->assertSessionHasErrors(['email' => __('complaint_portal.invalid_credentials')]);
        $this->post('/complaint-portal/login', ['email' => $officer->email, 'password' => 'Isolated-password-123'])
            ->assertSessionHasErrors(['email' => __('complaint_portal.inactive_account')]);
        $this->assertGuest();
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

    public function test_public_expired_csrf_returns_to_form_without_persistence()
    {
        $officer = $this->admin('public-expired');
        $this->actingAs($officer)->withSession(['_token' => 'new-session-token']);
        $this->app['env'] = 'local';
        try {
            $this->from('/complaint-portal')->post('/ar/staff-feedback', [
                '_token' => 'old-session-token', 'staff_name' => 'Test staff',
                'phone' => '0900000000', 'complaint_text' => 'A complete staff message with sufficient detail.',
            ])->assertRedirect('/ar/staff-feedback')->assertSessionHasErrors('complaint');
        } finally {
            $this->app['env'] = 'testing';
        }
        $this->assertSame(0, Complaint::count());
        $this->assertSame(0, AdminComplaintNotification::count());
        $this->assertAuthenticatedAs($officer);
    }

    public function test_public_validation_ignores_portal_previous_url()
    {
        $this->from('/complaint-portal')->post('/en/staff-feedback', ['staff_name' => 'Retained name'])
            ->assertRedirect('/en/staff-feedback')->assertSessionHasErrors(['phone', 'complaint_text'])
            ->assertSessionHasInput('staff_name', 'Retained name');
        $this->from('/complaint-portal')->post('/complaints', ['type' => 'academic', 'student_name' => 'Retained student'])
            ->assertRedirect('/complaints')->assertSessionHasErrors('student_identifier')
            ->assertSessionHasInput('student_name', 'Retained student');
        $this->assertSame(0, Complaint::count());
    }

    public function test_public_submission_redirects_are_session_independent()
    {
        $officer = $this->admin('redirect-matrix');
        $admin = User::create(['name' => 'Test admin', 'email' => 'redirect-admin@example.test', 'password' => 'unused', 'type' => '2']);
        $locale = getenv('ROUTING_LOCALE') ?: 'ar';
        $forms = [
            route('website.complaints.store', [], false) => $this->submission('transport', '233-2'),
            '/'.$locale.'/staff-feedback' => ['staff_name' => 'Test staff', 'phone' => '0900000000', 'complaint_text' => 'A staff message with sufficient detail.'],
        ];
        foreach ([null, $admin, $officer] as $actor) {
            \Illuminate\Support\Facades\Auth::logout();
            if ($actor) { $this->actingAs($actor); }
            foreach ($forms as $path => $payload) {
                app(\Illuminate\Cache\RateLimiter::class)->clear('complaints:127.0.0.1');
                $before = Complaint::count();
                $this->withSession(['url.intended' => '/complaint-portal', '_token' => 'fresh-token']);
                $this->app['env'] = 'local';
                try {
                    $this->from('/complaint-portal/login')->post($path, $payload + ['_token' => 'stale-token'])
                        ->assertRedirect($path)->assertSessionHasErrors('complaint')->assertSessionMissing('success');
                    $this->assertSame($before, Complaint::count());
                    $this->from('/complaint-portal')->post($path, ['_token' => 'fresh-token'])
                        ->assertRedirect($path)->assertSessionHasErrors();
                    $this->assertSame($before, Complaint::count());
                    $success = $this->from('/complaint-portal')->post($path, $payload + ['_token' => 'fresh-token']);
                    if ($path === route('website.complaints.store', [], false)) {
                        $success->assertRedirect(route('website.complaints.confirmation', [], false))
                            ->assertSessionHas('complaint_confirmation');
                    } else {
                        $success->assertRedirect('/'.$locale.'/staff-feedback/confirmation')
                            ->assertSessionHas('staff_feedback_confirmation');
                    }
                } finally {
                    $this->app['env'] = 'testing';
                }
                $this->assertSame($before + 1, Complaint::count());
                $record = Complaint::orderByDesc('id')->firstOrFail();
                $this->assertSame(1, AdminComplaintNotification::where('complaint_id', $record->id)->count());
            }
        }
    }

    public function test_public_form_opened_before_account_switch_recovers_without_insert()
    {
        $officer = $this->admin('switch-public');
        $this->actingAs($officer)->withSession(['_token' => 'token-before-switch']);
        $this->post('/complaint-portal/switch-account')->assertRedirect('/complaint-portal/login');
        $this->assertGuest();
        $this->app['env'] = 'local';
        try {
            $this->from('/complaint-portal/login')->post('/ar/staff-feedback', [
                '_token' => 'token-before-switch', 'staff_name' => 'Retained staff',
                'phone' => '0900000000', 'complaint_text' => 'The form was open before account switching.',
            ])->assertRedirect('/ar/staff-feedback')->assertSessionHasErrors('complaint')
                ->assertSessionHasInput('staff_name', 'Retained staff');
        } finally {
            $this->app['env'] = 'testing';
        }
        $this->assertSame(0, Complaint::count());
        $this->assertSame(0, AdminComplaintNotification::count());
    }

    public function test_staff_feedback_validates_and_preserves_parent_columns()
    {
        $officerA = $this->admin('staff-a');
        $officerB = $this->admin('staff-b');
        $payload = [
            'staff_name' => 'Staff Member', 'phone' => '09 123 456 789',
            'type' => 'staff_complaint',
            'complaint_text' => 'A staff complaint with enough detailed information.',
            'source' => 'parent', 'status' => 'resolved',
            'student_name' => 'Forged student', 'handled_by' => $officerA->id,
        ];
        $this->post('/ar/staff-feedback', $payload)->assertRedirect('/ar/staff-feedback/confirmation');
        $complaint = Complaint::firstOrFail();
        $this->assertSame('staff', $complaint->source);
        $this->assertSame('staff_feedback', $complaint->type);
        $this->assertSame('new', $complaint->status);
        $this->assertSame('Staff Member', $complaint->staff_name);
        $this->assertSame('09 123 456 789', $complaint->phone);
        $this->assertNull($complaint->student_name);
        $this->assertNull($complaint->student_identifier);
        $this->assertNull($complaint->applicant_name);
        $this->assertNull($complaint->class_name);
        $this->assertNull($complaint->section_name);
        $this->assertNull($complaint->handled_by);
        $this->assertSame(2, AdminComplaintNotification::where('complaint_id', $complaint->id)->count());
        $this->assertSame(1, app(AdminComplaintNotificationService::class)->summaryFor($officerA)['unread_count']);
        $this->assertSame(1, app(AdminComplaintNotificationService::class)->summaryFor($officerB)['unread_count']);
    }

    public function test_staff_suggestion_and_parent_filtering_keep_original_workflow()
    {
        $officer = $this->admin('staff-filter');
        $parent = $this->complaint();
        $legacyStaff = Complaint::create([
            'source' => 'staff', 'type' => 'staff_suggestion',
            'staff_name' => 'Earlier Staff', 'phone' => '0900000000',
            'complaint_text' => 'An earlier staff submission that must remain intact.',
        ]);
        $this->post('/en/staff-feedback', [
            'staff_name' => 'Teacher Example', 'phone' => '+963 9 1234 5678',
            'complaint_text' => 'This is a suggestion for a better school process.',
        ])->assertRedirect('/en/staff-feedback/confirmation');
        $staff = Complaint::where('type', 'staff_feedback')->firstOrFail();
        $this->assertSame('staff_suggestion', $legacyStaff->fresh()->type);
        $this->assertSame('parent', $parent->fresh()->source);
        $this->assertSame([$staff->id, $legacyStaff->id], app(\App\Services\ComplaintWorkflowService::class)->listing($officer, ['source' => 'staff'])->pluck('id')->all());
        $this->assertSame([$parent->id], app(\App\Services\ComplaintWorkflowService::class)->listing($officer, ['source' => 'parent'])->pluck('id')->all());
        $this->assertSame([$parent->id], app(\App\Services\ComplaintWorkflowService::class)->listing($officer, ['type' => 'academic'])->pluck('id')->all());
        $this->actingAs($officer)->get('/complaint-portal?source=staff')->assertOk()->assertSee('Teacher Example')
            ->assertSee('Earlier Staff')->assertDontSee('Student Private Name')->assertDontSee('staff_suggestion');
        $this->get('/complaint-portal/complaints/'.$staff->id.'?source=staff')->assertOk()
            ->assertSee('Teacher Example')->assertSee($staff->staff_reference)
            ->assertSee(__('staff_feedback.category'))->assertDontSee('staff_feedback.kind')
            ->assertDontSee(__('complaints.fields.student_identifier'))
            ->assertDontSee(__('complaints.fields.class_name'));
        $this->post('/complaint-portal/complaints/'.$staff->id.'/status', ['status' => 'viewed'])->assertRedirect();
        $this->post('/complaint-portal/complaints/'.$staff->id.'/archive')->assertRedirect();
        $this->assertSame('archived', $staff->fresh()->status);
        $this->assertSame(2, DB::table('complaint_action_audits')->where('complaint_id', $staff->id)->count());
    }

    public function test_staff_feedback_rejects_invalid_and_spam_payloads()
    {
        $this->post('/ar/staff-feedback', [
            'staff_name' => '', 'phone' => '', 'complaint_text' => 'short',
        ])->assertSessionHasErrors(['staff_name', 'phone', 'complaint_text']);
        $this->post('/ar/staff-feedback', [
            'staff_name' => 'Example', 'phone' => '0900000000',
            'complaint_text' => 'A complaint with enough detailed information.',
            'website_url' => 'https://spam.example',
        ])->assertSessionHasErrors('feedback');
        $this->assertSame(0, Complaint::count());
    }

    public function test_staff_feedback_uses_public_csrf_and_shared_rate_limit()
    {
        $payload = [
            'staff_name' => 'Example', 'phone' => '0900000000',
            'complaint_text' => 'A complaint with enough detailed information.',
        ];
        $this->withSession(['_token' => 'staff-csrf-token']);
        $this->app['env'] = 'local';
        try {
            $this->post('/en/staff-feedback', $payload)->assertRedirect('/en/staff-feedback')->assertSessionHasErrors('complaint');
            $this->assertSame(0, Complaint::count());
            $this->post('/en/staff-feedback', $payload + ['_token' => 'staff-csrf-token'])->assertRedirect('/en/staff-feedback/confirmation');
        } finally {
            $this->app['env'] = 'testing';
        }
        $this->assertSame(1, Complaint::count());

        for ($attempt = 0; $attempt < 9; $attempt++) {
            $this->post('/ar/staff-feedback', ['website_url' => 'spam'])->assertSessionHasErrors('feedback');
        }
        $this->post('/ar/staff-feedback', $payload)->assertSessionHasErrors('feedback');
        $this->assertSame(1, Complaint::count());
    }

    public function test_staff_filters_remain_selected_across_pages()
    {
        $officer = $this->admin('staff-pagination');
        $this->complaint();
        for ($number = 1; $number <= 16; $number++) {
            Complaint::create([
                'source' => 'staff', 'type' => 'staff_feedback',
                'staff_name' => 'Staff member '.$number,
                'phone' => '0900000000',
                'complaint_text' => 'A suggestion with enough detailed information.',
            ]);
        }
        $this->actingAs($officer)->get('/complaint-portal?source=staff&status=new')
            ->assertOk()->assertSee('Staff member 16')->assertDontSee('Student Private Name')
            ->assertSee('source=staff')->assertSee('page=2');
        $this->get('/complaint-portal?source=staff&status=new&page=2')
            ->assertOk()->assertSee('Staff member 1')->assertDontSee('Student Private Name');
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
