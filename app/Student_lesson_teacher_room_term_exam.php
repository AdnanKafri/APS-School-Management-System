<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_lesson_teacher_room_term_exam extends Model
{

  protected  $table='student_lesson_teacher_room_term_exam';

protected $fillable=['student_id','lesson_id','teacher_id','room_id','term_id','test','extension','quize','exam','exam_id'];

public function student() {

    return $this->belongsTo(Student ::class,'student_id');
}




}
