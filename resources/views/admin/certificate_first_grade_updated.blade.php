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
@import url(https://fonts.googleapis.com/earlyaccess/amiri.css);
  /* font-family: 'Amiri', serif; */


 .herozintal{
    width: 115% !important;
    opacity: 1 !important;
    margin-top: 0.7 rem !important;
   height: 1px !important;
   border: 2px;
}
 .vertical {
            border-left: 1px solid rgb(110, 110, 110);
           margin-top: -6px;
           margin-bottom: -6px;
           padding-right: 0px;
           border-left: 2px solid rgb(110, 110, 110);
           height: 60px;
         }
.background-gray{
    /*background: #ddd;*/
}


body{
    font-family:  sans-serif,monospace !important;
}
 table {
   direction: rtl;
     border: 2px solid black;
 }
 th {
     border: 2px solid black;
     padding: 5px;
     background-color:white;
     color: #000;
     font-size: 12px;
 }
 td {
     border: 2px solid black;
     padding: 5px;
     color: #000 !important ;
     font-size: 13px;

 }
 /*td:not(.special-subject){*/
 /*    font-size: 13px;*/
 /*}*/
  td.special-subject{
     font-size: 11px;
     font-weight: 600;
 }
 td p{
  color:  #000 ;
  font-size: 9px ;
 }
 .upper-table td {
     border: 0px ;
     padding: 5px;
 }


.paragraph-os {
    font-family: revert;
    font-weight: 700;
    color: #000;
    font-size: 11px;
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
 .result1_total + td > p{
     font-size:8px;
     font-weight:600;
 }
 .result2_total + td > p{
     font-size:8px;
     font-weight:600;
 }
 .final_result2 + td > p{
     font-size:8px;
     font-weight:600;
 }
 .result11_total + td > p{
     font-size:8px;
     font-weight:600;
 }
 .result22_total  + td > p{
     font-size:8px;
     font-weight:600;
 }
 .final_result22  + td > p{
     font-size:8px;
     font-weight:600;
 }

 .space-separator{
    border: 0px !important ;
}
@media only screen and (max-width: 1200px) {
    /* tablets and desktop */
    .my-title{
        right:50px !important;
    }
    .header-space{
         display: none !important;
    }
}

/* for printing*/
@media print {

    html, body {
      height:100%;
      width:100%;
      margin: 0 !important;
      padding: 0 !important;
      overflow: hidden;
    }
}
 </style>

  @php
        $school_data = \App\School_data::first();
        @endphp
</head>
<body style="margin-top:5%;  background-image: url('../simages/IMG_3225.jpg');background-size: cover;
">



    <form class="limiter"  action="{{ route('save_report_card') }}" method="post">
    @csrf
     <input type="hidden" name="student_id" class="form-control"
                                            value="{{ $student->id }}" required>
      <input type="hidden" name="stage_id" class="form-control"
                                            value="{{ $stage_id }}" required>

	<div style="width:100%" class="animate__animated animate__lightSpeedInRight animate__delay-1s">




     <table id="1" class="table-responsive" style="border-color: white;text-align:center;width:98%;margin:auto "  >

          <tr>
            <td colspan="2" class="upper-table"  style="border-color: white">
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

                                    <h7 class="text-right col-9 "   style="font-weight:600;font-family:'Amiri', serif;margin-right: 25px;"    >
                             مديرية التربية في محافظة: حماه
                                    </h7>
                                    <br>
                                </div>
                                <div class="col-3"></div>
                                <div class="col-9 row">


                                    <h7 class="text-right col-9"   style="font-weight:600;font-family:'Amiri', serif;margin-right: 25px;"  >
                            مدرسة: {{$school_data->name}}  (الافتراضية)
                                    </h7>

                                </div>
                                <div class="col-3"></div>
                            </div>
                        </td>

                        <td   colspan="2" style="position: relative;width:36%;font-family:'Amiri', serif;">
                            <h2 class="my-title" style="font-weight: 600;position: absolute;top:5px;right:12px"> مرحلة التعليم الأساسي  </h2>
                            <h3 class="my-title" style="font-weight: 600;font-size:18px;position: absolute;top:50px;right:40px">  الحلقة الأولى الصف /1-4/    </h3>
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
                                 <div class="col-3 text-right" Style="width:22.333333%">
                                      <p class="paragraph-os">
                                        <span class="paragraph-os ml-4"> الرقم المتسلسل ({{  arabic_w2e($student->serial_number) }})  </span>

                                        <span class="paragraph-os " style="padding-left:25px" > اسم التلميذ/ة: <span> {{ $student->first_name.' '.$student->last_name }}</span>       </span>

                                      </p>
                                      <p class="paragraph-os">تاريخ الميلاد: <span dir="rtl"> {{ arabic_w2e(Carbon\Carbon::parse($student->date_birth)->format('Y/m/d')) }}</span></p>

                                </div>
                                <div class="col-3 " style="text-align: right;width:31.333333%">
                                  <span class="paragraph-os ml-4"> الأب: <span>{{ $student->details->father_name }}</span> </span>

                                  <span class="paragraph-os"> الأم: <span>{{ $student->details->mother_name }}</span></span>
                                </div>

                                <div class="col-6 text-right" style="margin-right: 10px;width:37.5%">
                                  <div class="row mb-3">
                                      <div class="col-4 paragraph-os ml-4"> الصف: <span> {{ $class->name}}</span> </div>
                                      <div class="col-4 paragraph-os"> الشعبة: <span>{{ $room_name }}</span></div>
                                  </div>
                                   <div class="row">
                                      <div class="col-4 paragraph-os ml-4"> اللغة الأجنبية: <span>  الإنجليزية</span> </div>
                                      <div class="col-4 paragraph-os"> الرقم في السجل العام: <span> {{  arabic_w2e($student->public_record_number) }} </span></div>
                                  </div>

                                </div>


                            </div>


                        </td>

                    </tr>
                    {{-- <tr class="text-left">
                      <td></td>
                        <td colspan="">
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
                            <p class="paragraph-os1 text-center" >رقمه في السجل العام: <span style="color:#000">  {{  arabic_w2e($student->public_record_number) }}   </span></p>
                        </td>

                        <td>
                            <p class="paragraph-os1">   العام الدراسي: <span>  {{ arabic_w2e($year_name )}}</span></p>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
            </td>
        </tr>
         <tr style="border-color: white;"  >
            <!-- start table one -->
            <td style="border-color: white;"  >
                <table style="table-layout: fixed;">
                  <thead>
                      <tr >
                        <th  rowspan="1" style="text-align: center;width:14.45%;font-weight:700;font-size:14px;background:#666 !important;color:#fff  !important" >
                            <div style="min-width:100px" >
                            المواد الدراسية
                            </div>
                        </th>
                        <th  rowspan="1"    style="text-align: center;width:9.53%;font-weight:700;font-size:14px;background:#666 !important;color:#fff  !important">
                            تقديرات الفصل الأول
                        </th>
                        <th  rowspan="1"    style="text-align: center;width:8.8%;font-weight:700;font-size:14px ;background:#666 !important;color:#fff  !important">
                            تقديرات الفصل الثاني
                        </th>
                        <th  rowspan="1"    style="text-align: center;width:8.8%;font-weight:700;font-size:14px ;background:#666 !important;color:#fff  !important">
                            التقدير النهائي
                        </th>

                        <th  rowspan="1"    style="width:13.425%;border-top:2px solid #fff;border-bottom:1px solid #fff;"> </th>

                        <th colspan="5" rowspan="1"  style="text-align: center;width:23.33%;font-weight:700;background:#666 !important;color:#fff  !important" >جدول دوام التلميذ  </th>
                        <th colspan="1" rowspan="1"  style="text-align: center;width:21.76%;font-weight:700;background:#666 !important;color:#fff  !important" >التوجيهات التربوية للمعلم    </th>


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


                  </thead>
                  <tbody class="text-center">

                            @foreach ($mark_base_subjects as $key77 => $base_subject)
                            @php
                                $lessons = $base_subject->lessons_mark ;
                                $lesson_count =  count($lessons);
                                // $numItems = count($arr);
                                $i = 0;
                                $addable_lesson_id = 0 ;
                                // dd($lessons);
                                // dd( gettype($lessons)) ;

                            @endphp

                            @foreach ($lessons as $key => $lesson)
                            @if($lesson->certificate_order !=0)

                                @php
                                    if ( $lesson->religion != null)
                                        $lesson_name =  'التربية الدينية' ;
                                    else if($lesson->is_english == 1)
                                        $lesson_name = 'اللغة الأجنبية' ;
                                    else
                                    $lesson_name = $lesson->name ;

                                    $term1_result = 0 ;
                                    $term2_result = 0 ;


                                @endphp
                                @if ($lesson->religion == null || $lesson->religion  == $student->religion)
                                @if ($lesson->is_addable == 1 )

                                    <tr>
                                        <td style="text-align: center;font-weight:600">{{ $lesson_name  }} </td>

                                        <td class="estimation {{($base_subject->lessons_mark2->certificate_order == 11 || $base_subject->lessons_mark2->certificate_order == 13)  ? 'background-gray' : ''}}">
                                            @if(json_decode($student_marks->estimation1) !== null  && $student_rigistration_term == 1)
                                                @foreach(json_decode($student_marks->estimation1) as $key1 => $item1 )
                                                    @if($key1 == $lesson->id )
                                                    {{  $item1 }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="estimation {{($base_subject->lessons_mark2->certificate_order == 11 || $base_subject->lessons_mark2->certificate_order == 13)  ? 'background-gray' : ''}}">
                                            @if(json_decode($student_marks->estimation2) !== null && $current_term == 2)
                                                @foreach(json_decode($student_marks->estimation2) as $key2 => $item2 )
                                                    @if($key2 == $lesson->id )
                                                    {{  $item2 }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="estimation {{($base_subject->lessons_mark2->certificate_order == 11 || $base_subject->lessons_mark2->certificate_order == 13) ? 'background-gray' : ''}}" >
                                            @if(json_decode($student_marks->estimation) !== null && $current_term == 2)
                                                @if($student_rigistration_term == 1)
                                                    @foreach(json_decode($student_marks->estimation) as $key_all => $item_all)
                                                        @if($key_all == $lesson->id )
                                                        {{  $item_all }}
                                                        @endif
                                                    @endforeach
                                                @elseif($student_rigistration_term == 2)
                                                    @foreach(json_decode($student_marks->estimation2) as $key2 => $item2 )
                                                        @if($key2 == $lesson->id )
                                                        {{  $item2 }}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        </td>
                                        <td style="border-bottom:{{$base_subject->lessons_mark2->certificate_order == 14 ? "2px" : "1px"}} solid #fff;border-top:2px solid #fff"></td>
                                    @if($base_subject->lessons_mark2->certificate_order == 1)
                                        <td rowspan="4" style="font-size:12px;font-weight:700;width:6%">
                                          <span style="writing-mode: vertical-rl;white-space: pre;">الدوام المدرسي </span>
                                        </td>
                                        <td rowspan="4" style="font-size:12px;font-weight:700;width:5.55%">
                                          <span style="writing-mode: vertical-rl;white-space: pre;">الدوام الفعلي </span>
                                        </td>
                                        <td rowspan="4" style="font-size:12px;font-weight:700;width:4.25%">
                                          <span style="writing-mode: vertical-rl;white-space: pre;">دوام التلميذ  </span>
                                        </td>
                                        <td colspan="2" style="font-size:12px;font-weight:700">الغياب    </td>
                                        <td  rowspan="7" style="font-size:12px;font-weight:700">
                                            <p style="height: 70px;">
                                                {{isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term2'} : '' }}
                                            </p>
                                        </td>

                                    @endif
                                    @if($base_subject->lessons_mark2->certificate_order == 4)
                                        <td> الفصل الأول</td>
                                        <td  style="text-align: center;">
                                            {{ $student_rigistration_term == 1  ?  arabic_w2e($actual_attendance1) : '' }}

                                        </td>
                                        <td style="text-align: center;">
                                            {{ $student_rigistration_term == 1  ?  arabic_w2e($student_attendance1) : '' }}
                                        </td>

                                        <td style="text-align: center;">
                                            {{ $student_rigistration_term == 1  ?  arabic_w2e($justified_absence1) : ''}}
                                        </td>
                                        <td style="text-align: center;">
                                            {{$student_rigistration_term == 1  ?  arabic_w2e($unjustified_absence1) : ''}}
                                        </td>
                                    @endif
                                    @if($base_subject->lessons_mark2->certificate_order == 5)
                                       <td> الفصل الثاني </td>
                                       <td  style="text-align: center;">
                                        {{ isset( $report_card_details->actual_attendance) ? arabic_w2e(json_decode( $report_card_details->actual_attendance)->{'term2'}) : '' }}

                                        {{-- {{ isset($report_card) ?  arabic_w2e(json_decode($report_card->actual_attendance)->{'term2'}) : ''}} --}}
                                        </td>
                                        <td style="text-align: center;">
                                            {{  isset($report_card) ?  arabic_w2e(json_decode($report_card->student_attendance)->{'term2'}) : ''}}
                                        </td>

                                        <td style="text-align: center;">
                                            {{  isset($report_card) ?  arabic_w2e(json_decode($report_card->justified_absence)->{'term2'}) : ''}}
                                        </td>
                                        <td style="text-align: center;">
                                            {{  isset($report_card) ?  arabic_w2e(json_decode($report_card->unjustified_absence)->{'term2'}) : ''}}
                                        </td>
                                    @endif
                                    @if($base_subject->lessons_mark2->certificate_order == 6)
                                        <td style="text-align: center;"> المجموع </td>
                                        <td style="text-align: center;">{{ arabic_w2e($total_actual_attendance) }}</td>
                                        <td style="text-align: center;"> {{ arabic_w2e($total_student_attendance) }}</td>
                                        <td style="text-align: center;">{{ arabic_w2e($total_justified_absence) }}</td>
                                        <td style="text-align: center;">{{ arabic_w2e($total_unjustified_absence) }}</td>

                                    @endif
                                    @if($base_subject->lessons_mark2->certificate_order == 7)
                                        <td rowspan="2" style="text-align: center;"> النسبة المئوية للدوام </td>
                                        <td rowspan="2" colspan="4" style="text-align: center;">   {{  arabic_w2e(round($attendance_percent,1)). '%' }} </td>
                                        <td rowspan="2" style="text-align: center;">
                                        <div class ="row align-items-center">
                                             <div class="col-6 text-right" style="font-weight:bold"> اسم المعلم وتوقيعه:</div>
                                             <div class="col-6 text-right" style="font-weight:bold">
                                                    {{ $report_card->teacher_name }}
                                             </div>

                                        </div>
                                        </td>


                                    @endif
                                    @if($base_subject->lessons_mark2->certificate_order == 9)
                                        <td colspan="6" rowspan="1" style="font-size:12px;font-weight:700;background:#666;color:#fff !important">
                                           نتيجة التلميذ
                                        </td>
                                    @endif
                                    @if($base_subject->lessons_mark2->certificate_order == 10)
                                        <td colspan="6" rowspan="1" class="text-right">
                                             <div class="row">
                                                <div class="col-6 " style="margin-right:0%;font-weight:700">
                                                    نجاح إلى الصف:
                                                </div>
                                                <div class="col-4">
                                                       @if($report_card->final_result == 2 && $current_term != 1)
                                                            {{ $class->next_class_success->name }}
                                                        @endif
                                                </div>
                                             </div>
                                        </td>
                                    @endif
                                     @if($base_subject->lessons_mark2->certificate_order == 11)
                                        <td colspan="6" rowspan="1" class="report_details text-right">
                                            <div class="row">
                                                <div class="col-6 " style="margin-right:0%; font-weight:700">
                                                    رسوب في الصف:
                                                </div>
                                                <div class="col-4">
                                                    @if($report_card->final_result == 3 && $current_term != 1)
                                                     {{ $class->name }}
                                                      @endif

                                                </div>
                                             </div>
                                        </td>
                                    @endif
                                     @if($base_subject->lessons_mark2->certificate_order == 12)
                                        <td colspan="6" rowspan="1" class="report_details text-right" style="font-size:12px;font-weight:700">
                                            <div class="row">
                                                <div class="col-6">
                                                    نقل إلى الصف:
                                                </div>
                                                <div class="col-6">
                                                    لأنه معيد
                                                </div>

                                            </div>
                                        </td>
                                    @endif
                                     @if($base_subject->lessons_mark2->certificate_order == 13)
                                        <td colspan="6" rowspan="1" class="report_details text-right" style="font-size:12px;font-weight:700">
                                            <div class="row">
                                                <div class="col-6">
                                                    نقل إلى الصف:
                                                </div>
                                                <div class="col-6">
                                                       لاستنفاذ سنوات الرسوب
                                                </div>

                                            </div>
                                        </td>
                                    @endif

                                     @if($base_subject->lessons_mark2->certificate_order == 14)
                                     <td colspan="6" rowspan="3">
                                        <div class="row"   style="height:60px;position: relative;">
                                          <div class="row">
                                            <div class="col-2"> </div>
                                            <div class="col-2">اسم المدير:</div>
                                            <div class="col-3">{{ isset($report_card_details) ? $report_card_details->manager_name : ''}}</div>
                                            <div class="col-2">التوقيع:</div>
                                            <div class="col-2">الختم:</div>
                                            <div class="col-1"></div>
                                          </div>
                                          <div class="row justify-content-center history" style="width:100%;align-self: flex-end;" >
                                            @php
                                                $report_card_date =  isset($report_card_details) ? json_decode($report_card_details->report_card_date)->{'term1'} : '';
                                                $formatted_date1 = empty($report_card_date) ? '' : arabic_w2e(Carbon\Carbon::parse($report_card_date)->format('Y/m/d'));
                                                $report_card_date =  isset($report_card_details) ? json_decode($report_card_details->report_card_date)->{'term2'} : '';
                                                $formatted_date2 = empty($report_card_date) ? '' : arabic_w2e(Carbon\Carbon::parse($report_card_date)->format('Y/m/d'));
                                            @endphp
                                            <div style="margin-left: 3px"> التاريخ:   {{ $current_term == 2 ? $formatted_date2 : $formatted_date1 }}</div>
                                            <!--<div>  {{ $current_term == 2 ? $formatted_date2 : $formatted_date1 }}  </div>        -->
                                            </div>
                                         </div>
                                    </td>
                                    @endif
                                    </tr>

                                @endif

                                @if ($lesson->is_addable == 0 )
                                    @php

                                    $addable_lesson_id++ ;
                                    $base_subject_id = $base_subject->id ;
                                    @endphp
                                    @if( $addable_lesson_id < 2)

                                    <tr>
                                        <td rowspan="3">
                                           <div class="row no-gutters" style="  margin-left: 0 !important;margin-right: 0 !important;">
                                              <div class="col-6 d-flex justify-content-between p-0; ">

                                                  <div style="font-size:12px;font-weight:600;margin:auto">{{  $base_subject->name  }} </div>

                                                <div class = "vertical " ></div>
                                              </div>

                                              <div class="col-6" style="margin: auto; ">
                                                  <h6 style="font-size:11px;margin:2px;font-weight:600">المهارات الشفوية </h6>
                                                  <hr class="my-2 herozintal" >
                                                  <h6 style="font-size:11px;margin:2px;font-weight:600"> المهارات الكتابية</h6>
                                              </div>
                                            </div>
                                        </td>
                                        @foreach ($addable_lessons as $addableKey =>  $lesson2)
                                            @if($base_subject_id == $lesson2->base_subject_id)
                                                <tr style="height:30px">

                                                    <td class="estimation">
                                                        @if(json_decode($student_marks->estimation1) !== null   && $student_rigistration_term == 1)
                                                            @foreach(json_decode($student_marks->estimation1) as $key1 => $item1 )
                                                                @if($key1 == $lesson2->id )
                                                                {{  $item1 }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="estimation">
                                                        @if(json_decode($student_marks->estimation2) !== null && $current_term == 2)
                                                            @foreach(json_decode($student_marks->estimation2) as $key2 => $item2 )
                                                                @if($key2 == $lesson2->id )
                                                                {{  $item2 }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="estimation">
                                                        @if(json_decode($student_marks->estimation) !== null && $current_term == 2)
                                                            @if($student_rigistration_term == 1)
                                                                @foreach(json_decode($student_marks->estimation) as $key_all => $item_all)
                                                                    @if($key_all == $lesson2->id )
                                                                    {{  $item_all }}
                                                                    @endif
                                                                @endforeach
                                                            @elseif($student_rigistration_term == 2)
                                                                @foreach(json_decode($student_marks->estimation2) as $key2 => $item2 )
                                                                    @if($key2 == $lesson2->id )
                                                                    {{  $item2 }}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td style="border-bottom:2px solid #fff;border-top:2px solid #fff"></td>

                                                @if($lesson2->certificate_order == 2)
                                                    <td rowspan="2" style="font-size:11px;font-weight:700;width:3.98%">   مبرر</td>
                                                    <td rowspan="2" style="font-size:11px;font-weight:700;width:3.98%">   غير مبرر  </td>
                                                @endif


                                                </tr>
                                            @endif
                                        @endforeach



                                            </tr>



                                    @endif
                                    @endif
                                    @endif
                                    @endif
                    @endforeach
                @endforeach

                    <tr>
                        <td style="text-align: center;font-size:14px;font-weight:600" >ملاحظات المدير وتوقيعه </td>
                        <td colspan="3" class="gray-background">

                                {{ isset($report_card) ?  $report_card->manager_notes   : ''}}

                        </td>
                        <td style="border-bottom:2px solid #fff"></td>

                    </tr>

                    <tr style="height: 43px">
                        <td style="text-align: center;font-size:14px;font-weight:600" > ملاحظات ولي التلميذ</td>
                        <td colspan="3" class="gray-background"> </td>
                        <td style="border-bottom:2px solid #fff"></td>
                    </tr>




                        </tbody>
                </table>
            </td>
            <!-- end table one -->
            <!-- start table 2-->

            <!-- end table 2 -->
         </tr>
     </table>









 <div class="Row" style="margin: 0 auto ; text-align: center;">

    <!--<input class="btn btn-primary " type="button" onclick="tablesToExcel(array1,'myfile.xlxs')" value="تنزيل ملف اكسل" style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;-->
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

    var n = 1; //Total table
    for ( var x=1; x<=n; x++ ) {
        array1[x-1] = x;

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
      $.each($('.x'), function (key, value) {
          let my_num = $(this).data('id');
            var tafqeet_number = tafqeet (my_num);
            let min_mark = $(this).data('min_mark');
            let my_style = '' ;
            if(my_num < min_mark) my_style =  "color:red; "
            $(this).append(`<p style="margin:0 !important;${my_style}"> ${tafqeet_number}</p>` );
         })
         $.each($('.special-subject'), function (key, value) {
            let text = $( this).text() ;
            // let text = $(this).text() ;
            if ( text.includes("زراع") || text.includes("مهني") ){
                $(this).siblings().not(".report_details").text('') ;
            }
             if (text.length > 30) {
                $(this).css('font-size','10px')
            }

         })




    })
    </script>



</body>
</html>




