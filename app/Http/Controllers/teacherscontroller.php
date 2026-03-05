<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Day;
use App\Lesson;
use App\Lesson_teacher_room_term_exam;
use App\Room;
use App\Road;
use App\Means;
use App\Google_meet;
use App\Message;
use App\Exam_file;
use App\Teacher_event;
use Carbon\Carbon;
use App\Messages_super;
use App\Supervisor_teacher_item;
use App\Lecture;
use App\Student;
use App\Student_lesson_teacher_room_term_exam;
use App\Students_mark;
use App\Teacher;
use App\Teacher_room_lesson;
use App\Term;
use App\Certificate;
use App\Medal;
use App\Term_year;
use App\User;
use App\Question;
use App\Section;
use App\Objection;
use App\Year;
use App\Prepare;
use App\Option;
use App\Unit_analysis;
use App\Exam_result;
use App\Exam_result2;
use App\Exams;
use App\Lecture_time;
use App\Lesson_room_teacher_lecture_time;
use App\Room_student;
use App\Exams2;

use App\Student_schedule_tracer;
use App\Planification_trimestrielle;
use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Console\Input\Input;
use DateTime;
use RealRashid\SweetAlert\Facades\Alert;

class teacherscontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('warning')) {
                Alert::warning(session('warning'));
            }

            return $next($request);
        });
    }
       public function dalete_lecture(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
        $item =  Lecture::find($request->question_id);
        $item->active=1;

        $item->save();
        return  redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
        public function solve( $id)
    {
         $objection=Objection::find($id);
         $objection->type=1;
         $objection->save();
          return redirect()->back()->with('success', '! تمت العملية بنجاح ')
   ; }

      public function quize_student(Request $request){
          $exam11=Exams2::find($request->exam);
          $exam2=Exam_result2 ::where('exam_id',$request->exam)->where('room_id',$request->room_id)->get();
           foreach ($exam2 as $item) {
               $item->delete();

           }
          if($request->all==1){
              $studens = Room::find($request->room_id)->student;

          foreach ($studens as $student) {
                $item2 = new Exam_result2;
                $item2->class_id = $request->class_id;
                $item2->room_id = $request->room_id;
                $item2->exam_id = $request->exam;
                $item2->user_id = $student->id;
                $item2->lesson_id = $request->lesson_id;

                $item2->show_result = $exam11->has_traditional == 0 ? 1 : 0;
                $item2->type =$exam11->type;
                $item2->save();
          }
          }

          else{

             if($request->student){
                 $studens=Student::whereIn('id',$request->student)->get();

          foreach ($studens as $student) {
                $item2 = new Exam_result2;
                $item2->class_id = $request->class_id;
                $item2->room_id = $request->room_id;
                $item2->exam_id = $request->exam;
                $item2->user_id = $student->id;
                $item2->lesson_id = $request->lesson_id;
               $item2->show_result = $item2->show_result = $exam11->has_traditional == 0 ? 1 : 0;
               $item2->type =$exam11->type;
                $item2->save();
          }
             }

          }

              return  redirect()->back()->with('success', '! تمت العملية بنجاح ');
      }




     public function update_lecture(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
          $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $item =  Lecture::find($request->id);
        $item->teacher_id = $request->teacher_id;
        $item->class_id = $request->class_id;
        $item->room_id = $request->room_id;
        $item->lesson_id = $request->lesson_id;
        $item->year_id = $year->id;
        $item->name = $request->name;
        $item->term_id = $terms->id;


        $item->save();
        return  redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
    public function profile()
    {
        $teacher_id = Auth::user()->teacher_id;
        $year = Year::where('current_year', '1')->first();
        $teacher = Teacher::with(['rooms.student' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($teacher_id);

        return  view('teachers.index',compact('teacher'));
    }
   public function key(Request $request) {
        $lecture=Lecture::find($request->id);

        if($lecture->key==0){

            $lecture->key='1';
            $lecture->save();
            return  $lecture;

        }
        else{
            $lecture->key='0';
            $lecture->save();
            return  $lecture;
        }
    }
      public function get_message()
    {
        $st=[];
          $teacher = Teacher::find( Auth::user()->teacher_id);
         $message=Message::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'desc')->get();
         foreach($message as $item){
         $st[] = $item->student_id	;

         }



      $message1=Message::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'desc')->get();

               $student = Student::withCount('message')->with('room')->with(['message1' => function ($q) {
                  $q->where('teacher_id', Auth::user()->teacher_id);
        $q->orderBy('id','desc');

    }])->with('room.classes')->whereIn('id',$st)->get();


         $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
           $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        return view('teachers.teacher_message', compact('teacher', 'student','message','objection')); ;

    }

         public function teacher_objection_term( )
    {
           $teacher = Teacher::find( Auth::user()->teacher_id);
           $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
           $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
           return view('teachers.teacher_objection_term', compact('teacher','message','objection')); ;

   ; }

      public function filtersolve($lec)
    {
        if($lec==1){
             $objection=Objection::where('teacher_id', Auth::user()->teacher_id)->with('student')->with('room')->with('room.classes')->where('type',1)->orderBy("id", 'desc')->get();
        }
        elseif($lec==2){
             $objection=Objection::where('teacher_id', Auth::user()->teacher_id)->with('student')->with('room')->with('room.classes')->where('type',0)->orderBy("id", 'desc')->get();
        }
        else{
             $objection=Objection::where('teacher_id', Auth::user()->teacher_id)->with('student')->with('room')->with('room.classes')->orderBy("id", 'desc')->get();
        }
        return $objection;

    }

      public function get_objection($number)
    {
        $st=[];
          $teacher = Teacher::find( Auth::user()->teacher_id);
         $message12=Objection::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'desc')->get();
         foreach($message12 as $item){
         $st[] = $item->student_id	;

         }
       $objection2=[];
           $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->where('type',$number)->first();

      $message1=Objection::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'desc')->get();

               $student = Student::withCount('objection')->with('room')->with('objection1')->with('room.classes')->whereIn('id',$st)->get();
             if($term){
                   $objection2=Objection::with('student')->with('room')->where('term_id',$term->id)->where('teacher_id',Auth::user()->teacher_id)->get();
             }

          if($objection2){
              foreach($objection2 as $item){
         $item->view = '1'	;
         $item->save();

         }
          }

         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
           $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_objection', compact('teacher', 'student','objection','message','objection2'));

    }
      public function event_delete(Request $request)
    {

         $event_delete = Teacher_event::find($request->question_id);

        $event_delete->delete();
      session()->flash('success', 'تمت العملية بنجاح');
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
  public function dashboard_teacher()
    {

        $teacher_id = Auth::user()->teacher_id;
        $teacher_name = Auth::user()->name;

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $teacher = Teacher::with(['rooms.student' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($teacher_id);

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();

        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        $classes = [];


        // return $teacher ;
        foreach ($teacher->rooms as $item) {

            $classes[] = $item->classes;
        }
        $classes = array_unique($classes);

          $events = Teacher_event::where('teacher_id', auth()->user()->teacher_id)->get();
         $message=Message::where('teacher_id',$teacher_id)->where('type',1)->where('view',0)->count();
          $objection=Objection::where('teacher_id',$teacher_id)->where('view',0)->count();
        return view('teachers.teacher_index', compact('objection','teacher', 'events','count', 'count2', 'teacher_name', 'classes','message'));
    }




   public function update_profile1(Request $request, $teacher_id)
    {


        $teacher = Teacher::find($teacher_id);

        if ($request->image != null) {
            Storage::disk('public')->delete($teacher->image);
            $teacher->image = $request->image->store('filesteachers', 'public');
        }


        $teacher->save();
        $user = User::where('teacher_id',$teacher_id)->first();
        // return $user;

        // $this->validate($request, [
        //     'old_password'          => 'required',
        //     'password'              => 'required',
        //     'password_confirmation' => 'required|same:password'
        // ]);

        if (Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->password);
            $user->view_password = $request->password;

            $user->save();
        } else {
            session()->flash('warning', 'كلمة المرور خاطئة   ');
            return redirect()->back()->with('warning', '! كلمة المرور القديمة خاطئة');
        }
        session()->flash('success', '   تمت العملية بنجاح   ');
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }



    public function update_password(Request $request, $teacher_id)
    {

        // return $teacher_id;
        $user = User::find($teacher_id);
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
    public function teacher_classes($teacher_id)
    {

        $year = Year::where('current_year', '1')->first();

        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find($teacher_id);
        $classes = [];
        foreach ($teacher->rooms as $item) {

            $classes[] = $item->classes;
        }
        $classes = array_unique($classes);

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.classes', compact('classes', 'teacher', 'count', 'count2'));
    }

    public function teacher_rooms($class_id, $teacher_id)
    {

        $year = Year::where('current_year', '1')->first();

        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find($teacher_id);
        $rooms = $teacher->rooms;

        $class_rooms = [];
        foreach ($rooms as $room) {

            if ($room->class_id == $class_id) {
                $class_rooms[] = $room;
            }
        }

        $class_rooms = array_unique($class_rooms);

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.rooms', compact('class_rooms', 'teacher', 'count', 'count2'));
    }



    public function teacher_lessons($room_id, $teacher_id)
    {

        $teacher = Teacher::find($teacher_id);
        $lessons = $teacher->lessons;
        $room_lessons = [];
        $teacher_room_lessons = Teacher_room_lesson::where('room_id', $room_id)->where('teacher_id', $teacher_id)->get();
        $teacher_lessons = [];
        foreach ($teacher_room_lessons as $teacher_room_lesson) {

            $teacher_lessons[] = Lesson::find($teacher_room_lesson->lesson_id);
        }




        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.lessons', compact('teacher_lessons', 'teacher', 'room_id', 'count', 'count2'));
    }

    public function correct_exam($exam_id, $student_id)
    {


         $exam = Lesson_teacher_room_term_exam::find($exam_id);
         $student = Student::find($student_id);
        $room=Room::find($exam->room_id);
         $class_id=Room::find($exam->room_id)->class_id;
         $class1=Classe::find($class_id);
         $term= Term_year::find($exam->term_id)->term;
        $lesson = Lesson::find($exam->lesson_id);
        //  تخزين اسئلة الامتحان مع الاجابات

        $questions = [];
        if ($exam->selected_ques) {
            foreach (json_decode($exam->selected_ques, true) as $question_id) {

       $questions[] = Question::with('option')->find($question_id);


            }
        }


        $exam_result = Exam_result::where('exam_id', $exam_id)->where('user_id', $student->id)->first();


        $class = $exam->class;

        $max_result = 0;

        foreach ($questions as $item) {
            if($item)
{
      $max_result = $max_result + $item->mark;
}

        }
$year = Year::where('current_year', '1')->first()->name;
        // if ($exam_result->status == '0') {
        //   return redirect()->back()->with('warning','لا يوجد امتحان ');
        // }
         $teacher = Teacher::find(auth()->user()->teacher_id);
        return view('teachers.teacher_testfile', compact('student', 'teacher','max_result','exam_id','questions', 'exam', 'exam_result', 'class1','room','term','year','class','lesson'));
    }

    public function correct_exam1($exam_id, $student_id)
    {
        $exam = Exams2::find($exam_id);
        $student = Student::find($student_id);
        $room=Room::find($exam->room_id);
        $class_id=Room::find($exam->room_id)->class_id;
        $class1=Classe::find($class_id);
        $term= Term_year::find($exam->term_id)->term;
        $lesson = Lesson::find($exam->lesson_id);
        //  تخزين اسئلة الامتحان مع الاجابات
        $questions = [];
        if ($exam->selected_ques) {
            foreach (json_decode($exam->selected_ques, true) as $question_id) {

        $questions[] = Question::with('option')->find($question_id);
            }
        }

        $exam_result = Exam_result2::where('exam_id', $exam_id)->where('user_id', $student->id)->first();
        $class = $exam->class;
        $max_result = 0;
        foreach ($questions as $item) {
            if($item)
        {
        $max_result = $max_result + $item->mark;
        }}
        $year = Year::where('current_year', '1')->first()->name;
        // if ($exam_result->status == '0') {
        //   return redirect()->back()->with('warning','لا يوجد امتحان ');
        // }
        $teacher = Teacher::find(auth()->user()->teacher_id);
        return view('teachers.teacher_testfile1', compact('student', 'teacher','max_result','exam_id','questions', 'exam', 'exam_result', 'class1','room','term','year','class','lesson'));
    }

    public function StudentsRoomLessontotal($room_id, $teacher_id, $lesson_id)
    {
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $year = Year::where('current_year', '1')->first();

        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

        $students = $room->student;

        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

       if ($lesson->lang == '1') {
             $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('lang', '1')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);

        } elseif ($lesson->lang == '0') {

              $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('lang', '0')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        } elseif ($lesson->religion == '1') {
              $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('religion', '1')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        } elseif ($lesson->religion == '0') {

           $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('religion', '0')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        } else {

            $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        }



        if (!$students->count() > 0) {

            return redirect()->back()->with('warning', '! لا يوجد طلاب');
        }

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

         $class_id=Room::find($room_id)->class_id;
         $class=Classe::find($class_id);
           $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        if($class->stage_id ==1){
            return view('teachers.teacher_total', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
        elseif($class->stage_id ==2){
             return view('teachers.teacher_total1', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
          elseif($class->stage_id ==3){
             return view('teachers.teacher_total2', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }


    }
     public function StudentsRoomLessontotal_pdf($room_id, $teacher_id, $lesson_id)
    {
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $year = Year::where('current_year', '1')->first();

        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

        $students = $room->student;

        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

        if ($lesson->lang == '1') {
             $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('lang', '1')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);

        } elseif ($lesson->lang == '0') {

              $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('lang', '0')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        } elseif ($lesson->religion == '1') {
              $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('religion', '1')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        } elseif ($lesson->religion == '0') {

           $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('religion', '0')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        } else {

            $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        }


        if (!$students->count() > 0) {

            return redirect()->back()->with('warning', '! لا يوجد طلاب');
        }

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

         $class_id=Room::find($room_id)->class_id;
         $class=Classe::find($class_id);
          $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        if($class->stage_id ==1){
            return view('teachers.teacher_total_pdf', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
        elseif($class->stage_id ==2){
             return view('teachers.teacher_total1_pdf', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
          elseif($class->stage_id ==3){
             return view('teachers.teacher_total2_pdf', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }


    }
      public function StudentsRoomLessontotal_excel($room_id, $teacher_id, $lesson_id)
    {
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $year = Year::where('current_year', '1')->first();

        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

        $students = $room->student;

        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);
          $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        if ($lesson->lang == '1') {
             $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('lang', '1')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);

        } elseif ($lesson->lang == '0') {

              $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('lang', '0')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        } elseif ($lesson->religion == '1') {
              $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('religion', '1')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        } elseif ($lesson->religion == '0') {

           $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);
                              $query->where('religion', '0')->orderBy('first_name');

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        } else {

            $students=Room::whereHas('student', function ($query) use($year){
                             $query->where('year_id', $year->id);

                        })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                        ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        }



        if (!$students->count() > 0) {

            return redirect()->back()->with('warning', '! لا يوجد طلاب');
        }

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

         $class_id=Room::find($room_id)->class_id;
         $class=Classe::find($class_id);

        if($class->stage_id ==1){
            return view('teachers.teacher_total_excel', compact('objection','objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
        elseif($class->stage_id ==2){
             return view('teachers.teacher_total_excel1', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
          elseif($class->stage_id ==3){
             return view('teachers.teacher_total2_excel1', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }


    }
    public function pdfdownload($id)
    {
        $prepare=Prepare::find($id);
        $class_id= Classe::find($prepare->class_id);

        $lesson_id=Lesson::find($prepare->lesson_id);
        if($lesson_id->is_english==1){
            $means= Means::where('lang',2)->get();
            $road= Road::where('lang',2)->get();
            return view('teachers.ll_en',compact('means','road','prepare','lesson_id','class_id'));
        }
        elseif($lesson_id->lang==0 && $lesson_id->lang !=null  ){
            return view('teachers.ll_fr',compact('prepare','lesson_id','class_id'));
        }
        else{
             $means= Means::where('lang',1)->get();
            $road= Road::where('lang',1)->get();
            return view('teachers.ll',compact('means','road','prepare','lesson_id','class_id'));
        }


    }
    public function multipdfdownload($id)
    {
        $prepare=Prepare::find($id);
        $lesson_id=Lesson::find($prepare->lesson_id);
        $class_id= Classe::find($prepare->class_id);
         $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $prepares=Prepare::where('class_id',$class_id->id)->where('term_id',$term->id)->where('lesson_id',$lesson_id->id)->where('teacher_id',auth()->user()->teacher_id)->get();
      if( $lesson_id->is_english==1){
           $means= Means::where('lang',2)->get();
            $road= Road::where('lang',2)->get();
        return view('teachers.allbook_en',compact('means','road','prepares','lesson_id','class_id'));
      }
      elseif($lesson_id->lang==0 && $lesson_id->lang !=null ){
        return view('teachers.allbook_fr',compact('prepares','lesson_id','class_id'));
      }

      else{
           $means= Means::where('lang',1)->get();
            $road= Road::where('lang',1)->get();
        return view('teachers.allbook',compact('means','road','prepares','lesson_id','class_id'));
      }


    }
     public function searchlect(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson_id=Lesson::find($request->lesson_id);

        $class_id= Classe::find($request->class_id);
        if($lesson_id->is_english==1){
        $means= Means::where('lang',2)->get();
        $road= Road::where('lang',2)->get();
        $prepare=Prepare::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('term_id',$request->term)->where('teacher_id',auth()->user()->teacher_id)->where('lecture', 'LIKE', '%' . $request->search . "%")->paginate(1);
    return view('teachers.load_en',compact('means','road','prepare','class_id','lesson_id','term'));
   }
   elseif($lesson_id->lang==0 && $lesson_id->lang !=null ){
    $prepare=Prepare::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('term_id',$request->term)->where('teacher_id',auth()->user()->teacher_id)->where('lecture', 'LIKE', '%' . $request->search . "%")->paginate(1);
    return view('teachers.load_fr',compact('prepare','class_id','lesson_id','term'));
    }
else{
     $means= Means::where('lang',1)->get();
             $road= Road::where('lang',1)->get();
    $prepare=Prepare::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('term_id',$request->term)->where('teacher_id',auth()->user()->teacher_id)->where('lecture', 'LIKE', '%' . $request->search . "%")->paginate(1);
    return view('teachers.load',compact('means','road','prepare','class_id','lesson_id','term'));
}

}


     public function question_store(Request $request)
    {


 $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        if ($request->ques_type == "2") {
            $question =  new  question();
            $question->question_form = $request->question_form1;
            $question->section_id = $request->section_id;
            $question->answer = $request->answer;
            $question->mark = $request->mark;
            $question->note = $request->note;
            $question->class_id = $request->class_id;
            $question->ques_type = $request->ques_type;
            $question->Lecture_id = $request->Lecture_id;
            $question->lesson_id = $request->lesson_id;
            $question->term_id = $term->id;

            $question->teacher_id = auth()->user()->teacher_id;
            $question->save();

            // dd($question);

        } //نهاية السشرط لحالة السؤال التقليدي

        // حالة السؤال متعدد الخيارات
        else {

            $options = new stdClass();

            // $validatedData = $request->validate([
            //     'question_form' => 'required',
            //     'answer' => 'required',
            //     'mark' => 'required',
            //     'class_id' => 'required',
            //     'ques_type' => 'required',
            //     'option' => 'required',
            //     'Lecture_id' => 'required'
            // ], [
            //     'question_form.required' => 'يرجي ادخال صيغة السؤال',
            //     'answer.required' => 'يرجي ادخال إجابة السؤال',
            //     'mark.required' => 'يرجي ادخال علامة السؤال',

            //     'ques_type.required' => 'يرجي ادخال نوع السؤال',
            // ]);

            $question =  new  question();
            $question->question_form = $request->question_form;
            $question->section_id = $request->section_id;
            $question->answer = json_encode($request->answer);
            $question->mark = $request->mark;
            $question->class_id = $request->class_id;
            $question->ques_type = $request->ques_type;
            $question->Lecture_id = $request->Lecture_id;
            $question->lesson_id = $request->lesson_id;
            $question->teacher_id = auth()->user()->teacher_id;
             $question->term_id = $term->id;

            $question->save();

            // تقوم بجلب آخر ريكورد تم إضافته للداتا بيز
            // $data = DB::select('select * from questions order by Created_at desc limit 1');

            // dd($data[0]->id);

            $option =  Option::create([
                'question_id' => $question->id,
                // 'myOptions' =>  json_encode($options)
                'myOptions' =>  json_encode($request->option),
            ]);

        }

        session()->flash('Add', 'تم اضافة السؤال بنجاح ');
       return redirect($request->back)->with('success', '! تمت العملية بنجاح ');
    }


    public function update_result(Request $request)
    {

        $result2 = 0;
        $exam_result = Exam_result::find($request->exam_result_id);

        $result = 0;
//   $exam_result->traditional_result =  json_encode($request->traditional_result);
//         if (!$request->has('traditional_result')) {
//             return redirect()->back();
//         }
if($request->traditional_result){
    foreach ($request->traditional_result as $key => $value) {

            $result = $result + $value;
        }
}


        if($request->mark){
        foreach ($request->mark as $key => $value) {

             $result = $result + $value;
        }

      }
       $exam=lesson_teacher_room_term_exam::find($request->exam);
        
        // --- Enforce Gradebook Config ---
        try {
            $year = \App\Year::where('current_year', '1')->first();
            if ($year && $exam) {
                $config = \App\GradebookConfig::where('lesson_id', $exam->lesson_id)
                                            ->where('year_id', $year->id)
                                            ->first();
                if ($config) {
                    $maxMark = 0;
                    if ($exam->type == 1) { // Homework
                        $maxMark = $config->homework_max;
                    } else { // Oral/Participation
                        $maxMark = $config->oral_max;
                    }

                    if ($maxMark > 0 && $result > $maxMark) {
                        return redirect()->back()->with('warning', "خطأ: العلامة ($result) تتجاوز الحد المسموح ($maxMark)");
                    }
                }
            }
        } catch (\Exception $e) {
            // Check failed safely
        }
        // --------------------------------

        $exam_result->traditional_result =  json_encode($request->traditional_result);
         if ($result > $exam->success_mark) $result=  floor($result);
        $exam_result->result = $result;
        $exam_result->show_result = 1;
         $medal = 0;
             if($exam->success_mark == $result){

                $medal = "1";
            }
             elseif( $exam->success_mark - 3 <= $result ){

                $medal = "2";
            }
             elseif( $exam->success_mark - 6 <= $result ){

                $medal = "3";
            }
             else{
                 $medal = null;
            }

        $exam_result->medal = $medal;
        $exam_result->save();

 session()->flash('success', '  ');
        return redirect()->back()->with('success', 'تمت العملية بنجاح');
    }

      public function update_result1(Request $request)
    {

        $result2 = 0;
        $result3=0;
        $exam_result = Exam_result2::find($request->exam_result_id);
        $result=0;
        // $result = $exam_result->result;

    //   if($exam_result->traditional_result){
    //     foreach (json_decode($exam_result->traditional_result) as $key => $value) {

    //         $result2 = $result2 + $value;
    //     }

    //   }
    //     if($request->mark){
    //     foreach ($request->mark as $key => $value) {

    //         $result3 = $result3 + $value;
    //     }

    //   }


        // $result = $result - $result2 ;

       $exam_result->traditional_result =  json_encode($request->traditional_result);
        // if (!$request->has('traditional_result')) {
        //     return redirect()->back();
        // }
        if($request->traditional_result){
             foreach ($request->traditional_result as $key => $value) {

            $result = $result + $value;
        }
        }


        if($request->mark){
        foreach ($request->mark as $key => $value) {

             $result = $result + $value;
        }

      }
     $exam=Exams2::find($request->exam);
     
        // --- Enforce Gradebook Config ---
        try {
            $year = \App\Year::where('current_year', '1')->first();
            if ($year && $exam) {
                $config = \App\GradebookConfig::where('lesson_id', $exam->lesson_id)
                                            ->where('year_id', $year->id)
                                            ->first();
                if ($config) {
                    $maxMark = 0;
                    if ($exam->type == 1) { // Final/Mid Exam
                        $maxMark = $config->exam_max;
                    } elseif ($exam->type == 2) { // Quiz
                        // Treating Quiz as Oral component for safety
                        $maxMark = $config->oral_max; 
                    }

                    if ($maxMark > 0 && $result > $maxMark) {
                        return redirect()->back()->with('warning', "خطأ: العلامة ($result) تتجاوز الحد المسموح ($maxMark)");
                    }
                }
            }
        } catch (\Exception $e) {
            // Check failed safely
        }
        // --------------------------------

        // $result = round($result, 1);
        $exam_result->traditional_result =  json_encode($request->traditional_result);
        if ($result > $exam->mark) $result=  floor($result);
        $exam_result->result = $result;
        $exam_result->show_result = 1;
          $exam=Exams2::find($request->exam);
            $medal = 0;

              if($exam->mark  ==  $result){

                $medal = "1";
            }
             elseif( $exam->mark - 3 <= $result ){

                $medal = "2";
            }
             elseif( $exam->mark - 6 <= $result ){

                $medal = "3";
            }
             else{
                 $medal = null;
            }

        $exam_result->medal = $medal;
        $exam_result->save();

session()->flash('success', '  ');

        return redirect()->back()->with('success', 'تمت العملية بنجاح');
    }
    public function question_delete(Request $request)
    {

         $question = Question::find($request->question_id);
if($question->option){
    $question->option->delete();
}

        $question->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }





    public function exam_delete(Request $request)
    {

        $id = $request->exam_id;
        Lesson_teacher_room_term_exam::find($id)->delete();
        Exam_result::where('exam_id', $request->exam_id)->delete();

        return redirect()->back()->with('delete', 'تم حذف الامتحان بنجاح');
    }



        public function addunit(Request $request)
    {
        $unti= new Unit_analysis();
        $unti->unit_name=$request->unit_name;
        $unti->teacher_id=auth()->user()->teacher_id;
        $unti->class_id=$request->class_id;
        $unti->lesson_id=$request->lesson_id;
        $unti->year_id=$request->year_id;
        $unti->term_id=$request->term_id;
        $unti->contain=json_encode(json_decode($request->conatin));
        $unti->save();

    return redirect()->back();

    }

   public function unit_analysis1($class_id,$lesson_id,$room_id)
    {
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find(auth()->user()->teacher_id);
         $lesson_id=Lesson::find($lesson_id);
         $unit=Unit_analysis::where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id)->where('term_id',$term->id)->where('teacher_id',null)->paginate(1);
 if($unit->isEmpty()){
      return redirect()->back();

 }

 if($unit!=null){
      $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
      $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
      return view('teachers.coordinatore_showunits',compact('objection','message','term','teacher','class_id','lesson_id','year','unit','room_id'));

 }





    }

    public function show_unit($class_id,$lesson_id,$room_id)
    {
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find(auth()->user()->teacher_id);
         $lesson_id=Lesson::find($lesson_id);
         $unit=Unit_analysis::where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id)->where('term_id',$term->id)->where('teacher_id',auth()->user()->teacher_id)->paginate(1);
 if($unit!=null){
      $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
      return view('teachers.teacher_showunits',compact('objection','message','term','teacher','class_id','lesson_id','year','unit','room_id'));

 }
 else{
     return redirect()->back();
 }




    }

         public function show_message( $student_id)
    {
          $message=Message::where('teacher_id',auth()->user()->teacher_id)->where('student_id',$student_id)->where('type','1')->where('view','0')->get();
         foreach($message as $item){
             $item->view = 1;
             $item->save();
         }
         return 1;
    }

    public function updateunit(Request $request)
    {
        $unti=  Unit_analysis::find($request->unitid);
        $unti->unit_name=$request->unit_name;
        $unti->teacher_id=auth()->user()->teacher_id;
        $unti->class_id=$request->class_id;
        $unti->lesson_id=$request->lesson_id;
        $unti->year_id=$request->year_id;
        $unti->term_id=$request->term_id;
        $unti->contain=json_encode(json_decode($request->conatin));
        $unti->save();

    return redirect()->back();

    }


    public function searchunit(Request $request)
    {
       $unit=Unit_analysis::where('class_id',$request->class_id)
       ->where('lesson_id',$request->lesson_id)
       ->where('year_id',$request->year)
       ->where('term_id',$request->term)
       ->where('teacher_id',auth()->user()->teacher_id)
       ->where('unit_name', 'LIKE', '%' . $request->search . "%")->first();
       return  $unit;

    }
        public function searchunit1(Request $request)
    {


       $unit=Unit_analysis::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('year_id',$request->year)->where('term_id',$request->term)->where('teacher_id',null)->where('unit_name', 'LIKE', '%' . $request->search . "%")->first();
       return  $unit;

    }
    public function unit_analysis($class_id,$lesson_id,$room_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find(auth()->user()->teacher_id);
         $lesson_id=Lesson::find($lesson_id);
         $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        return view('teachers.teacher_unit_analysis',compact('objection','message','term','teacher','class_id','lesson_id','year','room_id'));

    }
    public function prepare (Request $request,$class_id,$lesson_id,$room_id)
    {
        $year = Year::where('current_year', '1')->first();
                $lesson_id=Lesson::find($lesson_id);
                 $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find(auth()->user()->teacher_id);
        if($lesson_id->is_english==1){
           $means= Means::where('lang',2)->get();
            $road= Road::where('lang',2)->get();
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

            $class_id= Classe::find($class_id);
            $prepare=Prepare::where('teacher_id',auth()->user()->teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

            if ($request->ajax()) {

                $class_id= Classe::find($class_id);

                $prepare=Prepare::where('teacher_id',auth()->user()->teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

                return view('teachers.load_en')->withprepare($prepare)->withclass_id($class_id)->withlesson_id($lesson_id);

            }
            return  view('teachers.teacher_prepare_en', compact('road','means','prepare','lesson_id','class_id','year','term','teacher','room_id'));

        }
        if($lesson_id->lang==0 && $lesson_id->lang !=null ){
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

            $class_id= Classe::find($class_id);
            $prepare=Prepare::where('teacher_id',auth()->user()->teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

            if ($request->ajax()) {

                $class_id= Classe::find($class_id);

                $prepare=Prepare::where('teacher_id',auth()->user()->teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

                return view('teachers.load_fr')->withprepare($prepare)->withclass_id($class_id)->withlesson_id($lesson_id);

            }
            return  view('teachers.teacher_prepare_fr', compact('prepare','lesson_id','class_id','year','term','teacher','room_id'));

        }
        else{
            $means= Means::where('lang',1)->get();
            $road= Road::where('lang',1)->get();
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
            $class_id= Classe::find($class_id);
            $prepare=Prepare::where('teacher_id',auth()->user()->teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

            if ($request->ajax()) {

                $class_id= Classe::find($class_id);

                $prepare=Prepare::where('teacher_id',auth()->user()->teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

                return view('teachers.load')->withprepare($prepare)->withclass_id($class_id)->withlesson_id($lesson_id);

            }
            return  view('teachers.teacher_prepare', compact('means','road','prepare','lesson_id','class_id','year','teacher','term','room_id'));

        }

    }
   public function planification_trimestrielle($class_id,$lesson_id,$room_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find(auth()->user()->teacher_id);
         $lesson_id=Lesson::find($lesson_id);
          $planification_trimestrielle=Planification_trimestrielle::where('teacher_id',auth()->user()->teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();
$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
$message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        return view('teachers.teacher_planification_trimestrielle',compact('objection','message','planification_trimestrielle','room_id','term','teacher','class_id','lesson_id','year'));

    }
     public function teacher_planification1($class_id,$lesson_id,$room_id)
    {
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find(auth()->user()->teacher_id);
         $lesson_id=Lesson::find($lesson_id);
          $planification_trimestrielle=Planification_trimestrielle::where('teacher_id',auth()->user()->teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();
$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();

        return view('teachers.teacher_planification1',compact('objection','message','planification_trimestrielle','room_id','term','teacher','class_id','lesson_id','year'));

    }

       public function planification_trimestrielle1($class_id,$lesson_id,$room_id)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find(auth()->user()->teacher_id);
         $lesson_id=Lesson::find($lesson_id);
          $planification_trimestrielle=Planification_trimestrielle::where('teacher_id',null)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();
           $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.coordinatore_planification_trimestrielle',compact('objection','message','planification_trimestrielle','room_id','term','teacher','class_id','lesson_id','year'));

    }
         public function coordinatore_planification1($class_id,$lesson_id,$room_id)
    {
       $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find(auth()->user()->teacher_id);
         $lesson_id=Lesson::find($lesson_id);
          $planification_trimestrielle=Planification_trimestrielle::where('teacher_id',null)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();
$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();

        return view('teachers.coordinatore_planification1',compact('objection','message','planification_trimestrielle','room_id','term','teacher','class_id','lesson_id','year'));

    }

    public function addplanification(Request $request)
    {


        if($request->planification_trimestrielle_id){
            $planification =Planification_trimestrielle:: find($request->planification_trimestrielle_id);
            $planification->lesson_id=$request->lesson_id;
            $planification->class_id=$request->class_id;
            $planification->term_id=$request->term_id;
            $planification->year_id=$request->year_id;
            $planification->teacher_id=auth()->user()->teacher_id;
            $planification->from_to1= json_encode($request->from_to1)  ;
            $planification->from_to2=json_encode($request->from_to2) ;
            $planification->from_to3=json_encode($request->from_to3) ;
            $planification->from_to4=json_encode($request->from_to4) ;
            $planification->from_to5=json_encode($request->from_to5) ;
            $planification->from_to6=json_encode($request->from_to6) ;
            $planification->from_to7=json_encode($request->from_to7) ;
            $planification->from_to8=json_encode($request->from_to8) ;
            $planification->from_to9=json_encode($request->from_to9) ;
            $planification->from_to10=json_encode($request->from_to10) ;
            $planification->from_to11=json_encode($request->from_to11) ;
            $planification->from_to12=json_encode($request->from_to12) ;
            $planification->from_to13=json_encode($request->from_to13) ;
            $planification->from_to14=json_encode($request->from_to14) ;
            $planification->from_to15=json_encode($request->from_to15) ;
            $planification->from_to16=json_encode($request->from_to16) ;
            $planification->from_to17=json_encode($request->from_to17) ;
            $planification->from_to18=json_encode($request->from_to18) ;
            $planification->from_to19=json_encode($request->from_to19) ;
            $planification->from_to20=json_encode($request->from_to20) ;
            $planification->text1=$request->text1;
            $planification->text2=$request->text2;
            $planification->text3=$request->text3;
            $planification->text4=$request->text4;
            $planification->text5=$request->text5;
            $planification->text6=$request->text6;
            $planification->text7=$request->text7;
            $planification->text8=$request->text8;
            $planification->text9=$request->text9;
            $planification->text10=$request->text10;
            $planification->text11=$request->text11;
            $planification->text12=$request->text12;
            $planification->text13=$request->text13;
            $planification->text14=$request->text14;
            $planification->text15=$request->text15;
            $planification->text16=$request->text16;
            $planification->text17=$request->text17;
            $planification->text18=$request->text18;
            $planification->text19=$request->text19;
            $planification->text20=$request->text20;
            $planification->save();
        }
        else{
            $planification = new Planification_trimestrielle();
            $planification->lesson_id=$request->lesson_id;
            $planification->class_id=$request->class_id;
            $planification->term_id=$request->term_id;
            $planification->year_id=$request->year_id;
            $planification->teacher_id=auth()->user()->teacher_id;
            $planification->from_to1= json_encode($request->from_to1)  ;
            $planification->from_to2=json_encode($request->from_to2) ;
            $planification->from_to3=json_encode($request->from_to3) ;
            $planification->from_to4=json_encode($request->from_to4) ;
            $planification->from_to5=json_encode($request->from_to5) ;
            $planification->from_to6=json_encode($request->from_to6) ;
            $planification->from_to7=json_encode($request->from_to7) ;
            $planification->from_to8=json_encode($request->from_to8) ;
            $planification->from_to9=json_encode($request->from_to9) ;
            $planification->from_to10=json_encode($request->from_to10) ;
            $planification->from_to11=json_encode($request->from_to11) ;
            $planification->from_to12=json_encode($request->from_to12) ;
            $planification->from_to13=json_encode($request->from_to13) ;
            $planification->from_to14=json_encode($request->from_to14) ;
            $planification->from_to15=json_encode($request->from_to15) ;
            $planification->from_to16=json_encode($request->from_to16) ;
            $planification->from_to17=json_encode($request->from_to17) ;
            $planification->from_to18=json_encode($request->from_to18) ;
            $planification->from_to19=json_encode($request->from_to19) ;
            $planification->from_to20=json_encode($request->from_to20) ;
            $planification->text1=$request->text1;
            $planification->text2=$request->text2;
            $planification->text3=$request->text3;
            $planification->text4=$request->text4;
            $planification->text5=$request->text5;
            $planification->text6=$request->text6;
            $planification->text7=$request->text7;
            $planification->text8=$request->text8;
            $planification->text9=$request->text9;
            $planification->text10=$request->text10;
            $planification->text11=$request->text11;
            $planification->text12=$request->text12;
            $planification->text13=$request->text13;
            $planification->text14=$request->text14;
            $planification->text15=$request->text15;
            $planification->text16=$request->text16;
            $planification->text17=$request->text17;
            $planification->text18=$request->text18;
            $planification->text19=$request->text19;
            $planification->text20=$request->text20;
            $planification->save();
        }




      return redirect()->back();
    }

    public function addprepare(Request $request)
    {

     if($request->prepare_id){
            $prepare= Prepare::find($request->prepare_id);
            $prepare->lesson_id=$request->lesson_id;
            $prepare->class_id=$request->class_id;
            $prepare->teacher_id= auth()->user()->teacher_id;

              if($request->room_id){

                $room1=[];
                    if($request->room_id[0]==null){

                          $room1=[];
                          $prepare->room_id= json_encode($room1);
                    }
                    elseif($request->room_id[0]!=null){
                        $prepare->room_id= json_encode($request->room_id);
                    }





            }



              if($request->Period){

                  $Period=[];
                    if($request->Period[0]==null){
                          $Period=[];
                          $prepare->period= json_encode($Period);
                    }
                    elseif($request->Period[0]!=null){
                        $prepare->period= json_encode($request->Period);
                    }




            }

            $prepare->class_time=$request->class_time;
            $prepare->number_of_lecture=$request->number_of_lecture;
            $prepare->day=$request->day;
            $prepare->month=$request->month;
            $prepare->year=$request->year;
            $prepare->lecture=$request->lecture;
            $prepare->unit=$request->unit;
            $prepare->term_id=$request->term_id;
            $prepare->The_general_goal_of_the_lesson=$request->The_general_goal_of_the_lesson;
            $prepare->stimulating_initialization=$request->stimulating_initialization;
            $prepare->behavioral_goals=$request->behavioral_goals;
              if($request->conatin){
                  $prepare->procedures_and_activities= $request->conatin;
            }
            else{
               $options = new stdClass();
                $prepare->procedures_and_activities=json_encode($options);
            }
            $prepare->concepts_and_terminology=$request->concepts_and_terminology;
             if($request->means){

                  $prepare->means=json_encode($request->means);

            }
            else{
                $means=[];

                  $prepare->means=json_encode($means);
            }
             if($request->roads){

                  $prepare->roads=json_encode($request->roads);

            }
            else{
                    $roads=[];
                 $prepare->roads=json_encode($roads);
            }

            $prepare->homework=$request->homework;
            $prepare->note=$request->note;
            $prepare->Interim_calendar=$request->Interim_calendar;
            $prepare->Final_calendar=$request->Final_calendar;
            $prepare->Taches=$request->Taches;
            $prepare->Evaluation=$request->Evaluation;
            $prepare->Materiel=$request->Materiel;
            $prepare->Phonetique=$request->Phonetique;
            $prepare->Points_grammaticaux=$request->Points_grammaticaux;
            $prepare->Lexique=$request->Lexique;
            $prepare->number=  $prepare->number;



            $prepare->save();
        }
        else{
             $prepare1=Prepare::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('term_id',$request->term_id)->where('teacher_id',auth()->user()->teacher_id)->orderBy('id', 'DESC')->first();


            $prepare= new Prepare();

            $prepare->lesson_id=$request->lesson_id;
            $prepare->class_id=$request->class_id;
            $prepare->teacher_id= auth()->user()->teacher_id;

              if($request->room_id){

                $room1=[];
                    if($request->room_id[0]==null){

                          $room1=[];
                          $prepare->room_id= json_encode($room1);
                    }
                    elseif($request->room_id[0]!=null){
                        $prepare->room_id= json_encode($request->room_id);
                    }





            }



              if($request->Period){

                  $Period=[];
                    if($request->Period[0]==null){
                          $Period=[];
                          $prepare->period= json_encode($Period);
                    }
                    elseif($request->Period[0]!=null){
                        $prepare->period= json_encode($request->Period);
                    }




            }

            $prepare->class_time=$request->class_time;
            $prepare->number_of_lecture=$request->number_of_lecture;
            $prepare->day=$request->day;
            $prepare->month=$request->month;
            $prepare->year=$request->year;
            $prepare->lecture=$request->lecture;
            $prepare->unit=$request->unit;
            $prepare->term_id=$request->term_id;
            $prepare->The_general_goal_of_the_lesson=$request->The_general_goal_of_the_lesson;
            $prepare->stimulating_initialization=$request->stimulating_initialization;
            $prepare->behavioral_goals=$request->behavioral_goals;
            if($request->conatin){
                  $prepare->procedures_and_activities= $request->conatin;
            }
            else{
               $options = new stdClass();
                $prepare->procedures_and_activities=json_encode($options);
            }

            $prepare->concepts_and_terminology=$request->concepts_and_terminology;
          if($request->means){

                  $prepare->means=json_encode($request->means);

            }
            else{
                $means=[];

                  $prepare->means=json_encode($means);
            }
             if($request->roads){

                  $prepare->roads=json_encode($request->roads);

            }
            else{
                    $roads=[];
                 $prepare->roads=json_encode($roads);
            }
            $prepare->homework=$request->homework;
            $prepare->note=$request->note;
            if($prepare1 !=null){
                $prepare->number= $prepare1->number+1;

            }
            else{
                $prepare->number=1;
            }
            // $prepare->Interim_calendar=$request->Interim_calendar;
            $prepare->Final_calendar=$request->Final_calendar;
            $prepare->Taches=$request->Taches;
            $prepare->Evaluation=$request->Evaluation;
            $prepare->Materiel=$request->Materiel;
            $prepare->Phonetique=$request->Phonetique;
            $prepare->Points_grammaticaux=$request->Points_grammaticaux;
            $prepare->Lexique=$request->Lexique;

      $prepare->save();
       }

          return redirect()->back();
    }
    public function exam_store(Request $request)
    {
        //  $validatedData = $request->validate([
        //      'exam_title'  => 'required',
        //     'start_time' => 'required',
        //     'end_time' => 'required',

        //     'class_id' => 'required',
        //  ],[
        //     // 'admin_id.required' => '',
        //     'exam_title.required' => 'يرجى ادخال عنوان الامتحان',
        //     'start_time.required' => 'يرجى ادخال بداية الامتحان',
        //     'end_time.required' => 'يرجى ادخال نهاية الامتحان',

        //      'class_id.required'  => 'يرجى اختيار القسم',

        // ]);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        // if ($request->type == 2) {
        //     $item =  new Lesson_teacher_room_term_exam();
        //     $item->class_id = $request->class_id;
        //     $item->room_id = $request->room_id;
        //     $item->teacher_id = auth()->user()->teacher_id;
        //     $item->name_exam = $request->name_exam;
        //     $item->lesson_id = $request->lesson_id;
        //     $item->success_mark = $request->success_mark;
        //     $item->lecture_id = $request->lecture_id;
        //     $item->period = $request->period;
        //     $item->start_time = $request->start_time;
        //     $item->note = $request->note;
        //     $item->term_id = $term->id;

        //     $item->end_time = $request->end_time;
        //     $item->type = '5';
        //     $item->type_file = '2';

        //     $item->save();
        // } else {
        //     $item =  new Lesson_teacher_room_term_exam();
        //     $item->class_id = $request->class_id;
        //     $item->room_id = $request->room_id;
        //     $item->teacher_id = auth()->user()->teacher_id;
        //     $item->name_quize = $request->name_exam;
        //     $item->lesson_id = $request->lesson_id;
        //     $item->success_mark = $request->success_mark;
        //     $item->lecture_id = $request->lecture_id;
        //     $item->period = $request->period;
        //     $item->start_time = $request->start_time;
        //     $item->note = $request->note;
        //     $item->term_id = $term->id;
        //     $item->end_time = $request->end_time;
        //     $item->type = '5';
        //     $item->type_file = '2';
        //     $item->save();
        // }
  if ($request->type == 3) {
      if($request->start_time > $request->end_time){

           session()->flash('error', 'يرجى تعديل الوقت');
            return redirect()->back()->with('error', '   يرجى تعديل الوقت   !! ');
      }
            $item =  new Lesson_teacher_room_term_exam();
            $item->class_id = $request->class_id;
            $item->room_id = $request->room_id;
            $item->teacher_id = auth()->user()->teacher_id;
            $item->name_quize1 = $request->name_exam;
            $item->lesson_id = $request->lesson_id;
            $item->success_mark = $request->success_mark;
            $item->lecture_id = $request->lecture_id;
            $item->period = $request->period;
            $item->start_time = $request->start_time;
            $item->note = $request->note;
            $item->term_id = $term->id;

            $item->end_time = $request->end_time;
            $item->type = '8';
            $item->type_file = '2';

            $item->save();
        }


        $studens = Room::find($request->room_id)->student;

        foreach ($studens as $student) {


            $item2 = new Exam_result;
            $item2->class_id = $request->class_id;
            $item2->room_id = $request->room_id;
            $item2->exam_id = $item->id;
            $item2->user_id = $student->id;
            $item2->lesson_id = $request->lesson_id;
            // $item2->start_time = $request->start_time;

            // $item2->end_time = $request->end_time;
            $item2->lecture_id = $request->lecture_id;

            $item2->type ='8';

            $item2->save();
        }
        return redirect()->back()->with('Add', 'تم اضافة الامتحان بنجاح ');
    }

    public function exams($class_id, $lecture_id, $room_id)
    {  
        $teacher_id = Auth::user()->teacher_id;
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
      $class = Classe::find($class_id);
        // $rooms = $class->room;
        $questions = question::where('class_id', $class_id)->get();
        $lecture_id = Lecture::find($lecture_id);
        $teacher = Teacher::with(['rooms.student' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($teacher_id);
        $exams = Lesson_teacher_room_term_exam::where('type', '8')->where('teacher_id', Auth::user()->teacher_id)->where('type_file', '1')->where('term_id', $term->id)->where('room_id', $room_id)->where('lecture_id', $lecture_id->id)->get();
        $classes = Classe::all();
        $students = User::all();
        $lessons = $class->lessons;
  $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_testtable', compact('objection','message','questions', 'teacher', 'room_id', 'lecture_id', 'exams', 'classes', 'class', 'lessons'));
    }


    public function chat()
    {
        // return $student_id ;
        $user_id = auth()->user()->id ;
        $teacher_id = auth()->user()->teacher_id ;
       $teacher = Teacher::find($teacher_id);
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);


        // pring lecture_tims
        $lecture_times = Lecture_time::all();
          // pring days
        $days = Day::all();

        // return $today_lectures  ;
        $now=Carbon::now() ;
        $minutes = 0;

        $now=Carbon::now();

        return view('teachers.chat',compact('teacher','now','teacher_id','days','today','minutes'));
    }


    public function teacher_schedule()
    {

         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        // return $student_id ;
        $user_id = auth()->user()->id ;
        $teacher_id = auth()->user()->teacher_id ;
       $teacher = Teacher::find($teacher_id);
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);


        // $room = Room::findOrFail($room_id);
        // $lessons = $room->lessons2 ;
        // pring teachers

        // pring lecture_tims
        $lecture_times = Lecture_time::all();
          // pring days
        $days = Day::all();
        // pring teacher schedule
        $schedule = Lesson_room_teacher_lecture_time::with('lesson','lecture_time')->
        with(['room.classes' => function($query){
            $query->select("id","name");
        }])
         ->join('lecture_times', 'lecture_times.id', '=', 'lesson_room_teacher_lecture_time.lecture_time_id')
        ->orderBy('lecture_times.start_time')
        ->select("lesson_room_teacher_lecture_time.*")
        ->where('teacher_id',$teacher_id)->get();

        // pring student schedule tracer
        $student_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::today())->
        where('user_id',$user_id)->get();
        $today_lectures = $schedule->where('day_id',$today +1) ;
        // return $today_lectures  ;
        $now=Carbon::now() ;
        $minutes = 0;
        foreach($today_lectures  as $key => $today_lecture){
            $tracer =  $student_schedule_tracer->where('lecture_time_id',$today_lecture->lecture_time_id);
                if (!blank($tracer)){
                     $today_lecture->attendance = true;
                }else {
                    $today_lecture->attendance = false;
                }
                   $lecture_time = Lecture_time::findOrFail($today_lecture->lecture_time_id);
                $hourMin = date('H:i');
                // $hourMin = \Carbon\Carbon::parse(date('H:i') );
                // $hourMin = $hourMin->addMinute(60)->format("H:i");
                if ( $hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time){
                    $today_lecture->inter = true;
                     $minutes = $now->diffInMinutes($lecture_time->end_time) ;
                }else{
                    $today_lecture->inter = false;
                }

        }

$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers2.teacher_schedule',compact('objection','message','teacher','now','teacher_id','lecture_times','days','schedule','today','minutes'));
    }

       public function available_schedule($teacher_id) {
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);


        $schedule_day = Lesson_room_teacher_lecture_time::with('lesson','room')
            ->where('teacher_id',$teacher_id)->where('day_id',$today +1)->get();
        $available_lecture = '';
        foreach($schedule_day  as $key => $today_lecture){
            $lecture_time = Lecture_time::findOrFail($today_lecture->lecture_time_id);

             $hourMin = date('H:i');
            if ( $hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time){
                $today_lecture->inter = true;
                $available_lecture = $today_lecture ;
                break;
            }
        }

       return $available_lecture;

    }

     public function google_meet_add(Request $request){

        $lecture_time = Lesson_room_teacher_lecture_time::findOrFail($request->lesson_time_id);
        // $this->validate($request, [
        //     'meeting_link' => 'required',
        // ],[
        //     'meeting_link.require' => 'يرجى إدخال الرابط',
        // ]);

        $lecture_time->meeting_link = $request->meeting_link;
        $lecture_time->save();
        // return $lecture_time ;
        return redirect()->back()->with('success','تم التخزين بنجاح');
    }



    // public function google_meets($teacher_id,$room_id,$lesson_id){
    //     $google_meets = Google_meet::with('lesson','room','teacher','lectureTime','day')
    //     ->where('teacher_id',$teacher_id)->orderBy('meeting_date')->paginate(10);
    //     $count=Google_meet::where('teacher_id',$teacher_id)->count();

    //     // return $room_id ;
    //     // return $lesson_id ;
    //     $teacher = Teacher::findOrFail($teacher_id) ;
    //     $lecture_times = Lecture_time::all();
    //     return view('teachers.new_teacher_google_meets',
    //     compact('google_meets','teacher','lecture_times','room_id','lesson_id','count')) ;
    // }

    // public function google_meet_add(Request $request){
    // //   return $request ;
    // //   $this->validate($request, [
    // //     'teacher_id' => 'required',
    // //     'room_id' => 'required',
    // //     'lesson_id' => 'required',
    // //     'meeting_date' => 'required',
    // //     'lecture_time_id' => 'required',
    // //     'link' => 'required',
    // // ],[
    // //     'teacher_id.required' => 'يرجى تحديد المدرس',
    // //     'room_id.required'=> 'يرجى تحديد الشعبة',
    // //     'lesson_id.required' => 'يرجى تحديد المادة',
    // //     'lecture_time_id.required' => 'يرجى تحديد الحصة',
    // //     'meeting_date.required' => 'يرجى تحديد تاريخ اللقاء',
    // //     'link.require' => 'يرجى إدخال الرابط',

    // // ]);

    // $item =  Google_meet::where('teacher_id',$request->teacher_id)
    // ->where('room_id',$request->room_id)->where('meeting_date',$request->meeting_date)
    // ->where('lecture_time_id',$request->lecture_time_id)->where('lesson_id',$request->lesson_id)->first();
    // // return $item ;
    // if (isset($item)){
    //     // return 25 ;
    //     return redirect()->back()->with('error','  هذا التوقيت غير متاح  هناك درس مجدول مسبقاً');
    // }


    // $this_day =  Carbon::parse($request->meeting_date)->format('l');
    // $this_day = $this->getDay($this_day);
    // // return $request ;
    // $item = new Google_meet ;
    // $item->name = $request->name;
    // $item->lesson_id = $request->lesson_id;
    // $item->room_id = $request->room_id;
    // $item->teacher_id = $request->teacher_id;
    // $item->lecture_time_id = $request->lecture_time_id;
    // $item->day_id = $this_day + 1;
    // $item->meeting_link = $request->meeting_link;
    // $item->meeting_date = $request->meeting_date;
    // $item->notes = $request->notes;
    // $item->save();
    // return redirect()->back()->with('success',' تم التخزين  بنجاح ');

    // }


    // public function google_meet_update(Request $request){
    // //   return $request ;
    // //   $this->validate($request, [
    // //     'teacher_id' => 'required',
    // //     'room_id' => 'required',
    // //     'lesson_id' => 'required',
    // //     'meeting_date' => 'required',
    // //     'lecture_time_id' => 'required',
    // //     'link' => 'required',
    // // ],[
    // //     'teacher_id.required' => 'يرجى تحديد المدرس',
    // //     'room_id.required'=> 'يرجى تحديد الشعبة',
    // //     'lesson_id.required' => 'يرجى تحديد المادة',
    // //     'lecture_time_id.required' => 'يرجى تحديد الحصة',
    // //     'meeting_date.required' => 'يرجى تحديد تاريخ اللقاء',
    // //     'link.require' => 'يرجى إدخال الرابط',

    // // ]);

    // $item =  Google_meet::findOrFail($request->meeting_id);


    // $this_day =  Carbon::parse($request->meeting_date)->format('l');
    // $this_day = $this->getDay($this_day);
    // // return $request ;

    // $item->name = $request->name;
    // $item->lesson_id = $request->lesson_id;
    // $item->room_id = $request->room_id;
    // $item->teacher_id = $request->teacher_id;
    // $item->lecture_time_id = $request->lecture_time_id;
    // $item->day_id = $this_day + 1;
    // $item->meeting_link = $request->meeting_link;
    // $item->meeting_date = $request->meeting_date;
    // $item->notes = $request->notes;
    // $item->save();
    // // return $item ;
    // return redirect()->back()->with('success',' تم التعديل  بنجاح ');

    // }

    // public function google_meet_delete(Request $request){
    //     $item =  Google_meet::findOrFail($request->meeting_id);
    //     if (isset($item))
    //     $item->delete() ;
    //     return redirect()->back()->with('success','تم الحذف بنجاح');
    // }


    public function go_to_stream($scheduler_id,$day_id,$lecture_time_id,$room_id,$student_id)
    {
        $user_id = auth()->user()->id ;
        $day = Day::findOrFail($day_id);
        $scheduler_record = Lesson_room_teacher_lecture_time::findOrFail($scheduler_id);

        $lecture_time = Lecture_time::findOrFail($lecture_time_id);
        $hourMin = date('H:i');
        // $hourMin = \Carbon\Carbon::parse(date('H:i') );
        // $hourMin = $hourMin->addMinute(60)->format("H:i");
        $end = $lecture_time->end_time;
        if ( $hourMin < $lecture_time->start_time || $hourMin > $lecture_time->end_time){
            return redirect()->back()->with('othertime','لايمكنك الدخول لحصة في غير  توقيتها');
        }

        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);
        if ($today != $day->id - 1){
            return redirect()->back()->with('otherday','لايمكنك الدخول لحصة في غير اليوم الحالي');
        }
        $student_schedule_tracer = new Student_schedule_tracer() ;
        $student_schedule_tracer->user_id = $user_id ;
        $student_schedule_tracer->lecture_time_id = $lecture_time_id ;
        $student_schedule_tracer->day_id = $day_id ;
        $student_schedule_tracer->save();
        $student = Teacher::findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name ;
        $google_meet_url = $scheduler_record->meeting_link ;
        redirect()->to($google_meet_url)->send();

        // return view('teachers.ter_stream',compact('room_name','room_id','class_name','student','room','end'));
    }

   public function myquestions(Request $request)
    {

        // $validatedData = $request->validate([
        //     'selected_ques' => 'required'
        // ],[
        //     'selected_ques.required' => 'قم باختيار الأسئلة من فضلك'
        // ]);

        if ($request->selected_ques1 == null) {
            session()->flash('error', 'لم يتم وضع السؤال   ');
            return redirect()->back()->with('error', 'لم يتم اختيار أي سؤال !! ');
        };
           $selected_ques = $request->selected_ques1;
        $show_result = 1;
        foreach($selected_ques as $question_id){
            $question = Question::findOrFail($question_id) ;
            if ($question->ques_type == 2){
                $show_result = 0;
                break ;
            }
        }


        $selected_ques = (object) $selected_ques; // convert the array to an object;;

        $exam = Lesson_teacher_room_term_exam::find($request->exam_id);
        $exam->selected_ques = json_encode($selected_ques);
        $exam->has_traditional = $show_result == 0 ? 1 : 0;
        $exam->save();

        $students_exam_result = Exam_result::where('exam_id',$exam->id)->get() ;
        foreach($students_exam_result as $students_result){
            if ($show_result == 0){
                $students_result->show_result = 0 ;
                $students_result->save() ;
             }else{
                $students_result->show_result = 1 ;
                $students_result->save() ;
             }
        }


        $studivs = array();
        foreach (json_decode($exam->selected_ques) as $x) {
            $studivs[] = $x;
        }
        session()->flash('success', 'تم وضع السؤال بنجاح   ');
        return redirect()->back()->with('success', '! تمت العملية بنجاح');

    }
    public function myquestions1(Request $request)
    {
        if(!$request->room_id){
            session()->flash('error1', 'لم يتم وضع  الشعبة    ');
        return redirect()->back()->with('error1', 'لم يتم اختيار أي شعبة !! ');
    }
    if ($request->selected_ques1 == null) {
        session()->flash('error', 'لم يتم وضع السؤال   ');
        return redirect()->back()->with('error', 'لم يتم اختيار أي سؤال !! ');
    }

    $selected_ques = $request->selected_ques1;
    $show_result = 1;
    foreach($selected_ques as $question_id){

          $question = Question::findOrFail($question_id) ;
          $question->active=1;
          $question->save();

        if ($question->ques_type == 2){
            $show_result = 0;
            break ;
        }
    }

    $selected_ques = (object) $selected_ques; // convert the array to an object;;
    foreach($request->room_id as $item){
        $exam = Exams2::find($item);
        $exam->selected_ques = json_encode($selected_ques);
        // if there is traditonal ques then put 1 in has_traditon and 0 in show result
        $exam->has_traditional = $show_result == 0 ? 1 : 0;
        $exam->save();

        $students_exam_result = Exam_result2::where('exam_id',$exam->id)->get() ;
        foreach($students_exam_result as $students_result){
            if ($show_result == 0){
                $students_result->show_result = 0 ;
                $students_result->save() ;
            }else{
                $students_result->show_result = 1 ;
                $students_result->save() ;
            }
        }


    }


    $studivs = array();
    foreach (json_decode($exam->selected_ques) as $x) {
        $studivs[] = $x;
    }

    session()->flash('success', 'تم وضع السؤال بنجاح   ');
    return redirect()->back()->with('success', '! تمت العملية بنجاح');

    }

    public function examstudent($lec,$home ,Request $request)
    {
        if ($lec == 1) {
            $ro1=[];
            $student=[];
	     $exam_id=Exam_result::where('exam_id',$home)->where('result','!=',null)->get();

         if($exam_id){
            foreach( $exam_id as $item ){
                $ro1[]=$item->room_id;
                $student[]=$item->user_id;

            }

               $room = Room::whereIn('id',$ro1)->first();

            $students = Student:: with('student_lesson_teacher_room_term_exam')->with('exam_result')->
               whereIn('id',$student)->get();

               $exam1 = Lesson_teacher_room_term_exam::find($lec);
            //    $quize_result = Room::with(['student.exam_result' => function ($q) {
            //        $q->where('id', '<>', null)->orderBy('type');
            //    }])->where('id', $room->room_id)->get();

                    return  $students;

              }
         }
         elseif($lec == 2){
            $ro1=[];
            $student=[];
            $student123=[];
                  $exam_id=Exam_result::where('exam_id',$home)->where('result','!=',null)->get();
         if($exam_id->count()>0) {

            foreach( $exam_id as $item ){
                $ro1[]=$item->room_id;
                $student[]=$item->user_id;

            }


            $room = Room::whereIn('id',$ro1)->first();
            $room_student=Room_student::where('room_id',$room->id)->get();

            foreach( $room_student as $item ){

                            $student123[]=$item->student_id ;

                        }


               $student123=  array_diff($student123,$student);

            $students = Student:: with('student_lesson_teacher_room_term_exam')->with('exam_result')->

            whereIn("id",$student123)->get();

               $exam1 = Lesson_teacher_room_term_exam::find($lec);
            //    $quize_result = Room::with(['student.exam_result' => function ($q) {
            //        $q->where('id', '<>', null)->orderBy('type');
            //    }])->where('id', $room->room_id)->get();

                    return  $students;

              }
              else{


                   $room = Room::find($request->room_id);

                    $students = $room->with('student.student_lesson_teacher_room_term_exam')->with('student.exam_result')->get();
                     return  $students;

              }
            }
              else{

                $ro1=[];
                $student=[];
               $exam_id=Exam_result::where('exam_id',$home)->where('result',null)->get();

             if($exam_id){
                foreach( $exam_id as $item ){
                    $ro1[]=$item->room_id;
                    $student[]=$item->user_id;

                }


                     $room = Room::whereIn('id',$ro1)->first();

                $students = Student:: with('student_lesson_teacher_room_term_exam')->with('exam_result')->
                   whereIn('id',$student)->get();


                   $exam1 = Lesson_teacher_room_term_exam::find($lec);
                //    $quize_result = Room::with(['student.exam_result' => function ($q) {
                //        $q->where('id', '<>', null)->orderBy('type');
                //    }])->where('id', $room->room_id)->get();



              return  $students;
              }


         }


        }
         public function studentselect($exam,$room)
    {
        $exam_id=Exam_result2::where('exam_id',$exam)->where('room_id',$room)->get();
         foreach( $exam_id as $item ){

                $student[]=$item->user_id;

            }
      return    $students = Student:: whereIn('id',$student)->get();

    }

  public function examstudent2($lec,$home,$room_id ,Request $request)
    {
        if ($lec == 1) {
            $ro1=[];
            $student=[];
	     $exam_id=Exam_result2::where('exam_id',$home)->where('result','!=',null)->get();

         if($exam_id){
            foreach( $exam_id as $item ){
                $ro1[]=$item->room_id;
                $student[]=$item->user_id;

            }

               $room = Room::where('id',$room_id)->first();

            $students = Student:: with('exams_files')->with('exam_result2')->
               whereIn('id',$student)->get();

               $exam1 = Exam_file::find($lec);
            //    $quize_result = Room::with(['student.exam_result' => function ($q) {
            //        $q->where('id', '<>', null)->orderBy('type');
            //    }])->where('id', $room->room_id)->get();

                    return  $students;

              }
         }
         elseif($lec == 2){
            $ro1=[];
            $student=[];
            $student123=[];
                  $exam_id=Exam_result2::where('exam_id',$home)->where('result','!=',null)->get();
         if($exam_id->count()>0) {

            foreach( $exam_id as $item ){
                $ro1[]=$item->room_id;
                $student[]=$item->user_id;

            }


            $room = Room::where('id',$room_id)->first();
            $room_student=Room_student::where('room_id',$room_id)->get();

            // foreach( $room_student as $item ){

            //                 $student123[]=$item->student_id ;

            //             }
            $studen12t=[];
            $student12=[];
              $exam_id1=Exam_result2::where('exam_id',$home)->where('room_id',$room_id)->get();
            foreach($exam_id1 as $item){
                        $student12[]= $item->user_id;
                     }



               $student12=  array_diff($student12,$student);

            $students = Student:: with('exams_files')->with('exam_result2')->

            whereIn("id",$student12)->get();

               $exam1 = Lesson_teacher_room_term_exam::find($lec);
            //    $quize_result = Room::with(['student.exam_result' => function ($q) {
            //        $q->where('id', '<>', null)->orderBy('type');
            //    }])->where('id', $room->room_id)->get();

                    return  $students;

              }
              else{



                   $room = Room::find($request->room_id);
 $exam_id1=Exam_result2::where('exam_id',$home)->where('room_id',$room_id)->get();
            foreach($exam_id1 as $item){
                        $student12[]= $item->user_id;
                     }



               $student12=  array_diff($student12,$student);

                    $students = Student:: with('exams_files')->with('exam_result2')->

            whereIn("id",$student12)->get();
                     return  $students;

              }
            }
              else{

                $ro1=[];
                $student=[];
               $exam_id=Exam_result2::where('exam_id',$home)->where('result',null)->get();

             if($exam_id){
                foreach( $exam_id as $item ){
                    $ro1[]=$item->room_id;
                    $student[]=$item->user_id;

                }


                     $room = Room::whereIn('id',$room_id)->first();

                $students = Student:: with('student_lesson_teacher_room_term_exam')->with('exam_result')->
                   whereIn('id',$student)->get();


                   $exam1 = Lesson_teacher_room_term_exam::find($lec);
                //    $quize_result = Room::with(['student.exam_result' => function ($q) {
                //        $q->where('id', '<>', null)->orderBy('type');
                //    }])->where('id', $room->room_id)->get();



              return  $students;
              }


         }


        }

    public function homeworkestudent($lec,$home)
    {
        if ($lec == 1) {
            $ro1=[];
            $student=[];
	    $exam_id=Student_lesson_teacher_room_term_exam::where('exam_id',$home)->where('file','!=',null)->get();

         if($exam_id){
            foreach( $exam_id as $item ){

                $ro1[]=$item->room_id;



            }
             $room = Room::whereIn('id',$ro1)->first();
             $room_student=Room_student::where('room_id',$room->id)->get();


       foreach( $exam_id as $item ){
                foreach( $room_student as $item1 ){
                $ro1[]=$item->room_id;
                if($item1->student_id== $item->student_id){
                $student[]=$item->student_id;
}
            }}
                  $students = Student:: with('student_lesson_teacher_room_term_exam')->with('exam_result')->
               whereIn('id',$student)->get();

               $exam1 = Lesson_teacher_room_term_exam::find($lec);
               $quize_result = Room::with(['student.exam_result' => function ($q) {
                   $q->where('id', '<>', null)->orderBy('type');
               }])->where('id', $room->id)->get();

                    return  $students;

              }
         }
         elseif($lec == 2){
            $ro1=[];
            $student=[];
            $student123=[];
	        $exam_id=Student_lesson_teacher_room_term_exam::where('exam_id',$home)->where('file','!=',null)->get();
         if($exam_id){
            foreach( $exam_id as $item ){
                $ro1[]=$item->room_id;
                $student[]=$item->student_id;

            }

               $room = Room::whereIn('id',$ro1)->first();


                $student12 = $room->with('student.student_lesson_teacher_room_term_exam')->with('student.exam_result')->get();

               foreach( $student12 as $item ){
                 if($item->id ==  $room->id){
                       foreach( $item->student as $item1 ){


                $student123[]=$item1->id;

            }
                 }

                 }

                        $student123=  array_diff($student123,$student);






            $students = Student:: with('student_lesson_teacher_room_term_exam')->with('exam_result')->

            whereIn("id",$student123)->get();

               $exam1 = Lesson_teacher_room_term_exam::find($lec);
               $quize_result = Room::with(['student.exam_result' => function ($q) {
                   $q->where('id', '<>', null)->orderBy('type');
               }])->where('id', $room->id)->get();

                    return  $students;

              }
         }




    }
        public function quizestudent($lec,$home,$room_id)
    {
        if ($lec == 1) {
            $ro1=[];
            $student=[];
	    $exam_id=Exam_file::where('exam_id',$home)->where('file','!=',null)->get();

         if($exam_id){
        //     foreach( $exam_id as $item ){

        //         $ro1[]=$item->room_id;



        //     }

             $room = Room::where('id',$room_id)->first();
               if($room){
                    $room_student=Room_student::where('room_id',$room->id)->get();
               }



       foreach( $exam_id as $item ){
                foreach( $room_student as $item1 ){
                $ro1[]=$item->room_id;
                if($item1->student_id== $item->student_id){
                $student[]=$item->student_id;
}
            }}
                  $students = Student:: with('exams_files')->with('exam_result2')->
               whereIn('id',$student)->get();

               $exam1 = Exams2::find($lec);
               if($room){
                     $quize_result = Room::with(['student.exam_result2' => function ($q) {
                   $q->where('id', '<>', null)->orderBy('type');
               }])->where('id', $room->id)->get();
               }


                    return  $students;

              }}

         elseif($lec == 2){
            $ro1=[];
            $student=[];
            $student123=[];
	        $exam_id=Exam_file::where('exam_id',$home)->where('file','!=',null)->get();
         if($exam_id){
            foreach( $exam_id as $item ){
                $ro1[]=$item->room_id;
                $student[]=$item->student_id;

            }

               $room = Room::whereIn('id',$ro1)->first();


            //     $student12 = $room->with('student.exams_files')->with('student.exam_result2')->get();

            //   foreach( $student12 as $item ){
            //      if($item->id ==  $room->id){
            //           foreach( $item->student as $item1 ){


            //     $student123[]=$item1->id;

            // }
            //      }

            //      }

            //             $student123=  array_diff($student123,$student);






            // $students = Student:: with('exams_files')->with('exam_result2')->

            // whereIn("id",$student123)->get();
             $studen12t=[];
              $exam_id1=Exam_result2::where('exam_id',$home)->where('room_id',$room_id)->get();
            foreach($exam_id1 as $item){
                        $student12[]= $item->user_id;
                     }



               $student12=  array_diff($student12,$student);

            $students = Student:: with('exams_files')->with('exam_result2')->

            whereIn("id",$student12)->get();
               $exam1 = Exams2::find($lec);
            //   $quize_result = Room::with(['student.exam_result2' => function ($q) {
            //       $q->where('id', '<>', null)->orderBy('type');
            //   }])->where('id', $room->id)->get();

                    return  $students;

              }
         }




    }

    public function lecquestion1($lec, $exam,Request $request)
    {
        if ($lec != 0) {

            $questions = question::with('classes')->with('lecture')->where('lecture_id', $lec)->where('teacher_id',auth()->user()->teacher_id)->get();
        } else {
            $exam1 = Lesson_teacher_room_term_exam::find($exam);
            if ($exam1) {
                $questions = question::with('classes')->with('lecture')->where('class_id', $exam1->class_id)->where('lesson_id', $exam1->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
            } else {
                $questions = question::with('classes')->with('lecture')->where('class_id', $request->class_id)->where('lesson_id', $request->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
            }
        }

        return $questions;
    }
    public function lecquestion($lec, $exam,Request $request)
    {
        if ($lec != 0) {

            $questions = question::with('classes')->with('lecture')->where('lecture_id', $lec)->where('teacher_id',auth()->user()->teacher_id)->get();
        } else {
            $exam1 = Lesson_teacher_room_term_exam::find($exam);
            if ($exam1) {
                $questions = question::with('classes')->with('lecture')->where('class_id', $exam1->class_id)->where('lesson_id', $exam1->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
            } else {
                $questions = question::with('classes')->with('lecture')->where('class_id', $request->class_id)->where('lesson_id', $request->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
            }
        }

        return $questions;
    }

      public function search(Request $request)
    {

        $exam1 = Exams2::find($request->exam);
        if ($exam1) {
            $questions = question::with('classes')->with('lecture')->where('class_id', $exam1->class_id)->where('lesson_id', $exam1->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        } else {
     $questions = question::with('classes')->with('lecture')->where('class_id', $request->exam)->where('lesson_id', $request->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        }

        if ($questions) {
            return $questions;
        } else return 1;
    }

  public function exam_update(Request $request)
    {



        $validatedData = $request->validate([

            'start_time' => 'required',
            'end_time' => 'required',

        ], [
            // 'admin_id.required' => '',

            'start_time.required' => 'يرجى ادخال بداية الامتحان',
            'end_time.required' => 'يرجى ادخال نهاية الامتحان',

        ]);

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam = Lesson_teacher_room_term_exam::find($request->exam_id);

        if ($request->type == 1 ) {

            $exam->class_id = $exam->class_id;
            $exam->room_id = $exam->room_id;
            $exam->teacher_id = auth()->user()->teacher_id;
            if($request->name !=null){
                $exam->name_exam = $request->name;
            }
            else{
                $exam->name_exam = $request->name;
            }

            $exam->lesson_id = $exam->lesson_id;
             $exam->success_mark = $request->success_mark;
            $exam->lecture_id = $exam->lecture_id;
            $exam->period = $request->period;
            $exam->start_time = $request->start_time;
            $exam->note = $request->note;
            $exam->term_id = $term->id;

            $exam->end_time = $request->end_time;
            $exam->type = '8';
            $exam->type_file = '2';

            $exam->save();
        } else {

            // $exam->class_id = $exam->class_id;
            // $exam->room_id = $exam->room_id;
            // $exam->teacher_id = auth()->user()->teacher_id;
            // $exam->name_quize = $request->name;
            // $exam->lesson_id = $exam->lesson_id;
            // $exam->success_mark = $request->success_mark;
            // $exam->lecture_id = $exam->lecture_id;
            // $exam->period = $request->period;
            // $exam->start_time = $request->start_time;
            // $exam->note = $request->note;
            // $exam->term_id = $term->id;
            // $exam->end_time = $request->end_time;
            // $exam->type = '8';
            // $exam->type_file = '2';
            // $exam->save();
        }
        if ($request->room_id != $exam->room_id) {

            Exam_result::where('exam_id', $request->exam_id)->delete();


            $studens = Room::find($exam->room_id)->student;

            foreach ($studens as $student) {


                $item2 = new Exam_result;
                $item2->class_id = $exam->class_id;
                $item2->room_id = $exam->room_id;
                $item2->exam_id = $exam->id;
                $item2->user_id = $student->id;
                $item2->type = $request->type;
                // $item2->start_time = $request->start_time;

                // $item2->end_time = $request->end_time;
                $item2->save();
            }
            return redirect()->back()->with('update', 'تم تعديل الامتحان بنجاح ');
        }

        $results = Exam_result::where('exam_id', $exam->id)->get();
        foreach ($results as $item) {
            $item->update([
                'class_id' => $request->class_id,
                'room_id' => $request->room_id,
                'type' => $request->type,

            ]);
        }

        return redirect()->back()->with('update', 'تم تعديل الامتحان بنجاح ');
    }

    public function exams_addquestion($exam_id,$lecture_id,$room_id)
    {
        $teacher_id = Auth::user()->teacher_id;
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam = lesson_teacher_room_term_exam::find($exam_id);
        $lectures = Lecture::where('active', 0)->where('term_id', $term->id)->where('class_id', $exam->class_id)->where('lesson_id',$exam->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $questions = Question::where('class_id', $exam->class_id)->where('lesson_id', $exam->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_examquestion', compact('teacher_id','objection','questions', 'exam', 'lectures','lecture_id','room_id'));
    }

     public function exams1_addquestion($exam_id,$room_id,$class_id,$lesson_id)
   {
    $classes=[];
    $teacher_id = Auth::user()->teacher_id;
    $teacher_id =  Teacher::find($teacher_id);
    $teacher_room_lessons = Teacher_room_lesson::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id->id)->get();

          foreach ($teacher_room_lessons as $item) {

            $classes[] = $item->room_id;
        }

        $exam = lesson_teacher_room_term_exam::find($exam_id);
       $year = Year::where('current_year', '1')->first();
       $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
       $exam = Exams2::find($exam_id);
       $exams=Exams2::with('room')->whereIn('room_id',$classes)->where('groupe',$exam->groupe)->get();
       $questions = Question::where('class_id', $exam->class_id)->where('lesson_id', $exam->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $lectures = Lecture::where('active', 0)->where('term_id', $term->id)->where('class_id', $exam->class_id)->where('lesson_id',$exam->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();

      $class_id = Classe:: find($exam->class_id);

$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();

       return view('teachers.exams1_addquestion', compact('lectures','objection','questions', 'exam','class_id', 'teacher_id','room_id','exams','lesson_id','class_id'));
   }

      public function detexam(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
         $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find(auth()->user()->teacher_id);
         $classes=[];

          $teacher_room_lessons = Teacher_room_lesson::where('lesson_id', $request->lesson_id)->where('teacher_id', $teacher->id)->get();

          foreach ($teacher_room_lessons as $item) {

            $classes[] = $item->room_id;
        }
         $exam = Exams2::with('room')->whereIn('room_id',$classes)->where('groupe',$request->groupe)->get();

         return $exam;

    }

    public function sections($class_id, $room_id, $lecture_id, $lesson_id)
    {
         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $class = Classe::find($class_id);
        $classes = Classe::all();
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $sections = Section::where('class_id', $class_id)->where('lesson_id', $lesson_id)->where('teacher_id',auth()->user()->teacher_id)
        ->where('term_id', $term->id)->get();
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $rooms = $class->room;
        $Lecture = Lecture::find($lecture_id);
       $questions = Question::where('class_id', $class_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();

$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_addsection', compact('objection','message','class', 'lesson_id', 'room_id', 'Lecture', 'classes', 'sections', 'teacher', 'rooms', 'questions'));
    }

        public function section_update(Request $request)
    {
        // Validate title input
        $request->validate([
            'title' => 'required',
        ]);

        // Ensure type is valid
        if (!in_array($request->type, ['0', '2', '3'])) {
            session()->flash('error', 'Invalid content type!');
            return redirect()->back()->with('error', 'Failed! Invalid content type.');
        }

        // Fetch current year and term
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        // Find the section by ID
        $section = Section::find($request->section_id);

        // Update section attributes
        $section->teacher_id = auth()->user()->teacher_id;
        $section->title = $request->title;
        $section->term_id = $term->id;

        // Check if the content is text (type == 0)
        if ($request->type == '0') {
            // Directly update the text content
            $section->content = $request->content; // Update content with the text from the request
        }

        // If the content is an audio or image file, handle file storage
        if (($request->type == '2' || $request->type == '3') && $request->hasFile('content')) {
            // Delete old file if it exists
            if ($section->content) {
                Storage::disk('public')->delete($section->content);
            }
            // Store the new file
            $section->content = $request->content->store('sectionfiles', 'public');
        }

        // Update the section type
        $section->type = $request->type;

        // Save the section changes
        $section->save();

        // Flash success message and redirect
        session()->flash('update', 'تم تعديل المحتوى بنجاح');
        return redirect()->back()->with('update', '! تمت العملية بنجاح');
    }

     public function section_store(Request $request)
    {
          $request->validate([

        'title'=>'required',



    ]);
     $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    if( $request->type!='0' &&  $request->type!='3' && $request->type!='2' ){
        session()->flash('error', 'تم اضافة السؤال بنجاح ');
        return redirect()->back()->with('error', '! تمت العملية بنجاح ');
    }
        $item = new Section;
         $item->term_id = $term->id;
        $item->teacher_id = auth()->user()->teacher_id ;
        $item->class_id = $request->class_id;
        $item->room_id = $request->room_id;
        $item->lesson_id = $request->lesson_id;
        $item->lecture_id = $request->lecture_id;
        $item->type = $request->type;
        $item->title = $request->title;
        if ($request->type == '0') {
            $item->content = $request->content;
        } elseif ($request->type == '3') {


            if ($request->hasFile('content2')) {


                $item->content = $request->content2->store('sectionfiles', 'public');
            }
        } else {
            if ($request->hasFile('content')) {


                $item->content = $request->content->store('sectionfiles', 'public');
            }
        }

        $item->save();

        session()->flash('Add', 'تم اضافة السؤال بنجاح ');
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
     public function question_edit($id,$room_id)
    {

        $questions = Question::where('id', $id)->first();
        $class_id = $questions->class_id;
        $classes = Classe::all();
        $room_id = Room::where('class_id', $class_id)->where('id', $room_id)->first();
        $sections = Section::where('class_id', $class_id)->where('lesson_id', $questions->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $item = Question::where('id', $id)->first();
        $Lecture = Lecture::where('class_id', $item->class_id)->where('active',0)->get();

        return view('edit-question.update_question', compact('questions', 'room_id','class_id', 'Lecture', 'id', 'sections', 'item'));
    }
    public function question_update(Request $request, $question_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $question = question::find($question_id);

        if ($request->ques_type == 2) {
            // $this->validate(
            //     $request,
            //     [
            //         'question_form' => 'required',
            //         'answer' => 'required',

            //         'mark' => 'required',

            //     ],
            //     [
            //         'question_form.required' => 'يرجي ادخال صيغة السؤال',
            //         'answer.required' => 'يرجي ادخال إجابة السؤال',
            //         'mark.required' => 'يرجي ادخال علامة السؤال',
            //         'class_id.required' => 'يرجي ادخال اسم القسم',

            //     ]
            // );

            if($request->question_form){
                $question->question_form = $request->question_form;
            }
            else{
                $question->question_form = $question->question_form;
            }
            if($request->answer){
                $question->answer = $request->answer;
            }
            else{
                $question->answer = $question->answer;
            }

            if($request->mark){
                $question->mark = $request->mark;
            }
            else{
                $question->mark = $question->mark;
            }
            $question->ques_type = $request->ques_type;

            $question->class_id = $request->class_id;
            $question->section_id = $request->section_id;
            $question->lecture_id = $request->lecture_id;
            $question->lesson_id = $question->lesson_id;
            $question->teacher_id = auth()->user()->teacher_id;
            $question->term_id = $term->id;
            $question->note = $request->note;
            $question->save();
            // $options = $users = DB::select('select * from options');
            // $options = option::where('qusetion_id',$id);
        } else {

            // dd($request);
            // $this->validate(
            //     $request,
            //     [
            //         'question_form' => 'required',
            //         'answer' => 'required',

            //         'mark' => 'required',
            //         'option' => 'required',
            //     ],
            //     [
            //         'question_form.required' => 'يرجى إدخال صيغة السؤل',
            //         'answer.required' => 'يرجى إدخال الإجابة',
            //         'class_id.required' => 'يرجى إدخال القسم',
            //         'option.required' =>  ' يرجى إدخال الخيارات ',
            //         'mark.required' => 'يرجي ادخال علامة السؤال',

            //     ]
            // );

            // $options = new stdClass();
            // $options->option1 =  $request->option1 ;
            // $options->option2 =  $request->option2 ;
            // $options->option3 =  $request->option3 ;
            // $options->option4 =  $request->option4 ;
            // dd($options);
            if($request->question_form){
                $question->question_form = $request->question_form;
            }
            else{
                $question->question_form = $question->question_form;
            }
            if($request->answer){
                $question->answer = $request->answer;
            }
            else{
                $question->answer = $question->answer;
            }

            $question->ques_type = $request->ques_type;
            $question->term_id = $term->id;
            $question->class_id = $request->class_id;
            $question->section_id = $request->section_id;
            $question->lecture_id = $request->lecture_id;
            $question->lesson_id = $question->lesson_id;
            $question->teacher_id = auth()->user()->teacher_id;
            if($request->mark){
                $question->mark = $request->mark;
            }
            else{
                $question->mark = $question->mark;
            }


            $question->note = $request->note;
            $question->save();
            // تقوم بجلب آخر ريكورد تم إضافته للداتا بيز
            // $data = DB::select('select * from questions order by Created_at desc limit 1');

            // dd($data[0]->id);
            // $option = option::find($question->id);
            $option = option::where('question_id', $question->id)->first();
            $option->update([
                'question_id' => $question->id,
                'myOptions' => json_encode($request->option),
            ]);
        }
        session()->flash('update', 'تم تعديل السؤال بنجاح');
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function add_questions($class_id, $room_id, $lecture_id, $lesson_id)
    {
        $class = Classe::find($class_id);
        $room = Room::where('class_id', $class_id)->where('id', $room_id)->first();
        $Lecture = Lecture::find($lecture_id);
        $classes = Classe::all();
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
       $questions = Question::where('class_id', $class_id)->where('lesson_id', $lesson_id)->where('term_id', $term->id)->where('teacher_id',auth()->user()->teacher_id)->get();

     $sections = Section::where('class_id', $class_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
   foreach($sections as $key => $item ){
       if(($item->type==3 ||  $item->type==2) && $item->content==null ){
           $sections->forget($key);

       }

   }


        $back=URL::previous();
        $teacher = Teacher::find(auth()->user()->teacher_id);
        return view('edit-question.edit_question', compact('class','back', 'Lecture', 'room_id', 'classes', 'questions', 'sections', 'teacher','lesson_id'));
    }


    public function questions($class_id, $room_id, $lecture_id, $lesson_id)
    {
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class = Classe::find($class_id);
        $lecture_id = Lecture::find($lecture_id);
        $room = Room::where('class_id', $class_id)->where('id', $room_id)->first();
        $classes = Classe::all();
        $questions = Question::where('class_id', $class->id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $sections = Section::where('class_id', $class_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $lectures = Lecture::where('active', 0)->where('class_id', $class_id)->where('lesson_id',$lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $teacher = Teacher::find(auth()->user()->teacher_id);
       $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
       $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_add_automated',
        compact('objection','message','class','lectures',
         'lecture_id', 'lesson_id', 'room_id', 'classes', 'questions', 'sections', 'teacher'));
    }
    public function StudentsRoomLesson_quize1($room_id, $teacher_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $quize = Lesson_teacher_room_term_exam::where('term_id', $term->id)->where('teacher_id', $teacher_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type','8')->get();

        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

        $students = $room->student;

        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
         $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_quize1', compact('objection','message','quize', 'students', 'teacher', 'lesson', 'room','lesson_id', 'room_id', 'count', 'count2'));
    }
    public function StudentsRoomLesson_quize($room_id, $teacher_id, $lesson_id)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $quizes  = Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '2')->where('is_file', '1')->get();
        $quize1 = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '2')->where('is_file','0')->get();
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);
        $class_id = Classe:: find($room->classes->id);
        $students = $room->student;
        $students1 = $room->student;
        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
         $lecture = Lecture::where('lesson_id',$lesson->id)->where('class_id',$class_id->id)->where('active',0)->get();
          $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_quize', compact('objection','lecture','students1','message','quizes','class_id', 'quize1','students','room','lesson' ,'teacher','now', 'lesson_id', 'room_id', 'count', 'count2'));
    }

    public function StudentsRoomLesson_exam($room_id, $teacher_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $quizes  = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '1')->where('is_file', '1')->get();
        $quize1 = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '1')->where('is_file','0')->get();
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

        $class_id = Classe:: find($room->classes->id);
        $students = $room->student;

        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $students1 = $room->student;
        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $lecture = Lecture::where('lesson_id',$lesson->id)->where('class_id',$class_id->id)->where('active',0)->get();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_exam', compact('objection','lecture','students1','message','quizes', 'class_id','now','students', 'teacher','lesson', 'room','lesson_id', 'room_id', 'count', 'count2','quize1'));
    }

    public function StudentsRoomLesson_homeworke($room_id, $teacher_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $homeworke = Lesson_teacher_room_term_exam::where('term_id', $term->id)->where('teacher_id', $teacher_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('namehomework', "!=", null)->get();

        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

        $students = $room->student;

        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();
        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_homework', compact('objection','message','homeworke', 'students','lesson','room', 'teacher', 'lesson_id', 'room_id', 'count', 'count2'));
    }

    public function StudentsRoomLesson($room_id, $teacher_id, $lesson_id, $exam_id)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();


         $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find( auth()->user()->teacher_id);

        $room = Room::find($room_id);

        $students = $room->with('student.student_lesson_teacher_room_term_exam')->with('student.exam_result')->get();

        $exam1 = Lesson_teacher_room_term_exam::find($exam_id);
        $quize_result = Room::with(['student.exam_result' => function ($q) {
            $q->where('id', '<>', null)->orderBy('type');
        }])->where('id', $room_id)->get();

        $exam_title = Lesson_teacher_room_term_exam::where('room_id', $room_id)->where('lesson_id', $lesson_id)
            ->where('teacher_id', $teacher_id)->orderBy('type')->get();
          $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_homworke_mark', compact('objection','message','students', 'exam1','lesson' ,'room','exam_title', 'quize_result', 'teacher', 'exam_id', 'lesson_id', 'room_id'));
    }

     public function export_exam($exam_id, $room_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term_id = Exams2::find($exam_id)->term_id;
        $term = Term_year::where('id', $term_id)->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);

        $exam = Exam_result2::where('exam_id', $exam_id)->where('room_id', $room_id)->get();
        foreach ($exam as $item) {
            $student[] = $item->user_id;
        }



        $student_mark = Students_mark::whereIn('student_id', $student)->where('year_id', $year->id)->get();
        if ($term->type == "1") {

            foreach ($student_mark as $item) {
                foreach ($exam as $item1) {
                    if ($item->student_id    == $item1->user_id) {
                        $object1 = json_decode($item->mark, true);
                        if ($item1->result == null) {
                            $object1[$lesson_id]['quize'] = 0;
                        } else {
                            if ($item1->result > ($lesson->max_mark * 0.2)) {

                                session()->flash('success', 'تم تعديل  بنجاح');

                                return redirect()->back()->with('error', '! تمت العملية بنجاح');
                            } else {
                                $object1[$lesson_id]['quize'] = $item1->result;
                            }
                        }
                        if ($item->worke_degree) {
                            $object_worke_degree = json_decode($item->worke_degree, true);
                            foreach (json_decode($item->worke_degree) as $key => $item2) {
                                $count = 0;
                                if ($key != $lesson_id) {
                                    $count = 1;
                                    break;
                                }
                            }
                            if ($count == 1) {

                                $object_worke_degree[$lesson_id]['term1_result'] = "null";
                                $object_worke_degree[$lesson_id]['term2_result'] = "null";
                            }



                            $object_worke_degree[$lesson_id]['term1_result'] = $object1[$lesson_id]['oral'] + $object1[$lesson_id]['activities'] + $object1[$lesson_id]['homework'] + $object1[$lesson_id]['quize'];
                            if ($object_worke_degree[$lesson_id]['term2_result'] != "null") {
                                $object_worke_degree[$lesson_id]['term2_result'] = $object_worke_degree[$lesson_id]['term2_result'];
                            } else {
                                $object_worke_degree[$lesson_id]['term2_result'] = "null";
                            }
                        } else {
                            $object_worke_degree[$lesson_id]['term1_result'] = $object1[$lesson_id]['oral'] + $object1[$lesson_id]['activities'] + $object1[$lesson_id]['homework'] + $object1[$lesson_id]['quize'];
                            $object_worke_degree[$lesson_id]['term2_result'] = "null";
                        }


                        $object_result1 = json_decode($item->result1, true);
                        $object_result1[$lesson_id]['term1_quizes'] = ceil($object1[$lesson_id]['oral']) +
                            ceil($object1[$lesson_id]['homework']) + ceil($object1[$lesson_id]['activities']) + ceil($object1[$lesson_id]['quize']);
                        $object_result1[$lesson_id]['term1_exam'] = ceil($object1[$lesson_id]['exam']);
                        $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);

                        $object_result2 = json_decode($item->result2, true);

                        $object_result = json_decode($item->result, true);
                        if ($item->result) {
                            $object_result = json_decode($item->result, true);

                            if (!json_decode($item->result2, true)) {


                                $object_result2[$lesson_id]['term2_result'] = 0;
                            }



                            $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);
                            $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
                        }

                        $item->update([
                            'room_id' => $room_id,
                            'lesson_id' => $lesson_id,
                            'mark' => json_encode($object1),
                            'result1' => json_encode($object_result1),
                            'worke_degree' => json_encode($object_worke_degree),
                            'result' => json_encode($object_result),
                            'status' => '1',
                        ]);
                        if ($item->estimation1) {
                            $stc = json_decode($item->estimation1, true);
                            if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= "0" && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 40) {

                                $stc[$lesson_id] = "ضعيف";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 70) {
                                $stc[$lesson_id] = "وسط";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 80) {
                                $stc[$lesson_id] = "جيد";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 90) {
                                $stc[$lesson_id] = "جيد حداًً";
                                $item->estimation1 = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 100) {

                                $stc[$lesson_id] = "ممتاز";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            }
                        } else {
                            $stc = new stdClass;
                            if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= "0" && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 40) {

                                $stc->{$lesson_id} = "ضعيف";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 70) {
                                $stc->{$lesson_id} = "وسط";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 80) {
                                $stc->{$lesson_id} = "جيد";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 90) {
                                $stc->{$lesson_id} = "جيد حداًً";
                                $item->estimation1 = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 100) {

                                $stc->{$lesson_id} = "ممتاز";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            }
                        }
                        $result_term1 = 0;
                        $count = 0;
                        foreach (json_decode($item->result1, true) as $key1 => $value1) {

                            $result_term1 = $result_term1 + $value1['term1_result'];
                            $count++;
                        }
                        $objec_term_result = json_decode($item->term_result, true);
                        $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 / $count : "0";

                        $item->term_result = json_encode($objec_term_result);
                        $item->year_result = (json_decode($item->term_result, true)['term1']
                            + json_decode($item->term_result, true)['term2']) / 2;
                        $item->save();



                        if ($item->estimation) {
                            $stc = json_decode($item->estimation, true);
                            if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= "0" && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 40) {

                                $stc[$lesson_id] = "ضعيف";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 41 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 70) {
                                $stc[$lesson_id] = "وسط";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 71 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 80) {
                                $stc[$lesson_id] = "جيد";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 81 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 90) {
                                $stc[$lesson_id] = "جيد حداًً";
                                $item->estimation = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 91 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 100) {

                                $stc1[$lesson_id] = "ممتاز";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            }
                        } else {
                            $stc1 = new stdClass;
                            if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= "0" && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 40) {

                                $stc1->{$lesson_id} = "ضعيف";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 41 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 70) {
                                $stc1->{$lesson_id} = "وسط";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 71 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 80) {
                                $stc1->{$lesson_id} = "جيد";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 81 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 90) {
                                $stc1->{$lesson_id} = "جيد حداًً";
                                $item->estimation = json_encode($stc1);

                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 91 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 100) {

                                $stc1->{$lesson_id} = "ممتاز";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            }
                        }
                    }
                }
            }
        } else if ($term->type == "2") {

            foreach ($student_mark as $item) {
                foreach ($exam as $item1) {
                    if ($item->student_id    == $item1->user_id) {

                        $object2 = json_decode($item->mark2, true);
                        if ($item1->result == null) {
                            $object1[$lesson_id]['quize'] = 0;
                        } else {
                            $object1[$lesson_id]['quize'] = $item1->result * 0.2;
                        }

                        $object_result2 = json_decode($item->result2, true);
                        $object_result2[$lesson_id]['term2_quizes'] = ceil($object2[$lesson_id]['oral']) +
                            ceil($object2[$lesson_id]['homework']) + ceil($object2[$lesson_id]['activities']) + ceil($object2[$lesson_id]['quize']);
                        $object_result2[$lesson_id]['term2_exam'] = ceil($object2[$lesson_id]['exam']);
                        $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);

                        $object_result1 = json_decode($item->result1, true);
                        $object_result = json_decode($item->result, true);

                        if ($item->result) {
                            $item = json_decode($item->result, true);


                            if (!json_decode($student_mark->result1, true)) {


                                $object_result1[$lesson_id]['term1_result'] = 0;
                            }




                            $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
                            $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
                        }

                        $object_worke_degree2 = json_decode($item->worke_degree, true);
                        $object_worke_degree2[$lesson_id]['term2_result'] = $object2[$lesson_id]['oral'] + $object2[$lesson_id]['activities'] + $object2[$lesson_id]['homework'] + $object2[$lesson_id]['quize'];

                        $item->update([
                            'room_id' => $room_id,
                            'lesson_id' => $lesson_id,
                            'mark2' => json_encode($object2),
                            'result2' => json_encode($object_result2),
                            'result' => json_encode($object_result),
                            'worke_degree' => json_encode($object_worke_degree2),
                            'status' => '1',
                        ]);
                        if ($item->estimation2) {
                            $stc = json_decode($item->estimation2, true);
                            if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 40) {

                                $stc[$lesson_id] = "ضعيف";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 70) {
                                $stc[$lesson_id] = "وسط";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 80) {
                                $stc[$lesson_id] = "جيد";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 90) {
                                $stc[$lesson_id] = "جيد حداًً";
                                $item->estimation2 = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 100) {

                                $stc[$lesson_id] = "ممتاز";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            }
                        } else {
                            $stc = new stdClass;
                            if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 40) {

                                $stc->{$lesson_id} = "ضعيف";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 70) {
                                $stc->{$lesson_id} = "وسط";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 80) {
                                $stc->{$lesson_id} = "جيد";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 90) {
                                $stc->{$lesson_id} = "جيد حداًً";
                                $item->estimation2 = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 100) {

                                $stc->{$lesson_id} = "ممتاز";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            }
                        }



                        $result_term2 = 0;
                        $count = 0;
                        foreach (json_decode($item->result2, true) as $key1 => $value1) {

                            $result_term2 = $result_term2 + $value1['term2_result'];
                            $count++;
                        }
                        $objec_term_result = json_decode($item->term_result, true);
                        $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2 / $count : "0";
                        $item->term_result = json_encode($objec_term_result);

                        $item->year_result = (json_decode($item->term_result, true)['term1']
                            + json_decode($item->term_result, true)['term2']) / 2;

                        $item->save();

                        if ($item->estimation) {
                            $stc = json_decode($item->estimation, true);
                            if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= "0" && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 40) {

                                $stc[$lesson_id] = "ضعيف";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 41 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 70) {
                                $stc[$lesson_id] = "وسط";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 71 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 80) {
                                $stc[$lesson_id] = "جيد";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 81 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 90) {
                                $stc[$lesson_id] = "جيد حداًً";
                                $item->estimation = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 91 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 100) {

                                $stc1[$lesson_id] = "ممتاز";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            }
                        } else {
                            $stc1 = new stdClass;
                            if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= "0" && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 40) {

                                $stc1->{$lesson_id} = "ضعيف";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 41 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 70) {
                                $stc1->{$lesson_id} = "وسط";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 71 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 80) {
                                $stc1->{$lesson_id} = "جيد";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 81 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 90) {
                                $stc1->{$lesson_id} = "جيد حداًً";
                                $item->estimation = json_encode($stc1);

                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 91 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 100) {

                                $stc1->{$lesson_id} = "ممتاز";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            }
                        }
                    }
                }
            }
        }



        session()->flash('success', 'تم تعديل  بنجاح');

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function export_exam1($exam_id, $room_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term_id = Exams2::find($exam_id)->term_id;
        $term = Term_year::where('id', $term_id)->where('year_id', $year->id)->first();
        $lesson =Lesson::find($lesson_id);
        $exam = Exam_result2::where('exam_id', $exam_id)->where('room_id', $room_id)->get();
        foreach ($exam as $item) {
            $student[] = $item->user_id;
        }



        $student_mark = Students_mark::whereIn('student_id', $student)->where('year_id', $year->id)->get();
        if ($term->type == "1") {

            foreach ($student_mark as $item) {
                foreach ($exam as $item1) {
                    if ($item->student_id    == $item1->user_id) {
                        $object1 = json_decode($item->mark, true);
                        if ($item1->result == null) {
                            $object1[$lesson_id]['exam'] = 0;
                        } else {
                            if ($item1->result > ($lesson->max_mark * 0.4)) {

                                session()->flash('success', 'تم تعديل  بنجاح');

                                return redirect()->back()->with('error', '! تمت العملية بنجاح');
                            } else {
                                $object1[$lesson_id]['exam'] = $item1->result;
                            }
                        }


                        $object_result1 = json_decode($item->result1, true);
                        $object_result1[$lesson_id]['term1_quizes'] = ceil($object1[$lesson_id]['oral']) +
                            ceil($object1[$lesson_id]['homework']) + ceil($object1[$lesson_id]['activities']) + ceil($object1[$lesson_id]['quize']);
                        $object_result1[$lesson_id]['term1_exam'] = ceil($object1[$lesson_id]['exam']);
                        $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);

                        $object_result2 = json_decode($item->result2, true);

                        $object_result = json_decode($item->result, true);
                        if ($item->result) {
                            $object_result = json_decode($item->result, true);

                            if (!json_decode($item->result2, true)) {


                                $object_result2[$lesson_id]['term2_result'] = 0;
                            }



                            $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);
                            $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
                        }

                        if ($item->worke_degree) {
                            $object_worke_degree = json_decode($item->worke_degree, true);
                            foreach (json_decode($item->worke_degree) as $key => $item2) {
                                $count = 0;
                                if ($key != $lesson_id) {
                                    $count = 1;
                                    break;
                                }
                            }
                            if ($count == 1) {

                                $object_worke_degree[$lesson_id]['term1_result'] = "null";
                                $object_worke_degree[$lesson_id]['term2_result'] = "null";
                            }



                            $object_worke_degree[$lesson_id]['term1_result'] = $object1[$lesson_id]['oral'] + $object1[$lesson_id]['activities'] + $object1[$lesson_id]['homework'] + $object1[$lesson_id]['quize'];
                            if ($object_worke_degree[$lesson_id]['term2_result'] != "null") {
                                $object_worke_degree[$lesson_id]['term2_result'] = $object_worke_degree[$lesson_id]['term2_result'];
                            } else {
                                $object_worke_degree[$lesson_id]['term2_result'] = "null";
                            }
                        } else {
                            $object_worke_degree[$lesson_id]['term1_result'] = $object1[$lesson_id]['oral'] + $object1[$lesson_id]['activities'] + $object1[$lesson_id]['homework'] + $object1[$lesson_id]['quize'];
                            $object_worke_degree[$lesson_id]['term2_result'] = "null";
                        }
                        $item->update([
                            'room_id' => $room_id,
                            'lesson_id' => $lesson_id,
                            'mark' => json_encode($object1),
                            'result1' => json_encode($object_result1),
                            'result' => json_encode($object_result),
                            'worke_degree' => json_encode($object_worke_degree),
                            'status' => '1',
                        ]);

                        if ($item->estimation1) {
                            $stc = json_decode($item->estimation1, true);
                            if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= "0" && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 40) {

                                $stc[$lesson_id] = "ضعيف";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 70) {
                                $stc[$lesson_id] = "وسط";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 80) {
                                $stc[$lesson_id] = "جيد";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 90) {
                                $stc[$lesson_id] = "جيد حداًً";
                                $item->estimation1 = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 100) {

                                $stc[$lesson_id] = "ممتاز";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            }
                        } else {
                            $stc = new stdClass;
                            if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= "0" && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 40) {

                                $stc->{$lesson_id} = "ضعيف";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 70) {
                                $stc->{$lesson_id} = "وسط";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 80) {
                                $stc->{$lesson_id} = "جيد";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 90) {
                                $stc->{$lesson_id} = "جيد حداًً";
                                $item->estimation1 = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 100) {

                                $stc->{$lesson_id} = "ممتاز";
                                $item->estimation1 = json_encode($stc);
                                $item->save();
                            }
                        }
                        $result_term1 = 0;
                        $count = 0;
                        foreach (json_decode($item->result1, true) as $key1 => $value1) {

                            $result_term1 = $result_term1 + $value1['term1_result'];
                            $count++;
                        }
                        $objec_term_result = json_decode($item->term_result, true);
                        $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 / $count : "0";

                        $item->term_result = json_encode($objec_term_result);
                        $item->year_result = (json_decode($item->term_result, true)['term1']
                            + json_decode($item->term_result, true)['term2']) / 2;
                        $item->save();

                        if ($item->estimation) {
                            $stc = json_decode($item->estimation, true);
                            if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= "0" && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 40) {

                                $stc[$lesson_id] = "ضعيف";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 41 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 70) {
                                $stc[$lesson_id] = "وسط";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 71 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 80) {
                                $stc[$lesson_id] = "جيد";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 81 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 90) {
                                $stc[$lesson_id] = "جيد حداًً";
                                $item->estimation = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 91 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 100) {

                                $stc1[$lesson_id] = "ممتاز";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            }
                        } else {
                            $stc1 = new stdClass;
                            if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= "0" && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 40) {

                                $stc1->{$lesson_id} = "ضعيف";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 41 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 70) {
                                $stc1->{$lesson_id} = "وسط";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 71 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 80) {
                                $stc1->{$lesson_id} = "جيد";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 81 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 90) {
                                $stc1->{$lesson_id} = "جيد حداًً";
                                $item->estimation = json_encode($stc1);

                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 91 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 100) {

                                $stc1->{$lesson_id} = "ممتاز";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            }
                        }
                    }
                }
            }
        } else if ($term->type == "2") {

            foreach ($item as $item) {
                foreach ($exam as $item1) {
                    if ($item->student_id    == $item1->user_id) {

                        $object2 = json_decode($item->mark2, true);
                        if ($item1->result == null) {
                            $object1[$lesson_id]['exam'] = 0;
                        } else {
                            $object1[$lesson_id]['exam'] = $item1->result * 0.4;
                        }

                        $object_result2 = json_decode($item->result2, true);
                        $object_result2[$lesson_id]['term2_quizes'] = ceil($object2[$lesson_id]['oral']) +
                            ceil($object2[$lesson_id]['homework']) + ceil($object2[$lesson_id]['activities']) + ceil($object2[$lesson_id]['quize']);
                        $object_result2[$lesson_id]['term2_exam'] = ceil($object2[$lesson_id]['exam']);
                        $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);

                        $object_result1 = json_decode($item->result1, true);
                        $object_result = json_decode($item->result, true);

                        if ($item->result) {
                            $object_result = json_decode($item->result, true);


                            if (!json_decode($item->result1, true)) {


                                $object_result1[$lesson_id]['term1_result'] = 0;
                            }




                            $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
                            $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
                        }

                        $object_worke_degree2 = json_decode($item->worke_degree, true);
                        $object_worke_degree2[$lesson_id]['term2_result'] = $object2[$lesson_id]['oral'] + $object2[$lesson_id]['activities'] + $object2[$lesson_id]['homework'] + $object2[$lesson_id]['quize'];

                        $item->update([
                            'room_id' => $room_id,
                            'lesson_id' => $lesson_id,
                            'mark2' => json_encode($object2),
                            'result2' => json_encode($object_result2),
                            'result' => json_encode($object_result),
                            'worke_degree' => json_encode($object_worke_degree2),
                            'status' => '1',
                        ]);
                        if ($item->estimation2) {
                            $stc = json_decode($item->estimation2, true);
                            if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 40) {

                                $stc[$lesson_id] = "ضعيف";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 70) {
                                $stc[$lesson_id] = "وسط";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 80) {
                                $stc[$lesson_id] = "جيد";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 90) {
                                $stc[$lesson_id] = "جيد حداًً";
                                $item->estimation2 = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 100) {

                                $stc[$lesson_id] = "ممتاز";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            }
                        } else {
                            $stc = new stdClass;
                            if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 40) {

                                $stc->{$lesson_id} = "ضعيف";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 70) {
                                $stc->{$lesson_id} = "وسط";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 80) {
                                $stc->{$lesson_id} = "جيد";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 90) {
                                $stc->{$lesson_id} = "جيد حداًً";
                                $item->estimation2 = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 100) {

                                $stc->{$lesson_id} = "ممتاز";
                                $item->estimation2 = json_encode($stc);
                                $item->save();
                            }
                        }


                        $result_term2 = 0;
                        $count = 0;
                        foreach (json_decode($item->result2, true) as $key1 => $value1) {

                            $result_term2 = $result_term2 + $value1['term2_result'];
                            $count++;
                        }
                        $objec_term_result = json_decode($item->term_result, true);
                        $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2 / $count : "0";
                        $item->term_result = json_encode($objec_term_result);

                        $item->year_result = (json_decode($item->term_result, true)['term1']
                            + json_decode($item->term_result, true)['term2']) / 2;

                        $item->save();


                        if ($item->estimation) {
                            $stc = json_decode($item->estimation, true);
                            if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= "0" && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 40) {

                                $stc[$lesson_id] = "ضعيف";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 41 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 70) {
                                $stc[$lesson_id] = "وسط";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 71 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 80) {
                                $stc[$lesson_id] = "جيد";
                                $item->estimation = json_encode($stc);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 81 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 90) {
                                $stc[$lesson_id] = "جيد حداًً";
                                $item->estimation = json_encode($stc);

                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 91 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 100) {

                                $stc1[$lesson_id] = "ممتاز";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            }
                        } else {
                            $stc1 = new stdClass;
                            if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= "0" && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 40) {

                                $stc1->{$lesson_id} = "ضعيف";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 41 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 70) {
                                $stc1->{$lesson_id} = "وسط";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 71 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 80) {
                                $stc1->{$lesson_id} = "جيد";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 81 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 90) {
                                $stc1->{$lesson_id} = "جيد حداًً";
                                $item->estimation = json_encode($stc1);

                                $item->save();
                            } else if (json_decode($item->result, true)[$lesson_id]['year_result'] / 2 >= 91 && json_decode($item->result, true)[$lesson_id]['year_result'] / 2 <= 100) {

                                $stc1->{$lesson_id} = "ممتاز";
                                $item->estimation = json_encode($stc1);
                                $item->save();
                            }
                        }
                    }
                }
            }
        }



        session()->flash('success', 'تم تعديل  بنجاح');

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
      public function teacher_quize_mark($room_id, $teacher_id, $lesson_id, $exam_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();


        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);
         $exam = Exam_result2::where('exam_id',$exam_id)->where('room_id',$room_id)->get();
         foreach($exam as $item){
            $student[]= $item->user_id;
         }

        $students = $room->with('student.exams_files')->with('student.exam_result2')->get();

        $exam1 = Exams2::find($exam_id);
    //   $quize_result = Room::with(['student.exam_result2' => function ($q) {
    //         $q->where('id', '<>', null)->orderBy('type');
    //     }])->where('id', $room_id)->get();

         $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();

        // $exam_title = Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)
        //     ->where('teacher_id', $teacher_id)->orderBy('type')->get();
      if($exam1->type=='2'&& $exam1->is_file == '0'){
          $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
          $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
          $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
           return view('teachers.teacher_quize_mark', compact('objection','students','message', 'exam1',  'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }
       if($exam1->type=='2'&& $exam1->is_file == '1'){
            $quize_result = Exam_result2::with('student' )->with('student.exams_files' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
           $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
           $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
           return view('teachers.teacher_quize_mark1', compact('objection','students','message', 'exam1', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }

    }


    public function StudentsRoomLesson_exammark($room_id, $teacher_id, $lesson_id, $exam_id)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);
        $room = Room::find($room_id);
        $students = $room->with('student.exams_files')->with('student.exam_result2')->get();
        $exam1 = Exams2::find($exam_id);
        $quize_result = Room::with(['student.exam_result2' => function ($q) {
            $q->where('id', '<>', null)->orderBy('type');
        }])->where('id', $room_id)->get();

        // $exam_title = Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)
        //     ->where('teacher_id', $teacher_id)->orderBy('type')->get();
        if($exam1->type=='1'&& $exam1->is_file == '1'){
            $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
            $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
            $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
            return view('teachers.teacher_exammark', compact('objection','students','message', 'exam1',  'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
        }
        if($exam1->type=='1' && $exam1->is_file == '0'){
            $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
            $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
            $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
            return view('teachers.teacher_exammark1', compact('objection','students','message', 'exam1', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
        }
    }
    

     public function StudentsRoomLesson_exammark1($room_id, $teacher_id, $lesson_id, $exam_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();


        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

        $students = $room->with('student.student_lesson_teacher_room_term_exam')->with('student.exam_result')->get();

        $exam1 = Lesson_teacher_room_term_exam::find($exam_id);
        $quize_result = Room::with(['student.exam_result' => function ($q) {
            $q->where('id', '<>', null)->orderBy('type');
        }])->where('id', $room_id)->get();

        $exam_title = Lesson_teacher_room_term_exam::where('room_id', $room_id)->where('lesson_id', $lesson_id)
            ->where('teacher_id', $teacher_id)->orderBy('type')->get();
 $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
 $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_exammark2', compact('objection','message','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
    }
    public function student_save_mark(Request $request)

    {

        $home = Lesson_teacher_room_term_exam::find($request->exam_id);

        $exam_result = Exam_result::find($request->exam_result_id);
        $room = Room::find($request->room_id);
        if ($exam_result) {

            $exam_result->result = $request->mark;
            $exam_result->status = '1';
            $exam_result->class_id = $room->classes->id;
            $exam_result->room_id = $request->room_id;
            $exam_result->exam_id = $request->exam_id;
            $exam_result->user_id = $request->user_id;
            $exam_result->lesson_id = $request->lesson_id;
            $exam_result->lecture_id = $home->lecture_id;
            $exam_result->type = $home->type;
            $exam_result->start_time = $home->start_time;
            $exam_result->end_time = $home->end_time;

            $exam_result->save();
        } else {
            $exam_result1 = new Exam_result();
            $exam_result1->class_id = $room->classes->id;
            $exam_result1->result = $request->mark;
            $exam_result1->status = '1';
            $exam_result1->class_id = $request->class_id;
            $exam_result1->room_id = $request->room_id;
            $exam_result1->exam_id = $request->exam_id;
            $exam_result1->user_id = $request->user_id;
            $exam_result1->lesson_id = $request->lesson_id;
            $exam_result1->lecture_id = $home->lecture_id;
            $exam_result1->type = $home->type;
            $exam_result1->start_time = $home->start_time;
            $exam_result1->end_time = $home->end_time;

            $exam_result1->save();
        }
        return  redirect()->back();
    }

   public function student_save_mark3(Request $request)

    {

        $home = Exams2::find($request->exam_id);

        $exam_result = Exam_result2::find($request->exam_result_id);
        $room = Room::find($request->room_id);
        if ($exam_result) {
   if($home->mark ==$request->mark){

            $exam_result->medal ="1";
        }
        elseif($home->mark-1 ==$request->mark    || $home->mark-2 ==$request->mark || $home->mark-3 ==$request->mark ){
            $exam_result->medal ="2";
        }
        elseif($home->mark-4 ==$request->mark    || $home->mark-5 ==$request->mark || $home->mark-6 ==$request->mark ){
             $exam_result->medal ="3";
        } else{
            $exam_result->medal =null;
        }
            $exam_result->result = $request->mark;
            $exam_result->status = '1';
            $exam_result->class_id = $room->classes->id;
            $exam_result->room_id = $request->room_id;
            $exam_result->exam_id = $request->exam_id;
            $exam_result->user_id = $request->user_id;

            $exam_result->type = $home->type;
            $exam_result->start_time = $home->start_date;
            $exam_result->end_time = $home->end_date;

            $exam_result->save();
        } else {

            $exam_result1 = new Exam_result2();
            $exam_result1->class_id = $room->classes->id;
            $exam_result1->result = $request->mark;
            $exam_result1->status = '1';
            $exam_result1->class_id = $request->class_id;
            $exam_result1->room_id = $request->room_id;
            $exam_result1->exam_id = $request->exam_id;
            $exam_result1->user_id = $request->user_id;

            $exam_result1->type = $home->type;
            $exam_result1->start_time = $home->start_date;
            $exam_result1->end_time = $home->end_date;
       if($home->mark ==$request->mark){

            $exam_result1->medal ="1";
        }
        elseif($home->mark-1 ==$request->mark    || $home->mark-2 ==$request->mark || $home->mark-3 ==$request->mark ){
            $exam_result1->medal ="2";
        }
        elseif($home->mark-4 ==$request->mark    || $home->mark-5 ==$request->mark || $home->mark-6 ==$request->mark ){
             $exam_result1->medal ="3";
        }
         else{
            $exam_result->medal =null;
        }
            $exam_result1->save();
        }
        return  redirect()->back();
    }

    public function student_save_mark2(Request $request)

    {
        $home = Exams2::find($request->exam_id);

        $exam_result = Exam_result2::find($request->exam_result_id);
        $room = Room::find($request->room_id);
        if ($exam_result) {

            $exam_result->result = $request->mark;
            $exam_result->status = '1';
            $exam_result->class_id = $room->classes->id;
            $exam_result->room_id = $request->room_id;
            $exam_result->exam_id = $request->exam_id;
            $exam_result->user_id = $request->user_id;
         if($home->mark ==$request->mark){

            $exam_result->medal ="1";
        }
        elseif($home->mark-1 ==$request->mark    || $home->mark-2 ==$request->mark || $home->mark-3 ==$request->mark ){
            $exam_result->medal ="2";
        }
        elseif($home->mark-4 ==$request->mark    || $home->mark-5 ==$request->mark || $home->mark-6 ==$request->mark ){
             $exam_result->medal ="3";
        }
        else{
            $exam_result->medal =null;
        }
            $exam_result->type = $home->type;
            $exam_result->start_time = $home->start_date;
            $exam_result->end_time = $home->end_date;


            $exam_result->save();

        } else {
            $exam_result1 = new Exam_result2();
            $exam_result1->class_id = $room->classes->id;
            $exam_result1->result = $request->mark;
            $exam_result1->status = '1';
            $exam_result1->class_id = $request->class_id;
            $exam_result1->room_id = $request->room_id;
            $exam_result1->exam_id = $request->exam_id;
            $exam_result1->user_id = $request->user_id;

            $exam_result1->type = $home->type;
            $exam_result1->start_time = $home->start_date;
            $exam_result1->end_time = $home->end_date;
   if($home->mark ==$request->mark){

            $exam_result1->medal ="1";
        }
        elseif($home->mark-1 ==$request->mark    || $home->mark-2 ==$request->mark || $home->mark-3 ==$request->mark ){
            $exam_result1->medal ="2";
        }
        elseif($home->mark-4 ==$request->mark    || $home->mark-5 ==$request->mark || $home->mark-6 ==$request->mark ){
             $exam_result1->medal ="3";
        }
         else{
            $exam_result->medal =null;
        }
            $exam_result1->save();

        }
        return  redirect()->back();
    }

    public function student_save_mark1(Request $request)

    {

        $home = Lesson_teacher_room_term_exam::find($request->exam_id);

        $exam_result = Exam_result::where('exam_id',$home->id)->where('user_id',$request->user_id)->first();
        $room = Room::find($request->room_id);
        if ($exam_result) {

            $exam_result->result = $request->mark;
            $exam_result->status = '1';
            $exam_result->class_id = $room->classes->id;
            $exam_result->room_id = $request->room_id;
            $exam_result->exam_id = $request->exam_id;
            $exam_result->user_id = $request->user_id;
            $exam_result->lesson_id = $request->lesson_id;
            $exam_result->lecture_id = $home->lecture_id;
            $exam_result->type = $home->type;
            $exam_result->start_time = $home->start_time;
            $exam_result->end_time = $home->end_time;

            $exam_result->save();
        } else {
            $exam_result1 = new Exam_result();
            $exam_result1->class_id = $room->classes->id;
            $exam_result1->result = $request->mark;
            $exam_result1->status = '1';
            $exam_result1->class_id = $request->class_id;
            $exam_result1->room_id = $request->room_id;
            $exam_result1->exam_id = $request->exam_id;
            $exam_result1->user_id = $request->user_id;
            $exam_result1->lesson_id = $request->lesson_id;
            $exam_result1->lecture_id = $home->lecture_id;
            $exam_result1->type = $home->type;
            $exam_result1->start_time = $home->start_time;
            $exam_result1->end_time = $home->end_time;

            $exam_result1->save();
        }
        return  redirect()->back();
    }


    public function classes_lessons($teacher_id)
    {


        $year = Year::where('current_year', '1')->first();

        $teacher = Teacher::with(['rooms' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find($teacher_id);

        $classes = [];


        // return $teacher ;
        foreach ($teacher->rooms as $item) {

            $classes[] = $item->classes;
        }
        $classes = array_unique($classes);

        $terms = Term_year::all();

        $lessons = Lesson::all();

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.classes_lessons', compact('classes', 'teacher', 'terms', 'lessons', 'count', 'count2'));
    }
    public function teacher_addexamorquize($class_id, $teacher_id)
    {


        $year = Year::where('current_year', '1')->first();
        $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $classes = Classe::with(['room' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find($class_id);
        $rooms = $classes->room;
        $rooms1 = [];
        foreach ($rooms as $room) {

            $a = Teacher_room_lesson::where('teacher_id', $teacher_id)->where('room_id', $room->id)->first();
            if ($a != null) {
                $rooms1[] = $a;
            }
        }

        $rooms1 = array_unique($rooms1);

        $rooms2 = [];
        foreach ($rooms1 as $room1) {

            $rooms2[] = Room::find($room1->room_id);
        }


        $rooms2 = array_unique($rooms2);



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


        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        // $lecture_id = Lecture::find($lecture_id);
 $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
  $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_addexamorquize', compact('objection','rooms2','message', 'room_id', 'class_id', 'terms', 'teacher', 'lessons', 'count', 'count2'));
    }







    public function teacher_rooms2($class_id, $teacher_id, $room_id, $lecture_id)
    {


        $year = Year::where('current_year', '1')->first();
         $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $classes = Classe::with(['room' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find($class_id);
        $rooms = $classes->room;
        $rooms1 = [];
        foreach ($rooms as $room) {

            $a = Teacher_room_lesson::where('teacher_id', $teacher_id)->where('room_id', $room->id)->first();
            if ($a != null) {
                $rooms1[] = $a;
            }
        }

        $rooms1 = array_unique($rooms1);

        $rooms2 = [];
        foreach ($rooms1 as $room1) {

            $rooms2[] = Room::find($room1->room_id);
        }


        $rooms2 = array_unique($rooms2);



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


        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        $lecture_id = Lecture::find($lecture_id);
$room1=room::find($room_id);
 $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
 $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_addcontent', compact('objection','rooms2','message', 'lecture_id', 'room_id', 'room1','class_id', 'terms', 'teacher', 'lessons', 'count', 'count2'));
    }

    public function store_items(Request $request)
    {


        $item = new Lesson_teacher_room_term_exam;
        $item->namehomework = $request->namehomework;
        $item->lesson_id = $request->lesson_id;
        $item->teacher_id = $request->teacher_id;
        $item->room_id = $request->room_id;
        $item->term_id = $request->term_id;
        $item->type = $request->type;
        if ($request->name_video == null && $request->name_audio == null &&  $request->namehomework == null &&  $request->name_quize == null  &&  $request->name_quize1 == null && $request->test == null && $request->name_addition == null &&  $request->name_exam == null) {

            return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
        if ($request->video == null && $request->video_in == null && $request->quize_link1 == null && $request->quize1 == null && $request->audio_file == null && $request->voice == null && $request->audio_link == null && $request->test == null && $request->quize == null && $request->exam == null && $request->test_link == null && $request->quize_link == null && $request->exam_link == null && $request->addition == null  &&  $request->addition_link == null) {

            return redirect()->back()->with('message', 'المحتوى فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
        if($item->type==1){
             $item->namehomework = $request->namehomework;
        $item->lesson_id = $request->lesson_id;
        $item->teacher_id = $request->teacher_id;
        $item->room_id = $request->room_id;
        $item->term_id = $request->term_id;
        $item->type = $request->type;
            if ( $request->test == null && $request->test_link == null ) {

            return redirect()->back()->with('message', 'المحتوى فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
                  if ($request->test_link != null) {
            $item->test_link = $request->test_link;
            $item->start_time = $request->test_start_time;
            $item->end_time = $request->test_end_time;
            $item->type_file =  '1';
            if ($request->namehomework == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->namehomework = $request->namehomework;
        }

        if ($request->test && $request->hasFile('test')) {

            $item->test = $request->test->store('filesteachers', 'public');
            $item->start_time = $request->test_start_time;
            $item->end_time = $request->test_end_time;
            if ($request->namehomework == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->namehomework = $request->namehomework;

            $item->extension =  $request->test->extension();
        }
            $item->lecture_id = $request->lecture_id;

        $item->save();
 session()->flash('Add', 'تم تعديل  بنجاح');
        return redirect()->back()->with('Add', '! تمت العملية بنجاح ');

        }
        else if($item->type==0){
             $item->lecture_id = $request->lecture_id;
             $item->namehomework = $request->namehomework;
        $item->lesson_id = $request->lesson_id;
        $item->teacher_id = $request->teacher_id;
        $item->room_id = $request->room_id;
        $item->term_id = $request->term_id;
        $item->type = $request->type;
             if ($request->video == null && $request->video_in == null ) {

            return redirect()->back()->with('message', 'المحتوى فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
        if ($request->video_in && $request->hasFile('video_in')) {
            $item->video = $request->video_in->store('filesteachers', 'public');
            $item->type_video = '0';

                if ($request->name_video == null){
                    return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
                }

            $item->name_video = $request->name_video;
            $item->extension =  $request->video_in->extension();
        }


        if ($request->video != null) {
            $item->video_link = $request->video;
            if ($request->name_video == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->name_video = $request->name_video;

            $item->type_video = '1';
        }

           $item->save();

 session()->flash('Add', 'تم تعديل  بنجاح');

        return redirect()->back()->with('Add', '! تمت العملية بنجاح ');

        }
         else if($item->type==6){
              $item->lecture_id = $request->lecture_id;
              $item->namehomework = $request->namehomework;
        $item->lesson_id = $request->lesson_id;
        $item->teacher_id = $request->teacher_id;
        $item->room_id = $request->room_id;
        $item->term_id = $request->term_id;
        $item->type = $request->type;
                if ( $request->audio_file == null &&  $request->audio_link == null ) {

            return redirect()->back()->with('message', 'المحتوى فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
        if ($request->audio_file && $request->hasFile('audio_file')) {
            $item->audio_file = $request->audio_file->store('filesteachers', 'public');
            $item->type_voice = '0';
            if ($request->name_audio == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->name_audio = $request->name_audio;

            $item->extension =  $request->audio_file->extension();
        }


        if ($request->audio_link  != null) {
            $item->audio_link = $request->audio_link;
            if ($request->name_audio == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->name_audio = $request->name_audio;

            $item->type_voice = '1';
        }
            $item->save();

 session()->flash('Add', 'تم تعديل  بنجاح');


        return redirect()->back()->with('Add', '! تمت العملية بنجاح ');

         }

        else if($item->type==4){
             $item->lecture_id = $request->lecture_id;
           $item->namehomework = $request->namehomework;
        $item->lesson_id = $request->lesson_id;
        $item->teacher_id = $request->teacher_id;
        $item->room_id = $request->room_id;
        $item->term_id = $request->term_id;
        $item->type = $request->type;
              if (  $request->addition == null  &&  $request->addition_link == null) {

            return redirect()->back()->with('message', 'المحتوى فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
           if ($request->addition && $request->hasFile('addition')) {
            $item->addition =  $request->addition->store('filesteachers', 'public');
            if ($request->name_addition == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->name_addition = $request->name_addition;

            $item->extension =  $request->addition->extension();
            $item->save();
        }
        if ($request->addition_link != null) {

            $item->addition_link = $request->addition_link;

            if ($request->name_addition == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->name_addition = $request->name_addition;
            $item->save();
        }
              $item->save();
session()->flash('Add', 'تم تعديل  بنجاح');


        return redirect()->back()->with('Add', '! تمت العملية بنجاح ');


        }


        // if ($request->quize_link != null)  {


        //     $item->quiz_link = $request->quize_link;
        //     $item->start_time = $request->quize_start_time;
        //     $item->end_time = $request->quize_end_time;
        //     $item->type_file =  '1';
        //     if ($request->name_quize == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_quize = $request->name_quize;
        // } elseif ($request->quize && $request->hasFile('quize')) {


        //     $item->quize = $request->quize->store('filesteachers', 'public');
        //     $item->start_time = $request->quize_start_time;
        //     $item->end_time = $request->quize_end_time;
        //     if ($request->name_quize == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_quize = $request->name_quize;
        //     $item->extension =  $request->quize->extension();
        // }
        // if ($request->quize_link1 != null) {


        //     $item->quiz_link1 = $request->quize_link1;
        //     $item->start_time = $request->quize1_start_time;
        //     $item->end_time = $request->quize1_end_time;
        //     $item->type_file =  '1';
        //     if ($request->name_quize1 == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_quize1 = $request->name_quize1;
        // }
        // elseif ($request->quize1 && $request->hasFile('quize1')) {


        //     $item->quize1 = $request->quize1->store('filesteachers', 'public');
        //     $item->start_time = $request->quize1_start_time;
        //     $item->end_time = $request->quize1_end_time;
        //     if ($request->name_quize1 == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_quize1 = $request->name_quize1;
        //     $item->extension =  $request->quize1->extension();
        // }

        // if ($request->exam_link != null) {

        //     $item->type_file =  '1';

        //     $item->exam_link =  $request->exam_link;
        //     $item->start_time = $request->exam_start_time;
        //     $item->end_time = $request->exam_end_time;
        //     if ($request->name_exam == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_exam = $request->name_exam;

        // } elseif ($request->exam && $request->hasFile('exam')) {
        //     $item->exam =  $request->exam->store('filesteachers', 'public');
        //     $item->start_time = $request->exam_start_time;
        //     $item->end_time = $request->exam_end_time;
        //     if ($request->name_exam == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_exam = $request->name_exam;
        //     $item->extension =  $request->exam->extension();
        // }





       }

    public function lessons($room_id, $teacher_id)
    {
        $teacher = Teacher::find($teacher_id);
        $lessons = $teacher->lessons;
        $room_lessons = [];
        $teacher_room_lessons = Teacher_room_lesson::where('room_id', $room_id)->where('teacher_id', $teacher_id)->get();
        $teacher_lessons = [];
        foreach ($teacher_room_lessons as $teacher_room_lesson) {

            $teacher_lessons[] = Lesson::find($teacher_room_lesson->lesson_id);
        }

        return  $teacher_lessons = array_unique($teacher_lessons);
    }

    public function teacher_lessons2($room_id, $teacher_id)
    {
        $teacher_name = Auth::user()->name;


        $teacher = Teacher::find($teacher_id);
         $lessons = $teacher->lessons;
        $room_lessons = [];
        $teacher_room_lessons = Teacher_room_lesson::where('room_id', $room_id)->where('teacher_id', $teacher_id)->get();
        $teacher_lessons = [];
        foreach ($teacher_room_lessons as $teacher_room_lesson) {

            $teacher_lessons[] = Lesson::find($teacher_room_lesson->lesson_id);
        }

        $teacher_lessons = array_unique($teacher_lessons);

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();
        $room = Room::find($room_id);
        $room_name = Room::find($room_id)->name;
        $class =Classe::where('id',$room->class_id );

        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
   $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
   $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_subject', compact('objection','teacher_lessons', 'teacher_name', 'room_name','message', 'teacher', 'room_id', 'count', 'count2','class'));
    }

     public function lectures($lesson_id, $teacher_id, $room_id)
    {
        $year = Year::where('current_year', '1')->first();
         $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $teacher = Teacher::find($teacher_id);


        $lesson = Lesson::find($lesson_id);

        $lectures = Lecture::with('teacher')->where('active', 0)->where('term_id', $terms->id)->where('lesson_id', $lesson->id)->where('room_id', $room_id)->get();

        $class = Room::find($room_id)->classes;
        $room = Room::find($room_id);
 $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
    $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_lesson', compact(
            'teacher',
            'objection',
            'lectures',
            'lesson',
            'class',
            'room',
'message',
        ));
    }
    public function store_lecture(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
         $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $item = new Lecture;
        $item->teacher_id = $request->teacher_id;
        $item->class_id = $request->class_id;
        $item->room_id = $request->room_id;
        $item->lesson_id = $request->lesson_id;
        $item->year_id = $year->id;
         $item->term_id = $terms->id;

        $item->name = $request->name;
        // $item->start_time = $request->start_time;
        // $item->end_time = $request->end_time;
        // $item->start_date = $request->start_date;
        // $item->end_date = $request->end_date;
        $item->save();
        return  redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
     public function medal($room_id, $teacher_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam = Lesson_teacher_room_term_exam::where('term_id', $term->id)->where('teacher_id', $teacher_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '3')->orwhere('type', '5')->get();

        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

          $student = $room->student;

          $class=Classe::find($room->class_id);
          $lesson=Lesson::find( $lesson_id);
        $medal=Medal::where('teacher_id',$teacher->id)->where('lesson_id',$lesson_id)->where('room_id',$room_id)->where('term',$term->id)->where('class_id',$class->id)->get();
         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
      $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();

        return view('teachers.teacher_medal', compact('objection','message','medal','room_id' ,'student', 'teacher','room','lesson','class','lesson_id'));
    }
     public function certificate($room_id, $teacher_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam = Lesson_teacher_room_term_exam::where('term_id', $term->id)->where('teacher_id', $teacher_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '3')->orwhere('type', '5')->get();

        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

          $student = $room->student;

          $class=Classe::find($room->class_id);
          $lesson=Lesson::find( $lesson_id);
        $medal=Certificate::where('teacher_id',$teacher->id)->where('lesson_id',$lesson_id)->where('room_id',$room_id)->where('term',$term->id)->where('class_id',$class->id)->get();
         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();

 $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_certificate', compact('objection','message','medal','room_id' ,'student', 'teacher','room','lesson','class','lesson_id'));
    }

    public function medal_store(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $medal = new Medal();

        $medal->teacher_id=auth()->user()->teacher_id;

        $medal->student_id=$request->student_id;
        $medal->term=$term->id;
        $medal->room_id=$request->room_id;
        $medal->lesson_id=$request->lesson_id;
        $medal->class_id=$request->class_id;
        $medal->medal=$request->medal;


        $medal->save();
        session()->flash('Add', 'تم تعديل  بنجاح');
            return redirect()->back()->with('Add', '! تمت العملية بنجاح');

    }
    public function certificate_store(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $medal = new Certificate();

        $medal->teacher_id=auth()->user()->teacher_id;

        $medal->student_id=$request->student_id;
        $medal->term=$term->id;
        $medal->room_id=$request->room_id;
        $medal->lesson_id=$request->lesson_id;
        $medal->class_id=$request->class_id;



        $medal->save();
        session()->flash('Add', 'تم تعديل  بنجاح');
            return redirect()->back()->with('Add', '! تمت العملية بنجاح');

    }
    public function medal_delete(Request $request)
    {

    $id = $request->exam_id;
    Medal::find($id)->delete();
    session()->flash('error', 'تم الحذف  بنجاح');
    return redirect()->back()->with('error', '! تمت العملية بنجاح');

    }
      public function certificate_delete(Request $request)
    {

    $id = $request->exam_id;
    Certificate::find($id)->delete();
    session()->flash('error', 'تم الحذف  بنجاح');
    return redirect()->back()->with('error', '! تمت العملية بنجاح');

    }
    public function book_details($lesson_id, $teacher_id, $room_id, $lecture_id)
    {
 $year = Year::where('current_year', '1')->first();
         $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
 $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $teacher = Teacher::find($teacher_id);


        $book_details = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('term_id', $terms->id)
            ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')->get();

        $lesson = Lesson::find($lesson_id);
        $videos = $book_details->where('type', '0');
        $voices = $book_details->where('type', '6');

        $tests = $book_details->where('type', '1');
        $quizes =  Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
        ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')->where('type', '2')->orWhere('type', '5')->get();
        $exams =  Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
        ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')->where('type', '3')->orWhere('type', '5')->get();
       ;
       $quizes1  =  Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
       ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')->where('type', '8')->get();
        $additions = $book_details->where('type', '4');

        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $class = Room::find($room_id)->classes;
         $class_id = Room::find($room_id)->class_id;
        $room = Room::find($room_id);

        $lecture = Lecture::find($lecture_id);
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_show', compact(
            'teacher',
            'now',
            'objection',
            'message',
            'quizes1',
            'room_id',
            'lesson',
            'book_details',
            'videos',
            'voices',
            'lecture',
            'tests',
            'quizes',
            'exams',
            'additions',
            'class',
            'class_id',
            'room'

        ));
    }


    public function file_answers($file_id, $lesson_id, $teacher_id, $room_id)
    {
        $answers = Student_lesson_teacher_room_term_exam::where('file_id', $file_id)->where('room_id', $room_id)->where('teacher_id', $teacher_id)->where('lesson_id', $lesson_id)->get();
        $room = Room::find($room_id);
        $students = $room->student;
        $file = Lesson_teacher_room_term_exam::find($file_id);

        $teacher = Teacher::find($teacher_id);

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.answers', compact('answers', 'file', 'teacher', 'students', 'count', 'count2'));
    }


    public function room_lessons(Request $request)
    {

        if ($request->room_id != '0') {


            $items = Teacher_room_lesson::where('room_id', $request->room_id)
                ->where('teacher_id', $request->teacher_id)->get();
            $lessons = [];
            foreach ($items as $item) {

                $lessons[] = Lesson::where('id', $item->lesson_id)->first();
            }
            $lessons = array_unique($lessons);
        } else {

            $rooms = Room::where('class_id', $request->class_id)->get();
            $items = [];
            foreach ($rooms as $room) {

                $items[] = Teacher_room_lesson::where('room_id', $room->id)
                    ->where('teacher_id', $request->teacher_id)->get();
            }
            $lessons = [];

            foreach ($items as $item1) {

                foreach ($item1 as $item) {
                    $lessons[] = Lesson::where('id', $item->lesson_id)->first();
                }
            }

            $lessons = array_unique($lessons);
        }

        return  $lessons;
    }




    public function marks_status($room_id, $lesson_id)
    {


        $year = Year::where('current_year', '1')->first();
        $teacher = Teacher::find(auth()->user()->teacher_id);


        $rooms_all = $teacher->rooms;

        // use collect function to unique array

        $collection = collect($rooms_all);
        $rooms = $collection->each(function ($obj, $key) {
        })->unique('id');

        $students = [];
        foreach ($rooms as $room) {

            $students[] = $room->student;
        }
        $students = array_unique($students);


        $student = $students[0]->first();

        $mark_status = Teacher_room_lesson::where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('year_id', $year->id)->where('teacher_id', $teacher->id)->first();

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.marks_status', compact('teacher', 'student', 'mark_status', 'room_id', 'lesson_id', 'count', 'count2'));
    }



    public function students($teacher_id)
    {

        $teacher = Teacher::find($teacher_id);
        $year = Year::where('current_year', '1')->first();

        $rooms = Teacher::with(['rooms.student' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($teacher_id);

        $classes = [];
        foreach ($rooms->rooms as $item) {

            $classes[] = $item->classes;
        }
        $classes = collect($classes);
        $classes = $classes->unique();
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();

        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
 $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
   $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_students', compact('objection','message','classes', 'teacher', 'count', 'count2'));
    }

    public function class_rooms($class_id, $teacher_id)
    {

        $year = Year::where('current_year', '1')->first();
        $rooms1 = Teacher_room_lesson::where('teacher_id', $teacher_id)->where('class_id', $class_id)->where('year_id', $year->id)->get();
        $rooms1 = $rooms1->unique('room_id');

        $rooms = [];

        foreach ($rooms1 as $room) {

            $rooms[] = Room::find($room->room_id);
        }

        return $rooms;
    }

    public function room_students($room_id)
    {

        $room = Room::find($room_id);
        $students = $room->student;

        return $students;
    }

    public function write_message($student_id)
    {

        $student = Student::find($student_id);
        $teacher_id = auth()->user()->teacher_id;

        $teacher = Teacher::find($teacher_id);
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.write_message', compact('objection','student', 'teacher', 'count', 'count2'));
    }

    public function send_message(Request $request)
    {
         $year = Year::where('current_year', '1')->first();
        $message = new Message;
        $message->year_id = $year->id;
        $message->student_id = $request->student_id;
        $message->message = $request->message;
        $message->teacher_id = $request->teacher_id;
        $message->save();
        return redirect()->back();
    }

    public function write_group_message($room_id)
    {

        $teacher_id = auth()->user()->teacher_id;
        $room = Room::find($room_id);
        $teacher = Teacher::find($teacher_id);

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
       $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.write_group_message', compact('objection','room', 'teacher', 'count', 'count2'));
    }

    public function send_group_message(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
        $room = Room::find($request->room_id);
        $students = $room->student;
        foreach ($students as $item) {

            $message = new Message;
            $message->year_id = $year->id;
            $message->student_id = $item->id;
            $message->message = $request->message;
            $message->teacher_id = $request->teacher_id;

            $message->save();
        }

        return redirect()->back();
    }



    public function events()
    {

        $events = Teacher_event::where('teacher_id', auth()->user()->teacher_id)->get();
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();

        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.events', compact('events', 'teacher', 'count', 'count2'));
    }

    public function add_event()
    {

        $teacher = Teacher::find(auth()->user()->teacher_id);
        $classes = $teacher->classes->unique();
        $teacher = Teacher::find(auth()->user()->teacher_id);

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.add_event', compact('classes', 'teacher', 'count', 'count2'));
    }

     public function event_store(Request $request)
    {


        $year = Year::where('current_year', '1')->first();

        $request->validate([
            'class_id' => 'required|numeric',
            'room_id'  =>  'required|numeric',
            'title'    =>   'required|max:30',

            'date'     =>    'required',
        ]);


        $teacher_event = new Teacher_event;

        $teacher_event->class_id = $request->class_id;
        $teacher_event->room_id = $request->room_id;
        $teacher_event->year_id = $year->id;
        $teacher_event->teacher_id = auth()->user()->teacher_id;
        $teacher_event->title = $request->title;
        $teacher_event->content = $request->content;
        $teacher_event->date = $request->date;

        $teacher_event->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }


    public function delete_event(Request $request)
    {

        $answer = Teacher_event::find($request->id);


        $answer->delete();

        return response()->json([
            'status' => true,
            'msg' => 'تم الحذف بنجاح ',

        ]);
        // return redirect()->back()->with('success','تم حذف الملف بنجاح !');



    }





    public function addition_delete(Request $request){


         $file_id=$request->id;



        $file=Lesson_teacher_room_term_exam::find($file_id);
                 Exam_result::where('exam_id',$file->id)->delete();

        if($file->type=='0'){
            Storage::disk('public')->delete($file->video);
    $file->delete();
        }elseif($file->type=='1'){

            Storage::disk('public')->delete($file->test);
            $file->delete();

        }
        elseif($file->type=='2'){
            Storage::disk('public')->delete($file->quize);
            $file->delete();


        }elseif($file->type=='3'){
            Storage::disk('public')->delete($file->exam);
            $file->delete();


        }elseif($file->type=='4'){

            Storage::disk('public')->delete($file->addition);
            $file->delete();

        }
         $answers=Student_lesson_teacher_room_term_exam::where('file_id',$file->id)->get();
        foreach($answers as $item){

            Storage::disk('public')->delete($item->file);
            $item->delete();
        }
        $file->delete();
        return redirect()->back()->with('success','! تمت العملية بنجاح ');

    }


    public function file_edit($file_id)
    {
        $year = Year::where('current_year', '1')->first();


        $lessons = Teacher::find(auth()->user()->teacher_id);
        $file = Lesson_teacher_room_term_exam::find($file_id);


        $classes = Teacher::find(auth()->user()->teacher_id)->classes->unique();

        $class_old = Room::find($file->room_id)->classes;
        // $rooms=Room::where('class_id',$class_old->id)->where('rooms.year_id',$year->id)->get();
        $rooms = $lessons->rooms()->where('teacher_room_lesson.class_id', $class_old->id)->where('teacher_room_lesson.year_id', $year->id)->get()->unique();
        $room_old = Room::find($file->room_id);
        // $lessons=Lesson::where('class_id',$class_old->id)->get();
        $lessons = $lessons->lessons()->where('teacher_room_lesson.class_id', $class_old->id)->where('teacher_room_lesson.year_id', $year->id)->get()->unique();
        $lesson_old = Lesson::find($file->lesson_id);
        $teacher = Teacher::find(auth()->user()->teacher_id);

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.file_edit', compact('file', 'classes', 'lessons', 'teacher', 'lesson_old', 'rooms', 'class_old', 'room_old', 'count', 'count2'));
    }

    public function edit_home($file_id)
    {
        $year = Year::where('current_year', '1')->first();

        $teacher = Teacher::find(auth()->user()->teacher_id);

        $lessons = Teacher::find(auth()->user()->teacher_id);
        $file = Lesson_teacher_room_term_exam::find($file_id);
          $lecture=Lecture::find($file->lecture_id);
        $room=Room::find($file->room_id);
         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
         $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_edithomework', compact('objection','message','file','teacher','lecture','room'));

    }

    public function edit_quize($file_id)
    {
        $year = Year::where('current_year', '1')->first();

        $teacher = Teacher::find(auth()->user()->teacher_id);

        $lessons = Teacher::find(auth()->user()->teacher_id);
        $file = Lesson_teacher_room_term_exam::find($file_id);
          $lecture=Lecture::find($file->lecture_id);
        $room=Room::find($file->room_id);
         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
         $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_editquize', compact('objection','message','file','teacher','lecture','room'));

    }
    public function edit_audio($file_id)
    {
        $year = Year::where('current_year', '1')->first();

        $teacher = Teacher::find(auth()->user()->teacher_id);

        $lessons = Teacher::find(auth()->user()->teacher_id);
        $file = Lesson_teacher_room_term_exam::find($file_id);
           $lecture=Lecture::find($file->lecture_id);
        $room=Room::find($file->room_id);
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_editaudio', compact('objection','message','file','teacher','lecture','room'));

    }
    public function edit_video($file_id)
    {
        $year = Year::where('current_year', '1')->first();

        $teacher = Teacher::find(auth()->user()->teacher_id);

        $lessons = Teacher::find(auth()->user()->teacher_id);
        $file = Lesson_teacher_room_term_exam::find($file_id);
        $lecture=Lecture::find($file->lecture_id);
        $room=Room::find($file->room_id);

        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
         $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.teacher_editvideo', compact('objection','message','file','teacher','lecture','room'));

    }
    public function edit_exam1($file_id)
    {
        $year = Year::where('current_year', '1')->first();

        $teacher = Teacher::find(auth()->user()->teacher_id);

        $lessons = Teacher::find(auth()->user()->teacher_id);
        $file = Lesson_teacher_room_term_exam::find($file_id);

        return view('teachers.teacher_editexam', compact('file','teacher'));

    }
    public function video_update($file_id, Request $request)
    {


        $item = Lesson_teacher_room_term_exam::find($file_id);
        if ($request->video == null &&  $request->video_link == null ){
            return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        }




            if ($request->video && $request->hasFile('video')) {
                $item->video = $request->video->store('filesteachers', 'public');
                $item->type_video = '0';

                    if ($request->name_video == null){
                        return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
                    }

                $item->name_video = $request->name_video;

            }


            if ($request->video_link != null) {
                $item->video_link = $request->video_link;
                if ($request->name_video == null){
                    return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
                }
                $item->name_video = $request->name_video;

                $item->type_video = '1';
            }



        $item->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }

    public function quize_update($file_id, Request $request)
    {


        $item = Lesson_teacher_room_term_exam::find($file_id);
        if ($request->quize == null &&  $request->quize_link == null ){
            return redirect()->back()->with('message', 'المحتوى   فارغ يرجى اعادة تعبئة البيانات من جديد');
        }


        if ($request->quize_link != null) {


            $item->quiz_link = $request->quiz_link;
            $item->start_time = $request->start_time;
            $item->end_time = $request->end_time;
            $item->type_file =  '1';
            if ($request->name_quize == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->name_quize = $request->name_quize;

        } elseif ($request->quize && $request->hasFile('quize')) {


            $item->quize = $request->quize->store('filesteachers', 'public');
            $item->start_time = $request->start_time;
            $item->end_time = $request->end_time;
            if ($request->name_quize == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
             $item->type_file =  '0';
             $item->name_quize = $request->name_quize;
            $item->extension =  $request->quize->extension();
        }



        $item->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
     public function exam_update123(Request $request){
        if(!$request->room_id ){

            session()->flash('error', 'تم تعديل  بنجاح');
            return redirect()->back()->with('error', '! تمت العملية بنجاح');
        }
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        foreach($request->room_id as $item){
              $exam = Exams2::find($item);




           if ($request->quize && $request->hasFile('quize')) {


                $exam->file = $request->quize->store('filesteachers', 'public');

                // $exam->extension =  $request->quize->extension();
            }
              $exam->save();
        }



            session()->flash('Add', 'تم تعديل  بنجاح');
            return redirect()->back()->with('Add', '! تمت العملية بنجاح');


    }
    public function audio_update($file_id, Request $request)
    {


        $item = Lesson_teacher_room_term_exam::find($file_id);
        if ($request->audio_file == null &&  $request->audio_link == null ){
            return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
            if ($request->audio_file && $request->hasFile('audio_file')) {
                $item->audio_file = $request->audio_file->store('filesteachers', 'public');
                $item->type_voice = '0';

                    if ($request->name_audio == null){
                        return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
                    }

                $item->name_audio = $request->name_audio;

            }
            if ($request->audio_link != null) {
                $item->audio_link = $request->audio_link;
                if ($request->name_audio == null){
                    return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
                }
                $item->name_audio = $request->name_audio;

                $item->type_voice = '1';
            }



        $item->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
    public function file_update($file_id, Request $request)
    {

        $item = Lesson_teacher_room_term_exam::find($file_id);
        if (($request->test == null && $item->test == null) &&  $request->test_link == null ){

            return redirect()->back()->with('message', 'المحتوى   فارغ يرجى اعادة تعبئة البيانات من جديد');
        }

        if ( $request->hasFile('test')) {

            $item->test = $request->test->store('filesteachers', 'public');
            $item->start_time = $request->test_start_time;
            $item->end_time = $request->test_end_time;
            if ($request->namehomework == null){
                return redirect()->back()->with('message', 'المحتوى   فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->namehomework = $request->namehomework;
            $item->extension =  $request->test->extension();

            $item->type = '1';
            $item->type_file = '0';
        }


        if ($request->test_link != null) {
            $item->test_link = $request->test_link;
            $item->start_time = $request->test_start_time;
            $item->end_time = $request->test_end_time;
            $item->type_file =  '1';
            $item->type = '1';
            if ($request->namehomework == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }

            $item->namehomework = $request->namehomework;
        }
        else{
            if ($request->test == null &&   $request->test_link == null ){
                 $item->test_link = $request->test_link;
                $item->test = $item->test ;
             if ($request->namehomework == null){
                return redirect()->back()->with('message', 'المحتوى   فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->namehomework = $request->namehomework;
              $item->start_time = $request->test_start_time;
            $item->end_time = $request->test_end_time;
        }
        }



        $item->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
    public function exam_update11($file_id, Request $request)
    {

        $item = Lesson_teacher_room_term_exam::find($file_id);
        if ($request->exam_link == null &&  $request->exam == null ){
            return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        }

        if ($request->exam_link != null) {

            $item->type_file =  '1';

            $item->exam_link =  $request->exam_link;
            $item->start_time = $request->exam_start_time;
            $item->end_time = $request->exam_end_time;
            if ($request->name_exam == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->name_exam = $request->name_exam;

        } elseif ($request->exam && $request->hasFile('exam')) {
            $item->exam =  $request->exam->store('filesteachers', 'public');
            $item->start_time = $request->exam_start_time;
            $item->end_time = $request->exam_end_time;
            if ($request->name_exam == null){
                return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
            }
            $item->name_exam = $request->name_exam;
            $item->extension =  $request->exam->extension();
        }



        $item->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }

    public function quest_exam($exam_id) {

        $exam = Lesson_teacher_room_term_exam::find($exam_id);
        $room=Room::find($exam->room_id);
         $class_id=Room::find($exam->room_id)->class_id;
         $class1=Classe::find($class_id)->name;
         $term= Term_year::find($exam->term_id)->term;
        $lesson = Lesson::find($exam->lesson_id);
        $selected_ques = $exam->selected_ques;

       $selected_ques = json_decode($selected_ques);
$selected_ques1=[];

           if($selected_ques != null){
       foreach ($selected_ques as $x) {

          $selected_ques1[] = Question::where('id', $x)->with('option')->orderBy('section_id')->get();
       };
       // dd($ques_id);


         $class=$exam->class;

      $year = Year::where('current_year', '1')->first()->name;
 $teacher = Teacher::find(auth()->user()->teacher_id);
       return view('teachers.teacher_examfile',compact('selected_ques1','selected_ques','teacher','exam','class','room','term','lesson','class1','year'));
   }
       session()->flash('noSelectedQuestions', ' لم يتم اختيار أي سؤال لهذا الامتحان !! ');
       return redirect()->back();
    }

 public function quest_exam1($exam_id,$class_id,$lesson_id) {

        $exam = Exams2::find($exam_id);

        $exam = Exams2::find($exam_id);

 $teacher = Teacher::find(auth()->user()->teacher_id);

        $room=Room::find($exam->room_id);
         $class_id=Room::find($exam->room_id)->class_id;
         $class1=Classe::find($class_id)->name;
         $term= Term_year::find($exam->term_id)->term;
        $lesson = Lesson::find($exam->lesson_id);
        $selected_ques = $exam->selected_ques;

       $selected_ques = json_decode($selected_ques);



      $selected_ques1=[];

           if($selected_ques != null){
       foreach ($selected_ques as $x) {

          $selected_ques1[] = Question::where('id', $x)->with('option')->orderBy('section_id')->get();
       };

         $class=$exam->class;

            $year = Year::where('current_year', '1')->first()->name;

       return view('teachers.teacher_examfile1',compact( 'selected_ques1','selected_ques','exam','teacher','class','room','term','lesson','class1','year'));
       }
       else{
             session()->flash('noSelectedQuestions', ' لم يتم اختيار أي سؤال لهذا الامتحان !! ');
       return redirect()->back();;
       }
}

    public function teacher_lessons3($class_id)
    {

        $year = Year::where('current_year', '1')->first();

        $lessons = Teacher::find(auth()->user()->teacher_id);
        $lessons = $lessons->lessons()->where('teacher_room_lesson.class_id', $class_id)->where('teacher_room_lesson.year_id', $year->id)->get()->unique();
        return $lessons;
    }

    public function rooms3($class_id)
    {
        $year = Year::where('current_year', '1')->first();

        $lessons = Teacher::find(auth()->user()->teacher_id);
        $rooms = $lessons->rooms()->where('teacher_room_lesson.class_id', $class_id)->where('teacher_room_lesson.year_id', $year->id)->get()->unique();

        return $rooms;
    }

    public function event_edit($event_id)
    {
        $year = Year::where('current_year', '1')->first();

        $event = Teacher_event::find($event_id);
        $class_old = Room::find($event->room_id)->classes;

        $lessons = Teacher::find(auth()->user()->teacher_id);
        $rooms = $lessons->rooms()->where('teacher_room_lesson.class_id', $class_old->id)->where('teacher_room_lesson.year_id', $year->id)->get()->unique();
        $teacher = Teacher::find(auth()->user()->teacher_id);

        $classes = $teacher->classes->unique();

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

        return view('teachers.event_edit', compact('event', 'rooms', 'classes', 'teacher', 'count', 'count2'));
    }

    public function event_update(Request $request)
    {
        $year = Year::where('current_year', '1')->first();

        $teacher_event = Teacher_event::find($request->event_id);
        $teacher_event->class_id = $teacher_event->class_id;
        $teacher_event->room_id = $teacher_event->room_id;
        $teacher_event->year_id = $year->id;
        $teacher_event->teacher_id = auth()->user()->teacher_id;
        $teacher_event->title = $request->title;
        $teacher_event->content = $request->content;
        $teacher_event->date = $request->date;

        $teacher_event->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }


    public function messages($teacher_id)
    {

        $teacher = Teacher::find($teacher_id);

        $year = Year::where('current_year', '1')->first();


        $messages = Messages_super::where('teacher_id', $teacher->id)->where('year_id', $year->id)->get();

        foreach ($messages as $item) {

            $m = Messages_super::find($item->id);
            $m->view = '1';
            $m->save();
        }
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();


        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();

$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers.messages', compact('objection','teacher', 'messages', 'count', 'count2'));
    }

    public function show_supervisor_items()
    {
        $teacher_id = Auth::user()->teacher_id;
        $teacher = Teacher::find($teacher_id);
        $year = Year::where('current_year', '1')->first();

        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();

        $supervisor_items = Supervisor_teacher_item::where('teacher_id', $teacher_id)->where('year_id', $year->id)->get();

        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();


        foreach ($supervisor_items as $item) {
            $m = Supervisor_teacher_item::find($item->id);
            $m->view = '1';
            $m->save();
        }

        return view('teachers.show_supervisor_items', compact('teacher', 'supervisor_items', 'count', 'count2'));
    }
    public function getDay($day)
{
    $week = [
        'Saturday' => 0,
        'Sunday' => 1,
        'Monday' => 2,
        'Tuesday' => 3,
        'Wednesday' => 4,
        'Thursday' => 5,
        'Friday' => 6,
    ] ;
    $day = $week[$day];
return  $day ;
}
}
