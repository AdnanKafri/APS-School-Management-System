(function () {
    'use strict';
    var list = document.getElementById('gbt-components');
    var add = document.getElementById('gbt-add');
    var template = document.getElementById('gbt-component-template');
    if (!list || !add || !template) return;
    function indexRows() {
        Array.prototype.forEach.call(list.children, function (row, index) {
            Array.prototype.forEach.call(row.querySelectorAll('[data-field]'), function (input) {
                input.name = 'components[' + index + '][' + input.getAttribute('data-field') + ']';
            });
        });
        add.disabled = list.children.length >= 100;
    }
    add.addEventListener('click', function () {
        if (list.children.length >= 100) return;
        list.appendChild(template.content.cloneNode(true));
        indexRows();
        list.lastElementChild.querySelector('[data-field="name_ar"]').focus();
    });
    list.addEventListener('click', function (event) {
        var button = event.target.closest('button');
        if (!button || !list.contains(button)) return;
        var row = button.closest('.gbt-component');
        if (button.hasAttribute('data-remove')) list.removeChild(row);
        else if (button.getAttribute('data-move') === 'up' && row.previousElementSibling) list.insertBefore(row, row.previousElementSibling);
        else if (button.getAttribute('data-move') === 'down' && row.nextElementSibling) list.insertBefore(row.nextElementSibling, row);
        indexRows();
    });
    indexRows();
}());
