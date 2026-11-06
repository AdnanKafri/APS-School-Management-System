document.addEventListener('DOMContentLoaded', function () {
    'use strict';
    var notice = document.getElementById('traditional-entry-window');
    if (!notice) return;
    var closed = notice.dataset.allowed !== '1';
    function disable() {
        if (!closed) return;
        document.querySelectorAll('input[name="mark"]').forEach(function (input) {
            input.disabled = true;
            var form = input.closest('form');
            if (form) form.querySelectorAll('[type="submit"]').forEach(function (button) { button.disabled = true; });
            var row = input.closest('tr');
            if (row) row.querySelectorAll('button[type="submit"], .Btn').forEach(function (button) { button.disabled = true; });
        });
        document.querySelectorAll('.js-bulk-save').forEach(function (button) { button.disabled = true; });
    }
    disable();
    if (window.MutationObserver) new MutationObserver(disable).observe(document.body, { childList: true, subtree: true });
    if (!closed) {
        // Elapsed monotonic time from the server-provided interval, never a browser permission grant.
        var started = performance.now(), remaining = Number(notice.dataset.remaining);
        function check() {
            var wait = remaining - (performance.now() - started);
            if (wait > 0) { window.setTimeout(check, Math.min(wait, 60000)); return; }
            closed = true; notice.textContent = notice.dataset.ended; notice.className = 'alert alert-warning mx-3'; disable();
        }
        check();
    }
});
