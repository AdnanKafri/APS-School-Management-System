@extends('website.layouts.app')

@section('css')
    @include('website.partials.complaint_tracking_styles')
@endsection

@section('content')
<main class="complaint-track-shell">
    <section class="complaint-track-card" aria-labelledby="confirmation-title">
        <h1 id="confirmation-title">{{ __('complaint_tracking.confirmation_title') }}</h1>
        <p class="complaint-track-lead">{{ __('complaint_tracking.confirmation_text') }}</p>
        <div class="complaint-track-reference">
            <strong>{{ __('complaint_tracking.reference') }}</strong>
            <code id="complaint-reference">{{ $reference }}</code>
        </div>
        <p class="complaint-track-reminder">{{ __('complaint_tracking.save_reminder') }}</p>
        <button class="btn btn-outline-primary" id="copy-complaint-reference" type="button">{{ __('complaint_tracking.copy') }}</button>
        <p class="complaint-track-feedback" id="copy-complaint-feedback" role="status" aria-live="polite"></p>
        <div class="complaint-track-actions">
            <a class="btn btn-primary" href="{{ route('website.complaints.track') }}">{{ __('complaint_tracking.track_action') }}</a>
            <a class="btn btn-light" href="{{ route('website.complaints') }}">{{ __('complaint_tracking.back_to_form') }}</a>
        </div>
    </section>
</main>
@include('website.partials.complaint_reference_copy')
@endsection
