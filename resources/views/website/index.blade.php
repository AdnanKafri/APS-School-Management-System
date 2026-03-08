@extends('website.layouts.app')

@section('content')
@php
    $locale = LaravelLocalization::setLocale();
    $isRtl = $locale === 'ar';

    $makeMediaUrl = function ($path, $fallback = null) {
        if (empty($path)) {
            return $fallback ?: asset('assets/website/images/homepage-1/static-box/staticbox-img-01.jpg');
        }
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        return asset('storage/' . ltrim($path, '/'));
    };

    $heroSlide = isset($sliders) && $sliders->count() ? $sliders->first() : null;
    $fallbackWide = asset('assets/website/images/homepage-1/static-box/staticbox-img-01.jpg');
    $fallbackSquare = asset('assets/website/images/homepage-1/gallery/gallery-img-01.jpg');
    $fallbackAbout = asset('assets/website/images/homepage-1/about-img-01.jpg');
    $txt = [
        'welcome' => $isRtl ? 'مرحباً بكم' : 'Welcome',
        'our_vision' => $isRtl ? 'رؤيتنا' : 'Our Vision',
        'services' => $isRtl ? 'خدماتنا' : 'Our Services',
        'classes' => $isRtl ? 'الصفوف الدراسية' : 'Classes',
        'news' => $isRtl ? 'الأخبار' : 'News',
        'blogs' => $isRtl ? 'المدونة' : 'Blogs',
        'testimonials' => $isRtl ? 'آراء أولياء الأمور' : 'Testimonials',
        'gallery' => $isRtl ? 'المعرض' : 'Gallery',
        'more' => $isRtl ? 'المزيد' : 'More',
        'read_more' => $isRtl ? 'قراءة المزيد' : 'Read more',
        'lessons' => $isRtl ? 'حصص' : 'Lessons',
        'week' => $isRtl ? 'أسبوعي' : 'Weekly',
    ];
    $aboutPoints = [];
    if (!empty(optional($about)->content)) {
        $decoded = json_decode($about->content, true);
        if (is_array($decoded)) {
            $aboutPoints = array_values(array_filter($decoded, function ($item) {
                return $item !== null && trim((string) $item) !== '';
            }));
        }
    }
@endphp

<div class="page-content sch-homepage">
    <section class="sch-section sch-intro-strip">
        <div class="container">
            <div class="sch-intro-card">
                <span class="sch-kicker">{{ $txt['welcome'] }}</span>
                <h1>{{ optional($about)->title ?: (optional($heroSlide)->header ?: __('site.Home')) }}</h1>
                <p>{{ \Illuminate\Support\Str::limit((string) (optional($about)->description ?: optional($heroSlide)->content), 190) }}</p>
            </div>
        </div>
    </section>

    @if(isset($counter_web) && $counter_web->count())
        <section class="sch-section sch-counter-strip">
            <div class="container">
                <div class="row g-3">
                    @foreach($counter_web->take(4) as $item)
                        <div class="col-6 col-lg-3">
                            <div class="sch-mini-stat">
                                <strong>{{ number_format((float) $item->count) }}</strong>
                                <span>{{ $item->title }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(isset($vision) && $vision->count())
        <section class="sch-section sch-vision-section">
            <div class="container">
                <div class="sch-section-head">
                    <h2>{{ $txt['our_vision'] }}</h2>
                </div>
                <div class="row g-4">
                    @foreach($vision as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="modern-vision-card modern-vision-card-v2 h-100">
                                <div class="modern-vision-icon">
                                    <i class="pbmit-kidzieo-icon pbmit-kidzieo-icon-book"></i>
                                </div>
                                <h3 class="modern-vision-title">{{ $item->title }}</h3>
                                <p class="modern-vision-desc">{{ \Illuminate\Support\Str::limit((string) $item->title, 120) }}</p>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="sch-section sch-about-section" id="about_us">
        <div class="container">
            <div class="sch-surface sch-about-surface">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <div class="sch-about-media">
                            <img src="{{ $makeMediaUrl(optional($about)->image, $fallbackAbout) }}" alt="{{ optional($about)->title }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ $fallbackAbout }}';">
                        </div>
                    </div>
                    <div class="col-lg-7 sch-about-content" @if($isRtl) dir="rtl" @endif>
                        <span class="sch-kicker">{{ optional($about)->welcome }}</span>
                        <h2 class="sch-title">{{ optional($about)->title }}</h2>
                        <p class="sch-text">{{ optional($about)->description }}</p>
                        @if(count($aboutPoints))
                            <div class="row g-2 sch-check-grid">
                                @foreach($aboutPoints as $point)
                                    <div class="col-md-6">
                                        <div class="sch-check-item">
                                            <i class="pbmit-kidzieo-icon pbmit-kidzieo-icon-circle-check-solid"></i>
                                            <span>{{ $point }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(isset($service) && $service->count())
        <section class="sch-section sch-services-section" id="services">
            <div class="container">
                <div class="sch-section-head">
                    <h2>{{ $txt['services'] }}</h2>
                </div>
                <div class="row g-4">
                    @foreach($service as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="service-visual-card h-100">
                                <div class="service-visual-media">
                                    <img src="{{ $makeMediaUrl($item->image, $fallbackWide) }}" alt="{{ $item->title }}"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ $fallbackWide }}';">
                                </div>
                                <div class="service-visual-overlay"></div>
                                <div class="service-visual-content">
                                    <h3>{{ $item->title }}</h3>
                                    <p>{{ \Illuminate\Support\Str::limit((string) $item->description, 120) }}</p>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(isset($classes) && $classes->count())
        <section class="sch-section sch-classes-section" id="classes">
            @php
                $normalizeClassLabel = function ($value) {
                    $value = \Illuminate\Support\Str::lower(trim((string) $value));
                    $value = strtr($value, ['٠'=>'0','١'=>'1','٢'=>'2','٣'=>'3','٤'=>'4','٥'=>'5','٦'=>'6','٧'=>'7','٨'=>'8','٩'=>'9']);
                    $value = str_replace(['أ', 'إ', 'آ'], 'ا', $value);
                    $value = str_replace('ى', 'ي', $value);
                    $value = preg_replace('/\s+/u', ' ', $value);
                    return trim((string) $value);
                };

                $gradeTokenMap = [
                    12 => ['الثاني عشر', 'ثاني عشر', 'twelfth', 'grade 12', 'class 12'],
                    11 => ['الحادي عشر', 'حادي عشر', 'eleventh', 'grade 11', 'class 11'],
                    10 => ['العاشر', 'عاشر', 'tenth', 'grade 10', 'class 10'],
                    9 => ['التاسع', 'تاسع', 'ninth', 'grade 9', 'class 9'],
                    8 => ['الثامن', 'ثامن', 'eighth', 'grade 8', 'class 8'],
                    7 => ['السابع', 'سابع', 'seventh', 'grade 7', 'class 7'],
                    6 => ['السادس', 'سادس', 'sixth', 'grade 6', 'class 6'],
                    5 => ['الخامس', 'خامس', 'fifth', 'grade 5', 'class 5'],
                    4 => ['الرابع', 'رابع', 'fourth', 'grade 4', 'class 4'],
                    3 => ['الثالث', 'ثالث', 'third', 'grade 3', 'class 3'],
                    2 => ['الثاني', 'ثاني', 'second', 'grade 2', 'class 2'],
                    1 => ['الاول', 'اول', 'first', 'grade 1', 'class 1'],
                ];

                $gradeIndex = function ($item) use ($normalizeClassLabel, $gradeTokenMap) {
                    $label = $normalizeClassLabel(($item->name ?? '') . ' ' . ($item->name_en ?? ''));

                    foreach ($gradeTokenMap as $index => $tokens) {
                        if (\Illuminate\Support\Str::contains($label, $tokens)) {
                            return $index;
                        }
                    }

                    if (preg_match('/(?:^|\s)(1[0-2]|[1-9])(?:\s|$)/u', $label, $matches)) {
                        return (int) $matches[1];
                    }

                    return 999;
                };

                $orderedClasses = collect($classes)
                    ->sortBy(function ($item) use ($gradeIndex) {
                        return sprintf('%03d-%08d', $gradeIndex($item), (int) ($item->id ?? 0));
                    })
                    ->reverse()
                    ->values();
            @endphp
            <div class="container">
                <div class="sch-section-head d-flex justify-content-between align-items-center flex-wrap">
                    <h2>{{ $txt['classes'] }}</h2>
                    <a href="{{ route('website.classes') }}" class="sch-link-more">{{ $txt['more'] }}</a>
                </div>
                <div class="classes-marquee" dir="ltr">
                    <div class="classes-marquee-track">
                        @foreach($orderedClasses as $item)
                            @php
                                $className = $locale === 'ar' ? $item->name : ($item->name_en ?: $item->name);
                                $classInfo = $locale === 'ar'
                                    ? ($item->description_ar ?: $item->description_en)
                                    : ($item->description_en ?: $item->description_ar);
                                $classInfo = \Illuminate\Support\Str::limit((string) ($classInfo ?: ($isRtl ? 'مستوى دراسي ضمن المنهاج الأكاديمي.' : 'A grade level in the academic curriculum.')), 82);
                            @endphp
                            <article class="class-marquee-card">
                                <div class="class-marquee-media">
                                    <img src="{{ $makeMediaUrl($item->image, $fallbackWide) }}" alt="{{ $className }}"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ $fallbackWide }}';">
                                </div>
                                <h3>{{ $className }}</h3>
                                <div class="class-marquee-info" aria-hidden="true">
                                    <p>{{ $classInfo }}</p>
                                </div>
                            </article>
                        @endforeach
                        @foreach($orderedClasses as $item)
                            @php
                                $className = $locale === 'ar' ? $item->name : ($item->name_en ?: $item->name);
                                $classInfo = $locale === 'ar'
                                    ? ($item->description_ar ?: $item->description_en)
                                    : ($item->description_en ?: $item->description_ar);
                                $classInfo = \Illuminate\Support\Str::limit((string) ($classInfo ?: ($isRtl ? 'مستوى دراسي ضمن المنهاج الأكاديمي.' : 'A grade level in the academic curriculum.')), 82);
                            @endphp
                            <article class="class-marquee-card">
                                <div class="class-marquee-media">
                                    <img src="{{ $makeMediaUrl($item->image, $fallbackWide) }}" alt="{{ $className }}"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ $fallbackWide }}';">
                                </div>
                                <h3>{{ $className }}</h3>
                                <div class="class-marquee-info" aria-hidden="true">
                                    <p>{{ $classInfo }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(isset($news) && $news->count())
        <section class="sch-section sch-news-section" id="news">
            <div class="container">
                <div class="sch-section-head d-flex justify-content-between align-items-center flex-wrap">
                    <h2>{{ $txt['news'] }}</h2>
                    <a href="{{ route('website.news') }}" class="sch-link-more">{{ $txt['more'] }}</a>
                </div>
                @php
                    $featuredNews = $news->first();
                    $secondaryNews = $news->slice(1, 3);
                @endphp
                <div class="row g-4 align-items-stretch news-split-row">
                    @if($secondaryNews->count())
                        <div class="col-12 col-lg-5 news-list-col">
                            <div class="news-list-stack h-100">
                                @foreach($secondaryNews as $item)
                                    <article class="news-compact-card">
                                        <div class="news-compact-media">
                                            <img src="{{ $makeMediaUrl($item->image1, $fallbackWide) }}" alt="{{ $item->title }}"
                                                loading="lazy"
                                                onerror="this.onerror=null;this.src='{{ $fallbackWide }}';">
                                        </div>
                                        <div class="news-compact-body">
                                            <h3>{{ $item->title }}</h3>
                                            <p>{{ \Illuminate\Support\Str::limit((string) $item->content, 95) }}</p>
                                            <a href="{{ route('website.news.single', $item->id) }}" class="sch-link-more">{{ $txt['read_more'] }}</a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($featuredNews)
                        <div class="col-12 {{ $secondaryNews->count() ? 'col-lg-7' : 'col-lg-12' }} news-featured-col">
                            <article class="news-featured-card h-100">
                                <div class="news-featured-media">
                                    <img src="{{ $makeMediaUrl($featuredNews->image1, $fallbackWide) }}" alt="{{ $featuredNews->title }}"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ $fallbackWide }}';">
                                </div>
                                <div class="news-featured-body">
                                    <h3>{{ $featuredNews->title }}</h3>
                                    <p>{{ \Illuminate\Support\Str::limit((string) $featuredNews->content, 170) }}</p>
                                    <a href="{{ route('website.news.single', $featuredNews->id) }}" class="sch-link-more">{{ $txt['read_more'] }}</a>
                                </div>
                            </article>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if(isset($testimonials) && $testimonials->count())
        <section class="sch-section sch-muted-bg">
            <div class="container">
                <div class="sch-section-head">
                    <h2>{{ $txt['testimonials'] }}</h2>
                </div>
                <div class="row g-4">
                    @foreach($testimonials->take(3) as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="sch-quote-card h-100">
                                <p>{{ \Illuminate\Support\Str::limit((string) $item->message, 180) }}</p>
                                <div class="sch-quote-user">
                                    <strong>{{ $item->user_name }}</strong>
                                    <span>{{ $item->job_title }}</span>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(isset($blogs_web) && $blogs_web->count())
        <section class="sch-section sch-blog-section" id="Blog">
            <div class="container">
                <div class="sch-section-head">
                    <h2>{{ $txt['blogs'] }}</h2>
                </div>
                <div class="blog-centered-carousel swiper">
                    <div class="swiper-wrapper">
                        @foreach($blogs_web as $item)
                            <div class="swiper-slide">
                                <article class="blog-centered-card">
                                    <div class="blog-centered-media">
                                        <img src="{{ $makeMediaUrl($item->image, $fallbackWide) }}" alt="{{ $item->title }}"
                                            loading="lazy"
                                            onerror="this.onerror=null;this.src='{{ $fallbackWide }}';">
                                    </div>
                                    <div class="blog-centered-body">
                                        <h3>{{ $item->title }}</h3>
                                        <p>{{ \Illuminate\Support\Str::limit((string) $item->description, 130) }}</p>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    @endif

    @if(isset($gallery) && $gallery->count())
        <section class="sch-section sch-gallery sch-gallery-section">
            <div class="container">
                <div class="sch-section-head">
                    <h2>{{ $txt['gallery'] }}</h2>
                </div>
                <div class="sch-gallery-masonry">
                    @foreach($gallery->take(8) as $item)
                        <a class="sch-gallery-item" href="{{ $makeMediaUrl($item->image, $fallbackSquare) }}" target="_blank" rel="noopener">
                            <img src="{{ $makeMediaUrl($item->image, $fallbackSquare) }}" alt="gallery"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ $fallbackSquare }}';">
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="sch-section sch-cta">
        <div class="container">
            <div class="sch-cta-box">
                <h2>{{ optional($about)->title ?: $txt['welcome'] }}</h2>
                <p>{{ optional($about)->description }}</p>
                <div class="sch-hero-actions justify-content-center">
                    <a href="{{ route('website.register') }}" class="pbmit-btn"><span>{{ __('site.Signup') }}</span></a>
                    <a href="{{ route('website.contact_us') }}" class="sch-ghost-btn">{{ __('site.Contact Us') }}</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
