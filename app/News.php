<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table='news';


    protected $fillable=['id','image1','image2','image3','image4','header1','content1','header2',
    'content2','header3','content3','header4','content4','category_id'];
     public function category(){

        return $this->belongsTo(Category::class,'category_id');
    }

}
