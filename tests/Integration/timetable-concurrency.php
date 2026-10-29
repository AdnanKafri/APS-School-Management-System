<?php

// Creates and removes its own local QA database; never connects Eloquent to the school database.
require dirname(__DIR__, 2).'/vendor/autoload.php';
$qaEnvironment = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2))->load();
date_default_timezone_set('Asia/Damascus');

function verify($condition, $message)
{
    if (!$condition) { throw new RuntimeException($message); }
}

function qaEnv($key, $default = null)
{
    global $qaEnvironment;
    return $qaEnvironment[$key] ?? $_ENV[$key] ?? $_SERVER[$key] ?? $default;
}

function qaConnection($database)
{
    verify((bool) preg_match('/^aladham_timetable_qa_[a-f0-9]{16}$/D', $database), 'Invalid isolated database name.');
    $host = qaEnv('DB_HOST','127.0.0.1');
    verify(in_array($host, ['127.0.0.1','localhost','::1'], true), 'This test permits a local database server only.');
    $container = new Illuminate\Container\Container;
    Illuminate\Container\Container::setInstance($container);
    $capsule = new Illuminate\Database\Capsule\Manager($container);
    $capsule->addConnection(['driver'=>'mysql','host'=>$host,'port'=>qaEnv('DB_PORT',3306),
        'database'=>$database,'username'=>qaEnv('DB_USERNAME',''), 'password'=>qaEnv('DB_PASSWORD',''),
        'charset'=>'utf8mb4','collation'=>'utf8mb4_unicode_ci','prefix'=>'','strict'=>false]);
    $capsule->setAsGlobal(); $capsule->bootEloquent();
    $container->instance('db',$capsule->getDatabaseManager());
    Illuminate\Support\Facades\Facade::setFacadeApplication($container);
    return $capsule;
}

function waitForFile($path, $worker = null)
{
    $deadline = microtime(true) + 15;
    while (!is_file($path)) {
        if ($worker) {
            $state = proc_get_status($worker['process']);
            if (!$state['running']) {
                throw new RuntimeException('QA worker exited '.$state['exitcode'].': '
                    .stream_get_contents($worker['stdout']).stream_get_contents($worker['stderr']));
            }
        }
        verify(microtime(true) < $deadline, 'Timed out waiting for a QA worker signal.');
        usleep(20000);
        clearstatcache(true,$path);
    }
}

if (($argv[1] ?? null) === '--worker') {
    try {
        $database = $argv[2] ?? ''; $role = $argv[3] ?? ''; $directory = $argv[4] ?? '';
        verify(in_array($role, ['A','B'], true), 'Invalid worker.');
        verify(basename($directory) === $database && realpath(dirname($directory)) === realpath(sys_get_temp_dir()), 'Invalid QA signal directory.');
        qaConnection($database);
        file_put_contents($directory.'/'.$role.'_started','1');
        Illuminate\Support\Facades\DB::transaction(function () use ($role,$directory) {
            App\Year::where('current_year',1)->lockForUpdate()->firstOrFail();
            $row = App\Lesson_room_teacher_lecture_time::findOrFail(1);
            $row->teacher_id = $role === 'A' ? 167 : 168;
            $row->save();
            app(App\Services\CurrentTeacherAssignments::class)->synchronize(132);
            if ($role === 'A') {
                file_put_contents($directory.'/A_locked','1');
                waitForFile($directory.'/release_A');
            }
        }, 3);
        file_put_contents($directory.'/'.$role.'_done','1');
        exit(0);
    } catch (Throwable $e) {
        fwrite(STDERR,$e->getMessage()); exit(1);
    }
}

function startWorker($database,$role,$directory)
{
    $pipes = [];
    $process = proc_open([PHP_BINARY,__FILE__,'--worker',$database,$role,$directory],
        [0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes,dirname(__DIR__,2),null,['bypass_shell'=>true]);
    verify(is_resource($process),'Unable to start a QA worker.');
    fclose($pipes[0]);
    stream_set_blocking($pipes[1],false); stream_set_blocking($pipes[2],false);
    return ['process'=>$process,'stdout'=>$pipes[1],'stderr'=>$pipes[2]];
}

function finishWorker($worker)
{
    $deadline = microtime(true)+20;
    do {
        $status = proc_get_status($worker['process']);
        if (!$status['running']) { break; }
        verify(microtime(true)<$deadline,'Concurrent transaction timed out.');
        usleep(20000);
    } while (true);
    $output = stream_get_contents($worker['stdout']); $errors = stream_get_contents($worker['stderr']);
    fclose($worker['stdout']); fclose($worker['stderr']); proc_close($worker['process']);
    verify($status['exitcode']===0,'QA worker failed: '.$output.$errors);
}

$database = 'aladham_timetable_qa_'.bin2hex(random_bytes(8));
$directory = sys_get_temp_dir().DIRECTORY_SEPARATOR.$database;
$created = false; $server = null; $workers = [];
try {
    $host = qaEnv('DB_HOST','127.0.0.1');
    verify(in_array($host,['127.0.0.1','localhost','::1'],true),'Only a local MariaDB/MySQL server is permitted.');
    $server = new PDO('mysql:host='.$host.';port='.qaEnv('DB_PORT',3306).';charset=utf8mb4',
        qaEnv('DB_USERNAME',''),qaEnv('DB_PASSWORD',''),[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $server->exec('CREATE DATABASE `'.$database.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $created = true;
    verify(mkdir($directory,0700),'Cannot create QA signal directory.');
    qaConnection($database);
    $connection = Illuminate\Support\Facades\DB::connection();
    $ddl = [
        'years'=>'id INT PRIMARY KEY, name VARCHAR(30), current_year INT',
        'term_years'=>'id INT PRIMARY KEY, year_id INT, current_term INT',
        'rooms'=>'id INT PRIMARY KEY, class_id INT, year_id INT',
        'lessons'=>'id INT PRIMARY KEY, class_id INT, name VARCHAR(50)',
        'teachers'=>'id INT PRIMARY KEY, active INT, first_name VARCHAR(30), last_name VARCHAR(30)',
        'days'=>'id INT PRIMARY KEY',
        'lecture_times'=>'id INT PRIMARY KEY, room_id INT, type INT, start_time TIME, end_time TIME',
        'lesson_room_teacher_lecture_time'=>'id INT PRIMARY KEY, teacher_id INT, room_id INT, lesson_id INT, day_id INT, lecture_time_id INT, year_id INT, term_id INT, created_at DATETIME NULL, updated_at DATETIME NULL',
        'teacher_room_lesson'=>'id INT AUTO_INCREMENT PRIMARY KEY, teacher_id INT, room_id INT, lesson_id INT, class_id INT, year_id INT, created_at DATETIME NULL, updated_at DATETIME NULL',
        'teacher_assignment_periods'=>'id INT AUTO_INCREMENT PRIMARY KEY, teacher_room_lesson_id INT, teacher_id INT, room_id INT, lesson_id INT, class_id INT, year_id INT, effective_from DATETIME, effective_to DATETIME NULL, source VARCHAR(50), created_at DATETIME NULL, updated_at DATETIME NULL',
        'academic_sentinel'=>'id INT PRIMARY KEY, teacher_id INT, earned_mark INT, original_note VARCHAR(100)',
    ];
    foreach ($ddl as $table=>$columns) { $connection->statement('CREATE TABLE `'.$table.'` ('.$columns.') ENGINE=InnoDB'); }
    $connection->table('years')->insert(['id'=>6,'name'=>'QA year','current_year'=>1]);
    $connection->table('term_years')->insert(['id'=>20,'year_id'=>6,'current_term'=>1]);
    $connection->table('rooms')->insert(['id'=>132,'year_id'=>6,'class_id'=>2]);
    $connection->table('lessons')->insert(['id'=>409,'class_id'=>2,'name'=>'QA subject']);
    foreach ([166,167,168] as $id) { $connection->table('teachers')->insert(['id'=>$id,'active'=>0,'first_name'=>'QA','last_name'=>'Teacher']); }
    $connection->table('days')->insert(['id'=>1]);
    $connection->table('lecture_times')->insert(['id'=>1,'room_id'=>132,'type'=>1,'start_time'=>'08:00','end_time'=>'08:40']);
    $connection->table('lesson_room_teacher_lecture_time')->insert(['id'=>1,'teacher_id'=>166,'room_id'=>132,'lesson_id'=>409,'day_id'=>1,'lecture_time_id'=>1,'year_id'=>6,'term_id'=>20]);
    $connection->table('academic_sentinel')->insert(['id'=>1,'teacher_id'=>166,'earned_mark'=>31,'original_note'=>'Preserve original author and mark']);
    $authority = app(App\Services\CurrentTeacherAssignments::class);
    $authority->synchronize(132);
    $original = $connection->table('academic_sentinel')->get()->toJson();
    $workers['A'] = startWorker($database,'A',$directory);
    waitForFile($directory.'/A_locked',$workers['A']);
    $workers['B'] = startWorker($database,'B',$directory);
    waitForFile($directory.'/B_started',$workers['B']);
    usleep(300000);
    verify(!is_file($directory.'/B_done'),'Writer B bypassed the academic-year lock.');
    verify($authority->has(166,132,409),'Another connection observed a partially committed replacement.');
    file_put_contents($directory.'/release_A','1');
    finishWorker($workers['A']); unset($workers['A']);
    finishWorker($workers['B']); unset($workers['B']);
    verify($authority->has(168,132,409),'Final timetable owner is not authorized.');
    verify(!$authority->has(166,132,409) && !$authority->has(167,132,409),'A replaced Teacher retained current authority.');
    verify(App\Teacher_room_lesson::count()===3,'Annual historical references were deleted or duplicated.');
    verify(App\Teacher_room_lesson::currentTimetable()->count()===1,'Projection disagrees with the final timetable.');
    verify(App\TeacherAssignmentPeriod::whereNull('effective_to')->count()===1,'Contradictory open responsibility periods remain.');
    verify(App\TeacherAssignmentPeriod::whereNotNull('effective_to')->count()===2,'Replaced responsibility history was not closed.');
    verify($original===$connection->table('academic_sentinel')->get()->toJson(),'Original academic evidence changed.');
    echo "PASS: parallel InnoDB writers serialized; atomic visibility, final authority, retained pivots, closed periods and academic sentinel verified.\n";
} finally {
    if (is_dir($directory)) { file_put_contents($directory.'/release_A','1'); }
    foreach ($workers as $worker) { if (is_resource($worker['process'])) { proc_terminate($worker['process']); } }
    if ($created) {
        Illuminate\Support\Facades\DB::disconnect();
        $server->exec('DROP DATABASE `'.$database.'`');
        echo "Disposable QA database removed; school database was not used for test writes.\n";
    }
    if (is_dir($directory)) {
        foreach (['A_started','A_locked','B_started','A_done','B_done','release_A'] as $file) {
            if (is_file($directory.'/'.$file)) { unlink($directory.'/'.$file); }
        }
        rmdir($directory);
    }
}
