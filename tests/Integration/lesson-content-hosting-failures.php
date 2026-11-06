<?php

// Included exclusively by the existing guarded disposable MariaDB runner.
if (!isset($database, $storage) || !preg_match('/^aladham_lesson_test_[a-f0-9]{16}$/D', $database)
    || $db::selectOne('SELECT DATABASE() AS db')->db !== $database
    || !preg_match('/^aladham-lesson-test-[a-f0-9]{32}$/D', basename($storage))) {
    throw new RuntimeException('Hosting failure fixtures cannot use school storage/database.');
}
$diskName = App\Services\LessonContentStorage::DISK;
$originalConfig = config('filesystems.disks.'.$diskName);
$logPath = $storage.'/logs/hosting-failures.log';
$originalLog = config('logging.default');
$originalSingle = config('logging.channels.single');
config(['logging.default'=>'single', 'logging.channels.single.path'=>$logPath]);
Illuminate\Support\Facades\Log::forgetChannel('single');
$selectDisk = function ($configuration) use ($diskName) {
    config(['filesystems.disks.'.$diskName=>$configuration]);
    app('filesystem')->forgetDisk($diskName);
};
$failure = function ($response, $label, $before, $logOffset) use ($check, $snapshot, $assertStatus, $logPath) {
    $assertStatus($response, 500, $label);
    $check(json_decode($response->getContent(), true) === ['message'=>__('lesson_content.failed')], $label.': response contains only localized generic message');
    $check($snapshot() === $before, $label.': no partial parent/attachment/notice/private-file state');
    $log = file_get_contents($logPath);
    $check(strlen($log) > $logOffset && strpos(substr($log, $logOffset), 'LessonContent') !== false, $label.': exception logged privately with application stack');
};
$logOffset = function () use ($logPath) { return file_exists($logPath) ? strlen(file_get_contents($logPath)) : 0; };

try {
    $before=$snapshot(); $offset=$logOffset();
    $selectDisk(null);
    $response=$create([$upload()]);
    $selectDisk($originalConfig);
    $failure($response, 'missing private-disk configuration', $before, $offset);

    $rootFile=$storage.'/uploads/private-root-is-file'; file_put_contents($rootFile, 'Fixture path collision');
    $before=$snapshot(); $offset=$logOffset();
    $selectDisk(array_replace($originalConfig, ['root'=>$rootFile]));
    $response=$create([$upload()]);
    $selectDisk($originalConfig);
    $failure($response, 'private root points at a regular file', $before, $offset);

    $journalRoot=$storage.'/hosting-journal-collision'; mkdir($journalRoot);
    file_put_contents($journalRoot.'/journals', 'Not a directory');
    $before=$snapshot(); $offset=$logOffset();
    $selectDisk(array_replace($originalConfig, ['root'=>$journalRoot]));
    $response=$create([$upload()]);
    $selectDisk($originalConfig);
    $failure($response, 'journal directory unavailable', $before, $offset);

    $filesRoot=$storage.'/hosting-files-collision'; mkdir($filesRoot);
    file_put_contents($filesRoot.'/files', 'Not a directory');
    $before=$snapshot(); $offset=$logOffset();
    $selectDisk(array_replace($originalConfig, ['root'=>$filesRoot]));
    $response=$create([$upload()]);
    $selectDisk($originalConfig);
    $failure($response, 'attachment write fails after journal and parent creation', $before, $offset);
    $check(glob($filesRoot.'/journals/*.json') === [], 'certain rollback removes owned failed-write journal');

    // A table existing is not proof that every required child column was deployed.
    $before=$snapshot(); $offset=$logOffset();
    $db::statement('ALTER TABLE lesson_content_attachments CHANGE mime_type fixture_missing_mime_type VARCHAR(127) NOT NULL');
    try { $response=$create([$upload()]); }
    finally { $db::statement('ALTER TABLE lesson_content_attachments CHANGE fixture_missing_mime_type mime_type VARCHAR(127) NOT NULL'); }
    $failure($response, 'partial child schema passes feature gate but fails INSERT', $before, $offset);

    // Notification INSERT is inside the transaction; external push is not.
    $before=$snapshot(); $offset=$logOffset();
    $db::statement("CREATE TRIGGER fixture_notification_failure BEFORE INSERT ON notifications FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Fixture notification INSERT failure'");
    try { $response=$create([$upload()]); }
    finally { $db::statement('DROP TRIGGER fixture_notification_failure'); }
    $failure($response, 'notification INSERT fails after attachment storage', $before, $offset);

    $db::statement('RENAME TABLE lesson_content_attachments TO fixture_absent_attachment_table');
    try { $response=$create([$upload()]); }
    finally { $db::statement('RENAME TABLE fixture_absent_attachment_table TO lesson_content_attachments'); }
    $assertStatus($response, 404, 'completely absent attachment table fails closed, not generic save error');

    $queue=config('queue.default'); config(['queue.default'=>'fixture_unconfigured_queue']);
    try { $response=$create([$upload()]); }
    finally { config(['queue.default'=>$queue]); }
    $assertStatus($response, 200, 'post-commit push dispatch failure does not fail persisted upload');
    $check(App\LessonContentAttachment::where('content_id', json_decode($response->getContent(), true)['content_id'])->count() === 1,
        'post-commit dispatch failure retains committed attachment');

    $data=$payload(); $data['attachment_count']=2;
    $response=$create([$upload('recovered-a.txt'), $upload('recovered-b.txt')], $data);
    $assertStatus($response, 200, 'normal two-file upload works after fixture environment restoration');
    $receipt=json_decode($response->getContent(), true)['content_id']; $before=$snapshot();
    $response=$create([$upload('recovered-a.txt'), $upload('recovered-b.txt')], $data);
    $assertStatus($response, 200, 'same successful receipt remains idempotent after hosting failures');
    $check(json_decode($response->getContent(), true)['content_id'] === $receipt && $snapshot() === $before, 'retry cannot duplicate committed group/files/notifications');
} finally {
    $selectDisk($originalConfig);
    config(['logging.default'=>$originalLog, 'logging.channels.single'=>$originalSingle]);
    Illuminate\Support\Facades\Log::forgetChannel('single');
}
