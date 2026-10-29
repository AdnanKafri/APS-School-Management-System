<?php

namespace App\Services;

use App\Exam_result2;
use App\Exams2;
use App\Lesson;
use App\Room;
use App\Student;
use App\Teacher_room_lesson;
use App\Term_year;
use App\Year;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherAssessmentService
{
    public function context(Exams2 $exam, $studentId = null)
    {
        $user = Auth::user();
        abort_unless($user && (int) $user->type === 1, 403);
        $yearQuery = Year::where('current_year', 1);
        if (DB::transactionLevel() > 0) { $yearQuery->lockForUpdate(); }
        $year = $yearQuery->first();
        $term = $year ? Term_year::where('year_id', $year->id)->where('current_term', 1)->first() : null;
        $room = $year ? Room::whereKey($exam->room_id)->where('year_id', $year->id)->first() : null;
        abort_unless($room && $term && (int) $exam->term_id === (int) $term->id
            && (int) $exam->class_id === (int) $room->class_id
            && Lesson::whereKey($exam->lesson_id)->where('class_id', $room->class_id)->exists()
            && app(CurrentTeacherAssignments::class)->has($user->teacher_id, $room->id, $exam->lesson_id), 403);
        if ($studentId !== null) {
            abort_unless(Student::currentMembership($year->id, $room->id)->whereKey($studentId)->exists(), 403);
        }
        return [$year, $term, $room];
    }

    public function save($examId, $studentId, $roomId, $lessonId, $value, $resultId = null)
    {
        return DB::transaction(function () use ($examId, $studentId, $roomId, $lessonId, $value, $resultId) {
            Student::whereKey($studentId)->lockForUpdate()->firstOrFail();
            $exam = Exams2::whereKey($examId)->lockForUpdate()->firstOrFail();
            abort_unless((int) $exam->room_id === (int) $roomId && (int) $exam->lesson_id === (int) $lessonId, 403);
            $this->context($exam, $studentId);
            app(AssessmentContinuityService::class)->assertWritable($exam, $studentId);
            AssessmentResultSafety::validateMark($value, $exam->mark);
            $rows = Exam_result2::where('exam_id', $exam->id)->where('user_id', $studentId)->lockForUpdate()->get();
            if ($rows->count() > 1) {
                AssessmentResultSafety::reject('ambiguous_result');
            }
            $record = $rows->first();
            if ($resultId && (!$record || (int) $resultId !== (int) $record->id)) {
                abort(403);
            }
            if ($record) {
                AssessmentResultSafety::assertResultContext($record, $exam);
            }
            $record = $record ?: new Exam_result2();
            $difference = (float) $exam->mark - (float) $value;
            $medal = $difference == 0 ? '1' : (in_array($difference, [1, 2, 3]) ? '2' : (in_array($difference, [4, 5, 6]) ? '3' : null));
            $record->forceFill([
                'class_id' => $exam->class_id, 'room_id' => $exam->room_id, 'lesson_id' => $exam->lesson_id,
                'exam_id' => $exam->id, 'user_id' => $studentId, 'term_id' => $exam->term_id,
                'result' => $value, 'status' => '1', 'type' => $exam->type, 'medal' => $medal,
                'start_time' => $exam->start_date, 'end_time' => $exam->end_date,
            ])->save();
            return $record;
        }, 3);
    }

    public function participants($examId, $roomId, $lessonId, $classId, $all, array $selected)
    {
        return DB::transaction(function () use ($examId, $roomId, $lessonId, $classId, $all, $selected) {
            $exam = Exams2::whereKey($examId)->lockForUpdate()->firstOrFail();
            [$year, $term, $room] = $this->context($exam);
            abort_unless((int) $roomId === (int) $exam->room_id && (int) $lessonId === (int) $exam->lesson_id
                && (int) $classId === (int) $exam->class_id, 403);
            $current = Student::currentMembership($year->id, $room->id)->orderBy('id')->lockForUpdate()->pluck('students.id');
            $selected = $all ? $current->all() : array_values(array_unique(array_map('intval', $selected)));
            abort_unless(collect($selected)->diff($current)->isEmpty(), 403);
            $records = Exam_result2::where('exam_id', $exam->id)->lockForUpdate()->get();
            if ($records->groupBy('user_id')->contains(function ($rows) { return $rows->count() > 1; })) {
                AssessmentResultSafety::reject('ambiguous_result');
            }
            $removed = $records->whereIn('user_id', $current)->whereNotIn('user_id', $selected);
            foreach ($removed as $record) {
                if (AssessmentResultSafety::hasEarnedData($record)
                    || DB::table('exams_files')->where('exam_id', $exam->id)->where('student_id', $record->user_id)->exists()) {
                    AssessmentResultSafety::reject('participation_retained', 'student');
                }
            }
            foreach ($records as $record) {
                AssessmentResultSafety::assertResultContext($record, $exam);
            }
            foreach ($removed as $record) {
                $record->delete(); // Only unused current-roster placeholders passed the guard.
            }
            $notifications = collect();
            $continuity = app(AssessmentContinuityService::class)->resolve($exam, $selected);
            foreach ($selected as $studentId) {
                if (in_array($continuity[$studentId]['state'] ?? null, ['carried', 'conflict'], true)) {
                    continue; // Keep the original attempt; do not materialize a receiving result.
                }
                if ($records->contains('user_id', $studentId)) {
                    continue;
                }
                $record = new Exam_result2();
                $record->forceFill([
                    'class_id' => $exam->class_id, 'room_id' => $exam->room_id, 'lesson_id' => $exam->lesson_id,
                    'exam_id' => $exam->id, 'user_id' => $studentId, 'term_id' => $exam->term_id,
                    'type' => $exam->type, 'show_result' => $exam->has_traditional == 0 ? 1 : 0,
                ])->save();
                $notification = new \App\Notification();
                $notification->forceFill([
                    'user_id' => Auth::id(), 'student_id' => $studentId, 'lesson_id' => $exam->lesson_id,
                    'room_id' => $exam->room_id, 'title' => (int) $exam->type === 2 ? 'تم اضافة مذاكرة' : 'تم اضافة امتحان',
                    'body' => $exam->name, 'term_id' => $term->id, 'type' => (int) $exam->type === 2 ? 4 : 5,
                ])->save();
                $notifications->push($notification);
            }
            return $notifications;
        }, 3);
    }
}
