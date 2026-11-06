@extends('students.layouts.app4')
@section('title', 'نتيجة التقييم')
@section('content')
<main class="main-panel"><div class="content-wrapper"><div class="sp-page">
    <section class="sp-page-header">
        <div class="sp-page-header__content">
            <a class="sp-page-header__eyebrow" href="{{ route('student_exam') }}">الامتحانات والتقييمات</a>
            <h1>{{ optional($content->lesson)->name ?: 'مادة غير محددة' }}</h1>
            <p>{{ $content->name }}</p>
        </div>
    </section>
    <section class="sp-card sp-section"><div class="sp-card__body">
        <p class="sp-muted">{{ optional($room->classes)->name }} · {{ $room->name }} · {{ optional($room->year)->name }} · {{ $term->term }}</p>
        @php($value = \App\Services\GradebookReadService::number($exam_result->result))
        @if ($value !== null)
            <div class="sp-assessment-result"><span>{{ __('student_assessments.result') }}</span><strong dir="ltr">{{ $value }}@if ($content->mark > 0) / {{ $content->mark }}@endif</strong></div>
        @else
            <p>{{ __('student_assessments.unentered') }}</p>
        @endif
    </div></section>
</div></div></main>
@endsection
