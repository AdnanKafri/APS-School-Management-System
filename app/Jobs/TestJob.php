<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Classe;
use App\Notification;
use App\Studentfcmtoken;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     protected $class_id;
     protected $term;
     
    public function __construct($class_id,$term)
    {
        $this->class_id = $class_id;
        $this->term = $term;
   
        //
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
public function handle()
    {   
         ini_set("max_execution_time", "-1");
        ini_set("max_file_uploads", "2000M");
        ini_set("max_input_time", "100000000000000");
        ini_set("memory_limit", "10000000000000M");
        ini_set('post_max_size', '50000000000000M');
        ini_set('upload_max_filesize', '500000000000000M');
        //  Artisan::call('queue:work' );
        //  Artisan::call('queue:listen' );
        //
                      
         if($this->term ==1){
            $class = Classe :: find($this->class_id);
                    $rooms = $class->room;
                    foreach($rooms as $room){
                        $students = $room->student;
                        foreach($students as $student){
                            $noti = new Notification;
                            $noti->user_id =1;
                            $noti->student_id = $student->id;
                            $noti->room_id = $room->id;
                            $noti->title ="تم استصدار الجلاء ";
                            $noti->body = "الفصل الأول";
                            $noti->type = 9;
                            $noti->save();  
                            $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
            
                            $devices = array();
                                foreach($tokens as $t){
                                    array_push($devices, $t['s_fcm_token']);

                                }


                        } 
                         
                    }  
         }
         else{
              $class = Classe :: find($this->class_id);
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
                            $tokens = Studentfcmtoken::where('s_fk',$student->id)->get();
            
                            $devices = array();
                                foreach($tokens as $t){
                                    array_push($devices, $t['s_fcm_token']);
                                    //array_push($devices['p_id'], $t['p_fk']);
                                }
                            $this->send_notification($noti->title,$noti->body,$noti->id,$noti->type,'null','null','null',$devices);

                        } 
                         
                    }
         }
          
                    
                    
               
    }
    
     public   function send_notification($Title, $Body,$id,$type,$room_id,$lesson_id,$lecture_id, $devices, $FCM_API_KEY = null)
    {    dd(333333333333);
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
}





