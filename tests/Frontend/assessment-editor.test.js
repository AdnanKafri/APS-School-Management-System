const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const handlers = {}, callbacks = {};
let ready, requests = 0, reloads = 0, initializations = 0, filter, confirmed = false, prompts = 0;
const errors = { hidden: true, textContent: '', lines: [], setAttribute() {}, focus() {}, appendChild(line) { this.lines.push(line.textContent); } };
const button = { textContent: 'Save', disabled: false };
const submitKey='[data-assessment-form], [data-assessment-delete]:submit';
const form = { action: '/isolated-quiz-update', dataset: {}, elements: {}, reportValidity: () => true,
    querySelector(selector) { if(selector==='[type="submit"]')return button;if(selector==='[data-assessment-errors]')return errors;return this.elements[selector.match(/name="([^"]+)/)?.[1]] || null; },
    querySelectorAll:()=>[],
    reset() { Object.values(this.elements).forEach(field => { field.value = ''; }); }
};
['quize_id','content_name','is_file','lesson_id','room_id','start_date','end_date','mark','period','required_lectures','question_picker','notes','confirm_window_change'].forEach(name => { form.elements[name] = { value: '',setAttribute(){},classList:{add(){}},parentNode:{appendChild(){}} }; });
const createForm = { elements: { lesson_id: { value: 'keep-create' } } };
const document = { body: {}, querySelectorAll:()=>[], getElementById: () => ({ dataset: { saving: 'Saving', failed: 'Failed',session:'Expired',denied:'Denied',missing:'Missing' } }), createElement: () => ({ textContent: '',setAttribute(){} }) };
const table = { column: () => ({ search: value => { filter = value; return { draw() {} }; } }) };
function $(target) {
    if (typeof target === 'function') { ready = target; return; }
    if (target === document) return { on: (event, selector, handler) => { handlers[selector + ':' + event] = handler; } };
    if (target === form) return { serialize: () => '_token=fixture&quize_id=17&confirm_window_change=' + (form.elements.confirm_window_change?.value || '0'),
        trigger: () => handlers[submitKey].call(form, { preventDefault() {} }) };
    return {
        appendTo() {}, DataTable() { initializations++; return table; },
        on(event, handler) { handlers[target + ':' + event] = handler; }, each() {}
    };
}
$.fn = { DataTable() {}, dataTable: { isDataTable: () => false, util: { escapeRegex: value => value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') } } };
$.ajax = options => { requests++; assert.equal(options.method, 'POST'); assert.equal(options.headers.Accept, 'application/json'); assert.ok(options.data.includes('_token=')); const xhr = {}; ['done','fail','always'].forEach(name => { xhr[name] = handler => { callbacks[name] = handler; return xhr; }; }); return xhr; };
const moduleFixture = { exports: {} };
vm.runInNewContext(fs.readFileSync('public/assets/admin/js/assessment-editor.js','utf8'), {
    window: { jQuery: $, confirm() { prompts++; return confirmed; }, location: { reload() { reloads++; } } }, document, module: moduleFixture
});
ready();
const api = moduleFixture.exports;
assert.equal(api.localDate('2026-10-22 09:03:12'),'2026-10-22T09:03:12');
assert.equal(api.localDate('2026-10-22T09:03'),'2026-10-22T09:03:00');
assert.equal(api.localDate('bad'),'');
const data = { id: '17', name: 'Arabic fixture', is_file: '1', lesson_id: '409', room_id: '132', start_date: '2026-10-22 09:03:12', end_date: '2026-10-22 11:00:00', mark: '20', period: '40', required_lectures: '0', question_picker: '2', notes: 'exact notes' };
const trigger = { getAttribute: name => data[name.slice(5)] ?? null };
handlers['#assessment-edit:show.bs.modal'].call({ querySelector: selector => selector === 'form' ? form : errors }, { relatedTarget: trigger });
assert.equal(form.elements.quize_id.value,'17'); assert.equal(form.elements.is_file.value,'1');
assert.equal(form.elements.lesson_id.value,'409'); assert.equal(form.elements.notes.value,'exact notes');
assert.equal(form.elements.required_lectures.value,'0'); assert.equal(form.elements.start_date.value,'2026-10-22T09:03:12');
assert.equal(createForm.elements.lesson_id.value,'keep-create');
const submit = handlers[submitKey], event = { preventDefault() {} };
submit.call(form,event); submit.call(form,event); assert.equal(requests,1); assert.equal(button.disabled,true);
callbacks.fail({ status:422,responseJSON: { errors: { mark: ['Keep entered values'] } } }); callbacks.always();
assert.equal(errors.lines[0],'Keep entered values'); assert.equal(form.elements.notes.value,'exact notes'); assert.equal(button.disabled,false);
submit.call(form,event); callbacks.done({ success: true }); callbacks.always(); assert.equal(reloads,1);
const afterSuccess=requests;submit.call(form,event);assert.equal(requests,afterSuccess);assert.equal(button.disabled,true);
// Simulate the fresh document after successful navigation for subsequent cases.
form.dataset.saving='0';button.disabled=false;button.textContent='Save';
assert.equal(prompts,0);
submit.call(form,event);
callbacks.fail({ status: 422, responseJSON: { errors: { confirm_window_change: ['Retained records: confirm rescheduling'] } } }); callbacks.always();
assert.equal(prompts,1); assert.equal(form.elements.confirm_window_change.value,'0');
const cancelledRequests = requests;
confirmed = true;
submit.call(form,event);
callbacks.fail({ status: 422, responseJSON: { errors: { confirm_window_change: ['Retained records: confirm rescheduling'] } } }); callbacks.always();
assert.equal(requests,cancelledRequests+2); assert.equal(form.elements.confirm_window_change.value,'1'); assert.equal(button.disabled,true);
callbacks.done({ success:true }); callbacks.always(); assert.equal(reloads,2); assert.equal(form.elements.confirm_window_change.value,'0');
form.dataset.saving='0';button.disabled=false;button.textContent='Save';
form.elements.confirm_window_change.value='1';
handlers['[data-assessment-form] [name="start_date"], [data-assessment-form] [name="end_date"]:input change'].call({ form });
assert.equal(form.elements.confirm_window_change.value,'0');
submit.call(form,event);
callbacks.fail({ status:422, responseJSON:{ errors:{ confirm_window_change:['Risk'], mark:['Invalid maximum'] } } }); callbacks.always();
assert.equal(prompts,2);
form.elements.confirm_window_change.value='1'; api.populate(form,trigger); assert.equal(form.elements.confirm_window_change.value,'0');
handlers['#lesson_id_filter:change'].call({ value: '409', selectedIndex: 0, options: [{ text: 'English (A)' }] });
assert.equal(filter,'^\\s*English \\(A\\)\\s*$'); assert.equal(initializations,1);
const all={checked:false,disabled:false},sections={disabled:false,options:[{selected:true},{selected:false}]},summary={};
const group={dataset:{allCount:'5',countLabel:'Count :count'},querySelector:s=>s==='[data-all-sections]'?all:s==='[data-specific-sections]'?sections:summary};
api.syncSections(group);assert.equal(sections.disabled,false);assert.equal(summary.textContent,'Count 1');
all.checked=true;api.syncSections(group);assert.equal(sections.disabled,true);assert.equal(summary.textContent,'Count 5');
all.checked=false;sections.options[1].selected=true;api.syncSections(group);assert.equal(sections.disabled,false);assert.equal(summary.textContent,'Count 2');
all.disabled=true;all.checked=true;api.syncSections(group);assert.equal(sections.disabled,false);
delete form.elements.confirm_window_change;form.elements.delete_code={value:'fixture-only'};
for(const [status,text] of [[401,'Expired'],[419,'Expired'],[403,'Denied'],[404,'Missing'],[500,'Failed']]) {
    submit.call(form,event);callbacks.fail({status,responseJSON:{message:'Do not expose server internals'}});callbacks.always();
    assert.equal(errors.lines.at(-1),text);assert.equal(form.elements.delete_code.value,'');
}
submit.call(form,event);callbacks.done('<html>Login</html>');callbacks.always();assert.equal(errors.lines.at(-1),'Expired');
console.log('PASS: modal/context reset, exclusive section serialization states/counts, field errors, CSRF, duplicate/success guards, risky-window confirmation and deletion/session/server feedback');
