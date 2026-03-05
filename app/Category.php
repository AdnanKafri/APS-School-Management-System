<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table='catagories';

    protected $fillable=['id','name_ar','name_en'];
    public function news(){

        return $this->hasMany(News::class,'category_id');
    }

}
