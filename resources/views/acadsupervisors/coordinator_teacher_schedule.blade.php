@extends('acadsupervisors.master')
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
.bell{
  display:block;
  width: 40px;
  height: 40px;
  font-size: 40px;
  margin:50px auto 0;
  color: #9e9e9e;
  -webkit-animation: ring 4s .7s ease-in-out infinite;
  -webkit-transform-origin: 50% 4px;
  -moz-animation: ring 4s .7s ease-in-out infinite;
  -moz-transform-origin: 50% 4px;
  animation: ring 4s .7s ease-in-out infinite;
  transform-origin: 50% 4px;
}

@-webkit-keyframes ring {
  0% { -webkit-transform: rotateZ(0); }
  1% { -webkit-transform: rotateZ(30deg); }
  3% { -webkit-transform: rotateZ(-28deg); }
  5% { -webkit-transform: rotateZ(34deg); }
  7% { -webkit-transform: rotateZ(-32deg); }
  9% { -webkit-transform: rotateZ(30deg); }
  11% { -webkit-transform: rotateZ(-28deg); }
  13% { -webkit-transform: rotateZ(26deg); }
  15% { -webkit-transform: rotateZ(-24deg); }
  17% { -webkit-transform: rotateZ(22deg); }
  19% { -webkit-transform: rotateZ(-20deg); }
  21% { -webkit-transform: rotateZ(18deg); }
  23% { -webkit-transform: rotateZ(-16deg); }
  25% { -webkit-transform: rotateZ(14deg); }
  27% { -webkit-transform: rotateZ(-12deg); }
  29% { -webkit-transform: rotateZ(10deg); }
  31% { -webkit-transform: rotateZ(-8deg); }
  33% { -webkit-transform: rotateZ(6deg); }
  35% { -webkit-transform: rotateZ(-4deg); }
  37% { -webkit-transform: rotateZ(2deg); }
  39% { -webkit-transform: rotateZ(-1deg); }
  41% { -webkit-transform: rotateZ(1deg); }

  43% { -webkit-transform: rotateZ(0); }
  100% { -webkit-transform: rotateZ(0); }
}

@-moz-keyframes ring {
  0% { -moz-transform: rotate(0); }
  1% { -moz-transform: rotate(30deg); }
  3% { -moz-transform: rotate(-28deg); }
  5% { -moz-transform: rotate(34deg); }
  7% { -moz-transform: rotate(-32deg); }
  9% { -moz-transform: rotate(30deg); }
  11% { -moz-transform: rotate(-28deg); }
  13% { -moz-transform: rotate(26deg); }
  15% { -moz-transform: rotate(-24deg); }
  17% { -moz-transform: rotate(22deg); }
  19% { -moz-transform: rotate(-20deg); }
  21% { -moz-transform: rotate(18deg); }
  23% { -moz-transform: rotate(-16deg); }
  25% { -moz-transform: rotate(14deg); }
  27% { -moz-transform: rotate(-12deg); }
  29% { -moz-transform: rotate(10deg); }
  31% { -moz-transform: rotate(-8deg); }
  33% { -moz-transform: rotate(6deg); }
  35% { -moz-transform: rotate(-4deg); }
  37% { -moz-transform: rotate(2deg); }
  39% { -moz-transform: rotate(-1deg); }
  41% { -moz-transform: rotate(1deg); }

  43% { -moz-transform: rotate(0); }
  100% { -moz-transform: rotate(0); }
}

@keyframes ring {
  0% { transform: rotate(0); }
  1% { transform: rotate(30deg); }
  3% { transform: rotate(-28deg); }
  5% { transform: rotate(34deg); }
  7% { transform: rotate(-32deg); }
  9% { transform: rotate(30deg); }
  11% { transform: rotate(-28deg); }
  13% { transform: rotate(26deg); }
  15% { transform: rotate(-24deg); }
  17% { transform: rotate(22deg); }
  19% { transform: rotate(-20deg); }
  21% { transform: rotate(18deg); }
  23% { transform: rotate(-16deg); }
  25% { transform: rotate(14deg); }
  27% { transform: rotate(-12deg); }
  29% { transform: rotate(10deg); }
  31% { transform: rotate(-8deg); }
  33% { transform: rotate(6deg); }
  35% { transform: rotate(-4deg); }
  37% { transform: rotate(2deg); }
  39% { transform: rotate(-1deg); }
  41% { transform: rotate(1deg); }

  43% { transform: rotate(0); }
  100% { transform: rotate(0); }
}
	 </style>


<section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                <h1 class="mb-0 bread"> برنامج الدوام  </h1>
            </div>
        </div>
    </div>
</section>
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">    جدول الدوام    </a>
     <a  href="{{ route('dashboard.acadsupervisor_teacher',[$room->id,$teacher->id, $lesson->id ]) }}" class="breadcrumbs__item "> {{ $teacher->first_name }}  {{ $teacher->last_name }}   </a>
    <a  href="{{ route('dashboard.acadsupervisor_subject',$room->id ) }}" class="breadcrumbs__item ">{{ $classes->name }} / {{$room->name}}   </a>
     <a   href="{{ route('dashboard.acadsupervisor') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<div  id="bell1" style="display:none">

    <span class="bell fa fa-bell"></span>
  </div>
  <!-- start new-->

<div class="col-md-10 " style="margin: auto; direction: rtl; text-align:center">
    @if (session()->has('success'))

    <script>
        window.onload = function() {
            notif({
                msg: " {{ Session::get('success') }} ",
                type: "success"
            })
        }

    </script>
@endif
    @if (session()->has('error'))

    <script>
        window.onload = function() {
            notif({
                msg: "{{ Session::get('error') }}",
                type: "error"
            })
        }

    </script>
@endif
    @if (session()->has('othertime'))

    <script>
        window.onload = function() {
            notif({
                msg: " {{  Session::get('othertime')  }} ",
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
    <div class="row"  >
        <!-- <div class="row" style="margin-right: 1px;float:left ">-->
        <!--        <div class="col3 mx-2 btn-success p-1">يمكن الدخول للدرس</div>-->
        <!--        <div class="col3 mx-2 btn-danger p-1">تم حضورالدرس   </div>-->
        <!--        <div class="col3 mx-2 btn-warning p-1">الدرس لا يحوي رابط غوغل</div>-->
        <!--        <div class="col3 mx-2 btn-primary2 p-1 text-light">اللون الافتراضي</div>-->
        <!--</div>-->
        {{-- <a class="btn btn-success" href="{{ route('teacher.google_meets',$teacher->id) }}"> Goolge Meets</a> --}}
        <h1  class="title text-center w-100 m-5" style="text-align: center"> برنامج الدوام  </h1>
       
        <div class="row w-100" style="margin-right: 1px;margin-bottom:15px ">
                <div class="col-sm-2 mx-2 btn-primary2 p-1 text-light">اللون الافتراضي</div>
                <div class="col-sm-2 mx-2 btn-info p-1 text-light">اليوم الحالي </div>
                <div class="col-sm-2 mx-2 btn-success p-1">يمكن الدخول للدرس</div>
                <div class="col-sm-2 mx-2 btn-danger p-1">تم حضورالدرس   </div>
                <div class="col-sm-3 mx-2 btn-warning p-1">الدرس لا يحوي رابط غوغل</div>
        </div>
        <div style="overflow-x: scroll;width: 100%;">
       <table class="table table-bordered table-responsive"
        style="direction: rtl !important;text-align: center !important;display:inline-table">

        <tbody>
            <?php
             $i = 1;
            ?>
            @foreach ($days as $key => $day)

                <tr>
                    <th scope="row">{{ $day->name }}</th>
                        @php
                        $lesson_name2 =  '' ;
                        $title =  ' حصة اسبوعية' ;
                        $google_meeting_link =  '' ;
                        $lesson_time_id =  -1 ;
                        $room_id = "";
                        $class_and_room  =    '';
                        $background =    'btn-primary2';
                        $my_href = '#';
                        $passToStream  = true ;
                        $go_to_google = false ;


                        @endphp

                        @foreach ($schedule as $key3 => $lesson_time )
                            @if ($day->id == $lesson_time->day_id )
                                @php
                                $lesson_name2 =   '';
                                $class_name =    $lesson_time->room->classes->name;
                                $room_name =    $lesson_time->room->name;
                                $room_id =    $lesson_time->room->id;
                                $class_and_room = " $class_name / $room_name" ;
                                $lesson_name2 =    $lesson_time->lesson->name ;
                                $lesson_time_id = $lesson_time->id ;
                                $meeting_link = $lesson_time->meeting_link ;

                                if( $today == $day->id - 1 && $lesson_time->attendance == false &&  $lesson_time->inter == false && $lesson_time->meeting_link != null){
                                    $background = 'btn-info';
                                    // $title = 'لم يحن الوقت بعد';
                                }
                                else if($today == $day->id - 1 && $lesson_time->attendance == false &&  $lesson_time->inter == true && isset($lesson_time->meeting_link )){
                                    $background = 'btn-success';
                                    $title = ' الدخول للحصة';
                                    $google_meeting_link = $lesson_time->meeting_link ;
                                    $go_to_google = true;
                                }
                                else if($today == $day->id - 1 && $lesson_time->meeting_link == null){
                                    $background = 'btn-warning';
                                    $title = 'لا يوجد درس مجدول';
                                }
                                else if($today == $day->id - 1 && $lesson_time->attendance == true){
                                    $background = 'btn-danger';
                                    // $title = 'لقد زرت هذا الرابط من قبل   ';

                                }
                                else
                                    $background = 'btn-primary2';


                                @endphp
                                <td >
                                    <a  style="display: block" target="_blank"
                                        class="btn
                                        {{ $background }}
                                        btn-sm add_time "
                                        @if( $passToStream && $room_id != "" &&  $go_to_google)
                                            href="{{ route('dashboard.teacher.room.go_to_stream',['scheduler_id' => $lesson_time_id,'day_id' => $day->id,'lecture_time_id' =>$lesson_time->lecture_time->id ,'room_id' =>$room_id,'teacher_id' => $teacher_id]) }}"
                                        @endif
                                        title="{{ $title }}">
                                        <p class="lesson_name-schedule{{  $day->id .''. $lesson_time->lecture_time->id }}" style="margin:0;font-weight:bold"> {{ $lesson_time->lesson->name }}</p>
                                        <p class="teacher_name-schedule{{  $day->id .''. $lesson_time->lecture_time->id }}" style="margin:0;font-size:14px"> {{ $lesson_time->room->classes->name." / ".$lesson_time->room->name }} </p>
                                        <p  style="margin:0;font-size:14px"> {{ $lesson_time->lecture_time->start_time." - ".$lesson_time->lecture_time->end_time }} </p>
                                        <input class="time" hidden value="$lesson_time->lecture_time->end_time">
                                        <p  style="margin:0;font-size:14px"> {{ $lesson_time->lecture_time->name }} </p>
                                    </a>
                                    @if( $lesson_time_id > 0)


                                    <a class="btn  btn-warning btn-sm add_time"
                                        data-toggle="modal" data-target="#add_schedule" data-day_id = '{{ $day->id  }}'
                                        data-day = '{{ $day->name  }}'
                                        data-time = "{{ $lesson_time->lecture_time->name }}"
                                         data-lesson_name = "{{ $lesson_name2 }}"
                                        data-lesson_time_id = "{{ $lesson_time_id }}"
                                        data-meeting_link = "{{  $meeting_link  }}"

                                        title="إضافة رابط ">
                                    </a>
                                    @endif
                                </td>
                            @endif
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

<audio id="MyAudioElement" >
    <source src="{{asset('teachers/schoolbell.mp3')}}" >

   
  </audio>
  <button id="btn" hidden></button>

{{-- add lesson time --}}

<div class="modal fade" id="add_schedule">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="direction: rtl; text-align:right">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLongTitle">  إضافة رابط غوغل   </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: inline-block;margin: 0px;padding: 0px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  action="{{ route('teacher.google_meet_add') }}" method="post" class="w-100">
                @csrf
                {{-- <input type="hidden" name="room_id" id="room_id" value=" {{ $room_id }}" class="room_id"> --}}
                <input type="hidden" name="lesson_time_id" id="lesson_time_id"  class="lesson_time_id">


                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> اليوم : </label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control day">
                        <input type="hidden" name="day_id"  class="form-control day_id">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> الحصة : </label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control time">
                        <input type="hidden" name="time_id"  class="form-control time_id">

                    </div>
                </div>
                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> المادة : </label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control lesson">
                        <input type="hidden" name="lesson_id"  class="form-control time_id">

                    </div>
                </div>
                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> الرابط : </label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control meeting_link" name="meeting_link">
                    </div>
                </div>

                <div class="form-group modal-footer row justify-content-around px-3">
                      <button class="btn btn-success save_lecture_time" type="submit" style="width: 35%">تأكيد </button>
                    <button  class="btn btn-light btn-info" data-dismiss="modal" style="width: 35%">خروج</button>
                </div>

                <!-- end submit-->


            </form>
            </div>
        </div>
    </div>
</div>
        {{-- end add lesson time --}}


	@endsection
    @section('js')
    <script>
     $(document).ready(function () {
        Audio.prototype.play = (function(play) {
return function () {
  var audio = this,
      args = arguments,
      promise = play.apply(audio, args);
  if (promise !== undefined) {
    promise.catch(_ => {
      // Autoplay was prevented. This is optional, but add a button to start playing.
      var el = document.getElementById("btn");
        el.innerHTML = "Play";
      el.addEventListener("click", function(){play.apply(audio, args);});
      this.parentNode.insertBefore(el, this.nextSibling);

    });
  }

};
})(Audio.prototype.play);})
    var period = {{ $minutes }} ;

       period1=period*60;
    console.log(period) ;
   var intervalId = window.setInterval(function(){
    if(period != 0){
     period1=period1-1;
 if(period1<1 &&  period1 > -60  ){
   
           $('#bell1').show();
            document.getElementById('btn').click();
    $('#btn').click();
    document.getElementById('MyAudioElement').play();
     
      }
      else{
            $('#bell1').hide(); 
      }
         
    }
}, 1000)
 
    
    
    
  $('#bell1').on('click',function(){
      
       $('#bell1').hide(); 
      period1=-60;
     document.getElementById('MyAudioElement').pause();
     
      
})
  
    
    
     </script>
    <script>
         $('.add_time').on('click',function(){
                day = $(this).data('day');
                time2 = $(this).data('time');
                day_id = $(this).data('day_id');
                time_id = $(this).data('time_id');
                lesson_name = $(this).data('lesson_name');
                lesson_time_id = $(this).data('lesson_time_id');
                meeting_link = $(this).data('meeting_link');
                $(`.day`).val(day);
               $(`.time`).val(time2);
                $(`.day_id`).val(day_id);
               $(`.time_id`).val(time_id);
               $(`.lesson`).val(lesson_name);
               $(`.lesson_time_id`).val(lesson_time_id);
               $(`.meeting_link`).val(meeting_link);
            });
    </script>

    @endsection
