<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{

    protected $table='testimonials_website';

    protected $fillable=['id','message','user_name'];


}
