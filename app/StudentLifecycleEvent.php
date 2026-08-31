<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentLifecycleEvent extends Model
{
    public const EVENT_ARCHIVED = 'archived';
    public const EVENT_RESTORED = 'restored';

    protected $table = 'student_lifecycle_events';

    protected $fillable = [
        'student_id',
        'event_type',
        'occurred_at',
        'actioned_by',
        'reason',
        'year_id',
        'placement_id',
        'room_student_id',
        'class_id',
        'room_id',
        'bus_id',
        'before_state',
        'after_state',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actioned_by');
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function placement()
    {
        return $this->belongsTo(StudentAcademicPlacement::class);
    }
}
