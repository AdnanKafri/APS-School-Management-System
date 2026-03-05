<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basic_stages_class extends Model
{

    protected $table='basic_stages_classes';

   
    
    public function classes(){
        return $this->belongsTo(Classe::class,'class_id');
    }
    public function stages(){
        return $this->belongsTo(Basic_stage::class,'stage_id');
    }

}
