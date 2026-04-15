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

    .teacher-schedule-v2 .teacher-timetable-wrap {
        width: 100%;
        overflow: visible;
    }

    .teacher-schedule-v2 .teacher-timetable {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .teacher-schedule-v2 .teacher-timetable th,
    .teacher-schedule-v2 .teacher-timetable td {
        border: 1px solid #d6edf1 !important;
        background: #fff;
        vertical-align: middle;
        padding: 0 !important;
    }

    .teacher-schedule-v2 .teacher-timetable thead th {
        color: #121826;
        font-size: 1rem;
        font-weight: 800;
        text-align: center !important;
        padding: 1rem .35rem !important;
        background: #fff;
    }

    .teacher-schedule-v2 .teacher-timetable__day-head {
        width: 104px;
        min-width: 104px;
        text-align: center !important;
        font-size: 1rem;
        font-weight: 800;
        color: #121826;
        background: #fff !important;
    }

    .teacher-schedule-v2 .teacher-timetable__slot-head {
        padding: .9rem .3rem !important;
        text-align: center !important;
        background: #fff !important;
    }

    .teacher-schedule-v2 .teacher-timetable__slot-name {
        display: block;
        font-size: 1rem;
        font-weight: 800;
        color: #121826;
        line-height: 1.45;
    }

    .teacher-schedule-v2 .teacher-timetable__slot-time {
        display: block;
        margin-top: .35rem;
        font-size: .8rem;
        color: #121826;
        line-height: 1.5;
    }

    .teacher-schedule-v2 .teacher-timetable__cell {
        height: 146px;
        padding: .5rem .35rem !important;
        text-align: center !important;
        background: #fff !important;
    }

    .teacher-schedule-v2 .teacher-timetable__lesson-box.btn,
    .teacher-schedule-v2 .teacher-timetable__empty {
        border-radius: 12px;
    }

    .teacher-schedule-v2 .teacher-timetable__lesson-box.btn,
    .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu1,
    .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu2,
    .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu6 {
        width: min(132px, calc(100% - 8px));
        min-height: 76px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .22rem;
        padding: .75rem .5rem;
        text-align: center;
        white-space: normal;
        overflow-wrap: anywhere;
        border: 0;
        box-shadow: none;
        background: linear-gradient(180deg, #5d7ef4, #4f6df5) !important;
        color: #fff !important;
    }

    .teacher-schedule-v2 .teacher-timetable__lesson-box p {
        margin: 0 !important;
        color: inherit !important;
        line-height: 1.35;
    }

    .teacher-schedule-v2 .teacher-timetable__lesson-title {
        font-size: .92rem;
        font-weight: 800;
    }

    .teacher-schedule-v2 .teacher-timetable__meta {
        font-size: .72rem;
        opacity: .96;
    }

    .teacher-schedule-v2 .teacher-timetable__empty {
        width: min(132px, calc(100% - 8px));
        min-height: 76px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: .5rem;
        color: #8c96ab;
        font-size: .78rem;
        font-weight: 700;
        text-align: center;
        background: transparent;
        border: 1px dashed rgba(140, 150, 171, 0.35);
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

        .teacher-schedule-v2 .teacher-timetable {
            font-size: .88rem;
        }

        .teacher-schedule-v2 .teacher-timetable thead th {
            font-size: .78rem;
            padding: .7rem .2rem !important;
        }

        .teacher-schedule-v2 .teacher-timetable__day-head {
            width: 86px;
            min-width: 86px;
            font-size: .82rem;
        }

        .teacher-schedule-v2 .teacher-timetable__slot-name {
            font-size: .8rem;
        }

        .teacher-schedule-v2 .teacher-timetable__slot-time,
        .teacher-schedule-v2 .teacher-timetable__meta {
            font-size: .64rem;
        }

        .teacher-schedule-v2 .teacher-timetable__cell {
            height: 118px;
            padding: .35rem .2rem !important;
        }

        .teacher-schedule-v2 .teacher-timetable__lesson-box.btn,
        .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu1,
        .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu2,
        .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu6,
        .teacher-schedule-v2 .teacher-timetable__empty {
            width: min(104px, calc(100% - 4px));
            min-height: 64px;
        }

        .teacher-schedule-v2 .teacher-timetable__lesson-box.btn,
        .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu1,
        .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu2,
        .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu6 {
            padding: .55rem .3rem;
        }

        .teacher-schedule-v2 .teacher-timetable__lesson-title {
            font-size: .74rem;
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

    @php
        $scheduleLookup = [];
        foreach ($schedule as $scheduleItem) {
            $scheduleLookup[$scheduleItem->lecture_time_id][$scheduleItem->day_id] = $scheduleItem;
        }
    @endphp

    <div class="card v2-card teacher-schedule-card">
        <div class="card-body">
            <div id="schedule-capture" class="teacher-timetable-wrap">
                @php
                    $primaryRoomId = $schedule
                        ->groupBy('room_id')
                        ->sortByDesc(function ($roomSchedule) {
                            return $roomSchedule->count();
                        })
                        ->keys()
                        ->first();

                    $instructionLectureTimes = $lecture_times
                        ->when($primaryRoomId, function ($collection) use ($primaryRoomId) {
                            return $collection->where('room_id', $primaryRoomId);
                        })
                        ->where('type', 1)
                        ->sortBy(function ($lectureTime) {
                            return sprintf('%s|%s|%06d', $lectureTime->start_time, $lectureTime->end_time, $lectureTime->id);
                        })
                        ->values();

                    $lessonLabels = [
                        'الحصة الأولى',
                        'الحصة الثانية',
                        'الحصة الثالثة',
                        'الحصة الرابعة',
                        'الحصة الخامسة',
                        'الحصة السادسة',
                        'الحصة السابعة',
                    ];
                @endphp
                <table class="table teacher-timetable" style="direction: rtl !important; text-align: center !important;">
                    <thead>
                        <tr>
                            <th scope="col" class="teacher-timetable__day-head">اليوم</th>
                            @foreach($instructionLectureTimes as $index => $lecture_time)
                                <th scope="col" class="teacher-timetable__slot-head">
                                    <span class="teacher-timetable__slot-name">{{ $lessonLabels[$index] ?? $lecture_time->name }}</span>
                                    <span class="teacher-timetable__slot-time">{{ $lecture_time->start_time." - ".$lecture_time->end_time }}</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($days->take(7) as $day)
                            <tr>
                                <th scope="row" class="teacher-timetable__day-head">{{ $day->name }}</th>
                                @foreach($instructionLectureTimes as $lecture_time)
                                    @php
                                        $lesson_time = $scheduleLookup[$lecture_time->id][$day->id] ?? null;
                                    @endphp
                                    <td class="teacher-timetable__cell">
                                        @if($lesson_time)
                                            @php
                                                $background = '';
                                                if($today == $day->id - 1 && $lesson_time->attendance == false) $background = 'btn-success';
                                                else if($today == $day->id - 1 && $lesson_time->attendance == true) $background = 'btn-danger';
                                                else $background = 'btn-info';
                                            @endphp
                                            <a class="btn {{ $background }} btn-sm add_time teacher-timetable__lesson-box" title="الدخول إلى الحصة">
                                                <p class="lesson_name-schedule{{  $day->id .''. $lecture_time->id }} teacher-timetable__lesson-title">{{ $lesson_time->lesson->name }}</p>
                                                <p class="teacher_name-schedule{{  $day->id .''. $lecture_time->id }} teacher-timetable__meta">{{ $lesson_time->room->classes->name." / ".$lesson_time->room->name }}</p>
                                                <p class="teacher-timetable__meta">{{ $lesson_time->lecture_time->start_time." - ".$lesson_time->lecture_time->end_time }}</p>
                                            </a>
                                        @else
                                            <div class="teacher-timetable__empty">لا يوجد حصة</div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
