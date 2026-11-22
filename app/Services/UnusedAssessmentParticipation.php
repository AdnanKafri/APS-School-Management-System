<?php

namespace App\Services;

use App\Exam_result2;
use App\Exams2;
use Illuminate\Support\Facades\DB;

/** Narrow maintenance exception; general academic model deletion stays forbidden. */
class UnusedAssessmentParticipation
{
    public function assertUnused(Exam_result2 $record, Exams2 $exam, $unpublished = false)
    {
        if (DB::transactionLevel() < 1) throw new \LogicException('Locked assessment transaction required.');
        \App\Student::whereKey($record->user_id)->lockForUpdate()->firstOrFail();
        AssessmentResultSafety::assertResultContext($record, $exam);
        if ((int) $record->exam_id !== (int) $exam->id
            || ($record->type !== null && (int) $record->type !== (int) $exam->type)) {
            AssessmentResultSafety::reject('retained_results');
        }
        foreach (['result', 'selected_ques', 'user_answers', 'traditional_result', 'start_time', 'end_time'] as $field) {
            $value = $record->getRawOriginal($field);
            if ($value !== null && trim((string) $value) !== '') AssessmentResultSafety::reject('retained_results');
        }
        foreach ($unpublished ? ['status', 'medal', 'show_result'] : ['status', 'medal'] as $field) {
            $value = $record->getRawOriginal($field);
            if ($value !== null && !in_array((string) $value, ['', '0'], true)) AssessmentResultSafety::reject('retained_results');
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('exam_result_tester')
            && DB::table('exam_result_tester')->where('exam_id', $exam->id)->where('user_id', $record->user_id)->exists()) {
            AssessmentResultSafety::reject('retained_results');
        }
        $room = \App\Room::find($exam->room_id);
        if (!$room || !\App\Year::whereKey($room->year_id)->where('current_year', 1)->exists()
            || !\App\Term_year::whereKey($exam->term_id)->where('year_id', $room->year_id)->where('current_term', 1)->exists()
            || !\App\Student::currentMembership($room->year_id, $room->id)->whereKey($record->user_id)->exists()
            || DB::table('exams_files')->where('exam_id', $exam->id)->where('student_id', $record->user_id)->exists()) {
            AssessmentResultSafety::reject('retained_results');
        }
        $visits = app(AcademicVisitRecords::class);
        $link = $visits->link('modern_result', $record->id);
        if ($link && ((int)$link->student_id !== (int)$record->user_id || (int)$link->room_id !== (int)$room->id
            || (int)$link->year_id !== (int)$room->year_id)) AssessmentResultSafety::reject('ambiguous_result');
        if (in_array($visits->resultState($record), ['carried', 'conflict'], true)) AssessmentResultSafety::reject('carried_read_only');
        if ($visits->enabled()) {
            // A locking read also sees a transfer committed after an earlier
            // consistent read in the surrounding maintenance transaction.
            $placements = \App\StudentAcademicPlacement::where('student_id', $record->user_id)
                ->where('year_id', $room->year_id)->lockForUpdate()->get();
            $active = $placements->where('status', 'active');
            if ($placements->isNotEmpty() && ($active->count() !== 1
                || (int)$active->first()->room_id !== (int)$room->id
                || (int)$active->first()->class_id !== (int)$room->class_id)) AssessmentResultSafety::reject('carried_read_only');
            if (($link && ($active->count() !== 1 || (int)$active->first()->id !== (int)$link->placement_id))
                || (!$link && $placements->where('room_id', $room->id)->count() > 1)) AssessmentResultSafety::reject('ambiguous_result');
        }
    }

    public function remove(Exam_result2 $record, Exams2 $exam, $unpublished = false)
    {
        $record = Exam_result2::whereKey($record->id)->lockForUpdate()->firstOrFail();
        $this->assertUnused($record, $exam, $unpublished);
        // Only the verified empty participation and its attribution are removed.
        // No earned/historical row can pass this exception to the model guard.
        if (app(AcademicVisitRecords::class)->enabled()) {
            DB::table(AcademicVisitRecords::TABLE)->where('record_type', 'modern_result')->where('record_id', $record->id)->delete();
        }
        DB::table('exam_result2')->where('id', $record->id)->delete();
    }
}
