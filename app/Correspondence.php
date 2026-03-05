<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correspondence extends Model
{
    protected $table = 'correspondences';
    protected $fillable = ['message','adminEmployeeSender_id','adminEmployeeRecv_id','adminSender_id','adminRecv_id','is_availableSender','is_availableRecv','is_done'];

    public function adminEmployeeSender(){

        return $this->belongsTo(Adminemployee::class,'adminEmployeeSender_id');
    }


    public function adminEmployeeRecv(){

        return $this->belongsTo(Adminemployee::class,'adminEmployeeSender_id');
    }


    public function adminSender(){

        return $this->belongsTo(Adminemployee::class,'adminSender_id');
    }


    public function adminRecv(){

        return $this->belongsTo(Adminemployee::class,'adminRecv_id');
    }



}
