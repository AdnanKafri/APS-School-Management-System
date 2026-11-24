<?php

// Opt-in DDL-only copy plus existing 93-assertion workflow. Never runs migrations.
require __DIR__.'/post-transfer-corrections-mariadb.php';
if (!preg_match('/^aladham_student_workflow_test_[a-f0-9]{16}$/D', $database)
    || $db::selectOne('SELECT DATABASE() AS db')->db !== $database) throw new RuntimeException('Unsafe observation fixture.');

$db::table('rooms')->insert(['id'=>7134,'name'=>'Stale section fixture','class_id'=>2,'year_id'=>6]);
$seedObservation = function ($id) use ($db) {
    $db::table('students')->insert(['id'=>$id,'first_name'=>'Observation fixture','last_name'=>(string)$id,'lifecycle_status'=>'active','lang'=>'0','religion'=>'0']);
    $db::table('student_details')->insert(['student_id'=>$id]);
    $db::table('room_student')->insert(['student_id'=>$id,'year_id'=>6,'room_id'=>132,'created_at'=>now()->subDays(2),'updated_at'=>now()->subHour()]);
    $db::table('student_academic_placements')->insert(['student_id'=>$id,'year_id'=>6,'class_id'=>2,'room_id'=>7134,
        'status'=>'active','effective_from'=>now()->subDays(2),'updated_at'=>now()->subHours(2)]);
};
$seedObservation(7541);
$definition=$exam(['is_file'=>1,'has_traditional'=>0]);
$existing=$exam(['is_file'=>1,'has_traditional'=>0]); $peer=$exam(['room_id'=>7134,'is_file'=>1,'has_traditional'=>0]);
Illuminate\Support\Facades\Auth::setUser($admin);
app(App\Services\AssessmentEquivalenceService::class)->verify([$existing->id,$peer->id],'Synthetic observed current result');
$original=$db::table('exam_result2')->insertGetId(['user_id'=>7541,'exam_id'=>$existing->id,'room_id'=>132,'class_id'=>2,
    'lesson_id'=>409,'term_id'=>20,'type'=>'2','result'=>'0','status'=>'1','show_result'=>1,'created_at'=>now()->subMinutes(30)]);
$sourceMark=$db::table('students_marks')->insertGetId(['student_id'=>7541,'year_id'=>6,'room_id'=>7134,'mark'=>'{"409":{"exam":0}}','created_at'=>now()->subDay()]);
$sourceCard=$db::table('report_cards')->insertGetId(['student_id'=>7541,'year_id'=>6,'room_id'=>7134,'class'=>2,'teacher_notes'=>'Original report','created_at'=>now()->subDay()]);
$db::table('invoices')->insert(['student_id'=>7541,'year_id'=>5,'invoice_amount'=>123,'class_id'=>2]);
$retainedObservation=function() use ($db,$original,$sourceMark,$sourceCard) {
    return [$db::table('exam_result2')->where('id',$original)->first(),$db::table('students_marks')->where('id',$sourceMark)->first(),
        $db::table('report_cards')->where('id',$sourceCard)->first(),$db::table('invoices')->where('student_id',7541)->get()->toJson(),
        $db::table('students')->where('id',7541)->get()->toJson(),$db::table('room_student')->where('student_id',7541)->get()->toJson()];
};
$beforeObservation=json_encode($retainedObservation());
$payload=['exam_id'=>$definition->id,'room_id'=>132,'lesson_id'=>409,'user_id'=>7541,'mark'=>0];
$response=$http($teacher,'POST','/SMARMANger/dashboard/teacher/student_save_mark_quize',$payload);
$status($response,200,'real traditional POST saves zero with stale placement');
$saved=App\Exam_result2::where('exam_id',$definition->id)->where('user_id',7541)->firstOrFail();
$active=App\StudentAcademicPlacement::where('student_id',7541)->where('status','active')->firstOrFail();
$check((int)$active->room_id===132 && $active->action_source==='academic_write_observation','current observation in exact enrollment section');
$check(app(App\Services\AcademicVisitRecords::class)->link('modern_result',$saved->id)->placement_id===$active->id,'new grade exact visit attribution');
$check(json_encode($retainedObservation())===$beforeObservation,'all existing results, source marks/reports, finance, identity, enrollment unchanged');
$audit=$db::table('student_placement_reconciliations')->where('student_id',7541)->first();
$check(json_decode($audit->before_snapshot,true)['historical_transition_date']==='unknown','audit does not invent transfer date');
$check($db::table('student_transfer_histories')->where('student_id',7541)->count()===0,'observation is not a fictitious transfer event');
$status($http($teacher,'POST','/SMARMANger/dashboard/teacher/student_save_mark_quize',$payload),200,'retry succeeds');
$check(App\Exam_result2::where('exam_id',$definition->id)->where('user_id',7541)->count()===1
    && $db::table('student_placement_reconciliations')->where('student_id',7541)->count()===1,'retry duplicates neither grade nor observation');
$resolved=app(App\Services\AssessmentContinuityService::class)->resolve($existing,[7541])[7541];
$check($resolved['state']==='current' && $resolved['value']===0.0 && (int)$resolved['result_id']===$original,'existing explicit current original zero is not falsely carried');
$studentObservation=App\User::create(['name'=>'Observed student','email'=>'observed@example.test','password'=>bcrypt('synthetic-only'),'type'=>'0','student_id'=>7541]);
$status($http($studentObservation,'GET','/SMARMANger/dashboard/student/room/main_quizes/132/7541',[],true,false),200,'real Student quiz page renders observed results');
$status($http($studentObservation,'GET','/SMARMANger/dashboard/student/academic-record/'.$active->id,[],true,false),200,'real Academic Record renders current observation');
$status($http($studentUser,'GET','/SMARMANger/dashboard/student/academic-record/'.$active->id),404,'another student cannot read observed placement');
Illuminate\Support\Facades\Auth::setUser($teacher);
$db::unprepared("CREATE TRIGGER fixture_observation_failure BEFORE INSERT ON report_cards FOR EACH ROW BEGIN IF NEW.student_id=7542 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='isolated observation rollback'; END IF; END");
$seedObservation(7542); $before=$db::table('student_academic_placements')->where('student_id',7542)->get()->toJson();
try { app(App\Services\TeacherAssessmentService::class)->save($definition->id,7542,132,409,15); throw new RuntimeException('Missing rollback'); }
catch (Illuminate\Database\QueryException $e) { $check(true,'forced InnoDB observation failure'); }
$check($db::table('student_academic_placements')->where('student_id',7542)->get()->toJson()===$before,'InnoDB restores exact stale placement after failure');
foreach (['student_placement_reconciliations','student_academic_visit_records','students_marks','report_cards'] as $table) $check($db::table($table)->where('student_id',7542)->count()===0,'rollback leaves no partial '.$table);
$check(App\Exam_result2::where('user_id',7542)->count()===0,'rollback removes incoming grade');
$db::unprepared('DROP TRIGGER fixture_observation_failure');
app(App\Services\TeacherAssessmentService::class)->save($definition->id,7542,132,409,15);
$check($db::table('student_placement_reconciliations')->where('student_id',7542)->count()===1,'retry after rollback observes once');
$seedObservation(7546);
$db::table('students')->where('id',7546)->update(['religion'=>null,'lang'=>null]);
app(App\Services\TeacherAssessmentService::class)->save($definition->id,7546,132,409,0);
$summary=App\Students_mark::where('student_id',7546)->firstOrFail();
$check($summary->religion===null && $summary->lang===null,'nullable identity settings remain NULL, not invalid empty enum strings');

// Real second connections contend on the same permanent-student lock as transfers.
file_put_contents($storage.'/observation-identity.json',json_encode(['database'=>$database,'storage'=>realpath($storage)]));
$spawn=function($mode,$student,$assessment)use($database,$storage,$teacher){
    $ready=$storage.'/observation-ready-'.bin2hex(random_bytes(6));
    $command=[PHP_BINARY,__DIR__.'/academic-write-observation-worker.php',$database,$storage,$mode,(string)$student,(string)$assessment,(string)$teacher->id,$ready];
    $process=proc_open($command,[0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes,null,getenv());
    if(!is_resource($process))throw new RuntimeException('Cannot start fixture worker');
    fclose($pipes[0]); $until=microtime(true)+15;
    while(!file_exists($ready)&&microtime(true)<$until)usleep(20000);
    if(!file_exists($ready))throw new RuntimeException('Worker failed before lock attempt: '.stream_get_contents($pipes[2]));
    return [$process,$pipes];
};
$finish=function($worker) {
    [$process,$pipes]=$worker;$output=stream_get_contents($pipes[1]);$error=stream_get_contents($pipes[2]);
    fclose($pipes[1]);fclose($pipes[2]);$code=proc_close($process);
    if($code!==0)throw new RuntimeException('Fixture worker failed: '.$error.$output);
    $data=json_decode($output,true);if(!is_array($data))throw new RuntimeException('Worker output: '.$output.$error);return $data;
};
$seedObservation(7543); Illuminate\Support\Facades\Auth::setUser($teacher);
$db::beginTransaction();
try {
    App\Student::whereKey(7543)->lockForUpdate()->firstOrFail();
    $worker=$spawn('grade',7543,$definition->id);
    app(App\Services\TeacherAssessmentService::class)->save($definition->id,7543,132,409,0);
    $db::commit();
} catch(Throwable $e){$db::rollBack();throw $e;}
$check($finish($worker)['status']===200,'concurrent duplicate grade waits and retries safely');
$check(App\Exam_result2::where('user_id',7543)->where('exam_id',$definition->id)->count()===1
    && $db::table('student_placement_reconciliations')->where('student_id',7543)->count()===1,'concurrent grade observes once and keeps one result');
$seedObservation(7544); Illuminate\Support\Facades\Auth::setUser($admin);
$db::beginTransaction();
try {
    App\Student::whereKey(7544)->lockForUpdate()->firstOrFail();
    $worker=$spawn('grade',7544,$definition->id);
    $service=app(App\Services\StudentTransferService::class);
    $service->handle(Illuminate\Http\Request::create('/','POST',['student_id'=>7544,'class_change_id'=>2,'room_change_id'=>7133]));
    $check($service->succeeded(),'transfer wins lock and commits first');$db::commit();
} catch(Throwable $e){$db::rollBack();throw $e;}
$check($finish($worker)['status']===403,'waiting grade rechecks membership after committed transfer');
$check(App\Exam_result2::where('user_id',7544)->count()===0,'no stale-section grade after transfer');
$seedObservation(7545); Illuminate\Support\Facades\Auth::setUser($teacher);
$db::beginTransaction();
try {
    App\Student::whereKey(7545)->lockForUpdate()->firstOrFail();
    $worker=$spawn('transfer',7545,$admin->id);
    $grade=app(App\Services\TeacherAssessmentService::class)->save($definition->id,7545,132,409,0);
    $db::commit();
} catch(Throwable $e){$db::rollBack();throw $e;}
$check($finish($worker)['status']===200,'waiting transfer succeeds after observed grade commits');
$check($grade->fresh()->result==='0' && app(App\Services\AcademicVisitRecords::class)->resultState($grade)==='carried','grade-first race preserves zero in now-closed source visit');
$check((int)$db::table('room_student')->where('student_id',7545)->value('room_id')===7133,'grade-first race finishes in requested destination');
echo json_encode(['observation_mariadb'=>'PASS','assertions'=>$assertions,'database'=>$database,'storage'=>$storage],JSON_PRETTY_PRINT)."\n";
