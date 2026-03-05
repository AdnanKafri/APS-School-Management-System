@extends('supervisors.layouts.new_app')
@section('css')
<style>
  	 /*table */
       table {
  border-spacing: 1;
  border-collapse: collapse;
  background: linear-gradient(to right top, #2c71ad 50%, rgb(132, 167, 196));
  border-radius: 6px;
  overflow: hidden;
  max-width: 990px;
  width: 100%;
  margin: 0 auto;
  position: relative;
 /* margin-top: -170px;
  margin-bottom: 100px;*/
  direction: rtl;


}
table * {
  position: relative;
}
table td, table th {
  padding-left: 8px;

}
table thead tr {
  height: 60px;
  background: white;
  font-size: 22px;
  color: #f38639;
  border-style: solid ;
  border-color: #094e89;


}
table tbody tr {
  height: 48px;
  font-size: 18px;
  /*border-bottom: 1px solid #f38639;*/

  color: white;
}
table tbody tr:last-child {
  border: 0;
  border-radius: 15px;
}
table td, table th {
  text-align: center;
}
table td.l, table th.l {
  text-align: center;
}
table td.c, table th.c {
  text-align: center;
}
table td.r, table th.r {
  text-align: center;
}
@media screen and (max-width: 35.5em) {
  table {
    display: block;
  }
  table > *, table tr, table td, table th {
    display: block;
  }
  table thead {
    display: none;
  }
  table tbody tr {
    height: auto;
    padding: 8px 0;
  }
  table tbody tr td {
    padding-right: 45%;
    margin-bottom: 12px;
  }
  table tbody tr td:last-child {
    margin-bottom: 0;
  }
  table tbody tr td:before {
    position: absolute;
    font-weight: 700;
    width: 40%;
    right: 10px;
    top: 0;
  }
  table tbody tr td:nth-child(1):before {
    content: "اسم الامتحان ";
	color: #094e89;
  }
  table tbody tr td:nth-child(2):before {
    content: "وقت البداية ";
	color: #094e89;

  }
  table tbody tr td:nth-child(3):before {
    content: "وقت النهاية ";
	color: #094e89;
  }
  table tbody tr td:nth-child(4):before {
    content: "عرض العلامات ";
	color: #094e89;
  }


}

.container2 th h1 {
	  font-weight: bold;
	  font-size: 1em;
  text-align: center;
  color: #185875;
}

.container2 td {
	  font-weight: normal;
	  font-size: 1em;
  -webkit-box-shadow: 0 2px 2px -2px #0E1119;
	   -moz-box-shadow: 0 2px 2px -2px #0E1119;
	        box-shadow: 0 2px 2px -2px #0E1119;
}

.container2 {
	  text-align: center;
	  overflow: hidden;
	  width: 70%;
	  margin: 0 auto;
  display: table;
  padding: 0 0 8em 0;
}

.container2 td, .container2 th {
	  padding-bottom: 2%;
	  padding-top: 2%;
  /*padding-left:5%; */
}

/* Background-color of the odd rows */
.container2 tr:nth-child(odd) {
	  background-color: #323C50;
}

/* Background-color of the even rows */
.container2 tr:nth-child(even) {
	  background-color: #2C3446;
}

.container2 th {
	  background-color: #1F2739;
}

.container2 td:first-child { color: #FB667A; }

.container2 tr:hover {
   background-color: #464A52;
-webkit-box-shadow: 0 6px 6px -6px #0E1119;
	   -moz-box-shadow: 0 6px 6px -6px #0E1119;
	        box-shadow: 0 6px 6px -6px #0E1119;
}

.container2 td:hover {
  background-color: #FFF842;
  color: #403E10;
  font-weight: bold;

  box-shadow: #7F7C21 -1px 1px, #7F7C21 -2px 2px, #7F7C21 -3px 3px, #7F7C21 -4px 4px, #7F7C21 -5px 5px, #7F7C21 -6px 6px;
  transform: translate3d(6px, -6px, 0);

  transition-delay: 0s;
	  transition-duration: 0.4s;
	  transition-property: all;
  transition-timing-function: line;
}

@media (max-width: 1020px) {
.container2 td:nth-child(9),
.container2 th:nth-child(9) { display: none; }
}
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
	 background: #428bff;
	 margin-top: 5px;
	 left: 1px;
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label svg {
	 fill: #428bff;
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
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label svg {
	 fill: #428bff;
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
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label svg {
	 fill: #428bff;
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
                        <h1 class="mb-0 bread">جميع العلامات
            </div>
        </div>
    </div>
</section>
<!-- start new-->


<br>
<br>


<br>
<br>
<!--- tablist for total marks -->
<!-- marks of subjects -->

<div class="tabs">

    <input type="radio" id="tab1" name="tab-control" checked>
    <input type="radio" id="tab2" name="tab-control">
    <input type="radio" id="tab3" name="tab-control">

    <ul>
        <li title="الفصل الأول"><label for="tab1" role="button"><svg viewBox="0 0 24 24">
                    <path
                        d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                </svg>
                <span>الفصل الأول</span></label></li> &nbsp;&nbsp;&nbsp;&nbsp;

        <li title="الفصل الثاني "><label for="tab2" role="button"><br><svg viewBox="0 0 24 24">
                    <path
                        d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                </svg>
                <span>الفصل الثاني</span></label></li>&nbsp;&nbsp;&nbsp;&nbsp;

        <li title="المحصلة "><label for="tab3" role="button"><br><svg viewBox="0 0 24 24">
                    <path
                        d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                </svg>
                <span>المحصلة</span></label></li>

    </ul>


    <div class="">
        <div class="indicator"></div>
    </div>

    <div class="content">
        <section>
            <h2>الفصل الأول</h2>
            <table class="" >
                <thead>
                    <tr>
                        <th>
                             اسم الطالب
                        </th>
                        <th>
                          الهاتف
                        </th>
                        <th>
                           الشفهي
                        </th>
                        <th>
                            الوظائف
                        </th>
                        <th>
                            النشاط
                        </th>
                        <th>
                             المذاكرة
                        </th>
                        <th>
                             الامتحان الفصلي
                        </th>
                        {{-- <th>
                             ارسال
                        </th> --}}


                    </tr>
                </thead>
                <tbody>
@foreach (  $students as $item  )
<tr>
    <td>{{ $item->first_name }} {{ $item->last_name }}   </td>
    <td>{{ $item->phone }}</td>


            <input type="hidden" name="term" value="term1">
                <input type="hidden" name="room_id" value="{{ $room_id }}">
            <input type="hidden" name="student_id" value="{{$item->id}}">
            <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
            @foreach ($item->student_mark as $item2)

            <td><input type="text" class="common-input mb-20 form-control"  style="height: 50px; width:60px" value="{{ json_decode($item2->mark,true)[$lesson_id]['oral']}}" name="oral" id="" readonly></td>

            <td><input type="text"  class="common-input mb-20 form-control"  style="height: 50px; width:60px" value="{{ json_decode($item2->mark,true)[$lesson_id]['homework'] }}" name="homework" id="" readonly></td>
            <td><input type="text" class="common-input mb-20 form-control"  style="height: 50px; width:60px" value="{{json_decode($item2->mark,true)[$lesson_id]['activities']}}" name="activities" id="" readonly></td>
            <td><input type="text"class="common-input mb-20 form-control"  style="height: 50px; width:60px" value="{{json_decode($item2->mark,true)[$lesson_id]['quize']}}" name="quize" id="" readonly></td>
            <td><input type="text"  class="common-input mb-20 form-control" style="height: 50px; width:60px" value="{{ json_decode($item2->mark,true)[$lesson_id]['exam'] }}" name="exam" id="" readonly></td>


            {{-- <td><button   type="submit" class="btn  btn-sm one"  style="background-color: white; color: rgb(117, 115, 115);">ارسال</button></td> --}}
            @endforeach





</tr>
@endforeach




                </tbody>
            </table>

        </section>
        <!-- end mark subject -->
        <section>
            <h2>الفصل الثاني </h2>
            <table class="" style="">
                <thead>
                    <tr>
                        <th>
                            اسم الطالب
                        </th>
                        <th>
                            الهاتف
                        </th>
                        <th>
                            الشفهي
                        </th>
                        <th>
                            الوظائف
                        </th>
                        <th>
                            النشاط
                        </th>
                        <th>
                             المذاكرة
                        </th>
                        <th>
                             الامتحان الفصلي
                        </th>
                        {{-- <th>
                             ارسال
                        </th> --}}


                    </tr>
                </thead>
                <tbody>
                    @foreach (  $students as $item  )
                    <tr>
                        <td>{{ $item->first_name }} {{ $item->last_name }}   </td>
                        <td>{{ $item->phone }}</td>


                            <input type="hidden" name="term" value="term2">
                            <input type="hidden" name="room_id" value="{{ $room_id }}">
                            <input type="hidden" name="student_id" value="{{$item->id}}">
                            <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
                            @foreach ($item->student_mark as $item2)

                            <td><input type="text" class="common-input mb-20 form-control"  style="height: 50px; width:60px" value="{{ json_decode($item2->mark2,true)[$lesson_id]['oral']}}" name="oral" id="" readonly></td>

                            <td><input type="text" class="common-input mb-20 form-control"  style="height: 50px; width:60px" value="{{ json_decode($item2->mark2,true)[$lesson_id]['homework'] }}" name="homework" id="" readonly> </td>
                            <td><input type="text" class="common-input mb-20 form-control"  style="height: 50px; width:60px" value="{{json_decode($item2->mark2,true)[$lesson_id]['activities']}}" name="activities" id="" readonly></td>
                            <td><input type="text" class="common-input mb-20 form-control"  style="height: 50px; width:60px" value="{{json_decode($item2->mark2,true)[$lesson_id]['quize']}}" name="quize" id="" readonly></td>
                            <td><input type="text" class="common-input mb-20 form-control"  style="height: 50px; width:60px" value="{{ json_decode($item2->mark2,true)[$lesson_id]['exam'] }}" name="exam" id="" readonly></td>






                            {{-- <td><button   type="submit" class="btn  btn-sm one"  style="background-color: white; color: rgb(117, 115, 115);">ارسال</button></td> --}}
                            @endforeach



                    </tr>
                    @endforeach
                </tbody>
            </table>




        </section>
        <!-- end mark subject -->

        <!-- start  mark subject-->
        <section>

            <h2>المحصلة </h2>
            <table class="" style="">
                <thead>

                    <tr>
                        <th>
                             &nbsp; اسم الطالب &nbsp;
                        </th>
                        <th>
                            درجة اعمال
                        </th>
                        <th>
                            امتحان
                        </th>
                        <th>
                            محصلة الفصل الأول
                        </th>
                        <th>
                             درجة اعمال
                        </th>
                        <th>
                             امتحان
                        </th>
                        <th>
                             محصلة الفصل الثاني
                        </th>
                        <th>
                             مجموع درجات الفصلين
                        </th>
                        <th>
                             متوسط درجات الفصلين
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach (  $students as $item  )
                    <tr>
                        <td>{{$item->first_name}}  {{$item->last_name}}   </td>
                        @foreach ($item->student_mark as $item2)
                        <td>

                        {{ json_decode($item2->result1,true)[$lesson_id]['term1_quizes'] }}
                           </td>
                           <td >
                        {{ json_decode($item2->result1,true)[$lesson_id]['term1_exam'] }}
                    </td>
                    <td >

                        {{ json_decode($item2->result1,true)[$lesson_id]['term1_result'] }}
                    </td>

                        @endforeach


                        @foreach ($item->student_mark as $item2)
                        <td>
                            {{ json_decode($item2->result2,true)[$lesson_id]['term2_quizes'] }}

                        </td>

                        <td>
                            {{-- {{ json_decode($item2->result2,true)[$lesson_id]['term2_exam'] }} --}}

                        </td>

                        <td style="font-size: 16px; font-weight: bold; text-align: center">
                            {{ json_decode($item2->result2,true)[$lesson_id]['term2_result'] }}

                        </td>

                        @endforeach

                        @foreach ($item->student_mark as $item2)
                        <td>
                            {{ json_decode($item2->result,true)[$lesson_id]['year_result'] }}

                        </td>

                        <td>
                            {{ json_decode($item2->result,true)[$lesson_id]['year_result'] /2 }}

                        </td>


                        @endforeach
                    </tr>
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
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
            stroke="#F96D00" />
    </svg>
</div>
@endsection
@section('js')
@endsection
