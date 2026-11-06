const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const events = {}, windowEvents = {};
let approved = true, valid = true;
const button = {disabled:false};
const form = {
    dataset:{confirm:'Confirm removal?'}, attrs:{}, matches:()=>true,
    checkValidity:()=>valid, setAttribute(key,value){this.attrs[key]=value;},
    removeAttribute(key){delete this.attrs[key];}, querySelectorAll:()=>[button]
};
vm.runInNewContext(fs.readFileSync('public/teachers_2/assets/js/lesson-content-management.js','utf8'),{
    document:{addEventListener:(key,handler)=>events[key]=handler,querySelectorAll:()=>[form]},
    window:{confirm:()=>approved,setTimeout:handler=>handler(),addEventListener:(key,handler)=>windowEvents[key]=handler}
});
const submit = () => {const event={target:form,preventDefault(){this.prevented=true;}};events.submit(event);return event;};
approved=false; assert.equal(submit().prevented,true); assert.equal(button.disabled,false);
approved=true; valid=false; submit(); assert.equal(form.dataset.pending,undefined);
valid=true; assert.equal(submit().prevented,undefined); assert.equal(button.disabled,true); assert.equal(form.attrs['aria-busy'],'true');
assert.equal(submit().prevented,true);
windowEvents.pageshow(); assert.equal(button.disabled,false); assert.equal(form.dataset.pending,undefined); assert.equal(form.attrs['aria-busy'],undefined);
delete form.dataset.confirm; submit(); assert.equal(button.disabled,true);
console.log('PASS: confirmation/cancel, native validation, duplicate-submit guard and back-page recovery.');
