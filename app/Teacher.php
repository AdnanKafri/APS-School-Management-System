<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    protected $table='teachers';
    protected $fillable=['id','first_name','last_name','date_birth','age','email','address','contract','vcation_days','lesson_name','phone','image','salary'];

    public function exam(){
  
        return $this->hasMany(Exam::class,'teacher_id','id');

    }
public function evaluation(){

        return $this->hasMany(Evaluations::class,'teacher_id','id');
    }
    public function lesson_exam(){

        return $this->hasMany(Room_lesson_exam::class,'teacher_id','id');

    }

    public function rooms(){

        return $this->BelongsToMany(Room::class , 'teacher_room_lesson','teacher_id','room_id');

    }

    public function lessons(){

        $year=Year::where('current_year','1')->first();
        return $this->BelongsToMany(Lesson::class , 'teacher_room_lesson','teacher_id','lesson_id')->where('teacher_room_lesson.year_id','=',$year->id);

    }

    public function user(){

        return $this->hasOne(User::class,'teacher_id');
    }
   public function lecture(){

        return $this->hasMany(Lecture::class,'teacher_id');
    }



    public function room(){

        return $this->belongsToMany(Room::class,'lesson_teacher_room_term_exam','room_id','lesson_id','term_id','teacher_id');
    }

    public function lesson(){

        return $this->belongsToMany(Lesson::class,'lesson_teacher_room_term_exam','lesson_id','term_id','term_id','teacher_id');
    }

    public function term(){

        return $this->belongsToMany(Term_year::class,'lesson_teacher_room_term_exam','term_id','lesson_id','term_id','teacher_id');
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

    public function term2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'term_id','student_id','room_id','lesson_id','teacher_id');
    }

    public function classes(){

        return $this->belongsToMany(Classe::class,'teacher_room_lesson','teacher_id','class_id');
    }
    
            public function lecture_time(){

        return $this->hasMany(Lesson_room_teacher_lecture_time::class,'teacher_id');
    }
    

}
