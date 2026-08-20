@extends('students.layouts.app4')

@section('title', 'الكتب المدرسية')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            @php
                $bookCount = 0;
                foreach ($classes->lessons as $bookLesson) {
                    $bookCount += $bookLesson->books ? count(json_decode($bookLesson->books) ?: []) : 0;
                }
            @endphp
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <a class="sp-page-header__eyebrow" href="{{ route('dashboard.student.lessons', $student->id) }}">الصفحة الرئيسية</a>
                    <h1>الكتب المدرسية</h1>
                    <p>كتب صفك الدراسي مرتبة وجاهزة للفتح أو التنزيل.</p>
                </div>
                <div class="sp-page-header__aside"><div class="sp-header-stat"><span>الكتب المتاحة</span><strong>{{ $bookCount }}</strong></div></div>
            </section>

            <section class="sp-section">
                <div class="sp-grid sp-grid--auto">
                    @php $renderedBooks = 0; @endphp
                    @foreach ($classes->lessons as $bookLesson)
                        @foreach (json_decode($bookLesson->books ?: '[]') ?: [] as $item)
                            @php
                                $renderedBooks++;
                                $bookName = str_replace('_', '-', app()->getLocale()) === 'en' ? $item->name_en : $item->name_ar;
                                $bookUrl = $item->type === 'link' ? $item->value : asset('storage/' . $item->value);
                            @endphp
                            <article class="sp-card sp-file-card">
                                <div class="sp-card__body">
                                    <span class="sp-icon-box sp-icon-box--gold"><i class="mdi mdi-book-open-page-variant"></i></span>
                                    <div><span class="sp-badge sp-badge--info">{{ $bookLesson->name }}</span><h3 class="sp-card__title">{{ $bookName }}</h3><p class="sp-card__meta">كتاب مدرسي</p></div>
                                </div>
                                <div class="sp-card__footer"><a class="sp-btn sp-btn--primary sp-btn--block" href="{{ $bookUrl }}" target="_blank" rel="noopener"><i class="mdi mdi-download-outline"></i> فتح الكتاب</a></div>
                            </article>
                        @endforeach
                    @endforeach
                    @if ($renderedBooks === 0)
                        <div class="sp-empty"><span class="sp-empty__icon"><i class="mdi mdi-book-off-outline"></i></span><h3>لا توجد كتب متاحة</h3><p>ستظهر الكتب هنا عند إضافتها إلى مواد صفك.</p></div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
