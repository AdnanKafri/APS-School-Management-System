<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exams2 extends Model
{
    protected $table='exams2';
 protected $fillable=['id','user_id','class_id','room_id','lesson_id','term_id','name','question_picker','type',
                            'is_file','file','selected_ques',
                            'required','start_date','end_date','groupe','notes'];

    public function user(){

        return $this->belongsTo(User::class,'user_id');

    }
    public function examResult()
    {
        return $this->hasMany(Exam_result::class,'exam_id');
    }


    // public function class()
    // {
    //     return $this->belongsTo(Classe::class, 'class_id');
    // }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class,'lesson_id');
    }

}
