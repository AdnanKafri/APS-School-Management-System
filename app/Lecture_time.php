<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture_time extends Model
{
    protected $table='lecture_times';

    protected $fillable=['id','name','start_time','end_time','type'];
 public function room() {

        return $this->belongsTo(Room::class,'room_id');
    }

}
