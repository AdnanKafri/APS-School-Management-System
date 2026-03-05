@extends('coordinators.master')
@section('title')
School
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<style>
      :root {
  --rad: 0.6rem;
  --color-dark: white;
  --color-light: #84a7c4;
  --color-brand: #f38639;
  --font-fam: 'Lato', sans-serif;
  --height: 3rem;
  --btn-width: 3rem;
  --bez: cubic-bezier(0, 0, 0.43, 1.49);
}

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
        box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
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

    .card .card-statistic-3 .card-icon-large .fas,
    .card .card-statistic-3 .card-icon-large .far,
    .card .card-statistic-3 .card-icon-large .fab,
    .card .card-statistic-3 .card-icon-large .fal {
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

    .tabs .content section h2,
    .tabs ul li label {
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

    .tabs ul li label:hover,
    .tabs ul li label:focus,
    .tabs ul li label:active {
        outline: 0;
        color: #bec5cf;
    }

    .tabs ul li label:hover svg,
    .tabs ul li label:focus svg,
    .tabs ul li label:active svg {
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

    .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
        cursor: default;
        color: #f38639;
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~.content>section:nth-child(1) {
        display: block;
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
        cursor: default;
        color: #f38639;
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~.slider {
        transform: translateX(100%);
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~.content>section:nth-child(2) {
        display: block;
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
        cursor: default;
        color: #f38639;
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~.slider {
        transform: translateX(200%);
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~.content>section:nth-child(3) {
        display: block;
    }

    /*tab 4*/
    .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
        cursor: default;
        color: #1068b4;
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label svg {
        fill: #1068b4;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~.content>section:nth-child(4) {
        display: block;
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.content>section:nth-child(5) {
        display: block;
    }

    /*tab 5*/
    .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
        cursor: default;
        color: #1068b4;
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label svg {
        fill: #1068b4;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.content>section:nth-child(5) {
        display: block;
    }

    /*tab 6*/
    .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~.content>section:nth-child(6) {
        display: block;
    }

    /*tab 7*/
    .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~.content>section:nth-child(7) {
        display: block;
    }

    /*tab 8*/
    .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~.content>section:nth-child(8) {
        display: block;
    }

    /*tab 9*/
    .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~.content>section:nth-child(9) {
        display: block;
    }

    /*tab 10*/
    .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~.content>section:nth-child(10) {
        display: block;
    }

    /*tab 11*/
    .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~.content>section:nth-child(11) {
        display: block;
    }

    /*tab 12*/
    .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~.content>section:nth-child(12) {
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
        box-shadow: 1px 1px 10px 2px rgba(0, 0, 0, 0.22), -1px -1px 10px 2px rgba(0, 0, 0, 0.20);
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

    a {
        color: #fff ;
        font-size: 16px !important;
    }

    div#ui_notifIt p {
        color: #fff;
    }
    input[type="search"] {
  outline: 0;
  width: 100%;
  background: var(--color-light);
  padding: 0 1.5rem;
  border-radius: var(--rad);
  appearance: none;
  transition: all var(--dur) var(--bez);
  transition-property: width, border-radius;
  z-index: 1;
  position: relative;


} #new{
  position: relative;
  width: 19rem;
  background: var(--color-brand);
  border-color: #f38639;
  border-radius: var(--rad);

  margin: 0 auto;


}
label {
  position: absolute;
  clip: rect(1px, 1px, 1px, 1px);
  padding: 0;
  border: 0;
  height: 1px;
  width: 1px;
  overflow: hidden;
}
.page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #5c8eba;
    border-color: #5c8eba;}
    .page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #5c8eba !important;
    background-color: #fff;
    border: 1px solid #dee2e6;}

</style>


<section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2">
                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread">  تحليل الوحدة  </h1>
            </div>
        </div>
    </div>
</section>
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">  تحليل الوحدة </a>
     <a  href="{{ route('dashboard.coordinator_teacher',[$class_id->id,$teacher->id, $lesson_id->id ]) }}" class="breadcrumbs__item "> {{ $teacher->first_name }}  {{ $teacher->last_name }}   </a>
    <a  href="{{ route('dashboard.coordinator_subject',$class_id->id ) }}" class="breadcrumbs__item ">{{ $class_id->name }}   </a>
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<!-- start new-->

<div class="col-md-12 " style="margin: auto; direction: rtl; text-align:center">


    <div class="row">
        <h1 class="title text-center w-100 m-5" style="text-align: center"> </h1>
        <br><br><br><br>
        <form  id="new"   onsubmit="event.preventDefault();" role="search" style="direction: rtl;margin: auto;">
            <label for="search" style="direction: rtl;"></label>
            <input id="search" type="search"  style="color: white;" placeholder="البحث .."  />

          </form>


        <br><br><br><br>
        <input hidden type="text" id="teacher_id" value="{{ $teacher->id }}" name="class_id">
            <input hidden type="text" id="class_id" value="{{ $class_id->id }}">


            <input hidden type="text" id="lesson_id" value="{{ $lesson_id ->id }}" name="lesson_id">
            <input hidden type="text"   id="year" value="{{ $year ->id }}" name="year_id">
            <input hidden type="text" id="term" value="{{ $term ->id }}" name="term_id">

            <input hidden type="text"  id="conatin" name="conatin">


            @foreach ($unit as $item)
           <div style="overflow-x: auto;width: 100%;">
           <table id="example" class="table  table1 table-bordered table-responsive"
        style="direction: rtl !important;text-align: center !important;display:inline-table">
                <thead>
                    <tr>
                        <th scope="col" style="border: none !important;">
                            {{ $term->term }}
                        </th>
                        <th scope="col" style="border: none !important;">
                            الصف : &nbsp;{{ $class_id->name }}
                        </th>
                        <th scope="col" style="border: none !important;">
                            المادة : &nbsp;{{ $lesson_id->name }}
                        </th>
                        <th scope="col" span="2" style="border: none !important;">
                            عنوان الوحدة  :
                        </th>
                        <th scope="col" span="2"   id="unit_name"  style="border: none !important;">
                            <p style="margin: auto;" >
                               {{ $item->unit_name }} 
                            </p>
                           
                             <input hidden type="text"  value="{{ $item->id }}" name="unitid">
                        </th>
                    </tr>

                    <tr>
                        <th scope="col">
                            عنوان الدرس

                        </th>
                        <th scope="col">
                            المصطلحات والمفاهيم
                        </th>
                        <th scope="col">
                            مؤشرات الأداء لمستهدفة
                           ( نواتج التعلم )

                        </th>
                        <th scope="col">
                            استراتيجيات  وطرائق التدريس
                        </th>
                        <th scope="col">
                            أنشطة التعلم
                        </th>
                        <th scope="col">
                            التقييم من أجل
                            التعلم

                        </th>
                        <th scope="col">
                       ملاحظات

                        </th>



                    </tr>

                </thead>
                <tbody>
                    @php
                    $i=0
                @endphp

                @foreach (json_decode($item->contain) as $key=>$item1)
                <tr >
                  @php
                  $i=$i+1
                   @endphp
                   @if ($key==$i)
                   <td >
                    <input type="text" hidden class="i" value="{{ $i }}">
                       {{ $item1[0] }} 

                  </td>
                  <td >
                       {{ $item1[1] }}
                  </td>
                  <td >
                    {{ $item1[2] }} 
                  </td>
                  <td >
                     {{ $item1[3] }}
                  </td>
                  <td>
                       {{ $item1[4] }}
                  </td>
                  <td >
                      {{ $item1[5] }} 
                  </td>
                  <td >
                     {{ $item1[6] }} 

                   @endif


               </tr>
         @endforeach
        

            

                </tbody>
            </table>
            </div>
            @endforeach
            <div class="btn"  style="float: left; padding-right: 700px;">
                {{ $unit->links() }}

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

     


@endsection
@section('js')
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script   src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script   src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script   src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script   src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script   src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script   src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script   src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script>
$(document).ready(function () {
    
 $('#example').DataTable( {
           columnDefs: [ { type: 'date', 'targets': [3] } ],
   order: [[ 3, 'desc' ]],    
      dom: 'Bfrtip',
       
        buttons: [
        
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
         
        ],
          
} );
  
//     $('#example').DataTable( {
//       dom: 'Bfrtip',
//         buttons: [
//              {
//                 extend: 'copyHtml5',
//                 exportOptions: {
//                     columns: [ ':visible' ]
//                 }
//             },
//             {
//                 extend: 'csvHtml5',
//                 exportOptions: {
//                     columns: [ ':visible' ]
//                 }
//             },
//             {
//                 extend: 'excelHtml5',
//                 exportOptions: {
//                     columns: ':visible'
//                 }
//             },
//             {
//                 extend: 'pdfHtml5',
                 
//                               exportOptions: {
//                   columns: [ ':visible' ],
 
                         
                     
 
                     
 
 
//                 }
//             },
//         ]
// } );
});
    $(document).ready(function(){

        comt={};
                 comt1=[];
                 for(i=1;i<50;i++){
                    comt1=[];
 $.each($('.comt'), function (key, value) {


    if($(this).data('id')==i){
        if($(this).val()){
            comt1.push($(this).val())

          comt[i]=comt1;

        }

    }

$('#conatin').val(JSON.stringify(comt));

 })


                 }
                 console.log(comt);


    })










$(document).on('keyup', '#search', function () {
            var lect=$('#search').val();
            var class_id=$('#class_id').val();
            var lesson_id=$('#lesson_id').val();
            var term=$('#term').val();
            var year=$('#year').val();
             var teacher_id=$('#teacher_id').val();
            

                    var data={
                            "search":lect,
                            "class_id":class_id,
                            "lesson_id":lesson_id,
                             "teacher_id":teacher_id,
                            "term":term,
                            "year":year,


                        }
                        $('.table1 tbody').empty();
                          $('#unit_name').empty();
                    var url = "{{ URL::to('SMARMANger/dashboard/coordinator/searchunitteacher') }}";
                $.ajax({
                    url: url,
                    data : data,
                    type: "get",
                    contentType: 'application/json',
                    success: function (data) {
                        console.log(data);
  if ($.fn.DataTable.isDataTable('.table1')) {
                             $('#example').DataTable().destroy();
                              }
                               $('.table1 tbody').empty();
                               
                                $('#unit_name').empty();
                                
                        $('#unit_name').append(`<p style="margin: auto;">${data.unit_name}</p>`);
i=0;
                        $.each(JSON.parse(data.contain), function (key, value) {
                            i=i+1;
                            if(i==key){
                                $('.table1 tbody').append(`<tr >


<td >
    <input type="text" hidden class="i" value="${i}">
  ${value[0] }
</td>
<td >
   ${value[1] } 
</td>
<td >
  ${value[2] }
</td>
<td >
  ${value[3] }
</td>
<td>
    ${value[4] }
</td>
<td >
   ${value[5] } 
</td>
<td >
  ${value[6] } 
</td>




</tr>
`)

                            }

                        })
                    

 $('#example').DataTable( {
           columnDefs: [ { type: 'date', 'targets': [3] } ],
   order: [[ 3, 'desc' ]],    
      dom: 'Bfrtip',
       
        buttons: [
        
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
         
        ],
          
} );


                    },
                    error: function (xhr) {

                    }

                })

        })






$(document).on('change', '.comt', function () {
    comt={};
                 comt1=[];
                 for(i=1;i<50;i++){
                    comt1=[];
 $.each($('.comt'), function (key, value) {


    if($(this).data('id')==i){
        if($(this).val()){
            comt1.push($(this).val())

          comt[i]=comt1;

        }

    }

$('#conatin').val(JSON.stringify(comt));

 })


                 }
                 console.log(comt);
})
   




</script>


@endsection
