<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit_analysis extends Model
{
    protected $table = 'unit_analysis' ;
    protected $fillable = [
        'lesson_id',
        'teacher_id',
        'unit_name',
        'term_id',
        'contain',
        'class_id',
        'term_id',
        'year_id',


    ];

    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function lesson(){

        return $this->belongsTo(Lesson::class,'lesson_id');

    }
}
