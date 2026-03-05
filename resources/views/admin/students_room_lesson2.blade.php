@extends('admin.master')
@section('style')

<style>
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

.modal-header .close {
    padding: 1rem;
    margin: -1rem 20rem -1rem auto;
}
</style>
@endsection



@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">طلاب الشعبة</a>
    <a href="{{ route('roomlessons',[$room->class_id,$room->id]) }}" class="breadcrumbs__item ">جدول مواد الشعبة</a>
    <a href="{{ route('classroom',$room->class_id) }}" class="breadcrumbs__item ">الشعب</a>
    <a href="{{ route('classes') }}" class="breadcrumbs__item ">قسم الصفوف</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')

<div class="col" style="direction:rtl;text-align:right">
    <div class="card">

<input type="hidden" name="count" id="count" value="{{ $count }}">
            <!-- Card header -->
        <!--    @if(session()->has('success'))-->
        <!--    <div class="alert alert-success text-center"  style="font-size: 20px">-->
        <!--         {{ session()->get('success') }}-->
        <!--    </div>-->
        <!--@endif-->

@auth('web')



@endauth

	 @php
                     function arabic_w2e($str)
{
    $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    return str_replace($arabic_western, $arabic_eastern, $str);
}

                     @endphp

<div class="tabs">
     <h2 style="text-align: center;">{{$lesson->name}}</h2>
       @can('edit_student_marks')
   <a href=".deleteEmployeeModal11" class="dropdown-item" data-toggle="modal"  class="btn" style="  display: inline;    width: 10%; background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;"> اضافة علامة للكل</a>
 
                  <a href=".add_mark" class="dropdown-item" data-toggle="modal" class="btn"
                style="      display: inline;  width: 10%; background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;">
                اضافة علامة تفصيلية  للكل</a>
                
 
 
   @endcan
     <!--<a href="{{ route('StudentsRoomLesson_pdf',[$room->id,$lesson_id]) }}" target="_blank" class="dropdown-item"  class="btn" style="     display: inline;   width: 10%; background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;"> تنزيل pdf  </a>    -->
 @can('Download_excel_for_tags')
   <a href="{{ route('StudentsRoomLesson_excel',[$room->id,$lesson_id]) }}" target="_blank" class="dropdown-item"  class="btn" style="     display: inline;   width: 10%; background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;"> تنزيل اكسل  </a>
 @endcan
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
                    <th rowspan="2"   style="text-align: center;" >الرقم </th>
                      <th rowspan="2"    style="text-align: center;" >الاسم والشهرة </th>
                      <th rowspan="1" colspan="4" style="text-align: center;">اعمال الطالب </th>
                      <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الأعمال </th>
                      <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الامتحان </th>
                      <th rowspan="1"  colspan="1"  style="text-align: center;" > المجموع </th>
                      <th rowspan="2"  colspan="1"  style="text-align: center;" > المحصلة الأولى </th>

                      <th rowspan="2" colspan="1" style="text-align: center;"> ارسال </th>

                  </tr>
                  <tr>

                   <th rowspan="1" colspan="1"  style="text-align: center;">شفهي <br> <span style="color: #f38639;">%١٠</span>  </th>
                    <th rowspan="1" colspan="1" style="text-align: center;"> وظائف   <br> <span style="color: #f38639;">%١٠</span> </th>
                    <th rowspan="1" colspan="1" style="text-align: center;">نشاطات   <br> <span style="color: #f38639;">%٢٠</span></th>
                    <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
                     <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٦٠</span></th>
                    <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
                    <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>
                  </tr>


              </thead>
              <tbody>

                  <tr>
                    @if ($students)
                @foreach (  $students->student as $item  )
                <form  action="{{ route('student_mark') }}"  method="post">
                       @csrf
                    <tr style="text-align: center;" >
                     <input type="hidden" name="term" value="term1">
                      <input type="hidden" name="room_id" value="{{ $room_id }}">
                  <input type="hidden" name="student_id" value="{{$item->id}}">
                  <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
                   <td> {{arabic_w2e( $item->id) }}  </td>
                      <td> {{ $item->first_name }} {{ $item->last_name }} </td>
                          @foreach ($item->student_mark as $item2)
                          <td>
                            @php
                            $decodedData = json_decode($item2->mark);
                          @endphp
                            @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                            <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                            value="" name="oral"
                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                            class="common-input mb-20 form-control" type="number" min="0"
                            data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">

                            @endif
                            @foreach( json_decode($item2->mark,true) as $key=>$item)



                            @if($key == $lesson_id && $item['oral'] !="null" )

                            @if(json_decode($item2->mark,true)[$lesson_id]['oral'] == null)
                            <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['oral']}}" name="oral"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                            @else
                            <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['oral']}}" name="oral"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                            @endif
                            @break

                            @endif

                            @endforeach




                        </td>


                        <td>
                            @php
                            $decodedData = json_decode($item2->mark);
                          @endphp
                            @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                            <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                            value="" name="homework"
                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                            class="common-input mb-20 form-control" type="number" min="0"
                            data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">

                            @endif

                            @foreach( json_decode($item2->mark,true) as $key=>$item)
                            @if($key == $lesson_id && $item['homework'] !="null" )
                            @if(json_decode($item2->mark,true)[$lesson_id]['homework'] == null)
                            <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['homework']}}" name="homework"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                            @else
                            <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['homework']}}" name="homework"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                            @endif
                            @break

                            @endif

                            @endforeach


                        </td>

                        <td>
                            @php
                            $decodedData = json_decode($item2->mark);
                          @endphp
                            @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                            <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                            value="" name="activities"
                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                            class="common-input mb-20 form-control" type="number" min="0"
                            data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">

                            @endif
                            @foreach( json_decode($item2->mark,true) as $key=>$item)
                            @if($key == $lesson_id && $item['activities'] !="null" )
                            @if(json_decode($item2->mark,true)[$lesson_id]['activities'] == null)
                            <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['activities']}}"
                                name="activities" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                            @else
                            <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['activities']}}"
                                name="activities" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                            @endif
                            @break

                            @endif

                            @endforeach


                        </td>

                        <td>
                            @php
                            $decodedData = json_decode($item2->mark);
                          @endphp
                            @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                            <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                            value="" name="quize"
                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                            class="common-input mb-20 form-control" type="number" min="0"
                            data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">

                            @endif
                            @foreach( json_decode($item2->mark,true) as $key=>$item)
                            @if($key == $lesson_id && $item['quize'] !="null" )
                            @if(json_decode($item2->mark,true)[$lesson_id]['quize'] == null)
                            <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['quize']}}" name="quize"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                            @else
                            <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['quize']}}" name="quize"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                            @endif
                            @break

                            @endif

                            @endforeach



                        </td>
                           <td>
                            @if($item2->worke_degree)
                        @foreach( json_decode($item2->worke_degree,true) as $key=>$item)
                        @if(isset($item['term1_result']))
                        @if($key == $lesson_id  && $item['term1_result'] !="null" )
                          {{arabic_w2e($item['term1_result'])}}
                              @break

                      @endif
                      @endif
                       @endforeach
                          @endif
                          </td>
                          <td>
                            @php
                            $decodedData = json_decode($item2->mark);
                          @endphp
                            @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                            <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                            value="" name="exam"
                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                            class="common-input mb-20 form-control" type="number" min="0"
                            data-max="{{$lesson->max_mark*0.4}}" max="{{$lesson->max_mark*0.4}}">

                            @endif
                            @foreach( json_decode($item2->mark,true) as $key=>$item)
                            @if($key == $lesson_id && $item['exam'] !="null" )
                            @if(json_decode($item2->mark,true)[$lesson_id]['exam'] == null)
                            <input class="number"   style="height: 50px; width:60px; border: 1px solid red;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['exam']}}" name="exam"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.4}}" max="{{$lesson->max_mark*0.4}}">
                            @else
                            <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                value="{{ json_decode($item2->mark,true)[$lesson_id]['exam']}}" name="exam"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                class="common-input mb-20 form-control" type="number" min="0"
                                data-max="{{$lesson->max_mark*0.4}}" max="{{$lesson->max_mark*0.4}}">
                            @endif
                            @break

                            @endif

                            @endforeach


                        </td>
                        <td>
                            @if($item2->result1)
                            @foreach( json_decode($item2->result1,true) as $key=>$item)
                            @if($key == $lesson_id && $item['term1_result'] !="null" )
                            @if(json_decode($item2->result1,true)[$lesson_id]['term1_result'] >=$lesson->min_mark)
                            <span>
                                {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}}</span>
                            @else
                            <span style="color: red;
                     text-decoration: underline;">
                                {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}}</span>
                            @endif
                            @break

                            @endif

                            @endforeach
                            @endif
                        </td>
                        <td>
                          @if($item2->result1)
                          @foreach( json_decode($item2->result1,true) as $key=>$item)
                          @if($key == $lesson_id && $item['term1_result'] !="null" )
                          @if(json_decode($item2->result1,true)[$lesson_id]['term1_result'] >=$lesson->min_mark)
                          <span>
                              {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}}</span>
                          @else
                          <span style="color: red;
                   text-decoration: underline;">
                              {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}}</span>
                          @endif
                          @break

                          @endif

                          @endforeach
                          @endif
                      </td>
      <td>
                    @if($item2->key==0)
                      @can('edit_student_marks')
                          <button type="submit" class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;">ارسال </button>
      @endcan
     @endif

                      </td>
                         @endforeach
                  </tr>
                </form>
                @endforeach
                @endif
             </tr>
              </tbody>
            </table>






		  </section>
		   <!-- end mark subject -->
       <section >
        <h2>الفصل الثاني  </h2>


        <table >
          <thead>
              <tr>
                <th rowspan="2"   style="text-align: center;" >الرقم </th>
                  <th rowspan="2"    style="text-align: center;" >الاسم والشهرة </th>
                  <th rowspan="1" colspan="4" style="text-align: center;">اعمال الطالب </th>
                  <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الأعمال </th>
                  <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الامتحان </th>
                  <th rowspan="1"  colspan="1"  style="text-align: center;" > المجموع </th>
                  <th rowspan="2"  colspan="1"  style="text-align: center;" > المحصلة الثانية </th>
                  <th rowspan="2" colspan="1" style="text-align: center;"> مجموع المحصلتين <span style="color:white;"> &#247</span> ٢ </th>
                   <th rowspan="2" colspan="1" style="text-align: center;"> ملاحظات </th>
                  <th rowspan="2" colspan="1" style="text-align: center;"> ارسال </th>

              </tr>
              <tr>

               <th rowspan="1" colspan="1"  style="text-align: center;">شفهي <br> <span style="color: #f38639;">%١٠</span>  </th>
                <th rowspan="1" colspan="1" style="text-align: center;"> وظائف   <br> <span style="color: #f38639;">%١٠</span> </th>
                <th rowspan="1" colspan="1" style="text-align: center;">نشاطات   <br> <span style="color: #f38639;">%٢٠</span></th>
                <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
                 <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٦٠</span></th>
                <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
                <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>
              </tr>


          </thead>
          <tbody>
            @if ($students)
          @foreach (  $students->student as $item  )
            <form  action="{{ route('student_mark') }}"  method="post">
                   @csrf
                <tr style="text-align: center;" >
                 <input type="hidden" name="term" value="term2">
                  <input type="hidden" name="room_id" value="{{ $room_id }}">
              <input type="hidden" name="student_id" value="{{$item->id}}">
              <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
               <td> {{arabic_w2e( $item->id )}}  </td>
                  <td> {{ $item->first_name }} {{ $item->last_name }} </td>

                    @foreach ($item->student_mark as $item2)
                    <td>
                    @php
                      $decodedData = json_decode($item2->mark2);
                    @endphp
                      @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                      <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                      value="" name="oral"
                      onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                      class="common-input mb-20 form-control" type="number" min="0"
                      data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">

                      @endif
                      @foreach( json_decode($item2->mark2,true) as $key=>$item)
                      @if($key == $lesson_id && $item['oral'] !="null" )
                      @if(json_decode($item2->mark2,true)[$lesson_id]['oral'] == null)
                      <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                          value="{{ json_decode($item2->mark2,true)[$lesson_id]['oral']}}" name="oral"
                          onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                          class="common-input mb-20 form-control" type="number" min="0"
                          data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                      @else
                      <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                          value="{{ json_decode($item2->mark2,true)[$lesson_id]['oral']}}" name="oral"
                          onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                          class="common-input mb-20 form-control" type="number" min="0"
                          data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                      @endif
                      @break

                      @endif

                      @endforeach



                  </td>


                  <td>
                    @php
                    $decodedData = json_decode($item2->mark2);
                  @endphp
                    @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                      <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                      value="" name="homework"
                      onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                      class="common-input mb-20 form-control" type="number" min="0"
                      data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">

                      @endif
                      @foreach( json_decode($item2->mark2,true) as $key=>$item)
                      @if($key == $lesson_id && $item['homework'] !="null" )
                      @if(json_decode($item2->mark2,true)[$lesson_id]['homework'] == null)
                      <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                          value="{{ json_decode($item2->mark2,true)[$lesson_id]['homework']}}" name="homework"
                          onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                          class="common-input mb-20 form-control" type="number" min="0"
                          data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                      @else
                      <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                          value="{{ json_decode($item2->mark2,true)[$lesson_id]['homework']}}" name="homework"
                          onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                          class="common-input mb-20 form-control" type="number" min="0"
                          data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                      @endif
                      @break

                      @endif

                      @endforeach



                  <td>
                    @php
                    $decodedData = json_decode($item2->mark2);
                  @endphp
                    @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                      <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                      value="" name="activities"
                      onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                      class="common-input mb-20 form-control" type="number" min="0"
                      data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">

                      @endif
                      @foreach( json_decode($item2->mark2,true) as $key=>$item)
                      @if($key == $lesson_id && $item['activities'] !="null" )
                      @if(json_decode($item2->mark2,true)[$lesson_id]['activities'] == null)
                      <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                          value="{{ json_decode($item2->mark2,true)[$lesson_id]['activities']}}"
                          name="activities" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                          class="common-input mb-20 form-control" type="number" min="0"
                          data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                      @else
                      <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                          value="{{ json_decode($item2->mark2,true)[$lesson_id]['activities']}}"
                          name="activities" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                          class="common-input mb-20 form-control" type="number" min="0"
                          data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                      @endif
                      @break

                      @endif

                      @endforeach


                  </td>

                  <td>
                    @php
                    $decodedData = json_decode($item2->mark2);
                    @endphp
                    @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                      <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                      value="" name="quize"
                      onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                      class="common-input mb-20 form-control" type="number" min="0"
                      data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">

                      @endif
                      @foreach( json_decode($item2->mark2,true) as $key=>$item)
                      @if($key == $lesson_id && $item['quize'] !="null" )
                      @if(json_decode($item2->mark2,true)[$lesson_id]['quize'] == null)
                      <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                          value="{{ json_decode($item2->mark2,true)[$lesson_id]['quize']}}" name="quize"
                          onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                          class="common-input mb-20 form-control" type="number" min="0"
                          data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                      @else
                      <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                          value="{{ json_decode($item2->mark2,true)[$lesson_id]['quize']}}" name="quize"
                          onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                          class="common-input mb-20 form-control" type="number" min="0"
                          data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                      @endif
                      @break

                      @endif

                      @endforeach


                  </td>

                       <td>
                        @if($item2->worke_degree)
                    @foreach( json_decode($item2->worke_degree,true) as $key=>$item)
                    @if($key == $lesson_id && $item['term2_result'] !="null" )
                      {{arabic_w2e($item['term2_result'])}}
                          @break

                  @endif

                   @endforeach
                      @endif
                      </td>
                      <td>
                        @php
                      $decodedData = json_decode($item2->mark2);
                       @endphp
                      @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                        <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                        value="" name="exam"
                        onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                        class="common-input mb-20 form-control" type="number" min="0"
                        data-max="{{$lesson->max_mark*0.4}}" max="{{$lesson->max_mark*0.4}}">

                        @endif
                        @foreach( json_decode($item2->mark2,true) as $key=>$item)
                        @if($key == $lesson_id && $item['exam'] !="null" )
                        @if(json_decode($item2->mark2,true)[$lesson_id]['exam'] == null)
                        <input class="number" style="height: 50px; width:60px; border: 1px solid red;"
                            value="{{ json_decode($item2->mark2,true)[$lesson_id]['exam']}}" name="exam"
                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                            class="common-input mb-20 form-control" type="number" min="0"
                            data-max="{{$lesson->max_mark*0.4}}" max="{{$lesson->max_mark*0.4}}">
                        @else
                        <input class="number" style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                            value="{{ json_decode($item2->mark2,true)[$lesson_id]['exam']}}" name="exam"
                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                            class="common-input mb-20 form-control" type="number" min="0"
                            data-max="{{$lesson->max_mark*0.4}}" max="{{$lesson->max_mark*0.4}}">
                        @endif
                        @break

                        @endif

                        @endforeach


                    </td>

                  <td>
                    @if($item2->result2)
                    @foreach( json_decode($item2->result2,true) as $key=>$item)
                    @if($key == $lesson_id && $item['term2_result'] !="null" )
                    @if(json_decode($item2->result2,true)[$lesson_id]['term2_result'] >=$lesson->min_mark)
                    <span>
                        {{ arabic_w2e(json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</span>
                    @else
                    <span style="color: red;
             text-decoration: underline;">
                        {{ arabic_w2e(json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</span>
                    @endif
                    @break

                    @endif

                    @endforeach
                    @endif
                </td>
                <td>
                  @if($item2->result2)
                  @foreach( json_decode($item2->result2,true) as $key=>$item)
                  @if($key == $lesson_id && $item['term2_result'] !="null" )
                  @if(json_decode($item2->result2,true)[$lesson_id]['term2_result'] >=$lesson->min_mark)
                  <span>
                      {{ arabic_w2e(json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</span>
                  @else
                  <span style="color: red;
           text-decoration: underline;">
                      {{ arabic_w2e(json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</span>
                  @endif
                  @break

                  @endif

                  @endforeach
                  @endif
              </td>


                {{-- <td class="c1" @if($item2->result)
                    @foreach( json_decode($item2->result,true) as $key=>$item)
                    @if($key == $lesson_id && $item['year_result'] !="null" )
                    data-number="{{ json_decode($item2->result,true)[$lesson_id]['year_result'] }}"
                    @break

                    @endif

                    @endforeach
                    @endif ></td> --}}



                <td>
                    @if($item2->result)
                    @foreach( json_decode($item2->result,true) as $key=>$item)
                    @if($key == $lesson_id && $item['year_result'] !="null" )
                    @if(ceil(json_decode($item2->result,true)[$lesson_id]['year_result']
                    /2)>=$lesson->min_mark)
                    {{     arabic_w2e(ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)) }}
                    @else
                    <span style="color: red;
                        text-decoration: underline;">
                        {{     arabic_w2e(ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)) }}
                    </span>
                    @endif
                    @break

                    @endif

                    @endforeach
                    @endif
                </td>
                {{-- <td class="x" @if($item2->result)
                    @foreach( json_decode($item2->result,true) as $key=>$item)
                    @if($key == $lesson_id && $item['year_result'] !="null" )

                        data-id="{{ ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)}}"

                    @break

                    @endif

                    @endforeach
                    @endif></td> --}}
                    <td>
                          <textarea class="form-control" name="notes">
                        @if($item2->notes)
                    @foreach( json_decode($item2->notes,true) as $key=>$item)
                    @if($key == $lesson_id  )
                      {{$item}}
                          @break

                  @endif

                   @endforeach
                      @endif
                      </textarea>
                      </td>
                      <td>
                @if($item2->key==0)
                 @can('edit_student_marks')
                      <button type="submit" class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;">ارسال </button>
 
  @endcan
  @endif

                    </td>
                     @endforeach
              </tr>
            </form>
           @endforeach
           @endif
          </tbody>
        </table>




             </section>
        <!-- end mark subject -->



		 <!-- start  mark subject -->

			<!-- start mark subject-->


	</div>
  </div>
     <div class="modal fade  add_mark">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="" method="POST" action="{{route('student_mark_admin_details')}}">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title"> اضافة تفصيلات  </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>حدد العلامة </p>
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <input type="text" hidden name="lesson_id" value="{{$lesson->id}}">

                            <select name="term"  class="form-control">
                                <option value="term1">
                                    فصل اول
                                </option>
                                <option value="term2">
                                    فصل ثاني
                                </option>
                            </select>
                            <br>
                             <table style="text-align: center;">
                        <thead style="text-align: center;">
                         
                            <tr>
                                <th rowspan="1" colspan="1" style="text-align: center;">شفوية <br> <span
                                        style="color: #f38639;">%١٠</span> </th>
                                <th rowspan="1" colspan="1" style="text-align: center;"> وظائف و اوراق عمل <br> <span
                                        style="color: #f38639;">%١٠</span> </th>
                                <th rowspan="1" colspan="1" style="text-align: center;"> نشاطات و مبادرات <br> <span
                                        style="color: #f38639;">%٢٠</span></th>
                                <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات <br> <span
                                        style="color: #f38639;">%٢٠</span></th>
                                <th rowspan="1" colspan="1" style="text-align: center;"> امتحانات <br><span
                                        style="color: #f38639;">%٤٠</span>
                                </th>
                             
                                </th>

                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            <tr>
                                <td>
                                       <input class="number"
                                            style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                             name="oral"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                            class="common-input mb-20 form-control" type="number" min="0"
                                            data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                                </td>
                                  <td>
                                       <input class="number"
                                            style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                             name="homework"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                            class="common-input mb-20 form-control" type="number" min="0"
                                            data-max="{{$lesson->max_mark*0.1}}" max="{{$lesson->max_mark*0.1}}">
                                </td>
                                  <td>
                                       <input class="number"
                                            style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                             name="activities"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                            class="common-input mb-20 form-control" type="number" min="0"
                                            data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                                </td>
                                  <td>
                                       <input class="number"
                                            style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                             name="quize"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                            class="common-input mb-20 form-control" type="number" min="0"
                                            data-max="{{$lesson->max_mark*0.2}}" max="{{$lesson->max_mark*0.2}}">
                                </td>
                                  <td>
                                       <input class="number"
                                            style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                             name="exam"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                            class="common-input mb-20 form-control" type="number" min="0"
                                            data-max="{{$lesson->max_mark*0.4}}" max="{{$lesson->max_mark*0.4}}">
                                </td>
                            </tr>
                        </tbody>
                        </table>   
                        </div>
                        <div class="modal-footer">
                        

                            <button class="btn" type="submit">تم</button>


                        </div>
                    </form>
                </div>
            </div>
        </div> 
 <div class="modal fade deleteEmployeeModal11">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <form id="" method="POST" action="{{route('student_mark_admin')}}" >
                           @csrf
                              <div class="modal-header">
                                  <h4 class="modal-title">  اضافة علامة </h4>
                                  <button type="button" class="close" data-dismiss="modal"
                                      aria-hidden="true">&times;</button>
                              </div>
                              <div class="modal-body">
                                  <p>حدد العلامة  </p>
                                  <input type="hidden" name="room_id" value="{{ $room->id }}">
                                   <input type="text" hidden name="lesson_id" value="{{$lesson->id}}" >

                                   <select name="term" class="form-control ">
                                       <option value="term1">
                                           فصل اول
                                       </option>
                                        <option value="term2">
                                           فصل ثاني
                                       </option>
                                   </select>
                                   <br>
                                  <input type="number" class="common-input mb-20 form-control " name="mark" max="{{$lesson->max_mark}}" min="0" >
                              </div>
                              <div class="modal-footer">
                                  <input type="button" class="btn btn-default" data-dismiss="modal"
                                      value="الغاء">

                                  <button class="btn" type="submit">تم</button>


                              </div>
                          </form>
                      </div>
                  </div>
              </div>

                <div class="modal fade deleteEmployeeModal">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <form id="form_delete" method="POST">
                              @csrf
                              @method('delete')
                              <div class="modal-header">
                                  <h4 class="modal-title">Delete element</h4>
                                  <button type="button" class="close" data-dismiss="modal"
                                      aria-hidden="true">&times;</button>
                              </div>
                              <div class="modal-body">
                                  <p>Are you sure you want to delete these Records?</p>
                                  <p class="text-warning"><small>This action cannot be undone.</small></p>
                              </div>
                              <div class="modal-footer">
                                  <input type="button" class="btn btn-default" data-dismiss="modal"
                                      value="Cancel">

                                  <button class="btn btn-danger">Delete</button>


                              </div>
                          </form>
                      </div>
                  </div>
              </div>

      </div>
  </div>
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).on('keyup', '.number', function () {

    if($(this).val()>$(this).data('max') || $(this).val()==""){
        alert('لايمكن وضع القيمة');
        $(this).val("");
    }


})

</script>
                  <script>
  $(document).on('click','.one',function(e){

e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('student_mark') }}",
    enctype:'multipart/form-data',
    data: $(this).parent().parent().find('form:first').serialize(),
    success:function(data){
console.log(data);
swal({
  title: "حسنا",
  text: "! تمت العملية بنجاح",
  icon: "success",
  button: "OK",
  timer: 2000

});
    },
    error: function (xhr) {

}

});




    });
                      $(document).ready(function () {
                          $('#mydiv2').hide();
                          $('#mydiv3').hide();

                      $('.delete').on('click', function () {
                          var id = $(this).data('id');
                          var url = "{{URL::to('SMARMANger/admin/students')}}";
                          $('#form_delete').attr("action", url);


                      });

                      $('.mydiv2').on('click', function () {
                          $('#mydiv2').show();

                          $('#mydiv').hide();
                          $('#mydiv3').hide();


                      });

                      $('.mydiv').on('click', function () {
                          $('#mydiv').show();

                          $('#mydiv2').hide();
                          $('#mydiv3').hide();


                      });

                      $('.mydiv3').on('click', function () {
                          $('#mydiv3').show();

                          $('#mydiv').hide();

                          $('#mydiv2').hide();


                      });




                      });
                      </script>






                    @endsection
