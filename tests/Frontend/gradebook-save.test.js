// Run with node tests/Frontend/gradebook-save.test.js. No browser or school DB.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const blade = fs.readFileSync('resources/views/teachers/gradebook/index.blade.php', 'utf8');
const script = blade.match(/<script>([\s\S]*?)<\/script>/)[1]
    .replace(/@json\(__\('gradebook\.([^']+)'\)\)/g, (_, key) => JSON.stringify(key))
    .replace(/@json\(route\('teacher.gradebook.save'\)\)/g, '"/isolated-save"')
    .replace(/@json\(csrf_token\(\)\)/g, '"isolated-csrf"')
    .replace(/@json\(\$(room|subject)->id\)/g, '132');

const handlers = {}, callbacks = {}, feedback = {}, status = {}, retry = { hidden: true };
const total = { textContent: '55' };
const row = { dataset: {}, querySelector: () => total, querySelectorAll: () => [input] };
const cell = { querySelector: selector => selector === '.save-state' ? status : selector === '.grade-retry' ? retry : input };
const input = {
    value: '15', dataset: { student: '41', comp: 'dynamic_a', accepted: '' }, disabled: false,
    closest: selector => selector === 'tr' ? row : cell,
    checkValidity: () => true, reportValidity: () => {},
    setAttribute: (key, value) => { input[key] = value; }, removeAttribute: key => { delete input[key]; },
    addEventListener: (name, handler) => { handlers[name] = handler; }
};
retry.closest = () => cell;
retry.addEventListener = (_, handler) => { handlers.retry = handler; };
let requests = 0, payload;
vm.runInNewContext(script, {
    document: {
        addEventListener: (_, handler) => handler(), getElementById: () => feedback,
        querySelectorAll: selector => selector === '.grade-input' ? [input] : [retry],
        querySelector: () => input.dataset.unsaved === '1' ? input : null
    },
    window: { addEventListener: (name, handler) => { handlers[name] = handler; } },
    $: { ajax: options => {
        requests++; payload = options;
        const request = {};
        for (const event of ['done', 'fail', 'always']) request[event] = callback => { callbacks[event] = callback; return request; };
        return request;
    } }
});

handlers.input(); handlers.change();
assert.equal(requests, 1); assert.equal(payload.type, 'POST');
assert.equal(payload.data._token, 'isolated-csrf'); assert.equal(payload.data.student_id, '41');
assert.equal(total.textContent, '55'); assert.equal(input.readOnly, true); assert.equal(input.disabled, false);
handlers.change(); assert.equal(requests, 1); // Repeated change cannot duplicate an in-flight save.
callbacks.fail({ responseJSON: { errors: { value: ['Rejected mark'] } } }); callbacks.always();
assert.equal(total.textContent, '55'); assert.equal(retry.hidden, false);
assert.equal(input['aria-invalid'], 'true'); assert.equal(feedback.textContent, 'Rejected mark');
assert.equal(input.disabled, false); assert.equal(input.dataset.unsaved, '1');
let prevented = false;
handlers.beforeunload({ preventDefault: () => { prevented = true; } });
assert.equal(prevented, true);

input.value = '0'; handlers.retry();
callbacks.done({ success: true, value: 0, total: 55 }); callbacks.always();
assert.equal(input.value, 0); assert.equal(total.textContent, 55);
assert.equal(input.dataset.unsaved, undefined); assert.equal(input['aria-invalid'], undefined);
assert.equal(feedback.textContent, 'saved'); assert.equal(retry.hidden, true);
input.value = '5'; handlers.input(); handlers.change();
callbacks.done({ success: false, message: 'Not saved' }); callbacks.always();
assert.equal(total.textContent, 55); assert.equal(feedback.textContent, 'Not saved');
assert.equal(retry.hidden, false);
console.log('PASS: pending, repeated click, POST/CSRF, failure, retry, zero, server total and unsaved warning');
