<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_result extends Model
{
    public function scopeCurrentRoster($query)
    {
        return $query->whereIn('exam_result.user_id', Student::currentMembership(null,
            \Illuminate\Support\Facades\DB::raw('exam_result.room_id'))->select('students.id'));
    }

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
