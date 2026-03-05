@php
    $locale = app()->getLocale();
    $isRtl = strpos((string) $locale, 'ar') === 0;
@endphp
<!DOCTYPE html>
<html lang="{{ $isRtl ? 'ar' : $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    @php
        $school_data = \App\School_data::first();
    @endphp
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ optional($school_data)->name_en ?? config('app.name') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --v2-primary: #5B4B8A;
            --v2-accent: #1f9d6b;
            --v2-bg: #f6f7fa;
            --v2-surface: #ffffff;
            --v2-text: #2f2b3a;
            --v2-muted: #8a869a;
            --v2-border: #e9e8ef;
            --v2-hover: rgba(91, 75, 138, 0.08);
            --v2-active: rgba(91, 75, 138, 0.12);
            --v2-sidebar-w: 286px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background: var(--v2-bg);
            color: var(--v2-text);
            overflow-x: hidden;
            direction: rtl;
            text-align: right;
        }
        html[dir="ltr"] body {
            direction: ltr;
            text-align: left;
        }

        .v2-shell {
            min-height: 100vh;
        }

        .v2-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: var(--v2-sidebar-w);
            height: 100vh;
            background:
                linear-gradient(to bottom, rgba(59,130,246,0.05), transparent 22%),
                #fff;
            color: var(--v2-text);
            z-index: 1040;
            border-left: 1px solid var(--v2-border);
            box-shadow:
                0 10px 26px rgba(36, 30, 62, .08),
                inset 0 0 20px rgba(0,0,0,.02);
            transition: transform .28s ease;
            display: flex;
            flex-direction: column;
        }
        [dir="ltr"] .v2-sidebar {
            right: auto;
            left: 0;
            border-left: 0;
            border-right: 1px solid var(--v2-border);
        }

        .v2-sidebar-brand {
            padding: 1rem 1rem .85rem;
            border-bottom: 1px solid var(--v2-border);
        }

        .v2-sidebar-menu {
            overflow-y: auto;
            flex: 1;
            padding: .7rem .6rem .95rem;
        }

        .v2-menu-title {
            color: rgba(47, 43, 58, .52);
            font-size: .68rem;
            font-weight: 700;
            margin: 1.1rem .7rem .5rem;
            letter-spacing: .04em;
            text-align: start;
        }

        .v2-menu-group {
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }

        .v2-menu-link {
            border: 0;
            width: 100%;
            text-align: right;
            color: #403b52;
            background: transparent;
            border-radius: 12px;
            padding: 12px 16px;
            min-height: 48px;
            display: flex;
            flex-direction: row;
            align-items: center;
            text-decoration: none;
            transition: all .2s ease;
            font-size: .95rem;
            font-weight: 600;
            gap: .6rem;
            direction: rtl;
            will-change: transform;
        }
        html[dir="ltr"] .v2-menu-link {
            text-align: left;
            direction: ltr;
        }

        .v2-menu-link span {
            order: 1;
            flex: 1;
            line-height: 1.2;
        }

        .v2-menu-link i:first-child {
            order: 2;
            width: 28px;
            height: 28px;
            flex: 0 0 28px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            line-height: 1;
            text-align: center;
            color: #3B82F6;
            background: rgba(59,130,246,.10);
            margin-inline-start: .2rem;
            transition: all .2s ease;
        }

        .v2-menu-link:hover {
            text-decoration: none;
            color: #2f2b3a;
            background: rgba(59,130,246,0.05);
            transform: translateX(-3px);
        }
        html[dir="ltr"] .v2-menu-link:hover {
            transform: translateX(3px);
        }

        .v2-menu-link.active {
            color: #2f2b3a;
            background: rgba(59,130,246,0.08);
            border-inline-start: 4px solid #3B82F6;
            font-weight: 700;
        }
        .v2-menu-link:hover i:first-child,
        .v2-menu-link.active i:first-child {
            background: rgba(59,130,246,.18);
            color: #2563eb;
        }

        .v2-sub-link {
            color: #55506a;
            text-decoration: none;
            font-size: .86rem;
            margin: .12rem .35rem;
            padding: .5rem 1rem;
            border-radius: 10px;
            display: block;
            transition: all .2s ease;
            text-align: right;
            min-height: 40px;
        }
        html[dir="ltr"] .v2-sub-link {
            text-align: left;
        }

        .v2-sub-link:hover,
        .v2-sub-link.active {
            color: #2f2b3a;
            background: rgba(59,130,246,0.05);
            text-decoration: none;
        }

        .v2-submenu {
            padding-inline-start: 1.35rem;
            padding-inline-end: .2rem;
        }
        .v2-submenu.collapse,
        .v2-submenu.collapsing {
            transition: height .24s ease;
        }

        .v2-menu-toggle .fa-chevron-down {
            order: 3;
            transition: transform .22s ease;
            margin-inline-start: auto;
            margin-inline-end: 0;
        }
        .v2-menu-toggle[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
        }

        .v2-main {
            margin-right: var(--v2-sidebar-w);
            min-height: 100vh;
            transition: margin-right .28s ease;
        }
        [dir="ltr"] .v2-main {
            margin-right: 0;
            margin-left: var(--v2-sidebar-w);
            transition: margin-left .28s ease;
        }

        .v2-navbar {
            position: sticky;
            top: 0;
            z-index: 1060;
            background: #fff;
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            overflow: visible;
        }

        .v2-navbar-inner {
            min-height: 70px;
            padding: .7rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
        }

        .v2-navbar-left,
        .v2-navbar-right {
            display: flex;
            align-items: center;
            gap: .6rem;
            min-width: 0;
            overflow: visible;
        }

        .v2-navbar-brand-block {
            line-height: 1.15;
            min-width: 0;
        }

        .v2-navbar-brand-ar {
            font-weight: 800;
            color: #2f2b3a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 240px;
        }

        .v2-navbar-brand-en {
            color: #8a869a;
            font-size: .78rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 240px;
        }

        .v2-navbar-page {
            margin-inline-start: .35rem;
            padding-inline-start: .75rem;
            position: relative;
            color: #4a4760;
            font-weight: 700;
            font-size: .92rem;
            white-space: nowrap;
        }

        .v2-navbar-page::after {
            content: "";
            position: absolute;
            inset-inline-start: .75rem;
            inset-block-end: -8px;
            width: 28px;
            height: 2px;
            border-radius: 20px;
            background: #3B82F6;
            opacity: .9;
        }

        .v2-navbar .btn,
        .v2-search-input {
            transition: all .2s ease;
        }

        .v2-navbar .btn:hover {
            transform: translateY(-1px);
        }

        .v2-nav-icon-btn {
            width: 38px;
            height: 38px;
            border: 1px solid rgba(59,130,246,.18);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(59,130,246,.08);
            color: #3B82F6;
            padding: 0;
        }

        .v2-nav-icon-btn:hover {
            background: rgba(59,130,246,.15);
            border-color: rgba(59,130,246,.32);
            color: #2563eb;
        }

        .v2-navbar-search {
            position: relative;
            width: min(320px, 38vw);
        }

        .v2-search-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            inset-inline-start: .72rem;
            color: #8a869a;
            font-size: .86rem;
            pointer-events: none;
        }

        .v2-search-input {
            width: 100%;
            height: 40px;
            border: 1px solid rgba(59,130,246,.16);
            border-radius: 999px;
            background: #f9fbff;
            color: #2f2b3a;
            padding-inline-start: 2rem;
            padding-inline-end: .9rem;
            font-size: .9rem;
            outline: none;
        }

        .v2-search-input::placeholder {
            color: #9c98ad;
        }

        .v2-search-input:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
            background: #fff;
        }

        .v2-notify-btn {
            position: relative;
        }

        .v2-notify-badge {
            position: absolute;
            top: 7px;
            inset-inline-end: 8px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #3B82F6;
            box-shadow: 0 0 0 2px #fff;
        }

        .v2-user-btn {
            height: 40px;
            border: 1px solid rgba(59,130,246,.2);
            border-radius: 12px;
            background: rgba(59,130,246,.08);
            color: #2f2b3a;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: 0 .65rem 0 .45rem;
        }

        .v2-user-btn:hover {
            background: rgba(59,130,246,.14);
            border-color: rgba(59,130,246,.35);
            color: #2f2b3a;
        }

        .v2-user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(59,130,246,.16);
            color: #2563eb;
            font-weight: 800;
            font-size: .8rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 28px;
        }

        .v2-user-name {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .v2-user-caret {
            font-size: .72rem;
            color: #7e7a91;
            transition: transform .2s ease;
        }

        .v2-dd.open > .v2-user-btn .v2-user-caret {
            transform: rotate(180deg);
        }

        .v2-dd {
            position: relative;
            overflow: visible;
        }

        .v2-nav-dropdown {
            min-width: 230px;
            max-width: calc(100vw - 20px);
            position: fixed;
            top: 0;
            left: 0;
            border: 1px solid rgba(59,130,246,.15);
            border-radius: 12px;
            box-shadow: 0 12px 26px rgba(17,24,39,.10);
            padding: .45rem;
            background: #fff;
            transform-origin: top center;
            z-index: 1200;
            opacity: 0;
            transform: translate3d(0, -6px, 0);
            pointer-events: none;
            visibility: hidden;
            transition: opacity .2s ease, transform .2s ease, visibility .2s ease;
        }

        .v2-dd.open > .v2-nav-dropdown {
            opacity: 1;
            transform: translate3d(0, 0, 0);
            pointer-events: auto;
            visibility: visible;
        }

        .v2-nav-dropdown.v2-drop-up {
            transform: translate3d(0, 6px, 0);
            transform-origin: bottom center;
        }
        .v2-dd.open > .v2-nav-dropdown.v2-drop-up {
            transform: translate3d(0, 0, 0);
        }

        .v2-dropdown-head {
            font-size: .75rem;
            color: #8a869a;
            font-weight: 700;
            padding: .35rem .55rem .45rem;
        }

        .v2-dropdown-item {
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: .5rem;
            min-height: 38px;
            color: #3d3950;
            font-size: .9rem;
            transition: all .2s ease;
            white-space: normal;
        }

        .v2-dropdown-item:hover,
        .v2-dropdown-item:focus {
            background: rgba(59,130,246,.08);
            color: #1f2937;
        }

        .v2-item-dot {
            font-size: .45rem;
            color: #3B82F6;
        }

        .v2-nav-dropdown::before {
            content: "";
            position: absolute;
            top: -6px;
            left: var(--v2-arrow-x, 20px);
            width: 10px;
            height: 10px;
            background: #fff;
            border-top: 1px solid rgba(59,130,246,.15);
            border-left: 1px solid rgba(59,130,246,.15);
            transform: rotate(45deg);
        }

        .v2-nav-dropdown.v2-drop-up::before {
            top: auto;
            bottom: -6px;
            border-top: 0;
            border-left: 0;
            border-bottom: 1px solid rgba(59,130,246,.15);
            border-right: 1px solid rgba(59,130,246,.15);
        }

        @media (max-width: 992px) {
            .v2-navbar-inner {
                min-height: 62px;
                padding: .6rem .75rem;
            }

            .v2-navbar-brand-en,
            .v2-navbar-page {
                display: none !important;
            }

            .v2-navbar-right {
                margin-inline-start: auto;
            }

            .v2-user-name {
                max-width: 90px;
            }

            .v2-nav-dropdown {
                min-width: 210px;
            }
        }

        .v2-content-wrap {
            padding: 1rem 1rem 1.2rem;
        }

        .v2-card {
            background: var(--v2-surface);
            border: 1px solid var(--v2-border);
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(36, 30, 62, .05);
        }

        .breadcrumbs {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }

        .breadcrumbs__item {
            text-decoration: none;
            color: var(--v2-text);
            font-weight: 700;
        }

        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(25, 17, 57, .35);
            z-index: 1035;
            display: none;
        }

        .v2-shell.sidebar-open .sidebar-backdrop {
            display: block;
        }

        @media (max-width: 992px) {
            .v2-sidebar {
                transform: translateX(100%);
            }
            [dir="ltr"] .v2-sidebar {
                transform: translateX(-100%);
            }

            .v2-main {
                margin-right: 0;
            }
            [dir="ltr"] .v2-main {
                margin-left: 0;
            }

            .v2-shell.sidebar-open .v2-sidebar {
                transform: translateX(0);
            }
        }
    </style>

    @yield('style')
</head>
<body class="{{ $isRtl ? 'is-rtl' : 'is-ltr' }}">
    <div class="v2-shell" id="v2-shell">
        @include('admin.components.sidebar')

        <div class="v2-main">
            @include('admin.components.navbar')

            <div class="v2-content-wrap">
                @include('admin.components.page-header')
                @yield('content')
            </div>
        </div>

        <div class="sidebar-backdrop" id="sidebar-backdrop"></div>
    </div>

    <script src="{{ asset('assets/admin/plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/toastr/js/toastr.init.js') }}"></script>

    <script>
        (function() {
            var shell = document.getElementById('v2-shell');
            var toggle = document.getElementById('v2-sidebar-toggle');
            var close = document.getElementById('v2-sidebar-close');
            var backdrop = document.getElementById('sidebar-backdrop');
            var dropdowns = Array.prototype.slice.call(document.querySelectorAll('.v2-dd'));

            function openSidebar() { shell.classList.add('sidebar-open'); }
            function closeSidebar() { shell.classList.remove('sidebar-open'); }
            function clamp(value, min, max) {
                return Math.min(Math.max(value, min), max);
            }
            function positionDropdown(dd) {
                var btn = dd.querySelector('.v2-dd-toggle');
                var panel = dd.querySelector('.v2-dd-menu');
                if (!btn || !panel) {
                    return;
                }

                var gap = 8;
                var viewportMargin = 10;
                var viewportW = document.documentElement.clientWidth;
                var viewportH = window.innerHeight || document.documentElement.clientHeight;
                var isRtl = (document.documentElement.getAttribute('dir') || 'rtl').toLowerCase() === 'rtl';
                var btnRect = btn.getBoundingClientRect();

                panel.classList.remove('v2-drop-up');
                panel.style.left = '0px';
                panel.style.top = '0px';

                var panelRect = panel.getBoundingClientRect();
                var panelW = panelRect.width;
                var panelH = panelRect.height;

                if (panelW > (viewportW - viewportMargin * 2)) {
                    panelW = viewportW - viewportMargin * 2;
                    panel.style.width = panelW + 'px';
                } else {
                    panel.style.width = '';
                }

                var preferredLeft = isRtl ? (btnRect.right - panelW) : btnRect.left;
                var left = clamp(preferredLeft, viewportMargin, viewportW - panelW - viewportMargin);

                var top = btnRect.bottom + gap;
                if ((top + panelH) > (viewportH - viewportMargin)) {
                    var upwardTop = btnRect.top - panelH - gap;
                    if (upwardTop >= viewportMargin) {
                        top = upwardTop;
                        panel.classList.add('v2-drop-up');
                    } else {
                        top = clamp(top, viewportMargin, viewportH - panelH - viewportMargin);
                    }
                }

                var arrowX = clamp((btnRect.left + (btnRect.width / 2)) - left - 5, 10, panelW - 20);
                panel.style.setProperty('--v2-arrow-x', arrowX + 'px');
                panel.style.left = left + 'px';
                panel.style.top = top + 'px';
            }
            function repositionOpenDropdowns() {
                dropdowns.forEach(function(dd) {
                    if (dd.classList.contains('open')) {
                        positionDropdown(dd);
                    }
                });
            }
            function closeAllDropdowns(exceptEl) {
                dropdowns.forEach(function(dd) {
                    if (exceptEl && dd === exceptEl) {
                        return;
                    }
                    dd.classList.remove('open');
                    var btn = dd.querySelector('.v2-dd-toggle');
                    var panel = dd.querySelector('.v2-dd-menu');
                    if (btn) {
                        btn.setAttribute('aria-expanded', 'false');
                    }
                    if (panel) {
                        panel.setAttribute('aria-hidden', 'true');
                        panel.classList.remove('v2-drop-up');
                    }
                });
            }

            if (toggle) toggle.addEventListener('click', openSidebar);
            if (close) close.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            dropdowns.forEach(function(dd) {
                var btn = dd.querySelector('.v2-dd-toggle');
                var panel = dd.querySelector('.v2-dd-menu');
                if (!btn || !panel) {
                    return;
                }
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var willOpen = !dd.classList.contains('open');
                    closeAllDropdowns(dd);
                    dd.classList.toggle('open', willOpen);
                    btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                    panel.setAttribute('aria-hidden', willOpen ? 'false' : 'true');
                    if (willOpen) {
                        positionDropdown(dd);
                    }
                });
                panel.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            document.addEventListener('click', function() {
                closeAllDropdowns();
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllDropdowns();
                }
            });
            window.addEventListener('resize', repositionOpenDropdowns);
            window.addEventListener('scroll', repositionOpenDropdowns, true);

            @if (Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif
            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif
        })();
    </script>

    @yield('js')
</body>
</html>
