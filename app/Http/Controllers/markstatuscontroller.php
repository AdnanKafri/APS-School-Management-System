<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Lesson;
use App\Room;
use App\Student;
use App\Teacher;
use App\Teacher_room_lesson;
use App\Term_year;
use App\Year;
use Illuminate\Http\Request;
use App\Messages_super;

class markstatuscontroller extends Controller
{


    public function classes_lessons2($teacher_id)
    {


        $year=Year::where('current_year','1')->first();

        $teacher = Teacher::with(['rooms'=>fn($q1)=>$q1->where('rooms.year_id',$year->id)])->find($teacher_id);

        $classes = [];


        // return $teacher ;
        foreach ($teacher->rooms as $item) {

            $classes[] = $item->classes;
        }
        $classes = array_unique($classes);

        $terms = Term_year::all();

        $lessons = Lesson::all();
        
 
        $count=Messages_super::whereNull('view')->where('teacher_id',auth()->user()->teacher_id)->get();
        $count=$count->count();
        
        return view('teachers.classes_lessons2', compact('classes', 'teacher','count', 'terms', 'lessons'));
    }



    public function teacher_rooms3($class_id, $teacher_id)
    {

        $year=Year::where('current_year','1')->first();

        $classes=Classe::with(['room'=>fn($q1)=>$q1->where('rooms.year_id',$year->id)])->find($class_id);
        $rooms=$classes->room;
$rooms1=[];
foreach($rooms as $room){

$a=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room->id)->first();
if($a!=null){
    $rooms1[]=$a;

}

}

$rooms1=array_unique($rooms1);

$rooms2=[];
foreach($rooms1 as $room1){

$rooms2[]=Room::find($room1->room_id);

}


$rooms2=array_unique($rooms2);

        $lessons = [];
        foreach ($rooms as $item) {
            if (count($item->teachers) > 0) {

                foreach ($item->teachers[0]->lessons as $item2) {

                    $lessons[] = $item2;
                }
            }
        }
        $lessons = array_unique($lessons);



        $teacher = Teacher::find($teacher_id);
        $rooms = $teacher->rooms;

        $class_rooms = [];
        foreach ($rooms as $room) {

            $class_rooms[] = $room->where('class_id', $class_id)->get();
        }
        $class_rooms = array_unique($class_rooms);

        $terms = Term_year::all();


        $count=Messages_super::whereNull('view')->where('teacher_id',auth()->user()->teacher_id)->get();
        $count=$count->count();
        
        return view('teachers.rooms3', compact('rooms2', 'class_id', 'terms', 'teacher', 'lessons','count'));
    }



    public function teacher_lessons4($room_id, $teacher_id)
    {

        $teacher = Teacher::find($teacher_id);
        $lessons = $teacher->lessons;
        $room_lessons = [];
        $teacher_room_lessons = Teacher_room_lesson::where('room_id', $room_id)->where('teacher_id', $teacher_id)->get();
        $teacher_lessons = [];
        foreach ($teacher_room_lessons as $teacher_room_lesson) {

            $teacher_lessons[] = Lesson::find($teacher_room_lesson->lesson_id);
        }
        
        
        $count=Messages_super::whereNull('view')->where('teacher_id',auth()->user()->teacher_id)->get();
        $count=$count->count();
        
        return view('teachers.lessons4', compact('teacher_lessons', 'teacher', 'room_id','count'));
    }


    public function quize_active($teacher_id,$room_id,$lesson_id){

        $year=Year::where('current_year','1')->first();


        $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
         $mark_status->quize_status = '1';

         $mark_status->save();
return redirect()->back()->with('success','تم إصدار نتائج المذاكرات بنجاح !');


    }


    // =================================================

    public function quize_disable($teacher_id,$room_id,$lesson_id){

        $year=Year::where('current_year','1')->first();


        $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
         $mark_status->quize_status = '0';

         $mark_status->save();

       return redirect()->back()->with('success','تم اخفاء نتائج المذاكرات بنجاح !');


    }




 // =========================================================


 public function oral_active($teacher_id,$room_id,$lesson_id){
    $year=Year::where('current_year','1')->first();


    $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
     $mark_status->oral_status = '1';

     $mark_status->save();

   return redirect()->back()->with('success','تم إصدار نتائج الشفهي بنجاح !');


       }


       // =================================================

       public function oral_disable($teacher_id,$room_id,$lesson_id){
 
        $year=Year::where('current_year','1')->first();


        $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
         $mark_status->oral_status = '0';
         $mark_status->save();

          return redirect()->back()->with('success','تم اخفاء نتائج الشفهي بنجاح !');


       }


// =====================================================




public function activity_active($teacher_id,$room_id,$lesson_id){


    $year=Year::where('current_year','1')->first();


    $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
     $mark_status->activity_status = '1';

     $mark_status->save();

   return redirect()->back()->with('success','تم إصدار نتائج النشاط  بنجاح !');


       }


       // =================================================

       public function activity_disable($teacher_id,$room_id,$lesson_id){


        $year=Year::where('current_year','1')->first();


        $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
         $mark_status->activity_status = '0';
         $mark_status->save();

          return redirect()->back()->with('success','تم اخفاء نتائج المذاكرات بنجاح !');


       }






       // =====================================================




public function homework_active($teacher_id,$room_id,$lesson_id){


    $year=Year::where('current_year','1')->first();


    $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
     $mark_status->homework_status = '1';
     $mark_status->save();

   return redirect()->back()->with('success','تم إصدار نتائج الوظائف بنجاح !');


       }


       // =================================================

       public function homework_disable($teacher_id,$room_id,$lesson_id){



        $year=Year::where('current_year','1')->first();


        $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
         $mark_status->homework_status = '0';
         $mark_status->save();


          return redirect()->back()->with('success','تم اخفاء نتائج الوظائف بنجاح !');


       }






       // =====================================================




public function exam_active($teacher_id,$room_id,$lesson_id){



    $year=Year::where('current_year','1')->first();


    $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
     $mark_status->exam_status = '1';
     $mark_status->save();

   return redirect()->back()->with('success','تم إصدار نتائج الامتحان الفصلي بنجاح !');


       }


       // =================================================

       public function exam_disable($teacher_id,$room_id,$lesson_id){

        $year=Year::where('current_year','1')->first();


        $mark_status=Teacher_room_lesson::where('teacher_id',$teacher_id)->where('room_id',$room_id)->where('lesson_id',$lesson_id)->where('year_id',$year->id)->first();
         $mark_status->exam_status = '0';
         $mark_status->save();

          return redirect()->back()->with('success','تم اخفاء نتائج الامتحان الفصلي بنجاح !');


       }




}
