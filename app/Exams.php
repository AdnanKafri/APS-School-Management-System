<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exams extends Model
{
    protected $table='exams';
    public function teacher(){

        return $this->belongsTo(Exam::class,'teacher_id');

    }
    public function examResult()
    {
        return $this->hasMany(Exam_result::class,'exam_id');
    }


    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

}
