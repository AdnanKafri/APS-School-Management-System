@extends('admin.master')
@section('style')
<style>
*{
    direction: rtl !important;
}
.form-group{
    direction: rtl !important;
    text-align: right;
}
.heading-small{
    text-align: center !important;
    color: #001586 !important;
    font-size: 20px
}
</style>
<style>
    .custom-file-label{
        display:none;
    }
</style>
@endsection
@section('content')

@if(session()->has('success'))

  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     {{ session()->get('success') }}
    </div>
@endif



<div class="row">

        <div class="col-xl-1 col-lg-1 col-12"></div>
      <div class="col-xl-10 col-lg-10 col-12">
    <div class="card" style="margin: 30px">
        <div class="card-header">
            <div class="row align-items-center">
              <div class="col-6">
                <h2 class="mb-0" style="color: #001586"> تعديل طالب </h2>
              </div>
              <div class="col-6 text-right">
                <span  class="btn btn-lg btn-primary">

                    @if ($student->place=='inside')
                    داخلي
                    @else
                    خارجي
                    @endif
                </span>

                <span  class="btn btn-lg btn-warning">

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
            <form method="post" action="{{ route('student_update',$student->id) }}" enctype="multipart/form-data">
                @csrf
                @method('post')
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






              <button class="btn btn-success btn-block " style="background: #6ABAA3;border-color: #6ABAA3;color: white" >تحديث </button>
            </form>
          </div>





    </div>
      </div>
      <div class="col-xl-1 col-lg-1 col-12"></div>


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
