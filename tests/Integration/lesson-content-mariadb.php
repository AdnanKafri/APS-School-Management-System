<?php

// Explicit local fixture runner. Never migrates, inserts into, or copies school records.
$worker = ($argv[1] ?? '') === '--worker';
if (PHP_SAPI !== 'cli' || (!$worker && ($argv[1] ?? '') !== '--create-disposable-database')) exit(1);
require __DIR__.'/../../vendor/autoload.php';
$project = realpath(__DIR__.'/../..');
if (file_exists($project.'/bootstrap/cache/config.php')) throw new RuntimeException('Clear/review cached configuration before fixture testing.');
$environment = Dotenv\Dotenv::createArrayBacked($project)->load();
if (($environment['DB_CONNECTION'] ?? '') !== 'mysql' || !in_array($environment['DB_HOST'] ?? '',['127.0.0.1','localhost'],true)
    || !empty($environment['DATABASE_URL']) || !empty($environment['DB_SOCKET'])) throw new RuntimeException('Only local MariaDB fixtures are allowed.');
$database = $worker ? ($argv[2] ?? '') : 'aladham_lesson_test_'.bin2hex(random_bytes(8));
$storage = $worker ? ($argv[3] ?? '') : sys_get_temp_dir().'/aladham-lesson-test-'.bin2hex(random_bytes(16));
if (!preg_match('/^aladham_lesson_test_[a-f0-9]{16}$/D',$database) || $database === ($environment['DB_DATABASE'] ?? '')) throw new RuntimeException('Unsafe fixture identity.');
if (!preg_match('/^aladham-lesson-test-[a-f0-9]{32}$/D',basename($storage))) throw new RuntimeException('Unsafe fixture storage.');
$pdo = new PDO('mysql:host='.$environment['DB_HOST'].';port='.($environment['DB_PORT']??3306).';charset=utf8mb4',
    $environment['DB_USERNAME'],$environment['DB_PASSWORD']??'',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
if ($worker) {
    if (json_decode(file_get_contents($storage.'/identity.json'),true)!==['database'=>$database,'project'=>$project]) throw new RuntimeException('Worker fixture identity mismatch.');
} else {
    if ($pdo->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME='$database'")->fetchColumn()) throw new RuntimeException('Refusing database reuse.');
    $pdo->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    foreach (['','app','logs','framework/views','framework/cache/data','framework/sessions','uploads'] as $directory) mkdir($storage.'/'.$directory,0700,true);
    file_put_contents($storage.'/identity.json',json_encode(['database'=>$database,'project'=>$project]));
    echo "Disposable fixture: $database ($storage)\n";
}
foreach (['APP_ENV'=>'testing','DB_CONNECTION'=>'mysql','DB_HOST'=>$environment['DB_HOST'],'DB_PORT'=>$environment['DB_PORT']??3306,
    'DB_DATABASE'=>$database,'DB_USERNAME'=>$environment['DB_USERNAME'],'DB_PASSWORD'=>$environment['DB_PASSWORD']??'',
    'SESSION_DRIVER'=>'array','CACHE_DRIVER'=>'array','QUEUE_CONNECTION'=>'sync','VIEW_COMPILED_PATH'=>$storage.'/framework/views'] as $key=>$value) {
    putenv($key.'='.$value); $_SERVER[$key]=$value; $_ENV[$key]=$value;
}
$app = require $project.'/bootstrap/app.php'; $app->useStoragePath($storage);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
if (Illuminate\Support\Facades\DB::getDriverName()!=='mysql'
    || Illuminate\Support\Facades\DB::selectOne('SELECT DATABASE() AS db')->db !== $database) throw new RuntimeException('Fixture connection mismatch.');
set_exception_handler(function (Throwable $e) { fwrite(STDERR,get_class($e).': '.$e->getMessage()."\n".$e->getTraceAsString()."\n"); exit(1); });
if ($worker) { require __DIR__.'/lesson-content-worker.php'; exit; }
$assertions=0;
$check=function($ok,$label)use(&$assertions){if(!$ok)throw new RuntimeException('FAILED: '.$label);$assertions++;};
foreach (json_decode(file_get_contents(__DIR__.'/../Fixtures/gradebook-schema.json'),true) as $table=>$columns) {
    $parts=[];
    foreach($columns as $column) {
        $type = $column['type'];
        // Some legacy ENUM declarations contain duplicate empty values, rejected by strict MariaDB.
        if (strpos($type, 'enum(') === 0) {
            $values = array_unique(str_getcsv(substr($type, 5, -1), ',', "'", '\\'));
            $type = 'enum('.implode(',', array_map(function ($value) { return "'".str_replace("'", "''", $value)."'"; }, $values)).')';
        }
        $parts[]='`'.$column['name'].'` '.($column['name']==='id'?'INT NOT NULL AUTO_INCREMENT PRIMARY KEY':$type.' NULL');
    }
    Illuminate\Support\Facades\DB::statement('CREATE TABLE `'.$table.'` ('.implode(',',$parts).') ENGINE=InnoDB');
}
foreach (['messages'=>['teacher_id','type','view'],'messages_super'=>['teacher_id','view'],
    'supervisor_teacher_items'=>['teacher_id','view'],'objections'=>['teacher_id','view'],
    'notifications'=>['user_id','student_id','lesson_id','room_id','lecture_id','title','body','term_id','type'],
    'student_fcm_tokens'=>['s_fk','s_fcm_token'],'super_files'=>['lecture_id','file','name','type'],
    'school_data'=>['name'],'lectures'=>['teacher_id','class_id','room_id','lesson_id','year_id','term_id','lecture_time','name','active']] as $table=>$columns) {
    Illuminate\Support\Facades\Schema::create($table,function($t)use($columns){$t->increments('id');foreach($columns as $column)$t->text($column)->nullable();$t->timestamps();});
}
Illuminate\Support\Facades\Schema::create('days',function($t){$t->increments('id');$t->text('name')->nullable();});
Illuminate\Support\Facades\Schema::create('lecture_times',function($t){$t->increments('id');foreach(['room_id','class_id','type']as$c)$t->integer($c)->nullable();$t->text('name')->nullable();$t->time('start_time');$t->time('end_time');});
Illuminate\Support\Facades\Schema::create('lesson_room_teacher_lecture_time',function($t){$t->increments('id');foreach(['teacher_id','room_id','lesson_id','lecture_time_id','day_id','year_id','term_id']as$c)$t->integer($c);});
$db=Illuminate\Support\Facades\DB::class;
$db::table('years')->insert([['id'=>5,'current_year'=>0,'name'=>'2025/2026'],['id'=>6,'current_year'=>1,'name'=>'2026/2027'],['id'=>7,'current_year'=>0,'name'=>'2027/2028']]);
$db::table('term_years')->insert([['id'=>20,'year_id'=>6,'type'=>1,'current_term'=>1],['id'=>21,'year_id'=>6,'type'=>2,'current_term'=>0]]);
$db::table('classes')->insert(['id'=>2,'name'=>'Grade 2']);
foreach([132,133]as$id)$db::table('rooms')->insert(['id'=>$id,'class_id'=>2,'year_id'=>6,'name'=>'Section '.$id]);
$db::table('lessons')->insert(['id'=>409,'class_id'=>2,'name'=>'Arabic','books'=>'[]']);
$db::table('teachers')->insert([['id'=>166,'active'=>0],['id'=>167,'active'=>0]]);
$db::table('days')->insert(['id'=>1,'name'=>'Sunday']);
$db::table('lecture_times')->insert(['id'=>1,'room_id'=>132,'class_id'=>2,'type'=>1,'start_time'=>'08:00:00','end_time'=>'08:40:00']);
$db::table('lesson_room_teacher_lecture_time')->insert(['teacher_id'=>166,'room_id'=>132,'lesson_id'=>409,'lecture_time_id'=>1,'day_id'=>1,'year_id'=>6,'term_id'=>20]);
$db::table('teacher_room_lesson')->insert(['teacher_id'=>166,'room_id'=>132,'lesson_id'=>409,'class_id'=>2,'year_id'=>6]);
foreach([41=>132,42=>133]as$id=>$room){
    $db::table('students')->insert(['id'=>$id,'lifecycle_status'=>'active','first_name'=>'Fixture','last_name'=>(string)$id]);
    $db::table('room_student')->insert(['student_id'=>$id,'year_id'=>6,'room_id'=>$room]);
    $db::table('student_academic_placements')->insert(['student_id'=>$id,'year_id'=>6,'room_id'=>$room,'class_id'=>2,'status'=>'active','effective_from'=>'2026-01-01']);
}
$db::table('lectures')->insert(['id'=>5037,'teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'year_id'=>6,'term_id'=>20,'lecture_time'=>'2026-01-02','active'=>0,'name'=>'Fixture lesson']);
$accounts=[];
foreach([1=>[1,166,null],2=>[0,null,41],3=>[0,null,42],4=>[1,167,null],5=>[2,null,null]]as$id=>$data){
    $accounts[$id]=App\User::create(['name'=>'Fixture account','email'=>'fixture'.$id.'@example.test','password'=>bcrypt('fixture-only'),
        'type'=>(string)$data[0],'teacher_id'=>$data[1],'student_id'=>$data[2]]);
}
$db::table('lesson_teacher_room_term_exam')->insert(['id'=>1,'type'=>'4','teacher_id'=>166,'room_id'=>132,'lesson_id'=>409,'lecture_id'=>5037,'term_id'=>20,'addition'=>'filesteachers/legacy.pdf','name_addition'=>'Legacy file','note'=>null]);
$legacy=$db::table('lesson_teacher_room_term_exam')->where('id',1)->first();
require_once $project.'/database/migrations/2026_11_06_000001_create_lesson_content_attachment_foundation.php';
$migration=new CreateLessonContentAttachmentFoundation();
config(['lesson_content.enabled'=>true]);
$check(!app(App\Services\LessonContentFeature::class)->enabled(),'missing schema cannot activate grouped content');
Illuminate\Support\Facades\Schema::table('lesson_teacher_room_term_exam',function($t){$t->unsignedInteger('upload_revision')->default(0);});
try{$migration->up();$check(false,'partial schema must refuse');}catch(RuntimeException $e){$check(!Illuminate\Support\Facades\Schema::hasColumn('lesson_teacher_room_term_exam','upload_request_hash'),'partial migration refuses before modifying other columns');}
Illuminate\Support\Facades\Schema::table('lesson_teacher_room_term_exam',function($t){$t->dropColumn('upload_revision');});
$migration->up(); $migration->down();
Illuminate\Support\Facades\Artisan::call('migrate', ['--path'=>'database/migrations/2026_11_06_000001_create_lesson_content_attachment_foundation.php','--force'=>true]);
$check($db::table('migrations')->where('migration','2026_11_06_000001_create_lesson_content_attachment_foundation')->count()===1,'fixture migration registered once');
Illuminate\Support\Facades\Artisan::call('migrate', ['--path'=>'database/migrations/2026_11_06_000001_create_lesson_content_attachment_foundation.php','--force'=>true]);
$check($db::table('migrations')->count()===1,'fixture migration rerun is a no-op');
try{$migration->up();$check(false,'blind migration reapply must refuse');}catch(RuntimeException $e){$check(true,'physical schema cannot be blindly recreated');}
$check($db::table('lesson_teacher_room_term_exam')->where('id',1)->value('addition')===$legacy->addition,'MariaDB additive up/down/up preserves legacy file');
$check($db::table('lesson_content_attachments')->count()===0,'no legacy attachment backfill');
config(['lesson_content.enabled'=>true,'app.debug'=>false,'queue.default'=>'sync']);
Illuminate\Support\Facades\View::composer(['teachers2.layouts.app','students.layouts.app4'],function($view)use($project){$view->setPath($project.'/tests/Fixtures/lesson-workspace-layout.blade.php');});
$http=function($user,$method,$url,$data=[],$files=[],$headers=[])use($app){
    if($user)Illuminate\Support\Facades\Auth::setUser($user);
    else Illuminate\Support\Facades\Auth::logout();
    $request=Illuminate\Http\Request::create('http://localhost'.$url,$method,$data,[],$files,array_merge(['HTTP_ACCEPT'=>'application/json'],$headers));
    return $app->make(Illuminate\Contracts\Http\Kernel::class)->handle($request);
};
$upload=function($name='fixture.txt',$bytes='Fixture plain text')use($storage){$path=$storage.'/uploads/'.bin2hex(random_bytes(8));file_put_contents($path,$bytes);return new Illuminate\Http\UploadedFile($path,$name,null,UPLOAD_ERR_OK,true);};
$payload=function() {return ['type'=>'4','teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'lecture_id'=>5037,'name_addition'=>'محتوى للاختبار','note'=>"تعليمات\n<script>not HTML</script>",'upload_token'=>(string)Illuminate\Support\Str::uuid()];};
$url='/SMARMANger/dashboard/teacher/classes_lessons/store_items';
$initial=$payload();$initial['attachment_count']=2;
$response=$http($accounts[1],'POST',$url,$initial,['attachments'=>[$upload(),$upload('ملف ثان.txt')]]);
$check($response->getStatusCode()===200,'two-file HTTP create: '.$response->getContent());
$id=json_decode($response->getContent(),true)['content_id'];
$check(App\LessonContentAttachment::where('content_id',$id)->count()===2,'two ordered children');
$file=App\LessonContentAttachment::where('content_id',$id)->first();
$response=$http($accounts[2],'GET','/SMARMANger/lesson-content/attachments/'.$file->id.'/download');
$check($response->getStatusCode()===200,'authorized Student download');
$check($http($accounts[3],'GET','/SMARMANger/lesson-content/attachments/'.$file->id.'/download')->getStatusCode()===403,'foreign Student denied');
require __DIR__.'/lesson-content-cases.php';
$result=['database'=>$database,'storage'=>$storage,'assertions'=>$assertions,'server'=>$db::selectOne('SELECT VERSION() AS v')->v];
file_put_contents($storage.'/result.json',json_encode($result,JSON_PRETTY_PRINT));
echo json_encode($result,JSON_PRETTY_PRINT)."\n";
