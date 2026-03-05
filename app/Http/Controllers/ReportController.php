<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Day;
use App\Exports\StudentExport;
use App\Lecture_time;
use App\Lesson;
use App\Lesson_room_teacher_lecture_time;
use App\Lesson_teacher_room_term_exam;
use App\Room;
use App\Room_student;
use App\Student;
use App\Student_schedule_tracer;
use App\Teacher;
use App\User;
use App\Year;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Rect;
use stdClass;

class ReportController extends Controller
{

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

    public function getstudentsdetails($id)
    {
        return  Student::with('details')->find($id);
    }




    public function all_workschedule($id)
    {
        $year = Year::where('current_year',1)->first();
        if($id == 0){
            $rooms = Room::where('year_id',$year->id)->get();
        }else{
            $rooms = Room::where('year_id',$year->id)->where('class_id',$id)->get();
        }
        $schedules = [];
        $room_name = [];
        $class_name = [];
        $lecture_times = [];

        $teachers = DB::table('teachers')
        ->select('id' ,'first_name','last_name')
        ->get();

        foreach ($rooms as $key => $value) {
            $room = $value;
            $room_id = $value->id;
            $class_id = Room::findOrFail($room_id)->class_id;
            $lessons = Lesson::where('class_id',$class_id)->get();
            // pring teachers

            // pring lecture_tims
            $lecture_times [] = Lecture_time::where('class_id',$room->class_id)->orderBy('start_time','asc')->get();
            // pring days
            $days = Day::all();
            // pring romm schedule
            $schedule = Lesson_room_teacher_lecture_time::with('lesson','teacher')
            ->where('room_id',$room_id)->get();

            $schedules [] = $schedule;
            $room_name [] = $room->name;
            $room_id = $room->id;
            $class_name [] =  $room->classes->name ;
            $now=Carbon::now();
        }

        $classes = Classe::all();

        return view('admin.reports.workschedule',compact('classes','class_name','room_name','now','lessons','lecture_times','days','schedules','teachers','id'));
    }




    public function teachers_schedule()
    {

       $teacher = Teacher::all();
       $schedules = [];
       foreach ($teacher as $key => $value) {
            $user = User::where('teacher_id',$value->id)->first();
            $timestamp = strtotime(now());
            $today = date('l', $timestamp);
            $today = $this->getDay($today);
            $teacher_id = $value->id;

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
            where('user_id',$user->id)->get();
            $today_lectures = $schedule->where('day_id',$today +1) ;
            // return $today_lectures  ;
            foreach($today_lectures  as $key => $today_lecture){
                $tracer =  $student_schedule_tracer->where('lecture_time_id',$today_lecture->lecture_time_id);
                    if (!blank($tracer)){
                        $today_lecture->attendance = true;
                    }else {
                        $today_lecture->attendance = false;
                    }
            }
            $schedules [] = $schedule;
       }

        $now=Carbon::now();

        return view('admin.reports.new_teacher_schedule',compact('teacher','now','lecture_times','days','schedules','today'));
    }



    public function getteachers2 (Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length;

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $search_bar = $request->barcode_pos_check;
        $class_filter = $request->classes;
        $room_filter = $request->rooms;

        if($request->start2 == ""){
            $start_date = "2020-10-10";
        }else{
            $start_date = $request->start2;
        }

        if($request->end2 == ""){
            $end_date = "2200-10-10";
        }else{
            $end_date = $request->end2;
        }


        $columnIndex = $columnIndex_arr[0]['column'];
        $searchValue = $search_arr['value'];
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;

        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%". $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = Teacher::count();
        $totalRecordswithFilter = Teacher::whereHas('rooms.classes',function($q) use($class_filter,$room_filter){
            $year = Year::where('current_year','1')->first();
            if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('rooms.year_id',$year->id);
            }else if($class_filter != "" && $class_filter != null){
                $q->where('classes.id', $class_filter);
            }
        })->where(function($q) use($result_search){
            $q->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
        })->count();

        $records = Teacher::whereHas('rooms.classes',function($q) use($class_filter,$room_filter){
            $year = Year::where('current_year','1')->first();
            if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('rooms.year_id',$year->id);
            }else if($class_filter != "" && $class_filter != null){
                $q->where('classes.id', $class_filter);
            }
        })->where(function($q) use($result_search){
            $q->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
        })->with(['user.student_schedule_tracer' => function($q1) use($start_date , $end_date){
            $q1->select(['lesson_id','user_id', DB::raw('COUNT(*) as count')])
                ->whereDate('student_schedule_tracer.created_at',">=",$start_date)->whereDate('student_schedule_tracer.created_at',"<=",$end_date)->groupBy('lesson_id','user_id');
        }])->skip($start)->take($rowperpage)->get();


        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "first_name" => $record->first_name,
                "last_name" => $record->last_name,
                "address" => $record->address,
                "date_birth" => $record->date_birth,
                "image" => $record->image,
                "id" => $record->id ,
                "phone"=>$record->phone,
                "user"=>$record->user,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
            "start_date" => $start_date,
            "end_date" => $end_date,
        );
        echo json_encode($response);
        exit;
    }


    public function teacher_pdf()
    {
        $teachers=Teacher::with('user')->orderBy('first_name')->paginate(20);
        $count=Teacher::count();
        $classes=Classe::all();
        return view('admin.reports.teacher',compact('teachers','count','classes'));
    }


    public function teacher_attend()
    {
        // $datetime1 = new DateTime("2022-09-24 22:12:56");
        // $datetime2 = new DateTime("2022-11-24 22:12:56");
        // $interval = $datetime1->diff($datetime2);
        // return $days = $interval->format('%a');
        $classes = Classe::all();
        $classes2 = Classe::pluck('name', 'id');
        $lesson = Lesson::pluck('name', 'id');
        $lesson2 = Lesson::pluck('class_id', 'id');
        return view('admin.reports.teacher_attend',compact('classes','lesson','lesson2','classes2'));
    }


    public function update_tracer()
    {
        set_time_limit(100000);
        ini_set("max_execution_time", "-1");
        ini_set('memory_limit','-1');
        $tracer = Student_schedule_tracer::all();
        foreach ($tracer as $key => $value) {
            $user = User::find($value->user_id);
            if($user->student_id != null){
                $year = Year::where('current_year',1)->first();
                $room = Room_student::where('year_id',$year->id)->where('student_id',$user->student_id)->first();
                $teacher_lecture_time = Lesson_room_teacher_lecture_time::where('room_id',$room->room_id)->where('lecture_time_id',$value->lecture_time_id)->where('day_id',$value->day_id)->first();
                if($teacher_lecture_time){
                    $value->lesson_id = $teacher_lecture_time->lesson_id;
                    $value->save();
                }
            }else if($user->teacher_id){
                $teacher_lecture_time = Lesson_room_teacher_lecture_time::where('teacher_id',$user->teacher_id)->where('lecture_time_id',$value->lecture_time_id)->where('day_id',$value->day_id)->first();
                if($teacher_lecture_time){
                    $value->lesson_id = $teacher_lecture_time->lesson_id;
                    $value->save();
                }
            }
        }
        return redirect()->back();
    }




    public function getstudent_with_attend(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $class_filter = $request->class;
        // return $request;
        $now = new Carbon($start_date." "."00:00:00");
        $now2 = new Carbon($end_date." "."00:00:00");
        $records = Student::WhereHas('room.classes', function($q) use ($class_filter) {
                $year = Year::where('current_year','1')->first();
                $q->where('classes.id', $class_filter);
          })->with('room.classes','user','details')->with(['room'=>function($q1){
                $year = Year::where('current_year','1')->first();
                $q1->where('room_student.year_id',$year->id);
        }])->with(['user.student_schedule_tracer' => function($q1) use($start_date , $end_date,$now){
            $q1->select(['lesson_id','user_id','created_at', DB::raw('COUNT(*) as count')])->
            whereDate('student_schedule_tracer.created_at',">=",$start_date)->whereDate('student_schedule_tracer.created_at',"<=",$end_date)->groupBy('lesson_id','user_id');
        }])->get();


        // $year = Year::where('current_year',1)->first();
        // return $product = DB::table('students')
        // ->join('student_details', 'student_details.student_id', '=', 'students.id')
        // ->join('room_student', 'room_student.student_id', '=', 'students.id')
        // ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        // ->join('classes', 'rooms.class_id', '=', 'classes.id')
        // ->join('users', 'users.student_id', '=', 'students.id')
        // ->join('student_schedule_tracer', 'student_schedule_tracer.user_id', '=', 'users.id')
        // ->select('students.first_name','students.last_name','classes.name as class_name','rooms.name as rooms_name','student_schedule_tracer.lesson_id','student_schedule_tracer.user_id',"student_schedule_tracer.created_at")
        // ->where('room_student.year_id',$year->id)
        // ->where('classes.id','like',$class_filter)
        // ->whereDate('student_schedule_tracer.created_at',">=",$start_date)
        // ->groupBy('user_id','lesson_id')
        // ->having('student_schedule_tracer.created_at',">",$now)
        // ->get();

        $lessons = Lesson::where('class_id',$class_filter)->get();

        return [
            'records' => $records , 'lessons' => $lessons
        ];

    }




    public function getstudents2(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $class_filter = $request->class_id;
        $room_filter = $request->room_id;
        $search_bar = $request->barcode_pos_check;
        $start_date = "2022-09-15";
        $end_date = "2022-12-25";

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;

        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%". $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = Student::count();
        $totalRecordswithFilter = Student::where(function($qu) use($result_search){
            $qu->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
            })->WhereHas('room.classes', function($q) use ($class_filter,$room_filter) {
                 $year = Year::where('current_year','1')->first();
                if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                    $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
                }else if($class_filter != "" && $class_filter != null){
                    $q->where('classes.id', $class_filter);
                }
          })->with('room.classes')->with(['room'=>function($q1) use($room_filter){
            $year = Year::where('current_year','1')->first();
            if($room_filter != "" && $room_filter != null ){
                $q1->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
            }else{
                $q1->where('room_student.year_id',$year->id);
            }
        }])->with(['user.student_schedule_tracer' => function($q1) use($start_date , $end_date){
            $q1->select(['lesson_id','user_id', DB::raw('COUNT(*) as count')])
                ->whereDate('student_schedule_tracer.created_at',">=",$start_date)->whereDate('student_schedule_tracer.created_at',"<=",$end_date)->groupBy('lesson_id','user_id');
        }])->count();
        $records = Student::where(function($qu) use($result_search){
            $qu->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
            })->WhereHas('room.classes', function($q) use ($class_filter,$room_filter) {
                 $year = Year::where('current_year','1')->first();
                if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                    $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
                }else if($class_filter != "" && $class_filter != null){
                    $q->where('classes.id', $class_filter);
                }
          })->with('room.classes','user','details')->with(['room'=>function($q1) use($room_filter){
            $year = Year::where('current_year','1')->first();
            if($room_filter != "" && $room_filter != null ){
                $q1->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
            }else{
                $q1->where('room_student.year_id',$year->id);
            }
        }])->with(['user.student_schedule_tracer' => function($q1) use($start_date , $end_date){
            $q1->select(['lesson_id','user_id', DB::raw('COUNT(*) as count')])
                ->whereDate('student_schedule_tracer.created_at',">=",$start_date)->whereDate('student_schedule_tracer.created_at',"<=",$end_date)->groupBy('lesson_id','user_id');
        }])->skip($start)
        ->take($rowperpage)->get();


        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "first_name" => $record->first_name,
                "last_name" => $record->last_name,
                "address" => $record->address,
                "phone" => $record->phone,
                "img" => $record->image,
                "room" => $record->room ,
                "id" => $record->id ,
                "lang" => $record->lang ,
                "user"=>$record->user,
                "details"=>$record->details,

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
        exit;
    }

     public function student_report_chart()
    {
        $classes = Classe::all();
        $year = Year::where('current_year',1)->first();
        $year_name = $year->name;
        return view('admin.reports.chart_report',compact('classes','year_name'));
    }
  public function get_data_chart( Request $request )
    {

        $year = Year::where('current_year',1)->first();
        $student = Room_student::where('student_id',$request->id)->where('year_id',$year->id)->first();
        $room = Room::find( $student->room_id );
        $class = Classe::find( $room->class_id );

        $object = new stdClass;

        $lessons = '';
        if($request->lesson_id == 0){
            $lessons = Lesson::where('class_id',$class->id)->get();
        }else{
            $lessons = Lesson::where('id',$request->lesson_id)->get();
        }

            foreach ($lessons as $key => $value) {

                $rows = DB::table('students_marks')->where('student_id',$request->id)->where('year_id',$year->id)
                ->selectRaw("CAST( JSON_EXTRACT(mark, '$.\"$value->id\".oral') AS DECIMAL(10,6) )*100/(10*$value->max_mark/100) AS 'oral'")
                ->selectRaw("CAST( JSON_EXTRACT(mark, '$.\"$value->id\".homework') AS DECIMAL(10,6) )*100/(10*$value->max_mark/100) AS 'homework'")
                ->selectRaw("CAST( JSON_EXTRACT(mark, '$.\"$value->id\".activities') AS DECIMAL(10,6) )*100/(20*$value->max_mark/100) AS 'activities'")
                ->selectRaw("CAST( JSON_EXTRACT(mark, '$.\"$value->id\".quize') AS DECIMAL(10,6) )*100/(20*$value->max_mark/100) AS 'quize'")
                ->selectRaw("CAST( JSON_EXTRACT(mark, '$.\"$value->id\".exam') AS DECIMAL(10,6) )*100/(40*$value->max_mark/100) AS 'exam'")
                ->selectRaw("CAST( JSON_EXTRACT(mark2, '$.\"$value->id\".oral') AS DECIMAL(10,6) )*100/(10*$value->max_mark/100) AS 'oral2'")
                ->selectRaw("CAST( JSON_EXTRACT(mark2, '$.\"$value->id\".homework') AS DECIMAL(10,6) )*100/(10*$value->max_mark/100) AS 'homework2'")
                ->selectRaw("CAST( JSON_EXTRACT(mark2, '$.\"$value->id\".activities') AS DECIMAL(10,6) )*100/(20*$value->max_mark/100) AS 'activities2'")
                ->selectRaw("CAST( JSON_EXTRACT(mark2, '$.\"$value->id\".quize') AS DECIMAL(10,6) )*100/(20*$value->max_mark/100) AS 'quize2'")
                ->selectRaw("CAST( JSON_EXTRACT(mark2, '$.\"$value->id\".exam') AS DECIMAL(10,6) )*100/(40*$value->max_mark/100) AS 'exam2'")
                ->first();



                $object->{$value->name} = $rows;

            }
        // }else{

        // }
                // return 5;

        return response()->json($object);

    }
     public function get_info_class_bystudent( Request $request )
    {
        $year = Year::where('current_year',1)->first();
        $student = Room_student::where('student_id',$request->id)->where('year_id',$year->id)->first();
        $room = Room::find( $student->room_id );
        $lesson = Lesson::where('class_id',$room->class_id)->get();

        return [
            'room' => $room , 'lesson' => $lesson
        ];
    }
     public function get_info_class( Request $request )
    {
        $year = Year::where('current_year',1)->first();
        $room = Room::where('class_id',$request->id)->where('year_id',$year->id)->where('branch_id',$request->branch_id)->get();
        $lesson = Lesson::where('class_id',$request->id)->get();

        return [
            'room' => $room , 'lesson' => $lesson
        ];
    }
     public function getstudent_select2 (Request $request)
    {
       
       
        $page = $request->page;
        $resultCount = 30;
        $seach = str_replace(" ","*",$request->q);
        $pieces = explode("*", $seach);
        $seach1 = '';
        $seach2 = '';

        for ($i=0; $i < sizeof($pieces) ; $i++) {
            $seach1 .= $pieces[$i] ."%";
            $seach2 .= $pieces[sizeof($pieces) -1 - $i] ."%";
        }

        $offset = ($page - 1) * $resultCount;
        
        $count = Student::
                    whereHas('room', function ($query)   {
                        $year = Year::where('current_year',1)->first();
                        $query->where('rooms.year_id', $year->id);
                            
                    })
                    ->where('first_name', 'like', $seach1)->orwhere('last_name', 'like', $seach2)->count();
        $data = Student::
                    whereHas('room', function ($query)    {
                        $year = Year::where('current_year',1)->first();
                        $query->where('rooms.year_id', $year->id);
                            
                    })
                    ->select(DB::raw("first_name"),"last_name","id")->where('first_name', 'like', $seach1)->orwhere('last_name', 'like', $seach2)-> whereHas('room', function ($query)   {
                        $year = Year::where('current_year',1)->first();
                        $query->where('rooms.year_id', $year->id);
                            
                    })->select(DB::raw("first_name"),"last_name","id")->skip($offset)->take($resultCount)->get();

        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;

        $results = array(
            "results" => $data,
            "pagination" => array(
                "more" => $morePages
            )
        );
        return response()->json($results);
    }
    public function index()
    {
        return view('admin.reports.index');
    }

    public function export_student(Request $request)
    {
        return Excel::download(new StudentExport($request), 'users.xlsx');
    }

    public function students()
    {

        $year2 = Year::where('current_year','1')->first();
        $classes = Classe::all();
        $lesson = Lesson::pluck('name', 'id');
        return view('admin.reports.student',compact('year2','classes','lesson'));
    }

    public function student_pdf()
    {
        $year2 = Year::where('current_year','1')->first();
        $classes = Classe::all();
        return view('admin.reports.student_pdf',compact('year2','classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
