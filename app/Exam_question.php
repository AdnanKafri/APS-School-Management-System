<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_question extends Model
{
    protected $table = 'exam_questions' ;
  
  
    public function test()
    {
        return $this->belongsTo(Lesson_teacher_room_term_exam::class, 'test_id');
    }

 public function exam()
    {
        return $this->belongsTo(Exams2::class, 'exam_id');
    }
  
          
    


}
