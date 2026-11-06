@extends('admin.gradebook.templates.layout')
@section('template-content')
    <div class="card mb-3"><div class="card-header bg-white border-bottom gbt-toolbar">
        <h4 class="mb-0 text-primary">{{ __('gradebook_templates.version') }} {{ $version->number }}</h4>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.gradebook.templates.show', $template->id) }}">{{ __('gradebook_templates.open') }}</a>
    </div></div>
    @include('admin.gradebook.templates.notice')
    <p class="text-muted">{{ __('gradebook_templates.immutable') }} · {{ $version->published_at }} · {{ __('gradebook_templates.actor') }} #{{ $version->published_by }}</p>
    <div class="card"><div class="card-body">@include('admin.gradebook.templates.definition', ['payload'=>$version->payload])</div></div>
@endsection
