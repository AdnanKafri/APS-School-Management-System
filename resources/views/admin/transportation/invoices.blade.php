@extends('admin.layouts.v2')

@section('page_title', 'فواتير النقل')
@section('page_subtitle', 'عرض فواتير النقل للطالب وإضافة دفعات جديدة من نافذة موحدة')

@section('style')
<style>
    .transport-invoices-v2,
    .transport-invoices-v2 * { box-sizing: border-box; }
    .transport-invoices-v2 { direction: rtl; }
    .transport-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .transport-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .transport-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .transport-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .transport-breadcrumbs__current { color:#2f2b3a; font-weight:800; }
    .transport-shell { display:grid; gap:1rem; }
    .transport-card { overflow:hidden; }
    .transport-card__header { padding:1.1rem 1.25rem 0; }
    .transport-card__title { margin:0; font-size:1.05rem; font-weight:800; color:#2f2b3a; }
    .transport-card__subtitle { margin:.25rem 0 0; color:#8a869a; font-size:.88rem; }
    .transport-card__body { padding:1rem 1.25rem 1.25rem; }
    .transport-toolbar { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; margin-bottom:1rem; }
    .transport-toolbar__meta { color:#6c6682; font-size:.92rem; font-weight:700; }
    .transport-add-btn { min-height:44px; border-radius:12px; font-weight:800; }
    .transport-table-wrap { border:1px solid #ece9f4; border-radius:18px; overflow:hidden; background:#fff; }
    .transport-table { width:100%; margin:0; }
    .transport-table thead th { background:#f8f7fc; color:#5e5873; font-size:.85rem; font-weight:800; padding:1rem .8rem; border:0 !important; text-align:center !important; white-space:nowrap; }
    .transport-table tbody td { color:#2f2b3a; font-size:.92rem; font-weight:700; padding:1rem .8rem; border:0 !important; border-top:1px solid #f0edf6 !important; text-align:center !important; vertical-align:middle; }
    .transport-table tbody tr:hover { background:#fbfaff; }
    .transport-pager { padding:1rem .5rem 0; text-align:center; color:#8a869a; font-size:.88rem; font-weight:700; }
    .transport-pagination { margin-top:.65rem; }
    .transport-pagination .pagination { justify-content:center !important; margin-bottom:0; }

    .transport-invoices-v2 .modal-backdrop { z-index:2000 !important; }
    .transport-invoices-v2 .modal { z-index:2010 !important; }
    .transport-invoices-v2 .modal-dialog { margin:1.75rem auto; max-width:640px; }
    .transport-invoices-v2 .modal-content { border:0; border-radius:20px; overflow:hidden; box-shadow:0 24px 60px rgba(36,30,62,.16); }
    .transport-invoices-v2 .modal-header,
    .transport-invoices-v2 .modal-footer { border-color:rgba(91,75,138,.12); }
    .transport-invoices-v2 .modal-header { padding:1.1rem 1.25rem; align-items:flex-start; background:linear-gradient(180deg,#fcfbff 0%,#f6f3fc 100%); }
    .transport-invoices-v2 .modal-title { font-size:1.02rem; font-weight:800; color:#2f2b3a; margin:0; }
    .transport-invoices-v2 .modal-body { padding:1.25rem 1.35rem; }
    .transport-invoices-v2 .modal-footer { padding:1rem 1.35rem 1.25rem; display:flex; gap:.75rem; justify-content:flex-start; direction:rtl; }
    .transport-invoices-v2 .modal-footer .btn { min-width:112px; min-height:44px; border-radius:12px; font-weight:800; }
    .transport-invoices-v2 .transport-modal__close { width:38px; height:38px; padding:0; display:inline-flex; align-items:center; justify-content:center; border:0; border-radius:10px; background:rgba(47,43,58,.06); color:#5e5873; font-size:1.4rem; line-height:1; opacity:1; cursor:pointer; }
    .transport-invoices-v2 .transport-modal__close:hover { background:rgba(47,43,58,.12); color:#2f2b3a; }
    .transport-invoices-v2 .transport-stats { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:.75rem; margin-bottom:1rem; }
    .transport-invoices-v2 .transport-stat { border-radius:16px; padding:.95rem .85rem; background:#f8f7fc; text-align:center; }
    .transport-invoices-v2 .transport-stat__label { display:block; color:#8a869a; font-size:.8rem; font-weight:700; margin-bottom:.3rem; }
    .transport-invoices-v2 .transport-stat__value { display:block; color:#2f2b3a; font-size:1.02rem; font-weight:800; }
    .transport-invoices-v2 .transport-receipt-toggle { min-height:44px; border-radius:12px; font-weight:800; margin-bottom:.9rem; }
    .transport-invoices-v2 .transport-form-group { display:grid; gap:.45rem; margin-bottom:.9rem; }
    .transport-invoices-v2 .transport-form-group label { margin:0; font-size:.9rem; font-weight:800; color:#4d4762; text-align:right; }
    .transport-invoices-v2 .form-control { min-height:46px; border-radius:12px; border:1px solid #dcd6eb; box-shadow:none; }

    @media (max-width: 767px) {
        .transport-card__header,
        .transport-card__body { padding-inline:.9rem; }
        .transport-toolbar { align-items:stretch; }
        .transport-invoices-v2 .transport-stats { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="transport-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="transport-breadcrumbs__link">لوحة التحكم</a>
    <span class="transport-breadcrumbs__sep">/</span>
    <a href="{{ route('students_financial_transport') }}" class="transport-breadcrumbs__link">الأقساط المالية - النقل</a>
    <span class="transport-breadcrumbs__sep">/</span>
    <span class="transport-breadcrumbs__current">فواتير الطالب</span>
</nav>
@endsection

@section('content')
<div class="transport-invoices-v2">
    <div class="modal fade financialaccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('transport_invoice_store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">إضافة فاتورة نقل</h4>
                        <button type="button" class="transport-modal__close" data-dismiss="modal" aria-label="إغلاق">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="student_id" value="{{ $student->id }}"/>
                        <input type="hidden" name="bus_line_id" value="{{ optional(optional($student->bus)->bus_lines)->id }}"/>

                        <div class="transport-stats">
                            <div class="transport-stat">
                                <span class="transport-stat__label">الكامل</span>
                                <span class="transport-stat__value">{{ optional(optional($student->bus)->bus_lines)->annual_cost }}</span>
                            </div>
                            <div class="transport-stat">
                                <span class="transport-stat__label">المدفوع</span>
                                <span class="transport-stat__value">{{ optional(optional($student->bus)->bus_lines)->annual_cost - $remain_invoices }}</span>
                            </div>
                            <div class="transport-stat">
                                <span class="transport-stat__label">المتبقي</span>
                                <span class="transport-stat__value">{{ $remain_invoices }}</span>
                            </div>
                        </div>

                        @if($remain_invoices != 0)
                            <button type="button" class="btn btn-primary btn-block transport-receipt-toggle add_reciept" data-toggle="collapse" data-target="#invoice-create-collapse">
                                إضافة فاتورة
                            </button>
                        @endif

                        <div id="invoice-create-collapse" class="collapse @if($remain_invoices != 0) show @endif">
                            <div class="transport-form-group">
                                <label>رقم الفاتورة</label>
                                <input type="text" name="invoice_number" class="form-control" maxlength="20">
                            </div>
                            <div class="transport-form-group">
                                <label>المبلغ المدفوع</label>
                                <input type="number" name="invoice_amount" class="form-control" id="invoice_amount">
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

    <div class="transport-shell">
        <div class="v2-card transport-card">
            <div class="transport-card__header">
                <h3 class="transport-card__title">
                    فواتير الطالب: {{ $student->first_name }} {{ $student->last_name }}
                </h3>
                <p class="transport-card__subtitle">مراجعة دفعات النقل الخاصة بالطالب الحالي.</p>
            </div>
            <div class="transport-card__body">
                <div class="transport-toolbar">
                    <div class="transport-toolbar__meta">
                        المبلغ المتبقي: <strong>{{ $remain_invoices }}</strong>
                    </div>
                    @if($remain_invoices != 0)
                        <button type="button" class="btn btn-primary transport-add-btn" data-toggle="modal" data-target=".financialaccountModal">
                            إضافة فاتورة
                        </button>
                    @endif
                </div>

                <div class="transport-table-wrap table-responsive">
                    <table class="table transport-table">
                        <thead>
                            <tr>
                                <th>قيمة الفاتورة</th>
                                <th>رقم الفاتورة</th>
                                <th>تاريخ الدفع</th>
                                <th>الخط</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $item)
                                <tr>
                                    <td>{{ $item->invoice_amount }}</td>
                                    <td>{{ $item->invoice_number }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ optional(optional(optional($item->student)->bus)->bus_lines)->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="transport-pager">
                    عرض الصفحة <b>{{ !request('page') ? '1' : request('page') }}</b> من أصل <b>{{ ceil($count / paginate_num) }}</b>
                    <div class="transport-pagination">{{ $invoices->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
