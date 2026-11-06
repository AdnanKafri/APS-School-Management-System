@extends('admin.gradebook.templates.layout')
@section('template-content')
    <div class="card mb-3">
        <div class="card-header bg-white border-bottom gbt-toolbar">
            <h4 class="mb-0 text-primary"><i class="fas fa-sliders-h" aria-hidden="true"></i> {{ $template->name }}</h4>
            <div class="gbt-actions"><a class="btn btn-outline-primary btn-sm" href="{{ route('admin.gradebook.templates.index',['year_id'=>$year->id,'class_id'=>$grade->id]) }}">{{ __('gradebook_templates.choose_subject') }}</a>@include('admin.gradebook.templates.settings-link')</div>
        </div>
        <div class="card-body">@include('admin.gradebook.templates.context')</div>
    </div>
    @include('admin.gradebook.templates.notice')
    <div class="card mb-4"><div class="card-body gbt-editor">
    @if($template->draft_payload !== null)
        <h3 class="h5">{{ __('gradebook_templates.draft') }} <small>{{ __('gradebook_templates.revision') }} {{ $template->draft_revision }}</small></h3>
        <form method="post" action="{{ route('admin.gradebook.templates.save', $template->id) }}" id="gbt-draft-form">@csrf
            <input type="hidden" name="revision" value="{{ $template->draft_revision }}">
            <div class="form-row">
                <div class="form-group col-md-6"><label for="draft-name">{{ __('gradebook_templates.name') }}</label><input class="form-control" id="draft-name" name="name_ar" maxlength="200" required value="{{ $template->draft_payload['name_ar'] }}"></div>
                <div class="form-group col-md-6"><label for="draft-name-en">{{ __('gradebook_templates.name_en') }}</label><input class="form-control" id="draft-name-en" name="name_en" maxlength="200" value="{{ $template->draft_payload['name_en'] }}"></div>
            </div>
            <div id="gbt-components">
                @foreach($template->draft_payload['components'] as $index=>$component)
                    @include('admin.gradebook.templates.component', ['component'=>$component, 'index'=>$index])
                @endforeach
            </div>
            <div class="gbt-actions mb-3"><button type="button" class="btn btn-outline-secondary" id="gbt-add">{{ __('gradebook_templates.add') }}</button><button class="btn btn-primary">{{ __('gradebook_templates.save') }}</button></div>
        </form>
        @if(count($template->draft_payload['components']))<a class="btn btn-outline-primary mb-2" href="{{ route('admin.gradebook.templates.preview', $template->id) }}">{{ __('gradebook_templates.preview') }}</a>@endif
        <p class="text-muted small">{{ __('gradebook_templates.save_before_preview') }}</p>
        <details><summary>{{ __('gradebook_templates.discard') }}</summary>
            <form class="mt-3" method="post" action="{{ route('admin.gradebook.templates.discard', $template->id) }}">@csrf
                <input type="hidden" name="revision" value="{{ $template->draft_revision }}">
                <label for="discard-reason">{{ __('gradebook_templates.reason') }}</label><textarea class="form-control mb-3" id="discard-reason" name="reason" minlength="3" maxlength="1000" required></textarea>
                <button class="btn btn-outline-danger">{{ __('gradebook_templates.discard') }}</button>
            </form>
        </details>
    @else
        <p>{{ __('gradebook_templates.no_draft') }}</p>
        <form method="post" action="{{ route('admin.gradebook.templates.start', $template->id) }}">@csrf<input type="hidden" name="revision" value="{{ $template->draft_revision }}"><button class="btn btn-outline-primary">{{ __('gradebook_templates.new_draft') }}</button></form>
    @endif
    </div></div>
    <h3 class="h5">{{ __('gradebook_templates.version') }}</h3>
    @forelse($versions as $version)
        <div class="card mb-3"><div class="card-body">
            <a href="{{ route('admin.gradebook.templates.version', [$template->id, $version->id]) }}">{{ __('gradebook_templates.version') }} {{ $version->number }}</a> · {{ $version->published_at }}
            @if($template->draft_payload === null)<form class="mt-3" method="post" action="{{ route('admin.gradebook.templates.start', $template->id) }}">@csrf<input type="hidden" name="revision" value="{{ $template->draft_revision }}"><input type="hidden" name="version_id" value="{{ $version->id }}"><button class="btn btn-sm btn-outline-primary">{{ __('gradebook_templates.from_version') }}</button></form>@endif
        </div></div>
    @empty<p>{{ __('gradebook_templates.empty') }}</p>@endforelse
    @if($versions->isNotEmpty())
    <div class="card mb-4"><div class="card-body gbt-toolbar">
        <span>{{ __('gradebook_templates.duplicate') }} / {{ __('gradebook_templates.version') }} {{ $versions->first()->number }}</span>
        <a class="btn btn-outline-secondary" href="{{ route('admin.gradebook.templates.index',['year_id'=>$year->id,'source_version_id'=>$versions->first()->id]) }}">{{ __('gradebook_templates.choose_destination') }}</a>
    </div></div>
    @endif
    <h3 class="h5">{{ __('gradebook_templates.history') }}</h3>
    <div class="table-responsive"><table class="table table-bordered"><thead><tr><th>{{ __('gradebook_templates.history') }}</th><th>{{ __('gradebook_templates.actor') }}</th><th>{{ __('gradebook_templates.date') }}</th></tr></thead>
        <tbody>@foreach($events as $event)<tr><td>{{ __('gradebook_templates.'.$event->action) }}@if(isset($event->metadata['reason']))<p class="mb-0">{{ $event->metadata['reason'] }}</p>@endif</td><td>#{{ $event->actor_id }}</td><td>{{ $event->created_at }}</td></tr>@endforeach</tbody>
    </table></div>{{ $events->links() }}
<template id="gbt-component-template">@include('admin.gradebook.templates.component', ['component'=>['id'=>'', 'name_ar'=>'', 'name_en'=>'', 'maximum'=>''], 'index'=>0])</template>
@endsection
@section('js')
<script src="{{ asset('assets/admin/js/gradebook-template-editor.js') }}"></script>
@endsection
