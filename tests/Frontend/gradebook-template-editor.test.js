// Isolated DOM/event harness; visual browser acceptance remains separate.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const handlers = {};
let focused = null;
const list = {
    children: [],
    addEventListener: (name, handler) => { handlers[name] = handler; },
    contains(rowOrButton) { return this.children.includes(rowOrButton.row || rowOrButton); },
    appendChild(row) { this.children.push(row); },
    removeChild(row) { this.children.splice(this.children.indexOf(row), 1); },
    insertBefore(row, target) {
        this.removeChild(row);
        this.children.splice(this.children.indexOf(target), 0, row);
    },
    get lastElementChild() { return this.children[this.children.length - 1]; }
};
function row(identity) {
    const fields = ['id', 'name_ar', 'name_en', 'maximum'].map(field => ({
        value: field === 'id' ? identity : field === 'maximum' ? '120' : 'Readable label',
        getAttribute: name => name === 'data-field' ? field : null,
        focus() { focused = this; }
    }));
    return {
        fields,
        querySelectorAll: () => fields,
        querySelector: () => fields[1],
        get previousElementSibling() { return list.children[list.children.indexOf(this) - 1]; },
        get nextElementSibling() { return list.children[list.children.indexOf(this) + 1]; }
    };
}
const add = { addEventListener: (name, handler) => { add[name] = handler; } };
const template = { content: { cloneNode: () => row('') } };
list.children = [row('stable-a'), row('stable-b')];
vm.runInNewContext(fs.readFileSync('public/assets/admin/js/gradebook-template-editor.js', 'utf8'), {
    document: { getElementById: id => ({ 'gbt-components': list, 'gbt-add': add, 'gbt-component-template': template })[id] }
});
function click(targetRow, action) {
    const button = {
        row: targetRow,
        closest: () => targetRow,
        hasAttribute: attribute => attribute === 'data-remove' && action === 'remove',
        getAttribute: attribute => attribute === 'data-move' ? action : null
    };
    handlers.click({ target: { closest: () => button } });
}
function checkNames() {
    list.children.forEach((current, index) => current.fields.forEach(field => {
        assert.equal(field.name, `components[${index}][${field.getAttribute('data-field')}]`);
    }));
}
checkNames();
const originalA = list.children[0];
click(list.children[1], 'up');
assert.deepEqual(list.children.map(current => current.fields[0].value), ['stable-b', 'stable-a']);
checkNames();
click(list.children[0], 'down');
assert.equal(list.children[0], originalA);
click(list.children[1], 'remove');
assert.equal(list.children.length, 1);
add.click();
assert.equal(list.lastElementChild.fields[0].value, '');
assert.equal(focused, list.lastElementChild.fields[1]);
assert.equal(list.children[0].fields[0].value, 'stable-a');
while (list.children.length < 100) add.click();
assert.equal(add.disabled, true);
add.click();
assert.equal(list.children.length, 100);
click(list.lastElementChild, 'remove');
assert.equal(add.disabled, false);
checkNames();
console.log('PASS: stable identities, reordering, removal, blank server-assigned IDs, indexing, focus and 100-component bound');
