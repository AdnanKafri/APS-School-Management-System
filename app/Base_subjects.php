<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base_subjects extends Model
{
    protected $table='base_subjects';

    protected $fillable=['id','name','type','notes'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class,'base_subject_id');
    }
    
     public function lessons_mark()
    {
        return $this->hasMany(Lesson::class,'mark_base_subject_id');
    }
       public function lessons_mark2()
    {
        return $this->hasOne(Lesson::class,'mark_base_subject_id');
    }
    

}
