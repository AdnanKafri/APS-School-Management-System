<?php

namespace App\Services;

use App\Exams2;
use App\Lesson_teacher_room_term_exam;
use App\Term_year;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/** Read-only impact evidence across every section and actual term of a subject/year. */
final class GradebookDistributionImpact
{
    public static function usedSources($subjectId, $yearId)
    {
        $terms = Term_year::where('year_id', $yearId)->pluck('id');
        $definitions = Exams2::where('lesson_id', $subjectId)->whereIn('term_id', $terms)->get();
        $ids = $definitions->pluck('id');
        $retained = DB::table('exam_result2')->whereIn('exam_id', $ids)->pluck('exam_id')
            ->merge(DB::table('exams_files')->whereIn('exam_id', $ids)->pluck('exam_id'));
        if (Schema::hasTable('assessment_equivalence_members')) {
            $retained = $retained->merge(DB::table('assessment_equivalence_members')->whereIn('exam_id', $ids)->pluck('exam_id'));
        }
        $retained = array_fill_keys($retained->all(), true);
        $sources = [];
        foreach ($definitions as $exam) {
            if (!isset($retained[$exam->id])) continue;
            if (preg_match('/^Dynamic_Section_(\d+)$/D', $exam->name, $m)) $source = (int) $m[1];
            else $source = (int) $exam->type === 1 ? 'LEGACY_EXAM' : ((int) $exam->type === 2 ? 'LEGACY_HOMEWORK' : null);
            if ($source !== null) $sources[(string) $source] = true;
        }
        $legacyIds = Lesson_teacher_room_term_exam::where('lesson_id', $subjectId)->whereIn('term_id', $terms)->pluck('id');
        if (DB::table('exam_result')->whereIn('exam_id', $legacyIds)->exists()
            || DB::table('student_lesson_teacher_room_term_exam')->whereIn('exam_id', $legacyIds)->orWhereIn('file_id', $legacyIds)->exists()) {
            $sources['LEGACY_ORAL'] = true;
        }
        return $sources;
    }
}
