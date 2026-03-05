@extends('admin.master')
@section('style')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.min.js>"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
   <input class="btn btn-primary " type="button" onclick="tablesToExcel(array1, 'myfile.xls')" value="تنزيل ملف اكسل" style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;
    background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));">



<table id="1">
  <tr>
   <td>
         <table style=""  >
       <thead style="text-align: center;" >
           <tr>
                 <th rowspan="2"   style="text-align: center;" >الرقم </th>
               <th rowspan="2"    style="text-align: center;" >الاسم والشهرة </th>
               <th rowspan="1" colspan="4" style="text-align: center;">اعمال الطالب </th>
               <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الأعمال </th>
               <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الامتحان </th>
               <th rowspan="1"  colspan="1"  style="text-align: center;" > المجموع </th>
               <th rowspan="2"  colspan="1"  style="text-align: center;" > المحصلة الأولى </th>


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
       <tbody style="text-align: center;     " >
        @if ($students)
           @foreach (  $students->student as $item  )

           <tr>
          <td> {{arabic_w2e( $item->id) }}  </td>
               <td> {{ $item->first_name }} {{ $item->last_name }} </td>

                 @foreach ($item->student_mark as $item2)

                 <td>  @foreach( json_decode($item2->mark,true) as $key=>$item)
                   @if($key == $lesson_id && $item['oral'] !="null" )
                   @if(json_decode($item2->mark,true)[$lesson_id]['oral'] !=null)
                   {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['oral'])}}

                   @endif
                   @break

                   @endif

                   @endforeach
                   </td>

                         <td>

                           @foreach( json_decode($item2->mark,true) as $key=>$item)
                           @if($key == $lesson_id && $item['homework'] !="null" )
                           @if(json_decode($item2->mark,true)[$lesson_id]['homework'] !=null)
                           {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['homework'])}}

                           @endif
                           @break

                           @endif

                           @endforeach




                            <td>
                             @foreach( json_decode($item2->mark,true) as $key=>$item)
                             @if($key == $lesson_id && $item['activities'] !="null" )
                             @if(json_decode($item2->mark,true)[$lesson_id]['activities'] !=null)
                             {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['activities'])}}

                             @endif
                             @break

                             @endif

                             @endforeach

                            </td>
                           <td>
                             @foreach( json_decode($item2->mark,true) as $key=>$item)
                             @if($key == $lesson_id && $item['quize'] !="null" )
                             @if(json_decode($item2->mark,true)[$lesson_id]['quize'] !=null)
                             {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['quize'])}}

                             @endif
                             @break

                             @endif

                             @endforeach
                            </td>
                 <td>
                     @if($item2->worke_degree)
                 @foreach( json_decode($item2->worke_degree,true) as $key=>$item)
                 @if($key == $lesson_id  && $item['term1_result'] !="null")
                   {{arabic_w2e($item['term1_result'])}}
                       @break

               @endif

                @endforeach
                   @endif
                   </td>
                   <td>
                     @foreach( json_decode($item2->mark,true) as $key=>$item)
                     @if($key == $lesson_id && $item['exam'] !="null" )
                     @if(json_decode($item2->mark,true)[$lesson_id]['exam'] !=null)
                     {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['exam'])}}

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


                @endforeach
           </tr>

         @endforeach
         @endif


       </tbody>

     </table>
     </td>

  <td>
<table  >
         <thead style="text-align: center;" >
             <tr style="text-align: center;"  >
             <th rowspan="2"   style="text-align: center;" >الرقم </th>
               <th rowspan="2"    style="text-align: center;" >الاسم والشهرة </th>
               <th rowspan="1" colspan="4" style="text-align: center;">اعمال الطالب </th>
               <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الأعمال </th>
               <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الامتحان </th>
               <th rowspan="1"  colspan="1"  style="text-align: center;" > المجموع </th>
               <th rowspan="2"  colspan="1"  style="text-align: center;" > المحصلة الثانية </th>
               <th rowspan="2" colspan="1" style="text-align: center;"> مجموع المحصلتين <span style="color:white;"> &#247</span> ٢ </th>
                <th rowspan="2" colspan="1" style="text-align: center;"> ملاحظات </th>

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
         <tbody style="text-align: center;"  >
          @if ($students)
            @foreach (  $students->student as $item  )

           <tr>
            <td> {{arabic_w2e( $item->id) }}  </td>
               <td> {{ $item->first_name }} {{ $item->last_name }} </td>

                @foreach ($item->student_mark as $item2)
                <td>  @foreach( json_decode($item2->mark2,true) as $key=>$item)
                 @if($key == $lesson_id && $item['oral'] !="null" )
                 @if(json_decode($item2->mark2,true)[$lesson_id]['oral'] !=null)
                 {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['oral'])}}

                 @endif
                 @break

                 @endif

                 @endforeach
                 </td>

                       <td>

                         @foreach( json_decode($item2->mark2,true) as $key=>$item)
                         @if($key == $lesson_id && $item['homework'] !="null" )
                         @if(json_decode($item2->mark2,true)[$lesson_id]['homework'] !=null)
                         {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['homework'])}}

                         @endif
                         @break

                         @endif

                         @endforeach
                       </td>




                          <td>
                           @foreach( json_decode($item2->mark2,true) as $key=>$item)
                           @if($key == $lesson_id && $item['activities'] !="null" )
                           @if(json_decode($item2->mark2,true)[$lesson_id]['activities'] !=null)
                           {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['activities'])}}

                           @endif
                           @break

                           @endif

                           @endforeach

                          </td>
                         <td>
                           @foreach( json_decode($item2->mark2,true) as $key=>$item)
                           @if($key == $lesson_id && $item['quize'] !="null" )
                           @if(json_decode($item2->mark2,true)[$lesson_id]['quize'] !=null)
                           {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['quize'])}}

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
                     @foreach( json_decode($item2->mark2,true) as $key=>$item)
                     @if($key == $lesson_id && $item['exam'] !="null" )
                     @if(json_decode($item2->mark2,true)[$lesson_id]['exam'] !=null)
                     {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['exam'])}}

                     @endif
                     @break

                     @endif

                     @endforeach
                    </td>



     <td>
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
       </td>
       <td>
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
         </td>




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
     <td>

                     @if($item2->notes)
                 @foreach( json_decode($item2->notes,true) as $key=>$item)
                 @if($key == $lesson_id   )
                   {{$item}}
                       @break

               @endif

                @endforeach
                   @endif

                   </td>


            @endforeach
             </tr>


  @endforeach
  @endif




         </tbody>
       </table>
       </td>
  </tr>
</table>

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







                    @endsection
