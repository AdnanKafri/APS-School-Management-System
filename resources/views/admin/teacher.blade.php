@extends('admin.master')

@section('style')
<style>
    *{
        direction: rtl !important;
        /* text-align: center; */
    }
    button,a{
        color: white !important;
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
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم المدرسين</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')


@php
$about = \App\Other::find(1);
@endphp
  @php
        $school_data = \App\School_data::first();
        @endphp
    <div class="modal fade archiveModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('teacher_archive') }}" method="POST"  autocomplete="off">

                                @csrf
                                <input type="hidden" name="archive_id" id="archive_id" required>

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: #f00"> ارشفة استاذ</h4>
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                           <label style="font-size: 18px; font-weight:bold">      هل انت متاكد من الارشفة  </label>


                                        <!--<input type="date" style="direction:rtl" id="date_archive" name="date_archive" class="form-control a"-->

                                        <!--      required>-->

                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-danger">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

<div class="modal fade" id="user_name_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="dvContainer">
                <div class="row">
                    <div class="col-lg-4 col-12" >
                        <img src="{{asset("storage/")}}/{{$school_data->logo}}" style="width: inherit;height: inherit;">
                    </div>
                    <div class="col-lg-8 col-12">
                        <div style="height: 5%"></div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم المدرس </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="name_share"></p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم المستخدم </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="username_share"></p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">كلمة المرور  </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="pass_share"></p>
                        </div>
                        <div style="height: 5%"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="direction: rtl;justify-content: right;">
                <a class="btn btn-info ml-2" data-dismiss="modal">اغلاق</a>
                <a class="btn btn-success ml-2" id="screenshot">تنزيل</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="classModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="dvContainer">
                <div class="row">
                    <div class="col-lg-12 col-12" >
                        <table class="table align-items-center class_table " id="">
                            <thead style="color: black">
                                <tr>
                                    <th>
                                         الصف
                                    </th>
                                    <th>
                                         الشعبة
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
            <div class="modal-footer" style="direction: rtl;justify-content: right;">
                <a class="btn btn-info ml-2" data-dismiss="modal">اغلاق</a>

            </div>
        </div>
    </div>
</div>

  <div class="modal fade deletelessonModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('teacher_delete') }}" method="POST"  autocomplete="off">

                                @csrf
                                <input type="hidden" name="teacher_id_delete" id="lesson_id_delete" required>

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: #f00">حذف استاذ</h4>
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                        <label style="font-size: 18px; font-weight:bold"> أدخل كود الحذف للتأكيد </label>


                                        <input type="password" style="direction:rtl" id="delete_code" name="delete_code" class="form-control a"

                                            placeholder="أدخل كود الحذف  "  required>
                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-danger">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<div class="modal fade" id="update_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('teacher_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="teacher_id" id="edit_teacher_id" hidden>
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">تعديل معلومات مدرس</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
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
                            <input type="date" name="date_birth" id="edit_date_birth" class="form-control b" value="" style="direction:rtl" placeholder="Type last name">
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
                            <label>اسم المادة</label>
                            <input type="text" name="lesson_name" id="edit_lesson_name" class="form-control b" value="" placeholder="اكتب اسم المادة " style="direction:rtl" maxlength="20" required="">
                        </div>
                           <div class="form-group" style="text-align:right">
                                        <label>عقد العمل</label>
                                         <select name="contract" id="edit_contract" class="form-control"
                                            style="min-height: 36px;direction: rtl" >
                                            <option value="2" hidden> حدد  هل العقد شهري او سنوي     </option>

                                                <option value="1">شهري</option>
                                                <option value="2"> سنوي</option>

                                        </select>
                                    </div>
                        <div class="form-group">
                            <label> عدد أيام الأجازات</label>
                            <input type="number" name="vcation_days" id="edit_vcation_days" class="form-control b" value="" min="0" placeholder="اكتب عدد أيام الإجازة " style="direction:rtl" maxlength="20" required="">
                        </div>

                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control b email" value="" maxlength="50" placeholder="اكتب البريد الالكتروني " >
                            <span class="text-danger error validate_email"></span>
                        </div>

                        <label for="" style="float: right;">كلمة المرور القديمة</label>
                        <br>
                        <small id="alert" style="color: #f00;"></small>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password" id="edit_password" type="password" value="" size="15" class="input form-control" id="password" placeholder="اكتب كلمة المرور"  aria-label="password" aria-describedby="basic-addon1">
                        </div>

                        <label  style="float: right;">تأكيد كلمة المرور</label>
                        <br>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password_confirmation" id="edit_password_confirmation" type="password" value="" size="15"  class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور" aria-label="password" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password_confirmation" id="edit_password_confirmation" type="password" value="" size="15"  class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور" aria-label="password" aria-describedby="basic-addon1">
                        </div>


                        <div class="form-group">
                            <label>الراتب</label>
                            <input type="number" name="salary" id="edit_salary" class="form-control b" value="" placeholder="ادخل الراتب "  style="direction:rtl">
                        </div>



                        <div class="form-group">
                                <label for="edit_image">صورة المدرس</label>
                                <input type="file" name="image" id="edit_image" class="form-control" lang="ar">
                        </div>
                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('teacher_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">إنشاء مدرس</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>الإسم الأول بالعربية</label>
                        <input type="text" name="first_name" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الإسم الأول" required>
                    </div>

                    <div class="form-group">
                        <label>الكنية بالعربية</label>
                        <input type="text" name="last_name" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="الكنية" required>
                    </div>
                    <div class="form-group">
                        <label>الإسم الأول بالانكليزية</label>
                        <input type="text" name="first_name_en" class="form-control a english_name" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الإسم الأول" required>
                    </div>

                    <div class="form-group">
                        <label> الكنية بالانكليزية</label>
                        <input type="text" name="last_name_en" class="form-control b english_name"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="الكنية" required>
                    </div>
                        <div class="form-group">
                            <label>تاريخ الولادة</label>
                            <input type="date" lang="ar" name="date_birth" class="form-control b" value="" style="direction:rtl" placeholder="Type last name">
                        </div>

                        <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" name="address" class="form-control b" value="" maxlength="100" placeholder="اكتب العنوان" style="direction:rtl">
                        </div>

                        <div class="form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" class="form-control b" value="" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                        </div>
                        <div class="form-group">
                            <label>اسم المادة</label>
                            <input type="text" name="lesson_name" class="form-control b" value="" placeholder="اكتب اسم المادة " style="direction:rtl" maxlength="20" required="">
                        </div>
                           <div class="form-group" style="text-align:right">
                                        <label>عقد العمل</label>
                                         <select name="contract" id="" class="form-control"
                                            style="min-height: 36px;direction: rtl" >
                                            <option value="annual" hidden> حدد  هل العقد شهري او سنوي     </option>

                                                <option value="monthly">شهري</option>
                                                <option value="annual"> سنوي</option>

                                        </select>
                                    </div>
                        <div class="form-group">
                            <label> عدد أيام الأجازات</label>
                            <input type="number" name="vcation_days" class="form-control b" value="" min="0" placeholder="اكتب عدد أيام الإجازة " style="direction:rtl" maxlength="20" required="">
                        </div>

                            <div class="form-group">
                            <label>الراتب</label>
                            <input type="number" name="salary"  class="form-control b" value="" min="0" placeholder="ادخل الراتب "  style="direction:rtl">
                        </div>



                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول المدرسين</h1>
        </div>

        <div class="row" >
             @can('create_teacher')
            {{-- <a   target="_blank" href="{{ route('tech_import') }}" class="btn  btn-success"
                > ادخال مدرسين </a>
                &nbsp; --}}
            <button type="button" class="btn  btn-success" data-toggle="modal" data-target="#create_teacher" >إنشاء مدرس</button>
            @endcan
             @can('teacher_details_department')
            {{-- <a class="btn btn-success" style="margin-right: 4px;"   href="{{ route('teacher_details_departments') }}"    >   اضافة قسم للادخال
            </a> --}}
             @endcan
               @can('export_teachers')
               {{-- <form action="{{ route('export_teacher') }}" method="post">
               @csrf
               <div id="disabled">
                    <button type="submit" class="btn btn-success "  style="margin-right: 4px;"    id="disabled1" >تصدير مدرسين</button>
               </div>

              </form> --}}
             @endcan
            </div>

            <br>
        <div class="row" >
           <div class="col-12 col-lg-6">
               <select name="classes" id="classes_select" class="form-control">
                   <option value=""> جميع الصفوف </option>
                   @foreach ($classes as $item)
                       <option value="{{ $item->id }}"> {{ $item->name }} </option>
                   @endforeach
                </select>
            </div>
           {{-- <div class="col-12 col-lg-6">
                <select name="rooms" id="rooms_classes" class="form-control">
                  <option value=""> جميع الشعب </option>
                </select>
            </div> --}}
        </div>



        <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم الأول</th>
                    <th scope="col" class="sort" data-sort="status">الكنية</th>
                    <th scope="col" class="sort" data-sort="status">تاريخ الميلاد</th>
                    <th scope="col" class="sort" data-sort="completion">العنوان</th>
                    <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                    <th scope="col" class="sort" data-sort="completion">الراتب</th>



                    <th scope="col" class="sort" data-sort="completion">الصورة </th>

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">


                </tbody>
              </table>



        </div>
    </div>
</div>

@php
    $year2 = \App\Year::where('current_year',1)->first();
@endphp
<input type="hidden" name="year_id" id="years" value={{$year2->id}}>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script >



$(document).on('change', '#classes_select', function () {

var year_id=$('#years').val();
var class_id=$(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
$('#rooms_classes').empty();
$('#rooms_classes').append(`<option value="">جميع الشعب</option>`);
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $.each(data, function (key, value) {
            $('#rooms_classes').append(`<option value="${value.id}">${value.name}</option>`);
        });
        table_test.draw();
    },


});
});
$(document).on('click', '.class_teacher', function () {

var teacher_id=$(this).data('id');

var url = "{{ URL::to('SMT/admin/class_teacher') }}/" + teacher_id ;

$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
          $('.class_table tbody').empty();
        console.log(data);
        $.each(data, function (key, value) {
           $('.class_table tbody').append(`<tr>
            <td>${value.classes.name}</td><td>${value.name}</td></tr>`)
        });
    },


});
});


        $('#rooms_classes').change(function () {
                table_test.draw();
        })

var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getteachers') }}",
            data : function (d) {
                d.classes = $('#classes_select').val();
                d.rooms= $('#rooms_classes').val();
            },
            "type": "GET",
            "dataSrc": function (json) {
                console.log(json.aaData);
                return json.aaData;
            }
        },
        columns: [
            {

                data: 'id',
                render: function (data, type, full) {
                    return `${full.first_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.last_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.date_birth}`;
                }, orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.address}`;
                },orderable : false
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.phone != null ? full.phone : ''}`;
                }, orderable : false
            },

                   {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.salary != null ? full.salary : ''}`;
                }, orderable : false
            },



            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.image != null ? `<img width="80" height="80" src="{!! asset('storage') !!}/${full.image}" >` : ""}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `
                        <a style="font-size:18px !important" href="{{ url('SMT/admin/teacher_schedule') }}/${full.id}" class="btn btn-info btn-sm" title="جدول الحصص"  style="font-size:18px !important">
                            <i class="fa fa-table fa-x" style="color: #eff0f1"></i>
                        </a>

                        @can('update_teacher')
                        <a style="font-size:18px !important" data-id="${ full.id }" data-data='${ JSON.stringify(full) }' class="edit_teacher btn btn-info btn-sm"   href="{{ url('SMT/admin/teacher_details') }}/${full.id}" title="تعديل معلومات المدرس" >
                            <i class="fa fa-eye fa-x" style="color: #eff0f1"></i>
                        </a>
                         @endcan
                           @can('Account_Information_teacher')
                        <a style="font-size:18px !important" class="share_teacher btn btn-info btn-sm" data-toggle="modal" data-target="#user_name_modal" data-username="${ full.user.email }" data-name="${ full.first_name+" "+full.last_name }" data-pass="${ full.user.view_password }" title = "معلومات الأيميل">
                             <i class="fa fa-send fa-x" style="color: #eff0f1"></i>
                        </a>
                        @endcan

                        @can('delete_teacher')
                         <a href=".deletelessonModal" class="delete"  data-id="${ full.id }"  data-toggle="modal" >
                            <i class="fa fa-trash" style="font-size: 19px;color: #af686e"></i>
                        </a>
                        @endcan


                    `;
                }, orderable : false
            },

        ]
    });

 $(document).on('click', '.archive', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');


    $('#archive_id').val(id);
});
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#lesson_id_delete').val(id);
});
$(document).on("click",".share_teacher",function () {
    $('#pass_share').text($(this).data("pass"));
    $('#username_share').text($(this).data("username"));
    $('#name_share').text($(this).data("name"));
});

$(document).on("click","#screenshot",function () {
    html2canvas(document.querySelector("#dvContainer")).then(canvas => {
		a = document.createElement('a');
		document.body.appendChild(a);
		a.download = $('#name_share').text()+".png";
		a.href =  canvas.toDataURL();
		a.click();
	});
 });


$(document).on('click','.edit_teacher',function (e) {
    var data = $(this).data('data');

    $('#edit_teacher_id').val(data.id);
    $('#edit_first_name').val(data.first_name);
    $('#edit_last_name').val(data.last_name);
    $('#edit_date_birth').val(data.date_birth);
    $('#edit_address').val(data.address);
    $('#edit_vcation_days').val(data.vcation_days);
    $('#edit_contract').val(data.contract);
    $('#edit_lesson_name').val(data.lesson_name);
    $('#edit_phone').val(data.phone);
    $('#edit_email').val(data.email);
    $('#edit_salary').val(data.salary);





    console.log(data.id);
});
 $(".english_name").keypress(function(event){
    var ew = event.which;
    if(ew == 32)
        return true;
    if(48 <= ew && ew <= 57)
        return true;
    if(65 <= ew && ew <= 90)
        return true;
    if(97 <= ew && ew <= 122)
        return true;
    return false;
});

$(document).on('click', '#disabled1', function () {
        $('#disabled button').prop('disabled', true); // Disable the button
    $('#disabled1').closest('form').submit();
    $('#disabled').empty();
    $('#disabled').append(`<button type="submit" class="btn btn-success "  style="margin-right: 4px;"   id="disabled1" >تصدير مدرسين</button>`);
    $('#disabled button').prop('disabled', false); // Re-enable the button

});

</script>

@endsection
