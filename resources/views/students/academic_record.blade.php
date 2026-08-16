@extends('students.layouts.app4')

@section('title', 'السجل الأكاديمي')

@section('css')
<style>
    .academic-record { direction: rtl; max-width: 980px; margin: 0 auto; }
    .academic-record__header, .academic-record__item { background: #fff; border: 1px solid #e4e8ef; border-radius: 14px; }
    .academic-record__header { padding: 22px; margin-bottom: 18px; }
    .academic-record__item { display: block; color: #152c4f; padding: 18px 20px; margin-bottom: 12px; transition: box-shadow .2s ease, transform .2s ease; }
    .academic-record__item:hover { color: #152c4f; transform: translateY(-1px); box-shadow: 0 8px 22px rgba(21, 44, 79, .08); }
    .academic-record__meta { display: flex; flex-wrap: wrap; gap: 8px 18px; color: #68758a; font-size: 13px; }
    .academic-record__status { color: #16805b; font-weight: 700; }
    @media (max-width: 575px) { .academic-record { padding: 0 10px; } }
</style>
@endsection

@section('content')
<div class="main-panel" style="background:#f8f9fb;">
    <div class="content-wrapper pb-5">
        <div class="academic-record">
            <div class="academic-record__header">
                <h2 class="mb-2">السجل الأكاديمي</h2>
                <p class="mb-0 text-muted">عرض السنوات والصفوف والغرف المرتبطة بحسابك.</p>
            </div>

            @forelse ($placements as $placement)
                <a class="academic-record__item" href="{{ route('dashboard.student.academic_record.show', $placement->id) }}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <h4 class="mb-2">{{ optional($placement->year)->name ?: 'عام دراسي غير محدد' }}</h4>
                        @if ($placement->status === 'active')
                            <span class="academic-record__status">الحالي</span>
                        @else
                            <span class="text-muted">سجل سابق</span>
                        @endif
                    </div>
                    <div class="academic-record__meta">
                        <span>الصف: {{ optional($placement->classRoom)->name ?: 'غير محدد' }}</span>
                        <span>الشعبة: {{ optional($placement->room)->name ?: 'غير محددة' }}</span>
                        @if ($placement->effective_from)
                            <span>من: {{ $placement->effective_from->format('Y-m-d') }}</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="academic-record__header text-center text-muted">لا توجد سجلات أكاديمية متاحة.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
