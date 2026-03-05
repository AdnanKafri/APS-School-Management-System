@extends('admin.master')
<!--@section('search')
<!--<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">-->
<!--    <div class="form-group mb-0">-->
<!--      <div class="input-group input-group-alternative input-group-merge">-->
<!--        <div class="input-group-prepend">-->
<!--          <span class="input-group-text"><i class="fas fa-search"></i></span>-->
<!--        </div>-->
<!--        <input class="form-control" name="search_teacher" id="search_teacher" placeholder="Search" type="text">-->
<!--      </div>-->
<!--    </div>-->
<!--    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">-->
<!--      <span aria-hidden="true">×</span>-->
<!--    </button>-->
<!--  </form>-->
<!--@endsection-->
@section('content')
<div class="col" style="direction:rtl;text-align:right">
    <div class="card">

        @if ($errors->any())
        @foreach ($errors->all() as $error)

            <div class="alert alert-danger" >

                <h4 style="color: #FFF; font-size:30px" >   عذرا , لم يتم تسجيل الحساب يرجى اعادة الادخال
                </h4>

            </div>


        @endforeach
    @endif

<!--@if(session()->has('success'))-->

<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->

            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">جدول الحسابات</h3>

            </div>
<div class="table-responsive">
    <a href=".createTermModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">انشاء حساب جديد</i></a>

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">#</th>
                    <th scope="col" class="sort" data-sort="budget">الاسم</th>
                    <th scope="col" class="sort" data-sort="status"> البريد الالكتروني</th>
                    <th scope="col" class="sort" data-sort="budget">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                    @php
                        $i = 0;
                    @endphp
                @foreach ($users as $item)

               <tr id="user_{{ $item->id }}">
                    <td>{{ ++$i }}</td>
                    <td class="budget">
                    {{$item->name}}

                  </td>

                  <td class="budget">
                    {{$item->email}}

                  </td>

                  <td class="budget">


                 <a href=".edituserModal" class="edit btn btn-info btn-sm" data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                    data-email={{ $item->email }} data-mobile={{ $item->mobile }} data-role_id={{ $item->role_id }} data-toggle="modal" >
                   <i class="fa fa-pen"></i>
               </a>
                 <a class="share_coordinator btn btn-info btn-sm" data-toggle="modal" data-target="#user_name_modal" data-username="{{ $item->email }}" data-name="{{ $item->name }}" data-pass="{{ $item->view_password }}" title = "معلومات الأيميل">
                             <i class="fa fa-send fa-x" style="color: #eff0f1"></i>
                 </a>

               <a  data-id="{{ $item->id }}" class="one btn btn-info btn-sm"
                href=".active_result" data-toggle="modal">
                <i style="" class="fa fa-trash"></i>
                </a>

                  </td>




                  </tr>


               @endforeach



                </tbody>
              </table>

            </div>












            <div class="clearfix" style="padding-left:10px">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/20) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-10">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>



    </div></div>







    <div class="modal fade edituserModal" style="">
        <div class="modal-dialog">
            <div class="modal-content" style="">

                <div class="modal-header" style="direction: rtl" >
                    <h4 class="modal-title" style="" >تعديل حساب</h4>

                    {{-- <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true" style="">&times;</button> --}}

                </div>

                <div class="modal-body" style="direction: rtl; text-align: right">

                <form id="form_update" action="{{ route('admin.user_update') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" name="user_id" id="user_id">

                    <div class="form-group" style="text-align:right">
                        <label>الاسم</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="" style="direction: rtl" maxlength="20"
                            placeholder="" required>
                    </div>

                    <div class="form-group" >
                        <label>البريد الالكتروني</label>
                        <input type="text" name="email" id="email" class="form-control email"
                            value="" style="direction: ltr"
                            placeholder="" required>




                        </div>


                    <div class="form-group"  >
                        <label>الموبايل</label>
                        <input type="text" name="mobile" id="mobile" class="form-control"
                            value="" style="direction: ltr" maxlength="20"
                            placeholder="" required>
                    </div>



                    <div class="form-group">
                        <label>الصلاحيات </label>

                        <select name="role_id" class="form-control" id="role_id"
                            style="min-height: 36px;direction: rtl" required>


                        @foreach ($roles as $role)

                        <option value="{{ $role->id }}" >{{ $role->name }}</option>
                        @endforeach

                        </select>

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">الغاء </a>
                        <button class="btn btn-info">حفظ</button>
                    </div>
                </form>

            </div>

            </div>
        </div>
    </div>




    <div class="col-md-12" class="delete_modal">
        {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
        <div class="modal fade active_result" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
          <div class="modal-content bg-gradient-danger">
            <form id="form_delete" method="POST">
                @csrf
                @method('delete')
              <div class="modal-header">
                  <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                  <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true" class="close">×</span>
                  </a>
              </div>

              <div class="modal-body">

                  <div class="py-3 text-center">
                      <i class="ni ni-bell-55 ni-3x"></i>
                      <h4 class="heading mt-4">You should read this!</h4>
                      <p>Are you sure you want to delete the item ?</p>
                  </div>

              </div>

              <div class="modal-footer">
                  <a  class="btn btn-white delete_event" id="delete_event"   href="">Ok, Got it</a>
                  <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
              </div>
            </form>
          </div>
      </div>
    </div>

    </div>




            <div class="modal fade createTermModal">
                <div class="modal-dialog">
                    <div class="modal-content" style="direction: rtl; text-align: right">
                        <form id="form_update" action="{{ route('admin.user_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">إنشاء حساب جديد</h4>


                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>الاسم</label>
                                    <input type="text" name="name" class="form-control"
                                        value="" style="direction: rtl" maxlength="20"
                                        placeholder="" required>
                                </div>

                                {{-- <div class="form-group" >
                                    <label>البريد الالكتروني</label>
                                    <input type="text" name="email" class="form-control"
                                        value="" style="direction: ltr"
                                        placeholder="" required>
                                </div> --}}


                                <div class="form-group"  >
                                    <label>الموبايل</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="" style="direction: ltr" maxlength="20"
                                        placeholder="" required>
                                </div>


                                <!-- <label>كلمة المرور</label>-->
                                <!--<br>-->
                                <!--<div class="input-group mb-3">-->

                                <!--    <div class="input-group-prepend">-->
                                <!--    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>-->
                                <!--    </div>-->
                                <!--    <input name="password" type="password" value="" size="15" onkeyup="return passwordChanged3();"-->
                                <!--    class="input form-control" id="ppassword3" placeholder="كلمة المرور"-->
                                <!--    required="true" aria-label="password" aria-describedby="basic-addon1" />-->
                                <!--    <div class="input-group-append">-->
                                <!--    <span class="input-group-text" onclick="ppassword_show_hide3();">-->
                                <!--        <i class="fas fa-eye" id="sshow_eye3"></i>-->
                                <!--        <i class="fas fa-eye-slash d-none" id="hhide_eye3"></i>-->
                                <!--    </span>-->
                                <!--    </div>-->
                                <!--</div> -->


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
                            <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-info">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>


<script>
$(document).on("click",".share_coordinator",function () {
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


$(document).on('click','.edit_coordinator',function (e) {
    var data = $(this).data('data');

    $('#edit_coordinator_id').val(data.id);
    $('#edit_first_name').val(data.first_name);
    $('#edit_last_name').val(data.last_name);
    $('#edit_date_birth').val(data.date_birth);
    $('#edit_address').val(data.address);
    $('#edit_phone').val(data.phone);
    $('#edit_email').val(data.email);

    console.log(data.id);
});

                
// function ppassword_show_hide3() {
//     var x = document.getElementById("ppassword3");
//     var show_eye = document.getElementById("sshow_eye3");
//     var hide_eye = document.getElementById("hhide_eye3");
//     hide_eye.classList.remove("d-none");
//     if (x.type === "password") {
//     x.type = "text";
//     show_eye.style.display = "none";
//     hide_eye.style.display = "block";
//     } else {
//     x.type = "password";
//     show_eye.style.display = "block";
//     hide_eye.style.display = "none";
//     }
//     }



// $(document).on('focusout','.email',function(){
//     $('.validate_email').text('');

// var email=$(this).val();
//      $.ajax({
// url: "{{ URL::to('SMARMANger/admin/validate_email1') }}",
// type: "get",
// contentType: 'application/json',
// data : {
//     '_token':"{{ csrf_token() }}",
//     'email':email,
// },
// success: function (data) {

//       },
// error: function (xhr) {
//     $('.validate_email').html("<div >! عذرا , هذا الايميل موجود مسبقا</div> ");

// }

// });



// });

$(document).on('click', '.edit', function () {

    var id = $(this).data('id');
    var name=$(this).data('name');
    var email=$(this).data('email');
    var mobile = $(this).data('mobile');
    var role_id = $(this).data('role_id');


    $('#user_id').val(id);
    $('#name').val(name);
    $('#email').val(email);
    $('#mobile').val(mobile);
    $('#role_id').val(role_id);





});



        $(document).on('click' , '.one' , function () {

        var id=$(this).data('id');

        $('.delete_event').data('id',id);

        });



        $(document).on('click','.delete_event',function(e){
        e.preventDefault();

        var id=$(this).data('id');

        $.ajax({

        type:'post',
        url:"{{ route('admin.user.delete') }}",
        enctype:'multipart/form-data',
        data:{
        '_token':"{{ csrf_token() }}",
        'user_id':id,

        },

        success:function(data){
        console.log(data);
        $(`#user_${id}`).remove();
        $(".modal").modal('hide');

        swal({
        title: "حسناً",
        text: "! تمت العملية بنجاح",
        icon: "success",
        button: "OK",
        timer: 2000

        });
        },
        error: function (xhr) {

        }

        });


        });
</script>

@endsection
