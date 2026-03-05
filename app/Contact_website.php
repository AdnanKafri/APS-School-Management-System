<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact_website extends Model
{
    protected $table='contact_website';

    protected $fillable=['id','name','subject','phone','email','message'];
}
