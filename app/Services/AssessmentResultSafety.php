<?php

namespace App\Services;

use App\Exam_result;
use App\Exam_result2;
use App\Exams2;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AssessmentResultSafety
{
    public static function reject($key, $field = 'assessment', array $parameters = [])
    {
        throw ValidationException::withMessages([$field => __('gradebook.' . $key, $parameters)]);
    }

    public static function hasRecords($definition)
    {
        $modern = $definition instanceof Exams2;
        if ($modern && \Illuminate\Support\Facades\Schema::hasTable('assessment_equivalence_members')
            && DB::table('assessment_equivalence_members')->where('exam_id', $definition->id)->exists()) return true;
        $results = $modern ? Exam_result2::query() : Exam_result::query();
        return $results->where('exam_id', $definition->id)->exists()
            || DB::table($modern ? 'exams_files' : 'student_lesson_teacher_room_term_exam')
                ->where(function ($query) use ($modern, $definition) {
                    $query->where('exam_id', $definition->id);
                    if (!$modern) $query->orWhere('file_id', $definition->id);
                })->exists();
    }

    public static function assertDeletable($definition)
    {
        if (self::hasRecords($definition)) {
            self::reject('retained_results');
        }
    }

    public static function assertContextDeletable($field, $id)
    {
        if (!in_array($field, ['student_id', 'class_id', 'room_id', 'lesson_id'], true)) {
            throw new \InvalidArgumentException('Unsupported academic context');
        }
        // Legacy cascades use bulk deletes, bypassing model events. Check before
        // they remove assignments, definitions, or any part of an academic record.
        foreach (['exam_result2' => 'exams2', 'exam_result' => 'lesson_teacher_room_term_exam'] as $results => $definitions) {
            $query = DB::table($results);
            if ($field === 'student_id') {
                $query->where('user_id', $id);
            } else {
                $query->where(function ($q) use ($field, $id, $definitions) {
                    $q->where($field, $id)->orWhereIn('exam_id', DB::table($definitions)->where($field, $id)->select('id'));
                });
            }
            if ($query->exists()) self::reject('retained_results');
        }
        foreach (['exams_files', 'student_lesson_teacher_room_term_exam'] as $table) {
            $query = DB::table($table);
            if ($field === 'class_id') {
                $query->whereIn('room_id', DB::table('rooms')->where('class_id', $id)->select('id'));
            } else {
                $query->where($field, $id);
            }
            if ($query->exists()) self::reject('retained_results');
        }
        if ($field === 'lesson_id') {
            foreach (DB::table('students_marks')->select('mark', 'mark2', 'result', 'result1', 'result2')->cursor() as $row) {
                foreach ((array) $row as $json) {
                    $values = json_decode($json ?? '', true);
                    if (is_array($values) && array_key_exists($id, $values)) self::reject('retained_results');
                }
            }
        } else {
            foreach (['students_marks', 'report_cards'] as $table) {
                $query = DB::table($table);
                if ($field === 'class_id') {
                    $query->whereIn('room_id', DB::table('rooms')->where('class_id', $id)->select('id'));
                } else {
                    $query->where($field, $id);
                }
                if ($query->exists()) self::reject('retained_results');
            }
        }
    }

    public static function assertDefinitionUnchanged($definition)
    {
        $fields = ['class_id', 'room_id', 'lesson_id', 'term_id', 'type', 'type_file',
            'teacher_id', 'mark', 'selected_ques', 'question_picker', 'is_file', 'has_traditional'];
        if ($definition->isDirty($fields) && self::hasRecords($definition)) {
            self::reject('retained_results');
        }
    }

    public static function hasEarnedData($result)
    {
        foreach (['result', 'user_answers', 'start_time'] as $field) {
            $value = $result->getRawOriginal($field);
            if ($value !== null && trim((string) $value) !== '') {
                return true;
            }
        }
        return false;
    }

    public static function validateMark($value, $maximum, $field = 'mark')
    {
        $max = GradebookReadService::number($maximum);
        if ($max === null || $max <= 0) {
            self::reject('maximum_missing', $field);
        }
        $number = GradebookReadService::number($value);
        if ($number === null || $number > $max) {
            self::reject('mark_invalid', $field, ['max' => $max]);
        }
        return $number;
    }

    public static function assertResultContext($record, $definition)
    {
        foreach (['room_id', 'class_id', 'lesson_id', 'term_id'] as $field) {
            if ($record->$field !== null && $definition->$field !== null
                && (int) $record->$field !== (int) $definition->$field) {
                self::reject('ambiguous_result');
            }
        }
    }
}
