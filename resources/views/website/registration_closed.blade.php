@extends('website.layouts.app')

@section('css')
<style>
    .register-closed-page {
        padding: 3rem 0 4rem;
    }

    .register-closed-shell {
        max-width: 820px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .register-closed-card {
        border: 1px solid #ece7f6;
        border-radius: 20px;
        background: linear-gradient(180deg, #ffffff 0%, #fcfbff 100%);
        box-shadow: 0 14px 34px rgba(28, 20, 52, 0.08);
        padding: 2.2rem 1.4rem;
        text-align: center;
    }

    .register-closed-pill {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        border-radius: 999px;
        background: #fff1f1;
        color: #b23a3a;
        font-size: .82rem;
        font-weight: 800;
        padding: .4rem .8rem;
        margin-bottom: .95rem;
    }

    .register-closed-title {
        margin: 0 0 .5rem;
        font-weight: 800;
        color: #2f2b3a;
        font-size: 1.6rem;
        line-height: 1.35;
    }

    .register-closed-desc {
        margin: 0 auto 1.2rem;
        max-width: 640px;
        color: #6f6885;
        line-height: 1.9;
    }

    .register-closed-actions {
        display: flex;
        justify-content: center;
        gap: .65rem;
        flex-wrap: wrap;
    }

    .register-closed-actions .btn {
        min-width: 150px;
        border-radius: 12px;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .register-closed-card {
            padding: 1.5rem 1rem;
        }
        .register-closed-title {
            font-size: 1.35rem;
        }
    }
</style>
@endsection

@section('content')
@php
    $locale = LaravelLocalization::getCurrentLocale();
    $isArabic = $locale === 'ar';
@endphp

<section class="register-closed-page">
    <div class="register-closed-shell">
        <div class="register-closed-card" dir="{{ $isArabic ? 'rtl' : 'ltr' }}">
            <span class="register-closed-pill">
                <i class="fa fa-info-circle"></i>
                {{ $isArabic ? 'حالة التسجيل' : 'Registration Status' }}
            </span>

            <h1 class="register-closed-title">
                {{ $isArabic ? 'التسجيل الإلكتروني مغلق حالياً' : 'Registration Is Currently Closed' }}
            </h1>

            <p class="register-closed-desc">
                {{ $isArabic
                    ? 'نعتذر، تم إيقاف استقبال طلبات التسجيل. يمكنك التواصل مع إدارة المدرسة لمزيد من المعلومات.'
                    : 'We are sorry, online registration is unavailable. You can contact the school administration for more details.' }}
            </p>

            <div class="register-closed-actions">
                <a href="{{ route('website.index') }}" class="btn btn-primary">
                    {{ $isArabic ? 'العودة إلى الرئيسية' : 'Back to Home' }}
                </a>
                <a href="{{ route('website.contact_us') }}" class="btn btn-outline-primary">
                    {{ $isArabic ? 'تواصل معنا' : 'Contact Us' }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
