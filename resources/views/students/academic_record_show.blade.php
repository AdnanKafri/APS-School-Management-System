@extends('students.layouts.app4')

@section('title', 'السجل الأكاديمي')

@section('css')
<style>
    .academic-record { direction: rtl; max-width: 1040px; margin: 0 auto; }
    .academic-record__panel { background: #fff; border: 1px solid #e4e8ef; border-radius: 14px; padding: 20px; margin-bottom: 16px; }
    .academic-record__summary, .academic-record__chips { display: flex; flex-wrap: wrap; gap: 8px 18px; color: #68758a; }
    .academic-record__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(155px, 1fr)); gap: 10px; }
    .academic-record__count { padding: 14px; background: #f6f8fc; border-radius: 10px; text-align: center; }
    .academic-record__count strong { display: block; color: #152c4f; font-size: 22px; }
    .academic-record__table { width: 100%; border-collapse: collapse; }
    .academic-record__table th, .academic-record__table td { border-bottom: 1px solid #edf0f5; padding: 11px 8px; text-align: right; vertical-align: top; }
    .academic-record__table th { color: #68758a; font-size: 13px; white-space: nowrap; }
    .academic-record__table td { color: #263853; }
    .academic-record__chips span { background: #f4f7fb; border-radius: 999px; padding: 4px 9px; font-size: 12px; }
    .academic-record__empty { color: #8a96a8; }
    .academic-record__type { font-weight: 700; color: #245da8; white-space: nowrap; }
    @media (max-width: 575px) {
        .academic-record { padding: 0 10px; }
        .academic-record__table { display: block; overflow-x: auto; white-space: nowrap; }
        .academic-record__panel { padding: 15px; }
    }
</style>
@endsection

@section('content')
<div class="main-panel" style="background:#f8f9fb;">
    <div class="content-wrapper pb-5">
        <div class="academic-record">
            <div class="academic-record__panel">
                <a href="{{ route('dashboard.student.academic_record') }}" class="btn btn-light mb-3">العودة إلى السجل</a>
                <h2 class="mb-3">{{ optional($placement->year)->name ?: 'عام دراسي غير محدد' }}</h2>
                <div class="academic-record__summary">
                    <span>الصف: {{ optional($placement->classRoom)->name ?: 'غير محدد' }}</span>
                    <span>الشعبة: {{ optional($placement->room)->name ?: 'غير محددة' }}</span>
                    <span>{{ $placement->status === 'active' ? 'القيد الحالي' : 'قيد تاريخي للعرض فقط' }}</span>
                </div>
            </div>

            <div class="academic-record__panel">
                <div class="academic-record__grid">
                    <div class="academic-record__count"><strong>{{ count($markRows) }}</strong>سجلات المواد</div>
                    <div class="academic-record__count"><strong>{{ $reportRows->count() }}</strong>بطاقات النتائج</div>
                    <div class="academic-record__count"><strong>{{ count($assessmentRows) }}</strong>التقييمات</div>
                    <div class="academic-record__count"><strong>{{ $fileRows->count() }}</strong>الملفات والتسليمات</div>
                    <div class="academic-record__count"><strong>{{ $certificateRows->count() }}</strong>الشهادات</div>
                </div>
            </div>

            <div class="academic-record__panel">
                <h4>العلامات حسب المادة</h4>
                @if (empty($markRows))
                    <p class="academic-record__empty mb-0">لا توجد علامات قابلة للعرض لهذا القيد.</p>
                @else
                    <table class="academic-record__table">
                        <thead><tr><th>المادة</th><th>تفصيل العلامات</th><th>الفصل الأول</th><th>الفصل الثاني</th><th>النتيجة السنوية</th></tr></thead>
                        <tbody>
                        @foreach ($markRows as $row)
                            <tr>
                                <td><strong>{{ $row['subject'] }}</strong></td>
                                <td>
                                    @if (empty($row['components']))
                                        <span class="academic-record__empty">لا توجد تفاصيل</span>
                                    @else
                                        <div class="academic-record__chips">
                                            @foreach ($row['components'] as $component)
                                                <span>{{ $component['label'] }}: {{ $component['value'] }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $row['term_one'] ?: '—' }}</td>
                                <td>{{ $row['term_two'] ?: '—' }}</td>
                                <td>{{ $row['year'] ?: '—' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="academic-record__panel">
                <h4>الامتحانات والمذاكرات والاختبارات</h4>
                @if (empty($assessmentRows))
                    <p class="academic-record__empty mb-0">لا توجد تقييمات قابلة للعرض لهذا القيد.</p>
                @else
                    <table class="academic-record__table">
                        <thead><tr><th>النوع</th><th>المادة</th><th>التقييم</th><th>الفصل</th><th>العلامة</th></tr></thead>
                        <tbody>
                        @foreach ($assessmentRows as $row)
                            <tr>
                                <td class="academic-record__type">{{ $row['type'] }}</td>
                                <td>{{ $row['subject'] }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td>{{ $row['term'] }}</td>
                                <td>{{ $row['result'] }}@if ($row['maximum']) / {{ $row['maximum'] }}@endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="academic-record__panel">
                <h4>الملفات والتسليمات</h4>
                @if ($fileRows->isEmpty())
                    <p class="academic-record__empty mb-0">لا توجد ملفات أو تسليمات مرتبطة بهذا القيد.</p>
                @else
                    <table class="academic-record__table">
                        <thead><tr><th>النوع</th><th>المادة</th><th>الملف</th></tr></thead>
                        <tbody>
                        @foreach ($fileRows as $row)
                            <tr><td>{{ $row['type'] }}</td><td>{{ $row['subject'] }}</td><td>{{ $row['format'] }}</td></tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="academic-record__panel">
                <h4>بطاقات النتائج والشهادات</h4>
                @if ($reportRows->isEmpty() && $certificateRows->isEmpty())
                    <p class="academic-record__empty mb-0">لا توجد بطاقات نتائج أو شهادات مرتبطة بهذا القيد.</p>
                @else
                    @if ($reportRows->isNotEmpty())
                        <h6>بطاقات النتائج</h6>
                        <table class="academic-record__table mb-3">
                            <thead><tr><th>النتيجة النهائية</th><th>الحضور</th></tr></thead>
                            <tbody>@foreach ($reportRows as $row)<tr><td>{{ $row['status'] }}</td><td>{{ $row['attendance'] ?: '—' }}</td></tr>@endforeach</tbody>
                        </table>
                    @endif
                    @if ($certificateRows->isNotEmpty())
                        <h6>الشهادات</h6>
                        <table class="academic-record__table">
                            <thead><tr><th>المادة</th><th>الوثيقة</th></tr></thead>
                            <tbody>@foreach ($certificateRows as $row)<tr><td>{{ $row['subject'] }}</td><td>{{ $row['label'] }}</td></tr>@endforeach</tbody>
                        </table>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
