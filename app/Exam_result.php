<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_result extends Model
{
    protected $table = 'exam_result' ;
    protected $fillable = [
        'exam_id',
        'user_id',
        'selected_ques',
        'user_answers',
        'result',
        'show_result',
        'medal',
        'type',
        'class_id',
        'room_id',
        'status'
    ];
    // protected $casts = [
    //     'user_answers' => 'array'
    // ];
    public function exam()
    {
        return $this->belongsTo(Lesson_teacher_room_term_exam::class, 'exam_id');
    }

    public function student() {

        return $this->belongsTo(Student::class,'user_id');
    }

           public function lesson(){
        
        return $this->belongsTo(Lesson::class,'lesson_id');
        
    }
    


}
