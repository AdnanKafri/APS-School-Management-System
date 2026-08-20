@extends('students.layouts.app4')

@section('title', 'لوحتي الدراسية')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <span class="sp-page-header__eyebrow">مرحباً بك في بوابتك</span>
                    <h1>{{ $student->first_name }} {{ $student->last_name }}</h1>
                    <p>تابع موادك ودروسك ونتائجك من مساحة دراسية واحدة وواضحة.</p>
                </div>
                <div class="sp-page-header__aside" aria-label="بيانات القيد الحالي">
                    <div class="sp-header-stat">
                        <span>الصف</span>
                        <strong>{{ optional($class)->name ?: 'غير محدد' }}</strong>
                    </div>
                    <div class="sp-header-stat">
                        <span>الشعبة</span>
                        <strong>{{ optional($room)->name ?: 'غير محددة' }}</strong>
                    </div>
                </div>
            </section>

            <nav class="sp-quick-grid" aria-label="روابط الطالب السريعة">
                <a class="sp-quick-link" href="{{ route('student_exam') }}">
                    <span class="sp-quick-link__icon"><i class="mdi mdi-clipboard-text-outline"></i></span>
                    <span><strong>الامتحانات والتقييمات</strong><small>الامتحانات والمذاكرات المتاحة</small></span>
                </a>
                <a class="sp-quick-link" href="{{ route('dashboard.student.results', $student->id) }}">
                    <span class="sp-quick-link__icon sp-icon-box--blue"><i class="mdi mdi-chart-box-outline"></i></span>
                    <span><strong>النتائج والعلامات</strong><small>راجع نتائجك الأكاديمية</small></span>
                </a>
                <a class="sp-quick-link" href="{{ route('dashboard.student.academic_record') }}">
                    <span class="sp-quick-link__icon sp-icon-box--gold"><i class="mdi mdi-history"></i></span>
                    <span><strong>السجل الأكاديمي</strong><small>سنواتك ونتائجك السابقة</small></span>
                </a>
                <a class="sp-quick-link" href="{{ route('student_electronic_sections') }}">
                    <span class="sp-quick-link__icon"><i class="mdi mdi-folder-multiple-outline"></i></span>
                    <span><strong>الملفات الإلكترونية</strong><small>المصادر والملفات الدراسية</small></span>
                </a>
            </nav>

            <section class="sp-section" id="student-subjects">
                <div class="sp-section-header">
                    <div>
                        <h2>موادي الدراسية</h2>
                        <p>اختر المادة للوصول إلى الدروس والمحتوى المرتبط بها.</p>
                    </div>
                    <span class="sp-badge sp-badge--success">{{ $lessons->count() }} مادة</span>
                </div>

                <div class="sp-grid sp-grid--auto">
                    @forelse ($lessons as $lesson)
                        <a class="sp-subject-card" href="{{ route('dashboard.student.lesson.lectures', ['lesson_id' => $lesson->id, 'room_id' => $room->id, 'student_id' => $student->id]) }}">
                            <span class="sp-subject-card__visual">
                                <i class="mdi mdi-book-open-page-variant"></i>
                                <span class="sp-subject-card__index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            </span>
                            <span class="sp-subject-card__body">
                                <h3>{{ $lesson->name }}</h3>
                                <p>الدروس والمحتوى التعليمي</p>
                                <span class="sp-subject-card__action">فتح المادة <i class="mdi mdi-arrow-left"></i></span>
                            </span>
                        </a>
                    @empty
                        <div class="sp-empty">
                            <span class="sp-empty__icon"><i class="mdi mdi-book-off-outline"></i></span>
                            <h3>لا توجد مواد متاحة حالياً</h3>
                            <p>ستظهر المواد هنا عند ربطها بصفك وشعبتك.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
