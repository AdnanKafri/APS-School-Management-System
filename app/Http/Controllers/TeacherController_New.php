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
use App\Exam_question;
use App\Report_card;
use App\Studentfcmtoken;
use App\Notification;
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
use Session;
use ZipArchive ;
use App\Super_file;
use App\Rewards_and_sanction;
use App\Rewad_and_sanction_student;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\School_data;

class TeacherController_New extends Controller
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
     //functions for exams
    public function questions($class_id, $room_id, $lecture_id, $lesson_id)
    {
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class = Classe::find($class_id);
        $lecture_id = Lecture::find($lecture_id);
        $room = Room::where('class_id', $class_id)->where('id', $room_id)->first();
        $classes = Classe::all();
        $questions = Question::where('class_id', $class->id)->where('accept', 1)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $results = []; 
         foreach ($questions as $question) {
         $options = Option::where('question_id', $question->id)->get();
         $results[$question->id] = $options;
          }
          //return $results; 
        $sections = Section::where('class_id', $class_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $lectures = Lecture::where('active', 0)->where('class_id', $class_id)->where('lesson_id',$lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
         $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers2.teacher_add_automated',
        
        compact('objection','message','class','lectures',
        'lecture_id', 'lesson_id', 'room_id', 'classes', 'questions', 'sections', 'teacher'));
    }

    //حذف سؤال
    public function question_delete(Request $request)
    {
        $question = Question::find($request->question_id);
        if($question->option){
        $question->option->delete();
        }
        $question->delete();
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
    //صفحة الاختبارات
    public function exams($class_id, $lecture_id, $room_id)
    {
        $teacher_id = Auth::user()->teacher_id;
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $class = Classe::find($class_id);
        // $rooms = $class->room;
        $questions = question::where('class_id', $class_id)->where('accept', 1)->get();
        $lecture_id = Lecture::find($lecture_id);
        $teacher = Teacher::with(['rooms.student' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($teacher_id);
         $exams = Lesson_teacher_room_term_exam::where('type', '8')->where('teacher_id', Auth::user()->teacher_id)->where('type_file', '1')->where('term_id', $term->id)->where('room_id', $room_id)->where('lecture_id', $lecture_id->id)->get();
        $classes = Classe::all();
        $students = User::all();
        $lessons = $class->lessons;
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers2.teacher_addtest', compact('objection','message','questions', 'teacher', 'room_id', 'lecture_id', 'exams', 'classes', 'class', 'lessons'));
    }
    //حذف اختبار
    public function exam_delete(Request $request)
    {
        $id = $request->exam_id;
         Exam_question::where('test_id',$id)->delete() ;
        Lesson_teacher_room_term_exam::find($id)->delete();
        Exam_result::where('exam_id', $request->exam_id)->delete();
        return redirect()->back()->with('delete', 'تم حذف الامتحان بنجاح');
    }
    //اضافة اختبار
    public function exam_store(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
            if ($request->type == 3) {
            if($request->start_time > $request->end_time){
            session()->flash('error', 'يرجى تعديل الوقت');
            return redirect()->back()->with('error', 'يرجى تعديل الوقت!!');
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
            $item2->lecture_id = $request->lecture_id;
            $item2->type ='8';
            $item2->save();
        }
        return redirect()->back()->with('Add', 'تم اضافة الامتحان بنجاح ');
    }
    //تعديل اختبار
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
        if (true) {
           
            $exam->class_id = $exam->class_id;
            $exam->room_id = $exam->room_id;
            $exam->teacher_id = auth()->user()->teacher_id;
            if($request->name !=null){
                $exam->name_exam = $request->name;
            }
            else{
                $exam->name_exam = $request->name;
            }
            $exam->name_exam = $request->name;
            $exam->name_quize1 = $request->name;
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
        }
    
        if ($request->room_id != $exam->room_id && $exam->type!=8) {
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

    //صفحة بنك الاسئلة
    public function exams_addquestion($exam_id,$lecture_id,$room_id)
    {
        $teacher_id = Auth::user()->teacher_id;
        $year = Year::where('current_year', '1')->first();
        $teacher = Teacher::with(['rooms.student' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($teacher_id);
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam = lesson_teacher_room_term_exam::find($exam_id);
        $lectures = Lecture::where('active', 0)->where('term_id', $term->id)->where('class_id', $exam->class_id)->where('lesson_id',$exam->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $questions = Question::where('class_id', $exam->class_id)->where('accept', 1)->where('lesson_id', $exam->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        return view('teachers2.teacher_examquestion', compact('teacher','teacher_id','message','objection','questions', 'exam', 'lectures','lecture_id','room_id'));
    }
    public function search(Request $request)
    {
    
       

        $class = Classe::find($request->exam);
        if ($class) {
          
            $questions = question::with('classes')->with('lecture')->where('class_id', $request->exam)->where('accept',1)->where('lesson_id', $request->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        }

        if ($questions) {
            return $questions;
        } else return 1;

    }
    public function search_test(Request $request)
    {
    
        $exam1 = Lesson_teacher_room_term_exam::find($request->exam);
        if ($exam1) {
            $questions = question::with('classes')->with('lecture')->where('accept',1)->where('class_id', $exam1->class_id)->where('lesson_id', $exam1->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        } else {
            $questions = question::with('classes')->with('lecture')->where('accept',1)->where('class_id', $request->exam)->where('lesson_id', $request->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        }

        if ($questions) {
            return $questions;
        } else return 1;

      
    }
    public function search_eaxm(Request $request)
    {
    
        $exam1 = Exams2::find($request->exam);
        if ($exam1) {
            $questions = question::with('classes')->with('lecture')->where('accept',1)->where('class_id', $exam1->class_id)->where('lesson_id', $exam1->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        } else {
            $questions = question::with('classes')->with('lecture')->where('accept',1)->where('class_id', $request->exam)->where('lesson_id', $request->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->where('question_form', 'LIKE', '%' . $request->search . "%")->get();
        }

        if ($questions) {
            return $questions;
        } else return 1;

      
    }

    public function lecquestion1($lec, $exam,Request $request)
    {
        if ($lec != 0) {

            $questions = question::with('classes')->with('lecture')->where('accept', 1)->where('lecture_id', $lec)->where('teacher_id',auth()->user()->teacher_id)->get();
        } else {
            $exam1 = Lesson_teacher_room_term_exam::find($exam);
            if ($exam1) {
                $questions = question::with('classes')->with('lecture')->where('accept', 1)->where('class_id', $exam1->class_id)->where('lesson_id', $exam1->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
            } else {
                $questions = question::with('classes')->with('lecture')->where('accept', 1)->where('class_id', $request->class_id)->where('lesson_id', $request->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
            }
        }

        return $questions;
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
       
       foreach($selected_ques as $question_id){
        $question = Question::findOrFail($question_id) ;
       $exam_question=Exam_question::where('test_id',$request->exam_id)->where('question_id',$question_id)->delete();
       $exam_new=new Exam_question();
       $exam_new->test_id=$request->exam_id;
       $exam_new->question_id=$question_id;
       $exam_new->mark=$question->mark;
       $exam_new->save();
  
       }
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
    
     foreach($selected_ques as $question_id){
        $question = Question::findOrFail($question_id) ;
       $exam_question=Exam_question::where('exam_id',$request->room_id)->where('question_id',$question_id)->delete();
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
        //صفحة علامات الاختبارات
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
            return view('teachers2.teacher_testmark', compact('objection','message','quize', 'students', 'teacher', 'lesson', 'room','lesson_id', 'room_id', 'count', 'count2'));
        }
        //صفحة علامات الطلاب تبع الاختبارات
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
            return view('teachers2.teacher_testmark_students', compact('objection','message','students', 'exam1', 'exam_title', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
        }
    //صفحة الفقرات نص او صورة او مقطع صوت
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
        return view('teachers2.teacher_addsection', compact('objection','message','class', 'lesson_id', 'room_id', 'Lecture', 'classes', 'sections', 'teacher', 'rooms', 'questions'));
    }

    //التعديل على فقرة
     public function section_update(Request $request)
    {
       
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $section = Section::find($request->section_id);
    
        // Update basic section details
        $section->teacher_id = auth()->user()->teacher_id;
        $section->title = $request->title;
        $section->term_id = $term->id;
        $section->type = $request->type;
    
        // Handle content based on type
        if ($request->type == '0') { // Text content
            $section->content = $request->content;
        } else { // File content
            if ($request->hasFile('content')) {
                // Delete the old file if it exists
                if (Storage::disk('public')->exists($section->content)) {
                    Storage::disk('public')->delete($section->content);
                }
                // Store the new file
                $section->content = $request->file('content')->store('sectionfiles', 'public');
            } else {
                // Keep the existing content if no new file is uploaded
                $section->content = $section->content;
            }
        }
    
        // Save the section
        $section->save();
    
        // Flash success message and redirect back
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



    //صفحة اضافة سؤال
    public function add_questions($class_id, $room_id, $lecture_id, $lesson_id)
    {
        $class = Classe::find($class_id);
        $room = Room::where('class_id', $class_id)->where('id', $room_id)->first();
        $Lecture = Lecture::find($lecture_id);
        $classes = Classe::all();
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $questions = Question::where('class_id', $class_id)->where('accept', 1)->where('lesson_id', $lesson_id)->where('term_id', $term->id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $sections = Section::where('class_id', $class_id)->where('term_id', $term->id)->where('lesson_id', $lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        foreach($sections as $key => $item ){
        if(($item->type==3 ||  $item->type==2) && $item->content==null ){
        $sections->forget($key);
        }
    }
        $back=URL::previous();
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();
        return view('teachers2.teacher_add_question', compact('message','class','back', 'Lecture', 'room_id', 'classes', 'questions', 'sections', 'teacher','lesson_id'));
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
             	

            $question->teacher_id = auth()->user()->teacher_id;
            $question->save();

            // dd($question);

        } //نهاية السشرط لحالة السؤال التقليدي

        // حالة السؤال متعدد الخيارات
        elseif ($request->ques_type == "1") {

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
            $question->note = $request->note;
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

    public function question_edit($id,$room_id)
    {
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();
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
        $sections = Section::where('class_id', $class_id)->where('lesson_id', $questions->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $item = Question::where('id', $id)->first();
        $Lecture = Lecture::where('class_id', $item->class_id)->where('active',0)->get();

        return view('teachers2.teacher_update_question', compact('message','teacher','questions', 'room_id','class_id', 'Lecture', 'id', 'sections', 'item'));
    }


    //تعديل سؤال
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
    //ملف الاختبار
    public function quest_exam($exam_id) {

        $exam = Lesson_teacher_room_term_exam::find($exam_id);
        //$year = Year::where('current_year', '1')->first()->name;

        $room=Room::find($exam->room_id);
        $class_id=Room::find($exam->room_id)->class_id;
        $class1=Classe::find($class_id)->name;
        $term= Term_year::find($exam->term_id)->term;
        $lesson = Lesson::find($exam->lesson_id);
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();
        $selected_ques = $exam->selected_ques;
        $selected_ques = json_decode($selected_ques);
        $selected_ques1=[];
        if($selected_ques != null){
        foreach ($selected_ques as $x) {
        $selected_ques1[] = Question::where('id', $x)->with('option')->orderBy('section_id')->get();
        };
       // dd($ques_id);
        $class=$exam->class;
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $year = Year::where('current_year', '1')->first()->name;

        // $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        // $exams = Lesson_teacher_room_term_exam::where('type', '8')->where('teacher_id', Auth::user()->teacher_id)->where('type_file', '1')->where('term_id', $term->id)->where('room_id',$exam->room_id)->get();


        return view('teachers2.teacher_testfile',compact('teacher','message','selected_ques1','selected_ques','teacher','exam','class','room','term','lesson','class1','year'));
    }
        session()->flash('noSelectedQuestions', ' لم يتم اختيار أي سؤال لهذا الامتحان !! ');
        return redirect()->back();
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
            //$student123[]=$item->student_id ;
            //}
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


     //end functions

    //for index page
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

        $message = Message::where('teacher_id', $teacher_id)->where('type', 1)->where('view', 0)->count();

        $objection = Objection::where('teacher_id', $teacher_id)->where('view', 0)->count();


//notifications
                    $tokens = Studentfcmtoken::where('s_fk',91)->get();

 $devices = array();
        foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
        }
        $school_data = School_data::first();

            // $this->send_notification('title noti mazen','body noti test5555','lesson4444',$devices);


        return view('teachers2.teacher_index', compact('school_data','objection', 'teacher', 'events', 'count', 'count2', 'teacher_name', 'classes', 'message'));
    }

    //for subjects page
    public function teacher_lessons2($room_id, $teacher_id)
    {
        $teacher_name = Auth::user()->name;
        $teacher = Teacher::find($teacher_id);
        //$lessons = $teacher->lessons;
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
        $class = Classe::where('id', $room->class_id);
        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();

        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();

        return view('teachers2.teacher_subjects', compact('objection', 'teacher_lessons', 'teacher_name', 'room_name', 'message', 'teacher', 'room_id', 'count', 'count2', 'class'));
    }

    //for lessons of each subject
    public function lectures($lesson_id, $teacher_id, $room_id)
    {
        $year = Year::where('current_year', '1')->first();
        $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $teacher = Teacher::find($teacher_id);
        $lesson = Lesson::find($lesson_id);
        $lectures = Lecture::with('teacher')->where('active', 0)->whereHas('term_years', function ($q) use ($year) {
        $q->where('year_id', $year->id);
              })->where('lesson_id', $lesson->id)->where('room_id', $room_id)->get();
        $class = Room::find($room_id)->classes;
        $room = Room::find($room_id);
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();
        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();
        return view('teachers2.teacher_lessons', compact(
            'teacher',
            'objection',
            'lectures',
            'lesson',
            'class',
            'room',
            'message',
            'lesson_id', 'room_id',
        ));
    }
    public function search_lecture(Request $request)
    {

        $lectures = Lecture::with('teacher')
        ->where('active', 0)
        ->where('room_id', $request->room_id)
        ->where('name', 'LIKE','%'. $request->search .'%')
        ->get();
        return $lectures;
    }
    public function search_lecturetime(Request $request)
    {

        // $year = Year::where('current_year', '1')->first();
        // $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        if ($request->date == null) {
            $request->date = "";
        }
        $lectures = Lecture::with('teacher')
        ->where('active', 0)
        ->where('lesson_id',$request->lesson_id)
        ->where('room_id', $request->room_id)
        ->where('lecture_time', 'LIKE','%'. $request->date .'%')
        ->get();
        return $lectures;
        // return view('teachers2.teacher_searchlecture',compact('lectures','teacher','lesson', 'lesson_id', 'room_id','class','room'));


    }
    //select question
    public function lecquestion($lec, $exam,Request $request)
    {
        if ($lec != 0) {
            $questions = question::with('classes')->with('lecture')->where('accept', 1)->where('lecture_id', $lec)->where('teacher_id',auth()->user()->teacher_id)->get();
        } else {
            $exam1 = Lesson_teacher_room_term_exam::find($exam);
            if ($exam1) {
                $questions = question::with('classes')->with('lecture')->where('accept', 1)->where('class_id', $exam1->class_id)->where('lesson_id', $exam1->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
            } else {
                $questions = question::with('classes')->with('lecture')->where('accept', 1)->where('class_id', $request->class_id)->where('lesson_id', $request->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
            }
        }
        return $questions;
    }


    //select lecture
    public function selectlesson($lec,Request $request)
    {
        if ($lec != 0) {

        $lectures = Lecture::with('teacher')->where('active', 0)->whereHas('term_years', function ($q) use ($year) {
        $q->where('year_id', $year->id);
        })->where('lesson_id', $lesson->id)->where('room_id', $room_id)->get();
        }
        return  $lectures;
    }

    //for add lesson to subject
    public function store_lecture(Request $request)
    {
        $now=Carbon::now() ;
        $year = Year::where('current_year', '1')->first();
        $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $item = new Lecture;
        $item->teacher_id = $request->teacher_id;
        $item->class_id = $request->class_id;
        $item->room_id = $request->room_id;
        $item->lesson_id = $request->lesson_id;
        $item->year_id = $year->id;
        $item->term_id = $terms->id;
        $item->lecture_time = $request->lecture_time;
        $item->name = $request->name;
        $item->save();

         if($item->lecture_time < $now ) {
            $room = Room::find($request->room_id);
            $students = $room->student;
            foreach($students as $student){
            $noti = new Notification;
                $noti->user_id = Auth::user()->id;
                $noti->lesson_id = $request->lesson_id;
                $noti->student_id = $student->id;
                $noti->room_id = $request->room_id;
                $noti->lecture_id = $item->id;
                $noti->title ="تم اضافة درس ";
                $noti->body = $item->name;
                $noti->term_id = $terms->id;
                $noti->type = 1;
                $noti->save();
                $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                 $devices = array();
                 foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
                }
                $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, $noti->lecture_id,$devices);

            }
            }
        return  redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }
    //for update name and date of lesson
    public function update_lecture(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $item =  Lecture::find($request->id);
        $item->teacher_id = $request->teacher_id;
        $item->class_id = $request->class_id;
        $item->room_id = $request->room_id;
        $item->lesson_id = $request->lesson_id;
        $item->lecture_time = $request->lecture_time;
        $item->year_id = $year->id;
        $item->name = $request->name;
        $item->term_id = $terms->id;
        $item->save();
        return  redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }

    /*public function search_lecture(Request $request){
        $search_lecture=$_GET['search_lecture'];
        $lectures = Lecture::with('teacher')->where('active', 0)
        ->where('term_id', $terms->id)
        ->where('lesson_id', $lesson->id)
        ->where('room_id', $room_id)
        ->where('name', 'LIKE', '%' . $request->search_lecture . "%")->first();
        $output='';
        foreach ($lectures as $lecture) {
            $output.=`

            `;
        }


    }*/


    public function dalete_lecture(Request $request)
    {   $now=Carbon::now() ;
        $lectures = Lecture::find($request->question_id);
        if($lectures->lecture_time < $now ) {
            $room = Room::find($lectures->room_id);
            $students = $room->student;
            foreach($students as $student){
            $noti = new Notification;
                $noti->user_id = Auth::user()->id;
                $noti->lesson_id = $lectures->lesson_id;
                $noti->student_id = $student->id;
                $noti->room_id = $lectures->room_id;
                $noti->lecture_id = $lectures->id;
                $noti->title ="تم حذف درس ";
                $noti->body = $lectures->name;
                $noti->term_id = $lectures->term_id;
                $noti->type = 6;
                $noti->save();
                $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                 $devices = array();
                 foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
                }
                $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, $noti->lecture_id,$devices);

            }
            }
            $lectures->active=1;
             $lectures->save();
        // $lectures->delete();
        session()->flash('success', 'تمت العملية بنجاح');
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }

    //for send messages page
    public function teacher_messages()
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

        $message = Message::where('teacher_id', $teacher_id)->where('type', 1)->where('view', 0)->count();

        $objection = Objection::where('teacher_id', $teacher_id)->where('view', 0)->count();

        return view('teachers2.teacher_messages', compact('objection', 'teacher', 'events', 'count', 'count2', 'teacher_name', 'classes', 'message'));
    }

    //for send message student
   public function send_message(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
         $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $teacher = Teacher::find(Auth::user()->teacher_id);
        $message = new Message;
        $message->year_id = $year->id;
        $message->student_id = $request->student_id;
        $message->message = $request->message;
        $message->teacher_id =  auth()->user()->teacher_id;
        $message->save();
        $noti = new Notification;
                $noti->user_id = Auth::user()->id;
                $noti->teacher_id = $teacher->id;
                $noti->student_id = $request->student_id;
                $noti->title ="يوجد رسالة";
                $noti->body = $teacher->first_name . ' ' . $teacher->last_name;
                $noti->term_id = $term->id;
                $noti->type = 10;
                $noti->save();

                $tokens = Studentfcmtoken::where('s_fk',$noti->student_id)->get();

                  $devices = array();
                 foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
                }

                 $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,'null',$noti->teacher_id,'null',$devices);

        // session()->flash('success', 'تم ارسال بنجاح');
        // return redirect()->back()->with('success', '! تم ارسال بنجاح ');
    }
    //send message for all students
    public function send_group_message(Request $request)
    {
        $teacher = Teacher::find(Auth::user()->teacher_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $room = Room::find($request->room_id);
        $students = $room->student;
        foreach ($students as $item) {
            $message = new Message;
            $message->year_id = $year->id;
            $message->student_id = $item->id;
            $message->message = $request->message;
            $message->teacher_id = $request->teacher_id;
            $message->save();
            $noti = new Notification;
                $noti->user_id = Auth::user()->id;
                $noti->teacher_id = $teacher->id;
                $noti->student_id = $item->id;
                $noti->room_id = $room->id;
                $noti->title ="يوجد رسالة";
                $noti->body = $teacher->first_name . ' ' . $teacher->last_name;
                $noti->term_id = $term->id;
                $noti->type = 10;
                $noti->save();

                $tokens = Studentfcmtoken::where('s_fk',$noti->student_id)->get();

                  $devices = array();
                 foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
                }

                 $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->teacher_id,'null',$devices);

        }

        return redirect()->back();
    }
    //show all messages of students

    public function filter_message(Request $request)
    {
        $st = [];
        $room_st = [];
        $year = Year::where('current_year', '1')->first();
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'desc')->get();
        foreach ($message as $item) {
            $st[] = $item->student_id;
        }
        $rooms1 = Teacher_room_lesson::where('teacher_id', auth()->user()->teacher_id)->where('year_id', $year->id)->get();
          $rooms1 = $rooms1->unique('room_id');
          foreach ($rooms1 as $room) {

            $room_st[]=$room->room_id;
          }
        return Student::withCount('message')->with('room')->with(['message1' => function ($q) {
            $q->where('teacher_id', Auth::user()->teacher_id);
            $q->orderBy('id', 'desc');
        }])->whereHas('room',function ($q) use($request,$room_st) {
            if ($request->room != "" ) {
                $q->where('rooms.id', $request->room);
            }
            else{
                $q->whereIn('rooms.id', $room_st);
            }
        })->whereHas('room.classes' , function ($q) use($request) {
            $q->where('classes.id',$request->class);
        })->with('room.classes')->get();

    }

    public function get_message()
    {

        $year = Year::where('current_year', '1')->first();
        $st = [];
        $room_st = [];

        $teacher = Teacher::find(Auth::user()->teacher_id);
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'desc')->get();
        $rooms1 = Teacher_room_lesson::where('teacher_id', auth()->user()->teacher_id)->where('year_id', $year->id)->get();
         $rooms1 = $rooms1->unique('room_id');
          foreach ($rooms1 as $room) {

            $room_st[]=$room->room_id;
          }


        // foreach ($message as $item) {
        //      $item->student_id;
        // }

        $message1 = Message::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'ASC')->get();

          $student = Student::withCount('message')->with('room')->with(['message1' => function ($q) {
            $q->where('teacher_id', Auth::user()->teacher_id);
            $q->orderBy('id', 'desc');
        }])->with('room.classes')->
        whereHas('room' , function ($q) use($room_st) {
            $q->whereIn('room_id',$room_st);})->get();

        $classes = [];

        foreach ($teacher->rooms as $item) {
            $classes[] = $item->classes;
        }

         $classes = array_unique($classes);

        $year = Year::where('current_year', '1')->first();

        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();
        return view('teachers2.teacher_messages_teacher', compact('year','teacher', 'student', 'message', 'objection','classes'));;
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


    public function teacher_event()
    {

        $teacher_events = Teacher_event::where('teacher_id', auth()->user()->teacher_id)->get();
        $events = Teacher_event::where('teacher_id', auth()->user()->teacher_id)->get();
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $classes = $teacher->classes->unique();
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();
       $message = Message::where('teacher_id', $teacher->id)->where('type', 1)->where('view', 0)->count();
        return view('teachers2.teacher_events', compact('teacher_events', 'events', 'teacher', 'count', 'classes','message'));
    }


    public function store_teacher_event(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $classes = $teacher->classes->unique();
        $class_old = Room::find($event->room_id)->classes;
        $lessons = Teacher::find(auth()->user()->teacher_id);
        $rooms = $lessons->rooms()->where('teacher_room_lesson.class_id', $class_old->id)->where('teacher_room_lesson.year_id', $year->id)->get()->unique();
        $request->validate([
            'class_id' => 'required|numeric',
            'room_id'  =>  'required|numeric',
            'title'    =>   'required|max:30',
            'date'     =>    'required',
        ]);
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $classes = $teacher->classes->unique();
        $teacher_events = new Teacher_event;
        $teacher_events->class_id = $request->class_id;
        $teacher_events->room_id = $request->room_id;
        $teacher_events->year_id = $year->id;
        $teacher_events->teacher_id = auth()->user()->teacher_id;
        $teacher_events->title = $request->title;
        $teacher_events->content = $request->content;
        $teacher_events->date = $request->date;

        $teacher_events->save();

        Session::flash('success', '! تمت العملية بنجاح ');
        return redirect()->back();
    }

  public function update_teacher_event(Request $request)
    {
        //

        $year = Year::where('current_year', '1')->first();
        $teacher = Teacher::find(auth()->user()->teacher_id);
        // $classes = $teacher->classes->unique();
        // $class_old = Room::find($event->room_id)->classes;
        // $lessons = Teacher::find(auth()->user()->teacher_id);
        // $rooms = $lessons->rooms()->where('teacher_room_lesson.class_id', $class_old->id)->where('teacher_room_lesson.year_id', $year->id)->get()->unique();
        $request->validate([
            'title'    =>   'required|max:30',
            'date'     =>    'required',
        ]);
        $teacher_events = Teacher_event::find($request->event_id);
        // $teacher_events->class_id = $request->class_id;
        // $teacher_events->room_id = $request->room_id;
        $teacher_events->year_id = $year->id;
        $teacher_events->teacher_id = auth()->user()->teacher_id;
        $teacher_events->title = $request->title;
        $teacher_events->content = $request->content;
        $teacher_events->date = $request->date;

        $teacher_events->save();
        Session::flash('success', '! تمت العملية بنجاح ');
        return redirect()->back();
    }


    public function event_delete(Request $request)
    {
        $event_delete = Teacher_event::find($request->question_id);
        $event_delete->delete();
        session()->flash('success', 'تمت العملية بنجاح');
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }

    //add_content for lessons
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
        $room1 = room::find($room_id);
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();
        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();
        return view('teachers2.teacher_addcontent', compact('objection', 'rooms2', 'message', 'lecture_id', 'room_id', 'room1', 'class_id', 'terms', 'teacher', 'lessons', 'count', 'count2'));
    }

    public function store_items(Request $request)
    {
        $now=Carbon::now() ;
        $lecture = Lecture::find($request->lecture_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $item = new Lesson_teacher_room_term_exam;
        $item->namehomework = $request->namehomework;
        $item->lesson_id = $request->lesson_id;
        $item->teacher_id = $request->teacher_id;
        $item->room_id = $request->room_id;
        $item->term_id = $term->id;
        $item->type = $request->type;
        if ($request->name_video == null && $request->name_audio == null &&  $request->namehomework == null &&  $request->name_quize == null  &&  $request->name_quize1 == null && $request->test == null && $request->name_addition == null &&  $request->name_exam == null) {
            return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        }
       // if ($request->video == null && $request->video_in == null && $request->quize_link1 == null && $request->quize1 == null && $request->audio_file == null && $request->voice == null && $request->audio_link == null && $request->test == null && $request->quize == null && $request->exam == null && $request->test_link == null && $request->quize_link == null && $request->exam_link == null && $request->addition == null  &&  $request->addition_link == null) {
       //     return redirect()->back()->with('message', 'المحتوى فارغ يرجى اعادة تعبئة البيانات من جديد');
       // }
         //item for test
        if ($item->type == 1) {
            $item->namehomework = $request->namehomework;
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $term->id;
            $item->type = $request->type;
            $item->success_mark = $request->mark;
            if ($request->test == null && $request->test_link == null) {


                return redirect()->back()->with('message', 'محتوى الوظيفة فارغ يرجى تعبئة البيانات');

            }
            if ($request->test_link != null) {
                $item->test_link = $request->test_link;
                $item->start_time = $request->test_start_time;
                $item->end_time = $request->test_end_time;
                $item->type_file =  '1';
                if ($request->namehomework == null) {
                    return redirect()->back()->with('message', 'اسم الوظيفة فارغ يرجى تعبئة البيانات');
                }
                $item->namehomework = $request->namehomework;
            }

            if ($request->test && $request->hasFile('test')) {
                if( !$request->test->extension()){
               return redirect()->back()->with('message', 'هناك خطأ بالملف المدخل ');
                }
                $item->test = $request->test->store('filesteachers', 'public');
                $item->start_time = $request->test_start_time;
                $item->end_time = $request->test_end_time;
                if ($request->namehomework == null) {
                    return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
                }
                $item->namehomework = $request->namehomework;

                $item->extension =  $request->test->extension();
            }
            $item->lecture_id = $request->lecture_id;

            $item->save();

            if($lecture->lecture_time < $now ) {
               $room = Room::find($request->room_id);
            $students = $room->student;
            foreach($students as $student){
            $noti = new Notification;
                $noti->user_id = Auth::user()->id;
                $noti->lesson_id = $request->lesson_id;
                $noti->student_id = $student->id;
                $noti->room_id = $request->room_id;
                $noti->lecture_id = $request->lecture_id;
                $noti->title ="تم اضافة وظيفة";
                $noti->body = $request->namehomework;
                $noti->term_id = $term->id;
                $noti->type = 1;
                $noti->save();
                $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                 $devices = array();
                 foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
                }
                $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, $noti->lecture_id,$devices);

            }
            }



            session()->flash('Add', 'تم تعديل  بنجاح');
            return redirect()->back()->with('Add', '! تمت العملية بنجاح ');

        //item for video
        }
        else if ($item->type == 0) {
            $item->lecture_id = $request->lecture_id;
            $item->namehomework = $request->namehomework;
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $term->id;
            $item->type = $request->type;
            if ($request->video == null && $request->video_in == null) {

                return redirect()->back()->with('message', 'محتوى الفيديو فارغ يرجى تعبئة البيانات من جديد');
            }
            if ($request->video_in && $request->hasFile('video_in')) {
                 $this->validate($request, [
                     'video_in' => 'required|mimetypes:video/mp4,video/avi,video/mpeg|max:50000'
                ], [
                    'file.required' => 'يرجى  ترفيع  بالشروط المحددة  ',

                ]);
                 if( !$request->video_in->extension()){
                     return redirect()->back()->with('message', 'هناك خطأ بالملف المدخل ');
                }
                $item->video = $request->video_in->store('filesteachers', 'public');
                $item->type_video = '0';

                if ($request->name_video == null) {
                    return redirect()->back()->with('message', 'اسم الفيديو فارغ يرجى تعبئة البيانات من جديد');
                }

                $item->name_video = $request->name_video;
                $item->extension =  $request->video_in->extension();
            }


            if ($request->video != null) {
                $item->video_link = $request->video;
                if ($request->name_video == null) {
                    return redirect()->back()->with('message', 'اسم الفيديو فارغ يرجى تعبئة البيانات من جديد');
                }
                $item->name_video = $request->name_video;

                $item->type_video = '1';
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
                $noti->title ="تم اضافة فيديو";
                $noti->body = $request->name_video;
                $noti->term_id = $term->id;
                $noti->type = 1;
                $noti->save();
                    $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                 $devices = array();
                 foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
                }
             $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, $noti->lecture_id,$devices);

            }
            }


            session()->flash('Add', 'تم تعديل  بنجاح');

            return redirect()->back()->with('Add', '! تمت العملية بنجاح ');

            //item for audio
        } else if ($item->type == 6) {
            $item->lecture_id = $request->lecture_id;
            $item->namehomework = $request->namehomework;
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $term->id;
            $item->type = $request->type;
            if ($request->audio_file == null &&  $request->audio_link == null) {

                return redirect()->back()->with('message', 'محتوى مقطع الصوت فارغ يرجى تعبئة البيانات من جديد');
            }

            if ($request->audio_file && $request->hasFile('audio_file')) {
                $item->audio_file = $request->audio_file->store('filesteachers', 'public');
                $item->type_voice = '0';
                if ($request->name_audio == null) {
                    return redirect()->back()->with('message', 'اسم مقطع الصوت فارغ يرجى تعبئة البيانات من جديد');
                }
                if( !$request->audio_file->extension()){
                     return redirect()->back()->with('message', 'هناك خطأ بالملف المدخل ');
                }
                $item->name_audio = $request->name_audio;

                $item->extension =  $request->audio_file->extension();
            }


            if ($request->audio_link  != null) {
                $item->audio_link = $request->audio_link;
                if ($request->name_audio == null) {
                    return redirect()->back()->with('message', 'اسم مقطع الصوت فارغ يرجى تعبئة البيانات من جديد');
                }
                $item->name_audio = $request->name_audio;

                $item->type_voice = '1';
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
                $noti->title ="تم اضافة مقطع صوت";
                $noti->body = $request->name_audio;
                $noti->term_id = $term->id;
                $noti->type = 1;
                $noti->save();
                    $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                 $devices = array();
                 foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
                }
            $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, $noti->lecture_id,$devices);

            }
            }

            session()->flash('Add', 'تم تعديل  بنجاح');


            return redirect()->back()->with('Add', '! تمت العملية بنجاح ');
            //item for file
        } else if ($item->type == 4) {

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

    //show_content
    public function book_details($lesson_id, $teacher_id, $room_id, $lecture_id)
    {
        $year = Year::where('current_year', '1')->first();
        $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();
        $teacher = Teacher::find($teacher_id);


        $book_details = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)
            ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')->get();

        $lesson = Lesson::find($lesson_id);
        $videos = $book_details->where('type', '0');
        $voices = $book_details->where('type', '6');

        $tests = $book_details->where('type', '1');
        //مذاكرات الدرس
        $quizes =  Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
            ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')->where('type', '2')->orWhere('type', '5')->get();
        //امتحانات الدرس
        $exams =  Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
            ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')->where('type', '3')->orWhere('type', '5')->get();;

        $quizes1  =  Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
            ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->orderBy("id", 'desc')->where('type', '8')->get();
        //ترفيع ملف
        $additions = $book_details->where('type', '4');
        $super_file  = Super_file ::where('lecture_id', $lecture_id)->orderBy("id", 'desc')->get();
        $date = new DateTime();

        $now = $date->format('Y-m-d H:i:s');

        $class = Room::find($room_id)->classes;
        $class_id = Room::find($room_id)->class_id;
        $room = Room::find($room_id);

        $lecture = Lecture::find($lecture_id);
        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();
        return view('teachers2.teacher_showcontent', compact(
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
            'room',
            'super_file'

        ));
    }
    //كتب المادة
    public function books_subject($lesson_id, $teacher_id, $room_id)
    {
        $year = Year::where('current_year', '1')->first();
        $terms = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $teacher = Teacher::find($teacher_id);
        $lesson = Lesson::find($lesson_id);
        $lesson->books = json_decode($lesson->books);
        $lectures = Lecture::with('teacher')->where('active', 0)->whereHas('term_years', function ($q) use ($year) {
        $q->where('year_id', $year->id);
              })->where('lesson_id', $lesson->id)->where('room_id', $room_id)->get();
        $class = Room::find($room_id)->classes;
        $room = Room::find($room_id);
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();
        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();
        return view('teachers2.books', compact(
            'teacher',
            'objection',
            'lectures',
            'lesson',
            'class',
            'room',
            'message',
        ));
    }

    //schedual table for teacher
    public function teacher_schedule()
    {
        $year=Year::where('current_year','1')->first();
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
    // الحصة الحالية بالnavbar
    public function go_to_stream($scheduler_id, $day_id, $lecture_time_id, $room_id, $student_id)
    {
        $user_id = auth()->user()->id;
        $day = Day::findOrFail($day_id);
        $scheduler_record = Lesson_room_teacher_lecture_time::findOrFail($scheduler_id);

        $lecture_time = Lecture_time::findOrFail($lecture_time_id);
        $hourMin = date('H:i');
        // $hourMin = \Carbon\Carbon::parse(date('H:i') );
        // $hourMin = $hourMin->addMinute(60)->format("H:i");
        $end = $lecture_time->end_time;
        if ($hourMin < $lecture_time->start_time || $hourMin > $lecture_time->end_time) {
            return redirect()->back()->with('othertime', 'لايمكنك الدخول لحصة في غير  توقيتها');
        }

        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);
        if ($today != $day->id - 1) {
            return redirect()->back()->with('otherday', 'لايمكنك الدخول لحصة في غير اليوم الحالي');
        }
        $student_schedule_tracer = new Student_schedule_tracer();
        $student_schedule_tracer->user_id = $user_id;
        $student_schedule_tracer->lecture_time_id = $lecture_time_id;
        $student_schedule_tracer->day_id = $day_id;
        $student_schedule_tracer->save();
        $student = Teacher::findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $google_meet_url = $scheduler_record->meeting_link;
        redirect()->to($google_meet_url)->send();

        // return view('teachers.ter_stream',compact('room_name','room_id','class_name','student','room','end'));
    }

    //function for exams_quizes page
    public function exams_quizes_page()
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

        $message = Message::where('teacher_id', $teacher_id)->where('type', 1)->where('view', 0)->count();

        $objection = Objection::where('teacher_id', $teacher_id)->where('view', 0)->count();

        return view('teachers2.teacher_exams_quizes', compact('objection', 'teacher', 'events', 'count', 'count2', 'teacher_name', 'classes', 'message'));
    }

    //صفحة علامات المواد يلي منفوتهامن صفحة المذاكرات و الامتحانات
    public function marks_subjects($room_id, $teacher_id)
    {
        $teacher_name = Auth::user()->name;
        $teacher = Teacher::find($teacher_id);
        //$lessons = $teacher->lessons;
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
        $class = Classe::where('id', $room->class_id);
        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();

        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();

        return view('teachers2.teacher_marks_subjects', compact('objection', 'teacher_lessons', 'teacher_name', 'room_name', 'message', 'teacher', 'room_id', 'count', 'count2', 'class'));
    }
    //for prizemark page
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

        return view('teachers2.teacher_prizemark', compact('objection','message','medal','room_id' ,'student', 'teacher','room','lesson','class','lesson_id'));
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
        $noti = new Notification;
        $noti->user_id = Auth::user()->id;
        $noti->student_id = $request->student_id;
        $noti->room_id = $request->room_id;
        $noti->title ="تم منحك وسام";
        if ($request->medal == 1) {
            $noti->body = "ذهبي";
        } else if ($request->medal == 2) {
            $noti->body = "فضي";
        } else {
            $noti->body = "برونزي";
        }

        $noti->term_id = $term->id;
        $noti->type = 3;
        $noti->save();
        $tokens = Studentfcmtoken::where('s_fk',$request->student_id)->get();

         $devices = array();
         foreach($tokens as $t){
       array_push($devices, $t['s_fcm_token']);
        //array_push($devices['p_id'], $t['p_fk']);
            }
        $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,'null', 'null',$devices);
        session()->flash('Add', 'تم تعديل  بنجاح');
        return redirect()->back()->with('Add', '! تمت العملية بنجاح');

    }
    public function medal_delete(Request $request)
    {
    $id = $request->exam_id;
    Medal::findOrFail($id)->delete();
    session()->flash('error', 'تم الحذف  بنجاح');
    return redirect()->back()->with('error', '! تمت العملية بنجاح');
    }

    //edit homework
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
        return view('teachers2.teacher_edithomework', compact('objection','message','file','teacher','lecture','room'));

    }
    //صفحة علامات الوظائف
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
        return view('teachers2.teacher_mark_homework', compact('objection','message','homeworke', 'students','lesson','room', 'teacher', 'lesson_id', 'room_id', 'count', 'count2'));
    }
    //عرض وظائف الطلاب
    public function StudentsRoomLesson($room_id, $teacher_id, $lesson_id, $exam_id)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find( auth()->user()->teacher_id);
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
    //   return   $quize_result = Room::with(['student.exam_result' => function ($q) {
    //         $q->where('id', '<>', null)->orderBy('type');
    //     }]) ->whereHas('student.student_lesson_teacher_room_term_exam', function ($query) use ($exam_id) {
    //     $query->where('exam_id', $exam_id);
    // })
    // ->with(['student.student_lesson_teacher_room_term_exam' => function ($query) use ($exam_id) {
    //     $query->where('exam_id', $exam_id);
    // }])
     $quize_result = Room::with(['student.exam_result' => function ($q) {
            $q->where('id', '<>', null)->orderBy('type');
        }]) 
    ->with(['student.student_lesson_teacher_room_term_exam' => function ($query) use ($exam_id) {
        $query->where('exam_id', $exam_id);
    }])
    ->where('id', $room_id)->get();
        $exam_title = Lesson_teacher_room_term_exam::where('room_id', $room_id)->where('lesson_id', $lesson_id)
            ->where('teacher_id', $teacher_id)->orderBy('type')->get();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers2.teacher_homework_students', compact('objection','message','students', 'exam1','lesson' ,'room','exam_title', 'quize_result', 'teacher', 'exam_id', 'lesson_id', 'room_id'));
    }
    public function student_save_mark(Request $request)

    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
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
            $exam_result->term_id = $term->id;
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
             $exam_result1->term_id = $term->id;
            $exam_result1->save();
        }

                $noti = new Notification;
                $noti->user_id = Auth::user()->id;
                $noti->lesson_id = $request->lesson_id;
                $noti->student_id = $request->user_id;
                $noti->room_id = $request->room_id;
                $noti->lecture_id =  $home->lecture_id;
                $noti->title ="تمت اضافة علامة وظيفة  ";
                $noti->body = $home->namehomework;
                $noti->term_id = $term->id;
                $noti->type = 7;
                $noti->save();
                $tokens = Studentfcmtoken::where('s_fk',$request->user_id)->get();

                 $devices = array();
                 foreach($tokens as $t){
                array_push($devices, $t['s_fcm_token']);
                //array_push($devices['p_id'], $t['p_fk']);
                }
                $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, $noti->lecture_id,$devices);


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
        return view('teachers2.teacher_edit_video', compact('objection','message','file','teacher','lecture','room'));

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
        return view('teachers2.teachers_edit_audio', compact('objection','message','file','teacher','lecture','room'));

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


  public function profile()
    {
        $teacher_id = Auth::user()->teacher_id;
        $year = Year::where('current_year', '1')->first();
        $teacher = Teacher::with(['rooms.student' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($teacher_id);
$message = Message::where('teacher_id', $teacher_id)->where('type', 1)->where('view', 0)->count();
        return  view('teachers2.teacher_profile',compact('teacher','message'));
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

    public function exams1_addquestion($exam_id,$room_id,$class_id,$lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $classes=[];
        $teacher =  Teacher::find( Auth::user()->teacher_id);
        $teacher_id =  Teacher::find( Auth::user()->teacher_id);
        // $teachers = Teacher::with(['rooms.student' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($teacher_id);
        $teacher_room_lessons = Teacher_room_lesson::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id->id)->get();
        foreach ($teacher_room_lessons as $item) {
            $classes[] = $item->room_id;
        }
        $exam = lesson_teacher_room_term_exam::find($exam_id);
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam = Exams2::find($exam_id);
        $exams=Exams2::with('room')->whereIn('room_id',$classes)->where('groupe',$exam->groupe)->get();
        $questions = Question::where('class_id', $exam->class_id)->where('accept', 1)->where('lesson_id', $exam->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $lectures = Lecture::where('active', 0)->where('term_id', $term->id)->where('class_id', $exam->class_id)->where('lesson_id',$exam->lesson_id)->where('teacher_id',auth()->user()->teacher_id)->get();
        $class_id = Classe:: find($exam->class_id);
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        return view('teachers2.exams1_addquestion', compact('message','teacher_id','teacher','lectures','objection','questions', 'exam','class_id', 'room_id','exams','lesson_id','class_id'));
    }
    public function StudentsRoomLesson_exam($room_id, $teacher_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam  = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '1')->where('is_file', '1')->get();
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
        return view('teachers2.teacher_exam_mark', compact('exam','objection','lecture','students1','message', 'class_id','now','students', 'teacher','lesson', 'room','lesson_id', 'room_id', 'count', 'count2','quize1'));
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
        return view('teachers2.teacher_quize_mark', compact('objection','lecture','students1','message','quizes','class_id', 'quize1','students','room','lesson' ,'teacher','now', 'lesson_id', 'room_id', 'count', 'count2'));
    }


public function addition_delete(Request $request){


    $file_id=$request->id;



    $file=Lesson_teacher_room_term_exam::find($file_id);
    $exam_id= Exam_result::where('exam_id',$file->id)->get();
    if($exam_id){
        foreach($exam_id as $item){
            $item->delete();
        }
    }

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
public function file_update($file_id, Request $request)
{

    $item = Lesson_teacher_room_term_exam::find($file_id);
    if (($request->test == null && $item->test == null) &&  $request->test_link == null ){

        return redirect()->back()->with('message', 'المحتوى   فارغ يرجى اعادة تعبئة البيانات من جديد');
    }
    $item->success_mark = $request->mark;
    if ( $request->hasFile('test')) {
        if( !$request->test->extension()){
                    return redirect()->back()->with('message', 'هناك خطأ بالملف المدخل ');
            }
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

public function audio_update($file_id, Request $request)
{

    $item = Lesson_teacher_room_term_exam::find($file_id);
    if ($request->audio_file == null &&  $request->audio_link == null && $item->audio_file== Null && $item->audio_link== Null ){
        return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
    }
    $item->name_audio = $request->name_audio;
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

    $questions[] = Question::with(['exam_question'=>fn($q1)=>$q1->where('test_id',$exam_id)])->with('option')->find($question_id);


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
 
      $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
    $teacher = Teacher::find(auth()->user()->teacher_id);
    return view('teachers2.teacher_testfilestudent', compact('message','student', 'teacher','max_result','exam_id','questions', 'exam', 'exam_result', 'class1','room','term','year','class','lesson'));
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
 
    $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
    $teacher = Teacher::find(auth()->user()->teacher_id);
    return view('teachers2.teacher_quizefile',compact('message','student','teacher','max_result','exam_id','questions', 'exam', 'exam_result', 'class1','room','term','year','class','lesson'));
}

public function video_update($file_id, Request $request)
{


    $item = Lesson_teacher_room_term_exam::find($file_id);
    if ($request->video == null &&  $request->video_link == null && $item->video== Null && $item->video_link== Null ){
        return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
    }


  $item->name_video = $request->name_video;
         if ($request->name_video == null){
                    return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
                }
        if ($request->video && $request->hasFile('video')) {
             $this->validate($request, [
                     'video' => 'required|mimetypes:video/mp4,video/avi,video/mpeg|max:50000'
                ], [
                    'file.required' => 'يرجى  ترفيع  بالشروط المحددة  ',

                ]);
            Storage::disk('public')->delete($item->video);
            $item->video = $request->video->store('filesteachers', 'public');
            $item->type_video = '0';



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
        $exam_result->traditional_result =  json_encode($request->traditional_result);
         if ($result > $exam->success_mark) $result=  floor($result);
        $exam_result->result = $result;
        $exam_result->show_result = 1;
        $exam=lesson_teacher_room_term_exam::find($request->exam);
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





public function event_store(Request $request)
{


    $year = Year::where('current_year', '1')->first();

    $request->validate([
        'class_id' => 'required|numeric',
        'room_id'  =>  'required|numeric',
        'title'    =>   'required|max:30',
        'date'     =>    'required',
    ]);

    $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

    $teacher_event = new Teacher_event;

    $teacher_event->class_id = $request->class_id;
    $teacher_event->room_id = $request->room_id;
    $teacher_event->year_id = $year->id;
    $teacher_event->teacher_id = auth()->user()->teacher_id;
    $teacher_event->title = $request->title;
    $teacher_event->content = $request->content;
    $teacher_event->date = $request->date;

    $teacher_event->save();
     $room = Room::find($request->room_id);
            $students = $room->student;
            foreach($students as $student){
               $noti = new Notification;
                $noti->user_id = Auth::user()->id;
                $noti->student_id = $student->id;
                $noti->room_id = $request->room_id;
                $noti->title ="تم اضافة  حدث";
                $noti->body = $request->title;
                $noti->term_id = $term->id;
                $noti->type = 2;
                $noti->save();
                $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                 $devices = array();
                 foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
                }
            $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,'null', 'null',$devices);



            }

    return redirect()->back()->with('success', '! تمت العملية بنجاح ');
}
public function class_rooms($class_id, $teacher_id)
{

    $year = Year::where('current_year', '1')->first();
    $rooms1 = Teacher_room_lesson::where('teacher_id', auth()->user()->teacher_id)->where('class_id', $class_id)->where('year_id', $year->id)->get();
    $rooms1 = $rooms1->unique('room_id');

    $rooms = [];

    foreach ($rooms1 as $room) {

        $rooms[] = Room::find($room->room_id);
    }

    return $rooms;
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

    //تنزيل جميع الملفات الوظائف بمجلد واحد
     public function download_zip($room_id, $exam_id)
    {

       $files = [];
    $exam1 = Lesson_teacher_room_term_exam::find($exam_id);

    $exam_title = Student_lesson_teacher_room_term_exam::where('room_id', $room_id)
        ->where('exam_id', $exam_id)
        ->get();

    foreach ($exam_title as $item) {
        $files[] = $item->file;
    }

     if($exam_title->isEmpty()){
       Session::flash('success', '! لايوجد اي ملف مخزن من الطلاب  ');
          return redirect()->back();
     }

     else{
           $fileName = $exam1->namehomework.'downloads.zip';

    // Check if the file exists, and create it if it doesn't
    if (!file_exists(public_path($fileName))) {
         touch(public_path($fileName));
    }else{
         unlink(public_path($fileName));
    }

    $zip = new ZipArchive;

    if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
        foreach ($files as $file) {
            $path =storage_path('app/'.$file);
            $relativeName = basename($path);
            $zip->addFile($path, $relativeName);
        }

     $zip->close();
    }

    return response()->download(public_path($fileName));

    }

    }
    //تنزيل ملفات المذاكرة

     public function quize_zip($room_id, $exam_id)
    {

       $files = [];
    $exam1 = Exams2::find($exam_id);

    $exam_title = Exam_file::where('room_id', $room_id)
        ->where('exam_id', $exam_id)
        ->get();

             if($exam_title->isEmpty()){
     session()->flash('error', '');
            return redirect()->back()->with('error', '!   ');
    }
    else{
         foreach ($exam_title as $item) {
        $files[] = $item->file;
    }

    $fileName = $exam1->name.'downloads.zip';

    // Check if the file exists, and create it if it doesn't
    if (!file_exists(public_path($fileName))) {
         touch(public_path($fileName));
    }else{
         unlink(public_path($fileName));
    }

    $zip = new ZipArchive;

    if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
        foreach ($files as $file) {
            $path =storage_path('app/'.$file);
            $relativeName = basename($path);
            $zip->addFile($path, $relativeName);
        }

     $zip->close();
    }

    return response()->download(public_path($fileName));

    }


    }

   public function teacher_quize_mark($room_id, $teacher_id, $lesson_id)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
         $quizes  = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '2')->where('is_file', '1')->get();
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
        return view('teachers2.teacher_quize_mark', compact('objection','lecture','students1','message','quizes','class_id', 'quize1','students','room','lesson' ,'teacher','now', 'lesson_id', 'room_id', 'count', 'count2'));
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
       public function studentselect($exam,$room)
    {
        $student=[];
        $exam_id=Exam_result2::where('exam_id',$exam)->where('room_id',$room)->get();
         foreach( $exam_id as $item ){

                $student[]=$item->user_id;

            }
      return    $students = Student:: whereIn('id',$student)->get();

    }

     //دفتر العلامات
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

         $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
         $count = $count->count();


         $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
         $count2 = $count2->count();

          $class_id=Room::find($room_id)->class_id;
          $class=Classe::find($class_id);
            $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
         if($class->stage_id ==1){
             return view('teachers2.teacher_total', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
         }
         elseif($class->stage_id ==2){
              return view('teachers2.teacher_total1', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
         }
           elseif($class->stage_id ==3){
              return view('teachers2.teacher_total2', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
         }


     }
     //ملف دفتر العلامات
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
            return view('teachers2.teacher_total_pdf', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
        elseif($class->stage_id ==2){
             return view('teachers2.teacher_total1_pdf', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
          elseif($class->stage_id ==3){
             return view('teachers2.teacher_total2_pdf', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }


    }

    //اكسل دفتر العلامات
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
            return view('teachers2.teacher_total_excel', compact('objection','objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
        elseif($class->stage_id ==2){
             return view('teachers2.teacher_total_excel1', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }
          elseif($class->stage_id ==3){
             return view('teachers2.teacher_total2_excel1', compact('objection','room','students', 'teacher', 'lesson_id','message', 'room_id', 'count', 'count2','lesson'));
        }


    }
    /// اضافة طلاب للمذاكرة
 public function add_quize_student(Request $request){
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
            $exam11=Exams2::find($request->exam);
           
        try {
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
                    if($exam11->type==2){
                    $noti = new Notification;
                    $noti->user_id = Auth::user()->id;
                    $noti->student_id = $student->id;
                    $noti->lesson_id = $request->lesson_id;
                    $noti->room_id = $request->room_id;
                    $noti->title ="تم اضافة  مذاكرة";
                    $noti->body = $exam11->name;
                    $noti->term_id = $term->id;
                    $noti->type = 4;
                    $noti->save();
                    $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                    $devices = array();
                    foreach($tokens as $t){
                array_push($devices, $t['s_fcm_token']);
                //array_push($devices['p_id'], $t['p_fk']);
                    }
                $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, 'null',$devices);
                    }
                    else{
                    $noti = new Notification;
                    $noti->user_id = Auth::user()->id;
                    $noti->student_id = $student->id;
                    $noti->lesson_id = $request->lesson_id;
                    $noti->room_id = $request->room_id;
                    $noti->title ="تم اضافة  امتحان";
                    $noti->body = $exam11->name;
                    $noti->term_id = $term->id;
                    $noti->type = 5;
                    $noti->save();
                    $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
                    $devices = array();
                    foreach($tokens as $t){
                array_push($devices, $t['s_fcm_token']);
                //array_push($devices['p_id'], $t['p_fk']);
                    }
                $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, 'null',$devices);
                    }


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

                if($exam11->type==2){
                $noti = new Notification;
                    $noti->user_id = Auth::user()->id;
                    $noti->student_id = $student->id;
                    $noti->lesson_id = $request->lesson_id;
                    $noti->room_id = $request->room_id;
                    $noti->title ="تم اضافة  مذاكرة";
                    $noti->body = $exam11->name;
                    $noti->term_id = $term->id;
                    $noti->type = 4;
                    $noti->save();
                    $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
                    $devices = array();
                    foreach($tokens as $t){
                array_push($devices, $t['s_fcm_token']);
                //array_push($devices['p_id'], $t['p_fk']);
                    }
                $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, 'null',$devices);
                    }
                    elseif($exam11->type==1){

                    $noti = new Notification;
                    $noti->user_id = Auth::user()->id;
                    $noti->student_id = $student->id;
                    $noti->lesson_id = $request->lesson_id;
                    $noti->room_id = $request->room_id;
                    $noti->title ="تم اضافة  امتحان";
                    $noti->body = $exam11->name;
                    $noti->term_id = $term->id;
                    $noti->type = 5;
                    $noti->save();
                    $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
                    $devices = array();
                    foreach($tokens as $t){
                array_push($devices, $t['s_fcm_token']);
                //array_push($devices['p_id'], $t['p_fk']);
                    }
                $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, 'null',$devices);
                    }
            }
            }
        }
            DB::commit();
        } catch (\Exception $e) {
           
            DB::rollBack();
        }
       

            return  redirect()->back()->with('success', '! تمت العملية بنجاح ');
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
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        return view('teachers2.teacher_examfile1',compact( 'message','selected_ques1','selected_ques','exam','teacher','class','room','term','lesson','class1','year'));
        }
        else{
            session()->flash('noSelectedQuestions', ' لم يتم اختيار أي سؤال لهذا الامتحان !! ');
        return redirect()->back();;
        }
}
     // صفحة علامات المذاكرات
    public function teacher_quize_students($room_id, $teacher_id, $lesson_id, $exam_id)
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
        $quize = Exams2::find($exam_id);
      if($exam1->type=='2'&& $exam1->is_file == '0'){
          $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
          $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
          $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
           return view('teachers2.teacher_quize_students_outo', compact('objection','students','message', 'exam1',  'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
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


                 $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
                $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
               return view('teachers2.teacher_quize_students', compact('objection','students','message', 'quize', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
    }
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

    ///حفظ علامة المذاكرة او الامتحان
public function student_save_mark_quize(Request $request)

    {
         $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $exam = Exams2::find($request->exam_id);

        $exam_result = Exam_result2::find($request->exam_result_id);
        $room = Room::find($request->room_id);
        if ($exam_result) {

            $exam_result->result = $request->mark;
            $exam_result->status = '1';
            $exam_result->class_id = $room->classes->id;
            $exam_result->room_id = $request->room_id;
            $exam_result->exam_id = $request->exam_id;
            $exam_result->user_id = $request->user_id;
            $exam_result->term_id = $term->id;
         if($exam->mark ==$request->mark){

            $exam_result->medal ="1";
        }
        elseif($exam->mark-1 ==$request->mark    || $exam->mark-2 ==$request->mark || $exam->mark-3 ==$request->mark ){
            $exam_result->medal ="2";
        }
        elseif($exam->mark-4 ==$request->mark    || $exam->mark-5 ==$request->mark || $exam->mark-6 ==$request->mark ){
             $exam_result->medal ="3";
        }
        else{
            $exam_result->medal =null;
        }
            $exam_result->type = $exam->type;
            $exam_result->start_time = $exam->start_date;
            $exam_result->end_time = $exam->end_date;


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
            $exam_result1->term_id = $term->id;
            $exam_result1->type = $exam->type;
            $exam_result1->start_time = $exam->start_date;
            $exam_result1->end_time = $exam->end_date;
   if($exam->mark ==$request->mark){

            $exam_result1->medal ="1";
        }
        elseif($exam->mark-1 ==$request->mark    || $exam->mark-2 ==$request->mark || $exam->mark-3 ==$request->mark ){
            $exam_result1->medal ="2";
        }
        elseif($exam->mark-4 ==$request->mark    || $exam->mark-5 ==$request->mark || $exam->mark-6 ==$request->mark ){
             $exam_result1->medal ="3";
        }
         else{
            $exam_result->medal =null;
        }
            $exam_result1->save();

        }
        if($exam->type == 2){
          $noti = new Notification;
        $noti->user_id = Auth::user()->id;
        $noti->student_id = $request->user_id;

        $noti->room_id = $request->room_id;
        $noti->title ="تم اضافة  علامة للمذاكرة";
        $noti->body = $exam->name;
        $noti->term_id = $term->id;
        $noti->type = 4;
        $noti->save();
        $tokens = Studentfcmtoken::where('s_fk',$request->user_id)->get();

         $devices = array();
         foreach($tokens as $t){
    array_push($devices, $t['s_fcm_token']);
    //array_push($devices['p_id'], $t['p_fk']);
        }
    $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,'null', 'null',$devices);
        }
      if($exam->type == 1){
           $noti = new Notification;
        $noti->user_id = Auth::user()->id;
        $noti->student_id = $request->user_id;

        $noti->room_id = $request->room_id;
        $noti->title ="تم اضافة  علامة للامتحان";
        $noti->body = $exam->name;
        $noti->term_id = $term->id;
        $noti->type = 5;
        $noti->save();
        $tokens = Studentfcmtoken::where('s_fk',$request->user_id)->get();

         $devices = array();
         foreach($tokens as $t){
    array_push($devices, $t['s_fcm_token']);
    //array_push($devices['p_id'], $t['p_fk']);
        }
    $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,'null', 'null',$devices);
        }
        return  redirect()->back();
    }

    public function StudentsRoomLesson_exammark($room_id, $teacher_id, $lesson_id, $exam_id)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);
        $room = Room::find($room_id);
        $students = $room->with('student.exams_files')->with('student.exam_result2')->get();
        $exam  = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->get();
        $quize_result = Room::with(['student.exam_result2' => function ($q) {
            $q->where('id', '<>', null)->orderBy('type');
        }])->where('id', $room_id)->get();

        // $exam_title = Exams2::where('room_id', $room_id)->where('lesson_id', $lesson_id)
        //     ->where('teacher_id', $teacher_id)->orderBy('type')->get();
        if($exam->type=='1'&& $exam->is_file == '1'){
            $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
            $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
            $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
            return view('teachers.teacher_exammark', compact('objection','students','message', 'exam1',  'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
        }
        if($exam->type=='1' && $exam->is_file == '0'){
            $quize_result = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
            $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
            $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
            return view('teachers2.teacher_exam_mark', compact('objection','students','message', 'exam', 'quize_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
        }
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
    ///  فلتر للمذاكرات يلي مقدمين

      public function quizestudent($lec,$home,$room_id)
    {
        $student12=[];
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
    ///  اضافة علامة للمذاكرة بعد ال ajax
    public function student_save_mark3(Request $request)

    {
      $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam2 = Exams2::find($request->exam_id);

        $exam_result = Exam_result2::find($request->exam_result_id);
        $room = Room::find($request->room_id);
        if ($exam_result) {
   if($exam2->mark ==$request->mark){

            $exam_result->medal ="1";
        }
        elseif($exam2->mark-1 ==$request->mark    || $exam2->mark-2 ==$request->mark || $exam2->mark-3 ==$request->mark ){
            $exam_result->medal ="2";
        }
        elseif($exam2->mark-4 ==$request->mark    || $exam2->mark-5 ==$request->mark || $exam2->mark-6 ==$request->mark ){
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
            $exam_result->term_id = $term->id;
            $exam_result->type = $exam2->type;
            $exam_result->start_time = $exam2->start_date;
            $exam_result->end_time = $exam2->end_date;

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
            $exam_result1->term_id = $term->id;
            $exam_result1->type = $exam2->type;
            $exam_result1->start_time = $exam2->start_date;
            $exam_result1->end_time = $exam2->end_date;
       if($exam2->mark ==$request->mark){

            $exam_result1->medal ="1";
        }
        elseif($exam2->mark-1 ==$request->mark    || $exam2->mark-2 ==$request->mark || $exam2->mark-3 ==$request->mark ){
            $exam_result1->medal ="2";
        }
        elseif($exam2->mark-4 ==$request->mark    || $exam2->mark-5 ==$request->mark || $exam2->mark-6 ==$request->mark ){
             $exam_result1->medal ="3";
        }
         else{
            $exam_result->medal =null;
        }
            $exam_result1->save();
        }

          if($exam2->type == 2){
          $noti = new Notification;
        $noti->user_id = Auth::user()->id;
        $noti->student_id = $request->user_id;

        $noti->room_id = $request->room_id;
        $noti->title ="تم اضافة  علامة للمذاكرة";
        $noti->body = $exam2->name;
        $noti->term_id = $term->id;
        $noti->type = 4;
        $noti->save();
        $tokens = Studentfcmtoken::where('s_fk',$request->user_id)->get();

         $devices = array();
         foreach($tokens as $t){
    array_push($devices, $t['s_fcm_token']);
    //array_push($devices['p_id'], $t['p_fk']);
        }
    $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,'null', 'null',$devices);
        }
         if($exam2->type == 1){
           $noti = new Notification;
        $noti->user_id = Auth::user()->id;
        $noti->student_id = $request->user_id;

        $noti->room_id = $request->room_id;
        $noti->title ="تم اضافة  علامة للامتحان";
        $noti->body = $exam2->name;
        $noti->term_id = $term->id;
        $noti->type = 5;
        $noti->save();
        $tokens = Studentfcmtoken::where('s_fk',$request->user_id)->get();

         $devices = array();
         foreach($tokens as $t){
    array_push($devices, $t['s_fcm_token']);
    //array_push($devices['p_id'], $t['p_fk']);
        }
    $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,'null', 'null',$devices);
        }

        return  redirect()->back();
    }
    //عرض جميع الامتحانات
    public function teacher_exam_mark($room_id, $teacher_id, $lesson_id)
    {
       $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $exam  = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '1')->where('is_file', '1')->get();
        $quize1 = Exams2::where('term_id', $term->id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '1')->where('is_file','0')->get();
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);

        $room = Room::find($room_id);

          $class_id = Classe:: find($room->classes->id);
        $students = $room->student;

        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $students1 = $room->student;

         $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
          $lecture = Lecture::where('lesson_id',$lesson->id)->where('class_id',$class_id->id)->where('active',0)->get();

        return view('teachers2.teacher_exam_mark', compact('lecture','students1','message','exam', 'class_id','now','students', 'teacher','lesson', 'room','lesson_id', 'room_id','quize1'));
    }
    //عرض صفحة علامات الامتحانات
    public function teacher_exam_students($room_id, $teacher_id, $lesson_id, $exam_id)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);
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
            $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
            $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
            return view('teachers2.teacher_exam_student', compact('objection','students','message', 'exam',  'exam_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
        }
        if($exam->type=='1' && $exam->is_file == '0'){
            $exam_result  = Exam_result2::with('student' )->where('exam_id',$exam_id)->where('room_id',$room_id)->get();
            $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
            $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
           return view('teachers2.teacher_exammark_auto', compact('objection','students','message', 'exam', 'exam_result','lesson','room' ,'teacher', 'exam_id', 'lesson_id', 'room_id'));
      }


    }
    ///حفظ علامة الوظيفة بعد ال ajax
    public function student_save_mark_homework(Request $request)

    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $home = Lesson_teacher_room_term_exam::find($request->exam_id);

        $exam_result = Exam_result::where('exam_id',$home->id)->where('user_id',$request->user_id)->first();
        $room = Room::find($request->room_id);
        if ($exam_result) {
            $exam_result->term_id = $term->id;
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
            $exam_result1->term_id = $term->id;
            $exam_result1->save();
        }
         $noti = new Notification;
                $noti->user_id = Auth::user()->id;
                $noti->lesson_id = $request->lesson_id;
                $noti->student_id = $request->user_id;
                $noti->room_id = $request->room_id;
                $noti->lecture_id =  $home->lecture_id;
                $noti->title ="تمت اضافة علامة وظيفة  ";
                $noti->body = $home->namehomework;
                $noti->term_id = $term->id;
                $noti->type = 7;
                $noti->save();
                $tokens = Studentfcmtoken::where('s_fk',$request->user_id)->get();

                 $devices = array();
                 foreach($tokens as $t){
                array_push($devices, $t['s_fcm_token']);
                //array_push($devices['p_id'], $t['p_fk']);
                }
                $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, $noti->lecture_id,$devices);

        return  redirect()->back();
    }
    // اظهار الصفوف لدفتر العلامات 
   public function mark_class()
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

        $message = Message::where('teacher_id', $teacher_id)->where('type', 1)->where('view', 0)->count();

        $objection = Objection::where('teacher_id', $teacher_id)->where('view', 0)->count();

        return view('teachers2.mark_class', compact('objection', 'teacher', 'events', 'count', 'count2', 'teacher_name', 'classes', 'message'));
    }
    //  اظهار المواد لدفتر العلامات بالشعبة 
       public function mark_room($room_id, $teacher_id)
    {
        $teacher_name = Auth::user()->name;
        $teacher = Teacher::find($teacher_id);
        //$lessons = $teacher->lessons;
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
        $class = Classe::where('id', $room->class_id);
        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();

        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();

        return view('teachers2.mark_room', compact('objection', 'teacher_lessons', 'teacher_name', 'room_name', 'message', 'teacher', 'room_id', 'count', 'count2', 'class'));
    }
     // تصدير علامات المذاكرة 
    public function export_exam($exam_id,$room_id,$lesson_id)
    {
           $lesson=Lesson::find($lesson_id);
          $year=Year::where('current_year','1')->first();
          $term_id=Exams2::find($exam_id)->term_id;
          $term = Term_year::where('id', $term_id)->where('year_id', $year->id)->first();
         
          $exam = Exam_result2::where('exam_id',$exam_id)->where('room_id',$room_id)->get();
        foreach($exam as $item){
            $student[]= $item->user_id;
         }
     

           
                 $student_mark=Students_mark::whereIn('student_id',$student)->where('year_id',$year->id)->get();
                 if($term->type=="1"){
                    
              foreach($student_mark as $item){
            
             foreach($exam as $item1){
                       
                    $report_card=Report_card::where('student_id',$item->student_id)->where('year_id',$year->id)->first();
                    if (isset($report_card) && $report_card->adjustable != 0){
                            session()->flash('error',' لا يمكن التعديل بعد استصدار الجلاء  ' ) ;
                        return redirect()->back()->with('error','  لا يمكن تعديل العلامات بعد استصدار الجلاء !  ') ;
                    }
                    if (auth()->user()->type == 1 && $item->adjustable != 0){
                            session()->flash('error',' لا يمكن التعديل تم تثبيت العلامات من قبل الإدارة  ' ) ;
                        return redirect()->back()->with('error','لا يمكن التعديل   تم تثبيت العلامات من قبل الإدارة   !  ') ;
                    }
                    
                       
                       if($item->student_id	==$item1->user_id){
                            $object1=json_decode($item->mark,true);
                            if($item1->result== null){
                              
                                   $object1[$lesson_id]['quize']="0";
                            }else{
                                if($item1->result > ($lesson->max_mark *0.2) ){
                                     
               session()->flash('error', ' لايمكن الادخال العلامة اكبر من القيمة ');

           return redirect()->back()->with('error', '!   لايمكن الادخال  العلامة اكبر من القيمة المحددة');
                                    
                                }
                                else{
                                     $object1[$lesson_id]['quize']=$item1->result;
                                }
                                   
                            }
             if ($item->worke_degree) {
                $object_worke_degree = json_decode($item->worke_degree, true);
                foreach (json_decode($item->worke_degree) as $key => $item12) {
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

            $object_result2 = json_decode($item->result2, true);
            if ($item->result) {
                $object_result = json_decode($item->result, true);
     
                $decodedData=[];  
                $object_result = json_decode($item->result, true);  
                $decodedData = json_decode($item->result2, true);
               
                 if (!$decodedData || !array_key_exists($lesson_id, $decodedData)) {


                    $object_result2[$lesson_id]['term2_result'] = 0;
                }


                $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);
                $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
            }







           $item->update([
                'student_id' => $item->student_id,
                'room_id' => $room_id,
                'worke_degree' => json_encode($object_worke_degree),
                'mark' => json_encode($object1),
                'result1' => json_encode($object_result1),
                'result' => json_encode($object_result),
                'status' => '1'

            ]);

            if ($item->estimation1) {
                $stc = json_decode($item->estimation1, true);
                if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 0 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 40) {

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
                    $stc[$lesson_id] = "جيد جداًً";
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
                    $stc->{$lesson_id} = "جيد جداًً";
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
                $les= Lesson::find($key1);
                 if($les){
                if( $les->is_neutral!=3){
                $result_term1 = $result_term1 + $value1['term1_result'];
                $count++;
                 }}
            }
          
            $objec_term_result = json_decode($item->term_result, true);
              $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 : "0";
             
                  $year_result = (json_decode($item->term_result, true)['term1']
                + $objec_term_result['term1'] ) / 2;

            $item->update([
                'term_result' => json_encode($objec_term_result),
                'year_result' => $year_result,


            ]);
            if ($item->estimation) {
                $stc = json_decode($item->estimation, true);
                if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $item->estimation = json_encode($stc);

                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $item->estimation = json_encode($stc);
                    $item->save();
                }
            } else {
                $stc1 = new stdClass;
                if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc1->{$lesson_id} = "ضعيف";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc1->{$lesson_id} = "وسط";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc1->{$lesson_id} = "جيد";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc1->{$lesson_id} = "جيد جداًً";
                    $item->estimation = json_encode($stc1);

                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc1->{$lesson_id} = "ممتاز";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                }
            }
          }
                       
                   }
          }}
          
          
          
              else if($term->type=="2"){
              
               foreach($student_mark as $item){
                  
                   foreach($exam as $item1){
                       
                        $report_card=Report_card::where('student_id',$item->student_id)->where('year_id',$year->id)->first();
                       if (isset($report_card) && $report_card->adjustable != 1){
                session()->flash('error22',' لا يمكن التعديل تأكد من حالة الجلاء ' ) ;
                return redirect()->back()->with('error','  لا يمكن التعديل تأكد من حالة الجلاء    !  ') ;
            }
            if (auth()->user()->type == 1 && $item->adjustable != 1){
                        session()->flash('error22',' لا يمكن التعديل تأكد من حالة الجلاء ' ) ;
                return redirect()->back()->with('error','   لا يمكن التعديل   تم تثبيت العلامات من قبل الإدارة    !  ') ;
            }

          
 if($item->student_id	==$item1->user_id){

            $object2 = json_decode($item->mark2, true);
                      if($item1->result== null){
                              
                                   $object2[$lesson_id]['quize']="0";
                            }else{
                                if($item1->result > ($lesson->max_mark *0.2) ){
                                     
                        session()->flash('error', ' لايمكن الادخال العلامة اكبر من القيمة ');

                        return redirect()->back()->with('error', '!   لايمكن الادخال  العلامة اكبر من القيمة المحددة');
                                    
                                }
                                else{
                                     $object2[$lesson_id]['quize']=$item1->result;
                                }
                                   
                            }

          
            if($item->worke_degree ){
                $object_worke_degree2=json_decode($item->worke_degree,true);
               foreach(json_decode($item->worke_degree) as $key=>$item12){
                 $count=0;
                  if($key !=$lesson_id ) {
                       $count=1;
                       break;
                  }


               }
               if($count==1){
                      $object_worke_degree2[$lesson_id]['term2_result']="null";
               }



                  $object_worke_degree2[$lesson_id]['term2_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];
                     if(isset($object_worke_degree2[$lesson_id]['term1_result']) && $object_worke_degree2[$lesson_id]['term1_result'] !="null"){
               $object_worke_degree2[$lesson_id]['term1_result']=$object_worke_degree2[$lesson_id]['term1_result'];
         }
         else{
            $object_worke_degree2[$lesson_id]['term1_result']="null";
         }

           }
           else{
               //   $object_worke_degree2[$lesson_id]['term1_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];
               $object_worke_degree2[$lesson_id]['term2_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];
           }

            //   if($item->worke_degree){
            //     $object_worke_degree2=json_decode($item->worke_degree,true);
            //   }

            //     $object_worke_degree2[$lesson_id]['term2_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];

            $object_result2 = json_decode($item->result2, true);
            $object_result2[$lesson_id]['term2_quizes'] = ceil($object2[$lesson_id]['oral']) +
                ceil($object2[$lesson_id]['homework']) + ceil($object2[$lesson_id]['activities']) + ceil($object2[$lesson_id]['quize']);
            $object_result2[$lesson_id]['term2_exam'] = ceil($object2[$lesson_id]['exam']);
            $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
            $object_result1 = json_decode($item->result1, true);
            $object_result = json_decode($item->result, true);

            if ($item->result) {
                $object_result = json_decode($item->result, true);
                $decodedData = json_decode($item->result1);
                  if (!$decodedData || !array_key_exists($lesson_id, $decodedData)) {
                    $object_result1[$lesson_id]['term1_result'] = 0;
                }
                $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
                $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
            }

           
            $item->update([
                'student_id' => $item->student_id,
                'room_id' => $room_id,
                'mark2' => json_encode($object2),
                'result2' => json_encode($object_result2),
                'result' => json_encode($object_result),
                'worke_degree' => json_encode($object_worke_degree2),
                'status' => '1'

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
                    $stc[$lesson_id] = "جيد جداًً";
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
                    $stc->{$lesson_id} = "جيد جداًً";
                    $item->estimation2 = json_encode($stc);

                    $item->save();
                } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 100) {

                    $stc->{$lesson_id} = "ممتاز";
                    $item->estimation2 = json_encode($stc);
                    $item->save();
                }
            }
            // $item = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();

            $result_term2 = 0;
            $count = 0;
            foreach (json_decode($item->result2, true) as $key1 => $value1) {
                $les= Lesson::find($key1);
                 if($les){
                if( $les->is_neutral !=3){
                 $result_term2 = $result_term2 + $value1['term2_result'];
                 $count++;
                }}
                  
             }
             
             $objec_term_result = json_decode($item->term_result, true);
               $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2  : "0";
                  $year_result = (json_decode($item->term_result, true)['term1']
                 +  $objec_term_result['term2']) / 2;

            $item->update([

                'term_result' => json_encode($objec_term_result),
                'year_result' => $year_result,

            ]);

            // return response()->json([
            //     'success'=>'! تمت العملية بنجاح'
            // ]);
            if ($item->estimation) {
                $stc = json_decode($item->estimation, true);
                if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $item->estimation = json_encode($stc);

                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $item->estimation = json_encode($stc);
                    $item->save();
                }
            } else {
                $stc1 = new stdClass;
                if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc1->{$lesson_id} = "ضعيف";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc1->{$lesson_id} = "وسط";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc1->{$lesson_id} = "جيد";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc1->{$lesson_id} = "جيد جداًً";
                    $item->estimation = json_encode($stc1);

                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc1->{$lesson_id} = "ممتاز";
                    $item->estimation = json_encode($stc1);
                    $student_mark->save();
                }
                }
          }
                   }
               }
              
               session()->flash('success', 'تم تعديل  بنجاح');

           return redirect()->back()->with('success', '! تمت العملية بنجاح');
}          
               session()->flash('success', 'تم تعديل  بنجاح');

           return redirect()->back()->with('success', '! تمت العملية بنجاح');
              
   
        
    }
       public function export_exam1($exam_id,$room_id,$lesson_id)
    {
           $lesson=Lesson::find($lesson_id);
          $year=Year::where('current_year','1')->first();
          $term_id=Exams2::find($exam_id)->term_id;
          $term = Term_year::where('id', $term_id)->where('year_id', $year->id)->first();
         
          $exam = Exam_result2::where('exam_id',$exam_id)->where('room_id',$room_id)->get();
        foreach($exam as $item){
            $student[]= $item->user_id;
         }
     

           
                 $student_mark=Students_mark::whereIn('student_id',$student)->where('year_id',$year->id)->get();
                 if($term->type=="1"){
                    
              foreach($student_mark as $item){
            
             foreach($exam as $item1){
                       
                    $report_card=Report_card::where('student_id',$item->student_id)->where('year_id',$year->id)->first();
                    if (isset($report_card) && $report_card->adjustable != 0){
                            session()->flash('error',' لا يمكن التعديل بعد استصدار الجلاء  ' ) ;
                        return redirect()->back()->with('error','  لا يمكن تعديل العلامات بعد استصدار الجلاء !  ') ;
                    }
                    if (auth()->user()->type == 1 && $item->adjustable != 0){
                            session()->flash('error',' لا يمكن التعديل تم تثبيت العلامات من قبل الإدارة  ' ) ;
                        return redirect()->back()->with('error','لا يمكن التعديل   تم تثبيت العلامات من قبل الإدارة   !  ') ;
                    }
                    
                       
                       if($item->student_id	==$item1->user_id){
                            $object1=json_decode($item->mark,true);
                            if($item1->result== null){
                              
                                   $object1[$lesson_id]['exam']="0";
                            }else{
                                if($item1->result > ($lesson->max_mark *0.4) ){
                                                             
                                       session()->flash('error', ' لايمكن الادخال العلامة اكبر من القيمة ');
                        
                                   return redirect()->back()->with('error', '!   لايمكن الادخال  العلامة اكبر من القيمة المحددة');
                                                            
                                }
                                else{
                                     $object1[$lesson_id]['exam']=$item1->result;
                                }
                                   
                            }
             if ($item->worke_degree) {
                $object_worke_degree = json_decode($item->worke_degree, true);
                foreach (json_decode($item->worke_degree) as $key => $item12) {
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

            $object_result2 = json_decode($item->result2, true);
          
            if ($item->result) {
                $decodedData=[];
                $object_result = json_decode($item->result, true);
                $decodedData = json_decode($item->result2, true);
                  if (!$decodedData || !array_key_exists($lesson_id, $decodedData)) {
                        $object_result2[$lesson_id]['term2_result'] = 0;
                    }


                $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);
                $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
            }







           $item->update([
                'student_id' => $item->student_id,
                'room_id' => $room_id,
                'worke_degree' => json_encode($object_worke_degree),
                'mark' => json_encode($object1),
                'result1' => json_encode($object_result1),
                'result' => json_encode($object_result),
                'status' => '1'

            ]);

            if ($item->estimation1) {
                $stc = json_decode($item->estimation1, true);
                if (json_decode($item->result1, true)[$lesson_id]['term1_result'] >= 0 && json_decode($item->result1, true)[$lesson_id]['term1_result'] <= 40) {

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
                    $stc[$lesson_id] = "جيد جداًً";
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
                    $stc->{$lesson_id} = "جيد جداًً";
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
                $les= Lesson::find($key1);
                 if($les){
                if( $les->is_neutral!=3){
                $result_term1 = $result_term1 + $value1['term1_result'];
                $count++;
                 }}
            }
          
            $objec_term_result = json_decode($item->term_result, true);
              $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 : "0";
             
                  $year_result = (json_decode($item->term_result, true)['term1']
                + $objec_term_result['term1'] ) / 2;

            $item->update([
                'term_result' => json_encode($objec_term_result),
                'year_result' => $year_result,


            ]);
            if ($item->estimation) {
                $stc = json_decode($item->estimation, true);
                if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $item->estimation = json_encode($stc);

                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $item->estimation = json_encode($stc);
                    $item->save();
                }
            } else {
                $stc1 = new stdClass;
                if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc1->{$lesson_id} = "ضعيف";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc1->{$lesson_id} = "وسط";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc1->{$lesson_id} = "جيد";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc1->{$lesson_id} = "جيد جداًً";
                    $item->estimation = json_encode($stc1);

                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc1->{$lesson_id} = "ممتاز";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                }
            }
          }
                       
                   }
          }}
          
          
          
          else if($term->type=="2"){
              
               foreach($student_mark as $item){
                  
                   foreach($exam as $item1){
                       
                        $report_card=Report_card::where('student_id',$item->student_id)->where('year_id',$year->id)->first();
                       if (isset($report_card) && $report_card->adjustable != 1){
                session()->flash('error22',' لا يمكن التعديل تأكد من حالة الجلاء ' ) ;
                return redirect()->back()->with('error','  لا يمكن التعديل تأكد من حالة الجلاء    !  ') ;
            }
            if (auth()->user()->type == 1 && $item->adjustable != 1){
                        session()->flash('error22',' لا يمكن التعديل تأكد من حالة الجلاء ' ) ;
                return redirect()->back()->with('error','   لا يمكن التعديل   تم تثبيت العلامات من قبل الإدارة    !  ') ;
            }

          
 if($item->student_id	==$item1->user_id){

            $object2 = json_decode($item->mark2, true);
                      if($item1->result== null){
                              
                                   $object2[$lesson_id]['exam']="0";
                            }else{
                                if($item1->result > ($lesson->max_mark *0.4) ){
                                     
                        session()->flash('error', ' لايمكن الادخال العلامة اكبر من القيمة ');

                        return redirect()->back()->with('error', '!   لايمكن الادخال  العلامة اكبر من القيمة المحددة');
                                    
                                }
                                else{
                                     $object2[$lesson_id]['exam']=$item1->result;
                                }
                                   
                            }

          
            if($item->worke_degree ){
                $object_worke_degree2=json_decode($item->worke_degree,true);
               foreach(json_decode($item->worke_degree) as $key=>$item12){
                 $count=0;
                  if($key !=$lesson_id ) {
                       $count=1;
                       break;
                  }


               }
               if($count==1){
                      $object_worke_degree2[$lesson_id]['term2_result']="null";
               }



                  $object_worke_degree2[$lesson_id]['term2_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];
                     if(isset($object_worke_degree2[$lesson_id]['term1_result']) && $object_worke_degree2[$lesson_id]['term1_result'] !="null"){
               $object_worke_degree2[$lesson_id]['term1_result']=$object_worke_degree2[$lesson_id]['term1_result'];
         }
         else{
            $object_worke_degree2[$lesson_id]['term1_result']="null";
         }

           }
           else{
               //   $object_worke_degree2[$lesson_id]['term1_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];
               $object_worke_degree2[$lesson_id]['term2_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];
           }

            //   if($item->worke_degree){
            //     $object_worke_degree2=json_decode($item->worke_degree,true);
            //   }

            //     $object_worke_degree2[$lesson_id]['term2_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];

            $object_result2 = json_decode($item->result2, true);
            $object_result2[$lesson_id]['term2_quizes'] = ceil($object2[$lesson_id]['oral']) +
                ceil($object2[$lesson_id]['homework']) + ceil($object2[$lesson_id]['activities']) + ceil($object2[$lesson_id]['quize']);
            $object_result2[$lesson_id]['term2_exam'] = ceil($object2[$lesson_id]['exam']);
            $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
            $object_result1 = json_decode($item->result1, true);
            $object_result = json_decode($item->result, true);

            if ($item->result) {
                $object_result = json_decode($item->result, true);


                $decodedData = json_decode($item->result1);

                     if (!$decodedData || !array_key_exists($lesson_id, $decodedData)) {
                        $object_result1[$lesson_id]['term1_result'] = 0;
                    }



                $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
                $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
            }

           
            $item->update([
                'student_id' => $item->student_id,
                'room_id' => $room_id,
                'mark2' => json_encode($object2),
                'result2' => json_encode($object_result2),
                'result' => json_encode($object_result),
                'worke_degree' => json_encode($object_worke_degree2),
                'status' => '1'

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
                    $stc[$lesson_id] = "جيد جداًً";
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
                    $stc->{$lesson_id} = "جيد جداًً";
                    $item->estimation2 = json_encode($stc);

                    $item->save();
                } else if (json_decode($item->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($item->result2, true)[$lesson_id]['term2_result'] <= 100) {

                    $stc->{$lesson_id} = "ممتاز";
                    $item->estimation2 = json_encode($stc);
                    $item->save();
                }
            }
            // $item = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();

            $result_term2 = 0;
            $count = 0;
            foreach (json_decode($item->result2, true) as $key1 => $value1) {
                $les= Lesson::find($key1);
                 if($les){
                if( $les->is_neutral !=3){
                 $result_term2 = $result_term2 + $value1['term2_result'];
                 $count++;
                }}
                  
             }
             
             $objec_term_result = json_decode($item->term_result, true);
               $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2  : "0";
                  $year_result = (json_decode($item->term_result, true)['term1']
                 +  $objec_term_result['term2']) / 2;

            $item->update([

                'term_result' => json_encode($objec_term_result),
                'year_result' => $year_result,

            ]);

            // return response()->json([
            //     'success'=>'! تمت العملية بنجاح'
            // ]);
            if ($item->estimation) {
                $stc = json_decode($item->estimation, true);
                if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $item->estimation = json_encode($stc);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $item->estimation = json_encode($stc);

                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $item->estimation = json_encode($stc);
                    $item->save();
                }
            } else {
                $stc1 = new stdClass;
                if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc1->{$lesson_id} = "ضعيف";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc1->{$lesson_id} = "وسط";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc1->{$lesson_id} = "جيد";
                    $item->estimation = json_encode($stc1);
                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc1->{$lesson_id} = "جيد جداًً";
                    $item->estimation = json_encode($stc1);

                    $item->save();
                } else if (ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($item->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc1->{$lesson_id} = "ممتاز";
                    $item->estimation = json_encode($stc1);
                    $student_mark->save();
                }
                }
          }
                   }
               }
          }
              
               session()->flash('success', 'تم تعديل  بنجاح');

           return redirect()->back()->with('success', '! تمت العملية بنجاح');
              
   
        
   
    


        
    }
      /// المكافئات والعقوبات 
    public function teacher_rewads_and_sanction_class()
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

        $message = Message::where('teacher_id', $teacher_id)->where('type', 1)->where('view', 0)->count();

        $objection = Objection::where('teacher_id', $teacher_id)->where('view', 0)->count();


//notifications
                    $tokens = Studentfcmtoken::where('s_fk',91)->get();

 $devices = array();
        foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);
            //array_push($devices['p_id'], $t['p_fk']);
        }

            // $this->send_notification('title noti mazen','body noti test5555','lesson4444',$devices);


        return view('teachers2.teacher_rewads_and_sanction_class', compact('objection', 'teacher', 'events', 'count', 'count2', 'teacher_name', 'classes', 'message'));
    }
    public function teacher_rewads_and_sanction_subject($room_id, $teacher_id)
    {
        $teacher_name = Auth::user()->name;
        $teacher = Teacher::find($teacher_id);
        //$lessons = $teacher->lessons;
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
        $class = Classe::where('id', $room->class_id);
        $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count2 = $count2->count();
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();

        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();

        return view('teachers2.teacher_rewads_and_sanction_subject', compact('objection', 'teacher_lessons', 'teacher_name', 'room_name', 'message', 'teacher', 'room_id', 'count', 'count2', 'class'));
    }
    public function teacher_rewads_students($room_id, $teacher_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $rewads_students = Rewad_and_sanction_student::where('term_id', $term->id)->where('teacher_id', $teacher_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '1')->get();
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);
        $room = Room::find($room_id);
        $student = $room->student;
        $class=Classe::find($room->class_id);
        $lesson=Lesson::find( $lesson_id);
        $rewads=Rewards_and_sanction::where('type', '1')->get();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();

        return view('teachers2.teacher_rewads_students', compact('rewads','objection','message','rewads_students','room_id' ,'student', 'teacher','room','lesson','class','lesson_id'));
    }
    public function teacher_rewads_students_store(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $rewads = new Rewad_and_sanction_student();
        $rewads->teacher_id=auth()->user()->teacher_id;
        $rewads->student_id=$request->student_id;
        $rewads->term_id=$term->id;
        $rewads->room_id=$request->room_id;
        $rewads->lesson_id=$request->lesson_id;
        $rewads->class_id=$request->class_id;
        $rewads->type=$request->type;
        $rewads->rewad_and_sanction_id=$request->rewad_and_sanction_id;
        $rewads->save();
        $rewad_and_sanction_id=Rewards_and_sanction::find($request->rewad_and_sanction_id);
        $noti = new Notification;
        $noti->user_id = Auth::user()->id;
        $noti->student_id = $request->student_id;
        $noti->room_id = $request->room_id;
        $noti->title ="تم منحك وسام";
        $noti->body = $rewad_and_sanction_id->name;
        $noti->term_id = $term->id;
        $noti->type = 3;
        $noti->save();
        $tokens = Studentfcmtoken::where('s_fk',$request->student_id)->get();

         $devices = array();
         foreach($tokens as $t){
        array_push($devices, $t['s_fcm_token']);
        //array_push($devices['p_id'], $t['p_fk']);
            }
        $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,'null', 'null',$devices);
        session()->flash('Add', 'تم تعديل  بنجاح');
        return redirect()->back()->with('Add', '! تمت العملية بنجاح');

    }

    public function teacher_rewads_students_delete(Request $request){

        $rewards_and_sanction= Rewad_and_sanction_student::find($request->id);
        $rewards_and_sanction->delete();
        session()->flash('success', ' تم الحذف بنجاح');
        return redirect()->back();
    }
    public function teacher_sanction_students($room_id, $teacher_id, $lesson_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $rewads_students = Rewad_and_sanction_student::where('term_id', $term->id)->where('teacher_id', $teacher_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '2')->get();
        $lesson = Lesson::find($lesson_id);
        $teacher = Teacher::find($teacher_id);
        $room = Room::find($room_id);
        $student = $room->student;
        $class=Classe::find($room->class_id);
        $lesson=Lesson::find( $lesson_id);
        $rewads=Rewards_and_sanction::where('type', '2')->get();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();

        return view('teachers2.teacher_sanction_students', compact('rewads','objection','message','rewads_students','room_id' ,'student', 'teacher','room','lesson','class','lesson_id'));
    }
}
