@php
    $school = \App\School_data::first();
    $pageTitle = trim($__env->yieldContent('page_title')) ?: 'لوحة التحكم';
    $userName = optional(auth()->user())->name ?: 'Admin';
    $complaintNotifications = $adminComplaintNotificationSummary ?? ['unread_count' => 0, 'recent' => collect()];
@endphp

<header class="v2-navbar">
    <div class="container-fluid v2-navbar-inner">
        <div class="v2-navbar-left">
            <button class="btn btn-sm d-lg-none v2-nav-icon-btn" id="v2-sidebar-toggle" type="button" aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>

            <div class="v2-navbar-brand-block">
                <div class="v2-navbar-brand-ar">{{ optional($school)->name ?? 'لوحة الإدارة' }}</div>
                <div class="v2-navbar-brand-en">{{ optional($school)->name_en ?? 'Admin Interface' }}</div>
            </div>

            <div class="v2-navbar-page d-none d-md-flex">
                <span>{{ $pageTitle }}</span>
            </div>
        </div>

        <div class="v2-navbar-right">
            <form class="v2-navbar-search d-none d-md-flex" action="javascript:void(0);" method="get" role="search">
                <i class="fas fa-search v2-search-icon"></i>
                <input type="text" class="v2-search-input" placeholder="بحث سريع..." aria-label="بحث سريع">
            </form>

            @can('manage_complaints')
                <div class="v2-dd">
                    <button class="btn btn-sm v2-nav-icon-btn v2-notify-btn v2-dd-toggle" type="button" data-dropdown-target="v2-notify-menu" data-poll-url="{{ route('admin.complaints.notifications.poll') }}" aria-expanded="false" aria-haspopup="true" aria-label="{{ __('complaints.notifications.title') }}">
                        <i class="far fa-bell"></i>
                        <span class="v2-notify-badge {{ $complaintNotifications['unread_count'] > 0 ? 'has-count' : '' }}" aria-live="polite">{{ $complaintNotifications['unread_count'] > 99 ? '99+' : ($complaintNotifications['unread_count'] ?: '') }}</span>
                    </button>
                    <div id="v2-notify-menu" class="v2-nav-dropdown v2-notify-dropdown v2-dd-menu" role="menu" aria-hidden="true">
                        <div class="v2-dropdown-head">{{ __('complaints.notifications.title') }}</div>
                        <div data-complaint-notifications-list>
                            @forelse($complaintNotifications['recent'] as $notification)
                                <a class="dropdown-item v2-dropdown-item {{ is_null($notification->read_at) ? 'is-unread' : '' }}" href="{{ route('admin.complaints.notifications.open', $notification->id) }}">
                                    <i class="fas fa-circle v2-item-dot"></i>
                                    <span>{{ __('complaints.notifications.new') }}</span>
                                </a>
                            @empty
                                <span class="dropdown-item v2-dropdown-item v2-notify-empty">{{ __('complaints.notifications.empty') }}</span>
                            @endforelse
                        </div>
                        <a class="dropdown-item v2-dropdown-item v2-notify-all" href="{{ route('admin.complaints.index') }}">{{ __('complaints.notifications.view_all') }}</a>
                    </div>
                </div>
            @endcan

            <div class="v2-dd">
                <button class="btn btn-sm v2-user-btn v2-dd-toggle" type="button" data-dropdown-target="v2-user-menu" aria-expanded="false" aria-haspopup="true">
                    <span class="v2-user-avatar">{{ strtoupper(substr($userName, 0, 1)) }}</span>
                    <span class="v2-user-name">{{ $userName }}</span>
                    <i class="fas fa-chevron-down v2-user-caret"></i>
                </button>
                <div id="v2-user-menu" class="v2-nav-dropdown v2-user-dropdown v2-dd-menu" role="menu" aria-hidden="true">
                    <div class="v2-dropdown-head">الحساب</div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item v2-dropdown-item">
                            <i class="fas fa-sign-out-alt"></i>
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
