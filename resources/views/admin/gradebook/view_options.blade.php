@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.review'))
@section('page_subtitle', __('gradebook_ui.review_help'))
@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.review')]]])
@endsection
@section('gradebook-content')
    <div class="gb-entry-grid">
        <section class="gb-entry">
            <i class="fas fa-book-open" aria-hidden="true"></i>
            <h2>{{ __('gradebook_ui.by_subject') }}</h2>
            <p>{{ __('gradebook_ui.subject_help') }}</p>
            <a class="btn btn-primary" href="{{ route('admin.gradebook.view_classes_subject') }}">{{ __('gradebook_ui.choose_subject') }}</a>
        </section>
        <section class="gb-entry">
            <i class="fas fa-user-graduate" aria-hidden="true"></i>
            <h2>{{ __('gradebook_ui.by_student') }}</h2>
            <p>{{ __('gradebook_ui.student_help') }}</p>
            <a class="btn btn-outline-primary" href="{{ route('admin.gradebook.view_classes_student') }}">{{ __('gradebook_ui.choose_student') }}</a>
        </section>
    </div>
@endsection
