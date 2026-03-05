<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class class_room_student extends Model
{
    protected $table='class_room_student';
    protected $fillable=['id','class_id','room_id','student_id'];
}
