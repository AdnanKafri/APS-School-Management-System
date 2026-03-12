@php
    $locale = LaravelLocalization::setLocale();
    $isRtl = $locale === 'ar';
    $schoolData = \App\School_data::first();
    $officialLogo = asset('assets/images/school/adham_black.png');
    $isHomepage = request()->routeIs('website.index');
    $resolveImage = function ($path, $fallback = null) {
        if (empty($path)) {
            return $fallback ?: asset('assets/website/images/homepage-1/slider/slider-img-01.jpg');
        }
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        return asset('storage/' . ltrim($path, '/'));
    };
    $localMediaExists = function ($relativePath) {
        $relativePath = ltrim((string) $relativePath, '/');
        if ($relativePath === '') {
            return false;
        }

        $candidates = [
            public_path($relativePath),
            public_path('storage/' . $relativePath),
            storage_path($relativePath),
            storage_path('app/public/' . $relativePath),
        ];

        if (\Illuminate\Support\Str::startsWith($relativePath, 'storage/')) {
            $trimmed = ltrim(substr($relativePath, strlen('storage/')), '/');
            if ($trimmed !== '') {
                $candidates[] = storage_path($trimmed);
                $candidates[] = storage_path('app/public/' . $trimmed);
            }
        }

        foreach ($candidates as $candidate) {
            if (is_string($candidate) && file_exists($candidate)) {
                return true;
            }
        }

        return false;
    };
    $normalizeHeroVideo = function ($url) use ($localMediaExists) {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }

        if (stripos($url, '<iframe') !== false && preg_match('/src=[\"\']([^\"\']+)[\"\']/i', $url, $embedMatch)) {
            $url = trim($embedMatch[1]);
        }

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $url)) {
            return [
                'type' => 'iframe',
                'src' => 'https://www.youtube.com/embed/' . $url . '?rel=0&modestbranding=1',
            ];
        }

        if (\Illuminate\Support\Str::startsWith($url, ['www.youtube.com', 'youtube.com', 'youtu.be', 'vimeo.com'])) {
            $url = 'https://' . ltrim($url, '/');
        }

        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{6,})~i', $url, $match)) {
            return [
                'type' => 'iframe',
                'src' => 'https://www.youtube.com/embed/' . $match[1] . '?rel=0&modestbranding=1',
            ];
        }

        if (preg_match('~(?:vimeo\.com/)(\d+)~i', $url, $match)) {
            return [
                'type' => 'iframe',
                'src' => 'https://player.vimeo.com/video/' . $match[1],
            ];
        }

        if (preg_match('~\.(mp4|webm|ogg)(\?.*)?$~i', $url)) {
            if (\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) {
                return ['type' => 'video', 'src' => $url];
            }

            $cleanPath = ltrim($url, '/');

            if (\Illuminate\Support\Str::startsWith($cleanPath, ['storage/', 'assets/', 'uploads/', 'images/'])) {
                if (!$localMediaExists($cleanPath)) {
                    return null;
                }
                return ['type' => 'video', 'src' => asset($cleanPath)];
            }

            if (!$localMediaExists($cleanPath)) {
                return null;
            }
            return ['type' => 'video', 'src' => asset('storage/' . $cleanPath)];
        }

        return null;
    };
    $heroVideoMeta = null;
    if (isset($video) && $video) {
        if (!empty($video->youtube)) {
            $heroVideoMeta = $normalizeHeroVideo($video->youtube);
        }
        if (empty($heroVideoMeta) && !empty($video->video)) {
            $heroVideoMeta = $normalizeHeroVideo($video->video);
        }
    }
    if (empty($heroVideoMeta) && !empty(optional($schoolData)->video)) {
        $heroVideoMeta = $normalizeHeroVideo($schoolData->video);
    }
    if (empty($heroVideoMeta) && isset($other) && $other && !empty($other->img3)) {
        $heroVideoMeta = $normalizeHeroVideo($other->img3);
    }
@endphp
<!doctype html>
<html class="no-js" lang="{{ $locale ?? 'ar' }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">


<!-- Mirrored from kidzieo-demo.pbminfotech.com/html-demo/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Apr 2024 10:17:03 GMT -->

<head>
    <meta property="og:title" content="{{ optional($schoolData)->name ?: 'مدرسة الأدهم الخاصة' }}" />
    <meta property="og:description" content="{{ optional($footer_web)->title ?: 'موقع مدرسة الأدهم الخاصة - تعليم متميز لبناء المستقبل' }}" />
    <meta property="og:image" content="{{ $officialLogo }}" />
    <meta property="og:url" content="https://aladhamedu.com/ar" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="ar_AR" />

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
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/website/css/modern-school.css') }}">


</head>

<body class="{{ $isRtl ? 'site-rtl' : 'site-ltr' }} {{ $isHomepage ? 'is-homepage' : '' }}">
    <!-- page wrapper -->
    <div class="page-wrapper" id="page">



        <!-- Hero Wrapper: shared bg for floating navbar + hero -->
        <div class="sch-hero-wrapper">

        <!-- Header Main Area -->
        <header class="sch-site-header">
            <div class="container">
                <div class="sch-header-shell">
                    <a class="sch-brand" href="{{ Route('website.index') }}">
                        <img src="{{ $officialLogo }}"
                            alt="{{ optional($schoolData)->name_en ?? 'Aladham Private School' }}">
                    </a>

                    <button class="sch-menu-toggle" type="button" aria-label="Menu" aria-expanded="false"
                        aria-controls="schPrimaryNav">
                        <span></span><span></span><span></span>
                    </button>

                    <nav class="sch-nav" id="schPrimaryNav">
                        <ul class="sch-nav-list">
                            <li><a href="{{ Route('website.index') }}">{{ __('site.Home') }}</a></li>
                            <li><a href="{{ Route('website.index') }}#about_us">{{ __('site.About Us') }}</a></li>
                            <li><a href="{{ Route('website.faq') }}">{{ __('site.Faq') }}</a></li>
                            <li><a href="{{ Route('website.index') }}#classes">{{ __('site.Classes') }}</a></li>
                            <li><a href="{{ Route('website.index') }}#Blog">{{ __('site.Blogs') }}</a></li>
                            <li><a href="{{ Route('website.contact_us') }}">{{ __('site.Contact Us') }}</a></li>
                            <li><a href="{{ Route('website.register') }}">{{ __('site.Signup') }}</a></li>
                            @if (LaravelLocalization::setLocale() == 'en')
                                <li><a href="{{ Route('Recruitment_competition') }}">Recruitment competition</a></li>
                            @else
                                <li><a href="{{ Route('Recruitment_competition') }}">مسابقة التوظيف</a></li>
                            @endif
                        </ul>
                    </nav>

                    <div class="sch-header-actions">
                        @if (LaravelLocalization::setLocale() == 'en')
                            <a class="sch-lang-switch"
                                href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                                <img src="{{ asset('website/icons8-syria-48.png') }}" alt="AR">
                            </a>
                        @else
                            <a class="sch-lang-switch"
                                href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                                <img src="{{ asset('website/icons8-usa-48.png') }}" alt="EN">
                            </a>
                        @endif
                        <a href="adh-login" class="pbmit-btn sch-header-login">
                            <span>{{ __('site.Login') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        @if ($isHomepage)
            @php
                $heroSlides = isset($sliders) ? $sliders : collect();
                $heroFallback = asset('assets/website/images/homepage-1/slider/slider-img-01.jpg');
                $hasHeroSlider = $heroSlides->count() > 1;
            @endphp
            <section class="home-hero">
                <div class="container">
                    @if ($hasHeroSlider)
                        <div class="home-hero-carousel">
                            <div class="home-hero-slider swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($heroSlides as $item)
                                        @php
                                            $heroSubtitle = !empty($item->subtitle) ? $item->subtitle : $item->key_word;
                                            $heroTitle = !empty($item->title)
                                                ? $item->title
                                                : (!empty($item->header)
                                                    ? $item->header
                                                    : (optional($schoolData)->name ?: 'Aladham Private School'));
                                            $heroDescription = !empty($item->description) ? $item->description : $item->content;
                                            $primaryText = !empty($item->button_text) ? $item->button_text : __('site.Signup');
                                            $secondaryText = !empty($item->button_text_secondary) ? $item->button_text_secondary : ($isRtl ? 'شاهد الفيديو' : 'Watch Video');
                                            $primaryUrl = !empty($item->button_link) ? $item->button_link : Route('website.register');
                                            $secondaryUrl = !empty($item->button_link_secondary) ? $item->button_link_secondary : Route('website.contact_us');
                                            $slideVideoMeta = !empty($item->button_link_secondary) ? $normalizeHeroVideo($item->button_link_secondary) : null;
                                            if (empty($slideVideoMeta)) {
                                                $slideVideoMeta = $heroVideoMeta;
                                            }
                                            $useVideoModal = !empty($slideVideoMeta);
                                            $heroBgFrom = !empty($item->background_from) ? $item->background_from : '#ffffff';
                                            $heroBgMid = !empty($item->background_mid) ? $item->background_mid : '#f7f2ff';
                                            $heroBgTo = !empty($item->background_to) ? $item->background_to : '#efe5ff';
                                            $heroCircle = !empty($item->circle_color) ? $item->circle_color : '#b682d8';
                                            $heroCircleSecondary = !empty($item->circle_color_secondary) ? $item->circle_color_secondary : '#efc3ff';
                                        @endphp
                                        <div class="swiper-slide">
                                            <article class="home-hero-item home-hero-v4"
                                                style="--hero-bg-from: {{ $heroBgFrom }}; --hero-bg-mid: {{ $heroBgMid }}; --hero-bg-to: {{ $heroBgTo }}; --hero-circle: {{ $heroCircle }}; --hero-circle-2: {{ $heroCircleSecondary }};">
                                                <div class="home-hero-grid home-hero-grid-v4">
                                                    <div class="home-hero-content home-hero-content-v4">
                                                        @if (!empty($heroSubtitle))
                                                            <span class="home-hero-label home-hero-label-v4">{{ $heroSubtitle }}</span>
                                                        @endif
                                                        <h1 class="home-hero-title home-hero-title-v4">
                                                            {{ $heroTitle }}
                                                        </h1>
                                                        @if (!empty($heroDescription))
                                                            <p class="home-hero-text home-hero-text-v4">{{ $heroDescription }}</p>
                                                        @endif
                                                        <div class="home-hero-actions home-hero-actions-v4">
                                                            <a href="{{ $primaryUrl }}"
                                                                class="home-hero-btn home-hero-btn-primary home-hero-btn-primary-v4">{{ $primaryText }}</a>
                                                            @if ($useVideoModal)
                                                                <a href="#" class="home-hero-btn home-hero-btn-ghost home-hero-btn-ghost-v4 js-hero-video-trigger"
                                                                    data-video-type="{{ $slideVideoMeta['type'] }}"
                                                                    data-video-src="{{ $slideVideoMeta['src'] }}">
                                                                    <i class="fa fa-play" aria-hidden="true"></i>
                                                                    <span>{{ $secondaryText }}</span>
                                                                </a>
                                                            @else
                                                                <a href="{{ $secondaryUrl }}"
                                                                    class="home-hero-btn home-hero-btn-ghost home-hero-btn-ghost-v4">
                                                                    <i class="fa fa-play" aria-hidden="true"></i>
                                                                    <span>{{ $secondaryText }}</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="home-hero-media home-hero-media-v4">
                                                        <span class="home-hero-circle-v4" aria-hidden="true"></span>
                                                        <img src="{{ $resolveImage($item->image, $heroFallback) }}"
                                                            alt="{{ $heroTitle }}"
                                                            onerror="this.onerror=null;this.src='{{ $heroFallback }}';">
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hero-arrows">
                                <div class="swiper-button-prev" aria-label="Previous Slide"></div>
                                <div class="swiper-button-next" aria-label="Next Slide"></div>
                            </div>
                            <div class="hero-pagination"></div>
                        </div>
                    @else
                        @php
                            $item = $heroSlides->first();
                            $heroSubtitle = !empty(optional($item)->subtitle) ? $item->subtitle : optional($item)->key_word;
                            $heroTitle = !empty(optional($item)->title)
                                ? $item->title
                                : (!empty(optional($item)->header)
                                    ? $item->header
                                    : (optional($schoolData)->name ?: 'Aladham Private School'));
                            $heroDescription = !empty(optional($item)->description) ? $item->description : optional($item)->content;
                            $primaryText = !empty(optional($item)->button_text) ? $item->button_text : __('site.Signup');
                            $secondaryText = !empty(optional($item)->button_text_secondary) ? $item->button_text_secondary : ($isRtl ? 'شاهد الفيديو' : 'Watch Video');
                            $primaryUrl = !empty(optional($item)->button_link) ? $item->button_link : Route('website.register');
                            $secondaryUrl = !empty(optional($item)->button_link_secondary) ? $item->button_link_secondary : Route('website.contact_us');
                            $slideVideoMeta = !empty(optional($item)->button_link_secondary) ? $normalizeHeroVideo($item->button_link_secondary) : null;
                            if (empty($slideVideoMeta)) {
                                $slideVideoMeta = $heroVideoMeta;
                            }
                            $useVideoModal = !empty($slideVideoMeta);
                            $heroBgFrom = !empty(optional($item)->background_from) ? $item->background_from : '#ffffff';
                            $heroBgMid = !empty(optional($item)->background_mid) ? $item->background_mid : '#f7f2ff';
                            $heroBgTo = !empty(optional($item)->background_to) ? $item->background_to : '#efe5ff';
                            $heroCircle = !empty(optional($item)->circle_color) ? $item->circle_color : '#b682d8';
                            $heroCircleSecondary = !empty(optional($item)->circle_color_secondary) ? $item->circle_color_secondary : '#efc3ff';
                        @endphp
                        <article class="home-hero-item home-hero-static home-hero-v4"
                            style="--hero-bg-from: {{ $heroBgFrom }}; --hero-bg-mid: {{ $heroBgMid }}; --hero-bg-to: {{ $heroBgTo }}; --hero-circle: {{ $heroCircle }}; --hero-circle-2: {{ $heroCircleSecondary }};">
                            <div class="home-hero-grid home-hero-grid-v4">
                                <div class="home-hero-content home-hero-content-v4">
                                    @if (!empty($heroSubtitle))
                                        <span class="home-hero-label home-hero-label-v4">{{ $heroSubtitle }}</span>
                                    @endif
                                    <h1 class="home-hero-title home-hero-title-v4">
                                        {{ $heroTitle }}
                                    </h1>
                                    @if (!empty($heroDescription))
                                        <p class="home-hero-text home-hero-text-v4">{{ $heroDescription }}</p>
                                    @endif
                                    <div class="home-hero-actions home-hero-actions-v4">
                                        <a href="{{ $primaryUrl }}"
                                            class="home-hero-btn home-hero-btn-primary home-hero-btn-primary-v4">{{ $primaryText }}</a>
                                        @if ($useVideoModal)
                                            <a href="#" class="home-hero-btn home-hero-btn-ghost home-hero-btn-ghost-v4 js-hero-video-trigger"
                                                data-video-type="{{ $slideVideoMeta['type'] }}"
                                                data-video-src="{{ $slideVideoMeta['src'] }}">
                                                <i class="fa fa-play" aria-hidden="true"></i>
                                                <span>{{ $secondaryText }}</span>
                                            </a>
                                        @else
                                            <a href="{{ $secondaryUrl }}"
                                                class="home-hero-btn home-hero-btn-ghost home-hero-btn-ghost-v4">
                                                <i class="fa fa-play" aria-hidden="true"></i>
                                                <span>{{ $secondaryText }}</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="home-hero-media home-hero-media-v4">
                                    <span class="home-hero-circle-v4" aria-hidden="true"></span>
                                    <img src="{{ $resolveImage(optional($item)->image, $heroFallback) }}"
                                        alt="{{ $heroTitle }}"
                                        onerror="this.onerror=null;this.src='{{ $heroFallback }}';">
                                </div>
                            </div>
                        </article>
                    @endif
                </div>
            </section>
            <div class="hero-video-modal" id="heroVideoModal" aria-hidden="true">
                <div class="hero-video-modal__overlay" data-video-close></div>
                <div class="hero-video-modal__dialog" role="dialog" aria-modal="true" aria-label="{{ $isRtl ? 'مشغل فيديو' : 'Video Player' }}">
                    <button type="button" class="hero-video-modal__close" aria-label="{{ $isRtl ? 'إغلاق' : 'Close' }}" data-video-close>&times;</button>
                    <div class="hero-video-modal__ratio">
                        <iframe id="hero-video-iframe" class="hero-video-modal__iframe" title="School Video"
                            allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen hidden></iframe>
                        <video id="hero-video-player" class="hero-video-modal__video" controls playsinline preload="metadata" hidden></video>
                    </div>
                </div>
            </div>
        @endif
        </div><!-- /.sch-hero-wrapper -->
        <!-- Header Main Area End Here -->

        @yield('content')



        <!-- footer -->
        <footer class="site-footer sch-footer-clean">
            <div class="container footer-clean-wrap">
                <div class="row g-4 footer-clean-grid">
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-clean-col footer-clean-brand">
                            <a href="{{ Route('website.index') }}" class="footer-clean-logo-link">
                                <img src="{{ $officialLogo }}"
                                    alt="{{ optional($schoolData)->name_en ?? 'Aladham Private School' }}"
                                    class="footer-clean-logo">
                            </a>
                            <h3 class="footer-clean-title footer-clean-brand-name">
                                {{ optional($schoolData)->name ?: 'Aladham Private School' }}
                            </h3>
                            <p class="footer-clean-text">{{ $footer_web->title }}</p>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-clean-col">
                            <h4 class="footer-clean-title">{{ __('site.Utility Page') }}</h4>
                            <ul class="footer-clean-links">
                                <li><a href="{{ Route('website.index') }}#about_us">{{ __('site.About Us') }}</a></li>
                                <li><a href="{{ Route('website.faq') }}">{{ __('site.Faq') }}</a></li>
                                <li><a href="{{ Route('website.index') }}#classes">{{ __('site.Classes') }}</a></li>
                                <li><a href="{{ Route('website.index') }}#Blog">{{ __('site.Blogs') }}</a></li>
                                <li><a href="{{ Route('website.contact_us') }}">{{ __('site.Contact Us') }}</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-clean-col">
                            <h4 class="footer-clean-title">{{ __('site.Contact') }}</h4>
                            <ul class="footer-clean-contact">
                                <li>
                                    <i class="pbmit-base-icon-location-dot-solid"></i>
                                    <span>{{ $footer_web->address }}</span>
                                </li>
                                <li>
                                    <i class="pbmit-base-icon-phone-volume-solid"></i>
                                    <a href="tel:{{ $footer_web->phone }}">{{ $footer_web->phone }}</a>
                                </li>
                                <li>
                                    <i class="pbmit-base-icon-envelope-solid"></i>
                                    <a href="mailto:{{ $footer_web->email }}">{{ $footer_web->email }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-clean-col">
                            <h4 class="footer-clean-title">{{ __('site.Contact Us') }}</h4>
                            <ul class="footer-clean-social">
                                <li><a title="Facebook" href="{{ $footer_web->facebook }}" target="_blank" rel="noopener"><span><i class="pbmit-base-icon-facebook-f"></i></span></a></li>
                                <li><a title="Twitter" href="{{ $footer_web->twitter }}" target="_blank" rel="noopener"><span><i class="pbmit-base-icon-twitter-x"></i></span></a></li>
                                <li><a title="LinkedIn" href="{{ $footer_web->linkedin }}" target="_blank" rel="noopener"><span><i class="pbmit-base-icon-linkedin-in"></i></span></a></li>
                                <li><a title="Instagram" href="{{ $footer_web->instgram }}" target="_blank" rel="noopener"><span><i class="pbmit-base-icon-instagram"></i></span></a></li>
                            </ul>
                            <a href="{{ Route('website.register') }}" class="pbmit-btn footer-clean-cta">
                                <span>{{ __('site.Signup') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="footer-clean-copy">
                    <p>© 2026 Aladham Private School — All Rights Reserved</p>
                    <p>Developed and Maintained by Eng. Adnan Kafri</p>
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
                <input type="search" class="form-control field searchform-s" name="s" placeholder="Search â€¦">
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
            var toggle = document.querySelector('.sch-menu-toggle');
            var nav = document.querySelector('.sch-nav');
            if (!toggle || !nav) return;

            var closeNav = function() {
                nav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            };

            toggle.addEventListener('click', function() {
                var expanded = toggle.getAttribute('aria-expanded') === 'true';
                if (expanded) {
                    closeNav();
                    return;
                }
                nav.classList.add('is-open');
                toggle.setAttribute('aria-expanded', 'true');
            });

            document.addEventListener('click', function(e) {
                if (!nav.contains(e.target) && !toggle.contains(e.target)) {
                    closeNav();
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) {
                    closeNav();
                }
            });
        })();
    </script>
    <script>
        (function() {
            var hero = document.querySelector('.home-hero-slider.swiper');
            var root = document.querySelector('.home-hero-carousel');
            if (!hero || !root || typeof Swiper === 'undefined') return;

            var prev = root.querySelector('.hero-arrows .swiper-button-prev');
            var next = root.querySelector('.hero-arrows .swiper-button-next');
            var pagination = root.querySelector('.hero-pagination');

            new Swiper(hero, {
                loop: true,
                speed: 900,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                navigation: {
                    prevEl: prev,
                    nextEl: next
                },
                pagination: {
                    el: pagination,
                    clickable: true
                }
            });
        })();
    </script>
    <script>
        (function() {
            var blogEl = document.querySelector('.blog-centered-carousel.swiper');
            if (!blogEl || typeof Swiper === 'undefined') return;

            new Swiper(blogEl, {
                loop: true,
                centeredSlides: true,
                slidesPerView: 1.12,
                spaceBetween: 18,
                speed: 700,
                autoplay: {
                    delay: 4200,
                    disableOnInteraction: false
                },
                pagination: {
                    el: blogEl.querySelector('.swiper-pagination'),
                    clickable: true
                },
                breakpoints: {
                    768: {
                        slidesPerView: 1.35,
                        spaceBetween: 22
                    },
                    1200: {
                        slidesPerView: 1.6,
                        spaceBetween: 26
                    }
                }
            });
        })();
    </script>
    <script>
        (function() {
            var modal = document.getElementById('heroVideoModal');
            if (!modal) return;

            var iframe = modal.querySelector('.hero-video-modal__iframe');
            var video = modal.querySelector('.hero-video-modal__video');
            var closeTargets = modal.querySelectorAll('[data-video-close]');
            var isClosing = false;

            function stopPlayback() {
                iframe.setAttribute('hidden', 'hidden');
                iframe.removeAttribute('src');

                video.pause();
                video.setAttribute('hidden', 'hidden');
                video.removeAttribute('src');
                video.load();
            }

            function closeModal() {
                if (isClosing || !modal.classList.contains('is-open')) return;
                isClosing = true;
                modal.classList.remove('is-open');
                modal.classList.add('is-closing');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('hero-video-open');
                stopPlayback();

                window.setTimeout(function() {
                    modal.classList.remove('is-closing');
                    isClosing = false;
                }, 220);
            }

            function openModal(source, type) {
                if (!source) return;

                stopPlayback();
                if (type === 'video') {
                    video.removeAttribute('hidden');
                    video.src = source;
                    video.load();
                    video.play().catch(function() {});
                } else {
                    iframe.removeAttribute('hidden');
                    iframe.src = source + (source.indexOf('?') === -1 ? '?autoplay=1' : '&autoplay=1');
                }

                modal.classList.add('is-open');
                modal.classList.remove('is-closing');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('hero-video-open');
            }

            document.addEventListener('click', function(event) {
                var trigger = event.target.closest('.js-hero-video-trigger');
                if (!trigger) return;
                event.preventDefault();
                openModal(trigger.getAttribute('data-video-src'), trigger.getAttribute('data-video-type'));
            });

            closeTargets.forEach(function(target) {
                target.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });
        })();
    </script>
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
