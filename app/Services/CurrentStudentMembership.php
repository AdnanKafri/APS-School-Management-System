<?php

namespace App\Services;

use App\Room;
use App\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CurrentStudentMembership
{
    /**
     * room_student is the operational projection, not an academic archive.
     * A unique effective placement resolves competing legacy enrollment rows.
     * A later same-grade enrollment edit may supersede one stale placement;
     * never infer a cross-grade move or attach new records to that stale row.
     */
    public function constrain($query, $yearId = null, $roomId = null, $requirePlacement = true, Carbon $at = null)
    {
        $at = ($at ?: Carbon::now('Asia/Damascus'))->format('Y-m-d H:i:s');

        return $query->where('students.lifecycle_status', Student::LIFECYCLE_ACTIVE)
            ->whereExists(function ($enrollment) use ($yearId, $roomId, $requirePlacement, $at) {
                $enrollment->select(DB::raw(1))->from('room_student as membership')
                    ->join('rooms as membership_room', function ($join) {
                        $join->on('membership_room.id', '=', 'membership.room_id')
                            ->on('membership_room.year_id', '=', 'membership.year_id');
                    })
                    ->whereColumn('membership.student_id', 'students.id');
                if ($yearId !== null) {
                    $enrollment->where('membership.year_id', $yearId);
                } else {
                    $enrollment->whereIn('membership.year_id', function ($year) {
                        $year->select('id')->from('years')->where('current_year', 1);
                    });
                }
                if ($roomId !== null) {
                    $enrollment->where('membership.room_id', $roomId);
                }

                $enrollment->where(function ($context) use ($requirePlacement, $at) {
                    if (!$requirePlacement) {
                        $context->where(function ($legacy) {
                            $legacy->whereNotExists(function ($placement) {
                                $placement->select(DB::raw(1))->from('student_academic_placements as membership_legacy')
                                    ->whereColumn('membership_legacy.student_id', 'membership.student_id')
                                    ->whereColumn('membership_legacy.year_id', 'membership.year_id')
                                    ->where('membership_legacy.status', 'active');
                            });
                            $this->withoutCompetingEnrollment($legacy);
                        });
                    }
                    $method = $requirePlacement ? 'whereExists' : 'orWhereExists';
                    $context->{$method}(function ($placement) use ($at) {
                        $placement->select(DB::raw(1))->from('student_academic_placements as membership_placement')
                            ->join('rooms as membership_placement_room', function ($join) {
                                $join->on('membership_placement_room.id', '=', 'membership_placement.room_id')
                                    ->on('membership_placement_room.year_id', '=', 'membership_placement.year_id')
                                    ->on('membership_placement_room.class_id', '=', 'membership_placement.class_id');
                            })
                            ->whereColumn('membership_placement.student_id', 'membership.student_id')
                            ->whereColumn('membership_placement.year_id', 'membership.year_id')
                            ->whereColumn('membership_placement.class_id', 'membership_room.class_id')
                            ->where('membership_placement.status', 'active')
                            ->where('membership_placement.effective_from', '<=', $at)
                            ->where(function ($period) use ($at) {
                                $period->whereNull('membership_placement.effective_to')
                                    ->orWhere('membership_placement.effective_to', '>', $at);
                            })
                            ->whereNotExists(function ($other) {
                                $other->select(DB::raw(1))->from('student_academic_placements as membership_other')
                                    ->whereColumn('membership_other.student_id', 'membership.student_id')
                                    ->whereColumn('membership_other.year_id', 'membership.year_id')
                                    ->whereColumn('membership_other.id', '<>', 'membership_placement.id')
                                    ->where('membership_other.status', 'active');
                            })
                            ->where(function ($room) {
                                $room->whereColumn('membership_placement.room_id', 'membership.room_id')
                                    ->orWhere(function ($stale) {
                                        $stale->whereColumn('membership.updated_at', '>', 'membership_placement.updated_at');
                                        $this->withoutCompetingEnrollment($stale);
                                        $stale->whereNotExists(function ($transfer) {
                                            $transfer->select(DB::raw(1))->from('student_transfer_histories as membership_transfer')
                                                ->whereColumn('membership_transfer.student_id', 'membership.student_id')
                                                ->whereColumn('membership_transfer.year_id', 'membership.year_id')
                                                ->where(function ($date) {
                                                    $date->whereNull('membership_transfer.created_at')
                                                        ->orWhereColumn('membership_transfer.created_at', '>=', 'membership.updated_at');
                                                });
                                        });
                                    });
                            });
                    });
                });
            });
    }

    private function withoutCompetingEnrollment($query)
    {
        $query->whereNotExists(function ($other) {
            $other->select(DB::raw(1))->from('room_student as membership_other_enrollment')
                ->whereColumn('membership_other_enrollment.student_id', 'membership.student_id')
                ->whereColumn('membership_other_enrollment.year_id', 'membership.year_id')
                ->whereColumn('membership_other_enrollment.room_id', '<>', 'membership.room_id');
        });
    }

    public function studentsQuery($yearId, $roomId = null, $requirePlacement = true, Carbon $at = null)
    {
        return $this->constrain(Student::query(), $yearId, $roomId, $requirePlacement, $at);
    }

    public function roomForStudent($studentId, $yearId)
    {
        if (!$yearId) {
            return null;
        }

        return Room::with('classes')->where('rooms.year_id', $yearId)
            ->whereHas('student', function ($query) use ($studentId, $yearId) {
                $this->constrain($query->where('students.id', $studentId), $yearId, DB::raw('room_student.room_id'));
            })->first();
    }
}
