<?php

namespace App\Services;

use App\Room;
use App\Student;
use App\StudentAcademicPlacement;
use Illuminate\Support\Facades\DB;

/** Observe proven current membership, never reconstruct an undocumented transfer. */
class AcademicWriteObservation
{
    private const MODELS = [
        'students_marks'=>\App\Students_mark::class, 'report_cards'=>\App\Report_card::class,
        'exam_result2'=>\App\Exam_result2::class, 'exam_result'=>\App\Exam_result::class,
        'exams_files'=>\App\Exam_file::class,
        'student_lesson_teacher_room_term_exam'=>\App\Student_lesson_teacher_room_term_exam::class,
        'certificates'=>\App\Certificate::class,
    ];

    /** SELECT-only preflight; also used under the student lock before any observation. */
    public function plan($studentId, Room $room, $incoming = null): array
    {
        $context = app(CurrentStudentMembership::class)->assessmentEntryContexts([$studentId], $room->year_id, $room->id)[$studentId] ?? null;
        $placements = StudentAcademicPlacement::where('student_id', $studentId)->where('year_id', $room->year_id)->where('status', 'active')->get();
        if (!$context || !$context['legacy_projection'] || $placements->count() !== 1
            || $placements->first()->effective_to !== null || !\App\Year::whereKey($room->year_id)->where('current_year', 1)->exists()) {
            return ['safe'=>false, 'reason'=>'membership_evidence'];
        }
        $records = collect();
        foreach (self::MODELS as $table=>$model) {
            $key = in_array($table, ['exam_result2','exam_result'], true) ? 'user_id' : 'student_id';
            $query = $model::withoutGlobalScope('academic_visit')->where($key, $studentId)->where('room_id', $room->id);
            if (in_array($table, ['students_marks','report_cards'], true)) $query->where('year_id', $room->year_id);
            if ($incoming && $incoming->getTable() === $table) $query->where('id', '<>', $incoming->id);
            $rows = $query->get();
            if (in_array($table, ['students_marks','report_cards'], true) && $rows->count() > 1) {
                return ['safe'=>false, 'reason'=>'duplicate_summary', 'table'=>$table];
            }
            foreach ($rows as $row) {
                $date = $row->getRawOriginal('created_at') ?: $row->getRawOriginal('Created_at');
                if (!app(AssessmentEntryWindow::class)->date($date) || $date < $context['effective_from'] || $date > now()->format('Y-m-d H:i:s')
                    || !$this->consistent($row, $room)
                    || app(AcademicVisitRecords::class)->link(AcademicVisitRecords::TYPES[$table], $row->id)) {
                    return ['safe'=>false, 'reason'=>'unresolved_original_context', 'table'=>$table, 'record_id'=>$row->id];
                }
                $records->push($row);
            }
        }
        return ['safe'=>true, 'context'=>$context, 'placements'=>$placements, 'records'=>$records];
    }

    public function forCreation($record, Room $room): StudentAcademicPlacement
    {
        if (DB::transactionLevel() < 1) throw new \LogicException('Academic observation requires the student write transaction.');
        $studentId = $record->student_id ?: $record->user_id;
        $student = Student::whereKey($studentId)->lockForUpdate()->firstOrFail();
        \App\Year::whereKey($room->year_id)->lockForUpdate()->firstOrFail();
        $enrollments = \App\Room_student::where('student_id', $studentId)->where('year_id', $room->year_id)->lockForUpdate()->get();
        StudentAcademicPlacement::where('student_id', $studentId)->where('year_id', $room->year_id)->lockForUpdate()->get();
        $user = auth()->user();
        $type = AcademicVisitRecords::TYPES[$record->getTable()];
        // These are additional observation checks, not replacements for endpoint authorization.
        $authorized = $user && ((int)$user->type === 2
            || ((int)$user->type === 1 && $record->lesson_id && app(CurrentTeacherAssignments::class)->has($user->teacher_id, $room->id, $record->lesson_id))
            || ((int)$user->type === 0 && (int)$user->student_id === (int)$studentId
                && in_array($type, ['modern_result','legacy_result','exam_submission','lesson_submission'], true)));
        $plan = $this->plan($studentId, $room, $record);
        if (!$authorized || !$plan['safe'] || $enrollments->count() !== 1 || !$this->consistent($record, $room)) {
            AssessmentResultSafety::reject('placement_inconsistent');
        }
        $evidence = ['basis'=>'verified_legacy_current_projection', 'context'=>$plan['context'],
            'attributed_originals'=>$plan['records']->map(function ($row) {
                return ['table'=>$row->getTable(), 'id'=>$row->id,
                    'sha256'=>hash('sha256', json_encode($row->getRawOriginal(), JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR))];
            })->all()];
        $placement = app(StudentPlacementReconciliation::class)->observeAcademicWrite(
            $enrollments->first(), $plan['placements'], $evidence);
        $visits = app(AcademicVisitRecords::class);
        foreach ($plan['records'] as $original) $visits->bind($original, $placement, 'verified_current_context_observation');
        $visits->bind($record, $placement, 'created_in_current_observation');
        $this->scaffolding($student, $room);
        return $placement;
    }

    private function consistent($record, Room $room): bool
    {
        if (($record->year_id !== null && (int)$record->year_id !== (int)$room->year_id)
            || ($record->class_id !== null && (int)$record->class_id !== (int)$room->class_id)
            || ($record->getTable() === 'report_cards' && (int)$record->class !== (int)$room->class_id)) return false;
        $termId = $record->getTable() === 'certificates' ? $record->term : $record->term_id;
        if ($termId && !\App\Term_year::whereKey($termId)->where('year_id', $room->year_id)->exists()) return false;
        if ($record->lesson_id && !\App\Lesson::whereKey($record->lesson_id)->where('class_id', $room->class_id)->exists()) return false;
        if (in_array($record->getTable(), ['exam_result2','exam_result','exams_files'], true)) {
            $model = $record->getTable() === 'exam_result' ? \App\Lesson_teacher_room_term_exam::class : \App\Exams2::class;
            $definition = $model::find($record->exam_id);
            if (!$definition || (int)$definition->room_id !== (int)$room->id
                || (int)$definition->class_id !== (int)$room->class_id
                || (int)$definition->term_id !== (int)$record->term_id
                || ($record->lesson_id !== null && (int)$definition->lesson_id !== (int)$record->lesson_id)
                || !\App\Term_year::whereKey($definition->term_id)->where('year_id', $room->year_id)->exists()) return false;
            if ($record->getTable() !== 'exams_files') {
                try { AssessmentResultSafety::assertResultContext($record, $definition); }
                catch (\Illuminate\Validation\ValidationException $e) { return false; }
            }
        }
        if ($record->getTable() === 'student_lesson_teacher_room_term_exam') {
            $definition = \App\Lesson_teacher_room_term_exam::find($record->exam_id ?: $record->file_id);
            if (!$definition || (int)$definition->room_id !== (int)$room->id
                || !\App\Term_year::whereKey($definition->term_id)->where('year_id', $room->year_id)->exists()
                || ($record->term_id !== null && (int)$record->term_id !== (int)$definition->term_id)
                || ($record->lesson_id !== null && (int)$record->lesson_id !== (int)$definition->lesson_id)) return false;
        }
        return true;
    }

    private function scaffolding(Student $student, Room $room): void
    {
        if (!\App\Students_mark::where('student_id', $student->id)->where('year_id', $room->year_id)->where('room_id', $room->id)->exists()) {
            $mark = []; $result1 = []; $result2 = []; $result = [];
            foreach (\App\Lesson::where('class_id', $room->class_id)->get() as $lesson) {
                if ((in_array((string)$student->lang, ['0','1'], true) && $lesson->lang !== null && (string)$lesson->lang === ((string)$student->lang === '0' ? '1' : '0'))
                    || (in_array((string)$student->religion, ['0','1'], true) && $lesson->religion !== null && (string)$lesson->religion === ((string)$student->religion === '0' ? '1' : '0'))) continue;
                $mark[$lesson->id] = ['oral'=>null, 'homework'=>null, 'activities'=>null, 'quize'=>null, 'exam'=>null];
                $result1[$lesson->id] = ['term1_quizes'=>null, 'term1_exam'=>null, 'term1_result'=>null];
                $result2[$lesson->id] = ['term2_quizes'=>null, 'term2_exam'=>null, 'term2_result'=>null];
                $result[$lesson->id] = ['year_result'=>null];
            }
            \App\Students_mark::create(['student_id'=>$student->id, 'year_id'=>$room->year_id, 'room_id'=>$room->id,
                'mark'=>json_encode((object)$mark), 'mark2'=>json_encode((object)$mark),
                'result1'=>json_encode((object)$result1), 'result2'=>json_encode((object)$result2), 'result'=>json_encode((object)$result),
                'term_result'=>json_encode(['term1'=>0,'term2'=>0]), 'year_result'=>0, 'status'=>'1', 'adjustable'=>0,
                'lang'=>$student->lang, 'religion'=>$student->religion]);
        }
        if (!\App\Report_card::where('student_id', $student->id)->where('year_id', $room->year_id)->where('room_id', $room->id)->exists()) {
            $report = new \App\Report_card();
            $report->forceFill(['student_id'=>$student->id, 'year_id'=>$room->year_id, 'room_id'=>$room->id,
                'class'=>$room->class_id, 'final_result'=>1]);
            foreach (['teacher_notes','student_attendance','actual_attendance','justified_absence','unjustified_absence'] as $field) {
                $report->$field = json_encode(['term1'=>null,'term2'=>null]);
            }
            $report->save();
        }
    }
}
