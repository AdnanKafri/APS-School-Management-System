@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.gradebook'))
@section('page_subtitle', __('gradebook_ui.overview'))
@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs')
@endsection
@section('gradebook-content')
    @if(session('error'))<div class="alert alert-warning" role="alert">{{ session('error') }}</div>@endif
    <div class="gb-entry-grid">
        <section class="gb-entry">
            <i class="fas fa-table" aria-hidden="true"></i>
            <h2>{{ __('gradebook_ui.review') }}</h2>
            <p>{{ __('gradebook_ui.review_help') }}</p>
            <a class="btn btn-primary" href="{{ route('admin.gradebook.view_options') }}">{{ __('gradebook_ui.open') }}</a>
        </section>
        <section class="gb-entry">
            <i class="fas fa-sliders-h" aria-hidden="true"></i>
            <h2>{{ __('gradebook_ui.settings') }}</h2>
            <p>{{ __('gradebook_ui.settings_help') }}</p>
            <a class="btn btn-outline-primary" href="{{ route('admin.gradebook.settings') }}">{{ __('gradebook_ui.settings') }}</a>
        </section>
    </div>
    <div class="mt-3"><a class="btn btn-secondary" href="{{ route('admin.gradebook.equivalence') }}">{{ __('gradebook.equivalence') }}</a></div>
@endsection
