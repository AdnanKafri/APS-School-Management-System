<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planification_trimestrielle extends Model
{
    protected $table = 'planification_trimestrielle' ;
    protected $fillable = [
        'from_to1',
        'from_to2',
        'from_to3',
        'from_to4',
        'from_to5',
        'from_to6',
        'from_to7',
        'from_to8',
        'from_to9',
        'from_to10',
        'from_to11',
        'from_to12',
        'from_to13',
        'from_to14',
        'from_to15',
        'from_to16',
        'from_to17',
        'from_to18',
        'from_to19',
        'from_to20',
        'text1',
        'text2',
        'text3',
        'text4',
        'text5',
        'text6',
        'text7',
        'text8',
        'text9',
        'text10',
        'text11',
        'text12',
         'text13',
         'text14',
         'text15',
         'text16',
         'text17',
         'text18',
         'text19',
         'text20',
         'class_id',
         'term_id',
         'lesson_id',
         'teacher_id',
    ];

    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }

    public function lesson(){

        return $this->belongsTo(Lesson::class,'lesson_id');

    }
}
