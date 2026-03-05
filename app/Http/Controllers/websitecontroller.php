<?php

namespace App\Http\Controllers;

use App\About_us;
use App\Applicant;
use App\Classe;
use App\Contact;
use App\Count;
use App\Event;
use App\Footer;
use App\Blog;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Inside_slider;
use App\Header_info;
use App\Advantages;
use App\Job;
use App\Lesson;
use App\News;
use App\Category;
use App\Slider;
use App\Vision;
use App\Service;
use App\Our_services_feature;
use App\Gallery;
use App\How_it_works_website;
use App\Counter_website;
use App\Contact_website;
use App\About_us_website;
use App\Testimonials;
use App\Blogs_website;
use App\Footer_website;
use App\Faqs_website;
use App\Student;
use App\Other;
use App\Video;
use App\More_details;
use App\Stats;
use App\User;
use App\Teacher;
use App\Group;
use App\Student_register;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use stdClass;
use App\Country_currency;


class websitecontroller extends Controller
{

    public function store_employee(Request $request){
        $employee = new Employee;
        $employee->job_name = $request->name_lecture;
        $employee->full_part = $request->timetype;
        $type_job = [];
        for($i = 0; $i < count($request->type_job) ;$i++){
            $object = new stdClass;
            if($request->type_job[$i] == "cord"){
                $object->name = $request->type_job[$i];
                $object->type = $request->name_cord;
            }else if($request->type_job[$i] == "teacher"){
                $object->name = $request->type_job[$i];
                $object->type = $request->name_teacher;
            }else if($request->type_job[$i] == "teacher_assistant"){
                $object->name = $request->type_job[$i];
                $object->type = $request->name_teacher_assistant;
            }else if($request->type_job[$i] == "section_manager"){
                $object->name = $request->type_job[$i];
                $object->type = $request->name_section_manager;
            }else if($request->type_job[$i] == "academic_guided"){
                $object->name = $request->type_job[$i];
                $object->type = $request->name_academic_guided;
            }else if($request->type_job[$i] == "administrative_guided"){
                $object->name = $request->type_job[$i];
                $object->type = $request->name_administrative_guided;
            }else{
                $object->name = $request->type_job[$i];
                $object->type = "";
            }
            $type_job [] = $object;
        }
        $employee->job = json_encode($type_job);
        $employee->name = $request->name;
        $employee->date = $request->address_date;
        $employee->gender = $request->gender;
        $employee->religion = $request->religion;
        $employee->landline_phone = $request->landline_phone;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->military = $request->military;
        $employee->family_status = $request->family_status;
        $employee->qualification = $request->qualification;
        $employee->specialization = $request->specialization;
        $employee->qualification_place = $request->qualification_place;
        $employee->qualification_place = $request->qualification_place;
        $employee->educational_qualification = $request->educational_qualification;
        $employee->educational_qualification_place = $request->educational_qualification_place;
        $languages = new stdClass;
        if(isset($request->arabic)){
            $languages->ar = $request->arabic;
        }
        if(isset($request->english)){
            $languages->en = $request->english;
        }
        if(isset($request->frinsh)){
            $languages->fr = $request->frinsh;
        }
        $employee->languages = json_encode($languages);

        $computer_course = [];
        if(isset($request->course_name)){
            for($i = 0; $i < count($request->course_name) ;$i++){
                if(!($request->course_name[$i] == null && $request->training_body[$i] == null && $request->yearof_course[$i] == null && $request->place_course[$i] == null)){
                    $xx = new stdClass;
                    $xx->course_name = $request->course_name[$i];
                    $xx->training_body = $request->training_body[$i];
                    $xx->yearof_course = $request->yearof_course[$i];
                    $xx->place_course = $request->place_course[$i];
                    $computer_course [] = $xx;
                }
            }
        }

        $employee->computer_course = json_encode($computer_course);

        $traning_course = [];
        if(isset($request->course_traning_name)){
            for($i = 0; $i < count($request->course_traning_name) ;$i++){
                if(!($request->course_traning_name[$i] == null && $request->course_traning_body[$i] == null && $request->yearof_traning_course[$i] == null && $request->place_traning_course[$i] == null)){
                    $xx = new stdClass;
                    $xx->course_name = $request->course_traning_name[$i];
                    $xx->training_body = $request->course_traning_body[$i];
                    $xx->yearof_course = $request->yearof_traning_course[$i];
                    $xx->place_course = $request->place_traning_course[$i];
                    $traning_course [] = $xx;
                }
            }
        }

        $employee->traning_course = json_encode($traning_course);


        $jobs = [];
        if(isset($request->course_traning_name)){
            for($i = 0; $i < count($request->course_traning_name) ;$i++){
                if(!($request->course_traning_name[$i] == null && $request->course_traning_body[$i] == null && $request->yearof_traning_course[$i] == null && $request->place_traning_course[$i] == null)){
                    $xx = new stdClass;
                    $xx->job = $request->job[$i];
                    $xx->number_year = $request->number_year[$i];
                    $xx->job_name = $request->job_name[$i];
                    $xx->job_place = $request->job_place[$i];
                    $jobs [] = $xx;
                }
            }
        }
        $employee->jobs = json_encode($jobs);


        $employee->save();
        return redirect()->back();
    }


    public function login1(Request $request){
    $input = $request->all();
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);
    $credentials = $request->only('email', 'password');

    if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
           if(auth()->user()->type=='4'){
                return redirect('SMARMANger/dashboard/coordinator');

            }
             if(auth()->user()->type=='5'){
                return redirect('SMARMANger/dashboard/acadsupervisor');

            }
            
                       if(auth()->user()->type=='6'){
                 return redirect('ADHAMMANger/dashboard/administrator');

            }
            
                               if(auth()->user()->type=='7'){
                 return redirect('ADHAMMANger/dashboard/employeeAdmin');

            }
            
           $user = Auth::getProvider()->retrieveByCredentials($credentials);
           Auth::login($user, $request->get('remember'));



           return redirect('SMARMANger/teacher');




        }
        else {
            session()->flash('error', '  ');

        return redirect()->back()->with('error',' البريد الالكتروني وكلمة السر غير متطابقين ... ') ;
        }
    }
    public function index(){


        $counter=Count::first();

        $counter->count=$counter->count+1;
        $counter->save();

        $video=Video::first();
        $sliders=Slider::
        select('id','header_'.LaravelLocalization::setLocale().
        ' as header','image','content_'.LaravelLocalization::setLocale().' as content','key_word_'.LaravelLocalization::setLocale().' as key_word')->get();
        $vision=Vision::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title',)->get();
        $about=About_us_website::
        select('id','welcome_'.LaravelLocalization::setLocale().
        ' as welcome','image','title_'.LaravelLocalization::setLocale().' as title','description_'.LaravelLocalization::setLocale().' as description','content_'.LaravelLocalization::setLocale().' as content')->first();
        $service=Service::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image','description_'.LaravelLocalization::setLocale().' as description',)->get();
        $our_services_feature=Our_services_feature::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','icon','image','description_'.LaravelLocalization::setLocale().' as description',)->get();

        $how_it_works_website=How_it_works_website::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','icon','description_'.LaravelLocalization::setLocale().' as description',)->get();
        $faqs=Faqs_website::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','description_'.LaravelLocalization::setLocale().' as description',)->get();

        $testimonials=Testimonials::
        select('id','message','user_name','job_title')->get();

        $blogs_web=Blogs_website::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image','description_'.LaravelLocalization::setLocale().' as description','updated_at')->get();
        $footer_web=Footer_website::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','whatsApp','linkedin','instgram','phone','email','created_at'
        )->first();


        $news=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(4)->get();
        $news1=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(9)->get();

         $classes=Classe::
        select('id','name','name_en','description_'.LaravelLocalization::setLocale().
        ' as description','image','week_count','lesson_count','cildren_count'

        )->get();


        $about_us=About_us::select('id','header_'.LaravelLocalization::setLocale().
        ' as header','content_'.LaravelLocalization::setLocale().' as content'
        ,'vission_'.LaravelLocalization::setLocale().
        ' as vission'
        ,'services_'.LaravelLocalization::setLocale().
        ' as services'
        ,'mission_'.LaravelLocalization::setLocale().
        ' as mission'
        ,'popular_information_'.LaravelLocalization::setLocale().
        ' as popular_information'
        ,'objective_'.LaravelLocalization::setLocale().
        ' as objective'
        ,'image','image_slider_top','image_slider_bottom','created_at'
        )->first();
        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','WhatsApp','google','instgram','phone','email','created_at'
        )->first();        $super_students=Student::where('super','1')->get();
     /* $dav=Advantages::all();*/

       $advantages = Advantages::select('id'
       ,'ourteams_'.LaravelLocalization::setLocale().
       ' as ourteams'
       ,'ourclasses_'.LaravelLocalization::setLocale().
       ' as ourclasses'
       ,'register_'.LaravelLocalization::setLocale().
       ' as register'
       ,'joinus_'.LaravelLocalization::setLocale().
       ' as joinus'


       )->first();
    $counter_web= Counter_website::select('id'
  ,'title_'.LaravelLocalization::setLocale().
  ' as title','count'

  )->get();
  $stats=Stats::all();
  $gallery=Gallery::all();
  $other=Other::first();


    $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();
    
        return view('website.index',compact('sliders','vision','service','about','news1','news','classes','about_us','video',
        'counter','stats','header','footer','super_students','advantages','other','our_services_feature','counter_web','gallery','how_it_works_website','testimonials','blogs_web','footer_web'));
        
        return view('website.app',compact('sliders','vision','news1','news','classes','about_us','video',
        'counter','stats','header','footer','super_students','advantages','other','footer_web'));


    }

  public function faq(){
    $footer_web=Footer_website::
    select('id','title_'.LaravelLocalization::setLocale().
    ' as title','content_'.LaravelLocalization::setLocale().
    ' as content','address_'.LaravelLocalization::setLocale().' as address'
    ,'facebook','twitter','whatsApp','linkedin','instgram','phone','email','created_at'
    )->first();

    $sliders=Slider::
    select('id','header_'.LaravelLocalization::setLocale().
    ' as header','image','content_'.LaravelLocalization::setLocale().' as content','key_word_'.LaravelLocalization::setLocale().' as key_word')->get();
    $faqs=faqs_website::
    select('id','title_'.LaravelLocalization::setLocale().
    ' as title','description_'.LaravelLocalization::setLocale().' as description',)->get();

    return view('website.faq',compact('sliders','footer_web','faqs')) ;

  }
  public function contact_us(){
    $footer_web=Footer_website::
    select('id','title_'.LaravelLocalization::setLocale().
    ' as title','content_'.LaravelLocalization::setLocale().
    ' as content','address_'.LaravelLocalization::setLocale().' as address'
    ,'facebook','twitter','whatsApp','linkedin','instgram','phone','email','created_at'
    )->first();

    $sliders=Slider::
    select('id','header_'.LaravelLocalization::setLocale().
    ' as header','image','content_'.LaravelLocalization::setLocale().' as content','key_word_'.LaravelLocalization::setLocale().' as key_word')->get();


    return view('website.contact_us',compact('sliders','footer_web')) ;

  }

  public function login(){
    return view('website.login') ;
  }


  public function register(){


    $counter=Count::first();

    $counter->count=$counter->count+1;
    $counter->save();

        $video=Video::first();
        $sliders=Slider::
        select('id','header_'.LaravelLocalization::setLocale().
        ' as header','image','content_'.LaravelLocalization::setLocale().' as content')->get();



        $news1=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(9)->get();

        $classes=Classe::all();


        $footer_web=Footer_website::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','whatsApp','linkedin','instgram','phone','email','created_at'
        )->first();

          $countries_currencies = Country_currency::all();


        return view('website.register_st',compact('countries_currencies','classes','counter','sliders','footer_web'));


    }

    public function lessons($class_id){
        $counter=Count::first();

        $counter->count=$counter->count+1;
        $counter->save();

        $countt=Count::first();

$lessons=Lesson::where('class_id',$class_id)->get();

$count=$lessons->count();
$count2=Count::first();

$lessons1=[];
$lessons2=[];

for ($i=0; $i <6 ; $i++) {
if (isset($lessons[$i])) {
    $lessons1[$i]=$lessons[$i];
}
}

for ($i=6; $i <$count ; $i++) {

    if (isset($lessons[$i])) {
        $lessons2[$i]=$lessons[$i];
    }
}


$class=Classe::find($class_id);

$footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
' as content','address_'.LaravelLocalization::setLocale().' as address'
,'facebook','twitter','WhatsApp','google','instgram','phone','email','created_at'
)->first();

$header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();

return view('website.lessons',compact('lessons1','lessons2','lessons','class','header','footer','count','count','count2','counter'));


    }

    public function about_us(){
        $counter=Count::first();

        $counter->count=$counter->count+1;
        $counter->save();

        $about_us=About_us::select('id','header_'.LaravelLocalization::setLocale().
        ' as header','content_'.LaravelLocalization::setLocale().' as content'
        ,'vission_'.LaravelLocalization::setLocale().
        ' as vission'
        ,'mission_'.LaravelLocalization::setLocale().
        ' as mission'
        ,'objective_'.LaravelLocalization::setLocale().
        ' as objective'
         ,'services_'.LaravelLocalization::setLocale().
        ' as services'
        ,'image','image_slider_top','image_slider_bottom','created_at'
        )->first();

        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','google','WhatsApp','instgram','phone','email','created_at'
        )->first();

         $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();
        $inside_slider=Inside_slider::first();
     $det=More_details::all();

     $news1=News::
     select('id','title_'.LaravelLocalization::setLocale().
     ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
     ,'part1_'.LaravelLocalization::setLocale().
     ' as part1'
     ,'content_'.LaravelLocalization::setLocale().
     ' as content'
     ,'part2_'.LaravelLocalization::setLocale().
     ' as part2'
     ,'part3_'.LaravelLocalization::setLocale().
     ' as part3'
     ,'part4_'.LaravelLocalization::setLocale().
     ' as part4'
     ,'image2','image3','image4','type','created_at'
     )->
     orderBy('created_at', 'desc')
     ->limit(9)->get();




          $other=Other::first();
          $mor_det=More_details::first();

        return view('website.about_us',['mor_det'=>$mor_det,'other'=>$other,'news1'=>$news1,'about_us'=>$about_us,'counter'=>$counter,'inside_slider'=>$inside_slider,'header'=>$header,'footer'=>$footer,'det'=>$det]);
    }


    public function contact(){


        $counter=Count::first();

        $counter->count=$counter->count+1;
        $counter->save();

        $news=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(4)->get();
        $news1=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(9)->get();

        $classes=Classe::all();
        $about_us=About_us::select('id','header_'.LaravelLocalization::setLocale().
        ' as header','content_'.LaravelLocalization::setLocale().' as content'
        ,'vission_'.LaravelLocalization::setLocale().
        ' as vission'
        ,'services_'.LaravelLocalization::setLocale().
        ' as services'
        ,'mission_'.LaravelLocalization::setLocale().
        ' as mission'
        ,'popular_information_'.LaravelLocalization::setLocale().
        ' as popular_information'
        ,'objective_'.LaravelLocalization::setLocale().
        ' as objective'
        ,'image','image_slider_top','image_slider_bottom','created_at'
        )->first();

        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,
        'title_'.LaravelLocalization::setLocale().' as title',

        'content_'.LaravelLocalization::setLocale().' as 	content',
        'business_hours_'.LaravelLocalization::setLocale().' as business_hours',
        'facebook','twitter','google','WhatsApp','instgram','img','phone','email','created_at'
        )->first();
        $other=Other::first();
        return view('website.contactus',compact('counter','news1','about_us','footer','other'));
    }


    public function contact_store(Request $request){
         $contact= new Contact_website;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->phone = $request->phone;
        $contact->message = $request->message;

            $contact->save();
        return redirect()->back()->with('success','Sending Successfully!');

    }


    public function classes(){
        $count=Count::first();
        $classes=Classe::all();

        $count=Count::first();
        $count->count=$count->count+1;
        $count->save();

    $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
    ' as content','address_'.LaravelLocalization::setLocale().' as address'
    ,'facebook','twitter','google','instgram','WhatsApp','phone','email','created_at'
    )->first();

             $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();

        return view('website.classes',compact('classes','count','header','footer','count'));
    }

    public function events(){

        $count=Count::first();
        $count->count=$count->count+1;
        $count->save();
        $events=Event::select('id','header_'.LaravelLocalization::setLocale().
        ' as header'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().
        ' as address',
        'start_time','end_time'
        ,'image','created_at'
        )->paginate(4);
        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','google','instgram','WhatsApp','phone','email','created_at'
        )->first();
        $inside_slider=Inside_slider::first();
         $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();

        return view('website.events',compact('events','count','header','footer','inside_slider'));
    }

    public function event_single($event_id){
        $count=Count::first();
        $count->count=$count->count+1;
        $count->save();
        $event=Event::select('id','header_'.LaravelLocalization::setLocale().
        ' as header'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content','start_time','end_time',
        'address_'.LaravelLocalization::setLocale().
        ' as address'
        ,'image','created_at'
        )->find($event_id);
        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','google','instgram','WhatsApp','phone','email','created_at'
        )->first();
                 $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();

        return view('website.event_single',compact('event','count','header','footer'));
    }


    public function blogs(){

        $count=Count::first();
        $count->count=$count->count+1;
        $count->save();
        $blogs=Blog::select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','image5','image6','image7','image8','image9','image10','created_at'
        )->paginate(4);
        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','google','instgram','WhatsApp','phone','email','created_at'
        )->first();

        $inside_slider=Inside_slider::first();
         $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();

        return view('website.blogs',compact('blogs','count','header','footer','inside_slider'));
    }

    public function blog_single($blog_id){
        $count=Count::first();
        $count->count=$count->count+1;
        $count->save();
        $blog=Blog::select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','image5','image6','image7','image8','image9','image10','created_at'
        )->find($blog_id);
        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','google','instgram','phone','WhatsApp','email','created_at'
        )->first();
                 $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();

        return view('website.blog_single',compact('blog','count','header','footer'));
    }
  public function stu_register(Request $request){

      $stu=new  Student_register();
      $stu->first_name=$request->first_name;
      $stu->last_name=$request->last_name;
      $stu->first_name_en=$request->first_name_en;
      $stu->last_name_en=$request->last_name_en;
      $stu->email=$request->email;
      $stu->phone=$request->phone;
      $stu->last_mother_name=$request->last_mather_name;
      $stu->date=$request->date;
      $stu->country=$request->country;
      $stu->father_name=$request->father_name;
      $stu->mather_name=$request->mather_name;
      $stu->religion=$request->religion;
      $stu->the_ID_number=$request->the_ID_number;
      $stu->nationality=$request->nationality;
      $stu->the_previous_school=$request->the_previous_school;

      $stu->con_sch=$request->con_sch;
      $stu->gender=$request->gender;
      $stu->passport_number=$request->passport_number;
      $stu->place_of_birth=$request->place_of_birth;
      $stu->city=$request->city;

      if ($request->hasFile('fourth_image')) {
        $stu->fourth_image = $request->fourth_image->store('filesteachers', 'public');
      }
       if ($request->hasFile('personal_image')) {
        $stu->personal_image = $request->personal_image->store('filesteachers', 'public');
      }

      if ($request->hasFile('passbord')) {
            $stu->passbord = $request->passbord->store('filesteachers', 'public');
      }

        if ($request->hasFile('certification')) {
            $stu->certification = $request->certification->store('filesteachers', 'public');
      }
         if ($request->hasFile('mather_page')) {
            $stu->mather_page = $request->mather_page->store('filesteachers', 'public');
      }
         if ($request->hasFile('father_page')) {
            $stu->father_page = $request->father_page->store('filesteachers', 'public');
      }

      $stu->class1=$request->class1;
      $stu->other_phone=$request->other_phone;


        $stu->save();
          session()->flash('success','شاكرين ثقتكم ... تم التسجيل و سنتواصل معكم بعد تدقيق البيانات');
        return redirect()->back()->with('success','شاكرين ثقتكم ... تم التسجيل و سنتواصل معكم بعد تدقيق البيانات');



  }


    public function employment(){

        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','google','instgram','phone','WhatsApp','email','created_at'
        )->first();
        return view('website.employment',compact('footer'));

    }


      public function news(){

        $counter=Count::first();

        $counter->count=$counter->count+1;
        $counter->save();

          $news=News:: paginate(9)->onEachSide(1);
          $count=News::count();
        $news1=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(9)->get();



        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','WhatsApp','google','instgram','phone','email','created_at'
        )->first();        $super_students=Student::where('super','1')->get();

         $other=Other::first();

        $inside_slider=Inside_slider::first();
         $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();
        $category=Category::all();
        return view('website.news',compact('counter','count','other','news1','news','count','header','footer','inside_slider','category'));

    }


  public function book($id){
    $counter=Count::first();

    $counter->count=$counter->count+1;
    $counter->save();
        $classes = Classe::where('id',$id)->with('lessons')->first();

        $news1=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(9)->get();



        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','WhatsApp','google','instgram','phone','email','created_at'
        )->first();        $super_students=Student::where('super','1')->get();


            $other=Other::first();

        return view('website.book',compact('classes','footer','other','news1','counter'));
    }
    public function news_single($news_id){
        $counter=Count::first();

        $counter->count=$counter->count+1;
        $counter->save();
        $news=News::  select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','created_at'
        )->find($news_id);
        $news1=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(9)->get();



        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','WhatsApp','google','instgram','phone','email','created_at'
        )->first();        $super_students=Student::where('super','1')->get();


$other=Other::first();

        return view('website.news_single',compact('other','news1','news','footer','counter'));
    }



    public function jobs(){


        $counter=Count::first();
        $counter->count=$counter->count+1;
        $counter->save();
          $jobs=Job::select('id','title_'.LaravelLocalization::setLocale().
        ' as title'
        ,'description_'.LaravelLocalization::setLocale().
        ' as description'
       ,'created_at','type'
        )->paginate(4);

        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','google','instgram','phone','WhatsApp','email','created_at'
        )->first();
                 $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().   ' as address')->first();
        $inside_slider=Inside_slider::first();
        $news1=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(9)->get();



        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','WhatsApp','google','instgram','phone','email','created_at'
        )->first();        $super_students=Student::where('super','1')->get();


            $other=Other::first();
        return view('website.jobs',compact('news1','other','jobs','counter','inside_slider','header','footer'));
    }

    public function applicant_store(Request $request) {

        $request->validate([

            'first_name' => 'required | max:50',
            'last_name'  => 'required | max:50',
            'email'      => 'required | email | max:100',
            'phone'      =>  'required | max:20',
            'job_id'     =>  'required | numeric',
        ]);




        $applicant = new Applicant;

        $applicant->first_name = $request->first_name;
        $applicant->last_name  = $request->last_name;
        $applicant->email      = $request->email;
        $applicant->phone      = $request->phone;
        $applicant->job_id     = $request->job_id;
        $applicant->extension  = $request->cv_file->extension();
        if ($request -> hasFile('cv_file')) {

            $applicant->file = $request->cv_file->store('applicantsfiles','public');
        }

           $applicant->save();

           session()->flash('success','لقد تم تسجيل طلبك بنجاح ' );
        return redirect()->back()->with('Sending Successfully !');

    }


    public function faqs(){

         $counter=Count::first();
        $counter->count=$counter->count+1;
        $counter->save();
         $faqs = Contact::whereNotNull ('answer_ar')->select('id','message_'.LaravelLocalization::setLocale().
         ' as message','answer_'.LaravelLocalization::setLocale().
         ' as answer')->where('type',1)->get();
         $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
         ' as content','address_'.LaravelLocalization::setLocale().' as address'
         ,'facebook','twitter','google','instgram','phone','WhatsApp','email','created_at'
         )->first();
         $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().
        ' as address')->first();
        $other=Other::first();
        $news1=News::
        select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'content_'.LaravelLocalization::setLocale().
        ' as content'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','type','created_at'
        )->
        orderBy('created_at', 'desc')
        ->limit(9)->get();
         return view('website.faqs',compact('news1','faqs','other','header','footer','counter'));
    }



        public function search(Request $request) {



        $news=News::where('title_ar',"like", "%" . $request->text . "%")->
        orwhere('title_en',"like", "%" . $request->text . "%")->
        orwhere('content_ar',"like", "%" . $request->text . "%")->
        orwhere('content_en',"like", "%" . $request->text . "%")->
        orwhere('part1_ar',"like", "%" . $request->text . "%")->
        orwhere('part1_en',"like", "%" . $request->text . "%")->
        orwhere('part2_ar',"like", "%" . $request->text . "%")->
        orwhere('part2_en',"like", "%" . $request->text . "%")->
        orwhere('part3_ar',"like", "%" . $request->text . "%")->
        orwhere('part3_en',"like", "%" . $request->text . "%")->
        orwhere('part4_ar',"like", "%" . $request->text . "%")->
        orwhere('part4_en',"like", "%" . $request->text . "%")
        ->select('id','title_'.LaravelLocalization::setLocale().
        ' as title','image1','content_'.LaravelLocalization::setLocale().' as content'
        ,'part1_'.LaravelLocalization::setLocale().
        ' as part1'
        ,'part2_'.LaravelLocalization::setLocale().
        ' as part2'
        ,'part3_'.LaravelLocalization::setLocale().
        ' as part3'
        ,'part4_'.LaravelLocalization::setLocale().
        ' as part4'
        ,'image2','image3','image4','created_at'
        )->get();






        $jobs=Job::where('title_ar',"like", "%" . $request->text . "%")->
        orwhere('title_en',"like", "%" . $request->text . "%")->
        orwhere('description_ar',"like", "%" . $request->text . "%")->
        orwhere('description_en',"like", "%" . $request->text . "%")
        ->select('id','title_'.LaravelLocalization::setLocale().
        ' as title'
        ,'description_'.LaravelLocalization::setLocale().
        ' as description'
       ,'created_at'
        )
        ->get();

        $faqs=Contact::where('subject',"like", "%" . $request->text . "%")->
        orwhere('message_ar',"like", "%" . $request->text . "%")->
        orwhere('message_en',"like", "%" . $request->text . "%")->
        orwhere('answer_ar',"like", "%" . $request->text . "%")->
        orwhere('answer_en',"like", "%" . $request->text . "%")->whereNotNull('answer_ar')->select('id','subject','message_'.LaravelLocalization::setLocale().
        ' as message','answer_'.LaravelLocalization::setLocale().
        ' as answer')->get();


        $result_count= count($news)+count($faqs)+count($jobs);

        $count=Count::first();
        $count->count=$count->count+1;
        $count->save();

         $header=Header_info::select('id','email','address_'.LaravelLocalization::setLocale().
        ' as address')->first();

        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','google','instgram','WhatsApp','phone','email','created_at'
        )->first();
         $counter=Count::first();
        $counter->count=$counter->count+1;
        $counter->save();
         $other=Other::first();
        return view('website.search',compact('other','result_count','news','faqs','jobs','header','footer','counter'));
    }
     public function ourteam(Request $request) {


        $footer=Footer:: select('id','content_'.LaravelLocalization::setLocale().
        ' as content','address_'.LaravelLocalization::setLocale().' as address'
        ,'facebook','twitter','google','instgram','WhatsApp','phone','email','created_at'
        )->first();
         $counter=Count::first();
        $counter->count=$counter->count+1;
        $counter->save();
         $other=Other::first();

           $teachers=Group::where('type',2)->paginate(12);
           $user=Group::where('type',1)->paginate(4);

        return view('website.ourteam',compact('other','footer','counter','user','teachers'));
    }


}
