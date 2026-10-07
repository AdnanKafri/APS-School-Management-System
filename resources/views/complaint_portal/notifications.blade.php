@if(isset($notifications) && \App\Services\ComplaintAccess::allows(auth()->user(), 'receive_complaint_notifications'))
<details class="cp-notifications">
    <summary>{{ __('complaint_portal.notifications') }} <span class="cp-badge">{{ $notifications['unread_count'] }}</span></summary>
    <div class="cp-notification-list">
    @forelse($notifications['recent'] as $receipt)
        <form method="POST" action="{{ route('complaint-portal.notifications.open', $receipt->id) }}" class="cp-notice">
            @csrf
            <button class="cp-notification-button">
                <span>@if(!$receipt->read_at)<span class="cp-dot" aria-label="{{ __('complaints.status.new') }}"></span>@endif {{ optional($receipt->complaint)->student_name ?: __('complaints.notifications.new') }} <bdi>#{{ $receipt->complaint_id }}</bdi></span>
                <time>{{ $receipt->created_at->copy()->timezone(config('app.timezone'))->locale('ar')->translatedFormat('j F Y - H:i') }}</time>
            </button>
        </form>
    @empty
        <p class="cp-empty">{{ __('complaints.notifications.empty') }}</p>
    @endforelse
    </div>
</details>
@endif
