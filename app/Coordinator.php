<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coordinator extends Model
{
    protected $table='coordinators';
    protected $fillable=['id','first_name','last_name','date_birth','age','email','address','phone','image'];

    public function exam(){

        return $this->hasMany(Exams2::class,'user_id','id');

    }
     public function evaluation(){

        return $this->hasMany(Evaluations::class,'coor_id','id');
    }

// I havent't followed this relation so it might'nt be neccesary;
    public function lesson_exam(){

        return $this->hasMany(Room_lesson_exam::class,'coordinator_id','id');

    }

    // public function classes(){

    //     return $this->BelongsToMany(Room::class , 'coordinator_class_lesson','coordinator_id','class_id');

    // }

    // public function lessons(){
    //     return $this->BelongsToMany(Lesson::class , 'coordinator_class_lesson','coordinator_id','lesson_id');
    // }
     public function classes(){

        return $this->BelongsToMany(Classe::class , 'coordinator_room_lesson','coordinator_id','class_id')
        ->select(['classes.id','name']);

    }

    public function lessons(){
        return $this->BelongsToMany(Lesson::class , 'coordinator_class_lesson','coordinator_id','class_id','room_id','lesson_id');
    }

    public function user(){

        return $this->hasOne(User::class,'coordinator_id');
    }




    // public function room(){

    //     return $this->belongsToMany(Room::class,'lesson_teacher_room_term_exam','room_id','lesson_id','term_id','teacher_id');
    // }

    // public function lesson(){

    //     return $this->belongsToMany(Lesson::class,'lesson_teacher_room_term_exam','lesson_id','term_id','term_id','teacher_id');
    // }

    // public function term(){

    //     return $this->belongsToMany(Term_year::class,'lesson_teacher_room_term_exam','term_id','lesson_id','term_id','teacher_id');
    // }



    // public function student2(){
    //     return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
    //     'student_id','room_id','lesson_id','teacher_id','term_id');
    // }

    // public function lesson2(){
    //     return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
    //     'lesson_id','student_id','room_id','teacher_id','term_id');
    // }

    // public function room2(){
    //     return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
    //   'room_id','student_id','teacher_id','lesson_id','term_id');
    // }

    // public function term2(){
    //     return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
    //     'term_id','student_id','room_id','lesson_id','teacher_id');
    // }

    // public function classes(){

    //     return $this->belongsToMany(Classe::class,'coordinator_room_lesson','coordinator_id','class_id');
    // }

}
