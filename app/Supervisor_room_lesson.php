<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor_room_lesson extends Model
{
    protected $table='supervisor_room_lesson';

    protected $fillable = ['supervisor_id','lesson_id','room_id','class_id'];
    public $timestamps = true;

}
