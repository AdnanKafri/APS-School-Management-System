
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title> AL BAYAN SCHOOL</title>
        <!-- Favicon-->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

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
    <link rel="stylesheet" href="{{ asset('teachers/css/style.css') }}">

        <style>
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

        </style>
            @yield('css')
    </head>
<body class="theme-red">

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <br>
        <br>
       <a class="navbar-brand" href="{{ route('dashboard.coordinator.profile') }}" target="_blank" ><span>{{$coordinator->first_name }} &nbsp;
                {{$coordinator->last_name }}
                <img style="height: 45px; width:45px;border-radius:50%;"
                    src="{{ asset('storage/'.$coordinator->image) }}"> </span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <br>
            <br>
            <span class="oi oi-menu"></span> القائمة
        </button>


        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
           

                <li class="nav-item"><a href="{{ route('dashboard.coordinator') }}" class="nav-link"> الصفحة الرئيسية 
                    </a></li>
             
                <li class="nav-item"><a href="{{ route('dashboard.coordinator.chat') }}" class="nav-link">   <i class="fa fa-comments" aria-hidden="true" style="font-size: 26px;
    height: 30px;
    width: 9px;    
    color: #0a4f8a;" ></i> 
                    </a></li>&nbsp;&nbsp;&nbsp;
                <li class="nav-item"><a href="#" class="nav-link">
                      <form action="https://albayan-virtualschool.com/en/logout" method="POST">
                                    @csrf <button href="https://albayan-virtualschool.com/en/logout" style="    background: #ffdead00;
                                     border: none;">
                                        <img style="height: 30px; width:30px" src="{{  asset('teachers/photo/2.png') }}"
                                            title="تسجيل خروج ">
                                    </button>
                                </form>
                    </a></li>
                    <li class="nav-item"><a href="#" class="nav-link">
                        <img  style=" position: absolute;
                        top: 0px;right: 5px;"  src="{{  asset('website/images/logo22.png') }}"  > </a></li>



                <!--li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
          <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li-->
            </ul>
        </div>
    </div>
</nav>



@yield('content')

<script src="{{ URL::asset('teachers/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('teachers/notify/js/notifit-custom.js') }}"></script>
<script src="{{ asset('teachers/js/jquery.min.js') }}"></script>
<script src="{{ asset('teachers/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('teachers/js/popper.min.js') }}"></script>
<script src="{{ asset('teachers/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('teachers/js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('teachers/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('teachers/js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('teachers/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('teachers/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('teachers/js/jquery.animateNumber.min.js') }}"></script>
<script src="{{ asset('teachers/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('teachers/js/scrollax.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="{{ asset('teachers/js/google-map.js') }}"></script>
<script src="{{ asset('teachers/js/main.js') }}"></script>


        <script>

    </script>
    @yield('js')

</body>

</html>

