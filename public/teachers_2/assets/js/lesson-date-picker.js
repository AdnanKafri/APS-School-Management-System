(function () {
    'use strict';
    document.querySelectorAll('[data-lc-date-picker]').forEach(function (button) {
        var input = document.getElementById(button.getAttribute('data-lc-date-picker'));
        if (!input || input.type !== 'date' || typeof input.showPicker !== 'function') return;
        button.hidden = false;
        button.addEventListener('click', function () {
            input.focus();
            try { input.showPicker(); } catch (error) {
                // Native date entry remains available when the browser denies opening.
                input.focus();
            }
        });
    });
})();
