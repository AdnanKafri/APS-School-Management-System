<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department_detail extends Model
{
    protected $table='department_details';
  
    public function construction_department() {

        return $this->belongsTo(Construction_department::class,'construction_department_id');
    }
   

}
