// Exact arithmetic and isolated DOM/event harness; not browser acceptance.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const units = require('../../public/assets/admin/js/gradebook-distribution-units.js');
for (const total of [100, 150, 200, 300, 400, 500, 600]) {
    for (let percent = 0; percent <= 100; percent++) {
        const marks = units.fromPercent(total, percent);
        if (marks !== null) assert.equal(units.toPercent(total, marks), String(percent));
    }
}
assert.equal(units.toPercent(300, 100), null);
assert.equal(units.toPercent(300, 50), null);
assert.equal(units.toPercent(300, 150), '50');
assert.equal(units.fromPercent(150, 25), null); // Fractional assessment maxima are not materialized.
assert.equal(units.toPercent(75, '18.75'), null);
assert.equal(units.toPercent(300, '99.000'), '33');
assert.equal(units.toPercent(300, '0'), '0');
for (const value of ['', '-1', '1e2', 'abc', '301', '99.000000000001']) assert.equal(units.toPercent(300, value), null);
assert.equal(units.fromPercent(0, 20), null);
assert.equal(units.fromPercent(100, '20.5'), null);
assert.deepEqual(units.summary(300, ['20', '30', '50']), { percent: '100', marks: '300', remaining: '0' });
assert.deepEqual(units.summary(300, ['20', '30']), { percent: '50', marks: '150', remaining: '150' });
assert.deepEqual(units.summary(300, ['60', '50']), { percent: '110', marks: '330', remaining: '-30' });
assert.equal(units.summary(300, ['20', '']), null);
const unsupported = { BigInt: undefined, module: { exports: {} } };
vm.runInNewContext(fs.readFileSync('public/assets/admin/js/gradebook-distribution-units.js','utf8'), unsupported);
assert.equal(unsupported.module.exports.supported, false);
assert.equal(unsupported.module.exports.fromPercent(100,20), null);

function fixture(total = '200', blocked = '0') {
    const handlers = {}, rows = [], nodes = {}, buttons = [];
    let reports = 0, originalInputs = 0;
    const form = {
        dataset: { subjectTotal: total, unitsBlocked: blocked, inexact: 'inexact', unsupported: 'unsupported',
            invalidTotal: 'invalid', incomplete: 'incomplete', excess: 'excess', complete: 'complete' },
        querySelector: selector => nodes[selector],
        querySelectorAll: selector => selector === '.component-row' ? rows : buttons,
        addEventListener: (event, handler) => { handlers[event] = handler; },
        reportValidity: () => reports++
    };
    for (const id of ['distribution-units','allocation-feedback','saveBtn','allocation-percent','allocation-marks','allocation-remaining','allocation-subject-total']) nodes['#'+id] = {};
    function row(value) {
        const fields = {};
        const result = { querySelector: selector => fields[selector] };
        const weight = { value, classList: { contains: c => c === 'weight-input' }, dispatchEvent: () => { originalInputs++; handlers.input({ target: weight }); } };
        const mark = { value: '', dataset: {}, classList: { contains: c => c === 'allocation-mark-input' }, closest: () => result,
            setCustomValidity: text => { mark.error = text; } };
        Object.assign(fields, { '.weight-input': weight, '.allocation-mark-input': mark,
            '.allocation-percent-group': {}, '.allocation-mark-group': {} });
        return result;
    }
    rows.push(row('25'), row('75'));
    for (const mode of ['percent','marks']) buttons.push({ dataset: { allocationMode: mode },
        setAttribute: (key, value) => { buttons.find(b => b.dataset.allocationMode === mode)[key] = value; },
        addEventListener: (event, handler) => { buttons.find(b => b.dataset.allocationMode === mode)[event] = handler; } });
    units.mount(form);
    return { form, nodes, rows, buttons, handlers, row, reports: () => reports, originalInputs: () => originalInputs };
}
const f = fixture();
assert.equal(f.nodes['#distribution-units'].hidden, false);
assert.equal(f.buttons[1].disabled, false);
assert.equal(f.nodes['#allocation-marks'].textContent, '200');
f.buttons[1].click();
assert.equal(f.nodes['#allocation-subject-total'].disabled, false);
const first = f.rows[0].querySelector('.allocation-mark-input');
assert.equal(first.value, '50'); assert.equal(first.required, true);
first.value = '67'; f.handlers.input({ target: first });
assert.equal(first.error, 'inexact');
assert.equal(f.rows[0].querySelector('.weight-input').value, '25');
assert.equal(f.nodes['#saveBtn'].disabled, true);
let prevented = false; f.handlers.submit({ preventDefault: () => { prevented = true; } });
assert.equal(prevented, true); assert.equal(f.reports(), 1);
first.value = '100'; f.handlers.input({ target: first });
assert.equal(f.rows[0].querySelector('.weight-input').value, '50');
assert.equal(f.originalInputs(), 1);
assert.equal(f.nodes['#saveBtn'].disabled, false);
assert.equal(f.nodes['#allocation-remaining'].textContent, '-50'); // Legacy total policy unchanged.
first.value = '0'; f.handlers.input({ target: first });
assert.equal(f.rows[0].querySelector('.weight-input').value, '0');
f.buttons[0].click(); assert.equal(first.disabled, true);
assert.equal(f.nodes['#allocation-subject-total'].disabled, true);
const newRow = f.row('0'); f.rows.push(newRow);
f.handlers.click({ target: { closest: () => ({ id: 'addRowBtn' }) } });
assert.equal(newRow.querySelector('.allocation-mark-input').value, '0');
const savedHandler = f.handlers.input; units.mount(f.form); assert.equal(f.handlers.input, savedHandler);
newRow.querySelector('.weight-input').value='50'; f.handlers['gradebook:components-changed']();
assert.equal(f.nodes['#allocation-percent'].textContent,'125%');
for (const f of [fixture('0'), fixture('200','1')]) assert.equal(f.buttons[1].disabled, true);
const threeHundred = fixture('300'); // 25% is 75, so the mode is available initially.
threeHundred.buttons[1].click();
const input = threeHundred.rows[0].querySelector('.allocation-mark-input');
input.value = '100'; threeHundred.handlers.input({ target: input });
assert.equal(threeHundred.nodes['#saveBtn'].disabled, true);
threeHundred.buttons[0].click();
assert.equal(threeHundred.rows[0].querySelector('.weight-input').value, '25');
assert.equal(threeHundred.nodes['#saveBtn'].disabled, false);
console.log('PASS: exact reversible integer allocations, unsafe conversions blocked, canonical payloads, totals, zero, add-row events and submit protection');
