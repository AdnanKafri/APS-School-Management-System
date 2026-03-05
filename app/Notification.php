<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function student()
{
    return $this->belongsTo(Student::class, 'student_id');
}



    //
}
