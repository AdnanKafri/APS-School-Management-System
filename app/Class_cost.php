<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Class_cost extends Model
{
    protected $table = 'class_cost';
    protected $fillable=['id','class_id','country_id','cost'];

    public function class()
    {
        return $this->hasMany(Classe::class, 'class_id');
    }

    public function country_currency()
{
    return $this->belongsTo(Country_currency::class, 'country_id');
}

}


