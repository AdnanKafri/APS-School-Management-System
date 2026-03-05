@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/showcontent_style.css') }}">
     <style>

 table {
    border: 1px solid #ccc ;
    border-collapse: collapse !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    margin-top:10px !important;
  }

  table caption {
    font-size: 1.5em !important;
    margin: .25em 0 .75em !important;
  }

  table tr {
    background: #f8f8f8 !important;
    border: 1px solid #ddd ;
    padding: .35em !important;
  }

  table th, table td {
    padding: .625em !important;
    text-align: center !important;
  }

  table th {
    font-size: 20px !important;

  }

  table td img { text-align: center; }
  @media screen and (max-width: 900px) {

  table { border: none !important; }


  table thead { display: none !important; }

  table tr {
    /*border-bottom: 3px solid #ddd!important ;*/
    border-bottom: none !important;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    display: block!important;
    margin-bottom: .625em !important;
  }

  table td {
    padding: 10px !important;
    border-top: 1px solid #ddd !important;
    border-bottom: none !important;
    display: block !important;
    font-size: .8em !important;
    text-align: left !important;
  }

  table td:before {
    content: attr(data-label) !important;
    float: right !important;
    font-weight: bold !important;

  }

  table td:last-child {
  border-bottom: 1px solid #ddd !important;
  border-right: 1px solid #ddd;
   }


  }

      /*
 * {
   font-family: 'Work Sans', sans-serif;
 }
 html, body {
   height: 100%;
   color: #1a1b1c;
 }
 label, a {
   cursor: pointer;
   user-select: none;
   text-decoration: none;
   display: inline-block;
   color: inherit;
   transition: border 0.2s;
   border-bottom: 5px solid rgba(142, 68, 173, 0.2);
   padding: 3px 2px;
 }
 label:hover, a:hover {
   border-bottom-color: #9b59b6;
 }*/
 .layout {
   display: grid;
   height: 100%;
   width: 100%;
   overflow: hidden;
   /*grid-template-rows: 50px 1fr;
   grid-template-columns: 1fr 1fr 1fr;*/
 }
 input[type="radio"] {
   display: none;
 }
 label.nav {
   display: flex;
   align-items: center;
   justify-content: center;
   cursor: pointer;
   border-bottom: 2px solid #8e44ad;
   background: #ecf0f1;
   user-select: none;
   transition: background 0.4s, padding-left 0.2s;
  /* padding-left: 0;*/
    padding: 10px;
 }
 @media (min-width:200px) and (max-width:1000px){
  .layout{
   overflow: scroll;
   width: 100% ;
  }
 }

 input[type="radio"]:checked + .page + label.nav {
   background: #9b59b6;
   color: #ffffff;
   padding-left: 20px;
 }
 input[type="radio"]:checked + .page + label.nav span {
   padding-left: 20px;
 }
 input[type="radio"]:checked + .page + label.nav svg {
   opacity: 1;
 }
 label.nav span {
   padding-left: 0px;
   position: relative;
 }
 label.nav svg {
   left: -2px;
   top: 4px;
   position: absolute;
   width: 15px;
   opacity: 0;
   transition: opacity 0.2s;
 }
 .page {
   grid-column-start: 1;
   grid-row-start: 2;
   grid-column-end: span 6;
   padding: 0px 2px;
   display: flex;
   align-items: center;
 }
 .page-contents > * {
   opacity: 0;
   transform: translateY(20px);
   transition: opacity 0.2s, transform 0.2s;
 }
 .page-contents > *:nth-child(1) {
   transition-delay: 0.4s;
 }
 .page-contents > *:nth-child(2) {
   transition-delay: 0.6s;
 }
 .page-contents > *:nth-child(3) {
   transition-delay: 0.8s;
 }
 .page-contents > *:nth-child(4) {
   transition-delay: 1s;
 }
 .page-contents > *:nth-child(5) {
   transition-delay: 1.2s;
 }
 .page-contents > *:nth-child(6) {
   transition-delay: 1.4s;
 }
 .page-contents > *:nth-child(7) {
   transition-delay: 1.6s;
 }
 .page-contents > *:nth-child(8) {
   transition-delay: 1.8s;
 }
 .page-contents > *:nth-child(9) {
   transition-delay: 2s;
 }
 .page-contents > *:nth-child(10) {
   transition-delay: 2.2s;
 }
 .page-contents > *:nth-child(11) {
   transition-delay: 2.4s;
 }
 .page-contents > *:nth-child(12) {
   transition-delay: 2.6s;
 }
 .page-contents > *:nth-child(13) {
   transition-delay: 2.8s;
 }
 .page-contents > *:nth-child(14) {
   transition-delay: 3s;
 }
 .page-contents > *:nth-child(15) {
   transition-delay: 3.2s;
 }
 .page-contents > *:nth-child(16) {
   transition-delay: 3.4s;
 }
 .page-contents > *:nth-child(17) {
   transition-delay: 3.6s;
 }
 .page-contents > *:nth-child(18) {
   transition-delay: 3.8s;
 }
 .page-contents > *:nth-child(19) {
   transition-delay: 4s;
 }
 .page-contents > *:nth-child(20) {
   transition-delay: 4.2s;
 }
 input[type="radio"] + .page {
   transition: transform 0.2s;
   transform: translateX(100%);
 }
 input[type="radio"]:checked + .page {
   transform: translateX(0%);
 }
 input[type="radio"]:checked + .page .page-contents > * {
   opacity: 1;
   transform: translateY(0px);
 }
 .page-contents {
   max-width: 100%;
   /*width: 500px;*/
   margin: 0 auto;
   padding-top: 25px;
   padding-left: 20px;
 }

 /*css card for content*/
 .box {
   -webkit-box-shadow: 0px 12px 6px -6px rgba(41,41,41,0.25);
   -moz-box-shadow: 0px 12px 6px -6px rgba(41,41,41,0.25);
   box-shadow: 0px 12px 6px -6px rgba(41,41,41,0.25);
   /*padding: 0;*/
   padding-bottom: 8px;
   margin-bottom: 30px;
   margin-left: 10px;
   background-color: #fff;

 }

 .step1 {
   z-index: 999;
 }

 .step2 .animated {
   -webkit-animation-delay: 1s;
   animation-delay: 1s;
   position: relative;
   top: -6px;
 }

 .step3 .animated {
   -webkit-animation-delay: 2s;
   animation-delay: 2s;
   z-index: -3;
   position:relative;
   top: -12px;
 }

 .step4 .animated {
   -webkit-animation-delay: 3s;
   animation-delay: 3s;
   z-index: -5;
   position: relative;
   top: -18px;
 }

 .shape {
   width: 150px;
   height: 120px;
   -webkit-transform: skew(20deg);
   -moz-transform: skew(20deg);
   -o-transform: skew(20deg);
   -webkit-box-shadow: 0px 12px 30px -6px rgba(41,41,41,0.25);
   -moz-box-shadow: 0px 12px 30px -6px rgba(41,41,41,0.25);
   box-shadow: 0px 12px 30px -6px rgba(41,41,41,0.25);
   top: 10px;
   left: 8px;
   text-align: center;
 }

 .shape-1 .shape{
   background: #e74c3c;
 }

 .shape-1 .material-icons {
   color: #e74c3c;
 }

 .shape-2 .shape{
   background: #34495e;
 }

 .shape-2 .material-icons {
   color: #34495e;
 }

 .shape-3 .shape {
   background: #f39c12;
 }

 .shape-3 .material-icons {
   color: #f39c12;
 }

 .shape-4 .shape {
   background: #3498db;
 }

 .shape-4 .material-icons {
   color: #3498db;
 }

 .number {
   -webkit-transform: skew(-20deg);
   -moz-transform: skew(-20deg);
   -o-transform: skew(-20deg);
 }
 .newh1 {
   color: #fff;
   font-weight: 700;
   letter-spacing: 2px;
   padding-top: 15px;
   transform:scale(2,3);
   -webkit-transform:scale(2,3);
   -moz-transform:scale(2,3);
   -ms-transform:scale(2,3);
   -o-transform:scale(2,3);
 }

 .box p {
     font-weight: 900;
     padding-top: 25px;
     text-align: center;
     font-size: 22px;
 }

 /* Not required */


 h2 {
   margin: 40px 0;
   text-align: center;
   text-transform: uppercase;
   letter-spacing: 3px;
 }

 .md-56 {
   font-size: 56px;
   padding-top: 30px;
 }
 /*css for table*/
 div.table-title {
   display: block;
   margin: auto;
   max-width: 600px;
   padding:5px;
   width: 100%;
   direction: rtl !important;
 }

 .table-title h3 {
    color: #fafafa;
    font-size: 30px;
    font-weight: 400;
    font-style:normal;
    font-family: "Roboto", helvetica, arial, sans-serif;
    text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
    text-transform:uppercase;
 }


 /*** Table Styles **/

 /*.table-fill {
   background: white;
   border-radius:3px;
   border-collapse: collapse;
   height: 320px;*
   margin: auto;
   max-width: 895px;
   padding:5px;
   width: 100%;
   box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
   animation: float 5s infinite;
   margin-top: 120px;
   margin: 0 auto;
 }*/
 table{
   border-collapse: collapse;
   border-spacing: 0;
    width: 100%;
    margin: 0 auto;
    direction: rtl;
 }

 @media (min-width:200px) and (max-width:900px){
   table{
     width: 100% !important;
   }
 }
 th {
   color:#FFFFFF;;
   background:#173D64 !important;
   border-bottom:4px solid #9ea7af;
   border-right: 2px solid #C1C3D1;
   border-left: 2px solid #C1C3D1;
   font-size:23px;
   font-weight: 100;
   padding:11px;
   text-align:center;
   text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
   vertical-align:middle;
   width: 678px;
 }

 th:first-child {
   border-top-left-radius:1px;
 }

 th:last-child {
   border-top-right-radius:1px;
   border-right:none;
 }

 tr {
   border-top: 1px solid #C1C3D1;
   border-bottom-: 1px solid #C1C3D1;
   border-right: 1px solid #C1C3D1;
   border-left: 1px solid #C1C3D1;
   color:#666B85;
   font-size:16px;
   font-weight:normal;
   text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
 }

 tr:hover td {
   /*background:#9ea7af;*/
   color:#9ea7af;
   border-top: 1px solid #9ea7af;
 }

 tr:first-child {
   border-top:none;
 }

 tr:last-child {
   border-bottom:none;
 }

 tr:nth-child(odd) td {
   /*background:#EBEBEB;*/
 }

 tr:nth-child(odd):hover td {
   /*background:#9ea7af;*/
 }

 tr:last-child td:first-child {
   border-bottom-left-radius:3px;
 }

 tr:last-child td:last-child {
   border-bottom-right-radius:1px;
 }

 td {
   background:#FFFFFF;
   padding: 4px;
   text-align: center;
   vertical-align:middle;
   font-weight:300;
   font-size:18px;
   text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
   border-right: 1px solid #C1C3D1;
   border-left: 1px solid #C1C3D1;
   border-bottom:1px solid #9ea7af;
 }

 td:last-child {
   border-right: 0px;
 }

 th.text-left {
   text-align: left;
 }

 th.text-center {
   text-align: center;
 }

 th.text-right {
   text-align: right;
 }

 td.text-left {
   text-align: left;
 }

 td.text-center {
   text-align: center;
 }

 td.text-right {
   text-align: right;
 }
 /*end css for table*/
 
    
 @media (min-width:200px) and (max-width:500px){
     .new{
      position: relative;
      left: 15px;
     }
     .newcol{
      position: relative;
      margin-bottom: 10px;
     }
 }
 @media (min-width:501px) and (max-width:1000px){
  .newcol{
      position: relative;
      margin-bottom: 10px;
      left: 18px;
     }
 }
 .uuu1{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}

.uuu3{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}

.uuu2{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}

.uuu6{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}
.uuu5{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}
.uuu1 > p{
   font-weight: bold;
   font-size: large;

}

.uuu3 > p{
   font-weight: bold;
   font-size: large;

}

.uuu2 > p{
   font-weight: bold;
   font-size: large;

}   

.uuu6 > p{
   font-weight: bold;
   font-size: large;

}
.uuu5 > p{
   font-weight: bold;
   font-size: large;

}
.btn{
  padding-top: 10px !important;
  padding-bottom: 10px !important;
  margin-bottom: 5px;
 }
 .btn-info{
    padding-left: 19px !important;
    padding-right: 19px !important;

}

.btn-primary{
    padding-left: 19px !important;
    padding-right: 19px !important;

}

.btn-success{
    padding-left: 19px !important;
    padding-right: 19px !important;

}

.btn-danger{
    padding-left: 19px !important;
    padding-right: 19px !important;

}

th{
    font-size: 26px !important;
}
	 </style>

@endsection

@section('content')
<div class="main-panel" style="background: #f8f9fb;">
  <ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="#">جدول الدوام</a></li>

   </ul>
    <div class="content-wrapper pb-0">
      <!--content -->
        <!--card of subjects-->
       <!-- start new-->
       @if (session()->has('success'))

       <script>
           window.onload = function() {
               notif({
                   msg: "  تم التخزين بنجاح  ",
                   type: "success"
               })
           }

       </script>
   @endif
       @if (session()->has('otherday'))

       <script>
           window.onload = function() {
               notif({
                   msg: " {{ session()->get('otherday') }} ",
                   type: "warning"
               })
           }

       </script>
   @endif
       @if (session()->has('othertime'))

       <script>
           window.onload = function() {
               notif({
                   msg: " {{ session()->get('othertime') }} ",
                   type: "warning"
               })
           }

       </script>
   @endif
   @if ($errors->any())

           @foreach ($errors->all() as $error)
           {{-- <li>{{ $error }}</li> --}}
           <script>
               window.onload = function() {
                   notif({
                       msg: `{{  $error }}`  ,
                       type: "error"
                   })
               }

           </script>
           @endforeach

   @endif
   {{-- <div class="col-md-12" style="text-align:end">
    <button class="btn3 print" style="width: 140px;
    padding-top: 10px;
    padding-bottom: 10px;">طباعة </button>
  </div> --}}

<div class="row">
  <h1 class="title text-center w-100" style="text-align: center;padding-bottom: 50px;padding-top: 30px;">
    برنامج الدوام
  </h1>

  <div class="container new">
    <div class="row w-100" style="margin-right: 1px; margin-bottom: 15px">

      <div class="col-sm-2 mx-2 btn btn-primary p-1 text-light newcol">
        اللون الافتراضي
      </div>

      <div class="col-sm-2 mx-2 btn btn-info p-1 text-light newcol">اليوم الحالي</div>

      <div class="col-sm-2 mx-2 btn btn-success p-1 text-light  newcol">يمكن الدخول للدرس</div>

      <div class="col-sm-2 mx-2 btn btn-danger p-1 text-light newcol">تم حضورالدرس</div>

      <div class="col-sm-3 mx-2 btn btn-warning p-1 text-light newcol ">
        الدرس لا يحوي رابط
      </div>

    </div>
  </div>


  <div class="container" style="padding-bottom: 50px;">
    <div class="row">
      <div class="col-md-12">
       <div >
  <table class="table-fill"  id="dvContainer" >
      <thead>
        <tr>
          <th scope="col" style="border: 2px solid;">اليوم </th>
          @foreach ($lecture_times as $key => $value)

              <th style="border: 2px solid;" scope="col"> {{ $value['name'] }} <br>
                <span style="font-size: 9px"> {{ $value['start_time']->format('H:i')  }} - {{ $value['end_time']->format('H:i')  }} </span>
              </th>
          @endforeach


          {{-- <th scope="col"> محتوى الدرس</th> --}}
        </tr>
      </thead>
      <tbody>
          <?php
           $i = 1;
          ?>
          @foreach ($schedule as $key => $schedule_day)
              @php
                   $week = [
                              0 => 'السبت',
                              1 => 'الأحد',
                              2 => 'الاثنين',
                              3 => 'الثلاثاء',
                              4 => 'الأربعاء',
                              5 => 'الخميس',
                              6 => 'الجمعة',
                          ] ;

                  $day_name = $week[$key] ;
              @endphp
              <tr>
                  <th style="border: 2px solid;" scope="row">{{ $week[$key] }}</th>
                  @foreach ($lecture_times as $key => $lecture_time)

                      @php
                      $lesson_name2 =  '' ;
                      $title =  ' حصة اسبوعية' ;
                      $google_meeting_link =  '' ;
                      $teacher_name2 =    '';
                      $background =    'btn-primary';
                      $passToStream  = true ;
                      $go_to_google = false ;
                      if ( $lecture_time->type == 2){
                          $background = 'btn-primary2';
                          $lesson_name2 = '';
                          $passToStream  = false ;
                      }


                      @endphp



                      @foreach ($schedule_day as $key2 => $lesson_time)


                          @if(  $lecture_time->id == $lesson_time->lecture_time_id)
                              @php
                                  $lesson_name2 =    $lesson_time->lesson->name ;
                                  $x =$lesson_time->teacher->first_name ;
                                  $y =$lesson_time->teacher->last_name ;
                                  $teacher_name2 =  "($x    $y)"  ;
                                  $meeting_link = $lesson_time->meeting_link ;
                                  $lesson_time_id = $lesson_time->id ;

                                  if( isset($lesson_time->attendance) && $lesson_time->attendance == false  &&  $lesson_time->inter == false)
                                      $background = 'btn-info';
                                  else if(isset($lesson_time->attendance) && $lesson_time->attendance == false &&  $lesson_time->inter == true && isset($lesson_time->meeting_link )){
                                      $background = 'btn-success';
                                      $title = ' الدخول للحصة';
                                      $google_meeting_link = $lesson_time->meeting_link ;
                                      $go_to_google = true;

                                  }
                                  else if(isset($lesson_time->attendance) && $lesson_time->meeting_link == null){
                                      $background = 'btn-warning';
                                      $title = 'لا يوجد درس مجدول';
                                  }
                                  else if(isset($lesson_time->attendance) && $lesson_time->attendance == true  ){
                                      $background = 'btn-danger';
                                      $go_to_google = true ;
                                      $lesson_time_id = $lesson_time->id ;
                                  }
                                  else
                                      $background = 'btn-primary';

                              @endphp


                          @endif



                      @endforeach

                      <td style="border: 2px solid;" data-label="{{ $lecture_time['name'] }} ">
                          {{-- <a class=" aaa btn  @if( $lecture_time->type == 1 ) btn-info @else btn-dark @endif btn-sm add_time a-schedule{{  $day->id .''. $lecture_time->id }}"></a> --}}
                          <a target="_blank" class=" aaa btn
                                  {{ $background }}
                              btn-sm add_time "
                              @if( $passToStream && $room_id != "" &&  $go_to_google)
                              href="{{ route('dashboard.students.room.go_to_stream',['scheduler_id' => $lesson_time_id,'day_id' => $lesson_time->day_id,'lecture_time_id' =>$lecture_time->id ,'room_id' => $room_id,'student_id' => $student->id]) }}"
                              @endif
                              title="{{ $title }}">

                              <p  style="margin:0;font-weight:bold"> {{ $lesson_name2 }}</p>
                              <p  style="margin:0;font-size:10px"> {{ $teacher_name2 }} </p>

                          </a>

                      </td>
                  @endforeach

              </tr>


          @endforeach

  </tbody>
</table>
</div>

</div>

</div>
  </div>


</div>
</div>
<input type="text" hidden id="name_share" value="{{ $student->first_name }} {{ $student->last_name }} ">
<!-- end new-->
<!-- page-body-wrapper ends -->


	@endsection
    @section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PrintArea/2.4.1/jquery.PrintArea.js"
    integrity="sha512-GhQdBWSddrd8ijiuwA0LZ7ppPcPrJOZAtGMOmgO/371vPNUNm/mKdNc13T/2UWLp5vLIcaDvh/9NwCRZAdxgFw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>


        $(document).ready(function(){
            $('.sh11').addClass('active') ;
            $('.print').on('click',function(e){
            $('.btn-info').removeClass('btn-info').addClass('uuu1');
            $('.btn-success').removeClass('btn-success').addClass('uuu2');
            $('.btn-primary').removeClass('btn-primary').addClass('uuu3');
            $('.btn-primary2').removeClass('btn-primary2').addClass('uuu4');
            $('.btn-danger').removeClass('btn-danger').addClass('uuu6');
             $('.btn-warning').removeClass('btn-warning').addClass('uuu5');

            html2canvas(document.querySelector("#dvContainer")).then(canvas => {
            a = document.createElement('a');
            document.body.appendChild(a);
            a.download = "برنامج الدوام.png";
            a.href =  canvas.toDataURL();
            a.click();

            $('.uuu1').removeClass('uuu1').addClass('btn-info');
            $('.uuu2').removeClass('uuu2').addClass('btn-success');
            $('.uuu3').removeClass('uuu3').addClass('btn-primary');
            $('.uuu4').removeClass('uuu4').addClass('btn-primary2');
            $('.uuu6').removeClass('uuu6').addClass('btn-danger');
            $('.uuu5').removeClass('uuu5').addClass('btn-warning');
        });
      })



        });
    </script>
    @endsection
