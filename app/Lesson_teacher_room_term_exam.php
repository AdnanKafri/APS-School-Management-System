<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson_teacher_room_term_exam extends Model
{
    protected $table='lesson_teacher_room_term_exam';
    protected $fillable=['lesson_id','teacher_id','room_id','term_id','video','test','quize','exam'];
       public function room()
{
    return $this->belongsTo(Room::class,'room_id');
}
public function lecture()
{
    return $this->belongsTo(Lecture::class,'lecture_id');
}
public function exam_resullt()
{
    return $this->hasMany(Exam_result::class, 'exam_id');
}


  public function lesson(){

return $this->belongsTo(Lesson::class,'lesson_id');
}
}
