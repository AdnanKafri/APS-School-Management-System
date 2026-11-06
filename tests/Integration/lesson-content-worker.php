<?php

// Loaded only after the runner verifies the new disposable database and storage identity.
if (!isset($worker) || !$worker || !isset($argv[4]) || !Illuminate\Support\Str::isUuid($argv[4])) throw new RuntimeException('Invalid fixture worker.');
config(['lesson_content.enabled'=>true,'app.debug'=>false,'queue.default'=>'sync']);
Illuminate\Support\Facades\Auth::setUser(App\User::findOrFail(1));
$path=$storage.'/uploads/'.bin2hex(random_bytes(8));file_put_contents($path,'Concurrent fixture content');
$upload=new Illuminate\Http\UploadedFile($path,'concurrent.txt',null,UPLOAD_ERR_OK,true);
$request=Illuminate\Http\Request::create('http://localhost/SMARMANger/dashboard/teacher/classes_lessons/store_items','POST',[
    'type'=>'4','teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'lecture_id'=>5037,
    'name_addition'=>'Concurrent fixture','upload_token'=>$argv[4],'attachment_count'=>1,
],[],['attachments'=>[$upload]],['HTTP_ACCEPT'=>'application/json']);
$response=$app->make(Illuminate\Contracts\Http\Kernel::class)->handle($request);
echo json_encode(['status'=>$response->getStatusCode(),'body'=>json_decode($response->getContent(),true)]);
