<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonContentAttachment extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = ['disk', 'path', 'sha256'];

    public function content()
    {
        return $this->belongsTo(Lesson_teacher_room_term_exam::class, 'content_id');
    }
}
