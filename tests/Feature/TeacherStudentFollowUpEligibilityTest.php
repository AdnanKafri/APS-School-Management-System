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
