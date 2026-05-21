@extends('teachers2.layouts.app')

@section('teacher_page_title')
{{ app()->getLocale() === 'en' ? 'Teacher Schedule' : 'جدول الدوام' }}
@endsection

@section('teacher_page_subtitle')
{{ app()->getLocale() === 'en' ? 'A simple weekly planner for your lessons, streams, and attendance states.' : 'مخطط أسبوعي بسيط للدروس وروابط البث وحالات الحضور.' }}
@endsection

@section('css')
<style>
    body.teacher-portal-body .teacher-schedule-page {
        padding: 1.25rem;
    }

    body.teacher-portal-body .teacher-schedule-shell {
        display: grid;
        gap: 1rem;
        width: 100%;
        min-width: 0;
    }

    body.teacher-portal-body .teacher-schedule-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(280px, 380px);
        gap: .9rem;
        align-items: stretch;
        padding: 1.2rem 1.35rem;
        border-radius: 22px;
        background: linear-gradient(135deg, #0f172a 0%, #1e40af 58%, #6d28d9 100%);
        color: #fff;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.14);
    }

    body.teacher-portal-body .teacher-schedule-hero__copy {
        display: grid;
        gap: .55rem;
        min-width: 0;
        align-content: center;
    }

    body.teacher-portal-body .teacher-schedule-hero__eyebrow,
    body.teacher-portal-body .teacher-schedule-panel__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .42rem;
        width: fit-content;
        padding: .38rem .75rem;
        border-radius: 999px;
        font-size: .76rem;
        font-weight: 700;
        letter-spacing: .02em;
    }

    body.teacher-portal-body .teacher-schedule-hero__eyebrow {
        background: rgba(255, 255, 255, 0.14);
        color: rgba(255, 255, 255, 0.95);
    }

    body.teacher-portal-body .teacher-schedule-panel__eyebrow {
        background: #eef2ff;
        color: #4338ca;
    }

    body.teacher-portal-body .teacher-schedule-hero__title {
        margin: 0;
        font-size: 1.65rem;
        line-height: 1.25;
        font-weight: 800;
        color: #fff;
    }

    body.teacher-portal-body .teacher-schedule-hero__subtitle {
        margin: 0;
        max-width: 58rem;
        color: rgba(255, 255, 255, 0.9);
        font-size: .93rem;
        line-height: 1.75;
    }

    body.teacher-portal-body .teacher-schedule-hero__meta {
        display: grid;
        gap: .75rem;
        align-content: center;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        min-width: 0;
    }

    body.teacher-portal-body .teacher-schedule-stat {
        display: grid;
        gap: .25rem;
        padding: .85rem .9rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    body.teacher-portal-body .teacher-schedule-stat strong {
        font-size: 1.15rem;
        line-height: 1.2;
        font-weight: 800;
        color: #fff;
    }

    body.teacher-portal-body .teacher-schedule-stat span {
        color: rgba(255, 255, 255, 0.9);
        font-size: .78rem;
        line-height: 1.35;
    }

    body.teacher-portal-body .teacher-schedule-panel {
        display: grid;
        gap: .9rem;
        padding: 1.1rem;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    body.teacher-portal-body .teacher-schedule-panel__head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: .9rem;
        flex-wrap: wrap;
    }

    body.teacher-portal-body .teacher-schedule-panel__copy {
        min-width: 0;
        display: grid;
        gap: .28rem;
    }

    body.teacher-portal-body .teacher-schedule-panel__copy h3 {
        margin: 0;
        color: #0f172a;
        font-size: 1.08rem;
        line-height: 1.35;
        font-weight: 800;
    }

    body.teacher-portal-body .teacher-schedule-panel__copy p {
        margin: 0;
        color: #64748b;
        line-height: 1.7;
        font-size: .88rem;
    }

    body.teacher-portal-body .teacher-schedule-panel__actions {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        align-items: center;
        justify-content: flex-end;
    }

    body.teacher-portal-body .teacher-schedule-chip {
        display: inline-flex;
        align-items: center;
        gap: .38rem;
        padding: .5rem .75rem;
        border-radius: 999px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #334155;
        font-size: .8rem;
        font-weight: 700;
        white-space: nowrap;
    }

    body.teacher-portal-body .teacher-schedule-legend {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
    }

    body.teacher-portal-body .teacher-schedule-legend__item {
        display: inline-flex;
        align-items: center;
        gap: .42rem;
        padding: .45rem .7rem;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-size: .77rem;
        font-weight: 700;
    }

    body.teacher-portal-body .teacher-schedule-legend__dot {
        width: .72rem;
        height: .72rem;
        border-radius: 999px;
        flex: 0 0 auto;
    }

    body.teacher-portal-body .teacher-schedule-legend__item.is-default .teacher-schedule-legend__dot { background: #cbd5e1; }
    body.teacher-portal-body .teacher-schedule-legend__item.is-info .teacher-schedule-legend__dot { background: #38bdf8; }
    body.teacher-portal-body .teacher-schedule-legend__item.is-success .teacher-schedule-legend__dot { background: #22c55e; }
    body.teacher-portal-body .teacher-schedule-legend__item.is-danger .teacher-schedule-legend__dot { background: #ef4444; }
    body.teacher-portal-body .teacher-schedule-legend__item.is-warning .teacher-schedule-legend__dot { background: #f59e0b; }

    body.teacher-portal-body .teacher-schedule-day-stack {
        display: grid;
        gap: .85rem;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        align-items: start;
    }

    body.teacher-portal-body .teacher-schedule-day-card {
        display: grid;
        gap: .7rem;
        padding: .85rem .85rem .9rem;
        border-radius: 18px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        background: linear-gradient(180deg, rgba(255,255,255,.95) 0%, rgba(248,250,252,.94) 100%);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.04);
        backdrop-filter: blur(8px);
        min-width: 0;
    }

    body.teacher-portal-body .teacher-schedule-day-card__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .55rem;
        flex-wrap: wrap;
        position: sticky;
        top: .35rem;
        z-index: 1;
    }

    body.teacher-portal-body .teacher-schedule-day-card__title {
        display: inline-flex;
        align-items: center;
        gap: .38rem;
        margin: 0;
        padding: .38rem .7rem;
        border-radius: 999px;
        background: rgba(255,255,255,.82);
        color: #1e40af;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.03);
        font-size: .8rem;
        font-weight: 800;
    }

    body.teacher-portal-body .teacher-schedule-day-card__title i {
        color: #1d4ed8;
        opacity: .9;
    }

    body.teacher-portal-body .teacher-schedule-day-card__today {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .34rem .62rem;
        border-radius: 999px;
        background: #ecfeff;
        color: #0f766e;
        font-size: .74rem;
        font-weight: 700;
    }

    body.teacher-portal-body .teacher-schedule-lesson-list {
        display: grid;
        gap: .55rem;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item {
        display: grid;
        gap: .55rem;
        padding: .78rem .8rem;
        border-radius: 15px;
        border: 1px solid rgba(226, 232, 240, 0.95);
        background: #fff;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.03);
        transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease, background .16s ease;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
    }

    body.teacher-portal-body .teacher-schedule-lesson-item.is-default { background: #fff; }
    body.teacher-portal-body .teacher-schedule-lesson-item.is-info { background: #f8fbff; border-color: #dbeafe; }
    body.teacher-portal-body .teacher-schedule-lesson-item.is-success { background: #f5fbf7; border-color: #dcfce7; }
    body.teacher-portal-body .teacher-schedule-lesson-item.is-danger { background: #fff7f7; border-color: #fee2e2; }
    body.teacher-portal-body .teacher-schedule-lesson-item.is-warning { background: #fffaf3; border-color: #fde68a; }

    body.teacher-portal-body .teacher-schedule-lesson-item__top {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        align-items: center;
        justify-content: space-between;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item__time {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .3rem .55rem;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.08);
        color: #0f172a;
        font-size: .75rem;
        font-weight: 700;
        white-space: nowrap;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item__badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .3rem .56rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 800;
        white-space: nowrap;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item.is-default .teacher-schedule-lesson-item__badge {
        background: rgba(148, 163, 184, .16);
        color: #475569;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item.is-info .teacher-schedule-lesson-item__badge {
        background: rgba(56, 189, 248, .16);
        color: #0369a1;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item.is-success .teacher-schedule-lesson-item__badge {
        background: rgba(34, 197, 94, .16);
        color: #15803d;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item.is-danger .teacher-schedule-lesson-item__badge {
        background: rgba(239, 68, 68, .16);
        color: #b91c1c;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item.is-warning .teacher-schedule-lesson-item__badge {
        background: rgba(245, 158, 11, .16);
        color: #b45309;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item__title {
        margin: 0;
        font-size: .94rem;
        line-height: 1.4;
        font-weight: 800;
        color: #0f172a;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item__meta {
        display: grid;
        gap: .24rem;
        color: #475569;
        font-size: .79rem;
        line-height: 1.55;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item__meta strong {
        color: #0f172a;
        font-weight: 700;
    }

    body.teacher-portal-body .teacher-schedule-lesson-item__action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
        width: fit-content;
        padding: .42rem .72rem;
        border-radius: 999px;
        background: #111827;
        color: #fff;
        font-size: .75rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12);
    }

    body.teacher-portal-body .teacher-schedule-empty {
        display: grid;
        place-items: center;
        text-align: center;
        gap: .3rem;
        min-height: 120px;
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
        background: #f8fafc;
        color: #94a3b8;
        padding: 1rem;
    }

    body.teacher-portal-body .teacher-schedule-empty i {
        font-size: 1.5rem;
    }

    @media (max-width: 1199.98px) {
        body.teacher-portal-body .teacher-schedule-hero {
            grid-template-columns: 1fr;
        }

        body.teacher-portal-body .teacher-schedule-day-stack {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        body.teacher-portal-body .teacher-schedule-page {
            padding: 1rem;
        }

        body.teacher-portal-body .teacher-schedule-panel,
        body.teacher-portal-body .teacher-schedule-hero {
            border-radius: 20px;
        }

        body.teacher-portal-body .teacher-schedule-hero {
            padding: 1.15rem;
        }

        body.teacher-portal-body .teacher-schedule-panel {
            padding: 1rem;
        }

        body.teacher-portal-body .teacher-schedule-hero__title {
            font-size: 1.45rem;
        }

        body.teacher-portal-body .teacher-schedule-hero__meta {
            grid-template-columns: 1fr;
        }

        body.teacher-portal-body .teacher-schedule-day-stack {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575.98px) {
        body.teacher-portal-body .teacher-schedule-hero__subtitle {
            font-size: .92rem;
        }
    }
</style>
@endsection

@section('content')
@php
    $isRtl = app()->getLocale() !== 'en';
    $teacherName = trim(($teacher->first_name ?? '') . ' ' . ($teacher->last_name ?? ''));
    $teacherName = $teacherName !== ''
        ? ($isRtl ? 'أ. ' . $teacherName : $teacherName)
        : ($isRtl ? 'الأستاذ' : 'Teacher');

    $dayCollection = collect($days)->sortBy('id')->values();
    $boardDays = $dayCollection->take(5)->values();
    $lessonsByDay = collect($schedule)
        ->sortBy(function ($entry) {
            return optional($entry->lecture_time)->start_time ?: '23:59:59';
        })
        ->groupBy('day_id');

    $todayDayId = (int) $today + 1;
    $todaySessions = collect($schedule)->where('day_id', $todayDayId);
    $totalSessions = collect($schedule)->count();
    $liveSessions = $todaySessions->filter(fn ($entry) => !empty($entry->inter))->count();
    $joinableSessions = $todaySessions->filter(fn ($entry) => !empty($entry->meeting_link))->count();
    $attendedSessions = $todaySessions->filter(fn ($entry) => !empty($entry->attendance))->count();
    $currentDayName = optional($dayCollection->firstWhere('id', $todayDayId))->name ?: ($isRtl ? 'اليوم الحالي' : 'Today');
    $todayDate = \Carbon\Carbon::now()->locale($isRtl ? 'ar' : 'en')->translatedFormat($isRtl ? 'l، j F Y' : 'l, j F Y');
    $roomCount = collect($teacher->rooms ?? [])->count();

    $labels = [
        'dashboard' => $isRtl ? 'لوحة الدوام' : 'Schedule Dashboard',
        'summary' => $isRtl ? 'ملخص سريع' : 'Quick Summary',
        'today_sessions' => $isRtl ? 'حصص اليوم' : 'Today Sessions',
        'live_sessions' => $isRtl ? 'حصص مباشرة' : 'Live Sessions',
        'lesson_list' => $isRtl ? 'دروس هذا اليوم' : 'Lessons for this day',
        'lesson_count' => $isRtl ? 'عدد الدروس' : 'Lesson count',
        'legend' => $isRtl ? 'دليل الألوان' : 'Color Legend',
        'no_lessons' => $isRtl ? 'لا توجد حصص مجدولة بعد' : 'No scheduled lessons yet',
        'no_lessons_text' => $isRtl ? 'سيظهر الجدول هنا بمجرد ربط الشعب والحصص بالمعلم.' : 'The schedule will appear here once rooms and lessons are assigned to you.',
        'empty_day' => $isRtl ? 'لا توجد حصص في هذا اليوم' : 'No lessons on this day',
        'today' => $isRtl ? 'اليوم' : 'Today',
        'scheduled' => $isRtl ? 'مجدولة' : 'Scheduled',
        'available_link' => $isRtl ? 'الرابط متاح' : 'Link available',
        'join_lesson' => $isRtl ? 'الدخول إلى الحصة' : 'Join lesson',
        'attended' => $isRtl ? 'تم الحضور' : 'Attended',
        'no_link' => $isRtl ? 'لا يوجد رابط' : 'No link',
        'room_label' => $isRtl ? 'الشعبة' : 'Room',
        'time_label' => $isRtl ? 'الوقت' : 'Time',
        'period_label' => $isRtl ? 'الحصة' : 'Slot',
        'open' => $isRtl ? 'فتح الحصة' : 'Open lesson',
    ];
@endphp

<div class="main-panel teacher-schedule-page">
    <div class="content-wrapper">
        <div class="teacher-schedule-shell">
            <section class="teacher-schedule-hero">
                <div class="teacher-schedule-hero__copy">
                    <span class="teacher-schedule-hero__eyebrow">
                        <i class="mdi mdi-calendar-clock" aria-hidden="true"></i>
                        {{ $labels['dashboard'] }}
                    </span>
                    <h2 class="teacher-schedule-hero__title">
                        {{ $isRtl ? 'جدول الدوام' : 'Teacher Schedule' }}
                    </h2>
                    <p class="teacher-schedule-hero__subtitle">
                        {{ $isRtl ? 'هذه الصفحة تعرض الجدول الأسبوعي بصيغة بسيطة وواضحة: كل يوم على حدة مع الدروس الفعلية فقط، مع حالات الدخول والحضور وروابط البث عند توفرها.' : 'This page shows a simple weekly planner: one day at a time with the real lessons only, plus access states and stream links when available.' }}
                    </p>
                    <p class="teacher-schedule-hero__subtitle">
                        {{ $isRtl ? 'مرحباً،' : 'Hello,' }} {{ $teacherName }} · {{ $todayDate }}
                    </p>
                </div>

                <div class="teacher-schedule-hero__meta">
                    <div class="teacher-schedule-stat">
                        <strong>{{ $roomCount }}</strong>
                        <span>{{ $isRtl ? 'الشعب المرتبطة بك' : 'Rooms linked to you' }}</span>
                    </div>
                    <div class="teacher-schedule-stat">
                        <strong>{{ $totalSessions }}</strong>
                        <span>{{ $labels['lesson_count'] }}</span>
                    </div>
                    <div class="teacher-schedule-stat">
                        <strong>{{ $todaySessions->count() }}</strong>
                        <span>{{ $labels['today_sessions'] }}</span>
                    </div>
                    <div class="teacher-schedule-stat">
                        <strong>{{ $liveSessions }}</strong>
                        <span>{{ $labels['live_sessions'] }}</span>
                    </div>
                </div>
            </section>

            <section class="teacher-schedule-panel">
                <div class="teacher-schedule-panel__head">
                    <div class="teacher-schedule-panel__copy">
                        <span class="teacher-schedule-panel__eyebrow">
                            <i class="mdi mdi-view-week-outline" aria-hidden="true"></i>
                            {{ $labels['summary'] }}
                        </span>
                        <h3>{{ $isRtl ? 'الجدول الأسبوعي المبسط' : 'Simple Weekly Planner' }}</h3>
                        <p>{{ $isRtl ? 'يتم ترتيب الدروس تحت كل يوم بشكل مباشر مع الحفاظ على ترتيبها الزمني، بدون خلايا فارغة أو أعمدة متكررة.' : 'Lessons are grouped directly under each day in chronological order, without empty cells or repeated columns.' }}</p>
                    </div>

                    <div class="teacher-schedule-panel__actions">
                        <span class="teacher-schedule-chip">
                            <i class="mdi mdi-calendar-today" aria-hidden="true"></i>
                            {{ $currentDayName }}
                        </span>
                        <span class="teacher-schedule-chip">
                            <i class="mdi mdi-link-variant" aria-hidden="true"></i>
                            {{ $joinableSessions }} {{ $isRtl ? 'رابط' : 'links' }}
                        </span>
                        <span class="teacher-schedule-chip">
                            <i class="mdi mdi-check-circle-outline" aria-hidden="true"></i>
                            {{ $attendedSessions }} {{ $isRtl ? 'حضور' : 'attended' }}
                        </span>
                    </div>
                </div>

                <div class="teacher-schedule-legend" aria-label="{{ $labels['legend'] }}">
                    <span class="teacher-schedule-legend__item is-default"><span class="teacher-schedule-legend__dot"></span>{{ $labels['scheduled'] }}</span>
                    <span class="teacher-schedule-legend__item is-info"><span class="teacher-schedule-legend__dot"></span>{{ $labels['available_link'] }}</span>
                    <span class="teacher-schedule-legend__item is-success"><span class="teacher-schedule-legend__dot"></span>{{ $labels['join_lesson'] }}</span>
                    <span class="teacher-schedule-legend__item is-danger"><span class="teacher-schedule-legend__dot"></span>{{ $labels['attended'] }}</span>
                    <span class="teacher-schedule-legend__item is-warning"><span class="teacher-schedule-legend__dot"></span>{{ $labels['no_link'] }}</span>
                </div>

                @if ($boardDays->isEmpty())
                    <div class="teacher-schedule-empty">
                        <i class="mdi mdi-calendar-remove-outline" aria-hidden="true"></i>
                        <strong>{{ $labels['no_lessons'] }}</strong>
                        <span>{{ $labels['no_lessons_text'] }}</span>
                    </div>
                @else
                <div class="teacher-schedule-day-stack">
                        @foreach ($boardDays as $day)
                            @php
                                $dayLessons = collect($lessonsByDay->get($day->id, []));
                            @endphp
                            <section class="teacher-schedule-day-card">
                                <div class="teacher-schedule-day-card__head">
                                    <h4 class="teacher-schedule-day-card__title">
                                        <i class="mdi mdi-calendar-range" aria-hidden="true"></i>
                                        {{ $day->name }}
                                    </h4>
                                    @if ((int) $day->id === (int) $todayDayId)
                                        <span class="teacher-schedule-day-card__today">
                                            <i class="mdi mdi-calendar-star" aria-hidden="true"></i>
                                            {{ $labels['today'] }}
                                        </span>
                                    @endif
                                </div>

                                @if ($dayLessons->isEmpty())
                                    <div class="teacher-schedule-empty" style="min-height: 130px;">
                                        <i class="mdi mdi-calendar-remove-outline" aria-hidden="true"></i>
                                        <strong>{{ $labels['empty_day'] }}</strong>
                                    </div>
                                @else
                                    <div class="teacher-schedule-lesson-list">
                                        @foreach ($dayLessons as $entry)
                                            @php
                                                $hasLink = !blank($entry->meeting_link);
                                                $attendance = (bool) $entry->attendance;
                                                $inter = (bool) $entry->inter;
                                                $stateClass = 'is-default';
                                                $stateLabel = $labels['scheduled'];
                                                $actionable = false;
                                                $joinUrl = null;

                                                if ((int) $day->id === (int) $todayDayId) {
                                                    if (!$hasLink) {
                                                        $stateClass = 'is-warning';
                                                        $stateLabel = $labels['no_link'];
                                                    } elseif ($attendance && $inter) {
                                                        $stateClass = 'is-danger';
                                                        $stateLabel = $labels['attended'];
                                                        $actionable = true;
                                                    } elseif ($inter) {
                                                        $stateClass = 'is-success';
                                                        $stateLabel = $labels['join_lesson'];
                                                        $actionable = true;
                                                    } elseif ($hasLink) {
                                                        $stateClass = 'is-info';
                                                        $stateLabel = $labels['available_link'];
                                                    }
                                                } elseif (!$hasLink) {
                                                    $stateClass = 'is-warning';
                                                    $stateLabel = $labels['no_link'];
                                                }

                                                if ($actionable && optional($entry->room)->id) {
                                                    $joinUrl = route('dashboard.teacher.room.go_to_stream', [
                                                        'scheduler_id' => $entry->id,
                                                        'day_id' => $day->id,
                                                        'lecture_time_id' => $entry->lecture_time->id,
                                                        'room_id' => $entry->room->id,
                                                        'teacher_id' => $teacher_id,
                                                    ]);
                                                }
                                            @endphp

                                            <article class="teacher-schedule-lesson-item {{ $stateClass }}">
                                                <div class="teacher-schedule-lesson-item__top">
                                                    <span class="teacher-schedule-lesson-item__badge">{{ $stateLabel }}</span>
                                                    <span class="teacher-schedule-lesson-item__time">
                                                        <i class="mdi mdi-clock-outline" aria-hidden="true"></i>
                                                        {{ \Carbon\Carbon::parse($entry->lecture_time->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($entry->lecture_time->end_time)->format('H:i') }}
                                                    </span>
                                                </div>

                                                <h4 class="teacher-schedule-lesson-item__title">{{ $entry->lesson->name }}</h4>

                                                <div class="teacher-schedule-lesson-item__meta">
                                                    <span><strong>{{ $labels['room_label'] }}:</strong> {{ $entry->room->classes->name }} / {{ $entry->room->name }}</span>
                                                    <span><strong>{{ $labels['period_label'] }}:</strong> {{ $entry->lecture_time->name }}</span>
                                                </div>

                                                @if ($joinUrl)
                                                    <a href="{{ $joinUrl }}" target="_blank" rel="noopener noreferrer" class="teacher-schedule-lesson-item__action">
                                                        <i class="mdi mdi-arrow-top-right-thin" aria-hidden="true"></i>
                                                        {{ $labels['open'] }}
                                                    </a>
                                                @endif
                                            </article>
                                        @endforeach
                                    </div>
                                @endif
                            </section>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var activeNav = document.querySelector('.sh11');
        if (activeNav) {
            activeNav.classList.add('active');
        }
    });
</script>
@endsection
