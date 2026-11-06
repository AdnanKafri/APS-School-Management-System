@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.classes'))
@section('page_subtitle', __('gradebook_ui.by_student'))
@section('breadcrumbs')
    @include('admin.gradebook.partials.breadcrumbs', ['items'=>[['label'=>__('gradebook_ui.review'), 'url'=>route('admin.gradebook.view_options')], ['label'=>__('gradebook_ui.by_student')]]])
@endsection
@section('gradebook-content')
    @include('admin.gradebook.partials.classes', ['sectionRoute'=>'admin.gradebook.view_rooms_student'])
@endsection
