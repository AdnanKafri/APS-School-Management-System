const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');

const events = {};
const elements = {};
let requests = [], reloads = 0;
function element(key) {
    if (elements[key]) return elements[key];
    const value = {
        attributes: {}, state: {}, children: [], value: '', textValue: '',
        data(name, next) { if (next === undefined) return this.state[name]; this.state[name] = next; return this; },
        attr(name, next) { if (next === undefined) return this.attributes[name]; this.attributes[name] = next; return this; },
        prop(name, next) { this[name] = next; return this; },
        val(next) { if (next === undefined) return this.value; this.value = next; return this; },
        empty() { this.children = []; this.textValue = ''; return this; },
        append(child) { this.children.push(child); return this; },
        text(next) { this.textValue = next; return this; },
        find(selector) { return element(selector); },
        serialize() { return '_token=fixture-csrf&student_id=41&password=fixture-only'; },
        modal(action) { this.modalAction = action; return this; },
        DataTable() { return { ajax: { reload: () => reloads++ } }; }
    };
    elements[key] = value;
    return value;
}
const document = {};
function $(selector, attributes) {
    if (selector === document) return { on: (event, target, handler) => { events[event + ' ' + target] = handler; } };
    if (typeof selector === 'object') return selector;
    if (selector === '<p>') return { text: attributes.text };
    if (selector === '#student-delete-form [name=password]') return element('[name=password]');
    return element(selector);
}
$.each = (values, callback) => Object.entries(values).forEach(([key, value]) => callback(key, value));
$.fn = { dataTable: { isDataTable: () => true } };
$.ajax = options => {
    const callbacks = {};
    const chain = { done(fn) { callbacks.done = fn; return this; }, fail(fn) { callbacks.fail = fn; return this; }, always(fn) { callbacks.always = fn; return this; } };
    requests.push({ options, callbacks });
    return chain;
};
vm.runInNewContext(fs.readFileSync('public/assets/admin/js/student-delete.js', 'utf8'), {
    jQuery: $, document, window: { location: { reload() { reloads++; } } }
});
const form = element('#student-delete-form');
form.attributes.action = '/SMT/admin/delete_student';
for (const key of ['session', 'forbidden', 'invalid', 'failed', 'network']) form.state[key] = key + '-localized';
const submit = () => {
    let prevented = false;
    events['submit #student-delete-form'].call(form, { preventDefault() { prevented = true; } });
    assert.equal(prevented, true);
};
const finish = (type, data) => { const current = requests.at(-1); current.callbacks[type](data); current.callbacks.always(); };
assert.equal(typeof events['submit #student-delete-form'], 'function');
submit();
assert.equal(requests.length, 1);
assert.equal(requests[0].options.type, 'POST');
assert.equal(requests[0].options.url, '/SMT/admin/delete_student');
assert.match(requests[0].options.data, /_token=fixture-csrf&student_id=41&password=/);
assert.equal(element('#student-delete-submit').disabled, true);
submit(); assert.equal(requests.length, 1, 'in-flight duplicate prevented');
element('[name=password]').value = 'fixture-only';
finish('fail', { status: 422, responseJSON: { errors: { password: ['كلمة المرور غير صحيحة.'], student_id: ['<script>not executable</script>'] } } });
assert.equal(element('#student-delete-errors').hidden, false);
assert.deepEqual(element('#student-delete-errors').children.map(child => child.text), ['كلمة المرور غير صحيحة.', '<script>not executable</script>']);
assert.equal(element('#student-delete-submit').disabled, false);
assert.equal(form.state.submitting, false);
assert.equal(element('[name=password]').value, '');
for (const [status, key] of [[401,'session'],[419,'session'],[403,'forbidden'],[404,'invalid'],[405,'invalid'],[500,'failed'],[0,'network'],[200,'network']]) {
    submit(); finish('fail', { status });
    assert.equal(element('#student-delete-errors').children[0].text, key + '-localized');
    assert.equal(element('#student-delete-submit').disabled, false);
}
submit(); finish('done', { unexpected: true });
assert.equal(reloads, 0, 'unconfirmed response cannot trigger successful refresh');
submit(); finish('done', { student_id: 41, message: 'تم حذف الطالب.' });
assert.equal(element('#delete_class').modalAction, 'hide');
assert.equal(element('#student-delete-feedback').textValue, 'تم حذف الطالب.');
assert.equal(element('#student-delete-feedback').hidden, false);
assert.equal(reloads, 1, 'confirmed success reloads server-backed table once');
element('[name=password]').value = 'fixture-only';
events['hidden.bs.modal #delete_class']();
assert.equal(element('[name=password]').value, '');
const blade = fs.readFileSync('resources/views/admin/student.blade.php', 'utf8');
assert.equal((blade.match(/id="student-delete-form"/g) || []).length, 1);
assert.equal((blade.match(/student-delete\.js/g) || []).length, 1);
assert.match(blade, /on\('click', '\.delete_class_modal'/);
assert.match(blade, /old\('student_delete_form'\)/);
console.log('PASS: delegated form, CSRF payload, duplicate guard, validation/status/network errors, safe text, recovery, confirmed refresh and password clearing.');
