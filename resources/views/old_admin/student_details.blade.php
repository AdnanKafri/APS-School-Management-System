@extends('admin.layouts.app')
@section('search')


@endsection

<head>

    <style>
        .custom-file-label{
            display:none;
        }
    </style>
</head>
@section('content')

@if(session()->has('success'))

  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     {{ session()->get('success') }}
    </div>
@endif



<div class="row">


    <div class="col-xl-4 order-xl-2">
        <div class="card card-profile">
          <img src="{{ asset('students/images/animation-bg.jpg') }}" alt="Image placeholder" class="card-img-top">
          <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
              <div class="card-profile-image">

    @if($student->image!=null)
                  <img src="{{ asset('storage/'.$student->image) }}" class="rounded-circle">
@endif
              </div>
            </div>
          </div>
          <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
            <div class="d-flex justify-content-between">
              <span  class="btn btn-sm btn-info  mr-4 ">


                    @if ($student->place=='inside')
                    داخلي
                    @else
                    خارجي
                    @endif




              </span>
              <span  class="btn btn-sm btn-default float-right">



                    @if ($student->transparent=='new')
                    قديم
                    @else
                    منقول
                    @endif

              </span>
            </div>
          </div>
          <div class="card-body pt-0">
            <div class="row">
              <div class="col">
                <div class="card-profile-stats d-flex justify-content-center">
                  <div>
                    <span class="heading">{{ $student->room[0]->classes->name }}</span>
                    <span class="description">الصف</span>
                  </div>
                  <div>
                    <span class="heading">{{ $student->room[0]->name }}</span>
                    <span class="description">الشعبة</span>
                  </div>
                  <div>
                    <span class="heading">{{ $student->date_birth }}</span>
                    <span class="description">تاريخ الميلاد </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center">
              <h5 class="h3">
               {{ $student->first_name }}  {{ $student->last_name }}

                <span class="font-weight-light">, {{ $student->date_birth }}</span>
              </h5>
              <div class="h5 font-weight-300">
                <i class="ni location_pin mr-2"></i>{{ $student->nationality }}, {{ $student->place_birth }}
              </div>

              <div>
                <i class="ni education_hat mr-2"></i>  {{$school_data->name}}  </div>
            </div>
          </div>
        </div>



                <a class=" btn btn-outline-danger" href=".resetstudentPassword" data-toggle="modal" ">
            <i class="ni ni-single-copy-04 text-default"></i>
            <span class="nav-link-text">تغيير كلمة المرور</span>
        </a>



        <div class="modal fade resetstudentPassword">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form_update" action="{{ route('admin.reset_student_password',$student->id) }}" method="POST" enctype="multipart/form-data">
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
                                class="input form-control" id="pppassword" placeholder="كلمة المرور"
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
                                class="input form-control" id="pppassword-confirm" placeholder="إعادة كلمة المروو "
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
                <h3 class="mb-0">Edit student </h3>
              </div>
              <div class="col-4 text-right">
                <span  class="btn btn-sm btn-primary">

                    @if ($student->place=='inside')
                    داخلي
                    @else
                    خارجي
                    @endif
                </span>

                <span  class="btn btn-sm btn-warning">

                    @if ($student->transparent=='new')
                    قديم
                    @else
                    منقول
                    @endif
                </span>
              </div>
            </div>
          </div>





          <div class="card-body">
            <form method="post" action="{{ route('admin.student_update',$student->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
              <h6 class="heading-small text-muted mb-4">المعلومات الشخصية</h6>
              <div class="pl-lg-4">

                <div class="row">

              <div class="col-lg-6">
              <div class="form-group">
                    <label class="form-control-label" for="input-email">البريد الإلكتروني</label>
                    <input type="email" id="input-email" name="email" required class="form-control email" value="{{ $student->email }}">

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
                      <input type="text" id="input-first-name" name="first_name" required class="form-control" value="{{ $student->first_name }}">
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-last-name">الكنية</label>
                      <input type="text" id="input-last-name" name="last_name" required class="form-control" value="{{ $student->last_name }}">
                    </div>
                  </div>


                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">اسم الأب</label>
                      <input type="text" id="input-first-name" name="father_name" required class="form-control" value="{{ $student->father_name }}">
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-last-name">اسم الأم</label>
                      <input type="text" id="input-last-name" name="mother_name" class="form-control"  value="{{ $student->mother_name }}">
                    </div>
                  </div>


                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-last-name">تاريخ الميلاد</label>
                      <input type="date" id="input-last-name" name="date_birth"  class="form-control"  value="{{ $student->date_birth }}">
                    </div>
                  </div>


                  <div class="col-lg-12">
                    <div class="form-group">
                        <label>الديانة</label>

                        <select name="religion" id="" class="form-control dep"
                            style="min-height: 36px;direction: rtl" required>


                        <option value="0" {{ $student->religion == '0' ? 'selected' :''}} >
                                     اسلامية
                      </option>


                        <option value="1" {{ $student->religion == '1'  ? 'selected' :''}} >
                          مسيحية
                                      </option>
                        </select>

                    </div>
                  </div>



                  <!-- <div class="col-lg-12">
                    <div class="form-group">
                        <label>الصف</label>

                        <select name="class_id" id="classes" class="form-control dep"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="">اختر الصف الدراسي</option>

                        @foreach ($classes as $class)

                        <option value="{{ $class->id }}"  {{ $student->room[0]->classes->id  ==  $class->id   ? 'selected' :''}}

                            >{{ $class->name }}</option>
                        @endforeach

                        </select>

                    </div>
                  </div> -->

<input type="hidden" name="class_id" value="{{ $student->room[0]->classes->id}}">

                  <div class="col-lg-12">

                  <div class="form-group" id="class_room">

                    <label>الشعبة</label>

                    <select name="room_id" id="" class="form-control"
                        style="min-height: 36px;direction: rtl" required>
                        <option value="">اختر الشعبة الدراسي</option>

                    @foreach ($rooms as $room)

                    <option value="{{ $room->id }}"  {{ $student->room[0]->id  ==  $room->id   ? 'selected' :''}}

                        >{{ $room->name }}</option>
                    @endforeach

                    </select>


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
                      <input id="input-address" class="form-control" name="address" placeholder="عنوان السكن" value="{{ $student->address }}" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-city">الجنسية</label>
                      <input type="text" id="input-city" name="nationality" class="form-control" placeholder="البلد" value="{{ $student->nationality }}">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-country">مكان الولادة</label>
                      <input type="text" id="input-country" name="place_birth"  class="form-control"  value="{{ $student->place_birth }}">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-country">الخانة</label>
                      <input type="number" id="input-postal-code" name="box_birth" class="form-control" value="{{ $student->box_birth }}">
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-country">شعبة التجنيد</label>
                      <input type="text" id="input-postal-code" name="army_room" class="form-control" value="{{ $student->army_room }}">
                    </div>
                  </div>


                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-country">الهاتف</label>
                      <input type="text" id="input-phone" name="phone" class="form-control" value="{{ $student->phone }}">
                    </div>
                  </div>


                </div>
              </div>
              <hr class="my-4">
              <!-- Description -->
              <h6 class="heading-small text-muted mb-4">الوثائق</h6>





              <div class="pl-lg-4 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-country">دفتر العائلة</label>
                   <br>
                           <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                    @if ($student->family_book_image!=null)

                <img src="{{ asset('storage/'.$student->family_book_image) }}" class="del_edit_img" id="image1" alt="Not found" width="100%" alt="">
                 <span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer">&times;</span>

                @endif
   <input type="file" name="family_book_image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image1" lang="en">
                        <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                </div>
              </div>


<hr>



              <div class="pl-lg-4 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-country">شهادة صحية </label>
                   <br>
                           <input type="hidden" class="del" name="del_img2" value="del_img2" disabled="disabled">

                    @if ($student->health_certificate_image!=null)

                <img src="{{ asset('storage/'.$student->health_certificate_image) }}" class="del_edit_img" id="image2" alt="Not found" width="100%" alt="">
                 <span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer">&times;</span>

                @endif
   <input type="file" name="health_certificate_image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image2" lang="en">
                        <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                </div>
              </div>




<hr>



              <div class="pl-lg-4 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-country">شهادة مدرسية 1</label>
                   <br>
                           <input type="hidden" class="del" name="del_img3" value="del_img3" disabled="disabled">

                    @if ($student->school_seq_image1!=null)

                <img src="{{ asset('storage/'.$student->school_seq_image1) }}" class="del_edit_img" id="image3" alt="Not found" width="100%" alt="">
                 <span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer">&times;</span>

                @endif
   <input type="file" name="school_seq_image1" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image3" lang="en">
                        <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                </div>
              </div>



<hr>






              <div class="pl-lg-4 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-country">شهادة مدرسية 2 </label>
                   <br>
                           <input type="hidden" class="del" name="del_img4" value="del_img4" disabled="disabled">

                    @if ($student->school_seq_image2!=null)

                <img src="{{ asset('storage/'.$student->school_seq_image2) }}" class="del_edit_img" id="image4" alt="Not found" width="100%" alt="">
                 <span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer">&times;</span>

                @endif
   <input type="file" name="school_seq_image2" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image4" lang="en">
                        <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                </div>
              </div>




<hr>


              <div class="pl-lg-4 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-country">صورة اخر شهادة </label>
                   <br>
                           <input type="hidden" class="del" name="del_img5" value="del_img5" disabled="disabled">

                    @if ($student->last_certificate_image!=null)

                <img src="{{ asset('storage/'.$student->last_certificate_image) }}" class="del_edit_img" id="image5" alt="Not found" width="100%" alt="">
                 <span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer">&times;</span>

                @endif
   <input type="file" name="last_certificate_image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image5" lang="en">
                        <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                </div>
              </div>


<hr>




              <div class="pl-lg-4 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-country"> الصورة الشخصية</label>
                   <br>
                           <input type="hidden" class="del" name="del_img6" value="del_img6" disabled="disabled">

                    @if ($student->image!=null)

                <img src="{{ asset('storage/'.$student->image) }}" class="del_edit_img rounded-circle" id="image6" alt="Not found" width="40%" alt="">
                 <span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer">&times;</span>

                @endif
   <input type="file" name="image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image6" lang="en">
                        <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                </div>
              </div>






              <button class="btn btn-success btn-block" >تحديث </button>
            </form>
          </div>





    </div>
      </div>

</div>










<div class="row">
    <div class="col-md-12">

        <div class="table-responsive" id="mydiv3" >

            <table class="table align-items-center table-flush " style="" >
              <thead class="thead-light">
                <tr>

                <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> مجموع الفصل الأول </th>

                <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> مجموع الفصل الثاني </th>

                <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> المجموع النهائي للفصلين</th>

                  {{-- <th scope="col" class="sort" data-sort="budget">Action</th> --}}
                </tr>
              </thead>
              <tbody class="list">

<tr>
<!--@foreach (json_decode($student_mark->term_result,true) as $key=>$value)-->

<!--<td style="font-weight: bold">{{round($value)  }}</td>-->


<!--@endforeach-->

<!--<td style="font-weight: bold">{{ round($student_mark->year_result) }}</td>-->

</tr>



              </tbody>
            </table>

          </div>
    </div>
</div>






<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>





<script>



$(document).on('focusout','.email',function(){

    $('.er').hide();
    $('.validate_email').text('');
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


  var loadFile = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };


    var loadFile_edit = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            input_image.previousElementSibling.setAttribute('style','display:none');
            input_image.previousElementSibling.previousElementSibling.setAttribute('style','display:none');

            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };


        $(document).on('click' , '.del_img' , function () {
            $(this).nextAll('.output').attr('style','display:none;');
            $(this).prevAll('.input_image:first').val('');
            $(this).hide();

        });

        $(document).on('click' , '.del_icon' , function () {
            $(this).prevAll('.del:first').attr('disabled',false );
            $(this).prevAll('.del_edit_img:first').hide();
            $(this).hide();

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

<script>

    $(document).ready(function () {



$(document).on('change', '#classes', function () {
    var class_id = $(this).val();

    var url = "{{ URL::to('SMARMANger/admin/classes/rooms') }}/" + class_id ;
    $.ajax({
        url: url,
        type: "get",
        contentType: 'application/json',
        success: function (data) {

            $('#class_room').empty();
            var type = `
            <label>الشعبة</label>

            <select name="room_id" id="" class="form-control dep"
                style="min-height: 36px;direction:rtl">
                <option value="">اختر الشعبة الدراسية</option>

                `;

            $.each(data, function (key, value) {


                type += `
<option value="${value.id}">${value.name}</option>

                  `;

            });

        type+=`
                </select>
                      `;
            $('#class_room').append(type);

        },
        error: function (xhr) {

        }

    });
});







});

</script>



            @endsection
