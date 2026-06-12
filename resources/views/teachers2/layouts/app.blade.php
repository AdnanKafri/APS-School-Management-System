<!DOCTYPE html>
<html lang="{{ app()->getLocale() === 'en' ? 'en' : 'ar' }}" dir="{{ app()->getLocale() === 'en' ? 'ltr' : 'rtl' }}">
<head>
    @php
        $logo = DB::table('other')->first();
        $scheduleController = new App\Http\Controllers\TeacherController_New();
        $teacher_id = $teacher->id;
        $available_lecture = $scheduleController->available_schedule($teacher_id);
        $isRtl = app()->getLocale() !== 'en';
        $school_data = \App\School_data::first();
        $teacherDisplayName = trim(($teacher->first_name ?? '') . ' ' . ($teacher->last_name ?? ''));
        $teacherDisplayName = $teacherDisplayName !== ''
            ? ($isRtl ? 'أ. ' . $teacherDisplayName : $teacherDisplayName)
            : ($isRtl ? 'الأستاذ' : 'Teacher');
        $pageTitle = trim($__env->yieldContent('teacher_page_title')) ?: ($isRtl ? 'لوحة الأستاذ' : 'Teacher Dashboard');
        $pageSubtitle = trim($__env->yieldContent('teacher_page_subtitle')) ?: ($isRtl ? 'إدارة الصفوف والشعب والدروس من مكان واحد.' : 'Manage classes, rooms, and lessons from one place.');
        $schoolName = $isRtl
            ? ((optional($school_data)->name ?: optional($school_data)->name_en) ?: 'مدرسة الأدهم الخاصة')
            : ((optional($school_data)->name_en ?: optional($school_data)->name) ?: 'Aladham Private School');
        $schoolLogo = optional($school_data)->logo_account ?: optional($school_data)->logo;
        $messageCount = (int) ($message ?? 0);
        $labels = [
            'portal' => $isRtl ? 'بوابة المعلم' : 'Teacher Portal',
            'welcome' => $isRtl ? 'مرحباً بك' : 'Welcome back',
            'subjects' => $isRtl ? 'المواد' : 'Subjects',
            'schedule' => $isRtl ? 'جدول الدوام' : 'Schedule',
            'exams' => $isRtl ? 'الامتحانات والمذاكرات' : 'Exams & Quizzes',
            'gradebook' => $isRtl ? 'دفتر العلامات' : 'Grade Book',
            'messages' => $isRtl ? 'رسائل الطلاب' : 'Student Messages',
            'logout' => $isRtl ? 'تسجيل خروج' : 'Log Out',
            'open_menu' => $isRtl ? 'فتح القائمة' : 'Open menu',
            'toggle_sidebar' => $isRtl ? 'طي الشريط الجانبي' : 'Toggle sidebar',
        ];
    @endphp

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $schoolLogo ? asset('storage/' . $schoolLogo) : asset('teachers_2/icons/teacher.png') }}">
    <title>{{ $schoolName }}</title>

    <link rel="stylesheet" href="{{ asset('teachers_2/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/vendors/jquery-bar-rating/css-stars.css') }}" />
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/css/demo_1/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/css/demo_1/showcontent_style.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/css/teacherstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/vendors/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="{{ asset('student/notify/css/notifIt.css') }}" />
    <script src="{{ asset('student/notify/js/notifIt.js') }}"></script>

    @yield('css')

    <style>
        body.teacher-portal-body #sidebar.sidebar.sidebar-offcanvas {
            position: fixed;
            top: 0;
            right: 0;
            left: auto;
            bottom: 0;
            width: 260px !important;
            min-width: 260px !important;
            min-height: 100vh;
            background: #0f172a !important;
            box-shadow: -18px 0 38px rgba(15, 23, 42, 0.2);
            overflow-x: hidden;
            transition: width 0.25s ease, min-width 0.25s ease, box-shadow 0.25s ease;
        }

        body.teacher-portal-body.ltr #sidebar.sidebar.sidebar-offcanvas {
            right: auto;
            left: 0;
            box-shadow: 18px 0 38px rgba(15, 23, 42, 0.2);
        }

        body.teacher-portal-body .navbar.default-layout-navbar {
            position: fixed;
            top: 0;
            right: 260px;
            left: 0;
            height: 64px;
            z-index: 1050;
            transition: right 0.25s ease, left 0.25s ease;
        }

        body.teacher-portal-body.ltr .navbar.default-layout-navbar {
            right: 0;
            left: 260px;
        }

        body.teacher-portal-body .main-panel {
            margin-right: 260px !important;
            margin-left: 0;
            width: calc(100% - 260px) !important;
            padding-top: 64px;
            transition: margin-right 0.25s ease, margin-left 0.25s ease, width 0.25s ease;
        }

        body.teacher-portal-body.ltr .main-panel {
            margin-right: 0;
            margin-left: 260px !important;
        }

        @media (min-width: 992px) {
            body.teacher-portal-body.sidebar-icon-only #sidebar.sidebar.sidebar-offcanvas {
                width: 88px !important;
                min-width: 88px !important;
            }

            body.teacher-portal-body.sidebar-icon-only .navbar.default-layout-navbar {
                right: 88px;
                left: 0;
            }

            body.teacher-portal-body.sidebar-icon-only.ltr .navbar.default-layout-navbar {
                right: 0;
                left: 88px;
            }

            body.teacher-portal-body.sidebar-icon-only .main-panel {
                margin-right: 88px !important;
                margin-left: 0;
                width: calc(100% - 88px) !important;
            }

            body.teacher-portal-body.sidebar-icon-only.ltr .main-panel {
                margin-right: 0;
                margin-left: 88px !important;
            }
        }

        @media (max-width: 991.98px) {
            body.teacher-portal-body #sidebar.sidebar.sidebar-offcanvas {
                top: 64px;
                right: -260px;
                left: auto;
                width: 260px;
                min-height: calc(100vh - 64px);
            }

            body.teacher-portal-body.ltr #sidebar.sidebar.sidebar-offcanvas {
                right: auto;
                left: -260px;
            }

            body.teacher-portal-body #sidebar.sidebar.sidebar-offcanvas.active {
                right: 0;
            }

            body.teacher-portal-body.ltr #sidebar.sidebar.sidebar-offcanvas.active {
                left: 0;
            }

            body.teacher-portal-body .navbar.default-layout-navbar,
            body.teacher-portal-body.ltr .navbar.default-layout-navbar {
                right: 0;
                left: 0;
            }

            body.teacher-portal-body .main-panel,
            body.teacher-portal-body.ltr .main-panel {
                margin-right: 0;
                margin-left: 0;
                width: 100%;
                padding-top: 64px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/css/teacher-responsive.css') }}">
</head>

<body class="teacher-portal-body {{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="container-scroller teacher-shell">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="teacher-sidebar__brand">
                <a href="{{ route('dashboard.teacher') }}" class="teacher-sidebar__brand-link">
                    <span class="teacher-sidebar__brand-logo-wrap">
                        <img src="{{ $schoolLogo ? asset('storage/' . $schoolLogo) : asset('teachers_2/icons/teacher.png') }}" alt="{{ $schoolName }}" class="teacher-sidebar__brand-logo">
                    </span>
                    <span class="teacher-sidebar__brand-copy">
                        <small>{{ $labels['portal'] }}</small>
                        <strong>{{ $schoolName }}</strong>
                    </span>
                </a>
            </div>

            <ul class="nav teacher-sidebar__nav">
                <li class="nav-item nav-profile">
                    <a href="{{ route('dashboard.teacher.profile') }}" class="nav-link teacher-sidebar-profile">
                        <span class="nav-profile-image teacher-sidebar-profile__avatar">
                            @if ($teacher->image)
                                <img src="{{ asset('storage/' . $teacher->image) }}" alt="{{ $teacherDisplayName }}">
                            @else
                                <img src="{{ asset('teachers_2/icons/teacher.png') }}" alt="{{ $teacherDisplayName }}">
                            @endif
                        </span>
                        <span class="teacher-sidebar-profile__text">
                            <small>{{ $labels['welcome'] }}</small>
                            <strong>{{ $teacherDisplayName }}</strong>
                        </span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('dashboard.teacher', 'dashboard.teacher_lessons2', 'dashboard.teacher_showcontent', 'dashboard.teacher_addcontent', 'dashboard.teacher_addsection') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.teacher') }}">
                        <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                        <span class="menu-title">{{ $labels['subjects'] }}</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('dashboard.teacher_schedule') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.teacher_schedule') }}">
                        <i class="mdi mdi-calendar-range menu-icon"></i>
                        <span class="menu-title">{{ $labels['schedule'] }}</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('teacher.exams_quizes') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('teacher.exams_quizes') }}">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title">{{ $labels['exams'] }}</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('teacher.mark_class', 'teacher.mark_room', 'teacher.teacher_marks_subjects') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('teacher.mark_class') }}">
                        <i class="mdi mdi-notebook menu-icon"></i>
                        <span class="menu-title">{{ $labels['gradebook'] }}</span>
                    </a>
                </li>
            </ul>
        </nav>
        <button type="button" class="teacher-sidebar-backdrop" aria-label="{{ $labels['toggle_sidebar'] }}" tabindex="-1"></button>

        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <div class="teacher-topbar__start">
                    <button class="navbar-toggler align-self-center teacher-topbar__toggle d-none d-lg-inline-flex" type="button" data-toggle="minimize" aria-label="{{ $labels['toggle_sidebar'] }}">
                        <span class="mdi mdi-menu-open"></span>
                    </button>
                    <button class="navbar-toggler navbar-toggler-right align-self-center teacher-topbar__toggle d-lg-none" type="button" data-toggle="offcanvas" aria-label="{{ $labels['open_menu'] }}">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <div class="teacher-topbar__heading">
                        <span class="teacher-topbar__eyebrow">{{ $labels['portal'] }}</span>
                        <h1>{{ $pageTitle }}</h1>
                        <p>{{ $pageSubtitle }}</p>
                    </div>
                </div>

                <div class="teacher-topbar__actions">
                    <a class="teacher-topbar__icon" href="{{ route('get_message') }}" title="{{ $labels['messages'] }}" aria-label="{{ $labels['messages'] }}">
                        <i class="mdi mdi-email-outline"></i>
                        @if ($messageCount > 0)
                            <span class="teacher-topbar__badge">{{ $messageCount }}</span>
                        @endif
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="teacher-topbar__logout-form">
                        @csrf
                        <button type="submit" class="teacher-topbar__icon" title="{{ $labels['logout'] }}" aria-label="{{ $labels['logout'] }}">
                            <i class="mdi mdi-logout"></i>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <link rel="stylesheet" href="{{ asset('student/notify/css/notifIt.css') }}" />
    <script src="{{ asset('student/notify/js/notifIt.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/jquery-bar-rating/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/flot/jquery.flot.fillbetween.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/js/select2.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/js/misc.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/js/settings.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/js/todolist.js') }}"></script>
    <script src="{{ asset('teachers_2/assets/js/dashboard.js') }}"></script>
    <script>
        (function ($) {
            'use strict';

            var mobileBreakpoint = 992;
            var $body = $('body.teacher-portal-body');
            var $sidebar = $('#sidebar');
            var $backdrop = $('.teacher-sidebar-backdrop');

            function syncMobileSidebar() {
                var isOpen = window.innerWidth < mobileBreakpoint && $sidebar.hasClass('active');
                $body.toggleClass('teacher-sidebar-open', isOpen);
                $backdrop.attr('tabindex', isOpen ? '0' : '-1');
            }

            function closeMobileSidebar() {
                $sidebar.removeClass('active');
                syncMobileSidebar();
            }

            $(document).on('click', '[data-toggle="offcanvas"]', function () {
                window.setTimeout(syncMobileSidebar, 0);
            });

            $backdrop.on('click', closeMobileSidebar);
            $sidebar.on('click', 'a[href]', function () {
                if (window.innerWidth < mobileBreakpoint) {
                    closeMobileSidebar();
                }
            });

            $(document).on('keydown', function (event) {
                if (event.key === 'Escape' && $body.hasClass('teacher-sidebar-open')) {
                    closeMobileSidebar();
                }
            });

            $(window).on('resize', function () {
                if (window.innerWidth >= mobileBreakpoint) {
                    closeMobileSidebar();
                    return;
                }
                syncMobileSidebar();
            });
        })(jQuery);
    </script>
    <script>
        $(window).on('load', function () {
            if ("{{ Session::has('success') }}") {
                notif({msg: "{{ Session::get('success') }}", type: 'success'})
            }
            if ("{{ Session::has('error') }}") {
                notif({msg: "{{ Session::get('error') }}", type: 'error'})
            }
        })
    </script>

    @yield('js')
</body>
</html>
