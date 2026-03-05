<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table= 'group';

    protected $fillable = ['first_name_ar','first_name_en','last_name_ar','last_name_en','type'];

}
