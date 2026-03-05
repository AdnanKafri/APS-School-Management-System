<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson_room_teacher_lecture_time extends Model
{
    protected $table='lesson_room_teacher_lecture_time';

    protected $fillable=['id','lesson_id','room_id','teacher_id','lectuer_time_id','day_id','meeting_link'];

    public function lecture_time()
    {
        return $this->belongsTo(Lecture_time::class,'lecture_time_id');
    }
    public function day()
    {
        return $this->belongsTo(Day::class,'day_id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class,'room_id');
    }
    public function lesson()
    {
        return $this->belongsTo(Lesson::class,'lesson_id')->select(['id','name']);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id')->select(['id','first_name','last_name']);
    }
}
