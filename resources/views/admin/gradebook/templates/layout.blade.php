@extends('admin.gradebook.layout')
@section('page_title', __('gradebook_ui.template_review'))
@section('page_subtitle', __('gradebook_ui.template_review_help'))
@section('gradebook-style')
<link rel="stylesheet" href="{{ asset('assets/admin/css/gradebook-templates.css') }}">
@endsection
@section('breadcrumbs')
<nav class="gb-breadcrumbs" aria-label="{{ __('gradebook_templates.navigation') }}">
    <a href="{{ route('dashboard.index') }}">{{ __('gradebook_templates.home') }}</a><span aria-hidden="true">/</span>
    <a href="{{ route('admin.gradebook.index') }}">{{ __('gradebook_templates.gradebook') }}</a><span aria-hidden="true">/</span>
    <a href="{{ route('admin.gradebook.settings') }}">{{ __('gradebook_templates.settings') }}</a><span aria-hidden="true">/</span>
    <a href="{{ route('admin.gradebook.templates.index', ['year_id'=>optional($year)->id]) }}">{{ __('gradebook_templates.title') }}</a>
    @if($grade)
        <span aria-hidden="true">/</span><a href="{{ route('admin.gradebook.templates.index', ['year_id'=>optional($year)->id,'class_id'=>$grade->id]) }}">{{ $grade->name }}</a>
    @endif
    @if($subject)<span aria-hidden="true">/</span><span aria-current="page">{{ $subject->name }}</span>@endif
</nav>
@endsection
@section('gradebook-content')
<div class="container-fluid mt-3 gbt-page" dir="{{ app()->getLocale() === 'en' ? 'ltr' : 'rtl' }}">
    <div class="row justify-content-center"><div class="col-xl-11">
        @yield('template-content')
    </div></div>
</div>
@endsection
