<?php

// Separate InnoDB connection/process. It cannot target the configured school DB.
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__.'/../../vendor/autoload.php';
$project=realpath(__DIR__.'/../..');$database=$argv[1]??'';$storage=$argv[2]??'';$mode=$argv[3]??'';$examId=(int)($argv[4]??0);
if (!preg_match('/^aladham_lesson_test_[a-f0-9]{16}$/D',$database)
    || !preg_match('/^aladham-lesson-test-[a-f0-9]{32}$/D',basename($storage))
    || getenv('DB_DATABASE')!==$database || getenv('APP_ENV')!=='testing'
    || !in_array(getenv('DB_HOST'),['127.0.0.1','localhost'],true)
    || !in_array($mode,['transfer','grade'],true) || !$examId
    || file_exists($project.'/bootstrap/cache/config.php')
    || json_decode(file_get_contents($storage.'/identity.json'),true)!==['database'=>$database,'project'=>$project]) exit(2);
$app=require $project.'/bootstrap/app.php';$app->useStoragePath($storage);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
if (Illuminate\Support\Facades\DB::selectOne('SELECT DATABASE() AS db')->db!==$database) exit(3);
config(['app.debug'=>false]);
Illuminate\Support\Facades\Auth::setUser(App\User::where('type',$mode==='grade'?'1':'2')->firstOrFail());
file_put_contents($storage.'/visit-'.$mode.'-'.$examId.'.ready','ready');
try {
    if ($mode==='grade') {
        app(App\Services\TeacherAssessmentService::class)->save($examId,7441,7132,409,0);
        echo json_encode(['status'=>200]);
    } else {
        $service=app(App\Services\StudentTransferService::class);
        $service->handle(Illuminate\Http\Request::create('/','POST',['student_id'=>7441,'class_change_id'=>2,'room_change_id'=>7133]));
        echo json_encode(['status'=>$service->succeeded()?200:409]);
    }
} catch (Symfony\Component\HttpKernel\Exception\HttpException $e) {
    echo json_encode(['status'=>$e->getStatusCode()]);
} catch (Throwable $e) {
    fwrite(STDERR,get_class($e).': '.$e->getMessage());exit(4);
}
