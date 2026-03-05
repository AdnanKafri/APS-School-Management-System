@extends('teachers2.layouts.app')
@section('css')
    <style>
        a:hover {
            color: #fff;
            text-decoration: none;
        }
        .home{
            background-color: #14315C;
        }
        .modal-header .close{
            margin: -25px -26px -25px auto;
            margin-left: -24px;
        }
        .modal-title{
            left: 5px;
        }
    </style>
@endsection
@section('content')

    <div class="main-panel" style="background: #f8f9fb;">

        <div class="content-wrapper pb-0">
            <!--start content-->
            <div class="container" style="direction: rtl;">

                <div class="row">
                    @if (session()->has('error'))
                    <script>
                        window.onload = function () {
                            notif({
                                msg: "  تم حذف الوسام ",
                                type: "error"
                            })
                        }
                    </script>
                    @endif
                     @if (session()->has('Add'))
                    <script>
                        window.onload = function () {
                            notif({
                                msg: "  تم اضافة وسام ",
                                type: "success"
                            })
                        }
                    </script>
                    @endif
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">


                                <div class="row" style="justify-content: center;padding-bottom: 40px;">
                                    <div class="col-md-3">
                                        <!--start add question-->
                                        <a href="#" data-toggle="modal" data-target="#demoModal4" class="addquestion">
                                            اضافة وسام
                                        </a>
                                        <!--end add question-->
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>اسم الطالب</th>
                                                <th>الوسام</th>
                                                <th>تاريخ المنح</th>
                                                <th>حذف</th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($medal as $item)
                                                <tr>
                                                    <td class="py-1" id="exam1">
                                                        {{ $item->student->first_name }} {{ $item->student->last_name }}
                                                    </td>
                                                    @if ($item->medal == '1')
                                                        <td class="py-1"><img
                                                                src="{{ asset('teachers_2/icons/p-1.png') }}"
                                                                style="width: 50px;height:50px"></td>
                                                    @elseif ($item->medal == '2')
                                                        <td class="py-1"><img
                                                                src="{{ asset('teachers_2/icons/p-2.png') }}"
                                                                style="width: 50px;height:50px"></td>
                                                    @elseif ($item->medal == '3')
                                                        <td class="py-1"><img
                                                                src="{{ asset('teachers_2/icons/p-3.png') }}"style="width: 50px;height:50px">
                                                        </td>
                                                    @endif

                                                    <td class="py-1">
                                                        {{ $item->created_at }}
                                                    </td>
                                                    <td class="py-1"><a href="#" data-exam_id="{{ $item->id }}"
                                                        data-toggle="modal" data-target="#delete_exam">
                                                            <img src="{{ asset('teachers_2/icons/trash.png') }}"
                                                                alt="">
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
                    <!--end col-->
                    <!--modal for add -->
                    <!--start add lesson modal-->
                    <div class="modal fade auto-off"id="demoModal4" tabindex="-1" role="dialog"
                        aria-labelledby="demoModal" aria-hidden="true">
                        <div class="modal-dialog animated zoomInLeft modal-dialog-centered" role="document">
                            <div class="modal-content" style="padding-top: 50px !important;">
                                <div class="container-fluid">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        style="background-color: white !important;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 style="color: #05579e;text-align: center; ">اضافة وسام</h4>
                                    <form action="{{ route('medal_store') }}" method="post" autocomplete="off"
                                        style="text-align: right;direction: rtl;">
                                        @csrf
                                        <input type="hidden" name="class_id" id="class_id" value="{{ $class->id }}">
                                        <input type="hidden" name="room_id" id="class_id" value="{{ $room->id }}">
                                        <input type="hidden" name="lesson_id" id="class_id" value="{{ $lesson->id }}">

                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group newselect">
                                                        <select class="form-control"name="medal"
                                                            style="width: 100%;direction: rtl;padding-bottom: 18px;">
                                                            <option style="text-align: center;" value="1">ذهبي</option>
                                                            <option style="text-align: center;" value="2">فضي </option>
                                                            <option style="text-align: center;" value="3">برونزي
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group newselect">
                                                        <select class="form-control" name="student_id"
                                                            style="width: 100%;direction: rtl;padding-bottom: 18px;">
                                                            @foreach ($student as $itme)
                                                                <option style="text-align: center;"
                                                                    value="{{ $itme->id }} ">{{ $itme->first_name }}
                                                                    {{ $itme->last_name }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row" style="justify-content: center;">
                                                <div class="col-md-4">
                                                    <!--submit button-->
                                                    <button class="home" type="submit"
                                                        style="width:150px;left: 20px;">حفظ</button>
                                                    <!--end submit button-->
                                                </div>

                                            </div>

                                        </div>
                                        <!--end container-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal-->
                    <!--delete modal-->
                   {{-- <div class="modal fade" id="delete_exam" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog animated zoomInLeft modal-dialog-centered" role="document">
                            <div class="modal-content" style="padding-top: 50px !important;">
                                <div class="container-fluid">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        style="background-color: white !important;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 style="color: #05579e;text-align: center; ">حذف وسام</h4>
                                    <form action="{{ route('medal_delete') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="exam_id" id="exam_id" value="">
                                        <div class="container">
                                            <div class="row" style="justify-content: center">
                                                <div class="col-md-6">
                                                    <h5 style="position: relative;top:-40px">هل انت متأكد من عملية الحذف ؟</h5>
                                                </div>
                                            </div>
                                            <div class="row" style="justify-content: center;top:-20px">
                                                <button type="submit" class="home" data-dismiss="modal">الغاء</button>
                                                <button type="submit" class="home">تاكيد</button>
                                            </div>

                                        </div>
                                        <!--end container-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                    <div class="modal fade" id="delete_exam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">حذف  الوسام</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<form   action="{{ route('medal_delete') }}" method="post">
 @csrf

</div>
<div class="modal-body" style="text-align: center;">
هل انت متاكد من عملية الحذف ؟
<input type="hidden" name="exam_id" id="exam_id" value="">
</div>
<div class="modal-footer" style="justify-content: initial;">
<button type="button" class="button" data-dismiss="modal">الغاء</button>
<button type="submit" class="button">تاكيد</button>
</div>
</form>
</div>
</div>
</div>
                </div>

                    <!--end delete-->

                </div>
            </div>
            <!--end content-->
        </div>
        <!--end content-wrapper pb-0-->
    </div>
    <!--end main panels-->
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
         $(".edit").on("click", function (e) {
            $('.type').empty();
            var id= $(this).data('id');
            var name_exam= $(this).data('name');
            var name_quize= $(this).data('name_quize');
            var mark= $(this).data('mark');
            var peroid= $(this).data('peroid');
            var endtime= $(this).data('endtime');
            var starttime = $(this).data('starttime');
           var note = $(this).data('note');
            if(name_exam!=null){
                $('.name1').val(name_exam)
                $('.type').append(`<option style="text-align: center;" value="1">امتحان</option>`)

            }
            else{
                $('.name1').val(name_quize)
                $('.type').append(`<option style="text-align: center;" value="2">مذاكرة </option>`)
            }

            $('.mark').val(0)
            $('.peroid').val()
            $('.end').val()
            $('.start').val()
            $('.name').val()
            $('.mark').val(mark)
            $('.peroid').val(peroid)
            $('.end').val(endtime)
            $('.note').val(note)
            $('.start').val(starttime)
            $('.exam_id').val(id)


        })
$('#delete_exam').on('show.bs.modal', function(event) {
var button = $(event.relatedTarget);
var exam_id = button.data('exam_id');
var modal = $(this);

modal.find('.modal-body #exam_id').val(exam_id);
});

    </script>
@endsection
