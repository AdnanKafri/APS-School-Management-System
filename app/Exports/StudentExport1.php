<?php

namespace App\Exports;

use App\Student;
use App\Year;
use App\Classe;
use App\Room;
use App\Basic_stages_class;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class StudentExport1 implements FromCollection, WithHeadings
{

    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {

        return [

             'رقم التسجيل',
            'الاسم الأول',
            'الكنية',
            'اسم الأب',
            'اسم الأم',
            'تاريخ الولادة',  
            'الهاتف',
            'العنوان',
            'الديانة',
            'اللغة',
            'الايميل',
            'كلمة السر',
            'الصف',
            'الشعبة',
          'رقم تسلسلي',
        ];
    }
    public function collection()
    {

        set_time_limit(100000);
        ini_set("max_execution_time", "-1");
        ini_set('memory_limit','-1');

        $year = Year::where('current_year',1)->first();
        if($this->request->stage == 0 &&  $this->request->classes==0 && $this->request->rooms==0 ){
            $classes_id=[];
            $classes = Classe::all();
            foreach($classes as $classe){
              $classes_id[]= $classe->id; 
            }
          $product = DB::table('students')
      ->join('student_details', 'student_details.student_id', '=', 'students.id')
      ->join('room_student', 'room_student.student_id', '=', 'students.id')
      ->join('users', 'users.student_id', '=', 'students.id')
      ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
      ->join('classes', 'rooms.class_id', '=', 'classes.id')
      ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
      'students.date_birth','student_details.phone','students.address',DB::raw('(CASE
      WHEN students.religion = "0" THEN "مسلم"
      ELSE "مسيحي"
      END) AS religion') , DB::raw('(CASE
      WHEN students.lang = "0" THEN "فرنسي"
      ELSE "روسي"
      END) AS lang') ,DB::raw('(CASE
        WHEN classes.stage_id = 3 THEN (CASE WHEN students.lang = "0" THEN "فرنسي " ELSE "روسي " END)
        ELSE (CASE WHEN students.lang = "0" THEN " " ELSE " " END)
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
      ->where('room_student.year_id',$year->id)
      ->whereIn('classes.id',$classes_id)
      ->get();  
      
      }
        elseif($this->request->classes==0 && $this->request->rooms==0 ){
            $classes_id=[];
              $classes = Basic_stages_class::where('stage_id',$this->request->stage)->get();
              foreach($classes as $classe){
                $classes_id[]= $classe->class_id; 
              }
              
           $product = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN " "
        ELSE " "
        END) AS lang')
        , DB::raw('(CASE
        WHEN classes.stage_id = 3 THEN (CASE WHEN students.lang = "0" THEN "فرنسي " ELSE "روسي " END)
        ELSE (CASE WHEN students.lang = "0" THEN " " ELSE " " END)
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->whereIn('classes.id',$classes_id)
        ->get();
        
        
        
        
        
        }
        elseif($this->request->classes!=0 && $this->request->rooms==0 ){
             $room_id=[];
              $rooms = Room::where('class_id',$this->request->classes)->get();
              foreach($rooms as $room){
                $room_id[]= $room->id; 
              } 
               $classes = Classe::find($this->request->classes);
            
              if($classes->stage_id==3){
                   $product = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN "فرنسي"
        ELSE "روسي"
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->where('classes.id',$this->request->classes)
        ->whereIn('rooms.id',$room_id)

        ->get();
              }
              else{
                   $product = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN " "
        ELSE " "
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->where('classes.id',$this->request->classes)
        ->whereIn('rooms.id',$room_id)

        ->get();
              }
                
       
        }
        else{
        
                $classes = Classe::find($this->request->classes);
            
              if($classes->stage_id==3){
                   $product = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN "فرنسي"
        ELSE "روسي"
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->where('classes.id','like',$this->request->classes)
        ->where('rooms.id','like',$this->request->rooms)

        ->get();
              }
              else{
                   $product = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN " "
        ELSE " "
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->where('classes.id','like',$this->request->classes)
        ->where('rooms.id','like',$this->request->rooms)

        ->get();
              }
             
        
        }
      

        $collect = new Collection;
        $count = 1; // Start the count from 1
        foreach ($product as $item) {
            $item->serial_number = $count; // Add serial number to the item
            $collect->push($item);
            $count++; // Increment the count for each item
        }
        
        return $collect;
    }
}
