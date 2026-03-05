@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a href="{{ route('admin.gradebook.view_options') }}" class="breadcrumbs__item">خيارات العرض</a>
        <a class="breadcrumbs__item is-active">جدول العلامات</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-primary">
                <i class="fas fa-table"></i> دفتر العلامات: {{ $subject->name }} <span class="text-muted">({{ $section ? $section->name : 'غير محدد' }})</span>
            </h4>
            <div>
                <button class="btn btn-outline-success btn-sm disabled"><i class="fas fa-file-excel"></i> تصدير Excel</button>
                <button class="btn btn-outline-primary btn-sm" onclick="window.print()"><i class="fas fa-print"></i> طباعة</button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>الطالب</th>
                            <th>Term 1 Data</th>
                            <th>Term 2 Data</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            @php
                                $markRecord = $marks[$student->id] ?? null;
                                $term1 = $markRecord && $markRecord->mark ? json_decode($markRecord->mark, true) : null;
                                $term2 = $markRecord && $markRecord->mark2 ? json_decode($markRecord->mark2, true) : null;

                                // Helper function to display array nicely
                                $formatMarks = function($data) {
                                    if(empty($data)) return '<span class="text-muted">—</span>';
                                    $html = '<ul class="list-unstyled mb-0 text-left small">';
                                    $total = 0;
                                    foreach($data as $key => $val) {
                                        // Filter for in-person keys only if needed, 
                                        // but for now display all found in the 'mark' column (which is in-person)
                                        // Online marks are usually in a different table or logic, 
                                        // or specific keys like 'online_exam'.
                                        // We display what's there as requested.
                                        $html .= "<li><strong>{$key}:</strong> {$val}</li>";
                                        if(is_numeric($val)) $total += $val;
                                    }
                                    $html .= "<li class='border-top mt-1 pt-1 text-primary'><strong>Total: {$total}</strong></li>";
                                    $html .= '</ul>';
                                    return $html;
                                };
                            @endphp
                            <tr>
                                <td class="text-right font-weight-bold align-middle">{{ $student->name_ar }}</td>
                                <td class="align-middle">{!! $formatMarks($term1) !!}</td>
                                <td class="align-middle">{!! $formatMarks($term2) !!}</td>
                                <td class="align-middle">
                                    @if($markRecord && $markRecord->notes)
                                        {{ $markRecord->notes }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <h5 class="text-muted">لا يوجد طلاب في هذه الشعبة</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-center">
            <p class="text-muted mb-0">عرض بيانات حقيقية (للقراءة فقط)</p>
        </div>
    </div>
</div>
@endsection
