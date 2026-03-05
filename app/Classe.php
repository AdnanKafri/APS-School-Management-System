<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Room;
class Classe extends Model
{
    protected $table='classes';
    protected $fillable=['name','image','annual_installment','stage_id','report_card'];
    
    public function classCost()
    {
        return $this->hasMany(Class_cost::class, 'class_id');
    }
 
      public function stages(){
        return $this->belongsToMany(Basic_stage::class,'basic_stages_classes','class_id','stage_id')
        ->select(['basic_stages.id']);
    }   
    public function room(){       

        return $this->hasMany(Room::class,'class_id','id');
    }

    public function lessons(){

        return $this->hasMany(Lesson::class,'class_id','id');
    }

  public function evaluation(){

        return $this->hasMany(Evaluations::class,'class_id','id');
    }

    public function teachers(){

        return $this->belongsToMany(Teacher::class,'teacher_room_lesson','class_id','teacher_id');
    }

    public function invoices(){
        return $this->hasMany(Invoice::class,'class_id');
    }

        public function events(){

        return $this->hasMany(Event::class,'class_id','id');
    }
     public function unit_analysis(){

        return $this->hasMany(Unit_analysis::class,'class_id');
    }
    public function prepare(){

        return $this->hasMany(Prepare::class,'class_id');
    }
    public function planification_trimestrielle(){

        return $this->hasMany(Planification_trimestrielle::class,'class_id');
    }
        public function supervisor(){
        return $this->BelongsToMany(Supervisor::class, 'supervisor_class_lesson','class_id','supervisor_id');

    }
    
     public function coordinator(){
        return $this->BelongsToMany(Coordinator::class, 'coordinator_room_lesson','class_id','coordinator_id');
    }


    public function lessons2(){
        return $this->BelongsToMany(Lesson::class, 'supervisor_class_lesson','class_id','lesson_id');

    }
    public function room2(){
        return $this->BelongsToMany(Room::class, 'supervisor_class_lesson','class_id','room_id')
        ->select(['rooms.id','name']);
    }
    
     public function lessons5(){
        return $this->BelongsToMany(Lesson::class, 'coordinator_room_lesson','class_id','lesson_id')
       ;
       
    }

    public function room_cor(){
        return $this->BelongsToMany(Room::class, 'coordinator_room_lesson','class_id','room_id')
        ->select(['rooms.id','name','rooms.year_id']);
    }
    public function question() {

        return $this->hasMany(Question::class,'class_id');
    }
    public function exam(){

        return $this->hasMany(Lesson_teacher_room_term_exam::class,'class_id');
    }

    public function report_card_details(){

        return $this->hasMany(Report_card_details::class,'class_id');
    }
    public function next_class_success(){

        return $this->hasOne(Classe::class,'id','next_class');
    }
}
