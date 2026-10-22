<?php

namespace Tests\Feature;

use App\Student;
use App\StudentAcademicPlacement;
use App\StudentFollowUp;
use App\Teacher_room_lesson;
use App\Services\StudentFollowUpService;
use App\Year;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class TeacherStudentFollowUpEligibilityTest extends TestCase
{
    private $now;
    private $year;
    private $teacherId = 41;
    private $lessonId = 51;
    private $classId = 61;
    private $roomId = 71;
    private $assignment;
    private $teacherUserId;

    protected function setUp(): void
    {
        parent::setUp();
        if (!extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The configured PHP runtime does not have pdo_sqlite enabled.');
        }
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->createSchema();
        $this->now = Carbon::parse('2026-10-12 10:00:00', 'Asia/Damascus');
        Carbon::setTestNow($this->now);

        $yearId = DB::table('years')->insertGetId(['current_year' => 1]);
        $this->year = Year::findOrFail($yearId);
        DB::table('classes')->insert(['id' => $this->classId, 'name' => 'Grade 2']);
        DB::table('rooms')->insert(['id' => $this->roomId, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'A']);
        DB::table('lessons')->insert(['id' => $this->lessonId, 'name' => 'Arabic']);
        DB::table('teachers')->insert(['id' => $this->teacherId, 'name' => 'Teacher']);
        DB::table('users')->insert(['name' => 'Teacher account', 'email' => 'teacher-follow-up@test.local',
            'password' => bcrypt('isolated-password'), 'type' => '1', 'teacher_id' => $this->teacherId]);
        $this->teacherUserId = DB::table('users')->value('id');
        $this->assignment = Teacher_room_lesson::create([
            'teacher_id' => $this->teacherId, 'lesson_id' => $this->lessonId, 'year_id' => $this->year->id,
            'class_id' => $this->classId, 'room_id' => $this->roomId,
        ]);
        DB::table('teacher_assignment_periods')->insert([
            'teacher_room_lesson_id' => $this->assignment->id, 'teacher_id' => $this->teacherId,
            'lesson_id' => $this->lessonId, 'year_id' => $this->year->id, 'class_id' => $this->classId,
            'room_id' => $this->roomId, 'effective_from' => $this->now->copy()->subDay()->format('Y-m-d H:i:s'),
            'source' => 'test', 'created_at' => $this->now, 'updated_at' => $this->now,
        ]);
        DB::table('term_years')->insert(['year_id' => $this->year->id, 'current_term' => 1, 'term' => 1]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_legacy_same_class_enrollment_is_visible_and_ajax_save_keeps_its_context()
    {
        $student = $this->enrolledStudent('legacy-section');
        $oldRoomId = 79;
        DB::table('rooms')->insert(['id' => $oldRoomId, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'Old']);
        $placement = $this->placement($student, $this->year->id, $this->classId, $oldRoomId, 'active', $this->now->copy()->subDays(5));
        DB::table('student_academic_placements')->where('id', $placement->id)->update([
            'reason' => 'student_creation', 'action_source' => 'admin_student_creation',
            'updated_at' => $this->now->copy()->subDays(5),
        ]);
        DB::table('room_student')->where('student_id', $student->id)->update(['updated_at' => $this->now->copy()->subDay()]);

        $this->actingAs(\App\User::findOrFail($this->teacherUserId));
        $this->assertSame([$student->id], $this->rosterStudentIds());
        $this->assertNull(app(StudentFollowUpService::class)
            ->resolveCreationContext($this->teacherId, $this->assignment->id, $student->id)['placement']);
        $response = $this->postJson('/SMARMANger/dashboard/teacher/student-follow-ups', [
            'assignment_id' => $this->assignment->id, 'student_id' => $student->id, 'level' => 'good',
        ]);
        $response->assertStatus(201)->assertJsonPath('student.id', $student->id)
            ->assertJsonPath('student.first', true)->assertJsonPath('summary.total', 1)
            ->assertJsonPath('summary.needs_current', 0);
        $record = StudentFollowUp::firstOrFail();
        $this->assertNull($record->student_academic_placement_id);
        $this->assertSame($this->roomId, (int) $record->room_id);
        $this->assertSame($oldRoomId, (int) $placement->fresh()->room_id);
        $this->assertSame($this->roomId, (int) DB::table('room_student')->where('student_id', $student->id)->value('room_id'));

        $update = $this->postJson('/SMARMANger/dashboard/teacher/student-follow-ups/' . $record->id . '/update', [
            'level' => 'excellent', 'note' => 'Improved',
        ]);
        $update->assertOk()->assertJsonPath('record.id', $record->id)
            ->assertJsonPath('record.level', 'excellent')->assertJsonPath('record.note', 'Improved');
        $this->assertSame(1, DB::table('student_follow_up_edit_audits')->count());
    }

    public function test_all_ratings_and_very_good_ajax_and_form_fallback_remain_compatible()
    {
        $student = $this->enrolledStudent('rating-compatibility');
        $this->placement($student, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());
        $this->actingAs(\App\User::findOrFail($this->teacherUserId));
        $url = '/SMARMANger/dashboard/teacher/student-follow-ups';
        $this->assertSame(['weak', 'average', 'good', 'very_good', 'excellent'], StudentFollowUp::LEVELS);
        foreach (StudentFollowUp::LEVELS as $level) {
            $this->postJson($url, [
                'assignment_id' => $this->assignment->id, 'student_id' => $student->id, 'level' => $level,
            ])->assertStatus(201);
            $this->assertSame($level, StudentFollowUp::orderByDesc('id')->firstOrFail()->level);
        }
        $oldValues = StudentFollowUp::orderBy('id')->pluck('level')->all();
        $record = StudentFollowUp::orderByDesc('id')->firstOrFail();
        app()->setLocale('en');
        $this->postJson($url . '/' . $record->id . '/update', ['level' => 'very_good'])
            ->assertOk()->assertJsonPath('record.level', 'very_good')
            ->assertJsonPath('record.level_label', 'Very Good');
        $this->assertSame('very_good', $record->fresh()->level);
        $this->assertSame('excellent', DB::table('student_follow_up_edit_audits')->value('previous_level'));
        $this->post($url, [
            'assignment_id' => $this->assignment->id, 'student_id' => $student->id, 'level' => 'very_good',
        ])->assertRedirect()->assertSessionHasNoErrors();
        $formRecord = StudentFollowUp::orderByDesc('id')->firstOrFail();
        $this->assertSame('very_good', $formRecord->level);
        $this->post($url . '/' . $formRecord->id . '/update', ['level' => 'very_good', 'note' => 'Updated'])
            ->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame('Updated', $formRecord->fresh()->note);
        $this->assertSame(array_slice($oldValues, 0, 4), StudentFollowUp::orderBy('id')->limit(4)->pluck('level')->all());
        $this->postJson($url, [
            'assignment_id' => $this->assignment->id, 'student_id' => $student->id, 'level' => 'unknown',
        ])->assertStatus(422)->assertJsonValidationErrors('level');
    }

    public function test_json_validation_denial_and_normal_redirect_are_preserved()
    {
        $student = $this->enrolledStudent('valid');
        $this->placement($student, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());
        $outsider = $this->enrolledStudent('outsider', false);
        $this->actingAs(\App\User::findOrFail($this->teacherUserId));
        $url = '/SMARMANger/dashboard/teacher/student-follow-ups';
        $this->postJson($url, ['assignment_id' => $this->assignment->id, 'student_id' => $student->id])
            ->assertStatus(422)->assertJsonValidationErrors('content');
        $this->postJson($url, ['assignment_id' => $this->assignment->id, 'student_id' => $student->id, 'note' => str_repeat('a', 1001)])
            ->assertStatus(422)->assertJsonValidationErrors('note');
        $this->postJson($url, ['assignment_id' => $this->assignment->id, 'student_id' => $outsider->id, 'level' => 'good'])
            ->assertStatus(403);
        $this->assertSame(0, StudentFollowUp::count());
        $this->post($url, ['assignment_id' => $this->assignment->id, 'student_id' => $student->id, 'level' => 'good'])
            ->assertRedirect();
        $this->assertSame(1, StudentFollowUp::count());
    }

    public function test_legacy_exception_rejects_competing_enrollment_and_recorded_transfer()
    {
        $student = $this->enrolledStudent('ambiguous');
        $oldRoom = 80;
        DB::table('rooms')->insert(['id' => $oldRoom, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'Other']);
        $placement = $this->placement($student, $this->year->id, $this->classId, $oldRoom, 'active', $this->now->copy()->subDays(5));
        DB::table('student_academic_placements')->where('id', $placement->id)->update([
            'reason' => 'student_creation', 'action_source' => 'admin_student_creation',
            'updated_at' => $this->now->copy()->subDays(5),
        ]);
        DB::table('room_student')->where('student_id', $student->id)->update(['updated_at' => $this->now->copy()->subDay()]);
        $this->enroll($student, $oldRoom, $this->year->id);
        $this->actingAs(\App\User::findOrFail($this->teacherUserId));
        $this->assertNotContains($student->id, $this->rosterStudentIds());
        $this->postJson('/SMARMANger/dashboard/teacher/student-follow-ups', [
            'assignment_id' => $this->assignment->id, 'student_id' => $student->id, 'level' => 'good',
        ])->assertStatus(403);
        DB::table('room_student')->where('student_id', $student->id)->where('room_id', $oldRoom)->delete();
        DB::table('student_transfer_histories')->insert([
            'student_id' => $student->id, 'year_id' => $this->year->id,
        ]);
        $this->assertNotContains($student->id, $this->rosterStudentIds());
        $this->postJson('/SMARMANger/dashboard/teacher/student-follow-ups', [
            'assignment_id' => $this->assignment->id, 'student_id' => $student->id, 'level' => 'good',
        ])->assertStatus(403);
        $this->assertSame(0, StudentFollowUp::count());
    }

    public function test_roster_and_post_share_eligibility_without_weakening_existing_guards()
    {
        $ordinary = $this->enrolledStudent('ordinary');
        $this->placement($ordinary, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());
        $transferred = $this->enrolledStudent('transferred');
        $oldRoomId = 76;
        DB::table('rooms')->insert(['id' => $oldRoomId, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'Old section']);
        $this->enroll($transferred, $oldRoomId, $this->year->id);
        $this->placement($transferred, $this->year->id, $this->classId, $this->roomId, 'closed', $this->now->copy()->subDays(10), $this->now->copy()->subDay());
        DB::table('student_academic_placements')->where('student_id', $transferred->id)->update(['room_id' => $oldRoomId]);
        $this->placement($transferred, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());
        $historical = $this->enrolledStudent('historical-current');
        $oldYear = DB::table('years')->insertGetId(['current_year' => 0]);
        $historicalRoomId = 77;
        DB::table('rooms')->insert(['id' => $historicalRoomId, 'year_id' => $oldYear, 'class_id' => $this->classId, 'name' => 'Historical section']);
        $this->enroll($historical, $historicalRoomId, $oldYear);
        $this->placement($historical, $oldYear, $this->classId, $historicalRoomId, 'closed', $this->now->copy()->subYear(), $this->now->copy()->subMonths(2));
        $this->placement($historical, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());
        $duplicateEnrollment = $this->enrolledStudent('duplicate-enrollment', false);
        $this->enroll($duplicateEnrollment, $this->roomId, $this->year->id);
        $this->enroll($duplicateEnrollment, $this->roomId, $this->year->id);
        $this->placement($duplicateEnrollment, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());

        $eligibleIds = $this->eligibleQuery()->pluck('students.id')->map(function ($id) { return (int) $id; })->all();
        $this->assertEqualsCanonicalizing([$ordinary->id, $transferred->id, $historical->id, $duplicateEnrollment->id], $eligibleIds);
        $this->actingAs(\App\User::findOrFail($this->teacherUserId));
        $this->assertEqualsCanonicalizing($eligibleIds, $this->rosterStudentIds());
        foreach ($eligibleIds as $studentId) {
            $context = app(StudentFollowUpService::class)->resolveCreationContext($this->teacherId, $this->assignment->id, $studentId);
            $this->assertSame((int) $studentId, (int) $context['student']->id);
        }

        $periodCount = DB::table('teacher_assignment_periods')->count();
        app(\App\Services\TeacherAssignmentPeriodService::class)->openForAssignment($this->assignment, $this->now);
        $this->assertSame($periodCount, DB::table('teacher_assignment_periods')->count());

        $followUpCount = StudentFollowUp::count();
        $this->actingAs(\App\User::findOrFail($this->teacherUserId))
            ->post('/SMARMANger/dashboard/teacher/student-follow-ups', [
                'assignment_id' => $this->assignment->id, 'student_id' => $transferred->id, 'level' => 'good',
            ])->assertRedirect();
        $this->assertSame(1, StudentFollowUp::where('student_id', $transferred->id)->count());
        $this->assertDashboardCountsMatchEligibleRoster($transferred->id);

        $this->assertInconsistentContextsRemainDenied();
        $this->assertEditWindowAndAuthorOnlyRulesRemainEnforced();
        $this->assertOtherAssignmentContextsRemainIsolated();
    }

    private function assertDashboardCountsMatchEligibleRoster($evaluatedStudentId)
    {
        $staleProjection = $this->enrolledStudent('stale-projection');
        $otherRoomId = 78;
        DB::table('rooms')->insert([
            'id' => $otherRoomId, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'Stale destination',
        ]);
        $otherPlacement = $this->placement(
            $staleProjection, $this->year->id, $this->classId, $otherRoomId, 'active', $this->now->copy()->subDay()
        );
        $period = DB::table('teacher_assignment_periods')->where('teacher_room_lesson_id', $this->assignment->id)->first();
        StudentFollowUp::create([
            'student_id' => $staleProjection->id, 'teacher_id' => $this->teacherId, 'lesson_id' => $this->lessonId,
            'year_id' => $this->year->id, 'class_id' => $this->classId, 'room_id' => $this->roomId,
            'student_academic_placement_id' => $otherPlacement->id, 'teacher_assignment_period_id' => $period->id,
            'level' => 'good', 'observed_at' => $this->now, 'compliance_month' => $this->now->copy()->startOfMonth(),
            'compliance_half' => 1, 'created_by_user_id' => $this->teacherUserId,
        ]);
        // SQLite stores Eloquent's DATE cast as midnight DATETIME; mirror the
        // production MySQL DATE representation used by period equality queries.
        DB::table('student_follow_ups')->update([
            'compliance_month' => $this->now->copy()->startOfMonth()->format('Y-m-d'),
        ]);

        $eligibleRoster = $this->eligibleQuery()->pluck('students.id')->map(function ($id) { return (int) $id; })->all();
        $this->assertNotContains((int) $staleProjection->id, $eligibleRoster);
        $followUpCount = StudentFollowUp::count();
        $this->post('/SMARMANger/dashboard/teacher/student-follow-ups', [
            'assignment_id' => $this->assignment->id, 'student_id' => $staleProjection->id, 'level' => 'good',
        ])->assertStatus(403);
        $this->assertSame($followUpCount, StudentFollowUp::count());

        $dashboard = app(\App\Http\Controllers\TeacherStudentFollowUpController::class)->index();
        $card = $dashboard->getData()['assignmentProgress'][$this->assignment->id];
        $roster = app(\App\Http\Controllers\TeacherStudentFollowUpController::class)->roster($this->assignment->id);
        $summary = $roster->getData()['summary'];

        $this->assertSame($summary['total'], $card['total']);
        $this->assertSame($summary['complete'], $card['complete']);
        $this->assertSame($summary['needs_current'], $card['needs_current']);
        $this->assertSame(4, $card['total']);
        $this->assertSame(3, $card['needs_current']);

        $secondHalfNow = $this->now->copy()->day(20);
        $this->now = $secondHalfNow;
        Carbon::setTestNow($secondHalfNow);
        app(StudentFollowUpService::class)->create(
            $this->teacherUserId, $this->teacherId, $this->assignment->id, $evaluatedStudentId, ['level' => 'good']
        );
        DB::table('student_follow_ups')->update([
            'compliance_month' => $this->now->copy()->startOfMonth()->format('Y-m-d'),
        ]);

        $dashboard = app(\App\Http\Controllers\TeacherStudentFollowUpController::class)->index();
        $card = $dashboard->getData()['assignmentProgress'][$this->assignment->id];
        $roster = app(\App\Http\Controllers\TeacherStudentFollowUpController::class)->roster($this->assignment->id);
        $summary = $roster->getData()['summary'];
        $this->assertSame($summary['needs_current'], $card['needs_current']);
        $this->assertSame(1, $card['complete']);
        $this->assertSame(3, $card['needs_current']);

        $nextMonth = $this->now->copy()->addMonth()->startOfMonth();
        $this->now = $nextMonth;
        Carbon::setTestNow($nextMonth);
        $dashboard = app(\App\Http\Controllers\TeacherStudentFollowUpController::class)->index();
        $card = $dashboard->getData()['assignmentProgress'][$this->assignment->id];
        $roster = app(\App\Http\Controllers\TeacherStudentFollowUpController::class)->roster($this->assignment->id);
        $summary = $roster->getData()['summary'];
        $this->assertSame($summary['needs_current'], $card['needs_current']);
        $this->assertSame(0, $card['complete']);
        $this->assertSame(4, $card['needs_current']);
    }

    private function assertInconsistentContextsRemainDenied()
    {
        $missingPlacement = $this->enrolledStudent('missing-placement');
        $closed = $this->enrolledStudent('closed-placement');
        $this->placement($closed, $this->year->id, $this->classId, $this->roomId, 'closed', $this->now->copy()->subDay(), $this->now);
        $future = $this->enrolledStudent('future-placement');
        $this->placement($future, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->addMinute());
        $wrongRoom = $this->enrolledStudent('wrong-room', false);
        $otherRoomId = 72;
        DB::table('rooms')->insert(['id' => $otherRoomId, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'B']);
        $this->enroll($wrongRoom, $otherRoomId, $this->year->id);
        $this->placement($wrongRoom, $this->year->id, $this->classId, $otherRoomId, 'active', $this->now->copy()->subDay());
        $archived = $this->enrolledStudent('archived');
        DB::table('students')->where('id', $archived->id)->update(['lifecycle_status' => 'archived']);
        $this->placement($archived, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());
        $otherYear = DB::table('years')->insertGetId(['current_year' => 0]);
        $otherYearStudent = $this->enrolledStudent('other-year', false);
        $otherYearRoom = 73;
        DB::table('rooms')->insert(['id' => $otherYearRoom, 'year_id' => $otherYear, 'class_id' => $this->classId, 'name' => 'Next year']);
        $this->enroll($otherYearStudent, $otherYearRoom, $otherYear);
        $this->placement($otherYearStudent, $otherYear, $this->classId, $otherYearRoom, 'active', $this->now->copy()->subDay());

        $visibleBeforeDenials = $this->eligibleQuery()->pluck('students.id')->map(function ($id) { return (int) $id; })->all();
        $this->assertNotContains($missingPlacement->id, $visibleBeforeDenials);
        $this->assertNotContains($closed->id, $visibleBeforeDenials);
        $this->assertNotContains($future->id, $visibleBeforeDenials);
        $this->assertNotContains($wrongRoom->id, $visibleBeforeDenials);
        $this->assertNotContains($archived->id, $visibleBeforeDenials);
        $this->assertNotContains($otherYearStudent->id, $visibleBeforeDenials);
        $rosterIds = $this->rosterStudentIds();
        foreach ([$missingPlacement, $closed, $future, $wrongRoom, $archived, $otherYearStudent] as $student) {
            $this->assertNotContains((int) $student->id, $rosterIds);
            $this->assertFalse(Student::currentMembership($this->year->id, $this->roomId)->whereKey($student->id)->exists());
        }
        foreach ([$missingPlacement, $closed, $future, $wrongRoom, $archived, $otherYearStudent] as $student) {
            try {
                app(StudentFollowUpService::class)->resolveCreationContext($this->teacherId, $this->assignment->id, $student->id);
                $this->fail('Ineligible student must remain denied.');
            } catch (HttpException $exception) {
                $this->assertSame(403, $exception->getStatusCode());
            }
        }
        $followUpCount = StudentFollowUp::count();
        $this->actingAs(\App\User::findOrFail($this->teacherUserId))
            ->post('/SMARMANger/dashboard/teacher/student-follow-ups', [
                'assignment_id' => $this->assignment->id, 'student_id' => $missingPlacement->id, 'level' => 'good',
            ])->assertStatus(403);
        $this->assertSame($followUpCount, StudentFollowUp::count());
    }

    private function assertEditWindowAndAuthorOnlyRulesRemainEnforced()
    {
        $student = $this->enrolledStudent('edit-window');
        $placement = $this->placement($student, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());
        $period = DB::table('teacher_assignment_periods')->first();
        $attributes = [
            'student_id' => $student->id, 'teacher_id' => $this->teacherId, 'lesson_id' => $this->lessonId,
            'year_id' => $this->year->id, 'class_id' => $this->classId, 'room_id' => $this->roomId,
            'student_academic_placement_id' => $placement->id, 'teacher_assignment_period_id' => $period->id,
            'level' => 'good', 'observed_at' => $this->now->copy()->subHours(3),
            'compliance_month' => $this->now->copy()->startOfMonth(), 'compliance_half' => 1,
            'created_by_user_id' => $this->teacherUserId,
        ];
        $expiredRecord = StudentFollowUp::create($attributes);
        DB::table('student_follow_ups')->where('id', $expiredRecord->id)->update([
            'created_at' => $this->now->copy()->subHours(3), 'updated_at' => $this->now->copy()->subHours(3),
        ]);
        $expiredRecord->refresh();

        try {
            app(StudentFollowUpService::class)->update($expiredRecord, $this->teacherUserId, $this->teacherId, ['level' => 'excellent']);
            $this->fail('Expired edit must be rejected.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
        }

        $freshRecord = StudentFollowUp::create($attributes);
        DB::table('student_follow_ups')->where('id', $freshRecord->id)->update([
            'created_at' => $this->now->copy()->subHour(), 'updated_at' => $this->now->copy()->subHour(),
        ]);
        $freshRecord->refresh();
        try {
            app(StudentFollowUpService::class)->update($freshRecord, $this->teacherUserId, 42, ['level' => 'excellent']);
            $this->fail('Another teacher must not edit this record.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
        }

        $this->assertSame('good', $expiredRecord->fresh()->level);
        $this->assertSame('good', $freshRecord->fresh()->level);
        $this->assertSame(0, DB::table('student_follow_up_edit_audits')->count());
    }

    private function assertOtherAssignmentContextsRemainIsolated()
    {
        $student = $this->enrolledStudent('authorized-section');
        $this->placement($student, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());
        $otherRoomId = 74;
        DB::table('rooms')->insert(['id' => $otherRoomId, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'C']);
        $otherLessonId = 52;
        DB::table('lessons')->insert(['id' => $otherLessonId, 'name' => 'Math']);
        $sameTeacherAssignment = Teacher_room_lesson::create([
            'teacher_id' => $this->teacherId, 'lesson_id' => $otherLessonId, 'year_id' => $this->year->id,
            'class_id' => $this->classId, 'room_id' => $otherRoomId,
        ]);
        DB::table('teacher_assignment_periods')->insert([
            'teacher_room_lesson_id' => $sameTeacherAssignment->id, 'teacher_id' => $this->teacherId,
            'lesson_id' => $otherLessonId, 'year_id' => $this->year->id, 'class_id' => $this->classId,
            'room_id' => $otherRoomId, 'effective_from' => $this->now->copy()->subDay()->format('Y-m-d H:i:s'),
            'source' => 'test', 'created_at' => $this->now, 'updated_at' => $this->now,
        ]);
        $otherSectionStudent = $this->enrolledStudent('other-section', false);
        $this->enroll($otherSectionStudent, $otherRoomId, $this->year->id);
        $this->placement($otherSectionStudent, $this->year->id, $this->classId, $otherRoomId, 'active', $this->now->copy()->subDay());

        $otherSectionContext = app(StudentFollowUpService::class)->resolveCreationContext(
            $this->teacherId, $sameTeacherAssignment->id, $otherSectionStudent->id
        );
        $this->assertSame((int) $otherSectionStudent->id, (int) $otherSectionContext['student']->id);
        $this->assertSame([$otherSectionStudent->id], $this->rosterStudentIds($sameTeacherAssignment->id));

        $otherAssignment = Teacher_room_lesson::create([
            'teacher_id' => 42, 'lesson_id' => $this->lessonId, 'year_id' => $this->year->id,
            'class_id' => $this->classId, 'room_id' => $otherRoomId,
        ]);
        try {
            app(StudentFollowUpService::class)->resolveCreationContext(42, $otherAssignment->id, $student->id);
            $this->fail('A teacher assigned to another section must not access this student.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
        }
        $visibleIds = $this->eligibleQuery()->pluck('students.id')->map(function ($id) { return (int) $id; })->all();
        $this->assertContains((int) $student->id, $visibleIds);
    }

    private function eligibleQuery()
    {
        return app(StudentFollowUpService::class)->eligibleStudentsQuery(
            $this->assignment, $this->year, $this->now
        )->orderBy('students.id');
    }

    public function test_same_grade_transfer_moves_current_rosters_and_preserves_academic_identity_and_history()
    {
        $this->createTransferSchema();
        $student = $this->transferStudent();
        DB::table('rooms')->insert(['id' => 72, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'B']);
        $oldRows = $this->academicSnapshot($student->id);
        $account = DB::table('users')->where('student_id', $student->id)->first();
        $oldPlacement = StudentAcademicPlacement::where('student_id', $student->id)->first();

        $this->moveStudent($student->id, $this->classId, 72);
        $this->assertSame($oldRows, $this->academicSnapshot($student->id));
        $this->assertEquals($account, DB::table('users')->where('student_id', $student->id)->first());
        $this->assertSame('closed', $oldPlacement->fresh()->status);
        $this->assertSame(72, (int) DB::table('room_student')->where('student_id', $student->id)->value('room_id'));
        $this->assertSame(1, DB::table('room_student')->where('student_id', $student->id)->count());
        $this->assertSame(72, (int) app(\App\Services\CurrentStudentMembership::class)->roomForStudent($student->id, $this->year->id)->id);
        $this->assertSame(0, \App\Room::find($this->roomId)->operationalStudents()->count());
        $this->assertSame([$student->id], \App\Room::find(72)->operationalStudents->pluck('id')->all());
        $this->assertSame(0, $this->eligibleQuery()->count());
        $this->assertSame(1, StudentFollowUp::where('student_id', $student->id)->count());
        $this->assertSame(1, \App\Exam_result2::where('user_id', $student->id)->count());
        $this->assertSame(0, \App\Exam_result2::currentRoster()->where('user_id', $student->id)->count());
        $freshMark = DB::table('students_marks')->where('student_id', $student->id)->where('room_id', 72)->first();
        $this->assertNull(json_decode($freshMark->mark, true)[$this->lessonId]['exam']);
        $this->assertSame(1, DB::table('students_marks')->where('student_id', $student->id)->where('room_id', 72)->count());

        $this->actingAs(\App\User::find($this->teacherUserId));
        $this->postJson('/SMARMANger/dashboard/teacher/student-follow-ups', [
            'assignment_id' => $this->assignment->id, 'student_id' => $student->id, 'level' => 'good',
        ])->assertStatus(403);
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark_bulk', [
            'kind' => 'exam2', 'rows' => json_encode([['room_id' => $this->roomId, 'lesson_id' => $this->lessonId,
                'user_id' => $student->id, 'exam_id' => 1, 'mark' => 90]]),
        ])->assertStatus(403);
        $this->get('/SMARMANger/dashboard/exam/correct_exam1/1/' . $student->id)->assertStatus(403);
        $this->postJson('/SMARMANger/dashboard/exam/update_result1', ['exam_result_id' => 1])->assertStatus(404);

        $newAssignment = $this->assignmentForRoom(72, 42);
        $newTeacher = \App\User::create(['name' => 'New teacher', 'email' => 'new@test.local', 'password' => bcrypt('test'), 'type' => '1', 'teacher_id' => 42]);
        $this->actingAs($newTeacher);
        $this->postJson('/SMARMANger/dashboard/teacher/student-follow-ups', [
            'assignment_id' => $newAssignment->id, 'student_id' => $student->id, 'note' => 'New section observation',
        ])->assertStatus(201);
        $this->assertSame(2, StudentFollowUp::where('student_id', $student->id)->count());
        $this->assertSame($oldRows, $this->academicSnapshot($student->id));

        $newExam = \App\Exams2::create(['room_id' => 72, 'class_id' => $this->classId, 'lesson_id' => $this->lessonId,
            'term_id' => DB::table('term_years')->value('id'), 'name' => 'Target assessment', 'type' => '2', 'mark' => 100]);
        $controller = app(\App\Http\Controllers\TeacherController_New::class);
        $rowsMethod = new \ReflectionMethod($controller, 'currentAssessmentRows');
        $rowsMethod->setAccessible(true);
        $countBefore = \App\Exam_result2::count();
        $rows = $rowsMethod->invoke($controller, collect(), $newExam);
        $this->assertCount(1, $rows);
        $this->assertSame((int) $student->id, (int) $rows->first()->user_id);
        $this->assertFalse($rows->first()->exists);
        $this->assertSame($countBefore, \App\Exam_result2::count());
        $payload = ['kind' => 'exam2', 'rows' => json_encode([['room_id' => 72, 'lesson_id' => $this->lessonId,
            'user_id' => $student->id, 'exam_id' => $newExam->id, 'mark' => 91]])];
        $this->post('/SMARMANger/dashboard/teacher/student_save_mark_bulk', $payload)->assertRedirect();
        $this->post('/SMARMANger/dashboard/teacher/student_save_mark_bulk', $payload)->assertRedirect();
        $this->assertSame(1, \App\Exam_result2::where('exam_id', $newExam->id)->where('user_id', $student->id)->count());
        $this->assertSame($oldRows, $this->academicSnapshot($student->id));

        // Returning to an old room needs a separate period-aware reconciliation;
        // its room/year academic rows must never become a second scaffold.
        $response = app(\App\Services\StudentTransferService::class)->handle(\Illuminate\Http\Request::create('', 'POST', [
            'student_id' => $student->id, 'class_change_id' => $this->classId, 'room_change_id' => $this->roomId,
        ]));
        $this->assertFalse(app(\App\Services\CurrentStudentMembership::class)->studentsQuery($this->year->id, $this->roomId)->whereKey($student->id)->exists());
        $this->assertSame(2, StudentAcademicPlacement::where('student_id', $student->id)->count());
    }

    public function test_cross_grade_transfer_and_legacy_route_preserve_old_curriculum()
    {
        $this->createTransferSchema();
        $student = $this->transferStudent();
        DB::table('classes')->insert(['id' => 62, 'name' => 'Grade 3']);
        DB::table('rooms')->insert(['id' => 72, 'year_id' => $this->year->id, 'class_id' => 62, 'name' => 'Grade 3 A']);
        DB::table('lessons')->insert(['id' => 52, 'name' => 'Grade 3 Math', 'class_id' => 62]);
        $before = $this->academicSnapshot($student->id);
        $request = \Illuminate\Http\Request::create('', 'POST', [
            'student_id' => $student->id, 'class_change_id' => 62, 'room_change_id' => 72,
        ]);
        app(\App\Http\Controllers\DashboardController::class)->student_change($request);
        $this->assertSame($before, $this->academicSnapshot($student->id));
        $this->assertSame(72, (int) DB::table('room_student')->where('student_id', $student->id)->value('room_id'));
        $mark = DB::table('students_marks')->where('student_id', $student->id)->where('room_id', 72)->first();
        $this->assertArrayHasKey(52, json_decode($mark->mark, true));
        $this->assertArrayNotHasKey($this->lessonId, json_decode($mark->mark, true));
        $this->assertSame('cross_grade_current_year', DB::table('student_transfer_histories')->value('transfer_type'));
        $this->assertSame(0, $this->eligibleQuery()->count());
    }

    public function test_new_year_preparation_uses_year_context_and_keeps_old_year_records()
    {
        $this->createTransferSchema();
        $student = $this->transferStudent();
        $targetYear = \App\Year::find(DB::table('years')->insertGetId(['name' => '2027/2028', 'current_year' => 0]));
        DB::table('years')->where('id', $this->year->id)->update(['next_year' => $targetYear->id]);
        DB::table('rooms')->insert(['id' => 72, 'year_id' => $targetYear->id, 'class_id' => $this->classId, 'name' => 'Next A']);
        $before = $this->academicSnapshot($student->id);
        $service = app(\App\Services\YearEndPromotionService::class);
        $placement = $service->process($student, $this->year->fresh(), $targetYear, $this->classId, 72);
        $this->assertSame($before, $this->academicSnapshot($student->id));
        $this->assertSame(2, DB::table('room_student')->where('student_id', $student->id)->count());
        $this->assertSame($this->roomId, (int) app(\App\Services\CurrentStudentMembership::class)->roomForStudent($student->id, $this->year->id)->id);
        $this->assertSame(0, Student::currentMembership(null, 72)->whereKey($student->id)->count());
        try {
            $service->process($student, $this->year->fresh(), $targetYear, $this->classId, 72);
            $this->fail('Preparing the target year twice must fail.');
        } catch (\RuntimeException $e) {
            $this->assertSame('year_end.errors.already_prepared', $e->getMessage());
        }
        $this->assertSame(1, DB::table('room_student')->where('student_id', $student->id)->where('year_id', $targetYear->id)->count());
        DB::table('years')->update(['current_year' => 0]);
        DB::table('years')->where('id', $targetYear->id)->update(['current_year' => 1]);
        $this->assertSame(0, \App\Room::find($this->roomId)->operationalStudents()->count());
        $this->assertSame([$student->id], \App\Room::find(72)->operationalStudents->pluck('id')->all());
        $this->assertSame($before, $this->academicSnapshot($student->id));
    }

    public function test_later_same_grade_enrollment_after_a_recorded_transfer_has_consistent_rosters_without_repairing_history()
    {
        DB::table('rooms')->insert(['id' => 72, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'New section']);
        $student = $this->enrolledStudent('later-section-edit');
        $placement = $this->placement($student, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDays(4));
        DB::table('student_academic_placements')->where('id', $placement->id)->update(['reason' => 'manual_class_transfer', 'action_source' => 'admin_transfer', 'updated_at' => $this->now->copy()->subDays(4)]);
        DB::table('student_transfer_histories')->insert(['student_id' => $student->id, 'year_id' => $this->year->id, 'created_at' => $this->now->copy()->subDays(4)]);
        DB::table('room_student')->where('student_id', $student->id)->update(['room_id' => 72, 'updated_at' => $this->now->copy()->subDay()]);
        $newAssignment = $this->assignmentForRoom(72, 42);
        $before = $placement->fresh()->getAttributes();
        $this->assertSame(0, $this->eligibleQuery()->whereKey($student->id)->count());
        $this->assertEquals([$student->id], app(StudentFollowUpService::class)->eligibleStudentsQuery($newAssignment, $this->year, $this->now)->pluck('students.id')->all());
        $context = app(StudentFollowUpService::class)->resolveCreationContext(42, $newAssignment->id, $student->id);
        $this->assertNull($context['placement']);
        $this->assertSame($before, $placement->fresh()->getAttributes());
        $second = $this->placement($student, $this->year->id, $this->classId, 72, 'active', $this->now->copy()->subDay());
        $this->assertSame(0, Student::currentMembership($this->year->id, 72)->whereKey($student->id)->count());
        $second->delete(); // Isolated fixture only.
        $this->enroll($student, $this->roomId, $this->year->id);
        $this->assertSame(0, Student::currentMembership($this->year->id, 72)->whereKey($student->id)->count());
    }

    public function test_gradebook_and_student_profile_cannot_mutate_another_placement_or_student()
    {
        $this->createTransferSchema();
        $student = $this->transferStudent();
        DB::table('rooms')->insert(['id' => 72, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'Unassigned']);
        $this->actingAs(\App\User::find($this->teacherUserId));
        $this->get('/SMARMANger/dashboard/teacher/gradebook/' . $this->classId . '/72/' . $this->lessonId)->assertStatus(403);
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/save', ['student_id' => $student->id, 'component_id' => 'x', 'room_id' => 72, 'subject_id' => $this->lessonId])->assertStatus(403);
        $account = \App\User::where('student_id', $student->id)->first();
        $this->actingAs($account);
        $before = $this->academicSnapshot($student->id);
        $this->post('/SMARMANger/dashboard/student/edit_student_info/' . ($student->id + 1), ['room_id' => $this->roomId])->assertRedirect('/SMARMANger');
        $this->actingAs($account);
        $this->post('/SMARMANger/dashboard/student/edit_student_info/' . $student->id, ['room_id' => 72])->assertStatus(403);
        $this->assertSame($before, $this->academicSnapshot($student->id));
    }

    public function test_admin_profile_section_change_uses_safe_transfer_and_scopes_profile_mark_updates()
    {
        $this->createTransferSchema();
        Schema::table('students', function (Blueprint $t) {
            foreach (['first_name_en','last_name_en','father_name','mother_name','email','date_birth','age','nationality','place_birth','box_birth','army_room','phone','address','country','public_record_number'] as $column) { $t->string($column)->nullable(); }
        });
        Schema::create('student_details', function (Blueprint $t) {
            $t->increments('id'); $t->unsignedInteger('student_id');
            foreach (['blood_type','city','city_alt','con_sch','father_job','father_name','father_phone','gender','grandfather_name','last_mother_name','mother_job','mother_name','mother_phone','other_name','other_phone','passport_number','phone','student_brather_and_sister','the_previous_school','the_ID_number'] as $column) { $t->string($column)->nullable(); }
            $t->timestamps();
        });
        $student = $this->transferStudent();
        DB::table('student_details')->insert(['student_id' => $student->id]);
        DB::table('rooms')->insert(['id' => 72, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'B']);
        $old = $this->academicSnapshot($student->id);
        $controller = app(\App\Http\Controllers\admincontroller::class);
        $request = \Illuminate\Http\Request::create('', 'PUT', [
            'first_name' => $student->first_name, 'last_name' => $student->last_name, 'father_name' => 'Parent',
            'email' => 'student@test.local', 'phone' => '12345', 'room_id' => 72, 'class_id' => $this->classId,
            'religion' => '0', 'lang' => '0',
        ]);
        $controller->student_update($request, $student->id);
        $this->assertSame(72, (int) DB::table('room_student')->where('student_id', $student->id)->value('room_id'));
        $this->assertSame(72, (int) StudentAcademicPlacement::where('student_id', $student->id)->where('status', 'active')->value('room_id'));
        $this->assertSame('same_class_room_current_year', DB::table('student_transfer_histories')->value('transfer_type'));
        $this->assertSame($old, $this->academicSnapshot($student->id));
        $this->assertSame(0, DB::connection()->transactionLevel());
    }

    public function test_enclosing_transaction_rolls_back_transfer_and_existing_target_enrollment_is_not_duplicated()
    {
        $this->createTransferSchema();
        $student = $this->transferStudent();
        DB::table('rooms')->insert(['id' => 72, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'B']);
        $old = $this->academicSnapshot($student->id);
        try {
            DB::transaction(function () use ($student) {
                $service = app(\App\Services\StudentTransferService::class);
                $service->handle(\Illuminate\Http\Request::create('', 'POST', [
                    'student_id' => $student->id, 'class_change_id' => $this->classId, 'room_change_id' => 72,
                ]), false);
                $this->assertTrue($service->succeeded());
                throw new \RuntimeException('profile_write_failed');
            });
        } catch (\RuntimeException $e) {
            $this->assertSame('profile_write_failed', $e->getMessage());
        }
        $this->assertSame($this->roomId, (int) DB::table('room_student')->value('room_id'));
        $this->assertSame(1, StudentAcademicPlacement::count());
        $this->assertSame(0, DB::table('student_transfer_histories')->count());
        $this->assertSame($old, $this->academicSnapshot($student->id));

        $targetYear = \App\Year::find(DB::table('years')->insertGetId(['current_year' => 0]));
        DB::table('years')->where('id', $this->year->id)->update(['next_year' => $targetYear->id]);
        DB::table('rooms')->insert(['id' => 73, 'year_id' => $targetYear->id, 'class_id' => $this->classId, 'name' => 'Next A']);
        $this->enroll($student, 73, $targetYear->id);
        try {
            app(\App\Services\YearEndPromotionService::class)->process($student, $this->year->fresh(), $targetYear, $this->classId, 73);
            $this->fail('An existing target-year enrollment without a placement needs reconciliation.');
        } catch (\RuntimeException $e) {
            $this->assertSame('year_end.errors.already_prepared', $e->getMessage());
        }
        $this->assertSame(1, DB::table('room_student')->where('year_id', $targetYear->id)->count());
    }

    public function test_bulk_transfer_only_moves_selected_students_and_preserves_old_academic_rows()
    {
        $this->createTransferSchema();
        $first = $this->transferStudent();
        $neighbor = $this->enrolledStudent('unselected');
        $second = $this->enrolledStudent('selected');
        foreach ([$neighbor, $second] as $student) {
            $this->placement($student, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDay());
        }
        DB::table('rooms')->insert(['id' => 72, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'name' => 'B']);
        $before = $this->academicSnapshot($first->id);
        app(\App\Services\StudentTransferService::class)->handleBulk(\Illuminate\Http\Request::create('', 'POST', [
            'student_ids' => [$first->id, $second->id, $first->id], 'class_change_id' => $this->classId, 'room_change_id' => 72,
        ]));
        foreach ([$first, $second] as $student) {
            $this->assertSame(72, (int) DB::table('room_student')->where('student_id', $student->id)->value('room_id'));
            $this->assertSame(1, DB::table('room_student')->where('student_id', $student->id)->count());
            $this->assertSame(1, StudentAcademicPlacement::where('student_id', $student->id)->where('status', 'active')->count());
        }
        $this->assertSame($this->roomId, (int) DB::table('room_student')->where('student_id', $neighbor->id)->value('room_id'));
        $this->assertSame(1, StudentAcademicPlacement::where('student_id', $neighbor->id)->count());
        $this->assertSame(2, DB::table('student_transfer_histories')->count());
        $this->assertSame($before, $this->academicSnapshot($first->id));
    }

    private function moveStudent($studentId, $classId, $roomId)
    {
        $service = app(\App\Services\StudentTransferService::class);
        $service->handle(\Illuminate\Http\Request::create('', 'POST', [
            'student_id' => $studentId, 'class_change_id' => $classId, 'room_change_id' => $roomId,
        ]));
        $this->assertTrue($service->succeeded());
    }

    private function assignmentForRoom($roomId, $teacherId)
    {
        if (!DB::table('teachers')->where('id', $teacherId)->exists()) {
            DB::table('teachers')->insert(['id' => $teacherId, 'name' => 'Teacher']);
        }
        $assignment = Teacher_room_lesson::create(['teacher_id' => $teacherId, 'lesson_id' => $this->lessonId,
            'year_id' => $this->year->id, 'class_id' => $this->classId, 'room_id' => $roomId]);
        DB::table('teacher_assignment_periods')->insert(['teacher_room_lesson_id' => $assignment->id, 'teacher_id' => $teacherId,
            'lesson_id' => $this->lessonId, 'year_id' => $this->year->id, 'class_id' => $this->classId, 'room_id' => $roomId,
            'effective_from' => $this->now->copy()->subDay(), 'source' => 'test']);
        return $assignment;
    }

    private function transferStudent()
    {
        $student = $this->enrolledStudent('permanent-identity');
        $this->placement($student, $this->year->id, $this->classId, $this->roomId, 'active', $this->now->copy()->subDays(10));
        \App\User::create(['name' => 'Student', 'email' => 'student@test.local', 'password' => bcrypt('unchanged'), 'type' => '0', 'student_id' => $student->id]);
        DB::table('students_marks')->insert(['student_id' => $student->id, 'year_id' => $this->year->id, 'room_id' => $this->roomId, 'mark' => json_encode([$this->lessonId => ['exam' => 81]])]);
        DB::table('report_cards')->insert(['student_id' => $student->id, 'year_id' => $this->year->id, 'room_id' => $this->roomId, 'teacher_notes' => 'Original teacher note']);
        DB::table('exams2')->insert(['id' => 1, 'room_id' => $this->roomId, 'lesson_id' => $this->lessonId, 'class_id' => $this->classId, 'term_id' => DB::table('term_years')->value('id'), 'type' => '2', 'name' => 'Original quiz']);
        DB::table('exam_result2')->insert(['id' => 1, 'user_id' => $student->id, 'room_id' => $this->roomId, 'class_id' => $this->classId, 'exam_id' => 1, 'lesson_id' => $this->lessonId, 'result' => 81]);
        app(StudentFollowUpService::class)->create($this->teacherUserId, $this->teacherId, $this->assignment->id, $student->id, ['level' => 'good']);
        DB::table('invoices')->insert(['student_id' => $student->id, 'year_id' => $this->year->id, 'amount' => 123]);
        DB::table('student_lesson_teacher_room_term_exam')->insert(['student_id' => $student->id, 'room_id' => $this->roomId, 'file' => 'original-submission.pdf']);
        return $student->fresh();
    }

    private function academicSnapshot($studentId)
    {
        $out = [];
        foreach (['students_marks', 'report_cards', 'invoices', 'student_lesson_teacher_room_term_exam'] as $table) {
            $out[$table] = DB::table($table)->where('student_id', $studentId)->where('id', 1)->get()->toJson();
        }
        $out['old_result'] = DB::table('exam_result2')->where('id', 1)->get()->toJson();
        $out['old_follow_up'] = DB::table('student_follow_ups')->where('id', 1)->get()->toJson();
        return $out;
    }

    private function createTransferSchema()
    {
        Schema::table('years', function (Blueprint $t) { $t->string('name')->nullable(); $t->unsignedInteger('next_year')->nullable(); });
        Schema::table('students', function (Blueprint $t) { $t->string('lang')->default('0'); $t->string('religion')->default('0'); });
        Schema::table('users', function (Blueprint $t) { $t->unsignedInteger('student_id')->nullable(); });
        Schema::table('room_student', function (Blueprint $t) { $t->string('term')->nullable(); });
        Schema::table('lessons', function (Blueprint $t) { $t->unsignedInteger('class_id')->nullable(); $t->string('lang')->nullable(); $t->string('religion')->nullable(); });
        DB::table('lessons')->update(['class_id' => $this->classId]);
        Schema::table('student_transfer_histories', function (Blueprint $t) {
            foreach (['user_id','from_class_id','from_room_id','to_class_id','to_room_id','previous_room_student_id','previous_students_mark_id','previous_report_card_id','transferred_by_user_id','from_placement_id','to_placement_id'] as $column) { $t->unsignedInteger($column)->nullable(); }
            foreach (['previous_room_student_snapshot','previous_students_mark_snapshot','previous_report_card_snapshot','transfer_type'] as $column) { $t->text($column)->nullable(); }
        });
        Schema::create('students_marks', function (Blueprint $t) {
            $t->increments('id'); $t->unsignedInteger('student_id'); $t->unsignedInteger('room_id')->nullable(); $t->unsignedInteger('year_id');
            foreach (['mark','mark2','result1','result2','result','term_result','year_result','status','lang','religion','estimation','estimation1','estimation2','worke_degree','notes'] as $column) { $t->text($column)->nullable(); }
            $t->integer('adjustable')->default(0); $t->timestamps();
        });
        Schema::create('report_cards', function (Blueprint $t) {
            $t->increments('id'); $t->unsignedInteger('student_id'); $t->unsignedInteger('room_id')->nullable(); $t->unsignedInteger('year_id');
            foreach (['class','teacher','teacher_name','teacher_notes','manager_notes','parent_notes','final_result','actual_attendance','student_attendance','justified_absence','unjustified_absence'] as $column) { $t->text($column)->nullable(); }
            $t->timestamps();
        });
        foreach (['exam_result','exam_result2'] as $table) { Schema::create($table, function (Blueprint $t) {
            $t->increments('id'); $t->unsignedInteger('user_id'); $t->unsignedInteger('room_id')->nullable();
            foreach (['class_id','lesson_id','term_id','exam_id'] as $column) { $t->unsignedInteger($column)->nullable(); }
            foreach (['result','type','status','start_time','end_time','medal'] as $column) { $t->string($column)->nullable(); } $t->timestamps();
        }); }
        Schema::create('exams2', function (Blueprint $t) {
            $t->increments('id'); foreach (['class_id','room_id','lesson_id','term_id'] as $column) { $t->unsignedInteger($column); }
            foreach (['name','type','mark','start_date','end_date'] as $column) { $t->string($column)->nullable(); } $t->timestamps();
        });
        foreach (['student_lesson_teacher_room_term_exam','exams_files','certificates'] as $table) { Schema::create($table, function (Blueprint $t) {
            $t->increments('id'); $t->unsignedInteger('student_id'); $t->unsignedInteger('room_id')->nullable(); $t->unsignedInteger('exam_id')->nullable(); $t->string('file')->nullable(); $t->timestamps();
        }); }
        Schema::create('invoices', function (Blueprint $t) { $t->increments('id'); $t->unsignedInteger('student_id'); $t->unsignedInteger('year_id'); $t->integer('amount'); });
    }

    private function rosterStudentIds($assignmentId = null)
    {
        $view = app(\App\Http\Controllers\TeacherStudentFollowUpController::class)
            ->roster($assignmentId ?: $this->assignment->id);

        return $view->getData()['students']->getCollection()
            ->pluck('id')->map(function ($id) { return (int) $id; })->all();
    }

    private function enrolledStudent($name, $enroll = true)
    {
        $student = Student::create(['first_name' => $name, 'last_name' => 'Student', 'lifecycle_status' => 'active']);
        if ($enroll) { $this->enroll($student, $this->roomId, $this->year->id); }
        return $student;
    }

    private function enroll(Student $student, $roomId, $yearId)
    {
        DB::table('room_student')->insert(['student_id' => $student->id, 'room_id' => $roomId, 'year_id' => $yearId,
            'created_at' => $this->now, 'updated_at' => $this->now]);
    }

    private function placement(Student $student, $yearId, $classId, $roomId, $status, Carbon $from, Carbon $to = null)
    {
        return StudentAcademicPlacement::create(['student_id' => $student->id, 'year_id' => $yearId,
            'class_id' => $classId, 'room_id' => $roomId, 'effective_from' => $from,
            'effective_to' => $to, 'status' => $status, 'reason' => 'test', 'action_source' => 'test']);
    }

    private function createSchema()
    {
        Schema::create('years', function (Blueprint $table) { $table->increments('id'); $table->boolean('current_year')->default(0); $table->timestamps(); });
        Schema::create('classes', function (Blueprint $table) { $table->increments('id'); $table->string('name'); });
        Schema::create('rooms', function (Blueprint $table) { $table->increments('id'); $table->unsignedInteger('year_id'); $table->unsignedInteger('class_id'); $table->string('name'); $table->timestamps(); });
        Schema::create('lessons', function (Blueprint $table) { $table->increments('id'); $table->string('name'); $table->timestamps(); });
        Schema::create('teachers', function (Blueprint $table) { $table->increments('id'); $table->string('name'); });
        Schema::create('users', function (Blueprint $table) { $table->bigIncrements('id'); $table->string('name'); $table->string('email'); $table->string('password'); $table->string('type'); $table->unsignedInteger('teacher_id')->nullable(); $table->rememberToken(); $table->timestamps(); });
        Schema::create('students', function (Blueprint $table) { $table->increments('id'); $table->string('first_name'); $table->string('last_name'); $table->string('lifecycle_status')->default('active'); $table->timestamps(); });
        Schema::create('teacher_room_lesson', function (Blueprint $table) { $table->increments('id'); $table->unsignedInteger('teacher_id'); $table->unsignedInteger('lesson_id'); $table->unsignedInteger('year_id'); $table->unsignedInteger('class_id'); $table->unsignedInteger('room_id'); $table->timestamps(); });
        Schema::create('room_student', function (Blueprint $table) { $table->bigIncrements('id'); $table->unsignedInteger('student_id'); $table->unsignedInteger('room_id'); $table->unsignedInteger('year_id'); $table->timestamps(); });
        Schema::create('student_transfer_histories', function (Blueprint $table) { $table->bigIncrements('id'); $table->unsignedInteger('student_id'); $table->unsignedInteger('year_id'); $table->timestamps(); });
        Schema::create('student_academic_placements', function (Blueprint $table) { $table->bigIncrements('id'); $table->unsignedInteger('student_id'); $table->unsignedInteger('year_id'); $table->unsignedInteger('class_id'); $table->unsignedInteger('room_id'); $table->unsignedInteger('term_id')->nullable(); $table->dateTime('effective_from'); $table->dateTime('effective_to')->nullable(); $table->string('status'); $table->string('reason')->nullable(); $table->string('action_source')->nullable(); $table->unsignedBigInteger('actioned_by')->nullable(); $table->timestamps(); });
        Schema::create('teacher_assignment_periods', function (Blueprint $table) { $table->bigIncrements('id'); $table->unsignedInteger('teacher_room_lesson_id')->nullable(); $table->unsignedInteger('teacher_id'); $table->unsignedInteger('lesson_id'); $table->unsignedInteger('year_id'); $table->unsignedInteger('class_id')->nullable(); $table->unsignedInteger('room_id')->nullable(); $table->dateTime('effective_from'); $table->dateTime('effective_to')->nullable(); $table->string('source')->default('test'); $table->timestamps(); });
        Schema::create('term_years', function (Blueprint $table) { $table->increments('id'); $table->unsignedInteger('year_id'); $table->integer('current_term')->default(0); $table->integer('term')->nullable(); $table->timestamps(); });
        Schema::create('messages', function (Blueprint $table) { $table->bigIncrements('id'); $table->unsignedInteger('teacher_id'); $table->integer('type'); $table->integer('view')->default(0); $table->timestamps(); });
        Schema::create('student_follow_ups', function (Blueprint $table) { $table->bigIncrements('id'); $table->unsignedInteger('student_id'); $table->unsignedInteger('teacher_id'); $table->unsignedInteger('lesson_id'); $table->unsignedInteger('year_id'); $table->unsignedInteger('term_id')->nullable(); $table->unsignedInteger('class_id')->nullable(); $table->unsignedInteger('room_id')->nullable(); $table->unsignedBigInteger('student_academic_placement_id')->nullable(); $table->unsignedBigInteger('teacher_assignment_period_id'); $table->string('level', 20)->nullable(); $table->text('note')->nullable(); $table->dateTime('observed_at'); $table->date('compliance_month'); $table->unsignedTinyInteger('compliance_half'); $table->unsignedBigInteger('created_by_user_id'); $table->unsignedBigInteger('created_by_admin_user_id')->nullable(); $table->string('created_via', 30)->nullable(); $table->unsignedBigInteger('last_edited_by_user_id')->nullable(); $table->dateTime('edited_at')->nullable(); $table->dateTime('voided_at')->nullable(); $table->unsignedBigInteger('voided_by')->nullable(); $table->text('void_reason')->nullable(); $table->timestamps(); });
        Schema::create('student_follow_up_edit_audits', function (Blueprint $table) { $table->bigIncrements('id'); $table->unsignedBigInteger('student_follow_up_id'); $table->unsignedBigInteger('edited_by_user_id'); $table->string('previous_level', 20)->nullable(); $table->text('previous_note')->nullable(); $table->string('new_level', 20)->nullable(); $table->text('new_note')->nullable(); $table->dateTime('edited_at'); $table->timestamps(); });
    }
}
