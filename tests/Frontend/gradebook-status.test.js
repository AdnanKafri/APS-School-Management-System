// Isolated event/AJAX harness. This is not a browser visual test.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
let script = fs.readFileSync('resources/views/admin/gradebook/view_subjects.blade.php', 'utf8')
    .match(/<script>([\s\S]*?)<\/script>/)[1]
    .replace(/@json\(__\('gradebook\.([^']+)'\)\)/g, (_, key) => JSON.stringify(key));
let confirmed = false, requests = 0, reloads = 0, request;
const feedback = {};
const context = {
    confirm: () => confirmed,
    document: { getElementById: () => feedback },
    location: { reload: () => reloads++ },
    $: { ajax: options => { request = options; requests++; } }
};
vm.runInNewContext(script, context);
const control = { checked: true, disabled: false, dataset: { accepted: 'LOCKED' } };
context.toggleGradebookStatus(2, 20, control);
assert.equal(control.checked, false);
assert.equal(requests, 0);
confirmed = true; control.checked = true;
context.toggleGradebookStatus(2, 20, control);
assert.equal(control.disabled, true);
assert.equal(request.type, 'POST');
assert.equal(request.data.status, 'OPEN');
assert.equal(request.data.term_id, 20);
request.error({ responseJSON: { message: 'Denied' } }); request.complete();
assert.equal(control.checked, false); assert.equal(control.disabled, false);
assert.equal(feedback.textContent, 'Denied'); assert.equal(reloads, 0);
control.checked = true; context.toggleGradebookStatus(2, 20, control);
request.success({ success: false }); request.complete();
assert.equal(control.checked, false); assert.equal(feedback.textContent, 'write_failed');
control.checked = true; context.toggleGradebookStatus(2, 20, control);
request.success({ success: true, status: 'OPEN' }); request.complete();
assert.equal(control.dataset.accepted, 'OPEN'); assert.equal(reloads, 1);
console.log('PASS: lock cancel, pending, rejection, failed response, retry and confirmed state');
