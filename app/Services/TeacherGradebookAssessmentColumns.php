<?php

namespace App\Services;

use App\Exams2;
use App\Lesson;
use App\Room;
use App\Term_year;

/** Read-only presentation of original occurrences, never a mark-entry policy. */
class TeacherGradebookAssessmentColumns
{
    public function forContext(array $gradebook, Room $room, Lesson $subject, Term_year $term)
    {
        abort_unless((int) $room->year_id === (int) $term->year_id
            && (int) $subject->class_id === (int) $room->class_id, 422, __('gradebook.context_invalid'));
        $occurrences = $gradebook['assessments']->filter(function ($assessment) use ($room, $subject, $term) {
            return $assessment['table'] === 'exams2' && !is_numeric($assessment['source'])
                && (int) $assessment['year_id'] === (int) $room->year_id
                && (int) $assessment['class_id'] === (int) $room->class_id
                && (int) $assessment['room_id'] === (int) $room->id
                && (int) $assessment['lesson_id'] === (int) $subject->id
                && (int) $assessment['term_id'] === (int) $term->id;
        });
        // One batch, not a definition lookup for every student or column.
        $definitions = Exams2::leftJoin('users as assessment_creator','assessment_creator.id','=','exams2.user_id')
            ->select('exams2.*','assessment_creator.type as creator_type')->whereIn('exams2.id', $occurrences->pluck('id'))
            ->where('exams2.room_id', $room->id)->where('exams2.class_id', $room->class_id)
            ->where('exams2.lesson_id', $subject->id)->where('exams2.term_id', $term->id)
            ->whereIn('exams2.type', [1, 2])->get()->keyBy('id');
        return $occurrences->filter(function ($assessment) use ($definitions) {
            return $definitions->has($assessment['id']);
        })->map(function ($assessment) use ($definitions) {
            $definition = $definitions->get($assessment['id']);
            // Keep original/result/continuity identities and values from the shared reader.
            $state = app(AssessmentEntryWindow::class)->state($definition,$definition->creator_type ?: -1);
            $assessment['window'] = $state['window'];
            $assessment['entry_allowed'] = $state['allowed'];
            $assessment['entry_reason'] = $state['reason'];
            $assessment['duration'] = $definition->period;
            $assessment['is_file'] = $definition->is_file;
            $assessment['has_traditional'] = $definition->has_traditional;
            $assessment['group'] = $definition->groupe;
            return $assessment;
        })->values();
    }

}
