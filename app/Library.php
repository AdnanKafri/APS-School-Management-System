<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{

    protected $table='library';

    protected $fillable=['id','class_id','teacher_id','name','file','type','extension'];
    
    public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id')->select(['id','first_name','last_name']);
    }
    public function classe(){
        return $this->belongsTo(Classe::class,'class_id')->select(['id','name']);
    }

}
