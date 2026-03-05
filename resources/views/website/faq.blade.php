{{-- <!doctype html>
<html class="no-js" lang="en">
   
<!-- Mirrored from kidzieo-demo.pbminfotech.com/html-demo/faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Apr 2024 10:18:50 GMT -->
<head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>Faq – Kidzieo Demo 01 HTML Template</title>
      <meta name="robots" content="noindex, follow">
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Favicon -->
      <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
      <!-- CSS
         ============================================ -->
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- Fontawesome -->
      <link rel="stylesheet" href="css/fontawesome.css">
      <!-- Flaticon -->
      <link rel="stylesheet" href="css/flaticon.css">
      <!-- Base Icons -->
      <link rel="stylesheet" href="css/pbminfotech-base-icons.css">
      <!-- Themify Icons -->
      <link rel="stylesheet" href="css/themify-icons.css">
      <!-- Slick -->
      <link rel="stylesheet" href="css/swiper.min.css">
      <!-- Magnific -->
      <link rel="stylesheet" href="css/magnific-popup.css">
      <!-- AOS -->
      <link rel="stylesheet" href="css/aos.css">
      <!-- Shortcode CSS -->
      <link rel="stylesheet" href="css/shortcode.css">
      <!-- Base CSS -->
      <link rel="stylesheet" href="css/base.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="css/responsive.css">
   </head>
   <body> --}}
@extends('website.layouts.header')


@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Header Main Area -->

        <!-- Header Main Area End Here -->

        <!-- Title Bar -->
        <div class="pbmit-title-bar-wrapper">
            <div class="container">
                <div class="pbmit-title-bar-content">
                    <div class="pbmit-title-bar-content-inner">
                        <div class="pbmit-tbar">
                            <div class="pbmit-tbar-inner container">
                                <h1 class="pbmit-tbar-title"> {{ __('site.Faq') }}</h1>
                            </div>
                        </div>
                        <div class="pbmit-breadcrumb">
                            <div class="pbmit-breadcrumb-inner">
                                <span><a title="" href="#"
                                        class="home"><span>{{ __('site.Aladham') }}</span></a></span>
                                <span class="sep">
                                    <i class="pbmit-base-icon-angle-double-right"></i>
                                </span>
                                <span><span class="post-root post post-post current-item">
                                        {{ __('site.Faq') }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Title Bar End-->

        <!-- Page Content -->
        <div class="page-content">

            <!-- Faq Start -->
            <section class="section-lg">
                <div class="container">
                    <div class="faq-bg-area">

                        <div class="pt-5">
                            <div class="pbmit-heading-subheading text-center">
                                <h2 class="">{{ __('site.Frequently Asked Questions') }}</h2>
                                <div class="pbmit-heading-desc">
                                    {{ __('site.Help your business respond to the needs of your technologies specialists more quickly and appropriately ') }}<br>
                                    {{ __("site.Please feel free to contact us if you don't get your question's answer in below.") }}
                                </div>
                            </div>
                            <div class="accordion accordion-style-1" id="accordionExample2">
                                @foreach ($faqs as $index => $item)
                                    <div class="accordion-item "
                                        @if (LaravelLocalization::setLocale() == 'ar') style="direction: rtl; text-align: right" @endif>
                                        <h2 class="accordion-header" id="heading0{{ $index }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse0{{ $index }}"
                                                aria-expanded="false" aria-controls="collapse0{{ $index }}">
                                                <span class="pbmit-accordion-icon">
                                                    <span class="pbmit-accordion-icon-closed">
                                                        <i class="fa fa-plus"></i>
                                                    </span>
                                                    <span class="pbmit-accordion-icon-opened">
                                                        <i class="fa fa-minus"></i>
                                                    </span>
                                                </span>
                                                <span class="pbmit-accordion-title">
                                                    {{ $item->title }}
                                                </span>
                                            </button>
                                        </h2>
                                        <div id="collapse0{{ $index }}" class="accordion-collapse collapse "
                                            aria-labelledby="heading0{{ $index }}"
                                            data-bs-parent="#accordionExample2">
                                            <div class="accordion-body">
                                                {{ $item->description }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Faq End -->

        </div>
        <!-- Page Content End -->


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

{{-- <!-- JS
        ============================================ -->
	<!-- jQuery JS -->
	<script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="js/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="js/bootstrap.min.js"></script>
	<!-- jquery Waypoints JS -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- jquery Appear JS -->
	<script src="js/jquery.appear.js"></script>
	<!-- Numinate JS -->
	<script src="js/numinate.min.js"></script>
	<!-- Slick JS -->
	<script src="js/swiper.min.js"></script>
	<!-- Magnific JS -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<!-- Circle Progress JS -->
	<script src="js/circle-progress.js"></script> 
	<!-- countdown JS -->
	<script src="js/jquery.countdown.min.js"></script> 
	<!-- AOS -->
	<script src="js/aos.js"></script>
	<!-- GSAP -->
	<script src='js/gsap.js'></script>
	<!-- Scroll Trigger -->
	<script src='js/ScrollTrigger.js'></script>
	<!-- Split Text -->
	<script src='js/SplitText.js'></script>
	<!-- Magnetic -->
	<script src='js/magnetic.js'></script>
	<!-- GSAP Animation -->
	<script src='js/gsap-animation.js'></script>
	<!-- Scripts JS -->
	<script src="js/scripts.js"></script>

   <script>(function(){if (!document.body) return;var js = "window['__CF$cv$params']={r:'86e0114a4f8c9f78',t:'MTcxMjA1MzAyOS42MDIwMDA='};_cpo=document.createElement('script');_cpo.nonce='',_cpo.src='../cdn-cgi/challenge-platform/h/g/scripts/jsd/dc6b543c1346/main.js',document.getElementsByTagName('head')[0].appendChild(_cpo);";var _0xh = document.createElement('iframe');_0xh.height = 1;_0xh.width = 1;_0xh.style.position = 'absolute';_0xh.style.top = 0;_0xh.style.left = 0;_0xh.style.border = 'none';_0xh.style.visibility = 'hidden';document.body.appendChild(_0xh);function handler() {var _0xi = _0xh.contentDocument || _0xh.contentWindow.document;if (_0xi) {var _0xj = _0xi.createElement('script');_0xj.innerHTML = js;_0xi.getElementsByTagName('head')[0].appendChild(_0xj);}}if (document.readyState !== 'loading') {handler();} else if (window.addEventListener) {document.addEventListener('DOMContentLoaded', handler);} else {var prev = document.onreadystatechange || function () {};document.onreadystatechange = function (e) {prev(e);if (document.readyState !== 'loading') {document.onreadystatechange = prev;handler();}};}})();</script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"86e0114a4f8c9f78","version":"2024.3.0","r":1,"token":"125856bf84ab44059737e93b01aa0fef","b":1}' crossorigin="anonymous"></script>
</body>

<!-- Mirrored from kidzieo-demo.pbminfotech.com/html-demo/faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Apr 2024 10:18:50 GMT -->
</html> --}}
