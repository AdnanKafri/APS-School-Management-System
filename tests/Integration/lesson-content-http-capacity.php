<?php

// Real multipart parsing in a separate loopback-only PHP process and fixture DB.
if (!isset($database) || !preg_match('/^aladham_lesson_test_[a-f0-9]{16}$/D',$database)
    || $db::selectOne('SELECT DATABASE() AS db')->db !== $database) throw new RuntimeException('Fixture identity mismatch.');
$nonce=bin2hex(random_bytes(32));
$router=$storage.'/http-router.php';
$source='<?php '."\n".'$project='.var_export($project,true).'; $fixtureStorage='.var_export($storage,true).'; $fixtureDatabase='.var_export($database,true).';' . "\n";
$source.='if ($_SERVER["REMOTE_ADDR"] !== "127.0.0.1" || !hash_equals('.var_export($nonce,true).', $_SERVER["HTTP_X_FIXTURE_KEY"] ?? "")) { http_response_code(403); exit; }' . "\n";
$source.= <<<'PHP'
require $project.'/vendor/autoload.php';
file_put_contents($fixtureStorage.'/http-progress.log', 'router entered '.microtime(true)."\n",FILE_APPEND);
$app=require $project.'/bootstrap/app.php';$app->useStoragePath($fixtureStorage);
$request=Illuminate\Http\Request::capture();$app->instance('request',$request);
$kernel=$app->make(Illuminate\Contracts\Http\Kernel::class);$kernel->bootstrap();
if (!app()->environment('testing') || Illuminate\Support\Facades\DB::selectOne('SELECT DATABASE() AS db')->db !== $fixtureDatabase) { http_response_code(403);exit; }
config(['lesson_content.enabled'=>true,'lesson_content.max_files'=>30,'lesson_content.max_file_bytes'=>104857600,'lesson_content.max_total_bytes'=>157286400,'session.driver'=>'file','session.cookie'=>'fixture_capacity_session','session.secure'=>false,'session.domain'=>null,'queue.default'=>'sync','app.debug'=>false]);
Illuminate\Support\Facades\Auth::setUser(App\User::findOrFail(1));
Illuminate\Support\Facades\Route::get('/_fixture/csrf',function(){return response()->json(['token'=>csrf_token()]);})->middleware('web');
if (!in_array($request->path(),['SMARMANger/dashboard/teacher/classes_lessons/store_items','_fixture/csrf'],true)) {http_response_code(404);exit;}
file_put_contents($fixtureStorage.'/http-progress.log', 'kernel start '.microtime(true)."\n",FILE_APPEND);
$response=$kernel->handle($request);file_put_contents($fixtureStorage.'/http-progress.log','kernel end '.microtime(true)."\n",FILE_APPEND);$response->send();$kernel->terminate($request,$response);
PHP;
file_put_contents($router,$source);
$socket=stream_socket_server('tcp://127.0.0.1:0',$errno,$error);
if(!$socket)throw new RuntimeException('Cannot reserve fixture port.');
$address=stream_socket_get_name($socket,false);fclose($socket);
$process=proc_open([PHP_BINARY,'-d','upload_max_filesize=100M','-d','post_max_size=160M','-d','max_file_uploads=30',
    '-d','max_execution_time=120','-d','max_input_time=600','-S',$address,$router],
    [0=>['pipe','r'],1=>['file',$storage.'/http-server.log','a'],2=>['file',$storage.'/http-server.log','a']],$pipes,$project);
if(!is_resource($process))throw new RuntimeException('Cannot start isolated HTTP fixture.');fclose($pipes[0]);
try {
    $ready=false;
    for($i=0;$i<50;$i++) {
        $probe=@stream_socket_client('tcp://'.$address,$errno,$error,0.1);
        if($probe){fclose($probe);$ready=true;break;}usleep(100000);
    }
    $check($ready,'isolated HTTP fixture starts with explicit process-only PHP limits');
    $cookieFile=$storage.'/http-cookies.txt';
    $csrfProcess=proc_open([PHP_OS_FAMILY==='Windows'?'curl.exe':'curl','--silent','--show-error','--cookie-jar',$cookieFile,
        '--header','Accept: application/json','--header','X-Fixture-Key: '.$nonce,'http://'.$address.'/_fixture/csrf'],
        [0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes);
    fclose($pipes[0]);$csrfBody=stream_get_contents($pipes[1]);$csrfError=stream_get_contents($pipes[2]);fclose($pipes[1]);fclose($pipes[2]);
    $check(proc_close($csrfProcess)===0,'fixture CSRF transport succeeds: '.$csrfError);
    $csrf=json_decode($csrfBody,true)['token']??null;$check(is_string($csrf) && strlen($csrf)>20,'real session CSRF token obtained');
    $sendMultipart=function(array $files)use($payload,$url,$address,$nonce,$cookieFile,$csrf) {
        $fields=$payload();$fields['attachment_count']=count($files);$fields['_token']=$csrf;
        $command=[PHP_OS_FAMILY==='Windows'?'curl.exe':'curl','--silent','--show-error','--max-time','600',
            '--header','Accept: application/json','--header','X-Fixture-Key: '.$nonce,'--header','Expect:',
            '--cookie',$cookieFile,'--cookie-jar',$cookieFile,'--write-out',"\n%{http_code}"];
        foreach($fields as $key=>$value){$command[]='--form-string';$command[]=$key.'='.$value;}
        foreach($files as $index=>$file){$command[]='--form';$command[]='attachments['.$index.']=@'.$file->getRealPath().';filename='.$file->getClientOriginalName();}
        $command[]='http://'.$address.$url;
        $curl=proc_open($command,[0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes);
        if(!is_resource($curl))throw new RuntimeException('Cannot start system curl.');fclose($pipes[0]);
        $output=stream_get_contents($pipes[1]);$error=stream_get_contents($pipes[2]);fclose($pipes[1]);fclose($pipes[2]);
        if(proc_close($curl)!==0)throw new RuntimeException('Fixture HTTP transport failed: '.$error);
        $split=strrpos($output,"\n");$body=substr($output,0,$split);$status=(int)substr($output,$split+1);
        return [$status,json_decode($body,true),substr($body,0,500)];
    };
    $files=[];for($i=0;$i<30;$i++)$files[]=$upload();
    [$status,$body,$text]=$sendMultipart($files);
    $check($status===200,'real multipart accepts 30 files ['.$status.']: '.$text);
    $check(App\LessonContentAttachment::where('content_id',$body['content_id'])->count()===30,'HTTP count matches 30 stored fixture attachments');
    $sources=[$project.'/login/assets/img/login-bg.mp4'];
    if(getenv('ALADHAM_SMALL_MP4_FIXTURE'))array_unshift($sources,getenv('ALADHAM_SMALL_MP4_FIXTURE'));
    foreach($sources as $source) {
        [$status,$body,$text]=$sendMultipart([new Illuminate\Http\UploadedFile($source,'real-video.mp4',null,UPLOAD_ERR_OK,true)]);
        $check($status===200,'real multipart MP4 upload '.filesize($source).' bytes ['.$status.']: '.$text);
        $check(App\LessonContentAttachment::where('content_id',$body['content_id'])->value('sha256')===hash_file('sha256',$source),'real HTTP MP4 stores unchanged bytes');
    }
    if (getenv('ALADHAM_HTTP_MAXIMUM_GATE') !== '1') {
        echo "150 MiB maximum-body transport gate not requested; set ALADHAM_HTTP_MAXIMUM_GATE=1.\n";
        return;
    }
    $sizedVideo=function($bytes)use($storage,$project) {
        $path=$storage.'/uploads/'.bin2hex(random_bytes(8));copy($project.'/login/assets/img/login-bg.mp4',$path);
        $padding=$bytes-filesize($path);if($padding<8)throw new RuntimeException('MP4 fixture must have space for a free box.');
        $handle=fopen($path,'r+b');fseek($handle,0,SEEK_END);fwrite($handle,pack('N',$padding).'free');ftruncate($handle,$bytes);fclose($handle);
        return new Illuminate\Http\UploadedFile($path,'sized-video.mp4',null,UPLOAD_ERR_OK,true);
    };
    [$status,$body,$text]=$sendMultipart([$sizedVideo(100*1048576),$sizedVideo(50*1048576)]);
    $check($status===200,'real multipart accepts 150 MiB under isolated 160M PHP envelope: '.$text);
    $check((int)App\LessonContentAttachment::where('content_id',$body['content_id'])->sum('size_bytes')===157286400,'HTTP stores exactly 150 MiB');
    [$status,$body,$text]=$sendMultipart([$sizedVideo(100*1048576+1)]);
    $check($status===422 && strpos($text,'server_limit')===false,'real PHP per-file limit returns a localized validation error');
    [$status,$body,$text]=$sendMultipart([$sizedVideo(90*1048576),$sizedVideo(71*1048576)]);
    $check($status===413 && ($body['message']??null)===__('lesson_content.server_limit',[],'ar'),'real PHP post_max_size rejection returns localized 413');
} finally {
    proc_terminate($process);proc_close($process);
}
