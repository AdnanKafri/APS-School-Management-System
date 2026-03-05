<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
   protected $table='road';
    protected $fillable=['id','name','lang'];
}
