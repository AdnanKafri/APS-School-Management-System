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
    ];

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
            case 'archived':
                return 'is-muted';
            default:
                return 'is-success';
        }
    }
}
