<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image_Invoice extends Model
{
    protected $table='images_invoices';

    protected $fillable=['id','student_id','file','extension'];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
}
