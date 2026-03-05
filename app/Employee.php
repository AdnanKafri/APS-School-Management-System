<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table='employees';
    
        protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
