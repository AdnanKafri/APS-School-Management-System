@extends('complaint_portal.layout')
@section('content')
<section class="cp-card"><h1>{{ __('complaint_portal.title') }}</h1>
<form method="GET" class="cp-filters">
    <label>{{ __('complaints.fields.type') }}<select name="type"><option value="all">{{ __('complaint_portal.all') }}</option>@foreach(['academic','transport'] as $type)<option value="{{ $type }}" {{ $typeFilter === $type ? 'selected' : '' }}>{{ __('complaints.types.'.$type) }}</option>@endforeach</select></label>
    <label>{{ __('complaints.admin.status') }}<select name="status"><option value="all">{{ __('complaint_portal.all') }}</option>@foreach(['new','viewed','in_progress','resolved','archived'] as $status)<option value="{{ $status }}" {{ $statusFilter === $status ? 'selected' : '' }}>{{ __('complaints.status.'.$status) }}</option>@endforeach</select></label>
    <button class="cp-button">{{ __('complaint_portal.filter') }}</button>
    @if($typeFilter !== 'all' || $statusFilter !== 'all')<a class="cp-button cp-secondary" href="{{ route('complaint-portal.index') }}">{{ __('complaint_portal.reset') }}</a>@endif
</form></section>
<section class="cp-list">
@forelse($complaints as $complaint)
<article class="cp-card cp-record"><div class="cp-row"><span class="cp-badge cp-status-{{ $complaint->status }}">{{ $complaint->statusLabel() }}</span><time>{{ $complaint->created_at->copy()->timezone(config('app.timezone'))->locale('ar')->translatedFormat('j F Y - H:i') }}</time></div>
<h2><a href="{{ route('complaint-portal.show', $complaint->id) }}">{{ $complaint->student_name }}</a></h2>
<p>{{ $complaint->typeLabel() }} · {{ $complaint->class_name }} / {{ $complaint->section_name }}</p>
<p>{{ __('complaints.fields.student_identifier') }}: <bdi>{{ $complaint->student_identifier ?: __('complaints.admin.unavailable') }}</bdi></p>
<a class="cp-button cp-secondary" href="{{ route('complaint-portal.show', $complaint->id) }}">{{ __('complaints.buttons.view') }}</a>
</article>
@empty<div class="cp-card">{{ __('complaint_portal.empty') }}</div>@endforelse
</section><nav class="cp-pagination">{{ $complaints->links() }}</nav>
@endsection
