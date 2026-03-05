<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Room;
use App\Students_mark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Student extends Authenticatable
{

    protected $table='students';
    protected $fillable=['first_name','last_name','first_name_en','last_name_en','father_name','mother_name','place_birth','date_birth',
    'box_birth','nationality','army_room','age','address',
    'phone','image','email','password','place','religion','transparent','lang','public_record_number'];
    protected $guard='student';

    public function room(){
        return $this->belongsToMany(Room::class,'room_student','student_id','room_id');
    }
    
  public function student()
    {
        return $this->belongsTo(Classe::class, 'student_id');
    }
    public function year(){
        return $this->belongsToMany(Room::class,'room_student','student_id','year_id');
    }

    public function invoices(){
        return $this->hasMany(Invoice::class,'student_id');
    }
    
    
    public function transport_invoices(){
        return $this->hasMany(Transport_invoice::class,'student_id');
    }

  public function message(){

        return $this->hasMany(Message::class,'student_id','id')->where('messages.type', '=', '1')->where('messages.view', '=', '0')->where('teacher_id', Auth::user()->teacher_id);
    }
    public function message_admin(){

        return $this->hasMany(Message::class,'student_id','id')->where('messages.type', '=', '1')->where('messages.view', '=', '0')->where('admin_id','!=', null);
    }
    
      public function messageApi(){

        return $this->hasMany(Message::class,'student_id','id')->where('messages.type', '=', '1')->where('messages.view', '=', '0');
    }
      public function message_admin1(){

        return $this->hasMany(Message::class,'student_id','id')->where('admin_id','!=', null)->orderBy('id', 'ASC');
    }
     public function message1(){

        return $this->hasMany(Message::class,'student_id','id')->orderBy('id', 'ASC');
    }
      public function objection1(){

        return $this->hasMany(Objection::class,'student_id','id')->orderBy('id', 'desc');
    }
      public function objection(){

          return $this->hasMany(Objection::class,'student_id','id')->where('objections.view', '=', '0')->where('teacher_id', Auth::user()->teacher_id);
    }
    

    public function student_mark(){

        return $this->hasMany(Students_mark::class,'student_id','id');
    }

    public function user(){
        return $this->hasOne(User::class,'student_id');
    }

    public function room2(){
        return $this->belongsToMany(Room::class,'Student_lesson_teacher_room_term_exam',
        'room_id','student_id','lesson_id','teacher_id','term_id');
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

    public function exam_result() {

        return $this->hasMany(Exam_result::class,'user_id');
    }
      public function exam_result2() {

        return $this->hasMany(Exam_result2::class,'user_id');
    }

    public function student_lesson_teacher_room_term_exam() {

        return $this->hasMany(Student_lesson_teacher_room_term_exam::class,'student_id');
    }
     public function exams_files() {

        return $this->hasMany(Exam_file::class,'student_id');
    }
    public function details()
    {
        return $this->hasOne(Student_detail::class, 'student_id');
    }
     public function report_card()
    {
        return $this->hasOne(Report_card::class, 'student_id');
    }
    public function images_invoices()
    {
        return $this->hasMany(Image_Invoice::class,'student_id');
    }
    public function modification_request()
    {
        return $this->hasMany(Modification_Request::class,'student_id');
    }
      public function country_currency()
    {
        return $this->belongsTo(Country_currency::class,'country_currency');
    }

    

       public function bus(){

        return $this->belongsTo(Buses::class,'bus_id');
    }
    

}
