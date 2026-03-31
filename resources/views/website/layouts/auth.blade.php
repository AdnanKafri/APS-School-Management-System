@php
    $locale = app()->getLocale();
    if (!in_array($locale, ['ar', 'en'], true)) {
        $locale = 'ar';
    }

    $isRtl = $locale === 'ar';
    $schoolData = \App\School_data::first();
    $schoolName = $isRtl
        ? (optional($schoolData)->name_ar ?: optional($schoolData)->name_en ?: 'مدرسة الأدهم الخاصة')
        : (optional($schoolData)->name_en ?: optional($schoolData)->name_ar ?: 'Al Adham Private School');
    $officialLogo = asset('assets/images/school/adham_black.png');
@endphp
<!doctype html>
<html class="no-js" lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $schoolName }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, follow">

    <link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/pbminfotech-base-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/shortcode.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/website/css/responsive.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cairo:wght@400;600;700;800&family=Inter:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/website/css/modern-school.css') }}">
    @yield('css')
    @stack('styles')
</head>

<body class="{{ $isRtl ? 'site-rtl' : 'site-ltr' }} auth-page auth-page--login">
    @yield('content')
    @stack('scripts')
</body>

</html>
