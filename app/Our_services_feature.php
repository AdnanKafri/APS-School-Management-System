<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Our_services_feature extends Model
{

    protected $table='our_services_feature_website';

    protected $fillable=['id','title_ar','title_en','description_ar','description_en','image'];


}
