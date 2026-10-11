@extends('complaint_portal.layout')
@section('content')
<a class="cp-button cp-secondary" href="{{ route('complaint-portal.index', request()->only('source', 'type', 'status', 'page')) }}">{{ __('complaints.buttons.back') }}</a>
<section class="cp-card"><div class="cp-row"><h1>{{ $complaint->typeLabel() }} #{{ $complaint->id }}</h1><span class="cp-badge cp-status-{{ $complaint->status }}">{{ $complaint->statusLabel() }}</span><span class="cp-badge cp-source-{{ $complaint->source === 'staff' ? 'staff' : 'parent' }}">{{ $complaint->sourceLabel() }}</span></div>
<dl class="cp-context">
@if($complaint->source === 'staff')
    <div><dt>{{ __('staff_feedback.name') }}</dt><dd>{{ $complaint->staff_name }}</dd></div>
    <div><dt>{{ __('staff_feedback.phone') }}</dt><dd><bdi>{{ $complaint->phone }}</bdi></dd></div>
    <div><dt>{{ __('staff_feedback.category') }}</dt><dd>{{ $complaint->typeLabel() }}</dd></div>
@else
@foreach(['student_name','student_identifier','applicant_name','phone','class_name','section_name'] as $field)
    <div><dt>{{ __('complaints.fields.'.$field) }}</dt><dd><bdi>{{ $complaint->$field ?: __('complaints.admin.unavailable') }}</bdi></dd></div>
@endforeach
@if($complaint->type === 'transport')<div><dt>{{ __('complaints.fields.bus_number') }}</dt><dd>{{ $complaint->bus_number }}</dd></div>@endif
@endif
<div><dt>{{ __('complaints.admin.handled_by') }}</dt><dd>{{ optional($complaint->handledBy)->name ?: __('complaints.admin.unavailable') }}</dd></div>
</dl>
<dl class="cp-context">
@foreach(['created_at','viewed_at','resolved_at','archived_at'] as $field)
<div><dt>{{ __('complaints.admin.'.$field) }}</dt><dd><bdi>{{ $complaint->$field ? $complaint->$field->copy()->timezone(config('app.timezone'))->locale('ar')->translatedFormat('j F Y - H:i') : __('complaints.admin.unavailable') }}</bdi></dd></div>
@endforeach
</dl>
<h2>{{ $complaint->source === 'staff' ? __('staff_feedback.message') : __('complaints.fields.complaint_text') }}</h2><div class="cp-text">{{ $complaint->complaint_text }}</div>
<div class="cp-actions">
@if(\App\Services\ComplaintAccess::allows(auth()->user(), 'manage_complaints'))
@foreach(\App\Complaint::allowedTransitions()[$complaint->status] ?? [] as $status)
<form method="POST" action="{{ route('complaint-portal.status', array_merge(['id' => $complaint->id], request()->only('source', 'type', 'status', 'page'))) }}">@csrf<input type="hidden" name="status" value="{{ $status }}"><button class="cp-button">{{ __('complaints.status.'.$status) }}</button></form>
@endforeach
@endif
@if($complaint->status !== 'archived' && \App\Services\ComplaintAccess::allows(auth()->user(), 'archive_complaints'))
<button type="button" class="cp-button cp-secondary" data-cp-open="archive-confirm">{{ __('complaints.buttons.archive') }}</button>
@endif
</div></section>
<section class="cp-card"><h2>{{ __('complaint_portal.audit') }}</h2>
@forelse($audits as $audit)<div class="cp-audit"><strong>{{ $audit->actor_name ?: __('complaints.admin.unavailable') }}</strong><span>{{ __('complaints.status.'.$audit->previous_status) }} ← {{ __('complaints.status.'.$audit->new_status) }}</span><time>{{ \Carbon\Carbon::parse($audit->occurred_at, config('app.timezone'))->locale('ar')->translatedFormat('j F Y - H:i') }}</time></div>@empty<p class="cp-empty">{{ __('complaint_portal.no_audit') }}</p>@endforelse
</section>
<div class="cp-modal" id="archive-confirm" hidden role="dialog" aria-modal="true" aria-labelledby="archive-title"><div class="cp-modal-panel"><h2 id="archive-title">{{ __('complaints.buttons.archive') }}</h2><p>{{ __('complaint_portal.archive_question') }}</p><div class="cp-actions"><form method="POST" action="{{ route('complaint-portal.archive', array_merge(['id' => $complaint->id], request()->only('source', 'type', 'status', 'page'))) }}">@csrf<button class="cp-button">{{ __('complaints.buttons.archive') }}</button></form><button type="button" class="cp-button cp-secondary" data-cp-close>{{ __('complaint_portal.cancel') }}</button></div></div></div>
@endsection
