<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_result_tester extends Model
{
    protected $table = 'exam_result_tester' ;
    protected $fillable = [
        'class_id',
        'room_id',
        'lesson_id',
        'exam_id',
        'user_id',
        'selected_ques',
        'user_answers',
        'result',
        'show_result',
        'medal',
        'type',
        'status',
        'start_time',
        'end_time'
    ];
    // protected $casts = [
    //     'user_answers' => 'array'
    // ];
    public function exam()
    {
        return $this->belongsTo(Exams2::class, 'exam_id');
    }

    public function student() {

        return $this->belongsTo(Student::class,'user_id');
    }

           public function lesson(){

        return $this->belongsTo(Lesson::class,'lesson_id');

    }


}
