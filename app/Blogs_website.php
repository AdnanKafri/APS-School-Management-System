<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blogs_website extends Model
{

    protected $table='blogs_website';

    protected $fillable=['id','title_ar','title_en','description_ar','description_en','image'];


}
