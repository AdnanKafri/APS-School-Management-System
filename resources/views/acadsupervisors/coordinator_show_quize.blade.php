@extends('acadsupervisors.master')
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
/* upload input */
.panel { max-width: 500px; text-align: center; font-size: large;}
.button_outer {background: white;
	border-style: solid;
	border-color: #094e89;
    background-color: #094e89;
	 border-radius:30px;
	 text-align: center;
	 height:60px;
	 width: 200px;
	  display: inline-block;
	  transition: .2s;
	  position: relative;
	  overflow: hidden;}
.btn_upload {padding: 10px 30px 12px; color: #f38639; text-align: center; position: relative; display: inline-block; overflow: hidden; z-index: 3; white-space: nowrap;}
.btn_upload input {
	position: absolute;
	 width: 100%;
	 left: 0;
	 top: 0;
	 width: 100%;
	 height: 105%;
	 cursor: pointer;
	  opacity: 0;}

.file_uploading {width: 100%; height: 10px; margin-top: 20px; background: #ccc;}
.file_uploading .btn_upload {display: none; text-align: center; margin-bottom: 50px;}
.processing_bar {position: absolute; left: 0; top: 0; width: 0;
    height: 100%; border-radius: 30px; background:#f38639; transition: 3s;}
.file_uploading .processing_bar {width: 100%;}
.success_box {display: none; width: 50px; height: 50px; position: relative;}
.success_box:before {content: ''; display: block; width: 9px; height: 18px; border-bottom: 6px solid #fff; border-right: 6px solid #fff; -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg); transform:rotate(45deg); position: absolute; left: 17px; top: 10px;}
.file_uploaded .success_box {display: inline-block;}
.file_uploaded {margin-top: 0; width: 50px; background:linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196)); height: 50px;}
.uploaded_file_view {max-width: 300px; margin: 40px auto; text-align: center; position: relative; transition: .2s; opacity: 0; border: 2px solid #ddd; padding: 15px;}
.file_remove{width: 30px; height: 30px; border-radius: 50%; display: block; position: absolute; background: #aaa; line-height: 30px; color: #fff; font-size: 12px; cursor: pointer; right: -15px; top: -15px;}
.file_remove:hover {background: #222; transition: .2s;}
.uploaded_file_view img {max-width: 100%;}
.uploaded_file_view.show {opacity: 1;}
.error_msg {text-align: center; color: #f00}
</style>

@endsection
@section('content')

<!-- END nav -->


<section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2">
                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread"> المذاكرات
            </div>
        </div>
    </div>
</section>
<!-- start new-->

@if (session()->has('error'))
<script>
    window.onload = function () {
        notif({
            msg: "لم تحدد الاسئلة بعد ",
            type: "error"
        })
    }
</script>
@endif
@if (session()->has('error1'))
<script>
    window.onload = function () {
        notif({
            msg: " يجب تحديد الشعبة اولا ",
            type: "error"
        })
    }
</script>
@endif
@if (session()->has('success'))
<script>
    window.onload = function () {
        notif({
            msg: "تم   حذف المذاكرة بنجاح ",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('Add'))
<script>
    window.onload = function () {
        notif({
            msg: "   تم التعديل بنجاح  ",
            type: "success" 
        })
    }
</script>
@endif
@if (session()->has('success'))
<script>
    window.onload = function () {
        notif({
            msg: " تم الحذف بنجاح ",
            type: "success"
        })
    }
</script>
@endif
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">  مذاكرات </a>
     <a  href="{{ route('dashboard.acadsupervisor_teacher',[$room->id,$teacher->id, $lesson->id ]) }}" class="breadcrumbs__item "> {{ $teacher->first_name }}  {{ $teacher->last_name }}   </a>
    <a  href="{{ route('dashboard.acadsupervisor_subject',$room->id ) }}" class="breadcrumbs__item ">{{ $classes->name }} / {{$room->name}}   </a>
     <a   href="{{ route('dashboard.acadsupervisor') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<br>
<br>


<br>
<br>
<input hidden value="{{$room->id}}" id="room_id">
<!--- tablist for total marks -->
<!-- marks of subjects -->

<div class="tabs">
<span class="subheading"></span>
<div class="tab1cards">
 


     </div>
    <input type="radio" id="tab1" name="tab-control" checked>
    <input type="radio" id="tab2" name="tab-control">


    <ul>
        <li title="الفصل الأول"><label for="tab1" role="button"><svg viewBox="0 0 24 24">
                    <path
                        d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                </svg>
                <span> المذاكرات</span></label></li> &nbsp;&nbsp;&nbsp;&nbsp;

        <li title="الفصل الثاني "><label for="tab2" role="button"><br><svg viewBox="0 0 24 24">
                    <path
                        d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                </svg>
                <span>  المذاكرات المؤتمتة</span></label></li>


    </ul>


    <div class="">
        <div class="indicator"></div>
    </div>

    <div class="content">
        <section>
            <h2> المذاكرات</h2>
            <table class="" >
                <thead>
                    <tr>
                        <th>
                             اسم
                        </th>
                        <th>
                          وقت البداية
                        </th>
                        <th>
                           وقت النهاية
                        </th>
                        <th>
                            الحالة
                        </th>
                        <th>
                            مشاهدة
                        </th>
                        <th>
                            عرض العلامات
                        </th>
                         <th>
                            الفترة
                        </th>
                        <th>
                            العلامة 
                        </th>
                        <!--<th>-->
                        <!--     التعديل-->
                        <!--</th>-->
                        <!--<th>-->
                        <!--     الحذف-->
                        <!--</th>-->



                    </tr>
                </thead>
                <tbody>
@foreach (  $quizes as $item  )

<tr>
    <td>{{ $item->name }}  </td>
    <td>{{ $item->start_date }}</td>
    <td>{{ $item->end_date }}</td>



    <td> @if ($now < $item->start_date && $now < $item->end_date)
    بالانتظار
    @elseif($now > $item->start_date && $now < $item->end_date)
جاري
@elseif($now > $item->start_date && $now > $item->end_date)
انتهى
@endif
    </td>

 <td>
 
@if($item->file)
<a href="{{ asset('storage/'.$item->file) }}" type="button"  target="_blank"  class="btn" style="background-color: white; color: rgb(117, 115, 115);"> مشاهدة </a>

@endif
</td>
<td>  <a   href="{{ route('acadsupervisor_teacher_quize_mark',[$room->id,$classes->id,$teacher->id,$lesson->id,$item->id]) }}" class="btn edit" class="btn" style="background-color: white; color: rgb(117, 115, 115);">   عرض العلامات   </a></td>
 <td>{{ $item->period }}</td>
  <td>{{ $item->mark }}</td>

 <!--<td><a href=""-->
 <!--   data-name_quize="{{ $item ->name_quize  }}"  data-type="{{ $item ->type }}"   data-quiz_link="{{ $item ->quiz_link }}"  data-quize="{{ $item ->quize }}" data-id="{{  $item ->id }}" data-endtime="{{  $item ->end_time }}"  data-start_time="{{  $item ->start_time }}" data-toggle="modal"-->
 <!--   data-target="#staticBackdrop5" type="button" class="btn edit" style="background-color: white; color: rgb(117, 115, 115);"> تعديل </a></td>-->


 <!--<td><a href=""-->
 <!--   data-id="{{ $item->id }}" data-toggle="modal"-->
 <!--   data-target="#modal-fullscreen-xs-down3" type="button" class="btn three" style="background-color: white; color: rgb(117, 115, 115);"> حذف </a></td>-->


</tr>

@endforeach




                </tbody>
            </table>

        </section>
        <!-- end mark subject -->
        <section>
            <h2> المذاكرات المؤتمتة  </h2>
            <table class="" style="">
                <thead>
                    <tr>
                        <th>
                            اسم
                       </th>
                       <th>
                         وقت البداية
                       </th>
                       <th>
                          وقت النهاية
                       </th>
                       <th>
                           الحالة
                       </th>
                       <th>
                           مشاهدة
                       </th>
                          <th>
                            عرض العلامات 
                       </th>
                       <th>
                           الفترة
                       </th>
                        <th>
                           العلامة
                       </th>
                       
                       <!-- <th>-->
                       <!--     التعديل-->
                       <!--</th>-->



                    </tr>
                </thead>
                <tbody>
                    @foreach (  $quize_auto as $item  )
                  
                    <tr>
                        <td>{{ $item->name }}  </td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->end_date }}</td>



                        <td> @if ($now < $item->start_date && $now < $item->end_date)
                        بالانتظار
                        @elseif($now > $item->start_date && $now < $item->end_date)
                    جاري
                    @elseif($now > $item->start_date && $now > $item->end_date)
                    انتهى
                    @endif
                        </td> 
                        
 
                     <td><a href="{{ route('acadsupervisor_quest_exam_quize',[$item->id,$room->id,$lesson->id,$teacher->id]) }}" type="button" class="btn" style="background-color: white; color: rgb(117, 115, 115);"> مشاهدة </a></td></td>


 <td>
 
  <a href="{{ route('acadsupervisor_teacher_quize_mark',[$room->id,$classes->id,$teacher->id,$lesson->id,$item->id]) }}" type="button"    class="btn" style="background-color: white; color: rgb(117, 115, 115);">  عرض العلامات </a></td>
                 <td>{{ $item->period }}</td>
                  <td>{{ $item->mark }}</td>
                    </tr>
               
                    @endforeach

                </tbody>
            </table>




        </section>



    </div>
</div>




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
<script>
      $(".edit").on("click", function (e) {
        var type= $(this).data('type');
        if(type=='5'){
            $('.auto').show();
            $('.normal').hide();
            var id= $(this).data('id');
            var name_quize= $(this).data('name_quize');
            var mark= $(this).data('mark');
            var peroid= $(this).data('peroid');
            var endtime= $(this).data('endtime');
            var starttime = $(this).data('start_time');

            $('.mark').val(mark)
            $('.peroid').val(peroid)
            $('.end').val(endtime)
            $('.note').val(note)
            $('.strat').val(starttime)
            $('.quize_id').val(id)
            $('.name1').val(name_quize)




        }
        else if(type=='2'){
 $('.A').empty();
 room_id= $('#room_id').val();
            $('.auto').hide();
            $('.normal').show();
            var id= $(this).data('id');

            var name_quize= $(this).data('name_quize');

            var endtime= $(this).data('endtime');
            var starttime = $(this).data('start_time');
            var groupe = $(this).data('groupe');
            var quize_file = $(this).data('quize');

            $('.name1').val(name_quize)

            $('.strat').val(starttime)
            $('.end').val(endtime)

            $('.quize_id').val(id)

            if(quize_file){
                $('.A').append(` <label class="form__label" for="">ملف المذاكرة </label>
                                <a  href= "{{url('https://albayan-virtualschool.com/storage/') }}${quize_file}"      id="quize_file"   target="_blank" style="margin:0 auto ">
                                <img src="{{  asset('teachers/photo/pdf1.png') }}"  style="height: 160px; width:160px; margin: 0 auto;">
                                </a>`);

            }

          var data={

                        "id":id,
                         "groupe":groupe,

                    }
var url = "{{ URL::to('SMARMANger/dashboard/coordinator/detexam') }}"  ;
$.ajax({
url: url,
data : data,
type: "get",
contentType: 'application/json',
success: function (data) {
    console.log(data);
     $.each(data, function (key, value) {
    
            if(room_id== value.room.id){
         $('.A').append(` <label class="form__label"  for="${value.room.id}">${value.room.name}</label>
                             <input type="checkbox" name="room_id[]" value="${value.id}" id="${value.room.id}" checked >
                             <br>`);
    }
    else{
         $('.A').append(` <label class="form__label"  for="${value.room.id}">${value.room.name}</label>
                             <input type="checkbox" name="room_id[]" value="${value.id}" id="${value.room.id}" >
                             <br>`);
    }

     })
  
    
}})

        }







        })
        $(document).on('click', '.three', function (e) {




var id = $(this).data('id');

$('#s11').val($(this).data('id'));
$('.confirm3').data('id', id);



});

</script>
<script>

    var btnUpload = $("#upload_file"),
    btnOuter = $(".button_outer");
    btnUpload.on("change", function(e){
    var ext = btnUpload.val().split('.').pop().toLowerCase();


        $(".error_msg").text("");
        btnOuter.addClass("file_uploading");
        setTimeout(function(){
            btnOuter.addClass("file_uploaded");
        },3000);
        var uploadedFile = URL.createObjectURL(e.target.files[0]);
        setTimeout(function(){
            $("#uploaded_view").append('<img src="'+uploadedFile+'" />').addClass("show");
        },3500);

});
$(".file_remove").on("click", function(e){
    $("#uploaded_view").removeClass("show");
    $("#uploaded_view").find("img").remove();
    btnOuter.removeClass("file_uploading");
    btnOuter.removeClass("file_uploaded");
});
        </script>
@endsection
