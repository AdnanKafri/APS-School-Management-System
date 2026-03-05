<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus_driver extends Model
{
    protected $table = 'bus_driver';
    protected $fillable = ['name','address','phone','bus_id'];


    public function bus(){

        return $this->belongsTo(Buses::class,'bus_id');
    }


}
