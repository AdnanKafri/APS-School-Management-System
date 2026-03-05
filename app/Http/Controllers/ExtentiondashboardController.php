<?php

namespace App\Http\Controllers;

use File;
use ZipArchive as A;
 
use App\Message;
use App\Room;
use Illuminate\Support\Facades\Auth;
use App\Other;
use App\More_details;
use App\Room_student;
use App\Student;
use App\Student_vaccine;
use App\Student_lesson_teacher_room_term_exam;
use App\Students_mark;
 
 
use App\Teacher;
use App\Teacher_room_lesson;
 
 use App\Year;
 
use App\News;
use Carbon\Carbon;
use stdClass;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
 
use App\Advantages;
use App\Student_detail;
use App\Student_register;
 

use App\Http\Controllers\DashboardController;

class ExtentiondashboardController extends Controller
{
    
    
    
 
    
    public function student_vaccines($student_id){
     $year=Year::where('current_year','1')->first();
    $student=Student::find($student_id);
 
 

   $student_vaccines=Student_vaccine::where('student_id',$student_id)->first();

 
     return view('admin.student_vaccines',compact('student','student_vaccines' ));

}


    public function student_vaccines_update(Request $request ,$student_id){
         
         $student=Student::find($student_id);
  
        $before_vaccines=[];
        $current_vaccines=[];
        $current_illness=[];
        $old_illness=[];
        if($request->vaccines_name){
            for($i=0;$i<count($request->vaccines_name); $i++){
               $std= new stdClass();
               $std->{'vaccines_name'}=$request->vaccines_name[$i];
          
              $before_vaccines[$i]=$std;
            } 
        }
       
        if($request->vaccines_current_name){ 
             for($i=0;$i<count($request->vaccines_current_name); $i++){
                $std= new stdClass();
                $std->{'vaccines_current_name'}=$request->vaccines_current_name[$i];
                $std->{'date'}=$request->date[$i];
                $std->{'doctor'}=$request->doctor[$i];
                $current_vaccines[$i]=$std;
     
         }
         
        }
         if($request->date_illness){  
             for($i=0;$i<count($request->date_illness); $i++){
                $std= new stdClass();
                $std->{'date_illness'}=$request->date_illness[$i];
                $std->{'diagnosis'}=$request->diagnosis[$i];
                $std->{'break_duration'}=$request->break_duration[$i];
                 $std->{'treatment'}=$request->treatment[$i];
                $std->{'other_options'}=$request->other_options[$i];
                $current_illness[$i]=$std;
     
            }
         } 
         
         
                  if($request->old_illness_name){  
             for($i=0;$i<count($request->old_illness_name); $i++){
                $std= new stdClass();
                $std->{'old_illness_name'}=$request->old_illness_name[$i];
                $std->{'old_illness_description'}=$request->old_illness_description[$i];
                  $std->{'old_illness_treatment'}=$request->old_illness_treatment[$i];
                                  $std->{'date_old_illness'}=$request->date_old_illness[$i];

                 $old_illness[$i]=$std;
     
            }
         } 
    $student_vaccines=Student_vaccine::where('student_id',$request->student_id)->first();
 
 if(!$student_vaccines){
      $student_vaccines=new Student_vaccine;

 } 
 
 $student_vaccines->student_id=$request->student_id;
 $student_vaccines->before_vaccines=json_encode($before_vaccines);
 $student_vaccines->current_vaccines=json_encode($current_vaccines);
 $student_vaccines->current_illness=json_encode($current_illness);
 $student_vaccines->old_illness=json_encode($old_illness);
  $student_vaccines->save();
 return redirect()->back()->with('success', 'تم التخزين بنجاح');

}
//ترقين قيد 
 public function archived_students_section()
    {
        $year2 = Year::where('current_year','1')->first();
        $years = Year::all();
        $classes = Classe::all();
        return view('admin.archived_students_section',compact('year2','classes','years'));
    }

 
        

}
