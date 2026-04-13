@extends('admin.layouts.v2')

@section('page_title', 'جدول المدرس')
@section('page_subtitle', 'عرض برنامج الدوام والحصص الأسبوعية')

@section('style')
<style>
    .v2-shell .v2-sidebar .v2-menu-title,
    .v2-shell .v2-sidebar .v2-menu-link,
    .v2-shell .v2-sidebar .v2-menu-link span,
    .v2-shell .v2-sidebar .v2-sub-link,
    .v2-shell .v2-sidebar .v2-sidebar-brand div,
    .v2-shell .v2-navbar .v2-navbar-brand-ar,
    .v2-shell .v2-navbar .v2-navbar-brand-en,
    .v2-shell .v2-navbar .v2-navbar-page span,
    .v2-shell .v2-navbar .v2-user-btn,
    .v2-shell .v2-navbar .v2-user-name,
    .v2-shell .v2-navbar .dropdown-item,
    .v2-shell .v2-navbar .v2-nav-icon-btn,
    .v2-shell .v2-navbar .v2-dropdown-item {
        color: inherit !important;
    }

    .v2-content-wrap > .v2-card .breadcrumbs__item,
    .v2-content-wrap > .v2-card .breadcrumbs__item.is-active {
        color: #2f2b3a !important;
    }

    .v2-content-wrap > .v2-card:first-of-type {
        margin-bottom: 1.5rem !important;
    }

    .v2-content-wrap > .v2-card:first-of-type > div {
        padding: 1rem 1.25rem !important;
        gap: 1rem;
        align-items: flex-start !important;
    }

    .v2-content-wrap > .v2-card:first-of-type .breadcrumbs {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: .45rem;
    }

    .teacher-schedule-breadcrumbs {
        font-size: .9rem;
        align-items: center;
        gap: .35rem;
    }

    .teacher-schedule-breadcrumbs .breadcrumbs__item {
        font-weight: 700;
    }

    .teacher-schedule-breadcrumbs a.breadcrumbs__item {
        color: #8a869a !important;
    }

    .teacher-schedule-breadcrumbs .breadcrumbs__item.is-active {
        color: #2f2b3a !important;
    }

    .teacher-schedule-breadcrumbs__sep {
        color: #b2aec0;
        font-weight: 700;
    }

    .v2-navbar #v2-sidebar-toggle {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
    }

    .teacher-schedule-v2 {
        direction: rtl;
        text-align: right;
    }

    html[dir="ltr"] .teacher-schedule-v2 {
        direction: ltr;
        text-align: left;
    }

    .teacher-schedule-shell {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .teacher-schedule-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1.5rem;
        border-radius: 22px;
        background: linear-gradient(135deg, #5B4B8A, #7B67B2);
        color: #fff;
        box-shadow: 0 18px 40px rgba(36, 30, 62, 0.10);
    }

    .teacher-schedule-summary__eyebrow {
        display: inline-block;
        font-size: .82rem;
        font-weight: 700;
        opacity: .76;
        margin-bottom: .45rem;
    }

    .teacher-schedule-summary__title {
        margin: 0;
        font-size: 1.7rem;
        font-weight: 800;
        color: #fff;
    }

    .teacher-schedule-summary__subtitle {
        margin: .45rem 0 0;
        color: rgba(255,255,255,.84);
        max-width: 42rem;
        line-height: 1.7;
    }

    .teacher-schedule-summary__actions {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .teacher-schedule-summary__actions .btn {
        min-height: 44px;
        border-radius: 12px;
        font-weight: 700;
        padding: .72rem 1.15rem;
        color: #fff !important;
    }

    .teacher-schedule-card {
        border-radius: 22px;
        border: 1px solid rgba(91, 75, 138, 0.12);
        box-shadow: 0 18px 40px rgba(36, 30, 62, 0.08);
        overflow: hidden;
    }

    .teacher-schedule-card .card-body {
        padding: 1.25rem;
        background: #fff;
    }

    .teacher-schedule-v2 .table-responsive {
        overflow: auto !important;
        border-radius: 18px;
        border: 1px solid rgba(91, 75, 138, 0.12);
        background: #fff;
    }

    .teacher-schedule-v2 #table-container {
        width: 100% !important;
    }

    .teacher-schedule-v2 #simple_table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }

    .teacher-schedule-v2 #simple_table th {
        background: #f7f5fc;
        color: #2f2b3a;
        font-size: 1rem;
        font-weight: 800;
        padding: 1rem .75rem !important;
        border-color: rgba(91, 75, 138, 0.12) !important;
        text-align: center !important;
        white-space: nowrap;
    }

    .teacher-schedule-v2 #simple_table td {
        padding: 1rem .75rem !important;
        border-color: rgba(91, 75, 138, 0.1) !important;
        vertical-align: middle;
        text-align: center;
        min-width: 220px;
    }

    .teacher-schedule-v2 #simple_table .btn {
        min-width: 190px;
        border-radius: 16px;
        padding: .9rem 1rem;
        white-space: normal;
        box-shadow: none;
    }

    .teacher-schedule-v2 #simple_table p {
        color: inherit;
    }

    .teacher-schedule-v2 .uuu1,
    .teacher-schedule-v2 .uuu2,
    .teacher-schedule-v2 .uuu3,
    .teacher-schedule-v2 .uuu4,
    .teacher-schedule-v2 .uuu5,
    .teacher-schedule-v2 .uuu6,
    .teacher-schedule-v2 .uuu7 {
        color: #2f2b3a !important;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-sidebar {
        width: 88px;
    }

    html[dir="ltr"] #v2-shell.teacher-sidebar-collapsed .v2-main {
        margin-left: 88px;
    }

    html[dir="rtl"] #v2-shell.teacher-sidebar-collapsed .v2-main {
        margin-right: 88px;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-sidebar-brand {
        justify-content: center !important;
        padding-inline: .75rem;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-sidebar-brand .d-flex.align-items-center > div:last-child,
    #v2-shell.teacher-sidebar-collapsed .v2-menu-title,
    #v2-shell.teacher-sidebar-collapsed .v2-menu-link span,
    #v2-shell.teacher-sidebar-collapsed .v2-submenu,
    #v2-shell.teacher-sidebar-collapsed .v2-menu-toggle .fa-chevron-down {
        display: none !important;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-sidebar-menu {
        padding-inline: .4rem;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-menu-link {
        justify-content: center;
        padding-inline: .5rem;
        min-height: 48px;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-menu-link i:first-child {
        margin-inline: 0;
    }

    #v2-shell.teacher-sidebar-collapsed .v2-menu-link.active {
        border-inline-start: 0;
        box-shadow: inset 0 0 0 1px rgba(59,130,246,0.15);
    }

    @media (max-width: 991.98px) {
        .teacher-schedule-summary {
            padding: 1.1rem;
        }

        .teacher-schedule-summary__title {
            font-size: 1.35rem;
        }

        .teacher-schedule-summary__actions {
            width: 100%;
        }

        .teacher-schedule-summary__actions .btn {
            width: 100%;
        }

        .teacher-schedule-card .card-body {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs teacher-schedule-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">لوحة التحكم</a>
    <span class="teacher-schedule-breadcrumbs__sep" aria-hidden="true">/</span>
    <a href="{{ route('teachers') }}" class="breadcrumbs__item">المدرسين</a>
    <span class="teacher-schedule-breadcrumbs__sep" aria-hidden="true">/</span>
    <span class="breadcrumbs__item is-active">جدول المدرس</span>
</nav>
@endsection

@section('content')
<div class="teacher-schedule-v2">
  <!-- start new-->
  @if (session()->has('success'))

    <script>
        window.onload = function() {
            notif({
                msg: "  تم التخزين بنجاح  ",
                type: "success"
            })
        }

    </script>
@endif
    @if (session()->has('otherday'))

    <script>
        window.onload = function() {
            notif({
                msg: " {{ session()->get('otherday') }} ",
                type: "warning"
            })
        }

    </script>
@endif

<div class="teacher-schedule-shell">
    <div class="teacher-schedule-summary">
        <div>
            <span class="teacher-schedule-summary__eyebrow">الجدول الأسبوعي</span>
            <h2 class="teacher-schedule-summary__title">برنامج المدرس {{ $teacher->first_name }} {{ $teacher->last_name }}</h2>
            <p class="teacher-schedule-summary__subtitle">استعراض برنامج الدوام والحصص الأسبوعية بشكل واضح ومنظم مع إمكانية تنزيل الجدول مباشرة.</p>
        </div>
        <div class="teacher-schedule-summary__actions">
            <input type="button" id="button" class="btn btn-success" value="تنزيل الجدول">
        </div>
    </div>

    <div class="card v2-card teacher-schedule-card">
        <div class="card-body">
            <div class="table-responsive">
                <div id="table-container" style="width: 100%">
                    <table class="table table-bordered" id="simple_table" style="direction: rtl !important; text-align: center !important;">
            @if($schedule->count() > 0)
            
            <tbody>
                <?php $i = 1; ?>
                @foreach($days as $key => $day)
                <tr>
                    <th scope="row">{{ $day->name }}</th>
                    @foreach($schedule as $key3 => $lesson_time)
                    @if($day->id == $lesson_time->day_id)
                    @php
                    $background = '';
                    if($today == $day->id - 1 && $lesson_time->attendance == false) $background = 'btn-success';
                    else if($today == $day->id - 1 && $lesson_time->attendance == true) $background = 'btn-danger';
                    else $background = 'btn-info';
                    @endphp
                    <td>
                        <a class="btn {{ $background }} btn-sm add_time" title="الدخول إلى الحصة">
                            <p class="lesson_name-schedule{{  $day->id .''. $lesson_time->lecture_time->id }}" style="margin:0;font-weight:bold"> {{ $lesson_time->lesson->name }}</p>
                            <p class="teacher_name-schedule{{  $day->id .''. $lesson_time->lecture_time->id }}" style="margin:0;font-size:14px"> {{ $lesson_time->room->classes->name." / ".$lesson_time->room->name }} </p>
                            <p style="margin:0;font-size:14px"> {{ $lesson_time->lecture_time->start_time." - ".$lesson_time->lecture_time->end_time }} </p>
                            <p style="margin:0;font-size:14px"> {{ $lesson_time->lecture_time->name }} </p>
                        </a>
                    </td>
                    @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
            @else
            <tbody>
                <?php $i = 1; ?>
                @foreach($days as $key => $day)
                <tr>
                    <th scope="row">{{ $day->name }}</th>
                    <td style="color: gray; font-size: smaller;">
                        لايوجد حصص
                    </td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('js')
<script>
(function() {
    var shell = document.getElementById('v2-shell');
    var toggle = document.getElementById('v2-sidebar-toggle');
    if (!shell || !toggle) return;

    toggle.classList.remove('d-lg-none');

    var media = window.matchMedia('(min-width: 993px)');
    var storageKey = 'teachersSidebarCollapsed';

    function syncSidebarState() {
        if (media.matches) {
            if (window.localStorage.getItem(storageKey) === '1') {
                shell.classList.add('teacher-sidebar-collapsed');
            } else {
                shell.classList.remove('teacher-sidebar-collapsed');
            }
            shell.classList.remove('sidebar-open');
        } else {
            shell.classList.remove('teacher-sidebar-collapsed');
        }
    }

    toggle.addEventListener('click', function(e) {
        if (!media.matches) return;
        e.preventDefault();
        e.stopImmediatePropagation();
        shell.classList.toggle('teacher-sidebar-collapsed');
        window.localStorage.setItem(storageKey, shell.classList.contains('teacher-sidebar-collapsed') ? '1' : '0');
    }, true);

    if (media.addEventListener) {
        media.addEventListener('change', syncSidebarState);
    } else if (media.addListener) {
        media.addListener(syncSidebarState);
    }

    syncSidebarState();
})();
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script>
    $(document).on("click","#button",function () {
        $('.btn-info').removeClass('btn-info').addClass('uuu1');
        $('.btn-success').removeClass('btn-success').addClass('uuu2');
        $('.btn-primary').removeClass('btn-primary').addClass('uuu3');
        $('.btn-primary2').removeClass('btn-primary2').addClass('uuu4');
        $('.btn-primary3').removeClass('btn-primary3').addClass('uuu5');
        $('.btn-danger').removeClass('btn-danger').addClass('uuu6');

        var tableContainer = document.querySelector("#simple_table");
        var tableWidth = tableContainer.scrollWidth;
        var tableHeight = tableContainer.offsetHeight;
        var windowWidth = window.innerWidth;
        var windowHeight = window.innerHeight;

        html2canvas(tableContainer, {
            allowTaint: true,
            logging: true,
            taintTest: false,
            scrollX: -window.scrollX, // Capture the entire table horizontally
            scrollY: -window.scrollY, // Capture the entire table vertically
            windowWidth: tableWidth > windowWidth ? windowWidth : tableWidth, // Set window width if table is wider
            windowHeight: tableHeight > windowHeight ? windowHeight : tableHeight // Set window height if table is taller
        }).then(canvas => {
            a = document.createElement('a');
            document.body.appendChild(a);
            a.download = "{{ $teacher->first_name }}" + " {{ $teacher->last_name }}" + ".png";
            a.href =  canvas.toDataURL();
            a.click();
        });

        $('.uuu1').removeClass('uuu1').addClass('btn-info');
        $('.uuu2').removeClass('uuu2').addClass('btn-success');
        $('.uuu3').removeClass('uuu3').addClass('btn-primary');
        $('.uuu4').removeClass('uuu4').addClass('btn-primary2');
        $('.uuu5').removeClass('uuu5').addClass('btn-primary3');
        $('.uuu6').removeClass('uuu6').addClass('btn-danger');

    });
</script>

    @endsection
