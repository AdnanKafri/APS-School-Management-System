@extends('teachers2.layouts.app')
@section('title')
School
@endsection
@section('css')
<style>
table th, table td {
    padding: 7px !important;
    text-align: center !important;
}
      table {
    border: 1px solid #ccc ;
    border-collapse: collapse !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    margin-top:10px !important;
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
  table th {
    font-size: 20px !important;

  }

  table td img { text-align: center; }
  @media screen and (max-width: 1000px) {

  table { border: none !important; }


  table thead { display: none !important; }

  table tr {
    border-bottom: 3px solid #ddd!important ;
    border-bottom: none !important;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    display: block!important;
    margin-bottom: .625em !important;
  }

  table td {
    padding: 10px !important;
    padding-bottom: 25px !important;
    border-top: 1px solid #ddd !important;
    border-bottom: none !important;
    display: block !important;
    font-size: .8em !important;
    text-align: left !important;
  }

  table td:before {
    content: attr(data-label) !important;
    float: right !important;
    font-weight: bold !important;

  }

  table td:last-child {
  border-bottom: 1px solid #ddd !important;
  border-right: 1px solid #ddd;
   }
  }

 .layout {
   display: grid;
   height: 100%;
   width: 100%;
   overflow: hidden;
   /*grid-template-rows: 50px 1fr;
   grid-template-columns: 1fr 1fr 1fr;*/
 }
 input[type="radio"] {
   display: none;
 }
 label.nav {
   display: flex;
   align-items: center;
   justify-content: center;
   cursor: pointer;
   border-bottom: 2px solid #8e44ad;
   background: #ecf0f1;
   user-select: none;
   transition: background 0.4s, padding-left 0.2s;
  /* padding-left: 0;*/
    padding: 10px;
 }
 @media (min-width:200px) and (max-width:1000px){
  .layout{
   overflow: scroll;
   width: 100% ;
  }
 }
 /*css for table*/
 div.table-title {
   display: block;
   margin: auto;
   max-width: 600px;
   padding:5px;
   width: 100%;
   direction: rtl !important;
 }

 .table-title h3 {
    color: #fafafa;
    font-size: 30px;
    font-weight: 400;
    font-style:normal;
    font-family: "Roboto", helvetica, arial, sans-serif;
    text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
    text-transform:uppercase;
 }
 table{
   border-collapse: collapse;
   border-spacing: 0;
    width: 100%;
    margin: 0 auto;
    direction: rtl;
 }

 @media (min-width:200px) and (max-width:1000px){
   table{
     width: 100% !important;
   }
 }
 @media(min-width:200px) and (max-width:1000px){
     th{
         width:700px !important;
     }
 }
 th {
   color:#FFFFFF;;
   background:#173D64 !important;
   border-bottom:4px solid #9ea7af;
   border-right: 2px solid #C1C3D1;
   border-left: 2px solid #C1C3D1;
   font-size:23px;
   font-weight: 100;
   padding:11px;
   text-align:center;
   text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
   vertical-align:middle;
 }
 th:first-child {
   border-top-left-radius:1px;
 }
 th:last-child {
   border-top-right-radius:1px;
   border-right:none;
 }
 tr {
   border-top: 1px solid #C1C3D1;
   border-bottom-: 1px solid #C1C3D1;
   border-right: 1px solid #C1C3D1;
   border-left: 1px solid #C1C3D1;
   color:#666B85;
   font-size:16px;
   font-weight:normal;
   text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
 }
 tr:hover td {
   /*background:#9ea7af;*/
   color:#9ea7af;
   border-top: 1px solid #9ea7af;
 }
 tr:first-child {
   border-top:none;
 }
 tr:last-child {
   border-bottom:none;
 }
 tr:nth-child(odd) td {
   /*background:#EBEBEB;*/
 }
 tr:nth-child(odd):hover td {
   /*background:#9ea7af;*/
 }
 tr:last-child td:first-child {
   border-bottom-left-radius:3px;
 }

 tr:last-child td:last-child {
   border-bottom-right-radius:1px;
 }

 td {
   background:#FFFFFF;
   padding: 4px;
   text-align: center;
   vertical-align:middle;
   font-weight:300;
   font-size:18px;
   text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
   border-right: 1px solid #C1C3D1;
   border-left: 1px solid #C1C3D1;
   border-bottom:1px solid #9ea7af;
 }

 td:last-child {
   border-right: 0px;
 }

 th.text-left {
   text-align: left;
 }

 th.text-center {
   text-align: center;
 }

 th.text-right {
   text-align: right;
 }

 td.text-left {
   text-align: left;
 }

 td.text-center {
   text-align: center;
 }

 td.text-right {
   text-align: right;
 }
 /*end css for table*/

 @media (min-width:200px) and (max-width:500px){
     .new{
      position: relative;
     /* right: 51%;*/
     left: 13px;
     }
     .newcol{
      position: relative;
      margin-bottom: 10px;
     }
 }
 @media (min-width:501px) and (max-width:1000px){
  .newcol{
      position: relative;
      margin-bottom: 10px;
      left: 18px;
     }
 }
 .btn{
  padding-top: 10px !important;
  padding-bottom: 10px !important;
  margin-bottom: 5px;
 }
 .btn-primary {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.btn-info{
    padding-left: 13px !important;
    padding-right: 13px !important;

}

.btn-primary{
    padding-left: 13px !important;
    padding-right: 13px !important;

}

.btn-success{
    padding-left: 13px !important;
    padding-right: 13px !important;

}

.btn-danger{
    padding-left: 13px !important;
    padding-right: 13px !important;

}
/* تعديلاتي  */
.uuu1{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}

.uuu3{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}

.uuu2{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}

.uuu6{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}
.uuu5{
    padding-left: 35px !important;
    padding-right: 35px !important;
    width: max-content;
    font-weight: bolder;

}
.uuu1 > p{
   font-weight: bold;

}

.uuu3 > p{
   font-weight: bold;

}

.uuu2 > p{
   font-weight: bold;

}

.uuu6 > p{
   font-weight: bold;

}
.uuu5 > p{
   font-weight: bold;

}
font-weight: bold;
  table th {
    font-size: 30px !important;
}
@media (min-width:700px) and (max-width:1500px){
  table th {
    font-size: 20px !important;
}
 }
   /* Add print styles */
  @media print {
  table th, table td {
    padding: 7px !important;
    text-align: center !important;
}
      table {
    border: 1px solid #ccc ;
    border-collapse: collapse !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    margin-top:10px !important;
  }
  table caption {
    font-size: 1.5em !important;
    margin: .25em 0 .75em !important;
  }

  table tr {
    background: #f8f8f8 !important;
    border: 1px solid #ddd !important;
    padding: .35em !important;
  }
  table th {
    font-size: 20px !important;

  }
  
  }
  
   .print-styles table th,
    .print-styles table td {
        padding: 7px;
        text-align: center;
    }

    .print-styles table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        margin-top: 10px;
    }

    .print-styles table caption {
        font-size: 1.5em;
        margin: .25em 0 .75em;
    }

    .print-styles table tr {
        background: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    .print-styles table th {
        font-size: 20px;
    }
  
</style>
@endsection
@section('content')



<div  id="bell1" style="display:none">

    <span class="bell fa fa-bell"></span>
  </div>
  <!-- start new-->

<div class="col-md-10 " style="margin: auto; direction: rtl; text-align:center">
    @if (session()->has('success'))

    <script>
        window.onload = function() {
            notif({
                msg: " {{ Session::get('success') }} ",
                type: "success"
            })
        }

    </script>
@endif
    @if (session()->has('error'))

    <script>
        window.onload = function() {
            notif({
                msg: "{{ Session::get('error') }}",
                type: "error"
            })
        }

    </script>
@endif
    @if (session()->has('othertime'))

    <script>
        window.onload = function() {
            notif({
                msg: " {{  Session::get('othertime')  }} ",
                type: "warning"
            })
        }

    </script>
@endif
@if ($errors->any())

        @foreach ($errors->all() as $error)
        {{-- <li>{{ $error }}</li> --}}
        <script>
            window.onload = function() {
                notif({
                    msg: `{{  $error }}`  ,
                    type: "error"
                })
            }

        </script>
        @endforeach

@endif
<div class="main-panel" style="background: #f8f9fb;">
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">

      <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
      <li class="li"><a href="#">جدول الدوام</a></li>

   </ul>
<!--<div class="row">-->
<!--    <div class="col-md-4" >-->
<!--        <button class="accept print" style="width: 140px;-->
<!--        padding-top: 10px;-->
<!--        padding-bottom: 10px;">طباعة</button>-->
<!--      </div>-->
<!--</div>-->


    <div class="content-wrapper pb-0">

        <!-- <div class="row" style="margin-right: 1px;float:left ">-->
        <!--        <div class="col3 mx-2 btn-success p-1">يمكن الدخول للدرس</div>-->
        <!--        <div class="col3 mx-2 btn-danger p-1">تم حضورالدرس   </div>-->
        <!--        <div class="col3 mx-2 btn-warning p-1">الدرس لا يحوي رابط غوغل</div>-->
        <!--        <div class="col3 mx-2 btn-primary2 p-1 text-light">اللون الافتراضي</div>-->
        <!--</div>-->
        {{-- <a class=" aaa btn btn-success" href="{{ route('teacher.google_meets',$teacher->id) }}"> Goolge Meets</a> --}}
        <h1  class="title text-center w-100" style="padding-bottom:20px;padding-top:20px"> برنامج الدوام  </h1>

        <div class="row w-100" style="margin-right: 1px;margin-bottom:15px ">
             <div class="col-sm-2 mx-2 btn-primary p-1 text-light">اللون الافتراضي</div>
            <div class="col-sm-2 mx-2 btn-info p-1 text-light">اليوم الحالي </div>
                <div class="col-sm-2 mx-2 btn-success p-1">يمكن الدخول للدرس</div>
                <div class="col-sm-2 mx-2 btn-danger p-1">تم حضورالدرس   </div>

                <div class="col-sm-3 mx-2 btn-warning p-1">الدرس لا يحوي رابط</div>

        </div>
        <div class="container" style="padding-bottom: 50px;">
            <div class="row">
              <div class="col-md-12">
               <div>
                 <table  id="dvContainer">
        <tbody style="border: 2px solid;">
          <?php
             $i = 1;
            ?>
            @foreach ($days as $key => $day)

                <tr style="border: 2px solid;">
                    <th scope="row" style="border: 2px solid;">{{ $day->name }}</th>
                        @php
                        $lesson_name2 =  '' ;
                        $title =  ' حصة اسبوعية' ;
                        $google_meeting_link =  '' ;
                        $lesson_time_id =  -1 ;
                        $room_id = "";
                        $class_and_room  =    '';
                        $background =    'btn-primary';
                        $my_href = '#';
                        $passToStream  = true ;
                        $go_to_google = false ;


                        @endphp

                        @foreach ($schedule as $key3 => $lesson_time )
                            @if ($day->id == $lesson_time->day_id )
                                @php
                                $lesson_name2 =   '';
                                $class_name =    $lesson_time->room->classes->name;
                                $room_name =    $lesson_time->room->name;
                                $room_id =    $lesson_time->room->id;
                                $class_and_room = " $class_name / $room_name" ;
                                $lesson_name2 =    $lesson_time->lesson->name ;
                                $lesson_time_id = $lesson_time->id ;
                                $meeting_link = $lesson_time->meeting_link ;

                                if( $today == $day->id - 1 && $lesson_time->attendance == false &&  $lesson_time->inter == false && $lesson_time->meeting_link != null){
                                    $background = 'btn-info';
                                    // $title = 'لم يحن الوقت بعد';
                                }
                                else if($today == $day->id - 1 && $lesson_time->attendance == true  &&  $lesson_time->inter == true && isset($lesson_time->meeting_link )){
                                    $background = 'btn-danger';
                                    $title = ' الدخول للحصة';
                                    $google_meeting_link = $lesson_time->meeting_link ;
                                    $go_to_google = true;
                                    // $title = 'لقد زرت هذا الرابط من قبل   ';

                                }
                                else if($today == $day->id - 1  &&  $lesson_time->inter == true && isset($lesson_time->meeting_link )){
                                    $background = 'btn-success';
                                    $title = ' الدخول للحصة';
                                    $google_meeting_link = $lesson_time->meeting_link ;
                                    $go_to_google = true;
                                }
                                else if($today == $day->id - 1 && $lesson_time->meeting_link == null){
                                    $background = 'btn-warning';
                                    $title = 'لا يوجد درس مجدول';
                                }
                                else if($today == $day->id - 1 && $lesson_time->attendance == true){
                                    $background = 'btn-danger';
                                    // $title = 'لقد زرت هذا الرابط من قبل   ';

                                }
                                else
                                    $background = 'btn-primary';


                                @endphp
                                <td  style="border: 2px solid;">
                                    <a  style="display: block" target="_blank"
                                        class="aaa
                                        {{ $background }}
                                        btn-sm add_time "
                                        @if( $passToStream && $room_id != "" &&  $go_to_google)
                                            href="{{ route('dashboard.teacher.room.go_to_stream',['scheduler_id' => $lesson_time_id,'day_id' => $day->id,'lecture_time_id' =>$lesson_time->lecture_time->id ,'room_id' =>$room_id,'teacher_id' => $teacher_id]) }}"
                                        @endif
                                        title="{{ $title }}">
                                        <p class="lesson_name-schedule{{  $day->id .''. $lesson_time->lecture_time->id }}" style="margin:0;font-weight:bold"> {{ $lesson_time->lesson->name }}</p>
                                        <p class="teacher_name-schedule{{  $day->id .''. $lesson_time->lecture_time->id }}" style="margin:0;font-size:14px"> {{ $lesson_time->room->classes->name." / ".$lesson_time->room->name }} </p>
                                        <p  style="margin:0;font-size:14px"> {{ Carbon\Carbon::parse($lesson_time->lecture_time->start_time)->format('H:i')." - ".

                                      Carbon\Carbon::parse($lesson_time->lecture_time->end_time)->format('H:i')
                                         }} </p>
                                        <input class="time" hidden value="$lesson_time->lecture_time->end_time">
                                        <p  style="margin:0;font-size:14px"> {{ $lesson_time->lecture_time->name }} </p>
                                    </a>
                                    @if( $lesson_time_id > 0)
                                    {{-- <a class="aaa btn  btn-warning btn-sm add_time"
                                        data-toggle="modal" data-target="#add_schedule" data-day_id = '{{ $day->id  }}'
                                        data-day = '{{ $day->name  }}'
                                        data-time = "{{ $lesson_time->lecture_time->name }}"
                                         data-lesson_name = "{{ $lesson_name2 }}"
                                        data-lesson_time_id = "{{ $lesson_time_id }}"
                                        data-meeting_link = "{{  $meeting_link  }}"

                                        title="إضافة رابط ">
                                    </a> --}}
                                    @endif
                                </td>
                            @endif
                        @endforeach
                </tr>
            @endforeach

    </tbody>
    </table>
    </div>

</div>
</div>
<!-- end new-->

<audio id="MyAudioElement" >
    <source src="{{asset('teachers/schoolbell.mp3')}}" >


  </audio>
  <button id="btn" hidden></button>

{{-- add lesson time --}}

{{--<div class="modal fade" id="add_schedule">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="direction: rtl; text-align:right">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLongTitle">  إضافة رابط غوغل   </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: inline-block;margin: 0px;padding: 0px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  action="" method="post" class="w-100">
                @csrf
                {{-- <input type="hidden" name="room_id" id="room_id" value=" {{ $room_id }}" class="room_id">
                <input type="hidden" name="lesson_time_id" id="lesson_time_id"  class="lesson_time_id">


                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> اليوم : </label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control day">
                        <input type="hidden" name="day_id"  class="form-control day_id">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> الحصة : </label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control time">
                        <input type="hidden" name="time_id"  class="form-control time_id">

                    </div>
                </div>
                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> المادة : </label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control lesson">
                        <input type="hidden" name="lesson_id"  class="form-control time_id">

                    </div>
                </div>
                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> الرابط : </label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control meeting_link" name="meeting_link">
                    </div>
                </div>

                <div class="form-group modal-footer row justify-content-around px-3">
                      <button class="btn btn-success save_lecture_time" type="submit" style="width: 35%">تأكيد </button>
                    <button  class="btn btn-light btn-info" data-dismiss="modal" style="width: 35%">خروج</button>
                </div>

                <!-- end submit-->


            </form>
            </div>
        </div>
    </div>
</div>--}}
        {{-- end add lesson time --}}
        <input type="text" hidden id="name_share" value="{{ $teacher->first_name }} {{ $teacher->last_name }} ">

	@endsection
    @section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/PrintArea/2.4.1/jquery.PrintArea.js" integrity="sha512-GhQdBWSddrd8ijiuwA0LZ7ppPcPrJOZAtGMOmgO/371vPNUNm/mKdNc13T/2UWLp5vLIcaDvh/9NwCRZAdxgFw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
<script>
    $(document).ready(function() {
        $('.sh11').addClass('active');
        $('.print').on('click', function(e) {
            // Apply print styles
            $('#dvContainer').addClass('print-styles');

            // Remove button styles temporarily
            $('.btn-info').removeClass('btn-info').addClass('uuu1');
            $('.btn-success').removeClass('btn-success').addClass('uuu2');
            $('.btn-primary').removeClass('btn-primary').addClass('uuu3');
            $('.btn-danger').removeClass('btn-danger').addClass('uuu6');
            $('.btn-warning').removeClass('btn-warning').addClass('uuu5');

            // Set the viewport width to a large value for printing
            var originalViewportWidth = window.innerWidth;
            window.innerWidth = 1920; // Set the desired width (e.g., 1920px)

            html2canvas(document.querySelector("#dvContainer")).then(canvas => {
                a = document.createElement('a');
                document.body.appendChild(a);
                a.download = $('#name_share').val() + ".png";
                a.href = canvas.toDataURL();
                a.click();

                // Restore button styles
                $('.uuu1').removeClass('uuu1').addClass('btn-info');
                $('.uuu2').removeClass('uuu2').addClass('btn-success');
                $('.uuu3').removeClass('uuu3').addClass('btn-primary');
                $('.uuu6').removeClass('uuu6').addClass('btn-danger');
                $('.uuu5').removeClass('uuu5').addClass('btn-warning');

                // Remove print styles
                $('#dvContainer').removeClass('print-styles');

                // Restore the original viewport width
                window.innerWidth = originalViewportWidth;
            });
        });
    });
</script>



    @endsection
