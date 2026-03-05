<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
   
    public function room(){

        return $this->hasMany(Room::class,'year_id','id');
    }

    public function room2(){
        return $this->belongsToMany(Student::class,'room_student','year_id','room_id');
    }

    public function student(){
        return $this->belongsToMany(Student::class,'room_student','year_id','student_id');
    }
    public function term(){
        return $this->hasMany(Term_year::class,'year_id','id');

    }

    public function invoices(){
        return $this->hasMany(Invoice::class,'year_id');
    }
    
      public function coordinator(){
        return $this->belongsToMany(Coordinator_room_lesson::class,'year_id','id');
    }
}
