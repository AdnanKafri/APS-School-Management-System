@extends('admin.layouts.v2')

@section('page_title', 'الفصول الدراسية')
@section('page_subtitle', 'إدارة الفصول المرتبطة بكل سنة دراسية مع الحفاظ على جدول واضح للحالة والتعديل')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<style>
    .terms-admin {
        direction: rtl;
        text-align: right;
    }

    .terms-admin .terms-hero,
    .terms-admin .terms-card,
    .terms-admin .terms-table-card {
        border: 1px solid #ebe7f5;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 26px rgba(36, 30, 62, 0.05);
    }

    .terms-admin .terms-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(280px, .7fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .terms-admin .terms-hero__block {
        padding: 1rem 1.05rem;
    }

    .terms-admin .terms-hero__block h3 {
        margin: 0 0 .35rem;
        font-size: 1.15rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .terms-admin .terms-hero__block p {
        margin: 0;
        color: #746f84;
        line-height: 1.8;
        font-size: .92rem;
    }

    .terms-admin .terms-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: .65rem;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .terms-admin .terms-toolbar__actions {
        display: flex;
        flex-wrap: wrap;
        gap: .55rem;
        align-items: center;
    }

    .terms-admin .terms-toolbar .btn,
    .terms-admin .terms-toolbar a.btn {
        white-space: nowrap;
        border-radius: 12px;
        font-weight: 700;
        padding-inline: 1rem;
    }

    .terms-admin .terms-table-card {
        overflow: hidden;
    }

    .terms-admin .terms-table-wrap {
        overflow-x: auto;
    }

    .terms-admin .terms-table {
        width: 100%;
        margin: 0;
    }

    .terms-admin .terms-table thead th {
        background: #f7f5fb;
        color: #4d4762;
        font-size: .84rem;
        font-weight: 800;
        border-bottom: 1px solid #ebe7f5;
        white-space: nowrap;
    }

    .terms-admin .terms-table tbody td {
        vertical-align: middle;
        color: #2f2b3a;
        font-size: .92rem;
    }

    .terms-admin .terms-table tbody tr:hover {
        background: rgba(91, 75, 138, 0.03);
    }

    .terms-admin .terms-actions-cell {
        white-space: nowrap;
    }

    .terms-admin .terms-action-btn {
        border-radius: 10px;
        font-size: .85rem !important;
        font-weight: 700;
        min-width: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .terms-admin .form-group {
        margin-bottom: .95rem !important;
    }

    .terms-admin label {
        font-size: .95rem;
        font-weight: 700;
        color: #2f2b3a;
        margin-bottom: .35rem;
    }

    .terms-admin .form-control {
        min-height: 44px;
        border-radius: 12px;
        border-color: #d8d2e6;
        box-shadow: none;
    }

    .terms-admin .form-control:focus {
        border-color: #5b4b8a;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.12);
    }

    @media (max-width: 992px) {
        .terms-admin .terms-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .terms-admin .terms-hero__block {
            padding: .95rem;
        }

        .terms-admin .terms-toolbar {
            align-items: stretch;
        }

        .terms-admin .terms-toolbar__actions,
        .terms-admin .terms-toolbar .btn,
        .terms-admin .terms-toolbar a.btn {
            width: 100%;
        }

        .terms-admin .terms-table thead th,
        .terms-admin .terms-table tbody td {
            white-space: nowrap;
        }

    }
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a href="{{ route('show_years') }}" class="breadcrumbs__item">السنوات الدراسية</a>
    <a class="breadcrumbs__item is-active">الفصول الدراسية</a>
</nav>
@endsection

@section('content')
@php
    $about = \App\About_us::find(1);
@endphp

<div class="terms-admin">
    <div class="terms-hero">
        <div class="terms-hero__block terms-card">
            <h3>إدارة الفصول الدراسية</h3>
            <p>يمكنك إنشاء فصل جديد، تعديل بياناته، وربطه بالسنة الدراسية المناسبة من خلال هذه الصفحة.</p>
        </div>
        <div class="terms-hero__block terms-card">
            <h3>الارتباط بالسنوات</h3>
            <p>اضبط السنة الدراسية أولاً، ثم اربط بها الفصول الحالية لضمان أن يبقى الجدول الدراسي واضحاً ومتسقاً.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="terms-toolbar">
        <div class="terms-toolbar__actions">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create_teacher" style="background:#6ABAA3;border-color:#6ABAA3;">
                إنشاء فصل
            </button>
            <a href="{{ route('show_years') }}" class="btn btn-outline-primary">
                تحديد السنة
            </a>
        </div>
    </div>

    <div class="terms-table-card">
        <div class="terms-table-wrap">
            <table class="table align-items-center terms-table" id="table_xx">
                <thead>
                    <tr>
                        <th scope="col" class="sort" data-sort="budget">الاسم</th>
                        <th scope="col" class="sort" data-sort="budget">بداية الفصل</th>
                        <th scope="col" class="sort" data-sort="budget">نهاية الفصل</th>
                        <th scope="col" class="sort" data-sort="status">السنة</th>
                        <th scope="col" class="sort" data-sort="status">النوع</th>
                        <th scope="col" class="sort" data-sort="status">الحالي</th>
                        <th scope="col" class="sort" data-sort="status">العمليات</th>
                    </tr>
                </thead>
                <tbody class="list" id="mydiv"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade v2-dashboard-modal" id="up_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('term_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل فصل</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="term_id" hidden name="term_id">
                        <label>الاسم</label>
                        <input type="text" id="term" name="name" class="form-control a" style="direction:rtl" value="" maxlength="20" placeholder="الاسم" required>
                    </div>

                    <div class="form-group">
                        <label>اختر السنة</label>
                        <select class="form-control a year" required name="year_id">
                            @isset($years)
                                @foreach ($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="form-group">
                        <label>اختر الفصل</label>
                        <select class="form-control a term1" required name="type"></select>
                    </div>

                    <div class="form-group">
                        <label>بداية الفصل</label>
                        <input type="datetime-local" id="start" name="start" class="form-control a" style="direction:rtl" required>
                    </div>

                    <div class="form-group">
                        <label>نهاية الفصل</label>
                        <input type="datetime-local" id="end" name="end" class="form-control a" style="direction:rtl" required>
                    </div>
                </div>
                <div class="modal-footer" style="text-align:right;direction:rtl;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade v2-dashboard-modal" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('term_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إنشاء فصل</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>الاسم</label>
                        <input type="text" name="name" class="form-control a" style="direction:rtl" value="" maxlength="20" placeholder="الاسم" required>
                    </div>

                    <div class="form-group">
                        <label>اختر السنة</label>
                        <select class="form-control a" required name="year_id">
                            @foreach ($years as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>اختر الفصل</label>
                        <select class="form-control a" required name="type">
                            <option value="1">الفصل الأول</option>
                            <option value="2">الفصل الثاني</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>بداية الفصل</label>
                        <input type="datetime-local" name="start" class="form-control a" style="direction:rtl" required>
                    </div>

                    <div class="form-group">
                        <label>نهاية الفصل</label>
                        <input type="datetime-local" name="end" class="form-control a" style="direction:rtl" required>
                    </div>
                </div>
                <div class="modal-footer" style="text-align:right;direction:rtl;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script>
var table_test = $('#table_xx').DataTable({
    processing: true,
    oLanguage: {
        sProcessing: "<h1>Proccessing</h1>"
    },
    serverSide: true,
    pageLength: 10,
    ajax: {
        type: "GET",
        url: "{{ route('getterm') }}",
        dataSrc: function (json) {
            console.log(json.aaData);
            return json.aaData;
        }
    },
    columns: [
        {
            data: 'id',
            render: function (data, type, full) {
                return `${full.name}`;
            },
            orderable: false
        },
        {
            data: 'id',
            render: function (data, type, full) {
                return `${full.start != null ? `<p>${full.start}</p>` : ""}`;
            },
            orderable: false
        },
        {
            data: 'id',
            render: function (data, type, full) {
                return `${full.end != null ? `<p>${full.end}</p>` : ""}`;
            },
            orderable: false
        },
        {
            data: 'id',
            render: function (data, type, full) {
                return `${full.year.name}`;
            },
            orderable: false
        },
        {
            data: 'id',
            render: function (data, type, full) {
                let term_type = `الأول`;
                if (full.type == 2) {
                    term_type = 'الثاني';
                }
                return `<p>${term_type}</p>`;
            },
            orderable: false
        },
        {
            data: 'id',
            render: function (data, type, full) {
                let status = 'لا';
                let style = `style="color:red;"`;
                if (full.current_term == 1) {
                    style = `style="color:green;"`;
                    status = 'نعم';
                }
                return `${full.current_term != null ? `<p ${style}>${status}</p>` : ""}`;
            },
            orderable: false
        },
        {
            data: 'id',
            render: function (data, type, full) {
                return `
                    <a data-id="${full.id}" style="font-size:18px !important"
                       data-type="${full.type}" data-year="${full.year.name}" data-yearid="${full.year.id}"
                       data-current_term="${full.current_term}" data-name="${full.name}"
                       data-start="${full.start}" data-end="${full.end}"
                       data-toggle="modal" data-target="#up_teacher"
                       class="btn btn-info btn-sm edit terms-action-btn" title="تعديل">
                        <i class="fa fa-eye fa-x" style="color:#eff0f1"></i>
                    </a>
                `;
            },
            orderable: false
        }
    ]
});

$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name = $(this).data('name');

    $('#name_delete').val(name);
    $('#lesson_id_delete').val(id);
});

$(document).on("click", ".share_teacher", function () {
    $('#pass_share').text($(this).data("pass"));
    $('#username_share').text($(this).data("username"));
    $('#name_share').text($(this).data("name"));
});

$(document).on("click", "#screenshot", function () {
    html2canvas(document.querySelector("#dvContainer")).then(canvas => {
        a = document.createElement('a');
        document.body.appendChild(a);
        a.download = $('#name_share').text() + ".png";
        a.href = canvas.toDataURL();
        a.click();
    });
});

$(document).on('click', '.edit', function () {
    $('.term1').empty();
    yearid = $(this).data('yearid');
    year = $(this).data('year');
    $('#term_id').val($(this).data('id'));
    $('#term').val($(this).data('name'));
    $('#start').val($(this).data('start'));
    $('#end').val($(this).data('end'));

    if ($(this).data('current_term') == 1) {
        $('#current_term').attr('checked', true);
    }
    if ($(this).data('current_term') == 0) {
        $('#current_term').removeAttr('checked');
    }

    $('.year').val(yearid);
    if ($(this).data('type') == 1) {
        $('.term1').append(` <option value="1">الفصل الأول</option>
                             <option value="2">الفصل الثاني</option>`);
    } else if ($(this).data('type') == 2) {
        $('.term1').append(` <option value="2">الفصل الثاني</option>
                             <option value="1">الفصل الأول</option>`);
    }
});

$(document).on('keypress', '.english_name', function(event) {
    var ew = event.which;
    if (ew == 32) return true;
    if (48 <= ew && ew <= 57) return true;
    if (65 <= ew && ew <= 90) return true;
    if (97 <= ew && ew <= 122) return true;
    return false;
});
</script>
@endsection
