<?php

namespace Tests\Feature;

use App\User;
use App\Services\Gradebook\GradebookTemplateService;
use App\Services\GradebookConfigService;
use App\Services\GradebookReadService;
use App\Services\GradebookStatusService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Real V2 parent and partials, not the legacy layout fixture. Synthetic data only.
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class GradebookAdminV2Test extends TestCase
{
    use \Tests\Concerns\TimetableFixtures;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', DB::getDriverName());
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        DB::connection()->getPdo()->sqliteCreateCollation('utf8_unicode_ci', 'strcmp');
        Storage::fake('local');
        config(['filesystems.default'=>'local']);
        app()->setLocale('ar');
        foreach (json_decode(file_get_contents(base_path('tests/Fixtures/gradebook-schema.json')), true) as $table=>$columns) {
            Schema::create($table, function (Blueprint $t) use ($columns) {
                foreach ($columns as $column) {
                    if ($column['name'] === 'id') $t->increments('id');
                    elseif (preg_match('/^(tiny|small|medium|big)?int/', $column['type'])) $t->integer($column['name'])->nullable();
                    else $t->text($column['name'])->nullable();
                }
            });
        }
        Schema::create('school_data', function (Blueprint $t) {
            $t->increments('id'); $t->string('name'); $t->string('name_en');
        });
        DB::table('school_data')->insert(['name'=>'مدرسة الاختبار', 'name_en'=>'Fixture School']);
        DB::table('years')->insert([['id'=>5,'name'=>'2025/2026','current_year'=>0], ['id'=>6,'name'=>'2026/2027','current_year'=>1]]);
        DB::table('term_years')->insert([
            ['id'=>17,'year_id'=>5,'term'=>'فصل قديم','type'=>1,'current_term'=>1],
            ['id'=>20,'year_id'=>6,'term'=>'فصل أول','type'=>1,'current_term'=>1],
            ['id'=>21,'year_id'=>6,'term'=>'فصل ثان','type'=>2,'current_term'=>0],
            ['id'=>22,'year_id'=>6,'term'=>'فصل أول مستقل','type'=>1,'current_term'=>0],
        ]);
        DB::table('classes')->insert([['id'=>2,'name'=>'الصف الثاني'],['id'=>3,'name'=>'صف بلا شعب']]);
        foreach ([132,133] as $id) DB::table('rooms')->insert(['id'=>$id,'year_id'=>6,'class_id'=>2,'name'=>'شعبة '.$id]);
        DB::table('rooms')->insert(['id'=>93,'year_id'=>5,'class_id'=>2,'name'=>'شعبة قديمة']);
        DB::table('lessons')->insert(['id'=>409,'class_id'=>2,'name'=>'English / اللغة الأجنبية','max_mark'=>100]);
        DB::table('teachers')->insert(['id'=>166,'first_name'=>'معلم','last_name'=>'اختبار']);
        $this->createTimetableSchema();
        $this->timetablePeriod(166,132,409,6);
        DB::table('teacher_room_lesson')->insert(['teacher_id'=>166,'room_id'=>132,'lesson_id'=>409,'class_id'=>2,'year_id'=>6]);
        foreach ([41,42] as $id) {
            DB::table('students')->insert(['id'=>$id,'first_name'=>'عبداللطيف عبدالله الحمداني العنزي','last_name'=>'طالب '.$id,'lifecycle_status'=>'active']);
            DB::table('room_student')->insert(['student_id'=>$id,'room_id'=>132,'year_id'=>6]);
            DB::table('student_academic_placements')->insert(['student_id'=>$id,'room_id'=>132,'class_id'=>2,'year_id'=>6,'status'=>'active','effective_from'=>now()->subDay()]);
        }
        DB::table('users')->insert(['id'=>1,'name'=>'Fixture Admin','email'=>'admin@example.test','password'=>'unused','type'=>2]);
        $this->admin = User::findOrFail(1);
        $this->actingAs($this->admin);
        require_once base_path('database/migrations/2026_10_29_000001_create_gradebook_template_foundation.php');
        (new \CreateGradebookTemplateFoundation())->up();
        Schema::create('assessment_equivalence_members', function (Blueprint $t) {
            $t->increments('id'); $t->integer('exam_id');
        });
    }

    private function pages()
    {
        return [
            '/SMT/admin/gradebook'=>'admin.gradebook.index',
            '/SMT/admin/gradebook/settings'=>'admin.gradebook.settings.index',
            '/SMT/admin/gradebook/settings/rooms/2'=>'admin.gradebook.settings.rooms',
            '/SMT/admin/gradebook/settings/subjects/132'=>'admin.gradebook.settings.subjects',
            '/SMT/admin/gradebook/settings/edit/409'=>'admin.gradebook.settings.edit_json',
            '/SMT/admin/gradebook/view/options'=>'admin.gradebook.view_options',
            '/SMT/admin/gradebook/view/subject/classes'=>'admin.gradebook.view_classes',
            '/SMT/admin/gradebook/view/subject/rooms/2'=>'admin.gradebook.view_rooms',
            '/SMT/admin/gradebook/view/subject/subjects/132'=>'admin.gradebook.view_subjects',
            '/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=409'=>'admin.gradebook.view_by_subject_corrected',
            '/SMT/admin/gradebook/view/student/classes'=>'admin.gradebook.view_classes_student',
            '/SMT/admin/gradebook/view/student/rooms/2'=>'admin.gradebook.view_rooms_student',
            '/SMT/admin/gradebook/view/student/students/132'=>'admin.gradebook.view_students',
            '/SMT/admin/gradebook/view/student/card?student_id=41'=>'admin.gradebook.view_by_student',
            '/SMT/admin/gradebook/equivalence?year_id=6&lesson_id=409'=>'admin.gradebook.equivalence',
        ];
    }

    private function assertShell($response, $ordinary = true)
    {
        $response->assertOk()->assertSee('gradebook-admin-v2.css')->assertSee('class="v2-sidebar"',false)
            ->assertSee('class="v2-navbar"',false)->assertSee('class="gb-v2"',false)
            ->assertDontSee('Sunrise-IT')->assertDontSee('gradebook_ui.');
        $html = $response->getContent();
        $this->assertSame(1, substr_count($html, 'id="v2-shell"'));
        $this->assertSame(1, substr_count($html, 'id="v2-sidebar-toggle"'));
        $this->assertSame(1, substr_count($html, 'plugins/common/common.min.js'));
        $this->assertSame(1, substr_count($html, 'class="v2-menu-link active"'));
        if ($ordinary) $response->assertDontSee('/SMT/admin/gradebook/templates',false);
        $dom = new \DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        foreach ($dom->getElementsByTagName('a') as $a) {
            $url = $a->getAttribute('href');
            if (strpos($url,'/SMT/admin/gradebook') === false) continue;
            $route = app('router')->getRoutes()->match(Request::create($url));
            $this->assertStringStartsWith('admin.gradebook.', $route->getName());
            $this->assertNotContains(null, $route->parameters());
        }
        foreach (['link'=>'href', 'script'=>'src'] as $tag=>$attribute) {
            foreach ($dom->getElementsByTagName($tag) as $element) {
                $path=parse_url($element->getAttribute($attribute),PHP_URL_PATH);
                // The unchanged global shell's missing /images/favicon.png is deferred;
                // this feature owns neither that reference nor the global brand assets.
                if (strpos((string)$path,'/assets/') === 0) {
                    $this->assertFileExists(public_path(ltrim($path,'/')));
                }
            }
        }
    }

    public function test_every_operational_get_uses_real_v2_shell_and_valid_links_without_writes()
    {
        GradebookConfigService::saveConfig(409,6,GradebookConfigService::getDefaults()->map(function($c){return (array)$c;})->all());
        GradebookStatusService::setStatus(2,20,'OPEN');
        $tables = array_keys(json_decode(file_get_contents(base_path('tests/Fixtures/gradebook-schema.json')),true));
        $tables = array_merge($tables,['gradebook_templates','gradebook_template_versions','gradebook_events']);
        $before = [];
        foreach ($tables as $t) $before[$t] = DB::table($t)->orderBy('id')->get()->toJson();
        $files = [];
        foreach (Storage::allFiles() as $file) $files[$file] = Storage::get($file);
        foreach ($this->pages() as $url=>$view) {
            $response = $this->get($url)->assertViewIs($view);
            $this->assertShell($response);
        }
        foreach ($before as $t=>$rows) $this->assertSame($rows,DB::table($t)->orderBy('id')->get()->toJson(),$t);
        foreach ($files as $file=>$bytes) $this->assertSame($bytes,Storage::get($file),$file);
    }

    public function test_distribution_fields_payload_errors_and_explicit_maximum_stay_compatible()
    {
        $components = [['id'=>'legacy_homework','name'=>'مذاكرات','weight'=>30,'data_source'=>'LEGACY_HOMEWORK','sort_order'=>1,'max_mark'=>40],
            ['id'=>'dynamic_a','name'=>'مشروع','weight'=>20,'data_source'=>100,'sort_order'=>2]];
        GradebookConfigService::saveConfig(409,6,$components);
        $response = $this->get('/SMT/admin/gradebook/settings/edit/409');
        $this->assertShell($response);
        foreach (['id','data_source','name','weight'] as $field) $response->assertSee('name="components[0]['.$field.']"',false);
        $response->assertSee('value="legacy_homework"',false)->assertSee('id="componentsBody"',false)->assertSee('id="addRowBtn"',false)->assertSee('id="saveBtn"',false);
        $this->post('/SMT/admin/gradebook/settings/update/409',['components'=>$components])->assertRedirect()->assertSessionHasNoErrors();
        $stored = GradebookConfigService::getConfig(409,6);
        $this->assertSame(40,$stored->first()->max_mark);
        $this->assertSame('legacy_homework',$stored->first()->id);
        $this->assertSame(100,$stored->last()->data_source);
        $bad=$components; $bad[0]['weight']=101;
        $bytes=Storage::get('gradebook/409_6.json');
        $this->from('/SMT/admin/gradebook/settings/edit/409')->post('/SMT/admin/gradebook/settings/update/409',['components'=>$bad])->assertSessionHasErrors('components.0.weight');
        $this->get('/SMT/admin/gradebook/settings/edit/409')->assertOk()->assertSee('role="alert"',false)->assertSee('value="101"',false);
        $this->assertSame($bytes,Storage::get('gradebook/409_6.json'));
    }

    public function test_exact_terms_original_ids_decimal_zero_and_status_action_survive_the_shell_change()
    {
        foreach ([20=>'12.5',21=>'0',22=>'18.75'] as $term=>$mark) {
            $id=DB::table('exams2')->insertGetId(['class_id'=>2,'room_id'=>132,'lesson_id'=>409,'term_id'=>$term,'type'=>2,'name'=>'Assessment '.$term,'mark'=>30]);
            DB::table('exam_result2')->insert(['exam_id'=>$id,'user_id'=>41,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'term_id'=>$term,'result'=>$mark,'status'=>1]);
        }
        $before=app(GradebookReadService::class)->read(\App\Room::find(132),\App\Lesson::find(409),[41,42]);
        $response=$this->get('/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=409');
        $this->assertShell($response);
        foreach (['Assessment 20','Assessment 21','Assessment 22','12.5','18.75','data-assessment="exams2:'] as $text) $response->assertSee($text,false);
        $this->assertSame([20,21,22],$before['terms']->pluck('id')->all());
        $this->assertEquals(0,$before['marks'][41][21]['legacy_homework']);
        $this->assertNull($before['marks'][42][21]['total']);
        $this->postJson('/gradebook/status',['class_id'=>2,'term_id'=>20,'status'=>'OPEN'])->assertOk()->assertJson(['status'=>'OPEN']);
        $this->get('/SMT/admin/gradebook/view/subject/subjects/132')->assertOk()->assertSee('id="statusToggle"',false)->assertSee('data-accepted="OPEN"',false);
        $this->postJson('/gradebook/status',['class_id'=>2,'term_id'=>17,'status'=>'OPEN'])->assertStatus(422);
        $after=app(GradebookReadService::class)->read(\App\Room::find(132),\App\Lesson::find(409),[41,42]);
        $this->assertEquals($before,$after);
        $this->get('/SMT/admin/gradebook/view/student/card?student_id=41')->assertOk()
            ->assertSee(__('gradebook_ux.result_notice'))->assertDontSee('>ناجح</span>',false)->assertDontSee('>راسب</span>',false);
    }

    public function test_operational_settings_expose_existing_class_actual_term_status_and_default_explanations()
    {
        $url = '/SMT/admin/gradebook/settings';
        $this->get($url)->assertOk()->assertSee('id="gradebook-status-2"',false)
            ->assertSee(__('gradebook_ux.lock_scope'))->assertSee('toggleGradebookStatus(2, 20, this)',false)
            ->assertSee('2026/2027 / '.DB::table('term_years')->where('id',20)->value('term'));
        $this->postJson('/gradebook/status',['class_id'=>2,'term_id'=>20,'status'=>'OPEN'])->assertOk();
        $this->get($url)->assertOk()->assertSee('data-accepted="OPEN"',false);
        $this->assertSame('LOCKED',GradebookStatusService::getStatus(2,21));
        $this->postJson('/gradebook/status',['class_id'=>2,'term_id'=>17,'status'=>'OPEN'])->assertStatus(422);
        $edit = '/SMT/admin/gradebook/settings/edit/409';
        DB::table('lessons')->where('id',409)->update(['min_mark'=>41]);
        $this->get($edit)->assertOk()->assertSee(__('gradebook_ux.defaults'))->assertSee(__('gradebook_ux.stored_minimum'));
        Storage::assertMissing('gradebook/409_6.json');
        Storage::put('gradebook/409_6.json','invalid json');
        $this->get($edit)->assertOk()->assertSee(__('gradebook_ux.invalid_config'));
        $this->assertSame('invalid json',Storage::get('gradebook/409_6.json'));
        Storage::put('gradebook/409_6.json',json_encode(['components'=>[
            ['id'=>'independent','name'=>'Independent maximum','data_source'=>100,'max_mark'=>42]
        ]]));
        $this->get($edit)->assertOk()->assertSee('value="0"',false)->assertDontSee('value="42"',false)
            ->assertSee(__('gradebook_ux.explicit_maximum'));
        DB::table('term_years')->where('year_id',6)->update(['current_term'=>0]);
        $this->get($url)->assertOk()->assertSee(__('gradebook.term_missing'))->assertDontSee('id="gradebook-status-2"',false);
    }

    public function test_direct_template_workflow_is_preserved_and_renders_real_v2()
    {
        $service=app(GradebookTemplateService::class);
        $this->assertShell($this->get('/SMT/admin/gradebook/templates'),false);
        $template=$service->create(6,409,'تعريف محفوظ');
        $template=$service->save($template->id,1,['name_ar'=>'تعريف محفوظ','components'=>[['id'=>'','name_ar'=>'تقييم','maximum'=>25]]]);
        $this->assertShell($this->get('/SMT/admin/gradebook/templates/'.$template->id),false);
        $this->assertShell($this->get('/SMT/admin/gradebook/templates/'.$template->id.'/preview'),false);
        $review=$service->preview($template->id);
        $version=$service->publish($template->id,2,$review['preview_token'],1);
        $this->assertShell($this->get('/SMT/admin/gradebook/templates/'.$template->id.'/versions/'.$version->id),false);
        $this->assertFalse(Storage::exists('gradebook/409_6.json'));
        $this->assertSame(1,\App\GradebookTemplateVersion::count());
    }

    public function test_empty_context_pagination_locale_and_permission_boundaries()
    {
        $this->get('/SMT/admin/gradebook/settings/rooms/3')->assertOk()->assertSee(__('gradebook_ui.empty'));
        DB::table('term_years')->where('year_id',6)->update(['current_term'=>0]);
        $this->get('/SMT/admin/gradebook/view/subject/subjects/132')->assertOk()->assertSee(__('gradebook.term_missing'))->assertDontSee('id="statusToggle"',false);
        for ($i=10;$i<24;$i++) DB::table('classes')->insert(['id'=>$i,'name'=>'Class '.$i]);
        $this->get('/SMT/admin/gradebook/settings')->assertOk()->assertSee('page=2',false);
        $this->get('/SMT/admin/gradebook/settings?page=2')->assertOk()->assertDontSee('/settings/rooms/2"',false);
        app()->setLocale('en');
        foreach ($this->pages() as $url=>$view) $this->get($url)->assertOk()->assertSee('<html lang="en" dir="ltr">',false)->assertDontSee('gradebook_ui.');
        DB::table('users')->insert(['id'=>2,'name'=>'Officer','email'=>'officer@example.test','password'=>'unused','type'=>8,'complaint_officer_active'=>1]);
        $this->actingAs(User::find(2));
        foreach (array_keys($this->pages()) as $url) $this->get($url)->assertForbidden();
        $this->get('/SMT/admin/gradebook/templates')->assertForbidden();
    }

    public function test_class_navigation_has_no_per_row_context_or_template_queries()
    {
        DB::enableQueryLog();
        $this->get('/SMT/admin/gradebook/settings')->assertOk();
        $small=DB::getQueryLog();
        for ($i=10;$i<24;$i++) DB::table('classes')->insert(['id'=>$i,'name'=>'Class '.$i]);
        DB::flushQueryLog();
        $this->get('/SMT/admin/gradebook/settings')->assertOk();
        $large=DB::getQueryLog();
        DB::disableQueryLog();
        $this->assertSame(count($small),count($large));
        foreach ($large as $query) $this->assertStringNotContainsString('gradebook_template',$query['query']);
    }

    public function test_navigation_keeps_current_year_class_section_and_subject_parameters()
    {
        foreach (['settings/rooms/2'=>'admin.gradebook.settings.subjects',
            'view/subject/rooms/2'=>'admin.gradebook.view_subjects',
            'view/student/rooms/2'=>'admin.gradebook.view_students'] as $path=>$destination) {
            $this->get('/SMT/admin/gradebook/'.$path)->assertOk()
                ->assertSee(route($destination,132),false)->assertSee(route($destination,133),false)
                ->assertDontSee(route($destination,93),false);
        }
        $this->get('/SMT/admin/gradebook/settings/subjects/132')->assertOk()
            ->assertSee(route('admin.gradebook.settings.edit',409),false)->assertSee('معلم اختبار');
        $this->get('/SMT/admin/gradebook/view/subject/subjects/132')->assertOk()
            ->assertSee(route('admin.gradebook.view_grid_simple',['room_id'=>132,'subject_id'=>409]));
        $this->get('/SMT/admin/gradebook/view/student/students/132')->assertOk()
            ->assertSee(route('admin.gradebook.view_student_card',['student_id'=>41]),false)
            ->assertSee(route('admin.gradebook.view_student_card',['student_id'=>42]),false);
        $this->get('/SMT/admin/gradebook/settings/subjects/93')->assertNotFound();
    }

    public function test_unification_component_configuration_empty_retained_sources_revision_and_order()
    {
        $url = '/SMT/admin/gradebook/settings/update/409';
        $edit = '/SMT/admin/gradebook/settings/edit/409';
        $this->get($edit)->assertOk()->assertSee('id="componentDialog"',false)->assertSee('gradebook-component-editor.js');
        $this->post($url,['_components_present'=>'1','_configuration_revision'=>'missing'])->assertRedirect()->assertSessionHasNoErrors();
        $this->assertCount(0,GradebookConfigService::getConfig(409,6));
        $rows = [['id'=>'','name'=>'شفهي مستقل','weight'=>20,'data_source'=>''],['id'=>'','name'=>'وظائف مستقلة','weight'=>30,'data_source'=>'']];
        $hash = hash('sha256',Storage::get('gradebook/409_6.json'));
        $this->post($url,['components'=>$rows,'_configuration_revision'=>$hash])->assertRedirect()->assertSessionHasNoErrors();
        $saved = GradebookConfigService::getConfig(409,6)->map(function($c){return (array)$c;})->all();
        $this->assertSame([100,101],array_column($saved,'data_source'));
        $this->postJson($url,['components'=>$rows,'_configuration_revision'=>$hash])->assertStatus(422);
        $this->from($edit)->post($url,['components'=>$rows,'_configuration_revision'=>$hash])->assertSessionHasErrors('components');
        $this->get($edit)->assertOk()->assertSee('name="_configuration_revision" value="'.$hash.'"',false);
        $this->postJson($url,['components'=>$saved,'_configuration_year'=>5])->assertStatus(422);
        $tampered=$saved;$tampered[0]['data_source']=['invalid'];
        $this->postJson($url,['components'=>$tampered])->assertStatus(422);
        $this->post($url,['components'=>array_reverse($saved)])->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame(array_reverse(array_column($saved,'id')),GradebookConfigService::getConfig(409,6)->pluck('id')->all());
        // A known nonstandard reserved ID/source pair must round-trip without remapping.
        $mismatch = [['id'=>'legacy_homework','name'=>'Historical manual','weight'=>20,'data_source'=>100]];
        GradebookConfigService::saveConfig(409,6,$mismatch);
        $id = DB::table('exams2')->insertGetId(['lesson_id'=>409,'room_id'=>132,'class_id'=>2,'term_id'=>20,'type'=>1,'name'=>'Dynamic_Section_100','mark'=>20]);
        DB::table('exam_result2')->insert(['exam_id'=>$id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'result'=>0]);
        $before = DB::table('exam_result2')->get()->toJson();
        $this->post($url,['components'=>$mismatch])->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame(100,GradebookConfigService::getConfig(409,6)->first()->data_source);
        $this->postJson($url,['components'=>[]])->assertStatus(422);
        $mismatch[0]['weight']=21;
        $this->postJson($url,['components'=>$mismatch])->assertStatus(422);
        $this->assertSame($before,DB::table('exam_result2')->get()->toJson());
        // Retained original quiz summaries also cannot be structurally removed.
        GradebookConfigService::saveConfig(409,6,[['id'=>'legacy_homework','name'=>'Quizzes','weight'=>40,'data_source'=>'LEGACY_HOMEWORK']]);
        DB::table('exams2')->where('id',$id)->update(['type'=>2,'name'=>'Original quiz']);
        $this->postJson($url,['components'=>[]])->assertStatus(422);
        Storage::put('gradebook/409_6.json','malformed json');
        $this->postJson($url,['components'=>$saved])->assertStatus(422);
        $this->assertSame('malformed json',Storage::get('gradebook/409_6.json'));
    }

    private function distributions()
    {
        DB::table('lessons')->where('id',409)->update(['max_mark'=>300]);
        DB::table('lessons')->insert(['id'=>410,'class_id'=>2,'name'=>'اللغة العربية','max_mark'=>200]);
        $english = [
            ['id'=>'legacy_oral','name'=>'English Participation','weight'=>20,'data_source'=>'LEGACY_ORAL','sort_order'=>1],
            ['id'=>'legacy_homework','name'=>'English Quizzes','weight'=>30,'data_source'=>'LEGACY_HOMEWORK','sort_order'=>2],
            ['id'=>'legacy_exam','name'=>'English Exam','weight'=>50,'data_source'=>'LEGACY_EXAM','sort_order'=>3],
        ];
        $arabic = [
            ['id'=>'legacy_oral','name'=>'مشاركة العربية','weight'=>10,'data_source'=>'LEGACY_ORAL','sort_order'=>1],
            ['id'=>'arabic_homework','name'=>'واجب العربية','weight'=>10,'data_source'=>100,'sort_order'=>2],
            ['id'=>'legacy_homework','name'=>'مذاكرات العربية','weight'=>30,'data_source'=>'LEGACY_HOMEWORK','sort_order'=>3],
            ['id'=>'legacy_exam','name'=>'امتحان العربية','weight'=>50,'data_source'=>'LEGACY_EXAM','sort_order'=>4],
        ];
        GradebookConfigService::saveConfig(409,6,$english);
        GradebookConfigService::saveConfig(410,6,$arabic);
        return [$english,$arabic];
    }

    private function distributionResult($subject, $type, $name, $value, $term = 20, $room = 132)
    {
        $exam = DB::table('exams2')->insertGetId(['class_id'=>2,'room_id'=>$room,'lesson_id'=>$subject,'term_id'=>$term,'type'=>$type,'name'=>$name,'mark'=>100]);
        DB::table('exam_result2')->insert(['exam_id'=>$exam,'user_id'=>41,'room_id'=>$room,'class_id'=>2,'lesson_id'=>$subject,'term_id'=>$term,'result'=>$value,'status'=>1]);
        return $exam;
    }

    public function test_student_review_uses_each_subjects_exact_components_without_fixed_columns()
    {
        $this->distributions();
        $exam = $this->distributionResult(409,1,'Original English Exam','55.5');
        $this->distributionResult(409,2,'Original English Quiz','0');
        $this->distributionResult(410,1,'Dynamic_Section_100','0');
        $this->distributionResult(410,2,'Original Arabic Quiz','12.25');
        $before = DB::table('exam_result2')->orderBy('id')->get()->toJson();
        $response = $this->get('/SMT/admin/gradebook/view/student/card?student_id=41')->assertOk();
        $marks=$response->viewData('studentMarks');
        $this->assertSame([3,4],array_map(function($row){return count($row['term1']['components']);},$marks));
        $this->assertSame(150.0,$marks[0]['term1']['components'][2]['maximum']);
        $this->assertSame(20.0,$marks[1]['term1']['components'][1]['maximum']);
        $this->assertNull($marks[0]['term1']['components'][0]['value']);
        $this->assertSame(0.0,$marks[0]['term1']['components'][1]['value']);
        $this->assertSame(55.5,$marks[0]['term1']['components'][2]['value']);
        $this->assertSame(12.3,$marks[1]['term1']['components'][2]['value']);
        $dom=new \DOMDocument(); @$dom->loadHTML('<?xml encoding="UTF-8">'.$response->getContent()); $xpath=new \DOMXPath($dom);
        foreach ([409=>3,410=>4] as $subject=>$count) {
            $scope='//section[@data-summary-subject="'.$subject.'" and @data-summary-term="20"]';
            $this->assertSame($count,$xpath->query($scope.'//tr[@data-component]')->length);
            $text=$xpath->query($scope)->item(0)->textContent;
            $this->assertStringContainsString($subject===409 ? 'English Participation' : 'واجب العربية',$text);
            $this->assertStringNotContainsString($subject===409 ? 'واجب العربية' : 'English Participation',$text);
        }
        $response->assertSee('data-assessment="exams2:'.$exam.'"',false)->assertSee('12.25');
        $this->get('/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=410')->assertOk()
            ->assertSee('واجب العربية')->assertDontSee('English Participation');
        $this->assertSame($before,DB::table('exam_result2')->orderBy('id')->get()->toJson());
    }

    public function test_unit_controls_keep_canonical_payload_and_exact_authorized_round_trip()
    {
        [$english] = $this->distributions();
        $response=$this->get('/SMT/admin/gradebook/settings/edit/409')->assertOk()
            ->assertSee('data-subject-total="300"',false)->assertSee('data-units-blocked="0"',false)
            ->assertSee('gradebook-distribution-units.js');
        $dom=new \DOMDocument(); @$dom->loadHTML($response->getContent()); $xpath=new \DOMXPath($dom);
        $inputs=$xpath->query('//form[@id="configForm"]//tbody[@id="componentsBody"]//input[contains(@class,"allocation-mark-input")]');
        $this->assertSame(3,$inputs->length);
        foreach ($inputs as $input) { $this->assertFalse($input->hasAttribute('name')); $this->assertTrue($input->hasAttribute('disabled')); }
        $this->post('/SMT/admin/gradebook/settings/update/409',['components'=>$english,'_allocation_subject_total'=>'300'])->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame($english,GradebookConfigService::getConfig(409,6)->map(function($c){return (array)$c;})->all());
        $bad=$english; $bad[2]['weight']='33.3333333333'; $bytes=Storage::get('gradebook/409_6.json');
        $this->post('/SMT/admin/gradebook/settings/update/409',['components'=>$bad])->assertSessionHasErrors('components.2.weight');
        $this->assertSame($bytes,Storage::get('gradebook/409_6.json'));
    }

    public function test_distribution_remains_subject_year_scoped_not_section_or_term_specific()
    {
        [$english]=$this->distributions();
        GradebookConfigService::saveConfig(409,5,[['id'=>'old_only','name'=>'Old component','weight'=>100,'data_source'=>'LEGACY_EXAM','sort_order'=>1]]);
        $this->distributionResult(409,2,'Current quiz',0);
        $this->distributionResult(409,2,'Other actual term',25,21);
        $this->distributionResult(409,1,'Historical exam',70,17,93);
        $service=app(GradebookReadService::class); $subject=\App\Lesson::find(409);
        $current=$service->read(\App\Room::find(132),$subject,[41],[20]);
        $other=$service->read(\App\Room::find(133),$subject,[41],[20]);
        $old=$service->read(\App\Room::find(93),$subject,[41]);
        $this->assertEquals($current['components'],$other['components']);
        $this->assertSame(0.0,$current['marks'][41][20]['legacy_homework']);
        $this->assertNull($other['marks'][41][20]['total']);
        $this->assertSame([20],$current['terms']->pluck('id')->all());
        $this->assertSame(['Old component'],$old['components']->pluck('name')->all());
        $this->assertSame(70.0,$old['marks'][41][17]['old_only']);
        $this->assertSame($english,GradebookConfigService::getConfig(409,6)->map(function($c){return (array)$c;})->all());
    }

    public function test_explicit_bounds_mismatched_sources_and_empty_components_are_not_normalized()
    {
        foreach ([['id'=>'project','name'=>'Explicit bound','weight'=>20,'data_source'=>100,'sort_order'=>1,'max_mark'=>12],
            ['id'=>'legacy_homework','name'=>'Unresolved mapping','weight'=>0,'data_source'=>100,'sort_order'=>1]] as $component) {
            GradebookConfigService::saveConfig(409,6,[$component]); $before=Storage::get('gradebook/409_6.json');
            $this->get('/SMT/admin/gradebook/settings/edit/409')->assertOk()->assertSee('data-units-blocked="1"',false);
            $this->assertSame($before,Storage::get('gradebook/409_6.json'));
        }
        GradebookConfigService::saveConfig(409,6,[]);
        $id=$this->distributionResult(409,1,'Unconfigured original assessment',12.5);
        $this->get('/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=409')->assertOk()
            ->assertSee(__('gradebook_distribution.no_components'))->assertSee('Unconfigured original assessment')
            ->assertDontSee('<th>شفهي</th>',false);
        $this->get('/SMT/admin/gradebook/view/student/card?student_id=41')->assertOk()
            ->assertSee(__('gradebook_distribution.no_components'))->assertSee('data-assessment="exams2:'.$id.'"',false);
        $this->assertSame('12.5',DB::table('exam_result2')->where('exam_id',$id)->value('result'));
    }

    public function test_subject_discovery_does_not_hide_unscheduled_or_configured_class_subjects()
    {
        $this->distributions();
        DB::table('teacher_room_lesson')->insert(['teacher_id'=>166,'room_id'=>132,'lesson_id'=>410,'class_id'=>2,'year_id'=>6]);
        $this->get('/SMT/admin/gradebook/settings/subjects/132')->assertOk()->assertSee('اللغة العربية')
            ->assertSee(route('admin.gradebook.settings.edit',410),false)->assertDontSee('/gradebook/templates',false);
        $this->assertFalse(app(\App\Services\CurrentTeacherAssignments::class)->has(166,132,410));
    }

    public function test_mark_mode_rejects_a_stale_subject_maximum_without_changing_legacy_percent_requests()
    {
        [$english]=$this->distributions();
        $before=Storage::get('gradebook/409_6.json');
        DB::table('lessons')->where('id',409)->update(['max_mark'=>600]);
        $this->post('/SMT/admin/gradebook/settings/update/409',['components'=>$english,'_allocation_subject_total'=>'300'])
            ->assertSessionHasErrors('_allocation_subject_total');
        $this->assertSame($before,Storage::get('gradebook/409_6.json'));
        $this->post('/SMT/admin/gradebook/settings/update/409',['components'=>$english])->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame($english,GradebookConfigService::getConfig(409,6)->map(function($c){return (array)$c;})->all());
    }
}
