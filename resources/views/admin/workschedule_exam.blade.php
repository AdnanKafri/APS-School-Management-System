@extends('admin.layouts.v2')

@section('page_title', 'برنامج الدوام')
@section('page_subtitle', 'عرض برنامج الدوام الأسبوعي للشعبة بنفس بنية البرنامج الأسبوعي')

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
        width: 8%;
        min-width: 68px;
        max-width: 110px;
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
        height: 140px;
        padding: .4rem .25rem !important;
        text-align: center !important;
        background: #fff !important;
        vertical-align: middle;
    }

    .teacher-schedule-v2 .teacher-timetable__lesson-box.btn,
    .teacher-schedule-v2 .teacher-timetable__empty {
        border-radius: 12px;
    }

    .teacher-schedule-v2 .teacher-timetable__lesson-box.btn,
    .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu1,
    .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu2,
    .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu6 {
        width: calc(100% - 8px);
        height: 100px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: .22rem;
        padding: .65rem .5rem;
        text-align: center;
        white-space: normal;
        overflow-wrap: anywhere;
        overflow: hidden;
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
        width: calc(100% - 8px);
        height: 100px;
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
        border-radius: 12px;
    }

    .teacher-schedule-v2 .teacher-timetable__aux-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #f59e0b;
        color: #fff !important;
        box-shadow: 0 10px 22px rgba(245, 158, 11, 0.22);
    }

    .teacher-schedule-v2 .teacher-timetable__aux-action i {
        font-size: 0.8rem;
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
            width: 8%;
            min-width: 56px;
            max-width: 90px;
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
            height: 114px;
            padding: .3rem .2rem !important;
        }

        .teacher-schedule-v2 .teacher-timetable__lesson-box.btn,
        .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu1,
        .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu2,
        .teacher-schedule-v2 .teacher-timetable__lesson-box.uuu6,
        .teacher-schedule-v2 .teacher-timetable__empty {
            width: calc(100% - 4px);
            height: 78px;
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

    /* ── Table responsive wrapper ── */
    .teacher-schedule-v2 .teacher-timetable-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 575.98px) {
        .teacher-schedule-v2 .teacher-timetable {
            min-width: 560px;
        }
    }

    /* ── Modal polish ── */
    .modal .modal-content {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,.18);
    }

    .modal .modal-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
        align-items: center;
    }

    .modal .modal-header .modal-title {
        font-size: 1.05rem;
        font-weight: 700;
    }

    .modal .modal-body {
        padding: 1.5rem;
    }

    .modal .form-group {
        margin-bottom: 1rem;
    }

    .modal .form-group label {
        font-weight: 600;
        color: #3a3550;
    }

    .modal .form-group.row label.col-form-label {
        display: flex;
        align-items: center;
        font-weight: 600;
    }

    .modal .form-control {
        border-radius: 8px;
        border-color: #d0d5dd;
        padding: .45rem .75rem;
        font-size: .95rem;
    }

    .modal .form-control:focus {
        border-color: #5d7ef4;
        box-shadow: 0 0 0 3px rgba(93,126,244,.15);
    }

    .modal .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e9ecef;
        gap: .6rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
    }

    .modal .modal-footer .btn {
        min-height: 40px;
        min-width: 110px;
        font-weight: 600;
        border-radius: 10px;
        padding: .45rem 1.1rem;
    }

    /* ── form-group modal-footer (inline footer inside body) ── */
    .modal .form-group.modal-footer {
        margin-top: 1.25rem;
        justify-content: center !important;
        gap: .75rem;
        border-top: 1px solid #e9ecef;
    }

    .modal .form-group.modal-footer .btn {
        min-width: 130px;
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs teacher-schedule-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">لوحة التحكم</a>
    <span class="teacher-schedule-breadcrumbs__sep" aria-hidden="true">/</span>
    <a href="{{ route('workschedule_class') }}" class="breadcrumbs__item">برنامج الدوام</a>
    <span class="teacher-schedule-breadcrumbs__sep" aria-hidden="true">/</span>
    <a href="{{ route('workschedule_room',$room->class_id) }}" class="breadcrumbs__item">الشعب</a>
    <span class="teacher-schedule-breadcrumbs__sep" aria-hidden="true">/</span>
    <span class="breadcrumbs__item is-active">البرنامج الأسبوعي</span>
</nav>
@endsection

@section('content')

	{{-- <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('student-UI/img/school_bulding.jpg') }}'); border-bottom-right-radius: 70px 50px;">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text align-items-end justify-content-center">
				<div class="col-md-12 ftco-animate pb-5 text-right">
					<h1 class="mb-0 bread">  <span> {{ $room_name  }} </span> / {{ $class_name }} </h1>
				</div>
			</div>
		</div>
	</section> --}}
  <!-- start new-->
     <div class="modal fade" id="store_session">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form id="form_update" method="POST" action="{{ route('session_store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="class_id" id="class_id">
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة حصة</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>اسم الحصة</label>
                                    <input type="text" name="session_name" class="form-control" value="" style="direction: rtl"  maxlength="20" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>بداية الحصة</label>
                                    <input type="time" name="start_time"  class="form-control" value="" style="direction: rtl" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>نهاية الحصة</label>
                                    <input type="time" name="end_time"  class="form-control" value="" style="direction: rtl" required>
                                </div>


                                <div class="form-group" style="text-align:right" hidden>
                                    <label>الصفوف</label>
                                    <select name="class[]" class="w-100 js-example-basic-multiple"  multiple="multiple">
                                            <option value="{{ $room->class_id }}" selected ></option>
                                    </select>
                                </div>


                                <div class="form-group" style="text-align:right">
                                    <label>النوع</label>
                                    <select name="type" style="direction: rtl" class="form-control" required>
                                        <option value="1">حصة درسية</option>
                                        <option value="2">استراحة</option>
                                    </select>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label>  الشعب</label>
                                    <select name="room[]" style="direction: rtl" class="form-control" >

                                            <option value="{{ $room->id }}" selected>{{ $room->name }}</option>

                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer" style="justify-content: right;">
                                <a class="btn btn-default" data-dismiss="modal" style="color: black !important;">الغاء</a>
                                <button class="btn btn-primary">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<div class="col-12 teacher-schedule-v2" style="direction: rtl; text-align:center">
    <div class="modal fade" id="add_schedule1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="direction: rtl; text-align:right">
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalLongTitle">  إضافة رابط غوغل   </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: inline-block;margin: 0px;padding: 0px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form  action="{{ route('admin.google_meet_add') }}" method="post" class="w-100">
                    @csrf
                    <input type="hidden" name="room_id" id="room_id" value=" {{ $room_id }}" class="room_id">
                    <input type="hidden" name="lesson_time_id" id="lesson_time_id"  class="lesson_time_id">
                    <input type="hidden" name="time_id" id="time_id" class="time_id">
                    <input type="hidden" name="lesson_id" id="lesson_id" class="lesson_id">


                    <div class="form-group row">
                        <label for="courseCost" class="col-sm-2 col-form-label"> اليوم : </label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control day">
                            <input type="hidden" name="day_id"  class="form-control day_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="courseCost" class="col-sm-2 col-form-label"> الحصة : </label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control time_name">
                            <input type="hidden" name="time_id"  class="form-control time_id">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="courseCost" class="col-sm-2 col-form-label"> المادة : </label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control lesson">
                            <input type="hidden" name="lesson_id"  class="form-control lesson_id">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="courseCost" class="col-sm-2 col-form-label"> الرابط : </label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control meeting_link" name="meeting_link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="courseCost" class="col-sm-2 col-form-label">  تحديد الرابط لجميع الحصص</label>
                        <div class="col-sm-10">
                            <input type="checkbox"  class=" " name="all">
                        </div>
                    </div>

                    <div class="form-group modal-footer row justify-content-around px-3">
                          <button class="btn btn-success " type="submit" style="width: 35%">تأكيد </button>
                        <button  class="btn btn-light btn-info" data-dismiss="modal" style="width: 35%">خروج</button>
                    </div>

                    <!-- end submit-->


                </form>
                </div>
            </div>
        </div>
    </div>

    

    <div class="teacher-schedule-shell">
        <div class="teacher-schedule-summary">
            <div>
                <span class="teacher-schedule-summary__eyebrow">الجدول الأسبوعي</span>
                <h2 class="teacher-schedule-summary__title">برنامج الدوام للصف {{ $class_name }} / {{ $room_name }}</h2>
                <p class="teacher-schedule-summary__subtitle">نفس بنية جدول المدرس تماماً مع الاحتفاظ بأدوات إدارة الحصص والربط داخل نفس الصفحة.</p>
            </div>
            <div class="teacher-schedule-summary__actions">
                @can('Deletion of a class in the work schedule section')
                    <a class="btn btn-danger delete_lecture_time" data-toggle="modal" data-target="#delete_lesson_time">حذف الحصة</a>
                @endcan
                <input type="button" id="button" class="btn btn-success" value="تنزيل الجدول">
            </div>
        </div>

        @php
            $scheduleLookup = [];
            foreach ($schedule as $scheduleItem) {
                $scheduleLookup[$scheduleItem->lecture_time_id][$scheduleItem->day_id] = $scheduleItem;
            }

            $instructionLectureTimes = $lecture_times
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

        <div class="card v2-card teacher-schedule-card">
            <div class="card-body">
                <div id="simple_table" class="teacher-timetable-wrap">
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
                                        @php $lesson_time = $scheduleLookup[$lecture_time->id][$day->id] ?? null; @endphp
                                        <td class="teacher-timetable__cell">
                                            @if($lesson_time)
                                                <a class="btn btn-info btn-sm add_time teacher-timetable__lesson-box"
                                                   data-toggle="modal"
                                                   data-target="#add_schedule"
                                                   data-day_id="{{ $day->id }}"
                                                   data-day="{{ $day->name }}"
                                                   data-time_id="{{ $lecture_time->id }}"
                                                   data-time="{{ $lecture_time->name }}"
                                                   data-lesson_id="{{ $lesson_time->lesson->id }}"
                                                   data-teacher_id="{{ $lesson_time->teacher->id }}"
                                                   title="تحديد الحصة">
                                                    <p class="lesson_name-schedule{{ $day->id . $lecture_time->id }} teacher-timetable__lesson-title">{{ $lesson_time->lesson->name }}</p>
                                                    <p class="teacher_name-schedule{{ $day->id . $lecture_time->id }} teacher-timetable__meta">{{ $lesson_time->teacher->first_name }} {{ $lesson_time->teacher->last_name }}</p>
                                                    <p class="teacher-timetable__meta">{{ $lecture_time->start_time." - ".$lecture_time->end_time }}</p>
                                                </a>
                                                <a class="teacher-timetable__aux-action"
                                                   data-toggle="modal"
                                                   data-target="#add_schedule1"
                                                   data-day_id="{{ $day->id }}"
                                                   data-day="{{ $day->name }}"
                                                   data-time_name="{{ $lecture_time->name }}"
                                                   data-time_id="{{ $lecture_time->id }}"
                                                   data-lesson_id="{{ $lesson_time->lesson->id }}"
                                                   data-lesson_name="{{ $lesson_time->lesson->name }}"
                                                   data-lesson_time_id="{{ $lesson_time->id }}"
                                                   data-meeting_link="{{ $lesson_time->meeting_link }}"
                                                   title="إضافة رابط"><i class="fas fa-link"></i></a>
                                            @else
                                                <a class="teacher-timetable__empty add_time"
                                                   data-toggle="modal"
                                                   data-target="#add_schedule"
                                                   data-day_id="{{ $day->id }}"
                                                   data-day="{{ $day->name }}"
                                                   data-time_id="{{ $lecture_time->id }}"
                                                   data-time="{{ $lecture_time->name }}"
                                                   data-lesson_id=""
                                                   data-teacher_id=""
                                                   title="تحديد الحصة">لا يوجد حصة</a>
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


{{-- add lesson time --}}

<div class="modal fade" id="add_schedule">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="direction: rtl; text-align:right">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">تحديد الحصة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: inline-block;margin: 0px;padding: 0px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.room.save.schedule') }}" method="post" class="w-100 this-form">
                    @csrf
                    <input type="hidden" name="room_id" id="room_id" value="{{ $room_id }}" class="room_id">

                    <div class="form-group row">
                        <label for="courseCost" class="col-sm-2 col-form-label">اليوم:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control day">
                            <input type="hidden" name="day_id" class="form-control day_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="courseCost" class="col-sm-2 col-form-label">الحصة:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control time">
                            <input type="hidden" name="lecture_time_id" class="form-control time_id">
                        </div>
                    </div>
                    <div class="lessons-container">
                        <div class="form-group row">
                            <label for="courseCost" class="col-sm-2 col-form-label">حدد المادة:</label>
                            <div class="col-sm-10">
                                <select class="form-control wide lesson_id" style="width: 100%;" name="lesson[0][lesson_id]" id="lesson_id">
                                    <option value="">حدد المادة</option>
                                    @foreach ($lessons as $lesson)
                                        <option value="{{ $lesson->id }}">
                                            {{ $lesson->name }} ({{ $lesson->base_subject->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="courseCost" class="col-sm-2 col-form-label">حدد الاستاذ:</label>
                            <div class="col-sm-10">
                                <select class="form-control teacher_id" style="width: 100%;" name="lesson[0][teacher_id]" id="teacher_id">
                                    <option value="">حدد الاستاذ</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">
                                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <span><a href="#" class="btn btn-info btn-sm add_another_lesson">إضافة مادة أخرى لهذ التوقيت</a></span>
                    <div class="form-group modal-footer row justify-content-around px-3">
                        <button class="btn btn-success save_lecture_time" type="submit" style="width: 35%">تأكيد</button>
                        <button class="btn btn-light text-dark" data-dismiss="modal" style="width: 35%">خروج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        {{-- end add lesson time --}}



{{-- delete lesson time --}}

<div class="modal fade" id="delete_lesson_time">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="direction: rtl; text-align:right">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">حذف الحصة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  action="{{ route('dashboard.room.delete.lecture_time') }}" method="post" class="w-100">
                @csrf
                <input type="hidden" name="room_id" id="room_id" value=" {{ $room_id }}" class="room_id">


                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> اليوم : </label>
                    <div class="col-sm-10">
                        <select class="form-control wide2 " style="width: 100%;" name="day_id" id="">
                            <option value="">حدد اليوم</option>
                            @foreach ($days as $day)
                            <option value="{{ $day->id }}"><span>{{ $day->name }} </span></option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> الحصة : </label>
                    <div class="col-sm-10">
                        <select class="form-control wide2 " style="width: 100%;" name="lecture_time_id" id="">
                            <option value="">حدد الحصة</option>
                            @foreach ($lecture_times as $lecture_time)

                                <option value="{{ $lecture_time->id }}"><span>{{ $lecture_time->name }} </span></option>

                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="form-group modal-footer row justify-content-around px-3">
                      <button class="btn btn-warning delete_lecture_time" type="submit" style="width: 35%">تأكيد </button>
                    <button  class="btn btn-light btn-info" data-dismiss="modal" style="width: 35%">خروج</button>
                </div>

                <!-- end submit-->


            </form>
            </div>
        </div>
    </div>
</div>
        {{-- end delete lesson time --}}

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
            if (window.localStorage.getItem(storageKey) === '1') shell.classList.add('teacher-sidebar-collapsed');
            else shell.classList.remove('teacher-sidebar-collapsed');
            shell.classList.remove('sidebar-open');
        } else shell.classList.remove('teacher-sidebar-collapsed');
    }
    toggle.addEventListener('click', function(e) {
        if (!media.matches) return;
        e.preventDefault(); e.stopImmediatePropagation();
        shell.classList.toggle('teacher-sidebar-collapsed');
        window.localStorage.setItem(storageKey, shell.classList.contains('teacher-sidebar-collapsed') ? '1' : '0');
    }, true);
    if (media.addEventListener) media.addEventListener('change', syncSidebarState);
    else if (media.addListener) media.addListener(syncSidebarState);
    syncSidebarState();
})();
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
    <script>
        $(document).ready(function(){
            let counter = 0 ;

            $('.teacher_id').select2();
        //     $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
            let xx ;
            let my_room = {{ $room_id }} ;
            $('.add_time').on('click',function(){
                xx = $(this).data('xx');
                day = $(this).data('day');
                time2 = $(this).data('time');
                day_id = $(this).data('day_id');
                time_id = $(this).data('time_id');
                time_name = $(this).data('time_name');
                $(`.day`).val(day);
               $(`.time`).val(time2);
                $(`.day_id`).val(day_id);
               $(`.time_id`).val(time_id);
               $(`.time_name`).val(time_name);
            });

            $('.save_lecture_time').on('click',function(e){
                e.preventDefault() ;
                // let lesson_id = $('select.lesson_id').val();
                // let teacher_id = $('select.teacher_id').val();
                // let day_id = $(`.day_id`).val();
                // let lecture_time_id = $(`.time_id`).val();
                var form = $('.this-form');
                $.ajax({
                    url:"{{ route('save.schedule') }}",
                    type: "POST",

                    data: form.serialize(),
                    success: function (response2) {
                        console.log(response2);
                        if (response2.status == false) {
                            swal({title:"خطأ",text:`<p> هذا التوقيت محجوز للاستاذ</p>`,html:!0});
                        }else if (response2.status == 2){
                            swal({title:"خطأ",text:`<p> لايمكن إضافة مادنتين بنفس الوقت   </p>`,html:!0});
                        }else if (response2.status == 3){
                            swal({title:"خطأ",text:`<p> مسموح إضافة مادة واحدة   فقط      </p>`,html:!0});
                        }else{
                            let lesson_name = $( ".wide option:selected" ).text();
                            let lesson_id = $( ".wide " ).val();
                            let teacher_name = $( ".teacher_id option:selected" ).text();
                            // let lesson_id = $( ".wide " ).val();

                            $(`.${xx}`).val(lesson_name);
                            $(`.id-${xx}`).val(lesson_id);
                            $(`.lesson_name-${xx}`).text(lesson_name);
                            $(`.teacher_name-${xx}`).text(`(${teacher_name})`);

                            $("#add_schedule").modal('hide');
                            swal({title:"نجاح",text:`<p>تم الإضافة  بنجاح</p>`,html:!0});
                            window.location.reload();

                            console.log('content name',response2);
                    }
                    },error: function(error){
                    console.log('insider function',error);
                    var x = JSON.parse(error.responseText);
                        $.each(x.errors, function(key,value) {
                            swal({title:"خطأ",text:`<p>${value}</p>`,html:!0});
                        });
                    }
                });

            })
            $('.add_another_lesson').on('click',function(){
                counter++ ;
                $('.lessons-container').append(`
                <div >
                    <span class="del-element"  style=" text-align:right;color:red">  <i class="fa fa-window-close fa-3x " style="cursor:pointer" title="الغاء" aria-hidden="true"></i> </span>
                    <div class="form-group row">
                        <label for="courseCost" class="col-sm-2 col-form-label"> حدد المادة     :</label>
                        <div class="col-sm-10">
                            <select class="form-control wide lesson_id" style="width: 100%;" name="lesson[${counter}][lesson_id]" id="lesson_id">
                                <option value="">حدد المادة</option>
                                @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}"><span>{{ $lesson->name }} </span></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="courseCost" class="col-sm-2 col-form-label"> حدد الاستاذ     :</label>
                        <div class="col-sm-10">
                            <select class="form-control  teacher_id" style="width: 100%;" name="lesson[${counter}][teacher_id]" id="teacher_id">
                                <option value="">حدد الاستاذ</option>
                                @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->first_name }}  {{ $teacher->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                `)
            });

            $(document).on('click' , '.del-element' , function () {
                $(this).parent().remove();
                counter-- ;
            });

        });
    </script>
<script>
    $(document).ready(function() {
        $('.add_time').on('click', function() {
            var day = $(this).data('day');
            var time = $(this).data('time');
            var time_name = $(this).data('time_name');
            var day_id = $(this).data('day_id');
            var time_id = $(this).data('time_id');
            var lesson_id = $(this).data('lesson_id'); // Lesson ID
            var teacher_id = $(this).data('teacher_id'); // Teacher ID

            // Set the values in the modal
            $('.day').val(day);
            $('.time').val(time);
            $('.time_name').val(time-name);
            $('.day_id').val(day_id);
            $('.time_id').val(time_id);

            // Select the lesson and teacher in the dropdowns
            $('.lesson_id').val(lesson_id).trigger('change'); // Use trigger('change') to update UI if needed
            $('.teacher_id').val(teacher_id).trigger('change'); // Use trigger('change') to update UI if needed
        });
    });
</script>




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
            a.download = "برنامج دوام الصف " +"{{ $class_name }}" +" "  + "{{ $room->name }}"  + ".png";
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

<script>
    $('#add_schedule1').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var lessonTimeId = button.data('lesson_time_id');  // Ensure this has the correct value
    var lessonId = button.data('lesson_id');  // This should extract the correct lesson ID

    var modal = $(this);
    modal.find('.lesson_time_id').val(lessonTimeId);

    // Extract the correct data
    var dayId = button.data('day_id');
    var day = button.data('day');
    var timeId = button.data('time_id');  // Correct time ID
    var timeName = button.data('time_name');  // Correct time ID
    var lessonName = button.data('lesson_name');
    var lessonID = button.data('lesson_id');

    var lessonTimeId = button.data('lesson_time_id');
    var meetingLink = button.data('meeting_link');

    // Assign these values to the modal inputs
    var modal = $(this);
    modal.find('.day').val(day);
    modal.find('.day_id').val(dayId);
    modal.find('.time').val(timeId);
    modal.find('.time_name').val(timeName);
    modal.find('.time_id').val(timeId);  // Make sure time_id gets the correct time value
    modal.find('.lesson').val(lessonName);
    modal.find('.lesson_id').val(lessonID);

    modal.find('.lesson_time_id').val(lessonTimeId);
    modal.find('.meeting_link').val(meetingLink);
});
</script>

    @endsection
