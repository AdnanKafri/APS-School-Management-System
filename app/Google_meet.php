<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Google_meet extends Model
{
    protected $table='google_meets';

    protected $fillable=['id','lesson_id','room_id','teacher_id','lecture_time_id','day_id',
                        'name','meeting_link','meeting_date','notes'];
    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->select(['id','name']);
    }
    public function room()
    {
        return $this->belongsTo(Room::class)->select(['id','name']);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->select(['id','first_name','last_name']);
    }
    public function lectureTime()
    {
        return $this->belongsTo(Lecture_time::class)->select(['id','name']);
    }
    public function day()
    {
        return $this->belongsTo(Day::class)->select(['id','name']);
    }
}
