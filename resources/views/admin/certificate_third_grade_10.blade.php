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
   justify-content: space-around;

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

 /*style table*/
 table {
   width: 100%;
   border-collapse: collapse;
   direction: rtl;
   text-align: right;
 }
 /* Zebra striping */
 tr:nth-of-type(odd) {
   background: #fff;
 }
 th {
   background: #fff;
   color: #000;
   font-weight: 800;
   font-size: 11px ;
 }
 td, th {
   padding: 6px;
   border: 1px solid #000;
   text-align: center;
 }

 td {
     border: 1px solid black;
     padding: 8px;
     color: #000 !important ;
     font-size: 12px ;

    }
    td:not(.special-subject){
        font-size: 13px;
    }
    td p{
      color:  #000 ;
      font-size: 9px ;
    }
    .upper-table td {
        border: 0px ;
        padding: 5px;
        color : #f00 ;
    }
    .special-subject{
      font-size: 12px ;
    }
    .all-border {
      border: 3px solid #000 ;
    }
    .side-border {
      border-left: 3px solid #000 ;
      border-right: 3px solid #000 ;
    }
    .top-bottom-border {
      border-top: 3px solid #000 ;
      border-bottom: 2px solid #000 ;
    }
    .bottom-border {
      border-bottom: 3px solid #000 ;
    }
    .top-border {
      border-top: 3px solid #000 ;
    }
    .left-border {
      border-left: 3px solid #000 ;
    }
    .right-border {
      border-right: 3px solid #000 ;
    }
    table tr td:nth-child(2),th:nth-child(2) {
      border-left: 3px solid #000 ;
      border-right: 3px solid #000 ;
    }
     table tr td:nth-child(1),th:nth-child(1) {
      border-right: 3px solid #000 ;
    }
    table tr td:nth-child(12),th:nth-child(12) {
      border-left: 1px solid #000 ;

    }
 @media
 only screen and (max-width: 760px),
 (min-device-width: 768px) and (max-device-width: 1024px)  {


 }
 /*end style table */


.paragraph-os {
    font-family: revert;
    font-weight: 600;
    color: #000;
    font-size: 12px;
 }
 .paragraph-os1 {
    font-family: revert;
    font-weight: 500;
    color: #000;
    font-size: 12px;
 }
 .paragraph-os2 {
    font-family: revert;
    font-weight: 600;
    color: #000;
    font-size: 11px;
 }
 .main-p {
    font-family: revert;
    font-weight: 600;
    color: #000;
 }

 h7 {
     font-weight: 700;
 }
body{
    font-family: system-ui;
}

 </style>
 </head>
 <body style=" padding:10px;background-size: cover;
 ">


<form class="limiter"  action="{{ route('save_report_card') }}" method="post">
    @csrf
     <input type="hidden" name="student_id" class="form-control"
                                            value="{{ $student->id }}" required>
      <input type="hidden" name="stage_id" class="form-control"
                                            value="{{ $stage_id }}" required>




<div class="row w-100">

    <table class="upper-table w-100"  style="border-color: white">
        <thead>
              @php
                    function arabic_w2e($str)
                        {
                            $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
                            $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                            return str_replace($arabic_western, $arabic_eastern, $str);
                        }

            @endphp
                <tr class="upper-table">
                <td colspan="2" style="border: 0">
                    <div class="row">
                        <div class="col-6" >
                            <h7 class="text-center"     >
                                الجمهورية العربية السورية  <br>
                                وزارة التربية
                            </h7>
                        </div>
                        <div class="col-6"></div>
                    </div>
                </td>

                <td   colspan="2" style="border: 0">
                  <div class="row">

                    <div class="col-9">
                      <h6  class="text-center" style="font-weight: 600">  الصف  {{ $report_card_design == 6 ? 'الثاني' : 'الأول'  }} الثانوي العام - الفرع العلمي </h6>
                    </div>
                    <div class="col-3"></div>
                  </div>
                </td>

                <td  colspan="2" >
                  <p class="paragraph-os">   العام الدراسي: <span>  {{ arabic_w2e($year_name )}}</span></p>
                </td>



            </tr>
        </thead>
        <tbody>
            <tr class="upper-table">
                <td colspan="2" class="text-right" style="border: 0">
                    <h7  class="text-right" style="margin-right: 0"  >مديرية التربية  في محافظة دمشق   </h7>
                </td>
                <td colspan="2" style="border: 0">
                    <div class="row">
                        <div class="col-9">
                          <h7  class="text-center" style="margin-right: 0"  > {{$school_data->name}}       </h7>
                        </div>
                        <div class="col-3"></div>
                    </div>
                </td>






                <td  colspan="2" >
                    <p class="paragraph-os text-center">الشعبة: <span> {{ $room_name }}</span></p>
                </td>



            </tr>
            <tr class="text-left upper-table">
              <td  colspan="6" style="border: 0">
                <div class="row " style="width:75%;text-align:right;margin-bottom:-15px">
                  <div class="col-2" style="width:13.5% !important">
                    <p class="paragraph-os"> الرقم المتسلسل ({{  arabic_w2e($student->serial_number) }})  </p>
                  </div>
                  <div class="col-2">
                    <p class="paragraph-os "  >  الطالب/ة: <span> {{ $student->first_name.' '.$student->last_name }}</span>       </p>
                  </div>
                  <div class="col-1" style="margin-right:-8px;width:12.5% !important">
                    <p class="paragraph-os"> الأب: <span>{{ $student->details->father_name }}</span> </p>
                  </div>
                  <div class="col-1">
                    <p class="paragraph-os"> الأم: <span> {{ $student->details->mother_name }}</span> </p>
                  </div>
                  <div class="col-2">
                    <p class="paragraph-os">تاريخ الميلاد: <span dir="rtl"> {{ arabic_w2e(Carbon\Carbon::parse($student->date_birth)->format('d-m-Y')) }}</span></p>
                  </div>
                  <div class="col-2">
                    <p class="paragraph-os text-center" >الرقم في السجل العام: <span style="color:#000;">  {{  arabic_w2e($student->public_record_number_secondary) }}   </span></p>
                  </div>
                  <div class="col-1"></div>
                </div>
              </td>

                {{-- <td colspan="">
                    <p class="paragraph-os1 " style="padding-left:25px" > اسم التلميذ/ة: <span> {{ $student->first_name.' '.$student->last_name }}</span>       </p>
                </td>

                <td  colspan="">
                    <p class="paragraph-os1"> الأب: <span>{{ $student->details->father_name }}</span> </p>
                </td>

                <td>
                    <p class="paragraph-os1"> الأم: <span> {{ $student->details->mother_name }}</span> </p>
                </td>
                <td>
                    <p class="paragraph-os1">تاريخ الميلاد: <span dir="rtl"> {{ arabic_w2e(Carbon\Carbon::parse($student->date_birth)->format('d-m-Y')) }}</span></p>
                </td>
                <td>
                    <p class="paragraph-os1 text-center" >رقمه في السجل العام: <span style="color:red">  {{  arabic_w2e($student->public_record_number) }}   </span></p>
                </td> --}}

            </tr>
        </tbody>
    </table>

</div>

<div class="row g-0 w-100" >
        <table id="3" class="text-center" style="border-right:3px solid #000;border-bottom:2px solid #000;" >
            <tbody>
              <tr class="all-border">
               <th rowspan="3" class="right-border" style="text-align: center;width:13.75%;padding:3px;font-size:15px" ><div style="text-align: center;">المواد</div> </th>
               <th class="side-border " style=" text-align: center;width:4.87%;font-size:14px" rowspan="3"> <span style="writing-mode: vertical-rl;white-space: pre;transform: rotate(180deg);">الدرجة العظمى </span></th>
               <th colspan="4" rowspan="1" style="text-align: center;width:27%"> الفصل الأول </th>
               <th colspan="3" rowspan="1" class="side-border" style="text-align: center;width:18.4%"> الفصل الثاني </th>
               <th colspan="3" rowspan="1" style="text-align: center;width:21.4%">النتيجة </th>
               <th colspan="1" rowspan="1" class="right-border" style="width: 14.7%;text-align:center"> ملاحظات الادارة </th>


              </tr>
              <tr>
                <th colspan="1" rowspan="1" style="text-align: center;width:5%;padding:3px;font-size:10px">
                  <div >
                    درجة اعمال
                    <br> الطالب
                  </div >
                </th>
                <th colspan="1" rowspan="1" style="text-align: center;width:5%"> الامتحان </th>
                <th colspan="2" rowspan="1" class="left-border" style="text-align: center;width:17.7%"> المحصلة الأولى </th>
                <th colspan="1" rowspan="1" style="text-align: center;width: 5%;padding:3px;font-size:10px" >
                   <div >
                      درجة اعمال
                      <br> الطالب
                  </div >
                  </th>
                <th colspan="1" rowspan="1" style="text-align: center;width: 5%;"> الامتحان </th>
                <th colspan="1" rowspan="1" style="text-align: center;width:8.5%" >
                  <div >المحصلة الثانية</div>
                </th>
                <th rowspan="2" class="side-border " style="text-align: center;width:5%" > مجموع <br>  محصلتي <br> الفصلين </th>
                <th colspan="2" rowspan="1" class="left-border" style="text-align: center;width:16.5%" > الدرجة النهائية </th>
                <th colspan="1" rowspan="1"  style="text-align: center;" class="left-border" > الفصل الأول  </th>



              </tr>

              <tr class="bottom-border">
                    <td style="text-align:center;width:5%"> ٦٠%</td>
                    <td style="text-align: center;width:5%"> ٤٠%</td>
                    <td style="text-align: center;width:5%" > رقماً </td>
                    <td class="left-border" style="text-align: center;width:12.6%" >
                        <div style=""> كتابة</div>
                    </td>
                    <td style="text-align:center;width:5%"> ٦٠%</td>
                    <td style="text-align: center;width:5%"> ٤٠%</td>
                    <td style="text-align: center;width:5%" > رقماً </td>

                    <td style="text-align: center;width:5%" >
                                    <div style="width: 50px">رقماً</div>

                    </td>
                    <td class="left-border" style="text-align: center;width:11.6%" >
                        <div style="">كتابة</div>
                    </td>
                    <td colspan="1" rowspan="6" class="all-border">
                        @php
                            $teacher_notes1 = '';
                            if(isset($report_card) && isset($report_card->teacher_notes)  )
                                $teacher_notes1 = isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term1'} : '' ;
                        @endphp
                        {{ $student_rigistration_term == 1 ? $teacher_notes1 : '' }}

                    </td>
              </tr>
               @foreach ($mark_base_subjects as $key77 => $base_subject)
                @php
                    $lessons = $base_subject->lessons_mark ;
                    $lesson_count =  count($lessons);
                    // $numItems = count($arr);
                    $i = 0;
                    $term1_work_degree = 0 ;
                    $term2_work_degree = 0 ;
                    $term1_exam_degree = 0 ;
                    $term2_exam_degree = 0 ;
                    $term1_result = 0 ;
                    $term2_result = 0 ;

                @endphp
                    @foreach ($lessons as $key => $lesson)
                        @php
                            $lesson_name = $lesson->name ;
                            if ( $lesson->religion != null)
                                $lesson_name =  'التربية الدينية' ;




                            if ($lesson_count < 2 || $i == 0){
                                // $term1_result = 0 ;
                                // $term2_result = 0 ;
                            }
                            if($lesson_count > 1) {

                                if(json_decode($student_marks->worke_degree) !== null ){
                                    foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 ){
                                        if($key1 == $lesson->id ){

                                            // $term1_result +=  $item1->term1_result ;
                                            $term1_work_degree += $item1->term1_result;
                                        }
                                    }
                                }
                                if(json_decode($student_marks->mark) !== null ){
                                    foreach(json_decode($student_marks->mark) as $key1 => $item1 ){
                                        if($key1 == $lesson->id ){
                                            // $term1_result +=  $item1->exam ;
                                            $term1_exam_degree += $item1->exam  ;
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
                                            $term2_exam_degree += $item1->exam  ;
                                        }
                                    }
                                }
                            }


                        @endphp
                        @if (++$i === $lesson_count)
                            @if ( $lesson->first_total == 1)

                                <form>
                                    <tr>
                                        <td class="special-subject">    {{ $i > 1 ?  $base_subject->name : $lesson_name }} </td>

                                        <td class="max_mark"> {{  arabic_w2e( $lesson->max_mark ) }} </td>
                                        @if($lesson->is_project == 1)
                                            <td colspan="2">
                                                    @if(json_decode($student_marks->worke_degree) !== null && $student_rigistration_term == 1)
                                                        @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                            @if($key1 == $lesson->id )

                                                            @php
                                                                $term1_result +=  $item1->term1_result ;
                                                            @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @if(json_decode($student_marks->mark) !== null && $student_rigistration_term == 1)
                                                    @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                        @if($key1 == $lesson->id )

                                                        @php
                                                            $term1_result +=  $item1->exam  ;
                                                        @endphp
                                                        @endif
                                                    @endforeach
                                                    @endif
                                            </td>
                                        @else
                                            <td>
                                                @if(!($i > 1)  && $student_rigistration_term == 1)
                                                    @if(json_decode($student_marks->worke_degree) !== null )
                                                    @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                        @if($key1 == $lesson->id )
                                                        {{  arabic_w2e($item1->term1_result) }}
                                                        @php
                                                            $term1_result +=  $item1->term1_result ;
                                                        @endphp
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                @elseif($student_rigistration_term == 1)
                                                {{    arabic_w2e($term1_work_degree)  }}
                                                    @php
                                                    $term1_result +=  $term1_work_degree ;
                                                    @endphp
                                                @endif
                                            </td>
                                            <td>
                                                @if(!($i > 1) && $student_rigistration_term == 1)
                                                    @if(json_decode($student_marks->mark) !== null )
                                                    @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                        @if($key1 == $lesson->id )
                                                        {{  arabic_w2e($item1->exam)   }}
                                                        @php
                                                            $term1_result +=  $item1->exam  ;
                                                        @endphp
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                @elseif( $student_rigistration_term == 1)
                                                {{  arabic_w2e($term1_exam_degree) }}
                                                @php
                                                $term1_result +=  $term1_exam_degree ;
                                                @endphp
                                                @endif
                                            </td>
                                        @endif
                                        <td class="result1" data-term1_result="{{  $student_rigistration_term == 1 ? $term1_result : '' }}"
                                        @if( $term1_result  < $lesson->min_mark)
                                        style="color:red !important;"
                                       @endif
                                        > {{  arabic_w2e($student_rigistration_term == 1 ? $term1_result : '') }} </td>

                                        <td class="{{$student_rigistration_term == 1 ? 'x' : ''}} left-border" data-id="{{  $student_rigistration_term == 1 ? $term1_result : '' }}" data-min_mark="{{  $lesson->min_mark }}"> </td>

                                        @if($lesson->is_project == 1)
                                        <td colspan="2">
                                            @if(json_decode($student_marks->worke_degree) !== null && $current_term == 2)
                                            @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )
                                                    @php
                                                        $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                                        $term2_result +=   $x ;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @endif
                                            @if(json_decode($student_marks->mark2) !== null  && $current_term == 2)
                                            @foreach(json_decode($student_marks->mark2) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )

                                                @php
                                                    $term2_result +=  $item1->exam  ;
                                                @endphp
                                                @endif
                                            @endforeach
                                            @endif
                                        </td>
                                        @else
                                        <td>
                                            @if(!($i > 1))
                                                @if(json_decode($student_marks->worke_degree) !== null && $current_term == 2)
                                                @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                    @if($key1 == $lesson->id )
                                                        {{    $item1->term2_result == 'null' ? '' : arabic_w2e($item1->term2_result) }}

                                                        @php
                                                            $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                                            $term2_result +=   $x ;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @endif
                                            @else
                                             {{  $current_term == 2 ? arabic_w2e($term2_work_degree)  : ''  }}
                                             @php
                                             $term2_result +=  $term2_work_degree ;
                                            @endphp
                                            @endif
                                        </td>
                                        <td>
                                            @if(!($i > 1))
                                                @if(json_decode($student_marks->mark2) !== null && $current_term == 2)
                                                @foreach(json_decode($student_marks->mark2) as $key1 => $item1 )
                                                    @if($key1 == $lesson->id )
                                                    {{  arabic_w2e($item1->exam) }}
                                                    @php
                                                        $term2_result +=  $item1->exam ;
                                                    @endphp
                                                    @endif
                                                @endforeach
                                                @endif
                                            @else
                                           {{ $current_term == 2 ? arabic_w2e($term2_exam_degree) : '' }}
                                            @php
                                             $term2_result +=  $term2_exam_degree ;
                                            @endphp
                                            @endif
                                        </td>
                                        @endif



                                        <td class="result2" data-term2_result="{{  $current_term == 2 ? $term2_result : '' }}"
                                        @if( $term2_result  < $lesson->min_mark)
                                        style="color:red !important;"
                                       @endif
                                        > {{  arabic_w2e($current_term == 2 ? $term2_result : '') }} </td>

                                            {{-- <td class="x" data-id="{{ $term2_result }}"> </td> --}}

                                         @php
                                            $theToltalResult = $term1_result + $term2_result ;
                                            $dividingRatio =  $student_rigistration_term == 1 ? 2 : 1 ;
                                            $theFinalResult = $theToltalResult / $dividingRatio ;
                                          @endphp
                                        <td class="total_result side-border " data-total_result="{{$current_term == 2 ? $theToltalResult  : '' }}">
                                          {{   arabic_w2e( $current_term == 2 ? $term1_result + $term2_result  : ''  ) }}
                                        </td>

                                        <td class="final_result" data-final_result="{{$current_term == 2 ? ceil($theFinalResult)  : ''  }}"
                                          @if( ceil($theFinalResult)  < $lesson->min_mark)
                                          style="color:red !important;"
                                          @endif
                                        > {{$current_term == 2 ? arabic_w2e(ceil($theFinalResult))  : '' }} </td>


                                        <td class="x" data-id="{{$current_term == 2 ? ceil($theFinalResult)  : '' }}" data-min_mark="{{  $lesson->min_mark }}"> </td>
                                        @if($base_subject->lessons_mark2->certificate_order == 6)
                                            <td colspan="1" rowspan="1" class="text-center all-border">
                                                الفصل الثاني
                                            </td>
                                        @endif
                                        @if($base_subject->lessons_mark2->certificate_order == 7)
                                            <td colspan="1" rowspan="7" class="text-center all-border">
                                                @if(isset($report_card) && isset($report_card->teacher_notes)  )
                                                    {{json_decode($report_card->teacher_notes)->{'term2'} }}
                                                @endif
                                            </td>
                                        @endif
                                        @if($base_subject->lessons_mark2->certificate_order == 14)
                                            <td colspan="1" rowspan="10" class="text-center  all-border" style="position: relative">
                                               <div style="width:100%">
                                                <br>
                                                <br>
                                                <br>

                                                    <h6 class="paragraph-os2">النتيجة النهائية</h6>
                                                    <br>
                                                    <h6 class="paragraph-os2">نجاح إلى:
                                                       <span class="mr-1">
                                                         @if($report_card->final_result == 2 && $current_term != 1)
                                                            {{ $class->next_class_success->name }}
                                                        @endif
                                                        </span>
                                                    </h6>
                                                    <br>
                                                    <br>
                                                    <br>


                                                    <h6 class="paragraph-os2">رسوب في:
                                                         <span class="mr-1">
                                                            @if($report_card->final_result == 3 && $current_term != 1)
                                                                {{ $class->name }}
                                                            @endif
                                                        </span>
                                                    </h6>
                                                    <br>
                                                    <br>
                                                    <br>



                                                </div>
                                                <div class="row g-0 w-100   " style="">
                                                    <div class="col-7 g-0">
                                                        <div class=" text-left paragraph-os2 ml-3">اسم المدير</div>
                                                        <div class="text-right paragraph-os2">{{ isset($report_card_details) ? $report_card_details->manager_name : ''}}</div>
                                                    </div>
                                                    <!--<div class="col-1"></div>-->
                                                    <div class="col-5 g-0">
                                                        <div class="paragraph-os2 text-center">التوقيع والختم</div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>

                                    @endif
                                @endif
                            @endforeach
                        @endforeach





                        <tr class="top-border">
                            <td>المجموع العام </td>
                            <td

                            >{{ arabic_w2e($report_card_design == 5 ? 4000 : 3800) }}</td>
                           <td colspan="2" rowspan="3" class="left-border" style="background: #ccc"></td>
                           <td class="{{ $student_rigistration_term == 1 ? 'result1_total result11' : '' }}" ></td>
                           <td class="{{$student_rigistration_term == 1 ? 'x' : ''}}" Style="font-size:8px;font-weight:600">  </td>
                           <td colspan="2" rowspan="3" class="side-border" style="background: #ccc"></td>
                           <td class="{{ $current_term == 2 ? ' result2_total result22 ' : '' }}"  > </td>

                           <td class="{{ $current_term == 2 ? ' total_result1 total_result2 ' : '' }} right-border" ></td>
                           <td class="{{ $current_term == 2 ? 'final_result1 final_result2 ' : '' }} side-border" ></td>
                           <td class="x" data-id="" Style="font-size:8px;font-weight:600"></td>



                          </tr>

             {{-- ********************************************************* --}}
             @foreach ($mark_base_subjects as $key77 => $base_subject)
                        @php
                            $lessons = $base_subject->lessons_mark ;
                            $lesson_count =  count($lessons);
                            // $numItems = count($arr);
                            $i = 0;
                            $term1_work_degree = 0 ;
                            $term2_work_degree = 0 ;
                            $term1_exam_degree = 0 ;
                            $term2_exam_degree = 0 ;
                            $term1_result = 0 ;
                            $term2_result = 0 ;

                        @endphp
                            @foreach ($lessons as $key => $lesson)
                                @php
                                    if ( $lesson->religion != null)
                                        $lesson_name =  'التربية الدينية' ;
                                    else if($lesson->is_english == 1)
                                        $lesson_name = 'اللغة الأجنبية' ;
                                    else
                                     $lesson_name = $lesson->name ;



                                    if($lesson_count > 1) {

                                        if(json_decode($student_marks->worke_degree) !== null ){
                                            foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 ){
                                                if($key1 == $lesson->id ){

                                                    $term1_work_degree += $item1->term1_result;
                                                }
                                            }
                                        }
                                        if(json_decode($student_marks->mark) !== null ){
                                            foreach(json_decode($student_marks->mark) as $key1 => $item1 ){
                                                if($key1 == $lesson->id ){
                                                    $term1_exam_degree += $item1->exam  ;
                                                }
                                            }
                                        }
                                        if(json_decode($student_marks->worke_degree) !== null ){
                                            foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 ){
                                                if($key1 == $lesson->id ){

                                                    $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                                    $term2_work_degree +=   $x ;
                                                }
                                            }
                                        }
                                        if(json_decode($student_marks->mark2) !== null ){
                                            foreach(json_decode($student_marks->mark2) as $key1 => $item1 ){
                                                if($key1 == $lesson->id ){
                                                    $term2_exam_degree += $item1->exam  ;
                                                }
                                            }
                                        }
                                    }

                                @endphp
                                @if (++$i === $lesson_count)
                                    @if ( $lesson->first_total == 0)

                                        <form>
                                            <tr>
                                                <td class="special-subject">    {{ $i > 1 ?  $base_subject->name : $lesson_name }} </td>

                                                <td class=" max_mark2">{{  arabic_w2e( $lesson->max_mark ) }}  </td>
                                                @if($lesson->is_project == 1)

                                                            @if(json_decode($student_marks->worke_degree) !== null && $student_rigistration_term == 1)
                                                                @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                                    @if($key1 == $lesson->id )

                                                                    @php
                                                                        $term1_result +=  $item1->term1_result ;
                                                                    @endphp
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            @if(json_decode($student_marks->mark) !== null && $student_rigistration_term == 1)
                                                            @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                                @if($key1 == $lesson->id )

                                                                @php
                                                                    $term1_result +=  $item1->exam  ;
                                                                @endphp
                                                                @endif
                                                            @endforeach
                                                            @endif

                                                @endif
                                                <td class="result11 top-bottom-border" data-term1_result="{{  $student_rigistration_term == 1 ? $term1_result : '' }}"
                                                @if( $term1_result  < $lesson->min_mark)
                                                style="color:red !important;"
                                               @endif
                                                > {{  arabic_w2e( $student_rigistration_term == 1 ? $term1_result : '') }} </td>


                                                <td class="{{$student_rigistration_term == 1 ? 'x' : ''}}  top-bottom-border" data-id="{{ $term1_result }}" data-min_mark="{{  $lesson->min_mark }}">
                                                </td>
                                                @if($lesson->is_project == 1)

                                                    @if(json_decode($student_marks->worke_degree) !== null && $current_term == 2)
                                                    @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                        @if($key1 == $lesson->id )
                                                            @php
                                                                $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                                                $term2_result +=   $x ;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                    @if(json_decode($student_marks->mark2) !== null && $current_term == 2)
                                                    @foreach(json_decode($student_marks->mark2) as $key1 => $item1 )
                                                        @if($key1 == $lesson->id )

                                                        @php
                                                            $term2_result +=  $item1->exam  ;
                                                        @endphp
                                                        @endif
                                                    @endforeach
                                                    @endif

                                                @endif

                                                <td class="result22 top-bottom-border" data-term2_result="{{ $current_term == 2 ? $term2_result : ''}}"
                                                @if( $term2_result  < $lesson->min_mark)
                                                style="color:red !important;"
                                               @endif
                                                > {{ $current_term == 2 ?   arabic_w2e($term2_result) : ''}} </td>
                                                 @php
                                                    $theToltalResult = $term1_result + $term2_result ;
                                                    $dividingRatio =  $student_rigistration_term == 1 ? 2 : 1 ;
                                                    $theFinalResult = $theToltalResult / $dividingRatio ;
                                                  @endphp
                                                <td class="total_result2  top-bottom-border right-border " data-total_result="{{ $current_term == 2 ?  $theToltalResult : ''}}"> {{ $current_term == 2 ?  arabic_w2e($term1_result + $term2_result)  : ''}}  </td>


                                                <td class="final_result2 top-bottom-border side-border"  data-final_result="{{ ceil($theFinalResult) }}"
                                                @if( ceil($theFinalResult)  < $lesson->min_mark)
                                                style="color:red !important;"
                                                @endif
                                                > {{ $current_term == 2 ? arabic_w2e(ceil($theFinalResult))  : ''}} </td>
                                                <td class="x  top-bottom-border" data-id="{{ $current_term == 2 ?  ceil($theFinalResult) :'' }}" data-min_mark="{{  $lesson->min_mark }}"> </td>

                                            </tr>
                                        </form>

                                    @endif
                                @endif
                            @endforeach
                        @endforeach



    {{-- ****************************************************************************** --}}


    <tr class="bottom-border">
        <td> المجموع النهائي </td>
        <td>{{ arabic_w2e($report_card_design == 5 ? 4200 : 4000) }}</td>


        <td  class="{{  $student_rigistration_term == 1 ? 'result11_total' : '' }}"></td>
        <td class="{{$student_rigistration_term == 1 ? 'x' : ''}}" Style="font-size:8px;font-weight:600">   </td>

        <td class="{{ $current_term == 2 ? ' result22_total ' : '' }}" ></td>
        {{-- <td></td> --}}
        <td class="{{ $current_term == 2 ? ' total_result22  ' : '' }} right-border"></td>
        <td class="{{ $current_term == 2 ? ' final_result22 ' : '' }} side-border "></td>
        <td class="x" data-id="" Style="font-size:8px;font-weight:600"></td>

     </tr>


              <tr>
                 <td rowspan="2">الدوام </td>
                 <td rowspan="2"> الفعلي </td>
                 <td colspan="4" style="text-align: center;">الغياب  </td>
                 <td rowspan="1" colspan="3" class="side-border" style="text-align: center; ">ملاحظات ولي الأمر وتوقيعه </td>
                 <td rowspan="4" colspan="2" style="text-align: center;">   ترتيب النجاح </td>
                 <td rowspan="4" colspan="1" class="right-border"></td>
              </tr>
              <tr>
                 <td> مبرر</td>
                 <td colspan="2" style="border:1px">غير مبرر</td>
                 <td> المجموع </td>
                 <td rowspan="3" colspan="3" class="side-border">  </td>
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




                $student_attendance2 =   isset($report_card) ?  json_decode($report_card->student_attendance)->{'term2'} : 0 ;
                $actual_attendance2 =    isset($report_card_details->actual_attendance) ?  json_decode($report_card_details->actual_attendance)->{'term2'} : 0;
                $justified_absence2 =    isset($report_card) ?  json_decode($report_card->justified_absence)->{'term2'} : 0;
                $unjustified_absence2 =  isset($report_card) ? json_decode($report_card->unjustified_absence)->{'term2'} : 0;

                $total_student_attendance =  $student_attendance1 +  $student_attendance2 ;
                $total_actual_attendance =  $actual_attendance1 +  $actual_attendance2 ;
                $total_justified_absence =  $justified_absence1 +  $justified_absence2 ;
                $total_unjustified_absence =  $unjustified_absence1 +  $unjustified_absence2 ;

                $term1_student_attendance = $actual_attendance1 - $justified_absence1 - $unjustified_absence1 ;
                $term2_student_attendance = $actual_attendance2 - $justified_absence2 - $unjustified_absence2 ;


                $attendance_percent = $total_student_attendance / ($total_actual_attendance != 0 ? $total_actual_attendance : 1 )  * 100 ;
                $term1_attendance_percent = $student_attendance1 / ($actual_attendance1 != 0 ? $actual_attendance1 : 1 )  * 100 ;
                $term2_attendance_percent = $student_attendance2 / ($actual_attendance2 != 0 ? $actual_attendance2 : 1 )  * 100 ;
              @endphp
              <tr>
               <td> الفصل الأول </td>
                <td>{{$student_rigistration_term == 1 ? $actual_attendance1 : ''}}</td>

               <td>{{ $student_rigistration_term == 1 ? $justified_absence1 : ''}}</td>
               <td colspan="2"> {{   $student_rigistration_term == 1 ? $unjustified_absence1 : ''}}</td>

               <td> {{$student_rigistration_term == 1 ?  arabic_w2e(  ceil($term1_student_attendance) ) : ''}}</td>


              </td>
              </tr>
              <tr>
               <td> الفصل الثاني </td>
               <td>{{ isset($report_card_details->actual_attendance) ? arabic_w2e( json_decode($report_card_details->actual_attendance)->{'term2'}) : '٠'}}</td>

               <td>{{  isset($report_card) ?  arabic_w2e( json_decode($report_card->justified_absence)->{'term2'}) : '٠'}}</td>
               <td colspan="2"> {{  isset($report_card) ?  arabic_w2e( json_decode($report_card->unjustified_absence)->{'term2'}) : '٠'}}</td>

               <td> {{ arabic_w2e(  ceil($term2_student_attendance) )}}</td>



              </tr>
              <tr class="top-bottom-border">
               <td colspan="9">

                <div class="row  text-right">
                    <span class="col-2 paragraph-os2">   اسم الموجه وتوقيعه:</span>
                    <span class="col-2 paragraph-os2">  {{ isset($report_card_details) ? $report_card_details->instructor_name : ''}} </span>
                    <span class="col-3 paragraph-os2">   توقيع المدير:  </span>
                    <span class="col-1 paragraph-os2">  </span>
                    <span class="col-1 paragraph-os2">  </span>
                    <span class="col-1 paragraph-os2">    </span>
                    @php
                    $report_card_date =  isset($report_card_details) ? json_decode($report_card_details->report_card_date)->{'term1'} : '' ;
                    $formatted_date = empty($report_card_date) ? '' : arabic_w2e(Carbon\Carbon::parse($report_card_date)->format('Y/m/d'))  ;
                    @endphp
                    <span class="col-2 paragraph-os2 text-left">  في   {{$formatted_date }}    </span>
                </div>
               </td>
               <td colspan="4" >
                <div class="row justify-content-start" >
                    <span class="col-7 paragraph-os2 text-right">اسم الموجه وتوقيعه:  {{ isset($report_card_details) ? $report_card_details->instructor_name : ''}}</span>
                    <span class="col-5 text-right">في</span>
                </div>
               </td>
               {{-- <td> عمر خليل</td>
               <td> </td>
               <td> توقيع المدير </td>
               <td> <input class="form-control" style="height:40px; width:60px"> </td> --}}

              </tr>


            </tbody>
         </table>


    </div>








    <div class="Row" style="margin: 0 auto ; text-align: center;">
             <!--<a id="dlink"  style="display:none;"></a>-->
             <!--<input class="btn btn-primary " type="button" onclick="tablesToExcel(array1, array2, 'myfile.xls')" value="تنزيل ملف اكسل" style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;-->
             <!--background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));">-->
             <!--&nbsp;&nbsp;-->
               <input class="btn btn-primary pdf_download" type="button"  value="pdf تنزيل ملف  " style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;
            background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));">
            &nbsp;&nbsp;
            <!--<button  class="btn btn-primary hide"-->
            <!--style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;-->
            <!--background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> حفظ-->
            <!--</button>-->
    </div>

     </form>



    <script>
    $(document).on('click', '.pdf_download', function () {
        $('.pdf_download').hide() ;
        $('.hide').hide() ;
        window.print();
        setInterval(function() {$('.pdf_download').show() ;}, 5000);
    });

    $(document).on('click', '.graduate', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('.room_name').val(name);
    $('.room_id').val(id);
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

                  //   result1 = $( this).text() ;
                  //   result1 = result1.length == 0 ? 0 : result1;
                  //   result1 = parseInt(result1) ;
                  //   result +=     result1 ;
                  //   $('.result1_total').html(result)
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

               let result2 = 0 ;
               $.each($('.result2'), function (key, value) {
                  result1 = $( this).data('term2_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result2 +=     result1 ;
                })
                $('.result2_total').attr('data-term2_result', result2);
                $('.result2_total').next('td.x').data('id',`${result2}`);
                $('.result2_total').html( (result2).toLocaleString('ar-EG'));
               let result22 = 0 ;
               $.each($('.result22'), function (key, value) {
                  result1 =  $( this).data('term2_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result22 +=     result1 ;
                })
                $('.result22_total').next('td.x').data('id',`${result22}`);
                $('.result22_total').html((result22).toLocaleString('ar-EG'))
            //    let max_mark = 0 ;
            //    $.each($('.max_mark'), function (key, value) {
            //       result1 = $( this).text() ;
            //       result1 = result1.length == 0 ? 0 : result1;
            //       result1 = parseInt(result1) ;
            //       max_mark +=     result1 ;
            //       $('.max_mark_total1').html(max_mark)
            //    })
            //    let max_mark2 = 0 ;
            //    $.each($('.max_mark2'), function (key, value) {
            //       result1 = $( this).text() ;
            //       result1 = result1.length == 0 ? 0 : result1;
            //       result1 = parseInt(result1) ;
            //       max_mark2 +=     result1 ;
            //       $('.max_mark_total2').html(max_mark2)
            //    })
               let total_result = 0 ;
               $.each($('.total_result'), function (key, value) {
                  result1 = $( this).data('total_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  total_result +=     result1 ;
                })
                $('.total_result1').attr('data-total_result', total_result);
                $('.total_result1').html((total_result).toLocaleString('ar-EG'))
               let final_result = 0 ;
               $.each($('.final_result'), function (key, value) {
                  result1 = $( this).data('final_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  final_result +=     result1 ;
                })
                $('.final_result1').attr('data-final_result', final_result);
                $('.final_result1').html((final_result).toLocaleString('ar-EG'))
                $('.final_result1').next('td.x').data('id',`${final_result}`);
               let total_result2 = 0 ;
               $.each($('.total_result2'), function (key, value) {
                  result1 = $( this).data('total_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  total_result2 +=     result1 ;
                })
                $('.total_result22').html((total_result2).toLocaleString('ar-EG'))
               let final_result2 = 0 ;
               $.each($('.final_result2'), function (key, value) {
                  result1 = $( this).data('final_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  final_result2 +=     result1 ;

                })
                $('.final_result22').html((final_result2).toLocaleString('ar-EG'))
                $('.final_result22').next('td.x').data('id',`${final_result2}`);

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
        1: "مئة",
        2: "مئتان",
        3: "ثلاثمئة",
        4: "أربعمئة",
        5: "خمسمئة",
        6: "ستمئة",
        7: "سبعمئة",
        8: "ثمانمئة",
        9: "تسعمئة"
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
            if(my_num < min_mark) my_style = 'color:red;margin:0 !important' ;
            $(this).append(`<p style="margin:0 !important;${my_style}"> ${tafqeet_number}</p>` );
         })
         $.each($('.special-subject'), function (key, value) {
            let text = $( this).text() ;
            // let text = $(this).text() ;
            if ( text.includes("زراع") || text.includes("مهني") ){
                $(this).siblings().not(".report_details").text('') ;
            }

         })




    })
    </script>


</body>
</html>




