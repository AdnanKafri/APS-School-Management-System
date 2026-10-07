@extends('complaint_portal.layout')
@section('content')
<section class="cp-card cp-login"><h1>{{ __('complaint_portal.login') }}</h1>
<form method="POST" action="{{ route('complaint-portal.authenticate') }}" class="cp-form">@csrf
    <label for="email">{{ __('complaint_portal.email') }}</label><input id="email" name="email" type="email" dir="ltr" value="{{ old('email') }}" autocomplete="username" required>
    <label for="password">{{ __('complaint_portal.password') }}</label><input id="password" name="password" type="password" autocomplete="current-password" required>
    <button class="cp-button">{{ __('complaint_portal.login') }}</button>
</form></section>
@endsection
