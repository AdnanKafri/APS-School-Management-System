@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a href="{{ route('admin.gradebook.settings') }}" class="breadcrumbs__item">إعدادات التوزيع</a>
        <a class="breadcrumbs__item is-active">المواد الدراسية</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-primary"><i class="fas fa-book"></i> مواد الشعبة: {{ $room->name }}</h4>
            <span class="text-muted small">انقر على المادة لضبط توزيع العلامات</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>المادة (Subject)</th>
                            <th>المعلم</th>
                            <th>حالة التكوين</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                            @php
                                // Configs are passed from controller. Robust against missing table.
                                $configC = isset($configs) ? $configs->get($subject->id) : null;
                                $hasConfig = $configC ? true : false;
                                $configStr = $hasConfig 
                                    ? "Oral: {$configC->oral_max}, HW: {$configC->homework_max}, Exam: {$configC->exam_max}" 
                                    : "افتراضي";
                            @endphp
                            <tr>
                                <td class="font-weight-bold align-middle">{{ $subject->name }}</td>
                                <td class="align-middle">{{ optional($subject->teacher)->full_name ?? '-' }}</td>
                                <td class="align-middle">
                                    @if($hasConfig) 
                                        <span class="badge badge-success p-2">{{ $configStr }}</span>
                                    @else
                                        <span class="badge badge-warning p-2">غير محدد (افتراضي)</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.gradebook.settings.edit', $subject->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-cogs"></i> إعداد التوزيع
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4">لا توجد مواد</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
