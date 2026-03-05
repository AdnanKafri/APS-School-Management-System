@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
      @media (min-width: 900px) and (max-width: 1000px){
  .navbar .navbar-menu-wrapper .navbar-toggler {
    background: #995FDE  !important; 
}
}

      /* upload input */
.panel { max-width: 500px; text-align: center; font-size: large;}
.button_outer {background: #152C4F; border-radius:30px; text-align: center; height: 50px; width: 200px; display: inline-block; transition: .2s; position: relative; overflow: hidden;}
.btn_upload {padding: 17px 30px 12px; color: #fff; text-align: center; position: relative; display: inline-block; overflow: hidden; z-index: 3; white-space: nowrap;}
.btn_upload input {position: absolute; width: 100%; left: 0; top: 0; width: 100%; height: 105%; cursor: pointer; opacity: 0;}
.file_uploading {width: 100%; height: 10px; margin-top: 20px; background: #ccc;}
.file_uploading .btn_upload {display: none;}
.processing_bar {position: absolute; left: 0; top: -25px; width: 0px; 
    height: 100%; border-radius: 30px; 
    background:#a5c9ff  ; transition: 3s;}
.file_uploading .processing_bar {width: 100%;}
.success_box {display: none; width: 50px; height: 50px; position: relative;}
.success_box:before {content: ''; display: block; width: 9px; 
height: 18px; border-bottom: 6px solid #fff; 
border-right: 6px solid #fff; -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg);
 -ms-transform:rotate(45deg); transform:rotate(45deg); position: absolute;
  left: 20px; top: -7px;}

.file_uploaded .success_box {display: inline-block;}
.file_uploaded {margin-top: 0;
   width: 50px; background:#152C4F; height: 50px;}
.uploaded_file_view {max-width: 300px; margin: -76px auto; text-align: center;
   position: relative; transition: .2s; opacity: 0; border: 2px solid #ddd; padding: 15px;}
.file_remove{width: 30px; height: 30px; border-radius: 50%; display: block; position: absolute;
   background: #aaa; line-height: 30px; color: #fff; font-size: 12px; cursor: pointer; right: -15px; top: -15px;}
.file_remove:hover {background: #222; transition: .2s;}
.uploaded_file_view img {max-width: 100%;}
.uploaded_file_view.show {opacity: 1;}
.error_msg {text-align: center; color: #f00}

     /*css for profile*/
     .main {
 
  position: relative;
  display: flex;
  flex-direction: column;
  background-color: #152C4F;
  max-height: 550px;
  width: 50%;
  margin: auto;
  overflow: hidden;
  border-radius: 12px;
  box-shadow: 7px 7px 10px 3px #24004628;
}
@media(min-width:200px) and (max-width:438px){
  .main{
    width: 100%;
    height: fit-content;
  }
  .newsave{
    position: relative;
    top: -150px;
  }
  .register{
    height: fit-content;
    top:65px
  }
  .regform{
    padding-top: 53px !important;
  }
}

@media(min-width:439px) and (max-width:734px){
  .main{
    width: 100%;
    height: max-content;
  }
  .newsave{
    position: relative;
    top: -150px;
  }
  .register{
    height: 525px;
  }
}
.form {
  display: flex;
  flex-direction: column;
  gap: 14px;
  padding: 24px;
}
@media(min-width:735px) and (max-width:764px){
  .main{
    width: 100%;
    height: max-content;
  }
  .newsave{
    position: relative;
    top: -150px;
  }
  .register{
    height: 525px;
  }
}
.form {
  display: flex;
  flex-direction: column;
  gap: 14px;
  padding: 24px;
}

@media(min-width:765px) and (max-width:990px){
  .main{
    width: 100%;
    height: max-content;
  }
  .newsave{
    position: relative;
    top: -150px;
  }
  .register{
    height: 525px;
    top:-66px
  }
}
@media(min-width:991px) and (max-width:1000px){
  .main{
    width: 100%;
    height: max-content;
  }
  .newsave{
    position: relative;
    top: -150px;
  }
  .register{
    height: 525px;
    top:-122px;
  }
  .regform{
    padding-top: 100px !important;
  }
}


.form {
  display: flex;
  flex-direction: column;
  gap: 14px;
  padding: 24px;
}

/*checkbox to switch from sign up to login*/
#chk {
  display: none;
}

/*Login*/
.login {
  position: relative;
  width: 100%;
  height: 100%;
}

.login label {
  margin: 25% 0 5%;
}

label {
  color: #fff;
  font-size: 2rem;
  justify-content: center;
  display: flex;
  font-weight: bold;
  cursor: pointer;
  transition: .5s ease-in-out;
  position: relative;
  top: -40px;
}

.input {
  width: 100%;
  height: 40px;
  background: #e0dede;
  padding: 10px;
  border: none;
  outline: none;
  border-radius: 4px;
}

/*Register*/
.register {
  background: #eee;
  border-radius: 60% / 10%;
  transform: translateY(5%);
  transition: .8s ease-in-out;
  position: relative;
   padding-bottom: 90px;
}

.register label {
  color: #152C4F;
  transform: scale(.6);
  position: relative;
  top: -18px;
}

#chk:checked ~ .register {
  transform: translateY(-60%);
}

#chk:checked ~ .register label {
  transform: scale(1);
  margin: 10% 0 5%;
}

#chk:checked ~ .login label {
  transform: scale(.6);
  margin: 5% 0 5%;
}   
/*Button*/
.form button {
  width: 40%;
    height: 40px;
    margin: 12px auto 10%;
    color: #fff;
    background: #a5c9ff ;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: .2s ease-in;
    position: relative;
    top: 53px;
}
.form button:hover {
  background: linear-gradient(30deg, #a5c9ff 20%, #4382E0 80%);
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
<div class="main-panel" >
  <ul class="breadcrumbs" style="padding-bottom: 7px;
      padding-top: 11px;">
       
        <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">المواد</a></li>
        <li class="li"><a href="#">حسابي</a></li>
        
     </ul>
    <div class="content-wrapper pb-0">
      <!--profile content -->
       <div class="container" style="padding-bottom: 100px;padding-top: 20px;">
         <div class="row">
           <div class="col-md-12">
            <div class="main" style="text-align: right;direction: rtl;">  	
              <input type="checkbox" id="chk" aria-hidden="true">
          
                <div class="login">
                    <form action="{{ route('dashboard.student.profile_store') }}"
                    class="form" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <input type="hidden" name="room_id" value="{{ $room_id }}">
                    <label for="chk" aria-hidden="true">تعديل كلمة المرور</label>
                    <input class="input" type="password" name="old_password" placeholder="كلمة المرور القديمة" required="">
                    <input class="input" type="password" name="password" placeholder="كلمة المرور الجديدة" required="">
                    <button >حفظ</button>
                  </form>
                </div>
          
                <div class="register">
                    <form action="{{ route('dashboard.student.profile_store') }}"
                    class="form regform" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <input type="hidden" name="room_id" value="{{ $room_id }}">
                 
                    <label for="chk" aria-hidden="true">تعديل الصورة</label>
                     <div class="container">
                       <div class="row" style="text-align: center; justify-content: center;">
                         <div class="col-md-5">
                           <img src="{{ asset('storage/'.$student->image) }}" alt="" style="height: 150px; width: 150px;">

                         </div>
                        <div class="col-md-7">
                          <div>
                              <!-- <small style="color: green;position: relative;
                            left: 20px;">يرجى ادخال الصورة بأبعاد 150*150</small>-->
                            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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
                            </div>
                        </div>
                        </div>

                       </div>

                     </div>
                    <button class="newsave">حفظ</button>
                  </form>
                </div>
            </div>


           </div>

         </div>

       </div>

      <!--end profile-->
  
</div>
</div>
@endsection
<!-- JS here -->
@section('js')
<script>
      var btnUpload = $("#upload_file"),
         btnOuter = $(".button_outer");
     btnUpload.on("change", function(e){
         var ext = btnUpload.val().split('.').pop().toLowerCase();
         if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
@endsection

</body>
</html>
