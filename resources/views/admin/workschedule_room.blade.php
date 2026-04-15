@extends('admin.layouts.v2')

@section('page_title', 'الشعب')
@section('page_subtitle', 'اختيار الشعبة لعرض برنامج الدوام الأسبوعي')

@section('style')
<style>
    .teacher-schedule-breadcrumbs {
        font-size: 0.9rem;
        align-items: center;
        gap: 0.35rem;
    }

    .teacher-schedule-breadcrumbs .breadcrumbs__item {
        font-weight: 700;
    }

    .teacher-schedule-breadcrumbs a.breadcrumbs__item {
        color: #8a869a !important;
    }

    .teacher-schedule-breadcrumbs .breadcrumbs__item.is-active {
        color: #2f2b3a !important;
    }

    .teacher-schedule-breadcrumbs__sep {
        color: #b2aec0;
        font-weight: 700;
    }

    .schedule-selector-v2 {
        direction: rtl;
        text-align: right;
    }

    .schedule-selector-v2 .selector-card {
        border-radius: 22px;
        border: 1px solid rgba(91, 75, 138, 0.12);
        box-shadow: 0 18px 40px rgba(36, 30, 62, 0.08);
        overflow: hidden;
    }

    .schedule-selector-v2 .selector-card .card-body {
        padding: 1.25rem;
    }

    .schedule-selector-v2 .selector-table {
        margin-bottom: 0;
    }

    .schedule-selector-v2 .selector-table th,
    .schedule-selector-v2 .selector-table td {
        padding: 1rem 0.85rem !important;
        vertical-align: middle;
        text-align: right !important;
    }

    .schedule-selector-v2 .selector-table thead th {
        background: #f8f7fc;
        color: #2f2b3a;
        font-weight: 800;
        border-bottom: 1px solid rgba(91, 75, 138, 0.12) !important;
    }

    .schedule-selector-v2 .selector-table tbody td {
        border-bottom: 1px solid rgba(91, 75, 138, 0.08) !important;
    }

    .schedule-selector-v2 .selector-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .schedule-selector-v2 .selector-action {
        border-radius: 12px;
        padding: 0.65rem 1rem;
        font-weight: 700;
    }

    .schedule-selector-v2 .selector-pagination {
        padding-top: 1rem;
        text-align: center;
    }

    .schedule-selector-v2 .selector-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #f3f4f6;
        color: #4b5563 !important;
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs teacher-schedule-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">لوحة التحكم</a>
    <span class="teacher-schedule-breadcrumbs__sep" aria-hidden="true">/</span>
    <a href="{{ route('workschedule_class') }}" class="breadcrumbs__item">برنامج الدوام</a>
    <span class="teacher-schedule-breadcrumbs__sep" aria-hidden="true">/</span>
    <span class="breadcrumbs__item is-active">الشعب</span>
</nav>
@endsection

@section('content')
<div class="schedule-selector-v2">
    <div class="card v2-card selector-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table selector-table">
                    <thead>
                        <tr>
                            <th>اسم الشعبة</th>
                            <th>الصف</th>
                            <th>العام الدراسي</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $item)
                            <tr>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td>{{ $item->classes->name }}</td>
                                <td>{{ $item->year->name }}</td>
                                <td>
                                    <div class="selector-actions">
                                        <a href=".editroomModal" class="edit selector-icon" data-class1="{{ $item->classes->id }}" data-name="{{ $item->name }}" data-id="{{ $item->id }}" data-toggle="modal">
                                            <i class="ni ni-settings"></i>
                                        </a>
                                        @can('workschedule')
                                            <a class="btn btn-primary selector-action" href="{{ route('workschedule_exam',$item->id) }}">البرنامج الأسبوعي</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="selector-pagination">
                <div class="hint-text">Showing <b>{{ !request('page') ? '1' : request('page') }}</b> out of <b>{{ ceil($count / paginate_num) }}</b> entries</div>
                <div class="row">
                    <div class="col-md-12">
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script>
    $(document).on('click', '.edit', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#name').val(name);
        $('#room_id').val(id);
    });
</script>
@endsection
