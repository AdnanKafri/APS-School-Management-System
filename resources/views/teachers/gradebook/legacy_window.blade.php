@php
    $legacyWindow = app(\App\Services\AssessmentEntryWindow::class);
    $legacyState = $legacyWindow->state($originalAssessment);
    $legacyEnd = $legacyWindow->date($originalAssessment->end_date);
    $remaining = $legacyEnd ? max(0, now()->diffInMilliseconds($legacyEnd, false) + 1) : 0;
@endphp
<div class="alert {{ $legacyState['allowed'] ? 'alert-info' : 'alert-warning' }} mx-3" role="status" dir="rtl"
    id="traditional-entry-window" data-allowed="{{ $legacyState['allowed'] ? '1' : '0' }}" data-remaining="{{ $remaining }}"
    data-ended="{{ __('assessment_entry.ended') }}">{{ __('assessment_entry.'.$legacyState['reason']) }}</div>
<script src="{{ asset('teachers_2/assets/js/assessment-window.js') }}"></script>
