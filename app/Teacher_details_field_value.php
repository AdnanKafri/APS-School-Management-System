<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher_details_field_value extends Model
{

    protected $table='teacher_details_field_values';

    public function teacher_details_department_field() {

        return $this->belongsTo(Teacher_details_department_field::class,'teacher_details_field_id');
    }
    public function teacher() {

        return $this->belongsTo(Teacher::class,'teacher_id');
    }
}
