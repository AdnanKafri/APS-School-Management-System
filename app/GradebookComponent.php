<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradebookComponent extends Model
{
    protected $table = 'gradebook_components';

    protected $fillable = [
        'lesson_id',
        'year_id',
        'name',
        'max_mark',
        'weight',
        'sort_order',
        'data_source'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
}
