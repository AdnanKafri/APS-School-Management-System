<?php

namespace App\Services;

use App\Exams2;
use App\Room;
use App\Term_year;
use App\Lesson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/** Explicit, append-only modern assessment identity. No name/group inference. */
class AssessmentEquivalenceService
{
    public function createdTogether(array $examIds)
    {
        if (count($examIds) > 1 && \Illuminate\Support\Facades\Schema::hasTable('assessment_equivalence_members')) {
            return $this->verify($examIds, 'Explicit multi-section assessment creation');
        }
    }

    public function verify(array $examIds, $evidence)
    {
        abort_unless(auth()->check() && (int) auth()->user()->type === 2
            && auth()->user()->can('student_marks'), 403);
        if (count($examIds) < 2 || count(array_unique($examIds)) !== count($examIds)
            || !is_string($evidence) || trim($evidence) === '') {
            AssessmentResultSafety::reject('context_invalid');
        }
        return DB::transaction(function () use ($examIds, $evidence) {
            $exams = Exams2::whereIn('id', $examIds)->orderBy('id')->lockForUpdate()->get();
            if ($exams->count() !== count($examIds)
                || DB::table('assessment_equivalence_members')->whereIn('exam_id', $examIds)->exists()) {
                AssessmentResultSafety::reject('ambiguous_result');
            }
            $earned = \App\Exam_result2::whereIn('exam_id', $examIds)->whereNotNull('result')->get()
                ->filter(function ($row) { return trim((string) $row->result) !== ''; });
            if ($earned->groupBy('user_id')->contains(function ($rows) { return $rows->count() > 1; })) {
                AssessmentResultSafety::reject('ambiguous_result');
            }
            $identity = (string) Str::uuid();
            $expected = null;
            $rooms = [];
            foreach ($exams as $exam) {
                $context = $this->context($exam);
                if (($expected !== null && $context !== $expected) || in_array($exam->room_id, $rooms)) {
                    AssessmentResultSafety::reject('context_invalid');
                }
                $expected = $context;
                $rooms[] = $exam->room_id;
                DB::table('assessment_equivalence_members')->insert(array_merge($context, [
                    'identity' => $identity, 'exam_id' => $exam->id, 'room_id' => $exam->room_id,
                    'verified_by' => auth()->id(), 'evidence' => trim($evidence), 'created_at' => now(),
                ]));
            }
            return $identity;
        }, 3);
    }

    public function context(Exams2 $exam)
    {
        $room = Room::find($exam->room_id);
        $term = Term_year::find($exam->term_id);
        $maximum = GradebookReadService::number($exam->mark);
        if (!$room || !$term || (int) $room->year_id !== (int) $term->year_id
            || (int) $room->class_id !== (int) $exam->class_id
            || !Lesson::whereKey($exam->lesson_id)->where('class_id', $exam->class_id)->exists()
            || !in_array((int) $exam->type, [1, 2], true)
            || strpos((string) $exam->name, 'Dynamic_Section_') === 0
            || $maximum === null || $maximum <= 0 || $maximum > 99999999999.9999
            || round($maximum, 4) !== $maximum) {
            AssessmentResultSafety::reject('context_invalid');
        }
        return ['year_id' => (int) $room->year_id, 'term_id' => (int) $term->id,
            'class_id' => (int) $room->class_id, 'lesson_id' => (int) $exam->lesson_id,
            'type' => (int) $exam->type, 'maximum' => $maximum];
    }
}
