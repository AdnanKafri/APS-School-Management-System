<?php

namespace App\Services;

use App\Classe;
use App\Exam_file;
use App\Exam_result;
use App\Exam_result2;
use App\Lesson;
use App\Report_card;
use App\Room;
use App\Room_student;
use App\Student;
use App\Students_mark;
use App\Year;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentTransferService
{
    public function handle(Request $request): RedirectResponse
    {
        $request->validate([
            'student_id' => 'required|integer',
            'class_change_id' => 'required|integer',
            'room_change_id' => 'required|integer',
        ]);

        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return $this->warning('student_transfer.validation.transfer_active_year_missing');
        }

        $student = Student::find($request->student_id);
        if (!$student) {
            return $this->warning('student_transfer.validation.transfer_student_missing');
        }

        $targetClass = Classe::find($request->class_change_id);
        if (!$targetClass) {
            return $this->warning('student_transfer.validation.transfer_class_invalid');
        }

        $targetRoom = Room::find($request->room_change_id);
        if (!$targetRoom || (int) $targetRoom->class_id !== (int) $targetClass->id) {
            return $this->warning('student_transfer.validation.transfer_room_invalid');
        }

        if ((int) $targetRoom->year_id !== (int) $year->id) {
            return $this->warning('student_transfer.validation.transfer_room_year_mismatch');
        }

        $currentEnrollments = Room_student::where('student_id', $student->id)
            ->where('year_id', $year->id)
            ->orderBy('id')
            ->get();

        if ($currentEnrollments->count() !== 1) {
            return $this->warning('student_transfer.validation.transfer_conflicting_enrollment');
        }

        $currentEnrollment = $currentEnrollments->first();
        $currentRoom = Room::find($currentEnrollment->room_id);
        if (!$currentRoom || (int) $currentRoom->year_id !== (int) $year->id) {
            return $this->warning('student_transfer.validation.transfer_requires_current_enrollment');
        }

        if ((int) $currentEnrollment->room_id === (int) $targetRoom->id) {
            return $this->warning('student_transfer.notifications.transfer_no_change');
        }

        $currentMarks = Students_mark::where('student_id', $student->id)
            ->where('year_id', $year->id)
            ->orderBy('id')
            ->get();

        if ($currentMarks->count() > 1) {
            return $this->warning('student_transfer.validation.transfer_conflicting_marks');
        }

        $currentReportCards = Report_card::where('student_id', $student->id)
            ->where('year_id', $year->id)
            ->orderBy('id')
            ->get();

        if ($currentReportCards->count() > 1) {
            return $this->warning('student_transfer.validation.transfer_conflicting_report_card');
        }

        $currentMark = $currentMarks->first();
        $currentReportCard = $currentReportCards->first();
        $currentClassId = (int) $currentRoom->class_id;
        $targetClassId = (int) $targetClass->id;
        $hasRoomBoundAcademicActivity = $this->hasRoomBoundAcademicActivity($student->id, (int) $currentRoom->id);

        if ($currentClassId !== $targetClassId && $hasRoomBoundAcademicActivity) {
            return $this->warning('student_transfer.validation.transfer_existing_assessments');
        }

        try {
            DB::transaction(function () use (
                $request,
                $student,
                $year,
                $targetRoom,
                $targetClassId,
                $currentClassId,
                $currentEnrollment,
                $currentMark,
                $currentReportCard,
                $currentRoom,
                $hasRoomBoundAcademicActivity
            ) {
                if ($currentClassId === $targetClassId) {
                    $this->applySameClassRoomTransfer(
                        $student->id,
                        (int) $currentRoom->id,
                        $currentEnrollment,
                        $currentMark,
                        $currentReportCard,
                        $targetRoom,
                        $targetClassId,
                        $hasRoomBoundAcademicActivity
                    );

                    return;
                }

                DB::table('student_transfer_histories')->insert([
                    'student_id' => $student->id,
                    'user_id' => optional($student->user)->id,
                    'year_id' => $year->id,
                    'from_class_id' => $currentClassId,
                    'from_room_id' => $currentRoom->id,
                    'to_class_id' => $targetClassId,
                    'to_room_id' => $targetRoom->id,
                    'previous_room_student_id' => $currentEnrollment->id,
                    'previous_students_mark_id' => optional($currentMark)->id,
                    'previous_report_card_id' => optional($currentReportCard)->id,
                    'previous_room_student_snapshot' => json_encode($currentEnrollment->toArray(), JSON_UNESCAPED_UNICODE),
                    'previous_students_mark_snapshot' => $currentMark ? json_encode($currentMark->toArray(), JSON_UNESCAPED_UNICODE) : null,
                    'previous_report_card_snapshot' => $currentReportCard ? json_encode($currentReportCard->toArray(), JSON_UNESCAPED_UNICODE) : null,
                    'transferred_by_user_id' => optional(auth()->user())->id,
                    'transfer_type' => 'cross_grade_current_year',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $currentEnrollment->room_id = $targetRoom->id;
                $currentEnrollment->save();

                $markPayload = $this->buildStudentMarkPayload($student, $targetClassId, $targetRoom->id, $year->id, $request);

                if ($currentMark) {
                    foreach ($markPayload as $field => $value) {
                        $currentMark->{$field} = $value;
                    }
                    $currentMark->save();
                } else {
                    Students_mark::create($markPayload);
                }

                if ($currentReportCard) {
                    $this->resetStudentReportCard($currentReportCard, $targetRoom->id, $year->id, $student->id, $targetClassId);
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->warning('student_transfer.notifications.transfer_failed');
        }

        if ($currentClassId === $targetClassId) {
            return redirect()->back()->with('success', __('student_transfer.notifications.room_updated'));
        }

        return redirect()->back()->with('success', __('student_transfer.notifications.transferred'));
    }

    private function applySameClassRoomTransfer(
        int $studentId,
        int $currentRoomId,
        Room_student $currentEnrollment,
        ?Students_mark $currentMark,
        ?Report_card $currentReportCard,
        Room $targetRoom,
        int $targetClassId,
        bool $hasRoomBoundAcademicActivity
    ): void {
        $currentEnrollment->room_id = $targetRoom->id;
        $currentEnrollment->save();

        if ($currentMark) {
            $currentMark->room_id = $targetRoom->id;
            $currentMark->save();
        }

        if ($currentReportCard) {
            $currentReportCard->room_id = $targetRoom->id;
            $currentReportCard->class = $targetClassId;
            $currentReportCard->save();
        }

        if ($hasRoomBoundAcademicActivity) {
            Exam_result::where('user_id', $studentId)
                ->where('room_id', $currentRoomId)
                ->update(['room_id' => $targetRoom->id, 'class_id' => $targetClassId]);

            Exam_result2::where('user_id', $studentId)
                ->where('room_id', $currentRoomId)
                ->update(['room_id' => $targetRoom->id, 'class_id' => $targetClassId]);

            DB::table('student_lesson_teacher_room_term_exam')
                ->where('student_id', $studentId)
                ->where('room_id', $currentRoomId)
                ->update(['room_id' => $targetRoom->id]);

            Exam_file::where('student_id', $studentId)
                ->where('room_id', $currentRoomId)
                ->update(['room_id' => $targetRoom->id, 'class_id' => $targetClassId]);
        }
    }

    private function buildStudentMarkPayload(Student $student, int $classId, int $roomId, int $yearId, Request $request): array
    {
        $lessons = Lesson::where('class_id', $classId)->get();

        $mark = [];
        $mark2 = [];
        $result1 = [];
        $result2 = [];
        $result = [];

        foreach ($lessons as $lesson) {
            $mark[$lesson->id] = [
                'oral' => $request->oral,
                'homework' => $request->homework,
                'activities' => $request->activities,
                'quize' => $request->quize,
                'exam' => $request->exam,
            ];

            $mark2[$lesson->id] = [
                'oral' => $request->oral,
                'homework' => $request->homework,
                'activities' => $request->activities,
                'quize' => $request->quize,
                'exam' => $request->exam,
            ];

            $result1[$lesson->id] = [
                'term1_quizes' => null,
                'term1_exam' => null,
                'term1_result' => null,
            ];

            $result2[$lesson->id] = [
                'term2_quizes' => null,
                'term2_exam' => null,
                'term2_result' => null,
            ];

            $result[$lesson->id] = [
                'year_result' => null,
            ];
        }

        $languageFilter = (string) $student->lang === '0' ? '1' : ((string) $student->lang === '1' ? '0' : null);
        if ($languageFilter !== null) {
            foreach (Lesson::where('class_id', $classId)->where('lang', $languageFilter)->get() as $lesson) {
                unset($mark[$lesson->id], $mark2[$lesson->id], $result1[$lesson->id], $result2[$lesson->id], $result[$lesson->id]);
            }
        }

        $religionFilter = (string) $student->religion === '0' ? '1' : ((string) $student->religion === '1' ? '0' : null);
        if ($religionFilter !== null) {
            foreach (Lesson::where('class_id', $classId)->where('religion', $religionFilter)->get() as $lesson) {
                unset($mark[$lesson->id], $mark2[$lesson->id], $result1[$lesson->id], $result2[$lesson->id], $result[$lesson->id]);
            }
        }

        return [
            'student_id' => $student->id,
            'room_id' => $roomId,
            'year_id' => $yearId,
            'mark' => json_encode((object) $mark, JSON_UNESCAPED_UNICODE),
            'mark2' => json_encode((object) $mark2, JSON_UNESCAPED_UNICODE),
            'result1' => json_encode((object) $result1, JSON_UNESCAPED_UNICODE),
            'result2' => json_encode((object) $result2, JSON_UNESCAPED_UNICODE),
            'result' => json_encode((object) $result, JSON_UNESCAPED_UNICODE),
            'term_result' => json_encode(['term1' => 0, 'term2' => 0], JSON_UNESCAPED_UNICODE),
            'year_result' => 0,
            'status' => '1',
            'adjustable' => 0,
            'lang' => (string) $student->lang,
            'religion' => (string) $student->religion,
            'estimation' => null,
            'estimation1' => null,
            'estimation2' => null,
            'worke_degree' => null,
            'notes' => null,
            'key' => 0,
        ];
    }

    private function resetStudentReportCard(Report_card $reportCard, int $roomId, int $yearId, int $studentId, int $classId): void
    {
        $teacherNotes = ['term1' => null, 'term2' => null];
        $studentAttendance = ['term1' => null, 'term2' => null];
        $actualAttendance = ['term1' => null, 'term2' => null];
        $justifiedAbsence = ['term1' => null, 'term2' => null];
        $unjustifiedAbsence = ['term1' => null, 'term2' => null];

        $reportCard->room_id = $roomId;
        $reportCard->year_id = $yearId;
        $reportCard->student_id = $studentId;
        $reportCard->class = $classId;
        $reportCard->teacher = null;
        $reportCard->teacher_name = null;
        $reportCard->teacher_notes = json_encode($teacherNotes, JSON_UNESCAPED_UNICODE);
        $reportCard->manager_notes = null;
        $reportCard->parent_notes = null;
        $reportCard->final_result = 1;
        $reportCard->student_attendance = json_encode($studentAttendance, JSON_UNESCAPED_UNICODE);
        $reportCard->actual_attendance = json_encode($actualAttendance, JSON_UNESCAPED_UNICODE);
        $reportCard->justified_absence = json_encode($justifiedAbsence, JSON_UNESCAPED_UNICODE);
        $reportCard->unjustified_absence = json_encode($unjustifiedAbsence, JSON_UNESCAPED_UNICODE);
        $reportCard->save();
    }

    private function warning(string $translationKey): RedirectResponse
    {
        return redirect()->back()->with('warning', __($translationKey));
    }

    private function hasRoomBoundAcademicActivity(int $studentId, int $roomId): bool
    {
        return Exam_result::where('user_id', $studentId)->where('room_id', $roomId)->exists()
            || Exam_result2::where('user_id', $studentId)->where('room_id', $roomId)->exists()
            || DB::table('student_lesson_teacher_room_term_exam')->where('student_id', $studentId)->where('room_id', $roomId)->exists()
            || Exam_file::where('student_id', $studentId)->where('room_id', $roomId)->exists();
    }
}
