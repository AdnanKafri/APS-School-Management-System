@extends('website.layouts.auth')

@section('content')
    @php
        $locale = App::getLocale();
        $isArabic = $locale === 'ar';

        $copy = [
            'hero_title' => $isArabic ? 'تسجيل الدخول' : 'Login',
            'hero_subtitle' => $isArabic
                ? 'بوابة آمنة وسهلة للوصول إلى حسابك ومتابعة خدمات المدرسة.'
                : 'A secure and simple way to access your account and continue with school services.',
            'home' => $isArabic ? 'الرئيسية' : 'Home',
            'badge' => $isArabic ? 'بوابة المستخدم' : 'User Access',
            'title' => $isArabic ? 'مرحباً بعودتك' : 'Welcome back',
            'intro' => $isArabic
                ? 'سجّل الدخول باستخدام بريدك الإلكتروني وكلمة المرور للوصول إلى لوحة التحكم والخدمات المرتبطة بحسابك.'
                : 'Sign in with your email and password to access your dashboard and the services connected to your account.',
            'email' => $isArabic ? 'البريد الإلكتروني' : 'Email Address',
            'password' => $isArabic ? 'كلمة المرور' : 'Password',
            'remember' => $isArabic ? 'تذكرني' : 'Remember me',
            'forgot' => $isArabic ? 'هل نسيت كلمة المرور؟' : 'Forgot Password?',
            'submit' => $isArabic ? 'تسجيل الدخول' : 'Log In',
            'error' => $isArabic
                ? 'البريد الإلكتروني أو كلمة المرور غير صحيحة. يرجى التحقق والمحاولة مرة أخرى.'
                : 'The email address or password is incorrect. Please review your details and try again.',
            'validation' => $isArabic
                ? 'يرجى مراجعة الحقول المطلوبة ثم إعادة المحاولة.'
                : 'Please review the required fields and try again.',
        ];
    @endphp

    <main class="auth-page-shell">
        <div class="auth-page-decoration auth-page-decoration--one" aria-hidden="true"></div>
        <div class="auth-page-decoration auth-page-decoration--two" aria-hidden="true"></div>
        <div class="auth-page-decoration auth-page-decoration--three" aria-hidden="true"></div>

        <section class="login-modern-section">
            <div class="container">
                <div class="login-modern-shell">
                    <div class="login-modern-card">
                        <div class="login-modern-brand">
                            <a href="{{ route('website.index') }}" class="login-modern-brand__logo" aria-label="{{ $copy['home'] }}">
                                <img src="{{ asset('assets/images/school/adham_black.png') }}" alt="Al Adham Private School">
                            </a>
                            <a href="{{ route('website.index') }}" class="login-modern-home-link">
                                <i class="fa fa-angle-{{ $isArabic ? 'left' : 'right' }}"></i>
                                <span>{{ $isArabic ? 'العودة إلى الرئيسية' : 'Back to Home' }}</span>
                            </a>
                        </div>

                        <div class="login-modern-card__head">
                            <span class="login-modern-badge">{{ $copy['badge'] }}</span>
                            <h1>{{ $copy['hero_title'] }}</h1>
                            <p>{{ $copy['intro'] }}</p>
                        </div>

                        @if (session()->has('error'))
                            <div class="login-modern-alert login-modern-alert--error">
                                {{ $copy['error'] }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="login-modern-alert login-modern-alert--error">
                                {{ $copy['validation'] }}
                            </div>
                        @endif

                        <form action="{{ route('login1') }}" method="post" class="login-modern-form" novalidate>
                            @csrf

                            <div class="login-modern-field">
                                <label for="login_email">{{ $copy['email'] }}</label>
                                <div class="login-modern-input-wrap">
                                    <span class="login-modern-input-icon" aria-hidden="true">
                                        <i class="fa fa-envelope-o"></i>
                                    </span>
                                    <input
                                        id="login_email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="login-modern-input @error('email') is-invalid @enderror"
                                        autocomplete="username"
                                        required>
                                </div>
                                @error('email')
                                    <small class="login-modern-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="login-modern-field">
                                <label for="login_password">{{ $copy['password'] }}</label>
                                <div class="login-modern-input-wrap">
                                    <span class="login-modern-input-icon" aria-hidden="true">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    <input
                                        id="login_password"
                                        type="password"
                                        name="password"
                                        class="login-modern-input @error('password') is-invalid @enderror"
                                        autocomplete="current-password"
                                        required>
                                </div>
                                @error('password')
                                    <small class="login-modern-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="login-modern-meta">
                                <label class="login-modern-check">
                                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                                    <span>{{ $copy['remember'] }}</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a class="login-modern-forgot" href="{{ route('password.request') }}">
                                        {{ $copy['forgot'] }}
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="pbmit-btn login-modern-submit">
                                <span>{{ $copy['submit'] }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
