<?php

namespace Tests\Concerns;

use App\Services\LessonContentLimits;
use App\Services\LessonContentStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/** Complete protected upload routes on SQLite memory DB + disposable storage, no migrations. */
trait TeacherMediaUploadChecks
{
    private function mediaFixture()
    {
        $student=$this->studentUiFixture();
        config(['lesson_content.enabled'=>true,'lesson_content.max_files'=>20,
            'lesson_content.max_file_bytes'=>2040*1048576,'lesson_content.max_total_bytes'=>2040*1048576]);
        app()->instance(LessonContentLimits::class,new class extends LessonContentLimits {
            protected function runtime(){return ['file'=>2147483648,'post'=>2147483648,'count'=>20];}
        });
        foreach (['upload_request_hash','upload_payload_hash','upload_deleted_at'] as $field) {
            Schema::table('lesson_teacher_room_term_exam',function($t)use($field){$t->text($field)->nullable();});
        }
        Schema::table('lesson_teacher_room_term_exam',function($t){$t->integer('upload_revision')->default(0);});
        Schema::create('lesson_content_attachments',function($t){
            $t->increments('id');$t->integer('content_id');$t->text('disk');$t->text('path')->unique();
            $t->text('original_name');$t->text('mime_type');$t->bigInteger('size_bytes');$t->text('sha256');$t->integer('position');
            $t->timestamp('deleted_at')->nullable();$t->timestamp('purged_at')->nullable();$t->timestamps();
        });
        Schema::table('notifications',function($t){$t->integer('lecture_id')->nullable();});
        Schema::table('lectures',function($t){foreach(['year_id','room_id','teacher_id','term_id']as$f)$t->integer($f)->nullable();$t->text('name')->nullable();$t->text('lecture_time')->nullable();});
        DB::table('lectures')->insert(['id'=>8501,'teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'year_id'=>6,'term_id'=>20,'lecture_time'=>now()->subHour(),'active'=>0,'name'=>'Media fixture']);
        Storage::fake(LessonContentStorage::DISK); Storage::fake('public');
        $this->actingAs($this->teacher);
        return $student;
    }

    private function mediaFile($name,$bytes='Educational text')
    {
        $directory=storage_path('media-upload-fixtures');if(!is_dir($directory))mkdir($directory,0700,true);
        $path=tempnam($directory,'media');file_put_contents($path,$bytes);return new UploadedFile($path,$name,null,UPLOAD_ERR_OK,true);
    }

    private function mediaCreate($files,$extra=[])
    {
        return $this->postJson('/SMARMANger/dashboard/teacher/classes_lessons/store_items',array_merge([
            'type'=>4,'lecture_id'=>8501,'teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,
            'name_addition'=>'ملفات تعليمية','note'=>'تعليمات','upload_token'=>(string)\Illuminate\Support\Str::uuid(),'attachment_count'=>count($files),'attachments'=>$files,
        ],$extra));
    }

    public function test_media_private_active_files_are_download_only_for_view_and_download_and_own_section_only()
    {
        $student=$this->mediaFixture();
        foreach (['html'=>'<!doctype html><script>alert(1)</script>','css'=>'body {color:red}','js'=>'alert(1);','php'=>'<?php echo 1;',
            'svg'=>'<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'] as $ext=>$bytes) {
            $this->actingAs($this->teacher);$r=$this->mediaCreate([$this->mediaFile('درس.'.$ext,$bytes)])->assertOk();
            $file=\App\LessonContentAttachment::where('content_id',$r->json('content_id'))->firstOrFail();
            $this->assertSame('.bin',substr($file->path,-4));$this->assertSame($bytes,Storage::disk(LessonContentStorage::DISK)->get($file->path));
            $this->actingAs($student);
            foreach (['view','download'] as $mode) {
                $r=$this->get('/SMARMANger/lesson-content/attachments/'.$file->id.'/'.$mode)->assertOk();
                $this->assertStringStartsWith('attachment;',$r->headers->get('Content-Disposition'));
                $this->assertSame('application/octet-stream',$r->headers->get('Content-Type'));
                $this->assertSame('nosniff',$r->headers->get('X-Content-Type-Options'));
                $this->assertStringContainsString('sandbox',$r->headers->get('Content-Security-Policy'));
            }
            $this->actingAs($this->admin)->get('/SMARMANger/lesson-content/attachments/'.$file->id.'/view')->assertForbidden();
        }
        $this->get('/SMARMANger/dashboard/teacher/classes_lessons/store_items')->assertStatus(405);
        $this->assertCount(0,Storage::disk('public')->allFiles());
    }

    public function test_media_batch_count_rollback_and_idempotent_retry_preserve_existing_bytes()
    {
        $this->mediaFixture();$files=[];foreach(range(1,20)as$i)$files[]=$this->mediaFile('same.txt');
        $payload=['upload_token'=>(string)\Illuminate\Support\Str::uuid()];
        $r=$this->mediaCreate($files,$payload)->assertOk();$id=$r->json('content_id');
        $this->mediaCreate($files,$payload)->assertOk()->assertJsonPath('content_id',$id);
        $this->assertSame(20,\App\LessonContentAttachment::count());
        $before=Storage::disk(LessonContentStorage::DISK)->allFiles('files');
        $files[]=$this->mediaFile('21.txt');$this->mediaCreate($files)->assertStatus(422);
        $this->mediaCreate([$this->mediaFile('good.txt'),$this->mediaFile('fake.pdf','<html>bad')])->assertStatus(422);
        $this->mediaCreate([$this->mediaFile('single.txt')],['attachment_count'=>2])->assertStatus(422);
        DB::unprepared("CREATE TRIGGER fixture_attachment_failure BEFORE INSERT ON lesson_content_attachments BEGIN SELECT RAISE(ABORT,'fixture failure'); END");
        $this->mediaCreate([$this->mediaFile('source.php','<?php echo 1;')])->assertStatus(409);
        $this->assertSame($before,Storage::disk(LessonContentStorage::DISK)->allFiles('files'));
        $this->assertSame(1,DB::table('lesson_teacher_room_term_exam')->count());
        $this->assertSame(20,\App\LessonContentAttachment::count());
    }

    public function test_media_legacy_single_video_edit_and_audio_use_limits_without_destroying_previous_files()
    {
        $this->mediaFixture();
        $video=$this->mediaFile('lesson.mp4',file_get_contents(base_path('login/assets/img/login-bg.mp4')));
        $payload=['type'=>0,'lecture_id'=>8501,'teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'name_video'=>'Video','video_in'=>$video];
        $this->post('/SMARMANger/dashboard/teacher/classes_lessons/store_items',$payload)->assertRedirect();
        $row=\App\Lesson_teacher_room_term_exam::where('type',0)->firstOrFail();$old=$row->video;
        $url='/SMARMANger/dashboard/video/update/'.$row->id;
        DB::unprepared("CREATE TRIGGER fixture_video_failure BEFORE UPDATE ON lesson_teacher_room_term_exam BEGIN SELECT RAISE(ABORT,'fixture failure'); END");
        $this->postJson($url,['name_video'=>'Edited','video'=>$video])->assertStatus(500);
        $this->assertSame($old,$row->fresh()->video);$this->assertSame([$old],Storage::disk('public')->allFiles());
        DB::unprepared('DROP TRIGGER fixture_video_failure');
        $this->post($url,['name_video'=>'Edited','video'=>$video])->assertRedirect();
        $this->assertTrue(Storage::disk('public')->exists($old));$this->assertNotSame($old,$row->fresh()->video);
        $wav='RIFF'.pack('V',836).'WAVEfmt '.pack('VvvVVvv',16,1,1,8000,8000,1,8).'data'.pack('V',800).str_repeat("\x80",800);
        $this->post('/SMARMANger/dashboard/teacher/classes_lessons/store_items',array_merge($payload,['type'=>6,'name_audio'=>'Audio','video_in'=>null,'audio_file'=>$this->mediaFile('lesson.wav',$wav)]))->assertRedirect();
        $this->assertSame(1,\App\Lesson_teacher_room_term_exam::where('type',6)->count());
        $this->postJson('/SMARMANger/dashboard/teacher/classes_lessons/store_items',array_merge($payload,['type'=>6,'name_audio'=>'Bad','video_in'=>null,'audio_file'=>$this->mediaFile('payload.php','<?php echo 1;')]))->assertStatus(422);
    }

    public function test_media_real_2040_mib_streaming_and_boundaries_in_disposable_storage()
    {
        if(getenv('ALADHAM_LARGE_MEDIA_TEST')!=='1'){$this->markTestSkipped('Opt in to the 2040 MiB isolated disk test.');}
        $this->mediaFixture();$bytes=2040*1048576;$root=storage_path('media-upload-fixtures');if(!is_dir($root))mkdir($root,0700,true);
        if(disk_free_space($root)<2*$bytes+512*1048576)$this->markTestSkipped('Insufficient isolated disk space.');
        $path=tempnam($root,'large');$h=fopen($path,'wb');$block=str_repeat("Educational text\n",65536);$left=$bytes;
        while($left>0){$n=min($left,strlen($block));if(fwrite($h,substr($block,0,$n))!==$n)throw new \RuntimeException('Fixture disk write failed');$left-=$n;}fclose($h);clearstatcache(true,$path);
        $file=new UploadedFile($path,'large.txt',null,UPLOAD_ERR_OK,true);$r=$this->mediaCreate([$file])->assertOk();
        $attachment=\App\LessonContentAttachment::where('content_id',$r->json('content_id'))->firstOrFail();
        $this->assertEquals($bytes,$attachment->size_bytes);$this->assertEquals($bytes,Storage::disk(LessonContentStorage::DISK)->size($attachment->path));
        $this->assertSame(hash_file('sha256',$path),$attachment->sha256);
        $over=new class($path,'large.txt',null,UPLOAD_ERR_OK,true) extends UploadedFile {public function getSize(){return 2040*1048576+1;}};
        $this->mediaCreate([$over])->assertStatus(422);$this->mediaCreate([$file,$this->mediaFile('extra.txt')])->assertStatus(422);
        $this->assertSame(1,\App\LessonContentAttachment::count());
        file_put_contents(storage_path('large-media-result.json'),json_encode(['bytes'=>$bytes,'peak_memory_bytes'=>memory_get_peak_usage(true)]));
        $this->actingAs($this->teacher)->postJson('/SMARMANger/dashboard/teacher/lesson-content/'.$r->json('content_id').'/delete',['revision'=>1])->assertOk();
        $this->assertFalse(Storage::disk(LessonContentStorage::DISK)->exists($attachment->path));unlink($path);
    }
}
