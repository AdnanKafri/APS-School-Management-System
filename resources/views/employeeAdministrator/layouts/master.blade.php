<html>

<head>
    <style>
        .gradient-custom-2,
        body {
            /* fallback for old browsers */
            background: #7e40f6;
            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(
                to right,
                rgba(126, 64, 246, 1),
                rgba(80, 139, 252, 1)
            );
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(
                to right,
                rgba(126, 64, 246, 1),
                rgba(80, 139, 252, 1)
            );
        }

        .mask-custom {
            background: rgba(24, 24, 16, 0.2);
            border-radius: 2em;
            backdrop-filter: blur(25px);
            border: 2px solid rgba(255, 255, 255, 0.05);
            background-clip: padding-box;
            box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
        }
        
        
        /* The switch - the box around the slider */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider (circle) */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 34px;
}

/* Rounded sliders (when the switch is on) */
.slider.round {
    border-radius: 34px;
}

/* Styling the slider when the checkbox is checked (on) */
.slider.round:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
}

/* Styling the checkbox when it's checked */
input:checked + .slider.round {
    background-color: #2196F3;
}

/* Styling the circle slider when the checkbox is checked (on) */
input:checked + .slider.round:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}



.navbar-nav .nav-item .nav-link.active {
    background-color: #7e40f6; /* Change to the desired color */
    color: white; /* Change to the desired text color */
    /* Add any additional styles as needed */
}


    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
        
        
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 
 
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        
 
</head>


<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom">
    <div class="container-fluid">
        <!-- Navbar brand with logo and avatar -->
        <a class="navbar-brand" href="#">
            <!--<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="Your Logo" width="80" height="30" class="d-inline-block align-top me-2">-->
            <!-- User avatar -->
            <span>{{$adminEmployee->first_name}} {{$adminEmployee->last_name}}</span>
        </a>
        <!-- Navbar toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                
          <li class="nav-item">
                    <a class="nav-link {{ Route::is('dashboard.employeeAdmin') ? 'active' : '' }}"
                        href="{{ route('dashboard.employeeAdmin') }}">
                        المهام المستقبلة
                     </a>
                </li>
                
                 
                             <li class="nav-item">
                    <a class="nav-link {{ Route::is('dashboard.employeeAdmin_sent_tasks') ? 'active' : '' }}"
                        href="{{ route('dashboard.employeeAdmin_sent_tasks') }}">
                        المهام المرسلة 
                     </a>
                </li>
          
                
                <li class="nav-item">
                    <a href=".logout12" data-toggle="modal"class="nav-link"  value="تسجيل الخروج ">
                                                تسجيل الخروج
                                            </a>
                                            
                 </li>
                <!-- New item with notification badge -->
        
            </ul>
        </div>
    </div>
</nav>
        <div class="modal fade logout12">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <button type="button" style="color: blue !important;" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                            <h4 class="modal-title">تسجيل خروج </h4>
                           
                        </div>
                        <div class="modal-body" style="text-align: right;">
                             <input class="delete1"  hidden   name="id" >
                            <p>     هل تود تسجيل الخروج ؟</p>
                           
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" style="padding-bottom: 4px;" data-dismiss="modal"
                                value="الغاء">

                            <button class="btn btn-danger" style="margin-right: 8px;" type="submit">نعم</button>


                        </div>
                    </form>
                </div>
            </div>
        </div>

@yield('content')


    <script src="{{ asset('assets/admin/plugins/common/common.min.js') }}"></script>
   
  


</body>

</html>