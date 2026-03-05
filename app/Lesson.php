<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table='lessons';
    protected $fillable=['name','name_en','type','class_id',
                        'book1','book2','lang','max_mark','min_mark',
                        'mark_base_subject_id','is_addable','certificate_order'];
    public function student(){
        
        return $this->belongsToMany(Student::class);
        
    }
    
        public function exam_result(){
        
        return $this->hasMany(Exam_result::class,'lesson_id');
        
    }
    
            public function exam_result2(){
        
        return $this->hasMany(Exam_result2::class,'lesson_id');
        
    }
    
                public function medal(){
        
        return $this->hasMany(Medal::class,'lesson_id');
        
    }
    

    public function lesson_exam(){

        return $this->hasMany(Room_lesson_exam::class,'lesson_id','id');

    }
     public function evaluation(){

        return $this->hasMany(Evaluations::class,'lesson_id','id');
    }
       public function unit_analysis(){

        return $this->hasMany(Unit_analysis::class,'lesson_id');
    }
    public function prepare(){

        return $this->hasMany(Prepare::class,'lesson_id');

    }
       public function planification_trimestrielle(){

        return $this->hasMany(Planification_trimestrielle::class,'lesson_id');

    }

    public function classes(){

        return $this->belongsTo(Classe::class,'class_id','id');
    }

    public function teachers(){

        return $this->BelongsToMany(Teacher::class, 'teacher_room_lesson','lesson_id','teacher_id');

    }

    public function rooms(){

        $year=Year::where('current_year','1')->first();

        return $this->BelongsToMany(Room::class,'teacher_room_lesson','lesson_id','room_id')->where('teacher_room_lesson.year_id','=',$year->id);


    }

    public function room(){

        return $this->belongsToMany(Room::class,'lesson_teacher_room_term_exam','room_id','lesson_id');
    }

    public function teacher(){

        return $this->belongsToMany(Teacher::class,'lesson_teacher_room_term_exam','lesson_id','teacher_id');
    }

    public function term(){

        return $this->belongsToMany(Term_year::class,'lesson_teacher_room_term_exam','term_id','lesson_id','room_id','teacher_id');
    }






    public function student2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'student_id','room_id','lesson_id','teacher_id','term_id');
    }

    public function term2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
       'term_id','lesson_id','student_id','teacher_id','room_id');
    }

    public function room2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
       'room_id','student_id','teacher_id','lesson_id','term_id');
    }

    public function teacher2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'teacher_id','term_id','student_id','room_id','lesson_id');
    }



    public function supervisor(){
        return $this->BelongsToMany(Supervisor::class, 'supervisor_class_lesson','lesson_id','supervisor_id');

    }

    public function classes2(){
        return $this->BelongsToMany(Classe::class, 'supervisor_class_lesson','lesson_id','class_id');

    }
      public function classes3(){
          
        return $this->BelongsToMany(Classe::class, 'coordinator_room_lesson','class_id','lesson_id');

    }

    public function lectures() {

        return $this->hasMany(Lecture::class,'lesson_id');
    }
    // مواد الجلاء.
    public function mark_base_subject(){

        return $this->belongsTo(Base_subjects::class,'mark_base_subject_id','id');
    }
 public function base_subject(){

        return $this->belongsTo(Base_subjects::class,'base_subject_id','id');
    }

}
