@extends('admin.layouts.v2')

@section('page_title', 'الترقية السنوية')
@section('page_subtitle', 'إعداد توزيع الطلاب للعام الدراسي التالي دون تعديل السجل الأكاديمي السابق')

@section('style')
<style>
    .year-end-page { direction: rtl; text-align: right; }
    .year-end-card { background: #fff; border: 1px solid #e9e5f2; border-radius: 18px; box-shadow: 0 8px 24px rgba(35, 27, 64, .06); margin-bottom: 18px; padding: 18px; }
    .year-end-toolbar { display:flex; gap:10px; align-items:center; justify-content:space-between; flex-wrap:wrap; }
    .year-end-table { min-width: 1080px; }
    .year-end-table th, .year-end-table td { vertical-align: middle; }
    .year-end-table select { min-width: 150px; }
    .year-end-filters { display:grid; grid-template-columns:minmax(220px,1.5fr) repeat(2,minmax(170px,1fr)); gap:10px; }
    .year-end-count { color:#6d6780; font-size:.9rem; }
    .year-end-hidden { display:none !important; }
    .year-end-note { color:#6d6780; font-size:.9rem; }
    .year-end-prepared { color:#176b4d; font-weight:700; }
    @media (max-width: 768px) { .year-end-card { padding: 12px; } .year-end-table-wrap { overflow-x:auto; } }
</style>
@endsection

@section('content')
<div class="year-end-page">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if(session('warning'))<div class="alert alert-warning">{{ session('warning') }}</div>@endif
    @if(session('year_end_failures'))
        <div class="alert alert-warning">
            <strong>تعذر إعداد بعض الطلاب:</strong>
            <ul class="mb-0 mt-2">
                @foreach(session('year_end_failures') as $failure)
                    <li><strong>{{ $failure['student_name'] }}</strong>: {{ $failure['reason'] }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="year-end-card">
        <div class="year-end-toolbar">
            <div>
                <h3 class="mb-1">الترقية إلى العام الدراسي التالي</h3>
                <p class="year-end-note mb-0">لا يتم تفعيل العام الجديد من هذه الصفحة، ولا يتم نسخ أي علامات أو سجلات مالية.</p>
            </div>
            <form method="POST" action="{{ route('admin.year_end.clone_rooms') }}">@csrf
                <button class="btn btn-outline-primary" type="submit" {{ !$targetYear ? 'disabled' : '' }}>تجهيز العام الدراسي التالي</button>
            </form>
        </div>
        <p class="year-end-note mt-2 mb-0">تجهيز الشعب ينسخ بنية الشعب وأسماءها من العام الحالي إلى العام التالي فقط، ولا ينقل طلاباً ولا علامات ولا بيانات مالية.</p>
        <div class="row mt-3">
            <div class="col-md-6"><strong>العام الحالي:</strong> {{ optional($sourceYear)->name ?: 'غير محدد' }}</div>
            <div class="col-md-6"><strong>العام التالي:</strong> {{ optional($configuredTargetYear)->name ?: 'غير مرتبط' }} @if($yearConfigurationError)<span class="text-danger">(غير صالح)</span>@endif</div>
        </div>
        @if($yearConfigurationError)<div class="alert alert-warning mt-3 mb-0">{{ $yearConfigurationError }}</div>@endif
    </div>

    @if($targetYear)
    <div class="year-end-card">
        <div class="row text-center mb-3">
            <div class="col-md-3"><strong class="d-block">الشعب الحالية</strong><span>{{ $currentSectionCatalog->count() }}</span></div>
            <div class="col-md-3"><strong class="d-block">شعب العام التالي</strong><span>{{ $rooms->count() }}</span></div>
            <div class="col-md-3"><strong class="d-block">الطلاب المرحلون</strong><span>{{ $enrollments->pluck('student_id')->unique()->count() }}</span></div>
            <div class="col-md-3"><strong class="d-block">المجهزون مسبقاً</strong><span>{{ $preparedPlacements->count() }}</span></div>
        </div>
        <p class="year-end-note">سيتم نقل كل طالب إلى الشعبة المطابقة له بالاسم والصف في العام التالي. بعد تفعيل العام الجديد يمكن استخدام نقل الصف أو الشعبة للتعديلات الفردية.</p>
        <div class="year-end-table-wrap">
            <table class="table table-hover year-end-table">
                <thead><tr><th>الطالب</th><th>الصف / الشعبة الحالية</th><th>الشعبة المطابقة في العام التالي</th><th>الحالة</th></tr></thead>
                <tbody>
                @forelse($rolloverPreview as $enrollment)
                    @php($student = $enrollment->student)
                    @php($prepared = $preparedPlacements->get($student->id))
                    <tr>
                        <td>{{ trim($student->first_name.' '.$student->last_name) }}</td>
                        <td>{{ optional($enrollment->sourceRoom->classes)->name }} / {{ $enrollment->sourceRoom->name }}</td>
                        <td>{{ $enrollment->targetRoom ? optional($enrollment->targetRoom->classes)->name . ' / ' . $enrollment->targetRoom->name : 'غير مجهزة بعد' }}</td>
                        <td class="year-end-prepared">
                            @if($prepared)
                                {{ __('year_end.errors.prepared_destination', ['year' => optional($targetYear)->name, 'class' => optional($prepared->classRoom)->name, 'section' => optional($prepared->room)->name]) }}
                            @else
                                {{ __('year_end.errors.pending_status') }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">لا يوجد طلاب مرتبطون بالعام الحالي.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
