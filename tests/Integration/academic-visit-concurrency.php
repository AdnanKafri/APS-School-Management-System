<?php

if (!isset($database,$storage,$db,$check) || $db::selectOne('SELECT DATABASE() AS db')->db!==$database
    || !preg_match('/^aladham_lesson_test_[a-f0-9]{16}$/D',$database)) throw new RuntimeException('Unsafe concurrency fixture');

$db::table('teacher_room_lesson')->insert(['teacher_id'=>166,'room_id'=>7132,'lesson_id'=>409,'year_id'=>6,'class_id'=>2]);
$slot=$db::table('lecture_times')->insertGetId(['room_id'=>7132,'class_id'=>2,'type'=>1,'start_time'=>'08:00:00','end_time'=>'08:40:00']);
$db::table('lesson_room_teacher_lecture_time')->insert(['teacher_id'=>166,'room_id'=>7132,'lesson_id'=>409,'year_id'=>6,'term_id'=>20,'day_id'=>1,'lecture_time_id'=>$slot]);
$teacher=App\User::where('type','1')->firstOrFail();$admin=App\User::where('type','2')->firstOrFail();
$createExam=function()use($db,$admin){return $db::table('exams2')->insertGetId(['class_id'=>2,'room_id'=>7132,'lesson_id'=>409,
    'term_id'=>20,'type'=>2,'is_file'=>1,'user_id'=>$admin->id,'name'=>'Concurrent isolated quiz','mark'=>100,
    'start_date'=>now()->subHour(),'end_date'=>now()->addHour()]);};
$launch=function($mode,$id)use($database,$storage,$project){
    $pipes=[];$process=proc_open([PHP_BINARY,__DIR__.'/academic-visit-worker.php',$database,$storage,$mode,(string)$id],
        [0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes,$project);
    if (!is_resource($process)) throw new RuntimeException('Cannot start visit worker');
    fclose($pipes[0]);$ready=$storage.'/visit-'.$mode.'-'.$id.'.ready';$deadline=microtime(true)+15;
    while(!is_file($ready)&&microtime(true)<$deadline){usleep(20000);clearstatcache(true,$ready);}
    if(!is_file($ready)){proc_terminate($process);throw new RuntimeException('Visit worker did not start');}
    return [$process,$pipes];
};
$finish=function($worker)use($check){[$process,$pipes]=$worker;
    $output=stream_get_contents($pipes[1]);$errors=stream_get_contents($pipes[2]);fclose($pipes[1]);fclose($pipes[2]);
    $exit=proc_close($process);$check($exit===0 && $errors==='','independent visit worker succeeded: '.$errors);
    return json_decode($output,true)['status']??null;
};

// Grade obtains the student lock first; concurrent transfer waits and preserves it.
$id=$createExam();$db::beginTransaction();
App\Student::whereKey(7441)->lockForUpdate()->firstOrFail();
$waiting=$launch('transfer',$id);
Illuminate\Support\Facades\Auth::setUser($teacher);
$earned=app(App\Services\TeacherAssessmentService::class)->save($id,7441,7132,409,0);
$db::commit();$check($finish($waiting)===200,'grade-first concurrent transfer completes');
$check($db::table('exam_result2')->where('id',$earned->id)->value('result')==0,'grade-first earned zero remains unchanged');
$check(app(App\Services\AcademicVisitRecords::class)->resultState($earned)==='carried','grade-first original is frozen on its original visit');

Illuminate\Support\Facades\Auth::setUser($admin);
$service=app(App\Services\StudentTransferService::class);
$service->handle(Illuminate\Http\Request::create('/','POST',['student_id'=>7441,'class_change_id'=>2,'room_change_id'=>7132]));
$check($service->succeeded(),'concurrency fixture returns to A');

// Transfer wins the lock; a waiting grade must re-authorize against membership.
$id=$createExam();$db::beginTransaction();App\Student::whereKey(7441)->lockForUpdate()->firstOrFail();
$waiting=$launch('grade',$id);
$service->handle(Illuminate\Http\Request::create('/','POST',['student_id'=>7441,'class_change_id'=>2,'room_change_id'=>7133]));
$check($service->succeeded(),'transfer-first transaction succeeds');$db::commit();
$check($finish($waiting)===403,'waiting grade denied after membership changed');
$check(!$db::table('exam_result2')->where('exam_id',$id)->where('user_id',7441)->exists(),'no stale-context grade created');
$check($db::table('room_student')->where('student_id',42)->get()->toJson()===$neighbor,'concurrency leaves neighbor unchanged');
