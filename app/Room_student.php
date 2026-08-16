<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room_student extends Model
{
    protected $table="room_student";

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }


}
