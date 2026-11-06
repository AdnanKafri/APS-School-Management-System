const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
function fixture(allowed) {
    let elapsed = 0, timer, observer;
    const save = { disabled: false }, bulk = { disabled: false };
    const input = { disabled: false, closest: () => ({ querySelectorAll: () => [save] }) };
    const notice = { dataset: { allowed, remaining: '1000', ended: 'Expired' }, textContent: '' };
    const Observer = function (callback) { observer = callback; this.observe = () => {}; };
    vm.runInNewContext(fs.readFileSync('public/teachers_2/assets/js/assessment-window.js','utf8'), {
        document: { addEventListener: (_,handler) => handler(), getElementById: () => notice, body: {},
            querySelectorAll: selector => selector.startsWith('input') ? [input] : [bulk] },
        window: { MutationObserver: Observer, setTimeout: callback => { timer = callback; } },
        MutationObserver: Observer, performance: { now: () => elapsed }
    });
    return { input, save, bulk, notice, advance() { elapsed = 1001; timer(); }, redraw() { input.disabled = false; observer(); } };
}
const before = fixture('0'); assert.equal(before.input.disabled,true); assert.equal(before.save.disabled,true); assert.equal(before.bulk.disabled,true); before.redraw(); assert.equal(before.input.disabled,true);
const active = fixture('1'); assert.equal(active.input.disabled,false); active.advance(); assert.equal(active.input.disabled,true); assert.equal(active.notice.textContent,'Expired');
console.log('PASS: traditional legacy read-only state, AJAX redraw, bulk/single controls and server-interval expiry without reopening permissions');
