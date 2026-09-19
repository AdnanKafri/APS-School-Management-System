<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentFollowUp extends Model
{
    public const LEVELS = ['weak', 'average', 'good', 'excellent'];

    protected $table = 'student_follow_ups';

    protected $fillable = [
        'student_id', 'teacher_id', 'lesson_id', 'year_id', 'term_id', 'class_id', 'room_id',
        'student_academic_placement_id', 'teacher_assignment_period_id', 'level', 'note',
        'observed_at', 'compliance_month', 'compliance_half', 'created_by_user_id',
        'last_edited_by_user_id', 'edited_at', 'voided_at',
    ];

    protected $casts = [
        'observed_at' => 'datetime',
        'compliance_month' => 'date',
        'edited_at' => 'datetime',
        'voided_at' => 'datetime',
    ];

    public function isEditableBy($teacherId, $now)
    {
        return (int) $this->teacher_id === (int) $teacherId
            && !$this->voided_at
            && $now->lt($this->created_at->copy()->addHours(2));
    }
}
