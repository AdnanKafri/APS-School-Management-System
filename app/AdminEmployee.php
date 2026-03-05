<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminEmployee extends Model
{
    protected $table = 'adminemployees';
    protected $fillable = ['first_name','last_name','phone','subDepartment_id'];

    public function subDepartment(){
        return $this->belongsTo(SubDepartment::class,'subDepartment_id');
    }
    
        public function user(){

        return $this->hasOne(User::class,'adminEmployee_id');
    }
}
