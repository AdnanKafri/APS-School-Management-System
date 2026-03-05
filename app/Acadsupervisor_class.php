<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acadsupervisor_class extends Model
{
    protected $table='acadsupervisor_class';

    protected $fillable = ['supervisor_id','class_id'];
    public $timestamps = false;

}
