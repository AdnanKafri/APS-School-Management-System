<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ __('complaint_portal.title') }}</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/complaint-portal.css') }}">
</head>
<body class="cp-shell">
<header class="cp-header"><a href="{{ route('complaint-portal.index') }}" class="cp-brand">{{ __('complaint_portal.title') }}</a>
    @auth
    <div class="cp-account"><span>{{ auth()->user()->name }}</span>@include('complaint_portal.notifications')<form method="POST" action="{{ route('complaint-portal.logout') }}">@csrf<button class="cp-button cp-secondary">{{ __('complaint_portal.logout') }}</button></form></div>
    @endauth
</header>
<main class="cp-main">
    @if(session('success'))<p class="cp-alert cp-success" role="status">{{ session('success') }}</p>@endif
    @if($errors->any())<div class="cp-alert" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
    @yield('content')
</main>
<script src="{{ asset('js/complaint-portal.js') }}" defer></script>
</body></html>
