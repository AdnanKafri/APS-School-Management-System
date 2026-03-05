@extends('website.layouts.header')


@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">



        <!-- Title Bar -->
        <div class="pbmit-title-bar-wrapper">
            <div class="container">
                <div class="pbmit-title-bar-content">
                    <div class="pbmit-title-bar-content-inner">
                        <div class="pbmit-tbar">
                            <div class="pbmit-tbar-inner container">
                                <h1 class="pbmit-tbar-title">{{ __('site.Contact Us') }}</h1>
                            </div>
                        </div>
                        <div class="pbmit-breadcrumb">
                            <div class="pbmit-breadcrumb-inner">
                                <span><a title="" href="#"
                                        class="home"><span>{{ __('site.Aladham') }}</span></a></span>
                                <span class="sep">
                                    <i class="pbmit-base-icon-angle-double-right"></i>
                                </span>
                                <span><span
                                        class="post-root post post-post current-item">{{ __('site.Contact Us') }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Title Bar End-->

        <!-- Contact Us Content -->
        <div class="page-content contact-us">

            <!-- Ihbox -->
            <section class="section-lg ihbox-section pbmit-column-three">
                <div class="container">
                    <div class="row" @if (LaravelLocalization::setLocale() == 'ar') style="direction: rtl; text-align: right" @endif>
                        <div class="col-md-6 col-xl-4">
                            <div class="pbmit-ihbox-style-2">
                                <div class="pbmit-ihbox-headingicon">
                                    <div class="pbmit-ihbox-icon">
                                        <div class="pbmit-ihbox-icon-wrapper">
                                            <div class="pbmit-icon-wrapper pbmit-icon-type-icon">
                                                <i class="pbmit-kidzieo-icon pbmit-kidzieo-icon-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbmit-ihbox-contents">
                                        <h2 class="pbmit-element-title">{{ __('site.Mail us 24/7') }}</h2>
                                        <div class="pbmit-heading-desc">
                                            <a href="mailto:{{ $footer_web->email }}">
                                                <i class=""></i><span>{{ $footer_web->email }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="pbmit-ihbox-style-2">
                                <div class="pbmit-ihbox-headingicon">
                                    <div class="pbmit-ihbox-icon">
                                        <div class="pbmit-ihbox-icon-wrapper">
                                            <div class="pbmit-icon-wrapper pbmit-icon-type-icon">
                                                <i class="pbmit-kidzieo-icon pbmit-kidzieo-icon-maps-and-flags"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbmit-ihbox-contents">
                                        <h2 class="pbmit-element-title">{{ __('site.Our Location') }}</h2>
                                        <div class="pbmit-heading-desc">{{ $footer_web->address }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="pbmit-ihbox-style-2">
                                <div class="pbmit-ihbox-headingicon">
                                    <div class="pbmit-ihbox-icon">
                                        <div class="pbmit-ihbox-icon-wrapper">
                                            <div class="pbmit-icon-wrapper pbmit-icon-type-icon">
                                                <i class="pbmit-kidzieo-icon pbmit-kidzieo-icon-call"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbmit-ihbox-contents">
                                        <h2 class="pbmit-element-title">{{ __('site.Call us 24/7') }}</h2>
                                        <div class="pbmit-heading-desc">{{ $footer_web->phone }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Ihbox End -->

            <!-- Contact Form -->
            <section>
                <div class="container">
                    <div class="row g-0" @if (LaravelLocalization::setLocale() == 'ar') style="direction: rtl; text-align: right" @endif>
                        <div class="col-md-6 contact-col-1">
                            <div class="contact-form-leftbox">
                                <div class="pbmit-heading-subheading">
                                    <h4 class="pbmit-subtitle">{{ __('site.Get in touch') }}</h4>
                                    <h2 class="">
                                        {{ __('site.If you need to message us,please fill out the form') }}</h2>

                                </div>
                                <form method="post" class="contact-form" id="contact-form"
                                    action="{{ route('contact_store') }}">

                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control"
                                                placeholder="{{ __('site.Your Name') }}" name="name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control"
                                                placeholder="{{ __('site.Email Address') }}" name="email" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control"
                                                placeholder="{{ __('site.Phone Number') }}" name="phone" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control"
                                                placeholder="{{ __('site.subject') }}" name="subject" required>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="message" cols="40" rows="10" class="form-control"
                                                placeholder="{{ __('site.How can we help you? Feel free to get in touch!') }}" required></textarea>
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="pbmit-btn">
                                                <i
                                                    class="form-btn-loader fa fa-circle-o-notch fa-spin fa-fw margin-bottom d-none"></i>
                                                <span>{{ __('site.Send Message') }}</span>
                                            </button>
                                        </div>
                                        <div class="col-md-12 col-lg-12 message-status"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 contact-col-2">
                            <div class="contact-form-rightbox">
                                <div class="pbmit-img-animation-01 contact-pattern-02-img">
                                    <img src="images/contact-pattern-02.png" alt="">
                                </div>
                                <div class="pbmit-heading">
                                    <h3>School working Hours</h3>
                                </div>
                                <article class="pbmit-miconheading-style-8">
                                    <div class="pbmit-ihbox-style-8">
                                        <div class="pbmit-ihbox-box">
                                            <div class="pbmit-ihbox-inner">
                                                <div class="pbmit-ihbox-wrap">
                                                    <h2 class="pbmit-element-title"> Monday </h2>
                                                </div>
                                                <div class="pbmit-content-wrap">
                                                    <h4 class="pbmit-element-subtitle"> 09:00 am </h4>
                                                    <div class="pbmit-heading-desc">19:00 pm</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="pbmit-miconheading-style-8">
                                    <div class="pbmit-ihbox-style-8">
                                        <div class="pbmit-ihbox-box">
                                            <div class="pbmit-ihbox-inner">
                                                <div class="pbmit-ihbox-wrap">
                                                    <h2 class="pbmit-element-title"> Tuesday </h2>
                                                </div>
                                                <div class="pbmit-content-wrap">
                                                    <h4 class="pbmit-element-subtitle"> 09:00 am </h4>
                                                    <div class="pbmit-heading-desc">19:00 pm</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="pbmit-miconheading-style-8">
                                    <div class="pbmit-ihbox-style-8">
                                        <div class="pbmit-ihbox-box">
                                            <div class="pbmit-ihbox-inner">
                                                <div class="pbmit-ihbox-wrap">
                                                    <h2 class="pbmit-element-title"> Wednesday </h2>
                                                </div>
                                                <div class="pbmit-content-wrap">
                                                    <h4 class="pbmit-element-subtitle"> 09:00 am </h4>
                                                    <div class="pbmit-heading-desc">19:00 pm</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="pbmit-miconheading-style-8">
                                    <div class="pbmit-ihbox-style-8">
                                        <div class="pbmit-ihbox-box">
                                            <div class="pbmit-ihbox-inner">
                                                <div class="pbmit-ihbox-wrap">
                                                    <h2 class="pbmit-element-title"> Thursday </h2>
                                                </div>
                                                <div class="pbmit-content-wrap">
                                                    <h4 class="pbmit-element-subtitle"> 09:00 am </h4>
                                                    <div class="pbmit-heading-desc">19:00 pm</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="pbmit-miconheading-style-8">
                                    <div class="pbmit-ihbox-style-8">
                                        <div class="pbmit-ihbox-box">
                                            <div class="pbmit-ihbox-inner">
                                                <div class="pbmit-ihbox-wrap">
                                                    <h2 class="pbmit-element-title"> Friday </h2>
                                                </div>
                                                <div class="pbmit-content-wrap">
                                                    <h4 class="pbmit-element-subtitle"> 09:00 am </h4>
                                                    <div class="pbmit-heading-desc">19:00 pm</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="pbmit-miconheading-style-8">
                                    <div class="pbmit-ihbox-style-8">
                                        <div class="pbmit-ihbox-box">
                                            <div class="pbmit-ihbox-inner">
                                                <div class="pbmit-ihbox-wrap">
                                                    <h2 class="pbmit-element-title"> Saturday </h2>
                                                </div>
                                                <div class="pbmit-content-wrap">
                                                    <h4 class="pbmit-element-subtitle"> 09:00 am </h4>
                                                    <div class="pbmit-heading-desc">19:00 pm</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article class="pbmit-miconheading-style-8">
                                    <div class="pbmit-ihbox-style-8">
                                        <div class="pbmit-ihbox-box">
                                            <div class="pbmit-ihbox-inner">
                                                <div class="pbmit-ihbox-wrap">
                                                    <h2 class="pbmit-element-title"> Sunday </h2>
                                                </div>
                                                <div class="pbmit-content-wrap">
                                                    <div class="pbmit-heading-desc">Closed*</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </section>
            <!-- Contact Form -->

            <!-- Client Start -->
            {{-- <section class="client_one">
                <div class="container-fluid p-0">
                    <div class="swiper-slider" data-loop="true" data-autoplay="true" data-dots="false" data-arrows="false"
                        data-columns="6" data-margin="0" data-effect="slide">
                        <div class="swiper-wrapper">
                            <!-- Slide1 -->
                            <div class="swiper-slide">
                                <article class="pbmit-client-style-1">
                                    <div class="pbmit-border-wrapper text-align-center">
                                        <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
                                            <h4 class="pbmit-hide">Client 09</h4>
                                            <div class="pbmit-client-hover-img">
                                                <img src="images/client/cleint-01-black.png" alt="">
                                            </div>
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/client/cleint-01-global.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <!-- Slide2 -->
                            <div class="swiper-slide">
                                <article class="pbmit-client-style-1">
                                    <div class="pbmit-border-wrapper text-align-center">
                                        <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
                                            <h4 class="pbmit-hide">Client 09</h4>
                                            <div class="pbmit-client-hover-img">
                                                <img src="images/client/cleint-02-black.png" alt="">
                                            </div>
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/client/cleint-02-global.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <!-- Slide3 -->
                            <div class="swiper-slide">
                                <article class="pbmit-client-style-1">
                                    <div class="pbmit-border-wrapper text-align-center">
                                        <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
                                            <h4 class="pbmit-hide">Client 09</h4>
                                            <div class="pbmit-client-hover-img">
                                                <img src="images/client/cleint-03-black.png" alt="">
                                            </div>
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/client/cleint-03-global.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <!-- Slide4 -->
                            <div class="swiper-slide">
                                <article class="pbmit-client-style-1">
                                    <div class="pbmit-border-wrapper text-align-center">
                                        <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
                                            <h4 class="pbmit-hide">Client 09</h4>
                                            <div class="pbmit-client-hover-img">
                                                <img src="images/client/cleint-04-black.png" alt="">
                                            </div>
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/client/cleint-04-global.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <!-- Slide5 -->
                            <div class="swiper-slide">
                                <article class="pbmit-client-style-1">
                                    <div class="pbmit-border-wrapper text-align-center">
                                        <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
                                            <h4 class="pbmit-hide">Client 09</h4>
                                            <div class="pbmit-client-hover-img">
                                                <img src="images/client/cleint-05-black.png" alt="">
                                            </div>
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/client/cleint-05-global.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <!-- Slide6 -->
                            <div class="swiper-slide">
                                <article class="pbmit-client-style-1">
                                    <div class="pbmit-border-wrapper text-align-center">
                                        <div class="pbmit-client-wrapper pbmit-client-with-hover-img">
                                            <h4 class="pbmit-hide">Client 09</h4>
                                            <div class="pbmit-client-hover-img">
                                                <img src="images/client/cleint-06-black.png" alt="">
                                            </div>
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/client/cleint-06-global.png" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                    <div class="fid-style-4_area">
                        <div class="pbminfotech-ele-fid-style-4">
                            <div class="pbmit-fld-contents">
                                <h4 class="pbmit-fid-inner">
                                    <span class="pbmit-fid-before"></span>
                                    <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits"
                                        data-from="0" data-to="25" data-interval="5" data-before=""
                                        data-before-style="" data-after="" data-after-style="">25</span>
                                    <span class="pbmit-fid"><span>+</span></span>
                                </h4>
                                <h3 class="pbmit-fid-title">Kidschool community partnerships</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}
            <!-- Client End -->

            <!-- Iframe -->
            <section class="iframe-section">
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1631.337063242067!2d36.70465248532134!3d35.1398048717514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x152483001a15755f%3A0x400defa18d075f2!2z2YXYr9ix2LPYqV_Yp9mE2KfYr9mH2YVf2KfZhNiu2KfYtdip!5e0!3m2!1sen!2suk!4v1724844019498!5m2!1sen!2suk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </section>
            <!-- Iframe End-->

        </div>
        <!-- Contact Us Content End -->



    </div>
    <!-- Page Wrapper End -->

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
@endsection
