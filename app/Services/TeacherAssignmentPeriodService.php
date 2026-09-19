<?php

namespace App\Services;

use App\TeacherAssignmentPeriod;
use App\Teacher_room_lesson;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeacherAssignmentPeriodService
{
    public function openForAssignment(Teacher_room_lesson $assignment, $effectiveFrom = null, $source = 'teacher_room_lesson')
    {
        return DB::transaction(function () use ($assignment, $effectiveFrom, $source) {
            $active = TeacherAssignmentPeriod::where('teacher_room_lesson_id', $assignment->id)
                ->whereNull('effective_to')
                ->lockForUpdate()
                ->first();

            if ($active) {
                return $active;
            }

            return TeacherAssignmentPeriod::create([
                'teacher_room_lesson_id' => $assignment->id,
                'teacher_id' => $assignment->teacher_id,
                'lesson_id' => $assignment->lesson_id,
                'year_id' => $assignment->year_id,
                'class_id' => $assignment->class_id,
                'room_id' => $assignment->room_id,
                'effective_from' => $effectiveFrom ?: $this->schoolNow(),
                'source' => $source,
            ]);
        });
    }

    public function closeForAssignment(Teacher_room_lesson $assignment, $effectiveTo = null)
    {
        return TeacherAssignmentPeriod::where('teacher_room_lesson_id', $assignment->id)
            ->whereNull('effective_to')
            ->update([
                'effective_to' => $effectiveTo ?: $this->schoolNow(),
                'updated_at' => $this->schoolNow(),
            ]);
    }

    public function closeForAssignments($assignments, $effectiveTo = null)
    {
        foreach ($assignments as $assignment) {
            $this->closeForAssignment($assignment, $effectiveTo);
        }
    }

    private function schoolNow()
    {
        return Carbon::now('Asia/Damascus');
    }
}
