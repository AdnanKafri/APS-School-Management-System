<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Footer_website extends Model
{

    protected $table='footer_website';

    protected $fillable=['id','title_ar','title_en','content_ar','content_en','address_ar','address_en','phone','email','facebook','twitter','linkedin','instgram','whatsApp'];


}
