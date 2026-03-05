<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{

    public function lesson() {

        return $this->belongsTo(Lesson::class,'lesson_id');
    }
     public function room() {

        return $this->belongsTo(Room::class,'room_id');
    }
    
    public function question(){

        return $this->hasMany(Question::class,'lecture_id');
     }
      public function teacher(){

        return $this->belongsTo(Teacher::class,'teacher_id');
     }
       public function term_years(){

        return $this->belongsTo(Term_year::class,'term_id');
     }
}
