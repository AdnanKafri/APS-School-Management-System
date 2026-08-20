@extends('students.layouts.app4')

@section('title', 'النتائج غير متاحة')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page sp-page--centered">
            <section class="sp-state-card">
                <span class="sp-state-card__icon"><i class="mdi mdi-lock-clock"></i></span>
                <span class="sp-badge sp-badge--info">{{ $pageLabel }}</span>
                <h1>{{ $blockedTitle }}</h1>
                <p>{{ $blockedMessage }}</p>
                <small>سيتم إتاحة هذه الصفحة بعد مراجعة الدرجات واعتمادها بشكل نهائي.</small>
                <div class="sp-state-card__actions">
                    <a href="{{ route('dashboard.student.lessons', $student->id) }}" class="sp-btn sp-btn--primary">العودة إلى المواد</a>
                    <a href="{{ route('dashboard.student.profile', [$student->id, $room_id]) }}" class="sp-btn sp-btn--soft">الملف الشخصي</a>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
