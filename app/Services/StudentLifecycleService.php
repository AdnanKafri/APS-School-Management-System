<?php

namespace App\Services;

use App\Certificate;
use App\Exam_file;
use App\Exam_result;
use App\Exam_result2;
use App\Exam_result_tester;
use App\Lesson;
use App\Report_card;
use App\Room;
use App\Room_student;
use App\Student;
use App\StudentAcademicPlacement;
use App\StudentLifecycleEvent;
use App\Student_lesson_teacher_room_term_exam;
use App\Students_mark;
use App\Student_schedule_tracer;
use App\User;
use App\Year;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class StudentLifecycleService
{
    /**
     * Archive a student without deleting identity or historical records.
     * The service deliberately does not change the existing delete workflow.
     */
    public function archiveStudent(Student $student, $reason = null, $actionedBy = null)
    {
        return DB::transaction(function () use ($student, $reason, $actionedBy) {
            $now = now();
            $actorId = $actionedBy !== null ? $actionedBy : optional(auth()->user())->id;
            $lockedStudent = Student::whereKey($student->id)->lockForUpdate()->first();

            if (!$lockedStudent) {
                throw new RuntimeException('student_lifecycle.errors.student_missing');
            }
            if (!$lockedStudent->isActiveLifecycle()) {
                throw new RuntimeException('student_lifecycle.errors.invalid_archive_state');
            }

            $user = User::where('student_id', $lockedStudent->id)->lockForUpdate()->first();
            $activeYear = Year::where('current_year', 1)->lockForUpdate()->first();
            $activeEnrollments = collect();
            $activePlacements = collect();

            if ($activeYear) {
                $activeEnrollments = Room_student::where('student_id', $lockedStudent->id)
                    ->where('year_id', $activeYear->id)
                    ->lockForUpdate()
                    ->get();
                $activePlacements = StudentAcademicPlacement::where('student_id', $lockedStudent->id)
                    ->where('year_id', $activeYear->id)
                    ->where('status', StudentAcademicPlacement::STATUS_ACTIVE)
                    ->lockForUpdate()
                    ->get();
            } else {
                $activePlacements = StudentAcademicPlacement::where('student_id', $lockedStudent->id)
                    ->where('status', StudentAcademicPlacement::STATUS_ACTIVE)
                    ->lockForUpdate()
                    ->get();

                if ($activePlacements->isNotEmpty()) {
                    throw new RuntimeException('student_lifecycle.errors.active_year_missing');
                }
            }

            if ($activeEnrollments->count() > 1 || $activePlacements->count() > 1) {
                throw new RuntimeException('student_lifecycle.errors.duplicate_active_placement');
            }

            $currentEnrollment = $activeEnrollments->first();
            $currentPlacement = $activePlacements->first();

            if ($currentEnrollment) {
                $currentRoom = Room::whereKey($currentEnrollment->room_id)->lockForUpdate()->first();
                if (!$currentRoom || !$activeYear || (int) $currentRoom->year_id !== (int) $activeYear->id) {
                    throw new RuntimeException('student_lifecycle.errors.current_enrollment_invalid');
                }

                if ($currentPlacement && (
                    (int) $currentPlacement->room_id !== (int) $currentRoom->id
                    || (int) $currentPlacement->class_id !== (int) $currentRoom->class_id
                )) {
                    throw new RuntimeException('student_lifecycle.errors.placement_enrollment_mismatch');
                }

                // Repair only a missing placement projection so the current
                // academic context is preserved before the enrollment closes.
                if (!$currentPlacement) {
                    $currentPlacement = StudentAcademicPlacement::create([
                        'student_id' => $lockedStudent->id,
                        'year_id' => $activeYear->id,
                        'class_id' => $currentRoom->class_id,
                        'room_id' => $currentRoom->id,
                        'effective_from' => $currentEnrollment->created_at ?: $now,
                        'status' => StudentAcademicPlacement::STATUS_ACTIVE,
                        'reason' => 'legacy_sync',
                        'action_source' => 'student_lifecycle_archive_repair',
                    ]);
                }
            }

            $futurePlacements = $activeYear
                ? StudentAcademicPlacement::where('student_id', $lockedStudent->id)
                    ->whereIn('year_id', $this->configuredFutureYearIds($activeYear))
                    ->where('status', StudentAcademicPlacement::STATUS_ACTIVE)
                    ->lockForUpdate()
                    ->get()
                : collect();
            $futureEnrollments = $activeYear
                ? Room_student::where('student_id', $lockedStudent->id)
                    ->whereIn('year_id', $this->configuredFutureYearIds($activeYear))
                    ->lockForUpdate()
                    ->get()
                : collect();

            if ($activeYear) {
                $futureYearIds = $this->configuredFutureYearIds($activeYear);
                $otherActivePlacements = StudentAcademicPlacement::where('student_id', $lockedStudent->id)
                    ->where('year_id', '!=', $activeYear->id)
                    ->where('status', StudentAcademicPlacement::STATUS_ACTIVE)
                    ->lockForUpdate()
                    ->get();

                if ($otherActivePlacements->contains(function ($placement) use ($futureYearIds) {
                    return !in_array((int) $placement->year_id, $futureYearIds, true);
                })) {
                    throw new RuntimeException('student_lifecycle.errors.unknown_active_placement');
                }

                // A non-current enrollment with a year outside the configured
                // next-year chain cannot be classified safely as future data.
                $unknownFutureEnrollment = Room_student::where('student_id', $lockedStudent->id)
                    ->where('year_id', '>', $activeYear->id)
                    ->whereNotIn('year_id', $futureYearIds)
                    ->lockForUpdate()
                    ->exists();
                if ($unknownFutureEnrollment) {
                    throw new RuntimeException('student_lifecycle.errors.unknown_future_enrollment');
                }
            }

            foreach ($futurePlacements as $futurePlacement) {
                if ($this->hasMeaningfulFutureActivity($lockedStudent->id, $user, $futurePlacement)) {
                    throw new RuntimeException('student_lifecycle.errors.future_activity');
                }
            }

            foreach ($futureEnrollments as $futureEnrollment) {
                $futurePlacement = $futurePlacements->first(function ($placement) use ($futureEnrollment) {
                    return (int) $placement->year_id === (int) $futureEnrollment->year_id
                        && (int) $placement->room_id === (int) $futureEnrollment->room_id;
                });

                if (!$futurePlacement && $this->hasMeaningfulRoomYearActivity(
                    $lockedStudent->id,
                    $user,
                    $futureEnrollment->year_id,
                    $futureEnrollment->room_id
                )) {
                    throw new RuntimeException('student_lifecycle.errors.future_activity');
                }
            }

            $beforeState = $this->stateSnapshot(
                $lockedStudent,
                $user,
                $activeYear,
                $currentEnrollment,
                $currentPlacement,
                $futureEnrollments,
                $futurePlacements
            );

            $cancelledFuturePlacementIds = [];
            foreach ($futurePlacements as $futurePlacement) {
                $futurePlacement->status = StudentAcademicPlacement::STATUS_CANCELLED;
                $futurePlacement->effective_to = $now;
                $futurePlacement->reason = 'archive_cancelled';
                $futurePlacement->action_source = 'student_lifecycle_archive';
                $futurePlacement->actioned_by = $actorId;
                $futurePlacement->save();
                $cancelledFuturePlacementIds[] = $futurePlacement->id;
            }

            if ($futureEnrollments->isNotEmpty()) {
                Room_student::whereIn('id', $futureEnrollments->pluck('id')->all())->delete();
            }

            if ($currentEnrollment) {
                $currentEnrollment->delete();
            }

            if ($currentPlacement) {
                $currentPlacement->status = StudentAcademicPlacement::STATUS_WITHDRAWN;
                $currentPlacement->effective_to = $now;
                $currentPlacement->reason = 'withdrawal';
                $currentPlacement->action_source = 'student_lifecycle_archive';
                $currentPlacement->actioned_by = $actorId;
                $currentPlacement->save();
            }

            $previousBusId = $lockedStudent->bus_id;
            $lockedStudent->lifecycle_status = Student::LIFECYCLE_ARCHIVED;
            $lockedStudent->archived_at = $now;
            $lockedStudent->archived_by = $actorId;
            $lockedStudent->archive_reason = $reason;
            $lockedStudent->bus_id = null;
            $lockedStudent->save();

            // Clearing remember_token preserves the account and password but
            // prevents an old remembered session from remaining operational.
            if ($user) {
                $user->remember_token = null;
                $user->save();
            }

            $afterState = [
                'student' => [
                    'id' => $lockedStudent->id,
                    'lifecycle_status' => $lockedStudent->lifecycle_status,
                    'archived_at' => optional($lockedStudent->archived_at)->toDateTimeString(),
                    'archived_by' => $lockedStudent->archived_by,
                    'bus_id' => $lockedStudent->bus_id,
                ],
                'account' => $user ? ['id' => $user->id, 'student_id' => $user->student_id] : null,
                'withdrawn_placement_id' => optional($currentPlacement)->id,
                'cancelled_future_placement_ids' => $cancelledFuturePlacementIds,
                'current_enrollment_removed' => (bool) $currentEnrollment,
                'previous_bus_id' => $previousBusId,
            ];

            return StudentLifecycleEvent::create([
                'student_id' => $lockedStudent->id,
                'event_type' => StudentLifecycleEvent::EVENT_ARCHIVED,
                'occurred_at' => $now,
                'actioned_by' => $actorId,
                'reason' => $reason,
                'year_id' => optional($activeYear)->id,
                'placement_id' => optional($currentPlacement)->id,
                'room_student_id' => optional($currentEnrollment)->id,
                'class_id' => optional($currentPlacement)->class_id,
                'room_id' => optional($currentPlacement)->room_id,
                'bus_id' => $previousBusId,
                'before_state' => json_encode($beforeState, JSON_UNESCAPED_UNICODE),
                'after_state' => json_encode($afterState, JSON_UNESCAPED_UNICODE),
            ]);
        });
    }

    /**
     * Restore into an explicitly selected year/class/room. The old room is
     * never reopened automatically.
     */
    public function restoreStudent(Student $student, $yearId, $classId, $roomId, $reason = null, $actionedBy = null)
    {
        return DB::transaction(function () use ($student, $yearId, $classId, $roomId, $reason, $actionedBy) {
            $now = now();
            $actorId = $actionedBy !== null ? $actionedBy : optional(auth()->user())->id;
            $lockedStudent = Student::whereKey($student->id)->lockForUpdate()->first();

            if (!$lockedStudent) {
                throw new RuntimeException('student_lifecycle.errors.student_missing');
            }
            if (!$lockedStudent->isArchived()) {
                throw new RuntimeException('student_lifecycle.errors.invalid_restore_state');
            }

            $user = User::where('student_id', $lockedStudent->id)->lockForUpdate()->first();
            if (!$user) {
                throw new RuntimeException('student_lifecycle.errors.account_missing');
            }

            $targetYear = Year::whereKey($yearId)->lockForUpdate()->first();
            $targetClass = \App\Classe::whereKey($classId)->lockForUpdate()->first();
            $targetRoom = Room::whereKey($roomId)->lockForUpdate()->first();
            if (!$targetYear || !$targetClass || !$targetRoom) {
                throw new RuntimeException('student_lifecycle.errors.restore_context_invalid');
            }

            $activeYear = Year::where('current_year', 1)->first();
            if ($activeYear && (int) $targetYear->id < (int) $activeYear->id) {
                throw new RuntimeException('student_lifecycle.errors.restore_past_year');
            }
            if ((int) $targetRoom->class_id !== (int) $targetClass->id
                || (int) $targetRoom->year_id !== (int) $targetYear->id) {
                throw new RuntimeException('student_lifecycle.errors.restore_context_invalid');
            }

            $existingEnrollments = Room_student::where('student_id', $lockedStudent->id)
                ->where('year_id', $targetYear->id)
                ->lockForUpdate()
                ->get();
            $existingActivePlacements = StudentAcademicPlacement::where('student_id', $lockedStudent->id)
                ->where('status', StudentAcademicPlacement::STATUS_ACTIVE)
                ->lockForUpdate()
                ->get();

            if ($existingEnrollments->isNotEmpty() || $existingActivePlacements->isNotEmpty()) {
                throw new RuntimeException('student_lifecycle.errors.restore_conflict');
            }

            if ($this->hasMeaningfulRoomYearActivity(
                $lockedStudent->id,
                $user,
                $targetYear->id,
                $targetRoom->id
            )) {
                throw new RuntimeException('student_lifecycle.errors.restore_activity_conflict');
            }

            $beforeState = $this->stateSnapshot($lockedStudent, $user, $targetYear, null, null, collect(), collect());

            $enrollment = new Room_student();
            $enrollment->student_id = $lockedStudent->id;
            $enrollment->room_id = $targetRoom->id;
            $enrollment->year_id = $targetYear->id;
            $enrollment->term = null;
            $enrollment->save();

            $placement = StudentAcademicPlacement::create([
                'student_id' => $lockedStudent->id,
                'year_id' => $targetYear->id,
                'class_id' => $targetClass->id,
                'room_id' => $targetRoom->id,
                'effective_from' => $now,
                'effective_to' => null,
                'status' => StudentAcademicPlacement::STATUS_ACTIVE,
                'reason' => 'restore',
                'action_source' => 'admin_student_restore',
                'actioned_by' => $actorId,
            ]);

            $this->createBlankAcademicScaffolding($lockedStudent, $targetClass->id, $targetRoom->id, $targetYear->id);

            $lockedStudent->lifecycle_status = Student::LIFECYCLE_ACTIVE;
            $lockedStudent->archived_at = null;
            $lockedStudent->archived_by = null;
            $lockedStudent->archive_reason = null;
            $lockedStudent->save();

            return StudentLifecycleEvent::create([
                'student_id' => $lockedStudent->id,
                'event_type' => StudentLifecycleEvent::EVENT_RESTORED,
                'occurred_at' => $now,
                'actioned_by' => $actorId,
                'reason' => $reason,
                'year_id' => $targetYear->id,
                'placement_id' => $placement->id,
                'room_student_id' => $enrollment->id,
                'class_id' => $targetClass->id,
                'room_id' => $targetRoom->id,
                'bus_id' => null,
                'before_state' => json_encode($beforeState, JSON_UNESCAPED_UNICODE),
                'after_state' => json_encode([
                    'student' => [
                        'id' => $lockedStudent->id,
                        'lifecycle_status' => $lockedStudent->lifecycle_status,
                        'archived_at' => null,
                        'bus_id' => $lockedStudent->bus_id,
                    ],
                    'account' => ['id' => $user->id, 'student_id' => $user->student_id],
                    'placement_id' => $placement->id,
                    'room_student_id' => $enrollment->id,
                ], JSON_UNESCAPED_UNICODE),
            ]);
        });
    }

    private function hasMeaningfulFutureActivity($studentId, $user, StudentAcademicPlacement $placement): bool
    {
        return $this->hasMeaningfulRoomYearActivity($studentId, $user, $placement->year_id, $placement->room_id)
            || ($user && Student_schedule_tracer::where('user_id', $user->id)
                ->where('created_at', '>=', $placement->effective_from)
                ->exists());
    }

    private function configuredFutureYearIds(Year $activeYear): array
    {
        $ids = [];
        $nextId = $activeYear->next_year;
        $visited = [(int) $activeYear->id => true];

        while ($nextId !== null && !isset($visited[(int) $nextId]) && count($ids) < 50) {
            $nextYear = Year::find($nextId);
            if (!$nextYear) {
                break;
            }

            $visited[(int) $nextYear->id] = true;
            $ids[] = (int) $nextYear->id;
            $nextId = $nextYear->next_year;
        }

        return $ids;
    }

    private function hasMeaningfulRoomYearActivity($studentId, $user, $yearId, $roomId): bool
    {
        $marks = Students_mark::where('student_id', $studentId)->where('year_id', $yearId);
        if ($roomId !== null) {
            $marks->where('room_id', $roomId);
        }
        foreach ($marks->get() as $mark) {
            if ($this->hasMeaningfulValue($mark->mark)
                || $this->hasMeaningfulValue($mark->mark2)
                || $this->hasMeaningfulValue($mark->result1)
                || $this->hasMeaningfulValue($mark->result2)
                || $this->hasMeaningfulValue($mark->result)
                || $this->hasMeaningfulValue($mark->term_result)
                || $this->hasMeaningfulValue($mark->year_result)
                || $this->hasMeaningfulValue($mark->estimation)
                || $this->hasMeaningfulValue($mark->estimation1)
                || $this->hasMeaningfulValue($mark->estimation2)) {
                return true;
            }
        }

        $reports = Report_card::where('student_id', $studentId)->where('year_id', $yearId);
        if ($roomId !== null) {
            $reports->where('room_id', $roomId);
        }
        foreach ($reports->get() as $report) {
            foreach (['teacher', 'teacher_notes', 'final_result', 'manager_notes', 'parent_notes', 'actual_attendance', 'student_attendance', 'justified_absence', 'unjustified_absence', 'teacher_name'] as $field) {
                if ($field === 'final_result' && (string) $report->{$field} === '1') {
                    continue;
                }
                if ($this->hasMeaningfulValue($report->{$field})) {
                    return true;
                }
            }
        }

        $roomResults = [
            [Exam_result::class, 'user_id'],
            [Exam_result2::class, 'user_id'],
            [Exam_result_tester::class, 'user_id'],
        ];
        foreach ($roomResults as $definition) {
            $query = $definition[0]::where($definition[1], $studentId);
            if ($roomId !== null) {
                $query->where('room_id', $roomId);
            }
            if ($query->exists()) {
                return true;
            }
        }

        $roomBound = [Exam_file::class, Student_lesson_teacher_room_term_exam::class, Certificate::class];
        foreach ($roomBound as $model) {
            $query = $model::where('student_id', $studentId);
            if ($roomId !== null) {
                $query->where('room_id', $roomId);
            }
            if ($query->exists()) {
                return true;
            }
        }

        return false;
    }

    private function createBlankAcademicScaffolding(Student $student, $classId, $roomId, $yearId): void
    {
        if (!Students_mark::where('student_id', $student->id)->where('room_id', $roomId)->where('year_id', $yearId)->exists()) {
            $empty = [];
            foreach (Lesson::where('class_id', $classId)->get() as $lesson) {
                $empty[$lesson->id] = [
                    'oral' => null,
                    'homework' => null,
                    'activities' => null,
                    'quize' => null,
                    'exam' => null,
                ];
            }

            Students_mark::create([
                'student_id' => $student->id,
                'room_id' => $roomId,
                'year_id' => $yearId,
                'mark' => json_encode((object) $empty, JSON_UNESCAPED_UNICODE),
                'mark2' => json_encode((object) $empty, JSON_UNESCAPED_UNICODE),
                'result1' => json_encode(new \stdClass()),
                'result2' => json_encode(new \stdClass()),
                'result' => json_encode(new \stdClass()),
                'term_result' => json_encode(['term1' => 0, 'term2' => 0]),
                'year_result' => 0,
                'status' => '1',
                'adjustable' => 0,
                'lang' => (string) $student->lang,
                'religion' => (string) $student->religion,
            ]);
        }

        if (!Report_card::where('student_id', $student->id)->where('room_id', $roomId)->where('year_id', $yearId)->exists()) {
            $report = new Report_card();
            $report->student_id = $student->id;
            $report->room_id = $roomId;
            $report->year_id = $yearId;
            $report->class = $classId;
            $report->final_result = 1;
            $report->teacher_notes = json_encode(['term1' => null, 'term2' => null]);
            $report->student_attendance = json_encode(['term1' => null, 'term2' => null]);
            $report->actual_attendance = json_encode(['term1' => null, 'term2' => null]);
            $report->justified_absence = json_encode(['term1' => null, 'term2' => null]);
            $report->unjustified_absence = json_encode(['term1' => null, 'term2' => null]);
            $report->save();
        }
    }

    private function hasMeaningfulValue($value): bool
    {
        if ($value === null || $value === '' || $value === false || $value === 0 || $value === '0') {
            return false;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $this->hasMeaningfulValue($decoded);
            }
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                if ($this->hasMeaningfulValue($item)) {
                    return true;
                }
            }
            return false;
        }

        return true;
    }

    private function stateSnapshot($student, $user, $year, $enrollment, $placement, $futureEnrollments, $futurePlacements): array
    {
        return [
            'student' => [
                'id' => $student->id,
                'lifecycle_status' => $student->lifecycle_status,
                'archived_at' => optional($student->archived_at)->toDateTimeString(),
                'archived_by' => $student->archived_by,
                'archive_reason' => $student->archive_reason,
                'bus_id' => $student->bus_id,
            ],
            'account' => $user ? ['id' => $user->id, 'student_id' => $user->student_id, 'email' => $user->email] : null,
            'year_id' => optional($year)->id,
            'enrollment' => $enrollment ? $enrollment->toArray() : null,
            'placement' => $placement ? $placement->toArray() : null,
            'future_enrollments' => $futureEnrollments->map(function ($item) {
                return $item->toArray();
            })->values()->all(),
            'future_placements' => $futurePlacements->map(function ($item) {
                return $item->toArray();
            })->values()->all(),
        ];
    }
}
