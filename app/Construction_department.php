<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Construction_department extends Model
{
    protected $table='construction_departments';
  
    public function department_detail() {

        return $this->hasMany(Department_detail::class,'construction_department_id');
    }
   

}
