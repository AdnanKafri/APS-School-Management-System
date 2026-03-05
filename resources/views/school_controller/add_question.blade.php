@extends('school_controller.layouts.app')
@section('css')
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<style>
    .modal-body{
      text-align:center ;
    }
.container2 {
direction: rtl;
text-align: right;
max-width: 88%;
background: #F8F9FD;
background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
border-radius: 40px;
padding: 25px 35px;
border: 5px solid rgb(255, 255, 255);
box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
margin: 20px;
}

.heading {
text-align: center;
font-weight: 900;
font-size: 30px;
color: rgb(16, 137, 211);
}

.form {
margin-top: 20px;
}

.form .input {
width: 100%;
background: white;
border: none;
padding: 15px 20px;
border-radius: 20px;
margin-top: 15px;
box-shadow: #cff0ff 0px 10px 10px -5px;
border-inline: 2px solid transparent;
}

.form .input::-moz-placeholder {
color: rgb(170, 170, 170);
}

.form .input::placeholder {
color: rgb(170, 170, 170);
}

.form .input:focus {
outline: none;
border-inline: 2px solid #12B1D1;
}

.form .forgot-password {
display: block;
margin-top: 10px;
margin-left: 10px;
}

.form .forgot-password a {
font-size: 11px;
color: #0099ff;
text-decoration: none;
}

.form .login-button {
display: block;
width: 100%;
font-weight: bold;
background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
color: white;
padding-block: 15px;
margin: 20px auto;
border-radius: 20px;
box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
border: none;
transition: all 0.2s ease-in-out;
}

.form .login-button:hover {
transform: scale(1.03);
box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
}

.form .login-button:active {
transform: scale(0.95);
box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
}

.social-account-container {
margin-top: 25px;
}

.social-account-container .title {
display: block;
text-align: center;
font-size: 10px;
color: rgb(170, 170, 170);
}

.social-account-container .social-accounts {
width: 100%;
display: flex;
justify-content: center;
gap: 15px;
margin-top: 5px;
}

.social-account-container .social-accounts .social-button {
background: linear-gradient(45deg, rgb(0, 0, 0) 0%, rgb(112, 112, 112) 100%);
border: 5px solid white;
padding: 5px;
border-radius: 50%;
width: 40px;
aspect-ratio: 1;
display: grid;
place-content: center;
box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 12px 10px -8px;
transition: all 0.2s ease-in-out;
}

.social-account-container .social-accounts .social-button .svg {
fill: white;
margin: auto;
}

.social-account-container .social-accounts .social-button:hover {
transform: scale(1.2);
}

.social-account-container .social-accounts .social-button:active {
transform: scale(0.9);
}

.agreement {
display: block;
text-align: center;
margin-top: 15px;
}

.agreement a {
text-decoration: none;
color: #0099ff;
font-size: 9px;
}
/* css for add */
.cssbuttons-io-button {
position: relative;
top: 25px;
display: flex;
align-items: center;
justify-content: center;
gap: .2em;
font-family: inherit;
font-weight: 600;
font-size: 16px;
padding: .5em .5em;
color: white;
background: linear-gradient(30deg, #a5c9ff 20%, #4382E0 80%);
border: none;
outline: none;
border-bottom: 3px solid #4382E0;
box-shadow: 0 .5em .5em -.4em rgb(0, 0, 0, .5);
letter-spacing: 0.08em;
border-radius: 20em;
cursor: pointer;
transition: .5s;
}

.cssbuttons-io-button:hover {
filter: brightness(1.2);
color: rgb(0, 0, 0, .5);
}

.cssbuttons-io-button:active {
transition: 0s;
transform: rotate(-10deg);
}
.cssbuttons-io-button svg {
   margin-right: 0px;
}
/* checkbox style */
.material-checkbox {
  display: flex;
  align-items: center;
  font-size: 16px;
  color: #777777;
  cursor: pointer;
}

.material-checkbox input[type="checkbox"] {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

.checkmark {
  position: relative;
  display: inline-block;
  width: 20px;
  height: 20px;
  margin-right: 12px;
  border: 2px solid #4382e0;
  border-radius: 4px;
  transition: all 0.3s;
}

.material-checkbox input[type="checkbox"]:checked ~ .checkmark {
    background-color: #a5c9ff;
    border-color: #4382e0;
}

.material-checkbox input[type="checkbox"]:checked ~ .checkmark:after {
  content: "";
  position: absolute;
  top: 2px;
  left: 6px;
  width: 4px;
  height: 10px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.material-checkbox input[type="checkbox"]:focus ~ .checkmark {
  box-shadow: 0 0 0 2px #a5c9ff;
}

.material-checkbox:hover input[type="checkbox"] ~ .checkmark {
  border-color: #4382e0;
}

.material-checkbox input[type="checkbox"]:disabled ~ .checkmark {
  opacity: 0.5;
  cursor: not-allowed;
}

.material-checkbox input[type="checkbox"]:disabled ~ .checkmark:hover {
  border-color: #4d4d4d;
}

/* END CHECKBOX STYLE */

/* اظهار الخيارات */
.showoption {
padding: 20px 20px;
border-radius: 30px;
border: 5px solid #ffffff;
background: linear-gradient(30deg, #a5c9ff 20%, #4382E0 80%);
font-size: 15px;
color: white;
font-weight: bolder;
animation: none;
transition: all .5s ease-in-out;
font-family: 'Rajdhani', sans-serif;
}

.showoption:hover {
border-radius: 30px 30px 0px 30px;
box-shadow: inset 0px 30px 10px -25px black;
transition: all .5s ease-in-out;
animation: bounce42 1.6s infinite;
}

@keyframes bounce42 {
0%, 20%, 50%, 80%, 100% {
transform: translateY(0);
}

40% {
transform: translateY(-5px);
}

60% {
transform: translateY(-5px);
}
}
form div span{
background-color: transparent;
height: auto;
width: auto;
}
/* حذف الخيار */
.delete-button {
margin-right: 140px;
width: 40px;
height: 40px;
border-radius: 50%;
background-color: rgb(21 44 79);
border: none;
font-weight: 600;
/* display: flex; */
align-items: center;
justify-content: center;
box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
cursor: pointer;
transition-duration: 0.3s;
overflow: hidden;
position: relative;
top: -40px;
}

.delete-svgIcon {
width: 15px;
transition-duration: 0.3s;
}

.delete-svgIcon path {
fill: white;
}

.delete-button:hover {
width: 90px;
border-radius: 50px;
transition-duration: 0.3s;
background-color: rgb(255, 69, 69);
align-items: center;
}

.delete-button:hover .delete-svgIcon {
width: 20px;
transition-duration: 0.3s;
transform: translateY(60%);
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-o-transform: rotate(360deg);
-ms-transform: rotate(360deg);
transform: rotate(360deg);
}

.delete-button::before {
display: none;
content: "Delete";
color: white;
transition-duration: 0.3s;
font-size: 2px;
}

.delete-button:hover::before {
display: block;
padding-right: 10px;
font-size: 13px;
opacity: 1;
transform: translateY(0px);
transition-duration: 0.3s;
}
#hi{
margin: inherit;
width: 900px;
}
@media(min-width:100px) and (max-width:900px){
#hi{
  margin: inherit;
width: 337px !important;
}
}
.div1 {
display: none;
}
/* submit button */
.my-button {
width: inherit;
display: inline-block;
padding: 10px 20px;
font-size: 16px;
font-weight: bold;
text-align: center;
text-decoration: none;
color: white;
background-color: #4158D0;
background-image: linear-gradient(43deg, #4158D0 0%, #a5c9ff 46%, #152c4f 100%);
transition: 0.2s ease-in-out;
border: none;
border-radius: 4px;
cursor: pointer;
box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
}

.my-button:hover {
box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
}

.my-button:active {
background-color: #4158D0;
background-image: linear-gradient(43deg, #4158D0 0%, #a5c9ff 46%, #152c4f 100%);
}

.myDiv{
	display:none;
    padding:10px;
    margin-top:20px;
    width: 85%;
}
</style>
@endsection

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<div class="main-panel" style="background: #f8f9fb;">
    @if (session()->has('Add'))
    <script>
         window.onload = function () {
    notif({
        msg: "تمت اضافة السؤال بنجاح ",
        type: "success"
    })
}
    </script>
    @endif
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
    <li class="li"><a href="{{ route('dashboard.teacher') }}"> الصفحة الرئيسية</a></li>
    {{-- <li class="li"><a href="{{ route('dashboard.teacher_rooms2',[$class->id,$teacher->id,$room_id,$Lecture->lesson->id]) }}">اضافة محتوى</a></li> --}}
    <li class="li"><a href="{{ route('dashboard.teacher.questions',[$class->id ,$room_id,$Lecture->id,$Lecture->lesson->id ]) }}">الاسئلة</a></li>
    <li class="li"><a href="#">اضافة سؤال</a></li>
    </ul>

    <div class="content-wrapper pb-0">

        <!-- start add question form -->
        <div class="container2" style="padding-bottom: 150px;">
          <div class="heading">اضافة سؤال</div>

          <form action="{{ route('coordinator.question.store') }}" method="post"
          class="mb-5" enctype="multipart/form-data">
          @csrf

          <input type="hidden" id="class_id" name="back" value="{{ $back }}">
          <input type="hidden" id="class_id" name="class_id" value="{{ $class->id }}">
          <input type="hidden" id="class_id" name="lesson_id" value="{{ $lesson_id }}">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <label for="budget" class="col-form-label">درس </label>
                    <select class="custom-select" name="Lecture_id">
                    <option selected value="{{$Lecture->id }}">{{$Lecture->name }}</option>
                    </select>

                </div>
                <div class="col-md-10">
                    <label for="budget" class="col-form-label">الفقرة </label>
                    <select class="form-control" id="budget"  name="section_id">
                        <option selected value="0">اختر الفقرة...</option>
                        @foreach ( $sections as $item)
                        <option value="{{ $item->id }} "> {{ $item->title }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <label for="budget" class="col-form-label"> نوع السؤال</label>
                    <select class="form-control myselection" id="myselection" name='ques_type'>
                        <option selected>اختر النوع </option>
                        <option  value="1">مؤتمت </option>
                        <option  value="2">تقليدي</option>
                    </select>
                </div><!--end col-md-10-->
                {{-- traditional --}}
                <div id="show2" class="myDiv">
                        <div class="col-md-12 form-group mb-3">
                            <label for="message" class="col-form-label" >ادخل نص السؤال </label>
                            <textarea class="form-control" name="question_form1" cols="30" rows="3"></textarea>
                        </div>

                        <div class="col-md-12 form-group mb-3">
                            <label for="message"  class="col-form-label">ادخل الجواب </label>
                            <textarea class="form-control input12"  id="question_form22"  name="answer" cols="10" rows="3"></textarea>
                        </div>

                </div>
                {{-- end --}}

                {{-- automat question --}}
                <div id="show1" class="myDiv">
                    <!-- start my div-->
                        <div class="col-md-10 form-group mb-3">
                            <label for="message" class="col-form-label ">ادخل نص السؤال </label>
                            <textarea class="form-control" name="question_form" cols="30" rows="3"></textarea>
                        </div>
                        <div class="row">
                        <div class="col-md-10">
                                <label for="" class="col-form-label"> الخيار الأول*</label>
                                <input type="text" name="option[]" class="form-control input  input12"
                                placeholder="ادخل الخيار الأول " value="">
                        </div>
                        <div class="col-md-1">
                            <button  id="btn" title="اضافة خيار" class="cssbuttons-io-button" type="button">
                                <svg height="25" width="25" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path></svg>
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button id="remove" title="حذف خيار" class="cssbuttons-io-button" type="button">
                                <svg height="25" width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12L18 12" stroke="#fafafa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </button>
                        </div>
                        </div>
                    <div id="add">
                        <!-- js for add choice -->
                        <script>
                            $(document).on('click', '#btn', function () {
                                $('#add').append(
                                    `<div class="row register" >
                                        <div class="col-md-10">
                                            <label for="" class="col-form-label">خيار السؤال</label>
                                            <input type="text" class="form-control input input12" name="option[]" placeholder="ادخل الخيار التالي ">
                                        </div>
                                    </div>`
                                );


                            });
                        </script>
                        <!-- End js for add choice -->
                        <!-- start js for remove choice -->
                        <script>
                            $(document).ready(function () {
                                $('#remove').click(function () {
                                $(".register").last().remove();
                            for (let index = 0; index < inputt.length; index++) {
                                $("#hi1").remove()
                            }
                            })
                            });
                        </script>
                        <!-- End js for remobtn3removeve choice-->

                    </div>
                    <!-- start checkbox -->
                    <div class="col-md-12">
                        <button class="showoption show" id="show" type="button">اظهار الخيارات</button>
                    </div>



                    <div id="hi">

                    </div>




                </div>
                {{-- end --}}

            </div>
        </div><!--end container-->




          <script>
              $(document).ready(function () {
                  $('#myselection').on('change', function () {
                      var demovalue = $(this).val();
                      $("div.myDiv").hide();
                      $("#show" + demovalue).show();
                  });
              });
          </script>


          <br>
          <div class="row">
              <div class="col-md-10">
                  <label for="" class="col-form-label"> العلامة </label>
                  <input type="number" required min="0" class="form-control" step="0.01" name="mark" id="mark"
                      placeholder="ادخل علامة السؤال">
              </div>
          </div>

          <div class="row">
              <div class="col-md-10">
                  <label for="message"  class="col-form-label">ملاحظات *</label>
                  <textarea class="form-control" name="note" cols="30" rows="3"
                      placeholder="ادخل الملاحظات "></textarea>
              </div>
          </div>
          <br>
          <div class="row">
              <div class="col-md-12 form-group">
                  <input type="button" id="submit1"  value="حفظ التعديل "
                      class="btn btn-primary rounded-0 py-2 px-4">
                  <input hidden id="submit" type="submit" value="حفظ التعديل "
                      class="btn btn-primary rounded-0 py-2 px-4">
                  <!--span class="submitting"></span-->
              </div>
          </div>
      </form>

        </div>
        <!-- end add question form -->

    </div><!--end content-wrapper pb-0-->
  </div><!--end main panels-->



@endsection

@section('js')
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    var inputt = [];
      $("#show").click(function () {
        $("#hi").empty();

        inputt = $('.input').map((_, el) => el.value).get();
            if(inputt.length<=1){
                alert('يجب وضع خيارين على الاقل')

            }
            else{
                   for (let index = 0; index < inputt.length; index++) {
                       if(inputt[0]=="" || inputt[1]==""){
                           alert('يجب وضع خيارين على الاقل')
                           break;
                       }
                       else{
            $("#hi").append(`
            <div id="hi1">
    <label class="material-checkbox">
    <input type="checkbox" class="answer" name="answer[]" value="${inputt[index]}">
    <span class="checkmark"></span>
    &nbsp;
    ${inputt[index]}
  </label>
  <button class="delete-button remove-btn" data-index="${index}">
                    <svg class="delete-svgIcon" viewBox="0 0 448 512">
                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                    </svg>
    </button>
    <br>
    </div>
    `)
         }
        }
    }
    })

  // Add event listener for remove button
  $(document).on('click', '.remove-btn', function () {
    var index = $(this).data('index');
    $(this).closest('#hi1').remove();
    inputt.splice(index, 1);
  });

</script>

<script>
$(document).on('keyup', '.input12', function () {
$(this).val($(this).val().replace('"', ''));
});
        $(document).on('click', '#submit1', function () {
            if($('.myselection').val()==1){
                count=0;
                $.each($('.answer'), function (key, value) {
                    if($(this).is(':checked')){
                    count=count+1;
                }})
            if(count>0){
                $('#submit').click();
            }
            else{
                alert('يرجى اختيار الاجابة الصحيحة ')
            }
            }
            else if($('.myselection').val()==2){
                if($('#question_form22').val()==""){
                    alert('يرجى وضع الاجابة   ')
                }
                else{
                    $('#submit').click();
                }
            }else if($('.myselection').val()==3){
                var fileInput = $('#question_form33');
                if (!(fileInput[0].files.length > 0)) {
                    alert('يرجى  رفع ملف الإجابة')
                }
                else{
                    $('#submit').click();
                }
            }
        })
</script>

@endsection
