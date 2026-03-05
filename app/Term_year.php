<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term_year extends Model
{

    protected $table='term_years';
    protected $fillable=['term','year_id','current_term','type'];
    
    public function year(){

        return $this->belongsTo(Year::class,'year_id');
    }

    public function lesson_exam(){

        return $this->hasMany(Room_lesson_exam::class,'term_id','id');


    }
     public function lecture(){

        return $this->belongsTo(Lecture::class,'term_id');
     }
    public function room(){

        return $this->belongsToMany(Room::class,'lesson_teacher_room_term_exam','room_id','lesson_id','term_id','teacher_id');
    }

    public function lesson(){

        return $this->belongsToMany(Lesson::class,'lesson_teacher_room_term_exam','lesson_id','room_id','term_id','teacher_id');
    }

    public function teacher(){

        return $this->belongsToMany(Teacher::class,'lesson_teacher_room_term_exam','teacher_id','lesson_id','term_id','room_id');
    }



    public function student2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'student_id','room_id','lesson_id','teacher_id','term_id');
    }

    public function lesson2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'lesson_id','student_id','room_id','teacher_id','term_id');
    }

    public function room2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
       'room_id','student_id','teacher_id','lesson_id','term_id');
    }

    public function teacher2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'teacher_id','term_id','student_id','room_id','lesson_id');
    }
}
