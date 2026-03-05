@extends('admin.master')
@section('style')
    <style>
    th{
        font-size: 20px;
        border: 0px  !important;
        text-align: center;
        color: black;
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
    #table_xx_wrapper{
    overflow: auto;
}
.modal-header .close {
    padding: 1rem;
    margin: -1rem 20rem -1rem auto;
}
    </style>
@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم المشرفيين التربويين</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')


@php
$about = \App\Other::find(1);
@endphp

<div class="modal fade" id="user_name_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="dvContainer">
                <div class="row" style="direction: rtl !important">
                    <div class="col-lg-4 col-12" >
                        <img src="{{asset("storage/")}}/{{$about->logo}}" style="width: inherit;height: inherit; border-radius: 0%">
                    </div>
                    <div class="col-lg-8 col-12">
                        <div style="height: 5%"></div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم المشرف التربوي </label>
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
                <a class="btn btn-info ml-2" data-dismiss="modal" style="color: white">اغلاق</a>
                <a class="btn btn-success ml-2" id="screenshot">تنزيل</a>
            </div>
        </div>
    </div>
</div>



<div class="col" style="direction:rtl;text-align:right">
    <div class="card" style="margin: 30px">

            <div class="card-header border-0" >
              <h2 class="mb-0" style="text-align: center;color: #001586">جدول الموجهين</h2>

            </div>
<div class="table-responsive" style="text-align:right">
     @can('create_supervisor') 

    <a href=".createSupervisorModal" class="btn btn-success" data-toggle="modal"
    data-id="" id="super_store"><i class="material-icons" data-toggle="\">إنشاء موجه</i></a>

  @endcan

              <table class="table align-items-center table-flush" >
                <thead class="">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم الأول</th>
                    <th scope="col" class="sort" data-sort="status">الكنية</th>
                    <th scope="col" class="sort" data-sort="status">تاريخ الميلاد</th>
                    <th scope="col" class="sort" data-sort="completion">العنوان</th>
                    <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                    <th scope="col" class="sort" data-sort="completion">الصورة </th>
                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($supervisors as $item)

               <tr>
                    <!--<th scope="row">-->
                    <!--{{$item->id}}-->
                    <!--</th>-->
                    <td class="budget" style="font-weight:bold; font-size:15px">
                    {{$item->first_name}}

                  </td>

                  <td class="budget" style="font-weight:bold;font-size:15px">
                    {{$item->last_name}}

                  </td>


                  <td class="budget">
                    {{$item->date_birth}}

                  </td>

                  <td class="budget">
                    {{$item->address}}

                  </td>

                  <td class="budget">
                    {{$item->phone}}

                  </td>

                    <td>

                    @if($item->image != null)
                      <div class="avatar-group">
                        <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="">
                          <img alt="Image placeholder" width="100" height="100"
                    src="{{asset('storage/'.$item->image)}}">
                    </a>

                      </div>

                      @endif
                    </td>


                    <td>

                         @can('update_supervisor') 
                        <a href="{{ route('supervisor_details',$item->id) }}" target="_blank">
                            <i class="fa fa-eye fa-2x" style="color: #008CC4"></i>

                            </a>
                      @endcan


                   @can('set_supervisor_task')
                    <a href="{{ route('set_supervisor_task',$item->id) }} " target="_blank" class="btn btn-success ">تحديد مهام</a>

                   @endcan
                   @can('update_supervisor_task')
                    <a href="{{ route('edit_supervisor_task',$item->id) }}" target="_blank" class="btn btn-warning" style="color: white">تعديل المهام</a>
                   @endcan
                     @can('Account_supervisor')
                    <a class="share_teacher" data-toggle="modal" data-target="#user_name_modal" data-username="{{ $item->user->email }}" data-name="{{ $item->first_name." ".$item->last_name }}" data-pass="{{ $item->user->view_password }}" > <i class="fa fa-send fa-2x" style="color: #0083FF"></i> </a>
                        @endcan
                     @can('delete_supervisor')
                      <a href=".deletelessonModal" class="delete"  data-id="{{$item->id}}"  data-toggle="modal" >
                            <i class="fa fa-trash" style="font-size: 25px;color: #af686e"></i>
                        </a>
                        @endcan
                    </td>


                  </tr>


               @endforeach
             <div class="modal fade deletelessonModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" autocomplete="off" action="{{ route('supervisore_delete') }}" method="POST"  autocomplete="off">
                                @csrf
                                <input type="hidden" name="supervisore_delete" id="supervisore_delete" required>

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: #f00">حذف موجه</h4>
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                        <label style="font-size: 27px; font-weight:bold"> أدخل كود الحذف للتأكيد </label>


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
               

                </tbody>
              </table>

            </div>












            <div class="clearfix" style="padding-left:10px">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/20) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-10">
                            {{ $supervisors->links() }}
                        </div>
                    </div>
                </div>

    </div>
</div>




            <div class="modal fade createSupervisorModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" autocomplete="off" action="{{ route('supervisor_store') }}" method="POST" enctype="multipart/form-data" style="text-align: right;">
                            @csrf

                            <div class="modal-header">
                               
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                             <h4 class="modal-title" style="text-align: center; padding-top: 15px;">إنشاء موجّه</h4>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>الاسم الأول</label>
                                    <input type="text" name="first_name" class="form-control a"
                                        value=""
                                        placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required>
                                </div>

                                <div class="form-group">
                                    <label>الكنية</label>
                                    <input type="text" name="last_name" class="form-control b"
                                        value=""
                                        placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required>
                                </div>



                                <div class="form-group">
                                    <label>تاريخ الولادة</label>
                                    <input type="date" name="date_birth" class="form-control b"
                                        value=""style="direction:rtl"
                                        placeholder="Type last name" >
                                </div>


                                <div class="form-group">
                                    <label>العنوان</label>
                                    <input type="text" name="address" class="form-control b"
                                        value="" maxlength="100"
                                        placeholder="اكتب العنوان" style="direction:rtl" >
                                </div>

                                <div class="form-group">
                                    <label>الهاتف</label>
                                    <input type="text" name="phone" class="form-control b"
                                        value=""
                                        placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required>
                                </div>

                                <div class="form-group">
                                    <label>البريد الإلكتروني</label>
                                    <input type="email" name="email"  class="form-control b email"
                                        value="" maxlength="50"
                                        placeholder="اكتب البريد الالكتروني " required>


                                        <span class="text-danger error validate_email">


                                        </span>
                                    </div>

                                <label for="">كلمة المرور</label>
                                <br>
                                <small id="alert" style="color: #f00;"> </small>


                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                                    </div>
                                                    <input name="password" type="password" value="" size="15"
                                                    class="input form-control" id="password" placeholder="اكتب كلمة المرور"
                                                    required="true" aria-label="password" aria-describedby="basic-addon1" />
                                                    <div class="input-group-append">
                                                    <span class="input-group-text" >
                                                        <i class="fas fa-eye" id="show_eye"></i>
                                                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div id="strength" style="margin-top: -18px"> </div>


 <br>

                                                <label for="">تأكيد كلمة المرور</label>
                                                <br>


                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                                    </div>
                                                    <input name="password_confirmation" type="password" value="" size="15"
                                                    class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور"
                                                    required="true" aria-label="password" aria-describedby="basic-addon1" />
                                                    <div class="input-group-append">
                                                    <span class="input-group-text" >
                                                        <i class="fas fa-eye" id="show_eye2"></i>
                                                        <i class="fas fa-eye-slash d-none" id="hide_eye2"></i>
                                                    </span>
                                                    </div>
                                                </div>


                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="customFileLang" lang="en">
                                        <label class="custom-file-label" for="customFileLang">Select file</label>
                                    </div>
                                </div>







                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-info" id="save">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endsection

            @section('js')
                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
                <script>

$(document).on("click","#screenshot",function () {
    html2canvas(document.querySelector("#dvContainer")).then(canvas => {
		a = document.createElement('a');
		document.body.appendChild(a);
		a.download = $('#name_share').text()+".png";
		a.href =  canvas.toDataURL();
		a.click();
	});
 });

 $(document).on("click",".share_teacher",function () {
    $('#pass_share').text($(this).data("pass"));
    $('#username_share').text($(this).data("username"));
    $('#name_share').text($(this).data("name"));
});



$(document).ready(function () {

$(document).on('click','#super_store',function(){
 $('.email').val('');  
 $('.validate_email').text('');

})

$(document).on('focusout','.email',function(){
     $('.validate_email').text('');
    if ($(this).val().length !== 0 ) {
    $('.validate_email').text('');
$('.er').hide();
var email=$(this).val();
     $.ajax({
url: "{{ URL::to('SMARMANger/admin/validate_email1') }}",
type: "get",
contentType: 'application/json',
data : {
    '_token':"{{ csrf_token() }}",
    'email':email,
},
success: function (data) {

       },
error: function (xhr) {
    $('.validate_email').html("<div >! عذرا , هذا الايميل موجود مسبقا</div> ");

}

});
}
});

});

$(document).ready(function () {
   
    setTimeout(function() {

        $('.alert-dismissible').hide(2000);


    },10000);


    $('#search_teacher').on('keyup',function(){
        var search_teacher = $(this).val();
        var url = "{{ URL::to('SMARMANger/admin/teachers/teacher_filter') }}";
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            data:{
                teacher_now:search_teacher,
            },
            success: function (data) {

                $('#mydiv').empty();
                type="";

                $.each(data, function (key, value) {
                console.log(data);
                    type += `

                    <tr>

                    <td class="budget" style="font-weight:bold;font-size:15px">
                    ${value.first_name}

                  </td>

                  <td class="budget" style="font-weight:bold;font-size:15px">
                    ${value.last_name}

                  </td>


                  <td class="budget">
                    ${value.date_birth}

                  </td>

                  <td class="budget">
                    ${value.address}

                  </td>

                  <td class="budget">
                    ${value.phone}

                  </td>

                  <td>`;

                  if(value.image!=null){

                      type+=`
                                            <div class="avatar-group">
                        <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">
              <img alt="Image placeholder" src="{{ asset('storage/${value.image}') }}">

                        </a>

                      </div>
                      `;
                  }
                   type+=` </td>
                  <td class="text-right">

                @can('edit_teacher')

                <a href="teachers/teacher_details/${value.id}" target="_blank">
                <i class="fa fa-eye fa-2x" style="color: blue"></i>
                </a>

                @endcan

                @can('set_task')
                <a href="teacher/set_task/${value.id}" target="_blank" class="btn btn-success btn-sm">تحديد مهام</a>
                @endcan

                @can('edit_task')

                <a href="teacher/edit_task/${value.id}" target="_blank" class="btn btn-warning btn-sm">تعديل المهام</a>

                @endcan
                    </td>

                  </tr>

                      `;

                });


                $('#mydiv').append(type);

            },
            error: function (xhr) {

            }

        });
    });











});

$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#supervisore_delete').val(id);
});
</script>

<script language="javascript">
    var pwd = document.getElementById("password");

function passwordChanged() {
var strength = document.getElementById('strength');
var strongRegex = new RegExp("^(?=.{14,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
var enoughRegex = new RegExp("(?=.{8,}).*", "g");
var pwd = document.getElementById("password");
if (pwd.value.length == 0) {
    strength.innerHTML = 'اكتب كلمة المرور';
    document.getElementById('alert').innerText=
"يجب ان يحتوي احرف كبيرة و صغيرة و رموز";
    document.getElementById('save').disabled = true;
} else if (false == enoughRegex.test(pwd.value)) {

    strength.innerHTML = 'محارف اكثر';

    document.getElementById('alert').innerText=
"يجب ان يحتوي احرف كبيرة و صغيرة و رموز";
    document.getElementById('save').disabled = true;
} else if (strongRegex.test(pwd.value)) {
    strength.innerHTML = '<span style="color:green">Strong!</span>';
    document.getElementById('alert').innerText="";
    document.getElementById('save').disabled = false;
} else if (mediumRegex.test(pwd.value)) {
    strength.innerHTML = '<span style="color:orange">Medium!</span>';
    document.getElementById('alert').innerText=
"";
    document.getElementById('save').disabled = false;

} else {

    document.getElementById('alert').innerText=
"يجب ان يحتوي احرف كبيرة و صغيرة و رموز";
    document.getElementById('save').disabled = true;
    strength.innerHTML = '<span style="color:red">ضعيف !</span>';
}
}
</script>

<script>
function password_show_hide() {
var x = document.getElementById("password");
var show_eye = document.getElementById("show_eye");
var hide_eye = document.getElementById("hide_eye");
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
}


function password_show_hide2() {
var x = document.getElementById("password-confirm");
var show_eye = document.getElementById("show_eye2");
var hide_eye = document.getElementById("hide_eye2");
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
}
</script>

@endsection
