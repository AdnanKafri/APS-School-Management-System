(function () {
    'use strict';
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.matches('[data-lesson-manage]')) return;
        if (form.dataset.pending === '1') { event.preventDefault(); return; }
        if (form.dataset.confirm && !window.confirm(form.dataset.confirm)) { event.preventDefault(); return; }
        if (!form.checkValidity()) return;
        form.dataset.pending = '1';
        window.setTimeout(function () {
            form.setAttribute('aria-busy','true');
            form.querySelectorAll('[type="submit"]').forEach(function (button) { button.disabled = true; });
        },0);
    });
    window.addEventListener('pageshow', function () {
        document.querySelectorAll('[data-lesson-manage]').forEach(function (form) {
            delete form.dataset.pending; form.removeAttribute('aria-busy');
            form.querySelectorAll('[type="submit"]').forEach(function (button) { button.disabled = false; });
        });
    });
})();
