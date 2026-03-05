<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title> Admin Dashboard .com</title>
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


        <!--**********************************
            Header start
        ***********************************-->
        <div class="header"  style="margin-left: 0px; width: auto;background: #7571f9;color: white">
            <!-- style="width:50%"     -->
            <div class="header-content clearfix">

                <div class="header-left" style="  align-items: center;justify-content: center;display: flex;">
                    <a type="button" class="btn mb-1 btn-success" href="{{ route('dashboard.index') }}" style="direction: rtl;color: white;background: #6ABAA3;border-color: #6ABAA3"> <span class="btn-icon-right"><i class="fa fa-arrow-alt-circle-left"></i></span>الصفحة الرئيسية
                    </a>
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown d-none d-md-flex">
                            <a href="javascript:void(0)" class="log-user"  data-toggle="dropdown">
                                <span style="color: white;font-size: 20px">{{ auth()->user()->name }}</span>  <i class="fa fa-angle-down f-s-14" aria-hidden="true"></i>
                            </a>

                            <div class="drop-down dropdown-language animated fadeIn  dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        {{-- <li><a href="javascript:void()" style="color: black !important">{{ auth()->user()->name }}</a></li> --}}
                                        <li><form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <input type="submit" value="تسجيل الخروج" style="background: white;border: 0px">
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content-body" style="margin-left: 0px; width: auto;">


    @yield('content')


        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">admin dashboard</a> 2022</p>
            </div>
        </div>

    </div>


    <script src="{{ asset('assets/admin/plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/settings.js') }}"></script>
    <script src="{{ asset('assets/admin/js/gleek.js') }}"></script>
    <script src="{{ asset('assets/admin/js/styleSwitcher.js') }}"></script>

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

    @yield('js')
    <script>
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
