<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher_details_department extends Model
{

    protected $table='teacher_details_departments';

    public function teacher_details_department_field() {

        return $this->hasMany(Teacher_details_department_field::class,'teacher_details_department_id');
    }
    
}
