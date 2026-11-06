<?php

namespace App\Services;

use App\Lecture;
use App\Lesson;
use App\Room;
use App\Student;
use App\StudentAcademicPlacement;
use App\Term_year;
use App\Year;
use Carbon\Carbon;

class LessonContentAccess
{
    public function teacherLecture($id, $write = true)
    {
        $user = auth()->user();
        abort_unless($user && (string)$user->type === '1' && (int)$user->teacher_id > 0, 403);
        $lecture = Lecture::findOrFail($id);
        $year = Year::where('current_year', 1)->first();
        $room = Room::find($lecture->room_id);
        abort_unless($year && $room && (int)$room->year_id === (int)$year->id
            && (int)$lecture->year_id === (int)$year->id
            && (int)$lecture->class_id === (int)$room->class_id
            && (int)$lecture->teacher_id === (int)$user->teacher_id
            && Lesson::whereKey($lecture->lesson_id)->where('class_id', $room->class_id)->exists()
            && app(CurrentTeacherAssignments::class)->has($user->teacher_id, $room->id, $lecture->lesson_id), 403);
        $term = Term_year::whereKey($lecture->term_id)->where('year_id', $year->id)->first();
        abort_unless($term && (!$write || (int)$term->current_term === 1), 403);
        return $lecture;
    }

    public function contentContext($content, $lecture)
    {
        abort_unless((string)$content->type === '4' && !$content->upload_deleted_at
            && (int)$content->lecture_id === (int)$lecture->id
            && (int)$content->lesson_id === (int)$lecture->lesson_id
            && (int)$content->room_id === (int)$lecture->room_id
            && (int)$content->term_id === (int)$lecture->term_id
            && (int)$content->class_id === (int)$lecture->class_id
            && (int)$content->teacher_id === (int)$lecture->teacher_id, 403);
    }

    public function studentLecture($id, $subjectId, $studentId)
    {
        $user = auth()->user();
        abort_unless($user && (string)$user->type === '0' && (int)$user->student_id === (int)$studentId, 403);
        $lecture = Lecture::findOrFail($id);
        $year = Year::where('current_year', 1)->first();
        abort_unless($year && (int)$lecture->year_id === (int)$year->id
            && (int)$lecture->lesson_id === (int)$subjectId
            && $this->published($lecture)
            && Student::currentMembership($year->id, $lecture->room_id)->whereKey($studentId)->exists(), 403);
        $this->validLecture($lecture);
        return $lecture;
    }

    private function validLecture($lecture)
    {
        abort_unless(Room::whereKey($lecture->room_id)->where('year_id', $lecture->year_id)->where('class_id', $lecture->class_id)->exists()
            && Lesson::whereKey($lecture->lesson_id)->where('class_id', $lecture->class_id)->exists()
            && Term_year::whereKey($lecture->term_id)->where('year_id', $lecture->year_id)->exists(), 403);
    }

    private function published($lecture)
    {
        return (int)$lecture->active === 0 && $lecture->lecture_time && Carbon::parse($lecture->lecture_time, 'Asia/Damascus')->lte(Carbon::now('Asia/Damascus'));
    }

    public function download($content)
    {
        $user = auth()->user();
        abort_unless($user && $content->isPrivateLessonContent() && !$content->upload_deleted_at, 404);
        if ((string)$user->type === '1') {
            $lecture = $this->teacherLecture($content->lecture_id, false);
            $this->contentContext($content, $lecture);
            return;
        }
        abort_unless((string)$user->type === '0' && Student::operational()->whereKey($user->student_id)->exists(), 403);
        $lecture = Lecture::findOrFail($content->lecture_id);
        $this->validLecture($lecture);
        $this->contentContext($content, $lecture);
        $year = Year::where('current_year', 1)->first();
        abort_unless($year && (int)$lecture->year_id <= (int)$year->id && $this->published($lecture), 403);
        if ((int)$lecture->year_id === (int)$year->id && Student::currentMembership($year->id, $lecture->room_id)->whereKey($user->student_id)->exists()) return;
        abort_unless($content->created_at && StudentAcademicPlacement::where('student_id', $user->student_id)
            ->where('year_id', $lecture->year_id)->where('class_id', $lecture->class_id)->where('room_id', $lecture->room_id)
            ->whereIn('status', ['active','closed'])->where('effective_from', '<=', $content->created_at)
            ->where(function ($q) use ($content) { $q->whereNull('effective_to')->orWhere('effective_to', '>', $content->created_at); })->exists(), 403);
    }
}
