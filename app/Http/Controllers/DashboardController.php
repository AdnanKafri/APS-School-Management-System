<?php

namespace App\Http\Controllers;

use File;
use ZipArchive as A;
use App\Backup;
use App\Classe;
use App\Stage;
use App\Lecture;
use App\About_us;
use App\About_us_website;
use App\Objection;
use App\Base_subjects;
use App\Exams2;
use App\Exam_result;
use App\Exam_result2;
use App\Certificate_Fields;
use App\Planification_trimestrielle;
use App\Prepare;
use App\Question;
use App\Room_lesson_exam;
use App\Section;
use App\Option;
use App\Supervisor_teacher_item;
use App\Acadsupervisor_teacher_item;
use App\Unit_analysis;
use App\Day;
use App\Exam_question;
use App\Exam_file;
use App\Stats;
use App\Event;
use App\Footer;
use App\Invoice;
use App\Teacher_event;
use App\Lecture_time;
use App\App_student_slider;
use App\Lesson;
use App\Modification_Request;
use App\Role;
use Illuminate\Support\Facades\Auth;
use App\Lesson_room_teacher_lecture_time;
use App\Lesson_teacher_room_term_exam;
use App\Message;
use App\Room;
use App\Other;
use App\More_details;
use App\Room_student;
use App\Student;
use App\Student_lesson_teacher_room_term_exam;
use App\Students_mark;
use App\Supervisor;
use App\Acadsupervisor;
use App\Supervisor_class_lesson;
use App\Supervisor_room_lesson;
use App\Acadsupervisor_class;
use App\Coordinator_class_lesson;
use App\Coordinator_room_lesson;
use App\Teacher;
use App\Teacher_room_lesson;
use App\User;
use App\Category;
use App\Student_schedule_tracer;
use App\Year;
use App\Coordinator;
use App\News;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use stdClass;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Shuttle_Dumper;
use Shuttle_Exception;
use App\Advantages;
use App\Student_detail;
use App\Student_register;
use App\Employee;
use App\Group;
use App\Chat;
use App\Library;
use App\Term_year;
use App\Contact;
use App\Image_Invoice;
use App\Job;
use App\Jobs\TestJob;
use App\Jobs\MessageJob;
use App\Jobs\Endyear;
use App\Certificate;
use App\Medal;
use Mail;
use DateTime;
use App\Slider;
use App\Gallery;
use App\Vision;
use App\Service;
use App\Our_services_feature;
use App\How_it_works_website;
use App\Counter_website;
use App\Testimonials;
use App\Blogs_website;
use App\Footer_website;
use App\Faqs_website;
use App\Contact_website;
use App\Mail\NewMail1;
use App\Applicant;
use App\Notification;
use App\Studentfcmtoken;
use App\Classes_Rooms_Roles;
use App\Report_card;
use App\Report_card_details;
use App\Imports\EmployeeImport;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


use App\Exports\StudentExport1;
use App\Exports\StudentExportArchive;
use App\Exports\TeacherExportArchive;
use App\Exports\TeacherExport;
use App\Exports\StudentExport_register;
use App\Imports\StudentImport;
use App\Imports\TeacherImport;
use Illuminate\Support\Facades\Artisan;
use App\Helpers;
//new
use App\Country_currency;
use App\School_staff;
use App\Staff_file;
use App\Class_cost;
//electronic section
use App\Electronic_file;
use App\Electronic_section;

use App\Rate;
//  المراحل
use App\Basic_stages_class;
use App\Basic_stage;
//  المشرف  ملفات
use App\Super_file;
use App\Construction_department;
use App\Department_detail;
use App\Student_details_department;
use App\Student_details_department_field;
use App\Student_details_field_value;
use App\Teacher_details_department;
use App\Teacher_details_department_field;
use App\Teacher_details_field_value;
use App\Rewards_and_sanction;
use App\Classes_room_role_exam;
use App\Classe_role_secret_keeper;
use App\Rewad_and_sanction_student;
use App\School_data;

use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{

  public function __construct()
    {

         // Assign to ALL methods in this Controller
        $this->middleware('roleadmin');
    }


    public function google_meet_add(Request $request)
    {

        $lecture_time = Lesson_room_teacher_lecture_time::findOrFail($request->lesson_time_id);

        if ($request->all) {

            $day = $lecture_time->day_id;
            $lecture_time1 = Lesson_room_teacher_lecture_time::where('room_id', $lecture_time->room_id)->where('day_id', $day)->get();
            foreach ($lecture_time1 as $item) {
                $item->meeting_link = $request->meeting_link;
                $item->save();
            }
        } else {
            $lecture_time->meeting_link = $request->meeting_link;
            $lecture_time->save();
        }

        // $this->validate($request, [
        //     'meeting_link' => 'required',
        // ],[
        //     'meeting_link.require' => 'يرجى إدخال الرابط',
        // ]);




        // return $lecture_time ;
        return redirect()->back()->with('success', 'تم التخزين بنجاح');
    }

     //صفحة اتمام مرحلة
    public function phase_completion_documents(){
        return view('admin.reports.phase_completion_documents');
    }
    //صفحة عرض طلاب اتمام مرحلة من التاسع للسابع
    public function phase_documents_students_7_to_9(){
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::whereIn('id', [7, 8, 9])->get();
        return view('admin.reports.phase_documents_students_7_to_9',compact('year2','classes'));
    }
    //صفحة عرض طلاب اتمام مرحلة الصف العاشر والحادي عشر
    public function phase_documents_students_10_to_11(){
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::whereIn('id', [10,11,16])->get();
        $student_detail = Student_detail::all();
        return view('admin.reports.phase_documents_students_10_to_11',compact('student_detail','year2','classes'));
    }
    //صفحة عرض طلاب اتمام مرحلة البكالوريا
    public function phase_documents_students_12(){
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::whereIn('id', [12,17])->get();
        return view('admin.reports.phase_documents_students_12',compact('year2','classes'));
    }

    //وثيقة اتمام مرحلة للصف التاسع للسابع
      public function student_phase($student_id){
       // $student=Student::with(['details','room.report_cards'=>fn($q1) =>
       // $q1->where('student_id',$student_id)])->find($student_id);
         $student=Student::with(['details'])->with(['room'=>function($q1) {
                    $year = Year::where('current_year','1')->first();
                    $q1->where('room_student.year_id',$year->id);
            }])->find($student_id);
        $date = Carbon::now();
        $date = $date->format('m/d/Y');
        return view('admin.reports.student_phase', compact('student', 'date'));
    }
    //وثيقة اتمام مرحلة للصف العاشر والحادي عشر
    public function student_phase_10($student_id){
    //$student=Student::with(['details','room.report_cards'=> fn($q1) =>
    //$q1->where('student_id',$student_id)])->find($student_id);
      $student=Student::with(['details'])->with(['room'=>function($q1) {
                    $year = Year::where('current_year','1')->first();
                    $q1->where('room_student.year_id',$year->id);
            }])->find($student_id);
    $student_detail = Student_detail::where('student_id', $student->id)->first();
    return view('admin.reports.student_phase_10_11', compact('student', 'student_detail'));
    }
     //وثيقة اتمام مرحلة للبكالوريا
    public function student_phase_12($student_id){
        //$student=Student::with(['details','room.report_cards'=>fn($q1) =>
        //$q1->where('student_id',$student_id)])->find($student_id);
          $student=Student::with(['details'])->with(['room'=>function($q1) {
                    $year = Year::where('current_year','1')->first();
                    $q1->where('room_student.year_id',$year->id);
            }])->find($student_id);
        $student_detail = Student_detail::where('student_id', $student->id)->first();
        return view('admin.reports.student_phase_12', compact('student', 'student_detail'));
        }



     //وثائق انتقال

    public function transfer_documents(){
        return view('admin.reports.transfer_documents');
    }
// طلاب وثيقة انتقال ثانوي
    public function secondary_transfer(){
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::whereIn('id',[10,11,12,16,17])->get();
        return view('admin.reports.secondary_transfer_students',compact('year2','classes'));
    }
    //طلاب وثيقة انتقال اساسي
    public function basic_transfer(){
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::whereIn('id',[1,2,3,4,5,6,7,8,9])->get();

        return view('admin.reports.basic_transfer_students',compact('year2','classes'));
    }
    //وثيقة انتقال المرحلة الاساسية
    public function basic_document($student_id)
    {
        //$student=Student::with(['details','room.report_cards'=>fn($q1) =>
        //$q1->where('student_id',$student_id)])->find($student_id);
         $student=Student::with(['details'])->with(['room'=>function($q1) {
                    $year = Year::where('current_year','1')->first();
                    $q1->where('room_student.year_id',$year->id);
            }])->find($student_id);
        $date = Carbon::now();
        $date = $date->format('m/d/Y');
        $year2 = Year::where('current_year', '1')->first();
        $report_card = Report_card::where('student_id', $student_id)->
        where('year_id', $year2->id)->first();
        return view('admin.reports.basic_document', compact('student', 'date','report_card'));
    }
    //وثيقة انتقال المراحلة الثانوية
    public function secoundry_document($student_id)
    {
       // $student=Student::with(['details','room.report_cards'=>fn($q1) =>
       // $q1->where('student_id',$student_id)])->find($student_id);
        $student=Student::with(['details'])->with(['room'=>function($q1) {
                    $year = Year::where('current_year','1')->first();
                    $q1->where('room_student.year_id',$year->id);
            }])->find($student_id);
        $date = Carbon::now();
        $date = $date->format('m/d/Y');
        return view('admin.reports.secondry_document_transfer', compact('student', 'date'));
    }


 //اضافة معلومات الى وثيقة انتقال الطالب للمرحلة الاساسية
    public function add_info_transfer_documents($student_id)
{
    //$student=Student::with(['details','room.report_cards'=>fn($q1) =>
    //$q1->where('student_id',$student_id)])->find($student_id);
     $student=Student::with(['details'])->with(['room'=>function($q1) {
                    $year = Year::where('current_year','1')->first();
                    $q1->where('room_student.year_id',$year->id);
            }])->find($student_id);
     $date = Carbon::now();
     $date = $date->format('m/d/Y');
    $year = Year::where('current_year', '1')->first();
    $student_detail = Student_detail::where('student_id', $student->id)->first();
    $class_id = $student->room[0]->classes->id;
    $rooms = Room::where('class_id', $class_id)->where('year_id', $year->id)->first();

    return view('admin.reports.add_basic_document', compact('rooms','year','student', 'date','student_detail'));

}
//اضافة معلومات لوثيقة انتقال المرحلة الثانوية
public function add_info_secondry_transfer_documents($student_id){
   // $student=Student::with(['details','room.report_cards'=>fn($q1) =>
   // $q1->where('student_id',$student_id)])->find($student_id);
    $student=Student::with(['details'])->with(['room'=>function($q1) {
                    $year = Year::where('current_year','1')->first();
                    $q1->where('room_student.year_id',$year->id);
            }])->find($student_id);
     $date = Carbon::now();
     $date = $date->format('m/d/Y');
    $year = Year::where('current_year', '1')->first();
    $student_detail = Student_detail::where('student_id', $student->id)->first();
    $class_id = $student->room[0]->classes->id;
    $rooms = Room::where('class_id', $class_id)->where('year_id', $year->id)->first();
    return view('admin.reports.add_secondry_document', compact('rooms','year','student', 'date','student_detail'));

}
// وحفظ معلومات الوثيقةالثانوية بصفحة اضافة معلومات وتخزينها بجدول تعديل طالب
public function student_update_secoundry_transfer_document(Request $request, $student_id){
    $year = Year::where('current_year', '1')->first();
   // $student=Student::with(['details','room.report_cards'=>fn($q1) =>
   // $q1->where('student_id',$student_id)])->find($student_id);
    $student=Student::with(['details'])->with(['room'=>function($q1) {
                    $year = Year::where('current_year','1')->first();
                    $q1->where('room_student.year_id',$year->id);
            }])->find($student_id);
    $student_detail = Student_detail::where('student_id', $student->id)->first();
        //new

    $student_detail->number_file = $request->number_file;
    $student_detail->status_cooperation = $request->status_cooperation;
    $student_detail->status_activity = $request->status_activity;
    $student_detail->status_books = $request->status_books;
    $student_detail->transfer_country = $request->transfer_country;
    $student_detail->transfer_school = $request->transfer_school;
    $student_detail->head_teacher = $request->head_teacher;
    $student_detail->date_seend = $request->date_seend;
    $student_detail->book1 = $request->book1;
    $student_detail->book_state1 = $request->book_state1;
    $student_detail->book2 = $request->book2;
    $student_detail->book_state2 = $request->book_state2;
    $student_detail->book3 = $request->book3;
    $student_detail->book_state3 = $request->book_state3;
    $student_detail->book4 = $request->book4;
    $student_detail->book_state4 = $request->book_state4;
    $student_detail->book5 = $request->book5;
    $student_detail->book_state5 = $request->book_state5;
    $student_detail->book6 = $request->book6;
    $student_detail->book_state6 = $request->book_state6;
    $student_detail->branch = $request->branch;
    $student_detail->behavior = $request->behavior;
    $student_detail->secret_keeper = $request->secret_keeper;
    $student_detail->days_absence = $request->days_absence;
    $student_detail->days_unabsence = $request->days_unabsence;
    $student_detail->leaving_school = $request->leaving_school;
    $student_detail->working_days = $request->working_days;
     $student_detail->number_document = $request->number_document;
    $student_detail->save();
    return redirect()->back()->with('success', '! تمت العملية بنجاح');
}

 //حفظ المعلومات يلي ع ضيفها من صفحة ااضافة ملعومات للوثيقة الاساسية بجدول تعديل طالب
public function student_update_transfer_document(Request $request, $student_id){
     $year = Year::where('current_year', '1')->first();
  //  $student=Student::with(['details','room.report_cards'=>fn($q1) =>
  //  $q1->where('student_id',$student_id)])->find($student_id);
   $student=Student::with(['details'])->with(['room'=>function($q1) {
                    $year = Year::where('current_year','1')->first();
                    $q1->where('room_student.year_id',$year->id);
            }])->find($student_id);
    $student_detail = Student_detail::where('student_id', $student->id)->first();
        //new
    $student_detail->number_file = $request->number_file;
    $student_detail->status_cooperation = $request->status_cooperation;
    $student_detail->status_activity = $request->status_activity;
    $student_detail->status_books = $request->status_books;
    $student_detail->transfer_country = $request->transfer_country;
    $student_detail->transfer_school = $request->transfer_school;
    $student_detail->head_teacher = $request->head_teacher;
    $student_detail->date_seend = $request->date_seend;
    $student_detail->book1 = $request->book1;
    $student_detail->book_state1 = $request->book_state1;
    $student_detail->book2 = $request->book2;
    $student_detail->book_state2 = $request->book_state2;
    $student_detail->book3 = $request->book3;
    $student_detail->book_state3 = $request->book_state3;
    $student_detail->book4 = $request->book4;
    $student_detail->book_state4 = $request->book_state4;
    $student_detail->book5 = $request->book5;
    $student_detail->book_state5 = $request->book_state5;
    $student_detail->book6 = $request->book6;
    $student_detail->book_state6 = $request->book_state6;
    $student_detail->branch = $request->branch;
    $student_detail->behavior = $request->behavior;
    $student_detail->secret_keeper = $request->secret_keeper;
    $student_detail->days_absence = $request->days_absence;
    $student_detail->days_unabsence = $request->days_unabsence;
    $student_detail->leaving_school = $request->leaving_school;
    $student_detail->working_days = $request->working_days;
    $student_detail->number_document = $request->number_document;
    $student_detail->save();
    return redirect()->back()->with('success', '! تمت العملية بنجاح');
   }





     //موظفين المدرسة
    public function school_staf(){
     $school_staf= School_staff::all();

    return view('admin.School_staff', compact('school_staf'));
}
    public function add_school_staff(Request $request){
          $school_staf= new School_staff;
        $school_staf->first_name = $request->first_name;
        $school_staf->last_name = $request->last_name;
        $school_staf->address = $request->address;
        $school_staf->phone = $request->phone;
        $school_staf->birth_date = $request->birth_date;
        $school_staf->salary = $request->salary;
        $school_staf->diseases = $request->diseases;
        $school_staf->business_register = $request->business_register;
        $school_staf->position = $request->position;
        if($request->hasFile('image')){
                    $school_staf->image = $request->image->store('staffimages', 'public');

        }

            if($request->hasFile('cv')){
            $school_staf->cv = $request->cv->store('staffimages', 'public');

        }
        $school_staf->save();
        return redirect()->back()->with('success', 'تم التخزين بنجاح');
    }
    public function school_staf_update (Request $request){
           $school_staf = School_staff::findOrFail($request->id);
       $school_staf->first_name = $request->first_name;
        $school_staf->last_name = $request->last_name;
        $school_staf->address = $request->address;
        $school_staf->phone = $request->phone;
        $school_staf->birth_date = $request->birth_date;
        $school_staf->salary = $request->salary;
        $school_staf->diseases = $request->diseases;
        $school_staf->business_register = $request->business_register;
        $school_staf->position = $request->position;

        if($request->hasFile('image')){
                    $school_staf->image = $request->image->store('staffimages', 'public');

        }

            if($request->hasFile('cv')){
            $school_staf->cv = $request->cv->store('staffimages', 'public');

        }

        $school_staf->save();
        return redirect()->back()->with('success', 'تم التعديل بنجاح');

    }

    public function delete_school_staff(Request $request){

        $school_staf = School_staff::findOrFail($request->id);
     if($school_staf->image!=null){
                 Storage::disk('public')->delete($school_staf->image);

     }

          if($school_staf->cv!=null){
                 Storage::disk('public')->delete($school_staf->cv);

     }

        $school_staf->delete();

        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
    //ملفات حضور الموظفين
    public function school_staff_files(Request $request, $id)
{
    $school_staf = School_staff::find($id);

    $staf_files = Staff_file::where('staf_id', $id)->get();

    return view('admin.school_staff_files', compact('school_staf', 'staf_files'));
}

public function add_staff_file(Request $request, $id)
{
    $school_staf = School_staff::find($id);
    $staf_files = new Staff_file;
    $staf_files->staf_id = $id;
    $staf_files->file_name = $request->file_name;
    if ($request->hasFile('file')) {
        $fileupload = $request->file('file');
        $fileName = Carbon::now()->format('Y-m-d') . '_' . str_replace(' ', '_', $fileupload->getClientOriginalName());
        $location = base_path("website/assets/files");
        $fileupload->move($location, $fileName);
        $staf_files->file = $fileName;
    }
    $staf_files->save();
    return redirect()->back()->with('success', 'تم التخزين بنجاح');
}

    public function delete_school_staff_file(Request $request){

        $school_staf = Staff_file::findOrFail($request->id);
        Storage::disk('public')->delete($school_staf->file);
        $school_staf->delete();
        $school_staf->delete();

        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
      //صفحة الملفات الالكترونية
        public function electronic_sections(){
      $electronic_sections= Electronic_section::with('classes')->get();
        $classes = Classe::all();
        return view('admin.electronic_sections', compact('electronic_sections','classes'));
    }
    public function add_electronic_sections(Request $request){
          if($request->class_id==0){
         return redirect()->back()->with('error', ' يرجى تحديد الصف ');
            }
        $electronic_sections= new Electronic_section;
        $electronic_sections->name_section = $request->name_section;
         $electronic_sections->class_id = $request->class_id;
        $electronic_sections->save();
        return redirect()->back()->with('success', 'تم التخزين بنجاح');
    }
    public function update_electronic_sections(Request $request){
       if($request->class_id==0){
         return redirect()->back()->with('error', ' يرجى تحديد الصف ');
            }
        $electronic_sections = Electronic_section::findOrFail($request->id);
        $electronic_sections->name_section = $request->name_section;
        $electronic_sections->class_id = $request->class_id;
        $electronic_sections->save();
        return redirect()->back()->with('success', 'تم التعديل بنجاح');

    }

    public function delete_electronic_sections(Request $request){

        $electronic_sections = Electronic_section::findOrFail($request->id);
        $electronic_sections->name_section = $request->name_section;
        $electronic_sections->class_id = $request->class_id;
        //$electronic_sections->file_title = $request->file_title;

        // if ($request->has('file')){
        //     $fileupload = $request->file('file');
        //     $fileName = Carbon::now()->format('Y-m-d') . '_' . str_replace(' ', '_', $fileupload->getClientOriginalName());
        //     $location = base_path("website/assets/" . 'files');
        //     $fileupload->delete($location, $fileName);
        // }

        $electronic_sections->delete();

        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
//ملفات المكتبة الالكترونية
public function school_electronic_files(Request $request, $id)
{
    $electronic_sections = Electronic_section::find($id);
    $electronic_files = Electronic_file::where('section_id', $id)->get();
    return view('admin.electronic_section_files', compact('electronic_sections', 'electronic_files'));
}

public function add_electronic_file(Request $request, $id)
{


    $electronic_sections = Electronic_section::find($id);
    $electronic_files = new Electronic_file;
    $electronic_files->section_id = $id;
    $electronic_files->file_name = $request->file_name;
     $electronic_files->link = $request->link;
    if ($request->hasFile('file')) {
        $fileupload = $request->file('file');
        $fileName = Carbon::now()->format('Y-m-d') . '_' . str_replace(' ', '_', $fileupload->getClientOriginalName());
        $location = base_path("website/assets/files");
        $fileupload->move($location, $fileName);
        $electronic_files->file = $fileName;
    }
    $electronic_files->save();
    ini_set("max_execution_time", "-1");
            ini_set("max_file_uploads", "2000M");
            ini_set("max_input_time", "10000000000000");
            ini_set("memory_limit", "10000000000000M");
            ini_set('post_max_size', '50000000000000M');
            ini_set('upload_max_filesize', '500000000000000M');
     $term = Term_year::where('current_term', '1')->first();
      $electronic_sections = Electronic_section::find($id);
   $rooms = Room::with('student')->where('class_id', $electronic_sections->class_id)->get();
   foreach($rooms as $room){
         $students = $room->student;
    foreach($students as $student){

        $noti = new Notification;
        $noti->user_id = Auth::user()->id;
        $noti->student_id = $student->id;
        $noti->room_id = $id;
        $noti->title ="تم اضافة  ملف مكتبة الكترونية ";
        $noti->body =  $request->file_name;
        $noti->term_id = $term->id;
        $noti->type = 12;
        $noti->save();
        $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
        $devices = array();
         foreach($tokens as $t){
            array_push($devices, $t['s_fcm_token']);

        }
    $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,$id,1, 1,$devices);

    }
   }


    return redirect()->back()->with('success', 'تم التخزين بنجاح');
}

    public function delete_electronic_file(Request $request){

        $electronic_files = Electronic_file::findOrFail($request->id);
        Storage::disk('public')->delete($electronic_files->file);
        $electronic_files->delete();
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

//صفحة الدول والعملات
    public function countries_currencies(){
        $countries_currencies = Country_currency::all();
        return view('admin.countries_currencies',compact('countries_currencies'));
    }
     public function add_countries_currencies(Request $request){
      $countries_currencies = new Country_currency;
      $countries_currencies->name_en = $request->name_en;
      $countries_currencies->name_ar = $request->name_ar;
      $countries_currencies->active ='1';
      $countries_currencies->key_country = $request->key_country;
      $countries_currencies->currency_country = $request->currency_country;
      $countries_currencies->save();
      return redirect()->back()->with('success', 'تم التخزين بنجاح');
     }

     public function update_countries_currencies(Request $request){

        $countries_currencies =Country_currency::find($request->id);

      if ($countries_currencies) {

    $countries_currencies->name_en = $request->name_en;
    $countries_currencies->name_ar = $request->name_ar;
    $countries_currencies->key_country = $request->key_country;
    $countries_currencies->currency_country = $request->currency_country;


    $countries_currencies->save();


    return redirect()->back()->with('success', 'تم التعديل بنجاح');
     } else {

    return redirect()->back()->with('error', 'لم يتم العثور على العنصر');
}

}

public function countries_currencies_archive($id)
{
    $countries_currencies = Country_currency::find($id);
    $countries_currencies->active = $countries_currencies->active ? 0 : 1;
    $countries_currencies->save();

    return redirect()->back()->with('success', 'تم التعديل بنجاح');


}


    public function library()
    {
        $classes = Classe::paginate(paginate_num);
        $count = Classe::count();
        return view('admin.library_classes', compact('classes', 'count'));
    }
    public function library_class_videos($class_id)
    {

        $class_videos = Library::with('classe', 'teacher')->where('class_id', $class_id)->paginate(paginate_num);
        $count = Library::where('class_id', $class_id)->count();
        $teachers = Teacher::whereHas('rooms.classes', function ($query) use ($class_id) {
            $query->where('id', $class_id);
        })->get();


        return view('admin.library_class_videos', compact('class_videos', 'count', 'teachers', 'class_id'));
    }

    public function library_video_store(Request $request)
    {

        $validatedData = $request->validate([
            'class_id' => 'required',
            'teacher_id' => 'required',
            'name' => 'required',
            // 'type' => 'required',
            'file' => 'required',
        ], [
            'class_id.required' => 'يرجي   تحديد الصف الدراسي',
            'teacher_id.required' => 'يرجي  تحديد المدرس ',
            'name.required' => 'يرجي ادخال عنوان الفيديو ',
            'file.required' => 'يرجي تحديد فيديو   ',
        ]);
        $library = new Library;
        $library->class_id = $request->class_id;
        $library->teacher_id = $request->teacher_id;
        $library->name = $request->name;
        $library->type = 1; // video
        if ($request->hasFile('file')) {
            $library->file = $request->file->store('libraryVideos', 'public');
            $library->extension =  $request->file->extension();
        }
        $library->save();
        return redirect()->back()->with('success', 'تم التخزين بنجاح');
    }


    public function library_video_update(Request $request)
    {

        $validatedData = $request->validate([
            'file_id' => 'required',
            'class_id' => 'required',
            'teacher_id' => 'required',
            'name' => 'required',
            // 'type' => 'required',

        ], [
            'class_id.required' => 'يرجي   تحديد الصف الدراسي',
            'teacher_id.required' => 'يرجي  تحديد المدرس ',
            'name.required' => 'يرجي ادخال عنوان الفيديو ',

        ]);
        $library = Library::findOrFail($request->file_id);
        $library->class_id = $request->class_id;
        $library->teacher_id = $request->teacher_id;
        $library->name = $request->name;
        $library->type = 1; // video
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($library->file);
            $library->file = $request->file->store('libraryVideos', 'public');
            $library->extension =  $request->file->extension();
        }
        $library->save();
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function library_video_delete(Request $request)
    {
        $library = Library::findOrFail($request->file_id);
        Storage::disk('public')->delete($library->file);
        if (isset($library)) {
            Storage::disk('public')->delete($library->file);
            $library->delete();
        }

        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function get_teacher_subjects($teacher_id)
    {

        $lessons = Teacher::with(['lessons' => fn ($q1) => $q1->select('lessons.id', 'name')])->find($teacher_id);
        return response()->json([
            'lessons' => $lessons
        ]);
    }



    public function objection()
    {

        $objection = Objection::paginate();
        $count = Objection::count();
        $classes = Classe::all();
        $year2 = Year::where('current_year', '1')->first();
        return view('admin.objections', compact('year2', 'classes', 'count', 'objection'));
    }
    //الفصول
    public function terms()
    {

        $terms = Term_year::paginate();
        $count = Term_year::count();
        $years = Year::all();
        return view('admin.terms', compact('terms', 'count', 'years'));
    }
    public function year()
    {

        $terms = Year::paginate();
        $all_years = Year::all();
        $count = Year::count();

        return view('admin.year', compact('terms', 'count', 'all_years'));
    }


    public function term_store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:20',
            'year_id' => 'required|numeric',
        ]);
        if ($request->current_term    == 1) {
            $term1 = Term_year::where('current_term', 1)->first();
            if ($term1) {
                $term1->current_term = 0;
                $term1->save();
            }
        }

        $term = new Term_year();
        $term->term = $request->name;
        $term->start = $request->start;
        $term->end = $request->end;
        $term->type = $request->type;

        if ($request->current_term) {

            $term->current_term    = $request->current_term;
        }

        $term->year_id = $request->year_id;
        $term->save();


        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function term_update(Request $request)
    {
        $request->validate([

            'name' => 'required|max:20',
            'year_id' => 'required|numeric',
        ]);
        if ($request->current_term == 1) {
            $term1 = Term_year::where('current_term', 1)->first();
            if ($term1) {
                $term1->current_term = 0;
                $term1->save();
            }
        }

        $term = Term_year::find($request->term_id);
        $term->term = $request->name;
        $term->start = $request->start;
        $term->end = $request->end;
        $term->type = $request->type;

        if ($request->current_term) {

            $term->current_term    = $request->current_term;
        }

        $term->year_id = $request->year_id;
        $term->save();


        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function year_store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:20',
            'next_year' => 'required',
        ]);
        if ($request->current_year    == 1) {
            $term1 = Year::where('current_year', 1)->first();
            if ($term1) {
                $term1->current_year = 0;
                $term1->save();
            }
        }

        $term = new Year();
        $term->name = $request->name;
        $term->start = $request->start;
        $term->end = $request->end;
        $term->next_year = $request->next_year;


        if ($request->current_year) {

            $term->current_year    = $request->current_year;
        }


        $term->save();


        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function year_update(Request $request)
    {

        $request->validate([

            'name' => 'required|max:20',
            'next_year' => 'required',

        ]);

        if ($request->current_year == 1) {

            $term1 = Year::where('current_year', 1)->first();
            if ($term1) {
                $term1->current_year = 0;
                $term1->save();
            }
        }

        $term = Year::find($request->term_id);
        $term->name = $request->name;
        $term->start = $request->start;
        $term->end = $request->end;
        $term->next_year = $request->next_year;


        if ($request->current_year) {
            $term->current_year    = $request->current_year;
            $term1 = Term_year::where('current_term', 1)->where('id', '!=', $request->current_term)->first();
            if ($term1) {
                $term1->current_term = 0;
                $term1->save();
            }
            $term_year = Term_year::findOrFail($request->current_term);
            $term_year->current_term = 1;
            $term_year->save();
        }


        $term->save();


        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function getyear_terms(Request $request)
    {
        $terms = Term_year::where('year_id', $request->year_id)->get();
        return $terms;
    }

    public function getyear(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $search_bar = $request->barcode_pos_check;


        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = Year::count();
        $totalRecordswithFilter = Year::where('name', "like", "%" . $result_search . "%")->count();
        $records = Year::where('name', "like", "%" . $result_search . "%")->skip($start)->take($rowperpage)->get();


        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "name" => $record->name,
                "id" => $record->id,
                "current_term" => $record->current_year,
                "next_year" => $record->next_year,
                "start" => $record->start,
                "end" => $record->end,

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


    public function getobj(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $search_bar = $request->barcode_pos_check;
        $class_filter = $request->classes;
        $room_filter = $request->rooms;

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = Objection::count();

        $totalRecordswithFilter = Objection::with('room.classes')->with('room')->with('lesson')->with('teacher')->with(['student' => function ($q) use ($result_search) {


            $q->where('first_name', "like", "%" . $result_search . "%")->orwhere('last_name', "like", "%" . $result_search . "%");
        }])->whereHas('room.classes', function ($q) use ($class_filter, $room_filter) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
        })->count();
        $records = Objection::with('room.classes')->with('room')->with('lesson')->with('teacher')->with(['student' => function ($q) use ($result_search) {


            $q->where('first_name', "like", "%" . $result_search . "%")->orwhere('last_name', "like", "%" . $result_search . "%");
        }])->whereHas('room.classes', function ($q) use ($class_filter, $room_filter) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
        })->skip($start)->take($rowperpage)->get();





        $data_arr = array();
        foreach ($records as $record) {
            if ($record->student) {
                $data_arr[] = array(
                    "id" => $record->id,
                    "name" => $record->note,
                    "type" => $record->type,
                    "student_first_name" => $record->student->first_name,
                    "student_last_name" => $record->student->last_name,
                    "room_name" => $record->room->name,
                    "lesson" => $record->lesson->name,
                    "classe_name" => $record->room->classes->name,
                    "teacher_first_name" => $record->teacher->first_name,

                    "teacher_last_name" => $record->teacher->last_name,
                    "created" => $record->created_at,


                );
            }
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

    public function getterm(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $search_bar = $request->barcode_pos_check;


        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = Term_year::count();
        $totalRecordswithFilter = Term_year::where('term', "like", "%" . $result_search . "%")->count();
        $records = Term_year::where('term', "like", "%" . $result_search . "%")->with('year')->skip($start)->take($rowperpage)->get();


        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "name" => $record->term,
                "id" => $record->id,
                "current_term" => $record->current_term,
                "type" => $record->type,
                "start" => $record->start,
                "end" => $record->end,

                "year" => $record->year,
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
    // جلب الصفوف لاستصدار الجلاءات
    public function classes_graduation()
    {
         $current_year = Year::where('current_year', '1')->first();
        $next_year = Year::where('id', $current_year->next_year)->first();
        $classes = Classe::with(['report_card_details' => fn ($q)  => $q->where('year_id', $current_year->id)])->paginate(paginate_num);
        $all_classes = Classe::with(['report_card_details' => fn ($q)  => $q->where('year_id', $current_year->id)])->get();
        $stages = Stage::all();
        $count = Classe::count();
         $jobcount=DB::table('jobs')->where('queue','second')->count();

        return view('admin.graduation_classes', compact('jobcount','classes', 'count', 'stages', 'all_classes', 'next_year'));
    }


    // جلب الشعب لاستصدار الجلاءات
    public function classroom_graduate($id)
    {

        $year = Year::where('current_year', '1')->first();
        $rooms = Room::where('class_id', $id)->where('year_id', $year->id)->paginate(paginate_num);
        $count = Room::count();
        $class_id = $id;
        $years = Year::all();
        return view('admin.graduation_rooms', compact('rooms', 'count', 'class_id', 'years'));
    }
    public function certificate_fields()
    {
        return view('admin.certificate_fields ');
    }
    public function ncertificaate()
    {
        $certificate = Certificate_Fields::where('type', 4)->first();
        return view('admin.ncertificaate.index ', compact('certificate'));
    }
    public function newcertificaate()
    {
        $certificate = Certificate_Fields::where('type', 2)->first();
        return view('admin.new.index ', compact('certificate'));
    }
    public function new2()
    {
        $certificate = Certificate_Fields::where('type', 7)->first();
        return view('admin.new2.index ', compact('certificate'));
    }
    public function new3()
    {
        $certificate = Certificate_Fields::where('type', 8)->first();
        return view('admin.new3.index ', compact('certificate'));
    }


    public function new231()
    {
        $certificate = Certificate_Fields::where('type', 1)->first();
        return view('admin.new231.index ', compact('certificate'));
    }
    public function new44()
    {
        $certificate = Certificate_Fields::where('type', 3)->first();
        return view('admin.new44.index ', compact('certificate'));
    }
    public function certificate_2()
    {
        $certificate = Certificate_Fields::where('type', 6)->first();
        return view('admin.certificate_2.index ', compact('certificate'));
    }

    public function newcerti()
    {
        $certificate = Certificate_Fields::where('type', 5)->first();
        return view('admin.newcerti.index ', compact('certificate'));
    }
    public function certificate_details($type)
    {
        $certificate = Certificate_Fields::where('type', $type)->first();
        return view('admin.certificate_details ', compact('certificate'));
    }
    public function certificate_update(Request $request)
    {
        $certificate = Certificate_Fields::find($request->id);
        $certificate->name = $request->name;
        $certificate->title = $request->title;
        $certificate->school_name = $request->school_name;
        $certificate->text1 = $request->text1;
        $certificate->text2 = $request->text2;
        $certificate->school_manager = $request->school_manager;
        $certificate->chairman = $request->chairman;

        if ($request->hasFile('barcode')) {

            $certificate->barcode = $request->barcode->store('filesteachers', 'public');
        } else {
            $certificate->barcode = $certificate->barcode;
        }
        if ($request->hasFile('logo')) {

            $certificate->logo = $request->logo->store('filesteachers', 'public');
        } else {
            $certificate->logo = $certificate->logo;
        }

        $certificate->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }


    public function room_student_graduate($room_id)
    {
        $year = Year::where('current_year', '1')->first();
        if(in_array("student_hidden", Auth::user()->role->permissions)){
            $students = Room_student::where('room_id', $room_id)->where('year_id', $year->id)->get();
        $room = Room::findOrFail($room_id) ;
        $class_id = $room->class_id ;
        $reportCardDetails = Report_card_details::where('year_id',$year->id)->where('class_id',$class_id)->first();
        $adjustable = isset($reportCardDetails) ? $reportCardDetails->report_card_status : 0;
        $a = [];
        foreach ($students as $student) {
            $a[] = $student->student_id;

            $reportCardExists = Report_card::where('student_id', $student->student_id)
            ->where('year_id', $year->id)
            ->exists();
            $report_card = Report_card::where('student_id', $student->id)->where('room_id', $room_id)->where('year_id', $year->id)->first();
            if (!isset($report_card)) {
                $this->make_student_report_card($student->id, $room_id, $year->id);
            }
              // If no report card exists, call the helper function to create a new report card
            //   $this->make_student_report_card($student->id,$room_id,$year->id,$adjustable );

            // if (!$reportCardExists) {
            //     Helpers\makeStudentReportCard($studentId, $room_id,  $year->id, $adjustable);
            // }
        }

        $students = Student::with(['report_card' => function ($q1) use ($year) {
            $q1->where('report_cards.year_id', $year->id);
        }])->whereIn('id', $a)->where('hidden',0)->orderBy('first_name')->get();
        }
        else{
            $students = Room_student::where('room_id', $room_id)->where('year_id', $year->id)->get();
            $room = Room::findOrFail($room_id) ;
            $class_id = $room->class_id ;
            $reportCardDetails = Report_card_details::where('year_id',$year->id)->where('class_id',$class_id)->first();
            $adjustable = isset($reportCardDetails) ? $reportCardDetails->report_card_status : 0;
            $a = [];
            foreach ($students as $student) {
                $a[] = $student->student_id;

                $reportCardExists = Report_card::where('student_id', $student->student_id)
                ->where('year_id', $year->id)
                ->exists();
                $report_card = Report_card::where('student_id', $student->id)->where('room_id', $room_id)->where('year_id', $year->id)->first();
            if (!isset($report_card)) {
                $this->make_student_report_card($student->id, $room_id, $year->id);
            }
                  // If no report card exists, call the helper function to create a new report card
                //   $this->make_student_report_card($student->id,$room_id,$year->id,$adjustable );

                // if (!$reportCardExists) {
                //     Helpers\makeStudentReportCard($studentId, $room_id,  $year->id, $adjustable);
                // }
            }

            $students = Student::with(['report_card' => function ($q1) use ($year) {
                $q1->where('report_cards.year_id', $year->id);
            }])->whereIn('id', $a)->orderBy('first_name')->get();
        }

        // return $students;
        $count = count($students);
        $classes = Classe::all();
        $years = Year::all();
        $room = Room::find($room_id);
        $room_name = $room->name;
        $class_name = $room->classes->name;
        $actual_attendance = $room->classes->actual_attendance;
        $year = Year::where('current_year', '1')->first();
        $report_card_details = Report_card_details::where('class_id', $room->classes->id)->where('year_id', $year->id)->first();


        return view('admin.graduation_student_details', compact('room', 'students', 'count', 'classes', 'years', 'room_name', 'class_name', 'report_card_details'));
        // return view('admin.graduation_student_room',compact('room','students','count','classes','years','room_name','class_name','actual_attendance'));
    }
    // approve single_student_graduate
    public function single_student_graduate(Request $request)
    {
        return 1515;

        return view('admin.certificate_first_grade', compact('room', 'students', 'count', 'classes', 'years', 'room_name', 'class_name'));
    }


    public function view_single_student_graduate(Request $request)
    {

        // $year=Year::where('current_year','1')->first();

        $student_id = $request->student_id;

        $student_marks = Students_mark::where('year_id', $request->year_id)
            // ->where('student_id',32)
            ->where('student_id', $student_id)
            ->first();
        if (!isset($student_marks)) {
            return redirect()->back()->with('error', 'الطالب لايملك سجل في العام المختار');
        }
        $year = Year::findOrFail($request->year_id);
        // current_term : 1 => first term, 2 => second term
        $current_term = Term_year::where('current_term', 1)->where('year_id', $year->id)->first();
        $current_term = isset($current_term) ? $current_term->type : 1;
        $student = Student::with(['room' => function ($q1) use ($year) {
            $q1->where('rooms.year_id', $year->id);
        }])->findOrFail($student_id);
        $lessons = ' ';
        // $lessons_id = $student->room()->with('lessons')->first()->lessons->unique()->pluck('id')  ;
        // $lessons = Lesson::with('mark_base_subject')->whereIn('id',$lessons_id)->orderBy('certificate_order','asc')->get() ;

        $room = $student->room[0];
        $room_id = $room->id;
        $room_students = Room::find($room_id)->student()->orderBy('first_name')->pluck('students.id')->toArray();

        $serial_number = $this->get_student_serial_num($student_id);
        $student->serial_number = $serial_number;
        $room_name = $room->name;
        $class_id = $room->class_id;
        $class = Classe::with('next_class_success')->findOrFail($class_id);
        $class_name = $class->name;
        $stage_id = $class->stage_id;
        $report_card_design = $class->report_card;
        $className = '' ;
        if ($report_card_design > 4 ){
            $className = $this->getClassName($report_card_design) ;
        }
        $report_card_details = Report_card_details::where('class_id', $class->id)->where('year_id', $year->id)->first();
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
        $student_rigistration_term = 1 ; // we assumed that all students came in first term>>




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
            ->with(['lessons_mark' => function ($q) use ($class) {
                $q->where('class_id', $class->id);


            }])
            ->get()->sortBy('lessons_mark2.certificate_order')->flatten(1);

        $year_name = $year->name;
        // $student_marks = Students_mark::where('year_id',$year->id)->
        //                                 where('student_id',$student_id)->
        //                                 where('room_id',$room_id)->first() ;
        $report_card = Report_card::where('student_id', $student_id)->where('year_id', $year->id)->first();
        $teacher_name = '';

        if ($stage_id == 1 || $stage_id == 2) {
            // $lessons = $student->room()->with('lessons')->first()->lessons->unique()  ;
            $lessons = Lesson::where('class_id', $class->id)->get();
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

        if ($report_card->adjustable == 0) {
            $current_term = 0;
        } elseif ($report_card->adjustable == 1) {
            $current_term = 1;
        } elseif ($report_card->adjustable == 2) {
            $current_term = 2;
        }
        $year_current=Year::where('current_year','1')->first();
        if($year_current->id != $request->year_id){
            $current_term = 2 ;
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
            return view('admin.certificate_third_grade_12_test1', compact('current_term', 'student', 'room', 'class', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'report_card_details', 'student_rigistration_term','className'));
        }
        else if (in_array($class->report_card,  [11,12] )) {
            // من أجل اللغة العربية لأنها مؤلفة من مادة المهارات الشفوية ومادة المهارات الكتابية
            $addable_lessons = Lesson::where('class_id', $class->id)->where('is_addable',0)->orderBy('certificate_order')->get();
            return view('admin.certificate_B_1', compact('current_term', 'student', 'room', 'class', 'class_name', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'addable_lessons', 'teacher_name', 'report_card_details', 'student_rigistration_term'));
        }
        else if ($class->report_card   == 13 ) {
            // من أجل اللغة العربية لأنها مؤلفة من مادة المهارات الشفوية ومادة المهارات الكتابية
            $addable_lessons = Lesson::where('class_id', $class->id)->where('is_addable',0)->orderBy('certificate_order')->get();
            return view('admin.certificate_B_3', compact('current_term', 'student', 'room', 'class', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'addable_lessons', 'teacher_name', 'report_card_details', 'student_rigistration_term'));
        }
         else if ($class->report_card   == 14) {
             return view('admin.certificate_B_4', compact('current_term', 'student', 'room', 'class', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'report_card_details', 'student_rigistration_term'));
        }



        else {
            $addable_lessons = Lesson::where('class_id', $class->id)->orderBy('certificate_order')->get();
            // return view('admin.certificate_first_grade3',compact('current_term','student','room','class','stage_id','year_name','room_name','lessons','student_marks','mark_base_subjects','report_card','addable_lessons','report_card_details'));
            return view('admin.certificate_third_grade_7_8_updated', compact('current_term', 'student', 'room', 'class', 'stage_id', 'year_name', 'room_name', 'lessons', 'student_marks', 'mark_base_subjects', 'report_card', 'report_card_details', 'student_rigistration_term'));
        }
    }
    public function save_report_card(Request $request)
    {
        $student_id = $request->student_id;
        $year = Year::where('current_year', '1')->first();
        $student = Student::with(['room' => function ($q1) use ($year) {
            $q1->where('rooms.year_id', $year->id);
        }])->findOrFail($student_id);
        if ($request->stage_id == 1 || $request->stage_id == 2) {

            $lessons = $student->room()->with('lessons')->first()->lessons->unique();
            foreach ($lessons as $lesson) {
                if ($lesson->is_addable == 0) {
                    $teacher_id = Teacher_room_lesson::where('lesson_id', $lesson->id)->where('room_id', $student->room[0]->id)->first()->teacher_id;
                    $teacher = Teacher::findOrFail($teacher_id);
                }
            }
        }

        // for both term1 and term2;
        $teacher_notes = new stdClass();
        $student_attendance = new stdClass();
        $actual_attendance     = new stdClass();
        $justified_absence    = new stdClass();
        $unjustified_absence    = new stdClass();

        $teacher_notes->{'term1'} = $request->teacher_notes1;
        $teacher_notes->{'term2'} = $request->teacher_notes2;

        $student_attendance->{'term1'} = $request->student_attendance1;
        $student_attendance->{'term2'} = $request->student_attendance2;

        $actual_attendance->{'term1'} = $request->actual_attendance1;
        $actual_attendance->{'term2'} = $request->actual_attendance2;

        $justified_absence->{'term1'} = $request->justified_absence1;
        $justified_absence->{'term2'} = $request->justified_absence2;

        $unjustified_absence->{'term1'} = $request->unjustified_absence1;
        $unjustified_absence->{'term2'} = $request->unjustified_absence2;

        $report_cards = Report_card::where('student_id', $student_id)->where('year_id', $year->id)->first();
        if (isset($report_cards)) {

            $report_cards->room_id = $student->room[0]->id;
            $report_cards->year_id = $year->id;
            if (isset($teacher))
                $report_cards->teacher = $teacher->first_name . ' ' . $teacher->last_name;
            $report_cards->student_id = $student_id;
            $report_cards->teacher_notes = json_encode($teacher_notes);
            $report_cards->manager_notes = $request->manager_notes;
            $report_cards->final_result = $request->final_result;
            $report_cards->student_attendance = json_encode($student_attendance);
            $report_cards->actual_attendance = json_encode($actual_attendance);
            $report_cards->justified_absence = json_encode($justified_absence);
            $report_cards->unjustified_absence = json_encode($unjustified_absence);
        } else {
            $report_cards = new Report_card;

            $report_cards->room_id = $student->room[0]->id;
            $report_cards->year_id = $year->id;
            if (isset($teacher))
                $report_cards->teacher = $teacher->first_name . ' ' . $teacher->last_name;
            $report_cards->student_id = $student_id;
            $report_cards->teacher_notes = json_encode($teacher_notes);
            $report_cards->manager_notes = $request->manager_notes;
            $report_cards->final_result = $request->final_result;
            $report_cards->student_attendance = json_encode($student_attendance);
            $report_cards->actual_attendance = json_encode($actual_attendance);
            $report_cards->justified_absence = json_encode($justified_absence);
            $report_cards->unjustified_absence = json_encode($unjustified_absence);
        }
        $report_cards->save();

        return redirect()->back()->with('success', 'تم التخزين بنجاح');
    }


    public function store_report_card_details(Request $request)
    {
 


        $student_id = $request->student_id;
        $year = Year::where('current_year', '1')->first();
        $student = Student::with(['room' => function ($q1) use ($year) {
            $q1->where('rooms.year_id', $year->id);
        }])->findOrFail($student_id);
     $report_card_details = Report_card_details::where('class_id', $request->class_id)->where('year_id', $year->id)->first();
        if($report_card_details){

          $actual_attendance10=  $report_card_details->actual_attendance;

          foreach(json_decode($actual_attendance10) as $key=>$item){
              if($key=="term1"){

                  if($request->student_attendance1 > $item  ){

                         Session::flash('error', " لايمكن وضع قيمة اعلى من الدوام الفعليئ للفصل الاول   ");
                        return redirect()->back()->with('error', '  لايمكن وضع قيمة اعلى من الدوام الفعلي للفصل الاول ');
                  }
              }
             if($key=="term2"){
                  if($request->student_attendance2 > $item ){
                        Session::flash('error', " لايمكن وضع قيمة اعلى من الدوام الفعليئ للفصل الثاني   ");
                      return redirect()->back()->with('error', '  لايمكن وضع قيمة اعلى من الدوام الفعلي للفصل الثاني ');
                  }
              }



          }
        }
        $teacher_notes = new stdClass();
        $student_attendance = new stdClass();
        $actual_attendance     = new stdClass();
        $justified_absence    = new stdClass();
        $unjustified_absence    = new stdClass();

        $teacher_notes->{'term1'} = $request->teacher_notes1;
        $teacher_notes->{'term2'} = $request->teacher_notes2;

        $student_attendance->{'term1'} = $request->student_attendance1;
        $student_attendance->{'term2'} = $request->student_attendance2;

        $actual_attendance->{'term1'} = $request->actual_attendance1;
        $actual_attendance->{'term2'} = $request->actual_attendance2;

        $justified_absence->{'term1'} = $request->justified_absence1;
        $justified_absence->{'term2'} = $request->justified_absence2;

        $unjustified_absence->{'term1'} = $request->unjustified_absence1;
        $unjustified_absence->{'term2'} = $request->unjustified_absence2;

         $report_cards = Report_card::where('student_id', $student_id)->where('year_id', $year->id)->first();
        if (isset($report_cards)) {
            $report_cards->room_id = $student->room[0]->id;
            $report_cards->year_id = $year->id;

            $report_cards->student_id = $student_id;
            $report_cards->manager_notes = $request->manager_notes;
            $report_cards->teacher_notes = json_encode($teacher_notes);
            $report_cards->student_attendance = json_encode($student_attendance);
            $report_cards->actual_attendance = json_encode($actual_attendance);
            $report_cards->justified_absence = json_encode($justified_absence);
            $report_cards->unjustified_absence = json_encode($unjustified_absence);
        } else {
            $report_cards = new Report_card;

            $report_cards->room_id = $student->room[0]->id;
            $report_cards->year_id = $year->id;
            $report_cards->student_id = $student_id;
            $report_cards->manager_notes = $request->manager_notes;
            $report_cards->teacher_notes = json_encode($teacher_notes);
            $report_cards->student_attendance = json_encode($student_attendance);
            $report_cards->actual_attendance = json_encode($actual_attendance);
            $report_cards->justified_absence = json_encode($justified_absence);
            $report_cards->unjustified_absence = json_encode($unjustified_absence);
        }

        $report_cards->save();


        return redirect()->back()->with('success', 'تم التخزين بنجاح');
    }


    public function set_actual_attendance(Request $request)
    {
        $classes_id = $request->class_id;
        if (in_array(0, $request->class_id)) {
            $classes = Classe::all();
            $classes_id = [];
            foreach ($classes as $class) {
                array_push($classes_id, $class->id);
            }
        }
        $year = Year::where('current_year', '1')->first();
        foreach ($classes_id as $class_id) {

            $report_card_details = Report_card_details::where('class_id', $class_id)->where('year_id', $year->id)->first();

            if (isset($report_card_details)) {
                $actual_attendance =  json_decode($report_card_details->actual_attendance);
                $actual_attendance->{'term1'} = isset($request->actual_attendance1) ? $request->actual_attendance1 : $actual_attendance->term1;
                $actual_attendance->{'term2'} = isset($request->actual_attendance2) ? $request->actual_attendance2 : $actual_attendance->term2;

                $report_card_date =  json_decode($report_card_details->report_card_date);
                if (isset($report_card_date->term1)) {
                    $report_card_date->{'term1'} = isset($request->report_card_date_term1) ? $request->report_card_date_term1 : $report_card_date->term1;
                    $report_card_date->{'term2'} = isset($request->report_card_date_term2) ? $request->report_card_date_term2 : $report_card_date->term2;
                } else {
                    $report_card_date = new stdClass();
                    $report_card_date->{'term1'} = $request->report_card_date_term1;
                    $report_card_date->{'term2'} = $request->report_card_date_term2;
                }

                $report_card_details->year_id = $year->id;
                $report_card_details->class_id = $class_id;
                $report_card_details->actual_attendance = json_encode($actual_attendance);
                $report_card_details->manager_name = isset($request->manager_name) ? $request->manager_name : $report_card_details->manager_name;
                $report_card_details->instructor_name = isset($request->instructor_name) ? $request->instructor_name : $report_card_details->instructor_name;
                //   $report_card_details->report_card_date =  isset($request->report_card_date) ? $request->report_card_date : $report_card_details->report_card_date;
                $report_card_details->report_card_date =  json_encode($report_card_date);
            } else {
                $actual_attendance = new stdClass();
                $actual_attendance->{'term1'} = $request->actual_attendance1;
                $actual_attendance->{'term2'} = $request->actual_attendance2;

                $report_card_date = new stdClass();
                $report_card_date->{'term1'} = $request->report_card_date_term1;
                $report_card_date->{'term2'} = $request->report_card_date_term2;

                $report_card_details = new  Report_card_details;
                $report_card_details->year_id =  $year->id;
                $report_card_details->class_id = $class_id;
                $report_card_details->actual_attendance = json_encode($actual_attendance);
                $report_card_details->manager_name =  $request->manager_name;
                $report_card_details->instructor_name =  $request->instructor_name;
                $report_card_details->report_card_date =   json_encode($report_card_date);
            }

            // return $report_card_details ;
            $report_card_details->save();
        }
        Session::flash('success', 'تم التخزين بنجاح');
        return redirect()->back();
    }



    public function store_all_student_notes(Request $request)
    {

        $year = Year::where('current_year', '1')->first();

        $students = Room_student::where('room_id', $request->room_id)->get();
        $a = [];
        foreach ($students as $student) {


            $teacher_notes = new stdClass();
            $student_attendance = new stdClass();
            $actual_attendance     = new stdClass();
            $justified_absence    = new stdClass();
            $unjustified_absence    = new stdClass();

            $teacher_notes->{'term1'} = $request->teacher_notes1;
            $teacher_notes->{'term2'} = $request->teacher_notes2;

            $student_attendance->{'term1'} = $request->student_attendance1;
            $student_attendance->{'term2'} = $request->student_attendance2;

            $actual_attendance->{'term1'} = $request->actual_attendance1;
            $actual_attendance->{'term2'} = $request->actual_attendance2;

            $justified_absence->{'term1'} = $request->justified_absence1;
            $justified_absence->{'term2'} = $request->justified_absence2;

            $unjustified_absence->{'term1'} = $request->unjustified_absence1;
            $unjustified_absence->{'term2'} = $request->unjustified_absence2;

            $student_id = $student->student_id;
            $report_cards = Report_card::where('student_id', $student_id)->where('year_id', $year->id)->first();
            if (isset($report_cards)) {

                $report_cards->room_id = $request->room_id;
                $report_cards->year_id = $year->id;
                $report_cards->student_id = $student_id;
                $report_cards->teacher_notes = json_encode($teacher_notes);
                $report_cards->manager_notes = $request->manager_notes;
                $report_cards->student_attendance = json_encode($student_attendance);
                $report_cards->actual_attendance = json_encode($actual_attendance);
                $report_cards->justified_absence = json_encode($justified_absence);
                $report_cards->unjustified_absence = json_encode($unjustified_absence);
            } else {
                $report_cards = new Report_card;
                $report_cards->room_id = $request->room_id;
                $report_cards->year_id = $year->id;
                $report_cards->student_id = $student_id;
                $report_cards->teacher_notes = json_encode($teacher_notes);
                $report_cards->manager_notes = $request->manager_notes;
                $report_cards->student_attendance = json_encode($student_attendance);
                $report_cards->actual_attendance = json_encode($actual_attendance);
                $report_cards->justified_absence = json_encode($justified_absence);
                $report_cards->unjustified_absence = json_encode($unjustified_absence);
            }
            $report_cards->save();
        }
        return redirect()->back()->with('success', 'تم التخزين بنجاح');
    }

      public function report_teacher_name(Request $request)
    {


       $year = Year::where('current_year', '1')->first();
      $students = Room_student::where('room_id', $request->room_id)->get();
      $teacher_notes = new stdClass();
            $student_attendance = new stdClass();
            $actual_attendance     = new stdClass();
            $justified_absence    = new stdClass();
            $unjustified_absence    = new stdClass();

            $teacher_notes->{'term1'} = $request->teacher_notes1;
            $teacher_notes->{'term2'} = $request->teacher_notes2;

            $student_attendance->{'term1'} = $request->student_attendance1;
            $student_attendance->{'term2'} = $request->student_attendance2;

            $actual_attendance->{'term1'} = $request->actual_attendance1;
            $actual_attendance->{'term2'} = $request->actual_attendance2;

            $justified_absence->{'term1'} = $request->justified_absence1;
            $justified_absence->{'term2'} = $request->justified_absence2;

            $unjustified_absence->{'term1'} = $request->unjustified_absence1;
            $unjustified_absence->{'term2'} = $request->unjustified_absence2;

      foreach ($students as $student) {
          $student_id = $student->student_id;
      $report_cards = Report_card::where('student_id', $student_id)->where('year_id', $year->id)->first();


       if (isset($report_cards)) {

                $report_cards->room_id = $request->room_id;
                $report_cards->year_id = $year->id;
                $report_cards->student_id = $student_id;
                $report_cards->teacher_name = $request->teacher_name;

            } else {
                $report_cards = new Report_card;
                $report_cards->room_id = $request->room_id;
                $report_cards->year_id = $year->id;
                $report_cards->student_id = $student_id;
                $report_cards->teacher_name = $request->teacher_name;
                 $report_cards->teacher_notes = json_encode($teacher_notes);
                $report_cards->manager_notes = $request->manager_notes;
                $report_cards->student_attendance = json_encode($student_attendance);
                $report_cards->actual_attendance = json_encode($actual_attendance);
                $report_cards->justified_absence = json_encode($justified_absence);
                $report_cards->unjustified_absence = json_encode($unjustified_absence);

            }
            $report_cards->save();

      }
         Session::flash('success', 'تم التخزين بنجاح');
        return redirect()->back();
    }

    public function student_pass_check_by_admin(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
        $next_year = Year::where('id', $year->next_year)->first();
        $next_year_id = $next_year->id;
        $student = Student::with(['room' => function ($q1) use ($year) {
            $q1->where('rooms.year_id', $year->id);
        }])->find($request->student_id);

        $current_class_id = $student->room[0]->class_id;
        $current_class = Classe::with(['room' => function ($q1) use ($next_year_id) {
            $q1->where('rooms.year_id', $next_year_id);
        }])->find($current_class_id);
        $lessons = Lesson::where('class_id', $current_class_id)->get();
        if ($request->is_passed == 1 || $request->is_passed == 2) {
            if ($current_class->next_class != 0) {

                //ckeck if class has room in the next year, if not then create one
                $next_class = Classe::with(['room' => function ($q1) use ($next_year_id) {
                    $q1->where('rooms.year_id', $next_year_id);
                }])->find($current_class->next_class);

                $next_class_room =  $next_class->room;
                // if there is no room in this class then create one and go on !
                if (count($next_class_room) == 0) {
                    $new_next_room = new Room;
                    $new_next_room->name = 'الأولى';
                    $new_next_room->year_id = $next_year_id;
                    $new_next_room->class_id = $next_class->id;
                    $new_next_room->save();
                } else {
                    $new_next_room =  $next_class->room[0];
                }
            }
            if ($request->is_passed == 1) {
                $student_pass = $this->check_student_pass($lessons, $student, $student->room[0]->id, $year->id,$current_class);
            } elseif ($request->is_passed == 2) {

                $student_pass = 1;
            }
            if ($student_pass == 1) {
                $next_class_id = $current_class->next_class;
                $report_card = Report_card::where('student_id', $student->id)->where('year_id', $year->id)->first();
                if (isset($report_card)) {

                    // check if student was faild then delete his records
                    if ($report_card->final_result == 3) {
                        $this->change_student_situation($student->id, $next_year_id, $passed = 1);
                    }
                    // check if student wasn't passed then make him pass
                    if ($report_card->final_result != 2) {
                        $report_card->final_result = 2; //student is passed
                        $report_card->save();
                        if ($next_class_id == 0)
                            $this->student_graduate(); //الصفوف التي لايوجد صف تالي للنجاح له كالبكالوريا
                        $this->student_pass($student, $new_next_room, $next_year_id);
                    }
                } else {

                    return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
                }

                return redirect()->back()->with('success', ' الطالب ناجح تم التخزين بنجاح');
            }
            return back()->with('error', "إن الطالب $student->first_name $student->last_name لم ينجح يرجى التأكد من علاماته   ");
        } else if ($request->is_passed == 0) {
            $current_class_room =  $current_class->room;
            // if there is no room in this class then create one and go on !
            if (count($current_class_room) == 0) {
                $new_current_room = new Room;
                $new_current_room->name = 'الأولى';
                $new_current_room->year_id = $next_year_id;
                $new_current_room->class_id = $current_class->id;
                $new_current_room->save();
            } else {
                $new_current_room =  $current_class->room[0];
            }
            $student_pass = $this->check_student_pass($lessons, $student, $student->room[0]->id, $year->id,$current_class);

            if ($student_pass == 1) {
                return back()->with('error', "إن الطالب $student->first_name $student->last_name  ناجح بكل  مواده ولا يمكن ترسيبه    ");
            }
            $report_card = Report_card::where('student_id', $student->id)->where('year_id', $year->id)->first();
            if (isset($report_card)) {
                if ($report_card->final_result == 2) {
                    $this->change_student_situation($student->id, $next_year_id, $passed = 1);
                }
                if ($report_card->final_result != 3) {
                    $report_card->final_result = 3; //student is passed
                    $report_card->save();
                    $this->student_fail($student, $new_current_room, $next_year_id);
                }
            } else {
                return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
            }

            // return redirect()->back()->with('success', ' تم تحديد الطالب على أنه راسب   بنجاح');
              return redirect()->back()->with('success', ' جاري العمل على طلبك');
        } else {
            return redirect()->back()->with('error', 'تأكد من المعلومات المدخلة ');
        }
    }

    public function end_school_backup()
    {

        include app_path() . '/BackupDataBase.php';
        try {
            $world_dumper = Shuttle_Dumper::create(array(
                'host' => 'localhost',
                'username' => 'u266086252_aladhamedu',
                'password' => 'Sf6=nwR&[8Y',
                'db_name' => 'u266086252_aladhamedu',
            ));

            // $world_dumper->dump('cep.sql.gz');
            $path = base_path('storage/backup') . '/backup_' . Carbon::now()->format('Y-m-d')
                . '_' . Carbon::now()->format('H')
                . '_' . Carbon::now()->format('m')
                . '_' . Carbon::now()->format('s') . '_.sql';
            $world_dumper->dump($path);

            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . basename($path) . "\"");
            // readfile($path);
            Session::flash('success', 'تم أخذ نسخة احتياطية بنجاح');

            $backup = new Backup;
            $backup->item = substr($path, 38);
            $backup->save();
            return 1;
        } catch (Shuttle_Exception $e) {
            echo "Couldn't dump database: " . $e->getMessage();
        }
    }

    public function end_school_year(Request $request){
    

        //   $this->end_school_backup() ;
        $r10=$request->next_year_id;
            ini_set("max_execution_time", "-1");
            ini_set("max_file_uploads", "2000M");
            ini_set("max_input_time", "10000000000000");
            ini_set("memory_limit", "10000000000000M");
            ini_set('post_max_size', '50000000000000M');
            ini_set('upload_max_filesize', '500000000000000M');


              $year=Year::where('current_year','1')->first();
            $next_year = Year::where('id',$year->next_year)->first();
            if (!isset($next_year)){
                return back()->with('error','  قم بتحديد العام التالي للعام الحالي');
            }
            $next_year_id = $next_year->id ;

            $confirm_code = User::where('role_id','1')->first()->view_password;
            if ($confirm_code == $request->confirm_code ){

                if ($next_year_id == $year->id){
                    return back()->with('error','لايمكن  اختيار العام الحالي');
                }
                if ($next_year_id < $year->id){
                    return back()->with('error','لايمكن  اختيار  عام سابق');
                }



                $all_classes = Classe::with(['room'=>function($q1) use($year){
                    $q1->where('rooms.year_id',$year->id);
                    $q1->with('student');
                }])->get();

                foreach($all_classes as $key => $class){
                    $next_class = Classe::find($class->next_class) ;
                    if( !$next_class){
                        if ($class->next_class != 0 )
                        return back()->with('error',"إن الصف $class->name لايملك صف تالي للنجاح له");
                    }
                }

                // DB::transaction(function () use($request,$year){


                    if(isset($all_classes) && count($all_classes) > 0){
                         foreach($all_classes as $class){
                             if ($class->next_class != 0 ){
                                       $next_year_id=$next_year_id;



                           if ($class->next_class != 0 ){
                             //ckeck if class has room in the next year, if not then create one
                             $next_class = Classe::with(['room'=>function($q1) use($next_year_id){
                                $q1->where('rooms.year_id',$next_year_id) ;
                            }])->find($class->next_class);
                            $current_class = Classe::with(['room'=>function($q1) use($next_year_id){
                                $q1->where('rooms.year_id',$next_year_id) ;
                            }])->find($class->id);

                              $next_class_room =  $next_class->room;
                            // if there is no room in this class then create one and go on !
                            if (count($next_class_room) == 0){

                                $new_room = new Room ;
                                $new_room->name = 'الأولى' ;
                                $new_room->year_id = $request->next_year_id ;
                                $new_room->class_id = $next_class->id ;
                                $new_room->save() ;
                            }else {
                                     $new_room =  $next_class->room;
                            }




                           }
                           $current_class_room =  $current_class->room;


                          // if there is no room in this class then create one and go on !
                          if (count($current_class_room) == 0){
                              $new_current_room = new Room ;
                              $new_current_room->name = 'الأولى' ;
                              $new_current_room->year_id = $next_year_id ;
                              $new_current_room->class_id = $current_class->id ;

                              $new_current_room->save() ;
                          }else {
                              $new_current_room =  $current_class->room;
                          }


                              $rooms = $class->room ;

                            if(isset($rooms) && count($rooms) > 0){
                                $lessons = Lesson::where('class_id',$class->id)->get() ;
                                foreach($rooms as $room){

                                    $students = $room->student;

                                    if(isset($students) && count($students) > 0){
                                        $religion = [0 => '1',1 => '0'] ;
                                        $lang = [0 => '1',1 => '0'] ;
                                         if($class->report_card != 4 ) { 
                                        foreach($students as $key => $student){
                                        //   if($class->report_card ==5 ){
                                        //       if($student->id ==8501){
                                        //           return   $student_pass = $this->check_student_pass($lessons,$student,$room->id, $year->id,$class);
                                        //       }

                                        //   }

 

                 $student_pass = $this->check_student_pass($lessons,$student,$room->id, $year->id,$class);
                 if ($student_pass == 1){
                    $next_class_id = $class->next_class ;
                    $report_card = Report_card::where('student_id',$student->id)->where('year_id', $year->id)->first() ;
                     if (isset($report_card)){
                        $report_card->final_result = 2 ;
                        $report_card->save() ;
                    }
                     // else {
                    //     return back()->with('error', "إن الطالب $this->student->first_name $this->student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
                    // }
                    if ($next_class_id == 0)
                        $this->student_graduate() ;
                         
                    $this->student_pass($student,$new_room[0],$next_year_id) ;
                }
                else{
                
                    
                    $report_card = Report_card::where('student_id',$student->id)->where('year_id',$year->id)->first() ;
                    if (isset($report_card)){
                        $report_card->final_result = 3 ;
                        $report_card->save() ;
                    }
                    //  else {
                    //     return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
                    // }
                    
                      $this->student_fail($student,$new_current_room[0],$next_year_id) ;
 
               
                }
                    
          





 







                                        } // foreach students

                                    }

                                    } // if students
                                } //foreach rooms
                            } // if rooms




                             }
                         }
                        // foreach($all_classes as $class){

                        //   if ($class->next_class != 0 ){
                        //      //ckeck if class has room in the next year, if not then create one
                        //      $next_class = Classe::with(['room'=>function($q1) use($next_year_id){
                        //         $q1->where('rooms.year_id',$next_year_id) ;
                        //     }])->find($class->next_class);
                        //     $current_class = Classe::with(['room'=>function($q1) use($next_year_id){
                        //         $q1->where('rooms.year_id',$next_year_id) ;
                        //     }])->find($class->id);

                        //       $next_class_room =  $next_class->room;
                        //     // if there is no room in this class then create one and go on !
                        //     if (count($next_class_room) == 0){

                        //         $new_room = new Room ;
                        //         $new_room->name = 'الأولى' ;
                        //         $new_room->year_id = $this->$request->next_year_id ;
                        //         $new_room->class_id = $next_class->id ;
                        //         $new_room->save() ;
                        //     }else {
                        //              $new_room =  $next_class->room;
                        //     }




                        //   }
                        //   $current_class_room =  $current_class->room;


                        //   // if there is no room in this class then create one and go on !
                        //   if (count($current_class_room) == 0){
                        //       $new_current_room = new Room ;
                        //       $new_current_room->name = 'الأولى' ;
                        //       $new_current_room->year_id = $next_year_id ;
                        //       $new_current_room->class_id = $current_class->id ;

                        //       $new_current_room->save() ;
                        //   }else {
                        //       $new_current_room =  $current_class->room;
                        //   }


                        //       $rooms = $class->room ;
                        //     if(isset($rooms) && count($rooms) > 0){
                        //         $lessons = Lesson::where('class_id',$class->id)->get() ;
                        //         foreach($rooms as $room){

                        //             $students = $room->student;

                        //             if(isset($students) && count($students) > 0){
                        //                 $religion = [0 => '1',1 => '0'] ;
                        //                 $lang = [0 => '1',1 => '0'] ;

                        //                 foreach($students as $key => $student){

                        //                       $student_pass = $this->check_student_pass($lessons,$student,$room->id,$year->id,$class);
                        //                     if ($student_pass == 1){
                        //                         $next_class_id = $class->next_class ;
                        //                         $report_card = Report_card::where('student_id',$student->id)->where('year_id',$year->id)->first() ;
                        //                         if (isset($report_card)){
                        //                             $report_card->final_result = 2 ;
                        //                             $report_card->save() ;
                        //                         }
                        //                         else {
                        //                             return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
                        //                         }
                        //                         if ($next_class_id == 0)
                        //                             $this->student_graduate() ;

                        //                         $this->student_pass($student,$new_room[0],$next_year_id) ;
                        //                     }
                        //                     else{


                        //                         $report_card = Report_card::where('student_id',$student->id)->where('year_id',$year->id)->first() ;
                        //                         if (isset($report_card)){
                        //                             $report_card->final_result = 3 ;
                        //                             $report_card->save() ;
                        //                         }
                        //                          else {
                        //                             return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
                        //                         }

                        //                           $this->student_fail($student,$new_current_room[0],$next_year_id) ;



                        //                     }


                        //                 //     else {
                        //                 //         $this->student_fail() ;
                        //                 //    }

                        //                 } // foreach students

                        //             } // if students
                        //         } //foreach rooms
                        //     } // if rooms
                        // } //foreach classes
                    } //if classes



                // });
                // end transaction
                  return redirect()->back()->with('success','جاري العمل على طلبك ') ;
                // return redirect()->back()->with('success','تم تغيير العام الدراسي ') ;

            } else {
                return redirect()->back()->with('error','كود التأكد غير صحيح') ;
            }

            // $year=Year::where('current_year','1')->first();
            // $next_year = Year::where('id',$year->next_year)->first();
            // if (!isset($next_year)){
            //     return back()->with('error','  قم بتحديد العام التالي للعام الحالي');
            // }
            // $next_year_id = $next_year->id ;

            // $confirm_code = User::where('role_id','1')->first()->view_password;
            // if ($confirm_code == $request->confirm_code ){

            //     if ($next_year_id == $year->id){
            //         return back()->with('error','لايمكن  اختيار العام الحالي');
            //     }
            //     if ($next_year_id < $year->id){
            //         return back()->with('error','لايمكن  اختيار  عام سابق');
            //     }



            //     $all_classes = Classe::with(['room'=>function($q1) use($year){
            //         $q1->where('rooms.year_id',$year->id);
            //         $q1->with('student');
            //     }])->get();

            //     foreach($all_classes as $key => $class){
            //         $next_class = Classe::find($class->next_class) ;
            //         if( !$next_class){
            //             if ($class->next_class !== 0 )
            //             return back()->with('error',"إن الصف $class->name لايملك صف تالي للنجاح له");
            //         }
            //     }

            //     // DB::transaction(function () use($request,$year){


            //         if(isset($all_classes) && count($all_classes) > 0){
            //             foreach($all_classes as $class){

            //               if ($class->next_class != 0 ){
            //                  //ckeck if class has room in the next year, if not then create one
            //                  $next_class = Classe::with(['room'=>function($q1) use($next_year_id){
            //                     $q1->where('rooms.year_id',$next_year_id) ;
            //                 }])->find($class->next_class);
            //                 $current_class = Classe::with(['room'=>function($q1) use($next_year_id){
            //                     $q1->where('rooms.year_id',$next_year_id) ;
            //                 }])->find($class->id);

            //                   $next_class_room =  $next_class->room;
            //                 // if there is no room in this class then create one and go on !
            //                 if (count($next_class_room) == 0){

            //                     $new_room = new Room ;
            //                     $new_room->name = 'الأولى' ;
            //                     $new_room->year_id = $request->next_year_id ;
            //                     $new_room->class_id = $next_class->id ;
            //                     $new_room->save() ;
            //                 }else {
            //                          $new_room =  $next_class->room;
            //                 }




            //               }
            //               $current_class_room =  $current_class->room;


            //               // if there is no room in this class then create one and go on !
            //               if (count($current_class_room) == 0){
            //                   $new_current_room = new Room ;
            //                   $new_current_room->name = 'الأولى' ;
            //                   $new_current_room->year_id = $next_year_id ;
            //                   $new_current_room->class_id = $current_class->id ;

            //                   $new_current_room->save() ;
            //               }else {
            //                   $new_current_room =  $current_class->room;
            //               }


            //                   $rooms = $class->room ;
            //                 if(isset($rooms) && count($rooms) > 0){
            //                     $lessons = Lesson::where('class_id',$class->id)->get() ;
            //                     foreach($rooms as $room){

            //                         $students = $room->student;

            //                         if(isset($students) && count($students) > 0){
            //                             $religion = [0 => '1',1 => '0'] ;
            //                             $lang = [0 => '1',1 => '0'] ;

            //                             foreach($students as $key => $student){
            //                                 ini_set("max_execution_time", "-1");
            //                                 ini_set("max_file_uploads", "2000M");
            //                                 ini_set("max_input_time", "10000000000000");
            //                                 ini_set("memory_limit", "10000000000000M");
            //                                 ini_set('post_max_size', '50000000000000M');
            //                                 ini_set('upload_max_filesize', '500000000000000M');
            //                                   $student_pass = $this->check_student_pass($lessons,$student,$room->id,$year->id,$class);
            //                                 if ($student_pass == 1){
            //                                     $next_class_id = $class->next_class ;
            //                                     $report_card = Report_card::where('student_id',$student->id)->where('year_id',$year->id)->first() ;
            //                                     if (isset($report_card)){
            //                                         $report_card->final_result = 2 ;
            //                                         $report_card->save() ;
            //                                     }
            //                                     else {
            //                                         return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
            //                                     }
            //                                     if ($next_class_id == 0)
            //                                         $this->student_graduate() ;

            //                                     $this->student_pass($student,$new_room[0],$next_year_id) ;
            //                                 }
            //                                 else{


            //                                     $report_card = Report_card::where('student_id',$student->id)->where('year_id',$year->id)->first() ;
            //                                     if (isset($report_card)){
            //                                         $report_card->final_result = 3 ;
            //                                         $report_card->save() ;
            //                                     }
            //                                      else {
            //                                         return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
            //                                     }

            //                                       $this->student_fail($student,$new_current_room[0],$next_year_id) ;



            //                                 }


            //                             //     else {
            //                             //         $this->student_fail() ;
            //                             //    }

            //                             } // foreach students

            //                         } // if students
            //                     } //foreach rooms
            //                 } // if rooms
            //             } //foreach classes
            //         } //if classes
            //     // });
            //     // end transaction
            //     return redirect()->back()->with('success','تم تغيير العام الدراسي بنجاح') ;

            // } else {
            //     return redirect()->back()->with('error','كود التأكد غير صحيح') ;
            // }

        }


    public function all_class_graduate(Request $request)
    {
        DB::beginTransaction();
        try {
            $year = Year::where('current_year', '1')->first();
            $adjustable = $request->adjustable;
            $term = $request->term;
            if ($adjustable == 0) {
                if ($term == 1) {
                    // Students_mark::where('year_id',$year->id)->update(['adjustable' => 0]);
                    Report_card::where('year_id', $year->id)->update(['adjustable' => 0]);
                    Report_card_details::where('year_id', $year->id)->update(['report_card_status' => 0]);
                    DB::commit();

                    return redirect()->back()->with('success', 'تم إلغاء استصدار الجلاء للفصل الأول بنجاح ');
                } elseif ($term == 2) {
                    //here we assume that first term has finished and his status is 1;
                    // Students_mark::where('year_id',$year->id)->update(['adjustable' => 2]);
                    Report_card::where('year_id', $year->id)->update(['adjustable' => 1]);
                    Report_card_details::where('year_id', $year->id)->update(['report_card_status' => 1]);

                    DB::commit();

                    return redirect()->back()->with('success', 'تم إلغاء استصدار الجلاء للفصل الثاني بنجاح ');
                }
            } elseif ($adjustable == 1) {
                if ($term == 1) {
                    Students_mark::where('year_id', $year->id)->update(['adjustable' => 1]);
                    Report_card::where('year_id', $year->id)->update(['adjustable' => 1]);
                    Report_card_details::where('year_id', $year->id)->update(['report_card_status' => 1]);

                    DB::commit();
                     $classes = Classe ::all();
                     foreach($classes as $class ){
                    $rooms = $class->room;
                    foreach($rooms as $room){
                        $students = $room->student;
                        foreach($students as $student){
                            $noti = new Notification;
                            $noti->user_id =1;
                            $noti->student_id = $student->id;
                            $noti->room_id = $room->id;
                            $noti->title ="تم استصدار الجلاء ";
                            $noti->body = "الفصل الاول";
                            // $noti->term_id = $terms->id;
                            $noti->type = 9;
                            $noti->save();
                            // $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                            // $devices = array();
                            //     foreach($tokens as $t){
                            //         array_push($devices, $t['s_fcm_token']);
                            //         //array_push($devices['p_id'], $t['p_fk']);
                            //     }
                            // $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,'null','null','null',$devices);
                        }

                    }

                     }
                    return redirect()->back()->with('success', 'تم استصدار الجلاء للفصل الأول بنجاح ');
                } elseif ($term == 2) {
                    Students_mark::where('year_id', $year->id)->update(['adjustable' => 2]);
                    Report_card::where('year_id', $year->id)->update(['adjustable' => 2]);
                    Report_card_details::where('year_id', $year->id)->update(['report_card_status' => 2]);

                    DB::commit();
                     $classes = Classe ::all();
                     foreach($classes as $class ){
                    $rooms = $class->room;
                    foreach($rooms as $room){
                        $students = $room->student;
                        foreach($students as $student){
                            $noti = new Notification;
                            $noti->user_id =1;
                            $noti->student_id = $student->id;
                            $noti->room_id = $room->id;
                            $noti->title ="تم استصدار الجلاء ";
                            $noti->body = "الفصل الثاني";
                            // $noti->term_id = $terms->id;
                            $noti->type = 9;
                            $noti->save();
                            // $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                            // $devices = array();
                            //     foreach($tokens as $t){
                            //         array_push($devices, $t['s_fcm_token']);
                            //         //array_push($devices['p_id'], $t['p_fk']);
                            //     }
                            // $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,'null','null','null',$devices);
                        }

                    }
                     }
                    return redirect()->back()->with('success', 'تم استصدار الجلاء للفصل الثاني بنجاح ');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', ' ! يرجى التأكد من المعلومات');
        }
    }


    public function all_Classes_freeze_Marks(Request $request)
    {
        DB::beginTransaction();
        try {
            $year = Year::where('current_year', '1')->first();
            $adjustable = $request->adjustable;
            $term = $request->term;
            if ($adjustable == 0) {
                if ($term == 1) {
                    Students_mark::where('year_id', $year->id)->update(['adjustable' => 0]);
                    DB::commit();
                    return redirect()->back()->with('success', 'تم إلغاء تثبيت العلامات للفصل الأول بنجاح ');
                } elseif ($term == 2) {
                    Students_mark::where('year_id', $year->id)->update(['adjustable' => 1]);
                    DB::commit();
                    return redirect()->back()->with('success', 'تم إلغاء تثبيت العلامات للفصل الثاني بنجاح ');
                }
            } elseif ($adjustable == 1) {
                if ($term == 1) {
                    Students_mark::where('year_id', $year->id)->update(['adjustable' => 1]);
                    DB::commit();

                    return redirect()->back()->with('success', 'تم  تثبيت العلامات للفصل الأول بنجاح ');
                } elseif ($term == 2) {
                    Students_mark::where('year_id', $year->id)->update(['adjustable' => 2]);
                    DB::commit();

                    return redirect()->back()->with('success', 'تم  تثبيت العلامات للفصل الثاني بنجاح ');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', ' ! يرجى التأكد من المعلومات');
        }
    }

public function startQueueWorker()
{
    Artisan::call('queue:work');
    return "Queue worker started.";
}
    public function single_class_graduate(Request $request)
    {


        DB::beginTransaction();
   try {
            $year = Year::where('current_year', '1')->first();
            $adjustable = $request->adjustable;
            $term = $request->term;
            if ($adjustable == 0) {
                if ($term == 1) {
                    Classe::join('rooms', 'classes.id', '=', 'rooms.class_id')
                        ->join('room_student', 'rooms.id', '=', 'room_student.room_id')
                        ->join('students', 'students.id', '=', 'room_student.student_id')
                        ->join('students_marks', 'students.id', '=', 'students_marks.student_id')
                        ->join('report_cards', 'students.id', '=', 'report_cards.student_id')
                        ->where('classes.id', '=', $request->class_id)
                        ->where('rooms.year_id', '=', $year->id)
                        ->update(['report_cards.adjustable' => 0]);
                    Report_card_details::where('class_id', $request->class_id)->where('year_id', $year->id)->update(['report_card_status' => 0]);
                    DB::commit();
                    return redirect()->back()->with('success', 'تم إلغاء استصدار الجلاء للفصل الأول بنجاح ');
                } elseif ($term == 2) {
                    Classe::join('rooms', 'classes.id', '=', 'rooms.class_id')
                        ->join('room_student', 'rooms.id', '=', 'room_student.room_id')
                        ->join('students', 'students.id', '=', 'room_student.student_id')
                        ->join('students_marks', 'students.id', '=', 'students_marks.student_id')
                        ->join('report_cards', 'students.id', '=', 'report_cards.student_id')
                        ->where('classes.id', '=', $request->class_id)
                        ->where('rooms.year_id', '=', $year->id)
                        ->update(['report_cards.adjustable' => 1]);
                    Report_card_details::where('class_id', $request->class_id)->where('year_id', $year->id)->update(['report_card_status' => 1]);
                    DB::commit();

                    return redirect()->back()->with('success', 'تم إلغاء استصدار الجلاء للفصل الثاني بنجاح ');
                }
            } elseif ($adjustable == 1) {
                if ($term == 1) {
                    Classe::join('rooms', 'classes.id', '=', 'rooms.class_id')
                        ->join('room_student', 'rooms.id', '=', 'room_student.room_id')
                        ->join('students', 'students.id', '=', 'room_student.student_id')
                        ->join('students_marks', 'students.id', '=', 'students_marks.student_id')
                        ->join('report_cards', 'students.id', '=', 'report_cards.student_id')
                        ->where('classes.id', '=', $request->class_id)
                        ->where('rooms.year_id', '=', $year->id)
                        ->update(['report_cards.adjustable' => 1]);
                    Report_card_details::where('class_id', $request->class_id)->where('year_id', $year->id)->update(['report_card_status' => 1]);

                    DB::commit();

                    // ارسال اشعار انه تم استصار الجلاء


                    // dispatch(new TestJob($request->class_id,$term));
                 
                 
                 
                    //   Artisan::call('queue:work --once' );
                    //  $class = Classe :: find($request->class_id);
                    // $rooms = $class->room;
                    // foreach($rooms as $room){
                    //     $students = $room->student;
                    //     foreach($students as $student){
                    //         $noti = new Notification;
                    //         $noti->user_id =1;
                    //         $noti->student_id = $student->id;
                    //         $noti->room_id = $room->id;
                    //         $noti->title ="تم استصدار الجلاء ";
                    //         $noti->body = "الفصل الاول";
                    //         // $noti->term_id = $terms->id;
                    //         $noti->type = 9;
                    //         $noti->save();
                    //         // $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                    //         // $devices = array();
                    //         //     foreach($tokens as $t){
                    //         //         array_push($devices, $t['s_fcm_token']);
                    //         //         //array_push($devices['p_id'], $t['p_fk']);
                    //         //     }
                    //         // $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,'null','null','null',$devices);
                    //     }

                    // }
                    return redirect()->back()->with('success', 'تم استصدار  الجلاء بنجاح ');
                } elseif ($term == 2) {
                    Classe::join('rooms', 'classes.id', '=', 'rooms.class_id')
                        ->join('room_student', 'rooms.id', '=', 'room_student.room_id')
                        ->join('students', 'students.id', '=', 'room_student.student_id')
                        ->join('students_marks', 'students.id', '=', 'students_marks.student_id')
                        ->join('report_cards', 'students.id', '=', 'report_cards.student_id')
                        ->where('classes.id', '=', $request->class_id)
                        ->where('rooms.year_id', '=', $year->id)
                        ->update(['students_marks.adjustable' => '2', 'report_cards.adjustable' => 2]);
                    Report_card_details::where('class_id', $request->class_id)->where('year_id', $year->id)->update(['report_card_status' => 2]);

                    DB::commit();
                    //  dispatch(new TestJob($request->class_id,$term));
                    // dispatch(new TestJob($request->class_id));
                    // $class = Classe :: find($request->class_id);
                    // $rooms = $class->room;
                    // foreach($rooms as $room){
                    //     $students = $room->student;
                    //     foreach($students as $student){
                    //         $noti = new Notification;
                    //         $noti->user_id =1;
                    //         $noti->student_id = $student->id;
                    //         $noti->room_id = $room->id;
                    //         $noti->title ="تم استصدار الجلاء ";
                    //         $noti->body = "الفصل الثاني";
                    //         // $noti->term_id = $terms->id;
                    //         $noti->type = 9;
                    //         $noti->save();
                    //         // $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();

                    //         // $devices = array();
                    //         //     foreach($tokens as $t){
                    //         //         array_push($devices, $t['s_fcm_token']);
                    //         //         //array_push($devices['p_id'], $t['p_fk']);
                    //         //     }
                    //         // $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,'null','null','null',$devices);
                    //     }

                    // }
                    return redirect()->back()->with('success', 'تم استصدار  الجلاء بنجاح ');
                }
            }}
   catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', ' ! يرجى التأكد من المعلومات');
        }


    }

    public function single_Class_freeze_Marks(Request $request)
    {
        DB::beginTransaction();
        try {
            $year = Year::where('current_year', '1')->first();
            $adjustable = $request->adjustable;
            $term = $request->term;

            if ($adjustable == 0) {
                if ($term == 1) {
                   $shares = Classe::join('rooms', 'classes.id', '=', 'rooms.class_id')
                        ->join('room_student', 'rooms.id', '=', 'room_student.room_id')
                        ->join('students', 'students.id', '=', 'room_student.student_id')
                        ->join('students_marks', 'students.id', '=', 'students_marks.student_id')
                        ->join('report_cards', 'students.id', '=', 'report_cards.student_id')
                        ->where('classes.id', '=', $request->class_id)
                        ->where('rooms.year_id', '=', $year->id)
                        ->update(['students_marks.adjustable' => '0']);



                    DB::commit();
                    return redirect()->back()->with('success', 'تم إلغاء تثبيت العلامات للفصل الأول بنجاح ');
                } elseif ($term == 2) {
                    $shares = Classe::join('rooms', 'classes.id', '=', 'rooms.class_id')
                        ->join('room_student', 'rooms.id', '=', 'room_student.room_id')
                        ->join('students', 'students.id', '=', 'room_student.student_id')
                        ->join('students_marks', 'students.id', '=', 'students_marks.student_id')
                        ->join('report_cards', 'students.id', '=', 'report_cards.student_id')
                        ->where('classes.id', '=', $request->class_id)
                        ->where('rooms.year_id', '=', $year->id)
                        ->update(['students_marks.adjustable' => '1']);
                    DB::commit();
                    return redirect()->back()->with('success', 'تم إلغاء تثبيت العلامات للفصل الثاني بنجاح ');
                }
            } elseif ($adjustable == 1) {
                if ($term == 1) {
                    $shares = Classe::join('rooms', 'classes.id', '=', 'rooms.class_id')
                        ->join('room_student', 'rooms.id', '=', 'room_student.room_id')
                        ->join('students', 'students.id', '=', 'room_student.student_id')
                        ->join('students_marks', 'students.id', '=', 'students_marks.student_id')
                        ->join('report_cards', 'students.id', '=', 'report_cards.student_id')
                        ->where('classes.id', '=', $request->class_id)
                        ->where('rooms.year_id', '=', $year->id)
                        ->update(['students_marks.adjustable' => '1']);
                    DB::commit();
                    return redirect()->back()->with('success', 'تم  تثبيت العلامات للفصل الأول بنجاح ');
                } elseif ($term == 2) {
                    $shares = Classe::join('rooms', 'classes.id', '=', 'rooms.class_id')
                        ->join('room_student', 'rooms.id', '=', 'room_student.room_id')
                        ->join('students', 'students.id', '=', 'room_student.student_id')
                        ->join('students_marks', 'students.id', '=', 'students_marks.student_id')
                        ->join('report_cards', 'students.id', '=', 'report_cards.student_id')
                        ->where('classes.id', '=', $request->class_id)
                        ->where('rooms.year_id', '=', $year->id)
                        ->update(['students_marks.adjustable' => '2']);
                    DB::commit();
                    return redirect()->back()->with('success', 'تم  تثبيت العلامات للفصل الثاني بنجاح ');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', ' ! يرجى التأكد من المعلومات');
        }
    }




    public function recognize_employee(Request $request)
    {

        $x = Employee::find($request->id);
        $x->scientific_material = $request->scientific_material;
        $x->educational_material = $request->educational_material;
        $x->style = $request->style;
        $x->body_standards = $request->body_standards;
        $x->computer_use = $request->computer_use;
        $x->stress = $request->stress;
        $x->teaching_experience = $request->teaching_experience;
        $x->scientific_material2 = $request->scientific_material2;
        $x->language = $request->language;
        $x->preface = $request->preface;
        $x->classroom_management = $request->classroom_management;
        $x->specialization_competencies = $request->specialization_competencies;
        $x->reinforce_behaviors = $request->reinforce_behaviors;
        $x->exam_number = $request->exam_number;
        $x->final_result = $request->final_result;


        $x->recognize = 1;

        $x->save();
        return redirect()->back();
    }


    public function employee_delete(Request $request)
    {
        Employee::find($request->employee_id)->delete();
        return redirect()->back();
    }

    public function changemessage(Request $request)
    {
        $chats = Chat::whereIn('id', $request->all())->get();
        foreach ($chats as $chat) {
            $chat->isread = 1;
            $chat->save();
        }
    }

    public function storechat(Request $request)
    {
        $messages = new Chat;
        $messages->from = auth()->user()->id;
        $messages->to = $request->userid;
        if ($request->type == 0) {
            $messages->message = $request->message;
        } else {
            if ($request->hasFile('message')) {

                $messages->message = 'storage/' . $request->message->store('chatfile', 'public');
                $messages->isfile = 1;
            }
        }
        $messages->save();
        $messages = Chat::find($messages->id);
        return $messages;
    }

    public function getchat(Request $request)
    {
        $messages = Chat::where('from', auth()->user()->id)->where('to', $request->userid)->orwhere('from', $request->userid)->where('to', auth()->user()->id)->get();
        foreach ($messages as $message) {
            if ($message->to == auth()->user()->id) {
                $message->isread = 1;
                $message->save();
            }
        }
        return $messages;
    }



    public function importedatabase(Request $request)
    {
        $formed_code = Auth::User()->view_password;
        if ($formed_code == $request->password) {
            $this->validate($request, [
                'sql' => 'required',
            ]);
            $sql = $request->file('sql');
            set_time_limit(100000);
            ini_set('memory_limit', '-1');
            DB::unprepared(file_get_contents($sql));
            Session::flash('success', 'تمت العملية بنجاح');
        } else {
            Session::flash('error', "كلمة المرور غير مطابقة");
        }
        return redirect()->back();
    }

    // public function get_chat_admin(Request $request)
    // {
    //     $search = $request->search;
    //     if (auth()->user()->type == "8") {
    //         return $users = User::where('type', '!=', '0')->where('id', '!=', auth()->user()->id)->where(function ($q) use ($search) {
    //             $q->where('name', "like", "%" . $search . "%")
    //                 ->orwhereHas('teacher', function ($query) use ($search) {
    //                     $query->where('first_name', 'like', "%" . $search . "%")->orwhere('last_name', 'like', "%" . $search . "%");
    //                 })->orwhereHas('supervisor', function ($query) use ($search) {
    //                     $query->where('first_name', 'like', "%" . $search . "%")->orwhere('last_name', 'like', "%" . $search . "%");
    //                 })->orwhereHas('acadsupervisor', function ($query) use ($search) {
    //                     $query->where('first_name', 'like', "%" . $search . "%")->orwhere('last_name', 'like', "%" . $search . "%");
    //                 })->orwhereHas('supervisor', function ($query) use ($search) {
    //                     $query->where('first_name', 'like', "%" . $search . "%")->orwhere('last_name', 'like', "%" . $search . "%");
    //                 });
    //         })->with('teacher', 'supervisor', 'acadsupervisor', 'coordinator', 'chats')->get();
    //     } else {
    //         return $users = User::where('type', '!=', '0')->where('id', '!=', auth()->user()->id)->where(function ($q) use ($search) {
    //             $q->where('name', "like", "%" . $search . "%")
    //                 ->orwhereHas('teacher', function ($query) use ($search) {
    //                     $query->where('first_name', 'like', "%" . $search . "%")->orwhere('last_name', 'like', "%" . $search . "%");
    //                 })->orwhereHas('supervisor', function ($query) use ($search) {
    //                     $query->where('first_name', 'like', "%" . $search . "%")->orwhere('last_name', 'like', "%" . $search . "%");
    //                 })->orwhereHas('acadsupervisor', function ($query) use ($search) {
    //                     $query->where('first_name', 'like', "%" . $search . "%")->orwhere('last_name', 'like', "%" . $search . "%");
    //                 })->orwhereHas('supervisor', function ($query) use ($search) {
    //                     $query->where('first_name', 'like', "%" . $search . "%")->orwhere('last_name', 'like', "%" . $search . "%");
    //                 });
    //         })->with('teacher', 'supervisor', 'acadsupervisor', 'coordinator', 'chats')->get();
    //     }
    // }
    
        public function get_chat_admin(Request $request)
        {
            $search = $request->search;
            $userId = auth()->user()->id;
        
            return User::where('type', '!=', '0')
                ->where('id', '!=', $userId)
                ->whereHas('teacher', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%" . $search . "%")
                        ->orWhere('last_name', 'like', "%" . $search . "%");
                })
                ->with(['teacher', 'chats']) // Only eager load the teacher and chats relationships
                ->get();
        }

    public function getchat2(Request $request)
    {
        $messages = Chat::where('from', $request->userid1)->where('to', $request->userid2)->orwhere('from', $request->userid2)->where('to', $request->userid1)->get();
        return $messages;
    }

    public function all_chat()
    {
        $users = User::where('type', '!=', '0')->with('teacher', 'supervisor', 'acadsupervisor', 'coordinator', 'chats')->get();
        return view('admin.all_chat', compact('users'));
    }

    public function chat_admin()
    {
        return view('admin.chat_admin');
    }


    public function getemployees(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $select = $request->select;


        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = Employee::count();
        $totalRecordswithFilter = Employee::where('name', "like", "%" . $result_search . "%")->where('recognize', $select)->count();
        $records = Employee::where('name', "like", "%" . $result_search . "%")->where('recognize', $select)->skip($start)->take($rowperpage)->get();


        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "data" => $record,
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

    public function getteachers(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $search_bar = $request->barcode_pos_check;
        $class_filter = $request->classes;
        $room_filter = $request->rooms;

        // $store = Store::where('quantity','>',0)->get();
        // foreach($store as $store_item){
        //     $ids[] = $store_item->product_id;
        // }

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnIndex = $columnIndex > 2 ? 0 : $columnIndex;
        $array_of_sorting = ['first_name', 'last_name',]; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = Teacher::count();
         if($class_filter == null || $class_filter == ""){
            $totalRecordswithFilter = Teacher::withCount('lecture_time')->where(function($q) use($result_search){
                $q->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
            })->where('active',0)->count();
            $records = Teacher::withCount('lecture_time')->where(function($q) use($result_search){
                $q->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
            })->where('active',0)->with('user')->skip($start)->take($rowperpage)->get();
        }else{
        $totalRecordswithFilter = Teacher::withCount('lecture_time')->whereHas('rooms.classes', function ($q) use ($class_filter, $room_filter) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('rooms.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
        })->where(function ($q) use ($result_search) {
            $q->where('first_name', "like", "%" . $result_search . "%")->orwhere('last_name', "like", "%" . $result_search . "%");
        })->where('active',0)->count();
        $records = Teacher::withCount('lecture_time')->whereHas('rooms.classes', function ($q) use ($class_filter, $room_filter) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('rooms.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
        })->where(function ($q) use ($result_search) {
            $q->where('first_name', "like", "%" . $result_search . "%")->orwhere('last_name', "like", "%" . $result_search . "%");
        })->where('active',0)->with('user')->skip($start)->take($rowperpage)->orderBy($array_of_sorting[$columnIndex], $columnIndex_arr[0]['dir'])->get();
        }

        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "first_name" => $record->first_name,
                "last_name" => $record->last_name,
                "address" => $record->address,
                "date_birth" => $record->date_birth,
                "image" => $record->image,
                "id" => $record->id,
                "phone" => $record->phone,
                "Description_ar" => $record->Description_ar,
                "Description_en" => $record->Description_en,
                "type" => $record->type,
                    "lecture_time_count"=>$record->lecture_time_count,

                "user" => $record->user,
                "salary" => $record->salary,
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


    public function acadsupervisor_update(Request $request, $supervisor_id)
    {

        $user = User::where('acadsupervisor_id', $supervisor_id)->first();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
            'phone' => 'required',


        ]);

        $supervisor = Acadsupervisor::find($supervisor_id);
        $supervisor->first_name = $request->first_name;
        $supervisor->last_name = $request->last_name;
        $supervisor->email = $request->email;
        $supervisor->date_birth = $request->date_birth;
        $supervisor->phone = $request->phone;
        $supervisor->address = $request->address;

        $user = User::where('acadsupervisor_id', $supervisor_id)->first();
        $user->email = $request->email;

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete($supervisor->image);

            $supervisor->image = $request->image->store('supervisorsimage', 'public');
        }


        $user = User::where('acadsupervisor_id', $supervisor_id)->first();
        $user->email = $request->email;
        $user->save();

        $supervisor->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }



    public function supervisor_update(Request $request, $supervisor_id)
    {

        $user = User::where('supervisor_id', $supervisor_id)->first();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
            'phone' => 'required',


        ]);

        $supervisor = Supervisor::find($supervisor_id);
        $supervisor->first_name = $request->first_name;
        $supervisor->last_name = $request->last_name;
        $supervisor->email = $request->email;
        $supervisor->date_birth = $request->date_birth;
        $supervisor->phone = $request->phone;
        $supervisor->address = $request->address;

        $user = User::where('supervisor_id', $supervisor_id)->first();
        $user->email = $request->email;

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete($supervisor->image);

            $supervisor->image = $request->image->store('supervisorsimage', 'public');
        }


        $user = User::where('supervisor_id', $supervisor_id)->first();
        $user->email = $request->email;
        $user->save();

        $supervisor->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function delete_student(Request $request)
    {

        $formed_code = Auth::User()->view_password;
        if ($formed_code == $request->password) {
            $user = User::where('student_id', $request->student_id)->first();
            if (count(Students_mark::where('student_id', $request->student_id)->get()) > 0) {
                Students_mark::where('student_id', $request->student_id)->delete();
            }
            if (count(Student_lesson_teacher_room_term_exam::where('student_id', $request->student_id)->get()) > 0) {
                Student_lesson_teacher_room_term_exam::where('student_id', $request->student_id)->delete();
            }
            if (count(Exam_result::where('user_id', $request->student_id)->get()) > 0) {
                Exam_result::where('user_id', $request->student_id)->delete();
            }
            if (count(Exam_result2::where('user_id', $request->student_id)->get()) > 0) {
                Exam_result2::where('user_id', $request->student_id)->delete();
            }

            if (count(Room_student::where('student_id', $request->student_id)->get()) > 0) {
                Room_student::where('student_id', $request->student_id)->delete();
            }
            $user->delete();
            $student = Student::find($request->student_id);
            $messgaes = Message::where('student_id', $request->student_id)->delete();
            $certificate = Certificate::where('student_id', $request->student_id)->get();
            $medal = Medal::where('student_id', $request->student_id)->get();
            if ($certificate) {
                foreach ($certificate as $item) {
                    $item->delete();
                }
            }
            if ($medal) {
                foreach ($medal as $item) {
                    $item->delete();
                }
            }
            ////  المكافأت والعقوبات
             $rewards_and_sanction_student=Rewad_and_sanction_student::where('student_id',$request->student_id)->get();
             foreach($rewards_and_sanction_student as $item){
                 $item->delete();
             }
             $old_tokens = Studentfcmtoken::where('s_fk',$request->student_id)->get();
             foreach($old_tokens as $item){
                 $item->delete();
             }
            // $rome_user= Room_user::where('user_id',$user->id)->get();

            //  if($rome_user){
            //     foreach($rome_user as $item){
            //       $item->delete();
            //   }

            // }

            $student_detail =  Student_detail::where('student_id', $request->student_id)->first();

            if ($student_detail->certification_nine != null) {
                unlink('storage/' . $student_detail->certification_nine);
            }
            if ($student_detail->certification != null) {
                unlink('storage/' . $student_detail->certification);
            }
            if ($student_detail->study_sequence != null) {
                unlink('storage/' . $student_detail->study_sequence);
            }
            if ($student_detail->father_page != null) {
                unlink('storage/' . $student_detail->father_page);
            }
            if ($student_detail->mather_page != null) {
                unlink('storage/' . $student_detail->mather_page);
            }
            if ($student_detail->family_book != null) {
                unlink('storage/' . $student_detail->family_book);
            }
            if ($student_detail->passport != null) {
                unlink('storage/' . $student_detail->passport);
            }
            if ($student_detail->fourth_image != null) {
                unlink('storage/' . $student_detail->fourth_image);
            }
            if ($student_detail->father_image != null) {
                unlink('storage/' . $student_detail->father_image);
            }
            if ($student_detail->mother_image != null) {
                unlink('storage/' . $student_detail->mother_image);
            }
            if ($student_detail->personal_image != null) {
                unlink('storage/' . $student_detail->personal_image);
            }

            $student_detail->delete();
            $student->delete();

            Session::flash('success', "تم حذف الطالب بنجاح");
        } else {
            Session::flash('error', "كلمة المرور غير مطابقة");
        }
        return redirect()->back();
    }
    public function getstudentsprobe(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $current_class = $request->current_class;
        $class_id = $request->class_id;
        // $store = Store::where('quantity','>',0)->get();
        // foreach($store as $store_item){
        //     $ids[] = $store_item->product_id;
        // }

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = Student_register::count();
        if ($class_id != "") {
            $totalRecordswithFilter = Student_register::where('first_name', "like", "%" . $result_search . "%")->where('current_class', "like", "%" . $current_class . "%")->where('probe_class', $class_id)->where('probe', 1)->orwhere('last_name', "like", "%" . $result_search . "%")->where('probe', 1)->where('probe_class', $class_id)->where('current_class', "like", "%" . $current_class . "%")->count();
            $records = Student_register::where('first_name', "like", "%" . $result_search . "%")->where('current_class', "like", "%" . $current_class . "%")->where('probe_class', $class_id)->where('probe', 1)->orwhere('last_name', "like", "%" . $result_search . "%")->where('probe', 1)->where('probe_class', $class_id)->where('current_class', "like", "%" . $current_class . "%")->skip($start)
                ->take($rowperpage)->with('class')->get();
        } else {
            $totalRecordswithFilter = Student_register::where('first_name', "like", "%" . $result_search . "%")->where('current_class', "like", "%" . $current_class . "%")->where('probe', 1)->orwhere('last_name', "like", "%" . $result_search . "%")->where('probe', 1)->where('current_class', "like", "%" . $current_class . "%")->count();
            $records = Student_register::where('first_name', "like", "%" . $result_search . "%")->where('current_class', "like", "%" . $current_class . "%")->where('probe', 1)->orwhere('last_name', "like", "%" . $result_search . "%")->where('probe', 1)->where('current_class', "like", "%" . $current_class . "%")->skip($start)
                ->take($rowperpage)->with('class')->get();
        }


        $data_arr = array();
        foreach ($records as $record) {
            $record["date2"] = \Carbon\Carbon::parse($record->created_at)->isoFormat('D/M/Y h:m');
            $record["id2"] =  $record->id;
            $data_arr[] = $record;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        return response;
        echo json_encode($response);
        exit;
    }


    public function getstudentsapprove(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $current_class = $request->current_class;
        $class_id = $request->class_id;
        // $store = Store::where('quantity','>',0)->get();
        // foreach($store as $store_item){
        //     $ids[] = $store_item->product_id;
        // }

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnIndex = $columnIndex > 2 ? 0 : $columnIndex;
         $array_of_sorting = ['created_at', 'last_name','first_name' ]; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = Student_register::count();
        if ($class_id != "") {
            $totalRecordswithFilter = Student_register::where('first_name', "like", "%" . $result_search . "%")->where('current_class', "like", "%" . $current_class . "%")->where('class1', $class_id)->where('probe', 0)->orwhere('last_name', "like", "%" . $result_search . "%")->where('probe', 0)->where('class1', $class_id)->where('current_class', "like", "%" . $current_class . "%")->count();
            $records = Student_register::where('first_name', "like", "%" . $result_search . "%")->where('current_class', "like", "%" . $current_class . "%")->where('class1', $class_id)->where('probe', 0)->orwhere('last_name', "like", "%" . $result_search . "%")->where('probe', 0)->where('class1', $class_id)->where('current_class', "like", "%" . $current_class . "%")->skip($start)
                ->take($rowperpage)->with('class')->orderBy($array_of_sorting[$columnIndex], $columnIndex_arr[0]['dir'])->get();
        } else {
            $totalRecordswithFilter = Student_register::where('first_name', "like", "%" . $result_search . "%")->where('current_class', "like", "%" . $current_class . "%")->where('probe', 0)->orwhere('last_name', "like", "%" . $result_search . "%")->where('probe', 0)->where('current_class', "like", "%" . $current_class . "%")->count();
            $records = Student_register::where('first_name', "like", "%" . $result_search . "%")->where('current_class', "like", "%" . $current_class . "%")->where('probe', 0)->orwhere('last_name', "like", "%" . $result_search . "%")->where('probe', 0)->where('current_class', "like", "%" . $current_class . "%")->skip($start)
                ->take($rowperpage)->with('class')->orderBy($array_of_sorting[$columnIndex], $columnIndex_arr[0]['dir'])->get();
        }


        $data_arr = array();

        //  $number = ($start / $rowperpage) * $rowperpage;
        foreach ($records as $record) {
            // $number++;
            // $record["number"]=$number;
            $record["date2"] = \Carbon\Carbon::parse($record->created_at)->isoFormat('D/M/Y');
            $record["time"]  = \Carbon\Carbon::parse($record->created_at)->isoFormat('h:m a');
            $record["id2"]   = $record->id;
            $data_arr[] = $record;
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


    public function probe_student(Request $request)
    {

        $student_register = Student_register::find($request->student_id);
        $student_register->probe = 1;
        $student_register->probe_class = $request->class_id;
        $student_register->save();
    }


    public function approve_student(Request $request)
    {

        $student_register = Student_register::find($request->student_id);

        $accepted = 0;
        if (isset($request->is_admin) && $request->is_admin == 1)
            $accepted = 1;

        $student = new Student;
        // $student->accepted =  $accepted;
        $student->first_name =  $student_register->first_name;
        $student->last_name =  $student_register->last_name;
        $student->first_name_en =  $student_register->first_name_en;
        $student->last_name_en =  $student_register->last_name_en;
        $student->email =  $student_register->email;
        $student->date_birth =  $student_register->date;
        $student->address =  $student_register->country;
        $student->religion =  isset($student_register->religion) ? (string)$student_register->religion : '0';

        $student->save();

        $year = Year::where('current_year', '1')->first();
        $rooom = Room::find($request->room_id);
        Invoice::create([
            'invoice_number' => $student->id,
            'invoice_amount' => 0,
            'payment_type' => '',
            'bank_name' => '',
            'student_id' => $student->id,
            'class_id' => $rooom->class_id,
            'year_id' => $year->id,
        ]);

        $student_details = new Student_detail;
        $student_details->student_id = $student->id;
        $student_details->phone = $student_register->phone;
        $student_details->father_name = $student_register->father_name;
        $student_details->father_phone = $student_register->father_phone;
        $student_details->mother_name = $student_register->mather_name;
        $student_details->mother_phone = $student_register->mather_phone;
        $student_details->personal_image = $student_register->personal_image;
        $student_details->mother_image = $student_register->mother_image;
        $student_details->father_image = $student_register->father_image;
        $student_details->passport = $student_register->passbord;
        $student_details->mother_job = $student_register->mather_job;
        $student_details->father_job = $student_register->father_job;
        $student_details->other_phone = $student_register->other_phone;
        $student_details->family_book = $student_register->family_book;
        $student_details->mather_page = $student_register->mather_page;
        $student_details->father_page = $student_register->father_page;
        $student_details->study_sequence = $student_register->study_sequence;
        $student_details->certification = $student_register->certification;
        $student_details->certification_nine = $student_register->certification_nine;
        $student_details->save();

        $year = Year::where('current_year', 1)->first();

        $user = User::create([
            'name' => $student->first_name,
            'email' => "a@app.com",
            'mobile' => $student->phone != null ? $student->phone : ' ',
            'password' => Hash::make(5),
            'view_password' => 5,
            'type' => '0',
            'student_id' => $student->id,

        ]);

        $email = str_replace(" ", "", $student->first_name_en) . str_replace(" ", "", $student->last_name_en) . rand(1, 1000) . "@aladham.com";
        if (strlen($student->first_name_en) > 2) {
            $namee = substr($student->first_name_en, 0, 3);
        } else {
            $namee = "aladham";
        }
        $password = $namee . "@" . rand(100000, 900000);
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->view_password = $password;
        $user->save();


        $room_student = new Room_student;
        $room_student->year_id = $year->id;
        $room_student->room_id = $request->room_id;
        $room_student->student_id = $student->id;
        $room_student->save();

        $student->email = $email;
        $student->save();
        $student_register->delete();

        $reportCardDetails = Report_card_details::where('year_id', $year->id)->where('class_id', $request->class_id)->first();
        $adjustable = isset($reportCardDetails) ? $reportCardDetails->report_card_status : 0;
        $this->make_student_report_card($student->id, $request->room_id, $year->id, $adjustable);

        // create record in student_mark table
        $lessons = Lesson::where('class_id', $request->class_id)->get();
        $object1 = new stdClass();
        foreach ($lessons as $item) {
            $object1->{$item->id}['oral'] = $request->oral;
            $object1->{$item->id}['homework'] = $request->homework;
            $object1->{$item->id}['activities'] = $request->activities;
            $object1->{$item->id}['quize'] = $request->quize;
            $object1->{$item->id}['exam'] = $request->exam;
        }

        $object2 = new stdClass();
        foreach ($lessons as $item) {
            $object2->{$item->id}['oral'] = $request->oral;
            $object2->{$item->id}['homework'] = $request->homework;
            $object2->{$item->id}['activities'] = $request->activities;
            $object2->{$item->id}['quize'] = $request->quize;
            $object2->{$item->id}['exam'] = $request->exam;
        }

        $object_result1 = new stdClass();

        foreach ($lessons as $item) {
            $object_result1->{$item->id}['term1_quizes'] = null;
            $object_result1->{$item->id}['term1_exam'] = null;
            $object_result1->{$item->id}['term1_result'] = null;
        }


        $object_result2 = new stdClass();

        foreach ($lessons as $item) {
            $object_result2->{$item->id}['term2_quizes'] = null;
            $object_result2->{$item->id}['term2_exam'] = null;
            $object_result2->{$item->id}['term2_result'] = null;
        }

        $object_result = new stdClass();

        foreach ($lessons as $item) {
            $object_result->{$item->id}['year_result'] = null;
        }

        $object_result_term = new stdClass();

        $object_result_term->{'term1'} = null;
        $object_result_term->{'term2'} = null;

        // return json_encode($object_result_term);
        $year = Year::where('current_year', '1')->first();

        Students_mark::create([
            'student_id' => $student->id,
            'room_id' => $request->room_id,
            'year_id' => $year->id,
            'mark' => json_encode($object1),
            'mark2' => json_encode($object2),
            'result1' => json_encode($object_result1),
            'result2' => json_encode($object_result2),
            'result' => json_encode($object_result),
            'term_result' => json_encode($object_result_term),
            'status' => '1',
            'adjustable' => isset($reportCardDetails) ? $reportCardDetails->student_marks_status : 0,
            'lang' => '0',
            'religion' => $student->religion,

        ]);

        //هنا الشرط لجلب المادة المخالفة للغة الطالب وحذفها من العلمات
        if ($student->lang == 0) {
            $lessons = Lesson::where('class_id', $request->class_id)->where('lang', '1')->get();
        } elseif ($student->lang == 1) {
            $lessons = Lesson::where('class_id', $request->class_id)->where('lang', '0')->get();
        }

        $student = Student::findOrFail($student->id);


        foreach ($lessons as $lesson) {

            if ($lesson->lang != null) {

                $student_mark = Students_mark::where('student_id', $student->id)->where('lang', $student->lang)->where('year_id', $year->id)->first();
                  ['student_mark' => $student_mark, 'student_id' => $student->id, 'lang' => $student->lang];




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

        //هنا الشرط لجلب المادة المخالف لديانة الطالب وحذفها من العلمات

        if ($student->religion == 0) {
            $lessons = Lesson::where('class_id', $request->class_id)->where('religion', '1')->get();
        } elseif ($student->religion == 1) {
            $lessons = Lesson::where('class_id', $request->class_id)->where('religion', '0')->get();
        }



        foreach ($lessons as $lesson) {

            if ($lesson->religion != null) {
                $student_mark = Students_mark::where('student_id', $student->id)->where('religion', $student->religion)->where('year_id', $year->id)->first();



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

        Session::flash('success', '! تمت العملية بنجاح');

        return redirect()->back();
    }



    public function studentadmission()
    {
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::all();
        return view('admin.studentapprove', compact('year2', 'classes'));
    }
    public function studentprobe()
    {
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::all();
        return view('admin.studentprobe', compact('year2', 'classes'));
    }


    public function delete_student_request(Request $request)
    {
        $student_register = Student_register::findOrFail($request->student_id_delete)->delete();
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }


    public function delete_multiple_student(Request $request)
    {

        foreach ($request->selected_stu as $to_delete) {
            $student_register = Student_register::findOrFail($to_delete)->delete();
        }
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }


    public function index()
    {
        $fixe_it = Exam_result::all();
        foreach ($fixe_it as $fixe_me) {

            $test = Lesson_teacher_room_term_exam::find($fixe_me->exam_id);
            if (isset($test)) {
                $fixe_me->lecture_id = $test->lecture_id;

                $fixe_me->save();
            }
        }
        return view('admin.index');
    }
    public function websitecontroller()
    {
        return view('admin.websitecontroller');
    }
    public function news()
    {
        return view('admin.news');
    }

    public function websitecontactus()
    {
        return view('admin.websitecontactus');
    }

    public function about_us1()
    {
        return view('admin.about_us');
    }
    public function websitehome()
    {
        return view('admin.websitehome');
    }


     public function students()
    {
        // $students = Student::orderBy('first_name')->paginate(25);
        // $classes=Classe::all();
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::all();
        $country_currency = Country_currency::all();
        $stages =Basic_stage:: all();
        return view('admin.student', compact('year2', 'classes','country_currency','stages'));
    }

     public function export_teacher_archive(Request $request)
    {
         $request->validate([
            'year_id' => 'required',
        ]);
            return Excel::download(new TeacherExportArchive($request),' المعلمين .xlsx');
    }
      public function export_teacher(Request $request)
    {

            return Excel::download(new TeacherExport($request),' المعلمين .xlsx');
    }
     public function export_student_archive(Request $request)
    {
         $request->validate([
            'year_id' => 'required',
        ]);

            return Excel::download(new StudentExportArchive($request),' الطلاب.xlsx');



    }

     public function export_student1(Request $request)
    {
         $request->validate([
            'rooms' => 'required',
        ]);
        //   return $request->all();
        // if($request->rooms == 0){
        //     Session::flash('error', '!يرجى تحديد الشعبة ');
        //       return redirect()->back();
        // }
        if($request->stage == 0 && $request->rooms == 0 &&  $request->classes==0){
            return Excel::download(new StudentExport1($request),'كل الطلاب.xlsx');
        }
        else if($request->rooms == 0 &&  $request->classes==0){

            $satge =Basic_stage ::find($request->stage)->name;
        return Excel::download(new StudentExport1($request), $satge.'.xlsx');
        }
        elseif($request->rooms == 0 &&  $request->classes !=0){
             $classes = Classe::find($request->classes)->name;
        // $student=Student::all();
        return Excel::download(new StudentExport1($request),  $classes . '.xlsx');
        }
        else{
          $room = Room::find($request->rooms)->name;
        // $student=Student::all();
        return Excel::download(new StudentExport1($request),  $room . '.xlsx');
        }

    }
    public function export_register_student(Request $request)
    {


        // $student=Student::all();
        return Excel::download(new StudentExport_register($request),  now()->format('Y-m') . '.xlsx');
    }


    public function students_financial()
    {
        // return  $records = DB::table('students')->where('room_student.year_id',1)
        // ->join('invoices', 'invoices.student_id', '=', 'students.id')
        // ->join('room_student', 'room_student.student_id', '=', 'students.id')
        // ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        // ->join('classes', 'rooms.class_id', '=', 'classes.id')
        // ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
        // ->groupBy('invoices.student_id','classes.id')->having('remain_total',">",5000)
        // ->get();

        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::all();
        return view('admin.finastudent', compact('year2', 'classes'));
    }
       public function finastudent1($class_id, $room_id, $type, $amount, $date1, $date2)
    {
        $ratios = Rate::first();
         if(in_array("student_hidden", Auth::user()->role->permissions)){

        if ($type == "0") {



            $student = Student::WhereHas('room.classes', function ($q) use ($class_id, $room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($class_id != "" && $class_id != 'null' && $room_id != "" && $room_id != 'null') {
                        $q->where('classes.id', $class_id)->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else if ($class_id != "" && $class_id != 'null') {
                        $q->where('classes.id', $class_id);
                    }
                })
                ->with(['room' => function ($q1) use ($room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($room_id != "" && $room_id != 'null') {
                        $q1->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else {
                        $q1->where('room_student.year_id', $year->id);
                    }
                }])->WhereHas('invoices', function ($q) use ($date1, $date2) {

                    if ($date1 != "" && $date1 != 'null' && $date2 != "" && $date2 != 'null') {
                        $q->whereBetween('invoices.updated_at', [$date1 . " 00:00:00", $date2 . " 23:59:59"]);
                    }
                })->where('hidden',0)
                ->join('invoices', 'invoices.student_id', '=', 'students.id')
                ->join('room_student', 'room_student.student_id', '=', 'students.id')
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                 ->join('class_cost', function($join){
                    $join->on('class_cost.country_id', '=', 'students.country_currency')
                         ->on('class_cost.class_id', '=', 'classes.id');
                })->join('countries_currencies', 'class_cost.country_id', '=', 'countries_currencies.id')
                ->select(DB::raw('students.*'),
                DB::raw('rooms.id as room_id'),
                DB::raw('classes.id as class_id '),
                DB::raw('classes.fixed_cost'),
                DB::raw('classes.name as classname'),
                DB::raw('class_cost.cost as cost'),
                DB::raw('countries_currencies.currency_country as key_country'),
                DB::raw('sum(invoices.invoice_amount) as total'),
                DB::raw('class_cost.cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id', "students.id", 'classes.id')->having('remain_total', ">", doubleval($amount))
                ->get();
        } else if ($type == "1") {
            $student = Student::WhereHas('room.classes', function ($q) use ($class_id, $room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($class_id != "" && $class_id != 'null' && $room_id != "" && $room_id != 'null') {
                        $q->where('classes.id', $class_id)->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else if ($class_id != "" && $class_id != 'null') {
                        $q->where('classes.id', $class_id);
                    }
                })
                ->with(['room' => function ($q1) use ($room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($room_id != "" && $room_id != 'null') {
                        $q1->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else {
                        $q1->where('room_student.year_id', $year->id);
                    }
                }])->WhereHas('invoices', function ($q) use ($date1, $date2) {

                    if ($date1 != "" && $date1 != 'null' && $date2 != "" && $date2 != 'null') {
                        $q->whereBetween('invoices.updated_at', [$date1 . " 00:00:00", $date2 . " 23:59:59"]);
                    }
                })->where('hidden',0)
                ->join('invoices', 'invoices.student_id', '=', 'students.id')
                ->join('room_student', 'room_student.student_id', '=', 'students.id')
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->join('class_cost', function($join){
                    $join->on('class_cost.country_id', '=', 'students.country_currency')
                         ->on('class_cost.class_id', '=', 'classes.id');
                })->join('countries_currencies', 'class_cost.country_id', '=', 'countries_currencies.id')
                ->select(DB::raw('students.*'),
                DB::raw('rooms.id as room_id'),
                DB::raw('classes.id as class_id '),
                DB::raw('classes.fixed_cost'),
                DB::raw('classes.name as classname'),
                DB::raw('class_cost.cost as cost'),
                DB::raw('countries_currencies.currency_country as key_country'),
                DB::raw('sum(invoices.invoice_amount) as total'),
                DB::raw('class_cost.cost - sum(invoices.invoice_amount) as remain_total'))
                 ->groupBy('invoices.student_id', "students.id", 'classes.id')->having('total', ">", doubleval($amount))
                ->get();
        } else {

            $student = Student::WhereHas('room.classes', function ($q) use ($class_id, $room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($class_id != "" && $class_id != 'null' && $room_id != "" && $room_id != 'null') {
                        $q->where('classes.id', $class_id)->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else if ($class_id != "" && $class_id != 'null') {
                        $q->where('classes.id', $class_id);
                    }
                })
                ->with(['room' => function ($q1) use ($room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($room_id != "" && $room_id != 'null') {
                        $q1->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else {
                        $q1->where('room_student.year_id', $year->id);
                    }
                }])->WhereHas('invoices', function ($q) use ($date1, $date2) {

                    if ($date1 != "" && $date1 != 'null' && $date2 != "" && $date2 != 'null') {
                        $q->whereBetween('invoices.updated_at', [$date1 . " 00:00:00", $date2 . " 23:59:59"]);
                    }
                })->where('hidden',0)
                ->join('invoices', 'invoices.student_id', '=', 'students.id')
                ->join('room_student', 'room_student.student_id', '=', 'students.id')
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->join('class_cost', function($join){
                    $join->on('class_cost.country_id', '=', 'students.country_currency')
                         ->on('class_cost.class_id', '=', 'classes.id');
                })->join('countries_currencies', 'class_cost.country_id', '=', 'countries_currencies.id')
                ->select(DB::raw('students.*'),
                DB::raw('rooms.id as room_id'),
                DB::raw('classes.id as class_id '),
                DB::raw('classes.fixed_cost'),
                DB::raw('classes.name as classname'),
                DB::raw('class_cost.cost as cost'),
                DB::raw('countries_currencies.currency_country as key_country'),
                DB::raw('sum(invoices.invoice_amount) as total'),
                DB::raw('class_cost.cost - sum(invoices.invoice_amount) as remain_total'))
                 ->groupBy('invoices.student_id', "students.id", 'classes.id')->having('total', "<", doubleval($amount))
                ->get();
        }
         }else{
             if ($type == "0") {



            $student = Student::WhereHas('room.classes', function ($q) use ($class_id, $room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($class_id != "" && $class_id != 'null' && $room_id != "" && $room_id != 'null') {
                        $q->where('classes.id', $class_id)->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else if ($class_id != "" && $class_id != 'null') {
                        $q->where('classes.id', $class_id);
                    }
                })
                ->with(['room' => function ($q1) use ($room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($room_id != "" && $room_id != 'null') {
                        $q1->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else {
                        $q1->where('room_student.year_id', $year->id);
                    }
                }])->WhereHas('invoices', function ($q) use ($date1, $date2) {

                    if ($date1 != "" && $date1 != 'null' && $date2 != "" && $date2 != 'null') {
                        $q->whereBetween('invoices.updated_at', [$date1 . " 00:00:00", $date2 . " 23:59:59"]);
                    }
                })
                ->join('invoices', 'invoices.student_id', '=', 'students.id')
                ->join('room_student', 'room_student.student_id', '=', 'students.id')
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                 ->join('class_cost', function($join){
                    $join->on('class_cost.country_id', '=', 'students.country_currency')
                         ->on('class_cost.class_id', '=', 'classes.id');
                })->join('countries_currencies', 'class_cost.country_id', '=', 'countries_currencies.id')
                ->select(DB::raw('students.*'),
                DB::raw('rooms.id as room_id'),
                DB::raw('classes.id as class_id '),
                DB::raw('classes.fixed_cost'),
                DB::raw('classes.name as classname'),
                DB::raw('class_cost.cost as cost'),
                DB::raw('countries_currencies.currency_country as key_country'),
                DB::raw('sum(invoices.invoice_amount) as total'),
                DB::raw('class_cost.cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id', "students.id", 'classes.id')->having('remain_total', ">", doubleval($amount))
                ->get();
        } else if ($type == "1") {
            $student = Student::WhereHas('room.classes', function ($q) use ($class_id, $room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($class_id != "" && $class_id != 'null' && $room_id != "" && $room_id != 'null') {
                        $q->where('classes.id', $class_id)->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else if ($class_id != "" && $class_id != 'null') {
                        $q->where('classes.id', $class_id);
                    }
                })
                ->with(['room' => function ($q1) use ($room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($room_id != "" && $room_id != 'null') {
                        $q1->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else {
                        $q1->where('room_student.year_id', $year->id);
                    }
                }])->WhereHas('invoices', function ($q) use ($date1, $date2) {

                    if ($date1 != "" && $date1 != 'null' && $date2 != "" && $date2 != 'null') {
                        $q->whereBetween('invoices.updated_at', [$date1 . " 00:00:00", $date2 . " 23:59:59"]);
                    }
                })
                ->join('invoices', 'invoices.student_id', '=', 'students.id')
                ->join('room_student', 'room_student.student_id', '=', 'students.id')
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->join('class_cost', function($join){
                    $join->on('class_cost.country_id', '=', 'students.country_currency')
                         ->on('class_cost.class_id', '=', 'classes.id');
                })->join('countries_currencies', 'class_cost.country_id', '=', 'countries_currencies.id')
                ->select(DB::raw('students.*'),
                DB::raw('rooms.id as room_id'),
                DB::raw('classes.id as class_id '),
                DB::raw('classes.fixed_cost'),
                DB::raw('classes.name as classname'),
                DB::raw('class_cost.cost as cost'),
                DB::raw('countries_currencies.currency_country as key_country'),
                DB::raw('sum(invoices.invoice_amount) as total'),
                DB::raw('class_cost.cost - sum(invoices.invoice_amount) as remain_total'))
                 ->groupBy('invoices.student_id', "students.id", 'classes.id')->having('total', ">", doubleval($amount))
                ->get();
        } else {

            $student = Student::WhereHas('room.classes', function ($q) use ($class_id, $room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($class_id != "" && $class_id != 'null' && $room_id != "" && $room_id != 'null') {
                        $q->where('classes.id', $class_id)->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else if ($class_id != "" && $class_id != 'null') {
                        $q->where('classes.id', $class_id);
                    }
                })
                ->with(['room' => function ($q1) use ($room_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($room_id != "" && $room_id != 'null') {
                        $q1->where('rooms.id', $room_id)->where('room_student.year_id', $year->id);
                    } else {
                        $q1->where('room_student.year_id', $year->id);
                    }
                }])->WhereHas('invoices', function ($q) use ($date1, $date2) {

                    if ($date1 != "" && $date1 != 'null' && $date2 != "" && $date2 != 'null') {
                        $q->whereBetween('invoices.updated_at', [$date1 . " 00:00:00", $date2 . " 23:59:59"]);
                    }
                })
                ->join('invoices', 'invoices.student_id', '=', 'students.id')
                ->join('room_student', 'room_student.student_id', '=', 'students.id')
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->join('class_cost', function($join){
                    $join->on('class_cost.country_id', '=', 'students.country_currency')
                         ->on('class_cost.class_id', '=', 'classes.id');
                })->join('countries_currencies', 'class_cost.country_id', '=', 'countries_currencies.id')
                ->select(DB::raw('students.*'),
                DB::raw('rooms.id as room_id'),
                DB::raw('classes.id as class_id '),
                DB::raw('classes.fixed_cost'),
                DB::raw('classes.name as classname'),
                DB::raw('class_cost.cost as cost'),
                DB::raw('countries_currencies.currency_country as key_country'),
                DB::raw('sum(invoices.invoice_amount) as total'),
                DB::raw('class_cost.cost - sum(invoices.invoice_amount) as remain_total'))
                 ->groupBy('invoices.student_id', "students.id", 'classes.id')->having('total', "<", doubleval($amount))
                ->get();
        }
         }
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::all();
        foreach ($student as $record) {
            $rate_ministerial=number_format($record->total*($ratios->ministerial/100),1);
            $rate_financial=number_format($record->total*($ratios->financial/100),1);
            $record->rate_financial= $rate_financial;
            $record->rate_ministerial= $rate_ministerial;

        }

        return view('admin.finastudent1', compact('year2', 'classes', 'student'));
    }


    public function rooms2($class_id, $year_id)
    {
      $year2 = Year::where('current_year', '1')->first();
        $rooms = Room::where('class_id', $class_id)->where('year_id', $year2->id)->get();
        // $rooms = Room::where('class_id', $class_id)->get();
        return $rooms;
    }
    public function rooms2_role($class_id, $year_id)
    {
        $classes_rooms_roles = Classes_Rooms_Roles::where('role_id', auth()->user()->role_id)->get();


        $room = [];
        foreach ($classes_rooms_roles as $item) {
            $room[] = $item->room_id;
        };
         $year = Year::where('current_year', '1')->first();

        $rooms = Room::whereIn('id', $room)->where('class_id', $class_id)->where('year_id', $year->id)->get();
        return $rooms;
    }

    public function rooms22(Request $request)
    {

        $classes_rooms_roles = Classes_Rooms_Roles::where('role_id', auth()->user()->role_id)->get();

        $room = [];
        foreach ($classes_rooms_roles as $item) {
            $room[] = $item->room_id;
        };

        $year2 = Year::where('current_year', '1')->first();
        $rooms = Room::whereIn('id', $room)->whereIn('class_id', $request->class_id)->where('year_id', $year2->id)->get();
        //   $rooms=Room::whereIn('class_id',$class_id)->get();
        return $rooms;
    }
    public function rooms23(Request $request)
    {


        $year2 = Year::where('current_year', '1')->first();
        $rooms = Room::with('classes')->whereIn('class_id', $request->class_id)->where('year_id', $year2->id)->get();
        //   $rooms=Room::whereIn('class_id',$class_id)->get();
        return $rooms;
    }

    public function invoices_details($student_id)
    {
        $student = Student::find($student_id);
        $year = Year::where('current_year', '1')->first();
        $invoices_details = Invoice::where('student_id', $student_id)->where('year_id', $year->id)->get();
        return view('admin.invoices_details', compact('invoices_details', 'student'));
    }
        public function invoices_print($invoices_id)
    {
        
        $invoice = Invoice::find($invoices_id);
       
        
        return view('admin.invoices_print', compact('invoice'));
    }


    public function send_message(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $request->validate([
            'message' => 'required',
        ]);

        if (isset($request->class_id)) {
            if ($request->class_id == '0') {

                $rooms = Room::where('year_id', $year->id)->get();


                foreach ($rooms as $room) {

                    foreach ($room->student as $student) {

                        $item = new Message;

                        $item->student_id = $student->id;
                        $item->message = $request->message;
                        $item->year_id = $year->id;
                        $item->save();
                    }
                }

                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            }



            $class = Classe::find($request->class_id);

            $rooms =  $class->room->where('year_id', $year->id);

            foreach ($rooms as $room) {

                foreach ($room->student as $student) {


                    $item = new Message;

                    $item->student_id = $student->id;
                    $item->message = $request->message;
                    $item->year_id = $year->id;
                    $item->save();
                }
            }

            return redirect()->back()->with('success', '! تمت العملية بنجاح');
        }

        $item = new Message;

        $item->student_id = $request->student_id;
        $item->message = $request->message;
        $item->year_id = $year->id;
        $item->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function change_lang(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $student = Student::find($request->student_id);

        $class = $student->room()->where('room_student.year_id', $year->id)->first()->classes;

        $student_lang = $student->lang;
        $student->lang = $request->select_lang;
        $student->save();

        if ($student_lang == '0') {
            $lessons = Lesson::where('class_id', $class->id)->where('lang', '0')->get();
        } elseif ($student_lang == '1') {
            $lessons = Lesson::where('class_id', $class->id)->where('lang', '1')->get();
        }


        foreach ($lessons as $lesson) {

            if ($lesson->lang != null) {

                $student_mark = Students_mark::where('student_id', $student->id)->where('lang', $student_lang)->where('year_id', $year->id)->first();

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

        if ($request->has('select_lang')) {

            if ($request->select_lang == '0') {
                $lessons = Lesson::where('class_id', $class->id)->where('lang', '0')->get();
            } elseif ($request->select_lang == '1') {
                $lessons = Lesson::where('class_id', $class->id)->where('lang', '1')->get();
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
                $a5[$lesson->id] = ['year_result' => null];
                $item->result = json_encode($a5);
                $item->save();
            }
        }
        $student_mark_new = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();
        $student_mark_new->lang = $request->select_lang;
        $student_mark_new->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function invoice_store(Request $request)
    {
        
        $year = Year::where('current_year', '1')->first();
        Invoice::create([

            'invoice_number' => $request->invoice_number,
            'invoice_amount' => $request->invoice_amount,
            'payment_type' => $request->payment_type,
            'bank_name' => $request->bank_name,
            'student_id' => $request->student_id,
            'class_id' => $request->class_id,
            'year_id' => $year->id,

        ]);
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
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




    public function student_change(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
        $student_room = Room_student::where('student_id', $request->student_id)
            ->where('year_id', $year->id)->first();


        if ($student_room) {

            if ($student_room->room_id == $request->room_change_id) {
                return redirect()->back()->with('success', 'لا يوجد اي تعديل !');
            }


            $student = Student::find($request->student_id);

            $class_id = $student->room()->where('rooms.year_id', $year->id)->first()->class_id;

            if ($class_id == $request->class_change_id || $class_id == $request->old_class_id) {


                $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();
                $student_room->room_id = $request->room_change_id;
                $student_room->save();

                $student_mark->room_id = $request->room_change_id;
                $student_mark->save();
                return redirect()->back()->with('success', 'تم تعديل الشعبة الدراسية !');
            }
        }

        $student_room = Room_student::where('student_id', $request->student_id)
            ->where('year_id', $year->id)->get();
        $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->get();

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

        $lessons = Lesson::where('class_id', $request->class_change_id)->get();
        $object1 = new stdClass();
        foreach ($lessons as $item) {
            $object1->{$item->id}['oral'] = $request->oral;
            $object1->{$item->id}['homework'] = $request->homework;
            $object1->{$item->id}['activities'] = $request->activities;
            $object1->{$item->id}['quize'] = $request->quize;
            $object1->{$item->id}['exam'] = $request->exam;
        }

        $object2 = new stdClass();
        foreach ($lessons as $item) {
            $object2->{$item->id}['oral'] = $request->oral;
            $object2->{$item->id}['homework'] = $request->homework;
            $object2->{$item->id}['activities'] = $request->activities;
            $object2->{$item->id}['quize'] = $request->quize;
            $object2->{$item->id}['exam'] = $request->exam;
        }

        $object_result1 = new stdClass();

        foreach ($lessons as $item) {
            $object_result1->{$item->id}['term1_quizes'] = null;
            $object_result1->{$item->id}['term1_exam'] = null;
            $object_result1->{$item->id}['term1_result'] = null;
        }


        $object_result2 = new stdClass();

        foreach ($lessons as $item) {
            $object_result2->{$item->id}['term2_quizes'] = null;
            $object_result2->{$item->id}['term2_exam'] = null;
            $object_result2->{$item->id}['term2_result'] = null;
        }

        $object_result = new stdClass();

        foreach ($lessons as $item) {
            $object_result->{$item->id}['year_result'] = null;
        }

        $object_result_term = new stdClass();

        $object_result_term->{'term1'} = null;
        $object_result_term->{'term2'} = null;


        Students_mark::create([
            'student_id' => $request->student_id,
            'room_id' => $request->room_change_id,
            'year_id' => $year->id,
            'mark' => json_encode($object1),
            'mark2' => json_encode($object2),
            'result1' => json_encode($object_result1),
            'result2' => json_encode($object_result2),
            'result' => json_encode($object_result),
            'term_result' => json_encode($object_result_term),

            'status' => '1',
            'lang' => $student->lang,
        ]);



        if ($student->lang == '0') {
            $lessons = Lesson::where('class_id', $request->class_change_id)->where('lang', '1')->get();
        } elseif ($student->lang == '1') {
            $lessons = Lesson::where('class_id', $request->class_change_id)->where('lang', '0')->get();
        }


        foreach ($lessons as $lesson) {

            if ($lesson->lang != null) {

                $student_mark = Students_mark::where('student_id', $student->id)->where('lang', $student->lang)->where('year_id', $year->id)->first();

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
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }





    public function result_disable()
    {

        $students = Student::all();
        foreach ($students as $student) {
            $student->status = '0';
            $student->save();
        }

        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }


    public function result_active()
    {

        $students = Student::all();
        foreach ($students as $student) {
            $student->status = '1';
            $student->save();
        }

        return redirect()->back()->with('success', '! تمت العملية بنجاح ');
    }




     public function student_store(Request $request)
    {


        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'father_name' => 'required',
            'phone' => 'required',
            'class_id' => 'required|Numeric',
            'room_id' => 'required|Numeric',
             'public_record_number'=>'required|Numeric|unique:students',
                ],[
              'public_record_number.unique' => 'رقم السجل العام موجود مسبقاً'
        ]);

        $student = Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'place_birth' => $request->place_birth,
            'date_birth' => $request->date_birth,
            'box_birth' => $request->box_birth,
            'nationality' => $request->nationality,
            'army_room' => $request->army_room,
            'address' => $request->address,
            'public_record_number' =>  $request->public_record_number,
            'class_id' => $request->class_id,
            'room_id' => $request->room_id,
            'place' => $request->place,
            'transparent' => $request->status,
            'lang' => '0',
            'religion' => $request->religion,
             'country'=>$request->country

        ]);
        $student->first_name_en =$request->first_name_en;
        $student->last_name_en =$request->last_name_en;
        $student->country_currency =$request->country_currency;

        $student->save() ;
        $year = Year::where('current_year', '1')->first();
        $rooom = Room::find($request->room_id);
        Invoice::create([
            'invoice_number' => $student->id,
            'invoice_amount' => 0,
                        'payment_type' => '',
            'bank_name' => '',
            'student_id' => $student->id,
            'class_id' => $rooom->class_id,
            'year_id' => $year->id,
        ]);

        $student_detail = new Student_detail;
        $student_detail->student_id = $student->id;
        $student_detail->phone = $request->phone;
        $student_detail->father_name = $request->father_name;
        $student_detail->mother_name = $request->mother_name;
        $student_detail->mother_phone = $request->mother_phone;
        $student_detail->father_phone = $request->father_phone;
        $student_detail->save();



        $user = User::create([
            'name' => $request->first_name,
            'email' => "a@app.com",
            'mobile' => $request->phone,
            'password' => Hash::make(5),
            'view_password' => 5,
            'type' => '0',
            'student_id' => $student->id,

        ]);

        $email = str_replace(" ", "", $request->first_name_en) . str_replace(" ", "", $request->last_name_en) . rand(1, 1000) . "@aladham.com";
        if (strlen($request->first_name_en) > 2) {
            $namee = substr($request->first_name_en, 0, 3);
        } else {
            $namee = "aladham";
        }
        $password = $namee . "@" . rand(100000, 900000);
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->view_password = $password;
        $user->save();
        $student->email = $email;
        $student->save();

        $year = Year::where('current_year', '1')->first();

        $room_student = new Room_student;
        $room_student->student_id = $student->id;
        $room_student->year_id = $year->id;

        $room_student->room_id = $request->room_id;
        $room_student->term = 1;
        $room_student->save();

        $lessons = Lesson::where('class_id', $request->class_id)->get();
        $object1 = new stdClass();
        foreach ($lessons as $item) {
            $object1->{$item->id}['oral'] = $request->oral;
            $object1->{$item->id}['homework'] = $request->homework;
            $object1->{$item->id}['activities'] = $request->activities;
            $object1->{$item->id}['quize'] = $request->quize;
            $object1->{$item->id}['exam'] = $request->exam;
        }

        $object2 = new stdClass();
        foreach ($lessons as $item) {
            $object2->{$item->id}['oral'] = $request->oral;
            $object2->{$item->id}['homework'] = $request->homework;
            $object2->{$item->id}['activities'] = $request->activities;
            $object2->{$item->id}['quize'] = $request->quize;
            $object2->{$item->id}['exam'] = $request->exam;
        }

        $object_result1 = new stdClass();

        foreach ($lessons as $item) {
            $object_result1->{$item->id}['term1_quizes'] = null;
            $object_result1->{$item->id}['term1_exam'] = null;
            $object_result1->{$item->id}['term1_result'] = null;
        }


        $object_result2 = new stdClass();

        foreach ($lessons as $item) {
            $object_result2->{$item->id}['term2_quizes'] = null;
            $object_result2->{$item->id}['term2_exam'] = null;
            $object_result2->{$item->id}['term2_result'] = null;
        }

        $object_result = new stdClass();

        foreach ($lessons as $item) {
            $object_result->{$item->id}['year_result'] = null;
        }

        $object_result_term = new stdClass();

        $object_result_term->{'term1'} = null;
        $object_result_term->{'term2'} = null;

        // return json_encode($object_result_term);
        $year = Year::where('current_year', '1')->first();

         Students_mark::create([
            'student_id' => $student->id,
            'room_id' => $request->room_id,
            'year_id' => $year->id,
            'mark' => json_encode($object1),
            'mark2' => json_encode($object2),
            'result1' => json_encode($object_result1),
            'result2' => json_encode($object_result2),
            'result' => json_encode($object_result),
            'term_result' => json_encode($object_result_term),
            'status' => '1',
            'lang' => '0',
            'religion' => $request->religion,

        ]);


        if ($student->lang == 0) {
            $lessons = Lesson::where('class_id', $request->class_id)->where('lang', '1')->get();
        } elseif ($student->lang == 1) {
            $lessons = Lesson::where('class_id', $request->class_id)->where('lang', '0')->get();
        }



        foreach ($lessons as $lesson) {

            if ($lesson->lang != null) {

                $student_mark = Students_mark::where('student_id', $student->id)->where('lang', $student->lang)->where('year_id', $year->id)->first();




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


        if ($student->religion == 0) {
            $lessons = Lesson::where('class_id', $request->class_id)->where('religion', '1')->get();
        } elseif ($student->religion == 1) {
            $lessons = Lesson::where('class_id', $request->class_id)->where('religion', '0')->get();
        }



        foreach ($lessons as $lesson) {

            if ($lesson->religion != null) {
                 $student_mark = Students_mark::where('student_id', $student->id)->where('religion', $request->religion)->where('year_id', $year->id)->first();



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
        return redirect()->back()->with('success', ' ! تمت العملية بنجاح ');
    }


     public function getstudentsfina(Request $request)
        {
            $draw = $request->draw;
            $start = $request->start;
            $rowperpage = $request->length; // Rows display per page

            $columnIndex_arr = $request->order;
            $columnName_arr = $request->columns;
            $search_arr = $request->search;
            $search_bar = $request->barcode_pos_check;

            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $searchValue = $search_arr['value']; // Search value
            if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
                $searchValue = "";
            } else {
                $searchValue = explode('*', $searchValue);
            }
            $records = new Collection;
            // $searchValue = array_filter($searchValue, 'strlen');
            $result_search = "";
            foreach ($searchValue as $key => $item_search) {
                if ($key == 0) {
                    $result_search = "%". $item_search . "%";
                } else {
                    $result_search .= "%" . $item_search . "%";
                }
            }
            $year1 = Year::where('current_year','1')->first();

            if ($request->amount == "") {
                $request->amount = 0;
            }
            if(in_array("student_hidden", Auth::user()->role->permissions)){
            if ($request->type == "0") {

                    $totalRecordswithFilter = DB::table('students')->where('students.first_name',"like",$result_search)->where('hidden',0)->orwhere('students.last_name',"like",$result_search)->where('hidden',0)->orwhere('classes.name',"like",$result_search)
                    ->where('room_student.year_id',$year1->id)
                    ->where('hidden',0)
                     ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                    ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                    
                    // ->join('room_student', 'room_student.student_id', '=', 'students.id')
                    ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                    ->join('classes', 'rooms.class_id', '=', 'classes.id')
                    ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                    ->groupBy('invoices.student_id',"students.id",'classes.id')->having('remain_total',">",doubleval($request->amount))
                    ->get()->count();     

                    $records = DB::table('students')->where('students.first_name',"like",$result_search)->where('hidden',0)->orwhere('students.last_name',"like",$result_search)->where('hidden',0)->orwhere('classes.name',"like",$result_search)
                    ->where('room_student.year_id',$year1->id)
                    ->where('hidden',0)
                    ->where('invoices.year_id',$year1->id)
                    ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                    ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                    
                    // ->join('room_student', 'room_student.student_id', '=', 'students.id')
                    ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                    ->join('classes', 'rooms.class_id', '=', 'classes.id')
                    ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                    ->groupBy('invoices.student_id',"students.id",'classes.id')->having('remain_total',">",doubleval($request->amount))
                    ->skip($start)
                    ->take($rowperpage)->get();

            }else if($request->type == "1"){

                $totalRecordswithFilter = DB::table('students')->where('students.first_name',"like",$result_search)->where('hidden',0)->orwhere('students.last_name',"like",$result_search)->where('hidden',0)->orwhere('classes.name',"like",$result_search)
                ->where('room_student.year_id',$year1->id)
                ->where('hidden',0)
                // ->join('invoices', 'invoices.student_id', '=', 'students.id')
                 ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id',"students.id",'classes.id')->having('total',">",doubleval($request->amount))
                ->get()->count();

                $records = DB::table('students')->where('students.first_name',"like",$result_search)->where('hidden',0)->orwhere('students.last_name',"like",$result_search)->where('hidden',0)->orwhere('classes.name',"like",$result_search)
                ->where('room_student.year_id',$year1->id)
                ->where('hidden',0)
                // ->join('invoices', 'invoices.student_id', '=', 'students.id')
                 ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id',"students.id",'classes.id')->having('total',">",doubleval($request->amount))
                ->skip($start)
                ->take($rowperpage)->get();


            }else{
                $totalRecordswithFilter = DB::table('students')->where('students.first_name',"like",$result_search)->where('hidden',0)->orwhere('students.last_name',"like",$result_search)->where('hidden',0)->orwhere('classes.name',"like",$result_search)
                ->where('room_student.year_id',$year1->id)
                ->where('hidden',0)
           
                // ->join('invoices', 'invoices.student_id', '=', 'students.id')
                 ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                // ->join('room_student', 'room_student.student_id', '=', 'students.id')
                 ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id',"students.id",'classes.id')->having('total',"<",doubleval($request->amount))
                ->get()->count();

                $records = DB::table('students')->where('students.first_name',"like",$result_search)->where('hidden',0)->orwhere('students.last_name',"like",$result_search)->where('hidden',0)->orwhere('classes.name',"like",$result_search)
                ->where('room_student.year_id',$year1->id)
                ->where('hidden',0)
       
                // ->join('invoices', 'invoices.student_id', '=', 'students.id')
                 ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                // ->join('room_student', 'room_student.student_id', '=', 'students.id')
                 ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id',"students.id",'classes.id')->having('total',"<",doubleval($request->amount))
                ->skip($start)
                ->take($rowperpage)->get();
        }
    }
            else{
                if ($request->type == "0") {

                    $totalRecordswithFilter = DB::table('students')->where('students.first_name',"like",$result_search)->
                    orwhere('students.last_name',"like",$result_search)->orwhere('classes.name',"like",$result_search)
                    ->where('room_student.year_id',$year1->id)
                     ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                    ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                    
                    // ->join('room_student', 'room_student.student_id', '=', 'students.id')
                    ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                    ->join('classes', 'rooms.class_id', '=', 'classes.id')
                    ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                    ->groupBy('invoices.student_id',"students.id",'classes.id')->having('remain_total',">",doubleval($request->amount))
                    ->get()->count();

                    $records = DB::table('students')->where('students.first_name',"like",$result_search)->orwhere('students.last_name',"like",$result_search)->orwhere('classes.name',"like",$result_search)
                    ->where('room_student.year_id',$year1->id)->where('invoices.year_id',$year1->id)
                    ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                    ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                    
                    // ->join('room_student', 'room_student.student_id', '=', 'students.id')
                    ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                    ->join('classes', 'rooms.class_id', '=', 'classes.id')
                    ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                    ->groupBy('invoices.student_id',"students.id",'classes.id')->having('remain_total',">",doubleval($request->amount))
                    ->skip($start)
                    ->take($rowperpage)->get();

            }else if($request->type == "1"){

                $totalRecordswithFilter = DB::table('students')->where('students.first_name',"like",$result_search)->orwhere('students.last_name',"like",$result_search)->orwhere('classes.name',"like",$result_search)
                ->where('room_student.year_id',$year1->id)
                // ->join('invoices', 'invoices.student_id', '=', 'students.id')
                 ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id',"students.id",'classes.id')->having('total',">",doubleval($request->amount))
                ->get()->count();

                $records = DB::table('students')->where('students.first_name',"like",$result_search)->orwhere('students.last_name',"like",$result_search)->orwhere('classes.name',"like",$result_search)
                ->where('room_student.year_id',$year1->id)
                // ->join('invoices', 'invoices.student_id', '=', 'students.id')
                 ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id',"students.id",'classes.id')->having('total',">",doubleval($request->amount))
                ->skip($start)
                ->take($rowperpage)->get();

            }else{
                $totalRecordswithFilter = DB::table('students')->where('students.first_name',"like",$result_search)->orwhere('students.last_name',"like",$result_search)->orwhere('classes.name',"like",$result_search)
                ->where('room_student.year_id',$year1->id)
                // ->join('invoices', 'invoices.student_id', '=', 'students.id')
                 ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                // ->join('room_student', 'room_student.student_id', '=', 'students.id')
                 ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id',"students.id",'classes.id')->having('total',"<",doubleval($request->amount))
                ->get()->count();

                $records = DB::table('students')->where('students.first_name',"like",$result_search)->orwhere('students.last_name',"like",$result_search)->orwhere('classes.name',"like",$result_search)
                ->where('room_student.year_id',$year1->id)
                // ->join('invoices', 'invoices.student_id', '=', 'students.id')
                 ->join('invoices', function ($join) use ($year1) {
                     $join->on('students.id', '=', 'invoices.student_id')
                     ->where('invoices.year_id', '=', $year1->id);
                    })
                // ->join('room_student', 'room_student.student_id', '=', 'students.id')
                 ->join('room_student',  function ($join) use ($year1) {
                     $join->on('students.id', '=', 'room_student.student_id')
                     ->where('room_student.year_id', '=', $year1->id);
                    })
                ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                ->join('classes', 'rooms.class_id', '=', 'classes.id')
                ->select(DB::raw('students.*'),DB::raw('classes.fixed_cost'),DB::raw('classes.name as classname'),DB::raw('classes.id as class_id'),DB::raw('sum(invoices.invoice_amount) as total'),DB::raw('classes.fixed_cost - sum(invoices.invoice_amount) as remain_total'))
                ->groupBy('invoices.student_id',"students.id",'classes.id')->having('total',"<",doubleval($request->amount))
                ->skip($start)
                ->take($rowperpage)->get();
            }
            }
            $totalRecords = Student::count();

            $data_arr = array();
            foreach ($records as $record) {
                $data_arr[] = array(
                    "id" => $record->id,
                    "first_name" => $record->first_name,
                    "last_name" => $record->last_name,
                    "total" => $record->total,
                    "remain_total" => $record->remain_total,
                    "class" => $record->classname,
                    "class_id" => $record->class_id,
                    "fixed_cost" => $record->fixed_cost,
                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr,
                "$result_search" => $result_search
            );
            echo json_encode($response);
            exit;
        }




    public function getusers(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;


        $columnIndex = $columnIndex_arr[0]['column'];
        $columnIndex = $columnIndex > 1 ? 0 : $columnIndex;
        $array_of_sorting = ['name',]; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

        $totalRecords = User::count();
        $totalRecordswithFilter = User::where('type', '2')->where('name', "like", "%" . $result_search . "%")->count();
        $records = User::where('type', '2')->where('name', "like", "%" . $result_search . "%")->skip($start)
            ->take($rowperpage)->with('role')->orderBy($array_of_sorting[$columnIndex], $columnIndex_arr[0]['dir'])->get();


        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = $record;
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

    public function getstudents(Request $request)
    {
        try {
            $draw = $request->draw;
            $start = $request->start;
            $rowperpage = $request->length;
        
            $searchValue = $request->search['value'] ?? '';
            $searchValue = '%' . str_replace('*', '%', $searchValue) . '%';
            $class_filter = $request->class_id;
            $room_filter = $request->room_id;
            $stage_id = $request->stage_id;
    
            // Normalize search value (e.g., remove diacritics if needed)
            $searchValue = preg_replace('/[\p{Mn}]/u', '', $searchValue);
        
            // Initialize query
            $query = Student::query()
                ->where(function ($q) use ($searchValue) {
                    $q->where('first_name', 'like', $searchValue)
                      ->orWhere('last_name', 'like', $searchValue)
                      ->orWhere('public_record_number', 'like', $searchValue);
                })
                ->whereHas('room.classes', function ($q) use ($class_filter, $room_filter, $stage_id) {
                    $year = Year::where('current_year', '1')->first();
                    if ($class_filter) {
                        $q->where('classes.id', $class_filter)
                          ->where('room_student.year_id', $year->id);
                    }
                    if ($room_filter) {
                        $q->where('rooms.id', $room_filter);
                    }
                    if ($stage_id) {
                        $classIds = Basic_stages_class::where('stage_id', $stage_id)->pluck('class_id');
                        $q->whereIn('classes.id', $classIds);
                    }
                });
        
            // Total records count
            $totalRecords = $query->count();
    
            // Apply pagination
            $records = $query->skip($start)
                             ->take($rowperpage)
                             ->with('room.classes', 'user', 'details')
                             ->get();
        
            // Prepare data array
            $data_arr = $records->map(function ($record) {
                return [
                    "first_name" => $record->first_name,
                    "last_name" => $record->last_name,
                    "address" => $record->address,
                    "phone" => $record->phone,
                    "img" => $record->image,
                    "room" => $record->room,
                    "id" => $record->id,
                    "lang" => $record->lang,
                    "user" => $record->user,
                    "details" => $record->details,
                    "public_record_number" => $record->public_record_number,
                ];
            });
    
            // Prepare response
            $response = [
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecords,
                "aaData" => $data_arr
            ];
        
            return response()->json($response);
        } catch (\Exception $e) {
            // Log the exception message
            \Log::error($e->getMessage());
        
            // Return an error response
            return response()->json([
                "error" => "An unexpected error occurred. Please try again later."
            ], 500);
        }
    }
    
  public function getstudents_secret_keeper(Request $request)
{
    $classes_roles = Classe_role_secret_keeper::where('role_id', auth()->user()->role_id)->get();
         $classroles = [];
        foreach ($classes_roles as $item) {
                $classroles[] = $item->class_id;
        };

    $draw = $request->draw;
    $start = $request->start;
    $rowperpage = $request->length; // Rows display per page

    $columnIndex_arr = $request->order;
    $columnName_arr = $request->columns;
    $search_arr = $request->search;
    $class_filter = $request->class_id;
    $room_filter = $request->room_id;
     $stage_id = $request->stage_id;
    $search_bar = $request->barcode_pos_check;
    // $store = Store::where('quantity','>',0)->get();
    // foreach($store as $store_item){
    //     $ids[] = $store_item->product_id;
    // }

    $columnIndex = $columnIndex_arr[0]['column'];
    $columnIndex = $columnIndex > 2 ? 0 : $columnIndex;
    $array_of_sorting = ['first_name', 'last_name',]; // Column index
    $searchValue = $search_arr['value']; // Search value
    if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
        $searchValue = "";
    } else {
        $searchValue = explode('*', $searchValue);
    }
    $records = new Collection;
    // $searchValue = array_filter($searchValue, 'strlen');
    $result_search = "";
    foreach ($searchValue as $key => $item_search) {
        if ($key == 0) {
            $result_search = "%" . $item_search . "%";
        } else {
            $result_search .= "%" . $item_search . "%";
        }
    }
    $class1=[];
      $stage =Basic_stages_class::where('stage_id',$stage_id)->get();
    foreach($stage as $item ){
        $class1[]=$item->class_id;
    }


    if(in_array("student_hidden", Auth::user()->role->permissions)){
        $totalRecords = Student::where('hidden',0)->WhereHas('room.classes', function ($q) use ($classroles) {
                $q->whereIn('classes.id', $classroles);
            }
        )->count();
    $totalRecordswithFilter = Student::where('first_name', "like", "%" . $result_search . "%")
        ->WhereHas('room.classes', function ($q) use ($class_filter, $room_filter,$stage_id,$class1,$classroles) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
            else if ($stage_id != 0 && $stage_id != null) {
                $q->whereIn('classes.id', $class1);
            }
            else {
                $q->whereIn('classes.id', $classroles);
            }
        })->where('hidden',0)
        ->orwhere('last_name', "like", "%" . $result_search . "%")
        ->WhereHas('room.classes', function ($q) use ($class_filter, $room_filter,$stage_id,$class1,$classroles) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
            else if ($stage_id != 0 && $stage_id != null) {
                $q->whereIn('classes.id', $class1);
            }
            else {
                $q->whereIn('classes.id', $classroles);
            }
        })->where('hidden',0)
        ->with('room.classes')->with(['room' => function ($q1) use ($room_filter) {
            $year = Year::where('current_year', '1')->first();
            if ($room_filter != "" && $room_filter != null) {
                $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else {
                $q1->where('room_student.year_id', $year->id);
            }
        }])->count();
    $records = Student::where('first_name', "like", "%" . $result_search . "%")
        ->WhereHas('room.classes', function ($q) use ($class_filter, $room_filter,$stage_id,$class1,$classroles) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
            else if ($stage_id != 0 && $stage_id != null) {
                $q->whereIn('classes.id', $class1);
            }
            else {
                $q->whereIn('classes.id', $classroles);
            }
        })->where('hidden',0)
        ->orwhere('last_name', "like", "%" . $result_search . "%")
        ->WhereHas('room.classes', function ($q) use ($class_filter, $room_filter,$stage_id,$class1,$classroles) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
            else if ($stage_id != 0 && $stage_id != null) {
                $q->whereIn('classes.id', $class1);
            }
            else {
                $q->whereIn('classes.id', $classroles);
            }
        })->where('hidden',0)
        ->with('room.classes', 'user', 'details')->with(['room' => function ($q1) use ($room_filter) {
            $year = Year::where('current_year', '1')->first();
            if ($room_filter != "" && $room_filter != null) {
                $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else {
                $q1->where('room_student.year_id', $year->id);
            }
        }])->skip($start)
        ->take($rowperpage)->get();
    }
    else {
         $totalRecords = Student::WhereHas('room.classes', function ($q) use ($classroles) {
                $q->whereIn('classes.id', $classroles);
            }
        )->count();
        $totalRecordswithFilter = Student::where('first_name', "like", "%" . $result_search . "%")
        ->WhereHas('room.classes', function ($q) use ($class_filter, $room_filter,$stage_id,$class1,$classroles) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
            else if ($stage_id != 0 && $stage_id != null) {
                $q->whereIn('classes.id', $class1);
            }
            else {
                $q->whereIn('classes.id', $classroles);
            }
        })
        ->orwhere('last_name', "like", "%" . $result_search . "%")
        ->WhereHas('room.classes', function ($q) use ($class_filter, $room_filter,$stage_id,$class1,$classroles) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
            else if ($stage_id != 0 && $stage_id != null) {
                $q->whereIn('classes.id', $class1);
            }
            else {
                $q->whereIn('classes.id', $classroles);
            }
        })
        ->with('room.classes')->with(['room' => function ($q1) use ($room_filter) {
            $year = Year::where('current_year', '1')->first();
            if ($room_filter != "" && $room_filter != null) {
                $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else {
                $q1->where('room_student.year_id', $year->id);
            }
        }])->count();
    $records = Student::where('first_name', "like", "%" . $result_search . "%")
        ->WhereHas('room.classes', function ($q) use ($class_filter, $room_filter,$stage_id,$class1,$classroles) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
            else if ($stage_id != 0 && $stage_id != null) {
                $q->whereIn('classes.id', $class1);
            }
            else {
                $q->whereIn('classes.id', $classroles);
            }
        })
        ->orwhere('last_name', "like", "%" . $result_search . "%")
        ->WhereHas('room.classes', function ($q) use ($class_filter, $room_filter,$stage_id,$class1,$classroles) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else if ($class_filter != "" && $class_filter != null) {
                $q->where('classes.id', $class_filter);
            }
            else if ($stage_id != 0 && $stage_id != null) {
                $q->whereIn('classes.id', $class1);
            }
            else {
                $q->whereIn('classes.id', $classroles);
            }
        })
        ->with('room.classes', 'user', 'details')->with(['room' => function ($q1) use ($room_filter) {
            $year = Year::where('current_year', '1')->first();
            if ($room_filter != "" && $room_filter != null) {
                $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else {
                $q1->where('room_student.year_id', $year->id);
            }
        }])->skip($start)
        ->take($rowperpage)->get();
    }

    $data_arr = array();
    foreach ($records as $record) {
        $data_arr[] = array(
            "first_name" => $record->first_name,
            "last_name" => $record->last_name,
            "address" => $record->address,
            "phone" => $record->phone,
            "img" => $record->image,
            "room" => $record->room,
            "id" => $record->id,
            "lang" => $record->lang,
            "user" => $record->user,
            "details" => $record->details,

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



      public function student_details($student_id)
    {


        $year = Year::where('current_year', '1')->first();
        $student = Student::with(['room' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->with("user")->find($student_id);
        $room = $student->room;
         $student_detail = Student_detail::where('student_id', $student->id)->first();


        // if($room->isEmpty()){
        //     return redirect()->back();
        // }

        $student_mark = Students_mark::where('student_id', $student_id)->where('year_id', $year->id)->first();

        $lessons =  $room[0]->classes->lessons;
        $classes = Classe::all();
        $class_id = $student->room[0]->classes->id;
        $rooms = Room::where('class_id', $class_id)->where('year_id', $year->id)->get();
        //  return $student ;

        // $rooms=
         $student_details_departments=Student_details_department::with(['student_details_department_field.student_details_field_value' => function ($q1) use ($student_id) {
            $q1->where('student_id', $student_id);
        }])->get();
        $country_currency = Country_currency::where('active',1)->get();
        return view('admin.student_details', compact('student_details_departments','country_currency','student', 'student_mark', 'lessons', 'classes', 'rooms', 'student_detail'));
    }

    public function change_password(Request $request)
    {
        $user = User::find($request->user_id);
        $user->view_password = $request->password;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back();
    }

   // public function class_store(Request $request)
  // {
//
   //     $request->validate([
  //          'class_name' => 'required|max:20',
  //          'class_name_en' => 'required|max:20',
//
    //        'fixed_cost' => 'required',
   //         'stage_id' => 'required',
   //         'report_card' => 'required',
   //         'next_class' => 'required',
     //   ]);
     //   $class = new Classe;
    //    $class->name = $request->class_name;
     //   $class->name_en = $request->class_name_en;

    //    //$class->fixed_cost = $request->fixed_cost;
     //   $class->fixed_cost = json_encode($request->fixed_cost);
     //   $class->stage_id = $request->stage_id;
     //   $class->report_card = $request->report_card;
     //   $class->next_class = $request->next_class;

      //  if ($request->hasFile('image')) {
//
      //      $class->image = $request->image->store('classimages', 'public');
     //   }
//
      //  $class->save();
     //   return redirect()->back()->with('success', '! تمت العملية بنجاح');
   // }

    public function class_store(Request $request)
{
    // Create a new class

    $request->validate([
           'class_name' => 'required|max:20',
           'class_name_en' => 'required|max:20',

    //        'fixed_cost' => 'required',

            'next_class' => 'required',
       ]);
       $class = new Classe;
      $class->name = $request->class_name;
      $class->name_en = $request->class_name_en;
      $class->fixed_cost = $request->fixed_cost;
      $class->description_en = $request->description_en;
      $class->description_ar = $request->description_ar;
      $class->cildren_count = $request->cildren_count;
      $class->lesson_count = $request->lesson_count;
      $class->week_count = $request->week_count;

    //    //$class->fixed_cost = $request->fixed_cost;
    //   $class->fixed_cost = json_encode($request->fixed_cost);
    $class->stage_id = $request->stage_id;
      $class->report_card = $request->report_card;
      $class->next_class = $request->next_class;
       $class->is_scientific = $request->is_scientific;

        if ($request->hasFile('image')) {

           $class->image = $request->image->store('classimages', 'public');
       }

    $class->save();

    // Retrieve the class_id from the request
    // foreach($request->countries as $key=>$val){

    //         $classCost = new Class_cost();
    //         $classCost->class_id = $class->id;
    //         $classCost->country_id = $key;
    //         $classCost->cost = $val;
    //         $classCost->save();
    // }
        //   $stage_class = new  Basic_stages_class();
        //     $stage_class->stage_id = $request->stages_id;
        //     $stage_class->class_id = $class->id;
        //     $stage_class->save();



    return redirect()->back()->with('success', '! تمت العملية بنجاح');
}


   // public function class_update(Request $request)
    //{
//
    //    $class_id = $request->class_id;
   //     $class = Classe::find($class_id);
   //     $class->name = $request->class_name;
   //     $class->name_en = $request->class_name_en;
//
    //    //$class->fixed_cost = $request->fixed_cost;
     //
    //     $fixed_cost = [];
     //    foreach ($request->fixed_cost as $key => $value) {
     //    $fixed_cost[$key] = $value;
      //  }
//
     //   $class->fixed_cost = json_encode($fixed_cost);
     //
     //   $class->stage_id = $request->stage_id;
     //   $class->report_card = $request->report_card;
     //   $class->next_class = $request->next_class;
//
      //  if ($request->has('del_img1')) {
     //      Storage::disk('public')->delete($class->image);
      //      $class->image = null;
      //  }
      //  if ($request->hasFile('image')) {
       //     Storage::disk('public')->delete($class->image);
       //     $class->image = $request->image->store('classimages', 'public');
      //  }
//
      //  $class->save();
      //  return redirect()->back()->with('success', '! تمت العملية بنجاح');
 //   }
public function class_update(Request $request)
{
     $class_id = $request->class_id;
    $class = Classe::find($class_id);

    if (!$class) {
        return redirect()->back()->with('error', 'Class not found');
    }

    // Update class properties
    $class->name = $request->class_name;
    $class->name_en = $request->class_name_en;
    $class->stage_id = $request->stage_id;
    $class->report_card = $request->report_card;
    $class->next_class = $request->next_class;
    $class->fixed_cost = $request->fixed_cost;
    $class->description_en = $request->description_en;
    $class->description_ar = $request->description_ar;
    $class->cildren_count = $request->cildren_count;
    $class->lesson_count = $request->lesson_count;
    $class->week_count = $request->week_count;
    $class->is_scientific = $request->is_scientific;
    // Handle image upload
    if ($request->has('del_img1')) {
        Storage::disk('public')->delete($class->image);
        $class->image = null;
    }
    if ($request->hasFile('image')) {
        Storage::disk('public')->delete($class->image);
        $class->image = $request->image->store('classimages', 'public');
    }

    $class->save();
      Class_cost::where('class_id', $class->id)->delete();
 
     Basic_stages_class::where('class_id', $class->id)->delete();
     $stage_class = new  Basic_stages_class();
            $stage_class->stage_id = $request->stages_id;
            $stage_class->class_id = $class->id;
            $stage_class->save();

    return redirect()->back()->with('success', '! تمت العملية بنجاح');
}



    public function teacher_delete(Request $request)
    {

        // $delete_code = Hash::make($request->delete_code);
        $formed_code = Auth::User()->view_password;
        if ($formed_code == $request->delete_code) {
            $exam = Lesson_teacher_room_term_exam::where('teacher_id', $request->teacher_id_delete)->get();
            $w = [];
            $r = [];
            foreach ($exam as $x) {
                $w[] = $x->id;
            }
            $exam_result = Exam_result::whereIn('exam_id', $w)->get();
            foreach ($exam_result as $x1) {
                $x1->delete();
            }
            $stu = Student_lesson_teacher_room_term_exam::whereIn('exam_id', $w)->get();

            foreach ($stu as $x2) {
                $x2->delete();
            }

            $question = Question::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($exam as $x3) {
                $r[] = $x3->id;
            }
            $option = Option::whereIn('question_id', $r)->get();
            foreach ($option as $x22) {
                $x22->delete();
            }
            foreach ($question as $x23) {
                $x23->delete();
            }
            foreach ($exam as $x24) {
                $x24->delete();
            }
            $lec =  Lecture::where('teacher_id', $request->teacher_id_delete)->get();
            $rr = [];
            foreach ($lec as $x34) {
                $rr[] = $x34->id;
            }
            $section =  Section::whereIn('lecture_id', $rr)->get();
            foreach ($section as $x441) {
                $x441->delete();
            }
            foreach ($lec as $x44) {
                $x44->delete();
            }


            $prepare = Prepare::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($prepare as $x44) {
                $x44->delete();
            }
            $Unit_analysis = Unit_analysis::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($Unit_analysis as $x44) {
                $x44->delete();
            }
            $Planification_trimestrielle = Planification_trimestrielle::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($Planification_trimestrielle as $x44) {
                $x44->delete();
            }


            $lesson_room_teacher_lecture_time = Lesson_room_teacher_lecture_time::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($lesson_room_teacher_lecture_time as $x44) {
                $x44->delete();
            }
            $lesson_room_teacher_lecture_time = Lesson_room_teacher_lecture_time::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($lesson_room_teacher_lecture_time as $x44) {
                $x44->delete();
            }

            $message = Message::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($message as $x44) {
                $x44->delete();
            }
            $room_lesson_exam = Room_lesson_exam::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($room_lesson_exam as $x44) {
                $x44->delete();
            }
            $teacher_room_lesson = Teacher_room_lesson::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($teacher_room_lesson as $x44) {
                $x44->delete();
            }
            $teacher_event = Teacher_event::where('teacher_id', $request->teacher_id_delete)->get();
            foreach ($teacher_room_lesson as $x44) {
                $x44->delete();
            }
            ////  المكافأت والعقوبات
            $rewards_and_sanction_student=Rewad_and_sanction_student::where('teacher_id',$request->teacher_id_delete)->get();
            foreach($rewards_and_sanction_student as $item){

                $item->delete();
            }


            $user = User::where('teacher_id', $request->teacher_id_delete)->first();
            $user->delete();
            Teacher::findOrFail($request->teacher_id_delete)->delete();
            $messgaes = Message::where('teacher_id', $request->teacher_id_delete)->delete();


            return redirect()->back()->with('success', '! تمت العملية بنجاح');
        } else {
            return redirect()->back()->with('error', '! تأكد من الداتا البيانات  ');
        }
    }

    public function session_delete(Request $request)
    {
        // return $request ;
        $session = Lecture_time::find($request->id);
        if (isset($session)) {
            $to_delete1 = Lesson_room_teacher_lecture_time::where('lecture_time_id', $session->id)->get();
            foreach ($to_delete1 as $x) {
                $old_teacher = $x->teacher_id;
                $old_lesson = $x->lesson_id;
                $old_room = $x->room_id;
                $x->delete();
                $item2 =  Lesson_room_teacher_lecture_time::where('room_id', $old_room)
                    ->where('lesson_id', $old_lesson)->where('teacher_id', $old_teacher)->first();
                //  return $item2 ;
                if (!isset($item2)) {
                    $pivot =   Teacher_room_lesson::where('lesson_id', $old_lesson)
                        ->where('room_id', $old_room)->where('teacher_id', $old_teacher)->first();
                    //  return [$old_teacher,lll];
                    if (isset($pivot))
                        $pivot->delete();
                }
            }
            Student_schedule_tracer::where('lecture_time_id', $session->id)->delete();

            $session->delete();
        }

        return redirect()->back()->with('success', 'تم الحذف  بنجاح');
    }

    public function class_delete(Request $request)
    {

        // $delete_code = Hash::make($request->delete_code);
        $formed_code = Auth::User()->view_password;
        if ($formed_code == $request->delete_code) {
            $this->class_delete_fun($request->class_id_delete);
            return redirect()->back()->with('success', '! تمت العملية بنجاح');
        } else {
            return redirect()->back()->with('error', '! تأكد من الداتا البيانات  ');
        }
    }


    public function  save_schedule(Request $request)
    {
        //  return $request ;
        // $this->validate($request, [
        //     'room_id' => 'required',
        //     'teacher_id' => 'required',
        //     'lesson_id' => 'required',
        //     'day_id' => 'required',
        //     'lecture_time_id' => 'required',
        // ],[
        //     'teacher_id.required' => 'يرجى تحديد المدرس',
        //     'room_id.required'=> 'يرجى تحديد الشعبة',
        //     'lesson_id.required' => 'يرجى تحديد المادة',
        //     'day_id.require' => 'يرجى تحديد اليوم',
        //     'lecture_time_id.required' => 'يرجى تحديد الحصة',

        // ]);

         $year =Year::where('current_year','1')->first();
          $term=Term_year::where('current_term','1')->first();

        $old_teacher = '';
        $items = [];

         DB::beginTransaction();


        // جلب الحصص القديمة بهذا التوقيت
        $items =  Lesson_room_teacher_lecture_time::where('room_id', $request->room_id)
            ->where('lecture_time_id', $request->lecture_time_id)
            ->where('day_id', $request->day_id)->get();

        foreach ($items as $item3) {
            // return $items;
            if (isset($item3)) {
                $old_teacher = $item3->teacher_id;
                $old_lesson = $item3->lesson_id;
                $item3->delete();
                $item2 =  Lesson_room_teacher_lecture_time::where('room_id', $request->room_id)
                    ->where('lesson_id', $old_lesson)->where('teacher_id', $old_teacher)->first();
                //  return $item2 ;
                if (!isset($item2)) {
                    $pivot =   Teacher_room_lesson::where('lesson_id', $old_lesson)
                        ->where('room_id', $request->room_id)->where('teacher_id', $old_teacher)->first();
                    //  return [$old_teacher,lll];
                    if (isset($pivot))
                        $pivot->delete();
                }
            }
        }



        foreach ($request->lesson as $key => $individual_lesson) {

            $lesson = Lesson::findOrFail($individual_lesson['lesson_id']);
            // هل الاستاذ متاح بهذا اليوم بهذه الحصة
            // $item =  Lesson_room_teacher_lecture_time::where('teacher_id', $individual_lesson['teacher_id'])
            //     ->where('lecture_time_id', $request->lecture_time_id)->where('day_id', $request->day_id)->first();
            // if (isset($item) && $item->room_id != $request->room_id) {

            $lecture_time = Lecture_time::where('id',$request->lecture_time_id)->first();
            $item =  Lesson_room_teacher_lecture_time::whereHas('lecture_time', function ($q1) use ($lecture_time) {
                        $q1->Where(function ($q2) use ($lecture_time) {
                                $q2->where('start_time', '>', $lecture_time->start_time)
                                ->where('start_time', '<', $lecture_time->end_time);
                        })->orWhere(function ($q2) use ($lecture_time) {
                                $q2->where('end_time', '>', $lecture_time->start_time)
                                ->where('end_time', '<', $lecture_time->end_time);
                        })->orWhere(function ($q2) use ($lecture_time) {
                                $q2->where('start_time', '<', $lecture_time->start_time)
                                ->where('end_time', '>', $lecture_time->end_time);
                        })->orWhere(function ($q2) use ($lecture_time) {
                                $q2->where('start_time', '>=', $lecture_time->start_time)
                                ->where('end_time', '<=', $lecture_time->end_time);
                        });
                    })
                    ->where('term_id',$term->id)
                    // ->where('year_id',$year->id)
                    ->where('teacher_id',$individual_lesson['teacher_id'])
                    ->where('day_id',$request->day_id)->get() ;

            if (isset($item) && $item->count() > 0){
                DB::rollBack();
                 return response()->json([
                     'status' => 0,
                     'msg' => 'error message',
                 ]);
             }

            //  لايجب أن يكون هناك حصتان بنفس التوقيت باستثناء حصتي اللغة والديانة
            $lesson_type = Lesson::findOrFail($individual_lesson['lesson_id']);
            // في حال لم تكن المادة خاصة باللغة أو الديانة فلايجب ان يكون هناك مادتان بنفس التوقيت
            if ($lesson_type->lang != null || $lesson_type->religion != null) {
                $item =  Lesson_room_teacher_lecture_time::where('room_id', $request->room_id)
                    ->where('lecture_time_id', $request->lecture_time_id)
                    ->where('day_id', $request->day_id)->first();
                if (isset($item))
                    $lesson_type2 = Lesson::findOrFail($item->lesson_id);
                if (isset($lesson_type2) && ($lesson_type2->lang == null && $lesson_type2->religion == null)) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 3,
                        'msg' => 'لا يمكن اختيار مادتان بنفس الحصة',
                    ]);
                }
            } else if ($lesson_type->lang == null || $lesson_type->religion == null) {
                $item =  Lesson_room_teacher_lecture_time::where('room_id', $request->room_id)
                    ->where('lecture_time_id', $request->lecture_time_id)
                    ->where('day_id', $request->day_id)->first();
                if (isset($item))
                    $lesson_type2 = Lesson::findOrFail($item->lesson_id);
                if (isset($lesson_type2)) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 3,
                        'msg' => 'لا يمكن اختيار مادتان بنفس الحصة',
                    ]);
                }
            }


            $pivot =  Teacher_room_lesson::where('lesson_id', $individual_lesson['lesson_id'])
                ->where('room_id', $request->room_id)->where('teacher_id', $individual_lesson['teacher_id'])->first();
            if (!isset($pivot)) {
                $class_id = Room::find($request->room_id)->class_id;
                $year = Year::where('current_year', '1')->first();
                $pivot = new Teacher_room_lesson;
                $pivot->lesson_id = $individual_lesson['lesson_id'];
                $pivot->room_id = $request->room_id;
                $pivot->teacher_id = $individual_lesson['teacher_id'];
                $pivot->class_id = $class_id;
                $pivot->year_id = $year->id;
                $pivot->save();
            }

            $item4 =  Lesson_room_teacher_lecture_time::where('room_id', $request->room_id)->where('teacher_id', $individual_lesson['teacher_id'])
                ->where('lecture_time_id', $request->lecture_time_id)->where('day_id', $request->day_id)->first();
            if (!isset($item4)) {
                $item = new Lesson_room_teacher_lecture_time;
                $item->lesson_id = $individual_lesson['lesson_id'];
                $item->room_id = $request->room_id;
                $item->teacher_id = $individual_lesson['teacher_id'];
                $item->lecture_time_id = $request->lecture_time_id;
                $item->day_id = $request->day_id;
                $item->save();
            }
        }
        // return redirect()->bach()-with('success',' تم التخزين  بنجاح ');
        DB::commit();
        return response()->json([
            'status' => true,
            'msg' => ' تم التخزين بنجاح',
        ]);
    }

    // public function  save_schedule(Request $request)
    // {
    //     // return $request ;
    //     $this->validate($request, [
    //         'teacher_id' => 'required',
    //         'room_id' => 'required',
    //         'lesson_id' => 'required',
    //         'day_id' => 'required',
    //         'lecture_time_id' => 'required',
    //     ],[
    //         'teacher_id.required' => 'يرجى تحديد المدرس',
    //         'room_id.required'=> 'يرجى تحديد الشعبة',
    //         'lesson_id.required' => 'يرجى تحديد المادة',
    //         'day_id.require' => 'يرجى تحديد اليوم',
    //         'lecture_time_id.required' => 'يرجى تحديد الحصة',

    //     ]);

    //   $item =  Lesson_room_teacher_lecture_time::where('teacher_id',$request->teacher_id)
    //     ->where('lecture_time_id',$request->lecture_time_id)->where('day_id',$request->day_id)->first();
    //     if (isset($item) && $item->room_id != $request->room_id){
    //         // return redirect()->bach()-with('warning','  هذا التوقيت غير متاح لدى الاستاذ حصة اخرى');
    //         return response()->json([
    //             'status' => false,
    //             'msg' => 'error message',
    //         ]);
    //     }
    //     $old_teacher = '' ;
    //     $item =  Lesson_room_teacher_lecture_time::where('room_id',$request->room_id)
    //     ->where('lecture_time_id',$request->lecture_time_id)->where('day_id',$request->day_id)->first();
    //     if (isset($item) ){
    //         $old_teacher = $item->teacher_id ;
    //         $item->delete();
    //         $item2 =  Lesson_room_teacher_lecture_time::where('room_id',$request->room_id)
    //         ->where('lesson_id',$request->lesson_id)->where('teacher_id', $old_teacher)->first();
    //         // return $item ;
    //         if (!isset($item2) ){
    //             $pivot =   Teacher_room_lesson::where('lesson_id',$request->lesson_id)
    //             ->where('room_id',$request->room_id)->where('teacher_id', $old_teacher)->first();
    //             if (isset($item) )
    //             $pivot->delete();
    //         }
    //     }

    //     $pivot =  Teacher_room_lesson::where('lesson_id',$request->lesson_id)
    //     ->where('room_id',$request->room_id)->where('teacher_id',$request->teacher_id)->first();
    //     if (!isset($pivot) ){
    //         $class_id = Room::find($request->room_id)->class_id ;
    //         $year =Year::where('current_year','1')->first();
    //         $pivot = new Teacher_room_lesson ;
    //         $pivot->lesson_id = $request->lesson_id;
    //         $pivot->room_id = $request->room_id;
    //         $pivot->teacher_id = $request->teacher_id;
    //         $pivot->class_id = $class_id;
    //         $pivot->year_id = $year->id;
    //         $pivot->save() ;
    //     }
    //     $item = new Lesson_room_teacher_lecture_time ;
    //     $item->lesson_id = $request->lesson_id;
    //     $item->room_id = $request->room_id;
    //     $item->teacher_id = $request->teacher_id;
    //     $item->lecture_time_id = $request->lecture_time_id;
    //     $item->day_id = $request->day_id;
    //     $item->save();
    //     // return redirect()->bach()-with('success',' تم التخزين  بنجاح ');
    //     return response()->json([
    //         'status' => true,
    //         'msg' => ' تم التخزين بنجاح',
    //     ]);
    // }

    public function delete_lecture_time(Request $request)
    {

        $x =  Lesson_room_teacher_lecture_time::where('day_id', $request->day_id)
            ->where('lecture_time_id', $request->lecture_time_id)->where('room_id', $request->room_id)->first();

        if (isset($x)) {
            $old_teacher = $x->teacher_id;
            $old_lesson = $x->lesson_id;
            $old_room = $x->room_id;
            $x->delete();
            $item2 =  Lesson_room_teacher_lecture_time::where('room_id', $old_room)
                ->where('lesson_id', $old_lesson)->where('teacher_id', $old_teacher)->first();
            //  return $item2 ;
            if (!isset($item2)) {
                $pivot =   Teacher_room_lesson::where('lesson_id', $old_lesson)
                    ->where('room_id', $old_room)->where('teacher_id', $old_teacher)->first();
                //  return [$old_teacher,lll];
                if (isset($pivot))
                    $pivot->delete();
            }
        }
        Session::flash('success', '   ');
        return redirect()->back();
    }


    public function backups()
    {

        $backups = Backup::orderBy('id', 'DESC')->get();
        $count = Backup::count();

        return view('admin.backups', compact('backups', 'count'));
    }


    public function zipfile($id)
    {
        ini_set("max_execution_time", "-1");
        ini_set("max_file_uploads", "2000M");
        ini_set("max_input_time", "10000000000000");
        ini_set("memory_limit", "10000000000000M");
        ini_set('post_max_size', '50000000000000M');
        ini_set('upload_max_filesize', '500000000000000M');

         $backup = Backup::find($id);
          $backup_name= $backup->item;
         $zip = new A;
        $filename = 'myzip.zip';

            if (!file_exists(public_path($filename))) {
            touch(public_path($filename));
        } else {
            unlink(public_path($filename));
        }
        if ($zip->open(public_path($filename), A::CREATE) === true) {

             $files = File::files(base_path('storage/backup'));

            foreach ($files as $key => $value) {
                $relativePath = basename($value);
                if($relativePath == $backup_name){
                    $zip->addFile($value, $relativePath);
                }



            }

            $zip->close();
        }


        return response()->download(public_path($filename));
    }



    public function backup_del(Request $request)
    {

        File::delete(public_path('myzip.zip'));
        $backup = Backup::find($request->id);

      $file= substr($backup->item, 20);
                         Storage::disk('public')->delete($file);

        Backup::destroy($request->id);
        return redirect()->back();
    }



    public function databasebackup()
    {


        include app_path() . '/BackupDataBase.php';
        try {
            $world_dumper = Shuttle_Dumper::create(array(
                'host' => 'localhost',
                'username' => 'u266086252_aladhamedu',
                'password' => 'Sf6=nwR&[8Y',
                'db_name' => 'u266086252_aladhamedu',
            ));


            $path = base_path('storage/backup') . '/backup_' . Carbon::now()->format('Y-m-d')
                . '_' . Carbon::now()->format('H')
                . '_' . Carbon::now()->format('m')
                . '_' . Carbon::now()->format('s') . '_.sql';



            $world_dumper->dump($path);

            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . basename($path) . "\"");
            readfile($path);

            Session::flash('success', 'تم أخذ نسخة احتياطية بنجاح');

            $backup = new Backup;
            $backup->item = substr($path, 38);
            $backup->save();
            return redirect()->back()->with('! تمت العملية بنجاح ');
        } catch (Shuttle_Exception $e) {
            echo "Couldn't dump database: " . $e->getMessage();
        }
    }


    public function workschedule_manager($room_id)
    {

        $room = Room::findOrFail($room_id);
        $class_id = Room::findOrFail($room_id)->class_id;
        $lessons = Lesson::where('class_id', $class_id)->get();
        // pring teachers
        $teachers = DB::table('teachers')
            ->select('id', 'first_name', 'last_name')
              ->where('active',0)
            ->get();

        // pring lecture_tims
        $lecture_times = Lecture_time::where('room_id', $room->id)->orderBy('start_time', 'asc')->get();
        // pring days
        $days = Day::all();
        // pring romm schedule
        $schedule = Lesson_room_teacher_lecture_time::with('lesson', 'teacher')
            ->where('room_id', $room_id)->get();

        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);


        return view('admin.workschedule_manager', compact('room', 'room_name', 'class_name', 'now', 'room_id', 'lessons', 'lecture_times', 'days', 'schedule', 'teachers', 'today'));
    }

    public function workschedule_exam($room_id)
    {
        // return $student_id ;

        $room = Room::findOrFail($room_id);
        $class_id = Room::findOrFail($room_id)->class_id;
        $lessons = Lesson::where('class_id', $class_id)->get();
        // pring teachers
        $teachers = DB::table('teachers')
            ->select('id', 'first_name', 'last_name')
              ->where('active',0)
            ->get();

        // pring lecture_tims
        $lecture_times = Lecture_time::where('room_id', $room->id)->orderBy('start_time', 'asc')->get();
        // pring days
        $days = Day::all();
        // pring romm schedule
        $schedule = Lesson_room_teacher_lecture_time::with('lesson', 'teacher')
            ->where('room_id', $room_id)->get();

        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();

        return view('admin.workschedule_exam', compact('room', 'room_name', 'class_name', 'now', 'room_id', 'lessons', 'lecture_times', 'days', 'schedule', 'teachers'));
    }
    public function workschedule($room_id)
    {
        // return $student_id ;

        $room = Room::findOrFail($room_id);
        $class_id = Room::findOrFail($room_id)->class_id;
        $lessons = Lesson::where('class_id', $class_id)->get();
        // pring teachers
        $teachers = DB::table('teachers')
            ->select('id', 'first_name', 'last_name')
              ->where('active',0)
            ->get();

        // pring lecture_tims
        $lecture_times = Lecture_time::where('room_id', $room->id)->orderBy('start_time', 'asc')->get();
        // pring days
        $days = Day::all();
        // pring romm schedule
        $schedule = Lesson_room_teacher_lecture_time::with('lesson', 'teacher')
            ->where('room_id', $room_id)->get();

        $room_name = $room->name;
        $room_id = $room->id;
        $class_name =  $room->classes->name;
        $now = Carbon::now();

        return view('admin.workschedule', compact('room', 'room_name', 'class_name', 'now', 'room_id', 'lessons', 'lecture_times', 'days', 'schedule', 'teachers'));
    }

    public function classroom($id)
    {

        $year = Year::where('current_year', '1')->first();
        $rooms = Room::where('class_id', $id)->where('year_id', $year->id)->paginate(paginate_num);
        $count = Room::count();
        $id = $id;
        $years = Year::all();
        return view('admin.rooms', compact('rooms', 'count', 'id', 'years'));
    }

    public function roomteachers($class_id, $room_id)
    {

        $room = Room::with(['teachers.lessons' => fn ($q) => $q->where('teacher_room_lesson.room_id', $room_id)])->find($room_id);
        $room = Room::with(['teachers', 'lessons'])->where('id', $room_id)->get();
        $room = Room::find($room_id);
        $teachers = Teacher_room_lesson::where('room_id', $room_id)->paginate(paginate_num);

        $count = count($teachers);

        return view('admin.teachers_room', compact('room', 'room_id', 'teachers', 'count'));
    }

   public function roomstudent($room_id, $class_id)
    {


        $students = Room_student::where('room_id', $room_id)->get();
        $a = [];
        foreach ($students as $student) {
            $a[] = $student->student_id;
        }
        if(in_array("student_hidden", Auth::user()->role->permissions)){
        $students = Student::with('details')->whereIn('id', $a)->where('hidden',0)->orderBy('first_name')->paginate(paginate_num);
        }
        else{
        $students = Student::with('details')->whereIn('id', $a)->orderBy('first_name')->paginate(paginate_num);

       }
        // return $students;
        $count = count($students);
        $classes = Classe::all();
        $years = Year::all();
        $room = Room::find($room_id);

        return view('admin.student_room', compact('room', 'students', 'count', 'classes', 'years'));
    }


    public function student_mark(Request $request)
    {

        $year = Year::where('current_year', '1')->first();

        $lesson_id = $request->lesson_id;
        $student_id = $request->student_id;

        if ($request->term == 'term1') {

            if (isset($request->exam) && is_array($request->exam)) {


                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();
                    $object1 = json_decode($student_mark->mark, true);
                    $object1[$lesson_id]['exam'] = $request->exam[$i];
                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result1[$lesson_id]['term1_quizes'] = $object1[$lesson_id]['oral'] * 0.1 +
                        $object1[$lesson_id]['homework'] * 0.1 + $object1[$lesson_id]['activities'] * 0.2 + $object1[$lesson_id]['quize'] * 0.2;
                    $object_result1[$lesson_id]['term1_exam'] = $object1[$lesson_id]['exam'] * 0.4;
                    $object_result1[$lesson_id]['term1_result'] = $object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes'];
                    $object_result2 = json_decode($student_mark->result2, true);
                    $object_result = json_decode($student_mark->result, true);
                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];
                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark' => json_encode($object1),
                        'result1' => json_encode($object_result1),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);

                    $result_term1 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {

                        $result_term1 = $result_term1 + $value1['term1_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 / $count : "0";

                    $student_mark->term_result = json_encode($objec_term_result);
                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;
                    $student_mark->save();
                }

                //             $students_mark=Students_mark::where('lesson_id',$lesson_id)->get();
                //             return $students_mark;
                // $objects=new stdClass();
                // foreach(json_decode($students_mark->mark,true) as $key=>$value){
                //     $term1_quizes= $value['oral']*0.1+
                //     $value['homework']*0.1+
                //     $value['activities']*0.2+
                //     $value['quize']*0.2;
                //     $term1_exam=
                //     $value['exam']*0.4;
                //     $term1_result=$term1_quizes + $term1_exam;
                // return $term1_result;

                // }
                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            } elseif (isset($request->oral) && is_array($request->oral)) {

                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();
                    $object1 = json_decode($student_mark->mark, true);
                    $object1[$lesson_id]['oral'] = $request->oral[$i];

                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result1[$lesson_id]['term1_quizes'] = $object1[$lesson_id]['oral'] * 0.1 +
                        $object1[$lesson_id]['homework'] * 0.1 + $object1[$lesson_id]['activities'] * 0.2 + $object1[$lesson_id]['quize'] * 0.2;
                    $object_result1[$lesson_id]['term1_exam'] = $object1[$lesson_id]['exam'] * 0.4;
                    $object_result1[$lesson_id]['term1_result'] = $object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes'];

                    $object_result2 = json_decode($student_mark->result2, true);
                    $object_result = json_decode($student_mark->result, true);

                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark' => json_encode($object1),
                        'result1' => json_encode($object_result1),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);


                    $result_term1 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {

                        $result_term1 = $result_term1 + $value1['term1_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 / $count : "0";

                    $student_mark->term_result = json_encode($objec_term_result);
                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;
                    $student_mark->save();
                }
                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            } elseif (isset($request->quize) && is_array($request->quize)) {

                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();
                    $object1 = json_decode($student_mark->mark, true);
                    $object1[$lesson_id]['quize'] = $request->quize[$i];

                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result1[$lesson_id]['term1_quizes'] = $object1[$lesson_id]['oral'] * 0.1 +
                        $object1[$lesson_id]['homework'] * 0.1 + $object1[$lesson_id]['activities'] * 0.2 + $object1[$lesson_id]['quize'] * 0.2;
                    $object_result1[$lesson_id]['term1_exam'] = $object1[$lesson_id]['exam'] * 0.4;
                    $object_result1[$lesson_id]['term1_result'] = $object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes'];

                    $object_result2 = json_decode($student_mark->result2, true);

                    $object_result = json_decode($student_mark->result, true);
                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];


                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark' => json_encode($object1),
                        'result1' => json_encode($object_result1),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);

                    $result_term1 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {

                        $result_term1 = $result_term1 + $value1['term1_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 / $count : "0";

                    $student_mark->term_result = json_encode($objec_term_result);
                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;
                    $student_mark->save();
                }
                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            } elseif (isset($request->homework) && is_array($request->homework)) {

                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();

                    $object1 = json_decode($student_mark->mark, true);
                    $object1[$lesson_id]['homework'] = $request->homework[$i];

                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result1[$lesson_id]['term1_quizes'] = $object1[$lesson_id]['oral'] * 0.1 +
                        $object1[$lesson_id]['homework'] * 0.1 + $object1[$lesson_id]['activities'] * 0.2 + $object1[$lesson_id]['quize'] * 0.2;
                    $object_result1[$lesson_id]['term1_exam'] = $object1[$lesson_id]['exam'] * 0.4;
                    $object_result1[$lesson_id]['term1_result'] = $object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes'];


                    $object_result2 = json_decode($student_mark->result2, true);
                    $object_result = json_decode($student_mark->result, true);

                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark' => json_encode($object1),
                        'result1' => json_encode($object_result1),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);

                    $result_term1 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {

                        $result_term1 = $result_term1 + $value1['term1_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 / $count : "0";

                    $student_mark->term_result = json_encode($objec_term_result);
                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;
                    $student_mark->save();
                }
                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            } elseif (isset($request->activities) && is_array($request->activities)) {

                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();

                    $object1 = json_decode($student_mark->mark, true);
                    $object1[$lesson_id]['activities'] = $request->activities[$i];

                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result1[$lesson_id]['term1_quizes'] = $object1[$lesson_id]['oral'] * 0.1 +
                        $object1[$lesson_id]['homework'] * 0.1 + $object1[$lesson_id]['activities'] * 0.2 + $object1[$lesson_id]['quize'] * 0.2;
                    $object_result1[$lesson_id]['term1_exam'] = $object1[$lesson_id]['exam'] * 0.4;
                    $object_result1[$lesson_id]['term1_result'] = $object_result1[$lesson_id]['term1_exam'] + $object_result1[$lesson_id]['term1_quizes'];


                    $object_result2 = json_decode($student_mark->result2, true);
                    $object_result = json_decode($student_mark->result, true);

                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark' => json_encode($object1),
                        'result1' => json_encode($object_result1),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);

                    $result_term1 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {

                        $result_term1 = $result_term1 + $value1['term1_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 / $count : "0";

                    $student_mark->term_result = json_encode($objec_term_result);
                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;
                    $student_mark->save();
                }
                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            }

            $lesson = Lesson::find($lesson_id);
            $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();
            $object1 = json_decode($student_mark->mark, true);

            $object1[$lesson_id]['oral'] = $request->oral;
            $object1[$lesson_id]['homework'] = $request->homework;
            $object1[$lesson_id]['activities'] = $request->activities;
            $object1[$lesson_id]['quize'] = $request->quize;
            $object1[$lesson_id]['exam'] = $request->exam;


            $object_result1 = json_decode($student_mark->result1, true);
            $object_result1[$lesson_id]['term1_quizes']  =  $object1[$lesson_id]['oral'] * 0.1 +
                $object1[$lesson_id]['homework'] * 0.1 +
                $object1[$lesson_id]['activities'] * 0.2 +
                $object1[$lesson_id]['quize'] * 0.2;
            $object_result1[$lesson_id]['term1_exam'] = $object1[$lesson_id]['exam'] * 0.4;
            $object_result1[$lesson_id]['term1_result'] = $object_result1[$lesson_id]['term1_exam'] +
                $object_result1[$lesson_id]['term1_quizes'];


            $object_result2 = json_decode($student_mark->result2, true);
            $object_result = json_decode($student_mark->result, true);

            $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];


            $student_mark->update([
                'student_id' => $request->student_id,
                'room_id' => $request->room_id,
                'mark' => json_encode($object1),
                'result1' => json_encode($object_result1),
                'result' => json_encode($object_result),
                'status' => '1'

            ]);

            $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();

            $result_term1 = 0;
            $count = 0;
            foreach (json_decode($student_mark->result1, true) as $key1 => $value1) {

                $result_term1 = $result_term1 + $value1['term1_result'];
                $count++;
            }
            $objec_term_result = json_decode($student_mark->term_result, true);
            $objec_term_result['term1'] = $result_term1 != 0 ? $result_term1 / $count : "0";

            $year_result = (json_decode($student_mark->term_result, true)['term1']
                + json_decode($student_mark->term_result, true)['term2']) / 2;

            $student_mark->update([
                'term_result' => json_encode($objec_term_result),
                'year_result' => $year_result,


            ]);

            return response()->json([
                'success' => '! تمت العملية بنجاح'
            ]);
        } else {



            if (isset($request->exam) && is_array($request->exam)) {


                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();
                    $object2 = json_decode($student_mark->mark2, true);
                    $object2[$lesson_id]['exam'] = $request->exam[$i];


                    $object_result2 = json_decode($student_mark->result2, true);
                    $object_result2[$lesson_id]['term2_quizes'] = $object2[$lesson_id]['oral'] * 0.1 +
                        $object2[$lesson_id]['homework'] * 0.1 + $object2[$lesson_id]['activities'] * 0.2 + $object2[$lesson_id]['quize'] * 0.2;
                    $object_result2[$lesson_id]['term2_exam'] = $object2[$lesson_id]['exam'] * 0.4;
                    $object_result2[$lesson_id]['term2_result'] = $object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes'];

                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result = json_decode($student_mark->result, true);

                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark2' => json_encode($object2),
                        'result2' => json_encode($object_result2),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);

                    $result_term2 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {

                        $result_term2 = $result_term2 + $value1['term2_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term2'] = $result_term2 != '0' ? $result_term2 / $count : "0";
                    $student_mark->term_result = json_encode($objec_term_result);

                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->save();
                }

                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            } elseif (isset($request->oral) && is_array($request->oral)) {

                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();
                    $object2 = json_decode($student_mark->mark2, true);
                    $object2[$lesson_id]['oral'] = $request->oral[$i];

                    $object_result2 = json_decode($student_mark->result2, true);
                    $object_result2[$lesson_id]['term2_quizes'] = $object2[$lesson_id]['oral'] * 0.1 +
                        $object2[$lesson_id]['homework'] * 0.1 + $object2[$lesson_id]['activities'] * 0.2 + $object2[$lesson_id]['quize'] * 0.2;
                    $object_result2[$lesson_id]['term2_exam'] = $object2[$lesson_id]['exam'] * 0.4;
                    $object_result2[$lesson_id]['term2_result'] = $object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes'];

                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result = json_decode($student_mark->result, true);

                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark2' => json_encode($object2),
                        'result2' => json_encode($object_result2),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);


                    $result_term2 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {

                        $result_term2 = $result_term2 + $value1['term2_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2 / $count : "0";
                    $student_mark->term_result = json_encode($objec_term_result);

                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->save();
                }
                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            } elseif (isset($request->quize) && is_array($request->quize)) {

                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();
                    $object2 = json_decode($student_mark->mark2, true);
                    $object2[$lesson_id]['quize'] = $request->quize[$i];

                    $object_result2 = json_decode($student_mark->result2, true);
                    $object_result2[$lesson_id]['term2_quizes'] = $object2[$lesson_id]['oral'] * 0.1 +
                        $object2[$lesson_id]['homework'] * 0.1 + $object2[$lesson_id]['activities'] * 0.2 + $object2[$lesson_id]['quize'] * 0.2;
                    $object_result2[$lesson_id]['term2_exam'] = $object2[$lesson_id]['exam'] * 0.4;
                    $object_result2[$lesson_id]['term2_result'] = $object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes'];

                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result = json_decode($student_mark->result, true);

                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark2' => json_encode($object2),
                        'result2' => json_encode($object_result2),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);


                    $result_term2 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {

                        $result_term2 = $result_term2 + $value1['term2_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2 / $count : "0";
                    $student_mark->term_result = json_encode($objec_term_result);

                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->save();
                }
                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            } elseif (isset($request->homework) && is_array($request->homework)) {

                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();

                    $object2 = json_decode($student_mark->mark2, true);
                    $object2[$lesson_id]['homework'] = $request->homework[$i];

                    $object_result2 = json_decode($student_mark->result2, true);
                    $object_result2[$lesson_id]['term2_quizes'] = $object2[$lesson_id]['oral'] * 0.1 +
                        $object2[$lesson_id]['homework'] * 0.1 + $object2[$lesson_id]['activities'] * 0.2 + $object2[$lesson_id]['quize'] * 0.2;
                    $object_result2[$lesson_id]['term2_exam'] = $object2[$lesson_id]['exam'] * 0.4;
                    $object_result2[$lesson_id]['term2_result'] = $object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes'];

                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result = json_decode($student_mark->result, true);

                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark2' => json_encode($object2),
                        'result2' => json_encode($object_result2),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);


                    $result_term2 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {

                        $result_term2 = $result_term2 + $value1['term2_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2 / $count : "0";
                    $student_mark->term_result = json_encode($objec_term_result);

                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->save();
                }
                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            } elseif (isset($request->activities) && is_array($request->activities)) {

                for ($i = 0; $i < count($request->student_id); $i++) {
                    $student_mark = Students_mark::where('student_id', $request->student_id[$i])->where('year_id', $year->id)->first();

                    $object2 = json_decode($student_mark->mark2, true);
                    $object2[$lesson_id]['activities'] = $request->activities[$i];

                    $object_result2 = json_decode($student_mark->result2, true);
                    $object_result2[$lesson_id]['term2_quizes'] = $object2[$lesson_id]['oral'] * 0.1 +
                        $object2[$lesson_id]['homework'] * 0.1 + $object2[$lesson_id]['activities'] * 0.2 + $object2[$lesson_id]['quize'] * 0.2;
                    $object_result2[$lesson_id]['term2_exam'] = $object2[$lesson_id]['exam'] * 0.4;
                    $object_result2[$lesson_id]['term2_result'] = $object_result2[$lesson_id]['term2_exam'] + $object_result2[$lesson_id]['term2_quizes'];


                    $object_result1 = json_decode($student_mark->result1, true);
                    $object_result = json_decode($student_mark->result, true);

                    $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

                    $student_mark->update([
                        'room_id' => $request->room_id,
                        'lesson_id' => $request->lesson_id,
                        'mark2' => json_encode($object2),
                        'result2' => json_encode($object_result2),
                        'result' => json_encode($object_result),
                        'status' => '1',
                    ]);


                    $result_term2 = 0;
                    $count = 0;
                    foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {

                        $result_term2 = $result_term2 + $value1['term2_result'];
                        $count++;
                    }
                    $objec_term_result = json_decode($student_mark->term_result, true);
                    $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2 / $count : "0";
                    $student_mark->term_result = json_encode($objec_term_result);

                    $student_mark->year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->save();
                }
                return redirect()->back()->with('success', '! تمت العملية بنجاح');
            }

            $lesson = Lesson::find($lesson_id);

            $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();
            $object2 = json_decode($student_mark->mark2, true);

            $object2[$lesson_id]['oral'] = $request->oral;
            $object2[$lesson_id]['homework'] = $request->homework;
            $object2[$lesson_id]['activities'] = $request->activities;
            $object2[$lesson_id]['quize'] = $request->quize;
            $object2[$lesson_id]['exam'] = $request->exam;

            $object_result2 = json_decode($student_mark->result2, true);
            $object_result2[$lesson_id]['term2_quizes'] = $object2[$lesson_id]['oral'] * 0.1 +
                $object2[$lesson_id]['homework'] * 0.1 +
                $object2[$lesson_id]['activities'] * 0.2 +
                $object2[$lesson_id]['quize'] * 0.2;
            $object_result2[$lesson_id]['term2_exam'] = $object2[$lesson_id]['exam'] * 0.4;
            $object_result2[$lesson_id]['term2_result'] = $object_result2[$lesson_id]['term2_exam'] +
                $object_result2[$lesson_id]['term2_quizes'];


            $object_result1 = json_decode($student_mark->result1, true);
            $object_result = json_decode($student_mark->result, true);

            $object_result[$lesson_id]['year_result'] = $object_result1[$lesson_id]['term1_result'] + $object_result2[$lesson_id]['term2_result'];

            $student_mark->update([
                'student_id' => $request->student_id,
                'room_id' => $request->room_id,
                'mark2' => json_encode($object2),
                'result2' => json_encode($object_result2),
                'result' => json_encode($object_result),
                'status' => '1'

            ]);
            $student_mark = Students_mark::where('student_id', $request->student_id)->where('year_id', $year->id)->first();

            $result_term2 = 0;
            $count = 0;
            foreach (json_decode($student_mark->result2, true) as $key1 => $value1) {

                $result_term2 = $result_term2 + $value1['term2_result'];
                $count++;
            }
            $objec_term_result = json_decode($student_mark->term_result, true);
            $objec_term_result['term2'] = $result_term2 != 0 ? $result_term2 / $count : "0";
            $year_result = (json_decode($student_mark->term_result, true)['term1']
                + json_decode($student_mark->term_result, true)['term2']) / 2;

            $student_mark->update([

                'term_result' => json_encode($objec_term_result),
                'year_result' => $year_result,

            ]);

            return response()->json([
                'success' => '! تمت العملية بنجاح'
            ]);
        }
    }

    public function StudentsRoomLesson($room_id, $lesson_id)
    {

        $room = Room::with('student')->find($room_id);
        $year = Year::where('current_year', '1')->first();
        if(in_array("student_hidden", Auth::user()->role->permissions)){
            $students = Room::whereHas('student', function ($query) use($year){
                $query->where('year_id', $year->id);
                $query->where('hidden',0);
        })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

            $count = count($students->student);
            $market = Students_mark::where('room_id', $room_id)->get();


            $lesson = Lesson::find($lesson_id);

            if (isset($students) && $lesson->lang == '1') {
                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                    $query->where('lang', '1')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->orderBy('first_name');
                    }])->find($room_id);
            } elseif (isset($students) && $lesson->lang == '0') {

                   $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                    $query->where('lang', '0')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->orderBy('first_name');
                    }])->find($room_id);
            } elseif (isset($students) && $lesson->religion == '1') {
                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                    $query->where('religion', '1')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->where('religion', '1')->orderBy('first_name');
                    }])->find($room_id);
            } elseif (isset($students) && $lesson->religion == '0') {

             $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                    $query->where('religion', '0')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->where('religion', '0')->orderBy('first_name');
                    }])->find($room_id);
            } elseif (isset($students)) {

                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->orderBy('first_name');
                    }])->find($room_id);
            }
        }
        else{
            $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

            $count = count($students->student);
            $market = Students_mark::where('room_id', $room_id)->get();


            $lesson = Lesson::find($lesson_id);

            if (isset($students) && $lesson->lang == '1') {
                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('lang', '1')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
            } elseif (isset($students) && $lesson->lang == '0') {

                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('lang', '0')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
            } elseif (isset($students) && $lesson->religion == '1') {
                 $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('religion', '1')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->where('religion', '1')->orderBy('first_name')])->find($room_id);
            } elseif (isset($students) && $lesson->religion == '0') {

                    $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('religion', '0')->where('religion', '0')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
            } elseif (isset($students)) {

                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
            }
        }
        // $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

        // $count = count($students->student);
        // $market = Students_mark::where('room_id', $room_id)->get();


        // $lesson = Lesson::find($lesson_id);

        // if (isset($students) && $lesson->lang == '1') {
        //     $students = Room::whereHas('student', function ($query) use ($year) {
        //         $query->where('year_id', $year->id);
        //         $query->where('lang', '1')->orderBy('first_name');
        //     })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
        //         ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        // } elseif (isset($students) && $lesson->lang == '0') {

        //     $students = Room::whereHas('student', function ($query) use ($year) {
        //         $query->where('year_id', $year->id);
        //         $query->where('lang', '0')->orderBy('first_name');
        //     })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
        //         ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        // } elseif (isset($students) && $lesson->religion == '1') {
        //     $students = Room::whereHas('student', function ($query) use ($year) {
        //         $query->where('year_id', $year->id);
        //         $query->where('religion', '1')->orderBy('first_name');
        //     })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
        //         ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        // } elseif (isset($students) && $lesson->religion == '0') {

        //     $students = Room::whereHas('student', function ($query) use ($year) {
        //         $query->where('year_id', $year->id);
        //         $query->where('religion', '0')->orderBy('first_name');
        //     })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
        //         ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        // } elseif (isset($students)) {

        //     $students = Room::whereHas('student', function ($query) use ($year) {
        //         $query->where('year_id', $year->id);
        //     })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
        //         ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        // }
        $class_id = Room::find($room_id)->class_id;
        $class = Classe::find($class_id);
        if ($class->stage_id == 1) {
            return view('admin.students_room_lesson', compact('room', 'room_id', 'students', 'count', 'lesson_id', 'lesson'));
        } elseif ($class->stage_id == 2) {
            return view('admin.students_room_lesson1', compact('room', 'room_id', 'students', 'count', 'lesson_id', 'lesson'));
        } elseif ($class->stage_id == 3) {
            return view('admin.students_room_lesson2', compact('room', 'room_id', 'students', 'count', 'lesson_id', 'lesson'));
        }
    }


    public function StudentsRoomLesson_pdf($room_id, $lesson_id)
    {

        $room = Room::with('student')->find($room_id);
        $year = Year::where('current_year', '1')->first();

        $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

        $count = count($students->student);
        $market = Students_mark::where('room_id', $room_id)->get();


        $lesson = Lesson::find($lesson_id);

        if (isset($students) && $lesson->lang == '1') {
            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
                $query->where('lang', '1')->orderBy('first_name');
            })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        } elseif (isset($students) && $lesson->lang == '0') {

            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
                $query->where('lang', '0')->orderBy('first_name');
            })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        } elseif (isset($students) && $lesson->religion == '1') {
            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
                $query->where('religion', '1')->orderBy('first_name');
            })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        } elseif (isset($students) && $lesson->religion == '0') {

            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
                $query->where('religion', '0')->orderBy('first_name');
            })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        } elseif (isset($students)) {

            $students = Room::whereHas('student', function ($query) use ($year) {
                $query->where('year_id', $year->id);
            })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
        }
        $class_id = Room::find($room_id)->class_id;
        $class = Classe::find($class_id);
        if ($class->stage_id == 1) {
            return view('admin.students_room_lesson_pdf', compact('room', 'room_id', 'students', 'count', 'lesson_id', 'lesson'));
        } elseif ($class->stage_id == 2) {
            return view('admin.students_room_lesson1_pdf', compact('room', 'room_id', 'students', 'count', 'lesson_id', 'lesson'));
        } elseif ($class->stage_id == 3) {
            return view('admin.students_room_lesson2_pdf', compact('room', 'room_id', 'students', 'count', 'lesson_id', 'lesson'));
        }
    }
     public function StudentsRoomLesson_excel($room_id, $lesson_id)
    {

        $room = Room::with('student')->find($room_id);
        $year = Year::where('current_year', '1')->first();
        if(in_array("student_hidden", Auth::user()->role->permissions)){
            $students = Room::whereHas('student', function ($query) use($year){
                $query->where('year_id', $year->id);
                $query->where('hidden',0);
        })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

            $count = count($students->student);
            $market = Students_mark::where('room_id', $room_id)->get();


            $lesson = Lesson::find($lesson_id);

            if (isset($students) && $lesson->lang == '1') {
                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                    $query->where('lang', '1')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->orderBy('first_name');
                    }])->find($room_id);
            } elseif (isset($students) && $lesson->lang == '0') {

                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                    $query->where('lang', '0')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->orderBy('first_name');
                    }])->find($room_id);
            } elseif (isset($students) && $lesson->religion == '1') {
                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                    $query->where('religion', '1')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->where('religion', '1')->orderBy('first_name');
                    }])->find($room_id);
            } elseif (isset($students) && $lesson->religion == '0') {

                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                    $query->where('religion', '0')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->where('religion', '0')->orderBy('first_name');
                    }])->find($room_id);
            } elseif (isset($students)) {

                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('hidden',0);
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => function ($q1) {
                        $q1->where('hidden', 0)->orderBy('first_name');
                    }])->find($room_id);
            }
        }
        else{
            $students = Room::with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])->find($room_id);

            $count = count($students->student);
            $market = Students_mark::where('room_id', $room_id)->get();


            $lesson = Lesson::find($lesson_id);

            if (isset($students) && $lesson->lang == '1') {
                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('lang', '1')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
            } elseif (isset($students) && $lesson->lang == '0') {

                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('lang', '0')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
            } elseif (isset($students) && $lesson->religion == '1') {
                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('religion', '1')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->where('religion', '1')->orderBy('first_name')])->find($room_id);
            } elseif (isset($students) && $lesson->religion == '0') {

                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                    $query->where('religion', '0')->orderBy('first_name');
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->where('religion', '0')->orderBy('first_name')])->find($room_id);
            } elseif (isset($students)) {

                $students = Room::whereHas('student', function ($query) use ($year) {
                    $query->where('year_id', $year->id);
                })->with(['student.student_mark' => fn ($q1) => $q1->where('students_marks.year_id', $year->id)])
                    ->with(['student' => fn ($q1) => $q1->orderBy('first_name')])->find($room_id);
            }
        }

        $class_id = Room::find($room_id)->class_id;
        $class = Classe::find($class_id);
        if ($class->stage_id == 1) {
            return view('admin.students_room_lesson_excel', compact('room', 'room_id', 'students', 'count', 'lesson_id', 'lesson'));
        } elseif ($class->stage_id == 2) {
            return view('admin.students_room_lesson1_excel', compact('room', 'room_id', 'students', 'count', 'lesson_id', 'lesson'));
        } elseif ($class->stage_id == 3) {
            return view('admin.students_room_lesson2_excel', compact('room', 'room_id', 'students', 'count', 'lesson_id', 'lesson'));
        }
    }
    public function roomlessons($class_id, $room_id)
    {


        //الاستاذ يلي بدرس كل مادة بعد ما وصلت للمواد من الشعبة يلي وصلتلها من الصف
        //المواد المتعلقة بكل شعبة بعد ما وصلت للشعب من الصف
        //   $lessons=Room::with(['lessons'])->where('id',$room_id)->get();
        //   $room=Room::find($room_id);
        $lessons = Lesson::where('class_id', $class_id)->paginate(paginate_num);
        //   $lessons=$room->lessons()->paginate(paginate_num);
        $count = count($lessons);
        $room = Room::find($room_id);
        return view('admin.lesson_room', compact('room', 'lessons', 'room_id', 'count'));
    }

  public function room_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_name' => [
                'required',
                Rule::unique('rooms', 'name')->where(function ($query) use ($request) {
                    return $query->where('class_id', $request->class_id);
                })
            ],
            'year_id' => 'required|exists:years,id',
            'class_id' => 'required|exists:classes,id',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors("الأسم مأخوذ بالفعل(تم استخدام هذا الأسم من قبل ضمن هذا الصف)")->withInput();
        }
    
        $year = Year::find($request->year_id);
        Room::create([
            'name' => $request->room_name,
            'year_id' => $year->id,
            'class_id' => $request->class_id
        ]);
    
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function room_update(Request $request)
    {

        $room = Room::find($request->room_id);
        $room->name = $request->name;


        $room->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');;
    }

    public function room_delete(Request $request)
    {

        $formed_code = Auth::User()->view_password;
        if ($formed_code == $request->delete_code) {
            $this->room_delete_fun($request->room_id_delete);
            return redirect()->back()->with('success', '! تمت العملية بنجاح');
        } else {
            return redirect()->back()->with('error', '! تأكد من البيانات  ');
        }
    }

    public function teacher_store(Request $request)
    {
        // $year= Year::where('current_year','1')->first();

        $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'phone' => 'required|max:20'
        ]);

        $teacher = Teacher::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'first_name_en' => $request->first_name_en,
            'last_name_en' => $request->last_name_en,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'salary' => $request->salary,
            'date_birth' => $request->date_birth,
            'lesson_name' => $request->lesson_name,
            'vcation_days' => $request->vcation_days,
            'contract' => $request->contract,
        ]);

        if ($request->hasFile('image')) {
            $teacher->image = $request->image->store('teachersimage', 'public');
        }

        $user = User::create([
            'name' => $request->first_name,
            'email' => "a@app.com",
            'mobile' => $request->phone,
            'password' => Hash::make(5),
            'view_password' => 5,
            'type' => '1',
            'teacher_id' => $teacher->id,
        ]);

        $email = str_replace(" ", "", $request->first_name_en) . str_replace(" ", "", $request->last_name_en) . rand(1, 1000) . "@aladham.com";
        if (strlen($request->first_name_en) > 2) {
            $namee = substr($request->first_name_en, 0, 3);
        } else {
            $namee = "aladham";
        }
        $password = $namee . "@" . rand(100000, 900000);
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->view_password = $password;
        $user->save();

        $teacher->email = $email;
        $teacher->Description_ar = $request->Description_ar;
        $teacher->Description_en = $request->Description_en;
        if ($request->type) {
            $teacher->type = 1;
        } else {
            $teacher->type = null;
        }
        $teacher->save();
        Session::flash('success', '! تمت العملية بنجاح');
        return redirect()->back();
    }
    public function footer_store(Request $request)
    {


        $footer = Footer::find($request->id);
        $footer->address_ar = $request->address_ar;
        $footer->address_en = $request->address_en;
        $footer->phone = json_encode($request->phone);
        $footer->email = $request->email;
        $footer->facebook = $request->facebook;
        $footer->twitter = $request->twitter;
        $footer->google = $request->google;
        $footer->instgram = $request->instgram;
        $footer->WhatsApp = $request->WhatsApp;
        $footer->content_ar = $request->content_ar;
        $footer->content_en = $request->content_en;
        $footer->title_ar = $request->title_ar;
        $footer->title_en = $request->title_en;
        $footer->business_hours_ar = $request->business_hours_ar;
        $footer->business_hours_en = $request->business_hours_en;
        if ($request->hasFile('img')) {
            if ($footer->img != null) {

                Storage::disk('public')->delete($footer->img);
            }
            $footer->img = $request->img->store('filesteachers', 'public');
        }



        $footer->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function other_store(Request $request)
    {

        $other = Other::find($request->id);

        if ($request->hasFile('img')) {

            $other->img = $request->img->store('filesteachers', 'public');
        }
        if ($request->hasFile('imgn')) {

            $other->imgn = $request->imgn->store('filesteachers', 'public');
        }
        if ($request->hasFile('logo')) {

            $other->logo = $request->logo->store('filesteachers', 'public');
        }
        if ($request->hasFile('img3')) {

            $other->img3 = $request->img3->store('videosfiles', 'public');
        }
        $other->title1_ar = $request->title1_ar;
        $other->title1_en = $request->title1_en;
        $other->title2_ar = $request->title2_ar;
        $other->title2_en = $request->title2_en;


        $other->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function about_store(Request $request)
    {


   $request->validate([
            'content_ar'=>'max:300',
            'content_en'=>'max:300',

        ]);
        $about = About_us_website::find($request->id);
        $about->welcome_ar = $request->welcome_ar;
        $about->welcome_en = $request->welcome_en;
        $about->title_ar = $request->title_ar;
        $about->title_en = $request->title_en;
        $about->description_ar = $request->description_ar;
        $about->description_en = $request->description_en;
        $about->content_ar = $request->content_ar;
        $about->content_en = $request->content_en;
        if ($request->hasFile('image')) {

            $about->image = $request->image->store('newsimages', 'public');
        }



        $about->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function advntages_store(Request $request)
    {

        // $request->validate([
        //     'ourteams_ar'=>'required|max:40',
        //     'joinus_ar'=>'required|max:50',
        //     'register_ar'=>'required|max:40',
        //     'ourclasses_ar'=>'required|max:50',

        // ]);
        // return $request->all();
        $advntages = Advantages::find($request->id);
        $advntages->ourteams_en = $request->ourteams_en;
        $advntages->ourteams_ar = $request->ourteams_ar;
        $advntages->joinus_en = $request->joinus_en;
        $advntages->joinus_ar = $request->joinus_ar;
        $advntages->register_en = $request->register_en;
        $advntages->register_ar = $request->register_ar;
        $advntages->ourclasses_en = $request->ourclasses_en;
        $advntages->ourclasses_ar = $request->ourclasses_ar;


        $advntages->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function more_details_store(Request $request)
    {

        // $request->validate([
        //     'title_ar'=>'required|max:40',
        //     'text_ar'=>'required|max:500',
        //     'title_en'=>'required|max:40',
        //     'text_en'=>'required|max:500',

        // ]);
        $details = More_details::find($request->id);
        $details->title_ar = $request->title_ar;
        $details->text_ar = $request->text_ar;
        $details->title_en = $request->title_en;
        $details->text_en = $request->text_en;
        $details->title1_ar = $request->title1_ar;
        $details->title1_en = $request->title1_en;
        $details->title2_ar = $request->title2_ar;
        $details->title2_en = $request->title2_en;
        $details->text2_ar = $request->text2_ar;
        $details->text2_en = $request->text2_en;


        if ($request->hasFile('img')) {

            $details->img = $request->img->store('filesteachers', 'public');
        } else {
            $details->img = $details->img;
        }
        if ($request->hasFile('img_s1')) {

            $details->img_s1 = $request->img_s1->store('filesteachers', 'public');
        } else {
            $details->img_s1 = $details->img_s1;
        }
        if ($request->hasFile('img_s2')) {

            $details->img_s2 = $request->img_s2->store('filesteachers', 'public');
        } else {
            $details->img_s2 = $details->img_s2;
        }
        if ($request->hasFile('img_s3')) {

            $details->img_s3 = $request->img_s3->store('filesteachers', 'public');
        } else {
            $details->img_s3 = $details->img_s3;
        }


        $details->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function stats_store(Request $request)
    {

        $request->validate([
            'name_ar' => 'required|max:40',
            'name_en' => 'required|max:40',


        ]);
        $stats = new Stats;
        $stats->name_ar = $request->name_ar;
        $stats->name_en = $request->name_en;
        $stats->ratio = $request->ratio;

        $stats->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function category_store(Request $request)
    {

        $request->validate([
            'name_ar' => 'required|max:40',
            'name_en' => 'required|max:40',


        ]);
        $category = new Category;
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;


        $category->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }



    public function delete_stats(Request $request)
    {

        $advantages = Stats::find($request->id);
        $advantages->delete();

        return redirect()->back();
    }
    public function delete_category(Request $request)
    {

        $category = Category::find($request->id);
        $news = News::where('category_id', $category->id)->get();
        foreach ($news as $item) {
            $item->delete();
        }


        $category->delete();

        return redirect()->back();
    }

    public function delete_more_details(Request $request)
    {

        $details = More_details::find($request->id);
        $details->delete();

        return redirect()->back();
    }

    public function delete_advantges(Request $request)
    {

        $advantages = Advantages::find($request->id);
        $advantages->delete();

        return redirect()->back();
    }
    public function delete_objection(Request $request)
    {

        $advantages = Objection::find($request->id);
        $advantages->delete();

        return redirect()->back();
    }
    public function delete_mes(Request $request)
    {
         $messages = Message::find($request->id);
        $messages->delete();

        Session::flash('success', "تم حذف جميع الرسائل    ");
        return redirect()->back();
    }
    public function delete_all_mes(Request $request)
    {

        $messages = Message::where('admin_id','!=',null)->where('student_id',$request->id)->get();
        if($messages){
            foreach( $messages as $message){
               $message->delete();

        }

        }

        Session::flash('success', "تم حذف جميع الرسائل    ");
        return redirect()->back();
    }


    public function delete_app_slider(Request $request)
    {

        $advantages = App_student_slider::find($request->id);
        $advantages->delete();

        return redirect()->back();
    }


    public function about()
    {

        $bout = About_us_website::paginate(paginate_num);
        $count = About_us_website::count();

        return view('admin.aboutusd', compact('bout', 'count'));
    }
    public function category()
    {

        $category = Category::paginate(paginate_num);
        $count = Category::count();

        return view('admin.category', compact('category', 'count'));
    }
    public function newsdetails()
    {

        $newsdetails = News::with('category')->paginate(paginate_num);
        $count = Category::count();
        $category = Category::all();

        return view('admin.newsdetails', compact('newsdetails', 'count', 'category'));
    }

    public function news_update(Request $request)
    {


        $news_id = $request->id;
        $news = News::find($news_id);

        $news->title_ar = $request->title_ar;
        $news->content_ar = $request->content_ar;
        if ($request->type) {
            $news->type = 1;
        } else {
            $news->type = null;
        }

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

        if ($request->has('del_img1')) {
            Storage::disk('public')->delete($news->image1);
            $news->image1 = null;
        }


        if ($request->has('del_img2')) {
            Storage::disk('public')->delete($news->image2);

            $news->image2 = null;
        }

        if ($request->has('del_img3')) {
            Storage::disk('public')->delete($news->image3);

            $news->image3 = null;
        }

        if ($request->has('del_img4')) {
            Storage::disk('public')->delete($news->image4);

            $news->image4 = null;
        }

        if ($request->hasFile('image1')) {

            if ($news->image1 != null) {

                Storage::disk('public')->delete($news->image1);
            }
            $news->image1 = $request->image1->store('newsimages', 'public');
        }


        if ($request->hasFile('image2')) {

            if ($news->image2 != null) {

                Storage::disk('public')->delete($news->image2);
            }
            $news->image2 = $request->image2->store('newsimages', 'public');
        }


        if ($request->hasFile('image3')) {

            if ($news->image3 != null) {

                Storage::disk('public')->delete($news->image3);
            }
            $news->image3 = $request->image3->store('newsimages', 'public');
        }


        if ($request->hasFile('image4')) {

            if ($news->image4 != null) {

                Storage::disk('public')->delete($news->image4);
            }

            $news->image4 = $request->image4->store('newsimages', 'public');
        }




        $news->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function news_delete(Request $request)
    {

        $news_id = $request->id;
        $news = News::find($news_id);
        if ($news->image1 != null) {

            Storage::disk('public')->delete($news->image1);
        }

        if ($news->image2 != null) {

            Storage::disk('public')->delete($news->image2);
        }

        if ($news->image3 != null) {

            Storage::disk('public')->delete($news->image3);
        }

        if ($news->image4 != null) {

            Storage::disk('public')->delete($news->image4);
        }



        $news->delete();

        return redirect()->back()->with('success', 'تم حذف  بنجاح !');
    }
    public function news_store(Request $request)
    {

        $request->validate([
            'title_ar' => 'required|max:100',
            'content_ar' => 'required|max:255',
            'title_en' => 'required|max:100',
            'content_en' => 'required|max:255',
            'part1_ar' => 'required|max:600',
            'part2_ar' => 'max:600',
            'part3_ar' => 'max:600',
            'part3_ar' => 'max:600',
            'part1_en' => 'required|max:600',
            'part2_en' => 'max:600',
            'part3_en' => 'max:600',
            'part3_en' => 'max:600',

        ]);

        $news = new News;

        if ($request->type) {
            $news->type = 1;
        } else {
            $news->type = null;
        }

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

            $news->image1 = $request->image1->store('newsimages', 'public');
        }


        if ($request->hasFile('image2')) {

            $news->image2 = $request->image2->store('newsimages', 'public');
        }


        if ($request->hasFile('image3')) {

            $news->image3 = $request->image3->store('newsimages', 'public');
        }


        if ($request->hasFile('image4')) {

            $news->image4 = $request->image4->store('newsimages', 'public');
        }





        $news->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function other()
    {

        $other = Other::paginate(paginate_num);
        $count = Other::count();

        return view('admin.other', compact('other', 'count'));
    }
    public function footer()
    {

        $footer = Footer::paginate(paginate_num);
        $count = Footer::count();

        return view('admin.footer', compact('footer', 'count'));
    }

    public function stats()
    {

        $stats = Stats::paginate(paginate_num);
        $count = Stats::count();

        return view('admin.stats', compact('stats', 'count'));
    }




    public function advantages()
    {

        $advantages = Advantages::paginate(paginate_num);
        $count = Advantages::count();

        return view('admin.advantages', compact('advantages', 'count'));
    }
    public function app_slider()
    {

        $app_student = App_student_slider::paginate(paginate_num);
        $count = App_student_slider::count();

        return view('admin.app_slider', compact('app_student', 'count'));
    }
    public function app_slider_store(Request $request)
    {
        $app_student =  new App_student_slider();
        if ($request->hasFile('img')) {

            $app_student->image = $request->img->store('filesteachers', 'public');
        }

        $app_student->save();
        return redirect()->back();
    }

    public function more_details()
    {

        $details = More_details::paginate(paginate_num);
        $count = More_details::count();

        return view('admin.more_details', compact('details', 'count'));
    }

    //public function classes()
    //{

      //  $classes = Classe::paginate(paginate_num);
       // $stages = Stage::all();
       // $count = Classe::count();
       // $all_classes = Classe::all();
       // $countries_currencies = Country_currency::all();
       // return view('admin.classes', compact('countries_currencies','classes', 'count', 'stages', 'all_classes'));
    //}
    //new edit
     public function classes()
    {

        $classes = Classe::with('classCost')->paginate(paginate_num);
        $stages = Stage::all();
        $count = Classe::count();
         $all_classes = Classe::with('stages')->get();
        $countries_currencies = Country_currency::all();
        $class_cost = Class_cost::where('class_id', $all_classes->pluck('id'))
        ->where('country_id', $countries_currencies->pluck('id'));
        $countries = [];
        foreach ($countries_currencies as $country_currency) {
        $countries[$country_currency->id] = $country_currency->name_ar;


        $stage1 =Basic_stage:: all();

 }

        return view('admin.classes', compact('stage1','countries','class_cost','countries_currencies','classes', 'count', 'stages', 'all_classes'));
    }


    public function sessions()
    {  $year = Year::where('current_year', '1')->first();
        $class = Classe::all();
        $room = Room::where('year_id',$year->id)->get();

        return view('admin.sessions', compact('room', 'class'));
    }

    public function session_class($id)
    {    $year = Year::where('current_year', '1')->first();
        $classes = Lecture_time::WhereHas('room' ,function($q) use ($year){
            $q->where('year_id',$year->id);
        })->where('class_id', $id)->get();
        $class = Classe::find($id);

        $room = $class->room->where('year_id',$year->id);
        return view('admin.sessions2', compact('room', 'classes', 'id'));
    }

    public function acadsupervisor_details($supervisor_id)
    {

        $year = Year::where('current_year', '1')->first();
        $supervisor = Acadsupervisor::find($supervisor_id);
        return view('admin.acadsupervisor_details', compact('supervisor'));
    }

    public function supervisor_details($supervisor_id)
    {

        $year = Year::where('current_year', '1')->first();
        $supervisor = Supervisor::find($supervisor_id);
        return view('admin.supervisor_details', compact('supervisor'));
    }



    public function store_acadsupervisor_set_task(Request $request)
    {

        Acadsupervisor_class::where('supervisor_id', $request->supervisor_id)->delete();

        for ($i = 0; $i < count($request->class_id); $i++) {

            $item = new Acadsupervisor_class;
            $item->supervisor_id = $request->supervisor_id;
            $item->class_id = $request->class_id[$i];
            $item->save();
        }


        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }



    public function store_supervisor_set_task(Request $request)
    {
        // return $request ;
        $year = Year::where('current_year', '1')->first();


        Supervisor_class_lesson::where('supervisor_id', $request->supervisor_id)->delete();
        Supervisor_room_lesson::where('supervisor_id', $request->supervisor_id)->delete();
        $supervisor = Supervisor::find($request->supervisor_id);
        // return $request ;
        for ($i = 0; $i < count($request->class_id); $i++) {

            foreach ($request->lesson_id[$request->class_id[$i]] as $lesson_id) {





                if (in_array(0, $request->room_id[$request->class_id[$i]])) {

                    $classes = Classe::with(['room:id,class_id'])->find($request->class_id[$i]);
                    $rooms_id = [];
                    foreach ($classes->room as $id) {
                        array_push($rooms_id, $id->id);
                    }
                    foreach ($rooms_id as $room_id) {

                        $item = new Supervisor_class_lesson;
                        $item->supervisor_id = $request->supervisor_id;
                        $item->class_id = $request->class_id[$i];
                        $item->lesson_id = $lesson_id;
                        $item->room_id = $room_id;
                        $item->save();

                        $item2 = new Supervisor_room_lesson;
                        $item2->supervisor_id = $request->supervisor_id;
                        $item2->class_id = $request->class_id[$i];
                        $item2->room_id = $room_id;
                        $item2->lesson_id = 555;
                        $item2->save();
                    }
                } else {

                    foreach ($request->room_id[$request->class_id[$i]] as $room_id) {

                        $item = new Supervisor_class_lesson;
                        $item->supervisor_id = $request->supervisor_id;
                        $item->class_id = $request->class_id[$i];
                        $item->lesson_id = $lesson_id;
                        $item->room_id = $room_id;
                        $item->save();

                        $item2 = new Supervisor_room_lesson;
                        $item2->supervisor_id = $request->supervisor_id;
                        $item2->class_id = $request->class_id[$i];
                        $item2->room_id = $room_id;
                        $item2->lesson_id = 555;
                        $item2->save();
                    }
                }
            }
        }



        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }




    public function acadsupervisor_store(Request $request)
    {

        $year = Year::where('current_year', '1')->first();

        $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'phone' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password|min:8',
        ]);

        $supervisor = Acadsupervisor::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'date_birth' => $request->date_birth,
        ]);


        if ($request->hasFile('image')) {

            $supervisor->image = $request->image->store('supervisorsimage', 'public');
        }

        $user = User::create([
            'name' => $request->first_name,
            'email' => $request->email,
            'mobile' => $request->phone,
            'password' => Hash::make($request->password),
            'view_password' => $request->password,
            'type' => '5',
            'acadsupervisor_id' => $supervisor->id,

        ]);


        $supervisor->save();
        return redirect()->back();
    }




    public function supervisor_store(Request $request)
    {

        $year = Year::where('current_year', '1')->first();

        $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'phone' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password|min:8',
        ]);

        $supervisor = Supervisor::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'date_birth' => $request->date_birth,
        ]);


        if ($request->hasFile('image')) {

            $supervisor->image = $request->image->store('supervisorsimage', 'public');
        }

        $user = User::create([
            'name' => $request->first_name,
            'email' => $request->email,
            'mobile' => $request->phone,
            'password' => Hash::make($request->password),
            'view_password' => $request->password,
            'type' => '3',
            'supervisor_id' => $supervisor->id,

        ]);


        $supervisor->save();
        return redirect()->back();
    }

    public function edit_supervisor_task($supervisor_id)
    {

        $supervisor = Supervisor::with([
            'classes.lessons2' => function ($q1) use ($supervisor_id) {
                // $supervisor=Supervisor::with(['classes.lessons2', fn ($q) use ($supervisor_id) {
                $q1->where('supervisor_id', $supervisor_id);
            }
        ])->find($supervisor_id);
        $supervisor->classes2 = $supervisor->classes->unique();

        unset($supervisor->classes);


        foreach ($supervisor->classes2 as $key =>  $class) {

            // groupe the properiate lessons;
            $x = [];
            foreach ($class->lessons2 as $class_lessons) {
                array_push($x, $class_lessons->id);
            }

            $lessons = Lesson::where('class_id', $class->id)->get();
            foreach ($lessons as $lesson) {
                if (in_array($lesson->id, $x)) {
                    $lesson->selected = true;
                } else {
                    $lesson->selected = false;
                }
            }
            $class->lessons = $lessons;
            unset($class->lessons2);
          $year = Year::where('current_year', '1')->first();
            // groupe the properiate rooms;
            $rooms_id = Supervisor_room_lesson::where('supervisor_id', $supervisor_id)->where('class_id', $class->id)->pluck('room_id')->toArray();
            $rooms = Room::where('class_id', $class->id)->where('year_id', $year->id)->get();
            foreach ($rooms as $room) {
                // if ($key == 1)  return [$room->id,$rooms_id];
                if (in_array($room->id, $rooms_id)) {
                    $room->selected = true;
                } else {
                    $room->selected = false;
                }
            }
            $class->rooms = $rooms;
        }

        $classes = Classe::all();
        return view('admin.edit_supervisor_task', compact('classes', 'supervisor'));
    }



    public function edit_acadsupervisor_task($supervisor_id)
    {

        $lessons = Acadsupervisor::with(['lessons.classes2'])->find($supervisor_id);
        $lessons = $lessons->lessons->unique();
        $supervisor = Acadsupervisor::find($supervisor_id);
        $classes = Classe::all();

        return view('admin.edit_acadsupervisor_task', compact('classes', 'lessons', 'supervisor'));
    }


    public function teacher_filter(Request $request)
    {
        $teachers = Teacher::where('first_name', "like", "%" . $request->teacher_now . "%")->orwhere('last_name', "like", "%" . $request->teacher_now . "%")->orwhere('phone', "like", "%" . $request->teacher_now . "%")
            ->get();

        return $teachers;
    }



    public function update_supervisor_set_task(Request $request)
    {

        if ($request->has('class_id') != '1') {
            Supervisor_class_lesson::where('supervisor_id', $request->supervisor_id)->delete();
            Supervisor_room_lesson::where('supervisor_id', $request->supervisor_id)->delete();
            return redirect()->back()->with('success', 'تم حذف مهام الموجه');
        }


        Supervisor_class_lesson::where('supervisor_id', $request->supervisor_id)->delete();
        Supervisor_room_lesson::where('supervisor_id', $request->supervisor_id)->delete();
        $supervisor = Supervisor::find($request->supervisor_id);


        for ($i = 0; $i < count($request->class_id); $i++) {
            if (isset($request->lesson_id))
                foreach ($request->lesson_id[$request->class_id[$i]] as $lesson_id) {




                    // *************************************************************
                    if (isset($request->room_id))
                        if (in_array(0, $request->room_id[$request->class_id[$i]])) {

                            $classes = Classe::with(['room:id,class_id'])->find($request->class_id[$i]);
                            $rooms_id = [];
                            foreach ($classes->room as $id) {
                                array_push($rooms_id, $id->id);
                            }
                            foreach ($rooms_id as $room_id) {
                                $item = new Supervisor_class_lesson;

                                $item->supervisor_id = $request->supervisor_id;
                                $item->class_id = $request->class_id[$i];
                                $item->lesson_id = $lesson_id;
                                $item->room_id = $room_id;
                                $item->save();

                                $item2 = new Supervisor_room_lesson;
                                $item2->supervisor_id = $request->supervisor_id;
                                $item2->class_id = $request->class_id[$i];
                                $item2->room_id = $room_id;
                                $item2->lesson_id = $lesson_id;
                                $item2->save();
                            }
                        } else {

                            foreach ($request->room_id[$request->class_id[$i]] as $room_id) {
                                $item = new Supervisor_class_lesson;

                                $item->supervisor_id = $request->supervisor_id;
                                $item->class_id = $request->class_id[$i];
                                $item->lesson_id = $lesson_id;
                                $item->room_id = $room_id;
                                $item->save();

                                $item2 = new Supervisor_room_lesson;
                                $item2->supervisor_id = $request->supervisor_id;
                                $item2->class_id = $request->class_id[$i];
                                $item2->room_id = $room_id;
                                $item2->lesson_id = $lesson_id;
                                $item2->save();
                            }
                        }
                    // *************************************************************




                }
        }

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function update_acadsupervisor_set_task(Request $request)
    {

        if ($request->has('class_id') != '1') {
            return redirect(route('admin.teacher.set_task', $request->supervisor_id));
        }


        Acadsupervisor_class::where('supervisor_id', $request->supervisor_id)->delete();
        $supervisor = Acadsupervisor::find($request->supervisor_id);


        for ($i = 0; $i < count($request->class_id); $i++) {

            $item = new Acadsupervisor_class;
            $item->supervisor_id = $request->supervisor_id;
            $item->class_id = $request->class_id[$i];
            $item->lesson_id = $request->lesson_id[$i];
            $item->save();
        }

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }



    public function set_acadsupervisor_task($supervisor_id)
    {

        $supervisor = Acadsupervisor::find($supervisor_id);
        $classes = Classe::all();
        return view('admin.set_acadsupervisor_task', compact('supervisor', 'classes'));
    }

    public function set_supervisor_task($supervisor_id)
    {

        $supervisor = Supervisor::find($supervisor_id);
        $classes = Classe::all();
        return view('admin.set_supervisor_task', compact('supervisor', 'classes'));
    }




    public function supervisors()
    {

        $supervisors = Supervisor::with('user')->paginate(20);
        $count = Supervisor::count();
        $classes = Classe::all();
        return view('admin.supervisors', compact('supervisors', 'count', 'classes'));
    }


    public function acadsupervisors()
    {

        $supervisors = Acadsupervisor::with('user')->with(['classes' => function ($query) {
            $query->select("classes.id");
        }])->paginate(20);
        $count = Acadsupervisor::count();
        $classes = Classe::all();
        return view('admin.acadsupervisors', compact('supervisors', 'count', 'classes'));
    }



    public function lesson_delete(Request $request)
    {



        $year = Year::where('current_year', '1')->first();
        $lesson = Lesson::find($request->id);
        $class = Lesson::find($request->id)->classes;
        $rooms = $class->room()->where('rooms.year_id', $year->id)->get();
        $ss = [];
        $students = [];
        foreach ($rooms as $room) {
            $ss[] = $room->student;
        }
        foreach ($ss as $s) {
            foreach ($s as $student) {
                if ($lesson->lang != null) {

                    $student_mark = Students_mark::where('student_id', $student->id)->where('lang', $lesson->lang)->where('year_id', $year->id)->first();
                } elseif ($lesson->lang == null && $lesson->religion == null) {
                    $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();
                }

                if (isset($student_mark) && $student_mark != "") {


                    $arr1 = json_decode($student_mark->mark, true);
                    $arr2 = json_decode($student_mark->mark2, true);
                    $arr_result1 = json_decode($student_mark->result1, true);
                    $arr_result2 = json_decode($student_mark->result2, true);
                    $arr_result = json_decode($student_mark->result, true);

                    if (array_key_exists($request->id, $arr1) == '1') {

                        unset($arr1[$request->id]);

                        $student_mark->mark = json_encode($arr1);
                    }

                    if (array_key_exists($request->id, $arr2)) {

                        unset($arr2[$request->id]);
                        $student_mark->mark2 = json_encode($arr2);
                    }


                    if (array_key_exists($request->id, $arr_result1)) {

                        unset($arr_result1[$request->id]);
                        $student_mark->result1 = json_encode($arr_result1);
                    }

                    if (array_key_exists($request->id, $arr_result2)) {

                        unset($arr_result2[$request->id]);
                        $student_mark->result2 = json_encode($arr_result2);
                    }

                    if (array_key_exists($request->id, $arr_result)) {

                        unset($arr_result[$request->id]);
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


                    $year_result = (json_decode($student_mark->term_result, true)['term1']
                        + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->year_result = $year_result;
                    $student_mark->save();
                }
            }
        }



        // ===============



        $ss = [];
        $students = [];
        foreach ($rooms as $room) {
            $ss[] = $room->student;
        }
        foreach ($ss as $s) {
            foreach ($s as $student) {
                if ($lesson->religion != null) {

                    $student_mark = Students_mark::where('student_id', $student->id)->where('religion', $lesson->religion)->where('year_id', $year->id)->first();

                    if (isset($student_mark) && $student_mark != "") {
                        # code...
                        $arr1 = json_decode($student_mark->mark, true);
                        $arr2 = json_decode($student_mark->mark2, true);
                        $arr_result1 = json_decode($student_mark->result1, true);
                        $arr_result2 = json_decode($student_mark->result2, true);
                        $arr_result = json_decode($student_mark->result, true);

                        if (array_key_exists($request->id, $arr1) == '1') {

                            unset($arr1[$request->id]);

                            $student_mark->mark = json_encode($arr1);
                        }

                        if (array_key_exists($request->id, $arr2)) {

                            unset($arr2[$request->id]);
                            $student_mark->mark2 = json_encode($arr2);
                        }


                        if (array_key_exists($request->id, $arr_result1)) {

                            unset($arr_result1[$request->id]);
                            $student_mark->result1 = json_encode($arr_result1);
                        }

                        if (array_key_exists($request->id, $arr_result2)) {

                            unset($arr_result2[$request->id]);
                            $student_mark->result2 = json_encode($arr_result2);
                        }

                        if (array_key_exists($request->id, $arr_result)) {

                            unset($arr_result[$request->id]);
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


                        $year_result = (json_decode($student_mark->term_result, true)['term1']
                            + json_decode($student_mark->term_result, true)['term2']) / 2;

                        $student_mark->year_result = $year_result;
                        $student_mark->save();
                    }
                }
            }
        }




        $lesson_id = $request->id;
        $lesson = Lesson::find($lesson_id);
        if ($lesson->image1 != null) {

            Storage::disk('public')->delete($lesson->image1);
        }

        if ($lesson->image2 != null) {

            Storage::disk('public')->delete($lesson->image2);
        }


        if ($lesson->image3 != null) {

            Storage::disk('public')->delete($lesson->image3);
        }


        if ($lesson->image4 != null) {

            Storage::disk('public')->delete($lesson->image4);
        }

        if ($lesson->book1 != null) {
            if ($lesson->type_file1 != '0') {
                Storage::disk('public')->delete($lesson->book1);
            }
        }

        if ($lesson->book2 != null) {
            if ($lesson->type_file2 != '0') {
                Storage::disk('public')->delete($lesson->book2);
            }
        }

        if ($lesson->book3 != null) {
            if ($lesson->type_file3 != '0') {
                Storage::disk('public')->delete($lesson->book3);
            }
        }


        if ($lesson->book4 != null) {
            if ($lesson->type_file4 != '0') {
                Storage::disk('public')->delete($lesson->book4);
            }
        }

        $student_lesson = Student_lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->delete();
        $teacher_lesson = Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->delete();
        $content_lesson = Teacher_room_lesson::where('lesson_id', $lesson_id)->delete();

        $lesson->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function book_update(Request $request)
    {


        $lesson = Lesson::find($request->lesson_id);
        $books = json_decode($lesson->books);
        if ($books == null) {
            $books = [];
        }
        $books2 = [];
  if (!empty($request->book)) {
        for ($i = 0; $i < count($request->book); $i++) {
            if ($request->book[$i]["id"] == 0) {
                $book = new stdClass;
                $book->id = $i + 1;
                $book->type = $request->book[$i]["typebook"];

                if ($request->book[$i]["typebook"] == "link") {

                    $book->value = $request->book[$i]["link_book"];
                } else {

                    if (isset($request->book[$i]["file_book"])) {
                        $book->value = $request->book[$i]["file_book"]->store('filesstudents', 'public');
                    }
                }
                if (isset($request->book[$i]["img_book"])) {
                    $book->image = $request->book[$i]["img_book"]->store('filesstudents', 'public');
                }
                $book->name_ar = $request->book[$i]["name_ar"];
                $book->name_en = $request->book[$i]["name_en"];
                $books2[] = $book;
            } else {
                if ($request->book[$i]["typebook"] == "link") {
                    $book = new stdClass;
                    foreach ($books as $key => $value) {

                        if ($value->id == $request->book[$i]["id"]) {
                            if ($value->type == "book") {
                                if ($value->value != "") {
                                    Storage::disk('public')->delete($value->value);
                                }
                            }
                            if (isset($request->book[$i]["img_book"])) {
                                $book->image = $request->book[$i]["img_book"]->store('filesstudents', 'public');
                            } else if (isset($value->image)) {
                                $book->image = $value->image;
                            }
                            break;
                        }
                    }
                    $book->id = $i + 1;
                    $book->type = $request->book[$i]["typebook"];
                    if ($request->book[$i]["typebook"] == "link") {
                        $book->value = $request->book[$i]["link_book"];
                    } else {
                        if (isset($request->book[$i]["file_book"])) {
                            $book->value = $request->book[$i]["file_book"]->store('filesstudents', 'public');
                        }
                    }

                    $book->name_ar = $request->book[$i]["name_ar"];
                    $book->name_en = $request->book[$i]["name_en"];
                    $books2[] = $book;
                } else {
                    $book = new stdClass;

                    foreach ($books as $key => $value) {

                        if ($value->id == $request->book[$i]["id"]) {
                            if ($value->type == "book") {
                                if ($value->value != "") {
                                    if (isset($request->book[$i]["file_book"])) {
                                        Storage::disk('public')->delete($value->value);
                                        $book->value = $request->book[$i]["file_book"]->store('filesstudents', 'public');
                                    } else {
                                        $book->value = $value->value;
                                    }
                                }
                            }

                            if ($request->book[$i]["typebook"] == "link") {
                                $book->value = $request->book[$i]["link_book"];
                            } else {
                                if (isset($request->book[$i]["file_book"])) {
                                    $book->value = $request->book[$i]["file_book"]->store('filesstudents', 'public');
                                }
                            }

                            if (isset($request->book[$i]["img_book"])) {
                                $book->image = $request->book[$i]["img_book"]->store('filesstudents', 'public');
                            } else if (isset($value->image)) {
                                $book->image = $value->image;
                            }
                            break;
                        }
                    }
                }
                    $book->id = $i + 1;
                    $book->type = $request->book[$i]["typebook"];
                    $book->name_ar = $request->book[$i]["name_ar"];
                    $book->name_en = $request->book[$i]["name_en"];
                    $books2[] = $book;
                }
            }
        }
        $lesson->books = json_encode($books2);
        $lesson->save();
        return redirect()->back();
    }

    public function delete_books($lesson_id, $id)
    {
        $lesson = Lesson::find($lesson_id);
        $books = json_decode($lesson->books);
        $books2 = [];
        foreach ($books as $key => $value) {
            if ($value->id != $id) {
                $value->id = $key;
                $books2[] = $value;
            }
        }
        $lesson->books = json_encode($books2);
        $lesson->save();
        return redirect()->back();
    }

    public function lesson_store(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'name_en' => 'required',
            'base_subject_id' => 'required',
            // 'mark_base_subject_id'=>'required',
            'class_id' => 'required|numeric',
            'max_mark' => 'required',
            'min_mark' => 'required',
        ]);

        $lesson = new Lesson;

        $lesson->is_english = $request->is_english;

        if ($request->has('select_lang')) {
            $lesson->lang = $request->select_lang;
        }


        if ($request->has('select_religion')) {
            $lesson->religion = $request->select_religion;
        }


        $lesson->name = $request->name;
        $lesson->name_en = $request->name_en;
             if ($request->hasFile('image')) {

            $lesson->img = $request->image->store('classimages', 'public');
        }


        $lesson->type = null;
        $lesson->class_id = $request->class_id;
        $lesson->base_subject_id = $request->base_subject_id;
        $lesson->mark_base_subject_id = $request->mark_base_subject_id;
        $lesson->certificate_order = $request->certificate_order;
        $lesson->first_total = $request->first_total;
        $lesson->is_addable = $request->is_addable;
        $lesson->is_project = $request->is_project;
        if($request->is_neutral=='4'){

       $lesson->not_affect_and_collect= null;

    //   مادة غير مرسبة لكن تدخل في المجموع
       $lesson->is_neutral = '2';



        }else if($request->is_neutral=='2'){

            //   مادة مرسبة لكن ليست لوحدها وتدخل بالمجموع
        $lesson->is_neutral = $request->is_neutral;
        $lesson->not_affect_and_collect='1';


}else {
        $lesson->is_neutral = $request->is_neutral;


    }
        $lesson->max_mark = $request->max_mark;
        $lesson->min_mark = $request->min_mark;
        $lesson->is_behavior = $request->is_behavior;



        $lesson->save();
        $year = Year::where('current_year', '1')->first();


        if ($request->has('select_religion')) {

            $rooms = Classe::find($request->class_id)->room()->where('rooms.year_id', $year->id)->get('id');
            $cont = [];
            foreach ($rooms as $room) {
                $cont[] = Students_mark::where('room_id', $room->id)->where('religion', $request->select_religion)->get();
            }
            $students_marks = [];
            foreach ($cont as $room) {
                foreach ($room as $item) {
                    if ($item != "") {


                        //  هون كل حقل بالسجل عبارة عن نص
                        $students_marks[] = $item;
                        //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
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
            }
        } elseif ($request->has('select_lang')) {

            $rooms = Classe::find($request->class_id)->room()->where('rooms.year_id', $year->id)->get('id');
            $cont = [];
            foreach ($rooms as $room) {
                $cont[] = Students_mark::where('room_id', $room->id)->where('lang', $request->select_lang)->get();
            }
            // return count($cont);
            $students_marks = [];
            foreach ($cont as $room) {
                foreach ($room as $item) {
                    if ($item != "") {


                        //  هون كل حقل بالسجل عبارة عن نص
                        $students_marks[] = $item;
                        //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
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
            }
        } else {


            $rooms = Classe::find($request->class_id)->room()->where('rooms.year_id', $year->id)->get('id');
            $cont = [];
            foreach ($rooms as $room) {
                $cont[] = Students_mark::where('room_id', $room->id)->get();
            }
            $students_marks = [];
            foreach ($cont as $room) {
                foreach ($room as $item) {
                    if ($item != "") {

                        //  هون كل حقل بالسجل عبارة عن نص
                        $students_marks[] = $item;
                        //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
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
            }
        }
        return redirect()->back()->with('success', 'تمت العملية بنجاح');
    }



    public function lesson_update(Request $request)
    {

        $year = Year::where('current_year', '1')->first();
        $lesson = Lesson::find($request->lesson_id);
        $class_lesson = $lesson->class_id;
        $lesson->is_english = $request->is_english;


        $lesson->name = $request->name;
        $lesson->name_en = $request->name_en;
        $lesson->type = null;
        $lesson->class_id = $request->class_id;
        $lesson->base_subject_id = $request->base_subject_id;
        $lesson->mark_base_subject_id = $request->mark_base_subject_id;
        $lesson->certificate_order = $request->certificate_order;
        $lesson->first_total = $request->first_total;
        $lesson->is_addable = $request->is_addable;
        $lesson->is_project = $request->is_project;
         if ($request->has('select_lang')) {
            $lesson->lang = $request->select_lang;
        }
        if ($request->has('select_religion')) {
            $lesson->religion = $request->select_religion;
        }
         if($request->is_neutral=='4'){

       $lesson->not_affect_and_collect= null;

    //   مادة غير مرسبة لكن تدخل في المجموع
       $lesson->is_neutral = '2';



        }else if($request->is_neutral=='2'){

            //   مادة مرسبة لكن ليست لوحدها وتدخل بالمجموع
        $lesson->is_neutral = $request->is_neutral;
        $lesson->not_affect_and_collect='1';


}else {
        $lesson->is_neutral = $request->is_neutral;


    }
        $lesson->is_behavior = $request->is_behavior;

        $lesson->max_mark = $request->max_mark;
        $lesson->min_mark = $request->min_mark;
                if ($request->hasFile('image')) {
            Storage::disk('public')->delete($lesson->img);
            $lesson->img = $request->image->store('classimages', 'public');
        }
        $lesson->save();




        if ($class_lesson != $request->class_id) {


            $class = Lesson::find($request->lesson_id)->classes;
            $rooms = $class->room()->where('rooms.year_id', $year->id)->get();
            $ss = [];
            $students = [];

            foreach ($rooms as $room) {
                $ss[] = $room->student;
            }

            foreach ($ss as $s) {
                foreach ($s as $student) {

                    if ($lesson->lang != null) {

                        $student_mark = Students_mark::where('student_id', $student->id)->where('lang', $lesson->lang)->where('year_id', $year->id)->first();
                    } elseif ($lesson->lang == null && $lesson->religion == null) {


                        $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $year->id)->first();
                    }
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


                        $year_result = (json_decode($student_mark->term_result, true)['term1']
                            + json_decode($student_mark->term_result, true)['term2']) / 2;

                        $student_mark->year_result = $year_result;
                        $student_mark->save();
                    }
                }
            }



            $ss = [];
            $students = [];

            foreach ($rooms as $room) {
                $ss[] = $room->student;
            }

            foreach ($ss as $s) {
                foreach ($s as $student) {

                    if ($lesson->religion != null) {

                        $student_mark = Students_mark::where('student_id', $student->id)->where('religion', $lesson->religion)->where('year_id', $year->id)->first();



                        if ($student_mark != "") {




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


                            $year_result = (json_decode($student_mark->term_result, true)['term1']
                                + json_decode($student_mark->term_result, true)['term2']) / 2;

                            $student_mark->year_result = $year_result;
                            $student_mark->save();
                        }
                    }
                }
            }







            // -------------------------------------------------------













            if ($lesson->lang != null) {

                $rooms = Classe::find($request->class_id)->room()->where('rooms.year_id', $year->id)->get('id');
                $cont = [];
                foreach ($rooms as $room) {
                    $cont[] = Students_mark::where('room_id', $room->id)->where('lang', $lesson->lang)->get();
                }
                // return count($cont);
                $students_marks = [];
                foreach ($cont as $room) {
                    foreach ($room as $item) {
                        if ($item != "") {
                            # code...

                            //  هون كل حقل بالسجل عبارة عن نص
                            $students_marks[] = $item;
                            //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
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
                }
            } elseif ($lesson->lang == null && $lesson->religion == null) {



                $rooms = Classe::find($request->class_id)->room()->where('rooms.year_id', $year->id)->get('id');
                $cont = [];
                foreach ($rooms as $room) {
                    $cont[] = Students_mark::where('room_id', $room->id)->get();
                }
                // return count($cont);
                $students_marks = [];
                foreach ($cont as $room) {
                    foreach ($room as $item) {
                        if ($item != "") {
                            # code...

                            //  هون كل حقل بالسجل عبارة عن نص
                            $students_marks[] = $item;
                            //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
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
                }
            }


            // =======================


            if ($lesson->religion != null) {

                $rooms = Classe::find($request->class_id)->room()->where('rooms.year_id', $year->id)->get('id');
                $cont = [];
                foreach ($rooms as $room) {
                    $cont[] = Students_mark::where('room_id', $room->id)->where('religion', $lesson->religion)->get();
                }
                // return count($cont);
                $students_marks = [];
                foreach ($cont as $room) {
                    foreach ($room as $item) {
                        if ($item != "") {
                            # code...

                            //  هون كل حقل بالسجل عبارة عن نص
                            $students_marks[] = $item;
                            //  هون حقل العلامات بعد تنفيذ الغاء تشفير عليه يصبح مصفوفة مترابطة الاضافة عليه كمصفوفة لانه لا يوجد كائن في php
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
                }
            }
        }

        $lesson->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }



    public function event_delete(Request $request)
    {

        $event_id = $request->id;
        $event = Event::find($event_id);
        if ($event->image != null) {

            Storage::disk('public')->delete($event->image);
        }
        $event->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function lesson_delete2(Request $request)
    {

        // $delete_code = Hash::make($request->delete_code);
        $formed_code = Auth::User()->view_password;
        if ($formed_code == $request->delete_code) {

            $to_delete1 =   Coordinator_class_lesson::where('lesson_id', $request->lesson_id_delete)->get();

            foreach ($to_delete1 as $x) {
                $x->delete();
            }
            //  $to_delete2 =   Exams::where('lesson_id',$request->lesson_id_delete)->get();
            //
            //  foreach($to_delete2 as $x){
            //     $x->delete();
            //  }
            $to_delete21 =   Exams2::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete21 as $x) {
                $x->delete();
            }
            $to_delete3 =   Exam_result::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete3 as $x) {
                $x->delete();
            }

            $to_delete31 =   Lecture::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete31 as $x) {
                $x->delete();
            }
            $to_delete4 =   Lesson_teacher_room_term_exam::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete4 as $x) {
                $x->delete();
            }
            $to_delete41 =   Lesson_room_teacher_lecture_time::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete41 as $x) {
                $x->delete();
            }
            $to_delete42 =   Planification_trimestrielle::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete42 as $x) {
                $x->delete();
            }
            $to_delete43 =   Prepare::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete43 as $x) {
                $x->delete();
            }
            $to_delete5 =   Question::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete5 as $x) {
                $x->delete();
            }
            $to_delete6 =   Room_lesson_exam::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete6 as $x) {
                $x->delete();
            }
            $to_delete7 =   Section::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete7 as $x) {
                $x->delete();
            }
            $to_delete7 =   Section::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete7 as $x) {
                $x->delete();
            }
            //  $to_delete8 =   Students_mark::where('lesson_id',$request->lesson_id_delete)->get();
            //  foreach($to_delete8 as $x){
            //     $x->delete();
            //  }
            // }
            $to_delete9 =   Student_lesson_teacher_room_term_exam::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete9 as $x) {
                $x->delete();
            }
            $to_delete10 =   Supervisor_class_lesson::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete10 as $x) {
                $x->delete();
            }
            $to_delete101 =   Supervisor_teacher_item::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete101 as $x) {
                $x->delete();
            }
            $to_delete11 =   Teacher_room_lesson::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete11 as $x) {
                $x->delete();
            }
            $to_delete12 =   Unit_analysis::where('lesson_id', $request->lesson_id_delete)->get();
            foreach ($to_delete12 as $x) {
                $x->delete();
            }
            Lesson::findOrFail($request->lesson_id_delete)->delete();
        } else {
            return redirect()->back()->with('error', '! تأكد من البيانات المدخلة  ]');
        }


        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }




    public function session_store(Request $request)
    {

        foreach ($request->class as $item) {

            foreach ($request->room as $item2) {
                $session = new Lecture_time;
                $session->name = $request->session_name;
                $session->type = $request->type;
                $session->start_time = $request->start_time;
                $session->end_time = $request->end_time;
                $session->class_id = $item;
                $session->room_id = $item2;

                $session->save();
            }
        }

        return redirect()->back();
    }
    public function session_store1(Request $request)
    {



        foreach ($request->room as $item2) {
            $room = Room::find($item2);
            $session = new Lecture_time;
            $session->name = $request->session_name;
            $session->type = $request->type;
            $session->start_time = $request->start_time;
            $session->end_time = $request->end_time;
            $session->class_id = $room->class_id;
            $session->room_id = $item2;

            $session->save();
        }

        return redirect()->back();
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


    public function lessons2()
    {

        $classes = Classe::all();

        return view('admin.lessons2', compact('classes'));
    }

    public function lessons($id)
    {


          $lessons = Lesson::where('class_id', $id)->get();
        $class = Classe::find($id);
        $base_subjects = Base_subjects::all();


        return view('admin.lessons', compact('lessons', 'class', 'base_subjects'));
    }


    public function base_subjects($class_id)
    {


        $base_subjects = Base_subjects::paginate(paginate_num);

        $count = Base_subjects::count();


        return view('admin.base_subject', compact('count', 'base_subjects', 'class_id'));
    }
    public function base_subject_store(Request $request)
    {
        // return $request ;
        $base_subject = new Base_subjects;
        $base_subject->name = $request->name;
        $base_subject->type = $request->type;
        $base_subject->save();
        Session::flash('success', 'تم التخزين بنجاح');
        return redirect()->back();
    }
    public function base_subject_update(Request $request)
    {
        // return $request ;
        $base_subject =  Base_subjects::findOrFail($request->base_subject_id);
        $base_subject->name = $request->name;
        $base_subject->type = $request->type;
        $base_subject->save();
        Session::flash('success', 'تم التخزين بنجاح');
        return redirect()->back();
    }
    public function base_subject_delete(Request $request)
    {
        // return $request ;
        $base_subject =  Base_subjects::findOrFail($request->base_subject_id);
        if (isset($base_subject))
            $base_subject->delete();

        Session::flash('success', 'تم التخزين بنجاح');
        return redirect()->back();
    }

    public function session_update(Request $request)
    {

        $session = Lecture_time::find($request->id);
        $session->name = $request->session_name;
        $session->start_time = $request->start_time;
        $session->type = $request->type;
        $session->end_time = $request->end_time;
        $session->save();

        return redirect()->back();
    }





    public function reset_password(Request $request, $id)
    {

        $user = User::find($id);
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
            return redirect()->back()->with('warning', 'Incorrect Old Password  !');
        }
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }






  public function student_update(Request $request, $student_id)
    {

        $user = User::where('student_id', $student_id)->first();

        $year = Year::where('current_year', '1')->first();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            //   'public_record_number'=>'required|Numeric|unique:students,public_record_number,'.$user->student_id,
                ],[
                // 'public_record_number.unique' => 'رقم السجل العام موجود مسبقاً' ,

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
        $student->country_currency = $request->country_currency;
        $student->country = $request->country;


        $student->public_record_number =  $request->public_record_number;

        $student_detail = Student_detail::where('student_id', $student->id)->first();
        $student_detail->father_name = $request->father_name;
        $student_detail->mother_name = $request->mother_name;
        $student_detail->mother_phone = $request->mother_phone;
        $student_detail->father_phone = $request->father_phone;
         $student_detail->grandfather_name = $request->grandfather_name;
        $student_detail->mother_job = $request->mother_job;
        $student_detail->father_job = $request->father_job;
        $student_detail->phone = $request->phone;
        $student_detail->other_phone = $request->other_phone;
        $student_detail->city = $request->city;
        $student_detail->city_alt = $request->city_alt;
        $student_detail->other_name = $request->other_name;
        $student_detail->stage = $request->stage;
        $student_detail->the_previous_school = $request->the_previous_school;
        $student_detail->student_brather_and_sister = $request->student_brather_and_sister;
        $student_detail->passport_number = $request->passport_number;
        $student_detail->gender = $request->gender;
        $student_detail->blood_type = $request->blood_type;
        $student_detail->last_mother_name = $request->last_mother_name;
        $student_detail->the_ID_number = $request->the_ID_number;
         //new
    $student_detail->number_file = $request->number_file;
    $student_detail->status_cooperation = $request->status_cooperation;
    $student_detail->status_activity = $request->status_activity;
    $student_detail->status_books = $request->status_books;
    $student_detail->transfer_country = $request->transfer_country;
    $student_detail->transfer_school = $request->transfer_school;
    $student_detail->head_teacher = $request->head_teacher;
    $student_detail->date_seend = $request->date_seend;
    $student_detail->book1 = $request->book1;
    $student_detail->book_state1 = $request->book_state1;
    $student_detail->book2 = $request->book2;
    $student_detail->book_state2 = $request->book_state2;
    $student_detail->book3 = $request->book3;
    $student_detail->book_state3 = $request->book_state3;
    $student_detail->book4 = $request->book4;
    $student_detail->book_state4 = $request->book_state4;
    $student_detail->book5 = $request->book5;
    $student_detail->book_state5 = $request->book_state5;
    $student_detail->book6 = $request->book6;
    $student_detail->book_state6 = $request->book_state6;
    $student_detail->branch = $request->branch;
    $student_detail->behavior = $request->behavior;
    $student_detail->secret_keeper = $request->secret_keeper;
    $student_detail->days_unabsence = $request->days_unabsence;
    $student_detail->days_unabsence = $request->days_absence;
    $student_detail->leaving_school = $request->leaving_school;
    $student_detail->working_days = $request->working_days;


if($request->val){


  foreach($request->val as $key=>$val){

          $stu=Student_details_field_value::where('student_details_field_id',$key)->where('student_id',$student_id)->first();
          $student_details_department_field =Student_details_department_field ::find($key);
           if($stu){
            $stu->student_details_field_id=$key;
            $stu->student_id=$student_id;
            if($student_details_department_field ->type==4){
                if ($request->hasFile('val')) {
                    Storage::disk('public')->delete($stu->val);
                    $stu->value = $val->store('studentsimage', 'public');
                }
            }
            else{
                $stu->value=$val;
            }

            $stu->save();


           }
           else{
            $stu1=  new Student_details_field_value ();
            $stu1->student_details_field_id=$key;
            $stu1->student_id=$student_id;
            if($student_details_department_field ->type==4){
                if ($request->hasFile('val')) {
                    $stu1->value = $val->store('studentsimage', 'public');
                }
            }
            else{
                $stu1->value=$val;
            }
            $stu1->save();
           }


        }
}
        if ($request->hasFile('personal_image')) {

            Storage::disk('public')->delete($student_detail->personal_image);

            $student_detail->personal_image = $request->personal_image->store('studentsimage', 'public');
        }
        if ($request->hasFile('family_book')) {

            Storage::disk('public')->delete($student_detail->family_book);

            $student_detail->family_book = $request->family_book->store('studentsimage', 'public');
        }
        if ($request->hasFile('mother_image')) {

            Storage::disk('public')->delete($student_detail->mother_image);

            $student_detail->mother_image = $request->mother_image->store('studentsimage', 'public');
        }
        if ($request->hasFile('father_image')) {

            Storage::disk('public')->delete($student_detail->father_image);

            $student_detail->father_image = $request->father_image->store('studentsimage', 'public');
        }
        if ($request->hasFile('fourth_image')) {

            Storage::disk('public')->delete($student_detail->fourth_image);

            $student_detail->fourth_image = $request->fourth_image->store('studentsimage', 'public');
        }
        if ($request->hasFile('passport')) {

            Storage::disk('public')->delete($student_detail->passport);

            $student_detail->passport = $request->passport->store('studentsimage', 'public');
        }
        if ($request->hasFile('mother_page')) {

            Storage::disk('public')->delete($student_detail->mother_page);

            $student_detail->mother_page = $request->mother_page->store('studentsimage', 'public');
        }
        if ($request->hasFile('father_page')) {

            Storage::disk('public')->delete($student_detail->father_page);

            $student_detail->father_page = $request->father_page->store('studentsimage', 'public');
        }
        if ($request->hasFile('study_sequence')) {

            Storage::disk('public')->delete($student_detail->study_sequence);

            $student_detail->study_sequence = $request->study_sequence->store('studentsimage', 'public');
        }
        if ($request->hasFile('certification')) {

            Storage::disk('public')->delete($student_detail->certification);

            $student_detail->certification = $request->certification->store('studentsimage', 'public');
        }
        if ($request->hasFile('certification_nine')) {

            Storage::disk('public')->delete($student_detail->certification_nine);

            $student_detail->certification_nine = $request->certification_nine->store('studentsimage', 'public');
        }
         if ($request->hasFile('basic_transger_file')) {

            Storage::disk('public')->delete($student_detail->basic_transger_file);

            $student_detail->basic_transger_file = $request->basic_transger_file->store('studentsimage', 'public');
        }

        if ($request->hasFile('secondary_transfer_file')) {

            Storage::disk('public')->delete($student_detail->secondary_transfer_file);

            $student_detail->secondary_transfer_file = $request->secondary_transfer_file->store('studentsimage', 'public');
        }

        if ($request->hasFile('phase_class6')) {

            Storage::disk('public')->delete($student_detail->phase_class6);

            $student_detail->phase_class6 = $request->phase_class6->store('studentsimage', 'public');
        }

        if ($request->hasFile('phase_class9')) {

            Storage::disk('public')->delete($student_detail->phase_class9);

            $student_detail->phase_class9 = $request->phase_class9->store('studentsimage', 'public');
        }
        if ($request->hasFile('phase_class12')) {

            Storage::disk('public')->delete($student_detail->phase_class12);

            $student_detail->phase_class12 = $request->phase_class12->store('studentsimage', 'public');
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
        $user->email = $request->email;
        $user->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function reset_student_password(Request $request, $student_id)
    {

        $user = User::where('student_id', $student_id)->first();
        $this->validate($request, [
            'password'              => 'required|min:4',
            'password_confirmation' => 'required|same:password'
        ]);

        $user->password = Hash::make($request->password);
        $user->view_password = $request->password;

        $user->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }



    public function student_archive($student_id)
    {

        $student=Student::with(['details','room.report_cards'=>fn($q1) => $q1->where('student_id',$student_id)])->find($student_id);
        $date = Carbon::now();
        $date = $date->format('m/d/Y');
        return view('admin.archive', compact('student', 'date'));
    }

    public function get_employee_detail(Request $request)
    {
        return Employee::find($request->id);
    }

    public function employees()
    {
        return view('admin.employee');
    }


    public function teachers()
    {
        $teachers = Teacher::with('user')->orderBy('first_name')->paginate(20);
        $count = Teacher::count();
        $classes = Classe::all();
        return view('admin.teacher', compact('teachers', 'count', 'classes'));
    }

    public function teacher_update(Request $request)
    {
         $user = User::where('teacher_id', $request->teacher_id)->first();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',

            'phone' => 'required',
        ]);

        $teacher = Teacher::find($request->teacher_id);
        $teacher->first_name = $request->first_name;
        $teacher->last_name = $request->last_name;
        $teacher->email = $request->email;
        $teacher->date_birth = $request->date_birth;
        $teacher->phone = $request->phone;
        $teacher->address = $request->address;
        $teacher->salary = $request->salary;
        $teacher->Description_ar = $request->Description_ar;
        $teacher->Description_en = $request->Description_en;
        $teacher->lesson_name = $request->lesson_name;
        $teacher->vcation_days = $request->vcation_days;
        $teacher->contract = $request->contract;
        if($request->val){
             foreach($request->val as $key=>$val){

            $teach=Teacher_details_field_value::where('teacher_details_field_id',$key)->where('teacher_id',$request->teacher_id)->first();
            $student_details_department_field =Teacher_details_department_field ::find($key);
             if($teach){
              $teach->teacher_details_field_id=$key;
              $teach->teacher_id=$request->teacher_id;
              if($student_details_department_field ->type==4){
                  if ($request->hasFile('val')) {
                      Storage::disk('public')->delete($teach->val);
                      $teach->value = $val->store('studentsimage', 'public');
                  }
              }
              else{
                  $teach->value=$val;
              }

              $teach->save();


             }
             else{
              $teach1=  new Teacher_details_field_value ();
              $teach1->teacher_details_field_id=$key;
              $teach1->teacher_id=$request->teacher_id;
              if($student_details_department_field ->type==4){
                  if ($request->hasFile('val')) {
                      $teach1->value = $val->store('studentsimage', 'public');
                  }
              }
              else{
                  $teach1->value=$val;
              }
              $teach1->save();
             }


          }
        }

        if ($request->type) {
            $teacher->type = 1;
        } else {
            $teacher->type = null;
        }
        $user = User::where('teacher_id', $request->teacher_id)->first();
        $user->email = $request->email;

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete($teacher->image);

            $teacher->image = $request->image->store('teachersimage', 'public');
        }


        $user = User::where('teacher_id', $request->teacher_id)->first();
        if ($request->email) {
            $user->email = $request->email;
        }

         if ($request->password_confirmation) {
            if (isset($request->password_confirmation)) {

                $this->validate($request, [
                    'password' => 'required|min:6|confirmed',
                ], [
                    'password.required' => 'يرجى ادخال كلمة السر',
                    'password.min' => 'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل',
                    'password.confirmed' => 'كلمة السر غير متطابقة',
                ]);

                // Update the user's password
                $user->password = Hash::make($request->password);
                $user->view_password = $request->password;
            }
        }

        $user->save();

        $teacher->save();
        Session::flash('success', '! تمت العملية بنجاح');
        return redirect()->back();
    }

    public function set_task($teacher_id)
    {
        $teacher = Teacher::find($teacher_id);
        $classes = Classe::all();
        return view('admin.set_task', compact('teacher', 'classes'));
    }

    public function rooms($class_id)
    {

        $year = Year::where('current_year', '1')->first();
        $rooms = Room::where('class_id', $class_id)->where('year_id', $year->id)->get();
        return $rooms;
    }


    public function teacher_lessons($class_id)
    {
         $year = Year::where('current_year', '1')->first();
        $lessons = Lesson::where('class_id', $class_id)->get();
        $rooms = Room::where('class_id', $class_id)->where('year_id', $year->id)->get();
        return response()->json([
            'lessons' =>   $lessons,
            'rooms' =>   $rooms,
        ]);
    }


    public function teacher_schedule($id)
    {
        $year=Year::where('current_year','1')->first();
        $teacher = Teacher::find($id);
        $user = User::where('teacher_id', $id)->first();
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);
        $teacher_id = $id;

        $lecture_times = Lecture_time::all();
        // pring days
        $days = Day::all();
        // pring teacher schedule
        $schedule = Lesson_room_teacher_lecture_time::with('lesson', 'lecture_time')
        ->WhereHas('room' ,function($q) use ($year){
            $q->where('year_id',$year->id);
        })
        ->with(['room.classes' => function ($query) {
                $query->select("id", "name");
        }])
        ->join('lecture_times', 'lecture_times.id', '=', 'lesson_room_teacher_lecture_time.lecture_time_id')
        ->orderBy('lecture_times.start_time')
        ->select("lesson_room_teacher_lecture_time.*")
        ->where('teacher_id', $id)->get();

        $schedule_count = Lesson_room_teacher_lecture_time::with('lesson', 'lecture_time')
        ->WhereHas('room' ,function($q) use ($year){
            $q->where('year_id',$year->id);
        })
        ->with(['room.classes' => function ($query) {
                $query->select("id", "name");
        }])
        ->join('lecture_times', 'lecture_times.id', '=', 'lesson_room_teacher_lecture_time.lecture_time_id')
        ->orderBy('lecture_times.start_time')
        ->select("lesson_room_teacher_lecture_time.*")
        ->where('teacher_id', $id)->count();

        // pring student schedule tracer
        $student_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::today())->where('user_id', $user->id)->get();
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

        $now = Carbon::now();
         return view('admin.new_teacher_schedule', compact('teacher', 'now', 'teacher_id', 'lecture_times', 'days', 'schedule', 'today'));
    }


    public function teacher_attendance($id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->first();
        $teacher = Teacher::find($id);
        $user = User::where('teacher_id', $id)->first();
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);
        $teacher_id = $id;

        //   $lecture_times = Lecture_time::all();

        $schedule = Lesson_room_teacher_lecture_time::with('lesson')
            ->WhereHas('room', function ($q) use ($year) {
                $q->where('year_id', $year->id);
            })
            ->with(['room.classes' => function ($query) {
                $query->select("id", "name");
            }])
            ->where('teacher_id', $id)->get();

        $diff = strtotime($term->start) - strtotime($term->end);
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        $diff_in_days = abs(round($diff / 86400));
        $x = 0;
        $y = [];


        //

        while ($term->end >= $term->start) {
            // while(Carbon::now()->subDays($x) >= Carbon::now()->subDays(35)) {
            $schedule = Lesson_room_teacher_lecture_time::WhereHas('room', function ($q) use ($year) {
                $q->where('year_id', $year->id);
            })->with('lesson')->with(['room.classes' => function ($query) {
                    $query->select("id", "name");
                }])
                ->where('teacher_id', $id)->get();
            $y11 = [];
            $x++;
            $user_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::parse($term->end)->subDays($x))->where('user_id', $user->id)->get();

            $timestamp = strtotime(Carbon::parse($term->end)->subDays($x));
            $this_day = date('l', $timestamp);
            $this_day = $this->getDay($this_day);
            $this_day_lecture = $schedule->where('day_id', $this_day + 1);
            $this_day_date = Carbon::parse($term->end)->subDays($x);
            $this_day_date = Carbon::parse($this_day_date);
            $this_day_date = $this_day_date->format('Y-m-d');



            //  if ($x == 87) return $user_schedule_tracer;


            $this_day_lectures = $schedule->where('day_id', $this_day + 1);

            foreach ($this_day_lectures  as $key => $this_day_lecture) {
                $tracer =  $user_schedule_tracer->where('lecture_time_id', $this_day_lecture->lecture_time_id);

                if (!blank($tracer)) {
                    $this_day_lecture->attendance = true;
                } else {
                    $this_day_lecture->attendance = false;
                }
                $y["$this_day_date"]['lectures'][] = $this_day_lecture;
            }
            if ($diff_in_days == $x) break;
        }
        $user_attendance = $y;
        $now = Carbon::now();
        //   return $user_attendance ;
        return view('admin.new_teacher_attendance', compact('teacher', 'now', 'teacher_id', 'user_attendance', 'schedule', 'today'));
    }

    public function student_attendance($student_id, $room_id, $month)
    {


        if ($room_id == 0) {
            return redirect()->back()->with('error', 'قم بتحديد شعبة الطالب');
        }
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->first();



        $student = Student::find($student_id);
        $room = Room::with('classes')->findOrFail($room_id);
        //    $room->class_name = $room->classes->name ;

        if (Carbon::parse($term->start)->format('m') == $month) {
            $start_year = Carbon::parse($term->start)->format('Y');
            $start = Carbon::create($start_year, $month)->startOfMonth()->format('Y-m-d');
            if (Carbon::parse($term->start)->format('Y-m-d') > $start) {
                $start = Carbon::parse($term->start)->format('Y-m-d');
            }
            $end = Carbon::create($start_year, $month)->lastOfMonth()->format('Y-m-d');
        } elseif (Carbon::parse($term->end)->format('m') == $month) {
            $end_year = Carbon::parse($term->end)->format('Y');
            $start = Carbon::create($end_year, $month)->startOfMonth()->format('Y-m-d');
            $end = Carbon::create($end_year, $month)->lastOfMonth()->format('Y-m-d');
            if (Carbon::parse($term->start)->format('Y-m-d') < $end) {
                $end = Carbon::parse($term->end)->format('Y-m-d');
            }
        } else {
            $period = CarbonPeriod::create($term->start, $term->end)->month();
            $months = collect($period)->map(function (Carbon $date) {
                return  $date->format("Y-m");
            })->toArray();

            foreach ($months as $item) {

                if (Carbon::parse($item)->format('m') == $month) {
                    $year10 = Carbon::parse($item)->format('Y');
                    $start = Carbon::create($year10, $month)->startOfMonth()->format('Y-m-d');
                    $end = Carbon::create($year10, $month)->lastOfMonth()->format('Y-m-d');
                }
            }
        }



        $user = User::where('student_id', $student_id)->first();
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);


        $lecture_times = Lecture_time::where('room_id', $room->id)->get();

        $schedule = Lesson_room_teacher_lecture_time::WhereHas('room', function ($q) use ($year) {
            $q->where('year_id', $year->id);
        })->with('lesson')->with(['room.classes' => function ($query) {
                $query->select("id", "name");
            }])
            ->where('room_id', $room_id)->get();

        $diff = strtotime($start) - strtotime($end);
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        $diff_in_days = abs(round($diff / 86400));
        $x = 0;
        $y = [];

        // جلب اليوم لكل يوم بالمجال واستعراض الحضور

        while ($end >= $start) {
            // while(Carbon::now()->subDays($x) >= Carbon::now()->subDays(35)) {
            $schedule = Lesson_room_teacher_lecture_time::with('lesson')->with(['room.classes' => function ($query) {
                    $query->select("id", "name");
                }])
                ->where('room_id', $room_id)->get();
            $y11 = [];
            $x++;
            $user_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::parse($end)->subDays($x))->where('user_id', $user->id)->get();

            $timestamp = strtotime(Carbon::parse($end)->subDays($x));
            $this_day = date('l', $timestamp);
            $this_day = $this->getDay($this_day);
            $this_day_lecture = $schedule->where('day_id', $this_day + 1);
            $this_day_date = Carbon::parse($end)->subDays($x);
            $this_day_date = Carbon::parse($this_day_date);
            $this_day_date = $this_day_date->format('Y-m-d');
            $this_day_lectures = $schedule->where('day_id', $this_day + 1);

            foreach ($this_day_lectures  as $key => $this_day_lecture) {
                $tracer =  $user_schedule_tracer->where('lecture_time_id', $this_day_lecture->lecture_time_id);
                if (!blank($tracer)) {
                    $this_day_lecture->attendance = true;
                } else {
                    $this_day_lecture->attendance = false;
                }
                $y["$this_day_date"]['lectures'][] = $this_day_lecture;
            }
            if ($diff_in_days == $x) break;
        }
        $user_attendance = $y;
        $now = Carbon::now();
        return view('admin.new_student_attendance', compact('student', 'now', 'student_id', 'lecture_times', 'user_attendance', 'schedule', 'today', 'room'));
    }



     //المشرف المدرسي
 public function coordinators()
 {
     $coordinators=Coordinator::with('user')->orderBy('first_name')->paginate(20);
     $count=Coordinator::count();
     //$classes = Classe::all();
     $year=Year::where('current_year','1')->first();
     $classes = Classe::with(['room' => function ($query) use ($year) {
                $query->where("year_id", $year->id);
            }])->WhereHas('room' ,function($q) use ($year){
            $q->where('year_id',$year->id);
        })->get();
     return view('admin.coordinator',compact('coordinators','count','classes'));
 }

 public function coordinator_store(Request $request){
         // $year= Year::where('current_year','1')->first();

         $request->validate([
             'first_name'=>'required|max:30',
             'last_name'=>'required|max:30',
             'phone'=>'required|max:20'
         ]);

         $coordinator = Coordinator::create([
             'first_name'=>$request->first_name,
             'last_name'=>$request->last_name,
             'address'=>$request->address,
             'age'=>$request->age,
             'phone'=>$request->phone,
             'email'=>$request->email,
             'date_birth'=>$request->date_birth,
         ]);


         if($request->hasFile('image')){
             $coordinator->image = $request->image->store('coordinatorsimage','public');
         }

         $user = User::create([
             'name'=>$request->first_name,
             'email'=>"a@app.com",
             'mobile'=>$request->phone,
             'password'=>Hash::make(5),
             'view_password'=>5,
             'type'=>'4',
             'type_id'=>$coordinator->id,
             'coordinator_id'=>$coordinator->id,
         ]);

         $email = str_replace(" ", "", $request->first_name_en).
         str_replace(" ", "", $request->last_name_en).rand(1,1000)."@aladham.com";
         if (strlen($request->first_name_en) > 2) {
             $namee = substr($request->first_name_en, 0, 3);
         }else{
             $namee = "aladham";
         }
         $password = $namee."@".rand(100000,900000);
         $user->email = $email;
         $user->password = Hash::make($password);
         $user->view_password = $password;
         $user->save();

         $coordinator->email = $email;
         $coordinator->save();

         Session::flash('success', '! تمت العملية بنجاح');
         return redirect()->back();

 }

 public function coordinator_update(Request $request ){

         $user=User::where('coordinator_id',$request->coordinator_id)->first();
         $request->validate([
             'first_name'=>'required',
             'last_name'=>'required',
             //'email' => 'required|unique:users,email,'.$user->id.',id',
             'phone'=>'required',
         ]);

         $coordinator=Coordinator::find($request->coordinator_id);
         $coordinator->first_name=$request->first_name;
         $coordinator->last_name=$request->last_name;
         $coordinator->email=$request->email;
         $coordinator->date_birth=$request->date_birth;
         $coordinator->phone=$request->phone;
         $coordinator->address=$request->address;



         if ($request->hasFile('image')) {

             Storage::disk('public')->delete($coordinator->image);

             $coordinator->image = $request->image->store('coordinatorsimage','public');
         }


     $user=User::where('coordinator_id',$request->coordinator_id)->first();
     $user->email=$request->email;
     if(isset($request->password)){

         $this->validate($request,[
             'password' => 'same:password_confirmation',
         ],[
             'password.required' =>'يرجى ادخال كلمة السر ',
             'password.same' =>'كلمة السر غير متطابقة',
         ]);
         $user->password = Hash::make($request->password);
         $user->view_password = $request->password;
     }

     $user->save();

     $coordinator->save();
     Session::flash('success', '! تمت العملية بنجاح');
     return redirect()->back();
 }

    public function coordinator_details($coordinator_id)
    {

        $year = Year::where('current_year', '1')->first();
        $coordinator = Coordinator::find($coordinator_id);
        return view('admin.coordinator_details', compact('coordinator'));
    }


    public function search_classes(Request $request, $les)
    {
        $lesson1 = [];
        $base_subjects = Base_subjects::with('lessons')->findOrFail($les);
        foreach ($base_subjects->lessons as $lesson) {

            $lesson1[] = $lesson->class_id;
        }
        $class = Classe::whereIn('id', $lesson1)->get();

        return $class;
    }
    //add tasks for  المشرف المدرسي
   public function store_coordinator_task(Request $request)
{
    $year = Year::where('current_year', '1')->first();
    Coordinator_room_lesson::where('coordinator_id', $request->coordinator_id)->delete();
    $coordinator = Coordinator::find($request->coordinator_id);

    for ($i = 0; $i < count($request->class_id); $i++) {
        $class_id = $request->class_id[$i];
        $lesson_ids = $request->lesson_id[$class_id];
        $room_ids = $request->room_id[$class_id];

        foreach ($lesson_ids as $lesson_id) {
            // If the room_id array contains 0, retrieve all room IDs associated with the class
            if (in_array(0, $room_ids)) {
                $classes = Classe::with(['room:id,class_id'])->find($class_id);
                $rooms_id = $classes->room->pluck('id')->toArray();

                foreach ($rooms_id as $room_id) {
                    $item = new Coordinator_room_lesson;
                    $item->coordinator_id = $request->coordinator_id;
                    $item->class_id = $class_id;
                    $item->room_id = $room_id;
                    $item->lesson_id = $lesson_id;
                    $item->year_id = $year->id;
                    $item->save();
                }
            } else {
                // If the room_id array does not contain 0
                foreach ($room_ids as $room_id) {
                    $item = new Coordinator_room_lesson;
                    $item->coordinator_id = $request->coordinator_id;
                    $item->class_id = $class_id;
                    $item->lesson_id = $lesson_id;
                    $item->room_id = $room_id;
                    $item->year_id = $year->id;
                    $item->save();
                }
            }
        }
    }

    Session::flash('success', 'ok');
    return redirect(route('coordinators'));
}

   //صفحة تعديل مهام المشرف المدرسي
public function edit_coordinator_task($coordinator_id)
{
    $year = Year::where('current_year', '1')->first();
    $coordinator = Coordinator::with([
        'classes.room_cor.lessons5' => function ($q1) use ($coordinator_id, $year) {
            $q1->where('coordinator_id', $coordinator_id)->where('year_id', $year->id);
        }
    ])->find($coordinator_id);
    $coordinator->classes2 = $coordinator->classes->unique();
    unset($coordinator->classes);

    foreach ($coordinator->classes2 as $key => $class) {
        // Get all lessons for the class
        $lessons = Lesson::where('class_id', $class->id)->get();
        foreach ($lessons as $lesson) {
            // Check if the lesson_id exists in Coordinator_room_lesson and set selected to true
            $lesson->selected = Coordinator_room_lesson::where('coordinator_id', $coordinator_id)
                ->where('class_id', $class->id)
                ->where('lesson_id', $lesson->id)
                ->where('year_id', $year->id)
                ->exists();
        }
        $class->lessons = $lessons;

        // Get all rooms for the class
        $rooms = Room::where('class_id', $class->id)
            ->where('year_id', $year->id)
            ->get();
        foreach ($rooms as $room) {
            // Check if the room_id exists in Coordinator_room_lesson and set selected to true
            $room->selected = Coordinator_room_lesson::where('coordinator_id', $coordinator_id)
                ->where('class_id', $class->id)
                ->where('room_id', $room->id)
                ->where('year_id', $year->id)
                ->exists();
        }
        $class->rooms = $rooms;
    }

    $classes = Classe::all();
    return view('admin.edit_coordinator_task', compact('classes', 'coordinator'));
}


//الفورم يلي بصفحة تعديل مهام المشرف لتعديل المهام
 public function update_coordinator_task(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        if ($request->has('class_id') != '1') {

            Coordinator_room_lesson::where('coordinator_id', $request->coordinator_id)
            ->where('year_id', $year->id)
            ->delete();
            return redirect()->back()->with('success', 'تم حذف مهام مشرف المدرسي');
        }
        Coordinator_room_lesson::where('coordinator_id', $request->coordinator_id)
        ->where('year_id', $year->id)
        ->delete();
        $coordinator = Coordinator::find($request->coordinator_id);
        for ($i = 0; $i < count($request->class_id); $i++) {
            if (isset($request->lesson_id))
                foreach ($request->lesson_id[$request->class_id[$i]] as $lesson_id) {
                    if (isset($request->room_id))
                        if (in_array(0, $request->room_id[$request->class_id[$i]])) {
                            $classes = Classe::with(['room:id,class_id'])->find($request->class_id[$i]);
                            $rooms_id = [];
                            foreach ($classes->room as $id) {
                                array_push($rooms_id, $id->id);
                            }
                            foreach ($rooms_id as $room_id) {
                                $item = new Coordinator_room_lesson;

                                $item->coordinator_id = $request->coordinator_id;
                                $item->class_id = $request->class_id[$i];
                                $item->room_id = $room_id;
                                $item->lesson_id = $lesson_id;
                                $item->year_id = $year->id;
                                $item->save();
                            }
                        } else {

                            foreach ($request->room_id[$request->class_id[$i]] as $room_id) {
                                $item = new Coordinator_room_lesson;

                                $item->coordinator_id = $request->coordinator_id;
                                $item->class_id = $request->class_id[$i];
                                $item->room_id = $room_id;
                                $item->lesson_id = $lesson_id;
                                $item->year_id = $year->id;
                                $item->save();
                            }
                        }
                    // *************************************************************
                }
        }
    return redirect()->back()->with('success','! تمت العملية بنجاح');
    }

//صفحة اضافة مهام للمشرف المدرسي
    public function set_coordinator_task($coordinator_id)
    {
        $coordinator = Coordinator::find($coordinator_id);
        $classes = Classe::all();
        return view('admin.set_coordinator_task', compact('coordinator', 'classes'));
    }

    public function users()
    {
        //type = 2 is admin
        // $users=User::where('type','2')->paginate(20);
        //  $count=count(User::where('type','2')->get());
        $roles = Role::all();
        return view('admin.users', compact('roles'));
    }
    public function user_store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:30',
            'phone' => 'required|max:20'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->mobile = $request->phone;
        $user->email = "a@app.com";
        $user->password = Hash::make(5);
        $user->view_password = $request->password;
        $user->type = '2';
        $user->role_id = $request->role_id;
        if ($request->hasFile('image')) {
            $user->img = $request->image->store('teachersimage', 'public');
        }
        $user->save();

        $email = str_replace(" ", "", $request->name_en) . rand(1, 1000) . "@aladham.com";
        if (strlen($request->name_en) > 2) {
            $namee = substr($request->name_en, 0, 3);
        } else {
            $namee = "aladham";
        }
        $password = $namee . "@" . rand(100000, 900000);
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->view_password = $password;
        $user->Description_ar = $request->Description_ar;
        $user->Description_en = $request->Description_en;
        if ($request->type) {
            $user->type1 = 1;
        } else {
            $user->type1 = null;
        }
        $user->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function user_update(Request $request)
    {




        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->mobile = $request->phone;
        if ($request->email) {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $request->user_id . ',id',
            ]);
            $user->email = $request->email;
        }

        $user->role_id = $request->role_id;
        $user->Description_ar = $request->Description_ar;
        $user->Description_en = $request->Description_en;
        if ($request->type) {
            $user->type1 = 1;
        } else {
            $user->type1 = null;
        }
        if ($request->password) {
            if (isset($request->password)) {

                $this->validate($request, [
                    'password' => 'same:password_confirmation',
                ], [
                    'password.required' => 'يرجى ادخال كلمة السر ',
                    'password.same' => 'كلمة السر غير متطابقة',
                ]);
                $user->password = Hash::make($request->password);
                $user->view_password = $request->password;

                if ($request->hasFile('image')) {

                    Storage::disk('public')->delete($user->image);

                    $user->img = $request->image->store('teachersimage', 'public');
                }
            }
        }


        $user->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function user_delete(Request $request)
    {
        User::find($request->user_id)->delete();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function classes_manager()
    {
        $year = Year::where('current_year', '1')->first();
        $classes = Classe::all();
        return view('admin.classes_manager', compact('classes', 'year'));
    }

    public function classes_view_exams()
    {
        $year = Year::where('current_year', '1')->first();
         
    
        $classes = Classe::paginate(paginate_num);
        $count = Classe::count();

        return view('admin.classes_view_exams', compact('classes', 'count', 'year'));
    }
      public function workschedule_class()
    {
        $year = Year::where('current_year', '1')->first();
        $classes = Classe::paginate(paginate_num);
        $count = Classe::count();

        return view('admin.workschedule_class', compact('classes', 'count', 'year'));
    }
    public function classroom_manager($id)
    {

        $year = Year::where('current_year', '1')->first();

        $rooms = Room::where('class_id', $id)->where('year_id', $year->id)->get();
        $id = $id;
        $years = Year::all();
        return view('admin.rooms_manager', compact('rooms', 'id', 'years'));
    }

    public function classroom_exams($id)
    {

       

       
        $year = Year::where('current_year', '1')->first();
        $rooms = Room::where('class_id', $id)->where('year_id', $year->id)->paginate(paginate_num);
        $count = Room::count();
        $id = $id;
        $years = Year::all();
        
        return view('admin.rooms_exams', compact('rooms', 'count', 'id', 'years'));
    }

     public function workschedule_room($id)
    {

        $year = Year::where('current_year', '1')->first();
        $rooms = Room::where('class_id', $id)->where('year_id', $year->id)->paginate(paginate_num);
        $count = Room::count();
        $id = $id;
        $years = Year::all();
        return view('admin.workschedule_room', compact('rooms', 'count', 'id', 'years'));
    }

    // public function room_quizes($room_id)
    // {
    //     // return $room_id ;
    //     $room = Room::findORFail($room_id);
    //     $classes = Classe::findOrFail($room->class_id);
    //     $class_id = $classes->id;
    //     $lessons = $classes->lessons;
    //     $rooms = $classes->room;
    //     $year = Year::where('current_year', '1')->first();
    //     $contents = Exams2::with('room', 'lesson')->where('room_id', $room_id)->where('term_id', 1)
    //         ->where('type', '2')->paginate(paginate_num);
    //     foreach ($contents as $content) {
    //         $content->start_date = Carbon::parse($content->start_date);
    //     }
    //     $count = Room::count();

    //     // $years=Year::all();
    //     return view('admin.quizes_of_room', compact('contents', 'count', 'rooms', 'room_id', 'lessons', 'class_id'));
    // }
    //تابع المذاكرات التقليدية
    // public function quize_store(Request $request)
    // {
    //     // return $request ;
    //     $rooms_id = $request->room_id;
    //     if (in_array(0, $request->room_id)) {
    //         $room = Room::findOrFail($request->my_room_id);
    //         $classes = Classe::with(['room:id,class_id'])->find($room->class_id);
    //         $rooms_id = [];
    //         foreach ($classes->room as $id) {
    //             array_push($rooms_id, $id->id);
    //         }
    //     }
    //     $exams = Exams2::where('id', '>', '0')->latest('id')->first();
    //     foreach ($rooms_id as $room_id) {

    //         $exam = new Exams2();
    //         $exam->user_id = auth()->id();
    //         $exam->class_id = $request->class_id;
    //         $exam->room_id = $room_id;
    //         $exam->lesson_id = $request->lesson_id;
    //         $exam->term_id = 1;
    //         $exam->name = $request->content_name;
    //         $exam->question_picker = $request->question_picker;
    //         $exam->required = $request->required_lectures;
    //         $exam->type = 2;
    //         $exam->start_date = $request->start_date;
    //         $exam->end_date = $request->end_date;
    //         $exam->mark = $request->mark;
    //         $exam->period = $request->period;
    //         $exam->groupe = isset($exams) ? $exams->groupe + 1 : 1;
    //         $exam->notes = $request->notes;
    //         if ($request->is_file == 1)
    //             $exam->is_file = 1;
    //         else
    //             $exam->is_file = 0;

    //         $exam->save();
    //         //    return $exam ;

    //         // $studens = Room::find($room_id)->student;

    //         // foreach ($studens as $student) {
    //         //     $item2 = new Exam_result2;
    //         //     $item2->class_id = $request->class_id;
    //         //     $item2->room_id = $room_id;
    //         //     $item2->exam_id = $exam->id;
    //         //     $item2->user_id = $student->id;
    //         //     $item2->lesson_id = $request->lesson_id;

    //         //     $item2->type ='2';
    //         //     $item2->save();
    //         // }
    //     }
    //     Session::flash('success', 'تم التخزين بنجاح');
    //     return redirect()->back();
    // }
    // public function quize_update(Request $request)
    // {

    //     $exam =  Exams2::findOrFail($request->quize_id);
    //     $exam->user_id = auth()->id();
    //     $exam->room_id = $request->room_id;
    //     $exam->lesson_id = $request->lesson_id;
    //     $exam->term_id = 1;
    //     $exam->name = $request->content_name;
    //     $exam->question_picker = $request->question_picker;
    //     $exam->required = $request->required_lectures;
    //     $exam->type = 2;
    //     $exam->start_date = $request->start_date;
    //     $exam->end_date = $request->end_date;
    //     $exam->mark = $request->mark;
    //     $exam->period = $request->period;
    //     $exam->notes = $request->notes;
    //     if ($request->is_file == 1)
    //         $exam->is_file = 1;
    //     else
    //         $exam->is_file = 0;
    //     $exam->save();
    //     Session::flash('success', 'تم التخزين بنجاح');
    //     return redirect()->back();
    // }
    // public function room_exams($room_id)
    // {
    //     // return $room_id ;
    //     $room = Room::findORFail($room_id);
    //     $classes = Classe::findOrFail($room->class_id);
    //     $class_id = $classes->id;
    //     $lessons = $classes->lessons;
    //     $rooms = $classes->room;
    //     $year = Year::where('current_year', '1')->first();
    //     $contents = Exams2::with('room', 'lesson')->where('room_id', $room_id)->where('term_id', 1)
    //         ->where('type', '1')->paginate(paginate_num);
    //     foreach ($contents as $content) {
    //         $content->start_date = Carbon::parse($content->start_date);
    //     }
    //     $count = Room::count();

    //     // $years=Year::all();
    //     return view('admin.exams_of_room', compact('contents', 'count', 'rooms', 'room_id', 'lessons', 'class_id'));
    // }
    // public function exam_store(Request $request)
    // {
    //     // return $request ;
    //     $rooms_id = $request->room_id;
    //     if (in_array(0, $request->room_id)) {
    //         $room = Room::findOrFail($request->my_room_id);
    //         $classes = Classe::with(['room:id,class_id'])->find($room->class_id);
    //         $rooms_id = [];
    //         foreach ($classes->room as $id) {
    //             array_push($rooms_id, $id->id);
    //         }
    //         // $rooms_id = $class->with('room')->get() ;

    //     }

    //     $exams = Exams2::where('id', '>', '0')->latest('id')->first();
    //     foreach ($rooms_id as $room_id) {

    //         $exam = new Exams2();
    //         $exam->user_id = auth()->id();
    //         $exam->class_id = $request->class_id;
    //         $exam->room_id = $room_id;
    //         $exam->lesson_id = $request->lesson_id;
    //         $exam->term_id = 1;
    //         $exam->name = $request->content_name;
    //         $exam->question_picker = $request->question_picker;
    //         $exam->required = $request->required_lectures;
    //         $exam->type = 1;

    //         $exam->start_date = $request->start_date;
    //         $exam->end_date = $request->end_date;
    //         $exam->groupe = isset($exams) ? $exams->groupe + 1 : 1;
    //         $exam->mark = $request->mark;
    //         $exam->period = $request->period;
    //         $exam->notes = $request->notes;
    //         if ($request->is_file == 1)
    //             $exam->is_file = 1;
    //         else
    //             $exam->is_file = 0;

    //         $exam->save();
    //         //    return $exam ;

    //         //   $studens = Room::find($room_id)->student;

    //         //   foreach ($studens as $student) {
    //         //         $item2 = new Exam_result2;
    //         //         $item2->class_id = $request->class_id;
    //         //         $item2->room_id = $room_id;
    //         //         $item2->exam_id = $exam->id;
    //         //         $item2->user_id = $student->id;
    //         //         $item2->lesson_id = $request->lesson_id;

    //         //         $item2->type ='1';
    //         //         $item2->save();
    //         //   }
    //     }
    //     Session::flash('success', 'تم التخزين بنجاح');
    //     return redirect()->back();
    // }

    //تابع المذاكرات التقليدية والمؤتمتة
    public function room_quizes($room_id){
        $year=Year::where('current_year','1')->first();
        $term = Term_year::where('current_term', '1')->first();
        $room = Room::findORFail($room_id) ;
        $classes = Classe::with(['room' => fn($q) => $q->where('year_id',$year->id)])->findOrFail($room->class_id) ;
        $class_id = $classes->id;
        $lessons = $classes->lessons ;

        $room_quize = [];
      
        $rooms = $classes->room;
       $contents=Exams2::with('room','lesson')->where('room_id',$room_id)->where('term_id',$term->id)
        ->where('type','2')->get();
        foreach ($contents as $content){
            $content->start_date = Carbon::parse( $content->start_date);
        }
        $count=Room::count();

        // $years=Year::all();
        return view('admin.quizes_of_room',compact('contents','count','rooms','room_id','lessons','class_id'));
    }

   public function quize_store(Request $request){
         $classes_roles = Classes_room_role_exam::where('role_id', auth()->user()->role_id)->get();
               $room_exam = [];
                  $room=[];
                foreach ($classes_roles as $item) {
                    if($item->roles =="quizes"){
                        $room_exam[] = $item->room_id;
                    }

                };
        $year=Year::where('current_year','1')->first();
        $term = Term_year::where('current_term', '1')->first();
        $rooms_id = $request->room_id ;
        if (in_array(0,$request->room_id)){
            $room = Room::findOrFail($request->my_room_id);

            $classes=Classe::with(['room'=>function($q1) use($year){
                                        $q1->where('rooms.year_id',$year->id) ;
                                        $q1->select('rooms.id','class_id');
                                    }])->find($room->class_id);

            $rooms_id = [] ;
            $clas=$classes->room->whereIn('id',$room_exam);
            foreach($clas as $id){
                array_push($rooms_id,$id->id) ;
            }

        }
        $exams = Exams2::where('id','>', '0')->latest('id')->first();
       foreach ( $rooms_id as $room_id) {

           $exam = new Exams2();
           $exam->user_id = auth()->id();
           $exam->class_id = $request->class_id;
           $exam->room_id = $room_id;
           $exam->lesson_id = $request->lesson_id;
           $exam->term_id = $term->id;
           $exam->name = $request->content_name;
           $exam->question_picker = $request->question_picker;
           $exam->required = $request->required_lectures;
           $exam->type = 2;
           $exam->start_date = $request->start_date;
           $exam->end_date = $request->end_date;
           $exam->mark = $request->mark;
           $exam->period = $request->period;
           $exam->groupe = isset($exams) ? $exams->groupe + 1 : 1;
           $exam->notes = $request->notes;
           if ($request->is_file == 1)
           $exam->is_file = 1;
           else
           $exam->is_file = 0;

           $exam->save();
        //    return $exam ;

            // $studens = Room::find($room_id)->student;

            // foreach ($studens as $student) {
            //     $item2 = new Exam_result2;
            //     $item2->class_id = $request->class_id;
            //     $item2->room_id = $room_id;
            //     $item2->exam_id = $exam->id;
            //     $item2->user_id = $student->id;
            //     $item2->lesson_id = $request->lesson_id;

            //     $item2->type ='2';
            //     $item2->save();
            // }
        }
        Session::flash('success','تم التخزين بنجاح');
        return redirect()->back();
    }
     public function quize_update(Request $request){
        $term = Term_year::where('current_term', '1')->first();

        $exam =  Exams2::findOrFail($request->quize_id);
        $exam->user_id = auth()->id();
        $exam->room_id = $request->room_id;
        $exam->lesson_id = $request->lesson_id;
        $exam->term_id = $term->id;
        $exam->name = $request->content_name;
        $exam->question_picker = $request->question_picker;
        $exam->required = $request->required_lectures;
        $exam->type = 2;
        $exam->start_date = $request->start_date;
        $exam->end_date = $request->end_date;
        $exam->mark = $request->mark;
        $exam->period = $request->period;
        $exam->notes = $request->notes;
        if ($request->is_file == 1)
        $exam->is_file = 1;
        else
        $exam->is_file = 0;
        $exam->save();
        Session::flash('success','تم التخزين بنجاح');
        return redirect()->back();
    }

   public function room_students_exam($room_id,$exam_id)
    {

    $year = Year::where('current_year', '1')->first();
    $students=Room_student::where('room_id',$room_id)->where('year_id',$year->id)->get();
    $a=[];
    foreach($students as $student){
        $a[]=$student->student_id;
    }
    if(in_array("student_hidden", Auth::user()->role->permissions)){
        $students=Student::whereIn('id',$a)->where('hidden',0)->orderBy('first_name')->paginate(paginate_num);
    }
    else{
        $students=Student::whereIn('id',$a)->orderBy('first_name')->paginate(paginate_num);
    }
    // return $students;
    $count= count($students);
    $room = Room::find($room_id);
    $room_name = $room->name ;
    $class_name = $room->classes->name ;
    $class_id = $room->classes->id ;
    return view('admin.room_students_exam',compact('room','students','count','class_id','room_name','class_name','exam_id'));
    }

    public function exam_reactivate(Request $request) {
        $exam_id =  $request->exam_id ;
        $content = Exams2::findOrFail($exam_id) ;
        $now=Carbon::now() ;
        if ($now > $content->end_date ){
            session()->flash('error', 'انتهى الوقت المسموح ');
            return redirect()->back();
        }
        Exam_result2::where('exam_id',$exam_id)->where('user_id',$request->student_id)
        ->update(['result' => null,'status' => '0','start_time' => null,'end_time' => null]);
        session()->flash('success', '  تم التفعيل بنجاح ');
        return redirect()->back();
    }

        //قسم الامتحانات التقليدية والمؤتمتة
    public function room_exams($room_id){
    
          $room_exam = [];
          $room=[];
    
        $year = Year::where('current_year','1')->first();
        $term = Term_year::where('current_term', '1')->first();
        $room = Room::findORFail($room_id) ;
        $classes = Classe::with(['room' => fn($q) => $q->where('year_id',$year->id)])->findOrFail($room->class_id) ;
        $class_id = $classes->id;
        $lessons = $classes->lessons ;

        $rooms = $classes->room ;
        $contents=Exams2::with('room','lesson')->where('room_id',$room_id)->where('term_id',$term->id)
        ->where('type','1')
        ->where(function($q) {
            $q->where('name', 'NOT LIKE', 'Dynamic_Section_%')
              ->orWhereNull('name');
        })->get();
        foreach ($contents as $content){
            $content->start_date = Carbon::parse( $content->start_date);
            }
            $count=Room::count();
            // $years=Year::all();
                return view('admin.exams_of_room',compact('contents','count','rooms','room_id','lessons','class_id'));
            }

   public function exam_filter_search(Request $request){
        // return $room_id ;
         $classes_roles = Classes_room_role_exam::where('role_id', auth()->user()->role_id)->get();
          $room_exam = [];
          $room=[];
        foreach ($classes_roles as $item) {
            if($item->roles =="exams"){
                $room_exam[] = $item->room_id;
            }
                 $room[] = $item->room_id;
        };
        $year = Year::where('current_year','1')->first();
        $term = Term_year::where('current_term', '1')->first();
        $room = Room::findORFail($request->room_id1) ;
        $classes = Classe::with(['room' => fn($q) => $q->where('year_id',$year->id)])->findOrFail($room->class_id) ;
        $class_id = $classes->id;
        $lessons = $classes->lessons ;
        $lesson_id=$request->lesson_id;
        $rooms = $classes->room->whereIn('id',$room_exam) ;
        $year=Year::where('current_year','1')->first();
      return  $contents=Exams2::with('room','lesson')->WhereHas('lesson' ,function($q) use ($lesson_id){
          if($lesson_id !=0){
            $q->where('id',$lesson_id);
          }

        })->where('room_id',$request->room_id1)->where('term_id',$term->id)
        ->where('type','1')
        ->where(function($q) {
            $q->where('name', 'NOT LIKE', 'Dynamic_Section_%')
              ->orWhereNull('name');
        })->get();
        // foreach ($contents as $content){
        //     $content->start_date = Carbon::parse( $content->start_date);
        //     }
        //     $count=Room::count();
        //     // $years=Year::all();
        //         return view('admin.exams_of_room',compact('contents','count','rooms','room_id','lessons','class_id'));
            }
             public function quize_filter_search(Request $request){
        // return $room_id ;
         $classes_roles = Classes_room_role_exam::where('role_id', auth()->user()->role_id)->get();
          $room_exam = [];
          $room=[];
        foreach ($classes_roles as $item) {
            if($item->roles =="exams"){
                $room_exam[] = $item->room_id;
            }
                 $room[] = $item->room_id;
        };
        $year = Year::where('current_year','1')->first();
        $term = Term_year::where('current_term', '1')->first();
        $room = Room::findORFail($request->room_id1) ;
        $classes = Classe::with(['room' => fn($q) => $q->where('year_id',$year->id)])->findOrFail($room->class_id) ;
        $class_id = $classes->id;
        $lessons = $classes->lessons ;
        $lesson_id=$request->lesson_id;
        $rooms = $classes->room->whereIn('id',$room_exam) ;
        $year=Year::where('current_year','1')->first();
      return  $contents=Exams2::with('room','lesson')->WhereHas('lesson' ,function($q) use ($lesson_id){
          if($lesson_id !=0){
            $q->where('id',$lesson_id);
          }

        })->where('room_id',$request->room_id1)->where('term_id',$term->id)
        ->where('type','2')->get();
        // foreach ($contents as $content){
        //     $content->start_date = Carbon::parse( $content->start_date);
        //     }
        //     $count=Room::count();
        //     // $years=Year::all();
        //         return view('admin.exams_of_room',compact('contents','count','rooms','room_id','lessons','class_id'));
            }
        public function exam_store(Request $request) {
            $year = Year::where('current_year','1')->first();
            $term = Term_year::where('current_term', '1')->first();
            $rooms_id = $request->room_id ;
             $classes_roles = Classes_room_role_exam::where('role_id', auth()->user()->role_id)->get();
               $room_exam = [];
                  $room=[];
                foreach ($classes_roles as $item) {
                    if($item->roles =="exams"){
                        $room_exam[] = $item->room_id;
                    }

                };
            if (in_array(0,$request->room_id)){
                $room = Room::findOrFail($request->my_room_id);
                $classes=Classe::with(['room'=>function($q1) use($year){
                $q1->where('rooms.year_id',$year->id) ;
                $q1->select('rooms.id','class_id');
                }])->find($room->class_id);
                $rooms_id = [] ;
                $clas=$classes->room->whereIn('id',$room_exam);
                foreach($clas as $id){
                    array_push($rooms_id,$id->id) ;
                    }
                    // $rooms_id = $class->with('room')->get() ;
                    }
                $exams = Exams2::where('id','>', '0')->latest('id')->first();
                foreach ( $rooms_id as $room_id) {
                    $exam = new Exams2();
                    $exam->user_id = auth()->id();
                    $exam->class_id = $request->class_id;
                    $exam->room_id = $room_id;
                    $exam->lesson_id = $request->lesson_id;
                    $exam->term_id = $term->id;
                    $exam->name = $request->content_name;
                    $exam->question_picker = $request->question_picker;
                    $exam->required = $request->required_lectures;
                    $exam->type = 1;
                    $exam->start_date = $request->start_date;
                    $exam->end_date = $request->end_date;
                    $exam->groupe = isset($exams) ? $exams->groupe + 1 : 1;
                    $exam->mark = $request->mark;
                    $exam->period = $request->period;
                    $exam->notes = $request->notes;
                    if ($request->is_file == 1)
                    $exam->is_file = 1;
                    else
                    $exam->is_file = 0;
                    $exam->save();
                    //    return $exam ;
                    //   $studens = Room::find($room_id)->student;
                    //   foreach ($studens as $student) {
                    //         $item2 = new Exam_result2;
                    //         $item2->class_id = $request->class_id;
                    //         $item2->room_id = $room_id;
                    //         $item2->exam_id = $exam->id;
                    //         $item2->user_id = $student->id;
                    //         $item2->lesson_id = $request->lesson_id;
                    //         $item2->type ='1';
                    //         $item2->save();
                    //   }
                }
                    Session::flash('success','تم التخزين بنجاح');
                    return redirect()->back();
                }

        public function exam_update(Request $request){
                $term = Term_year::where('current_term', '1')->first();
                $exam =  Exams2::findOrFail($request->exam_id);
                $exam->user_id = auth()->id();
                $exam->room_id = $request->room_id;
                $exam->lesson_id = $request->lesson_id;
                $exam->term_id = $term->id;
                $exam->name = $request->content_name;
                $exam->question_picker = $request->question_picker;
                $exam->required = $request->required_lectures;
                $exam->type = 1;
                $exam->start_date = $request->start_date;
                $exam->end_date = $request->end_date;
                $exam->mark = $request->mark;
                $exam->period = $request->period;
                $exam->notes = $request->notes;
                if ($request->is_file == 1)
                $exam->is_file = 1;
                else
                $exam->is_file = 0;
                $exam->save();
                Session::flash('success','تم التخزين بنجاح');
                return redirect()->back();
            }

            public function exam_quize_delete(Request $request){

        $formed_code = Auth::User()->view_password;
                if ($formed_code == $request->delete_code ){
                $exam =  Exams2::findOrFail($request->content_id);
                Exam_result2::where('exam_id',$request->content_id)->delete() ;
                if ($exam->is_file == 1){
                if ($exam->file != null) {
                   Storage::disk('public')->delete($exam->file);
                }
                    $exam_files =  Exam_file::where('exam_id',$request->content_id)->get() ;
                        foreach($exam_files as $exam_file){
                                if ($exam_file->file != null) {
                                   Storage::disk('public')->delete($exam->file);
                                }
                                $exam_file->delete() ;
                        }
                    }
                    $exam->delete() ;
                    Session::flash('success','تم التخزين بنجاح');
                    return redirect()->back();
                    }else {
                        return redirect()->back()->with('error','! تأكد من البيانات المدخلة  ]');
                }
            }


        public function class_delete_fun($class_id)
        {
            $to_delete11 =   Coordinator_class_lesson::where('class_id', $class_id)->get();
            foreach ($to_delete11 as $x) {
            $x->delete();
        }
         $to_delete15 =   Basic_stages_class::where('class_id', $class_id)->get();
            foreach ($to_delete15 as $x) {
            $x->delete();
        }
        $to_delete2 =   Exam_result::where('class_id', $class_id)->get();
        foreach ($to_delete2 as $x) {
            $x->delete();
        }
        $to_delete3 =   Lecture::where('class_id', $class_id)->get();
        foreach ($to_delete3 as $x) {
            $x->delete();
        }
        $to_delete12 =   Planification_trimestrielle::where('class_id', $class_id)->get();
        foreach ($to_delete12 as $x) {
            $x->delete();
        }
        $to_delete43 =   Prepare::where('class_id', $class_id)->get();
        foreach ($to_delete43 as $x) {
            $x->delete();
        }
        $to_delete5 =   Question::where('class_id', $class_id)->get();
        foreach ($to_delete5 as $x) {
            // if($x->option){
            //    $x->option->delete();
            $x->delete();
        }
        $to_delete7 =   Section::where('class_id', $class_id)->get();
        foreach ($to_delete7 as $x) {
            $x->delete();
        }
        $to_delete10 =   Supervisor_class_lesson::where('class_id', $class_id)->get();
        foreach ($to_delete10 as $x) {
            $x->delete();
        }
        $to_delete101 =   Supervisor_teacher_item::where('class_id', $class_id)->get();
        foreach ($to_delete101 as $x) {
            $x->delete();
        }
        $to_delete91 =   Teacher_event::where('class_id', $class_id)->get();
        foreach ($to_delete91 as $x) {
            $x->delete();
        }
        $to_delete10 =   Teacher_room_lesson::where('class_id', $class_id)->get();
        foreach ($to_delete10 as $x) {
            $x->delete();
        }
        $to_delete12 =   Unit_analysis::where('class_id', $class_id)->get();
        foreach ($to_delete12 as $x) {
            $x->delete();
        }

        // delete related rooms
        $class = Classe::findOrFail($class_id);
        $rooms = $class->room;

        foreach ($rooms as $room) {
            $this->room_delete_fun($room->id);
        }
        // delete related lessons
        $lessons = $class->lessons;
        foreach ($lessons as $lesson) {
            $this->lesson_delete_fun($lesson->id);
        }
        if (isset($class)) {
            $class->delete();
        }
    }

    public function room_delete_fun($room_id)
    {

        $to_delete1 =   Exams2::where('room_id', $room_id)->get();
        foreach ($to_delete1 as $x) {
            $x->delete();
        }
        $to_delete2 =   Exam_result::where('room_id', $room_id)->get();
        foreach ($to_delete2 as $x) {
            $x->delete();
        }
        $to_delete3 =   Lecture::where('room_id', $room_id)->get();
        foreach ($to_delete3 as $x) {
            $x->delete();
        }
        $to_delete4 =   lesson_room_teacher_lecture_time::where('room_id', $room_id)->get();
        foreach ($to_delete4 as $x) {
            $x->delete();
        }
        $to_delete41 =   Lesson_teacher_room_term_exam::where('room_id', $room_id)->get();
        foreach ($to_delete41 as $x) {
            $x->delete();
        }


        $to_delete43 =   Prepare::where('room_id', $room_id)->get();
        foreach ($to_delete43 as $x) {
            $x->delete();
        }

        $to_delete6 =  Room_lesson_exam::where('room_id', $room_id)->get();
        foreach ($to_delete6 as $x) {
            $x->delete();
        }

        $to_delete7 =   Section::where('room_id', $room_id)->get();
        foreach ($to_delete7 as $x) {
            $x->delete();
        }

        $to_delete8 =   Students_mark::where('room_id', $room_id)->get();
        foreach ($to_delete8 as $x) {
            $x->delete();
        }
        $to_delete9 =   Student_lesson_teacher_room_term_exam::where('room_id', $room_id)->get();
        foreach ($to_delete9 as $x) {
            $x->delete();
        }
        $to_delete91 =   Teacher_event::where('room_id', $room_id)->get();
        foreach ($to_delete91 as $x) {
            $x->delete();
        }

        $to_delete10 =   Teacher_room_lesson::where('room_id', $room_id)->get();
        foreach ($to_delete10 as $x) {
            $x->delete();
        }


            $to_delete11 =   Classes_Rooms_Roles::where('room_id', $room_id)->get();
        foreach ($to_delete11 as $x) {
            $x->delete();
        }



        $room = Room::findOrFail($room_id);
        $students = $room->student;
     if(count($students)!=0){

         foreach ($students as $student) {
            $this->student_delete_fun($student->id);
         }
        }
        if (isset($room)) {
            $room->delete();
        }
    }

    public function student_delete_fun($student_id)
    {
        $user = User::where('student_id', $student_id)->first();
        if (count(Students_mark::where('student_id', $student_id)->get()) > 0) {
            Students_mark::where('student_id', $student_id)->delete();
        }
        if (count(Student_lesson_teacher_room_term_exam::where('student_id', $student_id)->get()) > 0) {
            Student_lesson_teacher_room_term_exam::where('student_id', $student_id)->delete();
        }

        if (count(Room_student::where('student_id', $student_id)->get()) > 0) {
            Room_student::where('student_id', $student_id)->delete();
        }
        $user->delete();
        $student = Student::find($student_id);
        $messgaes = Message::where('student_id', $student_id) -> delete();

        $student_detail =  Student_detail::where('student_id', $student_id)->first();

        if ($student_detail->certification_nine != null) {
            unlink('storage/' . $student_detail->certification_nine);
        }
        if ($student_detail->certification != null) {
            unlink('storage/' . $student_detail->certification);
        }
        if ($student_detail->study_sequence != null) {
            unlink('storage/' . $student_detail->study_sequence);
        }
        if ($student_detail->father_page != null) {
            unlink('storage/' . $student_detail->father_page);
        }
        if ($student_detail->mather_page != null) {
            unlink('storage/' . $student_detail->mather_page);
        }
        if ($student_detail->family_book != null) {
            unlink('storage/' . $student_detail->family_book);
        }
        if ($student_detail->passport != null) {
            unlink('storage/' . $student_detail->passport);
        }
        if ($student_detail->fourth_image != null) {
            unlink('storage/' . $student_detail->fourth_image);
        }
        if ($student_detail->father_image != null) {
            unlink('storage/' . $student_detail->father_image);
        }
        if ($student_detail->mother_image != null) {
            unlink('storage/' . $student_detail->mother_image);
        }
        if ($student_detail->personal_image != null) {
            unlink('storage/' . $student_detail->personal_image);
        }
         ////  المكافأت والعقوبات
        $rewards_and_sanction_student=Rewad_and_sanction_student::where('student_id',$student_id)->get();
        foreach($rewards_and_sanction_student as $item){

            $item->delete();
        }

        $student_detail->delete();
        $student->delete();
    }


    public function lesson_delete_fun($lesson_id)
    {

        $to_delete1 =   Coordinator_class_lesson::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete1 as $x) {
            $x->delete();
        }
        //  $to_delete2 =   Exams::where('lesson_id',$lesson_id)->get();
        //
        //  foreach($to_delete2 as $x){
        //     $x->delete();
        //  }
        $to_delete21 =   Exams2::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete21 as $x) {
            $x->delete();
        }
        $to_delete3 =   Exam_result::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete3 as $x) {
            $x->delete();
        }

        $to_delete31 =   Lecture::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete31 as $x) {
            $x->delete();
        }
        $to_delete4 =   Lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete4 as $x) {
            $x->delete();
        }
        $to_delete41 =   Lesson_room_teacher_lecture_time::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete41 as $x) {
            $x->delete();
        }
        $to_delete42 =   Planification_trimestrielle::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete42 as $x) {
            $x->delete();
        }
        $to_delete43 =   Prepare::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete43 as $x) {
            $x->delete();
        }
        $to_delete5 =   Question::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete5 as $x) {
            // if($x->option){
            //    $x->option->delete();
            $x->delete();
        }
        $to_delete6 =   Room_lesson_exam::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete6 as $x) {
            $x->delete();
        }
        $to_delete7 =   Section::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete7 as $x) {
            $x->delete();
        }
        $to_delete7 =   Section::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete7 as $x) {
            $x->delete();
        }
        //  $to_delete8 =   Students_mark::where('lesson_id',$lesson_id)->get();
        //  foreach($to_delete8 as $x){
        //     $x->delete();
        //  }
        // }
        $to_delete9 =   Student_lesson_teacher_room_term_exam::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete9 as $x) {
            $x->delete();
        }
        $to_delete10 =   Supervisor_class_lesson::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete10 as $x) {
            $x->delete();
        }
        $to_delete101 =   Supervisor_teacher_item::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete101 as $x) {
            $x->delete();
        }
        $to_delete11 =   Teacher_room_lesson::where('lesson_id', $lesson_id)->get();
        foreach ($to_delete11 as $x) {
            $x->delete();
        }

        Lesson::findOrFail($lesson_id)->delete();
    }
    public function studentimport(Request $request)
    {
        // if ($request->hasFile('file')) {

        //     $file = $request->file;
        // }
        $file = $request->file('file')->store('files');

        if($request->file->extension()){

        }

        // $ = Input::file('file');
        set_time_limit(100000);
        ini_set('memory_limit', '-1');
        if($request->file->extension() !='xlsx'){
         return redirect()->back()->with('error', 'يرجى ادخال ملف اكسل  !');
       }
       try{
          Excel::import(new StudentImport(), $file);
           return redirect()->back()->with('success', '!Student imported successfully!');
       }
       catch (\Exception $e) {
            return redirect()->back()->with('error', ' يرجى ادخال معلومات  الاكسل بشكل صحيح  !');

        }


    }
    public function teacherimport(Request $request)
    {
        // if ($request->hasFile('file')) {

        //     $file = $request->file;
        // }
        $file = $request->file('file')->store('files');
        // $ = Input::file('file');
        set_time_limit(10000);
        ini_set('memory_limit', '-1');
       if($request->file->extension() !='xlsx'){
         return redirect()->back()->with('error', 'يرجى ادخال ملف اكسل  !');
       }
       try{
          Excel::import(new TeacherImport(), $file);
           return redirect()->back()->with('success', 'Teachers imported successfully!');
       }
       catch (\Exception $e) {
            return redirect()->back()->with('error', ' يرجى ادخال معلومات  الاكسل بشكل صحيح  !');

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


    public function student_contact()
    {


        $classes_rooms_roles = Classes_Rooms_Roles::where('role_id', auth()->user()->role_id)->get();
        $class = [];
        foreach ($classes_rooms_roles as $item) {
            $class[] = $item->class_id;
        };
        $room = [];
        foreach ($classes_rooms_roles as $item) {
            $room[] = $item->room_id;
        };


        // $student_contact = Message::whereHas('student.room.classes', function ($query) use ($class) {
        //     $query->whereIn('id', $class);
        // })->whereHas('student.room', function ($query) use ($room) {
        //     $query->whereIn('room_id', $room);
        // })->where('admin_id', '!=', null)->where('type', 1)->paginate(20);

        // $count = Message::where('admin_id', '!=', null)->where('type', 1)->count();
         if(in_array("student_hidden", Auth::user()->role->permissions)){
              $year = Year::where('current_year', '1')->first();
               $student = Student::withCount('message_admin')
            ->with(['message_admin1' => function ($q) {
                $q->where('admin_id', '!=', null)
                    ->orderBy('created_at', 'desc');
            }])->where('hidden',0)
            ->with('room.classes')
            ->whereHas('room', function ($q) use ($room) {
                $q->whereIn('room_id', $room);
            })->with(['room' => function ($q1)  {
            $year = Year::where('current_year', '1')->first();

                $q1->where('room_student.year_id', $year->id);
        }])
             ->join('messages', 'messages.student_id', '=', 'students.id')
            ->where('messages.admin_id', '!=', null)
            ->orderByDesc('messages.created_at')
            ->paginate(50);
         }
         else{
              $student = Student::withCount('message_admin')
            ->with(['message_admin1' => function ($q) {
                $q->where('admin_id', '!=', null)
                    ->orderBy('created_at', 'desc');
            }])
            ->with('room.classes')
            ->whereHas('room', function ($q) use ($room) {
                $q->whereIn('room_id', $room);
            })->with(['room' => function ($q1)  {
            $year = Year::where('current_year', '1')->first();

                $q1->where('room_student.year_id', $year->id);
        }])
             ->join('messages', 'messages.student_id', '=', 'students.id')
            ->where('messages.admin_id', '!=', null)
            ->orderByDesc('messages.created_at')
            ->paginate(50);
         }

        $classes = Classe::whereIn('id', $class)->get();
        $year2 = Year::where('current_year', '1')->first();
        return view('admin.student_contact', compact('student', 'year2', 'classes'));
    }

    public function getstudents_contact(Request $request)
    {
        $st = [];


        $classes_rooms_roles = Classes_Rooms_Roles::where('role_id', auth()->user()->role_id)->get();
        $class = [];
        foreach ($classes_rooms_roles as $item) {
            $class[] = $item->class_id;
        };
        $room = [];
        foreach ($classes_rooms_roles as $item) {
            $room[] = $item->room_id;
        };
        if(in_array("student_hidden", Auth::user()->role->permissions)){
            if($request->room !=""){
              return Student::withCount('message_admin')->where('hidden',0)->with('room.classes')->whereHas('room', function ($q) use ($request) {
            $q->where('room_id', $request->room);
       })->get();
         }
         else{
               return Student::withCount('message_admin')->whereHas('room.classes' , function ($q) use($request) {
            $q->where('classes.id',$request->class);
        })->where('hidden',0)->with('room.classes')->whereHas('room', function ($q) use ($room) {
        $q->whereIn('room_id', $room);
       })->get();
         }
        }
        else{
            if($request->room !=""){
              return Student::withCount('message_admin')->with('room.classes')->whereHas('room', function ($q) use ($request) {
            $q->where('room_id', $request->room);
       })->get();
         }
         else{
               return Student::withCount('message_admin')->whereHas('room.classes' , function ($q) use($request) {
            $q->where('classes.id',$request->class);
        })->with('room.classes')->whereHas('room', function ($q) use ($room) {
        $q->whereIn('room_id', $room);
       })->get();
         }
        }



    }
     public function getstudents_contact_date(Request $request)
    {
        $st = [];
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $class_filter = $request->class;
        $room_filter = $request->room;

        $classes_rooms_roles = Classes_Rooms_Roles::where('role_id', auth()->user()->role_id)->get();
        $class = [];
        foreach ($classes_rooms_roles as $item) {
            $class[] = $item->class_id;
        };
        $room = [];
        foreach ($classes_rooms_roles as $item) {
            $room[] = $item->room_id;
        };

   if(in_array("student_hidden", Auth::user()->role->permissions)){
        return    $students = Student::withCount('message_admin')
  ->where('hidden',0)->with('room.classes')

    ->WhereHas('room.classes', function($q) use ($class_filter,$room_filter,$room) {
                 $year = Year::where('current_year','1')->first();
                 if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                     $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
                 }else if($class_filter != "" && $class_filter != null){
                     $q->where('classes.id', $class_filter)->where('room_student.year_id',$year->id)->whereIn('room_id', $room);
                 }
                 else{
                     $q->whereIn('room_id', $room);
                 }
             })

    ->join('messages', 'messages.student_id', '=', 'students.id')
    ->where('messages.admin_id', '!=', null)
     ->whereDate('messages.created_at', '>=', $start_date)
    ->whereDate('messages.created_at', '<=', $end_date)
    ->orderByDesc('messages.created_at')
    ->get();
   }
   else{
        return    $students = Student::withCount('message_admin')
   ->where('hidden',0) ->with('room.classes')
     ->WhereHas('room.classes', function($q) use ($class_filter,$room_filter,$room) {
                 $year = Year::where('current_year','1')->first();
                 if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                     $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
                 }else if($class_filter != "" && $class_filter != null){
                     $q->where('classes.id', $class_filter)->where('room_student.year_id',$year->id)->whereIn('room_id', $room);
                 }
                 else{
                     $q->whereIn('room_id', $room);
                 }
             })
    ->join('messages', 'messages.student_id', '=', 'students.id')
    ->where('messages.admin_id', '!=', null)
     ->whereDate('messages.created_at', '>=', $start_date)
    ->whereDate('messages.created_at', '<=', $end_date)
    ->orderByDesc('messages.created_at')
    ->get();
   }





    }


    public function admin_contact()
    {
        $classes_rooms_roles = Classes_Rooms_Roles::where('role_id', auth()->user()->role_id)->get();
        $class = [];
        foreach ($classes_rooms_roles as $item) {
            $class[] = $item->class_id;
        };
        $room = [];
        foreach ($classes_rooms_roles as $item) {
            $room[] = $item->room_id;
        };
        $student_contact = Message::where('admin_id', '!=', null)->where('type', 0)->paginate(20);
        $count = Message::where('admin_id', '!=', null)->where('type', 0)->count();
        $classes = Classe::whereIn('id', $class)->get();
        $year2 = Year::where('current_year', '1')->first();
        return view('admin.admin_contact', compact('student_contact', 'year2', 'count', 'classes'));
    }

    public function getstudents_contact_admin(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $class_filter = $request->class_id;
        $room_filter = $request->room_id;
        $student_id = $request->student_id;
        $search_bar = $request->barcode_pos_check;

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }
        $st = [];
        $classes_rooms_roles = Classes_Rooms_Roles::where('role_id', auth()->user()->role_id)->get();
        $class = [];
        foreach ($classes_rooms_roles as $item) {
            $class[] = $item->class_id;
        };
        $room = [];
        foreach ($classes_rooms_roles as $item) {
            $room[] = $item->room_id;
        };

        $totalRecords = Message::whereHas('student.room.classes', function ($query) use ($class) {
            $query->whereIn('id', $class);
        })->whereHas('student.room', function ($query) use ($room) {
            $query->whereIn('room_id', $room);
        })->where('admin_id', '!=', null)->where('type', 0)->orderBy("id", 'desc')->count();
        $message = Message::whereHas('student.room.classes', function ($query) use ($class) {
            $query->whereIn('id', $class);
        })->whereHas('student.room', function ($query) use ($room) {
            $query->whereIn('room_id', $room);
        })->where('admin_id', '!=', null)->where('type', 0)->orderBy("id", 'desc')->get();
        foreach ($message as $item) {
            $st[] = $item->student_id;
        }
         if(in_array("student_hidden", Auth::user()->role->permissions)){
              $totalRecordswithFilter = Message::with(['student' => function ($q) use ($result_search, $student_id) {

                    if ($student_id != "" && $student_id != null) {
                        $q->where('first_name', "like", "%" . $result_search . "%")->where('id', $student_id)->where('hidden',0)
                            ->orwhere('last_name', "like", "%" . $result_search . "%")->where('id', $student_id)->where('hidden',0);
                    } else {
                        $q->where('first_name', "like", "%" . $result_search . "%")->where('hidden',0)
                            ->orwhere('last_name', "like", "%" . $result_search . "%")->where('hidden',0);
                    }
                }])->whereHas('student.room.classes', function ($query) use ($class) {
                    $query->whereIn('id', $class);
                })->whereHas('student.room', function ($query) use ($room) {
                    $query->whereIn('room_id', $room);
                })->WhereHas('student', function ($q) use ($result_search, $student_id) {
                    if ($student_id != "" && $student_id != null) {
                        $q->where('first_name', "like", "%" . $result_search . "%")->where('id', $student_id)->where('hidden',0)
                            ->orwhere('last_name', "like", "%" . $result_search . "%")->where('id', $student_id)->where('hidden',0);
                    } else {
                        $q->where('first_name', "like", "%" . $result_search . "%")->where('hidden',0)
                            ->orwhere('last_name', "like", "%" . $result_search . "%")->where('hidden',0);
                    }
                })->with('student.room.classes')

                    ->WhereHas('student.room.classes', function ($q) use ($class_filter, $room_filter) {
                        $year = Year::where('current_year', '1')->first();
                        if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                            $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
                        } else if ($class_filter != "" && $class_filter != null) {
                            $q->where('classes.id', $class_filter);
                        }
                    })

                    ->with('student.room.classes')->with(['student.room' => function ($q1) use ($room_filter) {
                        $year = Year::where('current_year', '1')->first();
                        if ($room_filter != "" && $room_filter != null) {
                            $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
                        } else {
                            $q1->where('room_student.year_id', $year->id);
                        }
                    }])->where('admin_id', '!=', null)->where('type', 0)->orderBy("id", 'desc')->count();
                $records = Message::with(['student' => function ($q) use ($result_search, $student_id) {

                    if ($student_id != "" && $student_id != null) {
                        $q->where('first_name', "like", "%" . $result_search . "%")->where('id', $student_id)->where('hidden',0)
                            ->orwhere('last_name', "like", "%" . $result_search . "%")->where('id', $student_id)->where('hidden',0);
                    } else {
                        $q->where('first_name', "like", "%" . $result_search . "%")->where('hidden',0)
                            ->orwhere('last_name', "like", "%" . $result_search . "%")->where('hidden',0);
                    }
                }])->with('student.room.classes')->whereHas('student.room.classes', function ($query) use ($class) {
                        $query->whereIn('id', $class);
                    })->whereHas('student.room', function ($query) use ($room) {
                        $query->whereIn('room_id', $room);
                    })
                    ->WhereHas('student.room.classes', function ($q) use ($class_filter, $room_filter) {
                        $year = Year::where('current_year', '1')->first();
                        if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                            $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
                        } else if ($class_filter != "" && $class_filter != null) {
                            $q->where('classes.id', $class_filter);
                        }
                    })->with(['student' => function ($q) use ($result_search) {


                        $q->where('first_name', "like", "%" . $result_search . "%")->where('hidden',0);
                    }])->WhereHas('student', function ($q) use ($result_search, $student_id) {
                        if ($student_id != "" && $student_id != null) {
                            $q->where('first_name', "like", "%" . $result_search . "%")->where('id', $student_id)->where('hidden',0)
                                ->orwhere('last_name', "like", "%" . $result_search . "%")->where('id', $student_id)->where('hidden',0);
                        } else {
                            $q->where('first_name', "like", "%" . $result_search . "%")->where('hidden',0)
                                ->orwhere('last_name', "like", "%" . $result_search . "%")->where('hidden',0);
                        }
                    })->where('admin_id', '!=', null)->where('type', 0)->orderBy("id", 'desc')->with('student.room.classes')->with(['student.room' => function ($q1) use ($room_filter) {
                        $year = Year::where('current_year', '1')->first();
                        if ($room_filter != "" && $room_filter != null) {
                            $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
                        } else {
                            $q1->where('room_student.year_id', $year->id);
                        }
                    }])->skip($start)
                    ->take($rowperpage)->orderBy('id', 'desc')->get();
         }
           else{
               $totalRecordswithFilter = Message::with(['student' => function ($q) use ($result_search, $student_id) {

                    if ($student_id != "" && $student_id != null) {
                        $q->where('first_name', "like", "%" . $result_search . "%")->where('id', $student_id)
                            ->orwhere('last_name', "like", "%" . $result_search . "%")->where('id', $student_id);
                    } else {
                        $q->where('first_name', "like", "%" . $result_search . "%")
                            ->orwhere('last_name', "like", "%" . $result_search . "%");
                    }
                }])->whereHas('student.room.classes', function ($query) use ($class) {
                    $query->whereIn('id', $class);
                })->whereHas('student.room', function ($query) use ($room) {
                    $query->whereIn('room_id', $room);
                })->WhereHas('student', function ($q) use ($result_search, $student_id) {
                    if ($student_id != "" && $student_id != null) {
                        $q->where('first_name', "like", "%" . $result_search . "%")->where('id', $student_id)
                            ->orwhere('last_name', "like", "%" . $result_search . "%")->where('id', $student_id);
                    } else {
                        $q->where('first_name', "like", "%" . $result_search . "%")
                            ->orwhere('last_name', "like", "%" . $result_search . "%");
                    }
                })->with('student.room.classes')

                    ->WhereHas('student.room.classes', function ($q) use ($class_filter, $room_filter) {
                        $year = Year::where('current_year', '1')->first();
                        if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                            $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
                        } else if ($class_filter != "" && $class_filter != null) {
                            $q->where('classes.id', $class_filter);
                        }
                    })

                    ->with('student.room.classes')->with(['student.room' => function ($q1) use ($room_filter) {
                        $year = Year::where('current_year', '1')->first();
                        if ($room_filter != "" && $room_filter != null) {
                            $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
                        } else {
                            $q1->where('room_student.year_id', $year->id);
                        }
                    }])->where('admin_id', '!=', null)->where('type', 0)->orderBy("id", 'desc')->count();
                $records = Message::with(['student' => function ($q) use ($result_search, $student_id) {

                    if ($student_id != "" && $student_id != null) {
                        $q->where('first_name', "like", "%" . $result_search . "%")->where('id', $student_id)
                            ->orwhere('last_name', "like", "%" . $result_search . "%")->where('id', $student_id);
                    } else {
                        $q->where('first_name', "like", "%" . $result_search . "%")
                            ->orwhere('last_name', "like", "%" . $result_search . "%");
                    }
                }])->with('student.room.classes')->whereHas('student.room.classes', function ($query) use ($class) {
                        $query->whereIn('id', $class);
                    })->whereHas('student.room', function ($query) use ($room) {
                        $query->whereIn('room_id', $room);
                    })
                    ->WhereHas('student.room.classes', function ($q) use ($class_filter, $room_filter) {
                        $year = Year::where('current_year', '1')->first();
                        if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
                            $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
                        } else if ($class_filter != "" && $class_filter != null) {
                            $q->where('classes.id', $class_filter);
                        }
                    })->with(['student' => function ($q) use ($result_search) {


                        $q->where('first_name', "like", "%" . $result_search . "%");
                    }])->WhereHas('student', function ($q) use ($result_search, $student_id) {
                        if ($student_id != "" && $student_id != null) {
                            $q->where('first_name', "like", "%" . $result_search . "%")->where('id', $student_id)
                                ->orwhere('last_name', "like", "%" . $result_search . "%")->where('id', $student_id);
                        } else {
                            $q->where('first_name', "like", "%" . $result_search . "%")
                                ->orwhere('last_name', "like", "%" . $result_search . "%");
                        }
                    })->where('admin_id', '!=', null)->where('type', 0)->orderBy("id", 'desc')->with('student.room.classes')->with(['student.room' => function ($q1) use ($room_filter) {
                        $year = Year::where('current_year', '1')->first();
                        if ($room_filter != "" && $room_filter != null) {
                            $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
                        } else {
                            $q1->where('room_student.year_id', $year->id);
                        }
                    }])->skip($start)
                    ->take($rowperpage)->orderBy('id', 'desc')->get();
           }



        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "first_name" => $record->student->first_name,
                "last_name" => $record->student->last_name,
                "room" => $record->student->room,
                "id" => $record->id,
                "created_at" => Carbon::parse($record->created_at)->toDateTimeString(),
                "message" => $record->message,

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
   public function classes_rooms2_student($room_id, $year_id)
    {

        $year = Year::where('current_year', '1')->first();
        $room = Room::find($room_id);
        if(in_array("student_hidden", Auth::user()->role->permissions)){
            $students = $room->student->where('hidden',0);
        }
        else{
            $students = $room->student;
        }



        return $students;
    }
    public function classes_rooms22_student2(Request $request, $year_id)
    {
        $students = [];
        $year = Year::where('current_year', '1')->first();
        $room = Room::whereIn('id', $request->class_id)->where('year_id', $year->id)->get();
         if(in_array("student_hidden", Auth::user()->role->permissions)){
             foreach ($room as $item) {
            $students[] = $item->student->where('hidden',0);
        }

         }
   else{
       foreach ($room as $item) {
            $students[] = $item->student->where('hidden',0);
        }

   }

        return $students;
    }

    public function send_message_admin(Request $request)
    {
        $classes_rooms_roles = Classes_Rooms_Roles::where('role_id', auth()->user()->role_id)->get();


        $room1 = [];
        foreach ($classes_rooms_roles as $item) {
            $room1[] = $item->room_id;
        };
        $class = [];
        foreach ($classes_rooms_roles as $item) {
            $class[] = $item->class_id;
        };

        $year = Year::where('current_year', '1')->first();
        $classes = [];
        foreach ($request->classes as $classes_it) {
            if ($classes_it == "0") {
                $room = Room::whereIn('id', $room1)->get();
                $students = [];
                foreach ($room as $item) {
                    $students[] = $item->student;
                }

                foreach ($students as $item) {
                    foreach ($item as $item2) {

                        $message = new Message;
                        $message->year_id = $year->id;
                        $message->student_id = $item2->id;
                        $message->message = $request->message;
                        $message->admin_id = Auth::user()->id;
                        $message->save();
                        // dispatch(new MessageJob($item2->id));

                    }
                }
                return redirect()->back()->with('success', '! تمت العملية بنجاح ');
            } else {

                $classes[] = $classes_it;
            }
        }


        $rooms = [];
        if ($request->rooms) {
            foreach ($request->rooms as $rooms_it) {
                if ($rooms_it == "0") {
                    $room = Room::whereIn("id", $room1)->whereIn("class_id", $classes)->get();
                    $students = [];
                    foreach ($room as $item) {
                        $students[] = $item->student;
                    }

                    foreach ($students as $item) {
                        foreach ($item as $item2) {

                            $message = new Message;
                            $message->year_id = $year->id;
                            $message->student_id = $item2->id;
                            $message->message = $request->message;
                            $message->admin_id = Auth::user()->id;
                            $message->save();
                            // dispatch(new MessageJob($item2->id));
                        }
                    }
                } else {

                    $rooms[] = $rooms_it;
                }
            }
            if (count($rooms) == 0) {
                return redirect()->back()->with('success', '! تمت العملية بنجاح ');
            }
        } else {
            return redirect()->back()->with('error', '! يرجى اختيار الشعبة   ');
        }
        $students = [];

        if ($request->student) {

            foreach ($request->student as $student) {
                if ($student == "0") {
                    $room = Room::WhereIn("id", $rooms)->get();

                    foreach ($room as $item) {
                        $students[] = $item->student;
                    }

                    foreach ($students as $item) {
                        foreach ($item as $item50) {


                            $message = new Message;
                            $message->year_id = $year->id;
                            $message->student_id = $item50->id;
                            $message->message = $request->message;
                            $message->admin_id = Auth::user()->id;
                            $message->save();
                            // dispatch(new MessageJob($item50->id));
                        }
                    }
                } else {

                    $message = new Message;
                    $message->year_id = $year->id;
                    $message->student_id = $student;
                    $message->message = $request->message;
                    $message->admin_id = Auth::user()->id;
                    $message->save();
                    // dispatch(new MessageJob($student));
                }
            }
            return redirect()->back()->with('success', '! تمت العملية بنجاح ');
        } else {
            return redirect()->back()->with('error', '! يرجى اختيار الطلاب   ');
        }
    }

    public function st_import(Request $request)
    {
        return view('admin.studentimport');
    }
    public function tech_import(Request $request)
    {
        return view('admin.teacherimport');
    }
    public function contacts()
    {
        $contacts = DB::table('contacts')->orderBy('id', 'desc')->paginate(paginate_num);
        // $contacts=Contact::paginate(paginate_num);
        $count = $contacts->count();
        return view('admin.contacts', compact('contacts', 'count'));
    }
    public function jobs()
    {

        $jobs = Job::paginate(paginate_num);
        $count = $jobs->count();
        return view('admin.jobs', compact('jobs', 'count'));
    }
    public function job_update(Request $request)
    {



        $job = Job::find($request->job_id);

        $job->title_ar = $request->title_ar;
        $job->description_ar = $request->description_ar;
        $job->title_en = $request->title_en;
        $job->description_en = $request->description_en;

        if ($request->type) {

            $job->type = 0;
        } else {

            $job->type = 1;
        }



        $job->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function job_store(Request $request)
    {

        $request->validate([
            'title_ar' => 'required|max:100',
            'description_ar' => 'required|max:600',
            'title_en' => 'required|max:100',
            'description_en' => 'required|max:600',
        ]);

        $job = new Job;

        $job->title_ar = $request->title_ar;
        $job->description_ar = $request->description_ar;
        $job->title_en = $request->title_en;
        $job->description_en = $request->description_en;

        if ($request->type) {

            $job->type = 0;
        } else {

            $job->type = 1;
        }


        $job->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function applicants()
    {

        $applicants = Applicant::all();
        $count = $applicants->count();
        return view('admin.applicants', compact('applicants', 'count'));
    }
    public function applicant_delete(Request $request)
    {

        $applicant_id = $request->id;
        $applicant = Applicant::find($applicant_id);

        if ($applicant->file != null) {

            Storage::disk('public')->delete($applicant->file);
        }
        $applicant->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function websitejob()
    {
        return view('admin.websitejob');
    }

    public function contact_answer(Request $request)
    {

        $contact = Contact::find($request->contact_id);
        $contact->message_ar = $request->message_ar;
        $contact->message_en = $request->message_en;

        $contact->answer_ar = $request->answer_ar;
        $contact->answer_en = $request->answer_en;

        if ($request->type) {

            $contact->type = 1;
        } else {

            $contact->type = 0;
        }
        $mail = $contact->email;
        $message = $request->answer_ar;



        $footer = Footer::first();

        $details = $request->answer_ar;
        Mail::to($mail)->send(new NewMail1($details, $footer));

        $contact->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

        public function check_student_pass($lessons,$student,$room_id,$year_id,$class){

            // عدد المواد الراسب فيها اذا كان نوعها مرسبة ولكن ليست لوحدها
              $failed_lessons_count=0;
            //    هل يوجد مادة مرسبة لوحدها راسب فيهاالتحقق
            $lesson_alone_failed_status=false;
            // مادة سلوك
             $lesson_two_failed=0;
            $is_behavior=false;
            // مجموع العام
            // $total_count=Lesson::where('class_id',$class->id)->where('is_neutral','!=',3)
            // ->sum('max_mark');
            $report_card_details=Report_card_details::where('class_id',$class->id)->first();
             // عدد ايام الدوام الفعلي في العام كاملا
            $actual_attendance_count=json_decode($report_card_details->actual_attendance,true)['term1']+json_decode($report_card_details->actual_attendance,true)['term2'];
             // حساب نسبة الدوام
              $student_attendance_days = Student_schedule_tracer::where('user_id',2308)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d'); // grouping by years
                //return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

            // النسبة المئوية الدوام الطالب خلال العام
            $student_attendance_rate=round(100*count($student_attendance_days) /$actual_attendance_count);



        //  dd($student_attendance_rate);

            $religion = [0 => '1',1 => '0'] ;
            $lang = [0 => '1',1 => '0'] ;
            $lessons =  $lessons->Where('religion','!=',$religion[$student->religion]);
            $lessons = $lessons->Where('lang','!=',$lang[$student->lang]);
            $student_marks = Students_mark::where('year_id',$year_id)->
            where('student_id',$student->id)->
            where('room_id',$room_id)
            ->first() ;
             $year_result=0;
             $lessons1=$lessons->where('first_total',1)->where('is_neutral','!=',3);
             foreach( $lessons1 as $lesson1){
               $object_result=json_decode($student_marks->result,true);
          
               $year_result=$year_result+(ceil($object_result[$lesson1->id]['year_result']/2));

            }
            //   $total_count=$lessons ->where('is_neutral','!=',3)->where('first_total',1)
            //                                                              ->sum('max_mark');
               $year_result;
              $total_count=$lessons ->where('is_neutral','!=',3)
                                     ->sum('max_mark');
            $room_student = Room_student::where('student_id', $student->id)->where('year_id',$year_id)->first();
            if (isset($student_marks)) {

            // determine student rigestration term
            // if term is 3 then the student does not have marks for first term and the result will ba calculated based on marks of term2
                if($room_student->term == 3){
                    $final_result = json_decode($student_marks->result2,true);

                    foreach($lessons as $lesson){
                        if ( $lesson->is_neutral != 3 && ($final_result[$lesson->id]['term2_result'] < $lesson->min_mark)) {
                            //student is faild do nothing ;
                            return 0 ;
                        }
                     }
                    // you reach here then you can pass o_o ;
                    return 1;
                }else {


                      // if term is 1 or 2 then it is normal



                            //    من الاول للرابع
             if($class->report_card ==1 || $class->report_card ==11  || $class->report_card ==12){


                $final_result = json_decode($student_marks->result,true) ;

                    foreach($lessons as $lesson){

                        if ( $lesson->is_neutral == 2  &&  $lesson->not_affect_and_collect == 1 &&  (ceil($final_result[$lesson->id]['year_result'] / 2) <= ($lesson->max_mark*0.4))) {
                            $failed_lessons_count++;
                            //student is faild do nothing ;
                            // return 0 ;
                        }
                         if ( $lesson->is_neutral == 1  &&  (ceil($final_result[$lesson->id]['year_result'] / 2) <= ($lesson->max_mark*0.4))) {
                            $failed_lessons_count++;
                            //student is faild do nothing ;
                            // return 0 ;
                        }
                  }
                         if($failed_lessons_count>=2){
                          //student is faild do nothing ;

                         return 0;
                     }else{
                       // you reach here then you can pass o_o ;
                    return 1;
                     }


             }
              elseif($class->report_card ==2  || $class->report_card ==13){
                    $total_count=$lessons ->where('is_neutral','!=',3)->where('first_total',1)
                                                                         ->sum('max_mark');
            // خامس وسادس
                             $final_result = json_decode($student_marks->result,true) ;
                    foreach($lessons as $lesson){
                        if ( $lesson->is_neutral == 2  &&  $lesson->not_affect_and_collect == 1 && (ceil($final_result[$lesson->id]['year_result'] / 2) < ($lesson->max_mark*0.5) )) {


                            $failed_lessons_count++;
                            //student is faild do nothing ;
                            // return 0 ;

                        }


                        // if($lesson->is_neutral == 1 && (ceil($final_result[$lesson->id]['year_result'] / 2) < ($lesson->max_mark*0.5))){
                        //   $lesson_alone_failed_status=true;
                        // }
                           if($lesson->is_neutral == 1){

                               $lesson_two_failed=$lesson_two_failed+(ceil($final_result[$lesson->id]['year_result'] / 2));

                        }

                  }
                        if(ceil($lesson_two_failed/2) < ($lesson->max_mark*0.5)){
                               $lesson_alone_failed_status=true;
                          }

                      if(
                     ( $failed_lessons_count==0 && $lesson_alone_failed_status==false  && (100*$year_result)/$total_count>=50 &&$student_attendance_rate>=60)
                     ||

                      ($lesson_alone_failed_status==false && (100*$year_result)/$total_count>=50)

                      ){

                                  // you reach here then you can pass o_o ;
                    return 1;


                     }else{
                      //student is faild do nothing ;

                         return 0;
                     }


             }



             elseif($class->report_card ==3 || $class->report_card ==14){
                   $total_count=$lessons ->where('is_neutral','!=',3)->where('first_total',1)
                                                                         ->sum('max_mark');

                // سابع تامن

                            $final_result = json_decode($student_marks->result,true) ;
                    foreach($lessons as $lesson){
                        if ( $lesson->is_neutral == 2  &&  $lesson->not_affect_and_collect == 1 &&  $lesson->is_behavior==0 && (ceil($final_result[$lesson->id]['year_result'] / 2) < ($lesson->max_mark*0.5))) {


                            $failed_lessons_count++;
                            //student is faild do nothing ;
                            // return 0 ;
                        }

                          if($lesson->is_neutral == 1  && $lesson->is_behavior==0 && (ceil($final_result[$lesson->id]['year_result'] / 2) < ($lesson->max_mark*0.5))){
                          $lesson_alone_failed_status=true;
                        }
                        if(   $lesson->is_behavior==1 && (ceil($final_result[$lesson->id]['year_result'] / 2) < ($lesson->max_mark*0.6) )){
                             $failed_lessons_count++;
                             $is_behavior=true ;


                        }
                  }


                      if(

                      ( $failed_lessons_count==0  && $is_behavior==false  && $lesson_alone_failed_status==false && (100*$year_result)/$total_count>=50 &&$student_attendance_rate>=60)
                     ||

                      ($lesson_alone_failed_status==false  && $is_behavior==false  && (100*$year_result)/$total_count>=50)

                      ){

                                  // you reach here then you can pass o_o ;
                        return 1;


                     }
                     else{
                          return 0 ;
                     }

                    }
                     elseif($class->report_card == 5   || $class->report_card == 6  || $class->report_card == 7 || $class->report_card == 8  ){
                        $total_count=$lessons ->where('is_neutral','!=',3)->where('first_total',1)
                                                                         ->sum('max_mark');
                        $is_smaller_20=false;
                        $is_smaller_50=false;

                        $final_result = json_decode($student_marks->result,true) ;
                        foreach($lessons as $lesson){

                            if ( $lesson->is_neutral == 2 && $lesson->is_behavior==0 &&    $lesson->not_affect_and_collect == 1 &&  $lesson->is_behavior==0  && (ceil($final_result[$lesson->id]['year_result'] / 2) < ( $lesson->max_mark*0.5))) {

                                $failed_lessons_count++;
                            if((ceil($final_result[$lesson->id]['year_result'] / 2) < ( $lesson->max_mark*0.2))){
                                $is_smaller_20=true;
                             }

                             if((ceil($final_result[$lesson->id]['year_result'] / 2) < ( $lesson->max_mark*0.5))){
                                $is_smaller_50=true;
                             }

                              //student is faild do nothing ;
                                // return 0 ;
                            }

                              if($lesson->is_neutral == 1 && $lesson->is_behavior==0 && (ceil($final_result[$lesson->id]['year_result'] / 2) < ( $lesson->max_mark*0.5))){
                            //    $lesson_alone_failed_status=true;
                                if((ceil($final_result[$lesson->id]['year_result'] / 2) < ( $lesson->max_mark*0.2))){
                                 $is_smaller_20=true;
                              }
                              if($class->is_scientific== 1 ){
                                if((ceil($final_result[$lesson->id]['year_result'] / 2) < ( $lesson->max_mark*0.5))){
                                    $lesson_alone_failed_status=true;
                                }
                            }
                            elseif(  $class->is_scientific == 2 ){
                                if((ceil($final_result[$lesson->id]['year_result'] / 2) < ( $lesson->max_mark*0.4))){
                                    $lesson_alone_failed_status=true;
                                }
                            }

                            }

                            if($lesson->is_behavior==1   && (ceil($final_result[$lesson->id]['year_result'] / 2) < ($lesson->max_mark*0.7) )){

                                $failed_lessons_count++;
                                $is_behavior=true;

                            }
                      }


                          if(

                            ( $failed_lessons_count==0  && $is_behavior==false  && $lesson_alone_failed_status==false && $is_smaller_20==false  && (100*$year_result)/$total_count>=50 && $student_attendance_rate>=75)
                            ||

                          ($lesson_alone_failed_status==false  && $is_behavior==false && $is_smaller_20==false  && (100*$year_result)/$total_count>=50 )



                          ){

                                      // you reach here then you can pass o_o ;
                        return 1;

                     }


                }else{


                              $final_result = json_decode($student_marks->result,true) ;
                    foreach($lessons as $lesson){
                        if ( $lesson->is_neutral == 2  &&  $lesson->not_affect_and_collect == 1 && (ceil($final_result[$lesson->id]['year_result'] / 2) < $lesson->min_mark)) {


                            $failed_lessons_count++;
                            //student is faild do nothing ;
                            // return 0 ;
                        }

                          if($lesson->is_neutral == 1 && (ceil($final_result[$lesson->id]['year_result'] / 2) < $lesson->min_mark)){
                          $lesson_alone_failed_status=true;
                        }
                  }

                      if(

                      ( $failed_lessons_count=0  && (100*$year_result)/$total_count>=50 &&$student_attendance_rate>=75)
                     ||

                      ($lesson_alone_failed_status==false && (100*$year_result)/$total_count>=50)

                      ){

                                  // you reach here then you can pass o_o ;
                    return 1;


                     }else{
                      //student is faild do nothing ;

                         return 0;
                     }




             }

                     // if term is 1 or 2 then it is normal

                    $final_result = json_decode($student_marks->result,true) ;
                    foreach($lessons as $lesson){
                        if ( $lesson->is_neutral != 3 && (ceil($final_result[$lesson->id]['year_result'] / 2) < $lesson->min_mark)) {
                            //student is faild do nothing ;
                            return 0 ;
                        }
                  }
                    // you reach here then you can pass o_o ;
                    // return 1;
                }
                  return 0 ;
            }

            return 0 ;

        }

      public function student_pass($student, $new_room, $next_year_id)
    {
          if($student->religion ==NULL){
                $student->religion='0';
            }
        // first we will bind the student with new room
       $room_student = Room_student::where('student_id', $student->id)->where('year_id', $next_year_id)->where('room_id', $new_room->id)->first();
        if (!isset($room_student)) {
             $room_student1 = Room_student::where('student_id', $student->id)->where('year_id', $next_year_id)->delete();
            $room_student = new Room_student;
            $room_student->student_id = $student->id;
            $room_student->year_id = $next_year_id;
            $room_student->room_id = $new_room->id;

            $room_student->save();
        }
          $report_card = Report_card::where('student_id', $student->id)->where('room_id', $new_room->id)->where('year_id', $next_year_id)->first();
        if (!isset($report_card)) {
            $this->make_student_report_card($student->id, $new_room->id, $next_year_id);
        }
        $student_marks = Students_mark::where('year_id', $next_year_id)->where('student_id', $student->id)->where('room_id', $new_room->id)
            ->first();
        if (!isset($student_marks)) {
        $student_marks = Students_mark::where('year_id', $next_year_id)->where('student_id', $student->id)->delete();
            $next_class_id = $new_room->class_id;
            $lessons = Lesson::where('class_id', $next_class_id)->get();
            $object1 = new stdClass();
            foreach ($lessons as $item) {
                $object1->{$item->id}['oral'] = null;
                $object1->{$item->id}['homework'] = null;
                $object1->{$item->id}['activities'] = null;
                $object1->{$item->id}['quize'] = null;
                $object1->{$item->id}['exam'] = null;
            }

            $object2 = new stdClass();
            foreach ($lessons as $item) {
                $object2->{$item->id}['oral'] = null;
                $object2->{$item->id}['homework'] = null;
                $object2->{$item->id}['activities'] = null;
                $object2->{$item->id}['quize'] = null;
                $object2->{$item->id}['exam'] = null;
            }

            $object_result1 = new stdClass();

            foreach ($lessons as $item) {
                $object_result1->{$item->id}['term1_quizes'] = null;
                $object_result1->{$item->id}['term1_exam'] = null;
                $object_result1->{$item->id}['term1_result'] = null;
            }


            $object_result2 = new stdClass();

            foreach ($lessons as $item) {
                $object_result2->{$item->id}['term2_quizes'] = null;
                $object_result2->{$item->id}['term2_exam'] = null;
                $object_result2->{$item->id}['term2_result'] = null;
            }

            $object_result = new stdClass();

            foreach ($lessons as $item) {
                $object_result->{$item->id}['year_result'] = null;
            }

            $object_result_term = new stdClass();

            $object_result_term->{'term1'} = null;
            $object_result_term->{'term2'} = null;

            // return json_encode($object_result_term);

            $student_mark = Students_mark::create([
                'student_id' => $student->id,
                'room_id' => $new_room->id,
                'year_id' => $next_year_id,
                'mark' => json_encode($object1),
                'mark2' => json_encode($object2),
                'result1' => json_encode($object_result1),
                'result2' => json_encode($object_result2),
                'result' => json_encode($object_result),
                'term_result' => json_encode($object_result_term),
                'status' => '1',
                'lang' => $student->lang,
                'religion' => $student->religion,

            ]);



            if ($student->lang == 0) {
                $lessons = Lesson::where('class_id', $next_class_id)->where('lang', '1')->get();
            } elseif ($student->lang == 1) {
                $lessons = Lesson::where('class_id', $next_class_id)->where('lang', '0')->get();
            }


            $student_mark = '';
            foreach ($lessons as $lesson) {

                if ($lesson->lang != null) {

                    $student_mark = Students_mark::where('student_id', $student->id)->where('lang', $student->lang)->where('year_id', $next_year_id)->first();


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

                    $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $next_year_id)->first();

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
                    $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $next_year_id)->first();

                    $year_result = (json_decode($student_mark->term_result, true)['term1'] + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->year_result = $year_result;
                    $student_mark->save();
                }
            }


            if ($student->religion == 0) {
                $lessons = Lesson::where('class_id', $next_class_id)->where('religion', '1')->get();
            } elseif ($student->religion == 1) {
                $lessons = Lesson::where('class_id', $next_class_id)->where('religion', '0')->get();
            }



            foreach ($lessons as $lesson) {

                if ($lesson->religion != null) {
                    $student_mark = Students_mark::where('student_id', $student->id)->where('religion', $student->religion)->where('year_id', $next_year_id)->first();

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

                    $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $next_year_id)->first();

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
                    $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $next_year_id)->first();


                    $year_result = (json_decode($student_mark->term_result, true)['term1'] + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->year_result = $year_result;
                    $student_mark->save();
                }
            } //religion lesson
        }
        return  0;
    }
     public function student_graduate()
    {
        return 0;
    }
  public function student_fail($student, $new_room, $next_year_id)
    {

         $room_student = Room_student::where('student_id', $student->id)->where('year_id', $next_year_id)->where('room_id', $new_room->id)->first();
        if (!isset($room_student)) {
          $room_student1 = Room_student::where('student_id', $student->id)->where('year_id', $next_year_id)->delete();
            $room_student = new Room_student;
            $room_student->student_id = $student->id;
            $room_student->year_id = $next_year_id;
            $room_student->room_id = $new_room->id;

            $room_student->save();
        }

        $report_card = Report_card::where('student_id', $student->id)->where('room_id', $new_room->id)->where('year_id', $next_year_id)->first();
        if (!isset($report_card)) {
            $this->make_student_report_card($student->id, $new_room->id, $next_year_id);
        }

        $student_marks = Students_mark::where('year_id', $next_year_id)->where('student_id', $student->id)->where('room_id', $new_room->id)
            ->first();
        if (!isset($student_marks)) {
             $student_marks = Students_mark::where('year_id', $next_year_id)->where('student_id', $student->id)->delete();
            $next_class_id = $new_room->class_id;
            $lessons = Lesson::where('class_id', $next_class_id)->get();
            $object1 = new stdClass();
            foreach ($lessons as $item) {
                $object1->{$item->id}['oral'] = null;
                $object1->{$item->id}['homework'] = null;
                $object1->{$item->id}['activities'] = null;
                $object1->{$item->id}['quize'] = null;
                $object1->{$item->id}['exam'] = null;
            }

            $object2 = new stdClass();
            foreach ($lessons as $item) {
                $object2->{$item->id}['oral'] = null;
                $object2->{$item->id}['homework'] = null;
                $object2->{$item->id}['activities'] = null;
                $object2->{$item->id}['quize'] = null;
                $object2->{$item->id}['exam'] = null;
            }

            $object_result1 = new stdClass();

            foreach ($lessons as $item) {
                $object_result1->{$item->id}['term1_quizes'] = null;
                $object_result1->{$item->id}['term1_exam'] = null;
                $object_result1->{$item->id}['term1_result'] = null;
            }


            $object_result2 = new stdClass();

            foreach ($lessons as $item) {
                $object_result2->{$item->id}['term2_quizes'] = null;
                $object_result2->{$item->id}['term2_exam'] = null;
                $object_result2->{$item->id}['term2_result'] = null;
            }

            $object_result = new stdClass();

            foreach ($lessons as $item) {
                $object_result->{$item->id}['year_result'] = null;
            }

            $object_result_term = new stdClass();

            $object_result_term->{'term1'} = null;
            $object_result_term->{'term2'} = null;

            // return json_encode($object_result_term);

            $student_mark = Students_mark::create([
                'student_id' => $student->id,
                'room_id' => $new_room->id,
                'year_id' => $next_year_id,
                'mark' => json_encode($object1),
                'mark2' => json_encode($object2),
                'result1' => json_encode($object_result1),
                'result2' => json_encode($object_result2),
                'result' => json_encode($object_result),
                'term_result' => json_encode($object_result_term),
                'status' => '1',
                'lang' => $student->lang,
                'religion' => $student->religion,

            ]);



            if ($student->lang == 0) {
                $lessons = Lesson::where('class_id', $next_class_id)->where('lang', '1')->get();
            } elseif ($student->lang == 1) {
                $lessons = Lesson::where('class_id', $next_class_id)->where('lang', '0')->get();
            }


            $student_mark = '';
            foreach ($lessons as $lesson) {

                if ($lesson->lang != null) {

                    $student_mark = Students_mark::where('student_id', $student->id)->where('lang', $student->lang)->where('year_id', $next_year_id)->first();


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

                    $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $next_year_id)->first();

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
                    $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $next_year_id)->first();

                    $year_result = (json_decode($student_mark->term_result, true)['term1'] + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->year_result = $year_result;
                    $student_mark->save();
                }
            }


            if ($student->religion == 0) {
                $lessons = Lesson::where('class_id', $next_class_id)->where('religion', '1')->get();
            } elseif ($student->religion == 1) {
                $lessons = Lesson::where('class_id', $next_class_id)->where('religion', '0')->get();
            }



            foreach ($lessons as $lesson) {

                if ($lesson->religion != null) {
                    $student_mark = Students_mark::where('student_id', $student->id)->where('religion', $student->religion)->where('year_id', $next_year_id)->first();

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

                    $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $next_year_id)->first();

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
                    $student_mark = Students_mark::where('student_id', $student->id)->where('year_id', $next_year_id)->first();


                    $year_result = (json_decode($student_mark->term_result, true)['term1'] + json_decode($student_mark->term_result, true)['term2']) / 2;

                    $student_mark->year_result = $year_result;
                    $student_mark->save();
                }
            } //religion lesson
        }

        return 0;
    }

    public function change_student_situation($student_id, $next_year_id, $is_passed)
    {
        Room_student::where('student_id', $student_id)->where('year_id', $next_year_id)->delete();
        Students_mark::where('year_id', $next_year_id)->where('student_id', $student_id)->delete();
        Report_card::where('student_id', $student_id)->where('year_id', $next_year_id)->delete();

        return 1;
    }
     public function make_student_report_card($student_id,$room_id,$year_id,$adjustable = 0){
        // for both term1 and term2;
        Report_card::where('student_id', $student_id)->where('year_id', $year_id)->delete();
        $teacher_notes = new stdClass() ;
        $student_attendance = new stdClass() ;
        $actual_attendance 	= new stdClass() ;
        $justified_absence	= new stdClass() ;
        $unjustified_absence	= new stdClass() ;

        $teacher_notes->{'term1'} = null ;
        $teacher_notes->{'term2'} = null ;
        $student_attendance->{'term1'} = null ;
        $student_attendance->{'term2'} = null ;
        $actual_attendance->{'term1'} = null ;
        $actual_attendance->{'term2'} = null ;
        $justified_absence->{'term1'} = null ;
        $justified_absence->{'term2'} = null ;
        $unjustified_absence->{'term1'} = null ;
        $unjustified_absence->{'term2'} = null ;

        $report_cards = new Report_card ;

        $report_cards->room_id = $room_id;
        $report_cards->year_id = $year_id;

        $report_cards->student_id = $student_id;
        $report_cards->teacher_notes = json_encode($teacher_notes);
        $report_cards->manager_notes = null;
        $report_cards->final_result = 1;
        $report_cards->student_attendance = json_encode($student_attendance);
        $report_cards->actual_attendance = json_encode($actual_attendance);
        $report_cards->justified_absence = json_encode($justified_absence);
        $report_cards->unjustified_absence = json_encode($unjustified_absence);
         $report_cards->adjustable = $adjustable ;
        $report_cards->save();
   }


    // public function school_data()
    // {
    //     $school_data = About_us::select('school_name', 'province', 'logo')->where('id', '>', 0)->first();
    //     return view('admin.school_data', compact('school_data'));
    // }
    // public function school_data_store(Request $request)
    // {
    //     $school_data = About_us::where('id', '>', 0)->first();
    //     $school_data->school_name = $request->school_name;
    //     $school_data->province = $request->province;
    //     // if ($request->hasFile('logo')) {
    //     //     Storage::disk('public')->delete( $school_data->logo);
    //     //     $school_data->logo = $request->logo->store('school_data','public');
    //     // }
    //     $school_data->save();
    //     return redirect()->back()->with('success', 'تم التخزين بنجاح');
    // }


    public function our_team()
    {

        $group = Group::paginate(paginate_num);
        $count = Category::count();


        return view('admin.our_team', compact('group', 'count'));
    }

    public function ourteam_store(Request $request)
    {


        $group = new Group;


        $group->first_name_ar = $request->first_name_ar;
        $group->first_name_en = $request->first_name_en;

        $group->last_name_ar = $request->last_name_ar;
        $group->last_name_en = $request->last_name_en;

        $group->discrption_ar = $request->discrption_ar;
        $group->discrption_en = $request->discrption_en;
        $group->type = $request->type;



        if ($request->hasFile('img')) {

            $group->img = $request->img->store('newsimages', 'public');
        }






        $group->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function gruop_delete(Request $request)
    {

        $group_id = $request->id;
        $group = Group::find($group_id);

        if ($group->img != null) {

            Storage::disk('public')->delete($group->img);
        }
        $group->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function ourteam_update(Request $request)
    {


        $group = Group::find($request->id);


        $group->first_name_ar = $request->first_name_ar;
        $group->first_name_en = $request->first_name_en;

        $group->last_name_ar = $request->last_name_ar;
        $group->last_name_en = $request->last_name_en;

        $group->discrption_ar = $request->discrption_ar;
        $group->discrption_en = $request->discrption_en;
        $group->type = $request->type;



        if ($request->hasFile('img')) {
            if ($group->img != null) {

                Storage::disk('public')->delete($group->img);
            }

            $group->img = $request->img->store('newsimages', 'public');
        }


        $group->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function slider()
    {

        $slider = Slider::paginate(paginate_num);
        $count = Slider::count();


        return view('admin.sliders', compact('slider', 'count'));
    }


    public function slider_store(Request $request)
    {


        $slider = new Slider;


        $slider->header_ar = $request->header_ar;

        $slider->header_en = $request->header_en;
        $slider->content_ar= $request->content_ar;
        $slider->content_en= $request->content_en;
        $slider->key_word_ar= $request->key_word_ar;
        $slider->key_word_en= $request->key_word_en;
        if ($request->hasFile('image')) {

            $slider->image = $request->image->store('newsimages', 'public');
        }






        $slider->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function slider_delete(Request $request)
    {

        $group_id = $request->id;
        $slider = Slider::find($group_id);

        if ($slider->image != null) {

            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function slider_update(Request $request)
    {


        $slider = Slider::find($request->id);


        $slider->header_ar = $request->header_ar;

        $slider->header_en = $request->header_en;
        $slider->content_ar= $request->content_ar;
        $slider->content_en= $request->content_en;
        $slider->key_word_ar= $request->key_word_ar;
        $slider->key_word_en= $request->key_word_en;
        if ($request->hasFile('image')) {
            if ($slider->image != null) {

                Storage::disk('public')->delete($slider->image);
            }
            $slider->image = $request->image->store('newsimages', 'public');
        }

        $slider->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    //////////////////////////////gallery_website
    public function gallery()
    {

        $gallery = Gallery::paginate(paginate_num);
        $count = Slider::count();


        return view('admin.gallery', compact('gallery', 'count'));
    }


    public function gallery_store(Request $request)
    {


        $gallery = new Gallery;



        if ($request->hasFile('image')) {

            $gallery->image = $request->image->store('newsimages', 'public');
        }






        $gallery->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function gallery_delete(Request $request)
    {

        $group_id = $request->id;
        $gallery = Gallery::find($group_id);

        if ($gallery->image != null) {

            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function gallery_update(Request $request)
    {


        $gallery = Gallery::find($request->id);



        if ($request->hasFile('image')) {
            if ($gallery->image != null) {

                Storage::disk('public')->delete($gallery->image);
            }
            $gallery->image = $request->image->store('newsimages', 'public');
        }

        $gallery->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    //// vision_mission_website
    public function vision_mission_website()
    {

        $vision = Vision::orderBy('created_at')->paginate(10);
        $count = Vision::count();


        return view('admin.visions', compact('vision', 'count'));
    }


    public function vision_mission_website_store(Request $request)
    {




        $vision = new Vision;


        $vision->title_ar = $request->title_ar;

        $vision->title_en = $request->title_en;

        $vision->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function vision_mission_website_delete(Request $request)
    {

        $group_id = $request->id;
        $vision = Vision::find($group_id);
        $vision->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function vision_mission_website_update(Request $request)
    {


        $vision = Vision::find($request->id);


        $vision->title_ar = $request->title_ar;

        $vision->title_en = $request->title_en;
        $vision->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    /////service
    public function service_website()
    {

        $service = Service::paginate(paginate_num);
        $count = Service::count();


        return view('admin.services', compact('service', 'count'));
    }

    public function service_website_store(Request $request)
        {



        $service = new Service;




        $service->title_en = $request->title_en;
        $service->title_ar= $request->title_ar;
        $service->description_en= $request->description_en;
        $service->description_ar= $request->description_ar;
        if ($request->hasFile('image')) {

            $service->image = $request->image->store('newsimages', 'public');
        }

        $service->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function service_website_delete(Request $request)
    {

        $group_id = $request->id;
        $service = Service::find($group_id);
        if ($service->image != null) {

            Storage::disk('public')->delete($service->image);
        }
        $service->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function service_website_update(Request $request)
    {


        $service = Service::find($request->id);

        $service->title_en = $request->title_en;
        $service->title_ar= $request->title_ar;
        $service->description_en= $request->description_en;
        $service->description_ar= $request->description_ar;
        if ($request->hasFile('image')) {
            if ($service->image != null) {

                Storage::disk('public')->delete($service->image);
            }
            $service->image = $request->image->store('newsimages', 'public');
        }
        $service->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    /////////////our_services_feature_website
    public function our_services_feature_website()
    {

        $our_service = Our_services_feature::paginate(paginate_num);
        $count = Our_services_feature::count();


        return view('admin.our_services_feature_website', compact('our_service', 'count'));
    }

    public function our_services_feature_website_store(Request $request)
    {


        $our_service = new Our_services_feature;
        $our_service->title_ar= $request->title_ar;
        $our_service->title_en = $request->title_en;
        $our_service->description_ar= $request->description_ar;
        $our_service->description_en= $request->description_en;

        if ($request->hasFile('image')) {

            $our_service->image = $request->image->store('newsimages', 'public');
        }
        if ($request->hasFile('icon')) {

            $our_service->icon = $request->icon->store('newsimages', 'public');
        }

        $our_service->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function our_services_feature_website_delete(Request $request)
    {

        $group_id = $request->id;
        $our_service = Our_services_feature::find($group_id);
        if ($our_service->image != null) {

            Storage::disk('public')->delete($our_service->image);
        }
        if ($our_service->icon != null) {

            Storage::disk('public')->delete($our_service->icon);
        }
        $our_service->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function our_services_feature_website_update(Request $request)
    {


        $our_service = Our_services_feature::find($request->id);

        $our_service->title_en = $request->title_en;
        $our_service->title_ar= $request->title_ar;
        $our_service->description_en= $request->description_en;
        $our_service->description_ar= $request->description_ar;
        if ($request->hasFile('image')) {
            if ($our_service->image != null) {

                Storage::disk('public')->delete($our_service->image);
            }
            $our_service->image = $request->image->store('newsimages', 'public');
        }
        if ($request->hasFile('icon')) {
            if ($our_service->icon != null) {

                Storage::disk('public')->delete($our_service->icon);
            }
            $our_service->icon = $request->icon->store('newsimages', 'public');
        }
        $our_service->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    ///////////////////////////////////////how_it_works_website
    public function how_it_works_website()
    {

        $how_it_works = How_it_works_website::paginate(paginate_num);
        $count = How_it_works_website::count();


        return view('admin.how_it_works_website', compact('how_it_works', 'count'));
    }

    public function how_it_works_website_store(Request $request)
    {


        $how_it_works = new How_it_works_website;
        $how_it_works->title_ar= $request->title_ar;
        $how_it_works->title_en = $request->title_en;
        $how_it_works->description_ar= $request->description_ar;
        $how_it_works->description_en= $request->description_en;



        $how_it_works->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function how_it_works_website_delete(Request $request)
    {

        $group_id = $request->id;
        $how_it_works = How_it_works_website::find($group_id);

        $how_it_works->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function how_it_works_website_update(Request $request)
    {


        $how_it_works = How_it_works_website::find($request->id);

        $how_it_works->title_en = $request->title_en;
        $how_it_works->title_ar= $request->title_ar;
        $how_it_works->description_en= $request->description_en;
        $how_it_works->description_ar= $request->description_ar;

        $how_it_works->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    //////////////////////////////////////////
     //// counter_website
     public function counter_website()
     {

         $counter = Counter_website::paginate(paginate_num);
         $count = Counter_website::count();


         return view('admin.counter_website', compact('counter', 'count'));
     }


     public function counter_website_store(Request $request)
     {




         $counter = new Counter_website;


         $counter->title_ar = $request->title_ar;

         $counter->title_en = $request->title_en;

         $counter->count = $request->count;

         $counter->save();

         return redirect()->back()->with('success', '! تمت العملية بنجاح');
     }
     public function counter_website_delete(Request $request)
     {

         $group_id = $request->id;
         $counter = Counter_website::find($group_id);
         $counter->delete();

         return redirect()->back()->with('success', '! تمت العملية بنجاح');
     }


     public function counter_website_update(Request $request)
     {


         $counter = Counter_website::find($request->id);


         $counter->title_ar = $request->title_ar;

         $counter->title_en = $request->title_en;
         $counter->count = $request->count;
         $counter->save();

         return redirect()->back()->with('success', '! تمت العملية بنجاح');
     }
      //// testimonials_website
      public function testimonials_website()
      {

          $testimonials = Testimonials::paginate(paginate_num);
          $count = Testimonials::count();


          return view('admin.testimonials_website', compact('testimonials', 'count'));
      }


      public function testimonials_website_store(Request $request)
      {




          $testimonials = new Testimonials;


          $testimonials->message = $request->message;

          $testimonials->user_name = $request->user_name;
          $testimonials->job_title = $request->job_title;



          $testimonials->save();

          return redirect()->back()->with('success', '! تمت العملية بنجاح');
      }
      public function testimonials_website_delete(Request $request)
      {

          $group_id = $request->id;
          $testimonials = Testimonials::find($group_id);
          $testimonials->delete();

          return redirect()->back()->with('success', '! تمت العملية بنجاح');
      }


      public function testimonials_website_update(Request $request)
      {


          $testimonials = Testimonials::find($request->id);


          $testimonials->message = $request->message;

          $testimonials->user_name = $request->user_name;
          $testimonials->job_title = $request->job_title;
          $testimonials->save();

          return redirect()->back()->with('success', '! تمت العملية بنجاح');
      }
     ///////////////////////////////////
         /////blogs_website
    public function blogs_website()
    {

        $blogs = Blogs_website::paginate(paginate_num);
        $count = Blogs_website::count();


        return view('admin.blogs_website', compact('blogs', 'count'));
    }

    public function blogs_website_store(Request $request)
        {



        $blogs = new Blogs_website;




        $blogs->title_en = $request->title_en;
        $blogs->title_ar= $request->title_ar;
        $blogs->description_en= $request->description_en;
        $blogs->description_ar= $request->description_ar;
        if ($request->hasFile('image')) {

            $blogs->image = $request->image->store('newsimages', 'public');
        }

        $blogs->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function blogs_website_delete(Request $request)
    {

        $group_id = $request->id;
        $blogs = Blogs_website::find($group_id);
        if ($blogs->image != null) {

            Storage::disk('public')->delete($blogs->image);
        }
        $blogs->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }


    public function blogs_website_update(Request $request)
    {


        $blogs = Blogs_website::find($request->id);

        $blogs->title_en = $request->title_en;
        $blogs->title_ar= $request->title_ar;
        $blogs->description_en= $request->description_en;
        $blogs->description_ar= $request->description_ar;
        if ($request->hasFile('image')) {
            if ($blogs->image != null) {

                Storage::disk('public')->delete($blogs->image);
            }
            $blogs->image = $request->image->store('newsimages', 'public');
        }
        $blogs->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
       /////footer_website
       public function footer_website()
       {

           $footer = Footer_website::paginate(paginate_num);
           $count = Footer_website::count();


           return view('admin.footer_website', compact('footer', 'count'));
       }

       public function footer_website_update(Request $request)
       {
    $request->validate([
            'phone' => 'max:22',
        ]);

           $footer = Footer_website::find($request->id);
           $footer->title_ar= $request->title_ar;
           $footer->title_en = $request->title_en;
           $footer->content_ar= $request->content_ar;
           $footer->content_en= $request->content_en;
           $footer->address_ar= $request->address_ar;
           $footer->address_en= $request->address_en;
           $footer->phone= $request->phone;
           $footer->email= $request->email;
           $footer->facebook= $request->facebook;
           $footer->twitter= $request->twitter;
           $footer->linkedin= $request->linkedin;
           $footer->instgram= $request->instgram;
           $footer->whatsApp= $request->whatsApp;


           $footer->save();

           return redirect()->back()->with('success', '! تمت العملية بنجاح');
       }
    ///////////////////////////////////
     ///////////////////////////////////////faqs_website
     public function faqs_website()
     {

         $faqs = Faqs_website::paginate(paginate_num);
         $count = Faqs_website::count();


         return view('admin.faqs_website', compact('faqs', 'count'));
     }

     public function faqs_website_store(Request $request)
     {


         $faqs = new Faqs_website;
         $faqs->title_ar= $request->title_ar;
         $faqs->title_en = $request->title_en;
         $faqs->description_ar= $request->description_ar;
         $faqs->description_en= $request->description_en;



         $faqs->save();

         return redirect()->back()->with('success', '! تمت العملية بنجاح');
     }
     public function faqs_website_delete(Request $request)
     {

         $group_id = $request->id;
         $faqs = Faqs_website::find($group_id);

         $faqs->delete();

         return redirect()->back()->with('success', '! تمت العملية بنجاح');
     }


     public function faqs_website_update(Request $request)
     {


         $faqs = Faqs_website::find($request->id);

         $faqs->title_en = $request->title_en;
         $faqs->title_ar= $request->title_ar;
         $faqs->description_en= $request->description_en;
         $faqs->description_ar= $request->description_ar;

         $faqs->save();

         return redirect()->back()->with('success', '! تمت العملية بنجاح');
     }
     //////////////////////////////////////////

     ///////////////////////////////////////Contact_website
     public function contact_website()
     {

         $contact_web = Contact_website::paginate(paginate_num);
         $count = Contact_website::count();


         return view('admin.Contact_website', compact('contact_web', 'count'));
     }

     public function contact_website_delete(Request $request)
     {

         $group_id = $request->id;
         $contact_web = Contact_website::find($group_id);

         $contact_web->delete();

         return redirect()->back()->with('success', '! تمت العملية بنجاح');
     }



     ////////////////////////////////////////
    public function class_teacher($teacher_id)
    {
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();
        $teacher = Teacher::with(['rooms.student' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->find($teacher_id);

        foreach ($teacher->rooms as $item) {

            $classes[] = $item->classes;
        }
        $rooms = $teacher->rooms;
        $classes = array_unique($classes);
        $schedule = Lesson_room_teacher_lecture_time::with('lesson', 'lecture_time')->with(['room.classes' => function ($query) {
                $query->select("id", "name");
            }])
            ->join('lecture_times', 'lecture_times.id', '=', 'lesson_room_teacher_lecture_time.lecture_time_id')
            ->orderBy('lecture_times.start_time')
            ->select("lesson_room_teacher_lecture_time.*")
            ->where('teacher_id', $teacher_id)->get();
        return  $rooms;
    }


    public function send_message_admin_reply(Request $request)
    {
        $year = Year::where('current_year', '1')->first();
        $message = new Message;
        $message->year_id = $year->id;
        $message->student_id = $request->student_id;
        $message->message = $request->message;
        $message->admin_id = Auth::user()->id;
        $message->save();
        $noti = new Notification;
        $noti->user_id =1;
        $noti->student_id = $request->student_id;
        // $noti->room_id = $room->id;
        $noti->title ="يوجد رسالة ";
        $noti->body = "الادارة ";
        // $noti->term_id = $terms->id;
        $noti->type = 11;
        $noti->save();
        $tokens = Studentfcmtoken::where('s_fk',$request->student_id)->get();

        $devices = array();
            foreach($tokens as $t){
                array_push($devices, $t['s_fcm_token']);
                //array_push($devices['p_id'], $t['p_fk']);
            }
        $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,'null','null','null',$devices);


        return $message;
    }




    public function student_attendance_month($student_id, $room_id)
    {
        if ($room_id == 0) {
            return redirect()->back()->with('error', 'قم بتحديد شعبة الطالب');
        }
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->first();
        $student = Student::find($student_id);
        $room = Room::with('classes')->findOrFail($room_id);
        //    $room->class_name = $room->classes->name ;

        $user = User::where('student_id', $student_id)->first();
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);


        $lecture_times = Lecture_time::where('room_id', $room->id)->get();

        $schedule = Lesson_room_teacher_lecture_time::WhereHas('room', function ($q) use ($year) {
            $q->where('year_id', $year->id);
        })->with('lesson')->with(['room.classes' => function ($query) {
                $query->select("id", "name");
            }])
            ->where('room_id', $room_id)->get();

        $diff = strtotime($term->start) - strtotime($term->end);
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        $diff_in_days = abs(round($diff / 86400));
        $x = 0;
        $y = [];



        // جلب اليوم لكل يوم بالمجال واستعراض الحضور

        while ($term->end >= $term->start) {
            // while(Carbon::now()->subDays($x) >= Carbon::now()->subDays(35)) {
            $schedule = Lesson_room_teacher_lecture_time::with('lesson')->with(['room.classes' => function ($query) {
                    $query->select("id", "name");
                }])
                ->where('room_id', $room_id)->get();
            $y11 = [];
            $x++;
            $user_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::parse($term->end)->subDays($x))->where('user_id', $user->id)->get();

            $timestamp = strtotime(Carbon::parse($term->end)->subDays($x));
            $this_day = date('l', $timestamp);
            $this_day = $this->getDay($this_day);
            $this_day_lecture = $schedule->where('day_id', $this_day + 1);
            $this_day_date = Carbon::parse($term->end)->subDays($x);
            $this_day_date = Carbon::parse($this_day_date);
            $this_day_date = $this_day_date->format('Y-m-d');



            $this_day_lectures = $schedule->where('day_id', $this_day + 1);

            foreach ($this_day_lectures  as $key => $this_day_lecture) {

                $y[] = $this_day_date;
            }
            if ($diff_in_days == $x) break;
        }

        $now = Carbon::now();


        $month = [];
        $user_attendance = $y;
        foreach ($user_attendance as $item) {
            $i =    Carbon::parse($item)->format('m');
            $month[$i] =  Carbon::parse($item)->locale("ar")->translatedFormat("F");
        }




        return view('admin.student_attendance_month', compact('student', 'student_id', 'room', 'month'));
    }


    public function teacher_sch()
    {
        $teacher = Teacher::all();
        return view('admin.reports.teacher_sch', compact('teacher'));
    }
    public function student_sch()
    {
        $class = Classe::all();
        return view('admin.reports.student_sch', compact('class'));
    }

    public function teacher_sched($teacher_id, $first_date, $end_date)
    {

        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->first();
        $teacher = Teacher::find($teacher_id);
        $user = User::where('teacher_id', $teacher_id)->first();
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);
        $teacher_id = $teacher_id;



        $schedule = Lesson_room_teacher_lecture_time::with('lesson')
            ->WhereHas('room', function ($q) use ($year) {
                $q->where('year_id', $year->id);
            })
            ->with(['room.classes' => function ($query) {
                $query->select("id", "name");
            }])
            ->where('teacher_id', $teacher_id)->get();

        $diff = strtotime($first_date) - strtotime($end_date);

        $diff_in_days = abs(round($diff / 86400));
        $x = 0;
        $y = [];


        while ($end_date >= $first_date) {

            $schedule = Lesson_room_teacher_lecture_time::WhereHas('room', function ($q) use ($year) {
                $q->where('year_id', $year->id);
            })->with('lesson')->with(['room.classes' => function ($query) {
                    $query->select("id", "name");
                }])->with('lecture_time')
                ->where('teacher_id', $teacher_id)->get();
            $y11 = [];
            $x++;
            $user_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::parse($end_date)->subDays($x))->where('user_id', $user->id)->get();

            $timestamp = strtotime(Carbon::parse($end_date)->subDays($x));
            $this_day = date('l', $timestamp);
            $this_day = $this->getDay($this_day);
            $this_day_lecture = $schedule->where('day_id', $this_day + 1);
            $this_day_date = Carbon::parse($end_date)->subDays($x);
            $this_day_date = Carbon::parse($this_day_date);
            $this_day_date = $this_day_date->format('Y-m-d');

            $this_day_lectures = $schedule->where('day_id', $this_day + 1);

            foreach ($this_day_lectures  as $key => $this_day_lecture) {
                $tracer =  $user_schedule_tracer->where('lecture_time_id', $this_day_lecture->lecture_time_id);

                if (!blank($tracer)) {
                    $this_day_lecture->attendance = true;
                } else {
                    $this_day_lecture->attendance = false;
                }
                $y["$this_day_date"]['lectures'][] = $this_day_lecture;
            }
            if ($diff_in_days == $x) break;
        }
        $user_attendance = $y;
        return  $user_attendance;
    }

    public function student_sched($student_id, $room_id, $first_date, $end_date)
    {
        if ($room_id == 0) {
            return redirect()->back()->with('error', 'قم بتحديد شعبة الطالب');
        }
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->first();
        $student = Student::find($student_id);
        $room = Room::with('classes')->findOrFail($room_id);
        //    $room->class_name = $room->classes->name ;

        $user = User::where('student_id', $student_id)->first();
        $timestamp = strtotime(now());
        $today = date('l', $timestamp);
        $today = $this->getDay($today);


        $lecture_times = Lecture_time::where('room_id', $room->id)->get();

        $schedule = Lesson_room_teacher_lecture_time::WhereHas('room', function ($q) use ($year) {
            $q->where('year_id', $year->id);
        })->with('lesson')->with(['room.classes' => function ($query) {
                $query->select("id", "name");
            }])->with('lecture_time')
            ->where('room_id', $room_id)->get();

        $diff = strtotime($first_date) - strtotime($end_date);
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        $diff_in_days = abs(round($diff / 86400));
        $x = 0;
        $y = [];

        while ($end_date >= $first_date) {
            // while(Carbon::now()->subDays($x) >= Carbon::now()->subDays(35)) {
            $schedule = Lesson_room_teacher_lecture_time::with('lesson')->with(['room.classes' => function ($query) {
                    $query->select("id", "name");
                }])->with('lecture_time')
                ->where('room_id', $room_id)->get();
            $y11 = [];
            $x++;
            $user_schedule_tracer = Student_schedule_tracer::whereDate('created_at', Carbon::parse($end_date)->subDays($x))->where('user_id', $user->id)->get();

            $timestamp = strtotime(Carbon::parse($end_date)->subDays($x));
            $this_day = date('l', $timestamp);
            $this_day = $this->getDay($this_day);
            $this_day_lecture = $schedule->where('day_id', $this_day + 1);
            $this_day_date = Carbon::parse($end_date)->subDays($x);
            $this_day_date = Carbon::parse($this_day_date);
            $this_day_date = $this_day_date->format('Y-m-d');



            $this_day_lectures = $schedule->where('day_id', $this_day + 1);

            foreach ($this_day_lectures  as $key => $this_day_lecture) {
                $tracer =  $user_schedule_tracer->where('lecture_time_id', $this_day_lecture->lecture_time_id);
                if (!blank($tracer)) {
                    $this_day_lecture->attendance = true;
                } else {
                    $this_day_lecture->attendance = false;
                }
                $y["$this_day_date"]['lectures'][] = $this_day_lecture;
            }
            if ($diff_in_days == $x) break;
        }
        $user_attendance = $y;
        return  $user_attendance;
    }
    public function student_message($student_id)
    {

        $year = Year::where('current_year', '1')->first();
        // $student_id=User::where('student_id',$student_id)->first();

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

        $s_mess = Message::where('student_id', $student->id)->where('admin_id', "!=", null)->where('year_id', $year->id)
            ->get();

        foreach ($s_mess   as $item) {

            if ($item->type == 1) {
                $item->view = 1;
                $item->save();
            }
        }

        return $s_mess;
    }
    public function getstudents_view(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;

        $search_bar = $request->barcode_pos_check;
        $columnIndex = $columnIndex_arr[0]['column'];
        $columnIndex = $columnIndex > 2 ? 0 : $columnIndex;
        $array_of_sorting = ['first_name', 'last_name',]; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }
        $classes_rooms_roles = Classes_Rooms_Roles::where('role_id', auth()->user()->role_id)->get();
        $class = [];
        foreach ($classes_rooms_roles as $item) {
            $class[] = $item->class_id;
        };

        $room = [];
        foreach ($classes_rooms_roles as $item) {
            $room[] = $item->room_id;
        };

        $totalRecords = Message::whereHas('student.room.classes', function ($query) use ($class) {
                $query->whereIn('id', $class);
            })->whereHas('student.room', function ($query) use ($room) {
                $query->whereIn('room_id', $room);
            })->where('admin_id', '!=', null)->where('type', 1)->orderBy("id", 'desc')->count();
        $message = Message::whereHas('student.room.classes', function ($query) use ($class) {
            $query->whereIn('id', $class);
        })->whereHas('student.room', function ($query) use ($room) {
            $query->whereIn('room_id', $room);
        })->where('admin_id', '!=', null)->where('type', 1)->where('view', 0)->orderBy("id", 'desc')->get();
        foreach ($message as $item) {
            $st[] = $item->student_id;
        }

        $totalRecords = Student::count();
        $totalRecordswithFilter = Student::whereIn('id', $st)->where('first_name', "like", "%" . $result_search . "%")

            ->orwhere('last_name', "like", "%" . $result_search . "%")->whereIn('id', $st)

            ->with('room.classes')->count();
        $records = Student::whereIn('id', $st)->where('first_name', "like", "%" . $result_search . "%")
            ->withCount('message_admin')
            ->orwhere('last_name', "like", "%" . $result_search . "%")
            ->whereIn('id', $st)->withCount('message_admin')
            ->with('room.classes', 'user', 'details')->with('room')->skip($start)
            ->take($rowperpage)->get();


        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                'id' => $record->id,
                "first_name" => $record->first_name,
                "last_name" => $record->last_name,
                "student_id" => $record->id,
                "room" => $record->room,
                "created_at" => Carbon::parse($record->created_at)->toDateTimeString(),
                "message_admin_count" => $record->message_admin_count,
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



    public function payment_receipts()
    {
          $invoices = Image_Invoice::with('student')->get();
        return view('admin.payment_receipts', compact('invoices'));
    }


    public function delete_images_invoice(Request $request)
    {


        $image_invoice = Image_Invoice::find($request->id);

        if ($image_invoice->file != null) {

            Storage::disk('public')->delete($image_invoice->image);
        }
        $image_invoice->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }



    ////secret_keeper
    public function secret_keeper(Request $request)
    {
        $classes_roles = Classe_role_secret_keeper::where('role_id', auth()->user()->role_id)->get();
         $classroles = [];
        foreach ($classes_roles as $item) {
                $classroles[] = $item->class_id;
        };
        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::whereIn('id',$classroles)->get();
        return view('admin.secret_keeper', compact('year2', 'classes'));


    }
    public function getstudents_request_edit(Request $request)
    {
        $classes_roles = Classe_role_secret_keeper::where('role_id', auth()->user()->role_id)->get();
         $classroles = [];
        foreach ($classes_roles as $item) {
                $classroles[] = $item->class_id;
        };

         $request_edit=Modification_Request::with('student.room.classes')->with(['student.room' => function ($q1)  {
            $year = Year::where('current_year', '1')->first();
                $q1->where('room_student.year_id', $year->id);
        }])->WhereHas('student.room.classes' ,function($q) use ($classroles){
            $q->whereIn('id',$classroles);
        })->get();
        $classes = Classe::whereIn('id',$classroles)->get();
        $stages =Basic_stage:: all();
        return view('admin.getstudents_request_edit', compact('request_edit','classes','stages'));


    }
       public function filter_getstudents_request_edit(Request $request)
    {
        $class_filter=$request->classes;
        $room_filter=$request->room;
        $stage_id=$request->stage;
        $classes_roles = Classe_role_secret_keeper::where('role_id', auth()->user()->role_id)->get();
        $classroles = [];
        foreach ($classes_roles as $item) {
                $classroles[] = $item->class_id;
        };
        $class1=[];
         $stage =Basic_stages_class::where('stage_id',$stage_id)->get();
        foreach($stage as $item ){
            if(in_array($item->class_id,$classroles)){
                $class1[]=$item->class_id;
            }

        }
       return   $request_edit=Modification_Request::WhereHas('student.room.classes', function ($q) use ($class_filter, $room_filter,$stage_id,$class1,$classroles) {
            $year = Year::where('current_year', '1')->first();
            if ($class_filter != "" && $class_filter != null  && $class_filter != 0 && $room_filter != ""  && $room_filter != 0 && $room_filter != null) {
                $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter);
            } else if ($class_filter != "" && $class_filter != null && $class_filter != 0) {
                $q->where('classes.id', $class_filter);
            }
            else if ($stage_id != 0 && $stage_id != null) {
                $q->whereIn('classes.id', $class1);
            }
            else{
               $q->whereIn('id',$classroles) ;
            }
        })->with('student.room.classes')->with(['student.room' => function ($q1) use ($room_filter) {
            $year = Year::where('current_year', '1')->first();
            if ($room_filter != "" && $room_filter != null && $room_filter != 0) {
                $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
            } else {
                $q1->where('room_student.year_id', $year->id);
            }
        }])->get();



    }
    public function delete_request_edit(Request $request)
    {


        $request_edit = Modification_Request::find($request->id);

        $request_edit->delete();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function student_details1($student_id)
    {

        $year = Year::where('current_year', '1')->first();
        $student = Student::with(['room' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->with("user")->find($student_id);
        $room = $student->room;
        $student_detail = Student_detail::where('student_id', $student->id)->first();


        // if($room->isEmpty()){
        //     return redirect()->back();
        // }

        $student_mark = Students_mark::where('student_id', $student_id)->where('year_id', $year->id)->first();

        $lessons =  $room[0]->classes->lessons;
        $classes = Classe::all();
        $class_id = $student->room[0]->classes->id;
        $rooms = Room::where('class_id', $class_id)->where('year_id', $year->id)->get();
        //  return $student ;

        // $rooms=
          $student_details_departments=Student_details_department::with(['student_details_department_field.student_details_field_value' => function ($q1) use ($student_id) {
            $q1->where('student_id', $student_id);
        }])->get();
          $country_currency = Country_currency::where('active',1)->get();
        return view('admin.student_details1', compact('student_details_departments','country_currency','student', 'student_mark', 'lessons', 'classes', 'rooms', 'student_detail'));
    }

      public function student_details2($student_id)
    {

        $year = Year::where('current_year', '1')->first();
        $student = Student::with(['room' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->with("user")->find($student_id);
        $room = $student->room;
        $student_detail = Student_detail::where('student_id', $student->id)->first();


        // if($room->isEmpty()){
        //     return redirect()->back();
        // }

        $student_mark = Students_mark::where('student_id', $student_id)->where('year_id', $year->id)->first();

        $lessons =  $room[0]->classes->lessons;
        $classes = Classe::all();
        $class_id = $student->room[0]->classes->id;
        $rooms = Room::where('class_id', $class_id)->where('year_id', $year->id)->get();
        //  return $student ;

        // $rooms=
          $student_details_departments=Student_details_department::with(['student_details_department_field.student_details_field_value' => function ($q1) use ($student_id) {
            $q1->where('student_id', $student_id);
        }])->get();
          $country_currency = Country_currency::where('active',1)->get();
        return view('admin.student_details2', compact('student_details_departments','country_currency','student', 'student_mark', 'lessons', 'classes', 'rooms', 'student_detail'));
    }
    //تابع لارسال الاشعارات
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
    //  حذف موجه
     public function supervisore_delete(Request $request){

        $formed_code = Auth::User()->view_password;
        if ($formed_code == $request->delete_code) {

           $to_delete_class_lesson =  Supervisor_class_lesson ::where('supervisor_id', $request->supervisore_delete)->get();
           if($to_delete_class_lesson){
               foreach($to_delete_class_lesson as $item){
                   $item->delete();
               }
           }
            $to_delete_room_lesson =  Supervisor_room_lesson ::where('supervisor_id', $request->supervisore_delete)->get();
            if($to_delete_room_lesson){
               foreach($to_delete_room_lesson as $item2){
                   $item2->delete();
               }
            }
             $user = User::where('supervisor_id', $request->supervisore_delete)->first();
             $user->delete();
             Supervisor::findOrFail($request->supervisore_delete)->delete();


            return redirect()->back()->with('success', '! تمت العملية بنجاح');
        } else {
            return redirect()->back()->with('error', '! تأكد من الداتا البيانات  ');
        }
     }



     /// تنزيل كافة ملفات الطالب
      public function  all_documents ($student_id){
          $files = [];
       $student = Student::with("user")->find($student_id);

        $student_detail = Student_detail::where('student_id', $student->id)->first();

            if($student_detail->personal_image){
              $files['الصورة الشخصية'] = $student_detail->personal_image;
            }
             if($student_detail->mother_image){
              $files['صورة هوية الام'] = $student_detail->mother_image;
            }
             if($student_detail->father_image){
              $files['صورة هوية الاب'] = $student_detail->father_image;
            }
             if($student_detail->fourth_image){
                 $files['صورة اخراج القيد'] = $student_detail->fourth_image;
            }
             if($student_detail->passport){
                $files['صورة جواز السفر'] = $student_detail->passport;
            }
             if($student_detail->mather_page){
                 $files['جواز سفر الام'] = $student_detail->mather_page;
            } if($student_detail->father_page){
                  $files['جواز سفر الاب'] = $student_detail->father_page;
            } if($student_detail->study_sequence){
                $files['التسلسل الدراسي'] = $student_detail->study_sequence;
            }
            if($student_detail->family_book){
                $files['دفتر العائلة'] = $student_detail->family_book;
            }
            if($student_detail->certification){
                $files['اخر جلاء مدرسي'] = $student_detail->certification;
            }
            if($student_detail->certification_nine){
                $files['شهادة التاسع'] = $student_detail->certification_nine;
            }


      $fileName = '  كل الوثائق  '. $student->first_name . $student->last_name . '.zip';


    // Check if the file exists, and create it if it doesn't
    if (!file_exists(public_path($fileName))) {
            touch(public_path($fileName));
        } else {
            unlink(public_path($fileName));
        }
         if(count($files) ==0){
       Session::flash('error', '! لايوجد اي ملف مخزن من الطلاب  ');
          return redirect()->back();
     }

     else{
          $zip = new A;

    if ($zip->open(public_path($fileName), A::CREATE) === TRUE) {
        foreach ($files as $key=>$file) {

            $path =storage_path($file);
            $relativeName = basename($path);
            $extension = pathinfo($relativeName, PATHINFO_EXTENSION);

             // Generate a new unique name for the file
            $newName = $key. '.' .$extension;
            $zip->addFile($path,$newName);
        }

     $zip->close();
    }
     }


    return response()->download(public_path($fileName));

      }

       public function  getClassName ($report_card_design){

            $className = "";

            switch ($report_card_design) {
                case 5:
                    $className = "الأول الثانوي العام - الفرع العلمي";
                    break;
                case 6:
                    $className = "الأول الثانوي العام - الفرع الأدبي";
                    break;
                case 7:
                    $className = "الثاني الثانوي العام - الفرع العلمي";
                    break;
                case 8:
                    $className = "الثاني الثانوي العام - الفرع الأدبي";
                    break;
                case 9:
                    $className = "الثالث الثانوي العام - الفرع العلمي";
                    break;
                case 10:
                    $className = "الثالث الثانوي العام - الفرع الأدبي";
                    break;
                default:
                    $className = "الصف غير معرف";
                    break;
            }

            return $className ;

       }
          ///super
       public function admin_dashboard_supervisor() {

        $supervisor = Auth::user();
        $year=Year::where('current_year','1')->first();
        $classes = Classe::with(['room' => function ($query) use ($year) {
                $query->where("year_id", $year->id);
            }])->WhereHas('room' ,function($q) use ($year){
            $q->where('year_id',$year->id);
        })->get();
    //    $supervisor = Supervisor::with(['classes.room2'  =>  function ($query) use($supervisor_id){
    //                                        $query->where('supervisor_id', $supervisor_id);}])
    //                                ->find($supervisor_id);
    // //     $classes=$supervisor->with(['classes.room' => fn ($q1) => $q1->where('year_id', $year->id)])
    // //   ->orderBy('id')->get()->unique();
    //    $classes = $supervisor->classes->unique();

    //    foreach($classes as $class){
    //        $class->room3 = $class->room2 ->unique();
    //        unset( $class->room2);
    //    }


        return view('admin.supervisors.new_supervisor_index', compact('supervisor','classes'));
      }

      public function admin_supervisor_subjects($room_id)
        {

            $supervisor = Auth::user();

             $room_lessons = Room::find($room_id) ;
        //    $lessons =  $room_lessons->lessons;
            $room_lessons = [];

            $room = Room::find($room_id);
            $room_name = Room::find($room_id)->name;
            $class =Classe::where('id',$room->class_id );
            $lessons=Lesson::where('class_id',$room->class_id)->get();
            // $count2 = Supervisor_teacher_item::whereNull('view')->where('teacher_id', auth()->user()->teacher_id)->get();
            // $count2 = $count2->count();

            return view('admin.supervisors.new_supervisor_subjects', compact('room_name','lessons', 'supervisor', 'room_id','class'));
        }
        public function admin_supervisor_subjects_lectures ($lesson_id, $room_id)
        {

            $supervisor = Auth::user();



            $lesson = Lesson::find($lesson_id);
            $lectures = Lecture::where('room_id', $room_id)->where('lesson_id', $lesson_id)
             ->where('key','0')->where('active','0')->get();


            $class = Room::find($room_id)->classes;
            $room = Room::find($room_id);
            $now = Carbon::now();
            return view('admin.supervisors.new_subject_lectures', compact(
                'supervisor',
                'lectures',
                'lesson',
                'class',
                'room',
                'now'

            ));
        }
         public function admin_supervisor_lecture_content($lesson_id, $room_id, $lecture_id)
        {
            $supervisor = Auth::user();


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
           ->where('type', '8')->get();
            $additions = $book_details->where('type', '4');
            $super_file  = Super_file ::where('lecture_id', $lecture_id)->orderBy("id", 'desc')->get();
            $additions = $book_details->where('type', '4');

            $date = new DateTime();
            $now = $date->format('Y-m-d H:i:s');

            $class = Room::find($room_id)->classes;
            $class_id = Room::find($room_id)->id;
            $room = Room::find($room_id);

            $lecture = Lecture::find($lecture_id);
            return view('admin.supervisors.new_lecture_content', compact(
                'supervisor',
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
                'room',
                'super_file'

            ));
        }
        public function admin_supervisors_testfile($exam_id) {

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
        $supervisor=Auth::user();
           return view('admin.supervisors.testfile',compact('selected_ques1','selected_ques','supervisor','exam','class','room','term','lesson','class1','year'));
        }
           session()->flash('error', ' لم يتم اختيار أي سؤال لهذا الامتحان !! ');
           return redirect()->back();
        }

          /// edit25
    // صفحة حجب الطلاب عن المشرف
    public function hideStudentFromSupervisor()
    {
        $year2 = Year::where('current_year','1')->first();
        $classes = Classe::all();
        return view('admin.hide_student_from_supervisor',compact('year2','classes'));
    }
    public function hideStudentOfSupervisor(Request $request){
        // return $request ;
        $formed_code = Auth::User()->view_password;
        if ($formed_code == $request->password ){
         $x = Student::where('id',$request->student_id)->update(['hidden' => '1']);
         return redirect()->back()->with('success','تم إخفاء الطالب بنجاح');
        }else {
            return redirect()->back()->with('error','كلمة السر غير صحيحة');
        }
    }

    public function showStudentOfSupervisor(Request $request){

        $formed_code = Auth::User()->view_password;
        if ($formed_code == $request->password ){
         $x = Student::where('id',$request->student_id)->update(['hidden' => '0']);
         return redirect()->back()->with('success','تم إظهار الطالب بنجاح');
        }else {
            return redirect()->back()->with('error','كلمة السر غير صحيحة');
        }
    }
    public function getHiddenStudentsFromSupervisor(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $class_filter = $request->class_id;
        $room_filter = $request->room_id;
        $hidden_from_supervisor_filter = $request->hidden_from_supervisor;
        $search_bar = $request->barcode_pos_check;
        // $store = Store::where('quantity','>',0)->get();
        // foreach($store as $store_item){
        //     $ids[] = $store_item->product_id;
        // }

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%". $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }

       $totalRecords = Student::count();
        $totalRecordswithFilter = Student::where('hidden',$hidden_from_supervisor_filter)->where(function ($query) use ($class_filter,$room_filter,$result_search)  {
            // $query->where('activated', '=', $activated);
            $query->where('first_name',"like","%".$result_search."%")
            ->WhereHas('room.classes', function($q) use ($class_filter,$room_filter) {
                 $year = Year::where('current_year','1')->first();
                 if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                     $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
                 }else if($class_filter != "" && $class_filter != null){
                     $q->where('classes.id', $class_filter)->where('room_student.year_id',$year->id);
                 }
             })
            ->orwhere('last_name',"like","%".$result_search."%")
            ->WhereHas('room.classes', function($q) use ($class_filter,$room_filter) {
                  $year = Year::where('current_year','1')->first();
                 if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                     $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
                 }else if($class_filter != "" && $class_filter != null){
                     $q->where('classes.id', $class_filter)->where('room_student.year_id',$year->id);
                 }
           });
        })

        ->with('room.classes')->with(['room'=>function($q1) use($room_filter){
            $year = Year::where('current_year','1')->first();
            if($room_filter != "" && $room_filter != null ){
                $q1->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
            }else{
                $q1->where('room_student.year_id',$year->id);
            }
        }])->count();
        $records = Student::where('hidden',$hidden_from_supervisor_filter)->where(function ($query) use ($class_filter,$room_filter,$result_search)  {
            // $query->where('activated', '=', $activated);
            $query->where('first_name',"like","%".$result_search."%")
            ->WhereHas('room.classes', function($q) use ($class_filter,$room_filter) {
                 $year = Year::where('current_year','1')->first();
                 if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                     $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
                 }else if($class_filter != "" && $class_filter != null){
                     $q->where('classes.id', $class_filter)->where('room_student.year_id',$year->id);
                 }
             })
            ->orwhere('last_name',"like","%".$result_search."%")
            ->WhereHas('room.classes', function($q) use ($class_filter,$room_filter) {
                  $year = Year::where('current_year','1')->first();
                 if($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null ){
                     $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
                 }else if($class_filter != "" && $class_filter != null){
                     $q->where('classes.id', $class_filter)->where('room_student.year_id',$year->id);
                 }
           });
        })

        ->with('room.classes')->with(['room'=>function($q1) use($room_filter){
            $year = Year::where('current_year','1')->first();
            if($room_filter != "" && $room_filter != null ){
                $q1->where('rooms.id', $room_filter)->where('room_student.year_id',$year->id);
            }else{
                $q1->where('room_student.year_id',$year->id);
            }
        }])->skip($start)
        ->take($rowperpage)->get();

        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "hidden" => $record->hidden,
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

    //  النسب


    public function ministerial_and_financial_ratios()
    {
        $ratios = Rate::first();
        return view('admin.ministerial_and_financial_ratios',compact('ratios'));
    }
    public function update_ratios(Request $request)
    {

        $ratios = Rate::find($request->id);
        $ratios->ministerial = $request->ministerial;
        $ratios->financial = $request->financial;
        $ratios->save();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

    public function all_ratios()
    {
        $ratios = Rate::first();
       $rate=[];
       $cost=0;
         $student = Student::with('details')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->join('class_cost', function($join){
            $join->on('class_cost.country_id', '=', 'students.country_currency')
                 ->on('class_cost.class_id', '=', 'classes.id');
        }) ->join('countries_currencies', 'class_cost.country_id', '=', 'countries_currencies.id')
        ->select(DB::raw('students.*'),
        DB::raw('rooms.id as room_id'),
        DB::raw('classes.id as class_id '),
        DB::raw('classes.fixed_cost'),
        DB::raw('classes.name as classname'),
        DB::raw('class_cost.cost as cost'),
        DB::raw('countries_currencies.currency_country as key_country'),
        DB::raw('countries_currencies.name_ar as name_ar'))
        ->get() ->groupBy('name_ar');

       foreach($student as   $key=> $item ){
        $cost=0;

        $ra = new stdClass();
           foreach($item as    $val ){

              $cost = $cost + $val->cost;
              $key_country=$val->key_country;
           }
           $ra->cost=$cost;
          $ra->rate_ministerial=number_format($cost*($ratios->ministerial/100),1);
          $ra->rate_financial=number_format($cost*($ratios->financial/100),1);
          $ra->key_country=$key_country;
           $rate[$key]=$ra;

       }



        return view('admin.all_ratios',compact('rate'));
    }
    public function all_ratios_details()
    {

        $year2 = Year::where('current_year', '1')->first();
        $classes = Classe::all();
        return view('admin.all_ratios_details', compact('year2', 'classes'));
    }
     public function getstudentsfina_datails(Request $request)
{
    $class_filter = $request->class_id;
    $room_filter = $request->room_id;

    $date1  = $request->date1;

    $date2 = $request->date2;
    $draw = $request->draw;
    $start = $request->start;
    $rowperpage = $request->length; // Rows display per page

    $columnIndex_arr = $request->order;
    $columnName_arr = $request->columns;
    $search_arr = $request->search;
    $search_bar = $request->barcode_pos_check;

    $columnIndex = $columnIndex_arr[0]['column'];
    $columnIndex = $columnIndex > 2 ? 0 : $columnIndex;
    $array_of_sorting = ['first_name', 'last_name',]; // Column index
    $searchValue = $search_arr['value']; // Search value
    if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
        $searchValue = "";
    } else {
        $searchValue = explode('*', $searchValue);
    }
    $records = new Collection;
    // $searchValue = array_filter($searchValue, 'strlen');
    $result_search = "";
    foreach ($searchValue as $key => $item_search) {
        if ($key == 0) {
            $result_search = "%" . $item_search . "%";
        } else {
            $result_search .= "%" . $item_search . "%";
        }
    }
    $year1 = Year::where('current_year', '1')->first();

    // $totalRecordswithFilter
    $ratios = Rate::first();
    $rate=[];
    $cost=0;

    $student = Student::
      WhereHas('room.classes', function ($q) use ($class_filter, $room_filter) {
        $year = Year::where('current_year', '1')->first();
        if ($class_filter != "" && $class_filter != null && $room_filter != "" && $room_filter != null) {
            $q->where('classes.id', $class_filter)->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
        } else if ($class_filter != "" && $class_filter != null) {
            $q->where('classes.id', $class_filter);
        }
    })->WhereHas('invoices', function ($q) use ($date1, $date2,$year1) {
        $q->where('invoices.year_id', $year1->id);

        if ($date1 != "" && $date1 != null && $date2 != "" && $date2 != null) {
            $q->whereBetween('invoices.updated_at', [$date1 . " 00:00:00", $date2 . " 23:59:59"]);
        }
    })->with('details')

    ->with(['room' => function ($q1) use ($room_filter) {
        $year = Year::where('current_year', '1')->first();
        if ($room_filter != "" && $room_filter != null) {
            $q1->where('rooms.id', $room_filter)->where('room_student.year_id', $year->id);
        } else {
            $q1->where('room_student.year_id', $year->id);
        }
    }])
    ->with(['invoices' => function ($q1)  use ($date1, $date2)  {
        $year = Year::where('current_year', '1')->first();
        if ($date1 != "" && $date1 != null && $date2 != "" && $date2 != null) {
            $q1->whereBetween('invoices.updated_at', [$date1 . " 00:00:00", $date2 . " 23:59:59"]);
        }
    }])

    ->join('room_student', 'room_student.student_id', '=', 'students.id')
    ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
    ->where('rooms.year_id', $year1->id)
    ->join('classes', 'rooms.class_id', '=', 'classes.id')
    ->join('class_cost', function($join){
        $join->on('class_cost.country_id', '=', 'students.country_currency')
             ->on('class_cost.class_id', '=', 'classes.id');
    })
     ->join('countries_currencies', 'class_cost.country_id', '=', 'countries_currencies.id')
    ->select(DB::raw('students.*'),
    DB::raw('rooms.id as room_id'),
    DB::raw('classes.id as class_id '),
    DB::raw('classes.fixed_cost'),
    DB::raw('classes.name as classname'),
    DB::raw('class_cost.cost as cost'),
    DB::raw('countries_currencies.currency_country as key_country'),
    DB::raw('countries_currencies.name_ar as name_ar'))
    ->get() ->groupBy('name_ar');
    $count=0;
    foreach($student as   $key=> $item ){
        $cost=0;
        $count=+1;
        $ra = new stdClass();
           foreach($item as    $val ){
            foreach($val->invoices as    $val1 ){
              $cost = $cost + $val1->invoice_amount;

           }
           $key_country=$val->key_country;
        }

           $ra->cost=$cost;
          $ra->rate_ministerial=number_format($cost*($ratios->ministerial/100),1);
          $ra->rate_financial=number_format($cost*($ratios->financial/100),1);
          $ra->key_country=$key_country;
           $rate[$key]=$ra;

       }

       $totalRecordswithFilter=$count;
        $records=$rate;
    $totalRecords = Student::count();

    $data_arr = array();

    foreach ($records as    $key=>$record) {

        $data_arr[] = array(

            "key" => $key,
            "cost" => $record->cost,
            "key_country" => $record->key_country,
            "rate_ministerial" => $record->rate_ministerial,
            "rate_financial" => $record->rate_financial,

        );
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr,
        "$result_search" => $result_search
    );
    echo json_encode($response);
    exit;
}
   //  المراحل

 public function basic_stage()
 {

     $stage=Basic_stage::with('basic_stages_classes.classes')->paginate(paginate_num);
     $classes = Classe::all();
     $count = Basic_stage::count();
     return view('admin.basic_stage', compact('stage', 'classes','count'));
 }
 public function add_stage(Request $request)
    {

        $stage = new  Basic_stage();
        $stage->name = $request->name;
        $stage->save();
        foreach($request->classes as $class){
            $stage_class = new  Basic_stages_class();
            $stage_class->stage_id = $stage->id;
            $stage_class->class_id = $class;
            $stage_class->save();

        }
         return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    public function edit_stage(Request $request)
    {

        $stage = Basic_stage::find( $request->id);
        $stage->name = $request->name;
        $stage->save();
        Basic_stages_class::where('stage_id',$stage->id)->delete();
        foreach($request->classes as $class){
            $stage_class = new  Basic_stages_class();
            $stage_class->stage_id = $stage->id;
            $stage_class->class_id = $class;
            $stage_class->save();

        }
         return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }
    //class_stage

    public function stages_class($id)
    {
         $class=[];
         if($id != 0){
            $stage = Basic_stage::find($id);
            $basic_stage= Basic_stages_class::where('stage_id',$stage->id)->get();
            foreach($basic_stage as $item){
                $class[]=$item->class_id;
            }

            $classes = Classe::whereIn('id',$class)->get();
         }
         else{
            $classes = Classe::all();
         }

        return  $classes;
    }
     public function stages_class_secret($id)
    {     $classes_roles = Classe_role_secret_keeper::where('role_id', auth()->user()->role_id)->get();
         $classroles = [];
        foreach ($classes_roles as $item) {
                $classroles[] = $item->class_id;
        };
         $class=[];
         if($id != 0){
            $stage = Basic_stage::find($id);
            $basic_stage= Basic_stages_class::where('stage_id',$stage->id)->get();
            foreach($basic_stage as $item){
                if (in_array($item->class_id, $classroles))
                {
                   $class[]=$item->class_id;
                }

            }

            $classes = Classe::whereIn('id',$class)->get();
         }
         else{
            $classes = Classe::whereIn('id',$classroles)();
         }

        return  $classes;
    }
       ///archive


   public function archives()
   {

       return view('admin.archives');
   }
   public function archives_students()
   {
       $years=Year::all();
       return view('admin.archives_students',compact('years'));
   }



   public function archive_student_year(Request $request)
   {
    $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;

        $search_bar = $request->barcode_pos_check;
        $columnIndex = $columnIndex_arr[0]['column'];
        $columnIndex = $columnIndex > 2 ? 0 : $columnIndex;
        $array_of_sorting = ['first_name', 'last_name',]; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }
       $year=Year::find($request->year_id);
       if(in_array("student_hidden", Auth::user()->role->permissions)){


        $totalRecordswithFilter= Student::
        where('first_name', "like", "%" . $result_search . "%")->
        WhereHas('room', function ($q) use ($year) {

            if ($year != "" && $year != 'null' ) {
                $q->where('room_student.year_id', $year->id);
            }
        })
      ->with('details')->where('hidden',0)->
      orwhere('last_name', "like", "%" . $result_search . "%")->
      WhereHas('room', function ($q) use ($year) {

        if ($year != "" && $year != 'null' ) {
            $q->where('room_student.year_id', $year->id);
        }
         })
      ->with('details')->where('hidden',0)-> with('room.classes')->with(['room'=>function($q1) use($year){


        $q1->where('room_student.year_id',$year->id);

}]) ->with(['invoices'=>function($q1) use($year){


    $q1->where('invoices.year_id',$year->id);

}])


         ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
         ->select(DB::raw('students.*'),
        DB::raw('countries_currencies.currency_country as key_country'),
     )

        ->count();
           $records = Student::where('first_name', "like", "%" . $result_search . "%")
       ->WhereHas('room', function ($q) use ($year) {
           if ($year != "" && $year != 'null' ) {
               $q->where('room_student.year_id', $year->id);
           }
       })
       ->with('details')
       ->where('hidden', 0)
       ->orWhere('last_name', "like", "%" . $result_search . "%")
       ->WhereHas('room', function ($q) use ($year) {
           if ($year != "" && $year != 'null' ) {
               $q->where('room_student.year_id', $year->id);
           }
       })
       ->with('details')
       ->where('hidden', 0)
       ->with('room.classes')
       ->with(['room' => function ($q1) use ($year) {
           $q1->where('room_student.year_id', $year->id);
       }]) ->with(['invoices'=>function($q1) use($year){


        $q1->where('invoices.year_id',$year->id);

    }])


       ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')

       ->select(DB::raw('students.*'),
                DB::raw('countries_currencies.currency_country as key_country'),
              )
       ->groupBy('students.id')
 // Move the where condition here
       ->skip($start)
       ->take($rowperpage)
       ->get();
}
else{

    $totalRecordswithFilter= Student::   where('first_name', "like", "%" . $result_search . "%")->
    WhereHas('room', function ($q) use ($year) {

        if ($year != "" && $year != 'null' ) {
            $q->where('room_student.year_id', $year->id);
        }
    })
  ->with('details')->
  orwhere('last_name', "like", "%" . $result_search . "%")->
  WhereHas('room', function ($q) use ($year) {

    if ($year != "" && $year != 'null' ) {
        $q->where('room_student.year_id', $year->id);
    }
     })
  ->with('details')-> with('room.classes')->with(['room'=>function($q1) use($year){


    $q1->where('room_student.year_id',$year->id);

}]) ->with(['invoices'=>function($q1) use($year){


    $q1->where('invoices.year_id',$year->id);

}])

     ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
    ->select(DB::raw('students.*'),

    DB::raw('countries_currencies.currency_country as key_country'),
       )

    ->count();
    $records = Student::   where('first_name', "like", "%" . $result_search . "%")->
    WhereHas('room', function ($q) use ($year) {

        if ($year != "" && $year != 'null' ) {
            $q->where('room_student.year_id', $year->id);
        }
    })  ->with('details')->
  orwhere('last_name', "like", "%" . $result_search . "%")->
  WhereHas('room', function ($q) use ($year) {

    if ($year != "" && $year != 'null' ) {
        $q->where('room_student.year_id', $year->id);
    }
     })->
     with('room.classes')->with(['room'=>function($q1) use($year){


            $q1->where('room_student.year_id',$year->id);

    }])
  ->with('details')
  ->with(['invoices'=>function($q1) use($year){


    $q1->where('invoices.year_id',$year->id);

}])
    ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
    ->select(DB::raw('students.*'),
    DB::raw('countries_currencies.currency_country as key_country'),
      )
    ->groupBy('students.id')
    ->skip($start)
        ->take($rowperpage)->get();
}



            $totalRecords = Student::count();

            $data_arr = array();
            foreach ($records as $record) {
                $total=0;
                foreach ($record->invoices as $invoice) {
                    $total= $total +$invoice->invoice_amount;
                }

            $data_arr[] = array(
                "hidden" => $record->hidden,
                "first_name" => $record->first_name,
                "last_name" => $record->last_name,
                "address" => $record->address,
                "phone" => $record->phone,
                "img" => $record->image,
                "room" => $record->room ,
                "classname" => $record->room[0]->classes->name ,
                "id" => $record->id ,
                "user"=>$record->user,
                "key_country"=>$record->key_country,
                "total"=>$total,
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

public function archives_students_details($student_id)
{


    $year = Year::where('current_year', '1')->first();
    $student = Student::with(['room' => fn ($q1) => $q1->where('room_student.year_id', $year->id)])->with("user")->find($student_id);
    $room = $student->room;
    $student_detail = Student_detail::where('student_id', $student->id)->first();


    // if($room->isEmpty()){
    //     return redirect()->back();
    // }

    $student_mark = Students_mark::where('student_id', $student_id)->where('year_id', $year->id)->first();

    $lessons =  $room[0]->classes->lessons;
    $classes = Classe::all();
    $class_id = $student->room[0]->classes->id;
    $rooms = Room::where('class_id', $class_id)->where('year_id', $year->id)->get();
    //  return $student ;

    // $rooms=
    $country_currency = Country_currency::where('active',1)->get();
    return view('admin.archives_students_details', compact('country_currency','student', 'student_mark', 'lessons', 'classes', 'rooms', 'student_detail'));
}


public function archives_teacher()
{
    $years=Year::all();
    return view('admin.archives_teacher',compact('years'));
}
public function archive_teacher_year(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $rowperpage = $request->length; // Rows display per page

        $columnIndex_arr = $request->order;
        $columnName_arr = $request->columns;
        $search_arr = $request->search;
        $search_bar = $request->barcode_pos_check;
        $class_filter = $request->classes;
        $room_filter = $request->rooms;

        // $store = Store::where('quantity','>',0)->get();
        // foreach($store as $store_item){
        //     $ids[] = $store_item->product_id;
        // }

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnIndex = $columnIndex > 2 ? 0 : $columnIndex;
        $array_of_sorting = ['first_name', 'last_name',]; // Column index
        $searchValue = $search_arr['value']; // Search value
        if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
            $searchValue = "";
        } else {
            $searchValue = explode('*', $searchValue);
        }
        $records = new Collection;
        // $searchValue = array_filter($searchValue, 'strlen');
        $result_search = "";
        foreach ($searchValue as $key => $item_search) {
            if ($key == 0) {
                $result_search = "%" . $item_search . "%";
            } else {
                $result_search .= "%" . $item_search . "%";
            }
        }
        $year=Year::find($request->year_id);
        $totalRecords = Teacher::count();

        $totalRecordswithFilter = Teacher::whereHas('rooms.classes', function ($q) use ($year) {

            if ( $year != "" && $year != null) {
                $q->where('rooms.year_id', $year->id);
            }
        })->where(function ($q) use ($result_search) {
            $q->where('first_name', "like", "%" . $result_search . "%")->orwhere('last_name', "like", "%" . $result_search . "%");
        })->count();
        $records = Teacher::whereHas('rooms.classes', function ($q) use ($year) {

            if ( $year != "" && $year != null) {
                $q->where('rooms.year_id', $year->id);
            }
        })->where(function ($q) use ($result_search) {
            $q->where('first_name', "like", "%" . $result_search . "%")->orwhere('last_name', "like", "%" . $result_search . "%");
        })->with('user')->skip($start)->take($rowperpage)->orderBy($array_of_sorting[$columnIndex], $columnIndex_arr[0]['dir'])->get();


        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "first_name" => $record->first_name,
                "last_name" => $record->last_name,
                "address" => $record->address,
                "date_birth" => $record->date_birth,
                "image" => $record->image,
                "id" => $record->id,
                "phone" => $record->phone,
                "Description_ar" => $record->Description_ar,
                "Description_en" => $record->Description_en,
                "type" => $record->type,
                "user" => $record->user,
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

    public function teacher_archive(Request $request)
    {

        $teacher = Teacher::find ($request->archive_id);
        $teacher->date_archive =$request->date_archive ;
        $teacher->active =1 ;
        $teacher->save();
        Session::flash('success', '! تمت العملية بنجاح');
        return redirect()->back();
    }


///  المشرف ملفات


public function  add_super_file(Request $request)
{
     $term = Term_year::where('current_term', '1')->first();
    $file = new Super_file ();
    $file->type=$request->type;
    if( !$request->file->extension()){
        return redirect()->back()->with('message', 'هناك خطأ بالملف المدخل ');
         }
    if ($request->hasFile('file')) {

        $file->file = $request->file->store('teachersimage', 'public');
    }
    $file->extension =  $request->file->extension();
    $file->user_id=auth()->id();
    $file->name=$request->name;
    $file->lesson_id=$request->lesson_id;
    $file->lecture_id=$request->lecture_id;
    $file->room_id=$request->room_id;
    $file->save();
    $room = Room::find($request->room_id);
     $students = $room->student;
    foreach($students as $student){

        $noti = new Notification;
        $noti->user_id = Auth::user()->id;
        $noti->lesson_id = $request->lesson_id;
        $noti->student_id = $student->id;
        $noti->lecture_id = $request->lecture_id;
        $noti->room_id = $request->room_id;
        $noti->title ="تم اضافة ملفات وزارية";
        $noti->body = $request->name;
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
    Session::flash('success', '! تمت العملية بنجاح');
    return redirect()->back();
}
public function delete_super_file(Request $request){
    $file =  Super_file ::find($request->id);
    Storage::disk('public')->delete($file->file);
    $file->delete();
    Session::flash('success', '! تمت  الحذف بنجاح');
    return redirect()->back();
}
///  اقسام البناء
public function construction_departments(Request $request){
    $construction_departments=Construction_department::paginate(paginate_num);
    $count = Construction_department::count();
    return view('admin.construction_departments', compact('construction_departments','count'));
}
public function construction_departments_store(Request $request){
         $this->validate($request, [
            'name' => 'required',
        ],[
            'name.require' => 'يرجى إدخال الاسم ',
        ]);
        $construction_departments=  new Construction_department ();
        $construction_departments->name=$request->name;
        $construction_departments->save();
        Session::flash('success', '! تمت العملية بنجاح');
        return redirect()->back();

}
public function construction_departments_update(Request $request){
    $this->validate($request, [
       'name' => 'required',
   ],[
       'name.require' => 'يرجى إدخال الاسم ',
   ]);
   $construction_departments= Construction_department::find($request->id);
   $construction_departments->name=$request->name;
   $construction_departments->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function department_details($construction_department_id){
     $departments_detail=Department_detail::with('construction_department')->where('construction_department_id',$construction_department_id)->paginate(paginate_num);
    $count = Department_detail::count();
    return view('admin.department_details', compact('departments_detail','count','construction_department_id'));
}
public function department_details_store(Request $request){
    $this->validate($request, [
       'name' => 'required',
       'quantity' => 'required',
       'description' => 'required',
       'construction_department_id' => 'required',
   ],[
       'name.require' => 'يرجى إدخال الاسم ',
       'quantity.require' => 'يرجى إدخال  الكمية ',
       'description.require' => 'يرجى إدخال   الوصف ',
       'construction_department_id.require' => 'هناك خطأ لايمكن الادخال      ',
   ]);
   $departments_detail= new Department_detail () ;
   $departments_detail->name=$request->name;
   $departments_detail->description=$request->description;
   $departments_detail->quantity=$request->quantity;
   $departments_detail->construction_department_id=$request->construction_department_id;
   if ($request->hasFile('file')) {

        $departments_detail->file = $request->file->store('teachersimage', 'public');
    }

   $departments_detail->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function department_details_update(Request $request){
    $this->validate($request, [
       'name' => 'required',
       'quantity' => 'required',
       'description' => 'required',
   ],[
       'name.require' => 'يرجى إدخال الاسم ',
       'quantity.require' => 'يرجى إدخال  الكمية ',
       'description.require' => 'يرجى إدخال   الوصف ',
   ]);
   $departments_detail=  Department_detail ::find($request->id) ;
   $departments_detail->name=$request->name;
   $departments_detail->description=$request->description;
   $departments_detail->quantity=$request->quantity;
   if ($request->hasFile('file')) {

        $departments_detail->file = $request->file->store('teachersimage', 'public');
    }
   $departments_detail->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function department_details_delete(Request $request){
    $file = Department_detail ::find($request->id);
     Storage::disk('public')->delete($file->file);
    $file->delete();
    Session::flash('success', '! تمت  الحذف بنجاح');
    return redirect()->back();
}
public function construction_departments_delete(Request $request){

    $construction_department= Construction_department::find($request->id);
    $departments_detail = Department_detail ::where('construction_department_id',$construction_department->id)->get();
    foreach($departments_detail as $item){
         Storage::disk('public')->delete($item->file);
        $item->delete();
    }

    $construction_department->delete();
    Session::flash('success', '! تمت  الحذف بنجاح');
    return redirect()->back();
}


      public function import_employe(){

        return view('admin.import_employe');
    }

 public function employeesimport(Request $request)
    {
        // if ($request->hasFile('file')) {

        //     $file = $request->file;
        // }
        $file = $request->file('file')->store('files');
        // $ = Input::file('file');
        set_time_limit(10000);
        ini_set('memory_limit', '-1');
       if($request->file->extension() !='xlsx'){
         return redirect()->back()->with('error', 'يرجى ادخال ملف اكسل  !');
       }
       try{
          Excel::import(new EmployeeImport(), $file);
           return redirect()->back()->with('success', 'employees imported successfully!');
       }
       catch (\Exception $e) {
            return redirect()->back()->with('error', ' يرجى ادخال معلومات  الاكسل بشكل صحيح  !');

        }



}
/////  اقسام الطالب
public function student_details_department(Request $request){
    $student_details_department=Student_details_department::paginate(paginate_num);
    $count = Student_details_department::count();
    return view('admin.student_details_department', compact('student_details_department','count'));


}
public function student_details_department_store(Request $request){
    $this->validate($request, [
       'name' => 'required',
   ],[
       'name.require' => 'يرجى إدخال الاسم ',
   ]);
   $student_details_department=  new Student_details_department ();
   $student_details_department->name=$request->name;
   $student_details_department->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function student_details_department_update(Request $request){
    $this->validate($request, [
       'name' => 'required',
   ],[
       'name.require' => 'يرجى إدخال الاسم ',
   ]);
   $student_details_department= Student_details_department::find($request->id);
   $student_details_department->name=$request->name;
   $student_details_department->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function student_details_department_fields($student_details_department_id){
    $student_details_department_fields=Student_details_department_field::with('student_details_department')->where('student_details_department_id',$student_details_department_id)->paginate(paginate_num);
   $count = Student_details_department_field::count();
   return view('admin.student_details_department_fields', compact('student_details_department_fields','count','student_details_department_id'));
}
public function student_details_department_fields_store(Request $request){
    $this->validate($request, [
       'name' => 'required',
       'type' => 'required',

   ],[
       'name.require' => 'يرجى إدخال الاسم ',
       'type.require' => 'يرجى إدخال    النوع ',
   ]);
   $student_details_department_fields=   new Student_details_department_field () ;
   $student_details_department_fields->name=$request->name;
   $student_details_department_fields->type=$request->type;
   if($request->type_radio){
    $student_details_department_fields->type_radio=json_encode($request->type_radio);
   }
   $student_details_department_fields->student_details_department_id=$request->student_details_department_id;
   $student_details_department_fields->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function student_details_department_fields_update(Request $request){
    $this->validate($request, [
       'name' => 'required',
       'type' => 'required',

   ],[
       'name.require' => 'يرجى إدخال الاسم ',
       'type.require' => 'يرجى إدخال    النوع ',
   ]);
   $student_details_department_fields= Student_details_department_field::find($request->id) ;
   $student_details_department_fields->name=$request->name;
   $student_details_department_fields->type=$request->type;
   if($request->type_radio){
    $student_details_department_fields->type_radio=json_encode($request->type_radio);
   }

   $student_details_department_fields->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function student_details_department_fields_delete(Request $request){

    $student_details_department_fields= Student_details_department_field::find($request->id);
    Student_details_field_value::where('student_details_field_id',$request->id)->delete();
    $student_details_department_fields->delete();
    Session::flash('success', '! تمت  الحذف بنجاح');
    return redirect()->back();
}
public function student_details_department_delete(Request $request){
    $student_details_department= Student_details_department::find($request->id);
    $student_details_department_fields= Student_details_department_field::where('student_details_department_id',$request->id)->get();

    foreach($student_details_department_fields as $item){
        Student_details_field_value::where('student_details_field_id',$item->id)->delete();
        $item->delete();
    }

    $student_details_department->delete();
    Session::flash('success', '! تمت  الحذف بنجاح');
    return redirect()->back();
}
///  اقسام الاستاذ
public function teacher_details_departments(Request $request){
    $teacher_details_department=Teacher_details_department::paginate(paginate_num);
    $count = Teacher_details_department::count();
    return view('admin.teacher_details_departments', compact('teacher_details_department','count'));


}
public function teacher_details_department_store(Request $request){
    $this->validate($request, [
       'name' => 'required',
   ],[
       'name.require' => 'يرجى إدخال الاسم ',
   ]);
   $teacher_details_department=  new Teacher_details_department ();
   $teacher_details_department->name=$request->name;
   $teacher_details_department->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function teacher_details_department_update(Request $request){
    $this->validate($request, [
       'name' => 'required',
   ],[
       'name.require' => 'يرجى إدخال الاسم ',
   ]);
   $teacher_details_department= Teacher_details_department::find($request->id);
   $teacher_details_department->name=$request->name;
   $teacher_details_department->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}


public function teacher_details_department_fields($teacher_details_department_id){
    $teacher_details_department_fields=Teacher_details_department_field::with('teacher_details_department')->where('teacher_details_department_id',$teacher_details_department_id)->paginate(paginate_num);
   $count = Teacher_details_department_field::count();
   return view('admin.teacher_details_department_fields', compact('teacher_details_department_fields','count','teacher_details_department_id'));
}
public function teacher_details_department_fields_store(Request $request){
    $this->validate($request, [
       'name' => 'required',
       'type' => 'required',

   ],[
       'name.require' => 'يرجى إدخال الاسم ',
       'type.require' => 'يرجى إدخال    النوع ',
   ]);
   $teacher_details_department_fields=   new Teacher_details_department_field () ;
   $teacher_details_department_fields->name=$request->name;
   $teacher_details_department_fields->type=$request->type;
   if($request->type_radio){
    $teacher_details_department_fields->type_radio=json_encode($request->type_radio);
   }
   $teacher_details_department_fields->teacher_details_department_id=$request->teacher_details_department_id;
   $teacher_details_department_fields->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function teacher_details_department_fields_update(Request $request){
    $this->validate($request, [
       'name' => 'required',
       'type' => 'required',

   ],[
       'name.require' => 'يرجى إدخال الاسم ',
       'type.require' => 'يرجى إدخال    النوع ',
   ]);
   $teacher_details_department_fields= Teacher_details_department_field::find($request->id) ;
   $teacher_details_department_fields->name=$request->name;
   $teacher_details_department_fields->type=$request->type;
   if($request->type_radio){
    $teacher_details_department_fields->type_radio=json_encode($request->type_radio);
   }

   $teacher_details_department_fields->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function teacher_details_department_fields_delete(Request $request){

    $teacher_details_department_fields= Teacher_details_department_field::find($request->id);
    Teacher_details_field_value::where('teacher_details_field_id',$request->id)->delete();
    $teacher_details_department_fields->delete();
    Session::flash('success', '! تمت  الحذف بنجاح');
    return redirect()->back();
}


public function teacher_details($id)
{

    $teacher = Teacher::find($id);
    $teacher_details_departments=Teacher_details_department::with(['teacher_details_department_field.teacher_details_field_value' => function ($q1) use ($id) {
        $q1->where('teacher_id', $id);
    }])->get();
    return view('admin.teacher_details', compact('teacher','teacher_details_departments'));
}


public function teacher_details_department_delete(Request $request){
    $teacher_details_department=  Teacher_details_department::find($request->id);
    $teacher_details_department_fields=  Teacher_details_department_field::where('teacher_details_department_id',$request->id)->get();

    foreach($teacher_details_department_fields as $item){
        Teacher_details_field_value::where('teacher_details_field_id',$item->id)->delete();
        $item->delete();
    }

    $teacher_details_department->delete();
    Session::flash('success', '! تمت  الحذف بنجاح');
    return redirect()->back();
}
public function export_students_detail(){

    $classes = Classe::all();
    $stages =Basic_stage:: all();
    return view('admin.export_students_detail', compact('classes','stages'));

}
public function export_student_detail_page(Request $request){
    if(!$request->fields){
        Session::flash('error', '!  لايوجد حقول مختارة ');
        return redirect()->back();
    }
    $fields= $request->fields;

    set_time_limit(100000);
        ini_set("max_execution_time", "-1");
        ini_set('memory_limit','-1');


        $year = Year::where('current_year',1)->first();
        if($request->stage == 0 &&  $request->classes==0 && $request->rooms==0 ){
            $classes_id=[];
            $classes = Classe::all();
            foreach($classes as $classe){
              $classes_id[]= $classe->id;
            }
          $students = DB::table('students')
      ->join('student_details', 'student_details.student_id', '=', 'students.id')
      ->join('room_student', 'room_student.student_id', '=', 'students.id')
      ->join('users', 'users.student_id', '=', 'students.id')
      ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
      ->join('classes', 'rooms.class_id', '=', 'classes.id')
      ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
      ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
      'students.date_birth','student_details.phone','students.address','countries_currencies.name_ar as country',DB::raw('(CASE
      WHEN students.religion = "0" THEN "مسلم"
      ELSE "مسيحي"
      END) AS religion') , DB::raw('(CASE
      WHEN students.lang = "0" THEN "فرنسي"
      ELSE "روسي"
      END) AS lang') ,DB::raw('(CASE
        WHEN classes.stage_id = 3 THEN (CASE WHEN students.lang = "0" THEN "فرنسي " ELSE "روسي " END)
        ELSE (CASE WHEN students.lang = "0" THEN " " ELSE " " END)
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
      ->where('room_student.year_id',$year->id)
      ->whereIn('classes.id',$classes_id)
      ->get();

      }
        elseif($request->classes==0 && $request->rooms==0 ){
            $classes_id=[];
              $classes = Basic_stages_class::where('stage_id',$request->stage)->get();
              foreach($classes as $classe){
                $classes_id[]= $classe->class_id;
              }

           $students = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address','countries_currencies.name_ar as country',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN " "
        ELSE " "
        END) AS lang')
        , DB::raw('(CASE
        WHEN classes.stage_id = 3 THEN (CASE WHEN students.lang = "0" THEN "فرنسي " ELSE "روسي " END)
        ELSE (CASE WHEN students.lang = "0" THEN " " ELSE " " END)
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->whereIn('classes.id',$classes_id)
        ->get();





        }
        elseif($request->classes!=0 && $request->rooms==0 ){
             $room_id=[];
              $rooms = Room::where('class_id',$request->classes)->get();
              foreach($rooms as $room){
                $room_id[]= $room->id;
              }
               $classes = Classe::find($request->classes);

              if($classes->stage_id==3){
                   $students = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address','countries_currencies.name_ar as country',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN "فرنسي"
        ELSE "روسي"
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->where('classes.id',$request->classes)
        ->whereIn('rooms.id',$room_id)

        ->get();
              }
              else{
                   $students = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address','countries_currencies.name_ar as country',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN " "
        ELSE " "
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->where('classes.id',$request->classes)
        ->whereIn('rooms.id',$room_id)

        ->get();
              }


        }
        else{

                $classes = Classe::find($request->classes);

              if($classes->stage_id==3){
                   $students = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address','countries_currencies.name_ar as country',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN "فرنسي"
        ELSE "روسي"
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->where('classes.id','like',$request->classes)
        ->where('rooms.id','like',$request->rooms)

        ->get();
              }
              else{
                   $students = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('users', 'users.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
        ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','student_details.phone','students.address','countries_currencies.name_ar as country',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN " "
        ELSE " "
        END) AS lang') ,'users.email','users.view_password','classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->where('classes.id','like',$request->classes)
        ->where('rooms.id','like',$request->rooms)

        ->get();
              }


        }



    return view('admin.export_student_detail_page', compact('students','fields'));

}
//  المكافأت والعقوبات
public function Rewards_and_sanctions(){

    return view('admin.Rewards_and_sanctions');

}
public function rewards(){

    $rewards = Rewards_and_sanction::where('type',1)->get();

    return view('admin.rewards', compact('rewards'));

}
public function sanctions(){

    $sanctions = Rewards_and_sanction::where('type',2)->get();

    return view('admin.sanctions', compact('sanctions'));

}
public function rewards_and_sanction_store(Request $request){
    $this->validate($request, [
       'name' => 'required',
       'type' => 'required',

   ],[
       'name.require' => 'يرجى إدخال الاسم ',
    ]);
   $rewards_and_sanction= new Rewards_and_sanction ;
   $rewards_and_sanction->name=$request->name;
   $rewards_and_sanction->type=$request->type;

   if ($request->hasFile('image')) {

    $rewards_and_sanction->image = $request->image->store('teachersimage', 'public');
}
   $rewards_and_sanction->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function rewards_and_sanction_update(Request $request){
    $this->validate($request, [
       'name' => 'required',

   ],[
       'name.require' => 'يرجى إدخال الاسم ',
    ]);
   $rewards_and_sanction=  Rewards_and_sanction ::find($request->id);;
   $rewards_and_sanction->name=$request->name;
   if ($request->hasFile('image')) {
    if ($rewards_and_sanction->image != null) {

        Storage::disk('public')->delete($rewards_and_sanction->image);
    }
    $rewards_and_sanction->image = $request->image->store('teachersimage', 'public');
}
   $rewards_and_sanction->save();
   Session::flash('success', '! تمت العملية بنجاح');
   return redirect()->back();

}
public function rewards_and_sanction_delete(Request $request){

    $rewards_and_sanction= Rewards_and_sanction::find($request->id);
    if ($rewards_and_sanction->image != null) {

        Storage::disk('public')->delete($rewards_and_sanction->image);
    }
     $rewards_and_sanction_student=Rewad_and_sanction_student::where('rewad_and_sanction_id',$request->id)->get();
    foreach($rewards_and_sanction_student as $item){

        $item->delete();
    }

    $rewards_and_sanction->delete();
    Session::flash('success', '! تمت  الحذف بنجاح');
    return redirect()->back();
}
//  مشرف وزاري مكافأت وعقوبات
public function supervisor_rewads()
{
    $term = Term_year::where('current_term', 1)->first();
    $year = Year::where('current_year', '1')->first();
    $rewads = Rewad_and_sanction_student::with('lesson')->where('type', 1)->where('term_id', $term->id)->orderBy('updated_at', 'desc')->get();
    $supervisor = Auth::user();
    $classes=Classe::all();
    return view('admin.supervisors.supervisor_rewads', compact( 'classes','supervisor','rewads','year'));
}
public function supervisor_sanctions(Request $request)
{
    $term = Term_year::where('current_term', 1)->first();
    $year = Year::where('current_year', '1')->first();
    $rewads = Rewad_and_sanction_student::with('lesson')->where('type', 2)->where('term_id', $term->id)->orderBy('updated_at', 'desc')->get();
    $supervisor = Auth::user();
    $classes=Classe::all();
    return view('admin.supervisors.supervisor_sanctions', compact( 'classes','supervisor','rewads','year'));
}

public function filter_rewads(Request $request){
      $classes=Classe::all();
      $class =[];
      foreach($classes as $item){
       $class[]= $item->id;
    }

    $term = Term_year::where('current_term', 1)->first();
    return Rewad_and_sanction_student::whereHas('room.classes' , function ($q) use($request,$class) {
        $year = Year::where('current_year', '1')->first();
        if ($request->class != "" && $request->class != null && $request->room != "" && $request->room != null) {
            $q->where('classes.id', $request->class)->where('rooms.id', $request->room)->where('rooms.year_id', $year->id);
        } else if ($request->class != "" & $request->class!= null) {
            $q->where('classes.id', $request->class);
        }
        else {
            $q->whereIn('classes.id', $class)->where('rooms.year_id', $year->id);
        }
    })->where('term_id',$term->id)->where('type',$request->type)->with('room.classes')->with(['room' => function ($q1) use ($request) {
        $year = Year::where('current_year', '1')->first();
        if ($request->room != "" && $request->room != null) {
            $q1->where('rooms.id', $request->room)->where('rooms.year_id', $year->id);
        } else {
             $q1->where('rooms.year_id', $year->id);
        }
    }])->with('rewad_and_sanction')->with('student')->with('lesson')->with('teacher')->get();
}

//الوظففين
public function getemployees2(Request $request)
{
    $draw = $request->draw;
    $start = $request->start;
    $rowperpage = $request->length; // Rows display per page
    $columnIndex_arr = $request->order;
    $columnName_arr = $request->columns;
    $search_arr = $request->search;
    $search_bar = $request->barcode_pos_check;
    $class_filter = $request->classes;
    $room_filter = $request->rooms;
    $columnIndex = $columnIndex_arr[0]['column'];
    $columnIndex = $columnIndex >3 ? 0 : $columnIndex ;
    $array_of_sorting = ['first_name'];// Column index
    $searchValue = $search_arr['value']; // Search value
    if (substr($searchValue, 0, 1) == "*" && substr($searchValue, 0, 2) == "") {
        $searchValue = "";
    } else {
        $searchValue = explode('*', $searchValue);
    }
    $records = new Collection;
    // $searchValue = array_filter($searchValue, 'strlen');
    $result_search = "";
    foreach ($searchValue as $key => $item_search) {
        if ($key == 0) {
            $result_search = "%". $item_search . "%";
        } else {
            $result_search .= "%" . $item_search . "%";
        }
    }
    $totalRecords = School_staff::count();
    if($class_filter == null || $class_filter == ""){
        $totalRecordswithFilter = School_staff::where(function($q) use($result_search){
            $q->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
        })->count();
        $records = School_staff::where(function($q) use($result_search){
            $q->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
        })->skip($start)->take($rowperpage)->orderBy($array_of_sorting[$columnIndex],$columnIndex_arr[0]['dir'])->get();
    }else{
        $totalRecordswithFilter = School_staff::where(function($q) use($result_search){
            $q->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
        })->count();
        $records = School_staff::where(function($q) use($result_search){
            $q->where('first_name',"like","%".$result_search."%")->orwhere('last_name',"like","%".$result_search."%");
        })->skip($start)->take($rowperpage)->orderBy($array_of_sorting[$columnIndex],$columnIndex_arr[0]['dir'])->get();
    }
    $data_arr = array();
    foreach ($records as $record) {
        $data_arr[] = array(
            "id" => $record->id,
            "first_name" => $record->first_name,
            "last_name" => $record->last_name,
            "address" => $record->address,
            "date_birth" => $record->date,
            "image" => $record->image,
             "phone"=>$record->phone,

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

//البناء المدرسي
public function school_builder_edit(){

    $content = Building_content::first();
    return view('admin.school_builder_edit', compact('content'));
}

public function school_builder_update(Request $request){
            $content = Building_content::first();
            $content->school_name=$request->school_name;
            $content->statistical_number=$request->statistical_number;
            $content->region=$request->region;
            $content->side=$request->side;
            $content->street=$request->street;
            $content->educational_assembly=$request->educational_assembly;
            $content->is_independent_school=$request->is_independent_school;
            $content->is_inside_school=$request->is_inside_school;
            $content->address=$request->address;
            $content->administrative_division=$request->administrative_division;
            $content->is_main_builder_school=$request->is_main_builder_school;
            $content->access_main_school=$request->access_main_school;
            $content->subscriber_builder=$request->subscriber_builder;
            $content->school_type=$request->school_type;
            $content->attending_school=$request->attending_school;
            $content->attending_school_number=$request->attending_school_number;
            $content->subscriber_school_name=$request->subscriber_school_name;
            $content->subscriber_school_number=$request->subscriber_school_number;
            $content->attendance_type=$request->attendance_type;
            $content->building_ownership=$request->building_ownership;
            $content->school_builder_space=$request->school_builder_space;
            $content->floors_number=$request->floors_number;
            $content->Number_of_valid_building_blocks=$request->Number_of_valid_building_blocks;
            $content->Number_of_not_valid_building_blocks=$request->Number_of_not_valid_building_blocks;
            $content->builder_school_status=$request->builder_school_status;
            $content->Damaged_by_earthquakes=$request->Damaged_by_earthquakes;
            $content->Damaged_by_war=$request->Damaged_by_war;
            $content->builder_type=$request->builder_type;
            $content->floor_type=$request->floor_type;
            $content->Number_of_diesel_tanks=$request->Number_of_diesel_tanks;
            $content->size_of_diesel_tanks=$request->size_of_diesel_tanks;
            $content->internet_status_in_admin_room=$request->internet_status_in_admin_room;
            $content->internet_status_education=$request->internet_status_education;
            $content->is_exist_electricity=$request->is_exist_electricity;
            $content->Alternative_Energy_type=$request->Alternative_Energy_type;
            $content->server_room=$request->server_room;
            $content->server_room_condition=$request->server_room_condition;
            $content->network_description=$request->network_description;
            $content->network_wifi_description=$request->network_wifi_description;
            $content->computer_number=$request->computer_number;
            $content->printer_number=$request->printer_number;
            $content->number_scanner=$request->number_scanner;
            $content->record_device=$request->record_device;
            $content->web_camera_number=$request->web_camera_number;
            $content->responsive_screen_number=$request->responsive_screen_number;
            $content->monitor_camera_number=$request->monitor_camera_number;
            $content->is_camera_full=$request->is_camera_full;
            $content->fire_system=$request->fire_system;
            $content->alert_system=$request->alert_system;

             //info owner , head teacher
            $content->head_teacher_name=$request->head_teacher_name;
            $content->head_teacher_phone=$request->head_teacher_phone;
            $content->head_teacher_mobile=$request->head_teacher_mobile;
            $content->head_teacher_certificate=$request->head_teacher_certificate;
            $content->head_teacher_specialization=$request->head_teacher_specialization;

             $content->school_owner_name=$request->school_owner_name;
            $content->school_owner_phone=$request->school_owner_phone;
            $content->school_owner_mobile=$request->school_owner_mobile;
            $content->school_owner_certificate=$request->school_owner_certificate;
            $content->school_owner_specialization=$request->school_owner_specialization;



            $content->edu_type=$request->edu_type;
            $content->school_integrate=$request->school_integrate;
            $content->kindergarten=$request->kindergarten;
            $content->kindergarten_rooms=$request->kindergarten_rooms;
            $content->basic_edu=$request->basic_edu;
            $content->high_school=$request->high_school;
            $content->institutes=$request->institutes;
            $content->type_b=$request->type_b;
            $content->type_b_students=$request->type_b_students;
            $content->sediments_resulting=$request->sediments_resulting;
            $content->waste_removal=$request->waste_removal;
            $content->draining_toilets=$request->draining_toilets;
            $content->waste_disposal=$request->waste_disposal;
            $content->water_sources=$request->water_sources;
            $content->water_sufficient=$request->water_sufficient;
            $content->water_safe=$request->water_safe;
            $content->water_student=$request->water_student;
            $content->water_availability=$request->water_availability;
            $content->school_phone_number=$request->school_phone_number;



            $content->good_seats=$request->good_seats;
            $content->good_chairs=$request->good_chairs;
            $content->good_lockers=$request->good_lockers;
            $content->good_heaters=$request->good_heaters;
            $content->good_whiteboard=$request->good_whiteboard;
            $content->good_teacher_table=$request->good_teacher_table;
            $content->good_interactive_screen=$request->good_interactive_screen;
            $content->good_laptop_computer=$request->good_laptop_computer;
            $content->bad_seats=$request->bad_seats;
            $content->bad_chairs=$request->bad_chairs;
            $content->bad_lockers=$request->bad_lockers;
            $content->bad_heaters=$request->bad_heaters;
            $content->bad_whiteboard=$request->bad_whiteboard;
            $content->bad_teacher_table=$request->bad_teacher_table;
            $content->bad_interactive_screen=$request->bad_interactive_screen;
            $content->bad_laptop_computer=$request->bad_laptop_computer;
            $content->good_monitors=$request->good_monitors;
            $content->good_scaner=$request->good_scaner;
            $content->good_Broadcasting=$request->good_Broadcasting;
            $content->good_printers=$request->good_printers;
            $content->good_cameras	=$request->good_cameras	;
            $content->good_equipment_for_people_with_disabilities	=$request->good_equipment_for_people_with_disabilities	;
            $content->good_early_childhood_equipment	=$request->good_early_childhood_equipment	;
            $content->good_equipment_for_professional_development_rooms	=$request->good_equipment_for_professional_development_rooms	;
            $content->bad_monitors	=$request->bad_monitors	;
            $content->bad_scaner	=$request->bad_scaner	;
            $content->bad_Broadcasting	=$request->bad_Broadcasting	;
            $content->bad_printers	=$request->bad_printers	;
            $content->bad_cameras	=$request->bad_cameras;
            $content->bad_equipment_for_people_with_disabilities	=$request->bad_equipment_for_people_with_disabilities	;
            $content->bad_early_childhood_equipment	=$request->bad_early_childhood_equipment	;
            $content->bad_equipment_for_professional_development_rooms	=$request->bad_equipment_for_professional_development_rooms	;
            $content->good_organization_male_bathrooms	=$request->good_organization_male_bathrooms	;

            $content->good_organization_female_bathrooms	=$request->good_organization_female_bathrooms;
            $content->good_organization_mixed_bathrooms	=$request->good_organization_mixed_bathrooms;
            $content->good_organization_male_restrooms	=$request->good_organization_male_restrooms;
            $content->good_organization_female_restrooms	=$request->good_organization_female_restrooms;
            $content->good_organization_mixed_restrooms	=$request->good_organization_mixed_restrooms;
            $content->good_organization_urinals	=$request->good_organization_urinals;
            $content->good_organization_male_laundries	=$request->good_organization_male_laundries;
            $content->good_organization_female_laundries	=$request->good_organization_female_laundries;
            $content->good_organization_mixed_laundries	=$request->good_organization_mixed_laundries;
            $content->good_organization_male_Drinking_water_taps	=$request->good_organization_male_Drinking_water_taps;
            $content->good_organization_female_Drinking_water_taps	=$request->good_organization_female_Drinking_water_taps;
            $content->good_organization_mixed_Drinking_water_taps	=$request->good_organization_mixed_Drinking_water_taps;
            $content->bad_organization_male_bathrooms	=$request->bad_organization_male_bathrooms;
            $content->bad_organization_female_bathrooms	=$request->bad_organization_female_bathrooms;
            $content->bad_organization_mixed_bathrooms	=$request->bad_organization_mixed_bathrooms;
            $content->bad_organization_male_restrooms	=$request->bad_organization_male_restrooms;
            $content->bad_organization_female_restrooms	=$request->bad_organization_female_restrooms;
            $content->bad_organization_mixed_restrooms	=$request->bad_organization_mixed_restrooms;
            $content->bad_organization_urinals	=$request->bad_organization_urinals;
            $content->bad_organization_male_laundries	=$request->bad_organization_male_laundries;
            $content->bad_organization_female_laundries	=$request->bad_organization_female_laundries;
            $content->bad_organization_mixed_laundries	=$request->bad_organization_mixed_laundries;
            $content->bad_organization_male_Drinking_water_taps	=$request->bad_organization_male_Drinking_water_taps;
            $content->bad_organization_female_Drinking_water_taps	=$request->bad_organization_female_Drinking_water_taps;

            $content->bad_organization_mixed_Drinking_water_taps	=$request->bad_organization_mixed_Drinking_water_taps;
            $content->good_students_male_bathrooms	=$request->good_students_male_bathrooms;
            $content->good_students_female_bathrooms	=$request->good_students_female_bathrooms;
            $content->good_students_mixed_bathrooms	=$request->good_students_mixed_bathrooms;
            $content->good_students_male_restrooms	=$request->good_students_male_restrooms;
            $content->good_students_female_restrooms	=$request->good_students_female_restrooms;
            $content->good_students_mixed_restrooms	=$request->good_students_mixed_restrooms;
            $content->good_students_urinals	=$request->good_students_urinals;
            $content->good_students_male_laundries	=$request->good_students_male_laundries;
            $content->good_students_female_laundries	=$request->good_students_female_laundries;
            $content->good_students_mixed_laundries	=$request->good_students_mixed_laundries;
            $content->good_students_male_stripes	=$request->good_students_male_stripes;
            $content->good_students_female_stripes	=$request->good_students_female_stripes;


            $content->good_students_mixed_Dstripes=$request->good_students_mixed_Dstripes;
            $content->good_students_male_Drinking_water_taps=$request->good_students_male_Drinking_water_taps;
            $content->good_students_female_Drinking_water_taps=$request->good_students_female_Drinking_water_taps;
            $content->good_students_mixed_Drinking_water_taps=$request->good_students_mixed_Drinking_water_taps;
            $content->bad_students_male_bathrooms=$request->bad_students_male_bathrooms;
            $content->bad_students_female_bathrooms=$request->bad_students_female_bathrooms;
            $content->bad_students_mixed_bathrooms=$request->bad_students_mixed_bathrooms;
            $content->bad_students_male_restrooms=$request->bad_students_male_restrooms;
            $content->bad_students_female_restrooms=$request->bad_students_female_restrooms;
            $content->bad_students_mixed_restrooms=$request->bad_students_mixed_restrooms;

            $content->bad_students_urinals	=$request->bad_students_urinals	;
            $content->bad_students_male_laundries	=$request->bad_students_male_laundries	;
            $content->bad_students_female_laundries	=$request->bad_students_female_laundries	;
            $content->bad_students_mixed_laundries	=$request->bad_students_mixed_laundries	;
            $content->bad_students_male_stripes	=$request->bad_students_male_stripes	;
            $content->bad_students_female_stripes	=$request->bad_students_female_stripes	;
            $content->bad_students_mixed_Dstripes	=$request->bad_students_mixed_Dstripes	;
            $content->bad_students_male_Drinking_water_taps	=$request->bad_students_male_Drinking_water_taps	;
            $content->bad_students_female_Drinking_water_taps	=$request->bad_students_female_Drinking_water_taps	;
            $content->bad_students_mixed_Drinking_water_taps	=$request->bad_students_mixed_Drinking_water_taps	;
            $content->good_people_with_special_needs_male_bathrooms	=$request->good_people_with_special_needs_male_bathrooms	;
            $content->good_people_with_special_needs_female_bathrooms	=$request->good_people_with_special_needs_female_bathrooms	;
            $content->good_people_with_special_needs_mixed_bathrooms	=$request->good_people_with_special_needs_mixed_bathrooms	;
            $content->good_people_with_special_needs_male_restrooms	=$request->good_people_with_special_needs_male_restrooms	;
            $content->good_people_with_special_needs_female_restrooms	=$request->good_people_with_special_needs_female_restrooms	;
            $content->good_people_with_special_needs_mixed_restrooms	=$request->good_people_with_special_needs_mixed_restrooms	;
            $content->good_people_with_special_needs_male_laundries	=$request->good_people_with_special_needs_male_laundries	;
            $content->good_people_with_special_needs_female_laundries	=$request->good_people_with_special_needs_female_laundries	;
            $content->good_people_with_special_needs_mixed_laundries	=$request->good_people_with_special_needs_mixed_laundries	;
            $content->good_people_with_special_needs_urinals	=$request->good_people_with_special_needs_urinals	;
            $content->bad_people_with_special_needs_male_bathrooms	=$request->bad_people_with_special_needs_male_bathrooms	;
            $content->bad_people_with_special_needs_female_bathrooms	=$request->bad_people_with_special_needs_female_bathrooms	;
            $content->bad_people_with_special_needs_mixed_bathrooms	=$request->bad_people_with_special_needs_mixed_bathrooms	;
            $content->bad_people_with_special_needs_male_restrooms	=$request->bad_people_with_special_needs_male_restrooms	;
            $content->bad_people_with_special_needs_female_restrooms	=$request->bad_people_with_special_needs_female_restrooms	;
            $content->bad_people_with_special_needs_mixed_restrooms	=$request->bad_people_with_special_needs_mixed_restrooms	;
            $content->bad_people_with_special_needs_male_laundries	=$request->bad_people_with_special_needs_male_laundries	;
            $content->bad_people_with_special_needs_female_laundries	=$request->bad_people_with_special_needs_female_laundries	;
            $content->bad_people_with_special_needs_mixed_laundries	=$request->bad_people_with_special_needs_mixed_laundries	;
            $content->bad_people_with_special_needs_urinals	=$request->bad_people_with_special_needs_urinals;

            // معلومات الغرف
            $content->room_director=$request->room_director;

            $content->assistant_directors_room=$request->assistant_directors_room;

            $content->used_classroom=$request->used_classroom;

            $content->used_prefabricated_classroom=$request->used_prefabricated_classroom;

            $content->classroom_used_as_administration=$request->classroom_used_as_administration;

            $content->vacant_classrooms=$request->vacant_classrooms;

            $content->vacant_administrative_rooms=$request->vacant_administrative_rooms;

            $content->secretariat_room=$request->secretariat_room;

            $content->mentors_room=$request->mentors_room;

            $content->warehouse_keepers_room=$request->warehouse_keepers_room;

            $content->warehouse_room=$request->warehouse_room;

            $content->librarians_room=$request->librarians_room;

            $content->library=$request->library;

            $content->computer_secretary_room=$request->computer_secretary_room;

            $content->multipurpose_room=$request->multipurpose_room;

            $content->detective_room=$request->detective_room;

            $content->laboratory=$request->laboratory;

            $content->teachers_room=$request->teachers_room;

            $content->art_workshops_room=$request->art_workshops_room;

            $content->activity_room=$request->activity_room;

            $content->psychological_counselor_room=$request->psychological_counselor_room;

            $content->cleaners_room=$request->cleaners_room;

            $content->cleaners_room=$request->cleaners_room;

            $content->guard_room=$request->guard_room;

            $content->food_warehouse=$request->food_warehouse;

            $content->accountants_room=$request->accountants_room;

            $content->stage=$request->stage;

            $content->buffet=$request->buffet;

            $content->health_curriculum_room=$request->health_curriculum_room;

            $content->resource_room_education=$request->resource_room_education;

            $content->early_childhood_division=$request->early_childhood_division;

            $content->accommodation_room=$request->accommodation_room;

            $content->continuing_development_room=$request->continuing_development_room;


            $content->conatiner_school=$request->conatiner_school;


           if ($request->hasFile('file')) {
        Storage::disk('public')->delete($content->file);
        $content->file = $request->file->store('school_data', 'public');
    }

            $content->save();
return redirect()->back()->with('success', 'تم التخزين بنجاح');
}

//غياب وحضور
public function get_manual_monthes($room_id){
    $year=Year::where('current_year','1')->first();

    $manual_monthes = Manual_month::where('year_id',$year->id)->paginate(paginate_num);
     $count = Manual_month::count();
    $all_manual_monthes = Manual_month::all();
    return view('admin.get_manual_monthes',compact('manual_monthes','count','all_manual_monthes','room_id'));
}


    public function get_manual_monthes_employees(){
    $year=Year::where('current_year','1')->first();

    $manual_monthes = Manual_month::where('year_id',$year->id)->paginate(paginate_num);
     $count = Manual_month::count();
    $all_manual_monthes = Manual_month::all();
    return view('admin.get_manual_monthes_employees',compact('manual_monthes','count','all_manual_monthes'));
}


    public function get_manual_monthes_teachers(){
    $year=Year::where('current_year','1')->first();

    $manual_monthes = Manual_month::where('year_id',$year->id)->paginate(paginate_num);
     $count = Manual_month::count();
    $all_manual_monthes = Manual_month::all();
    return view('admin.get_manual_monthes_teachers',compact('manual_monthes','count','all_manual_monthes'));
}

public function student_vaccines($student_id){
    $year=Year::where('current_year','1')->first();
   $student=Student::find($student_id);

  $student_vaccines=Student_vaccine::where('student_id',$student_id)->first();


    return view('admin.student_vaccines',compact('student','student_vaccines' ));

}


   public function student_vaccines_update(Request $request ,$student_id){

        $student=Student::find($student_id);

   $before_vaccines=[];
   $current_vaccines=[];
   $current_illness=[];
   for($i=0;$i<count($request->vaccines_name); $i++){
      $std= new stdClass();
 $std->{'vaccines_name'}=$request->vaccines_name[$i];
 $std->{'first_dose'}=$request->first_dose[$i];
 $std->{'second_dose'}=$request->second_dose[$i];
 $std->{'third_dose'}=$request->third_dose[$i];
 $std->{'first_supportive'}=$request->first_supportive[$i];
 $std->{'second_supportive'}=$request->second_supportive[$i];
$before_vaccines[$i]=$std;

    }

        for($i=0;$i<count($request->vaccines_current_name); $i++){
      $std= new stdClass();
 $std->{'vaccines_current_name'}=$request->vaccines_current_name[$i];
 $std->{'date'}=$request->date[$i];
 $std->{'doctor'}=$request->doctor[$i];

$current_vaccines[$i]=$std;

    }

        for($i=0;$i<count($request->date_illness); $i++){
      $std= new stdClass();
 $std->{'date_illness'}=$request->date_illness[$i];
 $std->{'diagnosis'}=$request->diagnosis[$i];
 $std->{'break_duration'}=$request->break_duration[$i];
 $std->{'Insulation'}=$request->Insulation[$i];
 $std->{'treatment'}=$request->treatment[$i];
 $std->{'other_options'}=$request->other_options[$i];
$current_illness[$i]=$std;

    }

   $student_vaccines=Student_vaccine::where('student_id',$request->student_id)->first();

if(!$student_vaccines){
     $student_vaccines=new Student_vaccine;

}

$student_vaccines->student_id=$request->student_id;
$student_vaccines->before_vaccines=json_encode($before_vaccines);
$student_vaccines->current_vaccines=json_encode($current_vaccines);
$student_vaccines->current_illness=json_encode($current_illness);
 $student_vaccines->save();
return redirect()->back()->with('success', 'تم التخزين بنجاح');

}

/// تحديد الصف التاسع ناجح ام راسب
         public function student_pass_check_by_admin_9(Request $request)
       {

            $year = Year::where('current_year', '1')->first();
            $next_year = Year::where('id', $year->next_year)->first();
            $next_year_id = $next_year->id;
            $student = Student::with(['room' => function ($q1) use ($year) {
                $q1->where('rooms.year_id', $year->id);
            }])->find($request->student_id);
             $user = User::where('student_id',$student->id)->first();
            $current_class_id = $student->room[0]->class_id;
            $class=Classe::find($current_class_id);
            $current_class = Classe::with(['room' => function ($q1) use ($next_year_id) {
                $q1->where('rooms.year_id', $next_year_id);
            }])->find($current_class_id);
            $lessons = Lesson::where('class_id', $current_class_id)->get();
            if ($request->is_passed == 1 ) {
 
                     //ckeck if class has room in the next year, if not then create one
                      $next_class = Classe::with(['room' => function ($q1) use ($next_year_id) {
                        $q1->where('rooms.year_id', $next_year_id);
                    }])->find($class->next_class);

                      $next_class_room =  $next_class->room;
                    // if there is no room in this class then create one and go on !
                    if (count($next_class_room) == 0) {
                        $new_next_room = new Room;
                        $new_next_room->name = 'الأولى';
                        $new_next_room->year_id = $next_year_id;
                        $new_next_room->class_id = $next_class->id;
                        $new_next_room->save();
                    } else {
                        $new_next_room =  $next_class->room[0];
                    }
                $student_pass = 1;
                if ($student_pass == 1) {
                    $next_class_id = $current_class->next_class;
                     
                     $report_card = Report_card::where('student_id', $student->id)->where('year_id', $year->id)->first();
                    if (isset($report_card)) {

                        // check if student was faild then delete his records
                        // if ($report_card->final_result == 3) {
                            $this->change_student_situation($student->id, $next_year_id, $passed = 1);
                        // }
                        // check if student wasn't passed then make him pass
                        // if ($report_card->final_result != 2) {
                            $report_card->final_result = 2; //student is passed
                            $report_card->save();
                            // if ($next_class_id == 0)
                            //     $this->student_graduate(); //الصفوف التي لايوجد صف تالي للنجاح له كالبكالوريا
                            $this->student_pass($student, $new_next_room, $next_year_id);
                        // }
                    }
                     else {

                       return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
                    }
                }


            return redirect()->back()->with('success', ' الطالب ناجح تم التخزين بنجاح');
        } else if ($request->is_passed == 2) {
            $current_class_room =  $current_class->room;
            // if there is no room in this class then create one and go on !
            if (count($current_class_room) == 0) {
                $new_current_room = new Room;
                $new_current_room->name = 'الأولى';
                $new_current_room->year_id = $next_year_id;
                $new_current_room->class_id = $current_class->id;
                $new_current_room->save();
            } else {
                $new_current_room =  $current_class->room[0];
            }
             $report_card = Report_card::where('student_id', $student->id)->where('year_id', $year->id)->first();
            if (isset($report_card)) {
                if ($report_card->final_result == 2) {
                    if($class->number_of_class==12){
                     $user->active = 1;
                     $user->active_year = NULL;
                     $user->save() ;
                    }
                    $this->change_student_situation($student->id, $next_year_id, $passed = 1);
                }
                if ($report_card->final_result != 3) {
                    $report_card->final_result = 3; //student is passed
                    $report_card->save();
                    $this->student_fail($student, $new_current_room, $next_year_id);
                }
            } else {
                return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
            }

            return redirect()->back()->with('success', ' تم تحديد الطالب على أنه راسب   بنجاح');
        } else {
            return redirect()->back()->with('error', 'تأكد من المعلومات المدخلة ');
        }
    }
    //صفحة بيانات المدرسة

     public function school_data()
    {
        $school_data = School_data::first();
        return view('admin.school_data', compact('school_data'));
    }
      public function school_data_update(Request $request)
    {
        $school_data = School_data::first();
        $school_data->name = $request->name;
        $school_data->name_en = $request->name_en;
        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete( $school_data->logo);
            $school_data->logo = $request->logo->store('school_data','public');
        }
        if ($request->hasFile('logo_account')) {
            Storage::disk('public')->delete( $school_data->logo_account);
            $school_data->logo_account = $request->logo_account->store('school_data','public');
        }
           if ($request->hasFile('video')) {

            $school_data->video = $request->video->store('videosfiles', 'public');
        }
        $school_data->save();
        return redirect()->back()->with('success', 'تم التخزين بنجاح');
    }


}
