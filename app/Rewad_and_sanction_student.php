<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rewad_and_sanction_student extends Model
{

    protected $table='rewad_and_sanction_students';

    public function rewad_and_sanction(){

        return $this->belongsTo(Rewards_and_sanction::class,'rewad_and_sanction_id');
    }
    public function student(){

        return $this->belongsTo(Student::class,'student_id');
    }
    public function lesson(){

        return $this->belongsTo(Lesson::class,'lesson_id');
    }
    public function teacher(){

        return $this->belongsTo(Teacher::class,'teacher_id');
    }
    public function room(){

        return $this->belongsTo(Room::class,'room_id');
    }
    


}
