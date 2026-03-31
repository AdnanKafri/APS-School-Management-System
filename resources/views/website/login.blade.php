@extends('website.layouts.auth')

@section('content')
    @php
        $locale = App::getLocale();
        $isArabic = $locale === 'ar';

        $copy = [
            'hero_title' => $isArabic ? 'تسجيل الدخول' : 'Login',
            'home' => $isArabic ? 'الرئيسية' : 'Home',
            'email' => $isArabic ? 'البريد الإلكتروني' : 'Email Address',
            'email_placeholder' => 'example@email.com',
            'password' => $isArabic ? 'كلمة المرور' : 'Password',
            'password_placeholder' => $isArabic ? 'أدخل كلمة المرور' : 'Enter your password',
            'show_password' => $isArabic ? 'إظهار كلمة المرور' : 'Show password',
            'hide_password' => $isArabic ? 'إخفاء كلمة المرور' : 'Hide password',
            'submit' => $isArabic ? 'تسجيل الدخول' : 'Log In',
            'back_home' => $isArabic ? 'العودة إلى الرئيسية' : 'Back to Home',
            'error' => $isArabic
                ? 'البريد الإلكتروني أو كلمة المرور غير صحيحة. يرجى التحقق من البيانات والمحاولة مرة أخرى.'
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
                                <span>{{ $copy['back_home'] }}</span>
                            </a>
                        </div>

                        <div class="login-modern-card__head">
                            <h1>{{ $copy['hero_title'] }}</h1>
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
                                        placeholder="{{ $copy['email_placeholder'] }}"
                                        required>
                                </div>
                                @error('email')
                                    <small class="login-modern-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="login-modern-field">
                                <label for="login_password">{{ $copy['password'] }}</label>
                                <div class="login-modern-input-wrap login-modern-input-wrap--password">
                                    <span class="login-modern-input-icon" aria-hidden="true">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    <input
                                        id="login_password"
                                        type="password"
                                        name="password"
                                        class="login-modern-input @error('password') is-invalid @enderror"
                                        autocomplete="current-password"
                                        placeholder="{{ $copy['password_placeholder'] }}"
                                        required>
                                    <button type="button"
                                        class="login-modern-password-toggle"
                                        data-password-toggle
                                        data-show-label="{{ $copy['show_password'] }}"
                                        data-hide-label="{{ $copy['hide_password'] }}"
                                        aria-controls="login_password"
                                        aria-label="{{ $copy['show_password'] }}"
                                        aria-pressed="false">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <small class="login-modern-error">{{ $message }}</small>
                                @enderror
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

@push('scripts')
<script>
    document.addEventListener('click', function (event) {
        var toggle = event.target.closest('[data-password-toggle]');
        if (!toggle) return;

        var inputId = toggle.getAttribute('aria-controls');
        var input = document.getElementById(inputId);
        if (!input) return;

        var icon = toggle.querySelector('i');
        var isVisible = input.type === 'text';

        input.type = isVisible ? 'password' : 'text';
        toggle.setAttribute('aria-pressed', isVisible ? 'false' : 'true');
        toggle.setAttribute('aria-label', isVisible ? toggle.dataset.showLabel : toggle.dataset.hideLabel);

        if (icon) {
            icon.classList.toggle('fa-eye', isVisible);
            icon.classList.toggle('fa-eye-slash', !isVisible);
        }
    });
</script>
@endpush
