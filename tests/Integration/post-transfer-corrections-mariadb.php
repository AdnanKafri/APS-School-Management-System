<?php

// Existing runner copies DDL only into a new random local database. No migrations.
require __DIR__.'/student-workflow-mariadb.php';
if (!preg_match('/^aladham_student_workflow_test_[a-f0-9]{16}$/D',$database)
    || $db::selectOne('SELECT DATABASE() AS db')->db !== $database) throw new RuntimeException('Unsafe correction fixture.');
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\AcademicVisitRecords;
use App\Services\GradebookReadService;
use App\Services\TeacherAssessmentService;

$check(Illuminate\Support\Facades\Schema::hasTable(AcademicVisitRecords::TABLE),'visit DDL copied, never migrated');
config(['filesystems.default'=>'local','filesystems.disks.local.root'=>$storage.'/app',
    'filesystems.disks.public.root'=>$storage.'/app/public','student_results.student_pages_enabled'=>true]);
$db::table('years')->insert(['id'=>5,'name'=>'2025/2026','current_year'=>0]);
$db::table('term_years')->insert([
    ['id'=>17,'year_id'=>5,'term'=>'Old term','type'=>1,'current_term'=>1],
    ['id'=>20,'year_id'=>6,'term'=>'Current term','type'=>1,'current_term'=>1],
    ['id'=>21,'year_id'=>6,'term'=>'Other actual term','type'=>2,'current_term'=>0],
]);
$db::table('lessons')->insert(['id'=>409,'name'=>'Synthetic subject','class_id'=>2,'base_subject_id'=>1,'max_mark'=>100]);
$db::table('rooms')->insert(['id'=>7133,'name'=>'Destination fixture','class_id'=>2,'year_id'=>6]);
$db::table('teachers')->insert(['id'=>166,'first_name'=>'Synthetic','last_name'=>'Teacher','active'=>0]);
$teacher->teacher_id=166;$teacher->save();
$admin->view_password='fixture-delete';$admin->save();
$db::table('days')->insert(['id'=>1,'name'=>'Fixture day','name_en'=>'Fixture day','notes'=>'Fixture']);
$slot=$db::table('lecture_times')->insertGetId(['room_id'=>132,'type'=>1,'name'=>'Fixture period','start_time'=>'08:00','end_time'=>'08:40']);
$db::table('lesson_room_teacher_lecture_time')->insert(['teacher_id'=>166,'room_id'=>132,'lesson_id'=>409,'year_id'=>6,'term_id'=>20,'day_id'=>1,'lecture_time_id'=>$slot]);
$db::table('teacher_room_lesson')->insert(['teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'year_id'=>6]);
$fixture=function($id)use($db){
    $db::table('students')->insert(['id'=>$id,'first_name'=>'Synthetic '.$id,'last_name'=>'Correction','lifecycle_status'=>'active','lang'=>'0','religion'=>'0']);
    $db::table('student_details')->insert(['student_id'=>$id]);
    $db::table('room_student')->insert(['student_id'=>$id,'year_id'=>6,'room_id'=>132,'created_at'=>'2026-01-01','updated_at'=>'2026-01-01']);
    $db::table('student_academic_placements')->insert(['student_id'=>$id,'year_id'=>6,'class_id'=>2,'room_id'=>132,'status'=>'active','effective_from'=>'2026-01-01']);
};
foreach(range(7441,7452) as $id)$fixture($id);
$studentUser=App\User::create(['name'=>'Synthetic correction','email'=>'correction@example.test','password'=>bcrypt('fixture-only'),'type'=>'0','student_id'=>7441]);
$exam=function($extra=[])use($db,$admin){return App\Exams2::find($db::table('exams2')->insertGetId(array_replace([
    'name'=>'Correction fixture','class_id'=>2,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'type'=>2,
    'is_file'=>0,'has_traditional'=>1,'mark'=>100,'groupe'=>0,'user_id'=>$admin->id,'start_date'=>now()->subHour(),'end_date'=>now()->addHour(),
],$extra)));};
$definition=$exam();
$payload=function($many=true)use($definition){return ['student_id'=>7441,'item_id'=>$definition->id,
    'file'=>$many?json_encode([base64_encode('first'),base64_encode('second')]):base64_encode('single'),
    'extension'=>$many?json_encode(['.txt','.txt']):'txt'];};
$disk=Storage::disk('public');
if (realpath($disk->getDriver()->getAdapter()->getPathPrefix()) !== realpath($storage.'/app/public')) {
    throw new RuntimeException('Unsafe correction fixture storage.');
}
foreach(['upload_exam_files','upload_exam_files2'] as $method){
    $r=$http($studentUser,'POST','/api/dashboard/student/'.$method,$payload($method==='upload_exam_files2'));
    $status($r,200,'legacy mobile upload returns 200');
    $check(json_decode($r->getContent(),true)===['status'=>true,'msg'=>'تم الترفيع بنجاح'],'legacy mobile response unchanged');
}
$check($db::table('exams_files')->where('student_id',7441)->count()===3,'single and multi uploads append three original rows');
$check($db::table('exams_files')->where('student_id',7441)->where('term_id',20)->count()===3,'actual assessment term, not old current flag');
$check($db::table(AcademicVisitRecords::TABLE)->where('student_id',7441)->where('record_type','exam_submission')->count()===3,'all uploads attributed to active visit');
$snapshot=function()use($db,$disk){return [$db::table('exams_files')->get()->toJson(),$db::table(AcademicVisitRecords::TABLE)->get()->toJson(),$disk->allFiles()];};
$before=$snapshot();
$db::unprepared("CREATE TRIGGER fixture_mobile_insert_failure BEFORE INSERT ON exams_files FOR EACH ROW BEGIN IF (SELECT COUNT(*) FROM exams_files WHERE student_id=7441)>=4 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='fixture second upload failure'; END IF; END");
$r=$http($studentUser,'POST','/api/dashboard/student/upload_exam_files2',$payload());
$check($r->getStatusCode()===200 && json_decode($r->getContent(),true)['status']===false,'second-row SQL failure returns legacy failure envelope');
$check($snapshot()===$before,'InnoDB rollback and cleanup preserve all earlier upload rows/files/links');
$db::unprepared('DROP TRIGGER fixture_mobile_insert_failure');
$invalid=$payload();$invalid['item_id']=$exam(['term_id'=>17])->id;
$r=$http($studentUser,'POST','/api/dashboard/student/upload_exam_files2',$invalid);
$check(json_decode($r->getContent(),true)['status']===false && $snapshot()===$before,'old-year term rejected before bytes');
$invalid=$payload();$invalid['student_id']=7442;
$status($http($studentUser,'POST','/api/dashboard/student/upload_exam_files2',$invalid),403,'authenticated cross-student submission rejected');

Auth::setUser($teacher);$participation=app(TeacherAssessmentService::class);$unused=$exam();
$participation->participants($unused->id,132,409,2,false,[7442]);
$placeholder=App\Exam_result2::where('exam_id',$unused->id)->firstOrFail();
$check(app(AcademicVisitRecords::class)->link('modern_result',$placeholder->id)!==null,'new placeholder has attribution');
$db::unprepared("CREATE TRIGGER fixture_participation_failure BEFORE INSERT ON notifications FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='fixture notification failure'");
try{$participation->participants($unused->id,132,409,2,false,[7443]);throw new RuntimeException('Expected SQL failure');}
catch(Illuminate\Database\QueryException $e){$check(true,'participation rollback forced after removal');}
$check(App\Exam_result2::whereKey($placeholder->id)->exists() && app(AcademicVisitRecords::class)->link('modern_result',$placeholder->id)!==null,'failed replacement restores placeholder AND attribution');
$db::unprepared('DROP TRIGGER fixture_participation_failure');
$participation->participants($unused->id,132,409,2,false,[]);
$check(!App\Exam_result2::whereKey($placeholder->id)->exists() && app(AcademicVisitRecords::class)->link('modern_result',$placeholder->id)===null,'only current empty participation/link removed');
$participation->participants($unused->id,132,409,2,false,[7442]);
$r=$http($admin,'POST','/SMT/admin/class/room/exam_quize/delete',['content_id'=>$unused->id,'delete_code'=>'fixture-delete']);
$status($r,200,'actual Admin unused quiz deletion');
$check(!App\Exams2::find($unused->id) && !App\Exam_result2::where('exam_id',$unused->id)->exists(),'unused quiz and placeholders removed');
$check($db::table('exams_files')->where('exam_id',$definition->id)->count()===3,'unrelated original submissions unchanged');

Auth::setUser($teacher);$graded=$exam();
$earned=$participation->save($graded->id,7442,132,409,0);
$earnedOriginal=$earned->fresh()->getRawOriginal();
try{$participation->participants($graded->id,132,409,2,false,[]);throw new RuntimeException('Zero removed');}
catch(Illuminate\Validation\ValidationException $e){$check($earned->fresh()->getRawOriginal()===$earnedOriginal,'earned zero never removed');}
$status($http($admin,'POST','/SMT/admin/class/room/exam_quize/delete',['content_id'=>$graded->id,'delete_code'=>'fixture-delete']),422,'earned quiz deletion blocked');
Auth::setUser($teacher);$gradeId=$participation->save($graded->id,7442,132,409,25)->id;
$check($gradeId===$earned->id,'normal grade edit keeps original result identity');
// Fixed subject/assessment count: student count must not grow SQL count.
foreach(range(7441,7452) as $id)if($id!==7442)$participation->save($graded->id,$id,132,409,$id===7441?0:25);
$measure=function($ids)use($db,$graded){
    $room=App\Room::find(132);$subject=App\Lesson::find(409);
    $db::enableQueryLog();$db::flushQueryLog();$read=app(GradebookReadService::class)->read($room,$subject,$ids);$queries=count($db::getQueryLog());$db::disableQueryLog();
    foreach($ids as$id){$row=$read['assessments']->firstWhere('id',$graded->id)['results'][$id];
        if($row['value']!==($id===7441?0.0:25.0))throw new RuntimeException('Grade changed');}
    return ['queries'=>$queries,'marks'=>$read['marks'],'assessments'=>$read['assessments']->toArray()];
};
$one=$measure([7441]);$many=$measure(range(7441,7452));$check($one['queries']===$many['queries'],'MariaDB linked visit read query count independent of roster');
$db::unprepared('RENAME TABLE student_academic_visit_records TO fixture_saved_visit_records, student_placement_reconciliations TO fixture_saved_reconciliations');
try{
    $absentOne=$measure([7441]);$absentMany=$measure(range(7441,7452));
    $check($absentOne['queries']===$absentMany['queries'],'MariaDB legacy/no-visit schema read query count independent of roster');
    $check($absentMany['marks']===$many['marks'],'all original computed marks agree with/without visit tables');
}finally{$db::unprepared('RENAME TABLE fixture_saved_visit_records TO student_academic_visit_records, fixture_saved_reconciliations TO student_placement_reconciliations');}

// Real transaction rollback, then A -> B -> A. Preserve original results/files/invoice/account.
$db::table('students_marks')->insert(['student_id'=>7441,'room_id'=>132,'year_id'=>6,'mark'=>'{"409":{"exam":0}}']);
$db::table('report_cards')->insert(['student_id'=>7441,'room_id'=>132,'year_id'=>6,'class'=>2,'teacher_notes'=>'Original correction report']);
$db::table('invoices')->insert(['student_id'=>7441,'class_id'=>2,'year_id'=>5,'invoice_amount'=>123]);
$originalMarks=$db::table('students_marks')->where('student_id',7441)->first();
$originalReport=$db::table('report_cards')->where('student_id',7441)->first();
$retained=function()use($db,$originalMarks,$originalReport){$out=[];foreach(['students','users','invoices','exams_files']as$t)$out[$t]=$db::table($t)->where($t==='students'?'id':'student_id',7441)->get()->toJson();
    $out['results']=$db::table('exam_result2')->where('user_id',7441)->get()->toJson();
    $out['marks']=json_encode($db::table('students_marks')->where('id',$originalMarks->id)->first());
    $out['report']=json_encode($db::table('report_cards')->where('id',$originalReport->id)->first());return $out;};
$original=$retained();$neighbor=$db::table('room_student')->where('student_id',7442)->get()->toJson();Auth::setUser($admin);
$move=function($room)use($check){$service=app(App\Services\StudentTransferService::class);$service->handle(Illuminate\Http\Request::create('/','POST',['student_id'=>7441,'class_change_id'=>2,'room_change_id'=>$room]));return $service->succeeded();};
$db::unprepared("CREATE TRIGGER fixture_correction_transfer_failure BEFORE INSERT ON report_cards FOR EACH ROW BEGIN IF NEW.student_id=7441 AND NEW.room_id=7133 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='fixture transfer rollback'; END IF; END");
$check(!$move(7133) && $retained()===$original,'failed transfer never changes original academic/financial/identity rows');
$check($db::table('room_student')->where('student_id',7441)->value('room_id')===132,'failed transfer restores membership');
$db::unprepared('DROP TRIGGER fixture_correction_transfer_failure');
foreach([7133,132]as$destination){$check($move($destination),'transfer/return persists');$check($retained()===$original,'transfer/return preserves original data');}
$check($db::table('room_student')->where('student_id',7442)->get()->toJson()===$neighbor,'unselected student untouched');
$check($db::table('student_academic_placements')->where('student_id',7441)->count()===3,'three distinct visits preserved');
$check($db::table('student_transfer_histories')->where('student_id',7441)->count()===2,'two transfer events preserved');
$check(app(AcademicVisitRecords::class)->resultState(App\Exam_result2::where('exam_id',$graded->id)->where('user_id',7441)->first())==='carried','original earned zero remains carried on return');
echo json_encode(['database'=>$database,'storage'=>$storage,'total_assertions'=>$assertions,
    'queries'=>['linked'=>[$one['queries'],$many['queries']],'schema_absent'=>[$absentOne['queries'],$absentMany['queries']]]],JSON_PRETTY_PRINT)."\n";
