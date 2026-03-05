<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country_currency extends Model
{
     protected $table='countries_currencies';
     protected $fillable=['id','name_ar','name_en','key_country','currency_country'];
    // Relationships
    public function classCost()
{
    return $this->hasOne(Class_cost::class, 'country_id');
}
}