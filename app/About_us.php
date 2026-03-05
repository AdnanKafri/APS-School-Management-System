<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About_us extends Model
{

    protected $table='about_us';

    protected $fillable=['id','time_zone','header','content','vission','mission','objective','services','welcome_en','title_en','description_en','content_en'];
    
}