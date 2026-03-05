@extends('admin.master')
@section('style')
<style>

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
    .pl-lg-4 label{
        font-size: 20px;
        font-weight: 600;
        color: black !important;
    }

    .delete_vaccine {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

.vaccine-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>
@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a class="breadcrumbs__item is-active "> تعديل طالب </a>
    <a href="{{ route('students') }}" class="breadcrumbs__item ">قسم شؤون الطلاب الطلاب</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

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






          <div class="card-body" style="text-align:right" >

            <form method="post" action="{{ route('student_vaccines_update',$student->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
       <input type="hidden" value="{{$student->id}}" name="student_id">
              <div class="pl-lg-4">

                <div class="row">

        <div class="col-lg-12">


       <h1 class="heading-small text-muted mb-4" style="font-size: 30px">  اللقاحات قبل سن المدرسة  </h1>

</div>
@if(!empty($student_vaccines) && !empty($student_vaccines->before_vaccines))
@foreach(json_decode($student_vaccines->before_vaccines,true) as $item)
         <div class="col-lg-6 vaccines">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name"> اسم اللقاح</label>
                      <button style="background-color: #f44336; color: white;border: none;padding: 5px 10px;cursor: pointer;" class="delete_vaccince" >delete</button>

                      <input type="text" id="input-first-name" name="vaccines_name[]"  class="form-control" value="{{$item['vaccines_name']}}">
                    </div>
                  </div>







                  @endforeach
                  @endif

                  <div id="next_vaccines"  class="col-lg-12">

                  </div>



             <div class="col-lg-6">



              <a class="btn btn-success btn-block add_vaccines" style="background: #6ABAA3;border-color: #6ABAA3;color: white" >اضافة لقاح </a>
            </form>
          </div>








             <div class="col-lg-12">

     <h1 class="heading-small text-muted mb-4" style="font-size: 30px">  اللقاحات في سن المدرسة  </h1>


          </div>
@if(!empty($student_vaccines) && !empty($student_vaccines->current_vaccines))
 @foreach(json_decode($student_vaccines->current_vaccines,true) as $item)
 <div class="current_vaccines">
    <h3 style="display: inline-block;">لقاح جديد</h3>
                        <button style="background-color: #f44336; color: white;border: none;padding: 5px 10px;cursor: pointer;" class="delete_current_vaccines" >delete</button>
<div class="row">

 <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name"> اسم اللقاح</label>
                      <input type="text" id="input-first-name" name="vaccines_current_name[]"  class="form-control" value="{{$item['vaccines_current_name']}}">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    التاريخ  </label>
                      <input type="date" id="input-first-name" name="date[]"  class="form-control" value="{{$item['date']}}">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    الطبيب  </label>
                      <input type="text" id="input-first-name" name="doctor[]"  class="form-control" value="{{$item['doctor']}}">
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <hr style="color:black">

                  </div>
                </div>
            </div>

           @endforeach
           @endif
                  <div id="next_current_vaccines"  class="col-lg-12">

                  </div>


             <div class="col-lg-6">



              <a class="btn btn-success btn-block add_current_vaccines" style="background: #6ABAA3;border-color: #6ABAA3;color: white" >اضافة لقاح </a>
            </form>
          </div>

<!---------------------------------------------->




             <div class="col-lg-12">

     <h1 class="heading-small text-muted mb-4" style="font-size: 30px"> الامرض المزمنة و الاوبئة قبل المدرسة </h1>


          </div>
@if(!empty($student_vaccines) && !empty($student_vaccines->old_illness))
 @foreach(json_decode($student_vaccines->old_illness,true) as $item)
 <div class="old_illness">

    <h3 style="display: inline-block;">مرض جديد</h3>
                        <button style="background-color: #f44336; color: white;border: none;padding: 5px 10px;cursor: pointer;" class="delete_old_illness" >delete</button>

    <div class="row">

         <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name"> اسم المرض</label>
                      <input type="text" id="input-first-name" name="old_illness_name[]"  class="form-control" value="{{$item['old_illness_name']}}">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name"> اعراض المرض</label>
                      <input type="text" id="input-first-name" name="old_illness_description[]"  class="form-control" value="{{$item['old_illness_description']}}">
                    </div>
                  </div>



                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">تاريخ حدوث المرض  </label>
                      <input type="date" id="input-first-name" name="date_old_illness[]"  class="form-control" value="{{$item['date_old_illness']}}">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    العلاج  </label>
                      <input type="text" id="input-first-name" name="old_illness_treatment[]"  class="form-control" value="{{$item['old_illness_treatment']}}">
                    </div>
                  </div>
                  </div>


                      <div class="col-lg-12">
                  <hr style="color:black">

                </div>
                  </div>

           @endforeach
           @endif
                  <div id="next_old_illness"  class="col-lg-12">

                  </div>


             <div class="col-lg-6">



              <a class="btn btn-success btn-block add_old_illness" style="background: #6ABAA3;border-color: #6ABAA3;color: white" >اضافة مرض </a>
            </form>
          </div>
















<!----------------------------------->



             <div class="col-lg-12">

     <h1 class="heading-small text-muted mb-4" style="font-size: 30px">     الأمراض و الحوادث خلال سنوات الدراسة    </h1>


          </div>
@if(!empty($student_vaccines) && !empty($student_vaccines->current_illness))
          @foreach(json_decode($student_vaccines->current_illness,true) as $item)

          <div class="current_illness">
            <h3 style="display: inline-block;">مرض جديد</h3>
                                <button style="background-color: #f44336; color: white;border: none;padding: 5px 10px;cursor: pointer;" class="delete_current_illness" >delete</button>
  <div class="row">

         <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">  التاريخ  </label>
                      <input type="date" id="input-first-name" name="date_illness[]"  class="form-control" value="{{$item['date_illness']}}">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    التشخيص  </label>
                      <input type="text" id="input-first-name" name="diagnosis[]"  class="form-control" value="{{$item['diagnosis']}}">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    مدة الاستراحة  </label>
                      <input type="text" id="input-first-name" name="break_duration[]"  class="form-control" value="{{$item['break_duration']}}">
                    </div>
                  </div>





                                             <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">     العلاج    </label>
                      <input type="text" id="input-first-name" name="treatment[]"  class="form-control" value="{{$item['treatment']}}">
                    </div>
                  </div>


                                             <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">     اجراءات أخرى    </label>
                      <input type="text" id="input-first-name" name="other_options[]"  class="form-control" value="{{$item['other_options']}}">
                    </div>

                  </div>
                  </div>

                <div class="col-lg-12">
                  <hr style="color:black">

                </div>

                   </div>

                  @endforeach
                  @endif


                  <div id="next_current_illness"  class="col-lg-12">

                  </div>


             <div class="col-lg-6">



              <a class="btn btn-success btn-block add_current_illness" style="background: #6ABAA3;border-color: #6ABAA3;color: white;margin-bottom: 50px;" >اضافة مرض </a>
            </form>
          </div>


              <div class="col-lg-12">



              <button class="btn btn-success btn-block " style="background: #6ABAA3;border-color: #6ABAA3;color: white" >تحديث </button>
            </form>
          </div>





    </div>
      </div>
      <div class="col-xl-1 col-lg-1 col-12"></div>


</div>
</div>
</div>
</div>



<script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>





<script>
$(document).on('click','.delete_vaccince',function(e){
             e.preventDefault();
            // Remove the closest parent div of the clicked delete link
            this.closest('.col-lg-6').remove();
     });


$(document).on('click','.add_vaccines',function(e){

    e.preventDefault();

    var type=`

<div class="vaccince">
         <div class="col-lg-6">
                     <h3 style="display: inline-block;">لقاح جديد</h3>
                    <button style="background-color: #f44336; color: white;border: none;padding: 5px 10px;cursor: pointer;" class="delete_vaccince" >delete</button>

                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name"> اسم اللقاح</label>
                      <input type="text" id="input-first-name" name="vaccines_name[]"  class="form-control" value="">
                    </div>

                  </div>
                  </div>



    `;


    $('#next_vaccines').append(type);
}) ;

$(document).on('click','.delete_current_vaccines',function(e){
             e.preventDefault();
            // Remove the closest parent div of the clicked delete link
            this.closest('.current_vaccines').remove();
     });

$(document).on('click','.add_current_vaccines',function(e){

    e.preventDefault();

    var type=`
 <div class="current_vaccines">
          <h3 style="display: inline-block;">لقاح جديد</h3>
                              <button style="background-color: #f44336; color: white;border: none;padding: 5px 10px;cursor: pointer;" class="delete_current_vaccines" >delete</button>
<div class="row">

              <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name"> اسم اللقاح</label>
                      <input type="text" id="input-first-name" name="vaccines_current_name[]"  class="form-control" value="">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    التاريخ  </label>
                      <input type="date" id="input-first-name" name="date[]"  class="form-control" value="">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    الطبيب  </label>
                      <input type="text" id="input-first-name" name="doctor[]"  class="form-control" value="">
                    </div>
                  </div>
                    </div>
 </div>




    `;


    $('#next_current_vaccines').append(type);
}) ;



// ----------------------


$(document).on('click','.delete_old_illness',function(e){
             e.preventDefault();
            // Remove the closest parent div of the clicked delete link
            this.closest('.old_illness').remove();
     });


$(document).on('click','.add_old_illness',function(e){

    e.preventDefault();

    var type=`
 <div class="old_illness">

          <h3 style="display: inline-block;">مرض جديد</h3>
                              <button style="background-color: #f44336; color: white;border: none;padding: 5px 10px;cursor: pointer;" class="delete_old_illness" >delete</button>

          <div class="row">

         <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name"> اسم المرض</label>
                      <input type="text" id="input-first-name" name="old_illness_name[]"  class="form-control"  >
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name"> اعراض المرض</label>
                      <input type="text" id="input-first-name" name="old_illness_description[]"  class="form-control" >
                    </div>
                  </div>



                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">تاريخ حدوث المرض  </label>
                      <input type="date" id="input-first-name" name="date_old_illness[]"  class="form-control" >
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    العلاج  </label>
                      <input type="text" id="input-first-name" name="old_illness_treatment[]"  class="form-control" >
                    </div>
                  </div>
                  </div>
         </div>



    `;


    $('#next_old_illness').append(type);
}) ;















// -------------------------------



$(document).on('click','.delete_current_illness',function(e){
             e.preventDefault();
            // Remove the closest parent div of the clicked delete link
            this.closest('.current_illness').remove();
     });


$(document).on('click','.add_current_illness',function(e){

    e.preventDefault();

    var type=`
<div class="current_illness">
          <h3 style="display: inline-block;">مرض جديد</h3>
                              <button style="background-color: #f44336; color: white;border: none;padding: 5px 10px;cursor: pointer;" class="delete_current_illness" >delete</button>
<div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">  التاريخ  </label>
                      <input type="date" id="input-first-name" name="date_illness[]"  class="form-control" value="">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    التشخيص  </label>
                      <input type="text" id="input-first-name" name="diagnosis[]"  class="form-control" value="">
                    </div>
                  </div>


                           <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">    مدة الاستراحة  </label>
                      <input type="text" id="input-first-name" name="break_duration[]"  class="form-control" value="">
                    </div>
                  </div>





                                             <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">     العلاج    </label>
                      <input type="text" id="input-first-name" name="treatment[]"  class="form-control" value="">
                    </div>
                  </div>


                                             <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">     اجراءات أخرى    </label>
                      <input type="text" id="input-first-name" name="other_options[]"  class="form-control" value="">
                    </div>
                  </div>
                  </div>


</div>


    `;


    $('#next_current_illness').append(type);
}) ;



$(document).on('focusout','.email',function(){

    $('.er').hide();
    $('.validate_email').text('');
var email=$(this).val();
     $.ajax({
url: "{{ URL::to('SUNRISEMANger/admin/validate_email1') }}",
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

    var url = "{{ URL::to('SUNRISEMANger/admin/classes/rooms') }}/" + class_id ;
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
