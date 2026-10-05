<div class="modal fade" id="scheduleConflictModal" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="scheduleConflictTitle" aria-describedby="scheduleConflictSummary" dir="{{ app()->getLocale() === 'en' ? 'ltr' : 'rtl' }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleConflictTitle"><i class="fas fa-calendar-times" aria-hidden="true"></i> {{ __('timetable.schedule.conflict_title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('timetable.schedule.close') }}"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p id="scheduleConflictSummary" class="schedule-conflict-summary"></p>
                <dl class="schedule-conflict-details">
                    <div><dt>{{ __('timetable.schedule.lesson_label') }}</dt><dd data-conflict-field="lesson_name"></dd></div>
                    <div><dt>{{ __('timetable.schedule.class_label') }}</dt><dd data-conflict-field="class_name"></dd></div>
                    <div><dt>{{ __('timetable.schedule.section_label') }}</dt><dd data-conflict-field="section_name"></dd></div>
                    <div><dt>{{ __('timetable.schedule.day_label') }}</dt><dd data-conflict-field="day_name"></dd></div>
                    <div><dt>{{ __('timetable.schedule.session_label') }}</dt><dd data-conflict-field="session_name"></dd></div>
                    <div><dt>{{ __('timetable.schedule.time_label') }}</dt><dd><bdi dir="ltr" data-conflict-field="time"></bdi></dd></div>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('timetable.schedule.conflict_acknowledge') }}</button>
            </div>
        </div>
    </div>
</div>
