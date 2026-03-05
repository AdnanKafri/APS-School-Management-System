@extends('school_controller.layouts.app')
@section('css')
    <style>
     @media (min-width: 200px) and (max-width: 700px){
          .btn {
           width: 14rem !important;
        }
        .card13 input {
        font-size: 16px !important;
}
    }
      .form {
        width: auto;
      }
      @media(min-width:200px) and (max-width:500px){
        .drop-container{
          width: 150px;
        }
      }
      form div span{
        background-color: transparent !important
      }
      .card13 input{
        font-size: 20px
      }
      @media(min-width:100px) and (max-width:900px){
          .dateinput{
              width:65% !important;
          }
      }
    </style>
@endsection


@section('content')
@if (session()->has('Add'))
<script>
    window.onload = function () {
        notif({
            msg: " تم اضافة محتوى بنجاح ",
            type: "success"
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
                    msg: 'يرجى  ترفيع   الفيديو بالشروط المحددة ' ,
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
      <li class="li"><a href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room_id ,'teacher_id'=>$teacher->id])}}">{{ $room1->name }} </a></li>
      <li class="li"><a href="{{ route('dashboard.lessons.lectures',['lesson_id' =>$lecture_id->lesson->id ,'teacher_id'=>$teacher->id,'room_id'=>$room1->id]) }}">{{  $lecture_id->lesson->name}}  </a></li>
      <li class="li"><a href="#">{{ $lecture_id->name }}</a></li>
   </ul>

    <div class="content-wrapper pb-0">
       <!--start content-->
       @if(session()->has('message'))
                <div class="alert alert-danger">
                {{ session()->get('message') }}
                </div>
                @endif
       <div class="container">
        <div class="row">
            <div class="col-md-6">


            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
            <input type="hidden" name="lesson_id" value="{{ $lecture_id->lesson->id }}">
            <input type="hidden" name="class_id" value="{{ $class_id }}">
            <input type="hidden" name="room_id" value="{{ $room_id }}">
            <input type="hidden" name="lecture_id" value="{{ $lecture_id->id }}">

                <div class="tab" role="tabpanel" style="direction: rtl;">
                <!--input type="hidden" value="1" id="tab1" name="type">
                <input type="hidden" value="0" id="tab2" name="type">
                <input type="hidden" value="6" id="tab3" name="type">
                <input type="hidden" value="7" id="tab4" name="type">
                <input type="hidden" value="4" id="tab5" name="type"-->
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">

                            <a href="#Section1"  role="tab" data-toggle="tab">اضافة ملف</a>

                        </li>
                        <li role="presentation">

                            <a href="#Section2"  role="tab" data-toggle="tab">اضافة اختبار</a>

                        </li>
                        <li role="presentation">

                            <a href="#Section3"  role="tab" data-toggle="tab">اضافة مقطع صوت</a>

                        </li>
                        <li role="presentation">

                            <a href="#Section4"  role="tab" data-toggle="tab">اضافة مقطع فيديو</a>

                        </li>
                        <li role="presentation">

                            <a href="#Section5"  role="tab" data-toggle="tab">اضافة وظيفة</a>

                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs">
                        <div role="tabpanel" class="tab-pane active" id="Section1">

                            <form action="{{ route('dashboard.store_items') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                <input type="hidden" name="lesson_id" value="{{ $lecture_id->lesson->id }}">
                                <input type="hidden" name="class_id" value="{{ $class_id }}">
                                <input type="hidden" name="room_id" value="{{ $room_id }}">
                                <input type="hidden" name="lecture_id" value="{{ $lecture_id->id }}">
                                <input hidden type="text" name="type" value="4" >
                            <div class="container">
                               <div class="row">
                                 <!--start card-->
                                 <div class="col-md-6 newrow">
                                  <div class="card13">
                                     <span style="color: #444bba;text-align: center;"></span>
                                    <div class="Group" style="justify-content: right;">
                                       <label style="text-align: right;">اسم الملف</label>
                                       <input name="name_addition" type="text" class="form-control" placeholder="ادخل اسم الملف ">
                                    </div>
                                  </div>

                                 </div>
                                 <!--end card-->
                                 <div class="col-md-6 newrow">
                                  <div class="card13">
                                     <span style="color: #444bba;text-align: center;"></span>
                                    <div class="Group" style="justify-content: right;">
                                       <label style="text-align: right;">اضافة رابط خارجي</label>
                                       <input name="addition_link" type="text" class="form-control" placeholder="اضافة رابط خارجي">
                                    </div>
                                  </div>

                                 </div>
                                 <!--end card-->
                                 <div class="col-md-6 newrow">
                                    <div class="card13">
                                        <span style="color: #444bba;text-align: center;"></span>
                                          <div class="Group" style="justify-content: right;">
                                             <label style="text-align: right;">تحميل ملف</label>
                                             <label for="file-input" class="drop-container">
                                                <span class="drop-title">
                                                   <br>
                                                   <br>
                                                </span>
                                                <input type="file" name="addition"  id="file-input">
                                              </label>

                                          </div>
                                        </div>
                                 </div>
                               </div><!--end row-->
                              <div class="row" style="justify-content: center;padding-top: 20px;">
                                 <div class="col-md-2">
                                  <button class="btn" type="submit">
                                    <strong>حفظ </strong>
                                    <div id="container-stars">
                                      <div id="stars"></div>
                                    </div>

                                    <div id="glow">
                                      <div class="circle"></div>
                                      <div class="circle"></div>
                                    </div>
                                  </button>

                                 </div>

                              </div>
                            </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="Section2">

                             <div class="container" style="justify-content: center;">
                                <div class="row" style="justify-content: center;">
                                  <div class="col-md-4">
                                    <div class="card13">
                                      <span style="color: #444bba;text-align: center;"></span>
                                     <div class="Group" style="justify-content: right;">
                                      <a href="{{ route('dashboard.teacher.questions',[$class_id,$room_id,$lecture_id->id,$lecture_id->lesson->id ]) }}">
                                        <button class="button21">
                                          <span class="transition"></span>
                                          <span class="gradient"></span>
                                          <span class="label">اضافة محتوى مؤتمت</span>
                                        </button>
                                      </a>

                                     </div>
                                   </div>
                                  </div>
                                </div>
                             </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="Section3">

                            <form action="{{ route('dashboard.store_items') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                <input type="hidden" name="lesson_id" value="{{ $lecture_id->lesson->id }}">
                                <input type="hidden" name="class_id" value="{{ $class_id }}">
                                <input type="hidden" name="room_id" value="{{ $room_id }}">
                                <input type="hidden" name="lecture_id" value="{{ $lecture_id->id }}">
                                <input hidden type="text" name="type" value="6" >
                            <div class="container">
                              <div class="row">
                                <!--start card-->
                                <div class="col-md-6 newrow">
                                 <div class="card13">
                                    <span style="color: #444bba;text-align: center;"></span>
                                   <div class="Group" style="justify-content: right;">
                                      <label style="text-align: right;">اسم مقطع الصوت</label>
                                      <input  name="name_audio" type="text" class="form-control" placeholder="ادخل اسم الملف ">
                                   </div>
                                 </div>

                                </div>
                                <!--end card-->
                                <div class="col-md-6 newrow">
                                 <div class="card13">
                                    <span style="color: #444bba;text-align: center;"></span>
                                   <div class="Group" style="justify-content: right;">
                                      <label style="text-align: right;">اضافة رابط خارجي</label>
                                      <input name="audio_link" type="text" class="form-control" placeholder="اضافة رابط خارجي">
                                   </div>
                                 </div>

                                </div>
                                <!--end card-->
                                <div class="col-md-6 newrow">
                                    <div class="card13">
                                        <span style="color: #444bba;text-align: center;"></span>
                                          <div class="Group" style="justify-content: right;">
                                             <label style="text-align: right;">تحميل ملف</label>
                                             <label for="file-input" class="drop-container">
                                                <span class="drop-title">
                                                   <br>
                                                   <br>
                                                </span>
                                                <input type="file" name="audio_file"    id="file-input">
                                              </label>

                                          </div>
                                        </div>
                                </div>
                              </div><!--end row-->
                             <div class="row" style="justify-content: center;padding-top: 20px;">
                                <div class="col-md-3">
                                 <button class="btn" type="submit">
                                   <strong>حفظ </strong>
                                   <div id="container-stars">
                                     <div id="stars"></div>
                                   </div>

                                   <div id="glow">
                                     <div class="circle"></div>
                                     <div class="circle"></div>
                                   </div>
                                 </button>

                                </div>

                             </div>
                           </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="Section4">

                            <form action="{{ route('dashboard.store_items') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                <input type="hidden" name="lesson_id" value="{{ $lecture_id->lesson->id }}">
                                <input type="hidden" name="class_id" value="{{ $class_id }}">
                                <input type="hidden" name="room_id" value="{{ $room_id }}">
                                <input type="hidden" name="lecture_id" value="{{ $lecture_id->id }}">
                                <input hidden type="text" name="type" value="0" >
                          <div class="container">
                            <div class="row">
                              <!--start card-->
                              <div class="col-md-6 newrow">
                               <div class="card13">
                                  <span style="color: #444bba;text-align: center;"></span>
                                 <div class="Group" style="justify-content: right;">
                                    <label style="text-align: right;">عنوان الفيديو</label>
                                    <input type="text" name="name_video"  class="form-control" placeholder="ادخل اسم الملف ">
                                 </div>
                               </div>

                              </div>
                              <!--end card-->
                              <div class="col-md-6 newrow">
                               <div class="card13">
                                  <span style="color: #444bba;text-align: center;"></span>
                                 <div class="Group" style="justify-content: right;">
                                    <label style="text-align: right;">اضافة رابط خارجي</label>
                                    <input type="text" name="video"  class="form-control" placeholder="اضافة رابط خارجي">
                                 </div>
                               </div>

                              </div>
                              <!--end card-->
                              <div class="col-md-6 newrow">
                                <div class="card13">
                                    <span style="color: #444bba;text-align: center;"></span>
                                      <div class="Group" style="justify-content: right;">
                                         <label style="text-align: right;">تحميل  مقطع الفيديو
                                          <span style="    display: contents;
                                            color: #8080805e;
                                            font-size: small;">لايمكن تحميل اكثر من 50M</span>
                                         </label>
                                         <label for="file-input" class="drop-container">
                                            <span class="drop-title">
                                               <br>
                                               <br>
                                            </span>
                                            <input type="file" name="video_in"    id="file-input">
                                          </label>

                                      </div>
                                    </div>
                              </div>
                            </div><!--end row-->
                           <div class="row" style="justify-content: center;padding-top: 20px;">
                              <div class="col-md-3">
                               <button class="btn" type="submit">
                                 <strong>حفظ </strong>
                                 <div id="container-stars">
                                   <div id="stars"></div>
                                 </div>

                                 <div id="glow">
                                   <div class="circle"></div>
                                   <div class="circle"></div>
                                 </div>
                               </button>

                              </div>

                           </div>
                         </div>
                            </form>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="Section5">

                        <form action="{{ route('dashboard.store_items') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                            <input type="hidden" name="lesson_id" value="{{ $lecture_id->lesson->id }}">
                            <input type="hidden" name="class_id" value="{{ $class_id }}">
                            <input type="hidden" name="room_id" value="{{ $room_id }}">
                            <input type="hidden" name="lecture_id" value="{{ $lecture_id->id }}">
                        <div class="container">
                          <div class="row">
                            <!--start card-->
                            <input hidden type="text" name="type" value="1" >
                            <div class="col-md-6 newrow">
                             <div class="card13">
                                <span style="color: #444bba;text-align: center;"></span>
                               <div class="Group" style="justify-content: right;">
                                  <label style="text-align: right;">اسم الوظيفة</label>
                                  <input name="namehomework"  type="text" class="form-control" placeholder="ادخل اسم الملف ">
                               </div>
                             </div>

                            </div>
                            <!--end card-->
                            <div class="col-md-6 newrow">
                             <div class="card13">
                                <span style="color: #444bba;text-align: center;"></span>
                               <div class="Group" style="justify-content: right;">
                                  <label style="text-align: right;">اضافة رابط خارجي</label>
                                  <input name="test_link" type="text" class="form-control" placeholder="اضافة رابط خارجي">
                               </div>
                             </div>

                            </div>
                            <!--end card-->
                             <!--end card-->
                             <div class="col-md-6 newrow">
                              <div class="card13">
                                 <span style="color: #444bba;text-align: center;"></span>
                                <div class="Group" style="justify-content: right;">
                                   <label style="text-align: right;">بداية الوقت</label>
                                   <input  name="test_start_time" type="datetime-local" required  class="form-control dateinput" placeholder="اضافة رابط خارجي">
                                </div>
                              </div>

                             </div>
                             <!--end card-->
                              <!--end card-->
                              <div class="col-md-6 newrow">
                                <div class="card13">
                                   <span style="color: #444bba;text-align: center;"></span>
                                  <div class="Group" style="justify-content: right;">
                                     <label style="text-align: right;">نهاية الوقت</label>
                                     <input name="test_end_time" type="datetime-local"  required  class="form-control dateinput" placeholder="اضافة رابط خارجي">
                                  </div>
                                </div>

                               </div>
                               <!--end card-->
                                <div class="col-md-6 newrow">
                             <div class="card13">
                                <span style="color: #444bba;text-align: center;"></span>
                               <div class="Group" style="justify-content: right;">
                                  <label style="text-align: right;">علامة الوظيفة  </label>
                                  <input name="mark" type="number" class="form-control" placeholder="علامة الوظيفة ">
                               </div>
                             </div>

                            </div>
                               <div class="col-md-6 newrow">
                                <div class="card13">
                                <span style="color: #444bba;text-align: center;"></span>
                                  <div class="Group" style="justify-content: right;">
                                     <label style="text-align: right;">تحميل ملف</label>
                                     <label for="file-input" class="drop-container">
                                        <span class="drop-title">
                                           <br>
                                           <br>
                                        </span>
                                        <input type="file" name="test"  id="file-input">
                                      </label>

                                  </div>
                                </div>
                               </div>
                            <!--div class="col-md-6 newrow">
                             <form class="form">
                               <span class="form-title" style="text-align: right;">تحميل ملف</span>

                            <label for="file-input" class="drop-container">
                               <span class="drop-title">
                                  <br>
                                  <br>
                               </span>
                               <input type="file" name="test"  accept="file_extension/*"  id="file-input">
                             </label>
                             </form>
                            </div-->

                          </div><!--end row-->
                         <div class="row" style="justify-content: center;padding-top: 20px;">
                            <div class="col-md-3">
                             <button class="btn" type="submit">
                               <strong>حفظ </strong>
                               <div id="container-stars">
                                 <div id="stars"></div>
                               </div>

                               <div id="glow">
                                 <div class="circle"></div>
                                 <div class="circle"></div>
                               </div>
                             </button>

                            </div>

                         </div>
                       </div>
                        </form>
                    </div>

                    </div>
                </div><!--end tab-->

            </div>
        </div>
    </div>
       <!--end content-->
    </div><!--end content-wrapper pb-0-->

  </div><!--end main panels-->

    <!-- container-scroller -->

@endsection
@section('js')
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
@endsection
