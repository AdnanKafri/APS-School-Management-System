<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{

    protected $table='stats';

    protected $fillable=['id','name_ar','name_en','ratio'];
    
}
