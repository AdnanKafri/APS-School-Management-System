@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.choose_section'))
@section('page_subtitle', __('gradebook_ui.settings_help'))
@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.settings'), 'url'=>route('admin.gradebook.settings')], ['label'=>__('gradebook_ui.sections')]]])
@endsection
@section('gradebook-content')
<section class="card">
    <div class="card-header"><h3>{{ __('gradebook_ui.choose_section') }}</h3></div>
    <div class="card-body">
        <div class="table-responsive" tabindex="0" role="region" aria-label="{{ __('gradebook_ui.sections') }}">
            <table class="table table-hover gb-table">
                <thead><tr><th scope="col">#</th><th scope="col">{{ __('gradebook_ui.section') }}</th><th scope="col">{{ __('gradebook_ui.student_count') }}</th><th scope="col">{{ __('gradebook_ui.actions') }}</th></tr></thead>
                <tbody>
                @forelse($rooms as $room)
                    <tr><td>{{ $room->id }}</td><th scope="row">{{ $room->name }}</th><td>{{ optional($room->student)->count() ?? 0 }}</td><td><a href="{{ route('admin.gradebook.settings.subjects', $room->id) }}" class="btn btn-outline-primary">{{ __('gradebook_ui.subjects') }}</a></td></tr>
                @empty
                    <tr><td colspan="4">{{ __('gradebook_ui.empty') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $rooms->links() }}
    </div>
</section>
@endsection
