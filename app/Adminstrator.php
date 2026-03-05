<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adminstrator extends Model
{
    protected $table = 'adminstrators';
    protected $fillable = ['first_name','last_name','phone','mainDepartment_id'];

    public function mainDepartment(){
        return $this->belongsTo(MainDepartment::class,'mainDepartment_id');
    }
    
        public function user(){
 
        return $this->hasOne(User::class,'adminstrator_id');
    }
}
