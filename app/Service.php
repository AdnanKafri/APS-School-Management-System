<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $table='service_website';

    protected $fillable=['id','title_ar','title_en','description_ar','description_en','image','icon'];


}
