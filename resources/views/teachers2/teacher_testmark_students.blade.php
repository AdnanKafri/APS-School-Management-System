@extends('teachers2.layouts.app')
@section('css')
    <style>
        /*responsive table*/
        /**/

        table {
            border: 1px solid #ccc;
            border-collapse: collapse !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            margin-top: 10px !important;
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

        /*css for show homework button*/
        a:hover {
            color: #fff;
            text-decoration: none;
        }

        .home {
            position: relative;
            /* margin: 0;*/
            width: 120px;
            padding: 0.8em 1em;
            outline: none;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border: none;
            text-transform: uppercase;
            background-color: #14315C;
            border-radius: 10px;
            color: #fff;
            font-weight: 300;
            font-size: 18px;
            font-family: inherit;
            z-index: 0;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.02, 0.01, 0.47, 1);
        }

        .home:hover {
            animation: sh0 0.5s ease-in-out both;
        }

        @keyframes sh0 {
            0% {
                transform: rotate(0deg) translate3d(0, 0, 0);
            }

            25% {
                transform: rotate(7deg) translate3d(0, 0, 0);
            }

            50% {
                transform: rotate(-7deg) translate3d(0, 0, 0);
            }

            75% {
                transform: rotate(1deg) translate3d(0, 0, 0);
            }

            100% {
                transform: rotate(0deg) translate3d(0, 0, 0);
            }
        }

        .home:hover span {
            animation: storm 0.7s ease-in-out both;
            animation-delay: 0.06s;
        }

        .home::before,
        .home::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #fff;
            opacity: 0;
            transition: transform 0.15s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.15s cubic-bezier(0.02, 0.01, 0.47, 1);
            z-index: -1;
            transform: translate(100%, -25%) translate3d(0, 0, 0);
        }

        .home:hover::before,
        .home:hover::after {
            opacity: 0.15;
            transition: transform 0.2s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.2s cubic-bezier(0.02, 0.01, 0.47, 1);
        }

        .home:hover::before {
            transform: translate3d(50%, 0, 0) scale(0.9);
        }

        .home:hover::after {
            transform: translate(50%, 0) scale(1.1);
        }
        .form-control{
            margin:auto !important;
        }


        /*end css*/
    </style>
@endsection
@section('content')
    {{-- new --}}
    <div class="main-panel" style="background: #f8f9fb;">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
            <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
            <li class="li"><a
                    href="{{ route('dashboard.teacher_lessons2', ['room_id' => $room_id, 'teacher_id' => $teacher->id]) }}">{{ $room->name }}
                </a></li>
            <li class="li"><a
                    href="{{ route('dashboard.StudentsRoomLesson_quize1', [$room_id, $teacher->id, $lesson->id]) }}">الاختبارات
                </a></li>
            <li class="li"><a href="#">
                    @if ($exam1->type == 1)
                        {{ $exam1->namehomework }}
                    @elseif ($exam1->type == 2)
                        {{ $exam1->name_quize1 }}
                    @endif
                </a></li>
        </ul>
        <div class="content-wrapper pb-0">
            <!--start content-->
            <div class="container" style="direction: rtl;">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            {{-- select --}}
                            <div class="row pt-4 justify-content-center">
                                <div class="col-md-5">
                                    {{--   <select class="choice js-example-basic-single" style="width: 100%;direction: rtl;">
                            <option value="0">اختر الدرس </option>
                            @foreach ($lectures as $item)
                                @if ($item->active == 1)
                                    <option value="{{ $item->id }}"> <del>{{ $item->name }}</del> </option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }} </option>
                                @endif
                            @endforeach
                        </select> --}}
                                    @if ($exam1->type == 3 || $exam1->type == 2 || $exam1->type == 7)
                                        <div class="form-group newselect" style="width: 100%;">
                                            <input class="homeid" hidden value="{{ $exam1->id }}">
                                            <select class="choice form-control" style="width: 100%;direction: rtl;">
                                                <option value="0"> اختر الطلاب </option>
                                                <option value="1"> يوجد ملف </option>
                                                <option value="2"> لايوجد ملف </option>
                                            </select>
                                        </div>
                                </div>



                            </div>
                        @elseif($exam1->type == 5 || $exam1->type == 8)
                            <div class="form-group newselect" style="width: 100%;">
                                <input class="homeid" hidden value="{{ $exam1->id }}">
                                    <select class="choice form-control" style="width: 100%;direction: rtl;">
                                        <option value="0"> اختر الطلاب </option>
                                        <option value="1"> المتقدمين </option>
                                        <option value="2"> غير المتقدمين </option>
                                    </select>
                            </div>
                            @endif
                        </div>
                    </div>
                    {{-- end select --}}


                    <div class="card-body">
                        <h4 style="text-align: center;padding-bottom: 20px;color: #152C4F;font-size: 28px;">الاختبارات
                        </h4>
                        <div class="table-responsive">
                            <table class="table1">
                                <thead>
                                    <tr>
                                        <th>الرقم التسلسلي </th>
                                        <th>اسم الطالب </th>
                                        <th>العلامة </th>
                                        <th> تصحيح ملف </th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <input style="height: 50px; width:80px" class="room_id" hidden name="room_id"
                                        value="{{ $room_id }}" type="text">

                                    @foreach ($quize_result as $item)
                                        @foreach ($item->student as $item2)
                                            <tr>
                                                <form action="{{ route('dashboard.teacher.student_save_mark') }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf

                                                    <td>{{ $item2->id }}</td>
                                                    <td>{{ $item2->first_name }} {{ $item2->last_name }} </td>


                                                    <td>
                                                        @if ($item2->exam_result->count() > 0)
                                                            @foreach ($item2->exam_result as $item3)
                                                                @php
                                                                    $i2 = 0;
                                                                @endphp
                                                                @if ($item3->exam_id == $exam_id)
                                                                    <input style="height: 50px; width:80px" hidden
                                                                        name="exam_result_id" value="{{ $item3->id }}"
                                                                        type="text">

                                                                    <input hidden style="height: 50px; width:80px"
                                                                        name="mark"
                                                                        value="{{ $item3->result != null ? $item3->result : '' }}"
                                                                        onfocus="this.placeholder = ''"
                                                                        onblur="this.placeholder = ''"
                                                                        class="common-input mb-20 form-control input1"
                                                                        type="text">
                                                                @endif
                                                            @endforeach
                                                            <input style="height: 50px; width:80px" name="mark"
                                                                value="" onfocus="this.placeholder = ''"
                                                                onblur="this.placeholder = ''"
                                                                class="common-input mb-20 form-control input2"
                                                                type="text">
                                                        @else
                                                            <input style="height: 50px; width:80px" name="mark"
                                                                onfocus="this.placeholder = ''"
                                                                onblur="this.placeholder = ''"
                                                                class="common-input mb-20 form-control" required=""
                                                                type="text">
                                                        @endif

                                                        <input style="height: 50px; width:80px" hidden name="class_id"
                                                            value="{{ $room_id }}" type="text">
                                                        <input style="height: 50px; width:80px" class="room_id" hidden
                                                            name="room_id" value="{{ $room_id }}" type="text">
                                                        <input style="height: 50px; width:80px" hidden name="exam_id"
                                                            value="{{ $exam_id }}" type="text">
                                                        <input style="height: 50px; width:80px" hidden name="lesson_id"
                                                            value="{{ $lesson_id }}" type="text">
                                                        <input style="height: 50px; width:80px" hidden name="user_id"
                                                            value="{{ $item2->id }}" type="text">

                                                    </td>
                                                    <td>
                                                        @if ($item2->exam_result->count() > 0)
                                                            @foreach ($item2->exam_result as $item322)
                                                                @if ($item322->exam_id == $exam_id)
                                                                    @if ($item322->type == 5 || $item322->type == 8)
                                                                        {{-- <a href="{{ route('dashboard.correct_exam', [$exam1->id, $item2->id]) }}"
                                                                                class="btn"
                                                                                style="background-color: white; color: rgb(117, 115, 115);">تصحيح
                                                                                الامتحان </a> --}}

                                                                        <a href="{{ route('dashboard.correct_exam', [$exam1->id, $item2->id]) }}"
                                                                            class="home">
                                                                            <span>التصحيح</span>
                                                                        </a>
                                                                    @else
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @else
                                                        @endif
                                                        <!--<button type="submit" class="btn"  style="background-color: white; color: rgb(117, 115, 115);" >تعديل  </button>-->
                                                    </td>

                                                    {{-- <td style="height: 86px">
                   <!--@if ($item2->exam_result->count() > 0)-->
                   <!--@foreach ($item2->exam_result as $item3)-->

                   <!--@if ($item3->exam_id == $exam_id)-->

                   <!--@if ($item3->type == 3 || $item3->type == 7)-->
                   <!--@foreach ($item2->student_lesson_teacher_room_term_exam as $item32)-->

                   <!--@if ($item32->exam_id == $exam_id)-->
                   <!--@if ($item32->type == 3 || $item3->type == 7)-->

                   <!--    <a href="{{ asset('storage/'.$item32->file) }}"  target="_blank">-->

                   <!--        <img src="{{  asset('teachers/icons8-downloads-folder-30.png') }}" style="height: 50px;width:50px"></a>-->

                   <!--@endif-->


                   <!--@endif-->
                   <!--@endforeach-->

                   <!--@endif-->
                   <!--@endif-->
                   <!--@endforeach-->


                   <!--@endif-->

                     @if ($item2->exam_result->count() > 0)
                   @foreach ($item2->exam_result as $item3)

                   @if ($item3->exam_id == $exam_id)
                           @if ($item3->medal == '1')



                           <img src="{{  asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
                   @elseif($item3->medal ==  "2" )
                    <img src="{{  asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
                   @elseif($item3->medal ==  "3" )
                    <img src="{{  asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
                   @endif


                   @endif
                   @endforeach


                   @endif





               </td> --}}

                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--end content-->
    </div><!--end content-wrapper pb-0-->
    </div><!--end main panels-->
    {{-- end  --}}

    {{-- <section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                     @if ($exam1->type == 1)
                    <h1 class="mb-0 bread">{{ $exam1->namehomework }}  </h1>
                    @elseif ($exam1->type==2)
                    <h1 class="mb-0 bread">{{ $exam1->name_quize }}  </h1>
                    @endif
            </div>
        </div>
    </div>
</section>
 <nav class="breadcrumbs" style="float: left;">

     <a  class="breadcrumbs__item is-active"> علامات   </a>
       <a   href="{{ route('dashboard.StudentsRoomLesson_quize1',[$room_id,$teacher->id,$lesson->id]) }}" class="breadcrumbs__item ">الاختبارات  </a>

    <a   href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room_id ,'teacher_id'=>$teacher->id])}}" class="breadcrumbs__item ">{{$lesson->name}}/{{ $room->name }}   </a>

     <a   href="{{ route('dashboard.teacher') }}" class="breadcrumbs__item ">الواجهة الرئيسية
</a>
</nav>
<!-- start new-->


<br>
<br>
<br>
<br>
@if ($exam1->type == 3 || $exam1->type == 2 || $exam1->type == 7)
<span class="subheading"></span>
<div class="tab1cards">
<input  class="homeid"  hidden value="{{ $exam1->id}}">
                <div class="select" style=" border-radius: 5px; " >
                  <select  class="choice">
                    <option value="0" > اختر الطلاب   </option>

                    <option value="1" > يوجد ملف  </option>
                    <option value="2" > لايوجد ملف  </option>



                  </select>
                  </div>

     </div>
@elseif($exam1->type==5 || $exam1->type==8)
<span class="subheading"></span>
<div class="tab1cards">
<input  class="homeid"  hidden value="{{ $exam1->id}}">
                <div class="select" style=" border-radius: 5px; " >
                  <select  class="choice">
                    <option value="0" > اختر الطلاب   </option>

                    <option value="1" > المتقدمين   </option>
                    <option value="2" > غير المتقدمين   </option>



                  </select>
                  </div>

     </div>
@endif

     <br>


    <br>

    <br>
    <br>
<!-- marks of homework -->
      <table class="table1" >
        <thead>
            <tr>
                <th>الرقم التسلسلي </th>
                <th>اسم الطالب </th>

                <th>العلامة </th>
               <th> تصحيح ملف </th>
                         <th> اعطاء اوسمة   </th>


            </tr>
        </thead>
        <tbody>

                     <input style="height: 50px; width:80px" class="room_id"  hidden name="room_id"  value="{{ $room_id }}"  type="text">

            @foreach ($quize_result as $item)

            @foreach ($item->student as $item2)
            <tr>
                <form action="{{ route('dashboard.teacher.student_save_mark') }}" method="post" enctype="multipart/form-data">
                    @csrf

                <td>{{ $item2->id }}</td>
                <td>{{ $item2->first_name }} {{ $item2->last_name }} </td>


                <td>
                    @if ($item2->exam_result->count() > 0)
                    @foreach ($item2->exam_result as $item3)
                    @php
                        $i2=0
                    @endphp
                    @if ($item3->exam_id == $exam_id)


                    <input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="{{ $item3->id }}" type="text">

                       <input  hidden style="height: 50px; width:80px" name="mark" value="{{ $item3->result!=null ?$item3->result : '' }}" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control input1"  type="text">

                       @endif


                    @endforeach
                    <input style="height: 50px; width:80px" name="mark" value="" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control input2"  type="text">
                    @else
                    <input style="height: 50px; width:80px" name="mark" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control" required="" type="text">
                    @endif

                     <input style="height: 50px; width:60px"  hidden name="class_id"  value="{{ $room_id }}" type="text">
                     <input style="height: 50px; width:60px" class="room_id"  hidden name="room_id"  value="{{ $room_id }}"  type="text">
                     <input style="height: 50px; width:60px"  hidden name="exam_id"  value="{{ $exam_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="lesson_id"  value="{{ $lesson_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="user_id"  value="{{ $item2->id }}" type="text">

                </td>
                <td>
                @if ($item2->exam_result->count() > 0)
                @foreach ($item2->exam_result as $item322)

                @if ($item322->exam_id == $exam_id)

                @if ($item322->type == 5 || $item322->type == 8)

                <a href="{{ route('dashboard.correct_exam',[$exam1->id,$item2->id]) }}" class="btn"  style="background-color: white; color: rgb(117, 115, 115);" >تصحيح الامتحان  </a>&nbsp;&nbsp;&nbsp;


                @else

                @endif

                @endif
                @endforeach
                  @else
                @endif
                <!--<button type="submit" class="btn"  style="background-color: white; color: rgb(117, 115, 115);" >تعديل  </button>-->
            </td>

        <td style="height: 86px">
                <!--@if ($item2->exam_result->count() > 0)-->
                <!--@foreach ($item2->exam_result as $item3)-->

                <!--@if ($item3->exam_id == $exam_id)-->

                <!--@if ($item3->type == 3 || $item3->type == 7)-->
                <!--@foreach ($item2->student_lesson_teacher_room_term_exam as $item32)-->

                <!--@if ($item32->exam_id == $exam_id)-->
                <!--@if ($item32->type == 3 || $item3->type == 7)-->

                <!--    <a href="{{ asset('storage/'.$item32->file) }}"  target="_blank">-->

                <!--        <img src="{{  asset('teachers/icons8-downloads-folder-30.png') }}" style="height: 50px;width:50px"></a>-->

                <!--@endif-->


                <!--@endif-->
                <!--@endforeach-->

                <!--@endif-->
                <!--@endif-->
                <!--@endforeach-->


                <!--@endif-->

                  @if ($item2->exam_result->count() > 0)
                @foreach ($item2->exam_result as $item3)

                @if ($item3->exam_id == $exam_id)
                        @if ($item3->medal == '1')



                        <img src="{{  asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
                @elseif($item3->medal ==  "2" )
                 <img src="{{  asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
                @elseif($item3->medal ==  "3" )
                 <img src="{{  asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
                @endif


                @endif
                @endforeach


                @endif





            </td>

            </tr>
           @endforeach
           @endforeach
        </tbody>
    </table> --}}
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $.each($('.input1'), function(key, value) {
                var z = value.value;
                $(this).parent().find('.input2').val(z);
            })




        })
        $(document).on('change', '.choice', function() {

            var lect = $(this).val();
            var home = $('.homeid').val();
            var room_id = $('.room_id').val();
            var data = {

                "room_id": room_id,

            }
            var url = "{{ URL::to('SMARMANger/dashboard/teacher/examstudent') }}/" + lect + "/" + home;
            $.ajax({
                url: url,
                data: data,
                type: "get",
                contentType: 'application/json',
                success: function(data) {

                    console.log(data);

                    if (lect == 1) {
                        $('.table1 tbody').empty();
                        $.each(data, function(key, value) {
                            medal = `
                            <td style="height: 86px">
                            </td>`
                            if (value.exam_result.length > 0) {
                                $.each(value.exam_result, function(key1, value1) {
                                    if (value1.exam_id == home) {
                                        d = `   <input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="${value1.id}" type="text">
                                                <input   style="height: 50px; width:80px;    margin: auto;" name="mark" value="${value1.result}"  class="common-input mb-20 form-control input1"  type="text">`
                                        if (value1.medal == "1") {
                                            medal = ` <td style="height: 86px">

                                                  <img src="{{ asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
                                                    </td>`
                                        } else if (value1.medal == "2") {
                                            medal = ` <td style="height: 86px">

                <img src="{{ asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
            </td>`

                                        } else if (value1.medal == "3") {
                                            medal = ` <td style="height: 86px">

                <img src="{{ asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
            </td>`
                                        }


                                    }


                                })
                            }


                            $('.table1 tbody').append(`
                                <tr  id="st">
                                <td>${ value.id }</td>
                                <td>${ value.first_name } ${ value.last_name}</td>
                                <td>${d}</td>
                                <td> <a href="{{ url('SMARMANger/dashboard/exam/correct_exam') }}/${home}/${value.id}" class="home"  >التصحيح</a>
                                </td>
                                <!--${medal}-->
                                </tr> `)
                        });

                    } else if (lect == 2) {
                        $('.table1 tbody').empty();
                        $.each(data, function(key, value) {
                            medal = `<td style="height: 86px"> </td>`
                            d = `<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="" type="text">
                                <input   style="height: 50px; width:80px" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text">`
                            if (value.exam_result) {
                                if (value.exam_result.length > 0) {
                                    $.each(value.exam_result, function(key1, value1) {
                                        if (value1.exam_id == home) {
                                            if (value1.result != null) {
                                                d = `<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="${value1.id}" type="text">
                                                    <input   style="height: 50px; width:80px;    margin: auto;" name="mark" value="${value1.result}"  class="common-input mb-20 form-control input1"  type="text">`
                                            }
                                            if (value1.medal == "1") {
                                                medal = ` <td style="height: 86px">

                                                 <img src="{{ asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
                                            </td>`
                                            } else if (value1.medal == "2") {
                                                medal = ` <td style="height: 86px">

                                                        <img src="{{ asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
                                                        </td>`

                                            } else if (value1.medal == "3") {
                                                medal = ` <td style="height: 86px">

                <img src="{{ asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
            </td>`
                                            }
                                        } else {
                                            d = `<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="" type="text">
    <input   style="height: 50px; width:80px;    margin: auto;" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text"> `

                                        }
                                    })
                                }
                                $('.table1 tbody').append(`
                                <tr  id="st">
                                <td>${ value.id }</td>
                                <td>${ value.first_name } ${ value.last_name}</td>


                                <td>${d}</td>

<td> <a href="{{ url('SMARMANger/dashboard/exam/correct_exam') }}/${home}/${value.id}" class="home"   > التصحيح  </a>

    </td>


      <!--${medal}-->


    </tr> `)
                            } else {
                                d = `<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="" type="text">
    <input   style="height: 50px; width:80px" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text"> `
                                if (value.id == room_id) {
                                    $.each(value.student, function(key, value2) {

                                        $('.table1 tbody').append(`<tr  id="st">

            <td>${ value2.id }</td>
<td>${ value2.first_name } ${ value2.last_name}</td>

<td>${d}</td>

<td> <a href="{{ url('SMARMANger/dashboard/exam/correct_exam') }}/${home}/${value2.id}" class="home"> التصحيح  </a>

    </td>


    </tr> `)
                                    })
                                }

                            }



                        });

                    }



                },
                error: function(xhr) {

                }

            });
        })
    </script>

@endsection
