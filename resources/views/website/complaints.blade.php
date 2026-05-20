@extends('website.layouts.app')

@section('css')
<style>
    .complaints-page {
        max-width: 1120px;
        margin: 28px auto 40px;
        padding: 0 16px;
        font-family: inherit;
    }

    .complaints-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.3fr) minmax(280px, .82fr);
        gap: 16px;
        align-items: stretch;
        margin-bottom: 16px;
    }

    .complaints-panel {
        border: 1px solid #e8e4f2;
        border-radius: 22px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfafe 100%);
        box-shadow: 0 16px 40px rgba(31, 24, 46, 0.05);
        padding: 22px;
    }

    .complaints-title {
        margin: 0 0 8px;
        font-size: 30px;
        line-height: 1.3;
        font-weight: 800;
        color: #2f2b3a;
        text-align: start;
    }

    .complaints-subtitle {
        margin: 0;
        color: #746f84;
        font-size: 15px;
        line-height: 1.9;
        text-align: start;
    }

    .complaints-help {
        height: 100%;
        display: grid;
        gap: 12px;
        align-content: center;
        background: radial-gradient(circle at top right, rgba(91,75,138,.12), transparent 38%), #fff;
    }

    .complaints-help__tag {
        display: inline-flex;
        width: fit-content;
        border-radius: 999px;
        padding: .35rem .7rem;
        background: #f1edf9;
        color: #5b4b8a;
        font-size: 12px;
        font-weight: 800;
    }

    .complaints-help__title {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #2f2b3a;
    }

    .complaints-help__text {
        margin: 0;
        color: #706b80;
        font-size: 14px;
        line-height: 1.8;
    }

    .complaints-form {
        display: grid;
        gap: 16px;
    }

    .complaints-card {
        border: 1px solid #ebe7f5;
        border-radius: 20px;
        background: #fff;
        padding: 18px;
        box-shadow: 0 10px 26px rgba(36, 30, 62, 0.05);
    }

    .complaints-card__head {
        margin-bottom: 14px;
    }

    .complaints-card__head h3 {
        margin: 0 0 4px;
        font-size: 18px;
        font-weight: 800;
        color: #2f2b3a;
    }

    .complaints-card__head p {
        margin: 0;
        color: #746f84;
        font-size: 13px;
        line-height: 1.8;
    }

    .complaints-type-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .complaints-type-card {
        position: relative;
        border: 1px solid #e6e2ef;
        border-radius: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfbff 100%);
        padding: 16px 16px 15px;
        cursor: pointer;
        display: grid;
        gap: 8px;
        transition: all .2s ease;
        min-width: 0;
    }

    .complaints-type-card:hover,
    .complaints-type-card.is-active {
        border-color: #5b4b8a;
        box-shadow: 0 12px 28px rgba(91, 75, 138, 0.12);
        transform: translateY(-1px);
    }

    .complaints-type-card input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .complaints-type-card__meta {
        color: #8c86a0;
        font-size: 12px;
        font-weight: 700;
    }

    .complaints-type-card__title {
        color: #2f2b3a;
        font-size: 17px;
        font-weight: 800;
        line-height: 1.5;
    }

    .complaints-type-card__desc {
        color: #746f84;
        font-size: 13px;
        line-height: 1.7;
    }

    .complaints-grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 14px;
    }

    .complaints-field {
        grid-column: span 6;
        min-width: 0;
    }

    .complaints-field.col-12 {
        grid-column: span 12;
    }

    .complaints-field label {
        display: block;
        margin-bottom: 7px;
        color: #4d4762;
        font-size: 14px;
        font-weight: 700;
        text-align: start;
    }

    .complaints-field input,
    .complaints-field select,
    .complaints-field textarea {
        width: 100%;
        min-height: 48px;
        border: 1px solid #d8d2e6;
        border-radius: 12px;
        background: #fff;
        color: #2f2b3a;
        padding: 12px 14px;
        font-family: inherit;
        transition: border-color .2s ease, box-shadow .2s ease;
        box-sizing: border-box;
        text-align: start;
    }

    .complaints-field textarea {
        min-height: 160px;
        resize: vertical;
        line-height: 1.9;
    }

    .complaints-field input:focus,
    .complaints-field select:focus,
    .complaints-field textarea:focus {
        outline: none;
        border-color: #5b4b8a;
        box-shadow: 0 0 0 4px rgba(91, 75, 138, 0.12);
    }

    .complaints-field.is-hidden {
        display: none;
    }

    .complaints-note {
        margin-top: 8px;
        color: #7d7692;
        font-size: 12px;
        line-height: 1.7;
    }

    .complaints-alert {
        border-radius: 16px;
        margin-bottom: 14px;
    }

    .complaints-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
        margin-top: 4px;
    }

    @media (max-width: 992px) {
        .complaints-hero {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .complaints-page {
            margin-top: 18px;
        }

        .complaints-panel {
            padding: 18px;
            border-radius: 18px;
        }

        .complaints-title {
            font-size: 24px;
        }

        .complaints-type-grid,
        .complaints-field {
            grid-column: span 12;
        }

        .complaints-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
@php
    $isRtl = app()->getLocale() === 'ar';
    $activeType = old('type', $activeType ?? 'academic');
@endphp
<div class="complaints-page">
    <div class="complaints-hero">
        <div class="complaints-panel">
            <h1 class="complaints-title">{{ __('complaints.title') }}</h1>
            <p class="complaints-subtitle">{{ __('complaints.subtitle') }}</p>
        </div>
        <div class="complaints-panel complaints-help">
            <span class="complaints-help__tag">{{ __('complaints.help_title') }}</span>
            <h2 class="complaints-help__title">{{ __('complaints.help_title') }}</h2>
            <p class="complaints-help__text">{{ __('complaints.help_text') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success complaints-alert">
            <strong>{{ session('success') }}</strong>
            <div>{{ __('complaints.success_hint') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger complaints-alert">
            <strong>{{ $errors->first() }}</strong>
        </div>
    @endif

    <form method="POST" action="{{ route('website.complaints.store') }}" class="complaints-form">
        @csrf

        <div class="complaints-card">
            <div class="complaints-card__head">
                <h3>{{ __('complaints.form.title') }}</h3>
                <p>{{ __('complaints.form.subtitle') }}</p>
            </div>

            <div class="complaints-type-grid">
                <label class="complaints-type-card {{ $activeType === 'academic' ? 'is-active' : '' }}">
                    <input type="radio" name="type" value="academic" {{ $activeType === 'academic' ? 'checked' : '' }}>
                    <span class="complaints-type-card__meta">{{ __('complaints.types.academic') }}</span>
                    <span class="complaints-type-card__title">{{ __('complaints.types.academic') }}</span>
                    <span class="complaints-type-card__desc">{{ $isRtl ? 'ملاحظات دراسية أو سلوكية أو متعلقة بأداء الطالب داخل الصف.' : 'Academic or classroom-related feedback about the student or the learning experience.' }}</span>
                </label>
                <label class="complaints-type-card {{ $activeType === 'transport' ? 'is-active' : '' }}">
                    <input type="radio" name="type" value="transport" {{ $activeType === 'transport' ? 'checked' : '' }}>
                    <span class="complaints-type-card__meta">{{ __('complaints.types.transport') }}</span>
                    <span class="complaints-type-card__title">{{ __('complaints.types.transport') }}</span>
                    <span class="complaints-type-card__desc">{{ $isRtl ? 'ملاحظة أو شكوى تتعلق بالباص أو الالتزام أو السلوك أثناء النقل.' : 'Issues related to school transport, the bus, or the ride experience.' }}</span>
                </label>
            </div>
        </div>

        <div class="complaints-card">
            <div class="complaints-grid">
                <div class="complaints-field">
                    <label for="student_name">{{ __('complaints.fields.student_name') }}</label>
                    <input id="student_name" name="student_name" type="text" value="{{ old('student_name') }}" placeholder="{{ __('complaints.placeholders.student_name') }}">
                </div>
                <div class="complaints-field">
                    <label for="applicant_name">{{ __('complaints.fields.applicant_name') }}</label>
                    <input id="applicant_name" name="applicant_name" type="text" value="{{ old('applicant_name') }}" placeholder="{{ __('complaints.placeholders.applicant_name') }}">
                </div>
                <div class="complaints-field">
                    <label for="phone">{{ __('complaints.fields.phone') }}</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="{{ __('complaints.placeholders.phone') }}" inputmode="tel">
                </div>
                <div class="complaints-field">
                    <label for="class_name">{{ __('complaints.fields.class_name') }}</label>
                    <input id="class_name" name="class_name" type="text" value="{{ old('class_name') }}" placeholder="{{ __('complaints.placeholders.class_name') }}">
                </div>
                <div class="complaints-field">
                    <label for="section_name">{{ __('complaints.fields.section_name') }}</label>
                    <input id="section_name" name="section_name" type="text" value="{{ old('section_name') }}" placeholder="{{ __('complaints.placeholders.section_name') }}">
                </div>
                <div class="complaints-field {{ $activeType === 'transport' ? '' : 'is-hidden' }}" data-transport-field>
                    <label for="bus_number">{{ __('complaints.fields.bus_number') }}</label>
                    <input id="bus_number" name="bus_number" type="text" value="{{ old('bus_number') }}" placeholder="{{ __('complaints.placeholders.bus_number') }}">
                </div>
                <div class="complaints-field col-12">
                    <label for="complaint_text">{{ __('complaints.fields.complaint_text') }}</label>
                    <textarea id="complaint_text" name="complaint_text" placeholder="{{ __('complaints.placeholders.complaint_text') }}">{{ old('complaint_text') }}</textarea>
                </div>
            </div>

            <div class="complaints-note">{{ __('complaints.form.note') }}</div>

            <div class="complaints-actions">
                <button type="reset" class="btn btn-light">{{ __('complaints.buttons.reset') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('complaints.buttons.submit') }}</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeInputs = Array.from(document.querySelectorAll('input[name="type"]'));
    const transportField = document.querySelector('[data-transport-field]');
    const busInput = document.getElementById('bus_number');
    const cards = Array.from(document.querySelectorAll('.complaints-type-card'));

    function syncComplaintTypeUI() {
        const active = (typeInputs.find(function (input) { return input.checked; }) || {}).value || 'academic';
        cards.forEach(function (card) {
            card.classList.toggle('is-active', card.querySelector('input') && card.querySelector('input').value === active);
        });
        if (transportField) {
            transportField.classList.toggle('is-hidden', active !== 'transport');
        }
        if (busInput) {
            busInput.required = active === 'transport';
        }
    }

    typeInputs.forEach(function (input) {
        input.addEventListener('change', syncComplaintTypeUI);
    });

    syncComplaintTypeUI();
});
</script>
@endsection
