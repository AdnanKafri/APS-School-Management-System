<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{

    protected $table='stages';

    protected $fillable=['id','name','notes'];
    
    public function classes(){
        return $this->hasMany(Classe::class,'stage_id');
    }

}
