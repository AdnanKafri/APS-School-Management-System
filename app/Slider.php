<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    protected $table='sliders_home_website';

    protected $fillable = [
        'header_ar',
        'header_en',
        'content_ar',
        'content_en',
        'key_word_ar',
        'key_word_en',
        'image',
    ];


}
