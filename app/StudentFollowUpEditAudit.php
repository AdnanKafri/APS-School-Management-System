<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentFollowUpEditAudit extends Model
{
    protected $table = 'student_follow_up_edit_audits';

    protected $fillable = [
        'student_follow_up_id', 'edited_by_user_id', 'previous_level', 'previous_note',
        'new_level', 'new_note', 'edited_at',
    ];

    protected $casts = [
        'edited_at' => 'datetime',
    ];
}
