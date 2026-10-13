<?php

namespace App\Services;

use App\Classe;
use App\Room;
use App\Room_student;
use App\Student;
use App\StudentAcademicPlacement;
use App\StudentFollowUp;
use App\StudentFollowUpEditAudit;
use App\TeacherAssignmentPeriod;
use App\Teacher_room_lesson;
use App\Term_year;
use App\Year;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class StudentFollowUpService
{
    public function schoolNow()
    {
        return Carbon::now('Asia/Damascus');
    }

    public function activeYearOrFail()
    {
        $year = Year::where('current_year', 1)->first();
        if (!$year) {
            throw ValidationException::withMessages([
                'year' => [__('student_follow_up.errors.no_active_year')],
            ]);
        }

        return $year;
    }

    public function assignmentForTeacherOrFail($assignmentId, $teacherId, Year $year)
    {
        $assignment = Teacher_room_lesson::whereKey($assignmentId)
            ->where('teacher_id', $teacherId)
            ->where('year_id', $year->id)
            ->first();

        if (!$assignment) {
            abort(403, __('student_follow_up.errors.assignment_not_allowed'));
        }

        $room = Room::whereKey($assignment->room_id)
            ->where('year_id', $year->id)
            ->first();

        if (!$room || (int) $room->class_id !== (int) $assignment->class_id) {
            abort(403, __('student_follow_up.errors.assignment_not_allowed'));
        }

        return $assignment;
    }

    public function openAssignmentPeriod(Teacher_room_lesson $assignment, Carbon $at)
    {
        $period = TeacherAssignmentPeriod::where('teacher_room_lesson_id', $assignment->id)
            ->where('teacher_id', $assignment->teacher_id)
            ->where('lesson_id', $assignment->lesson_id)
            ->where('year_id', $assignment->year_id)
            ->where('room_id', $assignment->room_id)
            ->where('class_id', $assignment->class_id)
            ->where('effective_from', '<=', $at)
            ->where(function ($query) use ($at) {
                $query->whereNull('effective_to')->orWhere('effective_to', '>', $at);
            })
            ->first();

        if (!$period) {
            abort(403, __('student_follow_up.errors.assignment_not_allowed'));
        }

        return $period;
    }

    public function eligibleStudentsQuery(Teacher_room_lesson $assignment, Year $year, Carbon $at)
    {
        $atValue = $at->format('Y-m-d H:i:s');

        return Student::operational()
            ->whereExists(function ($query) use ($assignment, $year) {
                $query->select(DB::raw(1))
                    ->from('room_student')
                    ->whereColumn('room_student.student_id', 'students.id')
                    ->where('room_student.room_id', $assignment->room_id)
                    ->where('room_student.year_id', $year->id);
            })
            ->where(function ($query) use ($assignment, $year, $atValue) {
                $query->whereExists(function ($placement) use ($assignment, $year, $atValue) {
                    $placement->select(DB::raw(1))->from('student_academic_placements as p')
                        ->whereColumn('p.student_id', 'students.id')
                        ->where('p.year_id', $year->id)
                        ->where('p.class_id', $assignment->class_id)
                        ->where('p.room_id', $assignment->room_id)
                        ->where('p.status', StudentAcademicPlacement::STATUS_ACTIVE)
                        ->where('p.effective_from', '<=', $atValue)
                        ->where(function ($period) use ($atValue) {
                            $period->whereNull('p.effective_to')->orWhere('p.effective_to', '>', $atValue);
                        });
                })->orWhereExists(function ($placement) use ($assignment, $year, $atValue) {
                    // Legacy same-class section edits updated room_student but left the creation placement behind.
                    $placement->select(DB::raw(1))->from('student_academic_placements as p')
                        ->join('room_student as enrollment', function ($join) use ($assignment, $year) {
                            $join->on('enrollment.student_id', '=', 'p.student_id')
                                ->where('enrollment.year_id', $year->id)
                                ->where('enrollment.room_id', $assignment->room_id);
                        })
                        ->whereColumn('p.student_id', 'students.id')
                        ->where('p.year_id', $year->id)
                        ->where('p.class_id', $assignment->class_id)
                        ->where('p.room_id', '<>', $assignment->room_id)
                        ->where('p.status', StudentAcademicPlacement::STATUS_ACTIVE)
                        ->where('p.action_source', 'admin_student_creation')
                        ->where('p.reason', 'student_creation')
                        ->whereColumn('enrollment.updated_at', '>', 'p.updated_at')
                        ->whereNotExists(function ($other) use ($assignment, $year) {
                            $other->select(DB::raw(1))->from('room_student as other_enrollment')
                                ->whereColumn('other_enrollment.student_id', 'p.student_id')
                                ->where('other_enrollment.year_id', $year->id)
                                ->where('other_enrollment.room_id', '<>', $assignment->room_id);
                        })
                        ->where('p.effective_from', '<=', $atValue)
                        ->where(function ($period) use ($atValue) {
                            $period->whereNull('p.effective_to')->orWhere('p.effective_to', '>', $atValue);
                        })
                        ->whereNotExists(function ($other) use ($year) {
                            $other->select(DB::raw(1))->from('student_academic_placements as other_placement')
                                ->whereColumn('other_placement.student_id', 'p.student_id')
                                ->whereColumn('other_placement.id', '<>', 'p.id')
                                ->where('other_placement.year_id', $year->id)
                                ->where('other_placement.status', StudentAcademicPlacement::STATUS_ACTIVE);
                        })
                        ->whereNotExists(function ($transfer) use ($year) {
                            $transfer->select(DB::raw(1))->from('student_transfer_histories as transfer')
                                ->whereColumn('transfer.student_id', 'p.student_id')
                                ->where('transfer.year_id', $year->id);
                        });
                });
            });
    }

    public function resolveCreationContext($teacherId, $assignmentId, $studentId)
    {
        $now = $this->schoolNow();
        $year = $this->activeYearOrFail();
        $assignment = $this->assignmentForTeacherOrFail($assignmentId, $teacherId, $year);
        $period = $this->openAssignmentPeriod($assignment, $now);

        $student = Student::find($studentId);
        if (!$student || !$student->isActiveLifecycle()) {
            $this->denyStudent($teacherId, $studentId, $year, $assignment, !$student ? 'student_missing' : 'student_not_operational');
        }

        $enrollment = Room_student::where('student_id', $student->id)
            ->where('room_id', $assignment->room_id)
            ->where('year_id', $year->id)
            ->first();
        if (!$enrollment) {
            $this->denyStudent($teacherId, $studentId, $year, $assignment, 'current_year_enrollment_missing');
        }

        if (!$this->eligibleStudentsQuery($assignment, $year, $now)->whereKey($student->id)->exists()) {
            $this->denyStudent($teacherId, $studentId, $year, $assignment, 'eligibility_context_mismatch');
        }

        $placement = StudentAcademicPlacement::where('student_id', $student->id)
            ->where('year_id', $year->id)
            ->where('class_id', $assignment->class_id)
            ->where('room_id', $assignment->room_id)
            ->where('status', StudentAcademicPlacement::STATUS_ACTIVE)
            ->where('effective_from', '<=', $now)
            ->where(function ($query) use ($now) {
                $query->whereNull('effective_to')->orWhere('effective_to', '>', $now);
            })
            ->orderByDesc('id')
            ->first();
        if (!$placement) {
            Log::warning('Teacher follow-up uses enrollment context with a stale creation placement.', [
                'teacher_id' => (int) $teacherId, 'student_id' => (int) $studentId,
                'year_id' => (int) $year->id, 'assignment_id' => (int) $assignment->id,
            ]);
        }

        $term = Term_year::where('year_id', $year->id)->where('current_term', 1)->first();

        return compact('now', 'year', 'assignment', 'period', 'student', 'placement', 'term');
    }

    private function denyStudent($teacherId, $studentId, Year $year, Teacher_room_lesson $assignment, $condition)
    {
        Log::warning('Teacher student follow-up authorization denied for student context.', [
            'teacher_id' => (int) $teacherId,
            'student_id' => (int) $studentId,
            'year_id' => (int) $year->id,
            'assignment_id' => (int) $assignment->id,
            'condition' => $condition,
        ]);

        abort(403, __('student_follow_up.errors.student_not_allowed'));
    }

    public function create($teacherUserId, $teacherId, $assignmentId, $studentId, array $input)
    {
        return $this->createForContext($teacherUserId, null, 'teacher', $teacherId, $assignmentId, $studentId, $input);
    }

    public function createOnBehalf($adminUserId, $teacherId, $assignmentId, $studentId, array $input)
    {
        return $this->createForContext($adminUserId, $adminUserId, 'admin_on_behalf', $teacherId, $assignmentId, $studentId, $input);
    }

    private function createForContext($createdByUserId, $adminUserId, $createdVia, $teacherId, $assignmentId, $studentId, array $input)
    {
        $context = $this->resolveCreationContext($teacherId, $assignmentId, $studentId);
        $note = $this->normalizeNote($input['note'] ?? null);
        $level = $input['level'] ?? null;
        $this->validateContent($level, $note);

        return DB::transaction(function () use ($createdByUserId, $adminUserId, $createdVia, $context, $level, $note) {
            $now = $context['now'];
            return StudentFollowUp::create([
                'student_id' => $context['student']->id,
                'teacher_id' => $context['assignment']->teacher_id,
                'lesson_id' => $context['assignment']->lesson_id,
                'year_id' => $context['year']->id,
                'term_id' => optional($context['term'])->id,
                'class_id' => $context['assignment']->class_id,
                'room_id' => $context['assignment']->room_id,
                'student_academic_placement_id' => optional($context['placement'])->id,
                'teacher_assignment_period_id' => $context['period']->id,
                'level' => $level,
                'note' => $note,
                'observed_at' => $now,
                'compliance_month' => $now->copy()->startOfMonth()->toDateString(),
                'compliance_half' => $now->day <= 15 ? 1 : 2,
                'created_by_user_id' => $createdByUserId,
                'created_by_admin_user_id' => $adminUserId,
                'created_via' => $createdVia,
            ]);
        });
    }

    public function update(StudentFollowUp $followUp, $teacherUserId, $teacherId, array $input)
    {
        $now = $this->schoolNow();
        if (!$followUp->isEditableBy($teacherId, $now)) {
            abort(403, __('student_follow_up.errors.edit_window_expired'));
        }

        $note = $this->normalizeNote($input['note'] ?? null);
        $level = $input['level'] ?? null;
        $this->validateContent($level, $note);

        return DB::transaction(function () use ($followUp, $teacherUserId, $teacherId, $level, $note, $now) {
            $record = StudentFollowUp::whereKey($followUp->id)->lockForUpdate()->firstOrFail();
            if (!$record->isEditableBy($teacherId, $now)) {
                abort(403, __('student_follow_up.errors.edit_window_expired'));
            }

            StudentFollowUpEditAudit::create([
                'student_follow_up_id' => $record->id,
                'edited_by_user_id' => $teacherUserId,
                'previous_level' => $record->level,
                'previous_note' => $record->note,
                'new_level' => $level,
                'new_note' => $note,
                'edited_at' => $now,
            ]);

            $record->level = $level;
            $record->note = $note;
            $record->last_edited_by_user_id = $teacherUserId;
            $record->edited_at = $now;
            $record->save();

            return $record;
        });
    }

    private function validateContent($level, $note)
    {
        if ($level !== null && $level !== '' && !in_array($level, StudentFollowUp::LEVELS, true)) {
            throw ValidationException::withMessages(['level' => [__('student_follow_up.errors.invalid_level')]]);
        }

        if (($level === null || $level === '') && $note === null) {
            throw ValidationException::withMessages(['content' => [__('student_follow_up.errors.content_required')]]);
        }
    }

    private function normalizeNote($note)
    {
        if ($note === null) {
            return null;
        }

        $note = trim(preg_replace('/\s+/u', ' ', $note));
        if ($note === '') {
            return null;
        }

        // This PHP 7.4 environment does not guarantee mbstring. PCRE's UTF-8
        // matcher keeps the character limit correct without making follow-up
        // entry depend on that extension.
        if (preg_match_all('/./us', $note, $characters) > 1000) {
            throw ValidationException::withMessages(['note' => [__('student_follow_up.errors.note_too_long')]]);
        }

        return $note;
    }
}
