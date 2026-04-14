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

    .teacher-schedule-v2 .teacher-schedule-card {
        overflow: visible;
    }

    .teacher-schedule-v2 .teacher-schedule-card .card-body {
        padding: 1.25rem;
        overflow: visible;
    }

    .teacher-schedule-v2 #schedule-capture {
        width: 100%;
    }

    .teacher-schedule-v2 .teacher-schedule-days {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }

    .teacher-schedule-v2 .teacher-day-card {
        display: flex;
        flex-direction: column;
        gap: .9rem;
        min-width: 0;
        border-radius: 18px;
        border: 1px solid rgba(91, 75, 138, 0.12);
        background: linear-gradient(180deg, rgba(91, 75, 138, 0.05), rgba(91, 75, 138, 0.01));
        padding: 1rem;
        box-shadow: 0 12px 28px rgba(36, 30, 62, 0.06);
    }

    .teacher-schedule-v2 .teacher-day-card__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        padding-bottom: .75rem;
        border-bottom: 1px solid rgba(91, 75, 138, 0.12);
    }

    .teacher-schedule-v2 .teacher-day-card__title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .teacher-schedule-v2 .teacher-day-card__count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        border-radius: 999px;
        background: rgba(91, 75, 138, 0.12);
        color: #5B4B8A;
        font-size: .82rem;
        font-weight: 800;
        padding-inline: .7rem;
    }

    .teacher-schedule-v2 .teacher-day-card__slots {
        display: grid;
        gap: .75rem;
    }

    .teacher-schedule-v2 .teacher-day-card__slot {
        width: 100%;
    }

    .teacher-schedule-v2 .teacher-day-card__slot .btn {
        width: 100%;
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: .2rem;
        border-radius: 16px;
        padding: .9rem 1rem;
        white-space: normal;
        text-align: right;
        box-shadow: none;
    }

    html[dir="ltr"] .teacher-schedule-v2 .teacher-day-card__slot .btn {
        align-items: flex-start;
        text-align: left;
    }

    .teacher-schedule-v2 .teacher-day-card__slot p {
        margin: 0 !important;
        color: inherit;
    }

    .teacher-schedule-v2 .teacher-day-card__empty {
        min-height: 108px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        border: 1px dashed rgba(91, 75, 138, 0.18);
        background: rgba(91, 75, 138, 0.04);
        color: #7b768f;
        font-weight: 700;
        text-align: center;
        padding: 1rem;
    }

    .teacher-schedule-v2 .teacher-day-card__meta {
        font-size: .84rem;
        opacity: .92;
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
            <div id="schedule-capture" class="teacher-schedule-days">
                @foreach($days as $key => $day)
                    @php
                        $dayLessons = $schedule->where('day_id', $day->id);
                    @endphp
                    <section class="teacher-day-card">
                        <div class="teacher-day-card__header">
                            <h3 class="teacher-day-card__title">{{ $day->name }}</h3>
                            <span class="teacher-day-card__count">{{ $dayLessons->count() }}</span>
                        </div>

                        <div class="teacher-day-card__slots">
                            @forelse($dayLessons as $lesson_time)
                                @php
                                    $background = '';
                                    if($today == $day->id - 1 && $lesson_time->attendance == false) $background = 'btn-success';
                                    else if($today == $day->id - 1 && $lesson_time->attendance == true) $background = 'btn-danger';
                                    else $background = 'btn-info';
                                @endphp
                                <div class="teacher-day-card__slot">
                                    <a class="btn {{ $background }} btn-sm add_time" title="الدخول إلى الحصة">
                                        <p class="lesson_name-schedule{{  $day->id .''. $lesson_time->lecture_time->id }}" style="font-weight:bold">{{ $lesson_time->lesson->name }}</p>
                                        <p class="teacher_name-schedule{{  $day->id .''. $lesson_time->lecture_time->id }} teacher-day-card__meta">{{ $lesson_time->room->classes->name." / ".$lesson_time->room->name }}</p>
                                        <p class="teacher-day-card__meta">{{ $lesson_time->lecture_time->start_time." - ".$lesson_time->lecture_time->end_time }}</p>
                                        <p class="teacher-day-card__meta">{{ $lesson_time->lecture_time->name }}</p>
                                    </a>
                                </div>
                            @empty
                                <div class="teacher-day-card__empty">لايوجد حصص</div>
                            @endforelse
                        </div>
                    </section>
                @endforeach
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

        var tableContainer = document.querySelector("#schedule-capture");
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
