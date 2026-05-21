@extends('teachers2.layouts.app')

@section('teacher_page_title', 'المواد الدراسية')
@section('teacher_page_subtitle', 'إدارة الدروس والمحتوى التعليمي')

@section('content')
    @php
        $today = \Carbon\Carbon::now()->locale('ar')->translatedFormat('l، j F Y');
        $teacherName = trim($teacher->first_name . ' ' . $teacher->last_name);
        $teacherName = $teacherName !== '' ? 'أ. ' . $teacherName : 'الأستاذ';
    @endphp

    <div class="main-panel teacher-subjects-page">
        <div class="content-wrapper pb-0 teacher-dashboard-content">
            <div class="teacher-dashboard-inner">
                <ul class="breadcrumbs teacher-breadcrumbs">
                    <li class="li"><a href="{{ route('dashboard.teacher') }}">الرئيسية</a></li>
                    <li class="li"><a href="#">{{ $room_name }}</a></li>
                </ul>

                <section class="teacher-welcome-banner animated fadeInDown">
                    <div class="teacher-welcome-banner__content">
                        <span class="teacher-welcome-banner__eyebrow">لوحة المواد</span>
                        <h2>مرحباً، {{ $teacherName }} <span aria-hidden="true">👋</span></h2>
                        <p>استعرض موادك الدراسية وابدأ إدارة الدروس والكتب المنهجية ضمن بيئة أكثر وضوحاً وتنظيماً.</p>
                    </div>
                    <div class="teacher-welcome-banner__meta">
                        <div class="teacher-welcome-banner__date">
                            <i class="mdi mdi-calendar-month-outline" aria-hidden="true"></i>
                            <span>{{ $today }}</span>
                        </div>
                        <div class="teacher-welcome-banner__tag">
                            <i class="mdi mdi-book-education-outline" aria-hidden="true"></i>
                            <span>{{ $room_name }}</span>
                        </div>
                    </div>
                </section>

                <div class="container teacher-subjects-container">
                    <div class="row teacher-subjects-grid">
                        @forelse ($teacher_lessons as $item)
                            <div class="col-xl-4 col-md-6">
                                <article class="cookie-card teacher-subject-card">
                                    <div class="teacher-subject-card__visual">
                                        <span class="teacher-subject-card__visual-glow" aria-hidden="true"></span>
                                        <div class="teacher-subject-card__icon" aria-hidden="true">
                                            <i class="mdi mdi-book-open-page-variant"></i>
                                        </div>
                                    </div>

                                    <div class="teacher-subject-card__body">
                                        <span class="teacher-subject-card__eyebrow">مادة دراسية</span>
                                        <h3 class="teacher-subject-card__title">{{ $item->name ?? '—' }}</h3>
                                        <p class="teacher-subject-card__text">يمكنك الانتقال إلى الدروس أو استعراض الكتب المنهجية الخاصة بهذه المادة مباشرة.</p>
                                    </div>

                                    <div class="actions teacher-subject-card__actions">
                                        <a href="{{ route('dashboard.lessons.lectures', ['lesson_id' => $item->id, 'teacher_id' => $teacher->id, 'room_id' => $room_id]) }}"
                                           class="accept teacher-subject-card__link teacher-subject-card__link--primary">
                                            الدروس
                                        </a>
                                        <a href="{{ route('teacher.books', ['lesson_id' => $item->id, 'teacher_id' => $teacher->id, 'room_id' => $room_id]) }}"
                                           class="accept teacher-subject-card__link teacher-subject-card__link--secondary">
                                            الكتب المنهجية
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="teacher-dashboard-empty">
                                    <i class="mdi mdi-book-open-page-variant"></i>
                                    <strong>لا توجد مواد مرتبطة بهذه الشعبة حالياً</strong>
                                    <span>عند ربط مادة دراسية بهذه الشعبة ستظهر هنا تلقائياً.</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
