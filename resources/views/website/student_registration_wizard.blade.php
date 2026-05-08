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
    }

    .wizard-wrap.is-ltr {
        font-family: inherit;
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
        padding: 10px 14px;
        font-family: inherit;
        background: #fff;
        color: #2f2b3a;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        text-align: start;
    }

    .wizard-wrap.is-rtl .wizard-field input,
    .wizard-wrap.is-rtl .wizard-field select,
    .wizard-wrap.is-rtl .wizard-field textarea {
        font-family: 'Cairo', sans-serif;
    }

    .wizard-wrap.is-ltr .wizard-field input,
    .wizard-wrap.is-ltr .wizard-field select,
    .wizard-wrap.is-ltr .wizard-field textarea {
        font-family: inherit;
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
        min-height: 100px;
        resize: vertical;
    }

    .wizard-field.is-invalid input,
    .wizard-field.is-invalid select,
    .wizard-field.is-invalid textarea {
        border-color: #d64545;
        box-shadow: 0 0 0 3px rgba(214, 69, 69, 0.12);
        background: #fffafa;
    }

    .wizard-terms {
        border: 1px solid #e9e8ef;
        border-radius: 14px;
        padding: 14px;
        max-height: 320px;
        overflow: auto;
        line-height: 1.9;
        background: #fcfcfe;
        text-align: start;
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
        margin: 0;
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
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 14px;
        cursor: pointer;
        user-select: none;
        color: #3b354a;
        font-weight: 600;
    }

    .wizard-check input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        width: 22px;
        height: 22px;
        margin: 0;
        border: 2px solid #8e86aa;
        border-radius: 6px;
        background: #fff;
        flex-shrink: 0;
        display: grid;
        place-content: center;
        transition: border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .wizard-check input[type="checkbox"]::before {
        content: "";
        width: 10px;
        height: 6px;
        border-right: 2px solid #fff;
        border-bottom: 2px solid #fff;
        transform: rotate(45deg) scale(0);
        transform-origin: center;
        transition: transform 0.15s ease;
        margin-top: -2px;
    }

    .wizard-check input[type="checkbox"]:checked {
        border-color: #5b4b8a;
        background: #5b4b8a;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.12);
    }

    .wizard-check input[type="checkbox"]:checked::before {
        transform: rotate(45deg) scale(1);
    }

    .wizard-check input[type="checkbox"]:focus-visible {
        outline: none;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.18);
    }

    .wizard-check__text {
        line-height: 1.7;
        text-align: start;
    }

    .wizard-wrap.is-ltr .wizard-check,
    .wizard-wrap.is-ltr .wizard-choice,
    .wizard-wrap.is-ltr .wizard-summary-row,
    .wizard-wrap.is-ltr .wizard-steps {
        direction: ltr;
    }

    .wizard-wrap.is-rtl .wizard-check,
    .wizard-wrap.is-rtl .wizard-choice,
    .wizard-wrap.is-rtl .wizard-summary-row,
    .wizard-wrap.is-rtl .wizard-steps {
        direction: rtl;
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
    <input type="hidden" id="registrationId" value="">

    <div class="wizard-card wizard-pane is-active" data-pane="1">
        <h3 class="wizard-section-title">{{ __('wizard.sections.school_terms') }}</h3>
        <div class="wizard-terms">{!! optional($schoolTerms)->content ?? e(__('wizard.terms.empty_school')) !!}</div>
        <label class="wizard-check" for="agreeTerms">
            <input type="checkbox" id="agreeTerms">
            <span class="wizard-check__text">{{ __('wizard.terms.school_agree') }}</span>
        </label>
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
            <div class="wizard-field col-6"><label class="wizard-label-required" for="fourth_image">{{ __('wizard.fields.birth_record') }}</label><input id="fourth_image" type="file" accept=".jpg,.jpeg,.png,.pdf"></div>
            <div class="wizard-field col-6"><label class="wizard-label-required" for="personal_image">{{ __('wizard.fields.personal_image') }}</label><input id="personal_image" type="file" accept=".jpg,.jpeg,.png,.pdf"></div>
            <div class="wizard-field col-6"><label for="passbord">{{ __('wizard.fields.passport_copy') }}</label><input id="passbord" type="file" accept=".jpg,.jpeg,.png,.pdf"></div>
            <div class="wizard-field col-6"><label class="wizard-label-required" for="certification">{{ __('wizard.fields.latest_certificate') }}</label><input id="certification" type="file" accept=".jpg,.jpeg,.png,.pdf"></div>
            <div class="wizard-field col-6"><label class="wizard-label-required" for="mather_page">{{ __('wizard.fields.mother_passport') }}</label><input id="mather_page" type="file" accept=".jpg,.jpeg,.png,.pdf"></div>
            <div class="wizard-field col-6"><label class="wizard-label-required" for="father_page">{{ __('wizard.fields.father_passport') }}</label><input id="father_page" type="file" accept=".jpg,.jpeg,.png,.pdf"></div>
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
        <div class="wizard-terms">{!! optional($transportTerms)->content ?? e(__('wizard.terms.empty_transport')) !!}</div>
        <label class="wizard-check" for="agreeTransportTerms">
            <input type="checkbox" id="agreeTransportTerms">
            <span class="wizard-check__text">{{ __('wizard.terms.transport_agree') }}</span>
        </label>
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
        registrationId: '',
        wantsTransport: null,
        formData: {},
        uploadedFiles: {}
    };

    const csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    const redirectAfterSubmit = @json(url($locale));
    const leaveWarningMessage = @json($isRtl ? 'لديك بيانات قيد الإدخال. قد تفقد التغييرات غير المكتملة إذا غادرت الصفحة الآن.' : 'You have registration data in progress. You may lose unfinished changes if you leave this page now.');
    let allowSilentUnload = false;
    const urls = {
        step1: "{{ route('registration_wizard.step1') }}",
        step2: "{{ route('registration_wizard.step2') }}",
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
        'summary' => [
            'studentSummary' => __('wizard.sections.student_summary'),
            'feesSummary' => __('wizard.sections.fees_summary'),
            'fullName' => __('wizard.summary.full_name'),
            'fatherName' => __('wizard.summary.father_name'),
            'motherName' => __('wizard.summary.mother_name'),
            'phone' => __('wizard.summary.phone'),
            'class' => __('wizard.summary.class'),
            'address' => __('wizard.summary.address'),
            'idNumber' => __('wizard.summary.id_number'),
            'transport' => __('wizard.summary.transport'),
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

    async function postFormData(url, formData) {
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
            throw new Error(extractErrorMessage(data, i18n.errors.studentSaveFailed));
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
            religion: document.getElementById('religion').value,
            nationality: document.getElementById('nationality').value,
            the_ID_number: document.getElementById('the_ID_number').value.trim(),
            passport_number: document.getElementById('passport_number').value.trim(),
            place_of_birth: document.getElementById('place_of_birth').value.trim(),
            country: document.getElementById('country').value,
            country_label: countryOption ? (countryOption.text || '') : '',
            city: document.getElementById('city').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            other_phone: document.getElementById('other_phone').value.trim(),
            email: document.getElementById('email').value.trim(),
            the_previous_school: document.getElementById('the_previous_school').value.trim(),
            con_sch: document.getElementById('con_sch').value.trim(),
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
        if (state.registrationId) {
            formData.append('registration_id', state.registrationId);
        }
        Object.keys(data).forEach(function (key) {
            if (key === 'country_label') {
                return;
            }
            formData.append('form_data[' + key + ']', data[key]);
        });
        ['fourth_image', 'passbord', 'personal_image', 'certification', 'mather_page', 'father_page'].forEach(function (field) {
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

        const transportLabel = state.wantsTransport === 1 ? i18n.summary.yes : i18n.summary.no;
        const fullName = ((state.formData.first_name || '') + ' ' + (state.formData.last_name || '')).trim();
        const addressValue = state.formData.country_label ? [state.formData.country_label, state.formData.city].filter(Boolean).join(' - ') : (state.formData.city || i18n.summary.dash);
        const fees = data && data.fees ? data.fees : {};

        document.getElementById('summaryBox').innerHTML =
            '<div class="wizard-summary-section">' +
                '<h4 class="wizard-summary-heading">' + escapeHtml(i18n.summary.studentSummary) + '</h4>' +
                '<div class="wizard-summary-grid">' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.fullName) + '</span><span>' + escapeHtml(displayValue(fullName)) + '</span></div>' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.fatherName) + '</span><span>' + escapeHtml(displayValue(state.formData.father_name)) + '</span></div>' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.motherName) + '</span><span>' + escapeHtml(displayValue(state.formData.mather_name)) + '</span></div>' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.phone) + '</span><span>' + escapeHtml(displayValue(state.formData.phone)) + '</span></div>' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.class) + '</span><span>' + escapeHtml(displayValue(state.formData.class_name)) + '</span></div>' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.address) + '</span><span>' + escapeHtml(displayValue(addressValue)) + '</span></div>' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.idNumber) + '</span><span>' + escapeHtml(displayValue(state.formData.the_ID_number)) + '</span></div>' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.transport) + '</span><span>' + escapeHtml(displayValue(transportLabel)) + '</span></div>' +
                '</div>' +
            '</div>' +
            '<div class="wizard-summary-section">' +
                '<h4 class="wizard-summary-heading">' + escapeHtml(i18n.summary.feesSummary) + '</h4>' +
                '<div class="wizard-summary-grid">' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.registrationFee) + '</span><span>' + escapeHtml(displayValue(fees.registration_fee)) + '</span></div>' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.servicesFee) + '</span><span>' + escapeHtml(displayValue(fees.services_fee)) + '</span></div>' +
                    '<div class="wizard-summary-row"><span>' + escapeHtml(i18n.summary.transportFee) + '</span><span>' + escapeHtml(displayValue(fees.transport_fee)) + '</span></div>' +
                    '<div class="wizard-summary-row total"><span>' + escapeHtml(i18n.summary.total) + '</span><span>' + escapeHtml(displayValue(fees.total_amount)) + '</span></div>' +
                '</div>' +
            '</div>';
    }

    document.getElementById('agreeTerms').addEventListener('change', function () {
        document.getElementById('agreeTermsError').classList.remove('show');
    });

    document.getElementById('btnStep1Next').addEventListener('click', async function () {
        if (!document.getElementById('agreeTerms').checked) {
            document.getElementById('agreeTermsError').classList.add('show');
            return;
        }
        const button = this;
        button.disabled = true;
        try {
            await postUrlEncoded(urls.step1, { accepted_terms: 1 });
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
            const payload = buildStep2Payload(state.formData);
            const response = await postFormData(urls.step2, payload);
            state.registrationId = String(response.registration_id || '');
            document.getElementById('registrationId').value = state.registrationId;
            requiredStep2Files.forEach(function (field) {
                const input = document.getElementById(field);
                if (input && input.files && input.files.length > 0) {
                    state.uploadedFiles[field] = true;
                }
            });
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
    });

    document.getElementById('choiceNo').addEventListener('click', function () {
        state.wantsTransport = 0;
        document.querySelector('#choiceNo input[type="radio"]').checked = true;
        document.querySelector('#choiceYes input[type="radio"]').checked = false;
        document.getElementById('choiceNo').classList.add('is-active');
        document.getElementById('choiceYes').classList.remove('is-active');
        document.getElementById('btnStep3Next').disabled = false;
    });

    document.getElementById('btnStep3Next').addEventListener('click', async function () {
        if (!state.registrationId) {
            showAlert(i18n.errors.completeStudentFirst);
            return;
        }
        const button = this;
        button.disabled = true;
        try {
            await postUrlEncoded(urls.step3, {
                registration_id: state.registrationId,
                wants_transport: state.wantsTransport,
                accepted_transport_terms: 0
            });
            if (state.wantsTransport === 1) {
                setStep(4);
                return;
            }
            const summary = await postUrlEncoded(urls.summary, { registration_id: state.registrationId });
            renderSummary(summary);
            setStep(5);
        } catch (error) {
            showAlert(error.message || i18n.errors.transportSaveFailed);
        } finally {
            button.disabled = false;
        }
    });

    document.getElementById('agreeTransportTerms').addEventListener('change', function (event) {
        document.getElementById('btnStep4Next').disabled = !event.target.checked;
    });

    document.getElementById('btnStep4Next').addEventListener('click', async function () {
        const button = this;
        button.disabled = true;
        try {
            await postUrlEncoded(urls.step3, {
                registration_id: state.registrationId,
                wants_transport: 1,
                accepted_transport_terms: 1
            });
            const summary = await postUrlEncoded(urls.summary, { registration_id: state.registrationId });
            renderSummary(summary);
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
    });

    document.getElementById('btnFinalSubmit').addEventListener('click', async function () {
        if (!state.registrationId) {
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
            payload.append('registration_id', state.registrationId);
            payload.append('payment_method', 'manual');
            payload.append('payment_receipt', receiptInput.files[0]);

            const response = await postFormData(urls.finalSubmit, payload);
            const successTitle = (response && response.message) ? response.message : i18n.success.finalSubmit;
            showSuccessToast(successTitle, i18n.success.finalSubmitHint);
            button.textContent = i18n.buttons.submitted;
            const submitNote = document.querySelector('.wizard-submit-note');
            if (submitNote) {
                submitNote.textContent = i18n.success.finalSubmitHint;
            }
            allowSilentUnload = true;
            window.setTimeout(function () {
                window.location.href = redirectAfterSubmit;
            }, 1700);
        } catch (error) {
            showAlert(error.message || i18n.errors.finalSubmitFailed);
            button.disabled = false;
        }
    });
});
</script>
@endsection


