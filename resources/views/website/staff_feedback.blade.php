@extends('website.layouts.app')

@section('css')
<style>
.staff-feedback{max-width:780px;margin:30px auto 48px;padding:0 16px;min-width:0}
.staff-feedback__card{background:#fff;border:1px solid #e8e4f2;border-radius:20px;padding:clamp(18px,3vw,30px);box-shadow:0 10px 26px rgba(36,30,62,.05)}
.staff-feedback h1{font-size:clamp(24px,4vw,30px);color:#2f2b3a;margin:0 0 8px;line-height:1.4}
.staff-feedback p{line-height:1.8;color:#645d73}
.staff-feedback__privacy{border-inline-start:3px solid #5b4b8a;padding:10px 14px;background:#f7f5fb;border-radius:8px;margin:16px 0}
.staff-feedback__fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px;margin-top:22px}
.staff-feedback__field{min-width:0}.staff-feedback__field--wide{grid-column:1/-1}
.staff-feedback label{display:block;font-weight:700;margin-bottom:6px;color:#433b54}
.staff-feedback input,.staff-feedback textarea{display:block;width:100%;border:1px solid #d8d2e6;background:#fff;border-radius:12px;padding:11px 14px;min-height:48px;color:#2f2b3a;font:inherit}
.staff-feedback textarea{min-height:150px;resize:vertical}
.staff-feedback input:focus,.staff-feedback textarea:focus{outline:3px solid #bfb0e1;outline-offset:1px}
.staff-feedback__hint{display:block;color:#726d80;font-size:13px;margin-top:6px}
.staff-feedback__error{display:block;color:#9b3030;margin-top:5px}
.staff-feedback__actions{display:flex;justify-content:flex-end;margin-top:22px}
.staff-feedback__submit{background:#5b4b8a;border:0;border-radius:10px;color:#fff;padding:10px 22px;min-height:46px;font:inherit;font-weight:700;cursor:pointer}
.staff-feedback__submit:disabled{opacity:.65;cursor:wait}
.staff-feedback__trap{position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden}
@media(max-width:600px){.staff-feedback__fields{grid-template-columns:1fr}.staff-feedback__actions .staff-feedback__submit{width:100%}}
</style>
@endsection

@section('content')
<main class="staff-feedback">
    <div class="staff-feedback__card">
        <h1>{{ __('staff_feedback.title') }}</h1>
        <p>{{ __('staff_feedback.intro') }}</p>
        <p class="staff-feedback__privacy">{{ __('staff_feedback.privacy') }}</p>

        @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('website.staff_feedback.store.' . app()->getLocale()) }}" id="staff-feedback-form">
            @csrf
            <div class="staff-feedback__trap" aria-hidden="true">
                <label for="website_url">Website</label>
                <input id="website_url" name="website_url" tabindex="-1" autocomplete="off">
            </div>
            <div class="staff-feedback__fields">
                <div class="staff-feedback__field">
                    <label for="staff_name">{{ __('staff_feedback.name') }}</label>
                    <input id="staff_name" name="staff_name" value="{{ old('staff_name') }}" maxlength="190" required autocomplete="name" aria-invalid="{{ $errors->has('staff_name') ? 'true' : 'false' }}">
                </div>
                <div class="staff-feedback__field">
                    <label for="staff_phone">{{ __('staff_feedback.phone') }}</label>
                    <input id="staff_phone" name="phone" type="tel" inputmode="tel" dir="ltr" value="{{ old('phone') }}" maxlength="50" required autocomplete="tel" aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}">
                </div>
                <div class="staff-feedback__field staff-feedback__field--wide">
                    <label for="staff_message">{{ __('staff_feedback.message') }}</label>
                    <textarea id="staff_message" name="complaint_text" minlength="20" maxlength="5000" required aria-describedby="staff-message-hint" aria-invalid="{{ $errors->has('complaint_text') ? 'true' : 'false' }}">{{ old('complaint_text') }}</textarea>
                    <small id="staff-message-hint" class="staff-feedback__hint">{{ __('staff_feedback.message_hint') }}</small>
                </div>
            </div>
            <div class="staff-feedback__actions"><button type="submit" class="staff-feedback__submit">{{ __('staff_feedback.submit') }}</button></div>
        </form>
    </div>
</main>
<script>
(function () {
    var form = document.getElementById('staff-feedback-form');
    if (!form) return;
    form.addEventListener('submit', function (event) {
        if (form.dataset.submitting) { event.preventDefault(); return; }
        form.dataset.submitting = '1';
        form.querySelector('[type="submit"]').disabled = true;
    });
    window.addEventListener('pageshow', function () {
        delete form.dataset.submitting;
        form.querySelector('[type="submit"]').disabled = false;
    });
}());
</script>
@endsection
