@extends('website.layouts.app')

@section('css')
    @include('website.partials.complaint_tracking_styles')
@endsection

@section('content')
<main class="complaint-track-shell">
    <section class="complaint-track-card" aria-labelledby="tracking-title">
        <h1 id="tracking-title">{{ __('complaint_tracking.track_title') }}</h1>
        <p class="complaint-track-lead">{{ __('complaint_tracking.track_text') }}</p>
        @if(!empty($rateLimited))
            <div class="alert alert-warning" role="alert">{{ __('complaint_tracking.rate_limited') }}</div>
        @elseif($lookupFailed)
            <div class="alert alert-danger" role="alert">{{ __('complaint_tracking.invalid') }}</div>
        @endif
        <form method="POST" action="{{ route('website.complaints.lookup') }}" autocomplete="off">
            @csrf
            <div class="complaint-track-field">
                <label for="tracking-reference">{{ __('complaint_tracking.reference') }}</label>
                <input id="tracking-reference" name="reference" type="text" required maxlength="42" spellcheck="false" autocomplete="off" dir="ltr">
            </div>
            <div class="complaint-track-field">
                <label for="tracking-student-identifier">{{ __('complaint_tracking.student_identifier') }}</label>
                <input id="tracking-student-identifier" name="student_identifier" type="text" required maxlength="{{ \App\Services\ComplaintStudentIdentifier::MAX_LENGTH }}" pattern="{{ \App\Services\ComplaintStudentIdentifier::HTML_PATTERN }}" spellcheck="false" autocomplete="off" dir="ltr" aria-describedby="tracking-student-identifier-hint">
                <small id="tracking-student-identifier-hint">{{ __('complaints.form.student_identifier_hint') }}</small>
            </div>
            <div class="complaint-track-actions">
                <button class="btn btn-primary" type="submit">{{ __('complaint_tracking.lookup') }}</button>
                <a class="btn btn-light" href="{{ route('website.complaints') }}">{{ __('complaint_tracking.back_to_form') }}</a>
            </div>
        </form>
        @if($complaint)
            <section class="complaint-track-result" aria-label="{{ __('complaint_tracking.current_status') }}">
                <dl>
                    <dt>{{ __('complaint_tracking.reference') }}</dt><dd dir="ltr">{{ $reference }}</dd>
                    <dt>{{ __('complaint_tracking.submitted_at') }}</dt><dd>{{ $complaint->created_at->format('Y/m/d') }}</dd>
                    <dt>{{ __('complaint_tracking.current_status') }}</dt><dd>{{ $publicStatus }}</dd>
                </dl>
            </section>
            <p class="complaint-track-private">{{ __('complaint_tracking.privacy_note') }}</p>
        @endif
    </section>
</main>
@endsection
