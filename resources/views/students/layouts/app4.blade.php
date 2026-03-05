<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Student</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('student/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('student/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('student/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('student/assets/vendors/jquery-bar-rating/css-stars.css') }}" />
    <link rel="stylesheet" href="{{ asset('student/assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('student/notify/css/notifIt.css') }}" />
    <script src="{{ asset('student/notify/js/notifIt.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset("storage/")}}/{{$school_data->logo}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <style>
        @media(min-width:100px) and (max-width:848px) {
            .sidebar .nav .nav-item .nav-link i.menu-icon {
                font-size: 25px !important;
                line-height: 1.2;
                margin-right: -1px !important;
                color: #6a6b83;
            }

            .menu-icon2 {
                max-width: 14% !important;
                margin-right: -4px !important;
            }
        }

        @media screen and (max-width: 991px) {
            .sidebar .nav .nav-item {
                padding: 0rem !important;
                padding-right: 10px !important;
            }
        }

        @media (min-width:200px) and (max-width:500px) {

            .coll {
                width: 50% !important
            }

            .blob-btn {
                padding: 6px 7px !important;
            }

            .buttons {
                margin-top: 7px !important;
            }

            .font-weight-semibold {
                font-size: 16px;
            }
        }

        .stop {
            text-decoration: none;
        }

        @media (min-width: 992px) {
            .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title {
                color: #152C4F !important;
                border-radius: 0px 5px 5px 0px;
                text-align: center !important;
            }
        }

        @media (min-width: 992px) {
            .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-icon {

                max-width: 26% !important;
            }
        }

        @media (min-width: 992px) {
            .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-icon2 {

                max-width: 33% !important;
            }
        }

        @media (min-width: 992px) {
            .sidebar-icon-only .sidebar .nav .nav-item .nav-link i.menu-icon {
                margin-right: 12px !important;
                margin-left: 0px !important;

            }
        }

        .dropdown-item {
            justify-content: end !important
        }

        .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .dropdown-menu.navbar-dropdown .dropdown-item {
            margin-top: 6px !important;
            margin-bottom: 6px !important;
        }
    </style>
    @yield('css')
</head>
@php
    $year = DB::table('years')->where('current_year', '1')->first();

    $messages_count = DB::table('messages')
        ->where('student_id', $student->id)
        ->where('year_id', $year->id)
        ->where('view', 0)
        ->where('type', 0)
        ->count();
    $scheduleController = new App\Http\Controllers\studentscontroller();
    $available_lecture = $scheduleController->available_schedule($room_id, $student->id);

@endphp
@php
    $year = DB::table('years')->where('current_year', '1')->first();

    $messages_count2 = DB::table('messages')
        ->where('student_id', $student->id)
        ->where('admin_id', '!=', null)
        ->where('year_id', $year->id)
        ->where('view', 0)
        ->where('type', 0)
        ->count();
    $notification = DB::table('notifications')
        ->where('student_id', $student->id)
        ->take(100)
        ->orderBy('id', 'DESC')
        ->get();
    $notification_number = DB::table('notifications')
        ->where('student_id', $student->id)
        ->where('view', 0)
        ->count();
@endphp
@php
    $year = DB::table('years')->where('current_year', '1')->first();
    $room = $student
        ->room()
        ->where('rooms.year_id', $year->id)
        ->first();
    $class = $room->classes;
    $report_card_details = DB::table('report_card_details')
        ->where('year_id', $year->id)
        ->where('class_id', $class->id)
        ->first();

@endphp
@php
    $school_data = \App\School_data::first();
@endphp

<body style="background: #f8f9fb;">
    <input id="student_id52" type="hidden" value="{{ $student->id }}">
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <!--logo-->
                    <a class="nav-link" data-toggle="collapse" href="#" aria-expanded="false"
                        aria-controls="ui-basic">
                        <!--img class="sidebar-brand-logo" src="../smartlogo.png" alt="" /-->
                        <span class="menu-title" style="font-weight: 900;"></span>
                    </a>
                    <!--end logo-->
                </li>

                <li class="nav-item nav-profile border-bottom">
                    <!--start profile-->
                    <div class="row resprow">
                        {{-- <div class="col-md-4 respnecol">
                            <img class="sidebar-brand-logo" src="{{ asset('storage/' . $school_data->logo_account) }}" width="50" height="50"
                                alt="" />
                        </div> --}}
                        <div class="col-md-4 respnecol">
                            <a href="{{ route('dashboard.student.profile', [$student->id, $room_id]) }}"
                                class="nav-link flex-column">
                                <div class="nav-profile-image">
                                    @if ($student->image)
                                        <img src="{{ asset('storage/' . $student->image) }}" alt="profile" />
                                    @else
                                        <img src=" {{ asset('student/avatar.png') }}" alt="profile" />
                                    @endif


                                    <!--change to offline or busy as needed-->
                                </div>
                                <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                                    <span class="font-weight-semibold mb-1 mt-2 text-center" style="color:#ffff ;"
                                        style="color: #fff;"> {{ $student->first_name }} {{ $student->last_name }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!--end profile-->

                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.student.lessons', $student->id) }}">
                        <i class="mdi mdi-book menu-icon"></i>
                        <span class="menu-title">المواد</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('dashboard.students.room.view_schedule', [$room_id, $student->id, 1]) }}">
                        <img src="{{ asset('student/demo/icons/icons8-calender-50 (1).png') }}" alt=""
                            class="menu-icon" style="max-width: 10.5%;">
                        &nbsp;&nbsp;
                        <!--i class="mdi mdi-calendar menu-icon"></i-->
                        <span class="menu-title">جدول الدوام</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student_exam') }}">
                        <!--i class="mdi mdi-file-document-box menu-icon"></i-->
                        <img src="{{ asset('student/demo/icons/icons8-exam-30 .png') }}" alt=""
                            class="menu-icon2" style="max-width: 13%;">
                        &nbsp;
                        <span class="menu-title">الامتحانات</span>
                    </a>
                </li>
                
  
           
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.book', $class->id) }}">
                        <i class="mdi mdi-book-multiple menu-icon"></i>
                        <span class="menu-title">الكتب المدرسية</span>
                    </a>
                </li>
        
                         <li class="nav-item lesson11">
            <a class="nav-link" href="{{ route('dashboard.student.medical_profile', [$room_id, $student->id]) }}">
              <i class="mdi mdi-book menu-icon"></i>
              <span class="menu-title">الملف الطبي</span>
            </a>
          </li>
          
          
                                   <li class="nav-item lesson11">
            <a class="nav-link" href="{{ route('dashboard.student.transport', [$room_id, $student->id]) }}">
              <i class="mdi mdi-book menu-icon"></i>
              <span class="menu-title">المواصلات </span>
            </a>
          </li>

            </ul>
        </nav>


        <!--start header-->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                    data-toggle="minimize">
                    <span class="mdi mdi-chevron-double-left"></span>
                </button>
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img
                            src="{{ asset('student/assets/images/logo-mini.svg') }}" alt="logo" /></a>
                </div>
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a title="الرسائل" class="nav-link" id="messageDropdown" href="#"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-email-outline"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list"
                            aria-labelledby="messageDropdown" style="height: auto;
                            overflow: inherit;">

                            <div class="dropdown-divider"></div>
                            <!--first choice-->
                            <a class="dropdown-item preview-item" href="{{ route('student_admin_message') }}">
                                <div class="preview-thumbnail">
                                    <img src="{{ asset('student/adminvvv-01.png') }}" alt="image">
                                </div>
                                <div
                                    class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="preview-subject ellipsis mb-1 font-weight-normal">الرسائل مع الإدارة
                                    </h6>

                                </div>
                            </a>
                            <!--end first choice-->
                            <div class="dropdown-divider"></div>
                            <!--secound choice-->
                            <a class="dropdown-item preview-item"
                                href="{{ route('dashboard.student.messages', [$student->id, 0]) }}">
                                <div class="preview-thumbnail">
                                    <img src="{{ asset('student/techerrrr-01.png
                                                          ') }}"
                                        alt="image" class="profile-pic">
                                </div>
                                <div
                                    class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="preview-subject ellipsis mb-1 font-weight-normal">الرسائل مع الاستاذ
                                    </h6>

                                </div>
                            </a>
                            <!--end secound choice-->
                    </li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link" id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="mdi mdi-bell-outline"></i>
                            <span class="btn__badge pulse-button " id="number_noti"
                                data-number="{{ $notification_number }}">{{ $notification_number }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list "
                            aria-labelledby="notificationDropdown">
                            <h6 class="px-3 py-3 font-weight-semibold mb-0">الاشعارات</h6>
                            <div class="dropdown-divider"></div>

                            <div class="dropdown-divider"></div>

                            <div class="notification">
                                @foreach ($notification as $item)
                                    @if ($item->type == 1)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                                               margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('dashboard.student.lesson.lecture.content', [$item->lesson_id, $student->id, $item->lecture_id]) }}">
                                                <div class="preview-item-content">

                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                                                display: flex;
                                                font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>

                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                                                 margin-bottom: 6px;"
                                                href="{{ route('dashboard.student.lesson.lecture.content', [$item->lesson_id, $student->id, $item->lecture_id]) }}">
                                                <div class="preview-item-content">

                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>

                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 2)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                                          margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('dashboard.student.events') }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>

                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                                                    margin-bottom: 6px;"
                                                href="{{ route('dashboard.student.events') }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>

                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 3)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                  margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('student.student_rewads', [$student->id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                  margin-bottom: 6px;"
                                                href="{{ route('student.student_rewads', [$student->id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @endif

                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 4)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                  margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('dashboard.student.room.main.quizes', [$item->room_id, $student->id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                  margin-bottom: 6px;"
                                                href="{{ route('dashboard.student.room.main.quizes', [$item->room_id, $student->id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 5)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('dashboard.student.room.main.exams', [$item->room_id, $student->id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;"
                                                href="{{ route('dashboard.student.room.main.exams', [$item->room_id, $student->id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 6)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('dashboard.student.lesson.lectures', [$item->lesson_id, $item->room_id, $student->id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;"
                                                href="{{ route('dashboard.student.lesson.lectures', [$item->lesson_id, $item->room_id, $student->id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 7)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('dashboard.student.lesson.lecture.content', [$item->lesson_id, $student->id, $item->lecture_id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;"
                                                href="{{ route('dashboard.student.lesson.lecture.content', [$item->lesson_id, $student->id, $item->lecture_id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 9)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;"
                                                target="_blank" href="{{ route('student_view_report_card') }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;"
                                                target="_blank" href="{{ route('student_view_report_card') }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 10)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('dashboard.student.messages', [$student->id, $item->teacher_id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;"
                                                href="{{ route('dashboard.student.messages', [$student->id, $item->teacher_id]) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 11)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('student_admin_message') }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;"
                                                href="{{ route('student_admin_message') }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @elseif($item->type == 12)
                                        @if ($item->view == 0)
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;"
                                                href="{{ route('student_electronic_files', $item->room_id) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a class="dropdown-item preview-item noti_href"
                                                data-id="{{ $item->id }}"
                                                style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;"
                                                href="{{ route('student_electronic_files', $item->room_id) }}">
                                                <div class="preview-item-content">
                                                    <p style="padding-left:20px;">{{ $item->body }}
                                                        <span
                                                            style="color: gray;
                          display: flex;
                         font-size: 10px;">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('h:i a') }}</span>
                                                    </p>
                                                    <h6 style="margin-left: 70px;">{{ $item->title }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-divider"></div>
                                    @endif
                                @endforeach

                            </div>

                    </li> --}}
                    <!--events-->
                    {{-- <li class="nav-item dropdown eventmobile">
                        <a class="nav-link" id="notificationDropdown"
                            href="{{ route('dashboard.student.events') }}" title="الاحداث">
                            <!--i class="mdi mdi-calendar"></i-->
                            <img src="{{ asset('student/demo/icons/icons8-reminder-50.png') }}" alt=""
                                style="width: 60%; position: relative;
                  left: 8px;">
                        </a>
                    </li> --}}

                    <!--end events-->
                    {{-- <li class="nav-item eventmobile">
                        <a class="nav-link" id="notificationDropdown" target="_blank"
                            href="{{ route('student_view_report_card') }}">
                            <img src="{{ asset('student/diploma.png') }}" alt="" style="width: 50px;">
                        </a>
                    </li> --}}
                    <!--live lessons-->
                    {{-- <li class="nav-item">
                        @if (isset($available_lecture) && isset($available_lecture->meeting_link))
                            <a target="_blank"
                                href="{{ route('dashboard.students.room.go_to_stream', ['scheduler_id' => $available_lecture->id, 'day_id' => $available_lecture->day_id, 'lecture_time_id' => $available_lecture->lecture_time_id, 'room_id' => $room->id, 'student_id' => $student->id]) }}"
                                class="live">
                                الدخول الى الحصة
                                &nbsp; <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true" width="26px">
                                    <path
                                        d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"
                                        fill="currentColor"></path>
                                </svg>
                            </a>
                        @else
                            <a class="live stop"
                                style="
               background: gray;
                animation: -0.8s cubic-bezier(0.8, 0, 0, 1) 0s infinite normal none running pulse;">
                                لايوجد حصة
                                &nbsp; <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true" width="26px">
                                    <path
                                        d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"
                                        fill="currentColor"></path>
                                </svg>
                            </a>
                        @endif


                    </li> --}}
                    <!--end live lessons-->
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-logout d-none d-lg-block">
                        <form action="{{ route('logout') }}" title="تسجيل خروج" method="POST">
                            @csrf
                            <a id="deletekey" title="تسجيل خروج"
                                style="background: #ffdead00;
                   border: none;">
                                <i class="mdi mdi-export" title="تسجيل خروج"
                                    style="color:white;font-size: x-large;"></i>
                            </a>

                        </form>
                    </li>

                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        @yield('content')
    </div>

    {{-- <div class="container-scroller"> --}}
    <!-- partial:partials/_sidebar.html -->
    {{-- <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <!--logo-->
            <a class="nav-link" data-toggle="collapse" href="#" aria-expanded="false" aria-controls="ui-basic">
              <img class="sidebar-brand-logo" src="{{ asset('student/smartlogo.png') }}" alt="" />
              <span class="menu-title" style="font-weight: 900;">المدرسة السورية الذكية</span>
            </a>
            <!--end logo-->
          </li>
          <li class="nav-item nav-profile border-bottom">
            <!--start profile-->
            <a href="{{ route('dashboard.student.profile',[$student->id,$room_id]) }}" class="nav-link flex-column">
              <div class="nav-profile-image">
                @if ($student->image)
                <img src="{{ asset('storage/'. $student->image) }}" alt="profile" />
                @else
                <img src=" {{ asset('student/avatar.png') }}" alt="profile" />

                @endif

                <!--change to offline or busy as needed-->
              </div>
              <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                <span class="font-weight-semibold mb-1 mt-2 text-center">   {{ $student->first_name }} {{ $student->last_name }} </span>

              </div>
            </a>
            <!--end profile-->

          </li>

          <li class="nav-item lesson11">
            <a class="nav-link" href="{{ route('dashboard.student.lessons',$student->id) }}">
              <i class="mdi mdi-book menu-icon"></i>
              <span class="menu-title">المواد</span>
            </a>
          </li>
          <li class="nav-item sh11">
            <a class="nav-link" href="{{ route('dashboard.students.room.view_schedule',[$room_id,$student->id,1]) }}">
              <i class="mdi mdi-calendar menu-icon"></i>
              <span class="menu-title">جدول الدوام</span>
            </a>
          </li>
          <li class="nav-item exam11">
            <a class="nav-link" href="{{route('student_exam')}}">
              <i class="mdi mdi-file-document-box menu-icon"></i>
              <span class="menu-title">الامتحانات</span>
            </a>
          </li>
          <li class="nav-item medal11">
            <a class="nav-link" href="{{ route('student.student_rewads',[$student->id]) }}">
              <i class="mdi mdi-certificate menu-icon"></i>
              <span class="menu-title">الاوسمة</span>
            </a>
          </li>
          
                    <li class="nav-item lesson11">
            <a class="nav-link" href="{{ route('dashboard.student.medical_profile', [$item->room_id, $student->id]) }}">
              <i class="mdi mdi-book menu-icon"></i>
              <span class="menu-title">الملف الطبي</span>
            </a>
          </li>
          <!--<li class="nav-item m11">-->
          <!--  <a class="nav-link" href="{{ route('dashboard.financial_account',$student->id) }}">-->
          <!--    <i class="mdi mdi-account-card-details menu-icon"></i>-->
          <!--    <span class="menu-title">القسم المالي</span>-->
          <!--  </a>-->
          <!--</li>-->

        </ul>
      </nav>


       <!--start header-->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-chevron-double-left"></span>
            </button>
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
              <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../assets/images/logo-mini.svg" alt="logo" /></a>
            </div>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email-outline"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list" aria-labelledby="messageDropdown" style="height: auto;
    overflow: inherit;">
                  <h6 class="p-3 mb-0 font-weight-semibold">الرسائل </h6>
                  <div class="dropdown-divider"></div>
                  <!--first choice-->
                  <a class="dropdown-item preview-item" href="{{ route('student_admin_message') }}">
                    <div class="preview-thumbnail">
                      <img src="{{ asset('student/adminvvv-01.png') }}" alt="image" >
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject ellipsis mb-1 font-weight-normal">الرسائل مع الإدارة </h6>

                    </div>
                  </a>
                  <!--end first choice-->
                  <div class="dropdown-divider"></div>
                  <!--secound choice-->
                  <a class="dropdown-item preview-item" href="{{ route('dashboard.student.messages',$student->id) }}">
                    <div class="preview-thumbnail">
                      <img src="{{ asset('student/techerrrr-01.png
                      ') }}" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject ellipsis mb-1 font-weight-normal">الرسائل مع الاستاذ</h6>

                    </div>
                  </a>
                  <!--end secound choice-->
              </li>
              <li class="nav-item dropdown ml-3">
                <a class="nav-link" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell-outline"></i>
                  <span class="btn__badge pulse-button ">4</span>
                </a>
                <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="px-3 py-3 font-weight-semibold mb-0">الاشعارات</h6>
                  <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>

                  <!---->
                  <a class="dropdown-item preview-item">
                    <div class="preview-item-content d-flex align-items-start justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-0">Server limit reached</h6>
                      <p class="text-gray ellipsis mb-0">23min</p>
                    </div>
                  </a>
                  <!----->

                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-item-content d-flex align-items-start justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-0">Server limit reached</h6>
                      <p class="text-gray ellipsis mb-0">23min</p>
                    </div>
                  </a>

                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-item-content d-flex align-items-start justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-0">Server limit reached</h6>
                      <p class="text-gray ellipsis mb-0">23min</p>
                    </div>
                  </a>
              </li>
              <!--events-->
              <li class="nav-item dropdown ml-3">
                <a class="nav-link" id="notificationDropdown" href="{{route('dashboard.student.events')}}" title="الاحداث">
                  <i class="mdi mdi-calendar"></i>
                </a>
              </li>
              @if (isset($report_card_details) && $report_card_details->report_card_status > 0)
              <li class="nav-item dropdown ml-3">
                <a href="{{ route('student_view_report_card') }}" title="الجلاء المدرسي">
                  <img id ="graduation2" style="width: 51px;
                  border-radius: 50%;"  class="wow pulse" src="{{  asset('student/diploma.png') }}" alt="الجلاء"
                  data-wow-iteration="infinite" data-wow-duration="1000ms">
                </a>
              </li>
              @endif

              <!--end events-->
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item nav-logout d-none d-lg-block">
                <a class="nav-link" href="" style="padding-top: 23px;">

                  <form action="{{route('logout')}}"  method="POST"  >
                    @csrf
                    <button href="{{ route('logout') }}" style="background: #ffdead00;
                     border: none;">
                        <i class="mdi mdi-export" style="color:white"></i>
                    </button>
                </form>
                </a>
              </li>
            </ul>

            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">

                <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </nav> --}}
    {{-- @if (isset($available_lecture) && isset($available_lecture->meeting_link))
        <div class="available_schedule available_schedule_animation text-center bg-white p-3" style="position: fixed; bottom:3%; left:33px;">
            <img src="{{ asset('student/lecture2.gif') }}" alt="" width="100" class="img-fluid rounded-circle mb-2 img-thumbnail shadow-sm">

            <p class="d-block" style="color:#0e2144;">  انقر للانضمام</p>
            <a class="available_schedule_a wow pulse" style="display:block"
                href="{{ route('dashboard.students.room.go_to_stream',['scheduler_id' => $available_lecture->id,'day_id' => $available_lecture->day_id,'lecture_time_id' => $available_lecture->lecture_time_id, 'room_id' => $room_id,'student_id' => $student->id]) }}"
                data-wow-iteration="infinite" data-wow-duration="1000ms"> {{ $available_lecture->lesson->name }}
                {{-- <img id ="graduation" class="wow pulse" src="{{  asset('student-UI/img/g.jpeg') }}" alt="الجلاء"
                style="" data-wow-iteration="infinite" data-wow-duration="1000ms"> --}}
    {{-- </a> --}}
    {{-- </div> --}}
    {{-- @endif --}}



    <!--end header-->



    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="{{ asset('student/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('student/assets/vendors/jquery-bar-rating/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('student/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('student/assets/vendors/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('student/assets/vendors/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('student/assets/vendors/flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('student/assets/vendors/flot/jquery.flot.fillbetween.js') }}"></script>
    <script src="{{ asset('student/assets/vendors/flot/jquery.flot.stack.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('student/assets/js/off-canvas.jss') }}"></script>
    <script src="{{ asset('student/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('student/assets/js/misc.js') }}"></script>
    <script src="{{ asset('student/assets/js/settings.js') }}"></script>
    <script src="{{ asset('student/assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('student/assets/js/dashboard.js') }}"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>

    <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-messaging.js"></script>


    <script>
        $(document).ready(function() {

            student_id52 = $('#student_id52').val();
            $(document).on('click', '.noti_href_append', function(event) {
                event.preventDefault(); // prevent the default hyperlink behavior

                var id = $(this).data('id');
                var href = $(this).attr('href');
                var url = "{{ URL::to('SMARMANger/dashboard/student/read_notification') }}/" + id;

                $.ajax({
                    url: url,
                    type: "get",
                    contentType: 'application/json',
                    success: function(data) {
                        console.log(data);
                        // get the href attribute from the event target
                        window.location.href = href;
                        // redirect the browser to the specified URL
                    },
                    error: function(xhr) {
                        // handle errors
                    }
                });
            });



            $(document).on('click', '#deletekey', function() {

                var id = $(this).data('id');
                var url = "{{ URL::to('SMARMANger/dashboard/student/deletekey_notification') }}";
                $.ajax({
                    url: url,
                    type: "get",
                    contentType: 'application/json',
                    success: function(data) {

                        console.log(data);

                    },
                    error: function(xhr) {

                    }


                });
                $('#deletekey').closest('form').submit();
            });

            $(document).on('click', '.noti_href', function() {

                var id = $(this).data('id');
                var url = "{{ URL::to('SMARMANger/dashboard/student/read_notification') }}/" + id;
                $.ajax({
                    url: url,
                    type: "get",
                    contentType: 'application/json',
                    success: function(data) {

                        console.log(data);
                        event.preventDefault();
                        var href = $(this).attr('href');

                        //  window.open(href);
                    },
                    error: function(xhr) {

                    }


                });
            });


        })

        const firebaseConfig = {
            apiKey: "AIzaSyBsViQf5LtwHoXguoeTnK8uh6j2QClMwug",
            authDomain: "smart-syrian-school.firebaseapp.com",
            projectId: "smart-syrian-school",
            storageBucket: "smart-syrian-school.appspot.com",
            messagingSenderId: "796754541605",
            appId: "1:796754541605:web:f7c216799d251a563f93cc",
            measurementId: "G-N5SHZKZZ4W"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function IntitalizeFireBaseMessaging() {
            messaging
                .requestPermission()
                .then(function() {
                    console.log("Notification Permission");

                    return messaging.getToken();
                })
                .then(function(token) {
                    console.log("Token : " + token);
                    saveToken(token);
                    // document.getElementById("token").innerHTML=token;
                })
                .catch(function(reason) {
                    console.log(reason);
                });
        }


        messaging.onMessage(function(payload) {
            student_id52 = $('#student_id52').val();
            console.log('-0-0-0-0-0-0');

            console.log(payload);
            console.log(payload.data['gcm.notification.type']);
            const notificationOption = {
                body: payload.notification.body,
                icon: payload.notification.icon
            };

            if (Notification.permission === "granted") {
                var notification = new Notification(payload.notification.title, notificationOption);

                notification.onclick = function(ev) {
                    ev.preventDefault();
                    window.open(payload.notification.click_action, '_blank');
                    notification.close();
                }
            }
            var now = new Date();
            var date = (now.getMonth() + 1) + '/' + now.getDate();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12;
            var time = hours + ':' + (minutes < 10 ? '0' + minutes : minutes) + ' ' + ampm;
            var dateTime = date + ' ' + time;

            if (payload.data['gcm.notification.type'] == 1) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student/lesson/lecture/content') }}/${payload.data['gcm.notification.lesson_id']}/${student_id52}/${payload.data['gcm.notification.lecture_id']}">
                   <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                       <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>

                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);
            }
            if (payload.data['gcm.notification.type'] == 2) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student/events') }}">
                   <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);

            }
            if (payload.data['gcm.notification.type'] == 3) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student/student_rewads') }}/${student_id52}">
                   <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);

            }
            if (payload.data['gcm.notification.type'] == 4) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student/room/main_quizes') }}/${payload.data['gcm.notification.room_id']}/${student_id52}">
                   <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);

            }
            if (payload.data['gcm.notification.type'] == 5) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"   style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"  href="{{ url('SMARMANger/dashboard/student/room/main_exams') }}/${payload.data['gcm.notification.room_id']}/${student_id52}">
                   <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);

            }
            if (payload.data['gcm.notification.type'] == 6) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student/lesson/lectures') }}/${payload.data['gcm.notification.lesson_id']}/${payload.data['gcm.notification.room_id']}/${student_id52}">
                    <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);

            }
            if (payload.data['gcm.notification.type'] == 7) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student/lesson/lecture/content') }}/${payload.data['gcm.notification.lesson_id']}/${student_id52}/${payload.data['gcm.notification.lecture_id']}">
                    <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    // </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);
            }
            if (payload.data['gcm.notification.type'] == 9) {
                $('.notification').prepend(`
                 <a target="_blank" class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;"  data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student/view/report/card') }}">
                    <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);
            }
            if (payload.data['gcm.notification.type'] == 10) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student/messages') }}/${student_id52}/${payload.data['gcm.notification.lesson_id']}">
                    <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);
            }
            if (payload.data['gcm.notification.type'] == 11) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student_admin_message') }}">
                    <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);
            }
            if (payload.data['gcm.notification.type'] == 12) {
                $('.notification').prepend(`
                 <a class="dropdown-item preview-item noti_href noti_href_append"  style="justify-content: space-between !important;margin-top: 6px;
                 margin-bottom: 6px;background: #f3f3f3;" data-id="${payload.data['gcm.notification.id']}"   href="{{ url('SMARMANger/dashboard/student/electronic_files') }}/${payload.data['gcm.notification.room_id']}">
                    <div class="preview-item-content">
                       <p style="padding-left:20px;">${payload.notification.body}
                        <span style="color: gray;
                          display: flex;
                         font-size: 10px;">${dateTime} </span></p>
                       <h6  style="margin-left: 70px;">${payload.notification.title}</h6>
                    </div>
                  </a>
                    <div class="dropdown-divider"></div>

                  <div class="dropdown-divider"></div>`);

            }


            number_noti = parseInt($('#number_noti').data('number'));
            number_noti = number_noti + 1;
            $('#number_noti').text(number_noti);






        });
        messaging.onTokenRefresh(function() {
            messaging.getToken()
                .then(function(newtoken) {
                    console.log("New Token : " + newtoken);
                })
                .catch(function(reason) {
                    console.log(reason);
                })
        })

        IntitalizeFireBaseMessaging();

        function saveToken(token) {


            $.ajax({
                type: "get",
                url: 'https://aladham.school/SMARMANger/studentSaveToken',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id_fk': 2,
                    'fcm_token': token,
                },
                beforeSend: function() {},
                success: function(data) {
                    console.log((data));

                    // show response from the php script.
                }
            });
        }

        $(document).ready(function() {
            $.each($('.nav-item'), function(key1, value) {
                $(value).removeClass('active');
            })
            $('.navbar-toggler').on('click', function(e) {
                if ($('.sidebar-offcanvas').hasClass("active")) {
                    $('.sidebar-offcanvas').removeClass('active');
                } else {
                    $('.sidebar-offcanvas').addClass('active');
                }

            })


        })
    </script>
    @yield('js')
    <!-- End custom js for this page -->
</body>

</html>
