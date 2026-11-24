<?php

namespace App\Services;

use App\Exams2;
use App\Exam_result2;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

/** Read-only projection. Callers must authorize the receiving room and student. */
class AssessmentContinuityService
{
    public function resolve(Exams2 $target, $studentIds)
    {
        $answer = [];
        $member = Schema::hasTable('assessment_equivalence_members')
            ? DB::table('assessment_equivalence_members')->where('exam_id', $target->id)->first() : null;
        if (!$member) return $this->originalVisitResults($target,$studentIds);
        if (!\App\Year::whereKey($member->year_id)->where('current_year', 1)->exists()) return $answer;

        $members = DB::table('assessment_equivalence_members')->where('identity', $member->identity)->get();
        $definitions = Exams2::whereIn('id', $members->pluck('exam_id'))->get()->keyBy('id');
        // An unused peer may be withdrawn by Admin, leaving a valid singleton.
        $valid = $members->count() >= 1 && $definitions->count() === $members->count();
        $expected = null;
        foreach ($members as $mapped) {
            if (!$definitions->has($mapped->exam_id)) { $valid = false; continue; }
            try {
                $context = app(AssessmentEquivalenceService::class)->context($definitions[$mapped->exam_id]);
                foreach ($context as $key => $value) {
                    if ((float) $mapped->$key !== (float) $value) $valid = false;
                }
                if ((int) $mapped->room_id !== (int) $definitions[$mapped->exam_id]->room_id
                    || ($expected !== null && $context !== $expected)) $valid = false;
                $expected = $context;
            } catch (ValidationException $e) { $valid = false; }
        }
        // Never widen historical reads: carry only into the student's operational placement.
        $entryContexts = app(CurrentStudentMembership::class)->assessmentEntryContexts(
            $studentIds, $member->year_id, $target->room_id);
        $eligible = array_keys($entryContexts);
        $placements = DB::table('student_academic_placements')->whereIn('student_id', $eligible)
            ->where('year_id', $member->year_id)->where('class_id', $member->class_id)->get()->groupBy('student_id');
        $originals = Exam_result2::whereIn('exam_id', $members->pluck('exam_id'))->whereIn('user_id', $eligible)->get();
        $visits = new AcademicVisitReadContext($originals);
        $results = $originals->groupBy('user_id');
        $roomNames = DB::table('rooms')->whereIn('id', $members->pluck('room_id'))->pluck('name', 'id');
        foreach ($eligible as $studentId) {
            $state = ['state' => 'missing', 'value' => null, 'identity' => $member->identity];
            $history = $placements->get($studentId, collect());
            $current = $entryContexts[$studentId] ?? null;
            if (!$valid || !$current) {
                $answer[$studentId] = array_merge($state, ['state' => 'conflict',
                    'reason' => !$valid ? 'assessment_context' : 'placement_context']);
                continue;
            }
            $earned = [];
            $conflict = false;
            foreach ($results->get($studentId, collect())->groupBy('exam_id') as $examId => $rows) {
                if ($rows->count() > 1) { $conflict = true; continue; }
                $row = $rows->first();
                $definition = $definitions[$examId];
                try { AssessmentResultSafety::assertResultContext($row, $definition); }
                catch (ValidationException $e) { $conflict = true; continue; }
                if ($row->result === null || trim((string) $row->result) === '') continue;
                $value = GradebookReadService::number($row->result);
                if ($value === null || $value > (float) $member->maximum) { $conflict = true; continue; }
                $prior = $history->where('room_id', $definition->room_id)->filter(function ($placement) {
                    return $placement->effective_from && ($placement->status === 'active'
                        || ($placement->effective_to && $placement->effective_to >= $placement->effective_from));
                });
                $visitLink = $visits->link($row);
                if ($visitLink) {
                    $prior = $prior->where('id', $visitLink->placement_id);
                    if ((int)$visitLink->student_id !== (int)$studentId || (int)$visitLink->room_id !== (int)$definition->room_id
                        || $prior->count() !== 1) { $conflict = true; continue; }
                }
                // Legacy MySQL returns this column as Created_at; Eloquent's
                // lowercase timestamp accessor does not resolve that attribute.
                $recordedAt = $row->getRawOriginal('created_at') ?: $row->getRawOriginal('Created_at');
                // A known result timestamp must belong to a real placement interval.
                if ($visitLink) {
                    // Explicit original attribution survives return visits and
                    // uncertain legacy timestamps without rewriting the result.
                } elseif ($recordedAt) {
                    $intervals = $prior->filter(function ($placement) use ($recordedAt) {
                        $time = (string) $recordedAt;
                        return $time >= $placement->effective_from
                            && (!$placement->effective_to || $time <= $placement->effective_to);
                    });
                    if ($current['legacy_projection']) {
                        $intervals = $intervals->reject(function ($placement) use ($current, $recordedAt) {
                            return (int) $placement->id === (int) $current['placement_id']
                                && (string) $recordedAt >= $current['effective_from'];
                        });
                    }
                    // A proven operational projection can own NEW original results
                    // without rewriting or pretending to close its stale history row.
                    $projected = $current['legacy_projection']
                        && (int) $definition->room_id === (int) $current['room_id']
                        && (string) $recordedAt >= $current['effective_from']
                        && (!$current['effective_to'] || (string) $recordedAt <= $current['effective_to']);
                    if ($intervals->count() + (int) $projected !== 1) { $conflict = true; continue; }
                } elseif ($prior->count() !== 1 || ($current['legacy_projection']
                    && in_array((int) $definition->room_id, [(int) $current['room_id'], (int) $current['stored_room_id']], true))) {
                    $conflict = true; continue;
                }
                $carried = (int) $examId !== (int) $target->id
                    || ($visitLink && (int)$visitLink->placement_id !== (int)$current['placement_id'])
                    || (!$visitLink && $recordedAt && (string) $recordedAt < $current['effective_from']);
                $earned[] = array_merge($state, [
                    'state' => $carried ? 'carried' : 'current', 'value' => $value,
                    'result_id' => $row->id, 'exam_id' => $definition->id,
                    'room_id' => $definition->room_id, 'assessment_name' => $definition->name,
                    'room_name' => $roomNames[$definition->room_id] ?? '',
                ]);
            }
            $answer[$studentId] = $conflict || count($earned) > 1
                ? array_merge($state, ['state' => 'conflict']) : ($earned[0] ?? $state);
        }
        return $answer;
    }

    public function assertWritable(Exams2 $exam, $studentId)
    {
        foreach (Exam_result2::where('exam_id',$exam->id)->where('user_id',$studentId)->get() as $original) {
            $visitState = app(AcademicVisitRecords::class)->resultState($original);
            if ($visitState === 'conflict') AssessmentResultSafety::reject('ambiguous_result');
            if ($visitState === 'carried') {
                AssessmentResultSafety::reject(AssessmentResultSafety::hasEarnedData($original) ? 'carried_read_only' : 'historical_record_read_only');
            }
        }
        $projection = $this->resolve($exam, [$studentId])[$studentId] ?? [];
        $state = $projection['state'] ?? null;
        if ($state === 'carried') AssessmentResultSafety::reject('carried_read_only');
        if ($state === 'conflict') AssessmentResultSafety::reject(($projection['reason'] ?? null) === 'placement_context' ? 'placement_inconsistent' : 'ambiguous_result');
    }

    private function originalVisitResults(Exams2 $exam, $studentIds)
    {
        $visits=app(AcademicVisitRecords::class);
        if (!$visits->enabled()) return [];
        $year=\App\Room::whereKey($exam->room_id)->value('year_id');
        if (!\App\Year::whereKey($year)->where('current_year',1)->exists()) return [];
        $contexts=app(CurrentStudentMembership::class)->assessmentEntryContexts($studentIds,$year,$exam->room_id);
        $answer=[];
        $originals=Exam_result2::where('exam_id',$exam->id)->whereIn('user_id',array_keys($contexts))->get();
        $visits=new AcademicVisitReadContext($originals, [$exam->room_id]);
        foreach ($originals->groupBy('user_id') as $id=>$rows) {
            $row=$rows->first();$state=$visits->resultState($row);
            if ($state === null || $state === 'current') continue;
            try { AssessmentResultSafety::assertResultContext($row,$exam); }
            catch (ValidationException $e) { $state='conflict'; }
            if ($rows->count() !== 1) $state='conflict';
            $answer[$id]=['state'=>$state,'value'=>$state==='conflict'?null:GradebookReadService::number($row->result),
                'result_id'=>$row->id,'exam_id'=>$exam->id,'room_id'=>$exam->room_id,'assessment_name'=>$exam->name,
                'room_name'=>$visits->roomName($exam->room_id)];
        }
        return $answer;
    }
}
