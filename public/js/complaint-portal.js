(function () {
    'use strict';
    var active = null, opener = null;
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (form.method.toLowerCase() !== 'post') return;
        if (form.dataset.submitting) { event.preventDefault(); return; }
        form.dataset.submitting = 'true';
        form.querySelectorAll('button:not([type="button"])').forEach(function (button) {
            button.disabled = true;
        });
    });
    window.addEventListener('pageshow', function () {
        document.querySelectorAll('form[data-submitting]').forEach(function (form) {
            delete form.dataset.submitting;
            form.querySelectorAll('button:disabled').forEach(function (button) { button.disabled = false; });
        });
    });
    function close() {
        if (!active) return;
        active.hidden = true;
        document.body.classList.remove('cp-lock');
        active = null;
        if (opener) opener.focus();
    }
    document.addEventListener('click', function (event) {
        document.querySelectorAll('.cp-notifications[open]').forEach(function (panel) {
            if (!panel.contains(event.target)) panel.open = false;
        });
        var trigger = event.target.closest('[data-cp-open]');
        if (trigger) {
            active = document.getElementById(trigger.getAttribute('data-cp-open'));
            if (!active) return;
            opener = trigger;
            active.hidden = false;
            document.body.classList.add('cp-lock');
            active.querySelector('[data-cp-close]').focus();
        } else if (event.target.closest('[data-cp-close]') || event.target === active) close();
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.cp-notifications[open]').forEach(function (panel) {
                panel.open = false;
                panel.querySelector('summary').focus();
            });
        }
        if (!active) return;
        if (event.key === 'Escape') close();
        if (event.key === 'Tab') {
            var buttons = active.querySelectorAll('button'), first = buttons[0], last = buttons[buttons.length - 1];
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
            else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
        }
    });
}());
