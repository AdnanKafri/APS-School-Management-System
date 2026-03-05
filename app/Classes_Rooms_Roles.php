<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes_Rooms_Roles extends Model
{
    protected $table='classes_rooms_roles';
    protected $fillable=['id','class_id','room_id','user_id','roles'];
    public function room() {

        return $this->belongsTo(Room::class,'room_id','id');
    }
    public function class() {

        return $this->belongsTo(Classe::class,'class_id','id');
    }

}
