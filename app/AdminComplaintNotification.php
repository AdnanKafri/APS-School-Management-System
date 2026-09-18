<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminComplaintNotification extends Model
{
    protected $table = 'admin_complaint_notifications';

    protected $fillable = [
        'complaint_id',
        'admin_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id');
    }
}
