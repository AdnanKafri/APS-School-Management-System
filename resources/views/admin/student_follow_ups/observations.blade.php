@extends('admin.layouts.v2')
@section('page_title', __('student_follow_up_admin.observations'))
@section('page_subtitle', $year->name)
@section('style') @include('admin.student_follow_ups._styles') @endsection
@section('content')<div class="sfu-admin"><div class="v2-card sfu-shell"><div class="sfu-intro"><div><h3>{{ __('student_follow_up_admin.observations') }}</h3><p>{{ __('student_follow_up_admin.month') }}: {{ $month }} · {{ __('student_follow_up_admin.current_year_only') }}</p></div><a class="btn btn-outline-secondary" href="{{ route('admin.student_follow_ups.index', ['month'=>$month]) }}">{{ __('student_follow_up_admin.back') }}</a></div>@include('admin.student_follow_ups._observations')<div class="mt-3">{{ $followUps->links() }}</div></div></div>@endsection
