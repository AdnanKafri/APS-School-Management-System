
<!DOCTYPE html>
<html >
    <head>
          @php

        $logo= DB::table('other')->first();
        @endphp
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/'.$logo->logo) }}">
        <title> smart syrian school </title>
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


    <link rel="stylesheet" href="{{ asset('teachers/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers/css/style.css') }}">--}}

    <!--new assets-->
 <!-- plugins:css -->
 <link rel="stylesheet" href="{{ asset('student/notify/css/notifIt.css') }}" />
    <script src="{{ asset('student/notify/js/notifIt.js') }}"></script>
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
    <!--end new assets-->

        <style>
              @media (min-width: 992px){
    .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title {
    color: #152C4F  !important;
    border-radius: 0px 5px 5px 0px;
    text-align: center !important;
}
   }

   @media (min-width: 992px){
    .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-icon {

    max-width: 26% !important;
}
   }
   @media (min-width: 992px){
    .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-icon2 {

    max-width: 33% !important;
}
   }
   @media (min-width: 992px){
    .sidebar-icon-only .sidebar .nav .nav-item .nav-link i.menu-icon {
    margin-right: 0px !important;
    margin-left: 0px !important;

}
   }
            /*
.breadcrumbs {

  border-radius: 0.3rem;
  display: inline-flex;
  overflow: hidden;
  direction: rtl !important;
}

.breadcrumbs__item {

  color: #f38639;
  outline: none;
  padding: 0.75em 0.75em 0.75em 1.25em;
  position: relative;
  text-decoration: none;
  transition: background 0.2s linear;
}

.breadcrumbs__item:hover:after,
.breadcrumbs__item:hover {
  background: #edf1f5;
  color: black !important;
}

.breadcrumbs__item:focus:after,
.breadcrumbs__item:focus,
.breadcrumbs__item.is-active:focus {
  background: #e2e9e708;
  color: #fff;
}

.breadcrumbs__item:after,
.breadcrumbs__item:before {
  background: #fff;
  bottom: 0;
  clip-path: polygon(50% 50%, -50% -50%, 0 100%);
  content: "";
  left: 100%;
  position: absolute;
  top: 0;
  transition: background 0.2s linear;
  width: 1.5em;
  z-index: 1;
}

.breadcrumbs__item:before {
  background: #3971a0;
  margin-left: 1px;
}

.breadcrumbs__item:last-child {
  border-right: none;
}

.breadcrumbs__item.is-active {
    background: #e2e9e708;
    font-weight: bold;
    color: #3971a0;
}
/*.hero-wrap.hero-wrap-2  {*/
/*        background-size: 100%;*/
/*}*/
*/


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
               <div class="col-md-4 respnecol">
                    <img class="sidebar-brand-logo" src="{{asset('teachers_2/icons/1-01 (1).png')}}" alt="" />
               </div>
               <div class="col-md-4 respnecol">
                <a href="{{ route('dashboard.supervisor.profile',[$supervisor->id]) }}" class="nav-link flex-column">
                  <div class="nav-profile-image">
                    @if ($supervisor->image)
                    <img src="{{ asset('storage/'.$supervisor->image) }}" alt="profile" />
                    @else
                    <img src=" {{ asset('teachers_2/icons/teacher.png') }}" alt="profile" style="height: 100px !important;" />

                    @endif


                    <!--change to offline or busy as needed-->
                  </div>
                  <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                    <span class="font-weight-semibold mb-1 mt-2 text-center" style="color: #fff;">{{$supervisor->first_name }}
                        {{$supervisor->last_name }}</span>
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
            <a class="nav-link" href="{{ route('dashboard.supervisor') }}">
              <i class="mdi mdi-book menu-icon"></i>
              <span class="menu-title">الصفوف</span>
            </a>
          </li>

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




@yield('content')
    </div>
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


    @yield('js')

</body>

</html>




