<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vision extends Model
{

    protected $table='vision_mission_website';

    protected $fillable=['id','title_ar','title_en'];


}
