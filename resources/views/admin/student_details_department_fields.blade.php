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
.content-body{
        min-height: 0px !important;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active"> تفاصيل القسم </a>
    <a href="{{ route('student_details_department') }}" class="breadcrumbs__item "> الاقسام  </a>
    <a href="{{ route('students') }}" class="breadcrumbs__item ">شؤون الطلاب  </a>
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



<div class="modal fade editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{route('student_details_department_fields_update')}}"  enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>

                    <h4 class="modal-title">تعديل المعلومات</h4>

                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="section_id" value="">

                    <div class="form-group">
                        <label>اسم   الحقل </label>
                        <input type="text" name="name" id="name_section"  class="form-control a" style="direction:rtl"
                            value=""
                            placeholder=" اسم   الحقل  ">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>  نوع الحقل  </label>

                        <select class="form-control type1" required  id="type"  style="width: 100%;" name="type" >
                            <option value="">حدد  النوع </option>
                            <option value="1"> نص   </option>
                            <option value="2"> تاريخ    </option>
                            <option value="3"> اختيار    </option>
                            <option value="4"> صورة    </option>
                       
                        </select>


                    </div>
                        <div id="type_filde1">
                       
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




<div class="modal fade" id="create_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('student_details_department_fields_store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>

                    <h2 class="modal-title" id="exampleModalLabel">اضافة   حقل   </h2>
                    <input type="hidden" name="student_details_department_id"  value="{{$student_details_department_id}}">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم   الحقل  </label>
                        <input type="text" name="name" class="form-control a" style="direction:rtl"
                            value=""
                            placeholder=" اسم  الحقل " required>
                    </div>
                    <div class="form-group">
                        <label>  نوع الحقل  </label>

                        <select class="form-control type " required  style="width: 100%;" name="type" >
                            <option value="">حدد  النوع </option>
                            <option value="1"> نص   </option>
                            <option value="2"> تاريخ    </option>
                            <option value="3"> اختيار    </option>
                            <option value="4"> صورة    </option>
                       
                        </select>
                        <div id="type_filde">
                       
                        </div>

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
            <h1 style="text-align: center;color: #001586">جدول   حقول الاقسام </h1>
        </div>
         @can('student_details_department_fields_store')
        <button type="button" class="btn mb-1 btn-success" data-toggle="modal" data-target="#create_section" style="font-size: 25px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3">إنشاء   حقل   </button>
          @endcan
        <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                <tr>
                    <th scope="col" class="sort" data-sort="budget">   اسم الحقل    </th>
                    <th scope="col" class="sort" data-sort="budget"> نوع  الحقل   </th>
                    <th scope="col" class="sort" data-sort="budget">  القسم   </th>
                    <th scope="col" class="sort" data-sort="budget">   الخيارات   </th>
              
                    <th scope="col" class="sort" data-sort="budget">عمليات التعديل</th>

                </tr>
                </thead>
                <tbody class="list" id="mydiv">
                 @foreach ($student_details_department_fields as $item)
                 <tr>
                 <td>{{$item->name}}</td>

                @if($item->type==1)
                <td> نص</td>
                @elseif($item->type==2)
                <td> تاريخ </td>
                @elseif($item->type==3)
                <td> خيارات </td>
                @elseif($item->type==4)
                <td>صورة</td>

                 @endif
                 <td>{{$item->student_details_department->name}}</td>
                 <td>
                     @if(isset($item->type_radio))
                     @foreach(json_decode($item->type_radio,true) as $item_radio)
                     
                     
                     {{$item_radio}} , 
                                          @endforeach
                     @endif
                     </td>
                 <td>
                     @can('student_details_department_fields_update')
                    <a style="padding: 8px 14px!important;" class="edit_section btn btn-success btn-sm"
                    data-name_section="{{ $item->name }}"
                    data-type="{{ $item->type }}"
                    data-type_radio="{{ $item->type_radio }}"
                    
                    data-id="{{ $item->id }}"
                    href=".editModal" data-toggle="modal">تعديل</i>
                    </a>
                    @endcan
                    @can('student_details_department_fields_delete')

                    <a href=".deletelessonModal"  class="btn btn-danger delete_field"
                    data-id="{{ $item->id }}"  data-toggle="modal" >
                        حذف
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
            <form id="form_delete" action="{{route('student_details_department_fields_delete')}}" method="POST"  autocomplete="off">

                @csrf
                <input type="hidden" name="id" id="id_delete" required>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">حذف    حقل </h4>
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



$(document).on('change', '.type', function () {
    $('#type_filde').empty();
    
    if($(this).val()==3){
        $('#type_filde').append(`
        <a  class="btn btn-primary add" style="color:white">   اضافة خيار  </a>
        <a  class="btn btn-primary delete" style="color:white">   حذف خيار  </a>
       
        <input id="type_filde_input" required name="type_radio[]" class="form-control type_filde_input" type="text">
      `);


    }
    else{
        $('#type_filde').empty();
    }

});
$(document).on('change', '.type1', function () {
    $('#type_filde1').empty();
    
    if($(this).val()==3){
        $('#type_filde1').append(`
        <a  class="btn btn-primary add1" style="color:white">   اضافة خيار  </a>
        <a  class="btn btn-primary delete1" style="color:white">   حذف خيار  </a>
       
        <input id="type_filde_input1" required name="type_radio[]" class="form-control type_filde_input1" type="text">
      `);


    }
    else{
        $('#type_filde').empty();
    }

});
$(document).on('click', '.add', function () {
    $('#type_filde').append(`

        <input id="type_filde_input"  required name="type_radio[]" class="form-control type_filde_input" type="text">
      `);

});
$(document).on('click', '.delete1', function () {
    $('.type_filde_input1').last().remove();

});
$(document).on('click', '.add1', function () {
    $('#type_filde1').append(`

        <input id="type_filde_input1"  required name="type_radio[]" class="form-control type_filde_input1" type="text">
      `);

});
$(document).on('click', '.delete', function () {
    $('.type_filde_input').last().remove();

});



$(document).on('click', '.delete_field', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#id_delete').val(id);
});

$(document).on('click','.edit_section',function(e){
var id=$(this).data('id');

e.preventDefault();

$('#type_filde1').empty();
$('#section_id').val(id);
$('#name_section').val($(this).data('name_section'));
$('#type').val($(this).data('type'));
if($(this).data('type_radio')){
    $('#type_filde1').append(`
        <a  class="btn btn-primary add1" style="color:white">   اضافة خيار  </a>
        <a  class="btn btn-primary delete1" style="color:white">   حذف خيار  </a>
      `);
 
    $.each($(this).data('type_radio'), function (key, value) {

        $('#type_filde1').append(`
      
        <input id="type_filde_input1" required name="type_radio[]" value="${value}" class="form-control type_filde_input1" type="text">
      `);
 

    })

}


$('#description').val($(this).data('description'));




});


</script>

@endsection
