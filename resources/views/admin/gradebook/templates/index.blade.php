@extends('admin.gradebook.templates.layout')
@section('template-content')
<div class="card">
    <div class="card-header bg-white border-bottom gbt-toolbar">
        <h4 class="mb-0 text-primary"><i class="fas fa-cogs" aria-hidden="true"></i> {{ __('gradebook_templates.title') }}</h4>
        @include('admin.gradebook.templates.settings-link')
    </div>
    <div class="card-body">
    @include('admin.gradebook.templates.notice')
    @if(!$available)<div class="alert alert-warning">{{ __('gradebook_templates.unavailable') }}</div>
    @else
        @if(!$currentYear)<div class="alert alert-warning" role="alert">{{ __('gradebook_templates.year_unresolved') }}</div>@endif
        @if($source)<div class="alert alert-info">{{ __('gradebook_templates.copying') }}: {{ $source->template->name }} / {{ __('gradebook_templates.version') }} {{ $source->number }}</div>@endif
        <form method="get" action="{{ route('admin.gradebook.templates.index') }}" class="gbt-year-form mb-4">
            @if($source)<input type="hidden" name="source_version_id" value="{{ $source->id }}">@endif
            <div class="form-group"><label for="gbt-year">{{ __('gradebook_templates.year') }}</label>
                <select id="gbt-year" class="form-control" name="year_id" required>
                    <option value="">{{ __('gradebook_templates.choose_year') }}</option>
                    @foreach($years as $option)<option value="{{ $option->id }}" {{ $year && (int)$year->id === (int)$option->id ? 'selected' : '' }}>{{ $option->name }}{{ $currentYear && (int)$currentYear->id === (int)$option->id ? ' · '.__('gradebook_templates.current') : '' }}</option>@endforeach
                </select>
            </div>
            <button class="btn btn-outline-primary">{{ __('gradebook_templates.choose_year') }}</button>
        </form>
        @if($year)
        @include('admin.gradebook.templates.context')
        @if($subject)
            <div class="border-top pt-3">
            <h5 class="text-primary">{{ $source ? __('gradebook_templates.duplicate') : __('gradebook_templates.create') }}</h5>
            <form method="post" action="{{ $source ? route('admin.gradebook.templates.duplicate',[$source->template_id,$source->id]) : route('admin.gradebook.templates.store') }}">@csrf
                @include('admin.gradebook.templates.scope')
                <div class="form-group gbt-name-fields"><label for="template-name">{{ __('gradebook_templates.name') }}</label>
                    <input id="template-name" class="form-control" name="name_ar" value="{{ old('name_ar', $source ? $source->payload['definition']['name_ar'] : $subject->name) }}" maxlength="200" required>
                </div>
                <div class="gbt-actions"><button class="btn btn-primary">{{ $source ? __('gradebook_templates.duplicate') : __('gradebook_templates.create') }}</button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.gradebook.templates.index',$context) }}">{{ __('gradebook_templates.choose_subject') }}</a>
                </div>
            </form>
            </div>
        @elseif($grade)
            <div class="gbt-toolbar mb-3"><h5 class="mb-0 text-primary">{{ __('gradebook_templates.choose_subject') }}</h5><a href="{{ route('admin.gradebook.templates.index',array_diff_key($context,['class_id'=>true])) }}">{{ __('gradebook_templates.choose_class') }}</a></div>
            <div class="table-responsive"><table class="table table-bordered table-hover text-center">
                <thead class="bg-light"><tr><th>{{ __('gradebook_templates.subject_only') }}</th><th>{{ __('gradebook_templates.template_state') }}</th><th>{{ __('gradebook_templates.actions') }}</th></tr></thead>
                <tbody>@forelse($subjects as $item)
                    @php($existing = $templates->get($item->id))
                    <tr><td class="font-weight-bold">{{ $item->name }}</td><td>@if($existing)<span class="badge badge-success p-2">{{ __('gradebook_templates.available_template') }}</span>@else<span class="text-muted">{{ __('gradebook_templates.no_template') }}</span>@endif</td>
                        <td><a class="btn btn-outline-primary btn-sm" href="{{ $existing ? route('admin.gradebook.templates.show',$existing->id) : route('admin.gradebook.templates.index',array_merge($context,['lesson_id'=>$item->id])) }}">{{ $existing ? __('gradebook_templates.open') : __('gradebook_templates.create') }}</a></td></tr>
                @empty<tr><td colspan="3">{{ __('gradebook_templates.no_subjects') }}</td></tr>@endforelse</tbody>
            </table></div>{{ $subjects->links() }}
        @else
            <h5 class="text-primary">{{ __('gradebook_templates.choose_class') }}</h5>
            <div class="table-responsive"><table class="table table-bordered table-striped text-center">
                <thead class="bg-light"><tr><th>{{ __('gradebook_templates.class') }}</th><th>{{ __('gradebook_templates.subject_count') }}</th><th>{{ __('gradebook_templates.actions') }}</th></tr></thead>
                <tbody>@forelse($classes as $item)<tr><td class="font-weight-bold">{{ $item->name }}</td><td>{{ $item->lessons_count }}</td><td><a class="btn btn-primary btn-sm" href="{{ route('admin.gradebook.templates.index',array_merge($context,['class_id'=>$item->id])) }}">{{ __('gradebook_templates.choose_subject') }}</a></td></tr>
                @empty<tr><td colspan="3">{{ __('gradebook_templates.empty') }}</td></tr>@endforelse</tbody>
            </table></div>{{ $classes->links() }}
        @endif
        @endif
    @endif
    </div>
</div>
@endsection
