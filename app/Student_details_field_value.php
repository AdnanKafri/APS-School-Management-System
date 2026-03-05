<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_details_field_value extends Model
{

    protected $table='student_details_field_values';

    public function student_details_department_field() {

        return $this->belongsTo(Student_details_department_field::class,'student_details_field_id');
    }
    public function student() {

        return $this->belongsTo(Student::class,'student_id');
    }
}
