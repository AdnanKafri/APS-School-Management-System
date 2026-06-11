@extends('website.layouts.app')

@section('content')
    @php
        $isArabic = app()->getLocale() === 'ar';

        $contactIntro = $isArabic
            ? 'نسعد بتواصلكم معنا للإجابة عن استفساراتكم حول التسجيل، البرامج التعليمية، والخدمات المدرسية. يمكنكم إرسال رسالتكم مباشرة وسيقوم فريق المدرسة بالرد عليكم في أقرب وقت.'
            : 'We are happy to assist you with any questions about admissions, academic programs, and school services. Send us your message directly and our team will respond as soon as possible.';

        $email = trim((string) optional($footer_web)->email);
        $address = trim((string) optional($footer_web)->address);
        $phoneRaw = trim((string) optional($footer_web)->phone);
        $whatsAppRaw = trim((string) optional($footer_web)->whatsApp);

        $splitContactValues = function ($raw) {
            $raw = trim((string) $raw);
            if ($raw === '') {
                return [];
            }

            $normalized = preg_replace('/[\r\n\t,،;|\/]+/u', ' | ', $raw);
            $normalized = preg_replace('/\s+-\s+/u', ' | ', $normalized);
            $chunks = preg_split('/\|+/u', (string) $normalized, -1, PREG_SPLIT_NO_EMPTY);

            $values = [];
            foreach ($chunks as $chunk) {
                $chunk = trim((string) $chunk);
                if ($chunk === '') {
                    continue;
                }

                if (preg_match_all('/\+?\d[\d\-]{6,}\d/u', $chunk, $matches) && count($matches[0]) > 1) {
                    foreach ($matches[0] as $match) {
                        $values[] = trim((string) $match);
                    }
                    continue;
                }

                $values[] = $chunk;
            }

            if (count($values) <= 1 && preg_match_all('/\+?\d[\d\-]{6,}\d/u', $raw, $matches) && count($matches[0]) > 1) {
                $values = $matches[0];
            }

            $clean = [];
            $seen = [];
            foreach ($values as $value) {
                $value = preg_replace('/\s+/u', ' ', trim((string) $value));
                if ($value === '') {
                    continue;
                }

                $key = preg_replace('/[^0-9\+]/u', '', $value);
                if ($key === '') {
                    $key = \Illuminate\Support\Str::lower($value);
                }

                if (isset($seen[$key])) {
                    continue;
                }

                $seen[$key] = true;
                $clean[] = $value;
            }

            return $clean;
        };

        $phoneItems = $splitContactValues($phoneRaw);
        $whatsAppItems = $splitContactValues($whatsAppRaw);

        $socialLinks = collect([
            ['icon' => 'pbmit-base-icon-facebook-f', 'title' => 'Facebook', 'url' => trim((string) optional($footer_web)->facebook)],
            ['icon' => 'pbmit-base-icon-twitter-x', 'title' => 'X', 'url' => trim((string) optional($footer_web)->twitter)],
            ['icon' => 'pbmit-base-icon-linkedin-in', 'title' => 'LinkedIn', 'url' => trim((string) optional($footer_web)->linkedin)],
            ['icon' => 'pbmit-base-icon-instagram', 'title' => 'Instagram', 'url' => trim((string) optional($footer_web)->instgram)],
        ])->filter(function ($item) {
            return !empty($item['url']);
        })->values();
    @endphp

    <section class="sch-section sch-page-hero">
        <div class="container">
            <div class="sch-section-head">
                <h2>{{ __('site.Contact Us') }}</h2>
            </div>
            <div class="sch-page-breadcrumb">
                <a href="{{ Route('website.index') }}">{{ __('site.Aladham') }}</a>
                <span class="sch-page-sep">/</span>
                <span>{{ __('site.Contact Us') }}</span>
            </div>
        </div>
    </section>

    <section class="sch-section contact-modern-section">
        <div class="container">
            <div class="contact-modern-wrap">
                <div class="contact-modern-grid">
                    <aside class="contact-modern-info">
                        <div class="contact-modern-head">
                            <h3>{{ __('site.Get in touch') }}</h3>
                            <p>{{ $contactIntro }}</p>
                        </div>

                        <div class="contact-modern-list">
                            <article class="contact-modern-item">
                                <div class="contact-modern-item-icon"><i class="pbmit-base-icon-location-dot-solid"></i></div>
                                <div class="contact-modern-item-content">
                                    <h4>{{ __('site.Our Location') }}</h4>
                                    <p>{{ $address !== '' ? $address : ($isArabic ? '—' : '—') }}</p>
                                </div>
                            </article>

                            <article class="contact-modern-item">
                                <div class="contact-modern-item-icon"><i class="pbmit-base-icon-phone-volume-solid"></i></div>
                                <div class="contact-modern-item-content">
                                    <h4>{{ __('site.Call us 24/7') }}</h4>
                                    <div class="contact-modern-values">
                                        @forelse($phoneItems as $phoneItem)
                                            @php $telHref = preg_replace('/[^0-9\+]/', '', (string) $phoneItem); @endphp
                                            <a href="{{ $telHref !== '' ? 'tel:' . $telHref : '#' }}">{{ $phoneItem }}</a>
                                        @empty
                                            <span>—</span>
                                        @endforelse
                                    </div>
                                </div>
                            </article>

                            @if(count($whatsAppItems))
                                <article class="contact-modern-item">
                                    <div class="contact-modern-item-icon"><i class="fa fa-whatsapp"></i></div>
                                    <div class="contact-modern-item-content">
                                        <h4>WhatsApp</h4>
                                        <div class="contact-modern-values">
                                            @foreach($whatsAppItems as $whatsAppItem)
                                                @php
                                                    $digits = ltrim(preg_replace('/[^0-9\+]/', '', (string) $whatsAppItem), '+');
                                                    $whatsHref = $digits !== '' ? 'https://wa.me/' . $digits : '#';
                                                @endphp
                                                <a href="{{ $whatsHref }}" target="_blank" rel="noopener">{{ $whatsAppItem }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </article>
                            @endif

                            <article class="contact-modern-item">
                                <div class="contact-modern-item-icon"><i class="pbmit-base-icon-envelope-solid"></i></div>
                                <div class="contact-modern-item-content">
                                    <h4>{{ __('site.Mail us 24/7') }}</h4>
                                    <div class="contact-modern-values">
                                        @if($email !== '')
                                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                                        @else
                                            <span>—</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </div>

                        @if($socialLinks->count())
                            <div class="contact-modern-social">
                                @foreach($socialLinks as $social)
                                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['title'] }}">
                                        <i class="{{ $social['icon'] }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </aside>

                    <div class="contact-modern-form-wrap">
                        <div class="contact-modern-form-head">
                            <h3>{{ __('site.Contact Us') }}</h3>
                            <p>{{ __('site.If you need to message us,please fill out the form') }}</p>
                        </div>

                        <form method="post" class="contact-form contact-modern-form" id="contact-form" action="{{ route('contact_store') }}">
                            @csrf

                            <div class="contact-modern-form-grid">
                                <div class="contact-modern-field">
                                    <label for="contact_name">{{ __('site.Your Name') }}</label>
                                    <input id="contact_name" type="text" class="form-control" placeholder="{{ __('site.Your Name') }}" name="name" value="{{ old('name') }}" required>
                                </div>

                                <div class="contact-modern-field">
                                    <label for="contact_email">{{ __('site.Email Address') }}</label>
                                    <input id="contact_email" type="email" class="form-control" placeholder="{{ __('site.Email Address') }}" name="email" value="{{ old('email') }}" required>
                                </div>

                                <div class="contact-modern-field">
                                    <label for="contact_phone">{{ __('site.Phone Number') }}</label>
                                    <input id="contact_phone" type="text" class="form-control" placeholder="{{ __('site.Phone Number') }}" name="phone" value="{{ old('phone') }}" required>
                                </div>

                                <div class="contact-modern-field">
                                    <label for="contact_subject">{{ __('site.subject') }}</label>
                                    <input id="contact_subject" type="text" class="form-control" placeholder="{{ __('site.subject') }}" name="subject" value="{{ old('subject') }}" required>
                                </div>

                                <div class="contact-modern-field contact-modern-field--full">
                                    <label for="contact_message">{{ __('site.How can we help you? Feel free to get in touch!') }}</label>
                                    <textarea id="contact_message" name="message" rows="7" class="form-control" placeholder="{{ __('site.How can we help you? Feel free to get in touch!') }}" required>{{ old('message') }}</textarea>
                                </div>

                                <div class="contact-modern-field contact-modern-field--full contact-modern-actions">
                                    <button type="submit" class="pbmit-btn contact-modern-submit">
                                        <i class="form-btn-loader fa fa-circle-o-notch fa-spin fa-fw margin-bottom d-none"></i>
                                        <span>{{ __('site.Send Message') }}</span>
                                    </button>
                                </div>

                                <div class="col-md-12 col-lg-12 message-status"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sch-section contact-modern-map-section">
        <div class="container">
            <div class="contact-modern-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1631.337063242067!2d36.70465248532134!3d35.1398048717514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x152483001a15755f%3A0x400defa18d075f2!2z2YXYr9ix2LPYqV_Yp9mE2KfYr9mH2YVf2KfZhNiu2KfYtdip!5e0!3m2!1sen!2suk!4v1724844019498!5m2!1sen!2suk"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
@endsection
