<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport_invoice extends Model
{

    protected $table='transport_student_invoices';


    public function student(){
        return $this->belongsTo(Student::class,'student_id');
    }
    
}