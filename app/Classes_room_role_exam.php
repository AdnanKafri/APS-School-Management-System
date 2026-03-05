<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes_room_role_exam extends Model
{
    protected $table='classes_room_role_exams';
  
    public function room() {

        return $this->belongsTo(Room::class,'room_id','id');
    }
    public function class() {

        return $this->belongsTo(Classe::class,'class_id','id');
    }

}
