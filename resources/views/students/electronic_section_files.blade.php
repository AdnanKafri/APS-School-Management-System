@extends('students.layouts.app4')

@section('title', 'ملفات ' . $electronic_sections->name_section)

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <a class="sp-page-header__eyebrow" href="{{ route('student_electronic_sections') }}"><i class="mdi mdi-arrow-right"></i> الأقسام الإلكترونية</a>
                    <h1>{{ $electronic_sections->name_section }}</h1>
                    <p>الملفات والروابط التعليمية المتاحة في هذا القسم.</p>
                </div>
                <div class="sp-page-header__aside">
                    <div class="sp-header-stat"><span>عدد الملفات</span><strong>{{ $electronic_files->count() }}</strong></div>
                </div>
            </section>

            <section class="sp-section">
                <div class="sp-grid sp-grid--auto">
                    @forelse ($electronic_files as $item)
                        @php $fileUrl = !empty($item->link) ? $item->link : asset('website/assets/files/' . $item->file); @endphp
                        <article class="sp-card sp-file-card">
                            <div class="sp-card__body">
                                <span class="sp-icon-box sp-icon-box--blue"><i class="mdi mdi-file-document-outline"></i></span>
                                <div><h3 class="sp-card__title">{{ $item->file_name }}</h3><p class="sp-card__meta">ملف تعليمي متاح للفتح أو التنزيل</p></div>
                            </div>
                            <div class="sp-card__footer">
                                <a class="sp-btn sp-btn--primary sp-btn--block" href="{{ $fileUrl }}" target="_blank" rel="noopener"><i class="mdi mdi-download-outline"></i> فتح الملف</a>
                            </div>
                        </article>
                    @empty
                        <div class="sp-empty"><span class="sp-empty__icon"><i class="mdi mdi-file-hidden"></i></span><h3>لا توجد ملفات في هذا القسم</h3><p>ستظهر الملفات هنا عند نشرها.</p></div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
