<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainDepartment extends Model
{
    protected $table = 'maindepartments';
    protected $fillable = ['name'];

    public function subDepartments(){
        return $this->hasMany(SubDepartment::class,'mainDepartment_id');
    }

    public function administrators(){
        return $this->hasOne(Adminstrator::class,'mainDepartment_id');
    }
}
