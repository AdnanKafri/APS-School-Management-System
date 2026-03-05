@extends('admin.layouts.v2')
@section('hide_page_header', 'true')

@section('style')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap');

        .dashboard-modern {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            background: radial-gradient(circle at top right, rgba(59,130,246,0.08), transparent 40%);
            border-radius: 18px;
            padding: .45rem;
        }

        html[dir="ltr"] .dashboard-modern {
            direction: ltr;
            text-align: left;
        }

        .kpi-grid,
        .quick-grid {
            row-gap: 1rem;
            direction: rtl;
        }

        html[dir="ltr"] .kpi-grid,
        html[dir="ltr"] .quick-grid {
            direction: ltr;
        }

        .quick-action-card:hover {
            transform: translateY(-6px) !important;
            box-shadow: 0 12px 30px rgba(59,130,246,0.18) !important;
            border-color: #3B82F6 !important;
        }

        .quick-action-card:hover .quick-card-icon {
            background: rgba(59,130,246,0.2) !important;
            color: #2563eb !important;
        }

        .kpi-card {
            transition: all .25s ease;
        }

        .kpi-card:hover {
            transform: translateY(-6px) !important;
            box-shadow: 0 10px 25px rgba(59,130,246,0.15) !important;
        }

        .kpi-icon {
            transition: all .25s ease;
        }

        .kpi-card:hover .kpi-icon {
            background: rgba(59,130,246,0.2) !important;
            color: #2563eb !important;
        }

        .activity-card {
            border: 0;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(36, 30, 62, 0.06);
            padding: 1rem 1.1rem;
            height: 100%;
            text-align: right;
        }

        html[dir="ltr"] .activity-card {
            text-align: left;
        }

        .activity-title {
            color: #2f2b3a;
            font-weight: 700;
            margin-bottom: .65rem;
            text-align: right;
        }

        html[dir="ltr"] .activity-title {
            text-align: left;
        }

        .activity-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .5rem 0;
            border-bottom: 1px dashed #e9e8ef;
            color: #4e4a6d;
            font-size: .95rem;
            direction: rtl;
            text-align: right;
        }

        html[dir="ltr"] .activity-line {
            direction: ltr;
            text-align: left;
        }

        .activity-line:last-child {
            border-bottom: 0;
        }

        .activity-badge {
            min-width: 2rem;
            text-align: center;
            border-radius: 10px;
            padding: .1rem .45rem;
            background: #eef6f1;
            color: #16815a;
            font-weight: 700;
            margin-inline-start: .5rem;
        }
    </style>
@endsection

@section('content')
    @php
        $totalStudents = \App\Student::count();
        $totalTeachers = \App\Teacher::count();
        $totalClasses = \App\Classe::count();
        $todayAttendance = \App\Student_schedule_tracer::whereDate('created_at', \Carbon\Carbon::today())->distinct('user_id')->count('user_id');
        $pendingTasks = \App\Task::where('is_done', '!=', 1)
            ->where(function ($q) {
                $q->where('is_admin_send_approve', '0')->orWhere('is_admin_recv_approve', '0');
            })->count();

        $todayAdmissions = \App\Student_register::whereDate('created_at', \Carbon\Carbon::today())->count();
        $todayMessages = \App\Message::whereDate('created_at', \Carbon\Carbon::today())->count();

        $quickCards = [
            ['permission' => 'users_section', 'route' => 'users', 'icon' => 'fas fa-user-friends', 'title' => 'المستخدمين', 'desc' => 'إدارة حسابات النظام'],
            ['permission' => 'attendance_schedule_and_exams', 'route' => 'classes.view.exams', 'icon' => 'far fa-calendar-alt', 'title' => 'الاختبارات', 'desc' => 'إدارة اختبارات الصفوف'],
            ['permission' => 'workschedule', 'route' => 'workschedule_class', 'icon' => 'far fa-calendar-check', 'title' => 'برنامج الدوام', 'desc' => 'جدولة الحصص اليومية'],
            ['permission' => 'student_affairs_section', 'route' => 'students', 'icon' => 'fas fa-user-alt', 'title' => 'شؤون الطلاب', 'desc' => 'البيانات الأكاديمية والإدارية'],
            ['permission' => 'user_permissions', 'route' => 'admin.roles.index', 'icon' => 'far fa-id-badge', 'title' => 'صلاحيات المستخدم', 'desc' => 'الأدوار والصلاحيات'],
            ['permission' => 'lecture_time_section', 'route' => 'sessions', 'icon' => 'far fa-building', 'title' => 'الحصص', 'desc' => 'الجلسات والجدول الأسبوعي'],
            ['permission' => 'accepting_and_regstration_section', 'route' => 'studentadmission', 'icon' => 'far fa-edit', 'title' => 'التسجيل والقبول', 'desc' => 'طلبات التسجيل والمتابعة'],
            ['permission' => 'website_controll', 'route' => 'websitecontroller', 'icon' => 'fas fa-user-cog', 'title' => 'التحكم بالموقع', 'desc' => 'إدارة واجهة المدرسة'],
            ['permission' => 'classes_section', 'route' => 'classes', 'icon' => 'far fa-building', 'title' => 'الصفوف', 'desc' => 'المراحل والشعب الدراسية'],
            ['permission' => 'basic_stage', 'route' => 'basic_stage', 'icon' => 'fas fa-book-open', 'title' => 'المراحل', 'desc' => 'المراحل الأساسية'],
            ['permission' => 'teachers', 'route' => 'teachers', 'icon' => 'fas fa-chalkboard-teacher', 'title' => 'المدرسين', 'desc' => 'ملفات الكادر التدريسي'],
            ['permission' => 'message_student', 'route' => 'student_contact', 'icon' => 'fas fa-user-graduate', 'title' => 'التواصل مع الطلاب', 'desc' => 'رسائل واستفسارات'],
            ['permission' => 'backup', 'route' => 'backups', 'icon' => 'fas fa-archive', 'title' => 'النسخ الاحتياطي', 'desc' => 'نسخ واسترجاع البيانات'],
            ['permission' => 'term_section', 'route' => 'terms', 'icon' => 'fas fa-book-open', 'title' => 'الفصول الدراسية', 'desc' => 'إدارة التقويم الدراسي'],
            ['permission' => 'last_year_results', 'route' => 'classes.graduation', 'icon' => 'fas fa-graduation-cap', 'title' => 'توليد الجلاءات', 'desc' => 'ترفيع وترصيد النتائج'],
            ['permission' => 'student_payments_section', 'route' => 'students_financial', 'icon' => 'fa fa-money-bill-alt', 'title' => 'الأقساط المالية', 'desc' => 'مالية الطلاب'],
            ['permission' => 'student_payments_section', 'route' => 'students_financial_transport', 'icon' => 'fa fa-money-bill-alt', 'title' => 'أقساط المواصلات', 'desc' => 'مالية النقل المدرسي'],
            ['permission' => 'student_payments_section', 'route' => 'mainDepartments', 'icon' => 'fa fa-sitemap', 'title' => 'الأفرع الإدارية', 'desc' => 'هيكل الأفرع'],
            ['permission' => 'student_payments_section', 'route' => 'adminstrators', 'icon' => 'fa fa-users-cog', 'title' => 'مدراء الأفرع', 'desc' => 'إدارة المدراء'],
            ['permission' => 'student_payments_section', 'route' => 'transportations', 'icon' => 'fa fa-bus', 'title' => 'قسم المواصلات', 'desc' => 'النقل المدرسي'],
            ['permission' => 'student_payments_section', 'route' => 'bus_supervisor', 'icon' => 'fa fa-user-shield', 'title' => 'مشرفو الباصات', 'desc' => 'إدارة المشرفين'],
            ['permission' => 'student_payments_section', 'route' => 'bus_driver', 'icon' => 'fa fa-id-card', 'title' => 'سائقو الباصات', 'desc' => 'إدارة السائقين'],
            ['permission' => 'curriculum_section', 'route' => 'lessons2', 'icon' => 'fas fa-bars', 'title' => 'المناهج', 'desc' => 'إدارة المواد الدراسية'],
            ['permission' => 'communication_section', 'route' => 'chat_admin', 'icon' => 'fas fa-phone-volume', 'title' => 'التواصل مع المدرسين', 'desc' => 'مراسلة الكادر'],
            ['permission' => 'reports_and_statistics', 'route' => 'reports', 'icon' => 'far fa-file-alt', 'title' => 'التقارير', 'desc' => 'تقارير تشغيل وإحصاء'],
            ['permission' => null, 'route' => 'admin.gradebook.index', 'icon' => 'fas fa-book-reader', 'title' => 'دفتر العلامات (Beta)', 'desc' => 'نظام العلامات المطور'],
        ];
    @endphp

    <div class="container-fluid dashboard-modern">
        <div class="row kpi-grid mb-4">
            <div class="col-12 col-sm-6 col-lg-3 col-xl-2">
                @include('admin.components.kpi-card', ['label' => 'إجمالي الطلاب', 'value' => number_format($totalStudents), 'icon' => 'fas fa-user-graduate', 'tone' => 'violet'])
            </div>
            <div class="col-12 col-sm-6 col-lg-3 col-xl-2">
                @include('admin.components.kpi-card', ['label' => 'إجمالي المدرسين', 'value' => number_format($totalTeachers), 'icon' => 'fas fa-chalkboard-teacher', 'tone' => 'violet'])
            </div>
            <div class="col-12 col-sm-6 col-lg-3 col-xl-2">
                @include('admin.components.kpi-card', ['label' => 'إجمالي الصفوف', 'value' => number_format($totalClasses), 'icon' => 'fas fa-school', 'tone' => 'violet'])
            </div>
            <div class="col-12 col-sm-6 col-lg-3 col-xl-3">
                @include('admin.components.kpi-card', ['label' => 'حضور اليوم', 'value' => number_format($todayAttendance), 'icon' => 'fas fa-user-check', 'tone' => 'emerald'])
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                @include('admin.components.kpi-card', ['label' => 'المهام المعلقة', 'value' => number_format($pendingTasks), 'icon' => 'fas fa-tasks', 'tone' => 'emerald'])
            </div>
        </div>

        <div class="row quick-grid mb-4">
            @foreach ($quickCards as $card)
                @if ($card['permission'])
                    @can($card['permission'])
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            @include('admin.components.quick-card', $card)
                        </div>
                    @endcan
                @else
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        @include('admin.components.quick-card', $card)
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row">
            <div class="col-12 col-lg-6 mb-3">
                <div class="activity-card">
                    <div class="activity-title">نشاط اليوم</div>
                    <div class="activity-line">
                        <span>سجلات حضور الطلاب اليوم</span>
                        <span class="activity-badge">{{ number_format($todayAttendance) }}</span>
                    </div>
                    <div class="activity-line">
                        <span>طلبات تسجيل جديدة اليوم</span>
                        <span class="activity-badge">{{ number_format($todayAdmissions) }}</span>
                    </div>
                    <div class="activity-line">
                        <span>رسائل جديدة اليوم</span>
                        <span class="activity-badge">{{ number_format($todayMessages) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-3">
                <div class="activity-card">
                    <div class="activity-title">ملخص تشغيلي</div>
                    <div class="activity-line">
                        <span>الطلاب مقابل الصفوف</span>
                        <span class="activity-badge">{{ $totalClasses > 0 ? number_format($totalStudents / $totalClasses, 1) : 0 }}</span>
                    </div>
                    <div class="activity-line">
                        <span>الطلاب مقابل المدرسين</span>
                        <span class="activity-badge">{{ $totalTeachers > 0 ? number_format($totalStudents / $totalTeachers, 1) : 0 }}</span>
                    </div>
                    <div class="activity-line">
                        <span>نسبة الحضور من إجمالي الطلاب</span>
                        <span class="activity-badge">{{ $totalStudents > 0 ? number_format(($todayAttendance / $totalStudents) * 100, 1) . '%' : '0%' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
