@extends('admin.master')

@section('style')
<style>
    *{
        direction: rtl !important;
        /* text-align: center; */
    }
    button,a{
        color: rgb(255, 255, 255) ;
    }
    .form-group{
        text-align: right;
    }
    label{
        font-size: 20px;
        color: black;
    }
    input{
        font-size: 17px !important;
    }
    th{
        font-size: 20px;
        border: 0px  !important;
        text-align: center !important;
    }
    td{
        font-size: 17px;
        color: black;
        border: 0px !important;
        text-align: center;
    }
    tr{
        border-bottom: 1px solid #008991 !important;
        border-top: 1px solid #008991 !important;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    .form-group{
        margin: 0px !important;
    }
    #table_xx_wrapper{
    overflow: auto;
}
.modal-title {
    margin-bottom: 0;
    line-height: 1.5;
    margin: auto;
    padding-left: 90PX;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">المكتبة الالكترونية</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@php
$about = \App\About_us::find(1);
@endphp



<div class="modal fade editNewsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{route('electronic_section_update')}}"  enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                    <h4 class="modal-title">تعديل المعلومات</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="news_id" value="">
                    <input type="hidden" name="class_id" id="class_id" value="">
                    <div class="form-group">
                        <label> اختر الصف</label>
                        <select  required  name="class_id" id="class_id1" class="form-control" >
                            <option value="0">  اختر الصف   </option>
                            @foreach ($classes as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>اسم القسم</label>
                        <input type="text" required name="name_section" id="name_section"  class="form-control a" style="direction:rtl"
                            value=""
                            placeholder=" اسم القسم">
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-dark text-light" data-dismiss="modal">الغاء</a>&nbsp;&nbsp;
                    <button class="btn btn-primary">حفظ</button>
                </div>
                </div>
            </form>
        </div>
    </div>




<div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('electronic_section_store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>

                    <h2 class="modal-title" id="exampleModalLabel">اضافة قسم </h2>

                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label> اختر الصف</label>
                        <select  required name="class_id" id="classes_select" class="form-control" >
                            <option value="0">  اختر الصف  </option>
                            @foreach ($classes as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>اسم القسم</label>
                        <input type="text" name="name_section" class="form-control a" style="direction:rtl"
                            value=""
                            placeholder=" اسم القسم" required>
                    </div>
                    <br>
                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول اقسام المكتبة الالكترونية</h1>
        </div>
         @can('create_electronic_section')
        <button type="button" class="btn mb-1 btn-success" data-toggle="modal" data-target="#create_teacher" style="font-size: 25px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3">إنشاء قسم </button>
        @endcan
        <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                <tr>
                    <th scope="col" class="sort" data-sort="budget">اسم القسم</th>
                    <th scope="col" class="sort" data-sort="budget">الصف</th>
                    <th scope="col" class="sort" data-sort="budget">عمليات التعديل</th>

                </tr>
                </thead>
                <tbody class="list" id="mydiv">
                 @foreach ($electronic_sections as $item)
                 <tr>
                 <td>{{$item->name_section}}</td>
                 <td>@if ($item->classes)
                    {{$item->classes->name}}
                @endif</td>
                 <td>
                    @can('update_electronic_section')
                    <a style="padding: 8px 14px!important;" class="edit_news btn btn-success btn-sm"
                    data-name_section="{{ $item->name_section }}"
                    data-id="{{ $item->id }}"
                    data-class_id="{{ $item->classes ? $item->classes->id : '' }}"
                    href=".editNewsModal" data-toggle="modal">تعديل</i>
                    </a>
                       @endcan
                     @can('delete_electronic_section')
                    <a href=".deletelessonModal" class="btn btn-danger delete"
                    data-id="{{ $item->id }}"  data-toggle="modal" >
                        حذف
                    </a>
                       @endcan
                     @can('file_electronic_section')
                    <a href="{{ route('school_electronic_files', ['id' => $item->id]) }}" class="btn btn-danger delete">
                        ملفات القسم
                    </a>
                       @endcan

                 </td>
                 @endforeach
                </tbody>
                </table>



        </div>
    </div>
</div>

<div class="modal fade deletelessonModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_delete" action="{{route('electronic_section_delete')}}" method="POST"  autocomplete="off">

                @csrf
                <input type="hidden" name="id" id="lesson_id_delete" required>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">حذف  القسم</h4>
                        <p>هل انت متأكد من عملية الحذف  ؟</p>
                    </div>

                </div>
                <div class="modal-footer" style="justify-content: right;">
                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>&nbsp;&nbsp;
                    <button class="btn btn-danger">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
@section('js')

<script>
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#lesson_id_delete').val(id);
});

$(document).on('click','.edit_news',function(e){
var id=$(this).data('id');
var classId = $(this).data('class_id');
e.preventDefault();
var file =$(this).data('file');

$('#news_id').val(id);
$('#class_id').val(classId);
$('#name_section').val($(this).data('name_section'));
$('#class_id').val($(this).data('class_id'));
$('#class_id1').val($(this).data('class_id'));

});


</script>

@endsection
