const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');

class Element {
    constructor(tag) { this.tag = tag; this.children = []; this.events = {}; this.attrs = {}; this.dataset = {}; }
    appendChild(child) { this.children.push(child); child.parentElement = this; }
    removeChild(child) { this.children.splice(this.children.indexOf(child), 1); }
    get firstChild() { return this.children[0]; }
    setAttribute(key, value) { this.attrs[key] = value; }
    addEventListener(key, callback) { this.events[key] = callback; }
    dispatchEvent(event) { if (this.events[event.type]) this.events[event.type](event); }
    focus() { this.focused = true; }
}
function fixture(transferAvailable = true, limited = false) {
    const group = new Element('div'), input = new Element('input'), field = new Element('div');
    const selectedCount = {}, form = {querySelector: () => selectedCount};
    field.dataset = {filesLabel: 'الملفات المحددة:', removeLabel: 'إزالة', reselectLabel: 'أعد الاختيار'};
    if (limited) input.dataset.maxFiles = '5';
    input.setCustomValidity = value => input.validationMessage = value;
    input.closest = selector => selector === '.Group' ? group : selector === 'form' ? form : field;
    input.files = [];
    Object.defineProperty(input, 'value', {set(value) { assert.equal(value, ''); this.files = []; }});
    const listeners = {};
    class Transfer {
        constructor() { this.files = []; this.items = {add: item => this.files.push(item)}; }
    }
    vm.runInNewContext(fs.readFileSync('public/teachers_2/assets/js/lesson-upload-selection.js', 'utf8'), {
        document: {readyState: 'complete', querySelectorAll: () => [input], createElement: tag => new Element(tag)},
        window: {DataTransfer: transferAvailable ? Transfer : undefined, addEventListener: (key, callback) => listeners[key] = callback},
        Event: class { constructor(type) { this.type = type; } }
    });
    const preview = group.children[0], count = preview.children[0], list = preview.children[1];
    function select(names) { input.files = names.map(name => typeof name === 'string' ? {name, size: 1} : name); input.dispatchEvent({type: 'change'}); }
    return {input, group, preview, count, list, select, listeners, selectedCount};
}

const f = fixture();
assert.equal(f.preview.hidden, true);
const long = 'الملف العربي ' + 'long.name.with.dots.'.repeat(15) + '.bin.sha256sum';
f.select([long]);
assert.equal(f.preview.hidden, false);
assert.equal(f.count.textContent, 'الملفات المحددة: 1');
const details = f.list.children[0].children[0];
assert.equal(details.tag, 'details');
assert.equal(details.children[0].tag, 'summary');
assert.equal(details.children[0].children[0].textContent, long);
assert.equal(details.children[0].children[0].title, long);
assert.equal(details.children[1].textContent, long);
f.list.children[0].children[1].dispatchEvent({type: 'click'});
assert.equal(f.input.files.length, 0); assert.equal(f.preview.hidden, true); assert.equal(f.input.focused, true);

const names = ['same.pdf', 'same.pdf', '<script>alert(1)</script>.pdf', long, ' spaces and English.txt'];
f.select(names);
assert.equal(f.count.textContent, 'الملفات المحددة: 5');
assert.equal(f.list.children.length, 5);
const injected = f.list.children[2].children[0].children[0].children[0];
assert.equal(injected.textContent, names[2]); assert.equal(injected.innerHTML, undefined);
f.list.children[1].children[1].dispatchEvent({type: 'click'});
assert.deepEqual(Array.from(f.input.files, file => file.name), [names[0], ...names.slice(2)]);
assert.equal(f.list.children.length, 4);
f.listeners.pageshow(); assert.equal(f.list.children.length, 4); assert.equal(f.group.children.length, 1);

const older = fixture(false);
older.select(['a.pdf', 'b.pdf']);
assert.equal(older.list.children[0].children.length, 1);
older.select(['a.pdf']); older.list.children[0].children[1].dispatchEvent({type: 'click'});
assert.equal(older.input.files.length, 0);

f.select(['a.pdf', 'b.pdf']);
Object.defineProperty(f.input, 'files', {get: () => [{name:'a.pdf'}, {name:'b.pdf'}], set() { throw Error('Read only'); }});
f.list.children[0].children[1].dispatchEvent({type: 'click'});
assert.equal(f.count.textContent, 'أعد الاختيار'); assert.equal(f.input.files.length, 2);

const limits = fixture(true, true);
limits.select(['a.txt','b.txt']); assert.equal(limits.selectedCount.value, 2); assert.equal(limits.input.validationMessage, '');
limits.select(Array(6).fill('a.txt')); assert.match(limits.input.validationMessage, /خمسة/);
limits.select([{name:'large.txt',size:10*1024*1024+1}]); assert.match(limits.input.validationMessage, /10 MiB/);
limits.select(Array(3).fill({name:'nine.txt',size:9*1024*1024})); assert.match(limits.input.validationMessage, /25 MiB/);
limits.select(['valid.txt']); assert.equal(limits.input.validationMessage, ''); assert.equal(limits.selectedCount.value, 1);
limits.list.children[0].children[1].dispatchEvent({type:'click'}); assert.equal(limits.selectedCount.value, 0);
console.log('PASS: previews, long/mixed/duplicate names, safe text, removal, fallback, pageshow, upload limits and submitted file count.');
