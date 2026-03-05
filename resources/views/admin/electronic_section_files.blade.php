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
    <a href="#" class="breadcrumbs__item is-active">ملفات المكتبة</a>
    <a href="{{route('electronic_section')}}"  class="breadcrumbs__item ">المكتبة الالكترونية</a>
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
            <form method="POST" action=""  enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>

                    <h4 class="modal-title">تعديل المعلومات</h4>

                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="news_id" value="">

                    <div class="form-group">
                        <label>اسم الموظف</label>
                        <input type="text" name="name" id="name"  class="form-control a" style="direction:rtl"
                            value=""
                            placeholder=" اسم الموظف">
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label>عنوان الملف</label>
                        <input type="text" name="link"  id="link"  class="form-control a" style="direction:rtl" value="" placeholder="   رابط الملف المرفوع" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <a class="btn btn-dark text-light" data-dismiss="modal">الغاء</a>&nbsp;&nbsp;
                    <button class="btn btn-primary">حفظ</button>
                </div>

                </div>

            </form>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('add_electronic_file', $electronic_sections->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h2 class="modal-title" id="exampleModalLabel">اضافة ملف للقسم</h2>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="staf_id" value="{{ $electronic_sections->id }}">
                    <div class="form-group">
                        <label>عنوان الملف</label>
                        <input type="text" name="file_name" class="form-control a" style="direction:rtl" value="" placeholder="   عنوان الملف المرفوع" required>
                    </div>
                    <br>

                    <div class="form-group">
                        <label>اختر نوع الملف</label>
                        <select name="file_type" id="file_type" class="form-control">
                            <option value=""></option>
                            <option value="file">ملف</option>
                            <option value="link">رابط</option>
                        </select>
                    </div>
                    <div class="form-group" id="file_input_group" style="display: none;">
                        <label>ملف القسم</label>
                        <input  type="file" name="file" class="form-control"   >
                    </div>

                    <div class="form-group" id="link_input_group" style="display: none;">
                        <label>رابط الملف</label>
                        <input type="text" name="link" class="form-control a" style="direction: rtl" value="" placeholder="   رابط الملف المرفوع">
                    </div>
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
            <h1 style="text-align: center;color: #001586">ملفات {{$electronic_sections->name_section}}</h1>
        </div>
         @can('add_file_electronic_section')
        <button type="button" class="btn mb-1 btn-success" data-toggle="modal" data-target="#create_teacher" style="font-size: 25px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3">اضافة ملف</button>
           @endcan

        <div class="">
            <!-- Table -->
<table class="table align-items-center" id="table_xx">
    <thead style="color: black">
        <tr>
            <th scope="col" class="sort" data-sort="name">عنوان الملف</th>
            <th scope="col" class="sort" data-sort="budget">ملف القسم</th>
            <th scope="col" class="sort" data-sort="budget">عمليات التعديل</th>
        </tr>
    </thead>
    <tbody class="list" id="mydiv">
        @foreach ($electronic_files  as $item)
        <tr>
            <td>{{$item->file_name}}</td>
            <td style="width: 100px;">
                @if (!empty($item->link))
                    {{ $item->link }}
                @else
                    <a href="{{ asset('website/assets/files/' . $item->file) }}" target="_blank" style="color: #b4b3e6">
                        <i class="fa fa-file" style="font-size: 30px"></i>
                    </a>
                @endif
            </td>

            <td>
                <!--<a style="padding: 8px 14px!important;" class="edit_news btn btn-success btn-sm" href=".editNewsModal" data-toggle="modal">تعديل</a>-->
                @can('delete_file_electronic_section')
                            <a href=".deletelessonModal" class="btn btn-danger delete"
                    data-id="{{ $item->id }}"  data-toggle="modal" >
                        حذف
                    </a>
                      @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

        </div>
    </div>
</div>

<div class="modal fade deletelessonModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_delete"  action="{{route('delete_electronic_file')}}" method="POST"  autocomplete="off">

                @csrf
                <input type="hidden" name="id" id="lesson_id_delete" required>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">حذف  الملف</h4>
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
    $(document).ready(function() {
        // Handle select change event
        $('#file_type').change(function() {
            var selectedOption = $(this).val();

            // Show/hide the corresponding input field
            if (selectedOption === 'file') {
                $('#file_input_group').show();
                $('#link_input_group').hide();
                $('input[name="file"]').prop('required', true); // Set the "required" attribute on file input
                $('input[name="link"]').prop('required', false); // Remove the "required" attribute from link input
            } else if (selectedOption === 'link') {
                $('#file_input_group').hide();
                $('#link_input_group').show();
                $('input[name="file"]').prop('required', false); // Remove the "required" attribute from file input
                $('input[name="link"]').prop('required', true); // Set the "required" attribute on link input
            }
        });

        // Handle form submission
        // $('form').submit(function(e) {
        //     var fileType = $('#file_type').val();

        //     // If file is selected and the file type is "file", perform additional validation
        //     if (fileType === 'file' && $('input[name="file"]').get(0).files.length === 0) {
        //         e.preventDefault(); // Prevent form submission
        //         alert('Please select a file.'); // Show an error message
        //     }
        // });
        
    });
</script>
<script>
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#lesson_id_delete').val(id);
});

$(document).on('click','.edit_news',function(e){
var id=$(this).data('id');
e.preventDefault();
var file =$(this).data('file');

$('#news_id').val(id);
$('#name').val($(this).data('name'));
$('#file_title').val($(this).data('file_title'));
$('#link').val($(this).data('link'));

if (file!="") {
    $('#file').attr('src',`{{ asset('storage/${file}') }}`);
}


});


</script>

@endsection
