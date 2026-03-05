<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buses;

class Bus_lines extends Model
{
    protected $table = 'bus_lines';
    protected $fillable = ['name','annual_cost'];


    public function buses(){

        return $this->hasMany(Buses::class,'bus_lines_id','id');
    }


}
