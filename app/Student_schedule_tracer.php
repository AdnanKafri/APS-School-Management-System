<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_schedule_tracer extends Model
{
    protected $table='student_schedule_tracer';

    protected $fillable=['id','user_id','lecture_time_id','day_id'];
}
