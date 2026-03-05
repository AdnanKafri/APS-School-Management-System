<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basic_stage extends Model
{

    protected $table='basic_stages';


    public function basic_stages_classes(){
        return $this->hasMany(Basic_stages_class::class,'stage_id');
    }

}
