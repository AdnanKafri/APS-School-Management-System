const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const events = {}, callbacks = {}, retry = { hidden: true }, state = {}, feedback = {}, total = {}, label = {};
let requests = 0, payload;
const cell = { dataset: {}, querySelector: selector => selector === '.occurrence-state' ? state : retry };
const field = { value: '0', disabled: false, dataset: { student: '41', exam: '17', accepted: '' }, reportValidity: () => true,
    matches: selector => selector === '.occurrence-input', closest: () => cell,
    setAttribute(name,value) { this[name] = value; }, removeAttribute(name) { delete this[name]; }
};
const row = { querySelector: () => total, querySelectorAll: () => [{ dataset: { componentValue: 'legacy_exam' }, querySelector: selector => selector === '.grade-input' ? null : label }] };
const section = { dataset: { occurrenceUrl: '/assessment/save', token: 'csrf', room: '132', subject: '409', saving: 'saving', saved: 'saved', failed: 'failed', pending: 'pending' },
    querySelectorAll: () => [field], querySelector: () => field.dataset.unsaved ? field : null,
    addEventListener(name,handler) { events[name] = handler; }
};
const window = { addEventListener: (name,handler) => { events[name] = handler; }, jQuery: { ajax(options) {
    payload = options; requests++; const xhr = {}; ['done','fail','always'].forEach(name => { xhr[name] = handler => { callbacks[name] = handler; return xhr; }; }); return xhr;
} } };
vm.runInNewContext(fs.readFileSync('public/teachers_2/assets/js/gradebook-occurrences.js','utf8'), {
    window, document: { addEventListener: (_,handler) => handler(), querySelector: selector => selector.startsWith('#') ? row : section, getElementById: () => feedback }
});
events.input({ target: field }); events.change({ target: field }); events.change({ target: field });
assert.equal(requests,1); assert.equal(payload.type,'POST'); assert.equal(payload.data.exam_id,'17'); assert.equal(payload.data.student_id,'41'); assert.equal(payload.data._token,'csrf'); assert.equal(payload.data.component_id,undefined);
callbacks.done({ success: true, value: 0, result_id: 91, total: 12, components: { legacy_exam: 0 } }); callbacks.always();
assert.equal(total.textContent,12); assert.equal(label.textContent,0); assert.equal(cell.dataset.result,91); assert.equal(field.dataset.unsaved,undefined);
field.value='5'; events.input({ target: field }); events.change({ target: field });
callbacks.fail({ responseJSON: { errors: { value: ['Too high'] } } }); callbacks.always();
assert.equal(retry.hidden,false); assert.equal(field.disabled,false); assert.equal(total.textContent,12);
events.change({ target: field }); callbacks.fail({ responseJSON: { errors: { entry_window: ['Window ended'] } } }); callbacks.always();
assert.equal(field.disabled,true); assert.equal(retry.hidden,true); assert.equal(feedback.textContent,'Window ended'); assert.equal(total.textContent,12);
let warned = false; events.beforeunload({ preventDefault() { warned = true; } }); assert.equal(warned,true);
console.log('PASS: original-ID POST/CSRF, zero, confirmed original result/total/components, repeated event, validation, expiry denial, disabled retry and pending warning');
