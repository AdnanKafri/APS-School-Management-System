<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room_lesson_exam extends Model
{
    protected $table='room_lesson_exam';

    public function room(){

        return $this->belongsTo(Room::class,'id');

    }

    public function lesson(){

        return $this->belongsTo(Lesson::class,'id');

    }

    public function teacher(){

        return $this->belongsTo(Teacher::class,'id');

    }

    public function term(){

        return $this->belongsTo(Term_year::class,'id');

    }
}
