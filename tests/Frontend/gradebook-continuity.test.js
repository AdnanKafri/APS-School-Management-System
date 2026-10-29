// Run after the isolated Phase 1 feature tests. This is not browser QA.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const os = require('node:os');
const path = require('node:path');
const vm = require('node:vm');
const files = ['teacher_exam_student', 'teacher_quize_students', 'teacher_exammark_auto', 'teacher_quize_students_outo'];
let filters = 0;
for (const file of files) {
    const blade = fs.readFileSync(`resources/views/teachers2/${file}.blade.php`, 'utf8');
    const branches = [...blade.matchAll(/if \(value\.continuity_row\) \{([\s\S]*?)\n\s*\}/g)];
    assert.ok(branches.length >= 2, `${file}: filtered rows must retain read-only provenance`);
    for (const branch of branches) {
        const appended = [];
        const render = vm.runInNewContext(`(function(value) { if(value.continuity_row) {${branch[1]}} throw new Error('Editable fallthrough'); })`, {
            $: selector => {
                assert.equal(selector, '.table1 tbody');
                return { append: html => appended.push(html) };
            }
        });
        render({continuity_row: '<tr data-continuity-row="41"><td>0</td></tr>'});
        assert.equal(appended.length, 1);
        assert.ok(!appended[0].includes('<input'));
        filters++;
    }
    if (blade.includes('student_save_mark3')) {
        const request = blade.slice(blade.indexOf("var url = \"{{ URL::to('SMARMANger/dashboard/teacher/student_save_mark3')"));
        assert.match(request, /type: "post",\s*headers: \{ 'X-CSRF-TOKEN': @json\(csrf_token\(\)\) \}/);
        assert.match(request, /error: function \(xhr\)/);
    }
}
let scripts = 0;
for (const kind of ['exam', 'quize']) for (const file of [0, 1]) {
    const html = fs.readFileSync(path.join(os.tmpdir(), `aladham-phase1-${kind}-${file}.html`), 'utf8');
    assert.match(html, /data-continuity="carried"/);
    for (const match of html.matchAll(/<script\b[^>]*>([\s\S]*?)<\/script>/gi)) {
        if (match[1].trim()) {
            new vm.Script(match[1], {filename: `${kind}-${file}-${scripts}.js`});
            scripts++;
        }
    }
}
console.log(`PASS: ${filters} legacy filter branches, POST/CSRF/error feedback, ${scripts} rendered scripts compile`);
