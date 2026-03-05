<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe_role_secret_keeper extends Model
{
    protected $table='classe_role_secret_keepers';
  
   
    public function class() {

        return $this->belongsTo(Classe::class,'class_id','id');
    }

}
