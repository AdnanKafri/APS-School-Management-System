<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acadsupervisor extends Model
{
    protected $table='acadsupervisors';

    protected $fillable=['first_name','last_name','email','date_birth','address','phone','image'];



    public function lessons(){
        return $this->BelongsToMany(Lesson::class, 'supervisor_class_lesson','supervisor_id','lesson_id');

    }

    public function classes(){
        return $this->BelongsToMany(Classe::class, 'acadsupervisor_class','supervisor_id','class_id');

    }


    public function user(){

        return $this->hasOne(User::class,'acadsupervisor_id');
    }
}
