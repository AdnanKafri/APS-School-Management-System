@php
    $seoRoute = request()->route() ? request()->route()->getName() : null;
    $seoLocale = in_array($locale ?? app()->getLocale(), ['ar', 'en'], true)
        ? ($locale ?? app()->getLocale())
        : 'ar';
    $seoSchoolData = $schoolData ?? \App\School_data::first();
    $seoFooter = $footer_web ?? \App\Footer_website::first();
    $seoBrandAr = trim((string) optional($seoSchoolData)->name) ?: 'مدرسة الأدهم الخاصة';
    $seoBrandEn = trim((string) optional($seoSchoolData)->name_en) ?: 'Aladham Private School';
    $seoBrand = $seoLocale === 'ar' ? $seoBrandAr : $seoBrandEn;
    $seoBaseUrl = rtrim((string) config('app.url'), '/');
    $seoPath = request()->getPathInfo() ?: '/';
    $seoCanonical = $seoBaseUrl . ($seoPath === '/' ? '' : $seoPath);
    $seoArPath = preg_replace('#^/(ar|en)(?=/|$)#', '/ar', $seoPath);
    $seoEnPath = preg_replace('#^/(ar|en)(?=/|$)#', '/en', $seoPath);
    $seoLogo = $studentBrandIcon ?? asset('student/avatar.png');
    $seoAddress = $seoLocale === 'ar'
        ? trim((string) (optional($seoFooter)->address_ar ?: optional($seoFooter)->address))
        : trim((string) (optional($seoFooter)->address_en ?: optional($seoFooter)->address));
    $seoPhone = trim((string) optional($seoFooter)->phone);
    $seoEmail = trim((string) optional($seoFooter)->email);
    $seoSocialLinks = array_values(array_filter([
        optional($seoFooter)->facebook,
        optional($seoFooter)->twitter,
        optional($seoFooter)->linkedin,
        optional($seoFooter)->instgram,
    ]));

    $seoPageCopy = [
        'ar' => [
            'website.index' => ['title' => 'مدرسة خاصة في حماة | مدرسة الأدهم الخاصة', 'description' => 'مدرسة الأدهم الخاصة في حماة: تعليم متميز وبيئة مدرسية داعمة لبناء مستقبل الطلاب.'],
            'website.faq' => ['title' => 'الأسئلة الشائعة | مدرسة الأدهم الخاصة', 'description' => 'إجابات عن الأسئلة الشائعة حول التسجيل والبرامج والخدمات في مدرسة الأدهم الخاصة.'],
            'website.contact_us' => ['title' => 'تواصل معنا | مدرسة الأدهم الخاصة في حماة', 'description' => 'تواصل مع مدرسة الأدهم الخاصة في حماة للاستفسار عن التسجيل والبرامج والخدمات المدرسية.'],
            'website.complaints' => ['title' => 'الشكاوى والاقتراحات | مدرسة الأدهم الخاصة', 'description' => 'أرسل ملاحظاتك واقتراحاتك إلى مدرسة الأدهم الخاصة لتحسين تجربتك المدرسية.'],
            'Recruitment_competition' => ['title' => 'مسابقة التوظيف | مدرسة الأدهم الخاصة', 'description' => 'تعرف على فرص ومسابقات التوظيف في مدرسة الأدهم الخاصة.'],
            'website.registration_wizard' => ['title' => 'التسجيل في مدرسة الأدهم الخاصة | مدرسة خاصة في حماة', 'description' => 'ابدأ طلب التسجيل في مدرسة الأدهم الخاصة في حماة عبر خطوات واضحة وآمنة.'],
            'website.register' => ['title' => 'التسجيل في مدرسة الأدهم الخاصة | مدرسة خاصة في حماة', 'description' => 'ابدأ طلب التسجيل في مدرسة الأدهم الخاصة في حماة عبر خطوات واضحة وآمنة.'],
            'website.login' => ['title' => 'تسجيل الدخول | مدرسة الأدهم الخاصة', 'description' => 'تسجيل الدخول إلى حساب مدرسة الأدهم الخاصة.'],
        ],
        'en' => [
            'website.index' => ['title' => 'Private School in Hama | Aladham Private School', 'description' => 'Aladham Private School in Hama provides quality education in a supportive school environment.'],
            'website.faq' => ['title' => 'Frequently Asked Questions | Aladham Private School', 'description' => 'Answers to common questions about registration, programs, and services at Aladham Private School.'],
            'website.contact_us' => ['title' => 'Contact Aladham Private School in Hama', 'description' => 'Contact Aladham Private School in Hama about registration, programs, and school services.'],
            'website.complaints' => ['title' => 'Complaints and Suggestions | Aladham Private School', 'description' => 'Send your feedback and suggestions to Aladham Private School.'],
            'Recruitment_competition' => ['title' => 'Recruitment Competition | Aladham Private School', 'description' => 'Learn about recruitment opportunities and competitions at Aladham Private School.'],
            'website.registration_wizard' => ['title' => 'Apply to Aladham Private School | Private School in Hama', 'description' => 'Start an application to Aladham Private School in Hama through a clear, secure process.'],
            'website.register' => ['title' => 'Apply to Aladham Private School | Private School in Hama', 'description' => 'Start an application to Aladham Private School in Hama through a clear, secure process.'],
            'website.login' => ['title' => 'Sign In | Aladham Private School', 'description' => 'Sign in to your Aladham Private School account.'],
        ],
    ];
    $seoCopy = $seoPageCopy[$seoLocale][$seoRoute] ?? [
        'title' => $seoBrand,
        'description' => $seoLocale === 'ar'
            ? 'تعرف على مدرسة الأدهم الخاصة وبرامجها وخدماتها التعليمية.'
            : 'Explore Aladham Private School, its programs, and educational services.',
    ];
    $seoNoIndexRoutes = ['website.login', 'website.registration_wizard', 'website.register', 'website.register_legacy', 'website.registration_closed'];
    $seoRobots = in_array($seoRoute, $seoNoIndexRoutes, true) ? 'noindex, nofollow' : 'index, follow';
    $seoIsIndexable = $seoRobots === 'index, follow';
    $seoImageAlt = $seoLocale === 'ar' ? $seoBrandAr : $seoBrandEn;
    $seoSchema = [
        '@type' => 'School',
        '@id' => $seoBaseUrl . '/#school',
        'name' => $seoBrand,
        'url' => $seoBaseUrl . '/' . $seoLocale,
        'logo' => $seoLogo,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $seoAddress,
            'addressLocality' => 'Hama',
            'addressCountry' => 'SY',
        ],
    ];
    if ($seoPhone !== '') {
        $seoSchema['telephone'] = preg_replace('/\s+/', ' ', $seoPhone);
    }
    if ($seoEmail !== '') {
        $seoSchema['email'] = $seoEmail;
    }
    if (count($seoSocialLinks)) {
        $seoSchema['sameAs'] = $seoSocialLinks;
    }
    $seoGraph = [
        $seoSchema,
        [
            '@type' => 'WebSite',
            '@id' => $seoBaseUrl . '/#website',
            'name' => $seoBrand,
            'url' => $seoBaseUrl . '/' . $seoLocale,
            'publisher' => ['@id' => $seoBaseUrl . '/#school'],
            'inLanguage' => $seoLocale,
        ],
        [
            '@type' => 'WebPage',
            '@id' => $seoCanonical . '#webpage',
            'url' => $seoCanonical,
            'name' => $seoCopy['title'],
            'description' => $seoCopy['description'],
            'isPartOf' => ['@id' => $seoBaseUrl . '/#website'],
            'inLanguage' => $seoLocale,
        ],
    ];
    if ($seoPath !== '/' && $seoPath !== '/ar' && $seoPath !== '/en') {
        $seoGraph[] = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => $seoLocale === 'ar' ? 'الرئيسية' : 'Home',
                    'item' => $seoBaseUrl . '/' . $seoLocale,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $seoCopy['title'],
                    'item' => $seoCanonical,
                ],
            ],
        ];
    }
@endphp

<title>{{ $seoCopy['title'] }}</title>
<meta name="description" content="{{ $seoCopy['description'] }}">
<meta name="robots" content="{{ $seoRobots }}">
<link rel="canonical" href="{{ $seoCanonical }}">
<meta property="og:type" content="{{ strpos((string) $seoRoute, '.single') !== false ? 'article' : 'website' }}">
<meta property="og:site_name" content="{{ $seoBrand }}">
<meta property="og:title" content="{{ $seoCopy['title'] }}">
<meta property="og:description" content="{{ $seoCopy['description'] }}">
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:image" content="{{ $seoLogo }}">
<meta property="og:image:alt" content="{{ $seoImageAlt }}">
<meta property="og:locale" content="{{ $seoLocale === 'ar' ? 'ar_AR' : 'en_GB' }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoCopy['title'] }}">
<meta name="twitter:description" content="{{ $seoCopy['description'] }}">
<meta name="twitter:image" content="{{ $seoLogo }}">
@if($seoIsIndexable)
    <link rel="alternate" hreflang="ar" href="{{ $seoBaseUrl . $seoArPath }}">
    <link rel="alternate" hreflang="en" href="{{ $seoBaseUrl . $seoEnPath }}">
    <link rel="alternate" hreflang="x-default" href="{{ $seoBaseUrl . $seoArPath }}">
@endif
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $seoGraph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
