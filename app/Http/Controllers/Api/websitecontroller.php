<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\before_room_student;
use App\Student_lesson_teacher_room_term_exam;
use App\Category;
use App\Classe;
use App\Means;
use App\Road;
use App\Policy;
use App\Medal;
use App\HomeAbout;
use App\HomeContact;
use App\HomeCounter;
use App\HomeCourseCat;
use App\HomeCourseSubCat;
use App\HomeLogo;
use App\HomeSlider;
use App\HomeWhyChooseUs;
use App\Room;
use App\Parents;
use App\Objection;
use App\Lesson;
use App\Teacher_room_lesson;
use App\Lesson_teacher_room_term_exam;
use DateTime;
use App\Lecture;
use App\Students_mark;
use App\Exam_result;
use App\Exam_result2;
use App\Exams2;
use App\Room_student;
use App\Student;
use App\Teacher;
use App\Tofel_exam;
use App\Tofel_model;
use App\Text;
use App\Word;
use App\Website_online;
use App\Message;
use App\Chat;
use App\Question;
use App\User;
use App\Lecture_time;
use App\Day;
use App\Lesson_room_teacher_lecture_time;
use App\Student_schedule_tracer;
use App\Year;
use App\Term;
use App\Prepare;
use App\Term_year;
use App\Teacher_event;
use App\About_us;
use App\Exam_file;
use App\Certificate;
use App\Report_card_details;
use App\App_teacher_slider;
use App\App_student_slider;
use App\Parentfcmtoken;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use stdClass;

class websitecontroller extends Controller
{
    public  $year;

    public function __construct()
    {
        $this->year = Year::where('current_year', '1')->first();
    }
    public function fetchPolicyContent()
    {

        return  Policy::find(1)->content;
    }

    public function get_login_teacher_info(Request $request)
    {
        $user = User::with('teacher')->where('email', $request->email)->where('view_password', $request->password)->first();
        if ($user) {
            return response()->json(['msg' => $user, 'status' => '1']);
        } else {
            return response()->json(['msg' => 'No user', 'status' => '0']);
        }
    }


    public function get_certificate($student_id)
    {
        $certificate = Certificate::with('lesson')->with('teacher')->where('student_id', $student_id)->get();
        $link2 = "https://www.google.com";
        $link = "http://localhost:8087/SMARMANger/dashboard/student/medals/" . $student_id;
        return response()->json(['certificate' => $certificate, 'web_link' => $link]);
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
        $x = [];
        foreach ($classes as $class) {
            array_push($x, $class);
        }
        $classes =  $x;
        return response()->json(['classes' => $classes]);
    }
    public function teacher_event($teacher_id)
    {
        $events = Teacher_event::where('teacher_id', $teacher_id)->get();
        return response()->json(['event' => $events]);
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
        $x = [];
        foreach ($class_rooms as $room) {
            array_push($x, $room);
        }
        $class_rooms =  $x;

        return response()->json(['rooms' => $class_rooms]);
    }


    public function teacher_subjects($room_id, $teacher_id)
    {

        $teacher = Teacher::find($teacher_id);
        $lessons = $teacher->lessons;
        $room_lessons = [];
        $teacher_room_lessons = Teacher_room_lesson::where('room_id', $room_id)->where('teacher_id', $teacher_id)->get();
        $teacher_lessons = [];
        foreach ($teacher_room_lessons as $teacher_room_lesson) {

            $teacher_lessons[] = Lesson::find($teacher_room_lesson->lesson_id);
        }

        return response()->json(['subjects' => $teacher_lessons]);
    }




    public function teacher_lessons($subject_id, $room_id, $teacher_id)
    {

        $term = Term_year::where('current_term', '1')->first();
        $teacher = Teacher::find($teacher_id);
        $lesson = Lesson::find($subject_id);
        $lectures = $lesson->lectures()->where('room_id', $room_id)->where('term_id', $term->id)->where('active', 0)->get();

        return response()->json(['msg' => $lectures, 'subject' => $lesson]);
    }

    public function get_teacher_lesson_details($room_id, $teacher_id, $subject_id, $lesson_id, $type_id)
    {

        $teacher = Teacher::find($teacher_id);
        $room = Room::find($room_id);
        $lecture = Lecture::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $lesson = Lesson::find($subject_id);

        $room_id = $room_id;
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $now = Carbon::now();


        $lesson_details = Lesson_teacher_room_term_exam::where('room_id', $room_id)->where('lecture_id', $lesson_id)->where('type', $type_id)->orderBy("id", 'desc')->get();



        $term_id = Lesson_teacher_room_term_exam::where('lecture_id', $lesson_id)
            ->where('teacher_id', $teacher_id)->get();



        if ($term_id->count() != 0) {
            $term_id = $term_id[0]->term_id;
        }



        $answers = [];
        $available_lesson_detail = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)
            ->where('room_id', $room_id)->where('start_time', '<=', $now)->where('end_time', '>=', $now)->get();

        // return $available_lesson_detail;

        $count = Message::whereNull('view')->where('teacher_id', $teacher_id)->get();

        $count = $count->count();

        $year = Year::where('current_year', '1')->first();

        return response()->json([
            'lesson_details' => $lesson_details, 'subject' => $lesson,


        ]);
    }
    public function teacher_schedule($id)
    {
        $year = Year::where('current_year', '1')->first();

        $teacher = Teacher::find($id);
        $user = User::where('teacher_id', $id)->first();
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);
        $teacher_id = $id;
        $end_times = [];
        $end_times2 = [];
        $lecture_times = Lecture_time::all();
        // pring days
        $days = Day::all();



        $schedule = collect();

        $end_times_teacher_list = [];
        foreach ($days  as $day) {

            $schedule_day = Lesson_room_teacher_lecture_time::with('lesson', 'lecture_time')
                ->WhereHas('room', function ($q) use ($year) {
                    $q->where('year_id', $year->id);
                })
                ->with(['room.classes' => function ($query) {
                    $query->select("id", "name");
                }])
                ->join('lecture_times', 'lecture_times.id', '=', 'lesson_room_teacher_lecture_time.lecture_time_id')
                ->orderBy('lecture_times.start_time')
                ->select("lesson_room_teacher_lecture_time.*")
                ->where('teacher_id', $id)
                ->where('day_id', $day->id)->get();



            if ($day->id == $today + 1) {

                $student_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::today())->where('user_id', $user->id)->get();
                foreach ($schedule_day  as $key => $today_lecture) {

                    $tracer =  $student_schedule_tracer->where('lecture_time_id', $today_lecture->lecture_time_id);
                    if (!blank($tracer)) {
                        $today_lecture->attendance = true;
                    } else {
                        $today_lecture->attendance = false;
                    }

                    $lecture_time = Lecture_time::findOrFail($today_lecture->lecture_time_id);
                    $hourMin = date('H:i');
                    if ($hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time) {
                        $today_lecture->inter = true;
                    } else {
                        $today_lecture->inter = false;
                    }

                    $lecture_time->end_time = \Carbon\Carbon::parse($lecture_time->end_time);

                    $end_times[$lecture_time->end_time->format('H:i')] = $lecture_time->name;
                    $end_times2[] = $lecture_time->end_time->format('H:i');
                }
            } else {
                foreach ($schedule_day  as $key => $today_lecture) {
                    $today_lecture->inter = false;
                }
            }
            $pbject = new stdClass;
            $pbject->{$day->id} = $schedule_day;
            $schedule[] = $pbject;
        }
        //   en end end


        foreach ($lecture_times as $lecture_time) {

            if ($lecture_time->type == '2') {
                $lecture_time->end_time = \Carbon\Carbon::parse($lecture_time->end_time);

                $end_times[$lecture_time->end_time->format('H:i')] = $lecture_time->name;
                $end_times2[] = $lecture_time->end_time->format('H:i');
            }
        }


        return response()->json(['schedule' => $schedule, 'status' => '1', 'end_times' => $end_times, 'end_times2' => $end_times2]);

        // return view('admin.new_teacher_schedule',compact('teacher','now','teacher_id','lecture_times','days','schedule','today'));
    }


    public function get_room_student($room_id)
    {
        $room_students = Room::with(['student' => fn ($q1) => $q1->select('students.id', 'first_name', 'last_name')])->find($room_id)->student;
        return response()->json(['room_students' => $room_students]);
    }
    public function key(Request $request)
    {
        $lecture = Lecture::find($request->id);

        if ($lecture->key == 0) {

            $lecture->key = '1';
            $lecture->save();
            // none 1
            return "success";
        } else {
            $lecture->key = '0';
            $lecture->save();
            // veiw 0
            return "success";
        }
    }










    public function store_lecture(Request $request)
    {

        $year = Year::where('current_year', '1')->first();

        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $item = new Lecture;
        $item->teacher_id = $request->teacher_id;
        $item->class_id = $request->class_id;
        $item->room_id = $request->room_id;
        $item->lesson_id = $request->lesson_id;
        $item->year_id = $year->id;
        $item->term_id = $term->id;
        $item->name = $request->name;
        // $item->start_time = $request->start_time;
        // $item->end_time = $request->end_time;
        // $item->start_date = $request->start_date;
        // $item->end_date = $request->end_date;
        $item->save();
        return response()->json(['msg' => 'saved correctly', 'status' => 1]);
    }
    
        public function dalete_lecture(Request $request)
    {

        $now=Carbon::now() ;
        $lectures = Lecture::find($request->lesson_id);
        if($lectures->lecture_time < $now ) {
            $room = Room::find($lectures->room_id);
            $students = $room->student;
            // foreach($students as $student){
            // $noti = new Notification;
            //     $noti->user_id = Auth::user()->id;
            //     $noti->lesson_id = $lectures->lesson_id;
            //     $noti->student_id = $student->id;
            //     $noti->room_id = $lectures->room_id;
            //     $noti->lecture_id = $lectures->id;
            //     $noti->title ="تم حذف درس ";
            //     $noti->body = $lectures->name;
            //     $noti->term_id = $lectures->term_id;
            //     $noti->type = 6;
            //     $noti->save();
            //     $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

            //      $devices = array();
            //      foreach($tokens as $t){
            // array_push($devices, $t['s_fcm_token']);
            // //array_push($devices['p_id'], $t['p_fk']);
            //     }
            //     $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$noti->room_id,$noti->lesson_id, $noti->lecture_id,$devices);

            // }
            }
            $lectures->active=1;
             $lectures->save();
        // $lectures->delete();

        return response()->json(['msg' => 'delete correctly', 'status' => 1]);
    }


    public function store_items(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $item = new Lesson_teacher_room_term_exam;



        // video case 0 ;

        if ($request->type == '0') {

            if (!isset($request->file) && !isset($request->link)) {
                return response()->json(['msg' => 'select file or link', 'status' => false]);
            }
            $item->name_video = $request->name;
            $item->video_link = $request->link;
            $item->type_video = '1'; // link

            if (isset($request->file) && $request->file != null && $request->file != 'null') {
                $image = base64_decode($request->file);
                $random = Str::random(10);
                Storage::disk('public')->put("filesteachers/$random.$request->extension", $image);
                $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

                $item->video = "filesteachers/$random.$request->extension";
                $item->extension =  $request->extension;
                $item->type_video = '1'; // file

            }
            $item->save();
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $term->id;
            $item->type = $request->type;
            $item->lecture_id = $request->lecture_id;

            $item->save();

            return response()->json(['msg' => ' saved correctly', 'status' => true]);
        }
        // homework case 1 ;
        if ($request->type == 1) {
            if (!isset($request->file) && !isset($request->link)) {
                return response()->json(['msg' => 'select file or link', 'status' => false]);
            }
            $item->namehomework = $request->name;
            $item->test_link = $request->test_link;
            $item->start_time = $request->start_time;
            $item->end_time = $request->end_time;
            $item->type_file =  '0';

            if (isset($request->file) && $request->file != null && $request->file != 'null') {
                $image = base64_decode($request->file);
                $random = Str::random(10);
                Storage::disk('public')->put("filesteachers/$random.$request->extension", $image);
                $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

                $item->test = "filesteachers/$random.$request->extension";
                $item->extension =  $request->extension;
                $item->type_file =  '1';
            }
            $item->save();

            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $term->id;
            $item->type = $request->type;
            $item->lecture_id = $request->lecture_id;

            $item->save();

            return response()->json(['msg' => ' saved correctly', 'status' => true]);
        }
        // audio and voice case 1 ;
        if ($request->type == 6) {

            if (!isset($request->file) && !isset($request->link)) {
                return response()->json(['msg' => 'select file or link', status => false]);
            }
            $item->name_audio = $request->name;
            $item->audio_link = $request->test_link;
            $item->type_voice =  '0';

            $image = base64_decode($request->file);
            $random = Str::random(10);
            Storage::disk('public')->put("filesteachers/$random" . $request->anyfile_extension, $image);
            $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

            $item->audio_file = "filesteachers/$random" . $request->anyfile_extension;
            $item->extension = substr($request->anyfile_extension, 1);
            $item->save();

            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $term->id;
            $item->type = $request->type;
            $item->lecture_id = $request->lecture_id;

            $item->save();

            return response()->json(['msg' => ' saved correctly', 'status' => true]);
        }

        //case addition file
        if ($request->type == 4) {
            if (!isset($request->file) && !isset($request->link)) {
                return response()->json(['msg' => 'select file or link', 'status' => false]);
            }
            $item->name_addition = $request->name;


            if (isset($request->file) && $request->file != null && $request->file != 'null') {
                $image = base64_decode($request->file);
                $random = Str::random(10);
                Storage::disk('public')->put("filesteachers/$random" . $request->anyfile_extension, $image);
                $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

                $item->addition = "filesteachers/$random" . $request->anyfile_extension;
                $item->extension = substr($request->anyfile_extension, 1);
            }
            $item->save();

            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $term->id;
            $item->type = $request->type;
            $item->lecture_id = $request->lecture_id;

            $item->save();

            return response()->json(['msg' => ' saved correctly', 'status' => true]);
        }
        return 25;


        // if ($request->test && $request->hasFile('test')) {

        //     $item->test = $request->test->store('filesteachers', 'public');

        //     }
        //     // test: وظيفة case 1 ;
        //     else if ($request->type == 1){
        //         $this->validate($request, [
        //             'test_start_time' => 'required',
        //             'test_end_time' => 'required',
        //         ],[
        //             'test_start_time.required' => 'يرجى  تحديد  وقت البداية ',
        //             'test_end_time.required' => 'يرجى  تحديد  وقت النهاية ',
        //         ]);

        //         $item->start_time = $request->test_start_time;
        //         $item->end_time = $request->test_end_time;

        //         if ($request->item_type == 1){
        //             $this->validate($request, [
        //                 'success_mark' => 'required',
        //             ],[
        //                 'success_mark.required' => 'يرجى  تحديد  علامة النجاح  ',
        //             ]);
        //             $item->success_mark =  $request->success_mark;
        //             $item->type_file =  '2';
        //             // save dafault result on students results
        //             $studens=Room::find($request->room_id)->student;

        //             foreach ($studens as $student) {
        //                 $item2=new Exam_result();
        //                 $item2->class_id = $request->class_id;
        //                 $item2->room_id = $request->room_id;
        //                 $item2->exam_id = $item->id;
        //                 $item2->user_id = $student->id;
        //                 $item2->lesson_id = $request->lesson_id;
        //                 $item2->lecture_id = $request->lecture_id;

        //                 $item2->type = $item->type;
        //                 $item2->save();
        //             }
        //         }
        //         else if($request->item_type == 2){
        //             if (!isset($request->file)){
        //                 $this->validate($request, [
        //                     'link' => 'required',
        //                 ],[
        //                     'link.required' => 'يرجى  تحميل المحتوى أو ادخال رابط له',
        //                 ]);
        //             }
        //             if ($request->link!=null) {
        //                 $item->test = $request->link;
        //                 $item->type_file =  '1'; // the file is coming from link
        //             }
        //             elseif( $request->file && $request->hasFile('file')){
        //                 $item->test = $request->file->store('filesteachers', 'public');
        //                 $item->type_file =  '0';  // the file is coming from storage
        //             }
        //         }
        //     }



        // $item = new Lesson_teacher_room_term_exam;
        // $item->namehomework = $request->namehomework;
        // $item->lesson_id = $request->lesson_id;
        // $item->teacher_id = $request->teacher_id;
        // $item->room_id = $request->room_id;
        // $item->term_id = $request->term_id;
        // $item->type = $request->type;

        // if ($request->name_video == null && $request->name_audio == null &&  $request->namehomework == null &&  $request->name_quize == null  &&  $request->name_quize1 == null && $request->test == null && $request->name_addition == null &&  $request->name_exam == null) {

        //     return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        // }
        // if ($request->video == null && $request->video_in == null && $request->quize_link1 == null && $request->quize1 == null && $request->audio_file == null && $request->voice == null && $request->audio_link == null && $request->test == null && $request->quize == null && $request->exam == null && $request->test_link == null && $request->quize_link == null && $request->exam_link == null && $request->addition == null  &&  $request->addition_link == null) {

        //     return redirect()->back()->with('message', 'المحتوى فارغ يرجى اعادة تعبئة البيانات من جديد');
        // }




        // if ($request->video_in && $request->hasFile('video_in')) {
        //     $item->video = $request->video_in->store('filesteachers', 'public');
        //     $item->type_video = '0';

        //         if ($request->name_video == null){
        //             return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //         }

        //     $item->name_video = $request->name_video;
        //     $item->extension =  $request->video_in->extension();
        // }


        // if ($request->video != null) {
        //     $item->video_link = $request->video;
        //     if ($request->name_video == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_video = $request->name_video;

        //     $item->type_video = '1';
        // }


        // if ($request->audio_file && $request->hasFile('audio_file')) {
        //     $item->audio_file = $request->audio_file->store('filesteachers', 'public');
        //     $item->type_voice = '0';
        //     if ($request->name_audio == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_audio = $request->name_audio;

        //     $item->extension =  $request->audio_file->extension();
        // }


        // if ($request->audio_link  != null) {
        //     $item->audio_link = $request->audio_link;
        //     if ($request->name_audio == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_audio = $request->name_audio;

        //     $item->type_voice = '1';
        // }



        // if ($request->test_link != null) {
        //     $item->test_link = $request->test_link;
        //     $item->start_time = $request->test_start_time;
        //     $item->end_time = $request->test_end_time;
        //     $item->type_file =  '1';
        //     if ($request->namehomework == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->namehomework = $request->namehomework;
        // }

        // if ($request->test && $request->hasFile('test')) {

        //     $item->test = $request->test->store('filesteachers', 'public');
        //     $item->start_time = $request->test_start_time;
        //     $item->end_time = $request->test_end_time;
        //     if ($request->namehomework == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->namehomework = $request->namehomework;

        //     $item->extension =  $request->test->extension();
        // }

        // if ($request->quize_link != null) {


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

        // if ($request->addition && $request->hasFile('addition')) {
        //     $item->addition =  $request->addition->store('filesteachers', 'public');
        //     if ($request->name_addition == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_addition = $request->name_addition;

        //     $item->extension =  $request->addition->extension();
        // }
        // if ($request->addition_link != null) {
        //     $item->addition_link = $request->addition_link;
        //     if ($request->name_addition == null){
        //         return redirect()->back()->with('message', 'المحتوى الاسم  فارغ يرجى اعادة تعبئة البيانات من جديد');
        //     }
        //     $item->name_addition = $request->name_addition;
        // }



        // $item->lecture_id = $request->lecture_id;

        // $item->save();



        // return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }

    // ----------------------------- student stuff

    public function get_login_student_info(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $user_check = User::where('email', $request->email)->where('view_password', $request->password)->first();
        if ($user_check) {
            if ($user_check->type == '0') {
                $user = User::with(['student.room' => function ($q1) use ($year) {
                    $q1->where('rooms.year_id', $year->id);
                    $q1->select('rooms.id', 'class_id', 'name');
                    $q1->with('classes');
                }])->where('email', $request->email)->where('view_password', $request->password)->first();
                return response()->json(['msg' => $user, 'status' => '1', 'type' => '0']);
            } else  if ($user_check->type == '1') {
                $user = User::with('teacher')->where('email', $request->email)->where('view_password', $request->password)->first();
                return response()->json(['msg' => $user, 'status' => '1', 'type' => '1']);
            } else  if ($user_check->type == '6') {
                $user = User::with('parents')->where('email', $request->email)->where('view_password', $request->password)->first();
                return response()->json(['msg' => $user, 'status' => '1', 'type' => '6']);
            }
        } else {
            return response()->json(['msg' => 'No user', 'status' => '0']);
        }
    }
    //  public function get_login_student_info(Request $request){

    //     $user=User::with('student.room.classes')->where('email',$request->email)->where('view_password',$request->password)->first();
    //     if($user){
    //             return response()->json(['msg'=>$user,'status'=>'1']);
    //     }else{
    //             return response()->json(['msg'=>'No user','status'=>'0']);
    //     }
    // }












    public function get_student_subjects($room_id, $student_id)
    {

        // $student_id = $student_id ;
        $year = Year::where('current_year', '1')->first();
        $student = Student::with('details')->find($student_id);
        $item = Room_student::where('student_id', $student_id)->where('year_id', $year->id)->first();
        if ($item == "") {

            return redirect()->back();
        }

        //  $room = Room::with('lessons3')->find($item->room_id);
        $room = Room::with('classes')->where('id', $item->room_id)->first();
        //  return Lesson::where('class_id', $room->class_id)->get() ;
        //  return $room::with('lessons')->first() ;

        $room_id = $room->id;
        // $lessons= $room->teachers;
        $lessons = Room::with(['lessons' => function ($q) use ($year) {
            $q->with('teachers');
            $q->where('year_id', $year->id);
        }])->find($room->id);

        //   $lessons = $lessons->lessons ;
        if ($student->lang == null || $student->religion == null)
            return response()->json(['msg' => 'بيانات الطالب غير مكتملة', 'status' => '0']);
        else if ($student->lang == '0' && $student->religion == '0') {

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
            $room->lessons2 = $lessons->unique();
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
            $room->lessons2 = $lessons->unique();
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
            $room->lessons2 = $lessons->unique();
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
            $room->lessons2 = $lessons->unique();
        }

        $count = Message::whereNull('view')->where('student_id', $student_id)->get();

        $count = $count->count();

        // $lessons5 = [];
        // return $lessons ;
        //  foreach ($lessons as $lesson) {
        //     $lessons5[] = $lesson;
        // }
        // $lessons = json_encode(json_decode($lessons,true)) ;
        // $lessons = $lessons->unique();

        // return $lessons ;
        $class = $room->classes;


        //         $year=Year::where('current_year','1')->first();
        //         $student=Student::find($student_id);
        //         // $item=Room_student::where('student_id',$student_id)->where('year_id',$year->id)->first();
        //         //         if ($item=="") {

        //         //     return redirect()->back();
        //         // }
        //         $room=Room::with('classes')->where('id',$room_id)->first();

        //         $lessons= $room->teachers;
        //         // $l=Lesson::with('room','teachers')->where()
        //         $lessons=Room::with(['lessons'=>function($q){
        //             $q->with('teachers');
        //         }])->find($room->id);

        // if ($student->lang=='0' && $student->religion=='0') {

        //     $lessons=$lessons->lessons()->where(function ($query) {
        //         $query->where(function($q1){

        //             $q1->where('religion','<>','1');
        //             $q1->orwhere('religion',null);
        //             $q1->where('lang',null);

        //         });

        //         $query->orwhere(function($q2){

        //             $q2->where('lang','<>','1');

        //             $q2->orwhere('lang',null);
        //             $q2->where('religion',null);

        //         });



        //     }
        //     )->get();

        // }elseif($student->lang=='1' && $student->religion=='1'){

        //     $lessons=$lessons->lessons()->where(function ($query) {
        //         $query->where(function($q1){

        //             $q1->where('religion','<>','0');
        //             $q1->orwhere('religion',null);
        //             $q1->where('lang',null);

        //         });

        //         $query->orwhere(function($q2){

        //             $q2->where('lang','<>','0');

        //             $q2->orwhere('lang',null);
        //             $q2->where('religion',null);

        //         });



        //     }
        //     )->get();
        // }elseif($student->religion=='0' && $student->lang=='1'){

        //     $lessons=$lessons->lessons()->where(function ($query) {
        //         $query->where(function($q1){

        //             $q1->where('religion','<>','1');
        //             $q1->orwhere('religion',null);
        //             $q1->where('lang',null);

        //         });

        //         $query->orwhere(function($q2){

        //             $q2->where('lang','<>','0');

        //             $q2->orwhere('lang',null);
        //             $q2->where('religion',null);

        //         });



        //     }
        //     )->get();
        // }
        // elseif($student->religion=='1' && $student->lang=='0'){


        //     $lessons=$lessons->lessons()->where(function ($query) {
        //         $query->where(function($q1){

        //             $q1->where('religion','<>','0');
        //             $q1->orwhere('religion',null);
        //             $q1->where('lang',null);

        //         });

        //         $query->orwhere(function($q2){

        //             $q2->where('lang','<>','1');

        //             $q2->orwhere('lang',null);
        //             $q2->where('religion',null);

        //         });



        //     }
        //     )->get();

        // }

        //                 $count=Message::whereNull('view')->where('student_id',$student_id)->get();

        //                 $count=$count->count();
        //                 $collection = collect($lessons);
        //                 $lessons = $lessons->unique();



        // $class=$room->classes;
        // $lessons=$lessons->lessons->unique();
        // $lessons->lessons2=$lessons->lessons->unique();
        $lessons = $room;
        unset($lessons->lessons);

        return response()->json(['msg' => $lessons, 'status => 1']);
    }






    public function get_student_lessons($lesson_id, $room_id, $student_id)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', 1)->first();
        $lesson = Lesson::find($lesson_id);
        $lectures = $lesson->lectures()->where('room_id', $room_id)
            ->where('lesson_id', $lesson_id)
            ->where('term_id', $term->id)
            ->where('key', '0')
            ->where('active', '0')->get();
        $student = Student::with(['room' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find($student_id);

        $class = Room::find($room_id)->classes;
        $room = Room::find($room_id);
        $count = Message::whereNull('view')->where('student_id', $student_id)->get();

        $count = $count->count();


        return response()->json(['msg' => $lectures]);
    }




    public function teacher_book_details($lesson_id, $teacher_id, $room_id, $lecture_id, $type_id)
    {


        $teacher = Teacher::find($teacher_id);
        $book_details = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
            ->where('room_id', $room_id)->orderBy("id", 'desc')->get();

        $book_details = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('teacher_id', $teacher_id)
            ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->where('type', $type_id)->orderBy("id", 'desc')->get();

        $lesson = Lesson::find($lesson_id);


        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');

        $class = Room::find($room_id)->classes;
        $room = Room::find($room_id);

        $lecture = Lecture::find($lecture_id);


        return response()->json(['msg' => $book_details, 'lesson' => $lesson]);
    }





    public function get_student_lesson_details($room_id, $lesson_id, $student_id, $lecture_id, $type_id)
    {
        // Find the lecture
        $lecture = Lecture::find($lecture_id);
        $year = Year::where('current_year', '1')->first();

        // Find the student and their room
        $student = Student::with(['room' => fn ($q1) => $q1->where('rooms.year_id', $year->id)])->find($student_id);
        $lesson = Lesson::find($lesson_id);
        $room_id = $room_id;

        // Get the current date and time
        $now = Carbon::now();

        // Get the lesson details for the specified type
        $lesson_details = Lesson_teacher_room_term_exam::with('lesson')->where('lesson_id', $lesson_id)
            ->where('room_id', $room_id)->where('lecture_id', $lecture_id)->where('type', $type_id)->orderBy("id", 'desc')->get();

        // If the type is homework (1), process the homework results
        if ($type_id == 1) {
            foreach ($lesson_details as $homework) {
                $content_result = Exam_result::where('exam_id', $homework->id)->where('user_id', $student_id)->first();
                $previous_homeworks = Student_lesson_teacher_room_term_exam::where('exam_id', $homework->id)
                    ->where('student_id', $student_id)->count();
                $homeworks = Student_lesson_teacher_room_term_exam::where('exam_id', $homework->id)
                    ->where('student_id', $student_id)->get();

                if (isset($content_result) && $content_result->result != null) {
                    $homework->result = $content_result->result;
                } else if (isset($content_result) && $content_result->status == 1 && $content_result->show_result == 0) {
                    $homework->result = -1;
                }
                $homework->previous_file_count = $previous_homeworks;
                $homework->homeworks = $homeworks;

                // Time tolerance
                if ($now > $homework->start_time && $now < $homework->end_time) {
                    $homework->in_time = 1;
                } else if ($now > $homework->end_time) {
                    $homework->in_time = 0;
                }
            }
        }

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

        foreach ($available_lesson_detail as $item) {
            $answers[] = Student_lesson_teacher_room_term_exam::with('exam')->where('student_id', $student_id)
                ->where('file_id', $item->id)->get();
        }

        $count = Message::whereNull('view')->where('student_id', $student_id)->count();

        $year = Year::where('current_year', '1')->first();
        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $class = $room->classes;

        $mark_status = Teacher_room_lesson::where('lesson_id', $lesson_id)->where('room_id', $room->id)->where('year_id', $year->id)->where('teacher_id', $teacher_id)->first();

        $time_status = [];

        foreach ($lesson_details as $item) {
            $time_status[$item->id] = Carbon::now()->lte($item->end_time);

            $content_result = Exam_result::where('exam_id', $item->id)->where('user_id', $student_id)->first();

            if (isset($content_result)) {
                if ($content_result->start_time != null && $content_result->status != '1') {
                    $item->not_terminate = '1';
                } else {
                    $item->not_terminate = '0';
                }
            }

            if (isset($content_result) && $content_result->status == 1 && $content_result->show_result == 0) {
                $item->status = '9'; // Exam in progress
            } else if (isset($content_result) && $content_result->status == 1 && $content_result->show_result == 1) {
                $item->status = '2'; // Exam completed by student
            } else if (isset($content_result) && isset($content_result->end_time) && $now->addMinute(1)->gte($content_result->end_time)) {
                $item->status = '4'; // Exam ended
            } else if (isset($content_result) && $content_result->status == 0) {
                if ($now > $item->start_time && $now < $item->end_time && $item->type == 8) {
                    $item->status = '3'; // Exam can be started
                } else if ($now > $item->end_time) {
                    $item->status = '4'; // Time over
                } else if ($now < $item->start_time) {
                    $item->status = '5'; // Exam scheduled
                }
            }
        }

        $quize_result = Exam_result::where('user_id', $student_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '2')->get();
        $exam_result = Exam_result::where('user_id', $student_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '3')->get();
        $test_result = Exam_result::where('user_id', $student_id)->where('room_id', $room_id)->where('lesson_id', $lesson_id)->where('type', '1')->get();

        return response()->json([
            'lesson_details' => $lesson_details,
            'now' => $now,
            'subject' => $lesson,
            'student_mark' => $student_mark,
        ]);
    }
    
    
    
    public function view_message($teacher_id, $student_id)
    {
        $message = Message::where('teacher_id', $teacher_id)->where('student_id', $student_id)->where('type', '1')->where('view', '0')->get();
        foreach ($message as $item) {
            $item->view = 1;
            $item->save();
        }
    }
    public function get_message($teacher_id)
    {
        $year = Year::where('current_year', '1')->first();
        $st = [];
        $message = Message::where('teacher_id', $teacher_id)->get();
        foreach ($message as $item) {
            $st[] = $item->student_id;
        }
        $count = 0;
        $st1 = [];

        $student = Student::withCount('messageApi')->with(['room' => fn ($q1) => $q1->where('rooms.year_id', $year->id), 'room.classes'])->whereIn('id', $st)->get();
        // $admin = User::where('role_id','1')->first() ;
        // $x =  Message::where('student_id',$student_id)->where('admin_id',$admin->id)->
        //                where('year_id',$year->id)->where('view',0)->where('type',0)->count();

        // $admin->message_count = $x ;
        // $admin->user_type = 1 ; //admin
        // $admin->first_name =  $admin->name ;
        // $admin->last_name =  '' ;

        //  $teachers[] = $admin ;
        //osama





        //  $count=Message::where('teacher_id',$teacher_id)->where('type',1)->where('view',0)->count();


        return response()->json(['student' => $student]);
    }
    public function get_message_count($teacher_id)
    {

        $message = Message::where('teacher_id', $teacher_id)->where('type', 1)->where('view', 0)->count();




        //  $count=Message::where('teacher_id',$teacher_id)->where('type',1)->where('view',0)->count();


        return response()->json(['message' => $message]);
    }
    public function get_message_student($teacher_id, $student_id)
    {

        $message = Message::where('teacher_id', $teacher_id)->where('student_id', $student_id)->get();



        return response()->json(['message' => $message]);
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
        return response()->json(['status' => true, 'msg' => 'تم ارسال الرسالة']);
    }
    public function Meansprepare($lesson_id)
    {
        $lesson_id = Lesson::find($lesson_id);
        if ($lesson_id->is_english == 1) {
            $means = Means::where('lang', 2)->get();
            $road = Road::where('lang', 2)->get();

            return response()->json(['means' => $means, 'road' => $road, 'lang' => 1]);
        } else if ($lesson_id->lang == 0 && $lesson_id->lang != null) {
            return response()->json(['lang' => 2]);
        } else {
            $means = Means::where('lang', 1)->get();
            $road = Road::where('lang', 1)->get();
            return response()->json(['means' => $means, 'road' => $road, 'lang' => 3],);
        }
    }

    public function addprepare(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        if ($request->prepare_id) {
            $prepare = Prepare::find($request->prepare_id);
            $prepare->lesson_id = $request->lesson_id;
            $prepare->class_id = $request->class_id;
            $prepare->teacher_id = $request->teacher_id;
            $prepare->room_id = $request->room_id;
            $prepare->period = $request->Period;
            $prepare->class_time = $request->class_time;
            $prepare->number_of_lecture = $request->number_of_lecture;
            $prepare->day = $request->day;
            $prepare->month = $request->month;
            $prepare->year = $request->year;
            $prepare->lecture = $request->lecture;
            $prepare->unit = $request->unit;
            $prepare->term_id = $term->id;
            $prepare->The_general_goal_of_the_lesson = $request->The_general_goal_of_the_lesson;
            $prepare->stimulating_initialization = $request->stimulating_initialization;
            $prepare->behavioral_goals = $request->behavioral_goals;
            $a = json_encode(json_decode($request->conatin));
            $js = json_decode($a, true);
            $stc = new stdClass;
            $a = [];
            foreach ($js as $key => $val) {
                $a[] = $val[$key];
                $stc->{$key} = $val[$key];
            }

            $prepare->procedures_and_activities = json_encode($stc);
            $prepare->concepts_and_terminology = $request->concepts_and_terminology;
            $prepare->means = $request->means;
            $prepare->roads = $request->roads;
            $prepare->homework = $request->homework;
            $prepare->note = $request->note;
            $prepare->Interim_calendar = $request->Interim_calendar;
            $prepare->Final_calendar = $request->Final_calendar;
            $prepare->Taches = $request->Taches;
            $prepare->Evaluation = $request->Evaluation;
            $prepare->Materiel = $request->Materiel;
            $prepare->Phonetique = $request->Phonetique;
            $prepare->Points_grammaticaux = $request->Points_grammaticaux;
            $prepare->Lexique = $request->Lexique;
            $prepare->number =  $prepare->number;



            $prepare->save();
        } else {
            $prepare1 = Prepare::where('class_id', $request->class_id)->where('lesson_id', $request->lesson_id)->where('term_id', $term->id)->where('teacher_id', $request->teacher_id)->orderBy('id', 'DESC')->first();


            $prepare = new Prepare();

            $prepare->lesson_id = $request->lesson_id;
            $prepare->class_id = $request->class_id;
            $prepare->teacher_id = $request->teacher_id;
            $prepare->room_id = $request->room_id;
            $prepare->period = $request->Period;
            $prepare->class_time = $request->class_time;
            $prepare->number_of_lecture = $request->number_of_lecture;
            $prepare->day = $request->day;
            $prepare->month = $request->month;
            $prepare->year = $request->year;
            $prepare->lecture = $request->lecture;
            $prepare->unit = $request->unit;
            $prepare->term_id = $term->id;
            $prepare->The_general_goal_of_the_lesson = $request->The_general_goal_of_the_lesson;
            $prepare->stimulating_initialization = $request->stimulating_initialization;
            $prepare->behavioral_goals = $request->behavioral_goals;
            $a = json_encode(json_decode($request->conatin));
            $js = json_decode($a, true);
            $stc = new stdClass;
            $a = [];
            foreach ($js as $key => $val) {
                $a[] = $val[$key];
                $stc->{$key} = $val[$key];
            }

            $prepare->procedures_and_activities = json_encode($stc);
            $prepare->concepts_and_terminology = $request->concepts_and_terminology;
            $prepare->means = $request->means;
            $prepare->roads = $request->roads;
            $prepare->homework = $request->homework;
            $prepare->note = $request->note;
            if ($prepare1 != null) {
                $prepare->number = $prepare1->number + 1;
            } else {
                $prepare->number = 1;
            }
            // $prepare->Interim_calendar=$request->Interim_calendar;
            $prepare->Final_calendar = $request->Final_calendar;
            $prepare->Taches = $request->Taches;
            $prepare->Evaluation = $request->Evaluation;
            $prepare->Materiel = $request->Materiel;
            $prepare->Phonetique = $request->Phonetique;
            $prepare->Points_grammaticaux = $request->Points_grammaticaux;
            $prepare->Lexique = $request->Lexique;

            $prepare->save();
        }

        return "success";
    }
    public function prepare($teacher_id, $class_id, $lesson_id, $room_id)
    {
        $year = Year::where('current_year', '1')->first();
        $lesson_id = Lesson::find($lesson_id);

        if ($lesson_id->is_english == 1) {
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
            $m = [];
            $class_id = Classe::find($class_id);
            $prepare = Prepare::with('lesson')->with('class')->where('teacher_id', $teacher_id)->where('term_id', $term->id)->where('class_id', $class_id->id)->where('lesson_id', $lesson_id->id)->orderBy('id', 'ASC')->get();
            foreach ($prepare as $item) {
                $m =  json_decode($item->means);
                $road = json_decode($item->roads);

                $mean = [];
                $means = Means::where('lang', 2)->whereIn('id', $m)->get();

                foreach ($means as $item2) {

                    $mean[] = $item2->name;
                }
                $item->mean2 = $mean;

                $roads1 = [];
                $roads = Road::where('lang', 2)->whereIn('id', $road)->get();


                foreach ($roads as $item3) {

                    $roads1[] = $item3->name;
                }
                $item->road2 = $roads1;
            }

            return response()->json(['prepare' => $prepare, 'lang' => '1']);
        }
        if ($lesson_id->lang == 0 && $lesson_id->lang != null) {
            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

            $class_id = Classe::find($class_id);
            $prepare = Prepare::with('lesson')->with('class')->where('teacher_id', $teacher_id)->where('term_id', $term->id)->where('class_id', $class_id->id)->where('lesson_id', $lesson_id->id)->orderBy('id', 'ASC')->get();
            foreach ($prepare as $item) {

                $item->mean2 = [];
                $item->road2 = [];
            }

            return response()->json(['prepare' => $prepare, 'lang' => '2']);
        } else {

            $year = Year::where('current_year', '1')->first();
            $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
            $class_id = Classe::find($class_id);
            $prepare = Prepare::with('lesson')->with('class')->where('teacher_id', $teacher_id)->where('term_id', $term->id)->where('class_id', $class_id->id)->where('lesson_id', $lesson_id->id)->orderBy('id', 'ASC')->get();
            // $prepare[1]->room_id = json_decode($prepare[1]->room_id) ;
            $m = [];
            foreach ($prepare as $item) {
                $m =  json_decode($item->means);
                $road = json_decode($item->roads);

                //     foreach(json_decode($item->means) as $item1 ){
                //         $m[]=$item1;






                //  }
                $mean = [];
                $means = Means::where('lang', 1)->whereIn('id', $m)->get();

                foreach ($means as $item2) {

                    $mean[] = $item2->name;
                }
                $item->mean2 = $mean;

                $roads1 = [];
                $roads = Road::where('lang', 1)->whereIn('id', $road)->get();


                foreach ($roads as $item3) {

                    $roads1[] = $item3->name;
                }
                $item->road2 = $roads1;
            }


            return response()->json(['prepare' => $prepare, 'lang' => '3']);
        }
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

        return response()->json(['status' => true, 'msg' => 'تم ارسال الرسالة']);
    }
    // ترفيع الوظيفة
    public function upload_files(Request $request)
    {

        //  $ this->validate($request, [
        //             'file' => 'required',
        //             'item_id' => 'required',
        //         ],[
        //             'file.required' => 'يرجى  ترفيع الملف  ',
        //             'item_id.required' => 'يرجى   تحديد المحتوى ',
        //         ]);
        if (!isset($request->extension)) {
            return response()->json(['status' => false, 'msg' => ' extension is required']);
        }
        if ($request->item_id && isset($request->item_id)) {


            $content = Lesson_teacher_room_term_exam::find($request->item_id);
            if (!isset($content)) {
                return response()->json(['status' => false, 'msg' => ' item is not existed   ']);
            }



            if (isset($request->file)) {
                $extension = json_decode($request->extension);


                foreach (json_decode($request->file) as $key => $file) {
                    $student_uploaded_file = new Student_lesson_teacher_room_term_exam;

                    $image = base64_decode($file);
                    $random = Str::random(10);
                    Storage::disk('public')->put("filesstudents/$random" . $extension[$key], $image);

                    $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

                    $student_uploaded_file->file = "filesstudents/$random" . $extension[$key];


                    $student_uploaded_file->exam_id =  $request->item_id;  // the file is coming from storage
                    $student_uploaded_file->student_id =  $request->student_id;
                    $student_uploaded_file->type =  $content->type;
                    $student_uploaded_file->room_id =  $content->room_id;
                    $student_uploaded_file->save();
                }

                //                 if($request->file !=null && $request->file != 'null'){

                //                 $image = base64_decode($request->file);
                //                 $random = Str::random(10);
                //                 Storage::disk('public')->put("filesstudents/$random.$request->extension", $image);

                //                 $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

                //                 $student_uploaded_file->file="filesstudents/$random.$request->extension";
                // }



                return response()->json(['status' => true, 'msg' => 'تم الترفيع بنجاح']);
            } else {
                return response()->json(['status' => false, 'msg' => 'file is required']);
            }
        } else {
            return response()->json(['status' => false, 'msg' => 'item_id is required']);
        }
    }





    public function get_student_quest_exam($exam_id, $student_id)
    {

        $exam = Lesson_teacher_room_term_exam::find($exam_id);
        $now = Carbon::now();

        $exam_result = Exam_result::where('user_id', $student_id)->where('exam_id', $exam_id)->first();
        $hours =   $now->diff($exam->end_time)->format('%H') * 60;
        $minutes =   $now->diff($exam->end_time)->format('%i');
        $now_period = $hours + $minutes;

        if (
            $exam_result->start_time == null
            && $now_period >= $exam->period
        ) {
            $exam_result->start_time = Carbon::now();

            $exam_result->end_time = Carbon::createFromFormat('H:i:s', $exam_result->start_time->format('H:i:s'))->addRealMinutes(intval($exam->period));

            $exam_result->save();
        }


        $exam = Lesson_teacher_room_term_exam::find($exam_id);
        $exam_result = Exam_result::where('exam_id', $exam_id)->where('user_id', $student_id)->first();
        $now = Carbon::now();
        // if ($now > $exam->end_time || $now_period<=5) {

        //     session()->flash('warning', ' يتعذر تقديم الامتحان انتهى الوقت');
        //     return redirect()->back();
        // }

        //  if ($now>$exam_result->end_time) {

        //     session()->flash('warning', ' يتعذر تقديم الامتحان انتهى الوقت');
        //     return redirect()->back();
        // }
        // if ($exam_result->status=='1') {
        //     session()->flash('warning', ' يتعذر تقديم الامتحان الان');
        //     return redirect()->back();


        // }
        $selected_ques = $exam->selected_ques;

        $selected_ques = json_decode($selected_ques);


        if ($selected_ques != null) {
            foreach ($selected_ques as $x) {

                $ques_id[] = $x;
            };
            // dd($ques_id);
            $selected_ques = Question::whereIn('id', $ques_id)->with('option')->get();

            $class = $exam->class;

            $std_exam = Exam_result::where('exam_id', $exam_id)->where('user_id', $student_id)->first();

            return response()->json(['selected_ques' => $selected_ques]);
        }
    }


    public function start_exam_test($exam_id, $student_id)
    {

        $student = Student::find($student_id);
        $content = Lesson_teacher_room_term_exam::findOrFail($exam_id);
        $lesson_name = Lesson::findOrFail($content->lesson_id)->name;
        $room = Room::findOrFail($content->room_id);
        $room_name = $room->name;
        $year_id = $room->year_id;
        $class_name = Classe::findOrFail($content->class_id)->name;
        $year = Year::findOrFail($year_id)->name;
        $term = $content->term_id;
        $first = 'الفصل الأول';
        $second = 'الفصل الثاني';
        $term_name = $term == 1 ? $first : $second;
        // return $content;
        $exam_result = Exam_result::where('exam_id', $exam_id)->where('user_id', $student->id)->first();
        if (isset($exam_result) && $exam_result->status == 1) {
            return response()->json(['message' => 'عذراً لايمكنأعادة الامتحان', 'status' => 0]);
        }

        $now = Carbon::now();


        if ($now->subMinutes(2) > $content->end_time && $exam_result->start_time == null) {
            return response()->json(['message' => 'انتهى الوقت  ', 'status' => 5]);
        }

        $now = Carbon::now();
        $minutes = $now->diffInMinutes($content->end_time);
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

            return response()->json(['message' => 'انتهى الوقت  ', 'status' => 6]);
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
            $questions = Question::with('option', 'section','lesson')->whereIn('id', $questions)
                ->get();
        } else {
            $exam_result->start_time = null;
            $exam_result->end_time = null;
            $exam_result->save();
            return response()->json(['msg' => 'لا يوجد اسئلة محددة', 'status' => 0]);
        }

        return response()->json([
            'questions' => $questions, 'exam_period' => $exam->period, 'exam' => $exam, 'content_id' => $content_id,
            'year' => $year, 'term_name' => $term_name, 'msg' => 'الاختبار جاهز يمكن البدء', 'status' => 1
        ]);

        // return view('students.new_start_exam2',compact('questions','exam','class','student',
        //                                                 'content_id','content_name','lesson_name','content',
        //                                                 'room_name','class_name','year','term_name'));
    }


    public function view_test_exam($exam_id, $student_id)
    {

        $content = Lesson_teacher_room_term_exam::findOrFail($exam_id);
        $content_mark = $content->success_mark;
        $exam_result = Exam_result::where('exam_id', $exam_id)->where('user_id', $student_id)->first();
        $student_result = $exam_result->result;
        $lesson_name = Lesson::findOrFail($content->lesson_id)->name;
        $room = Room::findOrFail($content->room_id);
        $room_name = $room->name;
        $class_name = $room->classes->name;
        $year_id = $room->year_id;
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
          

            $questions = Question::with(['exam_question'=>fn($q1)=>$q1->where('test_id',$exam_id)])->with('option', 'section',)->whereIn('id', $questions)
                ->get();

            $traditional_result = $exam_result->traditional_result;
             foreach (json_decode($exam_result->user_answers, true) as $key => $value) {
                $stored_mark = 0;
                $exam_questions = $questions->where('id', $key)->first();
                 if ($exam_questions->option != null) {
                     $stored_mark = $exam_questions->mark;
                    $stored_answer = json_decode($exam_questions->answer,true);
                
 
                    $check1 = array_diff($stored_answer, $value);
                    $check2 = array_diff($value, $stored_answer);


                    if (count($check1) == 0 && count($check2) == 0) {
                        $student_result += $stored_mark;
                        $exam_questions->deserved_mark =  $stored_mark;
                    } else {
                        $exam_questions->deserved_mark =  0;
                    }
                } else {

                     if (isset($traditional_result)) {
                          
                        foreach (json_decode($traditional_result,true) as $key => $ques_result)
                      
                           
                        if ($key == $exam_questions->id)
                            $exam_questions->deserved_mark = $ques_result;
                    } else {
                  
                        $exam_questions->deserved_mark = -1;
                    }
                }
             }
        } else {

            return response()->json(['msg' => 'لا يوجد اسئلة محددة', 'status' => 0]);
        }
        // وضعنا هذه الخاصية لكي نتمكن من ادراج مدينة سورية دون اعتراض تطبيق ios

        $city = 'حماة';
        
                          

        foreach($questions as $question){
     
                            $exam_questions = $questions->where('id', $question->id)->first();
$a=0;
                 if ($exam_questions->option != null) {

            if ($exam_result->user_answers){
                   foreach (json_decode($exam_result->user_answers, true) as $key => $value)
                                            if ($key == $question->id){
                                                
                                                   $a = 0;
                                                    if (json_decode($question->answer, true) == $value) {
                                                        $a = 1;
                                                    }
                                                    $diff = array_diff(json_decode($question->answer, true), $value);
                                                    $diff2 = array_diff($value, json_decode($question->answer, true));     
                                            }
                                             
                
            }
                 }
               if($a==1){
                   $question->student_mark =$question['exam_question'][0]->mark;
               } else{
                                      $question->student_mark =0;

               }          
         }
                    
          return response()->json([
            'questions' => $questions, 'exam' => $exam, 'exam_result' => $exam_result,
            'content_id' => $content_id, 'lesson_name' => $lesson_name, 'room_name' => $room_name,
            'term_name' => $term_name, 'exam_period' => $exam->period,
            'student_result' => $student_result, 'content_mark' => $content_mark,
            'year' => $year, 'city' => $city, 'term_name' => $term_name, 'status' => 1
        ]);
        // return view('students.new_view_exam2_2',compact('normal_questions','with_section_questions','exam','class_name',
        //                                                 'student','content_id','content_name',
        //                                                 'exam_result','max_result','lesson_name',
        //                                                 'room_name','term_name','year'));
    }




    public function view_quize_exam($exam_id, $student_id)
    {

        $content = Exams2::findOrFail($exam_id);
        $content_mark = $content->mark;
        $exam_result = Exam_result2::where('exam_id', $exam_id)->where('user_id', $student_id)->first();
        $student_result = $exam_result->result;
        $lesson_name = Lesson::findOrFail($content->lesson_id)->name;
        $room = Room::findOrFail($content->room_id);
        $room_name = $room->name;
        $class_name = $room->classes->name;
        $year_id = $room->year_id;
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




            $questions = Question::with('option', 'section')->whereIn('id', $questions)
                ->get();

            $traditional_result = $exam_result->traditional_result;
            foreach (json_decode($exam_result->user_answers, true) as $key => $value) {
                $stored_mark = 0;
                $exam_questions = $questions->where('id', $key)->first();
                if ($exam_questions) {
                    if ($exam_questions->option != null) {

                        $stored_mark = $exam_questions->mark;
                        $stored_answer  =  json_decode($exam_questions->answer);


                        $check1 = array_diff($stored_answer, $value);
                        $check2 = array_diff($value, $stored_answer);

                        if (count($check1) == 0 && count($check2) == 0) {
                          
                            $student_result += $stored_mark;
                            $exam_questions->deserved_mark =  $stored_mark;
                         
                        } else {
                            $exam_questions->deserved_mark =  0;
                        }
                    } else {
                        if (isset($traditional_result)) {
                        foreach (json_decode($traditional_result,true) as $key => $ques_result)
                               
                            if ($key == $exam_questions->id)
                                $exam_questions->deserved_mark = $ques_result;
                        } else {
                            $exam_questions->deserved_mark = -1;
                        }
                    }
                }
            }
        } else {

            return response()->json(['msg' => 'لا يوجد اسئلة محددة', 'status' => 0]);
        }
        // وضعنا هذه الخاصية لكي نتمكن من ادراج مدينة سورية دون اعتراض تطبيق ios
        $city = 'حخل';
                foreach($questions as $question){
     
                            $exam_questions = $questions->where('id', $question->id)->first();
$a=0;
                 if ($exam_questions->option != null) {

            if ($exam_result->user_answers){
                   foreach (json_decode($exam_result->user_answers, true) as $key => $value)
                                            if ($key == $question->id){
                                                
                                                   $a = 0;
                                                    if (json_decode($question->answer, true) == $value) {
                                                        $a = 1;
                                                    }
                                                    $diff = array_diff(json_decode($question->answer, true), $value);
                                                    $diff2 = array_diff($value, json_decode($question->answer, true));     
                                            }
                                             
                
            }
                 }
               if($a==1){
                   $question->student_mark =$question['exam_question'][0]->mark;
               } else{
                                      $question->student_mark =0;

               }          
         }
         

        return response()->json([
            'questions' => $questions, 'exam' => $exam, 'exam_result' => $exam_result,
            'content_id' => $content_id, 'lesson_name' => $lesson_name, 'room_name' => $room_name,
            'term_name' => $term_name, 'exam_period' => $exam->period,
            'student_result' => $student_result, 'content_mark' => $content_mark,
            'year' => $year, 'city' => $city, 'term_name' => $term_name, 'status' => 1
        ]);
    }



    public function save_exam(Request $request)
    { 
        // return $request ;
        $student_id = $request->student_id;
        $exam_result = Exam_result::where('user_id', $student_id)
            ->where('exam_id', $request->content_id)->first();
        $exam = Lesson_teacher_room_term_exam::find($request->content_id);

        if ($exam_result && $exam_result->status == 1) {

            if ($exam->type == 8) {

                return response()->json(['msg' => 'لا يمكن إعادة الاختبار  ', 'status' => 5]);
            } else if ($exam->type == 5) {
                return response()->json(['msg' => 'لا يمكن إعادة المذاكرة  ', 'status' => 5]);
            } else if ($exam->type == 6) {
                return response()->json(['msg' => 'لا يمكن إعادة الامتحان  ', 'status' => 5]);
            }
        }


        if (Carbon::now()->addMinutes(-3) >=  $exam_result->end_time) {
            return response()->json(['message' => 'انتهى الوقت  ', 'status' => 6, 'now' => Carbon::now()]);
        }

        // تغيير حالة  الامتحان للدلالة على ان الطالب قام به ,طالب واحد على الاقل يكفي لمعرفة أن هذا الامتحان لايمكن تعديل محتواه
        $exam->exam_status = '1';

        $exam->save();
        $user_answers = $request->answer;
        $selected_ques = json_decode($exam->selected_ques, true);
        // foreach ($selected_ques as $x) {
        //     $ques_id[] = $x;
        // };

        $exam_questions =  question::whereIn('id', $selected_ques)->with('option')->get();

$answer=null;
 
      $student_result = 0;

if ($request->answer != null) {
    $js = json_decode($request->answer, true); // Decode JSON to associative array directly

    $answer = []; // Initialize an array to store answers

    // Loop through the answers and store them in the $answer array
    foreach ($js as $item) {
        foreach ($item as $key => $val) {
            $answer[$key] = $val; // Store answer as an array
        }
    }
    // Loop through the student's answers to calculate the result
    foreach ($answer as $key => $value) {
        $exam_question = $exam_questions->where('id', $key)->first(); // Get the exam question by ID
         if ($exam_question && $exam_question->option != null) {
            $stored_mark = $exam_question->mark;
            $stored_answer =json_decode($exam_question->answer,true); // Decode stored answer to array
 

         $check1 = array_diff($stored_answer, $value);
                    $check2 = array_diff($value, $stored_answer);

                    if (count($check1) == 0 && count($check2) == 0) {
                         $student_result += $stored_mark;
                    }
                  
 
            // Check if the student's answer matches the stored answer
            // if (is_array($value) && count(array_diff($stored_answer, $value)) == 0 && count(array_diff($value, $stored_answer)) == 0) {
                       

            //     $student_result += $stored_mark;  
            // } 
        }
    }
}

$student = Student::find($student_id);
$item = Exam_result::where('user_id', $student_id)->where('exam_id', $request->content_id)->first();

        // give medals
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

        $item->update([
            'user_id' => $student_id,
            'exam_id'  => $request->content_id,
            'class_id'  => $exam->class_id,
            'room_id'  => $exam->room_id,
            'selected_ques' => $exam->selected_ques,
            'user_answers' =>  json_encode($answer),
            'result' => $student_result,
            'type' => $exam->type,
            'lesson_id' => $exam->lesson_id,
            'medal' => $medal,
            'status' => '1',
        ]);

        if (!$request->has('traditional')) {

            //   $item->result2=$item->result;
            $item->save();
        }
        if ($exam->type == 8) {
            return response()->json(['msg' => 'تم التخزين بنجاح    ', 'status' => 1]);
        } else if ($exam->type == 6) {
            return response()->json(['msg' => 'تم التخزين بنجاح    ', 'status' => 1]);
        } else if ($exam->type == 3) {
            return response()->json(['msg' => 'تم التخزين بنجاح    ', 'status' => 1]);
        }
    }

    public function student_schedule($room_id, $student_id, $time_zone_offset)
    {
        // return $time_zone_offset ;
        $user = User::where('student_id', $student_id)->first();
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
        $time_zone_offset = $damas_diff_time_zone - (-$time_zone_offset);
        $time_zone_offset;
        // pring lecture_tims
        $lecture_times = Lecture_time::where('class_id', $room->class_id)->orderBy('start_time', 'asc')->get();
        $end_times = [];
        $end_times2 = [];
        foreach ($lecture_times as $lecture_time) {

            $lecture_time->start_time = \Carbon\Carbon::parse($lecture_time->start_time);
            $lecture_time->end_time = \Carbon\Carbon::parse($lecture_time->end_time);

            $lecture_time->start_time->addMinute($time_zone_offset);
            $lecture_time->end_time->addMinute($time_zone_offset);
            $lecture_time->start_time =  $lecture_time->start_time->format('H:i:s');
            $lecture_time->end_time =  $lecture_time->end_time->format('H:i:s');
        }
        // pring days .
        $days = Day::all();
        // pring romm schedule
        $schedule = collect();

        foreach ($days  as $day) {

            $schedule_day = Lesson_room_teacher_lecture_time::with('lesson','teacher')
            ->where('room_id',$room_id)->where('day_id',$day->id)->get();

            // $schedule_day = Lesson_room_teacher_lecture_time::with('lesson', 'lecture_time')->with('lesson', 'teacher')
            //     ->join('lecture_times', 'lecture_times.id', '=', 'lesson_room_teacher_lecture_time.lecture_time_id')
            //     ->orderBy('lecture_times.start_time')
            //     ->select("lesson_room_teacher_lecture_time.*")
            //     ->where('room_id', $room_id)->where('day_id', $day->id)->get();

            if ($day->id == $today + 1) {

                $student_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::today())->where('user_id', $user->id)->get();
                foreach ($schedule_day  as $key => $today_lecture) {

                    $tracer =  $student_schedule_tracer->where('lecture_time_id', $today_lecture->lecture_time_id);
                    if (!blank($tracer)) {
                        $today_lecture->attendance = true;
                    } else {
                        $today_lecture->attendance = false;
                    }

                    $lecture_time = Lecture_time::findOrFail($today_lecture->lecture_time_id);
                    $hourMin = date('H:i');
                    if ($hourMin > $lecture_time->start_time && $hourMin < $lecture_time->end_time) {
                        $today_lecture->inter = true;
                    } else {
                        $today_lecture->inter = false;
                    }

                    $lecture_time->end_time = \Carbon\Carbon::parse($lecture_time->end_time);

                    $end_times[$lecture_time->end_time->format('H:i')] = $lecture_time->name;
                    $end_times2[] = $lecture_time->end_time->format('H:i');
                }
            } else {
                foreach ($schedule_day  as $key => $today_lecture) {
                    $today_lecture->inter = false;
                }
            }
            $pbject = new stdClass;
            $pbject->{$day->id} = $schedule_day;
            $schedule[] = $pbject;
        }



        // pring student schedule tracer

        $today_lectures = $schedule->where('day_id', $today + 1);

        foreach ($lecture_times as $lecture_time) {

            if ($lecture_time->type == '2') {
                $lecture_time->end_time = \Carbon\Carbon::parse($lecture_time->end_time);

                $end_times[$lecture_time->end_time->format('H:i')] = $lecture_time->name;
                $end_times2[] = $lecture_time->end_time->format('H:i');
            }
        }

        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();
        // return response()->json(['now','lecture_times','days','schedule','today']);
        return response()->json(['schedule' => $schedule, 'today' => $today, 'days' => $days, 'lecture_times' => $lecture_times, 'end_times' => $end_times, 'end_times2' => $end_times2]);
        // return view('students.new_student_schedule',compact('room_name','class_name','student','now','room_id','lessons','lecture_times','days','schedule','today'));
    }

    public function all_messages_count($student_id)
    {
        $year = Year::where('current_year', '1')->first();
        $student = Student::find($student_id);
        $messages_count = Message::where('student_id', $student->id)->where('year_id', $year->id)
            ->where('view', 0)->where('type', 0)->count();

        return response()->json(['message' => $messages_count, 'status' => 1]);
    }

    public function messages($student_id)
    {
        $year = Year::where('current_year', '1')->first();

        $student = Student::find($student_id);

        $messages = Message::where('student_id', $student->id)->where('year_id', $year->id)->get();

        $room = $student->room()->where('rooms.year_id', $year->id)->first();
        $room_id = $room->id;
        $teachers = $room->teachers->unique();

        foreach ($teachers as $teacher) {
            $x =  Message::where('student_id', $student_id)->where('teacher_id', $teacher->id)->where('year_id', $year->id)->where('view', 0)->where('type', 0)->count();
            $teacher->message_count = $x;
            $teacher->user_type = 2; // teacher

        }
        $admin = User::where('role_id', '1')->first();
        $x =  Message::where('student_id', $student_id)->where('admin_id', $admin->id)->where('year_id', $year->id)->where('view', 0)->where('type', 0)->count();
        $admin->message_count = $x;
        $admin->user_type = 1; //admin
        $admin->first_name =  $admin->name;
        $admin->last_name =  '';

        $teachers[] = $admin;



        return response()->json(['teachers' => $teachers, 'status' => 1]);
    }

    public function get_teacher_message($student_id, $teacher_id, $user_type)
    {

        $year = Year::where('current_year', '1')->first();
        //case admin messages
        if ($user_type == 1) {

            $messages = Message::where('student_id', $student_id)->where('admin_id', $teacher_id)->where('year_id', $year->id)->get();

            foreach ($messages as $item) {
                if ($item->type == '0') {
                    $m = Message::find($item->id);
                    $m->view = '1';
                    $m->save();
                }
            }
            //case teacher messages
        } else if ($user_type == 2) {

            $messages = Message::where('student_id', $student_id)->where('teacher_id', $teacher_id)->where('year_id', $year->id)->get();

            foreach ($messages as $item) {
                if ($item->type == '0') {
                    $m = Message::find($item->id);
                    $m->view = '1';
                    $m->save();
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' =>  $messages,
        ]);
    }

    public function store_student_message(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
        $message = new Message;
        $message->student_id = $request->student_id;

        $message->message = $request->message;
        $message->type = 1;
        $message->year_id = $year->id;
        $message->view = 0;
        if ($request->user_type == 1)
            $message->admin_id =  $request->teacher_id;
        else
            $message->teacher_id =  $request->teacher_id;
        $message->save();
        return response()->json([
            'status' => true,
            'message' =>  'تم التخزين بنجاح',
        ]);
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



    public function student_events($student_id)
    {
        $year = Year::where('current_year', '1')->first();
        $student = Student::with('details')->find($student_id);
        $item = Room_student::where('student_id', $student_id)->where('year_id', $year->id)->first();
        $events = Teacher_event::where('room_id', $item->room_id)->where('year_id', $year->id)->get();
        return response()->json([
            'status' => true,
            'event' =>  $events,
        ]);
    }


    public function student_main_exams($room_id, $student_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $student = Student::with('details')->findOrFail($student_id);

        // $exams = Exams2::where('room_id',$room_id)->
        //         where('type','1')->orderBy('created_at','asc')->
        //         with(['lesson' => fn($q) => $q->select('name','lessons.id')])->get();

        $exams_id = Exam_result2::where('room_id', $room_id)->where('user_id', $student_id)->where('type', '1')->pluck('exam_id');


        $exams = Exams2::where('term_id', $term->id)->whereIn('id', $exams_id)->where('type', '1')->orderBy('created_at', 'asc')->with(['lesson' => fn ($q) => $q->select('name', 'lessons.id')])->get();




        foreach ($exams  as $key => $content) {
            $timestamp = strtotime($content->start_date);
            $day = date('l', $timestamp);
            $day = $this->getDay($day);
            $content->day = $day;
            $start_date = Carbon::parse($content->start_date);
            $end_date = Carbon::parse($content->end_date);
            $totalDuration = $start_date->diffInSeconds($end_date);
            $content->total_period =  gmdate('H:i:s', $totalDuration);

            $previous_files = Exam_file::where('exam_id', $content->id)
                ->where('student_id', $student_id)->first();

            $previous_files_count = count(Exam_file::where('exam_id', $content->id)
                ->where('student_id', $student_id)->get());


            if (isset($previous_files)) {
                $content->previous_file = 1;
                $content->previous_files_count = $previous_files_count;
            } else {
                $content->previous_file = 0;
                $content->previous_files_count = 0;
            }

            $exam_result = Exam_result2::where('user_id', $student->id)->where('exam_id', $content->id)->first();
            // if (isset($exam_result) && $exam_result->status == 1){
            //  return response()->json(['message'=> 'عذراً لايمكن إعادة الامتحان','status' => 0]);
            // }
            if (isset($exam_result)) {

                        // هذا العنصر لمعرفة اذا كان الطالب دخل الى الامتحان لكن خرج منه و لم يقم بانهائه
                if($exam_result->start_time!=null && $exam_result->status!='1'){
                    $content->not_terminate='1';
                }else{
                                      $content->not_terminate='0';

                }
                if ($exam_result->status == '0') {
                    $content->result = '-1';
                } else if ($exam_result->status == '1' && $exam_result->show_result == 0) {
                    // الامتحان قيد التصحيح
                    $content->result = '-9';
                } else if ($exam_result->status == '1' && $exam_result->show_result == 1) {
                    $content->result = $exam_result->result;
                }
            }

            $now = Carbon::now();
            if (isset($exam_result) && $now->subMinutes(2)->gte($content->end_date) && ($exam_result->start_time == null)) {
                $content->start_exam = 0; // انتهى
            } else if (isset($exam_result) && isset($exam_result->end_time) && (isset($exam_result->result))) {
                $content->start_exam = 3; // تم التقدم للامتحان من قبل
            } else if (isset($exam_result)   && isset($exam_result->end_time)  && $now->addMinute(1)->gte($exam_result->end_time)) {

                $content->start_exam = 0; //  انتهى
            } else if (isset($exam_result) && $now->lte($content->end_date) && $now->addMinute(1)->gte($content->start_date) && $exam_result->status != 1) {
                $content->start_exam = 1; // جاري
            } else if (isset($exam_result) && $now->lte($content->start_date)) {
                $content->start_exam = 2; // مخطط له
            } else if (isset($exam_result) && $now->subMinutes(2)->gte($content->end_date)) {

                $content->start_exam = 0;
            } else if (isset($exam_result) && isset($exam_result->end_time) && isset($exam_result->result) && $exam_result->show_result == 0) {
                $content->start_exam = 4; // الامتحان قيد التصحيح
            } else if (isset($exam_result) && isset($exam_result->end_time) && (isset($exam_result->result))) {
                $content->start_exam = 3; // تم التقدم للامتحان من قبل
            }

            // if (isset($exam_result) && $now->subMinutes(2)->gte($content->end_date) && $exam_result->start_time == null){
            //                 $content->start_exam = 0 ; // انتهى
            // }
            // else if (isset($exam_result) && isset($exam_result->end_time) && isset( $exam_result->result  ) && $exam_result->show_result == 0  ){
            //       $content->start_exam = 4 ; // الامتحان قيد التصحيح
            // }
            // else if (isset($exam_result) && isset($exam_result->end_time) && (isset( $exam_result->result ) ) ){
            //       $content->start_exam = 3 ; // تم التقدم للامتحان من قبل
            // }
            // else if (isset($exam_result) && $now->lte($content->end_date) && $now->addMinute(1)->gte( $content->start_date )){
            //       $content->start_exam = 1 ; // جاري
            // }
            // else if (isset($exam_result) && $now->lte( $content->start_date ) ){
            //     $content->start_exam = 2 ; // مخطط له
            // }
            // else if (isset($exam_result) && $now->subMinutes(2)->gte($content->end_date) ){
            //       $content->start_exam = 0 ;
            //   }


        }


        return response()->json([
            'status' => true,
            'exams' =>  $exams,
        ]);
    }

    public function student_main_quizes($room_id, $student_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $student = Student::with('details')->findOrFail($student_id);

        // $exams = Exams2::where('room_id',$room_id)->
        //         where('type','2')->orderBy('created_at','asc')->
        //         with(['lesson' => fn($q) => $q->select('name','lessons.id')])->get();

        $exams_id = Exam_result2::where('room_id', $room_id)->where('user_id', $student_id)->where('type', '2')->pluck('exam_id');


        $exams = Exams2::where('term_id', $term->id)->whereIn('id', $exams_id)->where('type', '2')->orderBy('created_at', 'desc')->with(['lesson' => fn ($q) => $q->select('name', 'lessons.id')])->get();


        foreach ($exams  as $key => $content) {
            $timestamp = strtotime($content->start_date);
            $day = date('l', $timestamp);
            $day = $this->getDay($day);
            $content->day = $day;
            $start_date = Carbon::parse($content->start_date);
            $end_date = Carbon::parse($content->end_date);
            $totalDuration = $start_date->diffInSeconds($end_date);
            $content->total_period =  gmdate('H:i:s', $totalDuration);

            $previous_files = Exam_file::where('exam_id', $content->id)
                ->where('student_id', $student_id)->first();
            if (isset($previous_files)) {
                $content->previous_file = 1;
            } else {
                $content->previous_file = 0;
            }

            $exam_result = Exam_result2::where('user_id', $student->id)->where('exam_id', $content->id)->first();
            // if (isset($exam_result) && $exam_result->status == 1){
            //  return response()->json(['message'=> 'عذراً لايمكن إعادة الامتحان','status' => 0]);
            // }
            if (isset($exam_result)) {

                                // هذا العنصر لمعرفة اذا كان الطالب دخل الى الامتحان لكن خرج منه و لم يقم بانهائه
                if($exam_result->start_time!=null && $exam_result->status!='1'){
                    $content->not_terminate='1';
                }else{
                                      $content->not_terminate='0';

                }

                if ($exam_result->status == '0') {
                    $content->result = '-1';
                } else if ($exam_result->status == '1' && $exam_result->show_result == 0) {
                    // الامتحان قيد التصحيح
                    $content->result = '-9';
                } else if ($exam_result->status == '1' && $exam_result->show_result == 1) {
                    $content->result = $exam_result->result;
                }
            }

            $now = Carbon::now();
            if (isset($exam_result) && $now->subMinutes(2)->gte($content->end_date) && ($exam_result->start_time == null)) {
                $content->start_exam = 0; // انتهى
            } else if (isset($exam_result) && isset($exam_result->end_time) && (isset($exam_result->result))) {
                $content->start_exam = 3; // تم التقدم للامتحان من قبل
            } else if (isset($exam_result)   && isset($exam_result->end_time)  && $now->addMinute(1)->gte($exam_result->end_time)) {

                $content->start_exam = 0; //  انتهى
            } else if (isset($exam_result) && $now->lte($content->end_date) && $now->addMinute(1)->gte($content->start_date) && $exam_result->status != 1) {
                $content->start_exam = 1; // جاري
            } else if (isset($exam_result) && $now->lte($content->start_date)) {
                $content->start_exam = 2; // مخطط له
            } else if (isset($exam_result) && $now->subMinutes(2)->gte($content->end_date)) {

                $content->start_exam = 0;
            } else if (isset($exam_result) && isset($exam_result->end_time) && isset($exam_result->result) && $exam_result->show_result == 0) {
                $content->start_exam = 4; // الامتحان قيد التصحيح
            } else if (isset($exam_result) && isset($exam_result->end_time) && (isset($exam_result->result))) {
                $content->start_exam = 3; // تم التقدم للامتحان من قبل
            }

            // if (isset($exam_result) && $now->subMinutes(2)->gte($content->end_date) && $exam_result->start_time == null){
            //                 $content->start_exam = 0 ; // انتهى
            // }
            // else if (isset($exam_result) && isset($exam_result->end_time) && isset( $exam_result->result  ) && $exam_result->show_result == 0  ){
            //       $content->start_exam = 4 ; // الامتحان قيد التصحيح
            // }
            // else if (isset($exam_result) && isset($exam_result->end_time) && (isset( $exam_result->result ) ) ){
            //       $content->start_exam = 3 ; // تم التقدم للامتحان من قبل
            // }
            // else if (isset($exam_result) && $now->lte($content->end_date) && $now->addMinute(1)->gte( $content->start_date )){
            //       $content->start_exam = 1 ; // جاري
            // }
            // else if (isset($exam_result) && $now->lte( $content->start_date ) ){
            //     $content->start_exam = 2 ; // مخطط له
            // }
            // else if (isset($exam_result) && $now->subMinutes(2)->gte($content->end_date) ){
            //       $content->start_exam = 0 ;
            //   }


        }


        return response()->json([
            'status' => true,
            'exams' =>  $exams,
        ]);
    }

    public function start_main_exam($exam_id, $student_id)
    {

        $student = Student::find($student_id);
        $content = Exams2::findOrFail($exam_id);
        $lesson_name = Lesson::findOrFail($content->lesson_id)->name;
        $room = Room::findOrFail($content->room_id);
        $room_name = $room->name;
        $year_id = $room->year_id;
        $class_name = Classe::findOrFail($content->class_id)->name;
        $year = Year::findOrFail($year_id)->name;


        $term = Term_year::findOrFail($content->term_id);

        $term_name = $term->name;

        // return $content;
        $exam_result = Exam_result2::where('exam_id', $exam_id)->where('user_id', $student->id)->first();
        if (isset($exam_result) && $exam_result->status == 1) {
            return response()->json(['message' => 'عذراً لايمكن إعادة الامتحان', 'status' => 0]);
        }
        $now = Carbon::now();


        if ($now->subMinutes(2) > $content->end_date && $exam_result->start_time == null) {
            return response()->json(['message' => 'انتهى الوقت  ', 'status' => 5]);
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

            return response()->json(['message' => 'انتهى الوقت  ', 'status' => 6]);
        } else {
            $minutes = Carbon::now()->diffInMinutes($exam_result->end_time);
            $content->period = $minutes;
        }
        $now = Carbon::now();
        $content->now = $now;


        $content_id = $content->id;
        $questions = [];

        $exam = $content;
        $class = $exam->class;
        if ($exam->is_file == '0') {
            $questions = json_decode($content->selected_ques, true);
            if (isset($questions)) {
                $questions = Question::with('option', 'section','lesson')->whereIn('id', $questions)
                    ->get();
            } else {
                $exam_result->start_time = null;
                $exam_result->end_time = null;
                $exam_result->save();
                return response()->json(['msg' => 'لا يوجد اسئلة محددة', 'status' => 0]);
            }
        }


        return response()->json(['questions' => $questions, 'exam_period' => $exam->period, 'msg' => 'الامتحان جاهز يمكن البدء', 'status' => 1]);

        // return view('students.new_start_exam2',compact('questions','exam','class','student',
        //                                                 'content_id','content_name','lesson_name','content',
        //                                                 'room_name','class_name','year','term_name'));
    }

    public function upload_exam_files(Request $request)
    {


        if (!isset($request->extension)) {
            return response()->json(['status' => false, 'msg' => ' extension is required']);
        }
        if ($request->item_id && isset($request->item_id)) {


            $content = Exams2::find($request->item_id);
            if (!isset($content)) {
                return response()->json(['status' => false, 'msg' => ' item is not existed   ']);
            }


            $student_uploaded_file = new Exam_file();
            if (isset($request->file)) {

                if ($request->file != null && $request->file != 'null') {

                    // $old_exam = Exam_file::where('student_id',$request->student_id)->where('exam_id',$request->item_id)->first();
                    // if (isset($old_exam)){
                    //     $old_exam->delete() ;
                    // }
                    $term = Term_year::where('current_term', '1')->first();

                    $image = base64_decode($request->file);
                    $random = Str::random(10);
                    Storage::disk('public')->put("filesstudents/$random.$request->extension", $image);

                    $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

                    $student_uploaded_file->file = "filesstudents/$random.$request->extension";
                    $student_uploaded_file->extension = $request->extension;
                }


                $student_uploaded_file->exam_id =  $request->item_id;  // the file is coming from storage
                $student_uploaded_file->student_id =  $request->student_id;
                // $student_uploaded_file->type =  $content->type;
                $student_uploaded_file->room_id =  $content->room_id;
                $student_uploaded_file->lesson_id =  $content->lesson_id;
                $student_uploaded_file->class_id =  $content->class_id;
                $student_uploaded_file->term_id =  $term->id;
                $student_uploaded_file->save();
                return response()->json(['status' => true, 'msg' => 'تم الترفيع بنجاح']);
            } else {
                return response()->json(['status' => false, 'msg' => 'file is required']);
            }
        } else {
            return response()->json(['status' => false, 'msg' => 'item_id is required']);
        }
    }


    public function upload_exam_files2(Request $request)
    {


        if (!isset($request->extension)) {
            return response()->json(['status' => false, 'msg' => ' extension is required']);
        }
        if ($request->item_id && isset($request->item_id)) {


            $content = Exams2::find($request->item_id);
            if (!isset($content)) {
                return response()->json(['status' => false, 'msg' => ' item is not existed   ']);
            }


            if (isset($request->file)) {

                // $old_exam = Exam_file::where('student_id',$request->student_id)->where('exam_id',$request->item_id)->delete();

                if ($request->file != null && $request->file != 'null') {

                    // if (isset($old_exam)){
                    //     $old_exam->delete() ;
                    // }
                    $term = Term_year::where('current_term', '1')->first();
                    $extension = json_decode($request->extension);

                    for ($i = 0; $i < count(json_decode($request->file)); $i++) {

                        $student_uploaded_file = new Exam_file();
                        $image = base64_decode(json_decode($request->file)[$i]);
                        $random = Str::random(10);
                        Storage::disk('public')->put("filesstudents/$random" . $extension[$i], $image);

                        $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

                        $student_uploaded_file->file = "filesstudents/$random" . $extension[$i];
                        $student_uploaded_file->extension = $extension[$i];



                        $student_uploaded_file->exam_id =  $request->item_id;  // the file is coming from storage
                        $student_uploaded_file->student_id =  $request->student_id;
                        // $student_uploaded_file->type =  $content->type;
                        $student_uploaded_file->room_id =  $content->room_id;
                        $student_uploaded_file->lesson_id =  $content->lesson_id;
                        $student_uploaded_file->class_id =  $content->class_id;
                        $student_uploaded_file->term_id =  $term->id;
                        $student_uploaded_file->save();
                    }
                    //  foreach(json_decode($request->file) as $key => $file){
                    //      $student_uploaded_file = new Exam_file() ;
                    //     $image = base64_decode($file);
                    //     $random = Str::random(10);
                    //     Storage::disk('public')->put("filesstudents/$random".$extension[0], $image);

                    //     $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

                    //     $student_uploaded_file->file="filesstudents/$random".$extension[0];
                    //     $student_uploaded_file->extension= $extension[0];



                    //     $student_uploaded_file->exam_id =  $request->item_id;  // the file is coming from storage
                    //     $student_uploaded_file->student_id =  $request->student_id;
                    //     // $student_uploaded_file->type =  $content->type;
                    //      $student_uploaded_file->room_id =  $content->room_id;
                    //      $student_uploaded_file->lesson_id =  $content->lesson_id;
                    //      $student_uploaded_file->class_id =  $content->class_id;
                    //      $student_uploaded_file->term_id =  $term->id;
                    //     $student_uploaded_file->save();

                    // }
                    return response()->json(['status' => true, 'msg' => 'تم الترفيع بنجاح']);
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'file is required']);
            }
        } else {
            return response()->json(['status' => false, 'msg' => 'item_id is required']);
        }
    }



    public function save_main_exam(Request $request)
    {

        // return $request ;
        $student_id = $request->student_id;

        $exam_result = Exam_result2::where('user_id', $student_id)
            ->where('exam_id', $request->content_id)->where('status', '1')->first();

        $exam = Exams2::find($request->content_id);

        if ($exam_result) {
            return response()->json(['msg' => 'لا يمكن إعادة الامتحان  ', 'status' => 5]);
        }
        $exam_result = Exam_result2::where('user_id', $student_id)
            ->where('exam_id', $request->content_id)->first();
        if (Carbon::now()->addMinutes(-3) >=  $exam_result->end_time) {
            return response()->json(['message' => 'انتهى الوقت  ', 'status' => 6, 'now' => Carbon::now()]);
        }

        // تغيير حالة  الامتحان للدلالة على ان الطالب قام به ,طالب واحد على الاقل يكفي لمعرفة أن هذا الامتحان لايمكن تعديل محتواه
        $exam->is_taken = '1';

        $exam->save();
        $user_answers = $request->answer;
        $selected_ques = json_decode($exam->selected_ques, true);
        // foreach ($selected_ques as $x) {
        //     $ques_id[] = $x;
        // };

        $exam_questions =  question::whereIn('id', $selected_ques)->with('option')->get();


        $student_result = 0;

        if ($request->answer != null) {
            $answer = json_decode($request->answer, true);

            $a = json_encode(json_decode($request->answer));
            $js = json_decode($a, true);
            $answer = new stdClass;
            $a = [];

            for ($i = 0; $i < count($js); $i++) {
                foreach ($js[$i] as $key => $val) {


                    $answer->{"$key"} = $val;
                }
            }


            foreach ($answer as $key => $value) {

                $exam_questions = $exam_questions->where('id', $key)->first();
                if ($exam_questions->option != null) {

                    $stored_mark = $exam_questions->mark;
                    $stored_answer  =  json_decode($exam_questions->answer);


                    $check1 = array_diff($stored_answer, $value);
                    $check2 = array_diff($value, $stored_answer);

                    if (count($check1) == 0 && count($check2) == 0) {
                        $student_result += $stored_mark;
                    }
                }
            }
        }

        $student = Student::find($student_id);
        $item = Exam_result2::where('user_id', $student_id)->where('exam_id', $request->content_id)->first();

        // give medals
        $medal = 0;
        if ($exam->mark == $student_result) {

            $medal = "1";
        } elseif ($exam->mark - 3 <= $student_result) {

            $medal = "2";
        } elseif ($exam->mark - 6 <= $student_result) {

            $medal = "3";
        } else {
            $medal = null;
        }
        $term = Term_year::where('current_term', 1)->first();


        $item->update([
            'user_id' => $student_id,
            'term_id'  => $term->id,
            'exam_id'  => $request->content_id,
            'class_id'  => $exam->class_id,
            'room_id'  => $exam->room_id,
            'lesson_id'  => $exam->lesson_id,
            'selected_ques' => $exam->selected_ques,
            'user_answers' => json_encode($answer),
            'result' => $student_result,
            'medal' =>  $medal,
            'status' => '1'
        ]);

        if (!$request->has('traditional')) {

            //   $item->result2=$item->result;
            $item->save();
        }

        return response()->json(['msg' => 'تم التخزين بنجاح    ', 'status' => 1]);
    }


    public function student_medals($student_id)
    {
        $term = Term_year::where('current_term', 1)->first();
        $exam_medals = Exam_result2::with('lesson')->where('medal', '!=', null)->where('term_id', $term->id)->where('user_id', $student_id)->orderBy('updated_at', 'desc')->get();
        $test_medals = Exam_result::with('lesson')->where('medal', '!=', null)->where('term_id', $term->id)->where('user_id', $student_id)->orderBy('updated_at', 'desc')->get();

        $medals = Medal::with('lesson')->where('student_id', $student_id)->where('term', $term->id)->orderBy('updated_at', 'desc')->get();

        return response()->json(['exam_medals' => $exam_medals, 'test_medals' => $test_medals, 'medals' => $medals]);
    }
    public function student_graduate($student_id, $room_id)
    {
        // هنا نختبر حالة جهوزية الجلاء من حقل مميز بدفتر العلامات تتغير قيمته من صفر عدم جهوزية الى واحد جهوزية عند استصدار الجلاء من قبل الادمن
        // بحال كان هناك جلاء اي قيمة اكس ستكون واحد سيكون اللينك هو رابط واجهة الجلاء لدى الطالب بالويب اي سيتنقل الطالب من التطبيق لحسابه بالويب ومن هناك يمكنه تنزيل الجلاء ك بي دي اف
        $link = 'http://localhost:8087/SMARMANger/dashboard/student/view/report/card';
        $x = 1;
        // حسب المرحلة للتانية والتاليتة الهن مجموع نهائي
        $student_final_mark = 100;
        $student_total_mark = 100;
        if ($x == '1')
            return response()->json(['status' => 1, 'link' => $link, 'student_final_mark' => $student_final_mark, 'student_total_mark' => $student_total_mark]);

        return response()->json(['status' => 0, 'message' => 'الجلاءات لم تجهز بعد']);
    }
    public function student_graduate222($student_id, $room_id)
    {
        // هنا نختبر حالة جهوزية الجلاء من حقل مميز بدفتر العلامات تتغير قيمته من صفر عدم جهوزية الى واحد جهوزية عند استصدار الجلاء من قبل الادمن
        // بحال كان هناك جلاء اي قيمة اكس ستكون واحد سيكون اللينك هو رابط واجهة الجلاء لدى الطالب بالويب اي سيتنقل الطالب من التطبيق لحسابه بالويب ومن هناك يمكنه تنزيل الجلاء ك بي دي اف
        // $link = 'https://www.google.com/search?q=google+translate&oq=&sourceid=chrome&ie=UTF-8' ;

        $year = Year::where('current_year', '1')->first();
        $room = Room::find($room_id);
        $class = $room->classes;
        $report_card_details = Report_card_details::where('year_id', $year->id)->where('class_id', $class->id)->first();
        $x = 0;
        $link = '';
        if ($report_card_details->report_card_status > 0) {
            $x = 1;
            $link = 'https://albayan-virtualschool.com/QyamMANger/dashboard/student/view/report/card';
        }
        // حسب المرحلة للتانية والتاليتة الهن مجموع نهائي
        $student_final_mark = 100;
        $student_total_mark = 100;
        if ($x == '1')
            return response()->json(['status' => 1, 'link' => $link, 'student_final_mark' => $student_final_mark, 'student_total_mark' => $student_total_mark]);
        return response()->json(['status' => 0, 'message' => 'الجلاءات لم تجهز بعد']);
    }

    public function app_teacher_sliders()
    {

        $slider = App_teacher_slider::all();
        return response()->json(['slider' => $slider, 'status' => 1]);
    }


    public function app_student_sliders()
    {
        $slider = App_student_slider::all();

        return response()->json(['slider' => $slider, 'status' => 1]);
    }
    // حالياً الشات بين الادمن والاستاذ بشكل رسائل وليست آنية باالتالي
    public function get_admin_messages($teacher_id)
    {
        $admin = User::where('role_id', '1')->first();
        $user = User::where('teacher_id', $teacher_id)->first();

        $chats = Chat::where('from', $user->id)->orWhere('to', $user->id)->get();

        foreach ($chats as $chat) {
            $chat->isread = 1;
            $chat->save();
        }

        return response()->json(['chats' => $chats, 'status' => 1]);
    }
    public function get_admin_messages_count($teacher_id)
    {
        $admin = User::where('role_id', '1')->first();
        $user = User::where('teacher_id', $teacher_id)->first();

        $messages_count = Chat::Where('to', $user->id)->where('isread', 0)->count();

        return response()->json(['messages_count ' => $messages_count, 'status' => 1]);
    }
    public function store_admin_message(Request $request)
    {
        $admin = User::where('role_id', '1')->first();
        $messages = new Chat;
        $user = User::where('teacher_id', $request->teacher_id)->first();
        $messages->from =  $user->id;
        $messages->to =  $admin->id;
        $messages->message = $request->message;
        // if($request->type == 0){
        //     $messages->message = $request->message;
        // }else{
        //     if($request->hasFile('message')){

        //     $messages->message = 'storage/'.$request->message->store('chatfile','public');
        //     $messages->isfile = 1;
        //     }
        // }
        $messages->save();

        return response()->json(['msg' => 'تم التخزين بنجاح', 'status' => 1]);
    }

    public function app_version_num()
    {

        $version_num = $about_us = About_us::first()->version_num;
        return response()->json(['version_num' => $version_num]);
    }

    public function app_parent_children($parent_id)
    {

        $year = Year::where('current_year', '1')->first();


        $children = Parents::whereHas('connections', function ($query) use ($parent_id) {
            $query->where('parent_id', $parent_id);
        })
            ->with(['connections.student.room.classes'])
            ->find($parent_id);

        return response()->json(['status' => 1, 'children' => $children]);
    }
    public function homeworke($student_id, $lesson_id, $parent_id)
    {

        $parent = Parents::with(['connections'  =>  function ($query) use ($parent_id) {
            $query->where('parent_id', $parent_id);
        }])
            ->find($parent_id);
        $lesson = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $student = Student::with('details')->find($student_id);
        $homeworke = Lesson_teacher_room_term_exam::with('lecture')->with(['exam_resullt' => function ($q) use ($student_id) {

            $q->where('user_id', $student_id);
        }])->where('lesson_id', $lesson_id)
            ->where('type', '1')->where('term_id', $term->id)->orderBy("id", 'desc')->get();
        return response()->json(['homeworke' => $homeworke]);
    }
    public function test($student_id, $lesson_id)
    {


        $lesson = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $student = Student::with('details')->find($student_id);
        $test = Lesson_teacher_room_term_exam::with(['exam_resullt.lessons' => function ($q) use ($student_id) {

            $q->where('user_id', $student_id);
        }])->where('lesson_id', $lesson_id)
            ->where('type', '8')->where('term_id', $term->id)->orderBy("id", 'desc')->get();

        $test_marks = Exam_result::where('user_id', $student_id)->with('lesson')->with('lecture')->with('exam')->orderBy("id", 'desc')->get();

        return response()->json(['test' => $test, 'test_marks' => $test_marks]);
    }
    public function quize($student_id, $lesson_id, $parent_id)
    {

        $parent = Parents::with(['connections'  =>  function ($query) use ($parent_id) {
            $query->where('parent_id', $parent_id);
        }])
            ->find($parent_id);
        $lesson = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $student = Student::with('details')->find($student_id);
        $quize = Exams2::with(['exam_resullt2' => function ($q) use ($student_id) {

            $q->where('user_id', $student_id);
        }])->where('lesson_id', $lesson_id)
            ->where('type', '2')->where('term_id', $term->id)->orderBy("id", 'desc')->get();

        // $quize1 = Exams2::with(['exam_resullt2' => function ($q) use ($student_id) {

        //         $q->where('user_id', $student_id);
        //     }])->with(['exams_files' => function ($q) use ($student_id) {

        //         $q->where('student_id', $student_id);
        //     }])->where('lesson_id', $lesson_id)->where('is_file', '1')
        //     ->where('type', '2')->where('term_id', $term->id)->orderBy("id", 'desc')->get();


        return response()->json(['quize' => $quize]);
    }
    public function exam($student_id, $lesson_id, $parent_id)
    {

        $parent = Parents::with(['connections'  =>  function ($query) use ($parent_id) {
            $query->where('parent_id', $parent_id);
        }])
            ->find($parent_id);
        $lesson = Lesson::find($lesson_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $student = Student::with('details')->find($student_id);
        $exam = Exams2::with(['exam_resullt2' => function ($q) use ($student_id) {

            $q->where('user_id', $student_id);
        }])->where('lesson_id', $lesson_id)
            ->where('type', '1')->where('term_id', $term->id)->orderBy("id", 'desc')->get();

        // $quize1 = Exams2::with(['exam_resullt2' => function ($q) use ($student_id) {

        //         $q->where('user_id', $student_id);
        //     }])->with(['exams_files' => function ($q) use ($student_id) {

        //         $q->where('student_id', $student_id);
        //     }])->where('lesson_id', $lesson_id)->where('is_file', '1')
        //     ->where('type', '1')->where('term_id', $term->id)->orderBy("id", 'desc')->get();


        return response()->json(['exam' => $exam]);
    }
    public function certificates($student_id, $parent_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        $student = Student::find($student_id);

        $parent = Parents::with(['connections'  =>  function ($query) use ($parent_id) {
            $query->where('parent_id', $parent_id);
        }])
            ->find($parent_id);
        $certificates = Certificate::with('lesson')->where("student_id", $student_id)->where('term', $term->id)->get();
        $link = "http://localhost:8087/SMARMANger/subject/" . $student_id;
        return response()->json(['certificates' => $certificates, 'link' => $link]);
    }
    public function note($parent_id, $view_parent = null)
    {

        $year = Year::where('current_year', '1')->first();
        $student = [];
        $parent = Parents::with(['connections'  =>  function ($query) use ($parent_id) {
            $query->where('parent_id', $parent_id);
        }])
            ->find($parent_id);
        foreach ($parent->connections as $item) {
            $student[] = $item->student->id;
        }

        $students = Student::whereIn('id', $student)->get();

        if ($view_parent != null) {

            $note1 = Objection::with('teacher')->with('student')->where(function ($q) {
                $q->where('type', 0)
                    ->orWhere('type', 1)
                    ->orWhere('type', 2);
            })->where("parent_id", $parent_id)->orderBy('id', 'DESC')->get();
            $note = Objection::with('teacher')->with('lesson')->with('room.classes')->with('student.room.classes')->where("type", 5)->where("parent_id", $parent_id)->where('view_parent', '0')->orderBy('id', 'DESC')->count();
            return response()->json(['note' => $note]);
        } else {
            $note1 = Objection::with('teacher')->with('student')->where(function ($q) {
                $q->where('type', 0)
                    ->orWhere('type', 1)
                    ->orWhere('type', 2);
            })->where("parent_id", $parent_id)->orderBy('id', 'DESC')->get();
            $note = Objection::with('teacher')->with('lesson')->with('room.classes')->with('student.room.classes')->where("type", 5)->where("parent_id", $parent_id)->orderBy('id', 'DESC')->get();
            foreach ($note as $item) {
                $item['time'] =  Carbon::parse($item->updated_at)->format('m-d h:i A');
            }
            return response()->json(['note' => $note]);
        }
    }


    public function set_zero_notf_count_parents_objection($parent_id)
    {


        $objection_not_view_count = Objection::where("type", 5)->where("parent_id", $parent_id)->update(['view_parent' => '1']);

        return response()->json(['status' => 20000000]);
    }

    public function SaveToken($parent_id, $fcm_token)
    {

        $old_token = Parentfcmtoken::where('p_fk', $parent_id)->where('p_fcm_token', $fcm_token)->first();

        if ($old_token == null) {
            $item = new Parentfcmtoken();
            $item->p_fk = $parent_id;
            $item->p_fcm_token = $fcm_token;

            $item->save();
        }

        return response()->json([
            'status' => true,
            'msg' => $old_token
        ]);
    }


         public function go_to_stream_student($scheduler_id,$day_id,$lecture_time_id,$room_id,$student_id)
    {
       
        $user_id = User::where('student_id',$student_id)->first()->id ;
        $scheduler_record = Lesson_room_teacher_lecture_time::findOrFail($scheduler_id);

        $day = Day::findOrFail($day_id);
        $lecture_time = Lecture_time::findOrFail($lecture_time_id);


        $hourMin = date('H:i');
        if ( $hourMin < $lecture_time->start_time || $hourMin > $lecture_time->end_time){

        }

        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);
        if ($today != $day->id - 1){

        }
    

        $student_schedule_tracer2 = Student_schedule_tracer::where('user_id',$user_id)->where('lecture_time_id',$lecture_time_id)->where('lesson_id',$scheduler_record->lesson_id)->where('day_id',$day_id)->whereDate('created_at',Carbon::now()->format('Y-m-d'))->first();
        if( $student_schedule_tracer2 == null ){
            $student_schedule_tracer = new Student_schedule_tracer() ;
            $student_schedule_tracer->user_id = $user_id ;
            $student_schedule_tracer->lecture_time_id = $lecture_time_id ;
            $student_schedule_tracer->lesson_id = $scheduler_record->lesson_id ;
            $student_schedule_tracer->day_id = $day_id ;
            $student_schedule_tracer->save();
        }

        $student = Student::findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name ;
        $google_meet_url = $scheduler_record->meeting_link ;

    return response()->json(['msg' => 'تم التخزين بنجاح','status' => 1]);
        // return view('students.new_student_stream',compact('room_name','room_id','class_name','student','room'));
    }





     public function go_to_stream_teacher($scheduler_id,$day_id,$lecture_time_id,$room_id,$teacher_id)
    {
            
        $user_id = User::where('teacher_id',$teacher_id)->first()->id ;
        $scheduler_record = Lesson_room_teacher_lecture_time::findOrFail($scheduler_id);

        $day = Day::findOrFail($day_id);
        $lecture_time = Lecture_time::findOrFail($lecture_time_id);


        $hourMin = date('H:i');
        if ( $hourMin < $lecture_time->start_time || $hourMin > $lecture_time->end_time){

        }

        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);
        if ($today != $day->id - 1){

        }

        $student_schedule_tracer2 = Student_schedule_tracer::where('user_id',$user_id)->where('lecture_time_id',$lecture_time_id)->where('lesson_id',$scheduler_record->lesson_id)->where('day_id',$day_id)->whereDate('created_at',Carbon::now()->format('Y-m-d'))->first();
        if( $student_schedule_tracer2 == null ){
            $student_schedule_tracer = new Student_schedule_tracer() ;
            $student_schedule_tracer->user_id = $user_id ;
            $student_schedule_tracer->lecture_time_id = $lecture_time_id ;
            $student_schedule_tracer->lesson_id = $scheduler_record->lesson_id ;
            $student_schedule_tracer->day_id = $day_id ;
            $student_schedule_tracer->save();
        }

        $student = Student::findOrFail($student_id);
        $room = Room::findOrFail($room_id);
        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name ;
        $google_meet_url = $scheduler_record->meeting_link ;

    return response()->json(['msg' => 'تم التخزين بنجاح','status' => 1]);
        // return view('students.new_student_stream',compact('room_name','room_id','class_name','student','room'));
    }


}
