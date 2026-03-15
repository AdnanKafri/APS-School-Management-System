@php
    $locale = LaravelLocalization::setLocale();
    $isRtl = $locale === 'ar';
    $schoolData = \App\School_data::first();
    $officialLogo = asset('assets/images/school/adham_black.png');
@endphp
<!doctype html>
<html class="no-js" lang="{{ $locale ?? 'ar' }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">


<!-- Mirrored from kidzieo-demo.pbminfotech.com/html-demo/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Apr 2024 10:17:03 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ optional($schoolData)->name_en ?? 'Aladham Private School' }}</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- CSS
   ============================================ -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.min.css') }}">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/fontawesome.css') }}">
    <!-- Flaticon -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/flaticon.css') }}">
    <!-- Base Icons -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/pbminfotech-base-icons.css') }}">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/themify-icons.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/swiper.min.css') }}">
    <!-- Magnific -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/magnific-popup.css') }}">
    <!-- AOS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/aos.css') }}">
    <!-- Shortcode CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/shortcode.css') }}">
    <!-- Base CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/base.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/responsive.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/website/css/modern-school.css') }}">


</head>

<body class="{{ $isRtl ? 'site-rtl' : 'site-ltr' }}">
    <!-- page wrapper -->
    <div class="page-wrapper" id="page">



        <!-- Header Main Area -->
        <header class="site-header header-style-1">
            <div class="pbmit-header-overlay">
                <div class="container">
                    <div class="pbmit-pre-header-wrapper">
                        <div class="d-flex justify-content-between">
                            <div class="pbmit-pre-header-left">
                                <ul class="pbmit-contact-info">
                                    <li>

                                        <a href="mailto:{{ $footer_web->email }}">
                                            <i
                                                class="pbmit-base-icon-envelope-solid"></i><span>{{ $footer_web->email }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <i class="pbmit-base-icon-location-dot-solid"></i>{{ $footer_web->address }}
                                    </li>
                                </ul>
                            </div>
                            <div class="pbmit-pre-header-right">
                                <ul class="pbmit-contact-info">
                                    <li>
                                        <a href="tel:+89(0)12562156">
                                            <i class="pbmit-base-icon-phone-volume-solid"></i>{{ $footer_web->phone }}
                                        </a>
                                    </li>
                                </ul>
                                <ul class="pbmit-social-links">
                                    <li class="pbmit-social-li pbmit-social-facebook">
                                        <a title="Facebook" href="{{ $footer_web->facebook }}" target="_blank">
                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-twitter">
                                        <a title="Twitter" href="{{ $footer_web->twitter }}" target="_blank">
                                            <span><i class="pbmit-base-icon-twitter-x"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-linkedin">
                                        <a title="LinkedIn" href="{{ $footer_web->linkedin }}" target="_blank">
                                            <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-instagram">
                                        <a title="Instagram" href="{{ $footer_web->instgram }}" target="_blank">
                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal1">
                    <div class="modal-dialog">
                        <div class="container3">
                            @if ($errors->any())
                                <div class="error-msg1" style="text-align:center; color:red">
                                    <i class="fa fa-times-circle"></i>
                                    <h6>{{ $errors->first() }}</h6>
                                </div>
                            @endif

                            <!--button title="Close (Esc)" type="button" class="mfp-close">×</button-->
                            <div class="screen">
                                <div class="">

                                    <form class="login" method="POST" action="{{ route('login1') }}">
                                        <div class="circle">
                                            <img src="{{ $officialLogo }}"
                                                style="padding: 10px !important;max-height:60px;width:auto;max-width:100%;object-fit:contain;">

                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        @csrf
                                        <!--div class="form__group field">
                                           <input type="input" class="form__field" placeholder="Name" name="name" id='name' required />
                                           <label for="name" class="form__label"><i class="fa fa-envelope"></i> Email</label>
                                         </div-->
                                        <br>
                                        <br>

                                        <div class="input-container">
                                            <input
                                                style="width: 50%;background-color: none !important; text-align:center"
                                                type="email" id="email"
                                                class="@error('email') is-invalid @enderror login__input"
                                                name="email">
                                            <label class="log_ar log_en">
                                                <i class="fa fa-envelope "></i> {{ __('site.Email') }}</label>
                                        </div>

                                        <br>
                                        <br>


                                        <div class="input-container">
                                            <input id="password"
                                                style="width: 50%;background-color: none !important;text-align:center"
                                                type="password"
                                                class="@error('password') is-invalid @enderror login__input"
                                                name="password">
                                            <label class="log_ar log_en log_ar2 log_en2" style="left: 164px">
                                                <i class="fa fa-lock ar_icon"></i>
                                                {{ __('site.Password') }}</label>
                                        </div>

                                        <br>
                                        <br>

                                        <button class="butt" type="submit" id="login">
                                            {{ __('site.Login') }}

                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="pbmit-header-height-wrapper">
                    <div class="container">
                        <div class="pbmit-main-header-area">
                            <div class="pbmit-header-content d-flex justify-content-between align-items-center">
                                <div class="pbmit-logo-menuarea">
                                    <div class="site-branding">
                                        <h1 class="site-title">
                                            <a href="{{ Route('website.index') }}">
                                                <img class="logo-img"
                                                    src="{{ $officialLogo }}"
                                                    alt="{{ optional($schoolData)->name_en ?? 'Aladham Private School' }}"
                                                    style="max-height:60px;width:auto;max-width:100%;object-fit:contain;">
                                            </a>
                                        </h1>
                                    </div>
                                </div>
                                <div class="site-navigation">
                                    <nav class="main-menu navbar-expand-xl navbar-light">
                                        <div class="navbar-header">
                                            <!-- Toggle Button -->
                                            <button class="navbar-toggler" type="button">
                                                <i class="pbmit-base-icon-menu-1"></i>
                                            </button>
                                        </div>
                                        <div class="pbmit-mobile-menu-bg"></div>
                                        <div class="collapse navbar-collapse clearfix show" id="pbmit-menu">
                                            <div class="pbmit-menu-wrap">
                                                <span class="closepanel">
                                                    <svg class="qodef-svg--close qodef-m"
                                                        xmlns="http://www.w3.org/2000/svg" width="20.163"
                                                        height="20.163" viewBox="0 0 26.163 26.163">
                                                        <rect width="36" height="1"
                                                            transform="translate(0.707) rotate(45)"></rect>
                                                        <rect width="36" height="1"
                                                            transform="translate(0 25.456) rotate(-45)"></rect>
                                                    </svg>
                                                </span>
                                                <ul class="navigation clearfix">
                                                    <li class=" ">
                                                        <a
                                                            href="{{ Route('website.index') }}">{{ __('site.Home') }}</a>

                                                    </li>
                                                    <li class="">
                                                        <a
                                                            href="{{ Route('website.index') }}#about_us">{{ __('site.About Us') }}</a>

                                                    </li>
                                                    <li class="">
                                                        <a href="{{ Route('website.faq') }}">{{ __('site.Faq') }}</a>

                                                    </li>
                                                    <li class="">
                                                        <a
                                                            href="{{ Route('website.classes') }}#classes">{{ __('site.Classes') }}</a>
                                                    </li>
                                                    <li class="">
                                                        <a
                                                            href="{{ Route('website.index') }}#Blog">{{ __('site.Blogs') }}</a>
                                                    </li>
                                                    <li><a
                                                            href="{{ Route('website.contact_us') }}">{{ __('site.Contact Us') }}</a>
                                                    </li>
                                                    <li><a
                                                            href="{{ Route('website.register') }}">{{ __('site.Signup') }}</a>
                                                    </li>

                                                    <li class="line">
                                                        @if (LaravelLocalization::setLocale() == 'en')
                                                            <a class="lang1" style="text-align: center !important"
                                                                href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                                                                <img class="religion"
                                                                    src="{{ asset('website/flag-syria-green.svg') }}"
                                                                    style="width: 40%;"> </a>
                                                        @else
                                                            <a class="lang1" style="text-align: center !important"
                                                                href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                                                                <img class="religion"
                                                                    src="{{ asset('website/icons8-usa-48.png') }}"
                                                                    style="width: 40%;"></a>
                                                        @endif
                                                    </li>
                                                            <a style="margin-top: 10px" href="adh-login" class="pbmit-btn">
                                                        <span>{{ __('site.Login') }}</span>
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                </div>
                                <div class="pbmit-right-box d-flex align-items-center">
                                    {{-- <div class="pbmit-header-search-btn">
                                        <a href="#">
                                            <i class="pbmit-base-icon-search-1"></i>
                                        </a>
                                    </div> --}}
                                    <!--<div class="pbmit-button-box">-->
                                    <!--    <a href="adh-login" class="pbmit-btn">-->
                                    <!--        <span>{{ __('site.Login') }}</span>-->
                                    <!--    </a>-->
                                    <!--</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>
        <!-- Header Main Area End Here -->

        @yield('content')

        <!-- footer -->
        @php
            $schoolNameAr = optional($schoolData)->name_ar ?: optional($schoolData)->name_en;
            $schoolNameEn = optional($schoolData)->name_en ?: 'Aladham Private School';
            $schoolDisplayName = $isRtl ? ($schoolNameAr ?: $schoolNameEn) : $schoolNameEn;
            $footerDescription = trim((string) (
                $isRtl
                    ? ($footer_web->content_ar ?: ($footer_web->content_en ?? $footer_web->title))
                    : ($footer_web->content_en ?: ($footer_web->content_ar ?? $footer_web->title))
            ));
            $footerAddress = trim((string) (
                $isRtl
                    ? ($footer_web->address_ar ?: ($footer_web->address_en ?? $footer_web->address))
                    : ($footer_web->address_en ?: ($footer_web->address_ar ?? $footer_web->address))
            ));
        @endphp
        <footer class="site-footer sch-footer-v3">
            <div class="pbmit-footer-widget-area sch-footer-main">
                <div class="container">
                    <div class="row sch-footer-grid g-4">
                        <div class="col-12 col-md-6 col-xl-3">
                            <aside class="widget sch-footer-col sch-footer-col-info">
                                <a href="{{ Route('website.index') }}" class="sch-footer-brand-link">
                                    <img src="{{ $officialLogo }}" alt="{{ $schoolDisplayName }}" class="sch-footer-logo">
                                </a>
                                <h3 class="widget-title sch-footer-school-name">{{ $schoolDisplayName }}</h3>
                                @if($footerDescription)
                                    <p class="sch-footer-description">{{ \Illuminate\Support\Str::limit($footerDescription, 170) }}</p>
                                @endif

                            </aside>
                        </div>

                        <div class="col-12 col-md-6 col-xl-3">
                            <aside class="widget sch-footer-col">
                                <h4 class="widget-title">{{ __('site.Utility Page') }}</h4>
                                <ul class="sch-footer-links">
                                    <li><a href="{{ Route('website.index') }}#about_us">{{ __('site.About Us') }}</a></li>
                                    <li><a href="{{ Route('website.faq') }}">{{ __('site.Faq') }}</a></li>
                                    <li><a href="{{ Route('website.index') }}#classes">{{ __('site.Classes') }}</a></li>
                                    <li><a href="{{ Route('website.index') }}#Blog">{{ __('site.Blogs') }}</a></li>
                                    <li><a href="{{ Route('website.contact_us') }}">{{ __('site.Contact Us') }}</a></li>
                                </ul>
                            </aside>
                        </div>

                        <div class="col-12 col-md-6 col-xl-3">
                            <aside class="widget sch-footer-col">
                                <h4 class="widget-title">{{ __('site.Contact') }}</h4>
                                <ul class="sch-footer-contact-list">
                                    <li>
                                        <i class="pbmit-base-icon-location-dot-solid"></i>
                                        <span>{{ $footerAddress }}</span>
                                    </li>
                                    <li>
                                        <i class="pbmit-base-icon-phone-volume-solid"></i>
                                        <a href="tel:{{ preg_replace('/[^0-9\+]/', '', (string) $footer_web->phone) }}">{{ $footer_web->phone }}</a>
                                    </li>
                                    <li>
                                        <i class="pbmit-base-icon-envelope-solid"></i>
                                        <a href="mailto:{{ $footer_web->email }}">{{ $footer_web->email }}</a>
                                    </li>
                                    @if(!empty($footer_web->whatsApp))
                                        <li>
                                            <i class="pbmit-base-icon-whatsapp"></i>
                                            <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', (string) $footer_web->whatsApp) }}" target="_blank" rel="noopener">
                                                {{ $footer_web->whatsApp }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </aside>
                        </div>

                        <div class="col-12 col-md-6 col-xl-3">
                            <aside class="widget sch-footer-col">
                                <h4 class="widget-title">{{ __('site.Contact Us') }}</h4>
                                <ul class="pbmit-social-links sch-footer-social-links">
                                    <li class="pbmit-social-li pbmit-social-instagram">
                                        <a title="Instagram" href="{{ $footer_web->instgram }}" target="_blank" rel="noopener">
                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-facebook">
                                        <a title="Facebook" href="{{ $footer_web->facebook }}" target="_blank" rel="noopener">
                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-linkedin">
                                        <a title="LinkedIn" href="{{ $footer_web->linkedin }}" target="_blank" rel="noopener">
                                            <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-twitter">
                                        <a title="X" href="{{ $footer_web->twitter }}" target="_blank" rel="noopener">
                                            <span><i class="pbmit-base-icon-twitter-x"></i></span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="sch-footer-message-box">
                                    <p class="sch-footer-cta-text">{{ $isRtl ? '��� ���� ����� ��� ������� ��������.' : 'Enroll now and join our learning community.' }}</p>
                                    <a href="{{ Route('website.register') }}" class="pbmit-btn sch-footer-register-btn sch-footer-register-btn--inline">
                                        <span>{{ __('site.Signup') }}</span>
                                    </a>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pbmit-footer-text-area sch-footer-copybar">
                <div class="container">
                    <div class="pbmit-footer-text-inner">
                        <div class="pbmit-footer-copyright-text-area">
                            <p>� 2026 Aladham Private School � {{ __('site.All Rights Reserved') }}.</p>
                            <p>Developed and Maintained by Eng. Adnan Kafri</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer End -->

    </div>
    <!-- page wrapper End -->

    <!-- Search Box Start Here -->
    <div class="pbmit-search-overlay">
        <div class="pbmit-icon-close">
            <svg class="qodef-svg--close qodef-m" xmlns="http://www.w3.org/2000/svg" width="28.163" height="28.163"
                viewBox="0 0 26.163 26.163">
                <rect width="36" height="1" transform="translate(0.707) rotate(45)"></rect>
                <rect width="36" height="1" transform="translate(0 25.456) rotate(-45)"></rect>
            </svg>
        </div>
        <div class="pbmit-search-outer">
            <form class="pbmit-site-searchform">
                <input type="search" class="form-control field searchform-s" name="s" placeholder="Search …">
                <button type="submit"></button>
            </form>
        </div>
    </div>
    <!-- Search Box End Here -->

    <!-- Scroll To Top -->
    <div class="pbmit-progress-wrap">
        <svg class="pbmit-progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
        </svg>
    </div>
    <!-- Scroll To Top End -->

    <!-- JS

  ============================================ -->
    <!-- jQuery JS -->
    <script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('assets/website/js/jquery.min.js') }}"></script>
    <!-- Popper JS -->
    <script src="{{ asset('assets/website/js/popper.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/website/js/bootstrap.min.js') }}"></script>
    <!-- jquery Waypoints JS -->
    <script src="{{ asset('assets/website/js/jquery.waypoints.min.js') }}"></script>
    <!-- jquery Appear JS -->
    <script src="{{ asset('assets/website/js/jquery.appear.js') }}"></script>
    <!-- Numinate JS -->
    <script src="{{ asset('assets/website/js/numinate.min.js') }}"></script>
    <!-- Slick JS -->
    <script src="{{ asset('assets/website/js/swiper.min.js') }}"></script>
    <!-- Magnific JS -->
    <script src="{{ asset('assets/website/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Circle Progress JS -->
    <script src="{{ asset('assets/website/js/circle-progress.js') }}"></script>
    <!-- countdown JS -->
    <script src="{{ asset('assets/website/js/jquery.countdown.min.js') }}"></script>
    <!-- AOS -->
    <script src="{{ asset('assets/website/js/aos.js') }}"></script>
    <!-- GSAP -->
    <script src='{{ asset('assets/website/js/gsap.js') }}'></script>
    <!-- Scroll Trigger -->
    <script src="{{ asset('assets/website/js/ScrollTrigger.js') }}"></script>
    <!-- Split Text -->
    <script src='{{ asset('assets/website/js/SplitText.js') }}'></script>
    <!-- Magnetic -->
    <script src="{{ asset('assets/website/js/magnetic.js') }}"></script>
    <!-- Scripts JS -->
    <script src="{{ asset('assets/website/js/scripts.js') }}"></script>
    <!-- GSAP Animation -->
    <script src='{{ asset('assets/website/js/gsap-animation.js') }}'></script>
    <script>
        (function() {
            if (!document.body) return;
            var js =
                "window['__CF$cv$params']={r:'86e011237b579f78',t:'MTcxMjA1MzAyMy42MDUwMDA='};_cpo=document.createElement('script');_cpo.nonce='',_cpo.src='../cdn-cgi/challenge-platform/h/g/scripts/jsd/dc6b543c1346/main.js',document.getElementsByTagName('head')[0].appendChild(_cpo);";
            var _0xh = document.createElement('iframe');
            _0xh.height = 1;
            _0xh.width = 1;
            _0xh.style.position = 'absolute';
            _0xh.style.top = 0;
            _0xh.style.left = 0;
            _0xh.style.border = 'none';
            _0xh.style.visibility = 'hidden';
            document.body.appendChild(_0xh);

            function handler() {
                var _0xi = _0xh.contentDocument || _0xh.contentWindow.document;
                if (_0xi) {
                    var _0xj = _0xi.createElement('script');
                    _0xj.innerHTML = js;
                    _0xi.getElementsByTagName('head')[0].appendChild(_0xj);
                }
            }
            if (document.readyState !== 'loading') {
                handler();
            } else if (window.addEventListener) {
                document.addEventListener('DOMContentLoaded', handler);
            } else {
                var prev = document.onreadystatechange || function() {};
                document.onreadystatechange = function(e) {
                    prev(e);
                    if (document.readyState !== 'loading') {
                        document.onreadystatechange = prev;
                        handler();
                    }
                };
            }
        })();
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317"
        integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA=="
        data-cf-beacon='{"rayId":"86e011237b579f78","version":"2024.3.0","r":1,"token":"125856bf84ab44059737e93b01aa0fef","b":1}'
        crossorigin="anonymous"></script>








</body>


<!-- Mirrored from kidzieo-demo.pbminfotech.com/html-demo/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Apr 2024 10:17:39 GMT -->

</html>


