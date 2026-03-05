@extends('students.layouts.app4')
@section('css')

    <style>
        .form_main {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: rgb(255, 255, 255);
            padding: 0px 30px 30px 30px !important;
            border-radius: 30px;
            box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.062);
        }

        .heading {
            font-size: 2.5em;
            color: #2e2e2e;
            font-weight: 700;
            margin: 15px 0 30px 0;
        }

        .inputContainer {
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .inputIcon {
            position: absolute;
            left: 10px;
        }

        .inputField {
            width: 100%;
            height: 40px;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid rgb(173, 173, 173);
            border-radius: 30px;
            margin: 10px 0;
            color: black;
            font-size: .8em;
            font-weight: 500;
            box-sizing: border-box;
            padding-left: 30px;
        }

        .inputField:focus {
            outline: none;
            border-bottom: 2px solid rgb(199, 114, 255);
        }

        .inputField::placeholder {
            color: rgb(80, 80, 80);
            font-size: 1em;
            font-weight: 500;
        }

        #button {
            position: relative;
            width: 80% !important;
            border: 2px solid #528de5 !important;
            background-color: #528de5 !important;
            height: 40px !important;
            color: white;
            font-size: 24px !important;
            font-weight: 500;
            letter-spacing: 1px;
            border-radius: 30px;
            margin: 10px;
            cursor: pointer;
            overflow: hidden;
        }

        #button::after {
            content: "";
            position: absolute;
            background-color: rgba(255, 255, 255, 0.253);
            height: 100%;
            width: 150px;
            top: 0;
            left: -200px;
            border-bottom-right-radius: 100px;
            border-top-left-radius: 100px;
            filter: blur(10px);
            transition-duration: .5s;
        }

        #button:hover::after {
            transform: translateX(600px);
            transition-duration: .5s;
        }

        .signupContainer {
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .signupContainer p {
            font-size: .9em;
            font-weight: 500;
            color: black;
        }

        .signupContainer a {
            font-size: .7em;
            font-weight: 500;
            background-color: #2e2e2e;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px;
        }

        .row {
            width: inherit;
        }

        .exam_logo {
            top: 4px;
            position: relative;
            max-width: 55%;
        }

        /*  */
        /* Input container */
        .input {
            margin-bottom: 15px !important;
            max-width: 225px !important;
            height: 30px !important;
            border: 2px solid transparent !important;
            outline: none !important;
            border-bottom: 2px solid #9ac1fb !important;
            caret-color: #f3f9ff !important;
            background-color: #f3f9ff !important;
            padding: 5px !important;
            transition: .5s linear !important;
            font-family: monospace !important;
            /* letter-spacing: 1px; */
            text-align: center !important;
        }

        .input:focus {
            border: 2px solid #9ac1fb !important;
            caret-color: #9ac1fb !important;
            color: #9ac1fb !important;
            box-shadow: 4px 4px 10px #070707 !important;
        }

        .input:focus::placeholder {
            color: #9ac1fb;
        }

        .title_exam {
            font-size: 32px;
            color: #152c4f;
            text-align: center
        }

        .sub_title {
            font-size: 25px;
            color: #152c4f;
            text-align: center
        }

        /* css mark */
        .mark_sub {
            position: relative;
            height: 48px;
            width: 53px;
            /* padding: 0 24px; */
            border: 2px solid #4382e0;
            background: #ffffff !important;
            user-select: none;
            white-space: nowrap;
            transition: all .05s linear;
            font-family: inherit;
        }

        .mark_sub:before,
        .mark_sub:after {
            content: "";
            position: absolute;
            background: #ffffff !important;
            transition: all .2s linear;
        }

        .mark_sub:before {
            width: calc(100% + 6px);
            height: calc(100% - 16px);
            top: 8px;
            left: -3px;
        }

        .mark_sub:after {
            width: calc(100% - 16px);
            height: calc(100% + 6px);
            top: -3px;
            left: 8px;
        }

        .mark_sub:hover {
            cursor: crosshair;
        }

        .mark_sub:active {
            transform: scale(0.95);
        }

        .mark_sub:hover:before {
            height: calc(100% - 32px);
            top: 16px;
        }

        .mark_sub:hover:after {
            width: calc(100% - 32px);
            left: 16px;
        }

        .mark_sub span {
            font-size: 15px;
            z-index: 10;
            position: relative;
            font-weight: 600;
            right: 0px;
            left: 0px;
            text-align: center;
            color: #4986e1;
        }

        form div span {
            position: inherit !important;
            background-color: transparent !important;
            color: #4382e0 !important;
            width: auto !important;
        }

        form div button {
            margin-left: 0;
        }

        .all_mark {
            position: relative;
            /* top: -25px; */
        }

        .respon_wd {
            max-width: 32.33333%;
            text-align: right;
        }

        .num {
            font-size: 22px;
            color: #4382e0;
        }

        /* checkbox input */



        .form {
            padding: 0 16px;
            max-width: 550px;
            margin: 50px auto;
            font-size: 18px;
            font-weight: 600;
            line-height: 36px;
        }

        @media(min-width:100px) and (max-width:487px) {
            .respon_wd {
                max-width: 100% !important;

            }
        }

        @media(min-width:488px) and (max-width:501px) {
            .respon_wd {
                max-width: 93% !important;

            }
        }

        @media(min-width:502px) and (max-width:529px) {
            .respon_wd {
                max-width: 89% !important;

            }
        }

        @media(min-width:530px) and (max-width:929px) {
            .respon_wd {
                max-width: 100%;
                text-align: right !important;
                display: inline-grid;

            }
        }


        @media(min-width:100px) and (max-width:820px) {
            .title_exam {
                text-align: center;

            }

            .sub_title {
                text-align: center;

            }

            .inputGroup label {
                padding-right: 70px !important;
            }

        }

        @media(min-width:821px) and (max-width:1215px) {
            .title_exam {
                text-align: center;
                font-size: 23px !important;

            }

            .sub_title {
                text-align: center;
                font-size: 23px !important;

            }
        }

        /* new css for checkbox */
        .container_1 {
            /* display: flex; */
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2;
            border-radius: 10px;
        }

        .custom-radio {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .custom-radio input[type="checkbox"] {
            display: none;
        }

        .radio-label {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .radio-circle {
            width: 20px;
            height: 20px;
            border: 2px solid #9ec4fd;
            border-radius: 50%;
            margin-right: 10px;
            transition: border-color 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }

        .radio-text {
            padding-right: 20px;
            font-size: 20px;
            color: #333;
            transition: color 0.3s ease-in-out;
        }

        .custom-radio input[type="checkbox"]:checked+.radio-label {
            background-color: #9ec4fd;
        }

        .custom-radio input[type="checkbox"]:checked+.radio-label .radio-circle {
            border-color: #fff;
            background-color: #152c4f96;
        }

        .custom-radio input[type="checkbox"]:checked+.radio-label .radio-text {
            color: #64748b;
        }

        form div {
            position: relative;
            min-height: auto !important;
            margin-top: 25px;
        }
        .form_main::before{
            display: none !important
        }
        /*  */
        .bg-img {
  position : absolute;
  background: url("//unsplash.it/600/800") no-repeat;
  height: 100%;
  background-position: center;
  background-size: cover;
  filter: blur(4rem);
  opacity:0.3;
  z-index: -2;
}

.circle-bg{
  position:relative;
  width: 100%;
  height: 100%;
}

.circle{
  position: absolute;
  border-radius : 50%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -13%);
  z-index:2;
}

.circle-front {
  width : 8rem;
  height : 8rem;
  z-index: 2;
  box-shadow :  -10px 12px 19px 0 rgba(0,0,0,0.5) inset;
  background-image: linear-gradient(to right bottom, #f0669c,  #d4488e,  #9c6dd1, #6293f5, #00b4ff, #00cefc, #28e5eb);
  display: flex;
  align-items: center;
  justify-content: center;
  color : #BBEDE8;
  font-size: 1.6rem;
  font-weight: 100;
}

.circle-back{
  width : 10rem;
  height : 10rem;
  background:#32E5D3;
  z-index: 1;
  filter: blur(60px);
  opacity: 0.8;
}

@media(min-width:200px) and (max-width:900px){
    audio{
        width:inherit !important;
    }
}
    </style>
@section('content')
    <style>
        .pb-2 {
            padding-bottom: 4.5rem !important;
        }
    </style>

  @php
          $school_data = \App\School_data::first();
           @endphp

    <div class="main-panel" style="background: #f8f9fb;">
        {{-- <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
            <li class="li"><a href="#"> الصفحة الرئيسية</a></li>
            @if ($exam->type == '2')
                <li class="li">
                    <a href="{{ route('teacher_quize_mark', [$room->id, $teacher->id, $lesson->id, $exam_id]) }}">عودة</a>
                </li>
            @else
                <li class="li">
                    <a
                        href="{{ route('dashboard.StudentsRoomLesson_exammark', [$room->id, $teacher->id, $lesson->id, $exam_id]) }}">عودة</a>
                </li>
            @endif


        </ul> --}}

        <div class="content-wrapper" style="padding-bottom: 150px;">
            <div class="container" style="padding-bottom: 150px;">
                <div class="form_main">
                    <div class="row" style="direction: rtl;">

                        <div class="col-md-4" style="padding-top: 26px;">
                            <h1 class="title_exam">   {{$school_data->name}} </h1>
                            <h2 class="sub_title">مديرية التربية في دمشق</h2>

                        </div>

                        <div class="col-md-4 text-center">
                            <img src="{{  asset('storage/'. $school_data->logo)}}" alt="" class="exam_logo">
                        </div>
                        <div class="col-md-4 respon_wd" style="padding-right: 70px;
                        padding-top: 15px;">
                            <p style="color: #152c4f; margin-bottom: 0;font-size: 20px;">المادة : {{$lesson_name}}</p>
                                <p style="color: #152c4f; margin-bottom: 0;font-size: 20px;"> الصف : {{$class_name}}</p>
                                <p style="color: #152c4f; margin-bottom: 0;font-size: 20px;"> الشعبة : {{$room_id}}</p>
                               <!-- <p style="color: #152c4f; margin-bottom: 0;font-size: 20px;">  الفصل : {{ $term_name }}</p>-->
                                <p style="color: #152c4f; margin-bottom: 0;font-size: 20px;">  العام الدراسي : {{ $year }}</p>
                                <p style="color: #152c4f; margin-bottom: 0;font-size: 20px;">المدة الزمينة:   {{ $exam->period }} دقيقة  </p>
                        </div>
                    </div>



                     <div class="row justify-content-center pt-4">
                        <div class="col-md-5">
                            <div class="circle-bg" style="margin: 0 auto;text-align:center">
                                <div class="circle circle-front">
                                    00:00
                                </div>
                                <div class="circle circle-back">
                                   00
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end pt4 pb-4">
                        <div class="col-md-5">
                            <h2 class="sub_title" style="padding-top: 130px;">اسم الطالب: <small>{{ $student->first_name }}
                                {{ $student->last_name }}</small> </h2>
                        <h2 class="sub_title">{{ $exam->name }}</h2>
                        </div>
                    </div>

                    <div class="row pt-4" style="justify-content: space-between;
                  direction: rtl;">
                        {{-- <div class="col-md-4">
                            <h2>علامة الطالب :
                                <button class="mark_sub">
                                    <span> {{ $exam_result->result }}
                                    </span>
                                </button>
                            </h2>
                        </div> --}}
                        <div class="col-md-4">
                            <h2 class="all_mark">العلامة الكلية : <button class="mark_sub">
                                    <span> {{$exam->success_mark}}
                                    </span>
                                </button></h2>
                        </div>
                    </div>

                    <form class="pt-4" style="text-align: right;width: inherit;
                    direction: rtl;" action="{{ route('dashboard.student.save_exam') }}" method="post" id="this_exam" enctype="multipart/form-data">

                        @csrf
                        @php
                        $i=1;
                        $kk=0;
                        @endphp
                        <input type="hidden" name="content_id" value="{{$content_id}}">
                        <h1 style="margin-bottom:35px;font-size:24px;font-weight:bold">أجب عن الأسئلة التالية:</h1>
                        @foreach ($questions as $question)
                        @if ($question->section)
                        @if ($kk!=$question->section->id )
                            @php
                                $kk=$question->section->id;
                            @endphp

                            @if ($question->section->type=='0')

                                <!--<h2 style="font-weight:bold;font-size:22px">please reade the text then answer the questions</h2>-->
                                <div class="row pt-4" style="direction: rtl;text-align: right;">
                                    <div class="col-md-8">
                                <h4 >اقرأ النص التالي ثم أجب عن الأسئلة</h4>
                                <p>
                                    {{ $question->section->content }}
                                </p>
                                    </div>
                                </div>
                                @endif
                                @if ($question->section->type=='3')
                                    <!--<h2 style="font-weight:bold;font-size:22px"> please look at the image below then answer the questions </h2>   -->
                                    <div class="row pt-4" style="direction: rtl;text-align: right;">
                                        <div class="col-md-8">
                                    <h4 > يرجى النظر للصورة التالية ثم الإجابة عن الأسئلة ..</h4>
                                    <img style="max-width:50%;max-height:25%" src="{{ asset('storage/'.$question->section->content) }}"  >
                                </div>
                            </div>
                                @endif


                                @if($question->section->type=='2')
                                <div class="row pt-4" style="direction: rtl;text-align: right;">
                                    <div class="col-md-8">
                                    <!--<h2 style="font-weight:bold;font-size:22px">  please listen to the audio then answer the questions </h2>-->
                                    <h4 >  استمع للملف الصوتي ثم أجب عن الأسئلة </h4>
                                    <audio src="{{ asset('storage/'.$question->section->content) }}" controls  ></audio>
                                    </div>
                                </div>
                                @endif
                            @endif
                        @endif
                        {{-- <div class="row pt-4" style="direction: rtl;text-align: right;">
                            <div class="col-md-8">
                        <h2>
                        <span style="font-size: 14px;">
                            {{ $i++ .'_' }}  <i class=" fa fa-file-text-o"></i>
                        </span>
                        {{ $question->question_form }}
                        </h2>
                            </div>
                        </div> --}}
                        <div class="row pt-4" style="direction: rtl;text-align: right;">
                            <div class="col-md-8">
                                <h4><small class="num"></small>{{ $question->question_form }}</h4>
                            </div>
                        </div>



                        @if ($question->ques_type=='1')
                <div class="row pt-4" style="direction: rtl;text-align: right;">
                    <div class="col-md-8">
                        <div class="container_1">
                            <div class="custom-radio">
                                @foreach (json_decode($question->option->myOptions,true) as $key => $item)

                                <input type="checkbox" id="rb{{ $item.$key.$question->id }}"  name="answer[{{ $question->id }}][]" value="{{ $item }}">


                                <label class="radio-label" for="rb{{ $item.$key.$question->id }}">
                                    <div class="radio-circle"></div>
                                    <span class="radio-text">{{ $item }}</span>
                                    </label>
                                    @endforeach

                        </div>
                    </div>
                </div>
            </div>

                @elseif ($question->ques_type=='2')

            <div class="row pt-4" style="direction: rtl;text-align: right;">
                <div class="col-md-8">
                    <textarea name="answer[{{ $question->id }}][]" value="" class="form-control"
                        style="direction:rtl; text-align: right;" cols="3" rows="2">
                    </textarea>
                    <input type="hidden" name="traditional" value="true">
                </div>
            </div>



                @elseif ($question->ques_type=='3')

                <label for="file-input">قم باختيار ملف:</label>
                <input type="file" name="answer[{{ $question->id }}][]" value="" class=""
                    style="direction:rtl; text-align: right;" >
                <input type="hidden" name="traditional" value="true">



        <!-- end question-->
            @endif
    @endforeach

    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="mt-4" id="button" type="submit">حفظ</button>
        </div>
    </div>

    </form>
    <!--end content of file -->


    </div>

    </div><!--end content-wrapper pb-0-->
    </div><!--end main panels-->
    <script>
        $(document).on('click', '.show', function() {
            $('.show1').show();
        })
    </script>
@endsection
@section('js')

    <script>
    $( document ).ready(function(){
    let exam_id = 'proj{{ $content_id }}' ;

        function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        let x =     setInterval(function () {

                --timer
                var seconds = timer % 60; // Seconds that cannot be written in minutes
                var secondsInMinutes = (timer - seconds) / 60; // Gives the seconds that COULD be given in minutes
                var minutes = secondsInMinutes % 60; // Minutes that cannot be written in hours
                var hours = (secondsInMinutes - minutes) / 60;

                seconds = seconds < 10 ? "0" + seconds : seconds;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                hours = hours < 10 ? "0" + hours : hours;
                // days = days < 10 ? "0" + days : days;

                display.text( hours + ":" + minutes + ":" + seconds);

                if (timer == 0) {
                    clearInterval(x);
                    //submit the exam
                    $('#this_exam').submit();
                }
            }, 1000);
        }


var period = {{ $content->period }} * 60,
display = $('.circle-front');
startTimer(period, display);

$('#this_exam').on('submit',function() {
window.localStorage.clear();
});



// save answers in local storage

$('input[type="text"],input[type="checkbox"]').on('input',function(){
    var a=[];
    var one = $('input[type="text"],input[type="checkbox"]').each(function(index,input ) {
        if (input.getAttribute('type')=='text') {
            a[index] =
                        {
                            'type':input.getAttribute('type'),
                            'value':input.value
                        };
        }
        else if(input.getAttribute('type')=='checkbox'){
            a[index]=
                {
                    'type':input.getAttribute('type'),
                    'status':input.checked,
                    'value':input.getAttribute('value'),
                };
        }

    });

    window.localStorage.setItem('proj', JSON.stringify(a));
    var records = window.localStorage.getItem('proj');
    console.log(records);

});




window.onload =function(){

    var a=localStorage.getItem('proj');
    a=JSON.parse(a);
    var one = document.querySelectorAll("input[type='checkbox'],input[type='text']").forEach( (input,index) => {
        if (input.getAttribute('type')=='text') {
            input.value = a[index].value;
        }
        else if (input.getAttribute('type')=='checkbox') {

            if (a[index].status==true){
                input.setAttribute('checked',true);
            }

        }

    });


}

});
</script>
@endsection



