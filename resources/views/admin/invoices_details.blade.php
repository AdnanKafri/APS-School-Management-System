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
    .invoice-print-only { display:none; }
    .invoice-doc { width:190mm; margin:0 auto; color:#111827; direction:rtl; font-family:Tahoma, Arial, sans-serif; }
    .invoice-doc__school { margin:0; text-align:center; font-size:22px; font-weight:700; }
    .invoice-doc__kind { margin:2mm 0 4mm; text-align:center; font-size:13px; color:#4b5563; }
    .invoice-doc__title { margin:4mm 0 2mm; font-size:14px; font-weight:700; }
    .invoice-doc table { width:100%; border-collapse:collapse; }
    .invoice-doc__meta td, .invoice-doc__info td { border:1px solid #d1d5db; padding:7px 8px; font-size:12px; }
    .invoice-doc__meta span, .invoice-doc__info span { color:#6b7280; }
    .invoice-doc__table th, .invoice-doc__table td { border:1px solid #374151; padding:7px 6px; font-size:12px; text-align:center; word-break:break-word; }
    .invoice-doc__table th { background:#f9fafb; font-weight:700; }
    .invoice-doc__summary { width:40%; margin-right:auto; margin-top:3mm; }
    .invoice-doc__summary td { border:1px solid #374151; padding:6px 8px; font-size:12px; }
    .invoice-doc__summary td:last-child { font-weight:700; text-align:center; }
    .invoice-doc__footer { margin-top:10mm; display:flex; justify-content:space-between; font-size:12px; }
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
            margin:0 !important;
            padding:0 !important;
        }
        .v2-shell,
        .v2-main,
        .v2-content-wrap,
        .v2-page,
        .v2-layout,
        .container,
        .container-fluid,
        .row,
        .col,
        [class*="col-"] {
            margin:0 !important;
            padding:0 !important;
            width:100% !important;
            max-width:100% !important;
            min-width:0 !important;
            float:none !important;
            transform:none !important;
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
            width:100% !important;
            max-width:100% !important;
            margin:0 !important;
            padding:0 !important;
            background:#fff !important;
            box-shadow:none !important;
            border:0 !important;
            overflow:visible !important;
        }
        .invoice-shell,
        .invoice-card,
        .invoice-card__body,
        .invoice-print-scope,
        .invoice-table-wrap,
        .invoice-table {
            display:block !important;
            width:100% !important;
            max-width:100% !important;
            min-width:0 !important;
            margin:0 !important;
            padding:0 !important;
            float:none !important;
            transform:none !important;
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
            min-width:190mm !important;
            margin-left:auto !important;
            margin-right:auto !important;
            margin-inline:auto !important;
            padding:10mm !important;
            background:#fff !important;
            box-shadow:none !important;
            border:0 !important;
            overflow:visible !important;
            position:relative !important;
            left:0 !important;
            right:0 !important;
            transform:none !important;
            float:none !important;
            page-break-after:avoid !important;
            break-after:avoid-page !important;
        }
        .print-sheet > * {
            display:block !important;
            width:100% !important;
            max-width:100% !important;
        }
        .invoice-print-scope {
            display:block !important;
            width:100% !important;
            max-width:100% !important;
            margin:0 !important;
            padding:0 !important;
        }
        .invoice-print-head {
            display:block !important;
            width:100% !important;
            margin:0 0 6mm !important;
            text-align:center !important;
            direction:rtl !important;
        }
        .invoice-print-head__title {
            margin:0 0 4mm;
            font-size:18pt;
            font-weight:800;
            color:#111827;
            text-align:center !important;
        }
        .invoice-print-head__meta {
            display:grid !important;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:4mm;
            width:100% !important;
            margin:0 !important;
            justify-items:stretch !important;
            align-items:stretch !important;
            text-align:right !important;
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
            margin:0 !important;
            padding:0 !important;
        }
        .table-responsive {
            display:block !important;
            width:100% !important;
            max-width:100% !important;
            min-width:0 !important;
            overflow:visible !important;
            margin:0 !important;
            padding:0 !important;
            border:0 !important;
            float:none !important;
            position:static !important;
            -ms-overflow-style:auto !important;
        }
        .invoice-table {
            display:table !important;
            width:100% !important;
            max-width:100% !important;
            min-width:100% !important;
            border-collapse:collapse !important;
            table-layout:fixed !important;
            margin:0 !important;
            direction:rtl !important;
        }
        .invoice-table thead th:last-child,
        .invoice-table tbody td:last-child {
            display:none !important;
        }
        .invoice-table thead th,
        .invoice-table tbody td,
        .invoice-table tbody th {
            width:auto !important;
            border:1px solid #dbe2ea !important;
            background:#fff !important;
            color:#111827 !important;
            padding:3mm 2.5mm !important;
            font-size:9pt !important;
            line-height:1.35 !important;
            white-space:normal !important;
            word-break:break-word !important;
            overflow-wrap:anywhere !important;
        }
        .invoice-action {
            display:none !important;
        }
        tr, td, th, .invoice-print-head__box {
            page-break-inside:avoid !important;
            break-inside:avoid !important;
        }

        .v2-sidebar,
        .v2-navbar,
        .v2-page-header,
        .v2-page-subtitle,
        .invoice-breadcrumbs,
        .invoice-details-v2,
        .card,
        button,
        .actions,
        .toolbar {
            display:none !important;
        }
        .invoice-print-only {
            display:block !important;
            position:static !important;
            visibility:visible !important;
            opacity:1 !important;
            width:190mm !important;
            max-width:190mm !important;
            margin:0 auto !important;
            padding:0 !important;
            background:#fff !important;
        }
        .invoice-print-only * {
            visibility:visible !important;
            display:revert !important;
        }
        .invoice-print-only table {
            display:table !important;
            width:100% !important;
        }
        .invoice-print-only thead {
            display:table-header-group !important;
        }
        .invoice-print-only tbody {
            display:table-row-group !important;
        }
        .invoice-print-only tr {
            display:table-row !important;
        }
        .invoice-print-only th,
        .invoice-print-only td {
            display:table-cell !important;
        }
        .invoice-doc {
            width:100% !important;
            max-width:100% !important;
            margin:0 !important;
        }
        .invoice-doc__footer {
            display:flex !important;
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
    @php
        $firstInvoice = $invoices_details->first();
        $school = \App\School_data::first();
    @endphp
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
                    <button class="btn btn-primary invoice-print-button" id="screenshot" type="button" @if(!$firstInvoice) disabled @endif>طباعة الفاتورة</button>
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

<div class="invoice-print-only" id="invoice-print-only">
    <div class="invoice-doc">
        <h1 class="invoice-doc__school">{{ $school->name_ar ?? $school->name_en ?? config('app.name') }}</h1>
        <p class="invoice-doc__kind">سند قبض / فاتورة مالية</p>

        <table class="invoice-doc__meta">
            <tr>
                <td><span>التاريخ:</span> {{ now()->format('Y-m-d H:i') }}</td>
                <td><span>رقم الفاتورة:</span> {{ optional($firstInvoice)->invoice_number ?? '-' }}</td>
            </tr>
        </table>

        <h3 class="invoice-doc__title">بيانات الطالب</h3>
        <table class="invoice-doc__info">
            <tr>
                <td><span>اسم الطالب:</span> {{ $student->first_name }} {{ $student->last_name }}</td>
                <td><span>عدد الفواتير:</span> {{ $invoices_details->count() }}</td>
            </tr>
        </table>

        <h3 class="invoice-doc__title">تفاصيل الفواتير</h3>
        <table class="invoice-doc__table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم الفاتورة</th>
                    <th>الوصف</th>
                    <th>المبلغ</th>
                    <th>طريقة الدفع</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices_details as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->invoice_number }}</td>
                        <td>قسط دراسي</td>
                        <td>{{ $item->invoice_amount }}</td>
                        <td>{{ $item->payment_type }}</td>
                        <td>{{ optional($item->created_at)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="invoice-doc__summary">
            <tr>
                <td>الإجمالي</td>
                <td>{{ $invoices_details->sum('invoice_amount') }}</td>
            </tr>
            <tr>
                <td>المدفوع</td>
                <td>{{ $invoices_details->sum('invoice_amount') }}</td>
            </tr>
            <tr>
                <td>المتبقي</td>
                <td>0</td>
            </tr>
        </table>

        <div class="invoice-doc__footer">
            <div>توقيع المحاسب: ____________________</div>
            <div>توقيع المستلم: ____________________</div>
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
    var invoiceNode = document.querySelector('.invoice-print-only .invoice-doc');
    if (!invoiceNode) {
        return;
    }

    var content = invoiceNode.outerHTML;
    var printWindow = window.open('', '', 'width=900,height=700');
    if (!printWindow) {
        return;
    }

    var printStyles = `
        @page {
            size: A4;
            margin: 10mm;
        }
        * {
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            background: #ffffff;
        }
        body {
            color: #111827;
            direction: rtl;
            font-family: Tahoma, Arial, sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .invoice-doc {
            width: 190mm;
            margin: 0 auto;
            color: #111827;
            direction: rtl;
            font-family: Tahoma, Arial, sans-serif;
        }
        .invoice-doc__school {
            margin: 0;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
        }
        .invoice-doc__kind {
            margin: 2mm 0 4mm;
            text-align: center;
            font-size: 13px;
            color: #4b5563;
        }
        .invoice-doc__title {
            margin: 4mm 0 2mm;
            font-size: 14px;
            font-weight: 700;
        }
        .invoice-doc table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-doc__meta td,
        .invoice-doc__info td {
            border: 1px solid #d1d5db;
            padding: 7px 8px;
            font-size: 12px;
        }
        .invoice-doc__meta span,
        .invoice-doc__info span {
            color: #6b7280;
        }
        .invoice-doc__table th,
        .invoice-doc__table td {
            border: 1px solid #374151;
            padding: 7px 6px;
            font-size: 12px;
            text-align: center;
            word-break: break-word;
        }
        .invoice-doc__table th {
            background: #f9fafb;
            font-weight: 700;
        }
        .invoice-doc__summary {
            width: 40%;
            margin-right: auto;
            margin-top: 3mm;
        }
        .invoice-doc__summary td {
            border: 1px solid #374151;
            padding: 6px 8px;
            font-size: 12px;
        }
        .invoice-doc__summary td:last-child {
            font-weight: 700;
            text-align: center;
        }
        .invoice-doc__footer {
            margin-top: 10mm;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }
    `;

    printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>طباعة الفاتورة</title>
            <style>${printStyles}</style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();
    setTimeout(function () {
        printWindow.print();
        printWindow.close();
    }, 300);
});
</script>
@endsection
