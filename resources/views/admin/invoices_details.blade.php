@extends('admin.layouts.v2')

@section('page_title', 'تفاصيل الفواتير')
@section('page_subtitle', 'عرض جميع الفواتير المرتبطة بالطالب مع إمكانية فتح نسخة الطباعة لكل فاتورة')

@section('style')
<style>
    .invoice-details-v2,
    .invoice-details-v2 * { box-sizing:border-box; }
    .invoice-details-v2 { direction: rtl; }
    .invoice-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .invoice-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .invoice-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .invoice-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .invoice-breadcrumbs__current { color:#2f2b3a; font-weight:800; }
    .invoice-shell { display:grid; gap:1rem; }
    .invoice-grid { display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap:1rem; }
    .invoice-card { overflow:hidden; }
    .invoice-card__header { padding:1.1rem 1.25rem 0; }
    .invoice-card__title { margin:0; font-size:1.05rem; font-weight:800; color:#2f2b3a; }
    .invoice-card__subtitle { margin:.25rem 0 0; color:#8a869a; font-size:.88rem; }
    .invoice-card__body { padding:1rem 1.25rem 1.25rem; }
    .invoice-stat { border-radius:16px; padding:1rem; background:#f8f7fc; border:1px solid #ece9f4; }
    .invoice-stat__label { color:#8a869a; font-size:.82rem; font-weight:700; margin-bottom:.35rem; display:block; }
    .invoice-stat__value { color:#2f2b3a; font-size:1.05rem; font-weight:800; }
    .invoice-toolbar { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; margin-bottom:1rem; }
    .invoice-toolbar .btn { min-height:44px; border-radius:12px; font-weight:800; }
    .invoice-print-button { padding:.7rem 1rem; }
    .invoice-table-wrap { border:1px solid #ece9f4; border-radius:18px; overflow:hidden; background:#fff; }
    .invoice-table { width:100%; margin:0; }
    .invoice-table thead th { background:#f8f7fc; color:#5e5873; font-size:.85rem; font-weight:800; padding:1rem .8rem; border:0 !important; text-align:center !important; white-space:nowrap; }
    .invoice-table tbody td, .invoice-table tbody th { color:#2f2b3a; font-size:.92rem; font-weight:700; padding:1rem .8rem; border:0 !important; border-top:1px solid #f0edf6 !important; text-align:center !important; vertical-align:middle; }
    .invoice-table tbody tr:hover { background:#fbfaff; }
    .invoice-action { width:44px; height:44px; display:inline-flex; align-items:center; justify-content:center; border-radius:12px; border:1px solid rgba(59,130,246,.18); background:rgba(59,130,246,.08); color:#3b82f6 !important; text-decoration:none; }
    .invoice-action:hover { background:rgba(59,130,246,.15); color:#2563eb !important; text-decoration:none; }
    .invoice-print-head { display:none; }
    @page {
        size: A4;
        margin: 10mm;
    }
    @media print {
        * {
            box-sizing:border-box !important;
        }
        html, body {
            width:100% !important;
            background:#fff !important;
            margin:0 !important;
            padding:0 !important;
            height:auto !important;
            overflow:visible !important;
        }
        body {
            direction:rtl !important;
            text-align:right !important;
        }
        .v2-sidebar,
        .v2-navbar,
        .v2-page-header,
        .invoice-grid,
        .invoice-toolbar,
        .invoice-breadcrumbs,
        .invoice-card__header {
            display:none !important;
        }
        .v2-main,
        .v2-content-wrap,
        .invoice-details-v2,
        .invoice-shell,
        .invoice-card,
        .invoice-card__body {
            width:auto !important;
            max-width:none !important;
            margin:0 !important;
            padding:0 !important;
            background:#fff !important;
            box-shadow:none !important;
            border:0 !important;
            overflow:visible !important;
        }
        .v2-main {
            margin-right:0 !important;
            margin-left:0 !important;
            min-height:auto !important;
        }
        .v2-content-wrap {
            padding:0 !important;
        }
        .print-sheet {
            display:block !important;
            width:190mm !important;
            max-width:190mm !important;
            margin-left:auto !important;
            margin-right:auto !important;
            padding:10mm !important;
            background:#fff !important;
            box-shadow:none !important;
            border:0 !important;
            overflow:visible !important;
            page-break-after:avoid !important;
            break-after:avoid-page !important;
        }
        .invoice-print-head {
            display:block !important;
            width:100% !important;
            margin:0 0 6mm !important;
            text-align:right;
        }
        .invoice-print-head__title {
            margin:0 0 4mm;
            font-size:18pt;
            font-weight:800;
            color:#111827;
        }
        .invoice-print-head__meta {
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:4mm;
        }
        .invoice-print-head__box {
            border:1px solid #dbe2ea;
            border-radius:12px;
            padding:4mm;
        }
        .invoice-print-head__label {
            display:block;
            font-size:9pt;
            font-weight:700;
            color:#6b7280;
            margin-bottom:2mm;
        }
        .invoice-print-head__value {
            display:block;
            font-size:11pt;
            font-weight:800;
            color:#111827;
        }
        .invoice-table-wrap {
            border:0 !important;
            border-radius:0 !important;
            overflow:visible !important;
            background:#fff !important;
            width:100% !important;
            max-width:100% !important;
        }
        .invoice-table {
            width:100% !important;
            border-collapse:collapse !important;
            table-layout:fixed !important;
        }
        .invoice-table thead th:last-child,
        .invoice-table tbody td:last-child {
            display:none !important;
        }
        .invoice-table thead th,
        .invoice-table tbody td,
        .invoice-table tbody th {
            border:1px solid #dbe2ea !important;
            background:#fff !important;
            color:#111827 !important;
            padding:3mm 2.5mm !important;
            font-size:9pt !important;
            line-height:1.35 !important;
            white-space:normal !important;
            word-break:break-word !important;
        }
        .invoice-action {
            display:none !important;
        }
        tr, td, th, .invoice-print-head__box {
            page-break-inside:avoid !important;
            break-inside:avoid !important;
        }
    }
    @media (max-width: 991px) {
        .invoice-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="invoice-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="invoice-breadcrumbs__link">لوحة التحكم</a>
    <span class="invoice-breadcrumbs__sep">/</span>
    <a href="{{ route('students_financial') }}" class="invoice-breadcrumbs__link">الأقساط المالية</a>
    <span class="invoice-breadcrumbs__sep">/</span>
    <span class="invoice-breadcrumbs__current">تفاصيل الفواتير</span>
</nav>
@endsection

@section('content')
<div class="invoice-details-v2">
    <div class="invoice-shell">
        <div class="invoice-grid">
            <div class="invoice-stat">
                <span class="invoice-stat__label">اسم الطالب</span>
                <span class="invoice-stat__value">{{ $student->first_name }} {{ $student->last_name }}</span>
            </div>
            <div class="invoice-stat">
                <span class="invoice-stat__label">عدد الفواتير</span>
                <span class="invoice-stat__value">{{ $invoices_details->count() }}</span>
            </div>
            <div class="invoice-stat">
                <span class="invoice-stat__label">إجمالي المدفوع</span>
                <span class="invoice-stat__value">{{ $invoices_details->sum('invoice_amount') }}</span>
            </div>
        </div>

        <div class="v2-card invoice-card">
            <div class="invoice-card__header">
                <h3 class="invoice-card__title">سجل الفواتير</h3>
                <p class="invoice-card__subtitle">يمكنك من هنا مراجعة جميع الفواتير أو فتح نسخة الطباعة لكل فاتورة على حدة.</p>
            </div>
            <div class="invoice-card__body">
                <div class="invoice-toolbar">
                    <button class="btn btn-primary invoice-print-button" id="screenshot" type="button">طباعة الفاتورة</button>
                </div>

                <div class="invoice-print-scope print-sheet" id="dvContainer">
                    <div class="invoice-print-head">
                        <h2 class="invoice-print-head__title">كشف فواتير الطالب</h2>
                        <div class="invoice-print-head__meta">
                            <div class="invoice-print-head__box">
                                <span class="invoice-print-head__label">اسم الطالب</span>
                                <span class="invoice-print-head__value">{{ $student->first_name }} {{ $student->last_name }}</span>
                            </div>
                            <div class="invoice-print-head__box">
                                <span class="invoice-print-head__label">عدد الفواتير</span>
                                <span class="invoice-print-head__value">{{ $invoices_details->count() }}</span>
                            </div>
                            <div class="invoice-print-head__box">
                                <span class="invoice-print-head__label">إجمالي المدفوع</span>
                                <span class="invoice-print-head__value">{{ $invoices_details->sum('invoice_amount') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="invoice-table-wrap table-responsive">
                        <table class="table invoice-table">
                            <thead>
                                <tr>
                                    <th>المعرف</th>
                                    <th>رقم الفاتورة</th>
                                    <th>قيمة الفاتورة</th>
                                    <th>نوع الدفع</th>
                                    <th>اسم البنك</th>
                                    <th>التاريخ</th>
                                    <th>الطباعة</th>
                                </tr>
                            </thead>
                            <tbody id="mydiv">
                                @foreach ($invoices_details as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->invoice_number }}</td>
                                        <td>{{ $item->invoice_amount }}</td>
                                        <td>{{ $item->payment_type }}</td>
                                        <td>{{ $item->bank_name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a class="details invoice-action" title="طباعة" data-id="{{ $item->id }}" target="_blank" href="{{ route('invoices_print', $item->id) }}">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).on('click', '.details', function () {
    var invoices_id = $(this).data('id');
    var url = "{{ URL::to('SMT/admin/students/invoices_print') }}/" + invoices_id;
    $(this).attr('href', url);
});

$(document).on("click", "#screenshot", function () {
    window.print();
});
</script>
@endsection
