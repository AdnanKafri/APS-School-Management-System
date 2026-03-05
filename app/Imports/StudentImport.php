<?php

namespace App\Imports;

use App\Room;
use App\Classe;
use App\Student;
use App\Invoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Student_detail;
use App\user;
use App\Year;
use App\Lesson;
use App\Students_mark;
use App\Room_student;
use App\Country_currency;
use Carbon\Carbon;
use stdClass;

use Illuminate\Support\Facades\Hash;



class StudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */



    public function model(array $item)
    {

                
if( $item['first_name_ar'] && $item['last_name_ar'] &&  $item['first_name_en'] &&$item['last_name_en']){
            $student= new Student();
            $student->first_name = $item['first_name_ar'];
            $student->last_name = $item['last_name_ar'];
            $student->first_name_en = $item['first_name_en'];
            $student->last_name_en = $item['last_name_en'];
            $student->place_birth = $item['place_birth'];
            if($item['date_birth']){
                 $student->date_birth =\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item['date_birth']);
            }
           
            $student->box_birth =$item['box_birth'] ;
            $student->army_room = $item['army_room'];
            $student->nationality = $item['nationality'];
            $student->phone = $item['phone'];
            $student->address = $item['address'];
            if($item['lang']){
               $student->lang = (string) $item['lang'];  
            }
            else{
                 $student->lang=0;
            }
           
            $student->religion =(string) $item['religion'];
            
            $country_currency=Country_currency::Where('name_ar', $item['country_currency'])->first();
            $student->country_currency = $country_currency->id;
            $student->public_record_number = $item['public_record_number'];
            
            $student->save();
            
            $year=Year::where('current_year','1')->first();
            $rooom = Room::where('name',$item['room'])->where('year_id',$year->id)->first();

            Invoice::create([
                'invoice_number' => $student->id,
                'invoice_amount' => 0,
                'student_id' => $student->id,
                'class_id' => $rooom->class_id,
                'year_id' => $year->id,
            ]);

            $student_detail = new Student_detail;
            $student_detail->student_id = $student->id;
            $student_detail->phone = $item['phone'];
            $student_detail->father_name = $item['father_name'];
            $student_detail->mother_name = $item['mothre_name'];
            $student_detail->mother_phone = $item['mother_phone'];
            $student_detail->father_phone = $item['father_phone'];
            $student_detail->last_mother_name = $item['last_mother_name'];
            $student_detail->city = $item['city'];
            $student_detail->passport_number = $item['passport_number'];
           $student_detail->the_ID_number = $item['number'];
            $student_detail->other_phone = $item['other_phone'];
            $student_detail->gender =$item['gender'];


            $student_detail->save();


            $user=new User();

            $user->name = $item['first_name_ar'];
            $user->type="0";
            $user->email = "a@app.com";
            $user->student_id=$student->id;

            $user->password = Hash::make(5);
            $user->view_password = 5;
            $user->save();




        $email = str_replace(" ", "", $item['first_name_en']).str_replace(" ", "", $item['last_name_en']).rand(1,1000)."@aladham.com";
        if (strlen($item['first_name_en']) > 2) {
            $namee = substr($item['first_name_en'], 0, 3);
        }else{
            $namee = "aladham";
        }
        $password = $namee."@".rand(100000,900000);
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->view_password = $password;
        $user->save();
        $student->email = $email;
            $year = Year::where('current_year' , '1') ->first();

            $room_student=new Room_student;
            $room_student->student_id=$student->id;
            $room_student->year_id=$year->id;

            $room_student->room_id=$rooom->id;
            $room_student->term=1;
            $room_student->save();

            $lessons=Lesson::where('class_id', $item['class'])->get();
            $object1=new stdClass();
            foreach($lessons as $item){
                $object1->{$item->id}['oral']=null;
                $object1->{$item->id}['homework']=null;
                $object1->{$item->id}['activities']=null;
                $object1->{$item->id}['quize']=null;
                $object1->{$item->id}['exam']=null;


            }

            $object2=new stdClass();
            foreach($lessons as $item){
                $object2->{$item->id}['oral']=null;
                $object2->{$item->id}['homework']=null;
                $object2->{$item->id}['activities']=null;
                $object2->{$item->id}['quize']=null;
                $object2->{$item->id}['exam']=null;


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
        'room_id'=>$rooom->id,
        'year_id'=>$year->id,
        'mark'=>json_encode($object1),
        'mark2'=>json_encode($object2),
        'result1'=>json_encode($object_result1),
        'result2'=>json_encode($object_result2),
        'result'=>json_encode($object_result),
        'term_result'=>json_encode($object_result_term),

        'lang'=>$item['lang'],
        'religion'=>$item['religion'],

    ]);


    if ($student->lang==0) {
        $lessons=Lesson::where('class_id',$item['class'])->where('lang','1')->get();

    }elseif($student->lang==1){
        $lessons=Lesson::where('class_id',$item['class'])->where('lang','0')->get();

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


                $year_result=(json_decode($student_mark->term_result,true)['term1'] + json_decode($student_mark->term_result,true)['term2'])/2;

                $student_mark->year_result= $year_result;
                $student_mark->save();

                }


            }


    if ($student->religion==0) {
        $lessons=Lesson::where('class_id',$item['class'])->where('religion','1')->get();

    }elseif($student->religion==1){
        $lessons=Lesson::where('class_id',$item['class'])->where('religion','0')->get();

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


                $year_result=(json_decode($student_mark->term_result,true)['term1'] + json_decode($student_mark->term_result,true)['term2'])/2;

                $student_mark->year_result= $year_result;
                $student_mark->save();

            }

            }

    }
    }

}
