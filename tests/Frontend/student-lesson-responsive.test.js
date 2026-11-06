const assert = require('node:assert/strict');
const fs = require('node:fs');
const postcss = require('postcss');
const selectorParser = require('postcss-selector-parser');
const cssSelect = require('css-select');
const htmlParser = require('htmlparser2');

// CSS cascade regression, not a browser rendering/overflow measurement.
const sheet = 'public/student/assets/css/lesson-content-cards.css';
const blade = fs.readFileSync('resources/views/students/new_lecture_content.blade.php', 'utf8');
const sources = [
    'public/student/assets/vendors/css/vendor.bundle.base.css',
    'public/student/assets/css/demo_1/style.css',
    'public/student/assets/css/student-sidebar.css',
    'public/student/assets/css/student-portal-v2.css',
    null,
    'public/student/assets/css/demo_1/showcontent_style.css',
    'public/assets/css/lesson-workspace.css',
    sheet
];
const markup = role => `<html><body class="${role}-portal-body"><div class="container-scroller">
<main class="main-panel sp-content-page lc-page lc-lesson-page"><div class="content-wrapper"><div class="container slc-workspace">
<div class="row slc-workspace-row"><div class="col-md-12"><div class="container slc-workspace-inner"><div class="row slc-workspace-row"><div class="col-12 lc-tabs-column">
<div class="tab"><ul class="nav nav-tabs lc-tabs"><li><a href="#Section1"><i></i>المحتوى العلمي</a></li><li class="active"><a href="#Section2">الملفات</a></li></ul>
<div class="tab-content tabs"><section class="tab-pane active" id="Section2"><div class="container"><div class="row">
<div class="col-md-4 step1"><article class="box"><div class="shape"><div class="number"><i class="material-icons">description</i></div></div>
<div class="slc-content-body"><ul class="slc-attachments"><li><details class="slc-attachment-file"><summary><bdi class="slc-attachment-name" dir="auto">long-filename.txt</bdi></summary><bdi class="slc-attachment-full" dir="auto">long-filename.txt</bdi></details><div class="slc-attachment-actions"><a class="slc-content-action">عرض</a><a class="slc-content-action">تنزيل</a></div></li></ul></div>
</article></div></div></div></section></div></div></div></div></div></div></div></div></main></div></body></html>`;

function specificity(selector) {
    const result = [0, 0, 0];
    selectorParser(root => root.walk(node => {
        if (node.type === 'id') result[0]++;
        else if (node.type === 'class' || node.type === 'attribute') result[1]++;
        else if (node.type === 'tag') result[2]++;
        else if (node.type === 'pseudo' && ![':not', ':is', ':where'].includes(node.value)) result[node.value.startsWith('::') ? 2 : 1]++;
    })).processSync(selector);
    return result;
}
const rules = [];
for (const source of sources) {
    const text = source ? fs.readFileSync(source, 'utf8') : blade.match(/<style>([\s\S]*?)<\/style>/)[1];
    postcss.parse(text, {from: source || 'inline'}).walkRules(rule => {
        if (!/\.box|\.shape|\.main-panel|\.tab\b|\.lc-|\.slc-|\.container|\.row|\.nav-tabs/.test(rule.selector)) return;
        if (/:hover|:active|:focus|::|:before|:after/.test(rule.selector)) return;
        const media = [];
        for (let parent = rule.parent; parent; parent = parent.parent) if (parent.type === 'atrule' && parent.name === 'media') media.push(parent.params);
        for (const selector of rule.selectors) {
            let matches;
            try { matches = cssSelect.compile(selector); } catch (_) { continue; }
            rules.push({matches, specificity:specificity(selector), media, source, declarations:rule.nodes.filter(n => n.type === 'decl')});
        }
    });
}
function mediaMatches(query, width) {
    return query.split(',').some(part => !/\bprint\b|min-wdith/.test(part) && [...part.matchAll(/\((min|max)-width:\s*([\d.]+)px\)/g)].every(([, limit, value]) => limit === 'min' ? width >= +value : width <= +value));
}
function computed(node, width, current = true) {
    const properties = {};
    for (const rule of rules) {
        if ((!current && rule.source === sheet) || !rule.media.every(q => mediaMatches(q, width)) || !rule.matches(node)) continue;
        for (const decl of rule.declarations) {
            let props = [decl.prop];
            if (decl.prop === 'inset' && decl.value === 'auto') props = ['top', 'right', 'bottom', 'left'];
            for (const property of props) {
                const priority = [decl.important ? 1 : 0, ...rule.specificity];
                const previous = properties[property];
                const difference = previous ? priority.map((value, i) => value - previous.priority[i]).find(value => value !== 0) : 1;
                if (difference === undefined || difference >= 0) properties[property] = {value:decl.value, priority};
            }
        }
    }
    return Object.fromEntries(Object.entries(properties).map(([key, item]) => [key, item.value]));
}
const student = htmlParser.parseDOM(markup('student'));
const one = selector => cssSelect.selectOne(selector, student);
let checks = 0;
for (const width of [320, 360, 390, 480, 600, 768, 1366, 1920]) {
    const box = computed(one('.box'), width);
    assert.equal(box.left, 'auto'); assert.equal(box.right, 'auto');
    assert.equal(box.width, '100%'); assert.equal(box['min-width'], '0');
    assert.equal(box.overflow, 'visible'); assert.equal(box.display, 'grid');
    const shape = computed(one('.shape'), width);
    assert.equal(shape.width, '44px'); assert.equal(shape.height, '44px');
    const tab = computed(one('.tab'), width);
    assert.equal(tab.width, '100%'); assert.equal(tab.left, 'auto'); assert.equal(tab.right, 'auto');
    assert.equal(tab.overflow, 'visible');
    const tabs = computed(one('.lc-tabs'), width);
    if (width <= 767) assert.equal(tabs['grid-template-columns'], 'repeat(2, minmax(0, 1fr))');
    if (width <= 479) assert.equal(computed(one('.slc-content-action'), width)['min-height'], '44px');
    assert.deepEqual(computed(one('.main-panel'), width), computed(one('.main-panel'), width, false));
    checks++;
}
assert.equal(computed(one('.box'), 360, false).left, '128px');
assert.equal(computed(one('.shape'), 390, false).width, '233px');
assert.equal(computed(one('.slc-attachment-name'), 320)['text-overflow'], 'ellipsis');
assert.equal(computed(one('.slc-attachment-full'), 320)['overflow-wrap'], 'anywhere');
const teacher = htmlParser.parseDOM(markup('teacher'));
for (const selector of ['.main-panel', '.box', '.shape', '.lc-tabs']) {
    const node = cssSelect.selectOne(selector, teacher);
    assert.deepEqual(computed(node, 390), computed(node, 390, false));
}
assert.match(blade, /slc-workspace-inner/);
assert.match(blade, /responsive3/);
console.log(`PASS: real stylesheet cascade at ${checks} widths, legacy important offsets/icon sizes, compact tabs, accessible filenames; Student shell and Teacher rules unchanged. Browser pixel acceptance remains pending.`);
