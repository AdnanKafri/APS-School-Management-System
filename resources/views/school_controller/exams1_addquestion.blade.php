@extends('school_controller.layouts.app')
@section('css')
    <style>
        /* submit button */
        .my-button {
            width: inherit;
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            color: white;
            background-color: #4158D0;
            background-image: linear-gradient(43deg, #4158D0 0%, #a5c9ff 46%, #152c4f 100%);
            transition: 0.2s ease-in-out;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
        }

        .my-button:hover {
            box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
        }

        .my-button:active {
            background-color: #4158D0;
            background-image: linear-gradient(43deg, #4158D0 0%, #a5c9ff 46%, #152c4f 100%);
        }

        .modal-body {
            text-align: center;
        }

        .container2 {
            direction: rtl;
            text-align: right;
            max-width: 100%;
            background: #F8F9FD;
            background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
            border-radius: 40px;
            padding: 25px 35px;
            border: 5px solid rgb(255, 255, 255);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
            margin: 20px;
        }

        .heading {
            text-align: center;
            font-weight: 900;
            font-size: 30px;
            color: rgb(16, 137, 211);
        }

        .form {
            margin-top: 20px;
        }

        /* .form .input {
      width: 100%;
      background: white;
      border: none;
      padding: 15px 20px;
      border-radius: 20px;
      margin-top: 15px;
      box-shadow: #cff0ff 0px 10px 10px -5px;
      border-inline: 2px solid transparent;
    }

    .form .input::-moz-placeholder {
      color: rgb(170, 170, 170);
    } */
        /*
    .form .input::placeholder {
      color: rgb(170, 170, 170);
    }

    .form .input:focus {
      outline: none;
      border-inline: 2px solid #12B1D1;
    } */

        /* .form .forgot-password {
      display: block;
      margin-top: 10px;
      margin-left: 10px;
    }

    .form .forgot-password a {
      font-size: 11px;
      color: #0099ff;
      text-decoration: none;
    } */

        .form .login-button {
            display: block;
            width: 100%;
            font-weight: bold;
            background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
            color: white;
            padding-block: 15px;
            margin: 20px auto;
            border-radius: 20px;
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
            border: none;
            transition: all 0.2s ease-in-out;
        }

        .form .login-button:hover {
            transform: scale(1.03);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
        }

        .form .login-button:active {
            transform: scale(0.95);
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
        }

        .social-account-container {
            margin-top: 25px;
        }

        .social-account-container .title {
            display: block;
            text-align: center;
            font-size: 10px;
            color: rgb(170, 170, 170);
        }

        .social-account-container .social-accounts {
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 5px;
        }

        .social-account-container .social-accounts .social-button {
            background: linear-gradient(45deg, rgb(0, 0, 0) 0%, rgb(112, 112, 112) 100%);
            border: 5px solid white;
            padding: 5px;
            border-radius: 50%;
            width: 40px;
            aspect-ratio: 1;
            display: grid;
            place-content: center;
            box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 12px 10px -8px;
            transition: all 0.2s ease-in-out;
        }

        .social-account-container .social-accounts .social-button .svg {
            fill: white;
            margin: auto;
        }

        .social-account-container .social-accounts .social-button:hover {
            transform: scale(1.2);
        }

        .social-account-container .social-accounts .social-button:active {
            transform: scale(0.9);
        }

        .agreement {
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .agreement a {
            text-decoration: none;
            color: #0099ff;
            font-size: 9px;
        }



        form div span {
            background-color: transparent;
            height: auto;
            width: auto;
        }

        .form {
            --timing: 0.3s;
            --width-of-input: 100%;
        }

        /* css checkbox */


        .boxes {
            margin: auto;
            padding: 50px;
            /* background: #484848; */
        }

        /*Checkboxes styles*/
        /* input[type="checkbox"] { display: none; }

    input[type="checkbox"] + label {
      display: block;
      position: relative;
      padding-right: 35px;
      margin-bottom: 20px;
      font-weight: 600;
      color: #152c4f;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
    }

    input[type="checkbox"] + label:last-child { margin-bottom: 0; }

    input[type="checkbox"] + label:before {
      content: '';
      display: block;
      width: 20px;
      height: 20px;
      border: 1px solid #6cc0e5;
      position: absolute;
      right: 0;
      top: 0;
      opacity: .6;
      -webkit-transition: all .12s, border-color .08s;
      transition: all .12s, border-color .08s;
    }

    input[type="checkbox"]:checked + label:before {
      width: 10px;
      top: -5px;
      left: 5px;
      border-radius: 0;
      opacity: 1;
      border-top-color: transparent;
      border-left-color: transparent;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
    } */

        .todo-list {
            /* background: #FFF; */
            font-size: 20px;
            max-width: 100%;
            direction: rtl;
            text-align: right;
            padding: 0.5em 1em;
            /* box-shadow: 0 5px 30px rgba(0, 0, 0, 0.2); */
        }

        .todo {
            display: block;
            position: relative;
            padding: 1em 1em 1em 16%;
            /* margin: 0 auto; */
            right: 0;
            direction: rtl;
            text-align: right;
            cursor: pointer;
            border-bottom: solid 1px #ddd;
        }

        .todo:last-child {
            border-bottom: none;
        }

        .todo__state {
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0;
        }

        .todo__text {
            color: #135156;
            transition: all 0.8s/2 linear 0.8s/2;
            padding-right: 97px;
            direction: rtl;
            text-align: right;
        }

        .todo__icon {
            position: absolute;
            top: -19px;
            bottom: 0;
            right: 0;
            transform: rotateY(180deg);
            /* width: 76%; */
            height: 69%;
            margin: auto;
            fill: none;
            stroke: #4382e0;
            stroke-width: 2;
            stroke-linejoin: round;
            stroke-linecap: round;
        }

        @media(min-width:100px) and (max-width:526px) {
            .todo__icon {
                width: 100% !important;
                height: auto !important;
            }

            .todo__text {
                padding-right: 18px !important;
                width: 120%;
            }
        }

        @media(min-width:527px) and (max-width:614px) {
            .todo__icon {
                width: 100% !important;
                height: auto !important;
            }

            .todo__text {
                padding-right: 25px !important;
                width: 120%;
            }
        }

        @media(min-width:527px) and (max-width:614px) {
            .todo__icon {
                width: 100% !important;
                height: auto !important;
            }

            .todo__text {
                padding-right: 25px !important;
                width: 120%;
            }
        }

        @media(min-width:615px) and (max-width:737px) {
            .todo__icon {
                width: 100% !important;
                height: auto !important;
            }

            .todo__text {
                padding-right: 40px !important;
                width: 120%;
            }
        }

        @media(min-width:738px) and (max-width:827px) {
            .todo__icon {
                width: 88% !important;
                height: auto !important;
            }

            .todo__text {
                padding-right: 40px !important;
                width: 120%;
            }
        }

        @media(min-width:828px) and (max-width:927px) {
            .todo__icon {
                width: 88% !important;
                height: auto !important;
            }

            .todo__text {
                padding-right: 60px !important;
                width: 120%;
            }
        }

        .todo__line,
        .todo__box,
        .todo__check {
            transition: stroke-dashoffset 0.8s cubic-bezier(0.9, 0, 0.5, 1);
        }

        .todo__circle {
            stroke: #4382e0;
            stroke-dasharray: 1 6;
            stroke-width: 0;
            transform-origin: 13.5px 12.5px;
            transform: scale(0.4) rotate(0deg);
            animation: none 0.8s linear;
        }

        @keyframes explode {
            30% {
                stroke-width: 3;
                stroke-opacity: 1;
                transform: scale(0.8) rotate(40deg);
            }

            100% {
                stroke-width: 0;
                stroke-opacity: 0;
                transform: scale(1.1) rotate(60deg);
            }
        }

        .todo__box {
            stroke-dasharray: 56.1053, 56.1053;
            stroke-dashoffset: 0;
            transition-delay: 0.16s;
        }

        .todo__check {
            stroke: #4382e0;
            stroke-dasharray: 9.8995, 9.8995;
            stroke-dashoffset: 9.8995;
            transition-duration: 0.32s;
        }

        .todo__line {
            stroke-dasharray: 168, 1684;
            stroke-dashoffset: 168;
        }

        .todo__circle {
            animation-delay: 0.56s;
            animation-duration: 0.56s;
        }

        .todo__state:checked~.todo__text {
            transition-delay: 0s;
            color: #4382e0;
            opacity: 0.6;
        }

        .todo__state:checked~.todo__icon .todo__box {
            stroke-dashoffset: 56.1053;
            transition-delay: 0s;
        }

        .todo__state:checked~.todo__icon .todo__line {
            stroke-dashoffset: -8;
        }

        .todo__state:checked~.todo__icon .todo__check {
            stroke-dashoffset: 0;
            transition-delay: 0.48s;
        }

        .todo__state:checked~.todo__icon .todo__circle {
            animation-name: explode;
        }
        .form {
    --timing: 0.3s!important;
    --width-of-input: 200px!important;
    --height-of-input: 40px!important;
    --border-height: 2px!important;
    --input-bg: #a5c9ff!important;
    --border-color: #4382E0!important;
    --border-radius: 30px!important;
    --after-border-radius: 1px!important;
    position: relative!important;
    width: var(--width-of-input)!important;
    height: var(--height-of-input)!important;
    display: flex!important;
    align-items: center!important;
    padding-inline: 0.8em!important;
    border-radius: var(--border-radius)!important;
    transition: border-radius 0.5s ease!important;
    background: var(--input-bg,#fff)!important;
    flex-direction: inherit !important;
    padding: 0px;
    box-shadow: none;
}
.form button {
    border: none;
    background: none;
    color: #4382E0;
}
.ul {
  list-style: none;
  margin: 0 auto;
  background: #ffffff;
  padding: 0;
  margin-top: 50%;
}
@media (min-width: 36em) {
    .ul {
    margin-top: 5%;
  }
}
.ul li {
  position: relative;

}
input {
  -webkit-appearance: none;
  width: 2.20rem;
  height: 2.20rem;
  border: 1px solid #d9d9d9;
  border-radius: 1px;
  vertical-align: sub;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  right: 1rem;
  outline: none;
}
.s123:checked {
  background-color: #152c4f;
  border-color: #666;
  border-radius: 46%;
}
.s11:checked {
  background-color: #61414100;
  border-color: #666;
}
input:checked + label {
  text-decoration: line-through;
  color: #b3b3b3;
  font-weight: 600;
  background-color: #f7f7f7;
}
.s123:checked:focus, .s123:checked:hover {
  box-shadow: 0 0 0 3px #d9d9d9;
  border-color: #152c4f;
}
.s123:after {
  content: "";
  width: 100%;
  height: 100%;
  position: absolute;
  right: 0;
  top: 0;
  background-image: url("data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9JzMwMHB4JyB3aWR0aD0nMzAwcHgnICBmaWxsPSIjZmZmZmZmIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCIgdmVyc2lvbj0iMS4xIiB4PSIwcHgiIHk9IjBweCI+PHRpdGxlPmljb25fYnlfUG9zaGx5YWtvdjEwPC90aXRsZT48ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz48ZyBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48ZyBmaWxsPSIjZmZmZmZmIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyNi4wMDAwMDAsIDI2LjAwMDAwMCkiPjxwYXRoIGQ9Ik0xNy45OTk5ODc4LDMyLjQgTDEwLjk5OTk4NzgsMjUuNCBDMTAuMjI2Nzg5MSwyNC42MjY4MDE0IDguOTczMTg2NDQsMjQuNjI2ODAxNCA4LjE5OTk4Nzc5LDI1LjQgTDguMTk5OTg3NzksMjUuNCBDNy40MjY3ODkxNCwyNi4xNzMxOTg2IDcuNDI2Nzg5MTQsMjcuNDI2ODAxNCA4LjE5OTk4Nzc5LDI4LjIgTDE2LjU4NTc3NDIsMzYuNTg1Nzg2NCBDMTcuMzY2ODIyOCwzNy4zNjY4MzUgMTguNjMzMTUyOCwzNy4zNjY4MzUgMTkuNDE0MjAxNCwzNi41ODU3ODY0IEw0MC41OTk5ODc4LDE1LjQgQzQxLjM3MzE4NjQsMTQuNjI2ODAxNCA0MS4zNzMxODY0LDEzLjM3MzE5ODYgNDAuNTk5OTg3OCwxMi42IEw0MC41OTk5ODc4LDEyLjYgQzM5LjgyNjc4OTEsMTEuODI2ODAxNCAzOC41NzMxODY0LDExLjgyNjgwMTQgMzcuNzk5OTg3OCwxMi42IEwxNy45OTk5ODc4LDMyLjQgWiI+PC9wYXRoPjwvZz48L2c+PC9nPjwvc3ZnPg==");
  background-size: 40px;
  background-repeat: no-repeat;
  background-position: center;
}
.s123:focus, .s123:hover {
  box-shadow: 0 0 0 3px #ebebeb;
  border-color: #8c8c8c;
}
label {
  padding: 0.90rem 4rem 0.90rem calc(1.2rem * 2.25);
  display: inline-block;
  font-size: 17px;
  width: 100%;
  user-select: none;
  border-bottom: 2px solid #ededed;
  cursor: pointer;
  text-align: right;
}
label:hover {
  border-bottom-color: #152c4f;
}

.form svg {
    width: 17px;
    margin-top: 3px;
    margin-right: 147px;
}
input:not(:placeholder-shown) ~ .reset {
    opacity: 1;
    visibility: visible;
    display: contents;
}
    </style>
@endsection
@section('content')
    <div class="main-panel" style="background: #f8f9fb;">
        {{-- <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
            <li class="li"><a href="#"> الصفحة الرئيسية</a></li>
            @if($exam->type=="2")
            <li class="li"><a href="
           {{ route('dashboard.StudentsRoomLesson_quize',[$room_id,$teacher_id,$lesson_id]) }}"
                >
          عودة </a>
            </li>
            @else
            <li class="li">
              <a href="
            {{ route('dashboard.StudentsRoomLesson_exam',[$room_id,$teacher_id->id,$lesson_id]) }}"
              >
          عودة </a>
            </li>
            @endif

            <li class="li"><a href="#">بنك الاسئلة</a></li>
        </ul> --}}

        <div class="content-wrapper pb-0">

            <!-- start add question form -->
            <div class="container2" style="padding-bottom: 150px;">
                <div class="heading">جميع الاسئلة</div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <form class="form" id="new" onsubmit="event.preventDefault();" role="search">
                                <button>
                                    <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                                        <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                                <input id="search"  class="input" placeholder="ابحث" required="" type="search">
                                <button class="reset" type="reset">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                            {{-- <div class="form">
                                <button id="search1">
                                    <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        role="img" aria-labelledby="search">
                                        <path
                                            d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                                            stroke="currentColor" stroke-width="1.333" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                                <input class="input" name="search"   id="search" placeholder="ابحث عن السؤال" type="search">
                                <input hidden id="exam" name="exam" value="{{ $exam->id }}">
                                <button class="reset" type="reset">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                                        </path>
                                    </svg>
                                </button>
                            </div> --}}

                        </div>
                        <div class="col-md-4"></div>

                        <div class="col-md-4" style="padding-top: 24px;">


                            <p style="padding-left: 9px;">{{ $exam->mark }} / <span id="mark22"></span></p>
                        </div>


                    </div>
                </div>

                <form action="{{ route('coordinator_exams_myquestions1') }}" class="limiter" method="post" autocomplete="off">
                    @csrf
                    @if (session()->has('success'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: "تمت اضافة الاسئلة بنجاح ",
                                    type: "success"
                                })
                            }
                        </script>
                    @endif
                    @if (session()->has('error'))
                        <script>
                            window.onload = function() {
                                notif({
                                    msg: "   لم يتم اضافة اي سؤال ",
                                    type: "error"
                                })
                            }
                        </script>
                    @endif

                    <div style="display: none">
                        @foreach ($exams as $item )
                        @if($item->id==$exam->id)
                        <input type="checkbox" name="room_id[]" class="s11"  id="roo{{ $item->id }}"  value="{{ $item->id }}" checked>
                        <label for="roo{{ $item->id }}">{{ $item->room->name }}</label>

                        @else
                        <input type="checkbox" name="room_id[]" class="s11"   id="roo{{ $item->id }}"  value="{{ $item->id }}" >
                        <label for="roo{{ $item->id }}">{{ $item->room->name }}</label>
                        @endif
                        @endforeach
                    </div>


                    <input type="hidden" name= "selected_ques2" data-selected_ques="{{ $exam->selected_ques }}" id="selected_questions">
                    <input type="hidden" value="{{ $exam->id }}"  id="exam" name="exam_id">
                    <input type="hidden" value="{{ $exam->mark }}"  id="success_mark" name="success_mark">
                    <div class="r"></div>

                    <div class="container">
                     

                          <ul class="ul lecq ">
                             @foreach (  $questions as  $item )
                            @if(json_decode($exam->selected_ques))
                            @foreach( json_decode($exam->selected_ques)  as $item1 )
                            @if($item1 == $item->id)
                            @php
                                $i23=$item->id
                                @endphp
                                <input type="text" hidden  value="{{ $item->id }}"  class="y s123" id="cb{{ $item->id  }}" >

                            @endif
                            @endforeach
                              <li>
                                <input type="checkbox" value="{{ $item->id }}"    data-id="{{ $item->id }}" data-mark="{{ $item->mark }}"  class="x s123" id="cb{{ $item->id  }}"  name="selected_ques[]" >
                                <label for="cb{{ $item->id  }}">{{ $item->question_form }} ({{ $item->mark }}) </label>
                                </li>
                            <!--<label class="todo"  for="cb{{ $item->id }}">
                                <input value="{{ $item->id }}"
                                data-id="{{ $item->id }}" class="x todo__state"
                                data-mark="{{ $item->mark }}" id="cb{{ $item->id }}"
                                name="selected_ques[]"  type="checkbox" />
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 25" class="todo__icon">
                                <use xlink:href="#todo__line" class="todo__line"></use>
                                <use xlink:href="#todo__box" class="todo__box"></use>
                                <use xlink:href="#todo__check" class="todo__check"></use>
                                <use xlink:href="#todo__circle" class="todo__circle"></use>
                                </svg>
                                <div class="todo__text">{{ $item->question_form }} ({{ $item->mark }})</div>
                            </label>-->
                            @else
                            <!--<label class="todo"  for="cb{{ $item->id  }}">
                                <input  value="{{ $item->id }}"  data-id="{{ $item->id }}" class="todo__state x  s123" data-mark="{{ $item->mark }}" id="cb{{ $item->id  }}"  name="selected_ques[]"
                                type="checkbox" />
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 25" class="todo__icon">
                                <use xlink:href="#todo__line" class="todo__line"></use>
                                <use xlink:href="#todo__box" class="todo__box"></use>
                                <use xlink:href="#todo__check" class="todo__check"></use>
                                <use xlink:href="#todo__circle" class="todo__circle"></use>
                                </svg>
                                <div class="todo__text">{{ $item->question_form }} ({{ $item->mark }})</div>
                            </label>-->
                              <li>
                                <input type="checkbox" value="{{ $item->id }}"  data-id="{{ $item->id }}" class="x  s123" data-mark="{{ $item->mark }}" id="cb{{ $item->id  }}"  name="selected_ques[]" >
                                <label for="cb{{ $item->id  }}">{{ $item->question_form }} ({{ $item->mark }}) </label>
                                </li>

                            @endif
                            @endforeach


                        </ul>



                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                          <button class="my-button" type="submit">حفظ</button>
                        </div>
                      </div>
                </form>

            </div>
            <!-- end add question form -->

        </div><!--end content-wrapper pb-0-->
    </div><!--end main panels-->
@endsection
@section('js')
<script>
    let selected_ques ;
            let exam_id = $('#exam').val() ;
            let exam_questions = {};
            selected_ques = $('#selected_questions').data('selected_ques');
            if(selected_ques ==""){
                selected_ques = {}
            }
            selected_ques = selected_ques !== null ? selected_ques : {};
            console.log(typeof(selected_ques));
            console.log(selected_ques);

            exam_questions[exam_id] = selected_ques;
            localStorage.setItem('exam_questions', JSON.stringify(exam_questions));
                $('.r').empty();
                    // exam_questions=JSON.stringify(exam_questions)
       $.each(exam_questions, function (key, value) {
                       $.each(value, function (key, value1) {

                        $('.r').append(` <input  hidden name="selected_ques1[]" value="${value1}">`)
                  })
                   })
            $(document).on('click','.x',function(){
                  var x1=0;
            var x3=localStorage.getItem('x');
             if ($(this).is(':checked')) {

               $(this).addClass("x4"); }
               else{
                    $(this).removeClass("x4");
                   v= $(this).data('mark');
                   x3=parseFloat(x3)-parseFloat(v);
                    localStorage.setItem('x', x3);
               }

                if ($(this).is(':checked')) {

                x1= parseFloat(x1)+parseFloat($(this).data('mark') );


            }
            x1= parseFloat(x1)+parseFloat(x3 );
       mark= $('#success_mark').val();
       if(x1>mark){
           alert('لايمكن اضافة السؤال لانه تجاوز علامة الامتحان')
            $( this ).prop('checked',false);
            $(this).removeClass("x4");
            console.log(selected_ques);
            // doesExist(selected_ques,$(this).val(),true);
    console.log(selected_ques);


    console.log($(this).val());
    return false ;


       }
       else{
               x1 = Number(x1);
     x1 = x1.toFixed(3);
          $('#mark22').text(x1);
           localStorage.setItem('x', x1);
       }
                // if(localStorage.getItem('exam_questions') === null) {
                //     selected_ques = [];
                // } else {
                //     selected_ques = JSON.parse(localStorage.getItem('selected_ques'));
                // }

                    exam_questions = JSON.parse(localStorage.getItem('exam_questions'));
                selected_ques = exam_questions[exam_id];
                console.log(selected_ques);

                if($(this)[0].checked && !doesExist(selected_ques,$(this).val())){
    console.log(Object.keys(selected_ques).length);
                        selected_ques[Object.keys(selected_ques).length+1] = $(this).val()
                    exam_questions[exam_id] = selected_ques;
                    localStorage.setItem('exam_questions', JSON.stringify(exam_questions));
                    console.log(selected_ques);
                       $('.r').empty();
                        // exam_questions=JSON.stringify(exam_questions)

                       $.each(exam_questions, function (key, value) {
                       $.each(value, function (key, value1) {

                        $('.r').append(` <input  hidden name="selected_ques1[]" value="${value1}">`)
                  })
                   })
                    // if (selected_ques[$(this).val()]){
                    //     alert(5)length
                    // }
                    // localStorage.setItem('selected_ques', JSON.stringify(selected_ques));
                } else if (!$(this)[0].checked ) {
                    doesExist(selected_ques,$(this).val(),true);
                    exam_questions[exam_id] = selected_ques;
                    localStorage.setItem('exam_questions', JSON.stringify(exam_questions));
                    console.log(selected_ques);
                       $('.r').empty();
                        // exam_questions=JSON.stringify(exam_questions)

                       $.each(exam_questions, function (key, value) {
                       $.each(value, function (key, value1) {

                        $('.r').append(` <input  hidden name="selected_ques1[]" value="${value1}">`)
                  })
                   })
                }





            });

       $.each($('.y'), function (key, value) {
        var c= $(this).val();
        $.each($('.x'), function (key, value) {
        if($(this).data('id') ==c){

            $( this ).attr( 'checked', true )
            $( this ).val($(this).data('id'));
        }})
       })
         var  x=0;
       $.each($('.x'), function (key, value) {
                if ($(this).is(':checked')) {

                x= parseFloat(x)+parseFloat($(this).data('mark') );

                }

            })
                x = Number(x)
     x = x.toFixed(3);
             localStorage.setItem('x', x);
       $('#mark22').text(x);
    $(document).on('keyup', '#search', function () {
        var lect=$('#search').val();
                var exam=$('#exam').val();
                var data={
                        "search":lect,
                        "exam":exam,

                    }
                var url = "{{ URL::to('SMARMANger/dashboard/coordinator/search_exam') }}";
            $.ajax({
                url: url,
                data : data,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
                    if(data==1){
                        $('.lecq').append(`  <li> not found</li>`)
                    }
             console.log(data);

             $('.lecq').empty();
             let checked ;

                    $.each(data, function (key, value) {
                        checked = doesExist(selected_ques,value.id) === true ? 'checked' : '' ;
                        $('.lecq').append(`  <li>
                        <input type="checkbox"  class="x s123" data-mark="${ value.mark }"  ${checked} value="${ value.id }" id="cb${ value.id }" name="selected_ques[]" >
                        <label for="cb${ value.id }">${ value.question_form } (${ value.mark }) </label>
                      </li>`)



                    });




                },
                error: function (xhr) {

                }

            })

    })
    const doesExist = (selected_ques, ques_id,to_delete = false) => {
                for (let key in selected_ques) {
                    if (selected_ques[key] == ques_id) {
                        // if(to_delete) delete selected_ques[key];
                        if(to_delete)  {
                            delete selected_ques[key];

                        }
                    return true;
                    }
                }
                return false
                }

    $(document).on('change', '.choice', function () {

                var lect=$(this).val();
                var exam=$('#exam').val();

                $('.lecq').empty();
            var url = "{{ URL::to('SMARMANger/dashboard/teacher/lecquestion') }}/" + lect +"/"+exam;
            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
             console.log(data);

             $('.lecq').empty();
                    let checked ;
                    $.each(data, function (key, value) {
                        checked = doesExist(selected_ques,value.id) === true ? 'checked' : '' ;
                        $('.lecq').append(`<li>
                        <input type="checkbox" class="x s123" data-mark="${ value.mark }"   ${checked} value="${ value.id }" id="cb${ value.id }" name="selected_ques[]" >
                        <label for="cb${ value.id }">${ value.question_form } (${ value.mark }) </label>
                      </li>`)



                    });


                },
                error: function (xhr) {

                }

            });




        })

    </script>
@endsection
