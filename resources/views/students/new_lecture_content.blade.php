@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<style>
.drop-container {
  background-color: #fff;
  position: relative;
  display: flex;
  gap: 10px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 10px;
  margin-top: 2.1875rem;
  border-radius: 10px;
  border: 2px dashed #a5c9ff  ;
  color: #444;
  cursor: pointer;
  transition: background .2s ease-in-out, border .2s ease-in-out;
}

.drop-container:hover {
  background: #ecdefd;
  border-color: #a5c9ff;
}

.drop-container:hover .drop-title {
  color: #222;
}

.drop-title {
  color: #444;
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  transition: color .2s ease-in-out;
  background: none !important;
}

.file-input {
  width: 350px;
  max-width: 100%;
  color: #444;
  padding: 4px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid rgba(8, 8, 8, 0.288);
}

.file-input::file-selector-button {
  margin-right: 0px;
  border: none;
  background: #152C4F ;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

.file-input::file-selector-button:hover {
  background: #a5c9ff ;
}
/*style for link audio*/
.but2 {
 color: #152C4F ;
 padding: 0.7em 1.7em;
 font-size: 15px;
 top:12px;
 font-weight: 900;
 position: relative;
 left: 10px;
 border-radius: 0.5em;
 background: #e8e8e8;
 border: 1px solid #e8e8e8;
 transition: all .3s;
 box-shadow: 6px 6px 12px #c5c5c5,
             -6px -6px 12px #ffffff;
}

.but2:active {
 color: #666;
 box-shadow: inset 4px 4px 12px #c5c5c5,
             inset -4px -4px 12px #ffffff;
}
.form_main {
    height: 120%;
}

@media(min-wdith:200px) and (max-width:1000px){
    .form_main{
        padding-bottom: 25px !important;
    }
}

@media(min-width:200px) and (max-width:1000px){
    .audio{
    width: 100% !important;
}
.but2{
    left:60px !important;
}
.box p{
    padding-top: 46px !important;
}
.box {
    padding-bottom: 21px;
}
}
.audio{
    width: 123%;margin: 0 auto;justify-content: center;
}
.col_bottom{
    margin-bottom: 30px
}
/*end style for link audio*/
/*end style*/


/*mark subject*/
.toggle {
  display: inline-block;
}

.toggle {
  position: relative;
  height: 100px;
  width: 100px;
}

.toggle:before {
  box-shadow: 0;
  border-radius: 84.5px;
  background: #fff;
  position: absolute;
  margin-left: -36px;
  margin-top: -36px;
  opacity: 0.2;
  height: 72px;
  width: 72px;
  left: 50%;
  top: 50%;
}

.toggle .button {
  transition: all 300ms cubic-bezier(0.23, 1, 0.32, 1);
  box-shadow: 0 15px 25px -4px rgba(0, 0, 0, 0.5), inset 0 -3px 4px -1px rgba(0, 0, 0, 0.2), 0 -10px 15px -1px rgba(255, 255, 255, 0.6), inset 0 3px 4px -1px rgba(255, 255, 255, 0.2), inset 0 0 5px 1px rgba(255, 255, 255, 0.8), inset 0 20px 30px 0 rgba(255, 255, 255, 0.2);
  border-radius: 68.8px;
  position: absolute;
  background: #eaeaea;
  margin-left: -34.4px;
  margin-top: -34.4px;
  display: block;
  height: 68.8px;
  width: 68.8px;
  left: 50%;
  top: 50%;
}

.toggle .label {
  transition: color 300ms ease-out;
  line-height: 101px;
  text-align: center;
  position: absolute;
  font-weight: 700;
  font-size: 28px;
  display: block;
  opacity: 0.9;
  height: 100%;
  width: 100%;
  color: rgba(0, 0, 0, 0.9);
}

.toggle input {
  opacity: 0;
  position: absolute;
  cursor: pointer;
  z-index: 1;
  height: 100%;
  width: 100%;
  left: 0;
  top: 0;
}

.toggle input:active ~ .button {
  filter: blur(0.5px);
  box-shadow: 0 12px 25px -4px rgba(0, 0, 0, 0.4), inset 0 -8px 30px 1px rgba(255, 255, 255, 0.9), 0 -10px 15px -1px rgba(255, 255, 255, 0.6), inset 0 8px 25px 0 rgba(0, 0, 0, 0.4), inset 0 0 10px 1px rgba(255, 255, 255, 0.6);
}

.toggle input:active ~ .label {
  font-size: 26px;
  color: rgba(0, 0, 0, 0.45);
}

.toggle input:checked ~ .button {
  filter: blur(0.5px);
  box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.4), inset 0 -8px 25px -1px rgba(255, 255, 255, 0.9), 0 -10px 15px -1px rgba(255, 255, 255, 0.6), inset 0 8px 20px 0 rgba(0, 0, 0, 0.2), inset 0 0 5px 1px rgba(255, 255, 255, 0.6);
}

.toggle input:checked ~ .label {
  color: rgba(0, 0, 0, 0.8);
}
.card {
  overflow: hidden;
  position: relative;
  text-align: left;
  border-radius: 0.5rem;
  max-width: 290px;
  height: 100%;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  background-color: #fff;
}

.dismiss {
  position: absolute;
  right: 10px;
  top: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1rem;
  background-color: #fff;
  color: black;
  border: 2px solid #D1D5DB;
  font-size: 1rem;
  font-weight: 300;
  width: 30px;
  height: 30px;
  border-radius: 7px;
  transition: .3s ease;
}

.dismiss:hover {
  background-color: #ee0d0d;
  border: 2px solid #ee0d0d;
  color: #fff;
}

.header {
  padding: 1.25rem 1rem 1rem 1rem;
}

.image {
  display: flex;
  /*margin-left: auto;*/
  margin-right: auto;
  background-color: #a5c9ff;
  flex-shrink: 0;
  justify-content: center;
  align-items: center;
  width: 3.5rem;
  height: 3.5rem;
  font-weight: 900;
  font-size: 15px;
  color: #152C4F;
  border-radius: 9999px;
  animation: animate .6s linear alternate-reverse infinite;
  transition: .6s ease;
}

.image svg {
  color: #0afa2a;
  width: 2rem;
  height: 2rem;
}

.content {
  margin-top: 0.75rem;
  text-align: center;
  position: relative;
  top: 10px;
}

.title {
  color: #152C4F ;
  font-size: 1rem;
  font-weight: 600;
  line-height: 1.5rem;
  position: relative;
    top: -15px;
}

.message {
  margin-top: 0.5rem;
  color: #595b5f;
  font-size: 0.875rem;
  line-height: 1.25rem;
}

.actions {
  margin: 0.75rem 1rem;
  text-align: center;
  margin-top: 30px
}

.history {
  margin-bottom: 5px;
  display: inline-block;
  padding: 0.5rem 0rem;
  background: linear-gradient(30deg, #a5c9ff 20%, #4382E0 80%);
  color: #ffffff;
  font-size: 1rem;
  line-height: 1.5rem;
  font-weight: 500;
  justify-content: center;
  width: 45%;
  border-radius: 0.375rem;
  border: none;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.track {
  display: inline-flex;
  margin-top: 0.75rem;
  padding: 0.5rem 1rem;
  color: #242525;
  font-size: 1rem;
  line-height: 1.5rem;
  font-weight: 500;
  justify-content: center;
  width: 100%;
  border-radius: 0.375rem;
  border: 1px solid #D1D5DB;
  background-color: #fff;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

@keyframes animate {
  from {
    transform: scale(1);
  }

  to {
    transform: scale(1.09);
  }
}
.col-md-8{
   /* left: 23px;*/
   text-align:center;
}
.stardate {
    font-size: 15px !important;
}
/*button for files*/
.Btn {
    margin: auto;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 45px;
  height: 45px;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition-duration: .3s;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
  background: linear-gradient(30deg, #a5c9ff 20%, #4382E0 80%);
}

/* plus sign */
.sign {
  width: 100%;
  transition-duration: .3s;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 900;
}

.sign svg {
  width: 30px;
}

.sign svg path {
  fill: white;
}
/* text */
.text {
  position: absolute;
  right: 12%;
  width: 0%;
  opacity: 0;
  color: white;
  font-size: 1.2em;
  font-weight: 600;
  transition-duration: .3s;
}
/* hover effect on button width */
.Btn:hover {
  width: 120px;
  border-radius: 40px;
  transition-duration: .3s;
  color: white;
  font-weight: 900;
}

.Btn:hover .sign {
  width: 25%;
  transition-duration: .3s;
  padding-right: 15px;
}
/* hover effect button's text */
.Btn:hover .text {
  opacity: 1;
  width: 70%;
  transition-duration: .3s;
  padding-right: 20px;
}
/* button click effect*/
.Btn:active {
  transform: translate(2px ,2px);
}

/*end button for files*/
.tab .nav-tabs {
    border-bottom: 5px solid #152C4F;
    width: 198% !important;
    position: relative;
    left: 48% !important;
}
 </style>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <!--link for material icon -->

    <link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />

    <link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/showcontent_style.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     @endsection
@section('content')


<div class="main-panel" style="background: #f8f9fb;">
    @if (session()->has('success'))

    <script>
        window.onload = function() {
            notif({
                msg: " تمت العملية بنجاح ",
                type: "success"
            })
        }

    </script>
@endif
 @if (session()->has('success_uploading'))

    <script>
        window.onload = function() {
            notif({
                msg: " تم تخزين الوظيفة بنجاح ",
                type: "success"
            })
        }

    </script>
@endif
    @if (session()->has('file_error'))
    <script>
        window.onload = function() {
            notif({
                msg: "  قم بإضافة ملف أو رابط  ",
                type: "error"
            })
        }

    </script>
@endif
    @if (session()->has('file_error2'))

    <script>
        window.onload = function() {
            notif({
                msg: "  قم بإضافة ملف للمحتوى   ",
                type: "error"
            })
        }

    </script>
@endif
 @if (session()->has('no_questions'))

    <script>
        window.onload = function() {
            notif({
                msg: " الاختبار لا يحتوي أسئلة  ",
                type: "error"
            })
        }

    </script>
@endif
 @if (session()->has('warning'))

    <script>
        window.onload = function() {
            notif({
                msg: " {{Session::get('warning')}} ",
                type: "error"
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
                    msg: 'يرجى  ترفيع  بالشروط المحددة ' ,
                    type: "error"
                })
            }

        </script>
        @endforeach

@endif

{{--@if (count($errors) > 0)
    <div class="alert alert-danger">
       <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif--}}
	<ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	   <li class="li"><a href="{{route('dashboard.student.lesson.lectures',['lesson_id' => $lesson->id,'room_id' => $lecture->room->id,'student_id' => $student->id]) }}">الدروس</a></li>
	  <li class="li"><a href="#">{{$lecture->name}}</a></li>

   </ul>
    <div class="content-wrapper pb-0">

      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <!--tablist-->
                  <div class="container">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="tab" role="tabpanel">
                                  <!-- Nav tabs -->
                                  <ul class="nav nav-tabs" role="tablist">
                                      <li role="presentation" class="active"><a href="#Section1" aria-controls="book" role="tab" data-toggle="tab"><i class="fa fa-globe"></i> المحتوى العلمي</a></li>
                                      <li role="presentation"><a href="#Section2" aria-controls="files" role="tab" data-toggle="tab"><i class="fa fa-file"></i> الملفات</a></li>
                                      <li role="presentation"><a href="#Section3" aria-controls="homework" role="tab" data-toggle="tab"><i class="fa fa-tasks"></i> الوظائف</a></li>
                                      <li role="presentation"><a href="#Section4" aria-controls="exams" role="tab" data-toggle="tab"><i class="fa fa-question"></i> الاختبارات</a></li>
                                      <li role="presentation"><a href="#Section5" aria-controls="audio" role="tab" data-toggle="tab"><i class="fa fa-file-audio-o"></i> مقاطع الصوت</a></li>
                                      <li role="presentation"><a href="#Section6" aria-controls="video" role="tab" data-toggle="tab"><i class="fa fa-youtube-play"></i> مقاطع الفيديو</a></li>
                                  </ul>
                                  <!-- Tab panes -->
                                  <div class="tab-content tabs">
                                      <div role="tabpanel" class="tab-pane active" id="Section1">
                                          <!--h3 style="text-align: center;">المحتوى العلمي</h3-->
                                          <!--start content-->
                                               <!--new cards-->
                        <div class="container" style="direction: ltr;">
                          <div class="row" style="justify-content: center; margin:auto">

                            <!--start card tow-->
                            @if(isset($lesson->books))
                            @foreach ($lesson->books as $book)
                            <div class="col-md-4  step1">
                              <div class="row box shape-1 animated bounceInLeft">
                                <div class="col-md-4  shape">
                                  <div class="number">
                                    <h1>
                                        <i class="material-icons md-56"
                                            style="color: #fff;
                                            font-size: 55px;
                                            position: relative;
                                           ">&#xE873;</i></h1>
                                  </div>
                                </div>
                                <div class="col-md-8 ">
                                  <p> {{ $book->name_ar }}</p>
                                  
                                  <a target="_blank"
                                  @if ($book->type == 'link')
                                  href=" {{$book->value}}"
                                  @else
                                  href=" {{ asset('storage/'.$book->value) }}"
                                  @endif
                                  class=" " title="عرض">
                                  <button class="learn-more">
                                    <span class="circle" aria-hidden="true">
                                    <span class="icon arrow"></span>
                                    </span>
                                    <span class="button-text">استعراض المحتوى</span>
                                  </button>
                                  </a>


                                </div>

                              </div>
                            </div>


                            @endforeach
                            @endif
                            <!--end card tow-->
                            <!--start card tow-->

                          </div>
                         </div>
                        <!--end new cards-->
                                          <!--end content-->
                                      </div>
                                      <div role="tabpanel" class="tab-pane fade" id="Section2">
                                          <!--h3 style="text-align: center;">الملفات </h3-->
                                          <div class="container" style="direction: ltr;">
                                              <div class="row" style="justify-content: center; margin:auto">

                                                <!--start card tow-->
                                                @if(isset($lecture_others))
                                                @foreach ($lecture_others as $lecture_other )
                                                {{-- <a href="#"><img src="../img/icons8-export-pdf-100.png" alt=""></a> --}}
                                                 @if(isset($lecture_other) &&  isset($lecture_other->addition))
                                                <div class="col-md-4  step1">
                                                  <div class="row box shape-1 animated bounceInLeft">
                                                    <div class="col-md-4  shape">
                                                      <div class="number">
                                                        <h1><i class="material-icons md-56"
                                                          style="color: #fff;
                                                          font-size: 80px;
                                                          position: relative;
                                                          top: -10px;">&#xE873;</i></h1>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-8 ">
                                                      <p> {{ $lecture_other->name_addition }}</p>
                                                      <a href="{{ asset('storage/'.$lecture_other->addition) }}">
                                                          <button class="learn-more">
                                                              <span class="circle" aria-hidden="true">
                                                              <span class="icon arrow"></span>
                                                              </span>
                                                              <span class="button-text">استعراض المحتوى</span>
                                                            </button>
                                                      </a>

                                                    </div>

                                                  </div>
                                                </div>
                                                 @elseif(isset($lecture_other) &&  isset($lecture_other->addition_link))
                                                 <div class="col-md-4  step1">
                                                  <div class="row box shape-1 animated bounceInLeft">
                                                    <div class="col-md-4  shape">
                                                      <div class="number">
                                                        <h1><i class="material-icons md-56"
                                                          style="color: #fff;
                                                          font-size: 80px;
                                                          position: relative;
                                                          top: -10px;">&#xE873;</i></h1>
                                                      </div>
                                                    </div>    
                                                    <div class="col-md-8 ">
                                                      <p> {{ $lecture_other->name_addition }}</p>
                                                      <a target=_blank href="{{$lecture_other->addition_link}}">
                                                          <button class="learn-more">
                                                              <span class="circle" aria-hidden="true">
                                                              <span class="icon arrow"></span>
                                                              </span>
                                                              <span class="button-text">استعراض المحتوى</span>
                                                            </button>
                                                      </a>

                                                    </div>

                                                  </div>
                                                </div>
                                                @endif
                                                @endforeach

                                            @endif


                                              </div>
                                             </div>
                                            <!--end new cards-->
                                                              <!--end content-->

                                      </div>
                                      <div role="tabpanel" class="tab-pane fade" id="Section3">
                                          <!--h3 style="text-align: center;">الوظائف</h3-->
                                           <!--new cards for homework card-->
                                                    <div class="container">
                                            <div class="row responmaincol" style="justify-content: center;">
                                                @if(isset($lecture_tests))
                                                @foreach ($lecture_tests as $lecture_test )
                                                <div class="col-md-4 animated bounceInLeft col_bottom"><!--start card-->
                                                   <div class="card">
                                                         <div class="header">
                                                            @if( $now > $lecture_test->start_time && $now <= $lecture_test->end_time)
                                                            <div class="image" style="background-color: #45b6498a">
                                                                متاح
                                                              </div>
                                                            @elseif($now > $lecture_test->end_time)
                                                            <div class="image" style="background-color: #ff00004f;animation: none;">
                                                                انتهت
                                                              </div>
                                                          @else
                                                          <div class="image">
                                                            مخطط له
                                                          </div>
                                                          @endif

                                                            <div class="content">
                                                            <span class="title">{{ $lecture_test->namehomework  }}</span>
                                                               <div class="row">
                                                                <div class="col-md-4"> <span class="stardate">تاريخ البداية</span></div>
                                                                <div class="col-md-8">{{ $lecture_test->start_time  }} {{ $lecture_test->satart_Date}}</div>
                                                               </div>
                                                               <div class="row">
                                                                <div class="col-md-4"> <span class="stardate" style="font-size: 15px !important;">تاريخ النهاية </span></div>
                                                                <div class="col-md-8">{{ $lecture_test->end_time }} {{ $lecture_test->end_date }}</div>
                                                               </div>
                                                              </div>
                                                           <div class="actions">
                                                            @if(isset($lecture_test->test_link))
                                                            <a  href="  {{ $lecture_test->test_link }}"
                                                                class="history" target="_blank">
                                                                رابط
                                                            </a>

                                                            @endif
                                                            @if(isset($lecture_test->test))
                                                            <a  href=" {{ asset('storage/'.$lecture_test->test) }}"
                                                             class="history" target="_blank">
                                                             مشاهدة الوظيفة
                                                            </a>
                                                           @endif

                                                            @if($lecture_test->homeworks->count()>0)
                                                           <a  href="" data-toggle="modal" data-target="#demoModal"
                                                            data-id="{{ $lecture_test->id }}" data-content_name="{{ $lecture_test->namehomework }}" data-hommework="{{$lecture_test->homeworks}}" class="history homeworks">
                                                              ملفاتي
                                                             </a>

                                                                @endif

                                                                @if( isset($lecture_test->result))
                                                                <!--العلامة-->

                                                               {{-- <button class="Btn">
                                                                    {{$lecture_test->result}}

                                                                    <div class="text">العلامة</div>
                                                                  </button>
--}}
<button class="Btn">

    <div class="sign">
        {{$lecture_test->result}}
        </div>

    <div class="text">العلامة</div>
  </button>





                                                                @elseif ($now > $lecture_test->start_time && $now < $lecture_test->end_time)
                                                                <button class="history upload_files" data-toggle="modal" data-target="#demoModal4"
                                                                    data-id="{{ $lecture_test->id }}" data-content_name="{{ $lecture_test->namehomework }}"
                                                                    title="ارفع ملف" >
                                                                    ارفع ملف

                                                                </button>

                                                            @endif


                                                      </div>
                                                    </div>
                                                  </div>
                                                </div><!--end card-->
                                                @endforeach

                                                @endif

                                           <!--end-->
                                            </div>
                                           </div>
                                           <!--end new cards for homework card-->
                                             
                                           <!--
                                           <div class="container">
                                            <div class="row responmaincol" style="justify-content: center;">
                                                @if(isset($lecture_tests))
                                                @foreach ($lecture_tests as $lecture_test )
                                             <div class="col-md-4  animated bounceInLeft col_bottom">
                                               <div class="form_main">
                                                 <p class="heading"> {{ $lecture_test->namehomework  }}</p>
                                                    <div class="container respnscont">
                                                      <div class="row">
                                                        <div class="col-md-4" >
                                                          <span class="stardate">تاريخ البداية</span>
                                                        </div>
                                                        <div class="col-md-8" style="display: block;">
                                                         <span >{{ $lecture_test->start_time  }} {{ $lecture_test->satart_Date}}</span>
                                                       </div>
                                                       <div class="col-md-4 ncol" >
                                                         <span class="stardate">تاريخ النهاية</span>
                                                       </div>
                                                       <div class="col-md-8 ncol2">
                                                         <span> {{ $lecture_test->end_time }} {{ $lecture_test->end_date }}</span>
                                                      </div>
                                                      </div>
                                                    </div>
                                                   <div class="container respnscont2">
                                                      <div class="row" style="justify-content: space-around">
                                                        @if(isset($lecture_test->test_link))
                                                        <a  href="  {{ $lecture_test->test_link }}"
                                                            class="homeworkbtn" target="_blank">
                                                            رابط
                                                        </a>
                                                        @endif
                                                      @if(isset($lecture_test->test))
                                                       <a  href=" {{ asset('storage/'.$lecture_test->test) }}"
                                                        class="homeworkbtn" target="_blank">
                                                        مشاهدة الوظيفة
                                                       </a>
                                                      @endif
                                                      @foreach ($lecture_test->homeworks as $homeworks  )
                                                      @if(isset($homeworks->file))
                                                       <a  href=" {{ asset('storage/app/'.$homeworks->file) }}"
                                                        class="homeworkbtn" target="_blank">
                                                        ملفاتي 
                                                       </a>
                                                      @endif
                                                      @endforeach
                                                      @if( isset($lecture_test->result))
                                                      <a class="homeworkbtn"   style="padding-left: 6px; padding-right: 6px;">{{$lecture_test->result}} </a>

                                                      @elseif ($now > $lecture_test->start_time && $now < $lecture_test->end_time)
                                                      <a class="homeworkbtn upload_files" data-toggle="modal" data-target="#demoModal4"
                                                          data-id="{{ $lecture_test->id }}" data-content_name="{{ $lecture_test->namehomework }}"
                                                          title="ارفع ملف" >
                                                          ارفع ملف
                                                          <!--<i class="fa fa-pencil-square-o fa-xs" aria-hidden="true"></i>>
                                                          @if($lecture_test->previous_file_count > 0)
                                                          ارفع مجدداً
                                                          @endif
                                                      </a>
                                                      @if($lecture_test->previous_file_count > 0)
                                                      <a class="homeworkbtn"  style="color:white"   data-effect="effect-scale"
                                                          title=" " >
                                                          <!--<i class="fa fa-pencil-square-o fa-xs" aria-hidden="true"></i>->
                                                          تم الرفع
                                                      </a>
                                                      @endif


                                                  @endif


                                                    @if( $now > $lecture_test->start_time && $now <= $lecture_test->end_time)
                                                    <a class="homeworkbtn" href="#">متاح</a>
                                                    @elseif($now > $lecture_test->end_time)
                                                    <a class="homeworkbtn" href="#">انتهت</a>
                                                  @else
                                                  <a class="homeworkbtn" href="#">مخطط له</a>
                                                  @endif


                                               </div>
                                             </div>
                                           </div>
                                        </div><!--end col->
                                        @endforeach
                                        @endif
                                    <!--end-->
                                          
                                           <!--end content of homework cards-->
                          {{--<div class="container">
                              <div class="row" style="padding-top: 20px;">
                                <div class="col-md-12">

                                 <div style="overflow-x:auto; padding-bottom: 100px;" >
                                   <table class="table-fill"  >
                                       <thead>
                                         <tr>

                                           <th scope="col">اسم الوظيفة</th>
                                           <th scope="col">بداية الوقت</th>
                                           <th scope="col">نهاية الوقت</th>
                                           <th scope="col">نوع الوظيفة</th>
                                           <th scope="col">تحميل  الملف</th>
                                           <th scope="col">حالة الوظيفة</th>



                                         </tr>
                                       </thead>
                                       <tbody>
                                        @if(isset($lecture_tests))
                                        @foreach ($lecture_tests as $lecture_test )
                                         <tr>

                                           <td> {{ $lecture_test->namehomework  }} </td>
                                           <td scope="row"> {{ $lecture_test->start_time  }} {{ $lecture_test->satart_Date}}</td>

                                           <td>  {{ $lecture_test->end_time }} {{ $lecture_test->end_date }} </td>
                                           <td>

                     @if(isset($lecture_test->test_link))
                     <a  href="  {{ $lecture_test->test_link }}"
                         class="genric-btn info circle" target="_blank">
                         رابط
                     </a>
                     @endif
                   @if(isset($lecture_test->test))
                    <a  href=" {{ asset('storage/'.$lecture_test->test) }}"
                         class="genric-btn info circle" target="_blank">
                         ملف
                    </a>
                   @endif
                                           </td>

                                           <td>
                                            @if( isset($lecture_test->result))
                                            <a class="btn3"   style="padding-left: 6px; padding-right: 6px;">{{$lecture_test->result}} </a>

                                            @elseif ($now > $lecture_test->start_time && $now < $lecture_test->end_time)
                                            <a class="btn3 upload_files" href="#modal"
                                                data-id="{{ $lecture_test->id }}" data-content_name="{{ $lecture_test->namehomework }}"
                                                title="ارفع ملف" >
                                                ارفع ملف
                                                <!--<i class="fa fa-pencil-square-o fa-xs" aria-hidden="true"></i>-->
                                                @if($lecture_test->previous_file_count > 0)
                                                ارفع مجدداً
                                                @endif
                                            </a>
                                            @if($lecture_test->previous_file_count > 0)
                                            <a class="btn3"  style="color:white"   data-effect="effect-scale"
                                                title=" " >
                                                <!--<i class="fa fa-pencil-square-o fa-xs" aria-hidden="true"></i>-->
                                                تم الرفع
                                            </a>
                                            @endif


                                        @endif

                                           </td>
                                           <td>
                                            @if( $now > $lecture_test->start_time)
                                            <a class="btn3" href="#">متاح</a>
                                            @elseif($now > $lecture_test->end_time)
                                            <a class="btn3" href="#">انتهت</a>
                                        @else
                                        <a class="btn3" href="#">مخطط له</a>
                                        @endif

                                           </td>
                                         </tr>
                                         @endforeach
                                         @endif

                                       </tbody>
                                     </table>
                                 </div>

                                </div><!--end col-->

                              </div><!--end row-->
                            </div>
--}}


                           <!--end homework table-->

                                          <!--end content of homework-->
                                      </div>
                                      <div role="tabpanel" class="tab-pane fade" id="Section4">
                                          <!--h3 style="text-align: center;">الاختبارات</h3-->

                            <div class="container">
                             <div class="row" style="padding-top: 20px;justify-content: center;">
                                <!--start card content-->
                                @if(isset($lecture_quizes))
                                @foreach ($lecture_quizes as $lecture_quize )
                                <div class="col-md-4 animated bounceInLeft">
                                    <div class="form_main">
                                      <p class="heading" style="font-size: 20px;padding-top: 25px;">{{ $lecture_quize->name_quize1  }}</p>
                                      <div class="container respnscont">
                                        <div class="row">
                                          <div class="col-md-4" >
                                            <span class="stardate">تاريخ البداية</span>
                                          </div>
                                          <div class="col-md-8" style="display: block;">
                                           <span >{{ $lecture_quize->satart_Date}}   {{ $lecture_quize->start_time  }}</span>
                                         </div>
                                         <div class="col-md-4 ncol" >
                                           <span class="stardate">تاريخ النهاية</span>
                                         </div>
                                         <div class="col-md-8 ncol2">
                                           <span>{{ $lecture_quize->end_time }} {{ $lecture_quize->end_date }}</span>
                                        </div>
                                        </div>
                                      </div>
                             <div class="container respnscont2">
                                 <div class="row" style="justify-content: center">
                                    <a class="homeworkbtn" href="#" style="margin: 10px">مؤتمت</a>
                                    @if( isset($lecture_quize->result))
                                    @if( $lecture_quize->result != -1)
                                        <a  href=" {{route('dashboard.student.exam.view_exam',$lecture_quize->id)}}"
                                                  class="homeworkbtn" target="_blank" title="استعراض الاختبار">
                                                    {{$lecture_quize->success_mark}}  /  {{$lecture_quize->result}}
                                        </a>
                                    @else
                                        <a href="" style="margin: 10px"  class="homeworkbtn "
                                        title=" لم يتم التصحيح من قبل الاستاذ بعد">
                                                    قيد التصحيح
                                        </a>
                                    @endif



                                     @elseif ($now > $lecture_quize->start_time && $now < $lecture_quize->end_time  && $lecture_quize->type == 8)
                                     <a  style="margin: 10px" href=" {{route('dashboard.student.exam.start_exam',$lecture_quize->id)}}"
                                              class="homeworkbtn" target="_blank">
                                              ابدأ الاختبار
                                         </a>
                                    @elseif($now > $lecture_quize->end_time )
                                     <a  style="margin: 10px" href="#"
                                              class="homeworkbtn">
                                              انتهى الاختبار
                                         </a>
                                    @else
                                      <a  style="margin: 10px" href="#"
                                              class="homeworkbtn">
                                              مخطط له
                                         </a>
                                    
                                    @endif

                                 </div>
                               </div>
                             </div>
                          </div>
                          @endforeach
                          @endif
                                <!--end card content-->

                 

                          </div><!--end row-->


                        </div>
                       <!--end content-->
                                          <!--end content of quize-->
                                      </div>

                                      <div role="tabpanel" class="tab-pane fade" id="Section5">
                                          <!--h3 style="text-align: center;">مقاطع الصوت </h3-->
                                          <!--content of audio-->
                                          <div class="container" style="direction: ltr;">
                                              <div class="row">
                                                <!--start card one-->
                                                @if(isset($lecture_audios))
                                                @foreach ($lecture_audios as $lecture_audio )
                                                 @if(isset($lecture_audio) && ( isset($lecture_audio->audio_link) ||  isset($lecture_audio->audio_file)))

                                                <div class="col-md-4 col-md-offset-2 step1">
                                                  <div class="row box shape-1 animated bounceInLeft">
                                                    <div class="col-md-3 shape">
                                                      <div class="number">
                                                        <i class="material-icons mdi mdi-microphone-settings md-56" style="color: #fff;font-size: 53px;"></i>
                                                      </div>
                                                    </div>

                                                    <div class="col-md-8  col-md-offset-1" style="top: -16px;">
                                                      <p  style="font-size: 18px;
                                                      position: relative;"> 
                                                      {{ $lecture_audio->name_audio }} </p>
                                                        @if($lecture_audio->type_voice=='1')
                                                    <!--    <a target="_blank"  href="{{$lecture_audio->audio_link }}" >رابط مقطع الصوت</a>-->
                                                    
                                                         <a class="but2"  href="{{$lecture_audio->audio_link }}" target="_blank">رابط مقطع الصوت
                                                         </a>
                        
                                                     @else
                                                     <audio class="audio" src="{{ asset('storage/'.$lecture_audio->audio_file) }}" controls=""></audio>

                                                     @endif

                                                  </div>

                                                  </div>
                                                </div>
                                                @endif
                                                @endforeach
                                                @endif


                                              <!--end card 5-->



                                              </div>
                                            </div><!--end container-->
                                          <!--end content of audio-->
                                      </div>

                                      <div role="tabpanel" class="tab-pane fade" id="Section6">
                                          <!--h3 style="text-align: center;">مقاطع الفيديو</h3-->
                                          <!--content of video-->
                                               <!--video content-->
                       <div class="container">
                          <div class="row">
                            @if(isset($lecture_videos))
                            @foreach ($lecture_videos as $lecture_video )
                             @if(isset($lecture_video) && ( isset($lecture_video->video_link) ||  isset($lecture_video->video)))
                            <div class="col-md-6 ">
                              <div class="card2">
                                <div class="card-image">
                                  <div class="embed-responsive embed-responsive-16by9">
                                    @if($lecture_video->type_video == '1')
                                     <?php
                                  // Replace the 'watch?v=' part of the video link with 'embed/'
                                 $embed_link = str_replace('watch?v=', 'embed/', $lecture_video->video_link);
                                       ?>
                                  <iframe width="560" height="115" src="<?php echo $embed_link; ?>" 
                                  frameborder="0" allowfullscreen></iframe>
                                     @else
                                     <video width="210" height="150"  controls style="border-radius: 10px;">
                                      <source src="{{ asset('storage/'.$lecture_video->video) }}" type="video/mp4">
                                    </video>
                                     @endif
                                    <!--end div class content-->
                                  </div><!--End Div embed-responsive-->

                                </div>
                                <!-- card image -->

                                <div class="card-content" style="text-align: center;">
                                  <span class="card-title" >  {{ $lecture_video->name_video }} </span>


                                </div>
                                <!-- card content -->

                              </div>
                            </div>
                            @endif
                            @endforeach
                        @endif

                          </div>
                         </div>
                         <!--end video content-->
                                          <!--end content of video-->
                                      </div>
                                      <div role="tabpanel" class="tab-pane fade" id="Section7">
                                        <!--h3 style="text-align: center;">المحتوى العلمي</h3-->
                                        <!--start content-->
                                             <!--new cards-->
                                    <div class="container" style="direction: ltr;">
                                    <div class="row" style="justify-content: center; margin:auto">

                          <!--start card tow-->
                          @if(isset($super_file))
                          @foreach ($super_file as $file)
                          <div class="col-md-4  step1">
                            <div class="row box shape-1 animated bounceInLeft">
                              <div class="col-md-4  shape">
                                <div class="number">
                                  <h1>
                                      <i class="material-icons md-56"
                                          style="color: #fff;
                                          font-size: 55px;
                                          position: relative;
                                         ">&#xE873;</i></h1>
                                </div>
                              </div>
                              <div class="col-md-8 ">
                                @if ($file->type==1)
                                <p>  ملف    ({{$file->name}})   </p>
                                @else
                                <p> خطة فصلية  ({{$file->name}})  </p>
                                @endif
                                
                                <a target="_blank"
                                
                                href=" {{ asset('storage/'.$file->file) }}"
                              
                                class=" " title="عرض">
                                <button class="learn-more">
                                  <span class="circle" aria-hidden="true">
                                  <span class="icon arrow"></span>
                                  </span>
                                  <span class="button-text">استعراض المحتوى</span>
                                </button>
                                </a>


                              </div>

                            </div>
                          </div>


                          @endforeach
                          @endif
                          <!--end card tow-->
                          <!--start card tow-->

                        </div>
                       </div>
                      <!--end new cards-->
                                        <!--end content-->
                                    </div>


                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!--end tablist-->
              </div>
<!--new modal-->
 <div class="modal fade auto-off"id="demoModal4" tabindex="-1" role="dialog" aria-labelledby="demoModal" aria-hidden="true">
                    <div class="modal-dialog animated zoomInLeft modal-dialog-centered" role="document">
                        <div class="modal-content" style="padding-top: 50px !important;">
                            <div class="container-fluid">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: white !important;">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <h4  style="color: #152C4F;text-align: center;font-size: 25px; ">تحميل ملف</h4>
                                <form  action="{{ route('dashboard.student.upload_files') }}" method="post" enctype="multipart/form-data" style="direction: rtl; text-align: right;position: relative;
                                top: 0px;">
                                @csrf
                                <input type="hidden" name="item_id" id="item_id" value="" class="item_id">
                                <div class="container" style="padding-top: 20px;">
                                    <div class="form-group row">
                                        <label for="courseCost" class="col-sm-4 col-form-label">اسم  المحتوى :</label>
                                        <div class="col-sm-11">
                                            <input name="content_name" id="content_name" class="common-input mb-20 form-control"  type="text" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                          <small style="color:green">لايتجاوز حجم الملف  2M</small>
                                          <div class="py-8">
                                            <!--label for="file-input" class="drop-container">
                                                <span class="drop-title"></span>
                                                <input  name="file[]" id="file" type="file"  id="default" class="border p-2" multiple  class="file-input">
                                              </label-->
                                            <label for="default" class="block text-sm leading-5 font-medium text-gray-700 mb-4"></label>
                                            <input   name="file[]" id="file" type="file" class="file-input" multiple>
                                          </div>
                                        </div><!--end col-->
                                      </div><!--end row-->
                                   <div class="row" style="text-align: center;">
                                    <div class="col-md-12" style="padding-bottom: 10px;">
                                        <button class="btn3" type="submit" style="width: 140px;
                                        padding-top: 10px;
                                        padding-bottom: 10px;">حفظ</button>
                                    </div>
                                  </div>
                              </div>
                            </form>
                          </div>
                        </div>
                    </div>
                  </div>
                  <!---->
<!--end new modal-->
<!--files homwwork modal-->
<div class="modal fade auto-off"id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModal" aria-hidden="true">
    <div class="modal-dialog animated zoomInLeft modal-dialog-centered" role="document">
        <div class="modal-content" style="padding-top: 50px !important;">
            <div class="container-fluid">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: white !important;">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4  style="color: #152C4F;text-align: center;font-size: 25px; ">ملفات الوظائف</h4>
                <form  action="" method="post" enctype="multipart/form-data" >


                <input type="hidden" name="item_id" id="item_id" value="" class="item_id">
                <div class="container" style="padding-top: 20px;">

                    <div class="row home_work">
  
                      </div><!--end row-->

              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
<!--end file homework modal-->
              
              
<!--modal popup-->
<!--div id="modal" style="z-index: 9999;">
<a href="#"></a>
<section>
<form  action="{{ route('dashboard.student.upload_files') }}" method="post" enctype="multipart/form-data" style="direction: rtl; text-align: right;position: relative;
top: -30px;">
@csrf
<input type="hidden" name="item_id" id="item_id" value="" class="item_id">
  <div class="controls">
    <a href="#"><i class="fa fa-times"></i></a>
  </div>
  <h3 style="text-align: center;">تحميل الوظيفة</h3>
  <!--content of form->
  <div class="form-group row">
    <label for="courseCost" class="col-sm-4 col-form-label">اسم  المحتوى :</label>
    <div class="col-sm-11">
        <input name="content_name" id="content_name" class="common-input mb-20 form-control"  type="text" readonly>
    </div>
</div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <small style="color:green">لايتجاوز حجم الملف  2M</small>
        <div class="py-8">
          <label for="default" class="block text-sm leading-5 font-medium text-gray-700 mb-4"></label>
          <!-- This is a normal file input ->
          <input   name="file[]" id="file" type="file"  id="default" class="border p-2" multiple>
        </div>
      </div><!--end col->
    </div><!--end row->
    <div class="row" style="justify-content: center;top: 20px;">
      <div class="col-md-5">
       <!--submit button->
       <button class="btn3" type="submit" style="width: 140px;
       padding-top: 10px;
       padding-bottom: 10px;">حفظ</button>
       <!--end submit button->
      </div>

    </div>

  </div><!--end container-->


  <!--end contetn of foem->
</form>
</section>
</div>
<!--end modal popup-->



          </div>
      </div>
  </div>
   <!---modal popup-->
</div>
	@endsection
	@section('js')
  <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
   
    <script>

      $(document).ready(function(){
      $(document).on("click", ".homeworks", function (event) {
          $('.home_work').empty();
      home=$(this).data('hommework');
    $.each(home, function(index, value) {
        
        if(value){
         
               
           $('.home_work').append(`
         
            <a href="{{ url('/storage/app/') }}/${value.file}" class="homeworkbtn" target="_blank">
                ملفاتي
            </a>
      
        `); 
                  
              
          
        }
        
    })
})
     
      
     
     
      $(document).on("click", ".upload_files", function (event) {
      var  button = $(this);
      var id = button.data('id');
      var content_name = button.data('content_name');
      $('#item_id').val(id);
      $('#content_name').val(content_name);

  });


      })
      $(document).ready(function(){
    $('.lesson11').addClass('active') ;
  });
  </script>
  <script type="text/javascript">
    function ValidateSize(file) {
      var FileSize = file.files[0].size / 1024 / 1024; // in MB
      if (FileSize > 2) {
        alert('File size exceeds 2 MB');
         $(file).val(''); //for clearing with Jquery
      } else {

      }
    }
   </script>
	@endsection
