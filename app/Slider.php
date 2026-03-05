<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    protected $table='sliders_home_website';

    protected $fillable=['id','image1','image2','image3','image4','header','content'];


}
