@extends('school_controller.layouts.app')
@section('css')

<style>
    .form_main {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background-color: rgb(255, 255, 255);
      padding: 30px 30px 30px 30px;
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
      width: 25%;
      border: 2px solid #528de5;
      background-color: #528de5;
      height: 40px;
      color: white;
      font-size: .8em;
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
    .row{
        width: inherit;
    }
    .exam_logo{
        top: 4px;
        position: relative;
        max-width: 55%;
    }
    /*  */
    /* Input container */
    .input {
        margin-bottom: 15px!important;
        max-width: 225px!important;
        height: 30px!important;
        border: 2px solid transparent!important;
        outline: none!important;
        border-bottom: 2px solid #9ac1fb!important;
        caret-color: #f3f9ff!important;
        background-color: #f3f9ff!important;
        padding: 5px!important;
        transition: .5s linear!important;
        font-family: monospace!important;
        /* letter-spacing: 1px; */
        text-align: center!important;
    }

    .input:focus {
      border: 2px solid #9ac1fb!important;
      caret-color: #9ac1fb!important;
      color: #9ac1fb!important;
      box-shadow: 4px 4px 10px #070707!important;
    }

    .input:focus::placeholder {
      color: #9ac1fb;
    }
    .title_exam{
      font-size: 32px;
      color: #152c4f;
    }
    .sub_title{
      font-size: 25px;
      color: #152c4f;

    }
    /* css mark */
    .mark_sub {
     position: relative;
     height: 48px;
        width: 40px;
        padding: 0 24px;
     border: 2px solid #4382e0;
     background: #ffffff !important;
     user-select: none;
     white-space: nowrap;
     transition: all .05s linear;
     font-family: inherit;
    }

    .mark_sub:before, .mark_sub:after {
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
        right: -10px;
        text-align: center;
    }
    form div span{
        position: inherit !important;
      background-color: transparent !important;
      color: #4382e0 !important;
      width: auto !important;
    }
    form div button{
      margin-left: 0;
    }
    .all_mark{
      position: relative;
        top: -25px;
    }
    .respon_wd{
      max-width: 32.33333%;
      text-align: right;
    }
    .num{
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
    @media(min-width:100px) and (max-width:487px){
      .respon_wd {
        max-width: 100% !important;
        text-align: center !important;
    }
    }

    @media(min-width:488px) and (max-width:501px){
      .respon_wd {
        max-width: 93% !important;
        text-align: center !important;
    }
    }

    @media(min-width:502px) and (max-width:529px){
      .respon_wd {
        max-width: 89% !important;
        text-align: center !important;
    }
    }
    @media(min-width:530px) and (max-width:929px){
      .respon_wd {
        max-width: 100%;
        text-align: right!important;
        display: inline-grid;

    }
    }


    @media(min-width:100px) and (max-width:820px){
      .title_exam{
        text-align: center;

      }
      .sub_title{
        text-align: center;

      }
      .inputGroup label{
        padding-right: 70px !important;
      }

    }

    @media(min-width:821px) and (max-width:1215px){
      .title_exam{
        text-align: center;
        font-size: 23px !important;

      }
      .sub_title{
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

.custom-radio input[type="checkbox"]:checked + .radio-label {
  background-color: #9ec4fd;
}

.custom-radio input[type="checkbox"]:checked + .radio-label .radio-circle {
  border-color: #fff;
  background-color: #152c4f96;
}

.custom-radio input[type="checkbox"]:checked + .radio-label .radio-text {
  color: #64748b;
}
form div {
    position: relative;
    min-height: auto !important;
    margin-top: 25px;
}

    </style>
@section('content')
<style>
    .pb-2{
    padding-bottom: 4.5rem !important;
   }
</style>

 @php
          $school_data = \App\School_data::first();
           @endphp

<div class="main-panel" style="background: #f8f9fb;">
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
     <li class="li"><a href="{{route('dashboard.coordinator.exams_quizes')}}"> الصفحة الرئيسية</a></li>
    @if($exam->type=="2")
    <li class="li">
        <a href="{{route('coordinator.StudentsRoomLesson_quize',[$room->id,$coordinator->id,$lesson->id]) }}">عودة</a>
    </li>
    @else
    <li class="li">
        <a  style="cursor: pointer" href="{{ route('coordinator_exam',[$room->id,$coordinator->id,$lesson->id]) }}">عودة</a>
    </li>
    @endif

    {{-- <li class="li"><a href="#">بنك الاسئلة</a></li> --}}
    </ul>

    <div class="content-wrapper pb-0">
        <div class="container" style="padding-bottom: 150px;">




            <form class="form_main" action="">

                <div class="row" style="direction: rtl;">
                <div class="col-md-4" style="padding-top: 26px;">
                <h1 class="title_exam">   {{$school_data->name}} </h1>
                <h2 class="sub_title">مديرية التربية في دمشق</h2>
                <h2 class="sub_title">{{ $exam->name }}</h2>
                </div>

                <div class="col-md-4 text-center">
                    <img src="{{  asset('storage/'. $school_data->logo)}}" alt="" class="exam_logo">
                </div>
                    <div class="col-md-3 respon_wd">
                    <label for="">الصف :</label>&nbsp;
                    <input disabled class="input" name="text" type="text" value="{{$class1}}">

                    <label for="">الشعبة :</label>&nbsp;
                    <input disabled class="input" name="text" type="text" value="{{$room->name}}">

                    <label for="">الفصل :</label>&nbsp;
                    <input disabled class="input" name="text" type="text" value="{{$term}}">

                    <label for="">المادة :</label>&nbsp;
                    <input disabled class="input" name="text" type="text" value="{{$lesson->name}}">
                    </div>
                </div>


                @php
                $i = 1;
                $kk = 0;
                @endphp
                {{-- @isset($selected_ques1) --}}

                @foreach ($selected_ques1 as $question1)
                    @foreach ($question1 as $question)
                        @if ($question->section)
                            @if ($kk != $question->section->id)
                                @php
                                    $kk = $question->section->id;
                                @endphp

                                 @if ($question->section->type == '3')
                                 <div class="row pt-4 pb-2" style="direction: rtl;text-align: right;">
                                 <div class="col-md-10">
                                 <h3 style="color:#094e89"> يرجى التأمل بالصورة ثم الإجابة على الأسئلة
                                 </h3>
                                 <img style="margin:0 auto; width: 20%; "
                                 src="{{ asset('storage/' . $question->section->content) }}">
                                 </div>
                                 </div>
                             @endif

                                @if ($question->section->type == '0')
                                <div class="row pt-4 pb-2" style="direction: rtl;text-align: right;">
                                    <div class="col-md-10">
                                    <h3 style="color:#094e89;"><small class="num"></small>
                                        يرجى قراءة النص ثم الاجابة </h3>

                                        <p  style="justify-content:center; margin: 0 auto ; direction:rtl;pading-top:14px ">
                                            {{ $question->section->content }}
                                        </p>
                                    </div>
                                </div>

                                @endif



                                @if ($question->section->type == '2')
                                <div class="row pt-4 pb-2" style="direction: rtl;text-align: right;">
                                <div class="col-md-10">
                                    <h3 style="color: #094e89"> يرجى الاستماع للصوت ثم الإجابة على الأسئلة
                                    </h3>
                                    <div style="justify-content: center;margin:0 auto ">
                                        <audio src="{{ asset('storage/' . $question->section->content) }}"
                                        controls>
                                        </audio>
                                    </div>
                                </div>
                                </div>
                                @endif
                            @endif
                        @endif

                        @if ($question->ques_type == '1')
                        <div class="row pt-2 pb-2" style="direction: rtl;text-align: right;">
                        <div class="col-md-10">

                            <h3 style="color:#094e89"  class="myquestion{{ $i - 1 }}" data-mark="{{ $question->mark }}" data-answer="{{ $question->answer }}" data-ques_num="ques{{ $k = $i - 1 }}">
                                {{-- <span> {{ $i++ . '_' }} <i class=" fa fa-file-text-o " style="margin-left: 10px;"></i> </span> --}}
                                {{ $question->question_form }}</h3>
                                <div class="container_1">
                                    <div class="custom-radio">
                                    @foreach (json_decode($question->option->myOptions, true) as $item)

                                      <input type="checkbox" name="rb" id="rb{{ $item }}"
                                    @if ($question->answer != 'null') @foreach (json_decode($question->answer) as $itemq)
                                    @if ($item == $itemq)
                                    checked
                                    @endif
                                    @endforeach
                                    @endif
                                    disabled />
                                      <label class="radio-label"for="rb{{ $item }}">
                                        <div class="radio-circle"></div>
                                        <span class="radio-text">{{ $item }}</span>
                                      </label>
                                      @endforeach
                                    </div>
                                  </div>
                                {{-- <div class="inputGroup">
                                    @foreach (json_decode($question->option->myOptions, true) as $item)
                                    <input type="checkbox" name="rb" id="rb{{ $item }}"
                                    @if ($question->answer != 'null') @foreach (json_decode($question->answer) as $itemq)
                                    @if ($item == $itemq)
                                    checked
                                    @endif
                                    @endforeach
                                    @endif
                                    disabled />
                                    <label for="rb{{ $item }}">{{ $item }}</label>
                                    @endforeach
                                </div> --}}
                        </div>
                        </div>


        <input type="hidden" class="form-control user_answers" name="user_answers" placeholder="" value="">
        <input type="hidden" class="form-control selected_ques" name="selected_ques" placeholder=""value="{{ $exam->selected_ques1 }}">
        <input type="hidden" class="form-control exam_id" name="exam_id" placeholder=""value="{{ $exam->id }}">
        <input type="hidden" class="form-control result" name="result" placeholder="" value="">
        @elseif ($question->ques_type == '2')
        <div class="row pt-2 pb-2" style="direction: rtl;text-align: right;">
            <div class="col-md-10">
        <h3 style="color:#094e89" >
            {{-- <span style="font-size: 14px;">
            {{ $i++ . '_' }} <i class=" fa fa-file-text-o " style="margin-left: 10px;"></i></span> --}}
            {{ $question->question_form }}</h3>

        <textarea name="content" class="form-control" style="direction:rtl; text-align: right;" cols="3"rows="2"> {{ $question->answer }}</textarea>
            </div>
        </div>
        <!--input type="submit" class="btn btn-primary" style="width: 100px;" value="حفظ"-->
        @endif
        @endforeach
        @endforeach




        </form>
    </div>
</div>
        <!-- end add question form -->
@endsection
