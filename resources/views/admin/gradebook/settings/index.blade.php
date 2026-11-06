@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.settings'))
@section('page_subtitle', __('gradebook_ui.settings_help'))
@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.settings')]]])
@endsection
@section('gradebook-content')
<section class="card">
    <div class="card-header"><h3>{{ __('gradebook_ui.choose_class') }}</h3><span class="badge badge-primary">{{ $year->name }}</span></div>
    <div class="card-body">
        <div class="alert alert-info">
            <strong>{{ __('gradebook_ux.entry_control') }}</strong>
            @if($term)<span class="badge badge-light">{{ $year->name }} / {{ $term->term }}</span>@endif
            <p class="mb-0 mt-2">{{ __('gradebook_ux.lock_scope') }}</p>
            @unless($term)<p class="mb-0">{{ __('gradebook.term_missing') }}</p>@endunless
        </div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="table-responsive" tabindex="0" role="region" aria-label="{{ __('gradebook_ui.classes') }}">
            <table class="table table-hover gb-table">
                <thead><tr><th scope="col">#</th><th scope="col">{{ __('gradebook_ui.class') }}</th><th scope="col">{{ __('gradebook_ui.sections') }}</th><th scope="col">{{ __('gradebook_ux.entry_control') }}</th><th scope="col">{{ __('gradebook_ui.actions') }}</th></tr></thead>
                <tbody>
                @forelse($classes as $class)
                    <tr><td>{{ $class->id }}</td><th scope="row">{{ $class->name }}</th><td>{{ $class->room_count ?? optional($class->room)->count() ?? 0 }}</td>
                        <td>
                            @if($term)
                                @php($open = $classStatuses[$class->id] === 'OPEN')
                                <button id="gradebook-status-{{ $class->id }}" type="button" class="btn gb-entry-switch" role="switch" aria-checked="{{ $open ? 'true' : 'false' }}"
                                        aria-label="{{ __('gradebook_ux.entry_control') }} - {{ $class->name }}"
                                        data-accepted="{{ $classStatuses[$class->id] }}" data-feedback="gradebook-feedback-{{ $class->id }}"
                                        onclick="toggleGradebookStatus({{ $class->id }}, {{ $term->id }}, this)">
                                    <i class="fas fa-power-off" aria-hidden="true"></i><span data-status-label>{{ __('gradebook_ux.'.($open ? 'open' : 'locked')) }}</span>
                                </button>
                                <div id="gradebook-feedback-{{ $class->id }}" class="small" role="status" aria-live="polite"></div>
                            @else &mdash; @endif
                        </td>
                        <td><a href="{{ route('admin.gradebook.settings.rooms', $class->id) }}" class="btn btn-outline-primary">{{ __('gradebook_ui.sections') }}</a></td></tr>
                @empty
                    <tr><td colspan="5">{{ __('gradebook_ui.empty') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $classes->links() }}
    </div>
</section>
@endsection
@section('js')
@include('admin.gradebook.partials.status_script')
@endsection
