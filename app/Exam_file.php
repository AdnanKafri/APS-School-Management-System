<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_file extends Model
{

  protected  $table='exams_files';

protected $fillable=['class_id','lesson_id','room_id','student_id','exam_file','term_id','exam_id','file','extension'];

public function student() {

    return $this->belongsTo(Student ::class,'student_id');
}



}
