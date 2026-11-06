<?php

namespace App\Services;

use App\Student;
use App\Student_detail;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentDeletionService
{
    public function deleteHistoryFreeStudent($studentId)
    {
        return DB::transaction(function () use ($studentId) {
            $student = Student::whereKey($studentId)->lockForUpdate()->first();
            if (!$student) {
                $this->reject('missing');
            }
            $users = User::where('student_id', $student->id)->lockForUpdate()->get();
            $details = Student_detail::where('student_id', $student->id)->lockForUpdate()->get();
            if ($users->count() > 1 || $details->count() > 1 || $student->isArchived()) {
                $this->reject('retained');
            }

            // Legacy tables largely lack foreign keys. Fail closed on retained
            // student/account references, including ambiguous legacy user_id values.
            $columns = DB::select('SELECT TABLE_NAME AS table_name, COLUMN_NAME AS column_name
                FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE()
                AND COLUMN_NAME IN (\'student_id\', \'user_id\', \'s_fk\', \'admission_converted_student_id\', \'actor_id\')');
            foreach ($columns as $column) {
                $table = $column->table_name;
                $field = $column->column_name;
                if (in_array($table, ['users', 'student_details'], true)) {
                    continue;
                }
                $ids = in_array($field, ['user_id', 'actor_id'], true)
                    ? array_unique(array_merge([$student->id], $users->pluck('id')->all()))
                    : [$student->id];
                if (DB::table($table)->whereIn($field, $ids)->lockForUpdate()->first()) {
                    $this->reject('retained');
                }
            }
            // Include differently named declared foreign keys, not just legacy conventions.
            $references = DB::select('SELECT TABLE_NAME AS table_name, COLUMN_NAME AS column_name,
                REFERENCED_TABLE_NAME AS parent_table FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IN (\'students\', \'users\', \'student_details\')');
            foreach ($references as $reference) {
                if (in_array($reference->table_name, ['users', 'student_details'], true)) {
                    continue;
                }
                $ids = $reference->parent_table === 'students' ? [$student->id]
                    : ($reference->parent_table === 'users' ? $users->pluck('id')->all() : $details->pluck('id')->all());
                if ($ids && DB::table($reference->table_name)->whereIn($reference->column_name, $ids)->lockForUpdate()->first()) {
                    $this->reject('retained');
                }
            }
            foreach (array_merge([$student], $details->all()) as $record) {
                foreach ($record->getAttributes() as $key => $value) {
                    if (preg_match('/image|certificate|certification|sequence|study_sequence|father_page|mather_page|family_book|passport|fourth_image/i', $key)
                        && $value !== null && trim((string) $value) !== '') {
                        $this->reject('documents');
                    }
                }
            }
            foreach ($details as $detail) {
                foreach ($detail->getAttributes() as $key => $value) {
                    if (!in_array($key, ['id', 'student_id', 'created_at', 'updated_at', 'phone', 'father_name', 'mother_name', 'mother_phone', 'father_phone'], true)
                        && $value !== null && trim((string) $value) !== '' && (string) $value !== '0') {
                        $this->reject('retained');
                    }
                }
            }
            foreach ($details as $detail) {
                $detail->delete();
            }
            foreach ($users as $user) {
                if ((string) $user->type !== '0') {
                    $this->reject('retained');
                }
                $user->delete();
            }
            $student->delete();
            if (Student::whereKey($studentId)->exists() || User::where('student_id', $studentId)->exists()
                || Student_detail::where('student_id', $studentId)->exists()) {
                throw new \RuntimeException('Student deletion persistence check failed');
            }
        });
    }

    private function reject($key)
    {
        throw ValidationException::withMessages(['student_id' => __('student_deletion.'.$key)]);
    }
}
