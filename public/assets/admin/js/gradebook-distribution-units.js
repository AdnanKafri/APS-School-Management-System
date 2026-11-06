(function (root, factory) {
    'use strict';
    var api = factory(root);
    if (typeof module === 'object' && module.exports) module.exports = api;
    else root.GradebookDistributionUnits = api;
    if (root.document) root.document.addEventListener('DOMContentLoaded', function () {
        var form = root.document.getElementById('configForm');
        if (form) api.mount(form);
    });
}(typeof globalThis !== 'undefined' ? globalThis : this, function (root) {
    'use strict';
    var supported = typeof BigInt === 'function';
    function decimal(value) {
        var match = /^(\d{1,24})(?:\.(\d{1,12}))?$/.exec(String(value).trim());
        return supported && match ? { n: BigInt(match[1] + (match[2] || '')), scale: (match[2] || '').length } : null;
    }
    function power(scale) { return BigInt(10) ** BigInt(scale); }
    function wholePercent(value) {
        value = String(value).trim();
        return /^(0|[1-9]\d{0,2})$/.test(value) && Number(value) <= 100 ? BigInt(value) : null;
    }
    function format(n, scale) {
        var negative = n < BigInt(0);
        var text = String(negative ? -n : n).padStart(scale + 1, '0');
        if (scale) text = (text.slice(0, -scale) + '.' + text.slice(-scale)).replace(/0+$/, '').replace(/\.$/, '');
        return (negative ? '-' : '') + text;
    }
    function fromPercent(total, percent) {
        if (!supported) return null;
        var t = decimal(total), p = wholePercent(percent);
        if (!t || t.n <= BigInt(0) || p === null || t.n % power(t.scale) !== BigInt(0)) return null;
        // Existing assessment maximum columns are integers. Never offer a new
        // fractional maximum that downstream materialization could truncate.
        return (t.n * p) % power(t.scale + 2) === BigInt(0) ? format(t.n * p, t.scale + 2) : null;
    }
    function toPercent(total, marks) {
        if (!supported) return null;
        var t = decimal(total), m = decimal(marks);
        if (!t || t.n <= BigInt(0) || !m || t.n % power(t.scale) !== BigInt(0) || m.n % power(m.scale) !== BigInt(0)) return null;
        var numerator = m.n * power(t.scale) * BigInt(100);
        var denominator = t.n * power(m.scale);
        if (numerator % denominator !== BigInt(0)) return null;
        var percent = numerator / denominator;
        return percent <= BigInt(100) ? String(percent) : null;
    }
    function summary(total, values) {
        if (!supported) return null;
        var t = decimal(total), sum = BigInt(0);
        if (!t || t.n <= BigInt(0)) return null;
        for (var i = 0; i < values.length; i++) {
            var p = wholePercent(values[i]);
            if (p === null) return null;
            sum += p;
        }
        return { percent: String(sum), marks: format(t.n * sum, t.scale + 2),
            remaining: format(t.n * (BigInt(100) - sum), t.scale + 2) };
    }
    function mount(form) {
        if (form.dataset.unitsReady === '1') return;
        var ui = form.querySelector('#distribution-units');
        if (!ui) return;
        form.dataset.unitsReady = '1';
        var buttons = form.querySelectorAll('[data-allocation-mode]');
        var feedback = form.querySelector('#allocation-feedback');
        var save = form.querySelector('#saveBtn');
        var expectedTotal = form.querySelector('#allocation-subject-total');
        var mode = 'percent', changing = false;
        var total = form.dataset.subjectTotal;
        function rows() { return Array.prototype.slice.call(form.querySelectorAll('.component-row')); }
        function weight(row) { return row.querySelector('.weight-input'); }
        function mark(row) { return row.querySelector('.allocation-mark-input'); }
        function allowed() {
            return supported && form.dataset.unitsBlocked !== '1'
                && rows().every(function (row) { return fromPercent(total, weight(row).value) !== null; });
        }
        function validMarks() {
            return rows().every(function (row) { return toPercent(total, mark(row).value) !== null; });
        }
        function refresh(fill) {
            var compatible = allowed();
            expectedTotal.disabled = mode !== 'marks';
            rows().forEach(function (row) {
                var input = mark(row);
                if (fill || input.dataset.ready !== '1') input.value = fromPercent(total, weight(row).value) || '';
                input.dataset.ready = '1';
                input.disabled = mode !== 'marks'; input.required = mode === 'marks';
                input.setCustomValidity(mode === 'marks' && toPercent(total, input.value) === null ? form.dataset.inexact : '');
                row.querySelector('.allocation-percent-group').hidden = mode === 'marks';
                row.querySelector('.allocation-mark-group').hidden = mode !== 'marks';
            });
            Array.prototype.forEach.call(buttons, function (button) {
                button.disabled = button.dataset.allocationMode === 'marks' && !compatible;
                button.setAttribute('aria-pressed', String(button.dataset.allocationMode === mode));
            });
            var invalid = mode === 'marks' && !validMarks();
            var allocation = supported ? summary(total, rows().map(function (row) { return weight(row).value; })) : null;
            form.querySelector('#allocation-percent').textContent = allocation ? allocation.percent + '%' : '-';
            form.querySelector('#allocation-marks').textContent = allocation && compatible && !invalid ? allocation.marks : '-';
            form.querySelector('#allocation-remaining').textContent = allocation && compatible && !invalid ? allocation.remaining : '-';
            feedback.textContent = invalid ? form.dataset.inexact : !compatible ? form.dataset.unsupported
                : !allocation ? form.dataset.invalidTotal : allocation.percent === '100' ? form.dataset.complete
                : BigInt(allocation.percent) > BigInt(100) ? form.dataset.excess : form.dataset.incomplete;
            // Preserve the legacy percentage-mode total policy. Only inexact mark input is blocked.
            save.disabled = invalid;
        }
        if (!supported) return; // Percentage editing still works without this enhancement.
        ui.hidden = false;
        Array.prototype.forEach.call(buttons, function (button) {
            button.addEventListener('click', function () {
                if (button.dataset.allocationMode === 'marks' && !allowed()) return;
                mode = button.dataset.allocationMode;
                refresh(true); // Returning to percentages restores the last exact canonical values.
            });
        });
        form.addEventListener('input', function (event) {
            if (changing) return;
            if (event.target.classList.contains('allocation-mark-input')) {
                var percent = toPercent(total, event.target.value);
                if (percent !== null) {
                    changing = true;
                    var original = weight(event.target.closest('.component-row'));
                    original.value = percent;
                    original.dispatchEvent(new root.Event('input', { bubbles: true }));
                    changing = false;
                }
                refresh(false);
            } else if (event.target.classList.contains('weight-input')) refresh(mode === 'percent');
        });
        form.addEventListener('click', function (event) {
            var button = event.target.closest('button');
            if (button && (button.id === 'addRowBtn' || button.classList.contains('delete-row'))) refresh(false);
        });
        form.addEventListener('gradebook:components-changed', function () { refresh(false); });
        form.addEventListener('submit', function (event) {
            if (mode === 'marks' && !validMarks()) {
                event.preventDefault(); refresh(false); form.reportValidity();
            }
        });
        refresh(true);
    }
    return { supported: supported, fromPercent: fromPercent, toPercent: toPercent, summary: summary, mount: mount };
}));
