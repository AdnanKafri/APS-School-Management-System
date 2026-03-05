@extends('teachers2.layouts.app')
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
      width: 100%;
      border: 2px solid #528de5;
      background-color: #528de5;
      height: 40px;
      color: white;
      font-size: 24px;
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
      text-align: center
    }
    .sub_title{
      font-size: 25px;
      color: #152c4f;
      text-align: center

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
        color: #4986e1;
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
    <li class="li"><a href="#"> الصفحة الرئيسية</a></li>
    <li class="li"> <a href="{{ route('dashboard.StudentsRoomLesson_exammark1',[$room->id ,$teacher->id,$lesson->id,$exam_id]) }}">عودة</a></li>

    {{-- <li class="li"><a href="#">بنك الاسئلة</a></li> --}}
    </ul>

    <div class="content-wrapper pb-0">
        <div class="container" style="padding-bottom: 150px;">
            <div class="form_main">
                <div class="row" style="direction: rtl;">

                <div class="col-md-4" style="padding-top: 26px;">
                <h1 class="title_exam">   {{$school_data->name}} </h1>
                <h2 class="sub_title">مديرية التربية في دمشق
                </div>

                <div class="col-md-4 text-center">
                    <img src="{{  asset('storage/'. $school_data->logo)}}" alt="" class="exam_logo">
                </div>
                    <div class="col-md-3 respon_wd">
                    <label for="">الصف :</label>&nbsp;
                    <input disabled class="input" name="text" type="text" value="{{$lesson->name}}">

                    <label for="">الشعبة :</label>&nbsp;
                    <input disabled class="input" name="text" type="text" value="{{$room->name}}">

                    <label for="">الفصل :</label>&nbsp;
                    <input disabled class="input" name="text" type="text" value="{{$term}}">

                    <label for="">المادة :</label>&nbsp;
                    <input disabled class="input" name="text" type="text" value="{{$lesson->name}}">
                    </div>
                </div>



                <div class="row justify-content-end">
                    <div class="col-md-5">
                      <h2 class="sub_title">اسم الطالب: <small>{{ $student->first_name }} {{ $student->last_name }}</small> </h2>
                      <h2 class="sub_title">{{ $exam->name }}</h2>
                    </div>
                  </div>

                  <div class="row" style="justify-content: space-between;
                  direction: rtl;">
                    <div class="col-md-4">
                      <h2>علامة الطالب :
                         <button class="mark_sub">
                        <span> {{ $exam_result->result }}
                        </span>
                      </button>
                    </h2>
                    </div>
                    <div class="col-md-4">
                      <h2 class="all_mark">العلامة الكلية : <button class="mark_sub">
                        <span> {{ $exam->success_mark }}
                        </span>
                      </button></h2>
                    </div>
                  </div>
                  <form class="mb-5" style="width: inherit;direction: rtl;text-align: right;"  action="{{ route('dashboard.update_result') }}" method="post" >
                    @csrf
                    <input type="hidden" name="exam" value="{{ $exam->id }}">
                    <input type="hidden" name="exam_result_id" value="{{ $exam_result->id }}">
                    <!--content of file -->

                    @php
                            $i=1;
                            @endphp
                            @foreach ($questions as $question)
                            @if($question)

                            @php
                            $count=0;
                            @endphp


                            {{-- <h2>{{ $question->question_form }}</h2> --}}
                            <div class="row pt-4" style="direction: rtl;text-align: right;">
                                <div class="col-md-8">
                                    <h4><small class="num"></small>{{ $question->question_form }}</h4>
                                </div>
                            </div>

                            @if ($question->ques_type == '1')
                            <div class="row pt-4" style="direction: rtl;text-align: right;">
                            <div class="col-md-8">

                            <div class="container_1">
                                <div class="custom-radio">
                                    @foreach (json_decode($question->option->myOptions, true) as $item)

                                    <input type="checkbox" name="rb" id="rb{{ $item }}"
                                    @if ($exam_result->user_answers) @foreach (json_decode($exam_result->user_answers, true) as $key => $value)
                                    @if ($key == $question->id)
                                        @if (in_array($item, $value))
                                            checked @endif
                                    @endif
                                    @endforeach
                                    @endif
                                    disabled >
                                    @if ($question->answer != 'null')
                                    @if (in_array($item, json_decode($question->answer, true)))
                                    <label class="radio-label" for="rb{{ $item }}">
                                    <div class="radio-circle"></div>
                                    <span class="radio-text" style="color: green">{{ $item }}</span>
                                    </label>
                                    @else
                                    @if ($exam_result->user_answers)
                                        @foreach (json_decode($exam_result->user_answers, true) as $key => $value)
                                            @if ($key == $question->id)
                                                @if (in_array($item, $value))
                                                <label class="radio-label" for="rb{{ $item }}">
                                                    <div class="radio-circle"></div>
                                                    <span class="radio-text" style="color: red" >{{ $item }}</span>
                                                </label>
                                                    @else
                                                    <label class="radio-label" for="rb{{ $item }}">
                                                        <div class="radio-circle"></div>
                                                        <span class="radio-text"  >{{ $item }}</span>
                                                    </label>

                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                    <label class="radio-label" for="rb{{ $item }}">
                                        <div class="radio-circle"></div>
                                        <span class="radio-text"  >{{ $item }}</span>
                                    </label>
                                    @endif
                                @endif
                            @endif
 
                            @if ($question->answer != 'null')
                                @if (in_array($item, json_decode($question->answer, true)))
                                    @php
                                        $a = 0;
                                    @endphp
                                    @if ($exam_result->user_answers)
                                        @foreach (json_decode($exam_result->user_answers, true) as $key => $value)
                                            @if ($key == $question->id)
                                                @php
                                                    $a = 0;
                                                    if (json_decode($question->answer, true) == $value) {
                                                        $a = 1;
                                                    }
                                                    $diff = array_diff(json_decode($question->answer, true), $value);
                                                    $diff2 = array_diff($value, json_decode($question->answer, true));
                                                @endphp
                                                @foreach ($value as $item2)
                                                    @if ($item2 == $item)
                                                        @if (!in_array($item2, json_decode($question->answer, true)))
                                                        <label class="radio-label" for="rb{{ $item }}">
                                                            <div class="radio-circle"></div>
                                                            <span class="radio-text" style="color: red" >{{ $item }}</span>
                                                        </label>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            @endif
                        @endforeach
                                    </div>
                                </div>
                                </div>

                    <!-- mark -->
                    <div class="col-md-4" style="text-align: end;">
                        <input type="text" class="input"  name="mark[]" readonly
                        @if ($a == 0) value="0" @else
                                value="{{ $question->exam_question[0]->mark }}" @endif style="width: 60px;height: 50px;"> &nbsp;
                                <input hidden name="mark0" type="text" value="{{ $question->exam_question[0]->mark }}">
                                <button class="mark_sub"><span> {{ $question->exam_question[0]->mark }}</span></button>
                    </div>
                       </div>

                    <!-- end mark -->

                    @else



                    @if ($exam_result->user_answers)
                    @foreach (json_decode($exam_result->user_answers, true) as $key => $value)
                        @if ($key == $question->id)
                        <!-- mark -->
                        <div class="row pt-4" style="direction: rtl;text-align: right;">
                        <div class="col-md-8">
                            <textarea name="content" value="{{ $value[0] }}" class="form-control" style="direction:rtl; text-align: right;" cols="3" rows="2">{{ $value[0] }}
                            </textarea>
                            <a class="btn btn-primary show" style="float: left;color: white;display: none;">اظهار الاجابة</a>
                            <p class="show1" style="display:none">{{ $question->answer }}</p>
                        </div>

                    <div class="col-md-4" style="text-align: end;">
                        <input  class="input" name="traditional_result[{{ $question->id }}]" placeholder=""
                        type="number" min="0.0" step="0.001" max="{{ $question->exam_question[0]->mark }}"
                        @if ($exam_result->traditional_result != null) @foreach (json_decode($exam_result->traditional_result, true) as $key => $value1)
                        @if ($key == $question->id)
                        value="{{ $value1 }}" @endif
                        @endforeach
                        @endif style="width: 60px;height: 50px;"> &nbsp;
                        <button class="mark_sub"><span> {{ $question->exam_question[0]->mark }}</span></button>
                    </div>
                       </div>

                    <!-- end mark -->
            @endif

            @endforeach

            @else
            <div class="row">
            <div class="col-md-8">
            <textarea name="content" value="" class="form-control" style="direction:rtl; text-align: right;"
            cols="3" rows="2">
            </textarea>
            <a class="btn btn-primary show" style="float: left;color: white;display: none;">
            اظهار الاجابة</a>
            <p class="show1" style="display:none">{{ $question->answer }}</p>
            </div>

            <div class="col-md-4" style="text-align: end;">
                <input  class="input"   name="traditional_result[{{ $question->id }}]" placeholder=""  type="number"
                min="0" max="{{ $question->exam_question[0]->mark }}" style="width: 60px;height: 50px;"> &nbsp;
                <input hidden name="mark0" type="text" value="3333333333333333">
                        <button class="mark_sub"><span> 33333333</span></button>
            </div>
        </div>
@endif

<!-- end question-->

@endif
@endif
@endforeach
                    <div class="row pt-4 justify-content-center">
                        <div class="col-md-4">
                            <button class="mt-4" id="button" type="submit">حفظ</button>
                        </div>
                    </div>
                    </form>
                    <!--end content of file -->
                </div>
            </div>
        </div>

            <!-- end add question form -->

        </div><!--end content-wrapper pb-0-->
      </div><!--end main panels-->
      <script>
        $(document).on('click', '.show', function() {
            $('.show1').show();
        })
    </script>
@endsection
