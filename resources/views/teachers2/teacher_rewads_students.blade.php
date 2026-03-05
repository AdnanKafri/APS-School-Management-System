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
        <ul class="breadcrumbs" style="padding-bottom: 7px;
        padding-top: 11px;">
          <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
          <li class="li"><a href="{{route('teacher.teacher_rewads_and_sanction_class')}}">  المكافآت والعقوبات</a></li>
          <li class="li"><a href="{{route('teacher_rewads_and_sanction_subject',[$room->id,$teacher->id])}}">    المواد</a></li>
          <li class="li"><a href="#"> المكافآت </a></li>
    
       </ul>
        <div class="content-wrapper pb-0">
            <!--start content-->
            <div class="container" style="direction: rtl;">

                <div class="row">
                    @if (session()->has('error'))
                    <script>
                        window.onload = function () {
                            notif({
                                msg: "  تم حذف  المكافأة ",
                                type: "error"
                            })
                        }
                    </script>
                    @endif
                     @if (session()->has('Add'))
                    <script>
                        window.onload = function () {
                            notif({
                                msg: "  تم اضافة المكافأة ",
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
                                            اضافة  المكافأة
                                        </a>
                                        <!--end add question-->
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>اسم الطالب</th>
                                                <th> المكافأة</th>
                                                <th>   الصورة</th>
                                                <th>تاريخ المنح</th>
                                                <th>حذف</th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($rewads_students as $item)
                                                <tr>
                                                    <td class="py-1" id="exam1">
                                                        {{ $item->student->first_name }} {{ $item->student->last_name }}
                                                    </td>
                                                    <td>{{$item->rewad_and_sanction->name}}</td>
                                                   
                                                        <td class="py-1"><img src="{{ asset('storage/'.$item->rewad_and_sanction->image) }}"
                                                            id="image6" alt="Not found" width="50" alt=""></td>
                                                  

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
                                    <h4 style="color: #05579e;text-align: center; ">اضافة   مكافئة</h4>
                                    <form action="{{ route('teacher_rewads_students_store') }}" method="post" autocomplete="off"
                                        style="text-align: right;direction: rtl;">
                                        @csrf
                                        <input type="hidden" name="class_id" id="class_id" value="{{ $class->id }}">
                                        <input type="hidden" name="room_id" id="class_id" value="{{ $room->id }}">
                                        <input type="hidden" name="lesson_id" id="class_id" value="{{ $lesson->id }}">
                                        <input type="hidden" name="type" id="class_id" value="1">

                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group newselect">
                                                        <select class="form-control"name="rewad_and_sanction_id"
                                                            style="width: 100%;direction: rtl;padding-bottom: 18px;">
                                                            @foreach($rewads  as $rewad)
                                                            <option style="text-align: center;" value="{{$rewad->id}}">{{$rewad->name}}</option>
                                                            @endforeach
                                                           
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
<h5 class="modal-title" id="exampleModalLabel">حذف  المكافأة</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<form   action="{{ route('teacher_rewads_students_delete') }}" method="post">
 @csrf

</div>
<div class="modal-body" style="text-align: center;">
هل انت متاكد من عملية الحذف ؟
<input type="hidden" name="id" id="id" value="">
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
      
$('#delete_exam').on('show.bs.modal', function(event) {
var button = $(event.relatedTarget);
var id = button.data('exam_id');
var modal = $(this);

modal.find('.modal-body #id').val(id);
});

    </script>
@endsection
