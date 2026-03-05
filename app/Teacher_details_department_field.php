<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher_details_department_field extends Model
{

    protected $table='teacher_details_department_fields';

    public function teacher_details_department() {

        return $this->belongsTo(Teacher_details_department::class,'teacher_details_department_id');
    }
    public function teacher_details_field_value() {

        return $this->hasMany(Teacher_details_field_value::class,'teacher_details_field_id');
    }
}
