(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var feedback = document.getElementById('legacy-mark-feedback');
        if (!feedback || !window.jQuery) return;
        var config = feedback.dataset, busy = false;
        function fields() { return Array.from(document.querySelectorAll('.table1 input[name="mark"]')); }
        function state(input, message, failed) {
            var cell = input.closest('td'), label = cell.querySelector('[data-save-state]');
            if (!label) { label = document.createElement('small'); label.dataset.saveState = '1'; label.setAttribute('role','status'); cell.appendChild(label); }
            label.className = failed ? 'd-block text-danger' : 'd-block text-success'; label.textContent = message;
            feedback.className = failed ? 'small px-3 mb-2 text-danger' : 'small px-3 mb-2 text-success'; feedback.textContent = message;
        }
        function data(input) {
            var row = input.closest('tr');
            function value(name, fallback) { var field = row.querySelector('[name="' + name + '"]'); return field ? field.value : fallback; }
            return { room_id: config.room, lesson_id: config.lesson, exam_id: config.exam,
                user_id: value('user_id',input.dataset.id), exam_result_id: value('exam_result_id','') || input.dataset.resultId || '', mark: input.value };
        }
        function send(inputs, url, payload, button) {
            if (busy || inputs.some(function (input) { return input.disabled || !input.reportValidity(); })) return false;
            busy = true; if (button) button.disabled = true;
            inputs.forEach(function (input) { input.readOnly = true; input.dataset.unsaved = '1'; state(input,config.saving,false); });
            window.jQuery.ajax({ url: url, type: 'POST', data: payload, headers: { Accept: 'application/json', 'X-CSRF-TOKEN':config.token } })
                .done(function (response) {
                    if (!response || !response.success) { failed(response && response.message); return; }
                    var records = response.rows || [response];
                    inputs.forEach(function (input) {
                        var target = data(input), record = records.find(function (row) { return String(row.student_id) === String(target.user_id) && String(row.exam_id) === String(target.exam_id); });
                        if (!record) { state(input,config.failed,true); return; }
                        input.value = record.value == null ? '' : record.value; input.dataset.accepted = input.value;
                        input.dataset.resultId = String(record.result_id);
                        delete input.dataset.unsaved; input.removeAttribute('aria-invalid');
                        input.closest('tr').querySelectorAll('[name="exam_result_id"]').forEach(function (id) { id.value = record.result_id; });
                        state(input,response.message || config.saved,false);
                        if (input.dataset.advance === '1') {
                            delete input.dataset.advance; var list = fields(), next = list[list.indexOf(input)+1];
                            if (next && !next.disabled) next.focus();
                        }
                    });
                }).fail(function (xhr) {
                    var response = xhr.responseJSON || {}, errors = response.errors || {};
                    failed(Object.keys(errors).map(function (key) { return errors[key].join(' '); }).join(' ') || response.message);
                    if (errors.entry_window || xhr.status === 403) inputs.forEach(function (input) { input.dataset.closed = '1'; });
                }).always(function () {
                    busy = false;
                    inputs.forEach(function (input) { input.readOnly = false; if (input.dataset.closed === '1') input.disabled = true; });
                    if (button) button.disabled = inputs.some(function (input) { return input.disabled; });
                });
            function failed(message) { inputs.forEach(function (input) { input.setAttribute('aria-invalid','true'); state(input,message || config.failed,true); }); }
            return false;
        }
        function single(input, button) {
            if (!input || input.value.trim() === '') return false;
            input.step = 'any'; return send([input],config.legacyMarkUrl,data(input),button);
        }
        document.addEventListener('click', function (event) {
            var button = event.target.closest('.table1 .Btn');
            if (!button) return;
            var input = button.closest('tr').querySelector('[name="mark"]');
            if (input) { event.preventDefault(); single(input,button); }
        });
        document.addEventListener('submit', function (event) {
            if (!event.target.matches('form[action*="student_save_mark_quize"]')) return;
            var row = event.target.closest('tr'), input = row && row.querySelector('[name="mark"]');
            if (!input && event.target.elements) input = event.target.elements.namedItem('mark');
            if (input) { event.preventDefault(); single(input,event.submitter); }
        });
        document.addEventListener('input', function (event) {
            var input = event.target; if (!input.matches('.table1 input[name="mark"]')) return;
            input.step = 'any';
            if (input.value !== (input.dataset.accepted === undefined ? input.defaultValue : input.dataset.accepted)) input.dataset.unsaved = '1';
            else delete input.dataset.unsaved;
        });
        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter' || !event.target.matches('.table1 input[name="mark"]')) return;
            event.preventDefault(); event.target.dataset.advance = '1'; single(event.target);
        });
        window.teacherBulkSave = function (button) {
            var panel = button.closest('.teacher-bulk-panel'), form = panel && panel.querySelector('.bulk-mark-form');
            if (!form) return false;
            var inputs = fields().filter(function (input) { return !input.disabled && input.offsetParent !== null && input.value.trim() !== ''; });
            if (!inputs.length) { feedback.textContent = config.empty; return false; }
            inputs.forEach(function (input) { input.step = 'any'; });
            var rows = inputs.map(data), kind = form.querySelector('[name="kind"]').value;
            return send(inputs,form.action,{ _token:config.token, kind:kind, rows:JSON.stringify(rows) },button);
        };
        fields().forEach(function (input) { input.step = 'any'; input.dataset.accepted = input.value; });
        window.addEventListener('beforeunload', function (event) {
            if (fields().some(function (input) { return input.dataset.unsaved === '1'; })) { event.preventDefault(); event.returnValue = config.pending; }
        });
    });
}());
