<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Other extends Model
{

    protected $table='other';

    protected $fillable=['id','img','imgn','video'];
    
}