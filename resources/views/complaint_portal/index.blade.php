@extends('complaint_portal.layout')
@section('content')
<section class="cp-card"><h1>{{ __('complaint_portal.title') }}</h1>
<form method="GET" class="cp-filters">
    <label>{{ __('staff_feedback.source') }}<select name="source"><option value="all">{{ __('complaint_portal.all') }}</option>@foreach(['parent','staff'] as $source)<option value="{{ $source }}" {{ $sourceFilter === $source ? 'selected' : '' }}>{{ __('staff_feedback.sources.'.$source) }}</option>@endforeach</select></label>
    <label data-parent-type {{ $sourceFilter === 'staff' ? 'hidden' : '' }}>{{ __('staff_feedback.parent_category') }}<select name="type" {{ $sourceFilter === 'staff' ? 'disabled' : '' }}><option value="all">{{ __('staff_feedback.all_kinds') }}</option>@foreach(['academic','transport'] as $type)<option value="{{ $type }}" {{ $typeFilter === $type ? 'selected' : '' }}>{{ __('complaints.types.'.$type) }}</option>@endforeach</select></label>
    <label>{{ __('complaints.admin.status') }}<select name="status"><option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>{{ __('complaint_portal.all') }}</option>@foreach(['new','viewed','in_progress','resolved','archived'] as $status)<option value="{{ $status }}" {{ $statusFilter === $status ? 'selected' : '' }}>{{ $status === 'new' ? __('complaint_portal.new_filter') : __('complaints.status.'.$status) }}</option>@endforeach</select></label>
    <button class="cp-button">{{ __('complaint_portal.filter') }}</button>
    @if($sourceFilter !== 'all' || $typeFilter !== 'all' || $statusFilter !== 'new')<a class="cp-button cp-secondary" href="{{ route('complaint-portal.index') }}">{{ __('complaint_portal.reset') }}</a>@endif
</form></section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var source = document.querySelector('.cp-filters select[name="source"]');
    var parentType = document.querySelector('[data-parent-type]');
    if (!source || !parentType) return;
    source.addEventListener('change', function () {
        var staff = source.value === 'staff';
        parentType.hidden = staff;
        parentType.querySelector('select').disabled = staff;
        if (staff) parentType.querySelector('select').value = 'all';
    });
});
</script>
<section class="cp-list">
@forelse($complaints as $complaint)
<article class="cp-card cp-record"><div class="cp-row"><span class="cp-badge cp-status-{{ $complaint->status }}">{{ $complaint->statusLabel() }}</span><span class="cp-badge cp-source-{{ $complaint->source === 'staff' ? 'staff' : 'parent' }}">{{ $complaint->sourceLabel() }}</span><time>{{ $complaint->created_at->copy()->timezone(config('app.timezone'))->locale('ar')->translatedFormat('j F Y - H:i') }}</time></div>
<h2><a href="{{ route('complaint-portal.show', array_merge(['id' => $complaint->id], request()->only('source', 'type', 'status', 'page'))) }}">{{ $complaint->submitterName() }}</a></h2>
<p>{{ $complaint->typeLabel() }} @if($complaint->source === 'staff')@if($complaint->staff_reference) · {{ __('staff_feedback.reference') }}: <bdi>{{ $complaint->staff_reference }}</bdi>@endif <span class="cp-preview">{{ \Illuminate\Support\Str::limit($complaint->complaint_text, 90) }}</span>@else · {{ $complaint->class_name }} / {{ $complaint->section_name }}@endif</p>
<p>@if($complaint->source === 'staff')<bdi>{{ $complaint->phone }}</bdi>@else {{ __('complaints.fields.student_identifier') }}: <bdi>{{ $complaint->student_identifier ?: __('complaints.admin.unavailable') }}</bdi>@endif</p>
<a class="cp-button cp-secondary" href="{{ route('complaint-portal.show', array_merge(['id' => $complaint->id], request()->only('source', 'type', 'status', 'page'))) }}">{{ __('complaints.buttons.view') }}</a>
</article>
@empty<div class="cp-card">{{ __('complaint_portal.empty') }}</div>@endforelse
</section><nav class="cp-pagination">{{ $complaints->links() }}</nav>
@endsection
