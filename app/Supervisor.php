<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table='supervisors';

    protected $fillable=['first_name','last_name','email','date_birth','address','phone','image'];



    public function lessons(){
        return $this->BelongsToMany(Lesson::class, 'supervisor_class_lesson','supervisor_id','lesson_id');

    }

   public function classes(){
        return $this->BelongsToMany(Classe::class, 'supervisor_class_lesson','supervisor_id','class_id')
        ->select(['classes.id','name']);;
    }

    public function user(){

        return $this->hasOne(User::class,'supervisor_id');
    }
    
}
