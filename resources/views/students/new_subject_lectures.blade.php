@extends('students.layouts.app4')

@section('title', 'دروس ' . $lesson->name)

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <a class="sp-page-header__eyebrow" href="{{ route('dashboard.student.lessons', $student->id) }}">المواد الدراسية</a>
                    <h1>{{ $lesson->name }}</h1>
                    <p>الدروس المنشورة والمحتوى التعليمي المتاح لهذه المادة.</p>
                </div>
                <div class="sp-page-header__aside">
                    <div class="sp-header-stat">
                        <span>الدروس المتاحة</span>
                        <strong>{{ $lectures->filter(function ($lecture) use ($now) { return $lecture->lecture_time < $now; })->count() }}</strong>
                    </div>
                </div>
            </section>

            <section class="sp-section">
                <div class="sp-grid sp-grid--auto">
                    @php $visibleLectureCount = 0; @endphp
                    @foreach ($lectures as $lecture)
                        @if ($lecture->lecture_time < $now)
                            @php $visibleLectureCount++; @endphp
                            <article class="sp-card sp-lesson-card">
                                <div class="sp-card__body">
                                    <span class="sp-icon-box"><i class="mdi mdi-play-box-outline"></i></span>
                                    <div>
                                        <span class="sp-badge sp-badge--success">درس متاح</span>
                                        <h3 class="sp-card__title">{{ $lecture->name }}</h3>
                                        @if ($lecture->lecture_time)
                                            <p class="sp-card__meta">نشر في {{ \Carbon\Carbon::parse($lecture->lecture_time)->format('Y-m-d') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="sp-card__footer">
                                    <a class="sp-btn sp-btn--primary sp-btn--block" href="{{ route('dashboard.student.lesson.lecture.content', ['lesson_id' => $lesson->id, 'student_id' => $student->id, 'lecture_id' => $lecture->id]) }}">
                                        <i class="mdi mdi-book-open-variant"></i> فتح محتوى الدرس
                                    </a>
                                </div>
                            </article>
                        @endif
                    @endforeach
                    @if ($visibleLectureCount === 0)
                        <div class="sp-empty">
                            <span class="sp-empty__icon"><i class="mdi mdi-calendar-blank-outline"></i></span>
                            <h3>لا توجد دروس منشورة</h3>
                            <p>ستظهر الدروس هنا عند نشرها من المعلم.</p>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
