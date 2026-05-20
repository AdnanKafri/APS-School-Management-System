@extends('admin.layouts.v2')

@section('page_title', 'إدارة الشكاوى')
@section('page_subtitle', 'مراجعة الشكاوى الدراسية وشكاوى النقل مع الحفاظ على سجل حالة واضح')

@section('style')
<style>
    .complaints-admin {
        direction: rtl;
        text-align: right;
    }

    .complaints-admin .v2-card.main-shell {
        padding: 1.2rem;
    }

    .complaints-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(260px, .72fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .complaints-hero .intro-card,
    .complaints-hero .info-card {
        border: 1px solid #ebe7f5;
        border-radius: 18px;
        background: linear-gradient(180deg, #fff 0%, #fcfbff 100%);
        padding: 1rem 1.05rem;
        box-shadow: 0 10px 26px rgba(36, 30, 62, 0.05);
    }

    .complaints-hero h3 {
        margin: 0 0 .35rem;
        font-size: 1.18rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .complaints-hero p {
        margin: 0;
        color: #746f84;
        line-height: 1.8;
        font-size: .92rem;
    }

    .complaints-tabs,
    .complaints-status-filters {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .complaints-tab,
    .complaints-filter {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        border: 1px solid #e4e0ef;
        border-radius: 999px;
        padding: .5rem .85rem;
        background: #fff;
        color: #4d4762;
        font-weight: 700;
        font-size: .88rem;
        text-decoration: none;
        transition: all .2s ease;
    }

    .complaints-tab:hover,
    .complaints-filter:hover {
        text-decoration: none;
        border-color: #5b4b8a;
        color: #5b4b8a;
        transform: translateY(-1px);
    }

    .complaints-tab.is-active,
    .complaints-filter.is-active {
        background: #5b4b8a;
        border-color: #5b4b8a;
        color: #fff;
    }

    .complaints-tab .badge,
    .complaints-filter .badge {
        border-radius: 999px;
        background: rgba(255,255,255,.18);
        color: inherit;
    }

    .complaints-table-card {
        border: 1px solid #ebe7f5;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 26px rgba(36, 30, 62, 0.05);
        overflow: hidden;
    }

    .complaints-table-wrap {
        overflow-x: auto;
    }

    .complaints-table {
        width: 100%;
        margin: 0;
    }

    .complaints-table thead th {
        background: #f7f5fb;
        color: #4d4762;
        font-size: .82rem;
        font-weight: 800;
        border-bottom: 1px solid #ebe7f5;
        white-space: nowrap;
    }

    .complaints-table tbody td {
        vertical-align: middle;
        color: #2f2b3a;
        font-size: .9rem;
    }

    .complaints-table .text-wrap {
        max-width: 280px;
        white-space: normal;
        word-break: break-word;
    }

    .complaints-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .3rem .65rem;
        border-radius: 999px;
        font-size: .76rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .complaints-badge.is-new {
        background: #eefaf3;
        color: #1f8f5f;
    }

    .complaints-badge.is-viewed {
        background: #eef6ff;
        color: #2f6fc8;
    }

    .complaints-badge.is-archived {
        background: #f3f1f8;
        color: #6d6781;
    }

    .complaints-empty {
        padding: 2rem 1rem;
        text-align: center;
        color: #7b7590;
    }

    .complaints-empty h4 {
        margin: 0 0 .35rem;
        color: #2f2b3a;
        font-weight: 800;
    }

    @media (max-width: 992px) {
        .complaints-hero {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a class="breadcrumbs__item is-active">إدارة الشكاوى</a>
</nav>
@endsection

@section('content')
@php
    $type = $typeFilter ?? 'all';
    $status = $statusFilter ?? 'all';
    $tabClass = function ($current, $expected) {
        return $current === $expected ? 'is-active' : '';
    };
    $statusLabel = function ($value) {
        return [
            'new' => 'جديدة',
            'viewed' => 'تمت المراجعة',
            'archived' => 'مؤرشفة',
        ][$value] ?? 'جديدة';
    };
    $typeLabel = function ($value) {
        return $value === 'transport' ? 'شكاوى النقل' : 'الشكاوى الدراسية';
    };
@endphp

<div class="complaints-admin">
    <div class="v2-card main-shell">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="complaints-hero">
            <div class="intro-card">
                <h3>إدارة الشكاوى</h3>
                <p>هذه الصفحة تجمع شكاوى الطلبة وأولياء الأمور في مسار بسيط وواضح، مع فصل الشكاوى الدراسية عن شكاوى النقل.</p>
            </div>
            <div class="info-card">
                <h3>حالة المراجعة</h3>
                <p>يمكنك فتح أي شكوى، مراجعة التفاصيل، ثم وسمها كمراجعة أو أرشفتها من صفحة التفاصيل فقط.</p>
            </div>
        </div>

        <div class="complaints-tabs">
            <a href="{{ route('admin.complaints.index', array_filter(['status' => $status !== 'all' ? $status : null])) }}" class="complaints-tab {{ $type === 'all' ? 'is-active' : '' }}">
                <span>الكل</span>
                <span class="badge">{{ number_format($counts['all'] ?? 0) }}</span>
            </a>
            <a href="{{ route('admin.complaints.index', array_filter(['type' => 'academic', 'status' => $status !== 'all' ? $status : null])) }}" class="complaints-tab {{ $type === 'academic' ? 'is-active' : '' }}">
                <span>الشكاوى الدراسية</span>
                <span class="badge">{{ number_format($counts['academic'] ?? 0) }}</span>
            </a>
            <a href="{{ route('admin.complaints.index', array_filter(['type' => 'transport', 'status' => $status !== 'all' ? $status : null])) }}" class="complaints-tab {{ $type === 'transport' ? 'is-active' : '' }}">
                <span>شكاوى النقل</span>
                <span class="badge">{{ number_format($counts['transport'] ?? 0) }}</span>
            </a>
        </div>

        <div class="complaints-status-filters">
            <a href="{{ route('admin.complaints.index', array_filter(['type' => $type !== 'all' ? $type : null])) }}" class="complaints-filter {{ $status === 'all' ? 'is-active' : '' }}">
                الكل
            </a>
            <a href="{{ route('admin.complaints.index', array_filter(['type' => $type !== 'all' ? $type : null, 'status' => 'new'])) }}" class="complaints-filter {{ $status === 'new' ? 'is-active' : '' }}">
                جديدة <span class="badge">{{ number_format($counts['new'] ?? 0) }}</span>
            </a>
            <a href="{{ route('admin.complaints.index', array_filter(['type' => $type !== 'all' ? $type : null, 'status' => 'viewed'])) }}" class="complaints-filter {{ $status === 'viewed' ? 'is-active' : '' }}">
                تمت المراجعة <span class="badge">{{ number_format($counts['viewed'] ?? 0) }}</span>
            </a>
            <a href="{{ route('admin.complaints.index', array_filter(['type' => $type !== 'all' ? $type : null, 'status' => 'archived'])) }}" class="complaints-filter {{ $status === 'archived' ? 'is-active' : '' }}">
                مؤرشفة <span class="badge">{{ number_format($counts['archived'] ?? 0) }}</span>
            </a>
        </div>

        <div class="complaints-table-card">
            <div class="complaints-table-wrap">
                <table class="table table-hover complaints-table">
                    <thead>
                        <tr>
                            <th>الرقم</th>
                            <th>النوع</th>
                            <th>اسم الطالب</th>
                            <th>اسم المشتكي</th>
                            <th>الهاتف</th>
                            <th>الصف</th>
                            <th>الشعبة</th>
                            <th>تاريخ الإرسال</th>
                            <th>الحالة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                            @php
                                $badgeClass = $complaint->status === 'viewed' ? 'is-viewed' : ($complaint->status === 'archived' ? 'is-archived' : 'is-new');
                                $typeText = $complaint->type === 'transport' ? 'شكوى نقل' : 'شكوى دراسية';
                                $statusText = $statusLabel($complaint->status);
                            @endphp
                            <tr>
                                <td>#{{ $complaint->id }}</td>
                                <td>{{ $typeText }}</td>
                                <td class="text-wrap">{{ $complaint->student_name }}</td>
                                <td class="text-wrap">{{ $complaint->applicant_name }}</td>
                                <td>{{ $complaint->phone }}</td>
                                <td class="text-wrap">{{ $complaint->class_name }}</td>
                                <td class="text-wrap">{{ $complaint->section_name }}</td>
                                <td>{{ optional($complaint->created_at)->format('Y-m-d H:i') }}</td>
                                <td><span class="complaints-badge {{ $badgeClass }}">{{ $statusText }}</span></td>
                                <td>
                                    <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="btn btn-sm btn-primary">عرض التفاصيل</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="complaints-empty">
                                        <h4>لا توجد شكاوى ضمن هذا التصفية</h4>
                                        <p>يمكنك تغيير النوع أو الحالة لعرض نتائج أخرى.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $complaints->links() }}
        </div>
    </div>
</div>
@endsection
