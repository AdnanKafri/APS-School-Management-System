@extends('students.layouts.app4')

@section('title', 'تفاصيل السجل الأكاديمي')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            @php
                $isCurrentPlacement = $currentYear
                    && $placement->status === 'active'
                    && (int) $placement->year_id === (int) $currentYear->id;
            @endphp
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <a class="sp-page-header__eyebrow" href="{{ route('dashboard.student.academic_record') }}">
                        <i class="mdi mdi-arrow-right"></i> العودة إلى السجل الأكاديمي
                    </a>
                    <h1>{{ optional($placement->year)->name ?: 'عام دراسي غير محدد' }}</h1>
                    <div class="sp-meta-list sp-page-header__meta">
                        <span><i class="mdi mdi-school-outline"></i> {{ optional($placement->classRoom)->name ?: 'صف غير محدد' }}</span>
                        <span><i class="mdi mdi-door"></i> {{ optional($placement->room)->name ?: 'شعبة غير محددة' }}</span>
                        <span class="sp-badge {{ $isCurrentPlacement ? 'sp-badge--success' : 'sp-badge--warning' }}">
                            {{ $isCurrentPlacement ? 'القيد الحالي' : 'سجل تاريخي للعرض فقط' }}
                        </span>
                    </div>
                </div>
                <div class="sp-page-header__aside">
                    <div class="sp-header-stat"><span>المواد</span><strong>{{ count($markRows) }}</strong></div>
                    <div class="sp-header-stat"><span>التقييمات</span><strong>{{ count($assessmentRows) }}</strong></div>
                </div>
            </section>

            @unless ($isCurrentPlacement)
                <div class="sp-alert sp-alert--warning">
                    <i class="mdi mdi-lock-outline"></i>
                    هذا سجل أكاديمي تاريخي متاح للعرض فقط، وتبقى بياناته محفوظة ضمن عامها وشعبتها الأصلية.
                </div>
            @endunless

            <section class="sp-grid sp-grid--4 sp-summary-grid" aria-label="ملخص السجل">
                <div class="sp-summary-card"><span class="sp-icon-box"><i class="mdi mdi-book-education-outline"></i></span><span><strong>{{ count($markRows) }}</strong><small>سجلات المواد</small></span></div>
                <div class="sp-summary-card"><span class="sp-icon-box sp-icon-box--blue"><i class="mdi mdi-clipboard-check-outline"></i></span><span><strong>{{ count($assessmentRows) }}</strong><small>التقييمات</small></span></div>
                <div class="sp-summary-card"><span class="sp-icon-box sp-icon-box--gold"><i class="mdi mdi-file-document-outline"></i></span><span><strong>{{ $fileRows->count() }}</strong><small>الملفات والتسليمات</small></span></div>
                <div class="sp-summary-card"><span class="sp-icon-box sp-icon-box--red"><i class="mdi mdi-certificate-outline"></i></span><span><strong>{{ $reportRows->count() + $certificateRows->count() }}</strong><small>النتائج والشهادات</small></span></div>
            </section>

            <section class="sp-section sp-card">
                <div class="sp-card__header sp-section-header">
                    <div><h2>العلامات حسب المادة</h2><p>تفصيل العلامات الفصلية والنتيجة السنوية المسجلة.</p></div>
                </div>
                <div class="sp-card__body">
                    @if (empty($markRows))
                        <div class="sp-empty sp-empty--compact"><span class="sp-empty__icon"><i class="mdi mdi-chart-box-outline"></i></span><h3>لا توجد علامات قابلة للعرض</h3></div>
                    @else
                        <div class="sp-table-wrap">
                            <table class="sp-table">
                                <thead><tr><th>المادة</th><th>تفصيل العلامات</th><th>الفصل الأول</th><th>الفصل الثاني</th><th>النتيجة السنوية</th></tr></thead>
                                <tbody>
                                @foreach ($markRows as $row)
                                    <tr>
                                        <td data-label="المادة"><strong>{{ $row['subject'] }}</strong></td>
                                        <td data-label="التفاصيل">
                                            @if (empty($row['components']))
                                                <span class="sp-muted">لا توجد تفاصيل</span>
                                            @else
                                                <div class="sp-chip-list">
                                                    @foreach ($row['components'] as $component)
                                                        <span>{{ $component['label'] }}: <strong>{{ $component['value'] }}</strong></span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                        <td data-label="الفصل الأول">{{ $row['term_one'] ?: '—' }}</td>
                                        <td data-label="الفصل الثاني">{{ $row['term_two'] ?: '—' }}</td>
                                        <td data-label="النتيجة السنوية"><strong>{{ $row['year'] ?: '—' }}</strong></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>

            <section class="sp-section sp-card">
                <div class="sp-card__header sp-section-header">
                    <div><h2>الامتحانات والمذاكرات والاختبارات</h2><p>جميع التقييمات المرتبطة بهذا القيد الأكاديمي فقط.</p></div>
                    <span class="sp-badge sp-badge--info">{{ count($assessmentRows) }} تقييم</span>
                </div>
                <div class="sp-card__body">
                    @if (empty($assessmentRows))
                        <div class="sp-empty sp-empty--compact"><span class="sp-empty__icon"><i class="mdi mdi-clipboard-text-off-outline"></i></span><h3>لا توجد تقييمات قابلة للعرض</h3></div>
                    @else
                        <div class="sp-table-wrap">
                            <table class="sp-table">
                                <thead><tr><th>النوع</th><th>المادة</th><th>التقييم</th><th>الفصل</th><th>العلامة</th></tr></thead>
                                <tbody>
                                @foreach ($assessmentRows as $row)
                                    @php
                                        $typeClass = $row['type'] === 'امتحان' ? 'sp-badge--danger' : ($row['type'] === 'مذاكرة' ? 'sp-badge--warning' : 'sp-badge--info');
                                    @endphp
                                    <tr>
                                        <td data-label="النوع"><span class="sp-badge {{ $typeClass }}">{{ $row['type'] }}</span></td>
                                        <td data-label="المادة">{{ $row['subject'] }}</td>
                                        <td data-label="التقييم"><strong>{{ $row['name'] }}</strong></td>
                                        <td data-label="الفصل">{{ $row['term'] }}</td>
                                        <td data-label="العلامة"><strong>{{ $row['result'] }}</strong>@if ($row['maximum']) <span class="sp-muted">/ {{ $row['maximum'] }}</span>@endif</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>

            <div class="sp-grid sp-grid--2 sp-section">
                <section class="sp-card">
                    <div class="sp-card__header"><h2 class="sp-card__title">الملفات والتسليمات</h2><p class="sp-card__meta">الملفات المسجلة ضمن هذا القيد.</p></div>
                    <div class="sp-card__body">
                        @if ($fileRows->isEmpty())
                            <div class="sp-empty sp-empty--compact"><span class="sp-empty__icon"><i class="mdi mdi-file-hidden"></i></span><h3>لا توجد ملفات مرتبطة</h3></div>
                        @else
                            <div class="sp-list">
                                @foreach ($fileRows as $row)
                                    <div class="sp-list__item"><span class="sp-icon-box"><i class="mdi mdi-file-check-outline"></i></span><span><strong>{{ $row['subject'] }}</strong><small>{{ $row['type'] }} · {{ $row['format'] }}</small></span></div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>

                <section class="sp-card">
                    <div class="sp-card__header"><h2 class="sp-card__title">بطاقات النتائج والشهادات</h2><p class="sp-card__meta">الوثائق الأكاديمية المحفوظة.</p></div>
                    <div class="sp-card__body">
                        @if ($reportRows->isEmpty() && $certificateRows->isEmpty())
                            <div class="sp-empty sp-empty--compact"><span class="sp-empty__icon"><i class="mdi mdi-certificate-outline"></i></span><h3>لا توجد وثائق مرتبطة</h3></div>
                        @else
                            <div class="sp-list">
                                @foreach ($reportRows as $row)
                                    <div class="sp-list__item"><span class="sp-icon-box sp-icon-box--blue"><i class="mdi mdi-card-account-details-star-outline"></i></span><span><strong>{{ $row['status'] }}</strong><small>الحضور: {{ $row['attendance'] ?: 'غير مسجل' }}</small></span></div>
                                @endforeach
                                @foreach ($certificateRows as $row)
                                    <div class="sp-list__item"><span class="sp-icon-box sp-icon-box--gold"><i class="mdi mdi-certificate-outline"></i></span><span><strong>{{ $row['subject'] }}</strong><small>{{ $row['label'] }}</small></span></div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>
@endsection
