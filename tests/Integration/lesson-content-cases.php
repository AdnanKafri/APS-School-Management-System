<?php

// Included only by the guarded disposable MariaDB runner; never an independent school test.
if (!isset($database) || !preg_match('/^aladham_lesson_test_[a-f0-9]{16}$/D', $database)
    || Illuminate\Support\Facades\DB::selectOne('SELECT DATABASE() AS db')->db !== $database) throw new RuntimeException('Fixture guard failed.');
$disk=Illuminate\Support\Facades\Storage::disk(App\Services\LessonContentStorage::DISK);
$download='/SMARMANger/lesson-content/attachments/'.$file->id.'/download';
$check(strpos($response->headers->get('Cache-Control'),'no-store')!==false,'private download is not cacheable');
$check($response->headers->get('X-Content-Type-Options')==='nosniff','private download forbids MIME sniffing');
$check(hash_file('sha256',$response->getFile()->getPathname())===$file->sha256,'authorized response serves the original attachment bytes');
$check($http($accounts[1],'GET',$download)->getStatusCode()===200,'owner Teacher download');
$check($http($accounts[4],'GET',$download)->getStatusCode()===403,'foreign Teacher download denied');
$check($http($accounts[5],'GET',$download)->getStatusCode()===403,'Admin cannot use private download');
$check(in_array($http(null,'GET',$download)->getStatusCode(),[401,302],true),'guest download requires login');
$check($disk->exists($file->path) && strpos($file->path,'fixture')===false,'server-generated private filename');
$check(App\LessonContentAttachment::where('content_id',$id)->orderBy('position')->pluck('position')->all()===[0,1],'attachment order preserved');
$legacyArray=App\Lesson_teacher_room_term_exam::find(1)->toArray();
$privateArray=App\Lesson_teacher_room_term_exam::with('privateAttachments')->find($id)->toArray();
foreach(['upload_request_hash','upload_payload_hash','upload_revision','upload_deleted_at','privateAttachments','private_attachments']as$key) $check(!array_key_exists($key,$privateArray),'legacy serialization hides '.$key);
$check($privateArray['note']===null && $privateArray['addition']===null,'legacy serialization exposes no private notes/paths');
$check($legacyArray['addition']==='filesteachers/legacy.pdf','legacy API file path unchanged');

$assertStatus=function($response,$expected,$label)use($check){$check($response->getStatusCode()===$expected,$label.' ['.$response->getStatusCode().'] '.substr($response->getContent(),0,350));};
$create=function($files,$data=null,$user=null)use($http,$accounts,$payload,$url){$data=$data??$payload();if(!array_key_exists('attachment_count',$data))$data['attachment_count']=count($files);return $http($user?:$accounts[1],'POST',$url,$data,['attachments'=>$files]);};
$snapshot=function()use($db,$disk){return [$db::table('lesson_teacher_room_term_exam')->count(),$db::table('lesson_content_attachments')->count(),$db::table('notifications')->count(),count($disk->allFiles('files'))];};
$retry=$payload(); $retry['attachment_count']=2;
$created=$create([$upload('same.txt'),$upload('same.txt')],$retry);
$assertStatus($created,200,'duplicate display names allowed');
$retryId=json_decode($created->getContent(),true)['content_id']; $after=$snapshot();
$replayed=$create([$upload('same.txt'),$upload('same.txt')],$retry);
$assertStatus($replayed,200,'idempotent replay accepted');
$check(json_decode($replayed->getContent(),true)['content_id']===$retryId && $snapshot()===$after,'replay creates no parent/files/notifications');
$assertStatus($create([$upload('different.txt'),$upload('same.txt')],$retry),409,'same token changed payload rejected');
$check($snapshot()===$after,'conflicting retry has no side effects');

// Two independent PHP processes issue the same real Web request against MariaDB.
$concurrentToken=(string)Illuminate\Support\Str::uuid();$workers=[];$concurrentBefore=$snapshot();
for($i=0;$i<2;$i++){
    $pipes=[];$process=proc_open([PHP_BINARY,__DIR__.'/lesson-content-mariadb.php','--worker',$database,$storage,$concurrentToken],
        [0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes,$project);
    if(!is_resource($process))throw new RuntimeException('Cannot start concurrent fixture worker.');
    fclose($pipes[0]);$workers[]=[$process,$pipes];
}
$workerResults=[];
foreach($workers as[$process,$pipes]){
    $output=stream_get_contents($pipes[1]);$errors=stream_get_contents($pipes[2]);fclose($pipes[1]);fclose($pipes[2]);
    $check(proc_close($process)===0 && $errors==='','concurrent worker process succeeds: '.$errors);
    $workerResults[]=json_decode($output,true);
}
$check($workerResults[0]['status']===200 && $workerResults[1]['status']===200,'both concurrent requests succeed');
$check($workerResults[0]['body']['content_id']===$workerResults[1]['body']['content_id'],'concurrent requests return same parent');
$concurrentAfter=$snapshot();
$check($concurrentAfter[0]===$concurrentBefore[0]+1 && $concurrentAfter[1]===$concurrentBefore[1]+1
    && $concurrentAfter[2]===$concurrentBefore[2]+1 && $concurrentAfter[3]===$concurrentBefore[3]+1,'concurrent request creates one parent/file/notification');

$data=$payload(); unset($data['upload_token']);
$assertStatus($http($accounts[1],'POST',$url,$data,['addition'=>$upload('old-client.txt')]),200,'legacy scalar single file supported when activated');
$five=[];for($i=0;$i<5;$i++)$five[]=$upload('ملف عربي English '.$i.'.txt');
$fiveResponse=$create($five); $assertStatus($fiveResponse,200,'five file upload');
$fiveId=json_decode($fiveResponse->getContent(),true)['content_id'];
$check(App\LessonContentAttachment::where('content_id',$fiveId)->count()===5,'all five stored');
$longName=str_repeat('اسم عربي طويل ',10).'mixed.with.dots.sha256sum';
$assertStatus($create([$upload($longName)]),200,'long Arabic technical filename');
$link=$payload();$link['addition_link']='https://example.test/lesson';$link['note']=null;
$assertStatus($create([],$link),200,'external link without files and no notes');
$maxNote=$payload();$maxNote['note']=str_repeat('ع',2000);
$assertStatus($create([$upload()],$maxNote),200,'2000 character Arabic note accepted');
$maxNote['note'].='ع';$maxNote['upload_token']=(string)Illuminate\Support\Str::uuid();
$assertStatus($create([$upload()],$maxNote),422,'2001 character note rejected');

$before=$snapshot();
foreach([
    'unsupported extension'=>[$upload('bad.php','<?php echo 1;')],
    'MIME spoof'=>[$upload('fake.pdf','<html>not PDF</html>')],
    'empty file'=>[$upload('empty.txt','')],
    'too many files'=>array_map(function()use($upload){return $upload();},range(1,6)),
    'nested array'=>[[$upload()]], 'sparse array'=>[1=>$upload()],
    'oversized file'=>[$upload('large.txt',str_repeat('x',10*1024*1024+1))],
    'oversized total'=>[$upload('a.txt',str_repeat('x',9*1024*1024)),$upload('b.txt',str_repeat('x',9*1024*1024)),$upload('c.txt',str_repeat('x',9*1024*1024))],
] as $label=>$files) $assertStatus($create($files),422,$label.' rejected');
$tampered=$payload();$tampered['attachments']='../../other-file';
$assertStatus($http($accounts[1],'POST',$url,$tampered),422,'posted path rejected');
$assertStatus($http($accounts[1],'POST',$url,$payload(),['attachments'=>[$upload()]]),422,'missing selected-file count cannot silently truncate uploads');
$tampered=$payload();$tampered['lecture_id']=[5037];$assertStatus($create([$upload()],$tampered),422,'malformed lecture identity rejected before query');
$tampered=$payload();$tampered['attachment_count']=3;
$assertStatus($create([$upload()],$tampered),422,'truncated file array rejected');
$tampered=$payload();$tampered['upload_token']='not-a-uuid';
$assertStatus($create([$upload()],$tampered),422,'invalid idempotency token');
$assertStatus($http($accounts[1],'POST',$url,$payload(),['addition'=>$upload(),'attachments'=>[$upload()]]),422,'ambiguous file fields rejected');
$tampered=$payload();$tampered['addition_link']='javascript:alert(1)';
$assertStatus($create([$upload()],$tampered),422,'unsafe link rejected');
$check($snapshot()===$before,'validation rejection writes no rows/files');
$atLimit=$payload();$atLimit['note']=null;
$limitFiles=[$upload('ten-a.txt',str_repeat("a\n",5*1024*1024)),$upload('ten-b.txt',str_repeat("b\n",5*1024*1024)),$upload('five.txt',str_repeat("c\n",(int)(2.5*1024*1024)))];
$assertStatus($create($limitFiles,$atLimit),200,'exact 10 MiB per file and 25 MiB combined accepted');
unset($limitFiles);
$pdf=$upload('real.pdf',"%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n%%EOF");
$pdfResponse=$create([$pdf]);$assertStatus($pdfResponse,200,'verified PDF accepted');
$pdfId=json_decode($pdfResponse->getContent(),true)['content_id'];$pdfFile=App\LessonContentAttachment::where('content_id',$pdfId)->first();
$pdfView=$http($accounts[2],'GET','/SMARMANger/lesson-content/attachments/'.$pdfFile->id.'/view');
$check($pdfView->getStatusCode()===200 && strpos($pdfView->headers->get('Content-Disposition'),'inline;')===0,'PDF view uses private inline response');
$textView=$http($accounts[2],'GET',str_replace('/download','/view',$download));
$check(strpos($textView->headers->get('Content-Disposition'),'attachment;')===0,'plain text cannot execute inline');
$zipPath=$storage.'/uploads/office-fixture.docx';$zip=new ZipArchive();$zip->open($zipPath,ZipArchive::CREATE);$zip->addFromString('[Content_Types].xml','<Types/>');$zip->addFromString('word/document.xml','<document/>');$zip->close();
$assertStatus($create([new Illuminate\Http\UploadedFile($zipPath,'lesson.docx',null,UPLOAD_ERR_OK,true)]),200,'verified Office document accepted');
$zip->open($zipPath);$zip->addFromString('word/vbaProject.bin','macro');$zip->close();
$assertStatus($create([new Illuminate\Http\UploadedFile($zipPath,'lesson.docx',null,UPLOAD_ERR_OK,true)]),422,'macro-bearing Office document rejected');

$before=$snapshot();
foreach(['teacher_id'=>167,'class_id'=>99,'room_id'=>133,'lesson_id'=>999]as$key=>$value){$tampered=$payload();$tampered[$key]=$value;$assertStatus($create([$upload()],$tampered),403,'tampered '.$key.' denied');}
$assertStatus($create([$upload()],null,$accounts[4]),403,'Teacher without assignment denied');
foreach(['term_id'=>21,'year_id'=>5,'class_id'=>99,'room_id'=>133,'active'=>1]as$key=>$value){
    $old=$db::table('lectures')->where('id',5037)->value($key);$db::table('lectures')->where('id',5037)->update([$key=>$value]);
    if($key!=='active')$assertStatus($create([$upload()]),403,'noncurrent/inconsistent lecture '.$key.' denied');
    else $assertStatus($http($accounts[2],'GET',$download),403,'unpublished lecture denied to Student');
    $db::table('lectures')->where('id',5037)->update([$key=>$old]);
}
$check($snapshot()===$before,'authorization rejection creates nothing');
$db::table('students')->where('id',41)->update(['lifecycle_status'=>'archived']);
$assertStatus($http($accounts[2],'GET',$download),403,'archived Student cannot download private content');
$db::table('students')->where('id',41)->update(['lifecycle_status'=>'active']);
$db::table('years')->where('id',6)->update(['current_year'=>0]);$db::table('years')->where('id',5)->update(['current_year'=>1]);
$assertStatus($http($accounts[2],'GET',$download),403,'future/prepared year cannot authorize downloads');
$db::table('years')->where('id',5)->update(['current_year'=>0]);$db::table('years')->where('id',6)->update(['current_year'=>1]);
config(['lesson_content.enabled'=>false]);
$assertStatus($create([$upload()]),404,'activation flag rejects grouped writes');
$assertStatus($http($accounts[2],'GET',$download),404,'activation flag rejects private downloads');
config(['lesson_content.enabled'=>true]);
$app->instance('env','local');
$assertStatus($create([$upload()]),419,'normal Web CSRF enforcement retained');
$app->instance('env','testing');

$manage='/SMARMANger/dashboard/teacher/lesson-content/'.$retryId;
$edit=['revision'=>1,'name_addition'=>'عنوان معدل','note'=>'<script>escaped note</script>','addition_link'=>null];
$assertStatus($http($accounts[1],'POST',$manage.'/update',$edit),200,'edit title/notes');
$check(App\Lesson_teacher_room_term_exam::find($retryId)->note===$edit['note'],'plain text note stored verbatim');
$assertStatus($http($accounts[1],'POST',$manage.'/update',$edit),409,'stale edit rejected');
$edit['revision']=2;
$assertStatus($http($accounts[4],'POST',$manage.'/update',$edit),403,'foreign Teacher edit denied');
$foreign=App\LessonContentAttachment::where('content_id',$id)->first();
$assertStatus($http($accounts[1],'POST',$manage.'/attachments/'.$foreign->id.'/remove',['revision'=>2]),404,'cannot remove another group attachment');
$owned=App\LessonContentAttachment::where('content_id',$retryId)->first();
$assertStatus($http($accounts[1],'POST',$manage.'/attachments/'.$owned->id.'/remove',['revision'=>2]),200,'remove one attachment');
$check(!$disk->exists($owned->path) && App\LessonContentAttachment::where('content_id',$retryId)->count()===1,'only selected file removed');
$remaining=App\LessonContentAttachment::where('content_id',$retryId)->first();
$assertStatus($http($accounts[1],'POST',$manage.'/attachments/'.$remaining->id.'/remove',['revision'=>3]),422,'last file without link protected');
$check($disk->exists($remaining->path),'last attachment remains intact');
$assertStatus($http($accounts[1],'POST',$manage.'/delete',['revision'=>3]),200,'delete content group');
$check(!$disk->exists($remaining->path) && App\Lesson_teacher_room_term_exam::find($retryId)->upload_deleted_at,'group tombstone and file cleanup');
$assertStatus($create([$upload('same.txt'),$upload('same.txt')],$retry),409,'deleted token cannot recreate content');
$assertStatus($http($accounts[2],'GET','/SMARMANger/lesson-content/attachments/'.$remaining->id.'/download'),404,'deleted attachment inaccessible');
$check($disk->exists($file->path),'unrelated group file retained');
try{$guarded=App\Lesson_teacher_room_term_exam::find($id);$guarded->note='legacy bypass';$guarded->save();$check(false,'legacy model bypass must be denied');}
catch(Symfony\Component\HttpKernel\Exception\HttpException $e){$check($e->getStatusCode()===409,'legacy model mutation guard retained');}
try{$migration->down();$check(false,'populated rollback must refuse');}catch(RuntimeException $e){$check(strpos($e->getMessage(),'Preserve')!==false,'populated rollback refused');}
try{$db::table('lesson_teacher_room_term_exam')->where('id',$id)->delete();$check(false,'FK must protect parent');}catch(Illuminate\Database\QueryException $e){$check(true,'MariaDB FK restrict protects ownership');}

class InterruptedLessonStorage extends App\Services\LessonContentStorage {
    public function store($file,$extension){$path=parent::store($file,$extension);if(count($this->paths())===2)throw new RuntimeException('Injected second-file failure');return $path;}
}
$before=$snapshot();$app->bind(App\Services\LessonContentStorage::class,InterruptedLessonStorage::class);
$assertStatus($create([$upload(),$upload()]),500,'mid-storage failure reported');
$app->bind(App\Services\LessonContentStorage::class,App\Services\LessonContentStorage::class);
$check($snapshot()===$before,'storage failure rolls back parent/children/notices/owned bytes');
$inject=true;App\LessonContentAttachment::creating(function()use(&$inject){if($inject)throw new RuntimeException('Injected database-side model failure');});
$assertStatus($create([$upload()]),500,'database-side failure after storage reported');$inject=false;
$check($snapshot()===$before,'database-side failure compensates stored file');
// Real SQL constraint failure occurs after the second file's bytes are written.
$sqlInject=true;App\LessonContentAttachment::creating(function($attachment)use(&$sqlInject,$file){if($sqlInject)$attachment->path=$file->path;});
$assertStatus($create([$upload()]),409,'SQL unique violation after storage reported');$sqlInject=false;
$check($snapshot()===$before && $disk->exists($file->path),'SQL rollback compensates only newly owned bytes');
class UnavailableLessonCleanup extends App\Services\LessonContentStorage { public function purge($path){return false;} }
$cleanupResponse=$create([$upload(),$upload()]);$cleanupId=json_decode($cleanupResponse->getContent(),true)['content_id'];
$app->bind(App\Services\LessonContentStorage::class,UnavailableLessonCleanup::class);
$cleanupResponse=$http($accounts[1],'POST','/SMARMANger/dashboard/teacher/lesson-content/'.$cleanupId.'/delete',['revision'=>1]);
$assertStatus($cleanupResponse,200,'committed delete succeeds despite delayed cleanup');
$check(strpos(json_decode($cleanupResponse->getContent(),true)['message'],__('lesson_content.cleanup_pending'))!==false,'pending cleanup visible');
$check(App\LessonContentAttachment::onlyTrashed()->where('content_id',$cleanupId)->whereNull('purged_at')->count()===2,'cleanup retained for retry');
$app->bind(App\Services\LessonContentStorage::class,App\Services\LessonContentStorage::class);
$recovery=app(App\Services\LessonContentRecovery::class)->run(true);
$check($recovery['removed_attachments']===2,'recovery purges pending removed files');
$orphan='files/'.Illuminate\Support\Str::uuid().'.txt';$disk->put($orphan,'orphan fixture');
$journal='journals/'.Illuminate\Support\Str::uuid().'.json';$disk->put($journal,json_encode(['paths'=>[$orphan,$file->path]]));touch($disk->path($journal),time()-7200);
$dry=app(App\Services\LessonContentRecovery::class)->run(false);
$check($dry['unowned_files']===1 && $disk->exists($orphan),'cleanup defaults to dry run');
$handle=fopen($disk->path($journal),'r+b');flock($handle,LOCK_EX);
$check(app(App\Services\LessonContentRecovery::class)->run(true)['skipped_journals']===1,'recovery skips locked live upload');
flock($handle,LOCK_UN);fclose($handle);
$clean=app(App\Services\LessonContentRecovery::class)->run(true);
$check($clean['purged_files']===1 && !$disk->exists($orphan) && $disk->exists($file->path),'recovery deletes only unowned bytes');
$uncertain=new App\Services\LessonContentStorage();$uncertain->begin();$uncertainPath=$uncertain->store($upload(),'txt');$uncertain->finish(false,false);
$check($disk->exists($uncertainPath) && count($disk->files('journals'))===1,'uncertain commit preserves bytes/journal instead of unsafe purge');
foreach($disk->files('journals')as$pendingJournal)touch($disk->path($pendingJournal),time()-7200);
$check(app(App\Services\LessonContentRecovery::class)->run(true)['purged_files']===1 && !$disk->exists($uncertainPath),'ownership-checked recovery resolves uncertain orphan');

// Placement changes here are fixture-only authorization scenarios, never school reconciliation.
$db::table('student_academic_placements')->where('student_id',41)->update(['status'=>'closed','effective_to'=>'2026-12-01']);
$db::table('room_student')->where('student_id',41)->update(['room_id'=>133]);
$db::table('student_academic_placements')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>133,'class_id'=>2,'status'=>'active','effective_from'=>'2026-12-01']);
$assertStatus($http($accounts[2],'GET',$download),200,'historically eligible transferred Student download');
$db::table('student_academic_placements')->where('student_id',41)->where('room_id',132)->update(['effective_to'=>'2026-01-01']);
$assertStatus($http($accounts[2],'GET',$download),403,'historical interval excluding content denied');
$db::table('student_academic_placements')->where('student_id',41)->where('room_id',133)->delete();
$db::table('student_academic_placements')->where('student_id',41)->update(['status'=>'active','effective_to'=>null]);
$db::table('room_student')->where('student_id',41)->update(['room_id'=>132]);

// Actual routes/controllers/views; only the unrelated outer layout is a fixture.
$studentPage='/SMARMANger/dashboard/student/lesson/lecture/content/409/41/5037';
$studentResponse=$http($accounts[2],'GET',$studentPage,[],[],['HTTP_ACCEPT'=>'text/html']);
$assertStatus($studentResponse,200,'Student lesson route renders grouped/legacy content');
$html=$studentResponse->getContent();
$check(strpos($html,'&lt;script&gt;not HTML&lt;/script&gt;')!==false && strpos($html,'<script>not HTML</script>')===false,'notes escaped in actual Student view');
$check(strpos($html,'filesteachers/legacy.pdf')!==false && strpos($html,$file->path)===false,'legacy URL retained; private path absent');
$doc=new DOMDocument();libxml_use_internal_errors(true);$doc->loadHTML('<?xml encoding="utf-8">'.$html);libxml_clear_errors();$xp=new DOMXPath($doc);
$check($xp->query('//a[@href="#Section2" and @aria-selected="true"]')->length===1,'Files remains default tab');
$check($xp->query('//div[@id="Section2"]//article[contains(@class,"box")]')->length>=5,'one coherent Student card per group');
$check($xp->query('//div[@id="Section2"]//details[@class="slc-attachment-file"]/summary/bdi[@dir="auto" and @title]')->length>0,'group filename has native keyboard-accessible full-name disclosure');
$check($xp->query('//div[@id="Section2"]//article[contains(@class,"box") and contains(concat(" ",normalize-space(@class)," ")," row ")]')->length===0,'private card no longer inherits Bootstrap row gutters');
$assertStatus($http($accounts[3],'GET','/SMARMANger/dashboard/student/lesson/lecture/content/409/42/5037'),403,'foreign section lesson route denied');
$teacherPage=route('dashboard.student.lessons.book_details',[409,166,132,5037],false);
$teacherResponse=$http($accounts[1],'GET',$teacherPage,[],[],['HTTP_ACCEPT'=>'text/html']);
$assertStatus($teacherResponse,200,'Teacher grouped edit/delete view renders');
$check(strpos($teacherResponse->getContent(),'data-lesson-manage')!==false,'secure Teacher manage forms visible');
$teacherCreate=$http($accounts[1],'GET','/SMARMANger/dashboard/teacher/teacher_rooms2/2/166/132/5037',[],[],['HTTP_ACCEPT'=>'text/html']);
$assertStatus($teacherCreate,200,'Teacher multi-file create page renders');
$check(strpos($teacherCreate->getContent(),'name="attachments[]"')!==false && strpos($teacherCreate->getContent(),'maxlength="2000"')!==false,'activated form has multiple files/notes');
config(['lesson_content.enabled'=>false]);
$db::enableQueryLog();$db::flushQueryLog();
$check(!app(App\Services\LessonContentFeature::class)->enabled() && count($db::getQueryLog())===0,'disabled feature performs no schema queries');$db::disableQueryLog();
$teacherCreate=$http($accounts[1],'GET','/SMARMANger/dashboard/teacher/teacher_rooms2/2/166/132/5037',[],[],['HTTP_ACCEPT'=>'text/html']);
$assertStatus($teacherCreate,200,'disabled feature preserves create page');
$check(strpos($teacherCreate->getContent(),'name="attachments[]"')===false && strpos($teacherCreate->getContent(),'name="addition"')!==false,'disabled form retains scalar field');
$legacyPayload=$payload();unset($legacyPayload['note'],$legacyPayload['upload_token']);$legacyPayload['name_addition']='Legacy scalar fixture';
$legacyCreated=$http($accounts[1],'POST',$url,$legacyPayload,['addition'=>$upload('legacy-kept.txt')]);
$assertStatus($legacyCreated,302,'disabled feature preserves original single-file upload handler');
$legacyStored=App\Lesson_teacher_room_term_exam::where('name_addition','Legacy scalar fixture')->firstOrFail();
$check(!$legacyStored->isPrivateLessonContent() && strpos($legacyStored->addition,'filesteachers/')===0
    && Illuminate\Support\Facades\Storage::disk('public')->exists($legacyStored->addition),'legacy upload retains public disk/path contract');
config(['lesson_content.enabled'=>true]);
$check($db::table('lesson_teacher_room_term_exam')->where('id',1)->value('addition')===$legacy->addition,'legacy record untouched throughout suite');
// An eager-loaded collection always uses two queries, regardless of files per parent.
$db::enableQueryLog();$db::flushQueryLog();
App\Lesson_teacher_room_term_exam::where('type','4')->with('privateAttachments')->get();
$check(count($db::getQueryLog())===2,'parent and attachment display uses two queries, not N+1');$db::disableQueryLog();

// Legacy/private deletion isolation: mutations are restricted to this disposable MariaDB database.
$public=Illuminate\Support\Facades\Storage::disk('public');$public->put('filesteachers/legacy.pdf','Unchanged legacy fixture bytes');
$legacyBefore=(array)$db::table('lesson_teacher_room_term_exam')->where('id',1)->first();
$legacyRoute='/SMARMANger/dashboard/teacher/lesson-content/1';
foreach(['/update','/delete','/attachments/'.$file->id.'/remove']as$suffix){
    $assertStatus($http($accounts[1],'POST',$legacyRoute.$suffix,['revision'=>1,'name_addition'=>'Must not change legacy','note'=>'Must not save']),404,'private management refuses legacy parent '.$suffix);
}
$check((array)$db::table('lesson_teacher_room_term_exam')->where('id',1)->first()===$legacyBefore && $public->get('filesteachers/legacy.pdf')==='Unchanged legacy fixture bytes','private management cannot modify legacy row/file');
$assertStatus($http($accounts[1],'GET',route('dashboard.addition.delete',['id'=>$id],false)),409,'legacy deletion refuses private group');
$check($disk->exists($file->path),'legacy delete cannot remove private bytes');
$assertStatus($http($accounts[1],'GET',route('dashboard.addition.delete',['id'=>$legacyStored->id],false)),302,'legacy scalar delete still uses original action');
$check(!$db::table('lesson_teacher_room_term_exam')->where('id',$legacyStored->id)->exists()&&!$public->exists($legacyStored->addition),'legacy delete removes only its original scalar row/path');
$check($public->get('filesteachers/legacy.pdf')==='Unchanged legacy fixture bytes'&&$disk->exists($file->path),'unrelated legacy and private files survive legacy delete');
