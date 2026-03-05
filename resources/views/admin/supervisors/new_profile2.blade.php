@extends('supervisors.layouts.new_app')
@section('title')
School
@endsection
@section('css')
<style>

/*end upload new video*/
@import url("https://fonts.googleapis.com/css?family=Fira+Sans");
html, body {
  position: relative;
  min-height: 100vh;
  background-color: #E1E8EE;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: "Fira Sans", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.form-structor {
  background-color: #222;
  border-radius: 15px;
  height: 550px;
  width: 500px;
  position: relative;
  overflow: hidden;
}
.form-structor::after {
  content: '';
  opacity: 0.8;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-repeat: no-repeat;
  background-position: left bottom;
  background-size: 500px;
  background-image: url('https://images.unsplash.com/photo-1503602642458-232111445657?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=bf884ad570b50659c5fa2dc2cfb20ecf&auto=format&fit=crop&w=1000&q=100');
}
.form-structor .signup {
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  width: 65%;
  z-index: 5;
  -webkit-transition: all 0.3s ease;
}
.form-structor .signup.slide-up {
  top: 5%;
  -webkit-transform: translate(-50%, 0%);
  -webkit-transition: all 0.3s ease;
}
.form-structor .signup.slide-up .form-holder, .form-structor .signup.slide-up .submit-btn {
  opacity: 0;
  visibility: hidden;
}
.form-structor .signup.slide-up .form-title {
  font-size: 1em;
  cursor: pointer;
}
.form-structor .signup.slide-up .form-title span {
  margin-right: 5px;
  opacity: 1;
  visibility: visible;
  -webkit-transition: all 0.3s ease;
}
.form-structor .signup .form-title {
  color: #fff;
  font-size: 1.7em;
  text-align: center;
}
.form-structor .signup .form-title span {
  color: rgba(0, 0, 0, 0.4);
  opacity: 0;
  visibility: hidden;
  -webkit-transition: all 0.3s ease;
}
.form-structor .signup .form-holder {
  border-radius: 15px;
  background-color: #fff;
  overflow: hidden;
  margin-top: 50px;
  opacity: 1;
  visibility: visible;
  -webkit-transition: all 0.3s ease;
}
.form-structor .signup .form-holder .input {
  border: 0;
  outline: none;
  box-shadow: none;
  display: block;
  height: 50px;
  line-height: 30px;
  padding: 8px 15px;
  border-bottom: 1px solid #eee;
  width: 100%;
  font-size: 12px;
}
.form-structor .signup .form-holder .input:last-child {
  border-bottom: 0;
}
.form-structor .signup .form-holder .input::-webkit-input-placeholder {
  color: rgba(0, 0, 0, 0.4);
}
.form-structor .signup .submit-btn {
  background-color: rgba(0, 0, 0, 0.4);
  color: rgba(255, 255, 255, 0.7);
  border: 0;
  border-radius: 15px;
  display: block;
  margin: 15px auto;
  padding: 15px 45px;
  width: 100%;
  font-size: 13px;
  font-weight: bold;
  cursor: pointer;
  opacity: 1;
  visibility: visible;
  -webkit-transition: all 0.3s ease;
}
.form-structor .signup .submit-btn:hover {
  transition: all 0.3s ease;
  background-color: rgba(0, 0, 0, 0.8);
}
.form-structor .login {
  position: absolute;
  top: 20%;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #fff;
  z-index: 5;
  -webkit-transition: all 0.3s ease;
}
.form-structor .login::before {
  content: '';
  position: absolute;
  left: 50%;
  top: -20px;
  -webkit-transform: translate(-50%, 0);
  background-color: #fff;
  width: 200%;
  height: 250px;
  border-radius: 50%;
  z-index: 4;
  -webkit-transition: all 0.3s ease;
}
.form-structor .login .center {
  position: absolute;
  top: calc(50% - 10%);
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  width: 65%;
  z-index: 5;
  -webkit-transition: all 0.3s ease;
}
.form-structor .login .center .form-title {
  color: #000;
  font-size: 1.7em;
  text-align: center;
}
.form-structor .login .center .form-title span {
  color: rgba(0, 0, 0, 0.4);
  opacity: 0;
  visibility: hidden;
  -webkit-transition: all 0.3s ease;
}
.form-structor .login .center .form-holder {
  border-radius: 15px;
  background-color: #fff;
  border: 1px solid #eee;
  overflow: hidden;
  margin-top: 50px;
  opacity: 1;
  visibility: visible;
  -webkit-transition: all 0.3s ease;
}
.form-structor .login .center .form-holder .input {
  border: 0;
  outline: none;
  box-shadow: none;
  display: block;
  height: 30px;
  line-height: 30px;
  padding: 8px 15px;
  border-bottom: 1px solid #eee;
  width: 100%;
  font-size: 12px;
}
.form-structor .login .center .form-holder .input:last-child {
  border-bottom: 0;
}
.form-structor .login .center .form-holder .input::-webkit-input-placeholder {
  color: rgba(0, 0, 0, 0.4);
}
.form-structor .login .center .submit-btn {
  background-color: #6B92A4;
  color: rgba(255, 255, 255, 0.7);
  border: 0;
  border-radius: 15px;
  display: block;
  margin: 15px auto;
  padding: 15px 45px;
  width: 100%;
  font-size: 13px;
  font-weight: bold;
  cursor: pointer;
  opacity: 1;
  visibility: visible;
  -webkit-transition: all 0.3s ease;
}
.form-structor .login .center .submit-btn:hover {
  transition: all 0.3s ease;
  background-color: rgba(0, 0, 0, 0.8);
}
.form-structor .login.slide-up {
  top: 90%;
  -webkit-transition: all 0.3s ease;
}
.form-structor .login.slide-up .center {
  top: 10%;
  -webkit-transform: translate(-50%, 0%);
  -webkit-transition: all 0.3s ease;
}
.form-structor .login.slide-up .form-holder, .form-structor .login.slide-up .submit-btn {
  opacity: 0;
  visibility: hidden;
  -webkit-transition: all 0.3s ease;
}
.form-structor .login.slide-up .form-title {
  font-size: 1em;
  margin: 0;
  padding: 0;
  cursor: pointer;
  -webkit-transition: all 0.3s ease;
}
.form-structor .login.slide-up .form-title span {
  margin-right: 5px;
  opacity: 1;
  visibility: visible;
  -webkit-transition: all 0.3s ease;
}

/*css for upload*/
 /* upload input */
.panel { max-width: 500px; text-align: center; font-size: large;}
.button_outer {background: #4972a8; border-radius:30px; text-align: center; height: 50px; width: 200px; display: inline-block; transition: .2s; position: relative; overflow: hidden;}
.btn_upload {padding: 17px 30px 12px; color: #fff; text-align: center; position: relative; display: inline-block; overflow: hidden; z-index: 3; white-space: nowrap;}
.btn_upload input {position: absolute; width: 100%; left: 0; top: 0; width: 100%; height: 105%; cursor: pointer; opacity: 0;}
.file_uploading {width: 100%; height: 10px; margin-top: 20px; background: #ccc;}
.file_uploading .btn_upload {display: none;}
.processing_bar {position: absolute; left: 0; top: 0; width: 0; 
    height: 100%; border-radius: 30px; background:#f38639; transition: 3s;}
.file_uploading .processing_bar {width: 100%;}
.success_box {display: none; width: 50px; height: 50px; position: relative;}
.success_box:before {content: ''; display: block; width: 9px; height: 18px; border-bottom: 6px solid #fff; border-right: 6px solid #fff; -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg); transform:rotate(45deg); position: absolute; left: 17px; top: 10px;}
.file_uploaded .success_box {display: inline-block;}
.file_uploaded {margin-top: 0; width: 50px; background:#3a3b7c; height: 50px;}
.uploaded_file_view {max-width: 300px; margin: 40px auto; text-align: center; position: relative; transition: .2s; opacity: 0; border: 2px solid #ddd; padding: 15px;}
.file_remove{width: 30px; height: 30px; border-radius: 50%; display: block; position: absolute; background: #aaa; line-height: 30px; color: #fff; font-size: 12px; cursor: pointer; right: -15px; top: -15px;}
.file_remove:hover {background: #222; transition: .2s;}
.uploaded_file_view img {max-width: 100%;}
.uploaded_file_view.show {opacity: 1;}
.error_msg {text-align: center; color: #f00}
#hero{
	display: none !important;
}
	 </style>
 @endsection

 @section('content')
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

<main id="main">

  <!--section for form-->
  <div class="form-structor" style="margin-top: 100px;margin-bottom: 100px;">
    <form action="{{ route('dashboard.supervisor.profile_store') }}"
    class="form" method="POST" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" name="supervisor_id" value="{{ $supervisor->id }}">
    <div class="signup">
      <h2 class="form-title" id="signup"><span></span>تعديل كلمة السر</h2>
      <div class="form-holder">
        
        <input type="password" class="input" name="old_password" placeholder="ادخل كلمة المرور القديمة" />
        <input type="password" class="input" name="password" placeholder="ادخل كلمة المرور الجديدة " />
        <input type="password" class="input" name="password_confirmation" placeholder="تاكيد كلمة المرور الجديدة " />
      </div>
      <button class="submit-btn">حفظ</button>
    </div>
    <div class="login slide-up">
      <div class="center">
        <h2 class="form-title" id="login"><span></span>تعديل الصورة الشخصية </h2>
        
        <div class="form-holder">
         
          <label style="background-color: transparent;text-align: right;">تحميل الصورة الشخصية </label>
          <div>
          
            <div> 
                <main class="main_full" >
                    <div class="container">
                  <div class="panel">
                    <div class="button_outer" style="left: 23px;">
                        <div class="btn_upload">
                            <input type="file" id="upload_file" name="personal_image" accept="file_extension/*">
                            تحميل ملف 
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
        {{-- <img src="{{ asset('storage/'.$supervisor->image) }}" id="old_image" width="100px" height="100px"> --}}
            </div>
        </div>
        </div>
        <button class="submit-btn">حفظ </button>
      </div>
    </div>
    </form>
  </div>
  </main>

    	<!-- start add section-->


		<!-- loader -->

@endsection
@section('js-scripts')
<script>
    
                
  var btnUpload = $("#upload_file"),
       btnOuter = $(".button_outer");
   btnUpload.on("change", function(e){
       var ext = btnUpload.val().split('.').pop().toLowerCase();
       if($.inArray(ext, ['pdf','xlsx','text']) == -1) {
           $(".error_msg").text("Not an file..");
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

<script>
console.clear();

const loginBtn = document.getElementById('login');
const signupBtn = document.getElementById('signup');

loginBtn.addEventListener('click', (e) => {
let parent = e.target.parentNode.parentNode;
Array.from(e.target.parentNode.parentNode.classList).find((element) => {
if(element !== "slide-up") {
parent.classList.add('slide-up')
}else{
signupBtn.parentNode.classList.add('slide-up')
parent.classList.remove('slide-up')
}
});
});

signupBtn.addEventListener('click', (e) => {
let parent = e.target.parentNode;
Array.from(e.target.parentNode.classList).find((element) => {
if(element !== "slide-up") {
parent.classList.add('slide-up')
}else{
loginBtn.parentNode.parentNode.classList.add('slide-up')
parent.classList.remove('slide-up')
}
});
});
</script>
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
