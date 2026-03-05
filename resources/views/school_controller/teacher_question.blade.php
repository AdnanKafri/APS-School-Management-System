@extends('school_controller.layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('teachers_2/assets/css/newteacher.css')}}">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
 integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
 crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
                                        

 <style>
 .my-element {
  display: inline-block;
  margin: 0 0.5rem;
  animation: bounce 4s infinite;
    animation-delay: 0.5s; /* don't forget to set a duration! */
}
.my-element:hover {
  animation-play-state: paused; /* pause the animation when hovering */
}
.fa-solid{
    position: relative;
    top: 13px;
}
 @media(min-width:200px) and (max-width:900px){
     .showstate{
         width:100px !important;
     }
 }
 .addquestion::before {
            content: "";
            background-color: #14315C !important;
            width: 0;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            transition: width 700ms ease-in-out;
            display: inline-block;
        }

        .addquestion {
            box-shadow: #14315C 0px 4px 0px 0px;
        }



        @media(min-width:200px) and (max-width:900px) {
            .showstate {
                width: 100px !important;
            }
        }

        .card .card-body {
            padding: 0px 0px;
            padding-bottom: 20px;
        }

        table {
            border: 1px solid #ccc;
            border-collapse: collapse !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;

        }

        table caption {
            font-size: 1.5em !important;
            margin: .25em 0 .75em !important;
        }

        table tr {
            background: #f8f8f8 !important;
            border: 1px solid #ddd;
            padding: .35em !important;
        }

        table th,
        table td {
            padding: .625em !important;
            text-align: center !important;
        }

        table th {
            font-size: 20px !important;

        }

        table td img {
            text-align: center;
        }

        @media screen and (max-width: 900px) {

            table {
                border: none !important;
            }


            table thead {
                display: none !important;
            }

            table tr {
                /*border-bottom: 3px solid #ddd!important ;*/
                border-bottom: none !important;
                border-top: none !important;
                border-left: none !important;
                border-right: none !important;
                display: block !important;
                margin-bottom: .625em !important;
            }

            table td {
                padding: 10px !important;
                border-top: 1px solid #ddd !important;
                border-bottom: none !important;
                display: block !important;
                font-size: .8em !important;
                text-align: right !important;
            }

            table td:before {
                content: attr(data-label) !important;
                float: left !important;
                font-weight: bold !important;

            }

            table td:last-child {
                border-bottom: 1px solid #ddd !important;
                border-right: 1px solid #ddd;
            }


        }

        /*حالة الامتحان*/
        .showstate {
            width: 106px;
            background: transparent;
            position: relative;
            /*padding: 5px 15px;*/
            padding-right: 18px;
            padding-top: 5px;
            padding-bottom: 5px;
            display: flex;
            align-items: center;
            font-size: 16px;

            text-decoration: none;
            cursor: pointer;
            border: 1px solid #152C4F;
            border-radius: 25px;
            outline: none;
            overflow: hidden;
            color: #152C4F;
            transition: color 0.3s 0.1s ease-out;
            text-align: center;
        }

        .showstate span {
            margin: 6px;
        }

        .showstate::before {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            content: '';
            border-radius: 50%;
            display: block;
            width: 20em;
            height: 20em;
            left: -5em;
            text-align: center;
            transition: box-shadow 0.5s ease-out;
            z-index: -1;
        }

        .showstate:hover {
            color: #152C4F;
            border: 1px solid #152C4F;
        }

        .showstate:hover::before {
            box-shadow: inset 0 0 0 10em #152C4F;
        }

        .nav-tabs {
            border: 0 !important;
            padding: 40px 0.7rem !important;
        }

        div .card .card-header {
            background: transparent !important;
            border-bottom: 0 !important;
            border-radius: 0 !important;
            padding: 0 !important;
        }

        .nav-tabs>.nav-item>.nav-link.active {
            background-color: #152c4fc7 !important;
            border-radius: 30px !important;
            color: #FFFFFF !important;
        }

        form div span {
            position: absolute;
            z-index: 5;
            display: block;
            height: 46px;
            width: 50px;
            text-align: center;
            line-height: 50px;
            color: gray;
            background-color: transparent;
            font-size: 20px;
        }

        .bu{
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: transparent;
  border: none;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #cdcdcd;
  background: white;
  /*box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);*/
  cursor: pointer;
  transition-duration: .3s;
  overflow: hidden;
  position: relative;
}

.svgIcon {
  width: 12px;
  transition-duration: .3s;
}

.svgIcon path {
  fill: white;
}

.bu:hover {
  width: 100px;
  border-radius: 50px;
  transition-duration: .3s;
  background: white;
  align-items: center;
}

.bu:hover .svgIcon {
  width: 50px;
  transition-duration: .3s;
  transform: translateY(60%);
}

.bu::before {
  position: absolute;
  top: -14px;
  content: "";
  color: rgb(194, 188, 188);
  transition-duration: .3s;
  font-size: 2px;
}

.bu:hover::before {
  font-size: 13px;
  opacity: 1;
  transform: translateY(30px);
  transition-duration: .3s;
}
.modal-title {
  margin-bottom: 0;
    line-height: 1.5;
    text-align: center;
    justify-content: center;
    /* margin: 0 auto; */
    margin: auto;
    padding-left: 0px;
    font-size: 30px;
    text-align: center;
    margin: auto;
    color: #152C4F;
}

/*css for checkbox*/
.checkbox-wrapper-33 {
  --s-xsmall: 0.625em;
  --s-small: 1.2em;
  --border-width: 1px;
  --c-primary: #5F11E8;
  --c-primary-20-percent-opacity: rgb(95 17 232 / 20%);
  --c-primary-10-percent-opacity: rgb(95 17 232 / 10%);
  --t-base: 0.4s;
  --t-fast: 0.2s;
  --e-in: ease-in;
  --e-out: cubic-bezier(.11,.29,.18,.98);
}

.checkbox-wrapper-33 .visuallyhidden {
  border: 0;
  clip: rect(0 0 0 0);
  height: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  width: 1px;
}

.checkbox-wrapper-33 .checkbox {
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.checkbox-wrapper-33 .checkbox + .checkbox {
  margin-top: var(--s-small);
}

.checkbox-wrapper-33 .checkbox__symbol {
  display: inline-block;
  display: flex;
  margin-right: calc(var(--s-small) * 0.7);
  border: var(--border-width) solid var(--c-primary);
  position: relative;
  border-radius: 0.1em;
  width: 1.5em;
  height: 1.5em;
  transition: box-shadow var(--t-base) var(--e-out), background-color var(--t-base);
  box-shadow: 0 0 0 0 var(--c-primary-10-percent-opacity);
}

.checkbox-wrapper-33 .checkbox__symbol:after {
  content: "";
  position: absolute;
  top: 0.5em;
  left: 0.5em;
  width: 0.25em;
  height: 0.25em;
  background-color: var(--c-primary-20-percent-opacity);
  opacity: 0;
  border-radius: 3em;
  transform: scale(1);
  transform-origin: 50% 50%;
}

.checkbox-wrapper-33 .checkbox .icon-checkbox {
  width: 1em;
  height: 1em;
  margin: auto;
  fill: none;
  stroke-width: 3;
  stroke: currentColor;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-miterlimit: 10;
  color: var(--c-primary);
  display: inline-block;
}

.checkbox-wrapper-33 .checkbox .icon-checkbox path {
  transition: stroke-dashoffset var(--t-fast) var(--e-in);
  stroke-dasharray: 30px, 31px;
  stroke-dashoffset: 31px;
}

.checkbox-wrapper-33 .checkbox__textwrapper {
  margin: 0;
  position: relative;
  right: 5px;
}

.checkbox-wrapper-33 .checkbox__trigger:checked + .checkbox__symbol:after {
  -webkit-animation: ripple-33 1.5s var(--e-out);
  animation: ripple-33 1.5s var(--e-out);
}

.checkbox-wrapper-33 .checkbox__trigger:checked + .checkbox__symbol .icon-checkbox path {
  transition: stroke-dashoffset var(--t-base) var(--e-out);
  stroke-dashoffset: 0px;
}

.checkbox-wrapper-33 .checkbox__trigger:focus + .checkbox__symbol {
  box-shadow: 0 0 0 0.25em var(--c-primary-20-percent-opacity);
}

@-webkit-keyframes ripple-33 {
  from {
    transform: scale(0);
    opacity: 1;
  }

  to {
    opacity: 0;
    transform: scale(20);
  }
}

@keyframes ripple-33 {
  from {
    transform: scale(0);
    opacity: 1;
  }

  to {
    opacity: 0;
    transform: scale(20);
  }
}
/*end css for checkbox*/
.form{
  width:100%
}
.showstate {
    background: transparent;
    position: relative;
    padding: 5px 15px;}
    /**/

table {
  border: 1px solid #ccc ;
  border-collapse: collapse !important;
  margin: 0 !important;
  padding: 0 !important;
  width: 100% !important;

}

table caption {
  font-size: 1.5em !important;
  margin: .25em 0 .75em !important;
}

table tr {
  background: #f8f8f8 !important;
  border: 1px solid #ddd ;
  padding: .35em !important;
}

table th, table td {
  padding: .625em !important;
  text-align: center !important;
}

table th {
  font-size: 20px !important;

}

table td img { text-align: center; }
@media screen and (max-width: 600px) {

table { border: none !important; }


table thead { display: none !important; }

table tr {
  /*border-bottom: 3px solid #ddd!important ;*/
  border-bottom: none !important;
  border-top: none !important;
  border-left: none !important;
  border-right: none !important;
  display: block!important;
  margin-bottom: .625em !important;
}

table td {
  padding: 10px !important;
  border-top: 1px solid #ddd !important;
  border-bottom: none !important;
  display: block !important;
  font-size: .8em !important;
  text-align: right !important;
}

table td:before {
  content: attr(data-label) !important;
  float: left !important;
  font-weight: bold !important;

}

table td:last-child {
border-bottom: 1px solid #ddd !important;
border-right: 1px solid #ddd;
 }


}

@media (min-width: 1200px){
  .container, .container-sm, .container-md, .container-lg, .container-xl {
    max-width: 1000px;
}
}
/* add question */
.Btn{
    width: 55px;
    margin: 10px auto;
}

/* plus sign */
.sign {
  width: 100%;
  font-size: 2.2em;
  color: white;
  transition-duration: .3s;
  display: flex;
  align-items: center;
  justify-content: center;
}
/* text */
.text {
  position: absolute;
  right: 0%;
  width: 0%;
  opacity: 0;
  color: white;
  font-size: 1.4em;
  font-weight: 500;
  transition-duration: .3s;
}
/* hover effect on button width */
.Btn:hover {
  width: 45px;
  transition-duration: .3s;
}

.Btn:hover .sign {

  transition-duration: .3s;
  padding-left: 1px;
}
/* hover effect button's text */
.Btn:hover .text {
  opacity: 1;

  transition-duration: .3s;
  padding-right: 1px;
}
/* button click effect*/
.Btn:active {
  transform: translate(2px ,2px);
}
.nav-tabs .nav-item .nav-link {
            border: 0 !important;
            color: #485a76 !important;
            font-weight: 900;
        }
    </style>
@endsection
@section('content')
<div class="main-panel" style="background: #f8f9fb;">
     <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
      <li class="li"><a href="{{ route('dashboard.coordinator') }}">الصفحة الرئيسية</a></li>
      <li class="li"><a href="{{ route('dashboard.coordinator_subject',['room_id' => $room->id])}}">{{ $room->name }}</a></li>
      <li class="li"><a href="#">{{ $lesson->name }}</a></li>
   </ul>

    <div class="content-wrapper pb-0">
       <!--start content-->
        <div class="container" style="direction: rtl;">
           <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                 <div class="card">
                    <div class="card-header">
                      <ul class="nav nav-tabs justify-content-center" role="tablist">

                        <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                            <!--i class="now-ui-icons shopping_cart-simple"></i-->   الاسئلة الغير مقبولة 
                          </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#auto_1" role="tab">
                               <!--i class="now-ui-icons objects_umbrella-13"></i-->
                                 الاسئلة المقبولة 
                           </a>
                           </li>


                      </ul>
                    </div>
                    <div class="card-body">
                      <!-- Tab panes -->
                      <div class="tab-content text-center ">
                        <div class="tab-pane active" id="profile" role="tabpanel">
                         <div class="container animated bounceInLeft">
                          <div class="row" style="justify-content: center;padding-bottom: 20px;padding-right: 66px;">
                            <div class="col-md-3">
                               
                            </div>
                          </div>
                         <div class="col-md-12">

                                        <div class="table-responsive">
                                            <table class="table1 table table-striped">
                      <thead>
                        <tr>
                          <th>السؤال </th>
                          <th>الجواب</th>
                          <th> الاستاذ</th>
                          <th>الدرس</th>
                          <th>العلامة</th>
                          <th>ملاحظات</th>
                          <th> القبول </th>


                        </tr>
                      </thead>
                      <tbody>
                        @php
                            $i = 0;
                        @endphp

                        @foreach ($questions as $question)
                            @php
                                $i++;
                            @endphp
                            <tr>
                                <td  data-label="السؤال" class="py-1">{{ $question->question_form }}</td>
                                @if (is_array(json_decode($question->answer)))
                                    <td>
                                        @foreach (json_decode($question->answer) as $item)
                                            {{ $item }} ,
                                        @endforeach

                                    </td>
                                @else
                                    <td data-label="الجواب" class="py-1">{{ $question->answer }}</td>
                                @endif
                                <td data-label="الاستاذ " class="py-1">
                                    {{ $question->teacher->first_name }} {{ $question->teacher->last_name }} </td>
                                <td data-label="الدرس" class="py-1" >{{ $question->lecture->name }} </td>
                                <td data-label="العلامة" class="py-1">{{ $question->mark }}</td>
                                <td data-label="ملاحظات" class="py-1">{{ $question->note }}</td>
                             
                                <td data-label="القبول" class="py-1">
                                    <a class="Btn my-element" title="قبول"  href="{{route('accept_question',$question->id)}}">
                                    <!--<i class='fa-solid fa-circle-xmark'></i>-->
                                    <i class="fa fa-ban" style="top: 8px;position: relative;font-size: 24px;"></i>
                                    </a>
                                </td>
                                
                                
                            </tr>
                        @endforeach
                    </tbody>

                    </table>
                                        </div>
                                    </div>
                         </div>

                        </div>
                        <div class="tab-pane" id="auto_1" role="tabpanel">
                           
                            <div class="container animated bounceInLeft">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="table-responsive">
                                            <table class="table1 table table-striped">
                      <thead>
                        <tr>
                          <th>السؤال </th>
                          <th>الجواب</th>
                          <th> الاستاذ</th>
                          <th>الدرس</th>
                          <th>العلامة</th>
                          <th>ملاحظات</th>
                          <th> القبول </th>


                        </tr>
                      </thead>
                      <tbody>
                       

                        @foreach ($questions_accept as $question_accept)
                           
                            <tr>
                                <td  data-label="السؤال" class="py-1">{{ $question_accept->question_form }}</td>
                                @if (is_array(json_decode($question_accept->answer)))
                                    <td>
                                        @foreach (json_decode($question_accept->answer) as $item)
                                            {{ $item }} ,
                                        @endforeach

                                    </td>
                                @else
                                    <td data-label="الجواب" class="py-1">{{ $question_accept->answer }}</td>
                                @endif
                                <td data-label="الاستاذ " class="py-1">
                                    {{ $question_accept->teacher->first_name }} {{ $question_accept->teacher->last_name }} </td>
                                <td data-label="الدرس" class="py-1" >{{ $question_accept->lecture->name }} </td>
                                <td data-label="العلامة" class="py-1">{{ $question_accept->mark }}</td>
                                <td data-label="ملاحظات" class="py-1">{{ $question_accept->note }}</td>
                               
                                <td data-label="القبول" class="py-1">
                                    <!--<a class="Btn">-->
                                      <!--<i class="fa fa-check" style="font-size: larger;"></i>-->
                                      <a  style="background: green;" class="Btn" title="قبول"  href="#">
                                   <i class="fa fa-check" style="font-size: larger;"></i>
                                    </a>
                                    <!--</a>-->

                                </td>
                               
                                
                            </tr>
                        @endforeach
                    </tbody>

                    </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>


                      </div>
                    </div>
                  </div><!--end-->
            
            </div>

           </div>

        </div>
       <!--end content-->
    </div><!--end content-wrapper pb-0-->
  </div><!--end main panels-->

    @endsection
    @section('js')

