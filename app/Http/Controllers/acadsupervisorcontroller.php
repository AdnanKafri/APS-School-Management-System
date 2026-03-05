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
use App\Acadsupervisor_class;
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
use App\Acadsupervisor;
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

class acadsupervisorcontroller extends Controller
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
    
    
    public function chat()
    {
        // return $student_id ;
        $user_id = auth()->user()->id ;
        $teacher_id = auth()->user()->acadsupervisor_id ;
       $teacher = Acadsupervisor::find($teacher_id);
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

        return view('acadsupervisors.chat',compact('teacher','now','teacher_id','days','today','minutes'));
    }
    
    
    
       public function profile()
    {
       $coordinator_id = Auth::user()->acadsupervisor_id;
        $year = Year::where('current_year', '1')->first();
          $coordinator = Acadsupervisor::find($coordinator_id);
        return  view('acadsupervisors.index',compact('coordinator'));
    }
    
   public function update_profile_coor(Request $request, $coordinator_id)
    {


         $coordinator = Acadsupervisor::find($coordinator_id);

        if ($request->image != null) {
            Storage::disk('public')->delete($coordinator->image);
            $coordinator->image = $request->image->store('filesteachers', 'public');
        }


        $coordinator->save();
        $user = User::where('acadsupervisor_id',$coordinator_id)->first();
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

    public function dashboard_acadsupervisors()
    {
        
          $cor_clas1=[];
          $acadsupervisor_id = Auth::user()->acadsupervisor_id;
   

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $coordinator = Acadsupervisor::find($acadsupervisor_id);

        $cor_clas= Acadsupervisor_class::where('supervisor_id',$coordinator->id)->get();
        foreach($cor_clas as $item){

           $cor_clas1[]=$item->class_id;
        }
         $classes=Classe::with('room')->whereIn('id',$cor_clas1)->get();


        return view('acadsupervisors.acadsupervisor_index', compact('coordinator', 'classes'));
    }
    
    public function acadsupervisor_subject($room_id)
    {

          $cor_lesson1=[];
        $acadsupervisor_id = Auth::user()->acadsupervisor_id;


        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $coordinator = Acadsupervisor::find($acadsupervisor_id);
         $room=Room::find($room_id);
          $t_lesson=Teacher_room_lesson::with('teachers')->with('lesson')->where('room_id',$room->id)->get();

        

         $classes=Classe::find($room->class_id);
      


 
        return view('acadsupervisors.acadsupervisor_subject', compact('coordinator','room', 'classes','t_lesson'));
    }
       
    public function acadsupervisor_teacher($room_id,$teacher_id,$lesson_id)
    {

          $cor_lesson1=[];
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $teacher = Teacher::find($teacher_id);

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $coordinator = Acadsupervisor::find($coordinator_id);

         $room=Room::find($room_id);

         $classes=Classe::find($room->class_id);


         $lesson=Lesson::where('id',$lesson_id)->first();

        return view('acadsupervisors.acadsupervisor_teacher', compact('teacher','coordinator', 'classes','room','lesson'));
    }
     public function acadsupervisor_teacher_lesson($room_id,$teacher_id,$lesson_id)
    {
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

          $cor_lesson1=[];
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $teacher = Teacher::find($teacher_id);

       
         $coordinator = Acadsupervisor::find($coordinator_id);

         $room=Room::find($room_id);

         $classes=Classe::find($room->class_id);


         $lesson=Lesson::where('id',$lesson_id)->first();
         $lectures = $lesson->lectures()->where('active', 0)->where('teacher_id', $teacher_id)->where('term_id', $term->id)->where('room_id', $room->id)->get();

        return view('acadsupervisors.acadsupervisor_teacher_lesson', compact('teacher','coordinator', 'room','classes','lesson','lectures'));
    }
    
       public function acadsupervisor_show($lesson_id, $teacher_id, $room_id, $lecture_id)

    {
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
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
        return view('acadsupervisors.acadsupervisor_show', compact(
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
    
    public function acadsupervisor_quest_exam($exam_id,$class_id,$lesson_id) {

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

       return view('acadsupervisors.acadsupervisor_examfile',compact('selected_ques1','selected_ques','exam','class','room','term','lesson','class1','year'));
       }
       else{
              session()->flash('error', 'يرجى تعديل الوقت');
            return redirect()->back()->with('error', '   يرجى تعديل الوقت   !! ');
       }



}
    
     public function prepare (Request $request,$room_id,$class_id,$lesson_id,$teacher_id)
    {
        $room =Room::find($room_id);
         $lesson=Lesson::where('id',$lesson_id)->first();
          $classes=Classe::find($class_id);
        $teacher=Teacher::find($teacher_id);
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
                $lesson_id=Lesson::find($lesson_id);
                
        if($lesson_id->is_english==1){
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

            $class_id= Classe::find($class_id);
            
            $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

            if ($request->ajax()) {

                $class_id= Classe::find($class_id);

                $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

                return view('acadsupervisors.load_en')->withprepare($prepare)->withclass_id($class_id)->withlesson_id($lesson_id);

            }
             $means= Means::where('lang',2)->get();
             $road= Road::where('lang',2)->get();
            return  view('acadsupervisors.coordinator_teacher_prepare_en', compact('room','means','road','lesson','classes','teacher','prepare','coordinator','lesson_id','class_id','year','term'));

        }
        if($lesson_id->lang==0 && $lesson_id->lang !=null ){
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

            $class_id= Classe::find($class_id);
            $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

            if ($request->ajax()) {

                $class_id= Classe::find($class_id);

                $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

                return view('acadsupervisors.load_fr')->withprepare($prepare)->withclass_id($class_id)->withlesson_id($lesson_id);

            }
            return  view('acadsupervisors.coordinator_teacher_prepare_fr', compact('room','lesson','classes','teacher','prepare','coordinator','lesson_id','class_id','year','term'));

        }
        else{

            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
            $class_id= Classe::find($class_id);
            $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

            if ($request->ajax()) {

                $class_id= Classe::find($class_id);

                $prepare=Prepare::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->orderBy('id', 'ASC')->paginate(1);

                return view('acadsupervisors.load')->withprepare($prepare)->withclass_id($class_id)->withlesson_id($lesson_id);

            }
             $means= Means::where('lang',1)->get();
             $road= Road::where('lang',1)->get();
            return  view('acadsupervisors.coordinator_teacher_prepare', compact('room','means','road','lesson','classes','teacher','prepare','coordinator','lesson_id','class_id','year','term'));

        }

    }
    
      public function showclass($lesson_id, $teacher_id, $room_id)
    {
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
       
        $room=Room::find($room_id);
        $classes = Classe::find($room->class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        // $coordinator_id = Auth::user()->acadsupervisor_id;
        // $coordinator = Acadsupervisor::find($coordinator_id);
        $teacher = Teacher::find($teacher_id);
        $evaluation = Evaluation::where('lesson_id', $lesson_id)->where('term',$term->id)->where('acad_id', Auth::user()->acadsupervisor_id)->where('teacher_id',$teacher_id)->where('class_id', $classes->id)->orderBy('id', 'Asc')->paginate(1);
        return view('acadsupervisors.acadsupervisors_showclass', compact('room','evaluation', 'teacher', 'classes', 'lesson', 'year'));
    }
    
     public function searchdate(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($request->lesson_id);
        $teacher = Teacher::find($request->teacher_id);
        $classes = Classe::find($request->class_id);



        $evaluation = Evaluation::where('lesson_id', $lesson->id)->where('teacher_id', $teacher->id)->where('term',$term->id)->where('acad_id', Auth::user()->acadsupervisor_id)->where('class_id', $classes->id)->where('date', $request->search)->orderBy('id', 'Asc')->paginate(1);
        return view('acadsupervisors.evaluation', compact('evaluation', 'teacher', 'classes', 'lesson'));
    }
    
       public function pdf($lesson_id, $teacher_id, $class_id, $id)
    {
        $classes = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $teacher = Teacher::find($teacher_id);
        $item = Evaluation::find($id);
     
        return view('acadsupervisors.d_cor_ev_p', compact('item', 'coordinator', 'teacher', 'classes', 'lesson', 'year'));
    }
    public function all_pdf($lesson_id, $teacher_id, $class_id)
    {
        $classes = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $teacher = Teacher::find($teacher_id);
        $evaluation = Evaluation::where('lesson_id', $lesson->id)->where('term',$term->id)->where('teacher_id', $teacher->id)->where('class_id', $classes->id)->orderBy('id', 'Asc')->where('acad_id', Auth::user()->acadsupervisor_id)->get();
          
        return view('acadsupervisors.all_d_cor_ev_p', compact('evaluation', 'coordinator', 'teacher', 'classes', 'lesson', 'year'));
    }


   
    public function pdfdownload1($id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $prepare=Prepare::find($id);
        
        $class_id= Classe::find($prepare->class_id);

        $lesson_id=Lesson::find($prepare->lesson_id);
        if($lesson_id->is_english==1){
             $means= Means::where('lang',2)->get();
            $road= Road::where('lang',2)->get();
            return view('acadsupervisors.ll_en',compact('means','road','prepare','lesson_id','class_id'));
        }
        elseif($lesson_id->lang==0 && $lesson_id->lang !=null  ){
            return view('acadsupervisors.ll_fr',compact('prepare','lesson_id','class_id'));
        }
        else{
             $means= Means::where('lang',1)->get();
            $road= Road::where('lang',1)->get();
            return view('acadsupervisors.ll',compact('means','road','prepare','lesson_id','class_id'));
        }


    }
    public function multipdfdownload1($id,$teacher_id)
    {
          $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $prepare=Prepare::find($id);
        $lesson_id=Lesson::find($prepare->lesson_id);
        $class_id= Classe::find($prepare->class_id);
        $prepares=Prepare::where('class_id',$class_id->id)->where('term_id',$term->id)->where('lesson_id',$lesson_id->id)->where('teacher_id',$teacher_id)->get();
      if( $lesson_id->is_english==1){
           $means= Means::where('lang',2)->get();
            $road= Road::where('lang',2)->get();
        return view('acadsupervisors.allbook_en',compact('means','road','prepares','lesson_id','class_id'));
      }
      elseif($lesson_id->lang==0 && $lesson_id->lang !=null ){
        return view('acadsupervisors.allbook_fr',compact('prepares','lesson_id','class_id'));
      }

      else{
           $means= Means::where('lang',1)->get();
            $road= Road::where('lang',1)->get();
        return view('acadsupervisors.allbook',compact('means','road','prepares','lesson_id','class_id'));
      }


    }
    public function acadsupervisor_show_quize($class_id,$lesson_id,$room_id,$teacher){
    
    $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $quizes =  Exams2::where('room_id', $room_id)->where('term_id',$term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
        ->orderBy("id", 'desc')->where('type', '2')->where('is_file', 1)->get();
        	$teacher = Teacher::find($teacher);
        $quize_auto =  Exams2::where('room_id', $room_id)->where('term_id',$term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
        ->orderBy("id", 'desc')->where('type', '2')->where('is_file', 0)->get();
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $classes  = Classe::find($class_id);
        $lesson = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
       
        $room=Room::find($room_id);
        return  view('acadsupervisors.coordinator_show_quize', compact('teacher','room','quize_auto', 'now','coordinator','quizes','lesson', 'classes', 'year', 'term','quizes'));
    }
    
     public function acadsupervisor_teacher_quize_mark($room_id,$class_id, $teacher_id, $lesson_id, $exam_id)
    {
         $classes = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

         $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
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
           return view('acadsupervisors.coordinator_teacher_quize_mark1', compact('classes','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }
       if($exam1->type=='2'&& $exam1->is_file == '1' ){
            $quize_result = Exam_result2::with('student' )->with('student.exams_files' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
           return view('acadsupervisors.coordinator_teacher_quize_mark', compact('classes','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }

    }

      public function acadsupervisor_quest_exam_quize($exam_id,$class_id,$lesson_id,$teacher) {
    	$teacher = Teacher::find($teacher);
        $exam = Exams2::find($exam_id);

        $exam = Exams2::find($exam_id);



        $room=Room::find($exam->room_id);
         $class_id=Room::find($exam->room_id)->class_id;
         $class1=Classe::find($class_id)->name;
         $term= Term_year::find($exam->term_id)->term;
        $lesson = Lesson::find($exam->lesson_id);
        $selected_ques = $exam->selected_ques;
        $classes  = Classe::find($room->class_id);
       $selected_ques = json_decode($selected_ques);


     $selected_ques1=[];
               
           if($selected_ques != null){
       foreach ($selected_ques as $x) { 

          $selected_ques1[] = Question::where('id', $x)->with('option')->orderBy('section_id')->get();
       };
         $class=$exam->class;

            $year = Year::where('current_year', '1')->first()->name;

       return view('acadsupervisors.acadsupervisor_quest_exam_quize',compact('selected_ques1','classes','teacher','selected_ques','exam','class','room','term','lesson','class1','year'));
       }
       else{
              session()->flash('error', 'يرجى تعديل الوقت');
            return redirect()->back()->with('error', '   يرجى تعديل الوقت   !! ');
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

               $exam1 = Exams2::find($lec);
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
    
      public function acadsupervisor_show_exam_room($class_id,$lesson_id,$room_id,$teacher){
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $quizes =  Exams2::where('room_id', $room_id)->where('term_id',$term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
        ->orderBy("id", 'desc')->where('type', '1')->where('is_file', 1)->get();
        		$teacher = Teacher::find($teacher);
        $quize_auto =  Exams2::where('room_id', $room_id)->where('term_id',$term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
        ->orderBy("id", 'desc')->where('type', '1')->where('is_file', 0)->get();
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $classes = Classe::find($class_id);
        $lesson = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $room=Room::find($room_id);
        return  view('acadsupervisors.coordinator_show_exam', compact('teacher','quize_auto','room', 'now','coordinator','quizes','lesson', 'classes', 'year', 'term','quizes'));
    }
    
    
       public function acadsupervisor_teacher_exam_mark($room_id,$class_id, $teacher_id, $lesson_id, $exam_id)
    {
           $classes = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
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
           return view('acadsupervisors.coordinator_teacher_exam_mark1', compact('classes','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }
       if($exam1->type=='1'&& $exam1->is_file == '1' ){
            $quize_result = Exam_result2::with('student' )->with('student.exams_files' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
           return view('acadsupervisors.coordinator_teacher_exam_mark', compact('classes','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
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
    return view('acadsupervisors.load_en',compact('means','road','prepare','teacher','class_id','lesson_id','term'));
}
elseif($lesson_id->lang==0 && $lesson_id->lang !=null ){
    
    $prepare=Prepare::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('term_id',$request->term)->where('teacher_id',$request->teacher_id)->where('lecture', 'LIKE', '%' . $request->search . "%")->paginate(1);
    return view('acadsupervisors.load_fr',compact('prepare','teacher','class_id','lesson_id','term'));
}



else{
    $means= Means::where('lang',1)->get();
    $road= Road::where('lang',1)->get();
    $prepare=Prepare::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('term_id',$request->term)->where('teacher_id',$request->teacher_id)->where('lecture', 'LIKE', '%' . $request->search . "%")->paginate(1);
    return view('acadsupervisors.load',compact('means','road','prepare','class_id','teacher','lesson_id','term'));
}

}

    public function StudentsRoomLessontotal($room_id, $teacher_id, $lesson_id)
    {
       
        $year = Year::where('current_year', '1')->first();

        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);
       
        // $class_id=Classe::find($room->class_id);
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
          $class_id=Classe::find($class_id);
         
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        if($class->stage_id ==1){
            return view('acadsupervisors.teacher_total', compact('class_id','room','students', 'teacher', 'lesson_id', 'room_id', 'count', 'count2','lesson','coordinator')); 
        }
        elseif($class->stage_id ==2){
             return view('acadsupervisors.teacher_total1', compact('class_id','room','students', 'teacher', 'lesson_id', 'room_id', 'count', 'count2','lesson','coordinator')); 
        }
          elseif($class->stage_id ==3){
             return view('acadsupervisors.teacher_total2', compact('class_id','room','students', 'teacher', 'lesson_id', 'room_id', 'count', 'count2','lesson','coordinator')); 
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
          $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        if($class->stage_id ==1){
            return view('acadsupervisors.teacher_total_pdf', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson')); 
        }
        elseif($class->stage_id ==2){
             return view('acadsupervisors.teacher_total1_pdf', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson')); 
        }
          elseif($class->stage_id ==3){
             return view('acadsupervisors.teacher_total2_pdf', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson')); 
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
              $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        if($class->stage_id ==1){
            return view('acadsupervisors.teacher_total_excel', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson')); 
        }
        elseif($class->stage_id ==2){
             return view('acadsupervisors.teacher_total_excel1', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson')); 
        }
          elseif($class->stage_id ==3){
             return view('acadsupervisors.teacher_total2_excel1', compact('coordinator','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson')); 
        }
      
       
    }


 
      public function acadsupervisor_teacher_plan($room_id,$lesson_id,$teacher_id)
    {
        $room=Room::find($room_id);
        $classes=Classe::find($room->class_id);
        
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $lesson=Lesson::where('id',$lesson_id)->first();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        


       
  $teacher=Teacher::find($teacher_id);
         $lesson_id=Lesson::find($lesson_id);
           $lesson=Lesson::where('id',$lesson_id->id)->first();
          $planification_trimestrielle=Planification_trimestrielle::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$classes->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();


        return view('acadsupervisors.coordinator_teacher_plan',compact('room','teacher','planification_trimestrielle','term','classes','lesson','coordinator','lesson_id','lesson','classes','year'));

    }

    
       public function planification($class_id,$lesson_id)
    {
        $classes=Classe::find($class_id);
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $lesson=Lesson::where('id',$lesson_id)->first();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $classes=Classe::find($class_id->id);


       

         $lesson_id=Lesson::find($lesson_id);
           $lesson=Lesson::where('id',$lesson_id->id)->first();
          $planification_trimestrielle=Planification_trimestrielle::where('coor_id',auth()->user()->acadsupervisor_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();


        return view('acadsupervisors.coordinatore_planification',compact('planification_trimestrielle','term','classes','lesson','coordinator','class_id','lesson_id','lesson','classes','year'));

    }
     public function teacher_planification($class_id,$lesson_id,$teacher_id)
    {
        $classes=Classe::find($class_id);
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $lesson=Lesson::where('id',$lesson_id)->first();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class_id= Classe::find($class_id);
        $classes=Classe::find($class_id->id);

 
       
  $teacher=Teacher::find($teacher_id);
         $lesson_id=Lesson::find($lesson_id);
           $lesson=Lesson::where('id',$lesson_id->id)->first();
          $planification_trimestrielle=Planification_trimestrielle::where('teacher_id',$teacher_id)->where('term_id',$term->id)->where('class_id',$class_id->id)->where('lesson_id',$lesson_id->id)->where('year_id',$year->id )->first();


        return view('acadsupervisors.teacher_planification',compact('teacher','planification_trimestrielle','term','classes','lesson','coordinator','class_id','lesson_id','lesson','classes','year'));

    }
     public function acadsupervisor_teacher_showunit($room_id,$lesson_id,$teacher_id)
    {
          $teacher=Teacher::find($teacher_id);
          $room= Room::find($room_id);
            $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $classes= Classe::find($room->class_id);
       
         $lesson=Lesson::find($lesson_id);
         
        $unit=Unit_analysis::where('class_id',$classes->id)->where('lesson_id',$lesson->id)->where('year_id',$year->id)->where('term_id',$term->id)->where('teacher_id',$teacher_id)->paginate(1);
 if($unit->isEmpty()){
                     session()->flash('error', 'تحليل الوحدة فارغ    ');
                return redirect()->back()->with('error', '! تحليل الوحدة فارغ   ');



 }
           return view('acadsupervisors.coordinator_teacher_showunit',compact('room','teacher','term','coordinator','classes','lesson','year','unit'));

    }

    public function searchunit(Request $request)
    {


       $unit=Unit_analysis::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('year_id',$request->year)->where('term_id',$request->term)->where('coor_id',auth()->user()->acadsupervisor_id)->where('unit_name', 'LIKE', '%' . $request->search . "%")->first();
      return  $unit;

    }
    public function searchunitteacher(Request $request)
    {

       $unit=Unit_analysis::where('class_id',$request->class_id)->where('lesson_id',$request->lesson_id)->where('year_id',$request->year)->where('term_id',$request->term)->where('teacher_id',$request->teacher_id)->where('unit_name', 'LIKE', '%' . $request->search . "%")->first();
      return  $unit;

    }

    public function search(Request $request)
    {

        $exam1 = Exams2::find($request->exam);
        if ($exam1) {
            $questions = question::with('classes')->where('class_id', $exam1->class_id)->where('lesson_id', $exam1->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        } else {
     $questions = question::with('classes')->where('class_id', $request->exam)->where('lesson_id', $request->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        }

        if ($questions) {
            return $questions;
        } else return 1;
    }
       public function detexam(Request $request)
    {
        
         $exam = Exams2::with('room')->where('groupe',$request->groupe)->get();
         return $exam;
         
    }

    public function myquestions(Request $request)
    {    

        if ($request->selected_ques == null) {
            session()->flash('error', 'لم يتم وضع السؤال   ');
            return redirect()->back()->with('error', 'لم يتم اختيار أي سؤال !! ');
        };
        $selected_ques = $request->selected_ques;

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
 
    
   
     public function coordinator_teacher_exam_mark($room_id,$class_id, $teacher_id, $lesson_id, $exam_id)
    {
         $class_id = Classe::find($class_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
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
           return view('acadsupervisors.coordinator_teacher_exam_mark1', compact('class_id','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }
       if($exam1->type=='1'&& $exam1->is_file == '1' ){
            $quize_result = Exam_result2::with('student' )->with('student.exams_files' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
           return view('acadsupervisors.coordinator_teacher_exam_mark', compact('class_id','coordinator','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }

    }
   
   
    public function correct_exam1($exam_id, $student_id,$teacher_id)
    {


         $exam = Exams2::find($exam_id);
         $student = Student::find($student_id);
        $room=Room::find($exam->room_id);
         $class_id=Room::find($exam->room_id)->class_id;
         $class1=Classe::find($class_id);
         $term= Term_year::find($exam->term_id)->term;
        $lesson = Lesson::find($exam->lesson_id);
        //  تخزين اسئلة الامتحان مع الاجابات
       $teacher=Teacher::find($teacher_id);
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
}

        }
$year = Year::where('current_year', '1')->first()->name;
        // if ($exam_result->status == '0') {
        //   return redirect()->back()->with('warning','لا يوجد امتحان ');
        // }
        
        return view('acadsupervisors.coordinator_teacher_testfile', compact('student', 'teacher','max_result','exam_id','questions', 'exam', 'exam_result', 'class1','room','term','year','class','lesson'));
    }




   
     public function coordinator_show_eaxm_room($class_id,$lesson_id,$room_id,$teacher_id){
          $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $quizes =  Exams2::where('room_id', $room_id)->where('term_id',$term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)->where('is_file', 1)
       ->orderBy("id", 'desc')->where('type', '1')->get();
       $quize_auto =  Exams2::where('room_id', $room_id)->where('term_id',$term->id)->where('lesson_id', $lesson_id)->where('class_id',$class_id)
       ->orderBy("id", 'desc')->where('type', '1')->where('is_file', 0)->get();
       $coordinator_id = Auth::user()->acadsupervisor_id;
       $coordinator = Acadsupervisor::find($coordinator_id);
       $class_id = Classe::find($class_id);
       $lesson_id = Lesson::find($lesson_id);
       $year = Year::where('current_year', '1')->first();
       $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
       $date = new DateTime();
       $now = $date->format('Y-m-d H:i:s');
       $teacher = Teacher::find($teacher_id);
      $room=Room::find($room_id);
       return  view('acadsupervisors.coordinator_show_eaxm_room', compact('room','teacher','quize_auto', 'now','coordinator','quizes','lesson_id', 'class_id', 'year', 'term','quizes'));
   }
   
   public function coordinator_tacher_room_mark($class_id,$lesson_id,$teacher_id){


        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $class_id = Classe::find($class_id);

         $rooms =$class_id->room;
         $teacher=Teacher::find($teacher_id);
         $rooms = $teacher->rooms->unique();
        $lesson_id = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();



        return  view('acadsupervisors.coordinator_tacher_room_mark', compact( 'teacher','coordinator','rooms','lesson_id', 'class_id', 'year', 'term'));
    }
    
    public function coordinator_tacher_room($class_id,$lesson_id,$teacher_id){


        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $class_id = Classe::find($class_id);

         $rooms =$class_id->room;
         $teacher=Teacher::find($teacher_id);
         $rooms = $teacher->rooms->unique();
        $lesson_id = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();



        return  view('acadsupervisors.coordinator_tacher_room', compact( 'teacher','coordinator','rooms','lesson_id', 'class_id', 'year', 'term'));
    }
      public function coordinator_tacher_room1($class_id,$lesson_id,$teacher_id){


        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        $class_id = Classe::find($class_id);

         $rooms =$class_id->room;
         $teacher=Teacher::find($teacher_id);
         $rooms = $teacher->rooms->unique();
        $lesson_id = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();



        return  view('acadsupervisors.coordinator_tacher_room1', compact( 'teacher','coordinator','rooms','lesson_id', 'class_id', 'year', 'term'));
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
    
   
   public function acadsupervisor_teacher_schedule($teacher_id,$room_id,$lesson_id)
    {
        $year=Year::where('current_year','1')->first();
        $coordinator_id = Auth::user()->acadsupervisor_id;
        $coordinator = Acadsupervisor::find($coordinator_id);
        // return $student_id ;
        $user_id = auth()->user()->id ;
        // $teacher_id = auth()->user()->teacher_id ;
       $teacher = Teacher::find($teacher_id);
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);
       $lesson=Lesson::find($lesson_id);

        // $room = Room::findOrFail($room_id);
        // $lessons = $room->lessons2 ;
        // pring teachers

        // pring lecture_tims
        $room =Room::find($room_id);
        $classes=Classe::find($room ->class_id);
        $lecture_times = Lecture_time::where('class_id',$classes->id);
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
                $hourMin = date('H:i');
                if ( $hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time){
                    $today_lecture->inter = true;
                     $minutes = $now->diffInMinutes($lecture_time->end_time) ;
                }else{
                    $today_lecture->inter = false;
                }
            
        }
        
        $now=Carbon::now();

        return view('acadsupervisors.coordinator_teacher_schedule',compact('lesson','classes','room','coordinator','teacher','now','teacher_id','lecture_times','days','schedule','today','minutes'));
    } 
      public function addevaluion(Request $request)
    {
        $evaluion1 = Evaluation::where('class_id', $request->class_id)->where('lesson_id', $request->lesson_id)->where('teacher_id', $request->teacher_id)->where('acad_id', Auth::user()->acadsupervisor_id)->orderBy('id', 'DESC')->first();

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
         $evaluion->acad_id = Auth::user()->acadsupervisor_id;
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
        $evaluion->acad_id = Auth::user()->acadsupervisor_id;
        $evaluion->class_id = $request->class_id;

        $evaluion->save();
        return redirect()->back();
    }
  
    
}
