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
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #f3f4f6;
        color: #4b5563 !important;
        transition: background .18s, color .18s;
        cursor: pointer;
    }

    .schedule-selector-v2 .selector-icon:hover {
        background: #e2e8f0;
        color: #1e293b !important;
    }

    /* editroomModal polish */
    #editroomModal .modal-content {
        border-radius: 16px;
        overflow: hidden;
        direction: rtl;
        text-align: right;
    }

    #editroomModal .modal-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
        align-items: center;
    }

    #editroomModal .modal-title {
        font-size: 1rem;
        font-weight: 700;
        color: #2f2b3a;
    }

    #editroomModal .modal-body {
        padding: 1.5rem;
    }

    #editroomModal .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e9ecef;
        gap: .6rem;
        justify-content: flex-end;
    }

    #editroomModal .modal-footer .btn {
        min-height: 40px;
        min-width: 100px;
        font-weight: 600;
        border-radius: 10px;
        padding: .45rem 1.1rem;
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
                                        <!-- <a href="#editroomModal" class="edit selector-icon" data-class1="{{ $item->classes->id }}" data-name="{{ $item->name }}" data-id="{{ $item->id }}" data-toggle="modal" data-target="#editroomModal" title="تعديل الشعبة"> -->
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

{{-- Edit Room Modal --}}
<div class="modal fade" id="editroomModal" tabindex="-1" role="dialog" aria-labelledby="editroomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form_update" action="{{ route('room_update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="room_id" id="room_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editroomModalLabel">تعديل الشعبة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:0;padding:0;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="room_name_edit" style="font-weight:600;color:#3a3550;">اسم الشعبة</label>
                        <input type="text" id="name" name="name" class="form-control" style="direction:rtl;border-radius:8px;" placeholder="اسم الشعبة" maxlength="30" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light text-dark" data-dismiss="modal">إلغاء</a>
                    <button class="btn btn-primary" type="submit">حفظ</button>
                </div>
            </form>
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
