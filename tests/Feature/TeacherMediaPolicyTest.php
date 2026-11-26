<?php

namespace Tests\Feature;

use App\Services\LessonContentFileTypes;
use App\Services\LessonContentInput;
use App\Services\LessonContentLimits;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

/** @runTestsInSeparateProcesses @preserveGlobalState disabled */
class TeacherMediaPolicyTest extends TestCase
{
    private function limits(array $runtime)
    {
        return new class($runtime) extends LessonContentLimits {
            private $settings;
            public function __construct($settings) { $this->settings=$settings; }
            protected function runtime() { return $this->settings; }
        };
    }

    private function upload($name,$bytes)
    {
        $directory=storage_path('media-policy-fixtures');
        if (!is_dir($directory)) mkdir($directory,0700,true);
        $path=tempnam($directory,'media'); file_put_contents($path,$bytes);
        return new UploadedFile($path,$name,null,UPLOAD_ERR_OK,true);
    }

    private function rejectFile($name,$bytes)
    {
        try { app(LessonContentFileTypes::class)->inspect($this->upload($name,$bytes)); $this->fail('Accepted '.$name); }
        catch (ValidationException $e) { $this->assertArrayHasKey('attachments',$e->errors()); }
    }

    public function test_host_profile_leaves_eight_mib_for_multipart_and_respects_lower_php_and_env_limits()
    {
        $host=$this->limits(['file'=>2147483648,'post'=>2147483648,'count'=>20]);
        $this->assertSame(['max_files'=>20,'max_file_bytes'=>2139095040,'max_total_bytes'=>2139095040],$host->values());
        $this->assertSame(2147483648,$host->requestBytes());
        $this->assertSame(2147483648,LessonContentLimits::iniBytes('2048M'));
        $this->assertSame(2147483648,LessonContentLimits::iniBytes('2G'));
        $this->assertSame(0,LessonContentLimits::iniBytes('0'));
        config(['lesson_content.max_files'=>30,'lesson_content.max_file_bytes'=>2147483648,'lesson_content.max_total_bytes'=>2147483648]);
        $this->assertSame(2139095040,$host->values()['max_file_bytes']);
        $largerPost=$this->limits(['file'=>2147483648,'post'=>2056*1048576,'count'=>20]);
        $this->assertSame(2147483648,$largerPost->values()['max_file_bytes']);
        $this->assertSame(2056*1048576,$largerPost->requestBytes());
        $small=$this->limits(['file'=>2*1048576,'post'=>8*1048576,'count'=>5]);
        $this->assertSame(5,$small->values()['max_files']); $this->assertSame(2*1048576,$small->values()['max_file_bytes']);
        $this->assertLessThan(8*1048576,$small->values()['max_total_bytes']);
        config(['lesson_content.max_file_bytes'=>1048576,'lesson_content.max_total_bytes'=>2097152]);
        $this->assertSame(1048576,$host->values()['max_file_bytes']);
        $this->assertSame(2097152,$host->values()['max_total_bytes']);
    }

    public function test_text_and_source_allowlist_preserves_names_but_uses_nonexecuting_private_paths()
    {
        $policy=app(LessonContentFileTypes::class);
        foreach (['txt','csv','tsv','md','markdown','rst','log','ini','conf','cfg','properties','yaml','yml','tex','bib','cls','sty','srt','vtt','ass','ssa',
            'html','htm','css','scss','sass','less','js','mjs','cjs','jsx','ts','tsx','php','phps','py','java','c','cc','cpp','cxx','h','hpp','cs','sql','sh','bash','bat','cmd','ps1','r','rb','go','rs','swift','kt','kts','lua','pl','vue','svelte','dart','asm','obj','scad','step','stp'] as $extension) {
            $meta=$policy->inspect($this->upload('درس.'.$extension,"Educational source text\n"));
            $this->assertSame(in_array($extension,['txt','csv'],true)?$extension:'bin',$meta['extension'],$extension);
            $this->assertFalse($policy->inline($meta['mime_type'],'درس.'.$extension));
        }
        foreach (['json','ipynb','gltf'] as $extension) $this->assertSame('bin',$policy->inspect($this->upload('data.'.$extension,'{"lesson":true}'))['extension']);
        foreach (['xml'=>'<?xml version="1.0"?><lesson/>','svg'=>'<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>',
            'html'=>'<!doctype html><script>alert(1)</script>','php'=>'<?php echo "educational source";','js'=>'alert("lesson");'] as $extension=>$text) {
            $file=$this->upload('example.'.$extension,$text);
            try { $this->assertSame('bin',$policy->inspect($file)['extension']); }
            catch (ValidationException $e) { $this->fail($extension.': '.(new \finfo(FILEINFO_MIME_TYPE))->file($file->getRealPath())); }
        }
        $this->assertSame('txt',$policy->inspect($this->upload('UTF16.txt',"\xff\xfeH\0i\0"))['extension']);
    }

    public function test_executable_spoofs_unknown_types_and_binary_disguised_as_text_are_rejected()
    {
        foreach (['bad.exe'=>"MZ\0".str_repeat('x',400),'fake.pdf'=>'<html>not a PDF</html>',
            'fake.mp4'=>'<?php echo 1;','fake.svg'=>'not svg','fake.zip'=>'not zip','fake.docx'=>'not Office',
            'binary.py'=>"\x7fELF\0".str_repeat('x',100),'nul.js'=>"a\0b",'unknown.xyz'=>'text'] as $name=>$bytes) $this->rejectFile($name,$bytes);
        foreach (array_keys(app(LessonContentFileTypes::class)->formats()) as $extension) $this->rejectFile('renamed.'.$extension,"MZ\0".str_repeat('x',400));
    }

    public function test_representative_binary_media_archives_fonts_and_design_formats()
    {
        $wav='RIFF'.pack('V',836).'WAVEfmt '.pack('VvvVVvv',16,1,1,8000,8000,1,8).'data'.pack('V',800).str_repeat("\x80",800);
        $samples=[
            'pdf'=>"%PDF-1.4\n1 0 obj\n<<>>\nendobj\n%%EOF",
            'png'=>base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+a2ioAAAAASUVORK5CYII='),
            'wav'=>$wav, 'gz'=>gzencode('Educational archive'),
            'ttf'=>"\0\x01\0\0".str_repeat("\0",64),
            'eps'=>"%!PS-Adobe-3.0 EPSF-3.0\n%%BoundingBox: 0 0 10 10\nshowpage\n",
            'dwg'=>'AC1027'.str_repeat("\0",128),
            'glb'=>'glTF'.pack('VV',2,12),
            'stl'=>str_repeat("\0",80).pack('V',1).str_repeat("\0",50),
        ];
        $policy=app(LessonContentFileTypes::class);
        foreach ($samples as $extension=>$bytes) {
            $file=$this->upload('fixture.'.$extension,$bytes);
            try { $meta=$policy->inspect($file); }
            catch(ValidationException $e) { $this->fail($extension.': '.(new \finfo(FILEINFO_MIME_TYPE))->file($file->getRealPath())); }
            $this->assertSame(in_array($extension,['pdf','png','wav'],true)?$extension:'bin',$meta['extension']);
            $this->assertSame(in_array($extension,['pdf','png','wav'],true),$policy->inline($meta['mime_type'],'fixture.'.$extension));
        }
    }

    public function test_office_macros_require_the_explicit_macro_extension_and_archives_are_not_extracted()
    {
        $file=$this->upload('lesson.docx',''); $zip=new \ZipArchive(); $zip->open($file->getRealPath(),\ZipArchive::OVERWRITE);
        $zip->addFromString('[Content_Types].xml','<Types/>'); $zip->addFromString('word/document.xml','<document/>'); $zip->close();
        $this->assertSame('docx',app(LessonContentFileTypes::class)->inspect($file)['extension']);
        $zip->open($file->getRealPath()); $zip->addFromString('word/vbaProject.bin','Macro fixture'); $zip->close();
        $this->rejectFile('wrong.docx',file_get_contents($file->getRealPath()));
        $macro=new UploadedFile($file->getRealPath(),'lesson.docm',null,UPLOAD_ERR_OK,true);
        $this->assertSame('bin',app(LessonContentFileTypes::class)->inspect($macro)['extension']);
        $zip->open($file->getRealPath()); $zip->addFromString('../escape.txt','Unsafe entry'); $zip->close();
        $this->rejectFile('unsafe.zip',file_get_contents($file->getRealPath()));
    }

    public function test_count_size_and_declared_count_boundaries_reject_before_storage_with_shared_effective_policy()
    {
        $policy=$this->limits(['file'=>2147483648,'post'=>2147483648,'count'=>20]); app()->instance(LessonContentLimits::class,$policy);
        $request=function($files,$count=null){return Request::create('/','POST',['name_addition'=>'Title','upload_token'=>(string)\Illuminate\Support\Str::uuid(),'attachment_count'=>$count??count($files)],[],['attachments'=>$files]);};
        $files=[]; for($i=0;$i<20;$i++)$files[]=$this->upload('lesson.txt','Lesson');
        $data=app(LessonContentInput::class)->read($request($files)); $this->assertCount(20,$data['files']);
        $files[]=$this->upload('extra.txt','Lesson');
        foreach ([$request($files),$request([$files[0]],2)] as $r) {
            try { app(LessonContentInput::class)->read($r); $this->fail('Accepted invalid batch'); }
            catch(ValidationException $e){$this->assertNotEmpty($e->errors());}
        }
        config(['lesson_content.max_file_bytes'=>5,'lesson_content.max_total_bytes'=>8]);
        try { app(LessonContentInput::class)->read($request([$this->upload('a.txt','12345'),$this->upload('b.txt','1234')]));$this->fail('Total overflow'); }
        catch(ValidationException $e){$this->assertSame([__('lesson_content.limit_total',['total'=>0])],$e->errors()['attachments']);}
    }
}
