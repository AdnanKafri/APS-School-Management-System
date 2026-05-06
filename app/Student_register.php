<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_register extends Model
{

    protected $table='student_register';

    protected $guarded = [];

    protected $casts = [
        'status' => 'integer',
        'accepted_terms' => 'boolean',
        'accepted_transport_terms' => 'boolean',
        'wants_transport' => 'boolean',
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
}
