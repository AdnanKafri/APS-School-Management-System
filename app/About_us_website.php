<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About_us_website extends Model
{

    protected $table='about_us_websites';

    protected $fillable=['id','welcome_en','welcome_ar','title_en','title_ar','description_en','description_ar','content_en','content_ar','image'];
    
}