const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const events={}, callbacks={}, inputs=[], feedback={dataset:{legacyMarkUrl:'/single',token:'csrf',room:'132',lesson:'409',exam:'17',saving:'saving',saved:'saved',failed:'failed',empty:'empty',pending:'pending'}};
let count=0, request;
function input(student,value) {
    const hidden={exam_result_id:{value:''},user_id:{value:student}}, label={dataset:{},setAttribute(){}};
    const row={querySelector:s=>hidden[s.match(/name="([^"]+)/)?.[1]],querySelectorAll:()=>[hidden.exam_result_id]};
    const cell={querySelector:()=>cell.label,appendChild:l=>cell.label=l};
    const field={dataset:{id:student},defaultValue:value,disabled:false,readOnly:false,offsetParent:{},
        matches:()=>true, reportValidity:()=>true,step:'1',closest:s=>s==='td'?cell:row,
        setAttribute(k,v){this[k]=v;},removeAttribute(k){delete this[k];},focus(){this.focused=true;}};
    let stored=value;Object.defineProperty(field,'value',{get:()=>stored,set:v=>stored=String(v)});
    row.querySelector=s=>s==='[name="mark"]'?field:hidden[s.match(/name="([^"]+)/)?.[1]];
    const button={disabled:false,closest:()=>row};
    field.button=button;field.row=row;inputs.push(field);return field;
}
const a=input('41',''), b=input('42','25');
const bulkForm={action:'/bulk',querySelector:()=>({value:'exam2'})};
const panel={querySelector:()=>bulkForm};
const bulkButton={disabled:false,closest:()=>panel};
const window={jQuery:{ajax(options){request=options;count++;const xhr={};for(const key of ['done','fail','always'])xhr[key]=f=>{callbacks[key]=f;return xhr;};return xhr;}},
    addEventListener:(key,handler)=>events[key]=handler,location:{reload(){throw Error('Unexpected reload');}}};
vm.runInNewContext(fs.readFileSync('public/teachers_2/assets/js/legacy-grade-entry.js','utf8'),{
    document:{addEventListener(key,handler){if(key==='DOMContentLoaded')handler();else events[key]=handler;},
        getElementById:()=>feedback,querySelectorAll:()=>inputs,createElement:()=>({dataset:{},setAttribute(){}})},window});
function click(field){events.click({target:{closest:()=>field.button},preventDefault(){}});}
a.value='0';events.input({target:a});click(a);click(a);
assert.equal(count,1);assert.equal(a.readOnly,true);assert.equal(a.disabled,false);
assert.equal(request.data.mark,'0');assert.equal(request.data.user_id,'41');assert.equal(request.headers.Accept,'application/json');assert.equal(request.headers['X-CSRF-TOKEN'],'csrf');
callbacks.done({success:true,student_id:41,exam_id:17,result_id:91,value:0});callbacks.always();
assert.equal(a.value,'0');assert.equal(a.row.querySelector('[name="exam_result_id"]').value,91);assert.equal(a.dataset.unsaved,undefined);
assert.equal(a.dataset.resultId,'91');
a.value='13.5';events.input({target:a});click(a);callbacks.fail({status:422,responseJSON:{errors:{mark:['Too high']}}});callbacks.always();
assert.equal(a.value,'13.5');assert.equal(a['aria-invalid'],'true');assert.equal(feedback.textContent,'Too high');assert.equal(a.dataset.unsaved,'1');
let warned=false;events.beforeunload({preventDefault(){warned=true;}});assert.equal(warned,true);
window.teacherBulkSave(bulkButton);const before=count;window.teacherBulkSave(bulkButton);assert.equal(count,before);assert.equal(request.url,'/bulk');
const rows=JSON.parse(request.data.rows);assert.equal(rows.length,2);assert.equal(rows[0].mark,'13.5');assert.equal(request.data.kind,'exam2');
callbacks.done({success:true,message:'saved',rows:[{student_id:41,exam_id:17,result_id:91,value:13.5},{student_id:42,exam_id:17,result_id:92,value:25}]});callbacks.always();
assert.equal(a.dataset.unsaved,undefined);assert.equal(a.readOnly,false);assert.equal(b.readOnly,false);assert.equal(bulkButton.disabled,false);
events.keydown({key:'Enter',target:a,preventDefault(){}});callbacks.done({success:true,student_id:41,exam_id:17,result_id:91,value:13.5});callbacks.always();assert.equal(b.focused,true);
let prevented=false;
events.submit({target:{matches:()=>true,closest:()=>null,elements:{namedItem:()=>a}},preventDefault(){prevented=true;}});
assert.equal(prevented,true);assert.equal(request.data.exam_result_id,91);
callbacks.done({success:true,student_id:41,exam_id:17,result_id:91,value:13.5});callbacks.always();
click(a);callbacks.fail({status:422,responseJSON:{errors:{entry_window:['Ended']}}});callbacks.always();assert.equal(a.disabled,true);assert.equal(feedback.textContent,'Ended');
// Execute each real traditional filter callback, not a replacement renderer.
for (const view of ['teacher_quize_students','teacher_exam_student']) {
    const blade=fs.readFileSync(`resources/views/teachers2/${view}.blade.php`,'utf8');
    const script=[...blade.matchAll(/<script\b[^>]*>([\s\S]*?)<\/script>/g)].find(match=>match[1].includes("'.choice'"))[1];
    let change, ajax, rendered=[];
    const document={};
    const $=selector=>({
        on(event,control,handler){assert.equal(control,'.choice');change=handler;},
        val(){if(typeof selector==='object')return selector.filter;if(selector==='#success_mark')return '50';if(selector==='.homeid')return '2423';return '132';},
        empty(){rendered=[];},append(html){rendered.push(html);}
    });
    $.ajax=options=>ajax=options;
    $.each=(rows,handler)=>rows.forEach((row,index)=>handler(index,row));
    vm.runInNewContext(script,{$,document,console:{log(){}},moment:()=>({format:()=>''}),Date});
    for (const filter of ['0','1','2']) {
        change.call({filter});assert.equal(ajax.type,'get');
        for (const result of [undefined,{id:91,exam_id:2423,user_id:41,result:null},{id:91,exam_id:2423,user_id:41,result:0}]) {
            ajax.success([{id:41,first_name:'طالب',last_name:'اختبار',exam_result2:result?[result]:[],exams_files:[]}]);
            const html=rendered.join('');
            assert.equal((html.match(/name="mark"/g)||[]).length,1,`${view}/${filter}: one mark input per student`);
            assert.match(html,/max="50"/);
            assert.ok(!html.includes('undefined'));
            if(result && result.result===0)assert.match(html,/value="0"/);
        }
    }
}
console.log('PASS: delegated legacy AJAX/POST, first result IDs, no reload, zero/blank, keyboard/expiry and all six real quiz/exam filter branches');
