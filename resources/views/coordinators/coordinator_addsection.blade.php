@extends('coordinators.master')
@section('css')
<style>
 /*table */
table {
  border-spacing: 100px;
  border-collapse: collapse;
  background: linear-gradient(to right top, #2c71ad 50%, rgb(132, 167, 196));
  border-radius: 6px;
  overflow: hidden;
  max-width: 990px;
  width: 100%;
  margin: 0 auto;
  position: relative;
  /*margin-top: -170px;
  margin-bottom: 100px;*/
  direction: rtl;


}
table * {
  position: relative;
  border-spacing: 100px;
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
  /*border-spacing: 100px;*/
  border-bottom: 10px solid transparent;

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
  padding-bottom: 5em;
}
table td.r, table th.r {
  text-align: center;
  padding-bottom: 5em;
}
@media screen and (max-width: 35.5em) {
  table {
    display: block;
  }
  table > *, table tr, table td, table th {
    display: block;
    padding-bottom: 5em;
  }
  table thead {
    display: none;
  }
  table tbody tr {
    height: auto;
    padding: 8px 0;
    border: 5px solid transparent;
  }
  table tbody tr td {
    padding-right: 45%;
    margin-bottom: 17px;

  }
  table tbody tr td:last-child {
    margin-bottom: 20px;
  }
  table tbody tr td:before {
    position: absolute;
    font-weight: 700;
    width: 40%;
    right: 10px;
    top: 0;
  }
  table tbody tr td:nth-child(1):before {
    content: "اسم الاختبار ";
  }
  table tbody tr td:nth-child(2):before {
    content: "وقت البداية ";
  }
  table tbody tr td:nth-child(3):before {
    content: "وقت النهاية ";
  }
  table tbody tr td:nth-child(4):before {
    content: "نوع الاختبار ";
  }
  table tbody tr td:nth-child(5):before {
    content: "الاسئلة ";
  }
  table tbody tr td:nth-child(5):before {
    content: "عمليات التعديل ";
  }
}


/* end table */
/*select and option */
:root {
  --background-gradient: linear-gradient(30deg, #4986fc 30%, #4986fc);
  --gray: #094e89;
  --darkgray: #094e89 ;
}

select {
  /* Reset Select */
  appearance: none;
  outline: 0;
  border: 0;
  box-shadow: none;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: white;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;
  margin: 0 auto;
  font-size: 18px;


}
/* Remove IE arrow */
select::-ms-expand {
  display: none;
}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 20em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
  color: #f38639;
  float: right;
  text-align: center;


}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #094e89;
  transition: .25s all ease;
  pointer-events: none;
  float: right;
  text-align: center;

}
/* Transition */
.select:hover::after {
  color: #f38639;



}
.myDiv{
	display:none;
    padding:10px;
    margin-top:20px;
}

/* Other styles*/


/*end select */
/* start upload css*/
.panel { max-width: 500px; text-align: center; font-size: large;}
.button_outer {background: #094e89; border-radius:30px; text-align: center; height: 50px; width: 200px; display: inline-block; transition: .2s; position: relative; overflow: hidden;}
.btn_upload {padding: 13px 30px 12px; color: #fff; text-align: center; position: relative; display: inline-block; overflow: hidden; z-index: 3; white-space: nowrap;}
.btn_upload input {position: absolute; width: 100%; left: 0; top: 0; width: 100%; height: 105%; cursor: pointer; opacity: 0;}
.file_uploading {width: 100%; height: 10px; margin-top: 20px; background: #ccc;}
.file_uploading .btn_upload {display: none;}
.processing_bar {position: absolute; left: 0; top: 0; width: 0;
    height: 100%; border-radius: 30px; background:#f38639; transition: 3s;}
.file_uploading .processing_bar {width: 100%;}
.success_box {display: none; width: 50px; height: 50px; position: relative;}
.success_box:before {content: ''; display: block; width: 9px; height: 18px; border-bottom: 6px solid #fff; border-right: 6px solid #fff; -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg); transform:rotate(45deg); position: absolute; left: 17px; top: 10px;}
.file_uploaded .success_box {display: inline-block;}
.file_uploaded {margin-top: 0; width: 50px; background:#094e89; height: 50px;}
.uploaded_file_view {max-width: 300px; margin: 40px auto; text-align: center; position: relative; transition: .2s; opacity: 0; border: 2px solid #ddd; padding: 15px;}
.file_remove{width: 30px; height: 30px; border-radius: 50%; display: block; position: absolute; background: #aaa; line-height: 30px; color: #fff; font-size: 12px; cursor: pointer; right: -15px; top: -15px;}
.file_remove:hover {background: #222; transition: .2s;}
.uploaded_file_view img {max-width: 100%;}
.uploaded_file_view.show {opacity: 1;}
.error_msg {text-align: center; color: #f00}

/*upload audio*/

.panel2 { max-width: 500px; text-align: center; font-size: large;}
.button_outer2 {background: #094e89; border-radius:30px; text-align: center; height: 50px; width: 200px; display: inline-block; transition: .2s; position: relative; overflow: hidden;}
.btn_upload2 {padding: 13px 30px 12px; color: #fff; text-align: center; position: relative; display: inline-block; overflow: hidden; z-index: 3; white-space: nowrap;}
.btn_upload2 input {position: absolute; width: 100%; left: 0; top: 0; width: 100%; height: 105%; cursor: pointer; opacity: 0;}
.file_uploading2 {width: 100%; height: 10px; margin-top: 20px; background: #ccc;}
.file_uploading2 .btn_upload2 {display: none;}
.processing_bar2 {position: absolute; left: 0; top: 0; width: 0;
    height: 100%; border-radius: 30px; background:#f38639; transition: 3s;}
.file_uploading2 .processing_bar2 {width: 100%;}
.success_box2 {display: none; width: 50px; height: 50px; position: relative;}
.success_box2:before {content: ''; display: block; width: 9px; height: 18px; border-bottom: 6px solid #fff; border-right: 6px solid #fff; -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg); transform:rotate(45deg); position: absolute; left: 17px; top: 10px;}
.file_uploaded2 .success_box2 {display: inline-block;}
.file_uploaded2 {margin-top: 0; width: 50px; background:#094e89; height: 50px;}
.uploaded_file_view2 {max-width: 300px; margin: 40px auto; text-align: center; position: relative; transition: .2s; opacity: 0; border: 2px solid #ddd; padding: 15px;}
.file_remove2{width: 30px; height: 30px; border-radius: 50%; display: block; position: absolute; background: #aaa; line-height: 30px; color: #fff; font-size: 12px; cursor: pointer; right: -15px; top: -15px;}
.file_remove2:hover {background: #222; transition: .2s;}
.uploaded_file_view2 img {max-width: 100%;}
.uploaded_file_view2.show {opacity: 1;}
.error_msg {text-align: center; color: #f00}

/*end upload css*/

/*new */
/*style tablist*/
/* section add content */
@import "bourbon";
 @import 'https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,400';

 .tabs2 {
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
 .tabs2 input[name="tab-control"] {
	 display: none;
}
 .tabs2 .content section h2, .tabs2 ul li label {
	 font-family: "Montserrat";
	 font-weight: bold;
	 font-size: 18px;
	 color: #094e89;
}
 .tabs2 ul {
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
 .tabs2 ul li {
	 box-sizing: border-box;
	 /*flex: 1;
	 width: 25%;
	 padding: 0 10px;*/
	 text-align: center;
}
 .tabs2 ul li label {
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
 .tabs2 ul li label br {
	 display: none;
}
 .tabs2 ul li label svg {
	 fill: #929daf;
	 height: 1.2em;
	 vertical-align: bottom;
	 margin-right: 0.2em;
	 transition: all 0.2s ease-in-out;
}
 .tabs2 ul li label:hover, .tabs2 ul li label:focus, .tabs2 ul li label:active {
	 outline: 0;
	 color: #bec5cf;
}
 .tabs2 ul li label:hover svg, .tabs2 ul li label:focus svg, .tabs2 ul li label:active svg {
	 fill: #bec5cf;
}
 .tabs2 .slider {
	 position: relative;
	 width: 25%;
	 transition: all 0.33s cubic-bezier(0.38, 0.8, 0.32, 1.07);
}
 .tabs2 .slider .indicator {
	 position: relative;
	 width: 50px;
	 max-width: 100%;
	 margin: 0 auto;
	 height: 4px;
	 background: #cc151525;
	 border-radius: 1px;
}
 .tabs2 .content {
	 margin-top: 30px;
}
 .tabs2 .content section {
	 display: none;
	 animation-name: content;
	 animation-direction: normal;
	 animation-duration: 0.3s;
	 animation-timing-function: ease-in-out;
	 animation-iteration-count: 1;
	 line-height: 1.4;
}
 .tabs2 .content section h2 {
	 color: #1068b4;
	 display: none;
}
 .tabs2 .content section h2::after {
	 content: "";
	 position: relative;
	 display: block;
	 width: 30px;
	 height: 3px;
	 background: #1068b4;
	 margin-top: 5px;
	 left: 1px;
}
 .tabs2 input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label {
	 cursor: default;
	 color: #f38639;
}
 .tabs2 input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label svg {
	 fill: #f38639;
}
 @media (max-width: 600px) {
	 .tabs2 input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs2 input[name="tab-control"]:nth-of-type(1):checked ~ .slider {
	 transform: translateX(0%);
}
 .tabs2 input[name="tab-control"]:nth-of-type(1):checked ~ .content > section:nth-child(1) {
	 display: block;
}
 .tabs2 input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label {
	 cursor: default;
	 color: #f38639;
}
 .tabs2 input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label svg {
	 fill: #f38639;
}
 @media (max-width: 600px) {
	 .tabs2 input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs2 input[name="tab-control"]:nth-of-type(2):checked ~ .slider {
	 transform: translateX(100%);
}
 .tabs2 input[name="tab-control"]:nth-of-type(2):checked ~ .content > section:nth-child(2) {
	 display: block;
}
 .tabs2 input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label {
	 cursor: default;
	 color: #f38639;
}
 .tabs2 input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label svg {
	 fill: #f38639;
}
 @media (max-width: 600px) {
	 .tabs2 input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs2 input[name="tab-control"]:nth-of-type(3):checked ~ .slider {
	 transform: translateX(200%);
}
 .tabs2 input[name="tab-control"]:nth-of-type(3):checked ~ .content > section:nth-child(3) {
	 display: block;
}
/*tab 4*/
.tabs2 input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label {
	 cursor: default;
	 color: #1068b4;
}
 .tabs2 input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label svg {
	 fill: #1068b4;
}
 @media (max-width: 600px) {
	 .tabs2 input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs2 input[name="tab-control"]:nth-of-type(4):checked ~ .slider {
	 transform: translateX(0%);
}
 .tabs2 input[name="tab-control"]:nth-of-type(4):checked ~ .content > section:nth-child(4) {
	 display: block;
}
 .tabs2 input[name="tab-control"]:nth-of-type(5):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs2 input[name="tab-control"]:nth-of-type(5):checked ~ .content > section:nth-child(5) {
	 display: block;
}
/*tab 5*/
.tabs2 input[name="tab-control"]:nth-of-type(5):checked ~ ul > li:nth-child(5) > label {
	 cursor: default;
	 color: #1068b4;
}
 .tabs2 input[name="tab-control"]:nth-of-type(5):checked ~ ul > li:nth-child(5) > label svg {
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
                        <h1 class="mb-0 bread"> اضافة فقرة </h1>
            </div>
        </div>
    </div>
</section>
@if (session()->has('Add'))
<script>
    window.onload = function () {
        notif({
            msg: "تمت اضافة فقرة بنجاح ",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('update'))
<script>
    window.onload = function () {
        notif({
            msg: "تمت تعديل فقرة  بنجاح ",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('error'))
<script>
    window.onload = function () {
        notif({
            msg: "يرجى وضع نوع الفقرة    ",
            type: "error"
        })
    }
</script>
@endif
<!-- start new-->
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active"> اضافة  فقرة </a>
    <a  href="{{ route('coordinator_add_auto',[$class->id ,$lesson->id]) }}" class="breadcrumbs__item">اضافة محتوى مؤتمت  </a>
  
      <a  href="{{ route('coordinator_lesson',[$class->id,$lesson->id]) }}" class="breadcrumbs__item ">{{ $lesson->name }} </a>
    <a  href="{{ route('dashboard.coordinator_subject',$class->id ) }}" class="breadcrumbs__item ">{{ $class->name }}   </a>
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<br>
<br>
<br>
<br>
<!-- start add section-->
<div class="col-md-12 heading-section text-center ">
    <button     type="button" class="btn btn-primary launch"
      data-toggle="modal" data-target="#staticBackdrop5" >
  اضافة فقرة  &nbsp;<i class="fa fa-plus"></i>  </button>
             <!-- start  model-->
             <div class="modal fade" id="staticBackdrop5" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog" >
                  <div class="modal-content" >
                    <div class="modal-body" >
                      <div class="text-right">
                        <i   style="color:#495057" class="fa fa-close close" data-dismiss="modal">
                                </i>
                        <br>
                    </div>
                    <form action="{{ route('section_store') }}" method="post" autocomplete="off"
                        enctype="multipart/form-data">

                        @csrf


                        <div class="tabs mt-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">

                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="visa" role="tabpanel"
                                    aria-labelledby="visa-tab">
                                    <div class="mt-4 mx-4">
                                        <div class="text-center" style="height: auto;">
                                            <h5> اضافة محتوى </h5>
                                            <br>


                                            <br>

                                            <br>


                                            <br>
                                            <br>
                                            <!-- start select option-->
                                            <span style="float: right;">عنوان المحتوى </span>
                                            <br>


                                            <input hidden type="text" name="lesson_id" value="{{ $lesson_id }}">

                                            <input hidden type="text" name="class_id" value="{{ $class->id }}">
                                            <input style="text-align: right;" type="text" class="form-control"
                                                name="title" id="name" required placeholder="ادخل عنوان المحتوى ">
                                            <br>
                                            <br>

                                            <span style="float:right">نوع المحتوى</span>
                                            <br>

                                            <br>
                                            <select id="myselection" name="type"
                                                style="width: 300px;  height:50px; text-align: center;">
                                                <option style="text-align: center;"> اختيار المحتوى </option>
                                                <option style="text-align: center;" value="0">نص </option>
                                                <option style="text-align: center;" value="3">صورة </option>
                                                <option style="text-align: center;" value="2">صوت </option>
                                            </select>

                                            <br>
                                            <!-- upoad image -->
                                            <div id="show0" class="myDiv">
                                                <textarea name="content" class="form-control" style="direction:ltr"
                                                    cols="30" rows="10"></textarea>
                                            </div>


                                            <div id="show3" class="myDiv">

                                                <div>

                                                    <main class="main_full">
                                                        <div class="container">
                                                            <div class="panel">
                                                                <div class="button_outer">
                                                                    <div class="btn_upload">
                                                                        <input type="file" name="content2"
                                                                            id="upload_file">
                                                                        تحميل صورة
                                                                    </div>
                                                                    <div class="processing_bar"></div>
                                                                    <div class="success_box"></div>
                                                                </div>
                                                            </div>
                                                            <div class="error_msg"></div>
                                                            <div class="uploaded_file_view" id="uploaded_view">
                                                                <span class="file_remove">X</span>
                                                            </div>
                                                        </div>
                                                    </main>
                                                </div>


                                            </div>
                                            <!-- end upload image -->
                                            <!-- start upload audio-->
                                            <div id="show2" class="myDiv">
                                                <main class="main_full">
                                                    <div class="container">
                                                        <div class="panel2">
                                                            <div class="button_outer2">
                                                                <div class="btn_upload2">
                                                                    <input type="file" id="upload_file2" name="content"
                                                                        accept="audio/*">
                                                                    تحميل مقطع صوت
                                                                </div>
                                                                <div class="processing_bar2"></div>
                                                                <div class="success_box2"></div>
                                                            </div>
                                                        </div>
                                                        <div class="error_msg2"></div>
                                                        <div class="uploaded_file_view2" id="uploaded_view2">
                                                            <span class="file_remove2">X</span>
                                                        </div>
                                                    </div>
                                                </main>
                                            </div>
                                        </div>
                                        <!--- end upload audio-->

                                        <br>
                                        <br>




                                        <div class="px-5 pay" style="text-align: center;">
                                            <button type="submit" class="btn btn-primary" style="width: 200px;">
                                                حفظ
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end model-->

    <!--- end add section -->
</div>



<br>
<br>
<div class="modal fade" id="staticBackdrop1" data-backdrop="static" data-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <div class="text-right">
                <i class="fa fa-close close" data-dismiss="modal">
                </i>
                <br>
            </div>
            <div class="tabs mt-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">

                    </li>

                </ul>

                    <div class="tab-content" id="myTabContent">
                        <form action="{{ route('section_update') }}" method="post"
                    autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="section_id" id="id">
                  
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="type" id="type_edit">

                    <input type="hidden" name="teacher_id" value="{{ auth()->user()->teacher_id }}">
                        <div class="tab-pane fade show active" id="visa" role="tabpanel"
                            aria-labelledby="visa-tab">
                            <div class="mt-4 mx-4">
                                <div class="text-center">
                                    <h5>تعديل المحتوى </h5>
                                    <br>
                                    <!-- start select option-->
                                    <span style="float: right;"> عنوان المحتوى </span>
                                    <br>
                                    <input type="text" class="form-control"  required name="title"
                                        id="title_edit" value="image 1">
                                    <br>
                                    <br>

                                    <span style="float: right;"> نوع المحتوى </span>
                                    <br>

                                    <select id="text"
                                        style="width: 300px;  height:50px; text-align: center;">




                                    </select>
                                    <br>
                                    <br>
                                    <br>
                                    <div id="content_edit">

                                    </div>

                                    <!-- upload image-->
                                </div>
                            </div>

                            <!-- end upload image-->

                        </div>

                        <br>
                        <br>
                        <br>
                        <br>

                        <div class="px-5 pay" style="text-align: center;">
                            <button type="submit" class="btn btn-primary" style="width: 200px;">
                                حفظ
                            </button>
                        </div>
                    </form>
                    </div>

            </div>
        </div>


    </div>
</div>


</div>
<div class="tabs2">

    <input type="radio" id="tab1" name="tab-control"  >
    <input type="radio" id="tab2" name="tab-control">
    <input type="radio" id="tab3" name="tab-control" checked>

    <ul>
      <li title="اضافة نص "><label for="tab1" role="button"><svg viewBox="0 0 24 24"><path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
      </svg>
      <span> اضافة نص </span><br></label></li>&nbsp;&nbsp;

      <li title="اضافة صورة "><label for="tab2" role="button"><svg viewBox="0 0 24 24"><path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
      </svg>
      <span>اضافة صورة </span><br></label></li> </label></li>&nbsp;&nbsp;

      <li title="اضافة صوت "><label for="tab3" role="button"><svg viewBox="0 0 24 24"><path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
      </svg>
      <span>اضافة صوت </span><br></label></li></label></li>

    </ul>


    <div class=""><div class="indicator"></div></div>

    <div class="content">
     <!-- start  mark subject-->
      <section style="direction: rtl; text-align:right">
      <h2>اضافة نص  </h2>
        <table >
        <thead>
            <tr>
                <th>اسم المحتوى </th>

                <th>المحتوى  </th>
                <th>عمليات التعديل</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i2 = 0;
            @endphp

            @foreach ($sections as $section )
            @if ($section->type == '0')
            @php
            $i2++;
            @endphp
            <tr>
              <td> {{  $section->title }} </td>


            <td style="direction: ltr;">
              <textarea name="content" class="form-control" cols="3" rows="5">
                {{ $section->content }}</textarea>
            </td>
            <td>
                <a href="#" type="button" data-section_id="{{$section->id}}" data-content="{{$section->content}}"
                    data-type="{{$section->type}}" data-section_title="{{$section->title}}"
                   class="btn section_edit" style="background-color: white; color: rgb(117, 115, 115);" data-toggle="modal" data-target="#staticBackdrop1">تعديل</a>
                <!-- start modal -->

              </td>
        </tr>

@endif
@endforeach
        </tbody>
    </table>


      </section>
      <!-- end mark subject -->

       <!-- start  mark subject -->
        <section style="direction: rtl; text-align:right">
        <h2>اضافة صورة </h2>
        <table >
          <thead>

              <tr>
                  <th>اسم المحتوى </th>

                  <th>المحتوى  </th>
                  <th>عمليات التعديل</th>
              </tr>
          </thead>
          <tbody>
            @php
            $i1 = 0;
            @endphp

            @foreach ($sections as $section )
            @if ($section->type == '3')
            @php
            $i1++;
            @endphp
            <tr>
              <td>  {{  $section->title }} </td>
              <td>
                <img src="{{ asset('storage/'.$section->content) }}" style="height: 60px;width:70px">
              </td>

              <td>
                <a href="#" type="button" data-section_id="{{$section->id}}" data-content="{{$section->content}}"
                    data-type="{{$section->type}}" data-section_title="{{$section->title}}"
                   class="btn section_edit" style="background-color: white; color: rgb(117, 115, 115);" data-toggle="modal" data-target="#staticBackdrop1">تعديل</a>
                <!-- start modal -->

                <!-- Modal -->


                </td>
          </tr>
       @endif
       @endforeach

          </tbody>
      </table>


        </section>
         <!-- end mark subject -->

        <!-- start mark subject-->


       <section style="direction: rtl; text-align:right">
        <h2>اضافة صوت </h2>

        <table >
          <thead>
              <tr>
                  <th>اسم المحتوى </th>

                  <th>المحتوى  </th>
                  <th>عمليات التعديل</th>
              </tr>
          </thead>
          <tbody>
            @php
            $i = 0;
            @endphp

            @foreach ($sections as $section )
            @if ($section->type == '2')
            @php
            $i++;
            @endphp

            <tr>
              <td>  {{  $section->title }} </td>
              <td>
                <audio src="{{ asset('storage/'.$section->content) }}" controls="">
                </audio>
              </td>
              <td>
                <a href="#" type="button" data-section_id="{{$section->id}}" data-content="{{$section->content}}"
                    data-type="{{$section->type}}" data-section_title="{{$section->title}}"
                   class="btn section_edit" style="background-color: white; color: rgb(117, 115, 115);" data-toggle="modal" data-target="#staticBackdrop1">تعديل</a>
                <!-- start modal -->

                <!-- Modal -->


                </td>
          </tr>
          @endif
@endforeach

          </tbody>
      </table>

             </section>
        <!-- end mark subject -->


    </div>
    </div>
<!-- marks of homework -->


<!-- end marks of homework-->
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
    $(document).on('click', '.section_edit', function () {
        var id = $(this).data('section_id');
        var title = $(this).data('section_title');
        var type = $(this).data('type');
        var content = $(this).data('content');
        $('#id').val(id);
        $('#title_edit').val(title);
        $('#type_edit').val(type);
        $('#text').empty();
        $('#content_edit').empty();

        if (type == '0') {
            $('#text').append(`
        <option value="hide">-------------- نص --------------</option>


        `);

            $('#content_edit').append(`
        <textarea name="content" class="form-control" style="direction:ltr"
                                                        cols="30" rows="10">
                                                        ${content}</textarea>




        `);
        } else if (type == '3') {
            $('#text').append(`
        <option value="hide">-------------- صورة --------------</option>


        `);
            $('#content_edit').append(` <img src="{{ asset('storage/${content}') }}"  width="50px" height="50px">  <main class="main_full">
                                                        <div class="container">
                                                            <div class="panel">
                                                                <div class="button_outer">
                                                                    <div class="btn_upload">

                                                                        <input type="file" id="upload_file"
                                                                            name="content">
                                                                        تحميل صورة
                                                                    </div>
                                                                    <div class="processing_bar"></div>
                                                                    <div class="success_box"></div>
                                                                </div>
                                                            </div>
                                                            <div class="error_msg"></div>
                                                            <div class="uploaded_file_view" id="uploaded_view">
                                                                <span class="file_remove">X</span>
                                                            </div>
                                                        </div>
                                                    </main>




        `);

        } else {
            $('#text').append(`
        <option value="hide">-------------- صوت --------------</option>


        `);
            $('#content_edit').append(`
        <audio src="{{ asset('storage/${content}') }}" controls></audio>
        <main class="main_full">
                                                        <div class="container">
                                                            <div class="panel2">
                                                                <div class="button_outer2">
                                                                    <div class="btn_upload2">

                                                                        <input type="file" id="upload_file2" name="content"
                                                                            accept="audio/*">
                                                                        تحميل مقطع صوت
                                                                    </div>
                                                                    <div class="processing_bar2"></div>
                                                                    <div class="success_box2"></div>
                                                                </div>
                                                            </div>
                                                            <div class="error_msg2"></div>
                                                            <div class="uploaded_file_view2" id="uploaded_view2">
                                                                <span class="file_remove2">X</span>
                                                            </div>
                                                        </div>
                                                    </main>



        `);

        }
    })
    $(document).ready(function () {
        $('#myselection').on('change', function () {
            var demovalue = $(this).val();
            $("div.myDiv").hide();
            $("#show" + demovalue).show();
        });
    });
</script>
<script>
    var btnUpload = $("#upload_file"),
        btnOuter = $(".button_outer");
    btnUpload.on("change", function (e) {
        var ext = btnUpload.val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            $(".error_msg").text("Not an Image...");
        } else {
            $(".error_msg").text("");
            btnOuter.addClass("file_uploading");
            setTimeout(function () {
                btnOuter.addClass("file_uploaded");
            }, 3000);
            var uploadedFile = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view").append('<img src="' + uploadedFile + '" name="content" / >')
                    .addClass("show");
            }, 3500);
        }
    });
    $(".file_remove").on("click", function (e) {
        $("#uploaded_view").removeClass("show");
        $("#uploaded_view").find("img").remove();
        btnOuter.removeClass("file_uploading");
        btnOuter.removeClass("file_uploaded");
    });
    /* start upload audio */
    var btnUpload2 = $("#upload_file2"),
        btnOuter2 = $(".button_outer2");
    btnUpload2.on("change", function (e) {
        var ext = btnUpload2.val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['mp3']) == -1) {
            $(".error_msg2").text("Not an audio...");
        } else {
            $(".error_msg2").text("");
            btnOuter2.addClass("file_uploading2");
            setTimeout(function () {
                btnOuter2.addClass("file_uploaded2");
            }, 3000);
            var uploadedFile2 = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view2").append('<img src="' + uploadedFile2 + '"  name="content"/  >')
                    .addClass("show");
            }, 3500);
        }
    });
    $(".file_remove2").on("click", function (e) {
        $("#uploaded_view2").removeClass("show");
        $("#uploaded_view2").find("img").remove();
        btnOuter2.removeClass("file_uploading2");
        btnOuter2.removeClass("file_uploaded2");
    });
</script>


@endsection
