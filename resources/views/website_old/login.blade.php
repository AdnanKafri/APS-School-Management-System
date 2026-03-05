<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    
    <title> 
    تسجيل الدخول
    
    </title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap-grid.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap-grid.rtl.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap-reboot.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap-reboot.rtl.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap-utilities.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css"
    />
    <!--link for icons-->
    <link rel="stylesheet" href="{{asset('website/css/login_style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link href="{{URL::asset('teachers/notify/css/notifIt.css')}}" rel="stylesheet"/>
   <link rel="stylesheet" href="{{ asset('student/notify/css/notifIt.css') }}" />
    <script src="{{ asset('student/notify/js/notifIt.js') }}"></script>



    <!-- plugins:css -->
    <style>

    </style>
  </head>
  <body>
      @if (session()->has('error'))
<script>
    window.onload = function () {
        notif({
            msg: "   البريد الالكتروني وكلمة السر غير متطابقين  ",
            type: "error"
        })
    }
</script>
@endif
    <div class="container">
      <div class="row">
        <div class="overlay" style="padding-top: 80px;">
          <form  class="screen"  action="{{ route('login1') }}" method="post">
               @csrf
            <div class="con">
              <!--header class="head-form">
                 <img src="./smartlogo.png" alt="" class="logo">
              </header-->
              <div class="circle">
                <img src="{{asset('website/logo.png')}}" alt="" class="logo" style="padding: 14px !important">

           </div>
           <div class="container">
            <div class="row" style="justify-content: center;">
               <!--email-->
               <div class="col-md-12" style="padding-top: 50px;">
                <div class="input-container">
                  <input type="email" id="email"  name="email"  class="@error('email') is-invalid @enderror login__input" >
                  <label>
                      <i class="fa fa-envelope "></i>   &nbsp;
                      <!--{{ __('site.Email') }}-->
                      الإيميل
                      </label>
              </div>
               </div>
               
                <div class="col-md-12" style="padding-top: 70px">
                <div class="input-container">
                  <input type="password" id="password"  name="password"  class="@error('password') is-invalid @enderror login__input" >
                  <label>
                      <i class="fa fa-lock "></i>   &nbsp;
                      <!--{{ __('site.Password') }}-->
                      كلمة السر
                      </label>
              </div>
               </div>
               <!--end email-->
               <!--password-->
               <!--<div class="col-md-12" style="padding-top: 70px;">
                <div class="input-container">
                  <input id="password" type="password"   class="@error('password') is-invalid @enderror login__input"  name="password">
                  <label><i class="fa fa-lock"></i>
                      <!--{{ __('site.Password') }}>
                      كلمة السر
                      </label>
              </div>
            </div>-->
               <!--end password-->
               <div class="col-md-5" style="padding-top: 40px;">
                   <button  type="submit" id="login" >
                             <!--{{ __('site.Login') }}-->
                             تسجيل الدخول
                    </button>	

               </div>
            </div>
           </div>
          </div>

          <!-- End Form -->
        </form>
      </div>
    </div>
  </div>


              
             
              <!--div class="field-set" style="width: 80%;">
                
                <input class="form-control" type="text" placeholder="اسم المستخدم"/>
                <br />

                <input class="form-control" type="password" placeholder="كلمة المرور"/>

                <button class="log-in">تسجيل الدخول</button>
              </div-->

              <!--div class="field-set" style="width: 91%;">
                <!--a href="#">هل فقدت كلمة المرور ؟</a>
                <br>
                <hr class="new1">
              </div-->

              <!--div class="field-set" style="width: 90%;">
                <div class="row" style="direction: rtl;">
                  <div class="col-md-7">
                    <select name="" id="" class="form-control" style="direction: rtl; color:#4382E0 ;">
                      <option value=""  style="color: #4382E0 !important;">العربية (ar)</option>
                      <option value="" style="color: #4382E0 !important;">الانكليزية (en)</option>
                    </select>
                  </div>
                  <div class="col-md-5"></div>
                  <!--div class="col-md-7">
                    <button style="background-color: gray;padding: 0px 0px ;font-size: 14px;width: 200px;
                    position: relative;
                    top: -20px;">ملاحظة ملفات تعريف الارتباط</button>
                  </div>

                </div>
               
                
              </div-->
            
             

              <!--   other buttons -->
             
              <!--   End Conrainer  -->
          
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::asset('teachers/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('teachers/notify/js/notifit-custom.js') }}"></script>
    <script src="{{ asset('website/js/vendor/jquery-1.11.3.min.js') }}"></script>
      <script >
$(document).on('click', '#login', function () {
  if($('#email').val() ){
      if( $('#password').val() ){
          $(this).hide();
      }
  }
});
</script>

  
  </body>
</html>
