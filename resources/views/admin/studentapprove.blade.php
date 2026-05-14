@extends('admin.layouts.v2')

@section('page_title', 'طلبات القبول')
@section('page_subtitle', 'مراجعة طلبات التسجيل الواردة من بوابة التسجيل')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<style>
    .admission-requests-v2 {
        direction: rtl;
    }

    .admission-requests-v2 .v2-card.main-shell {
        padding: 1.15rem;
    }

    .admission-requests-v2 .section-head {
        margin-bottom: .75rem;
    }

    .admission-requests-v2 .section-head h3 {
        margin: 0 0 .25rem;
        font-size: 1.06rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .admission-requests-v2 .section-head p {
        margin: 0;
        color: #7b7590;
        font-size: .88rem;
    }

    .admission-requests-v2 .table-wrap {
        border: 1px solid #ece9f4;
        border-radius: 16px;
        overflow: auto;
        background: #fff;
    }

    .admission-requests-v2 .table thead th {
        background: #f8f7fc;
        color: #5d5673;
        font-weight: 800;
        border-bottom: 0;
    }

    .admission-requests-v2 .table td,
    .admission-requests-v2 .table th {
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    .admission-requests-v2 .toolbar {
        display: flex;
        gap: .65rem;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: .95rem;
    }

    .admission-requests-v2 .toolbar .form-control {
        min-height: 42px;
        border-radius: 12px;
        border-color: #d9d4e8;
    }

    .admission-requests-v2 .action-btn {
        min-width: 36px;
    }

    .admission-requests-v2 .review-pill {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .38rem .7rem;
        border-radius: 999px;
        font-size: .76rem;
        font-weight: 800;
        line-height: 1;
        border: 1px solid transparent;
        background: #f0edf8;
        color: #5a4a80;
    }

    .admission-requests-v2 .review-pill.is-success { background: #eefaf3; color: #1f8f5f; }
    .admission-requests-v2 .review-pill.is-warning { background: #fff7e8; color: #b67a15; }
    .admission-requests-v2 .review-pill.is-info { background: #eef6ff; color: #2f6fc8; }
    .admission-requests-v2 .review-pill.is-danger { background: #fff0f0; color: #b64242; }
    .admission-requests-v2 .review-pill.is-muted { background: #f4f2f8; color: #6f6787; }

    .admission-requests-v2 .modal-backdrop {
        z-index: 1040 !important;
    }

    .admission-requests-v2 .modal {
        z-index: 1055 !important;
    }

    .admission-requests-v2 .modal-content {
        border-radius: 16px;
        border: 0;
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a href="{{ route('studentadmission') }}" class="breadcrumbs__item">قسم القبول</a>
    <a class="breadcrumbs__item is-active">طلبات القبول</a>
</nav>
@endsection

@section('content')
<div class="admission-requests-v2">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="v2-card main-shell">
        <div class="section-head">
            <h3>جدول طلبات القبول</h3>
            <p>نفس سير العمل المعتاد: تصفية الطلبات، فتح التفاصيل، ثم الاعتماد أو الإلغاء مع بقاء السجل التاريخي محفوظاً.</p>
        </div>

        <div class="toolbar">
            <input id="filter_current" type="text" class="form-control" placeholder="بحث بالاسم" style="max-width:240px;">
            <select id="filter_class" class="form-control" style="max-width:220px;">
                <option value="">كل الصفوف</option>
                @foreach ($classes as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <select id="filter_status" class="form-control" style="max-width:220px;">
                <option value="active">الطلبات النشطة</option>
                <option value="draft">مسودات</option>
                <option value="pending_review">بانتظار المراجعة</option>
                <option value="under_review">قيد المراجعة</option>
                <option value="rejected">مرفوضة</option>
                <option value="cancelled">ملغاة</option>
                <option value="converted_to_student">مكتملة القبول</option>
                <option value="all">كل السجلات</option>
            </select>
        </div>

        <div class="table-wrap">
            <table class="table table-striped mb-0" id="table_xx">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم الأول</th>
                    <th>الكنية</th>
                    <th>الصف المطلوب</th>
                    <th>الحالة</th>
                    <th>تاريخ التسجيل</th>
                    <th>وقت التسجيل</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteStudentModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('delete_student_request') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">إلغاء طلب التسجيل</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id_delete" id="student_id_delete">
                    <p id="deleteName" class="mb-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">تأكيد الإلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
$(function () {
    const table = $('#table_xx').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        order: [[0, 'desc']],
        ajax: {
            url: "{{ route('getstudentsapprove') }}",
            type: "GET",
            data: function (d) {
                d.class_id = $('#filter_class').val();
                d.current_class = $('#filter_current').val();
                d.status_filter = $('#filter_status').val();
            },
            dataSrc: function (json) {
                return json.aaData || [];
            }
        },
        columns: [
            { data: 'id2', orderable: false },
            { data: 'first_name' },
            { data: 'last_name' },
            {
                data: 'class',
                render: function (data, type, full) {
                    return full.class && full.class.name ? full.class.name : '-';
                }
            },
            {
                data: 'admission_status_label',
                render: function (data, type, full) {
                    const label = data || '-';
                    const badgeClass = full.admission_status_class || 'is-muted';
                    const linkedBadge = full.is_converted ? '<span class="review-pill is-info">مرتبط بالسجل الأكاديمي</span>' : '';
                    return '<div class="d-inline-flex flex-wrap justify-content-center" style="gap:.35rem;">' +
                        '<span class="review-pill ' + badgeClass + '">' + label + '</span>' +
                        linkedBadge +
                    '</div>';
                }
            },
            { data: 'date2' },
            { data: 'time', orderable: false },
            {
                data: null,
                orderable: false,
                render: function (data, type, full) {
                    const viewUrl = "{{ route('studentadmission_request_show', ['id' => '__id__']) }}".replace('__id__', full.id2);
                    let html = '<a href="' + viewUrl + '" class="btn btn-sm btn-outline-primary action-btn" title="تفاصيل"><i class="fa fa-eye"></i></a> ';
                    if (!full.is_converted) {
                        html += '<button class="btn btn-sm btn-outline-danger action-delete action-btn" title="إلغاء الطلب" data-id="' + full.id2 + '" data-name="' + (full.first_name + ' ' + full.last_name) + '"><i class="fa fa-ban"></i></button>';
                    }
                    return html;
                }
            }
        ]
    });

    $('#filter_class').on('change', function () { table.draw(); });
    $('#filter_current').on('keyup', function () { table.draw(); });
    $('#filter_status').on('change', function () { table.draw(); });

    $(document).on('click', '.action-delete', function () {
        $('#student_id_delete').val($(this).data('id'));
        $('#deleteName').text('سيتم إلغاء طلب: ' + $(this).data('name'));
        $('#deleteStudentModal').modal('show');
    });
});
</script>
@endsection
