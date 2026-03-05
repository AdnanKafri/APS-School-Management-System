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
  @php
        $school_data = \App\School_data::first();
        @endphp
@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم الموظفين </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection
@section('content')


<div class="modal fade" id="user_name_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="dvContainer">
                <div class="row">
                    <div class="col-lg-4 col-12" >
                        <img src="{{  asset('storage/'. $school_data->logo)}}" style="width: inherit;height: inherit;">
                    </div>
                    <div class="col-lg-8 col-12">
                        <div style="height: 5%"></div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586"> الموظف </label>
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


<div class="modal fade" id="update_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.user_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="user_id" id="edit_user_id" hidden>
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">تعديل معلومات الموظف</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label>الاسم </label>
                            <input type="text" name="name" id="edit_name" class="form-control a" value="" placeholder=" الاسم " maxlength="30" style="direction:rtl" required="">
                        </div>




                        <div class="form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control b" value="" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                        </div>

                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control b email" value="" maxlength="50" placeholder="اكتب البريد الالكتروني " >
                            <span class="text-danger error validate_email"></span>
                        </div>

                        <label for="" style="float: right;">كلمة المرور</label>
                        <br>
                        <small id="alert" style="color: #f00;"></small>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password" id="edit_password" type="password" value="" size="15" class="input form-control" id="password" placeholder="اكتب كلمة المرور"  aria-label="password" aria-describedby="basic-addon1">
                            <span class="input-group-text" onclick="ppassword_show_hide3();">
                                        <i class="fas fa-eye" id="sshow_eye3"></i>
                                        <i class="fas fa-eye-slash d-none" id="hhide_eye3"></i>
                            </span>
                        </div>

                        <label  style="float: right;">تأكيد كلمة المرور</label>
                        <br>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password_confirmation" id="edit_password_confirmation" type="password" value="" size="15"  class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور" aria-label="password" aria-describedby="basic-addon1">
                            <span class="input-group-text" onclick="ppassword_show_hide4();">
                                        <i class="fas fa-eye" id="sshow_eye4"></i>
                                        <i class="fas fa-eye-slash d-none" id="hhide_eye4"></i>
                            </span>
                        </div>
                       
                        <div class="form-group">
                                    <label>الصلاحيات </label>

                                    <select name="role_id" class="form-control" id="edit_role"
                                        style="min-height: 36px;direction: rtl" required>
                                        <option value="">اختر الصلاحية المناسبة</option>

                                    @foreach ($roles as $role)

                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach

                                    </select>

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



<div class="modal fade" id="create_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.user_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">إنشاء مستخدم</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label>الاسم باللغة العربية  </label>
                            <input type="text" name="name" class="form-control a" value="" placeholder="الاسم  " maxlength="30" style="direction:rtl" required="">
                        </div>
                         <div class="form-group">
                            <label>الاسم باللغة الانكليزية </label>
                            <input type="text" name="name_en" class="form-control a english_name" value="" placeholder="name in english  " maxlength="30" style="direction:rtl" required>
                        </div>
                        <div class="form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" class="form-control b " value="" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                        </div>
                        
                     
                         <div class="form-group">
                                    <label>الصلاحيات </label>

                                    <select name="role_id" class="form-control"
                                        style="min-height: 36px;direction: rtl" required>
                                        <option value="">اختر الصلاحية المناسبة</option>

                                    @foreach ($roles as $role)

                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach

                                    </select>

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


<div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.user_delete') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" id="delete_user_id" >
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel"> حذف الموظف</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label>الاسم </label>
                            <input type="text" name="name" id="delete_name" class="form-control a" value="" placeholder=" الاسم " maxlength="30" style="direction:rtl" readonly>
                        </div>




                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <button type="submit" class="btn btn-danger">تأكيد</button>
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول الموظفين</h1>
        </div>
         @can('create_user')
        <button type="button" class="btn mb-1 btn-success" data-toggle="modal" data-target="#create_user" style="font-size: 25px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3">إنشاء مستخدم</button>
        @endcan
        <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم </th>

                    <th scope="col" class="sort" data-sort="completion">نوع المستخدم</th>
         
                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">

                </tbody>
              </table>


        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script >



var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 25,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getusers') }}",
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
                    return `${full.name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.role.name}`;
                },orderable : false
            },
        
            {
                data: 'id',
                render: function (data, type, full) {
                    return `
                    @can('update_user')
                        <a data-id="${ full.id }" data-data='${ JSON.stringify(full) }' class="edit_user btn btn-info btn-sm" data-toggle="modal" data-target="#update_user" title="تعديل معلومات المستحدم" >
                            <i class="fa fa-eye fa-x" style="color: #eff0f1"></i>
                        </a>
                         @endcan
                        <a class="share_user btn btn-info btn-sm" data-toggle="modal" data-target="#user_name_modal" data-username="${ full.email }" data-name="${ full.name }" data-pass="${ full.view_password }" title = "معلومات الأيميل">
                             <i class="fa fa-send fa-x" style="color: #eff0f1"></i>
                        </a>
                           @can('delete_user')
                         <a  class="delete_user btn btn-info btn-sm"   data-name="${ full.name }"  data-id="${ full.id }"  data-toggle="modal" data-target="#delete_user"  title="حذف الموظف">
                            <i class="fa fa-trash" style="font-size: ;color: #fff"></i>
                        </a>
                         @endcan

                    `;
                },orderable : false
            },

        ]
    });



$(document).on("click",".share_user",function () {
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


$(document).on('click','.edit_user',function (e) {
    var data = $(this).data('data');

    $('#edit_user_id').val(data.id);
    $('#edit_name').val(data.name);


    $('#edit_phone').val(data.mobile);
     $('#edit_role').val(data.role_id);
    $('#edit_email').val(data.email);
 

    console.log(data.id);
});
$(document).on('click','.delete_user',function (e) {

    var id = $(this).data('id');
    var name = $(this).data('name');

    $('#delete_user_id').val(id);
    $('#delete_name').val(name);

});
function ppassword_show_hide3() {
    var x = document.getElementById("edit_password");
    var show_eye = document.getElementById("sshow_eye3");
    var hide_eye = document.getElementById("hhide_eye3");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
    };
    function ppassword_show_hide4() {
    var x = document.getElementById("edit_password_confirmation");
    var show_eye = document.getElementById("sshow_eye4");
    var hide_eye = document.getElementById("hhide_eye4");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
    };
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
</script>

@endsection
