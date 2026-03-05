<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{


    protected $fillable = [
        'class_id',
        'section_id',
        'question_form',
        'answer',
        'mark',
        'note',
        'ques_type',
       ];

 public function classes() {

     return $this->belongsTo(Classe::class,'class_id');
 }

 public function option() {

    return $this->hasOne(Option::class,'question_id');
 }

 public function section(){

    return $this->belongsTo(Section::class,'section_id');
 }
 public function teacher(){

    return $this->belongsTo(Teacher::class,'teacher_id');
 }

 public function lecture(){

    return $this->belongsTo(Lecture::class,'lecture_id');
 }
  public function exam_question()
    {
        return $this->hasMany(Exam_question::class, 'question_id');
    }
    
     public function coordinator(){

    return $this->belongsTo(Coordinator::class,'coordinator_id');
 }
   public function lesson(){

    return $this->belongsTo(Lesson::class,'lesson_id');
 }
  


}
