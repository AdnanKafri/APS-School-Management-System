<?php

// Opt-in local fixtures. Copies schema definitions only, never school records.
if (PHP_SAPI !== 'cli' || ($argv[1] ?? '') !== '--create-disposable-database') exit(1);
require __DIR__.'/../../vendor/autoload.php';
$project = realpath(__DIR__.'/../..');
if (file_exists($project.'/bootstrap/cache/config.php')) throw new RuntimeException('Cached configuration must be reviewed first.');
$env = Dotenv\Dotenv::createArrayBacked($project)->load();
if (($env['DB_CONNECTION'] ?? '') !== 'mysql' || !in_array($env['DB_HOST'] ?? '', ['127.0.0.1', 'localhost'], true)
    || !empty($env['DATABASE_URL']) || !empty($env['DB_SOCKET'])) throw new RuntimeException('Local MariaDB only.');
$database = 'aladham_student_workflow_test_'.bin2hex(random_bytes(8));
$storage = sys_get_temp_dir().'/aladham-student-workflow-'.bin2hex(random_bytes(16));
$source = new PDO('mysql:host='.$env['DB_HOST'].';port='.($env['DB_PORT'] ?? 3306).';dbname='.$env['DB_DATABASE'].';charset=utf8mb4',
    $env['DB_USERNAME'], $env['DB_PASSWORD'] ?? '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$source->exec('SET TRANSACTION READ ONLY'); $source->beginTransaction();
$definitions = [];
foreach ($source->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_TYPE='BASE TABLE'")->fetchAll(PDO::FETCH_COLUMN) as $table) {
    $ddl = $source->query('SHOW CREATE TABLE `'.$table.'`')->fetch(PDO::FETCH_NUM)[1];
    $definitions[$table] = preg_replace('/ AUTO_INCREMENT=\d+/', '', $ddl);
}
$source->rollBack(); $source = null;
$server = new PDO('mysql:host='.$env['DB_HOST'].';port='.($env['DB_PORT'] ?? 3306).';charset=utf8mb4', $env['DB_USERNAME'], $env['DB_PASSWORD'] ?? '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
if ($database === $env['DB_DATABASE'] || $server->query("SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME='$database'")->fetchColumn()) throw new RuntimeException('Unsafe fixture identity.');
$server->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$server->exec("USE `$database`"); $server->exec('SET FOREIGN_KEY_CHECKS=0');
// Some existing legacy definitions have zero-date defaults. This DDL-only
// connection is disposable; Laravel mutation tests retain normal strict mode.
$server->exec("SET SESSION sql_mode=''");
foreach ($definitions as $ddl) $server->exec($ddl);
$server->exec('SET FOREIGN_KEY_CHECKS=1'); $server = null;
foreach (['', 'app', 'logs', 'framework/views', 'framework/cache/data', 'framework/sessions'] as $directory) mkdir($storage.'/'.$directory, 0700, true);
foreach (['APP_ENV'=>'testing', 'DB_CONNECTION'=>'mysql', 'DB_HOST'=>$env['DB_HOST'], 'DB_PORT'=>$env['DB_PORT'] ?? 3306,
    'DB_DATABASE'=>$database, 'DB_USERNAME'=>$env['DB_USERNAME'], 'DB_PASSWORD'=>$env['DB_PASSWORD'] ?? '',
    'SESSION_DRIVER'=>'array', 'CACHE_DRIVER'=>'array', 'QUEUE_CONNECTION'=>'sync', 'VIEW_COMPILED_PATH'=>$storage.'/framework/views'] as $key=>$value) {
    putenv($key.'='.$value); $_SERVER[$key]=$value; $_ENV[$key]=$value;
}
$app = require $project.'/bootstrap/app.php'; $app->useStoragePath($storage);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$db = Illuminate\Support\Facades\DB::class;
if ($db::selectOne('SELECT DATABASE() AS db')->db !== $database || !preg_match('/^aladham_student_workflow_test_[a-f0-9]{16}$/D', $database)) throw new RuntimeException('Fixture mismatch.');
set_exception_handler(function (Throwable $e) { fwrite(STDERR, get_class($e).': '.$e->getMessage()."\n".$e->getTraceAsString()."\n"); exit(1); });
config(['app.debug'=>false, 'app.locale'=>'ar']);
app()->setLocale('ar');
$assertions = 0;
$check = function ($ok, $label) use (&$assertions) { if (!$ok) throw new RuntimeException('FAILED: '.$label); $assertions++; };
$status = function ($response, $expected, $label) use ($check) { $check($response->getStatusCode() === $expected, $label.' ['.$response->getStatusCode().'] '.substr($response->getContent(), 0, 250)); };
$admin = App\User::create(['name'=>'Fixture Admin', 'email'=>'admin@example.test', 'password'=>bcrypt('fixture-correct'), 'view_password'=>'obsolete-not-the-password', 'type'=>'2']);
$teacher = App\User::create(['name'=>'Fixture Teacher', 'email'=>'teacher@example.test', 'password'=>bcrypt('fixture-teacher'), 'type'=>'1']);
$officer = App\User::create(['name'=>'Fixture Officer', 'email'=>'officer@example.test', 'password'=>bcrypt('fixture-officer'), 'type'=>'8']);
$session = app('session')->driver(); $session->start(); $session->put('_token', str_repeat('a', 40)); $session->save();
$http = function ($user, $method, $url, $data=[], $csrf=true, $json=true) use ($app, $session) {
    // Exercise real CSRF middleware as well as the actual Web routes/controllers.
    $app->instance('env', 'local');
    if ($user) Illuminate\Support\Facades\Auth::setUser($user); else Illuminate\Support\Facades\Auth::logout();
    $headers = ['HTTP_ACCEPT'=>$json ? 'application/json' : 'text/html', 'HTTP_REFERER'=>'http://localhost/SMT/admin/students'];
    if ($csrf) $headers['HTTP_X_CSRF_TOKEN'] = $session->token();
    $request = Illuminate\Http\Request::create('http://localhost'.$url, $method, $data, [config('session.cookie')=>$session->getId()], [], $headers);
    return $app->make(Illuminate\Contracts\Http\Kernel::class)->handle($request);
};
$fresh = function ($name='Synthetic') {
    $student = App\Student::create(['first_name'=>$name, 'last_name'=>'Fixture']);
    $detail = new App\Student_detail; $detail->student_id=$student->id; $detail->save();
    App\User::create(['name'=>$name, 'email'=>'student'.$student->id.'@example.test', 'password'=>bcrypt('fixture-student'), 'type'=>'0', 'student_id'=>$student->id]);
    return $student;
};
$url = '/SMT/admin/delete_student';
$student = $fresh();
$payload = ['student_id'=>$student->id, 'password'=>'fixture-correct'];
$status($http($admin, 'POST', $url, array_merge($payload, ['password'=>'wrong'])), 422, 'incorrect password rejected');
$status($http($admin, 'POST', $url, array_merge($payload, ['password'=>'obsolete-not-the-password'])), 422, 'display credential cannot authorize deletion');
$status($http($admin, 'POST', $url, ['student_id'=>$student->id]), 422, 'empty password rejected');
$status($http($admin, 'POST', $url, ['password'=>'fixture-correct']), 422, 'missing student ID rejected');
$status($http($admin, 'POST', $url, array_merge($payload, ['student_id'=>'invalid'])), 422, 'invalid ID rejected');
$status($http($admin, 'POST', $url, array_merge($payload, ['student_id'=>999999])), 422, 'missing student rejected');
$status($http($admin, 'POST', $url, $payload, false), 419, 'real CSRF failure');
$status($http(null, 'POST', $url, $payload), 401, 'guest rejected');
$status($http($officer, 'POST', $url, $payload), 403, 'Officer cannot use Admin endpoint');
$response=$http($teacher, 'POST', $url, $payload);
$check($response->getStatusCode()===302 && App\Student::find($student->id)!==null, 'Teacher denied by existing role redirect');
$response=$http($admin, 'POST', $url, array_merge($payload,['password'=>'wrong']), true, false);
$check($response->getStatusCode()===302 && strpos($response->headers->get('Location'), '/SMT/admin/students')!==false, 'HTML failure returns to students');
$check(!array_key_exists('password', $session->getOldInput()) && $session->getOldInput('student_delete_form')===1, 'password never flashed; modal restoration marker retained');

$db::statement("CREATE TRIGGER fixture_delete_failure BEFORE DELETE ON students FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Fixture rollback'");
$status($http($admin, 'POST', $url, $payload), 500, 'database failure visible');
$check(App\Student::find($student->id)!==null && App\User::where('student_id',$student->id)->count()===1 && App\Student_detail::where('student_id',$student->id)->count()===1, 'failed deletion restores identity/account/details');
$db::statement('DROP TRIGGER fixture_delete_failure');
$response=$http($admin, 'POST', $url, $payload); $status($response,200,'hashed Admin password safely deletes history-free student');
$check(json_decode($response->getContent(),true)['student_id']===$student->id && App\Student::find($student->id)===null, 'success follows persisted deletion');
$check(App\User::where('student_id',$student->id)->count()===0 && App\Student_detail::where('student_id',$student->id)->count()===0, 'only identity shells removed');
$status($http($admin, 'POST', $url, $payload),422,'repeat deletion is not a second success');

$db::table('years')->insert(['id'=>6,'name'=>'2026/2027','current_year'=>1]);
$db::table('classes')->insert(['id'=>2,'name'=>'Fixture grade']);
$db::table('rooms')->insert(['id'=>132,'name'=>'Fixture section','class_id'=>2,'year_id'=>6]);
$retained = $fresh('Retained');
foreach ([['students_marks',['student_id'=>$retained->id,'year_id'=>6,'room_id'=>132]],
    ['report_cards',['student_id'=>$retained->id,'year_id'=>5,'room_id'=>132]],
    ['invoices',['student_id'=>$retained->id,'invoice_amount'=>125,'year_id'=>5]],
    ['transport_student_invoices',['student_id'=>$retained->id,'invoice_number'=>'fixture','invoice_amount'=>100,'bus_line_id'=>1,'year_id'=>5]],
    ['room_student',['student_id'=>$retained->id,'year_id'=>6,'room_id'=>132]],
    ['student_academic_placements',['student_id'=>$retained->id,'year_id'=>6,'class_id'=>2,'room_id'=>132,'status'=>'closed','effective_from'=>'2026-01-01']],
    ['student_register',['admission_converted_student_id'=>$retained->id,'first_name'=>'Fixture','last_name'=>'Applicant']]
] as [$table,$values]) {
    $id=$db::table($table)->insertGetId($values);
    $before=json_encode($db::table($table)->where('id',$id)->first());
    $response=$http($admin,'POST',$url,['student_id'=>$retained->id,'password'=>'fixture-correct']);
    $status($response,422,$table.' retained');
    $check($before===json_encode($db::table($table)->where('id',$id)->first()) && App\Student::find($retained->id)!==null,'retained row unchanged: '.$table);
    $db::table($table)->where('id',$id)->delete();
}
$accountId=App\User::where('student_id',$retained->id)->value('id');
$id=$db::table('student_schedule_tracer')->insertGetId(['user_id'=>$accountId,'lecture_time_id'=>1,'day_id'=>1]);
$status($http($admin,'POST',$url,['student_id'=>$retained->id,'password'=>'fixture-correct']),422,'account-linked attendance retained');
$check($db::table('student_schedule_tracer')->where('id',$id)->exists(),'attendance unchanged');
$db::table('student_schedule_tracer')->where('id',$id)->delete();
$db::table('student_details')->where('student_id',$retained->id)->update(['passport'=>'fixture-document.pdf']);
$status($http($admin,'POST',$url,['student_id'=>$retained->id,'password'=>'fixture-correct']),422,'stored document blocks deletion without touching files');
$db::table('student_details')->where('student_id',$retained->id)->update(['passport'=>null]);
$db::table('students')->where('id',$retained->id)->update(['lifecycle_status'=>'archived']);
$status($http($admin,'POST',$url,['student_id'=>$retained->id,'password'=>'fixture-correct']),422,'archived identity retained');
$db::table('students')->where('id',$retained->id)->update(['lifecycle_status'=>'active']);
$bare=App\Student::create(['first_name'=>'Bare','last_name'=>'Fixture']);
$status($http($admin,'POST',$url,['student_id'=>$bare->id,'password'=>'fixture-correct']),200,'history-free incomplete identity needs no missing-object suppression');

$create='/SMT/admin/students/store';
$input=['student_create_form'=>1,'first_name'=>'طالب تجريبي','last_name'=>'اختبار','first_name_en'=>'Synthetic','last_name_en'=>'Student',
    'father_name'=>'عبداللطيف عبدالله الحمداني العنزي','mother_name'=>'اسم الأم','phone'=>'0990000000','country'=>'Syria',
    'religion'=>'0','class_id'=>2,'room_id'=>132,'public_record_number'=>'98765-1'];
$status($http($admin,'POST',$create,[]),422,'invalid creation form');
$response=$http($admin,'POST',$create,$input,true,false); $status($response,302,'student create redirect');
$created=App\Student::where('public_record_number',$input['public_record_number'])->first();
$check($created!==null,'created identity persisted');
$check($created->first_name===$input['first_name'] && $created->country==='Syria','Arabic name and validated residence saved');
$account=App\User::where('student_id',$created->id)->first();
$check($account && Illuminate\Support\Facades\Hash::check($account->view_password,$account->password),'generated account credentials remain consistent');
$check(App\Student_detail::where('student_id',$created->id)->value('father_name')===$input['father_name'],'long Arabic guardian name preserved');
foreach(['invoices','room_student','student_academic_placements','students_marks']as$table) $check($db::table($table)->where('student_id',$created->id)->count()===1,'one create scaffold: '.$table);
$check($db::table('room_student')->where('student_id',$created->id)->value('year_id')===6,'active-year enrollment');
$status($http($admin,'POST',$create,$input),422,'duplicate student identifier blocked');
$check(App\Student::where('public_record_number',$input['public_record_number'])->count()===1,'duplicate request creates no second student');
$status($http($admin,'POST',$url,['student_id'=>$created->id,'password'=>'fixture-correct']),422,'normal created students must be archived, not hard deleted');
$counts=function()use($db){$out=[];foreach(['students','users','student_details','invoices','room_student','student_academic_placements','students_marks']as$t)$out[$t]=$db::table($t)->count();return $out;};
$before=$counts();
$session->forget('success');
$db::statement("CREATE TRIGGER fixture_create_failure BEFORE INSERT ON student_academic_placements FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT='Fixture creation rollback'");
$broken=$input; $broken['public_record_number']='98765-2';
$response=$http($admin,'POST',$create,$broken,true,false); $status($response,302,'partial creation failure returns form');
$check($counts()===$before && !App\Student::where('public_record_number','98765-2')->exists(),'partial creation rolls back identity, account, invoice, details and enrollment');
$check($session->getOldInput('first_name')===$input['first_name'] && $session->get('errors')->has('student_create_form'),'creation failure preserves safe old input and visible error');
$check(!$session->has('success'),'failed creation never flashes success before commit');
$db::statement('DROP TRIGGER fixture_create_failure');
$db::table('rooms')->insert(['id'=>133,'name'=>'Wrong class','class_id'=>99,'year_id'=>6]);
$broken['room_id']=133;
$response=$http($admin,'POST',$create,$broken,true,false);
$check($response->getStatusCode()===302 && $counts()===$before,'cross-class section rejected without inserts');
$db::table('school_data')->insert(['name'=>'Fixture school','updated_at'=>now()]);
$response=$http($admin,'GET','/SMT/admin/students',[],true,false); $status($response,200,'actual students Blade and V2 layout render');
$html=$response->getContent();
$check(strpos($html,'id="student-delete-form"')!==false && strpos($html,'student-delete.js')!==false && strpos($html,'id="student-delete-errors"')!==false,'live view includes guarded form/error feedback script');
file_put_contents($storage.'/students.html',$html);
$result=['database'=>$database,'storage'=>$storage,'assertions'=>$assertions,'server'=>$db::selectOne('SELECT VERSION() AS v')->v];
file_put_contents($storage.'/result.json',json_encode($result,JSON_PRETTY_PRINT)); echo json_encode($result,JSON_PRETTY_PRINT)."\n";
