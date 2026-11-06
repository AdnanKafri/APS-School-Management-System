// Isolated event/AJAX harness. This is not a browser visual test.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
let script = fs.readFileSync('resources/views/admin/gradebook/partials/status_script.blade.php', 'utf8')
    .match(/<script>([\s\S]*?)<\/script>/)[1]
    .replace(/@json\(__\('(?:gradebook|gradebook_ux)\.([^']+)'\)\)/g, (_, key) => JSON.stringify(key));
let confirmed = false, requests = 0, reloads = 0, request;
const feedback = {};
const context = {
    confirm: () => confirmed,
    document: { getElementById: () => feedback },
    location: { reload: () => reloads++ },
    $: { ajax: options => { request = options; requests++; } }
};
vm.runInNewContext(script, context);
const control = { checked: true, disabled: false, dataset: { accepted: 'LOCKED' }, setAttribute(key,value){this[key]=value;}, removeAttribute(key){delete this[key];}, querySelector(){return null;} };
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
assert.equal(control.dataset.accepted, 'OPEN'); assert.equal(reloads, 0); assert.equal(control['aria-checked'],'true');
delete control.checked; control.disabled=false;
context.toggleGradebookStatus(2,20,control); assert.equal(request.data.status,'LOCKED');
context.toggleGradebookStatus(2,20,control); assert.equal(control.disabled,true);
request.error({responseJSON:{message:'Retry'}});request.complete();
assert.equal(control.checked,undefined);assert.equal(control.dataset.accepted,'OPEN');
confirmed=false;const before=requests;context.toggleGradebookStatus(2,20,control);assert.equal(requests,before);assert.equal(control.checked,undefined);
confirmed=true;context.toggleGradebookStatus(2,20,control);assert.equal(request.data.status,'LOCKED');
request.success({success:true,status:'LOCKED'});request.complete();assert.equal(control['aria-checked'],'false');assert.equal(reloads,0);
console.log('PASS: lock cancel, pending, rejection, failed response, retry and confirmed state');
