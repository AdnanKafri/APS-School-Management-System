<?php

// Restricted child of the disposable observation runner; never accepts school targets.
[$script,$database,$storage,$mode,$student,$assessment,$actor,$ready]=$argv;
if (PHP_SAPI!=='cli' || !preg_match('/^aladham_student_workflow_test_[a-f0-9]{16}$/D',$database)
    || !preg_match('/^aladham-student-workflow-[a-f0-9]{32}$/D',basename($storage))
    || getenv('DB_DATABASE')!==$database || getenv('APP_ENV')!=='testing'
    || !in_array(getenv('DB_HOST'),['localhost','127.0.0.1'],true)
    || !in_array($mode,['grade','transfer'],true) || dirname($ready)!==$storage) exit(1);
$identity=json_decode(file_get_contents($storage.'/observation-identity.json'),true);
if (($identity['database']??null)!==$database || ($identity['storage']??null)!==realpath($storage)
    || file_exists(__DIR__.'/../../bootstrap/cache/config.php')) exit(1);
require __DIR__.'/../../vendor/autoload.php';
$app=require __DIR__.'/../../bootstrap/app.php';$app->useStoragePath($storage);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
if (Illuminate\Support\Facades\DB::selectOne('SELECT DATABASE() AS db')->db!==$database) exit(1);
app()->setLocale('ar');Illuminate\Support\Facades\Auth::setUser(App\User::findOrFail($mode==='transfer'?$assessment:$actor));
file_put_contents($ready,'ready');
try {
    if($mode==='grade') app(App\Services\TeacherAssessmentService::class)->save((int)$assessment,(int)$student,132,409,0);
    else {
        $service=app(App\Services\StudentTransferService::class);
        $service->handle(Illuminate\Http\Request::create('/','POST',['student_id'=>(int)$student,'class_change_id'=>2,'room_change_id'=>7133]));
        if(!$service->succeeded())throw new RuntimeException('Fixture transfer did not succeed');
    }
    echo json_encode(['status'=>200]);
} catch (Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e) { echo json_encode(['status'=>$e->getStatusCode()]); }
