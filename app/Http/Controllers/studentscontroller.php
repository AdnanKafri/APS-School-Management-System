<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Report_card;
use App\Report_card_details;
use App\Base_subjects;
use App\Classe;
use App\Day;
use App\Exam_result;
use App\Exam_result2;
use App\Exam_file;
use Illuminate\Support\Facades\Session;
use App\Lecture;
use App\Lecture_time;
use App\Lesson;
use App\Studentfcmtoken;
use App\Student_vaccine;
use App\Term_year;
use App\Transport_invoice;
use App\Google_meet;
use App\Lesson_room_teacher_lecture_time;
use App\Lesson_teacher_room_term_exam;
use App\Room;
use App\Room_student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Message;
use App\Question;
use App\Schedule;
use App\Teacher_event;
use App\About_us;
use App\Student_detail;
use App\Objection;
use App\Student;
use App\Exams2;
use App\Student_lesson_teacher_room_term_exam;
use App\Student_schedule_tracer;
use App\Students_mark;
use App\Teacher;
use App\Teacher_room_lesson;
use App\User;
use App\Certificate;
use App\Term;
use App\Modification_Request;
use App\Certificate_Fields;
use App\Year;
use App\Image_Invoice;
use App\Medal;
use App\Class_cost;
use App\Notification;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Support\Facades\DB;
use App\Exam_result_tester;
//electronic section
use App\Electronic_file;
use App\Electronic_section;
use App\Super_file;
use App\Rewards_and_sanction;
use App\Rewad_and_sanction_student;
use App\Exam_question;
use App\School_data;
class studentscontroller extends Controller
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


    public function create()
    {

        return view('login_student');
    }
     //اقسام المكتبة الالكترونية
    // public function electronic_sections(){

    //     $electronic_sections= Electronic_section::all();
    //     $student_id = auth()->user()->student_id ;
    //     $year=Year::where('current_year','1')->first();
    //     $student=Student::with('details')->find($student_id);
    //     $item=Room_student::where('student_id',$student_id)->where('year_id',$year->id)->first();
    //     if ($item=="") {
    //     return redirect()->back();
    //  }
    //     $room=Room::with('classes')->where('id',$item->room_id)->first();
    //     $room_id = $room->id ;

    //     return view('students.electronic_sections', compact('electronic_sections','student','year'
    // ,'room','room_id'));

    // }
     public function electronic_sections()
{
    $student_id = auth()->user()->student_id;
    $year = Year::where('current_year', '1')->first();
    $student = Student::with('details')->find($student_id);
    $item = Room_student::where('student_id', $student_id)->where('year_id', $year->id)->first();

    if (!$item) {
        return redirect()->back();
    }

    $room = Room::with('classes')->where('id', $item->room_id)->first();
    $room_id = $room->id;

    // Retrieve electronic sections based on the class_id of the student
    $electronic_sections = Electronic_section::where('class_id', $room->class_id)->get();

    return view('students.electronic_sections', compact('electronic_sections', 'student', 'year', 'room', 'room_id'));
}
    
    //ملفات الاقسام الالكترونية
    public function student_electronic_files(Request $request, $id)
    {
    $student_id = auth()->user()->student_id ;
    $year=Year::where('current_year','1')->first();
    $student=Student::with('details')->find($student_id);
    $item=Room_student::where('student_id',$student_id)->where('year_id',$year->id)->first();
    if ($item=="") {
    return redirect()->back();
    }
    $room=Room::with('classes')->where('id',$item->room_id)->first();
    $room_id = $room->id ;

    $electronic_sections = Electronic_section::find($id);
    $electronic_files = Electronic_file::where('section_id', $id)->get();
    return view('students.electronic_section_files', compact('electronic_sections', 'electronic_files','student','year'
    ,'room','room_id'));
}

    //book student
     public function books_student($id){
        $student_id = auth()->user()->student_id ;
        $year=Year::where('current_year','1')->first();
        $student=Student::with('details')->find($student_id);
        $item=Room_student::where('student_id',$student_id)->where('year_id',$year->id)->first();
                if ($item=="") {
            return redirect()->back();
        }

        //  $room = Room::with('lessons3')->find($item->room_id);
         $room=Room::with('classes')->where('id',$item->room_id)->first();
         $room_id = $room->id ;
        // $lessons= $room->teachers;
            $lessons=Room::with(['lessons'=>function($q){
            $q->with('teachers');
        }])->find($room->id);
        $lessons = $lessons->lessons ;
        $classes = Classe::where('id',$id)->with('lessons')->first();
        $school_data = School_data::first();
        return view('students.books',compact('school_data','classes','student_id',
        'student',
        'year','room',
        'room_id'));

    }

    public function student_admin_message()
    {
        $year = Year::where('current_year', '1')->first();
         $student_id = Auth::user()->student_id;

        $student = Student::find($student_id);
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        if ($room) {
            $room_id = $room->id;
        } else {
            $room_id = "";
            // session()->flash('error', ' ! لايوجد رسائل    ');
            // return redirect()->back()->with('error','!  لايوجد رسائل  ');
        }
        $year = DB::table('years')->where('current_year', '1')->first();

        $messages = Message::where('student_id', $student->id)->where('admin_id', "!=", null)->where('year_id', $year->id)
            ->get();

        foreach ($messages  as $item) {

            if ($item->type == 0) {
                $item->view = 1;
                $item->save();
            }
        }
        $school_data = School_data::first();

        return view('students.student_admin_message', compact('school_data','student', 'room', 'room_id', 'messages'));
    }
    public function add_mes(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $message = new Message;
        $message->year_id = $year->id;
        $message->admin_id = 1;
        $message->message = $request->message;
        $message->student_id = Auth::user()->student_id;
        $message->type = 1;

        $message->save();
        return redirect()->back();
    }


    // public function dashboard(){
    //     $student_id=Auth::user()->student_id;

    //     $student=Student::find($student_id);
    //     $count=Message::whereNull('view')->where('student_id',auth()->user()->student_id)->get();

    //     $count=$count->count();
    //     $year=Year::where('current_year','1')->first();

    //     $room=$student->room()->where('rooms.year_id',$year->id)->first();
    //     $class=$room->classes;
    //     // return 13 ;
    //     return view('students.new_profile',compact('student','count','room','class'));
    //     // return view('students.new_subjects',compact('student','count','room','class'));
    // }

    public function profile($student_id, $room_id)
    {
        $student = Student::with('details')->findOrFail($student_id);
        $school_data = School_data::first();
        return view('students.new_profile', compact('school_data','student', 'room_id'));
    }
    
    
        public function medical_profile($room_id,$student_id)
    {
        $student = Student::with('details')->findOrFail($student_id);
        $school_data = School_data::first();
        return view('students.medical_profile', compact('school_data','student','room_id'));
    }
    
    
            public function transport($room_id,$student_id)
    {
        
                $year = Year::where('current_year', '1')->first();

           $student = Student::with('details','bus.bus_lines','bus.bus_driver','bus.bus_supervisor','transport_invoices')->findOrFail($student_id);
        $school_data = School_data::first();
        
               $sum_invoices=Transport_invoice::with('student')->where('student_id',$student_id)->where('year_id',$year->id)->sum('invoice_amount');
               if($student->bus){
                                     $remain_invoices= $student->bus->bus_lines->annual_cost-$sum_invoices;

               }else{
                   $remain_invoices=0;
               }
             
        return view('students.transport', compact('school_data','student','room_id','sum_invoices','remain_invoices'));
    }
    
            public function medical_profile_details ($type)
    { 
        $year = Year::where('current_year', '1')->first();

        $student = Student::with('details')->findOrFail(auth()->user()->student_id);
         $room_id = $student->room()->where('rooms.year_id',$year->id)->first()->id;
        $school_data = School_data::first();
          $before_vaccines=Student_vaccine::where('student_id',$student->id)->first();
                    $current_vaccines=Student_vaccine::where('student_id',$student->id)->first();
          $old_illness=Student_vaccine::where('student_id',$student->id)->first();
          $current_illness=Student_vaccine::where('student_id',$student->id)->first();
          if($before_vaccines){
        $before_vaccines=Student_vaccine::where('student_id',$student->id)->first()->before_vaccines;

          }
          
                    if($before_vaccines){
                    $current_vaccines=Student_vaccine::where('student_id',$student->id)->first()->current_vaccines;

          }
          
                    if($before_vaccines){
          $old_illness=Student_vaccine::where('student_id',$student->id)->first()->old_illness;

          }
          
                    if($before_vaccines){
          $current_illness=Student_vaccine::where('student_id',$student->id)->first()->current_illness;

          }
          
          
      

         switch($type) {
             
        // اللقاحات قبل المدرسة        
            case('1'):
                return view('students.medical.1',compact('school_data','student','room_id','before_vaccines'));
            break;
    //   اللقاحات اثناء الدراسة
            case('2'):
                return view('students.medical.2',compact('school_data','student','room_id','current_vaccines'));
            break;
            
        // الأمراض و الاوبئة السابقة
        case('3'):
                return view('students.medical.3',compact('school_data','student','room_id','old_illness'));

        break;
        
        
        // الامراض الطارئة
        case('4'):
                return view('students.medical.4',compact('school_data','student','room_id','current_illness'));

        break;

            
            }
 
    }
    
    
    public function profile_store(Request $request)
    {
        // return $request ;
        //   $this->validate($request, [
        //    'personal_image'  => 'required|image|dimensions:max_width=150//,max_height=150',

       // ],[
         //   'personal_image.required' => 'يرجى ادخال الصورة بأبعاد 150*150',
      //  ]);

        $user = User::where('student_id', $request->student_id)->first();
        $student = Student::findOrFail($request->student_id);
        $student_detail = Student_detail::where('student_id', $request->student_id)->first();
        if ($request->personal_image != null) {
            $student->image = $request->personal_image->store('filesstudents', 'public');
            $student->save();
        }

        if (isset($request->password)) {

            $this->validate($request, [
                'old_password' => 'required',
            ], [
                'old_password.required' => 'يرجى ادخال كلمة السر  القديمة',
            ]);


            if (Hash::check($request->old_password, $user->password)) {

                // $this->validate($request,[
                //     'password' => 'confirmed|max:20|different:old_password',
                // ],[
                //     'password.different' =>'كلمة السر الجديدة مطابقة للقديمة ',
                //     'password.confirmed' =>'كلمة السر غير متطابقة',
                // ]);

                $user->password = Hash::make($request->password);
                $user->view_password = $request->password;
                $user->save();
            } else {
                $request->session()->flash('error', 'Password does not match');
                return redirect()->back()->with('error', 'كلمة السر غير صحيحة');
            }
        }
        $student->save();
        $room_id = $request->room_id;
        $school_data = School_data::first();
        Session::flash('success', 'تم التعديل بنجاح');
        return view('students.new_profile', compact('school_data','student', 'room_id'));
    }

    public function update_profile(Request $request, $student_id)
    {
        // return $request;
        $student = Student::find($student_id);

        if ($request->image != null) {
            Storage::disk('public')->delete($student->image);
            $student->image = $request->image->store('filesstudents', 'public');
        }
        if ($request->last_certificate_image != null) {
            Storage::disk('public')->delete($student->last_certificate_image);
            $student->last_certificate_image = $request->last_certificate_image->store('filesstudents', 'public');
        }
        // if ($request->certificateImage != null) {
        //     Storage::disk('public')->delete($student->certificateImage);
        //     $student->certificateImage=$request->certificateImage->store('filesstudents','public');
        // }

        $student->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }



    public function update_password(Request $request, $student_id)
    {

        // return $teacher_id;
        $user = User::find($student_id);
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




    public function lessons()
    {

        $student_id = auth()->user()->student_id;
        $year = Year::where('current_year', '1')->first();
        $student = Student::with('details')->find($student_id);
        $item = Room_student::where('student_id', $student_id)->where('year_id', $year->id)->first();
        if ($item == "") {

            return redirect()->back();
        }

        //  $room = Room::with('lessons3')->find($item->room_id);
        $room = Room::with('classes')->where('id', $item->room_id)->first();
        $room_id = $room->id;
        // $lessons= $room->teachers;
        $lessons = Room::with(['lessons' => function ($q) {
            $q->with('teachers');
        }])->find($room->id);

        $lessons = $lessons->lessons;
        if ($student->lang == '0' && $student->religion == '0') {

            $lessons = $room->lessons()->where(
                function ($query) {
                    $query->where(function ($q1) {

                        $q1->where('religion', '<>', '1');
                        $q1->orwhere('religion', null);
                        $q1->where('lang', null);
                    });

                    $query->orwhere(function ($q2) {

                        $q2->where('lang', '<>', '1');

                        $q2->orwhere('lang', null);
                        $q2->where('religion', null);
                    });
                }
            )->get();
        } elseif ($student->lang == '1' && $student->religion == '1') {

            $lessons = $room->lessons()->where(
                function ($query) {
                    $query->where(function ($q1) {

                        $q1->where('religion', '<>', '0');
                        $q1->orwhere('religion', null);
                        $q1->where('lang', null);
                    });

                    $query->orwhere(function ($q2) {

                        $q2->where('lang', '<>', '0');

                        $q2->orwhere('lang', null);
                        $q2->where('religion', null);
                    });
                }
            )->get();
        } elseif ($student->religion == '0' && $student->lang == '1') {

            $lessons = $room->lessons()->where(
                function ($query) {
                    $query->where(function ($q1) {

                        $q1->where('religion', '<>', '1');
                        $q1->orwhere('religion', null);
                        $q1->where('lang', null);
                    });

                    $query->orwhere(function ($q2) {

                        $q2->where('lang', '<>', '0');

                        $q2->orwhere('lang', null);
                        $q2->where('religion', null);
                    });
                }
            )->get();
        } elseif ($student->religion == '1' && $student->lang == '0') {


            $lessons = $room->lessons()->where(
                function ($query) {
                    $query->where(function ($q1) {

                        $q1->where('religion', '<>', '0');
                        $q1->orwhere('religion', null);
                        $q1->where('lang', null);
                    });

                    $query->orwhere(function ($q2) {

                        $q2->where('lang', '<>', '1');

                        $q2->orwhere('lang', null);
                        $q2->where('religion', null);
                    });
                }
            )->get();
        }

        $count = Message::whereNull('view')->where('student_id', auth()->user()->student_id)->get();

        $count = $count->count();

        // $lessons5 = [];
        // return $lessons ;
        //  foreach ($lessons as $lesson) {
        //     $lessons5[] = $lesson;
        // }
        // $lessons = json_encode(json_decode($lessons,true)) ;
        $lessons = $lessons->unique();

        // return $lessons ;
        $class = $room->classes;
        $school_data = School_data::first();

        $events = Teacher_event::with('teacher')->where('room_id', $room->id)->get();
        return view('students.new_subjects', compact('events', 'room', 'count', 'lessons', 'student', 'class', 'room_id','school_data'));
        // return view('students.new_courses',compact('room','count','lessons','student','class'));
    }
    public function objection_store(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->where('type', $request->term_id)->first();

        $objection = new Objection();

        $objection->student_id = auth()->user()->student_id;
        $objection->teacher_id = $request->teacher_id;
        $objection->lesson_id = $request->lesson_id;
        $objection->room_id = $request->room_id;
        $objection->note = $request->note;
        $classes_id = Room::find($request->room_id)->class_id;
        $objection->classes_id = $classes_id;
        $objection->view = 0;
        $objection->type = 0;
        $objection->term_id = $term->id;
        $objection->save();
        return redirect()->back();
    }
    public function objection($room_id)
    {

        $student = Student::find(auth()->user()->student_id);
        $objection2 = Objection::where("student_id", auth()->user()->student_id)->get();
        $lessons = Room::with(['lessons' => function ($q) {
            $q->with('teachers');
        }])->find($room_id);

        $lessons = $lessons->lessons;
        $lessons = $lessons->unique();

        return view('students.student_objection', compact('objection2', 'student', 'room_id', 'lessons'));
    }
    public function certificates($room_id)
    {
        $student = Student::find(auth()->user()->student_id);
        $certificates = Certificate::where("student_id", auth()->user()->student_id)->get();
        return view('students.student_certificates', compact('certificates', 'student', 'room_id'));
    }
    public function certificates_stor(Request $request)
    {

        $certificates = Certificate::find($request->id);
        $certificates->certificate = $request->certi;
        $certificates->save();
        return redirect()->back();
    }

    public function getteacher($lesoon_id)
    {
        $t_lesson = Teacher_room_lesson::with('teachers')->where('lesson_id', $lesoon_id)->get();
        $tech = [];
        foreach ($t_lesson as $item) {
            $tech[] = $item->teacher_id;
        }
        $teacher = Teacher::whereIn('id', $tech)->get();
        return $teacher;
    }
    public function student_exams($room_id, $student_id)
    {
        $years = Year::where('current_year', '1')->first();
        $term1 = Term_year::where('current_term', 1)->first();

        $student = Student::with('details')->findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();

        $exams = Lesson_teacher_room_term_exam::where('room_id', $room_id)->where('term_id', $term1->id)->whereIn('type', ['2', '3'])->orderBy('created_at', 'asc')->where('type_file', 2)->with('lesson2')->get();
        foreach ($exams  as $item) {
            $timestamp = strtotime($item->start_time);
            $day = date('l', $timestamp);
            $day = $this->getDay($day);
            $item->day = $day;
            $start_time = Carbon::parse($item->start_time);
            $end_time = Carbon::parse($item->end_time);
            $totalDuration = $start_time->diffInSeconds($end_time);
            $item->period =  gmdate('H:i:s', $item->period  * 60);
        }
        // return $exams ;

        return view('students.new_student_exams', compact('exams', 'room_name', 'class_name', 'student', 'now', 'room_id'));
    }
    public function student_main_exams($room_id, $student_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $student = Student::with('details')->findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();

        $exams_id = Exam_result2::where('room_id', $room_id)->where('user_id', $student_id)->where('type', '1')->pluck('exam_id');


        $exams = Exams2::where('term_id', $term->id)->whereIn('id', $exams_id)->where('type', '1')->orderBy('created_at', 'asc')->with(['lesson' => fn ($q) => $q->select('name', 'lessons.id')])->get();
        foreach ($exams  as $item) {
            $timestamp = strtotime($item->start_date);
            $day = date('l', $timestamp);
            $day = $this->getDay($day);
            $item->day = $day;
            $start_date = Carbon::parse($item->start_date);
            $end_date = Carbon::parse($item->end_date);
            $totalDuration = $start_date->diffInSeconds($end_date);
            $item->period =  gmdate('H:i:s',  $item->period * 60);

            if ($item->is_file == 1) {
                $exam_file = Exam_file::where('student_id', $student_id)->where('exam_id', $item->id)->first();
            }
            $exam_result = Exam_result2::where('user_id', $student->id)->where('exam_id', $item->id)->first();

            // هذا العنصر لمعرفة اذا كان الطالب دخل الى الامتحان لكن خرج منه و لم يقم بانهائه
            if ($exam_result->start_time != null && $exam_result->status != '1') {
                $item->not_terminate = '1';
            } else {
                $item->not_terminate = '0';
            }

            if (isset($exam_result) && $exam_result->status == '1' && $exam_result->show_result == 1) {
                $item->result = $exam_result->result;
            } else if (isset($exam_result) && $exam_result->status == '1' && $exam_result->show_result == 0) {
                $item->result = -1;
            }

            //exam start ability
            if (isset($exam_result) && isset($exam_result->end_time) && (Carbon::now()->subMinutes(1) >=  $exam_result->end_time)) {
                $item->start_exam = 0; // الامتحان قيد التصحيح
            } else {
                $item->start_exam = 1;
            }
        }

        $class = Classe::find($room->class_id);
        $school_data = School_data::first();
        return view('students.new_student_exams', compact('school_data','exams', 'room_name', 'class_name', 'student', 'now', 'room_id', 'class'));
    }



    public function student_main_quizes($room_id, $student_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $student = Student::with('details')->findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();


        $exams_id = Exam_result2::where('room_id', $room_id)->where('user_id', $student_id)->where('type', '2')->pluck('exam_id');

        $exams = Exams2::where('term_id', $term->id)->whereIn('id', $exams_id)->where('type', '2')->orderBy('created_at', 'asc')->with(['lesson' => fn ($q) => $q->select('name', 'lessons.id')])->get();

        foreach ($exams  as $item) {
            $timestamp = strtotime($item->start_date);
            $day = date('l', $timestamp);
            $day = $this->getDay($day);
            $item->day = $day;
            $start_date = Carbon::parse($item->start_date);
            $end_date = Carbon::parse($item->end_date);
            $totalDuration = $start_date->diffInSeconds($end_date);
            $item->period =  gmdate('H:i:s', $item->period * 60);

            $exam_result = Exam_result2::where('user_id', $student->id)->where('exam_id', $item->id)->first();

            // هذا العنصر لمعرفة اذا كان الطالب دخل الى الامتحان لكن خرج منه و لم يقم بانهائه
            if ($exam_result->start_time != null && $exam_result->status != '1') {
                $item->not_terminate = '1';
            } else {
                $item->not_terminate = '0';
            }

            if (isset($exam_result) && $exam_result->status == '1' && $exam_result->show_result == 1) {
                $item->result = $exam_result->result;
            } else if (isset($exam_result) && $exam_result->status == '1' && $exam_result->show_result == 0) {
                $item->result = -1;
            }

            //exam start ability
            if (isset($exam_result) && isset($exam_result->end_time) && (Carbon::now()->subMinutes(2) >=  $exam_result->end_time)) {
                $item->start_exam = 0; // الامتحان قيد التصحيح
            } else {
                $item->start_exam = 1;
            }
        }
        $class = Classe::find($room->class_id);

        $school_data = School_data::first();
        return view('students.new_student_quizes', compact('school_data','exams', 'room_name', 'class_name', 'student', 'now', 'room_id', 'class'));
    }

    public function student_schedule($room_id, $student_id, $time_zone_offset)
    {

        $user_id = auth()->user()->id;
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);

        $student = Student::with('details')->findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $lessons = $room->lessons2;
        // return $lessons ;



        // pring difference between GMT and Damascus
        $damas_diff_time_zone = About_us::first()->time_zone;
        // $time_zone_offset = 60 ;
        $time_zone_offset = $damas_diff_time_zone - $time_zone_offset;

        // pring lecture_tims
        $lecture_times = Lecture_time::where('room_id', $room->id)->get();
        foreach ($lecture_times as $lecture_time) {

            $lecture_time->start_time = \Carbon\Carbon::parse($lecture_time->start_time);
            $lecture_time->end_time = \Carbon\Carbon::parse($lecture_time->end_time);
            $lecture_time->start_time->addMinute($time_zone_offset)->format('H:i:s');
            $lecture_time->end_time->addMinute($time_zone_offset)->format('H:i:s');
        }
        // pring days .
        $days = Day::all();
        // pring romm schedule

        $schedule = collect();

        foreach ($days  as $day) {

            $schedule_day = Lesson_room_teacher_lecture_time::with('lesson', 'teacher')
                ->where('room_id', $room_id)->where('day_id', $day->id)->get();

            // $schedule_day[] = $day->name;
            if ($day->id == $today + 1) {

                $student_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::today())->where('user_id', $user_id)->get();

                foreach ($schedule_day  as $key => $today_lecture) {

                    $tracer =  $student_schedule_tracer->where('lecture_time_id', $today_lecture->lecture_time_id);
                    if (!blank($tracer)) {
                        $today_lecture->attendance = true;
                    } else {
                        $today_lecture->attendance = false;
                    }

                    $lecture_time = Lecture_time::findOrFail($today_lecture->lecture_time_id);
                    // $hourMin = \Carbon\Carbon::parse(date('H:i') );
                    // $hourMin = $hourMin->addMinute(60)->format("H:i");
                    $hourMin = date('H:i');
                    if ($hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time) {
                        $today_lecture->inter = true;
                    } else {
                        $today_lecture->inter = false;
                    }
                }
            }

            foreach ($schedule_day  as $key => $today_lecture) {
                // if (!is_object($today_lecture))
                // continue;
                $lesson = Lesson::findOrFail($today_lecture->lesson_id);

                if ($lesson->lang != $student->lang && $lesson->lang != null) {

                    unset($schedule_day[$key]);
                } else if ($lesson->religion != $student->religion && $lesson->religion != null) {

                    unset($schedule_day[$key]);
                }
            }

            $schedule->push($schedule_day);
        }
        // return [$lecture_times,$schedule] ;

        // // pring student schedule tracer
        // $student_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::today())->
        // where('user_id',$user_id)->get();
        // $today_lectures = $schedule->where('day_id',$today +1) ;
        // foreach($today_lectures  as $key => $today_lecture){
        //     $tracer =  $student_schedule_tracer->where('lecture_time_id',$today_lecture->lecture_time_id);
        //         if (!blank($tracer)){
        //              $today_lecture->attendance = true;
        //         }else {
        //             $today_lecture->attendance = false;
        //         }
        //     $lecture_time = Lecture_time::findOrFail($today_lecture->lecture_time_id);
        //     $hourMin = date('H:i');
        //         if ( $hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time){
        //             $today_lecture->inter = true;
        //         }else{
        //             $today_lecture->inter = false;
        //         }
        //     $lesson = Lesson::findOrFail($today_lecture->lesson_id);
        //     // if (($lesson->lang != $student->lang || $lesson->religion !=  $student->religion) && ($lesson->lang != null ||  $lesson->religion != null) )
        //     //     unset($today_lectures->today_lecture);

        //         if ( $lesson->lang != $student->lang && $lesson->lang != null){
        //             unset($today_lectures[$key]);
        //         } else if ( $lesson->religion != $student->religion && $lesson->religion != null){
        //             unset($today_lectures[$key]);
        //         }

        //     // $google_meet =  Google_meet::where('lecture_time_id',$today_lecture->lecture_time_id)->
        //     //     where('lesson_id',$today_lecture->lesson_id)->
        //     //     where('room_id',$today_lecture->room_id)->
        //     //     where('day_id',$today_lecture->day_id)->
        //     //     where('meeting_date',now()->format('Y/m/d'))->first();

        //     //     // return [$google_meet,$today_lecture]    ;
        //     //     if (!blank($google_meet)){
        //     //          $today_lecture->google_meet = $google_meet->meeting_link;
        //     //     }else {
        //     //         $today_lecture->google_meet = false;
        //     //     }
        // }

        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();
        $class = Classe::find($room->class_id);
        $school_data = School_data::first();

        return view('students.new_student_schedule', compact('school_data','room_name', 'day', 'class_name', 'student', 'now', 'room_id', 'lessons', 'lecture_times', 'days', 'schedule', 'today', 'class'));
    }

    // public function student_schedule($room_id,$student_id,$time_zone_offset)
    // {
    //     // return $student_id ;
    //     $user_id = auth()->user()->id ;
    //     $timestamp = strtotime(now());
    //     $today = date('l', $timestamp);
    //     $today = $this->getDay($today);

    //     $student = Student::with('details')->findOrFail($student_id);
    //     $room = Room::findOrFail($room_id);
    //     $lessons = $room->lessons2 ;
    //     // pring difference between GMT and Damascus
    //     $damas_diff_time_zone = About_us::first()->time_zone ;
    //     // $time_zone_offset = 60 ;
    //     $time_zone_offset = $damas_diff_time_zone - $time_zone_offset ;

    //     // pring lecture_tims
    //     $lecture_times = Lecture_time::where('class_id',$room->class_id)->orderBy('start_time','asc')->get();
    //      foreach($lecture_times as $lecture_time){
    //         $lecture_time->start_time = \Carbon\Carbon::parse($lecture_time->start_time );
    //         $lecture_time->end_time = \Carbon\Carbon::parse($lecture_time->end_time );
    //         $lecture_time->start_time->addMinute($time_zone_offset);
    //         $lecture_time->end_time->addMinute($time_zone_offset);
    //     }
    //       // pring days
    //     $days = Day::all();
    //     // pring romm schedule
    //     $schedule = Lesson_room_teacher_lecture_time::with('lesson','teacher')
    //     ->where('room_id',$room_id)->get();

    //     // pring student schedule tracer
    //     $student_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::today())->
    //     where('user_id',$user_id)->get();
    //     $today_lectures = $schedule->where('day_id',$today +1) ;
    //     foreach($today_lectures  as $key => $today_lecture){
    //         $tracer =  $student_schedule_tracer->where('lecture_time_id',$today_lecture->lecture_time_id);
    //             if (!blank($tracer)){
    //                  $today_lecture->attendance = true;
    //             }else {
    //                 $today_lecture->attendance = false;
    //             }
    //         $lecture_time = Lecture_time::findOrFail($today_lecture->lecture_time_id);
    //         $hourMin = date('H:i');
    //             if ( $hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time){
    //                 $today_lecture->inter = true;
    //             }else{
    //                 $today_lecture->inter = false;
    //             }

    //     }
    //     // return $today_lectures ;
    //     $room_name = $room->name;
    //     $room_id = $room->id;
    //     $class_name =  $room->classes->name ;
    //     $now=Carbon::now();

    //     return view('students.new_student_schedule',compact('room_name','class_name','student','now','room_id','lessons','lecture_times','days','schedule','today'));
    // }


    public function go_to_stream($scheduler_id, $day_id, $lecture_time_id, $room_id, $student_id)
    {
        $user_id = auth()->user()->id;
        $scheduler_record = Lesson_room_teacher_lecture_time::findOrFail($scheduler_id);

        $day = Day::findOrFail($day_id);
        $lecture_time = Lecture_time::findOrFail($lecture_time_id);

        // $hourMin = \Carbon\Carbon::parse(date('H:i') );
        // $hourMin = $hourMin->addMinute(60)->format("H:i");
        $hourMin = date('H:i');
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
        $student = Student::findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $google_meet_url = $scheduler_record->meeting_link;
        redirect()->to($google_meet_url)->send();
        // return view('students.new_student_stream',compact('room_name','room_id','class_name','student','room'));
    }

    // for teacher
    public function teacher_schedule($student_id, $room_id, $teacher_id)
    {
        // return $student_id ;
        $user_id = auth()->user()->id;

        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);

        $student = Student::findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $lessons = $room->lessons2;
        // pring teachers

        // pring lecture_tims
        $lecture_times = Lecture_time::all();
        // pring days
        $days = Day::all();
        // pring teacher schedule
        $schedule = Lesson_room_teacher_lecture_time::with('lesson')->with(['room.classes' => function ($query) {
                $query->select("id", "name");
            }])
            ->where('teacher_id', $teacher_id)->get();

        // pring student schedule tracer
        $student_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::today())->where('user_id', $user_id)->get();
        $today_lectures = $schedule->where('day_id', $today + 1);
        // return $today_lectures  ;
        foreach ($today_lectures  as $key => $today_lecture) {
            $tracer =  $student_schedule_tracer->where('lecture_time_id', $today_lecture->lecture_time_id);
            if (!blank($tracer)) {
                $today_lecture->attendance = true;
            } else {
                $today_lecture->attendance = false;
            }
        }
        // return $today_lectures ;
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();

        return view('students.new_teacher_schedule', compact('room_name', 'class_name', 'student', 'now', 'room_id', 'lessons', 'lecture_times', 'days', 'schedule', 'today'));
    }



    public function set_schedule($room_id, $student_id)
    {
        // return $student_id ;

        $student = Student::findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $lessons = $room->lessons2;
        // pring teachers
        $teachers = DB::table('teachers')
            ->select('id', 'first_name', 'last_name')
            ->get();

        // pring lecture_tims
        $lecture_times = Lecture_time::all();
        // pring days
        $days = Day::all();
        // pring romm schedule
        $schedule = Lesson_room_teacher_lecture_time::with('lesson', 'teacher')
            ->where('room_id', $room_id)->get();

        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();

        return view('students.new_admin_set_schedule', compact('room_name', 'class_name', 'student', 'now', 'room_id', 'lessons', 'lecture_times', 'days', 'schedule', 'teachers'));
    }
    public function student_schedule_old($room_id, $student_id)
    {
        // return $student_id ;
        $student = Student::findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $lessons = $room->lessons2;
        $teacher_name = '';
        // put the teacher with lesson depending on room
        foreach ($lessons as $lesson) {
            $teacher_room_lesson = Teacher_room_lesson::where('lesson_id', $lesson->id)
                ->where('room_id', $room->id)->first();
            if (isset($teacher_room_lesson)) {
                $teacher = Teacher::findOrFail($teacher_room_lesson->teacher_id);
                $teacher_id = $teacher->id;
                $teacher_name = $teacher->first_name . ' ' . $teacher->last_name;
            }
            $lesson->teacher_name = $teacher_name;
        }
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();

        $schedule = Schedule::where('room_id', 9000)->first();
        $schedule->saturday = json_decode($schedule->saturday, true);
        $schedule->sunday = json_decode($schedule->sunday, true);
        $schedule->monday = json_decode($schedule->monday, true);
        $schedule->tuesday = json_decode($schedule->tuesday, true);
        $schedule->wednesday = json_decode($schedule->wednesday, true);
        $schedule->thursday = json_decode($schedule->thursday, true);
        // return $schedule->saturday ;
        return view('students.new_student_schedule2', compact('room_name', 'class_name', 'student', 'now', 'room_id', 'lessons', 'schedule'));
    }


    public function  save_schedule(Request $request)
    {
        // return $request ;
        $this->validate($request, [
            'teacher_id' => 'required',
            'room_id' => 'required',
            'lesson_id' => 'required',
            'day_id' => 'required',
            'lecture_time_id' => 'required',
        ], [
            'teacher_id.required' => 'يرجى تحديد المدرس',
            'room_id.required' => 'يرجى تحديد الشعبة',
            'lesson_id.required' => 'يرجى تحديد المادة',
            'day_id.require' => 'يرجى تحديد اليوم',
            'lecture_time_id.required' => 'يرجى تحديد الحصة',

        ]);

        $item =  Lesson_room_teacher_lecture_time::where('teacher_id', $request->teacher_id)
            ->where('lecture_time_id', $request->lecture_time_id)->where('day_id', $request->day_id)->first();
        if (isset($item) && $item->room_id != $request->room_id) {
            // return redirect()->bach()-with('warning','  هذا التوقيت غير متاح لدى الاستاذ حصة اخرى');
            return response()->json([
                'status' => false,
                'msg' => 'error message',
            ]);
        }
        $item = new Lesson_room_teacher_lecture_time;
        $item->lesson_id = $request->lesson_id;
        $item->room_id = $request->room_id;
        $item->teacher_id = $request->teacher_id;
        $item->lecture_time_id = $request->lecture_time_id;
        $item->day_id = $request->day_id;
        $item->save();
        // return redirect()->bach()-with('success',' تم التخزين  بنجاح ');
        return response()->json([
            'status' => true,
            'msg' => ' تم التخزين بنجاح',
        ]);
    }


    public function  save_schedule_old(Request $request)
    {
        $schedule = Schedule::where('room_id', 9000)->first();

        if (!isset($schedule)) {
            $schedule = new Schedule;
            $schedule->saturday = json_encode($request->schedule[0]);
            $schedule->sunday = json_encode($request->schedule[1]);
            $schedule->monday = json_encode($request->schedule[2]);
            $schedule->tuesday = json_encode($request->schedule[3]);
            $schedule->wednesday = json_encode($request->schedule[4]);
            $schedule->thursday = json_encode($request->schedule[5]);
            $schedule->save();
        } else {
            $schedule->saturday = json_encode($request->schedule[0]);
            $schedule->sunday = json_encode($request->schedule[1]);
            $schedule->monday = json_encode($request->schedule[2]);
            $schedule->tuesday = json_encode($request->schedule[3]);
            $schedule->wednesday = json_encode($request->schedule[4]);
            $schedule->thursday = json_encode($request->schedule[5]);
            $schedule->save();
        }
        return redirect()->back()->with('success', 'تم التخزين بنجاح');
        // $schedule->friday = $request->schedule[6];

    }

    public function lectures($lesson_id, $room_id, $student_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $year = Year::where('current_year', '1')->first();
        $lesson = Lesson::find($lesson_id);
        $lectures = $lesson->lectures()->where('room_id', $room_id)->where('lesson_id', $lesson_id)
            ->whereHas('term_years', function ($q) use ($year) {
        $q->where('year_id', $year->id);
              })
            ->where('key', '0')->where('active', '0')
            ->orderBy('id', 'asc')->get();
        $student = Student::with(['room' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->with('details')->find($student_id);

        $class = Room::find($room_id)->classes;
        $room = Room::find($room_id);
        $count = Message::whereNull('view')->where('student_id', auth()->user()->student_id)->get();

        $count = $count->count();
        $now = Carbon::now();
        $school_data = School_data::first();

        // return view('students.new_course_lecture',compact('room','count','lesson','student','class','lectures'));
        return view('students.new_subject_lectures', compact('school_data','room', 'count', 'lesson', 'student', 'class', 'lectures', 'room_id','now'));
    }






    public function lesson_detail($lesson_id, $student_id)
    {

        $year = Year::where('current_year', '1')->first();

        $student = Student::with(['room' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->with('details')->find($student_id);
        $lesson = Lesson::find($lesson_id);

        $room_id = $student->room[0]->id;
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $now = Carbon::now();

        $lesson_details = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)
            ->where('room_id', $room_id)->orderBy("id", 'desc')->get();

        $teacher_room_lesson = Teacher_room_lesson::where('room_id', $room_id)->where('lesson_id', $lesson_id)->get();

        $teacher_id = $teacher_room_lesson[0]->teacher_id;

        $term_id = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)
            ->where('teacher_id', $teacher_id)->get();


        if ($term_id->count() != 0) {
            $term_id = $term_id[0]->term_id;
        }


        $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->where('room_id', $room_id)->first();

        $answers = [];
        $available_lesson_detail = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)
            ->where('room_id', $room_id)->where('start_time', '<=', $now)->where('end_time', '>=', $now)->get();

        // return $available_lesson_detail;
        foreach ($available_lesson_detail as $item) {

            $answers[] = Student_lesson_teacher_room_term_exam::where('student_id', $student_id)
                ->where('file_id', $item->id)->get();
        }


        $count = Message::whereNull('view')->where('student_id', auth()->user()->student_id)->get();

        $count = $count->count();

        $year = Year::where('current_year', '1')->first();

        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;

        $mark_status = Teacher_room_lesson::where('lesson_id', $lesson_id)->where('room_id', $room->id)->where('year_id', $year->id)->where('teacher_id', $teacher_id)->first();

        $time_status = [];

        foreach ($lesson_details as $item) {

            $time_status[$item->id] = Carbon::now()->lte($item->end_time);
        }

        return view('students.new_courses', compact('now', 'time_status', 'mark_status', 'room', 'class', 'student', 'answers', 'lesson', 'lesson_details', 'lesson_id', 'count', 'student_id', 'teacher_id', 'room_id', 'term_id', 'student_mark'));
    }

    public function course_content($lesson_id, $student_id)
    {

        $student = Student::find($student_id);
        $lesson = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();

        return view('students.new_course_content', compact('lesson', 'student'));
    }

    public function lecture_extra_file($lesson_id, $student_id, $lecture_id)
    {
        $student = Student::with('details')->find($student_id);
        $lesson = Lesson::find($lesson_id);
        $lecture = Lecture::findOrFail($lecture_id);
        $year = Year::where('current_year', '1')->first();
        $room_id = $student->room[0]->id;
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $lesson_details = Lesson_teacher_room_term_exam::where('lecture_id', $lecture_id)
            ->where('type', '4')->orderBy("id", 'desc')->get();

        $lesson_name = $lesson->name;
        $lecture_name = $lecture->name;

        return view(
            'students.new_lecture_extra_files',
            compact('lesson_details', 'student', 'lesson_name', 'lecture_name', 'now', 'now')
        );
    }

    public function lecture_video($lesson_id, $student_id, $lecture_id)
    {
        $student = Student::with('details')->find($student_id);
        $lesson = Lesson::find($lesson_id);
        $lecture = Lecture::findOrFail($lecture_id);
        $year = Year::where('current_year', '1')->first();
        $room_id = $student->room[0]->id;
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $lesson_details = Lesson_teacher_room_term_exam::where('lecture_id', $lecture_id)
            ->where('type', '0')->orderBy("id", 'desc')->get();

        $lesson_name = $lesson->name;
        $lecture_name = $lecture->name;

        return view(
            'students.new_lecture_videos',
            compact('lesson_details', 'student', 'lesson_name', 'lecture_name', 'now')
        );
    }

    public function lecture_audio($lesson_id, $student_id, $lecture_id)
    {

        $student = Student::with('details')->find($student_id);
        $lesson = Lesson::find($lesson_id);
        $lecture = Lecture::findOrFail($lecture_id);
        $year = Year::where('current_year', '1')->first();
        $room_id = $student->room[0]->id;
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        //    $lesson_details=Lesson_teacher_room_term_exam::where('lesson_id',$lesson_id)
        //    ->where('room_id',$room_id)->where('type','5')->orderBy("id",'desc')->get();
        $lesson_details = Lesson_teacher_room_term_exam::Where('lecture_id', $lecture_id)
            ->where('type', '5')
            ->get();  // صوت


        $lesson_name = $lesson->name;
        $lecture_name = $lecture->name;

        return view(
            'students.new_lecture_audios',
            compact('lesson_details', 'student', 'lesson_name', 'lecture_name', 'now')
        );
    }

    public function lecture_homework($lesson_id, $student_id, $lecture_id)
    {
        $student = Student::with('details')->find($student_id);
        $lesson = Lesson::find($lesson_id);
        $lecture = Lecture::findOrFail($lecture_id);
        $year = Year::where('current_year', '1')->first();
        $room_id = $student->room[0]->id;
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $lesson_details = Lesson_teacher_room_term_exam::where('lecture_id', $lecture_id)
            ->where('type', '1')->orderBy("id", 'desc')->get();

        $lesson_name = $lesson->name;
        $lecture_name = $lecture->name;
        return view(
            'students.new_lecture_homeworks',
            compact('lesson_details', 'student', 'lesson_name', 'lecture_name', 'now')
        );
    }

    public function lecture_quize($lesson_id, $student_id, $lecture_id)
    {
        $student = Student::with('details')->find($student_id);
        $lesson = Lesson::find($lesson_id);
        $lecture = Lecture::findOrFail($lecture_id);
        $year = Year::where('current_year', '1')->first();
        $room_id = $student->room[0]->id;
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $lesson_details = Lesson_teacher_room_term_exam::where('lecture_id', $lecture_id)
            ->where('type', '2')->orderBy("id", 'desc')->get();

        $lesson_name = $lesson->name;
        $lecture_name = $lecture->name;

        return view(
            'students.new_lecture_quizes',
            compact('lesson_details', 'student', 'lesson_name', 'lecture_name', 'now')
        );
    }

    public function lecture_exam($lesson_id, $student_id, $lecture_id)
    {
        $student = Student::with('details')->find($student_id);
        $lesson = Lesson::find($lesson_id);
        $lecture = Lecture::findOrFail($lecture_id);
        $year = Year::where('current_year', '1')->first();
        $room_id = $student->room[0]->id;
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $lesson_details = Lesson_teacher_room_term_exam::where('lecture_id', $lecture_id)
            ->where('type', '3')->orderBy("id", 'desc')->get();

        $lesson_name = $lesson->name;
        $lecture_name = $lecture->name;

        return view(
            'students.new_lecture_exams',
            compact('lesson_details', 'student', 'lesson_name', 'lecture_name', 'now')
        );
    }

    public function start_exam($exam_id)
    {
        $student = Student::find(auth()->user()->student_id);
        $content = Lesson_teacher_room_term_exam::findOrFail($exam_id);
        $lesson_name = Lesson::findOrFail($content->lesson_id)->name;
        $room = Room::findOrFail($content->room_id);
        $room = Room::findOrFail($content->room_id);
        $room_id = $room->name;
        $year_id = $room->year_id;

        $class_name = Classe::findOrFail($content->class_id)->name;
        $year = Year::findOrFail($year_id)->name;
        $term = Term_year::findOrFail($content->term_id);
        $term_name = $term->name;

        // return $content;
        $exam_result = Exam_result::where('exam_id', $exam_id)->where('user_id', $student->id)->first();
        if (isset($exam_result) && $exam_result->status == 1) {
            session()->flash('warning', 'لا يمكن اعادة الاختبار ');
            return redirect()->back()->with('message', 'عذراً لايمكن أعادة الامتحان');
        }
        $now = Carbon::now();


        if ($now->subMinutes(2) > $content->end_time && $exam_result->start_time == null) {
            session()->flash('warning', 'انتهى الوقت ...  ');
            return redirect()->back();
        }

        $now = Carbon::now();
        $minutes = $now->diffInMinutes($content->end_time);
        if ($minutes < $content->period) {
            $content->period = $minutes;
        }
        $now = Carbon::now();
        $timer_end_time = $now->addMinutes($content->period);
        $content->timer_end = $timer_end_time;
        if ($exam_result->start_time == null) {
            $exam_result->start_time = Carbon::now();
            $exam_result->end_time = $timer_end_time;
            $exam_result->save();
        } else if (Carbon::now()->addMinutes(1) >=  $exam_result->end_time) {
            session()->flash('warning', ' لايمكنك الدخول للاختبار أكثر من مرة ..  ');
            return redirect()->back();
        } else {

            $minutes = Carbon::now()->diffInMinutes($exam_result->end_time);
            $content->period = $minutes;
        }

        $now = Carbon::now();
        $content->now = $now;

        if ($content->type == 8) {
            $content_name = $content->name_quize1;
        } else if ($content->type == 2) {
            $content_name = $content->name_quize;
        } else if ($content->type == 3) {
            $content_name = $content->name_exam;
        }
        $content_id = $content->id;
        $questions = [];

        $exam = $content;
        $class = $exam->class;
        $questions = json_decode($content->selected_ques, true);
        if (isset($questions)) {
            foreach ($questions as $x) {
                $selected_ques1[] = Question::where('id', $x)->with('option')->orderBy('section_id')->first();
            };
            $questions = $selected_ques1;
        } else {

            $exam_result->start_time = null;
            $exam_result->end_time = null;
            $exam_result->save();
            return redirect()->back()->with('no_questions', 'there is no selected questions');
        }

        return view('students.new_start_exam2', compact(
            'questions',
            'exam',
            'class',
            'student',
            'content_id',
            'content_name',
            'lesson_name',
            'content',
            'room_id',
            'class_name',
            'year',
            'term_name'
        ));
    }

    public function save_exam(Request $request)
    {

        $exam_result = Exam_result::where('user_id', auth()->user()->student_id)
            ->where('exam_id', $request->content_id)->where('status', '1')->first();
        $exam = Lesson_teacher_room_term_exam::find($request->content_id);

        if ($exam_result) {

            if ($exam->type == 8) {
                session()->flash('warning', 'لا يمكن اعادة الاختبار  ');
                return redirect(route('dashboard.student.lesson.lecture.content', [
                    $exam->lesson_id,
                    Auth::user()->student_id, $exam->lecture_id
                ]))->with('message', 'عذرا لا يمكن اعادة الاختبار ');
            } else if ($exam->type == 11) {
                session()->flash('warning', 'لا يمكن اعادة المذاكرة  ');
                return redirect(route('dashboard.student.lesson.lecture.quize', [
                    $exam->lesson_id,
                    Auth::user()->student_id, $exam->lecture_id
                ]))->with('message', 'عذرا لا يمكن اعادة المذاكرة ');
            } else if ($exam->type == 6) {
                session()->flash('warning', 'لا يمكن اعادة الامتحان  ');
                return redirect(route('dashboard.student.lesson.lecture.content', [
                    $exam->lesson_id,
                    Auth::user()->student_id, $exam->lecture_id
                ]))->with('message', 'عذرا لا يمكن اعادة الامتحان ');
            }
        }
        //    $this->validate($request,[
        //        'exam_id' => 'required',
        //        'class_id' => 'required',
        //    ]);
        // تغيير حالة  الامتحان للدلالة على ان الطالب قام به ,طالب واحد على الاقل يكفي لمعرفة أن هذا الامتحان لايمكن تعديل محتواه
        $exam->exam_status = '1';

        $exam->save();
        // هنا أضفنا ترو فتحول الأوبجكت لمصفوفة
        $user_answers = $request->answer;
        $selected_ques = json_decode($exam->selected_ques, true);
        // foreach ($selected_ques as $x) {
        //     $ques_id[] = $x;
        // };

         $exam_questions =  question::with(['exam_question'=>fn($q1)=>$q1->where('test_id',$request->content_id)])->whereIn('id', $selected_ques)->with('option')->get();


        $student_result = 0;
        if ($request->answer != null) {

            $counter = 0;
            foreach ($request->answer as $key => $value) {
                $counter++;
                $exam_questions = $exam_questions->where('id', $key)->first();
                if ($exam_questions->option != null) {
                    foreach ($exam_questions->exam_question as  $val) {
                        
                 if($val->test_id==$request->content_id){
                      $stored_mark = $val->mark;
                      
                    }
                
                }
                    // $stored_mark = $exam_questions->mark;
                    $stored_answer  =  json_decode($exam_questions->answer);



                    $check1 = array_diff($stored_answer, $value);
                    $check2 = array_diff($value, $stored_answer);

                    if (count($check1) == 0 && count($check2) == 0) {
                        $student_result += $stored_mark;
                    }
                }
            }
        }
        $student = Student::find(Auth::user()->student_id);
        $item = Exam_result::where('user_id', Auth::user()->student_id)->where('exam_id', $request->content_id)->first();

        // give medals
        if ($student_result > $exam->success_mark) $student_result =  floor($student_result);
        $medal = 0;
        if ($exam->success_mark == $student_result) {

            $medal = "1";
        } elseif ($exam->success_mark - 3 <= $student_result) {

            $medal = "2";
        } elseif ($exam->success_mark - 6 <= $student_result) {

            $medal = "3";
        } else {
            $medal = null;
        }


        //  return $request ;
        $exam_questions =  question::with(['exam_question'=>fn($q1)=>$q1->where('test_id',$request->content_id)])->whereIn('id', $selected_ques)->with('option')->get();
        if (!isset($request->answer)) {
            $pbject = new stdClass();
            foreach ($exam_questions as $question) {
                $pbject->{$question->id} = [];
            }


            $request->request->add(['answer' => $pbject]);
        } else {
            $default_answers = [];
            $null_correcter = [];
            foreach ($exam_questions as $question) {

                //  $null_correcter = $request->answer[$question->id][0] == null ? [] : $request->answer[$question->id] ;


                if (array_key_exists($question->id, $request->answer) && $question->type == 2)
                    $null_correcter = $request->answer[$question->id][0] == null ? [] : $request->answer[$question->id];


                $default_answers += [$question->id => !array_key_exists($question->id, $request->answer) == 1 ?  [] : $null_correcter];


                //  return getType($request->answer);

                if (!array_key_exists($question->id, $request->answer))
                    $request->answer += [$question->id => []];
            }
            $request->answer2 = $default_answers;
            $request->request->add(['answer2' => $default_answers]);
        }

 
        $item->update([
            'user_id' => Auth::user()->student_id,
            'exam_id'  => $request->content_id,
            //'class_id'  => $exam->class_id,
            'room_id'  => $exam->room_id,
            'lesson_id'  => $exam->lesson_id,
            'lecture_id'  => $exam->lecture_id,
            'selected_ques' => $exam->selected_ques,
            'user_answers' => json_encode($request->answer),
            'result' => $student_result,
            'medal' => $medal,
            'type' => $exam->type,
            'result'=>$student_result,
            'status' => '1'
        ]);

        if (!$request->has('traditional')) {

            //   $item->result2=$item->result;
            $item->save();
        }
        if ($exam->type == 8) {
            session()->flash('success', 'تم تخزين الاختبار بنجاح ');
            return redirect(route('dashboard.student.lesson.lecture.content', [
                $exam->lesson_id,
                Auth::user()->student_id, $exam->lecture_id
            ]))->with('success', 'تم تخزين الاختبار بنجاح ');
        } else if ($exam->type == 6) {
            session()->flash('success', 'تم  التخزين بنجاح ');
            return redirect()->back(); // حاليا
            return redirect(route('dashboard.student.lesson.lecture.quize', [
                $exam->lesson_id,
                Auth::user()->student_id, $exam->lecture_id
            ]))->with('success', 'تم تخزين المذاكرة بنجاح ');
        } else if ($exam->type == 3) {
            session()->flash('success', 'تم تخزين الامتحان بنجاح ');
            $exam = Lesson_teacher_room_term_exam::find($request->exam_id);
            return redirect(route('dashboard.student.lesson.lecture.exam', [
                $exam->lesson_id,
                Auth::user()->student_id, $exam->lecture_id
            ]))->with('success', 'تم تخزين الامتحان بنجاح ');
        }
    }

    public function view_exam($exam_id)
    {
        $student_id = auth()->user()->student_id;
        $content = Lesson_teacher_room_term_exam::findOrFail($exam_id);
        $exam_result = Exam_result::where('exam_id', $exam_id)->where('user_id', $student_id)->first();
        $lesson_name = Lesson::findOrFail($content->lesson_id)->name;
        $room = Room::findOrFail($content->room_id);
        $room_id = $room->name;
        $year_id = $room->year_id;
        $class_name = Classe::findOrFail($content->class_id)->name;
        $year = Year::findOrFail($year_id)->name;
        $term = $content->term_id;
        $first = 'الفصل الأول';
        $second = 'الفصل الثاني';
        $term_name = $term == 1 ? $first : $second;
        $student = Student::find($student_id);

        if ($content->type == 8) {
            $content_name = $content->name_quize1;
        } else if ($content->type == 2) {
            $content_name = $content->name_quize;
        } else if ($content->type == 3) {
            $content_name = $content->name_exam;
        }
        $content_id = $content->id;
        $questions = [];

        $exam = $content;


        $questions = json_decode($exam_result->selected_ques, true);
        if (isset($questions)) {
            foreach ($questions as $x) {
                $selected_ques1[] = Question::where('id', $x)->with('option')->orderBy('section_id')->first();
            };
            $questions = $selected_ques1;
        } else {

            return redirect()->back()->with('no_questions', 'there is no selected questions');
        }


        return view('students.new_view_test', compact(
            'questions',
            'exam',
            'class_name',
            'student',
            'content_id',
            'content_name',
            'exam_result',
            'lesson_name',
            'room_id',
            'term_name',
            'year'
        ));
    }



    public function start_main_exam($exam_id)
    {

        $student = Student::find(auth()->user()->student_id);
        $content = Exams2::findOrFail($exam_id);
        $lesson_name = Lesson::findOrFail($content->lesson_id)->name;
        $room = Room::findOrFail($content->room_id);
        $room_id = $room->name;
        $year_id = $room->year_id;

        $class_name = Classe::findOrFail($content->class_id)->name;
        $year = Year::findOrFail($year_id)->name;
         $term = Term_year::findOrFail($content->term_id);
         $term_name = $term->term;

        $exam_result = Exam_result2::where('exam_id', $exam_id)->where('user_id', $student->id)->first();
        if (isset($exam_result) && $exam_result->status == 1) {
            session()->flash('error', 'لا يمكن اعادة الاختبار ');
            return redirect()->back()->with('error', 'عذراً لايمكن أعادة الامتحان');
        }
        $now = Carbon::now();


        if ($now->subMinutes(2) > $content->end_date && $exam_result->start_time == null) {
            session()->flash('error', 'انتهى الوقت    ');

            return redirect()->back();
        }


        $now = Carbon::now();
        $minutes = $now->diffInMinutes($content->end_date);
        if ($minutes < $content->period) {
            $content->period = $minutes;
        }
        $timer_end_time = $now->addMinutes($content->period);
        $content->timer_end = $timer_end_time;

        if ($exam_result->start_time == null) {
            $exam_result->start_time = Carbon::now();
            $exam_result->end_time = $timer_end_time;
            $exam_result->save();
        } else if (Carbon::now()->addMinutes(1) >=  $exam_result->end_time) {


            session()->flash('error', 'لا يمكنك الدخول أكثر من مرة     ');

            return redirect()->back();
        } else {
            $minutes = Carbon::now()->diffInMinutes($exam_result->end_time);
            $content->period = $minutes;
        }

        $now = Carbon::now();
        $content->now = $now;

        $content_name = $content->name;

        $content_id = $content->id;
        $questions = [];

        $exam = $content;
        $class = $exam->class;

        $questions = json_decode($content->selected_ques, true);

        $selected_ques1 = [];

        if ($questions != null) {
            foreach ($questions as $x) {

                $selected_ques1[] = Question::where('id', $x)->with('option')->orderBy('section_id')->first();
            };
            $questions = $selected_ques1;
        } else {

            $exam_result->start_time = null;
            $exam_result->end_time = null;
            $exam_result->save();
            return redirect()->back()->with('error', ' ! لم يتم تحديد أسئلة بعد');
        }
        // if (isset($questions)){
        //   $normal_questions = Question::where('section_id','0')->whereIn('id', $questions)
        //     ->get();
        //     $with_section_questions = Question::where('section_id','!=','0')->whereIn('id', $questions)
        //     ->orderBy('section_id','asc')
        //     ->get();
        // }else {

        //     return redirect()->back()->with('error',' ! لم يتم تحديد أسئلة بعد');
        // }

        return view('students.new_start_main_exam2', compact(
            'questions',
            'exam',
            'class',
            'student',
            'content_id',
            'content_name',
            'lesson_name',
            'content',
            'room_id',
            'class_name',
            'year',
            'term_name'
            
        ));
    }

    public function save_main_exam(Request $request)
    {


        //  $option =  Option::create([
        //         'question_id' => 0,
        //         'myOptions' =>  json_encode($request->answer),
        //     ]);
//       $option = Option::find(5293) ;
//   return response()->json( json_decode($option->myOptions)) ;
       $exam_result=Exam_result2::where('user_id',auth()->user()->student_id)
                    ->where('exam_id',$request->content_id)->first();
         $exam=Exams2::find($request->content_id);
        //   **********************************************
        //  just for test
        $exam_result_tester= new Exam_result_tester ;
        $exam_result_tester->user_id = Auth::user()->student_id ;
        $exam_result_tester->exam_id = $request->content_id ;
        $exam_result_tester->class_id = $exam->class_id  ;
        $exam_result_tester->room_id = $exam->room_id ;
        $exam_result_tester->lesson_id = $exam->lesson_id ;
        $exam_result_tester->selected_ques = $exam->selected_ques ;
        $exam_result_tester->user_answers = json_encode($request->answer );
        $exam_result_tester->result = 11111 ;
        $exam_result_tester->show_result = $exam_result->show_result ;
        $exam_result_tester->type = $exam->type ;
        $exam_result_tester->status = '1' ;
        $exam_result_tester->save() ;

        // ************************************************

         if ($exam_result && $exam_result->status == 1 ) {

            if ($exam->type == 2){
                return redirect(route('dashboard.student.room.main.exams',
                [$exam->room_id,Auth::user()->student_id]))->with('error','عذرا لا يمكن اعادة المذاكرة ');

            }else if ($exam->type == 1){
                return redirect(route('dashboard.student.room.main.exams',
                [$exam->room_id,Auth::user()->student_id]))->with('error','عذرا لا يمكن اعادة الامتحان ');
            }
        }
    //    $this->validate($request,[
    //        'exam_id' => 'required',
    //        'class_id' => 'required',
    //    ]);
        // تغيير حالة  الامتحان للدلالة على ان الطالب قام به ,طالب واحد على الاقل يكفي لمعرفة أن هذا الامتحان لايمكن تعديل محتواه
        $exam->is_taken='1';

        $exam->save();
            // هنا أضفنا ترو فتحول الأوبجكت لمصفوفة
        $user_answers = $request->answer ;
        $selected_ques = json_decode($exam->selected_ques,true) ;
        // foreach ($selected_ques as $x) {
        //     $ques_id[] = $x;
        // };

           $exam_questions =  question::with(['exam_question'=>fn($q1)=>$q1->where('exam_id',$request->content_id)])->whereIn('id', $selected_ques)->with('option')->get();


        $student_result =0;
        $student_result1=[];
        if($user_answers != null) {

        foreach ($user_answers as $key => $value) {
            $exam_questions = $exam_questions->where('id',$key)->first() ;
            if ($exam_questions->option != null){
             foreach ($exam_questions->exam_question as  $val) {
                 if($val->exam_id==$request->content_id){
                      $stored_mark = $val->mark;
                      
                 }
                
             }
                 
                $stored_answer  =  json_decode($exam_questions->answer);


                $check1 = array_diff($stored_answer,$value);
                $check2 = array_diff($value,$stored_answer);
                // اختبار للعلامات يلي عم يجيبها 
           //    $student_result1[$key]= $stored_mark;
                if (count($check1) == 0 && count($check2) == 0 ){
                    $student_result += $stored_mark;
                }
            }else if($exam_questions->ques_type == 3){
            $path = $value[0]->store('filesstudents', 'public') ;
            $user_answers[$key][0] = $path;
            // $request->merge(['answer' => $fileAnswer]);

            }
        }

       }
        
           $student=Student::find(Auth::user()->student_id);
           $item=Exam_result2::where('user_id',Auth::user()->student_id)->where('exam_id', $request->content_id)->first();


            // give medals
             if ($student_result > $exam->mark) $student_result=  floor($student_result);
            $medal = 0;
             if($exam->mark == $student_result){

                $medal = "1";
            }
             elseif( $exam->mark - 3 <= $student_result ){

                $medal = "2";
            }
             elseif( $exam->mark - 6 <= $student_result ){

                $medal = "3";
            }
             else{
                 $medal = null;
            }

            // if (!isset($user_answers)){
            //     $exam_questions =  question::whereIn('id', $selected_ques)->with('option')->get();
            //     $pbject = new stdClass();
            //     foreach($exam_questions as $question){
            //         $pbject->{$question->id} = [];
            //     }


            //      $request->request->add(['answer' => $pbject]);

            // }

             $exam_questions =  question::with(['exam_question'=>fn($q1)=>$q1->where('exam_id',$request->content_id)])->whereIn('id', $selected_ques)->with('option')->get();
            if (!isset($request->answer)){
                $pbject = new stdClass();
                foreach($exam_questions as $question){
                    $pbject->{$question->id} = [];
                }

                  $user_answers =  ['answer' => $pbject];
                //  $request->request->add(['answer' => $pbject]);

            }else {
                $default_answers = [] ;
                $null_correcter = [] ;
                 foreach($exam_questions as $question){

                    //  $null_correcter = $request->answer[$question->id][0] == null ? [] : $request->answer[$question->id] ;


                        if(array_key_exists($question->id,$request->answer) && $question->type == 2)
                                $null_correcter = $request->answer[$question->id][0] == null ? [] : $request->answer[$question->id] ;


                        $default_answers += [$question->id => !array_key_exists($question->id,$request->answer) == 1 ?  [] : $null_correcter] ;


                        //  return getType($request->answer);

                         if(!array_key_exists($question->id,$request->answer))
                            $user_answers += [$question->id => []];

                        }
            }


           $item->update([
           'user_id' => Auth::user()->student_id,
           'exam_id'  => $request->content_id,
           'class_id'  => $exam->class_id,
           'room_id'  => $exam->room_id,
           'lesson_id'  => $exam->lesson_id,
        //   'lecture_id'  => $exam->lecture_id,
           'selected_ques' => $exam->selected_ques,
           'user_answers' => json_encode($user_answers),
           'result' => $student_result,
           'medal' => $medal,
           'type'=>$exam->type,
           'status'=>'1',
           ]);

        //     if (! $request->has('traditional')) {

        //       $item->result2=$item->result;
        //       $item->save();

        //   }
            session()->flash('success', 'تم  التخزين بنجاح ');
           if ($exam->type == 1){
            //   exam case.
                return redirect(route('dashboard.student.room.main.exams',
                [$exam->room_id,Auth::user()->student_id]));
           }else {
            //   quize case.
                 return redirect(route('dashboard.student.room.main.quizes',
                [$exam->room_id,Auth::user()->student_id]));
           }
    }
    public function save_main_exam_test(Request $request)
    {

        $exam_result = Exam_result2::where('user_id', 290)
            ->where('exam_id', 370)->first();
        $exam = Exams2::find(370);



        $user_answers = json_decode($exam_result->user_answers);
        $selected_ques = json_decode($exam->selected_ques, true);

        $exam_questions =  question::whereIn('id', $selected_ques)->with('option')->get();


        $student_result = 0;
        if ($user_answers != null) {

            foreach ($user_answers as $key => $value) {
                $exam_questions = $exam_questions->where('id', $key)->first();
                if ($exam_questions->option != null) {

                    $stored_mark = $exam_questions->mark;
                    $stored_answer  =  json_decode($exam_questions->answer);

                    if ($key == 2685) return  $exam_questions;
                    $check1 = array_diff($stored_answer, $value);
                    $check2 = array_diff($value, $stored_answer);

                    if (count($check1) == 0 && count($check2) == 0) {
                        $student_result += $stored_mark;
                    }
                }
            }
        }
        $student = Student::find(Auth::user()->student_id);
        $item = Exam_result2::where('user_id', Auth::user()->student_id)->where('exam_id', $request->content_id)->first();
        $exam_questions =  question::with(['exam_question'=>fn($q1)=>$q1->where('test_id',$request->content_id)])->whereIn('id', $selected_ques)->with('option')->get();
        if (!isset($request->answer)) {
            $pbject = new stdClass();
            foreach ($exam_questions as $question) {
                $pbject->{$question->id} = [];
            }


            $request->request->add(['answer' => $pbject]);
        } else {
            $default_answers = [];
            $null_correcter = [];
            foreach ($exam_questions as $question) {

                //  $null_correcter = $request->answer[$question->id][0] == null ? [] : $request->answer[$question->id] ;


                if (array_key_exists($question->id, $request->answer) && $question->type == 2)
                    $null_correcter = $request->answer[$question->id][0] == null ? [] : $request->answer[$question->id];


                $default_answers += [$question->id => !array_key_exists($question->id, $request->answer) == 1 ?  [] : $null_correcter];


                //  return getType($request->answer);

                if (!array_key_exists($question->id, $request->answer))
                    $request->answer += [$question->id => []];
            }
            $request->answer2 = $default_answers;
            $request->request->add(['answer2' => $default_answers]);
        }
        return $student_result;

        $item->update([
            'user_id' => Auth::user()->student_id,
            'exam_id'  => $request->content_id,
            'class_id'  => $exam->class_id,
            'room_id'  => $exam->room_id,
            'lesson_id'  => $exam->lesson_id,
            'lecture_id'  => $exam->lecture_id,
            'selected_ques' => $exam->selected_ques,
            'user_answers' => json_encode($request->answer),
            'result' => $student_result,

            'type' => $exam->type,
            'status' => '1',
        ]);

        //     if (! $request->has('traditional')) {

        //       $item->result2=$item->result;
        //       $item->save();

        //   }
        session()->flash('success', 'تم  التخزين بنجاح ');
        if ($exam->type == 1) {
            //   exam case.
            return redirect(route(
                'dashboard.student.room.main.exams',
                [$exam->room_id, Auth::user()->student_id]
            ));
        } else {
            //   quize case.
            return redirect(route(
                'dashboard.student.room.main.quizes',
                [$exam->room_id, Auth::user()->student_id]
            ));
        }
    }



    public function view_main_exam($exam_id)
    {
        $student_id = auth()->user()->student_id;
        $content = Exams2::findOrFail($exam_id);
        $exam_result = Exam_result2::where('exam_id', $exam_id)->where('user_id', $student_id)->first();
        $lesson_name = Lesson::findOrFail($content->lesson_id)->name;
        $room = Room::findOrFail($content->room_id);
        $room_id = $room->name;
        $year_id = $room->year_id;
        $class_name = Classe::findOrFail($content->class_id)->name;
        $year = Year::findOrFail($year_id)->name;
        $term = $content->term_id;
        $first = 'الفصل الأول';
        $second = 'الفصل الثاني';
        $term_name = $term == 1 ? $first : $second;
        $student = Student::find($student_id);


        $content_name = $content->name;

        $content_id = $content->id;
        $questions = [];

        $exam = $content;


        $questions = json_decode($exam_result->selected_ques, true);
        $selected_ques1 = [];

        if ($questions != null) {
            foreach ($questions as $x) {
                $selected_ques1[] = Question::with(['exam_question'=>fn($q1)=>$q1->where('exam_id',$exam_id)])->where('id', $x)->with('option')->orderBy('section_id')->first();
            };
            $questions = $selected_ques1;
        }
      
        // if (isset($questions)){
        //   $normal_questions = Question::where('section_id','0')->whereIn('id', $questions)
        //     ->get();
        //   $with_section_questions = Question::where('section_id','!=','0')->whereIn('id', $questions)
        //     ->orderBy('section_id','asc')
        //     ->get();
        //     $max_result = 0;

        // }
        else {
            return redirect()->back()->with('no_questions', 'there is no selected questions');
        }

 
        return view('students.new_view_main_exam2', compact(
            'questions',
            'exam',
            'class_name',
            'student',
            'content_id',
            'content_name',
            'exam_result',
            'lesson_name',
            'room_id',
            'term_name',
            'year'
        ));
    }


    public function lecture_content($lesson_id, $student_id, $lecture_id)
    {


        $super_file  = Super_file ::where('lecture_id', $lecture_id)->orderBy("id", 'desc')->get();
        $year = Year::where('current_year', '1')->first();

        $student = Student::with(['room' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($student_id);

        $lesson = Lesson::find($lesson_id);
        $lesson->books = json_decode($lesson->books);

        $lecture = Lecture::findOrFail($lecture_id);
        $year = Year::where('current_year', '1')->first();
        $room_id = $student->room[0]->id;
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');


        $lecture_videos = Lesson_teacher_room_term_exam::Where('lecture_id', $lecture_id)->where('type', '0')
            ->get();  // فيديو
        $lecture_tests = Lesson_teacher_room_term_exam::Where('lecture_id', $lecture_id)->where('type', '1')
            ->get(); // وظيفة
        //   $lecture_quizes = Lesson_teacher_room_term_exam::Where('lecture_id',$lecture_id)->where('type','2')
        //      ->get(); // مذاكرة
        //   $lecture_exams = Lesson_teacher_room_term_exam::Where('lecture_id',$lecture_id)->where('type','3')
        //      ->get(); //  امتحان
          $lecture_others = Lesson_teacher_room_term_exam::Where('lecture_id', $lecture_id)->where('type', '4')
            ->get();  // ملفات
        //   $lecture_audios = Lesson_teacher_room_term_exam::Where('lecture_id',$lecture_id)->where('type','5')
        //      ->get();
        $lecture_audios = Lesson_teacher_room_term_exam::Where('lecture_id', $lecture_id)->where('type', '6')
            ->get();  // صوت

         $lecture_quizes = Lesson_teacher_room_term_exam::Where('lecture_id', $lecture_id)->whereIn('type', ['7', '8'])
            ->get(); // اختبار خاص بكل درس على حدى

        foreach ($lecture_quizes as $content) {
             $content_result = Exam_result::where('exam_id', $content->id)->where('user_id', $student_id)->first();

            // هذا العنصر لمعرفة اذا كان الطالب دخل الى الامتحان لكن خرج منه و لم يقم بانهائه
           
           if($content_result){
            if ($content_result->start_time != null && $content_result->status != '1') {
                $content->not_terminate = '1';
            } else {
                $content->not_terminate = '0';
            }
}
            if (isset($content_result) && $content_result->status == 1 && $content_result->show_result == 1) {
                $content->result = $content_result->result;
            } else if (isset($content_result) && $content_result->status == 1 && $content_result->show_result == 0) {
                $content->result = -1;
            }

            //exam start ability
            if (isset($content_result) && isset($content_result->end_time) && (Carbon::now()->subMinutes(1) >=  $content_result->end_time)) {
                $content->start_exam = 0;
            } else {
                $content->start_exam = 1;
            }
        }
        foreach ($lecture_tests as $content) {
            $content_result = Exam_result::where('exam_id', $content->id)->where('user_id', $student_id)->first();
            $previous_homeworks = Student_lesson_teacher_room_term_exam::where('exam_id', $content->id)
                ->where('student_id', $student_id)->count();
                 $homeworks = Student_lesson_teacher_room_term_exam::where('exam_id', $content->id)
                ->where('student_id', $student_id)->get();
            if (isset($content_result) && $content_result->result != null) {
                $content->result = $content_result->result;
            } else if (isset($content_result) && $content_result->status == 1 && $content_result->show_result == 0) {
                $content->result = -1;
            }
            $content->previous_file_count = $previous_homeworks;
             $content->homeworks = $homeworks;
        }

        $school_data = School_data::first();



        return view('students.new_lecture_content', compact(
            'school_data',
            'lecture_videos',
            'lecture_tests',
            'lecture_quizes',
            'lecture_others',
            'lecture_audios',
            'student',
            'lecture',
            'now',
            'lesson',
            'room_id',
             'super_file'
        ));
    }


    public function upload_files(Request $request)
    {
        $student_id = auth()->user()->student_id;
        $student = Student::find($student_id);
        $content = Lesson_teacher_room_term_exam::findOrFail($request->item_id);

        $this->validate($request, [
            'file' => 'required',
            'file.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf,docx|max:2048',
            'item_id' => 'required',
        ], [
            'file.required' => 'يرجى  ترفيع  بالشروط المحددة  ',
            'item_id.required' => 'يرجى   تحديد المحتوى ',
        ]);
        $student_id = auth()->user()->student_id;
        $student = Student::find($student_id);
        $content = Lesson_teacher_room_term_exam::findOrFail($request->item_id);
        $student_uploaded_file = new Student_lesson_teacher_room_term_exam;

        $i = 0;
        if ($request->file && $request->hasFile('file')) {
              $i =  Student_lesson_teacher_room_term_exam::where('room_id',$content->room_id)->where('exam_id',$request->item_id)->count();
            foreach ($request->file as $k => $file) {

                $i = $i + 1;
                $filename = $i . " - " . $student->first_name ." ". $student->last_name ." ".  $content->namehomework . '.' . $file->extension();
                $values[] = [
                    'file' => $file->storeAs('public/filesstudents', $filename),
                    'exam_id' => $request->item_id,
                    'student_id' => auth()->user()->student_id,
                    'type' => $content->type,
                    'room_id' => $content->room_id,
                    'lesson_id' => $content->lesson_id,
                    'term_id' => $content->term_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }


            DB::table('student_lesson_teacher_room_term_exam')->insert($values);
            return redirect()->back()->with('success_uploading', 'تم ترفيع الوظيفة بنجاح');
        }



        return redirect()->back()->with('error', 'لا يوجد ملف  ');

    }
    public function upload_exam_files(Request $request)
    {

        $this->validate($request, [
            'file' => 'required',
            'exam_id' => 'required',
        ], [
            'file.required' => 'يرجى  ترفيع الملف  ',
            'exam_id.required' => 'يرجى   تحديد المحتوى ',
        ]);
        $student_id = auth()->user()->student_id;
        $student = Student::find($student_id);
        $content = Exams2::findOrFail($request->exam_id);

        if ($request->file && $request->hasFile('file')) {
            $old_exam = Exam_file::where('student_id', $student_id)->where('exam_id', $request->exam_id)->delete();
            // if (isset($old_exam)){
            //     $old_exam->delete() ;
            // }
            $term = Term::where('is_active', '1')->first();
            $i = 0;
            foreach ($request->file as $file) {
                $i = $i + 1;
                $student_uploaded_file = new Exam_file();
                $filename = $i . " - " . $student->first_name ." ".  $student->last_name ." ".  $content->name . '.' . $file->extension();
                $student_uploaded_file->file = $file->storeAs('public/filesstudents', $filename);
                $student_uploaded_file->extension   = $file->extension();
                $student_uploaded_file->exam_id =  $request->exam_id;  // the file is coming from storage
                $student_uploaded_file->student_id =  auth()->user()->student_id;
                $student_uploaded_file->class_id =  $content->class_id;
                $student_uploaded_file->room_id =  $content->room_id;
                $student_uploaded_file->lesson_id =  $content->lesson_id;
                $student_uploaded_file->term_id =  $term->id;
                $student_uploaded_file->save();
            }
            return redirect()->back()->with('success', 'تم التخزين بنجاح');
        }
        return redirect()->back()->with('error', 'لا يوجد ملف  ');
    }


    public function results($student_id)
    {


        $year = Year::where('current_year', '1')->first();
        $student = Student::with(['room' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($student_id);
        $room = $student->room;
        if ($room->isEmpty() || $student->status != '1') {
            return redirect()->back()->with('warning', 'لم تصدر النتائج بعد !');
        }
        $student_mark = null;
        if ($student->status != 0) {
            $student_mark = Students_mark::where('student_id', $student_id)
                ->where('room_id', $room[0]->id)->where('year_id', $year->id)->first();
        }

        $lessons =  $room[0]->classes->lessons;

        $count = Message::whereNull('view')->where('student_id', auth()->user()->student_id)->get();

        $count = $count->count();


        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;
        return view('students.results', compact('student_mark', 'student', 'class', 'room', 'count', 'lessons'));
    }

    public function upload_store(Request $request)
    {


        // return $request->all();
        //         $extension = $request->exam_file->extension();
        // return $extension;
        // $date = new DateTime();
        // $now=$date->format('Y-m-d H:i:s');
        $now = Carbon::now();
        // return $now;

        // return $question;

        $question = Lesson_teacher_room_term_exam::find($request->file_id);

        if ($now > $question->start_time && $now < $question->end_time) {
            $answer = Student_lesson_teacher_room_term_exam::where('file_id', $request->file_id)->where('student_id', $request->student_id)->where('type', $request->type)->first();

            if ($answer) {
                return redirect()->back()->with('warning', 'يجب حذف الملف السابق اولا ');
            }
            $item = new Student_lesson_teacher_room_term_exam;
            $item->student_id = $request->student_id;
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->student_id = $request->student_id;
            $item->room_id = $request->room_id;
            $item->term_id = $request->term_id;
            $item->file_id = $request->file_id;

            if ($request->hasFile('test_file')) {
                $item->type = '1';

                $item->file = $request->test_file->store('filesstudents', 'public');
                $item->extension  = $request->test_file->extension();
            }


            if ($request->hasFile('quize_file')) {
                $item->type = '2';

                $item->file = $request->quize_file->store('filesstudents', 'public');

                $item->extension  = $request->quize_file->extension();
            }

            if ($request->hasFile('exam_file')) {
                $item->type = '3';

                $item->file = $request->exam_file->store('filesstudents', 'public');

                $item->extension = $request->exam_file->extension();
            }

            $item->save();

            return redirect()->back()->with('success', '! تمت العملية بنجاح ');
        }

        return redirect()->back()->with('Warning', 'عذرا انتهى وقت الامتحان');
    }

    public function delete_answer($id, $student_id, $file_id, $type)
    {

        $answer = Student_lesson_teacher_room_term_exam::find($id);
        Storage::disk('public')->delete($answer->file);

        $answer->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }

    public function delete_answer2(Request $request)
    {

        $answer = Student_lesson_teacher_room_term_exam::find($request->id);
        Storage::disk('public')->delete($answer->file);

        $answer->delete();

        return response()->json([
            'status' => true,
            'msg' => 'تم الحذف بنجاح ',

        ]);
        // return redirect()->back()->with('success','تم حذف الملف بنجاح !');



    }


    public function financial_account($student_id)
    {

        $year = Year::where('current_year', '1')->first();
        $student = Student::with(['room' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($student_id);
        $class = $student->room[0]->classes;
        $invoices = Invoice::where('student_id', $student_id)->where('class_id', $class->id)->where('year_id', $year->id)->get();
        $class = Classe::find($class->id);
        $year = Year::where('current_year', '1')->first();

        $remain_amount = 0;
        $cost=Class_cost::where('class_id',$class->id)->where('country_id',$student->country_currency)->first();
       $full_amount = 0;
       if ($cost) {
       $full_amount = $cost->cost;
        }
        $amount_paid = 0;
        foreach ($invoices as $item) {
            $amount_paid = $amount_paid + $item->invoice_amount;
        }
        $remain_amount = $full_amount - $amount_paid;
        $count = Message::whereNull('view')->where('student_id', auth()->user()->student_id)->get();
        $count = $count->count();
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;
        $room_id = $room->id;
        return view('students.financial_account', compact('room_id', 'invoices', 'student', 'class', 'room', 'count', 'remain_amount', 'amount_paid', 'full_amount'));
    }




    public function messages($student_id,$teacher_id)
    {

        $year = Year::where('current_year', '1')->first();

        $student = Student::find($student_id);

        $messages = Message::where('student_id', $student->id)->where('year_id', $year->id)->get();
        // return redirect()->back();
        // foreach ($messages as $item) {

        //    $m=Message::find($item->id);
        //    $m->view='1';
        //     $m->save();
        // }


        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        if ($room) {
            $room_id = $room->id;
            $teachers = $room->teachers->unique();

            foreach ($teachers as $teacher) {
                 $dates="00";
              $x =  Message::where('student_id', $student_id)->where('teacher_id', $teacher->id)->where('year_id', $year->id)->where('view', 0)->where('type', 0)->count();
               $date =  Message::where('student_id', $student_id)->where('teacher_id', $teacher->id)->where('year_id', $year->id)->orderBy('id', 'desc')->first();
                if($date){
                  $dates =$date->created_at;
                }
                $teacher->message_count = $x;
                $teacher->message_date = $dates;
            }


            $class = $room->classes;
        } else {
            $room_id = "";

            $teachers = $room->teachers->unique();

            foreach ($teachers as $teacher) {
                $dates="00";
                $x =  Message::where('student_id', $student_id)->where('teacher_id', $teacher->id)->where('year_id', $year->id)->where('view', 0)->where('type', 0)->count();
               $date =  Message::where('student_id', $student_id)->where('teacher_id', $teacher->id)->where('year_id', $year->id)->orderBy('id', 'desc')->first();
                if($date){
                  $dates =$date->created_at;
                }
                $teacher->message_count = $x;
                $teacher->message_date = $dates;
            }


            $class = $room->classes;
        }
        $school_data = School_data::first();

     $teachers= $teachers->sortByDesc('message_date')->values();
        return view('students.new_messages3', compact('school_data','teacher_id','student', 'class', 'room', 'messages', 'room_id', 'teachers'));
    }


    public function get_teacher_message($student_id, $teacher_id)
    {
        $year = Year::where('current_year', '1')->first();


        $messages = Message::with('teacher')->where('student_id', $student_id)->where('teacher_id', $teacher_id)->where('year_id', $year->id)->get();

        foreach ($messages as $item) {
            if ($item->type == '0') {
                $m = Message::find($item->id);
                $m->view = '1';
                $m->save();
            }
            $item->date = Carbon::parse($item->created_at)->format('Y-m-d');
            $item->time = Carbon::parse($item->created_at)->format('H:i:s');
        }

        return response()->json([
            'status' => true,
            'messages' =>  $messages,
        ]);
    }

    public function store_student_message(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required',
            'teacher_id' => 'required',
            'message' => 'required',

        ], [
            'message.required' => 'يرجى ادخال رسالة قبل الارسال',
        ]);
        $year = Year::where('current_year', '1')->first();
        $message = new Message;
        $message->student_id = $request->student_id;
        $message->teacher_id =  $request->teacher_id;
        $message->message = $request->message;
        $message->type = '1';
        $message->year_id = $year->id;
        $message->view = 0;
        $message->save();
        return response()->json([
            'status' => true,
            'message' =>  $message,
        ]);
    }


    public function events()
    {

        $year = Year::where('current_year', '1')->first();

        $student = Student::find(auth()->user()->student_id);

        $room = $student->room->where('year_id', $year->id);
        if ($room->isEmpty()) {

            return redirect()->back();
        }
        $room_id = $room[0]->id;
        $events = Teacher_event::with('teacher')->where('room_id', $room_id)->get();
        // $events=Teacher_event::where('year_id',$year->id)->where('room_id',$room[0]->id)->
        // whereDate('date', '>=', Carbon::today()->toDateString())->get();


        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;
        return view('students.events', compact('events', 'student', 'class', 'room', 'room_id'));
    }

    public function checkout(Request $request)
    {
        $amount = $request->amount;
        $student = Student::find(auth()->user()->student_id);

        $count = Message::whereNull('view')->where('student_id', auth()->user()->student_id)->get();
        $count = $count->count();

        $year = Year::where('current_year', '1')->first();

        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;
        $room_id = $room->id;
        return view('students.checkout', compact('room_id', 'amount', 'student', 'class', 'room', 'count'));
    }

    public function charge(Request $request)
    {
        $year = Year::where('current_year', '1')->first();


        $charge = Stripe::charges()->create([

            'amount' => $request->amount,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $request->stripeToken,
        ]);

        $student = Student::find(auth()->user()->student_id);
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;
        $chargeId = $charge['id'];
        if ($chargeId) {

            $invoice = new Invoice;
            $invoice->student_id = $student->id;
            $invoice->class_id = $class->id;
            $invoice->year_id = $year->id;
            $invoice->invoice_amount = $request->amount;

            $invoice->save();
            session()->flash('success', ' !  تمت العملية بنجاح     ');
            return redirect()->route('dashboard')->with('success', '! تمت العملية بنجاح');
        }
    }

    // os
    public function student_medals($student_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $student = Student::find($student_id);
        $year = Year::where('current_year', '1')->first();
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $room_id = $room->id;
        $class = $room->classes;



        $test_medals = Exam_result::with('lesson')->where('medal', '!=', null)->where('user_id', $student_id)->where('term_id', $term->id)->orderBy('updated_at', 'desc')->get();
         $exam_medals = Exam_result2::with('lesson')->where('medal', '!=', null)->where('user_id', $student_id)->where('term_id', $term->id)->orderBy('updated_at', 'desc')->get();
        $medals = Medal::with('lesson')->where('student_id', $student_id)->where('term', $term->id)->orderBy('updated_at', 'desc')->get();


        $room->lessons2 =  $room->lessons->unique();
        $lessons =  $room->lessons2;
        foreach ($lessons as $lesson) {
            $golden_medals_exam  = Exam_result::where('medal', '=', '1')->where('user_id', $student_id)->where('term_id', $term->id)->where('lesson_id', $lesson->id)->count();
            $golden_medals_test  = Exam_result2::where('medal', '=', '1')->where('user_id', $student_id)->where('term_id', $term->id)->where('lesson_id', $lesson->id)->count();
            $golden_medals_class_activity  = Medal::where('medal', '=', '1')->where('student_id', $student_id)->where('term', $term->id)->where('lesson_id', $lesson->id)->count();
            // $lesson->golden_medals_count =  $golden_medals_exam  + $golden_medals_test +   $golden_medals_class_activity;
            $lesson->golden_medals_count =  $golden_medals_class_activity   ;

            $silver_medals_exam  = Exam_result::where('medal', '=', '2')->where('user_id', $student_id)->where('term_id', $term->id)->where('lesson_id', $lesson->id)->count();
            $silver_medals_test  = Exam_result2::where('medal', '=', '2')->where('user_id', $student_id)->where('term_id', $term->id)->where('lesson_id', $lesson->id)->count();
            $silver_medals_class_activity  = Medal::where('medal', '=', '2')->where('student_id', $student_id)->where('term', $term->id)->where('lesson_id', $lesson->id)->count();
            // $lesson->silver_medals_count =  $silver_medals_exam  + $silver_medals_test +   $silver_medals_class_activity;
             $lesson->silver_medals_count =   $silver_medals_class_activity;

            $pronze_medals_exam  = Exam_result::where('medal', '=', '3')->where('user_id', $student_id)->where('term_id', $term->id)->where('lesson_id', $lesson->id)->count();
            $pronze_medals_test  = Exam_result2::where('medal', '=', '3')->where('user_id', $student_id)->where('term_id', $term->id)->where('lesson_id', $lesson->id)->count();
            $pronze_medals_class_activity  = Medal::where('medal', '=', '3')->where('student_id', $student_id)->where('term', $term->id)->where('lesson_id', $lesson->id)->count();
            // $lesson->pronze_medals_count =  $pronze_medals_exam  + $pronze_medals_test +   $pronze_medals_class_activity;
            $lesson->pronze_medals_count =     $pronze_medals_class_activity;
        }
        //  foreach($test_medals as $medal){
        //      if($medal->medal == '1' || $medal->medal == 1) return 11;
        //      if($medal->medal == '2' || $medal->medal == 2) return 22;
        //      if($medal->medal == '3' || $medal->medal == 3) return 33;
        //      return 88;
        //  }
        //  return $test_medals ;

        return view('students.new_medals', compact('student', 'room', 'class', 'room_id', 'exam_medals', 'test_medals', 'medals', 'lessons'));
    }
    public function student_certificates($student_id)
    {

        $student = Student::find($student_id);
        $year = Year::where('current_year', '1')->first();
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $room_id = $room->id;
        $class = $room->classes;



        $test_medals = Exam_result::with('lesson')->where('medal', '!=', null)->where('user_id', $student_id)->orderBy('updated_at', 'desc')->get();
        $exam_medals = Exam_result2::with('lesson')->where('medal', '!=', null)->where('user_id', $student_id)->orderBy('updated_at', 'desc')->get();
        $medals = Medal::with('lesson')->where('student_id', $student_id)->orderBy('updated_at', 'desc')->get();


        $room->lessons2 =  $room->lessons->unique();
        $lessons =  $room->lessons2;



        return view('students.new_certificate', compact('student', 'room', 'class', 'room_id', 'exam_medals', 'test_medals', 'medals', 'lessons'));
    }
    public function get_teacher(Request $request)
    {
        $teacher_room_lesson = Teacher_room_lesson::where('lesson_id', $request->lesson_id)
            ->where('room_id', $request->room_id)->first();
        if (isset($teacher_room_lesson)) {
            $teacher = Teacher::findOrFail($teacher_room_lesson->teacher_id);
            $teacher_id = $teacher->id;
            $teacher_name = $teacher->first_name . ' ' . $teacher->last_name;
            return response()->json([
                'teacher_id' => $teacher_id,
                'teacher_name' => $teacher_name,
            ]);
        }
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
        ];
        $day = $week[$day];
        return  $day;
    }

    public function edit_2($id)
    {
        $year = Year::where('current_year', '1')->first();
        $cer = Certificate::find($id);
        $certificate = Certificate_Fields::find($cer->certificate);
        $teacher = Teacher::find($cer->teacher_id);
        $lesson = Lesson::find($cer->lesson_id);
        $student = Student::find($cer->student_id);
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;
        return view('students.edit-2.index ', compact('certificate', 'cer', 'teacher', 'student', 'room', 'class', 'lesson'));
    }
    public function newcertificate($id)
    {
        $year = Year::where('current_year', '1')->first();
        $cer = Certificate::find($id);
        $certificate = Certificate_Fields::find($cer->certificate);
        $teacher = Teacher::find($cer->teacher_id);
        $lesson = Lesson::find($cer->lesson_id);
        $student = Student::find($cer->student_id);
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;
        return view('students.new.index ', compact('certificate', 'cer', 'teacher', 'student', 'room', 'class', 'lesson'));
    }
    public function new44($id)
    {
        $year = Year::where('current_year', '1')->first();
        $cer = Certificate::find($id);
        $certificate = Certificate_Fields::find($cer->certificate);
        $teacher = Teacher::find($cer->teacher_id);
        $lesson = Lesson::find($cer->lesson_id);
        $student = Student::find($cer->student_id);
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;

        return view('students.new44.index ', compact('certificate', 'cer', 'teacher', 'student', 'room', 'class', 'lesson'));
    }
    public function ncertificate12($id)
    {
        $year = Year::where('current_year', '1')->first();
        $cer = Certificate::find($id);
        $certificate = Certificate_Fields::find($cer->certificate);
        $teacher = Teacher::find($cer->teacher_id);
        $lesson = Lesson::find($cer->lesson_id);
        $student = Student::find($cer->student_id);
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;

        return view('students.ncertificaate.index ', compact('certificate', 'cer', 'teacher', 'student', 'room', 'class', 'lesson'));
    }

    public function newcerti($id)
    {
        $year = Year::where('current_year', '1')->first();
        $cer = Certificate::find($id);
        $certificate = Certificate_Fields::find($cer->certificate);
        $teacher = Teacher::find($cer->teacher_id);
        $lesson = Lesson::find($cer->lesson_id);
        $student = Student::find($cer->student_id);
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;

        return view('students.newcerti.index ', compact('certificate', 'cer', 'teacher', 'student', 'room', 'class', 'lesson'));
    }
    public function certificate_22($id)
    {
        $year = Year::where('current_year', '1')->first();
        $cer = Certificate::find($id);
        $certificate = Certificate_Fields::find($cer->certificate);
        $teacher = Teacher::find($cer->teacher_id);
        $lesson = Lesson::find($cer->lesson_id);
        $student = Student::find($cer->student_id);
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;

        return view('students.certificate-2.index ', compact('certificate', 'cer', 'teacher', 'student', 'room', 'class', 'lesson'));
    }
    public function new2($id)
    {
        $year = Year::where('current_year', '1')->first();
        $cer = Certificate::find($id);
        $certificate = Certificate_Fields::find($cer->certificate);
        $teacher = Teacher::find($cer->teacher_id);
        $lesson = Lesson::find($cer->lesson_id);
        $student = Student::find($cer->student_id);
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;

        return view('students.new2.index ', compact('certificate', 'cer', 'teacher', 'student', 'room', 'class', 'lesson'));
    }


    public function student_exam()
    {

          $year = Year::where('current_year', '1')->first();

        $student = Student::find(auth()->user()->student_id);

         $room = $student->room->where('year_id', $year->id)->first();
         if (!$room) {
 
            return redirect()->back();
        }
         $room_id = $room->id;
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;
        $school_data = School_data::first();
        return view('students.student_exam', compact('school_data','student', 'class', 'room', 'room_id'));
    }
    public function student_view_report_card()
    {
        $year = Year::where('current_year', '1')->first();
        if (!isset($year)) {
            return redirect()->back()->with('error66', ' يجب تحديد العام الدراسي, تواصل مع الإدارة');
        }
        $student_id = Auth::user()->student_id;
        $student_marks = Students_mark::where('year_id', $year->id)
            ->where('student_id', $student_id)
            ->first();
        if (!isset($student_marks)) {
            return redirect()->back()->with('error66', 'الطالب لايملك سجل في العام المختار');
        }

        $current_term = Term_year::where('current_term', 1)->where('year_id', $year->id)->first();
        $current_term = isset($current_term) ? $current_term->type : 1;

        $student = Student::with(['room' => function ($q1) use ($year) {
            $q1->where('rooms.year_id', $year->id);
            // $q1->with('lessons') ;
        }])->findOrFail($student_id);
        $room = $student->room[0];
        $room_name = $room->name;
        $class_id = $room->class_id;
        $class = Classe::with(['report_card_details' => fn ($q) => $q->where('year_id', $year->id)])->findOrFail($class_id);
        $class_name = $class->name;
        $stage_id = $class->stage_id;
        $report_card_design = $class->report_card;
        //تمييز الأول الثانوي عن الثاني الثانوي
        $report_card_design = isset($report_card_design) ?   $report_card_design  : '5';
        $report_card_details = Report_card_details::where('class_id', $class->id)->where('year_id', $year->id)->first();
        $report_card = Report_card::where('student_id', $student_id)->where('year_id', $year->id)->first();
        //  through these condition we determine wich data to show in report card
        // these conditions has been made for student account, admin can visualize the report card at any time.
        if (!isset($report_card))
            return redirect()->back()->with('error66', ' جلاء الطالب غير مكتمل يرجى التواصل مع الإدارة  ');
        if ($report_card_details->report_card_status == 0)
            return redirect()->back()->with('error66', 'لم يتم استصدار الجلاء بعد ');

        $room_id = $room->id;
        $room_students = Room::find($room_id)->student()->orderBy('first_name')->pluck('students.id')->toArray();


        // to determin the term that the student came in..
        $room_student = Room_student::where('room_id', $room_id)
            ->where('student_id', $student->id)
            ->where('year_id', $year->id)
            ->first();

        $rigistration_term = isset($room_student) ?  $room_student->term : 1;
        if ($rigistration_term == 1  || $rigistration_term ==  2) {
            // case first term or second term with marks from term1
            $student_rigistration_term = 1;
        } else {
            // case second term without marks for first term
            $student_rigistration_term = 2;
        }






        $serial_number = $this->get_student_serial_num($student_id);
        $student->serial_number = $serial_number;



        $mark_base_subjects = Base_subjects::whereHas('lessons_mark', function ($query) use ($class,$student) {
            $query->where('class_id', $class->id);
            $query->where(function($b) use ($student)
                {
                    $b->where('religion', $student->religion);
                    $b->orWhereNull('religion');
                });
            $query->where(function($d) use ($student)
                {
                    $d->where('lang', $student->lang);
                    $d->orWhereNull('lang');
                });
            })
            ->with(['lessons_mark2' => function ($q) use ($class) {
                $q->where('class_id', $class->id);
            }])
            ->with(['lessons_mark' => function ($q) use ($class, $student) {
                $q->where('class_id', $class->id);
                // if ( $q->religion != null){
                //     $q->where('class_id', $class->id)
                //     ->where('religion', $student->religion) ;
                // }else{
                //     $q->where('class_id', $class->id);
                // }

            }])
            ->get()->sortBy('lessons_mark2.certificate_order')->flatten(1);

        $year_name = $year->name;

        $teacher_name = '';

        if ($stage_id == 1 || $stage_id == 2) {
            $lessons = Lesson::where('class_id', $class->id)->get();
            if (isset($lessons) && count($lessons) > 0) {
                foreach ($lessons as $lesson) {
                    if ($lesson->is_addable == 0) {
                        $teacher_id = Teacher_room_lesson::where('lesson_id', $lesson->id)->where('room_id', $student->room[0]->id)->first();
                        if (isset($teacher_id)) {
                            $teacher_id = $teacher_id->teacher_id;
                            $teacher = Teacher::findOrFail($teacher_id);
                            $teacher_name = $teacher->first_name . ' ' . $teacher->last_name;
                        }
                    }
                }
            }
        }

        //  through these condition we determine wich data to show in report card
        // these conditions has been made for student account, admin can visualize the report card at any time.
        if ($report_card->adjustable == 0) {
            $current_term = 0;
        } elseif ($report_card->adjustable == 1 && (auth()->user()->type != 2)) {
            $current_term = 1;
        } elseif ($report_card->adjustable == 2) {
            $current_term = 2;
        }




         if ($class->report_card  == 1) {
            // من أجل اللغة العربية لأنها مؤلفة من مادة المهارات الشفوية ومادة المهارات الكتابية
            $addable_lessons = Lesson::where('class_id', $class->id)->where('is_addable',0)->orderBy('certificate_order')->get();
            return view('admin.certificate_first_grade_updated', compact('current_term', 'student', 'room', 'class', 'class_name', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'addable_lessons', 'teacher_name', 'report_card_details', 'student_rigistration_term'));
        } else if ($class->report_card   == 2) {
            // من أجل اللغة العربية لأنها مؤلفة من مادة المهارات الشفوية ومادة المهارات الكتابية
        $addable_lessons = Lesson::where('class_id', $class->id)->where('is_addable',0)->orderBy('certificate_order')->get();
            return view('admin.certificate_second_grade_updated', compact('current_term', 'student', 'room', 'class', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'addable_lessons', 'teacher_name', 'report_card_details', 'student_rigistration_term'));
        } else if ($class->report_card   == 3) {
             return view('admin.certificate_third_grade_7_8_updated', compact('current_term', 'student', 'room', 'class', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'report_card_details', 'student_rigistration_term'));
        } else if ($class->report_card   == 4) {
            return view('admin.certificate_third_grade_9_updated', compact('current_term', 'student', 'room', 'class', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'report_card_details', 'student_rigistration_term'));
        } else if (in_array($class->report_card,  [5,6])) {
            return view('admin.certificate_third_grade_10_updated', compact('current_term', 'student', 'room', 'class', 'stage_id', 'report_card_design', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'report_card_details', 'student_rigistration_term','className'));
        } else if (in_array($class->report_card,  [7,8])) {
            return view('admin.certificate_third_grade_11_updated', compact('current_term', 'student', 'room', 'class', 'stage_id', 'report_card_design', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'report_card_details', 'student_rigistration_term','className','report_card_design'));
        } else if (in_array($class->report_card,  [9,10])) {
            return view('admin.certificate_third_grade_12_updated', compact('current_term', 'student', 'room', 'class', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'report_card_details', 'student_rigistration_term','className'));
        } else {
            $addable_lessons = Lesson::where('class_id', $class->id)->orderBy('certificate_order')->get();
            // return view('admin.certificate_first_grade3',compact('current_term','student','room','class','stage_id','year_name','room_name','lessons','student_marks','mark_base_subjects','report_card','addable_lessons','report_card_details'));
            return view('admin.certificate_third_grade_7_8_updated', compact('current_term', 'student', 'room', 'class', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'report_card_details', 'student_rigistration_term'));
        }
    }

    public function get_student_serial_num($student_id)
    {
        $year = Year::where('current_year', '1')->first();
        $student = Student::with(['room' => function ($q1) use ($year) {
            $q1->where('rooms.year_id', $year->id);
        }])->findOrFail($student_id);
        $room = $student->room[0];
        $room_students = Room::find($room->id)->student()->orderBy('first_name')->pluck('students.id')->toArray();
        $serial_number = array_search($student_id, $room_students) + 1;


        // $serial_number = 0;
        // foreach($room_students as $key => $stu){

        //     if ($student_id == $stu )  $serial_number = $key +1 ;
        // }
        return $serial_number;
    }

    //// add invoice

    public function add_payment_receipts(Request $request)
    {

        //  return  $request->all();
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'file.required' => 'يرجى  ترفيع  بالشروط المحددة  ',
        ]);

        $invoices = new Image_Invoice;
        $invoices->student_id = auth()->user()->student_id;
        if ($request->file && $request->hasFile('file')) {
            $invoices->file =  $request->file->store('filesstudents', 'public');
            $invoices->extension =  $request->file->extension();
        }
        $invoices->save();
        session()->flash('success', ' !  تم رفع الفاتورة بنجاح    ');

        return redirect()->back()->with('success', '! تم رفع الفاتورة بنجاح  ');
    }
    // public function payment_receipts_last( $student_id)
    // {
    //     $year=Year::where('current_year','1')->first();
    //     $invoice=  Invoice :: where('student_id',$student_id)->where('year_id',$year->id)->latest('id')->first();

    //     return $invoice;
    // }

    public function available_schedule($room_id, $student_id)
    {

        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);

        $student = Student::findOrFail($student_id);

        $schedule_day = Lesson_room_teacher_lecture_time::with('lesson', 'teacher')
            ->where('room_id', $room_id)->where('day_id', $today + 1)->get();
        $available_lecture = '';
        foreach ($schedule_day  as $key => $today_lecture) {

            $lesson = Lesson::findOrFail($today_lecture->lesson_id);

            if ($lesson->lang != $student->lang && $lesson->lang != null) {
                continue;
            } else if ($lesson->religion != $student->religion && $lesson->religion != null) {
                continue;
            }

            $lecture_time = Lecture_time::findOrFail($today_lecture->lecture_time_id);

            $hourMin = date('H:i');
            if ($hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time) {
                $today_lecture->inter = true;
                $available_lecture = $today_lecture;
                break;
            }
        }

        return $available_lecture;
    }

    /// student_info
    public function student_info(Request $request)
    {
        $year = Year::where('current_year', '1')->first();

        $student = Student::find(auth()->user()->student_id);
        $student_id = $student->id;
        $item = Room_student::where('student_id', $student_id)->where('year_id', $year->id)->first();
        if ($item == "") {

            return redirect()->back();
        }


        $room = Room::with('classes')->where('id', $item->room_id)->first();
        $room_id = $room->id;
        $student_detail = Student_detail::where('student_id', $student_id)->first();
        return view('students.student_info', compact('student', 'student_id', 'room_id', 'student_detail'));
    }
    public function edit_student_info(Request $request, $student_id)
    {

        $user = User::where('student_id', $student_id)->first();

        $year = Year::where('current_year', '1')->first();

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'father_name' => 'required',
        ]);

        $student = Student::find($student_id);
        $student_religion = $student->religion;

        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->first_name_en = $request->first_name_en;
        $student->last_name_en = $request->last_name_en;
        $student->email = $request->email;
        $student->date_birth = $request->date_birth;
        $student->age = $request->age;
        $student->nationality = $request->nationality;
        $student->place_birth = $request->place_birth;
        $student->address = $request->address;
        $student->box_birth = $request->box_birth;
        $student->army_room = $request->army_room;
        $student->religion = $request->religion;

        $student_detail = Student_detail::where('student_id', $student->id)->first();
        $student_detail->father_name = $request->father_name;
        $student_detail->mother_name = $request->mother_name;
        $student_detail->mother_phone = $request->mother_phone;
        $student_detail->father_phone = $request->father_phone;
        $student_detail->mother_job = $request->mother_job;
        $student_detail->father_job = $request->father_job;
        $student_detail->phone = $request->phone;
        $student_detail->other_phone = $request->other_phone;
        $student_detail->city = $request->city;
        $student_detail->passport_number = $request->passport_number;
        $student_detail->gender = $request->gender;
        $student_detail->last_mother_name = $request->last_mother_name;
        $student_detail->the_ID_number = $request->the_ID_number;



        if ($request->hasFile('personal_image')) {

            $this->validate($request, [
                'personal_image' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'personal_image.required' => 'يرجى  ترفيع  الصورة الشخصية بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->personal_image);

            $student_detail->personal_image = $request->personal_image->store('studentsimage', 'public');
        }
        if ($request->hasFile('family_book')) {
            $this->validate($request, [
                'family_book' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'family_book.required' => 'يرجى  ترفيع  دفتر العائلة  بالشروط المحددة  ',

            ]);

            Storage::disk('public')->delete($student_detail->family_book);

            $student_detail->family_book = $request->family_book->store('studentsimage', 'public');
        }
        if ($request->hasFile('mother_image')) {
            $this->validate($request, [
                'mother_image' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'mother_image.required' => 'يرجى  ترفيع   صورة هوية الام بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->mother_image);

            $student_detail->mother_image = $request->mother_image->store('studentsimage', 'public');
        }
        if ($request->hasFile('father_image')) {
            $this->validate($request, [
                'father_image' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'father_image.required' => 'يرجى  ترفيع   صورة هوية الاب  بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->father_image);

            $student_detail->father_image = $request->father_image->store('studentsimage', 'public');
        }
        if ($request->hasFile('fourth_image')) {
            $this->validate($request, [
                'fourth_image' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'fourth_image.required' => 'يرجى  ترفيع  صورة  اخراج القيد     بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->fourth_image);

            $student_detail->fourth_image = $request->fourth_image->store('studentsimage', 'public');
        }
        if ($request->hasFile('passport')) {
            $this->validate($request, [
                'passport' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'passport.required' => 'يرجى  ترفيع    جواز السفر بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->passport);

            $student_detail->passport = $request->passport->store('studentsimage', 'public');
        }
        if ($request->hasFile('mother_page')) {
            $this->validate($request, [
                'mother_page' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'mother_page.required' => 'يرجى  ترفيع  جواز سفر الام  بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->mother_page);

            $student_detail->mother_page = $request->mother_page->store('studentsimage', 'public');
        }
        if ($request->hasFile('father_page')) {
            $this->validate($request, [
                'father_page' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'father_page.required' => 'يرجى  ترفيع    جواز سفر الاب  بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->father_page);

            $student_detail->father_page = $request->father_page->store('studentsimage', 'public');
        }
        if ($request->hasFile('study_sequence')) {
            $this->validate($request, [
                'study_sequence' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'study_sequence.required' => 'يرجى  ترفيع    التسلسل الدراسي بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->study_sequence);

            $student_detail->study_sequence = $request->study_sequence->store('studentsimage', 'public');
        }
        if ($request->hasFile('certification')) {
            $this->validate($request, [
                'certification' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'certification.required' => 'يرجى  ترفيع  اخر شهادة  بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->certification);

            $student_detail->certification = $request->certification->store('studentsimage', 'public');
        }
        if ($request->hasFile('certification_nine')) {
            $this->validate($request, [
                'certification_nine' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

            ], [
                'certification_nine.required' => 'يرجى  ترفيع   شهادة التاسع  بالشروط المحددة  ',

            ]);
            Storage::disk('public')->delete($student_detail->certification_nine);

            $student_detail->certification_nine = $request->certification_nine->store('studentsimage', 'public');
        }


        $lessons = [];

        if ($student_religion != $request->religion) {

            if ($student_religion == '0') {
                $lessons = Lesson::where('class_id', $request->class_id)->where('religion', '0')->get();
            } elseif ($student_religion == '1') {
                $lessons = Lesson::where('class_id', $request->class_id)->where('religion', '1')->get();
            }
            if (count($lessons) > 0) {
                foreach ($lessons as $lesson) {

                    if ($lesson->religion != null) {

                        $student_mark = Students_mark::where('student_id', $student->id)->where('religion', $student_religion)->where('year_id', $year->id)->first();

                        if (isset($student_mark) && $student_mark != "") {

                            $arr1 = json_decode($student_mark->mark, true);
                            $arr2 = json_decode($student_mark->mark2, true);
                            $arr_result1 = json_decode($student_mark->result1, true);
                            $arr_result2 = json_decode($student_mark->result2, true);
                            $arr_result = json_decode($student_mark->result, true);

                            if (array_key_exists($lesson->id, $arr1) == '1') {

                                unset($arr1[$lesson->id]);

                                $student_mark->mark = json_encode($arr1);
                            }

                            if (array_key_exists($lesson->id, $arr2)) {

                                unset($arr2[$lesson->id]);
                                $student_mark->mark2 = json_encode($arr2);
                            }


                            if (array_key_exists($lesson->id, $arr_result1)) {

                                unset($arr_result1[$lesson->id]);
                                $student_mark->result1 = json_encode($arr_result1);
                            }

                            if (array_key_exists($lesson->id, $arr_result2)) {

                                unset($arr_result2[$lesson->id]);
                                $student_mark->result2 = json_encode($arr_result2);
                            }

                            if (array_key_exists($lesson->id, $arr_result)) {

                                unset($arr_result[$lesson->id]);
                                $student_mark->result = json_encode($arr_result);
                            }


                            $student_mark->save();

                            $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();

                            $result_term1 = 0;
                            $result_term2 = 0;

                            $count1 = 0;
                            $count2 = 0;

                            foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {

                                $result_term1 = $result_term1 + $value1['term1_result'];
                                $count1++;
                            }
                            foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {

                                $result_term2 = $result_term2 + $value1['term2_result'];
                                $count2++;
                            }

                            $objec_term_result = json_decode($student_mark->term_result, true);
                            $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 / $count1 : "0";
                            $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2 / $count2 : "0";

                            $student_mark->term_result = json_encode($objec_term_result);
                            $student_mark->save();
                            $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();


                            $year_result = (json_decode($student_mark->term_result, true)['term1'] + json_decode($student_mark->term_result, true)['term2']) / 2;

                            $student_mark->year_result = $year_result;
                            $student_mark->save();
                        }
                    }
                }
            }
        }

        if ($student_religion != $request->religion) {


            if ($request->religion == '0') {
                $lessons = Lesson::where('class_id', $request->class_id)->where('religion', '0')->get();
            } elseif ($request->religion == '1') {
                $lessons = Lesson::where('class_id', $request->class_id)->where('religion', '1')->get();
            }



            foreach ($lessons as $lesson) {

                $item = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();

                $a1 = json_decode($item->mark, true);

                $a1[$lesson->id] = [
                    'oral' => null,
                    'homework' => null,
                    'activities' => null,
                    'quize' => null,
                    'exam' => null,
                ];

                $item->mark = json_encode($a1);

                $a2 = json_decode($item->mark2, true);
                $a2[$lesson->id] = [
                    'oral' => null,
                    'homework' => null,
                    'activities' => null,
                    'quize' => null,
                    'exam' => null,
                ];

                $item->mark2 = json_encode($a2);


                $a3 = json_decode($item->result1, true);
                $a3[$lesson->id] = [
                    'term1_quizes' => null,
                    'term1_exam' => null,
                    'term1_result' => null,
                ];

                $item->result1 = json_encode($a3);


                $a4 = json_decode($item->result2, true);
                $a4[$lesson->id] = [
                    'term2_quizes' => null,
                    'term2_exam' => null,
                    'term2_result' => null,
                ];

                $item->result2 = json_encode($a4);

                $a5 = json_decode($item->result, true);
                $a5[$lesson->id] = [
                    'year_result' => null,

                ];

                $item->result = json_encode($a5);
                $item->save();
            }
        }


        $student_mark_new = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();

        $student_mark_new->religion = $request->religion;

        $student_mark_new->save();

        $student->religion = $request->religion;



        $year = Year::where('current_year', '1')->first();

        $room_student = Room_student::where('student_id', $student->id)->where('year_id', $year->id)->first();
        if ($room_student->room_id != $request->room_id) {
            // change room
            $room_student->room_id = $request->room_id;
            $room_student->save();
            // change student exams result to the new room
            $exam_result = Exam_result::where('user_id', $student->id)->get();
            foreach ($exam_result as $item) {
                $item->room_id = $request->room_id;
                $item->save();
            }
            // change student marks to the new room
            $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();
            $student_mark->room_id = $request->room_id;
            $student_mark->save();


            // change student uploaded files to the new room
            $saved_files = Student_lesson_teacher_room_term_exam::where('student_id', $student->id)->get();
            foreach ($saved_files as $item2) {
                $item2->room_id = $request->room_id;
                $item2->save();
            }
        }


        $user = User::where('student_id', $student_id)->first();

        $student->email = $request->email;


        $student_detail->save();
        $student->save();
        $user = User::where('student_id', $student->id)->first();
        // $user->email=$request->email;
        $user->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function modification_request(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'student_id' => 'required',

        ]);

        $modification_request = new Modification_Request();
        $modification_request->student_id = $request->student_id;
        $modification_request->phone = $request->phone;
        $modification_request->message = $request->message;

        $modification_request->save();
        return redirect()->back()->with('success1', '! تم ارسال طلب تعديل معلومات بنجاح   ');
    }

    public function studentSaveToken(Request $request){
             $old_tokens = Studentfcmtoken::where('s_fcm_token',$request->fcm_token)->get();
             if($old_tokens){
                 foreach( $old_tokens as $old_token){
                     $old_token->delete();
                 }

          }

              $item = new Studentfcmtoken();
             $item->s_fk=auth()->user()->student_id;
             $item->s_fcm_token=$request->fcm_token;

                 $item->save();


$old_token = Studentfcmtoken::where('s_fk',auth()->user()->student_id)->where('s_fcm_token',$request->fcm_token)->first();



  return response()->json([
            'status' => true,
            'msg' => $old_token
        ]);
}
//اظهار اشعار كمقروء
 public function read_notification($id)
    {
      $notification=Notification::find($id);
       $notification->created_at=$notification->created_at;
      $notification->view=1;

      $notification->save();

     return 1;
    }

 ///  المكافئات والعقوبات 
    public function student_rewads($student_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $student = Student::find($student_id);
        $year = Year::where('current_year', '1')->first();
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $room_id = $room->id;
        $class = $room->classes;
        $rewads = Rewad_and_sanction_student::with('lesson')->where('student_id', $student_id)->where('term_id', $term->id)->orderBy('updated_at', 'desc')->get();

        return view('students.student_rewads', compact('student', 'room', 'class', 'room_id','rewads'));
    }
    public function student_sanctions($student_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $student = Student::find($student_id);
        $year = Year::where('current_year', '1')->first();
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $room_id = $room->id;
        $class = $room->classes;
        $rewads = Rewad_and_sanction_student::with('lesson')->where('student_id', $student_id)->where('type', 2)->where('term_id', $term->id)->orderBy('updated_at', 'desc')->get();

        return view('students.student_sanctions', compact('student', 'room', 'class', 'room_id','rewads'));
    }
    public function deletekey_notification()
    {
  
         $old_tokens = Studentfcmtoken::where('s_fk',auth()->user()->student_id)->delete();
        return 1;
    }
    
    
}
