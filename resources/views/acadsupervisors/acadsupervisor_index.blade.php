@extends('acadsupervisors.master')
@section('css')
<style>
    /*select and option */
    :root {
        /*--background-gradient: linear-gradient(30deg, #4986fc 30%, #fc4967);*/
        --gray: white;
        --darkgray: white;
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
        color: rgb(160, 156, 156);

        background-color: var(--darkgray);
        background-image: none;
        cursor: pointer;


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

        /*float: left;
  text-align: left;*/


    }

    /* Arrow */
    .select::after {
        content: '\25BC';
        position: absolute;
        top: 0;
        right: 0;
        padding: 1em;
        background-color: white;
        transition: .25s all ease;
        pointer-events: none;
        /*float: left;
  text-align: left;*/

    }

    /* Transition */
    .select:hover::after {
        color: #094e89;
        /*text-align: left;
  float: left;*/


    }

    /* Other styles*/


    /*end select */
    /*start add event */
    /*style tablist*/
    /* section add content */
    @import "bourbon";
    @import 'https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,400';



    .tabs {
        left: 50%;
        transform: translateX(-50%);
        position: relative;
        background: linear-gradient(to right top, #2c71ad 20%, rgb(132, 167, 196));
        padding: 20px;
        padding-bottom: 80px;
        width: 80%;
        height: auto;
        box-shadow: 0 8px 10px rgba(0, 0, 0, 0.), 0 5px 7px rgba(0, 0, 0, 0.22);
        border-radius: 10px;
        min-width: 240px;
        direction: rtl;

    }

    .tabs input[name="tab-control"] {
        display: none;
    }

    .tabs .content section h2,
    .tabs ul li label {
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
        color: rgb(212, 209, 209);

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
        fill: rgb(212, 209, 209);
        ;
        height: 1.2em;
        vertical-align: bottom;
        margin-right: 0.2em;
        transition: all 0.2s ease-in-out;
    }

    .tabs ul li label:hover,
    .tabs ul li label:focus,
    .tabs ul li label:active {
        outline: 0;
        color: white;

    }

    .tabs ul li label:hover svg,
    .tabs ul li label:focus svg,
    .tabs ul li label:active svg {
        fill: white;

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
        color: white;
        display: none;
    }

    .tabs .content section h2::after {
        content: "";
        position: relative;
        display: block;
        width: 30px;
        height: 3px;
        background: white;
        margin-top: 5px;
        left: 1px;
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label svg {
        fill: white;
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
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label svg {
        fill: white;
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
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label svg {
        fill: white;
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
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label svg {
        fill: white;
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

    /*tab 5*/
    .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.content>section:nth-child(5) {
        display: block;
    }
     /*tab 6*/
    .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~.content>section:nth-child(6) {
        display: block;
    }
     /*tab 7*/
    .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~.content>section:nth-child(7) {
        display: block;
    }
    
     /*tab 8*/
    .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~.content>section:nth-child(8) {
        display: block;
    }
    
     /*tab 9*/
    .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~.content>section:nth-child(9) {
        display: block;
    }
     /*tab 10*/
    .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~.content>section:nth-child(10) {
        display: block;
    }

 /*tab 11*/
    .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~.content>section:nth-child(11) {
        display: block;
    }
    
     /*tab 12*/
    .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~.content>section:nth-child(12) {
        display: block;
    }
      /*tab 13*/
    .tabs input[name="tab-control"]:nth-of-type(13):checked~ul>li:nth-child(13)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(13):checked~ul>li:nth-child(13)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(13):checked~ul>li:nth-child(13)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(13):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(13):checked~.content>section:nth-child(13) {
        display: block;
    }
       /*tab 14*/
    .tabs input[name="tab-control"]:nth-of-type(14):checked~ul>li:nth-child(14)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(14):checked~ul>li:nth-child(14)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(14):checked~ul>li:nth-child(14)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(14):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(14):checked~.content>section:nth-child(14) {
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

    /*end style tablist*/
    /* cards of marks */
    .cards-list {
        z-index: 0;
        width: 100%;
        display: flex;
        /*justify-content: space-around;*/
        flex-wrap: wrap;
    }

    .card2 {
        margin: 30px auto;
        width: 180px;
        height: 180px;
        border-radius: 15px;
        /*box-shadow: 1px 1px 10px 2px rgba(0,0,0,0.22), -1px -1px 10px 2px rgba(0,0,0,0.20);*/
        cursor: pointer;
        transition: 0.4s;
        border-color: 10px solid white;
    }

    .card2 .card_image {
        width: inherit;
        height: inherit;
        border-radius: 15px;
        border-color: 10px solid white;
    }

    .card2 .card_image img {
        width: inherit;
        height: inherit;
        border-radius: 15px;
        object-fit: cover;
        /* opacity: #f38639 10%;
  border-color: 10px solid white;*/
    }

    .card2 .card_title {
        text-align: center;
        border-radius: 0px 0px 40px 40px;
        font-family: sans-serif;
        font-weight: bold;
        font-size: 30px;
        margin-top: 35px;
        height: 40px;
    }

    .card2:hover {
        border-color: 10px solid white;
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


    /*
.card {
  margin: 30px auto;
  width: 300px;
  height: 300px;
  border-radius: 40px;
  background-image: url('https://i.redd.it/b3esnz5ra34y.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  background-repeat: no-repeat;
box-shadow: 5px 5px 30px 7px rgba(0,0,0,0.25), -5px -5px 30px 7px rgba(0,0,0,0.22);
  transition: 0.4s;
}
*/
</style>



@endsection
@section('content')



<!-- END nav -->

<div class="hero-wrap js-fullheight" style="background-image:url( {{  asset('teachers/ppp.jpg') }}); height: 200px;">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
            <!--div class="col-md-7 ftco-animate">
         <span class="subheading">Welcome to StudyLab</span>
         <h1 class="mb-4">We Are Online Platform For Make Learn</h1>
         <p class="caps">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
         <p class="mb-0"><a href="#" class="btn btn-primary">Our Course</a> <a href="#" class="btn btn-white">Learn More</a></p>
     </div-->
        </div>
    </div>
</div>
<!-- new section-->

<div style="margin-top: 60px; border-top-right-radius: 100px 50px; " id="class">
    <div class="col-md-12 heading-section text-center ftco-animate">
        <span class="subheading"></span>
        <h2 class="mb-4" style="color: #f38639; ">الصفوف</h2>
    </div>
    <!-- start tablist -->
    <div class="tabs">
        @php
        $i=0;
        @endphp
        @foreach ($classes as $item )


        @php
        $i=$i+1;
        @endphp

        @if ($i==1)
        <input type="radio" value="{{$item->id }}" id="tab{{ $item->id }}" name="tab-control" checked>
        @else
        <input type="radio" value="{{$item->id }}" id="tab{{ $item->id }}" name="tab-control" >
        @endif
        @endforeach

        <ul>
            @foreach ($classes as $item )
            <li title="{{ $item->name }} "><label for="tab{{ $item->id }}" role="button">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,
                        10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,
                        4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,
                        3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                    </svg>
                    <span> {{ $item->name }} </span></label></li> &nbsp;&nbsp;&nbsp;&nbsp;

            @endforeach
        </ul>


        <div class="">
            <div class="indicator"></div>
        </div>

        <div class="content">
            <!-- start  mark subject-->
            @foreach ($classes as $item )
            <section style="direction: rtl; text-align:right">
                <h2>{{ $item->name }}  </h2>

                <div class="cards-list">
                    @foreach ( $item->room as $item1 )
                   
                      @php
                      $i2=0;
                      @endphp
                   

                    @php
                    $i2=$i2+1;        
                    @endphp
                   
              
         
                    <div class="card2 1">
                        <a href="{{ route('dashboard.acadsupervisor_subject',['room_id' =>$item1->id])}}" >
                        <div class="card_image">
                            @if( $i2 % 2 ==0)
                             <img style="height: 180px;width:180px"  src="{{  asset('teachers/photo/room-5.png') }}" />
                             @else
                             <img    style="height: 180px; width:180px" src="{{  asset('teachers/photo/room-4.png') }}" />
                             @endif
                        </div>
                        <div class="card_title title-white">
                            <p> {{ $item1->name }} </p>
                        </div>
                        </a>
                    </div> 

                   
                    @endforeach
             
                </div>


            </section>
@endforeach


        </div>
    </div>
    <!-- end add content -->
    <!-- end tablist -->


</div>

<br>
<br>
<br>
<!-- end new section-->






<!-- start event -->
<!-- start event -->


<!-- end event -->
{{-- <section class="ftco-section" id="message" >
    <input type="hidden" name="" id="teacher_id" value="{{ $teacher->id }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="wrapper">
                    <div class="row no-gutters">
                        <div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch">
                            <div class="contact-wrap w-100 p-md-5 p-4"
                            style="direction: rtl; text-align:right; box-shadow: 1px 1px 10px 2px rgba(0,0,0,0.22), -1px -1px 10px 2px rgba(0,0,0,0.20);">
                                <br>
                                <br>
                                <br>

                                <h3 class="mb-4" style="color: #094e89">ارسال رسائل  </h3>
                                <form action="{{ route('dashboard.send_group_message') }}" method="post">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="hidden" name="teacher_id" id="" value="{{ $teacher->id }}">
                                                <label class="label" style="color: #f38639; font-size: 20px;"> &nbsp;&nbsp;الصف &nbsp;</label>
                                                <div class="select"  >
                                                    <select id="classes" style="text-align: center; background-color: white;">
                                                        <option value="" style="text-align: center;">اختر الصف </option>
                                                        @foreach ($classes as $item )
                                                        <option value="{{ $item->id }}" style="text-align: center;">
                                                            {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                  </div>
                                                <!--input type="text" class="form-control" name="name" id="name" placeholder="Name"-->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label"  style="color:  #f38639; font-size: 20px;">الشعبة </label>
                                                <div class="select" >
                                                    <select  id="rooms" name="room_id" style="text-align: center;background-color: white;">

                                                            <option value="" style="text-align: center;">اختر الشعبة
                                                            </option>


                                                    </select>
                                                  </div>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label" style="color: #094e89;font-size: 20px;">اكتب الرسالة  ..</label>
                                                <textarea name="message" class="form-control" id="message" cols="30"
                                                rows="4" placeholder=""></textarea>

                                            </div>
                                        </div>

                                        <div class="col-md-12" style="margin-top: 190px;">
                                            <div class="form-group">
                                                <input type="submit" value="ارسال لجميع الطلاب " class="btn btn-primary">
                                                <div class="submitting"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 d-flex align-items-stretch"
                        style="text-align: rigtht;
                        direction: rtl; box-shadow: 1px 1px 10px 2px rgba(0,0,0,0.22),
                         -1px -1px 10px 2px rgba(0,0,0,0.20);
                         ">
                            <div class="info-wrap bg-primary w-100 p-md-5 p-4" >
                                <form action="{{ route('dashboard.send_message') }}" method="post">
                                    @csrf
                                <h3 style="text-align: center;">ارسال رسالة الى الطالب </h3>
                                <p class="mb-4"></p>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <!--div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-map-marker"></span>
                                    </div-->
                                    <br>
                                    <div class="text pl-3"  >


                                          <h6 style="text-align:right; font-size: 20px;color:white"> الصف </h6>
                                            <div class="select" style="width: 250px; ">
                                                <input type="hidden" name="teacher_id" id="" value="{{ $teacher->id }}">
                                                <select id="classes1" style="text-align: center;background-color: white;">

                                                        <option style="text-align: center;">اختر الصف</option>
                                                        @foreach ($classes as $item )

                                                        <option value="{{ $item->id }}" style="text-align: center;">
                                                            {{ $item->name }}</option>


                                                        @endforeach
                                                    </select>
                                              </div>

                                    </div>
                                </div>


                                <div class="dbox w-100 d-flex align-items-center">
                                    <!--div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-phone"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
                                    </div-->
                                    <div class="text pl-3" >


                                        <h6 style="text-align:right; font-size: 20px;color:white"> الشعبة </h6>
                                        <div class="select" style="width: 250px;">
                                            <select  id="rooms1" name="student_id"style="text-align: center;background-color: white;">

                                                    <option style="text-align: center;" value="">اختر الشعبة</option>


                                            </select>
                                          </div>

                                </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center">

                                    <div class="text pl-3">
                                        <h6 style="text-align:right; font-size: 20px; color:white"> الطالب </h6>
                                        <div class="select" style="width: 250px;">
                                            <select id="mydiv" style="text-align: center;background-color: white;">

                                                    <option style="text-align: center;" value="">اختر الطالب </option>

                                            </select>
                                          </div>
                                    </div>
                                </div>
                                <!--div class="dbox w-100 d-flex align-items-center" >
                                    <div class="text pl-3" >
                                        <h6 style="text-align:right; "> اكتب الرسالة </h6>
                                        <textarea  style="float: right;"    name="message" class="form-control" id="message" cols="" rows="4" placeholder=""></textarea>
                                    </div>
                                </div-->
                                <br>

                                <div class="dbox w-100 d-flex align-items-center">

                                    <div style="margin: 0 auto ;" >
                                        <h6 style="text-align:center; font-size: 20px;"> اكتب الرسالة ..</h6>
                                        <textarea name="message" class="form-control" id="message" cols="30"
                                                rows="4" placeholder=""></textarea>

                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center">

                                    <div style="margin:0 auto;">
                                        <input type="submit" value="ارسال  " class="btn " style=" background: linear-gradient(to right top,  rgb(132, 167, 196) 20%,  #094e89) ;border: none; width: 180px; color: white;">
                                                <div class="submitting"></div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section> --}}





<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>





@endsection
@section('js')



<script>
    $(document).ready(function () {


        $(document).on('change', '#classes2', function () {
            var teacher_id = $('#teacher_id').val();
            var class_id = $(this).val();
            var url = "{{ URL::to('SMARMANger/dashboard/teacher/class/rooms') }}/" + class_id + "/" +
                teacher_id;
            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
                    console.log(data);
                    $('#room3').empty();
                    $('#room3').append(
                        `<option value="" style="text-align: center;">اختر الشعبة  </option>`
                        )

                    $.each(data, function (key, value) {
                        $('#room3').append(
                            `<option style="text-align: center;" value="${value.id}">${value.name}</option>`
                            )



                    });




                },
                error: function (xhr) {

                }

            });
        })


        $(document).on('change', '#classes', function () {
            var teacher_id = $('#teacher_id').val();
            var class_id = $(this).val();
            var url = "{{ URL::to('SMARMANger/dashboard/teacher/class/rooms') }}/" + class_id + "/" +
                teacher_id;
            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
                    console.log(data);
                    $('#rooms').empty();
                    $('#rooms').append(
                        `<option value="" style="text-align: center;">اختر الشعبة  </option>`
                        )

                    $.each(data, function (key, value) {
                        $('#rooms').append(
                            `<option style="text-align: center;" value="${value.id}">${value.name}</option>`
                            )



                    });




                },
                error: function (xhr) {

                }

            });
        })




        $(document).on('change', '#classes1', function () {
            var teacher_id = $('#teacher_id').val();
            var class_id = $(this).val();
            var url = "{{ URL::to('SMARMANger/dashboard/teacher/class/rooms') }}/" + class_id + "/" +
                teacher_id;
            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
                    console.log(data);
                    $('#rooms1').empty();
                    $('#rooms1').append(
                        `<option value="" style="text-align: center;">اختر الشعبة </option>`
                        )

                    $.each(data, function (key, value) {
                        $('#rooms1').append(
                            `<option style="text-align: center;" value="${value.id}">${value.name}</option>`
                            )



                    });




                },
                error: function (xhr) {

                }

            });

        });

        $(document).on('change', '#rooms1', function () {

            var teacher_id = $('#teacher_id').val();
            var room_id = $(this).val();

            $('#group_message').attr('href',
                "{{ URL::to('SMARMANger/dashboard/teacher/write_group_message') }}/" + room_id);



            var url = "{{ URL::to('SMARMANger/dashboard/teacher/room/students/') }}/" + room_id;
            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {

                    console.log(data);
                    $('#mydiv').empty();

                    $.each(data, function (key, value) {

                        $('#mydiv').append(`<option  style="text-align: center;" value="${value.id}">${value.first_name}
                        ${value.father_name} ${value.last_name}</option>`);
                    });




                },
                error: function (xhr) {

                }

            });

        });
        $(document).on('change', '#rooms', function () {

            var teacher_id = $('#teacher_id').val();
            var room_id = $(this).val();
            var url = "{{ URL::to('SMARMANger/dashboard/teacher/class/rooms/lessons') }}/" + room_id +
                "/" + teacher_id;
            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {

                    console.log(data);
                    $('#lesson').empty();
                    $('#lesson').append(`<option value="">
                    Choose subject </option>`);
                    $.each(data, function (key, value) {

                        $('#lesson').append(`<option style="text-align: center;" value="${value.id}">${value.name_en}
                        </option>`);
                    });




                },
                error: function (xhr) {

                }

            });

        });


    })
</script>

@endsection
