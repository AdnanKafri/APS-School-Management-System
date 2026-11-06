<?php

namespace App\Services;

use App\Exams2;
use App\Exam_result2;
use App\Room;
use App\Student;
use App\Term_year;
use App\Year;
use Illuminate\Support\Facades\DB;

/** Student-safe originals projection. No participation, transfer or result writes. */
class StudentAssessmentReadService
{
    public function context($studentId, $roomId)
    {
        abort_unless(auth()->check() && (int) auth()->user()->type === 0
            && (int) auth()->user()->student_id === (int) $studentId, 403);
        $year = Year::where('current_year', '1')->first();
        $room = $year ? Room::with('classes')->whereKey($roomId)->where('year_id', $year->id)->first() : null;
        abort_unless($room && Student::currentMembership($year->id, $room->id)->whereKey($studentId)->exists(), 403);
        return [$room, Term_year::where('year_id', $year->id)->where('current_term', 1)->first()];
    }

    public function listing(Student $student, Room $room, $term, $type)
    {
        if (!$term) return collect();
        $definitions = Exams2::with('lesson')->where('room_id', $room->id)->where('class_id', $room->class_id)
            ->where('term_id', $term->id)->where('type', (string) $type)->orderBy('created_at')->orderBy('id')->get()
            ->reject(function ($exam) { return strpos((string) $exam->name, 'Dynamic_Section_') === 0; });
        $rows = Exam_result2::where('user_id', $student->id)->whereIn('exam_id', $definitions->pluck('id'))->get()->groupBy('exam_id');
        $creatorTypes = \App\User::whereIn('id', $definitions->pluck('user_id'))->pluck('type', 'id');
        $mapped = \Illuminate\Support\Facades\Schema::hasTable('assessment_equivalence_members')
            ? DB::table('assessment_equivalence_members')->whereIn('exam_id', $definitions->pluck('id'))->pluck('exam_id')->flip()
            : collect();
        $visibility = app(StudentResultsVisibility::class);
        return $definitions->map(function ($exam) use ($student, $rows, $creatorTypes, $visibility, $mapped) {
            $records = $rows->get($exam->id, collect());
            $traditional = (int) $exam->is_file === 1 && (int) ($creatorTypes[$exam->user_id] ?? -1) === 2;
            // Automated/legacy participation remains explicitly assigned, never inferred.
            if (!$traditional && $records->isEmpty()) return null;
            $state = $visibility->enabled() ? 'unentered' : 'hidden';
            $value = null;$resultExamId = null;
            if ($records->count() > 1) $state = 'unavailable';
            elseif ($records->count() === 1) {
                $record = $records->first();
                try { AssessmentResultSafety::assertResultContext($record, $exam); }
                catch (\Illuminate\Validation\ValidationException $e) { return $this->card($exam, 'unavailable'); }
                if ($visibility->published($record)) {
                    $value = GradebookReadService::number($record->result);
                    if ($value !== null) {$state = 'earned';$resultExamId = $exam->id;}
                } elseif ((string) $record->status === '1') $state = 'hidden';
            }
            $continuity = $mapped->has($exam->id) ? app(AssessmentContinuityService::class)->resolve($exam, [$student->id]) : [];
            $resolved = $continuity[$student->id] ?? null;
            if (($resolved['state'] ?? null) === 'conflict') return $this->card($exam, 'unavailable');
            if (($resolved['state'] ?? null) === 'carried') {
                $original = Exam_result2::find($resolved['result_id']);
                $value = null;$state = 'hidden';$resultExamId = null;
                if ($visibility->published($original)) {
                    $value = $resolved['value'];$state = 'earned';$resultExamId = $resolved['exam_id'];
                }
            }
            return $this->card($exam, $state, $value, $resultExamId, $records->first());
        })->filter()->values();
    }

    private function card($exam, $state, $value = null, $resultExamId = null, $record = null)
    {
        return (object) [
            'id'=>$exam->id, 'name'=>$exam->name, 'lesson'=>(object) ['name'=>optional($exam->lesson)->name],
            'is_file'=>$exam->is_file, 'mark'=>$exam->mark, 'start_date'=>$exam->start_date,
            'end_date'=>$exam->end_date, 'required'=>$exam->required, 'file'=>$exam->file,
            'result_state'=>$state, 'result_value'=>$value, 'result_exam_id'=>$resultExamId,
            'can_participate'=>$record && (string) $record->status !== '1',
        ];
    }

    public function ownedResult(Exams2 $exam, $studentId)
    {
        $rows = Exam_result2::where('exam_id', $exam->id)->where('user_id', $studentId)->get();
        abort_unless($rows->count() === 1, 404);
        $result = $rows->first();
        try { AssessmentResultSafety::assertResultContext($result, $exam); }
        catch (\Illuminate\Validation\ValidationException $e) { abort(404); }
        $room = Room::findOrFail($exam->room_id);
        $term = Term_year::find($exam->term_id);
        $activeYear = Year::where('current_year', '1')->first();
        abort_unless($activeYear && (int) $room->year_id <= (int) $activeYear->id
            && $term && (int) $term->year_id === (int) $room->year_id
            && (int) $exam->class_id === (int) $room->class_id, 404);
        $current = Year::whereKey($room->year_id)->where('current_year', '1')->exists()
            && Student::currentMembership($room->year_id, $room->id)->whereKey($studentId)->exists();
        $historical = DB::table('student_academic_placements')->where('student_id', $studentId)
            ->where('year_id', $room->year_id)->where('room_id', $room->id)->where('class_id', $room->class_id)->exists();
        abort_unless($current || $historical, 404);
        return $result;
    }
}
