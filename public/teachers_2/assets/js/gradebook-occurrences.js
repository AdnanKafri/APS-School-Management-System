(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var section = document.querySelector('[data-occurrence-url]');
        if (!section || !window.jQuery) return;
        var busy = window.gradebookSavingStudents = window.gradebookSavingStudents || {}, config = section.dataset, feedback = document.getElementById('gradebook-feedback');
        function save(input) {
            var student = input.dataset.student;
            if (input.readOnly || input.disabled || !input.reportValidity()) return;
            var cell = input.closest('td'), state = cell.querySelector('.occurrence-state'), retry = cell.querySelector('.occurrence-retry');
            if (busy[student]) { input.dataset.unsaved = '1'; state.textContent = config.pending; retry.hidden = false; return; }
            busy[student] = true; input.dataset.unsaved = '1'; state.textContent = config.saving; retry.hidden = true;
            var fields = Array.from(section.querySelectorAll('.occurrence-input')).filter(function (field) { return field.dataset.student === student; });
            fields.forEach(function (field) { field.readOnly = true; });
            window.jQuery.ajax({ url: config.occurrenceUrl, type: 'POST', data: {
                _token: config.token, exam_id: input.dataset.exam, student_id: student,
                room_id: config.room, subject_id: config.subject, value: input.value
            } }).done(function (response) {
                if (!response.success) { failed(response.message); return; }
                input.value = response.value; input.dataset.accepted = input.value;
                delete input.dataset.unsaved; input.removeAttribute('aria-invalid');
                cell.dataset.result = response.result_id; state.textContent = config.saved; feedback.textContent = config.saved;
                feedback.className = 'mb-2 text-success';
                var row = document.querySelector('#gradebookTable tr[data-student="' + student + '"]');
                if (!row) return;
                row.querySelector('.total-cell').textContent = response.total === null ? '-' : response.total;
                row.querySelectorAll('[data-component-value]').forEach(function (component) {
                    var value = response.components[component.dataset.componentValue];
                    var manual = component.querySelector('.grade-input');
                    if (manual) {
                        if (!manual.dataset.unsaved) { manual.value = value == null ? '' : value; manual.dataset.accepted = manual.value; }
                    } else {
                        var label = component.querySelector('span');
                        if (label) label.textContent = value == null ? '-' : value;
                    }
                });
            }).fail(function (xhr) {
                var response = xhr.responseJSON || {}, errors = response.errors || {};
                failed(Object.keys(errors).map(function (key) { return errors[key].join(' '); }).join(' ') || response.message);
                if (errors.entry_window || xhr.status === 403) { input.dataset.closed = '1'; retry.hidden = true; }
            }).always(function () {
                busy[student] = false;
                fields.forEach(function (field) { field.readOnly = false; field.disabled = field.dataset.closed === '1'; });
            });
            function failed(message) {
                input.setAttribute('aria-invalid','true'); state.textContent = message || config.failed;
                feedback.textContent = message || config.failed; feedback.className = 'mb-2 text-danger'; retry.hidden = false;
            }
        }
        section.addEventListener('change', function (event) { if (event.target.matches('.occurrence-input')) save(event.target); });
        section.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && event.target.matches('.occurrence-input')) { event.preventDefault(); save(event.target); }
        });
        section.addEventListener('input', function (event) {
            if (!event.target.matches('.occurrence-input')) return;
            if (event.target.value !== event.target.dataset.accepted) event.target.dataset.unsaved = '1';
            else delete event.target.dataset.unsaved;
        });
        section.addEventListener('click', function (event) {
            var retry = event.target.closest('.occurrence-retry');
            if (retry) save(retry.closest('td').querySelector('.occurrence-input'));
        });
        window.addEventListener('beforeunload', function (event) {
            if (section.querySelector('.occurrence-input[data-unsaved="1"]')) { event.preventDefault(); event.returnValue = config.pending; }
        });
    });
})();
