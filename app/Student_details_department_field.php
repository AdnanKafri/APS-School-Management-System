<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_details_department_field extends Model
{

    protected $table='student_details_department_fields';

    public function student_details_department() {

        return $this->belongsTo(Student_details_department::class,'student_details_department_id');
    }
    public function student_details_field_value() {

        return $this->hasMany(Student_details_field_value::class,'student_details_field_id');
    }
}
