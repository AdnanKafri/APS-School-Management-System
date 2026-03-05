<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher_event extends Model
{
    protected $dates = ['date'];

    public function classes(){

        return $this->belongsTo(Classe::class,'class_id');
    }
  

    public function rooms(){

        return $this->belongsTo(Room::class,'room_id');
    }
    public function teacher(){

        return $this->belongsTo(Teacher::class,'teacher_id');
    }
}
