@extends('admin.master')
@section('search')
<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
    <div class="form-group mb-0">
      <div class="input-group input-group-alternative input-group-merge">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input class="form-control" name="search_teacher" id="search_teacher" placeholder="Search" type="text">
      </div>
    </div>
    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </form>
@endsection
@section('content')

<div class="col" style="direction:rtl;text-align:right">
    <div class="card" >
            <!-- Card header -->
            
                     @if ($errors->any())
            @foreach ($errors->all() as $error)

                <div class="alert alert-danger" >

                    <h4 style="color: #FFF; font-size:30px" >   عذرا , لم يتم تسجيل الحساب يرجى اعادة الادخال
                    </h4>

                </div>


            @endforeach
        @endif
            
            
                    @if(session()->has('warning'))

                
                  <div class="alert alert-warning alert-dismissible" role="alert" style="text-align: right; font-size: 30px">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     {{ session()->get('warning') }}
                    </div>
                @endif
            <div class="card-header border-0" >
              <h3 class="mb-0">جدول المدرّسين</h3>

            </div>
<div class="table-responsive" style="text-align:right;overflow-x: scroll;">
    <a href=".createTeacherModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء مدرّس</i></a>

              <table class="table align-items-center table-flush" >
                <thead class="thead-light">
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
                @foreach ($teachers as $item)

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
                          <img alt="Image placeholder"
                    src="{{asset('storage/'.$item->image)}}">
</a>

                      </div>
                      
                      @endif
                    </td>


                    <td>
                        
                        
                <a href="{{ route('admin.teacher_details',$item->id) }}" target="_blank">
                    <i class="fa fa-eye fa-2x" style="color: blue"></i>

                    </a>
                    

                        <a href="{{ route('admin.teacher.set_task',$item->id) }}" target="_blank" class="btn btn-success btn-sm">تحديد مهام</a>
                        <a href="{{ route('admin.teacher.edit_task',$item->id) }}" target="_blank" class="btn btn-warning btn-sm">تعديل المهام</a>

                    </td>

                    <!--<td class="text-right">-->
                    <!--  <div class="dropdown">-->
                    <!--    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                    <!--      <i class="fas fa-ellipsis-v"></i>-->
                    <!--    </a>-->
                    <!--    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">-->
                    <!--    <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"-->
                    <!--      data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"-->
                    <!--          title="Delete">&#xE872; Delete</i></a>-->
                    <!--      <a class="dropdown-item" href="#">Another action</a>-->
                    <!--      <a class="dropdown-item" href="#">Something else here</a>-->
                    <!--    </div>-->
                    <!--  </div>-->
                    <!--</td>-->


                  </tr>


               @endforeach

               <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form_delete" method="POST">
                                        @csrf
                                        @method('delete')
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete element</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete these Records?</p>
                                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="Cancel">

                                            <button class="btn btn-danger">Delete</button>


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
                            {{ $teachers->links() }}
                        </div>
                    </div>
                </div>

    </div>
</div>




            <div class="modal fade createTeacherModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" action="{{ route('admin.teacher_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">إنشاء مدرّس</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
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
                                
                                
                                <!--<div class="form-group">-->
                                <!--    <label>العمر</label>-->
                                <!--    <input type="number" name="age" class="form-control b"-->
                                <!--        value=""-->
                                <!--        placeholder="اكتب العمر" style="direction:rtl" required>-->
                                <!--</div>-->


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
                                    <input type="email" name="email" class="form-control b email"
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
                                                    <input name="password" type="password" value="" size="15" onkeyup="return passwordChanged();"
                                                    class="input form-control" id="password" placeholder="اكتب كلمة المرور"
                                                    required="true" aria-label="password" aria-describedby="basic-addon1" />
                                                    <div class="input-group-append">
                                                    <span class="input-group-text" onclick="password_show_hide();">
                                                        <i class="fas fa-eye" id="show_eye"></i>
                                                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div id="strength" style="margin-top: -18px"> </div>




                                                <label for="">تأكيد كلمة المرور</label>
                                                <br>


                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                                    </div>
                                                    <input name="password_confirmation" type="password" value="" size="15" onkeyup="return passwordChanged();"
                                                    class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور"
                                                    required="true" aria-label="password" aria-describedby="basic-addon1" />
                                                    <div class="input-group-append">
                                                    <span class="input-group-text" onclick="password_show_hide2();">
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


                                {{-- <div class="form-group">
                                    <label>To Class</label>

                                    <select name="class_id[]" id="classes" class="form-control classes dep"
                                        style="min-height: 36px;direction: rtl">
                                        <option value="">اختر الصف الدراسي</option>

                                    @foreach ($classes as $class)

                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach

                                    </select>

                                </div> --}}
                        



                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-info" id="save">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>



$(document).on('focusout','.email',function(){
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
var type="";

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
                  
                <a href="teachers/teacher_details/${value.id}" target="_blank">
                    <i class="fa fa-eye fa-2x" style="color: blue"></i>

                    </a>

                    <a href="teacher/set_task/${value.id}" target="_blank" class="btn btn-success btn-sm">تحديد مهام</a>
                        <a href="teacher/edit_task/${value.id}" target="_blank" class="btn btn-warning btn-sm">تعديل المهام</a>






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











$('.delete').on('click', function () {
    var id = $(this).data('id');
    var url = "{{URL::to('SMARMANger/admin/students')}}";
    $('#form_delete').attr("action", url);


});












});
</script>

<script language="javascript">
    var pwd = document.getElementById("password");
pwd.onclick=function(){
document.getElementById('alert').innerText=
"يجب ان يحتوي احرف كبيرة و صغيرة و رموز";
}
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
