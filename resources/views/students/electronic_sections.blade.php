@extends('students.layouts.app4')

@section('title', 'الملفات الإلكترونية')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <a class="sp-page-header__eyebrow" href="{{ route('dashboard.student.lessons', $student->id) }}">الصفحة الرئيسية</a>
                    <h1>الملفات الإلكترونية</h1>
                    <p>مصادر وملفات مساندة منظمة بحسب الأقسام.</p>
                </div>
                <div class="sp-page-header__aside">
                    <div class="sp-header-stat"><span>الأقسام المتاحة</span><strong>{{ $electronic_sections->count() }}</strong></div>
                </div>
            </section>

            <section class="sp-section">
                <div class="sp-grid sp-grid--auto">
                    @forelse ($electronic_sections as $item)
                        <a class="sp-resource-card" href="{{ route('student_electronic_files', ['id' => $item->id]) }}">
                            <span class="sp-resource-card__icon"><i class="mdi mdi-folder-multiple-outline"></i></span>
                            <span class="sp-resource-card__content"><strong>{{ $item->name_section }}</strong><small>استعراض ملفات القسم</small></span>
                            <i class="mdi mdi-chevron-left sp-resource-card__arrow"></i>
                        </a>
                    @empty
                        <div class="sp-empty"><span class="sp-empty__icon"><i class="mdi mdi-folder-off-outline"></i></span><h3>لا توجد أقسام إلكترونية</h3><p>ستظهر الأقسام هنا عند إضافتها لصفك الدراسي.</p></div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
