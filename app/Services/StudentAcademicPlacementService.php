<?php

namespace App\Services;

use App\Room;
use App\Room_student;
use App\StudentAcademicPlacement;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentAcademicPlacementService
{
    /**
     * Create the placement projection for a newly-created legacy enrollment.
     * Existing placement rows are left untouched and are reused when they
     * already describe the same student/year/room.
     */
    public function syncForEnrollment(Room_student $enrollment, string $reason = 'student_creation', string $source = 'admin_student_creation'): StudentAcademicPlacement
    {
        $room = Room::whereKey($enrollment->room_id)
            ->where('year_id', $enrollment->year_id)
            ->first();

        if (!$room) {
            throw (new ModelNotFoundException())->setModel(Room::class, [$enrollment->room_id]);
        }

        $placement = StudentAcademicPlacement::where('student_id', $enrollment->student_id)
            ->where('year_id', $enrollment->year_id)
            ->where('class_id', $room->class_id)
            ->where('room_id', $room->id)
            ->where('status', 'active')
            ->orderByDesc('id')
            ->first();

        if ($placement) {
            return $placement;
        }

        return StudentAcademicPlacement::create([
            'student_id' => $enrollment->student_id,
            'year_id' => $enrollment->year_id,
            'class_id' => $room->class_id,
            'room_id' => $room->id,
            'term_id' => null,
            'effective_from' => $enrollment->created_at ?: now(),
            'effective_to' => null,
            'status' => 'active',
            'reason' => $reason,
            'action_source' => $source,
            'actioned_by' => optional(auth()->user())->id,
        ]);
    }
}
