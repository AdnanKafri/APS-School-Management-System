<?php

// Copies local schema definitions only into a new random DB; no migrations or school writes.
require __DIR__.'/post-transfer-corrections-mariadb.php';
if (!preg_match('/^aladham_student_workflow_test_[a-f0-9]{16}$/D',$database)
    || $db::selectOne('SELECT DATABASE() AS db')->db !== $database) throw new RuntimeException('Unsafe media fixture.');
use App\Services\LessonContentLimits;
use App\Services\LessonContentStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

config(['lesson_content.enabled'=>true,'lesson_content.max_files'=>20,'lesson_content.max_file_bytes'=>2040*1048576,
    'lesson_content.max_total_bytes'=>2040*1048576,'filesystems.disks.lesson_content_private.root'=>$storage.'/app/lesson-content-private']);
app()->instance(LessonContentLimits::class,new class extends LessonContentLimits {
    protected function runtime() { return ['file'=>2147483648,'post'=>2147483648,'count'=>20]; }
});
$db::table('lectures')->insert(['id'=>8501,'teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'year_id'=>6,
    'term_id'=>20,'lecture_time'=>now()->subHour(),'active'=>0,'name'=>'Synthetic media acceptance']);
$db::table('lesson_teacher_room_term_exam')->insert(['id'=>8501,'teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,
    'lecture_id'=>8501,'term_id'=>20,'type'=>'4','name_addition'=>'Kept legacy attachment','addition'=>'filesteachers/kept.pdf']);
$legacy=$db::table('lesson_teacher_room_term_exam')->where('id',8501)->first();
foreach (['uploads','app/lesson-content-private'] as $dir) if(!is_dir($storage.'/'.$dir))mkdir($storage.'/'.$dir,0700,true);
$disk=Storage::disk(LessonContentStorage::DISK); $public=Storage::disk('public');
$public->put('filesteachers/kept.pdf','Original fixture bytes');
$upload=function($name,$bytes='Educational attachment')use($storage){$path=tempnam($storage.'/uploads','upload');file_put_contents($path,$bytes);return new UploadedFile($path,$name,null,UPLOAD_ERR_OK,true);};
$payload=function(){return ['type'=>'4','lecture_id'=>8501,'teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,
    'name_addition'=>'اختبار ملفات تعليمي','note'=>'ملاحظات آمنة','upload_token'=>(string)Illuminate\Support\Str::uuid()];};
$mediaHttp=function($user,$method,$url,$data=[],$files=[],$headers=[])use($app,$session){
    $app->instance('env','local');if($user)Illuminate\Support\Facades\Auth::setUser($user);else Illuminate\Support\Facades\Auth::logout();
    $request=Illuminate\Http\Request::create('http://localhost'.$url,$method,$data,[config('session.cookie')=>$session->getId()],$files,
        array_merge(['HTTP_ACCEPT'=>'application/json','HTTP_X_CSRF_TOKEN'=>$session->token()],$headers));
    return $app->make(Illuminate\Contracts\Http\Kernel::class)->handle($request);
};
$url='/SMARMANger/dashboard/teacher/classes_lessons/store_items';
$create=function($files,$data=null)use($mediaHttp,$teacher,$url,$payload){
    foreach($files as $f)if($f instanceof UploadedFile)clearstatcache(true,$f->getRealPath());
    $data=$data??$payload();$data['attachment_count']=$data['attachment_count']??count($files);return $mediaHttp($teacher,'POST',$url,$data,['attachments'=>$files]);
};
$snapshot=function()use($db,$disk){return [$db::table('lesson_teacher_room_term_exam')->count(),$db::table('lesson_content_attachments')->count(),$db::table('notifications')->count(),$disk->allFiles('files')];};
$check(app(LessonContentLimits::class)->values()===['max_files'=>20,'max_file_bytes'=>2139095040,'max_total_bytes'=>2139095040],'reported Hostinger profile leaves 8 MiB multipart budget');
$activeFiles=[];
foreach (['html'=>'<!doctype html><script>alert(1)</script>','css'=>'body { color: red; }','js'=>'alert("lesson");',
    'php'=>'<?php echo "source only";','svg'=>'<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>',
    'py'=>'print("lesson")','sh'=>"#!/bin/sh\necho lesson",'bat'=>"@echo off\necho lesson",'json'=>'{"lesson":true}',
    'xml'=>'<?xml version="1.0"?><lesson/>','yaml'=>'lesson: safe','ts'=>'const lesson: string = "safe";',
    'sql'=>'SELECT 1;','md'=>'# Lesson','tex'=>'\\documentclass{article}','srt'=>"1\n00:00:00,000 --> 00:00:01,000\nLesson"] as $ext=>$bytes) {
    $r=$create([$upload('درس.'.$ext,$bytes)]);$status($r,200,'private '.$ext.' upload');
    $content=json_decode($r->getContent(),true)['content_id'];$file=App\LessonContentAttachment::where('content_id',$content)->firstOrFail();
    $check(substr($file->path,-4)==='.bin' && $disk->get($file->path)===$bytes,'opaque private storage preserves '.$ext.' bytes');
    foreach (['view','download'] as $mode) {
        $download=$mediaHttp($studentUser,'GET','/SMARMANger/lesson-content/attachments/'.$file->id.'/'.$mode);
        $status($download,200,$ext.' authorized '.$mode);
        $check(strpos($download->headers->get('Content-Disposition'),'attachment;')===0
            && $download->headers->get('Content-Type')==='application/octet-stream'
            && $download->headers->get('X-Content-Type-Options')==='nosniff'
            && strpos($download->headers->get('Content-Security-Policy'),'sandbox')!==false,'active '.$ext.' never renders in origin');
    }
    $activeFiles[]=$file;
}
$file=$activeFiles[0];
$status($mediaHttp($teacher,'GET','/SMARMANger/lesson-content/attachments/'.$file->id.'/download'),200,'owner Teacher download');
$foreign=App\User::create(['name'=>'Foreign teacher','email'=>'foreign-media@example.test','type'=>'1','teacher_id'=>167,'password'=>bcrypt('fixture-only')]);
foreach ([$foreign,$admin,$officer] as $user) $status($mediaHttp($user,'GET','/SMARMANger/lesson-content/attachments/'.$file->id.'/view'),403,'non-owner/role denied private content');
$check(in_array($mediaHttp(null,'GET','/SMARMANger/lesson-content/attachments/'.$file->id.'/download')->getStatusCode(),[302,401],true),'guest cannot download');
$db::table('students')->insert(['id'=>7540,'first_name'=>'Outside','last_name'=>'Fixture','lifecycle_status'=>'active']);
$db::table('room_student')->insert(['student_id'=>7540,'year_id'=>6,'room_id'=>7133]);
$db::table('student_academic_placements')->insert(['student_id'=>7540,'year_id'=>6,'class_id'=>2,'room_id'=>7133,'status'=>'active','effective_from'=>now()->subDay()]);
$foreignStudent=App\User::create(['name'=>'Outside student','email'=>'outside-media@example.test','type'=>'0','student_id'=>7540,'password'=>bcrypt('fixture-only')]);
$status($mediaHttp($foreignStudent,'GET','/SMARMANger/lesson-content/attachments/'.$file->id.'/download'),403,'student outside authorized section/history denied');

$packages=['docx'=>['word/document.xml',null],'xlsx'=>['xl/workbook.xml',null],'pptx'=>['ppt/presentation.xml',null],
    'docm'=>['word/document.xml','word/vbaProject.bin'],'xlsm'=>['xl/workbook.xml','xl/vbaProject.bin'],'pptm'=>['ppt/presentation.xml','ppt/vbaProject.bin']];
foreach ($packages as $extension=>[$main,$macro]) {
    $f=$upload('package.'.$extension,'');$zip=new ZipArchive();$zip->open($f->getRealPath(),ZipArchive::OVERWRITE);
    $zip->addFromString('[Content_Types].xml','<Types/>');$zip->addFromString($main,'<document/>');if($macro)$zip->addFromString($macro,'Macro source fixture');$zip->close();
    $status($create([$f]),200,'Office '.$extension.' package accepted');
}
foreach (['odt'=>'text','ods'=>'spreadsheet','odp'=>'presentation','epub'=>null] as $extension=>$kind) {
    $f=$upload('open.'.$extension,'');$zip=new ZipArchive();$zip->open($f->getRealPath(),ZipArchive::OVERWRITE);
    $zip->addFromString('mimetype',$extension==='epub'?'application/epub+zip':'application/vnd.oasis.opendocument.'.$kind);
    $zip->addFromString($extension==='epub'?'META-INF/container.xml':'content.xml','<document/>');$zip->close();
    $status($create([$f]),200,'open package '.$extension.' accepted');
}
$zipFile=$upload('archive.zip','');$zip=new ZipArchive();$zip->open($zipFile->getRealPath(),ZipArchive::OVERWRITE);$zip->addFromString('lesson.php','<?php echo 1;');$zip->close();
$status($create([$zipFile]),200,'source archive stored privately without extraction');
$zip->open($zipFile->getRealPath());$zip->addFromString('malware.exe','MZ executable');$zip->close();
$before=$snapshot();$status($create([$zipFile]),422,'executable archive entry rejected');$check($before===$snapshot(),'rejected archive leaves no partial upload');
$files=[];for($i=0;$i<20;$i++)$files[]=$upload('same.txt');$status($create($files),200,'20-file request accepted');
$before=$snapshot();$files[]=$upload('21.txt');$status($create($files),422,'21-file request rejected');
$status($create([$upload('valid.txt'),$upload('fake.pdf','<html>not PDF</html>')]),422,'mixed invalid batch rejected');
$partial=$payload();$partial['attachment_count']=2;$status($create([$upload('one.txt')],$partial),422,'PHP truncation detected from selected count');
$unsafe=$upload('escape.php','<?php echo 1;');
$unsafe=new class($unsafe->getRealPath(),'escape.php',null,UPLOAD_ERR_OK,true) extends UploadedFile {
    public function getClientOriginalName(){return '../escape.php';}
};
$status($create([$unsafe]),422,'raw path traversal rejected even if normal framework basename normalization is bypassed');
$check($before===$snapshot(),'rejected batches create no records or files');
$db::unprepared("CREATE TRIGGER fixture_media_attachment_failure BEFORE INSERT ON lesson_content_attachments FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='isolated attachment failure'");
$status($create([$upload('source.php','<?php echo 1;')]),500,'DB failure after file write');$db::unprepared('DROP TRIGGER fixture_media_attachment_failure');
$check($before===$snapshot(),'private rollback compensates bytes and notifications');

$source=$project.'/login/assets/img/login-bg.mp4';if(!is_file($source))throw new RuntimeException('Existing non-school MP4 test asset missing');
$videoPath=tempnam($storage.'/uploads','video');copy($source,$videoPath);$video=new UploadedFile($videoPath,'lesson.mp4',null,UPLOAD_ERR_OK,true);
$r=$create([$video]);$status($r,200,'existing MP4 upload');$videoId=json_decode($r->getContent(),true)['content_id'];$videoFile=App\LessonContentAttachment::where('content_id',$videoId)->firstOrFail();
$range=$mediaHttp($studentUser,'GET','/SMARMANger/lesson-content/attachments/'.$videoFile->id.'/view',[],[],['HTTP_RANGE'=>'bytes=0-1023']);
$status($range,206,'video range request preserved');$check($range->headers->get('Content-Length')==='1024' && strpos($range->headers->get('Content-Disposition'),'inline;')===0,'safe media preview and bounded range response');
ob_start();$range->sendContent();$chunk=ob_get_clean();$h=fopen($source,'rb');$expected=fread($h,1024);fclose($h);$check($chunk===$expected,'video range streams exact original bytes');
$videoData=$payload();$videoData['type']='0';$videoData['name_video']='Legacy video';unset($videoData['note']);
$status($mediaHttp($teacher,'POST',$url,$videoData,['video_in'=>$video]),302,'legacy video tab preserves upload flow');
$legacyVideo=App\Lesson_teacher_room_term_exam::where('lecture_id',8501)->where('type','0')->firstOrFail();$keptVideo=$legacyVideo->video;
$db::unprepared("CREATE TRIGGER fixture_legacy_media_failure BEFORE UPDATE ON lesson_teacher_room_term_exam FOR EACH ROW BEGIN IF OLD.id=".(int)$legacyVideo->id." THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='isolated media failure'; END IF; END");
$publicBefore=$public->allFiles();$status($mediaHttp($teacher,'POST','/SMARMANger/dashboard/video/update/'.$legacyVideo->id,['name_video'=>'Updated'],['video'=>$video]),500,'legacy replacement failure reported');
$db::unprepared('DROP TRIGGER fixture_legacy_media_failure');
$check($publicBefore===$public->allFiles() && $public->exists($keptVideo) && $legacyVideo->fresh()->video===$keptVideo,'failed replacement retains previous file and compensates new bytes');
$status($mediaHttp($teacher,'POST','/SMARMANger/dashboard/video/update/'.$legacyVideo->id,['name_video'=>'Updated'],['video'=>$video]),302,'legacy video edit uses shared limits');
$check($public->exists($keptVideo) && $legacyVideo->fresh()->video!==$keptVideo,'successful edit does not delete the old stored attachment');
$wav='RIFF'.pack('V',36+800).'WAVEfmt '.pack('VvvVVvv',16,1,1,8000,8000,1,8).'data'.pack('V',800).str_repeat("\x80",800);
$audioData=$payload();$audioData['type']='6';$audioData['name_audio']='Legacy audio';unset($audioData['note']);
$status($mediaHttp($teacher,'POST',$url,$audioData,['audio_file'=>$upload('lesson.wav',$wav)]),302,'legacy audio tab uses safe media validator');
$bad=$mediaHttp($teacher,'POST',$url,$audioData,['audio_file'=>$upload('payload.php','<?php echo 1;')]);$status($bad,422,'public media tab rejects active content');
$check($db::table('lesson_teacher_room_term_exam')->where('id',8501)->first()==$legacy && $public->get('filesteachers/kept.pdf')==='Original fixture bytes','legacy record/path/bytes unchanged');

if (in_array('--large-file',$argv,true)) {
    $bytes=2040*1048576;
    if(disk_free_space($storage)<2*$bytes+512*1048576)throw new RuntimeException('Insufficient space for isolated near-2-GiB test');
    $path=tempnam($storage.'/uploads','large');$handle=fopen($path,'wb');$block=str_repeat("Educational text\n",65536);$left=$bytes;
    while($left>0){$part=min($left,strlen($block));if(fwrite($handle,substr($block,0,$part))!==$part)throw new RuntimeException('Fixture write failed');$left-=$part;}fclose($handle);
    $start=microtime(true);$large=new UploadedFile($path,'large.txt',null,UPLOAD_ERR_OK,true);$r=$create([$large]);$status($r,200,'actual 2040 MiB file accepted without whole-file buffering');
    $largeId=json_decode($r->getContent(),true)['content_id'];$largeFile=App\LessonContentAttachment::where('content_id',$largeId)->firstOrFail();
    $check((int)$largeFile->size_bytes===$bytes && $disk->size($largeFile->path)===$bytes && hash_file('sha256',$path)===$largeFile->sha256,'complete 2040 MiB stored bytes and digest agree');
    $over=new class($path,'large.txt',null,UPLOAD_ERR_OK,true) extends UploadedFile {public function getSize(){return 2040*1048576+1;}};
    $before=$snapshot();$status($create([$over]),422,'2040 MiB plus one rejected before hashing/storage');
    $status($create([$large,$upload('extra.txt')]),422,'aggregate 2040 MiB plus extra bytes rejected');$check($before===$snapshot(),'over-limit requests cannot leave partial data');
    $status($mediaHttp($teacher,'POST','/SMARMANger/dashboard/teacher/lesson-content/'.$largeId.'/delete',['revision'=>1]),200,'remove only dedicated large test group');
    unlink($path);
    echo json_encode(['large_bytes'=>$bytes,'elapsed_seconds'=>round(microtime(true)-$start,2),'php_peak_bytes'=>memory_get_peak_usage(true)])."\n";
}
echo json_encode(['teacher_media'=>'PASS','assertions'=>$assertions,'database'=>$database,'storage'=>$storage],JSON_PRETTY_PRINT)."\n";
