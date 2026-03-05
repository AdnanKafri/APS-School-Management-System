<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advantages extends Model
{

    protected $table='advantages';

    protected $fillable=['id','title_en','title_ar','img','text_en','text_ar'];
    
}
