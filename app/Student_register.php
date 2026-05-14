<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_register extends Model
{

    protected $table='student_register';

    protected $guarded = [];

    protected $casts = [
        'status' => 'integer',
        'admission_status_changed_at' => 'datetime',
        'admission_submitted_at' => 'datetime',
        'admission_reviewed_at' => 'datetime',
        'admission_approved_at' => 'datetime',
        'admission_rejected_at' => 'datetime',
        'admission_cancelled_at' => 'datetime',
        'admission_converted_at' => 'datetime',
        'accepted_terms' => 'boolean',
        'accepted_transport_terms' => 'boolean',
        'wants_transport' => 'boolean',
        'fever_medicine_permission' => 'boolean',
        'payment_method' => 'integer',
        'registration_fee' => 'decimal:2',
        'services_fee' => 'decimal:2',
        'transport_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'current_step' => 'integer',
    ];

    public function class()
    {
        return $this->belongsTo('App\Classe', 'class1');
    }

    public function convertedStudent()
    {
        return $this->belongsTo('App\Student', 'admission_converted_student_id');
    }

    public function reviewedByUser()
    {
        return $this->belongsTo('App\User', 'admission_reviewed_by');
    }
}
