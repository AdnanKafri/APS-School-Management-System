<?php

namespace App\Services;

use App\Exam_result;
use App\Exam_result2;
use App\Exams2;
use App\Lesson;
use App\Lesson_teacher_room_term_exam;
use App\Room;
use App\Term_year;

/** Read the original results; never materialize or move marks between contexts. */
class GradebookReadService
{
    public static function number($value)
    {
        if ($value === null || !is_scalar($value)) {
            return null;
        }
        $value = trim((string) $value);
        if (!preg_match('/^\d+(?:\.\d+)?$/D', $value)) {
            return null;
        }
        $number = (float) $value;
        return is_finite($number) ? $number : null;
    }

    public static function componentMaximum($component, Lesson $subject)
    {
        $explicit = self::number($component->max_mark ?? null);
        return $explicit !== null ? $explicit : self::number($subject->max_mark) * ($component->weight ?? 0) / 100;
    }

    public function read(Room $room, Lesson $subject, $studentIds, $termIds = null)
    {
        abort_unless((int) $subject->class_id === (int) $room->class_id, 422, __('gradebook.context_invalid'));
        $terms = Term_year::where('year_id', $room->year_id)
            ->when($termIds !== null, function ($q) use ($termIds) { $q->whereIn('id', $termIds); })
            ->orderBy('id')->get();
        $components = GradebookConfigService::getConfig($subject->id, $room->year_id);
        $assessments = collect();
        $issues = [];

        $definitions = Exams2::where('room_id', $room->id)->where('class_id', $room->class_id)
            ->where('lesson_id', $subject->id)->whereIn('term_id', $terms->pluck('id'))->orderBy('id')->get();
        $results = Exam_result2::whereIn('exam_id', $definitions->pluck('id'))
            ->whereIn('user_id', $studentIds)->get()->groupBy('exam_id');
        $containerCounts = $definitions->groupBy(function ($definition) {
            return $definition->term_id . ':' . $definition->name;
        })->map->count();
        foreach ($definitions as $definition) {
            // Existing dynamic containers have no separate FK. Resolve their reserved
            // name only inside the exact class/room/lesson/term/type context.
            $dynamic = null;
            if (preg_match('/^Dynamic_Section_(\d+)$/D', (string) $definition->name, $match)) {
                if ((int) $definition->type !== 1 || (int) $match[1] < 100) {
                    $issues[] = 'exams2:' . $definition->id;
                    continue;
                }
                $dynamic = (int) $match[1];
            }
            $source = $dynamic !== null ? $dynamic : ((int) $definition->type === 1 ? 'LEGACY_EXAM' : ((int) $definition->type === 2 ? 'LEGACY_HOMEWORK' : null));
            $assessment = $this->assessment('exams2', $definition, $source,
                $results->get($definition->id, collect()), $terms, $issues);
            foreach (app(AssessmentContinuityService::class)->resolve($definition, $studentIds) as $studentId => $resolved) {
                $assessment['results'][$studentId] = $resolved;
                if ($resolved['state'] === 'conflict') $issues[] = 'exams2:' . $definition->id . ':continuity';
            }
            $assessment['ambiguous_container'] = $dynamic !== null && $containerCounts[$definition->term_id . ':' . $definition->name] > 1;
            if ($assessment['ambiguous_container']) $issues[] = 'exams2:' . $definition->id . ':container';
            $assessments->push($assessment);
        }

        $legacy = Lesson_teacher_room_term_exam::where('room_id', $room->id)
            ->where('lesson_id', $subject->id)->whereIn('term_id', $terms->pluck('id'))->orderBy('id')->get();
        $legacyResults = Exam_result::whereIn('exam_id', $legacy->pluck('id'))
            ->whereIn('user_id', $studentIds)->where('status', '1')->get()->groupBy('exam_id');
        foreach ($legacy as $definition) {
            if (!$legacyResults->has($definition->id)) {
                continue; // Lessons/videos without a confirmed result are not assessments to display.
            }
            $assessments->push($this->assessment('lesson_teacher_room_term_exam', $definition, 'LEGACY_ORAL',
                $legacyResults->get($definition->id, collect()), $terms, $issues));
        }

        $marks = [];
        foreach ($terms as $term) {
            foreach ($studentIds as $studentId) {
                $data = [];
                foreach ($components as $component) {
                    $values = $assessments->filter(function ($assessment) use ($term, $component) {
                        return (int) $assessment['term_id'] === (int) $term->id
                            && empty($assessment['ambiguous_container'])
                            && (string) $assessment['source'] === (string) $component->data_source;
                    })->map(function ($assessment) use ($studentId) {
                        return $assessment['results'][$studentId]['value'] ?? null;
                    })->filter(function ($value) { return $value !== null; });
                    if ($values->isNotEmpty()) {
                        // Preserve the existing Admin/summary rule: quiz/oral average,
                        // final-exam maximum. Percentages are not new scaling rules.
                        $data[$component->id] = round($component->data_source === 'LEGACY_EXAM' ? $values->max() : $values->avg(), 1);
                    }
                }
                $data['total'] = count($data) ? array_sum($data) : null;
                $marks[$studentId][$term->id] = $data;
            }
        }
        $historical = $this->unmappedHistory($room, $subject, $studentIds, $terms);
        return compact('terms', 'components', 'assessments', 'marks', 'issues', 'historical');
    }

    private function unmappedHistory(Room $room, Lesson $subject, $studentIds, $terms)
    {
        if (!\App\Year::whereKey($room->year_id)->where('current_year', 1)->exists()) return collect();
        $current = \App\Student::currentMembership($room->year_id, $room->id)
            ->whereIn('students.id', $studentIds)->pluck('students.id');
        $placements = \Illuminate\Support\Facades\DB::table('student_academic_placements')
            ->whereIn('student_id', $current)->where('year_id', $room->year_id)->where('class_id', $room->class_id)
            ->where('room_id', '<>', $room->id)->where('status', 'closed')
            ->whereColumn('effective_from', '<=', 'effective_to')->where('effective_to', '<=', now())->get();
        if ($placements->isEmpty()) return collect();
        $definitions = Exams2::whereIn('room_id', $placements->pluck('room_id'))->where('class_id', $room->class_id)
            ->whereHas('room', function ($q) use ($room) { $q->where('year_id', $room->year_id)->where('class_id', $room->class_id); })
            ->where('lesson_id', $subject->id)->whereIn('term_id', $terms->pluck('id'))->get()->keyBy('id');
        $members = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('assessment_equivalence_members')) {
            $members = \Illuminate\Support\Facades\DB::table('assessment_equivalence_members')
                ->whereIn('identity', function ($q) use ($room, $subject) {
                    $q->select('identity')->from('assessment_equivalence_members')->where('room_id', $room->id)
                        ->where('lesson_id', $subject->id);
                })->pluck('exam_id');
        }
        $rows = Exam_result2::whereIn('exam_id', $definitions->keys())->whereIn('user_id', $current)
            ->whereNotNull('result')->get();
        $history = collect();
        foreach ($rows as $row) {
            $definition = $definitions[$row->exam_id];
            if ($members->contains($definition->id) || !$placements->contains(function ($p) use ($row, $definition) {
                return (int)$p->student_id === (int)$row->user_id && (int)$p->room_id === (int)$definition->room_id;
            })) continue;
            try { AssessmentResultSafety::assertResultContext($row, $definition); }
            catch (\Illuminate\Validation\ValidationException $e) { continue; }
            $value = self::number($row->result);
            if ($value === null) continue;
            $history->push(['student_id' => $row->user_id, 'name' => $definition->name,
                'exam_id' => $definition->id, 'result_id' => $row->id, 'value' => $value,
                'term' => $terms->firstWhere('id', $definition->term_id)->term,
                'room' => $definition->room_id]);
        }
        return $history;
    }

    private function assessment($table, $definition, $source, $records, $terms, &$issues)
    {
        $values = [];
        foreach ($records->groupBy('user_id') as $studentId => $rows) {
            if ($rows->count() !== 1) {
                $issues[] = $table . ':' . $definition->id . ':duplicate';
                continue;
            }
            $row = $rows->first();
            foreach (['room_id', 'lesson_id', 'term_id', 'class_id'] as $field) {
                if ($row->$field !== null && $definition->$field !== null
                    && (int) $row->$field !== (int) $definition->$field) {
                    $issues[] = $table . ':' . $definition->id . ':context';
                    continue 2;
                }
            }
            $value = self::number($row->result);
            if ($value === null && $row->result !== null && trim((string) $row->result) !== '') {
                $issues[] = $table . ':' . $definition->id . ':value';
            }
            $values[$studentId] = ['result_id' => $row->id, 'value' => $value];
        }
        $component = is_numeric($source) ? GradebookConfigService::getConfig($definition->lesson_id, $terms->first()->year_id)
            ->first(function ($c) use ($source) { return (string) $c->data_source === (string) $source; }) : null;
        $name = $component ? $component->name : ($table === 'exams2' ? (is_numeric($source) ? __('gradebook.dynamic') : $definition->name)
            : ($definition->name_exam ?: ($definition->name_quize1 ?: $definition->namehomework)));
        return [
            'key' => $table . ':' . $definition->id, 'id' => $definition->id, 'table' => $table,
            'name' => $name ?: __('gradebook.unnamed_assessment'), 'source' => $source,
            'type' => is_numeric($source) ? 'dynamic' : ($table === 'exams2' ? ((int) $definition->type === 1 ? 'exam' : 'quiz') : 'lesson_assessment'),
            'year_id' => $terms->first()->year_id, 'class_id' => $definition->class_id,
            'room_id' => $definition->room_id, 'lesson_id' => $definition->lesson_id,
            'term_id' => $definition->term_id, 'term_name' => $terms->firstWhere('id', $definition->term_id)->term,
            'maximum' => self::number($definition->mark),
            'start' => $definition->start_date ?: $definition->start_time,
            'end' => $definition->end_date ?: $definition->end_time,
            'results' => $values,
        ];
    }
}
