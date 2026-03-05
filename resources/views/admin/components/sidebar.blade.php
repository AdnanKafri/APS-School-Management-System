@php
    $current = optional(request()->route())->getName();
    $school = \App\School_data::first();
    $brandLogo = asset('assets/images/school/adham_black.png');
    $brandNameAr = optional($school)->name ?: 'مدرسة الادهم الخاصة';
    $brandNameEn = optional($school)->name_en ?: 'Aladham Private School';
@endphp

<aside class="v2-sidebar">
    <div class="v2-sidebar-brand d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div style="width:48px;height:48px;border-radius:12px;background:#f4f3f8;display:flex;align-items:center;justify-content:center;overflow:hidden;flex:0 0 auto;">
                <img src="{{ $brandLogo }}" alt="{{ $brandNameEn }}" style="max-height:46px;max-width:46px;object-fit:contain;">
            </div>
            <div style="padding-inline-start:.65rem;line-height:1.25;">
                <div style="font-weight:800;color:#2f2b3a;">{{ $brandNameAr }}</div>
                <small style="color:#8a869a;font-size:.73rem;">{{ $brandNameEn }}</small>
            </div>
        </div>
        <button id="v2-sidebar-close" class="btn btn-link p-0 d-lg-none" style="color:#6a6680;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="v2-sidebar-menu">
        <div class="v2-menu-group">
            <a href="{{ route('dashboard.index') }}" class="v2-menu-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>لوحة التحكم</span>
            </a>
        </div>

        <div class="v2-menu-title">الإدارة الأكاديمية</div>
        <div class="v2-menu-group">
            @can('student_affairs_section')
                <a href="{{ route('students') }}" class="v2-menu-link {{ request()->routeIs('students*','student_*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>الطلاب</span>
                </a>
            @endcan
            @can('teachers')
                <a href="{{ route('teachers') }}" class="v2-menu-link {{ request()->routeIs('teachers*','teacher_*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>المدرسين</span>
                </a>
            @endcan
            @can('classes_section')
                <a href="{{ route('classes') }}" class="v2-menu-link {{ request()->routeIs('classes*','class_*','classroom*','rooms*') ? 'active' : '' }}">
                    <i class="fas fa-school"></i>
                    <span>الصفوف والشعب</span>
                </a>
            @endcan
            @can('curriculum_section')
                <a href="{{ route('lessons2') }}" class="v2-menu-link {{ request()->routeIs('lessons*') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i>
                    <span>المناهج</span>
                </a>
            @endcan
            @can('attendance_schedule_and_exams')
                <a href="{{ route('classes.view.exams') }}" class="v2-menu-link {{ request()->routeIs('classes.view.exams','classroom_exams','room_exams','exam.*') ? 'active' : '' }}">
                    <i class="far fa-calendar-alt"></i>
                    <span>الاختبارات</span>
                </a>
            @endcan
            @can('lecture_time_section')
                <a href="{{ route('sessions') }}" class="v2-menu-link {{ request()->routeIs('sessions*','session_*','allsession_delete') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i>
                    <span>الحصص</span>
                </a>
            @endcan
        </div>

        <div class="v2-menu-title">الإعدادات والإدارة</div>
        <div class="v2-menu-group">
            @can('user_permissions')
                <button class="v2-menu-link v2-menu-toggle {{ request()->routeIs('admin.roles.*','users*','roles*') ? 'active' : '' }}" type="button" data-toggle="collapse" data-target="#v2-users-menu" aria-expanded="{{ request()->routeIs('admin.roles.*','users*','roles*') ? 'true' : 'false' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>المستخدمون والصلاحيات</span>
                    <i class="fas fa-chevron-down" style="font-size:.72rem;"></i>
                </button>
                <div id="v2-users-menu" class="collapse v2-submenu {{ request()->routeIs('admin.roles.*','users*','roles*') ? 'show' : '' }}">
                    <a href="{{ route('users') }}" class="v2-sub-link {{ request()->routeIs('users*','user*') ? 'active' : '' }}">حسابات المستخدمين</a>
                    <a href="{{ route('admin.roles.index') }}" class="v2-sub-link {{ request()->routeIs('admin.roles.*','roles*') ? 'active' : '' }}">الأدوار والصلاحيات</a>
                </div>
            @endcan

            @can('student_payments_section')
                <button class="v2-menu-link v2-menu-toggle {{ request()->routeIs('students_financial*','students_financial_transport*','transport*','bus_*') ? 'active' : '' }}" type="button" data-toggle="collapse" data-target="#v2-finance-menu" aria-expanded="{{ request()->routeIs('students_financial*','students_financial_transport*','transport*','bus_*') ? 'true' : 'false' }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>المالية والمواصلات</span>
                    <i class="fas fa-chevron-down" style="font-size:.72rem;"></i>
                </button>
                <div id="v2-finance-menu" class="collapse v2-submenu {{ request()->routeIs('students_financial*','students_financial_transport*','transport*','bus_*') ? 'show' : '' }}">
                    <a href="{{ route('students_financial') }}" class="v2-sub-link {{ request()->routeIs('students_financial*') ? 'active' : '' }}">أقساط الطلاب</a>
                    <a href="{{ route('students_financial_transport') }}" class="v2-sub-link {{ request()->routeIs('students_financial_transport*') ? 'active' : '' }}">أقساط المواصلات</a>
                    <a href="{{ route('transportations') }}" class="v2-sub-link {{ request()->routeIs('transportations*') ? 'active' : '' }}">قسم المواصلات</a>
                </div>
            @endcan

            @can('backup')
                <a href="{{ route('backups') }}" class="v2-menu-link {{ request()->routeIs('backups*') ? 'active' : '' }}">
                    <i class="fas fa-database"></i>
                    <span>النسخ الاحتياطي</span>
                </a>
            @endcan
            @can('reports_and_statistics')
                <a href="{{ route('reports') }}" class="v2-menu-link {{ request()->routeIs('reports*','report_*') ? 'active' : '' }}">
                    <i class="far fa-file-alt"></i>
                    <span>التقارير</span>
                </a>
            @endcan
            <a href="{{ route('admin.gradebook.index') }}" class="v2-menu-link {{ request()->routeIs('admin.gradebook.*') ? 'active' : '' }}">
                <i class="fas fa-book-reader"></i>
                <span>دفتر العلامات (Beta)</span>
            </a>
        </div>
    </div>
</aside>
