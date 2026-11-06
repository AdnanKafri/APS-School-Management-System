<section class="traditional-assessment-context" dir="rtl" aria-label="{{ __('assessment_entry.context_title') }}">
    <h4>{{ $originalAssessment->name }}</h4>
    <dl>
        <div><dt>{{ __('assessment_entry.class') }}</dt><dd>{{ $room->classes->name }}</dd></div>
        <div><dt>{{ __('assessment_entry.section') }}</dt><dd>{{ $room->name }}</dd></div>
        <div><dt>{{ __('assessment_entry.subject') }}</dt><dd>{{ $lesson->name }}</dd></div>
        <div><dt>{{ __('assessment_entry.maximum') }}</dt><dd>{{ $originalAssessment->mark }}</dd></div>
        <div><dt>{{ __('gradebook_occurrences.start') }}</dt><dd><bdi dir="ltr">{{ $originalAssessment->start_date }}</bdi></dd></div>
        <div><dt>{{ __('gradebook_occurrences.end') }}</dt><dd><bdi dir="ltr">{{ $originalAssessment->end_date }}</bdi></dd></div>
    </dl>
</section>
<style>
    .traditional-assessment-context { padding: 1rem; margin-bottom: 1rem; border: 1px solid #dce3eb; border-radius: .75rem; background: #f8fafc; text-align: right; }
    .traditional-assessment-context h4 { margin: 0 0 .8rem; color: #152c4f; line-height: 1.7; overflow-wrap: anywhere; }
    .traditional-assessment-context dl { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: .75rem 1rem; margin: 0; }
    .traditional-assessment-context dl > div { min-width: 0; }
    .traditional-assessment-context dt { font-size: .85rem; font-weight: 400; color: #526174; line-height: 1.7; }
    .traditional-assessment-context dd { margin: .2rem 0 0; font-weight: 600; line-height: 1.7; overflow-wrap: anywhere; }
    @media(max-width: 767px) { .traditional-assessment-context dl { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media(max-width: 359px) { .traditional-assessment-context dl { grid-template-columns: minmax(0, 1fr); } }
</style>
