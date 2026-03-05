@extends('acadsupervisors.master')
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

    /*position: relative;*/

    margin-bottom: 30px;
    box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
}
.l-bg-cherry {
    background: linear-gradient(to right top, #289cf5, #84c0ec) !important;
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
    font-size: 110px;

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


/*
.card {
  margin: 30px auto;
  width: 300px;
  height: 300px;
  border-radius: 40px;
  background-image: url('https://i.redd.it/b3esnz5ra34y.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  background-repeat: no-repeat;
box-shadow: 5px 5px 30px 7px rgba(0,0,0,0.25), -5px -5px 30px 7px rgba(0,0,0,0.22);
  transition: 0.4s;
}


/*end cards of mark */


/*new design for cards */
/*@import url(https://fonts.googleapis.com/css?family=Raleway:300);

.badge {
  display: block;
  position: relative;
  width: 10rem;
  height: 10rem;
  cursor: pointer;
  background: url(./simages/IMG_1868.jpg) no-repeat 100% 50%;
  background-size: 120%;
  border-radius: 50%;
  transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1);
  box-shadow: 0px 0.5rem 1rem white;
}
.badge:hover {
  box-shadow: 0px 0.5rem 2rem white;
  background-position: 0% 50%;
}
.badge:hover .text {
  transform: rotate(-45deg) translate(0px) rotate(-315deg);
  background: rgba(102, 51, 153, 0.5);
  width: 10rem;
  letter-spacing: 1rem;
  line-height: 20rem;
  height: 10rem;
  margin-top: -5rem;
  margin-left: -5rem;
  transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1), letter-spacing 1.5s ease-out;
}
.badge .text {
  display: block;
  position: absolute;
  width: 7rem;
  height: 7rem;
  line-height: 7rem;
  left: 26%;
  top: 36%;
  margin-top: -5rem;
  margin-left: -5rem;
  font-size: 2rem;
  font-family: Raleway, sans-serif;
  text-align: center;
  color: #fff;
  border-radius: 50%;
  background: rebeccapurple;
  transform: rotate(-180deg) translate(-10rem) rotate(180deg);
  box-shadow: 0px 0.5rem 1rem rgba(0, 0, 0, 0.5);
  transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1);
}*/
</style>

@endsection
@section('content')

<!-- END nav -->


<section class="hero-wrap hero-wrap-2" style="background-image:url( {{  asset('teachers/ppp.jpg') }})">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
               
                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread"> {{ $teacher->first_name }}  {{ $teacher->last_name }} </h1>
            </div>
        </div>
    </div>
</section>
@if (session()->has('error'))
<script>
    window.onload = function () {
        notif({
            msg: " لايوجد تحليل وحدة بعد ",
            type: "error"
        })
    }
</script>
@endif
<!-- start new-->

<!-- end new-->
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">{{ $teacher->first_name }}  {{ $teacher->last_name }} / {{$lesson->name}} </a>
   
    <a  href="{{ route('dashboard.acadsupervisor_subject',['room_id' =>$room->id])}}" class="breadcrumbs__item ">{{ $classes->name }} / {{$room->name}}  </a>
     <a   href="{{ route('dashboard.acadsupervisor') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>

<br>
<br>
<br>
<br>

<div class="col-md-10 " style="margin: auto; direction: rtl; text-align: right; ">
    <div class="row">

        <div class="col-xl-3 col-lg-6" style="margin: auto; ">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large">
						<i class="fas fa-calendar" style=" transform: rotateY(180deg);"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
								<a href="{{ route('acadsupervisor_teacher_schedule',[$teacher->id,$room->id,$lesson->id]) }}" target="_blank" class="d-flex align-items-center mb-0" style="color: white;"> جدول الدوام</a>
                            </h2>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6" style="margin: auto; ">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large">
						<i class="fas fa-file" style=" transform: rotateY(180deg);"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
								<a href="{{ route('dashboard.acadsupervisor_teacher_lesson',[$room->id,$teacher->id,$lesson->id]) }}" class="d-flex align-items-center mb-0" style="color: white;">  الدروس</a>
                            </h2>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6" style="margin: auto; ">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large">
						<i class="fas  fa-clipboard-check" style=" transform: rotateY(180deg);"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
								<a href="{{ route('acadsupervisor.showclass',[$lesson->id,$teacher->id,$room->id]) }}" class="d-flex align-items-center mb-0" style="color: white;"> التقييم </a>
                            </h2>
                        </div>
                
                    </div>      

                </div>
            </div>
        </div>

 <div class="col-xl-3 col-lg-6" style="margin: auto; ">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large">
						<i class="fas fa-star" style=" transform: rotateY(180deg);"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">

								<a href="{{ route('acadsupervisor_show_quize_room',[$classes->id,$lesson->id,$room->id,$teacher->id]) }}" class="d-flex align-items-center mb-0" style="color: white;"> المذاكرات </a>
                            </h2>
                        </div>

                    </div>

                </div>
            </div>
        </div>
 <div class="col-xl-3 col-lg-6" style="margin: auto; ">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large">
						<i class="fas fa-star" style=" transform: rotateY(180deg);"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">

								<a href="{{ route('acadsupervisor_show_exam_room',[$classes->id,$lesson->id,$room->id,$teacher->id]) }}" class="d-flex align-items-center mb-0" style="color: white;"> الامتحانات </a>
                            </h2>
                        </div>

                    </div>

                </div>
            </div>
        </div>
     <div class="col-xl-3 col-lg-6" style="margin: auto; ">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large">
						<i class="fas fa-clipboard-check" style=" transform: rotateY(180deg);"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">

								<a href="{{route('acadsupervisor_teacher_plan',[$room->id,$lesson->id,$teacher->id])}}" class="d-flex align-items-center mb-0" style="color: white;">  الخطة الفصلية </a>
                            </h2>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6" style="margin: auto; ">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large">
						<i class="fas fa-clipboard-list" style=" transform: rotateY(180deg);"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">

								<a href="{{route('acadsupervisor_teacher_showunit',[$room->id,$lesson->id,$teacher->id])}}" class="d-flex align-items-center mb-0" style="color: white;"> تحليل الوحدة  </a>
                            </h2>
                        </div>

                    </div>

                </div>
            </div>
        </div>
 <div class="col-xl-3 col-lg-6" style="margin: auto; ">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large">
						<i class="fas fa-clipboard-list" style=" transform: rotateY(180deg);"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">

								<a href="{{route('StudentsRoomLessontotal12',[$room->id,$teacher->id,$lesson->id])}}" class="d-flex align-items-center mb-0" style="color: white;">  دفتر العلامات   </a>
                            </h2>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- end new-->


<br>
<br>
<br>
<br>





<!-- loader -->
<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
            stroke="#F96D00" />
    </svg>
</div>



@endsection
@section('js')
@endsection
