<?php

namespace App\Http\Controllers;
use Artisan;
use ZipArchive;
use App\About_us;
use App\Applicant;
use Illuminate\Http\Request;
use App\Blog;
use App\Header_info;
use App\Student;
use App\Classe;
use App\Contact;
use App\Event;
use App\Exams;
use App\Footer;
use App\Invoice;
use App\Job;
use App\Room;
use App\Year;
use App\Lesson;
use App\Message;
use App\Teacher_event;
use App\Inside_slider;
use App\News;
use App\Supervisor;
use App\Supervisor_class_lesson;
use App\Teacher;
use App\Room_student;
use App\Post;
use App\Recruitment;
use App\Slider;
use App\Students_mark;
use App\Tag;
use App\Student_lesson_teacher_room_term_exam;
use App\Lesson_teacher_room_term_exam;
use App\Backup;
use Illuminate\Support\Facades\Session;
use File;
use App\Teacher_room_lesson;
use App\Term;
use App\Term_year;
use App\User;
use App\Role;
use App\Video;
use Carbon\Carbon;
use DataTables;
use Dotenv\Validator;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use stdClass;
use RealRashid\SweetAlert\Facades\Alert;
use Shuttle_Dumper;
use Shuttle_Exception;
use function GuzzleHttp\json_decode;
use function PHPSTORM_META\type;
use App\Report_card;
use App\Student_detail;
use App\Student_details_department;
use App\Country_currency;
use App\Stage;
use App\Class_cost;
use App\Basic_stage;
use ZipArchive as A;

// dd( DB::table('student_rooms')->leftJoin('students', 'students.id', '=', 'student_rooms.student_id')
// ->get('Address'));

// dd( DB::table('classes')->Join('rooms', 'classes.Id', '=', 'rooms.class_id')->get());
      // dd( DB::table('classes')->Join('rooms', 'classes.Id', '=', 'rooms.class_id')->get());
        // dd(Post::find(2)->tag);
class admincontroller extends Controller
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

    public function students(){
        $year = Year::where('current_year','1')->first();
        $students=Student::with(['room'=>function($q1){
            $year = Year::where('current_year','1')->first();
            $q1->where('room_student.year_id',$year->id);
        }
        ])->orderBy('first_name')->paginate(paginate_num);

        $classes=Classe::all();
        $count=Student::count();
        $years=Year::all();
        $year2 = Year::where('current_year','1')->first();

        return view('admin.students',compact('students','count','classes','years','year2'));
    }


public function result_active(){

    $students=Student::all();
    foreach($students as $student){
        $student->status='1';
        $student->save();
    }

    return redirect()->back()->with('success','! تمت العملية بنجاح ');
}


public function result_disable(){

    $students=Student::all();
    foreach($students as $student){
        $student->status='0';
        $student->save();
    }

    return redirect()->back()->with('success','! تمت العملية بنجاح ');
}






public function quize_active(){

    $students=Student::all();
    foreach($students as $student){
        $student->quize_status='1';
        $student->save();
    }

    return redirect()->back()->with('success','! تم اصدار نتائج المذاكرات بنجاح');
}


public function quize_disable(){

    $students=Student::all();
    foreach($students as $student){
        $student->quize_status='0';
        $student->save();
    }

    return redirect()->back()->with('success','! تم اخفاء نتائج المذاكرات بنجاح');
}




public function validate_email1(Request $request) {


if ($request->validate(['email'=>'required|email|unique:users'])) ;




}

    public function student_store(Request $request){

        $this->validate($request, [
            'first_name' =>'required',
            'last_name' =>'required',
            'father_name' =>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required',
            'class_id'=>'required|Numeric',
            'room_id'=>'required|Numeric',
            'password' => 'required|min:6',

            'password_confirmation' => 'required_with:password|same:password|min:6',


        ]);

       $student= Student::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'father_name'=>$request->father_name,
            'mother_name'=>$request->mother_name,
            'place_birth'=>$request->place_birth,
            'date_birth'=>$request->date_birth,
            'box_birth'=>$request->box_birth,
            'nationality'=>$request->nationality,
            'army_room'=>$request->army_room,
            'email'=>$request->email,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'class_id'=>$request->class_id,
            'room_id'=>$request->room_id,
            'place'=>$request->place,
            'transparent'=>$request->status,
            'lang'=>'0',
            'religion'=>$request->religion,
        ]);

        if ($request->hasFile('family_book_image')) {

            $student->family_book_image=$request->family_book_image->store('studentsimage','public');

        }


        if ($request->hasFile('health_certificate_image')) {

            $student->health_certificate_image=$request->health_certificate_image->store('studentsimage','public');


        }

// return "s";
        if ($request->hasFile('school_seq_image')) {


                $student->school_seq_image1=$request->school_seq_image[0]->store('studentsimage','public');

                if (isset($request->school_seq_image[1])) {

                    $student->school_seq_image2=$request->school_seq_image[1]->store('studentsimage','public');
                }


        }


        if ($request->hasFile('last_certificate_image')) {


            $student->last_certificate_image=$request->last_certificate_image->store('studentsimage','public');

        }


        if ($request->hasFile('image')) {

            $student->image=$request->image->store('studentsimage','public');


        }

        $student->save();

        $user=User::create([
            'name'=>$request->first_name,
            'email'=>$request->email,
            'mobile'=>$request->phone,
            'password'=>Hash::make($request->password),
            'view_password'=>$request->password,
            'type'=>'0',
            'student_id'=>$student->id,

        ]);
        $year = Year::where('current_year' , '1') ->first();

        $room_student=new Room_student;
        $room_student->student_id=$student->id;
        $room_student->year_id=$year->id;

        $room_student->room_id=$request->room_id;

        $room_student->save();

        $lessons=Lesson::where('class_id',$request->class_id)->get();
        $object1=new stdClass();
        foreach($lessons as $item){
            $object1->{$item->id}['oral']=$request->oral;
            $object1->{$item->id}['homework']=$request->homework;
            $object1->{$item->id}['activities']=$request->activities;
            $object1->{$item->id}['quize']=$request->quize;
            $object1->{$item->id}['exam']=$request->exam;


        }

        $object2=new stdClass();
        foreach($lessons as $item){
            $object2->{$item->id}['oral']=$request->oral;
            $object2->{$item->id}['homework']=$request->homework;
            $object2->{$item->id}['activities']=$request->activities;
            $object2->{$item->id}['quize']=$request->quize;
            $object2->{$item->id}['exam']=$request->exam;


        }

        $object_result1=new stdClass();

        foreach($lessons as $item){
            $object_result1->{$item->id}['term1_quizes']=null;
            $object_result1->{$item->id}['term1_exam']=null;
            $object_result1->{$item->id}['term1_result']=null;

        }


        $object_result2=new stdClass();

        foreach($lessons as $item){
            $object_result2->{$item->id}['term2_quizes']=null;
            $object_result2->{$item->id}['term2_exam']=null;
            $object_result2->{$item->id}['term2_result']=null;

        }

        $object_result=new stdClass();

        foreach($lessons as $item){
            $object_result->{$item->id}['year_result']=null;

        }

        $object_result_term=new stdClass();

        $object_result_term->{'term1'}=null;
        $object_result_term->{'term2'}=null;

        // return json_encode($object_result_term);
        $year = Year::where('current_year' , '1') ->first();

Students_mark::create([
    'student_id'=>$student->id,
    'room_id'=>$request->room_id,
    'year_id'=>$year->id,
    'mark'=>json_encode($object1),
    'mark2'=>json_encode($object2),
    'result1'=>json_encode($object_result1),
    'result2'=>json_encode($object_result2),
    'result'=>json_encode($object_result),
    'term_result'=>json_encode($object_result_term),
    'status'=>'1',
    'lang'=>'0',
    'religion'=>$request->religion,

]);


if ($student->lang==0) {
    $lessons=Lesson::where('class_id',$request->class_id)->where('lang','1')->get();

}elseif($student->lang==1){
    $lessons=Lesson::where('class_id',$request->class_id)->where('lang','0')->get();

}



foreach($lessons as $lesson){

    if ($lesson->lang!=null) {

        $student_mark=Students_mark::where('student_id',$student->id)->where('lang',$student->lang)->where('year_id',$year->id)->first();




             $arr1= json_decode($student_mark->mark,true) ;
              $arr2= json_decode($student_mark->mark2,true) ;
             $arr_result1= json_decode($student_mark->result1,true) ;
             $arr_result2= json_decode($student_mark->result2,true) ;
             $arr_result= json_decode($student_mark->result,true) ;

                if(array_key_exists($lesson->id,$arr1)=='1'){

                   unset($arr1[$lesson->id]);

                   $student_mark->mark=json_encode($arr1);

    }

                            if(array_key_exists($lesson->id,$arr2)){

                   unset($arr2[$lesson->id]);
                   $student_mark->mark2=json_encode($arr2);

                }


                                        if(array_key_exists($lesson->id,$arr_result1)){

                   unset($arr_result1[$lesson->id]);
                   $student_mark->result1=json_encode($arr_result1);

                }

                                        if(array_key_exists($lesson->id,$arr_result2)){

                   unset($arr_result2[$lesson->id]);
                   $student_mark->result2=json_encode($arr_result2);

                }

                                        if(array_key_exists($lesson->id,$arr_result)){

                   unset($arr_result[$lesson->id]);
                   $student_mark->result=json_encode($arr_result);

                }


                                $student_mark->save();

             $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                        $result_term1=0;
                                            $result_term2=0;

            $count1=0;
                    $count2=0;

            foreach( json_decode($student_mark->result1,true) as $key1=>$value1){

                $result_term1=$result_term1+$value1['term1_result'];
                $count1++;

            }
                    foreach( json_decode($student_mark->result2,true) as $key1=>$value1){

                $result_term2=$result_term2+$value1['term2_result'];
                $count2++;

            }

            $objec_term_result=json_decode($student_mark->term_result,true);
            $objec_term_result['term1'] = $result_term1!=0 ?$result_term1/$count1 : "0" ;
            $objec_term_result['term2'] = $result_term2!=0 ?$result_term2/$count2 : "0" ;

                $student_mark->term_result=json_encode($objec_term_result);
                                $student_mark->save();
             $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();


            $year_result=(json_decode($student_mark->term_result,true)['term1']
                    +json_decode($student_mark->term_result,true)['term2'])/2;

    $student_mark->year_result= $year_result;
    $student_mark->save();




}


        }



// ---------------------------------








if ($student->religion==0) {
    $lessons=Lesson::where('class_id',$request->class_id)->where('religion','1')->get();

}elseif($student->religion==1){
    $lessons=Lesson::where('class_id',$request->class_id)->where('religion','0')->get();

}



foreach($lessons as $lesson){

    if ($lesson->religion!=null) {
         $student_mark=Students_mark::where('student_id',$student->id)->where('religion',$student->religion)->where('year_id',$year->id)->first();



             $arr1= json_decode($student_mark->mark,true) ;

              $arr2= json_decode($student_mark->mark2,true) ;

             $arr_result1= json_decode($student_mark->result1,true) ;
             $arr_result2= json_decode($student_mark->result2,true) ;
             $arr_result= json_decode($student_mark->result,true) ;
                if(array_key_exists($lesson->id,$arr1)=='1'){

                   unset($arr1[$lesson->id]);

                   $student_mark->mark=json_encode($arr1);

    }


                            if(array_key_exists($lesson->id,$arr2)){

                   unset($arr2[$lesson->id]);
                   $student_mark->mark2=json_encode($arr2);

                }


                                        if(array_key_exists($lesson->id,$arr_result1)){

                   unset($arr_result1[$lesson->id]);
                   $student_mark->result1=json_encode($arr_result1);

                }

                                        if(array_key_exists($lesson->id,$arr_result2)){

                   unset($arr_result2[$lesson->id]);
                   $student_mark->result2=json_encode($arr_result2);

                }

                                        if(array_key_exists($lesson->id,$arr_result)){

                   unset($arr_result[$lesson->id]);
                   $student_mark->result=json_encode($arr_result);

                }


                                $student_mark->save();

             $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                        $result_term1=0;
                                            $result_term2=0;

            $count1=0;
                    $count2=0;

            foreach( json_decode($student_mark->result1,true) as $key1=>$value1){

                $result_term1=$result_term1+$value1['term1_result'];
                $count1++;

            }
                    foreach( json_decode($student_mark->result2,true) as $key1=>$value1){

                $result_term2=$result_term2+$value1['term2_result'];
                $count2++;

            }

            $objec_term_result=json_decode($student_mark->term_result,true);
            $objec_term_result['term1'] = $result_term1!=0 ?$result_term1/$count1 : "0" ;
            $objec_term_result['term2'] = $result_term2!=0 ?$result_term2/$count2 : "0" ;

                $student_mark->term_result=json_encode($objec_term_result);
                                $student_mark->save();
             $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();


            $year_result=(json_decode($student_mark->term_result,true)['term1']
                    +json_decode($student_mark->term_result,true)['term2'])/2;

    $student_mark->year_result= $year_result;
    $student_mark->save();




}


        }





return redirect()->back()->with('success',' ! تمت العملية بنجاح ');

}




public function student_detail_prev($student_id){



$student=Room_student::where('student_id',$student_id)->latest()->limit(1)->first();
$year=Year::find($student->year_id);
$room=Room::with('classes')->find($student->room_id);
$class= $room->classes->name;

$a=['year_name'=>$year->name,
    'room_name'=>$room->name,
    'class_name'=>$class,
];
return $a;

}

public function student_details($student_id){

    $year=Year::where('current_year','1')->first();
    $student=Student::with(['room'=>fn($q1)=>$q1->where('room_student.year_id',$year->id)])->find($student_id);
        $room=$student->room;

if($room->isEmpty()){
    return redirect()->back();
}

$student_mark=Students_mark::where('student_id',$student_id)->where('year_id',$year->id)->first();

     $lessons=  $room[0]->classes->lessons;
    $classes=Classe::all();
    $class_id= $student->room[0]->classes->id;
    $rooms=Room::where('class_id',$class_id)->where('year_id',$year->id)->get();
    $student_detail = Student_detail::where('student_id', $student->id)->first();
    $student_details_departments = Student_details_department::with(['student_details_department_field.student_details_field_value' => function ($q1) use ($student_id) {
        $q1->where('student_id', $student_id);
    }])->get();
    $country_currency = Country_currency::where('active',1)->get();

    // $rooms=
     return view('admin.student_details',compact('student_details_departments','country_currency','student','student_mark','lessons','classes','rooms','student_detail'));

}




public function student_update(Request $request , $student_id){


    $user=User::where('student_id',$student_id)->first();

    $year=Year::where('current_year','1')->first();
    $request->validate([
        'first_name'=>'required',
        'last_name'=>'required',
        'father_name'=>'required',
        'email' => 'required|unique:users,email,'.$user->id.',id',
        'phone'=>'required',

    ]);

    $student=Student::find($student_id);
    $student_religion=$student->religion;

    $student->first_name=$request->first_name;
    $student->last_name=$request->last_name;
    $student->father_name=$request->father_name;
    $student->mother_name=$request->mother_name;
    $student->email=$request->email;
    $student->date_birth=$request->date_birth;
    $student->age=$request->age;
    $student->nationality=$request->nationality;
    $student->place_birth=$request->place_birth;
    $student->box_birth=$request->box_birth;
    $student->army_room=$request->army_room;
    $student->phone=$request->phone;
    $student->religion=$request->religion;



       if ( $student_religion!=$request->religion) {





    if ($student_religion=='0') {
        $lessons=Lesson::where('class_id',$request->class_id)->where('religion','0')->get();

    }elseif($student_religion=='1'){
        $lessons=Lesson::where('class_id',$request->class_id)->where('religion','1')->get();

    }

    foreach($lessons as $lesson){

        if ($lesson->religion!=null) {


            $student_mark=Students_mark::where('student_id',$student->id)->where('religion',$student_religion)->where('year_id',$year->id)->first();

      if (isset($student_mark) && $student_mark!="") {




                 $arr1= json_decode($student_mark->mark,true) ;
                  $arr2= json_decode($student_mark->mark2,true) ;
                 $arr_result1= json_decode($student_mark->result1,true) ;
                 $arr_result2= json_decode($student_mark->result2,true) ;
                 $arr_result= json_decode($student_mark->result,true) ;

                    if(array_key_exists($lesson->id,$arr1)=='1'){

                        unset($arr1[$lesson->id]);

                       $student_mark->mark=json_encode($arr1);

        }

                                if(array_key_exists($lesson->id,$arr2)){

                       unset($arr2[$lesson->id]);
                       $student_mark->mark2=json_encode($arr2);

                    }


                                            if(array_key_exists($lesson->id,$arr_result1)){

                       unset($arr_result1[$lesson->id]);
                       $student_mark->result1=json_encode($arr_result1);

                    }

                                            if(array_key_exists($lesson->id,$arr_result2)){

                       unset($arr_result2[$lesson->id]);
                       $student_mark->result2=json_encode($arr_result2);

                    }

                                            if(array_key_exists($lesson->id,$arr_result)){

                       unset($arr_result[$lesson->id]);
                       $student_mark->result=json_encode($arr_result);

                    }


                                    $student_mark->save();

                 $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                            $result_term1=0;
                                                $result_term2=0;

                $count1=0;
                        $count2=0;

                foreach( json_decode($student_mark->result1,true) as $key1=>$value1){

                    $result_term1=$result_term1+$value1['term1_result'];
                    $count1++;

                }
                        foreach( json_decode($student_mark->result2,true) as $key1=>$value1){

                    $result_term2=$result_term2+$value1['term2_result'];
                    $count2++;

                }

                $objec_term_result=json_decode($student_mark->term_result,true);
                $objec_term_result['term1'] = $result_term1!=0 ?$result_term1/$count1 : "0" ;
                $objec_term_result['term2'] = $result_term2!=0 ?$result_term2/$count2 : "0" ;

                    $student_mark->term_result=json_encode($objec_term_result);
                                    $student_mark->save();
                 $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();


                $year_result=(json_decode($student_mark->term_result,true)['term1']
                        +json_decode($student_mark->term_result,true)['term2'])/2;

        $student_mark->year_result= $year_result;
        $student_mark->save();




    }
}

            }

        }

            if ($student_religion!=$request->religion) {


                if ($request->religion =='0') {
                    $lessons=Lesson::where('class_id',$request->class_id)->where('religion','0')->get();

                }elseif($request->religion=='1'){
                    $lessons=Lesson::where('class_id',$request->class_id)->where('religion','1')->get();

                }



                foreach ($lessons as $lesson) {

                    $item=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                    $a1=json_decode($item->mark,true);

                    $a1[$lesson->id]=[
                    'oral'=>null,
                    'homework'=>null,
                    'activities'=>null,
                    'quize'=>null,
                    'exam'=>null,
                    ];

                    $item->mark=json_encode($a1);

                      $a2=json_decode($item->mark2,true);
                        $a2[$lesson->id]=[
                    'oral'=>null,
                    'homework'=>null,
                    'activities'=>null,
                    'quize'=>null,
                    'exam'=>null,
                    ];

                        $item->mark2=json_encode($a2);


                      $a3=json_decode($item->result1,true);
                        $a3[$lesson->id]=[
                    'term1_quizes'=>null,
                    'term1_exam'=>null,
                    'term1_result'=>null,
                    ];

                        $item->result1=json_encode($a3);


                              $a4=json_decode($item->result2,true);
                        $a4[$lesson->id]=[
                    'term2_quizes'=>null,
                    'term2_exam'=>null,
                    'term2_result'=>null,
                    ];

                        $item->result2=json_encode($a4);

                          $a5=json_decode($item->result,true);
                        $a5[$lesson->id]=[
                    'year_result'=>null,

                    ];

                        $item->result=json_encode($a5);

                    $item->save();




                }







            }


            $student_mark_new=Students_mark::where('student_id',$request->student_id)->where('year_id',$year->id)->first();

            $student_mark_new->religion=$request->religion;

         $student_mark_new->save();







         $student->religion=$request->religion;


    if($request->has('del_img1')){
Storage::disk('public')->delete($student->family_book_image);
$student->family_book_image=null;
}

if($request->has('del_img2')){
Storage::disk('public')->delete($student->health_certificate_image);
$student->health_certificate_image=null;
}


if($request->has('del_img3')){
Storage::disk('public')->delete($student->school_seq_image1);
$student->school_seq_image1=null;
}


if($request->has('del_img4')){
Storage::disk('public')->delete($student->school_seq_image2);
$student->school_seq_image2=null;
}

if($request->has('del_img5')){
Storage::disk('public')->delete($student->last_certificate_image);
$student->last_certificate_image=null;
}

if($request->has('del_img6')){
Storage::disk('public')->delete($student->image);
$student->image=null;
}









            $year=Year::where('current_year','1')->first();


    $room_student=Room_student::where('student_id',$student->id)->where('year_id',$year->id)->first();
    $room_student->room_id=$request->room_id;
    $room_student->save();


    $user=User::where('student_id',$student_id)->first();

    $user->email = $request->email;

    if ($request->hasFile('family_book_image')) {

        Storage::disk('public')->delete($student->family_book_image);

        $student->family_book_image = $request->family_book_image->store('studentsimage','public');
    }

    if ($request->hasFile('health_certificate_image')) {

        Storage::disk('public')->delete($student->health_certificate_image);

        $student->health_certificate_image = $request->health_certificate_image->store('studentsimage','public');
    }


    if ($request->hasFile('school_seq_image1')) {

        Storage::disk('public')->delete($student->school_seq_image1);

        $student->school_seq_image1 = $request->school_seq_image1->store('studentsimage','public');
    }

    if ($request->hasFile('school_seq_image2')) {

        Storage::disk('public')->delete($student->school_seq_image2);

        $student->school_seq_image2 = $request->school_seq_image2->store('studentsimage','public');
    }


    if ($request->hasFile('last_certificate_image')) {

        Storage::disk('public')->delete($student->last_certificate_image);

        $student->last_certificate_image = $request->last_certificate_image->store('studentsimage','public');
    }

    if ($request->hasFile('image')) {

        Storage::disk('public')->delete($student->image);

        $student->image = $request->image->store('studentsimage','public');
    }



$student->save();
$user=User::where('student_id',$student->id)->first();
$user->email=$request->email;
$user->save();
return redirect()->back()->with('success','! تمت العملية بنجاح');

}



public function reset_student_password(Request $request,$student_id){

    $user=User::where('student_id',$student_id)->first();
            $this->validate($request, [
                'password'              => 'required|min:4',
                'password_confirmation' => 'required|same:password'
            ]);


                $user->password = Hash::make($request->password);
                $user->view_password = $request->password;

                $user->save();



            return redirect()->back()->with('success','! تمت العملية بنجاح');


}




public function student_filter(Request $request){
    $students=Student::where('first_name', "like", "%" . $request->student_now . "%")->
    orwhere('last_name', "like", "%" . $request->student_now . "%")->
    orwhere('phone', "like", "%" . $request->student_now . "%")->with('room.classes')

->get();

    return $students;
}

public function student_room_filter(Request $request){

//   return $request->room_id;
  $room=Room::find($request->room_id);
  $student=$room->student()->with('room.classes')->get();



    return $student;
}


    public function teachers(){

        $teachers=Teacher::orderBy('first_name')->paginate(20);
        $count=Teacher::count();
        $classes=Classe::all();
        return view('admin.teachers',compact('teachers','count','classes'));
    }




    public function teacher_details($teacher_id){

        $year=Year::where('current_year','1')->first();

        $teacher=Teacher::find($teacher_id);

         return view('admin.teacher_details',compact('teacher'));

    }




public function teacher_update(Request $request , $teacher_id){

    $user=User::where('teacher_id',$teacher_id)->first();
    $request->validate([
        'first_name'=>'required',
        'last_name'=>'required',
        'email' => 'required|unique:users,email,'.$user->id.',id',
                'phone'=>'required',


    ]);

    $teacher=Teacher::find($teacher_id);
    $teacher->first_name=$request->first_name;
    $teacher->last_name=$request->last_name;
    $teacher->email=$request->email;
    $teacher->date_birth=$request->date_birth;
    $teacher->phone=$request->phone;
    $teacher->address=$request->address;

    $user=User::where('teacher_id',$teacher_id)->first();
    $user->email=$request->email;

    if ($request->hasFile('image')) {

        Storage::disk('public')->delete($teacher->image);

        $teacher->image = $request->image->store('teachersimage','public');
    }


$user=User::where('teacher_id',$teacher_id)->first();
$user->email=$request->email;
$user->save();

$teacher->save();

return redirect()->back()->with('success','! تمت العملية بنجاح');

}



public function reset_teacher_password(Request $request,$teacher_id){

    $user=User::where('teacher_id',$teacher_id)->first();
            $this->validate($request, [
                'password'              => 'required|min:4',
                'password_confirmation' => 'required|same:password'
            ]);


                $user->password = Hash::make($request->password);
                $user->view_password = $request->password;

                $user->save();



            return redirect()->back()->with('success','! تمت العملية بنجاح');


}




    public function teacher_store(Request $request){
         $year= Year::where('current_year','1')->first();

        $request->validate([
            'first_name'=>'required|max:30',
            'last_name'=>'required|max:30',
            'phone'=>'required|max:20',
            'email'=>'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password|min:8',
        ]);

       $teacher= Teacher::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'date_birth'=>$request->date_birth,
        ]);


if($request->hasFile('image')){

    $teacher->image = $request->image->store('teachersimage','public');
}

        $user=User::create([
            'name'=>$request->first_name,
            'email'=>$request->email,
            'mobile'=>$request->phone,
            'password'=>Hash::make($request->password),
            'view_password'=>$request->password,
            'type'=>'1',
            'teacher_id'=>$teacher->id,

        ]);



        // foreach ($request->room_id as $key => $value) {

        //     foreach ($value as $item) {
        //         $teacher_room_lesson=new  Teacher_room_lesson;

        //         $teacher_room_lesson->teacher_id=$teacher->id;
        //         $teacher_room_lesson->class_id=Room::find($item)->classes->id;
        //         $teacher_room_lesson->year_id=$year->id;
        //         $teacher_room_lesson->room_id=$item;
        //         $teacher_room_lesson->lesson_id=$key;
        //         $teacher_room_lesson->save();

        //     }

        // }





        $teacher->save();
        return redirect()->back();


 }



 public function set_task($teacher_id) {

     $teacher=Teacher::find($teacher_id);
     $classes=Classe::all();
    return view('admin.set_task',compact('teacher','classes'));
 }

public function store_set_task(Request $request){

    $year = Year:: where('current_year','1')->first();


Teacher_room_lesson::where('teacher_id',$request->teacher_id)->where('year_id',$year->id)->delete();
$teacher = Teacher :: find($request->teacher_id);


foreach ($request->room_id as $key => $value) {

    foreach ($value as $item) {
        if ($item == 0) {
            $class_id=Lesson::where('id',$key)->first()->classes->id;
            $rooms=Classe::find($class_id)->room()->where('rooms.year_id',$year->id)->get();
            foreach ($rooms as $room) {
                $teacher_room_lesson=new  Teacher_room_lesson;

                $teacher_room_lesson->teacher_id=$teacher->id;
                $teacher_room_lesson->class_id=$class_id;
                $teacher_room_lesson->year_id=$year->id;
                $teacher_room_lesson->room_id=$room->id;
                $teacher_room_lesson->lesson_id=$key;
                $teacher_room_lesson->save();

            }


break;


        }
        else {

            $teacher_room_lesson=new  Teacher_room_lesson;

            $teacher_room_lesson->teacher_id=$teacher->id;
            $teacher_room_lesson->class_id=Room::find($item)->classes->id;
            $teacher_room_lesson->year_id=$year->id;
            $teacher_room_lesson->room_id=$item;
            $teacher_room_lesson->lesson_id=$key;
            $teacher_room_lesson->save();

        }

    }

}

return redirect()->back()->with('success','! تمت العملية بنجاح');
}

public function edit_task($teacher_id) {
    $year=Year::where('current_year','1')->first();
    $lessons=Teacher::with(['lessons.rooms'=>fn($q)=>$q->where('teacher_room_lesson.teacher_id',$teacher_id)])->find($teacher_id)->lessons->unique();


$lessons_check=Teacher::with(['lessons'=>fn($q)=>$q->where('teacher_room_lesson.year_id',$year->id)])->find($teacher_id)->lessons->unique();
if ($lessons_check->isEmpty()) {
return redirect()->back()->with('warning','لا يوجد مهمات حتى الان قم بتحديد المهمات اولا قبل التعديل');
}
    $teacher = Teacher::find($teacher_id);
    $classes = Classe ::all();

    return view('admin.edit_task',compact('classes','year','lessons','teacher'));
}


public function update_set_task(Request $request){
    $year = Year:: where('current_year','1')->first();


    if($request->has('class_id')!='1') {



        return redirect(route('admin.teacher.set_task',$request->teacher_id));
    }


Teacher_room_lesson::where('teacher_id',$request->teacher_id)->where('year_id',$year->id)->delete();
$teacher = Teacher::find($request->teacher_id);

foreach ($request->room_id as $key => $value) {

    foreach ($value as $item) {
        if ($item == 0) {
            $class_id=Lesson::where('id',$key)->first()->classes->id;
            $rooms=Classe::find($class_id)->room()->where('rooms.year_id',$year->id)->get();

            foreach ($rooms as $room) {
                $teacher_room_lesson=new  Teacher_room_lesson;

                $teacher_room_lesson->teacher_id=$teacher->id;
                $teacher_room_lesson->class_id=$class_id;
                $teacher_room_lesson->year_id=$year->id;
                $teacher_room_lesson->room_id=$room->id;
                $teacher_room_lesson->lesson_id=$key;
                $teacher_room_lesson->save();

            }


break;


        }
        else {

            $teacher_room_lesson=new  Teacher_room_lesson;

            $teacher_room_lesson->teacher_id=$teacher->id;
            $teacher_room_lesson->class_id=Room::find($item)->classes->id;
            $teacher_room_lesson->year_id=$year->id;
            $teacher_room_lesson->room_id=$item;
            $teacher_room_lesson->lesson_id=$key;
            $teacher_room_lesson->save();

        }

    }

}

return redirect()->back()->with('success','! تمت العملية بنجاح');
}




 public function teacher_filter(Request $request){
    $teachers=Teacher::where('first_name', "like", "%" . $request->teacher_now . "%")->
    orwhere('last_name', "like", "%" . $request->teacher_now . "%")->
    orwhere('phone', "like", "%" . $request->teacher_now . "%")

->get();

    return $teachers;
}


public function terms(){

    $terms=Term_year::paginate();
    $count=Term_year::count();
    $years=Year::all();
    return view('admin.terms',compact('terms','count','years'));
}



public function term_store(Request $request){
$request->validate([

    'term_name'=>'required|max:20',
    'year_id'=>'required|numeric',
]);

    Term_year::create([
        'term'=>$request->term_name,
        'year_id'=>$request->year_id
    ]);
    return redirect()->back()->with('success','! تمت العملية بنجاح');
}


public function term_update(Request $request) {

 $term = Term_year::find($request->term_id);


 $term->term = $request->term_name;

$term->year_id=$request->year_id;

$term->save();
return redirect()->back()->with('success','! تمت العملية بنجاح');
}

    public function classes(){

        $classes=Classe::with('classCost')->paginate(paginate_num);
        $stages = Stage::all();
        $count=Classe::count();
        $all_classes = Classe::with('stages')->get();
        $countries_currencies = Country_currency::all();
        $class_cost = Class_cost::where('class_id', $all_classes->pluck('id'))
            ->where('country_id', $countries_currencies->pluck('id'));
        $countries = [];
        $stage1 = Basic_stage::all();
        foreach ($countries_currencies as $country_currency) {
            $countries[$country_currency->id] = $country_currency->name_ar;
        }

        return view('admin.classes',compact('stage1','countries','class_cost','countries_currencies','classes','count','stages','all_classes'));
    }


    public function class_store(Request $request){





        $request->validate([
            'class_name'=>'required|max:20',
            'class_name_en'=>'required|max:20',

            'fixed_cost'=>'required',
        ]);
        $class=new Classe;
        $class->name=$request->class_name;
        $class->name_en=$request->class_name_en;

        $class->fixed_cost=$request->fixed_cost;

        if ($request->hasFile('image')) {

            $class->image = $request->image->store('classimages','public');
        }

        $class->save();
        return redirect()->back()->with('success','! تمت العملية بنجاح');
    }

    public function class_update(Request $request) {

        $class_id = $request->class_id;
        $class=Classe::find($class_id);
        $class->name=$request->class_name;
        $class->name_en=$request->class_name_en;

        $class->fixed_cost=$request->fixed_cost;

if($request->has('del_img1')){
Storage::disk('public')->delete($class->image);
$class->image=null;
}
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($class->image);
            $class->image = $request->image->store('classimages','public');
        }

        $class->save();
        return redirect()->back()->with('success','! تمت العملية بنجاح');
    }
    public function teacher_lessons($class_id){

        $lessons=Lesson::where('class_id',$class_id)->get();
        return $lessons;

    }

    public function rooms($class_id){

        $year=Year::where('current_year','1')->first();
        $rooms=Room::where('class_id',$class_id)->where('rooms.year_id',$year->id)->get();
        return $rooms;

    }

    public function room_update(Request $request){

        $room=Room::find($request->room_id);
        $room->name = $request->name;


        $room->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');;

     }


    public function rooms2($class_id,$year_id){

        $rooms=Room::where('class_id',$class_id)->where('year_id',$year_id)->get();
        return $rooms;

    }

    public function lessons(){




        $lessons=Lesson::paginate(paginate_num);;
        $count=Lesson::count();
        $classes=Classe::all();

        return view('admin.lessons',compact('lessons','count','classes'));


    }


    public function lesson_store(Request $request){
// return "wait...";



        $request->validate([
            'name'=>'required|max:30',
            'name_en'=>'required|max:30',

            'class_id'=>'required|numeric',
        ]);

        $lesson=new Lesson;

        if ($request->has('select_lang')) {
$lesson->lang = $request->select_lang;

        }


        if ($request->has('select_religion')) {
            $lesson->religion = $request->select_religion;

                    }

if ($request->has('book1_link')) {
if ($request->book1_link!=null) {

$lesson->book1=$request->book1_link;
$lesson->type_file1='0';

}
elseif($request->has('book1')){
    if($request->hasFile('book1')){
        $lesson->book1=$request->book1->store('filesstudents','public');
        $lesson->type_file1='1';


}

}

}elseif($request->has('book1')){
    if($request->hasFile('book1')){
        $lesson->book1=$request->book1->store('filesstudents','public');
        $lesson->type_file1='1';


}

}






if ($request->has('book2_link')) {
    if ($request->book2_link!=null) {

    $lesson->book2=$request->book2_link;
    $lesson->type_file2='0';


    }
    elseif($request->has('book2')){
        if($request->hasFile('book2')){
            $lesson->book2=$request->book2->store('filesstudents','public');
            $lesson->type_file2='1';


    }

    }

    }
        elseif($request->has('book2')){
        if($request->hasFile('book2')){
            $lesson->book2=$request->book2->store('filesstudents','public');
            $lesson->type_file2='1';


    }

    }



if ($request->has('book3_link')) {
    if ($request->book3_link!=null) {

    $lesson->book3=$request->book3_link;
    $lesson->type_file3='0';


    }
    elseif($request->has('book3')){
        if($request->hasFile('book3')){
            $lesson->book3=$request->book3->store('filesstudents','public');
            $lesson->type_file3='1';


    }

    }

    }
    elseif($request->has('book3')){
        if($request->hasFile('book3')){
            $lesson->book3=$request->book3->store('filesstudents','public');
            $lesson->type_file3='1';


    }

    }


if ($request->has('book4_link')) {
    if ($request->book4_link!=null) {
    $lesson->book4=$request->book4_link;
    $lesson->type_file4='0';


    }
    elseif($request->has('book4')){
        if($request->hasFile('book4')){
            $lesson->book4=$request->book4->store('filesstudents','public');
            $lesson->type_file4='1';


    }

    }

    }
    elseif($request->has('book4')){
        if($request->hasFile('book4')){
            $lesson->book4=$request->book4->store('filesstudents','public');
$lesson->type_file4='1';

    }

    }

$lesson->name=$request->name;
$lesson->name_en=$request->name_en;

$lesson->name_book1_ar=$request->name_book1_ar;
$lesson->name_book1_en=$request->name_book1_en;
$lesson->name_book2_ar=$request->name_book2_ar;
$lesson->name_book2_en=$request->name_book2_en;
$lesson->name_book3_ar=$request->name_book3_ar;
$lesson->name_book3_en=$request->name_book3_en;
$lesson->name_book4_ar=$request->name_book4_ar;
$lesson->name_book4_en=$request->name_book4_en;

$lesson->type=null;
$lesson->class_id=$request->class_id;


$lesson->type_file1=$request->type_file1;
$lesson->type_file2=$request->type_file2;




      if($request->hasFile('image1')){
    $lesson->image1=$request->image1->store('filesstudents','public');

    }

    if($request->hasFile('image2')){
        $lesson->image2=$request->image2->store('filesstudents','public');

}


    if($request->hasFile('image3')){
        $lesson->image3=$request->image3->store('filesstudents','public');

}

    if($request->hasFile('image4')){
        $lesson->image4=$request->image4->store('filesstudents','public');

}


$lesson->save();
$year=Year::where('current_year','1')->first();








if ($request->has('select_religion')) {

    $rooms=Classe::find($request->class_id)->room()->where('rooms.year_id',$year->id)->get('id');
$cont=[];
foreach($rooms as $room) {
  $cont[]=Students_mark::where('room_id',$room->id)->where('religion',$request->select_religion)->get();
}
$students_marks=[];
foreach($cont as $room){
 foreach($room as $item){
     if ($item!="") {


    //  هون كل حقل بالسجل عبارة عن نص
     $students_marks[]=$item;
    //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
    $a1=json_decode($item->mark,true);
    $a1[$lesson->id]=[
    'oral'=>null,
    'homework'=>null,
    'activities'=>null,
    'quize'=>null,
    'exam'=>null,
    ];

    $item->mark=json_encode($a1);

      $a2=json_decode($item->mark2,true);
        $a2[$lesson->id]=[
    'oral'=>null,
    'homework'=>null,
    'activities'=>null,
    'quize'=>null,
    'exam'=>null,
    ];

        $item->mark2=json_encode($a2);


      $a3=json_decode($item->result1,true);
        $a3[$lesson->id]=[
    'term1_quizes'=>null,
    'term1_exam'=>null,
    'term1_result'=>null,
    ];

        $item->result1=json_encode($a3);


              $a4=json_decode($item->result2,true);
        $a4[$lesson->id]=[
    'term2_quizes'=>null,
    'term2_exam'=>null,
    'term2_result'=>null,
    ];

        $item->result2=json_encode($a4);

          $a5=json_decode($item->result,true);
        $a5[$lesson->id]=[
    'year_result'=>null,

    ];

        $item->result=json_encode($a5);

    $item->save();

 }
}
}

}





elseif ($request->has('select_lang')) {

    $rooms=Classe::find($request->class_id)->room()->where('rooms.year_id',$year->id)->get('id');
$cont=[];
foreach($rooms as $room) {
  $cont[]=Students_mark::where('room_id',$room->id)->where('lang',$request->select_lang)->get();
}
// return count($cont);
$students_marks=[];
foreach($cont as $room){
 foreach($room as $item){
     if ($item!="") {


    //  هون كل حقل بالسجل عبارة عن نص
     $students_marks[]=$item;
    //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
    $a1=json_decode($item->mark,true);
    $a1[$lesson->id]=[
    'oral'=>null,
    'homework'=>null,
    'activities'=>null,
    'quize'=>null,
    'exam'=>null,
    ];

    $item->mark=json_encode($a1);

      $a2=json_decode($item->mark2,true);
        $a2[$lesson->id]=[
    'oral'=>null,
    'homework'=>null,
    'activities'=>null,
    'quize'=>null,
    'exam'=>null,
    ];

        $item->mark2=json_encode($a2);


      $a3=json_decode($item->result1,true);
        $a3[$lesson->id]=[
    'term1_quizes'=>null,
    'term1_exam'=>null,
    'term1_result'=>null,
    ];

        $item->result1=json_encode($a3);


              $a4=json_decode($item->result2,true);
        $a4[$lesson->id]=[
    'term2_quizes'=>null,
    'term2_exam'=>null,
    'term2_result'=>null,
    ];

        $item->result2=json_encode($a4);

          $a5=json_decode($item->result,true);
        $a5[$lesson->id]=[
    'year_result'=>null,

    ];

        $item->result=json_encode($a5);

    $item->save();

 }
}
}


}else {


    $rooms=Classe::find($request->class_id)->room()->where('rooms.year_id',$year->id)->get('id');
    $cont=[];
    foreach($rooms as $room) {
      $cont[]=Students_mark::where('room_id',$room->id)->get();
    }
     $students_marks=[];
    foreach($cont as $room){
     foreach($room as $item){
         if ($item!="") {

        //  هون كل حقل بالسجل عبارة عن نص
         $students_marks[]=$item;
        //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
        $a1=json_decode($item->mark,true);
        $a1[$lesson->id]=[
        'oral'=>null,
        'homework'=>null,
        'activities'=>null,
        'quize'=>null,
        'exam'=>null,
        ];

        $item->mark=json_encode($a1);

          $a2=json_decode($item->mark2,true);
            $a2[$lesson->id]=[
        'oral'=>null,
        'homework'=>null,
        'activities'=>null,
        'quize'=>null,
        'exam'=>null,
        ];

            $item->mark2=json_encode($a2);


          $a3=json_decode($item->result1,true);
            $a3[$lesson->id]=[
        'term1_quizes'=>null,
        'term1_exam'=>null,
        'term1_result'=>null,
        ];

            $item->result1=json_encode($a3);


                  $a4=json_decode($item->result2,true);
            $a4[$lesson->id]=[
        'term2_quizes'=>null,
        'term2_exam'=>null,
        'term2_result'=>null,
        ];

            $item->result2=json_encode($a4);

              $a5=json_decode($item->result,true);
            $a5[$lesson->id]=[
        'year_result'=>null,

        ];

            $item->result=json_encode($a5);

        $item->save();

     }
    }
}




}







return redirect()->back()->with('success', 'تمت العملية بنجاح');

    }


   public function lesson_update(Request $request){
        $year=Year::where('current_year','1')->first();
        $lesson=Lesson::find($request->lesson_id);
        $class_lesson=$lesson->class_id;

        $lesson->name = $request->name;
$lesson->name_en = $request->name_en;
$lesson->name_book1_ar=$request->name_book1_ar;
$lesson->name_book1_en=$request->name_book1_en;
$lesson->name_book2_ar=$request->name_book2_ar;
$lesson->name_book2_en=$request->name_book2_en;
$lesson->name_book3_ar=$request->name_book3_ar;
$lesson->name_book3_en=$request->name_book3_en;
$lesson->name_book4_ar=$request->name_book4_ar;
$lesson->name_book4_en=$request->name_book4_en;
$lesson->type = null;
$lesson->class_id = $request->class_id;


if($request->has('del_img1')){
Storage::disk('public')->delete($lesson->image1);
$lesson->image1=null;
}


if($request->has('del_img2')){
Storage::disk('public')->delete($lesson->image2);

$lesson->image2=null;
}



if($request->has('del_img3')){
Storage::disk('public')->delete($lesson->image3);

$lesson->image3=null;
}


if($request->has('del_img4')){
Storage::disk('public')->delete($lesson->image4);

$lesson->image4=null;
}

if($lesson->type_file1!='0'){

 if($request->has('del_book1')){
Storage::disk('public')->delete($lesson->book1);
$lesson->book1=null;
   $lesson->type_file1=null;

}


}


if($lesson->type_file2!='0'){

if($request->has('del_book2')){
Storage::disk('public')->delete($lesson->book2);

$lesson->book2=null;
   $lesson->type_file2=null;

}

}

if($lesson->type_file3!='0'){

if($request->has('del_book3')){
Storage::disk('public')->delete($lesson->book3);

$lesson->book3=null;
   $lesson->type_file3=null;

}

}

if($lesson->type_file4!='0'){

if($request->has('del_book4')){
Storage::disk('public')->delete($lesson->book4);

$lesson->book4=null;
   $lesson->type_file4=null;

}

}
if($request->book1_link!=null){

   $lesson->book1=$request->book1_link;
   $lesson->type_file1='0';
}elseif($request->hasFile('book1')){

    if ($lesson->book1 !=null) {
Storage::disk('public')->delete($lesson->book1);
    }
    $lesson->book1=$request->book1->store('filesstudents','public');
       $lesson->type_file1='1';


}elseif($request->has('del_book1')){
Storage::disk('public')->delete($lesson->book1);
$lesson->book1=null;
   $lesson->type_file1=null;

}else{
       $lesson->book1=null;

}




if($request->hasFile('image1')){

    if ($lesson->image1 !=null) {
        Storage::disk('public')->delete($lesson->image1);
            }
$lesson->image1=$request->image1->store('filesstudents','public');

}

if($request->hasFile('image2')){

    if ($lesson->image2 !=null) {
        Storage::disk('public')->delete($lesson->image2);
            }

$lesson->image2=$request->image2->store('filesstudents','public');

}


if($request->hasFile('image3')){

    if ($lesson->image3 !=null) {
        Storage::disk('public')->delete($lesson->image3);
            }

$lesson->image3=$request->image3->store('filesstudents','public');

}


if($request->hasFile('image4')){

    if ($lesson->image4 !=null) {
        Storage::disk('public')->delete($lesson->image4);
            }

$lesson->image4=$request->image4->store('filesstudents','public');

}



if($request->book2_link!=null){

   $lesson->book2=$request->book2_link;
      $lesson->type_file2='0';

}elseif($request->hasFile('book2')){

    if ($lesson->book2 !=null) {
        Storage::disk('public')->delete($lesson->book2);
            }
$lesson->book2=$request->book2->store('filesstudents','public');
      $lesson->type_file2='1';

}elseif($request->has('del_book2')){
Storage::disk('public')->delete($lesson->book2);
$lesson->book2=null;
   $lesson->type_file2=null;

}else{
       $lesson->book2=null;

}




if($request->book3_link!=null){

   $lesson->book3=$request->book3_link;
      $lesson->type_file3='0';

}elseif($request->hasFile('book3')){

    if ($lesson->book3 !=null) {
        Storage::disk('public')->delete($lesson->book3);
            }
$lesson->book3=$request->book3->store('filesstudents','public');
      $lesson->type_file3='1';

}elseif($request->has('del_book3')){
Storage::disk('public')->delete($lesson->book3);
$lesson->book3=null;
   $lesson->type_file3=null;

}else{
       $lesson->book3=null;

}



if($request->book4_link!=null){

   $lesson->book4=$request->book4_link;
      $lesson->type_file4='0';

}elseif($request->hasFile('book4')){

    if ($lesson->book4 !=null) {
        Storage::disk('public')->delete($lesson->book4);
            }
$lesson->book4=$request->book4->store('filesstudents','public');
      $lesson->type_file4='1';

}elseif($request->has('del_book4')){
Storage::disk('public')->delete($lesson->book4);
$lesson->book4=null;
   $lesson->type_file4=null;

} else{
       $lesson->book4=null;

}




 if ($class_lesson!=$request->class_id) {


    $class=Lesson::find($request->lesson_id)->classes;
 $rooms= $class->room()->where('rooms.year_id',$year->id)->get();
 $ss=[];
$students=[];

foreach($rooms as $room)  {
    $ss[]=$room->student;

}

foreach($ss as $s ){
    foreach($s as $student){

        if ($lesson->lang!=null) {

    $student_mark=Students_mark::where('student_id',$student->id)->where('lang',$lesson->lang)->where('year_id',$year->id)->first();

}
elseif($lesson->lang==null && $lesson->religion==null)
{


    $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

}
if (isset($student_mark) && $student_mark!="") {




       $arr1= json_decode($student_mark->mark,true) ;
          $arr2= json_decode($student_mark->mark2,true) ;
         $arr_result1= json_decode($student_mark->result1,true) ;
         $arr_result2= json_decode($student_mark->result2,true) ;
         $arr_result= json_decode($student_mark->result,true) ;

            if(array_key_exists($lesson->id,$arr1)=='1'){

               unset($arr1[$lesson->id]);

               $student_mark->mark=json_encode($arr1);

}

                        if(array_key_exists($lesson->id,$arr2)){

               unset($arr2[$lesson->id]);
               $student_mark->mark2=json_encode($arr2);

            }


                                    if(array_key_exists($lesson->id,$arr_result1)){

               unset($arr_result1[$lesson->id]);
               $student_mark->result1=json_encode($arr_result1);

            }

                                    if(array_key_exists($lesson->id,$arr_result2)){

               unset($arr_result2[$lesson->id]);
               $student_mark->result2=json_encode($arr_result2);

            }

                                    if(array_key_exists($lesson->id,$arr_result)){

               unset($arr_result[$lesson->id]);
               $student_mark->result=json_encode($arr_result);

            }


                            $student_mark->save();

         $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                    $result_term1=0;
                                        $result_term2=0;

        $count1=0;
                $count2=0;

        foreach( json_decode($student_mark->result1,true) as $key1=>$value1){

            $result_term1=$result_term1+$value1['term1_result'];
            $count1++;

        }
                foreach( json_decode($student_mark->result2,true) as $key1=>$value1){

            $result_term2=$result_term2+$value1['term2_result'];
            $count2++;

        }
        $objec_term_result=json_decode($student_mark->term_result,true);
        $objec_term_result['term1'] = $result_term1!=0 ?$result_term1/$count1 : "0" ;
        $objec_term_result['term2'] = $result_term2!=0 ?$result_term2/$count2 : "0" ;

            $student_mark->term_result=json_encode($objec_term_result);
                            $student_mark->save();

         $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();


        $year_result=(json_decode($student_mark->term_result,true)['term1']
                +json_decode($student_mark->term_result,true)['term2'])/2;

$student_mark->year_result= $year_result;
$student_mark->save();






    }

}
}





// ===================


$ss=[];
$students=[];

foreach($rooms as $room)  {
    $ss[]=$room->student;

}

foreach($ss as $s ){
    foreach($s as $student){

        if ($lesson->religion!=null) {

    $student_mark=Students_mark::where('student_id',$student->id)->where('religion',$lesson->religion)->where('year_id',$year->id)->first();



if ($student_mark!="") {




       $arr1= json_decode($student_mark->mark,true) ;
          $arr2= json_decode($student_mark->mark2,true) ;
         $arr_result1= json_decode($student_mark->result1,true) ;
         $arr_result2= json_decode($student_mark->result2,true) ;
         $arr_result= json_decode($student_mark->result,true) ;

            if(array_key_exists($lesson->id,$arr1)=='1'){

               unset($arr1[$lesson->id]);

               $student_mark->mark=json_encode($arr1);

}

                        if(array_key_exists($lesson->id,$arr2)){

               unset($arr2[$lesson->id]);
               $student_mark->mark2=json_encode($arr2);

            }


                                    if(array_key_exists($lesson->id,$arr_result1)){

               unset($arr_result1[$lesson->id]);
               $student_mark->result1=json_encode($arr_result1);

            }

                                    if(array_key_exists($lesson->id,$arr_result2)){

               unset($arr_result2[$lesson->id]);
               $student_mark->result2=json_encode($arr_result2);

            }

                                    if(array_key_exists($lesson->id,$arr_result)){

               unset($arr_result[$lesson->id]);
               $student_mark->result=json_encode($arr_result);

            }


                            $student_mark->save();

         $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                    $result_term1=0;
                                        $result_term2=0;

        $count1=0;
                $count2=0;

        foreach( json_decode($student_mark->result1,true) as $key1=>$value1){

            $result_term1=$result_term1+$value1['term1_result'];
            $count1++;

        }
                foreach( json_decode($student_mark->result2,true) as $key1=>$value1){

            $result_term2=$result_term2+$value1['term2_result'];
            $count2++;

        }
        $objec_term_result=json_decode($student_mark->term_result,true);
        $objec_term_result['term1'] = $result_term1!=0 ?$result_term1/$count1 : "0" ;
        $objec_term_result['term2'] = $result_term2!=0 ?$result_term2/$count2 : "0" ;

            $student_mark->term_result=json_encode($objec_term_result);
                            $student_mark->save();

         $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();


        $year_result=(json_decode($student_mark->term_result,true)['term1']
                +json_decode($student_mark->term_result,true)['term2'])/2;

$student_mark->year_result= $year_result;
$student_mark->save();





}

    }

}
}







// -------------------------------------------------------













if ($lesson->lang!=null) {

    $rooms=Classe::find($request->class_id)->room()->where('rooms.year_id',$year->id)->get('id');
$cont=[];
foreach($rooms as $room) {
  $cont[]=Students_mark::where('room_id',$room->id)->where('lang',$lesson->lang)->get();
}
// return count($cont);
$students_marks=[];
foreach($cont as $room){
 foreach($room as $item){
     if ($item !="") {
         # code...

    //  هون كل حقل بالسجل عبارة عن نص
     $students_marks[]=$item;
    //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
    $a1=json_decode($item->mark,true);
    $a1[$lesson->id]=[
    'oral'=>null,
    'homework'=>null,
    'activities'=>null,
    'quize'=>null,
    'exam'=>null,
    ];

    $item->mark=json_encode($a1);

      $a2=json_decode($item->mark2,true);
        $a2[$lesson->id]=[
    'oral'=>null,
    'homework'=>null,
    'activities'=>null,
    'quize'=>null,
    'exam'=>null,
    ];

        $item->mark2=json_encode($a2);


      $a3=json_decode($item->result1,true);
        $a3[$lesson->id]=[
    'term1_quizes'=>null,
    'term1_exam'=>null,
    'term1_result'=>null,
    ];

        $item->result1=json_encode($a3);


              $a4=json_decode($item->result2,true);
        $a4[$lesson->id]=[
    'term2_quizes'=>null,
    'term2_exam'=>null,
    'term2_result'=>null,
    ];

        $item->result2=json_encode($a4);

          $a5=json_decode($item->result,true);
        $a5[$lesson->id]=[
    'year_result'=>null,

    ];

        $item->result=json_encode($a5);

    $item->save();
}
 }
}


}
elseif($lesson->lang==null && $lesson->religion==null)
 {



    $rooms=Classe::find($request->class_id)->room()->where('rooms.year_id',$year->id)->get('id');
    $cont=[];
    foreach($rooms as $room) {
      $cont[]=Students_mark::where('room_id',$room->id)->get();
    }
    // return count($cont);
    $students_marks=[];
    foreach($cont as $room){
     foreach($room as $item){
         if ($item!="") {
             # code...

        //  هون كل حقل بالسجل عبارة عن نص
         $students_marks[]=$item;
        //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
        $a1=json_decode($item->mark,true);
        $a1[$lesson->id]=[
        'oral'=>null,
        'homework'=>null,
        'activities'=>null,
        'quize'=>null,
        'exam'=>null,
        ];

        $item->mark=json_encode($a1);

          $a2=json_decode($item->mark2,true);
            $a2[$lesson->id]=[
        'oral'=>null,
        'homework'=>null,
        'activities'=>null,
        'quize'=>null,
        'exam'=>null,
        ];

            $item->mark2=json_encode($a2);


          $a3=json_decode($item->result1,true);
            $a3[$lesson->id]=[
        'term1_quizes'=>null,
        'term1_exam'=>null,
        'term1_result'=>null,
        ];

            $item->result1=json_encode($a3);


                  $a4=json_decode($item->result2,true);
            $a4[$lesson->id]=[
        'term2_quizes'=>null,
        'term2_exam'=>null,
        'term2_result'=>null,
        ];

            $item->result2=json_encode($a4);

              $a5=json_decode($item->result,true);
            $a5[$lesson->id]=[
        'year_result'=>null,

        ];

            $item->result=json_encode($a5);

        $item->save();
    }
     }
    }




}


// =======================




if ($lesson->religion!=null) {

    $rooms=Classe::find($request->class_id)->room()->where('rooms.year_id',$year->id)->get('id');
$cont=[];
foreach($rooms as $room) {
  $cont[]=Students_mark::where('room_id',$room->id)->where('religion',$lesson->religion)->get();
}
// return count($cont);
$students_marks=[];
foreach($cont as $room){
 foreach($room as $item){
     if ($item !="") {
         # code...

    //  هون كل حقل بالسجل عبارة عن نص
     $students_marks[]=$item;
    //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
    $a1=json_decode($item->mark,true);
    $a1[$lesson->id]=[
    'oral'=>null,
    'homework'=>null,
    'activities'=>null,
    'quize'=>null,
    'exam'=>null,
    ];

    $item->mark=json_encode($a1);

      $a2=json_decode($item->mark2,true);
        $a2[$lesson->id]=[
    'oral'=>null,
    'homework'=>null,
    'activities'=>null,
    'quize'=>null,
    'exam'=>null,
    ];

        $item->mark2=json_encode($a2);


      $a3=json_decode($item->result1,true);
        $a3[$lesson->id]=[
    'term1_quizes'=>null,
    'term1_exam'=>null,
    'term1_result'=>null,
    ];

        $item->result1=json_encode($a3);


              $a4=json_decode($item->result2,true);
        $a4[$lesson->id]=[
    'term2_quizes'=>null,
    'term2_exam'=>null,
    'term2_result'=>null,
    ];

        $item->result2=json_encode($a4);

          $a5=json_decode($item->result,true);
        $a5[$lesson->id]=[
    'year_result'=>null,

    ];

        $item->result=json_encode($a5);

    $item->save();
}
 }
}


}




}






$lesson->save();

return redirect()->back()->with('success', '! تمت العملية بنجاح');


    }





public function lesson_delete(Request $request){



        $year=Year::where('current_year','1')->first();
$lesson=Lesson::find($request->id);
 $class=Lesson::find($request->id)->classes;
 $rooms= $class->room()->where('rooms.year_id',$year->id)->get();
 $ss=[];
$students=[];
foreach($rooms as $room)  {
    $ss[]=$room->student;

}
foreach($ss as $s ){
    foreach($s as $student){
if ($lesson->lang!=null) {

    $student_mark=Students_mark::where('student_id',$student->id)->where('lang',$lesson->lang)->where('year_id',$year->id)->first();


}
elseif($lesson->lang==null && $lesson->religion==null)

{
    $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

}

if (isset($student_mark) && $student_mark!="") {


         $arr1= json_decode($student_mark->mark,true) ;
          $arr2= json_decode($student_mark->mark2,true) ;
         $arr_result1= json_decode($student_mark->result1,true) ;
         $arr_result2= json_decode($student_mark->result2,true) ;
         $arr_result= json_decode($student_mark->result,true) ;

            if(array_key_exists($request->id,$arr1)=='1'){

               unset($arr1[$request->id]);

               $student_mark->mark=json_encode($arr1);

}

                        if(array_key_exists($request->id,$arr2)){

               unset($arr2[$request->id]);
               $student_mark->mark2=json_encode($arr2);

            }


                                    if(array_key_exists($request->id,$arr_result1)){

               unset($arr_result1[$request->id]);
               $student_mark->result1=json_encode($arr_result1);

            }

                                    if(array_key_exists($request->id,$arr_result2)){

               unset($arr_result2[$request->id]);
               $student_mark->result2=json_encode($arr_result2);

            }

                                    if(array_key_exists($request->id,$arr_result)){

               unset($arr_result[$request->id]);
               $student_mark->result=json_encode($arr_result);

            }


                            $student_mark->save();

         $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                    $result_term1=0;
                                        $result_term2=0;

        $count1=0;
                $count2=0;

        foreach( json_decode($student_mark->result1,true) as $key1=>$value1){

            $result_term1=$result_term1+$value1['term1_result'];
            $count1++;

        }
                foreach( json_decode($student_mark->result2,true) as $key1=>$value1){

            $result_term2=$result_term2+$value1['term2_result'];
            $count2++;

        }
        $objec_term_result=json_decode($student_mark->term_result,true);
        $objec_term_result['term1'] = $result_term1!=0 ?$result_term1/$count1 : "0" ;
        $objec_term_result['term2'] = $result_term2!=0 ?$result_term2/$count2 : "0" ;

            $student_mark->term_result=json_encode($objec_term_result);
                            $student_mark->save();

         $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();


        $year_result=(json_decode($student_mark->term_result,true)['term1']
                +json_decode($student_mark->term_result,true)['term2'])/2;

$student_mark->year_result= $year_result;
$student_mark->save();





}

    }
}



// ===============



$ss=[];
$students=[];
foreach($rooms as $room)  {
    $ss[]=$room->student;

}
foreach($ss as $s ){
    foreach($s as $student){
if ($lesson->religion!=null) {

    $student_mark=Students_mark::where('student_id',$student->id)->where('religion',$lesson->religion)->where('year_id',$year->id)->first();

if (isset($student_mark) && $student_mark!="") {
    # code...
         $arr1= json_decode($student_mark->mark,true) ;
          $arr2= json_decode($student_mark->mark2,true) ;
         $arr_result1= json_decode($student_mark->result1,true) ;
         $arr_result2= json_decode($student_mark->result2,true) ;
         $arr_result= json_decode($student_mark->result,true) ;

            if(array_key_exists($request->id,$arr1)=='1'){

               unset($arr1[$request->id]);

               $student_mark->mark=json_encode($arr1);

}

                        if(array_key_exists($request->id,$arr2)){

               unset($arr2[$request->id]);
               $student_mark->mark2=json_encode($arr2);

            }


                                    if(array_key_exists($request->id,$arr_result1)){

               unset($arr_result1[$request->id]);
               $student_mark->result1=json_encode($arr_result1);

            }

                                    if(array_key_exists($request->id,$arr_result2)){

               unset($arr_result2[$request->id]);
               $student_mark->result2=json_encode($arr_result2);

            }

                                    if(array_key_exists($request->id,$arr_result)){

               unset($arr_result[$request->id]);
               $student_mark->result=json_encode($arr_result);

            }


                            $student_mark->save();

         $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                    $result_term1=0;
                                        $result_term2=0;

        $count1=0;
                $count2=0;

        foreach( json_decode($student_mark->result1,true) as $key1=>$value1){

            $result_term1=$result_term1+$value1['term1_result'];
            $count1++;

        }
                foreach( json_decode($student_mark->result2,true) as $key1=>$value1){

            $result_term2=$result_term2+$value1['term2_result'];
            $count2++;

        }
        $objec_term_result=json_decode($student_mark->term_result,true);
        $objec_term_result['term1'] = $result_term1!=0 ?$result_term1/$count1 : "0" ;
        $objec_term_result['term2'] = $result_term2!=0 ?$result_term2/$count2 : "0" ;

            $student_mark->term_result=json_encode($objec_term_result);
                            $student_mark->save();

         $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();


        $year_result=(json_decode($student_mark->term_result,true)['term1']
                +json_decode($student_mark->term_result,true)['term2'])/2;

$student_mark->year_result= $year_result;
$student_mark->save();





}

}

    }
}




$lesson_id=$request->id;
$lesson=Lesson::find($lesson_id);
if ($lesson->image1 !=null) {

    Storage::disk('public')->delete($lesson->image1);
}

if ($lesson->image2 !=null) {

    Storage::disk('public')->delete($lesson->image2);
}


if ($lesson->image3 !=null) {

    Storage::disk('public')->delete($lesson->image3);
}


if ($lesson->image4 !=null) {

    Storage::disk('public')->delete($lesson->image4);
}

    if ($lesson->book1 !=null) {
        if($lesson->type_file1!='0'){
            Storage::disk('public')->delete($lesson->book1);

        }
    }

        if ($lesson->book2 !=null) {
                    if($lesson->type_file2!='0'  ){
Storage::disk('public')->delete($lesson->book2);

}
    }

            if ($lesson->book3 !=null) {
                    if($lesson->type_file3!='0'  ){
Storage::disk('public')->delete($lesson->book3);

}
    }


            if ($lesson->book4 !=null) {
                    if($lesson->type_file4!='0'  ){
Storage::disk('public')->delete($lesson->book4);

}
    }

        $student_lesson=Student_lesson_teacher_room_term_exam::where('lesson_id',$lesson_id)->delete();
    $teacher_lesson=Lesson_teacher_room_term_exam::where('lesson_id',$lesson_id)->delete();
    $content_lesson=Teacher_room_lesson::where('lesson_id',$lesson_id)->delete();

$lesson->delete();

return redirect()->back()->with('success','! تمت العملية بنجاح');

}




    public function class_lessons($class_id){

        $lessons=Lesson::with('classes')->where('class_id',$class_id)->get();

        return $lessons;

    }
    public function destroy($id){
        return $id;
        $student=Student::find($id);
        // Storage::disk('public')->delete($element->image);
        $student->delete();
        return redirect(route('admin.students'));
       }

    public function classroom($id){

        $year=Year::where('current_year','1')->first();
        $rooms=Room::where('class_id',$id)->where('year_id',$year->id)->paginate(paginate_num);
        $count=Room::count();
        $id=$id;
        $years=Year::all();
        return view('admin.rooms',compact('rooms','count','id','years'));
    }

    public function room_store(Request $request){

        $year=Year::find($request->year_id);
        Room::create([
            'name'=>$request->room_name,
            'year_id'=>$year->id,
            'class_id'=>$request->class_id
        ]);

        return redirect()->back()->with('succes','! تمت العملية بنجاح');

    }

    public function roomstudent($room_id,$class_id){


        $students=Room_student::where('room_id',$room_id)->get();
        $a=[];
        foreach($students as $student){
            $a[]=$student->student_id;
        }
        $students=Student::whereIn('id',$a)->orderBy('first_name')->paginate(paginate_num);
        // return $students;
        $count= count($students);
        $classes=Classe::all();
        $years=Year::all();
        $room=Room::find($room_id);
        return view('admin.student_room',compact('room','students','count','classes','years'));
    }

    public function roomlessons($class_id,$room_id){


        //الاستاذ يلي بدرس كل مادة بعد ما وصلت للمواد من الشعبة يلي وصلتلها من الصف
        //المواد المتعلقة بكل شعبة بعد ما وصلت للشعب من الصف
        //   $lessons=Room::with(['lessons'])->where('id',$room_id)->get();
        //   $room=Room::find($room_id);
        $lessons=Lesson::where('class_id',$class_id)->paginate(paginate_num);
        //   $lessons=$room->lessons()->paginate(paginate_num);
          $count=count($lessons);
        $room=Room::find($room_id);
                  return view('admin.lesson_room',compact('room','lessons','room_id','count'));
    }

    public function roomteachers($class_id,$room_id){

$room=Room::with(['teachers.lessons'=>fn($q)=>$q->where('teacher_room_lesson.room_id',$room_id)])->find($room_id);
          $room=Room::with(['teachers','lessons'])->where('id',$room_id)->get();
          $room=Room::find($room_id);
        //   $teachers=$room->teachers()->paginate(paginate_num);
                  $teachers=Teacher_room_lesson::where('room_id',$room_id)->paginate(paginate_num);

          $count= count($teachers);

        return view('admin.teachers_room',compact('room','room_id','teachers','count'));
    }

    public function StudentsRoomLesson($room_id,$lesson_id){

        $room=Room::with('student')->find($room_id);
        $year=Year::where('current_year','1')->first();

        $students=Room::with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])->find($room_id);

    //     $students=$students->student()->get();
    //     $students=collect($students);
    //    $students=$students->with('student_mark')->get();
    //    return $students;
        $count= count($students->student);
        $market=Students_mark::where('room_id',$room_id)->get();


        $lesson=Lesson::find($lesson_id);

        if (isset($students) && $lesson->lang=='1') {
            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
                $query->where('lang', '1')->orderBy('first_name');
            })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);

        } elseif (isset($students) && $lesson->lang=='0') {

            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
                $query->where('lang', '0')->orderBy('first_name');
            })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);

        } elseif (isset($students) && $lesson->religion=='1') {
            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
                $query->where('religion', '1')->orderBy('first_name');
            })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                ->with(['student'=>fn($q1)=>$q1->where('religion', '1')->orderBy('first_name')])->find($room_id);

        } elseif (isset($students) && $lesson->religion=='0') {

            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
                $query->where('religion', '0')->orderBy('first_name');
            })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);

        } else {

            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
            })->with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])
                ->with(['student'=>fn($q1)=>$q1->orderBy('first_name')])->find($room_id);
        }

        $count = isset($students) ? count($students->student) : 0;

        return view('admin.students_room_lesson',compact('room','room_id','students','count','lesson_id','lesson'));
  }
  public function student_mark_admin(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $lesson_id = $request->lesson_id;
        $studens = Room::find($request->room_id)->student;
        foreach ($studens as $student) {

            if ($request->term == 'term1') {


                $lesson = Lesson::find($lesson_id);
                $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();
                $object1 = json_decode($student_mark->mark, true);

                $object1[$lesson_id]['oral'] = $request->mark * 0.1;
                $object1[$lesson_id]['homework'] = $request->mark * 0.1;
                $object1[$lesson_id]['activities'] = $request->mark * 0.2;
                $object1[$lesson_id]['quize'] = $request->mark * 0.2;
                $object1[$lesson_id]['exam'] = $request->mark * 0.4;

                if ($student_mark->worke_degree) {
                    $object_worke_degree = json_decode($student_mark->worke_degree, true);
                    foreach (json_decode($student_mark->worke_degree) as $key => $item) {
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




                $object_result1 = json_decode($student_mark->result1, true);
                // $object_result1[$lesson_id]['term1_quizes']=ceil($object1[$lesson_id]['oral']*0.1)+
                // ceil($object1[$lesson_id]['homework']*0.1)+ceil($object1[$lesson_id]['activities']*0.2)+ceil($object1[$lesson_id]['quize']*0.2);
                // $object_result1[$lesson_id]['term1_exam']=ceil($object1[$lesson_id]['exam']*0.4);

                $object_result1[$lesson_id]['term1_quizes'] = ceil($object1[$lesson_id]['oral']) +
                    ceil($object1[$lesson_id]['homework']) + ceil($object1[$lesson_id]['activities']) + ceil($object1[$lesson_id]['quize']);
                $object_result1[$lesson_id]['term1_exam'] = ceil($object1[$lesson_id]['exam']);

                $object_result2 = json_decode($student_mark->result2, true);
                $object_result = json_decode($student_mark->result, true);
                $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);

                if ($student_mark->result) {
                    $object_result = json_decode($student_mark->result, true);
                    $decodedData = json_decode($student_mark->result2);

                    if (!json_decode($student_mark->result2, true)  ||(!property_exists($decodedData,  $lesson_id ) )) {


                        $object_result2[$lesson_id]['term2_result'] = 0;
                    }



                    $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);
                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
                }


                $student_mark->update([
                    'student_id' => $student->id,
                    'room_id' => $request->room_id,
                    'worke_degree' => json_encode($object_worke_degree),
                    'mark' => json_encode($object1),
                    'result1' => json_encode($object_result1),
                    'result' => json_encode($object_result),

                    'status' => '1'

                ]);
                if ($student_mark->estimation1) {
                    $stc = json_decode($student_mark->estimation1, true);
                    if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= "0" && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 40) {

                        $stc[$lesson_id] = "ضعيف";
                        $student_mark->estimation1 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 70) {
                        $stc[$lesson_id] = "وسط";
                        $student_mark->estimation1 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 80) {
                        $stc[$lesson_id] = "جيد";
                        $student_mark->estimation1 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 90) {
                        $stc[$lesson_id] = "جيد جداًً";
                        $student_mark->estimation1 = json_encode($stc);

                        $student_mark->save();
                    } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 100) {

                        $stc[$lesson_id] = "ممتاز";
                        $student_mark->estimation1 = json_encode($stc);
                        $student_mark->save();
                    }
                } else {
                    $stc = new stdClass;
                    if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= "0" && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 40) {

                        $stc->{$lesson_id} = "ضعيف";
                        $student_mark->estimation1 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 70) {
                        $stc->{$lesson_id} = "وسط";
                        $student_mark->estimation1 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 80) {
                        $stc->{$lesson_id} = "جيد";
                        $student_mark->estimation1 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 90) {
                        $stc->{$lesson_id} = "جيد جداًً";
                        $student_mark->estimation1 = json_encode($stc);

                        $student_mark->save();
                    } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 100) {

                        $stc->{$lesson_id} = "ممتاز";
                        $student_mark->estimation1 = json_encode($stc);
                        $student_mark->save();
                    }
                }




                $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();

                $result_term1 = 0;
                $count = 0;
                foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {
                    $les= Lesson::find($key1);
                     if($les){
                    if( $les->is_neutral!=3){
                    $result_term1 = $result_term1 + $value1['term1_result'];
                    $count++;
                     }

                     }
                }

                $objec_term_result = json_decode($student_mark->term_result, true);
                  $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 : "0";

                      $year_result = (json_decode($student_mark->term_result, true)['term1']
                    + $objec_term_result['term1'] ) / 2;

                $student_mark->update([
                    'term_result' => json_encode($objec_term_result),
                    'year_result' => $year_result,


                ]);
                if ($student_mark->estimation) {
                    $stc = json_decode($student_mark->estimation, true);
                    if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                        $stc[$lesson_id] = "ضعيف";
                        $student_mark->estimation = json_encode($stc);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                        $stc[$lesson_id] = "وسط";
                        $student_mark->estimation = json_encode($stc);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                        $stc[$lesson_id] = "جيد";
                        $student_mark->estimation = json_encode($stc);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                        $stc[$lesson_id] = "جيد جداًً";
                        $student_mark->estimation = json_encode($stc);

                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                        $stc[$lesson_id] = "ممتاز";
                        $student_mark->estimation = json_encode($stc);
                        $student_mark->save();
                    }
                } else {
                    $stc1 = new stdClass;
                    if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                        $stc1->{$lesson_id} = "ضعيف";
                        $student_mark->estimation = json_encode($stc1);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                        $stc1->{$lesson_id} = "وسط";
                        $student_mark->estimation = json_encode($stc1);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                        $stc1->{$lesson_id} = "جيد";
                        $student_mark->estimation = json_encode($stc1);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                        $stc1->{$lesson_id} = "جيد جداًً";
                        $student_mark->estimation = json_encode($stc1);

                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                        $stc1->{$lesson_id} = "ممتاز";
                        $student_mark->estimation = json_encode($stc1);
                        $student_mark->save();
                    }
                }
            } else {


                $lesson = Lesson::find($lesson_id);

                $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();
                $object2 = json_decode($student_mark->mark2, true);

                $object2[$lesson_id]['oral'] = $request->mark * 0.1;
                $object2[$lesson_id]['homework'] = $request->mark * 0.1;
                $object2[$lesson_id]['activities'] = $request->mark * 0.2;
                $object2[$lesson_id]['quize'] = $request->mark * 0.2;
                $object2[$lesson_id]['exam'] = $request->mark * 0.4;
                if($student_mark->worke_degree ){
                    $object_worke_degree2=json_decode($student_mark->worke_degree,true);
                   foreach(json_decode($student_mark->worke_degree) as $key=>$item){
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
                $object_worke_degree2[$lesson_id]['term1_result']="null";
                   $object_worke_degree2[$lesson_id]['term2_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];
               }


                $object_worke_degree2[$lesson_id]['term2_result'] = $object2[$lesson_id]['oral'] + $object2[$lesson_id]['activities'] + $object2[$lesson_id]['homework'] + $object2[$lesson_id]['quize'];

                $object_result2 = json_decode($student_mark->result2, true);
                $object_result2[$lesson_id]['term2_quizes'] = ceil($object2[$lesson_id]['oral']) +
                    ceil($object2[$lesson_id]['homework']) + ceil($object2[$lesson_id]['activities']) + ceil($object2[$lesson_id]['quize']);
                $object_result2[$lesson_id]['term2_exam'] = ceil($object2[$lesson_id]['exam']);
                $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
                $object_result1 = json_decode($student_mark->result1, true);
                $object_result = json_decode($student_mark->result, true);

                if ($student_mark->result) {
                    $object_result = json_decode($student_mark->result, true);
                    $decodedData = json_decode($student_mark->result1);

                    if (!json_decode($student_mark->result1, true) ||  (!property_exists($decodedData,  $lesson_id ))) {
                        $object_result1[$lesson_id]['term1_result'] = 0;
                    }




                    $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
                }

                $student_mark->update([
                    'student_id' => $student->id,
                    'room_id' => $request->room_id,
                    'mark2' => json_encode($object2),
                    'result2' => json_encode($object_result2),
                    'result' => json_encode($object_result),
                    'worke_degree' => json_encode($object_worke_degree2),
                    'notes' => $request->notes,
                    'status' => '1'

                ]);
                if ($student_mark->estimation2) {
                    $stc = json_decode($student_mark->estimation2, true);
                    if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 40) {

                        $stc[$lesson_id] = "ضعيف";
                        $student_mark->estimation2 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 70) {
                        $stc[$lesson_id] = "وسط";
                        $student_mark->estimation2 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 80) {
                        $stc[$lesson_id] = "جيد";
                        $student_mark->estimation2 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 90) {
                        $stc[$lesson_id] = "جيد جداًً";
                        $student_mark->estimation2 = json_encode($stc);

                        $student_mark->save();
                    } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 100) {

                        $stc[$lesson_id] = "ممتاز";
                        $student_mark->estimation2 = json_encode($stc);
                        $student_mark->save();
                    }
                } else {
                    $stc = new stdClass;
                    if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 40) {

                        $stc->{$lesson_id} = "ضعيف";
                        $student_mark->estimation2 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 70) {
                        $stc->{$lesson_id} = "وسط";
                        $student_mark->estimation2 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 80) {
                        $stc->{$lesson_id} = "جيد";
                        $student_mark->estimation2 = json_encode($stc);
                        $student_mark->save();
                    } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 90) {
                        $stc->{$lesson_id} = "جيد جداًً";
                        $student_mark->estimation2 = json_encode($stc);

                        $student_mark->save();
                    } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 100) {

                        $stc->{$lesson_id} = "ممتاز";
                        $student_mark->estimation2 = json_encode($stc);
                        $student_mark->save();
                    }
                }
                $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();

                $result_term2 = 0;
                $count = 0;
                foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {
                    $les= Lesson::find($key1);
                     if($les){
                    if( $les->is_neutral !=3){
                     $result_term2 = $result_term2 + $value1['term2_result'];
                     $count++;
                    }
                     }

                 }

                 $objec_term_result = json_decode($student_mark->term_result, true);
                   $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2  : "0";
                      $year_result = (json_decode($student_mark->term_result, true)['term1']
                     +  $objec_term_result['term2']) / 2;

                 $student_mark->update([

                     'term_result' => json_encode($objec_term_result),
                     'year_result' => $year_result,

                 ]);

                // return response()->json([
                //     'success'=>'! تمت العملية بنجاح'
                // ]);
                if ($student_mark->estimation) {
                    $stc = json_decode($student_mark->estimation, true);
                    if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                        $stc[$lesson_id] = "ضعيف";
                        $student_mark->estimation = json_encode($stc);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                        $stc[$lesson_id] = "وسط";
                        $student_mark->estimation = json_encode($stc);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                        $stc[$lesson_id] = "جيد";
                        $student_mark->estimation = json_encode($stc);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                        $stc[$lesson_id] = "جيد جداًً";
                        $student_mark->estimation = json_encode($stc);

                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                        $stc[$lesson_id] = "ممتاز";
                        $student_mark->estimation = json_encode($stc);
                        $student_mark->save();
                    }
                } else {
                    $stc1 = new stdClass;
                    if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                        $stc1->{$lesson_id} = "ضعيف";
                        $student_mark->estimation = json_encode($stc1);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                        $stc1->{$lesson_id} = "وسط";
                        $student_mark->estimation = json_encode($stc1);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                        $stc1->{$lesson_id} = "جيد";
                        $student_mark->estimation = json_encode($stc1);
                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                        $stc1->{$lesson_id} = "جيد جداًً";
                        $student_mark->estimation = json_encode($stc1);

                        $student_mark->save();
                    } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                        $stc1->{$lesson_id} = "ممتاز";
                        $student_mark->estimation = json_encode($stc1);
                        $student_mark->save();
                    }
                }
            }
        }

        return redirect()->back();
    }
    public function student_mark(Request $request)
    {
        $year = Year::where('current_year', '1')->first();

        $lesson_id = $request->lesson_id;
        $student_id = $request->student_id;
        $room_id=$request->room_id;
        $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();
          $report_card=Report_card::where('student_id',$request->student_id)->where('year_id',$year->id)->first();


        if ($request->term == 'term1') {
            if (isset($report_card) && $report_card->adjustable != 0){
                session()->flash('error22',' لا يمكن التعديل بعد استصدار الجلاء  ' ) ;
            return redirect()->back()->with('error','  لا يمكن تعديل العلامات بعد استصدار الجلاء !  ') ;
        }
        if (auth()->user()->type == 1 && $student_mark->adjustable != 0){
                session()->flash('error22',' لا يمكن التعديل تم تثبيت العلامات من قبل الإدارة  ' ) ;
            return redirect()->back()->with('error','   لا يمكن التعديل   تم تثبيت العلامات من قبل الإدارة    !  ') ;
        }

            $lesson = Lesson::find($lesson_id);
            $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();
            $object1 = json_decode($student_mark->mark, true);

            $object1[$lesson_id]['oral'] = $request->oral;
            $object1[$lesson_id]['homework'] = $request->homework;
            $object1[$lesson_id]['activities'] = $request->activities;
            $object1[$lesson_id]['quize'] = $request->quize;
            $object1[$lesson_id]['exam'] = $request->exam;

            if ($student_mark->worke_degree) {
                $object_worke_degree = json_decode($student_mark->worke_degree, true);
                foreach (json_decode($student_mark->worke_degree) as $key => $item) {
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

            $object_result1 = json_decode($student_mark->result1, true);
            // $object_result1[$lesson_id]['term1_result']=ceil($object_result1[$lesson_id]['term1_exam']+ $object_result1[$lesson_id]['term1_quizes']);
            // $object_result1[$lesson_id]['term1_quizes']=ceil($object1[$lesson_id]['oral']*0.1)+
            // ceil($object1[$lesson_id]['homework']*0.1)+ceil($object1[$lesson_id]['activities']*0.2)+ceil($object1[$lesson_id]['quize']*0.2);
            // $object_result1[$lesson_id]['term1_exam']=ceil($object1[$lesson_id]['exam']*0.4);

            $object_result1[$lesson_id]['term1_quizes'] = ceil($object1[$lesson_id]['oral']) +
                ceil($object1[$lesson_id]['homework']) + ceil($object1[$lesson_id]['activities']) + ceil($object1[$lesson_id]['quize']);
            $object_result1[$lesson_id]['term1_exam'] = ceil($object1[$lesson_id]['exam']);

            $object_result2 = json_decode($student_mark->result2, true);
            if ($student_mark->result) {
                $object_result = json_decode($student_mark->result, true);
                $decodedData = json_decode($student_mark->result2);

                if (!json_decode($student_mark->result2, true)  ||(!property_exists($decodedData,  $lesson_id ) ) ) {


                    $object_result2[$lesson_id]['term2_result'] = 0;
                }



                $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);
                $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
            }







            $student_mark->update([
                'student_id' => $request->student_id,
                'room_id' => $request->room_id,
                'worke_degree' => json_encode($object_worke_degree),
                'mark' => json_encode($object1),
                'result1' => json_encode($object_result1),
                'result' => json_encode($object_result),

                'status' => '1'

            ]);

            if ($student_mark->estimation1) {
                $stc = json_decode($student_mark->estimation1, true);
                if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 0 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $student_mark->estimation1 = json_encode($stc);

                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                }
            } else {
                $stc = new stdClass;
                if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= "0" && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 40) {

                    $stc->{$lesson_id} = "ضعيف";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 70) {
                    $stc->{$lesson_id} = "وسط";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 80) {
                    $stc->{$lesson_id} = "جيد";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 90) {
                    $stc->{$lesson_id} = "جيد جداًً";
                    $student_mark->estimation1 = json_encode($stc);

                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 100) {

                    $stc->{$lesson_id} = "ممتاز";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                }
            }




            $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();

            $result_term1 = 0;
            $count = 0;

            foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {
                $les= Lesson::find($key1);
                 if($les){
                if( $les->is_neutral!=3){
                $result_term1 = $result_term1 + $value1['term1_result'];
                $count++;
                 }}
            }

            $objec_term_result = json_decode($student_mark->term_result, true);
              $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 : "0";

                  $year_result = (json_decode($student_mark->term_result, true)['term1']
                + $objec_term_result['term1'] ) / 2;

            $student_mark->update([
                'term_result' => json_encode($objec_term_result),
                'year_result' => $year_result,


            ]);
            if ($student_mark->estimation) {
                $stc = json_decode($student_mark->estimation, true);
                if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $student_mark->estimation = json_encode($stc);

                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                }
            } else {
                $stc1 = new stdClass;
                if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc1->{$lesson_id} = "ضعيف";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc1->{$lesson_id} = "وسط";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc1->{$lesson_id} = "جيد";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc1->{$lesson_id} = "جيد جداًً";
                    $student_mark->estimation = json_encode($stc1);

                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc1->{$lesson_id} = "ممتاز";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                }
            }

            return redirect()->back();
        } else {

            $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();
            if (isset($report_card) && $report_card->adjustable != 1){
                session()->flash('error22',' لا يمكن التعديل تأكد من حالة الجلاء ' ) ;
                return redirect()->back()->with('error','  لا يمكن التعديل تأكد من حالة الجلاء    !  ') ;
            }
            if (auth()->user()->type == 1 && $student_mark->adjustable != 1){
                        session()->flash('error22',' لا يمكن التعديل تأكد من حالة الجلاء ' ) ;
                return redirect()->back()->with('error','   لا يمكن التعديل   تم تثبيت العلامات من قبل الإدارة    !  ') ;
            }

            $lesson = Lesson::find($lesson_id);


            $object2 = json_decode($student_mark->mark2, true);

            $object2[$lesson_id]['oral'] = $request->oral;
            $object2[$lesson_id]['homework'] = $request->homework;
            $object2[$lesson_id]['activities'] = $request->activities;
            $object2[$lesson_id]['quize'] = $request->quize;
            $object2[$lesson_id]['exam'] = $request->exam;
            if($student_mark->worke_degree ){
                $object_worke_degree2=json_decode($student_mark->worke_degree,true);
               foreach(json_decode($student_mark->worke_degree) as $key=>$item){
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

            //   if($student_mark->worke_degree){
            //     $object_worke_degree2=json_decode($student_mark->worke_degree,true);
            //   }

            //     $object_worke_degree2[$lesson_id]['term2_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];

            $object_result2 = json_decode($student_mark->result2, true);
            $object_result2[$lesson_id]['term2_quizes'] = ceil($object2[$lesson_id]['oral']) +
                ceil($object2[$lesson_id]['homework']) + ceil($object2[$lesson_id]['activities']) + ceil($object2[$lesson_id]['quize']);
            $object_result2[$lesson_id]['term2_exam'] = ceil($object2[$lesson_id]['exam']);
            $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
            $object_result1 = json_decode($student_mark->result1, true);
            $object_result = json_decode($student_mark->result, true);

            if ($student_mark->result) {
                $object_result = json_decode($student_mark->result, true);

                $decodedData = json_decode($student_mark->result1);

                if (!json_decode($student_mark->result1, true) || (!property_exists($decodedData,  $lesson_id ) )) {
                    $object_result1[$lesson_id]['term1_result'] = 0;
                }




                $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
                $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
            }

            if ($student_mark->notes) {
                $notes = json_decode($student_mark->notes, true);
                $notes[$lesson_id] = $request->notes;
            } else {
                $notes = new stdClass;
                $notes->{$lesson_id} = $request->notes;
            }
            $student_mark->update([
                'student_id' => $request->student_id,
                'room_id' => $request->room_id,
                'mark2' => json_encode($object2),
                'result2' => json_encode($object_result2),
                'result' => json_encode($object_result),
                'worke_degree' => json_encode($object_worke_degree2),
                'notes' => json_encode($notes),
                'status' => '1'

            ]);
            if ($student_mark->estimation2) {
                $stc = json_decode($student_mark->estimation2, true);
                if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $student_mark->estimation2 = json_encode($stc);

                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                }
            } else {
                $stc = new stdClass;
                if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 40) {

                    $stc->{$lesson_id} = "ضعيف";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 70) {
                    $stc->{$lesson_id} = "وسط";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 80) {
                    $stc->{$lesson_id} = "جيد";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 90) {
                    $stc->{$lesson_id} = "جيد جداًً";
                    $student_mark->estimation2 = json_encode($stc);

                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 100) {

                    $stc->{$lesson_id} = "ممتاز";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                }
            }
            $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();

            $result_term2 = 0;
            $count = 0;
             json_decode($student_mark->result2, true) ;
            foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {
               $les= Lesson::find($key1);
                if($les){
               if( $les->is_neutral !=3){
                $result_term2 = $result_term2 + $value1['term2_result'];
                $count++;
               }}

            }

            $objec_term_result = json_decode($student_mark->term_result, true);
              $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2  : "0";
                 $year_result = (json_decode($student_mark->term_result, true)['term1']
                +  $objec_term_result['term2']) / 2;

            $student_mark->update([

                'term_result' => json_encode($objec_term_result),
                'year_result' => $year_result,

            ]);

            // return response()->json([
            //     'success'=>'! تمت العملية بنجاح'
            // ]);
            if ($student_mark->estimation) {
                $stc = json_decode($student_mark->estimation, true);
                if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $student_mark->estimation = json_encode($stc);

                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                }
            } else {
                $stc1 = new stdClass;
                if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc1->{$lesson_id} = "ضعيف";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc1->{$lesson_id} = "وسط";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc1->{$lesson_id} = "جيد";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc1->{$lesson_id} = "جيد جداًً";
                    $student_mark->estimation = json_encode($stc1);

                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc1->{$lesson_id} = "ممتاز";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                }
            }

            return redirect()->back();
        }
    }

    /// اضافة علامة تفصيلية للكل
    public function student_mark_admin_details(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $lesson_id = $request->lesson_id;
        $studens = Room::find($request->room_id)->student;
        foreach ($studens as $student) {
            $report_card=Report_card::where('student_id',$student->id)->where('year_id',$year->id)->first();
            if ($request->term == 'term1') {

       if (isset($report_card) && $report_card->adjustable != 0){
                session()->flash('error22',' لا يمكن التعديل بعد استصدار الجلاء  ' ) ;
            return redirect()->back()->with('error','  لا يمكن تعديل العلامات بعد استصدار الجلاء !  ') ;
        }
            $lesson = Lesson::find($lesson_id);
            $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();
            if (auth()->user()->type == 1 && $student_mark->adjustable != 0){
                session()->flash('error22',' لا يمكن التعديل تم تثبيت العلامات من قبل الإدارة  ' ) ;
            return redirect()->back()->with('error','   لا يمكن التعديل   تم تثبيت العلامات من قبل الإدارة    !  ') ;
        }
            $object1 = json_decode($student_mark->mark, true);
           if($request->oral){
               $object1[$lesson_id]['oral'] = $request->oral;
           }
           if($request->homework){
             $object1[$lesson_id]['homework'] = $request->homework;
           }
           if($request->activities){
             $object1[$lesson_id]['activities'] = $request->activities;
           }
           if($request->quize){
            $object1[$lesson_id]['quize'] = $request->quize;
           }
          if($request->exam){
              $object1[$lesson_id]['exam'] = $request->exam;
           }

            if ($student_mark->worke_degree) {
                $object_worke_degree = json_decode($student_mark->worke_degree, true);
                foreach (json_decode($student_mark->worke_degree) as $key => $item) {
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

            $object_result1 = json_decode($student_mark->result1, true);
            // $object_result1[$lesson_id]['term1_result']=ceil($object_result1[$lesson_id]['term1_exam']+ $object_result1[$lesson_id]['term1_quizes']);
            // $object_result1[$lesson_id]['term1_quizes']=ceil($object1[$lesson_id]['oral']*0.1)+
            // ceil($object1[$lesson_id]['homework']*0.1)+ceil($object1[$lesson_id]['activities']*0.2)+ceil($object1[$lesson_id]['quize']*0.2);
            // $object_result1[$lesson_id]['term1_exam']=ceil($object1[$lesson_id]['exam']*0.4);

            $object_result1[$lesson_id]['term1_quizes'] = ceil($object1[$lesson_id]['oral']) +
                ceil($object1[$lesson_id]['homework']) + ceil($object1[$lesson_id]['activities']) + ceil($object1[$lesson_id]['quize']);
            $object_result1[$lesson_id]['term1_exam'] = ceil($object1[$lesson_id]['exam']);

             $object_result2 = json_decode($student_mark->result2, true);
            if ($student_mark->result) {
                 $object_result = json_decode($student_mark->result, true);
                 $decodedData = json_decode($student_mark->result2);

                if (!json_decode($student_mark->result2, true) ||(!property_exists($decodedData,  $lesson_id ) ) ) {


                    $object_result2[$lesson_id]['term2_result'] = 0;
                }

                $object_result1[$lesson_id]['term1_result'] = ceil($object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes']);

                    $object_result[$lesson_id] = array("year_result" => null);



                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

            }
            $student_mark->update([
                'student_id' => $student->id,
                'room_id' => $request->room_id,
                'worke_degree' => json_encode($object_worke_degree),
                'mark' => json_encode($object1),
                'result1' => json_encode($object_result1),
                'result' => json_encode($object_result),

                'status' => '1'

            ]);

            if ($student_mark->estimation1) {
                $stc = json_decode($student_mark->estimation1, true);
                if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 0 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $student_mark->estimation1 = json_encode($stc);

                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                }
            } else {
                $stc = new stdClass;
                if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= "0" && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 40) {

                    $stc->{$lesson_id} = "ضعيف";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 41 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 70) {
                    $stc->{$lesson_id} = "وسط";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 71 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 80) {
                    $stc->{$lesson_id} = "جيد";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 81 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 90) {
                    $stc->{$lesson_id} = "جيد جداًً";
                    $student_mark->estimation1 = json_encode($stc);

                    $student_mark->save();
                } else if (json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] >= 91 && json_decode($student_mark->result1, true)[$lesson_id]['term1_result'] <= 100) {

                    $stc->{$lesson_id} = "ممتاز";
                    $student_mark->estimation1 = json_encode($stc);
                    $student_mark->save();
                }
            }




            $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();

            $result_term1 = 0;
            $count = 0;
            foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {
                $les= Lesson::find($key1);
                 if($les){
                if( $les->is_neutral!=3){
                $result_term1 = $result_term1 + $value1['term1_result'];
                $count++;
                 }}
            }

            $objec_term_result = json_decode($student_mark->term_result, true);
              $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 : "0";

                  $year_result = (json_decode($student_mark->term_result, true)['term1']
                + $objec_term_result['term1'] ) / 2;

            $student_mark->update([
                'term_result' => json_encode($objec_term_result),
                'year_result' => $year_result,


            ]);
            if ($student_mark->estimation) {
                $stc = json_decode($student_mark->estimation, true);
                if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $student_mark->estimation = json_encode($stc);

                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                }
            } else {
                $stc1 = new stdClass;
                if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc1->{$lesson_id} = "ضعيف";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc1->{$lesson_id} = "وسط";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc1->{$lesson_id} = "جيد";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc1->{$lesson_id} = "جيد جداًً";
                    $student_mark->estimation = json_encode($stc1);

                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc1->{$lesson_id} = "ممتاز";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                }
            }


            } else {
            $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();
            if (isset($report_card) && $report_card->adjustable != 1){
                session()->flash('error22',' لا يمكن التعديل تأكد من حالة الجلاء ' ) ;
                return redirect()->back()->with('error','  لا يمكن التعديل تأكد من حالة الجلاء    !  ') ;
            }
            if (auth()->user()->type == 1 && $student_mark->adjustable != 1){
                        session()->flash('error22',' لا يمكن التعديل تأكد من حالة الجلاء ' ) ;
                return redirect()->back()->with('error','   لا يمكن التعديل   تم تثبيت العلامات من قبل الإدارة    !  ') ;
            }

            $lesson = Lesson::find($lesson_id);


            $object2 = json_decode($student_mark->mark2, true);

            if($request->oral){
               $object2[$lesson_id]['oral'] = $request->oral;
           }
           if($request->homework){
             $object2[$lesson_id]['homework'] = $request->homework;
           }
           if($request->activities){
             $object2[$lesson_id]['activities'] = $request->activities;
           }
           if($request->quize){
            $object2[$lesson_id]['quize'] = $request->quize;
           }
          if($request->exam){
              $object2[$lesson_id]['exam'] = $request->exam;
           }
            if($student_mark->worke_degree ){
                $object_worke_degree2=json_decode($student_mark->worke_degree,true);
               foreach(json_decode($student_mark->worke_degree) as $key=>$item){
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

            //   if($student_mark->worke_degree){
            //     $object_worke_degree2=json_decode($student_mark->worke_degree,true);
            //   }

            //     $object_worke_degree2[$lesson_id]['term2_result']=$object2[$lesson_id]['oral']+$object2[$lesson_id]['activities']+$object2[$lesson_id]['homework']+$object2[$lesson_id]['quize'];

            $object_result2 = json_decode($student_mark->result2, true);
            $object_result2[$lesson_id]['term2_quizes'] = ceil($object2[$lesson_id]['oral']) +
                ceil($object2[$lesson_id]['homework']) + ceil($object2[$lesson_id]['activities']) + ceil($object2[$lesson_id]['quize']);
            $object_result2[$lesson_id]['term2_exam'] = ceil($object2[$lesson_id]['exam']);
            $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
            $object_result1 = json_decode($student_mark->result1, true);
            $object_result = json_decode($student_mark->result, true);

            if ($student_mark->result) {
                $object_result = json_decode($student_mark->result, true);
                $decodedData = json_decode($student_mark->result1);


                if (!json_decode($student_mark->result1, true) ||(!property_exists($decodedData,  $lesson_id ))) {


                    $object_result1[$lesson_id]['term1_result'] = 0;
                }




                $object_result2[$lesson_id]['term2_result'] = ceil($object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes']);
                $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
            }

            if ($student_mark->notes) {
                $notes = json_decode($student_mark->notes, true);
                $notes[$lesson_id] = $request->notes;
            } else {
                $notes = new stdClass;
                $notes->{$lesson_id} = $request->notes;
            }
            $student_mark->update([
                'student_id' => $student->id,
                'room_id' => $request->room_id,
                'mark2' => json_encode($object2),
                'result2' => json_encode($object_result2),
                'result' => json_encode($object_result),
                'worke_degree' => json_encode($object_worke_degree2),
                'notes' => json_encode($notes),
                'status' => '1'

            ]);
            if ($student_mark->estimation2) {
                $stc = json_decode($student_mark->estimation2, true);
                if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $student_mark->estimation2 = json_encode($stc);

                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                }
            } else {
                $stc = new stdClass;
                if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= "0" && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 40) {

                    $stc->{$lesson_id} = "ضعيف";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 41 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 70) {
                    $stc->{$lesson_id} = "وسط";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 71 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 80) {
                    $stc->{$lesson_id} = "جيد";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 81 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 90) {
                    $stc->{$lesson_id} = "جيد جداًً";
                    $student_mark->estimation2 = json_encode($stc);

                    $student_mark->save();
                } else if (json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] >= 91 && json_decode($student_mark->result2, true)[$lesson_id]['term2_result'] <= 100) {

                    $stc->{$lesson_id} = "ممتاز";
                    $student_mark->estimation2 = json_encode($stc);
                    $student_mark->save();
                }
            }
            $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();

            $result_term2 = 0;
            $count = 0;
            foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {
                $les= Lesson::find($key1);
                if($les){
                   if( $les->is_neutral !=3){
                 $result_term2 = $result_term2 + $value1['term2_result'];
                 $count++;
                }
                }


             }

             $objec_term_result = json_decode($student_mark->term_result, true);
               $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2  : "0";
                  $year_result = (json_decode($student_mark->term_result, true)['term1']
                 +  $objec_term_result['term2']) / 2;

             $student_mark->update([

                 'term_result' => json_encode($objec_term_result),
                 'year_result' => $year_result,

             ]);

            // return response()->json([
            //     'success'=>'! تمت العملية بنجاح'
            // ]);
            if ($student_mark->estimation) {
                $stc = json_decode($student_mark->estimation, true);
                if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc[$lesson_id] = "ضعيف";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc[$lesson_id] = "وسط";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc[$lesson_id] = "جيد";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc[$lesson_id] = "جيد جداًً";
                    $student_mark->estimation = json_encode($stc);

                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc[$lesson_id] = "ممتاز";
                    $student_mark->estimation = json_encode($stc);
                    $student_mark->save();
                }
            } else {
                $stc1 = new stdClass;
                if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= "0" && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 40) {

                    $stc1->{$lesson_id} = "ضعيف";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 41 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 70) {
                    $stc1->{$lesson_id} = "وسط";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 71 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 80) {
                    $stc1->{$lesson_id} = "جيد";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 81 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 90) {
                    $stc1->{$lesson_id} = "جيد جداًً";
                    $student_mark->estimation = json_encode($stc1);

                    $student_mark->save();
                } else if (ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) >= 91 && ceil(json_decode($student_mark->result,true)[$lesson_id]['year_result'] /2) <= 100) {

                    $stc1->{$lesson_id} = "ممتاز";
                    $student_mark->estimation = json_encode($stc1);
                    $student_mark->save();
                }
            }


        }

        }

        return redirect()->back();
    }



  public function create_mark(Request $request){
return $request->all();
  }





// ----------------------------------------------------------


  public function slider(){

    $sliders = Slider::orderBy('id', 'desc')->paginate(paginate_num);
    $count = Slider::count();

        return view('admin.sliders',compact('sliders', 'count'));

  }


  public function slider_store(Request $request){

    $slider=new Slider;
    $slider->header_ar = $request->header_ar;
    $slider->header_en = $request->header_en;
    $slider->content_ar= $request->content_ar;
    $slider->content_en= $request->content_en;



    // if ($request->hasFile('image1')) {

    //     if ($slider->image1 != null) {

    //         Storage::disk('public')->delete($slider->image1);
    //     }
    //     $slider->image1=$request->image1->store('sliderimages','public');
    // }
    if ($request->hasFile('image')) {
$slider->image = $request->image->store('sliderimages','public');

    }
    $slider->save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');

}


public function slider_update(Request $request){

    $sliderId = $request->slider_id ?: $request->id;
    $slider = Slider::find($sliderId);

    if (!$slider) {
        return redirect()->back()->with('error', 'Slider not found');
    }

    $slider->header_ar = $request->header_ar;
    $slider->header_en = $request->header_en;
    $slider->content_ar= $request->content_ar;
    $slider->content_en= $request->content_en;



    if ($request->hasFile('image')) {

        if ($slider->image != null) {

            Storage::disk('public')->delete($slider->image);
        }
        $slider->image=$request->image->store('sliderimages','public');
    }


    $slider->save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');

}


public function slider_delete(Request $request){

    $slider= Slider::find($request->id);


    if ($slider->image != null) {

       Storage::disk('public')->delete($slider->image);
    }


    $slider->delete();

    return redirect()->back()->with('success','! تمت العملية بنجاح ');

}


// ============================================





public function header_info(){

    $header_info=Header_info::first();
    if (isset($header_info)) {

        return view('admin.header_info',compact('header_info'));
    }else{
        return redirect()->back();
    }
  }





  public function header_info_store(Request $request,$header_info_id){

    $header_info=Header_info::first();

    $header_info->email = $request->email;
    $header_info->address_ar = $request->address_ar;
    $header_info->address_en = $request->address_en;

    $header_info->save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');

}



// =====================================

public function inside_slider(){

    $slider=Inside_slider::first();
    if (isset($slider)) {

        return view('admin.inside_sliders',compact('slider'));
    }else{
        return redirect()->back();
    }
  }





  public function inside_slider_store(Request $request,$slider_id){

    $slider=Inside_slider::find($slider_id);

    if ($request->hasFile('news_image')) {

        if ($slider->news_image != null) {

            Storage::disk('public')->delete($slider->news_image);
        }
        $slider->news_image=$request->news_image->store('indide_sliderimages','public');
    }




    if ($request->hasFile('events_image')) {

        if ($slider->events_image != null) {

            Storage::disk('public')->delete($slider->events_image);
        }
        $slider->events_image=$request->events_image->store('indide_sliderimages','public');
    }




    if ($request->hasFile('blogs_image')) {

        if ($slider->blogs_image != null) {

            Storage::disk('public')->delete($slider->blogs_image);
        }
        $slider->blogs_image=$request->blogs_image->store('indide_sliderimages','public');
    }


    if ($request->hasFile('about_image')) {

        if ($slider->about_image != null) {

            Storage::disk('public')->delete($slider->about_image);
        }
        $slider->about_image=$request->about_image->store('about_sliderimages','public');
    }

        if ($request->hasFile('jobs_image')) {

        if ($slider->jobs_image != null) {

            Storage::disk('public')->delete($slider->jobs_image);
        }
        $slider->jobs_image=$request->jobs_image->store('indide_sliderimages','public');
    }

    $slider->save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');

}






// =================================================

public function news(){

    $news=News::paginate(paginate_num);
    if (isset($news)) {

        $count=$news->count();
        return view('admin.news',compact('news','count'));
    }else{
        return redirect()->back();
    }
  }







  public function news_store(Request $request){

    $request->validate([
        'title_ar'=>'required|max:100',
        'content_ar'=>'required|max:255',
        'title_en'=>'required|max:100',
        'content_en'=>'required|max:255',
        'part1_ar'=>'required|max:600',
        'part2_ar'=>'max:600',
        'part3_ar'=>'max:600',
        'part3_ar'=>'max:600',
        'part1_en'=>'required|max:600',
        'part2_en'=>'max:600',
        'part3_en'=>'max:600',
        'part3_en'=>'max:600',

    ]);

    $news=new News;

    $news->title_ar = $request->title_ar;
    $news->content_ar = $request->content_ar;

    $news->title_en = $request->title_en;
    $news->content_en = $request->content_en;

    $news->part1_ar = $request->part1_ar;
    $news->part2_ar = $request->part2_ar;
    $news->part3_ar = $request->part3_ar;
    $news->part4_ar = $request->part4_ar;
    $news->part1_en = $request->part1_en;
    $news->part2_en = $request->part2_en;
    $news->part3_en = $request->part3_en;
    $news->part4_en = $request->part4_en;


    if ($request->hasFile('image1')) {

        $news->image1 = $request->image1->store('newsimages','public');

    }


    if ($request->hasFile('image2')) {

        $news->image2 = $request->image2->store('newsimages','public');

    }


    if ($request->hasFile('image3')) {

        $news->image3 = $request->image3->store('newsimages','public');

    }


    if ($request->hasFile('image4')) {

        $news->image4 = $request->image4->store('newsimages','public');

    }





    $news -> save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');



}


public function news_update(Request $request){


    $news_id=$request->id;
    $news=News::find($news_id);

    $news->title_ar = $request->title_ar;
    $news->content_ar = $request->content_ar;

    $news->title_en = $request->title_en;
    $news->content_en = $request->content_en;

    $news->part1_ar = $request->part1_ar;
    $news->part2_ar = $request->part2_ar;
    $news->part3_ar = $request->part3_ar;
    $news->part4_ar = $request->part4_ar;
    $news->part1_en = $request->part1_en;
    $news->part2_en = $request->part2_en;
    $news->part3_en = $request->part3_en;
    $news->part4_en = $request->part4_en;

if($request->has('del_img1')){
Storage::disk('public')->delete($news->image1);
$news->image1=null;
}


if($request->has('del_img2')){
Storage::disk('public')->delete($news->image2);

$news->image2=null;
}

if($request->has('del_img3')) {
Storage::disk('public')->delete($news->image3);

$news->image3=null;
}

if($request->has('del_img4')){
Storage::disk('public')->delete($news->image4);

$news->image4=null;
}

    if ($request->hasFile('image1')) {

        if ($news->image1 != null) {

        Storage::disk('public')->delete($news->image1);

        }
        $news->image1 = $request->image1->store('newsimages','public');

    }


    if ($request->hasFile('image2')) {

        if ($news->image2 != null) {

            Storage::disk('public')->delete($news->image2);

            }
        $news->image2 = $request->image2->store('newsimages','public');

    }


    if ($request->hasFile('image3')) {

        if ($news->image3 != null) {

            Storage::disk('public')->delete($news->image3);

            }
        $news->image3 = $request->image3->store('newsimages','public');

    }


    if ($request->hasFile('image4')) {

        if ($news->image4 != null) {

            Storage::disk('public')->delete($news->image4);

            }

        $news->image4 = $request->image4->store('newsimages','public');

    }




    $news -> save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');



}


public function news_delete(Request $request){

$news_id=$request->id;
$news=News::find($news_id);
if ($news->image1 !=null) {

    Storage::disk('public')->delete($news->image1);
}

if ($news->image2 !=null) {

    Storage::disk('public')->delete($news->image2);
}

if ($news->image3 !=null) {

    Storage::disk('public')->delete($news->image3);
}

if ($news->image4 !=null) {

    Storage::disk('public')->delete($news->image4);
}



$news->delete();

return redirect()->back()->with('success','تم حذف  بنجاح !');

}











public function about_us(){

    $about_us=About_us::first();

    return view('admin.about_us',compact('about_us'));
}

public function about_us_store(Request $request ,$about_us_id) {

    $request->validate([
        'header_ar'=>'max:100',
        'header_en'=>'max:100',

        'content_ar'=>'max:600',
        'content_en'=>'max:600',

        'vission_ar'=>'max:400',
        'mission_ar' => 'max:400',
        'objective_ar' => 'max:400',


        'vission_en'=>'max:400',
        'mission_en' => 'max:400',
        'objective_en' => 'max:400',

    ]);
    $about_us = About_us::find($about_us_id);

    $about_us->header_ar = $request->header_ar;
    $about_us->content_ar = $request->content_ar;
    $about_us->vission_ar = $request->vission_ar;
    $about_us->mission_ar = $request->mission_ar;
    $about_us->objective_ar = $request->objective_ar;


    $about_us->header_en = $request->header_en;
    $about_us->content_en = $request->content_en;
    $about_us->vission_en = $request->vission_en;
    $about_us->mission_en = $request->mission_en;
    $about_us->objective_en = $request->objective_en;

    if ($request -> hasFile('image')) {

        if ($about_us->image != null) {
            Storage::disk('public')->delete($about_us->image);
        }
        $about_us->image = $request->image->store('about_us_images','public');
    }

    if ($request -> hasFile('image_slider_top')) {
        if ($about_us->image_slider_top != null) {
            Storage::disk('public')->delete($about_us->image_slider_top);
        }
        $about_us->image_slider_top = $request->image_slider_top->store('about_us_images','public');
    }



    if ($request -> hasFile('image_slider_bottom')) {
        if ($about_us->image_slider_bottom != null) {
            Storage::disk('public')->delete($about_us->image_slider_bottom);
        }
        $about_us->image_slider_bottom = $request->image_slider_bottom->store('about_us_images','public');
    }

    $about_us->save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');

}


public function contacts(){
$contacts=DB::table('contacts') -> orderBy('id', 'desc') -> paginate(paginate_num);
    // $contacts=Contact::paginate(paginate_num);
    $count=$contacts->count();
    return view('admin.contacts',compact('contacts','count'));
}

public function contact_delete(Request $request){

    $contact_id=$request->id;

    $contact=Contact::find($contact_id);
    $contact->delete();
    return redirect()->back()->with('success','تمت العملية  بنجاح !');

}

public function events(){

    $events=Event::paginate(paginate_num);
    $count=$events->count();
    return view('admin.events',compact('events','count'));


}

public function event_store(Request $request){
   $request->validate([
        'header_ar'=>'required|max:100',
        'content_ar'=>'required|max:600',
        'header_en'=>'required|max:100',
        'content_en'=>'required|max:600',
        'address_ar'=>'required|max:100',
        'address_en'=>'required|max:100',

        'image'=>'required',
        'start_time'=>'required|date',
        'end_time'=>'required|date'
    ]);

    $event=new Event;

    $event->header_ar = $request->header_ar;
    $event->content_ar = $request->content_ar;

    $event->header_en = $request->header_en;
    $event->content_en = $request->content_en;

    $event->address_ar = $request->address_ar;
    $event->address_en = $request->address_en;


    $event->start_time = $request->start_time;
    $event->end_time = $request->end_time;

    if ($request->hasFile('image')) {

        $event->image = $request->image->store('eventsimages','public');

    }

    $event -> save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');




}



public function events_update(Request $request){



    $event_id=$request->id;
    $event=Event::find($event_id);

    $event->header_ar = $request->header_ar;
    $event->content_ar = $request->content_ar;

    $event->header_en = $request->header_en;
    $event->content_en = $request->content_en;

    $event->start_time = $request->start_time;
    $event->end_time = $request->end_time;

if($request->has('del_img1')){
Storage::disk('public')->delete($event->image);

$event->image=null;
}


    if ($request->hasFile('image')) {

        if ($event->image != null) {

        Storage::disk('public')->delete($event->image);

        }
        $event->image = $request->image->store('eventsimages','public');

    }



    $event -> save();

  return redirect()->back()->with('success','! تمت العملية بنجاح');



}


public function event_delete(Request $request){

$event_id=$request->id;
$event=Event::find($event_id);
if ($event->image !=null) {

    Storage::disk('public')->delete($event->image);
}
$event->delete();

return redirect()->back()->with('success','! تمت العملية بنجاح');

}

public function jobs(){

    $jobs=Job::paginate(paginate_num);
    $count=$jobs->count();
    return view('admin.jobs',compact('jobs','count'));

}


public function job_store(Request $request){

    $request->validate([
        'title_ar'=>'required|max:100',
        'description_ar'=>'required|max:600',
        'title_en'=>'required|max:100',
        'description_en'=>'required|max:600',
    ]);

    $job=new Job;

    $job->title_ar = $request->title_ar;
    $job->description_ar = $request->description_ar;
    $job->title_en = $request->title_en;
    $job->description_en = $request->description_en;




    $job -> save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');


}



public function job_update(Request $request){



    $job=Job::find($request->job_id);

    $job->title_ar = $request->title_ar;
    $job->description_ar = $request->description_ar;
    $job->title_en = $request->title_en;
    $job->description_en = $request->description_en;




    $job -> save();

    return redirect()->back()->with('success','! تمت العملية بنجاح');



}

public function job_delete(Request $request){

    $job_id=$request->id;
    $job=Job::find($job_id);
$job->delete();
$applicants=Applicant::where('job_id',$job_id)->delete();



    return redirect()->back()->with('success','! تمت العملية بنجاح');

    }

    public function applicants(){

        $applicants=Applicant::paginate(paginate_num);
        $count=$applicants->count();
        return view('admin.applicants',compact('applicants','count'));

    }


    public function applicant_delete(Request $request){

        $applicant_id=$request->id;
        $applicant=Applicant::find($applicant_id);

        if ($applicant->file != null) {

            Storage::disk('public')->delete($applicant->file);
        }
        $applicant->delete();

        return redirect()->back()->with('success','! تمت العملية بنجاح');

        }

      public function contact_answer(Request $request){

            $contact=Contact::find($request->contact_id);
            $contact->message_ar=$request->message_ar;
            $contact->message_en=$request->message_en;

            $contact->answer_ar=$request->answer_ar;
            $contact->answer_en=$request->answer_en;

            $contact->save();

            return redirect()->back()->with('success','! تمت العملية بنجاح');

        }

        public function video(){

            $video=Video::first();

            return view('admin.video',compact('video'));

        }

        public function video_update(Request $request){


            $video=Video::find($request->video_id);

            if (isset($request->youtube)) {
                $video->youtube  = $request->youtube;

                if ($video->video !=null) {

                    Storage::disk('public')->delete($video->video);
                }
            }else{

                $video->youtube=null;
            }

            if (isset($request->video)) {

                if ($request->hasFile('video')) {

                    $video->video = $request->video->store('videosfiles','public');
                }

                if ($video->youtube !=null) {

                    $video->youtube =null;

                }
            }
            else{
                $video->video =null;
            }

            $video->save();
            return redirect()->back()->with('Updated Successfully !');

        }


        public function student_super(Request $request){

            $student = Student::find($request->id);
            $student->super = '1';

            $student->save();

            return response()->json([
                'status' => true ,
                'msg'=> 'تم التحديث بنجاح ' ,

            ]);
         }


        public function student_less(Request $request){

            $student = Student::find($request->id);

            $student->super = null;

            $student->save();


            return response()->json([
                'status' => true ,
                'msg'=> 'تم التحديث بنجاح ' ,

            ]);

        }



        public function footer(){

            $footer=Footer::first();

            return view('admin.footer',['footer'=>$footer]);
        }


        public function footer_update(Request $request ,$footer_id){

            $request->validate([
                'content_ar' => 'required | max:255',
                'address_ar' => 'required | max:100',
                'content_en' => 'required | max:255',
                'address_en' => 'required | max:100',
                'phone' => 'required | max:20',
                'email' => 'required | max:100',
                'facebook' => 'required | max:255',
                'twitter' => 'required | max:255',
                'google' => 'required | max:255',
                'instgram' => 'required | max:255',

            ]);


            $footer = Footer::find($footer_id);

            $footer->update($request->all());


            return redirect()->back()->with('success','! تمت العملية بنجاح');


        }







        public function student_change(Request $request){

            $year=Year::where('current_year','1')->first();
            $student_room=Room_student::where('student_id',$request->student_id)
            ->where('year_id',$year->id)->first();


        if($student_room){



if($student_room->room_id==$request->room_change_id){
    return redirect()->back()->with('success','لا يوجد اي تعديل !');
}


    $student=Student::find($request->student_id);


    $class_id= $student->room()->where('rooms.year_id',$year->id)->first()->class_id;

    if($class_id == $request->class_change_id && $class_id == $request->old_class_id ){


    $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();
            $student_room->room_id = $request->room_change_id;
            $student_room->save();

            $student_mark->room_id= $request->room_change_id;
              $student_mark->save();
            return redirect()->back()->with('success','تم تعديل الشعبة الدراسية !');




}
   }
            $student_room=Room_student::where('student_id',$request->student_id)
            ->where('year_id',$year->id)->get();
                $student_mark=Students_mark::where('student_id',$request->student_id)->where('year_id',$year->id)->get();

            if ($student_room->count() > 0) {

                foreach ($student_room as $item) {

                    $item->delete();
                    }

                    foreach ($student_mark as $item) {

                        $item->delete();
                        }

            }


            $room_student = new Room_student;

            $room_student->student_id = $request->student_id;
            $room_student->room_id = $request->room_change_id;
            $room_student->year_id = $year->id;
            $room_student->save();








            $lessons=Lesson::where('class_id',$request->class_change_id)->get();
            $object1=new stdClass();
            foreach($lessons as $item){
                $object1->{$item->id}['oral']=$request->oral;
                $object1->{$item->id}['homework']=$request->homework;
                $object1->{$item->id}['activities']=$request->activities;
                $object1->{$item->id}['quize']=$request->quize;
                $object1->{$item->id}['exam']=$request->exam;


            }

            $object2=new stdClass();
            foreach($lessons as $item){
                $object2->{$item->id}['oral']=$request->oral;
                $object2->{$item->id}['homework']=$request->homework;
                $object2->{$item->id}['activities']=$request->activities;
                $object2->{$item->id}['quize']=$request->quize;
                $object2->{$item->id}['exam']=$request->exam;


            }

            $object_result1=new stdClass();

            foreach($lessons as $item){
                $object_result1->{$item->id}['term1_quizes']=null;
                $object_result1->{$item->id}['term1_exam']=null;
                $object_result1->{$item->id}['term1_result']=null;

            }


            $object_result2=new stdClass();

            foreach($lessons as $item){
                $object_result2->{$item->id}['term2_quizes']=null;
                $object_result2->{$item->id}['term2_exam']=null;
                $object_result2->{$item->id}['term2_result']=null;

            }

            $object_result=new stdClass();

            foreach($lessons as $item){
                $object_result->{$item->id}['year_result']=null;

            }

            $object_result_term=new stdClass();

            $object_result_term->{'term1'}=null;
            $object_result_term->{'term2'}=null;


        Students_mark::create([
        'student_id'=>$request->student_id,
        'room_id'=>$request->room_change_id,
        'year_id'=>$year->id,
        'mark'=>json_encode($object1),
        'mark2'=>json_encode($object2),
        'result1'=>json_encode($object_result1),
        'result2'=>json_encode($object_result2),
        'result'=>json_encode($object_result),
        'term_result'=>json_encode($object_result_term),

        'status'=>'1',
        'lang'=>$student->lang,
    ]);




    if ($student->lang=='0') {
        $lessons=Lesson::where('class_id',$request->class_change_id)->where('lang','1')->get();

    }elseif($student->lang=='1'){
        $lessons=Lesson::where('class_id',$request->class_change_id)->where('lang','0')->get();

    }


    foreach($lessons as $lesson){

        if ($lesson->lang!=null) {

            $student_mark=Students_mark::where('student_id',$student->id)->where('lang',$student->lang)->where('year_id',$year->id)->first();




                 $arr1= json_decode($student_mark->mark,true) ;
                  $arr2= json_decode($student_mark->mark2,true) ;
                 $arr_result1= json_decode($student_mark->result1,true) ;
                 $arr_result2= json_decode($student_mark->result2,true) ;
                 $arr_result= json_decode($student_mark->result,true) ;

                    if(array_key_exists($lesson->id,$arr1)=='1'){

                       unset($arr1[$lesson->id]);

                       $student_mark->mark=json_encode($arr1);

        }

                                if(array_key_exists($lesson->id,$arr2)){

                       unset($arr2[$lesson->id]);
                       $student_mark->mark2=json_encode($arr2);

                    }


                                            if(array_key_exists($lesson->id,$arr_result1)){

                       unset($arr_result1[$lesson->id]);
                       $student_mark->result1=json_encode($arr_result1);

                    }

                                            if(array_key_exists($lesson->id,$arr_result2)){

                       unset($arr_result2[$lesson->id]);
                       $student_mark->result2=json_encode($arr_result2);

                    }

                                            if(array_key_exists($lesson->id,$arr_result)){

                       unset($arr_result[$lesson->id]);
                       $student_mark->result=json_encode($arr_result);

                    }


                                    $student_mark->save();

                 $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                            $result_term1=0;
                                                $result_term2=0;

                $count1=0;
                        $count2=0;

                foreach( json_decode($student_mark->result1,true) as $key1=>$value1){

                    $result_term1=$result_term1+$value1['term1_result'];
                    $count1++;

                }
                        foreach( json_decode($student_mark->result2,true) as $key1=>$value1){

                    $result_term2=$result_term2+$value1['term2_result'];
                    $count2++;

                }

                $objec_term_result=json_decode($student_mark->term_result,true);
                $objec_term_result['term1'] = $result_term1!=0 ?$result_term1/$count1 : "0" ;
                $objec_term_result['term2'] = $result_term2!=0 ?$result_term2/$count2 : "0" ;

                    $student_mark->term_result=json_encode($objec_term_result);
                                    $student_mark->save();
                 $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();


                $year_result=(json_decode($student_mark->term_result,true)['term1']
                        +json_decode($student_mark->term_result,true)['term2'])/2;

        $student_mark->year_result= $year_result;
        $student_mark->save();




    }


            }






            return redirect()->back()->with('success','! تمت العملية بنجاح');

        }








        public function student_archive($student_id){

            $student=Student::with(['room.student_mark'=>fn($q1) => $q1->where('student_id',$student_id)])->find($student_id);

            $date=Carbon::now();
            $date= $date->format('m/d/Y');
            return view('admin.archive',compact('student','date'));
        }


        public function remain_account($student_id,$class_id) {


            $class=Classe::find($class_id);
    $year=Year::where('current_year','1')->first();
            $invoices=Invoice::where('year_id',$year->id)->where('student_id',$student_id)->get();

            $remain_amount=0;
            $full_amount = $class->fixed_cost;
            $amount_paid = 0;
            foreach ($invoices as $item) {
                $amount_paid=$amount_paid + $item->invoice_amount;

            }

            $remain_amount = $full_amount - $amount_paid;

            return response()->json([
                'status' => true ,
                'remain_amount'=> $remain_amount ,
                'amount_paid'  => $amount_paid,
                'full_amount'  => $full_amount,

            ]);


        }


        public function invoice_store(Request $request){
    $year=Year::where('current_year','1')->first();


            Invoice::create([

                'invoice_number' => $request->invoice_number,
                'invoice_amount' => $request->invoice_amount,
                'student_id' => $request->student_id,
                'class_id' => $request->class_id,
                'year_id' => $year->id,

            ]);

            return redirect()->back()->with('success','! تمت العملية بنجاح');


        }

        public function invoices_details ($student_id)  {

            $student = Student::find($student_id);
            $year = Year::where('current_year','1')->first();

            $invoices_details = Invoice::where('student_id',$student_id)->where('year_id',$year->id)->get();


            return view('admin.invoices_details',compact('invoices_details','student'));
        }

        public function invoices_delete ($invoice_id)  {


            $invoice = Invoice::find($invoice_id) ;

            $invoice -> delete();

            return redirect()->back()->with('success','! تمت العملية بنجاح');
        }

        public function show_years(){

            $years = Year::all();
            $current_year = Year::where('current_year','1')->first();
            return view('admin.years',compact('years','current_year'));

        }


        public function current_year(Request $request){

            $years=Year::all();

            foreach ($years as $item) {

                $item->current_year='0';
                $item->save();
            }
            $year = Year::find($request->year_id);
            $year->current_year = '1';
            $year->save();

            $students=Student::all();
            foreach($students as $student){
                $student->status='0';
                $student->oral_status='0';
                $student->quize_status='0';
                $student->activity_status='0';
                $student->homework_status='0';
                $student->exam_status='0';

                $student->save();
            }

                Teacher_event::truncate();
            Message::truncate();

            return redirect()->back();

        }



        public function blogs() {

            $blogs=Blog::paginate(paginate_num);
            $count=$blogs->count();
            return view('admin.blogs',compact('blogs','count'));

        }



    public function blog_store(Request $request){
// return $request->all();

        // $request->validate([
        //     'title_ar'=>'required|max:100',
        //     'title_en'=>'required|max:100',
        //     'part1_ar'=>'required|max:600',
        //     'part2_ar'=>'max:600',
        //     'part3_ar'=>'max:600',
        //     'part3_ar'=>'max:600',
        //     'part1_en'=>'required|max:600',
        //     'part2_en'=>'max:600',
        //     'part3_en'=>'max:600',
        //     'part3_en'=>'max:600',

        // ]);

        $blog=new Blog;

        $blog->title_ar = $request->title_ar;

        $blog->title_en = $request->title_en;

        $blog->part1_ar = $request->part1_ar;
        $blog->part2_ar = $request->part2_ar;
        $blog->part3_ar = $request->part3_ar;
        $blog->part4_ar = $request->part4_ar;
        $blog->part1_en = $request->part1_en;
        $blog->part2_en = $request->part2_en;
        $blog->part3_en = $request->part3_en;
        $blog->part4_en = $request->part4_en;



        if ($request->hasFile('image1')) {

            $blog->image1 = $request->image1->store('blogsimages','public');

        }


        if ($request->hasFile('image2')) {

            $blog->image2 = $request->image2->store('blogsimages','public');

        }


        if ($request->hasFile('image3')) {

            $blog->image3 = $request->image3->store('blogsimages','public');

        }


        if ($request->hasFile('image4')) {

            $blog->image4 = $request->image4->store('blogsimages','public');

        }


        // =================Image Gallery=====================


        if ($request->hasFile('image5')) {

            $blog->image5 = $request->image5->store('blogsimages','public');

        }


        if ($request->hasFile('image6')) {

            $blog->image6 = $request->image6->store('blogsimages','public');

        }


        if ($request->hasFile('image7')) {

            $blog->image7 = $request->image7->store('blogsimages','public');

        }


        if ($request->hasFile('image8')) {

            $blog->image8 = $request->image8->store('blogsimages','public');

        }


        if ($request->hasFile('image9')) {

            $blog->image9 = $request->image9->store('blogsimages','public');

        }

        if ($request->hasFile('image10')) {

            $blog->image10 = $request->image10->store('blogsimages','public');

        }



        $blog -> save();

        return redirect()->back()->with('success','Stored Successfullty !');



    }


    public function blog_update(Request $request){

        $blog_id=$request->id;
        $blog=Blog::find($blog_id);

        $blog->title_ar = $request->title_ar;

        $blog->title_en = $request->title_en;

        $blog->part1_ar = $request->part1_ar;
        $blog->part2_ar = $request->part2_ar;
        $blog->part3_ar = $request->part3_ar;
        $blog->part4_ar = $request->part4_ar;
        $blog->part1_en = $request->part1_en;
        $blog->part2_en = $request->part2_en;
        $blog->part3_en = $request->part3_en;
        $blog->part4_en = $request->part4_en;

if($request->has('del_img1')){
Storage::disk('public')->delete($blog->image1);
$blog->image1=null;
}


if($request->has('del_img2')){
Storage::disk('public')->delete($blog->image2);

$blog->image2=null;
}

if($request->has('del_img3')){
Storage::disk('public')->delete($blog->image3);

$blog->image3=null;
}

if($request->has('del_img4')){
Storage::disk('public')->delete($blog->image4);

$blog->image4=null;
}

if($request->has('del_img5')){
Storage::disk('public')->delete($blog->image5);

$blog->image5=null;
}

if($request->has('del_img6')){
Storage::disk('public')->delete($blog->image6);

$blog->image6=null;
}

if($request->has('del_img7')){
Storage::disk('public')->delete($blog->image7);

$blog->image7=null;
}

if($request->has('del_img8')){
Storage::disk('public')->delete($blog->image8);

$blog->image8=null;
}


if($request->has('del_img9')){
Storage::disk('public')->delete($blog->image9);

$blog->image9=null;
}

if($request->has('del_img10')){
Storage::disk('public')->delete($blog->image10);

$blog->image10=null;
}

        if ($request->hasFile('image1')) {

            if ($blog->image1 != null) {

            Storage::disk('public')->delete($blog->image1);

            }
            $blog->image1 = $request->image1->store('blogsimages','public');

        }


        if ($request->hasFile('image2')) {

            if ($blog->image2 != null) {

                Storage::disk('public')->delete($blog->image2);

                }
            $blog->image2 = $request->image2->store('blogsimages','public');

        }


        if ($request->hasFile('image3')) {

            if ($blog->image3 != null) {

                Storage::disk('public')->delete($blog->image3);

                }
            $blog->image3 = $request->image3->store('blogsimages','public');

        }


        if ($request->hasFile('image4')) {

            if ($blog->image4 != null) {

                Storage::disk('public')->delete($blog->image4);

                }

            $blog->image4 = $request->image4->store('blogsimages','public');

        }


        // =================Image Gallery=====================


        if ($request->hasFile('image5')) {

            if ($blog->image5 != null) {

                Storage::disk('public')->delete($blog->image5);

                }

            $blog->image5 = $request->image5->store('blogsimages','public');

        }


        if ($request->hasFile('image6')) {

            if ($blog->image6 != null) {

                Storage::disk('public')->delete($blog->image6);

                }
            $blog->image6 = $request->image6->store('blogsimages','public');

        }


        if ($request->hasFile('image7')) {

            if ($blog->image7 != null) {

                Storage::disk('public')->delete($blog->image7);

                }

            $blog->image7 = $request->image7->store('blogsimages','public');

        }


        if ($request->hasFile('image8')) {

            if ($blog->image8 != null) {

                Storage::disk('public')->delete($blog->image8);

                }

            $blog->image8 = $request->image8->store('blogsimages','public');

        }


        if ($request->hasFile('image9')) {

            if ($blog->image9 != null) {

                Storage::disk('public')->delete($blog->image9);

                }

            $blog->image9 = $request->image9->store('blogsimages','public');

        }

        if ($request->hasFile('image10')) {

            if ($blog->image10 != null) {

                Storage::disk('public')->delete($blog->image10);

                }

            $blog->image10 = $request->image10->store('blogsimages','public');

        }


        $blog -> save();

        return redirect()->back()->with('success','! تمت العملية بنجاح');



    }


    public function blog_delete(Request $request){


    $blog_id=$request->id;
    $blog=Blog::find($blog_id);
    if ($blog->image1 !=null) {

        Storage::disk('public')->delete($blog->image1);
    }

    if ($blog->image2 !=null) {

        Storage::disk('public')->delete($blog->image2);
    }

    if ($blog->image3 !=null) {

        Storage::disk('public')->delete($blog->image3);
    }

    if ($blog->image4 !=null) {

        Storage::disk('public')->delete($blog->image4);
    }

    if ($blog->image5 !=null) {

        Storage::disk('public')->delete($blog->image5);
    }

    if ($blog->image6 !=null) {

        Storage::disk('public')->delete($blog->image6);
    }

    if ($blog->image7 !=null) {

        Storage::disk('public')->delete($blog->image7);
    }

    if ($blog->image8 !=null) {

        Storage::disk('public')->delete($blog->image8);
    }
    if ($blog->image9 !=null) {

        Storage::disk('public')->delete($blog->image9);
    }
    if ($blog->image10 !=null) {

        Storage::disk('public')->delete($blog->image10);
    }
    $blog->delete();

    return redirect()->back()->with('success','تم حذف  بنجاح !');

    }


    public function reset_password(Request $request,$id){

           $user=User::find($id);
                   $this->validate($request, [
                       'old_password'          => 'required',
                       'password'              => 'required|min:4',
                       'password_confirmation' => 'required|same:password'
                   ]);

                   if (Hash::check($request->old_password, $user->password)) {

                       $user->password = Hash::make($request->password);
                       $user->view_password = $request->password;

                       $user->save();

                      }
                      else{

                       return redirect()->back()->with('warning','Incorrect Old Password  !');

                      }


                   return redirect()->back()->with('success','! تمت العملية بنجاح');


    }

    public function send_message(Request $request) {
        $year = Year :: where('current_year','1')->first();
        $request->validate([
            'message'=>'required',
        ]);

        if (isset($request->class_id)) {
            if ($request->class_id == '0') {

                $rooms= Room::where('year_id',$year->id)->get();


                foreach ($rooms as $room) {

                    foreach ($room->student as $student) {

                        $item = new Message;

                        $item->student_id = $student->id;
                        $item->message = $request->message;
                        $item->year_id = $year->id;
                        $item->save();

                    }

                }

                return redirect()->back()->with('success','! تمت العملية بنجاح');

            }



            $class=Classe::find($request->class_id);

            $rooms=  $class->room->where('year_id',$year->id);

            foreach ($rooms as $room) {

                foreach ($room->student as $student) {


                    $item = new Message;

                    $item->student_id = $student->id;
                    $item->message = $request->message;
                    $item->year_id = $year->id;
                    $item->save();

                }

            }

            return redirect()->back()->with('success','! تمت العملية بنجاح');

        }

        $item = new Message;

        $item->student_id = $request->student_id;
        $item->message = $request->message;
        $item->year_id = $year->id;
        $item->save();

return redirect()->back()->with('success','! تمت العملية بنجاح');
    }







    public function change_lang(Request $request) {
        $year = Year :: where('current_year','1')->first();
        $student=Student::find($request->student_id);

        $class=$student->room()->where('room_student.year_id',$year->id)->first()->classes;


        // if ($student->lang==$request->select_lang) {

        //     return redirect()->back()->with('success','! لا يوجد اي تعديل');

        // }


$student_lang=$student->lang;

   $student->lang=$request->select_lang;


$student->save();



   if ($student_lang=='0') {
    $lessons=Lesson::where('class_id',$class->id)->where('lang','0')->get();

}elseif($student_lang=='1'){
    $lessons=Lesson::where('class_id',$class->id)->where('lang','1')->get();

}


foreach($lessons as $lesson){

    if ($lesson->lang!=null) {

        $student_mark=Students_mark::where('student_id',$student->id)->where('lang',$student_lang)->where('year_id',$year->id)->first();




             $arr1= json_decode($student_mark->mark,true) ;
              $arr2= json_decode($student_mark->mark2,true) ;
             $arr_result1= json_decode($student_mark->result1,true) ;
             $arr_result2= json_decode($student_mark->result2,true) ;
             $arr_result= json_decode($student_mark->result,true) ;

                if(array_key_exists($lesson->id,$arr1)=='1'){

                   unset($arr1[$lesson->id]);

                   $student_mark->mark=json_encode($arr1);

    }

                            if(array_key_exists($lesson->id,$arr2)){

                   unset($arr2[$lesson->id]);
                   $student_mark->mark2=json_encode($arr2);

                }


                                        if(array_key_exists($lesson->id,$arr_result1)){

                   unset($arr_result1[$lesson->id]);
                   $student_mark->result1=json_encode($arr_result1);

                }

                                        if(array_key_exists($lesson->id,$arr_result2)){

                   unset($arr_result2[$lesson->id]);
                   $student_mark->result2=json_encode($arr_result2);

                }

                                        if(array_key_exists($lesson->id,$arr_result)){

                   unset($arr_result[$lesson->id]);
                   $student_mark->result=json_encode($arr_result);

                }


                                $student_mark->save();

             $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                        $result_term1=0;
                                            $result_term2=0;

            $count1=0;
                    $count2=0;

            foreach( json_decode($student_mark->result1,true) as $key1=>$value1){

                $result_term1=$result_term1+$value1['term1_result'];
                $count1++;

            }
                    foreach( json_decode($student_mark->result2,true) as $key1=>$value1){

                $result_term2=$result_term2+$value1['term2_result'];
                $count2++;

            }

            $objec_term_result=json_decode($student_mark->term_result,true);
            $objec_term_result['term1'] = $result_term1!=0 ?$result_term1/$count1 : "0" ;
            $objec_term_result['term2'] = $result_term2!=0 ?$result_term2/$count2 : "0" ;

                $student_mark->term_result=json_encode($objec_term_result);
                                $student_mark->save();
             $student_mark=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();


            $year_result=(json_decode($student_mark->term_result,true)['term1']
                    +json_decode($student_mark->term_result,true)['term2'])/2;

    $student_mark->year_result= $year_result;
    $student_mark->save();




}


        }



        if ($request->has('select_lang')) {


            if ($request->select_lang =='0') {
                $lessons=Lesson::where('class_id',$class->id)->where('lang','0')->get();

            }elseif($request->select_lang=='1'){
                $lessons=Lesson::where('class_id',$class->id)->where('lang','1')->get();

            }
            // $rooms=Classe::find($request->class_id)->room()->where('rooms.year_id',$year->id)->get('id');
        // $cont=[];
        // foreach($rooms as $room) {
        //   $cont[]=Students_mark::where('room_id',$room->id)->where('lang',$request->select_lang)->get();
        // }
        // return count($cont);
        // $students_marks=[];
        // foreach($cont as $room){
        //  foreach($room as $item){

            //  هون كل حقل بالسجل عبارة عن نص
            //  $students_marks[]=$item;
            //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php



            foreach ($lessons as $lesson) {

                $item=Students_mark::where('student_id',$student->id)->where('year_id',$year->id)->first();

                $a1=json_decode($item->mark,true);

                $a1[$lesson->id]=[
                'oral'=>null,
                'homework'=>null,
                'activities'=>null,
                'quize'=>null,
                'exam'=>null,
                ];

                $item->mark=json_encode($a1);

                  $a2=json_decode($item->mark2,true);
                    $a2[$lesson->id]=[
                'oral'=>null,
                'homework'=>null,
                'activities'=>null,
                'quize'=>null,
                'exam'=>null,
                ];

                    $item->mark2=json_encode($a2);


                  $a3=json_decode($item->result1,true);
                    $a3[$lesson->id]=[
                'term1_quizes'=>null,
                'term1_exam'=>null,
                'term1_result'=>null,
                ];

                    $item->result1=json_encode($a3);


                          $a4=json_decode($item->result2,true);
                    $a4[$lesson->id]=[
                'term2_quizes'=>null,
                'term2_exam'=>null,
                'term2_result'=>null,
                ];

                    $item->result2=json_encode($a4);

                      $a5=json_decode($item->result,true);
                    $a5[$lesson->id]=[
                'year_result'=>null,

                ];

                    $item->result=json_encode($a5);

                $item->save();




            }







        }














        $student_mark_new=Students_mark::where('student_id',$request->student_id)->where('year_id',$year->id)->first();

        $student_mark_new->lang=$request->select_lang;

     $student_mark_new->save();





return redirect()->back()->with('success','! تمت العملية بنجاح');
    }


    public function databasebackup()
    { include app_path() . '/BackupDataBase.php';
        try {
            $world_dumper = Shuttle_Dumper::create(array(
                'host' => 'localhost',
                'username' => 'smartsyrianschoo_school',
                'password' => '.G4WVt,_-0ak',
                'db_name' => 'smartsyrianschoo_school',
                //'include_tables' => array('country', 'city'), // only include those tables
                //'exclude_tables' => array('city'),
            ));

            // $world_dumper->dump('cep.sql.gz');
            $path = base_path('storage/backup') . '/backup_' . Carbon::now()->format('Y-m-d')
            . '_' . Carbon::now()->format('H')
            . '_' . Carbon::now()->format('m')
            . '_' . Carbon::now()->format('s') .'_.sql';
            $world_dumper->dump($path);

            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . basename($path) . "\"");
            readfile($path);
            Session::flash('success', 'تم أخذ نسخة احتياطية بنجاح');
            $backup=new Backup;
            $backup->item= substr($path,43);
            $backup->save();




            return redirect()->back()->with('! تمت العملية بنجاح ');
        } catch (Shuttle_Exception $e) {
            echo "Couldn't dump database: " . $e->getMessage();
        }



    }







public function importedatabase(Request $request)
    {include app_path() . '/BackupDataBase.php';
        $this->validate($request, [
            'sql' => 'required',
        ]);

        $sql = $request->file('sql');
        $filename = $sql->getClientOriginalName();
        $path = base_path('backup/') . $filename;
        DB::unprepared(file_get_contents($path));
        Session::flash('success', 'تمت العملية بنجاح');
        return redirect('/backup_view');
    }




    public function backups(){
        $backups=Backup::all();
        $count=Backup::count();

        return view('admin.backups',compact('backups','count'));
    }


    public function zipfile($id) {

        $zip=new A;
        $filename= 'myzip.zip';
        if ($zip->open(public_path($filename),A::CREATE)===true) {

$files=File::files(base_path('storage/backup'));
foreach ($files as $key => $value) {
    $relativePath=basename($value);
    $zip->addFile($value,$relativePath);




}
$zip->close();
}


 return response()->download(public_path($filename));
}

public function backup_del(Request $request) {
      File::delete(public_path('myzip.zip'));

    $backup = Backup::find($request->id);
    unlink(storage_path().'/'.$backup->item);
    Backup::destroy($request->id);
    return redirect()->back();
}




public function users() {

    $users=User::where('type','2')->paginate(20);
 $count=count(User::where('type','2')->get());
    $roles=Role::all();
    return view('admin.users',compact('users','count','roles'));

}

public function user_store(Request $request){

    $request->validate([
        'email'=>'required|email|unique:users'
    ]);
    $user=new User;
    $user->name = $request->name;
    $user->mobile = $request->mobile;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->view_password = $request->password ;
    $user->type = '2' ;
    $user->role_id = $request->role_id;

    $user->save();
return redirect()->back()->with('success','! تمت العملية بنجاح');
}

public function user_update(Request $request){


    $request->validate([
        'email' => 'required|email|unique:users,email,'.$request->user_id.',id',
    ]);

    $user= User::find($request->user_id);
    $user->name = $request->name;
    $user->mobile = $request->mobile;
    $user->email = $request->email;
    $user->role_id = $request->role_id;

    $user->save();
return redirect()->back()->with('success','! تمت العملية بنجاح');
}

public function user_delete(Request $request){
User::find($request->user_id)->delete();
return redirect()->back()->with('success','! تمت العملية بنجاح');

}







public function supervisors(){

    $supervisors= Supervisor::paginate(20);
    $count=Supervisor::count();
    $classes=Classe::all();
    return view('admin.supervisors',compact('supervisors','count','classes'));

}


public function supervisor_store(Request $request){

    $year= Year::where('current_year','1')->first();

   $request->validate([
       'first_name'=>'required|max:30',
       'last_name'=>'required|max:30',
       'phone'=>'required|max:20',
       'email'=>'required|email|unique:users',
       'password' => 'required|min:8',
       'password_confirmation' => 'required_with:password|same:password|min:8',
   ]);

  $supervisor= Supervisor::create([
       'first_name'=>$request->first_name,
       'last_name'=>$request->last_name,
       'address'=>$request->address,
       'phone'=>$request->phone,
       'email'=>$request->email,
       'date_birth'=>$request->date_birth,
   ]);


if($request->hasFile('image')){

$supervisor->image = $request->image->store('supervisorsimage','public');
}

   $user=User::create([
       'name'=>$request->first_name,
       'email'=>$request->email,
       'mobile'=>$request->phone,
       'password'=>Hash::make($request->password),
       'view_password'=>$request->password,
       'type'=>'3',
       'supervisor_id'=>$supervisor->id,

   ]);


   $supervisor->save();
   return redirect()->back();


}


public function supervisor_details($supervisor_id){

    $year=Year::where('current_year','1')->first();

    $supervisor=Supervisor::find($supervisor_id);

     return view('admin.supervisor_details',compact('supervisor'));

}




public function reset_supervisor_password(Request $request,$supervisor_id){

    $user=User::where('supervisor_id',$supervisor_id)->first();
            $this->validate($request, [
                'password'              => 'required|min:4',
                'password_confirmation' => 'required|same:password'
            ]);


                $user->password = Hash::make($request->password);
                $user->view_password = $request->password;

                $user->save();

            return redirect()->back()->with('success','! تمت العملية بنجاح');

}






public function supervisor_update(Request $request , $supervisor_id){

    $user=User::where('supervisor_id',$supervisor_id)->first();
    $request->validate([
        'first_name'=>'required',
        'last_name'=>'required',
        'email' => 'required|email|unique:users,email,'.$user->id.',id',
                'phone'=>'required',


    ]);

    $supervisor=Supervisor::find($supervisor_id);
    $supervisor->first_name=$request->first_name;
    $supervisor->last_name=$request->last_name;
    $supervisor->email=$request->email;
    $supervisor->date_birth=$request->date_birth;
    $supervisor->phone=$request->phone;
    $supervisor->address=$request->address;

    $user=User::where('supervisor_id',$supervisor_id)->first();
    $user->email=$request->email;

    if ($request->hasFile('image')) {

        Storage::disk('public')->delete($supervisor->image);

        $supervisor->image = $request->image->store('supervisorsimage','public');
    }


$user=User::where('supervisor_id',$supervisor_id)->first();
$user->email=$request->email;
$user->save();

$supervisor->save();

return redirect()->back()->with('success','! تمت العملية بنجاح');

}


public function set_supervisor_task($supervisor_id) {

    $supervisor=Supervisor::find($supervisor_id);
    $classes=Classe::all();
   return view('admin.set_supervisor_task',compact('supervisor','classes'));

}


public function store_supervisor_set_task(Request $request) {

    $year = Year:: where('current_year','1')->first();


    Supervisor_class_lesson::where('supervisor_id',$request->supervisor_id)->delete();
$supervisor = Supervisor :: find($request->supervisor_id);

for ($i=0; $i < count($request->class_id); $i++ )
{

    $item= new Supervisor_class_lesson;

    $item->supervisor_id = $request->supervisor_id;
    $item->class_id = $request->class_id[$i];
    $item->lesson_id = $request->lesson_id[$i];

    $item->save();

}



return redirect()->back()->with('success','! تمت العملية بنجاح');
}

public function edit_supervisor_task($supervisor_id) {

    $lessons=Supervisor::with(['lessons.classes2'])->find($supervisor_id);
    $lessons= $lessons->lessons->unique();
    $supervisor = Teacher::find($supervisor_id);
    $classes = Classe ::all();

    return view('admin.edit_supervisor_task',compact('classes','lessons','supervisor'));



}


public function update_supervisor_set_task(Request $request) {



    if($request->has('class_id')!='1') {



        return redirect(route('admin.teacher.set_task',$request->supervisor_id));
    }


    Supervisor_class_lesson::where('supervisor_id',$request->supervisor_id)->delete();
$supervisor = Supervisor::find($request->supervisor_id);



for ($i=0; $i < count($request->class_id); $i++ )
{

    $item= new Supervisor_class_lesson;

    $item->supervisor_id = $request->supervisor_id;
    $item->class_id = $request->class_id[$i];
    $item->lesson_id = $request->lesson_id[$i];

    $item->save();

}

return redirect()->back()->with('success','! تمت العملية بنجاح');
}



}
