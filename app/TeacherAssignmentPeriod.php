<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherAssignmentPeriod extends Model
{
    protected $table = 'teacher_assignment_periods';

    protected $fillable = [
        'teacher_room_lesson_id', 'teacher_id', 'lesson_id', 'year_id', 'class_id',
        'room_id', 'effective_from', 'effective_to', 'source',
    ];

    protected $casts = [
        'effective_from' => 'datetime',
        'effective_to' => 'datetime',
    ];
}
