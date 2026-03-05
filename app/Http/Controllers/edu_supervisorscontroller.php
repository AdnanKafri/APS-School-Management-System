<?php

namespace App\Http\Controllers;


use App\Classe;
use App\Lesson;
use App\Lesson_teacher_room_term_exam;
use App\Message;
use App\Messages_super;
use App\Room;
use App\Student;
use App\Student_lesson_teacher_room_term_exam;
use App\Students_mark;
use App\Supervisor;
use App\Teacher;
use App\User;
use App\Year;
use App\Supervisor_teacher_item;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class supervisorscontroller extends Controller
{

        public function __construct()
    {
        $this->middleware(function($request,$next){
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('warning')) {
                Alert::warning(session('warning'));
            }

            return $next($request);
        });
    }


   public function dashboard_supervisor() {

     $supervisor_id = Auth::user()->supervisor_id;
    $supervisor = Supervisor::find($supervisor_id);
    $year=Year::where('current_year','1')->first();

     return view('educational_supervisors.edu_supervisor_index', compact('supervisor'));
   }


   public function update_profile(Request $request, $supervisor_id)
   {
       $supervisor = Supervisor::find($supervisor_id);

       if ($request->image != null) {
           Storage::disk('public')->delete($supervisor->image);
           $supervisor->image = $request->image->store('filessupervisors', 'public');
       }

       $supervisor->save();
       return redirect()->back()->with('success', '! تمت العملية بنجاح ');
   }


   public function update_password(Request $request, $supervisor_id)
   {

       // return $teacher_id;
       $user = User::find($supervisor_id);
       // return $user;

       $this->validate($request, [
           'old_password'          => 'required',
           'password'              => 'required|min:4',
           'password_confirmation' => 'required|same:password'
       ]);
       if (Hash::check($request->old_password, $user->password)) {

           $user->password = Hash::make($request->password);
           $user->view_password = $request->password;

           $user->save();
       } else {
           return redirect()->back()->with('warning', '! كلمة المرور القديمة خاطئة');
       }


       return redirect()->back()->with('success', '! تمت العملية بنجاح ');
   }


   public function classes($supervisor_id) {

    $supervisor= Supervisor::find($supervisor_id);
    $classes=$supervisor->classes()->orderBy('id')->get()->unique();
    return view('supervisors.classes', compact('classes', 'supervisor'));

}

public function class_lessons($class_id) {
    $supervisor= Supervisor::find(auth()->user()->supervisor_id);
    $classes=$supervisor->classes()->orderBy('id')->get()->unique();
$lessons= $classes->where('id',$class_id)->first()->lessons2->unique();

return view('supervisors.lessons', compact('lessons', 'supervisor','class_id'));


}
public function lesson_rooms($class_id,$lesson_id) {
    $supervisor= Supervisor::find(auth()->user()->supervisor_id);

    $rooms=Classe::find($class_id)->room;

    return view('supervisors.rooms', compact('rooms', 'supervisor','lesson_id'));

}

public function book_details($lesson_id, $room_id)
{
    $supervisor= Supervisor::find(auth()->user()->supervisor_id);


    // $teacher = Teacher::find($teacher_id);
    $book_details = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)
        ->where('room_id', $room_id)->orderBy("id",'desc')->get();

    $lesson = Lesson::find($lesson_id);
    $teacher= $lesson->teachers()->where('teacher_room_lesson.room_id',$room_id)->get()->unique();


       $videos = $book_details->where('type', '0');
    $tests = $book_details->where('type', '1');
    $quizes = $book_details->where('type', '2');
    $exams = $book_details->where('type', '3');
    $additions = $book_details->where('type', '4');

    $date = new DateTime();
    $now = $date->format('Y-m-d H:i:s');

// $now=Carbon::now();

    // return $now;
 $class=Room::find($room_id)->classes;
$room=Room::find($room_id);
 return view('supervisors.book_details', compact(
        'supervisor',
        'now',
        'room_id',
        'lesson',
        'book_details',
        'videos',
        'tests',
        'quizes',
        'exams',
        'additions',
        'class',
        'teacher',
        'room'

    ));
}


public function file_answers($file_id, $lesson_id, $room_id)
{
    $supervisor= Supervisor::find(auth()->user()->supervisor_id);

    $answers = Student_lesson_teacher_room_term_exam::where('file_id', $file_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->get();
    $room = Room::find($room_id);
    $students = $room->student;

     return view('supervisors.answers', compact('answers', 'supervisor', 'students'));
}


    public function StudentsRoomLesson($room_id, $teacher_id, $lesson_id)
    {
    $supervisor= Supervisor::find(auth()->user()->supervisor_id);

    $year=Year::where('current_year','1')->first();

$lesson=Lesson::find($lesson_id);
    $teacher = Teacher::find($teacher_id);

    $room = Room::find($room_id);



    if ($lesson->lang!=null){
        $students = $room->student()->where('lang',$lesson->lang)->get();


    }




if($lesson->religion!=null){

      $students = $room->student()->where('students.religion',$lesson->religion);

}


if($lesson->religion==null && $lesson->lang==null) {

    $students = $room->student;

}



    $students=Room::with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])->find($room_id);

    if ($lesson->lang=='1') {
        $students=$students->student()->where('students.lang','1')->orderBy('first_name')->get();

    }elseif($lesson->lang=='0') {

        $students=$students->student()->where('students.lang','0')->orderBy('first_name')->get();

    }elseif($lesson->religion=='1') {
        $students=$students->student()->where('students.religion','1')->orderBy('first_name')->get();

    }elseif($lesson->religion=='0') {

        $students=$students->student()->where('students.religion','0')->orderBy('first_name')->get();

    }
    else{

        $students=$students->student()->orderBy('first_name')->get() ;

    }



    if(! $students->count() > 0 ) {

        return redirect()->back()->with('warning','! لا يوجد طلاب');
    }



    return view('supervisors.students', compact('students', 'teacher','supervisor' ,'lesson_id', 'room_id'));
}




public function classes2($supervisor_id) {

    $supervisor= Supervisor::find($supervisor_id);
    $classes=$supervisor->classes()->orderBy('id')->get()->unique();
    return view('supervisors.classes2', compact('classes', 'supervisor'));

}

public function class_rooms($class_id) {

    $supervisor= Supervisor::find(auth()->user()->supervisor_id);

    $rooms=Classe::find($class_id)->room;

    return view('supervisors.class_rooms', compact('rooms', 'supervisor'));

}

public function students_rooms($room_id) {

    $supervisor= Supervisor::find(auth()->user()->supervisor_id);

    $rooms=Room::find($room_id);

    $students= $rooms->student()->orderBy('first_name')->get();

    return view('supervisors.students_rooms',compact('students','supervisor'));
}

public function student_results($student_id) {

    $year=Year::where('current_year','1')->first();
    $supervisor= Supervisor::find(auth()->user()->supervisor_id);

    $student=Student::with(['room'=>fn($q1)=>$q1->where('room_student.year_id',$year->id)])->find($student_id);

    $room=$student->room;

    $student_mark=null;

        $student_mark=Students_mark::where('student_id',$student_id)
        ->where('room_id',$room[0]->id)->where('year_id',$year->id)->first();


    $lessons=  $room[0]->classes->lessons;

            $count=Message::whereNull('view')->where('student_id',auth()->user()->student_id)->get();

            $count=$count->count();


$room=$student->room()->where('rooms.year_id',$year->id)->first();
$class=$room->classes;


return view('supervisors.student_results',compact('student_mark','student','class','room','count','lessons','supervisor'));


}


public function teachers($supervisor_id){

    $supervisor = Supervisor::find($supervisor_id);
    $year=Year::where('current_year','1')->first();

    $classes=$supervisor->classes->unique();
     // $rooms=Teacher::with(['rooms.student'=>fn($q1)=>$q1->where('room_student.year_id',$year->id)])->find($teacher_id);

    // $classes=[];
    // foreach ($rooms->rooms as $item) {

    //     $classes[]=$item->classes;

    // }
    // $classes=collect($classes);
    // $classes= $classes->unique();

    return view('supervisors.supervisors_teacher',compact('classes','supervisor'));

}

public function class_lessons2($class_id) {

    $supervisor= Supervisor::find(auth()->user()->supervisor_id);
    $classes=$supervisor->classes()->orderBy('id')->get()->unique();
$lessons= $classes->where('id',$class_id)->first()->lessons2->unique();

return $lessons;

}

public function lesson_teachers($lesson_id) {

    $teachers=Lesson::find($lesson_id)->teachers->unique();
    return $teachers;

}

public function write_message($teacher_id) {


    $teacher = Teacher::find($teacher_id);
    $supervisor=Supervisor::find(auth()->user()->supervisor_id);

    return view('supervisors.write_message',compact('supervisor','teacher'));

}

public function send_message($teacher_id,Request $request) {


    $year=Year::where('current_year' , '1')->first();
    $message = new Messages_super;
    $message->year_id = $year->id;
    $message->teacher_id = $teacher_id;
    $message->supervisor_id = auth()->user()->supervisor_id;
    $message->message= $request->message;
    $message->save();

    session()->flash('success','تمت العملية بنجاح ');

    return redirect()->back()->with('success',' تمت العملية بنجاح ');

}

public function write_group_message($lesson_id){

    $teachers=Lesson::find($lesson_id)->teachers->unique();
    $supervisor=Supervisor::find(auth()->user()->supervisor_id);

   return view('supervisors.write_group_message',compact('teachers','lesson_id','supervisor'));

}

public function send_group_message($lesson_id, Request $request) {

    $teachers=Lesson::find($lesson_id)->teachers->unique();

    $year=Year::where('current_year' , '1')->first();
 foreach ($teachers as $item) {

$message = new Messages_super;
$message->year_id = $year->id;
$message->teacher_id = $item->id;
$message->message= $request->message;
$message->supervisor_id = auth()->user()->supervisor_id;

$message->save();

}
session()->flash('success','تمت العملية بنجاح ');

return redirect()->back()->with('success',' تمت العملية بنجاح ');

}



public function teachers2(){

    $supervisor = Supervisor::find(auth()->user()->supervisor_id);
    $year=Year::where('current_year','1')->first();

    $classes=$supervisor->classes->unique();

    return view('supervisors.supervisor_teachers2',compact('classes','supervisor'));

}

public function send_item($teacher_id,$lesson_id) {


    $teacher = Teacher::find($teacher_id);
    $supervisor=Supervisor::find(auth()->user()->supervisor_id);
    $lesson=Lesson::find($lesson_id);
    return view('supervisors.send_item',compact('supervisor','teacher','lesson_id','lesson'));

}



public function store_item(Request $request) {

    $lesson= Lesson::find($request->lesson_id);
     $year=Year::where('current_year' , '1')->first();
    $item = new Supervisor_teacher_item;
    $item->year_id = $year->id;
    $item->teacher_id = $request->teacher_id;
    $item->lesson_id = $request->lesson_id;
    $item->class_id = $lesson->classes->id;

    $item->supervisor_id = auth()->user()->supervisor_id;
    $item->title = $request->title;
    $item->description = $request->description;

    if($request->type=='0'){

        if($request->hasFile('image_in')){

            $item->item_storage=$request->image_in->store('superitems','public');
            $item->type_file='1';

        }

    }

    if($request->type=='1'){

        if($request->video != ""){

            $item->item_link=$request->video;
            $item->type_file='0';
        }elseif ($request->hasFile('video_in')) {
            $item->item_storage=$request->video_in->store('superitems','public');
            $item->type_file='1';

        }

    }


    if($request->type=='2'){

        if($request->audio != ""){

            $item->item_link=$request->audio;
            $item->type_file='0';
        }elseif ($request->hasFile('audio_in')) {
            $item->item_storage=$request->audio_in->store('superitems','public');
            $item->type_file='1';

        }

    }


    if($request->type=='3'){

        if($request->file != ""){

            $item->item_link=$request->file;
            $item->type_file='0';
        }elseif ($request->hasFile('file_in')) {
            $item->item_storage=$request->file_in->store('superitems','public');
            $item->type_file='1';

        }

    }



    if($request->type=='4'){



            $item->item_link=$request->link;
            $item->type_file='0';


    }

    $item->type= $request->type;

    $item->save();

    session()->flash('success','تمت العملية بنجاح ');

    return redirect()->back()->with('success',' تمت العملية بنجاح ');

}

public function send_group_item($lesson_id){

      $teachers=Lesson::find($lesson_id)->teachers->unique();
    $supervisor=Supervisor::find(auth()->user()->supervisor_id);
    $lesson=Lesson::find($lesson_id);
    $class=$lesson->classes;
   return view('supervisors.send_group_item',compact('teachers','lesson_id','supervisor','lesson','class'));

}

public function store_group_item(Request $request) {

    $teachers=Lesson::find($request->lesson_id)->teachers->unique();
foreach($teachers as $teacher) {
    $lesson= Lesson::find($request->lesson_id);
    $year=Year::where('current_year' , '1')->first();
   $item = new Supervisor_teacher_item;
   $item->year_id = $year->id;
   $item->teacher_id = $teacher->id;

   $item->lesson_id = $request->lesson_id;
   $item->class_id = $lesson->classes->id;

   $item->supervisor_id = auth()->user()->supervisor_id;
   $item->title = $request->title;
   $item->description = $request->description;

   if($request->type=='0'){

       if($request->hasFile('image_in')){

           $item->item_storage=$request->image_in->store('superitems','public');
           $item->type_file='1';

       }

   }

   if($request->type=='1'){

       if($request->video != ""){

           $item->item_link=$request->video;
           $item->type_file='0';
       }elseif ($request->hasFile('video_in')) {
           $item->item_storage=$request->video_in->store('superitems','public');
           $item->type_file='1';

       }

   }


   if($request->type=='2'){

       if($request->audio != ""){

           $item->item_link=$request->audio;
           $item->type_file='0';
       }elseif ($request->hasFile('audio_in')) {
           $item->item_storage=$request->audio_in->store('superitems','public');
           $item->type_file='1';

       }

   }


   if($request->type=='3'){

       if($request->file != ""){

           $item->item_link=$request->file;
           $item->type_file='0';
       }elseif ($request->hasFile('file_in')) {
           $item->item_storage=$request->file_in->store('superitems','public');
           $item->type_file='1';

       }

   }



   if($request->type=='4'){



           $item->item_link=$request->link;
           $item->type_file='0';


   }

   $item->type= $request->type;

   $item->save();



}




   session()->flash('success','تمت العملية بنجاح ');

   return redirect()->back()->with('success',' تمت العملية بنجاح ');

}

public function show_old_item($teacher_id,$lesson_id) {
    $year=Year::where('current_year','1')->first();

    $lesson=Lesson::find($lesson_id);
     $class=$lesson->classes;
    $teacher = Teacher::find($teacher_id);
    $supervisor=Supervisor::find(auth()->user()->supervisor_id);
    $old_items= Supervisor_teacher_item::where('supervisor_id',auth()->user()->supervisor_id)
    ->where('teacher_id',$teacher->id)->where('year_id',$year->id)->get();
    return view('supervisors.show_old_item',compact('supervisor','teacher','class','lesson','lesson_id','old_items'));

}

public function delete_item(Request $request){


    $item_id=$request->id;

    $item=Supervisor_teacher_item::find($item_id);
    if ($item->type_file=='1') {

        Storage::disk('public')->delete($item->item_storage);
    }
     $item->delete();

    return redirect()->back()->with('success','! تمت العملية بنجاح ');
}

public function edit_item($item_id){

     $supervisor=Supervisor::find(auth()->user()->supervisor_id);
    $item=Supervisor_teacher_item::find($item_id);



    return view('supervisors.edit_item',compact('supervisor','item'));
}

public function update_item(Request $request) {

    $lesson= Lesson::find($request->lesson_id);
     $year=Year::where('current_year' , '1')->first();
    $item = Supervisor_teacher_item::find($request->item_id);
    $item->year_id = $year->id;
    $item->teacher_id = $request->teacher_id;
    $item->lesson_id = $request->lesson_id;
    $item->class_id = $lesson->classes->id;

    $item->supervisor_id = auth()->user()->supervisor_id;
    $item->title = $request->title;
    $item->description = $request->description;



    if($request->type=='0'){

        if($request->hasFile('image_in')){

            $item->item_storage=$request->image_in->store('superitems','public');
            $item->type_file='1';

        }

    }

    if($request->type=='1'){

        if($request->video != ""){

            $item->item_link=$request->video;
            $item->type_file='0';
        }elseif ($request->hasFile('video_in')) {
            $item->item_storage=$request->video_in->store('superitems','public');
            $item->type_file='1';

        }

    }


    if($request->type=='2'){

        if($request->audio != ""){

            $item->item_link=$request->audio;
            $item->type_file='0';
        }elseif ($request->hasFile('audio_in')) {
            $item->item_storage=$request->audio_in->store('superitems','public');
            $item->type_file='1';

        }

    }


    if($request->type=='3'){

        if($request->file != ""){

            $item->item_link=$request->file;
            $item->type_file='0';
        }elseif ($request->hasFile('file_in')) {
            $item->item_storage=$request->file_in->store('superitems','public');
            $item->type_file='1';

        }

    }



    if($request->type=='4'){



            $item->item_link=$request->link;
            $item->type_file='0';


    }

    $item->type= $request->type;

    $item->save();

    session()->flash('success','تمت العملية بنجاح ');

    return redirect()->back()->with('success',' تمت العملية بنجاح ');

}


}
