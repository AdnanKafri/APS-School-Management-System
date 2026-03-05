<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $table= 'footer';

    protected $fillable = ['content_ar','content_en','email','address_ar','address_en','phone','facebook','twitter','google','instgram'];

}
