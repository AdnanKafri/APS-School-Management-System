<!--
=========================================================
* Argon Dashboard - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard


* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com



=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Smart Syrian School</title>
    <!-- Favicon -->
    <link rel="icon" href=" @yield('image') " type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.2.0') }}" type="text/css">
    <link href="{{ asset('students/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />


    <style>
        .swal2-select {
            display: none !important;
        }
    </style>
</head>

<body>
    <!-- Sidenav -->
    @include('sweetalert::alert')

    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header  align-items-center">
                <a class="navbar-brand1" href="http://smartsyrianschool.com/" target="_blank">
                    <img src="{{ asset('students/images/super_back.jpg') }}"
                        style="    height: 97px !important;
          width: 250px !important;
      "
                        class="navbar-brand-img1" alt="...">
                </a>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">

                        @can('students')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.students') }}" target="_blank">
                                    <i class="ni ni-single-02 text-default"></i>
                                    <span class="nav-link-text">الطلاب</span>
                                </a>
                            </li>
                        @endcan


                        @can('teachers')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.teachers') }}" target="_blank">
                                    <i class="ni ni-circle-08 text-default"></i>
                                    <span class="nav-link-text">المدرسون</span>
                                </a>
                            </li>
                        @endcan


                        @can('supervisors')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.supervisors') }}" target="_blank">
                                    <i class="ni ni-circle-08 text-default"></i>
                                    <span class="nav-link-text">الموجهون</span>
                                </a>
                            </li>
                        @endcan


                        @can('classes')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.classes') }}" target="_blank">
                                    <i class="ni ni-archive-2 text-default"></i>
                                    <span class="nav-link-text">الصفوف</span>
                                </a>
                            </li>
                        @endcan



                        @can('lessons')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.lessons') }}" target="_blank">
                                    <i class="ni ni-single-copy-04 text-default"></i>
                                    <span class="nav-link-text">المواد الدراسية</span>
                                </a>
                            </li>
                        @endcan

                        @can('terms')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.terms') }}" target="_blank">
                                    <i class="ni ni-single-copy-04 text-default"></i>
                                    <span class="nav-link-text">الفصول</span>
                                </a>
                            </li>
                        @endcan


                        @can('years')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.show_years') }}" target="_blank">
                                    <i class="ni ni-single-copy-04 text-default"></i>
                                    <span class="nav-link-text">العام الدراسي الحالي</span>
                                </a>
                            </li>
                        @endcan



                        <li class="nav-item">
                            <a class="nav-link active" href=".resetPassword" data-toggle="modal">
                                <i class="ni ni-single-copy-04 text-default"></i>
                                <span class="nav-link-text">تغيير كلمة المرور</span>
                            </a>
                        </li>



                        @can('backup')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.backups') }}" target="_blank">
                                    <i class="ni ni-single-copy-04 text-default"></i>
                                    <span class="nav-link-text"> نسخة احتياطية</span>
                                </a>
                            </li>
                        @endcan


                        @can('roles')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.roles.index') }}" target="_blank">
                                    <i class="ni ni-single-copy-04 text-default"></i>
                                    <span class="nav-link-text">الأدوار </span>
                                </a>
                            </li>
                        @endcan


                        @can('users')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.users') }}" target="_blank">
                                    <i class="ni ni-single-copy-04 text-default"></i>
                                    <span class="nav-link-text">حسابات </span>
                                </a>
                            </li>
                        @endcan


                    </ul>


















                    <div class="modal fade resetPassword">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="form_update"
                                    action="{{ route('admin.reset_password', auth()->user()->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">تغيير كلمة المرور</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">





                                        <label for="">كلمة المرور القديمة</label>
                                        <br>


                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-lock"></i></span>
                                            </div>
                                            <input id="oold_password" name="old_password" type="password"
                                                value="" size="15" onkeyup="return passwordChanged();"
                                                class="input form-control" placeholder="password" required="true"
                                                aria-label="password" aria-describedby="basic-addon1" />
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="ppassword_show_hide1();">
                                                    <i class="fas fa-eye" id="sshow_eye1"></i>
                                                    <i class="fas fa-eye-slash d-none" id="hhide_eye1"></i>
                                                </span>
                                            </div>
                                        </div>








                                        <label for="">كلمة المرور الجديدة</label>
                                        <br>


                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-lock"></i></span>
                                            </div>
                                            <input name="password" type="password" value="" size="15"
                                                onkeyup="return passwordChanged();" class="input form-control"
                                                id="ppassword" placeholder="كلمة المرور" required="true"
                                                aria-label="password" aria-describedby="basic-addon1" />
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="ppassword_show_hide();">
                                                    <i class="fas fa-eye" id="sshow_eye"></i>
                                                    <i class="fas fa-eye-slash d-none" id="hhide_eye"></i>
                                                </span>
                                            </div>
                                        </div>



                                        <label for="">تأكيد كلمة المرور</label>
                                        <br>


                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-lock"></i></span>
                                            </div>
                                            <input name="password_confirmation" type="password" value=""
                                                size="15" onkeyup="return passwordChanged();"
                                                class="input form-control" id="ppassword-confirm"
                                                placeholder="اعادة كلمة المرور" required="true" aria-label="password"
                                                aria-describedby="basic-addon1" />
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="ppassword_show_hide2();">
                                                    <i class="fas fa-eye" id="sshow_eye2"></i>
                                                    <i class="fas fa-eye-slash d-none" id="hhide_eye2"></i>
                                                </span>
                                            </div>
                                        </div>





                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                        <button class="btn btn-info">حفظ</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
























                    @can('website')
                        <!-- Divider -->
                        <hr class="my-3">
                        <!-- Heading -->
                        <h6 class="navbar-heading p-0 text-muted">
                            <span class="docs-normal">الموقع الرئيسي</span>
                        </h6>
                        <!-- Navigation -->
                        <ul class="navbar-nav mb-md-3">


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.slider') }}" target="_blank">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">السلايدر الرئيسي</span>
                                </a>
                            </li>




                            <!--<li class="nav-item">-->
                            <!--    <a class="nav-link" href="{{ route('admin.header_info') }}" target="_blank">-->
                            <!--      <i class="ni ni-spaceship"></i>-->
                            <!--      <span class="nav-link-text">معلومات ترويسة الموقع</span>-->
                            <!--    </a>-->
                            <!--  </li>-->


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.inside_slider') }}" target="_blank">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">السلايدرات الداخلية</span>
                                </a>
                            </li>




                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.news') }}" target="_blank">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">الأخبار</span>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.about_us') }}">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">من نحن</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.contacts') }}">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">تواصل معنا</span>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.events') }}" target="_blank">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">الأحداث</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.blogs') }}" target="_blank">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">المقالات</span>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.jobs') }}" target="_blank">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">فرص العمل</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.applicants') }}" target="_blank">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">المتقدمون</span>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.video') }}" target="_blank">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">الفيديو الرئيسي</span>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.footer') }}" target="_blank">
                                    <i class="ni ni-spaceship"></i>
                                    <span class="nav-link-text">معلومات قسم الفوتر</span>
                                </a>
                            </li>

                        </ul>
                    @endcan

                </div>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Search form -->

                    @yield('search')
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item d-xl-none">
                            <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                                data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        <!--<li class="nav-item d-sm-none">-->
                        <!--  <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">-->
                        <!--    <i class="ni ni-zoom-split-in"></i>-->
                        <!--  </a>-->
                        <!--</li>-->
                        <!--<li class="nav-item dropdown">-->
                        <!--  <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--    <i class="ni ni-bell-55"></i>-->
                        <!--  </a>-->
                        <!--  <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">-->
                        <!-- Dropdown header -->
                        <!--    <div class="px-3 py-3">-->
                        <!--      <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong> notifications.</h6>-->
                        <!--    </div>-->
                        <!-- List group -->
                        <!--    <div class="list-group list-group-flush">-->
                        <!--      <a href="#!" class="list-group-item list-group-item-action">-->
                        <!--        <div class="row align-items-center">-->
                        <!--          <div class="col-auto">-->
                        <!-- Avatar -->
                        <!--            <img alt="Image placeholder" src="{{ asset('assets/img/theme/team-1.jpg') }}" class="avatar rounded-circle">-->
                        <!--          </div>-->
                        <!--          <div class="col ml--2">-->
                        <!--            <div class="d-flex justify-content-between align-items-center">-->
                        <!--              <div>-->
                        <!--                <h4 class="mb-0 text-sm">John Snow</h4>-->
                        <!--              </div>-->
                        <!--              <div class="text-right text-muted">-->
                        <!--                <small>2 hrs ago</small>-->
                        <!--              </div>-->
                        <!--            </div>-->
                        <!--            <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>-->
                        <!--          </div>-->
                        <!--        </div>-->
                        <!--      </a>-->
                        <!--      <a href="#!" class="list-group-item list-group-item-action">-->
                        <!--        <div class="row align-items-center">-->
                        <!--          <div class="col-auto">-->
                        <!-- Avatar -->
                        <!--            <img alt="Image placeholder" src="{{ asset('assets/img/theme/team-2.jpg') }}" class="avatar rounded-circle">-->
                        <!--          </div>-->
                        <!--          <div class="col ml--2">-->
                        <!--            <div class="d-flex justify-content-between align-items-center">-->
                        <!--              <div>-->
                        <!--                <h4 class="mb-0 text-sm">John Snow</h4>-->
                        <!--              </div>-->
                        <!--              <div class="text-right text-muted">-->
                        <!--                <small>3 hrs ago</small>-->
                        <!--              </div>-->
                        <!--            </div>-->
                        <!--            <p class="text-sm mb-0">A new issue has been reported for Argon.</p>-->
                        <!--          </div>-->
                        <!--        </div>-->
                        <!--      </a>-->
                        <!--      <a href="#!" class="list-group-item list-group-item-action">-->
                        <!--        <div class="row align-items-center">-->
                        <!--          <div class="col-auto">-->
                        <!-- Avatar -->
                        <!--            <img alt="Image placeholder" src="{{ asset('assets/img/theme/team-3.jpg') }}" class="avatar rounded-circle">-->
                        <!--          </div>-->
                        <!--          <div class="col ml--2">-->
                        <!--            <div class="d-flex justify-content-between align-items-center">-->
                        <!--              <div>-->
                        <!--                <h4 class="mb-0 text-sm">John Snow</h4>-->
                        <!--              </div>-->
                        <!--              <div class="text-right text-muted">-->
                        <!--                <small>5 hrs ago</small>-->
                        <!--              </div>-->
                        <!--            </div>-->
                        <!--            <p class="text-sm mb-0">Your posts have been liked a lot.</p>-->
                        <!--          </div>-->
                        <!--        </div>-->
                        <!--      </a>-->
                        <!--      <a href="#!" class="list-group-item list-group-item-action">-->
                        <!--        <div class="row align-items-center">-->
                        <!--          <div class="col-auto">-->
                        <!-- Avatar -->
                        <!--            <img alt="Image placeholder" src="{{ asset('assets/img/theme/team-4.jpg') }}" class="avatar rounded-circle">-->
                        <!--          </div>-->
                        <!--          <div class="col ml--2">-->
                        <!--            <div class="d-flex justify-content-between align-items-center">-->
                        <!--              <div>-->
                        <!--                <h4 class="mb-0 text-sm">John Snow</h4>-->
                        <!--              </div>-->
                        <!--              <div class="text-right text-muted">-->
                        <!--                <small>2 hrs ago</small>-->
                        <!--              </div>-->
                        <!--            </div>-->
                        <!--            <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>-->
                        <!--          </div>-->
                        <!--        </div>-->
                        <!--      </a>-->
                        <!--      <a href="#!" class="list-group-item list-group-item-action">-->
                        <!--        <div class="row align-items-center">-->
                        <!--          <div class="col-auto">-->
                        <!-- Avatar -->
                        <!--            <img alt="Image placeholder" src="{{ asset('assets/img/theme/team-5.jpg') }}" class="avatar rounded-circle">-->
                        <!--          </div>-->
                        <!--          <div class="col ml--2">-->
                        <!--            <div class="d-flex justify-content-between align-items-center">-->
                        <!--              <div>-->
                        <!--                <h4 class="mb-0 text-sm">John Snow</h4>-->
                        <!--              </div>-->
                        <!--              <div class="text-right text-muted">-->
                        <!--                <small>3 hrs ago</small>-->
                        <!--              </div>-->
                        <!--            </div>-->
                        <!--            <p class="text-sm mb-0">A new issue has been reported for Argon.</p>-->
                        <!--          </div>-->
                        <!--        </div>-->
                        <!--      </a>-->
                        <!--    </div>-->
                        <!-- View all -->
                        <!--    <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>-->
                        <!--  </div>-->
                        <!--</li>-->
                        <!--<li class="nav-item dropdown">-->
                        <!--  <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--    <i class="ni ni-ungroup"></i>-->
                        <!--  </a>-->
                        <!--  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default  dropdown-menu-right ">-->
                        <!--    <div class="row shortcuts px-4">-->
                        <!--      <a href="#!" class="col-4 shortcut-item">-->
                        <!--        <span class="shortcut-media avatar rounded-circle bg-gradient-red">-->
                        <!--          <i class="ni ni-calendar-grid-58"></i>-->
                        <!--        </span>-->
                        <!--        <small>Calendar</small>-->
                        <!--      </a>-->
                        <!--      <a href="#!" class="col-4 shortcut-item">-->
                        <!--        <span class="shortcut-media avatar rounded-circle bg-gradient-orange">-->
                        <!--          <i class="ni ni-email-83"></i>-->
                        <!--        </span>-->
                        <!--        <small>Email</small>-->
                        <!--      </a>-->
                        <!--      <a href="#!" class="col-4 shortcut-item">-->
                        <!--        <span class="shortcut-media avatar rounded-circle bg-gradient-info">-->
                        <!--          <i class="ni ni-credit-card"></i>-->
                        <!--        </span>-->
                        <!--        <small>Payments</small>-->
                        <!--      </a>-->
                        <!--      <a href="#!" class="col-4 shortcut-item">-->
                        <!--        <span class="shortcut-media avatar rounded-circle bg-gradient-green">-->
                        <!--          <i class="ni ni-books"></i>-->
                        <!--        </span>-->
                        <!--        <small>Reports</small>-->
                        <!--      </a>-->
                        <!--      <a href="#!" class="col-4 shortcut-item">-->
                        <!--        <span class="shortcut-media avatar rounded-circle bg-gradient-purple">-->
                        <!--          <i class="ni ni-pin-3"></i>-->
                        <!--        </span>-->
                        <!--        <small>Maps</small>-->
                        <!--      </a>-->
                        <!--      <a href="#!" class="col-4 shortcut-item">-->
                        <!--        <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">-->
                        <!--          <i class="ni ni-basket"></i>-->
                        <!--        </span>-->
                        <!--        <small>Shop</small>-->
                        <!--      </a>-->
                        <!--    </div>-->
                        <!--  </div>-->
                        <!--</li>-->
                    </ul>
                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <a class="btn btn-success btn-sm" style="color:#fff"
                            href="{{ asset('storage/Documentation for aladham Admin.pdf') }}" target="_blank">
                            مساعدة</a>

                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder"
                                            src="{{ asset('assets/img/theme/team-4.jpg') }}">
                                    </span>
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">@yield('name')</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">

                                <!--<div class="dropdown-header noti-title">-->
                                <!--  <h6 class="text-overflow m-0">Welcome!</h6>-->
                                <!--</div>-->
                                {{-- <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>Settings</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-calendar-grid-58"></i>
                  <span>Activity</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-support-16"></i>
                  <span>Support</span>
                </a> --}}
                                <div class="dropdown-divider"></div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="">
                                    @csrf
                                    <button href="{{ route('logout') }}" class="dropdown-item">
                                        <i class="ni ni-user-run"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->
        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">

            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                {{-- <div class="col">
          <div class="card"> --}}

                <!-- Light table -->



                @yield('content')



                {{-- </div>
        </div> --}}
            </div>







            <!-- Footer -->
            <footer class="footer pt-0">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6">
                        <div class="copyright text-center  text-lg-left  text-muted">
                            &copy; 2021 <a href="https://sunrise-center.net/" title="+963993299301"
                                class="font-weight-bold ml-1" target="_blank">SunriseIT</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            {{-- <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Su</a>
              </li> --}}
                            <li class="nav-item">
                                <a href="https://sunrise-center.net/" class="nav-link" target="_blank">About Us</a>
                            </li>
                            {{-- <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
              </li> --}}
                            {{-- <li class="nav-item">
                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
              </li> --}}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <!-- Argon JS -->
    <script src="{{ asset('assets/js/argon.js?v=1.2.0') }}"></script>

    <script src="{{ asset('students/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        function ppassword_show_hide() {
            var x = document.getElementById("ppassword");
            var show_eye = document.getElementById("sshow_eye");
            var hide_eye = document.getElementById("hhide_eye");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }


        function ppassword_show_hide1() {
            var x = document.getElementById("oold_password");
            var show_eye = document.getElementById("sshow_eye1");
            var hide_eye = document.getElementById("hhide_eye1");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }


        function ppassword_show_hide2() {
            var x = document.getElementById("ppassword-confirm");
            var show_eye = document.getElementById("sshow_eye2");
            var hide_eye = document.getElementById("hhide_eye2");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }
    </script>

</body>

</html>
