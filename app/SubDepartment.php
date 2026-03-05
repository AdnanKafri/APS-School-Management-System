<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    protected $table = 'subdepartments';
    protected $fillable = ['name','mainDepartment_id'];

    public function mainDepartment(){
        return $this->belongsTo(MainDepartment::class,'mainDepartment_id');
    }

    public function adminEmployees(){
        return $this->hasMany(AdminEmployee::class,'subDepartment_id');
    }

}
