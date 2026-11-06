@extends('teachers2.layouts.app')
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
    <link rel="stylesheet" href="{{ asset('assets/css/lesson-workspace.css') }}?v=20261106-layout2">
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/css/lesson-upload-selection.css') }}?v=20261106">
@endsection


@section('content')
@php($privateLessonContent = app(\App\Services\LessonContentFeature::class)->enabled())
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
<div class="main-panel lc-page lc-lesson-page" style="background: #f8f9fb;">
    @if ($errors->any() || session('message'))
        <div class="alert alert-danger m-3" role="alert" dir="rtl">
            @if (session('message'))<p class="mb-0">{{ session('message') }}</p>@endif
            @if ($errors->any())<ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
        </div>
    @endif
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
            <div class="col-12 lc-tabs-column">


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
                    <ul class="nav nav-tabs lc-tabs" role="tablist">
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

                            <form class="lc-entry-form" action="{{ route('dashboard.store_items') }}" method="post" enctype="multipart/form-data" @if ($privateLessonContent) data-lesson-manage @endif>
                                @csrf
                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                <input type="hidden" name="lesson_id" value="{{ $lecture_id->lesson->id }}">
                                <input type="hidden" name="class_id" value="{{ $class_id }}">
                                <input type="hidden" name="room_id" value="{{ $room_id }}">
                                <input type="hidden" name="lecture_id" value="{{ $lecture_id->id }}">
                                <input hidden type="text" name="type" value="4" >
                                @if ($privateLessonContent)
                                    <input type="hidden" name="upload_token" value="{{ old('upload_token', (string)\Illuminate\Support\Str::uuid()) }}">
                                    <input type="hidden" name="attachment_count" value="">
                                @endif
                            <div class="container">
                               <div class="row">
                                 <!--start card-->
                                 <div class="col-md-6 newrow">
                                  <div class="card13">
                                     <span style="color: #444bba;text-align: center;"></span>
                                    <div class="Group" style="justify-content: right;">
                                       <label for="lc-name_addition">اسم الملف</label><input id="lc-name_addition" name="name_addition" type="text" class="form-control" placeholder="ادخل اسم الملف " @if ($privateLessonContent) maxlength="500" value="{{ old('name_addition') }}" @endif>
                                    </div>
                                  </div>

                                 </div>
                                 <!--end card-->
                                 <div class="col-md-6 newrow">
                                  <div class="card13">
                                     <span style="color: #444bba;text-align: center;"></span>
                                    <div class="Group" style="justify-content: right;">
                                       <label for="lc-addition_link">اضافة رابط خارجي</label><input id="lc-addition_link" name="addition_link" inputmode="url" dir="ltr" type="text" class="form-control" placeholder="اضافة رابط خارجي" @if ($privateLessonContent) maxlength="2048" value="{{ old('addition_link') }}" @endif>
                                    </div>
                                  </div>

                                 </div>
                                 <!--end card-->
                                 <div class="col-md-6 newrow lc-upload-field" data-files-label="الملفات المحددة:" data-remove-label="إزالة" data-reselect-label="تعذر إزالة الملف. يرجى إعادة اختيار الملفات المطلوبة.">
                                    <div class="card13">
                                        <span style="color: #444bba;text-align: center;"></span>
                                          <div class="Group" style="justify-content: right;">
                                             <label style="text-align: right;">تحميل ملف</label>
                                             <label for="lc-addition" class="drop-container">
                                                <span class="drop-title">
                                                   <br>
                                                   <br>
                                                </span>
                                                <input type="file" data-lesson-file-picker name="{{ $privateLessonContent ? 'attachments[]' : 'addition' }}" @if ($privateLessonContent) multiple data-max-files="5" @endif id="lc-addition" aria-label="رفع ملف">
                                              </label>
                                             @if ($privateLessonContent)<small>خمسة ملفات كحد أقصى، 10 MiB لكل ملف و25 MiB للمجموع.</small>@endif

                                          </div>
                                        </div>
                                 </div>
                                @if ($privateLessonContent)
                                    <div class="newrow lc-upload-field">
                                        <label for="lc-content-note">ملاحظات للطلاب (اختياري)</label>
                                          <textarea class="form-control" id="lc-content-note" name="note" rows="5" maxlength="2000" aria-describedby="lc-content-note-help">{{ old('note') }}</textarea>
                                          <small id="lc-content-note-help">2000 حرف كحد أقصى. تظهر الملاحظات للطلاب المصرح لهم.</small>
                                    </div>
                                @endif
                               </div><!--end row-->
                              <div class="row lc-form-actions" style="justify-content: center;padding-top: 20px;">
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

                            <form class="lc-entry-form" action="{{ route('dashboard.store_items') }}" method="post" enctype="multipart/form-data">
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
                                      <label for="lc-name_audio">اسم مقطع الصوت</label><input id="lc-name_audio"  name="name_audio" type="text" class="form-control" placeholder="ادخل اسم الملف ">
                                   </div>
                                 </div>

                                </div>
                                <!--end card-->
                                <div class="col-md-6 newrow">
                                 <div class="card13">
                                    <span style="color: #444bba;text-align: center;"></span>
                                   <div class="Group" style="justify-content: right;">
                                      <label for="lc-audio_link">اضافة رابط خارجي</label><input id="lc-audio_link" name="audio_link" inputmode="url" dir="ltr" type="text" class="form-control" placeholder="اضافة رابط خارجي">
                                   </div>
                                 </div>

                                </div>
                                <!--end card-->
                                <div class="col-md-6 newrow lc-upload-field" data-files-label="الملفات المحددة:" data-remove-label="إزالة" data-reselect-label="تعذر إزالة الملف. يرجى إعادة اختيار الملفات المطلوبة.">
                                    <div class="card13">
                                        <span style="color: #444bba;text-align: center;"></span>
                                          <div class="Group" style="justify-content: right;">
                                             <label style="text-align: right;">تحميل ملف</label>
                                             <label for="lc-audio_file" class="drop-container">
                                                <span class="drop-title">
                                                   <br>
                                                   <br>
                                                </span>
                                                <input type="file" data-lesson-file-picker name="audio_file"    id="lc-audio_file" aria-label="تحميل مقطع صوتي">
                                              </label>

                                          </div>
                                        </div>
                                </div>
                              </div><!--end row-->
                             <div class="row lc-form-actions" style="justify-content: center;padding-top: 20px;">
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

                            <form class="lc-entry-form" action="{{ route('dashboard.store_items') }}" method="post" enctype="multipart/form-data">
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
                                    <label for="lc-name_video">عنوان الفيديو</label><input id="lc-name_video" type="text" name="name_video"  class="form-control" placeholder="ادخل اسم الملف ">
                                 </div>
                               </div>

                              </div>
                              <!--end card-->
                              <div class="col-md-6 newrow">
                               <div class="card13">
                                  <span style="color: #444bba;text-align: center;"></span>
                                 <div class="Group" style="justify-content: right;">
                                    <label for="lc-video">اضافة رابط خارجي</label><input id="lc-video" type="text" name="video" inputmode="url" dir="ltr"  class="form-control" placeholder="اضافة رابط خارجي">
                                 </div>
                               </div>

                              </div>
                              <!--end card-->
                              <div class="col-md-6 newrow lc-upload-field" data-files-label="الملفات المحددة:" data-remove-label="إزالة" data-reselect-label="تعذر إزالة الملف. يرجى إعادة اختيار الملفات المطلوبة.">
                                <div class="card13">
                                    <span style="color: #444bba;text-align: center;"></span>
                                      <div class="Group" style="justify-content: right;">
                                         <label style="text-align: right;">تحميل  مقطع الفيديو
                                          <span style="    display: contents;
                                            color: #8080805e;
                                            font-size: small;">لايمكن تحميل اكثر من 50M</span>
                                         </label>
                                         <label for="lc-video_in" class="drop-container">
                                            <span class="drop-title">
                                               <br>
                                               <br>
                                            </span>
                                            <input type="file" data-lesson-file-picker name="video_in"    id="lc-video_in" aria-label="تحميل مقطع فيديو">
                                          </label>

                                      </div>
                                    </div>
                              </div>
                            </div><!--end row-->
                           <div class="row lc-form-actions" style="justify-content: center;padding-top: 20px;">
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

                        <form class="lc-entry-form" action="{{ route('dashboard.store_items') }}" method="post" enctype="multipart/form-data">
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
                                  <label for="lc-namehomework">اسم الوظيفة</label><input id="lc-namehomework" name="namehomework"  type="text" class="form-control" placeholder="ادخل اسم الملف ">
                               </div>
                             </div>

                            </div>
                            <!--end card-->
                            <div class="col-md-6 newrow">
                             <div class="card13">
                                <span style="color: #444bba;text-align: center;"></span>
                               <div class="Group" style="justify-content: right;">
                                  <label for="lc-test_link">اضافة رابط خارجي</label><input id="lc-test_link" name="test_link" type="text" class="form-control" placeholder="اضافة رابط خارجي">
                               </div>
                             </div>

                            </div>
                            <!--end card-->
                             <!--end card-->
                             <div class="col-md-6 newrow">
                              <div class="card13">
                                 <span style="color: #444bba;text-align: center;"></span>
                                <div class="Group" style="justify-content: right;">
                                   <label for="lc-test_start_time">بداية الوقت</label><input id="lc-test_start_time"  name="test_start_time" type="datetime-local" required  class="form-control dateinput" placeholder="اضافة رابط خارجي">
                                </div>
                              </div>

                             </div>
                             <!--end card-->
                              <!--end card-->
                              <div class="col-md-6 newrow">
                                <div class="card13">
                                   <span style="color: #444bba;text-align: center;"></span>
                                  <div class="Group" style="justify-content: right;">
                                     <label for="lc-test_end_time">نهاية الوقت</label><input id="lc-test_end_time" name="test_end_time" type="datetime-local"  required  class="form-control dateinput" placeholder="اضافة رابط خارجي">
                                  </div>
                                </div>

                               </div>
                               <!--end card-->
                                <div class="col-md-6 newrow">
                             <div class="card13">
                                <span style="color: #444bba;text-align: center;"></span>
                               <div class="Group" style="justify-content: right;">
                                  <label for="lc-mark">علامة الوظيفة  </label><input id="lc-mark" name="mark" type="number" inputmode="decimal" class="form-control" placeholder="علامة الوظيفة ">
                               </div>
                             </div>

                            </div>
                               <div class="col-md-6 newrow lc-upload-field" data-files-label="الملفات المحددة:" data-remove-label="إزالة" data-reselect-label="تعذر إزالة الملف. يرجى إعادة اختيار الملفات المطلوبة.">
                                <div class="card13">
                                <span style="color: #444bba;text-align: center;"></span>
                                  <div class="Group" style="justify-content: right;">
                                     <label style="text-align: right;">تحميل ملف</label>
                                     <label for="lc-test" class="drop-container">
                                        <span class="drop-title">
                                           <br>
                                           <br>
                                        </span>
                                        <input type="file" data-lesson-file-picker name="test"  id="lc-test" aria-label="تحميل ملف الوظيفة">
                                      </label>

                                  </div>
                                </div>
                               </div>
                            <!--div class="col-md-6 newrow">
                             <form class="form">
                               <span class="form-title" style="text-align: right;">تحميل ملف</span>

                            <label for="lc-test" class="drop-container">
                               <span class="drop-title">
                                  <br>
                                  <br>
                               </span>
                               <input type="file" name="test"  accept="file_extension/*"  id="lc-test" aria-label="تحميل ملف الوظيفة">
                             </label>
                             </form>
                            </div-->

                          </div><!--end row-->
                         <div class="row lc-form-actions" style="justify-content: center;padding-top: 20px;">
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
<script src="{{ asset('teachers_2/assets/js/lesson-upload-selection.js') }}?v=20261106-groups"></script>
<script src="{{ asset('teachers_2/assets/js/lesson-content-management.js') }}?v=20261106"></script>
<script src="{{ asset('assets/js/lesson-workspace.js') }}?v=20261106-selection"></script>

@endsection
