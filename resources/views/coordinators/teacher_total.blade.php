@extends('coordinators.master')
@section('css')

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.min.js>"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <style>

  .cart-count
{
  display: flex;
  position: relative;
  align-items:center;
  justify-content:center;
  min-width:1.3rem; 
  height:1.3rem;
  border-radius:50%;
  font-weight:700;
  font-size:0.7rem;
  line-height:1;
  
  margin-left:20px;
  margin-top:-40px;
  color:#f38639;
  background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);
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
  background: #eee; 
}
th { 
  background: #2c71ad; 
  color: white; 
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: right; 
}
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	td:nth-of-type(1):before { content: "المواد الدراسية "; }
	td:nth-of-type(2):before { content: "الدرجة العظمى "; }
	td:nth-of-type(3):before { content: "درجات اعمال الفصل الأول "; }
	td:nth-of-type(4):before { content: "شفوية "; }
	td:nth-of-type(5):before { content: "وظائف اوراق العمل "; }
	td:nth-of-type(6):before { content: "نشاطات ومبادرات "; }
	td:nth-of-type(7):before { content: "المذاكرات "; }
	td:nth-of-type(8):before { content: "درجة اختبار الفصل الأول "; }
	td:nth-of-type(9):before { content: "مجموع درجات الفصل الأول "; }
	td:nth-of-type(10):before { content: "تقدير الفصل الأول "; }
}
/*end style table */

  

/* style tablist*/
/*style tablist*/

/* section my classes*/


 .tabs {
	 left: 50%;
	 transform: translateX(-50%);
	 position: relative;
	 background: white;
	 padding: 20px;
	 padding-bottom: 80px;
	 width: 99%;
	 height: auto;
	 /*box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);*/
	 border-radius: 5px;
	 min-width: 240px;
   direction: rtl;
   
}
 .tabs input[name="tab-control"] {
	 display: none;
}
 .tabs .content section h2, .tabs ul li label {
	 font-family: "Montserrat";
	 font-weight: bold;
	 font-size: 18px;
	 color: #428bff;
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
	 /*flex: 1;*/
	 /*width: 25%;*/
	 /*padding: 0 0px;*/
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
	 color: #428bff;
	 display: none;
}
 .tabs .content section h2::after {
	 content: "";
	 position: relative;
	 display: block;
	 width: 30px;
	 height: 3px;
	 background: #f38639;
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
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label svg {
	 fill: #428bff;
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
 @media (max-width: auto) {
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
/*end section my classes*/
 /*style for input*/
 .form__group {
  direction: rtl;
    position: relative;
    padding: 15px 0 0;
    margin-top: 10px;
    width: 20%;
   
}
 .form__field {
    font-family: inherit;
   
    width: 150px;
    border: 0;
    border-bottom: 2px solid #9b9b9b;
    outline: 0;
    font-size: 1.3rem;
    color: #2c71ad;
    padding: 7px 0;
    background: transparent;
    transition: border-color 0.2s;
}
 .form__field::placeholder {
    color: transparent;
}
 .form__field:placeholder-shown ~ .form__label {
    font-size: 1.3rem;
    cursor: text;
    top: 20px;
   padding-right: 32px;
}
 .form__label {
  text-align: right;
    position: absolute;
    top: 0;
    display: block;
    transition: 0.2s;
    font-size: 1rem;
    color: #9b9b9b;
    padding-right: 39px;
}
 .form__field:focus {
  
    padding-bottom: 6px;
    font-weight: 700;
    border-width: 3px;
    /*border-image: linear-gradient(to right, #11998e, #38ef7d);
    border-image-slice: 1;*/
}
 .form__field:focus ~ .form__label {
  
    position: absolute;
    top: 0;
    display: block;
    transition: 0.2s;
    font-size: 1rem;
    color: #11998e;
    font-weight: 700;
}
/* reset input */
 .form__field:required, .form__field:invalid {
    box-shadow: none;
}
/* demo */
 
 

	 </style>

@endsection
@section('content')


<section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2">
                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread">دفتر العلامات 
            </div>
        </div>
    </div>
</section>
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">  دفتر العلامات </a>
     <a  href="{{ route('coordinator_tacher_room',[$class_id->id,$lesson->id,$teacher->id]) }}" class="breadcrumbs__item ">{{ $room->name }}   </a>
     <a  href="{{ route('dashboard.coordinator_teacher',[$class_id->id,$teacher->id, $lesson->id ]) }}" class="breadcrumbs__item "> {{ $teacher->first_name }}  {{ $teacher->last_name }}   </a>
    <a  href="{{ route('dashboard.coordinator_subject',$class_id->id ) }}" class="breadcrumbs__item ">{{ $class_id->name }}   </a>
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<!-- start new-->


<br>
<br>


<br>
<br>
<!--- tablist for total marks -->
<!-- marks of subjects -->

<a  href="{{ route('StudentsRoomLessontotal_pdf1',[$room_id,$teacher->id,$lesson_id]) }}"   class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;" target="_blank">pdf تنزيل </a>
<a  href="{{ route('StudentsRoomLessontotal_excel1',[$room_id,$teacher->id,$lesson_id]) }}"   class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;" target="_blank">excel تنزيل </a>
       @php
                     function arabic_w2e($str)
{
    $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    return str_replace($arabic_western, $arabic_eastern, $str);
}

                     @endphp


<div class="tabs">
  
  <input type="radio" id="tab1" name="tab-control" checked>
  <input type="radio" id="tab2" name="tab-control">
  <input type="radio" id="tab3" name="tab-control">  
 
  <ul>
    <li title="الفصل الأول "><label for="tab1" role="button"><svg viewBox="0 0 24 24"><path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
      </svg>
        <span>الفصل الأول</span></label></li> &nbsp;&nbsp;&nbsp;&nbsp;

        <li title="الفصل الثاني "><label for="tab2" role="button"><br><svg viewBox="0 0 24 24"><path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
        </svg>
          <span>الفصل الثاني</span></label></li>&nbsp;&nbsp;&nbsp;&nbsp;

          <!--li title="المحصلة "><label for="tab3" role="button"><br><svg viewBox="0 0 24 24"><path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
          </svg>
            <span>المحصلة</span></label></li-->

</ul>

	
	<div class=""><div class="indicator"></div></div>

	<div class="content">
    <section >
			<h2>الفصل الأول</h2>
      <table >
        <thead>
            <tr>
                <th rowspan="2"    style="text-align: center;" >الطلاب </th>
                <th rowspan="2"   style="text-align: center;" >الدرجة العظمى </th>
                <th rowspan="1" colspan="4" style="text-align: center;">درجات اعمال الفصل الأول </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;">درجة اختبار الفصل الأول </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;">مجموع درجات الفصل الأول </th>
                <th rowspan="2"  colspan="1"  style="text-align: center;" > تقدير الفصل الأول </th>
                <!--<th rowspan="2" colspan="1" style="text-align: center;"> ارسال </th>-->
               
            </tr>
            <tr>
             
             <th rowspan="1" colspan="1"  style="text-align: center;">شفوية <br> <span style="color: #f38639;">%١٠</span>  </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> وظائف و اوراق عمل  <br> <span style="color: #f38639;">%١٠</span> </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> نشاطات  و مبادرات <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
              <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>
            </tr>


        </thead>
        <tbody>
            @foreach (  $students as $item  )
          <form  action="{{ route('admin.teacher_student_mark') }}"  method="post">
                 @csrf
            <tr>
                 <input type="hidden" name="term" value="term1">
                <input type="hidden" name="room_id" value="{{ $room_id }}">
            <input type="hidden" name="student_id" value="{{$item->id}}">
            <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
                <td> {{ $item->first_name }} {{ $item->last_name }} </td>
                <td>{{arabic_w2e($lesson->max_mark)	}} </td>
                  @foreach ($item->student_mark as $item2)

                <td >
                    @if(json_decode($item2->mark,true)[$lesson_id]['oral']==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red;"value="{{ json_decode($item2->mark,true)[$lesson_id]['oral']}}" name="oral" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"  min="0" data-max="{{$lesson->max_mark*0.1}}"  max="{{$lesson->max_mark*0.1}}">
                    @else
                      <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"value="{{ json_decode($item2->mark,true)[$lesson_id]['oral']}}" name="oral" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.1}}"   max="{{$lesson->max_mark*0.1}}">
                   @endif
                    </td>
               
                   
                <td>
                      @if( json_decode($item2->mark,true)[$lesson_id]['homework'] ==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red"  value="{{ json_decode($item2->mark,true)[$lesson_id]['homework'] }}" name="homework" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"  min="0" data-max="{{$lesson->max_mark*0.1}}"  max="{{$lesson->max_mark*0.1}}">
                    @else
              <input  class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"  value="{{ json_decode($item2->mark,true)[$lesson_id]['homework'] }}" name="homework" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"  min="0" data-max="{{$lesson->max_mark*0.1}}"  max="{{$lesson->max_mark*0.1}}">
                   @endif
                    
                <td>
                       @if( json_decode($item2->mark,true)[$lesson_id]['activities'] ==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red"  value="{{ json_decode($item2->mark,true)[$lesson_id]['activities'] }}" name="activities" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.2}}"  max="{{$lesson->max_mark*0.2}}">
                    @else
              <input  class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"  value="{{ json_decode($item2->mark,true)[$lesson_id]['activities'] }}" name="activities" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.2}}"  max="{{$lesson->max_mark*0.2}}">
                   @endif
                   </td>
                    
                <td>
                     @if( json_decode($item2->mark,true)[$lesson_id]['quize'] ==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red"  value="{{ json_decode($item2->mark,true)[$lesson_id]['quize'] }}" name="quize" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"min="0" data-max="{{$lesson->max_mark*0.2}}"  max="{{$lesson->max_mark*0.2}}">
                    @else
              <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"  value="{{ json_decode($item2->mark,true)[$lesson_id]['quize'] }}" name="quize" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.2}}"  max="{{$lesson->max_mark*0.2}}">
                   @endif
                   </td>
                   
                     <td>
                          @if( json_decode($item2->mark,true)[$lesson_id]['exam'] ==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red"  value="{{ json_decode($item2->mark,true)[$lesson_id]['exam'] }}" name="exam" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"min="0" data-max="{{$lesson->max_mark*0.4}}"  max="{{$lesson->max_mark*0.4}}">
                    @else
              <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"  value="{{ json_decode($item2->mark,true)[$lesson_id]['exam'] }}" name="exam" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.4}}"  max="{{$lesson->max_mark*0.4}}">
                   @endif
                       </td>
                      @if(json_decode($item2->result1,true)[$lesson_id]['term1_result'] >$lesson->min_mark)
                <td> {{arabic_w2e( json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}} </td>
                @else
                 <td style="color: red;
               text-decoration: underline;"> {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}} </td>
                @endif
                <td>
                  @if($item2->estimation1)
                  @foreach( json_decode($item2->estimation1,true) as $key=>$item)
                  @if($key == $lesson_id )
                    {{$item}}
                        @break
               
                @endif
              
                 @endforeach
                 
                    @endif
                    </td>
                <!--<td><button type="submit" class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;">ارسال </button>-->

              
                <!--</td>-->
                 @endforeach
            </tr>
          </form>
          @endforeach

       

  <!--form>
  <tr>
    <td>المشروع</td>
    <td>100 </td>
    <td colspan="6"><textarea class="form-control"></textarea></td>
   
    <td><input style="height: 50px; width:60px" name="name" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control" required="" type="text"></td>
    </td>
    <td><a href="#" class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color: white;">ارسال </a>
</tr>
</form>

<form-->
<!--tr>
  <td>السلوك </td>
  <td>100 </td>
  <td colspan="6"><textarea class="form-control"></textarea></td>
 
  <td><input style="height: 50px; width:60px" name="name" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control" required="" type="text"></td>
  </td>
  <td><a href="#" class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color: white;">ارسال </a>
</tr>
</form-->

<!--form>
<tr>
  <td>النشاط المدرسي والطلائعي </td>
  <td>100 </td>
  <td colspan="6"><textarea class="form-control"> </textarea></td>
 
  <td><input style="height: 50px; width:60px" name="name" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control" required="" type="text"></td>
  </td>
  <td><a href="#" class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);;color: white;">ارسال </a>
   
</tr>
</form-->

        </tbody>
      </table>
      
			
	
			 
	
		  </section>
		   <!-- end mark subject -->
       <section >
        <h2>الفصل الثاني  </h2>
        <table style="text-align: center;" >
          <thead style="text-align: center;" >
              <tr style="text-align: center;"  >
                <th rowspan="2" colspan="1" style="text-align: center;">الطلاب </th>
                <th rowspan="2" colspan="1" style="text-align: center;"> الدرجة العظمى </th>
                  <th rowspan="1" colspan="4" style="text-align: center;"> درجة اعمال الفصل الثاني </th>
                  <th rowspan="1" colspan="1" style="text-align: center;" >درجة اختبار الفصل الثاني </th>
                  <th rowspan="1" colspan="1" style="text-align: center;" >مجموع درجات الفصل الثاني </th>
                  <th rowspan="2" colspan="1" style="text-align: center;" >تقدير الفصل الثاني  </th>
                  <th rowspan="2" colspan="1" style="text-align: center;" >مجموع درجات الفصلين</th>
                  <th rowspan="2" colspan="1" style="text-align: center;"  > متوسط درجات الفصلين </th>
                  <th rowspan="2" colspan="1" style="text-align: center;"  >  التقدير النهائي </th>
                  <!--<th rowspan="2" colspan="1" style="text-align: center;"  > ارسال </th>-->
              </tr>
              <tr>
              <th rowspan="1" colspan="1"  style="text-align: center;">شفوية <br> <span style="color: #f38639;">%١٠</span>  </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> وظائف و اوراق عمل  <br> <span style="color: #f38639;">%١٠</span> </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> نشاطات  و مبادرات <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
              <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>

              </tr>
          </thead>
          <tbody style="text-align: center;"  >
             @foreach (  $students as $item  )
          <form  action="{{ route('admin.teacher_student_mark') }}"  method="post">
                 @csrf
            <tr>
                 <input type="hidden" name="term" value="term2">
                <input type="hidden" name="room_id" value="{{ $room_id }}">
            <input type="hidden" name="student_id" value="{{$item->id}}">
            <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
                <td> {{ $item->first_name }} {{ $item->last_name }} </td>
                <td>{{arabic_w2e($lesson->max_mark)	}} </td>
                 @foreach ($item->student_mark as $item2)
                 <td>
                 @if(json_decode($item2->mark2,true)[$lesson_id]['oral']==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red;"value="{{ json_decode($item2->mark2,true)[$lesson_id]['oral']}}" name="oral" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"  min="0" data-max="{{$lesson->max_mark*0.1}}"  max="{{$lesson->max_mark*0.1}}">
                    @else
                      <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"value="{{ json_decode($item2->mark2,true)[$lesson_id]['oral']}}" name="oral" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.1}}"   max="{{$lesson->max_mark*0.1}}">
                   @endif
                    </td>
                  <td>
                      @if( json_decode($item2->mark2,true)[$lesson_id]['homework'] ==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red"  value="{{ json_decode($item2->mark2,true)[$lesson_id]['homework'] }}" name="homework" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"  min="0" data-max="{{$lesson->max_mark*0.1}}"  max="{{$lesson->max_mark*0.1}}">
                    @else
              <input  class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"  value="{{ json_decode($item2->mark2,true)[$lesson_id]['homework'] }}" name="homework" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"  min="0" data-max="{{$lesson->max_mark*0.1}}"  max="{{$lesson->max_mark*0.1}}">
                   @endif
                    
                <td>
                       @if( json_decode($item2->mark2,true)[$lesson_id]['activities'] ==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red"  value="{{ json_decode($item2->mark2,true)[$lesson_id]['activities'] }}" name="activities" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.2}}"  max="{{$lesson->max_mark*0.2}}">
                    @else
              <input  class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"  value="{{ json_decode($item2->mark2,true)[$lesson_id]['activities'] }}" name="activities" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.2}}"  max="{{$lesson->max_mark*0.2}}">
                   @endif   
                   </td>
                   <td>
                         @if( json_decode($item2->mark2,true)[$lesson_id]['quize'] ==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red"  value="{{ json_decode($item2->mark2,true)[$lesson_id]['quize'] }}" name="quize" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"min="0" data-max="{{$lesson->max_mark*0.2}}"  max="{{$lesson->max_mark*0.2}}">
                    @else
              <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"  value="{{ json_decode($item2->mark2,true)[$lesson_id]['quize'] }}" name="quize" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.2}}"  max="{{$lesson->max_mark*0.2}}">
                   @endif
                      </td>
               
                  <td>
                          @if( json_decode($item2->mark2,true)[$lesson_id]['exam'] ==null)
                    <input class="number" style="height: 50px; width:60px; border: 1px solid red"  value="{{ json_decode($item2->mark2,true)[$lesson_id]['exam'] }}" name="exam" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number"min="0" data-max="{{$lesson->max_mark*0.4}}"  max="{{$lesson->max_mark*0.4}}">
                    @else
              <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"  value="{{ json_decode($item2->mark2,true)[$lesson_id]['exam'] }}" name="exam" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="number" min="0" data-max="{{$lesson->max_mark*0.4}}"  max="{{$lesson->max_mark*0.4}}">
                   @endif
                       </td>
                 @if(json_decode($item2->result2,true)[$lesson_id]['term2_result'] >$lesson->min_mark)
                <td> {{arabic_w2e( json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</td>
                @else
                 <td style="color: red;
               text-decoration: underline;"> {{arabic_w2e( json_decode($item2->result2,true)[$lesson_id]['term2_result']) }} </td>
                @endif
              
                <td>
                  @if($item2->estimation2)
                  @foreach( json_decode($item2->estimation2,true) as $key=>$item)
                  @if($key == $lesson_id )
                    {{$item}}
                        @break
               
                @endif
              
                 @endforeach
                 
                    @endif
                    </td>
                <td>{{arabic_w2e( json_decode($item2->result,true)[$lesson_id]['year_result']) }}</td>
                    @if(ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)>$lesson->min_mark)
                  <td>       
                      {{     arabic_w2e(ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)) }}
                     </td>
                    @else
                 <td style="color: red;
               text-decoration: underline;">
                      {{     arabic_w2e(ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)) }}
                   </td>
                @endif
                   <td>
                  @if($item2->estimation)
                  @foreach( json_decode($item2->estimation,true) as $key=>$item)
                  @if($key == $lesson_id )
                    {{$item}}
                        @break
               
                @endif
              
                 @endforeach
                 
                    @endif
                    </td>
                  <!--<td><button  type="submit"class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;">ارسال </button>-->
  
                
                  <!--</td>-->
                  @endforeach
              </tr>
               
            </form>
   @endforeach
 
  


  
          </tbody>
        </table>
        
        
    
         
             </section>
        <!-- end mark subject -->
  
	

		 <!-- start  mark subject -->
		 
			<!-- start mark subject-->
		 
		
	</div>
  </div>
<!-- end add content -->
<!-- end marks of subject -->
  <!-- end tablist for marks -->



	
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
  
 
	
		<!-- loader -->
		<div id="ftco-loader" class="show fullscreen">
			<svg class="circular" width="48px" height="48px">
				<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/> 
				<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
			</svg>
		</div>
@endsection
@section('js')
 
<script>
$(document).on('keyup', '.number', function () {
    
    if($(this).val()>$(this).data('max') || $(this).val()==""){
        alert('لايمكن وضع القيمة');
        $(this).val("");
    }
    
    
})
    
</script>
 <script type="text/javascript">
     
     
    var array1 = new Array();
  
   var n = 1; //Total table
   for ( var x=1; x<=n; x++ ) {
       array1[x-1] = x;
   
   }

   var tablesToExcel = (function () {
       var uri = 'data:application/vnd.ms-excel;base64,'
       , template = '<html xmlns.o="urn.schemas-microsoft-com.office.office" xmlns.x="urn.schemas-microsoft-com.office.excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x.ExcelWorkbook><x.ExcelWorksheets>'
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
   
<script>
  (function() {
var Util,
__bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Util = (function() {
function Util() {}

Util.prototype.extend = function(custom, defaults) {
var key, value;
for (key in custom) {
  value = custom[key];
  if (value != null) {
    defaults[key] = value;
  }
}
return defaults;
};

Util.prototype.isMobile = function(agent) {
return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(agent);
};

return Util;

})();

this.WOW = (function() {
WOW.prototype.defaults = {
boxClass: 'wow',
animateClass: 'animated',
offset: 0,
mobile: true
};

function WOW(options) {
if (options == null) {
  options = {};
}
this.scrollCallback = __bind(this.scrollCallback, this);
this.scrollHandler = __bind(this.scrollHandler, this);
this.start = __bind(this.start, this);
this.scrolled = true;
this.config = this.util().extend(options, this.defaults);
}

WOW.prototype.init = function() {
var _ref;
this.element = window.document.documentElement;
if ((_ref = document.readyState) === "interactive" || _ref === "complete") {
  return this.start();
} else {
  return document.addEventListener('DOMContentLoaded', this.start);
}
};

WOW.prototype.start = function() {
var box, _i, _len, _ref;
this.boxes = this.element.getElementsByClassName(this.config.boxClass);
if (this.boxes.length) {
  if (this.disabled()) {
    return this.resetStyle();
  } else {
    _ref = this.boxes;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      box = _ref[_i];
      this.applyStyle(box, true);
    }
    window.addEventListener('scroll', this.scrollHandler, false);
    window.addEventListener('resize', this.scrollHandler, false);
    return this.interval = setInterval(this.scrollCallback, 50);
  }
}
};

WOW.prototype.stop = function() {
window.removeEventListener('scroll', this.scrollHandler, false);
window.removeEventListener('resize', this.scrollHandler, false);
if (this.interval != null) {
  return clearInterval(this.interval);
}
};

WOW.prototype.show = function(box) {
this.applyStyle(box);
return box.className = "" + box.className + " " + this.config.animateClass;
};

WOW.prototype.applyStyle = function(box, hidden) {
var delay, duration, iteration;
duration = box.getAttribute('data-wow-duration');
delay = box.getAttribute('data-wow-delay');
iteration = box.getAttribute('data-wow-iteration');
return box.setAttribute('style', this.customStyle(hidden, duration, delay, iteration));
};

WOW.prototype.resetStyle = function() {
var box, _i, _len, _ref, _results;
_ref = this.boxes;
_results = [];
for (_i = 0, _len = _ref.length; _i < _len; _i++) {
  box = _ref[_i];
  _results.push(box.setAttribute('style', 'visibility: visible;'));
}
return _results;
};

WOW.prototype.customStyle = function(hidden, duration, delay, iteration) {
var style;
style = hidden ? "visibility: hidden; -webkit-animation-name: none; -moz-animation-name: none; animation-name: none;" : "visibility: visible;";
if (duration) {
  style += "-webkit-animation-duration: " + duration + "; -moz-animation-duration: " + duration + "; animation-duration: " + duration + ";";
}
if (delay) {
  style += "-webkit-animation-delay: " + delay + "; -moz-animation-delay: " + delay + "; animation-delay: " + delay + ";";
}
if (iteration) {
  style += "-webkit-animation-iteration-count: " + iteration + "; -moz-animation-iteration-count: " + iteration + "; animation-iteration-count: " + iteration + ";";
}
return style;
};

WOW.prototype.scrollHandler = function() {
return this.scrolled = true;
};

WOW.prototype.scrollCallback = function() {
var box;
if (this.scrolled) {
  this.scrolled = false;
  this.boxes = (function() {
    var _i, _len, _ref, _results;
    _ref = this.boxes;
    _results = [];
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      box = _ref[_i];
      if (!(box)) {
        continue;
      }
      if (this.isVisible(box)) {
        this.show(box);
        continue;
      }
      _results.push(box);
    }
    return _results;
  }).call(this);
  if (!this.boxes.length) {
    return this.stop();
  }
}
};

WOW.prototype.offsetTop = function(element) {
var top;
top = element.offsetTop;
while (element = element.offsetParent) {
  top += element.offsetTop;
}
return top;
};

WOW.prototype.isVisible = function(box) {
var bottom, offset, top, viewBottom, viewTop;
offset = box.getAttribute('data-wow-offset') || this.config.offset;
viewTop = window.pageYOffset;
viewBottom = viewTop + this.element.clientHeight - offset;
top = this.offsetTop(box);
bottom = top + box.clientHeight;
return top <= viewBottom && bottom >= viewTop;
};

WOW.prototype.util = function() {
return this._util || (this._util = new Util());
};

WOW.prototype.disabled = function() {
return !this.config.mobile && this.util().isMobile(navigator.userAgent);
};

return WOW;

})();

}).call(this);


wow = new WOW(
{
animateClass: 'animated',
offset: 100
}
);
wow.init();

</script>
@endsection
