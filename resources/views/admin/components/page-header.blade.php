@php
    $hidePageHeader = in_array(trim($__env->yieldContent('hide_page_header')), ['1', 'true'], true);
    $pageTitle = trim($__env->yieldContent('page_title')) ?: 'لوحة التحكم';
    $pageSubtitle = trim($__env->yieldContent('page_subtitle')) ?: 'نظام إدارة المدرسة';
@endphp

@if (! $hidePageHeader)
    <div class="v2-card mb-3">
        <div class="px-3 py-2 py-md-3 d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h5 class="mb-0" style="font-weight:800;color:#2f2b3a;">{{ $pageTitle }}</h5>
                @if ($pageSubtitle)
                    <small style="color:#8a869a;">{{ $pageSubtitle }}</small>
                @endif
            </div>
            <div class="mt-2 mt-md-0">
                @yield('breadcrumbs')
            </div>
        </div>
    </div>
@endif
