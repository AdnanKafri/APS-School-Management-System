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

    /*checkbox */
    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:600&display=swap');


 .tab1cards {
   display: flex;
   flex-direction: row;
   justify-content: center;

 }


 table {
   direction: rtl;
     border: 2px solid black;

 }
 th {
     border: 2px solid black;
     padding: 3px;
     background-color:white;
     color: #000;
     font-size: 12px;
 }
 td {
     border: 1px solid black;
     padding: 4px;
     color: #000 !important ;
     font-size: 12px;
 }
 /*td:not(.special-subject){*/
 /*    font-size: 15px;*/
 /*}*/
 td.special-subject{
     font-size: 10px;
     padding-left: 0;
     padding-right: 0;
 }
 td p{
  color:  #000 ;
  font-size: 9px ;
 }
 .upper-table td {
     border: 0px ;
     padding: 5px;
 }

 .vertical {
            border-left: 1px solid rgb(110, 110, 110);
            margin-top:-4px;
            margin-bottom:-6px;
            height: 114%;
            padding-right: 0px;
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
    font-size: 14px;
 }
 .main-p {
    font-family: revert;
    font-weight: 600;
    color: #000;
 }
 p {
    margin-bottom: 0 !important;
 }

  @media print {

html, body {

  margin: 5px !important;
  padding: 0 !important;
  overflow: hidden;

}
table{

}
table.fixed5{

}
.subject{
    width: 11.875% !important;
}

}
.printing1 {
    position: absolute;
    top:-200px;
}
.printing2 {
    transform: scale(0.95145833333, 0.95111111111);
}

.space-separator{
    border: 0px !important ;
}
.gray-background{
    background: #aeafb0ad ;
}
.herozintal{
    width: 115% !important;
    opacity: 1 !important;
    margin-top: 0.7 rem !important;
}
.row.no-gutter {
  margin-left: 0 !important;
  margin-right: 0 !important;
}
.no-gutter {
  margin-left: 0 !important;
  margin-right: 0 !important;
}
 </style>


</head>
<body style="  background-image: url('../simages/IMG_3225.jpg');background-size: cover;
">



    <form class="limiter"  action="{{ route('save_report_card') }}" method="post">
    @csrf
     <input type="hidden" name="student_id" class="form-control"
                                            value="{{ $student->id }}" required>
      <input type="hidden" name="stage_id" class="form-control"
                                            value="{{ $stage_id }}" required>

	<div  style="width:1300px;margin:auto">

     <table id="1" class="w-100"  style="border-color: white;text-align:center;margin:auto"   >

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
                        <td colspan="3">
                            <div class="row">
                                <div class="col-7">
                                    <h6 class="text-center"     >
                                        الجمهورية العربية السورية  <br>
                                        وزارة التربية
                                    </h6>
                                </div>
                                <div class="col-5"></div>
                            </div>
                              {{-- <h5 class="text-center mb-2"> <span> وزارة التربية </span></h5> --}}
                        </td>

                        <td   colspan="3" >
                            <div class="row">
                                <div class="col-10">
                                    <h5 style="font-weight: 600"> مرحلة التعليم الأساسي  الحلقة الأولى الخامس والسادس  </h5>
                                </div>
                                <div class="col-2"></div>
                            </div>
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
                            <h6  class="text-right" style="margin-right: 0"  > {{$school_data->name}}    </h6>

                        </td>

                        <td  colspan="2">
                            <p class="paragraph-os"> الرقم المتسلسل ({{  arabic_w2e($student->serial_number) }})  </p>
                        </td>
                        <td></td>
                        <td>
                            <p class="paragraph-os text-center">الصف: <span> {{ $class->name}}</span></p>
                        </td>
                        <td>
                            <p class="paragraph-os text-left">الشعبة: <span> {{ $room_name }}</span></p>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="text-left">
                      <td></td>
                        <td colspan="">
                            <p class="paragraph-os1 text-center" style="padding-left:25px" > اسم التلميذ/ة: <span> {{ $student->first_name.' '.$student->last_name }}</span>       </p>
                        </td>

                        <td  colspan="">
                            <p class="paragraph-os1"> الأب: <span>{{ $student->details->father_name }}</span> </p>
                        </td>

                        <td>
                            <p class="paragraph-os1"> الأم: <span> {{ $student->details->mother_name }}</span> </p>
                        </td>
                        <td>
                            <p class="paragraph-os1 text-center">تاريخ الميلاد: <span dir="rtl"> {{ arabic_w2e(Carbon\Carbon::parse($student->date_birth)->format('d-m-Y')) }}</span></p>
                        </td>

                        <td>
                            <p class="paragraph-os1 text-center" >رقمه في السجل العام: <span style="color:#000;">  {{  arabic_w2e($student->public_record_number) }}   </span></p>
                        </td>

                        <td colspan="3">
                            <p class="paragraph-os1">   العام الدراسي: <span>  {{ arabic_w2e($year_name )}}</span></p>
                        </td>



                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
         <tr style="border-color: white;"  >
            <!-- start table one -->
            <td style="border-color: white;"  >
                <table class="fixed5" style="margin-top: -13px;">
                  <thead>
                      <tr>
                        <th  rowspan="6" class="subject" style="text-align: center;width:10.875%;font-weight:800;font-size:22px" >  المواد الدراسية </th>
                        <th  rowspan="6"    style="text-align: center;width:3.125%;font-weight:500">
                             <span style="writing-mode: vertical-rl;white-space: pre;transform: rotate(-180deg);font-size:16px">الدرجة العظمى</span>
                             </th>
                        <th colspan="4" rowspan="1"  style="text-align: center;width:165px;font-weight:400" >الفصل الدراسي الأول </th>
                        <th colspan="4" rowspan="1" style="text-align: center;border-left: 3px solid #000;width:165px;font-weight:400">الفصل الدراسي الثاني </th>
                        <th  rowspan="6" class="space-separator" style="border-top:2px solid #fff !important; width:4.5%;background:#fff"><p style="width: 45px"></p></th>
                        <th colspan="1" rowspan="5" style=" border-right: 3px solid #000;width:4.5%;">
                            <div style="writing-mode: vertical-rl;white-space: pre;transform: rotate(-180deg);font-size:16px;width:45px;">  مجموع درجات الفصلين  </div>

                        </th>
                        <th colspan="2"  rowspan="4" style="text-align: center;font-weight:800;font-size:16px;width:17%;">
                            <div style="width:199px;margin:auto">
                                 الدرجة النهائية
                               <br> ((محصلة الفصلين))
                           </div >
                        </th>

                        <th rowspan="2" style="width: 6.5%">
                            <!--4px-->
                            <div style="width:65px;margin:auto">
                                الدوام <br>
                                المدرسي
                            </div>
                        </th>
                        <th rowspan="2" style="width: 3.75%">
                            <!--2px-->
                            <div style="width:37.5px;font-size: 10px;margin:auto">
                                الدوام <br>
                                الفعلي
                            </div>
                        </th>
                        <th rowspan="2" style="width: 3.75%">
                            <div  style="width:37.5px;font-size: 10px;margin:auto">
                                دوام <br>
                                التلميذ
                            </div>
                        </th>
                        <th colspan="2" rowspan="1" style="width: 7.25%">
                            <!--5px-->
                              <div  style="width:72.5px;margin:auto">
                            الغياب
                            </div>
                        </th>
                        <th rowspan="2" style="text-align: center;width: 6%">
                            <div style="width: 60px;font-size: 10px;margin:auto">
                                النسبة المئوية <br>
                                للدوام
                            </div>
                        </th>



                      </tr>



                      <tr>
                        <th  colspan="1" rowspan="3" style="text-align: center;font-weight:600">
                             <span style="writing-mode: vertical-rl;white-space: pre;transform: rotate(-180deg); font-size:14px"> درجة الأعمال </span>
                        </th>
                        <th colspan="1" rowspan="3"  style="text-align: center;font-weight:600">
                            <span style="writing-mode: vertical-rl;white-space: pre;transform: rotate(-180deg);font-size:14px">  درجة الامتحان </span>
                        </th>
                        <th  colspan="2" rowspan="3"  style="text-align: center;font-weight:800;font-size:18px">
                            <div style="width: 130px;margin:auto">
                                 مجموع الدرجات
                                <br>  للفصل الدراسي الأول
                            </div >
                        </th>
                        <th  colspan="1" rowspan="3" style="text-align: center;font-weight:600">
                            <span style="writing-mode: vertical-rl;white-space: pre;transform: rotate(-180deg);font-size:14px"> درجة الأعمال </span>
                       </th>
                       <th colspan="1" rowspan="3"  style="text-align: center;font-weight:600">
                           <span style="writing-mode: vertical-rl;white-space: pre;transform: rotate(-180deg);font-size:14px">  درجة الامتحان </span>
                       </th>
                       <th  colspan="2" rowspan="3"  style="text-align: center;font-weight:800;font-size:18px;border-left:3px solid #000">
                        <div style="width: 130px;margin:auto">
                             مجموع الدرجات
                            <br>  للفصل الدراسي الثاني
                        </div >
                    </th>                        {{-- <th  style=" border: 2px solid white;width:5%;background:#fff"></th> --}}
                        {{-- <th rowspan="2" style="text-align: center; border-right: 2px solid #000;">رقم </th>
                        <th rowspan="2" style="text-align: center;"> كتابة </th> --}}

                    <th><div style="width: 36px;font-size: 10px;"> مبرر</div></th>
                    <th><div style="width: 36px;font-size: 10px;">غير مبرر</div> </th>

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

                      $actual_attendance2 =    isset($report_card_details->actual_attendance) ?  json_decode($report_card_details->actual_attendance)->{'term2'} : 0;
                      $student_attendance2 =   isset($report_card) ?  json_decode($report_card->student_attendance)->{'term2'} : 0 ;
                      $justified_absence2 =    isset($report_card) ?  json_decode($report_card->justified_absence)->{'term2'} : 0;
                      $unjustified_absence2 =  isset($report_card) ? json_decode($report_card->unjustified_absence)->{'term2'} : 0;

                      $total_student_attendance =  $student_attendance1 +  $student_attendance2 ;
                      $total_actual_attendance =  $actual_attendance1 +  $actual_attendance2 ;
                      $total_justified_absence =  $justified_absence1 +  $justified_absence2 ;
                      $total_unjustified_absence =  $unjustified_absence1 +  $unjustified_absence2 ;

                      $attendance_percent = $total_student_attendance / ($total_actual_attendance != 0 ? $total_actual_attendance : 1 )  * 100 ;
                      $attendance_percent_term1 = $student_attendance1 / ($actual_attendance1 != 0 ? $actual_attendance1 : 1 )  * 100 ;
                      $attendance_percent_term2 = $student_attendance2 / ($actual_attendance2 != 0 ? $actual_attendance2 : 1 )  * 100 ;

                  @endphp

                      <tr>
                        <td style="white-space: pre">الفصل الأول</td>
                        <td>{{  $student_rigistration_term == 1 ?  arabic_w2e($actual_attendance1) : ''}}</td>
                        <td>{{  $student_rigistration_term == 1 ?  arabic_w2e($student_attendance1) : ''}}</td>
                        <td>{{  $student_rigistration_term == 1 ? arabic_w2e( $justified_absence1) : ''}}</td>
                        <td> {{  $student_rigistration_term == 1 ?  arabic_w2e( $unjustified_absence1) : ''}}</td>
                        <td>{{  $student_rigistration_term == 1 ? arabic_w2e( ceil($attendance_percent_term1) ).'%' : ''}}</td>
                      </tr>
                      <tr>
                        <td style="white-space: pre">الفصل الثاني</td>
                        <td>{{  isset($report_card_details->actual_attendance) ?  arabic_w2e( json_decode($report_card_details->actual_attendance)->{'term2'}) : 0}}</td>
                        <td>{{  isset($report_card) ?  arabic_w2e( json_decode($report_card->student_attendance)->{'term2'}) : '٠'}}</td>
                        <td>{{  isset($report_card) ?  arabic_w2e( json_decode($report_card->justified_absence)->{'term2'}): '٠'}}</td>
                        <td> {{  isset($report_card) ?  arabic_w2e( json_decode($report_card->unjustified_absence)->{'term2'}) : '٠'}}</td>
                        <td>{{  arabic_w2e( ceil($attendance_percent_term2)).'%' }}</td>
                      </tr>

                      <tr>
                        <th style="text-align:center;width:3.125%"> ٦٠%</th>
                        <th style="text-align: center;width:3.125%"> ٤٠%</th>
                        <th style="text-align: center;width:3.125%"> رقما </th>
                        <th style="text-align: center;width:7.125%"> كتابة </th>
                        <th style="text-align:center;width:3.125%"> ٦٠%</th>
                        <th style="text-align: center;width:3.125%"> ٤٠%</th>
                        <th style="text-align: center;width:3.125%"> رقما </th>
                        <th  style="text-align: center; border-left: 3px solid #000;width:7.125%"> كتابة </th>

                        <th style="text-align: center;width:3.125%"> رقما </th>
                        <th  style="text-align: center;width:7.125% "> كتابة </th>
                        {{-- <th  style=" border: 2px solid white;width:5%;background:#fff"></th> --}}
                        <td>المجموع </td>
                        <td>{{ arabic_w2e( $total_actual_attendance ) }}</td>
                        <td> {{ arabic_w2e( $total_student_attendance ) }}</td>
                        <td>{{ arabic_w2e( $total_justified_absence) }}</td>
                        <td>{{ arabic_w2e( $total_unjustified_absence) }}</td>
                        {{-- <td>{{  ceil(($attendance_percent_term1 + $attendance_percent_term2) /2).'%' }}</td> --}}
                        <td>{{   arabic_w2e( ceil($attendance_percent)).'%' }}</td>

                      </tr>


                  </thead>
                  <tbody>
                    @foreach ($mark_base_subjects as $key77 => $base_subject)
                    @php
                        $lessons = $base_subject->lessons_mark ;
                        $lesson_count =  count($lessons);
                        $i = 0;
                        $addable_lesson_id = 0;
                        // $numItems = count($arr);
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
                            $before_first_total_subjects = [] ;
                            $value_loader = 0;
                        @endphp
                        @if (++$i === $lesson_count)
                            @if ($lesson->religion == null || $lesson->religion  == $student->religion)
                            @if ($lesson->is_addable == 1 &&  $lesson->first_total)
                            @php
                            @endphp
                                <form>
                                <tr>

                                    <td class="special-subject">    {{ $lesson_name }} </td>
                                    <td class="max_mark"> {{  arabic_w2e( $lesson->max_mark )}} </td>
                                    @if($lesson->is_project == 1)
                                    <td colspan="2">
                                        @if(json_decode($student_marks->worke_degree) !== null && $student_rigistration_term == 1)
                                        @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                            @if($key1 == $lesson->id )

                                            @php
                                               $item1_term1_result  = $item1->term1_result == 'null' ? 0 : $item1->term1_result ;

                                                $term1_result +=  $item1_term1_result ;

                                            @endphp
                                            @endif
                                        @endforeach
                                        @endif
                                        @if(json_decode($student_marks->mark) !== null && $student_rigistration_term == 1)
                                        @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                            @if($key1 == $lesson->id )

                                              @php
                                                  $item1_exam = $item1->exam  == 'null' ? 0 : $item1->exam  ;
                                                  $term1_result += $item1_exam ;

                                              @endphp
                                            @endif
                                        @endforeach
                                        @endif


                                   </td>
                                    @else
                                    <td>
                                      @if(json_decode($student_marks->worke_degree) !== null && $student_rigistration_term == 1)
                                      @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                          @if($key1 == $lesson->id )
                                            {{ $item1->term1_result  == 'null' ? '' :  arabic_w2e($item1->term1_result) }}
                                            @php
                                             $item1_term1_result = $item1->term1_result  == 'null' ? 0 : $item1->term1_result  ;
                                             $term1_result +=  $item1_term1_result ;

                                            @endphp
                                          @endif
                                      @endforeach
                                      @endif
                                    </td>
                                    <td>
                                      @if(json_decode($student_marks->mark) !== null && $student_rigistration_term == 1)
                                      @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                          @if($key1 == $lesson->id )
                                           {{ $item1->exam  == 'null' ? '' :  arabic_w2e($item1->exam) }}
                                            @php
                                                $item1_exam = $item1->exam  == 'null' ? 0 : $item1->exam  ;
                                                $term1_result += $item1_exam ;

                                            @endphp
                                          @endif
                                      @endforeach
                                      @endif
                                    </td>
                                    @endif
                                    <td class="result1" data-term1_result="{{  $student_rigistration_term == 1 ? $term1_result : ''}}"
                                    @if( $term1_result  < $lesson->min_mark)
                                        style="color:red !important;"
                                    @endif
                                    > {{ arabic_w2e( $student_rigistration_term == 1 ? $term1_result : '')  }} </td>
                                    <td class="x" data-id="{{  $student_rigistration_term == 1 ? $term1_result : '' }}" data-min_mark="{{  $lesson->min_mark }}"> </td>
                                    {{-- end term1 result  --}}


                                    {{-- start term2 result  --}}
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
                                        @if(json_decode($student_marks->mark2) !== null && $current_term == 2)
                                        @foreach(json_decode($student_marks->mark2) as $key1 => $item1 )
                                            @if($key1 == $lesson->id )

                                            @php
                                                $term2_result +=  $item1->exam ;
                                            @endphp
                                            @endif
                                        @endforeach
                                        @endif
                                    </td>
                                    @else
                                    <td>
                                      @if(json_decode($student_marks->worke_degree) !== null && $current_term == 2)
                                      @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                          @if($key1 == $lesson->id )
                                                {{  arabic_w2e($item1->term2_result == 'null' ? '' : $item1->term2_result)     }}
                                                @php
                                                    $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                                    $term2_result +=   $x ;
                                                @endphp
                                          @endif
                                      @endforeach
                                      @endif
                                    </td>

                                    <td>
                                    @if(json_decode($student_marks->mark2) !== null && $current_term == 2)
                                    @foreach(json_decode($student_marks->mark2) as $key1 => $item1 )
                                        @if($key1 == $lesson->id )
                                        {{  arabic_w2e(  $item1->exam  )  }}
                                          @php
                                              $term2_result +=  $item1->exam ;
                                          @endphp
                                        @endif
                                    @endforeach
                                    @endif
                                    </td>
                                    @endif
                                    <td class="result2" data-term2_result="{{$current_term == 2 ? $term2_result : ''  }}"
                                    @if( $term2_result  < $lesson->min_mark)
                                        style="color:red !important;"
                                    @endif
                                    > {{ arabic_w2e( $current_term == 2 ? $term2_result : '' ) }} </td>
                                  <td class="x" data-id="{{ $current_term == 2 ? $term2_result : '' }}" data-min_mark="{{  $lesson->min_mark }}" style=" border-left: 3px solid #000;"> </td>

                                  <th class="space-separator" style="background:#fff"></th>
                                  @php
                                    $theToltalResult = $term1_result + $term2_result ;
                                    $dividingRatio =  $student_rigistration_term == 1 ? 2 : 1 ;
                                    $theFinalResult = $theToltalResult / $dividingRatio ;
                                  @endphp
                                  <td class="total_result" data-total_result="{{$current_term == 2 ? $theToltalResult  : '' }}" style=" border-right: 3px solid #000;" > {{   arabic_w2e( $current_term == 2 ? $theToltalResult  : ''  ) }}  </td>
                                 <td class="final_result"  data-final_result="{{$current_term == 2 ?  ceil($theFinalResult) : '' }}"
                                @if( ceil($theFinalResult)  < $lesson->min_mark)
                                 style="color:red !important;"
                                @endif
                                > {{ $current_term == 2 ?   arabic_w2e( ceil($theFinalResult)) :''}} </td>
                                <td class="x" data-id="{{$current_term == 2 ?    ceil($theFinalResult)  : ''}}"
                                                  data-min_mark="{{  $lesson->min_mark }}"
                                 > </td>
                                        {{-- build the notes in report card --}}
                                    @if($key77 + 1 == 1)
                                        <td colspan="6" rowspan="2" style="border-bottom: 1px solid #fff;font-weight:600">
                                         <p class="main-p"  style="margin-bottom: -35px;"> التوجيهات التربوية للمعلم</p>
                                        </td>
                                    @endif
                                    @if($key77 + 1 == 3)
                                        <td colspan="6" rowspan="3">
                                            @php
                                             $teacher_notes1 = isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term1'} : ''
                                            @endphp
                                          {{ $student_rigistration_term == 1 ? $teacher_notes1 : '' }}
                                        </td>
                                    @endif
                                    @if($key77 + 1 == 6)
                                        <td colspan="6">الفصل الثاني  </td>
                                    @endif
                                    @if($key77 + 1 == 7)
                                        <td colspan="6" rowspan="3">
                                          {{ isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term2'} : ''  }}
                                        </td>
                                    @endif
                                    @if($key77 + 1 == 10)
                                        <td colspan="6" rowspan="2" class="report_details">  اسم المعلم وتوقيعه
                                             {{ $report_card->teacher_name }} </td>
                                    @endif




                                </tr>
                                </form>
                            @elseif ($lesson->is_addable == 0 )
                                @php
                                $addable_lesson_id++ ;

                                $base_subject_id = $base_subject->id ;
                                @endphp
                                @if($addable_lesson_id < 2)
                                <form>
                                    <tr>
                                        <td rowspan="3">
                                           <div class="row no-gutters" style="width:120px; margin-left: 0 !important;margin-right: 0 !important;">
                                              <div class="col-3 d-flex justify-content-between p-0;width:20% !important">
                                                <div class="col-6" style="margin: auto">
                                                  <div style="writing-mode: vertical-lr;font-size:11px;transform: rotate(-180deg);font-weight:500">{{  $base_subject->name  }} </div>
                                                </div>
                                                <div class = "vertical col-6" ></div>
                                              </div>

                                              <div class="col-9" style="margin: auto;margin-left: -15px;">
                                                  <h6 style="font-size:11px;margin:2px">المهارات الشفوية </h6>
                                                  <hr class="my-2 herozintal" >
                                                  <h6 style="font-size:11px;margin:2px"> المهارات الكتابية</h6>
                                              </div>
                                            </div>
                                        </td>
                                        @php
                                            $fff = 0 ;
                                        @endphp
                                    @foreach ($addable_lessons as $key177 => $lesson2)
                                        @if($base_subject_id == $lesson2->base_subject_id)
                                        @php
                                            $fff++ ;
                                            $term1_result = 0 ;
                                            $term2_result = 0 ;
                                        @endphp
                                        <form>
                                            <tr
                                            @if($lesson2->certificate_order == 3)
                                                class="oral"
                                            @endif>

                                                <td class="max_mark"> {{ arabic_w2e( $lesson2->max_mark ) }} </td>
                                                <td>
                                                    @if(json_decode($student_marks->worke_degree) !== null && $student_rigistration_term == 1)
                                                    @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                        @if($key1 == $lesson2->id )
                                                        {{  arabic_w2e( $item1->term1_result ) }}
                                                        @php
                                                            $term1_result +=  $item1->term1_result ;
                                                        @endphp
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                @if(json_decode($student_marks->mark) !== null && $student_rigistration_term == 1)
                                                @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                    @if($key1 == $lesson2->id )
                                                        {{  arabic_w2e( $item1->exam  ) }}
                                                        @php
                                                            $term1_result +=  $item1->exam ;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @endif
                                                </td>
                                                 <td class="result1" data-term1_result="{{  $student_rigistration_term == 1 ? $term1_result : '' }}"
                                                @if( $term1_result  < $lesson->min_mark)
                                                style="color:red !important;"
                                                 @endif
                                                > {{ arabic_w2e(  $student_rigistration_term == 1 ? $term1_result : '' )  }} </td>
                                                <td class="x" data-id="{{  $student_rigistration_term == 1 ? $term1_result : '' }}" data-min_mark="{{  $lesson->min_mark }}"> </td>
                                                {{-- end term1 result  --}}


                                                {{-- start term2 result  --}}
                                                <td>
                                                @if(json_decode($student_marks->worke_degree) !== null && $current_term == 2)
                                                @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                                    @if($key1 == $lesson2->id )
                                                        {{     arabic_w2e( $item1->term2_result == 'null' ? '' : $item1->term2_result ) }}
                                                        @php
                                                            $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                                            $term2_result +=   $x ;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @endif
                                            </td>

                                            <td>
                                                @if(json_decode($student_marks->mark2) !== null && $current_term == 2)
                                                @foreach(json_decode($student_marks->mark2) as $key1 => $item1 )
                                                    @if($key1 == $lesson2->id )
                                                    {{  arabic_w2e(  $item1->exam ) }}
                                                    @php
                                                        $term2_result +=  $item1->exam ;
                                                    @endphp
                                                    @endif
                                                @endforeach
                                                @endif
                                            </td>
                                           <td class="result2" data-term2_result="{{$current_term == 2 ? $term2_result : ''  }}"
                                            @if( $term2_result  < $lesson->min_mark)
                                            style="color:red !important;"
                                            @endif
                                            > {{ arabic_w2e( $current_term == 2 ? $term2_result : '' ) }} </td>
                                            <td class="x" data-id="{{ $current_term == 2 ? $term2_result : '' }}" data-min_mark="{{  $lesson->min_mark }}" style=" border-left: 3px solid #000;"> </td>

                                            <th class="space-separator" style="background:#fff"></th>
                                              @php
                                                $theToltalResult = $term1_result + $term2_result ;
                                                $dividingRatio =  $student_rigistration_term == 1 ? 2 : 1 ;
                                                $theFinalResult = $theToltalResult / $dividingRatio ;
                                              @endphp
                                            <td class="total_result" data-total_result="{{$current_term == 2 ? $theToltalResult : ''}}" style=" border-right: 3px solid #000;"> {{$current_term == 2 ? arabic_w2e( $theToltalResult ) : '' }}  </td>
                                            <td class="final_result"  data-final_result="{{$current_term == 2 ?  ceil($theFinalResult) : ''}}"
                                            @if( ceil($theFinalResult)  < $lesson->min_mark)
                                            style="color:red !important;"
                                            @endif
                                            > {{ $current_term == 2 ?   arabic_w2e( ceil($theFinalResult) ) :''}} </td>
                                            <td class="x" data-id="{{$current_term == 2 ?    ceil($theFinalResult)  : ''}}"
                                                          data-min_mark="{{  $lesson->min_mark }}"
                                            > </td>
                                            </tr>
                                        </form>
                                        @endif
                                    @endforeach



                                        </tr>
                                    </form>


                                @endif
                                @endif
                                @endif

                        @endif
                    @endforeach




            @endforeach
          <form>
            <tr >
              <td class="main-p" style="border-top: 2px solid #000">المجموع العام </td>
              <td class="max_mark_total1 max_mark2" style="border-top: 2px solid #000">١١٠٠</td>
              <td colspan="2" class="gray-background" style="border-top: 2px solid #000"></td>
              <td class="  {{  $student_rigistration_term == 1 ? 'result1_total result11' : '' }}" style="border-top: 2px solid #000"></td>
              <td class="{{$student_rigistration_term == 1 ? 'x' : ''}}" data-id style="border-top: 2px solid #000" > </td>
              <td colspan="2" class="gray-background" style="border-top: 2px solid #000"> </td>
              <td class="{{ $current_term == 2 ? ' result2_total result22 ' : '' }}"  style="border-top: 2px solid #000"> </td>
              <td class="x" data-id style=" border-left: 3px solid #000;border-top: 2px solid #000"> </td>
              <th class="space-separator" style="background:#fff"></th>
              <td class="{{ $current_term == 2 ? ' total_result1 total_result2 ' : '' }}"  style=" border-right: 3px solid #000;"></td>
              <td class="{{ $current_term == 2 ? 'final_result1 final_result2 ' : '' }}"  ></td>
              <td class="x" data-id=""></td>
              <td  colspan="6">نتيجة التلميذ</td>


            </tr>
          </form>




           {{-- subjects after first total --}}
           @php
                $counter = 0;
           @endphp
           @foreach ($mark_base_subjects as $key88 => $base_subject)

           @php
                $counter++ ;
               $lessons = $base_subject->lessons_mark ;
               $lesson_count =  count($lessons);
               $i = 0;
               $addable_lesson_id = 0;

               // $numItems = count($arr);
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
           @if (++$i === $lesson_count)
               @if ($lesson->is_addable == 1 &&  $lesson->first_total == 0)
               @php
               @endphp
                   <form>
                   <tr>

                       <td class="special-subject">    {{ $lesson_name }} </td>
                       <td class=" max_mark2"> {{  arabic_w2e( $lesson->max_mark ) }} </td>
                       @if($lesson->is_project == 1)
                       <td colspan="2" class="gray-background">
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
                                      $term1_result +=  $item1->exam ;
                                  @endphp
                                @endif
                            @endforeach
                            @endif


                       </td>
                       @else
                        <td>
                            @if(json_decode($student_marks->worke_degree) !== null && $student_rigistration_term == 1)
                            @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                @if($key1 == $lesson->id )
                                    {{   arabic_w2e($item1->term1_result) }}
                                    @php
                                    $term1_result +=  $item1->term1_result ;
                                    @endphp
                                @endif
                            @endforeach
                            @endif
                        </td>
                        <td>
                            @if(json_decode($student_marks->mark) !== null && $student_rigistration_term == 1)
                            @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                @if($key1 == $lesson->id )
                                {{   arabic_w2e($item1->exam) }}
                                @php
                                    $term1_result +=  $item1->exam ;
                                @endphp
                                @endif
                            @endforeach
                            @endif
                        </td>
                       @endif
                        <td class="result11" data-term1_result="{{  $student_rigistration_term == 1 ? $term1_result : ''}}"
                        @if( $term1_result  < $lesson->min_mark)
                        style="color:red !important;"
                      @endif
                        > {{ arabic_w2e( $student_rigistration_term == 1 ? $term1_result : '' )  }} </td>
                        <td class="{{$student_rigistration_term == 1 ? 'x' : ''}}" data-id="{{ $term1_result }}" data-min_mark="{{  $lesson->min_mark }}"> </td>
                       {{-- end term1 result  --}}


                       {{-- start term2 result  --}}
                       @if($lesson->is_project == 1)
                            <td colspan="2" class="gray-background">
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
                                            $term2_result +=  $item1->exam ;
                                        @endphp
                                        @endif
                                    @endforeach
                                    @endif
                            </td>
                       @else
                            <td>
                                @if(json_decode($student_marks->worke_degree) !== null && $current_term == 2)
                                @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                    @if($key1 == $lesson->id )
                                        {{   arabic_w2e(   $item1->term2_result == 'null' ? '' : $item1->term2_result ) }}
                                        @php
                                            $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                            $term2_result +=   $x ;
                                        @endphp
                                    @endif
                                @endforeach
                                @endif
                            </td>

                            <td>
                            @if(json_decode($student_marks->mark2) !== null && $current_term == 2)
                            @foreach(json_decode($student_marks->mark2) as $key1 => $item1 )
                                @if($key1 == $lesson->id )
                                {{   arabic_w2e( $item1->exam ) }}
                                    @php
                                        $term2_result +=  $item1->exam ;
                                    @endphp
                                @endif
                            @endforeach
                            @endif
                            </td>
                       @endif
                     <td class="result22" data-term2_result="{{ $current_term == 2 ? $term2_result : ''}}"
                      @if( $term2_result  < $lesson->min_mark)
                         style="color:red !important;"
                     @endif
                     > {{ $current_term == 2 ?   arabic_w2e($term2_result) : ''}} </td>
                     <td  class="x" data-id="{{$current_term == 2 ? $term2_result : '' }}" data-min_mark="{{  $lesson->min_mark }}" style=" border-left: 3px solid #000;"> </td>
                     <td class="space-separator"  style="background:#fff"></td>
                      @php
                        $theToltalResult = $term1_result + $term2_result ;
                        $dividingRatio =  $student_rigistration_term == 1 ? 2 : 1 ;
                        $theFinalResult = $theToltalResult / $dividingRatio ;
                      @endphp
                     <td data-total_result="{{ $current_term == 2 ?  $theToltalResult : ''}}" style=" border-right: 3px solid #000;" class="total_result2"> {{ $current_term == 2 ?  arabic_w2e($theToltalResult)  : ''}}  </td>
                     <td class="final_result2"  data-final_result="{{ ceil($theFinalResult) }}"
                      @if( ceil($theFinalResult)  < $lesson->min_mark)
                        style="color:red !important;"
                      @endif
                     > {{ $current_term == 2 ? arabic_w2e(ceil($theFinalResult))  : ''}} </td>
                     <td class="x" data-id="{{ $current_term == 2 ?  ceil($theFinalResult) :'' }}" data-min_mark="{{  $lesson->min_mark }}"> </td>


                    @if($base_subject->lessons_mark2->certificate_order == 14)
                        <td colspan="6" rowspan="1" class="report_details text-right"> نجاح إلى الصف
                            @if($report_card->final_result == 2 && $current_term != 1)
                                    {{ $class->next_class_success->name }}
                            @endif
                        </td>
                    @endif
                    @if($base_subject->lessons_mark2->certificate_order == 15)
                        <td colspan="6" rowspan="1" class="report_details text-right"> رسوب في الصف
                             <span class="mr-1">
                                @if($report_card->final_result == 3 && $current_term != 1)
                                    {{ $class->name }}
                                @endif
                            </span>
                        </td>
                    @endif
                    @if($base_subject->lessons_mark2->certificate_order == 16)
                        <td colspan="6" rowspan="1" class="report_details text-right">
                            <div class="row">
                                <div class="col-6">
                                    نقل إلى الصف
                                </div>
                                <div class="col-6">
                                    لأنه معيد
                                </div>

                            </div>
                        </td>
                    @endif


                   </tr>
                   </form>
               @elseif ($lesson->is_addable == 0  &&  $lesson->first_total == 0)
                   @php
                   $addable_lesson_id++ ;
                   $base_subject_id = $base_subject->id ;
                   @endphp
                   @if($addable_lesson_id < 2)
                   <form>
                       <tr>
                           <td rowspan="3">
                               <div class="tab1cards">
                                   <h5 style="writing-mode: vertical-lr;margin-left: 160px;">{{  $base_subject->name  }} </h5>
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
                           @php
                               $term1_result = 0 ;
                               $term2_result = 0 ;
                           @endphp
                           <form>
                               <tr style="color:#753BBD">

                                   <td class=" max_mark2"> {{ arabic_w2e( $lesson2->max_mark ) }} </td>
                                   <td>
                                       @if(json_decode($student_marks->worke_degree) !== null )
                                       @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                           @if($key1 == $lesson2->id )
                                           {{  arabic_w2e( $item1->term1_result ) }}
                                           @php
                                               $term1_result +=  $item1->term1_result ;
                                           @endphp
                                           @endif
                                       @endforeach
                                       @endif
                                   </td>
                                   <td>
                                   @if(json_decode($student_marks->mark) !== null )
                                   @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                       @if($key1 == $lesson2->id )
                                           {{  arabic_w2e( $item1->exam ) }}
                                           @php
                                               $term1_result +=  $item1->exam ;
                                           @endphp
                                       @endif
                                   @endforeach
                                   @endif
                                   </td>
                                   <td class="result11"> {{  arabic_w2e( $term1_result ) }} </td>
                                   <td class="x" data-id="{{ $term1_result }}"> </td>
                                   {{-- end term1 result  --}}


                                   {{-- start term2 result  --}}
                                   <td>
                                   @if(json_decode($student_marks->worke_degree) !== null )
                                   @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                       @if($key1 == $lesson2->id )
                                            {{     arabic_w2e($item1->term2_result == 'null' ? '' : $item1->term2_result) }}
                                            @php
                                                $x = $item1->term2_result == 'null' ? 0 : $item1->term2_result ;
                                                $term2_result +=   $x ;
                                            @endphp
                                       @endif
                                   @endforeach
                                   @endif
                               </td>

                               <td>
                                   @if(json_decode($student_marks->mark2) !== null )
                                   @foreach(json_decode($student_marks->mark2) as $key1 => $item1 )
                                       @if($key1 == $lesson2->id )
                                       {{  arabic_w2e( $item1->exam) }}
                                       @php
                                           $term2_result +=  $item1->exam ;
                                       @endphp
                                       @endif
                                   @endforeach
                                   @endif
                               </td>
                               <td class="result22"> {{  arabic_w2e($term2_result) }} </td>
                               <td class="x" data-id="{{ $term2_result }}"> </td>


                               <td class="total_result2"> {{  arabic_w2e($term1_result + $term2_result) }}  </td>
                               <td class="final_result2"> {{  arabic_w2e(ceil(($term1_result + $term2_result) /2)) }} </td>
                               <td class="x" data-id="{{ ceil(($term1_result + $term2_result) /2) }}"> </td>



                               </tr>
                           </form>
                           @endif
                       @endforeach


                           </tr>
                       </form>


                   @endif
                   @endif

           @endif
       @endforeach
       @endforeach



            <form>
              <tr >
                <td class="main-p" style="border-top: 2px solid #000"> المجموع النهائي </td>
                <td class="max_mark_total2" style="border-top: 2px solid #000">١٣٠٠</td>
                <td colspan="2" class="gray-background" style="border-top: 2px solid #000"> </td>
                <td class=" {{  $student_rigistration_term == 1 ? 'result11_total' : '' }}" style="border-top: 2px solid #000"></td>
                <td class="{{$student_rigistration_term == 1 ? 'x' : ''}}" data-id="" style="border-top: 2px solid #000"> </td>
                <td colspan="2" class="gray-background" style="border-top: 2px solid #000">    </td>
               <td class="{{ $current_term == 2 ? ' result22_total ' : '' }}"   style="border-top: 2px solid #000"></td>
               <td class="x" data-id="" style=" border-left: 3px solid #000;border-top: 2px solid #000"></td>
               <td class="space-separator" style=""></td>
               <td class="{{ $current_term == 2 ? ' total_result22  ' : '' }}"  style=" border-right: 3px solid #000;"></td>
               <td class="{{ $current_term == 2 ? ' final_result22 ' : '' }}" ></td>
               <td class="x" data-id=""></td>
               <td colspan="6" rowspan="1" class="report_details text-right">
                <div class="row">
                    <div class="col-6">
                        نقل إلى الصف
                    </div>
                    <div class="col-6">
                        لاستنفاذ سنوات الرسوب
                    </div>

                </div>
            </td>

             </tr>

              </tr>
            </form>




               <tr>
                <td colspan="2" style="text-align: center;">ملاحظات مدير المدرسة </td>
                <td colspan="8" style=" border-left: 3px solid #000;">

                        {{ isset($report_card) ?  $report_card->manager_notes : ''}}

                </td>
                <td class="space-separator" style="background:#fff"></td>
                <td colspan="9" rowspan="2" style=" border-right: 3px solid #000;">
                 <div class="row"   style="height:120px;position: relative;">
                  <div class="row">
                    <div class="col-2">اسم المدير:</div>
                    <div class="col-3">{{ isset($report_card_details) ? $report_card_details->manager_name : ''}}</div>
                    <div class="col-2">توقيعه:</div>
                    <div class="col-5">الختم:</div>
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

               </tr>

             <form>
               <tr>
                <td colspan="2" > ملاحظات ولي التلميذ </td>
                <td colspan="8" style="text-align: center;border-left: 3px solid #000;"></td>
                <td class="space-separator" style="border-bottom:2px solid #fff !important;background:#fff"></td>

               </tr>
             </form>



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
    <!--<button  class="btn btn-primary "-->
    <!--style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;-->
    <!--background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> حفظ-->
    <!--</button>-->
</div>


                </div><!--end warp-->
             <!-- end card 2-->

     <!-- end form -->

			</div><!-- end container-->


	</form>





    <script>
    $(document).on('click', '.pdf_download', function () {
        // $('form.limiter').addClass('printing1') ;
        $('.pdf_download').hide() ;
        $('.hide').hide() ;
        window.print();
        setInterval(function() {
            // $('form.limiter').removeClass('printing1') ;
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


      <script>
        $(document).ready(function() {

            //English to Arabic digits.
            String.prototype.EntoAr= function() {
              return this.replace(/\d/g, d =>  '٠١٢٣٤٥٦٧٨٩'[d])
            }



         $('.oral').append(`
            <td colspan="6"> الفصل الأول  </td>
         `);

              let result = 0 ;
               $.each($('.result1'), function (key, value) {
                  result1 = $( this).data('term1_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                    result1 = parseInt(result1) ;
                    result +=     result1 ;
                //   if ( result1.length > 0){
                //     result1 = parseInt(result1) ;
                //     result +=     result1 ;
                //   }



                  //   result1 = $( this).text() ;
                  //   result1 = result1.length == 0 ? 0 : result1;
                  //   result1 = parseInt(result1)  ;
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
            if(my_num < min_mark) my_style = "color:red; "
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
            // console.log(text,text.length) ;
         })




    })
    </script>



</body>
</html>




