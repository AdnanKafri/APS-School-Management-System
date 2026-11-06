// Isolated modal DOM harness; not browser/viewport QA.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const units = require('../../public/assets/admin/js/gradebook-distribution-units.js');
const handlers = {}, ids = {}, rows = [], modalCalls = [];
let confirms = 0, accept = false, cancelled = false, updates = 0;
function field(value = '') { return {value, dataset:{}, required:false, readOnly:false, disabled:false,
    setCustomValidity(message){this.error=message;}, parentElement:{}, focus(){this.focused=true;},
    addEventListener(name,handler){this[name]=handler;} }; }
function row(id, used='0') {
    const r={dataset:{used,explicit:'0'}, index:{}, fields:{}, buttons:{}};
    r.fields.id=field(id);r.fields.source=field('100');r.fields.name=field('Component');r.fields.weight=field('25');r.fields.marks=field();
    for(const key of ['component-up','component-down']) r.buttons[key]={disabled:false};
    r.querySelector=s=> s==='[name$="[id]"]'?r.fields.id:s==='.index-cell'?r.index:s==='.component-name'?r.fields.name:s==='.weight-input'?r.fields.weight:s==='.allocation-mark-input'?r.fields.marks:s==='td:nth-child(2) small'?{textContent:'source kind'}:r.buttons[s.slice(1)];
    r.querySelectorAll=()=>Object.entries(r.fields).filter(([k])=>k!=='marks').map(([key,f])=>{f.name='components[x]['+key+']';return f;});
    r.remove=()=>rows.splice(rows.indexOf(r),1);
    Object.defineProperty(r,'previousElementSibling',{get:()=>rows[rows.indexOf(r)-1]});
    Object.defineProperty(r,'nextElementSibling',{get:()=>rows[rows.indexOf(r)+1]});
    return r;
}
rows.push(row('manual_a'),row('manual_b','1'));
ids.componentsBody={querySelectorAll:()=>rows,addEventListener:(name,handler)=>handlers['body:'+name]=handler,
    appendChild:r=>rows.push(r),insertBefore(r,before){rows.splice(rows.indexOf(r),1);rows.splice(rows.indexOf(before),0,r);}};
Object.defineProperty(ids.componentsBody,'lastElementChild',{get:()=>rows[rows.length-1]});
ids.configForm={dataset:{subjectTotal:'200',manual:'manual',inexact:'inexact',impact:'impact',limit:'limit'},
    dispatchEvent(){updates++;},addEventListener:(name,handler)=>handlers['form:'+name]=handler};
for(const key of ['componentName','componentPercent','componentMarks','componentMode','componentFeedback','componentKind','componentProtection','components-empty','addRowBtn','componentDialog'])ids[key]=field();
ids.componentMode.value='percent';
ids.componentDialogForm={reset(){ids.componentMode.value='percent';},reportValidity:()=>!ids.componentMarks.error,addEventListener:(name,handler)=>handlers['editor:'+name]=handler};
ids['component-row-template']={content:{cloneNode:()=>row('')}};
function $(target){return {appendTo(){},modal(action){modalCalls.push(action);},on(name,handler){handlers[name]=handler;}};}
$.fn={modal(){}};
vm.runInNewContext(fs.readFileSync('public/assets/admin/js/gradebook-component-editor.js','utf8'),{
    document:{addEventListener:(_,handler)=>handler(),getElementById:id=>ids[id],body:{}},Event:function(){},
    window:{jQuery:$,GradebookDistributionUnits:units,confirm(){confirms++;return accept;},alert(){}}
});
function click(r,kind){handlers['body:click']({target:{closest:s=>s==='button'?{classList:{contains:c=>c===kind}}:r}});}
function apply(){handlers['editor:submit']({preventDefault(){}});}
assert.equal(rows[0].fields.weight.readOnly,true);
click(rows[0],'component-edit');assert.equal(modalCalls.at(-1),'show');
ids.componentName.value='Unsaved edit';assert.equal(rows[0].fields.name.value,'Component');
ids.componentName.value='Renamed';apply();assert.equal(rows[0].fields.name.value,'Renamed');assert.equal(rows[0].fields.id.value,'manual_a');
ids.addRowBtn.click();ids.componentName.value='New manual';ids.componentPercent.value='25';
ids.componentMode.value='marks';ids.componentMode.change();assert.equal(ids.componentMarks.value,'50');
ids.componentMarks.value='67';ids.componentMarks.input();assert.equal(ids.componentMarks.error,'inexact');apply();assert.equal(rows.length,2);
ids.componentMarks.value='100';ids.componentMarks.input();assert.equal(ids.componentPercent.value,'50');apply();assert.equal(rows.length,3);
assert.equal(rows[2].fields.weight.value,'50');
assert.ok(updates>=3);
click(rows[2],'component-up');assert.equal(rows[1].fields.id.value,'');
click(rows[0],'delete-row');assert.equal(rows.length,2);
click(rows[1],'delete-row');assert.equal(rows.length,2); // Used field cannot be removed.
click(rows[1],'component-edit');assert.equal(ids.componentPercent.readOnly,true);assert.equal(ids.componentMode.disabled,true);
handlers['form:submit']({defaultPrevented:false,preventDefault(){cancelled=true;}});assert.equal(cancelled,true);assert.equal(confirms,1);
accept=true;cancelled=false;handlers['form:submit']({defaultPrevented:false,preventDefault(){cancelled=true;}});assert.equal(cancelled,false);
rows[1].dataset.used='0';click(rows[1],'delete-row');click(rows[0],'delete-row');assert.equal(rows.length,0);assert.equal(ids['components-empty'].hidden,false);
console.log('PASS: modal add/edit/cancel, stable identities, exact absolute conversion, used-bound protection, reorder, explicit empty and impact confirmation');
