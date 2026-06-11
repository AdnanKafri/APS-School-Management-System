@extends('website.layouts.app')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .wizard-wrap {
        max-width: 1060px;
        margin: 24px auto;
        padding: 0 16px;
        font-family: inherit;
    }

    .wizard-wrap.is-rtl {
        font-family: 'Cairo', sans-serif;
        direction: rtl;
    }

    .wizard-wrap.is-ltr {
        font-family: inherit;
        direction: ltr;
    }

    .wizard-card {
        background: #fff;
        border: 1px solid #e9e8ef;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 16px 40px rgba(31, 24, 46, 0.05);
    }

    .wizard-card + .wizard-card {
        margin-top: 14px;
    }

    .wizard-title {
        margin: 0 0 8px;
        font-size: 28px;
        line-height: 1.35;
        font-weight: 800;
        color: #2f2b3a;
        letter-spacing: -0.02em;
        text-align: start;
    }

    .wizard-section-title {
        margin: 0 0 14px;
        font-size: 22px;
        line-height: 1.4;
        font-weight: 700;
        color: #2f2b3a;
        text-align: start;
    }

    .wizard-subtitle {
        margin: 0;
        color: #7f7891;
        font-size: 15px;
        line-height: 1.8;
        text-align: start;
    }

    .wizard-steps {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 14px;
        justify-content: flex-start;
    }

    .wizard-step-chip {
        padding: 8px 12px;
        border-radius: 999px;
        border: 1px solid #e9e8ef;
        color: #8a869a;
        font-size: 13px;
        font-weight: 700;
        background: #fff;
    }

    .wizard-step-chip.is-active {
        background: #5b4b8a;
        border-color: #5b4b8a;
        color: #fff;
    }

    .wizard-step-chip.is-done {
        background: #eefaf4;
        border-color: #cceedd;
        color: #1f9d6b;
    }

    .wizard-pane {
        display: none;
    }

    .wizard-pane.is-active {
        display: block;
    }

    .wizard-grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 14px;
    }

    .col-6 {
        grid-column: span 6;
    }

    .col-12 {
        grid-column: span 12;
    }

    .wizard-field label {
        display: block;
        margin-bottom: 7px;
        font-size: 14px;
        font-weight: 700;
        color: #4d4762;
        text-align: start;
    }

    .wizard-label-required::after {
        content: " *";
        color: #c53939;
        font-weight: 800;
    }

    .wizard-field.is-invalid label {
        color: #b42318;
    }

    .wizard-field input,
    .wizard-field select,
    .wizard-field textarea {
        width: 100%;
        min-height: 48px;
        border: 1px solid #d7d2e5;
        border-radius: 12px;
        padding: 14px 16px;
        font-family: inherit;
        background: #fff;
        color: #2f2b3a;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        text-align: start;
        direction: inherit;
        box-sizing: border-box;
        display: block;
    }

    .wizard-field textarea {
        min-height: 120px;
        line-height: 1.9;
        font-size: 14px;
        resize: vertical;
    }

    .wizard-wrap.is-rtl .wizard-field input,
    .wizard-wrap.is-rtl .wizard-field select,
    .wizard-wrap.is-rtl .wizard-field textarea {
        font-family: 'Cairo', sans-serif;
        direction: rtl;
        text-align: right;
    }

    .wizard-wrap.is-ltr .wizard-field input,
    .wizard-wrap.is-ltr .wizard-field select,
    .wizard-wrap.is-ltr .wizard-field textarea {
        font-family: inherit;
        direction: ltr;
        text-align: left;
    }

    .wizard-field input:focus,
    .wizard-field select:focus,
    .wizard-field textarea:focus {
        outline: none;
        border-color: #5b4b8a;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.12);
    }

    .wizard-field input::placeholder,
    .wizard-field textarea::placeholder {
        color: #a09ab1;
    }

    .wizard-field textarea {
        min-height: 120px;
        padding: 14px 16px;
        line-height: 1.9;
        font-size: 14px;
        resize: vertical;
        display: block;
        vertical-align: top;
    }

    .wizard-field.is-invalid input,
    .wizard-field.is-invalid select,
    .wizard-field.is-invalid textarea {
        border-color: #d64545;
        box-shadow: 0 0 0 3px rgba(214, 69, 69, 0.12);
        background: #fffafa;
    }

    .wizard-terms-panel {
        border: 1px solid #e7e1f3;
        border-radius: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfafe 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        overflow: hidden;
    }

    .wizard-terms-panel + .wizard-check {
        margin-top: 14px;
    }

    .wizard-terms-panel__head {
        padding: 16px 18px 12px;
        border-bottom: 1px solid #ece8f5;
    }

    .wizard-terms-panel__title {
        margin: 0 0 6px;
        font-size: 17px;
        font-weight: 800;
        color: #2f2b3a;
        text-align: start;
    }

    .wizard-terms-panel__intro {
        margin: 0;
        color: #7a7489;
        font-size: 13px;
        line-height: 1.85;
        text-align: start;
    }

    .wizard-terms-panel__body {
        max-height: 340px;
        overflow: auto;
        padding: 16px 18px 18px;
        color: #2f2b3a;
        line-height: 1.95;
        text-align: start;
    }

    .wizard-terms-panel__body :is(p, ul, ol, blockquote, h1, h2, h3, h4, h5, h6) {
        margin: 0 0 0.9rem;
    }

    .wizard-terms-panel__body :is(p, li, blockquote) {
        font-size: 14px;
    }

    .wizard-terms-panel__body :is(ul, ol) {
        padding-inline-start: 1.35rem;
        padding-inline-end: 0;
    }

    .wizard-terms-panel__body li + li {
        margin-top: 0.45rem;
    }

    .wizard-terms-panel__body ol {
        list-style: decimal;
    }

    .wizard-terms-panel__body ul {
        list-style: disc;
    }

    .wizard-terms-panel__body li {
        padding-inline-start: 0.15rem;
    }

    .wizard-terms-panel__body p:last-child,
    .wizard-terms-panel__body ul:last-child,
    .wizard-terms-panel__body ol:last-child {
        margin-bottom: 0;
    }

    .wizard-terms-panel__body .agreement-empty {
        margin: 0;
        color: #8d869c;
        font-style: italic;
    }

    .wizard-terms-panel__body .agreement-paragraph {
        white-space: pre-line;
    }

    .wizard-agreement-consent {
        border: 1px solid #ece8f5;
        border-radius: 16px;
        background: #fff;
        padding: 14px 16px;
        margin-top: 14px;
        display: flex;
        align-items: center;
    }

    .wizard-agreement-consent .wizard-check {
        margin-top: 0;
        padding: 0;
        border: 0;
        background: transparent;
    }

    .wizard-toggle-card {
        border: 1px solid #ece8f5;
        border-radius: 16px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfafe 100%);
        padding: 12px 14px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        width: 100%;
    }

    .wizard-toggle-card .wizard-check {
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 0;
        padding: 0;
        border: 0;
        background: transparent;
        width: 100%;
    }

    .wizard-actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 18px;
    }

    .wizard-choice-wrap {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .wizard-choice {
        flex: 1;
        min-width: 240px;
        border: 1px solid #e9e8ef;
        border-radius: 16px;
        padding: 16px 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfbff 100%);
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .wizard-choice:hover {
        border-color: #c9c1e4;
        box-shadow: 0 12px 28px rgba(31, 24, 46, 0.06);
        transform: translateY(-1px);
    }

    .wizard-choice.is-active {
        border-color: #5b4b8a;
        background: #f7f3ff;
        box-shadow: 0 0 0 3px rgba(91, 75, 138, 0.1);
    }

    .wizard-choice input[type="radio"] {
        appearance: none;
        -webkit-appearance: none;
        width: 22px;
        height: 22px;
        margin: 2px 0 0;
        border: 2px solid #8e86aa;
        border-radius: 999px;
        background: #fff;
        flex-shrink: 0;
        display: grid;
        place-content: center;
        transition: border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .wizard-choice input[type="radio"]::before {
        content: "";
        width: 10px;
        height: 10px;
        border-radius: 999px;
        transform: scale(0);
        transition: transform 0.15s ease;
        background: #5b4b8a;
    }

    .wizard-choice input[type="radio"]:checked {
        border-color: #5b4b8a;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.12);
    }

    .wizard-choice input[type="radio"]:checked::before {
        transform: scale(1);
    }

    .wizard-choice input[type="radio"]:focus-visible {
        outline: none;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.18);
    }

    .wizard-choice__content {
        display: flex;
        flex-direction: column;
        gap: 2px;
        text-align: start;
    }

    .wizard-choice__title {
        font-size: 16px;
        font-weight: 700;
        color: #2f2b3a;
    }

    .wizard-choice__hint {
        font-size: 13px;
        color: #7f7891;
    }

    .wizard-summary {
        display: grid;
        gap: 18px;
    }

    .wizard-payment-section {
        border: 1px solid #ece8f5;
        border-radius: 16px;
        padding: 16px;
        background: #fcfcff;
    }

    .wizard-payment-section p {
        margin: 0 0 8px;
        color: #4d4762;
        line-height: 1.8;
        text-align: start;
    }

    .wizard-payment-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        margin-top: 10px;
    }

    .wizard-payment-meta .wizard-summary-row {
        margin: 0;
    }

    .wizard-submit-note {
        color: #7f7891;
        font-size: 13px;
        margin-top: 8px;
        text-align: start;
    }

    .wizard-summary-section {
        border: 1px solid #ece8f5;
        border-radius: 16px;
        padding: 16px;
        background: #fcfcff;
    }

    .wizard-summary-heading {
        margin: 0 0 12px;
        font-size: 18px;
        font-weight: 700;
        color: #2f2b3a;
        text-align: start;
    }

    .wizard-summary-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .wizard-summary-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        border: 1px solid #e9e8ef;
        border-radius: 12px;
        padding: 10px 12px;
        background: #fff;
    }

    .wizard-summary-row span:first-child {
        color: #6d6781;
        text-align: start;
    }

    .wizard-summary-row span:last-child {
        color: #2f2b3a;
        font-weight: 700;
        text-align: end;
    }

    .wizard-summary-row.total {
        font-weight: 800;
        background: #f8f7fc;
    }

    .wizard-summary-doc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 10px;
    }

    .wizard-summary-doc {
        border: 1px solid #ece8f5;
        border-radius: 16px;
        background: #fff;
        padding: 12px 14px;
        display: grid;
        gap: 8px;
        min-width: 0;
        overflow: hidden;
        align-content: start;
    }

    .wizard-summary-doc__head {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        font-size: 14px;
        font-weight: 800;
        color: #2f2b3a;
        min-width: 0;
    }

    .wizard-summary-doc__title {
        flex: 1 1 auto;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        line-height: 1.5;
    }

    .wizard-summary-doc__title[title] {
        cursor: help;
    }

    .wizard-summary-doc__meta {
        font-size: 12px;
        line-height: 1.5;
        color: #7f7891;
        min-width: 0;
        overflow: hidden;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    .wizard-doc-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 26px;
        padding: 0.15rem 0.6rem;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        background: #f4f2f8;
        color: #6f6787;
        white-space: nowrap;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wizard-doc-pill.is-success {
        background: #eefaf3;
        color: #1f8f5f;
    }

    .wizard-doc-pill.is-muted {
        background: #f4f2f8;
        color: #6f6787;
    }

    .wizard-error {
        display: none;
        color: #c53939;
        font-size: 13px;
        margin-top: 8px;
        text-align: start;
    }

    .wizard-error.show {
        display: block;
    }

    .wizard-alert {
        display: none;
        border: 1px solid #f4cccc;
        background: #fff4f4;
        color: #b42318;
        border-radius: 10px;
        padding: 10px 12px;
        margin-bottom: 10px;
        text-align: start;
    }

    .wizard-alert.show {
        display: block;
    }

    .wizard-success-toast {
        position: fixed;
        inset-inline: 0;
        top: 24px;
        z-index: 1080;
        display: flex;
        justify-content: center;
        pointer-events: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity .24s ease, transform .24s ease;
    }

    .wizard-success-toast.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .wizard-success-toast__inner {
        width: min(92vw, 560px);
        border: 1px solid #cfe9d8;
        background: #f3fbf6;
        border-radius: 14px;
        box-shadow: 0 10px 26px rgba(46, 133, 79, 0.16);
        padding: 14px 16px;
        pointer-events: auto;
    }

    .wizard-success-toast__title {
        margin: 0;
        color: #1f7a46;
        font-size: 16px;
        font-weight: 800;
        text-align: start;
    }

    .wizard-success-toast__hint {
        margin: 6px 0 0;
        color: #356b4a;
        font-size: 13px;
        text-align: start;
    }

    .wizard-payment-qr-wrap {
        margin-top: 12px;
        text-align: center;
    }

    .wizard-payment-qr {
        width: min(220px, 100%);
        max-height: 220px;
        object-fit: contain;
        border: 1px solid #e5e0f0;
        border-radius: 10px;
        padding: 6px;
        background: #fff;
    }

    .wizard-check {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ece8f5;
        border-radius: 16px;
        background: #fff;
        margin-top: 14px;
        cursor: pointer;
        user-select: none;
        color: #3b354a;
        font-weight: 600;
        box-sizing: border-box;
    }

    .wizard-check input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        width: 22px;
        height: 22px;
        margin: 0;
        border: 2px solid #5b4b8a;
        border-radius: 6px;
        background: #fff;
        flex-shrink: 0;
        display: grid;
        place-content: center;
        transition: border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .wizard-check input[type="checkbox"]:checked {
        background: #5b4b8a;
        border-color: #fff;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.12);
    }

    .wizard-check input[type="checkbox"]:focus-visible {
        outline: none;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.18);
    }

    .wizard-check__text {
        flex: 1;
        line-height: 1.8;
        text-align: start;
        min-width: 0;
    }

    .wizard-file-status {
        margin-top: 6px;
        min-height: 18px;
        color: #7f7891;
        font-size: 12px;
        line-height: 1.5;
    }

    .wizard-subsection {
        grid-column: span 12;
        margin-top: 2px;
        padding-top: 16px;
        border-top: 1px solid #ece8f5;
    }

    .wizard-subsection__title {
        margin: 0 0 6px;
        font-size: 16px;
        font-weight: 800;
        color: #2f2b3a;
        text-align: start;
    }

    .wizard-subsection__text {
        margin: 0 0 10px;
        color: #7f7891;
        font-size: 13px;
        line-height: 1.7;
        text-align: start;
    }

    .wizard-wrap.is-ltr .wizard-check,
    .wizard-wrap.is-ltr .wizard-choice,
    .wizard-wrap.is-ltr .wizard-summary-row,
    .wizard-wrap.is-ltr .wizard-steps {
        direction: ltr;
    }

    .wizard-wrap.is-rtl .wizard-check {
        flex-direction: row-reverse;
    }

    .wizard-wrap.is-rtl .wizard-check,
    .wizard-wrap.is-rtl .wizard-choice,
    .wizard-wrap.is-rtl .wizard-summary-row,
    .wizard-wrap.is-rtl .wizard-steps {
        direction: rtl;
    }

    .wizard-wrap.is-rtl .wizard-check input[type="checkbox"] {
        order: 2;
    }

    .wizard-wrap.is-rtl .wizard-check__text {
        order: 1;
        text-align: right;
    }

    .wizard-wrap.is-ltr .wizard-check__text {
        text-align: left;
    }

    @media (max-width: 768px) {
        .col-6 {
            grid-column: span 12;
        }

        .wizard-title {
            font-size: 24px;
        }

        .wizard-section-title {
            font-size: 20px;
        }

        .wizard-summary-grid {
            grid-template-columns: 1fr;
        }

        .wizard-payment-meta {
            grid-template-columns: 1fr;
        }

        .wizard-actions {
            flex-direction: column-reverse;
        }

        .wizard-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
@php
    $renderAgreementContent = function ($content, $fallback) {
        $content = trim((string) $content);
        if ($content === '') {
            return '<p class="agreement-empty">' . e($fallback) . '</p>';
        }

        if (preg_match('/<\s*[a-z][\s\S]*>/i', $content)) {
            return $content;
        }

        $normalized = str_replace(["\r\n", "\r"], "\n", $content);
        $normalized = preg_replace('/<br\s*\/?>/i', "\n", $normalized);
        $chunks = preg_split('/\n{2,}/u', $normalized) ?: [];
        $items = [];
        $hasManualNumbering = false;

        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') {
                continue;
            }

            $parts = preg_split('/\n+/u', $chunk) ?: [];
            foreach ($parts as $part) {
                $part = trim($part);
                if ($part !== '') {
                    if (preg_match('/^\s*(?:[0-9]+|[٠-٩]+)\s*[\.\)\-:،]?\s+/u', $part)) {
                        $hasManualNumbering = true;
                    }
                    $items[] = $part;
                }
            }
        }

        if (!$hasManualNumbering && count($items) > 1) {
            $html = '<ol class="agreement-list">';
            foreach ($items as $item) {
                $html .= '<li>' . e($item) . '</li>';
            }
            $html .= '</ol>';
            return $html;
        }

        return '<div class="agreement-paragraph agreement-paragraph--raw">' . e($normalized) . '</div>';
    };
    $locale = LaravelLocalization::getCurrentLocale();
    $isRtl = $locale === 'ar';
    $paymentInstructions = $isRtl
        ? (string) ($paymentSettings['payment_instructions_ar'] ?? '')
        : (string) ($paymentSettings['payment_instructions_en'] ?? '');
    $paymentReference = $isRtl
        ? (string) ($paymentSettings['payment_reference_ar'] ?? '')
        : (string) ($paymentSettings['payment_reference_en'] ?? '');
    $paymentAccount = $isRtl
        ? (string) ($paymentSettings['payment_account_ar'] ?? '')
        : (string) ($paymentSettings['payment_account_en'] ?? '');
    $paymentQrUrl = (string) ($paymentQrUrl ?? '');
    $countryLabelKey = $isRtl ? 'name_ar' : 'name_en';
    $countryOptions = collect($countries_currencies ?? [])->filter(function ($item) {
        $labelAr = mb_strtolower(trim((string) ($item->name_ar ?? '')));
        $labelEn = mb_strtolower(trim((string) ($item->name_en ?? '')));
        $key = mb_strtolower(trim((string) ($item->key_country ?? '')));
        $isSyria = str_contains($labelAr, 'سوريا') || str_contains($labelAr, 'سوري')
            || str_contains($labelEn, 'syria') || str_contains($labelEn, 'syrian')
            || in_array($key, ['sy', 'syr', 'syria'], true);
        return (!isset($item->active) || (int) $item->active === 1) || $isSyria;
    })->map(function ($item) use ($countryLabelKey) {
        return [
            'value' => trim((string) ($item->key_country ?? $item->id)),
            'label' => trim((string) ($item->{$countryLabelKey} ?? $item->name_en ?? $item->name_ar ?? '')),
        ];
    })->filter(function ($item) {
        return $item['value'] !== '' && $item['label'] !== '';
    })->unique('value')->values();

    $syrianItem = $countryOptions->first(function ($item) {
        $label = mb_strtolower((string) $item['label']);
        $value = mb_strtolower((string) $item['value']);
        return in_array($value, ['sy', 'syr', 'syria', 'syrian arab republic'], true)
            || str_contains($label, 'سوريا')
            || str_contains($label, 'سوري')
            || str_contains($label, 'syria')
            || str_contains($label, 'syrian');
    });
    if (!$syrianItem) {
        $syrianItem = [
            'value' => 'SY',
            'label' => $isRtl ? 'سوريا' : 'Syria',
        ];
    }
    $otherCountries = $countryOptions->reject(function ($item) use ($syrianItem) {
        return $syrianItem && (string) $item['value'] === (string) $syrianItem['value'];
    })->sortBy('label', SORT_NATURAL | SORT_FLAG_CASE)->values();
    $countryOptions = collect($syrianItem ? [$syrianItem] : [])->merge($otherCountries)->values();

    $nationalityOptions = $countryOptions->map(function ($item) {
        return [
            'value' => $item['value'],
            'label' => $item['label'],
        ];
    })->values();

    $combinedNationalities = $isRtl
        ? [
            ['value' => 'SY-PS', 'label' => 'سوري فلسطيني'],
            ['value' => 'SY-JO', 'label' => 'سوري أردني'],
            ['value' => 'SY-LB', 'label' => 'سوري لبناني'],
            ['value' => 'SY-IQ', 'label' => 'سوري عراقي'],
            ['value' => 'SY-EG', 'label' => 'سوري مصري'],
        ]
        : [
            ['value' => 'SY-PS', 'label' => 'سوري فلسطيني'],
            ['value' => 'SY-JO', 'label' => 'سوري أردني'],
            ['value' => 'SY-LB', 'label' => 'سوري لبناني'],
            ['value' => 'SY-IQ', 'label' => 'سوري عراقي'],
            ['value' => 'SY-EG', 'label' => 'سوري مصري'],
        ];
    $nationalityOptions = collect($syrianItem ? [['value' => $syrianItem['value'], 'label' => $syrianItem['label']]] : [])
        ->merge($combinedNationalities)
        ->merge($nationalityOptions)
        ->unique('value')
        ->values();
@endphp

<div class="wizard-wrap {{ $isRtl ? 'is-rtl' : 'is-ltr' }}">
    <div class="wizard-card">
        <h1 class="wizard-title">{{ __('wizard.title') }}</h1>
        <p class="wizard-subtitle">{{ __('wizard.subtitle') }}</p>
        <div class="wizard-steps">
            <span class="wizard-step-chip is-active" data-step="1">1) {{ __('wizard.steps.school_terms') }}</span>
            <span class="wizard-step-chip" data-step="2">2) {{ __('wizard.steps.student_info') }}</span>
            <span class="wizard-step-chip" data-step="3">3) {{ __('wizard.steps.transport') }}</span>
            <span class="wizard-step-chip" data-step="4">4) {{ __('wizard.steps.transport_terms') }}</span>
            <span class="wizard-step-chip" data-step="5">5) {{ __('wizard.steps.review_payment') }}</span>
        </div>
    </div>

    <div id="wizardAlert" class="wizard-alert"></div>
    <input type="hidden" id="wizardToken" value="{{ $wizardToken }}">

    <div class="wizard-card wizard-pane is-active" data-pane="1">
        <h3 class="wizard-section-title">{{ __('wizard.sections.school_terms') }}</h3>
        <div class="wizard-terms-panel">
            <div class="wizard-terms-panel__head">
                <p class="wizard-terms-panel__title">{{ __('wizard.sections.school_terms') }}</p>
                <p class="wizard-terms-panel__intro">{{ __('wizard.terms.agreement_intro') }}</p>
            </div>
            <div class="wizard-terms-panel__body">
                {!! $renderAgreementContent(optional($schoolTerms)->content ?? '', __('wizard.terms.empty_school')) !!}
            </div>
        </div>
        <div class="wizard-agreement-consent">
            <label class="wizard-check" for="agreeTerms">
                <input type="checkbox" id="agreeTerms">
                <span class="wizard-check__text">{{ __('wizard.terms.school_agree') }}</span>
            </label>
        </div>
        <div class="wizard-error" id="agreeTermsError">{{ __('wizard.errors.terms_required') }}</div>
        <div class="wizard-actions">
            <button type="button" class="btn btn-light" disabled>{{ __('wizard.buttons.previous') }}</button>
            <button type="button" class="btn btn-primary" id="btnStep1Next">{{ __('wizard.buttons.next') }}</button>
        </div>
    </div>

    <div class="wizard-card wizard-pane" data-pane="2">
        <h3 class="wizard-section-title">{{ __('wizard.sections.student_info') }}</h3>
        <div class="wizard-grid" id="wizardStep2Form">
            <div class="wizard-field col-6"><label class="wizard-label-required" for="first_name">{{ __('wizard.fields.first_name') }}</label><input id="first_name" type="text"></div>
            <div class="wizard-field col-6"><label class="wizard-label-required" for="last_name">{{ __('wizard.fields.last_name') }}</label><input id="last_name" type="text"></div>
            <div class="wizard-field col-6"><label for="first_name_en">{{ __('wizard.fields.first_name_en') }}</label><input id="first_name_en" type="text"></div>
            <div class="wizard-field col-6"><label for="last_name_en">{{ __('wizard.fields.last_name_en') }}</label><input id="last_name_en" type="text"></div>
            <div class="wizard-field col-6"><label class="wizard-label-required" for="father_name">{{ __('wizard.fields.father_name') }}</label><input id="father_name" type="text"></div>
            <div class="wizard-field col-6"><label class="wizard-label-required" for="mather_name">{{ __('wizard.fields.mother_name') }}</label><input id="mather_name" type="text"></div>
            <div class="wizard-field col-6"><label for="last_mother_name">{{ __('wizard.fields.mother_last_name') }}</label><input id="last_mother_name" type="text"></div>
            <div class="wizard-field col-6"><label class="wizard-label-required" for="date">{{ __('wizard.fields.date') }}</label><input id="date" type="date"></div>
            <div class="wizard-field col-6">
                <label class="wizard-label-required" for="class1">{{ __('wizard.fields.class') }}</label>
                <select id="class1">
                    <option value="">{{ __('wizard.placeholders.choose_class') }}</option>
                    @foreach($classes as $class)
                        @php
                            $classLabel = $isRtl ? ($class->name ?? $class->name_en) : ($class->name_en ?? $class->name);
                        @endphp
                        @php
                            $stageId = (int) ($class->stage_id ?? 0);
                            if ($stageId === 0) {
                                $stageKey = 'kindergarten';
                            } elseif ($stageId === 1 || $stageId === 2) {
                                $stageKey = 'primary';
                            } elseif ($stageId === 3) {
                                $stageKey = 'middle';
                            } else {
                                $stageKey = 'high';
                            }
                        @endphp
                        <option value="{{ $class->id }}" data-class-label="{{ $classLabel }}" data-stage-key="{{ $stageKey }}">{{ $classLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="wizard-field col-6">
                <label for="gender">{{ __('wizard.fields.gender') }}</label>
                <select id="gender">
                    <option value="">{{ __('wizard.placeholders.choose_gender') }}</option>
                    <option value="1">{{ __('wizard.options.male') }}</option>
                    <option value="0">{{ __('wizard.options.female') }}</option>
                </select>
            </div>
            <div class="wizard-field col-6">
                <label for="religion">{{ __('wizard.fields.religion') }}</label>
                <select id="religion">
                    <option value="">{{ __('wizard.placeholders.choose_religion') }}</option>
                    <option value="0">{{ __('wizard.options.muslim') }}</option>
                    <option value="1">{{ __('wizard.options.christian') }}</option>
                </select>
            </div>
            <div class="wizard-field col-6">
                <label for="nationality">{{ __('wizard.fields.nationality') }}</label>
                <select id="nationality">
                    <option value="">{{ __('wizard.placeholders.choose_nationality') }}</option>
                    @foreach($nationalityOptions as $item)
                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="wizard-field col-6"><label for="the_ID_number">{{ __('wizard.fields.id_number') }}</label><input id="the_ID_number" type="text"></div>
            <div class="wizard-field col-6"><label for="passport_number">{{ __('wizard.fields.passport_number') }}</label><input id="passport_number" type="text"></div>
            <div class="wizard-field col-6"><label for="place_of_birth">{{ __('wizard.fields.place_of_birth') }}</label><input id="place_of_birth" type="text"></div>
            <div class="wizard-field col-6">
                <label class="wizard-label-required" for="country">{{ __('wizard.fields.country') }}</label>
                <select id="country">
                    <option value="">{{ __('wizard.placeholders.choose_country') }}</option>
                    @foreach($countryOptions as $item)
                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="wizard-field col-6"><label for="city">{{ __('wizard.fields.city') }}</label><input id="city" type="text"></div>
            <div class="wizard-field col-6"><label class="wizard-label-required" for="phone">{{ __('wizard.fields.phone') }}</label><input id="phone" type="text"></div>
            <div class="wizard-field col-6"><label for="other_phone">{{ __('wizard.fields.other_phone') }}</label><input id="other_phone" type="text"></div>
            <div class="wizard-field col-6"><label for="email">{{ __('wizard.fields.email') }}</label><input id="email" type="email"></div>
            <div class="wizard-field col-6"><label for="the_previous_school">{{ __('wizard.fields.previous_school') }}</label><input id="the_previous_school" type="text"></div>
            <div class="wizard-field col-12"><label for="con_sch">{{ __('wizard.fields.notes') }}</label><textarea id="con_sch"></textarea></div>
            <div class="wizard-subsection col-12">
                <h4 class="wizard-subsection__title">{{ __('wizard.sections.guardian_contacts') }}</h4>
                <p class="wizard-subsection__text">{{ __('wizard.section_notes.family') }}</p>
            </div>
            <div class="wizard-field col-6"><label for="father_phone">{{ __('wizard.fields.father_phone') }}</label><input id="father_phone" type="text" inputmode="tel"></div>
            <div class="wizard-field col-6"><label for="mather_phone">{{ __('wizard.fields.mother_phone') }}</label><input id="mather_phone" type="text" inputmode="tel"></div>
            <div class="wizard-field col-6"><label for="father_job">{{ __('wizard.fields.father_job') }}</label><input id="father_job" type="text"></div>
            <div class="wizard-field col-6"><label for="mather_job">{{ __('wizard.fields.mother_job') }}</label><input id="mather_job" type="text"></div>
            <div class="wizard-field col-6"><label for="guardian_name">{{ __('wizard.fields.guardian_name') }}</label><input id="guardian_name" type="text"></div>
            <div class="wizard-field col-6"><label for="guardian_relation">{{ __('wizard.fields.guardian_relation') }}</label><input id="guardian_relation" type="text"></div>
            <div class="wizard-field col-6"><label for="guardian_phone">{{ __('wizard.fields.guardian_phone') }}</label><input id="guardian_phone" type="text" inputmode="tel"></div>
            <div class="wizard-subsection col-12">
                <h4 class="wizard-subsection__title">{{ __('wizard.sections.address_health') }}</h4>
                <p class="wizard-subsection__text">{{ __('wizard.section_notes.contact') }}</p>
            </div>
            <div class="wizard-field col-12"><label for="permanent_address">{{ __('wizard.fields.permanent_address') }}</label><textarea id="permanent_address"></textarea></div>
            <div class="wizard-field col-12"><label for="current_address">{{ __('wizard.fields.current_address') }}</label><textarea id="current_address"></textarea></div>
            <div class="wizard-field col-6"><label for="medical_notes">{{ __('wizard.fields.medical_notes') }}</label><textarea id="medical_notes"></textarea></div>
            <div class="wizard-field col-6"><label for="chronic_diseases">{{ __('wizard.fields.chronic_diseases') }}</label><textarea id="chronic_diseases"></textarea></div>
            <div class="wizard-field col-6"><label for="allergies">{{ __('wizard.fields.allergies') }}</label><textarea id="allergies"></textarea></div>
            <div class="wizard-field col-6"><label for="custody_notes">{{ __('wizard.fields.custody_notes') }}</label><textarea id="custody_notes"></textarea></div>
            <div class="wizard-field col-12">
                <div class="wizard-toggle-card">
                    <label class="wizard-check" for="fever_medicine_permission">
                        <input type="checkbox" id="fever_medicine_permission">
                        <span class="wizard-check__text">{{ __('wizard.fields.fever_medicine_permission') }}</span>
                    </label>
                </div>
            </div>
            <div class="wizard-field col-6">
                <label class="wizard-label-required" for="fourth_image">{{ __('wizard.fields.birth_record') }}</label>
                <input id="fourth_image" type="file" accept=".jpg,.jpeg,.png,.pdf">
                <div class="wizard-file-status" data-file-status="fourth_image"></div>
            </div>
            <div class="wizard-field col-6">
                <label class="wizard-label-required" for="personal_image">{{ __('wizard.fields.personal_image') }}</label>
                <input id="personal_image" type="file" accept=".jpg,.jpeg,.png,.pdf">
                <div class="wizard-file-status" data-file-status="personal_image"></div>
            </div>
            <div class="wizard-field col-6">
                <label for="passbord">{{ __('wizard.fields.passport_copy') }}</label>
                <input id="passbord" type="file" accept=".jpg,.jpeg,.png,.pdf">
                <div class="wizard-file-status" data-file-status="passbord"></div>
            </div>
            <div class="wizard-field col-6">
                <label class="wizard-label-required" for="certification">{{ __('wizard.fields.latest_certificate') }}</label>
                <input id="certification" type="file" accept=".jpg,.jpeg,.png,.pdf">
                <div class="wizard-file-status" data-file-status="certification"></div>
            </div>
            <div class="wizard-field col-6">
                <label class="wizard-label-required" for="mather_page">{{ __('wizard.fields.mother_passport') }}</label>
                <input id="mather_page" type="file" accept=".jpg,.jpeg,.png,.pdf">
                <div class="wizard-file-status" data-file-status="mather_page"></div>
            </div>
            <div class="wizard-field col-6">
                <label class="wizard-label-required" for="father_page">{{ __('wizard.fields.father_passport') }}</label>
                <input id="father_page" type="file" accept=".jpg,.jpeg,.png,.pdf">
                <div class="wizard-file-status" data-file-status="father_page"></div>
            </div>
        </div>
        <div class="wizard-error" id="step2Error">{{ __('wizard.errors.step2_required') }}</div>
        <div class="wizard-actions">
            <button type="button" class="btn btn-light" data-back="1">{{ __('wizard.buttons.previous') }}</button>
            <button type="button" class="btn btn-primary" id="btnStep2Next">{{ __('wizard.buttons.next') }}</button>
        </div>
    </div>

    <div class="wizard-card wizard-pane" data-pane="3">
        <h3 class="wizard-section-title">{{ __('wizard.sections.transport') }}</h3>
        <div class="wizard-choice-wrap">
            <label class="wizard-choice" id="choiceYes">
                <input type="radio" name="wants_transport" value="1">
                <span class="wizard-choice__content">
                    <span class="wizard-choice__title">{{ __('wizard.options.transport_yes_title') }}</span>
                    <span class="wizard-choice__hint">{{ __('wizard.options.transport_yes_hint') }}</span>
                </span>
            </label>
            <label class="wizard-choice" id="choiceNo">
                <input type="radio" name="wants_transport" value="0">
                <span class="wizard-choice__content">
                    <span class="wizard-choice__title">{{ __('wizard.options.transport_no_title') }}</span>
                    <span class="wizard-choice__hint">{{ __('wizard.options.transport_no_hint') }}</span>
                </span>
            </label>
        </div>
        <div class="wizard-actions">
            <button type="button" class="btn btn-light" data-back="2">{{ __('wizard.buttons.previous') }}</button>
            <button type="button" class="btn btn-primary" id="btnStep3Next" disabled>{{ __('wizard.buttons.next') }}</button>
        </div>
    </div>

    <div class="wizard-card wizard-pane" data-pane="4">
        <h3 class="wizard-section-title">{{ __('wizard.sections.transport_terms') }}</h3>
        <div class="wizard-terms-panel">
            <div class="wizard-terms-panel__head">
                <p class="wizard-terms-panel__title">{{ __('wizard.sections.transport_terms') }}</p>
                <p class="wizard-terms-panel__intro">{{ __('wizard.terms.agreement_intro') }}</p>
            </div>
            <div class="wizard-terms-panel__body">
                {!! $renderAgreementContent(optional($transportTerms)->content ?? '', __('wizard.terms.empty_transport')) !!}
            </div>
        </div>
        <div class="wizard-agreement-consent">
            <label class="wizard-check" for="agreeTransportTerms">
                <input type="checkbox" id="agreeTransportTerms">
                <span class="wizard-check__text">{{ __('wizard.terms.transport_agree') }}</span>
            </label>
        </div>
        <div class="wizard-actions">
            <button type="button" class="btn btn-light" data-back="3">{{ __('wizard.buttons.previous') }}</button>
            <button type="button" class="btn btn-primary" id="btnStep4Next" disabled>{{ __('wizard.buttons.next') }}</button>
        </div>
    </div>

    <div class="wizard-card wizard-pane" data-pane="5">
        <h3 class="wizard-section-title">{{ __('wizard.sections.review_payment') }}</h3>
        <div class="wizard-summary" id="summaryBox"></div>
        <div class="wizard-payment-section">
            <h4 class="wizard-summary-heading">{{ __('wizard.payment.title') }}</h4>
            <p>{{ $paymentInstructions !== '' ? $paymentInstructions : __('wizard.payment.instructions') }}</p>
            <div class="wizard-payment-meta">
                <div class="wizard-summary-row">
                    <span>{{ __('wizard.payment.reference') }}</span>
                    <span>{{ $paymentReference !== '' ? $paymentReference : __('wizard.payment.reference_value') }}</span>
                </div>
                <div class="wizard-summary-row">
                    <span>{{ __('wizard.payment.method') }}</span>
                    <span>{{ $paymentAccount !== '' ? $paymentAccount : __('wizard.payment.method_manual') }}</span>
                </div>
            </div>
            @if($paymentQrUrl !== '')
                <div class="wizard-payment-qr-wrap">
                    <img class="wizard-payment-qr" src="{{ $paymentQrUrl }}" alt="Payment QR" loading="lazy" onerror="this.closest('.wizard-payment-qr-wrap').style.display='none';">
                </div>
            @endif
            <div class="wizard-field col-12" style="margin-top: 12px;">
                <label class="wizard-label-required" for="payment_receipt">{{ __('wizard.payment.receipt_label') }}</label>
                <input id="payment_receipt" type="file" accept=".jpg,.jpeg,.png,.pdf">
                <div class="wizard-file-status" data-file-status="payment_receipt"></div>
            </div>
            <div class="wizard-error" id="paymentReceiptError">{{ __('wizard.errors.required_file') }}</div>
            <div class="wizard-submit-note">{{ __('wizard.payment.submit_note') }}</div>
        </div>
        <div class="wizard-actions">
            <button type="button" class="btn btn-light" id="btnStep5Back">{{ __('wizard.buttons.previous') }}</button>
            <button type="button" class="btn btn-success" id="btnFinalSubmit">{{ __('wizard.buttons.submit_registration') }}</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const state = {
        step: 1,
        draftToken: @json($wizardToken),
        wantsTransport: null,
        formData: {},
        uploadedFiles: {},
        tempFiles: {},
        tempFileNames: {},
        pendingFileUploads: {},
        acceptedTerms: false,
        acceptedTransportTerms: false,
        fees: {},
        payment: {}
    };

    const csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    const redirectAfterSubmit = @json(url($locale));
    const storageKey = 'admissionWizardDraft:' + state.draftToken;
    const serverDraft = {!! json_encode($wizardDraft ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
    const leaveWarningMessage = @json($isRtl ? 'لديك بيانات قيد الإدخال. قد تفقد التغييرات غير المكتملة إذا غادرت الصفحة الآن.' : 'You have registration data in progress. You may lose unfinished changes if you leave this page now.');
    const fileStatusLabels = {
        temporaryUploaded: @json($isRtl ? 'مرفوع مؤقتاً' : 'Temporarily uploaded'),
        pendingUpload: @json($isRtl ? 'بانتظار الرفع' : 'Pending upload'),
        uploaded: @json($isRtl ? 'مرفوع' : 'Uploaded')
    };
    const paymentReferenceLabel = @json($paymentReference !== '' ? $paymentReference : __('wizard.payment.reference_value'));
    const paymentMethodLabel = @json($paymentAccount !== '' ? $paymentAccount : __('wizard.payment.method_manual'));
    const acceptanceSectionTitle = @json($isRtl ? 'الموافقة والقبول' : 'Acceptance');
    let allowSilentUnload = false;
    const urls = {
        step1: "{{ route('registration_wizard.step1') }}",
        step2: "{{ route('registration_wizard.step2') }}",
        tempFile: "{{ route('registration_wizard.temp_file') }}",
        step3: "{{ route('registration_wizard.step3') }}",
        summary: "{{ route('registration_wizard.summary') }}",
        finalSubmit: "{{ route('registration_wizard.final_submit') }}"
    };
    const requiredStep2 = ['first_name', 'last_name', 'father_name', 'mather_name', 'date', 'class1', 'country', 'phone'];
    const requiredStep2Files = ['fourth_image', 'personal_image', 'certification', 'mather_page', 'father_page'];
    const i18n = {!! json_encode([
        'errors' => [
            'termsRequired' => __('wizard.errors.terms_required'),
            'step2Required' => __('wizard.errors.step2_required'),
            'requestFailed' => __('wizard.errors.request_failed'),
            'studentSaveFailed' => __('wizard.errors.student_save_failed'),
            'completeStudentFirst' => __('wizard.errors.complete_student_first'),
            'transportSaveFailed' => __('wizard.errors.transport_save_failed'),
            'transportTermsFailed' => __('wizard.errors.transport_terms_failed'),
            'paymentReceiptRequired' => __('wizard.errors.required_file'),
            'finalSubmitFailed' => __('wizard.errors.final_submit_failed'),
        ],
        'buttons' => [
            'submitRegistration' => __('wizard.buttons.submit_registration'),
            'submitted' => __('wizard.buttons.submitted'),
        ],
        'success' => [
            'finalSubmit' => __('wizard.success.final_submit'),
            'finalSubmitHint' => __('wizard.success.final_submit_hint'),
        ],
        'fields' => [
            'first_name' => __('wizard.fields.first_name'),
            'last_name' => __('wizard.fields.last_name'),
            'first_name_en' => __('wizard.fields.first_name_en'),
            'last_name_en' => __('wizard.fields.last_name_en'),
            'father_name' => __('wizard.fields.father_name'),
            'mother_name' => __('wizard.fields.mother_name'),
            'mother_last_name' => __('wizard.fields.mother_last_name'),
            'date' => __('wizard.fields.date'),
            'class' => __('wizard.fields.class'),
            'gender' => __('wizard.fields.gender'),
            'religion' => __('wizard.fields.religion'),
            'nationality' => __('wizard.fields.nationality'),
            'country' => __('wizard.fields.country'),
            'city' => __('wizard.fields.city'),
            'id_number' => __('wizard.fields.id_number'),
            'passport_number' => __('wizard.fields.passport_number'),
            'place_of_birth' => __('wizard.fields.place_of_birth'),
            'phone' => __('wizard.fields.phone'),
            'father_phone' => __('wizard.fields.father_phone'),
            'mother_phone' => __('wizard.fields.mother_phone'),
            'father_job' => __('wizard.fields.father_job'),
            'mother_job' => __('wizard.fields.mother_job'),
            'other_phone' => __('wizard.fields.other_phone'),
            'email' => __('wizard.fields.email'),
            'previous_school' => __('wizard.fields.previous_school'),
            'guardian_name' => __('wizard.fields.guardian_name'),
            'guardian_relation' => __('wizard.fields.guardian_relation'),
            'guardian_phone' => __('wizard.fields.guardian_phone'),
            'permanent_address' => __('wizard.fields.permanent_address'),
            'current_address' => __('wizard.fields.current_address'),
            'notes' => __('wizard.fields.notes'),
            'medical_notes' => __('wizard.fields.medical_notes'),
            'chronic_diseases' => __('wizard.fields.chronic_diseases'),
            'allergies' => __('wizard.fields.allergies'),
            'fever_medicine_permission' => __('wizard.fields.fever_medicine_permission'),
            'custody_notes' => __('wizard.fields.custody_notes'),
            'birth_record' => __('wizard.fields.birth_record'),
            'personal_image' => __('wizard.fields.personal_image'),
            'passport_copy' => __('wizard.fields.passport_copy'),
            'latest_certificate' => __('wizard.fields.latest_certificate'),
            'mother_passport' => __('wizard.fields.mother_passport'),
            'father_passport' => __('wizard.fields.father_passport'),
        ],
        'sections' => [
            'guardian_contacts' => __('wizard.sections.guardian_contacts'),
            'address_health' => __('wizard.sections.address_health'),
            'documents' => __('wizard.section_notes.documents'),
        ],
        'options' => [
            'allowed' => __('wizard.options.allowed'),
            'not_allowed' => __('wizard.options.not_allowed'),
            'yes' => __('wizard.summary.yes'),
            'no' => __('wizard.summary.no'),
        ],
        'summary' => [
            'studentSummary' => __('wizard.sections.student_summary'),
            'feesSummary' => __('wizard.sections.fees_summary'),
            'fullName' => __('wizard.summary.full_name'),
            'firstNameEn' => __('wizard.fields.first_name_en'),
            'lastNameEn' => __('wizard.fields.last_name_en'),
            'fatherName' => __('wizard.summary.father_name'),
            'motherName' => __('wizard.summary.mother_name'),
            'motherLastName' => __('wizard.fields.mother_last_name'),
            'gender' => __('wizard.fields.gender'),
            'religion' => __('wizard.fields.religion'),
            'nationality' => __('wizard.fields.nationality'),
            'country' => __('wizard.fields.country'),
            'date' => __('wizard.fields.date'),
            'placeOfBirth' => __('wizard.fields.place_of_birth'),
            'fatherPhone' => __('wizard.summary.father_phone'),
            'motherPhone' => __('wizard.summary.mother_phone'),
            'fatherJob' => __('wizard.summary.father_job'),
            'motherJob' => __('wizard.summary.mother_job'),
            'guardianName' => __('wizard.summary.guardian_name'),
            'guardianRelation' => __('wizard.summary.guardian_relation'),
            'guardianPhone' => __('wizard.summary.guardian_phone'),
            'phone' => __('wizard.summary.phone'),
            'class' => __('wizard.summary.class'),
            'permanentAddress' => __('wizard.summary.permanent_address'),
            'currentAddress' => __('wizard.summary.current_address'),
            'emergencyPhone' => __('wizard.summary.emergency_phone'),
            'idNumber' => __('wizard.summary.id_number'),
            'passportNumber' => __('wizard.fields.passport_number'),
            'transport' => __('wizard.summary.transport'),
            'medicalNotes' => __('wizard.summary.medical_notes'),
            'chronicDiseases' => __('wizard.summary.chronic_diseases'),
            'allergies' => __('wizard.summary.allergies'),
            'feverMedicinePermission' => __('wizard.summary.fever_medicine_permission'),
            'custodyNotes' => __('wizard.summary.custody_notes'),
            'documents' => $isRtl ? 'الوثائق' : 'Documents',
            'paymentReference' => $isRtl ? 'مرجع الدفع' : 'Payment reference',
            'paymentMethod' => $isRtl ? 'طريقة الدفع' : 'Payment method',
            'schoolAgreement' => __('wizard.terms.school_agree'),
            'transportAgreement' => __('wizard.terms.transport_agree'),
            'registrationFee' => __('wizard.summary.registration_fee'),
            'servicesFee' => __('wizard.summary.services_fee'),
            'transportFee' => __('wizard.summary.transport_fee'),
            'total' => __('wizard.summary.total'),
            'yes' => __('wizard.summary.yes'),
            'no' => __('wizard.summary.no'),
            'dash' => '-',
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};

    function escapeHtml(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showAlert(message) {
        const alertBox = document.getElementById('wizardAlert');
        alertBox.textContent = message;
        alertBox.classList.add('show');
        window.setTimeout(function () {
            alertBox.classList.remove('show');
        }, 5000);
    }

    function showSuccessToast(title, hint) {
        const toast = document.createElement('div');
        toast.className = 'wizard-success-toast';
        toast.innerHTML =
            '<div class="wizard-success-toast__inner">' +
                '<p class="wizard-success-toast__title">' + escapeHtml(title || '') + '</p>' +
                '<p class="wizard-success-toast__hint">' + escapeHtml(hint || '') + '</p>' +
            '</div>';
        document.body.appendChild(toast);
        window.requestAnimationFrame(function () {
            toast.classList.add('is-visible');
        });
        return toast;
    }

    function readStoredDraft() {
        const candidates = [];
        try {
            candidates.push(sessionStorage.getItem(storageKey));
        } catch (error) {}
        try {
            candidates.push(localStorage.getItem(storageKey));
        } catch (error) {}
        for (const candidate of candidates) {
            if (!candidate) {
                continue;
            }
            try {
                const parsed = JSON.parse(candidate);
                if (parsed && typeof parsed === 'object') {
                    return parsed;
                }
            } catch (error) {}
        }
        return {};
    }

    function writeStoredDraft(draft) {
        const payload = JSON.stringify(draft || {});
        try {
            sessionStorage.setItem(storageKey, payload);
        } catch (error) {}
        try {
            localStorage.setItem(storageKey, payload);
        } catch (error) {}
    }

    function clearStoredDraft() {
        try {
            sessionStorage.removeItem(storageKey);
        } catch (error) {}
        try {
            localStorage.removeItem(storageKey);
        } catch (error) {}
    }

    function captureDraftSnapshot() {
        return {
            step: state.step,
            draftToken: state.draftToken,
            acceptedTerms: state.acceptedTerms ? 1 : 0,
            acceptedTransportTerms: state.acceptedTransportTerms ? 1 : 0,
            wantsTransport: state.wantsTransport,
            formData: state.formData,
            uploadedFiles: state.uploadedFiles,
            tempFiles: state.tempFiles,
            tempFileNames: state.tempFileNames,
            fees: state.fees,
            payment: state.payment
        };
    }

    function persistWizardState() {
        writeStoredDraft(captureDraftSnapshot());
    }

    function deepMerge(target, source) {
        const output = Array.isArray(target) ? target.slice() : Object.assign({}, target || {});
        Object.keys(source || {}).forEach(function (key) {
            const value = source[key];
            if (value && typeof value === 'object' && !Array.isArray(value)) {
                output[key] = deepMerge(output[key], value);
                return;
            }
            output[key] = value;
        });
        return output;
    }

    function getActiveDraft() {
        return deepMerge(serverDraft, readStoredDraft());
    }

    function setFileStatus(field, label, isSuccess) {
        const statusNode = document.querySelector('[data-file-status="' + field + '"]');
        if (!statusNode) {
            return;
        }
        statusNode.textContent = label || '';
        statusNode.style.color = isSuccess ? '#1f8f5f' : '#7f7891';
    }

    function setInputValue(id, value) {
        const element = document.getElementById(id);
        if (!element) {
            return;
        }
        const tag = (element.tagName || '').toLowerCase();
        const type = (element.type || '').toLowerCase();
        if (type === 'checkbox') {
            element.checked = !!Number(value);
            return;
        }
        if (type === 'radio') {
            element.checked = String(element.value) === String(value);
            return;
        }
        if (tag === 'select' || type === 'text' || type === 'email' || type === 'date' || type === 'textarea' || tag === 'textarea') {
            element.value = value == null ? '' : String(value);
        }
    }

    function syncFormToState() {
        state.formData = collectStep2Data();
        state.acceptedTerms = document.getElementById('agreeTerms') ? document.getElementById('agreeTerms').checked : state.acceptedTerms;
        state.acceptedTransportTerms = document.getElementById('agreeTransportTerms') ? document.getElementById('agreeTransportTerms').checked : state.acceptedTransportTerms;
        persistWizardState();
    }

    function applyDraftToForm(draft) {
        const data = (draft && draft.formData) || (draft && draft.form_data) || {};
        state.step = Number(draft && draft.step ? draft.step : draft && draft.current_step ? draft.current_step : 1) || 1;
        const draftTransportValue = draft && draft.wantsTransport !== undefined ? draft.wantsTransport : draft && draft.wants_transport !== undefined ? draft.wants_transport : state.wantsTransport;
        state.wantsTransport = draftTransportValue === null || draftTransportValue === '' || draftTransportValue === undefined ? state.wantsTransport : Number(draftTransportValue);
        state.acceptedTerms = !!Number(draft && (draft.acceptedTerms !== undefined ? draft.acceptedTerms : draft.accepted_terms));
        state.acceptedTransportTerms = !!Number(draft && (draft.acceptedTransportTerms !== undefined ? draft.acceptedTransportTerms : draft.accepted_transport_terms));
        state.formData = data;
        state.uploadedFiles = (draft && (draft.uploadedFiles || draft.uploaded_files)) ? deepMerge({}, (draft.uploadedFiles || draft.uploaded_files)) : {};
        state.tempFiles = (draft && draft.tempFiles) ? deepMerge({}, draft.tempFiles) : {};
        state.tempFileNames = (draft && draft.tempFileNames) ? deepMerge({}, draft.tempFileNames) : {};
        state.pendingFileUploads = {};
        state.fees = (draft && draft.fees) ? deepMerge({}, draft.fees) : state.fees;
        state.payment = (draft && draft.payment) ? deepMerge({}, draft.payment) : state.payment;

        Object.keys(data || {}).forEach(function (key) {
            setInputValue(key, data[key]);
        });
        if (document.getElementById('agreeTerms')) {
            document.getElementById('agreeTerms').checked = state.acceptedTerms;
        }
        if (document.getElementById('agreeTransportTerms')) {
            document.getElementById('agreeTransportTerms').checked = state.acceptedTransportTerms;
        }
        if (document.getElementById('fever_medicine_permission')) {
            document.getElementById('fever_medicine_permission').checked = Number(data.fever_medicine_permission || 0) === 1;
        }
        ['fourth_image', 'passbord', 'personal_image', 'certification', 'mather_page', 'father_page'].forEach(function (field) {
            const hasTemp = !!(state.tempFiles[field] || (state.uploadedFiles[field] && state.uploadedFiles[field].path));
            setFileStatus(field, hasTemp ? (state.tempFileNames[field] || fileStatusLabels.temporaryUploaded) : fileStatusLabels.pendingUpload, hasTemp);
        });
        if (state.wantsTransport === 1) {
            document.getElementById('choiceYes').classList.add('is-active');
            document.getElementById('choiceNo').classList.remove('is-active');
            document.querySelector('#choiceYes input[type="radio"]').checked = true;
            document.querySelector('#choiceNo input[type="radio"]').checked = false;
            document.getElementById('btnStep3Next').disabled = false;
        } else if (state.wantsTransport === 0) {
            document.getElementById('choiceNo').classList.add('is-active');
            document.getElementById('choiceYes').classList.remove('is-active');
            document.querySelector('#choiceNo input[type="radio"]').checked = true;
            document.querySelector('#choiceYes input[type="radio"]').checked = false;
            document.getElementById('btnStep3Next').disabled = false;
        }
        persistWizardState();
        setStep(state.step);
    }

    function hasDirtyWizardState() {
        if (allowSilentUnload) {
            return false;
        }

        const scope = document.querySelector('.wizard-wrap');
        if (!scope) {
            return false;
        }

        const inputs = scope.querySelectorAll('input:not([type="hidden"]), textarea, select');
        for (const input of inputs) {
            const tag = (input.tagName || '').toLowerCase();
            const type = (input.type || '').toLowerCase();

            if (type === 'file') {
                if (input.files && input.files.length > 0) {
                    return true;
                }
                continue;
            }

            if (type === 'checkbox' || type === 'radio') {
                if (input.checked) {
                    return true;
                }
                continue;
            }

            if (tag === 'select') {
                if (String(input.value || '').trim() !== '') {
                    return true;
                }
                continue;
            }

            if (String(input.value || '').trim() !== '') {
                return true;
            }
        }

        return false;
    }

    window.addEventListener('beforeunload', function (event) {
        if (!hasDirtyWizardState()) {
            return;
        }
        event.preventDefault();
        event.returnValue = leaveWarningMessage;
        return leaveWarningMessage;
    });

    function setStep(step) {
        state.step = step;
        document.querySelectorAll('.wizard-pane').forEach(function (pane) {
            pane.classList.remove('is-active');
        });
        const pane = document.querySelector('[data-pane="' + step + '"]');
        if (pane) {
            pane.classList.add('is-active');
        }
        document.querySelectorAll('.wizard-step-chip').forEach(function (chip) {
            const chipStep = Number(chip.dataset.step);
            chip.classList.toggle('is-active', chipStep === step);
            chip.classList.toggle('is-done', chipStep < step);
        });
    }

    function extractErrorMessage(data, fallback) {
        if (data && data.errors) {
            const firstKey = Object.keys(data.errors)[0];
            if (firstKey && Array.isArray(data.errors[firstKey]) && data.errors[firstKey][0]) {
                return data.errors[firstKey][0];
            }
        }
        return (data && data.message) ? data.message : fallback;
    }

    async function postUrlEncoded(url, payload) {
        console.log('[wizard] post', url, payload);
        const body = new URLSearchParams();
        Object.keys(payload).forEach(function (key) {
            body.append(key, payload[key]);
        });
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Content-Type': 'application/x-www-form-urlencoded',
                'Accept': 'application/json'
            },
            body: body.toString()
        });
        const data = await response.json().catch(function () {
            return null;
        });
        console.log('[wizard] response', data);
        if (!response.ok || !data || data.success === false) {
            throw new Error(extractErrorMessage(data, i18n.errors.requestFailed));
        }
        return data;
    }

    async function postFormData(url, formData, fallbackMessage) {
        console.log('[wizard] multipart', url);
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: formData
        });
        const data = await response.json().catch(function () {
            return null;
        });
        console.log('[wizard] multipart response', data);
        if (!response.ok || !data || data.success === false) {
            throw new Error(extractErrorMessage(data, fallbackMessage || i18n.errors.studentSaveFailed));
        }
        return data;
    }

    function collectStep2Data() {
        const classSelect = document.getElementById('class1');
        const classOption = classSelect.options[classSelect.selectedIndex];
        const countrySelect = document.getElementById('country');
        const countryOption = countrySelect.options[countrySelect.selectedIndex];

        return {
            first_name: document.getElementById('first_name').value.trim(),
            last_name: document.getElementById('last_name').value.trim(),
            first_name_en: document.getElementById('first_name_en').value.trim(),
            last_name_en: document.getElementById('last_name_en').value.trim(),
            father_name: document.getElementById('father_name').value.trim(),
            mather_name: document.getElementById('mather_name').value.trim(),
            last_mother_name: document.getElementById('last_mother_name').value.trim(),
            date: document.getElementById('date').value,
            class1: classSelect.value,
            class_name: classOption ? (classOption.text || '') : '',
            gender: document.getElementById('gender').value,
            gender_label: document.getElementById('gender').selectedIndex >= 0 ? (document.getElementById('gender').options[document.getElementById('gender').selectedIndex].text || '') : '',
            religion: document.getElementById('religion').value,
            religion_label: document.getElementById('religion').selectedIndex >= 0 ? (document.getElementById('religion').options[document.getElementById('religion').selectedIndex].text || '') : '',
            nationality: document.getElementById('nationality').value,
            nationality_label: document.getElementById('nationality').selectedIndex >= 0 ? (document.getElementById('nationality').options[document.getElementById('nationality').selectedIndex].text || '') : '',
            the_ID_number: document.getElementById('the_ID_number').value.trim(),
            passport_number: document.getElementById('passport_number').value.trim(),
            place_of_birth: document.getElementById('place_of_birth').value.trim(),
            country: document.getElementById('country').value,
            country_label: countryOption ? (countryOption.text || '') : '',
            city: document.getElementById('city').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            father_phone: document.getElementById('father_phone').value.trim(),
            mather_phone: document.getElementById('mather_phone').value.trim(),
            father_job: document.getElementById('father_job').value.trim(),
            mather_job: document.getElementById('mather_job').value.trim(),
            guardian_name: document.getElementById('guardian_name').value.trim(),
            guardian_relation: document.getElementById('guardian_relation').value.trim(),
            guardian_phone: document.getElementById('guardian_phone').value.trim(),
            other_phone: document.getElementById('other_phone').value.trim(),
            email: document.getElementById('email').value.trim(),
            the_previous_school: document.getElementById('the_previous_school').value.trim(),
            con_sch: document.getElementById('con_sch').value.trim(),
            permanent_address: document.getElementById('permanent_address').value.trim(),
            current_address: document.getElementById('current_address').value.trim(),
            medical_notes: document.getElementById('medical_notes').value.trim(),
            chronic_diseases: document.getElementById('chronic_diseases').value.trim(),
            allergies: document.getElementById('allergies').value.trim(),
            fever_medicine_permission: document.getElementById('fever_medicine_permission').checked ? 1 : 0,
            custody_notes: document.getElementById('custody_notes').value.trim(),
            grade_level: classOption ? (classOption.dataset.stageKey || '') : ''
        };
    }

    function setFieldValidity(fieldId, isValid) {
        const element = document.getElementById(fieldId);
        if (!element) {
            return;
        }
        const wrapper = element.closest('.wizard-field');
        if (wrapper) {
            wrapper.classList.toggle('is-invalid', !isValid);
        }
    }

    function validateStep2(data) {
        let isValid = true;

        requiredStep2.forEach(function (field) {
            const fieldValid = String(data[field] || '').trim() !== '';
            setFieldValidity(field, fieldValid);
            if (!fieldValid) {
                isValid = false;
            }
        });

        requiredStep2Files.forEach(function (field) {
            const input = document.getElementById(field);
            const fileValid = !!((input && input.files && input.files.length > 0) || state.uploadedFiles[field]);
            setFieldValidity(field, fileValid);
            if (!fileValid) {
                isValid = false;
            }
        });

        document.getElementById('step2Error').classList.toggle('show', !isValid);
        if (!isValid) {
            console.warn('[wizard] validation failed', data);
        }
        return isValid;
    }

    function buildStep2Payload(data) {
        const formData = new FormData();
        if (state.draftToken) {
            formData.append('draft_token', state.draftToken);
        }
        Object.keys(data).forEach(function (key) {
            if (key === 'country_label') {
                return;
            }
            formData.append('form_data[' + key + ']', data[key]);
        });
        ['fourth_image', 'passbord', 'personal_image', 'certification', 'mather_page', 'father_page'].forEach(function (field) {
            if (state.tempFiles[field]) {
                return;
            }
            const input = document.getElementById(field);
            if (input && input.files && input.files[0]) {
                formData.append(field, input.files[0]);
            }
        });
        return formData;
    }

    function renderSummary(data) {
        function displayValue(value) {
            return value === null || value === undefined || value === '' ? i18n.summary.dash : String(value);
        }

        function row(label, value, variant) {
            return '<div class="wizard-summary-row' + (variant ? ' ' + variant : '') + '"><span>' + escapeHtml(label) + '</span><span>' + escapeHtml(value) + '</span></div>';
        }

        function section(title, rows) {
            return '<div class="wizard-summary-section">' +
                '<h4 class="wizard-summary-heading">' + escapeHtml(title) + '</h4>' +
                '<div class="wizard-summary-grid">' + rows.join('') + '</div>' +
            '</div>';
        }

        const draft = data && typeof data === 'object' ? (data.draft || {}) : {};
        const fees = data && data.fees ? data.fees : (draft.fees || state.fees || {});
        const payment = data && data.payment ? data.payment : (draft.payment || state.payment || {});
        const formData = deepMerge({}, state.formData || draft.form_data || draft.formData || {});
        const transportEnabled = Number(state.wantsTransport || draft.wants_transport || 0) === 1;
        const fullName = ((formData.first_name || '') + ' ' + (formData.last_name || '')).trim();
        const genderLabel = formData.gender_label || (String(formData.gender) === '1' ? i18n.options.male : String(formData.gender) === '0' ? i18n.options.female : '');
        const religionLabel = formData.religion_label || (String(formData.religion) === '0' ? i18n.options.muslim : String(formData.religion) === '1' ? i18n.options.christian : '');
        const schoolAgreementLabel = state.acceptedTerms ? i18n.options.yes : i18n.options.no;
        const transportAgreementLabel = transportEnabled ? (state.acceptedTransportTerms ? i18n.options.yes : i18n.options.no) : @json($isRtl ? 'غير مطلوب' : 'Not required');
        const documents = [
            ['fourth_image', i18n.fields.birth_record],
            ['personal_image', i18n.fields.personal_image],
            ['passbord', i18n.fields.passport_copy],
            ['certification', i18n.fields.latest_certificate],
            ['mather_page', i18n.fields.mother_passport],
            ['father_page', i18n.fields.father_passport]
        ];

        state.formData = formData;
        state.fees = deepMerge({}, fees);
        state.payment = deepMerge({}, payment);

        const studentRows = [
            row(i18n.summary.fullName, displayValue(fullName)),
            row(i18n.summary.firstNameEn, displayValue(formData.first_name_en)),
            row(i18n.summary.lastNameEn, displayValue(formData.last_name_en)),
            row(i18n.summary.fatherName, displayValue(formData.father_name)),
            row(i18n.summary.motherName, displayValue(formData.mather_name)),
            row(i18n.summary.motherLastName, displayValue(formData.last_mother_name)),
            row(i18n.summary.date, displayValue(formData.date)),
            row(i18n.summary.class, displayValue(formData.class_name)),
            row(i18n.summary.gender, displayValue(genderLabel)),
            row(i18n.summary.religion, displayValue(religionLabel)),
            row(i18n.summary.nationality, displayValue(formData.nationality_label || formData.nationality)),
            row(i18n.summary.country, displayValue(formData.country_label || formData.country)),
            row(i18n.summary.placeOfBirth, displayValue(formData.place_of_birth)),
            row(i18n.summary.idNumber, displayValue(formData.the_ID_number)),
            row(i18n.summary.passportNumber, displayValue(formData.passport_number)),
            row(i18n.summary.phone, displayValue(formData.phone)),
            row(i18n.fields.email, displayValue(formData.email)),
            row(i18n.fields.previous_school, displayValue(formData.the_previous_school)),
            row(i18n.summary.transport, displayValue(transportEnabled ? i18n.summary.yes : i18n.summary.no))
        ];

        const guardianRows = [
            row(i18n.summary.fatherPhone, displayValue(formData.father_phone)),
            row(i18n.summary.motherPhone, displayValue(formData.mather_phone)),
            row(i18n.summary.fatherJob, displayValue(formData.father_job)),
            row(i18n.summary.motherJob, displayValue(formData.mather_job)),
            row(i18n.summary.guardianName, displayValue(formData.guardian_name)),
            row(i18n.summary.guardianRelation, displayValue(formData.guardian_relation)),
            row(i18n.summary.guardianPhone, displayValue(formData.guardian_phone)),
            row(i18n.summary.emergencyPhone, displayValue(formData.other_phone))
        ];

        const addressRows = [
            row(i18n.summary.permanentAddress, displayValue(formData.permanent_address)),
            row(i18n.summary.currentAddress, displayValue(formData.current_address)),
            row(i18n.summary.medicalNotes, displayValue(formData.medical_notes)),
            row(i18n.summary.chronicDiseases, displayValue(formData.chronic_diseases)),
            row(i18n.summary.allergies, displayValue(formData.allergies)),
            row(i18n.summary.feverMedicinePermission, displayValue(String(formData.fever_medicine_permission) === '1' ? i18n.options.allowed : i18n.options.not_allowed)),
            row(i18n.summary.custodyNotes, displayValue(formData.custody_notes)),
            row(i18n.fields.notes, displayValue(formData.con_sch))
        ];

        const documentRows = documents.map(function (entry) {
            const field = entry[0];
            const label = entry[1];
            const hasTemp = !!(state.tempFiles[field] || state.uploadedFiles[field]);
            const badge = hasTemp ? (state.tempFileNames[field] || fileStatusLabels.temporaryUploaded) : fileStatusLabels.pendingUpload;
            const fileName = state.tempFileNames[field] || fileStatusLabels.pendingUpload;
            const fileTitle = state.tempFileNames[field] || label;
            return '<div class="wizard-summary-doc">' +
                '<div class="wizard-summary-doc__head">' +
                    '<span class="wizard-summary-doc__title" title="' + escapeHtml(fileTitle) + '">' + escapeHtml(label) + '</span>' +
                    '<span class="wizard-doc-pill ' + (hasTemp ? 'is-success' : 'is-muted') + '" title="' + escapeHtml(fileName) + '">' + escapeHtml(badge) + '</span>' +
                '</div>' +
                '<div class="wizard-summary-doc__meta" title="' + escapeHtml(fileName) + '">' + escapeHtml(hasTemp ? fileName : fileStatusLabels.pendingUpload) + '</div>' +
            '</div>';
        });

        const summaryBox = document.getElementById('summaryBox');
        if (!summaryBox) {
            return;
        }

        summaryBox.innerHTML =
            section(i18n.sections.student_info, studentRows) +
            section(i18n.sections.guardian_contacts, guardianRows) +
            section(i18n.sections.address_health, addressRows) +
            '<div class="wizard-summary-section">' +
                '<h4 class="wizard-summary-heading">' + escapeHtml(i18n.summary.feesSummary) + '</h4>' +
                '<div class="wizard-summary-grid">' +
                    row(i18n.summary.registrationFee, displayValue(fees.registration_fee)) +
                    row(i18n.summary.servicesFee, displayValue(fees.services_fee)) +
                    row(i18n.summary.transportFee, displayValue(fees.transport_fee)) +
                    row(i18n.summary.total, displayValue(fees.total_amount), 'total') +
                '</div>' +
            '</div>' +
            '<div class="wizard-summary-section">' +
                '<h4 class="wizard-summary-heading">' + escapeHtml(i18n.summary.documents || fileStatusLabels.uploaded) + '</h4>' +
                '<div class="wizard-summary-doc-grid">' + documentRows.join('') + '</div>' +
            '</div>' +
            '<div class="wizard-summary-section">' +
                '<h4 class="wizard-summary-heading">' + escapeHtml(acceptanceSectionTitle) + '</h4>' +
                '<div class="wizard-summary-grid">' +
                    row(i18n.summary.schoolAgreement, schoolAgreementLabel) +
                    row(i18n.summary.transportAgreement, transportAgreementLabel) +
                    row(i18n.summary.paymentReference, displayValue(paymentReferenceLabel)) +
                    row(i18n.summary.paymentMethod, displayValue(paymentMethodLabel)) +
                '</div>' +
            '</div>';
    }

    async function uploadTemporaryWizardFile(field, file) {
        if (!file) {
            return;
        }
        const payload = new FormData();
        payload.append('draft_token', state.draftToken);
        payload.append('field', field);
        payload.append('file', file);
        const response = await postFormData(urls.tempFile, payload, i18n.errors.requestFailed);
        if (response && response.temp_file && response.temp_file.path) {
            state.tempFiles[field] = response.temp_file.path;
            state.tempFileNames[field] = response.temp_file.original_name || file.name || fileStatusLabels.temporaryUploaded;
            state.uploadedFiles[field] = response.temp_file;
            setFileStatus(field, state.tempFileNames[field], true);
            persistWizardState();
        }
        return response;
    }

    document.getElementById('agreeTerms').addEventListener('change', function () {
        document.getElementById('agreeTermsError').classList.remove('show');
        state.acceptedTerms = this.checked;
        persistWizardState();
    });

    document.getElementById('btnStep1Next').addEventListener('click', async function () {
        if (!document.getElementById('agreeTerms').checked) {
            document.getElementById('agreeTermsError').classList.add('show');
            return;
        }
        const button = this;
        button.disabled = true;
        try {
            state.acceptedTerms = true;
            persistWizardState();
            const response = await postUrlEncoded(urls.step1, {
                draft_token: state.draftToken,
                accepted_terms: 1
            });
            if (response && response.draft_token) {
                state.draftToken = String(response.draft_token);
                document.getElementById('wizardToken').value = state.draftToken;
            }
            setStep(2);
        } catch (error) {
            showAlert(error.message || i18n.errors.termsRequired);
        } finally {
            button.disabled = false;
        }
    });

    document.getElementById('btnStep2Next').addEventListener('click', async function () {
        state.formData = collectStep2Data();
        if (!validateStep2(state.formData)) {
            return;
        }
        const button = this;
        button.disabled = true;
        try {
            const pendingUploads = Object.values(state.pendingFileUploads || {});
            if (pendingUploads.length > 0) {
                await Promise.allSettled(pendingUploads);
            }
            const payload = buildStep2Payload(state.formData);
            const response = await postFormData(urls.step2, payload, i18n.errors.studentSaveFailed);
            if (response && response.draft_token) {
                state.draftToken = String(response.draft_token);
                document.getElementById('wizardToken').value = state.draftToken;
            }
            requiredStep2Files.forEach(function (field) {
                const input = document.getElementById(field);
                if (input && input.files && input.files.length > 0 && !state.tempFiles[field]) {
                    state.uploadedFiles[field] = true;
                    state.tempFileNames[field] = input.files[0].name || fileStatusLabels.temporaryUploaded;
                    setFileStatus(field, state.tempFileNames[field], true);
                }
            });
            state.formData = collectStep2Data();
            persistWizardState();
            setStep(3);
        } catch (error) {
            showAlert(error.message || i18n.errors.studentSaveFailed);
        } finally {
            button.disabled = false;
        }
    });

    document.getElementById('choiceYes').addEventListener('click', function () {
        state.wantsTransport = 1;
        document.querySelector('#choiceYes input[type="radio"]').checked = true;
        document.querySelector('#choiceNo input[type="radio"]').checked = false;
        document.getElementById('choiceYes').classList.add('is-active');
        document.getElementById('choiceNo').classList.remove('is-active');
        document.getElementById('btnStep3Next').disabled = false;
        persistWizardState();
    });

    document.getElementById('choiceNo').addEventListener('click', function () {
        state.wantsTransport = 0;
        document.querySelector('#choiceNo input[type="radio"]').checked = true;
        document.querySelector('#choiceYes input[type="radio"]').checked = false;
        document.getElementById('choiceNo').classList.add('is-active');
        document.getElementById('choiceYes').classList.remove('is-active');
        document.getElementById('btnStep3Next').disabled = false;
        persistWizardState();
    });

    document.getElementById('btnStep3Next').addEventListener('click', async function () {
        const button = this;
        button.disabled = true;
        try {
            await postUrlEncoded(urls.step3, {
                draft_token: state.draftToken,
                wants_transport: state.wantsTransport,
                accepted_transport_terms: 0
            });
            state.acceptedTransportTerms = false;
            if (state.wantsTransport === 1) {
                persistWizardState();
                setStep(4);
                return;
            }
            const summary = await postUrlEncoded(urls.summary, { draft_token: state.draftToken });
            renderSummary(summary);
            persistWizardState();
            setStep(5);
        } catch (error) {
            showAlert(error.message || i18n.errors.transportSaveFailed);
        } finally {
            button.disabled = false;
        }
    });

    document.getElementById('agreeTransportTerms').addEventListener('change', function (event) {
        document.getElementById('btnStep4Next').disabled = !event.target.checked;
        state.acceptedTransportTerms = !!event.target.checked;
        persistWizardState();
    });

    document.getElementById('btnStep4Next').addEventListener('click', async function () {
        const button = this;
        button.disabled = true;
        try {
            await postUrlEncoded(urls.step3, {
                draft_token: state.draftToken,
                wants_transport: 1,
                accepted_transport_terms: 1
            });
            state.acceptedTransportTerms = true;
            const summary = await postUrlEncoded(urls.summary, { draft_token: state.draftToken });
            renderSummary(summary);
            persistWizardState();
            setStep(5);
        } catch (error) {
            showAlert(error.message || i18n.errors.transportTermsFailed);
        } finally {
            button.disabled = false;
        }
    });

    document.querySelectorAll('[data-back]').forEach(function (button) {
        button.addEventListener('click', function () {
            setStep(Number(button.dataset.back));
        });
    });

    requiredStep2.concat(requiredStep2Files).forEach(function (field) {
        const element = document.getElementById(field);
        if (!element) {
            return;
        }
        const eventName = element.type === 'file' || element.tagName === 'SELECT' ? 'change' : 'input';
        element.addEventListener(eventName, function () {
            setFieldValidity(field, true);
            if (element.type === 'file') {
                const file = element.files && element.files[0] ? element.files[0] : null;
                if (file) {
                    const uploadTask = uploadTemporaryWizardFile(field, file).catch(function (error) {
                        showAlert(error.message || i18n.errors.requestFailed);
                    });
                    state.pendingFileUploads[field] = uploadTask;
                    uploadTask.finally(function () {
                        delete state.pendingFileUploads[field];
                    });
                } else {
                    setFileStatus(field, fileStatusLabels.pendingUpload, false);
                    state.tempFiles[field] = '';
                    state.tempFileNames[field] = '';
                    state.uploadedFiles[field] = false;
                    persistWizardState();
                }
            }
            syncFormToState();
            if (requiredStep2.every(function (item) {
                const target = document.getElementById(item);
                return target && String(target.value || '').trim() !== '';
            }) && requiredStep2Files.every(function (item) {
                const target = document.getElementById(item);
                return (target && target.files && target.files.length > 0) || state.uploadedFiles[item];
            })) {
                document.getElementById('step2Error').classList.remove('show');
            }
        });
    });

    document.getElementById('btnStep5Back').addEventListener('click', function () {
        setStep(state.wantsTransport === 1 ? 4 : 3);
    });

    document.getElementById('payment_receipt').addEventListener('change', function () {
        const valid = this.files && this.files.length > 0;
        setFieldValidity('payment_receipt', valid);
        document.getElementById('paymentReceiptError').classList.toggle('show', !valid);
        setFileStatus('payment_receipt', valid && this.files[0] ? this.files[0].name : fileStatusLabels.pendingUpload, valid);
        persistWizardState();
    });

    document.getElementById('btnFinalSubmit').addEventListener('click', async function () {
        if (!state.draftToken) {
            showAlert(i18n.errors.completeStudentFirst);
            return;
        }

        const receiptInput = document.getElementById('payment_receipt');
        const hasReceipt = !!(receiptInput && receiptInput.files && receiptInput.files.length > 0);
        setFieldValidity('payment_receipt', hasReceipt);
        document.getElementById('paymentReceiptError').classList.toggle('show', !hasReceipt);

        if (!hasReceipt) {
            showAlert(i18n.errors.paymentReceiptRequired);
            return;
        }

        const button = this;
        button.disabled = true;
        try {
            const payload = new FormData();
            payload.append('draft_token', state.draftToken);
            payload.append('payment_method', 'manual');
            payload.append('payment_receipt', receiptInput.files[0]);

            const response = await postFormData(urls.finalSubmit, payload, i18n.errors.finalSubmitFailed);
            const successTitle = (response && response.message) ? response.message : i18n.success.finalSubmit;
            showSuccessToast(successTitle, i18n.success.finalSubmitHint);
            button.textContent = i18n.buttons.submitted;
            const submitNote = document.querySelector('.wizard-submit-note');
            if (submitNote) {
                submitNote.textContent = i18n.success.finalSubmitHint;
            }
            allowSilentUnload = true;
            clearStoredDraft();
            window.setTimeout(function () {
                window.location.href = redirectAfterSubmit;
            }, 1700);
        } catch (error) {
            showAlert(error.message || i18n.errors.finalSubmitFailed);
            button.disabled = false;
        }
    });

    const initialDraft = getActiveDraft();
    if (initialDraft && Object.keys(initialDraft).length > 0) {
        applyDraftToForm(initialDraft);
        if (Number(state.step) === 5) {
            renderSummary({ draft: initialDraft, fees: initialDraft.fees || {}, payment: initialDraft.payment || {} });
        }
    } else {
        persistWizardState();
    }
});
</script>
@endsection


