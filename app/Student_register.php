<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_register extends Model
{

    protected $table='student_register';

    protected $fillable=['id','	first_name','last_name','email','date','country','phone','fateher_name','fateher_phone','mather_name','mather_phone','personal_image','	mother_image','father image','fourth_image','class1'];

        public function class()
    {
        return $this->belongsTo('App\Classe', 'class1');
    }
}
