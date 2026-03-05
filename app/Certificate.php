<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public function teacher(){

        return $this->belongsTo(Teacher::class, 'teacher_id');

    }
    public function student() {

        return $this->belongsTo(Student ::class,'student_id');
    }
    
               public function lesson(){
        
        return $this->belongsTo(Lesson::class,'lesson_id');
        
    }
}
