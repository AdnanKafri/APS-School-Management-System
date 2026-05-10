@extends('admin.layouts.v2')

@section('page_title', 'إعدادات القبول')
@section('page_subtitle', 'تهيئة الرسوم والشروط وحالة التسجيل من الموقع')

@section('style')
<style>
    .admission-setup-v2 {
        direction: rtl;
    }

    .admission-setup-v2 .v2-card.main-shell {
        padding: 1.2rem;
    }

    .admission-setup-v2 .section-head {
        margin-bottom: .9rem;
    }

    .admission-setup-v2 .section-head h3 {
        margin: 0 0 .25rem;
        font-size: 1.08rem;
        font-weight: 800;
        color: #2f2b3a;
    }

    .admission-setup-v2 .section-head p {
        margin: 0;
        color: #7b7590;
        font-size: .89rem;
    }

    .admission-setup-v2 .toggle-box {
        border: 1px solid #ebe7f5;
        border-radius: 14px;
        background: #fcfbff;
        padding: .95rem;
        margin-bottom: .95rem;
    }

    .admission-setup-v2 .switch-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .admission-setup-v2 .switch-copy {
        min-width: 220px;
    }

    .admission-setup-v2 .switch-copy h5 {
        margin: 0 0 .25rem;
        font-size: .92rem;
        font-weight: 800;
        color: #3d3655;
    }

    .admission-setup-v2 .switch-copy p {
        margin: 0;
        color: #7b7590;
        font-size: .83rem;
    }

    .admission-setup-v2 .status-switch {
        --switch-h: 36px;
        --switch-w: 76px;
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: var(--switch-w);
        height: var(--switch-h);
        border-radius: 999px;
        background: #e4deef;
        border: 1px solid #d5cee7;
        cursor: pointer;
        transition: background-color .22s ease, border-color .22s ease;
        user-select: none;
    }

    .admission-setup-v2 .status-switch input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .admission-setup-v2 .status-switch .track-label {
        position: absolute;
        inset-inline: 10px;
        font-size: .7rem;
        font-weight: 800;
        color: #7d7692;
        transition: color .22s ease;
        text-align: center;
        line-height: 1;
    }

    .admission-setup-v2 .status-switch .thumb {
        position: absolute;
        top: 3px;
        right: 3px;
        width: calc(var(--switch-h) - 8px);
        height: calc(var(--switch-h) - 8px);
        border-radius: 999px;
        background: #fff;
        box-shadow: 0 2px 7px rgba(33, 23, 57, 0.16);
        transition: transform .22s ease;
    }

    .admission-setup-v2 .status-switch input:focus-visible + .track-label {
        outline: 2px solid #6e5aa7;
        outline-offset: 10px;
        border-radius: 8px;
    }

    .admission-setup-v2 .status-switch input:checked ~ .thumb {
        transform: translateX(-40px);
    }

    .admission-setup-v2 .status-switch input:checked + .track-label {
        color: #fff;
    }

    .admission-setup-v2 .status-switch.is-on {
        background: #5f4b92;
        border-color: #5f4b92;
    }

    .admission-setup-v2 .status-state {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        border-radius: 999px;
        padding: .3rem .6rem;
        font-size: .76rem;
        font-weight: 800;
        background: #eefaf3;
        color: #1f8f5f;
    }

    .admission-setup-v2 .status-state.is-closed {
        background: #fff1f1;
        color: #b33a3a;
    }

    .admission-setup-v2 .stage-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: .85rem;
    }

    .admission-setup-v2 .stage-box {
        border: 1px solid #ebe7f5;
        border-radius: 16px;
        padding: .95rem;
        background: #fcfbff;
    }

    .admission-setup-v2 .stage-box h5 {
        margin: 0 0 .7rem;
        font-size: .92rem;
        font-weight: 800;
        color: #3d3655;
        padding-bottom: .4rem;
        border-bottom: 1px dashed #dfd8ef;
    }

    .admission-setup-v2 .form-group {
        margin-bottom: .75rem;
    }

    .admission-setup-v2 label {
        font-size: .85rem;
        font-weight: 800;
        margin-bottom: .35rem;
        color: #4d4762;
    }

    .admission-setup-v2 .form-control {
        min-height: 44px;
        border-radius: 12px;
        border-color: #d9d4e8;
        box-shadow: none;
    }

    .admission-setup-v2 .form-control:focus {
        border-color: #6e5aa7;
        box-shadow: 0 0 0 3px rgba(110, 90, 167, 0.12);
    }

    .admission-setup-v2 textarea.form-control {
        min-height: 130px;
        line-height: 1.7;
    }

    .admission-setup-v2 .terms-box {
        border: 1px solid #ebe7f5;
        border-radius: 16px;
        padding: .9rem;
        background: #fcfbff;
        margin-top: .95rem;
    }

    .admission-setup-v2 .terms-box h4 {
        font-size: .95rem;
        margin: 0 0 .8rem;
        font-weight: 800;
        color: #3d3655;
    }

    .admission-setup-v2 .save-row {
        display: flex;
        justify-content: flex-end;
        margin-top: 1rem;
        padding-top: .85rem;
        border-top: 1px solid #efecf7;
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a href="{{ route('studentadmission') }}" class="breadcrumbs__item">قسم القبول</a>
    <a class="breadcrumbs__item is-active">إعدادات القبول</a>
</nav>
@endsection

@section('content')
<div class="admission-setup-v2">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="v2-card main-shell">
        <div class="section-head">
            <h3>تهيئة مسار التسجيل الإلكتروني</h3>
            <p>إعداد الرسوم والشروط بشكل مركزي ليتم استهلاكها تلقائيًا في نموذج التسجيل ومراحل الاعتماد.</p>
        </div>

        <form method="POST" action="{{ route('studentadmission_setup_store') }}" enctype="multipart/form-data">
            @csrf

            <div class="toggle-box">
                <label class="d-block mb-2">حالة التسجيل من الموقع</label>
                @php
                    $registrationOpen = old('registration_open', ($termsSettings['registration_open'] ?? '1')) === '1';
                @endphp
                <div class="switch-row">
                    <div class="switch-copy">
                        <h5>السماح باستقبال طلبات التسجيل</h5>
                        <p>عند الإغلاق سيظهر للزائر صفحة إيقاف تسجيل واضحة ضمن واجهة الموقع.</p>
                    </div>

                    <div class="d-flex align-items-center" style="gap:.65rem;">
                        <label class="status-switch" for="registration_open">
                            <input type="checkbox" id="registration_open" name="registration_open" value="1" {{ $registrationOpen ? 'checked' : '' }}>
                            <span class="track-label">{{ $registrationOpen ? 'مفتوح' : 'مغلق' }}</span>
                            <span class="thumb" aria-hidden="true"></span>
                        </label>
                        <span id="registration_state_badge" class="status-state {{ $registrationOpen ? '' : 'is-closed' }}">{{ $registrationOpen ? 'قيد الاستقبال' : 'متوقف حاليًا' }}</span>
                    </div>
                </div>
            </div>

            <div class="section-head">
                <h3>رسوم المدرسة حسب المرحلة</h3>
                <p>يتم استخدام رسوم التسجيل والخدمات عند احتساب الفاتورة الأساسية للطالب.</p>
            </div>

            <div class="stage-grid mb-3">
                @foreach($stageDefaults as $stageKey => $stageMeta)
                    @php $row = $feeSettings[$stageKey] ?? null; @endphp
                    <div class="stage-box">
                        <h5>{{ $stageMeta['label_ar'] }}</h5>
                        <div class="form-group">
                            <label>رسوم التسجيل</label>
                            <input class="form-control" type="number" min="0" step="0.01" name="fees[{{ $stageKey }}][registration_fee]" value="{{ old("fees.$stageKey.registration_fee", $row->registration_fee ?? 0) }}" required>
                        </div>
                        <div class="form-group mb-0">
                            <label>رسوم الخدمات</label>
                            <input class="form-control" type="number" min="0" step="0.01" name="fees[{{ $stageKey }}][services_fee]" value="{{ old("fees.$stageKey.services_fee", $row->services_fee ?? 0) }}" required>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group mb-0">
                <label>رسوم النقل (مرجعية عامة حاليًا)</label>
                <input class="form-control" type="number" min="0" step="0.01" name="transport_fee" value="{{ old('transport_fee', optional($feeSettings->first())->transport_fee ?? 0) }}">
            </div>

            <div class="terms-box">
                <h4>الشروط والأحكام</h4>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>الشروط المدرسية (عربي)</label>
                            <textarea class="form-control" name="school_terms_ar">{{ old('school_terms_ar', $termsSettings['school_ar'] ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>School Terms (English)</label>
                            <textarea class="form-control" name="school_terms_en">{{ old('school_terms_en', $termsSettings['school_en'] ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-lg-0">
                            <label>شروط النقل (عربي)</label>
                            <textarea class="form-control" name="transport_terms_ar">{{ old('transport_terms_ar', $termsSettings['transport_ar'] ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-0">
                            <label>Transport Terms (English)</label>
                            <textarea class="form-control" name="transport_terms_en">{{ old('transport_terms_en', $termsSettings['transport_en'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>



            <div class="terms-box">
                <h4>Payment Configuration</h4>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Payment QR</label>
                            @if(!empty($termsSettings['payment_qr']))
                                <div class="mb-2">
                                    <img src="{{ route('studentadmission_media_file', ['path' => $termsSettings['payment_qr']]) }}" alt="Payment QR" style="max-width:160px;border:1px solid #e5e0f0;border-radius:10px;padding:6px;background:#fff;" onerror="this.style.display='none';">
                                </div>
                            @endif
                            <input class="form-control" type="file" name="payment_qr" accept=".jpg,.jpeg,.png,.webp">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Payment Reference (Arabic)</label>
                            <input class="form-control" type="text" name="payment_reference_ar" value="{{ old('payment_reference_ar', $termsSettings['payment_reference_ar'] ?? '') }}">
                        </div>
                        <div class="form-group mb-0">
                            <label>Payment Reference (English)</label>
                            <input class="form-control" type="text" name="payment_reference_en" value="{{ old('payment_reference_en', $termsSettings['payment_reference_en'] ?? '') }}">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Transfer / Wallet Details (Arabic)</label>
                            <input class="form-control" type="text" name="payment_account_ar" value="{{ old('payment_account_ar', $termsSettings['payment_account_ar'] ?? '') }}">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Transfer / Wallet Details (English)</label>
                            <input class="form-control" type="text" name="payment_account_en" value="{{ old('payment_account_en', $termsSettings['payment_account_en'] ?? '') }}">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-lg-0">
                            <label>Payment Instructions (Arabic)</label>
                            <textarea class="form-control" name="payment_instructions_ar">{{ old('payment_instructions_ar', $termsSettings['payment_instructions_ar'] ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-0">
                            <label>Payment Instructions (English)</label>
                            <textarea class="form-control" name="payment_instructions_en">{{ old('payment_instructions_en', $termsSettings['payment_instructions_en'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="save-row">
                <button class="btn btn-primary" type="submit">حفظ الإعدادات</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {
    const checkbox = document.getElementById('registration_open');
    const badge = document.getElementById('registration_state_badge');
    const label = document.querySelector('.status-switch .track-label');

    function syncSwitchState() {
        const open = !!checkbox.checked;
        label.textContent = open ? 'مفتوح' : 'مغلق';
        badge.textContent = open ? 'قيد الاستقبال' : 'متوقف حاليًا';
        badge.classList.toggle('is-closed', !open);
        checkbox.closest('.status-switch').classList.toggle('is-on', open);
    }

    checkbox.addEventListener('change', syncSwitchState);
    syncSwitchState();
});
</script>
@endsection

