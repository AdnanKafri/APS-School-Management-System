@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.choose_subject'))
@section('page_subtitle', __('gradebook_ui.shared_distribution'))
@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.settings'), 'url'=>route('admin.gradebook.settings')], ['label'=>__('gradebook_ui.sections'), 'url'=>route('admin.gradebook.settings.rooms', $room->class_id)], ['label'=>$room->name]]])
@endsection
@section('gradebook-content')
<section class="card">
    <div class="card-header"><h3>{{ __('gradebook_ui.subjects') }}: {{ $room->name }}</h3></div>
    <div class="table-responsive" tabindex="0" role="region" aria-label="{{ __('gradebook_ui.subjects') }}">
        <table class="table table-hover gb-table">
            <thead><tr><th scope="col">{{ __('gradebook_ui.subject') }}</th><th scope="col">{{ __('gradebook_ui.teacher') }}</th><th scope="col">{{ __('gradebook_ui.configuration') }}</th><th scope="col">{{ __('gradebook_ui.actions') }}</th></tr></thead>
            <tbody>
            @forelse($subjects as $subject)
                <tr>
                    <th scope="row">{{ $subject->name }}</th>
                    <td>{{ $subject->teachers->unique('id')->map(function ($teacher) { return trim($teacher->first_name.' '.$teacher->last_name); })->implode('، ') ?: '-' }}</td>
                    <td>@if(in_array($subject->id, $configuredSubjects))<span class="badge badge-success p-2">{{ __('gradebook.custom_configuration') }}</span>@else<span class="badge badge-light p-2">{{ __('gradebook_ui.default_configuration') }}</span>@endif</td>
                    <td><a href="{{ route('admin.gradebook.settings.edit', $subject->id) }}" class="btn btn-outline-primary"><i class="fas fa-sliders-h" aria-hidden="true"></i> {{ __('gradebook_ui.settings') }}</a></td>
                </tr>
            @empty
                <tr><td colspan="4">{{ __('gradebook_ui.empty') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
