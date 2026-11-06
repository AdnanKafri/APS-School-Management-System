(function ($) {
    'use strict';
    if (!$) return;
    function localDate(value) {
        var match = String(value || '').match(/^(\d{4}-\d{2}-\d{2})[ T](\d{2}:\d{2})(:\d{2})?$/);
        return match ? match[1] + 'T' + match[2] + (match[3] || ':00') : '';
    }
    function populate(form, trigger) {
        form.reset();
        if (form.elements.confirm_window_change) form.elements.confirm_window_change.value = '0';
        var fields = { content_name: 'name', is_file: 'is_file', lesson_id: 'lesson_id',
            room_id: 'room_id', start_date: 'start_date', end_date: 'end_date', mark: 'mark',
            period: 'period', required_lectures: 'required_lectures', question_picker: 'question_picker', notes: 'notes' };
        ['exam_id', 'quize_id'].forEach(function (name) {
            if (form.elements[name]) form.elements[name].value = trigger.getAttribute('data-id');
        });
        Object.keys(fields).forEach(function (name) {
            var input = form.elements[name], value = trigger.getAttribute('data-' + fields[name]);
            if (!input || value === null) return;
            input.value = /_date$/.test(name) ? localDate(value) : value;
        });
    }
    function syncSections(group) {
        var all = group.querySelector('[data-all-sections]'), sections = group.querySelector('[data-specific-sections]');
        var useAll = all.checked && !all.disabled;
        sections.disabled = useAll;
        var count = useAll ? Number(group.dataset.allCount) : Array.from(sections.options).filter(function (option) { return option.selected; }).length;
        group.querySelector('[data-section-summary]').textContent = group.dataset.countLabel.replace(':count', count);
    }
    function clearFields(form) {
        form.querySelectorAll('[data-field-error]').forEach(function (node) { node.remove(); });
        form.querySelectorAll('[aria-invalid="true"]').forEach(function (input) {
            input.removeAttribute('aria-invalid'); input.classList.remove('is-invalid');
        });
    }
    function showErrors(form, errors, messages) {
        clearFields(form);
        Object.keys(errors || {}).forEach(function (key) {
            var name = key.split('.')[0], input = name === 'room_id' ? form.querySelector('[data-specific-sections]') : null;
            input = input || form.querySelector('[name="' + name + '"]');
            if (!input || input.type === 'hidden') return;
            input.setAttribute('aria-invalid', 'true'); input.classList.add('is-invalid');
            var line = document.createElement('small'); line.setAttribute('data-field-error', name);
            line.textContent = errors[key].join(' '); line.setAttribute('role', 'alert');
            input.parentNode.appendChild(line);
        });
        var box = form.querySelector('[data-assessment-errors]'); box.textContent = '';
        messages.forEach(function (message) { var line = document.createElement('p'); line.textContent = message; box.appendChild(line); });
        box.hidden = false; box.setAttribute('tabindex', '-1'); box.focus();
    }
    $(function () {
        $('.assessment-editor').appendTo(document.body);
        document.querySelectorAll('[data-section-choice]').forEach(function (group) {
            syncSections(group); group.addEventListener('change', function () { syncSections(group); });
        });
        document.querySelectorAll('[data-validation]').forEach(function (box) {
            var fields = JSON.parse(box.dataset.validation || '{}');
            if (Object.keys(fields).length) showErrors(box.closest('form'), fields, Object.keys(fields).reduce(function (messages, key) { return messages.concat(fields[key]); }, []));
        });
        var table = null;
        if ($.fn.DataTable) {
            table = $.fn.dataTable.isDataTable('#table_xx') ? $('#table_xx').DataTable() : $('#table_xx').DataTable();
        }
        $('#lesson_id_filter').on('change', function () {
            if (!table) return;
            var text = this.value && this.value !== '0' ? this.options[this.selectedIndex].text.trim() : '';
            table.column(0).search(text ? '^\\s*' + $.fn.dataTable.util.escapeRegex(text) + '\\s*$' : '', true, false).draw();
        });
        $(document).on('show.bs.modal', '#assessment-edit', function (event) {
            if (event.relatedTarget) {
                var form = this.querySelector('form');
                if (form.dataset.saving === '1') { event.preventDefault(); return; }
                populate(form, event.relatedTarget);
                clearFields(form);
                this.querySelector('[data-assessment-errors]').hidden = true;
            }
        });
        $(document).on('click', '.deleteContent', function () {
            var modal = document.querySelector('.deleteContentModal');
            if (!modal) return;
            if (modal.querySelector('form').dataset.saving === '1') return;
            modal.querySelector('form').reset();
            clearFields(modal.querySelector('form'));
            modal.querySelector('[data-assessment-errors]').hidden = true;
            modal.querySelector('[name="content_id"]').value = this.getAttribute('data-id');
            modal.querySelector('.content_name').value = this.getAttribute('data-name');
        });
        $('[data-assessment-form], [data-assessment-delete]').on('submit', function (event) {
            event.preventDefault();
            var form = this;
            if (form.dataset.saving === '1' || !form.reportValidity()) return;
            var errors = form.querySelector('[data-assessment-errors]');
            var button = form.querySelector('[type="submit"]'), original = button.textContent;
            var config = document.getElementById('assessment-editor-config').dataset;
            var confirmation = form.elements.confirm_window_change, retry = false, completed = false;
            form.dataset.saving = '1'; button.disabled = true; button.textContent = config.saving;
            errors.hidden = true;
            $.ajax({ url: form.action, method: 'POST', data: $(form).serialize(), headers: { Accept: 'application/json' } })
                .done(function (response) {
                    if (!response || response.success !== true) { show([typeof response === 'string' ? config.session : config.failed]); return; }
                    completed = true;
                    window.location.reload();
                }).fail(function (xhr) {
                    var response = xhr.responseJSON || {};
                    // Only the server can determine whether retained records make rescheduling risky.
                    if (xhr.status === 422 && confirmation && confirmation.value !== '1' && response.errors
                        && Object.keys(response.errors).length === 1 && response.errors.confirm_window_change) {
                        if (window.confirm(response.errors.confirm_window_change.join('\n'))) {
                            confirmation.value = '1'; retry = true;
                        }
                        return;
                    }
                    if (xhr.status === 401 || xhr.status === 419 || (xhr.status === 200 && !xhr.responseJSON)) { show([config.session]); return; }
                    if (xhr.status === 403) { show([config.denied]); return; }
                    if (xhr.status === 404) { show([config.missing]); return; }
                    var messages = xhr.status === 422 && response.errors ? Object.keys(response.errors).reduce(function (all, key) {
                        return all.concat(response.errors[key]);
                    }, []) : [config.failed];
                    showErrors(form, xhr.status === 422 ? response.errors : {}, messages);
                }).always(function () {
                    if (form.elements.delete_code) form.elements.delete_code.value = '';
                    if (!completed) { form.dataset.saving = '0'; button.disabled = false; button.textContent = original; }
                    if (retry) $(form).trigger('submit');
                    else if (confirmation) confirmation.value = '0';
                });
            function show(messages) {
                showErrors(form, {}, messages);
            }
        });
        $(document).on('hidden.bs.modal', '#assessment-delete', function () {
            this.querySelector('[name="delete_code"]').value = '';
        });
        $('[data-assessment-form] [name="start_date"], [data-assessment-form] [name="end_date"]').on('input change', function () {
            if (this.form.elements.confirm_window_change) this.form.elements.confirm_window_change.value = '0';
        });
        $('.assessment-editor[data-restore="1"]').each(function () { if ($.fn.modal) $(this).modal('show'); });
    });
    // Pure helpers are exposed for isolated frontend regression tests.
    if (typeof module === 'object' && module.exports) module.exports = { localDate: localDate, populate: populate, syncSections: syncSections };
})(typeof window !== 'undefined' ? window.jQuery : null);
