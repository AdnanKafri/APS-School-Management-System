@extends('teachers2.layouts.app')

@section('teacher_page_title', __('student_follow_up.history'))
@section('teacher_page_subtitle', $student->first_name . ' ' . $student->last_name)

@push('page_styles')
    @include('teachers2.student_follow_ups.partials.styles')
@endpush

@section('content')
@php($formErrors = $errors ?? session('errors'))
<div class="main-panel student-follow-up-module">
    <div class="content-wrapper">
        <div class="fu-shell">
            <div class="fu-ajax-toast" role="status" aria-live="polite" hidden></div>
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

            <section class="fu-surface fu-history-head">
                <a class="fu-back-link" href="{{ route('teacher.student_follow_ups.roster', $assignment->id) }}">
                    <i class="mdi mdi-arrow-right" aria-hidden="true"></i>
                    {{ __('student_follow_up.back_to_roster') }}
                </a>
                <div class="fu-history-student">
                    <span class="fu-history-student__avatar" aria-hidden="true"><i class="mdi mdi-account"></i></span>
                    <div>
                        <span class="fu-eyebrow">{{ __('student_follow_up.student_history') }}</span>
                        <h1>{{ $student->first_name }} {{ $student->last_name }}</h1>
                        <p>{{ $lesson->name }} · {{ $class->name }} · {{ __('student_follow_up.section') }} {{ $room->name }} · {{ $year->name }}</p>
                    </div>
                </div>
            </section>

            @forelse($followUps as $followUp)
                @if($loop->first)<section class="fu-timeline" aria-label="{{ __('student_follow_up.history') }}">@endif
                <article class="fu-surface fu-history-item" data-follow-up-id="{{ $followUp->id }}">
                    <div class="fu-history-item__top">
                        <div>
                            <time class="fu-history-date" datetime="{{ $followUp->observed_at->toIso8601String() }}">
                                {{ $followUp->observed_at->timezone('Asia/Damascus')->format('Y/m/d H:i') }}
                            </time>
                            <div class="fu-history-meta">
                                @if($followUp->level)
                                    <span class="fu-level-badge" data-level-badge>
                                        <i class="mdi mdi-chart-line" aria-hidden="true"></i>
                                        {{ __('student_follow_up.levels.' . $followUp->level) }}
                                    </span>
                                @endif
                                @if($followUp->edited_at)
                                    <span class="fu-edited-badge" data-edited-badge title="{{ $followUp->edited_at->timezone('Asia/Damascus')->format('Y/m/d H:i') }}">
                                        <i class="mdi mdi-pencil-outline" aria-hidden="true"></i>
                                        {{ __('student_follow_up.edited') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($followUp->isEditableBy($teacher->id, $now))
                            <button type="button" class="fu-btn fu-btn--secondary js-edit-follow-up" data-id="{{ $followUp->id }}" data-level="{{ $followUp->level }}" data-note="{{ $followUp->note }}" data-observed-at="{{ $followUp->observed_at->timezone('Asia/Damascus')->format('Y/m/d H:i') }}">
                                <i class="mdi mdi-pencil-outline" aria-hidden="true"></i>
                                {{ __('student_follow_up.edit') }}
                            </button>
                        @endif
                    </div>

                    @if($followUp->note)
                        <p class="fu-history-note" data-history-note>{{ $followUp->note }}</p>
                    @else
                        <p class="fu-history-note" data-history-note>{{ __('student_follow_up.level_only_entry') }}</p>
                    @endif
                </article>
                @if($loop->last)</section>@endif
            @empty
                <section class="fu-surface fu-empty" role="status">
                    <span class="fu-empty__icon"><i class="mdi mdi-history" aria-hidden="true"></i></span>
                    <h3>{{ __('student_follow_up.no_history_title') }}</h3>
                    <p>{{ __('student_follow_up.no_history') }}</p>
                </section>
            @endforelse

            @if($followUps->hasPages())
                <div class="fu-surface fu-pagination">{{ $followUps->links() }}</div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade sfu-followup-modal student-follow-up-module" id="editFollowUpModal" tabindex="-1" role="dialog" aria-labelledby="editFollowUpModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="post" id="editFollowUpForm" class="modal-content js-edit-follow-up-form" novalidate>
            @csrf
            <div class="modal-header">
                <div class="sfu-modal-heading">
                    <p class="sfu-modal-eyebrow">{{ __('student_follow_up.student_history') }}</p>
                    <h2 class="modal-title" id="editFollowUpModalTitle">{{ __('student_follow_up.edit_title') }}</h2>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('student_follow_up.close') }}">&times;</button>
            </div>

            <div class="modal-body">
                <div class="sfu-inline-error js-follow-up-client-error" role="alert">{{ __('student_follow_up.errors.content_required') }}</div>
                <div class="sfu-inline-error js-follow-up-server-error" role="alert" hidden></div>
                <div class="js-follow-up-field-errors" role="alert" hidden></div>

                <section class="sfu-context" aria-label="{{ __('student_follow_up.assignment_context') }}">
                    <article class="sfu-context__item"><small>{{ __('student_follow_up.student') }}</small><strong>{{ $student->first_name }} {{ $student->last_name }}</strong></article>
                    <article class="sfu-context__item"><small>{{ __('student_follow_up.subject') }}</small><strong>{{ $lesson->name }}</strong></article>
                    <article class="sfu-context__item"><small>{{ __('student_follow_up.class') }} / {{ __('student_follow_up.section') }}</small><strong>{{ $class->name }} / {{ $room->name }}</strong></article>
                    <article class="sfu-context__item"><small>{{ __('student_follow_up.server_time') }}</small><strong class="js-edit-observed-at" dir="ltr">--</strong></article>
                </section>

                <section class="sfu-field">
                    <header class="sfu-field__heading"><b class="sfu-field__label">{{ __('student_follow_up.level') }}</b><small class="sfu-field__optional">{{ __('student_follow_up.optional') }}</small></header>
                    <div class="sfu-level-grid" role="radiogroup" aria-label="{{ __('student_follow_up.level') }}">
                        @foreach(\App\StudentFollowUp::LEVELS as $level)
                            <label class="sfu-level-option">
                                <input type="radio" name="level" value="{{ $level }}">
                                <b>{{ __('student_follow_up.levels.' . $level) }}</b>
                            </label>
                        @endforeach
                    </div>
                    <button type="button" class="sfu-clear-level js-clear-level">{{ __('student_follow_up.clear_level') }}</button>
                </section>

                <section class="sfu-field">
                    <header class="sfu-field__heading"><label class="sfu-field__label" for="editFollowUpNote">{{ __('student_follow_up.note') }}</label><small class="sfu-field__optional">{{ __('student_follow_up.optional') }}</small></header>
                    <textarea class="sfu-note-input js-note-input" id="editFollowUpNote" name="note" maxlength="1000" rows="4"></textarea>
                    <output class="sfu-character-count" aria-live="polite"><b class="js-note-count">0</b> / 1000</output>
                    <p class="sfu-field__help">{{ __('student_follow_up.content_guidance') }}</p>
                </section>

                <aside class="sfu-notices"><p class="sfu-notice"><i class="mdi mdi-clock-edit-outline" aria-hidden="true"></i>{{ __('student_follow_up.edit_notice') }}</p></aside>
            </div>

            <div class="modal-footer">
                <button type="button" class="sfu-button sfu-button--secondary" data-dismiss="modal">{{ __('student_follow_up.cancel') }}</button>
                <button type="submit" class="sfu-button sfu-button--primary js-edit-submit" data-loading-text="{{ __('student_follow_up.saving') }}">
                    <i class="mdi mdi-content-save-outline" aria-hidden="true"></i>
                    <b class="sfu-button__label">{{ __('student_follow_up.save_changes') }}</b>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
(function ($) {
    var updateUrl = @json(route('teacher.student_follow_ups.update', ['followUp' => 'FOLLOW_UP_ID']));
    var messages = {
        save: @json(__('student_follow_up.save_changes')),
        denied: @json(__('student_follow_up.errors.edit_window_expired')),
        expired: @json(__('student_follow_up.errors.session_expired')),
        failed: @json(__('student_follow_up.errors.save_failed')),
        levelOnly: @json(__('student_follow_up.level_only_entry')),
        edited: @json(__('student_follow_up.edited'))
    };

    function updateNoteCount(scope) {
        var input = scope.find('.js-note-input');
        scope.find('.js-note-count').text((input.val() || '').length);
    }

    function clearErrors(form) {
        form.find('.js-follow-up-client-error, .js-follow-up-server-error, .js-follow-up-field-errors').hide().prop('hidden', true);
        form.find('.js-follow-up-field-errors').empty();
        form.find('.is-invalid').removeClass('is-invalid');
    }

    function showErrors(form, xhr) {
        var errors = xhr.responseJSON && xhr.responseJSON.errors;
        if (xhr.status === 422 && errors) {
            var box = form.find('.js-follow-up-field-errors');
            $.each(errors, function (field, entries) {
                $.each(entries, function (_, message) { $('<p>').text(message).appendTo(box); });
                form.find('[name="' + field + '"]').addClass('is-invalid');
            });
            box.prop('hidden', false).show();
            return;
        }
        form.find('.js-follow-up-server-error')
            .text(xhr.status === 403 ? messages.denied : (xhr.status === 419 ? messages.expired : messages.failed))
            .prop('hidden', false).show();
    }

    $(document).on('click', '.js-edit-follow-up', function () {
        var button = $(this);
        var modal = $('#editFollowUpModal');
        modal.data('return-focus', button);
        var form = $('#editFollowUpForm');
        form.attr('action', updateUrl.replace('FOLLOW_UP_ID', button.attr('data-id'))).data('submitting', false);
        form.find('input[name="level"]').prop('checked', false);
        if (button.attr('data-level')) {
            form.find('input[name="level"][value="' + button.attr('data-level') + '"]').prop('checked', true);
        }
        $('#editFollowUpNote').val(button.attr('data-note') || '');
        modal.find('.js-edit-observed-at').text(button.attr('data-observed-at') || '--');
        clearErrors(form);
        form.find('.js-edit-submit').prop('disabled', false).find('.sfu-button__label').text(messages.save);
        updateNoteCount(modal);
        modal.modal('show');
    });

    $(document).on('click', '.js-clear-level', function () {
        $(this).closest('form').find('input[name="level"]').prop('checked', false);
    });

    $(document).on('input', '.js-note-input', function () {
        updateNoteCount($(this).closest('.sfu-followup-modal'));
    });

    $('#editFollowUpModal').on('hidden.bs.modal', function () {
        var button = $(this).data('return-focus');
        if (button && document.contains(button[0])) { button.trigger('focus'); }
    });

    $(document).on('submit', '.js-edit-follow-up-form', function (event) {
        event.preventDefault();
        var form = $(this);
        clearErrors(form);
        var hasLevel = form.find('input[name="level"]:checked').length > 0;
        var hasNote = $.trim(form.find('textarea[name="note"]').val()).length > 0;
        if (!hasLevel && !hasNote) {
            form.find('.js-follow-up-client-error').prop('hidden', false).show();
            return;
        }
        if (form.data('submitting')) { return; }
        form.data('submitting', true);
        var submit = form.find('.js-edit-submit');
        submit.prop('disabled', true).find('.sfu-button__label').text(submit.data('loading-text'));
        $.ajax({
            url: form.attr('action'), type: 'POST', data: form.serialize(), dataType: 'json',
            headers: { 'Accept': 'application/json' }
        }).done(function (response) {
            var record = response.record;
            var item = $('.fu-history-item[data-follow-up-id="' + record.id + '"]');
            var badge = item.find('[data-level-badge]');
            if (record.level_label) {
                if (!badge.length) {
                    badge = $('<span class="fu-level-badge" data-level-badge>').appendTo(item.find('.fu-history-meta'));
                }
                badge.text(record.level_label).show();
            } else { badge.remove(); }
            var edited = item.find('[data-edited-badge]');
            if (!edited.length) {
                edited = $('<span class="fu-edited-badge" data-edited-badge>').appendTo(item.find('.fu-history-meta'));
            }
            edited.attr('title', record.edited_at).text(messages.edited);
            item.find('[data-history-note]').text(record.note || messages.levelOnly);
            item.find('.js-edit-follow-up').attr('data-level', record.level || '').attr('data-note', record.note || '');
            $('#editFollowUpModal').modal('hide');
            var toast = $('.fu-ajax-toast');
            toast.text(@json(__('student_follow_up.messages.saved'))).prop('hidden', false).show();
            window.clearTimeout(toast.data('timer'));
            toast.data('timer', window.setTimeout(function () { toast.hide().prop('hidden', true); }, 5000));
        }).fail(function (xhr) {
            showErrors(form, xhr);
        }).always(function () {
            form.data('submitting', false);
            submit.prop('disabled', false).find('.sfu-button__label').text(messages.save);
        });
    });
})(jQuery);
</script>
@endsection
