<?php

// Reuse the existing guarded runner: random local fixture DB, isolated storage,
// no school-data copy and no production connection. Its upload regressions run too.
require __DIR__.'/lesson-content-mariadb.php';
if (!preg_match('/^aladham_lesson_test_[a-f0-9]{16}$/D', $database)
    || $db::selectOne('SELECT DATABASE() AS db')->db !== $database) throw new RuntimeException('Unsafe transfer fixture.');

Illuminate\Support\Facades\View::composer('students.layouts.app4', function ($view) use ($project) {
    $view->setPath($project.'/tests/Fixtures/gradebook-layout.blade.php');
});
config(['student_results.student_pages_enabled'=>true]);
// Explicit named migration, only after the disposable database identity check.
Illuminate\Support\Facades\Artisan::call('migrate',['--path'=>'database/migrations/2026_11_19_000001_create_student_academic_visit_records.php','--force'=>true]);
$check($db::table('migrations')->where('migration','2026_11_19_000001_create_student_academic_visit_records')->count()===1,'visit migration registered in fixture only');
Illuminate\Support\Facades\Artisan::call('migrate',['--path'=>'database/migrations/2026_11_19_000001_create_student_academic_visit_records.php','--force'=>true]);
$check($db::table('migrations')->where('migration','2026_11_19_000001_create_student_academic_visit_records')->count()===1,'visit migration repeat is a no-op');
foreach (['certificates','student_details'] as $table) {
    if (!Illuminate\Support\Facades\Schema::hasTable($table)) Illuminate\Support\Facades\Schema::create($table, function ($t) {
        $t->increments('id'); $t->integer('student_id')->nullable(); $t->integer('room_id')->nullable();
    });
}
foreach ([7132,7133] as $room) $db::table('rooms')->insert(['id'=>$room,'class_id'=>2,'year_id'=>6,'name'=>'Transfer fixture '.$room]);
$db::table('students')->insert(['id'=>7441,'first_name'=>'Transfer fixture','last_name'=>'Student','lifecycle_status'=>'active','lang'=>'0','religion'=>'0']);
$studentUser=App\User::create(['name'=>'Transfer fixture account','email'=>'transfer-history@example.test',
    'password'=>bcrypt('fixture-only'),'type'=>'0','student_id'=>7441]);
$db::table('room_student')->insert(['student_id'=>7441,'room_id'=>7132,'year_id'=>6,'created_at'=>'2026-01-01','updated_at'=>'2026-01-01']);
$oldPlacement=$db::table('student_academic_placements')->insertGetId(['student_id'=>7441,'room_id'=>7132,'class_id'=>2,
    'year_id'=>6,'status'=>'active','effective_from'=>'2026-01-01']);
$originalMark=$db::table('students_marks')->insertGetId(['student_id'=>7441,'room_id'=>7132,'year_id'=>6,'mark'=>'{"409":{"exam":0}}']);
$originalCard=$db::table('report_cards')->insertGetId(['student_id'=>7441,'room_id'=>7132,'year_id'=>6,'class'=>2,'teacher_notes'=>'Original report']);
if (!Illuminate\Support\Facades\Schema::hasTable('invoices')) Illuminate\Support\Facades\Schema::create('invoices',function($t) {
    $t->increments('id');$t->integer('student_id');$t->integer('class_id');$t->integer('year_id');$t->integer('invoice_amount');
});
$db::table('invoices')->insert(['student_id'=>7441,'class_id'=>2,'year_id'=>5,'invoice_amount'=>123]);
$exam=$db::table('exams2')->insertGetId(['class_id'=>2,'room_id'=>7132,'lesson_id'=>409,'term_id'=>20,
    'type'=>2,'is_file'=>1,'name'=>'Original transfer fixture quiz','mark'=>100]);
$db::table('exam_result2')->insert(['exam_id'=>$exam,'user_id'=>7441,'room_id'=>7132,'class_id'=>2,'lesson_id'=>409,
    'term_id'=>20,'type'=>2,'result'=>0,'status'=>1,'show_result'=>1]);
Illuminate\Support\Facades\Storage::disk('public')->put('filesstudents/transfer-fixture.txt','Original submission');
$submission=$db::table('exams_files')->insertGetId(['student_id'=>7441,'class_id'=>2,'room_id'=>7132,'lesson_id'=>409,
    'term_id'=>20,'exam_id'=>$exam,'file'=>'filesstudents/transfer-fixture.txt']);
$snap=function()use($db,$originalMark,$originalCard){$s=[];foreach(['students_marks','report_cards','invoices','exams_files'] as $table)
    $s[$table]=$db::table($table)->where('student_id',7441)->when(in_array($table,['students_marks','report_cards'],true),function($q)use($table,$originalMark,$originalCard){
        $q->where('id',$table==='students_marks'?$originalMark:$originalCard);})->orderBy('id')->get()->toJson();
    $s['results']=$db::table('exam_result2')->where('user_id',7441)->get()->toJson();
    $s['user']=$db::table('users')->where('student_id',7441)->get()->toJson();
    $s['student']=$db::table('students')->where('id',7441)->get()->toJson();return $s;};
$before=$snap();$neighbor=$db::table('room_student')->where('student_id',42)->get()->toJson();
$request=function() {return Illuminate\Http\Request::create('/','POST',['student_id'=>7441,'class_change_id'=>2,'room_change_id'=>7133]);};
Illuminate\Support\Facades\Auth::setUser($accounts[5]);

// Real InnoDB rollback after the enrollment/placement/history/marks writes.
$db::unprepared("CREATE TRIGGER fixture_transfer_failure BEFORE INSERT ON report_cards FOR EACH ROW BEGIN IF NEW.student_id=7441 AND NEW.room_id=7133 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Isolated rollback fixture'; END IF; END");
$service=app(App\Services\StudentTransferService::class);$service->handle($request());
$check(!$service->succeeded(),'MariaDB failure is not reported as success');
$check($snap()===$before,'failed transfer retains every original academic and financial row');
$check($db::table('room_student')->where('student_id',7441)->value('room_id')==7132,'failed transfer rolls back enrollment');
$check($db::table('student_academic_placements')->where('student_id',7441)->count()===1,'failed transfer rolls back destination placement');
$check(!$db::table('student_transfer_histories')->where('student_id',7441)->exists(),'failed transfer rolls back audit insert');
$check(!$db::table('student_academic_visit_records')->where('student_id',7441)->exists(),'failed transfer rolls back visit attribution');
$db::unprepared('DROP TRIGGER fixture_transfer_failure');

$service->handle($request());$check($service->succeeded(),'MariaDB transfer with earned results and submissions succeeds');
$check($snap()===$before,'successful transfer preserves original marks reports results files invoices identity and credentials');
$check($db::table('room_student')->where('student_id',7441)->value('room_id')==7133,'MariaDB destination enrollment persisted');
$check($db::table('student_academic_placements')->where('id',$oldPlacement)->value('status')==='closed','source placement closed');
$new=$db::table('student_academic_placements')->where('student_id',7441)->where('status','active')->first();
$check($new && $new->room_id==7133 && $new->year_id==6 && $new->class_id==2,'exact destination placement active');
$check($db::table('student_transfer_histories')->where('student_id',7441)->count()===1,'one audited transfer');
$check($db::table('room_student')->where('student_id',42)->get()->toJson()===$neighbor,'unselected neighbor unchanged');
$check(app(App\Services\CurrentStudentMembership::class)->roomForStudent(7441,6)->id==7133,'current resolver uses destination');
$r=$http($studentUser,'GET','/SMARMANger/dashboard/student/academic-record/'.$new->id);
$check($r->getStatusCode()===200 && strpos($r->getContent(),'/academic-record/'.$oldPlacement)!==false,'current record links original placement without learning content');
$r=$http($studentUser,'GET','/SMARMANger/dashboard/student/academic-record/'.$oldPlacement);
$check($r->getStatusCode()===200 && strpos($r->getContent(),'Original transfer fixture quiz')!==false,'historical original result remains visible');
$url='/SMARMANger/dashboard/student/academic-record/'.$oldPlacement.'/submissions/exam/'.$submission;
$r=$http($studentUser,'GET',$url);$check($r->getStatusCode()===200,'own historical submission downloads');
$check(strpos($r->headers->get('Cache-Control'),'private')!==false,'historical student file is private/no-store');
$check($http($accounts[3],'GET',$url)->getStatusCode()===404,'another student cannot download owned historical submission');
Illuminate\Support\Facades\Auth::setUser($accounts[5]);
$service->handle(Illuminate\Http\Request::create('/','POST',['student_id'=>7441,'class_change_id'=>2,'room_change_id'=>7132]));
$check($service->succeeded(),'return to previous section succeeds with visit attribution');
$check($snap()===$before,'return preserves every original');
foreach ([7133,7132,7133,7132] as $destination) {
    $service->handle(Illuminate\Http\Request::create('/','POST',['student_id'=>7441,'class_change_id'=>2,'room_change_id'=>$destination]));
    $check($service->succeeded(),'repeated return succeeds');
    $check($snap()===$before,'repeated return preserves originals');
    $check(App\Students_mark::where('student_id',7441)->where('year_id',6)->count()===1,'current summary is unique');
    $check(App\Report_card::where('student_id',7441)->where('year_id',6)->count()===1,'current report is unique');
    $check(app(App\Services\CurrentStudentMembership::class)->roomForStudent(7441,6)->id==$destination,'current membership follows each return');
}
$check($db::table('students_marks')->where('student_id',7441)->count()===7,'seven distinct visit summaries persisted');
$check(App\Students_mark::withoutGlobalScope('academic_visit')->whereKey($originalMark)->update(['notes'=>'forbidden'])===0,'closed summary rejects bulk writes');
$check(App\Exam_result2::where('exam_id',$exam)->where('user_id',7441)->update(['result'=>99])===0,'closed result rejects bulk writes');
$check($snap()===$before,'original rows unchanged after blocked mutations');
$joined=App\Classe::join('rooms','rooms.class_id','=','classes.id')
    ->join('room_student','room_student.room_id','=','rooms.id')->join('students','students.id','=','room_student.student_id')
    ->join('students_marks','students_marks.student_id','=','students.id')->join('report_cards','report_cards.student_id','=','students.id')
    ->where('students.id',7441)->where('rooms.year_id',6)
    ->whereColumn('students_marks.room_id','rooms.id')->whereColumn('students_marks.year_id','rooms.year_id')
    ->whereColumn('report_cards.room_id','rooms.id')->whereColumn('report_cards.year_id','rooms.year_id');
app(App\Services\AcademicVisitRecords::class)->current($joined,'students_marks','marks',true);
app(App\Services\AcademicVisitRecords::class)->current($joined,'report_cards','report',true);
$reportsBefore=$db::table('report_cards')->where('student_id',7441)->get()->keyBy('id');
$joined->update(['report_cards.adjustable'=>1]); // Eloquent also touches the joined Class timestamp.
$changed=$db::table('report_cards')->where('student_id',7441)->get()->filter(function($r)use($reportsBefore){return (array)$r!==(array)$reportsBefore[$r->id];});
$check($changed->count()===1 && $changed->first()->id==App\Report_card::where('student_id',7441)->value('id'),'MariaDB joined publication query updates exactly the current report');
$check($snap()===$before,'joined publication never changes original visit reports');
require __DIR__.'/academic-visit-concurrency.php';
echo json_encode(['transfer_assertions_complete'=>true,'total_assertions'=>$assertions,'database'=>$database,'storage'=>$storage],JSON_PRETTY_PRINT)."\n";
