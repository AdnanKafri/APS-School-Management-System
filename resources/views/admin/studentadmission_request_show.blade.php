@extends('admin.layouts.v2')

@section('page_title', 'تفاصيل طلب القبول')
@section('page_subtitle', 'مراجعة شاملة لبيانات الطالب والدفعة والمستندات قبل الاعتماد')

@section('style')
<style>
    .admission-request-show {
        direction: rtl;
        --review-border: #ebe7f5;
        --review-surface: #ffffff;
        --review-muted: #f8f7fc;
        --review-text: #2f2b3a;
        --review-subtle: #7d7692;
        --review-accent: #5f4b92;
        --review-success: #1f8f5f;
        --review-warning: #b67a15;
        --review-danger: #b64242;
    }

    .admission-request-show .review-shell {
        display: grid;
        gap: 1rem;
    }

    .admission-request-show .review-hero,
    .admission-request-show .review-card {
        border: 1px solid var(--review-border);
        border-radius: 20px;
        background: var(--review-surface);
        box-shadow: 0 14px 32px rgba(47, 34, 80, 0.06);
    }

    .admission-request-show .review-hero {
        padding: 1.2rem;
        background:
            radial-gradient(circle at top right, rgba(95, 75, 146, 0.12), transparent 33%),
            linear-gradient(135deg, #ffffff 0%, #fbfaff 100%);
    }

    .admission-request-show .review-hero__top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .admission-request-show .review-hero__identity {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
    }

    .admission-request-show .review-avatar {
        width: 68px;
        height: 68px;
        border-radius: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #5f4b92, #7a62b6);
        color: #fff;
        font-size: 1.35rem;
        font-weight: 800;
        box-shadow: 0 12px 22px rgba(95, 75, 146, 0.22);
        flex-shrink: 0;
    }

    .admission-request-show .review-kicker {
        margin: 0 0 .25rem;
        color: var(--review-accent);
        font-size: .82rem;
        font-weight: 800;
    }

    .admission-request-show .review-hero__identity h2 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--review-text);
    }

    .admission-request-show .review-hero__identity p {
        margin: .35rem 0 0;
        color: var(--review-subtle);
        font-size: .9rem;
    }

    .admission-request-show .review-hero__actions {
        display: flex;
        gap: .65rem;
        flex-wrap: wrap;
    }

    .admission-request-show .review-pill-row {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .admission-request-show .review-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .45rem .75rem;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 800;
        line-height: 1;
        border: 1px solid transparent;
        background: #f0edf8;
        color: #5a4a80;
    }

    .admission-request-show .review-pill.is-success {
        background: #eefaf3;
        color: var(--review-success);
        border-color: #d6f1e0;
    }

    .admission-request-show .review-pill.is-warning {
        background: #fff7e8;
        color: var(--review-warning);
        border-color: #f5e0ad;
    }

    .admission-request-show .review-pill.is-danger {
        background: #fff1f1;
        color: var(--review-danger);
        border-color: #f2c8c8;
    }

    .admission-request-show .review-pill.is-muted {
        background: #f3f1f8;
        color: #6c6481;
        border-color: #e0dbee;
    }

    .admission-request-show .review-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(320px, .95fr);
        gap: 1rem;
        align-items: start;
    }

    .admission-request-show .review-column {
        display: grid;
        gap: 1rem;
    }

    .admission-request-show .review-card {
        padding: 1rem 1.05rem;
    }

    .admission-request-show .review-card__head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: .9rem;
    }

    .admission-request-show .review-card__head h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: var(--review-text);
    }

    .admission-request-show .review-card__head p {
        margin: .3rem 0 0;
        color: var(--review-subtle);
        font-size: .86rem;
        line-height: 1.7;
    }

    .admission-request-show .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: .75rem;
    }

    .admission-request-show .info-card {
        border: 1px solid var(--review-border);
        border-radius: 16px;
        background: var(--review-muted);
        padding: .75rem .85rem;
    }

    .admission-request-show .info-card__label {
        display: block;
        margin-bottom: .28rem;
        color: var(--review-subtle);
        font-size: .8rem;
        font-weight: 700;
    }

    .admission-request-show .info-card__value {
        color: var(--review-text);
        font-size: .94rem;
        font-weight: 800;
        line-height: 1.75;
        word-break: break-word;
        white-space: pre-line;
    }

    .admission-request-show .status-list {
        display: grid;
        gap: .7rem;
    }

    .admission-request-show .status-item {
        border: 1px solid var(--review-border);
        border-radius: 16px;
        background: var(--review-muted);
        padding: .8rem .9rem;
    }

    .admission-request-show .status-item__label {
        display: block;
        color: var(--review-subtle);
        font-size: .8rem;
        font-weight: 700;
        margin-bottom: .45rem;
    }

    .admission-request-show .money-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .7rem;
        margin-bottom: .8rem;
    }

    .admission-request-show .money-card {
        border: 1px solid var(--review-border);
        border-radius: 18px;
        background: linear-gradient(180deg, #fff 0%, #f9f7fd 100%);
        padding: .85rem .9rem;
    }

    .admission-request-show .money-card.is-total {
        background: linear-gradient(135deg, #5f4b92, #725aad);
        border-color: #5f4b92;
        color: #fff;
        box-shadow: 0 18px 32px rgba(95, 75, 146, 0.18);
    }

    .admission-request-show .money-card__label {
        display: block;
        font-size: .8rem;
        font-weight: 700;
        color: inherit;
        opacity: .85;
        margin-bottom: .35rem;
    }

    .admission-request-show .money-card__value {
        display: block;
        font-size: 1.05rem;
        font-weight: 800;
        color: inherit;
        line-height: 1.3;
    }

    .admission-request-show .payment-proof {
        border: 1px solid var(--review-border);
        border-radius: 18px;
        background: #fbfbfe;
        padding: .9rem;
        display: grid;
        gap: .8rem;
    }

    .admission-request-show .payment-proof__meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        flex-wrap: wrap;
    }

    .admission-request-show .payment-proof__title {
        margin: 0;
        font-size: .93rem;
        font-weight: 800;
        color: var(--review-text);
    }

    .admission-request-show .payment-proof__hint {
        margin: .2rem 0 0;
        font-size: .82rem;
        color: var(--review-subtle);
    }

    .admission-request-show .doc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: .8rem;
    }

    .admission-request-show .doc-card {
        border: 1px solid var(--review-border);
        border-radius: 18px;
        background: #fff;
        padding: .9rem;
        display: grid;
        gap: .8rem;
        min-height: 180px;
    }

    .admission-request-show .doc-card__top {
        display: flex;
        align-items: flex-start;
        gap: .8rem;
    }

    .admission-request-show .doc-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f1eef8, #e4ddf6);
        color: var(--review-accent);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
        font-weight: 800;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .admission-request-show .doc-card h4 {
        margin: 0 0 .2rem;
        color: var(--review-text);
        font-size: .92rem;
        font-weight: 800;
    }

    .admission-request-show .doc-card p {
        margin: 0;
        color: var(--review-subtle);
        font-size: .8rem;
        line-height: 1.6;
    }

    .admission-request-show .doc-meta {
        display: flex;
        gap: .45rem;
        flex-wrap: wrap;
    }

    .admission-request-show .doc-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 28px;
        padding: .2rem .55rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 800;
        background: #f3f1f8;
        color: #6a6182;
    }

    .admission-request-show .doc-badge.is-success {
        background: #eefaf3;
        color: var(--review-success);
    }

    .admission-request-show .doc-badge.is-danger {
        background: #fff1f1;
        color: var(--review-danger);
    }

    .admission-request-show .doc-actions {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
        margin-top: auto;
    }

    .admission-request-show .doc-actions .btn {
        min-width: 110px;
    }

    .admission-request-show .empty-panel {
        border: 1px dashed #d7d0e8;
        border-radius: 18px;
        background: linear-gradient(180deg, #fff 0%, #faf9fe 100%);
        padding: 1rem;
        text-align: center;
        color: var(--review-subtle);
    }

    .admission-request-show .approve-form .form-control {
        min-height: 44px;
        border-radius: 12px;
        border-color: #d9d4e8;
    }

    .admission-request-show .approve-form .finance-adjust-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: .85rem;
        margin-top: 1rem;
        margin-bottom: .2rem;
    }

    .admission-request-show .approve-form .finance-adjust-card {
        border: 1px solid var(--review-border);
        border-radius: 16px;
        background: var(--review-muted);
        padding: .85rem .95rem;
    }

    .admission-request-show .approve-form .finance-adjust-card.is-disabled {
        opacity: .7;
    }

    .admission-request-show .approve-form .finance-adjust-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        margin-bottom: .45rem;
    }

    .admission-request-show .approve-form .finance-adjust-limit {
        color: var(--review-subtle);
        font-size: .78rem;
        font-weight: 700;
    }

    .admission-request-show .approve-form .finance-adjust-hint {
        margin: .45rem 0 0;
        color: var(--review-subtle);
        font-size: .78rem;
        line-height: 1.7;
    }

    .admission-request-show .approve-form .finance-adjust-errors {
        margin-bottom: .95rem;
    }

    .admission-request-show .approve-form label {
        display: block;
        margin-bottom: .35rem;
        color: #4d4762;
        font-size: .85rem;
        font-weight: 800;
    }

    .admission-request-show .approve-submit {
        min-height: 44px;
        border-radius: 12px;
        font-weight: 800;
    }

    #mediaViewerModal.modal {
        z-index: 1065 !important;
    }

    .modal-backdrop {
        z-index: 1060 !important;
    }

    #mediaViewerModal .modal-dialog {
        width: calc(100vw - 2.4rem);
        max-width: 1200px;
        height: calc(100vh - 2.4rem);
        margin: 1.2rem auto;
    }

    #mediaViewerModal .modal-content {
        height: 100%;
        border: 0;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 26px 50px rgba(31, 18, 56, 0.22);
    }

    #mediaViewerModal .modal-header {
        padding: 1rem 1.1rem;
        border-bottom: 1px solid var(--review-border);
        background: #fff;
        align-items: center;
    }

    #mediaViewerModal .modal-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        flex-wrap: wrap;
        color: var(--review-text);
        font-size: 1rem;
        font-weight: 800;
    }

    #mediaViewerModal .modal-body {
        display: grid;
        grid-template-rows: auto minmax(0, 1fr);
        gap: .8rem;
        padding: 1rem;
        background: #f7f6fb;
        min-height: 0;
    }

    .media-viewer-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .8rem;
        flex-wrap: wrap;
    }

    .media-viewer-toolbar__actions {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .media-tool {
        min-width: 44px;
        min-height: 38px;
        border-radius: 12px;
        border: 1px solid #ddd6ee;
        background: #fff;
        color: #554b6f;
        font-size: .82rem;
        font-weight: 800;
    }

    .media-tool[disabled] {
        opacity: .45;
        cursor: not-allowed;
    }

    .media-stage {
        min-height: 0;
        border: 1px solid var(--review-border);
        border-radius: 18px;
        background: linear-gradient(180deg, #fbfbfe 0%, #f2eff8 100%);
        overflow: hidden;
        position: relative;
    }

    .media-stage__scroll {
        width: 100%;
        height: 100%;
        overflow: auto;
        padding: .9rem;
    }

    .media-stage__canvas {
        min-width: 100%;
        min-height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .media-viewer-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transform-origin: center center;
        transition: transform .18s ease;
        box-shadow: 0 18px 34px rgba(33, 23, 57, 0.18);
        border-radius: 14px;
        background: #fff;
    }

    .media-viewer-frame {
        width: 100%;
        height: 100%;
        min-height: calc(100vh - 15rem);
        border: 0;
        background: #fff;
        border-radius: 14px;
    }

    .media-viewer-state {
        display: grid;
        place-items: center;
        gap: .7rem;
        min-height: calc(100vh - 15rem);
        color: var(--review-subtle);
        text-align: center;
        padding: 1.2rem;
    }

    .media-viewer-state .alert {
        margin: 0;
        max-width: 480px;
    }

    @media (max-width: 1199px) {
        .admission-request-show .review-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .admission-request-show .review-hero,
        .admission-request-show .review-card {
            border-radius: 18px;
        }

        .admission-request-show .review-hero {
            padding: 1rem;
        }

        .admission-request-show .review-hero__identity {
            align-items: flex-start;
        }

        .admission-request-show .review-avatar {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            font-size: 1.12rem;
        }

        .admission-request-show .money-grid {
            grid-template-columns: 1fr;
        }

        #mediaViewerModal .modal-dialog {
            width: calc(100vw - 1rem);
            height: calc(100vh - 1rem);
            margin: .5rem auto;
        }

        #mediaViewerModal .modal-body {
            padding: .8rem;
        }

        .media-stage__scroll {
            padding: .65rem;
        }

        .media-viewer-frame,
        .media-viewer-state {
            min-height: calc(100vh - 17rem);
        }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
    <a href="{{ route('studentadmission') }}" class="breadcrumbs__item">قسم القبول</a>
    <a href="{{ route('studentadmission_requests') }}" class="breadcrumbs__item">طلبات القبول</a>
    <a class="breadcrumbs__item is-active">تفاصيل الطلب</a>
</nav>
@endsection

@section('content')
@php
    $fullName = trim((string) ($record->first_name . ' ' . $record->last_name));
    $initials = mb_strtoupper(trim(mb_substr((string) $record->first_name, 0, 1) . mb_substr((string) $record->last_name, 0, 1)));
    $paymentMethodMap = [
        '0' => 'تحويل يدوي',
        '1' => 'ShamCash',
        'manual' => 'تحويل يدوي',
        'shamcash' => 'ShamCash',
    ];
    $paymentMethodKey = (string) $record->payment_method;
    $paymentMethodLabel = $paymentMethodMap[$paymentMethodKey] ?? ($paymentMethodKey !== '' ? $paymentMethodKey : 'غير محدد');
    $paymentStatusKey = strtolower((string) ($record->payment_status ?: 'pending'));
    $paymentStatusMap = [
        'pending' => ['label' => 'بانتظار التحقق', 'class' => 'is-warning'],
        'paid' => ['label' => 'مدفوع', 'class' => 'is-success'],
        'rejected' => ['label' => 'مرفوض', 'class' => 'is-danger'],
    ];
    $paymentStatus = $paymentStatusMap[$paymentStatusKey] ?? ['label' => ($record->payment_status ?: 'غير محدد'), 'class' => 'is-muted'];
    if (is_null($record->current_step) && !empty($record->payment_receipt)) {
        $requestStatus = ['label' => 'مكتمل وجاهز للمراجعة', 'class' => 'is-success'];
    } elseif (!is_null($record->current_step)) {
        $requestStatus = ['label' => 'طلب غير مكتمل', 'class' => 'is-warning'];
    } else {
        $requestStatus = ['label' => 'بحاجة إلى متابعة', 'class' => 'is-muted'];
    }
    $transportStatus = (int) $record->wants_transport === 1
        ? ['label' => 'النقل مطلوب', 'class' => 'is-success']
        : ['label' => 'بدون نقل', 'class' => 'is-muted'];
    $schoolFeesTotal = (float) ($record->registration_fee ?? 0) + (float) ($record->services_fee ?? 0);
    if ($schoolFeesTotal <= 0) {
        $schoolFeesTotal = (float) ($record->total_amount ?? 0);
    }
    $hasTransportSelection = (int) $record->wants_transport === 1;
    $transportFeesTotal = $hasTransportSelection ? (float) ($record->transport_fee ?? 0) : 0;
    $defaultSchoolPaidAmount = old('school_paid_amount', $schoolFeesTotal);
    $defaultTransportPaidAmount = old('transport_paid_amount', $transportFeesTotal);
    $paymentReceiptState = !empty($record->payment_receipt)
        ? ['label' => 'إثبات دفع مرفوع', 'class' => 'is-success']
        : ['label' => 'لا يوجد إثبات دفع', 'class' => 'is-danger'];
    $formatDate = function ($value, $fallback = '-') {
        if (!$value) {
            return $fallback;
        }
        try {
            return \Carbon\Carbon::parse($value)->format('Y/m/d - h:i A');
        } catch (\Throwable $e) {
            return (string) $value;
        }
    };
    $formatMoney = function ($value) {
        return number_format((float) $value, 2) . ' ل.س';
    };
    $yesNoMeta = function ($value) {
        return (int) $value === 1
            ? ['label' => 'نعم', 'class' => 'is-success']
            : ['label' => 'لا', 'class' => 'is-danger'];
    };
    $resolveNullableBooleanLabel = function ($value) {
        if ($value === null || $value === '') {
            return '-';
        }
        return (int) $value === 1 ? __('wizard.options.allowed') : __('wizard.options.not_allowed');
    };
    $fieldValue = function ($value) {
        return trim((string) $value) !== '' ? (string) $value : '-';
    };

    $locale = \Illuminate\Support\Str::startsWith(app()->getLocale(), 'en') ? 'en' : 'ar';
    $countryCurrencyLookup = [];
    foreach (($countryCurrencies ?? []) as $countryCurrency) {
        if (!is_array($countryCurrency) && !is_object($countryCurrency)) {
            continue;
        }

        $nameAr = trim((string) data_get($countryCurrency, 'name_ar', ''));
        $nameEn = trim((string) data_get($countryCurrency, 'name_en', ''));
        $label = $locale === 'en'
            ? ($nameEn !== '' ? $nameEn : $nameAr)
            : ($nameAr !== '' ? $nameAr : $nameEn);
        if ($label === '') {
            continue;
        }
        foreach ([data_get($countryCurrency, 'key_country', ''), data_get($countryCurrency, 'id', '')] as $lookupKey) {
            $lookupKey = strtolower(trim($lookupKey));
            if ($lookupKey !== '') {
                $countryCurrencyLookup[$lookupKey] = $label;
            }
        }
    }
    $specialNationalityLabels = [
        'sy-ps' => ['ar' => 'سوري فلسطيني', 'en' => 'Syrian Palestinian'],
        'sy-jo' => ['ar' => 'سوري أردني', 'en' => 'Syrian Jordanian'],
        'sy-lb' => ['ar' => 'سوري لبناني', 'en' => 'Syrian Lebanese'],
        'sy-iq' => ['ar' => 'سوري عراقي', 'en' => 'Syrian Iraqi'],
        'sy-eg' => ['ar' => 'سوري مصري', 'en' => 'Syrian Egyptian'],
    ];
    $resolveCountryLabel = function ($value) use ($countryCurrencyLookup, $fieldValue) {
        $key = strtolower(trim((string) $value));
        if ($key === '') {
            return $fieldValue($value);
        }
        return $countryCurrencyLookup[$key] ?? (string) $value;
    };
    $resolveNationalityLabel = function ($value) use ($countryCurrencyLookup, $specialNationalityLabels, $locale, $fieldValue) {
        $key = strtolower(trim((string) $value));
        if ($key === '') {
            return $fieldValue($value);
        }
        if (isset($specialNationalityLabels[$key])) {
            return $specialNationalityLabels[$key][$locale] ?? $specialNationalityLabels[$key]['ar'];
        }
        return $countryCurrencyLookup[$key] ?? (string) $value;
    };
    $resolveGenderLabel = function ($value) {
        $map = [
            '1' => __('wizard.options.male'),
            '0' => __('wizard.options.female'),
            'male' => __('wizard.options.male'),
            'female' => __('wizard.options.female'),
        ];
        $key = strtolower(trim((string) $value));
        return $map[$key] ?? ((string) $value !== '' ? (string) $value : '-');
    };
    $resolveReligionLabel = function ($value) {
        $map = [
            '0' => __('wizard.options.muslim'),
            '1' => __('wizard.options.christian'),
            'muslim' => __('wizard.options.muslim'),
            'christian' => __('wizard.options.christian'),
        ];
        $key = strtolower(trim((string) $value));
        return $map[$key] ?? ((string) $value !== '' ? (string) $value : '-');
    };

    $documentLabelsByPath = [
        (string) $record->personal_image => 'الصورة الشخصية',
        (string) $record->mother_image => 'هوية الأم',
        (string) $record->father_image => 'هوية الأب',
        (string) $record->fourth_image => 'إخراج قيد / شهادة ميلاد',
        (string) $record->passbord => 'جواز السفر',
        (string) $record->mather_page => 'جواز الأم',
        (string) $record->father_page => 'جواز الأب',
        (string) $record->family_book => 'دفتر العائلة',
        (string) $record->study_sequence => 'التسلسل الدراسي',
        (string) $record->certification => 'آخر شهادة',
        (string) $record->certification_nine => 'شهادة التاسع',
    ];

    $paymentReceiptDoc = null;
    $documentDocs = [];
    foreach ((array) $docsMeta as $doc) {
        $labelPath = (string) ($doc['label_path'] ?? '');
        if ($labelPath !== '' && $labelPath === (string) $record->payment_receipt) {
            $doc['label'] = 'إثبات الدفع';
            $paymentReceiptDoc = $doc;
            continue;
        }
        $doc['label'] = $documentLabelsByPath[$labelPath] ?? 'مستند إضافي';
        $documentDocs[] = $doc;
    }
    if (!$paymentReceiptDoc && !empty($paymentReceiptMeta)) {
        $paymentReceiptMeta['label'] = 'إثبات الدفع';
        $paymentReceiptDoc = $paymentReceiptMeta;
    }

    $primaryDocumentPaths = [
        (string) $record->personal_image,
        (string) $record->fourth_image,
        (string) $record->passbord,
        (string) $record->certification,
        (string) $record->mather_page,
        (string) $record->father_page,
    ];
    $legacyDocumentPaths = [
        (string) $record->mother_image,
        (string) $record->father_image,
        (string) $record->family_book,
        (string) $record->study_sequence,
        (string) $record->certification_nine,
    ];
    $primaryDocumentDocs = [];
    $legacyDocumentDocs = [];
    foreach ((array) $documentDocs as $doc) {
        $labelPath = (string) ($doc['label_path'] ?? '');
        if ($labelPath !== '' && in_array($labelPath, $legacyDocumentPaths, true)) {
            $legacyDocumentDocs[] = $doc;
            continue;
        }
        if ($labelPath !== '' && in_array($labelPath, $primaryDocumentPaths, true)) {
            $primaryDocumentDocs[] = $doc;
            continue;
        }
        $primaryDocumentDocs[] = $doc;
    }

    $studentInfo = [
        __('wizard.fields.first_name_en') => $fieldValue($record->first_name_en),
        __('wizard.fields.last_name_en') => $fieldValue($record->last_name_en),
        __('wizard.fields.gender') => $resolveGenderLabel($record->gender),
        __('wizard.fields.religion') => $resolveReligionLabel($record->religion),
        __('wizard.summary.full_name') => $fullName ?: '-',
        __('wizard.fields.phone') => $fieldValue($record->phone),
        __('wizard.fields.email') => $fieldValue($record->email),
        __('wizard.fields.date') => $fieldValue($record->date),
        __('wizard.fields.nationality') => $resolveNationalityLabel($record->nationality),
        __('wizard.fields.place_of_birth') => $fieldValue($record->place_of_birth),
        __('wizard.fields.id_number') => $fieldValue($record->the_ID_number),
        __('wizard.fields.passport_number') => $fieldValue($record->passport_number),
    ];
    $parentInfo = [
        __('wizard.summary.father_name') => $fieldValue($record->father_name),
        __('wizard.summary.mother_name') => $fieldValue($record->mather_name),
        __('wizard.fields.mother_last_name') => $fieldValue($record->last_mother_name),
        __('wizard.fields.father_phone') => $fieldValue($record->father_phone),
        __('wizard.fields.mother_phone') => $fieldValue($record->mather_phone),
        __('wizard.fields.father_job') => $fieldValue($record->father_job),
        __('wizard.fields.mother_job') => $fieldValue($record->mather_job),
        __('wizard.fields.guardian_name') => $fieldValue($record->guardian_name),
        __('wizard.fields.guardian_relation') => $fieldValue($record->guardian_relation),
        __('wizard.fields.guardian_phone') => $fieldValue($record->guardian_phone),
        __('wizard.fields.other_phone') => $fieldValue($record->other_phone),
    ];
    $addressInfo = [
        __('wizard.fields.permanent_address') => $fieldValue($record->permanent_address),
        __('wizard.fields.current_address') => $fieldValue($record->current_address),
        __('wizard.fields.country') => $resolveCountryLabel($record->country),
        __('wizard.fields.city') => $fieldValue($record->city),
        __('wizard.fields.notes') => $fieldValue($record->con_sch),
    ];
    $medicalInfo = [
        __('wizard.fields.medical_notes') => $fieldValue($record->medical_notes),
        __('wizard.fields.chronic_diseases') => $fieldValue($record->chronic_diseases),
        __('wizard.fields.allergies') => $fieldValue($record->allergies),
        __('wizard.fields.fever_medicine_permission') => $resolveNullableBooleanLabel($record->fever_medicine_permission),
        __('wizard.fields.custody_notes') => $fieldValue($record->custody_notes),
    ];
    $academicInfo = [
        'الصف المطلوب' => optional($record->class)->name ?: $fieldValue($record->class1),
        'المدرسة السابقة' => $fieldValue($record->the_previous_school),
        'تاريخ تقديم الطلب' => $formatDate($record->created_at),
        'آخر خطوة مسجلة' => !is_null($record->current_step) ? (string) $record->current_step : 'تم الإرسال النهائي',
    ];
    $transportInfo = [
        'خدمة النقل' => $transportStatus['label'],
        'الموافقة على الشروط المدرسية' => $yesNoMeta($record->accepted_terms)['label'],
        'الموافقة على شروط النقل' => $yesNoMeta($record->accepted_transport_terms)['label'],
    ];
@endphp

<div class="admission-request-show">
    <div class="review-shell">
        <div class="review-hero">
            <div class="review-hero__top">
                <div class="review-hero__identity">
                    <div class="review-avatar">{{ $initials !== '' ? $initials : 'ST' }}</div>
                    <div>
                        <p class="review-kicker">طلب قبول رقم #{{ $record->id }}</p>
                        <h2>{{ $fullName ?: 'طلب قبول' }}</h2>
                        <p>{{ optional($record->class)->name ?: 'الصف غير محدد' }} | تم الإرسال في {{ $formatDate($record->created_at) }}</p>
                    </div>
                </div>
                <div class="review-hero__actions">
                    <a href="{{ route('studentadmission_requests') }}" class="btn btn-light">العودة إلى الطلبات</a>
                    @if($paymentReceiptDoc)
                        <a href="{{ $paymentReceiptDoc['download_url'] }}" class="btn btn-outline-primary">تنزيل إثبات الدفع</a>
                    @endif
                </div>
            </div>
            <div class="review-pill-row">
                <span class="review-pill {{ $requestStatus['class'] }}">{{ $requestStatus['label'] }}</span>
                <span class="review-pill {{ $paymentStatus['class'] }}">{{ $paymentStatus['label'] }}</span>
                <span class="review-pill {{ $transportStatus['class'] }}">{{ $transportStatus['label'] }}</span>
                <span class="review-pill {{ $paymentReceiptState['class'] }}">{{ $paymentReceiptState['label'] }}</span>
            </div>
        </div>

        <div class="review-layout">
            <div class="review-column">
                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>معلومات الطالب</h3>
                            <p>عرض منظم للهوية الأساسية وبيانات التواصل المدخلة من ولي الأمر.</p>
                        </div>
                    </div>
                    <div class="info-grid">
                        @foreach($studentInfo as $label => $value)
                            <div class="info-card">
                                <span class="info-card__label">{{ $label }}</span>
                                <div class="info-card__value">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>الأهل وبيانات التواصل</h3>
                            <p>معلومات الأسرة، هواتف الوالدين، وبيانات الوصاية كما وردت في الطلب.</p>
                        </div>
                    </div>
                    <div class="info-grid">
                        @foreach($parentInfo as $label => $value)
                            <div class="info-card">
                                <span class="info-card__label">{{ $label }}</span>
                                <div class="info-card__value">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>العنوان والسكن</h3>
                            <p>العنوان الدائم والعنوان الحالي وبلد الإقامة والمدينة وملاحظات التسجيل العامة.</p>
                        </div>
                    </div>
                    <div class="info-grid">
                        @foreach($addressInfo as $label => $value)
                            <div class="info-card">
                                <span class="info-card__label">{{ $label }}</span>
                                <div class="info-card__value">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>المعلومات الطبية والوصاية</h3>
                            <p>ملاحظات الحالة الصحية والحساسية والسماح الدوائي وملاحظات الحضانة القانونية.</p>
                        </div>
                    </div>
                    <div class="info-grid">
                        @foreach($medicalInfo as $label => $value)
                            <div class="info-card">
                                <span class="info-card__label">{{ $label }}</span>
                                <div class="info-card__value">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>المعلومات الأكاديمية</h3>
                            <p>الصف المطلوب والخلفية الدراسية وحالة اكتمال الطلب الحالية.</p>
                        </div>
                    </div>
                    <div class="info-grid">
                        @foreach($academicInfo as $label => $value)
                            <div class="info-card">
                                <span class="info-card__label">{{ $label }}</span>
                                <div class="info-card__value">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>المستندات المرفوعة</h3>
                            <p>مستندات الطالب الأساسية في مساحة مستقلة، مع إبقاء إثبات الدفع ضمن القسم المالي.</p>
                        </div>
                        <span class="review-pill is-muted">{{ count($primaryDocumentDocs) }} مستند</span>
                    </div>
                    @if(count($primaryDocumentDocs))
                        <div class="doc-grid">
                            @foreach($primaryDocumentDocs as $doc)
                                @php
                                    $ext = strtolower((string) ($doc['ext'] ?? 'file'));
                                    $existsClass = !empty($doc['exists']) ? 'is-success' : 'is-danger';
                                @endphp
                                <div class="doc-card">
                                    <div class="doc-card__top">
                                        <div class="doc-icon">{{ $ext !== '' ? $ext : 'file' }}</div>
                                        <div>
                                            <h4>{{ $doc['label'] }}</h4>
                                            <p>معاينة مباشرة أو تنزيل الملف مع الحفاظ على توافق المستندات القديمة والجديدة.</p>
                                        </div>
                                    </div>
                                    <div class="doc-meta">
                                        <span class="doc-badge">{{ strtoupper($ext !== '' ? $ext : 'FILE') }}</span>
                                        <span class="doc-badge {{ $existsClass }}">{{ !empty($doc['exists']) ? 'جاهز للمعاينة' : 'الملف غير متاح' }}</span>
                                    </div>
                                    <div class="doc-actions">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-primary js-viewer-trigger"
                                            data-url="{{ $doc['url'] }}"
                                            data-download-url="{{ $doc['download_url'] }}"
                                            data-label="{{ $doc['label'] }}"
                                            data-ext="{{ $doc['ext'] }}"
                                            data-exists="{{ !empty($doc['exists']) ? '1' : '0' }}">
                                            معاينة
                                        </button>
                                        <a href="{{ $doc['download_url'] }}" class="btn btn-sm btn-light">تنزيل</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-panel">لا توجد مستندات طالب متاحة للعرض حالياً.</div>
                    @endif

                    @if(count($legacyDocumentDocs))
                        <div class="review-card__subhead" style="margin-top: 1rem;">
                            <h4 style="margin: 0 0 .35rem;">المستندات الإضافية / القديمة</h4>
                            <p style="margin: 0;">هذه الملفات تظهر فقط إذا كانت محفوظة بالفعل في السجل، حتى لا تبدو كحقول مطلوبة في المسار الحالي.</p>
                        </div>
                        <div class="doc-grid">
                            @foreach($legacyDocumentDocs as $doc)
                                @php
                                    $ext = strtolower((string) ($doc['ext'] ?? 'file'));
                                    $existsClass = !empty($doc['exists']) ? 'is-success' : 'is-danger';
                                @endphp
                                <div class="doc-card">
                                    <div class="doc-card__top">
                                        <div class="doc-icon">{{ $ext !== '' ? $ext : 'file' }}</div>
                                        <div>
                                            <h4>{{ $doc['label'] }}</h4>
                                            <p>ملف قديم أو اختياري محفوظ في السجل الحالي.</p>
                                        </div>
                                    </div>
                                    <div class="doc-meta">
                                        <span class="doc-badge">{{ strtoupper($ext !== '' ? $ext : 'FILE') }}</span>
                                        <span class="doc-badge {{ $existsClass }}">{{ !empty($doc['exists']) ? 'جاهز للمعاينة' : 'الملف غير متاح' }}</span>
                                    </div>
                                    <div class="doc-actions">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-primary js-viewer-trigger"
                                            data-url="{{ $doc['url'] }}"
                                            data-download-url="{{ $doc['download_url'] }}"
                                            data-label="{{ $doc['label'] }}"
                                            data-ext="{{ $doc['ext'] }}"
                                            data-exists="{{ !empty($doc['exists']) ? '1' : '0' }}">
                                            معاينة
                                        </button>
                                        <a href="{{ $doc['download_url'] }}" class="btn btn-sm btn-light">تنزيل</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="review-column">
                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>الحالة والموافقات</h3>
                            <p>ملخص سريع لحالة الطلب الحالية، النقل، وقبول الشروط.</p>
                        </div>
                    </div>
                    <div class="status-list">
                        <div class="status-item">
                            <span class="status-item__label">حالة الطلب</span>
                            <span class="review-pill {{ $requestStatus['class'] }}">{{ $requestStatus['label'] }}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">حالة الدفع</span>
                            <span class="review-pill {{ $paymentStatus['class'] }}">{{ $paymentStatus['label'] }}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">خدمة النقل</span>
                            <span class="review-pill {{ $transportStatus['class'] }}">{{ $transportStatus['label'] }}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">قبول الشروط المدرسية</span>
                            @php $schoolTermsMeta = $yesNoMeta($record->accepted_terms); @endphp
                            <span class="review-pill {{ $schoolTermsMeta['class'] }}">{{ $schoolTermsMeta['label'] }}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">قبول شروط النقل</span>
                            @php $transportTermsMeta = $yesNoMeta($record->accepted_transport_terms); @endphp
                            <span class="review-pill {{ $transportTermsMeta['class'] }}">{{ $transportTermsMeta['label'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>الرسوم والدفع</h3>
                            <p>تفصيل الرسوم المعتمدة في الإعدادات مع حالة الدفع الحالية وإثبات التحويل.</p>
                        </div>
                    </div>
                    <div class="money-grid">
                        <div class="money-card">
                            <span class="money-card__label">رسوم التسجيل</span>
                            <span class="money-card__value">{{ $formatMoney($record->registration_fee) }}</span>
                        </div>
                        <div class="money-card">
                            <span class="money-card__label">رسوم الخدمات</span>
                            <span class="money-card__value">{{ $formatMoney($record->services_fee) }}</span>
                        </div>
                        <div class="money-card">
                            <span class="money-card__label">رسوم النقل</span>
                            <span class="money-card__value">{{ $formatMoney($record->transport_fee) }}</span>
                        </div>
                        <div class="money-card is-total">
                            <span class="money-card__label">الإجمالي</span>
                            <span class="money-card__value">{{ $formatMoney($record->total_amount) }}</span>
                        </div>
                    </div>

                    <div class="status-list" style="margin-bottom: .8rem;">
                        <div class="status-item">
                            <span class="status-item__label">طريقة الدفع</span>
                            <div class="info-card__value">{{ $paymentMethodLabel }}</div>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">تاريخ الدفع</span>
                            <div class="info-card__value">{{ $formatDate($record->payment_date) }}</div>
                        </div>
                    </div>

                    <div class="payment-proof">
                        <div class="payment-proof__meta">
                            <div>
                                <p class="payment-proof__title">إثبات الدفع</p>
                                <p class="payment-proof__hint">تم فصل إثبات الدفع عن مستندات الطالب العامة لتسهيل المراجعة المالية.</p>
                            </div>
                            <span class="review-pill {{ $paymentReceiptState['class'] }}">{{ $paymentReceiptState['label'] }}</span>
                        </div>

                        @if($paymentReceiptDoc)
                            <div class="doc-meta">
                                <span class="doc-badge">{{ strtoupper((string) ($paymentReceiptDoc['ext'] ?: 'FILE')) }}</span>
                                <span class="doc-badge {{ !empty($paymentReceiptDoc['exists']) ? 'is-success' : 'is-danger' }}">{{ !empty($paymentReceiptDoc['exists']) ? 'جاهز للمعاينة' : 'الملف غير متاح' }}</span>
                            </div>
                            <div class="doc-actions">
                                <button
                                    type="button"
                                    class="btn btn-outline-primary js-viewer-trigger"
                                    data-url="{{ $paymentReceiptDoc['url'] }}"
                                    data-download-url="{{ $paymentReceiptDoc['download_url'] }}"
                                    data-label="{{ $paymentReceiptDoc['label'] }}"
                                    data-ext="{{ $paymentReceiptDoc['ext'] }}"
                                    data-exists="{{ !empty($paymentReceiptDoc['exists']) ? '1' : '0' }}">
                                    معاينة الإثبات
                                </button>
                                <a href="{{ $paymentReceiptDoc['download_url'] }}" class="btn btn-light">تنزيل الإثبات</a>
                            </div>
                        @else
                            <div class="empty-panel">لم يتم رفع إثبات دفع لهذا الطلب بعد.</div>
                        @endif
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>النقل والشروط</h3>
                            <p>مرجع سريع لتفاصيل النقل ومدى اكتمال الموافقات المطلوبة من ولي الأمر.</p>
                        </div>
                    </div>
                    <div class="info-grid">
                        @foreach($transportInfo as $label => $value)
                            <div class="info-card">
                                <span class="info-card__label">{{ $label }}</span>
                                <div class="info-card__value">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="review-card approve-form">
                    <div class="review-card__head">
                        <div>
                            <h3>اعتماد الطالب</h3>
                            <p>يتم إنشاء سجلات الطالب الأكاديمية والفواتير المرتبطة مباشرة بعد الاعتماد، مع الحفاظ على نفس التدفق الخلفي الحالي.</p>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger finance-adjust-errors">
                            <ul class="mb-0 pr-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('approve_student') }}">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $record->id }}">
                        <div class="row">
                            <div class="col-12">
                                <label for="approve_class_id">الصف النهائي</label>
                                <select name="class_id" id="approve_class_id" class="form-control" required>
                                    <option value="">اختر الصف</option>
                                    @foreach ($classes as $item)
                                        <option value="{{ $item->id }}" {{ (string) $record->class1 === (string) $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="approve_room_id">الشعبة</label>
                                <select name="room_id" id="approve_room_id" class="form-control" required></select>
                            </div>
                            <div class="col-12">
                                <div class="finance-adjust-grid">
                                    <div class="finance-adjust-card">
                                        <div class="finance-adjust-meta">
                                            <label for="school_paid_amount" class="mb-0">المبلغ المحتسب على الرسوم المدرسية والخدمات</label>
                                            <span class="finance-adjust-limit">الحد الأقصى: {{ $formatMoney($schoolFeesTotal) }}</span>
                                        </div>
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            max="{{ $schoolFeesTotal }}"
                                            name="school_paid_amount"
                                            id="school_paid_amount"
                                            class="form-control"
                                            value="{{ $defaultSchoolPaidAmount }}"
                                            required>
                                        <p class="finance-adjust-hint">هذا هو المبلغ الذي سيتم إنشاؤه كفاتورة مدرسية فعلية داخل النظام المالي بعد الاعتماد.</p>
                                    </div>

                                    @if($hasTransportSelection)
                                        <div class="finance-adjust-card">
                                            <div class="finance-adjust-meta">
                                                <label for="transport_paid_amount" class="mb-0">المبلغ المحتسب على رسوم النقل</label>
                                                <span class="finance-adjust-limit">الحد الأقصى: {{ $formatMoney($transportFeesTotal) }}</span>
                                            </div>
                                            <input
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                max="{{ $transportFeesTotal }}"
                                                name="transport_paid_amount"
                                                id="transport_paid_amount"
                                                class="form-control"
                                                value="{{ $defaultTransportPaidAmount }}"
                                                required>
                                            <p class="finance-adjust-hint">يمكن تعديل هذا الحقل عند وصول دفعة جزئية للنقل، وسيتم استخدامه مباشرة في فاتورة النقل المنشأة.</p>
                                        </div>
                                    @else
                                        <div class="finance-adjust-card is-disabled">
                                            <div class="finance-adjust-meta">
                                                <label class="mb-0">رسوم النقل</label>
                                                <span class="finance-adjust-limit">غير مطلوبة</span>
                                            </div>
                                            <input type="hidden" name="transport_paid_amount" value="0">
                                            <input type="text" class="form-control" value="لا توجد خدمة نقل لهذا الطلب" disabled>
                                            <p class="finance-adjust-hint">سيتم تجاهل أي مبالغ نقل لهذا الطلب لأن ولي الأمر لم يطلب خدمة النقل.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button class="btn btn-success btn-block approve-submit" type="submit">اعتماد الطالب وإنشاء السجلات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mediaViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="mediaViewerTitle">معاينة مستند</span>
                    <span id="mediaViewerType" class="doc-badge">FILE</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="media-viewer-toolbar">
                    <div class="media-viewer-toolbar__actions">
                        <button type="button" class="media-tool" data-media-action="zoom-out">-</button>
                        <button type="button" class="media-tool" data-media-action="fit">احتواء</button>
                        <button type="button" class="media-tool" data-media-action="zoom-in">+</button>
                    </div>
                    <div class="media-viewer-toolbar__actions">
                        <span class="doc-badge" id="mediaViewerZoomLabel">100%</span>
                        <a href="#" id="mediaViewerDownload" class="btn btn-primary btn-sm">تنزيل</a>
                    </div>
                </div>
                <div class="media-stage">
                    <div class="media-stage__scroll" id="mediaViewerScroll">
                        <div class="media-stage__canvas" id="mediaViewerCanvas"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(function () {
    function loadRooms(classId, selectedRoomId) {
        $('#approve_room_id').html('');
        if (!classId) {
            return;
        }
        $.get("{{ URL::to('SMT/admin/classes/rooms') }}/" + classId, function (data) {
            $.each(data || [], function (_, value) {
                const isSelected = String(selectedRoomId) === String(value.id) ? 'selected' : '';
                $('#approve_room_id').append('<option value="' + value.id + '" ' + isSelected + '>' + value.name + '</option>');
            });
        });
    }

    const initialClass = $('#approve_class_id').val();
    loadRooms(initialClass, null);

    $(document).on('change', '#approve_class_id', function () {
        loadRooms($(this).val(), null);
    });

    const viewerState = {
        type: null,
        ext: '',
        baseUrl: '',
        downloadUrl: '',
        objectUrl: '',
        scale: 1,
        fit: true
    };
    const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

    function buildPdfUrl() {
        const cleanUrl = String(viewerState.baseUrl || viewerState.objectUrl || '').split('#')[0];
        const zoomValue = viewerState.fit ? 'page-width' : Math.round(viewerState.scale * 100);
        return cleanUrl + '#toolbar=0&navpanes=0&scrollbar=0&zoom=' + zoomValue;
    }

    function cleanupViewerObjectUrl() {
        if (viewerState.objectUrl) {
            try {
                URL.revokeObjectURL(viewerState.objectUrl);
            } catch (e) {
            }
            viewerState.objectUrl = '';
        }
    }

    function updateViewerToolbar() {
        const canZoom = viewerState.type === 'image' || viewerState.type === 'pdf';
        $('[data-media-action]').prop('disabled', !canZoom);
        $('#mediaViewerZoomLabel').text(viewerState.fit ? 'احتواء' : (Math.round(viewerState.scale * 100) + '%'));
    }

    function renderViewerState(message, alertClass) {
        const html = '' +
            '<div class="media-viewer-state">' +
                '<div class="alert ' + alertClass + '">' + message + '</div>' +
            '</div>';
        $('#mediaViewerCanvas').html(html);
        updateViewerToolbar();
    }

    function applyViewerScale() {
        if (viewerState.type === 'image') {
            $('#mediaViewerCanvas').find('.media-viewer-image').css('transform', 'scale(' + viewerState.scale + ')');
        } else if (viewerState.type === 'pdf') {
            const iframe = $('#mediaViewerCanvas').find('.media-viewer-frame');
            if (iframe.length) {
                iframe.attr('src', buildPdfUrl());
            }
        }
        updateViewerToolbar();
    }

    async function openViewer(url, downloadUrl, label, ext, existsFlag) {
        viewerState.type = null;
        viewerState.ext = String(ext || '').toLowerCase();
        viewerState.baseUrl = String(url || '');
        viewerState.downloadUrl = String(downloadUrl || url || '#');
        cleanupViewerObjectUrl();
        viewerState.scale = 1;
        viewerState.fit = true;

        $('#mediaViewerTitle').text(label || 'معاينة مستند');
        $('#mediaViewerType').text((viewerState.ext || 'file').toUpperCase());
        $('#mediaViewerDownload').attr('href', viewerState.downloadUrl);
        $('#mediaViewerCanvas').empty();

        if (String(existsFlag) !== '1') {
            renderViewerState('الملف غير متاح في المسار الحالي. يمكنك تنزيله لاحقاً إذا تمت إعادة مزامنته.', 'alert-warning');
            $('#mediaViewerModal').modal('show');
            return;
        }

        $('#mediaViewerModal').modal('show');

        if (imageExts.indexOf(viewerState.ext) !== -1) {
            viewerState.type = 'image';
            updateViewerToolbar();
            const img = $('<img>', {
                alt: label || 'preview',
                class: 'media-viewer-image'
            });
            img.on('load', function () {
                $('#mediaViewerCanvas').find('.media-viewer-state').remove();
                applyViewerScale();
            });
            img.on('error', function () {
                renderViewerState('تعذر تحميل الصورة داخل المعاينة. يمكنك تنزيل الملف مباشرة.', 'alert-warning');
            });
            $('#mediaViewerCanvas').append(img);
            img.attr('src', viewerState.baseUrl);
            return;
        }

        if (viewerState.ext === 'pdf') {
            viewerState.type = 'pdf';
            updateViewerToolbar();
            let pdfSrcAssigned = false;
            const iframe = $('<iframe>', {
                class: 'media-viewer-frame'
            });
            iframe.on('load', function () {
                if (!pdfSrcAssigned) {
                    return;
                }
                $('#mediaViewerCanvas').find('.media-viewer-state').remove();
                updateViewerToolbar();
            });
            iframe.on('error', function () {
                renderViewerState('تعذر عرض ملف PDF داخل المعاينة. يمكنك استخدام زر التنزيل إذا لزم الأمر.', 'alert-warning');
            });
            $('#mediaViewerCanvas').append(iframe);
            pdfSrcAssigned = true;
            iframe.attr('src', buildPdfUrl());
            return;
        }
    }

    $(document).on('click', '.js-viewer-trigger', function () {
        openViewer(
            $(this).data('url'),
            $(this).data('download-url'),
            $(this).data('label'),
            $(this).data('ext'),
            $(this).data('exists')
        );
    });

    $(document).on('click', '[data-media-action]', function () {
        const action = $(this).data('media-action');
        if (!(viewerState.type === 'image' || viewerState.type === 'pdf')) {
            return;
        }

        if (action === 'zoom-in') {
            viewerState.fit = false;
            viewerState.scale = Math.min(viewerState.scale + 0.2, 3);
        } else if (action === 'zoom-out') {
            viewerState.fit = false;
            viewerState.scale = Math.max(viewerState.scale - 0.2, 0.6);
        } else if (action === 'fit') {
            viewerState.fit = true;
            viewerState.scale = 1;
        }

        applyViewerScale();
    });

    $('#mediaViewerModal').on('hidden.bs.modal', function () {
        $('#mediaViewerCanvas').empty();
        cleanupViewerObjectUrl();
        viewerState.type = null;
        viewerState.baseUrl = '';
        viewerState.downloadUrl = '';
        viewerState.scale = 1;
        viewerState.fit = true;
        updateViewerToolbar();
    });

    updateViewerToolbar();
});
</script>
@endsection
