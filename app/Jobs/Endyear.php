<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Classe;
use App\Report_card;
use App\Report_card_details;
use App\Base_subjects;
use App\Exams2;
use App\Exam_result;
use App\Exam_result2;
use App\Room_lesson_exam;
use App\Day;
use App\Exam_question;
use App\Exam_file;
use App\Stats;
use App\Lesson;
use App\Room;
use App\Room_student;
use App\Student;
use App\Students_mark;
use App\User;
use App\Student_schedule_tracer;
use App\Year;
use stdClass;

class Endyear implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     protected $class;
     protected $next_year_id;
     protected $r10;
     protected $year;
     protected $lessons;
     protected $student;
     protected $room;
     protected $new_room;
     protected $new_current_room;
    public function __construct($class,$lessons,$student,$room,$new_room,$new_current_room,$next_year_id,$year)
    {
        $this->class = $class;
        $this->lessons = $lessons;
        $this->student = $student;
        $this->next_year_id = $next_year_id;
        $this->year=$year;
        $this->room=$room;
        $this->new_room=$new_room;
        $this->new_current_room=$new_current_room;
   
        //
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
public function handle()
    {info('11111');
         ini_set("max_execution_time", "-1");
        ini_set("max_file_uploads", "2000M");
        ini_set("max_input_time", "100000000000000");
        ini_set("memory_limit", "10000000000000M");
        ini_set('post_max_size', '50000000000000M');
        ini_set('upload_max_filesize', '500000000000000M');
        //  Artisan::call('queue:work' );
        //  Artisan::call('queue:listen' );
        //       
                $dashboardController = app(\App\Http\Controllers\DashboardController::class) ; 
                $student_pass = $dashboardController->check_student_pass($this->lessons,$this->student,$this->room->id, $this->year->id,$this->class);
                if ($student_pass == 1){
                    $next_class_id = $this->class->next_class ;
                    $report_card = Report_card::where('student_id',$this->student->id)->where('year_id', $this->year->id)->first() ;
                    if (isset($report_card)){
                        $report_card->final_result = 2 ;
                        $report_card->save() ;
                    }
                    // else {
                    //     return back()->with('error', "إن الطالب $this->student->first_name $this->student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
                    // }
                    if ($next_class_id == 0)
                        $dashboardController->student_graduate() ;
                         
                    $dashboardController->student_pass($this->student,$this->new_room[0],$this->next_year_id) ;
                }
                else{
                
                    
                    $report_card = Report_card::where('student_id',$this->student->id)->where('year_id',$this->year->id)->first() ;
                    if (isset($report_card)){
                        $report_card->final_result = 3 ;
                        $report_card->save() ;
                    }
                    //  else {
                    //     return back()->with('error', "إن الطالب $student->first_name $student->last_name لا يملك سجل بجدول الجلاءات تواصل مع الدعم    ");
                    // }
                    
                      $dashboardController->student_fail($this->student,$this->new_current_room[0],$this->next_year_id) ;
 
               
                }
                    
          
                    
                    
               
    }
   


}





