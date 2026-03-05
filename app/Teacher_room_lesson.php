<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher_room_lesson extends Model
{
    protected $table='teacher_room_lesson';
    protected $fillable=['id','teacher_id','lesson_id','year_id','class_id','room_id'];
    // protected $hidden=['created_at','updated_at'];
      public function teachers(){

        return $this->belongsTo(Teacher::class, 'teacher_id');

    }
       public function lesson(){

        return $this->belongsTo(Lesson::class, 'lesson_id');

    }
}
