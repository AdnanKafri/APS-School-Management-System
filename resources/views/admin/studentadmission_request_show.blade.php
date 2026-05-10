@extends('admin.layouts.v2')

@section('page_title', 'Ã˜ÂªÃ™ÂÃ˜Â§Ã˜ÂµÃ™Å Ã™â€ž Ã˜Â·Ã™â€žÃ˜Â¨ Ã˜Â§Ã™â€žÃ™â€šÃ˜Â¨Ã™Ë†Ã™â€ž')
@section('page_subtitle', 'Ã™â€¦Ã˜Â±Ã˜Â§Ã˜Â¬Ã˜Â¹Ã˜Â© Ã˜Â´Ã˜Â§Ã™â€¦Ã™â€žÃ˜Â© Ã™â€žÃ˜Â¨Ã™Å Ã˜Â§Ã™â€ Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â·Ã˜Â§Ã™â€žÃ˜Â¨ Ã™Ë†Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹Ã˜Â© Ã™Ë†Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯Ã˜Â§Ã˜Âª Ã™â€šÃ˜Â¨Ã™â€ž Ã˜Â§Ã™â€žÃ˜Â§Ã˜Â¹Ã˜ÂªÃ™â€¦Ã˜Â§Ã˜Â¯')

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
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">Ã˜Â§Ã™â€žÃ˜Â±Ã˜Â¦Ã™Å Ã˜Â³Ã™Å Ã˜Â©</a>
    <a href="{{ route('studentadmission') }}" class="breadcrumbs__item">Ã™â€šÃ˜Â³Ã™â€¦ Ã˜Â§Ã™â€žÃ™â€šÃ˜Â¨Ã™Ë†Ã™â€ž</a>
    <a href="{{ route('studentadmission_requests') }}" class="breadcrumbs__item">Ã˜Â·Ã™â€žÃ˜Â¨Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ™â€šÃ˜Â¨Ã™Ë†Ã™â€ž</a>
    <a class="breadcrumbs__item is-active">Ã˜ÂªÃ™ÂÃ˜Â§Ã˜ÂµÃ™Å Ã™â€ž Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨</a>
</nav>
@endsection

@section('content')
@php
    $fullName = trim((string) ($record->first_name . ' ' . $record->last_name));
    $initials = mb_strtoupper(trim(mb_substr((string) $record->first_name, 0, 1) . mb_substr((string) $record->last_name, 0, 1)));
    $paymentMethodMap = [
        '0' => 'Ã˜ÂªÃ˜Â­Ã™Ë†Ã™Å Ã™â€ž Ã™Å Ã˜Â¯Ã™Ë†Ã™Å ',
        '1' => 'ShamCash',
        'manual' => 'Ã˜ÂªÃ˜Â­Ã™Ë†Ã™Å Ã™â€ž Ã™Å Ã˜Â¯Ã™Ë†Ã™Å ',
        'shamcash' => 'ShamCash',
    ];
    $paymentMethodKey = (string) $record->payment_method;
    $paymentMethodLabel = $paymentMethodMap[$paymentMethodKey] ?? ($paymentMethodKey !== '' ? $paymentMethodKey : 'Ã˜ÂºÃ™Å Ã˜Â± Ã™â€¦Ã˜Â­Ã˜Â¯Ã˜Â¯');
    $paymentStatusKey = strtolower((string) ($record->payment_status ?: 'pending'));
    $paymentStatusMap = [
        'pending' => ['label' => 'Ã˜Â¨Ã˜Â§Ã™â€ Ã˜ÂªÃ˜Â¸Ã˜Â§Ã˜Â± Ã˜Â§Ã™â€žÃ˜ÂªÃ˜Â­Ã™â€šÃ™â€š', 'class' => 'is-warning'],
        'paid' => ['label' => 'Ã™â€¦Ã˜Â¯Ã™ÂÃ™Ë†Ã˜Â¹', 'class' => 'is-success'],
        'rejected' => ['label' => 'Ã™â€¦Ã˜Â±Ã™ÂÃ™Ë†Ã˜Â¶', 'class' => 'is-danger'],
    ];
    $paymentStatus = $paymentStatusMap[$paymentStatusKey] ?? ['label' => ($record->payment_status ?: 'Ã˜ÂºÃ™Å Ã˜Â± Ã™â€¦Ã˜Â­Ã˜Â¯Ã˜Â¯'), 'class' => 'is-muted'];
    if (is_null($record->current_step) && !empty($record->payment_receipt)) {
        $requestStatus = ['label' => 'Ã™â€¦Ã™Æ’Ã˜ÂªÃ™â€¦Ã™â€ž Ã™Ë†Ã˜Â¬Ã˜Â§Ã™â€¡Ã˜Â² Ã™â€žÃ™â€žÃ™â€¦Ã˜Â±Ã˜Â§Ã˜Â¬Ã˜Â¹Ã˜Â©', 'class' => 'is-success'];
    } elseif (!is_null($record->current_step)) {
        $requestStatus = ['label' => 'Ã˜Â·Ã™â€žÃ˜Â¨ Ã˜ÂºÃ™Å Ã˜Â± Ã™â€¦Ã™Æ’Ã˜ÂªÃ™â€¦Ã™â€ž', 'class' => 'is-warning'];
    } else {
        $requestStatus = ['label' => 'Ã˜Â¨Ã˜Â­Ã˜Â§Ã˜Â¬Ã˜Â© Ã˜Â¥Ã™â€žÃ™â€° Ã™â€¦Ã˜ÂªÃ˜Â§Ã˜Â¨Ã˜Â¹Ã˜Â©', 'class' => 'is-muted'];
    }
    $transportStatus = (int) $record->wants_transport === 1
        ? ['label' => 'Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž Ã™â€¦Ã˜Â·Ã™â€žÃ™Ë†Ã˜Â¨', 'class' => 'is-success']
        : ['label' => 'Ã˜Â¨Ã˜Â¯Ã™Ë†Ã™â€  Ã™â€ Ã™â€šÃ™â€ž', 'class' => 'is-muted'];
    $schoolFeesTotal = (float) ($record->registration_fee ?? 0) + (float) ($record->services_fee ?? 0);
    if ($schoolFeesTotal <= 0) {
        $schoolFeesTotal = (float) ($record->total_amount ?? 0);
    }
    $hasTransportSelection = (int) $record->wants_transport === 1;
    $transportFeesTotal = $hasTransportSelection ? (float) ($record->transport_fee ?? 0) : 0;
    $defaultSchoolPaidAmount = old('school_paid_amount', $schoolFeesTotal);
    $defaultTransportPaidAmount = old('transport_paid_amount', $transportFeesTotal);
    $paymentReceiptState = !empty($record->payment_receipt)
        ? ['label' => 'Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â¯Ã™ÂÃ˜Â¹ Ã™â€¦Ã˜Â±Ã™ÂÃ™Ë†Ã˜Â¹', 'class' => 'is-success']
        : ['label' => 'Ã™â€žÃ˜Â§ Ã™Å Ã™Ë†Ã˜Â¬Ã˜Â¯ Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â¯Ã™ÂÃ˜Â¹', 'class' => 'is-danger'];
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
        return number_format((float) $value, 2) . ' Ã™â€ž.Ã˜Â³';
    };
    $yesNoMeta = function ($value) {
        return (int) $value === 1
            ? ['label' => 'Ã™â€ Ã˜Â¹Ã™â€¦', 'class' => 'is-success']
            : ['label' => 'Ã™â€žÃ˜Â§', 'class' => 'is-danger'];
    };
    $fieldValue = function ($value) {
        return trim((string) $value) !== '' ? (string) $value : '-';
    };

    $documentLabelsByPath = [
        (string) $record->personal_image => 'Ã˜Â§Ã™â€žÃ˜ÂµÃ™Ë†Ã˜Â±Ã˜Â© Ã˜Â§Ã™â€žÃ˜Â´Ã˜Â®Ã˜ÂµÃ™Å Ã˜Â©',
        (string) $record->mother_image => 'Ã™â€¡Ã™Ë†Ã™Å Ã˜Â© Ã˜Â§Ã™â€žÃ˜Â£Ã™â€¦',
        (string) $record->father_image => 'Ã™â€¡Ã™Ë†Ã™Å Ã˜Â© Ã˜Â§Ã™â€žÃ˜Â£Ã˜Â¨',
        (string) $record->fourth_image => 'Ã˜Â¥Ã˜Â®Ã˜Â±Ã˜Â§Ã˜Â¬ Ã™â€šÃ™Å Ã˜Â¯ / Ã˜Â´Ã™â€¡Ã˜Â§Ã˜Â¯Ã˜Â© Ã™â€¦Ã™Å Ã™â€žÃ˜Â§Ã˜Â¯',
        (string) $record->passbord => 'Ã˜Â¬Ã™Ë†Ã˜Â§Ã˜Â² Ã˜Â§Ã™â€žÃ˜Â³Ã™ÂÃ˜Â±',
        (string) $record->mather_page => 'Ã˜Â¬Ã™Ë†Ã˜Â§Ã˜Â² Ã˜Â§Ã™â€žÃ˜Â£Ã™â€¦',
        (string) $record->father_page => 'Ã˜Â¬Ã™Ë†Ã˜Â§Ã˜Â² Ã˜Â§Ã™â€žÃ˜Â£Ã˜Â¨',
        (string) $record->family_book => 'Ã˜Â¯Ã™ÂÃ˜ÂªÃ˜Â± Ã˜Â§Ã™â€žÃ˜Â¹Ã˜Â§Ã˜Â¦Ã™â€žÃ˜Â©',
        (string) $record->study_sequence => 'Ã˜Â§Ã™â€žÃ˜ÂªÃ˜Â³Ã™â€žÃ˜Â³Ã™â€ž Ã˜Â§Ã™â€žÃ˜Â¯Ã˜Â±Ã˜Â§Ã˜Â³Ã™Å ',
        (string) $record->certification => 'Ã˜Â¢Ã˜Â®Ã˜Â± Ã˜Â´Ã™â€¡Ã˜Â§Ã˜Â¯Ã˜Â©',
        (string) $record->certification_nine => 'Ã˜Â´Ã™â€¡Ã˜Â§Ã˜Â¯Ã˜Â© Ã˜Â§Ã™â€žÃ˜ÂªÃ˜Â§Ã˜Â³Ã˜Â¹',
    ];

    $paymentReceiptDoc = null;
    $documentDocs = [];
    foreach ((array) $docsMeta as $doc) {
        $labelPath = (string) ($doc['label_path'] ?? '');
        if ($labelPath !== '' && $labelPath === (string) $record->payment_receipt) {
            $doc['label'] = 'Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹';
            $paymentReceiptDoc = $doc;
            continue;
        }
        $doc['label'] = $documentLabelsByPath[$labelPath] ?? 'Ã™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯ Ã˜Â¥Ã˜Â¶Ã˜Â§Ã™ÂÃ™Å ';
        $documentDocs[] = $doc;
    }
    if (!$paymentReceiptDoc && !empty($paymentReceiptMeta)) {
        $paymentReceiptMeta['label'] = 'Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹';
        $paymentReceiptDoc = $paymentReceiptMeta;
    }

    $studentInfo = [
        'Ã˜Â§Ã™â€žÃ˜Â§Ã˜Â³Ã™â€¦ Ã˜Â§Ã™â€žÃ™Æ’Ã˜Â§Ã™â€¦Ã™â€ž' => $fullName ?: '-',
        'Ã˜Â±Ã™â€šÃ™â€¦ Ã˜Â§Ã™â€žÃ™â€¡Ã˜Â§Ã˜ÂªÃ™Â' => $fieldValue($record->phone),
        'Ã˜Â§Ã™â€žÃ˜Â¨Ã˜Â±Ã™Å Ã˜Â¯ Ã˜Â§Ã™â€žÃ˜Â¥Ã™â€žÃ™Æ’Ã˜ÂªÃ˜Â±Ã™Ë†Ã™â€ Ã™Å ' => $fieldValue($record->email),
        'Ã˜ÂªÃ˜Â§Ã˜Â±Ã™Å Ã˜Â® Ã˜Â§Ã™â€žÃ™â€¦Ã™Å Ã™â€žÃ˜Â§Ã˜Â¯' => $fieldValue($record->date),
        'Ã˜Â§Ã™â€žÃ˜Â¬Ã™â€ Ã˜Â³Ã™Å Ã˜Â©' => $fieldValue($record->nationality),
        'Ã™â€¦Ã™Æ’Ã˜Â§Ã™â€  Ã˜Â§Ã™â€žÃ™Ë†Ã™â€žÃ˜Â§Ã˜Â¯Ã˜Â©' => $fieldValue($record->place_of_birth),
        'Ã˜Â±Ã™â€šÃ™â€¦ Ã˜Â§Ã™â€žÃ™â€¡Ã™Ë†Ã™Å Ã˜Â© / Ã˜Â§Ã™â€žÃ™Ë†Ã˜Â·Ã™â€ Ã™Å ' => $fieldValue($record->the_ID_number),
        'Ã˜Â±Ã™â€šÃ™â€¦ Ã˜Â¬Ã™Ë†Ã˜Â§Ã˜Â² Ã˜Â§Ã™â€žÃ˜Â³Ã™ÂÃ˜Â±' => $fieldValue($record->passport_number),
    ];
    $parentInfo = [
        'Ã˜Â§Ã˜Â³Ã™â€¦ Ã˜Â§Ã™â€žÃ˜Â£Ã˜Â¨' => $fieldValue($record->father_name),
        'Ã˜Â§Ã˜Â³Ã™â€¦ Ã˜Â§Ã™â€žÃ˜Â£Ã™â€¦' => $fieldValue($record->mather_name),
        'Ã™â€¡Ã˜Â§Ã˜ÂªÃ™Â Ã˜Â§Ã™â€žÃ˜Â£Ã˜Â¨' => $fieldValue($record->father_phone),
        'Ã™â€¡Ã˜Â§Ã˜ÂªÃ™Â Ã˜Â§Ã™â€žÃ˜Â£Ã™â€¦' => $fieldValue($record->mather_phone),
        'Ã™â€¡Ã˜Â§Ã˜ÂªÃ™Â Ã˜Â¥Ã˜Â¶Ã˜Â§Ã™ÂÃ™Å ' => $fieldValue($record->other_phone),
        'Ã˜Â¨Ã™â€žÃ˜Â¯ Ã˜Â§Ã™â€žÃ˜Â¥Ã™â€šÃ˜Â§Ã™â€¦Ã˜Â©' => $fieldValue($record->country),
        'Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¯Ã™Å Ã™â€ Ã˜Â©' => $fieldValue($record->city),
        'Ã˜Â§Ã™â€žÃ˜Â¹Ã™â€ Ã™Ë†Ã˜Â§Ã™â€  / Ã˜Â§Ã™â€žÃ™â€¦Ã™â€žÃ˜Â§Ã˜Â­Ã˜Â¸Ã˜Â§Ã˜Âª' => $fieldValue($record->con_sch),
    ];
    $academicInfo = [
        'Ã˜Â§Ã™â€žÃ˜ÂµÃ™Â Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â·Ã™â€žÃ™Ë†Ã˜Â¨' => optional($record->class)->name ?: $fieldValue($record->class1),
        'Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¯Ã˜Â±Ã˜Â³Ã˜Â© Ã˜Â§Ã™â€žÃ˜Â³Ã˜Â§Ã˜Â¨Ã™â€šÃ˜Â©' => $fieldValue($record->the_previous_school),
        'Ã˜ÂªÃ˜Â§Ã˜Â±Ã™Å Ã˜Â® Ã˜ÂªÃ™â€šÃ˜Â¯Ã™Å Ã™â€¦ Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨' => $formatDate($record->created_at),
        'Ã˜Â¢Ã˜Â®Ã˜Â± Ã˜Â®Ã˜Â·Ã™Ë†Ã˜Â© Ã™â€¦Ã˜Â³Ã˜Â¬Ã™â€žÃ˜Â©' => !is_null($record->current_step) ? (string) $record->current_step : 'Ã˜ÂªÃ™â€¦ Ã˜Â§Ã™â€žÃ˜Â¥Ã˜Â±Ã˜Â³Ã˜Â§Ã™â€ž Ã˜Â§Ã™â€žÃ™â€ Ã™â€¡Ã˜Â§Ã˜Â¦Ã™Å ',
    ];
    $transportInfo = [
        'Ã˜Â®Ã˜Â¯Ã™â€¦Ã˜Â© Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž' => $transportStatus['label'],
        'Ã˜Â§Ã™â€žÃ™â€¦Ã™Ë†Ã˜Â§Ã™ÂÃ™â€šÃ˜Â© Ã˜Â¹Ã™â€žÃ™â€° Ã˜Â§Ã™â€žÃ˜Â´Ã˜Â±Ã™Ë†Ã˜Â· Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¯Ã˜Â±Ã˜Â³Ã™Å Ã˜Â©' => $yesNoMeta($record->accepted_terms)['label'],
        'Ã˜Â§Ã™â€žÃ™â€¦Ã™Ë†Ã˜Â§Ã™ÂÃ™â€šÃ˜Â© Ã˜Â¹Ã™â€žÃ™â€° Ã˜Â´Ã˜Â±Ã™Ë†Ã˜Â· Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž' => $yesNoMeta($record->accepted_transport_terms)['label'],
    ];
@endphp

<div class="admission-request-show">
    <div class="review-shell">
        <div class="review-hero">
            <div class="review-hero__top">
                <div class="review-hero__identity">
                    <div class="review-avatar">{{ $initials !== '' ? $initials : 'ST' }}</div>
                    <div>
                        <p class="review-kicker">Ã˜Â·Ã™â€žÃ˜Â¨ Ã™â€šÃ˜Â¨Ã™Ë†Ã™â€ž Ã˜Â±Ã™â€šÃ™â€¦ #{{ $record->id }}</p>
                        <h2>{{ $fullName ?: 'Ã˜Â·Ã™â€žÃ˜Â¨ Ã™â€šÃ˜Â¨Ã™Ë†Ã™â€ž' }}</h2>
                        <p>{{ optional($record->class)->name ?: 'Ã˜Â§Ã™â€žÃ˜ÂµÃ™Â Ã˜ÂºÃ™Å Ã˜Â± Ã™â€¦Ã˜Â­Ã˜Â¯Ã˜Â¯' }} | Ã˜ÂªÃ™â€¦ Ã˜Â§Ã™â€žÃ˜Â¥Ã˜Â±Ã˜Â³Ã˜Â§Ã™â€ž Ã™ÂÃ™Å  {{ $formatDate($record->created_at) }}</p>
                    </div>
                </div>
                <div class="review-hero__actions">
                    <a href="{{ route('studentadmission_requests') }}" class="btn btn-light">Ã˜Â§Ã™â€žÃ˜Â¹Ã™Ë†Ã˜Â¯Ã˜Â© Ã˜Â¥Ã™â€žÃ™â€° Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨Ã˜Â§Ã˜Âª</a>
                    @if($paymentReceiptDoc)
                        <a href="{{ $paymentReceiptDoc['download_url'] }}" class="btn btn-outline-primary">Ã˜ÂªÃ™â€ Ã˜Â²Ã™Å Ã™â€ž Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹</a>
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
                            <h3>Ã™â€¦Ã˜Â¹Ã™â€žÃ™Ë†Ã™â€¦Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â·Ã˜Â§Ã™â€žÃ˜Â¨</h3>
                            <p>Ã˜Â¹Ã˜Â±Ã˜Â¶ Ã™â€¦Ã™â€ Ã˜Â¸Ã™â€¦ Ã™â€žÃ™â€žÃ™â€¡Ã™Ë†Ã™Å Ã˜Â© Ã˜Â§Ã™â€žÃ˜Â£Ã˜Â³Ã˜Â§Ã˜Â³Ã™Å Ã˜Â© Ã™Ë†Ã˜Â¨Ã™Å Ã˜Â§Ã™â€ Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜ÂªÃ™Ë†Ã˜Â§Ã˜ÂµÃ™â€ž Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¯Ã˜Â®Ã™â€žÃ˜Â© Ã™â€¦Ã™â€  Ã™Ë†Ã™â€žÃ™Å  Ã˜Â§Ã™â€žÃ˜Â£Ã™â€¦Ã˜Â±.</p>
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
                            <h3>Ã˜Â§Ã™â€žÃ˜Â£Ã™â€¡Ã™â€ž Ã™Ë†Ã˜Â¨Ã™Å Ã˜Â§Ã™â€ Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜ÂªÃ™Ë†Ã˜Â§Ã˜ÂµÃ™â€ž</h3>
                            <p>Ã™â€¦Ã˜Â¹Ã™â€žÃ™Ë†Ã™â€¦Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â£Ã˜Â³Ã˜Â±Ã˜Â© Ã™Ë†Ã˜Â§Ã™â€žÃ˜Â§Ã˜ÂªÃ˜ÂµÃ˜Â§Ã™â€ž Ã™Ë†Ã˜Â§Ã™â€žÃ˜Â¹Ã™â€ Ã™Ë†Ã˜Â§Ã™â€  Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â§Ã™â€žÃ™Å  Ã™Æ’Ã™â€¦Ã˜Â§ Ã™Ë†Ã˜Â±Ã˜Â¯Ã˜Âª Ã™ÂÃ™Å  Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨.</p>
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
                            <h3>Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¹Ã™â€žÃ™Ë†Ã™â€¦Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â£Ã™Æ’Ã˜Â§Ã˜Â¯Ã™Å Ã™â€¦Ã™Å Ã˜Â©</h3>
                            <p>Ã˜Â§Ã™â€žÃ˜ÂµÃ™Â Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â·Ã™â€žÃ™Ë†Ã˜Â¨ Ã™Ë†Ã˜Â§Ã™â€žÃ˜Â®Ã™â€žÃ™ÂÃ™Å Ã˜Â© Ã˜Â§Ã™â€žÃ˜Â¯Ã˜Â±Ã˜Â§Ã˜Â³Ã™Å Ã˜Â© Ã™Ë†Ã˜Â­Ã˜Â§Ã™â€žÃ˜Â© Ã˜Â§Ã™Æ’Ã˜ÂªÃ™â€¦Ã˜Â§Ã™â€ž Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨ Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â§Ã™â€žÃ™Å Ã˜Â©.</p>
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
                            <h3>Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â±Ã™ÂÃ™Ë†Ã˜Â¹Ã˜Â©</h3>
                            <p>Ã™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â·Ã˜Â§Ã™â€žÃ˜Â¨ Ã˜Â§Ã™â€žÃ˜Â£Ã˜Â³Ã˜Â§Ã˜Â³Ã™Å Ã˜Â© Ã™ÂÃ™Å  Ã™â€¦Ã˜Â³Ã˜Â§Ã˜Â­Ã˜Â© Ã™â€¦Ã˜Â³Ã˜ÂªÃ™â€šÃ™â€žÃ˜Â©Ã˜Å’ Ã™â€¦Ã˜Â¹ Ã˜Â¥Ã˜Â¨Ã™â€šÃ˜Â§Ã˜Â¡ Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹ Ã˜Â¶Ã™â€¦Ã™â€  Ã˜Â§Ã™â€žÃ™â€šÃ˜Â³Ã™â€¦ Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â§Ã™â€žÃ™Å .</p>
                        </div>
                        <span class="review-pill is-muted">{{ count($documentDocs) }} Ã™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯</span>
                    </div>
                    @if(count($documentDocs))
                        <div class="doc-grid">
                            @foreach($documentDocs as $doc)
                                @php
                                    $ext = strtolower((string) ($doc['ext'] ?? 'file'));
                                    $existsClass = !empty($doc['exists']) ? 'is-success' : 'is-danger';
                                @endphp
                                <div class="doc-card">
                                    <div class="doc-card__top">
                                        <div class="doc-icon">{{ $ext !== '' ? $ext : 'file' }}</div>
                                        <div>
                                            <h4>{{ $doc['label'] }}</h4>
                                            <p>Ã™â€¦Ã˜Â¹Ã˜Â§Ã™Å Ã™â€ Ã˜Â© Ã™â€¦Ã˜Â¨Ã˜Â§Ã˜Â´Ã˜Â±Ã˜Â© Ã˜Â£Ã™Ë† Ã˜ÂªÃ™â€ Ã˜Â²Ã™Å Ã™â€ž Ã˜Â§Ã™â€žÃ™â€¦Ã™â€žÃ™Â Ã™â€¦Ã˜Â¹ Ã˜Â§Ã™â€žÃ˜Â­Ã™ÂÃ˜Â§Ã˜Â¸ Ã˜Â¹Ã™â€žÃ™â€° Ã˜ÂªÃ™Ë†Ã˜Â§Ã™ÂÃ™â€š Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ™â€šÃ˜Â¯Ã™Å Ã™â€¦Ã˜Â© Ã™Ë†Ã˜Â§Ã™â€žÃ˜Â¬Ã˜Â¯Ã™Å Ã˜Â¯Ã˜Â©.</p>
                                        </div>
                                    </div>
                                    <div class="doc-meta">
                                        <span class="doc-badge">{{ strtoupper($ext !== '' ? $ext : 'FILE') }}</span>
                                        <span class="doc-badge {{ $existsClass }}">{{ !empty($doc['exists']) ? 'Ã˜Â¬Ã˜Â§Ã™â€¡Ã˜Â² Ã™â€žÃ™â€žÃ™â€¦Ã˜Â¹Ã˜Â§Ã™Å Ã™â€ Ã˜Â©' : 'Ã˜Â§Ã™â€žÃ™â€¦Ã™â€žÃ™Â Ã˜ÂºÃ™Å Ã˜Â± Ã™â€¦Ã˜ÂªÃ˜Â§Ã˜Â­' }}</span>
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
                                            Ã™â€¦Ã˜Â¹Ã˜Â§Ã™Å Ã™â€ Ã˜Â©
                                        </button>
                                        <a href="{{ $doc['download_url'] }}" class="btn btn-sm btn-light">Ã˜ÂªÃ™â€ Ã˜Â²Ã™Å Ã™â€ž</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-panel">Ã™â€žÃ˜Â§ Ã˜ÂªÃ™Ë†Ã˜Â¬Ã˜Â¯ Ã™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯Ã˜Â§Ã˜Âª Ã˜Â·Ã˜Â§Ã™â€žÃ˜Â¨ Ã™â€¦Ã˜ÂªÃ˜Â§Ã˜Â­Ã˜Â© Ã™â€žÃ™â€žÃ˜Â¹Ã˜Â±Ã˜Â¶ Ã˜Â­Ã˜Â§Ã™â€žÃ™Å Ã˜Â§Ã™â€¹.</div>
                    @endif
                </div>
            </div>

            <div class="review-column">
                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â§Ã™â€žÃ˜Â© Ã™Ë†Ã˜Â§Ã™â€žÃ™â€¦Ã™Ë†Ã˜Â§Ã™ÂÃ™â€šÃ˜Â§Ã˜Âª</h3>
                            <p>Ã™â€¦Ã™â€žÃ˜Â®Ã˜Âµ Ã˜Â³Ã˜Â±Ã™Å Ã˜Â¹ Ã™â€žÃ˜Â­Ã˜Â§Ã™â€žÃ˜Â© Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨ Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â§Ã™â€žÃ™Å Ã˜Â©Ã˜Å’ Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€žÃ˜Å’ Ã™Ë†Ã™â€šÃ˜Â¨Ã™Ë†Ã™â€ž Ã˜Â§Ã™â€žÃ˜Â´Ã˜Â±Ã™Ë†Ã˜Â·.</p>
                        </div>
                    </div>
                    <div class="status-list">
                        <div class="status-item">
                            <span class="status-item__label">Ã˜Â­Ã˜Â§Ã™â€žÃ˜Â© Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨</span>
                            <span class="review-pill {{ $requestStatus['class'] }}">{{ $requestStatus['label'] }}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">Ã˜Â­Ã˜Â§Ã™â€žÃ˜Â© Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹</span>
                            <span class="review-pill {{ $paymentStatus['class'] }}">{{ $paymentStatus['label'] }}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">Ã˜Â®Ã˜Â¯Ã™â€¦Ã˜Â© Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž</span>
                            <span class="review-pill {{ $transportStatus['class'] }}">{{ $transportStatus['label'] }}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">Ã™â€šÃ˜Â¨Ã™Ë†Ã™â€ž Ã˜Â§Ã™â€žÃ˜Â´Ã˜Â±Ã™Ë†Ã˜Â· Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¯Ã˜Â±Ã˜Â³Ã™Å Ã˜Â©</span>
                            @php $schoolTermsMeta = $yesNoMeta($record->accepted_terms); @endphp
                            <span class="review-pill {{ $schoolTermsMeta['class'] }}">{{ $schoolTermsMeta['label'] }}</span>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">Ã™â€šÃ˜Â¨Ã™Ë†Ã™â€ž Ã˜Â´Ã˜Â±Ã™Ë†Ã˜Â· Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž</span>
                            @php $transportTermsMeta = $yesNoMeta($record->accepted_transport_terms); @endphp
                            <span class="review-pill {{ $transportTermsMeta['class'] }}">{{ $transportTermsMeta['label'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>Ã˜Â§Ã™â€žÃ˜Â±Ã˜Â³Ã™Ë†Ã™â€¦ Ã™Ë†Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹</h3>
                            <p>Ã˜ÂªÃ™ÂÃ˜ÂµÃ™Å Ã™â€ž Ã˜Â§Ã™â€žÃ˜Â±Ã˜Â³Ã™Ë†Ã™â€¦ Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¹Ã˜ÂªÃ™â€¦Ã˜Â¯Ã˜Â© Ã™ÂÃ™Å  Ã˜Â§Ã™â€žÃ˜Â¥Ã˜Â¹Ã˜Â¯Ã˜Â§Ã˜Â¯Ã˜Â§Ã˜Âª Ã™â€¦Ã˜Â¹ Ã˜Â­Ã˜Â§Ã™â€žÃ˜Â© Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹ Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â§Ã™â€žÃ™Å Ã˜Â© Ã™Ë†Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜ÂªÃ˜Â­Ã™Ë†Ã™Å Ã™â€ž.</p>
                        </div>
                    </div>
                    <div class="money-grid">
                        <div class="money-card">
                            <span class="money-card__label">Ã˜Â±Ã˜Â³Ã™Ë†Ã™â€¦ Ã˜Â§Ã™â€žÃ˜ÂªÃ˜Â³Ã˜Â¬Ã™Å Ã™â€ž</span>
                            <span class="money-card__value">{{ $formatMoney($record->registration_fee) }}</span>
                        </div>
                        <div class="money-card">
                            <span class="money-card__label">Ã˜Â±Ã˜Â³Ã™Ë†Ã™â€¦ Ã˜Â§Ã™â€žÃ˜Â®Ã˜Â¯Ã™â€¦Ã˜Â§Ã˜Âª</span>
                            <span class="money-card__value">{{ $formatMoney($record->services_fee) }}</span>
                        </div>
                        <div class="money-card">
                            <span class="money-card__label">Ã˜Â±Ã˜Â³Ã™Ë†Ã™â€¦ Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž</span>
                            <span class="money-card__value">{{ $formatMoney($record->transport_fee) }}</span>
                        </div>
                        <div class="money-card is-total">
                            <span class="money-card__label">Ã˜Â§Ã™â€žÃ˜Â¥Ã˜Â¬Ã™â€¦Ã˜Â§Ã™â€žÃ™Å </span>
                            <span class="money-card__value">{{ $formatMoney($record->total_amount) }}</span>
                        </div>
                    </div>

                    <div class="status-list" style="margin-bottom: .8rem;">
                        <div class="status-item">
                            <span class="status-item__label">Ã˜Â·Ã˜Â±Ã™Å Ã™â€šÃ˜Â© Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹</span>
                            <div class="info-card__value">{{ $paymentMethodLabel }}</div>
                        </div>
                        <div class="status-item">
                            <span class="status-item__label">Ã˜ÂªÃ˜Â§Ã˜Â±Ã™Å Ã˜Â® Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹</span>
                            <div class="info-card__value">{{ $formatDate($record->payment_date) }}</div>
                        </div>
                    </div>

                    <div class="payment-proof">
                        <div class="payment-proof__meta">
                            <div>
                                <p class="payment-proof__title">Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹</p>
                                <p class="payment-proof__hint">Ã˜ÂªÃ™â€¦ Ã™ÂÃ˜ÂµÃ™â€ž Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â¯Ã™ÂÃ˜Â¹ Ã˜Â¹Ã™â€  Ã™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯Ã˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â·Ã˜Â§Ã™â€žÃ˜Â¨ Ã˜Â§Ã™â€žÃ˜Â¹Ã˜Â§Ã™â€¦Ã˜Â© Ã™â€žÃ˜ÂªÃ˜Â³Ã™â€¡Ã™Å Ã™â€ž Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â±Ã˜Â§Ã˜Â¬Ã˜Â¹Ã˜Â© Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â§Ã™â€žÃ™Å Ã˜Â©.</p>
                            </div>
                            <span class="review-pill {{ $paymentReceiptState['class'] }}">{{ $paymentReceiptState['label'] }}</span>
                        </div>

                        @if($paymentReceiptDoc)
                            <div class="doc-meta">
                                <span class="doc-badge">{{ strtoupper((string) ($paymentReceiptDoc['ext'] ?: 'FILE')) }}</span>
                                <span class="doc-badge {{ !empty($paymentReceiptDoc['exists']) ? 'is-success' : 'is-danger' }}">{{ !empty($paymentReceiptDoc['exists']) ? 'Ã˜Â¬Ã˜Â§Ã™â€¡Ã˜Â² Ã™â€žÃ™â€žÃ™â€¦Ã˜Â¹Ã˜Â§Ã™Å Ã™â€ Ã˜Â©' : 'Ã˜Â§Ã™â€žÃ™â€¦Ã™â€žÃ™Â Ã˜ÂºÃ™Å Ã˜Â± Ã™â€¦Ã˜ÂªÃ˜Â§Ã˜Â­' }}</span>
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
                                    Ã™â€¦Ã˜Â¹Ã˜Â§Ã™Å Ã™â€ Ã˜Â© Ã˜Â§Ã™â€žÃ˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª
                                </button>
                                <a href="{{ $paymentReceiptDoc['download_url'] }}" class="btn btn-light">Ã˜ÂªÃ™â€ Ã˜Â²Ã™Å Ã™â€ž Ã˜Â§Ã™â€žÃ˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª</a>
                            </div>
                        @else
                            <div class="empty-panel">Ã™â€žÃ™â€¦ Ã™Å Ã˜ÂªÃ™â€¦ Ã˜Â±Ã™ÂÃ˜Â¹ Ã˜Â¥Ã˜Â«Ã˜Â¨Ã˜Â§Ã˜Âª Ã˜Â¯Ã™ÂÃ˜Â¹ Ã™â€žÃ™â€¡Ã˜Â°Ã˜Â§ Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨ Ã˜Â¨Ã˜Â¹Ã˜Â¯.</div>
                        @endif
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-card__head">
                        <div>
                            <h3>Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž Ã™Ë†Ã˜Â§Ã™â€žÃ˜Â´Ã˜Â±Ã™Ë†Ã˜Â·</h3>
                            <p>Ã™â€¦Ã˜Â±Ã˜Â¬Ã˜Â¹ Ã˜Â³Ã˜Â±Ã™Å Ã˜Â¹ Ã™â€žÃ˜ÂªÃ™ÂÃ˜Â§Ã˜ÂµÃ™Å Ã™â€ž Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž Ã™Ë†Ã™â€¦Ã˜Â¯Ã™â€° Ã˜Â§Ã™Æ’Ã˜ÂªÃ™â€¦Ã˜Â§Ã™â€ž Ã˜Â§Ã™â€žÃ™â€¦Ã™Ë†Ã˜Â§Ã™ÂÃ™â€šÃ˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â·Ã™â€žÃ™Ë†Ã˜Â¨Ã˜Â© Ã™â€¦Ã™â€  Ã™Ë†Ã™â€žÃ™Å  Ã˜Â§Ã™â€žÃ˜Â£Ã™â€¦Ã˜Â±.</p>
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
                            <h3>Ã˜Â§Ã˜Â¹Ã˜ÂªÃ™â€¦Ã˜Â§Ã˜Â¯ Ã˜Â§Ã™â€žÃ˜Â·Ã˜Â§Ã™â€žÃ˜Â¨</h3>
                            <p>Ã™Å Ã˜ÂªÃ™â€¦ Ã˜Â¥Ã™â€ Ã˜Â´Ã˜Â§Ã˜Â¡ Ã˜Â³Ã˜Â¬Ã™â€žÃ˜Â§Ã˜Âª Ã˜Â§Ã™â€žÃ˜Â·Ã˜Â§Ã™â€žÃ˜Â¨ Ã˜Â§Ã™â€žÃ˜Â£Ã™Æ’Ã˜Â§Ã˜Â¯Ã™Å Ã™â€¦Ã™Å Ã˜Â© Ã™Ë†Ã˜Â§Ã™â€žÃ™ÂÃ™Ë†Ã˜Â§Ã˜ÂªÃ™Å Ã˜Â± Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â±Ã˜ÂªÃ˜Â¨Ã˜Â·Ã˜Â© Ã™â€¦Ã˜Â¨Ã˜Â§Ã˜Â´Ã˜Â±Ã˜Â© Ã˜Â¨Ã˜Â¹Ã˜Â¯ Ã˜Â§Ã™â€žÃ˜Â§Ã˜Â¹Ã˜ÂªÃ™â€¦Ã˜Â§Ã˜Â¯Ã˜Å’ Ã™â€¦Ã˜Â¹ Ã˜Â§Ã™â€žÃ˜Â­Ã™ÂÃ˜Â§Ã˜Â¸ Ã˜Â¹Ã™â€žÃ™â€° Ã™â€ Ã™ÂÃ˜Â³ Ã˜Â§Ã™â€žÃ˜ÂªÃ˜Â¯Ã™ÂÃ™â€š Ã˜Â§Ã™â€žÃ˜Â®Ã™â€žÃ™ÂÃ™Å  Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â§Ã™â€žÃ™Å .</p>
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
                                <label for="approve_class_id">Ã˜Â§Ã™â€žÃ˜ÂµÃ™Â Ã˜Â§Ã™â€žÃ™â€ Ã™â€¡Ã˜Â§Ã˜Â¦Ã™Å </label>
                                <select name="class_id" id="approve_class_id" class="form-control" required>
                                    <option value="">Ã˜Â§Ã˜Â®Ã˜ÂªÃ˜Â± Ã˜Â§Ã™â€žÃ˜ÂµÃ™Â</option>
                                    @foreach ($classes as $item)
                                        <option value="{{ $item->id }}" {{ (string) $record->class1 === (string) $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="approve_room_id">Ã˜Â§Ã™â€žÃ˜Â´Ã˜Â¹Ã˜Â¨Ã˜Â©</label>
                                <select name="room_id" id="approve_room_id" class="form-control" required></select>
                            </div>
                            <div class="col-12">
                                <div class="finance-adjust-grid">
                                    <div class="finance-adjust-card">
                                        <div class="finance-adjust-meta">
                                            <label for="school_paid_amount" class="mb-0">Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¨Ã™â€žÃ˜Âº Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â­Ã˜ÂªÃ˜Â³Ã˜Â¨ Ã˜Â¹Ã™â€žÃ™â€° Ã˜Â§Ã™â€žÃ˜Â±Ã˜Â³Ã™Ë†Ã™â€¦ Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¯Ã˜Â±Ã˜Â³Ã™Å Ã˜Â© Ã™Ë†Ã˜Â§Ã™â€žÃ˜Â®Ã˜Â¯Ã™â€¦Ã˜Â§Ã˜Âª</label>
                                            <span class="finance-adjust-limit">Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â¯ Ã˜Â§Ã™â€žÃ˜Â£Ã™â€šÃ˜ÂµÃ™â€°: {{ $formatMoney($schoolFeesTotal) }}</span>
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
                                        <p class="finance-adjust-hint">Ã™â€¡Ã˜Â°Ã˜Â§ Ã™â€¡Ã™Ë† Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¨Ã™â€žÃ˜Âº Ã˜Â§Ã™â€žÃ˜Â°Ã™Å  Ã˜Â³Ã™Å Ã˜ÂªÃ™â€¦ Ã˜Â¥Ã™â€ Ã˜Â´Ã˜Â§Ã˜Â¤Ã™â€¡ Ã™Æ’Ã™ÂÃ˜Â§Ã˜ÂªÃ™Ë†Ã˜Â±Ã˜Â© Ã™â€¦Ã˜Â¯Ã˜Â±Ã˜Â³Ã™Å Ã˜Â© Ã™ÂÃ˜Â¹Ã™â€žÃ™Å Ã˜Â© Ã˜Â¯Ã˜Â§Ã˜Â®Ã™â€ž Ã˜Â§Ã™â€žÃ™â€ Ã˜Â¸Ã˜Â§Ã™â€¦ Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â§Ã™â€žÃ™Å  Ã˜Â¨Ã˜Â¹Ã˜Â¯ Ã˜Â§Ã™â€žÃ˜Â§Ã˜Â¹Ã˜ÂªÃ™â€¦Ã˜Â§Ã˜Â¯.</p>
                                    </div>

                                    @if($hasTransportSelection)
                                        <div class="finance-adjust-card">
                                            <div class="finance-adjust-meta">
                                                <label for="transport_paid_amount" class="mb-0">Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¨Ã™â€žÃ˜Âº Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â­Ã˜ÂªÃ˜Â³Ã˜Â¨ Ã˜Â¹Ã™â€žÃ™â€° Ã˜Â±Ã˜Â³Ã™Ë†Ã™â€¦ Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž</label>
                                                <span class="finance-adjust-limit">Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â¯ Ã˜Â§Ã™â€žÃ˜Â£Ã™â€šÃ˜ÂµÃ™â€°: {{ $formatMoney($transportFeesTotal) }}</span>
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
                                            <p class="finance-adjust-hint">Ã™Å Ã™â€¦Ã™Æ’Ã™â€  Ã˜ÂªÃ˜Â¹Ã˜Â¯Ã™Å Ã™â€ž Ã™â€¡Ã˜Â°Ã˜Â§ Ã˜Â§Ã™â€žÃ˜Â­Ã™â€šÃ™â€ž Ã˜Â¹Ã™â€ Ã˜Â¯ Ã™Ë†Ã˜ÂµÃ™Ë†Ã™â€ž Ã˜Â¯Ã™ÂÃ˜Â¹Ã˜Â© Ã˜Â¬Ã˜Â²Ã˜Â¦Ã™Å Ã˜Â© Ã™â€žÃ™â€žÃ™â€ Ã™â€šÃ™â€žÃ˜Å’ Ã™Ë†Ã˜Â³Ã™Å Ã˜ÂªÃ™â€¦ Ã˜Â§Ã˜Â³Ã˜ÂªÃ˜Â®Ã˜Â¯Ã˜Â§Ã™â€¦Ã™â€¡ Ã™â€¦Ã˜Â¨Ã˜Â§Ã˜Â´Ã˜Â±Ã˜Â© Ã™ÂÃ™Å  Ã™ÂÃ˜Â§Ã˜ÂªÃ™Ë†Ã˜Â±Ã˜Â© Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž Ã˜Â§Ã™â€žÃ™â€¦Ã™â€ Ã˜Â´Ã˜Â£Ã˜Â©.</p>
                                        </div>
                                    @else
                                        <div class="finance-adjust-card is-disabled">
                                            <div class="finance-adjust-meta">
                                                <label class="mb-0">Ã˜Â±Ã˜Â³Ã™Ë†Ã™â€¦ Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž</label>
                                                <span class="finance-adjust-limit">Ã˜ÂºÃ™Å Ã˜Â± Ã™â€¦Ã˜Â·Ã™â€žÃ™Ë†Ã˜Â¨Ã˜Â©</span>
                                            </div>
                                            <input type="hidden" name="transport_paid_amount" value="0">
                                            <input type="text" class="form-control" value="Ã™â€žÃ˜Â§ Ã˜ÂªÃ™Ë†Ã˜Â¬Ã˜Â¯ Ã˜Â®Ã˜Â¯Ã™â€¦Ã˜Â© Ã™â€ Ã™â€šÃ™â€ž Ã™â€žÃ™â€¡Ã˜Â°Ã˜Â§ Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨" disabled>
                                            <p class="finance-adjust-hint">Ã˜Â³Ã™Å Ã˜ÂªÃ™â€¦ Ã˜ÂªÃ˜Â¬Ã˜Â§Ã™â€¡Ã™â€ž Ã˜Â£Ã™Å  Ã™â€¦Ã˜Â¨Ã˜Â§Ã™â€žÃ˜Âº Ã™â€ Ã™â€šÃ™â€ž Ã™â€žÃ™â€¡Ã˜Â°Ã˜Â§ Ã˜Â§Ã™â€žÃ˜Â·Ã™â€žÃ˜Â¨ Ã™â€žÃ˜Â£Ã™â€  Ã™Ë†Ã™â€žÃ™Å  Ã˜Â§Ã™â€žÃ˜Â£Ã™â€¦Ã˜Â± Ã™â€žÃ™â€¦ Ã™Å Ã˜Â·Ã™â€žÃ˜Â¨ Ã˜Â®Ã˜Â¯Ã™â€¦Ã˜Â© Ã˜Â§Ã™â€žÃ™â€ Ã™â€šÃ™â€ž.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button class="btn btn-success btn-block approve-submit" type="submit">Ã˜Â§Ã˜Â¹Ã˜ÂªÃ™â€¦Ã˜Â§Ã˜Â¯ Ã˜Â§Ã™â€žÃ˜Â·Ã˜Â§Ã™â€žÃ˜Â¨ Ã™Ë†Ã˜Â¥Ã™â€ Ã˜Â´Ã˜Â§Ã˜Â¡ Ã˜Â§Ã™â€žÃ˜Â³Ã˜Â¬Ã™â€žÃ˜Â§Ã˜Âª</button>
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
                    <span id="mediaViewerTitle">Ã™â€¦Ã˜Â¹Ã˜Â§Ã™Å Ã™â€ Ã˜Â© Ã™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯</span>
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
                        <button type="button" class="media-tool" data-media-action="fit">Ã˜Â§Ã˜Â­Ã˜ÂªÃ™Ë†Ã˜Â§Ã˜Â¡</button>
                        <button type="button" class="media-tool" data-media-action="zoom-in">+</button>
                    </div>
                    <div class="media-viewer-toolbar__actions">
                        <span class="doc-badge" id="mediaViewerZoomLabel">100%</span>
                        <a href="#" id="mediaViewerDownload" class="btn btn-primary btn-sm">Ã˜ÂªÃ™â€ Ã˜Â²Ã™Å Ã™â€ž</a>
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
        const cleanUrl = String(viewerState.objectUrl || viewerState.baseUrl || '').split('#')[0];
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
        $('#mediaViewerZoomLabel').text(viewerState.fit ? 'Ã˜Â§Ã˜Â­Ã˜ÂªÃ™Ë†Ã˜Â§Ã˜Â¡' : (Math.round(viewerState.scale * 100) + '%'));
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

        $('#mediaViewerTitle').text(label || 'Ã™â€¦Ã˜Â¹Ã˜Â§Ã™Å Ã™â€ Ã˜Â© Ã™â€¦Ã˜Â³Ã˜ÂªÃ™â€ Ã˜Â¯');
        $('#mediaViewerType').text((viewerState.ext || 'file').toUpperCase());
        $('#mediaViewerDownload').attr('href', viewerState.downloadUrl);
        $('#mediaViewerCanvas').empty();

        if (String(existsFlag) !== '1') {
            renderViewerState('Ã˜Â§Ã™â€žÃ™â€¦Ã™â€žÃ™Â Ã˜ÂºÃ™Å Ã˜Â± Ã™â€¦Ã˜ÂªÃ˜Â§Ã˜Â­ Ã™ÂÃ™Å  Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â³Ã˜Â§Ã˜Â± Ã˜Â§Ã™â€žÃ˜Â­Ã˜Â§Ã™â€žÃ™Å . Ã™Å Ã™â€¦Ã™Æ’Ã™â€ Ã™Æ’ Ã˜ÂªÃ™â€ Ã˜Â²Ã™Å Ã™â€žÃ™â€¡ Ã™â€žÃ˜Â§Ã˜Â­Ã™â€šÃ˜Â§Ã™â€¹ Ã˜Â¥Ã˜Â°Ã˜Â§ Ã˜ÂªÃ™â€¦Ã˜Âª Ã˜Â¥Ã˜Â¹Ã˜Â§Ã˜Â¯Ã˜Â© Ã™â€¦Ã˜Â²Ã˜Â§Ã™â€¦Ã™â€ Ã˜ÂªÃ™â€¡.', 'alert-warning');
            $('#mediaViewerModal').modal('show');
            return;
        }

        renderViewerState('Ã˜Â¬Ã˜Â§Ã˜Â±Ã™Â Ã˜ÂªÃ˜Â­Ã™â€¦Ã™Å Ã™â€ž Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¹Ã˜Â§Ã™Å Ã™â€ Ã˜Â©...', 'alert-light');
        $('#mediaViewerModal').modal('show');

        if (imageExts.indexOf(viewerState.ext) !== -1) {
            viewerState.type = 'image';
            const img = $('<img>', {
                src: viewerState.baseUrl,
                alt: label || 'preview',
                class: 'media-viewer-image',
                css: { display: 'none' }
            });
            $('#mediaViewerCanvas').append(img);
            img.on('load', function () {
                $('#mediaViewerCanvas').find('.media-viewer-state').remove();
                img.show();
                applyViewerScale();
            });
            img.on('error', function () {
                renderViewerState('Ã˜ÂªÃ˜Â¹Ã˜Â°Ã˜Â± Ã˜ÂªÃ˜Â­Ã™â€¦Ã™Å Ã™â€ž Ã˜Â§Ã™â€žÃ˜ÂµÃ™Ë†Ã˜Â±Ã˜Â© Ã˜Â¯Ã˜Â§Ã˜Â®Ã™â€ž Ã˜Â§Ã™â€žÃ™â€¦Ã˜Â¹Ã˜Â§Ã™Å Ã™â€ Ã˜Â©. Ã™Å Ã™â€¦Ã™Æ’Ã™â€ Ã™Æ’ Ã˜ÂªÃ™â€ Ã˜Â²Ã™Å Ã™â€ž Ã˜Â§Ã™â€žÃ™â€¦Ã™â€žÃ™Â Ã™â€¦Ã˜Â¨Ã˜Â§Ã˜Â´Ã˜Â±Ã˜Â©.', 'alert-warning');
            });
            return;
        }

        if (viewerState.ext === 'pdf') {
            fetch(viewerState.baseUrl, {
                credentials: 'same-origin',
                cache: 'no-store'
            })
                .then(function (previewResponse) {
                    if (!previewResponse.ok) {
                        throw new Error('preview_response_' + previewResponse.status);
                    }

                    return previewResponse.blob();
                })
                .then(function (previewBlob) {
                    const previewType = String(previewBlob.type || '').toLowerCase();
                    if (previewType && previewType.indexOf('pdf') === -1) {
                        throw new Error('preview_not_pdf');
                    }

                    cleanupViewerObjectUrl();
                    viewerState.objectUrl = URL.createObjectURL(previewBlob);
                    viewerState.type = 'pdf';

                    const iframe = $('<iframe>', {
                        class: 'media-viewer-frame',
                        src: buildPdfUrl(),
                        css: { display: 'none' }
                    });

                    $('#mediaViewerCanvas').append(iframe);
                    iframe.on('load', function () {
                        $('#mediaViewerCanvas').find('.media-viewer-state').remove();
                        iframe.show();
                        updateViewerToolbar();
                    });
                    iframe.on('error', function () {
                        cleanupViewerObjectUrl();
                        renderViewerState('\u062A\u0639\u0630\u0631 \u0639\u0631\u0636 \u0645\u0644\u0641 PDF \u062F\u0627\u062E\u0644 \u0627\u0644\u0645\u0639\u0627\u064A\u0646\u0629. \u064A\u0645\u0643\u0646\u0643 \u0627\u0633\u062A\u062E\u062F\u0627\u0645 \u0632\u0631 \u0627\u0644\u062A\u0646\u0632\u064A\u0644 \u0625\u0630\u0627 \u0644\u0632\u0645 \u0627\u0644\u0623\u0645\u0631.', 'alert-warning');
                    });
                })
                .catch(function () {
                    cleanupViewerObjectUrl();
                    renderViewerState('\u062A\u0639\u0630\u0631 \u062A\u062D\u0645\u064A\u0644 \u0645\u0644\u0641 PDF \u062F\u0627\u062E\u0644 \u0627\u0644\u0645\u0639\u0627\u064A\u0646\u0629. \u064A\u0645\u0643\u0646\u0643 \u0627\u0633\u062A\u062E\u062F\u0627\u0645 \u0632\u0631 \u0627\u0644\u062A\u0646\u0632\u064A\u0644 \u0625\u0630\u0627 \u0644\u0632\u0645 \u0627\u0644\u0623\u0645\u0631.', 'alert-warning');
                });
            return;
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
