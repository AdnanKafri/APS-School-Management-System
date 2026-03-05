<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class How_it_works_website extends Model
{

    protected $table='how_it_works_website';

    protected $fillable=['id','title_en','title_ar','description_en','description_ar'];
    
}