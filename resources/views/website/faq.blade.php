@extends('website.layouts.app')

@section('content')
    @php
        $isArabic = app()->getLocale() === 'ar';
        $faqItems = collect($faqs ?? [])
            ->filter(function ($item) {
                return trim((string) ($item->title ?? '')) !== '';
            })
            ->unique(function ($item) {
                $title = trim((string) ($item->title ?? ''));
                $title = preg_replace('/\s+/u', ' ', $title);
                $title = preg_replace('/[\p{P}\p{S}]+/u', '', $title);
                return \Illuminate\Support\Str::lower($title);
            })
            ->values();

        $faqIntro = $isArabic
            ? 'نقدم هنا إجابات واضحة على أكثر الأسئلة شيوعًا حول التسجيل والمناهج والخدمات التي توفرها مدرسة الأدهم الخاصة. وإذا لم تجد الإجابة التي تبحث عنها، يمكنك التواصل معنا مباشرة وسنكون سعداء بمساعدتك.'
            : 'Here you can find clear answers to the most common questions about admissions, curriculum, and services at Al Adham Private School. If you still need help, please contact us directly and our team will be happy to assist you.';
    @endphp

    <section class="sch-section sch-page-hero">
        <div class="container">
            <div class="sch-section-head">
                <h2>{{ __('site.Faq') }}</h2>
            </div>
            <div class="sch-page-breadcrumb">
                <a href="{{ Route('website.index') }}">{{ __('site.Aladham') }}</a>
                <span class="sch-page-sep">/</span>
                <span>{{ __('site.Faq') }}</span>
            </div>
        </div>
    </section>

    <section class="sch-section faq-modern-section">
        <div class="container">
            <div class="faq-modern">
                <div class="faq-modern__head">
                    <h2>{{ __('site.Frequently Asked Questions') }}</h2>
                    <p>{{ $faqIntro }}</p>
                </div>

                <div class="accordion faq-modern__list" id="faqModernAccordion">
                    @foreach ($faqItems as $index => $item)
                        <article class="accordion-item faq-modern__item">
                            <h3 class="accordion-header" id="faqHeading{{ $index }}">
                                <button class="accordion-button collapsed faq-modern__trigger" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $index }}"
                                    aria-expanded="false" aria-controls="faqCollapse{{ $index }}">
                                    <span class="faq-modern__q">{{ $item->title }}</span>
                                    <span class="faq-modern__icon" aria-hidden="true">
                                        <span></span>
                                        <span></span>
                                    </span>
                                </button>
                            </h3>

                            <div id="faqCollapse{{ $index }}" class="accordion-collapse collapse"
                                aria-labelledby="faqHeading{{ $index }}" data-bs-parent="#faqModernAccordion">
                                <div class="accordion-body faq-modern__body">
                                    {{ $item->description }}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
