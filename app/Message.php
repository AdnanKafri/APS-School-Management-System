<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function student()
{
    return $this->belongsTo(Student::class, 'student_id');
}
public function teacher()
{
    return $this->belongsTo(Teacher::class, 'teacher_id');
}
    //
}
