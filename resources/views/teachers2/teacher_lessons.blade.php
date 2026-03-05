@extends('teachers2.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<!--link for select-->
<link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/select2/select2.min.css')}}" />
<link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}" />
<style>
 @media(min-width:1200px) and (max-width:2000px){
          .lessondate{
            text-align: right;
            left: 18px;
            top: -15px;
          }
        }
        @media(min-width:200px) and (max-width:1200px){
          .lessondate{
            text-align: right;
            left: 18px;
            top: -15px;
          }
          form div button {
         margin-left: 0px !important;
}
        }
        
        .col-md-4 {
          margin-bottom: 20px;
        }
        .form{
          --width-of-input: 100%;
        }
        @media(min-width:1200px) and (max-width:1900px){
          .textcol{
            left: 15px;
          }
        }
        @media (min-width: 1011px) and (max-width: 1300px){
          .newselect {
    position: relative;
    left: 0;
}
        }
        .form {
       --width-of-input: 100%;
      }
      .input {
    font-size: 0.9rem;
    background-color: transparent;
    width: 100%;
    height: 100%;
    padding-inline: 0.5em;
    padding-block: 0.7em;
    border: none;
}
      .form {
    --timing: 0.3s !important;
    --width-of-input: 100% !important;
    --height-of-input: 40px !important;
    --border-height: 2px !important;
    --input-bg: #a5c9ff !important;
    --border-color: #4382E0 !important;
    --border-radius: 30px !important;
    --after-border-radius: 1px !important;
    position: relative !important;
    width: var(--width-of-input) !important;
    height: var(--height-of-input) !important;
    display: flex !important;
    align-items: center !important;
    padding-inline: 0.8em !important;
    border-radius: var(--border-radius) !important;
    transition: border-radius 0.5s ease !important;
    background: var(--input-bg,#fff) !important;
    flex-direction: initial !important;
    padding: 0 !important;
    box-shadow: none !important;
}
.form button {
    border: none;
    background: none;
    color: #4382E0;
}

.box {
 /* width:100%;*/
  height: 100%;
  max-height: 600px;
  min-height: 450px;
  background: transparent !important;
  border-radius: 20px;
  position: absolute;
  left: 59%;
  top: 28%;
  /*transform: translate(-50%, -50%);
  padding: 30px 50px;*/
}
@media(min-width:100px) and (max-width:594px){
    .container-2{
        position: relative;
        z-index: 9;
    }
    .box {
        left: 0% !important;
        top: 100% !important;
    }
}

@media(min-width:595px) and (max-width:695px)
{
     .container-2{
        position: relative;
        z-index: 9;
    }
    .box {
        left: 0% !important;
        top: 100% !important;
    }
}

@media(min-width:696px) and (max-width:700px){
     .container-2{
        position: relative;
        z-index: 9;
    }
    .box {
        left: 50% !important;
        top: 28% !important;
    }
}

.box .box__ghost {
  padding: 15px 25px 25px;
  position: absolute;
  left: 50%;
  top: 30%;
  transform: translate(-50%, -0%);
}
.box .box__ghost .symbol:nth-child(1) {
  opacity: 0.2;
  animation: shine 4s ease-in-out 3s infinite;
}
.box .box__ghost .symbol:nth-child(1):before, .box .box__ghost .symbol:nth-child(1):after {
  content: '';
  width: 12px;
  height: 4px;
  background: #332F63;
  position: absolute;
  border-radius: 5px;
  bottom: 65px;
  left: 0;
}
.box .box__ghost .symbol:nth-child(1):before {
  transform: rotate(45deg);
}
.box .box__ghost .symbol:nth-child(1):after {
  transform: rotate(-45deg);
}
.box .box__ghost .symbol:nth-child(2) {
  position: absolute;
  left: -5px;
  top: 30px;
  height: 18px;
  width: 18px;
  border: 4px solid;
  border-radius: 50%;
  border-color: #332F63;
  opacity: 0.2;
  animation: shine 4s ease-in-out 1.3s infinite;
}
.box .box__ghost .symbol:nth-child(3) {
  opacity: 0.2;
  animation: shine 3s ease-in-out 0.5s infinite;
}
.box .box__ghost .symbol:nth-child(3):before, .box .box__ghost .symbol:nth-child(3):after {
  content: '';
  width: 12px;
  height: 4px;
  background: #332F63;
  position: absolute;
  border-radius: 5px;
  top: 5px;
  left: 40px;
}
.box .box__ghost .symbol:nth-child(3):before {
  transform: rotate(90deg);
}
.box .box__ghost .symbol:nth-child(3):after {
  transform: rotate(180deg);
}
.box .box__ghost .symbol:nth-child(4) {
  opacity: 0.2;
  animation: shine 6s ease-in-out 1.6s infinite;
}
.box .box__ghost .symbol:nth-child(4):before, .box .box__ghost .symbol:nth-child(4):after {
  content: '';
  width: 15px;
  height: 4px;
  background: #332F63;
  position: absolute;
  border-radius: 5px;
  top: 10px;
  right: 30px;
}
.box .box__ghost .symbol:nth-child(4):before {
  transform: rotate(45deg);
}
.box .box__ghost .symbol:nth-child(4):after {
  transform: rotate(-45deg);
}
.box .box__ghost .symbol:nth-child(5) {
  position: absolute;
  right: 5px;
  top: 40px;
  height: 12px;
  width: 12px;
  border: 3px solid;
  border-radius: 50%;
  border-color: #332F63;
  opacity: 0.2;
  animation: shine 1.7s ease-in-out 7s infinite;
}
.box .box__ghost .symbol:nth-child(6) {
  opacity: 0.2;
  animation: shine 2s ease-in-out 6s infinite;
}
.box .box__ghost .symbol:nth-child(6):before, .box .box__ghost .symbol:nth-child(6):after {
  content: '';
  width: 15px;
  height: 4px;
  background: #332F63;
  position: absolute;
  border-radius: 5px;
  bottom: 65px;
  right: -5px;
}
.box .box__ghost .symbol:nth-child(6):before {
  transform: rotate(90deg);
}
.box .box__ghost .symbol:nth-child(6):after {
  transform: rotate(180deg);
}
.box .box__ghost .box__ghost-container {
  background: #332F63;
  width: 150px;
  height: 150px;
  border-radius: 100px 100px 0 0;
  position: relative;
  margin: 0 auto;
  animation: upndown 3s ease-in-out infinite;
}
.box .box__ghost .box__ghost-container .box__ghost-eyes {
  position: absolute;
  left: 50%;
  top: 45%;
  height: 12px;
  width: 70px;
}
.box .box__ghost .box__ghost-container .box__ghost-eyes .box__eye-left {
  width: 12px;
  height: 12px;
  background: #ffff;
  border-radius: 50%;
  margin: 0 10px;
  position: absolute;
  left: 0;
}
.box .box__ghost .box__ghost-container .box__ghost-eyes .box__eye-right {
  width: 12px;
  height: 12px;
  background: #ffff;
  border-radius: 50%;
  margin: 0 10px;
  position: absolute;
  right: 0;
}
.box .box__ghost .box__ghost-container .box__ghost-bottom {
  display: flex;
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
}
.box .box__ghost .box__ghost-container .box__ghost-bottom div {
  flex-grow: 1;
  position: relative;
  top: -10px;
  height: 20px;
  border-radius: 100%;
  background-color: #332F63;
}
.box .box__ghost .box__ghost-container .box__ghost-bottom div:nth-child(2n) {
  top: -12px;
  margin: 0 0px;
  border-top: 15px solid #332F63;
  background: transparent;
}
.box .box__ghost .box__ghost-shadow {
  height: 20px;
  box-shadow: 0 50px 15px 5px #3B3769;
  border-radius: 50%;
  margin: 0 auto;
  animation: smallnbig 3s ease-in-out infinite;
}
.box .box__description {
  position: absolute;
  bottom: 150px;
  left: 50%;
  transform: translateX(-50%);
}
.box .box__description .box__description-container {
  color: #fff;
  text-align: center;
  width: 500px;
  font-size: 16px;
  margin: 0 auto;
}
.box .box__description .box__description-container .box__description-title {
  font-size: 24px;
  letter-spacing: 0.5px;
}
.box .box__description .box__description-container .box__description-text {
  color: #8C8AA7;
  line-height: 20px;
  margin-top: 20px;
  font-size: 40px
}
.box .box__description .box__button {
  display: block;
  position: relative;
  background: #FF5E65;
  border: 1px solid transparent;
  border-radius: 50px;
  height: 50px;
  text-align: center;
  text-decoration: none;
  color: #fff;
  line-height: 50px;
  font-size: 18px;
  padding: 0 70px;
  white-space: nowrap;
  margin-top: 25px;
  transition: background 0.5s ease;
  overflow: hidden;
  -webkit-mask-image: -webkit-radial-gradient(white, black);
}
.box .box__description .box__button:before {
  content: '';
  position: absolute;
  width: 20px;
  height: 100px;
  background: #fff;
  bottom: -25px;
  left: 0;
  border: 2px solid #fff;
  transform: translateX(-50px) rotate(45deg);
  transition: transform 0.5s ease;
}
.box .box__description .box__button:hover {
  background: transparent;
  border-color: #fff;
}
.box .box__description .box__button:hover:before {
  transform: translateX(250px) rotate(45deg);
}
@keyframes upndown {
  0% {
    transform: translateY(5px);
  }
  50% {
    transform: translateY(15px);
  }
  100% {
    transform: translateY(5px);
  }
}
@keyframes smallnbig {
  0% {
    width: 90px;
  }
  50% {
    width: 100px;
  }
  100% {
    width: 90px;
  }
}
@keyframes shine {
  0% {
    opacity: 0.2;
  }
  25% {
    opacity: 0.1;
  }
  50% {
    opacity: 0.2;
  }
  100% {
    opacity: 0.2;
  }
}
.sidebar {
    min-height: calc(100vh - -190px) !important;}

    ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color: #fff;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color: #fff;
    opacity: 1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
    color: #fff;
    opacity: 1;
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
    color: #fff;
}

::placeholder { /* Most modern browsers support this now. */
    color: #fff;
}
input[type="date"], input[type="time"], input[type="datetime-local"], input[type="month"]{
    -webkit-appearance: listbox;
    color: #fff;
}
input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(1);
}
.col-md-12 input[type="date"], input[type="time"], input[type="datetime-local"], input[type="month"]{
    -webkit-appearance: listbox;
    color: #161515 !important;
}
.col-md-12 input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(0);
}

</style>
@endsection

@section('content')


<div class="main-panel" style="background: #f8f9fb;">
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
      <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
      <li class="li"><a href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room->id ,'teacher_id'=>$teacher->id])}}">{{ $room->name }}</a></li>
      <li class="li"><a href="#">{{ $lesson->name }}</a></li>
   </ul>


    <div class="content-wrapper pb-0">
      <div class="container container-2">
        <div class="row">

          <div class="col-sm" style="padding-bottom: 20px;">
            <!--serach input-->
            <form class="form form_search" >
              <button>
                  <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                      <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
              </button>
              <input class="input input_search" placeholder="ابحث عن اسم الدرس" type="search" name="query">
              <button class="reset" type="reset">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
              </button>
          </form>

            <!--end serach-->
          </div>

        {{--  <input  hidden  value="{{ $class->id }}" class="exam12">--}}
          <div class="col-sm">
            <div class="form-group newselect">
              <select class="js-example-basic-single2 choice" id="select2" style="width: 100%;direction: rtl;">
                  <option value="0" >جميع الدروس </option>
                  @foreach (  $lectures as $item  )
                  @if($item->active==1)
                  <option value="{{ $item->id }}" ><del>{{ $item->name }}</del>  </option>
                  @else
                  <option value="{{ $item->id }}" > {{ $item->name }}  </option>
                  @endif
                  @endforeach
              </select>

            </div>
          </div>
          <div class="col-sm textcol" >
            <form class="form form_date">
                <button>
                    <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                        <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
                <input class="input data_input" placeholder="ابحث عن تاريخ الدرس" type="date" name="query2">
                <button class="reset_date2" hidden type="reset">
                <button class="reset reset_date" type="reset">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

          </form>
          </div>
        </div>

      </div>
      <div class="container container-2" style="padding-top: 20px;padding-bottom: 20px;">
         <div class="row" style="justify-content: center;">
           <div class="col-md-2" style="display: contents;">

              <!--add lesson-->
               <a href="#"  data-toggle="modal" data-target="#demoModal4"class="Btn" style="color: #fff;">اضافة درس
              <i class="mdi mdi-plus" style="padding-left: 10px;font-size: 15px;"></i>
              </a>



             <!--end add lesson-->
           </div>
         </div>
      </div>
     <!--start add lesson modal-->
<div class="modal fade auto-off"id="demoModal4" tabindex="-1" role="dialog" aria-labelledby="demoModal" aria-hidden="true">
<div class="modal-dialog animated zoomInLeft modal-dialog-centered" role="document">
    <div class="modal-content" style="padding-top: 50px !important;">
        <div class="container-fluid">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: white !important;">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4  style="color: #05579e;text-align: center; ">اضافة درس</h4>

              <form action="{{ route('dashboard.lessons.lecture.store') }}" method="post" id="confirm4" style="text-align: right;direction: rtl;">
                  @csrf
            <div class="container" style="padding-top: 20px;">
               <div class="row">
                <div class="col-md-12" style="display: grid;">
                  <label for="default" class="">اسم الدرس</label>
                  <!-- This is a normal file input -->
                  <input required  type="text" name="name" id="name" placeholder="ادخل اسم الدرس " class="border p-2"  style="width:300px">
              </div><!--end col-->
              <div class="col-md-12" style="display: grid;">
                <label for="default" class="">تاريخ ظهور الدرس</label>
                <!-- This is a normal file input -->
                <input required  name="lecture_time" id="lecture_time"  placeholder="ادخل بداية الوقت "
                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter start quize time'"
                class="border p-2" type="date" style="width:300px">
            </div><!--end col-->

               </div>
               <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
               <input type="hidden" name="class_id" value="{{ $class->id }}">
               <input type="hidden" name="room_id" value="{{ $room->id }}">
               <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

               <div class="row" style="text-align: center;">
                <div class="col-md-12" style="padding-bottom: 10px;">
                  <button id="saveButton" class="button" style="width:150px">حفظ</button>
                </div>
              </div>

          </div>
        </form>
      </div>
    </div>
</div>
</div>
<!--end end add lesson modal-->
<!-- start  model-->

<!--end modal popup-->
      <!--end modal popup-->

      <!--lessons-->
       <div class="container" style="padding-bottom: 100px;">

        <input hidden value="{{ $lesson_id }}" id="lesson_id">
        <input hidden id="room_id" value="{{ $room_id }}">
         <div class="row   newarticls">
    @if($lectures->isNotEmpty())
       @foreach ($lectures as $item )

           <div class="col-md-4 div_lesson {{ "ll_".$item->id }}">
            <section class="articles">
              <!--start card-->
              <article>
                  <div class="article-wrapper">
                    <figure>
                      <img src="{{asset('teachers_2/icons/sub1.jpg')}}" alt="" />
                    </figure>
                    <div class="article-body">
                       <div class="container">
                        <div class="row">
                           <div class="col-md-12 lessondate">
                            <span style="font-size: 15px;;">
                              <i class="mdi mdi-calendar" style="font-size: 14px;"></i>&nbsp;{{$item->lecture_time}}</span>
                           </div>
                        </div>
                         <div class="row" style="justify-content: space-between;">
                           <h2>{{ $item->name }}</h2>
                            <div style="position: relative;
                            top: -5px;">
                            <!--delete lesson-->
                            <a href="" id="delete_lesson" style="position: relative;" style="position: relative;"  data-lec_id="{{ $item->id }}"data-toggle="modal" data-target="#delete_question" >
                              <i class="fa fa-trash" style="font-size: 22px;color: #14315C ;"></i></a>
                              <!--end delete-->
                              &nbsp;
                              <!--edit lesson-->
                              <a    style="position: relative;"   href=".editEmployeeModal" class="edit11"  data-toggle="modal" data-target="#demoModal"
                             data-id="{{ $item->id }}"
                             data-name="{{ $item->name }}"
                             data-time="{{ $item->lecture_time }}" >
                              <i class="mdi mdi-pencil" style="font-size: 22px;color: #14315C ;"></i></a>
                              <!--end edit-->
                            </div>
                         </div>
                       </div>
                       <div class="row" style="justify-content: space-around;">
                        <button class="button">
                          <a href="{{ route('dashboard.student.lessons.book_details',[$lesson->id,$teacher->id,$room->id ,$item->id]) }}" style="color: #fff;" > مشاهدة المحتوى</a>
                        </button>
                        <button class="button">
                          <a href="{{ route('dashboard.teacher_rooms2',[$class->id,$teacher->id,$room->id ,$item->id]) }}" style="color: #fff;"> اضافة محتوى </a>
                        </button>
                       </div>
                    </div>
                  </div>
                </article>
              <!--end card-->
            </section>
           </div>
           @endforeach
           @else
    <div>
       
        <!--style for no lectures found-->
        <div class="box">
            <div class="box__ghost">
              <div class="symbol"></div>
              <div class="symbol"></div>
              <div class="symbol"></div>
              <div class="symbol"></div>
              <div class="symbol"></div>
              <div class="symbol"></div>

              <div class="box__ghost-container">
                <div class="box__ghost-eyes">
                  <div class="box__eye-left"></div>
                  <div class="box__eye-right"></div>
                </div>
                <div class="box__ghost-bottom">
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
              </div>
              <div class="box__ghost-shadow"></div>
            </div>

            <div class="box__description">
              <div class="box__description-container">
                <div class="box__description-text">لايوجد دروس لهذه المادة</div>
              </div>
            </div>

          </div>
        <!--end style-->
    </div>
@endif

<!--edit name lesson-->
<div class="modal fade auto-off editEmployeeModal"  id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModal" aria-hidden="true">
    <div class="modal-dialog animated zoomInLeft modal-dialog-centered" role="document">
        <div class="modal-content" style="padding-top: 50px !important;">
            <div class="container-fluid">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: white !important;">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4  style="color: #05579e;text-align: center; ">تعديل الدرس</h4>

                 {{-- <form action="" method="post" id="confirm4" style="text-align: right;direction: rtl;">
                      @csrf--}}
                      <form action="{{ route('dashboard.lessons.lecture.update') }}" method="post" id="confirm4" style="text-align: right;direction: rtl;">
                        @csrf
                      <input type="text" hidden name="id" id="lec_id">
                <div class="container" style="padding-top: 20px;">
                   <div class="row">
                    <div class="col-md-12" style="display: grid;">
                      <label for="default" class="">اسم الدرس</label>
                      <input type="text" class="border p-2" name="name" id="name2" placeholder="ادخل اسم الدرس " style="width:300px">


                  </div><!--end col-->
                  <div class="col-md-12" style="display: grid;">
                    <label for="default" class="">تاريخ ظهور الدرس</label>
                    <!-- This is a normal file input -->
                    <input name="lecture_time" id="date" placeholder="ادخل بداية الوقت "
                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter start quize time'"
                    class="border p-2" type="date" style="width:300px">
                </div><!--end col-->

                   </div>
                   <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                   <input type="hidden" name="class_id" value="{{ $class->id }}">
                   <input type="hidden" name="room_id" value="{{ $room->id }}">
                   <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

                   <div class="row" style="text-align: center;">
                    <div class="col-md-12" style="padding-bottom: 10px;">
                      <button class="button" style="width:150px">حفظ</button>
                    </div>
                  </div>

              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
   <!-- end model-->
<!--end edit modal-->




         </div>

       </div>
      <!--end lessons-->

  <!-- main-panel ends -->
</div><!--end container of cards-->
<!-- page-body-wrapper ends -->
</div>
</div><!--end container-scroller-->


<div class="modal fade" id="delete_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">حذف درس</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<form action="{{ route('dashboard.lec.delete') }}" method="post">
@csrf
</div>
<div class="modal-body" style="text-align:center">
هل انت متاكد من عملية الحذف ؟
<input type="hidden" name="question_id" id="question_id" value="">
</div>
<div class="modal-footer" style="justify-content: flex-end;">
<button type="submit" class="button">تاكيد</button>
<button type="button" class="button" data-dismiss="modal">الغاء</button>
</div>
</form>
</div>
</div>
</div>

     <!--- end add lesson -->


@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
  $("#saveButton").click(function() {
    // Check if the input fields are empty
    if ($("#name").val() !== '' && $("#lecture_time").val() !== '') {
      $(this).hide(); // Hide the button when clicked
    } else {
      alert("Please fill in all the fields"); // Show an alert if any of the fields are empty
    }
  });
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
{{--<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
<script>
var pageX = $(document).width();
var pageY = $(document).height();
var mouseY=0;
var mouseX=0;

$(document).mousemove(function( event ) {
  //verticalAxis
  mouseY = event.pageY;
  yAxis = (pageY/2-mouseY)/pageY*300;
  //horizontalAxis
  mouseX = event.pageX / -pageX;
  xAxis = -mouseX * 100 - 100;

  $('.box__ghost-eyes').css({ 'transform': 'translate('+ xAxis +'%,-'+ yAxis +'%)' });

  //console.log('X: ' + xAxis);

});
</script>
<script>
    $(document).ready(function () {
        $('#search_lecture').on('keyup', function(){
            var value = $(this).val();
            $.ajax({
                type: "get",
                url: "/search",
                data: {'search_lecture':value},
                success: function (data) {
                    $('.mycard').html(data);
                }
            });
        });
    });
</script>--}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>


    $(document).ready(function(){
        $('.js-example-basic-single2').select2();
    })

    $('.form_date').submit(function(event) {
        event.preventDefault();
    });

    $('.form_search').submit(function(event) {
        event.preventDefault();
        $('.reset_date2').click();
        search = $('.input_search').val();

        var url = "{{ route('search_lecture') }}";
                $.ajax({
                    url: url,
                    data: {
                        'lesson_id' : "{{ $lesson->id }}",
                        'teacher_id' : "{{ $teacher->id }}",
                        'room_id' : "{{ $room_id }}",
                        'search' : search,
                    },
                    type: "get",
                    contentType: 'application/json',
                    success: function(data) {
                        $('.newarticls').empty();
                        $('.js-example-basic-single2').select2('destroy');
                        $('.js-example-basic-single2').empty();
                        $('.js-example-basic-single2').append(
                                `<option value="0" >جميع الدروس </option>`
                            );
                            lesson = [];
                        $.each(data, function (indexInArray, value) {
                            $('.js-example-basic-single2').append(
                                `<option value="${ value.id }" > ${ value.name }  </option>`
                            );

                            lesson.push(value.id);

                            $('.newarticls').append(`
                            <div class="col-md-4 div_lesson ${"ll_"+value.id}">
                                    <section class="articles">
                                    <!--start card-->
                                    <article>
                                        <div class="article-wrapper">
                                            <figure>
                                            <img src="{{asset('teachers_2/icons/sub1.jpg')}}" alt="" />
                                            </figure>
                                            <div class="article-body">
                                            <div class="container">
                                                <div class="row">
                                                <div class="col-md-12 lessondate">
                                                    <span style="font-size: 15px;;">
                                                    <i class="mdi mdi-calendar" style="font-size: 14px;"></i>&nbsp;${value.lecture_time}</span>
                                                </div>
                                                </div>
                                                <div class="row" style="justify-content: space-between;">
                                                <h2 >${ value.name }</h2>
                                                    <div style="position: relative;
                                                    top: -5px;">
                                                    <!--delete lesson-->
                                                    <a  style="width:20px" id="delete_lesson" data-lec_id="${ value.id }"data-toggle="modal" data-target="#delete_question" href="" >
                                                    <i class="fa fa-trash" style="font-size: 22px;color: #14315C ;"></i></a>
                                                    <!--end delete-->
                                                    &nbsp;
                                                    <!--edit lesson-->
                                                    <a  style="position: relative;"  href=".editEmployeeModal" class="edit11"  data-toggle="modal" data-target="#demoModal"
                                                    data-id="${ value.id }"
                                                    data-name="${ value.name }"
                                                    data-time="${ value.lecture_time }" >
                                                    <i class="mdi mdi-pencil" style="font-size: 22px;color: #14315C ;"></i></a>
                                                    <!--end edit-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="justify-content: space-around;">
                                                <button class="button">
                                                <a href="${ "{{ route('dashboard.student.lessons.book_details',[$lesson->id,$teacher->id,$room->id ,'id_lesson']) }}".replace('id_lesson', value.id) }" style="color: #fff;" > مشاهدة المحتوى</a>
                                                </button>
                                                <button class="button">
                                                <a href="${ "{{ route('dashboard.teacher_rooms2',[$class->id,$teacher->id,$room->id ,'id_lesson']) }}".replace('id_lesson', value.id) }" style="color: #fff;"> اضافة محتوى </a>
                                                </button>
                                            </div>
                                            </div>
                                        </div>
                                        </article>
                                    <!--end card-->
                                    </section>
                                </div>
                            `);
                        });
                        $('.js-example-basic-single2').select2();
                    },
                    error: function(xhr) {
                    }

                });

    });

    lesson = "{{ $lectures->pluck('id') }}";


    $('.data_input,.reset_date').on('change click', function(event) {
        $('.input_search').val('');
        date = $('.data_input').val();
        if( $(this).hasClass('reset_date') ){
            date = '';
        }
        var url = "{{ route('search_lecturetime') }}";
                $.ajax({
                    url: url,
                    data: {
                        'lesson_id' : "{{ $lesson->id }}",
                        'teacher_id' : "{{ $teacher->id }}",
                        'room_id' : "{{ $room_id }}",
                        'date' : date,
                    },
                    type: "get",
                    contentType: 'application/json',
                    success: function(data) {
                        $('.newarticls').empty();
                        $('.js-example-basic-single2').select2('destroy');
                        $('.js-example-basic-single2').empty();
                        $('.js-example-basic-single2').append(
                                `<option value="0" >جميع الدروس </option>`
                            );
                            lesson = [];
                        $.each(data, function (indexInArray, value) {
                            $('.js-example-basic-single2').append(
                                `<option value="${ value.id }" > ${ value.name }  </option>`
                            );

                            lesson.push(value.id);

                            $('.newarticls').append(`
                            <div class="col-md-4 div_lesson ${"ll_"+value.id}">
                                    <section class="articles">
                                    <!--start card-->
                                    <article>
                                        <div class="article-wrapper">
                                            <figure>
                                            <img src="{{asset('teachers_2/icons/sub1.jpg')}}" alt="" />
                                            </figure>
                                            <div class="article-body">
                                            <div class="container">
                                                <div class="row">
                                                <div class="col-md-12 lessondate">
                                                    <span style="font-size: 15px;;">
                                                    <i class="mdi mdi-calendar" style="font-size: 14px;"></i>&nbsp;${value.lecture_time}</span>
                                                </div>
                                                </div>
                                                <div class="row" style="justify-content: space-between;">
                                                <h2 >${ value.name }</h2>
                                                    <div style="position: relative;
                                                    top: -5px;">
                                                    <!--delete lesson-->
                                                    <a  style="width:20px" id="delete_lesson" data-lec_id="${ value.id }"data-toggle="modal" data-target="#delete_question"  >
                                                    <i class="fa fa-trash" style="font-size: 22px;color: #14315C ;"></i></a>
                                                    <!--end delete-->
                                                    &nbsp;
                                                    <!--edit lesson-->
                                                    <a style="position: relative;"  href=".editEmployeeModal" class="edit11"  data-toggle="modal" data-target="#demoModal"
                                                    data-id="${ value.id }"
                                                    data-name="${ value.name }"
                                                    data-time="${ value.lecture_time }" >
                                                    <i class="mdi mdi-pencil" style="font-size: 22px;color: #14315C ;"></i></a>
                                                    <!--end edit-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="justify-content: space-around;">
                                                <button class="button">
                                                <a href="${ "{{ route('dashboard.student.lessons.book_details',[$lesson->id,$teacher->id,$room->id ,'id_lesson']) }}".replace('id_lesson', value.id) }" style="color: #fff;" > مشاهدة المحتوى</a>
                                                </button>
                                                <button class="button">
                                                <a href="${ "{{ route('dashboard.teacher_rooms2',[$class->id,$teacher->id,$room->id ,'id_lesson']) }}".replace('id_lesson', value.id) }" style="color: #fff;"> اضافة محتوى </a>
                                                </button>
                                            </div>
                                            </div>
                                        </div>
                                        </article>
                                    <!--end card-->
                                    </section>
                                </div>
                            `);
                        });
                        $('.js-example-basic-single2').select2();
                    },
                    error: function(xhr) {
                    }

                });
    });
    $(document).on('click', '.edit11', function() {
    
        var lec_id =$(this).data('id');
        var lec_name =$(this).data('name');
        var date =$(this).data('time');
        $('#lec_id').val(lec_id);
        $('#date').val(date);
        $('#name2').val(lec_name);


})

$(document).on('click', '#delete_lesson', function() {
        var lec_id =$(this).data('lec_id');
        $('#question_id').val(lec_id);

})

//   $('#delete_question').on('show.bs.modal', function(event) {
// var button = $(event.relatedTarget)
// var question_id = button.data('lec_id')
// var modal = $(this)
// modal.find('.modal-body #question_id').val(question_id);
// })



/*$(document).on('keyup','#search_lecture',function(){
    var search_lecture= $(this).val();
    if(search_lecture != ''){
        $.ajax({
            url:'/search_lecture',
            method:'GET',
            data:{search_lecture},
            datatype:'json',
            success:function(data){
                console.log(data);
            }
        })
    }
})*/

</script>
{{-- for select lessson --}}
<script>
            $(document).on('change', '.choice', function() {
                var lect = $(this).val();
                console.log(lect);
                $('.div_lesson').hide();
                if (lect == 0) {
                    $('.div_lesson').show();
                }else{
                    $(`.ll_${lect}`).show();
                }
            });


</script>

@endsection
