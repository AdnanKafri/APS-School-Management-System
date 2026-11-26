<?php

// Included only by the guarded disposable MariaDB runner.
if (!isset($database) || !preg_match('/^aladham_lesson_test_[a-f0-9]{16}$/D',$database)
    || $db::selectOne('SELECT DATABASE() AS db')->db !== $database) throw new RuntimeException('Fixture identity mismatch.');

$admin=$accounts[5]; $admin->view_password='fixture-delete'; $admin->save();
app()->setLocale('ar');
$quiz=function($room=132) {
    $quiz=new App\Exams2();
    $quiz->forceFill(['user_id'=>5,'class_id'=>2,'room_id'=>$room,'lesson_id'=>409,'term_id'=>20,'name'=>'Unused fixture quiz',
        'question_picker'=>2,'required'=>'Fixture','type'=>2,'is_file'=>1,'mark'=>100,'period'=>40,
        'start_date'=>'2026-11-18 08:00:00','end_date'=>'2026-11-19 08:00:00'])->save();
    return $quiz;
};
$editData=function($quiz) { return ['quize_id'=>$quiz->id,'room_id'=>$quiz->room_id,'lesson_id'=>409,'content_name'=>$quiz->name,
    'question_picker'=>2,'required_lectures'=>'Fixture','is_file'=>1,'mark'=>50,'period'=>40,
    'start_date'=>'2026-11-18T08:00:00','end_date'=>'2026-11-19T08:00:00']; };
$editUrl='/SMT/admin/class/room/quize/update'; $deleteUrl='/SMT/admin/class/room/exam_quize/delete';
$scaffold=function($quiz,$overrides=[])use($db) {
    return $db::table('exam_result2')->insertGetId(array_merge(['exam_id'=>$quiz->id,'class_id'=>2,'room_id'=>$quiz->room_id,
        'lesson_id'=>409,'user_id'=>41,'term_id'=>20,'type'=>2,'show_result'=>0],$overrides));
};
$original=$quiz(); $originalId=$original->id;
$assertStatus($http($admin,'POST',$editUrl,$editData($original)),200,'unused quiz maximum 100 to 50 through Admin route');
$check($original->fresh()->mark==50 && $original->fresh()->id===$originalId,'maximum edit preserves assessment ID');
$assertStatus($http($admin,'POST',$deleteUrl,['content_id'=>$originalId,'delete_code'=>'fixture-delete']),200,'unused quiz deletion through Admin route');
$check(!App\Exams2::find($originalId),'unused definition deleted');

require_once $project.'/database/migrations/2026_10_23_000001_create_assessment_equivalence_members.php';
if (!Illuminate\Support\Facades\Schema::hasTable('assessment_equivalence_members')) (new CreateAssessmentEquivalenceMembers())->up();
$pair=function()use($quiz,$admin) {
    Illuminate\Support\Facades\Auth::setUser($admin);
    $a=$quiz();$b=$quiz(133);app(App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Disposable multi-section fixture');return [$a,$b];
};
foreach (['edit','delete'] as $operation) {
    [$a,$b]=$pair(); $peer=$b->fresh()->getRawOriginal(); $peerMember=(array)$db::table('assessment_equivalence_members')->where('exam_id',$b->id)->first();
    $row=$scaffold($a); // NULL unattempted and unpublished; zero is tested separately below.
    $response=$operation==='edit' ? $http($admin,'POST',$editUrl,$editData($a))
        : $http($admin,'POST',$deleteUrl,['content_id'=>$a->id,'delete_code'=>'fixture-delete']);
    $assertStatus($response,200,'unused shared quiz '.$operation.' is independent');
    $check($b->fresh()->getRawOriginal()===$peer,'peer quiz unchanged after '.$operation);
    $check((array)$db::table('assessment_equivalence_members')->where('exam_id',$b->id)->first()===$peerMember,'peer identity metadata unchanged');
    $check(!$db::table('assessment_equivalence_members')->where('exam_id',$a->id)->exists() && !$db::table('exam_result2')->where('id',$row)->exists(),'only target identity and empty scaffold withdrawn');
    $resolved=app(App\Services\AssessmentContinuityService::class)->resolve($b,[42]);
    $check(($resolved[42]['state']??'missing')==='missing','remaining singleton is writable, not a continuity conflict');
}

// Reproduce the owner's six-section group without copying any school record.
$six=[];
foreach ([132,133,134,135,136,137] as $roomId) {
    if(!$db::table('rooms')->where('id',$roomId)->exists())$db::table('rooms')->insert(['id'=>$roomId,'class_id'=>2,'year_id'=>6,'name'=>'Fixture section']);
    $six[]=$quiz($roomId);
}
Illuminate\Support\Facades\Auth::setUser($admin);
app(App\Services\AssessmentEquivalenceService::class)->verify(array_map(function($exam){return $exam->id;},$six),'Disposable six-section fixture');
$peers=[];foreach(array_slice($six,1)as$peer)$peers[$peer->id]=$peer->fresh()->getRawOriginal();
$assertStatus($http($admin,'POST',$editUrl,$editData($six[0])),200,'six-section maximum correction changes only selected quiz');
foreach(array_slice($six,1)as$peer)$check($peer->fresh()->getRawOriginal()===$peers[$peer->id],'all five peer definitions stay byte-for-byte unchanged');
$assertStatus($http($admin,'POST',$deleteUrl,['content_id'=>$six[1]->id,'delete_code'=>'fixture-delete']),200,'another unused section quiz can be independently deleted');
$check($six[0]->fresh()->mark==50 && !$six[1]->fresh(),'six-section edit/delete persist independently');
foreach(array_slice($six,2)as$peer)$check($peer->fresh()->getRawOriginal()===$peers[$peer->id],'remaining four sections stay unchanged');

foreach ([['result'=>0],['result'=>25],['show_result'=>1],['user_answers'=>'{}'],['traditional_result'=>'{}'],['start_time'=>'2026-11-18 09:00:00'],['status'=>'1']] as $activity) {
    $a=$quiz();$row=$scaffold($a,$activity);$before=(array)$db::table('exam_result2')->where('id',$row)->first();
    $assertStatus($http($admin,'POST',$editUrl,$editData($a)),422,'protected quiz maximum blocked: '.json_encode($activity));
    $assertStatus($http($admin,'POST',$deleteUrl,['content_id'=>$a->id,'delete_code'=>'fixture-delete']),422,'protected quiz deletion blocked');
    $check($a->fresh()->mark==100 && (array)$db::table('exam_result2')->where('id',$row)->first()===$before,'protected result unchanged');
}
[$a,$b]=$pair();$scaffold($b,['result'=>0]);
$membersBefore=$db::table('assessment_equivalence_members')->orderBy('id')->get()->toJson();
$assertStatus($http($admin,'POST',$editUrl,$editData($a)),422,'earned peer blocks unsafe identity withdrawal');
$assertStatus($http($admin,'POST',$deleteUrl,['content_id'=>$a->id,'delete_code'=>'fixture-delete']),422,'earned peer blocks deletion');
$check($membersBefore===$db::table('assessment_equivalence_members')->orderBy('id')->get()->toJson(),'used group identity preserved');
foreach (['exams_files','exam_questions','exam_result_tester','exam_student_lesson'] as $table) {
    if (!Illuminate\Support\Facades\Schema::hasTable($table)) Illuminate\Support\Facades\Schema::create($table,function($t){$t->increments('id');$t->integer('exam_id');});
    $a=$quiz();$db::table($table)->insert(['exam_id'=>$a->id]);
    $assertStatus($http($admin,'POST',$editUrl,$editData($a)),422,'retained '.$table.' blocks edit');
    $assertStatus($http($admin,'POST',$deleteUrl,['content_id'=>$a->id,'delete_code'=>'fixture-delete']),422,'retained '.$table.' blocks delete');
}
$a=$quiz();$a->term_id=17;$a->save();
$assertStatus($http($admin,'POST',$deleteUrl,['content_id'=>$a->id,'delete_code'=>'fixture-delete']),422,'historical quiz cannot be deleted');
foreach ([$accounts[1],$accounts[2],null] as $unauthorized) {
    $a=$quiz();
    $check(in_array($http($unauthorized,'POST',$editUrl,$editData($a))->getStatusCode(),[302,401,403],true),'unauthorized edit denied');
    $check(in_array($http($unauthorized,'POST',$deleteUrl,['content_id'=>$a->id,'delete_code'=>'fixture-delete'])->getStatusCode(),[302,401,403],true),'unauthorized delete denied');
    $check($a->fresh()->mark==100,'unauthorized request changes nothing');
}
[$a,$b]=$pair();$row=$scaffold($a);$membersBefore=$db::table('assessment_equivalence_members')->orderBy('id')->get()->toJson();
$failQuiz=false;
App\Exams2::updating(function()use(&$failQuiz){if($failQuiz)throw new RuntimeException('Isolated quiz update failure');});
App\Exams2::deleting(function()use(&$failQuiz){if($failQuiz)throw new RuntimeException('Isolated quiz delete failure');});
foreach (['edit','delete'] as $operation) {
    $failQuiz=true;
    try {$response=$operation==='edit'?$http($admin,'POST',$editUrl,$editData($a)):$http($admin,'POST',$deleteUrl,['content_id'=>$a->id,'delete_code'=>'fixture-delete']);}
    finally {$failQuiz=false;}
    $assertStatus($response,500,'forced '.$operation.' failure');
    $check($a->fresh()->mark==100 && $db::table('exam_result2')->where('id',$row)->exists()
        && $membersBefore===$db::table('assessment_equivalence_members')->orderBy('id')->get()->toJson(),'transaction restores quiz, scaffold and equivalence on '.$operation.' failure');
}

// Smaller explicit deployment overrides remain supported; the file-count cap is now 20.
config(['lesson_content.max_files'=>20,'lesson_content.max_file_bytes'=>100*1048576,'lesson_content.max_total_bytes'=>150*1048576]);
$check(app(App\Services\LessonContentLimits::class)->values()===['max_files'=>20,'max_file_bytes'=>104857600,'max_total_bytes'=>157286400],'one upload policy resolves exact byte limits');
$sizedUpload=function($bytes,$name='boundary.txt')use($storage) {
    $path=$storage.'/uploads/'.bin2hex(random_bytes(8));$handle=fopen($path,'w+b');
    $block=str_repeat('x',1048576);while($bytes>0){$part=min($bytes,1048576);fwrite($handle,substr($block,0,$part));$bytes-=$part;}fclose($handle);
    return new Illuminate\Http\UploadedFile($path,$name,null,UPLOAD_ERR_OK,true);
};
$before=$snapshot();$files=[];for($i=0;$i<20;$i++)$files[]=$upload();
$assertStatus($create($files),200,'20 files accepted');
$files[]=$upload();$assertStatus($create($files),422,'21 files rejected');
$assertStatus($create([$sizedUpload(100*1048576)]),200,'exact 100 MiB accepted');
$before=$snapshot();$assertStatus($create([$sizedUpload(100*1048576+1)]),422,'100 MiB plus one byte rejected');$check($snapshot()===$before,'over-size rejection has no side effects');
$assertStatus($create([$sizedUpload(100*1048576),$sizedUpload(50*1048576)]),200,'exact 150 MiB aggregate accepted');
$before=$snapshot();$assertStatus($create([$sizedUpload(100*1048576),$sizedUpload(50*1048576+1)]),422,'aggregate plus one byte rejected');$check($snapshot()===$before,'aggregate rejection has no side effects');
$assertStatus($create([$upload('danger.mp4','<?php echo 1;')]),422,'renamed executable is not an MP4');

$smallVideo=getenv('ALADHAM_SMALL_MP4_FIXTURE');
$videoSources=[$project.'/login/assets/img/login-bg.mp4'];
if($smallVideo && is_file($smallVideo))array_unshift($videoSources,$smallVideo);
else echo "Small real MP4 fixture unavailable; set ALADHAM_SMALL_MP4_FIXTURE to enable it.\n";
foreach($videoSources as $source) {
    $path=$storage.'/uploads/'.bin2hex(random_bytes(8));copy($source,$path);
    $video=new Illuminate\Http\UploadedFile($path,'video.mp4',null,UPLOAD_ERR_OK,true);
    $response=$create([$video,$upload('alongside.txt')]);$assertStatus($response,200,'real MP4 plus document upload: '.filesize($source).' bytes');
    $contentId=json_decode($response->getContent(),true)['content_id'];$attachment=App\LessonContentAttachment::where('content_id',$contentId)->where('mime_type','video/mp4')->first();
    $check($attachment && $attachment->sha256===hash_file('sha256',$source),'video bytes preserved');
    $viewUrl='/SMARMANger/lesson-content/attachments/'.$attachment->id.'/view';
    $view=$http($accounts[2],'GET',$viewUrl);$assertStatus($view,200,'authorized MP4 inline view');
    $check(strpos($view->headers->get('Content-Disposition'),'inline;')===0 && $view->headers->get('Accept-Ranges')==='bytes','MP4 view inline and byte-range capable');
    $range=$http($accounts[2],'GET',$viewUrl,[],[],['HTTP_RANGE'=>'bytes=0-1023']);$assertStatus($range,206,'authorized range request');
    $check($range->headers->get('Content-Length')==='1024' && $range->headers->get('Content-Range')==='bytes 0-1023/'.filesize($source),'range headers match original file');
    ob_start();$range->sendContent();$chunk=ob_get_clean();$handle=fopen($source,'rb');$expected=fread($handle,1024);fclose($handle);
    $check($chunk===$expected,'range response streams exact requested bytes');
    $assertStatus($http($accounts[3],'GET',$viewUrl,[],[],['HTTP_RANGE'=>'bytes=0-1023']),403,'foreign Student denied video ranges');
    $assertStatus($http($accounts[4],'GET',$viewUrl),403,'foreign Teacher denied video');
    $download=$http($accounts[2],'GET',str_replace('/view','/download',$viewUrl));
    $check(strpos($download->headers->get('Content-Disposition'),'attachment;')===0,'download remains attachment');
    $legacyVideo=$payload();$legacyVideo['type']='0';$legacyVideo['name_video']='Legacy video fixture';
    $legacyBefore=App\Lesson_teacher_room_term_exam::max('id');
    $legacyResponse=$http($accounts[1],'POST',$url,$legacyVideo,['video_in'=>new Illuminate\Http\UploadedFile($path,'video.mp4',null,UPLOAD_ERR_OK,true)]);
    $assertStatus($legacyResponse,302,'existing single-video form accepts real MP4');
    $legacyEntry=App\Lesson_teacher_room_term_exam::where('id','>',$legacyBefore)->where('type','0')->first();
    $check($legacyEntry && $public->exists($legacyEntry->video) && hash_file('sha256',$public->path($legacyEntry->video))===hash_file('sha256',$source),'legacy video path/bytes preserved in isolated public disk');
}
$serverLimit=Illuminate\Http\Request::create('http://localhost'.$url,'POST',[],[],[],['CONTENT_LENGTH'=>200*1048576,'HTTP_ACCEPT'=>'application/json']);
$assertStatus($app->make(Illuminate\Contracts\Http\Kernel::class)->handle($serverLimit),413,'PHP post-size middleware rejection has localized response');
$invalid=$payload();$invalid['attachment_count']=1;
$badPath=$storage.'/uploads/php-error';file_put_contents($badPath,'Not received');
$assertStatus($create([new Illuminate\Http\UploadedFile($badPath,'failed.mp4',null,UPLOAD_ERR_INI_SIZE,true)],$invalid),422,'PHP per-file upload error is visible');
$legacyInvalid=$payload();$legacyInvalid['type']='0';$legacyInvalid['name_video']='Rejected legacy video';$before=$snapshot();
$assertStatus($http($accounts[1],'POST',$url,$legacyInvalid,['video_in'=>new Illuminate\Http\UploadedFile($badPath,'failed.mp4',null,UPLOAD_ERR_INI_SIZE,true)]),422,'legacy Video tab cannot report success for a PHP-rejected file');
$check($snapshot()===$before,'rejected legacy upload creates no blank content/notifications');
$before=$snapshot();$lateCapacityFailure=false;
App\LessonContentAttachment::creating(function()use(&$lateCapacityFailure){if($lateCapacityFailure)throw new RuntimeException('Isolated large-file late failure');});
$lateCapacityFailure=true;
try{$response=$create([$sizedUpload(11*1048576)]);}finally{$lateCapacityFailure=false;}
$assertStatus($response,500,'large-file post-storage failure');
$check($snapshot()===$before && $disk->files('journals')===[],'large-file rollback removes owned bytes and journal without orphans');
if (getenv('ALADHAM_RUN_HTTP_CAPACITY') === '1') require __DIR__.'/lesson-content-http-capacity.php';
else echo "Large real multipart tests not requested; set ALADHAM_RUN_HTTP_CAPACITY=1 to run the isolated HTTP transport gate.\n";
