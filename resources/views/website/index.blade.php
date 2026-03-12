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
        'why_choose_school' => $isRtl ? 'لماذا تختار مدرستنا للأطفال؟' : 'Why Choose Our School for Children?',
        'classes' => $isRtl ? 'الصفوف الدراسية' : 'Classes',
        'news' => $isRtl ? 'الأخبار' : 'News',
        'blogs' => $isRtl ? 'المدونة' : 'Blogs',
        'testimonials' => $isRtl ? 'ماذا يقول طلابنا؟' : 'What Our Students Say',
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

    @if((isset($service) && $service->count()) || (isset($our_services_feature) && $our_services_feature->count()))
        @php
            $whyItems = collect(isset($our_services_feature) ? $our_services_feature : [])->values();
            if ($whyItems->isEmpty() && isset($service) && $service->count()) {
                $whyItems = collect($service)->values();
            }
            $whyItems = $whyItems->take(6)->values();

            $serviceItems = collect(isset($service) ? $service : [])->values();
            if ($serviceItems->isEmpty() && isset($our_services_feature) && $our_services_feature->count()) {
                $serviceItems = collect($our_services_feature)->values();
            }
            $serviceItems = $serviceItems->take(8)->values();
        @endphp

        <section class="sch-section sch-services-rebuild-section" id="services">
            <div class="container">
                @if($whyItems->count())
                    <div class="services-block feature-stack-block feature-stack-block--why">
                        <div class="sch-section-head feature-stack-head">
                            <h2>{{ $txt['why_choose_school'] }}</h2>
                        </div>
                        <div class="feature-stack-list">
                            @foreach($whyItems as $item)
                                @php
                                    $whyTitle = $locale === 'ar'
                                        ? ($item->title_ar ?: ($item->title ?: $item->title_en))
                                        : ($item->title_en ?: ($item->title ?: $item->title_ar));
                                    $whyDesc = trim((string) (
                                        $locale === 'ar'
                                            ? ($item->description_ar ?: ($item->description ?: $item->description_en))
                                            : ($item->description_en ?: ($item->description ?: $item->description_ar))
                                    ));
                                    $whyIconRaw = (string) ($item->icon ?? '');
                                    $whyHasIconImage = !empty($whyIconRaw) && (
                                        \Illuminate\Support\Str::contains($whyIconRaw, ['/', '\\']) ||
                                        preg_match('/\.(png|jpe?g|svg|webp|gif)$/i', $whyIconRaw)
                                    );
                                    $whyIconImage = $whyHasIconImage ? $whyIconRaw : null;
                                @endphp
                                <article class="feature-stack-item">
                                    <span class="feature-stack-icon" aria-hidden="true">
                                        @if(!empty($whyIconImage))
                                            <img src="{{ $makeMediaUrl($whyIconImage, $fallbackSquare) }}" alt="{{ $whyTitle }}"
                                                loading="lazy"
                                                onerror="this.onerror=null;this.src='{{ $fallbackSquare }}';">
                                        @elseif(!empty($item->icon))
                                            <i class="{{ $item->icon }}"></i>
                                        @else
                                            <i class="pbmit-kidzieo-icon pbmit-kidzieo-icon-circle-check-solid"></i>
                                        @endif
                                    </span>
                                    <div class="feature-stack-content">
                                        <h3>{{ $whyTitle }}</h3>
                                        @if($whyDesc)
                                            <p>{{ $whyDesc }}</p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($serviceItems->count())
                    <div class="services-block feature-stack-block feature-stack-block--services">
                        <div class="sch-section-head feature-stack-head">
                            <h2>{{ $txt['services'] }}</h2>
                        </div>
                        <div class="feature-stack-list">
                            @foreach($serviceItems as $item)
                                @php
                                    $serviceTitle = $locale === 'ar'
                                        ? ($item->title_ar ?: ($item->title ?: $item->title_en))
                                        : ($item->title_en ?: ($item->title ?: $item->title_ar));
                                    $serviceDesc = trim((string) (
                                        $locale === 'ar'
                                            ? ($item->description_ar ?: ($item->description ?: $item->description_en))
                                            : ($item->description_en ?: ($item->description ?: $item->description_ar))
                                    ));
                                    $serviceIconImage = !empty($item->image) ? $item->image : null;
                                @endphp
                                <article class="feature-stack-item feature-stack-item--service">
                                    <span class="feature-stack-icon" aria-hidden="true">
                                        @if(!empty($serviceIconImage))
                                            <img src="{{ $makeMediaUrl($serviceIconImage, $fallbackSquare) }}" alt="{{ $serviceTitle }}"
                                                loading="lazy"
                                                onerror="this.onerror=null;this.src='{{ $fallbackSquare }}';">
                                        @elseif(!empty($item->icon))
                                            <i class="{{ $item->icon }}"></i>
                                        @else
                                            <i class="pbmit-kidzieo-icon pbmit-kidzieo-icon-book"></i>
                                        @endif
                                    </span>
                                    <div class="feature-stack-content">
                                        <h3>{{ $serviceTitle }}</h3>
                                        @if($serviceDesc)
                                            <p>{{ $serviceDesc }}</p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
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
        @php
            $blogItems = collect($blogs_web)->values();
            $featuredBlog = $blogItems->first();
            $blogHeading = $isRtl ? 'آخر الأخبار والإعلانات' : 'School News & Announcements';
            $blogSubheading = $isRtl ? 'تابع آخر الإعلانات المدرسية والأنشطة المهمة.' : 'Follow the latest school announcements and important activities.';
            $getBlogTitle = function ($item) use ($locale) {
                return $locale === 'ar'
                    ? ($item->title_ar ?: ($item->title ?? $item->title_en))
                    : ($item->title_en ?: ($item->title ?? $item->title_ar));
            };
            $getBlogDescription = function ($item) use ($locale) {
                return trim((string) (
                    $locale === 'ar'
                        ? ($item->description_ar ?: ($item->description ?? $item->description_en))
                        : ($item->description_en ?: ($item->description ?? $item->description_ar))
                ));
            };
            $featuredTitle = $featuredBlog ? $getBlogTitle($featuredBlog) : '';
            $featuredDescription = $featuredBlog ? $getBlogDescription($featuredBlog) : '';
            $featuredImage = $featuredBlog ? $makeMediaUrl($featuredBlog->image, $fallbackWide) : $fallbackWide;
        @endphp
        <section class="sch-section sch-blog-section sch-blog-annc" id="Blog">
            <div class="container">
                <div class="sch-section-head blog-annc-head">
                    <h2>{{ $blogHeading }}</h2>
                    <p>{{ $blogSubheading }}</p>
                </div>

                @if($featuredBlog)
                    <div class="blog-annc-layout">
                        <article class="blog-annc-featured" data-blog-featured>
                            <div class="blog-annc-featured-media">
                                <img src="{{ $featuredImage }}" alt="{{ $featuredTitle }}"
                                    data-blog-featured-image
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ $fallbackWide }}';">
                            </div>
                            <div class="blog-annc-featured-body">
                                <h3 data-blog-featured-title>{{ $featuredTitle }}</h3>
                                @if($featuredDescription)
                                    <p data-blog-featured-desc>{{ $featuredDescription }}</p>
                                @else
                                    <p data-blog-featured-desc></p>
                                @endif
                            </div>
                        </article>

                        <aside class="blog-annc-rail-wrap" aria-label="{{ $txt['blogs'] }}">
                            <div class="blog-annc-rail" data-blog-rail>
                                @foreach($blogItems as $item)
                                    @php
                                        $itemTitle = $getBlogTitle($item);
                                        $itemDescription = $getBlogDescription($item);
                                        $itemImage = $makeMediaUrl($item->image, $fallbackWide);
                                    @endphp
                                    <button
                                        type="button"
                                        class="blog-annc-mini @if($loop->first) is-active @endif"
                                        data-news-title="{{ $itemTitle }}"
                                        data-news-desc="{{ $itemDescription }}"
                                        data-news-image="{{ $itemImage }}"
                                        aria-label="{{ $itemTitle }}"
                                    >
                                        <span class="blog-annc-mini-thumb">
                                            <img src="{{ $itemImage }}" alt="{{ $itemTitle }}"
                                                loading="lazy"
                                                onerror="this.onerror=null;this.src='{{ $fallbackWide }}';">
                                        </span>
                                        <span class="blog-annc-mini-content">
                                            <strong>{{ $itemTitle }}</strong>
                                            @if($itemDescription)
                                                <small>{{ \Illuminate\Support\Str::limit($itemDescription, 88) }}</small>
                                            @endif
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </aside>
                    </div>
                @endif
            </div>
        </section>
        <script>
            (function() {
                var root = document.querySelector('.sch-blog-annc');
                if (!root) return;

                var featured = root.querySelector('[data-blog-featured]');
                var featuredImage = root.querySelector('[data-blog-featured-image]');
                var featuredTitle = root.querySelector('[data-blog-featured-title]');
                var featuredDesc = root.querySelector('[data-blog-featured-desc]');
                var rail = root.querySelector('[data-blog-rail]');
                var cards = root.querySelectorAll('.blog-annc-mini');
                var autoDelay = 5000;
                var autoTimer = null;
                var resumeTimer = null;
                var currentIndex = 0;
                var hoverLocked = false;
                var touchStartX = null;
                var touchStartY = null;

                if (!featuredImage || !featuredTitle || !cards.length) return;

                var indexOfCard = function(card) {
                    return Array.prototype.indexOf.call(cards, card);
                };

                var stopAuto = function() {
                    if (autoTimer) {
                        window.clearInterval(autoTimer);
                        autoTimer = null;
                    }
                };

                var startAuto = function() {
                    if (autoTimer || hoverLocked || document.hidden || cards.length < 2) return;
                    autoTimer = window.setInterval(function() {
                        goTo(currentIndex + 1);
                    }, autoDelay);
                };

                var resumeAutoSoon = function(delay) {
                    if (resumeTimer) {
                        window.clearTimeout(resumeTimer);
                    }
                    resumeTimer = window.setTimeout(function() {
                        hoverLocked = false;
                        startAuto();
                    }, delay || 1200);
                };

                var syncActiveCardIntoView = function(card) {
                    if (!rail || !card) return;

                    var isMobile = window.matchMedia('(max-width: 767px)').matches;
                    var cardStart = isMobile ? card.offsetLeft : card.offsetTop;
                    var cardSize = isMobile ? card.offsetWidth : card.offsetHeight;
                    var viewportSize = isMobile ? rail.clientWidth : rail.clientHeight;

                    var target = cardStart - ((viewportSize - cardSize) / 2);
                    if (target < 0) target = 0;

                    if (isMobile) {
                        rail.scrollTo({
                            left: target,
                            behavior: 'smooth'
                        });
                    } else {
                        rail.scrollTo({
                            top: target,
                            behavior: 'smooth'
                        });
                    }
                };

                var activate = function(card, options) {
                    options = options || {};
                    if (!card) return;

                    cards.forEach(function(item) {
                        item.classList.remove('is-active');
                    });
                    card.classList.add('is-active');

                    var nextIndex = indexOfCard(card);
                    if (nextIndex >= 0) {
                        currentIndex = nextIndex;
                    }

                    var nextImage = card.getAttribute('data-news-image') || '';
                    var nextTitle = card.getAttribute('data-news-title') || '';
                    var nextDesc = card.getAttribute('data-news-desc') || '';

                    var instant = !!options.instant;
                    var apply = function() {
                        featuredImage.src = nextImage || featuredImage.src;
                        featuredImage.alt = nextTitle || featuredImage.alt;
                        featuredTitle.textContent = nextTitle;
                        if (featuredDesc) {
                            featuredDesc.textContent = nextDesc;
                        }
                        if (featured) {
                            featured.classList.remove('is-switching');
                        }
                        syncActiveCardIntoView(card);
                    };

                    if (instant || !featured) {
                        apply();
                        return;
                    }

                    featured.classList.add('is-switching');
                    window.setTimeout(apply, 170);
                };

                var goTo = function(index) {
                    if (!cards.length) return;
                    var nextIndex = index;
                    if (nextIndex >= cards.length) nextIndex = 0;
                    if (nextIndex < 0) nextIndex = cards.length - 1;
                    activate(cards[nextIndex]);
                };

                var initial = root.querySelector('.blog-annc-mini.is-active');
                if (initial) {
                    var initialIndex = indexOfCard(initial);
                    if (initialIndex >= 0) currentIndex = initialIndex;
                    activate(initial, {
                        instant: true
                    });
                } else {
                    activate(cards[0], {
                        instant: true
                    });
                }

                cards.forEach(function(card) {
                    card.addEventListener('click', function() {
                        stopAuto();
                        activate(card);
                        startAuto();
                    });
                });

                root.addEventListener('mouseenter', function() {
                    hoverLocked = true;
                    stopAuto();
                });

                root.addEventListener('mouseleave', function() {
                    hoverLocked = false;
                    startAuto();
                });

                root.addEventListener('focusin', function() {
                    hoverLocked = true;
                    stopAuto();
                });

                root.addEventListener('focusout', function() {
                    if (!root.contains(document.activeElement)) {
                        hoverLocked = false;
                        startAuto();
                    }
                });

                document.addEventListener('visibilitychange', function() {
                    if (document.hidden) {
                        stopAuto();
                    } else if (!hoverLocked) {
                        startAuto();
                    }
                });

                var swipeSurface = featured || root;
                swipeSurface.addEventListener('touchstart', function(event) {
                    if (!event.touches || !event.touches.length) return;
                    touchStartX = event.touches[0].clientX;
                    touchStartY = event.touches[0].clientY;
                    hoverLocked = true;
                    stopAuto();
                }, {
                    passive: true
                });

                swipeSurface.addEventListener('touchend', function(event) {
                    if (!event.changedTouches || !event.changedTouches.length) {
                        resumeAutoSoon(1400);
                        return;
                    }
                    var dx = event.changedTouches[0].clientX - (touchStartX || 0);
                    var dy = event.changedTouches[0].clientY - (touchStartY || 0);

                    if (Math.abs(dx) > 44 && Math.abs(dx) > Math.abs(dy)) {
                        if (dx < 0) {
                            goTo(currentIndex + 1);
                        } else {
                            goTo(currentIndex - 1);
                        }
                    }

                    touchStartX = null;
                    touchStartY = null;
                    resumeAutoSoon(1500);
                }, {
                    passive: true
                });

                startAuto();
            })();
        </script>
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
