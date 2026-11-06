<?php

namespace Tests\Feature;

use App\GradebookEvent;
use App\GradebookTemplate;
use App\GradebookTemplateVersion;
use App\Services\Gradebook\GradebookTemplateService;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class GradebookTemplatesTest extends TestCase
{
    use \Tests\Concerns\GradebookTemplateFixtures;

    private $service;
    private $url = '/SMT/admin/gradebook/templates';

    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', DB::getDriverName());
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        DB::statement('PRAGMA foreign_keys = ON');
        $this->templateFixtureSchema();
        Storage::fake('local');
        $this->service = app(GradebookTemplateService::class);
        $this->actingAs(User::findOrFail(1));
        app()->setLocale('ar');
        View::composer('admin.layouts.v2', function ($view) { $view->setPath(base_path('tests/Fixtures/gradebook-layout.blade.php')); });
    }

    private function draft()
    {
        $template = $this->service->create(6,409,'قالب');
        return $this->service->save($template->id, $template->draft_revision, $this->templatePayload());
    }

    private function publish($template)
    {
        $preview = $this->service->preview($template->id);
        return $this->service->publish($template->id, $preview['revision'], $preview['preview_token'], 1);
    }

    private function rejects(callable $callback)
    {
        try { $callback(); $this->fail('Invalid operation accepted'); }
        catch (ValidationException $e) { $this->assertNotEmpty($e->errors()); }
    }

    public function test_admin_can_create_edit_preview_publish_and_read_using_real_routes()
    {
        $this->get($this->url)->assertOk()->assertSee(__('gradebook_templates.title'));
        $this->post($this->url,['year_id'=>6,'lesson_id'=>409,'name_ar'=>'قالب'])->assertRedirect();
        $template=GradebookTemplate::firstOrFail();
        $this->assertSame(1,(int)$template->created_by);
        $this->get($this->url.'/'.$template->id)->assertOk()->assertSee('gbt-components');
        $this->post($this->url.'/'.$template->id.'/draft',array_merge($this->templatePayload(),['revision'=>1,'created_by'=>2]))->assertRedirect();
        $this->get($this->url.'/'.$template->id.'/preview')->assertOk()->assertSee(__('gradebook_templates.structural'));
        $review=$this->service->preview($template->id);
        $this->assertSame(155,$review['total']);
        $this->post($this->url.'/'.$template->id.'/publish',[
            'revision'=>$review['revision'],'preview_token'=>$review['preview_token'],'confirmed'=>1,'published_by'=>2,
        ])->assertRedirect();
        $version=GradebookTemplateVersion::firstOrFail();
        $this->get($this->url.'/'.$template->id.'/versions/'.$version->id)->assertOk()->assertSee('155');
        $this->assertSame(1,(int)$version->published_by);
        $this->assertSame([1],GradebookEvent::pluck('actor_id')->map(function($id){return (int)$id;})->unique()->all());
        $this->assertNull($template->fresh()->draft_payload);
    }

    public function test_guest_teacher_student_and_officer_cannot_manage_templates()
    {
        $template=$this->draft();$preview=$this->service->preview($template->id);
        foreach([2,3,4] as $actor) {
            $this->actingAs(User::findOrFail($actor));
            $this->assertContains($this->postJson($this->url,['year_id'=>5,'lesson_id'=>410,'name_ar'=>'No'])->status(),[302,403]);
            $this->assertContains($this->postJson($this->url.'/'.$template->id.'/draft',array_merge($this->templatePayload(),['revision'=>2]))->status(),[302,403]);
            $this->assertContains($this->postJson($this->url.'/'.$template->id.'/publish',['revision'=>2,'preview_token'=>$preview['preview_token'],'confirmed'=>1])->status(),[302,403]);
            try{$this->service->create(5,410,'No');$this->fail('Service bypass');}catch(\Symfony\Component\HttpKernel\Exception\HttpException $e){$this->assertSame(403,$e->getStatusCode());}
        }
        auth()->logout();
        $this->getJson($this->url)->assertStatus(401);
        $this->assertSame(1,GradebookTemplate::count());$this->assertSame(0,GradebookTemplateVersion::count());
    }

    public function test_maxima_and_forged_component_identifiers_are_rejected_without_writes()
    {
        $template=$this->draft();$before=$template->fresh()->toJson();
        foreach([0,-1,'1.5',1.0,true,null,'1e3','01','2147483648',[]] as $maximum){
            $payload=$template->draft_payload;$payload['components'][0]['maximum']=$maximum;
            $this->rejects(function()use($template,$payload){$this->service->save($template->id,2,$payload);});
        }
        foreach(['not-a-uuid',(string)\Illuminate\Support\Str::uuid(),$template->draft_payload['components'][1]['id']] as $id){
            $payload=$template->draft_payload;$payload['components'][0]['id']=$id;
            $this->rejects(function()use($template,$payload){$this->service->save($template->id,2,$payload);});
        }
        $this->assertSame($before,$template->fresh()->toJson());
    }

    public function test_v1_v2_and_structural_diffs_preserve_identity_and_original_snapshot()
    {
        $template=$this->draft();$v1=$this->publish($template);$before=$v1->fresh()->getRawOriginal();
        $template=$this->service->startDraft($template->id,$template->fresh()->draft_revision,$v1->id);
        $payload=$template->draft_payload;$original=$payload['components'];
        $payload['components']=[$original[1],$original[0]];
        $payload['components'][0]['name_ar']='امتحان نهائي';$payload['components'][0]['maximum']=125;
        $payload['components'][0]['name_en']='Final examination';
        $template=$this->service->save($template->id,$template->draft_revision,$payload);
        $review=$this->service->preview($template->id);
        $this->assertCount(1,$review['changes']['renamed']);$this->assertCount(1,$review['changes']['maximum_changed']);
        $this->assertCount(2,$review['changes']['reordered']);$this->assertEmpty($review['changes']['added']);
        $this->assertSame($original[1]['id'],$review['payload']['definition']['components'][0]['id']);
        $this->get($this->url.'/'.$template->id.'/preview')->assertOk()->assertSee('Final examination');
        $v2=$this->publish($template);$this->assertSame(2,$v2->number);
        $this->assertSame($before,$v1->fresh()->getRawOriginal());
        $template=$this->service->startDraft($template->id,$template->fresh()->draft_revision,$v2->id);
        $payload=$template->draft_payload;array_pop($payload['components']);
        $payload['components'][]=['id'=>'','name_ar'=>'نشاط','maximum'=>9];
        $template=$this->service->save($template->id,$template->draft_revision,$payload);
        $review=$this->service->preview($template->id);
        $this->assertCount(1,$review['changes']['added']);$this->assertCount(1,$review['changes']['removed']);
        $this->assertNotSame($original[0]['id'],$review['changes']['added'][0]['id']);
    }

    public function test_stale_edits_and_stale_previews_do_not_overwrite_changes()
    {
        $template=$this->draft();$review=$this->service->preview($template->id);
        $saved=$this->service->save($template->id,2,$template->draft_payload);
        $this->rejects(function()use($template){$this->service->save($template->id,2,$template->draft_payload);});
        $this->rejects(function()use($template,$review){$this->service->publish($template->id,2,$review['preview_token'],1);});
        $this->rejects(function()use($template,$saved,$review){$this->service->publish($template->id,$saved->draft_revision,$review['preview_token'],1);});
        $this->assertSame(0,GradebookTemplateVersion::count());$this->assertSame(3,$template->fresh()->draft_revision);
    }

    public function test_duplicate_publish_is_idempotent_even_after_a_new_draft_exists()
    {
        $template=$this->draft();$review=$this->service->preview($template->id);$v1=$this->publish($template);
        $draft=$this->service->startDraft($template->id,$template->fresh()->draft_revision,$v1->id);
        $retry=$this->service->publish($template->id,$review['revision'],$review['preview_token'],1);
        $this->assertSame($v1->id,$retry->id);$this->assertSame(1,GradebookTemplateVersion::count());
        $this->assertSame(1,GradebookEvent::where('action','version_published')->count());
        $this->assertSame($draft->draft_payload,$template->fresh()->draft_payload);
    }

    public function test_audit_failure_rolls_back_the_entire_publication()
    {
        $template=$this->draft();$before=$template->fresh()->toJson();$events=GradebookEvent::count();
        GradebookEvent::creating(function($event){if($event->action==='version_published')throw new \RuntimeException('Isolated audit failure');});
        try{$this->publish($template);$this->fail('Failure not raised');}catch(\RuntimeException $e){$this->assertSame('Isolated audit failure',$e->getMessage());}
        $this->assertSame(0,GradebookTemplateVersion::count());$this->assertSame($events,GradebookEvent::count());
        $this->assertSame($before,$template->fresh()->toJson());
    }

    public function test_database_and_model_guards_reject_mutating_published_versions_and_events()
    {
        $version=$this->publish($this->draft());$before=$version->fresh()->getRawOriginal();
        try{$version->forceFill(['content_hash'=>str_repeat('0',64)])->save();$this->fail('Model update accepted');}catch(\LogicException $e){$this->assertStringContainsString('immutable',$e->getMessage());}
        foreach(['gradebook_template_versions','gradebook_events'] as $table){
            foreach(['update','delete'] as $operation){
                try{if($operation==='delete')DB::table($table)->delete();else DB::table($table)->update(['id'=>1]);$this->fail('Raw mutation accepted');}
                catch(\Illuminate\Database\QueryException $e){$this->assertStringContainsString('immutable',$e->getMessage());}
            }
        }
        $this->assertSame($before,$version->fresh()->getRawOriginal());
        try{(new \CreateGradebookTemplateFoundation())->down();$this->fail('History rollback accepted');}catch(\RuntimeException $e){$this->assertStringContainsString('preservation',$e->getMessage());}
    }

    public function test_scope_and_cross_template_version_tampering_are_rejected()
    {
        $a=$this->draft();$v1=$this->publish($a);$b=$this->service->create(5,410,'Other');
        $this->rejects(function(){$this->service->create(6,409,'Conflict');});
        $this->rejects(function(){$this->service->create(999,410,'Unknown year');});
        $this->rejects(function()use($b){$payload=$this->templatePayload();$payload['year_id']=6;$this->service->save($b->id,1,$payload);});
        $this->get($this->url.'/'.$b->id.'/versions/'.$v1->id)->assertNotFound();
        $b=$this->service->discard($b->id,1,'Fixture discard');
        $this->postJson($this->url.'/'.$b->id.'/start',['revision'=>$b->draft_revision,'version_id'=>$v1->id])->assertNotFound();
        $a=$this->service->startDraft($a->id,$a->fresh()->draft_revision,$v1->id);
        DB::table('lessons')->where('id',409)->update(['class_id'=>3]);
        $this->rejects(function()use($a){$this->service->preview($a->id);});
    }

    public function test_discard_and_duplicate_keep_history_and_allocate_independent_ids()
    {
        $template=$this->draft();$version=$this->publish($template);
        $copy=$this->service->duplicate($version->id,5,410,'Copy');
        $this->assertSame([],array_intersect(array_column($version->payload['definition']['components'],'id'),array_column($copy->draft_payload['components'],'id')));
        $this->assertSame(155,$this->service->preview($copy->id)['total']);
        $saved=$copy->draft_payload;$copy=$this->service->discard($copy->id,$copy->draft_revision,'No longer needed');
        $event=$copy->events()->where('action','draft_discarded')->firstOrFail();
        $this->assertSame($saved,$event->metadata['discarded_payload']);$this->assertNull($copy->draft_payload);
        $this->assertSame(1,GradebookTemplateVersion::count());
        $this->assertNotNull($this->service->startDraft($copy->id,$copy->draft_revision)->draft_payload);
    }

    public function test_publication_does_not_touch_legacy_files_results_or_equivalence()
    {
        foreach(['exam_result2','exam_result','students_marks','assessment_equivalence_members'] as $table){
            Schema::create($table,function($t){$t->increments('id');$t->text('evidence');});
            DB::table($table)->insert(['evidence'=>'original decimal 17.5 / original context']);
        }
        Storage::put('gradebook/409_6.json','{"components":[]}');Storage::put('gradebook_status/2_20.json','{"status":"LOCKED"}');
        $before=[];foreach(['exam_result2','exam_result','students_marks','assessment_equivalence_members'] as $table)$before[$table]=DB::table($table)->get()->toJson();
        $this->publish($this->draft());
        foreach($before as $table=>$json)$this->assertSame($json,DB::table($table)->get()->toJson());
        $this->assertSame('{"components":[]}',Storage::get('gradebook/409_6.json'));
        $this->assertSame('{"status":"LOCKED"}',Storage::get('gradebook_status/2_20.json'));
        $this->assertFalse(Schema::hasTable('gradebook_applications'));
    }

    public function test_csrf_and_explicit_confirmation_are_required()
    {
        $this->app->bind(\App\Http\Middleware\VerifyCsrfToken::class,function($app){
            return new class($app,$app['encrypter']) extends \App\Http\Middleware\VerifyCsrfToken {protected function runningUnitTests(){return false;}};
        });
        $this->postJson($this->url,['year_id'=>6,'lesson_id'=>409,'name_ar'=>'Blocked'])->assertStatus(419);
        $this->assertSame(0,GradebookTemplate::count());
        $template=$this->draft();$preview=$this->service->preview($template->id);
        $this->rejects(function()use($template,$preview){$this->service->publish($template->id,2,$preview['preview_token'],false);});
        $this->assertSame(0,GradebookTemplateVersion::count());
    }

    public function test_missing_or_incomplete_schema_fails_closed_without_touching_legacy_tables()
    {
        DB::unprepared('DROP TRIGGER gb_version_update_immutable');
        $this->assertFalse($this->service->available());
        $this->get($this->url)->assertOk()->assertSee(__('gradebook_templates.unavailable'));
        $this->postJson($this->url,['year_id'=>6,'lesson_id'=>409,'name_ar'=>'Blocked'])->assertStatus(503);
        (new \CreateGradebookTemplateFoundation())->down();
        $this->assertFalse($this->service->available());
        $this->get($this->url)->assertOk()->assertSee(__('gradebook_templates.unavailable'));
        (new \CreateGradebookTemplateFoundation())->up();
        $this->assertTrue($this->service->available());
        $this->assertSame(4,DB::table('users')->count());
    }

    public function test_context_navigation_defaults_to_current_year_and_filters_subjects_by_class()
    {
        $this->get($this->url)->assertOk()->assertViewHas('year',function($year){return (int)$year->id===6;})
            ->assertViewHas('subject',null)->assertSee('Grade 2')->assertDontSee('name="lesson_id"',false);
        $this->get($this->url.'?year_id=6&class_id=2')->assertOk()->assertSee('Math')->assertDontSee('Science')
            ->assertViewHas('subjects',function($subjects){return $subjects->pluck('id')->map(function($id){return (int)$id;})->all()===[409];});
        $this->get($this->url.'?year_id=6&class_id=3')->assertOk()->assertSee('Science')->assertDontSee('Math');
        $this->get($this->url.'?year_id=6&class_id=2&lesson_id=409')->assertOk()->assertSee('name="lesson_id" value="409"',false)
            ->assertSee(route('admin.gradebook.settings.edit',409),false);
        DB::table('classes')->insert(['id'=>4,'name'=>'No subjects']);
        $this->get($this->url.'?year_id=6&class_id=4')->assertOk()->assertSee(__('gradebook_templates.no_subjects'));
        $this->assertSame(0,GradebookTemplate::count());
    }

    public function test_explicit_year_is_preserved_and_missing_or_ambiguous_current_year_is_never_guessed()
    {
        $this->get($this->url.'?year_id=5&class_id=2&lesson_id=409')->assertOk()
            ->assertViewHas('year',function($year){return (int)$year->id===5;})
            ->assertDontSee(route('admin.gradebook.settings.edit',409),false);
        DB::table('years')->update(['current_year'=>0]);
        $this->get($this->url)->assertOk()->assertViewHas('year',null)->assertSee(__('gradebook_templates.year_unresolved'));
        DB::table('years')->update(['current_year'=>1]);
        $this->get($this->url)->assertOk()->assertViewHas('year',null)->assertViewHas('classes',null);
        $this->get($this->url.'?year_id=6&class_id=2')->assertOk()->assertSee('Math')->assertViewHas('currentYear',null);
        $this->getJson($this->url.'?year_id=999')->assertStatus(422);
    }

    public function test_context_create_validates_class_subject_pair_and_reopens_existing_template_without_writes()
    {
        $this->getJson($this->url.'?year_id=6&class_id=3&lesson_id=409')->assertStatus(422);
        $this->postJson($this->url,['year_id'=>6,'class_id'=>3,'lesson_id'=>409,'name_ar'=>'Wrong'])->assertStatus(422);
        $this->postJson($this->url,['year_id'=>6,'class_id'=>2,'lesson_id'=>409,'name_ar'=>'Valid'])->assertRedirect();
        $template=GradebookTemplate::firstOrFail();$before=$template->getRawOriginal();$events=GradebookEvent::count();
        $this->get($this->url.'?year_id=6&class_id=2&lesson_id=409')
            ->assertRedirect(route('admin.gradebook.templates.show',$template->id));
        $this->post($this->url,['year_id'=>6,'class_id'=>2,'lesson_id'=>409,'name_ar'=>'Must not replace'])
            ->assertRedirect(route('admin.gradebook.templates.show',$template->id));
        $this->assertSame(1,GradebookTemplate::count());$this->assertSame($events,GradebookEvent::count());
        $this->assertSame($before,$template->fresh()->getRawOriginal());
    }

    public function test_duplicate_follows_the_same_context_navigation_and_preserves_source_version()
    {
        $template=$this->draft();$version=$this->publish($template);$before=$version->fresh()->getRawOriginal();
        $this->get($this->url.'/'.$template->id)->assertOk()->assertSee(__('gradebook_templates.choose_destination'));
        $context='?year_id=5&source_version_id='.$version->id.'&class_id=3';
        $this->get($this->url.$context)->assertOk()->assertSee('Science')->assertDontSee('Math');
        $destination=route('admin.gradebook.templates.duplicate',[$template->id,$version->id]);
        $this->get($this->url.$context.'&lesson_id=410')->assertOk()->assertSee($destination,false)
            ->assertSee('name="class_id" value="3"',false);
        $this->postJson($destination,['year_id'=>5,'class_id'=>2,'lesson_id'=>410,'name_ar'=>'Bad'])->assertStatus(422);
        $this->post($destination,['year_id'=>5,'class_id'=>3,'lesson_id'=>410,'name_ar'=>'Copy'])->assertRedirect();
        $copy=GradebookTemplate::where('year_id',5)->where('lesson_id',410)->firstOrFail();
        $this->assertSame(3,(int)$copy->class_id);
        $this->assertSame([],array_intersect(array_column($version->payload['definition']['components'],'id'),array_column($copy->draft_payload['components'],'id')));
        $this->assertSame($before,$version->fresh()->getRawOriginal());
        $this->assertFalse(Schema::hasTable('gradebook_applications'));
    }

    public function test_template_navigation_uses_immutable_class_context_and_both_localizations_resolve()
    {
        $template=$this->draft();
        DB::table('lessons')->where('id',409)->update(['class_id'=>3]);
        $this->get($this->url.'/'.$template->id)->assertOk()->assertViewHas('grade',function($grade){return (int)$grade->id===2;})
            ->assertDontSee(route('admin.gradebook.settings.edit',409),false);
        app()->setLocale('en');
        $this->get($this->url)->assertOk()->assertSee('Choose class')->assertDontSee('gradebook_templates.');
    }
}
