<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable=['name','permissions'];

    public function user(){

        return $this->hasMany(User::class,'role_id');
    }

    public function classes_rooms_roles(){

        return $this->hasMany(Classes_Rooms_Roles::class,'role_id');
    }
    public function classes_room_role_exam(){

        return $this->hasMany(Classes_room_role_exam::class,'role_id');
    }
    public function classe_role_secret_keeper(){

        return $this->hasMany(Classe_role_secret_keeper::class,'role_id');
    }
    
    

    public $timestamps = false;
        public function getPermissionsAttribute($permissions){

        return json_decode($permissions,true);
    }
}
