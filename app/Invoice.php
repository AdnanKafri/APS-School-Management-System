<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = ['id','invoice_number','invoice_amount','payment_type','bank_name','student_id','class_id','year_id'];

    public function student(){

        return $this->belongsTo(Student::class,'student_id');
    }


    public function classes(){
        return $this->belongsTo(Classe::class,'class_id');
    }

    public function year(){
        return $this->belongsTo(Year::class,'year_id');
    }
}
