<!DOCTYPE html>
<html lang="en">
<head>
	<title>الجلاء المدرسي </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
   <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css"   href="{{ asset('assets/certificate/vendor/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css"   href="{{ asset('assets/certificate/vendor/bootstrap/css/bootstrap.min-2.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css"   href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css"  href="{{ asset('assets/certificate/vendor/animate/animate.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/certificate/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/certificate/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<!--===============================================================================================-->



<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/util.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/main.css') }}">

<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<!--===============================================================================================-->
<link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<style>


.tab1cards {
  display: flex;
  flex-direction: row;
  justify-content: center;

}

.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto;
  grid-gap: 10px;
  background-color: transparent;
  padding: 10px;
  /*margin-left: -50px;*/
  justify-content:center ;
  text-align: center;
}

table {
  direction: rtl;
    border: 1px solid black;
}
th {
    border: 3px solid black;
    padding: 6px;
    background-color:rgb(255, 255, 255);
    color: black;
    font-size: 11px;
     font-weight: 700;
}
td {
    border: 3px solid black;
    padding: 5px;
    font-size: 9.2px;
    color: #000 ;
}
td.special-subject{
    font-weight:600;
}
.border tr td {
   border: 2px solid white;
}



.upper-table td {
     border: 0px ;
     padding: 5px;
 }


 .paragraph-os {
    font-family: revert;
    font-weight: 700;
    color: #000;
    font-size: 14px;
 }
 .paragraph-os1 {
    font-family: revert;
    font-weight: 500;
    color: #000;
 }
 .main-p {
    font-family: revert;
    font-weight: 600;
    color: #000;
 }

.square{
    width: 18px;
    height: 12px;
    border: 1px solid black;
    display: inline-block;
    margin-left: 8px;
      box-shadow: 0px 1px 3px 1px  rgba(0,0,0,0.75);
-webkit-box-shadow: 0px 1px 3px 1px  rgba(0,0,0,0.75);
-moz-box-shadow: 0px 1px 3px 1px  rgba(0,0,0,0.75);
}

</style>
  @php
        $school_data = \App\School_data::first();
        @endphp
</head>
<body style=" padding:10px;background-size: cover;
">

    <table class="upper-table w-100 "  style="border-color: white">
        <thead>
                @php
                    function arabic_w2e($str)
                        {
                            $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
                            $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                            return str_replace($arabic_western, $arabic_eastern, $str);
                        }
                @endphp
                  <tr>
                        <td colspan="3" style="width:40%">
                            <div class="row">
                                <div class="col-8 row"   style="">
                                    <h6 class="text-center col-7"  style="font-weight:500;font-family:'Amiri', serif;" >
                                        الجمهورية العربية السورية  <br>
                                        وزارة التربية
                                    </h6>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-9 row">
                                    <br>

                                    <h6 class="text-right col-9 "   style="font-weight:600;font-family:'Amiri', serif;margin-right: 25px;"    >
                                مديرية التربية في محافظة: حماه
                                    </h6>
                                    <br>
                                </div>
                                <div class="col-3"></div>
                                <div class="col-9 row">


                                    <h6 class="text-right col-9"   style="font-weight:600;font-family:'Amiri', serif;margin-right: 25px;"  >
                            مدرسة: {{$school_data->name}}  (الافتراضية)
                                    </h6>

                                </div>
                                <div class="col-3"></div>
                            </div>
                        </td>

                        <td   colspan="2" style="position: relative;width:36%;font-family:'Amiri', serif;">
                            <h2 class="my-title" style="font-weight: 600;position: absolute;top:5px;right:20px"> مرحلة التعليم الأساسي  </h2>
                            <h3 class="my-title" style="font-weight: 600;font-size:18px;position: absolute;top:50px;right:35px">    الحلقة الثانية الصف /التاسع/   </h3>
                        </td>

                        <td  colspan="3"  style="position: relative;width:17%">
                            <p class="paragraph-os text-center" style="position: absolute;top:18px;right:25px;font-size:16px">   العام الدراسي: <span style="margin-right: 12px"> {{ arabic_w2e($year_name )}} </span></p>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                </thead>
                <tbody style="font-family:'Amiri', serif;">
                    <tr>


                        <td  colspan="11">
                            <div class="row" style="margin-bottom:-30px">
                                 <div class="col-4 text-right" Style="width:30.333333%">
                                  <p class="paragraph-os">
                                    <span class="paragraph-os ml-4"> الرقم المتسلسل ({{  arabic_w2e($student->serial_number) }})  </span>

                                    <span class="paragraph-os " style="padding-left:25px" > اسم التلميذ/ة: <span> {{ $student->first_name.' '.$student->last_name }}</span>       </span>

                                  </p>

                                </div>
                                <div class="col-2 " style="text-align: right;">
                                  <span class="paragraph-os ml-4"> الأب: <span>{{ $student->details->father_name }}</span> </span>

                                  <span class="paragraph-os"> الأم: <span>{{ $student->details->mother_name }}</span></span>
                                </div>

                                <div class="col-2 text-right" style="margin-right: 10px;width:20.5%">
                                  <p class="paragraph-os">تاريخ الميلاد: <span dir="rtl"> {{ arabic_w2e(Carbon\Carbon::parse($student->date_birth)->format('Y/m/d')) }}</span></p>
                                </div>
                                <div class="col-2" style="margin-right: 10px;width:13.5%">
                                    <span class="col-3 paragraph-os"> الشعبة: <span>{{ $room_name }}</span></span>
                                </div>
                                <div class="col-2" >
                                  <span class="c paragraph-os"> الرقم في السجل العام: <span> {{  arabic_w2e($student->public_record_number) }} </span></span>
                                </div>

                            </div>
                        </td>

                    </tr>

                </tbody>
            </table>
            </td>
        </tr>

        </tbody>
    </table>

    <table id="3" class="h-100 w-100 text-center mt-4" summary="Code page support in different versions of MS Windows."
    rules="groups" frame="hsides"
    style="border:3px solid #000;" >
       <tbody>

         <tr style="border:3px solid #000;" >
          <th rowspan="4" style="text-align: center;width:7.98%;font-size:11px;font-weight:700"  >المواد <br> الدراسية </th>
          <th  rowspan="4" style="width:2.88%;font-size:9px;font-weight:700">
                <span  style="writing-mode: vertical-rl; text-align: center;transform: rotate(180deg);">  النهاية العظمى
          </th>
          <th colspan="4" rowspan="2" style="text-align: center;font-size:13px">
          درجة أعمال الفصل الدراسي الأول <br>
          {{  arabic_w2e(60)   }}%
         </th>
          <th colspan="2" rowspan="2" style="text-align: center;font-size:13px">
               درجة امتحان الفصل الدراسي الأول <br>
                {{  arabic_w2e(40)   }}%

          </th>
          <th colspan="2" rowspan="2" style="text-align: center;font-size:13px">
               درجة أعمال الفصل الدراسي الثاني
               <br>           {{  arabic_w2e(60)   }}%
           </th>
          <th colspan="2" rowspan="3" style="text-align: center;font-size:10px">
       <span>
          المحصلة
       </span>
          { (
                       درجة أعمال الفصل الأول
                     {{  arabic_w2e(60)   }}%
              <br>
                      &plusmn;
                     درجة أعمال الفصل الثاني
                     {{  arabic_w2e(60)  }}%
                )
              <span style="color:black;"> &#247</span>  {{ arabic_w2e(2) }}
              }

              <br> = {{  arabic_w2e(60) }}%
                + درجة امتحان الفصل الأول
                {{  arabic_w2e(40) }}%
              <br>
                = {{  arabic_w2e(100) }}%
          </th>

          <th colspan="3" rowspan="1" style="width:18.7%;border-right: 3px solid #000 ;"    > ملاحظات الإدارة </th>

         </tr>
         <tr>
             <th rowspan="6" style="width:4.7%;font-size:10px;padding:1px">الفصل الأول</th>
             <th colspan="2" rowspan="6" style="width:14.48%;">
              @php
                $teacher_notes1 = isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term1'} : ''
             @endphp
            {{ $student_rigistration_term == 1 ? $teacher_notes1 : '' }}
             </th>
          </tr>

         <tr style="border-bottom:3px solid #000;">
            <th rowspan="2" style="width:3.9%;padding:8px;font-size:12px"> رقماً </th>
            <th rowspan="2" colspan="3" style="text-align: center;width:13.3%; border-right: 2px ;font-size:12px"> كتابة </th>
            <th rowspan="2" style="width:6%;font-size:12px"> رقماً </th>
            <th rowspan="2" style="width: 12.68%;text-align:center;font-size:12px"> كتابة </th>
            <th rowspan="2" style="text-align: center;border-right: 3px solid #000 ;width:7%;font-size:12px"> رقماً </th>
            <th rowspan="2" style="text-align: center;width: 13.5%;font-size:12px"> كتابة </th>
         </tr>


        <tr style="border-bottom:3px solid #000;">
            <th style="width:3.37%;padding:8px"> رقماً </th>
            <th style="text-align: center;width:11.3%; border-right: 1px ;"> كتابة </th>

         </tr>

         @foreach ($mark_base_subjects as $key77 => $base_subject)
                    @php
                        $lessons = $base_subject->lessons_mark ;
                        $lesson_count =  count($lessons);


                        $i = 0;
                        $addable_lesson_id = 0;
                        $term1_work_degree = 0 ;
                        $term2_work_degree = 0 ;
                        $term1_exam_degree = 0 ;
                        $base_subject_mark = 0 ;

                    @endphp
                    @foreach ($lessons as $key => $lesson)
                     @if($lesson->certificate_order !=0)
                        @php
                            if ( $lesson->religion != null)
                                $lesson_name =  'التربية الدينية' ;

                            else
                            $lesson_name = $lesson->name ;

                            $total_result = 0 ;
                            $term2_result = 0 ;
                            $item1_term1_result = '';
                            $item1_term2_result = '';
                            $before_first_total_subjects = [] ;
                            $value_loader = 0;
                            if($lesson_count > 1) {

                              $base_subject_mark +=  $lesson->max_mark ;
                                if(json_decode($student_marks->worke_degree) !== null ){
                                    foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 ){
                                        if($key1 == $lesson->id ){

                                            // $term1_result +=  $item1->term1_result ;

                                            $term1_work_degree += $item1->term1_result  == 'null' ? 0 : $item1->term1_result  ;
                                        }
                                    }
                                }
                                if(json_decode($student_marks->mark) !== null ){
                                    foreach(json_decode($student_marks->mark) as $key1 => $item1 ){
                                        if($key1 == $lesson->id ){
                                            // $term1_result +=  $item1->exam ;
                                            $term1_exam_degree += $item1->exam  == 'null' ? 0 : $item1->exam  ;
                                        }
                                    }
                                }
                                if(json_decode($student_marks->worke_degree) !== null ){
                                    foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 ){
                                        if($key1 == $lesson->id ){

                                            // $term2_result +=  $item1->term2_result ;
                                            $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                            $term2_work_degree +=   $x ;
                                        }
                                    }
                                }

                            }

                        @endphp



                        <!--check if the subject belongs to the first total in report card-->
                            @if (  $lesson->first_total)

                            @php

                            //  if($i > 1){

                            //     $term1_work_degree = ceil($term1_work_degree/$lesson_count);
                            //     $term1_exam_degree = ceil($term1_exam_degree/$lesson_count);

                            //     $term2_work_degree = ceil($term2_work_degree/$lesson_count);
                            //     $term2_exam_degree = ceil($term2_exam_degree/$lesson_count);

                            //   }
                            @endphp
                                <tr>

                                    <td class="special-subject">    {{  $i > 1 ?  $base_subject->name : $lesson_name  }} </td>
                                    <td class="max_mark"> {{  arabic_w2e( $i > 1 ?  $base_subject_mark : $lesson->max_mark )}} </td>




                                        @if(!($i > 1) && $student_rigistration_term == 1)

                                            @if(json_decode($student_marks->worke_degree) !== null )
                                            @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )
                                                  @php
                                                    $term1_work_degree = $item1->term1_result  == 'null' ? 0 : $item1->term1_result  ;
                                                    $total_result +=  $term1_work_degree;
                                                  @endphp
                                                @endif
                                            @endforeach
                                            @endif
                                        @elseif($student_rigistration_term == 1)

                                            @php
                                            $total_result +=  $term1_work_degree ;
                                            @endphp
                                        @endif
                                      <td class="work_degree1" data-work_degree="{{ $term1_work_degree }}">
                                           @if( $student_rigistration_term == 1)
                                                {{ arabic_w2e($term1_work_degree)  }}
                                            @endif
                                      </td>
                                       <td colspan="3" class="x" data-id="{{   $term1_work_degree ?? '' }}" ></td>
                                        @if(!($i > 1) && $student_rigistration_term == 1)
                                            @if(json_decode($student_marks->mark) !== null )
                                            @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )

                                                  @php
                                                    $term1_exam_degree = $item1->exam  == 'null' ? '' : $item1->exam  ;
                                                    $total_result += $term1_exam_degree ;
                                                  @endphp
                                                @endif
                                            @endforeach
                                            @endif
                                        @elseif($student_rigistration_term == 1)

                                            @php
                                            $total_result +=  $term1_exam_degree ;
                                            @endphp
                                        @endif
                                      <td class="exam" data-exam="{{ $term1_exam_degree }}">
                                            @if( $student_rigistration_term == 1)
                                                {{ arabic_w2e($term1_exam_degree)  }}
                                            @endif
                                      </td>
                                      <td class="x" data-id="{{   $term1_exam_degree }}" ></td>


                                      <!--second term-->

                                        @if(!($i > 1) && $current_term == 2)

                                            @if(json_decode($student_marks->worke_degree) !== null )
                                            @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )
                                                  @php
                                                     $term2_work_degree = $item1->term2_result  == 'null' ? 0 : $item1->term2_result  ;
                                                    $total_result +=  $term2_work_degree ;
                                                  @endphp
                                                @endif
                                            @endforeach
                                            @endif
                                        @elseif($current_term == 2)

                                              @php
                                              $total_result +=  $term2_work_degree ;
                                             @endphp
                                        @endif
                                       <td class="work_degree2" data-work_degree="{{ $term2_work_degree }}">
                                            @if( $current_term == 2)
                                                {{ arabic_w2e($term2_work_degree)  }}
                                            @endif
                                      </td>
                                       <td class="x" data-id="{{  $term2_work_degree ?? '' }}" ></td>




                                    <td class="result1" data-term1_result="{{  $current_term == 2 ? $total_result : ''}}"
                                    @if( $total_result  < $lesson->min_mark)
                                    style="color:red !important;"
                                   @endif
                                    > {{  arabic_w2e( $current_term == 2 ? $total_result : '') }} </td>
                                    <td class="x" data-id="{{   $current_term == 2 ? $total_result : '' }}" data-min_mark="{{  $lesson->min_mark }}"> </td>
                                    {{-- end term1 result  --}}


                                    {{-- start term2 result  --}}


                                    {{-- build the notes in report card --}}
                                    @if($key77 + 1 == 4)
                                        <td colspan="1" rowspan="8" style="font-size:10px;font-weight:700;padding:1px">الفصل الثاني</td>
                                        <td colspan="2" rowspan="8" style="font-size:12px;font-weight:700">
                                              @php
                                                $teacher_notes2 = isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term2'} : ''
                                             @endphp
                                            {{ $current_term == 2 ? $teacher_notes2 : '' }}
                                        </td>

                                    @endif

                                </tr>




                        @endif
                          @endif
                    @endforeach
            @endforeach



        <tr>
          <td style="font-weight:700;font-size:12px"> المجموع العام </td>
          <td class="max_mark_total1 max_mark2"> {{ arabic_w2e( 3700 ) }}</td>
          <td class="{{ $student_rigistration_term == 1 ? ' work_degree1_total work_degree11' : '' }}">  </td>
          <td colspan="3" class="{{$student_rigistration_term == 1 ? 'x' : '' }}"> </td>
          <td class="{{  $student_rigistration_term == 1 ? 'exam_total exam11  ' : ''}}">  </td>
          <td colspan="1" class="{{$student_rigistration_term == 1 ? 'x' : '' }}"> </td>
          <td class="{{ $student_rigistration_term == 1 ? 'work_degree2_total work_degree22' : '' }}">  </td>
          <td colspan="1" class="{{$student_rigistration_term == 1 ? 'x' : '' }}"> </td>


          <td class="{{ $student_rigistration_term == 1 ? 'result1_total result11' : '' }}">  </td>
          <td class="{{$student_rigistration_term == 1 ? 'x' : ''}} result1_total_write"> </td>

        </tr>


         @foreach ($mark_base_subjects as $key_after_total => $base_subject)
                    @php
                        $lessons = $base_subject->lessons_mark ;
                        $lesson_count =  count($lessons);


                        $i = 0;
                        $addable_lesson_id = 0;
                        $term1_work_degree = 0 ;
                        $term2_work_degree = 0 ;
                        $term1_exam_degree = 0 ;
                        $term2_exam_degree = 0 ;
                        $total_result = 0 ;
                        $term2_result = 0 ;
                        $base_subject_mark = 0 ;

                    @endphp
                    @foreach ($lessons as $key => $lesson)
                     @if($lesson->certificate_order !=0)
                        @php
                            if ( $lesson->religion != null)
                                $lesson_name =  'التربية الدينية' ;

                            else
                            $lesson_name = $lesson->name ;

                            $term1_result = 0 ;
                            $term2_result = 0 ;
                            $before_first_total_subjects = [] ;
                            $value_loader = 0;
                            if($lesson_count > 1) {
                              $base_subject_mark +=  $lesson->max_mark ;
                                if(json_decode($student_marks->worke_degree) !== null ){
                                    foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 ){
                                        if($key1 == $lesson->id ){

                                            // $term1_result +=  $item1->term1_result ;

                                            $term1_work_degree += $item1->term1_result  == 'null' ? 0 : $item1->term1_result  ;
                                        }
                                    }
                                }
                                if(json_decode($student_marks->mark) !== null ){
                                    foreach(json_decode($student_marks->mark) as $key1 => $item1 ){
                                        if($key1 == $lesson->id ){
                                            // $term1_result +=  $item1->exam ;
                                            $term1_exam_degree += $item1->exam  == 'null' ? 0 : $item1->exam  ;
                                        }
                                    }
                                }
                                if(json_decode($student_marks->worke_degree) !== null ){
                                    foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 ){
                                        if($key1 == $lesson->id ){

                                            // $term2_result +=  $item1->term2_result ;
                                            $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                            $term2_work_degree +=   $x ;
                                        }
                                    }
                                }
                                if(json_decode($student_marks->mark2) !== null ){
                                    foreach(json_decode($student_marks->mark2) as $key1 => $item1 ){
                                        if($key1 == $lesson->id ){
                                            // $term2_result +=  $item1->exam ;

                                            $term2_exam_degree += $item1->exam  == 'null' ? 0 : $item1->exam  ;
                                        }
                                    }
                                }
                            }
                            // if ($base_subject->id == 19 && $i > 0) dd($term1_work_degree) ;

                        @endphp

                        @if (++$i === $lesson_count)

                        <!--check if the subject belongs to the first total in report card-->
                            @if (  $lesson->first_total == 0)

                            @php

                            //  if($i > 1){

                            //     $term1_work_degree = ceil($term1_work_degree/$lesson_count);
                            //     $term1_exam_degree = ceil($term1_exam_degree/$lesson_count);

                            //     $term2_work_degree = ceil($term2_work_degree/$lesson_count);
                            //     $term2_exam_degree = ceil($term2_exam_degree/$lesson_count);

                            //   }
                            @endphp
                                 <tr >

                                    <td class="special-subject">    {{  $i > 1 ?  $base_subject->name : $lesson_name  }} </td>
                                    <td class="max_mark"> {{  arabic_w2e( $i > 1 ?  $base_subject_mark : $lesson->max_mark )}} </td>




                                        @if(!($i > 1) && $student_rigistration_term == 1)

                                            @if(json_decode($student_marks->worke_degree) !== null )
                                            @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )
                                                  @php
                                                     $term1_work_degree = $item1->term1_result  == 'null' ? 0 : $item1->term1_result  ;
                                                    $total_result +=  $term1_work_degree ;
                                                  @endphp
                                                @endif
                                            @endforeach
                                            @endif
                                        @elseif($student_rigistration_term == 1)

                                            @php
                                            $total_result +=  $term1_work_degree ;
                                            @endphp
                                        @endif

                                      <td class="work_degree11" data-work_degree="{{ $term1_work_degree }}">
                                           @if( $student_rigistration_term == 1)
                                                {{ arabic_w2e($term1_work_degree)  }}
                                            @endif
                                      </td>
                                       <td colspan="3" class="x" data-id="{{   $term1_work_degree ?? '' }}" ></td>

                                        @if(!($i > 1) && $student_rigistration_term == 1)
                                            @if(json_decode($student_marks->mark) !== null )
                                            @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )

                                                  @php
                                                    $term1_exam_degree = $item1->exam  == 'null' ? '' : $item1->exam  ;
                                                    $total_result += $term1_exam_degree ;
                                                  @endphp
                                                @endif
                                            @endforeach
                                            @endif
                                        @elseif($student_rigistration_term == 1)

                                            @php
                                            $total_result +=  $term1_exam_degree ;
                                            @endphp
                                        @endif

                                      <td class="exam11" data-exam="{{ $term1_exam_degree }}">
                                            @if( $student_rigistration_term == 1)
                                                {{ arabic_w2e($term1_exam_degree)  }}
                                            @endif
                                      </td>
                                      <td class="x" data-id="{{   $term1_exam_degree }}" ></td>


                                      <!--second term-->

                                        @if(!($i > 1) && $current_term == 2)

                                            @if(json_decode($student_marks->worke_degree) !== null )
                                            @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )
                                                  @php
                                                     $term2_work_degree = $item1->term2_result  == 'null' ? 0 : $item1->term2_result  ;
                                                    $total_result +=  $term2_work_degree ;
                                                  @endphp
                                                @endif
                                            @endforeach
                                            @endif
                                        @elseif($current_term == 2)

                                              @php
                                              $total_result +=  $term2_work_degree ;
                                             @endphp
                                        @endif
                                      <td class="work_degree22" data-work_degree="{{ $term2_work_degree }}">
                                           @if( $current_term == 2)
                                                {{ arabic_w2e($term2_work_degree)  }}
                                            @endif
                                      </td>
                                       <td class="x" data-id="{{  $term2_work_degree ?? '' }}" ></td>




                                    <td class="result11" data-term1_result="{{  $current_term == 2 ? $total_result : ''}}"
                                    @if( $total_result  < $lesson->min_mark)
                                    style="color:red !important;"
                                   @endif
                                    > {{  arabic_w2e( $current_term == 2 ? $total_result : '') }} </td>
                                    <td class="x" data-id="{{   $current_term == 2 ? $total_result : '' }}" data-min_mark="{{  $lesson->min_mark }}"> </td>
                                    {{-- end term1 result  --}}


                                    {{-- start term2 result  --}}


                                    {{-- build the notes in report card --}}
                                    @if($key_after_total + 1 == 11)
                                        <td colspan="3" rowspan="2" style="font-size:11px;font-weight:800;padding:1px;background:#fff" >متوسط درجات السلوك في الصف التاسع </td>


                                    @endif

                                </tr>



                        @endif
                        @endif
                           @endif
                    @endforeach
            @endforeach

        <tr >
          <td style="font-weight:700;font-size:12px"> المجموع النهائي </td>
          <td  style=""> {{ arabic_w2e( 3900 )  }}</td>
          <td colspan="1" class="{{$student_rigistration_term == 1 ? 'work_degree11_total' : ''}}"  style=""> </td>
          <td colspan="3" class="{{$student_rigistration_term == 1 ? 'x ' : ''}}" style=""> </td>
          <td class="{{$student_rigistration_term == 1 ? 'exam11_total' : ''}}" style=""> </td>
          <td colspan="1" class="{{$student_rigistration_term == 1 ? 'x ' : ''}}" style="">  </td>
          <td class="{{$current_term == 2 ? 'work_degree22_total' : ''}}" style="">  </td>
          <td class="{{$current_term == 2 ? 'x ' : ''}}" style=""> </td>
          <td  class="{{$student_rigistration_term == 1 ? 'result11_total' : ''}}"></td>
          <td class="{{$current_term == 2 ? 'x ' : ''}}"></td>

          <td colspan="1" style="width:5.2%;background:#fff;font-size:12px;font-weight:700;padding:0">الفصل الأول</td>
          <td  style="width:5.2%;background:#fff;font-size:12px;font-weight:700;padding:0">الفصل الثاني</td>
          <td  style="background:#fff;font-size:12px;font-weight:700;padding:0"> <div style=""> المجموع<span style="color:black;"> &#247</span>{{ arabic_w2e(2)}}</div></td>


        </tr>


        <tr>
            <td colspan="12"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        @php
                       if ($student_rigistration_term == 1 ){
                            $student_attendance1 =   isset($report_card) ?  json_decode($report_card->student_attendance)->{'term1'} : 0;
                            $justified_absence1 =    isset($report_card) ?  json_decode($report_card->justified_absence)->{'term1'} : 0;
                            $unjustified_absence1 =  isset($report_card) ?  json_decode($report_card->unjustified_absence)->{'term1'} : 0;
                            $actual_attendance1 =    isset($report_card_details->actual_attendance) ?  json_decode($report_card_details->actual_attendance)->{'term1'} : 0;
                      }else {
                            $student_attendance1 = 0 ;
                            $justified_absence1  = 0 ;
                            $unjustified_absence1 = 0 ;
                            $actual_attendance1 = 0 ;
                        }


                        if ($current_term == 2 ){
                            $student_attendance2 =   isset($report_card) ?  json_decode($report_card->student_attendance)->{'term2'} : 0 ;
                            $actual_attendance2 =    isset($report_card_details->actual_attendance) ?  json_decode($report_card_details->actual_attendance)->{'term2'} : 0;
                            $justified_absence2 =    isset($report_card) ?  json_decode($report_card->justified_absence)->{'term2'} : 0;
                            $unjustified_absence2 =  isset($report_card) ? json_decode($report_card->unjustified_absence)->{'term2'} : 0;
                        }
                        else {
                            $student_attendance2 =   0 ;
                            $actual_attendance2 =    0;
                            $justified_absence2 =    0;
                            $unjustified_absence2 =  0;
                        }




                      $total_student_attendance =  $student_attendance1 +  $student_attendance2 ;
                      $total_actual_attendance =  $actual_attendance1 +  $actual_attendance2 ;
                      $total_justified_absence =  $justified_absence1 +  $justified_absence2 ;
                      $total_unjustified_absence =  $unjustified_absence1 +  $unjustified_absence2 ;

                      $attendance_percent = $total_student_attendance / ($total_actual_attendance != 0 ? $total_actual_attendance : 1 )  * 100 ;
                      $attendance_percent_term1 = $student_attendance1 / ($actual_attendance1 != 0 ? $actual_attendance1 : 1 )  * 100 ;
                      $attendance_percent_term2 = $student_attendance2 / ($actual_attendance2 != 0 ? $actual_attendance2 : 1 )  * 100 ;

                  @endphp

        <tr>
            <td rowspan="2" style="font-size: 10px;padding:0;font-weight:700;"> جدول دوام التلميذ</td>
            <td rowspan="2" colspan="2" style="font-size: 9px;padding:0;font-weight:700;"> عدد أيام الدوام الفعلي</td>
            <td  colspan="3" style="font-size: 10px;padding:0;font-weight:700;">الغياب</td>
            <td colspan="6" rowspan="2" style="font-size: 11px;padding:0;font-weight:700;"> ملاحظات ولي التلميذ</td>
            <td colspan="3" rowspan="7">
                <div class="h-100" >

                    <div class="row " style="position: relative;    margin-top: 10px;">
                        <br>
                        <h6 style="margin:auto;margin-bottom:10px">
                            النتيجة النهائية
                        </h6>
                        <div style="text-align: right;">
                            <div style="font-size: 8px;font-weight:700;"> <span class="square"></span>تم ترشيحه إلى الامتحان العام لشهادة التعليم الأساسي </div>
                            <div style="font-size: 8px;font-weight:700;margin-top:15px"> <span class="square"></span>لم يتم ترشيحه إلى الامتحان العام لشهادة التعليم الأساسي </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                     @php
                        $report_card_date =  isset($report_card_details) ? json_decode($report_card_details->report_card_date)->{'term1'} : '' ;
                        $formatted_date = empty($report_card_date) ? '' : arabic_w2e(Carbon\Carbon::parse($report_card_date)->format('Y/m/d'))  ;
                    @endphp

                    <p class=" mb-0 " style="color:#000;font-size:10px;margin-top:-35px;text-align: right;">  {{ $formatted_date }} </p>

                    <div class="row" >
                        <div class="col-5 text-right">
                            <p class=" mb-0 " style="color:#000;font-size:12px">اسم المدير</p>
                            <p class="mt-2 mb-0 " style="color:#000;font-size:10px"> {{ isset($report_card_details) ? $report_card_details->manager_name : ''}}</p>

                        </div>

                        <div class="col-4 text-right">التوقيع  </div>

                        <div class="col-3 text-right">  الختم</div>
                    </div>

                </div>
            </td>
        </tr>
        <tr>
            <td style="font-size: 11px;padding:0;font-weight:700;width:4%">غير مبرر</td>
            <td style="font-size: 11px;padding:0;font-weight:700;width:4%">مبرر</td>
            <td style="font-size: 11px;padding:0;font-weight:700;width:5.3%">المجموع</td>
        </tr>
        <tr>
            <td style="font-size:12px;font-weight:700">الفصل الأول</td>
            <td style="font-size:12px;font-weight:700">{{  $student_rigistration_term == 1 ?  arabic_w2e($actual_attendance1) : ''}}</td>
            <td style="font-size:12px;font-weight:700">{{  $student_rigistration_term == 1 ?  arabic_w2e($student_attendance1) : ''}}</td>
            <td style="font-size:12px;font-weight:700"> {{  $student_rigistration_term == 1 ?  arabic_w2e($unjustified_absence1) : ''}}</td>
            <td style="font-size:12px;font-weight:700">{{  $student_rigistration_term == 1 ?  arabic_w2e($justified_absence1) : ''}}</td>
            <td style="font-size:12px;font-weight:700"></td>

        </tr>
        <tr>
            <td style="font-size:12px;font-weight:700">الفصل الثاني</td>
            <td  style="font-size:12px;font-weight:700">  {{ $current_term == 2  ?  arabic_w2e($actual_attendance2) : '' }}    </td>
            <td  style="font-size:12px;font-weight:700">   {{ $current_term == 2  ?  arabic_w2e($student_attendance2) : '' }}    </td>
            <td  style="font-size:12px;font-weight:700">  {{ $current_term == 2  ?  arabic_w2e($unjustified_absence2) : '' }}    </td>
            <td  style="font-size:12px;font-weight:700">  {{ $current_term == 2  ?  arabic_w2e($justified_absence2) : '' }}    </td>
            <td style="font-size:12px;font-weight:700"></td>

        </tr>
        <tr>
            <td style="font-size:12px;font-weight:700">المجموع </td>
            <td style="font-size:12px;font-weight:700">{{ arabic_w2e( $total_actual_attendance ) }}</td>
            <td style="font-size:12px;font-weight:700"> {{ arabic_w2e( $total_student_attendance ) }}</td>
            <td style="font-size:12px;font-weight:700">{{ arabic_w2e( $total_unjustified_absence) }}</td>
            <td style="font-size:12px;font-weight:700">{{ arabic_w2e( $total_justified_absence) }}</td>
            <td style="font-size:12px;font-weight:700">{{   arabic_w2e( ceil($total_student_attendance)) }}</td>

        </tr>
        <tr>
            <td style="font-size:12px;font-weight:700">النسبة المئوية </td>
            <td style="font-size:12px;font-weight:700"></td>
            <td style="font-size:12px;font-weight:700"> </td>
            <td style="font-size:12px;font-weight:700"></td>
            <td style="font-size:12px;font-weight:700"></td>
            <td style="font-size:12px;font-weight:700">{{   arabic_w2e( ceil($attendance_percent)).'%' }}</td>

        </tr>

 <tr style="border-top: 3px solid #000 ;">
              <td colspan="7">

                <div class="row">
                    <div class="col-3 text-right"  style="font-size:12px;font-weight:700">
                        توقيع الموجه:
                    </div>
                    <div class="col-2"></div>
                    <div class="col-4 text-right"  style="font-size:12px;font-weight:700">
                        توقيع المدير:
                    </div>
                </div>
            </td>


              <td colspan="5" style="border-right: 1px solid #000 ;">
                <div class="row">
                    <div class="col-3 text-right mr-4"  style="font-size:12px;font-weight:700">
                        توقيع الموجه
                    </div>
                    <div class="col-2"></div>
                    <div class="col-4 text-right"  style="font-size:12px;font-weight:700">
                        توقيع المدير
                    </div>
                </div>
              </td>

          </tr>
       </tbody>
    </table>





   <div class="Row" style="margin: 0 auto ; text-align: center;">
            <!--<a id="dlink"  style="display:none;"></a>-->
            <!--<input class="btn btn-primary " type="button" onclick="tablesToExcel(array1, array2, 'myfile.xls')" value="تنزيل ملف اكسل" style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;-->
            <!--background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));">-->
            <!--&nbsp;&nbsp;-->
            <input class="btn btn-primary pdf_download" type="button"  value="pdf تنزيل ملف  " style="margin:50px auto; width: 200px; height:40px;
            background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));">
            &nbsp;&nbsp;
            <!--<button  class="btn btn-primary hide"-->
            <!--style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;-->
            <!--background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> حفظ-->
            <!--</button>-->
  </div>




    <script>

    $(document).on('click', '.pdf_download', function () {
        $('.pdf_download').hide() ;
        $('.hide').hide() ;
        window.print();
        setInterval(function() {$('.pdf_download').show() ;}, 5000);
    });

    // certificate js stuff

    var array1 = new Array();
    var array2 = new Array(); // added

    var n = 3; //Total table
    for ( var x=1; x<=n; x++ ) {
        array1[x-1] = x;
        array2[x-1] = x + 'th'; // added
    }

    var tablesToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns.o="urn.schemas-microsoft-com.office.office" xmlns.x="urn.schemas-microsoft-com.office.excel" xmlns="http.//www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x.ExcelWorkbook><x.ExcelWorksheets>'
        , templateend = '</x.ExcelWorksheets></x.ExcelWorkbook></xml><![endif]--></head>'
        , body = '<body>'
        , tablevar = '<table>{table'
        , tablevarend = '}</table>'
        , bodyend = '</body></html>'
        , worksheet = '<x.ExcelWorksheet><x.Name>'
        , worksheetend = '</x.Name><x.WorksheetOptions><x.DisplayGridlines/></x.WorksheetOptions></x.ExcelWorksheet>'
        , worksheetvar = '{worksheet'
        , worksheetvarend = '}'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        , wstemplate = ''
        , tabletemplate = '';

        return function (table, name, filename) {
            var tables = table;

            for (var i = 0; i < tables.length; ++i) {
                wstemplate += worksheet + worksheetvar + i + worksheetvarend + worksheetend;
                tabletemplate += tablevar + i + tablevarend;
            }

            var allTemplate = template + wstemplate + templateend;
            var allWorksheet = body + tabletemplate + bodyend;
            var allOfIt = allTemplate + allWorksheet;

            var ctx = {};
            for (var j = 0; j < tables.length; ++j) {
                ctx['worksheet' + j] = name[j];
            }

            for (var k = 0; k < tables.length; ++k) {
                var exceltable;
                if (!tables[k].nodeType) exceltable = document.getElementById(tables[k]);
                ctx['table' + k] = exceltable.innerHTML;
            }

            //document.getElementById("dlink").href = uri + base64(format(template, ctx));
            //document.getElementById("dlink").download = filename;
            //document.getElementById("dlink").click();

            window.location.href = uri + base64(format(allOfIt, ctx));

        }
    })();



    </script>
	<script  src="{{ asset('assets/certificate/vendor/jquery/jquery-3.2.1.min.js') }}"    ></script>
    <script src="{{ asset('assets/certificate/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/certificate/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="{{ asset('assets/certificate/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/certificate/vendor/tilt/tilt.jquery.min.js') }}"></script>

      <script >
          $('.js-tilt').tilt({
              scale: 1.1
          })
      </script>

      <script  src="{{ asset('assets/certificate/js/main.js') }}"></script>

      <script>
        $(document).ready(function() {

            //English to Arabic digits.
            String.prototype.EntoAr= function() {
                return this.replace(/\d/g, d =>  '٠١٢٣٤٥٦٧٨٩'[d])
                }


            let result = 0 ;
               $.each($('.result1'), function (key, value) {
                  result1 = $( this).data('term1_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;


                })
                $('.result1_total').attr('data-term1_result', result);
                $('.result1_total').next('td.x').data('id',`${result}`);
                $('.result1_total').html((result).toLocaleString('ar-EG'));
               let result11 = 0 ;
               $.each($('.result11'), function (key, value) {
                  result1 = $( this).data('term1_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result11 +=     result1 ;
                })
                $('.result11_total').next('td.x').data('id',`${result11}`);
                $('.result11_total').html( (result11).toLocaleString('ar-EG'))



                 work_degree1_total = 0 ;
               $.each($('.work_degree1'), function (key, value) {
                  result1 = $( this).data('work_degree') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  work_degree1_total +=     result1 ;

                })
                $('.work_degree1_total').html((work_degree1_total).toLocaleString('ar-EG'))
                $('.work_degree1_total').attr('data-work_degree', work_degree1_total);
                $('.work_degree1_total').next('td.x').attr('data-id', work_degree1_total);

                 work_degree2_total = 0 ;
               $.each($('.work_degree2'), function (key, value) {
                  result1 = $( this).data('work_degree') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  work_degree2_total +=     result1 ;

                })
                $('.work_degree2_total').html((work_degree2_total).toLocaleString('ar-EG'))
                $('.work_degree2_total').attr('data-work_degree', work_degree2_total);
                $('.work_degree2_total').next('td.x').attr('data-id', work_degree2_total);

                 exam_total = 0 ;
               $.each($('.exam'), function (key, value) {
                  result1 = $( this).data('exam') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  exam_total +=     result1 ;

                })
                $('.exam_total').html((exam_total).toLocaleString('ar-EG'))
                $('.exam_total').attr('data-exam', exam_total);
                $('.exam_total').next('td.x').attr('data-id', exam_total);


                 work_degree11_total = 0 ;
               $.each($('.work_degree11'), function (key, value) {
                  result1 = $( this).data('work_degree') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  work_degree11_total +=     result1 ;

                })
                $('.work_degree11_total').html((work_degree11_total).toLocaleString('ar-EG'))
                $('.work_degree11_total').next('td.x').attr('data-id', work_degree11_total);

                 work_degree22_total = 0 ;
               $.each($('.work_degree22'), function (key, value) {
                  result1 = $( this).data('work_degree') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  work_degree22_total +=     result1 ;

                })
                $('.work_degree22_total').html((work_degree22_total).toLocaleString('ar-EG'))
                $('.work_degree22_total').next('td.x').attr('data-id', work_degree22_total);

                 exam11_total = 0 ;
               $.each($('.exam11'), function (key, value) {
                  result1 = $( this).data('exam') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  exam11_total +=     result1 ;

                })
                $('.exam11_total').html((exam11_total).toLocaleString('ar-EG'))
                $('.exam11_total').next('td.x').attr('data-id', exam11_total);



          })
      </script>


      {{-- تحويل الأرقام لكتابة --}}

<script>

    /*
    القيم الخاصة بقيم الآحاد
    وحتى الرقم 12
    * */
    var ones = {
        0: "صفر",
        1: "واحد",
        2: "اثنان",
        3: "ثلاثة",
        4: "أربعة",
        5: "خمسة",
        6: "ستة",
        7: "سبعة",
        8: "ثمانية",
        9: "تسعة",
        10: "عشرة",
        11: "أحد عشر",
        12: "اثنى عشر"
    }

    /*
    القيم الخاصة بقيم العشرات
    * */
    var tens = {
        1: "عشر",
        2: "عشرون",
        3: "ثلاثون",
        4: "أربعون",
        5: "خمسون",
        6: "ستون",
        7: "سبعون",
        8: "ثمانون",
        9: "تسعون"
    }


    /*
    القيم الخاصة بقيم المئات
    * */
    var hundreds = {
        0: "صفر",
        1: "مائة",
        2: "مئتان",
        3: "ثلاثمائة",
        4: "أربعمائة",
        5: "خمسمائة",
        6: "ستمائة",
        7: "سبعمائة",
        8: "ثمانمائة",
        9: "تسعمائة"
    }

    /*
    القيم الخاصة بقيم الآلاف
    * */
    var thousands = {
        1: "ألف",
        2: "ألفان",
        39: "آلاف",
        1199: "ألفًا"
    }

    /*
    القيم الخاصة بقيم الملايين
    * */
    var millions = {
        1: "مليون",
        2: "مليونان",
        39: "ملايين",
        1199: "مليونًا"
    }


    /*
    القيم الخاصة بقيم المليارات
    * */
    var billions = {
        1: "مليار",
        2: "ملياران",
        39: "مليارات",
        1199: "مليارًا"
    }

    /*
    القيم الخاصة بقيم التريليونات
    * */
    var trillions = {
        1: "تريليون",
        2: "تريليونان",
        39: "تريليونات",
        1199: "تريليونًا"
    }


    /**
     *
     * @param {*} number
     * هذه هي الدالة الرئيسية
     * والتي يتم من خلالها تفقيط الأرقام
     */
    function tafqeet(number) {

        /**
         * متغير لتخزين النص المفقط بداخله
         */

        var value = "";
        number = parseInt (number);
        //التحقق من أن المتغير يحتوي أرقامًا فقط، وأقل من تسعة وتسعين تريليون
        if (number.toString ().match(/^[0-9]+$/) != null && number.toString().length <= 14) {
            switch (number.toString().length) {
                /**
                 * إذا كان العدد من 0 إلى 99
                 */
                case 1:
                case 2:
                    value = oneTen(number);
                    break;

                /**
                 * إذا كان العدد من 100 إلى 999
                 */
                case 3:
                    value = hundred(number);
                    break;

                /**
                 * إذا كان العدد من 1000 إلى 999999
                 * أي يشمل الآلاف وعشرات الألوف ومئات الألوف
                 */
                case 4:
                case 5:
                case 6:
                    value = thousand(number);
                    break;

                /**
                 * إذا كان العدد من 1000000 إلى 999999999
                 * أي يشمل الملايين وعشرات الملايين ومئات الملايين
                 */
                case 7:
                case 8:
                case 9:
                    value = million(number);
                    break;

                /**
                 * إذا كان العدد من 1000000000 إلى 999999999999
                 * أي يشمل المليارات وعشرات المليارات ومئات المليارات
                 */
                case 10:
                case 11:
                case 12:
                    value = billion(number);
                    break;

                /**
                 * إذا كان العدد من 100000000000 إلى 9999999999999
                 * أي يشمل التريليونات وعشرات التريليونات
                 */
                case 13:
                case 14:
                case 15:
                    value = trillion(number);
                    break;

            }

        }

        /**
         * هذا السطر يقوم فقط بإزالة بعض الزوائد من النص الأخير
         * تظهر هذه الزوائد نتيجة بعض الفروق في عملية التفقيط
         * ولإزالتها يتم استخدام هذا السطر
         */
        return value.replace (/وصفر/g,"")
        .replace (/وundefined/g,"")
        .replace(/ +(?= )/g,'')
        .replace (/صفر و/g,"")
        // .replace (/صفر/g,"")
        .replace (/مئتان أ/,"مائتا أ")
        .replace (/مئتان م/,"مائتا م");
    }


    /**
     *
     * @param {*} number
     * الدالة الخاصة بالآحاد والعشرات
     */
    function oneTen(number) {

        /**
         * القيم الافتراضية
        */
        var value = "صفر";

        //من 0 إلى 12
        if (number <= 12) {
            switch (parseInt (number)) {
                case 0:
                    value = ones["0"];
                    break;
                case 1:
                    value = ones["1"];
                    break;
                case 2:
                    value = ones["2"];
                    break;
                case 3:
                    value = ones["3"];
                    break;
                case 4:
                    value = ones["4"];
                    break;
                case 5:
                    value = ones["5"];
                    break;
                case 6:
                    value = ones["6"];
                    break;
                case 7:
                    value = ones["7"];
                    break;
                case 8:
                    value = ones["8"];
                    break;
                case 9:
                    value = ones["9"];
                    break;
                case 10:
                    value = ones["10"];
                    break;

                case 11:
                    value = ones["11"];
                    break;

                case 12:
                    value = ones["12"];
                    break;


            }
        }

        /**
         * إذا كان العدد أكبر من12 وأقل من 99
         * يقوم بجلب القيمة الأولى من العشرات
         * والثانية من الآحاد
         */
        else {
            var first = getNth (number, 0,0);

            var second = getNth (number, 1,1);

            if(tens[first] == "عشر"){
                value = ones[second] + " " + tens[first];
            }
            else{
                value = ones[second] + " و" + tens[first];
            }

        }

        return value;
    }


    /**
     *
     * @param {*} number
     * الدالة الخاصة بالمئات
     */
    function hundred(number) {
        var value = "";

        /**
         * إذا كان الرقم لا يحتوي على ثلاث منازل
         * سيتم إضافة أصفار إلى يسار الرقم
         */
        while (number.toString().length !=3){
            number = "0"+number;
        }

        var first = getNth (number, 0,0);

        /**
         * تحديد قيمة الرقم الأول
         */
        switch (parseInt(first)) {
            case 0:
                value = hundreds["0"];
                break;
            case 1:
                value = hundreds["1"];
                break;
            case 2:
                value = hundreds["2"];
                break;
            case 3:
                value = hundreds["3"];
                break;
            case 4:
                value = hundreds["4"];
                break;
            case 5:
                value = hundreds["5"];
                break;
            case 6:
                value = hundreds["6"];
                break;
            case 7:
                value = hundreds["7"];
                break;
            case 8:
                value = hundreds["8"];
                break;
            case 9:
                value = hundreds["9"];
                break;
        }

        /**
         * إضافة منزلة العشرات إلى الرقم المفقط
         * باستخدام دالة العشرات السابقة
         */
        value = value + " و"+oneTen (parseInt (getNth (number,1,2)));
        return value;
    }

    /**
     *
     * @param {*} number
     * الدالة الخاصة بالآلاف
     */
    function thousand(number) {
        return thousandsTrillions (thousands["1"],thousands["2"], thousands["39"], thousands["1199"], 0, parseInt (number),  (getNthReverse (number, 4)));
    }

    /**
     *
     * @param {*} number
     * الدالة الخاصة بالملايين
     */
    function million(number) {
        return thousandsTrillions (millions["1"],millions["2"], millions["39"], millions["1199"], 3, parseInt (number),  (getNthReverse (number, 7)));
    }


    /**
     *
     * @param {*} number
     * الدالة الخاصة بالمليارات
     */
    function billion(number) {
        return thousandsTrillions (billions["1"],billions["2"], billions["39"], billions["1199"], 6, parseInt (number),  (getNthReverse (number, 10)));
    }


    /**
     *
     * @param {*} number
     * الدالة الخاصة بالترليونات
     */
    function trillion(number) {
        return thousandsTrillions (trillions["1"],trillions["2"], trillions["39"], trillions["1199"], 9, parseInt (number),  (getNthReverse (number, 13)));
    }


    /**
     * هذه الدالة هي الأساسية بالنسبة للأرقام
     * من الآلاف وحتى التريليونات
     * تقوم هذه الدالة بنفس العملية للمنازل السابقة مع اختلاف
     * زيادة عدد المنازل في كل مرة
     * @param {*} one
     * @param {*} two
     * @param {*} three
     * @param {*} eleven
     * @param {*} diff
     * @param {*} number
     * @param {*} other
     */
    function thousandsTrillions (one, two, three, eleven, diff, number, other){
        /**
         * جلب المنازل المتبقية
         */
        other = parseInt (other);
        other = tafqeet (other);

        /**
         * إذا كان المتبقي يساوي صفر
         */
        if (other == ""){
            other = "صفر"
        }

        var value = "";

        number = parseInt (number);

        /**
         * التحقق من طول الرقم
         * لاكتشاف إلى أي منزلة ينتمي
         */
        switch (number.toString().length){
            /**
             * ألوف، أو ملايين، أو مليارات، أو تريليونات
             */
            case 4+diff:
                var ones = parseInt (getNth (number, 0,0));
                switch (ones){
                    case 1:
                        value = one  + " و"+ (other);
                        break;
                    case 2:
                        value = two + " و"+ (other);
                        break;
                    default:
                        value = oneTen (ones) +" "+ three + " و"+ (other);
                        break;
                }
                break;

            /**
             * عشرات الألوف، أو عشرات الملايين، أو عشرات المليارات، أو عشرات التريليونات
             */
            case 5+diff:
                var tens = parseInt (getNth (number, 0,1));
                switch (tens){
                    case 10:
                        value = oneTen (tens) +" "+ three + " و"+ (other);
                        break;
                    default:
                        value = oneTen (tens) +" "+ eleven + " و"+ (other);
                        break;
                }
                break;

            /**
             *مئات الألوف، أو مئات الملايين، أو مئات المليارات
             */
            case 6+diff:
                var hundreds = parseInt (getNth (number, 0,2));

                var two = parseInt (getNth (number, 1,2));
                var th = "";
                switch (two){
                    case 0:
                        th = one;
                        break;

                    default:
                        th = eleven;
                        break;
                }
                switch (tens){
                    case 100<=tens<=199:
                        value = hundred (hundreds) +" "+ th + " و"+ (other);
                        break;
                    case 200<=tens<=299:
                        value = hundred (hundreds) +" "+ th + " و"+ (other);
                        break;
                    default:
                        value = hundred (hundreds) +" "+ th + " و"+ (other);
                        break;
                }
                break;
        }

        return value;

    }


    /**
     * دالة لجلب أجزاء من الرقم المراد تفقيطه
     */
    function getNth(number, first, end){
        var finalNumber = "";
        for (var i=first;i<=end;i++){
            finalNumber = finalNumber + String (number).charAt(i);
        }
        return finalNumber;
    }

    /**
     * دالة تجلب أجزاء من الرقم بالعكس
     * @param {*} number
     * @param {*} limit
     */
    function getNthReverse(number, limit){
        var finalNumber = "";
        var x = 1;
        while (x != limit){
            finalNumber = String (number).charAt(number.toString().length-x) + finalNumber;
            x++;
        }

        return finalNumber;
    }
    </script>
    <script>
    $(document).ready(function() {
        $.each($('.x'), function (key, value) {
          let my_num = $(this).data('id');
            var tafqeet_number = tafqeet (my_num);
            let min_mark = $(this).data('min_mark');
            let my_style = '' ;
            if(my_num < min_mark) my_style = 'color:red;' ;
            $(this).append(`<p style="margin:0 !important;font-size:8px;font-weight:600;${my_style}"> ${tafqeet_number}</p>` );
         })
         $.each($('.special-subject'), function (key, value) {
            let text = $( this).text() ;
            // let text = $(this).text() ;
            if ( text.includes("زراع") ){
                $(this).siblings().not(".report_details").text('') ;
            }
             if (text.length > 30) {
                $(this).css('font-size','8px')
            }

         })
    });
    </script>





</body>
</html>
