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
	<link rel="stylesheet" type="text/css"   href="{{ asset('assets/certificate/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css"  href="{{ asset('assets/certificate/vendor/animate/animate.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/certificate/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/certificate/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->



<link rel="stylesheet" type="text/css" href="{{ asset('assets/certificate/css/util.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/certificate/css/main.css') }}">

<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<!--===============================================================================================-->
<link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/css/tableexport.min.css" integrity="sha512-QNApdXD0OM7mWwz9n+xCNgjfkYe7Usw17xroPYOtsnVQqTQfardTXrrUWyvkcpkmYaeVn3KS0ps0BLbV59KCQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<style>

    /*checkbox */
    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:600&display=swap');


 .tab1cards {
   display: flex;
   flex-direction: row;
   justify-content: center;

 }
 .tab1cards2 {
   display: flex;
   flex-direction: row;
   justify-content: start;

 }


 table {
   direction: rtl;
     border: 2px solid black;
 }
 th {
     border: 2px solid black;
     padding: 5px;
     background-color: #aeafb0ad;
     color: #000;
 }
 td {
     border: 1px solid black;
     padding: 5px;
 }
 .upper-table  {
     border: 0px ;

 }
 .upper-table td {
     border: 0px ;
     padding: 5px;
 }


 .vertical {
             border-left: 1px solid rgb(110, 110, 110);
             height: 81px;
             position:absolute;

         }

 .paragraph-os {
    font-family: revert;
    font-weight: 700;
    color: #000;
 }
 .paragraph-os1 {
    font-family: revert;
    font-weight: 500;
    color: #000;
 }

 page[size="A4"][layout="portrait"] {
  width: 29.7cm;
  height: 21cm;
}
page[size="A3"] {
  width: 29.7cm;
  height: 42cm;
}
page[size="A3"][layout="portrait"] {
  width: 42cm;
  height: 29.7cm;
}

  @media print {

html, body {
  height:100%;
  width:100%;
  margin: 0 !important;
  padding: 0 !important;
  overflow: hidden;
}

}
@media only screen and (min-width: 992px) {
    .printing1 {

    /* top:-50px; */
}
}

 .printing1 {
    position: absolute;
    /* top:-100px; */
}
.printing2 {
    transform: scale(0.95145833333, 0.95111111111);
}
.base-table{
    width: 100%;
    height: 100%;
}
.gray-background{
    background: #aeafb0ad ;
}

 </style>


</head>
<body style="margin-top:5%;  background-image: url('../simages/IMG_3225.jpg');background-size: cover;
">

    <!--<form class="limiter"  action="{{ route('save_report_card') }}" method="post">-->
    <page size="A3" layout="portrait">
    @csrf
      <input type="hidden" name="student_id" class="form-control"
                                            value="{{ $student->id }}" required>
      <input type="hidden" name="stage_id" class="form-control"
                                            value="{{ $stage_id }}" required>

    <div class="">
        <table class="base-table" style="border-color: white;" id="base-table">
            <tr>
               <td colspan="2" class="upper-table">
                <table class="upper-table w-100">
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
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="text-center"     >
                                            الجمهورية العربية السورية  <br>
                                            وزارة التربية
                                        </h5>
                                    </div>
                                    <div class="col-4"></div>
                                </div>
                                 {{-- <h5 class="text-center mb-2"> <span> وزارة التربية </span></h5> --}}
                            </td>

                            <td   colspan="3" class="text-center">
                                <h4 >مرحلة التعليم الأساسي الحلقة الأولى /١ - ٤/  </h4>
                            </td>

                            <td  colspan="2">
                                <p class="paragraph-os text-center">   اللغة:  </p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                 <h5  class="text-right" style="margin-right: 0"  > {{$school_data->name}}  </h5>
                            </td>

                            <td  colspan="2">
                                <p class="paragraph-os"> الرقم المتسلسل ({{  arabic_w2e($student->serial_number) }})  </p>
                            </td>
                            <td>
                                <p class="paragraph-os text-center">الصف: <span> {{ $class->name}}</span></p>
                            </td>
                            <td>
                                <p class="paragraph-os text-center">الشعبة: <span> {{ $room_name }}</span></p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="text-left">
                            <td colspan="">
                                <p class="paragraph-os1 text-right pr-4" > اسم التلميذ/ة: <span> {{ $student->first_name.' '.$student->last_name }}</span>       </p>
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
                                <p class="paragraph-os1 text-center">رقمه في السجل العام: <span>  {{  arabic_w2e($student->public_record_number) }}   </span></p>
                            </td>
                            <td>
                                <p class="paragraph-os1">   العام الدراسي: <span>  {{ arabic_w2e($year_name )}}</span></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
               </td>
            </tr>
        {{-- <tr class="upper-table">
            <td colspan="2">

                <div class="row d-flex justify-content-between mb-2" >
                    <div class="col-3">

                        <h5 class="text-center"     >الجمهورية العربية السورية</h5>
                        <h5 class="text-center"> <span> وزارة التربية </span></h5>

                    </div>
                    <div class="row col-9">
                        <div class="col-9 ">
                            <h4 class="text-center">مرحلة التعليم الأساسي الحلقة الأولى /١ - ٤/  </h4>
                        </div>
                        <div class="col-3 pr-4">
                            <p class="paragraph-os">اللغة:</p>
                        </div>
                    </div>
                </div>


            </td>

        </tr>
        <tr class="upper-table mt-2">
            <td colspan="2">

                <div class="row d-flex justify-content-between">
                    <div class="col-4">

                        <h5    >مدارس البيان النموذجية الخاصة  </h5>

                    </div>

                    <div class="col-2 ">
                        <p class="paragraph-os"> الرقم المتسلسل (1)  </p>
                    </div>
                    <div class="col-2 ">

                    </div>

                    <div class="col-2">
                        <p class="paragraph-os">الصف: <span> الثاني</span></p>
                    </div>
                    <div class="col-2">
                        <p class="paragraph-os">الشعبة: <span> الأولى</span></p>
                    </div>

                </div>


            </td>

        </tr>
        <tr class="upper-table mt-2">
            <td colspan="2">

                <div class="row d-flex justify-content-between">
                    <div class="col-2">

                        <p class="paragraph-os1"> اسم التلميذ/ة: <span> test student</span>       </p>

                    </div>

                    <div class="col-2 ">
                        <p class="paragraph-os1"> الأب: <span>father</span> </p>
                    </div>
                    <div class="col-2 ">
                        <p class="paragraph-os1"> الأم: <span>mother</span> </p>
                    </div>

                    <div class="col-2">
                        <p class="paragraph-os1">تاريخ الميلاد: <span> 5/4/2015</span></p>
                    </div>
                    <div class="col-2">
                        <p class="paragraph-os1">رقمه في السجل العام: <span> 1105</span></p>
                    </div>
                    <div class="col-2">
                        <p class="paragraph-os1">   العام الدراسي: <span> 2020/2021</span></p>
                    </div>

                </div>


            </td>

        </tr> --}}

            <!-- start first table-->
            <td style="border: 0px">
                <div style=" height: 100%;margin-top:-18px">
                    <table  class="h-100 w-100">
                        <thead>
                            <tr>
                            <th   style="text-align: center;" >المواد الدراسية </th>
                                <th    style="text-align: center;width:25%" >تقديرات الفصل الأول </th>
                                <th style="text-align: center;width:25%">تقديرات الفصل الثاني  </th>
                                <th   style="text-align: center;width:25%">التقدير النهائي  </th>

                            </tr>


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
                                        <td style="text-align: center;">{{ $lesson_name  }} </td>

                                        <td class="estimation">
                                            @if(json_decode($student_marks->estimation1) !== null  && $student_rigistration_term == 1)
                                                @foreach(json_decode($student_marks->estimation1) as $key1 => $item1 )
                                                    @if($key1 == $lesson->id )
                                                    {{  $item1 }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="estimation">
                                            @if(json_decode($student_marks->estimation2) !== null && $current_term == 2)
                                                @foreach(json_decode($student_marks->estimation2) as $key2 => $item2 )
                                                    @if($key2 == $lesson->id )
                                                    {{  $item2 }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="estimation">
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
                                                <div class="tab1cards" style="direction:rtl">
                                                    <h5 style="writing-mode: vertical-rl;margin-left: 160px;transform: rotate(-180deg);padding-top:5px;margin-right:20px">{{  $base_subject->name  }} </h5>
                                                    <div class = "vertical" style="margin-left: 62px;margin-top:-6px"></div>

                                                </div>
                                                <div style="margin-right: 100px;margin-top:-76px">
                                                    <h6 style="font-size:15px;margin-right:-8px">المهارات الشفوية </h6>
                                                    <hr style="margin-right: -18px">
                                                    <h6 style="font-size:15px;margin-right:-8px"> المهارات الكتابية</h6>
                                                </div>
                                            </td>
                                        @foreach ($addable_lessons as $lesson2)
                                            @if($base_subject_id == $lesson2->base_subject_id)
                                                <tr>

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


                                                </tr>
                                            @endif
                                        @endforeach
            {{--
                                                <tr style="color:#f01d64">
                                                    <td >
                                                        @if(json_decode($student_marks->estimation1) !== null )
                                                            @foreach(json_decode($student_marks->estimation1) as $key1 => $item1 )
                                                                @if($key1 == $lesson->id )
                                                                {{  $item1 }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(json_decode($student_marks->estimation2) !== null )
                                                            @foreach(json_decode($student_marks->estimation2) as $key2 => $item2 )
                                                                @if($key2 == $lesson->id )
                                                                {{  $item2 }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(json_decode($student_marks->estimation) !== null )
                                                            @foreach(json_decode($student_marks->estimation) as $key_all => $item_all)
                                                                @if($key_all == $lesson->id )
                                                                {{  $item_all }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr> --}}


                                            </tr>



                                    @endif
                                    @endif
                                    @endif
                    @endforeach
                @endforeach

                    <tr>
                    <td style="text-align: center;font-size:18px;font-weight:600" >ملاحظات المدير وتوقيعه </td>
                    <td colspan="3" class="gray-background">

                            {{ isset($report_card) ?  $report_card->manager_notes   : ''}}

                    </td>
                    </tr>

                    <tr style="height: 43px">
                    <td style="text-align: center;font-size:18px;font-weight:600" > ملاحظات ولي أمر  التلميذ</td>
                    <td colspan="3" class="gray-background"> </td>
                    </tr>




                        </tbody>
                    </table>
            </div>
            </td>
            <!-- end first table -->
            <!-- start second table-->
            <td style="border: 0px">
            <div  style=" height: 100%;margin-top:-10px">
                <table style="" class="h-100 w-100">
                <thead >
                    <tr>

                        <th  rowspan="1" colspan="5"  style="text-align: center;" >جدول دوام التلميذ </th>
                        <th width="30%"> التوجيهات التربوية للمعلم </th>
                    </tr>



                </thead>
                <tbody style="text-align: center;">
                    <tr>

                        <td colspan="1" rowspan="2" style="text-align: center;font-weight: bold;">الدوام المدرسي </td>
                        <td colspan="1" rowspan="2" style="text-align: center;"> الدوام الفعلي </td>
                        <td colspan="1" rowspan="2"  style="text-align: center;"> دوام التلميذ </td>
                        <td  rowspan="1"  colspan="2"  style="text-align: center; font-weight: bold;"> الغياب </td>
                        <td rowspan="1" style="text-align: center;"> الفصل الأول </td>
                    </tr>
                    <tr>

                        <td colspan="1" style="text-align: center;">المبرر</td>
                        <td colspan="1" style="text-align: center;">غير المبرر</td>
                        <td colspan="1" rowspan="2" style="text-align: center;">

                                <!--<textarea name="teacher_notes1" value="" class="form-control"-->
                                <!--            style="direction:rtl; text-align: right;font-size:12px" cols="3" rows="2">-->
                                <!--</textarea>-->
                                <p style="height: 70px;">
                                     @php
                                       if ($student_rigistration_term == 1 ){
                                            $teacher_notes1 = isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term1'}  : '';
                                        }else{
                                            $teacher_notes1 = '';
                                        }
                                     @endphp
                                    {{ $teacher_notes1 }}
                                </p>
                        </td>

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

                            $attendance_percent = $total_student_attendance / ($total_actual_attendance != 0 ? $total_actual_attendance : 1 )  * 100 ;
                            $new_teacher_name = isset($report_card_details->teacher_name) ?  json_decode($report_card_details->teacher_name) : 0;
                    @endphp

                    <tr>

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


                    </tr>

                    <tr>

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


                        <td style="text-align: center;"> الفصل الثاني </td>

                    </tr>

                    <tr>

                    <td style="text-align: center;"> المجموع </td>
                    <td style="text-align: center;">{{ arabic_w2e($total_actual_attendance) }}</td>
                    <td style="text-align: center;"> {{ arabic_w2e($total_student_attendance) }}</td>
                    <td style="text-align: center;">{{ arabic_w2e($total_justified_absence) }}</td>
                    <td style="text-align: center;">{{ arabic_w2e($total_unjustified_absence) }}</td>
                     <td rowspan="1" style="text-align: center;">

                            <!--<textarea name="teacher_notes2" value="" class="form-control"-->
                            <!--            style="direction:rtl; text-align: right;font-size:12px" cols="3" rows="2">-->
                            <!--</textarea>-->
                            <p style="height: 70px;">
                                {{isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term2'} : '' }}
                            </p>
                         </td>

                </tr>

                <tr>
                    <td  colspan="2" class="text-center"> النسبة المئوية للدوام </td>
                    <td colspan="3" class="text-center"> {{  arabic_w2e(round($attendance_percent,1)). '%' }} </td>
                    <td>
                     <div class="">
                        <h6 style="text-align:right">
                           <p style="font-weight:bold"> اسم المعلم وتوقيعه:</p>
                            <!--@if(isset($teacher_name))-->
                            <!--    {{ $teacher_name }}-->
                            <!--@else-->
                            <!--    {{isset($report_card) ?   $report_card->teacher : '' }}-->
                            <!--@endif-->


                                {{ $report_card->teacher_name }}

                         </h6> &nbsp;&nbsp;

                    </div>
                    </td>

                </tr>

                <tr >
                <td colspan="6" class="gray-background" style="text-align: center;font-size:18px;font-weight:600"> النتيجة النهائية </td>
                </tr>


            <tr >
                <td colspan="6" style="text-align: right;">
                <div class="" style="background-color: transparent;color: #2E3C40;">
                {{-- <input type="radio" name="final_result" class="first-one"
                    value="pass"> --}}
                نجاح إلى الصف:
                 <span class="mr-1">
                    @if($report_card->final_result == 2 && $current_term != 1)
                        {{ $class->next_class_success->name }}
                    @endif
                </span>

                </div>
                </td>
                </tr>

                <tr >
                <td colspan="6" style="text-align: right;">
                    <div class="" style="background-color: transparent;color: #2E3C40;">
                     {{-- <input type="radio" name="final_result" class="second-one"
                    value="pass"> --}}
                   رسوب في الصف:
                    <span class="mr-1">
                        @if($report_card->final_result == 3 && $current_term != 1)
                            {{ $class->name }}
                        @endif
                    </span>

                    </div>
                </td>
                </tr>

                <tr >
                    <td colspan="6" style="text-align: right;">
                    <div class="row " style="background-color: transparent;color: #2E3C40;">
                       <div class="col-6">
                             {{-- <input type="radio" name="final_result" class="third-one"
                    value="pass"> --}}
                          نقل إلى الصف:
                       </div>

                        <small class="col-6" style="margin-left: -51px;"> لأنه معيد </small>
                    </div>

                    </td>
                    </tr>
                    <tr >
                    <td colspan="6" style="text-align: right;">
                        <div class="row" style="background-color: transparent;color: #2E3C40;">

                        <div class="col-6">
                             {{-- <input type="radio" name="final_result" class="last-one"
                            value="pass"> --}}
                                نقل إلى الصف:
                        </div>
                        <small class="col-6" style="margin-left: -88px;" > لاستنفاذ سنوات
                            الرسوب
                        </small>
                        </div>

                    </td>
                    </tr>
                    <tr height="153px">
                         <td colspan="6" rowspan="2">
                            <div class="row" >
                               <div class="col-10 d-flex justify-content-around">
                                     <div class="col-3">
                                     اسم المدير:
                                 </div>
                                 <div class="col-4">
                                    {{ isset($report_card_details) ? $report_card_details->manager_name : ''}}
                                 </div>
                                 <div class="col-3">
                                     توقيعه:
                                 </div>
                               </div>
                            </div>
                            <div class="d-flex justify-content-end" >
                                <div class="col-3"> الختم</div>
                            </div>
                            <div class="d-flex justify-content-center" >
                                <div> التاريخ</div>
                                <div class="col-1"></div>
                                 @php
                                    if ($current_term == 1 ){
                                        $report_card_date =  isset($report_card_details) ? json_decode($report_card_details->report_card_date)->{'term1'} : '' ;
                                    }else{
                                        $report_card_date =  isset($report_card_details) ? json_decode($report_card_details->report_card_date)->{'term2'} : '' ;
                                    }
                                    $formatted_date = empty($report_card_date) ? '' : arabic_w2e(Carbon\Carbon::parse($report_card_date)->format('Y/m/d'))  ;
                                @endphp

                                <div>  {{ $formatted_date }}  </div>
                            </div>

                        </td>
                    </tr>
                    <tr></tr>
                </tbody>
                </table>
            </div>
            </td>
            <!-- end second table -->
        </tr>
    </table>

    </div>
    <!-- end new table -->







        <div class="Row" style="margin: 0 auto ; text-align: center;">
            <!--<input class="btn btn-primary " type="button" onclick="fnExcelReport();" value="تنزيل ملف اكسل"-->
            <!--style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;-->
            <!--background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));">-->
            &nbsp;&nbsp;
            <input class="btn btn-primary pdf_download" type="button"  value="pdf تنزيل ملف  " style="margin:50px auto; width: 200px; height:40px;
            background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));">
            &nbsp;&nbsp;

            <!--<button  class="btn btn-primary " type="submit"-->
            <!--style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;-->
            <!--background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> حفظ-->
            <!--</button>-->
        </div>







    </page>





    <script>
      $(document).on('click', '.pdf_download', function () {
        $('form.limiter').addClass('printing1') ;
        $('.pdf_download').hide() ;
        $('.hide').hide() ;
        window.print();
        setInterval(function() {
            $('form.limiter').removeClass('printing1') ;
            $('.pdf_download').show() ;

        }, 5000);
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



{{-- filesaver.js is using  for saveing text and canvas file go to gethub to see more --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.core.min.js" integrity="sha512-UhlYw//T419BPq/emC5xSZzkjjreRfN3426517rfsg/XIEC02ggQBb680V0VvP+zaDZ78zqse3rqnnI5EJ6rxA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blob-polyfill/7.0.20220408/Blob.min.js" integrity="sha512-uPm9nh4/QF6a7Mz4Srk0lXfN7T+PhKls/NhWUKpXUbu3xeG4bXhtbw2NCye0BRXopnD0x+SBDMOWXOlHAwqgLw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- <script  src="{{ asset('assets/file_saverJs/blob.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.min.js" integrity="sha512-XmZS54be9JGMZjf+zk61JZaLZyjTRgs41JLSmx5QlIP5F+sSGIyzD2eJyxD4K6kGGr7AsVhaitzZ2WTfzpsQzg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script >
// document.getElementById("demo")
//   TableExport(document.getElementById("base-table"), {
//   headers: true,                      // (Boolean), display table headers (th or td elements) in the <thead>, (default: true)
//   footers: true,                      // (Boolean), display table footers (th or td elements) in the <tfoot>, (default: false)
//   formats: ["xlsx", "csv", "txt"],    // (String[]), filetype(s) for the export, (default: ['xlsx', 'csv', 'txt'])
//   filename: "id",                     // (id, String), filename for the downloaded file, (default: 'id')
//   bootstrap: false,                   // (Boolean), style buttons using bootstrap, (default: true)
//   exportButtons: true,                // (Boolean), automatically generate the built-in export buttons for each of the specified formats (default: true)
//   position: "bottom",                 // (top, bottom), position of the caption element relative to table, (default: 'bottom')
//   ignoreRows: null,                   // (Number, Number[]), row indices to exclude from the exported file(s) (default: null)
//   ignoreCols: null,                   // (Number, Number[]), column indices to exclude from the exported file(s) (default: null)
//   trimWhitespace: true,               // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s) (default: false)
//   RTL: false,                         // (Boolean), set direction of the worksheet to right-to-left (default: false)
//   sheetname: "id"                     // (id, String), sheet name for the exported spreadsheet, (default: 'id')
// });


function fnExcelReport() {
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('base-table'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++)
    {
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

    return (sa);

}


</script>

<script>
    $.each($('.estimation'), function (key, value) {
            let text = $( this).text() ;
            // let text = $(this).text() ;
            if ( text.includes("ضعيف") ){
                $(this).css('color','red') ;
            }

    }) ;
</script>


</body>
</html>




