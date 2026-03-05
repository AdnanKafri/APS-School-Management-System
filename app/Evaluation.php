<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table='evaluations';
    protected $fillable=['class_id','teacher_id','lesson_id','coor_id'];



    public function classes(){

        return $this->belongsTo(Classe::class,'class_id','id');
    }

    public function teachers(){

        return $this->belongsTo(Teacher::class,'teacher_id','id');

    }
    public function lesson(){

        return $this->belongsTo(Lesson::class,'lesson_id','id');

    }
    public function coordinator(){

        return $this->belongsTo(Coordinator::class,'coor_id','id');

    }



}
