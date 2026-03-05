<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faqs_website extends Model
{

    protected $table='faqs_website';

    protected $fillable=['id','title_ar','title_en','description_ar','description_en'];


}
