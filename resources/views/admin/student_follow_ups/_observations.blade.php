@forelse($followUps as $followUp)
    <article class="sfu-observation">
        <div class="sfu-observation-head">
            <div>
                <strong>{{ optional($followUp->teacher)->first_name }} {{ optional($followUp->teacher)->last_name }} · {{ optional($followUp->lesson)->name }}</strong>
                <span class="sfu-meta">{{ optional($followUp->classRoom)->name }} / {{ optional($followUp->room)->name }} · {{ optional($followUp->observed_at)->timezone('Asia/Damascus')->format('Y-m-d H:i') }}</span>
            </div>
            @if($followUp->edited_at)<span class="sfu-badge not_due">{{ __('student_follow_up_admin.edited') }}</span>@endif
        </div>
        @include('admin.student_follow_ups._evaluation')
    </article>
@empty
    <div class="sfu-empty"><h4>{{ __('student_follow_up_admin.no_evaluation') }}</h4></div>
@endforelse
