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

    /*checkbox */
    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:600&display=swap');

 input[type="checkbox"] {

   text-align: right;
   position: relative;
   width: 1.1em;
   height: 1.1em;
   color: #094e89;
   border: 1px solid #094e89;
   border-radius: 4px;
   appearance: none;
   outline: 0;
   cursor: pointer;
   transition: background 175ms cubic-bezier(0.1, 0.1, 0.25, 1);
 }
 input[type="checkbox"]::before {
   position: absolute;
   content: '';
   display: block;
   top: 2px;
   right: 7px;
   width: 4px;
   height: 10px;
   border-style: solid;
   border-color: #fff;
   border-width: 0 2px 2px 0;
   transform: rotate(45deg);
   opacity: 0;
 }
 input[type="checkbox"]:checked {
   color: #fff;
   border-color: #ffb832;
   background: #ffb832;
 }
 input[type="checkbox"]:checked::before {
   opacity: 1;
 }
 input[type="checkbox"]:checked ~ label::before {
   clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
 }
 label {
   color: #0b273f;
   position: relative;
   cursor: pointer;
   font-size: 1.1em;
   font-weight: 400;
   padding: 0 0.25em 0;
   user-select: none;
 }
 label::before {
   position: absolute;
   content: attr(data-content);
   color: #9c9e9f;
   clip-path: polygon(0 0, 0 0, 0% 100%, 0 100%);
   text-decoration: line-through;
   text-decoration-thickness: 3px;
   text-decoration-color: #363839;
   transition: clip-path 200ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
 }


    /*end checkbox*/
    /*cards*/

 .data-card {
   display: flex;
   flex-direction: column;
   max-width: 55.75em;

   min-height: auto;
   overflow: hidden;
   border-radius: 0.5em;
   text-decoration: none;
   background: white;
   margin: 1em;
   padding: 2.75em 5.5em;
   text-align: right;
   box-shadow: 0 1.8em 2.7em -0.7em rgba(0, 0, 0, 0.3);
   transition: transform 0.45s ease, background 0.45s ease;
 }
 @media (max-width: 992px) {
   .data-card {
     padding: 177px 90px 33px 85px;
   }



   .data-card {
     width: 50%;
   }
 }

 @media (max-width: 768px)  {
   .data-card {
     padding: 100px 80px 33px 80px;
   }

   .data-card {
     width: 100%;
   }
 }

 @media only screen and (max-width: 868px)  {
   .data-card {
     padding: 100px 80px 33px 80px;
   }

   .data-card {
     width: 100%;
   }
 }
 @media only screen and (max-width: 968px)  {
   .data-card {
     padding: 100px 80px 33px 80px;
   }

   .data-card {
     width: 100%;
   }
 }
 @media only screen and (max-width: 985px)  {
   .data-card {
     padding: 100px 80px 33px 80px;
   }

   .data-card {
     width: 100%;
   }
 }
 @media only screen and (max-width: 988px)  {
   .data-card {
     padding: 100px 80px 33px 80px;
   }

   .data-card {
     width: 100%;
   }
 }

 @media (max-width: 772px) , (max-width:991px) , (max-width:992px){
   .data-card {
     padding: 100px 80px 33px 80px;
   }
   .data-card {
     width: 100%;
   }
 }

 @media (max-width: 576px) {
   .data-card {
     padding: 10px 15px 33px 15px;
   }
 }

 .data-card h3 {
   color: #2E3C40;
   font-size: 3.5em;
   font-weight: 600;
   line-height: 1;
   padding-bottom: 0.5em;
   margin: 0 0 0.142857143em;
   border-bottom: 2px solid #753BBD;
   transition: color 0.45s ease, border 0.45s ease;
 }
 .data-card h4 {
   color: #627084;
   text-transform: uppercase;
   font-size: 1.125em;
   font-weight: 700;
   line-height: 1;
   letter-spacing: 0.1em;
   margin: 0 0 1.777777778em;
   transition: color 0.45s ease;
 }
 .data-card p {
   opacity: 0;
   color: #FFFFFF;
   font-weight: 600;
   line-height: 1.8;
   margin: 0 0 1.25em;
   transform: translateY(-1em);
   transition: opacity 0.45s ease, transform 0.5s ease;
 }
 .data-card .link-text {
   display: block;
   color: #753BBD;
   font-size: 1.125em;
   font-weight: 600;
   line-height: 1.2;
   margin: auto 0 0;
   transition: color 0.45s ease;
 }
 .data-card .link-text svg {
   margin-left: 0.5em;
   transition: transform 0.6s ease;
 }
 .data-card .link-text svg path {
   transition: fill 0.45s ease;
 }
 .data-card:hover {
   background: #FFFFFF;
   transform: scale(1.02);
 }
 .data-card:hover h3 {
   color: #FFFFFF;
   border-bottom-color: #A754C4;
 }
 .data-card:hover h4 {
   color: #FFFFFF;
 }
 .data-card:hover p {
   opacity: 1;
   transform: none;
 }
 .data-card:hover .link-text {
   color: #FFFFFF;
 }
 .data-card:hover .link-text svg {
   animation: point 1.25s infinite alternate;
 }
 .data-card:hover .link-text svg path {
   fill: #FFFFFF;
 }
 @keyframes point {
   0% {
     transform: translateX(0);
   }
   100% {
     transform: translateX(0.125em);
   }
 }


 /*end cards*/

 /*input*/
  /*
 =====
 HELPERS
 =====
 */

 .ha-screen-reader{
   width: var(--ha-screen-reader-width, 1px);
   height: var(--ha-screen-reader-height, 1px);
   padding: var(--ha-screen-reader-padding, 0);
   border: var(--ha-screen-reader-border, none);

   position: var(--ha-screen-reader-position, absolute);
   clip: var(--ha-screen-reader-clip, rect(1px, 1px, 1px, 1px));
   overflow: var(--ha-screen-reader-overflow, hidden);
 }



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
     border: 2px solid black;
 }
 th,td{
     border: 2px solid black;
     padding: 5px;
     background-color:white;
     color: #000;
     font-size: 11px;
     font-weight: 700;
 }

 td:not(.special-subject),td{
     font-size: 10px;
 }
 td p{
  color:  #000 ;
  font-size: 10px ;
 }
 .upper-table td {
     border: 0px ;
     padding: 5px;
 }


 .vertical {
             border-left: 1px solid rgb(110, 110, 110);
             height: 81px;
             /* position:absolute; */

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
 .main-p {
    font-family: revert;
    font-weight: 600;
    color: #000;
 }
 .square {
  height: 13px;
  width: 20px;
  background-color: #fff;
  border: 1px solid #000;
  box-shadow: 0px 1px 3px 1px  rgba(0,0,0,0.75);
-webkit-box-shadow: 0px 1px 3px 1px  rgba(0,0,0,0.75);
-moz-box-shadow: 0px 1px 3px 1px  rgba(0,0,0,0.75);
}

.space-separator{
    border: 0px !important ;
}

 </style>
  @php
        $school_data = \App\School_data::first();
        @endphp

</head>
<body style="margin-top:5%;  background-image: url('../simages/IMG_3225.jpg');background-size: cover;
">



    <form class="limiter animate__animated animate__lightSpeedInRight animate__delay-1s"  action="{{ route('save_report_card') }}" method="post">
    @csrf
     <input type="hidden" name="student_id" class="form-control"
                                            value="{{ $student->id }}" required>
      <input type="hidden" name="stage_id" class="form-control"
                                            value="{{ $stage_id }}" required>
    <div class="" >

     <table id="1"  style="border-color: white;text-align:center; width:100%;"   >
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
            <td colspan="2" class="upper-table"  style="border-color: white">
            <table class="upper-table w-100"  style="border-color: white">
                    <thead>

                            <tr>
                            <td colspan="3" style="width:40%">
                                <div class="row">
                                    <div class="col-8 row"   style="">
                                        <h7 class="text-center col-7"  style="font-weight:500" >
                                            الجمهورية العربية السورية  <br>
                                            وزارة التربية
                                        </h7>
                                    </div>


                                    <div class="col-4"></div>

                                    <div class="col-4"></div>
                                </div>
                            </td>

                            <td   colspan="3" style="position: relative;width:39%">
                                <h5 class="my-title" style="font-weight: 600;position: absolute;top:5px;right:95px;font-size:15px;font-weight:700">  {{$className}} </h5>
                            </td>

                            <td  colspan="2"  style="position: relative;width:17%">
                                <p class="paragraph-os text-center" style="position: absolute;top:18px;right:25px;font-size:13px">   العام الدراسي:  &nbsp;&nbsp;&nbsp;{{ arabic_w2e($year_name )}} </p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <td colspan="11">
                                <div class="col-12 row text-right">
                                    <br>
                                    <div class="col-4" style="width:27.5%">
                                        <h7 class="text-right "   style="font-weight:500"    >
                                            مديرية التربية في محافظة:   &nbsp     حماه
                                        </h7>
                                    </div>

                                    <div class="col-4 text-right">
                                         <h7 class="text-right"   style="font-weight:500;padding-right: 27px;"  >
                                                 {{$school_data->name}} الافتراضية
                                        </h7>
                                    </div>
                                    <br>

                                     <div class="col-4 text-right" style="">
                                          <p>
                                              <!--<span class="paragraph-os ml-4"> الصف: <span> {{ $class->name}}</span> </span>-->
                                              <span class="paragraph-os"> الشعبة: <span>{{ $room_name }}</span></span>
                                          </p>

                                    </div>
                                </div>
                            </td>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>


                            <td  colspan="11">
                                <div class="row" style="margin-bottom:-30px">
                                    <div class=" text-right" Style="width:18%">
                                      <p class="paragraph-os" style="margin-bottom: 25px;">
                                        <span class="paragraph-os ml-2"> الرقم المتسلسل ({{  arabic_w2e($student->serial_number) }})  </span>
                                        <span class="paragraph-os " style="padding-right:15px" > الطالب/ة: <span> {{ $student->first_name.' '.$student->last_name }}</span>       </span>
                                      </p>
                                    </div>


                                     <div class=" " style="width:13%">
                                      <span class="paragraph-os "> الأب: <span>{{ $student->details->father_name }}</span> </span>
                                    </div>

                                    <div  style="width:10%">
                                      <span class="paragraph-os"> الأم: <span>{{ $student->details->mother_name }}</span></span>
                                    </div>
                                    <div style="width:7%"></div>
                                    <div class=" " style="width:13%;margin-right: 15px;text-align: right;">
                                      <span class="paragraph-os">مواليد : <span dir="rtl"> {{ $student->place_birth }}</span></span>
                                    </div>

                                    <div class=" " style="width:12%">
                                        <span class="paragraph-os">عام : <span dir="rtl"> {{ arabic_w2e(Carbon\Carbon::parse($student->date_birth)->format('Y/m/d')) }}</span></span>
                                    </div>

                                    <div class=" " style="width:22%;text-align: right;">
                                          <span class="paragraph-os"> رقمه في السجل العام: <span> {{  arabic_w2e($student->public_record_number) }} </span></span>
                                    </div>



                                </div>
                            </td>

                        </tr>

                    </tbody>
                </table>
                </td>
            </tr>
        </thead>

        <tbody >
         <tr style="border-color: white;"  >

            <td style="border-color: white;"  >
                <table >
                  <tbody>
                      <tr>
                        <td  rowspan="2" style="text-align: center;width:6.975%;font-weight:600;" >  المواد الدراسية </td>
                        <td  rowspan="2"    style="text-align: center;width:2.79%;font-weight:600">
                             <span style="writing-mode: vertical-rl;white-space: pre; ">الدرجة العظمى</span>
                             </td>
                        <td colspan="3" rowspan="1"  style="text-align: center;font-weight:600; height:55px" >

                            درجة أعمال
                            الفصل
                             الدراسي الأول

                        </td>
                        <td colspan="2" rowspan="1"  style="text-align: center;font-weight:600;" >
                          درجة امتحان
                          الفصل
                           الدراسي الأول
                        </td>
                        <td colspan="2" rowspan="1"  style="text-align: center;font-weight:600 ; " >
                          درجة أعمال الفصل الدراسي
                          الثاني
                        </td>
                        <td  rowspan="2" class="space-separator" style="width:7.627%;background:#fff;border-top: 2px solid white !important;"><p style=""></p></td>

                        <td colspan="1"  rowspan="1" style="text-align: center;width:7.25%;font-weight:600;">
                          <div style="text-align: center">المجموع&#247;{{arabic_w2e(3)}}</div>
                        </td>

                        <td rowspan="1" colspan="2" style="font-weight:600;">
                           <div style="">المحصلة</div>
                        </td>
                        <td rowspan="1" colspan="3" style="width: 16.75%;font-weight:600;">
                          الملاحظات
                        </td>


                      </tr>



                      <tr>
                        <td  colspan="1" rowspan="1" style="text-align: center;font-weight:600;width:4.185%">
                          رقماً
                        </td>
                        <td colspan="2" rowspan="1"  style="text-align: center;font-weight:600;width:10%">
                          كتابةً
                        </td>
                        <td  colspan="1" rowspan="1" style="text-align: center;font-weight:600;width:3.53%">
                          رقماً
                        </td>
                        <td colspan="1" rowspan="1"  style="text-align: center;font-weight:600;width:9.76%">
                          كتابةً
                        </td>
                        <td  colspan="1" rowspan="1" style="text-align: center;font-weight:600;width:4.185%">
                          رقماً
                        </td>
                        <td colspan="1" rowspan="1"  style="text-align: center;font-weight:600;width:9.76%">
                          كتابةً
                        </td>
                        <td  colspan="1" rowspan="1" style="text-align: center;font-weight:600;width:3%">
                          رقماً
                        </td>
                        <td  colspan="1" rowspan="1" style="text-align: center;font-weight:600;width:2.325%">
                          رقماً
                        </td>
                        <td colspan="1" rowspan="1"  style="text-align: center;font-weight:600;width:15.9%">
                          كتابةً
                        </td>
                        <td colspan="3" rowspan="7"  style="text-align: center;font-weight:600">
                                  {{ isset($report_card) ?  $report_card->manager_notes : ''}}
                        </td>



                      </tr>




                    @foreach ($mark_base_subjects as $key77 => $base_subject)
                    @php
                        $lessons = $base_subject->lessons_mark ;
                        $lesson_count =  count($lessons);
                        $i = 0;
                        $addable_lesson_id = 0;

                    @endphp
                    @foreach ($lessons as $key => $lesson)
                     @if($lesson->certificate_order !=0)
                        @php
                            if ( $lesson->religion != null)
                                $lesson_name =  'التربية الدينية' ;

                            else
                            $lesson_name = $lesson->name ;
                            $term1_work_degree = 0 ;
                            $term1_exam = 0 ;
                            $term2_work_degree = 0 ;
                            $total_result = 0;
                            $result = 0;
                            $term1_result = 0 ;
                            $term2_result = 0 ;


                            $before_first_total_subjects = [] ;
                        @endphp
                        @if (++$i === $lesson_count)
                            @if (  $lesson->first_total)

                                <form>
                                <tr>

                                    <td class="special-subject">    {{ $lesson_name }} </td>
                                    <td  class="max_mark" data-max_mark="{{ $lesson->max_mark }}"> {{  arabic_w2e($lesson->max_mark) }} </td>

                                    @if($student_rigistration_term == 1)
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
                                    @endif
                                     <td class="work_degree1" data-work_degree="{{ $term1_work_degree }}">
                                           @if( $student_rigistration_term == 1)
                                                {{ arabic_w2e($term1_work_degree)  }}
                                           @endif
                                     </td>
                                    <td colspan="2" class="{{ $student_rigistration_term == 1 ? 'x' : '' }}"  data-id="{{ $term1_work_degree }}" > </td>
                                     @if(  $student_rigistration_term == 1)
                                            @if(json_decode($student_marks->mark) !== null )
                                            @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )

                                                  @php
                                                    $term1_exam = $item1->exam  == 'null' ? '' : $item1->exam  ;
                                                    $total_result += $term1_exam ;
                                                  @endphp
                                                @endif
                                            @endforeach
                                            @endif

                                        @endif
                                      <td class="exam1" data-exam="{{ $term1_exam }}">
                                            @if( $student_rigistration_term == 1)
                                                {{ arabic_w2e($term1_exam)  }}
                                            @endif
                                      </td>
                                    <td colspan="1" class="{{ $student_rigistration_term == 1 ? 'x' : '' }}"  data-id="{{ $term1_exam }}" > </td>

                                      @if(json_decode($student_marks->worke_degree) !== null &&  $current_term == 2)
                                      @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                          @if($key1 == $lesson->id )

                                            @php
                                                $term2_work_degree = $item1->term2_result  == 'null' ? 0 : $item1->term2_result  ;
                                                $total_result += $term2_work_degree ;

                                            @endphp
                                          @endif
                                      @endforeach
                                      @endif
                                    <td class="work_degree2" data-work_degree = "{{ $term2_work_degree }}" >
                                         @if( $current_term == 2)
                                                {{ arabic_w2e($term2_work_degree)  }}
                                        @endif
                                    </td>
                                    <td colspan="1" class="{{ $current_term == 2 ? 'x' : '' }}"  data-id="{{ $term2_work_degree }}" > </td>

                                     <td class="space-separator"  style="
                                             border-left: 2px solid #000;
                                             border-right: 2px solid #000;
                                             width:5%;background:#fff"></td>
                                    <td class="total_result"  data-total_result="{{$current_term == 2 ? $total_result : ''  }}"
                                    > {{  arabic_w2e($current_term == 2 ? $total_result : '' ) }} </td>
                                    <td class="final_result"  data-final_result="{{ $current_term == 2 ? ceil($total_result/3)  : ''  }}"
                                    > {{  arabic_w2e($current_term == 2 ? ceil($total_result/3) : '' ) }} </td>
                                    <td colspan="1" class="{{  $current_term == 2 ? 'x' : '' }}" data-id="{{ ceil($total_result/3) }}" data-min_mark="{{  $lesson->min_mark }}"> </td>
                                    {{-- end term1 result  --}}

                                    @if( $lesson->certificate_order == 7 )
                                          <td colspan="3">متوسط درجات السلوك</td>

                                    @elseif( $lesson->certificate_order == 8 )
                                        <td rowspan="1" style="font-size:11px">الفصل الأول</td>
                                        <td rowspan="1"  style="font-size:11px">الفصل الثاني</td>
                                        <td rowspan="1"  style="font-size:11px"> المجموع  &#247; ۲</td>

                                    @elseif( $lesson->certificate_order == 9 )
                                        <td rowspan="1" style="font-size:11px"> </td>
                                        <td rowspan="1"  style="font-size:11px"> </td>
                                        <td rowspan="1"  style="font-size:11px"></td>

                                    @elseif( $lesson->certificate_order == 10 )
                                        <td rowspan="10" colspan="3" style="font-size:9px">
                                         <div class="row" style="position: relative;height:150px;">
                                        <br>
                                        <div style="">
                                          النتيجة النهائية
                                        </div>
                                        <div class="row" style="">
                                            <div class="col-1">
                                              <div class="square"></div>
                                            </div>
                                            <div class="col-10  text-right">رشح لامتحان الشهادة الثانوية العامة</div>

                                        </div>
                                        <div class="row" style="">
                                            <div class="col-1">
                                              <div class="square"></div>
                                            </div>
                                            <div class="col-10 text-right pl-0">لم يرشح لامتحان الشهادة الثانوية العامة</div>

                                        </div>

                                        <div class="row" style="align-self:end">
                                            <div class="col-5">
                                              اسم المدير <br>
                                            <span> {{ isset($report_card_details) ? $report_card_details->manager_name : ''}}</span>
                                            </div>


                                            <div class="col-3 text-center">التوقيع </div>
                                            <div class="col-4 text-left">الختم</div>
                                        </div>

                                      </div>
                                        </td>
                                    @endif





                                </tr>
                                </form>


                        @endif
                        @endif
                        @endif
                    @endforeach

            @endforeach
          <form>
            <tr>
              <td class="main-p"  style="border-top:2px solid #000">المجموع العام </td>
              <td class="max_mark_total1 max_mark2"  style="border-top:2px solid #000"> {{  arabic_w2e(2900) }}</td>
              <td colspan="1"  class="{{ $student_rigistration_term == 1 ? 'work_degree1_total work_degree11' : '' }}"   style="border-top:2px solid #000"></td>
              <td  colspan="2" class="{{ $student_rigistration_term == 1 ? 'x' : '' }}" data-id=""  style="border-top:2px solid #000" ></td>
              <td colspan="1" class="{{ $student_rigistration_term == 1 ? 'exam1_total exam11' : '' }}"  style="border-top:2px solid #000"> </td>
              <td   class="{{ $student_rigistration_term == 1 ? 'x' : '' }}" data-id="" style=""> </td>

              <td class="{{ $current_term == 2 ? 'work_degree2_total work_degree22' :  '' }}" > </td>
              <td class="{{ $current_term == 2 ? 'x' : '' }}" data-id=""> </td>

              <td class="space-separator"  style="
                                                  border-left: 2px solid #000;
                                                  border-right: 2px solid #000;
                                                  width:5%;background:#fff">

              </td>
              <td  class="{{ $current_term == 2 ? ' total_result1_total total_result1_total1 ' : '' }}" style=" " ></td>
              <td class="{{ $current_term == 2 ? 'final_result1_total final_result1_total1 ' : '' }}"></td>
              <td class="x" data-id=""></td>



            </tr>
          </form>




           <!--subjects after first total-->
           @php
                $counter = 0;
           @endphp


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
                     @if($lesson->certificate_order !=0)
                        @php
                            if ( $lesson->religion != null)
                                $lesson_name =  'التربية الدينية' ;

                            else
                            $lesson_name = $lesson->name ;
                            $term1_work_degree = 0 ;
                            $term1_exam = 0 ;
                            $term2_work_degree = 0 ;
                            $total_result = 0;
                            $result = 0;


               $term2_result = 0 ;


                            $before_first_total_subjects = [] ;
                        @endphp
                        @if (++$i === $lesson_count)
                            @if (  $lesson->first_total == 0)
                            @php
                            @endphp

                                <form>
                                <tr>

                                    <td class="special-subject">    {{ $lesson_name }} </td>
                                    <td class="max_mark2" data-max_mark="{{$lesson->max_mark}}" > {{  arabic_w2e($lesson->max_mark) }} </td>

                                    @if($student_rigistration_term == 1)
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
                                    @endif
                                     <td class="work_degree11" data-work_degree="{{ $term1_work_degree }}">
                                           @if( $student_rigistration_term == 1)
                                                {{ arabic_w2e($term1_work_degree)  }}
                                           @endif
                                     </td>
                                    <td colspan="2" class="{{ $student_rigistration_term == 1 ? 'x' : '' }}"  data-id="{{ $term1_work_degree }}" > </td>
                                     @if(  $student_rigistration_term == 1)
                                            @if(json_decode($student_marks->mark) !== null )
                                            @foreach(json_decode($student_marks->mark) as $key1 => $item1 )
                                                @if($key1 == $lesson->id )

                                                  @php
                                                    $term1_exam = $item1->exam  == 'null' ? '' : $item1->exam  ;
                                                    $total_result += $term1_exam ;
                                                  @endphp
                                                @endif
                                            @endforeach
                                            @endif

                                        @endif
                                      <td class="exam11" data-exam="{{ $term1_exam }}">
                                            @if( $student_rigistration_term == 1)
                                                {{ arabic_w2e($term1_exam)  }}
                                            @endif
                                      </td>
                                    <td colspan="1" class="{{ $student_rigistration_term == 1 ? 'x' : '' }}"  data-id="{{ $term1_exam }}" > </td>

                                      @if(json_decode($student_marks->worke_degree) !== null &&  $current_term == 2)
                                      @foreach(json_decode($student_marks->worke_degree) as $key1 => $item1 )
                                          @if($key1 == $lesson->id )

                                            @php
                                                $term2_work_degree = $item1->term2_result  == 'null' ? 0 : $item1->term2_result  ;
                                                $total_result += $term2_work_degree ;

                                            @endphp
                                          @endif
                                      @endforeach
                                      @endif
                                    <td class="work_degree22" data-work_degree = "{{ $term2_work_degree }}" >
                                         @if( $current_term == 2)
                                                {{ arabic_w2e($term2_work_degree)  }}
                                        @endif
                                    </td>
                                    <td colspan="1" class="{{ $current_term == 2 ? 'x' : '' }}"  data-id="{{ $term2_work_degree }}" > </td>

                                     <td class="space-separator"  style="
                                             border-left: 2px solid #000;
                                             border-right: 2px solid #000;
                                             width:5%;background:#fff"></td>
                                    <td colspan="3"></td>
                                    <!--<td class="{{  $current_term == 2 ? 'total_result1_total1' : ''}}"  data-total_result="{{$current_term == 2 ? $total_result : ''  }}"-->
                                    <!-- {{  arabic_w2e($current_term == 2 ? $total_result : '') }} </td>-->
                                    <!--<td class="{{  $current_term == 2 ? 'final_result1_total1' :  ''}}"  data-final_result="{{ $current_term == 2 ? ceil($total_result/3)  : ''  }}"-->
                                    <!-- {{  arabic_w2e($current_term == 2 ? ceil($total_result/3) : '' ) }} </td>-->
                                    <!--<td colspan="1" class="{{  $current_term == 2 ? 'x' : '' }}" data-id="{{ ceil($total_result/3) }}" data-min_mark="{{  $lesson->min_mark }}"> </td>-->
                                    {{-- end term1 result  --}}



                        @endif
                        @endif
                         @endif
                    @endforeach

            @endforeach



            <form>
              <tr >
                <td class="main-p" style="border-bottom:2px solid #000"> المجموع النهائي </td>
                <td class="max_mark_total2" style="border-bottom:2px solid #000" >  {{  arabic_w2e( 3100 ) }}</td>
                <td   class="{{ $student_rigistration_term == 1 ? 'work_degree11_total ' : '' }}" style="border-bottom:2px solid #000" > </td>
                <td colspan="2" class="{{ $student_rigistration_term == 1 ? 'x' : '' }}" style="border-bottom:2px solid #000"> </td>
                <td colspan="1" class="{{ $student_rigistration_term == 1 ? 'exam11_total' : '' }}" style="border-bottom:2px solid #000"></td>
                <td colspan="1" class="{{ $student_rigistration_term == 1 ? 'x' : '' }}" style="border-bottom:2px solid #000"> </td>
                <td colspan="" class="{{ $current_term == 2 ? 'work_degree22_total' : '' }}" style="border-bottom:2px solid #000"></td>
                <td colspan="1" class="{{ $current_term == 2 ? 'x' : '' }}" style="border-bottom:2px solid #000"> </td>

                <td rowspan="7" class="space-separator"  style="
                    width:5%;background:#fff"></td>

                <td rowspan="1" style="font-size:11px">  المعدل النهائي</td>
                <td   rowspan="1" class=" {{ $current_term == 2 ? 'final_result11_total' : '' }}"></td>
                <td rowspan="1" class="x" data-id=""></td>




             </tr>


            </form>



            <tr>
              <td rowspan="2"   style="border-top:2px solid #000">الدوام </td>
              <td rowspan="2" colspan="1"  style="border-top:2px solid #000"> الفعلي </td>
              <td rowspan="2" colspan="1"  style="border-top:2px solid #000"> دوام الطالب </td>
              <td colspan="3" style="text-align: center;border-top:2px solid #000">الغياب  </td>
              <td rowspan="2" colspan="3" class="side-border" style="text-align: center;">ملاحظات ولي الطالب وتوقيعه </td>
              <td rowspan="2" colspan="3" style="text-align: center;">   ترتيب النجاح </td>

           </tr>
           <tr>
            <td  colspan="2"> مبرر</td>
            <td colspan="1" style="border:1px">غير مبرر</td>



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

            if ($current_term == 2 ){
                $student_attendance2 =   isset($report_card) ?  json_decode($report_card->student_attendance)->{'term2'} : 0 ;
                $actual_attendance2 =    isset($report_card_details->actual_attendance) ?  json_decode($report_card_details->actual_attendance)->{'term2'} : 0;
                $justified_absence2 =    isset($report_card) ?  json_decode($report_card->justified_absence)->{'term2'} : 0;
                $unjustified_absence2 =  isset($report_card) ? json_decode($report_card->unjustified_absence)->{'term2'} : 0;
            }
            else {
                $student_attendance2 =   0;
                $actual_attendance2 =    0;
                $justified_absence2 =    0;
                $unjustified_absence2 =  0;
            }


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

          <td colspan="1">{{$student_rigistration_term == 1 ?  arabic_w2e($actual_attendance1): ''}}</td>
          <td colspan="1">{{ $student_rigistration_term == 1 ? arabic_w2e($student_attendance1)  : ''}}</td>
          <td colspan="1">{{ $student_rigistration_term == 1 ? arabic_w2e($justified_absence1)  : ''}}</td>
          <td></td>
          <td colspan="1"> {{ $student_rigistration_term == 1 ? arabic_w2e($unjustified_absence1)  : ''}}</td>





         </td>
         <td colspan="3" rowspan="4" style=""></td>
         <td colspan="3" rowspan="4" style=""></td>
     </tr>
     <tr>
          <td> الفصل الثاني </td>
          <td colspan="1">{{$current_term == 2 ?  arabic_w2e($actual_attendance2): ''}}</td>
          <td colspan="1">{{$current_term == 2 ?  arabic_w2e($student_attendance2): ''}}</td>
          <td> {{$current_term == 2 ?  arabic_w2e($justified_absence2): ''}} </td>
          <td colspan="1"></td>
          <td colspan="1"> {{$current_term == 2 ?  arabic_w2e($unjustified_absence2): ''}}</td>





         </tr>
         <tr>
          <td> المجموع  </td>
          <td colspan="1">
           {{ arabic_w2e( $total_actual_attendance  )}}
          </td>
          <td colspan="1">
           {{ arabic_w2e( $total_student_attendance )}}
          </td>

          <td >
            {{ arabic_w2e( $total_justified_absence )}}
          </td>
          <td></td>
          <td>
           {{  arabic_w2e( ceil($total_unjustified_absence) )}}
          </td>

         </tr>
         <tr>
          <td> النسبة المئوية </td>
          <td colspan="1">
           {{  arabic_w2e(ceil($attendance_percent)).'%'}}
          </td>
          <td colspan="2">
          </td>


          <td colspan="2" class="space-separator"  style="
                                              border-left: 2px solid #000;
                                              border-right: 2px solid #000;
                                              width:5%;background:#fff"
            ></td>

         </tr>

         <tr class="top-bottom-border">
          <td colspan="9">

           <div class="row  text-right">
               <span class="col-2 paragraph-os2">   اسم الموجه وتوقيعه:  </span>
               <span class="col-2 paragraph-os2">  {{ isset($report_card_details) ? $report_card_details->instructor_name : ''}} </span>
               <span class="col-1 paragraph-os2">  </span>
               <span class="col-1 paragraph-os2">  </span>
               <span class="col-2 paragraph-os2">   توقيع المدير:  </span>

                @php
                    $report_card_date =  isset($report_card_details) ? json_decode($report_card_details->report_card_date)->{'term1'} : '' ;
                    $formatted_date = empty($report_card_date) ? '' : arabic_w2e(Carbon\Carbon::parse($report_card_date)->format('Y/m/d'))  ;
                @endphp
               <span class="col-4 paragraph-os2 text-left">  في {{ $formatted_date }}   </span>
           </div>
          </td>
          <td class="space-separator"   style="
          border-bottom: 2px solid white !important;
          width:5%;background:#fff"></td>
          <td colspan="6" style="border-left:#fff;padding-bottom:7px">
           <div class="row justify-content-start" style="text-align: right;margin-right:-11px">
            <div class="col-6">
                <span class=" paragraph-os2">توقيع الموجه  :  {{ isset($report_card_details) ? $report_card_details->instructor_name : ''}}</span>
            </div>
            <div class="col-6" style="text-align: right;">
                @php
                $report_card_date =  isset($report_card_details) ? json_decode($report_card_details->report_card_date)->{'term2'} : '' ;
                $formatted_date = empty($report_card_date) ? '' : arabic_w2e(Carbon\Carbon::parse($report_card_date)->format('Y/m/d'))  ;
                @endphp
                <span class=" paragraph-os2"> التاريخ  :  {{$current_term == 2 ? $formatted_date : '' }}</span>
            </div>

           </div>
          </td>

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

            <!--style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;-->
            <!--background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> حفظ-->
            <!--</button>-->
        </div>


		</div><!-- end container-->


	</form>





    <script>
      $(document).on('click', '.pdf_download', function () {
        $('.pdf_download').hide() ;
        $('.hide').hide() ;
        window.print();
        setInterval(function() {$('.pdf_download').show() ;}, 9000);
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



              let result = 0 ;
               $.each($('.work_degree1'), function (key, value) {
                  result1 = $( this).data('work_degree') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })
                $('.work_degree1_total').attr('data-work_degree', result);
                $('.work_degree1_total').next('td.x').data('id',`${result}`);
                $('.work_degree1_total').html((result).toLocaleString('ar-EG'));
               let result11 = 0 ;
               $.each($('.work_degree11'), function (key, value) {
                  result1 = $( this).data('work_degree') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result11 +=     result1 ;
                })
                $('.work_degree11_total').next('td.x').data('id',`${result11}`);
                $('.work_degree11_total').html( (result11).toLocaleString('ar-EG'))

               result = 0 ;
               $.each($('.exam1'), function (key, value) {
                  result1 = $( this).data('exam') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })
                $('.exam1_total').attr('data-exam', result);
                $('.exam1_total').next('td.x').data('id',`${result}`);
                $('.exam1_total').html( (result).toLocaleString('ar-EG'));
                result = 0 ;
               $.each($('.work_degree2'), function (key, value) {
                  result1 =  $( this).data('work_degree') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })
                $('.work_degree2_total').attr('data-work_degree', result);
                $('.work_degree2_total').next('td.x').data('id',`${result}`);
                $('.work_degree2_total').html((result).toLocaleString('ar-EG'))
                result = 0 ;
               $.each($('.total_result'), function (key, value) {
                  result1 =  $( this).data('total_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })
                $('.total_result1_total').attr('data-total_result', result);
                $('.total_result1_total').next('td.x').data('id',`${result}`);
                $('.total_result1_total').html((result).toLocaleString('ar-EG'))
                result = 0 ;
               $.each($('.final_result'), function (key, value) {
                  result1 =  $( this).data('final_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })
                $('.final_result1_total').attr('data-final_result', result);
                $('.final_result1_total').next('td.x').data('id',`${result}`);
                $('.final_result1_total').html((result).toLocaleString('ar-EG'));


                // final result
                result = 0;
                  $.each($('.work_degree11'), function (key, value) {
                  result1 = $( this).data('work_degree') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })
                $('.work_degree11_total').next('td.x').data('id',`${result}`);
                $('.work_degree11_total').html((result).toLocaleString('ar-EG'));

               result = 0 ;
               $.each($('.exam11'), function (key, value) {
                  result1 = $( this).data('exam') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })

                $('.exam11_total').next('td.x').data('id',`${result}`);
                $('.exam11_total').html( (result).toLocaleString('ar-EG'));

                result = 0 ;
               $.each($('.work_degree22'), function (key, value) {
                  result1 =  $( this).data('work_degree') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })
                $('.work_degree22_total').next('td.x').data('id',`${result}`);
                $('.work_degree22_total').html((result).toLocaleString('ar-EG'))

                result = 0 ;
               $.each($('.total_result1_total1'), function (key, value) {
                  result1 =  $( this).data('total_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })
                $('.total_result11_total').next('td.x').data('id',`${result}`);
                $('.total_result11_total').html((result).toLocaleString('ar-EG'))
                result = 0 ;
               $.each($('.final_result1_total1'), function (key, value) {
                  result1 =  $( this).data('final_result') ;
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  result +=     result1 ;
                })
                $('.final_result11_total').next('td.x').data('id',`${result}`);
                $('.final_result11_total').html((result).toLocaleString('ar-EG'));


                max_mark = 0 ;
                $.each($('.max_mark'), function (key, value) {
                  result1 = $( this).data('max_mark');
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1);
                  max_mark +=     result1 ;
                })
                  $('.max_mark_total1').attr('data-max_mark', max_mark);
                  $('.max_mark_total1').html( (max_mark).toLocaleString('ar-EG'));
                max_mark = 0 ;
                $.each($('.max_mark2'), function (key, value) {
                  result1 = $( this).data('max_mark');
                  result1 = result1.length == 0 ? 0 : result1;
                  result1 = parseInt(result1) ;
                  max_mark +=     result1 ;
                })
                  $('.max_mark_total2').html(max_mark);
                  $('.max_mark_total2').html( (max_mark).toLocaleString('ar-EG'));


               let total_result = 0 ;
            //   $.each($('.total_result'), function (key, value) {
            //       result1 = $( this).data('total_result') ;
            //       result1 = result1.length == 0 ? 0 : result1;
            //       result1 = parseInt(result1) ;
            //       total_result +=     result1 ;
            //     })
                $('.total_result1').attr('data-total_result', total_result);
                $('.total_result1').html((total_result).toLocaleString('ar-EG'))
               let final_result = 0 ;
            //   $.each($('.final_result'), function (key, value) {
            //       result1 = $( this).data('final_result') ;
            //       result1 = result1.length == 0 ? 0 : result1;
            //       result1 = parseInt(result1) ;
            //       final_result +=     result1 ;
            //     })
                $('.final_result1').attr('data-final_result', final_result);
                $('.final_result1').html((final_result).toLocaleString('ar-EG'))
                $('.final_result1').next('td.x').data('id',`${final_result}`);
               let total_result2 = 0 ;
            //   $.each($('.total_result2'), function (key, value) {
            //       result1 = $( this).data('total_result') ;
            //       result1 = result1.length == 0 ? 0 : result1;
            //       result1 = parseInt(result1) ;
            //       total_result2 +=     result1 ;
            //     })
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


