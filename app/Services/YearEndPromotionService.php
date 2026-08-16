<?php

namespace App\Services;

use App\Classe;
use App\Lesson;
use App\Report_card;
use App\Room;
use App\Room_student;
use App\Student;
use App\StudentAcademicPlacement;
use App\Students_mark;
use App\Year;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class YearEndPromotionService
{
    public function process(Student $student, Year $sourceYear, Year $targetYear, string $outcome, int $targetClassId, int $targetRoomId): StudentAcademicPlacement
    {
        return DB::transaction(function () use ($student, $sourceYear, $targetYear, $outcome, $targetClassId, $targetRoomId) {
            if ((int) $sourceYear->next_year !== (int) $targetYear->id) {
                throw new RuntimeException('year_end.errors.next_year');
            }

            $sourceEnrollment = Room_student::where('student_id', $student->id)
                ->where('year_id', $sourceYear->id)
                ->lockForUpdate()
                ->get();
            if ($sourceEnrollment->count() !== 1) {
                throw new RuntimeException('year_end.errors.source_enrollment');
            }

            $sourceEnrollment = $sourceEnrollment->first();
            $sourceRoom = Room::where('id', $sourceEnrollment->room_id)
                ->where('year_id', $sourceYear->id)
                ->first();
            if (!$sourceRoom) {
                throw new RuntimeException('year_end.errors.source_section');
            }

            $targetClass = Classe::find($targetClassId);
            $targetRoom = Room::where('id', $targetRoomId)
                ->where('year_id', $targetYear->id)
                ->where('class_id', $targetClassId)
                ->first();
            if (!$targetClass || !$targetRoom) {
                throw new RuntimeException('year_end.errors.target_missing');
            }

            if ($outcome === 'promote') {
                if (!$sourceRoom->classes || !(int) $sourceRoom->classes->next_class) {
                    throw new RuntimeException('year_end.errors.promote_class');
                }
                if ((int) $sourceRoom->classes->next_class !== (int) $targetClassId) {
                    throw new RuntimeException('year_end.errors.promote_class');
                }
            } elseif ($outcome === 'repeat' && (int) $sourceRoom->class_id !== (int) $targetClassId) {
                throw new RuntimeException('year_end.errors.repeat_class');
            } elseif (!in_array($outcome, ['promote', 'repeat', 'manual'], true)) {
                throw new RuntimeException('year_end.errors.outcome');
            }

            $existing = StudentAcademicPlacement::where('student_id', $student->id)
                ->where('year_id', $targetYear->id)
                ->where('status', 'active')
                ->lockForUpdate()
                ->first();
            if ($existing) {
                throw new RuntimeException('year_end.errors.already_prepared');
            }

            $oldPlacement = StudentAcademicPlacement::where('student_id', $student->id)
                ->where('year_id', $sourceYear->id)
                ->where('status', 'active')
                ->where('room_id', $sourceRoom->id)
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();
            if (!$oldPlacement) {
                $oldPlacement = StudentAcademicPlacement::create([
                    'student_id' => $student->id,
                    'year_id' => $sourceYear->id,
                    'class_id' => $sourceRoom->class_id,
                    'room_id' => $sourceRoom->id,
                    'effective_from' => $sourceEnrollment->created_at ?: now(),
                    'status' => 'active',
                    'reason' => 'legacy_sync',
                    'action_source' => 'legacy_room_student',
                ]);
            }

            $oldMark = Students_mark::where('student_id', $student->id)
                ->where('year_id', $sourceYear->id)->where('room_id', $sourceRoom->id)->first();
            $oldReport = Report_card::where('student_id', $student->id)
                ->where('year_id', $sourceYear->id)->where('room_id', $sourceRoom->id)->first();

            $oldPlacement->effective_to = now();
            $oldPlacement->status = 'closed';
            $oldPlacement->save();

            $newPlacement = StudentAcademicPlacement::create([
                'student_id' => $student->id,
                'year_id' => $targetYear->id,
                'class_id' => $targetClassId,
                'room_id' => $targetRoom->id,
                'effective_from' => now(),
                'status' => 'active',
                'reason' => $outcome === 'promote' ? 'year_end_promotion' : ($outcome === 'repeat' ? 'year_end_repeat' : 'year_end_manual'),
                'action_source' => 'admin_year_end',
                'actioned_by' => optional(auth()->user())->id,
            ]);

            DB::table('student_transfer_histories')->insert([
                'student_id' => $student->id,
                'user_id' => optional($student->user)->id,
                'year_id' => $targetYear->id,
                'from_class_id' => $sourceRoom->class_id,
                'from_room_id' => $sourceRoom->id,
                'to_class_id' => $targetClassId,
                'to_room_id' => $targetRoom->id,
                'previous_room_student_id' => $sourceEnrollment->id,
                'previous_students_mark_id' => optional($oldMark)->id,
                'previous_report_card_id' => optional($oldReport)->id,
                'previous_room_student_snapshot' => json_encode($sourceEnrollment->toArray(), JSON_UNESCAPED_UNICODE),
                'previous_students_mark_snapshot' => $oldMark ? json_encode($oldMark->toArray(), JSON_UNESCAPED_UNICODE) : null,
                'previous_report_card_snapshot' => $oldReport ? json_encode($oldReport->toArray(), JSON_UNESCAPED_UNICODE) : null,
                'transferred_by_user_id' => optional(auth()->user())->id,
                'from_placement_id' => $oldPlacement->id,
                'to_placement_id' => $newPlacement->id,
                'transfer_type' => 'year_end_' . $outcome,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $newEnrollment = new Room_student();
            $newEnrollment->student_id = $student->id;
            $newEnrollment->room_id = $targetRoom->id;
            $newEnrollment->year_id = $targetYear->id;
            $newEnrollment->term = null;
            $newEnrollment->save();

            $this->createFreshAcademicScaffolding($student, $targetClassId, $targetRoom->id, $targetYear->id);

            return $newPlacement;
        });
    }

    public function cloneRooms(Year $sourceYear, Year $targetYear): int
    {
        return DB::transaction(function () use ($sourceYear, $targetYear) {
            $created = 0;
            foreach (Room::where('year_id', $sourceYear->id)->orderBy('id')->get() as $sourceRoom) {
                $exists = Room::where('year_id', $targetYear->id)->where('class_id', $sourceRoom->class_id)
                    ->where('name', $sourceRoom->name)->exists();
                if (!$exists) {
                    Room::create(['name' => $sourceRoom->name, 'class_id' => $sourceRoom->class_id, 'year_id' => $targetYear->id]);
                    $created++;
                }
            }
            return $created;
        });
    }

    private function createFreshAcademicScaffolding(Student $student, int $classId, int $roomId, int $yearId): void
    {
        if (!Students_mark::where('student_id', $student->id)->where('room_id', $roomId)->where('year_id', $yearId)->exists()) {
            $empty = [];
            foreach (Lesson::where('class_id', $classId)->get() as $lesson) {
                $empty[$lesson->id] = ['oral' => null, 'homework' => null, 'activities' => null, 'quize' => null, 'exam' => null];
            }
            Students_mark::create([
                'student_id' => $student->id, 'room_id' => $roomId, 'year_id' => $yearId,
                'mark' => json_encode((object) $empty), 'mark2' => json_encode((object) $empty),
                'result1' => json_encode(new \stdClass()), 'result2' => json_encode(new \stdClass()),
                'result' => json_encode(new \stdClass()), 'term_result' => json_encode(['term1' => 0, 'term2' => 0]),
                'year_result' => 0, 'status' => '1', 'adjustable' => 0,
                'lang' => (string) $student->lang, 'religion' => (string) $student->religion,
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
}
