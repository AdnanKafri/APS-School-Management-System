
<!DOCTYPE html>
<html >
    <head>

          @php
        $logo= DB::table('other')->first();

        $scheduleController = new App\Http\Controllers\TeacherController_New();
        $teacher_id = $teacher->id ;
        $available_lecture = $scheduleController->available_schedule($teacher_id);
        @endphp
         @php
          $school_data = \App\School_data::first();
           @endphp
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset("storage/")}}/{{$school_data->logo}}">
        <title> {{$school_data->name_en}} </title>
        <!-- Favicon-->

    {{--<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('teachers/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('teachers/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('teachers/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers/css/jquery.timepicker.css') }}">
    <link href="{{URL::asset('teachers/notify/css/notifIt.css')}}" rel="stylesheet"/>
 <link href="{{URL::asset('student/notify/css/notifIt.css')}}" rel="stylesheet"/>
 <script src="{{ URL::asset('student/notify/js/notifIt.js') }}"></script>
 <script src="{{ URL::asset('student/notify/js/notifit-custom.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('teachers/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers/css/style.css') }}">--}}

    <!--new assets-->
 <!-- plugins:css -->
 <link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
 <link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
 <link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/css/vendor.bundle.base.css')}}">
 <!-- endinject -->
 <!-- Plugin css for this page -->
 <link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/jquery-bar-rating/css-stars.css')}}" />
 <link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/font-awesome/css/font-awesome.min.css')}}" />
 <!-- End plugin css for this page -->
 <!-- inject:css -->
 <!-- endinject -->
 <!-- Layout styles -->
 <link rel="stylesheet" href="{{asset('teachers_2/assets/css/demo_1/style.css')}}" />
 <link rel="stylesheet" href="{{asset('teachers_2/assets/css/teacherstyle.css')}}">
 <link rel="stylesheet" href="{{asset('teachers_2/assets/css/demo_1/showcontent_style.css')}}">
 <!--link for select-->
 <link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/select2/select2.min.css')}}" />
 <link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}" />

 <!-- End layout styles -->
 <!--link rel="shortcut icon" href="../smartlogo.png" /-->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  <link rel="stylesheet" href="{{ asset('student/notify/css/notifIt.css') }}" />
    <script src="{{ asset('student/notify/js/notifIt.js') }}"></script>
    <!--end new assets-->
    <style>
    @media screen and (max-width: 991px) {
  .sidebar-offcanvas {

     width: min-content !important;
     }}
    </style>



    @yield('css')
    </head>

<body style="background: #f8f9fb;">
    <div class="container-scroller">
      <!--new nav-->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-profile border-bottom">
                <!--start profile-->
                <div class="row resprow">
               {{-- <div class="col-md-4 respnecol">
                    <img class="sidebar-brand-logo" src="{{  asset('storage/'. $school_data->logo_account)}}" alt="" />
               </div> --}}
               <div class="col-md-4 respnecol">
                <a href="{{ route('dashboard.teacher.profile') }}" class="nav-link flex-column">
                  <div class="nav-profile-image">
                    @if ($teacher->image)
                    <img src="{{ asset('storage/'.$teacher->image) }}" alt="profile" />
                    @else
                    <img src=" {{ asset('teachers_2/icons/teacher.png') }}" alt="profile" style="height: 100px !important;" />

                    @endif


                    <!--change to offline or busy as needed-->
                  </div>
                  <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                    <span class="font-weight-semibold mb-1 mt-2 text-center" style="color: #fff;">{{$teacher->first_name }}
                        {{$teacher->last_name }}</span>
                  </div>
                </a>
               </div>
                </div>

                <!--end profile-->

              </li>
         {{-- <li class="nav-item">
            <!--logo-->
            <a class="nav-link" data-toggle="collapse" href="#" aria-expanded="false" aria-controls="ui-basic">
              <img class="sidebar-brand-logo" src="{{ asset('storage/'.$logo->logo) }}" alt="" />
            </a>
            <!--end logo-->
          </li>
          <li class="nav-item nav-profile border-bottom">
            <!--start profile-->
            <a href="#" class="nav-link flex-column">
              <div class="nav-profile-image">
                <img style="height: 45px; width:45px;border-radius:50%;"
                    src="{{ asset('storage/'.$teacher->image) }}">
                <!--change to offline or busy as needed-->
              </div>
              <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                <span class="font-weight-semibold mb-1 mt-2 text-center">{{$teacher->first_name }} &nbsp;
                    {{$teacher->last_name }}</span>
              </div>
            </a>
            <!--end profile-->

          </li>--}}

          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.teacher') }}">
              <i class="mdi mdi-book menu-icon"></i>
              <span class="menu-title">المواد</span>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.teacher_messages') }}">
              <i class="mdi mdi-email-open menu-icon"></i>
              <span class="menu-title">ارسال الرسائل</span>
            </a>
          </li>--}}
          <li class="nav-item ">
            <a class="nav-link" href="{{route('dashboard.teacher_schedule')}}">
              <i class="mdi mdi-calendar menu-icon"></i>
              <span class="menu-title">جدول الدوام</span>
            </a>
          </li>

          <li class="nav-item ">
            <a class="nav-link" href="{{route('teacher.exams_quizes')}}">
             <img src="{{asset('teachers_2/icons/icons8-exam-30.png')}}" class="menu-icon2" style="max-width: 13.5%;">&nbsp;
              <span class="menu-title">مذاكرات وامتحانات</span>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="{{route('teacher.mark_class')}}">
             <img src="{{asset('teachers_2/icons/icons8-exam-30.png')}}" class="menu-icon2" style="max-width: 13.5%;">&nbsp;
              <span class="menu-title">دفتر العلامات  </span>
            </a>
          </li>
          {{-- <li class="nav-item ">
            <a class="nav-link" href="{{route('teacher.teacher_rewads_and_sanction_class')}}">
             <img src="https://www.pngall.com/wp-content/uploads/2017/03/Silver-Medal-Free-PNG-Image.png" class="menu-icon2" style="max-width: 13.5%;">&nbsp;
              <span class="menu-title">   مكافآت والعقوبات</span>
            </a>
          </li> --}}



        </ul>
      </nav>


       <!--start header-->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-chevron-double-left"></span>
            </button>
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
              <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('teachers_2/assets/images/logo-mini.svg')}}" alt="logo" /></a>
            </div>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" id="notificationDropdown" href="{{route('get_message')}}" title="رسائل الطلاب">
                  <i class="mdi mdi-email-outline"></i>
                   <span class="btn__badge pulse-button ">{{$message}}</span>
                </a>
              </li>
              <!--events-->
              {{-- <li class="nav-item dropdown">
                <a class="nav-link" id="notificationDropdown" href="{{route('teacher_events')}}" title="الاحداث">
                  <i class="mdi mdi-calendar"></i>
                </a>
              </li> --}}
              <!--end events-->
              {{-- <li class="nav-item dropdown">
                @if(isset($available_lecture) && isset($available_lecture->meeting_link))


                <a target="_blank" href="{{ route('dashboard.teacher.room.go_to_stream',['scheduler_id' => $available_lecture->id,'day_id' => $available_lecture->day_id,'lecture_time_id' => $available_lecture->lecture_time_id, 'room_id' => $available_lecture->room_id,'teacher_id' => $teacher_id]) }}" class="live">
                   الدخول الى الحصة
                 &nbsp; <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="26px"><path d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z" fill="currentColor"></path></svg>
                </a>
                @else
                <a   class="live stop" style="
                 background: gray;
                 animation: -0.8s cubic-bezier(0.8, 0, 0, 1) 0s infinite normal none running pulse;">
                  لايوجد حصة
                 &nbsp; <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="26px"><path d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z" fill="currentColor"></path></svg>
                </a>

            @endif


             </li> --}}
            </ul>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-logout d-none d-lg-block">
                  <form action="{{route('logout')}}" title="تسجيل خروج"  method="POST"  >
                    @csrf
                    <button href="{{ route('logout') }}" title="تسجيل خروج"  style="background: #ffdead00;
                     border: none;">
                        <i class="mdi mdi-export" title="تسجيل خروج"  style="color:white;font-size: x-large;"></i>
                    </button>
                </form>
                </li>

              </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </nav>
        <!--end header-->
      <!--end new nav-->


  {{--  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar" style=" height: 118px;">
        <div class="container">
            <br>
            <br>
           <a class="navbar-brand" target="_blank" href="{{ route('dashboard.teacher.profile') }}"><span>{{$teacher->first_name }} &nbsp;
                    {{$teacher->last_name }}
                    <img style="height: 45px; width:45px;border-radius:50%;"
                        src="{{ asset('storage/'.$teacher->image) }}"> </span></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <br>
                <br>
                <span class="oi oi-menu"></span> القائمة
            </button>


            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item new"><a href="{{ route('dashboard.teacher_schedule') }}" class="nav-link">برنامج الدوام للاستاذ</a></li>

                    <!--li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li-->
                    <li class="nav-item new"><a href="{{ route('dashboard.teacher') }}#class" class="nav-link">الصفوف</a></li>
                    <li class="nav-item new"><a href="{{ route('dashboard.teacher') }}#event" class="nav-link">الأحداث </a></li>
                    <li class="nav-item new"><a href="{{ route('dashboard.teacher') }}#message" class="nav-link"> ارسال رسائل
                        </a></li>
                         {{-- <li class="nav-item"><a href="{{route('teacher_objection_term')}}" class="nav-link">

              <i style="font-size: 26px;
        height: 30px;
        width: 9px;
        color: #0a4f8a;" class="fa fa-hand-stop-o" ></i>
              <span class="cart-count wow pulse" data-wow-iteration="infinite" data-wow-duration="1000ms"  style="margin-left: 17px !important;"> {{$objection}}
              </span>
              </a></li> --

                        <li class="nav-item new"><a href="{{route('get_message')}}" class="nav-link">
              <img  style="height: 30px; width:30px"  src="{{  asset('teachers/icons8-email-50.png') }}"
              title="الرسائل الواردة " ><span class="cart-count  cart-count1 wow pulse" data-wow-iteration="infinite" data-wow-duration="1000ms" > {{$message}}
              </span>
              </a></li>
        <!--      <li class="nav-item new"><a href="{{route('dashboard.chat')}}" class="nav-link">-->
        <!--         <i class="fa fa-comments" aria-hidden="true" style="font-size: 26px;-->
        <!--height: 30px;-->
        <!--width: 9px;-->
        <!--color: #0a4f8a;" ></i>-->

        <!--      </a></li>-->
                    <li class="nav-item new"><a href="#" class="nav-link">
                           <form action="https://smartsyrianschool.com/ar/logout" method="POST">
                                        @csrf <button href="https://smartsyrianschool.com/smartsyrianschool/ar/logout" style="    background: #ffdead00;
                                         border: none;">
                                            <img style="height: 30px; width:30px" src="{{  asset('teachers/photo/2.png') }}"
                                                title="تسجيل خروج ">
                                        </button>
                                    </form>
                        </a></li>

                        <li class="nav-item new"><a href="#" class="nav-link">
                            <img class="log1" style=" position: absolute;
    top: 24px;

    width: 73px;"  src="{{ asset('storage/'.$logo->logo) }}"  > </a></li>



                    <!--li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
              <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li-->
                </ul>
            </div>
        </div>
    </nav>--}}


@yield('content')
 <link rel="stylesheet" href="{{ asset('student/notify/css/notifIt.css') }}" />
    <script src="{{ asset('student/notify/js/notifIt.js') }}"></script>
<script src="{{asset('teachers_2/assets/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{asset('teachers_2/assets/vendors/jquery-bar-rating/jquery.barrating.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.categories.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.fillbetween.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.stack.js')}}"></script>
<!-- End plugin js for this page -->
<script src="{{asset('teachers_2/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/js/select2.js')}}"></script>
<!-- inject:js -->
<script src="{{asset('teachers_2/assets/js/off-canvas.js')}}"></script>
<script src="{{asset('teachers_2/assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('teachers_2/assets/js/misc.js')}}"></script>
<script src="{{asset('teachers_2/assets/js/settings.js')}}"></script>
<script src="{{asset('teachers_2/assets/js/todolist.js')}}"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{asset('teachers_2/assets/js/dashboard.js')}}"></script>
<script>

  $(window).on("load",function(){
          if ("{{ Session::has('success') }}") {
              notif({msg: "{{ Session::get('success') }}", type:"success"})
          }
          if ("{{ Session::has('error') }}") {
              notif({msg: "{{ Session::get('error') }}", type:"error"})
          }


      })
  </script>

    @yield('js')

</body>

</html>




