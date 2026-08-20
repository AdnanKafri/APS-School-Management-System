@extends('students.layouts.app4')

@section('title', 'الحساب المالي')

@section('content')
@if (session()->has('success'))
    <script>
        window.addEventListener('load', function () {
            notif({ msg: @json(session('success') ?: 'تم رفع الوصل بنجاح'), type: 'success' });
        });
    </script>
@endif

<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <a class="sp-page-header__eyebrow" href="{{ route('dashboard.student.lessons', $student->id) }}">الصفحة الرئيسية</a>
                    <h1>الحساب المالي</h1>
                    <p>ملخص الحساب وسجل الدفعات المرتبط بحساب الطالب.</p>
                </div>
                <div class="sp-page-header__aside">
                    <div class="sp-header-stat"><span>المبلغ المتبقي</span><strong>{{ $remain_amount }}</strong></div>
                </div>
            </section>

            @error('file')
                <div class="sp-alert sp-alert--danger"><i class="mdi mdi-alert-circle-outline"></i>{{ $message }}</div>
            @enderror

            <section class="sp-grid sp-grid--3 sp-summary-grid">
                <div class="sp-summary-card"><span class="sp-icon-box sp-icon-box--blue"><i class="mdi mdi-cash-multiple"></i></span><span><strong>{{ $full_amount }}</strong><small>المبلغ الكلي</small></span></div>
                <div class="sp-summary-card"><span class="sp-icon-box"><i class="mdi mdi-check-circle-outline"></i></span><span><strong>{{ $amount_paid }}</strong><small>المبلغ المدفوع</small></span></div>
                <div class="sp-summary-card"><span class="sp-icon-box sp-icon-box--gold"><i class="mdi mdi-timer-sand"></i></span><span><strong>{{ $remain_amount }}</strong><small>المبلغ المتبقي</small></span></div>
            </section>

            <section class="sp-card sp-section">
                <div class="sp-card__header sp-section-header">
                    <div><h2>إجراءات الدفع</h2><p>يمكنك تسديد مبلغ إلكترونياً أو رفع صورة وصل دفع.</p></div>
                </div>
                <div class="sp-card__body sp-actions-row">
                    @if ($remain_amount != 0)
                        <button type="button" class="sp-btn sp-btn--primary" data-toggle="modal" data-target="#paymentModal"><i class="mdi mdi-credit-card-outline"></i> تسديد مبلغ</button>
                    @endif
                    <button type="button" class="sp-btn sp-btn--soft" data-toggle="modal" data-target="#receiptModal"><i class="mdi mdi-receipt"></i> رفع وصل الدفع</button>
                </div>
            </section>

            <section class="sp-card sp-section">
                <div class="sp-card__header sp-section-header">
                    <div><h2>تفاصيل المدفوعات</h2><p>سجل الدفعات المحفوظة على حسابك.</p></div>
                    <span class="sp-badge sp-badge--info">{{ $invoices->count() }} دفعة</span>
                </div>
                <div class="sp-card__body">
                    @if ($invoices->isEmpty())
                        <div class="sp-empty sp-empty--compact"><span class="sp-empty__icon"><i class="mdi mdi-receipt-text-remove-outline"></i></span><h3>لا توجد دفعات مسجلة</h3></div>
                    @else
                        <div class="sp-table-wrap">
                            <table class="sp-table">
                                <thead><tr><th>رقم الفاتورة</th><th>المبلغ المدفوع</th><th>تاريخ الدفع</th></tr></thead>
                                <tbody>
                                @foreach ($invoices as $item)
                                    <tr><td data-label="رقم الفاتورة"><strong>{{ $item->invoice_number }}</strong></td><td data-label="المبلغ المدفوع">{{ $item->invoice_amount }}</td><td data-label="تاريخ الدفع">{{ $item->created_at->format('d/m/Y') }}</td></tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</main>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('dashboard.checkout') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">تسديد مبلغ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="sp-field"><label for="paymentAmount">المبلغ المراد تسديده</label><input id="paymentAmount" type="number" min="1" required name="amount" placeholder="أدخل المبلغ" class="form-control" inputmode="decimal"></div>
                </div>
                <div class="modal-footer"><button type="button" class="sp-btn sp-btn--soft" data-dismiss="modal">إلغاء</button><button type="submit" class="sp-btn sp-btn--primary">متابعة الدفع</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('add_payment_receipts') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">رفع وصل الدفع</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="sp-field"><label for="receiptFile">صورة الوصل</label><input id="receiptFile" type="file" accept="image/*" name="file" required class="form-control-file"><small class="sp-muted">الحد الأقصى لحجم الصورة 2 ميغابايت.</small></div>
                </div>
                <div class="modal-footer"><button type="button" class="sp-btn sp-btn--soft" data-dismiss="modal">إلغاء</button><button type="submit" class="sp-btn sp-btn--primary">رفع الوصل</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
