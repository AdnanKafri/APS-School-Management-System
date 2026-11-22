const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');

// Exercise the actual delegated handler, substituting only Blade's named URL.
const source = fs.readFileSync('resources/views/admin/student.blade.php', 'utf8');
const start = source.indexOf("$(document).on('click', '.change_student', function () {");
const end = source.indexOf("$('.changeStudentModal').on('hidden.bs.modal'", start);
assert.ok(start >= 0 && end > start);
const bladeUrl = "@json(route('student_detail_prev', ['student_id'=>'__STUDENT_ID__']))";
assert.ok(source.slice(start, end).includes(bladeUrl));
const script = source.slice(start, end).replace(bladeUrl, JSON.stringify('/SMT/admin/students/student_detail_prev/__STUDENT_ID__'));
const document = {}, elements = {}, requests = [];
let click;
const studentInput = { value: '', val(value) { if (value === undefined) return this.value; this.value = value; return this; } };
function $(selector) {
    if (selector === document) return { on(event, target, handler) { assert.equal(target, '.change_student'); click = handler; } };
    if (typeof selector === 'object') return selector;
    if (selector === '#student_id' || selector === '.changeStudentModal input[name="student_id"]') return studentInput;
    return elements[selector] ||= {
        prop(key, value) { this[key] = value; return this; },
        empty() { this.emptied = true; return this; },
        text(value) { this.textValue = value; return this; }
    };
}
$.ajax = options => requests.push(options);
vm.runInNewContext(script, { $, document, encodeURIComponent });
assert.equal(typeof click, 'function');
const notice = () => elements['.changeStudentModal .student-transfer-record-notice'];
const select = id => click.call({ data(key) { return key === 'id' ? id : 'اسم الطالب'; } });
select(41);
assert.equal(notice().hidden, true);
assert.equal(requests[0].url, '/SMT/admin/students/student_detail_prev/41');
assert.equal(requests[0].type, 'get');
requests[0].success({ has_academic_records: true });
assert.equal(notice().hidden, false);
select(42);
assert.equal(notice().hidden, true);
requests[0].success({ has_academic_records: true });
assert.equal(notice().hidden, true, 'Late response must not affect another student');
requests[1].success({ has_academic_records: false });
assert.equal(notice().hidden, true);
select(41);
requests[2].success({ has_academic_records: true });
assert.equal(notice().hidden, false);
console.log('Student transfer notice: named route, delegated handler, history state and late responses passed.');
