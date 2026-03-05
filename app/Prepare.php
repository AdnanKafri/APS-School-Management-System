<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prepare extends Model
{
    protected $table = 'prepare' ;
    protected $fillable = [
        'lesson_id',
        'teacher_id',
        'room_id',
        'term_id',
        'class_id',
        'lecture_id',
        'period',
        'class_time',
        'number_of_lecture',
        'day',
        'month',
        'year',
        'lecture',
        'unit',
        'The_general_goal_of_the_lesson',
        'stimulating_initialization',
        'behavioral _goals',
        'procedures_and_activities',
        'concepts_and_terminology',
        'means',
        'roads',
        'homework',
        'note',
        'Interim _calendar',
        'Final_calendar',

    ];

    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function lesson(){

        return $this->belongsTo(Lesson::class,'lesson_id');

    }
}
