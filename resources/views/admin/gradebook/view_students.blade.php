@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.choose_student'))
@section('page_subtitle', __('gradebook_ui.by_student'))
@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.review'), 'url'=>route('admin.gradebook.view_options')], ['label'=>__('gradebook_ui.classes'), 'url'=>route('admin.gradebook.view_classes_student')], ['label'=>__('gradebook_ui.sections'), 'url'=>route('admin.gradebook.view_rooms_student', $room->class_id)], ['label'=>$room->name]]])
@endsection
@section('gradebook-content')
<section class="card">
    <div class="card-header"><h3>{{ __('gradebook_ui.students') }}: {{ $room->name }}</h3><span class="text-muted">{{ $room->classes->name }}</span></div>
    <div class="table-responsive" tabindex="0" role="region" aria-label="{{ __('gradebook_ui.students') }}">
        <table class="table table-hover gb-table">
            <thead><tr><th scope="col">{{ __('gradebook_ui.student') }}</th><th scope="col">{{ __('gradebook_ui.section') }}</th><th scope="col">{{ __('gradebook_ui.class') }}</th><th scope="col">{{ __('gradebook_ui.actions') }}</th></tr></thead>
            <tbody>
            @forelse($students as $item)
                <tr><th scope="row">{{ $item->first_name }} {{ $item->last_name }}</th><td>{{ $room->name }}</td><td>{{ $room->classes->name }}</td><td><a href="{{ route('admin.gradebook.view_student_card', ['student_id'=>$item->id]) }}" class="btn btn-outline-primary">{{ __('gradebook_ui.open') }}</a></td></tr>
            @empty
                <tr><td colspan="4">{{ __('gradebook_ui.empty') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
