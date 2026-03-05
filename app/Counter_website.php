<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Counter_website extends Model
{

    protected $table='counter_website';

    protected $fillable=['id','title_ar','title_en','count'];


}
