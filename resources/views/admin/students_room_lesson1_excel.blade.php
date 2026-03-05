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

   <input class="btn btn-primary " type="button" onclick="tablesToExcel(array1, 'myfile.xls')" value="تنزيل ملف اكسل" style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;
    background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));">
  @php
                     function arabic_w2e($str)
{
    $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    return str_replace($arabic_western, $arabic_eastern, $str);
}

                     @endphp



<table id="1">
    <tr>
     <td>
           <table style="margin-top: -16px;"  >
          <thead>
             <tr>
                   <th rowspan="2"    style="text-align: center;" >الطلاب </th>
                 <th rowspan="2"   style="text-align: center;" >الدرجة العظمى </th>
                 <th rowspan="1" colspan="4" style="text-align: center;">درجات اعمال الفصل الأول </th>
                 <th rowspan="1"  colspan="1"  style="text-align: center;">مجموع درجة اعمال الفصل الأول </th>
                 <th rowspan="1"  colspan="1"  style="text-align: center;">درجة اختبار الفصل الأول </th>
                 <th rowspan="1"  colspan="1"  style="text-align: center;" > مجموع درجات الفصل الأول </thh>


             </tr>
             <tr>

              <th rowspan="1" colspan="1"  style="text-align: center;">شفوية <br> <span style="color: #f38639;">%١٠</span>  </th>
               <th rowspan="1" colspan="1" style="text-align: center;"> وظائف و اوراق عمل  <br> <span style="color: #f38639;">%١٠</span> </th>
               <th rowspan="1" colspan="1" style="text-align: center;"> نشاطات  و مبادرات <br> <span style="color: #f38639;">%٢٠</span></th>
               <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
                <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٦٠</span></th>
               <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
               <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>
             </tr>


         </thead>
         <tbody>
            @if ($students)
             @foreach (  $students->student as $item  )

             <tr>

                 <td> {{ $item->first_name }} {{ $item->last_name }} </td>
                  <td>{{arabic_w2e($lesson->max_mark)	}} </td>
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
                   @if($key == $lesson_id && $item['term1_result'] !="null" )
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
                      <th rowspan="2" colspan="1" style="text-align: center;">الطلاب </th>
                 <th rowspan="2" colspan="1" style="text-align: center;"> الدرجة العظمى </th>
                   <th rowspan="1" colspan="4" style="text-align: center;"> درجة اعمال الفصل الثاني </th>
                   <th rowspan="1" colspan="1" style="text-align: center;" >مجموع درجات اعمال الفصل الثاني </th>
                   <th rowspan="1" colspan="1" style="text-align: center;" >درجة اختبار الفصل الثاني </th>
                   <th rowspan="1" colspan="1" style="text-align: center;" >مجموع درجات الفصل الثاني  </th>
                   <th rowspan="2" colspan="1" style="text-align: center;" >مجموع درجات الفصلين</th>
                   <th rowspan="1" colspan="2" style="text-align: center;"  > الدرجة النهائية </th>

               </tr>
               <tr>
             <th rowspan="1" colspan="1"  style="text-align: center;">شفوية <br> <span style="color: #f38639;">%١٠</span>  </th>
               <th rowspan="1" colspan="1" style="text-align: center;"> وظائف و اوراق عمل  <br> <span style="color: #f38639;">%١٠</span> </th>
               <th rowspan="1" colspan="1" style="text-align: center;"> نشاطات  و مبادرات <br> <span style="color: #f38639;">%٢٠</span></th>
               <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
                <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٦٠</span></th>
               <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
               <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>
               <th rowspan="1" colspan="1" style="text-align:center;">رقما  </th>
               <th rowspan="1" colspan="1" style="text-align:center;">كتابة</th>

               </tr>
           </thead>
           <tbody style="text-align: center;"  >
            @if ($students)
              @foreach (  $students->student as $item  )

             <tr>
                 <td> {{ $item->first_name }} {{ $item->last_name }} </td>
                   <td>{{arabic_w2e($lesson->max_mark)	}} </td>
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
                         @if($key == $lesson_id )
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


               <td class="c1"  > @if($item2->result)
                 @foreach( json_decode($item2->result,true) as $key=>$item)
                 @if($key == $lesson_id && $item['year_result'] !="null" )
               {{ arabic_w2e(json_decode($item2->result,true)[$lesson_id]['year_result']) }}
                 @break

                 @endif

                 @endforeach
                 @endif </td>



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
             <td class="x" @if($item2->result)
               @foreach( json_decode($item2->result,true) as $key=>$item)
               @if($key == $lesson_id && $item['year_result'] !="null" )

                   data-id="{{ ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)}}"

               @break

               @endif

               @endforeach
               @endif></td>

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

/*
القيم الخاصة بقيم الآحاد
وحتى الرقم 12
* */
var ones = {
    0: "صفر",
    1: "واحد",
    2: "اثنان",
    3: "ثلاثة",
    4: "أربعة",
    5: "خمسة",
    6: "ستة",
    7: "سبعة",
    8: "ثمانية",
    9: "تسعة",
    10: "عشرة",
    11: "أحد عشر",
    12: "اثنى عشر"
}

/*
القيم الخاصة بقيم العشرات
* */
var tens = {
    1: "عشر",
    2: "عشرون",
    3: "ثلاثون",
    4: "أربعون",
    5: "خمسون",
    6: "ستون",
    7: "سبعون",
    8: "ثمانون",
    9: "تسعون"
}


/*
القيم الخاصة بقيم المئات
* */
var hundreds = {
    0: "صفر",
    1: "مائة",
    2: "مئتان",
    3: "ثلاثمائة",
    4: "أربعمائة",
    5: "خمسمائة",
    6: "ستمائة",
    7: "سبعمائة",
    8: "ثمانمائة",
    9: "تسعمائة"
}

/*
القيم الخاصة بقيم الآلاف
* */
var thousands = {
    1: "ألف",
    2: "ألفان",
    39: "آلاف",
    1199: "ألفًا"
}

/*
القيم الخاصة بقيم الملايين
* */
var millions = {
    1: "مليون",
    2: "مليونان",
    39: "ملايين",
    1199: "مليونًا"
}


/*
القيم الخاصة بقيم المليارات
* */
var billions = {
    1: "مليار",
    2: "ملياران",
    39: "مليارات",
    1199: "مليارًا"
}

/*
القيم الخاصة بقيم التريليونات
* */
var trillions = {
    1: "تريليون",
    2: "تريليونان",
    39: "تريليونات",
    1199: "تريليونًا"
}


/**
 *
 * @param {*} number
 * هذه هي الدالة الرئيسية
 * والتي يتم من خلالها تفقيط الأرقام
 */
function tafqeet(number) {

    /**
     * متغير لتخزين النص المفقط بداخله
     */

    var value = "";
    number = parseInt (number);
    //التحقق من أن المتغير يحتوي أرقامًا فقط، وأقل من تسعة وتسعين تريليون
    if (number.toString ().match(/^[0-9]+$/) != null && number.toString().length <= 14) {
        switch (number.toString().length) {
            /**
             * إذا كان العدد من 0 إلى 99
             */
            case 1:
            case 2:
                value = oneTen(number);
                break;

            /**
             * إذا كان العدد من 100 إلى 999
             */
            case 3:
                value = hundred(number);
                break;

            /**
             * إذا كان العدد من 1000 إلى 999999
             * أي يشمل الآلاف وعشرات الألوف ومئات الألوف
             */
            case 4:
            case 5:
            case 6:
                value = thousand(number);
                break;

            /**
             * إذا كان العدد من 1000000 إلى 999999999
             * أي يشمل الملايين وعشرات الملايين ومئات الملايين
             */
            case 7:
            case 8:
            case 9:
                value = million(number);
                break;

            /**
             * إذا كان العدد من 1000000000 إلى 999999999999
             * أي يشمل المليارات وعشرات المليارات ومئات المليارات
             */
            case 10:
            case 11:
            case 12:
                value = billion(number);
                break;

            /**
             * إذا كان العدد من 100000000000 إلى 9999999999999
             * أي يشمل التريليونات وعشرات التريليونات
             */
            case 13:
            case 14:
            case 15:
                value = trillion(number);
                break;

        }

    }

    /**
     * هذا السطر يقوم فقط بإزالة بعض الزوائد من النص الأخير
     * تظهر هذه الزوائد نتيجة بعض الفروق في عملية التفقيط
     * ولإزالتها يتم استخدام هذا السطر
     */
    return value.replace (/وصفر/g,"")
    .replace (/وundefined/g,"")
    .replace(/ +(?= )/g,'')
    .replace (/صفر و/g,"")
    .replace (/صفر/g,"")
    .replace (/مئتان أ/,"مائتا أ")
    .replace (/مئتان م/,"مائتا م");
}


/**
 *
 * @param {*} number
 * الدالة الخاصة بالآحاد والعشرات
 */
function oneTen(number) {

    /**
     * القيم الافتراضية
    */
    var value = "صفر";

    //من 0 إلى 12
    if (number <= 12) {
        switch (parseInt (number)) {
            case 0:
                value = ones["0"];
                break;
            case 1:
                value = ones["1"];
                break;
            case 2:
                value = ones["2"];
                break;
            case 3:
                value = ones["3"];
                break;
            case 4:
                value = ones["4"];
                break;
            case 5:
                value = ones["5"];
                break;
            case 6:
                value = ones["6"];
                break;
            case 7:
                value = ones["7"];
                break;
            case 8:
                value = ones["8"];
                break;
            case 9:
                value = ones["9"];
                break;
            case 10:
                value = ones["10"];
                break;

            case 11:
                value = ones["11"];
                break;

            case 12:
                value = ones["12"];
                break;


        }
    }

    /**
     * إذا كان العدد أكبر من12 وأقل من 99
     * يقوم بجلب القيمة الأولى من العشرات
     * والثانية من الآحاد
     */
    else {
        var first = getNth (number, 0,0);

        var second = getNth (number, 1,1);

        if(tens[first] == "عشر"){
            value = ones[second] + " " + tens[first];
        }
        else{
            value = ones[second] + " و" + tens[first];
        }

    }

    return value;
}


/**
 *
 * @param {*} number
 * الدالة الخاصة بالمئات
 */
function hundred(number) {
    var value = "";

    /**
     * إذا كان الرقم لا يحتوي على ثلاث منازل
     * سيتم إضافة أصفار إلى يسار الرقم
     */
    while (number.toString().length !=3){
        number = "0"+number;
    }

    var first = getNth (number, 0,0);

    /**
     * تحديد قيمة الرقم الأول
     */
    switch (parseInt(first)) {
        case 0:
            value = hundreds["0"];
            break;
        case 1:
            value = hundreds["1"];
            break;
        case 2:
            value = hundreds["2"];
            break;
        case 3:
            value = hundreds["3"];
            break;
        case 4:
            value = hundreds["4"];
            break;
        case 5:
            value = hundreds["5"];
            break;
        case 6:
            value = hundreds["6"];
            break;
        case 7:
            value = hundreds["7"];
            break;
        case 8:
            value = hundreds["8"];
            break;
        case 9:
            value = hundreds["9"];
            break;
    }

    /**
     * إضافة منزلة العشرات إلى الرقم المفقط
     * باستخدام دالة العشرات السابقة
     */
    value = value + " و"+oneTen (parseInt (getNth (number,1,2)));
    return value;
}

/**
 *
 * @param {*} number
 * الدالة الخاصة بالآلاف
 */
function thousand(number) {
    return thousandsTrillions (thousands["1"],thousands["2"], thousands["39"], thousands["1199"], 0, parseInt (number),  (getNthReverse (number, 4)));
}

/**
 *
 * @param {*} number
 * الدالة الخاصة بالملايين
 */
function million(number) {
    return thousandsTrillions (millions["1"],millions["2"], millions["39"], millions["1199"], 3, parseInt (number),  (getNthReverse (number, 7)));
}


/**
 *
 * @param {*} number
 * الدالة الخاصة بالمليارات
 */
function billion(number) {
    return thousandsTrillions (billions["1"],billions["2"], billions["39"], billions["1199"], 6, parseInt (number),  (getNthReverse (number, 10)));
}


/**
 *
 * @param {*} number
 * الدالة الخاصة بالترليونات
 */
function trillion(number) {
    return thousandsTrillions (trillions["1"],trillions["2"], trillions["39"], trillions["1199"], 9, parseInt (number),  (getNthReverse (number, 13)));
}


/**
 * هذه الدالة هي الأساسية بالنسبة للأرقام
 * من الآلاف وحتى التريليونات
 * تقوم هذه الدالة بنفس العملية للمنازل السابقة مع اختلاف
 * زيادة عدد المنازل في كل مرة
 * @param {*} one
 * @param {*} two
 * @param {*} three
 * @param {*} eleven
 * @param {*} diff
 * @param {*} number
 * @param {*} other
 */
function thousandsTrillions (one, two, three, eleven, diff, number, other){
    /**
     * جلب المنازل المتبقية
     */
    other = parseInt (other);
    other = tafqeet (other);

    /**
     * إذا كان المتبقي يساوي صفر
     */
    if (other == ""){
        other = "صفر"
    }

    var value = "";

    number = parseInt (number);

    /**
     * التحقق من طول الرقم
     * لاكتشاف إلى أي منزلة ينتمي
     */
    switch (number.toString().length){
        /**
         * ألوف، أو ملايين، أو مليارات، أو تريليونات
         */
        case 4+diff:
            var ones = parseInt (getNth (number, 0,0));
            switch (ones){
                case 1:
                    value = one  + " و"+ (other);
                    break;
                case 2:
                    value = two + " و"+ (other);
                    break;
                default:
                    value = oneTen (ones) +" "+ three + " و"+ (other);
                    break;
            }
            break;

        /**
         * عشرات الألوف، أو عشرات الملايين، أو عشرات المليارات، أو عشرات التريليونات
         */
        case 5+diff:
            var tens = parseInt (getNth (number, 0,1));
            switch (tens){
                case 10:
                    value = oneTen (tens) +" "+ three + " و"+ (other);
                    break;
                default:
                    value = oneTen (tens) +" "+ eleven + " و"+ (other);
                    break;
            }
            break;

        /**
         *مئات الألوف، أو مئات الملايين، أو مئات المليارات
         */
        case 6+diff:
            var hundreds = parseInt (getNth (number, 0,2));

            var two = parseInt (getNth (number, 1,2));
            var th = "";
            switch (two){
                case 0:
                    th = one;
                    break;

                default:
                    th = eleven;
                    break;
            }
            switch (tens){
                case 100<=tens<=199:
                    value = hundred (hundreds) +" "+ th + " و"+ (other);
                    break;
                case 200<=tens<=299:
                    value = hundred (hundreds) +" "+ th + " و"+ (other);
                    break;
                default:
                    value = hundred (hundreds) +" "+ th + " و"+ (other);
                    break;
            }
            break;
    }

    return value;

}


/**
 * دالة لجلب أجزاء من الرقم المراد تفقيطه
 */
function getNth(number, first, end){
    var finalNumber = "";
    for (var i=first;i<=end;i++){
        finalNumber = finalNumber + String (number).charAt(i);
    }
    return finalNumber;
}

/**
 * دالة تجلب أجزاء من الرقم بالعكس
 * @param {*} number
 * @param {*} limit
 */
function getNthReverse(number, limit){
    var finalNumber = "";
    var x = 1;
    while (x != limit){
        finalNumber = String (number).charAt(number.toString().length-x) + finalNumber;
        x++;
    }

    return finalNumber;
}
</script>
<script>
$(document).ready(function() {
     $.each($('.x'), function (key, value) {
           var tafqeet_number = tafqeet ($(this).data('id'));

$(this).append(`<p> ${tafqeet_number}</p>` );
     })

})
</script>
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


                      $('.test_type').on('change', function () {




  $('#mydiv').empty();
  if($(this).val()==1){

    var type="";
      type+=`
  @if ($count!=0)

      <form action="{{ route('student_mark' ) }}" method="post">
      @csrf
  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">شفوية</th>




                    </tr>
                  </thead>
                  <tbody class="list">

                    @if ($students)


                      @foreach ($students->student as $item)

                     <tr>




                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>


      <form action="{{ route('student_mark')}}" method="post">
      @csrf
          @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['oral'] }}" name="oral[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach


                     @endif


                  </tbody>
                </table>
                <button class="btn btn-success">Click</button>
              </form>
              @endif


  `;

  }else if($(this).val()==2){
      type="";

      type+=`
      @if ($count!=0)

      <form action="{{ route('student_mark') }}" method="post">
      @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">وظائف و أوراق عمل</th>



                      {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

                    </tr>
                  </thead>
                  <tbody class="list">


                    @if ($students)

                      @foreach ($students->student as $item)

                     <tr>

                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>

                      {{-- <td class="text-right">
                          <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
                              data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                                  title="Delete">&#xE872; Delete</i></a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                          </div>

                        </td> --}}

                        @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['homework'] }}" name="homework[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach


                     @endif


                  </tbody>
                </table>
                <button class="btn btn-success">Click</button>

              </form>
              @endif

  `;

  }else if($(this).val()==3){
      type="";

      type+=`
      @if ($count!=0)

      <form action="{{ route('student_mark') }}" method="post">
      @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">نشاطات و مبادرات</th>



                      {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

                    </tr>
                  </thead>
                  <tbody class="list">


                    @if ($students)

                      @foreach ($students->student as $item)

                     <tr>

                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>

                      {{-- <td class="text-right">
                          <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
                              data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                                  title="Delete">&#xE872; Delete</i></a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                          </div>

                        </td> --}}


                        @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['activities'] }}" name="activities[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach

                     @endif



                  </tbody>
                </table>
                <button class="btn btn-success">Click</button>
              </form>

              @endif
  `;}
  else if($(this).val()==4){
      type="";

      type+=`
      @if ($count!=0)

      <form action="{{ route('student_mark' ) }}" method="post">
      @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">مذاكرة</th>



                      {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

                    </tr>
                  </thead>
                  <tbody class="list">


                    @if ($students)

                      @foreach ($students->student as $item)

                     <tr>

                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>

                      {{-- <td class="text-right">
                          <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
                              data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                                  title="Delete">&#xE872; Delete</i></a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                          </div>

                        </td> --}}



                        @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['quize'] }}" name="quize[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach


                     @endif


                  </tbody>
                </table>

                <button class="btn btn-success">Click</button>
              </form>

              @endif

  `;}

  else if($(this).val()==5){
      type="";

      type+=`
      @if ($count!=0)

      <form action="{{ route('student_mark') }}" method="post">
                          @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">درجة اختبار الفصل الأول	</th>




                    </tr>
                  </thead>
                  <tbody class="list">



                    @if ($students)
                      @foreach ($students->student as $item)

                     <tr>


                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>




                          @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['exam'] }}" name="exam[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach

                     @endif



                  </tbody>
                </table>
                <button class="btn btn-success">Click</button>

              </form>
              @endif

  `;

  }

  $('#mydiv').append(type);


  });












  // ==================================================================================================
















                      });
                      </script>






                    @endsection
