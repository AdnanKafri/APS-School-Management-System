<?php

// Explicit opt-in integration test. Creates only a new, uniquely named local fixture database.
use App\GradebookEvent;
use App\GradebookTemplate;
use App\GradebookTemplateVersion;
use App\Services\Gradebook\GradebookTemplateService;
use Illuminate\Support\Facades\DB;

if (PHP_SAPI !== 'cli') exit(1);
require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../Concerns/GradebookTemplateFixtures.php';
$project = realpath(__DIR__.'/../..');
if (file_exists($project.'/bootstrap/cache/config.php')) throw new RuntimeException('Cached config is not allowed.');
$environment = Dotenv\Dotenv::createArrayBacked($project)->load();
// Optional fresh local server: never redirect the application's .env or existing server.
$isolatedPort = getenv('ALADHAM_GBT_ISOLATED_PORT');
if ($isolatedPort !== false && $isolatedPort !== '') {
    if (!ctype_digit($isolatedPort) || (int)$isolatedPort < 1024 || (int)$isolatedPort > 65535 || (int)$isolatedPort === 3306) {
        throw new RuntimeException('Invalid isolated server port.');
    }
    $environment = array_merge($environment, ['DB_CONNECTION'=>'mysql','DB_HOST'=>'127.0.0.1',
        'DB_PORT'=>$isolatedPort,'DB_USERNAME'=>'root','DB_PASSWORD'=>'','DATABASE_URL'=>'','DB_SOCKET'=>'']);
}
if (($environment['DB_CONNECTION'] ?? 'mysql') !== 'mysql'
    || !in_array($environment['DB_HOST'] ?? '', ['127.0.0.1','localhost','::1'], true)
    || !empty($environment['DATABASE_URL']) || !empty($environment['DB_SOCKET'])) {
    throw new RuntimeException('Only an explicitly local mysql connection is allowed.');
}
$worker = ($argv[1] ?? '') === '--worker';
if (!$worker && ($argv[1] ?? '') !== '--create-isolated-database') {
    fwrite(STDERR, "Usage: php tests/Integration/gradebook-templates-mariadb.php --create-isolated-database\n");
    exit(1);
}
$database = $worker ? ($argv[2] ?? '') : 'aladham_gbt_test_'.bin2hex(random_bytes(8));
$storage = $worker ? ($argv[3] ?? '') : sys_get_temp_dir().'/aladham-gbt-mariadb-'.bin2hex(random_bytes(16));
if (!preg_match('/^aladham_gbt_test_[a-f0-9]{16}$/D', $database)
    || $database === ($environment['DB_DATABASE'] ?? '')
    || !preg_match('/^aladham-gbt-mariadb-[a-f0-9]{32}$/D', basename($storage))) {
    throw new RuntimeException('Invalid fixture database/storage identity.');
}
$dsn = 'mysql:host='.$environment['DB_HOST'].';port='.($environment['DB_PORT'] ?? 3306).';charset=utf8mb4';
$server = new PDO($dsn, $environment['DB_USERNAME'], $environment['DB_PASSWORD'] ?? '', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
if (!$worker) {
    if ($server->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '$database'")->fetchColumn()) {
        throw new RuntimeException('Refusing to reuse any existing database.');
    }
    $server->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    foreach (['','logs','app','framework/views','framework/cache/data','framework/sessions','jobs'] as $directory) {
        mkdir($storage.'/'.$directory, 0700, true);
    }
    file_put_contents($storage.'/identity.json', json_encode(['database'=>$database,'project'=>$project]));
    echo "Disposable database: $database\nArtifacts: $storage\n";
} else {
    $identity = json_decode(file_get_contents($storage.'/identity.json'), true);
    if ($identity !== ['database'=>$database,'project'=>$project]) throw new RuntimeException('Worker identity mismatch.');
}
foreach (['APP_ENV'=>'testing','DB_CONNECTION'=>'mysql','DB_HOST'=>$environment['DB_HOST'],
    'DB_PORT'=>$environment['DB_PORT'] ?? '3306','DB_DATABASE'=>$database,
    'DB_USERNAME'=>$environment['DB_USERNAME'],'DB_PASSWORD'=>$environment['DB_PASSWORD'] ?? '',
    'CACHE_DRIVER'=>'array','SESSION_DRIVER'=>'array','VIEW_COMPILED_PATH'=>$storage.'/framework/views'] as $key=>$value) {
    putenv($key.'='.$value); $_SERVER[$key]=$value; $_ENV[$key]=$value;
}
$app = require $project.'/bootstrap/app.php';
$app->useStoragePath($storage);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
set_exception_handler(function (Throwable $exception) {
    fwrite(STDERR, get_class($exception).': '.$exception->getMessage()."\n");
    exit(1);
});
if (DB::getDriverName() !== 'mysql' || DB::connection()->getDatabaseName() !== $database
    || DB::selectOne('SELECT DATABASE() AS db')->db !== $database) throw new RuntimeException('Effective connection is not isolated.');

class TemplateMariaFixtures { use Tests\Concerns\GradebookTemplateFixtures;
    public function install() { $this->templateFixtureSchema(); }
    public function payload() { return $this->templatePayload(); }
}
$fixtures = new TemplateMariaFixtures();
if (!$worker) $fixtures->install();
auth()->setUser(App\User::findOrFail(1));
$service = app(GradebookTemplateService::class);

if ($worker) {
    $jobId = $argv[4] ?? '';
    if (!preg_match('/^(publish|save)-[01]$/D', $jobId)) throw new RuntimeException('Invalid job identity.');
    $job = json_decode(file_get_contents($storage.'/jobs/'.$jobId.'.json'), true);
    file_put_contents($storage.'/jobs/'.$jobId.'.ready', 'ready');
    $deadline = microtime(true)+20;
    while (!file_exists($storage.'/jobs/'.$job['kind'].'.go')) {
        if (microtime(true)>$deadline) throw new RuntimeException('Barrier timeout.');
        usleep(10000);
    }
    try {
        if ($job['kind'] === 'publish') {
            $result = $service->publish($job['id'],$job['revision'],$job['token'],1);
            $output = ['status'=>'ok','version_id'=>(int)$result->id];
        } else {
            $result = $service->save($job['id'],$job['revision'],$job['payload']);
            $output = ['status'=>'ok','revision'=>$result->draft_revision];
        }
    } catch (Illuminate\Validation\ValidationException $e) {
        $output = ['status'=>'validation_rejected'];
    }
    file_put_contents($storage.'/jobs/'.$jobId.'.result', json_encode($output));
    exit(0);
}

$assertions = 0;
$check = function ($condition, $label) use (&$assertions) {
    if (!$condition) throw new RuntimeException('FAILED: '.$label);
    $assertions++;
};
$migration = new CreateGradebookTemplateFoundation();
$check($service->available(), 'three tables and four immutability triggers');
$migration->down(); $migration->up();
$check($service->available(), 'empty rollback and reinstallation');
$template = $service->create(6,409,'MariaDB fixture');
$template = $service->save($template->id,1,$fixtures->payload());
$preview = $service->preview($template->id);
$check($preview['total'] === 155, 'no forced 100 total');

$race = function ($kind, array $job) use ($storage,$database,$dsn,$environment,$server,$check) {
    $locker = new PDO($dsn.';dbname='.$database, $environment['DB_USERNAME'], $environment['DB_PASSWORD'] ?? '', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $locker->beginTransaction();
    $statement = $locker->prepare('SELECT id FROM gradebook_templates WHERE id = ? FOR UPDATE');
    $statement->execute([$job['id']]); $statement->fetchAll();
    $processes = [];
    try {
        foreach ([0,1] as $index) {
            $name = $kind.'-'.$index;
            file_put_contents($storage.'/jobs/'.$name.'.json', json_encode($job+['kind'=>$kind]));
            $process = proc_open([PHP_BINARY,__FILE__,'--worker',$database,$storage,$name],
                [0=>['pipe','r'],1=>['file',$storage.'/jobs/'.$name.'.stdout','w'],2=>['file',$storage.'/jobs/'.$name.'.stderr','w']], $pipes);
            if (!is_resource($process)) throw new RuntimeException('Worker failed to start.');
            fclose($pipes[0]); $processes[]=$process;
        }
        $deadline=microtime(true)+20;
        while (!file_exists($storage.'/jobs/'.$kind.'-0.ready') || !file_exists($storage.'/jobs/'.$kind.'-1.ready')) {
            if(microtime(true)>$deadline) throw new RuntimeException('Workers did not reach the barrier.');
            usleep(10000);
        }
        file_put_contents($storage.'/jobs/'.$kind.'.go','go');
        $waiting=0; $deadline=microtime(true)+10;
        do {
            $waiting=(int)$server->query("SELECT COUNT(*) FROM information_schema.PROCESSLIST WHERE DB='$database' AND COMMAND IN ('Execute','Query') AND INFO LIKE '%gradebook_templates%' AND INFO LIKE '%for update%'")->fetchColumn();
            if($waiting>=2) break;
            usleep(20000);
        } while(microtime(true)<$deadline);
        file_put_contents($storage.'/jobs/'.$kind.'.locks.json',json_encode([
            'waiting'=>$waiting,
            'processes'=>$server->query("SELECT ID,DB,COMMAND,STATE,INFO FROM information_schema.PROCESSLIST WHERE DB='$database'")->fetchAll(PDO::FETCH_ASSOC),
            'transactions'=>$server->query('SELECT trx_id,trx_state,trx_mysql_thread_id,trx_query FROM information_schema.INNODB_TRX')->fetchAll(PDO::FETCH_ASSOC),
        ],JSON_PRETTY_PRINT));
        $check($waiting>=2 && !file_exists($storage.'/jobs/'.$kind.'-0.result')
            && !file_exists($storage.'/jobs/'.$kind.'-1.result'),
            $kind.': both FOR UPDATE requests pending before the held row lock is released');
    } finally { $locker->rollBack(); }
    $results=[];
    foreach($processes as $index=>$process) {
        $check(proc_close($process)===0, $kind.': worker exit '.$index);
        $path=$storage.'/jobs/'.$kind.'-'.$index.'.result';
        $check(file_exists($path), $kind.': worker result '.$index);
        $results[]=json_decode(file_get_contents($path),true);
    }
    return $results;
};
$results=$race('publish',['id'=>$template->id,'revision'=>$preview['revision'],'token'=>$preview['preview_token']]);
$check(array_column($results,'status')===['ok','ok'], 'both publish requests return the same committed publication');
$check($results[0]['version_id']===$results[1]['version_id'], 'publication idempotency under concurrent requests');
$check(GradebookTemplateVersion::count()===1, 'exactly one V1');
$check(GradebookEvent::where('action','version_published')->count()===1, 'exactly one publication event');
$v1=GradebookTemplateVersion::firstOrFail(); $original=$v1->getRawOriginal();
$template=$service->startDraft($template->id,$template->fresh()->draft_revision,$v1->id);
$results=$race('save',['id'=>$template->id,'revision'=>$template->draft_revision,'payload'=>$template->draft_payload]);
$statuses=array_column($results,'status');sort($statuses);
$check($statuses===['ok','validation_rejected'], 'concurrent stale editor is rejected');
$template=$template->fresh(); $preview=$service->preview($template->id);
$service->publish($template->id,$preview['revision'],$preview['preview_token'],1);
$check(GradebookTemplateVersion::count()===2, 'V2 created');
$check($v1->fresh()->getRawOriginal()===$original, 'V1 snapshot unchanged');
foreach (['gradebook_template_versions','gradebook_events'] as $table) {
    foreach (['update','delete'] as $operation) {
        $blocked=false;
        try {
            if($operation==='update') DB::table($table)->update(['id'=>1]);
            else DB::table($table)->delete();
        } catch (Illuminate\Database\QueryException $e) { $blocked=strpos($e->getMessage(),'immutable')!==false; }
        $check($blocked, $table.' raw '.$operation.' blocked by MariaDB trigger');
    }
}
$template=$service->startDraft($template->id,$template->fresh()->draft_revision,$v1->id);
$before=$template->fresh()->getRawOriginal(); $eventCount=GradebookEvent::count();
GradebookEvent::creating(function($event){if($event->action==='version_published')throw new RuntimeException('Injected audit failure');});
$rolledBack=false;
try { $review=$service->preview($template->id);$service->publish($template->id,$review['revision'],$review['preview_token'],1); }
catch(RuntimeException $e){$rolledBack=$e->getMessage()==='Injected audit failure';}
$check($rolledBack && GradebookTemplateVersion::count()===2 && GradebookEvent::count()===$eventCount
    && $template->fresh()->getRawOriginal()===$before, 'failed audit rolls publication back atomically');
$preserved=false;
try{$migration->down();}catch(RuntimeException $e){$preserved=strpos($e->getMessage(),'preservation')!==false;}
$check($preserved && GradebookTemplateVersion::count()===2, 'populated rollback refuses destruction');
$unique=false;
try{DB::table('gradebook_templates')->insert(['identity'=>(string)Illuminate\Support\Str::uuid(),'year_id'=>6,'lesson_id'=>409,'class_id'=>2,'created_by'=>1,'name'=>'Conflict']);}
catch(Illuminate\Database\QueryException $e){$unique=(string)$e->getCode()==='23000';}
$check($unique,'database subject/year uniqueness');
$foreign=false;
try{DB::table('gradebook_templates')->insert(['identity'=>(string)Illuminate\Support\Str::uuid(),'year_id'=>999,'lesson_id'=>410,'class_id'=>3,'created_by'=>1,'name'=>'Invalid']);}
catch(Illuminate\Database\QueryException $e){$foreign=(string)$e->getCode()==='23000';}
$check($foreign,'database foreign keys');
$summary=['database'=>$database,'server'=>DB::selectOne('SELECT VERSION() AS version')->version,
    'assertions'=>$assertions,'versions'=>GradebookTemplateVersion::count(),'concurrent_publish'=>'PASS',
    'concurrent_edit'=>'PASS','recovery'=>'Fixture-only database retained; recreate through this runner. No school data copied.'];
file_put_contents($storage.'/result.json',json_encode($summary,JSON_PRETTY_PRINT));
echo json_encode($summary,JSON_PRETTY_PRINT)."\n";
