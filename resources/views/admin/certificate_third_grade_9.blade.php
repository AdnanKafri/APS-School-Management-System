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
    border: 1px solid black;
    padding: 6px;
    background-color:rgb(255, 255, 255);
    color: black;
    font-size: 11px;
     font-weight: 500;
}
td {
    border: 1px solid black;
    padding: 8px;
    font-size: 14px;
    color: #000 ;
}
td.special-subject{
    font-weight:500;
}
.border tr td {
   border: 2px solid white;
}


table tr td:nth-child(2),th:nth-child(2) {
      border-left: 3px solid #000 ;
      border-right: 3px solid #000 ;
    }
table tr td:nth-child(9){
      border-right: 3px solid #000 ;
    }
table tr td:nth-child(13){
      border-right: 3px solid #000 ;
    }
table tr td:nth-child(15){
      border-right: 3px solid #000 ;
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
</head>
<body style=" padding:10px;background-size: cover;
">



<form class="limiter"  action="{{ route('save_report_card') }}" method="post">
    @csrf
    <input type="hidden" name="student_id" class="form-control"
                                            value="{{ $student->id }}" required>
    <input type="hidden" name="stage_id" class="form-control"
                                            value="{{ $stage_id }}" required>



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
                <td colspan="1" style="width:40%;border:0px">
                    <div class="row">
                        <div class="col-6"   style="width:38% !important;font-weight:600"     >
                            <h6 class="text-center"  style="font-weight:700;">
                                الجمهورية العربية السورية  <br>
                                وزارة التربية
                            </h6>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-8">
                            <br>
                            <h6 class="text-right"  style="font-weight:700;"   >
                                مديرية التربية في محافظة حماه
                            </h6>
                            <br>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-8">

                            <h6 class="text-right"   style="font-weight:700;"  >
                                {{$school_data->name}}
                            </h6>

                        </div>
                        <div class="col-4"></div>
                    </div>
                        {{-- <h6 class="text-center mb-2"> <span> وزارة التربية </span></h6> --}}
                </td>

                <td   colspan="1" style="position: relative;width:37%;border:0px">
                    <h3 style="font-weight: 600;position: absolute;top:5px"> مرحلة التعليم الأساسي  </h3>
                    <h6 style="font-weight: 600;font-size:16px;text-align:center;position: absolute;top:39px;right:60px">  الحلقة الثانية   /التاسع/   </h6>
                </td>

                <td  colspan="2"  style="position: relative;width:15%">
                    <p class="paragraph-os text-center" style="position: absolute;bottom:5px">   العام الدراسي:  {{ arabic_w2e($year_name )}} </p>
                </td>

            </tr>
        </thead>
        <tbody>
            <tr>


                <td  colspan="3">
                    <div class="row" style="width:92%">
                        <div class="col-4 text-right" style="width:31% !important">
                            <p class="paragraph-os">
                            <span class="paragraph-os ml-3"> الرقم المتسلسل ({{  arabic_w2e($student->serial_number) }})  </span>

                            <span class="paragraph-os " style="" > اسم التلميذ/ة: <span> {{ $student->first_name.' '.$student->last_name }}</span>       </span>

                            </p>

                        </div>
                        <div class="col-3 text-right" style="width:21% !important">
                            <span class="paragraph-os ml-4"> الأب: <span>{{ $student->details->father_name }}</span> </span>

                            <span class="paragraph-os"> الأم: <span>{{ $student->details->mother_name }}</span></span>
                        </div>
                        <div class="col-3 text-right" style="width:30% !important">
                            <div>
                                <span class="paragraph-os ml-3">تاريخ الميلاد: <span dir="rtl"> {{ arabic_w2e(Carbon\Carbon::parse($student->date_birth)->format('Y/m/d')) }}</span></span>

                                <span class="paragraph-os"> الشعبة: <span>{{ $room_name }}</span></span>
                            </div>
                            {{-- <div>
                                <span class="paragraph-os ml-4"> اللغة الأجنبية: <span>  الإنجليزية</span> </span>
                                <span class="paragraph-os"> الرقم في السجل العام: <span> {{  arabic_w2e($student->public_record_number) }} </span></span>
                            </div> --}}
                        </div>
                        <div class="col-2">
                            <p class="paragraph-os">الرقم في السجل العام: <span >{{  arabic_w2e($student->public_record_number) }} </span></p>

                        </div>

                    </div>
                </td>

            </tr>

        </tbody>
    </table>

    <table id="3" class="h-100 w-100 text-center" summary="Code page support in different versions of MS Windows."
    rules="groups" frame="hsides"
    style="border:3px solid #000;" >
       <tbody>

         <tr style="border:3px solid #000;" >
          <th rowspan="4" style="text-align: center;width:13.3%;font-size:15px"  >المواد <br> الدراسية </th>
          <th  rowspan="4" style="width:4.7%;">
                <span  style="writing-mode: vertical-rl;white-space: pre; text-align: center;transform: rotate(180deg);">  الدرجة العظمى
          </th>
          <th colspan="6" rowspan="1" style="text-align: center;;width:28.7%"> الفصل الأول </th>

          <th colspan="4" rowspan="1" style="text-align: center;;width:21.1%;border-right: 3px solid #000 ;"> الفصل الثاني </th>
          <th colspan="2" style="width:13.7%;border-right: 3px solid #000 ;"> المعدل النهائي</th>
          <th colspan="4" rowspan="1" style="width:18.7%;border-right: 3px solid #000 ;"    > ملاحظات الإدارة </th>

         </tr>

         <tr>
           <th colspan="2" rowspan="1" style="text-align: center; border: 1px solid ;width:7.3%"> درجة أعمال الطالب </th>
           <th colspan="1" rowspan="1" style="text-align: center; border: 1px solid ;width:3.9%"> المعدل </th>
           <th  rowspan="3" style="text-align: center;width:5.2%;font-size:10px;padding:3px"> الامتحان <br>
             الفصلي  الأول </th>
           <th colspan="2" rowspan="2"  style="text-align: center;width:14%"> المحصلة الأولى </th>
           <th colspan="2" rowspan="1" style="text-align: center;border-right: 3px solid #000 ;"> درجة أعمال الطالب </th>
           <th colspan="2" rowspan="2" style="text-align: center;"> المعدل المجموع
            <span style="color:black;"> &#247</span>{{ arabic_w2e(2)}}
           </th>


           <th colspan="2" rowspan="2" style="  border-right: 3px solid #000 ;">
                <div class="Row" style="text-align: center;">
                <small>درجة أعمال الفصل الأول </small>
                </div>
                <div class="Row" style="text-align: center;">
                <small> درجة امتحان الفصل الأول </small>
                </div>
                <div class="Row" style="text-align: center;">
                <small>أعمال الفصل الثاني </small>
                </div>
                <div class="Row" style="text-align: center;"  >
                <span style="color:black;"> &#247</span>{{ arabic_w2e(3)}}
                </div>
           </th>
           <th rowspan="7" style="width: 3%;  border-right: 3px solid #000 ;font-size:11px;">الفصل <br>
                             الأول</th>
           <th rowspan="7" colspan="3" style="font-size:11px;">
                {{isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term1'} : '' }}
           </th>


          </tr>

         <tr>
<th rowspan="2" style="text-align: center;font-size:10px;" > اختبارات <br> شفهية <br> وعلمية <br> ووظائف </th>
          <th rowspan="2" style="text-align: center;  border: 1px ;font-size:10px;" > الاختبارات الشهرية </th>
          <th rowspan="2" style="text-align: center;" > المجموع  <span style="color:black;"> &#247</span>{{ arabic_w2e(2)}}</th>
          <th rowspan="2" style="text-align: center;  border-right: 3px solid #000 ;width:3.6%;font-size:10px;"  > اختبارات <br> شفهية <br> وعلمية <br> ووظائف </th>
          <th rowspan="2" style="text-align: center;width:3.6%;font-size:10px;" > الاختبارات الشهرية </th>
        </tr>

        <tr style="border-bottom:3px solid #000;">
            <th style="width:3.8%;padding:8px"> رقماً </th>
            <th style="text-align: center;width:10.4%; border-right: 1px ;"> كتابة </th>
            <th style="width:3.8%"> رقماً </th>
            <th style="width: 10.4%;text-align:center"> كتابة </th>
            <th style="text-align: center;border-right: 3px solid #000 ;width:3.8%;"> رقماً </th>
            <th style="text-align: center;width: 10.4%;"> كتابة </th>
         </tr>


        @foreach ($mark_base_subjects as $key77 => $base_subject)
        @php


            $lessons = $base_subject->lessons_mark ;
            $lesson_count =  count($lessons);

            $i = 0;
            $term1_work_degree = 0 ;
            $term2_work_degree = 0 ;
            $term1_exam_degree = 0 ;
            $term2_exam_degree = 0 ;
            $term1_result = 0 ;
            $term2_result = 0 ;
            $total_oral = 0;
            $total_quize = 0;
            $oral = 0;
            $quize = 0;
            $exam = 0;
            $base_subject_mark = 0 ;

        @endphp
            @foreach ($lessons as $key => $lesson)
                @php
                    if ( $lesson->religion != null)
                        $lesson_name =  'التربية الدينية' ;

                    else
                    $lesson_name = $lesson->name ;


                    if($lesson_count > 1) {
                        $base_subject_mark +=  $lesson->max_mark ;

                        if(json_decode($student_marks->mark) !== null ){
                            foreach(json_decode($student_marks->mark) as $key1 => $item1 ){
                                if($key1 == $lesson->id ){

                                    $total_oral += $item1->oral + $item1->homework + $item1->activities ;

                                }
                            }
                        }
                        if(json_decode($student_marks->mark) !== null ){
                            foreach(json_decode($student_marks->mark) as $key1 => $item1 ){
                                if($key1 == $lesson->id ){

                                    $total_quize += $item1->quize  ;

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

                    }

                @endphp
                @if (++$i === $lesson_count)
                    @if (  $lesson->first_total)
                        @php


                        @endphp
                        <form>
                            <tr>
                                <td class="special-subject">    {{ $i > 1 ?  $base_subject->name : $lesson_name }} </td>

                                    <td class="max_mark"> {{  arabic_w2e( $i > 1 ?  $base_subject_mark : $lesson->max_mark )}} </td>
                                @if($lesson->is_project == 1)
                                    <td colspan="4">
                                            @if(json_decode($student_marks->mark) !== null  && $student_rigistration_term == 1)
                                                @foreach(json_decode($student_marks->result1) as $key1 => $item1 )
                                                    @if($key1 == $lesson->id )

                                                    @php

                                                        $term1_result += $item1->term1_result;
                                                    @endphp
                                                    @endif
                                                @endforeach
                                            @endif

                                    </td>
                                @else
                                @if(!($i > 1)  && $student_rigistration_term == 1)
                                    @if(json_decode($student_marks->mark) !== null )
                                        @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                            @if($key1 == $lesson->id )
                                            @php
                                                    $oral = $item1->oral + $item1->homework + $item1->activities ;
                                                    $term1_result += $oral ;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                @elseif( $student_rigistration_term == 1)
                                @php
                                    $oral = $total_oral;
                                    $term1_result +=  $total_oral ;
                                    @endphp
                                @endif
                                    <td class="oral" data-oral="{{ $oral }}">
                                         @if( $student_rigistration_term == 1)
                                            {{ arabic_w2e($oral)  }}
                                        @endif
                                    </td>

                                    @if(!($i > 1)  && $student_rigistration_term == 1)
                                        @if(json_decode($student_marks->mark) !== null )
                                            @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )

                                                @php
                                                        $quize  = $item1->quize ;
                                                        $term1_result +=  $item1->quize  ;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    @elseif( $student_rigistration_term == 1)
                                    @php
                                    $quize =  $total_quize ;
                                    $term1_result +=  $total_quize;
                                    @endphp
                                    @endif
                                    <td class="quize" data-quize="{{ $quize }}">
                                         @if( $student_rigistration_term == 1)
                                            {{ arabic_w2e($quize)  }}
                                        @endif
                                    </td>
                                    <td class="oral_quize" data-oral_quize="{{  $term1_result }}">
                                         @if( $student_rigistration_term == 1)
                                            {{ arabic_w2e($term1_result)  }}
                                        @endif

                                    </td>
                                    @if(!($i > 1)  && $student_rigistration_term == 1)
                                    @if(json_decode($student_marks->mark) !== null )
                                        @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                            @if($key1 == $lesson->id )
                                            @php
                                                $exam = $item1->exam ;
                                                $term1_result +=  $item1->exam  ;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                    @elseif( $student_rigistration_term == 1)
                                    @php
                                    $exam =  $term1_exam_degree ;
                                    $term1_result +=  $term1_exam_degree ;
                                    @endphp
                                    @endif
                                    <td class="exam" data-exam="{{ $exam }}">
                                         @if( $student_rigistration_term == 1)
                                            {{ arabic_w2e($exam)  }}
                                        @endif
                                    </td>
                                @endif
                                <td class="result1" data-term1_result="{{ $student_rigistration_term == 1 ? $term1_result : ''  }}"
                                @if( $term1_result  < $lesson->min_mark)
                                style="color:red !important;"
                               @endif
                                > {{  arabic_w2e(  $student_rigistration_term == 1 ? $term1_result : '' ) }} </td>

                                <td class="{{$student_rigistration_term == 1 ? 'x' : ''}}" data-id="{{ $term1_result }}" data-min_mark="{{  $lesson->min_mark }}"
                                style="border-left: 3px solid #000 ;"> </td>

                                <td></td>
                                <td></td>
                                <td  ></td>
                                <td style="border-right: 1px solid #000 ;border-left: 3px solid #000 ;"></td>
                                <td></td>
                                <td></td>

                                @if($key77 + 1 == 5)
                                    <td rowspan="7" style="width: 3%;font-weight:bold">  الفصل <br>
                                                                         الثاني  </td>
                                    <td rowspan="7" colspan="3" style="font-size:11px;font-weight:bold;color:#000">
                                        {{isset($report_card) ?  json_decode($report_card->teacher_notes)->{'term2'} : '' }}
                                    </td>
                                @endif


                            @endif
                        @endif
                    @endforeach
                @endforeach



        <tr>
          <td style="font-weight:700"> المجموع العام </td>
          <td class="max_mark_total1 max_mark2"> {{ arabic_w2e( 3700 ) }}</td>
          <td class="{{ $student_rigistration_term == 1 ? 'oral_total oral11' : '' }}">  </td>
          <td class="{{ $student_rigistration_term == 1 ? 'quize_total quize11' : '' }}">  </td>
          <td class="{{ $student_rigistration_term == 1 ? 'oral_quize_total oral_quize11' : '' }}">  </td>
          <td class="{{ $student_rigistration_term == 1 ? 'exam_total exam11' : '' }}">  </td>
          <td class="{{ $student_rigistration_term == 1 ? 'result1_total result11' : '' }}">  </td>
          <td class="{{$student_rigistration_term == 1 ? 'x' : ''}} result1_total_write"> </td>
          <td class="oral_total2 oral22">  </td>
          <td class="quize_total2 quize22">  </td>
          <td class="oral_quize_total2 oral_quize22">  </td>

          <td>  </td>
          <td>  </td>
          <td style="width: 10%;">   </td>
        </tr>


        @foreach ($mark_base_subjects as $key77 => $base_subject)
        @php
            $lessons = $base_subject->lessons_mark ;
            $lesson_count =  count($lessons);

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

                    else
                    $lesson_name = $lesson->name ;


                    if ($lesson_count < 2 || $i == 0){

                    }
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
                        @php


                        @endphp
                        <form>
                            <tr>
                                <td class="special-subject">    {{ $i > 1 ?  $base_subject->name : $lesson_name }} </td>

                                <td class="max_mark"> {{ arabic_w2e(  $lesson->max_mark )}} </td>
                                @if($lesson->is_project == 1)
                                    <td colspan="4">
                                            @if(json_decode($student_marks->mark) !== null && $student_rigistration_term == 1)
                                                @foreach(json_decode($student_marks->result1) as $key1 => $item1 )
                                                    @if($key1 == $lesson->id )

                                                    @php

                                                        $term1_result += $item1->term1_result;
                                                    @endphp
                                                    @endif
                                                @endforeach
                                            @endif

                                    </td>
                                @else
                                    <td >
                                        @if(!($i > 1) && $student_rigistration_term == 1)
                                            @if(json_decode($student_marks->mark) !== null )
                                                @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                    @if($key1 == $lesson->id )
                                                        {{  arabic_w2e( $item1->oral + $item1->homework + $item1->activities ) }}
                                                        @php
                                                            $term1_result += $item1->oral + $item1->homework + $item1->activities ;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                        @elseif($student_rigistration_term == 1)
                                            {{  arabic_w2e(  $term1_work_degree ) }}
                                            @php
                                            $term1_result +=  $term1_work_degree ;
                                            @endphp
                                        @endif
                                    </td>
                                    <td >
                                        @if(!($i > 1) && $student_rigistration_term == 1)
                                            @if(json_decode($student_marks->mark) !== null )
                                                @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                    @if($key1 == $lesson->id )
                                                        {{  arabic_w2e( $item1->quize )  }}
                                                        @php
                                                            $term1_result +=  $item1->quize  ;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                        @elseif($student_rigistration_term == 1)
                                        {{ arabic_w2e( $term1_exam_degree ) }}
                                        @php
                                        $term1_result +=  $term1_exam_degree ;
                                        @endphp
                                        @endif
                                    </td>
                                    <td >
                                         @if( $student_rigistration_term == 1)
                                            {{ arabic_w2e($term1_result)  }}
                                        @endif


                                    </td>
                                    <td >
                                        @if(!($i > 1) && $student_rigistration_term == 1)
                                        @if(json_decode($student_marks->mark) !== null )
                                            @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )
                                                    {{ arabic_w2e(  $item1->exam ) }}
                                                    @php
                                                    $term1_result +=  $item1->exam  ;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                        @elseif($student_rigistration_term == 1)
                                            {{ arabic_w2e( $term1_exam_degree ) }}
                                            @php
                                            $term1_result +=  $term1_exam_degree ;
                                            @endphp
                                        @endif

                                    </td>
                                @endif
                                <td class="result11 " data-term1_result="{{ $student_rigistration_term == 1 ? $term1_result : '' }}"
                                @if( $term1_result  < $lesson->min_mark)
                                style="color:red !important;"
                                @endif
                                >
                                    {{ arabic_w2e(  $student_rigistration_term == 1 ? $term1_result : '' ) }}

                                </td>


                                <td class="{{$student_rigistration_term == 1 ? 'x' : ''}}" data-id="{{ $term1_result }}" data-min_mark="{{  $lesson->min_mark }}" style="border-left: 3px solid #000 ;"> </td>
                                @if($lesson->is_project == 1)
                                <td colspan="4" style="border-left: 3px solid #000"> </td>
                                @else
                                <td></td>
                                <td></td>
                                <td  ></td>
                                <td style="border-right: 1px solid #000 ;border-left: 3px solid #000 ;"></td>
                                @endif

                                 @if($key77 + 1 == 12)
                                   <td colspan="2"></td>
                                @endif
                                 @if($key77 + 1 == 11)
                                    <td ></td>
                                    <td></td>
                                    <td rowspan="2" colspan="4"  style="border-top: 3px solid #000;">  متوسط درجة السلوك في الصف التاسع  </td>

                                @endif
                            </tr>

                            @endif
                        @endif
                    @endforeach
                @endforeach







        <tr >
          <td style="border-top: 3px solid #000 ;
                     border-bottom: 3px solid #000 ;font-weight:700"> المجموع النهائي </td>
          <td  style="border-top: 3px solid #000 ;
                        border-bottom: 3px solid #000 ;"> {{ arabic_w2e( 3900 )  }}</td>
          <td colspan="4"  style="border-top: 3px solid #000 ;
          border-bottom: 3px solid #000 ;"> </td>
          <td class="{{$student_rigistration_term == 1 ? 'result11_total' : ''}}"  style="border-top: 3px solid #000 ;
          border-bottom: 3px solid #000 ;"> </td>
          <td class="{{$student_rigistration_term == 1 ? 'x final_total_write' : ''}}" style="border-left: 3px solid #000 ;border-top: 3px solid #000 ;
          border-bottom: 3px solid #000 ;"> </td>
          <td colspan="4" style="border-left: 3px solid #000 ;border-top: 3px solid #000 ;
          border-bottom: 3px solid #000 ;">  </td>
          <td  style="border-top: 3px solid #000 ;
          border-bottom: 3px solid #000 ;">  </td>
          <td  style="border-top: 3px solid #000 ;
          border-bottom: 3px solid #000 ;"> </td>

          <td colspan="2" >الفصل الأول</td>
          <td  style="width: 50px">الفصل الثاني</td>
          <td  > <div style="width: 60px"> المجموع<span style="color:black;"> &#247</span>{{ arabic_w2e(2)}}</div></td>


        </tr>
        <tr style="height: 35px">
            <td></td>
            <td colspan="13"></td>

            <td colspan="2"></td>
            <td></td>
            <td colspan="1">

            </td>
        </tr>

        <tr style="border-top: 3px solid #000 ;">
          <td rowspan="2"> جدول مواد التلميذ </td>
          <td rowspan="2" colspan="2" style="text-align: center;border-left: 1px solid #000 ;"> عدد أيام الدوام الفعلي </td>
          <td  colspan="4" style="text-align: center;"> الغياب </td>
          <td colspan="7" rowspan="2" style="text-align: center;"> ملاحظات ولي التلميذ </td>
          <td colspan="4" rowspan="5" style="border-right: 3px solid #000 ;">
            <div class="row h-100" style="position: relative">
                <br>
                <h6 style="margin:auto">

                    النتيجة النهائية
                </h6>
                <div style="text-align: right;">
                    <div style="font-size: 8px;font-weight:700;"> <span class="square"></span>تم ترشيحه إلى الامتحان العام لشهادة التعليم الأساسي </div>
                    <div style="font-size: 8px;font-weight:700;margin-top:15px"> <span class="square"></span>لم يتم ترشيحه إلى الامتحان العام لشهادة التعليم الأساسي </div>
                </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="text-align: center;border-left: 0;"> مبرر </td>
          <td style="text-align: center;border-left: 0;border-right:0;"> غير مبرر </td>
          <td colspan="2" style="text-align: center;border-right:0;"> المجموع </td>



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

            $actual_attendance2 =    isset($report_card_details->actual_attendance) ? json_decode($report_card_details->actual_attendance)->{'term2'} :  0 ;
            $justified_absence2 =    isset($report_card) ?  json_decode($report_card->justified_absence)->{'term2'} : 0;
            $unjustified_absence2 =  isset($report_card) ? json_decode($report_card->unjustified_absence)->{'term2'} : 0;

            // $total_student_attendance =  $student_attendance1 +  $student_attendance2 ;
            $total_actual_attendance =  $actual_attendance1 +  $actual_attendance2 ;
            $total_justified_absence =  $justified_absence1 +  $justified_absence2 ;
            $total_unjustified_absence =  $unjustified_absence1 +  $unjustified_absence2 ;

            $term1_student_attendance = $actual_attendance1 - $justified_absence1 - $unjustified_absence1 ;
            $term2_student_attendance = $actual_attendance2 - $justified_absence2 - $unjustified_absence2 ;
            $total_student_attendance =  $term1_student_attendance +  $term2_student_attendance ;


            $attendance_percent = $total_student_attendance / ($total_actual_attendance != 0 ? $total_actual_attendance : 1 )  * 100 ;
            $term1_attendance_percent = $student_attendance1 / ($actual_attendance1 != 0 ? $actual_attendance1 : 1 )  * 100 ;
            $term2_attendance_percent = $student_attendance2 / ($actual_attendance2 != 0 ? $actual_attendance2 : 1 )  * 100 ;
        @endphp
        <tr>
          <td> الفصل الأول </td>
          <td colspan="2" style="border-left: 1px solid #000 ;">
            {{$student_rigistration_term == 1 ? $actual_attendance1 : ''}}
          </td>
          <td >
            {{$student_rigistration_term == 1 ? $justified_absence1 : ''}}
          </td>
          <td>
            {{$student_rigistration_term == 1 ? $unjustified_absence1 : ''}}          </td>
          <td colspan="2">{{$student_rigistration_term == 1 ?  arabic_w2e(  ceil($term1_student_attendance) ) : ''}} </td>
          <td colspan="7" rowspan="4"></td>
        </tr>
        <tr>
          <td> الفصل الثاني </td>
          <td colspan="2" style="border-left: 1px solid #000 ;">
            {{ isset($report_card_details->actual_attendance) ? arabic_w2e( json_decode($report_card_details->actual_attendance)->{'term2'}) : '٠'}}
          </td>
          <td >
            {{  isset($report_card) ?  arabic_w2e( json_decode($report_card->justified_absence)->{'term2'}) : '٠'}}
          </td>
          <td>
            {{  isset($report_card) ?  arabic_w2e( json_decode($report_card->unjustified_absence)->{'term2'}) : '٠'}}
          </td>
          <td colspan="2"> {{   arabic_w2e(  ceil($term2_student_attendance) ) }}  </td>
        </tr>
        <tr>
          <td> المجموع </td>
          <td colspan="2" style="border-left: 1px solid #000 ;"> {{  arabic_w2e( $total_actual_attendance ) }} </td>
          <td > {{  arabic_w2e(  $total_justified_absence  ) }} </td>
          <td> {{  arabic_w2e(  $total_unjustified_absence )  }}</td>
          <td colspan="2"> {{  arabic_w2e(  $term1_student_attendance +  $term2_student_attendance ) }} </td>
        </tr>
        <tr>
          <td> النسبة المئوية للدوام </td>
          <td colspan="2" style="border-left: 1px solid #000 ;">  </td>
          <td >  </td>
          <td> </td>
          <td colspan="2">  {{   arabic_w2e( ceil($attendance_percent) ) .'%' }}</td>
          <td colspan="4" rowspan="2" style="border-right: 3px solid #000 ;">
               <div class="row" >
                <div class="col-5 text-right">
                    <p class=" mb-0 mr-2" style="color:#000;font-size:12px">اسم المدير</p>
                    <p class="mt-2 mb-0 " style="color:#000;font-size:10px"> {{ isset($report_card_details) ? $report_card_details->manager_name : ''}}</p>
                      @php
                        $report_card_date =  isset($report_card_details) ? json_decode($report_card_details->report_card_date)->{'term1'} : '' ;
                        $formatted_date = empty($report_card_date) ? '' : arabic_w2e(Carbon\Carbon::parse($report_card_date)->format('Y/m/d'))  ;
                    @endphp

                    <p class=" mb-0 " style="color:#000;font-size:10px"> التاريخ:  {{ $formatted_date }} </p>

                </div>

                <div class="col-4 text-right">التوقيع  </div>

                <div class="col-3 text-left">  الختم</div>
            </div>
          </td>
        </tr>
         <tr style="border-top: 3px solid #000 ;">
              <td colspan="8">

                <div class="row">
                    <div class="col-3 text-right">
                        توقيع الموجه
                    </div>
                    <div class="col-2"></div>
                    <div class="col-4 text-right">
                        توقيع المدير
                    </div>
                </div>
            </td>


              <td colspan="6" style="border-right: 1px solid #000 ;">
                <div class="row">
                    <div class="col-3 text-right mr-4">
                        توقيع الموجه
                    </div>
                    <div class="col-2"></div>
                    <div class="col-4 text-right">
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




     <!-- end form -->

	</form>

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
                 final_result2 = 0 ;
               $.each($('.oral'), function (key, value) {
                  result1 = $( this).data('oral') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  final_result2 +=     result1 ;

                })
                $('.oral_total').html((final_result2).toLocaleString('ar-EG'))
                 final_result2 = 0 ;
               $.each($('.quize'), function (key, value) {
                  result1 = $( this).data('quize') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  final_result2 +=     result1 ;

                })
                $('.quize_total').html((final_result2).toLocaleString('ar-EG'))
                 final_result2 = 0 ;
                $.each($('.oral_quize'), function (key, value) {
                  result1 = $( this).data('oral_quize') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  final_result2 +=     result1 ;

                })
                $('.oral_quize_total').html((final_result2).toLocaleString('ar-EG'))
                 final_result2 = 0 ;
                $.each($('.exam'), function (key, value) {
                  result1 = $( this).data('exam') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  final_result2 +=     result1 ;

                })
                $('.exam_total').html((final_result2).toLocaleString('ar-EG'))




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
            if ( text.includes("زراع") || text.includes("مهني") ){
                $(this).siblings().not(".report_details").text('') ;
            }
             if (text.length > 30) {
                $(this).css('font-size','12px')
            }

         })
    });
    </script>





</body>
</html>
