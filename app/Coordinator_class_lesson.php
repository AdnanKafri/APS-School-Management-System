<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinator_class_lesson extends Model
{
    protected $table='coordinator_class_lesson';

    protected $fillable = ['coordinator_id','lesson_id','class_id'];
    public $timestamps = true;

}
