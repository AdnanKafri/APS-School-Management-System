@extends('teachers2.layouts.app')
@section('css')
<style>
     /*responsive table*/
  /**/

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

  table th, table td {
    padding: .625em !important;
    text-align: center !important;
  }

  table th {
    font-size: 20px !important;

  }

  table td img { text-align: center; }
  @media screen and (max-width: 900px) {

  table { border: none !important; }


  table thead { display: none !important; }

  table tr {
    /*border-bottom: 3px solid #ddd!important ;*/
    border-bottom: none !important;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    display: block!important;
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
/*end responsiave table*/
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
.home {
    position: relative;
    /* margin: 0; */
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
    background-color: #152c4f;
    border-radius: 10px;
    color: #fff;
    font-weight: 300;
    font-size: 18px;
    font-family: inherit;
    z-index: 0;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.02, 0.01, 0.47, 1);
}
.Btn{
    margin: auto;
    width: 55px;
}
input[type="search" i]{
    width: 100% !important
}
</style>
@endsection
@section('content')
@if (session()->has('Add'))
<script>
    window.onload = function() {
        notif({
            msg: "تمت اضافة السؤال بنجاح ",
            type: "success"
        })
    }
</script>
@endif
<div class="main-panel" style="background: #f8f9fb;">
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
      <li class="li"><a href="{{ route('dashboard.teacher') }}"> الصفحة الرئيسية</a></li>
      <li class="li"><a href="{{ route('dashboard.teacher_rooms2',[$class->id,$teacher->id,$room_id,$lecture_id]) }}">اضافة محتوى</a></li>
      <li class="li"><a href="#">الاسئلة</a></li>

   </ul>
   {{-- حذف السؤال --}}
   <div class="modal fade" id="delete_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">حذف السؤال</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
               <form action="{{ route('dashboard.question.delete') }}" method="post">
                   @csrf
           </div>
           <div class="modal-body">
               هل انت متاكد من عملية الحذف ؟
               <input type="hidden" name="question_id" id="question_id" value="">
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
               <button type="submit" class="btn btn-danger">تاكيد</button>
           </div>
           </form>
       </div>
   </div>
</div>
   {{-- نهاية حذف السؤال --}}
    <div class="content-wrapper pb-0">
       <!--start content-->
        <div class="container" style="direction: rtl;">
           <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <!--select students-->
                 <div class="container" style="position: relative;top: -8px;padding-right: 200px;">
                  <div class="row">
                     <div class="col-md-4" style="left:210px">

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

                     </div>

                  </div>
                   <div class="row" style="padding-top: 30px;padding-bottom: 20px;">
                     <div class="col-md-5 newcol">

                      <div class="form-group newselect" style="width: 100%;">
                        <input hidden value="{{ $class->id }}" class="exam12">
                        <select class="choice js-example-basic-single" style="width: 100%;direction: rtl;">
                            <option value="0">اختر الدرس </option>
                            @foreach ($lectures as $item)
                                @if ($item->active == 1)
                                    <option value="{{ $item->id }}"> <del>{{ $item->name }}</del> </option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }} </option>
                                @endif
                            @endforeach
                        </select>

                      </div>
                     </div><!--end col-md-6-->
                    <div class="col-md-7 newcol2" style="left:30px">
                        <input hidden value="{{ $lesson_id }}" id="lesson_id">
                        <input hidden id="room_id" value="{{ $room_id }}">
                      <a href="{{ route('dashboard.teacher.exams', [$class->id, $lecture_id->id, $room_id]) }}" class="home">
                        <span>الاختبارات</span>
                      </a>
                        <a href="{{ route('dashboard.teacher.sections', [$class->id, $room_id, $lecture_id->id, $lesson_id]) }}" class="home">
                          <span>اضافة فقرة</span>
                        </a>
                        <a href="{{ route('dashboard.teacher.add_questions', [$class->id, $room_id, $lecture_id, $lesson_id]) }}" class="home">
                          <span>اضافة سؤال</span>
                        </a>
                    </div>
                   </div>

                 </div>


                  <!--end select students-->
                  <div class="table-responsive">
                    <table class="table1 table table-striped">
                      <thead>
                        <tr>
                          <th>السؤال </th>
                          <th>الجواب</th>
                    
                          <th>الدرس</th>
                          <th>العلامة</th>
                          <th>ملاحظات</th>
                          <th>عمليات التعديل</th>


                        </tr>
                      </thead>
                      <tbody>
                        @php
                            $i = 0;
                        @endphp

                        @foreach ($questions as $question)
                            @php
                                $i++;
                            @endphp
                            <tr>
                                <td  data-label="السؤال" class="py-1">{{ $question->question_form }}</td>
                                @if (is_array(json_decode($question->answer)))
                                    <td>
                                        @foreach (json_decode($question->answer) as $item)
                                            {{ $item }} ,
                                        @endforeach

                                    </td>
                                @else
                                    <td data-label="الجواب" class="py-1">{{ $question->answer }}</td>
                                @endif
                              
                                <td data-label="الدرس" class="py-1" >{{ $question->lecture->name }} </td>
                                <td data-label="العلامة" class="py-1">{{ $question->mark }}</td>
                                <td data-label="ملاحظات" class="py-1">{{ $question->note }}</td>

                                <td data-label="التعديل" class="py-1">
                                    <a class="Btn" type="submit" href="{{ route('dashboard.question.edit', [$question->id, $room_id]) }}">
                                        <svg class="svg" viewBox="0 0 512 512">
                                        <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>
                                    </a>

                                </td>
                            </tr>
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
@endsection
@section('js')
        <script>
            $('#delete_question').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var question_id = button.data('question_id')
                var modal = $(this)
                modal.find('.modal-body #question_id').val(question_id);
            })
        </script>

        <script>
            var room_id = $('#room_id').val();
            $(document).on('keyup', '#search', function() {
                var lect = $('#search').val();
                var exam = $('.exam12').val();
                var lesson_id = $('#lesson_id').val();
                var data = {
                    "search": lect,
                    "exam": exam,
                    "lesson_id": lesson_id,
                }
                var url = "{{ URL::to('SMARMANger/dashboard/teacher/search') }}";
                $.ajax({
                    url: url,
                    data: data,
                    type: "get",
                    contentType: 'application/json',
                    success: function(data) {
                        if (data == 1) {
                            $('.lecq').append(`  <li> not found</li>`)
                        }
                        console.log(data);
                        $('.table1 tbody').empty();
                        $('.lecq').empty();
                        $.each(data, function(key, value) {

                            if (value.ques_type == 2) {
                                ww = "";
                                ww = value.answer;

                            } else {
                                var ww1 = [];
                                $.each(JSON.parse(value.answer), function(key, value1) {
                                    ww1.push(value1);

                                })
                            }
                if (value.ques_type == 2) {
                $('.table1 tbody').append(`  <tr >
                <td>${ value.question_form }</td>
                <td>${ww}</td>
                <td>${ value.classes.name }  </td>
                <td>${ value.lecture.name }  </td>
                <td>${ value.mark } </td>
                <td>${ value.note }</td>
                <td>
                    <a class="Btn" type="submit" href="{{ url('SMARMANger/dashboard/teacher/questions/edit') }}/${value.id}/${room_id}">
                                <svg class="svg" viewBox="0 0 512 512">
                                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>
                    </a>
                </td>
                </tr>`)
                } else {
                $('.table1 tbody').append(`  <tr >
                <td>${ value.question_form }</td>
                <td>${ww1}</td>
                <td>${ value.classes.name }  </td>
                <td>${ value.lecture.name }  </td>
                <td>${ value.mark } </td>
                <td>${ value.note }</td>
                <td>
                    <a class="Btn" type="submit" href="{{ url('SMARMANger/dashboard/teacher/questions/edit') }}/${value.id}/${room_id}">
                                        <svg class="svg" viewBox="0 0 512 512">
                                        <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>
                                    </a>

                </td>
                </tr>`)
                }
                });
                },
                error: function(xhr) {
                    }
                })
            })

            $(document).on('change', '.choice', function() {
                var class_id = $('.exam12').val();

                var lesson_id = $('#lesson_id').val();

                var lect = $(this).val();
                var exam = $('.exam12').val();
                var data = {
                    "class_id": class_id,
                    "lesson_id": lesson_id,

                }
                $('.lecq').empty();
                var url = "{{ URL::to('SMARMANger/dashboard/teacher/lecquestion') }}/" + lect + "/" + exam;
                $.ajax({
                    url: url,
                    data: data,
                    type: "get",
                    contentType: 'application/json',
                    success: function(data) {
                        if (data == 1) {
                            $('.lecq').append(`  <li> not found</li>`)
                        }
                        console.log(data);
                        $('.table1 tbody').empty();
                        $('.lecq').empty();

                        $.each(data, function(key, value) {

                            if (value.ques_type == 2) {
                                ww = "";
                                ww = value.answer;

                            } else {
                                var ww1 = [];
                                $.each(JSON.parse(value.answer), function(key, value1) {
                                    ww1.push(value1);

                                })
                            }
                            if (value.ques_type == 2) {
                $('.table1 tbody').append(`
                <tr >
                <td>${ value.question_form }</td>
                <td>${ww}</td>
                <td>${ value.classes.name }  </td>
                <td>${ value.lecture.name }  </td>
                <td>${ value.mark } </td>
                <td>${ value.note }</td>
                <td>
                    <a class="Btn" type="submit" href="{{ url('SMARMANger/dashboard/teacher/questions/edit') }}/${value.id}/${room_id}">
                                        <svg class="svg" viewBox="0 0 512 512">
                                        <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>
                    </a>

                   </td>
            </tr>`)
                            } else {
                                $('.table1 tbody').append(`  <tr >
                <td>${ value.question_form }</td>
                <td>${ww1}</td>
                <td>${ value.classes.name }  </td>
                <td>${ value.lecture.name }  </td>
                <td>${ value.mark } </td>
                <td>${ value.note }</td>

                <td>
                    <a class="Btn" type="submit" href="{{ url('SMARMANger/dashboard/teacher/questions/edit') }}/${value.id}/${room_id}">
                        <svg class="svg" viewBox="0 0 512 512">
                        <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>
                    </a>
                   </td>
            </tr>`)
                            }

                        });
                    },
                    error: function(xhr) {
                    }

                });
            })


        </script>
        @endsection
