@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
     <style>

.card {
    background-color: #fff;
    border-radius: 10px;
    border: none;
	top: 50px;
	margin: 0 auto;
	text-align: center;
	width: 300px;
	min-height: 120px;

    /*position: relative;*/

    margin-bottom: 30px;
    box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
}
.l-bg-cherry {
    background: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196)) !important;
    color: #fff;

}

.l-bg-blue-dark {
	background: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196)) !important;
    color: #fff;
	text-align: center;
}

.l-bg-green-dark {
    background: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196)) !important;
    color: #fff;
	text-align: center;
}

.l-bg-orange-dark {
    background: linear-gradient(to right, #a86008, #ffba56) !important;
    color: #fff;
}

.card .card-statistic-3 .card-icon-large .fas, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal {
    font-size: 80px;

}

.card .card-statistic-3 .card-icon {

    line-height: 50px;
    margin-right: 195px;
    color: #000;
    position: absolute;
    right: -5px;
    top: 20px;
    opacity: 0.1;
	color: white;

}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
	text-align: center;
}

.l-bg-green {
    background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
    color: #fff;
	text-align: center;
}

.l-bg-orange {
    background: linear-gradient(to right, #f9900e, #ffba56) !important;
    color: #fff;
	text-align: center;
}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
	text-align: center;
}
/*style tablist*/
/* section add content */
@import "bourbon";
 @import 'https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,400';

 .tabs {
	 left: 50%;
	 transform: translateX(-50%);
	 position: relative;
	 background: white;
	 padding: 20px;
	 padding-bottom: 80px;
	 width: 90%;
	 height: auto;
	 box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
	 border-radius: 5px;
	 min-width: 240px;
}
 .tabs input[name="tab-control"] {
	 display: none;
}
 .tabs .content section h2, .tabs ul li label {
	 font-family: "Montserrat";
	 font-weight: bold;
	 font-size: 18px;
	 color: #094e89;
}
 .tabs ul {
	list-style-type: none;
	 padding-left: 0;

	 flex-direction: row;
	 margin-bottom: 10px;
   display: flex;
  justify-content: center;
	 /*justify-content: space-between;*/
	 align-items: center;
	 flex-wrap: wrap;

}
 .tabs ul li {
	 box-sizing: border-box;
	 /*flex: 1;
	 width: 25%;
	 padding: 0 10px;*/
	 text-align: center;
}
 .tabs ul li label {
	 transition: all 0.3s ease-in-out;
	 color: #929daf;
	 padding: 5px auto;
	 overflow: hidden;
	 text-overflow: ellipsis;
	 display: block;
	 cursor: pointer;
	 transition: all 0.2s ease-in-out;
	 white-space: nowrap;
	 -webkit-touch-callout: none;
}
 .tabs ul li label br {
	 display: none;
}
 .tabs ul li label svg {
	 fill: #929daf;
	 height: 1.2em;
	 vertical-align: bottom;
	 margin-right: 0.2em;
	 transition: all 0.2s ease-in-out;
}
 .tabs ul li label:hover, .tabs ul li label:focus, .tabs ul li label:active {
	 outline: 0;
	 color: #bec5cf;
}
 .tabs ul li label:hover svg, .tabs ul li label:focus svg, .tabs ul li label:active svg {
	 fill: #bec5cf;
}
 .tabs .slider {
	 position: relative;
	 width: 25%;
	 transition: all 0.33s cubic-bezier(0.38, 0.8, 0.32, 1.07);
}
 .tabs .slider .indicator {
	 position: relative;
	 width: 50px;
	 max-width: 100%;
	 margin: 0 auto;
	 height: 4px;
	 background: #cc151525;
	 border-radius: 1px;
}
 .tabs .content {
	 margin-top: 30px;
}
 .tabs .content section {
	 display: none;
	 animation-name: content;
	 animation-direction: normal;
	 animation-duration: 0.3s;
	 animation-timing-function: ease-in-out;
	 animation-iteration-count: 1;
	 line-height: 1.4;
}
 .tabs .content section h2 {
	 color: #1068b4;
	 display: none;
}
 .tabs .content section h2::after {
	 content: "";
	 position: relative;
	 display: block;
	 width: 30px;
	 height: 3px;
	 background: #1068b4;
	 margin-top: 5px;
	 left: 1px;
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label {
	 cursor: default;
	 color: #f38639;
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label svg {
	 fill: #f38639;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ .slider {
	 transform: translateX(0%);
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ .content > section:nth-child(1) {
	 display: block;
}
 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label {
	 cursor: default;
	 color: #f38639;
}
 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label svg {
	 fill: #f38639;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ .slider {
	 transform: translateX(100%);
}
 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ .content > section:nth-child(2) {
	 display: block;
}
 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label {
	 cursor: default;
	 color: #f38639;
}
 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label svg {
	 fill: #f38639;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ .slider {
	 transform: translateX(200%);
}
 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ .content > section:nth-child(3) {
	 display: block;
}
/*tab 4*/
.tabs input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label {
	 cursor: default;
	 color: #1068b4;
}
 .tabs input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label svg {
	 fill: #1068b4;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(4):checked ~ .slider {
	 transform: translateX(0%);
}
 .tabs input[name="tab-control"]:nth-of-type(4):checked ~ .content > section:nth-child(4) {
	 display: block;
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ .content > section:nth-child(5) {
	 display: block;
}
/*tab 5*/
.tabs input[name="tab-control"]:nth-of-type(5):checked ~ ul > li:nth-child(5) > label {
	 cursor: default;
	 color: #1068b4;
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ ul > li:nth-child(5) > label svg {
	 fill: #1068b4;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ ul > li:nth-child(5) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ .content > section:nth-child(5) {
	 display: block;
}
/*tab 6*/
.tabs input[name="tab-control"]:nth-of-type(6):checked ~ ul > li:nth-child(6) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(6):checked ~ ul > li:nth-child(6) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(6):checked ~ ul > li:nth-child(6) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(6):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(6):checked ~ .content > section:nth-child(6) {
	 display: block;
}
/*tab 7*/
.tabs input[name="tab-control"]:nth-of-type(7):checked ~ ul > li:nth-child(7) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(7):checked ~ ul > li:nth-child(7) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(7):checked ~ ul > li:nth-child(7) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(7):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(7):checked ~ .content > section:nth-child(7) {
	 display: block;
}
/*tab 8*/
.tabs input[name="tab-control"]:nth-of-type(8):checked ~ ul > li:nth-child(8) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(8):checked ~ ul > li:nth-child(8) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(8):checked ~ ul > li:nth-child(8) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(8):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(8):checked ~ .content > section:nth-child(8) {
	 display: block;
}
/*tab 9*/
.tabs input[name="tab-control"]:nth-of-type(9):checked ~ ul > li:nth-child(9) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(9):checked ~ ul > li:nth-child(9) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(9):checked ~ ul > li:nth-child(9) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(9):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(9):checked ~ .content > section:nth-child(9) {
	 display: block;
}
/*tab 10*/
.tabs input[name="tab-control"]:nth-of-type(10):checked ~ ul > li:nth-child(10) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(10):checked ~ ul > li:nth-child(10) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(10):checked ~ ul > li:nth-child(10) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(10):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(10):checked ~ .content > section:nth-child(10) {
	 display: block;
}
/*tab 11*/
.tabs input[name="tab-control"]:nth-of-type(11):checked ~ ul > li:nth-child(11) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(11):checked ~ ul > li:nth-child(11) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(11):checked ~ ul > li:nth-child(11) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(11):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(11):checked ~ .content > section:nth-child(11) {
	 display: block;
}
/*tab 12*/
.tabs input[name="tab-control"]:nth-of-type(12):checked ~ ul > li:nth-child(12) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(12):checked ~ ul > li:nth-child(12) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(12):checked ~ ul > li:nth-child(12) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(12):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(12):checked ~ .content > section:nth-child(12) {
	 display: block;
}
 @keyframes content {
	 from {
		 opacity: 0;
		 transform: translateY(5%);
	}
	 to {
		 opacity: 1;
		 transform: translateY(0%);
	}
}
 @media (max-width: 1000px) {
	 .tabs ul li label {
		 white-space: initial;
	}
	 .tabs ul li label br {
		 display: initial;
	}
	 .tabs ul li label svg {
		 height: 1.5em;
	}
}
 @media (max-width: 600px) {
	 .tabs ul li label {
		 padding: 5px;
		 border-radius: 5px;
	}
	 .tabs ul li label span {
		 display: none;
	}
	 .tabs .slider {
		 display: none;
	}
	 .tabs .content {
		 margin-top: 20px;
	}
	 .tabs .content section h2 {
		 display: block;
	}
}


/*end style tablist*/
/* cards of marks */
.cards-list {
  z-index: 0;
  width: 100%;
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
}

.card2 {
  margin: 30px auto;
  width: 170px;
  height: 170px;
  border-radius: 40px;
  border-color: 5px solid #094e89;
  /*box-shadow: 1px 1px 9px 2px rgba(0,0,0,0.22), -1px -1px 9px 2px rgba(0,0,0,0.20);*/
  cursor: pointer;
  transition: 0.4s;
}

.card2 .card_image {
 border-color: 5px solid #094e89;
  width: inherit;
  height: inherit;
  border-radius: 40px;
}

.card2 .card_image img {
  width: inherit;
  height: inherit;
  border-radius: 40px;
  object-fit: cover;
}

.card2 .card_title {
  text-align: center;
  border-radius: 0px 0px 40px 40px;
  font-family: sans-serif;
  font-weight: bold;
  font-size: 30px;
  margin-top: -20px;
  height: 40px;
}

.card2:hover {
  transform: scale(0.9, 0.9);
  box-shadow: 1px 1px 10px 2px rgba(0,0,0,0.22), -1px -1px 10px 2px rgba(0,0,0,0.20);
}

.title-white {
  color: white;
}

.title-black {
  color: black;
}

@media all and (max-width: 500px) {
  .card-list {
    /* On small screens, we are no longer using row direction but column */
    flex-direction: column;
  }
}
a{
    color:#fff !important;
    font-size: 16px !important;
}
div#ui_notifIt p{
    color:#fff ;
}
.btn-primary2{
    background : #283762 ;
}
.btn-primary3{
    background : #052d9b ;
}

	 </style>


	<section class="hero-wrap hero-wrap-2" style="background-image: url('{{  asset('teachers/ppp1.jpg') }}'); border-bottom-right-radius: 70px 50px;">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text align-items-end justify-content-center">
				<div class="col-md-12 ftco-animate pb-5 text-right">
					{{-- <p class="breadcrumbs"></p> --}}
					<h1 class="mb-0 bread">  <span> {{ $room_name  }} </span> / {{ $class_name }} </h1>
				</div>
			</div>
		</div>
	</section>
  <!-- start new-->

<div class="col-md-10 " style="margin: auto; direction: rtl; text-align:center">

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

    <br><br><br>
    <div class="row" style="width: 100%;"  >
        <h1  class="title text-center w-100 m-5" style="text-align: center"> برنامج الدوام  </h1>
        <br><br><br><br>
        <div style="overflow-x: scroll;width: 100%;">
       <table class="table table-bordered table-responsive"
        style="direction: rtl !important;text-align: center !important;display:inline-table">
            <thead>
              <tr>
                <th scope="col">اليوم </th>
                @foreach ($lecture_times as $key => $value)

                    <th scope="col"> {{ $value['name'] }} <br>
                     <span style="font-size: 10px"> {{ $value['start_time']->format('H:i')  }} - {{ $value['end_time']->format('H:i')  }} </span>
                    </th>
                @endforeach


                {{-- <th scope="col"> محتوى الدرس</th> --}}
              </tr>
            </thead>
            <tbody>
                <?php
                 $i = 1;
                ?>
                @foreach ($days as $key => $day)

                    <tr>
                        <th scope="row">{{ $day->name }}</th>
                        @foreach ($lecture_times as $key2 => $lecture_time)
                            @php

                            $lesson_name2 =  '' ;
                            $title =  ' حصة اسبوعية' ;
                            $google_meeting_link =  '' ;
                            $teacher_name2 =    '';
                            $background =    'btn-primary2';
                            $passToStream  = true ;
                            $go_to_google = false ;
                            if ( $lecture_time->type == 2){
                                $background = 'btn-primary3';
                                $lesson_name2 = '';
                                $passToStream  = false ;
                            }


                            @endphp
                            @foreach ($schedule as $key3 => $lesson_time )



                                @if( $lesson_time->day_id == $day->id && $lecture_time->id == $lesson_time->lecture_time_id)
                                @php
                                    $lesson_name2 =    $lesson_time->lesson->name ;
                                    $x =$lesson_time->teacher->first_name ;
                                    $y =$lesson_time->teacher->last_name ;
                                    $teacher_name2 =  "($x    $y)"  ;
                                    $meeting_link = $lesson_time->meeting_link ;
                                    

                                    if( $today == $day->id - 1 && $lesson_time->attendance == false  &&  $lesson_time->inter == false && $lesson_time->meeting_link != null)
                                        $background = 'btn-info';
                                        else if($today == $day->id - 1 && $lesson_time->attendance == false &&  $lesson_time->inter == true && isset($lesson_time->meeting_link )){
                                        $background = 'btn-success';
                                        $title = ' الدخول للحصة';
                                        $google_meeting_link = $lesson_time->meeting_link ;
                                        $go_to_google = true ;
                                        $lesson_time_id = $lesson_time->id ;
                                    }
                                    else if($today == $day->id - 1 && $lesson_time->meeting_link == null){
                                        $background = 'btn-warning';
                                        $title = 'لا يوجد درس مجدول';
                                    }
                                    else if($today == $day->id - 1 && $lesson_time->attendance == true && $lesson_time->inter == true){
                                        $background = 'btn-danger';
                                        $go_to_google = true ;
                                        $lesson_time_id = $lesson_time->id ;
                                        }
                                    else if($today == $day->id - 1 && $lesson_time->attendance == true )
                                        $background = 'btn-danger';
                                    else
                                        $background = 'btn-primary2';




                                @endphp
                                {{-- <input type="hidden"  name="schedule[{{ $day->id }}][{{ $lecture_time->id }}][lesson_name]" class="schedule{{ $day->id .''. $lecture_time->id }}" value=" ">
                                <input type="hidden"  name="schedule[{{ $day->id }}][{{ $lecture_time->id }}][lesson_id]" class="schedule{{ $day->id .''. $lecture_time->id }}" value=" ">
                                <input type="hidden"  name="schedule[{{ $day->id }}][{{ $lecture_time->id }}][teacher_name]" class="schedule{{ $day->id .''. $lecture_time->id }}" value="">
                                <input type="hidden"  name="schedule[{{ $day->id }}][{{ $lecture_time->id }}][teacher_id]" class="schedule{{ $day->id .''. $lecture_time->id }}" value=" "> --}}
                                @endif
                                @php

                                @endphp


                            @endforeach
                        <td >
                            {{-- <a class="btn  @if( $lecture_time->type == 1 ) btn-info @else btn-dark @endif btn-sm add_time a-schedule{{  $day->id .''. $lecture_time->id }}" --}}
                            <a class="btn
                                    {{ $background }}
                                 btn-sm add_time "
                                @if( $passToStream && $room_id != "" &&  $go_to_google)
                                href="{{ route('dashboard.students.room.go_to_stream',['scheduler_id' => $lesson_time_id,'day_id' => $day->id,'lecture_time_id' =>$lecture_time->id ,'room_id' => $room_id,'student_id' => $student->id]) }}"
                                @endif
                                title="{{ $title }}">

                                <p class="lesson_name-schedule{{  $day->id .''. $lecture_time->id }}" style="margin:0;font-weight:bold"> {{ $lesson_name2 }}</p>
                                <p class="teacher_name-schedule{{  $day->id .''. $lecture_time->id }}" style="margin:0;font-size:10px"> {{ $teacher_name2 }} </p>

                            </a>

                        </td>
                        @endforeach

                    </tr>


                @endforeach

        </tbody>
    </table>
    </div>
    <br>
    <br>

    </div>
</div>
<!-- end new-->

  <br>
  <br>
  <br>
  <br>




	@endsection
    @section('js-scripts')
    <script>
        $(document).ready(function(){

           
        //     $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
            let xx ;
            let my_room = {{ $room_id }} ;
            $('.add_time').on('click',function(){
                xx = $(this).data('xx');
                day = $(this).data('day');
                time2 = $(this).data('time');
                day_id = $(this).data('day_id');
                time_id = $(this).data('time_id');
                $(`.day`).val(day);
               $(`.time`).val(time2);
                $(`.day_id`).val(day_id);
               $(`.time_id`).val(time_id);
            });
           
            $('.save_lecture_time').on('click',function(e){
                e.preventDefault() ;
                let lesson_id = $('select.lesson_id').val();
                let teacher_id = $('select.teacher_id').val();
                let day_id = $(`.day_id`).val();
                let lecture_time_id = $(`.time_id`).val();
                $.ajax({
                    url:"{{ route('dashboard.room.save.schedule') }}",
                    type: "POST",

                    data: {
                            'lesson_id' : lesson_id,
                            'teacher_id' : teacher_id,
                            'room_id' : my_room,
                            'day_id' : day_id,
                            'lecture_time_id' : lecture_time_id,
                            '_token': "{{ csrf_token() }}"

                        },
                    success: function (response2) {
                        console.log(response2);
                        let lesson_name = $( ".wide option:selected" ).text();
                        let lesson_id = $( ".wide " ).val();
                        let teacher_name = $( ".teacher_id option:selected" ).text();
                        // let lesson_id = $( ".wide " ).val();

                        $(`.${xx}`).val(lesson_name);
                        $(`.id-${xx}`).val(lesson_id);
                        $(`.lesson_name-${xx}`).text(lesson_name);
                        $(`.teacher_name-${xx}`).text(`(${teacher_name})`);

                        $("#add_schedule").modal('hide');

                        notif({
                        msg: "تم الإضافة  بنجاح",
                        type: "success"
                    })
                    console.log('content name',response2);
                    },error: function(error){
                    console.log('insider function',error);
                    var x = JSON.parse(error.responseText);
                        $.each(x.errors, function(key,value) {
                            notif({
                                        msg: `${value}`,
                                        type: "error",
                            });
                        });
                    }
                });

            })
        });
    </script>
    @endsection
