<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Student;
use App\Lesson_room_teacher_lecture_time;
class Room extends Model
{
    protected $fillable=['id','name','class_id','year_id'];


    public function student(){
        return $this->belongsToMany(Student::class,'room_student','room_id','student_id');
    }

    public function year2(){
        return $this->belongsToMany(Year::class,'room_student','room_id','year_id');
    }

    public function student_mark(){

        return $this->hasMany(Students_mark::class,'room_id','id');
    }
    public function report_cards(){

        return $this->hasMany(Report_card::class,'room_id','id');
    }
    public function classes(){

        return $this->belongsTo(Classe::class,'class_id');
    }

    public function year(){

        return $this->belongsTo(year::class,'year_id');
    }

    public function lesson_exam(){

        return $this->hasMany(Room_lesson_exam::class,'room_id','id');

    }

    public function teachers(){

        return $this->BelongsToMany(Teacher::class ,'teacher_room_lesson','room_id','teacher_id');

    }

    public function lessons(){

        return $this->BelongsToMany(Lesson::class ,'teacher_room_lesson','room_id','lesson_id');

    }
    
        public function lessons2(){

        return $this->BelongsToMany(Lesson::class ,'teacher_room_lesson','room_id','lesson_id')
        ->select(['lessons.id','name']);

    }

     public function lessons3(){
            return $this->BelongsToMany('App\Lesson' ,'lesson_room_teacher_lecture_time','room_id','lesson_id');
    }

    public function lessons4(){
        return $this->BelongsToMany(Lesson::class, 'supervisor_class_lesson','room_id','lesson_id')
        ->select(['lessons.id','name']);
    }
      public function lessons5(){
        return $this->BelongsToMany(Lesson::class, 'coordinator_room_lesson','room_id','lesson_id','class_id')
        ->select(['lessons.id','name']);
    }


    public function student2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'student_id','room_id','lesson_id','teacher_id','term_id');
    }

    public function lesson2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'lesson_id','student_id','room_id','teacher_id','term_id');
    }

    public function teacher2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'teacher_id','student_id','room_id','lesson_id','term_id');
    }

    public function term2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'term_id','student_id','room_id','lesson_id','teacher_id');
    }


    public function events(){

        return $this->hasMany(Event::class,'class_id','id');
    }
    

}
