<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Day;
use App\Lesson;
use App\Lesson_teacher_room_term_exam;
use App\Room;
use App\Exams2;
use App\Exam_file;
use App\Message;
use App\Road;
use App\Means;
use App\Teacher_event;
use Carbon\Carbon;
use App\Messages_super;
use App\Supervisor_teacher_item;
use App\Lecture;
use App\Student;
use App\Evaluation;
use App\Student_lesson_teacher_room_term_exam;
use App\Students_mark;
use App\Teacher;
use App\Teacher_room_lesson;
use App\Term;
use App\Term_year;
use App\User;
use App\Question;
use App\Section;
use App\Year;
use App\Prepare;
use App\Option;
use App\Unit_analysis;
use App\Exam_result;
use App\Exam_result2;
use App\Exams;
use App\About_us;
use App\Lecture_time;
use App\Lesson_room_teacher_lecture_time;
use App\Room_student;
use App\Student_schedule_tracer;
use App\Planification_trimestrielle;
use stdClass;
use Illuminate\Http\Request;
use App\Coordinator;
use App\Coordinator_class_lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Console\Input\Input;
use DateTime;
use RealRashid\SweetAlert\Facades\Alert;
//electronic section
use App\Electronic_file;
use Illuminate\Support\Facades\DB;
use App\Electronic_section;
use App\Notification;
use App\Studentfcmtoken;
use App\Exam_question;

class coordinatorcontroller extends Controller
{


    public function chat()
    {
        // return $student_id ;
        $user_id = auth()->user()->id ;
        $teacher_id = auth()->user()->coordinator_id ;
       $teacher = Coordinator::find($teacher_id);
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

        return view('coordinators.chat',compact('teacher','now','teacher_id','days','today','minutes'));
    }

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
       public function profile()
    {
       $coordinator_id = Auth::user()->coordinator_id;
        $year = Year::where('current_year', '1')->first();
        $coordinator = Coordinator::find($coordinator_id);
        return  view('coordinators.index',compact('coordinator'));
    }

   public function update_profile_coor(Request $request, $coordinator_id)
    {


         $coordinator = Coordinator::find($coordinator_id);

        if ($request->image != null) {
            Storage::disk('public')->delete($coordinator->image);
            $coordinator->image = $request->image->store('filesteachers', 'public');
        }


        $coordinator->save();
        $user = User::where('coordinator_id',$coordinator_id)->first();
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

    public function dashboard_coordinator()
    {
    $coordinator_id = Auth::user()->coordinator_id;
  
    $year = Year::where('current_year', '1')->first();
    // $coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id,$year) {
    //     $query->where('coordinator_id', $coordinator_id)->distinct();
    //     $query ->where('year_id',$year->id);
    // }])->find($coordinator_id);
 $coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id, $year) {
        $query->where('coordinator_id', $coordinator_id)->distinct();
        $query->where('rooms.year_id', $year->id); 
    }])->find($coordinator_id);


    $classes = $coordinator->classes->unique();

    foreach ($classes as $class) {
        $class->room3 = $class->room2->unique();
        unset($class->room2);
    }

    return view('school_controller.index', compact('coordinator', 'classes'));
}

//اضافة سؤال

public function questions($class_id, $room_id, $lecture_id, $lesson_id)
{

    $year = Year::where('current_year', '1')->first();
    $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    $coordinator_id = Auth::user()->coordinator_id;
    $coordinator = Coordinator::find( $coordinator_id) ;
    $classes = Classe::all();
    $class = Room::find($room_id)->classes;
    //return $class;
    $lecture_id = Lecture::find($lecture_id);
    $room = Room::where('class_id', $class_id)->where('id', $room_id)->first();

    $questions = Question::where('class_id', $class->id)
    ->where('term_id', $term->id)
    ->where('lesson_id', $lesson_id)->where('coordinator_id',auth()->user()->coordinator_id)->get();
    $results = [];
     foreach ($questions as $question) {
     $options = Option::where('question_id', $question->id)->get();
     $results[$question->id] = $options;
      }
      //return $results;
    $sections = Section::where('class_id', $class_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->get();
    $lectures = Lecture::where('active', 0)->where('class_id', $class_id)->where('lesson_id',$lesson_id)->get();
    return view('school_controller.add_automated',
    compact('class','lectures',
    'lecture_id', 'lesson_id', 'room_id', 'classes', 'questions', 'sections', 'coordinator'));
}

  //صفحة اضافة سؤال
  public function add_questions($class_id, $room_id, $lecture_id, $lesson_id)
  {
    $coordinator = Coordinator::find(auth()->user()->coordinator_id);
      $class = Classe::find($class_id);
      $room = Room::where('class_id', $class_id)->where('id', $room_id)->first();
      $Lecture = Lecture::find($lecture_id);
      $classes = Classe::all();
      $year = Year::where('current_year', '1')->first();
      $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

      $questions = Question::where('class_id', $class_id)->where('accept', 0)
      ->where('lesson_id', $lesson_id)->where('term_id', $term->id)

      ->where('coordinator_id',auth()->user()->coordinator_id)->get();

      $sections = Section::where('class_id', $class_id)->where('term_id', $term->id)
      ->where('lesson_id', $lesson_id)->get();

      foreach($sections as $key => $item ){
      if(($item->type==3 ||  $item->type==2) && $item->content==null ){
      $sections->forget($key);
      }
  }
      $back=URL::previous();
      $coordinator = Teacher::find(auth()->user()->coordinator_id);

      return view('school_controller.add_question', compact('class','back', 'Lecture', 'room_id', 'classes', 'questions', 'sections', 'coordinator','lesson_id'));
  }

   //تخزين سؤال
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
             $question->accept = 1;
           $question->coordinator_id = auth()->user()->coordinator_id;
           $question->save();

           // dd($question);

       } //نهاية السشرط لحالة السؤال التقليدي

       // حالة السؤال متعدد الخيارات
       elseif ($request->ques_type == "1") {

           $options = new stdClass();
           $question =  new  question();
           $question->question_form = $request->question_form;
           $question->section_id = $request->section_id;
           $question->answer = json_encode($request->answer);
           $question->mark = $request->mark;
           $question->note = $request->note;
           $question->class_id = $request->class_id;
           $question->ques_type = $request->ques_type;
           $question->Lecture_id = $request->Lecture_id;
           $question->lesson_id = $request->lesson_id;
           $question->coordinator_id = auth()->user()->coordinator_id;
           $question->term_id = $term->id;
           $question->accept = 1;
           $question->save();

           $option =  Option::create([
               'question_id' => $question->id,
               'myOptions' =>  json_encode($request->option),
           ]);
       }
       session()->flash('Add', 'تم اضافة السؤال بنجاح ');
       return redirect($request->back)->with('success', '! تمت العملية بنجاح ');
   }

   public function question_edit($id,$room_id)
   {
       $coordinator = Coordinator::find(auth()->user()->coordinator_id);
       $questions = Question::where('id', $id)->first();

        $results = [];
       if ($questions) { // Check if $questions is not null
        $options = Option::where('question_id', $questions->id)->get();
        $results[$questions->id] = $options;
        }
      // Move the return statement inside the if statement

      //return $results;
       $class_id = $questions->class_id;
       $classes = Classe::all();
       $room_id = Room::where('class_id', $class_id)->where('id', $room_id)->first();
       $sections = Section::where('class_id', $class_id)->where('lesson_id', $questions->lesson_id)->get();
       $item = Question::where('id', $id)->first();
       $Lecture = Lecture::where('class_id', $item->class_id)->where('active',0)->get();

       return view('school_controller.update_question', compact('coordinator','questions', 'room_id','class_id', 'Lecture', 'id', 'sections', 'item'));
   }
    //تعديل سؤال
    public function question_update(Request $request, $question_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $question = question::find($question_id);

        if ($request->ques_type == 2) {
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
            $question->coordinator_id = auth()->user()->coordinator_id;
            $question->term_id = $term->id;
            $question->note = $request->note;
            $question->save();
            // $options = $users = DB::select('select * from options');
            // $options = option::where('qusetion_id',$id);
        } else {
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
            $question->coordinator_id = auth()->user()->coordinator_id;
            if($request->mark){
                $question->mark = $request->mark;
            }
            else{
                $question->mark = $question->mark;
            }
            $question->note = $request->note;
            $question->save();
            $option = option::where('question_id', $question->id)->first();

            $option->update([
                'question_id' => $question->id,
                'myOptions' => json_encode($request->option),
            ]);
        }
        session()->flash('update', 'تم تعديل السؤال بنجاح');
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
      //اضافة فقرة
    public function sections($class_id, $room_id, $lecture_id, $lesson_id)
    {
        $coordinator = Coordinator::find(auth()->user()->coordinator_id);
        $class = Classe::find($class_id);
        $classes = Classe::all();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $sections = Section::where('class_id', $class_id)
        ->where('lesson_id', $lesson_id)->where('coordinator_id',auth()->user()->coordinator_id)
        ->where('term_id', $term->id)->get();
        $rooms = $class->room;
        $Lecture = Lecture::find($lecture_id);
        $questions = Question::where('class_id', $class_id)
        ->where('term_id', $term->id)->where('lesson_id', $lesson_id)
        ->where('coordinator_id',auth()->user()->coordinator_id)->get();

        return view('school_controller.addsection', compact('class', 'lesson_id', 'room_id', 'Lecture', 'classes', 'sections', 'coordinator', 'rooms', 'questions'));
    }

    //التعديل على فقرة
    public function section_update(Request $request)
    { $request->validate([

        'title'=>'required',
    ]);
    if( $request->type!='0' &&  $request->type!='3' && $request->type!='2' ){
        session()->flash('error', 'تم اضافة السؤال بنجاح ');
        return redirect()->back()->with('error', '! تمت العملية بنجاح ');
    }
    $year = Year::where('current_year', '1')->first();
    $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    $section = Section::find($request->section_id);
    $section->coordinator_id = auth()->user()->coordinator_id ;
    $section->title = $request->title;
    $section->term_id = $term->id;
        if ($request->type != $section->type) {
            if ($request->type == '0') {
                $section->content = $request->content;
            } else {
                if ($request->hasFile('content')) {
                    $section->content = $request->content->store('sectionfiles', 'public');
                }
            }
        } else {
            Storage::disk('local')->delete($section->content);
            if ($request->hasFile('content')) {
                $section->content = $request->content->store('sectionfiles', 'public');
            } else {

                $section->content = $request->content;
            }
        }
        $section->type = $request->type;
        $section->save();
        session()->flash('update', 'تم تعديل السؤال بنجاح');
        return redirect()->back()->with('update', '! تمت العملية بنجاح');
    }

    //اضافة فقرة
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
        $item->coordinator_id = auth()->user()->coordinator_id ;
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
    
//صفحة الصفوف للكتب المدرسية
public function classes_book()
{
$coordinator_id = Auth::user()->coordinator_id;
$year = Year::where('current_year', '1')->first();
// $coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id,$year) {
//     $query->where('coordinator_id', $coordinator_id)->distinct();
//     $query ->where('year_id',$year->id);
// }])->find($coordinator_id);
$coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id, $year) {
    $query->where('coordinator_id', $coordinator_id)->distinct();
    $query->where('rooms.year_id', $year->id);
}])->find($coordinator_id);


$classes = $coordinator->classes->unique();

foreach ($classes as $class) {
    $class->room3 = $class->room2->unique();
    unset($class->room2);
}
return view('school_controller.classes_book', compact('coordinator', 'classes'));
}
 //book student
 public function books($id){
    $coordinator_name = Auth::user()->name;
    $coordinator_id = Auth::user()->coordinator_id;
    $coordinator = Coordinator::find( $coordinator_id) ;
    $year=Year::where('current_year','1')->first();
    //$student=Student::with('details')->find($student_id);
    // $item=Room_student::where('student_id',$student_id)->where('year_id',$year->id)->first();
    //         if ($item=="") {
    //     return redirect()->back();
    // }

    //  $room = Room::with('lessons3')->find($item->room_id);
     //$room=Room::with('classes')->where('id',$item->room_id)->first();
    //$room_id = $room->id ;
    // $lessons= $room->teachers;
    //     $lessons=Room::with(['lessons'=>function($q){
    //     $q->with('teachers');
    // }])->find($room->id);
    // $lessons = $lessons->lessons ;
    $classes = Classe::where('id',$id)->with('lessons')->first();
    return view('school_controller.books',compact('classes','coordinator_id','coordinator_name','coordinator',

    'year'));

}


//صفحة الصفوف والشعب لدفاتر العلامات
public function classes_mark_book()
{
$coordinator_id = Auth::user()->coordinator_id;
$year = Year::where('current_year', '1')->first();
// $coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id,$year) {
//     $query->where('coordinator_id', $coordinator_id)->distinct();
//     $query ->where('year_id',$year->id);
// }])->find($coordinator_id);
$coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id, $year) {
    $query->where('coordinator_id', $coordinator_id)->distinct();
    $query->where('rooms.year_id', $year->id);
}])->find($coordinator_id);


$classes = $coordinator->classes->unique();

foreach ($classes as $class) {
    $class->room3 = $class->room2->unique();
    unset($class->room2);
}
return view('school_controller.classes_mark_book', compact('coordinator', 'classes'));
}
//صفحة المواد لدفاتر العلامات
public function mark_book_subject($room_id){
    $coordinator_name = Auth::user()->name;
    $coordinator_id = Auth::user()->coordinator_id;
    $coordinator = Coordinator::find( $coordinator_id) ;
    $room_lessons = Room::with([
        'classes.lessons5' => function ($q2) use ($coordinator_id) {
            $q2->where('coordinator_id', $coordinator_id)->distinct();
        }
    ])->find($room_id);
    //return  $room_lessons;
    //return $room_lessons->classes->lessons5;
    $lessonsArray = $room_lessons->classes->lessons5;
    //return $lessonsArray;
    $room_lessons = [];
    $room = Room::find($room_id);
    $room_name = Room::find($room_id)->name;
    $class = Classe::where('id',$room->class_id );
    return view('school_controller.mark_book_subject',
    compact('lessonsArray', 'coordinator_name', 'room_name','coordinator', 'room_id','class'));
}
 //دفتر العلامات
 public function StudentsRoomLessontotal($room_id,$lesson_id)
 {
    $coordinator_name = Auth::user()->name;
    $coordinator_id = Auth::user()->coordinator_id;
    $coordinator = Coordinator::find( $coordinator_id) ;
    //$message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
    $year = Year::where('current_year', '1')->first();
    $lesson = Lesson::find($lesson_id);
    //$teacher = Teacher::find($teacher_id);
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
                     ->with(['student'=>fn($q1)=>$q1->where('religion', '1')->orderBy('first_name')])->find($room_id);
     } elseif ($lesson->religion == '0') {

        $students=Room::whereHas('student', function ($query) use($year){
                          $query->where('year_id', $year->id);
                           $query->where('religion', '0')->orderBy('first_name');

                     })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                     ->with(['student'=>fn($q1)=>$q1->where('religion', '0')->orderBy('first_name')])->find($room_id);
     } else {

         $students=Room::whereHas('student', function ($query) use($year){
                          $query->where('year_id', $year->id);

                     })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                     ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
     }



     if (!$students) {

         return redirect()->back()->with('error', '! لا يوجد طلاب');
     }

    //  $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
    //  $count = $count->count();


    //  $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
    //  $count2 = $count2->count();

      $class_id=Room::find($room_id)->class_id;
      $class=Classe::find($class_id);
      //$objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
     if($class->stage_id ==1){
         return view('school_controller.teacher_total', compact('coordinator_name','coordinator','room','students','lesson_id', 'room_id','lesson'));
     }
     elseif($class->stage_id ==2){
          return view('school_controller.teacher_total1', compact('coordinator_name','coordinator','room','students','lesson_id', 'room_id','lesson'));
     }
       elseif($class->stage_id ==3){
          return view('school_controller.teacher_total2', compact('coordinator_name','coordinator','room','students','lesson_id', 'room_id','lesson'));
     }
 }


 public function class_schedule()
    {
   
    $coordinator_id = Auth::user()->coordinator_id;
    $year = Year::where('current_year', '1')->first();
    // $coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id,$year) {
    //     $query->where('coordinator_id', $coordinator_id)->distinct();
    //   $query ->where('year_id',$year->id);
    // }])->find($coordinator_id);
    $coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id, $year) {
        $query->where('coordinator_id', $coordinator_id)->distinct();
        $query->where('rooms.year_id', $year->id); 
    }])->find($coordinator_id);

    $classes = $coordinator->classes->unique();

    foreach ($classes as $class) {
        $class->room3 = $class->room2->unique();
        unset($class->room2);
    }
    
 
    return view('school_controller.class_schedule', compact('coordinator', 'classes'));
}


    public function coordinator_subject2($room_id)
    {
        $coordinator_name = Auth::user()->name;
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);

        // Retrieve the room with its associated classes and the coordinator's room_cor
        $room = Room::with([
            'classes.lessons5' => function ($q2) use ($coordinator_id) {
                $q2->where('coordinator_id', $coordinator_id)->distinct();
            }
        ])->find($room_id);


        // Extract the room_cor array for each class
        $room_lessons = [];
        foreach ($room->classes as $class) {
            $room_cor_array = $class->room_cor->toArray();
            $room_lessons[$class->id] = $room_cor_array;
        }

        $room_name = $room->name;
        $class = $room->classes;

        return view('school_controller.subjects', compact('room_lessons', 'coordinator_name', 'room_name', 'coordinator', 'room_id', 'class'));
    }

    public function coordinator_subject($room_id)
    {
        
        $coordinator_name = Auth::user()->name;
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find( $coordinator_id) ;
        $room_lessons = Room::with([
            'classes.lessons5' => function ($q2) use ($coordinator_id) {
                $q2->where('coordinator_id', $coordinator_id)->distinct();
            }
        ])->find($room_id);
        //return  $room_lessons;
        $lessonsArray = $room_lessons->classes->lessons5;
        $room_lessons = [];
        $room = Room::find($room_id);
        $room_name = Room::find($room_id)->name;
        $class = Classe::where('id',$room->class_id );
        return view('school_controller.subjects',
        compact('lessonsArray', 'coordinator_name', 'room_name','coordinator', 'room_id','class'));
    }

    public function show_class_schedule($room_id, $time_zone_offset)
    {
        
        $year = Year::where('current_year', '1')->first();
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);

         $coordinator_id = Auth::user()->coordinator_id;
         
    //     $coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id,$year) {
    //     $query->where('coordinator_id', $coordinator_id)->distinct();
    //   $query ->where('year_id',$year->id);
    //      }])->find($coordinator_id);
    
    $coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id, $year) {
        $query->where('coordinator_id', $coordinator_id)->distinct();
        $query->where('rooms.year_id', $year->id); 
    }])->find($coordinator_id);
         
        $room = Room::findOrFail($room_id);
         $room_lessons = Room::with([
            'classes.lessons5' => function ($q2) use ($coordinator_id) {
                $q2->where('coordinator_id', $coordinator_id)->distinct();
            }
        ])->find($room_id);
        //return  $room_lessons;
        $lesson1=[];
         $lessons = $room_lessons->classes->lessons5;
         foreach($lessons as $lesson){
             $lesson1[]=$lesson->id;
         }
    
        $class_id = Room::findOrFail($room_id)->class_id;
           $teachers = DB::table('teachers')
                ->select('id', 'first_name', 'last_name')
                ->where('active',0)
                ->get();
    
            // pring lecture_tims
            $lecture_times = Lecture_time::where('room_id', $room->id)->orderBy('start_time', 'asc')->get();
            // pring days
            $days = Day::all();
            // pring romm schedule
             $schedule = Lesson_room_teacher_lecture_time::WhereHas('lesson', function ($q) use ($lesson1) {
                $q->whereIn('id',$lesson1); 
             })
         ->with ('teacher')->with(['lesson' => function ($q1) use ($lesson1) {
                $q1->whereIn('id',$lesson1);
                
            }])
                ->where('room_id', $room_id)->get();
    
            $room_name = $room->name;
            $room_id = $room->id;
            $class_name =  $room->classes->name;
            $now = Carbon::now();
            $timestamp = strtotime(now());
            $today = date('l', $timestamp);
            $today = $this->getDay($today);


        return view('school_controller.show_class_schedule',compact('coordinator','room', 'room_name', 'class_name', 'now', 'room_id', 'lessons', 'lecture_times', 'days', 'schedule', 'teachers', 'today'));
    }

    public function coordinator_subjects_lectures($lesson_id, $room_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $year = Year::where('current_year', '1')->first();
        $coordinator_name = Auth::user()->name;
        $coordinator_id = Auth::user()->coordinator_id;

        $coordinator = Coordinator::find($coordinator_id);
        $lesson = Lesson::find($lesson_id);
        $lectures = Lecture::where('room_id', $room_id)->where('lesson_id', $lesson_id)
         ->where('key','0')->whereHas('term_years', function ($q) use ($year) {
        $q->where('year_id', $year->id);
              })->where('active','0')->get();


        $class = Room::find($room_id)->classes;
        $room = Room::find($room_id);
        $now = Carbon::now();
        return view('school_controller.new_subject_lectures', compact(
            'coordinator',
            'lectures',
            'lesson',
            'class',
            'room',
            'now'

        ));
    }
    //محتوى الدرس
    public function coordinator_lecture_content($lesson_id, $room_id, $lecture_id)
    {
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find( $coordinator_id) ;

        $book_details = Lesson_teacher_room_term_exam::where('lecture_id', $lecture_id)->orderBy("id", 'desc')->get();

        $lesson = Lesson::find($lesson_id);
        $videos = $book_details->where('type', '0');
        $voices = $book_details->where('type', '6');

        $tests = $book_details->where('type', '1');

        $quizes =  Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)
        ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')
        ->where('type', '2')->orWhere('type', '5')->get();

        $exams =  Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)
        ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')
        ->where('type', '3')->orWhere('type', '5')->get();

        $quizes1  =  Lesson_teacher_room_term_exam::where('lecture_id', $lecture_id)->orderBy("id", 'desc')
       ->Where('type', '8')->get();
        $additions = $book_details->where('type', '4');

        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $class = Room::find($room_id)->classes;
        $class_id = Room::find($room_id)->id;
        $room = Room::find($room_id);

        $lecture = Lecture::find($lecture_id);
        return view('school_controller.new_lecture_content', compact(
            'coordinator',
            'now',
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
    //add file for lessons
    // public function add_content($class_id, $coordinator_id, $room_id, $lecture_id)
    // {
    //     $year = Year::where('current_year', '1')->first();
    //     $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    //     $classes = Classe::with(['room' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find($class_id);
    //     $rooms = $classes->room;
    //     $rooms1 = [];
    //     foreach ($rooms as $room) {
    //         $a = Teacher_room_lesson::where('coordinator_id', $coordinator_id)->where('room_id', $room->id)->first();
    //         if ($a != null) {
    //             $rooms1[] = $a;
    //         }
    //     }
    //     $rooms1 = array_unique($rooms1);
    //     $rooms2 = [];
    //     foreach ($rooms1 as $room1) {
    //         $rooms2[] = Room::find($room1->room_id);
    //     }
    //     $rooms2 = array_unique($rooms2);
    //     $lessons = [];
    //     foreach ($rooms as $item) {
    //         if (count($item->coordinators) > 0) {

    //             foreach ($item->coordinators[0]->lessons as $item2) {

    //                 $lessons[] = $item2;
    //             }
    //         }
    //     }
    //     $lessons = array_unique($lessons);
    //     $coordinator = Coordinator::find( $coordinator_id) ;
    //     $rooms = $coordinator->rooms;
    //     $class_rooms = [];
    //     foreach ($rooms as $room) {

    //         $class_rooms[] = $room->where('class_id', $class_id)->get();
    //     }
    //     $class_rooms = array_unique($class_rooms);

    //     $lecture_id = Lecture::find($lecture_id);
    //     $room1 = room::find($room_id);

    //     return view('school_controller.addcontent',
    //     compact('objection', 'rooms2',
    //     'lecture_id', 'room_id', 'room1', 'class_id',
    //     'terms', 'coordinator', 'lessons'));
    // }

    //add file for lesson
    public function store_items_coor(Request $request)
    {
        $now=Carbon::now() ;
        $lecture = Lecture::find($request->lecture_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $item = new Lesson_teacher_room_term_exam;
        $item->namehomework = $request->namehomework;
        $item->lesson_id = $request->lesson_id;
        //$item->teacher_id = $request->teacher_id;
        $item->room_id = $request->room_id;
        $item->term_id = $term->id;
        $item->type = $request->type;
        if ($request->name_video == null && $request->name_audio == null &&  $request->namehomework == null &&  $request->name_quize == null  &&  $request->name_quize1 == null && $request->test == null && $request->name_addition == null &&  $request->name_exam == null) {
            return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
       // if ($request->video == null && $request->video_in == null && $request->quize_link1 == null && $request->quize1 == null && $request->audio_file == null && $request->voice == null && $request->audio_link == null && $request->test == null && $request->quize == null && $request->exam == null && $request->test_link == null && $request->quize_link == null && $request->exam_link == null && $request->addition == null  &&  $request->addition_link == null) {
       //     return redirect()->back()->with('message', 'المحتوى فارغ يرجى اعادة تعبئة البيانات من جديد');
       // }

            //item for file
        if ($item->type == 4) {

            $item->lecture_id = $request->lecture_id;
            $item->name_addition = $request->name_addition;
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $term->id;
            $item->type = $request->type;
            if ($request->addition == null  &&  $request->addition_link == null) {

                return redirect()->back()->with('message', 'محتوى الملف فارغ يرجى تعبئة البيانات من جديد');
            }
            if ($request->addition && $request->hasFile('addition')) {
                $item->addition =  $request->addition->store('filesteachers', 'public');
                if ($request->name_addition == null) {
                    return redirect()->back()->with('message', 'اسم الملف فارغ يرجى تعبئة البيانات من جديد');
                }
                $item->name_addition = $request->name_addition;
                if( !$request->addition->extension()){
                     return redirect()->back()->with('message', 'هناك خطأ بالملف المدخل ');
                }
                $item->extension =  $request->addition->extension();
                $item->save();
            }
            if ($request->addition_link != null) {

                $item->addition_link = $request->addition_link;

                if ($request->name_addition == null) {
                    return redirect()->back()->with('message', 'اسم الملف فارغ يرجى تعبئة البيانات من جديد');
                }
                $item->name_addition = $request->name_addition;
                $item->save();
            }

            $item->save();

            if($lecture->lecture_time < $now ) {
             $room = Room::find($request->room_id);
             $students = $room->student;
             foreach($students as $student){

                $noti = new Notification;
                $noti->user_id = Auth::user()->id;
                $noti->lesson_id = $request->lesson_id;
                $noti->student_id = $student->id;
                $noti->lecture_id = $request->lecture_id;
                $noti->room_id = $request->room_id;
                $noti->title ="تم اضافة ملفات للدرس";
                $noti->body = $request->name_addition;
                $noti->term_id = $term->id;
                $noti->type = 1;
                $noti->save();
                $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
                $devices = array();
                 foreach($tokens as $t){
                    array_push($devices, $t['s_fcm_token']);

                }
            $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, $noti->lecture_id,$devices);

            }
        }

            session()->flash('Add', 'تم تعديل  بنجاح');

            return redirect()->back()->with('Add', '! تمت العملية بنجاح ');
        }
    }

        //اقسام المكتبة الالكترونية
        public function electronic_sec(){

            $electronic_sections= Electronic_section::all();
            $coordinator_id = Auth::user()->coordinator_id;
            $coordinator = Coordinator::find( $coordinator_id) ;

            return view('school_controller.electronic_sections',
             compact('electronic_sections','coordinator_id','coordinator'));

        }
        //ملفات الاقسام الالكترونية
        public function electronic_files(Request $request, $id)
        {
            $coordinator_id = Auth::user()->coordinator_id;
            $coordinator = Coordinator::find( $coordinator_id) ;
            $electronic_sections = Electronic_section::find($id);
            $electronic_files = Electronic_file::where('section_id', $id)->get();
        return view('school_controller.electronic_section_files',
        compact('electronic_sections', 'electronic_files','coordinator_id','coordinator'));
    }

    public function exams_quizes_page()
    {

        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find( $coordinator_id) ;
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
      $coordinator = Coordinator::with(['classes.room_cor' => function ($query) use ($coordinator_id, $year) {
        $query->where('coordinator_id', $coordinator_id)->distinct();
        $query->where('rooms.year_id', $year->id); 
    }])->find($coordinator_id);


        $classes = $coordinator->classes->unique();

        foreach ($classes as $class) {
            $class->room3 = $class->room2->unique();
            unset($class->room2);
        }
        return view('school_controller.exams_quizes',
        compact('coordinator_id','coordinator','classes'));
    }
     //صفحة علامات المواد يلي منفوتهامن صفحة المذاكرات و الامتحانات
     public function marks_subjects($room_id, $coordinator_id)
     {
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find( $coordinator_id) ;
         //$lessons = $teacher->lessons;
         $room_lessons = Room::with([
            'classes.lessons5' => function ($q2) use ($coordinator_id) {
                $q2->where('coordinator_id', $coordinator_id)->distinct();
            }
        ])->find($room_id);
        //return  $room_lessons;
        $lessonsArray = $room_lessons->classes->lessons5;
        $room_lessons = [];
        $room = Room::find($room_id);
        $room_name = Room::find($room_id)->name;
        $class = Classe::where('id',$room->class_id );
        return view('school_controller.marks_subjects',
        compact('lessonsArray', 'room_name','coordinator', 'room_id','class'));
    }

      //عرض جميع الامتحانات
    public function coordinator_exam_mark($room_id, $coordinator_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam  = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '1')->where('is_file', '1')->get();
        $quize1 = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '1')->where('is_file','0')->get();
        $lesson = Lesson::find($lesson_id);
       // $teacher = Teacher::find($teacher_id);
        $coordinator = Coordinator::find( $coordinator_id) ;
        $room = Room::find($room_id);
        $class_id = Classe:: find($room->classes->id);
        $students = $room->student;
        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $students1 = $room->student;

        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $lecture = Lecture::where('lesson_id',$lesson->id)->where('class_id',$class_id->id)->where('active',0)->get();
        return view('school_controller.exam_mark', compact('lecture','students1',
        'message','exam', 'class_id','now','students',
        'coordinator','lesson', 'room','lesson_id', 'room_id','quize1'));
    }
 //عرض صفحة علامات الامتحانات
 public function exam_students($room_id, $coordinator_id, $lesson_id, $exam_id)
 {

     $year = Year::where('current_year', '1')->first();
     $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
     $lesson = Lesson::find($lesson_id);
     $coordinator = Coordinator::find( $coordinator_id) ;
     $room = Room::find($room_id);
     $students = $room->with('student.exams_files')->with('student.exam_result2')->get();
     $exam = Exams2::find($exam_id);
     $quize_result = Room::with(['student.exam_result2' => function ($q) {
         $q->where('id', '<>', null)->orderBy('type');
     }])->where('id', $room_id)->get();

     // $exam_title = Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)
     //     ->where('teacher_id', $teacher_id)->orderBy('type')->get();
     if($exam->type=='1'&& $exam->is_file == '1'){
         $exam_result = Exam_result2::with('student')->with(['student.exams_files' => function ($query) use ($exam_id) {
                 $query->where('exam_id', $exam_id);
             }])
             ->where(function ($query) {
                 $query->whereHas('student.exams_files')
                 ->orWhereDoesntHave('student.exams_files');
             })
             ->where('exam_id', $exam_id)
             ->where('room_id', $room_id)
             ->get();

         return view('school_controller.exam_student', compact('students','exam',  'exam_result','lesson','room' ,'coordinator', 'exam_id', 'lesson_id', 'room_id'));
     }
     if($exam->type=='1' && $exam->is_file == '0'){
         $exam_result  = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();

        return view('school_controller.exammark_auto', compact('exam', 'exam_result','lesson','room' ,'coordinator', 'exam_id', 'lesson_id', 'room_id'));
   }
}
//صفحة اضافة اسئلة
public function exams1_addquestion($exam_id,$room_id,$class_id,$lesson_id)
{
    $coordinator_id = Auth::user()->coordinator_id;
    $coordinator = Coordinator::find($coordinator_id);
    $year = Year::where('current_year', '1')->first();
    $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    $exam = Exams2::find($exam_id);
    $exams=Exams2::with('room')->where('groupe',$exam->groupe)->get();

    $questions = Question::where('class_id', $exam->class_id)->
    where('lesson_id', $exam->lesson_id)->where('accept',1)->get();
        // return $questions;
    return view('school_controller.exams1_addquestion',
    compact('questions', 'exam', 'coordinator','room_id','exams','lesson_id','class_id'));
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
    foreach($selected_ques as $question_id){
        $question = Question::findOrFail($question_id) ;
       $exam_question=Exam_question::where('exam_id',$exam->id)->where('question_id',$question_id)->delete();
       $exam_new=new Exam_question();
       $exam_new->exam_id=$request->room_id[0];
       $exam_new->question_id=$question_id;
       $exam_new->mark=$question->mark;
       $exam_new->save();

          
    }
    $studivs = array();
    foreach (json_decode($exam->selected_ques) as $x) {
        $studivs[] = $x;
    }
    session()->flash('success', 'تم وضع السؤال بنجاح   ');
    return redirect()->back()->with('success', '! تمت العملية بنجاح');

    }
    //مشاهدة ملف الامتحان
    public function quest_exam1($exam_id,$class_id,$lesson_id) {
        $exam = Exams2::find($exam_id);
        $coordinator = Coordinator::find(auth()->user()->coordinator_id);
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

        return view('school_controller.examfile1',compact(
        'selected_ques1','selected_ques','exam','coordinator','class','room','term','lesson','class1','year'));
        }
        else{
            session()->flash('error', ' لم يتم اختيار أي سؤال لهذا الامتحان !! ');
            return redirect()->back();
        }
}
public function StudentsRoomLesson_quize($room_id, $coordinator_id, $lesson_id)
{
    $year = Year::where('current_year', '1')->first();
    $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    $quizes  = Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '2')->where('is_file', '1')->get();
    $quize1 = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '2')->where('is_file','0')->get();
    $lesson = Lesson::find($lesson_id);
    $coordinator = Coordinator::find(auth()->user()->coordinator_id);

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
    return view('school_controller.quize_mark', compact('students1','quizes','class_id', 'quize1','students','room','lesson' ,'now', 'lesson_id', 'room_id', 'count', 'count2'));
}
public function studentselect($exam,$room)
{
    $student=[];
    $exam_id=Exam_result2::where('exam_id',$exam)->where('room_id',$room)->get();
     foreach( $exam_id as $item ){

            $student[]=$item->user_id;

        }
  return    $students = Student:: whereIn('id',$student)->get();

}

public function detexam(Request $request)
{

         $exam = Exams2::with('room')->where('groupe',$request->groupe)->get();
         return $exam;
}

public function add_quize_student(Request $request){
    $year = Year::where('current_year', '1')->first();
    $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    $exam11=Exams2::find($request->exam);
    $exam_result=Exam_result2 ::where('exam_id',$request->exam)->where('room_id',$request->room_id)->get();
   foreach ($exam_result as $item) {
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

        //     if($exam11->type==2){
        //     $noti = new Notification;
        //     $noti->user_id = Auth::user()->id;
        //     $noti->student_id = $student->id;
        //     $noti->lesson_id = $request->lesson_id;
        //     $noti->room_id = $request->room_id;
        //     $noti->title ="تم اضافة  مذاكرة";
        //     $noti->body = $exam11->name;
        //     $noti->term_id = $term->id;
        //     $noti->type = 4;
        //     $noti->save();
        //     $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

        //     $devices = array();
        //     foreach($tokens as $t){
        // array_push($devices, $t['s_fcm_token']);
        // //array_push($devices['p_id'], $t['p_fk']);
        //     }
        // $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, 'null',$devices);
        //     }
        //     else{
        //     $noti = new Notification;
        //     $noti->user_id = Auth::user()->id;
        //     $noti->student_id = $student->id;
        //     $noti->lesson_id = $request->lesson_id;
        //     $noti->room_id = $request->room_id;
        //     $noti->title ="تم اضافة  امتحان";
        //     $noti->body = $exam11->name;
        //     $noti->term_id = $term->id;
        //     $noti->type = 5;
        //     $noti->save();
        //     $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
        //     $devices = array();
        //     foreach($tokens as $t){
        // array_push($devices, $t['s_fcm_token']);
        // //array_push($devices['p_id'], $t['p_fk']);
        //     }
        // $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, 'null',$devices);
        //     }
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

        // if($exam11->type==2){
        // $noti = new Notification;
        //     $noti->user_id = Auth::user()->id;
        //     $noti->student_id = $student->id;
        //     $noti->lesson_id = $request->lesson_id;
        //     $noti->room_id = $request->room_id;
        //     $noti->title ="تم اضافة  مذاكرة";
        //     $noti->body = $exam11->name;
        //     $noti->term_id = $term->id;
        //     $noti->type = 4;
        //     $noti->save();
        //     $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
        //     $devices = array();
        //     foreach($tokens as $t){
        // array_push($devices, $t['s_fcm_token']);
        // //array_push($devices['p_id'], $t['p_fk']);
        //     }
        // $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, 'null',$devices);
        //     }
        //     elseif($exam11->type==1){

        //     $noti = new Notification;
        //     $noti->user_id = Auth::user()->id;
        //     $noti->student_id = $student->id;
        //     $noti->lesson_id = $request->lesson_id;
        //     $noti->room_id = $request->room_id;
        //     $noti->title ="تم اضافة  امتحان";
        //     $noti->body = $exam11->name;
        //     $noti->term_id = $term->id;
        //     $noti->type = 5;
        //     $noti->save();
        //     $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
        //     $devices = array();
        //     foreach($tokens as $t){
        // array_push($devices, $t['s_fcm_token']);
        // //array_push($devices['p_id'], $t['p_fk']);
        //     }
        // $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, 'null',$devices);
        //     }

    }
    }
}

    return  redirect()->back()->with('success', '! تمت العملية بنجاح ');
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
            return  $students;
            }
        }
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

    $questions[] = Question::with(['exam_question'=>fn($q1)=>$q1->where('exam_id',$exam_id)])->with('option')->find($question_id);
        }
    }
    $exam_result = Exam_result2::where('exam_id', $exam_id)->where('user_id', $student->id)->first();
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
    //$message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
    $coordinator = Coordinator::find(auth()->user()->coordinator_id);
    return view('school_controller.teacher_quizefile',compact('student','coordinator','max_result','exam_id','questions', 'exam', 'exam_result', 'class1','room','term','year','class','lesson'));
}
public function coor_quize_mark($room_id, $coordinator_id, $lesson_id)
{

    $year = Year::where('current_year', '1')->first();
    $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    $quizes  = Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '2')->where('is_file', '1')->get();
    $quize1 = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '2')->where('is_file','0')->get();
    $lesson = Lesson::find($lesson_id);
    $coordinator = Coordinator::find($coordinator_id);

    $room = Room::find($room_id);
    $class_id = Classe:: find($room->classes->id);
    $students = $room->student;
    $students1 = $room->student;
    $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

    $date = new DateTime();
    $now = $date->format('Y-m-d H:i:s');

    $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
    $count2 = $count2->count();
    $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
    $lecture = Lecture::where('lesson_id',$lesson->id)->where('class_id',$class_id->id)->where('active',0)->get();

    return view('school_controller.quize_mark', compact('lecture','students1',
    'quizes','class_id', 'quize1','students','room','lesson' ,'coordinator','now', 'lesson_id', 'room_id', 'count2'));
}
public function coor_quize_students($room_id, $coordinator_id, $lesson_id, $exam_id)
{

    $year = Year::where('current_year', '1')->first();
    $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    $lesson = Lesson::find($lesson_id);
    $coordinator = Coordinator::find($coordinator_id);
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
    $quize = Exams2::find($exam_id);
    if($exam1->type=='2'&& $exam1->is_file == '0'){
        $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();

        return view('school_controller.quize_students_outo', compact('students','exam1',  'quize_result','lesson','room' ,'coordinator', 'exam_id', 'lesson_id', 'room_id'));
    }
    if($quize->type=='2'&& $quize->is_file == '1'){
                $quize_result =Exam_result2::with('student')->with(['student.exams_files' => function ($query) use ($exam_id) {
                $query->where('exam_id', $exam_id);
            }])

            ->where(function ($query) {
            $query->whereHas('student.exams_files')
            ->orWhereDoesntHave('student.exams_files');
            })
                ->where('exam_id', $exam_id)
                ->where('room_id', $room_id)
                ->get();
        return view('school_controller.quize_students', compact('students','quize', 'quize_result','lesson','room' ,'coordinator', 'exam_id', 'lesson_id', 'room_id'));
}
}
   //عرض وظائف الطلاب
   public function StudentsRoomLesson($room_id, $coordinator_id, $lesson_id, $exam_id)
   {

       $year = Year::where('current_year', '1')->first();
       $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
       $lesson = Lesson::find($lesson_id);
       $coordinator = Coordinator::find( auth()->user()->coordinator_id);
       $room = Room::find($room_id);

      $students = $room->with('student.exam_result')
   ->whereHas('student.student_lesson_teacher_room_term_exam', function ($query) use ($exam_id) {
       $query->where('exam_id', $exam_id);
   })
   ->with(['student.student_lesson_teacher_room_term_exam' => function ($query) use ($exam_id) {
       $query->where('exam_id', $exam_id);
   }])
   ->get();
       $exam1 = Lesson_teacher_room_term_exam::find($exam_id);
       $quize_result = Room::with(['student.exam_result' => function ($q) {
           $q->where('id', '<>', null)->orderBy('type');
       }]) ->whereHas('student.student_lesson_teacher_room_term_exam', function ($query) use ($exam_id) {
       $query->where('exam_id', $exam_id);
   })
   ->with(['student.student_lesson_teacher_room_term_exam' => function ($query) use ($exam_id) {
       $query->where('exam_id', $exam_id);
   }])
   ->where('id', $room_id)->get();
    //    $exam_title = Lesson_teacher_room_term_exam::where('room_id', $room_id)->where('lesson_id', $lesson_id)
    //        ->where('teacher_id', $teacher_id)->orderBy('type')->get();

       return view('school_controller.homework_students', compact('students', 'exam1','lesson' ,'room', 'quize_result', 'coordinator', 'exam_id', 'lesson_id', 'room_id'));
   }

    ///فلترة تقديم وظيفة من ليس مقدم
    ///فلترة تقديم وظيفة من ليس مقدم
     public function homeworkestudent($lec,$home,$room_id)
    {
        
        if ($lec == 1) {
        // تقديم
            $student=[];
	     $exam_id=Student_lesson_teacher_room_term_exam::where('exam_id',$home)->where('file','!=',null)->get();

         if($exam_id){
             $room = Room::where('id',$room_id)->first();
             $room_student=Room_student::where('room_id',$room->id)->get();

       foreach( $exam_id as $item ){
                foreach( $room_student as $item1 ){
                
                if($item1->student_id== $item->student_id){
                $student[]=$item->student_id;
}
            }}
                  $students = Student:: with('student_lesson_teacher_room_term_exam')->with('exam_result')->
               whereIn('id',$student)->get();

              }
                return  $students;
         }
         elseif($lec == 2){
            $ro1=[];
            $student=[];
            $students=[];
            $student123=[];
             $room = Room::where('id',$room_id)->first();
	         $exam_id=Student_lesson_teacher_room_term_exam::where('exam_id',$home)->where('file','!=',null)->get();
         if(count($exam_id)>0){
            foreach( $exam_id as $item ){
                $student[]=$item->student_id;
            }

              
                $room_student=Room_student::where('room_id',$room->id)->get();

               foreach( $room_student as $item ){
                    $student123[]=$item->student_id;
 
                }
                        $student123=  array_diff($student123,$student);

            $students = Student:: with('student_lesson_teacher_room_term_exam')->with('exam_result')->

            whereIn("id",$student123)->get();
              }
              else{
                  $room_student=Room_student::where('room_id',$room->id)->get();

               foreach( $room_student as $item ){
                    $student123[]=$item->student_id;
 
                }
                  $students = Student:: with('student_lesson_teacher_room_term_exam')->with('exam_result')->

            whereIn("id",$student123)->get();
              }
                 return  $students;
         }
         else{
           
            $ro1=[];
            $student=[];
	       $exam_id=Lesson_teacher_room_term_exam::find($home);

         if($exam_id){
           
             $room = Room::where('id',$exam_id->room_id)->first();
             $room_student=Room_student::where('room_id',$room->id)->get();

                foreach( $room_student as $item1 ){
                $student[]=$item1->student_id;
            }
           
       
                  $students = Student:: with(['student_lesson_teacher_room_term_exam' => function ($query) use ($home) {
                     $query->where('exam_id', $home);
                  }])->with('exam_result')->
               whereIn('id',$student)->get();

               $exam1 = Lesson_teacher_room_term_exam::find($lec);
               $quize_result = Room::with(['student.exam_result' => function ($q) {
                   $q->where('id', '<>', null)->orderBy('type');
               }]) ->whereHas('student.student_lesson_teacher_room_term_exam', function ($query) use ($exam_id) {
        $query->where('exam_id', $exam_id);
    })
    ->with(['student.student_lesson_teacher_room_term_exam' => function ($query) use ($exam_id) {
        $query->where('exam_id', $exam_id);
    }])
    ->where('id', $room->id)->get();

                    return  $students;

              } 
         }




    }



       public function pdf($lesson_id, $teacher_id, $class_id, $id)
    {
        $classes = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $teacher = Teacher::find($teacher_id);
        $item = Evaluation::find($id);
        return view('coordinators.d_cor_ev_p', compact('item', 'coordinator', 'teacher', 'classes', 'lesson', 'year'));
    }
    public function all_pdf($lesson_id, $teacher_id, $class_id)
    {
        $classes = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $teacher = Teacher::find($teacher_id);
        $evaluation = Evaluation::where('lesson_id', $lesson->id)->where('term', $term->id)->where('teacher_id', $teacher->id)->where('class_id', $classes->id)->where('coor_id', Auth::user()->coordinator_id)->orderBy('id', 'Asc')->get();
        return view('coordinators.all_d_cor_ev_p', compact('evaluation', 'coordinator', 'teacher', 'classes', 'lesson', 'year'));
    }


    public function searchdate(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($request->lesson_id);
        $teacher = Teacher::find($request->teacher_id);
        $classes = Classe::find($request->class_id);



        $evaluation = Evaluation::where('lesson_id', $lesson->id)->where('term', $term->id)->where('teacher_id', $teacher->id)->where('class_id', $classes->id)->where('coor_id', Auth::user()->coordinator_id)->where('date', $request->search)->orderBy('id', 'Asc')->paginate(1);
        return view('coordinators.evaluation', compact('evaluation', 'teacher', 'classes', 'lesson'));
    }
    public function showclass($lesson_id, $teacher_id, $class_id)
    {
        $classes = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $teacher = Teacher::find($teacher_id);
        $evaluation = Evaluation::where('lesson_id', $lesson_id)->where('term', $term->id)->where('teacher_id',    $teacher_id)->where('class_id', $class_id)->where('coor_id', Auth::user()->coordinator_id)->orderBy('id', 'Asc')->paginate(1);
        return view('coordinators.showclass', compact('evaluation', 'coordinator', 'teacher', 'classes', 'lesson', 'year'));
    }
    public function addevaluion(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $evaluion1 = Evaluation::where('class_id', $request->class_id)->where('term', $term->id)->where('lesson_id', $request->lesson_id)->where('teacher_id', $request->teacher_id)->where('coor_id', Auth::user()->coordinator_id)->orderBy('id', 'DESC')->first();

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $evaluion = new Evaluation();
        $evaluion->final_grade = $request->final_grade;
        $evaluion->lesson_id = $request->lesson_id;
        $evaluion->teacher_id = $request->teacher_id;
        $evaluion->date = $request->date;
        $evaluion->title = $request->title;
        $evaluion->year = $year->id;
        $evaluion->term = $term->id;
        if ($request->Standard1) {
            $evaluion->Standard1 = $request->Standard1[0];
        }
        if ($request->Standard2) {
            $evaluion->Standard2 = $request->Standard2[0];
        }
        if ($request->Standard31) {
            $evaluion->Standard31 = $request->Standard31[0];
        }
        if ($request->Standard32) {
            $evaluion->Standard32 = $request->Standard32[0];
        }
        if ($request->Standard33) {
            $evaluion->Standard33 = $request->Standard33[0];
        }

        if ($request->Standard41) {
            $evaluion->Standard41 = $request->Standard41[0];
        }
        if ($request->Standard42) {
            $evaluion->Standard42 = $request->Standard42[0];
        }
        if ($request->Standard43) {
            $evaluion->Standard43 = $request->Standard43[0];
        }
        if ($request->Standard44) {
            $evaluion->Standard44 = $request->Standard44[0];
        }
        if ($request->Standard45) {
            $evaluion->Standard45 = $request->Standard45[0];
        }
        if ($request->Standard46) {
            $evaluion->Standard46 = $request->Standard46[0];
        }
        if ($request->Standard47) {
            $evaluion->Standard47 = $request->Standard47[0];
        }
        if ($request->Standard48) {
            $evaluion->Standard48 = $request->Standard48[0];
        }
        if ($request->Standard51) {
            $evaluion->Standard51 = $request->Standard51[0];
        }
        if ($request->Standard51) {
            $evaluion->Standard52 = $request->Standard52[0];
        }
        $evaluion->Standard1_mark = $request->Standard1_mark;

        $evaluion->Standard2_mark = $request->Standard2_mark;

        $evaluion->Standard31_mark = $request->Standard31_mark;

        $evaluion->Standard32_mark = $request->Standard32_mark;
        $evaluion->Standard33_mark = $request->Standard33_mark;

        $evaluion->Standard41_mark = $request->Standard41_mark;
        $evaluion->Standard42_mark = $request->Standard42_mark;
        $evaluion->Standard43_mark = $request->Standard43_mark;
        $evaluion->Standard44_mark = $request->Standard44_mark;
        $evaluion->Standard45_mark = $request->Standard45_mark;
        $evaluion->Standard46_mark = $request->Standard46_mark;
        $evaluion->Standard47_mark = $request->Standard47_mark;
        $evaluion->Standard48_mark = $request->Standard48_mark;
        $evaluion->Standard51_mark = $request->Standard51_mark;
        $evaluion->Standard52_mark = $request->Standard52_mark;
        $evaluion->coor_id = Auth::user()->coordinator_id;
        $evaluion->class_id = $request->class_id;
        if ($evaluion1 != null) {
            $evaluion->number = $evaluion1->number + 1;
        } else {
            $evaluion->number = 1;
        }
        $evaluion->save();
        return redirect()->back();
    }
    public function editevaluion(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $evaluion =  Evaluation::find($request->id);
        $evaluion->final_grade = $request->final_grade;
        $evaluion->lesson_id = $request->lesson_id;
        $evaluion->teacher_id = $request->teacher_id;
        $evaluion->date = $request->date;
        $evaluion->title = $request->title;
        $evaluion->year = $year->id;
        $evaluion->term = $term->id;
        if ($request->Standard1) {
            $evaluion->Standard1 = $request->Standard1[0];
        }
        if ($request->Standard2) {
            $evaluion->Standard2 = $request->Standard2[0];
        }
        if ($request->Standard31) {
            $evaluion->Standard31 = $request->Standard31[0];
        }
        if ($request->Standard32) {
            $evaluion->Standard32 = $request->Standard32[0];
        }
        if ($request->Standard33) {
            $evaluion->Standard33 = $request->Standard33[0];
        }

        if ($request->Standard41) {
            $evaluion->Standard41 = $request->Standard41[0];
        }
        if ($request->Standard42) {
            $evaluion->Standard42 = $request->Standard42[0];
        }
        if ($request->Standard43) {
            $evaluion->Standard43 = $request->Standard43[0];
        }
        if ($request->Standard44) {
            $evaluion->Standard44 = $request->Standard44[0];
        }
        if ($request->Standard45) {
            $evaluion->Standard45 = $request->Standard45[0];
        }
        if ($request->Standard46) {
            $evaluion->Standard46 = $request->Standard46[0];
        }
        if ($request->Standard47) {
            $evaluion->Standard47 = $request->Standard47[0];
        }
        if ($request->Standard48) {
            $evaluion->Standard48 = $request->Standard48[0];
        }
        if ($request->Standard51) {
            $evaluion->Standard51 = $request->Standard51[0];
        }
        if ($request->Standard51) {
            $evaluion->Standard52 = $request->Standard52[0];
        }
        $evaluion->Standard1_mark = $request->Standard1_mark;

        $evaluion->Standard2_mark = $request->Standard2_mark;

        $evaluion->Standard31_mark = $request->Standard31_mark;


        $evaluion->Standard32_mark = $request->Standard32_mark;
        $evaluion->Standard33_mark = $request->Standard33_mark;

        $evaluion->Standard41_mark = $request->Standard41_mark;
        $evaluion->Standard42_mark = $request->Standard42_mark;
        $evaluion->Standard43_mark = $request->Standard43_mark;
        $evaluion->Standard44_mark = $request->Standard44_mark;
        $evaluion->Standard45_mark = $request->Standard45_mark;
        $evaluion->Standard46_mark = $request->Standard46_mark;
        $evaluion->Standard47_mark = $request->Standard47_mark;
        $evaluion->Standard48_mark = $request->Standard48_mark;
        $evaluion->Standard51_mark = $request->Standard51_mark;
        $evaluion->Standard52_mark = $request->Standard52_mark;
        $evaluion->coor_id = Auth::user()->coordinator_id;
        $evaluion->class_id = $request->class_id;

        $evaluion->save();
        return redirect()->back();
    }
    public function coordinator_teacher($class_id,$teacher_id,$lesson_id)
    {

          $cor_lesson1=[];
        $coordinator_id = Auth::user()->coordinator_id;
        $teacher = Teacher::find($teacher_id);

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $coordinator = Coordinator::find($coordinator_id);

          $cor_clas= Coordinator_class_lesson::where('coordinator_id',$coordinator->id)->get();

         $classes=Classe::find($class_id);


         $lesson=Lesson::where('id',$lesson_id)->first();

        return view('coordinators.coordinator_teacher', compact('teacher','coordinator', 'classes','lesson'));
    }
    public function coordinator_teacher_lesson($class_id,$teacher_id,$lesson_id)
    {
 $year = Year::where('current_year', '1')->first();
         $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
          $cor_lesson1=[];
        $coordinator_id = Auth::user()->coordinator_id;
        $teacher = Teacher::find($teacher_id);

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $coordinator = Coordinator::find($coordinator_id);

          $cor_clas= Coordinator_class_lesson::where('coordinator_id',$coordinator->id)->get();

         $classes=Classe::find($class_id);


         $lesson=Lesson::where('id',$lesson_id)->first();
         $lectures = $lesson->lectures()->where('active', 0)->where('teacher_id', $teacher_id)->where('term_id', $terms->id)->get();

        return view('coordinators.coordinator_teacher_lesson', compact('teacher','coordinator', 'classes','lesson','lectures'));
    }
    public function pdfdownload($id)
    {
        $prepare=Prepare::find($id);

        $class_id= Classe::find($prepare->class_id);

        $lesson_id=Lesson::find($prepare->lesson_id);
        if($lesson_id->is_english==1){
             $means= Means::where('lang',2)->get();
            $road= Road::where('lang',2)->get();
            return view('coordinators.ll_en',compact('means','road','prepare','lesson_id','class_id'));
        }
        elseif($lesson_id->lang==0 && $lesson_id->lang !=null  ){
            return view('coordinators.ll_fr',compact('prepare','lesson_id','class_id'));
        }
        else{
             $means= Means::where('lang',1)->get();
            $road= Road::where('lang',1)->get();
            return view('coordinators.ll',compact('means','road','prepare','lesson_id','class_id'));
        }


    }
    public function multipdfdownload($id,$teacher_id)
    {
        $prepare=Prepare::find($id);
        $lesson_id=Lesson::find($prepare->lesson_id);
        $class_id= Classe::find($prepare->class_id);
         $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $prepares=Prepare::where('class_id',$class_id->id)->where('term_id',$term->id)->where('lesson_id',$lesson_id->id)->where('teacher_id',$teacher_id)->get();
      if( $lesson_id->is_english==1){
           $means= Means::where('lang',2)->get();
            $road= Road::where('lang',2)->get();
        return view('coordinators.allbook_en',compact('means','road','prepares','lesson_id','class_id'));
      }
      elseif($lesson_id->lang==0 && $lesson_id->lang !=null ){
        return view('coordinators.allbook_fr',compact('prepares','lesson_id','class_id'));
      }

      else{
           $means= Means::where('lang',1)->get();
            $road= Road::where('lang',1)->get();
        return view('coordinators.allbook',compact('means','road','prepares','lesson_id','class_id'));
      }


    }
     public function searchlect(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson_id=Lesson::find($request->lesson_id);
        $teacher=Teacher::find($request->teacher_id);
        $class_id= Classe::find($request->class_id);
if($lesson_id->is_english==1){
      $means= Means::where('lang',2)->get();
            $road= Road::where('lang',2)->get();

    $prepare=Prepare::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('term_id',$request->term)->where('teacher_id',$request->teacher_id)->where('lecture', 'LIKE', '%' . $request->search . "%")->paginate(1);
    return view('coordinators.load_en',compact('means','road','prepare','teacher','class_id','lesson_id','term'));
}
elseif($lesson_id->lang==0 && $lesson_id->lang !=null ){

    $prepare=Prepare::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('term_id',$request->term)->where('teacher_id',$request->teacher_id)->where('lecture', 'LIKE', '%' . $request->search . "%")->paginate(1);
    return view('coordinators.load_fr',compact('prepare','teacher','class_id','lesson_id','term'));
}



else{
    $means= Means::where('lang',1)->get();
    $road= Road::where('lang',1)->get();
    $prepare=Prepare::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('term_id',$request->term)->where('teacher_id',$request->teacher_id)->where('lecture', 'LIKE', '%' . $request->search . "%")->paginate(1);
    return view('coordinators.load',compact('means','road','prepare','class_id','teacher','lesson_id','term'));
}

}

    public function coordinator_show($lesson_id, $teacher_id, $room_id, $lecture_id)

    {
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $teacher = Teacher::find($teacher_id);
        $book_details = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
            ->where('room_id', $room_id)->orderBy("id", 'desc')->get();

        $book_details = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
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
 $lesson=Lesson::where('id',$lesson_id)->first();
          $classes=Classe::find($class_id);
        $lecture = Lecture::find($lecture_id);
        return view('coordinators.coordinator_show', compact(
            'teacher',
            'now',
            'classes',
            'lesson',
            'coordinator',
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
    public function prepare (Request $request,$class_id,$lesson_id,$teacher_id)
    {
         $lesson=Lesson::where('id',$lesson_id)->first();
          $classes=Classe::find($class_id);
        $teacher=Teacher::find($teacher_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
                $lesson_id=Lesson::find($lesson_id);
        if($lesson_id->is_english==1){
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

            $class_id= Classe::find($class_id);

            $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

            if ($request->ajax()) {

                $class_id= Classe::find($class_id);

                $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

                return view('coordinators.load_en')->withprepare($prepare)->withclass_id($class_id)->withlesson_id($lesson_id);

            }
             $means= Means::where('lang',2)->get();
             $road= Road::where('lang',2)->get();
            return  view('coordinators.coordinator_teacher_prepare_en', compact('means','road','lesson','classes','teacher','prepare','coordinator','lesson_id','class_id','year','term'));

        }
        if($lesson_id->lang==0 && $lesson_id->lang !=null ){
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

            $class_id= Classe::find($class_id);
            $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

            if ($request->ajax()) {

                $class_id= Classe::find($class_id);

                $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

                return view('coordinators.load_fr')->withprepare($prepare)->withclass_id($class_id)->withlesson_id($lesson_id);

            }
            return  view('coordinators.coordinator_teacher_prepare_fr', compact('lesson','classes','teacher','prepare','coordinator','lesson_id','class_id','year','term'));

        }
        else{

            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
            $class_id= Classe::find($class_id);
            $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

            if ($request->ajax()) {

                $class_id= Classe::find($class_id);

                $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

                return view('coordinators.load')->withprepare($prepare)->withclass_id($class_id)->withlesson_id($lesson_id);

            }
             $means= Means::where('lang',1)->get();
             $road= Road::where('lang',1)->get();
            return  view('coordinators.coordinator_teacher_prepare', compact('means','road','lesson','classes','teacher','prepare','coordinator','lesson_id','class_id','year','term'));

        }

    }

       public function planification($class_id,$lesson_id)
    {
        $classes=Classe::find($class_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $lesson=Lesson::where('id',$lesson_id)->first();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $classes=Classe::find($class_id->id);




         $lesson_id=Lesson::find($lesson_id);
           $lesson=Lesson::where('id',$lesson_id->id)->first();
          $planification_trimestrielle=Planification_trimestrielle::where('coor_id',auth()->user()->coordinator_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();


        return view('coordinators.coordinatore_planification',compact('planification_trimestrielle','term','classes','lesson','coordinator','class_id','lesson_id','lesson','classes','year'));

    }
        public function planification_trimestrielle($class_id,$lesson_id)
    {
        $classes=Classe::find($class_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $lesson=Lesson::where('id',$lesson_id)->first();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $classes=Classe::find($class_id->id);




         $lesson_id=Lesson::find($lesson_id);
           $lesson=Lesson::where('id',$lesson_id->id)->first();
          $planification_trimestrielle=Planification_trimestrielle::where('coor_id',auth()->user()->coordinator_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();


        return view('coordinators.coordinatore_planification_trimestrielle',compact('planification_trimestrielle','term','classes','lesson','coordinator','class_id','lesson_id','lesson','classes','year'));

    }

       public function teacher_planification($class_id,$lesson_id,$teacher_id)
    {
        $classes=Classe::find($class_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $lesson=Lesson::where('id',$lesson_id)->first();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $classes=Classe::find($class_id->id);



  $teacher=Teacher::find($teacher_id);
         $lesson_id=Lesson::find($lesson_id);
           $lesson=Lesson::where('id',$lesson_id->id)->first();
          $planification_trimestrielle=Planification_trimestrielle::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();


        return view('coordinators.teacher_planification',compact('teacher','planification_trimestrielle','term','classes','lesson','coordinator','class_id','lesson_id','lesson','classes','year'));

    }
         public function coordinator_teacher_plan($class_id,$lesson_id,$teacher_id)
    {
        $classes=Classe::find($class_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $lesson=Lesson::where('id',$lesson_id)->first();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $classes=Classe::find($class_id->id);



  $teacher=Teacher::find($teacher_id);
         $lesson_id=Lesson::find($lesson_id);
           $lesson=Lesson::where('id',$lesson_id->id)->first();
          $planification_trimestrielle=Planification_trimestrielle::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();


        return view('coordinators.coordinator_teacher_plan',compact('teacher','planification_trimestrielle','term','classes','lesson','coordinator','class_id','lesson_id','lesson','classes','year'));

    }
    public function addplanification(Request $request)
    {

        if($request->planification_trimestrielle_id){
            $planification =Planification_trimestrielle:: find($request->planification_trimestrielle_id);
            $planification->lesson_id=$request->lesson_id;
            $planification->class_id=$request->class_id;
            $planification->term_id=$request->term_id;
            $planification->year_id=$request->year_id;
            $planification->coor_id=auth()->user()->coordinator_id;
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
            $planification->coor_id=auth()->user()->coordinator_id;
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
      public function coordinator_lesson($class_id,$lesson_id)
    {

          $cor_lesson1=[];
        $coordinator_id = Auth::user()->coordinator_id;


        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $coordinator = Coordinator::find($coordinator_id);

          $cor_clas= Coordinator_class_lesson::where('coordinator_id',$coordinator->id)->get();

         $classes=Classe::find($class_id);


         $lesson=Lesson::where('id',$lesson_id)->first();


        return view('coordinators.coordinatore_lesson', compact('coordinator', 'classes','lesson'));
    }
        public function addunit(Request $request)
    {
        $unti= new Unit_analysis();
        $unti->unit_name=$request->unit_name;
         $unti->coor_id=auth::user()->coordinator_id;
        $unti->class_id=$request->class_id;
        $unti->lesson_id=$request->lesson_id;
        $unti->year_id=$request->year_id;
        $unti->term_id=$request->term_id;
        $unti->contain=json_encode(json_decode($request->conatin));
        $unti->save();

    return redirect()->back();

    }

    public function show_unit($class_id,$lesson_id)
    {
            $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
       $classes =Classe::find($class_id->id);
         $lesson_id=Lesson::find($lesson_id);
        $unit=Unit_analysis::where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id)->where('term_id',$term->id)->where('coor_id',$coordinator_id)->paginate(1);
 if($unit->isEmpty()){
      return redirect()->back();

 }
           return view('coordinators.coordinatore_showunits',compact('classes','term','coordinator','class_id','lesson_id','year','unit'));

    }
       public function coordinator_teacher_showunit($class_id,$lesson_id,$teacher_id)
    {
          $teacher=Teacher::find($teacher_id);
            $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);

         $lesson_id=Lesson::find($lesson_id);

        $unit=Unit_analysis::where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id)->where('term_id',$term->id)->where('teacher_id',$teacher_id)->paginate(1);
 if($unit->isEmpty()){
      return redirect()->back();

 }
           return view('coordinators.coordinator_teacher_showunit',compact('teacher','term','coordinator','class_id','lesson_id','year','unit'));

    }

    public function updateunit(Request $request)
    {
        $unti=  Unit_analysis::find($request->unitid);
        $unti->unit_name=$request->unit_name;
        $unti->coor_id=auth()->user()->coordinator_id;
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


       $unit=Unit_analysis::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('year_id',$request->year)->where('term_id',$request->term)->where('coor_id',auth()->user()->coordinator_id)->where('unit_name', 'LIKE', '%' . $request->search . "%")->first();
      return  $unit;

    }
    public function searchunitteacher(Request $request)
    {

       $unit=Unit_analysis::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('year_id',$request->year)->where('term_id',$request->term)->where('teacher_id',$request->teacher_id)->where('unit_name', 'LIKE', '%' . $request->search . "%")->first();
      return  $unit;

    }
    public function unit_analysis($class_id,$lesson_id)
    {
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);

         $lesson_id=Lesson::find($lesson_id);


        return view('coordinators.coordinatore_unit_analysis',compact('term','coordinator','class_id','lesson_id','year'));

    }
    public function coordinator_table_exam($class_id,$lesson_id){


       $coordinator_id = Auth::user()->coordinator_id;
       $coordinator = Coordinator::find($coordinator_id);
       $class_id = Classe::find($class_id);

        $rooms =$class_id->room;
       $lesson_id = Lesson::find($lesson_id);
       $year = Year::where('current_year', '1')->first();
       $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();



       return  view('coordinators.coordinator_table_exam', compact( 'coordinator','rooms','lesson_id', 'class_id', 'year', 'term'));
   }
      public function coordinator_table_quize($class_id,$lesson_id){


       $coordinator_id = Auth::user()->coordinator_id;
       $coordinator = Coordinator::find($coordinator_id);
       $class_id = Classe::find($class_id);

        $rooms =$class_id->room;
       $lesson_id = Lesson::find($lesson_id);
       $year = Year::where('current_year', '1')->first();
       $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();



       return  view('coordinators.coordinator_table_quize', compact( 'coordinator','rooms','lesson_id', 'class_id', 'year', 'term'));
   }

   public function  quize_delete(Request $request){
    $file=Lesson_teacher_room_term_exam::find($request->id);
                 Exam_result::where('exam_id',$file->id)->delete();
                 if($file->type=='2'){
                    Storage::disk('public')->delete($file->quize);
                    $file->delete();

                }
                session()->flash('success', 'تم تعديل  بنجاح');
                return redirect()->back()->with('success', '! تمت العملية بنجاح');

   }
   public function exams_addquestion($exam_id,$room_id,$class_id,$lesson_id)
   {

    $coordinator_id = Auth::user()->coordinator_id;
    $coordinator = Coordinator::find($coordinator_id);
       $year = Year::where('current_year', '1')->first();
       $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
       $exam = Exams2::find($exam_id);
       $exams=Exams2::with('room')->where('groupe',$exam->groupe)->get();
        $questions = Question::where('class_id', $exam->class_id)->where('term_id', $term->id)->where('lesson_id', $exam->lesson_id)->where('coor_id',auth()->user()->coordinator_id)->get();
        return view('coordinators.coordinator_examquestion',
         compact('questions', 'exam', 'coordinator','room_id','exams','lesson_id','class_id'));
   }
    public function  quize_update(Request $request){
        if(!$request->room_id ){

            session()->flash('error1', 'تم تعديل  بنجاح');
            return redirect()->back()->with('error1', '! تمت العملية بنجاح');
        }
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

         foreach($request->room_id as $item){
        $exam = Exams2::find($item);




           if ($request->quize && $request->hasFile('quize')) {


                $exam->file = $request->quize->store('filesteachers', 'public');

                // $exam->extension =  $request->quize->extension();
            }

            $exam->save();}
            session()->flash('Add', 'تم تعديل  بنجاح');
            return redirect()->back()->with('Add', '! تمت العملية بنجاح');


    }
    public function coordinator_add_auto($class_id,$lesson_id){
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class = Classe::find($class_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $questions = Question::where('class_id', $class->id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('coor_id',auth()->user()->coordinator_id)->get();
        $sections = Section::where('class_id', $class->id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('coor_id',auth()->user()->coordinator_id)->get();

        $lesson=Lesson::find($lesson_id);
        return view('coordinators.coordinator_add_automated', compact('coordinator','class', 'lesson_id', 'lesson','questions', 'sections'));
    }
  

     public function coordinator_show_exam($class_id,$lesson_id,$room_id){
       $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $quizes =  Exams2::where('room_id', $room_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
        ->orderBy("id", 'desc')->where('type', '1')->where('is_file', 1)->get();

        $quize_auto =  Exams2::where('room_id', $room_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
        ->orderBy("id", 'desc')->where('type', '1')->where('is_file', 0)->get();
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $class_id = Classe::find($class_id);
        $lesson_id = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $room_id=Room::find($room_id);
        return  view('coordinators.coordinator_show_exam', compact('quize_auto','room_id', 'now','coordinator','quizes','lesson_id', 'class_id', 'year', 'term','quizes'));
    }
    public function coordinator_show_quize($class_id,$lesson_id,$room_id){
      $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $quizes =  Exams2::where('room_id', $room_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
        ->orderBy("id", 'desc')->where('type', '2')->where('is_file', 1)->get();

        $quize_auto =  Exams2::where('room_id', $room_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
        ->orderBy("id", 'desc')->where('type', '2')->where('is_file', 0)->get();
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $class_id = Classe::find($class_id);
        $lesson_id = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $room_id=Room::find($room_id);
        return  view('coordinators.coordinator_show_quize', compact('quize_auto','room_id', 'now','coordinator','quizes','lesson_id', 'class_id', 'year', 'term','quizes'));
    }
//     public function question_edit($id,$class_id,$lesson_id)
//     {

//         $questions = Question::where('id', $id)->first();
//         $class_id = $questions->class_id;
//         $classes = Classe::all();
//         $year = Year::where('current_year', '1')->first();
//         $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
//         $sections = Section::where('class_id', $class_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('coor_id',auth()->user()->coordinator_id)->get();
//         $item = Question::where('id', $id)->first();

//              $class = Classe::find($class_id);
//         return view('coordinators.edit-question.update_question', compact('questions','class', 'class_id', 'id', 'sections', 'item','lesson_id'));
//     }

//     public function question_update(Request $request, $question_id)
//     {
//         $year = Year::where('current_year', '1')->first();
//         $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

//         $question = question::find($question_id);
//         if ($request->ques_type == 2) {


//             if($request->question_form){
//                 $question->question_form = $request->question_form;
//             }
//             else{
//                 $question->question_form = $question->question_form;
//             }
//             if($request->answer){
//                 $question->answer = $request->answer;
//             }
//             else{
//                 $question->answer = $question->answer;
//             }

//             if($request->mark){
//                 $question->mark = $request->mark;
//             }
//             else{
//                 $question->mark = $question->mark;
//             }
//             $question->ques_type = $request->ques_type;

//             $question->class_id = $request->class_id;

//   $question->term_id = $term->id;
//              $question->lesson_id = $question->lesson_id;
//             $question->coor_id = auth()->user()->coordinator_id;

//             $question->note = $request->note;

//             $question->save();



//         } else {


//             if($request->question_form){
//                 $question->question_form = $request->question_form;
//             }
//             else{
//                 $question->question_form = $question->question_form;
//             }
//             if($request->answer){
//                 $question->answer = $request->answer;
//             }
//             else{
//                 $question->answer = $question->answer;
//             }

//             $question->ques_type = $request->ques_type;


//             $question->section_id = $request->section_id;
//               $question->term_id = $term->id;
//             $question->lesson_id = $question->lesson_id;
//             $question->coor_id = auth()->user()->coordinator_id;
//             if($request->mark){
//                 $question->mark = $request->mark;
//             }
//             else{
//                 $question->mark = $question->mark;
//             }


//             $question->note = $request->note;
//             $question->save();
//             // تقوم بجلب آخر ريكورد تم إضافته للداتا بيز
//             // $data = DB::select('select * from questions order by Created_at desc limit 1');

//             // dd($data[0]->id);
//             // $option = option::find($question->id);
//             $option = option::where('question_id', $question->id)->first();
//             $option->update([
//                 'question_id' => $question->id,
//                 'myOptions' => json_encode($request->option),
//             ]);
//         }
//         session()->flash('update', 'تم تعديل السؤال بنجاح');
//         return redirect()->back()->with('success', '! تمت العملية بنجاح');
//     }
   
    public function question_delete(Request $request)
    {

         $question = Question::find($request->question_id);
        if($question->option){
            $question->option->delete();
        }

        $question->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
//     public function question_store(Request $request)
//     {

//   $year = Year::where('current_year', '1')->first();
//         $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

//         if ($request->ques_type == "2") {


//             $question =  new  question();
//             $question->question_form = $request->question_form1;
//             $question->section_id = $request->section_id;
//             $question->answer = $request->answer;
//             $question->mark = $request->mark;
//             $question->note = $request->note;
//             $question->class_id = $request->class_id;
//             $question->ques_type = $request->ques_type;
//              $question->term_id = $term->id;

//             $question->lesson_id = $request->lesson_id;
//             $question->coor_id = auth()->user()->coordinator_id;
//             $question->save();

//             // dd($question);

//         } //نهاية السشرط لحالة السؤال التقليدي

//         // حالة السؤال متعدد الخيارات
//         else {

//             $options = new stdClass();

//             $validatedData = $request->validate([
//                 'question_form' => 'required',
//                 'answer' => 'required',
//                 'mark' => 'required',
//                 'class_id' => 'required',
//                 'ques_type' => 'required',
//                 'option' => 'required',

//             ], [
//                 'question_form.required' => 'يرجي ادخال صيغة السؤال',
//                 'answer.required' => 'يرجي ادخال إجابة السؤال',
//                 'mark.required' => 'يرجي ادخال علامة السؤال',

//                 'ques_type.required' => 'يرجي ادخال نوع السؤال',
//             ]);

//             $question =  new  question();
//             $question->question_form = $request->question_form;
//             $question->section_id = $request->section_id;
//             $question->answer = json_encode($request->answer);
//             $question->mark = $request->mark;
//             $question->class_id = $request->class_id;
//             $question->ques_type = $request->ques_type;
//               $question->term_id = $term->id;
//             $question->lesson_id = $request->lesson_id;
//             $question->coor_id = auth()->user()->coordinator_id;
//             $question->save();

//             // تقوم بجلب آخر ريكورد تم إضافته للداتا بيز
//             // $data = DB::select('select * from questions order by Created_at desc limit 1');

//             // dd($data[0]->id);

//             $option =  Option::create([
//                 'question_id' => $question->id,
//                 // 'myOptions' =>  json_encode($options)
//                 'myOptions' =>  json_encode($request->option),
//             ]);

//         }

//         session()->flash('Add', 'تم اضافة السؤال بنجاح ');
//       return redirect($request->back)->with('success', '! تمت العملية بنجاح ');
//     }

    public function store_items1(Request $request)

    {
          if($request->start_time > $request->end_time){

           session()->flash('error', 'يرجى تعديل الوقت');
            return redirect()->back()->with('error', '   يرجى تعديل الوقت   !! ');
      }
        if (  $request->name_quize == null &&  $request->quiz_link == null) {

            return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
         $classes=Classe::find($request->class_id);

            foreach($request->room_id  as $item1 ){

                $item = new Lesson_teacher_room_term_exam;
                $item->room_id = $item1;
                $item->coor_id =  auth()->user()->coordinator_id;
                $item->lesson_id = $request->lesson_id;
                $item->term_id = $request->term_id;
                $item->class_id = $request->class_id;

                $item->type = "2";
                if ($request->quize_link != null) {


                    $item->quiz_link = $request->quize_link;
                    $item->start_time = $request->quize_start_time;
                    $item->end_time = $request->quize_end_time;
                    $item->type_file =  '1';
                    if ($request->name_quize == null){
                        return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
                    }
                    $item->name_quize = $request->name_quize;
                }
                 elseif ($request->quize && $request->hasFile('quize')) {


                    $item->quize = $request->quize->store('filesteachers', 'public');
                    $item->start_time = $request->quize_start_time;
                    $item->end_time = $request->quize_end_time;
                    if ($request->name_quize == null){
                        return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
                    }
                    $item->name_quize = $request->name_quize;
                    $item->extension =  $request->quize->extension();
                }
                $item->save();
            }


        // else{
        //     $item = new Lesson_teacher_room_term_exam;
        //     $item->room_id = $request->room_id;
        //     $item->class_id = $request->class_id;
        //     $item->coor_id =  auth()->user()->coordinator_id;
        //     $item->lesson_id = $request->lesson_id;
        //     $item->term_id = $request->term_id;
        //     $item->type = "2";
        //     if ($request->quize_link != null) {


        //         $item->quiz_link = $request->quize_link;
        //         $item->start_time = $request->quize_start_time;
        //         $item->end_time = $request->quize_end_time;
        //         $item->type_file =  '1';
        //         if ($request->name_quize == null){
        //             return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //         }
        //         $item->name_quize = $request->name_quize;
        //     }
        //      elseif ($request->quize && $request->hasFile('quize')) {


        //         $item->quize = $request->quize->store('filesteachers', 'public');
        //         $item->start_time = $request->quize_start_time;
        //         $item->end_time = $request->quize_end_time;
        //         if ($request->name_quize == null){
        //             return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //         }
        //         $item->name_quize = $request->name_quize;
        //         $item->extension =  $request->quize->extension();
        //     }
        //     $item->save();
        // }



        session()->flash('success', 'تم تعديل  بنجاح');
        return redirect()->back()->with('success', '! تمت العملية بنجاح');


    }

    // public function add_questions($class_id, $lesson_id)
    // {
    //       $year = Year::where('current_year', '1')->first();
    //     $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
    //     $class = Classe::find($class_id);

    //     $classes = Classe::all();
    //   $questions = Question::where('class_id', $class_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();

    //     $sections = Section::where('class_id', $class->id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('coor_id',auth()->user()->coordinator_id)->get();
    //     $back=URL::previous();
    //     $coordinator_id = Auth::user()->coordinator_id;
    //     $coordinator = Coordinator::find($coordinator_id);
    //     return view('coordinators.edit-question.edit_question', compact('coordinator','class','back', 'classes', 'questions', 'sections','lesson_id'));
    // }

     public function quest_exam11($exam_id,$class_id,$lesson_id) {

        $exam = Lesson_teacher_room_term_exam::find($exam_id);

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

         $class=$exam->class;

            $year = Year::where('current_year', '1')->first()->name;

       return view('coordinators.coordinator_examfile',compact('selected_ques1','selected_ques','exam','class','room','term','lesson','class1','year'));
       }
       else{
              session()->flash('error', 'يرجى تعديل الوقت');
            return redirect()->back()->with('error', '   يرجى تعديل الوقت   !! ');
       }



}



    public function quest_exam($exam_id,$class_id,$lesson_id) {

        $exam = Exams2::find($exam_id);

        $exam = Exams2::find($exam_id);



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

       return view('coordinators.coordinator_examfile',compact('selected_ques1','selected_ques','exam','class','room','term','lesson','class1','year'));
       }
       else{
              session()->flash('error', 'يرجى تعديل الوقت');
            return redirect()->back()->with('error', '   يرجى تعديل الوقت   !! ');
       }



}
     public function search_exam(Request $request)
    {
    
        $exam1 = Exams2::find($request->exam);
        if ($exam1) {
            $questions = question::with('classes')->with('lecture')->where('accept',1)->where('class_id', $exam1->class_id)->where('lesson_id', $exam1->lesson_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        } else {
            $questions = question::with('classes')->with('lecture')->where('accept',1)->where('class_id', $request->exam)->where('lesson_id', $request->lesson_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        }

        if ($questions) {
            return $questions;
        } else return 1;

      
    }



    public function search(Request $request)
    {
      
         $class = Classe::find($request->exam);
        if ($class) {
          
            $questions = question::with('classes')->with('lecture')->where('class_id', $request->exam)->where('accept',1)->where('lesson_id', $request->lesson_id)->where('coordinator_id',auth()->user()->coordinator_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        }

        if ($questions) {
            return $questions;
        } else return 1;
    }
    //    public function detexam(Request $request)
    // {

    //      $exam = Exams2::with('room')->where('groupe',$request->groupe)->get();
    //      return $exam;

    // }

    public function myquestions(Request $request)
    {

        if ($request->selected_ques == null) {
            session()->flash('error', 'لم يتم وضع السؤال   ');
            return redirect()->back()->with('error', 'لم يتم اختيار أي سؤال !! ');
        };
        $selected_ques = $request->selected_ques1;

        $selected_ques = (object) $selected_ques; // convert the array to an object;;

        foreach($request->room_id as $item){
            $exam = Exams2::find($item);
            $exam->selected_ques = json_encode($selected_ques);
            $exam->save();
        }


        $studivs = array();
        foreach (json_decode($exam->selected_ques) as $x) {
            $studivs[] = $x;
        }
        session()->flash('success', 'تم وضع السؤال بنجاح   ');
        return redirect()->back()->with('success', '! تمت العملية بنجاح');

    }
    public function exams($class_id,$lesson_id )
    {
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
      $class = Classe::find($class_id);
        // $rooms = $class->room;
        $questions = question::where('class_id', $class_id)->get();


        $exams = Lesson_teacher_room_term_exam::where('type', '5')->where('lesson_id', $lesson_id)->where('class_id',$class_id)->where('coor_id', Auth::user()->coordinator_id)->where('term_id', $term->id)->get();
        $classes = Classe::all();
        $students = User::all();
        $lessons = $class->lessons;
         $lesson = Lesson::find($lesson_id);


        return view('coordinators.coordinator_testtable', compact('questions','coordinator', 'exams', 'classes', 'class','lesson', 'lessons','lesson_id'));
    }

    public function exam_delete(Request $request)
    {
        $id = $request->exam_id;
        Lesson_teacher_room_term_exam::find($id)->delete();
        Exam_result::where('exam_id', $request->exam_id)->delete();
        session()->flash('success', 'تم حذف  بنجاح');
        return redirect()->back()->with('success', 'تم حذف الامتحان بنجاح');
    }
    public function exam_update(Request $request)
    {
  if($request->start_time > $request->end_time){

           session()->flash('error', 'يرجى تعديل الوقت');
            return redirect()->back()->with('error', '   يرجى تعديل الوقت   !! ');
      }

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



            $exam->class_id = $exam->class_id;
            $exam->room_id = $exam->room_id;
            $exam->coor_id = auth()->user()->coordinator_id;

            $exam->name_quize = $request->name;

            $exam->lesson_id = $exam->lesson_id;
            $exam->success_mark = $request->success_mark;

            $exam->period = $request->period;
            $exam->start_time = $request->start_time;
            $exam->note = $request->note;
            $exam->term_id = $term->id;

            $exam->end_time = $request->end_time;
            $exam->type = '5';
            $exam->type_file = '2';

            $exam->save();


            Exam_result::where('exam_id', $request->exam_id)->delete();


            $studens = Room::find($exam->room_id)->student;

            foreach ($studens as $student) {


                $item2 = new Exam_result;
                $item2->class_id = $exam->class_id;
                $item2->room_id = $exam->room_id;
                $item2->exam_id = $exam->id;
                $item2->user_id = $student->id;
                $item2->type = '5';
                $item2->start_time = $request->start_time;

                $item2->end_time = $request->end_time;
                $item2->save();

        }

        $results = Exam_result::where('exam_id', $exam->id)->get();
        foreach ($results as $item) {
            $item->update([
                'class_id' => $request->class_id,

                'type' => $request->type,

            ]);
        }
 session()->flash('update', 'تم التعديل بنجاح      ');
        return redirect()->back()->with('update', 'تم تعديل الامتحان بنجاح ');
    }
    public function exam_store(Request $request)
    {
          if($request->start_time > $request->end_time){

           session()->flash('error', 'يرجى تعديل الوقت');
            return redirect()->back()->with('error', '   يرجى تعديل الوقت   !! ');
      }

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

         $exams = Lesson_teacher_room_term_exam::where('type', '5')->where('lesson_id',$request->lesson_id)->where('class_id',$request->class_id)->where('coor_id', Auth::user()->coordinator_id)->where('term_id', $term->id)->orderBy('id', 'desc')->first();

        $classes=Classe::find($request->class_id);
        foreach($request->room_id  as $item11 ){

        $item =  new Lesson_teacher_room_term_exam();
        if($exams){
            $item->key= $exams->key+1;

        }
        else{
            $item->key= '1';
        }

        $item->class_id = $request->class_id;
        $item->room_id = $item11;
        $item->coor_id = auth()->user()->coordinator_id;
        $item->name_quize = $request->name_exam;
        $item->lesson_id = $request->lesson_id;
        $item->success_mark = $request->success_mark;

        $item->period = $request->period;
        $item->start_time = $request->start_time;
        $item->note = $request->note;
        $item->term_id = $term->id;

        $item->end_time = $request->end_time;
        $item->type = '5';
        $item->type_file = '2';

        $item->save();

                    $studens = Room::find($item11)->student;
                    foreach ($studens as $student) {
                        $item2 = new Exam_result;
                        $item2->class_id = $request->class_id;
                        $item2->room_id = $item11;
                        $item2->exam_id = $item->id;
                        $item2->user_id = $student->id;
                        $item2->lesson_id = $request->lesson_id;
                        $item2->start_time = $request->start_time;
                        $item2->end_time = $request->end_time;
                        $item2->type ='5';

                        $item2->save();
                        }

                    }

        session()->flash('update', 'تم التعديل بنجاح      ');
        return redirect()->back()->with('update', 'تم التعديل بنجاح '    );
    }

    public function coordinator_quize($class_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $lesson_id = Lesson::find($lesson_id);
        $class_id = Classe::find($class_id);


        return  view('coordinators.coordinator_quize', compact( 'coordinator', 'lesson_id', 'class_id', 'year', 'term'));
    }

    public function coordinator_teacher_quize_mark($room_id,$class_id, $teacher_id, $lesson_id, $exam_id)
    {
         $class_id = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

        $students = $room->with('student.exams_files')->with('student.exam_result2')->get();

        $exam1 = Exams2::find($exam_id);
        $quize_result = Room::with(['student.exam_result2' => function ($q) {
            $q->where('id', '<>', null)->orderBy('type');
        }])->where('id', $room_id)->get();

        $exam_title = Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)
          ->orderBy('type')->get();
      if($exam1->type=='2'&& $exam1->is_file == '0'){
            $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
           return view('coordinators.coordinator_teacher_quize_mark1', compact('class_id','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }
       if($exam1->type=='2'&& $exam1->is_file == '1' ){
            $quize_result = Exam_result2::with('student' )->with('student.exams_files' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
           return view('coordinators.coordinator_teacher_quize_mark', compact('class_id','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }

    }
     public function coordinator_teacher_exam_mark($room_id,$class_id, $teacher_id, $lesson_id, $exam_id)
    {
         $class_id = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

        $students = $room->with('student.exams_files')->with('student.exam_result2')->get();

        $exam1 = Exams2::find($exam_id);
        $quize_result = Room::with(['student.exam_result2' => function ($q) {
            $q->where('id', '<>', null)->orderBy('type');
        }])->where('id', $room_id)->get();

        $exam_title = Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)
          ->orderBy('type')->get();
      if($exam1->type=='1'&& $exam1->is_file == '0'){
            $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
           return view('coordinators.coordinator_teacher_exam_mark1', compact('class_id','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }
       if($exam1->type=='1'&& $exam1->is_file == '1' ){
            $quize_result = Exam_result2::with('student' )->with('student.exams_files' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
           return view('coordinators.coordinator_teacher_exam_mark', compact('class_id','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
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
                  $students = Student:: with(['exams_files' => function ($query) use ($home) {
                    $query->where('exam_id', $home);
                }])->with('exam_result2')->

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

               $room = Room::where('id',$room_id)->first();
              $studen12t=[];
               $student12=[];
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


            //     $student12 = $room->with('student.exams_files')->with('student.exam_result2')->get();

            //   foreach( $student12 as $item ){
            //      if($item->id ==  $room_id){
            //           foreach( $item->student as $item1 ){


            //     $student123[]=$item1->id;

            // }
            //      }

            //      }

            //             $student123=  array_diff($student123,$student);






            // $students = Student:: with('exams_files')->with('exam_result2')->

            // whereIn("id",$student123)->get();

            //   $exam1 = Exams2::find($lec);
            //   $quize_result = Room::with(['student.exam_result2' => function ($q) {
            //       $q->where('id', '<>', null)->orderBy('type');
            //   }])->where('id', $room->id)->get();

            //         return  $students;

              }
         }
         else{
              
            $student=[];
	    $exam_id=Exams2::find($home);

         if($exam_id){

         $room_student=Room_student::where('room_id',$exam_id->room_id)->get();
  
     
                foreach( $room_student as $item1 ){
                $student[]=$item1->student_id;
            }
            $students = Student::with(['exams_files' => function ($query) use ($home) {
                     $query->where('exam_id', $home);
                  }])->with('exam_result2')->
               whereIn('id',$student)->get();

                    return  $students;

              }
         }




    }
   public function examstudent1($lec,$home,$room_id ,Request $request)
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
            $room_student=Room_student::where('room_id',$room->id)->get();

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
//     public function correct_exam1($exam_id, $student_id,$teacher_id)
//     {


//          $exam = Exams2::find($exam_id);
//          $student = Student::find($student_id);
//         $room=Room::find($exam->room_id);
//          $class_id=Room::find($exam->room_id)->class_id;
//          $class1=Classe::find($class_id);
//          $term= Term_year::find($exam->term_id)->term;
//         $lesson = Lesson::find($exam->lesson_id);
//         //  تخزين اسئلة الامتحان مع الاجابات
//        $teacher=Teacher::find($teacher_id);
//         $questions = [];
//         if ($exam->selected_ques) {
//             foreach (json_decode($exam->selected_ques, true) as $question_id) {

//        $questions[] = Question::with('option')->find($question_id);


//             }
//         }


//         $exam_result = Exam_result2::where('exam_id', $exam_id)->where('user_id', $student->id)->first();


//         $class = $exam->class;

//         $max_result = 0;

//         foreach ($questions as $item) {
//             if($item)
// {
//       $max_result = $max_result + $item->mark;
// }

//         }
//        $year = Year::where('current_year', '1')->first()->name;
//         // if ($exam_result->status == '0') {
//         //   return redirect()->back()->with('warning','لا يوجد امتحان ');
//         // }

//         return view('coordinators.coordinator_teacher_testfile', compact('student', 'teacher','max_result','exam_id','questions', 'exam', 'exam_result', 'class1','room','term','year','class','lesson'));
//     }




    public function coordinator_show_quize_room($class_id,$lesson_id,$room_id,$teacher_id){
         $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $quizes =  Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('term_id',$term->id)->where('class_id',$class_id)->where('is_file', 1)
       ->orderBy("id", 'desc')->where('type', '2')->get();
       $quize_auto =  Exams2::where('room_id', $room_id)->where('term_id',$term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
       ->orderBy("id", 'desc')->where('type', '2')->where('is_file', 0)->get();
       $coordinator_id = Auth::user()->coordinator_id;
       $coordinator = Coordinator::find($coordinator_id);
       $class_id = Classe::find($class_id);
       $lesson_id = Lesson::find($lesson_id);
       $year = Year::where('current_year', '1')->first();
       $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
       $date = new DateTime();
       $now = $date->format('Y-m-d H:i:s');
       $teacher = Teacher::find($teacher_id);
      $room=Room::find($room_id);
       return  view('coordinators.coordinator_show_quize_room', compact('room','teacher','quize_auto', 'now','coordinator','quizes','lesson_id', 'class_id', 'year', 'term','quizes'));
   }
     public function coordinator_show_eaxm_room($class_id,$lesson_id,$room_id,$teacher_id){
           $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $quizes =  Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('term_id',$term->id)->where('class_id',$class_id)->where('is_file', 1)
       ->orderBy("id", 'desc')->where('type', '1')->get();
       $quize_auto =  Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('term_id',$term->id)->where('class_id',$class_id)
       ->orderBy("id", 'desc')->where('type', '1')->where('is_file', 0)->get();
       $coordinator_id = Auth::user()->coordinator_id;
       $coordinator = Coordinator::find($coordinator_id);
       $class_id = Classe::find($class_id);
       $lesson_id = Lesson::find($lesson_id);
       $year = Year::where('current_year', '1')->first();
       $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
       $date = new DateTime();
       $now = $date->format('Y-m-d H:i:s');
       $teacher = Teacher::find($teacher_id);
      $room=Room::find($room_id);
       return  view('coordinators.coordinator_show_eaxm_room', compact('room','teacher','quize_auto', 'now','coordinator','quizes','lesson_id', 'class_id', 'year', 'term','quizes'));
   }

   public function coordinator_tacher_room_mark($class_id,$lesson_id,$teacher_id){


        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $class_id = Classe::find($class_id);

         $rooms =$class_id->room;
         $teacher=Teacher::find($teacher_id);
          $r=[];
         $room = Teacher_room_lesson ::where('class_id',$class_id->id)->where('teacher_id',$teacher_id)->get();
         foreach($room as $item ){
          $r[]=   $item->room_id;

         }
         $rooms=Room::whereIn('id',$r)->get();
        $lesson_id = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();



        return  view('coordinators.coordinator_tacher_room_mark', compact( 'teacher','coordinator','rooms','lesson_id', 'class_id', 'year', 'term'));
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
            $students = $students->student()->where('students.lang', '1')->orderBy('first_name')->get();
        } elseif ($lesson->lang == '0') {

            $students = $students->student()->where('students.lang', '0')->orderBy('first_name')->get();
        } elseif ($lesson->religion == '1') {
            $students = $students->student()->where('students.religion', '1')->orderBy('first_name')->get();
        } elseif ($lesson->religion == '0') {

            $students = $students->student()->where('students.religion', '0')->orderBy('first_name')->get();
        } else {

            $students = $students->student()->orderBy('first_name')->get();
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
          $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        if($class->stage_id ==1){
            return view('coordinators.teacher_total_pdf', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
        elseif($class->stage_id ==2){
             return view('coordinators.teacher_total1_pdf', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
          elseif($class->stage_id ==3){
             return view('coordinators.teacher_total2_pdf', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
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

        if ($lesson->lang == '1') {
            $students = $students->student()->where('students.lang', '1')->orderBy('first_name')->get();
        } elseif ($lesson->lang == '0') {

            $students = $students->student()->where('students.lang', '0')->orderBy('first_name')->get();
        } elseif ($lesson->religion == '1') {
            $students = $students->student()->where('students.religion', '1')->orderBy('first_name')->get();
        } elseif ($lesson->religion == '0') {

            $students = $students->student()->where('students.religion', '0')->orderBy('first_name')->get();
        } else {

            $students = $students->student()->orderBy('first_name')->get();
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
              $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        if($class->stage_id ==1){
            return view('coordinators.teacher_total_excel', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
        elseif($class->stage_id ==2){
             return view('coordinators.teacher_total_excel1', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
          elseif($class->stage_id ==3){
             return view('coordinators.teacher_total2_excel1', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }


    }
    public function coordinator_tacher_room($class_id,$lesson_id,$teacher_id){


        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $class_id = Classe::find($class_id);

         $rooms =$class_id->room;
         $teacher=Teacher::find($teacher_id);
         $r=[];
         $room = Teacher_room_lesson ::where('class_id',$class_id->id)->where('teacher_id',$teacher_id)->get();
         foreach($room as $item ){
          $r[]=   $item->room_id;

         }
         $rooms=Room::whereIn('id',$r)->get();
        $lesson_id = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();



        return  view('coordinators.coordinator_tacher_room', compact( 'teacher','coordinator','rooms','lesson_id', 'class_id', 'year', 'term'));
    }
      public function coordinator_tacher_room1($class_id,$lesson_id,$teacher_id){


        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        $class_id = Classe::find($class_id);

         $rooms =$class_id->room;
         $teacher=Teacher::find($teacher_id);
          $r=[];
         $room = Teacher_room_lesson ::where('class_id',$class_id->id)->where('teacher_id',$teacher_id)->get();
         foreach($room as $item ){
          $r[]=   $item->room_id;

         }
         $rooms=Room::whereIn('id',$r)->get();

        $lesson_id = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();



        return  view('coordinators.coordinator_tacher_room1', compact( 'teacher','coordinator','rooms','lesson_id', 'class_id', 'year', 'term'));
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

// صفحة الاسئلة 
public function teacher_question($lesson_id, $room_id )
    {
        $teacher=[];
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $room = Room::find($room_id);
         $lesson = Lesson::find($lesson_id);
        $class = Classe::find($room->class_id);
        $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
          $rooms = Teacher_room_lesson ::where('class_id',$class->id)->where('room_id',$room->id)->orderBy('id', 'DESC')->get();
         foreach($rooms as $item ){
          $teacher[]=   $item->teacher_id;

         }
        
        $questions = Question::where('class_id', $class->id)->where('accept', 0)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->whereIn('teacher_id',$teacher)->get();
        $results = []; 
         foreach ($questions as $question) {
         $options = Option::where('question_id', $question->id)->get();
         $results[$question->id] = $options;
          }
        $questions_accept = Question::where('class_id', $class->id)->where('accept', 1)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->whereIn('teacher_id',$teacher)->get();
          //return $results; 
        return view('school_controller.teacher_question',
        
        compact('class','lesson' ,'lesson_id', 'room_id','room','questions','coordinator','questions_accept'));
    }
    
     public function accept_question ( $question_id)
    {
        $question = Question::find($question_id);
        $question->accept=1;
        $question->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
    
    




       public function coordinator_teacher_schedule($teacher_id,$class_id,$lesson_id)
    {
         $year=Year::where('current_year','1')->first();
          $coordinator_id = Auth::user()->coordinator_id;
        $coordinator = Coordinator::find($coordinator_id);
        // return $student_id ;
        $user_id = auth()->user()->id ;
        // $teacher_id = auth()->user()->teacher_id ;
       $teacher = Teacher::find($teacher_id);
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);


        // $room = Room::findOrFail($room_id);
        // $lessons = $room->lessons2 ;
        // pring teachers

        // pring lecture_tims
        $lecture_times = Lecture_time::where('class_id',$class_id);
          // pring days
        $days = Day::all();
        // pring teacher schedule
        $schedule = Lesson_room_teacher_lecture_time::with('lesson','lecture_time')
          ->WhereHas('room' ,function($q) use ($year){
            $q->where('year_id',$year->id);
        })
        ->with(['room.classes' => function($query){
            $query->select("id","name");
        }])
         ->join('lecture_times', 'lecture_times.id', '=', 'lesson_room_teacher_lecture_time.lecture_time_id')
        ->orderBy('lecture_times.start_time')
        ->select("lesson_room_teacher_lecture_time.*")
        ->where('teacher_id',$teacher_id)
        ->where('lesson_id',$lesson_id)->get();

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
                // $hourMin = date('H:i');
                $hourMin = \Carbon\Carbon::parse(date('H:i') );
                $hourMin = $hourMin->addMinute(60)->format("H:i");
                if ( $hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time){
                    $today_lecture->inter = true;
                     $minutes = $now->diffInMinutes($lecture_time->end_time) ;
                }else{
                    $today_lecture->inter = false;
                }

        }

        $now=Carbon::now();

        return view('coordinators.coordinator_teacher_schedule',compact('coordinator','teacher','now','teacher_id','lecture_times','days','schedule','today','minutes'));
    }
  public function send_notification($Title, $Body,$id,$type,$room_id,$lesson_id,$lecture_id, $devices, $FCM_API_KEY = null)
    {
         if ($FCM_API_KEY == null) {
            $FCM_API_KEY = "AAAAuYJFfCU:APA91bEw50FxiBcHkaJpz5zlu5toR10xNjAmXWxoAmX9WjFsP2f7hwuJDpmpADyz-MzNyEawjWuwDEgYQOHEiCq6yfaU1XuNba7uHG3sJtaw8Rx3TqqN4eJgbMOF3IuzPK7MFk9NpO6J";
        }

        $API_ACCESS_KEY= $FCM_API_KEY;
        //   $registrationIds = ;
        #prep the bundle
        $msg = array
        (
            'body' 	=> $Body,
            'title'	=> $Title,
            'id'	=> $id,
            'type'	=> $type,
            'room_id'=> $room_id,
            'lesson_id'	=> $lesson_id,
            'lecture_id'=> $lecture_id,


        );

        $fields = array
        (
            'registration_ids'	=> $devices,
            'notification'	=> $msg,
         );

        $headers = array
        (
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

        $result = curl_exec($ch );
          curl_close( $ch );

    }

}
