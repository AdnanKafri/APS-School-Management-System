@extends('students.layouts.app4')

@section('title', 'النتائج والعلامات')

@section('content')
<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <span class="sp-page-header__eyebrow">الجلاء المدرسي</span>
                    <h1>النتائج والعلامات</h1>
                    <p>المحصلات الفصلية والدرجات التفصيلية المسجلة للعام الحالي.</p>
                </div>
                <div class="sp-page-header__aside">
                    <div class="sp-header-stat"><span>الصف</span><strong>{{ optional($class)->name ?: 'غير محدد' }}</strong></div>
                    <div class="sp-header-stat"><span>الشعبة</span><strong>{{ optional($room)->name ?: 'غير محددة' }}</strong></div>
                </div>
            </section>

            @if ($student_mark)
                @php
                    $termTotals = json_decode($student_mark->term_result, true) ?: [];
                    $termOne = json_decode($student_mark->result1, true) ?: [];
                    $termTwo = json_decode($student_mark->result2, true) ?: [];
                    $yearResults = json_decode($student_mark->result, true) ?: [];
                @endphp

                <section class="sp-grid sp-grid--3 sp-summary-grid">
                    @foreach ($termTotals as $index => $value)
                        <div class="sp-summary-card">
                            <span class="sp-icon-box {{ $loop->first ? 'sp-icon-box--blue' : '' }}"><i class="mdi mdi-chart-donut"></i></span>
                            <span><strong>{{ round($value) }}</strong><small>مجموع الفصل {{ $loop->iteration === 1 ? 'الأول' : 'الثاني' }}</small></span>
                        </div>
                    @endforeach
                    <div class="sp-summary-card">
                        <span class="sp-icon-box sp-icon-box--gold"><i class="mdi mdi-trophy-outline"></i></span>
                        <span><strong>{{ round($student_mark->year_result) }}</strong><small>المجموع النهائي للفصلين</small></span>
                    </div>
                </section>

                <section class="sp-card sp-section">
                    <div class="sp-card__header sp-section-header">
                        <div><h2>الدرجات التفصيلية</h2><p>نتائج المواد للفصلين والنتيجة السنوية.</p></div>
                    </div>
                    <div class="sp-card__body">
                        <div class="sp-table-wrap">
                            <table class="sp-table">
                                <thead>
                                    <tr><th>المادة</th><th>أعمال الفصل الأول</th><th>امتحان الفصل الأول</th><th>محصلة الفصل الأول</th><th>أعمال الفصل الثاني</th><th>امتحان الفصل الثاني</th><th>محصلة الفصل الثاني</th><th>المجموع السنوي</th><th>المتوسط</th></tr>
                                </thead>
                                <tbody>
                                @foreach ($lessons as $lesson)
                                    @php
                                        $first = $termOne[$lesson->id] ?? [];
                                        $second = $termTwo[$lesson->id] ?? [];
                                        $yearRow = $yearResults[$lesson->id] ?? [];
                                        $yearValue = $yearRow['year_result'] ?? null;
                                    @endphp
                                    <tr>
                                        <td data-label="المادة"><strong>{{ $lesson->name }}</strong></td>
                                        <td data-label="أعمال الفصل الأول">{{ $first['term1_quizes'] ?? '—' }}</td>
                                        <td data-label="امتحان الفصل الأول">{{ $first['term1_exam'] ?? '—' }}</td>
                                        <td data-label="محصلة الفصل الأول"><strong>{{ $first['term1_result'] ?? '—' }}</strong></td>
                                        <td data-label="أعمال الفصل الثاني">{{ $second['term2_quizes'] ?? '—' }}</td>
                                        <td data-label="امتحان الفصل الثاني">{{ $second['term2_exam'] ?? '—' }}</td>
                                        <td data-label="محصلة الفصل الثاني"><strong>{{ $second['term2_result'] ?? '—' }}</strong></td>
                                        <td data-label="المجموع السنوي"><strong>{{ $yearValue !== null ? $yearValue : '—' }}</strong></td>
                                        <td data-label="المتوسط">{{ $yearValue !== null ? round($yearValue / 2, 2) : '—' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            @else
                <div class="sp-empty"><span class="sp-empty__icon"><i class="mdi mdi-chart-box-outline"></i></span><h3>لا توجد نتائج متاحة حالياً</h3><p>ستظهر النتائج هنا بعد اعتمادها ونشرها.</p></div>
            @endif
        </div>
    </div>
</main>
@endsection
