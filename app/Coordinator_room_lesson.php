<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinator_room_lesson extends Model
{
    protected $table='coordinator_room_lesson';

    protected $fillable = ['coordinator_id','lesson_id','room_id','class_id'];
    public $timestamps = true;
    
     public function year(){
        return $this->belongsTo(year::class,'year_id');
    }


}
