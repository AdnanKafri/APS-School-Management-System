@extends('admin.master')
@section('style')

<style>
.custom-file-label{
display:none !important;
}
    .custom-file-label{
        display:none;
    }
    .pagination{
        justify-content: center !important;
    }
    th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
    color: black
    }
    td{
        font-size: 17px;
        border-bottom: 1px solid #008991 !important;
        color: black;
        text-align: center !important;
    }
    button.close{
    margin: 0px !important;
    padding: 0px !important;
    float: left !important;
}
.modal-header{
    direction: rtl;
}

</style>

@endsection

@section('breadcrumbs')


<nav class="breadcrumbs">
    <a  class="breadcrumbs__item ">قسم مذاكرات الشعبة </a>
    <a href="{{  route('classroom_exams',$class_id)}}"  class="breadcrumbs__item ">قسم الشعب </a>
    <a href="{{ route('classes.view.exams') }}" class="breadcrumbs__item ">قسم جدول الدوام والاختبارات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>
@endsection
@section('content')
@if (session()->has('success'))

<script>
    window.onload = function() {
        notif({
            msg: "   تم التخزين بنجاح  ",
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
                msg: `{{  $error }}`  ,
                type: "error"
            })
        }

    </script>
    @endforeach

@endif
<div class="col" style="direction:rtl;text-align:right">
    <div class="card" style="margin: 30px">
            <!-- Card header -->
            <div class="card-header border-0" style="">
              <h3 class="mb-0" style="text-align: center;color: #001586">جدول المذاكرات</h3>
              <br>

            </div>
               <div class="container">
                  <input type="hidden" id="room_id1" value="{{ $room_id }}">
    <div class="table-responsive" >
        @can('create_quize')
        <a href=".createRoomModal" class=" btn btn-success m-3" data-toggle="modal"
        data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء مذاكرة جديدة</i></a>
       @endcan
         <div class="row" style="margin-right:0px" >




                    <div class="col-12 col-lg-4">
                        <select  name="rooms" id="lesson_id_filter" class="form-control" >
                            <option value="0"> جميع   المواد  </option>
                              @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}"> {{ $lesson->name }} </option>
                            @endforeach
                        </select>
                    </div>
              </div>
              <table class="table align-items-center table-flush"  id="table_xx">
                <thead class="">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->

                    <th scope="col" class="sort" data-sort="status"> المادة</th>
                    {{-- <th scope="col" class="sort" data-sort="status">الصف</th> --}}
                    <th scope="col" class="sort" data-sort="status">الشعبة</th>
                 <th scope="col" class="sort" data-sort="budget">نوع المذاكرة </th>
                    <th scope="col" class="sort" data-sort="status"> تاريخ البداية</th>

                    <th scope="col" class="sort" data-sort="status"> الوقت</th>
                    <th scope="col" class="sort" data-sort="status"> العلامة</th>
                    <th scope="col" class="sort" data-sort="status"> المدة</th>

                    <!--<th scope="col" class="sort" data-sort="status">Image</th>-->

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($contents as $content)

               <tr>
                    <!--<th scope="row">-->
                    <!--{{$content->id}}-->
                    <!--</th>-->

                    <td class="budget">
                        {{$content->lesson->name}}
                    </td>



                <td class="budget">
                    {{$content->room->name}}
                </td>
                <td class="budget" style="font-weight:bold;font-size:15px">
                    {{$content->name}}
                </td>

                <td class="budget">
                    {{$content->start_date->format('d-m-Y')}}
                </td>
                <td class="budget">
                  {{$content->start_date->format('H:i')}}
                </td>

                <td class="budget">
                    {{$content->mark}}
                </td>
                <td class="budget">
                    {{$content->period}}
                </td>




                    <td class="">

                    {{-- <a href=".editroomModal" class="edit"  data-class1="{{ $quize->classes->id }}"
                    data-name="{{ $quize->name }}"  data-id="{{ $quize->id }}"  data-toggle="modal" >
                    <i class="ni ni-settings"></i>

                    </a> --}}
                @can('update_quize')
                    <a href=".updateContentModal" class=" btn btn-success m-3 updateContent"
                    data-toggle="modal" style="background: #001586 !important"
                    data-id="{{ $content->id }}" data-name="{{ $content->name }}" data-lesson_id="{{ $content->lesson_id }}"
                    data-room_id="{{ $content->room_id }}" data-start_date="{{ $content->start_date }}"
                    data-end_date="{{ $content->end_date }}" data-required_lectures="{{ $content->required }}"
                    data-mark="{{ $content->mark }}"  data-period="{{ $content->period }}" data-is_file="{{ $content->is_file }}"
                     data-question_picker="{{ $content->question_picker }}"
                     data-notes="{{ $content->notes }}"
                    ><i class="material-icons" data-toggle="tooltip">تعديل  </i></a>

                      @endcan
                  @can('delete_quize')
                      <a href=".deleteContentModal"  class="btn btn-warning deleteContent" style="color: white;background:  #0280b3;border-color: #0083FF"
                    data-toggle="modal"
                    data-id="{{ $content->id }}"
                    data-name="{{ $content->name }}" data-lesson_id="{{ $content->lesson_id }}"
                    >حذف</a>
                    @endcan


                    </td>



                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>

</div>




        </div>
    </div>






                <div class="modal fade editroomModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_update" action="{{ route('room_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="room_id" id="room_id">
                                <div class="modal-header">
                                    <h4 class="modal-title">تعديل الشعبة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>الاسم بالعربية</label>
                                        <input type="text" id="name" name="name" style="direction: rtl" class="form-control a"
                                            value=""
                                            placeholder="ضع اسما هنا" maxlength="30" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>





                <div class="modal fade createRoomModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('quize.store') }}"  enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">إنشاء مذاكرة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="my_room_id" class="form-control " value="{{ $room_id }}">
                                    <input type="hidden" name="class_id" class="form-control " value="{{ $class_id }}">

                                    <div class="form-group" style="text-align:right">
                                        <label>نوع المذاكرة (شفهية..) </label>
                                        <input type="text" name="content_name" class="form-control "
                                            value="" style="direction: rtl"
                                            placeholder="مثال:   تحريرية " required>
                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <label>  نوع المذاكرة</label>

                                        <select name="is_file" id="" class="form-control lesson_id"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="" hidden>حدد  نوع المذاكرة</option>
                                            <option value="0">مذاكرة مؤتمتة</option>
                                            <option value="1">مذاكرة تقليدية /* ملف */ </option>


                                        </select>

                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <label>  المادة</label>

                                        <select name="lesson_id" id="" class="form-control lesson_id"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر  المادة</option>

                                        @foreach ($lessons as $lesson)

                                        <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                        @endforeach

                                        </select>

                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <div class="row justify-space-between">
                                            {{-- <div class="col-md-3"
                                            style="background:#596fec;padding:7px 0  0 15px;
                                            border-radius:3px;margin-bottom:2px;position:relative">
                                                <label style="float:left ;color:#fff !important;margin:0 !important;
                                                position: absolute; right:5px"> كل الشعب &nbsp;<input type="checkbox" name="" id="" value=" "> </label>
                                            </div> --}}
                                            <div class="col-md-12">
                                                <label>  الشعبة</label>
                                            </div>
                                        </div>
                                        <select name="room_id[]" id="" class="form-control wide room_choosing"
                                            style="min-height: 36px;direction: rtl;
                                            width:100%;" required multiple>
                                            <option value="">اختر  الشعبة</option>
                                            <option value="0">كل الشعب  </option>

                                        @foreach ($rooms as $room)

                                        <option value="{{ $room->id }}"
                                            @if($room_id == $room->id )
                                                selected
                                            @endif>{{ $room->name }}</option>
                                        @endforeach

                                        </select>

                                    </div>

                                    <div class="form-group" style="text-align:right">
                                        <label for="">وقت البداية </label>
                                        <input   class="form-control "   type="datetime-local" name="start_date"  value=""   style="text-align: right;" required />
                                    </div>

                                    <div class="form-group" style="text-align:right">
                                        <label  for="">وقت النهاية </label>
                                        <input   class="form-control "   type="datetime-local" name="end_date"  value=""   style="text-align: right;" required />
                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <label  for="">العلامة   </label>
                                        <input   class="form-control "   type="number" name="mark"  value="" min="0"   style="text-align: right;" required />
                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <label  for="">المدة الزمنية  </label>
                                        <input   class="form-control "   type="number" name="period" min="0"  value=""   style="text-align: right;" required />
                                    </div>
                                    <div class="form-group" style="text-align:right;direction:rtl" >
                                        <label  for=""> المطلوب </label>
                                        <textarea class="form-control required_lectures" name="required_lectures" required id="" cols="30" rows="6"></textarea>
                                    </div>
                                    <div class="form-group" style="text-align:right" hidden>
                                        <label>   المسؤول عن وضع الأسئلة</label>

                                        <select name="question_picker" id="" class="form-control lesson_id"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="2" hidden>حدد  المسؤول عن وضع الأسئلة </option>
                                             <option value="1"> المشرف المدرسي</option>
                                            <option value="2">الاستاذ </option>


                                        </select>

                                    </div>
                                    <div class="form-group" style="text-align:right;direction:rtl" >
                                        <label  for=""> ملاحظات </label>
                                        <textarea class="form-control" name="notes" id="" cols="30" rows="2"></textarea>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-dark text-light" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade updateContentModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('quize.update') }}"  enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">تعديل مذاكرة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="room_id" class="form-control " value="{{ $room_id }}">
                                    <input type="hidden" name="quize_id" class="form-control quize_id" >

                                    <div class="form-group" style="text-align:right">
                                        <label> نوع المذاكرة (شفهية..)</label>
                                        <input type="text" name="content_name" class="form-control content_name"
                                            value="" style="direction: rtl"
                                            placeholder="مثال: مذاكرة تحريرية   " required>
                                    </div>
                                     <div class="form-group" style="text-align:right">
                                        <label>  نوع المذاكرة</label>

                                        <select name="is_file" id="" class="form-control is_file"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="" hidden>حدد  نوع المذاكرة</option>
                                            <option value="0">مذاكرة مؤتمتة</option>
                                            <option value="1">مذاكرة تقليدية /* ملف */ </option>


                                        </select>

                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <label>  المادة</label>

                                        <select name="lesson_id" id="" class="form-control lesson_id"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر  المادة</option>

                                        @foreach ($lessons as $lesson)

                                        <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                        @endforeach

                                        </select>

                                    </div>

                                    <div class="form-group" style="text-align:right">
                                        <label for="">وقت البداية </label>
                                        <input   class="form-control start_date"   type="datetime-local" name="start_date"  value=""   style="text-align: right;" required />
                                    </div>

                                    <div class="form-group" style="text-align:right">
                                        <label  for="">وقت النهاية </label>
                                        <input   class="form-control end_date"   type="datetime-local" name="end_date"  value=""   style="text-align: right;" required />
                                    </div>
                                    <div class="form-group" style="text-align:right">ً
                                        <label  for="">العلامة   </label>
                                        <input   class="form-control mark"   type="number" name="mark" min="0"  value=""   style="text-align: right;" required />
                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <label  for="">المدة الزمنية  </label>
                                        <input   class="form-control period"   type="number" name="period" min="0"  value=""   style="text-align: right;" required />
                                    </div>
                                    <div class="form-group" style="text-align:right;direction:rtl" >
                                        <label  for=""> المطلوب </label>
                                        <textarea class="form-control required_lectures" name="required_lectures" required id="" cols="30" rows="6"></textarea>
                                    </div>
                                    <div class="form-group" style="text-align:right" hidden>
                                        <label>   المسؤول عن وضع الأسئلة</label>

                                        <select name="question_picker" id="" class="form-control question_picker"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="2" hidden>حدد  المسؤول عن وضع الأسئلة </option>
                                            <option value="1"> المشرف المدرسي</option>
                                            <option value="2">الاستاذ </option>


                                        </select>

                                    </div>
                                    <div class="form-group" style="text-align:right;direction:rtl" >
                                        <label  for=""> ملاحظات </label>
                                        <textarea class="form-control notes" name="notes" id="" cols="30" rows="2"></textarea>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-dark text-light" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade deleteContentModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('exam_quize.delete') }}"  enctype="multipart/form-data">
                                @csrf

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: #f00">حذف المذاكرة</h4>
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="room_id" class="form-control " value="{{ $room_id }}">
                                    <input type="hidden" name="content_id" class="form-control quize_id" >

                                    <div class="form-group" style="text-align:right">
                                        <label> نوع المذاكرة (شفهية..)</label>
                                        <input type="text" class="form-control content_name"
                                            value="" style="direction: rtl"
                                            placeholder="مثال: مذاكرة تحريرية   " readonly>
                                    </div>
                                    {{-- <div class="form-group" style="text-align:right">
                                        <label>  المادة</label>

                                        <select name="lesson_id" id="" class="form-control lesson_id"
                                            style="min-height: 36px;direction: rtl" disabled>
                                            <option value="">اختر  المادة</option>

                                        @foreach ($lessons as $lesson)

                                        <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                        @endforeach

                                        </select>

                                    </div> --}}
                                    <div class="form-group" style="text-align:right">
                                        <label style="font-size: 18px; font-weight:bold"> أدخل كود الحذف للتأكيد </label>


                                        <input type="password" style="direction:rtl" id="delete_code" name="delete_code" class="form-control a"

                                            placeholder="أدخل كود الحذف  "  required>
                                    </div>




                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-dark text-light" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-danger">تأكيد</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end delete quize -->

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>


@endsection

@section('js')

<script>
$('#table_xx').DataTable();
    $(document).on('click', '.updateContent', function () {
    var quize_id = $(this).data('id');
    var name=$(this).data('name');
    var is_file=$(this).data('is_file');
    var lesson_id=$(this).data('lesson_id');
    var room_id=$(this).data('room_id');
    var start_date=$(this).data('start_date');
    var end_date=$(this).data('end_date');
    var mark=$(this).data('mark');
    var period=$(this).data('period');
    var required_lectures=$(this).data('required_lectures');
    var question_picker=$(this).data('question_picker');
    var notes=$(this).data('notes');
        console.log(start_date);
    $('.quize_id').val(quize_id);
    $('.content_name').val(name);
    $('.is_file').val(is_file);
    $('.lesson_id').val(lesson_id);
    $('.start_date').val(start_date);
    $('.end_date').val(end_date);
    $('.mark').val(mark);
    $('.period').val(period);
    $('.required_lectures').val(required_lectures);
    $('.question_picker').val(question_picker);
    $('.notes').val(notes);
});
$(document).on('click', '.deleteContent', function () {
    var quize_id = $(this).data('id');
    var name=$(this).data('name');
    // var lesson_id=$(this).data('lesson_id');

    $('.deleteContentModal .quize_id').val(quize_id);
    $('.deleteContentModal .content_name').val(name);
    // $('.deleteContentModal .lesson_id').val(lesson_id);

});
 function formatDate(timestamp) {
    return moment(timestamp).format('HH:mm');
}
 function formatDate1(timestamp) {
    return moment(timestamp).format('DD-MM-YYYY');
}
$('#table_xx').DataTable();

    $('#lesson_id_filter').change(function () {

        var url = "{{ URL::to('SMT/admin/quize_filter_search') }}/";
if ($.fn.DataTable.isDataTable('#table_xx')) {
                                $('#table_xx').DataTable().destroy();
                                }
                                $('#table_xx tbody').empty();
$.ajax({
    url: url,

     data:  {

                room_id1 : $('#room_id1').val(),
                lesson_id : $('#lesson_id_filter').val()
            },
     type: "get",
    contentType: 'application/json',
    success: function (data) {
        console.log(data);
        $.each(data, function (key, value) {
            var date = new Date(value.start_date);

            $('#table_xx tbody').append(`<tr>
                <td class="budget">
                 ${value.lesson.name}

                </td>

                <td class="budget">
                 ${value.room.name}

                </td>

                <td class="budget" style="font-weight:bold;font-size:15px">
                   ${value.name}
                </td>
                <td class="budget">
                ${formatDate1(date)}

                </td>
                <td class="budget">
                 ${formatDate(date)}


                </td>
                <td class="budget" style="font-weight:bold;font-size:15px">
                   ${value.mark}
                </td>
                <td class="budget" style="font-weight:bold;font-size:15px">
                   ${value.period}
                </td>
                   <td>
                      @can('update_exam')
                    <a href=".updateContentModal" class=" btn btn-success m-2 updateContent"
                    data-toggle="modal" style="background: #001586 !important"
                    data-id="${value.id}" data-name="${value.name}" data-lesson_id="${value.lesson_id}"
                    data-room_id="${value.room_id}"
                    data-start_date="${value.start_date}"
                    data-end_date="${value.end_date}" data-required_lectures="${value.required}"
                    data-mark="${value.mark}" data-period="${value.period}"
                    data-notes=" ${value.note}"  data-is_file="${value.is_file}"
                    data-question_picker="${value.question_picker}"
                    ><i class="material-icons" data-toggle="tooltip">تعديل  </i></a>
                      @endcan
                    @can('delete_exam')
                    <a href=".deleteContentModal"  class="btn btn-warning deleteContent" style="color: white;background:  #0280b3;border-color: #0083FF"
                    data-toggle="modal"
                    data-id="${value.id}"
                    data-name="${value.name}" data-lesson_id="${value.lesson_id}"
                    >حذف</a>
                     @endcan
                   </td>


                  </tr>`)
            })

        $('#table_xx').DataTable();
    },


});






    })
$('.room_choosing').select2();

</script>
@endsection
