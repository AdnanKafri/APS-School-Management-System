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
button.close {
 margin: 0px !important;
padding: 0px !important;
float: left !important;
}
/* demo */
.toast-message{
    text-align: right;
}

</style>
@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">الجلاءات -  طلاب الشعبة- </a>
    <a  href="{{ route('classroom_graduate',$room->class_id) }}" class="breadcrumbs__item " >قسم الجلاءات - الشعب - </a>
    <a href="{{ route('classes.graduation') }}" class="breadcrumbs__item "> قسم الجلاءات - الصفوف </a>

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


                     @endphp
      <div class="tabs">
            @can('add_general_details_of_the_division')
           <a href=".report_card_details" class="dropdown-item" data-toggle="modal"  class="btn" style="      display: inline;  width: 10%; background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;margin-left: 13px;"> تفصيلات عامة</a>

               <a href=".global_mark" class="dropdown-item" data-toggle="modal"  class="btn" style="      display: inline;  width: 10%; background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;margin-left: 13px;">علامة السلوك و المشروع</a>


           <a href=".report_teacher_name" class="dropdown-item" data-toggle="modal"  class="btn" style="      display: inline;  width: 10%; background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;">  اضافة اسم المعلم </a>
             @endcan
           &nbsp;  &nbsp; &nbsp;
   {{-- <a href="" target="_blank" class="dropdown-item"  class="btn" style="     display: inline;   width: 10%; background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;"> تنزيل اكسل  </a> --}}

   <h2 class="mb-0" style="color: #001586;text-align: center">جدول جلاءات   / الصف {{ $class_name }} /الشعبة {{ $room_name }} </h2>


  <input type="radio" id="tab1" name="tab-control" checked>
  <input type="radio" id="tab2" name="tab-control">
  <input type="radio" id="tab3" name="tab-control">

  {{-- <ul>
    <li title="الفصل الأول "><label for="tab1" role="button"><svg viewBox="0 0 24 24"><path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
      </svg>
        <span>الفصل الأول</span></label></li> &nbsp;&nbsp;&nbsp;&nbsp;

        <li title="الفصل الثاني "><label for="tab2" role="button"><br><svg viewBox="0 0 24 24"><path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
        </svg>
          <span>الفصل الثاني</span></label></li>&nbsp;&nbsp;&nbsp;&nbsp;



</ul> --}}




	<div class="content">
    <section >
			<h2>الفصل الأول</h2>
      <table >
        <thead>
            <tr>
                <th rowspan="2"    style="text-align: center;width:8%" >الاسم </th>
                <th  rowspan="2"  style="text-align: center;" >ملاحظة المدير  </th>
                <th rowspan="1" colspan="2" style="text-align: center;"> ملاحظة  الاستاذ </th>
                <th rowspan="1"  colspan="2"  style="text-align: center;">دوام الطالب </th>
                <th rowspan="1"  colspan="2"  style="text-align: center;"> الغياب المبرر </th>
                <th rowspan="1"  colspan="2"  style="text-align: center;"> الغياب الغير المبرر </th>
                <th rowspan="2"  colspan="1"  style="text-align: center;">العمليات  </th>

            </tr>
            <tr>
              <th rowspan="1" colspan="1" style="text-align: center;"> الفصل الأول   </th>
              <th rowspan="1" colspan="1" style="text-align: center;">  الفصل الثاني</th>
              <th rowspan="1" colspan="1" style="text-align: center;"> الفصل الأول   </th>
              <th rowspan="1" colspan="1" style="text-align: center;">الفصل الثاني</th>
              <th rowspan="1" colspan="1" style="text-align: center;"> الفصل الأول   </th>
              <th rowspan="1" colspan="1" style="text-align: center;">الفصل الثاني</th>
              <th rowspan="1" colspan="1" style="text-align: center;"> الفصل الأول   </th>
              <th rowspan="1" colspan="1" style="text-align: center;">الفصل الثاني</th>
            </tr>


        </thead>
        <tbody>
            @foreach (  $students as  $item  )
            @php
                $status = '';
                $final_result = isset($item->report_card)  ? $item->report_card->final_result: '' ;
                if ($final_result == 3 )
                    $status = 'color: #fff;
                               background: #ed5850de;' ;
                elseif($final_result == 2)
                $status = 'color: #fff;
                           background: #3ceb65;' ;
                else
                    $status = 'black'

            @endphp
          <form  action="{{ route('store_report_card_details') }}"  method="post">
                 @csrf
            <tr>

                <input type="hidden" name="student_id" value="{{$item->id}}">
                 <input type="hidden" name="class_id" value="{{$room->class_id}}">

                <td style="{{ $status }}"> {{ $item->first_name }} {{ $item->last_name }} </td>



                <td >
                      <textarea  cols="6" rows="5" name="manager_notes"  class="common-input mb-20 form-control"     >
                        {{ isset($item->report_card)  ? $item->report_card->manager_notes: ''  }}
                    </textarea>
                </td>


                <td >
                    <textarea  cols="6" rows="5" name="teacher_notes1"  class="common-input mb-20 form-control"     >
                        {{ isset($item->report_card)  ? json_decode($item->report_card->teacher_notes)->{'term1'} : ''  }}
                    </textarea>
                </td>
                <td >
                    <textarea  cols="6" rows="5" name="teacher_notes2"  class="common-input mb-20 form-control"     >
                        {{ isset($item->report_card)  ? json_decode($item->report_card->teacher_notes)->{'term2'} : ''  }}
                    </textarea>
                </td>

                <td  style="text-align: center;">
                    @if( isset($item->report_card) )
                        <input name="student_attendance1" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value=" {{ isset($item->report_card->student_attendance)  ? json_decode($item->report_card->student_attendance)->{'term1'} : ''  }}"    max="{{ isset($item->report_card->actual_attendance)  ? json_decode($item->report_card->actual_attendance)->{'term1'} : ''  }}" min="0" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                    @else
                        <input name="student_attendance1" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value=" "  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                    @endif
                </td>
                <td  style="text-align: center;">
                    @if( isset($item->report_card) )
                        <input name="student_attendance2" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value="  {{ isset($item->report_card->student_attendance)  ? json_decode($item->report_card->student_attendance)->{'term2'} : ''  }}"  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  max="{{ isset($item->report_card->actual_attendance)  ? json_decode($item->report_card->actual_attendance)->{'term2'} : ''  }}" type="text"     >
                     @else
                        <input name="student_attendance2" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value=" "  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                    @endif
                </td>
                <td  style="text-align: center;">
                    @if( isset($item->report_card) )
                        <input name="justified_absence1" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value="  {{ isset($item->report_card->justified_absence)  ? json_decode($item->report_card->justified_absence)->{'term1'} : ''  }}"  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                     @else
                        <input name="justified_absence1" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value=" "  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                    @endif
                </td>
                <td  style="text-align: center;">
                    @if( isset($item->report_card) )
                        <input name="justified_absence2" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value="  {{ isset($item->report_card->justified_absence)  ? json_decode($item->report_card->justified_absence)->{'term2'} : ''  }}"  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                     @else
                        <input name="justified_absence2" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value=" "  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                    @endif
                </td>
                <td  style="text-align: center;">
                    @if( isset($item->report_card) )
                        <input name="unjustified_absence1" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value="  {{ isset($item->report_card->unjustified_absence)  ? json_decode($item->report_card->unjustified_absence)->{'term1'} : ''  }}"  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                     @else
                        <input name="unjustified_absence1" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value=" "  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                    @endif
                </td>
                <td  style="text-align: center;">
                    @if( isset($item->report_card) )
                        <input name="unjustified_absence2" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value="  {{ isset($item->report_card->unjustified_absence)  ? json_decode($item->report_card->unjustified_absence)->{'term2'} : ''  }}"  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                     @else
                        <input name="unjustified_absence2" style="height: 50px; width:60px;border: 1px solid #e9d8db;" value=" "  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control"  type="text"     >
                    @endif
                </td>


                <td>
                    @can('add_general_details_of_the_division')
                    <button type="submit" class="btn" style=" background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);color :white;">حفظ </button>
                     @endcan
                 <!--@can('determine_student_success')-->
                 <!--   <a href=".student_pass_check_by_admin " class="btn student_pass" data-toggle="modal"-->
                 <!--   data-id="{{ $item->id }}"  data-name="{{ $item->first_name.' '.$item->last_name }}"-->
                 <!--   style=" background: linear-gradient(to right top, #067260 20%, #84a7c4);color :white;"-->
                 <!--   title="تحديد نجاح الطالب">-->
                 <!--        <i class="fa fa-archive" aria-hidden="true"></i>-->
                 <!--   </a>-->
                 <!--@endcan-->
                    @if($room->classes->report_card == 4)
                    <a href=".student_pass_check_by_admin_9" class="btn student_pass" data-toggle="modal"
                    data-id="{{ $item->id }}"  data-name="{{ $item->first_name.' '.$item->last_name }}"
                    style=" background: linear-gradient(to right top, #067260 20%, #84a7c4);color :white;"
                    title="تحديد نجاح الطالب">
                         <i class="fa fa-archive" aria-hidden="true"></i>
                    </a>
                    @endif
                    @if (isset( $item->report_card) && isset($report_card_details))
                        <a href=".show_report_card" class="btn student_pass" data-toggle="modal"
                        data-id="{{ $item->id }}"  data-name="{{ $item->first_name.' '.$item->last_name }}"
                        style=" background: linear-gradient(to right top, #067260 20%, #84a7c4);color :white;"
                        title="استعراض جلاء الطالب  ">
                        <i class="fa fa-graduation-cap  super_{{ $item->id }}" style="color: #fff" id="super_{{ $item->id }}"></i>
                        </a>



                                   {{-- <a href=".show_assistance_lesson_mark" class="btn student_pass" data-toggle="modal"
                        data-id="{{ $item->id }}"  data-name="{{ $item->first_name.' '.$item->last_name }}"
                        style=" background: linear-gradient(to right top, #067260 20%, #84a7c4);color :white;"
                        title="اضافة علامة مساعدة">
                        <i class="fa fa-flag  super_{{ $item->id }}" style="color: #fff" id="super_{{ $item->id }}"></i>
                        </a> --}}


                    @endif


                </td>

            </tr>
          </form>
          @endforeach




        </tbody>
      </table>





		  </section>
		   <!-- end mark subject -->


	</div>
  </div>

  <div class="modal fade student_pass_check_by_admin_9">
  <div class="modal-dialog">
      <div class="modal-content">
          <form id="" action="{{ route('student_pass_check_by_admin_9') }}" method="POST" >
              @csrf
              <input type="hidden" name="student_id" class="form-control student_id"
              value="{{ $room->id }}" >

              <div class="modal-header">
                  <h4 class="modal-title"> تحديد نجاح الطالب    </h4>
                  <button type="button" class="close" data-dismiss="modal"
                      aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body" style="direction: rtl">
                  <div class="form-group" style="text-align: right    ">
                      <label> اسم الطالب</label>
                      <input type="text"  class="form-control student_name"
                          value="" style="direction: rtl"
                        readonly>

                  </div>
                  <div class="form-group" style="text-align:right">
                    <label>   حالة الطالب  </label>
                     <select name="is_passed" id="is_passed_9" class="form-control "
                        style="min-height: 36px;direction: rtl" required>
                        <option value="8" hidden>هل الطالب ناجح أم راسب         </option>

                            <!--<option value="2" >ناجح نجاح فصلي   </option>-->
                            <option value="1">ناجح  </option>
                            <option value="2">  راسب</option>

                    </select>
                </div>
                @if( $room->classes->report_card ==4)
                 <div class="form-group select_class_9 " style="text-align:right ; display :none" >
                      <select name="select_class" id="select_class" class="form-control "
                        style="min-height: 36px;direction: rtl" required>
                        <!--<option value="8" hidden>   اختر الصف    </option>-->

                            @foreach($classes as $item )
                            @if($item->report_card==5 ||  $item->report_card==6)
                            <option value="{{$item->id}}"> {{$item->name}} </option>
                            @endif
                            @endforeach


                    </select>
                    <!--<div class="form-group" id="">-->
                    <!--    <label>الشعبة</label>-->
                    <!--    <select name="room_id" id="room_id_filter" class="form-control dep"-->
                    <!--        style="min-height: 36px;direction: rtl" required>-->
                    <!--        <option value="">اختر الشعبة الدراسية</option>-->
                    <!--    </select>-->
                    <!--</div>-->
                     </div>
                     @endif



                  </div>


                  <div class="modal-footer" style="justify-content: right;">
                    <button class="btn btn-success btn-block ml-1">حفظ</button>
                    <a class="btn btn-default  btn-block m-0" data-dismiss="modal" style="color: #000;background:#eee !important;">الغاء </a>
                </div>
          </form>
      </div>
  </div>
</div>
  <div class="modal fade student_pass_check_by_admin">
  <div class="modal-dialog">
      <div class="modal-content">
          <form id="" action="{{ route('student_pass_check_by_admin') }}" method="POST" >
              @csrf
              <input type="hidden" name="student_id" class="form-control student_id"
              value="{{ $room->id }}" >

              <div class="modal-header">
                  <h4 class="modal-title"> تحديد نجاح الطالب    </h4>
                  <button type="button" class="close" data-dismiss="modal"
                      aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body" style="direction: rtl">
                  <div class="form-group" style="text-align: right    ">
                      <label> اسم الطالب</label>
                      <input type="text"  class="form-control student_name"
                          value="" style="direction: rtl"
                        readonly>

                  </div>
                  <div class="form-group" style="text-align:right">
                    <label>   حالة الطالب  </label>
                     <select name="is_passed" id="" class="form-control is_passed"
                        style="min-height: 36px;direction: rtl" required>
                        <option value="8" hidden>هل الطالب ناجح أم راسب         </option>

                            <!--<option value="2" >ناجح نجاح فصلي   </option>-->
                            <option value="1">ناجح سيتم التأكد بشكل تلقائي</option>
                            <option value="0">  راسب</option>

                    </select>
                </div>

                {{-- <div class="form-check">
                    <label class="form-check-label" for="flexCheckDefault">
                        تأكيد رسوب الطالب
                    </label>
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                  </div> --}}
                  </div>


                  <div class="modal-footer" style="justify-content: right;">
                    <button class="btn btn-success btn-block ml-1">حفظ</button>
                    <a class="btn btn-default  btn-block m-0" data-dismiss="modal" style="color: #000;background:#eee !important;">الغاء </a>
                </div>
          </form>
      </div>
  </div>
</div>





  <div class="modal fade show_report_card">
  <div class="modal-dialog">
      <div class="modal-content">
          <form id="" action="{{ route('view_single_student_graduate') }}" method="POST" >
              @csrf
              <input type="hidden" name="student_id" class="form-control student_id"
              value="{{ $room->id }}" >

              <div class="modal-header">
                  <h4 class="modal-title"> استعراض جلاء الطالب   </h4>
                  <button type="button" class="close" data-dismiss="modal"
                      aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body" style="direction: rtl">
                  <div class="form-group" style="text-align: right    ">
                      <label> اسم الطالب</label>
                      <input type="text"  class="form-control student_name"
                          value="" style="direction: rtl"
                        readonly>

                  </div>
                  <div class="form-group" style="text-align:right">
                    <label>   اختر العام الدراسي   </label>
                     <select name="year_id" id="" class="form-control year_id"
                        style="min-height: 36px;direction: rtl" required>
                        <option value="" hidden> حدد العام الدراسي   </option>
                            @foreach ($years as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach

                    </select>
                </div>


              </div>

                  <div class="modal-footer" style="justify-content: right;">
                    <button class="btn btn-success btn-block ml-1 not-disabled">حفظ</button>
                    <a class="btn btn-default  btn-block m-0" data-dismiss="modal" style="color: #000;background:#eee !important;">الغاء </a>
                </div>
          </form>
      </div>
  </div>
</div>





















<div class="modal fade report_card_details">
  <div class="modal-dialog">
      <div class="modal-content">
          <form id="" action="{{ route('store_all_student_notes') }}" method="POST" >
              @csrf
              <input type="hidden" name="room_id" class="form-control room_id"
              value="{{ $room->id }}" >

              <div class="modal-header">
                  <h4 class="modal-title"> تفاصيل الجلاء    </h4>
                  <button type="button" class="close" data-dismiss="modal"
                      aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body" style="direction: rtl">
                  <div class="form-group" style="text-align: right    ">
                      <label> تفصيلات الجلاء لكل الشعبة </label>
                      <input type="text"  class="form-control student_name"
                          value="{{ $room_name }}" style="direction: rtl"
                        readonly>

                  </div>
                  <div  style="text-align:right">
                      <table   dir="rtl" class="table table-striped">
                          <thead>


                              <tr>

                                <th colspan="1" rowspan="2" style="text-align: center;">الدوام المدرسي </th>
                                <th colspan="1" rowspan="2" style="text-align: center;"> الدوام الفعلي </th>
                                <th colspan="1" rowspan="2"  style="text-align: center;"> دوام التلميذ </th>
                                <th  rowspan="1"  colspan="2"  style="text-align: center;"> الغياب </th>
                                {{-- <th rowspan="2"> النسبة المؤية للدوام </th> --}}
                              </tr>
                              <tr>

                                <th colspan="1" style="text-align: center;">مبرر</th>
                                <th colspan="1" style="text-align: center;">غير مبرر</th>
                              </tr>


                          </thead>
                          <tbody>


                              <tr>

                                  <td> الفصل الأول</td>
                                  <td >
                                   <input style="height: 50px; width:50px" name="actual_attendance1" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                       class="common-input mb-20 form-control actual_attendance1"  type="text"
                                       value=" "
                                   readonly></td>
                                  <td>
                                   <input style="height: 50px; width:50px" name="student_attendance1" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                       class="common-input mb-20 form-control student_attendance1"  type="text"
                                       value=" "
                                   ></td>

                                   <td>
                                   <input name="justified_absence1" style="height: 50px; width:50px"
                                   class="form-control justified_absence1"
                                       value=" "
                                   >   </td>
                                   <td>
                                   <input name="unjustified_absence1" style="height: 50px; width:50px"
                                   class="form-control unjustified_absence1"
                                   value=" "
                                   > </td>
                                   {{-- <td> <input class="form-control term1_attendance_percent" style="width: 60px;height:50px " value=" "> </td> --}}
                              </tr>



                              <tr>

                                 <td> الفصل الثاني </td>
                                <td><input style="height: 50px; width:50px" name="actual_attendance2" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                   class="common-input mb-20 form-control actual_attendance2"  type="text"
                                   value=""
                                   readonly></td>
                                <td><input style="height: 50px; width:50px" name="student_attendance2" onfocus="this.placeholder = ''" onblur="this.placeholder = ''"
                                    class="common-input mb-20 form-control student_attendance2"  type="text"
                                    value=""
                                    ></td>
                                <td> <input name="justified_absence2" style="height:50px; width:50px" class="form-control justified_absence2"
                                   value=""
                                   > </td>
                                <td> <input name="unjustified_absence2" style="height: 50px;width:50px" class="form-control unjustified_absence2"
                                   value=""
                                   >  </td>
                                {{-- <td> <input style="height: 50px; width:60px" class="form-control term2_attendance_percent" value=""> </td> --}}
                            </tr>


                          {{-- <form>
                            <tr >

                              <td> المجموع </td>
                              <td class="text-center total_actual_attendance"></td>
                              <td class="text-center total_student_attendance"> </td>
                              <td class="text-center total_justified_absence"></td>
                              <td class="text-center total_unjustified_absence"></td>
                             <td class="text-center total_attendance_percent">  </td>
                          </tr>
                        </form> --}}

                          </tbody>
                        </table>
                    </div>

                    <div class="form-group" style="text-align:right">
                        <label> ملاحظة المدير  </label>
                        <input type="text" name="manager_notes" class="form-control"
                            value="" style="direction: rtl"
                            placeholder="يرجى إدخال الملاحظة " >
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label> ملاحظة الاستاذ للفصل الأول</label>
                        <input type="text" name="teacher_notes1" class="form-control"
                            value="" style="direction: rtl"
                            placeholder="يرجى إدخال الملاحظة " >
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label> ملاحظة الاستاذ للفصل الثاني</label>
                        <input type="text" name="teacher_notes2" class="form-control"
                            value="" style="direction: rtl"
                            placeholder="يرجى إدخال الملاحظة " >
                    </div>




              </div>
              <div class="modal-footer">
                  <a class="btn btn-dark" style="color: #fff" data-dismiss="modal">الغاء</a>
                  <button class="btn btn-primary">حفظ</button>
              </div>
          </form>
      </div>
  </div>
</div>

<div class="modal fade report_teacher_name">
  <div class="modal-dialog">
      <div class="modal-content">
          <form id="" action="{{ route('report_teacher_name') }}" method="POST" >
              @csrf
              <div class="modal-header">
                  <h4 class="modal-title"> تفاصيل الجلاء    </h4>
                  <button type="button" class="close" data-dismiss="modal"
                      aria-hidden="true">&times;</button>
              </div>
              <input type="hidden" name="room_id" class="form-control room_id"
              value="{{ $room->id }}" >
                <div class="modal-body" style="direction: rtl">

                    <div class="form-group" style="text-align:right">
                        <label>   اضافة اسم المعلم </label>
                        <input type="text" name="teacher_name"  required  class="form-control"
                            value="" style="direction: rtl"
                            placeholder="يرجى إدخال الاسم  " >
                    </div>

              </div>
              <div class="modal-footer">
                  <a class="btn btn-dark" style="color: #fff" data-dismiss="modal">الغاء</a>
                  <button class="btn btn-primary">حفظ</button>
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

$(document).on('change', '.lessons', function () {




})
$(document).on('keyup', '.number', function () {

    if($(this).val()>$(this).data('max') || $(this).val()==""){
        alert('لايمكن وضع القيمة');
        $(this).val("");
    }


})
$(document).on('change', '#is_passed_9', function () {
    if($(this).val()==1){
        $('.select_class_9').show();
    }
    else{
        $('.select_class_9').hide();
    }


})
$(document).on('click', '.student_pass', function () {
let student_id = $(this).data('id') ;
let student_name = $(this).data('name') ;
let is_passed = $(this).data('is_passed') ;
$('.student_id').val(student_id);
$('.student_name').val(student_name);
$('.is_passed').val(8);


})
$(document).on('click', '.student_report_card', function () {
let student_id = $(this).data('id') ;
let student_name = $(this).data('name') ;
$('.student_id').val(student_id);
$('.student_name').val(student_name);

})

</script>
                  <script>
  $(document).on('click','.one',function(e){
    alert(152)
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

                      </script>






                    @endsection
