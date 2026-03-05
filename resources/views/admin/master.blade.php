<!DOCTYPE html>
<html lang="ar" style="direction: rtl !important" >
    <head>
        @php
        $school_data = \App\School_data::first();
        @endphp
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!--<meta name="viewport" content="width=device-width,initial-scale=1">-->
        <title>{{$school_data->name_en}} </title>
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
        <!-- Pignose Calender -->
        <link href="{{ asset('assets/admin/plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
        <!-- Chartist -->
        <link rel="stylesheet" href="{{ asset('assets/admin/plugins/chartist/css/chartist.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
        <!-- Custom Stylesheet -->
        <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
        <!-- <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/fontawesome.min.css"> -->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">
        <link href="{{ asset('admin/jquery.dataTables.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('admin/datatables.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('admin/css/searchPanes.dataTables.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('admin/select.dataTables.min.css') }}" rel="stylesheet" media="all">
        <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.4.0/css/autoFill.dataTables.min.css">

        <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}">
        <link href="{{ asset('assets/admin/plugins/sweetalert/css/sweetalert.css') }}" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
        <style>

.breadcrumbs {
  border: 1px solid #cbd2d9;
  border-radius: 0.3rem;
  display: inline-flex;
  overflow: hidden;
  direction: rtl !important;
}

.breadcrumbs__item {
  background: #6ABAA3;
  color: white;
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
  background: #6ABAA3;
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
  background: #2a7b64;
  margin-left: 1px;
}

.breadcrumbs__item:last-child {
  border-right: none;
}

.breadcrumbs__item.is-active {
  background: #7cc0ad;
}
.btn-danger {
    color: #fff;
    background-color: #7571f9;
    border-color: #7571f9;
}

   </style>

        @yield('style')
        <style>
            .btn-success{
                background: #6ABAA3 !important;
                border-color: #6ABAA3 !important;
                color: white !important
            }
        </style>
    </head>

<body>

    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
        {{-- @php
        $route_previouse = '';
            if(Route::current()->getName() == 'student_details' ){
                $route_previouse = route('students');
            }else if(Route::current()->getName() == 'admin.teacher_schedule'){
                $route_previouse = route('teachers');
            }else if(Route::current()->getName() == 'admin.teacher_attendance'){
                $route_previouse = route('teachers');
            }else if(Route::current()->getName() == 'lessons'){
                $route_previouse = route('lessons2');
            }else if(Route::current()->getName() == 'home_edit'){
                $route_previouse = route('websitecontrol');
            }else if(Route::current()->getName() == 'logo_edit'){
                $route_previouse = route('websitecontrol');
            }else if(Route::current()->getName() == 'about_us_edit'){
                $route_previouse = route('websitecontrol');
            }else if(Route::current()->getName() == 'footer_edit'){
                $route_previouse = route('websitecontrol');
            }else if(Route::current()->getName() == 'video_edit'){
                $route_previouse = route('websitecontrol');
            }else if(Route::current()->getName() == 'news_edit'){
                $route_previouse = route('websitecontrol');
            }else if(Route::current()->getName() == 'classroom'){
                $route_previouse = route('classes');
            }
        @endphp --}}

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header"  style="margin-left: 0px; width: auto;background: #B682D8;color: white">
            <!-- style="width:50%"     -->
            <div class="header-content clearfix">

                <div class="header-left" style="  align-items: center;justify-content: center;display: flex;">
                    {{-- <a type="button" class="btn mb-1 btn-success ml-3" href="{{ route('dashboard.index') }}" style="direction: rtl;color: white;background: #6ABAA3;border-color: #6ABAA3"> <span class="btn-icon-right"><i class="fa fa-arrow-alt-circle-left"></i></span>الصفحة الرئيسية
                    </a> --}}

                    @yield('breadcrumbs')


                    {{-- @if ($route_previouse != '')
                    <a type="button" class="btn mb-1 btn-success ml-3" href="{{ url()->previous() }}" style="direction: rtl;color: white;background: #6ABAA3;border-color: #6ABAA3"> <span class="btn-icon-right"><i class="fa fa-arrow-alt-circle-left"></i></span>الرجوع للخلف
                    </a>
                    @endif --}}
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        
                        <li class="icons dropdown d-none d-md-flex">
                            <a href="javascript:void(0)" class="log-user"  data-toggle="dropdown">
                                <span style="color: white;font-size: 20px">{{ auth()->user()->name }}</span>   <span style="color: white;font-size: 20px"> تسجيل خروج </span>
                            </a>

                            <div class="drop-down dropdown-language animated fadeIn  dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        {{-- <li><a href="javascript:void()" style="color: black !important">{{ auth()->user()->name }}</a></li> --}}
                                        <li>
                                            <a href=".logout12" data-toggle="modal"   value="تسجيل الخروج"  style="background: white;border: 0px;text-align: right; 
                                            color: black !important;">
                                                تسجيل الخروج
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
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
        <div class="content-body" style="margin-left: 0px; width: auto;">


    @yield('content')


        <div class="footer" style="padding-left:0">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by   <a href="https://sunrise-center.net/it"> <span style="color:#1368a5;font-weight:bold">Sunrise-IT</span>  </a> <script>document.write(new Date().getFullYear())</script></p>
            </div>
        </div>

    </div>


    <script src="{{ asset('assets/admin/plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/settings.js') }}"></script>
    <script src="{{ asset('assets/admin/js/gleek.js') }}"></script>
    <script src="{{ asset('assets/admin/js/styleSwitcher.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/admin/plugins/sweetalert/js/sweetalert.init.js') }}"></script> --}}

    <!-- Chartjs -->
    <script src="{{ asset('assets/admin/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Circle progress -->
    <script src="{{ asset('assets/admin/plugins/circle-progress/circle-progress.min.js') }}"></script>
    <!-- Datamap -->
    <script src="{{ asset('assets/admin/plugins/d3v3/index.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/topojson/topojson.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/admin/plugins/datamaps/datamaps.world.min.js') }}"></script> --}}
    <!-- Morrisjs -->
    <script src="{{ asset('assets/admin/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/morris/morris.min.js') }}"></script>
    <!-- Pignose Calender -->
    <script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
    <!-- ChartistJS -->
    <script src="{{ asset('assets/admin/plugins/chartist/js/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/admin/js/dashboard/dashboard-1.js') }}"></script> --}}

    <script src="{{ asset('assets/admin/plugins/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/toastr/js/toastr.init.js') }}"></script>
    <script src="{{ asset('admin/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.searchPanes.min.js') }}"></script>

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/autofill/2.4.0/js/dataTables.autoFill.min.js"></script>

    <script src="{{ asset('assets/select2/js/select2.full.min.js') }}"></script>

    @if ($errors->any())

    @foreach ($errors->all() as $key => $error)
    <script>


        if ("{{$key}}" == "0") {
            var xxxx = "";
        }
            console.log("{{$error}}");
            xxxx +=  `<div class="alert alert-danger">${"{{$error}}"}</div>`;
            console.log(xxxx,"{{$key}}");
            if ("{{$key}}" == parseInt("{{ count($errors) }}") - 1) {
                console.log(xxxx,"aa");
                swal({title:"خطأ",text:xxxx,html:!0});
            }

    </script>
    @endforeach
    {{-- <script>
            window.onload = function() {

            }
    </script> --}}

    @endif


    @yield('js')
    <script>

        $('form').on('submit', function(e) {
            $(this).find('button, input[type=button], input[type=submit]').prop('disabled', true);
            
        });
$(document).on('click', '#disabled1', function () {
    $('#disabled').empty();
    $('#disabled').append(`<button type="submit" class="btn btn-success "  style="margin-right: 4px;"   id="disabled1" >تصدير مدرسين</button>`);
    $('#disabled button').prop('disabled', false); // Re-enable the button
});
        $(window).on("load",function(){
            if ("{{ Session::has('success') }}") {
                toastr.success("{{ Session::get('success') }}","Success",{timeOut:5e3,closeButton:!0,debug:!1,newestOnTop:!0,progressBar:!0,positionClass:"toast-top-right",preventDuplicates:!0,onclick:null,showDuration:"300",hideDuration:"1000",extendedTimeOut:"1000",showEasing:"swing",hideEasing:"linear",showMethod:"fadeIn",hideMethod:"fadeOut",tapToDismiss:!1})
            }
            if ("{{ Session::has('error') }}") {
                toastr.error("{{ Session::get('error') }}","Error",{timeOut:5e3,closeButton:!0,debug:!1,newestOnTop:!0,progressBar:!0,positionClass:"toast-top-right",preventDuplicates:!0,onclick:null,showDuration:"300",hideDuration:"1000",extendedTimeOut:"1000",showEasing:"swing",hideEasing:"linear",showMethod:"fadeIn",hideMethod:"fadeOut",tapToDismiss:!1})
            }
        })
    </script>

</body>
</html>
