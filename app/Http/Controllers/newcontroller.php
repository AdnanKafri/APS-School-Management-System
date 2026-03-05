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
use session;

use RealRashid\SweetAlert\Facades\Alert;

class newcontroller extends Controller
{

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

        return view('teachers2.teacher_index', compact('objection', 'teacher', 'events', 'count', 'count2', 'teacher_name', 'classes', 'message'));
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
        $lectures = Lecture::with('teacher')->where('active', 0)->where('term_id', $terms->id)->where('lesson_id', $lesson->id)->where('room_id', $room_id)->get();
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
        ->where('room_id', $request->room_id)
        ->where('lecture_time', 'LIKE','%'. $request->date .'%')
        ->get();
        return $lectures;
        // return view('teachers2.teacher_searchlecture',compact('lectures','teacher','lesson', 'lesson_id', 'room_id','class','room'));


    }


    //select lecture
    public function selectlesson($lec,Request $request)
    {
        if ($lec != 0) {

            $lectures = Lecture::with('teacher')->where('active', 0)->where('term_id', $terms->id)->where('lesson_id', $lesson->id)->where('room_id', $room_id)->get();
        }


        return  $lectures;
    }

    //for add lesson to subject
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
        $item->lecture_time = $request->lecture_time;
        $item->name = $request->name;

        $item->save();
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
    {
        $lectures = Lecture::find($request->question_id);
        $lectures->delete();
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
        $message = new Message;
        $message->year_id = $year->id;
        $message->student_id = $request->student_id;
        $message->message = $request->message;
        $message->teacher_id = $request->teacher_id;
        $message->save();
        return redirect()->back();
    }
    //send message for all students
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
    //show all messages of students

    public function filter_message(Request $request)
    {
        $st = [];
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'desc')->get();
        foreach ($message as $item) {
            $st[] = $item->student_id;
        }

        return Student::withCount('message')->with('room')->with(['message1' => function ($q) {
            $q->where('teacher_id', Auth::user()->teacher_id);
            $q->orderBy('id', 'desc');
        }])->whereHas('room',function ($q) use($request) {
            if ($request->room != "" ) {
                $q->where('rooms.id', $request->room);
            }
        })->whereHas('room.classes' , function ($q) use($request) {
            $q->where('classes.id',$request->class);
        })->with('room.classes')->whereIn('id', $st)->get();

    }

    public function get_message()
    {
        $st = [];
        $teacher = Teacher::find(Auth::user()->teacher_id);
        $message = Message::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'desc')->get();
        foreach ($message as $item) {
            $st[] = $item->student_id;
        }

        $message1 = Message::where('teacher_id', Auth::user()->teacher_id)->orderBy("id", 'desc')->get();

        $student = Student::withCount('message')->with('room')->with(['message1' => function ($q) {
            $q->where('teacher_id', Auth::user()->teacher_id);
            $q->orderBy('id', 'desc');
        }])->with('room.classes')->whereIn('id', $st)->get();

        $classes = Classe::all();

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

        $teacher_events = Teacher_event::all();
        $events = Teacher_event::where('teacher_id', auth()->user()->teacher_id)->get();
        $teacher = Teacher::find(auth()->user()->teacher_id);
        $classes = $teacher->classes->unique();
        $count = Messages_super::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
        $count = $count->count();

        return view('teachers2.teacher_events', compact('teacher_events', 'events', 'teacher', 'count', 'classes'));
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

    public function update_teacher_event(Request $request, $id)
    {
        //

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
        $teacher_events = Teacher_event::find($id);

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
        return view('teachers2.teacher_newaddcontent', compact('objection', 'rooms2', 'message', 'lecture_id', 'room_id', 'room1', 'class_id', 'terms', 'teacher', 'lessons', 'count', 'count2'));
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
       // if ($request->video == null && $request->video_in == null && $request->quize_link1 == null && $request->quize1 == null && $request->audio_file == null && $request->voice == null && $request->audio_link == null && $request->test == null && $request->quize == null && $request->exam == null && $request->test_link == null && $request->quize_link == null && $request->exam_link == null && $request->addition == null  &&  $request->addition_link == null) {
       //     return redirect()->back()->with('message', 'المحتوى فارغ يرجى اعادة تعبئة البيانات من جديد');
       // }
         //item for test
        if ($item->type == 1) {
            $item->namehomework = $request->namehomework;
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $request->term_id;
            $item->type = $request->type;
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
            session()->flash('Add', 'تم تعديل  بنجاح');
            return redirect()->back()->with('Add', '! تمت العملية بنجاح ');

        //item for video
        } else if ($item->type == 0) {
            $item->lecture_id = $request->lecture_id;
            $item->namehomework = $request->namehomework;
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $request->term_id;
            $item->type = $request->type;
            if ($request->video == null && $request->video_in == null) {

                return redirect()->back()->with('message', 'محتوى الفيديو فارغ يرجى تعبئة البيانات من جديد');
            }
            if ($request->video_in && $request->hasFile('video_in')) {
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

            session()->flash('Add', 'تم تعديل  بنجاح');

            return redirect()->back()->with('Add', '! تمت العملية بنجاح ');

            //item for audio
        } else if ($item->type == 6) {
            $item->lecture_id = $request->lecture_id;
            $item->namehomework = $request->namehomework;
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $request->term_id;
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

            session()->flash('Add', 'تم تعديل  بنجاح');


            return redirect()->back()->with('Add', '! تمت العملية بنجاح ');
            //item for file
        } else if ($item->type == 4) {
            $item->lecture_id = $request->lecture_id;
            $item->namehomework = $request->namehomework;
            $item->lesson_id = $request->lesson_id;
            $item->teacher_id = $request->teacher_id;
            $item->room_id = $request->room_id;
            $item->term_id = $request->term_id;
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


        $book_details = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->where('term_id', $terms->id)
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
            'room'

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
        $lectures = Lecture::with('teacher')->where('active', 0)->where('term_id', $terms->id)->where('lesson_id', $lesson->id)->where('room_id', $room_id)->get();
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

        $message = Message::where('teacher_id', Auth::user()->teacher_id)->where('type', 1)->where('view', 0)->count();
        // return $student_id ;
        $user_id = auth()->user()->id;
        $teacher_id = auth()->user()->teacher_id;
        $teacher = Teacher::find($teacher_id);
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);


        // $room = Room::findOrFail($room_id);
        // $lessons = $room->lessons2 ;
        // pring teachers

        // pring lecture_tims
        $lecture_times = Lecture_time::where('room_id', $room->id)->get();
        foreach ($lecture_times as $lecture_time) {

            $lecture_time->start_time = \Carbon\Carbon::parse($lecture_time->start_time);
            $lecture_time->end_time = \Carbon\Carbon::parse($lecture_time->end_time);
            $lecture_time->start_time->addMinute($time_zone_offset)->format('H:i:s');
            $lecture_time->end_time->addMinute($time_zone_offset)->format('H:i:s');
        }
        // pring days
        $days = Day::all();
        // pring teacher schedule
        $schedule = Lesson_room_teacher_lecture_time::with('lesson', 'lecture_time')->with(['room.classes' => function ($query) {
                $query->select("id", "name");
            }])
            ->join('lecture_times', 'lecture_times.id', '=', 'lesson_room_teacher_lecture_time.lecture_time_id')
            ->orderBy('lecture_times.start_time')
            ->select("lesson_room_teacher_lecture_time.*")
            ->where('teacher_id', $teacher_id)->get();

        // pring student schedule tracer
        $student_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::today())->where('user_id', $user_id)->get();
        $today_lectures = $schedule->where('day_id', $today + 1);
        // return $today_lectures  ;
        $now = Carbon::now();
        $minutes = 0;
        foreach ($today_lectures  as $key => $today_lecture) {
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
        }


        $objection = Objection::where('teacher_id', Auth::user()->teacher_id)->where('view', 0)->count();
        return view('teachers2.teacher_schedule', compact('objection', 'message', 'teacher', 'now', 'teacher_id', 'lecture_times', 'days', 'schedule', 'today', 'minutes'));
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
        $students = $room->with('student.student_lesson_teacher_room_term_exam')->with('student.exam_result')->get();
        $exam1 = Lesson_teacher_room_term_exam::find($exam_id);
        $quize_result = Room::with(['student.exam_result' => function ($q) {
            $q->where('id', '<>', null)->orderBy('type');
        }])->where('id', $room_id)->get();
        $exam_title = Lesson_teacher_room_term_exam::where('room_id', $room_id)->where('lesson_id', $lesson_id)
            ->where('teacher_id', $teacher_id)->orderBy('type')->get();
        $message=Message::where('teacher_id',Auth::user()->teacher_id)->where('type',1)->where('view',0)->count();
        $objection=Objection::where('teacher_id',Auth::user()->teacher_id)->where('view',0)->count();
        return view('teachers2.teacher_homework_students', compact('objection','message','students', 'exam1','lesson' ,'room','exam_title', 'quize_result', 'teacher', 'exam_id', 'lesson_id', 'room_id'));
    }
    public function student_save_mark(Request $request)

    {

        $home = Lesson_teacher_room_term_exam::find($request->exam_id);
        
        // --- Enforce Gradebook Config ---
        try {
            $year = \App\Year::where('current_year', '1')->first();
            if ($year && $home) {
                // ... logic ...
                $config = \App\GradebookConfig::where('lesson_id', $home->lesson_id)
                                              ->where('year_id', $year->id)
                                              ->first();
                if ($config) {
                    $maxMark = 0;
                    if ($home->type == 1) { // Homework
                        $maxMark = $config->homework_max;
                    } else { // Fallback
                        $maxMark = $config->oral_max;
                    }
                    
                    if ($maxMark > 0 && $request->mark > $maxMark) {
                         return redirect()->back()->with('warning', "العلامة ({$request->mark}) أكبر من الحد المسموح به لهذا النوع ({$maxMark})");
                    }
                }
            }
        } catch (\Exception $e) {
            // Ignore config errors (missing table, etc) to prevent teacher block
        }
        // --------------------------------

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






}
