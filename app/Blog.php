<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
   protected $table='blogs';

   protected $fillable = ['id','title','part1','part2','part3','part4','image1','image2','image3','image4'];
}
