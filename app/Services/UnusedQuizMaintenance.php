<?php

namespace App\Services;

use App\Exams2;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

/** Called inside the Admin transaction, with the definition already locked. */
class UnusedQuizMaintenance
{
    private function reject($key = 'quiz_used')
    {
        throw ValidationException::withMessages(['assessment'=>__('assessment_entry.'.$key)]);
    }

    public function prepare(Exams2 $exam)
    {
        if (DB::transactionLevel() < 1 || (int)$exam->type !== 2) throw new \LogicException('Locked quiz transaction required.');
        $year = \App\Year::where('current_year',1)->lockForUpdate()->first();
        if (!$year || !\App\Term_year::whereKey($exam->term_id)->where('year_id',$year->id)->where('current_term',1)->exists()
            || !\App\Room::whereKey($exam->room_id)->where('year_id',$year->id)->where('class_id',$exam->class_id)->exists()) $this->reject('quiz_history');
        $member = Schema::hasTable('assessment_equivalence_members')
            ? DB::table('assessment_equivalence_members')->where('exam_id',$exam->id)->first() : null;
        if ($member) {
            $members = DB::table('assessment_equivalence_members')->where('identity',$member->identity)->orderBy('id')->lockForUpdate()->get();
            $definitions = Exams2::whereIn('id',$members->pluck('exam_id'))->orderBy('id')->lockForUpdate()->get()->keyBy('id');
            if ($definitions->count() !== $members->count()) $this->reject();
            $expected = null;
            foreach ($members as $mapped) {
                $definition = $definitions[$mapped->exam_id];
                $context = app(AssessmentEquivalenceService::class)->context($definition);
                if ($expected !== null && $expected !== $context) $this->reject();
                $expected = $context;
                foreach ($context as $field=>$value) if ((float)$mapped->$field !== (float)$value) $this->reject();
                if ((int)$mapped->room_id !== (int)$definition->room_id) $this->reject();
                $this->assertUnused($definition);
            }
            // Withdraw only the unused target from equivalence. Its peers and
            // their identity metadata remain intact, including a last singleton.
            DB::table('assessment_equivalence_members')->where('id',$member->id)->delete();
        } else {
            $this->assertUnused($exam);
        }
        // Only unattempted, unpublished, context-matching NULL/empty scaffolds qualify.
        // A numeric zero is an earned mark and never qualifies.
        foreach (\App\Exam_result2::where('exam_id',$exam->id)->lockForUpdate()->get() as $record) {
            app(UnusedAssessmentParticipation::class)->remove($record, $exam, true);
        }
    }

    private function assertUnused(Exams2 $exam)
    {
        if (strpos((string)$exam->name,'Dynamic_Section_') === 0 || filled($exam->file) || filled($exam->selected_ques)) $this->reject();
        foreach (['exams_files','exam_questions','exam_result_tester','exam_student_lesson'] as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table,'exam_id')
                && DB::table($table)->where('exam_id',$exam->id)->lockForUpdate()->exists()) $this->reject();
        }
        foreach (DB::table('exam_result2')->where('exam_id',$exam->id)->lockForUpdate()->get() as $row) {
            app(UnusedAssessmentParticipation::class)->assertUnused((new \App\Exam_result2)->newFromBuilder((array)$row), $exam, true);
            foreach (['result','selected_ques','user_answers','traditional_result','start_time','end_time'] as $field) {
                if (isset($row->$field) && trim((string)$row->$field) !== '') $this->reject();
            }
            foreach (['status','show_result','medal'] as $field) {
                if (isset($row->$field) && !in_array((string)$row->$field,['','0'],true)) $this->reject();
            }
            foreach (['class_id','room_id','lesson_id','term_id','type'] as $field) {
                if (isset($row->$field) && (int)$row->$field !== (int)$exam->$field) $this->reject();
            }
        }
    }
}
