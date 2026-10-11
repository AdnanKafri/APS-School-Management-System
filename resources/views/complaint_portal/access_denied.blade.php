@extends('complaint_portal.layout')
@section('content')
<section class="cp-card cp-login">
    <h1>{{ __('complaint_portal.access_denied_title') }}</h1>
    <p>{{ __('complaint_portal.access_denied_message') }}</p>
    @auth
        <p>{{ __('complaint_portal.signed_in_as') }} <bdi>{{ auth()->user()->name }}</bdi></p>
        <form method="POST" action="{{ route('complaint-portal.switch-account') }}">
            @csrf
            <button class="cp-button" type="submit">{{ __('complaint_portal.switch_account') }}</button>
        </form>
    @endauth
</section>
@endsection
