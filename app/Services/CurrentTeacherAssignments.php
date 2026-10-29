<?php

namespace App\Services;

use App\Lesson_room_teacher_lecture_time;
use App\Teacher_room_lesson;
use App\TeacherAssignmentPeriod;
use App\Term_year;
use App\Year;
use Illuminate\Support\Facades\DB;

class CurrentTeacherAssignments
{
    public function year()
    {
        return Year::where('current_year', 1)->first();
    }

    public function term($year = null)
    {
        $year = $year ?: $this->year();
        return $year ? Term_year::where('year_id', $year->id)->where('current_term', 1)->first() : null;
    }

    public function schedule($teacherId = null, $roomId = null, $lessonId = null)
    {
        $year = $this->year();
        $term = $this->term($year);
        $query = Lesson_room_teacher_lecture_time::query();
        if (!$year || !$term) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('lesson_room_teacher_lecture_time.year_id', $year->id)
            ->where('lesson_room_teacher_lecture_time.term_id', $term->id)
            ->whereHas('room', function ($q) use ($year) { $q->where('year_id', $year->id); })
            ->whereHas('teacher', function ($q) { $q->where('active', 0); })
            ->whereHas('day')
            ->whereHas('lesson', function ($q) {
                $q->whereExists(function ($r) {
                    $r->select(DB::raw(1))->from('rooms as assignment_room')
                        ->whereColumn('assignment_room.id', 'lesson_room_teacher_lecture_time.room_id')
                        ->whereColumn('assignment_room.class_id', 'lessons.class_id');
                });
            })
            ->whereHas('lecture_time', function ($q) {
                $q->where('type', 1)
                    ->whereColumn('lecture_times.room_id', 'lesson_room_teacher_lecture_time.room_id')
                    ->whereColumn('lecture_times.start_time', '<', 'lecture_times.end_time');
            })
            ->when($teacherId !== null, function ($q) use ($teacherId) { $q->where('lesson_room_teacher_lecture_time.teacher_id', $teacherId); })
            ->when($roomId !== null, function ($q) use ($roomId) { $q->where('lesson_room_teacher_lecture_time.room_id', $roomId); })
            ->when($lessonId !== null, function ($q) use ($lessonId) { $q->where('lesson_room_teacher_lecture_time.lesson_id', $lessonId); });
    }

    public function has($teacherId, $roomId, $lessonId = null)
    {
        return $this->schedule($teacherId, $roomId, $lessonId)->exists();
    }

    public function restrict($query)
    {
        $schedule = $this->schedule()->select(DB::raw(1))
            ->whereColumn('lesson_room_teacher_lecture_time.teacher_id', 'teacher_room_lesson.teacher_id')
            ->whereColumn('lesson_room_teacher_lecture_time.room_id', 'teacher_room_lesson.room_id')
            ->whereColumn('lesson_room_teacher_lecture_time.lesson_id', 'teacher_room_lesson.lesson_id')
            ->whereColumn('lesson_room_teacher_lecture_time.year_id', 'teacher_room_lesson.year_id')
            ->whereExists(function ($room) {
                $room->select(DB::raw(1))->from('rooms as projection_room')
                    ->whereColumn('projection_room.id', 'teacher_room_lesson.room_id')
                    ->whereColumn('projection_room.class_id', 'teacher_room_lesson.class_id');
            });
        $query->getQuery()->addWhereExistsQuery($schedule->toBase());
        return $query;
    }

    // Annual pivots remain as historical references. Only periods are retired.
    public function synchronize($roomId = null)
    {
        return DB::transaction(function () use ($roomId) {
            $year = Year::where('current_year', 1)->lockForUpdate()->first();
            if (!$year) {
                return;
            }
            $pairs = $this->schedule(null, $roomId)->with('room')->get()
                ->unique(function ($row) { return $row->teacher_id.':'.$row->room_id.':'.$row->lesson_id; });
            $assignments = Teacher_room_lesson::where('year_id', $year->id)
                ->when($roomId !== null, function ($q) use ($roomId) { $q->where('room_id', $roomId); })
                ->lockForUpdate()->get();
            $existing = $assignments->keyBy(function ($row) {
                return $row->teacher_id.':'.$row->room_id.':'.$row->lesson_id.':'.$row->class_id;
            });
            $active = [];
            foreach ($pairs as $row) {
                $key = $row->teacher_id.':'.$row->room_id.':'.$row->lesson_id.':'.$row->room->class_id;
                $active[$key] = true;
                if ($existing->has($key)) { continue; }
                $assignments->push(Teacher_room_lesson::create([
                    'teacher_id' => $row->teacher_id, 'year_id' => $year->id,
                    'class_id' => $row->room->class_id,
                    'room_id' => $row->room_id, 'lesson_id' => $row->lesson_id,
                ]));
            }
            $periods = app(TeacherAssignmentPeriodService::class);
            $open = TeacherAssignmentPeriod::where('year_id', $year->id)->whereNull('effective_to')
                ->whereIn('teacher_room_lesson_id', $assignments->pluck('id'))->get()->keyBy('teacher_room_lesson_id');
            foreach ($assignments as $assignment) {
                $key = $assignment->teacher_id.':'.$assignment->room_id.':'.$assignment->lesson_id.':'.$assignment->class_id;
                if (isset($active[$key])) {
                    if (!$open->has($assignment->id)) { $periods->openForAssignment($assignment, null, 'admin_timetable'); }
                } elseif ($open->has($assignment->id)) {
                    $periods->closeForAssignment($assignment);
                }
            }
        }, 3);
    }
}
