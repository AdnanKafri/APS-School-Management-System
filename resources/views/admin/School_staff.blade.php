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
    <a  class="breadcrumbs__item is-active">موظفو المدرسة</a>
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
            <form method="POST" action="{{route('school_staf_update')}}"  enctype="multipart/form-data">
                @csrf
<input type="hidden" id="staff_id" name="id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>

                    <h4 class="modal-title">تعديل المعلومات</h4>

                </div>
                <div class="modal-body">
 
         
         
               <div class="form-group">
                            <label>الاسم الأول</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control a" value="" placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                        </div>

                        <div class="form-group">
                            <label>الكنية</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control b" value="" placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required="">
                        </div>


                        <div class="form-group">
                            <label>تاريخ الولادة</label>
                            <input type="date" name="birth_date" id="edit_birth_date" class="form-control b" value="" style="direction:rtl" placeholder="Type last name">
                        </div>

                        <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" name="address" id="edit_address" class="form-control b" value="" maxlength="100" placeholder="اكتب العنوان" style="direction:rtl">
                        </div>

                        <div class="form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control b" value="" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                        </div>


                        
                        <div class="form-group">
                            <label>الراتب</label>
                            <input type="number" name="salary" id="edit_salary" class="form-control b" value="" placeholder="ادخل الراتب" style="direction:rtl" >
                        </div>
                         <div class="form-group">
                            <label> المنصب الوظيفي</label>
                            <input type="text" name="position" id="position" class="form-control b" value="" placeholder="ادخل  المنصب" style="direction:rtl" >
                        </div>
                        
            <div class="form-group">
                            <label>الأمراض التي يعاني منها</label>
                            <textarea cols="30" row="10" name="diseases" id="edit_diseases" class="form-control">
                             
                            </textarea>
                             
                         </div>
                       
                       
            <div class="form-group">
                            <label>سجل الأعمال</label>
                            <textarea cols="30" row="10" style="height:100px!important" name="edit_business_register" id="edit_business_register" class="form-control">
                             
                            </textarea>
                             
                         </div>
                         
                        


                          <div class="form-group">
                                <label for="edit_image">الصورة الشخصية </label>
                                <input type="file" name="image" id="edit_image" class="form-control" lang="ar">
                        </div>
                        
                        
                                   <div class="form-group">
                                <label for="edit_image">السيرة الذاتية </label>
                                <input type="file" name="cv" id="edit_cv" class="form-control" lang="ar">
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




<div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('add_school_staff')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>

                    <h2 class="modal-title" id="exampleModalLabel">اضافة موظف</h2>

                </div>
                <div class="modal-body">
             
                
               <div class="form-group">
                            <label>الاسم الأول</label>
                            <input type="text" name="first_name" class="form-control a" value="" placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                        </div>

                        <div class="form-group">
                            <label>الكنية</label>
                            <input type="text" name="last_name" class="form-control b" value="" placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required="">
                        </div>


                        <div class="form-group">
                            <label>تاريخ الولادة</label>
                            <input type="date" name="birth_date" class="form-control b" value="" style="direction:rtl" placeholder="Type last name">
                        </div>

                        <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" name="address" class="form-control b" value="" maxlength="100" placeholder="اكتب العنوان" style="direction:rtl">
                        </div>

                        <div class="form-group">
                           <label>الهاتف</label>
                           <input type="text" name="phone" id="edit_phone" class="form-control b" value="" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                        </div>

          
                        <div class="form-group">
                            <label>الراتب</label>
                            <input type="number" name="salary"   class="form-control b" value="" placeholder="ادخل الراتب" style="direction:rtl" >
                        </div>
                         <div class="form-group">
                            <label> المنصب الوظيفي</label>
                            <input type="text" name="position" class="form-control b" value="" placeholder="ادخل  المنصب" style="direction:rtl" >
                        </div>
                        
            <div class="form-group">
                            <label>الأمراض التي يعاني منها</label>
                            <textarea cols="30" row="10" name="diseases" class="form-control">
                             
                            </textarea>
                             
                         </div>
                       
                       
            <div class="form-group">
                            <label>سجل الأعمال</label>
                            <textarea cols="30" row="10"  style="height:100px!important" name="business_register" class="form-control">
                             
                            </textarea>
                             
                         </div>
                         
                        
                 
                          <div class="form-group">
                                <label for="edit_image">الصورة الشخصية </label>
                                <input type="file" name="image"  class="form-control" lang="ar">
                        </div>
                        
                         
                                   <div class="form-group">
                                <label for="edit_image">السيرة الذاتية </label>
                                <input type="file" name="cv" class="form-control" lang="ar">
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
            <h1 style="text-align: center;color: #001586">جدول  موظفي المدرسة</h1>
        </div>
          @can('create_staf')
        <button type="button" class="btn mb-1 btn-success" data-toggle="modal" data-target="#create_teacher" style="font-size: 25px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3">إنشاء موظف </button>

    
         <a href="{{route('import_employe')}}" type="button" class="btn mb-1 btn-success" style="font-size: 17px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3;margin-right: 3px;"> ادخال موظفين </a>
          @endcan
           <div class="table-responsive" style="overflow-x: scroll;">
            <table class="table align-items-center" id="table_xx">
                <thead style="color: black">
                <tr>
                    <th scope="col" class="sort" data-sort="budget">الاسم </th>
                    <th scope="col" class="sort" data-sort="budget">الموبايل </th>
                    <th scope="col" class="sort" data-sort="budget">العنوان </th>
                    <th scope="col" class="sort" data-sort="budget">تاريخ الولادة </th>
                    <th scope="col" class="sort" data-sort="budget"> الراتب</th>
                    <th scope="col" class="sort" data-sort="budget">  المنصب الوظيفي </th>
                    <th scope="col" class="sort" data-sort="budget">  الامراض التي يعاني منها  </th>
                    <th scope="col" class="sort" data-sort="budget">الصورة الشخصية </th> 
                    <th scope="col" class="sort" data-sort="budget"> السيرة الذاتية</th>
                       <th scope="col" class="sort" data-sort="budget">  العمليات </th>

                </tr>
                </thead>
                <tbody class="list" id="mydiv">
                 @foreach ($school_staf as $item)
                 <tr>
                 <td>{{$item->first_name}} {{$item->last_name}} </td>
                 <td>{{$item->phone}}</td>
                 <td>{{$item->address}}</td>
                 <td>{{$item->birth_date}}</td>
                 <td>{{$item->salary}}</td>
                  <td>{{$item->position}}</td>
                 <td>{{$item->diseases}}</td>
                 <td><img src="{{asset('storage/'.$item->image)}}" width="75px"height="75px"> </td>
                 
                 <td>
                   @if ($item->cv)
        <a href="{{ asset('storage/'.$item->cv) }}" target="_blank">
            <img src="{{ asset('assets/img/pdf.png') }}" width="75px" height="75px">
        </a>
    @else
        <span></span>
    @endif
                 </td>
                  <td>
                        @can('update_staf')
                    <a  style="padding: 8px 14px!important;" class="edit_staff btn btn-success btn-sm"
                    data-first_name="{{ $item->first_name }}"
                    data-last_name="{{ $item->last_name }}"
                    data-phone="{{ $item->phone }}"
                    data-address="{{ $item->address }}"
                    data-salary="{{ $item->salary }}"
                    data-birth_date="{{ $item->birth_date }}"
                    data-diseases="{{ $item->diseases }}"
                    data-business_register="{{ $item->business_register }}"
                    data-id="{{ $item->id }}"
                    data-position="{{ $item->position }}"
                    
                    href=".editNewsModal" data-toggle="modal">تعديل</i>
                    </a>
                     @endcan
                   @can('delete_staf')
                    <a href=".deletelessonModal" class="btn btn-danger delete"
                    data-id="{{ $item->id }}"  data-toggle="modal" >
                        حذف
                    </a>
                    @endcan
                   @can('file_staf')
                    <a href="{{ route('employee.attendance', ['id' => $item->id]) }}" class="btn btn-danger delete">
                        ملفات الحضور
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
            <form id="form_delete" action="{{route('delete_school_staff')}}" method="POST"  autocomplete="off">

                @csrf
                <input type="hidden" name="id" id="lesson_id_delete" required>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">حذف  الموظف</h4>
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

$(document).on('click','.edit_staff',function(e){
e.preventDefault();
var id=$(this).data('id');

var file =$(this).data('file');

$('#staff_id').val(id);
$('#edit_first_name').val($(this).data('first_name'));
$('#edit_last_name').val($(this).data('last_name'));
$('#edit_phone').val($(this).data('phone'));
$('#edit_address').val($(this).data('address'));
$('#edit_birth_date').val($(this).data('birth_date'));
$('#edit_diseases').val($(this).data('diseases'));
$('#edit_business_register').val($(this).data('business_register'));
$('#edit_salary').val($(this).data('salary'));
$('#position').val($(this).data('position'));
 
  
 

});


</script>

@endsection
