@extends('students.layouts.app4')

@section('title', 'السجل الأكاديمي')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <span class="sp-page-header__eyebrow">رحلتك الدراسية</span>
                    <h1>السجل الأكاديمي</h1>
                    <p>استعرض القيد الحالي والسنوات الدراسية السابقة دون خلط البيانات بينها.</p>
                </div>
                <div class="sp-page-header__aside">
                    <div class="sp-header-stat">
                        <span>السنوات المسجلة</span>
                        <strong>{{ $placements->count() }}</strong>
                    </div>
                </div>
            </section>

            <section class="sp-section">
                <div class="sp-timeline">
                    @forelse ($placements as $placement)
                        @php
                            $isCurrent = $currentYear
                                && $placement->status === 'active'
                                && (int) $placement->year_id === (int) $currentYear->id;
                        @endphp
                        <a class="sp-record-card {{ $isCurrent ? 'is-current' : '' }}" href="{{ route('dashboard.student.academic_record.show', $placement->id) }}">
                            <span class="sp-record-card__marker"><i class="mdi {{ $isCurrent ? 'mdi-school' : 'mdi-history' }}"></i></span>
                            <span class="sp-record-card__content">
                                <span class="sp-record-card__topline">
                                    <strong>{{ optional($placement->year)->name ?: 'عام دراسي غير محدد' }}</strong>
                                    <span class="sp-badge {{ $isCurrent ? 'sp-badge--success' : 'sp-badge--info' }}">{{ $isCurrent ? 'الحالي' : 'سجل سابق' }}</span>
                                </span>
                                <span class="sp-meta-list">
                                    <span><i class="mdi mdi-school-outline"></i> الصف: {{ optional($placement->classRoom)->name ?: 'غير محدد' }}</span>
                                    <span><i class="mdi mdi-door"></i> الشعبة: {{ optional($placement->room)->name ?: 'غير محددة' }}</span>
                                    @if ($placement->effective_from)
                                        <span><i class="mdi mdi-calendar-start"></i> منذ {{ $placement->effective_from->format('Y-m-d') }}</span>
                                    @endif
                                </span>
                            </span>
                            <i class="mdi mdi-chevron-left sp-record-card__arrow"></i>
                        </a>
                    @empty
                        <div class="sp-empty">
                            <span class="sp-empty__icon"><i class="mdi mdi-history"></i></span>
                            <h3>لا يوجد سجل أكاديمي متاح</h3>
                            <p>ستظهر السنوات الدراسية هنا بعد تسجيل القيد الأكاديمي.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</main>
@endsection
