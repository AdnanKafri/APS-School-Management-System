(function ($) {
    'use strict';
    $(function () {
        $('.lc-tabs').each(function () {
            var list = this;
            var tabs = Array.prototype.slice.call(list.querySelectorAll('[data-toggle="tab"]'));
            function select(tab) {
                tabs.forEach(function (item) {
                    var active = item === tab;
                    item.setAttribute('aria-selected', active ? 'true' : 'false');
                    item.setAttribute('tabindex', active ? '0' : '-1');
                    item.parentElement.classList.toggle('active', active);
                });
            }
            tabs.forEach(function (tab) {
                var target = tab.getAttribute('href').slice(1);
                tab.id = 'lc-tab-' + target;
                tab.setAttribute('aria-controls', target);
                var panel = document.getElementById(target);
                if (panel) panel.setAttribute('aria-labelledby', tab.id);
                $(tab).on('shown.bs.tab', function () { select(tab); });
                tab.addEventListener('keydown', function (event) {
                    var index = tabs.indexOf(tab);
                    var rtl = window.getComputedStyle(list).direction === 'rtl';
                    if (event.key === 'Home') index = 0;
                    else if (event.key === 'End') index = tabs.length - 1;
                    else if (event.key === 'ArrowRight') index += rtl ? -1 : 1;
                    else if (event.key === 'ArrowLeft') index += rtl ? 1 : -1;
                    else return;
                    event.preventDefault();
                    var next = tabs[(index + tabs.length) % tabs.length];
                    $(next).tab('show');
                    next.focus();
                });
            });
            if (tabs.length) select(tabs.filter(function (t) { return t.classList.contains('active') || t.parentElement.classList.contains('active'); })[0] || tabs[0]);
        });
        $('.lc-entry-form input[type="file"]').on('change', function () {
            if (this.dataset && this.dataset.lessonFilePicker !== undefined) return;
            var output = this.parentElement.querySelector('.lc-file-name');
            if (!output) {
                output = document.createElement('span');
                output.className = 'lc-file-name';
                output.setAttribute('aria-live', 'polite');
                this.parentElement.appendChild(output);
            }
            output.textContent = Array.prototype.map.call(this.files || [], function (file) { return file.name; }).join('، ');
        });
        $('.lc-entry-form, .lc-modal form').on('submit', function () {
            if (!this.checkValidity()) return;
            var form = this;
            // Do not disable controls before the browser captures their values.
            window.setTimeout(function () {
                $(form).attr('aria-busy', 'true').find('[type="submit"]').prop('disabled', true);
            }, 0);
        });
        window.addEventListener('pageshow', function () {
            $('.lc-entry-form, .lc-modal form').removeAttr('aria-busy').find('[type="submit"]').prop('disabled', false);
        });
    });
})(jQuery);
