<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_register extends Model
{

    protected $table='student_register';

    protected $guarded = [];

        public function class()
    {
        return $this->belongsTo('App\Classe', 'class1');
    }
}
