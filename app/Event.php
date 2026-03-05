<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
        protected $dates = ['start_time','end_time'];


    protected $table='events';

    protected $fillable= ['id','header','content','image','start_time','end_time'];
}
