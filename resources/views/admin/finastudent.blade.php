@extends('admin.layouts.v2')

@section('page_title', 'الأقساط المالية')
@section('page_subtitle', 'متابعة الحسابات المالية للطلاب وإضافة الفواتير من واجهة منظمة ومتسقة مع نظام الإدارة')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<style>
    .financial-v2 { direction: rtl; }
    .financial-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .financial-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .financial-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .financial-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .financial-breadcrumbs__current { color:#2f2b3a; font-weight:800; }
    .financial-shell { display:grid; gap:1rem; }
    .financial-card { overflow:hidden; }
    .financial-card__header { padding:1.1rem 1.25rem 0; }
    .financial-card__title { margin:0; font-size:1.05rem; font-weight:800; color:#2f2b3a; }
    .financial-card__subtitle { margin:.25rem 0 0; color:#8a869a; font-size:.88rem; }
    .financial-card__body { padding:1rem 1.25rem 1.25rem; }
    .financial-toolbar { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; margin-bottom:1rem; }
    .financial-toolbar__filters { display:flex; align-items:center; gap:.75rem; flex-wrap:wrap; }
    .financial-toolbar__filters .form-control { min-width:180px; }
    .financial-table-wrap { border:1px solid #ece9f4; border-radius:18px; overflow:hidden; background:#fff; }
    .financial-table { width:100%; margin:0; }
    .financial-table thead th { background:#f8f7fc; color:#5e5873; font-size:.85rem; font-weight:800; padding:1rem .8rem; border:0 !important; text-align:center !important; white-space:nowrap; }
    .financial-table tbody td { color:#2f2b3a; font-size:.92rem; font-weight:700; padding:1rem .8rem; border:0 !important; border-top:1px solid #f0edf6 !important; text-align:center !important; vertical-align:middle; }
    .financial-table tbody tr:hover { background:#fbfaff; }
    .financial-action { width:44px; height:44px; display:inline-flex; align-items:center; justify-content:center; border-radius:12px; border:1px solid rgba(59,130,246,.18); background:rgba(59,130,246,.08); color:#3b82f6 !important; text-decoration:none; }
    .financial-action:hover { background:rgba(59,130,246,.15); color:#2563eb !important; text-decoration:none; }
    .financial-v2 .dataTables_wrapper { padding-top:1rem; }
    .financial-v2 .dataTables_filter, .financial-v2 .dataTables_length { margin-bottom:1rem; }
    .financial-v2 .pagination { justify-content:center !important; }
    .financial-v2 .modal-backdrop { z-index:2000 !important; }
    .financial-v2 .modal { z-index:2010 !important; }
    .financial-v2 .modal-dialog { margin:1.75rem auto; max-width:640px; }
    .financial-v2 .modal-content { border:0; border-radius:20px; overflow:hidden; box-shadow:0 24px 60px rgba(36,30,62,.16); }
    .financial-v2 .modal-header, .financial-v2 .modal-footer { border-color:rgba(91,75,138,.12); }
    .financial-v2 .modal-header { padding:1.1rem 1.25rem; align-items:flex-start; background:linear-gradient(180deg,#fcfbff 0%,#f6f3fc 100%); }
    .financial-v2 .modal-title { font-size:1.02rem; font-weight:800; color:#2f2b3a; }
    .financial-v2 .financial-modal__header { display:flex; align-items:flex-start; justify-content:space-between; gap:1rem; width:100%; }
    .financial-v2 .financial-modal__title-wrap { display:grid; gap:.3rem; min-width:0; }
    .financial-v2 .financial-modal__actions { display:flex; align-items:center; gap:.75rem; flex-shrink:0; }
    .financial-v2 .financial-modal__details.btn { min-height:38px; padding:.5rem .9rem; border-radius:10px; font-size:.86rem; font-weight:800; color:#3b82f6 !important; border:1px solid rgba(59,130,246,.2); background:rgba(59,130,246,.08); text-decoration:none; }
    .financial-v2 .financial-modal__details.btn:hover { background:rgba(59,130,246,.14); color:#2563eb !important; text-decoration:none; }
    .financial-v2 .financial-modal__close { width:38px; height:38px; padding:0; display:inline-flex; align-items:center; justify-content:center; border:0; border-radius:10px; background:rgba(47,43,58,.06); color:#5e5873; font-size:1.4rem; line-height:1; opacity:1; cursor:pointer; }
    .financial-v2 .financial-modal__close:hover { background:rgba(47,43,58,.12); color:#2f2b3a; }
    .financial-v2 .modal-body { padding:1.25rem 1.35rem; }
    .financial-v2 .modal-footer { padding:1rem 1.35rem 1.25rem; display:flex; gap:.75rem; justify-content:flex-start; direction:rtl; }
    .financial-v2 .modal-footer .btn { min-width:112px; min-height:44px; border-radius:12px; font-weight:800; }
    .financial-v2 .modal-grid { display:grid; gap:1rem; }
    .financial-v2 .modal-stats { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:.75rem; }
    .financial-v2 .financial-stat { border-radius:16px; padding:.95rem .85rem; background:#f8f7fc; text-align:center; }
    .financial-v2 .financial-stat__label { display:block; color:#8a869a; font-size:.8rem; font-weight:700; margin-bottom:.3rem; }
    .financial-v2 .financial-stat__value { display:block; color:#2f2b3a; font-size:1.02rem; font-weight:800; }
    .financial-v2 .financial-receipt-toggle { min-height:44px; border-radius:12px; font-weight:800; }
    .financial-v2 .financial-form-group { display:grid; gap:.45rem; }
    .financial-v2 .financial-form-group label { margin:0; font-size:.9rem; font-weight:800; color:#4d4762; text-align:right; }
    .financial-v2 .form-control { min-height:46px; border-radius:12px; border:1px solid #dcd6eb; box-shadow:none; }
    .financial-v2 .details { margin-inline-start:auto; }
    .financial-v2 .btn, .financial-v2 a.btn { color:inherit; }
    @media (max-width: 767px) {
        .financial-card__body, .financial-card__header { padding-inline:.9rem; }
        .financial-toolbar { align-items:stretch; }
        .financial-toolbar__filters { width:100%; }
        .financial-toolbar__filters .form-control { width:100%; min-width:0; }
        .financial-v2 .modal-stats { grid-template-columns:1fr; }
        .financial-v2 .financial-modal__header { flex-direction:column; align-items:stretch; }
        .financial-v2 .financial-modal__actions { justify-content:space-between; }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="financial-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="financial-breadcrumbs__link">لوحة التحكم</a>
    <span class="financial-breadcrumbs__sep">/</span>
    <span class="financial-breadcrumbs__current">الأقساط المالية</span>
</nav>
@endsection

@section('content')
<div class="financial-v2">
    <div class="modal fade financialaccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('invoice_store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <div class="financial-modal__header">
                            <div class="financial-modal__title-wrap">
                                <h4 class="modal-title">الحساب المالي: <span class="student_name" style="font-weight:800"></span></h4>
                            </div>
                            <div class="financial-modal__actions">
                                <a target="_blank" class="btn financial-modal__details details">تفاصيل الفواتير</a>
                                <button type="button" class="financial-modal__close" data-dismiss="modal" aria-label="إغلاق">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="student_id" id="student_financial_id">
                        <input type="hidden" name="class_id" id="class_id">

                        <div class="modal-grid">
                            <div class="modal-stats">
                                <div class="financial-stat">
                                    <span class="financial-stat__label">الكامل</span>
                                    <span class="financial-stat__value" id="full_account"></span>
                                </div>
                                <div class="financial-stat">
                                    <span class="financial-stat__label">المدفوع</span>
                                    <span class="financial-stat__value" id="amount_paid"></span>
                                </div>
                                <div class="financial-stat">
                                    <span class="financial-stat__label">المتبقي</span>
                                    <span class="financial-stat__value" id="remaining_account"></span>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary btn-block financial-receipt-toggle add_reciept" data-toggle="collapse" data-target="#demo">إضافة فاتورة</button>

                            <div id="demo" class="collapse">
                                <div class="modal-grid">
                                    <div class="financial-form-group">
                                        <label>رقم الفاتورة</label>
                                        <input type="text" name="invoice_number" class="form-control b" maxlength="20">
                                    </div>
                                    <div class="financial-form-group">
                                        <label>المبلغ المدفوع</label>
                                        <input type="number" name="invoice_amount" class="form-control" id="invoice_amount">
                                    </div>
                                    <div class="financial-form-group">
                                        <label>نوع الدفع</label>
                                        <input type="text" name="payment_type" class="form-control" id="payment_type">
                                    </div>
                                    <div class="financial-form-group">
                                        <label>اسم البنك</label>
                                        <input type="text" name="bank_name" class="form-control" id="bank_name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" data-dismiss="modal">إلغاء</a>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="financial-shell">
        <div class="v2-card financial-card">
            <div class="financial-card__header">
                <h3 class="financial-card__title">حسابات الطلاب</h3>
                <p class="financial-card__subtitle">تصفية الطلاب حسب الرصيد المتبقي أو المدفوع ومراجعة الحساب المالي لكل طالب.</p>
            </div>
            <div class="financial-card__body">
                <div class="financial-toolbar">
                    <div class="financial-toolbar__filters">
                        <select id="type_filtter" class="form-control">
                            <option value="0">باقي له أكثر من</option>
                            <option value="1">دافع أكثر من</option>
                            <option value="2">دافع أقل من</option>
                        </select>
                        <input type="text" class="form-control" placeholder="المبلغ" id="amount_balance">
                    </div>
                </div>

                <div class="financial-table-wrap table-responsive">
                    <table class="table financial-table" id="table_xx">
                        <thead>
                            <tr>
                                <th>الاسم الأول</th>
                                <th>الكنية</th>
                                <th>المبلغ المدفوع</th>
                                <th>المبلغ المتبقي</th>
                                <th>الصف</th>
                                <th>كامل القسط</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
$('#type_filtter').change(function () {
    table_test.draw();
});
$('#amount_balance').keyup(function () {
    table_test.draw();
});

var table_test = $('#table_xx').DataTable({
    processing: true,
    oLanguage: {
        sProcessing: "<h1>Proccessing</h1>"
    },
    serverSide: true,
    pageLength: 10,
    ajax: {
        type: "GET",
        url: "{{ route('getstudentsfina') }}",
        type: "GET",
        data: function (d) {
            d.amount = $('#amount_balance').val();
            d.type = $('#type_filtter').val();
        },
        dataSrc: function (json) {
            console.log(555, json.aaData);
            return json.aaData;
        }
    },
    columns: [
        { data: 'id', render: function (data, type, full) { return `${full.first_name}`; } },
        { data: 'id', render: function (data, type, full) { return `${full.last_name}`; } },
        { data: 'id', render: function (data, type, full) { return `${full.total}`; } },
        { data: 'id', render: function (data, type, full) { return `${full.remain_total}`; } },
        { data: 'id', render: function (data, type, full) { return `${full.class}`; } },
        { data: 'id', render: function (data, type, full) { return `${full.fixed_cost}`; } },
        {
            data: 'id',
            render: function (data, type, full) {
                return `<a href=".financialaccountModal" class="financial_account financial-action" data-toggle="modal" data-id="${full.id}" data-name="${ full.first_name+" "+full.last_name }" data-class="${ full.class_id }"><i class="fa fa-eye"></i></a>`;
            }
        },
    ]
});

$(document).on('click', '.financial_account', function () {
    var student_id = $(this).data('id');
    var class_id = $(this).data('class');

    $('#student_financial_id').val(student_id);
    $('#class_id').val(class_id);
    $('.student_name').text($(this).data('name'));
    $('.details').attr('href', "{{ URL::to('SMT/admin/students/invoices_details') }}/" + student_id);

    var url = "{{ URL::to('SMT/admin/students/remain_account') }}/" + student_id + "/" + class_id;
    $.ajax({
        url: url,
        type: "get",
        contentType: 'application/json',
        success: function (data) {
            $('#full_account').text(data.full_amount);
            $('#remaining_account').text(data.remain_amount);
            $('#amount_paid').text(data.amount_paid);
            $('#invoice_amount').attr('max', data.remain_amount);
            $('#payment_type').attr('max', data.payment_type);
            $('#bank_name').attr('max', data.bank_name);
            if (data.remain_amount == 0) {
                $('.add_reciept').hide();
            } else {
                $('.add_reciept').show();
            }
        },
    });
});
</script>
@endsection
