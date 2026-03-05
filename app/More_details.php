<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class More_details extends Model
{

    protected $table='more_details';

  protected $fillable=['id','titl_ar','titl_en','text_ar','text_en'];
    
}