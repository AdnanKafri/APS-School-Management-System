@extends('teachers2.layouts.app')

@section('teacher_page_title', __('student_follow_up.title'))
@section('teacher_page_subtitle', $lesson->name . ' - ' . $room->name)

@push('page_styles')
    @include('teachers2.student_follow_ups.partials.styles')
@endpush

@section('content')
@php($formErrors = $errors ?? session('errors'))
<div class="main-panel student-follow-up-module">
    <div class="content-wrapper">
        <div class="fu-shell">
            @if(session('success'))
                <div class="fu-flash" role="status">
                    <i class="mdi mdi-check-circle-outline" aria-hidden="true"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($formErrors && $formErrors->any())
                <div class="fu-errors" role="alert">
                    <ul>
                        @foreach($formErrors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="fu-surface fu-page-head" aria-labelledby="assignment-title">
                <div class="fu-page-head__copy">
                    <a class="fu-back-link" href="{{ route('teacher.student_follow_ups.index') }}">
                        <i class="mdi mdi-arrow-right" aria-hidden="true"></i>
                        {{ __('student_follow_up.back') }}
                    </a>
                    <span class="fu-eyebrow">
                        <i class="mdi mdi-book-open-variant" aria-hidden="true"></i>
                        {{ __('student_follow_up.assignment_context') }}
                    </span>
                    <h1 class="fu-page-title" id="assignment-title">{{ $lesson->name }}</h1>
                    <div class="fu-context-list">
                        <span class="fu-context-chip"><i class="mdi mdi-school" aria-hidden="true"></i>{{ $class->name }}</span>
                        <span class="fu-context-chip"><i class="mdi mdi-door" aria-hidden="true"></i>{{ __('student_follow_up.section') }} {{ $room->name }}</span>
                        <span class="fu-context-chip"><i class="mdi mdi-calendar-check" aria-hidden="true"></i>{{ $year->name }}</span>
                        <span class="fu-context-chip"><i class="mdi mdi-calendar-month" aria-hidden="true"></i>{{ __('student_follow_up.months.' . $now->month) }}</span>
                    </div>
                </div>
            </section>

            <section class="fu-summary-grid" aria-label="{{ __('student_follow_up.monthly_summary') }}">
                <article class="fu-surface fu-summary-card">
                    <span class="fu-summary-card__icon"><i class="mdi mdi-account-group" aria-hidden="true"></i></span>
                    <div class="fu-summary-card__content"><strong dir="ltr">{{ $summary['total'] }}</strong><span>{{ __('student_follow_up.total_students') }}</span></div>
                </article>
                <article class="fu-surface fu-summary-card fu-summary-card--success">
                    <span class="fu-summary-card__icon"><i class="mdi mdi-check-circle-outline" aria-hidden="true"></i></span>
                    <div class="fu-summary-card__content"><strong dir="ltr">{{ $summary['complete'] }}</strong><span>{{ __('student_follow_up.completed_month') }}</span></div>
                </article>
                <article class="fu-surface fu-summary-card fu-summary-card--pending">
                    <span class="fu-summary-card__icon"><i class="mdi mdi-clock-outline" aria-hidden="true"></i></span>
                    <div class="fu-summary-card__content"><strong dir="ltr">{{ $summary['needs_current'] }}</strong><span>{{ __('student_follow_up.needs_current_period') }}</span></div>
                </article>
            </section>

            <form class="fu-surface fu-toolbar" method="get" action="{{ route('teacher.student_follow_ups.roster', $assignment->id) }}">
                <div class="fu-toolbar__field fu-toolbar__field--search">
                    <label for="follow-up-search">{{ __('student_follow_up.search_student') }}</label>
                    <div class="fu-search-wrap">
                        <i class="mdi mdi-magnify" aria-hidden="true"></i>
                        <input class="form-control" id="follow-up-search" name="search" value="{{ $search }}" placeholder="{{ __('student_follow_up.search_placeholder') }}">
                    </div>
                </div>
                <div class="fu-toolbar__field fu-toolbar__field--filter">
                    <label for="follow-up-filter">{{ __('student_follow_up.filter_status') }}</label>
                    <select class="form-control" id="follow-up-filter" name="filter">
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>{{ __('student_follow_up.all') }}</option>
                        <option value="needs_follow_up" {{ $filter === 'needs_follow_up' ? 'selected' : '' }}>{{ __('student_follow_up.needs_follow_up') }}</option>
                        <option value="complete" {{ $filter === 'complete' ? 'selected' : '' }}>{{ __('student_follow_up.complete') }}</option>
                    </select>
                </div>
                <button class="fu-btn fu-btn--secondary" type="submit">
                    <i class="mdi mdi-filter-outline" aria-hidden="true"></i>
                    {{ __('student_follow_up.apply_filter') }}
                </button>
            </form>

            <section class="fu-surface fu-roster-surface" aria-label="{{ __('student_follow_up.student_roster') }}">
                @if($students->isEmpty())
                    <div class="fu-empty" role="status">
                        <span class="fu-empty__icon"><i class="mdi mdi-account-search-outline" aria-hidden="true"></i></span>
                        <h3>{{ __('student_follow_up.no_students_title') }}</h3>
                        <p>{{ __('student_follow_up.no_students') }}</p>
                    </div>
                @else
                    <div class="fu-table-wrap">
                        <table class="fu-roster-table">
                            <thead>
                                <tr>
                                    <th>{{ __('student_follow_up.student') }}</th>
                                    <th>{{ __('student_follow_up.first_half') }}</th>
                                    <th>{{ __('student_follow_up.second_half') }}</th>
                                    <th>{{ __('student_follow_up.monthly_status') }}</th>
                                    <th>{{ __('student_follow_up.last_follow_up') }}</th>
                                    <th>{{ __('student_follow_up.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    @php($status = $statusByStudent[$student->id] ?? ['first' => false, 'second' => false, 'count' => 0, 'last' => null])
                                    @php($minimumCompleted = min(2, ($status['first'] ? 1 : 0) + ($status['second'] ? 1 : 0)))
                                    @php($lastFollowUp = $status['last'] ? \Carbon\Carbon::parse($status['last'])->timezone('Asia/Damascus')->format('Y/m/d H:i') : null)
                                    <tr>
                                        <td data-label="{{ __('student_follow_up.student') }}">
                                            <div class="fu-student-name">
                                                <span class="fu-student-avatar" aria-hidden="true"><i class="mdi mdi-account"></i></span>
                                                <span>{{ $student->first_name }} {{ $student->last_name }}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('student_follow_up.first_half') }}">
                                            <span class="fu-status {{ $status['first'] ? 'fu-status--complete' : 'fu-status--pending' }}">
                                                <i class="mdi {{ $status['first'] ? 'mdi-check-circle-outline' : 'mdi-clock-outline' }}" aria-hidden="true"></i>
                                                {{ $status['first'] ? __('student_follow_up.period_complete') : __('student_follow_up.period_pending') }}
                                            </span>
                                        </td>
                                        <td data-label="{{ __('student_follow_up.second_half') }}">
                                            <span class="fu-status {{ $status['second'] ? 'fu-status--complete' : 'fu-status--pending' }}">
                                                <i class="mdi {{ $status['second'] ? 'mdi-check-circle-outline' : 'mdi-clock-outline' }}" aria-hidden="true"></i>
                                                {{ $status['second'] ? __('student_follow_up.period_complete') : __('student_follow_up.period_pending') }}
                                            </span>
                                        </td>
                                        <td data-label="{{ __('student_follow_up.monthly_status') }}">
                                            <div class="fu-month-progress">
                                                <strong>{{ $minimumCompleted }} {{ __('student_follow_up.of') }} 2 {{ __('student_follow_up.minimum_follow_ups') }}</strong>
                                                @if($status['count'] > 2)
                                                    <small>{{ __('student_follow_up.month_records', ['count' => $status['count']]) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="{{ __('student_follow_up.last_follow_up') }}">
                                            <span class="fu-last-follow-up">
                                                {{ $lastFollowUp ?: __('student_follow_up.no_follow_up_yet') }}
                                            </span>
                                        </td>
                                        <td data-label="{{ __('student_follow_up.actions') }}">
                                            <div class="fu-actions">
                                                <button type="button" class="fu-btn fu-btn--primary js-add-follow-up" data-student-id="{{ $student->id }}" data-student-name="{{ $student->first_name }} {{ $student->last_name }}">
                                                    <i class="mdi mdi-plus-circle-outline" aria-hidden="true"></i>
                                                    {{ __('student_follow_up.add') }}
                                                </button>
                                                <a class="fu-btn fu-btn--secondary" href="{{ route('teacher.student_follow_ups.history', [$assignment->id, $student->id]) }}">
                                                    <i class="mdi mdi-history" aria-hidden="true"></i>
                                                    {{ __('student_follow_up.history') }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="fu-pagination">{{ $students->links() }}</div>
                @endif
            </section>
        </div>
    </div>
</div>

<div class="modal fade sfu-followup-modal student-follow-up-module" id="followUpModal" tabindex="-1" role="dialog" aria-labelledby="followUpModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="post" action="{{ route('teacher.student_follow_ups.store') }}" class="modal-content js-follow-up-form" novalidate>
            @csrf
            <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
            <input type="hidden" name="student_id" id="followUpStudentId" value="{{ old('student_id') }}">

            <div class="modal-header">
                <div class="sfu-modal-heading">
                    <p class="sfu-modal-eyebrow">{{ __('student_follow_up.follow_up_entry') }}</p>
                    <h2 class="modal-title" id="followUpModalTitle">{{ __('student_follow_up.add') }}</h2>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('student_follow_up.close') }}">&times;</button>
            </div>

            <div class="modal-body">
                <div class="sfu-inline-error js-follow-up-client-error" role="alert">{{ __('student_follow_up.errors.content_required') }}</div>

                <section class="sfu-context" aria-label="{{ __('student_follow_up.assignment_context') }}">
                    <article class="sfu-context__item"><small>{{ __('student_follow_up.student') }}</small><strong id="followUpStudentName">{{ __('student_follow_up.student') }}</strong></article>
                    <article class="sfu-context__item"><small>{{ __('student_follow_up.subject') }}</small><strong>{{ $lesson->name }}</strong></article>
                    <article class="sfu-context__item"><small>{{ __('student_follow_up.class') }} / {{ __('student_follow_up.section') }}</small><strong>{{ $class->name }} / {{ $room->name }}</strong></article>
                    <article class="sfu-context__item"><small>{{ __('student_follow_up.server_time') }}</small><strong dir="ltr">{{ $serverNow }}</strong></article>
                </section>

                <section class="sfu-field">
                    <header class="sfu-field__heading"><b class="sfu-field__label">{{ __('student_follow_up.level') }}</b><small class="sfu-field__optional">{{ __('student_follow_up.optional') }}</small></header>
                    <div class="sfu-level-grid" role="radiogroup" aria-label="{{ __('student_follow_up.level') }}">
                        @foreach(['weak', 'average', 'good', 'excellent'] as $level)
                            <label class="sfu-level-option">
                                <input type="radio" name="level" value="{{ $level }}" {{ old('level') === $level ? 'checked' : '' }}>
                                <b>{{ __('student_follow_up.levels.' . $level) }}</b>
                            </label>
                        @endforeach
                    </div>
                </section>

                <section class="sfu-field">
                    <header class="sfu-field__heading"><label class="sfu-field__label" for="followUpNote">{{ __('student_follow_up.note') }}</label><small class="sfu-field__optional">{{ __('student_follow_up.optional') }}</small></header>
                    <textarea class="sfu-note-input js-note-input" id="followUpNote" name="note" maxlength="1000" rows="4" placeholder="{{ __('student_follow_up.note_placeholder') }}">{{ old('note') }}</textarea>
                    <output class="sfu-character-count" aria-live="polite"><b class="js-note-count">0</b> / 1000</output>
                    <p class="sfu-field__help">{{ __('student_follow_up.content_guidance') }}</p>
                </section>

                <aside class="sfu-notices">
                    <p class="sfu-notice"><i class="mdi mdi-shield-account-outline" aria-hidden="true"></i>{{ __('student_follow_up.privacy_notice') }}</p>
                    <p class="sfu-notice"><i class="mdi mdi-clock-edit-outline" aria-hidden="true"></i>{{ __('student_follow_up.edit_notice') }}</p>
                </aside>
            </div>

            <div class="modal-footer">
                <button type="button" class="sfu-button sfu-button--secondary" data-dismiss="modal">{{ __('student_follow_up.cancel') }}</button>
                <button type="submit" class="sfu-button sfu-button--primary js-follow-up-submit" data-loading-text="{{ __('student_follow_up.saving') }}">
                    <i class="mdi mdi-content-save-outline" aria-hidden="true"></i>
                    <b class="sfu-button__label">{{ __('student_follow_up.save') }}</b>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
(function ($) {
    function updateNoteCount(scope) {
        var input = scope.find('.js-note-input');
        scope.find('.js-note-count').text((input.val() || '').length);
    }

    $(document).on('click', '.js-add-follow-up', function () {
        var button = $(this);
        var modal = $('#followUpModal');
        modal.find('form').data('submitting', false);
        modal.find('.js-follow-up-submit').prop('disabled', false).find('.sfu-button__label').text(@json(__('student_follow_up.save')));
        modal.find('.js-follow-up-client-error').hide();
        modal.find('input[name="level"]').prop('checked', false);
        modal.find('.js-note-input').val('');
        $('#followUpStudentId').val(button.data('student-id'));
        $('#followUpStudentName').text(button.data('student-name'));
        updateNoteCount(modal);
        modal.modal('show');
    });

    $(document).on('input', '.js-note-input', function () {
        updateNoteCount($(this).closest('.sfu-followup-modal'));
    });

    $(document).on('submit', '.js-follow-up-form', function () {
        var form = $(this);
        var hasLevel = form.find('input[name="level"]:checked').length > 0;
        var hasNote = $.trim(form.find('textarea[name="note"]').val()).length > 0;
        if (!hasLevel && !hasNote) {
            form.find('.js-follow-up-client-error').show();
            return false;
        }
        if (form.data('submitting')) {
            return false;
        }
        form.data('submitting', true);
        var submit = form.find('.js-follow-up-submit');
        submit.prop('disabled', true).find('.sfu-button__label').text(submit.data('loading-text'));
    });

    @if($formErrors && $formErrors->any() && old('student_id'))
        var previousButton = $('.js-add-follow-up[data-student-id="{{ (int) old('student_id') }}"]').first();
        $('#followUpStudentName').text(previousButton.data('student-name') || @json(__('student_follow_up.student')));
        updateNoteCount($('#followUpModal'));
        $('#followUpModal').modal('show');
    @endif
})(jQuery);
</script>
@endsection
