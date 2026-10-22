<div class="sfu-evaluation">
    <div class="sfu-evaluation-rating">
        <span class="sfu-evaluation-label">{{ __('student_follow_up_admin.level') }}</span>
        <strong>{{ $followUp->level ? __('student_follow_up.levels.' . $followUp->level) : __('student_follow_up_admin.no_rating') }}</strong>
    </div>
    <div class="sfu-evaluation-note">
        <span class="sfu-evaluation-label">{{ __('student_follow_up_admin.note') }}</span>
        @if($followUp->note !== null && trim($followUp->note) !== '')
            <p class="sfu-note">{{ $followUp->note }}</p>
        @else
            <p class="sfu-note sfu-evaluation-muted">{{ __('student_follow_up_admin.no_evaluation_note') }}</p>
        @endif
    </div>
</div>
