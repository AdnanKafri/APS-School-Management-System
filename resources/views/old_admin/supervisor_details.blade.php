@extends('admin.layouts.app')
@section('search')


@endsection
@section('content')

<!--@if(session()->has('success'))-->

<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->



<div class="row">


    <div class="col-xl-4 order-xl-2">


        <div class="modal fade resetsupervisorPassword">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form_update" action="{{ route('admin.reset_supervisor_password',$supervisor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">تغيير كلمة المرور</h4>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">






                            <label for="">كلمة المرور</label>
                            <br>


                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                </div>
                                <input name="password" type="password" value="" size="15" onkeyup="return pppasswordChanged();"
                                class="input form-control" id="pppassword" placeholder="اكتب كلمة المرور"
                                required="true" aria-label="password" aria-describedby="basic-addon1" />
                                <div class="input-group-append">
                                <span class="input-group-text" onclick="pppassword_show_hide();">
                                    <i class="fas fa-eye" id="ssshow_eye"></i>
                                    <i class="fas fa-eye-slash d-none" id="hhhide_eye"></i>
                                </span>
                                </div>
                            </div>



                            <label for="">تأكيد كلمة المرور</label>
                            <br>


                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                </div>
                                <input name="password_confirmation" type="password" value="" size="15" onkeyup="return pppasswordChanged();"
                                class="input form-control" id="pppassword-confirm" placeholder="أعد كتابة كلمة المرور"
                                required="true" aria-label="password" aria-describedby="basic-addon1" />
                                <div class="input-group-append">
                                <span class="input-group-text" onclick="pppassword_show_hide2();">
                                    <i class="fas fa-eye" id="ssshow_eye2"></i>
                                    <i class="fas fa-eye-slash d-none" id="hhhide_eye2"></i>
                                </span>
                                </div>
                            </div>





                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                            <button class="btn btn-info">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

      </div>


      <div class="col-xl-8 order-xl-1">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-0">تعديل معلومات الحساب </h3>
              </div>
              <div class="col-4 text-right">



                <a  class=" btn btn-outline-danger" href=".resetsupervisorPassword" data-toggle="modal">
                    <i class="ni ni-single-copy-04 text-default"></i>
                    <span class="nav-link-text">تغيير كلمة المرور</span>
                </a>


              </div>
            </div>
          </div>





          <div class="card-body">
            <form method="post" action="{{ route('admin.supervisor_update',$supervisor->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
              <h6 class="heading-small text-muted mb-4">معلومات المستخدم</h6>
              <div class="pl-lg-4">

                <div class="row">

              <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="input-email">البريد الإلكتروني</label>
                    <input type="email" id="input-email" name="email" class="form-control email" value="{{ $supervisor->email }}">

                    @error('email')
                    <div class="error er" style="color: red" >عذرا , الايميل موجود مسبقا</div>
                @enderror

                <span class="text-danger error validate_email">


                </span>
                </div>
                </div>


                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">الإسم الأول</label>
                      <input type="text" id="input-first-name" name="first_name" class="form-control" value="{{ $supervisor->first_name }}">
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-last-name">الكنية</label>
                      <input type="text" id="input-last-name" name="last_name" class="form-control" value="{{ $supervisor->last_name }}">
                    </div>
                  </div>



                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-username">تاريخ الميلاد</label>
                      <input type="date" id="input-last-name" name="date_birth" required class="form-control"  value="{{ $supervisor->date_birth }}">
                    </div>
                  </div>



    {{-- ------------------------------------- --}}

                </div>
              </div>
              <hr class="my-4">
              <!-- Address -->
              <h6 class="heading-small text-muted mb-4">معلومات التواصل</h6>
              <div class="pl-lg-4">
                <div class="row">

                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-control-label" for="input-address">العنوان</label>
                      <input id="input-address" class="form-control" name="address" placeholder="Home Address" value="{{ $supervisor->address }}" type="text">
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-country">الهاتف</label>
                      <input type="text" id="input-phone" name="phone" class="form-control" value="{{ $supervisor->phone }}">
                    </div>
                  </div>
                </div>

              </div>
              <hr class="my-4">





              <div class="pl-lg-4 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-country">الصورة الشخصية</label>
                    <br>
                    @if ($supervisor->image!=null)

                <img src="{{ asset('storage/'.$supervisor->image) }}" class="rounded-circle" width="40%" alt="">
                @endif

                <input type="file" name="image"  class="form-control">
                </div>
              </div>



              <button class="btn btn-success btn-block" >تأكيد </button>
            </form>
          </div>





    </div>
      </div>




</div>





<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>





<script>


$(document).on('focusout','.email',function(){
    $('.er').hide();
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


$('.alert-success').hide(3000);

    function pppassword_show_hide() {
    var x = document.getElementById("pppassword");
    var show_eye = document.getElementById("ssshow_eye");
    var hide_eye = document.getElementById("hhhide_eye");
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




    function pppassword_show_hide2() {
    var x = document.getElementById("pppassword-confirm");
    var show_eye = document.getElementById("ssshow_eye2");
    var hide_eye = document.getElementById("hhhide_eye2");
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
