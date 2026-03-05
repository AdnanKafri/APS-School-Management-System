@extends('supervisors.layouts.new_app')
@section('css')
<style>

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
 
  position: relative !important;
  display: flex !important;
  flex-direction: column !important;
  background-color: #152C4F !important;
  max-height: 550px !important;
  width: 50% !important;
  margin: auto !important;
  overflow: hidden !important;
  border-radius: 12px !important;
  box-shadow: 7px 7px 10px 3px #24004628 !important;
}
@media(min-width:200px) and (max-width:438px){
  .main{
    width: 100% !important; 
    height: fit-content !important;
  }
  .newsave{
    position: relative !important;
    top: -150px !important;
  }
  .register{
    height: fit-content !important;
    top:65px !important
  }
  .regform{
    padding-top: 53px !important;
  }
}

@media(min-width:439px) and (max-width:734px){
  .main{
    width: 100% !important;
    height: max-content !important;
  }
  .newsave{
    position: relative !important;
    top: -150px !important;
  }
  .register{
    height: 525px !important;
  }
}
.form1 {
  display: flex !important;
  flex-direction: column !important;
  gap: 14px !important;
  padding: 24px !important; 
}
@media(min-width:735px) and (max-width:764px){
  .main{
    width: 100% !important;
    height: max-content !important;
  }
  .newsave{
    position: relative !important; 
    top: -150px !important;
  }
  .register{
    height: 525px !important;
  }
}
.form1 {
  display: flex !important;
  flex-direction: column !important;
  gap: 14px !important;
  padding: 24px !important; 
}

@media(min-width:765px) and (max-width:990px){
  .main{
    width: 100% !important;
    height: max-content !important;
  }
  .newsave{
    position: relative !important;
    top: -150px !important;
  }
  .register{
    height: 525px !important;
    top:-66px !important
  }
}
@media(min-width:991px) and (max-width:1000px){
  .main{
    width: 100% !important;
    height: max-content !important;
  }
  .newsave{
    position: relative;
    top: -150px !important;
  }
  .register{
    height: 525px !important;
    top:-122px !important;
  }
  .regform{
    padding-top: 100px !important;
  }
}


.form1 {
  display: flex !important;
  flex-direction: column !important;
  gap: 14px !important;
  padding: 24px !important;
}

/*checkbox to switch from sign up to login*/
#chk {
  display: none !important;
}

/*Login*/
.login {
  position: relative !important;
  width: 100% !important;
  height: 100% !important;
}

.login label {
  margin: 25% 0 5% !important;
}

label {
  color: #fff !important;
  font-size: 2rem !important;
  justify-content: center !important;
  display: flex !important;
  font-weight: bold !important;
  cursor: pointer !important;
  transition: .5s ease-in-out !important;
  position: relative !important;
  top: -40px !important;
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
  background: #eee !important;
  border-radius: 60% / 10% !important;
  transform: translateY(5%) !important;
  transition: .8s ease-in-out !important;
  position: relative !important;
   padding-bottom: 90px !important;
}

.register label {
  color: #152C4F !important;
  transform: scale(.6) !important;  
  position: relative !important;
  top: -18px !important;
}

#chk:checked ~ .register {
  transform: translateY(-60%) !important;
}

#chk:checked ~ .register label {
  transform: scale(1) !important;
  margin: 10% 0 5% !important;
}

#chk:checked ~ .login label {
  transform: scale(.6) !important;
  margin: 5% 0 5% !important;
}   
/*Button*/
.form1 button {
  width: 40% !important;
    height: 40px !important;
    margin: 12px auto 10% !important;
    color: #fff !important;
    background: #a5c9ff !important ;
    font-size: 1rem !important;
    font-weight: bold !important;
    border: none !important;
    border-radius: 4px !important; 
    cursor: pointer !important;
    transition: .2s ease-in !important;
    position: relative !important;
    top: 53px !important;
}
.form1 button:hover {
  background: linear-gradient(30deg, #a5c9ff 20%, #4382E0 80%) !important;
}
/*end upload new video*/

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

  <div class="content-wrapper pb-0">
    <!--profile content -->
     <div class="container" style="padding-bottom: 100px;padding-top: 20px;">
       <div class="row">
         <div class="col-md-12">
          <div class="main" style="text-align: right;direction: rtl;">  	
            <input type="checkbox" id="chk" aria-hidden="true">
        
              <div class="login">
                  <form action="{{ route('dashboard.supervisor.profile_store') }}"
                  class="form1" method="POST" enctype="multipart/form-data" >
                      @csrf
                    
                      <input type="hidden" name="supervisor_id" value="{{ $supervisor->id }}">
                   
                  <label for="chk" aria-hidden="true">تعديل كلمة المرور</label>
                  <input class="input" type="password" name="old_password" placeholder="كلمة المرور القديمة" required="">
                  <input class="input" type="password" name="password" placeholder="كلمة المرور الجديدة" required="">
                  <button >حفظ</button>
                </form>
              </div>
        
              <div class="register">
                  <form action="{{ route('dashboard.supervisor.profile_store') }}"
                  class="form1 regform" method="POST" enctype="multipart/form-data" >
                      @csrf
                   
                      <input type="hidden" name="supervisor_id" value="{{ $supervisor->id }}">
                     
               
                  <label for="chk" aria-hidden="true">تعديل الصورة</label>
                   <div class="container">
                     <div class="row" style="text-align: center; justify-content: center;">
                       <div class="col-md-5">
                         <img src="{{ asset('storage/'.$supervisor->image) }}" alt="" style="height: 150px; width: 150px;">

                       </div>
                      <div class="col-md-7">
                        <div>
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
  






  <!-- end edit video -->







    	<!-- start add section-->


		<!-- loader -->

@endsection
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
