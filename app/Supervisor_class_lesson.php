<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor_class_lesson extends Model
{
    protected $table='supervisor_class_lesson';

    protected $fillable = ['supervisor_id','lesson_id','class_id','room_id'];
    public $timestamps = true;

}
