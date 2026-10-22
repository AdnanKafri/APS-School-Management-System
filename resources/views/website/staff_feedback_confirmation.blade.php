@extends('website.layouts.app')

@section('css')
    @include('website.partials.complaint_tracking_styles')
@endsection

@section('content')
<main class="complaint-track-shell">
    <section class="complaint-track-card" aria-labelledby="confirmation-title">
        <h1 id="confirmation-title">{{ __('staff_feedback.confirmation_title') }}</h1>
        <p class="complaint-track-lead">{{ __('staff_feedback.confirmation_text') }}</p>
        <div class="complaint-track-reference">
            <strong>{{ __('staff_feedback.reference') }}</strong>
            <code id="complaint-reference">{{ $reference }}</code>
        </div>
        <p class="complaint-track-reminder">{{ __('staff_feedback.save_reference') }}</p>
        <button class="btn btn-outline-primary" id="copy-complaint-reference" type="button">{{ __('complaint_tracking.copy') }}</button>
        <p class="complaint-track-feedback" id="copy-complaint-feedback" role="status" aria-live="polite"></p>
        <div class="complaint-track-actions">
            <a class="btn btn-light" href="{{ route('website.staff_feedback.' . app()->getLocale()) }}">{{ __('staff_feedback.back_to_form') }}</a>
        </div>
    </section>
</main>
@include('website.partials.complaint_reference_copy')
@endsection
