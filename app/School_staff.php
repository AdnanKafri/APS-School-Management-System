<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School_staff extends Model
{
    protected $table='school_stafs';
        protected $fillable=['first_name','last_name','birth_date','address','phone','image','salary','cv','business_register','diseases'];


}
