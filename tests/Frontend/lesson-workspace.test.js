const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');

function element(attrs = {}, classes = []) {
    const values = new Set(classes);
    return { attrs, events: {}, children: [],
        classList: { contains: x => values.has(x), toggle: (x, on) => on ? values.add(x) : values.delete(x) },
        getAttribute(key) { return this.attrs[key]; },
        setAttribute(key, value) { this.attrs[key] = value; },
        addEventListener(key, cb) { this.events[key] = cb; },
        appendChild(child) { this.children.push(child); },
        querySelector() { return this.children[0]; },
        focus() { this.focused = true; }
    };
}

function fixture(direction, initial = 0) {
    const panels = {}, tabs = Array.from({length: 7}, (_, i) => {
        const tab = element({href: '#Section' + (i + 1)});
        tab.parentElement = element({}, i === initial ? ['active'] : []);
        panels['Section' + (i + 1)] = element();
        return tab;
    });
    const list = {querySelectorAll: () => tabs};
    const input = element(); input.parentElement = element();
    const submit = element(); const form = element(); form.checkValidity = () => true;
    const listeners = {}, timers = [];
    function $(items) {
        if (typeof items === 'function') { items(); return; }
        if (items === '.lc-tabs') items = [list];
        else if (items === '.lc-entry-form input[type="file"]') items = [input];
        else if (items === '.lc-entry-form, .lc-modal form') items = [form];
        else items = Array.isArray(items) ? items : [items];
        const api = {
            each(fn) { items.forEach(x => fn.call(x)); return api; },
            on(name, fn) { items.forEach(x => x.events[name] = fn); return api; },
            attr(name, value) { items.forEach(x => x.attrs[name] = value); return api; },
            removeAttr(name) { items.forEach(x => delete x.attrs[name]); return api; },
            prop(name, value) { items.forEach(x => x[name] = value); return api; },
            find() { return $([submit]); },
            tab(action) { assert.equal(action, 'show'); items.forEach(x => x.events['shown.bs.tab']()); return api; }
        };
        return api;
    }
    vm.runInNewContext(fs.readFileSync('public/assets/js/lesson-workspace.js', 'utf8'), {
        jQuery: $, document: {getElementById: id => panels[id], createElement: () => element()},
        window: {getComputedStyle: () => ({direction}), setTimeout: fn => timers.push(fn), addEventListener: (name, fn) => listeners[name] = fn}
    });
    return {tabs, panels, input, submit, form, timers, listeners};
}

for (const direction of ['rtl', 'ltr']) {
    const files = fixture(direction, 1);
    assert.equal(files.tabs[1].attrs['aria-selected'], 'true');
    assert.equal(files.tabs[1].attrs.tabindex, '0');
    files.tabs[4].events['shown.bs.tab']();
    assert.equal(files.tabs[4].attrs['aria-selected'], 'true');
    assert.equal(files.tabs[1].attrs['aria-selected'], 'false');
    assert.equal(files.tabs.filter(t => t.parentElement.classList.contains('active')).length, 1);
    const f = fixture(direction);
    f.tabs.forEach((tab, i) => {
        assert.equal(tab.attrs['aria-controls'], 'Section' + (i + 1));
        assert.equal(f.panels['Section' + (i + 1)].attrs['aria-labelledby'], tab.id);
        assert.equal(tab.attrs.tabindex, i ? '-1' : '0');
    });
    const key = (tab, value) => tab.events.keydown({key: value, preventDefault() {}});
    key(f.tabs[0], 'ArrowRight');
    assert.equal(f.tabs[direction === 'rtl' ? 6 : 1].attrs['aria-selected'], 'true');
    key(f.tabs[6], 'Home'); assert.equal(f.tabs[0].attrs['aria-selected'], 'true');
    key(f.tabs[0], 'End'); assert.equal(f.tabs[6].attrs['aria-selected'], 'true');
    assert.equal(f.tabs.filter(t => t.parentElement.classList.contains('active')).length, 1);
    f.tabs[3].events['shown.bs.tab']();
    assert.equal(f.tabs[3].attrs['aria-selected'], 'true');
    f.input.files = [{name: 'ملف عربي طويل.pdf'}, {name: '<script>alert(1)</script>.txt'}];
    f.input.events.change.call(f.input);
    assert.equal(f.input.parentElement.children.length, 1);
    assert.equal(f.input.parentElement.children[0].textContent, 'ملف عربي طويل.pdf، <script>alert(1)</script>.txt');
    assert.equal(f.input.parentElement.children[0].innerHTML, undefined);
    f.input.files = []; f.input.events.change.call(f.input);
    assert.equal(f.input.parentElement.children[0].textContent, '');
    f.form.checkValidity = () => false; f.form.events.submit.call(f.form);
    assert.equal(f.timers.length, 0);
    f.form.checkValidity = () => true; f.form.events.submit.call(f.form);
    assert.equal(f.submit.disabled, undefined);
    f.timers.shift()(); assert.equal(f.submit.disabled, true); assert.equal(f.form.attrs['aria-busy'], 'true');
    f.listeners.pageshow(); assert.equal(f.submit.disabled, false); assert.equal(f.form.attrs['aria-busy'], undefined);
}
const css = fs.readFileSync('public/assets/css/lesson-workspace.css', 'utf8');
assert.match(css, /width: 100% !important; max-width: 100%; left: auto !important; right: auto !important; top: auto !important/);
assert.match(css, /max-width: 100% !important/);
assert.match(css, /max-width: 767px/); assert.match(css, /max-width: 359px/);
assert.match(css, /100dvh/); assert.match(css, /overflow-wrap: anywhere/);
assert.doesNotMatch(css, /\.breadcrumbs/);
// The shell owns its fixed-header clearance in both sidebar states.
assert.doesNotMatch(css, /\.main-panel\s*\{/);
assert.match(css, /body\.student-portal-body \.lc-page\.lc-lesson-page \.tab\s*\{\s*top: auto !important; left: auto !important; right: auto !important; width: 100% !important;/);
console.log('PASS: RTL/LTR tab mappings, keyboard navigation, Bootstrap event sync, escaped long filenames, validation/busy/BFCache handling, scoped legacy CSS resets. Not a browser layout test.');
