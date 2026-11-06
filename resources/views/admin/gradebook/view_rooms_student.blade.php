@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.sections'))
@section('page_subtitle', __('gradebook_ui.by_student'))
@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.review'), 'url'=>route('admin.gradebook.view_options')], ['label'=>__('gradebook_ui.classes'), 'url'=>route('admin.gradebook.view_classes_student')], ['label'=>__('gradebook_ui.sections')]]])
@endsection
@section('gradebook-content')
    @include('admin.gradebook.partials.rooms', ['destinationRoute'=>'admin.gradebook.view_students', 'destinationLabel'=>__('gradebook_ui.students')])
@endsection
