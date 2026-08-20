@extends('students.layouts.app4')

@section('title', 'الامتحانات والتقييمات')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <a class="sp-page-header__eyebrow" href="{{ route('dashboard.student.lessons', $student->id) }}">الصفحة الرئيسية</a>
                    <h1>الامتحانات والتقييمات</h1>
                    <p>اختر نوع التقييم للاطلاع على المواعيد والنتائج المتاحة.</p>
                </div>
                <div class="sp-page-header__aside">
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

            <section class="sp-section">
                <div class="sp-section-header">
                    <div>
                        <h2>اختر القسم</h2>
                        <p>جميع التقييمات مرتبطة بقيدك الدراسي الحالي.</p>
                    </div>
                </div>

                <div class="sp-grid sp-grid--2">
                    <a class="sp-card sp-assessment-entry" href="{{ route('dashboard.student.room.main.exams', [$room_id, $student->id]) }}">
                        <span class="sp-icon-box sp-icon-box--blue"><i class="mdi mdi-file-document-edit-outline"></i></span>
                        <span class="sp-assessment-entry__content">
                            <strong>الامتحانات</strong>
                            <small>الامتحانات الفصلية والنهائية</small>
                        </span>
                        <i class="mdi mdi-arrow-left sp-assessment-entry__arrow"></i>
                    </a>
                    <a class="sp-card sp-assessment-entry" href="{{ route('dashboard.student.room.main.quizes', [$room_id, $student->id]) }}">
                        <span class="sp-icon-box sp-icon-box--gold"><i class="mdi mdi-lightbulb-on-outline"></i></span>
                        <span class="sp-assessment-entry__content">
                            <strong>المذاكرات والاختبارات</strong>
                            <small>التقييمات القصيرة والأنشطة الصفية</small>
                        </span>
                        <i class="mdi mdi-arrow-left sp-assessment-entry__arrow"></i>
                    </a>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
