@extends('admin.layouts.v2')

@section('body_class', 'gradebook-admin-v2')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/gradebook-admin-v2.css') }}">
    @yield('gradebook-style')
@endsection

@section('content')
    <div class="gb-v2" dir="{{ strpos(app()->getLocale(), 'ar') === 0 ? 'rtl' : 'ltr' }}">
        @yield('gradebook-content')
    </div>
@endsection
