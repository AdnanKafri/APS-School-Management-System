@php
    $locale = in_array(request()->segment(1), ['ar', 'en'], true)
        ? request()->segment(1)
        : (in_array(app()->getLocale(), ['ar', 'en'], true) ? app()->getLocale() : 'ar');
    $rtl = $locale === 'ar';
@endphp
<!doctype html>
<html lang="{{ $locale }}" dir="{{ $rtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('errors.403.title', [], $locale) }} | Aladham Private School</title>
    <style>
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; display: grid; place-items: center; padding: 24px; background: #f3f6f6; color: #183c45; font-family: Tahoma, Arial, sans-serif; }
        main { width: min(100%, 560px); padding: clamp(26px, 6vw, 48px); border: 1px solid #dfe8e8; border-radius: 18px; background: #fff; box-shadow: 0 16px 44px rgba(24, 60, 69, .08); text-align: center; }
        .code { margin: 0 0 12px; color: #217368; font-size: 14px; font-weight: 700; letter-spacing: .12em; }
        h1 { margin: 0; font-size: clamp(24px, 5vw, 34px); line-height: 1.4; }
        p { margin: 14px 0 26px; color: #586d72; font-size: 16px; line-height: 1.8; }
        a { display: inline-flex; min-height: 46px; align-items: center; justify-content: center; padding: 10px 22px; border-radius: 9px; background: #217368; color: #fff; font-weight: 700; text-decoration: none; }
        a:focus-visible { outline: 3px solid #8fc8bd; outline-offset: 3px; }
    </style>
</head>
<body>
    <main>
        <p class="code">403</p>
        <h1>{{ __('errors.403.title', [], $locale) }}</h1>
        <p>{{ __('errors.403.message', [], $locale) }}</p>
        <a href="{{ url('/' . $locale) }}">{{ __('errors.403.home', [], $locale) }}</a>
    </main>
</body>
</html>
