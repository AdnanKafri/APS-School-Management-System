<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modification_Request extends Model
{

    protected $table='modification_requests';

    protected $fillable=['id','student_id','phone'];
    public function student()
{
    return $this->belongsTo(Student::class, 'student_id');
}

}