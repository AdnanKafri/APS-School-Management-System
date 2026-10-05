(function (window, $) {
    'use strict';

    function normalizeName(value) {
        return String(value || '').toLowerCase()
            .replace(/[\u0622\u0623\u0625\u0671]/g, '\u0627')
            .replace(/\u0649/g, '\u064a')
            .replace(/[\u0640\u064b-\u065f\u0670]/g, '')
            .trim();
    }

    function nameMatcher(params, data) {
        var term = normalizeName(params.term);
        if (!term) return data;
        return normalizeName(data.text).indexOf(term) !== -1 ? data : null;
    }

    function create($modal, $form, labels) {
        var $conflict = $('#scheduleConflictModal');
        var $error = $('<div class="alert alert-danger d-none schedule-form-error" role="alert" tabindex="-1"></div>').prependTo($form);
        var suspended = false;
        var modalShown = false;
        var rtl = $modal.css('direction') === 'rtl';

        $modal.on('shown.bs.modal.workScheduleUi', function () { modalShown = true; });
        $modal.on('hidden.bs.modal.workScheduleUi', function () { modalShown = false; });

        function clearError() {
            $error.addClass('d-none').empty();
        }

        function initSelects($row) {
            if (!$.fn.select2) return;
            var options = {dropdownParent: $modal, width: '100%', dir: rtl ? 'rtl' : 'ltr'};
            $row.find('.lesson_id').select2(options);
            $row.find('.teacher_id').select2($.extend({}, options, {
                minimumResultsForSearch: 0,
                matcher: nameMatcher,
                placeholder: $row.find('.teacher_id option:first').text(),
                language: {noResults: function () { return labels.searchEmpty; }}
            })).on('select2:open.scheduleTeacherSearch', function () {
                window.setTimeout(function () {
                    var search = $modal.find('.select2-container--open .select2-search__field')[0];
                    if (search) {
                        search.setAttribute('aria-label', labels.searchPrompt);
                        search.setAttribute('placeholder', labels.searchPrompt);
                        search.focus();
                    }
                }, 0);
            });
        }

        function success(message) {
            if (window.toastr && typeof window.toastr.success === 'function') {
                window.toastr.success(message, '', {
                    rtl: rtl,
                    positionClass: rtl ? 'toast-bottom-left' : 'toast-bottom-right',
                    timeOut: 2800,
                    extendedTimeOut: 500,
                    closeButton: false,
                    progressBar: true,
                    escapeHtml: true,
                    preventDuplicates: true
                });
                return;
            }
            var $notice = $('<div class="work-schedule-toast" role="status"></div>').text(message).appendTo('body');
            window.setTimeout(function () { $notice.remove(); }, 2800);
        }

        // Use one Bootstrap modal at a time; preserve the assignment form while details are open.
        function showConflict(response) {
            if (suspended) return;
            suspended = $modal.hasClass('show');
            clearError();
            if ($.fn.select2) $form.find('select.select2-hidden-accessible').select2('close');
            var details = $.extend({}, response.conflict);
            details.time = details.start_time && details.end_time
                ? details.start_time + ' - ' + details.end_time : '';
            $conflict.find('#scheduleConflictSummary').text(response.message || response.msg);
            $conflict.find('[data-conflict-field]').each(function () {
                $(this).text(details[$(this).attr('data-conflict-field')] || labels.unavailable);
            });
            if ($modal.is(':visible')) {
                $modal.one('hidden.bs.modal.scheduleConflict', function () {
                    $conflict.modal('show');
                });
                if (suspended) {
                    if (modalShown) $modal.modal('hide');
                    else $modal.one('shown.bs.modal.scheduleConflict', function () { $modal.modal('hide'); });
                }
            } else {
                $conflict.modal('show');
            }
        }

        $conflict.on('hidden.bs.modal.scheduleConflict', function () {
            if (!suspended) return;
            $modal.one('shown.bs.modal.scheduleConflict', function () {
                suspended = false;
                var $selection = $form.find('.teacher_id').first().next('.select2').find('.select2-selection');
                ($selection.length ? $selection : $form.find('.teacher_id').first()).trigger('focus');
            }).modal('show');
        });

        function error(response, fallback) {
            if (response && response.code === 'teacher_conflict' && response.conflict) {
                showConflict(response);
                return;
            }
            $error.text(fallback).removeClass('d-none').trigger('focus');
        }

        return {
            initSelects: initSelects,
            clearError: clearError,
            success: success,
            error: error,
            isSuspended: function () { return suspended; }
        };
    }

    window.WorkScheduleUI = {create: create, nameMatcher: nameMatcher};
}(window, jQuery));
