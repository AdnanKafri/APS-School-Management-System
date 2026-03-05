@extends('students.layouts.app4')
@section('css')
<style>
*, *:before, *:after {
  box-sizing: border-box;
}
*:focus {
  outline: none;
}
fieldset {
  border: none;
}
input[type=submit] {
  border: none;
  font-size: 1em;
}
/*************
 Layout
 **************/
.l-container {
  margin-top: 20px;
  margin-right: auto;
  margin-left: auto;
  width: 670px;
  height: auto;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
  background: url(https://dl.dropboxusercontent.com/u/11530795/background_image.jpg),
  linear-gradient(to right top, #2c71ad 20%, rgb(132, 167, 196));
  background-blend-mode: darken;
  overflow: hidden;
}
/*************
 Modules
 **************/
.header {
  padding-top: 10px;
  width: inherit;
  height: 160px;
  text-align: center;
  color: white;
  font-family: 'PT Serif', serif;
  font-weight: 100;
  font-size: 34px;
  text-transform: uppercase;
  letter-spacing: 2px;
}
.header .logo {
  margin-right: auto;
  margin-left: auto;
  padding-top: 15px;
  width: 300px;
  height: 145px;
}
.form {
  display: flex;
  flex-direction: column;
  /*margin-top: 90px;*/
  margin-right: auto;
  margin-left: auto;
  width: 670px;
  height: auto;
  border-radius: 2px;
  background: rgba(238, 238, 238, 0.9);
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
  background:linear-gradient(to right top, #2c71ad 20%, rgb(132, 167, 196));

  background-blend-mode: darken;
  overflow: hidden;
}
.form__label {

  margin-top: 20px;
  font-size: 20px;
  padding-right: 60px;
   color: white;
}
.form__input {
  margin-top: -20px;
  margin-right: auto;
  margin-left: auto;
  color:#fff ;
  font-weight: 800 ;
  /*padding-bottom: -100px;*/
  width:300px;
  font-size: 16px;
  border: 0;
  outline: 0;
  border-bottom: 1px solid white;
  background: transparent;
  text-align: center;
}
.form__submit {
	border-radius: 20px;
  margin-top: 0px;
  margin-right: auto;
  margin-left: auto;
  padding: 10px 20px;
  width: 200px;
  font-size: 18px;
  color: white;
  background: rgb(132, 167, 196);
}
/*.connect {
  margin-top: -55px;
  margin-right: auto;
  margin-left: auto;
  width: 200px;
  height: 50px;
  font-size: 13px;
  text-align: center;
}*/
.connect__icon {
  margin-left: 30px;
  font-size: 20px;
  color: #b19a9a;
}
.account {
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
  width: 225px;
  height: 45px;
  font-size: 10px;
  line-height: 45px;
  border-radius: 2px;
  background: rgba(238, 238, 238, 0.9);
}
.account span {
  margin-left: 25px;
  font-size: 13px;
  color: #4986fc;
}
.circle {
  stroke: none;
  fill: none;
}
.red {
  visibility: hidden;
}
/*************
 states
 **************/
.is-btn-hovered:hover {
  background:#f38639;
}
/*upload new video*/
/* upload input */
.panel { max-width: 500px; text-align: center; font-size: large;}
.button_outer {background: white;
	border-style: solid;
	border-color: #f38639;
	 border-radius:30px;
	 text-align: center;
	 height:60px;
	 width: 200px;
	  display: inline-block;
	  transition: .2s;
	  position: relative;
	  overflow: hidden;}
.btn_upload {padding: 10px 30px 12px; color: #f38639; text-align: center; position: relative; display: inline-block; overflow: hidden; z-index: 3; white-space: nowrap;}
.btn_upload input {
	position: absolute;
	 width: 100%;
	 left: 0;
	 top: 0;
	 width: 100%;
	 height: 105%;
	 cursor: pointer;
	  opacity: 0;}

.file_uploading {width: 100%; height: 10px; margin-top: 20px; background: #ccc;}
.file_uploading .btn_upload {display: none; text-align: center; margin-bottom: 50px;}
.processing_bar {position: absolute; left: 0; top: 0; width: 0;
    height: 100%; border-radius: 30px; background:#f38639; transition: 3s;}
.file_uploading .processing_bar {width: 100%;}
.success_box {display: none; width: 50px; height: 50px; position: relative;}
.success_box:before {content: ''; display: block; width: 9px; height: 18px; border-bottom: 6px solid #fff; border-right: 6px solid #fff; -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg); transform:rotate(45deg); position: absolute; left: 17px; top: 10px;}
.file_uploaded .success_box {display: inline-block;}
.file_uploaded {margin-top: 0; width: 50px; background:linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196)); height: 50px;}
.uploaded_file_view {max-width: 300px; margin: 40px auto; text-align: center; position: relative; transition: .2s; opacity: 0; border: 2px solid #ddd; padding: 15px;}
.file_remove{width: 30px; height: 30px; border-radius: 50%; display: block; position: absolute; background: #aaa; line-height: 30px; color: #fff; font-size: 12px; cursor: pointer; right: -15px; top: -15px;}
.file_remove:hover {background: #222; transition: .2s;}
.uploaded_file_view img {max-width: 100%;}
.uploaded_file_view.show {opacity: 1;}
.error_msg {text-align: center; color: #f00}
.hero-wrap.hero-wrap-2{
  height: 100px !important;
}
.ftco-navbar-light .navbar-nav > .nav-item > .nav-link{
  color: #fff;
}
.ftco-navbar-light .navbar-nav > .nav-item > .nav-link:hover{
  color: rgb(239, 242, 243) !important;
}
.ftco_navbar{
  background: fixed !important;
  background-color: #094e89 !important;
}
/*end upload new video*/

	 </style>
 @endsection

 @section('content-2')
 @if (session()->has('success'))

 <script>
     window.onload = function() {
         notif({
             msg: "  تم التخزين بنجاح  ",
             type: "success"
         })
     }

 </script>
@endif

 @if (session()->has('error'))

 <script>
     window.onload = function() {
         notif({
             msg: " {{ session()->get('error') }} ",
             type: "error"
         })
     }

 </script>
@endif
@if ($errors->any())

     @foreach ($errors->all() as $error)
     {{-- <li>{{ $error }}</li> --}}
     <script>
         window.onload = function() {
             notif({
                 msg: `{{  $error }}`  ,
                 type: "error"
             })
         }

     </script>
     @endforeach

@endif
  <br>
  <br>
  <br>
  <div class="text-center" style="margin-top: 100px !important">
    <h3>الملف الشخصي</h3>
  </div>
  <section class="l-container" style="margin-top:50px !important">


	<form action="{{ route('dashboard.student.profile_store') }}"
    class="form" method="POST" enctype="multipart/form-data" style="padding: 15px 0 85px 0">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="room_id" value="{{ $room_id }}">
		<label class="form__label" for="">اسم  المستخدم</label>
		<input class="form__input" type="text" placeholder=""
           value ="{{   $student->first_name }} {{   $student->last_name }}" style="margin-bottom: 15px" />
		<br>
        <label class="form__label" for="">  كلمة المرور القديمة</label>
		<input class="form__input" type="password" name="old_password"  style="margin-bottom: 35px"  />

        <label class="form__label" for="">   كلمة المرور الجديدة</label>
		<input class="form__input" type="password" name="password" />
        <label class="form__label" for="">  تأكيد كلمة المرور</label>
		<input class="form__input" type="password" name="password_confirmation" style="margin-bottom: 35px" />
	  <br>


	  <label class="form__label" for=""> تحميل صورة شخصية </label>
	  <div style="margin: 0 auto;">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <main class="main_full" >
      <div class="container">
      <div class="panel">
      <div class="button_outer">
        <div class="btn_upload">
          <input type="file" id="upload_file" name="personal_image" accept="image/*">
          تحميل الصورة
          </div>
        <div class="processing_bar"></div>
           <div class="success_box"></div>
      </div>
    </div>
    <div class="error_msg"></div>
    <div class="uploaded_file_view" id="uploaded_view">
      <span class="file_remove">X</span>
    </div>
  </div>
</main>

	</div>

	  <input class="form__submit is-btn-hovered" type="submit" value="حفظ التعديل ">
	  <br>
	</form>



  </section>


  <!-- end edit video -->





  <br>
  <br>
  <br>
  <br>

    	<!-- start add section-->


		<!-- loader -->

@endsection
@section('js-scripts')
		<script>

         var btnUpload = $("#upload_file"),
         btnOuter = $(".button_outer");
         btnUpload.on("change", function(e){
         var ext = btnUpload.val().split('.').pop().toLowerCase();
         if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
             $(".error_msg").text("Not an file...");
         } else {
             $(".error_msg").text("");
             btnOuter.addClass("file_uploading");
             setTimeout(function(){
                 btnOuter.addClass("file_uploaded");
             },3000);
             var uploadedFile = URL.createObjectURL(e.target.files[0]);
             setTimeout(function(){
                 $("#uploaded_view").append('<img src="'+uploadedFile+'" />').addClass("show");
             },3500);
         }
     });
     $(".file_remove").on("click", function(e){
         $("#uploaded_view").removeClass("show");
         $("#uploaded_view").find("img").remove();
         btnOuter.removeClass("file_uploading");
         btnOuter.removeClass("file_uploaded");
     });
			 </script>
		@endsection
