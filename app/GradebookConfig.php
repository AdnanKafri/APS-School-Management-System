<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradebookConfig extends Model
{
    protected $table = 'gradebook_configs';
    
    protected $fillable = [
        'lesson_id',
        'year_id',
        'oral_max',
        'homework_max',
        'exam_max'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
}
