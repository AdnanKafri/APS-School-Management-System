@extends('website.layouts.app')

@section('content')
    @php
        $locale = App::getLocale();
        if (!in_array($locale, ['ar', 'en'], true)) {
            $locale = 'ar';
        }

        $isArabic = $locale === 'ar';

        $page = [
            'title' => $isArabic ? 'مسابقة التوظيف' : 'Recruitment Competition',
            'subtitle' => $isArabic
                ? 'نشارككم هنا أحدث حالة لفرص التوظيف في مدرسة الأدهم الخاصة، مع توضيح واضح لحالة التقديم الحالية وآلية المتابعة مستقبلاً.'
                : 'Here you can find the current status of employment opportunities at Al Adham Private School, presented in a clear and consistent format.',
            'home' => $isArabic ? 'الرئيسية' : 'Home',
            'status_badge' => $isArabic ? 'حالة التقديم الحالية' : 'Current Status',
            'status_title' => $isArabic ? 'باب التقديم مغلق حالياً' : 'Applications Are Currently Closed',
            'status_text' => $isArabic
                ? 'انتهت فترة استقبال طلبات مسابقة التوظيف بتاريخ 30/04/2025. في الوقت الحالي لا توجد شواغر متاحة، وسيتم الإعلان عن أي فرص جديدة فور اعتمادها من إدارة المدرسة.'
                : 'The application period for the recruitment competition ended on April 30, 2025. There are no open vacancies at the moment, and any new opportunities will be announced once they are officially approved by the school administration.',
            'info_title' => $isArabic ? 'ماذا يمكنكم فعله الآن؟' : 'What Can You Do Now?',
            'info_items' => $isArabic
                ? [
                    'متابعة الموقع الرسمي وصفحات المدرسة لمعرفة أي إعلان جديد.',
                    'التواصل مع المدرسة عند الحاجة للاستفسار عن فرص قادمة أو متطلبات التقديم.',
                    'الاحتفاظ بالوثائق المهنية والسيرة الذاتية محدثة استعداداً لأي إعلان لاحق.',
                ]
                : [
                    'Follow the official website and school channels for future announcements.',
                    'Contact the school if you need clarification about upcoming opportunities or requirements.',
                    'Keep your CV and professional documents updated so you are ready for future openings.',
                ],
            'contact_title' => $isArabic ? 'هل تحتاجون إلى استفسار إضافي؟' : 'Need Additional Clarification?',
            'contact_text' => $isArabic
                ? 'يمكنكم التواصل مع فريق المدرسة عبر صفحة التواصل معنا، وسيتم توجيهكم إلى الجهة المناسبة عند توفر أي تحديث.'
                : 'You can contact the school team through the Contact Us page and we will direct you to the appropriate department whenever an update becomes available.',
            'contact_cta' => $isArabic ? 'الانتقال إلى صفحة التواصل' : 'Go to Contact Page',
            'next_title' => $isArabic ? 'عند فتح التقديم من جديد' : 'When Applications Reopen',
            'next_text' => $isArabic
                ? 'سيتم نشر الموعد الجديد، الشروط المطلوبة، وآلية التقديم بشكل واضح على الموقع ضمن نفس الصفحة.'
                : 'The new application date, required criteria, and submission method will be published clearly on this same page.',
        ];
    @endphp

    <section class="sch-section sch-page-hero">
        <div class="container">
            <div class="sch-section-head">
                <h2>{{ $page['title'] }}</h2>
                <p>{{ $page['subtitle'] }}</p>
            </div>
            <div class="sch-page-breadcrumb">
                <a href="{{ route('website.index') }}">{{ $page['home'] }}</a>
                <span class="sch-page-sep">/</span>
                <span>{{ $page['title'] }}</span>
            </div>
        </div>
    </section>

    <section class="sch-section recruitment-modern-section">
        <div class="container">
            <div class="recruitment-modern-shell">
                <div class="recruitment-modern-main">
                    <article class="recruitment-modern-card recruitment-modern-card--primary">
                        <span class="recruitment-modern-badge">{{ $page['status_badge'] }}</span>
                        <h3>{{ $page['status_title'] }}</h3>
                        <p>{{ $page['status_text'] }}</p>
                    </article>

                    <article class="recruitment-modern-card recruitment-modern-card--soft">
                        <h4>{{ $page['info_title'] }}</h4>
                        <ul class="recruitment-modern-list">
                            @foreach ($page['info_items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                </div>

                <aside class="recruitment-modern-side">
                    <article class="recruitment-modern-card recruitment-modern-card--side">
                        <h4>{{ $page['contact_title'] }}</h4>
                        <p>{{ $page['contact_text'] }}</p>
                        <a href="{{ route('website.contact_us') }}" class="pbmit-btn recruitment-modern-cta">
                            <span>{{ $page['contact_cta'] }}</span>
                        </a>
                    </article>

                    <article class="recruitment-modern-card recruitment-modern-card--side-alt">
                        <h4>{{ $page['next_title'] }}</h4>
                        <p>{{ $page['next_text'] }}</p>
                    </article>
                </aside>
            </div>
        </div>
    </section>
@endsection
