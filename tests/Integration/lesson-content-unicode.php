<?php

if (!isset($database, $storage) || !preg_match('/^aladham_lesson_test_[a-f0-9]{16}$/D', $database)
    || $db::selectOne('SELECT DATABASE() AS db')->db !== $database) {
    throw new RuntimeException('Unicode fixtures require a disposable database.');
}
// Reproduce the actual legacy column, not the fixture database's utf8mb4 default.
$db::statement('ALTER TABLE lesson_teacher_room_term_exam DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci');
$db::statement('ALTER TABLE lesson_teacher_room_term_exam MODIFY name_addition TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL');
$db::statement('ALTER TABLE lesson_teacher_room_term_exam MODIFY note TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL');
$before = $snapshot();
$unicodeInput = $payload();
$unicodeInput['note'] = "ملاحظات عربية مع رموز 🙏🌹𐍈𝄞 English";
$response = $create([$upload('unicode.txt')], $unicodeInput);
$assertStatus($response, 500, 'legacy three-byte note reproduces production emoji failure through real upload route');
$check(json_decode($response->getContent(), true) === ['message'=>__('lesson_content.failed')], 'encoding failure uses existing safe generic response');
$check($snapshot() === $before && $disk->files('journals') === [], 'rejected parent INSERT leaves no upload, notice, file or journal');

require_once $project.'/database/migrations/2026_11_14_000001_ensure_lesson_content_note_utf8mb4.php';
$unicodeMigration = new EnsureLessonContentNoteUtf8mb4();
$tableRows = function () use ($db) { return json_encode($db::table('lesson_teacher_room_term_exam')->orderBy('id')->get()); };
$metadata = function () use ($db) {
    return $db::select("SELECT COLUMN_NAME,COLUMN_TYPE,IS_NULLABLE,COLUMN_DEFAULT,CHARACTER_SET_NAME,COLLATION_NAME,EXTRA,COLUMN_COMMENT
        FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam' ORDER BY ORDINAL_POSITION");
};
$originalRows=$tableRows(); $originalColumns=$metadata();
$childDdl=(array)$db::selectOne('SHOW CREATE TABLE lesson_content_attachments');
$rejectMigration = function ($label) use ($unicodeMigration, $check) {
    try { $unicodeMigration->up(); $check(false, $label); }
    catch (RuntimeException $e) { $check(true, $label); }
};
$db::statement("ALTER TABLE lesson_teacher_room_term_exam ALTER COLUMN note SET DEFAULT 'unreviewed default'");
$rejectMigration('unexpected default fails closed');
$db::statement('ALTER TABLE lesson_teacher_room_term_exam ALTER COLUMN note SET DEFAULT NULL');
$db::statement('CREATE INDEX fixture_note_index ON lesson_teacher_room_term_exam (note(5))');
$rejectMigration('indexed note requires review instead of implicit index changes');
$db::statement('DROP INDEX fixture_note_index ON lesson_teacher_room_term_exam');
$db::statement('SET NAMES utf8');
try { $rejectMigration('three-byte application session requires explicit review'); }
finally { $db::statement('SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'); }

Illuminate\Support\Facades\Artisan::call('migrate', [
    '--path'=>'database/migrations/2026_11_14_000001_ensure_lesson_content_note_utf8mb4.php', '--force'=>true,
]);
$check($tableRows() === $originalRows, 'note-only migration preserves every existing parent field and value');
$afterColumns=$metadata();
foreach ($originalColumns as $index=>$column) {
    $after=$afterColumns[$index];
    if ($column->COLUMN_NAME === 'note') {
        $check($after->CHARACTER_SET_NAME === 'utf8mb4' && $after->COLLATION_NAME === 'utf8mb4_unicode_ci', 'note supports four-byte Unicode');
        $after->CHARACTER_SET_NAME=$column->CHARACTER_SET_NAME; $after->COLLATION_NAME=$column->COLLATION_NAME;
    }
    $check((array)$after === (array)$column, 'other column attributes preserved: '.$column->COLUMN_NAME);
}
$check((array)$db::selectOne('SHOW CREATE TABLE lesson_content_attachments') === $childDdl, 'attachment schema and ownership FK untouched');
$check($db::selectOne("SELECT TABLE_COLLATION c FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam'")->c === 'utf8_general_ci', 'legacy table default remains unchanged');
$check($db::table('migrations')->count()===2 && $db::table('migrations')->where('migration','2026_11_14_000001_ensure_lesson_content_note_utf8mb4')->count()===1, 'explicit path registers only the reviewed Unicode migration');
$unicodeMigration->up();
Illuminate\Support\Facades\Artisan::call('migrate', ['--path'=>'database/migrations/2026_11_14_000001_ensure_lesson_content_note_utf8mb4.php','--force'=>true]);
$check($tableRows()===$originalRows && $db::table('migrations')->count()===2, 'already-compatible physical schema and Artisan rerun are no-ops');

$notes = [
    'Arabic'=>'ملاحظات عربية دون رموز',
    'Arabic emoji'=>'ملاحظات عربية 🙏🌹',
    'supplementary'=>"😀🧑🏽‍🏫𐍈𝄞𠀀",
    'mixed'=>"Arabic العربية English notes 🌍\nSecond line سطر ثانٍ",
    'null'=>null,
    'empty'=>'',
    'near limit'=>str_repeat('ع',1996).'😀𐍈𝄞🌹',
    'quotes'=>"قال: 'مرحباً' \"Hello\" & <script>plain text</script> \\ path 🌹",
];
$unicodeGroups=[];
foreach ($notes as $label=>$note) {
    $input=$payload(); $input['note']=$note;
    $files=$label==='mixed' ? [$upload('أول 📘.txt'),$upload('second.txt')] : [$upload('note.txt')];
    $input['attachment_count']=count($files);
    $response=$create($files,$input); $assertStatus($response,200,'Unicode create: '.$label);
    $contentId=json_decode($response->getContent(),true)['content_id']; $unicodeGroups[]=$contentId;
    // The existing TrimStrings/ConvertEmptyStringsToNull middleware is preserved.
    $expected=$note==='' ? null : $note;
    $actual=App\Lesson_teacher_room_term_exam::findOrFail($contentId)->note;
    $check($actual===$expected,'exact Unicode/NULL round trip: '.$label);
    $check(App\LessonContentAttachment::where('content_id',$contentId)->count()===count($files),'correct single/multiple attachment count: '.$label);
}
$tooLong=$payload();$tooLong['note']=str_repeat('😀',2001);
$assertStatus($create([$upload()],$tooLong),422,'existing 2000-character note limit unchanged');
$linkOnly=$payload();$linkOnly['note']='رابط مع ملاحظة 🌹';$linkOnly['addition_link']='https://example.test/lesson';
$response=$create([],$linkOnly);$assertStatus($response,200,'Unicode link-only entry');
$linkId=json_decode($response->getContent(),true)['content_id'];
$check(App\Lesson_teacher_room_term_exam::find($linkId)->note===$linkOnly['note'] && App\LessonContentAttachment::where('content_id',$linkId)->count()===0,'link-only notes require no invented attachment');
$editId=$unicodeGroups[0]; $editUrl='/SMARMANger/dashboard/teacher/lesson-content/'.$editId.'/update';
foreach ([1=>'أضيفت رموز 🌹𐍈',2=>'تمت إزالة الرموز'] as $revision=>$note) {
    $response=$http($accounts[1],'POST',$editUrl,['revision'=>$revision,'name_addition'=>'Unicode edit fixture','note'=>$note,'addition_link'=>null]);
    $assertStatus($response,200,'edit notes: revision '.$revision);
    $check(App\Lesson_teacher_room_term_exam::find($editId)->note===$note,'edited note preserved exactly');
}
$newAttachment=App\LessonContentAttachment::where('content_id',$editId)->firstOrFail();
$response=$http($accounts[2],'GET','/SMARMANger/lesson-content/attachments/'.$newAttachment->id.'/download');
$assertStatus($response,200,'authorized Student download after Unicode migration');
$check(hash_file('sha256',$response->getFile()->getPathname())===$newAttachment->sha256,'Unicode note changes do not alter file bytes');
$assertStatus($http($accounts[3],'GET','/SMARMANger/lesson-content/attachments/'.$newAttachment->id.'/download'),403,'foreign Student remains denied');
$response=$http($accounts[2],'GET','/SMARMANger/dashboard/student/lesson/lecture/content/409/41/5037',[],[],['HTTP_ACCEPT'=>'text/html']);
$assertStatus($response,200,'Student grouped/legacy presentation after Unicode notes');
$check(strpos($response->getContent(),'🌹')!==false && strpos($response->getContent(),'&lt;script&gt;plain text&lt;/script&gt;')!==false,'Student view renders emoji and escapes note markup');
$check(strpos($response->getContent(),'filesteachers/legacy.pdf')!==false,'legacy single-file presentation remains intact');

$unicodeFailure=false;
App\LessonContentAttachment::creating(function () use (&$unicodeFailure) { if ($unicodeFailure) throw new RuntimeException('Unicode fixture late attachment failure'); });
$before=$snapshot();$rowsBeforeFailure=$tableRows();$unicodeFailure=true;
try { $response=$create([$upload()],$unicodeInput); }
finally { $unicodeFailure=false; }
$assertStatus($response,500,'deliberate failure after Unicode parent/file creation');
$check($snapshot()===$before && $tableRows()===$rowsBeforeFailure && $disk->files('journals')===[], 'Unicode failure rolls back rows and cleans only newly owned bytes');
try { $unicodeMigration->down();$check(false,'Unicode narrowing rollback must refuse'); }
catch (RuntimeException $e) { $check(App\Lesson_teacher_room_term_exam::find($unicodeGroups[2])->note===$notes['supplementary'],'rollback refuses without removing supplementary Unicode'); }

// The title column intentionally retains its legacy three-byte encoding.
$check($db::selectOne("SELECT CHARACTER_SET_NAME c FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam' AND COLUMN_NAME='name_addition'")->c === 'utf8', 'unrelated title encoding deliberately unchanged');
