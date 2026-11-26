(function () {
    'use strict';
    function validate(input) {
        var files = Array.prototype.slice.call(input.files || []);
        if (input.dataset.maxFiles) {
            var message = '';
            var total = files.reduce(function (sum, file) { return sum + file.size; }, 0);
            if (files.length > Number(input.dataset.maxFiles)) message = input.dataset.countError;
            else if (files.some(function (file) { return file.size <= 0 || file.size > Number(input.dataset.maxFileBytes); })) message = input.dataset.fileError;
            else if (total > Number(input.dataset.maxTotalBytes)) message = input.dataset.totalError;
            input.setCustomValidity(message);
            var selectedCount = input.closest('form').querySelector('[name="attachment_count"]');
            if (selectedCount) selectedCount.value = files.length;
        }
        return files;
    }
    function initialize() {
        document.querySelectorAll('[data-lesson-file-picker]').forEach(function (input) {
            var field = input.closest('.lc-upload-field');
            var group = input.closest('.Group');
            if (!field || !group) {
                input.addEventListener('change', function () { validate(input); });
                window.addEventListener('pageshow', function () { validate(input); });
                validate(input);
                return;
            }
            var preview = document.createElement('div');
            preview.className = 'lc-file-selection';
            var count = document.createElement('output');
            count.className = 'lc-file-selection__count';
            count.setAttribute('aria-live', 'polite');
            var list = document.createElement('ul');
            list.className = 'lc-file-selection__list';
            preview.appendChild(count);
            preview.appendChild(list);
            group.appendChild(preview);

            function render() {
                var files = validate(input);
                preview.hidden = files.length === 0;
                count.textContent = field.dataset.filesLabel + ' ' + files.length;
                while (list.firstChild) list.removeChild(list.firstChild);
                files.forEach(function (file, index) {
                    var item = document.createElement('li');
                    item.className = 'lc-file-selection__item';
                    var details = document.createElement('details');
                    details.className = 'lc-file-selection__details';
                    var summary = document.createElement('summary');
                    var name = document.createElement('bdi');
                    name.className = 'lc-file-selection__name';
                    name.dir = 'auto';
                    name.title = file.name;
                    name.textContent = file.name;
                    summary.appendChild(name);
                    details.appendChild(summary);
                    var full = document.createElement('bdi');
                    full.className = 'lc-file-selection__full';
                    full.dir = 'auto';
                    full.textContent = file.name;
                    details.appendChild(full);
                    item.appendChild(details);
                    // Single-file clearing works without DataTransfer on older browsers.
                    if (files.length === 1 || typeof window.DataTransfer === 'function') {
                        var remove = document.createElement('button');
                        remove.type = 'button';
                        remove.className = 'lc-file-selection__remove';
                        remove.textContent = field.dataset.removeLabel;
                        remove.setAttribute('aria-label', field.dataset.removeLabel + ': ' + file.name);
                        remove.addEventListener('click', function () {
                            if (files.length === 1) {
                                input.value = '';
                            } else {
                                try {
                                    var transfer = new window.DataTransfer();
                                    files.forEach(function (selected, i) { if (i !== index) transfer.items.add(selected); });
                                    input.files = transfer.files;
                                } catch (error) {
                                    count.textContent = field.dataset.reselectLabel;
                                    return;
                                }
                            }
                            input.dispatchEvent(new Event('change', {bubbles: true}));
                            input.focus();
                        });
                        item.appendChild(remove);
                    }
                    list.appendChild(item);
                });
            }
            input.addEventListener('change', render);
            window.addEventListener('pageshow', render);
            render();
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initialize);
    else initialize();
})();
