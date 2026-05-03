@extends('admin.layouts.v2')

@section('page_title', 'حضور الطلاب')
@section('page_subtitle', 'عرض حضور الطلاب حسب الصف والشعبة والفترة الزمنية')

@section('style')
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
    .report-v2 { direction: rtl; }
    .report-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .report-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .report-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .report-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .report-breadcrumbs__current { color:#2f2b3a; font-weight:800; }

    .report-filter { display:grid; gap:.85rem; grid-template-columns:repeat(12, minmax(0,1fr)); align-items:end; margin-bottom:1rem; }
    .report-filter__item { grid-column:span 3; }
    .report-filter__item--wide { grid-column:span 4; }
    .report-filter__item--btn { grid-column:span 12; }
    .report-filter label { display:block; margin-bottom:.35rem; color:#4d4762; font-size:.88rem; font-weight:800; text-align:right; }
    .report-v2 .form-control { min-height:44px; border-radius:12px; border:1px solid #dcd6eb; }

    .report-table-wrap { border:1px solid #ece9f4; border-radius:18px; overflow:hidden; }
    .report-table-wrap #report_wrapper { overflow:auto; padding:.8rem; }
    .report-v2 table.dataTable thead th { background:#f8f7fc; color:#5e5873; border:0 !important; text-align:center !important; font-weight:800; }
    .report-v2 table.dataTable tbody td { text-align:center !important; vertical-align:middle; }
    .report-v2 .dt-buttons { margin-bottom:.75rem; }
    .report-v2 .dt-button { border-radius:10px !important; }
    .report-empty { text-align:center; color:#8a869a; font-weight:700; padding:1rem 0; }

    @media (max-width: 991px) {
        .report-filter__item, .report-filter__item--wide { grid-column:span 6; }
    }
    @media (max-width: 575px) {
        .report-filter__item, .report-filter__item--wide, .report-filter__item--btn { grid-column:span 12; }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="report-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="report-breadcrumbs__link">لوحة التحكم</a>
    <span class="report-breadcrumbs__sep">/</span>
    <a href="{{ route('reports') }}" class="report-breadcrumbs__link">قسم التقارير</a>
    <span class="report-breadcrumbs__sep">/</span>
    <span class="report-breadcrumbs__current">حضور الطلاب</span>
</nav>
@endsection

@section('content')
<div class="report-v2">
    <div class="v2-card" style="padding:1.2rem;">
        <div class="report-filter">
            <div class="report-filter__item">
                <label for="classes_select">الصف</label>
                <select name="class_id" id="classes_select" class="form-control">
                    <option value="">اختر الصف</option>
                    @foreach ($class as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="report-filter__item">
                <label for="rooms_classes">الشعبة</label>
                <select id="rooms_classes" class="form-control">
                    <option value="">اختر الشعبة</option>
                </select>
            </div>

            <div class="report-filter__item">
                <label for="rooms_student">الطالب</label>
                <select name="student_id" id="rooms_student" class="form-control student_id">
                    <option value="">اختر الطالب</option>
                </select>
            </div>

            <div class="report-filter__item--wide">
                <label for="start_date">من</label>
                <input type="date" class="form-control" id="start_date">
            </div>

            <div class="report-filter__item--wide">
                <label for="end_date">إلى</label>
                <input type="date" class="form-control" id="end_date">
            </div>

            <div class="report-filter__item--btn">
                <button type="button" class="btn btn-primary" id="search">بحث</button>
            </div>
        </div>

        <div id="nodata" class="report-empty">لا يوجد بيانات.</div>

        <div class="report" style="display:none;">
            <div class="report-table-wrap">
                <table class="table" id="report">
                    <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>الصف</th>
                        <th>الشعبة</th>
                        <th>المادة</th>
                        <th>الحصة</th>
                        <th>الحضور</th>
                    </tr>
                    </thead>
                    <tbody id="mydiv"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script>
    function reportButtons() {
        return [
            { extend: 'excelHtml5', exportOptions: { columns: ':visible' } },
            { extend: 'print', exportOptions: { columns: ':visible' } }
        ];
    }

    $('.student_id').select2();
    $('#report').DataTable({ dom: 'Bfrtip', buttons: reportButtons() });

    $(document).on('change', '#rooms_classes', function () {
        var year_id = $('#years').val();
        var class_id = $(this).val();
        var url = "{{ URL::to('SMT/admin/classes/rooms2/student') }}/" + class_id + "/" + year_id;
        $('#rooms_student').empty();
        $.ajax({
            url: url,
            type: 'get',
            contentType: 'application/json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#rooms_student').append(`<option value="${value.id}">${value.first_name} ${value.last_name}</option>`);
                });
            }
        });
    });

    $(document).on('change', '#classes_select', function () {
        var year_id = $('#years').val();
        var class_id = $(this).val();
        var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id + "/" + year_id;
        $('#rooms_classes').empty();
        $('#rooms_student').empty();
        $('#rooms_student').append('<option value="">جميع الطلاب</option>');
        $('#rooms_classes').append('<option value="">جميع الشعب</option>');

        $.ajax({
            url: url,
            type: 'get',
            contentType: 'application/json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#rooms_classes').append(`<option value="${value.id}">${value.name}</option>`);
                });
            }
        });
    });

    $(document).on('click', '#search', function () {
        $('#nodata').hide();
        $('.report').show();

        var student_id = $('#rooms_student').val();
        var first_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var room_id = $('#rooms_classes').val();

        var url = "{{ URL::to('SMT/admin/student_sched') }}/" + student_id + "/" + room_id + "/" + first_date + "/" + end_date;
        if ($.fn.DataTable.isDataTable('#report')) {
            $('#report').DataTable().destroy();
        }
        $('#report tbody').empty();

        $.ajax({
            url: url,
            type: 'get',
            contentType: 'application/json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $.each(value.lectures, function (key1, value1) {
                        var Attend = '<p>غير معروف</p>';
                        if (value1.attendance === true) {
                            Attend = "<p style='color:green'>حضور</p>";
                        } else if (value1.attendance === false) {
                            Attend = "<p style='color:red'>غياب</p>";
                        }

                        $('#report tbody').append(`<tr>
                            <td>${key}</td>
                            <td>${value1.room.classes.name}</td>
                            <td>${value1.room.name}</td>
                            <td>${value1.lesson.name}</td>
                            <td>${value1.lecture_time.name}</td>
                            <td>${Attend}</td>
                        </tr>`);
                    });
                });

                $('#report').DataTable({ dom: 'Bfrtip', buttons: reportButtons() });
            }
        });
    });
</script>
@endsection
