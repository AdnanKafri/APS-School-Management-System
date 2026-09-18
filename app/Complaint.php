<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $guarded = [];

    protected $casts = [
        'viewed_at' => 'datetime',
        'archived_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function handledBy()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public static function allowedTransitions()
    {
        return [
            'new' => ['viewed', 'in_progress'],
            'viewed' => ['in_progress', 'resolved'],
            'in_progress' => ['resolved'],
            'resolved' => [],
            'archived' => [],
        ];
    }

    public function canTransitionTo($status)
    {
        return in_array($status, self::allowedTransitions()[$this->status] ?? [], true);
    }

    public function typeLabel()
    {
        return $this->type === 'transport'
            ? __('complaints.types.transport')
            : __('complaints.types.academic');
    }

    public function statusLabel()
    {
        switch ($this->status) {
            case 'viewed':
                return __('complaints.status.viewed');
            case 'in_progress':
                return __('complaints.status.in_progress');
            case 'resolved':
                return __('complaints.status.resolved');
            case 'archived':
                return __('complaints.status.archived');
            default:
                return __('complaints.status.new');
        }
    }

    public function statusTone()
    {
        switch ($this->status) {
            case 'viewed':
                return 'is-info';
            case 'in_progress':
                return 'is-warning';
            case 'resolved':
            case 'archived':
                return 'is-muted';
            default:
                return 'is-success';
        }
    }
}
