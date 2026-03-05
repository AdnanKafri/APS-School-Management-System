<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_details_department extends Model
{

    protected $table='student_details_departments';

    public function student_details_department_field() {

        return $this->hasMany(Student_details_department_field::class,'student_details_department_id');
    }
}
