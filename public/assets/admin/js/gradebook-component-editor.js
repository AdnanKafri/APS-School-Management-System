(function () {
    'use strict';
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('configForm'), modal = document.getElementById('componentDialog');
        if (!form || !modal || !window.jQuery || !window.jQuery.fn.modal) return;
        window.jQuery(modal).appendTo(document.body);
        var body = document.getElementById('componentsBody'), editor = document.getElementById('componentDialogForm');
        var name = document.getElementById('componentName'), percent = document.getElementById('componentPercent');
        var marks = document.getElementById('componentMarks'), mode = document.getElementById('componentMode');
        var feedback = document.getElementById('componentFeedback'), selected = null, returnFocus = null;
        var units = window.GradebookDistributionUnits, initial = structure();
        function rows() { return Array.from(body.querySelectorAll('.component-row')); }
        function structure() { return rows().map(function (row) { return [row.querySelector('[name$="[id]"]').value, row.querySelector('.weight-input').value]; }); }
        function refresh() {
            rows().forEach(function (row, index) {
                row.querySelector('.component-name').readOnly = true;
                row.querySelector('.weight-input').readOnly = true;
                row.querySelector('.allocation-mark-input').readOnly = true;
                row.querySelector('.index-cell').textContent = index + 1;
                row.querySelectorAll('[name]').forEach(function (field) { field.name = field.name.replace(/components\[[^\]]+\]/, 'components[' + index + ']'); });
                row.querySelector('.component-up').disabled = index === 0;
                row.querySelector('.component-down').disabled = index === rows().length - 1;
            });
            document.getElementById('components-empty').hidden = rows().length > 0;
            form.dispatchEvent(new Event('gradebook:components-changed', { bubbles: true }));
        }
        function open(row) {
            returnFocus = document.activeElement;
            selected = row; editor.reset(); feedback.textContent = '';
            name.value = row ? row.querySelector('.component-name').value : '';
            percent.value = row ? row.querySelector('.weight-input').value : '0';
            var protectedBound = row && row.dataset.used === '1';
            percent.readOnly = !!protectedBound;
            mode.disabled = !!protectedBound || !!(row && row.dataset.explicit === '1') || !units || !units.supported;
            mode.value = 'percent';
            document.getElementById('componentKind').textContent = row ? row.querySelector('td:nth-child(2) small').textContent : form.dataset.manual;
            document.getElementById('componentProtection').hidden = !protectedBound;
            changeMode(); window.jQuery(modal).modal('show');
        }
        function changeMode() {
            var absolute = mode.value === 'marks';
            if (absolute && units.fromPercent(form.dataset.subjectTotal, percent.value) === null) {
                feedback.textContent = form.dataset.inexact;
            }
            percent.parentElement.hidden = absolute; marks.parentElement.hidden = !absolute;
            percent.required = !absolute; marks.required = absolute;
            marks.value = units ? units.fromPercent(form.dataset.subjectTotal, percent.value) || '' : '';
            marks.setCustomValidity(absolute && units.toPercent(form.dataset.subjectTotal, marks.value) === null ? form.dataset.inexact : '');
        }
        mode.addEventListener('change', changeMode);
        marks.addEventListener('input', function () {
            var value = units.toPercent(form.dataset.subjectTotal, marks.value);
            marks.setCustomValidity(value === null ? form.dataset.inexact : '');
            feedback.textContent = value === null ? form.dataset.inexact : '';
            if (value !== null) percent.value = value;
        });
        document.getElementById('addRowBtn').addEventListener('click', function () {
            if (rows().length >= 100) { window.alert(form.dataset.limit); return; }
            open(null);
        });
        body.addEventListener('click', function (event) {
            var button = event.target.closest('button'), row = event.target.closest('.component-row');
            if (!button || !row) return;
            if (button.classList.contains('component-edit')) open(row);
            if (button.classList.contains('delete-row') && row.dataset.used !== '1') row.remove();
            if (button.classList.contains('component-up') && row.previousElementSibling) body.insertBefore(row, row.previousElementSibling);
            if (button.classList.contains('component-down') && row.nextElementSibling) body.insertBefore(row.nextElementSibling, row);
            refresh();
        });
        editor.addEventListener('submit', function (event) {
            event.preventDefault(); if (!editor.reportValidity()) return;
            if (!selected) {
                if (rows().length >= 100) return;
                var template = document.getElementById('component-row-template');
                body.appendChild(template.content.cloneNode(true)); selected = body.lastElementChild;
            }
            selected.querySelector('.component-name').value = name.value;
            selected.querySelector('.weight-input').value = percent.value;
            refresh(); window.jQuery(modal).modal('hide');
        });
        window.jQuery(modal).on('shown.bs.modal', function () { name.focus(); });
        window.jQuery(modal).on('hidden.bs.modal', function () { if (returnFocus && returnFocus.isConnected) returnFocus.focus(); });
        form.addEventListener('submit', function (event) {
            if (event.defaultPrevented) return;
            if (JSON.stringify(initial) !== JSON.stringify(structure()) && !window.confirm(form.dataset.impact)) event.preventDefault();
        });
        refresh();
    });
}());
