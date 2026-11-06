@extends('admin.gradebook.templates.layout')
@section('template-content')
    <div class="card mb-3"><div class="card-header bg-white border-bottom gbt-toolbar">
        <h4 class="mb-0 text-primary">{{ __('gradebook_templates.preview') }}</h4>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.gradebook.templates.show', $template->id) }}">{{ __('gradebook_templates.draft') }}</a>
    </div></div>
    @include('admin.gradebook.templates.notice')
    <div class="alert alert-warning">{{ __('gradebook_templates.structural') }}</div>
    <div class="card mb-4"><div class="card-body">@include('admin.gradebook.templates.definition', ['payload'=>$review['payload']])</div></div>
    <p>{{ __('gradebook_templates.version') }}: {{ $review['previous'] ? $review['previous']->number : '—' }} → {{ $template->last_version + 1 }}</p>
    @foreach($review['changes'] as $kind=>$changes)
        <div class="card mb-3"><div class="card-body"><h3 class="h5">{{ __('gradebook_templates.'.$kind) }} ({{ count($changes) }})</h3>
            @forelse($changes as $change)
                @if(isset($change['before']))
                    <p>{{ $change['before']['name_ar'] }}: {{ __('gradebook_templates.before') }} {{ $change['before']['name_ar'] }}@if($change['before']['name_en']) ({{ $change['before']['name_en'] }})@endif / {{ $change['before']['maximum'] }} / #{{ $change['before']['order'] }}
                        → {{ __('gradebook_templates.after') }} {{ $change['after']['name_ar'] }}@if($change['after']['name_en']) ({{ $change['after']['name_en'] }})@endif / {{ $change['after']['maximum'] }} / #{{ $change['after']['order'] }}</p>
                @else<p>{{ $change['name_ar'] }} / {{ $change['maximum'] }} / #{{ $change['order'] }}</p>@endif
            @empty<p class="text-muted mb-0">—</p>@endforelse
        </div></div>
    @endforeach
    <form class="gbt-publish mb-4" method="post" action="{{ route('admin.gradebook.templates.publish', $template->id) }}">@csrf
        <input type="hidden" name="revision" value="{{ $review['revision'] }}"><input type="hidden" name="preview_token" value="{{ $review['preview_token'] }}">
        <label class="gbt-confirm"><input type="checkbox" name="confirmed" value="1" required> <span>{{ __('gradebook_templates.confirm') }}</span></label>
        <button class="btn btn-primary mt-2">{{ __('gradebook_templates.publish') }}</button>
    </form>
@endsection
