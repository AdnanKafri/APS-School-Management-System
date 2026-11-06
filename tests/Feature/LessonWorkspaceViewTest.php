<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\View;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class LessonWorkspaceViewTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        config(['lesson_content.enabled'=>false]); // Render-only legacy cases must not inherit the local activation flag.
        View::share('errors',new \Illuminate\Support\ViewErrorBag());
        View::composer(['teachers2.layouts.app','students.layouts.app4'], function ($view) {
            $view->setPath(__DIR__.'/../Fixtures/lesson-workspace-layout.blade.php');
        });
    }

    private function data()
    {
        $lesson=(object)['id'=>409,'name'=>'اللغة العربية','books'=>[]];
        $room=(object)['id'=>132,'name'=>'الشعبة الأولى'];
        return ['lesson'=>$lesson,'room'=>$room,'room1'=>$room,'room_id'=>132,'class_id'=>2,
            'teacher'=>(object)['id'=>166], 'student'=>(object)['id'=>41],
            'lecture'=>(object)['id'=>4999,'name'=>'درس عربي طويل للاختبار','lesson'=>$lesson,'room'=>$room],
            'now'=>'2026-11-06 10:00:00', 'additions'=>collect(), 'quizes1'=>collect(), 'voices'=>collect(),
            'videos'=>collect(), 'tests'=>collect(), 'super_file'=>collect(), 'lecture_others'=>collect(),
            'lecture_tests'=>collect(), 'lecture_quizes'=>collect(), 'lecture_audios'=>collect(), 'lecture_videos'=>collect()];
    }

    private function dom($view, $data)
    {
        $html=view($view,$data)->render();
        $doc=new \DOMDocument(); libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8">'.$html); libxml_clear_errors();
        return [$html,new \DOMXPath($doc)];
    }

    public function test_all_teacher_and_student_panels_have_accessible_tabs_and_empty_states()
    {
        foreach (['teachers2.teacher_showcontent'=>6,'students.new_lecture_content'=>7] as $view=>$count) {
            [$html,$xp]=$this->dom($view,$this->data());
            $tabs=$xp->query('//ul[contains(@class,"lc-tabs")]//a');
            $this->assertCount($count,$tabs);
            $this->assertCount($count,$xp->query('//p[@class="lc-empty"]'));
            foreach ($tabs as $tab) $this->assertCount(1,$xp->query('//*[@id="'.substr($tab->getAttribute('href'),1).'"]'));
            $this->assertStringNotContainsString('ajax.googleapis.com/ajax/libs/jquery',$html);
            $this->assertStringNotContainsString('bootstrap/3.3',$html);
        }
    }

    public function test_student_workspace_css_loads_after_legacy_css_outside_the_document_title()
    {
        [$html,$xp]=$this->dom('students.new_lecture_content',$this->data());
        preg_match('~<title>(.*?)</title>~s',$html,$title);
        $this->assertSame('School',trim($title[1]));
        $links=$xp->query('//head/link[@rel="stylesheet" and contains(@href,"lesson-workspace.css")]');
        $this->assertCount(1,$links);
        $this->assertLessThan(strpos($html,'lesson-workspace.css'),strpos($html,'demo_1/showcontent_style.css'));
        $this->assertCount(1,$xp->query('//div[contains(@class,"main-panel")]/ul[@class="breadcrumbs"]'));
        $this->assertCount(1,$xp->query('//div[contains(@class,"main-panel")]/div[contains(@class,"content-wrapper")]'));
        $this->assertLessThan(strpos($html,'lesson-content-cards.css'),strpos($html,'lesson-workspace.css'));
    }

    public function test_student_files_are_initially_active_even_when_empty_and_card_links_remain_intact()
    {
        foreach ([0,1,3] as $count) {
            $data=$this->data();
            for ($i=0;$i<$count;$i++) {
                $data['lecture_others']->push((object)['name_addition'=>str_repeat('عنوان عربي طويل ',8).'<ملف>',
                    'addition'=>$i===1?null:'original/file-'.$i.'.pdf','addition_link'=>$i===1?'https://example.test/resource':null]);
            }
            [$html,$xp]=$this->dom('students.new_lecture_content',$data);
            $this->assertCount(1,$xp->query('//ul[contains(@class,"lc-tabs")]/li[contains(@class,"active")]/a[@href="#Section2"]'));
            $this->assertCount(1,$xp->query('//div[contains(concat(" ",normalize-space(@class)," ")," tab-pane ") and contains(concat(" ",normalize-space(@class)," ")," active ") and @id="Section2"]'));
            $this->assertCount(1,$xp->query('//div[contains(concat(" ",normalize-space(@class)," ")," tab-pane ") and contains(concat(" ",normalize-space(@class)," ")," active ")]'));
            foreach ($xp->query('//ul[contains(@class,"lc-tabs")]//a') as $tab) {
                $active=$tab->getAttribute('href')==='#Section2';
                $this->assertSame($active?'true':'false',$tab->getAttribute('aria-selected'));
                $this->assertSame($active?'0':'-1',$tab->getAttribute('tabindex'));
                $this->assertSame(substr($tab->getAttribute('href'),1),$tab->getAttribute('aria-controls'));
                $panel=$xp->query('//*[@id="'.$tab->getAttribute('aria-controls').'"]')->item(0);
                $this->assertSame($tab->getAttribute('id'),$panel->getAttribute('aria-labelledby'));
            }
            $actions=$xp->query('//*[@id="Section2"]//a[@class="slc-content-action"]');
            $this->assertCount($count,$actions);
            $this->assertCount($count?0:1,$xp->query('//*[@id="Section2"]/p[@class="lc-empty"]'));
            foreach ($actions as $i=>$action) {
                $this->assertSame($i===1?'https://example.test/resource':asset('storage/original/file-'.$i.'.pdf'),trim($action->getAttribute('href')));
                $this->assertCount(0,$xp->query('.//button',$action));
            }
            if ($count) $this->assertStringContainsString('&lt;ملف&gt;',$html);
        }
    }

    public function test_grouped_student_cards_keep_full_bidirectional_filenames_accessible_without_row_gutters()
    {
        $feature = $this->getMockBuilder(\App\Services\LessonContentFeature::class)->onlyMethods(['enabled'])->getMock();
        $feature->method('enabled')->willReturn(true);
        $this->app->instance(\App\Services\LessonContentFeature::class, $feature);
        foreach ([0,1,3] as $count) {
            $data = $this->data();
            $name = str_repeat('اسم عربي English.file.2026 ',6).'<ملف>.txt';
            for ($i=0;$i<$count;$i++) {
                $data['lecture_others']->push((object)[
                    'upload_request_hash'=>str_repeat('a',64), 'name_addition'=>'عنوان مجموعة '.$i,
                    'note'=>"تعليمات\n<script>plain text</script>", 'addition_link'=>null,
                    'privateAttachments'=>collect([(object)['id'=>101+$i,'original_name'=>$name]]),
                ]);
            }
            [$html,$xp] = $this->dom('students.new_lecture_content',$data);
            $this->assertCount($count,$xp->query('//*[@id="Section2"]//article[@class="box"]'));
            $this->assertCount($count,$xp->query('//details[@class="slc-attachment-file"]/summary'));
            $this->assertCount($count*2,$xp->query('//*[@id="Section2"]//a[contains(@href,"lesson-content/attachments/")]'));
            foreach ($xp->query('//details[@class="slc-attachment-file"]') as $details) {
                $summary = $xp->query('./summary/bdi',$details)->item(0);
                $full = $xp->query('./bdi[@class="slc-attachment-full"]',$details)->item(0);
                $this->assertSame($name,$summary->textContent);
                $this->assertSame($name,$summary->getAttribute('title'));
                $this->assertSame($name,$full->textContent);
                $this->assertSame('auto',$summary->getAttribute('dir'));
                $this->assertSame('auto',$full->getAttribute('dir'));
            }
            if ($count) {
                $this->assertStringContainsString('&lt;ملف&gt;',$html);
                $this->assertStringContainsString('&lt;script&gt;plain text&lt;/script&gt;',$html);
                $this->assertStringNotContainsString('<script>plain text</script>',$html);
            }
        }
    }

    public function test_teacher_breadcrumbs_inherit_the_mark_room_design_without_workspace_overrides()
    {
        $css=file_get_contents(public_path('assets/css/lesson-workspace.css'));
        $this->assertStringNotContainsString('.breadcrumbs',$css);
        $reference=file_get_contents(resource_path('views/teachers2/mark_room.blade.php'));
        preg_match('~<ul class="breadcrumbs"[^>]*>~',$reference,$opening);
        foreach (['teacher_lessons','teacher_showcontent','teacher_addcontent'] as $view) {
            $source=file_get_contents(resource_path('views/teachers2/'.$view.'.blade.php'));
            preg_match('~<ul class="breadcrumbs"[^>]*>~',$source,$actual);
            $this->assertSame(preg_replace('/\s+/',' ',$opening[0]),preg_replace('/\s+/',' ',$actual[0]));
            $this->assertStringContainsString('<li class="li">',$source);
        }
    }

    public function test_multiple_files_and_media_preserve_their_original_urls_and_order()
    {
        $data=$this->data();
        $data['additions']=collect([
            (object)['id'=>11,'addition'=>'original/one.pdf','addition_link'=>null,'extension'=>'pdf','name_addition'=>'ملف عربي طويل جداً & <اختبار>'],
            (object)['id'=>12,'addition'=>null,'addition_link'=>'https://example.test/two','extension'=>null,'name_addition'=>'Second file'],
        ]);
        $data['voices']=collect([(object)['id'=>13,'audio_file'=>'original/audio.mp3','audio_link'=>null,'name_audio'=>'Audio']]);
        $data['videos']=collect([(object)['id'=>14,'video'=>'original/video.mp4','video_link'=>null,'name_video'=>'Video']]);
        [$html,$xp]=$this->dom('teachers2.teacher_showcontent',$data);
        $this->assertStringContainsString('original/one.pdf',$html);
        $this->assertStringContainsString('https://example.test/two',$html);
        $this->assertStringContainsString('original/audio.mp3',$html);
        $this->assertStringContainsString('original/video.mp4',$html);
        $this->assertStringContainsString('&lt;اختبار&gt;',$html);
        $this->assertLessThan(strpos($html,'Second file'),strpos($html,'ملف عربي طويل'));
        $this->assertCount(2,$xp->query('//*[@id="Section1"]//*[contains(concat(" ",normalize-space(@class)," ")," card12 ")]'));

        $data['lesson']->books=[(object)['name_ar'=>'كتاب طويل','type'=>'link','value'=>'https://example.test/book']];
        $data['lecture_others']=collect([$data['additions'][0]]);
        $data['lecture_audios']=collect([(object)['audio_file'=>'original/audio.mp3','audio_link'=>null,'name_audio'=>'Audio','type_voice'=>'file']]);
        $data['lecture_videos']=collect([(object)['video'=>'original/video.mp4','video_link'=>null,'name_video'=>'Video','type_video'=>'file']]);
        [$html]=$this->dom('students.new_lecture_content',$data);
        foreach (['https://example.test/book','original/one.pdf','original/audio.mp3','original/video.mp4'] as $url) $this->assertStringContainsString($url,$html);
    }

    public function test_upload_forms_and_add_edit_modal_fields_keep_their_contract()
    {
        $data=$this->data(); $data['lecture_id']=$data['lecture'];
        [$html,$xp]=$this->dom('teachers2.teacher_addcontent',$data);
        $forms=$xp->query('//form[contains(@class,"lc-entry-form")]');
        $this->assertCount(4,$forms);
        foreach ($forms as $form) {
            $this->assertSame(route('dashboard.store_items'),$form->getAttribute('action'));
            $this->assertSame('post',$form->getAttribute('method'));
            $this->assertSame('multipart/form-data',$form->getAttribute('enctype'));
            foreach (['_token','teacher_id','lesson_id','class_id','room_id','lecture_id','type'] as $name) $this->assertCount(1,$xp->query('.//input[@name="'.$name.'"]',$form));
        }
        foreach (['addition','audio_file','video_in','test'] as $name) $this->assertCount(1,$xp->query('//input[@type="file" and @name="'.$name.'"]'));
        $data['lesson_id']=409; $data['class']=(object)['id'=>2]; $data['lectures']=collect();
        [$html,$xp]=$this->dom('teachers2.teacher_lessons',$data);
        foreach (['demoModal4','demoModal'] as $id) {
            $this->assertCount(1,$xp->query('//*[@id="'.$id.'"]'));
            foreach (['name','lecture_time','teacher_id','room_id','lesson_id','class_id'] as $name) $this->assertCount(1,$xp->query('//*[@id="'.$id.'"]//input[@name="'.$name.'"]'));
        }
        $this->assertCount(1,$xp->query('//form[@id="confirm4"]'));
        $this->assertCount(1,$xp->query('//form[@id="confirmEdit4"]'));
    }
}
