const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const source = fs.readFileSync('public/teachers_2/assets/js/lesson-date-picker.js', 'utf8');
for (const support of ['supported', 'unsupported', 'denied']) {
    const inputs = {}, buttons = ['lecture_time', 'date'].map(id => {
        const input = inputs[id] = {type: 'date', focused: 0, opened: 0, value: '2026-11-14', focus() { this.focused++; }};
        if (support !== 'unsupported') input.showPicker = function () { this.opened++; if (support === 'denied') throw Error('NotAllowedError'); };
        return {hidden: true, getAttribute: () => id, addEventListener(event, fn) { this[event] = fn; }};
    });
    vm.runInNewContext(source, {document: {querySelectorAll: () => buttons, getElementById: id => inputs[id]}});
    buttons.forEach((button, index) => {
        const input = inputs[['lecture_time', 'date'][index]];
        assert.equal(button.hidden, support === 'unsupported');
        if (support !== 'unsupported') {
            button.click();
            assert.equal(input.opened, 1);
            assert.ok(input.focused > 0);
        }
        assert.equal(input.value, '2026-11-14');
    });
}
const css = fs.readFileSync('public/teachers_2/assets/css/lesson-content-management.css', 'utf8');
assert.match(css, /\.lc-private-content a::after\s*\{\s*content:\s*none;/);
console.log('PASS: Add/Edit picker support, denial fallback, value preservation and scoped stretched-link reset. Browser visual/keyboard acceptance remains pending.');
