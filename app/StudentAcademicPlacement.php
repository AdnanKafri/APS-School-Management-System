<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAcademicPlacement extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_WITHDRAWN = 'withdrawn';
    public const STATUS_CANCELLED = 'cancelled';
    protected $table = 'student_academic_placements';

    protected $fillable = [
        'student_id',
        'year_id',
        'class_id',
        'room_id',
        'term_id',
        'effective_from',
        'effective_to',
        'status',
        'reason',
        'action_source',
        'actioned_by',
    ];

    protected $casts = [
        'effective_from' => 'datetime',
        'effective_to' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }
}
