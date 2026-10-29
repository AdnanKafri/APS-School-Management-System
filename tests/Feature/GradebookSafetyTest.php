<?php

namespace Tests\Feature;

use App\Exams2;
use App\Exam_result2;
use App\Lesson;
use App\Room;
use App\Student;
use App\User;
use App\Services\GradebookReadService;
use App\Services\GradebookConfigService;
use App\Services\GradebookStatusService;
use App\Services\TeacherAssessmentService;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class GradebookSafetyTest extends TestCase
{
    use \Tests\Concerns\TimetableFixtures;
    private $teacher;
    private $admin;
    private $studentId = 41;
    private $roomId = 132;
    private $lessonId = 409;
    private $teacherUrl = '/SMARMANger/dashboard/teacher/gradebook/2/132/409';
    private $saveUrl = '/SMARMANger/dashboard/teacher/gradebook/save';

    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        DB::connection()->getPdo()->sqliteCreateCollation('utf8_unicode_ci', 'strcmp');
        Carbon::setTestNow(Carbon::parse('2026-10-22 10:00:00', 'Asia/Damascus'));
        Storage::fake('local');
        config(['filesystems.default' => 'local']);
        app()->setLocale('ar');
        foreach (json_decode(file_get_contents(__DIR__.'/../Fixtures/gradebook-schema.json'), true) as $table => $columns) {
            Schema::create($table, function (Blueprint $schema) use ($columns) {
                foreach ($columns as $column) {
                    if ($column['name'] === 'id') $schema->increments('id');
                    elseif (preg_match('/^(tiny|small|medium|big)?int/', $column['type'])) $schema->integer($column['name'])->nullable();
                    else $schema->text($column['name'])->nullable();
                }
            });
        }
        foreach (['messages' => ['teacher_id','type','view'], 'notifications' => ['user_id','student_id','lesson_id','room_id','title','body','term_id','type'],
            'student_fcm_tokens' => ['s_fk','s_fcm_token'], 'exam_questions' => ['test_id','exam_id','question_id'],
            'lectures' => ['lesson_id','class_id','active'], 'messages_super' => ['teacher_id','view'],
            'supervisor_teacher_items' => ['teacher_id','view'], 'objections' => ['teacher_id','view']] as $table => $columns) {
            Schema::create($table, function (Blueprint $schema) use ($columns) {
                $schema->increments('id'); foreach ($columns as $column) $schema->text($column)->nullable(); $schema->timestamps();
            });
        }
        // Render the real child views; unrelated portal shell queries are isolated.
        View::composer(['admin.master', 'teachers2.layouts.app', 'students.layouts.app4'], function ($view) {
            $view->setPath(__DIR__.'/../Fixtures/gradebook-layout.blade.php');
        });
        DB::table('years')->insert([['id'=>5,'name'=>'2025/2026','current_year'=>0],['id'=>6,'name'=>'2026/2027','current_year'=>1]]);
        DB::table('term_years')->insert([
            ['id'=>17,'year_id'=>5,'type'=>1,'term'=>'Old term','current_term'=>1],
            ['id'=>20,'year_id'=>6,'type'=>1,'term'=>'الفصل الأول','current_term'=>1],
            ['id'=>21,'year_id'=>6,'type'=>2,'term'=>'الفصل الثاني','current_term'=>0],
        ]);
        DB::table('classes')->insert(['id'=>2,'name'=>'Grade 2']);
        foreach ([132,133] as $id) DB::table('rooms')->insert(['id'=>$id,'year_id'=>6,'class_id'=>2,'name'=>'Section '.$id]);
        DB::table('rooms')->insert(['id'=>93,'year_id'=>5,'class_id'=>2,'name'=>'Old section']);
        DB::table('lessons')->insert(['id'=>409,'class_id'=>2,'name'=>'English','max_mark'=>100]);
        DB::table('teachers')->insert(['id'=>166,'first_name'=>'Isolated','last_name'=>'teacher']);
        $this->createTimetableSchema();
        $this->timetablePeriod(166, 132, 409, 6);
        DB::table('teacher_room_lesson')->insert(['teacher_id'=>166,'year_id'=>6,'class_id'=>2,'room_id'=>132,'lesson_id'=>409]);
        $this->teacher = $this->account(1, ['teacher_id'=>166]);
        $this->admin = $this->account(2, ['role_id'=>1,'view_password'=>'test-delete']);
        $this->enroll(41); $this->enroll(42);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function account($type, array $attributes = [])
    {
        $id = DB::table('users')->insertGetId(array_merge(['name'=>'Isolated account','email'=>uniqid().'@test.local','password'=>'unused','type'=>$type], $attributes));
        return User::findOrFail($id);
    }

    private function enroll($id, $room = 132)
    {
        DB::table('students')->insert(['id'=>$id,'first_name'=>'طالب '.$id,'last_name'=>'اختبار','lifecycle_status'=>'active']);
        DB::table('room_student')->insert(['student_id'=>$id,'year_id'=>6,'room_id'=>$room,'created_at'=>now(),'updated_at'=>now()]);
        DB::table('student_academic_placements')->insert(['student_id'=>$id,'year_id'=>6,'class_id'=>2,'room_id'=>$room,
            'status'=>'active','effective_from'=>now()->subDay(),'created_at'=>now(),'updated_at'=>now()]);
    }

    private function exam($type = 1, array $extra = [])
    {
        $id = DB::table('exams2')->insertGetId(array_merge(['user_id'=>$this->admin->id,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,
            'term_id'=>20,'type'=>$type,'name'=>'Assessment '.$type,'mark'=>100,'is_file'=>1,'has_traditional'=>0,
            'start_date'=>'2026-10-20 09:00:00','end_date'=>'2026-10-21 09:00:00'], $extra));
        return Exams2::findOrFail($id);
    }

    private function result($exam, $value, array $extra = [])
    {
        $id = DB::table('exam_result2')->insertGetId(array_merge(['exam_id'=>$exam->id,'user_id'=>41,'room_id'=>$exam->room_id,
            'class_id'=>$exam->class_id,'lesson_id'=>$exam->lesson_id,'term_id'=>$exam->term_id,'result'=>$value,'status'=>1,'type'=>$exam->type], $extra));
        return Exam_result2::findOrFail($id);
    }

    private function read($students = [41,42])
    {
        return app(GradebookReadService::class)->read(Room::find(132), Lesson::find(409), $students);
    }

    private function dynamic()
    {
        $components = GradebookConfigService::getDefaults()->map(function ($c) { return (array) $c; })->all();
        $components[] = ['id'=>'dynamic_a','name'=>'مشروع','data_source'=>100,'weight'=>20,'sort_order'=>4];
        GradebookConfigService::saveConfig(409, 6, $components);
        GradebookStatusService::setStatus(2,20,'OPEN');
        return ['student_id'=>41,'room_id'=>132,'subject_id'=>409,'component_id'=>'dynamic_a','value'=>15];
    }

    public function test_all_admin_gradebook_routes_enforce_admin_role_for_direct_get_and_post()
    {
        $routes = collect(app('router')->getRoutes()->getRoutes())->filter(function ($route) {
            return strpos($route->uri(), 'SMT/admin/gradebook') === 0 || $route->getName() === 'admin.gradebook.status';
        });
        $this->assertSame(19, $routes->count());
        foreach ($routes as $route) {
            $this->assertContains('auth', $route->gatherMiddleware());
            $this->assertContains('roleadmin', $route->gatherMiddleware());
            $this->assertContains('can:student_marks', $route->gatherMiddleware());
            $url = '/'.preg_replace('/\{[^}]+\}/', '409', $route->uri());
            foreach ([0,1,3,4,8] as $type) {
                $this->actingAs($this->account($type));
                $response = in_array('POST',$route->methods()) ? $this->postJson($url,[]) : $this->getJson($url);
                $this->assertContains($response->status(), [302,403]);
            }
        }
        auth()->logout();
        $this->getJson('/SMT/admin/gradebook')->assertStatus(401);
        $this->actingAs($this->admin)->get('/SMT/admin/gradebook')->assertOk();
        $this->postJson('/gradebook/status',['class_id'=>2,'term_id'=>20,'status'=>'OPEN'])->assertOk();
        $this->postJson('/gradebook/status',['class_id'=>2,'term_id'=>17,'status'=>'OPEN'])->assertStatus(422);
    }

    public function test_admin_creation_preserves_schedule_and_uses_current_year_term()
    {
        $this->actingAs($this->admin);
        foreach (['exam'=>1,'quize'=>2] as $kind=>$type) {
            $this->post('/SMT/admin/class/room/'.$kind.'/store', ['class_id'=>2,'room_id'=>[132], 'lesson_id'=>409,
                'content_name'=>'اختبار معتمد','question_picker'=>2,'required_lectures'=>0,'is_file'=>1,
                'start_date'=>'2026-10-23 08:00:00','end_date'=>'2026-10-24 08:00:00','mark'=>20,'period'=>40])
                ->assertRedirect()->assertSessionHasNoErrors();
            $exam = Exams2::orderByDesc('id')->first();
            $this->assertEquals(20,$exam->term_id); $this->assertEquals($type,$exam->type);
            $this->assertSame('2026-10-23 08:00:00',$exam->start_date);
            $this->assertSame('2026-10-24 08:00:00',$exam->end_date);
        }
    }

    public function test_legacy_teacher_save_is_immediately_visible_in_both_gradebooks_without_copying()
    {
        $this->actingAs($this->teacher);
        foreach ([1=>38,2=>17] as $type=>$mark) {
            $exam = $this->exam($type);
            $this->post('/SMARMANger/dashboard/teacher/student_save_mark_quize', [
                'exam_id'=>$exam->id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'class_id'=>2,'mark'=>$mark,
            ])->assertRedirect()->assertSessionHasNoErrors();
            $this->assertDatabaseHas('exam_result2',['exam_id'=>$exam->id,'user_id'=>41,'result'=>$mark]);
            $read = $this->read();
            $this->assertEquals($mark,$read['assessments']->firstWhere('id',$exam->id)['results'][41]['value']);
        }
        $teacher = app(\App\Http\Controllers\Teacher\TeacherGradebookController::class)->index(2,132,409)->getData();
        $admin = app(\App\Http\Controllers\Admin\GradebookController::class)->viewGridSimple(new \Illuminate\Http\Request(['room_id'=>132,'subject_id'=>409]))->getData();
        $this->assertSame($teacher['gradebook']['assessments']->all(),$admin['gradebook']['assessments']->all());
        $this->assertEquals(55,$teacher['existingMarks'][41]['total']);
        $this->assertEquals(55,$admin['calculatedMarks'][41]['term1']['total']);
        $this->assertSame(2,Exam_result2::count());
        $this->assertSame(0,DB::table('students_marks')->count());
        $this->get($this->teacherUrl)->assertOk()->assertSee('Assessment 1')->assertSee('Assessment 2');
        $this->actingAs($this->admin)->get('/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=409')->assertOk();
    }

    public function test_read_adapter_distinguishes_numeric_max_zero_missing_invalid_and_nullable_term()
    {
        $this->result($this->exam(1), '90');
        $this->result($this->exam(1), '100', ['term_id'=>null]);
        $this->result($this->exam(2), '0');
        $this->result($this->exam(2), null);
        $this->result($this->exam(2), 'bad');
        $conflict=$this->exam(1);$this->result($conflict,'99',['term_id'=>21]);
        $this->result($this->exam(1,['term_id'=>21]),'30');
        $read=$this->read();
        $this->assertSame(100.0,$read['marks'][41][20]['legacy_exam']);
        $this->assertSame(0.0,$read['marks'][41][20]['legacy_homework']);
        $this->assertNull($read['marks'][42][20]['total']);
        $this->assertSame(30.0,$read['marks'][41][21]['legacy_exam']);
        $this->assertCount(2,$read['issues']);
        $this->assertArrayNotHasKey(41,$read['assessments']->firstWhere('id',$conflict->id)['results']);
    }

    public function test_dynamic_and_oral_sources_do_not_overwrite_or_double_count_quizzes_or_exams()
    {
        $this->dynamic();
        $this->result($this->exam(1,['name'=>'Dynamic_Section_100','mark'=>20]),'12');
        $this->result($this->exam(1), '35');
        $this->result($this->exam(2), '15');
        $id=DB::table('lesson_teacher_room_term_exam')->insertGetId(['class_id'=>2,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'type'=>8,'name_exam'=>'Lesson test']);
        DB::table('exam_result')->insert(['exam_id'=>$id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'term_id'=>null,'result'=>'5','status'=>1]);
        $read=$this->read();
        $this->assertSame(['legacy_oral'=>5.0,'legacy_homework'=>15.0,'legacy_exam'=>35.0,'dynamic_a'=>12.0,'total'=>67.0],$read['marks'][41][20]);
    }

    public function test_dynamic_writes_reject_invalid_bounds_lock_context_and_duplicate_rows()
    {
        $this->actingAs($this->teacher);$payload=$this->dynamic();
        foreach (['bad',-1,20.1] as $invalid) $this->postJson($this->saveUrl,array_merge($payload,['value'=>$invalid]))->assertStatus(422);
        $this->postJson($this->saveUrl,array_merge($payload,['room_id'=>133]))->assertStatus(403);
        $this->postJson($this->saveUrl,array_merge($payload,['component_id'=>'legacy_exam']))->assertStatus(422);
        $this->postJson($this->saveUrl,array_merge($payload,['value'=>0]))->assertOk()->assertJsonPath('total',0);
        $this->postJson($this->saveUrl,$payload)->assertOk()->assertJsonPath('total',15);
        $this->assertSame(1,Exams2::count());$this->assertSame(1,Exam_result2::count());
        $this->postJson($this->saveUrl,array_merge($payload,['value'=>null]))->assertStatus(422);
        GradebookStatusService::setStatus(2,20,'LOCKED');
        $this->postJson($this->saveUrl,$payload)->assertStatus(403);
        $this->assertEquals(15,Exam_result2::first()->result);
        GradebookStatusService::setStatus(2,20,'OPEN');
        $this->result(Exams2::first(),'10');
        $this->postJson($this->saveUrl,$payload)->assertStatus(422);
        $this->assertSame(2,Exam_result2::count());
    }

    public function test_transferred_out_and_historical_students_cannot_receive_current_marks()
    {
        $this->actingAs($this->teacher);$payload=$this->dynamic();$exam=$this->exam();$old=$this->result($exam,'25');
        DB::table('room_student')->where('student_id',41)->update(['room_id'=>133]);
        DB::table('student_academic_placements')->where('student_id',41)->update(['room_id'=>133]);
        $this->postJson($this->saveUrl,$payload)->assertStatus(403);
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark_quize',[
            'exam_id'=>$exam->id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'mark'=>30])->assertStatus(403);
        $this->assertSame('25',$old->fresh()->result);
        $this->assertEquals(25,$this->read()['assessments']->first()['results'][41]['value']);
        $view=app(\App\Http\Controllers\Teacher\TeacherGradebookController::class)->index(2,132,409)->getData();
        $this->assertSame([42],$view['students']->pluck('id')->all());
    }

    public function test_delete_and_definition_edit_preserve_results_and_files()
    {
        $this->actingAs($this->admin);$exam=$this->exam();$result=$this->result($exam,'0');
        $snapshot=$result->getRawOriginal();
        $this->postJson('/SMT/admin/class/room/exam_quize/delete',['content_id'=>$exam->id,'delete_code'=>'test-delete'])->assertStatus(422);
        $this->assertEquals($snapshot,$result->fresh()->getRawOriginal());
        $this->assertDatabaseHas('exams2',['id'=>$exam->id]);
        try {$exam->room_id=133;$exam->save();$this->fail('Context rewrite accepted');} catch (\Illuminate\Validation\ValidationException $e) {}
        $this->assertEquals(132,$exam->fresh()->room_id);
        $empty=$this->exam();
        $this->post('/SMT/admin/class/room/exam_quize/delete',['content_id'=>$empty->id,'delete_code'=>'test-delete'])->assertRedirect();
        $this->assertDatabaseMissing('exams2',['id'=>$empty->id]);
        $fileExam=$this->exam();DB::table('exams_files')->insert(['exam_id'=>$fileExam->id,'student_id'=>41,'file'=>'keep.pdf']);
        $this->postJson('/SMT/admin/class/room/exam_quize/delete',['content_id'=>$fileExam->id,'delete_code'=>'test-delete'])->assertStatus(422);
        $this->assertDatabaseHas('exams_files',['file'=>'keep.pdf']);
    }

    public function test_participation_preserves_existing_marks_notifies_only_new_students_and_rejects_removal()
    {
        $this->actingAs($this->teacher);$exam=$this->exam(2);$result=$this->result($exam,'15');$snapshot=$result->getRawOriginal();
        $payload=['exam'=>$exam->id,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'all'=>1];
        $url='/SMARMANger/dashboard/teacher/add_quize_student';
        $this->post($url,$payload)->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame($snapshot,$result->fresh()->getRawOriginal());$this->assertSame(2,Exam_result2::count());
        $this->assertSame(1,DB::table('notifications')->count());
        $this->post($url,$payload)->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame(1,DB::table('notifications')->count());
        $this->postJson($url,array_merge($payload,['all'=>0,'student'=>[42]]))->assertStatus(422);
        $this->assertSame($snapshot,$result->fresh()->getRawOriginal());
        $this->postJson($url,array_merge($payload,['all'=>0,'student'=>[999]]))->assertStatus(403);
    }

    public function test_bulk_save_is_atomic_and_invalid_row_does_not_leave_partial_marks()
    {
        $this->actingAs($this->teacher);$exam=$this->exam();
        $row=['exam_id'=>$exam->id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'mark'=>20];
        $url='/SMARMANger/dashboard/teacher/student_save_mark_bulk';
        $this->postJson($url,['kind'=>'exam2','rows'=>json_encode([$row,array_merge($row,['user_id'=>42,'mark'=>101])])])->assertStatus(422);
        $this->assertSame(0,Exam_result2::count());
        $this->post($url,['kind'=>'exam2','rows'=>json_encode([$row,array_merge($row,['user_id'=>42,'mark'=>0])])])->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame(2,Exam_result2::count());
    }

    public function test_get_imports_are_non_mutating_and_post_checks_exact_context()
    {
        $this->actingAs($this->teacher);$exam=$this->exam(2);$this->result($exam,'15');
        foreach (['export_exam','export_exam1'] as $name) $this->get('/SMARMANger/dashboard/teacher/'.$name.'/'.$exam->id.'/132/409')->assertStatus(405);
        $this->assertSame(0,DB::table('students_marks')->count());
        $this->postJson('/SMARMANger/dashboard/teacher/export_exam/'.$exam->id.'/133/409')->assertStatus(403);
        $this->postJson('/SMARMANger/dashboard/teacher/export_exam/'.$exam->id.'/132/409')->assertStatus(422);
        $this->assertSame(0,DB::table('students_marks')->count());
    }

    public function test_summary_aggregation_uses_numeric_max_and_cannot_rewrite_old_year()
    {
        $this->result($this->exam(),'90');$this->result($this->exam(),'100',['term_id'=>null]);
        $service=app(\App\Services\GradebookAggregationService::class);
        $this->assertSame('success',$service->aggregateRoomSubject(132,409,6)['status']);
        $this->assertEquals(100,json_decode(DB::table('students_marks')->where('student_id',41)->value('mark'),true)[409]['exam']);
        $before=DB::table('students_marks')->orderBy('id')->get()->toJson();
        $this->assertSame('error',$service->aggregateRoomSubject(93,409,5)['status']);
        $this->assertSame($before,DB::table('students_marks')->orderBy('id')->get()->toJson());
    }

    private function scaffold($studentId = 41)
    {
        return DB::table('students_marks')->insertGetId([
            'student_id'=>$studentId,'year_id'=>6,'room_id'=>132,'adjustable'=>0,
            'mark'=>json_encode([409=>['oral'=>0,'homework'=>0,'activities'=>0,'quize'=>0,'exam'=>0]]),
            'mark2'=>json_encode([409=>['oral'=>0,'homework'=>0,'activities'=>0,'quize'=>0,'exam'=>0]]),
            'result1'=>json_encode([409=>['term1_result'=>0,'term1_quizes'=>0,'term1_exam'=>0]]),
            'result2'=>json_encode([409=>['term2_result'=>0,'term2_quizes'=>0,'term2_exam'=>0]]),
            'result'=>json_encode([409=>['year_result'=>0]]), 'term_result'=>json_encode(['term1'=>0,'term2'=>0]),
            'estimation1'=>'{}','estimation2'=>'{}','estimation'=>'{}','worke_degree'=>null,
        ]);
    }

    public function test_authorized_post_import_preserves_raw_results_and_report_formula()
    {
        $this->actingAs($this->teacher);$id=$this->scaffold();
        foreach ([2=>15,1=>38] as $type=>$mark) {
            $exam=$this->exam($type);$record=$this->result($exam,$mark);$before=$record->getRawOriginal();
            $name=$type===2?'export_exam':'export_exam1';
            $this->post('/SMARMANger/dashboard/teacher/'.$name.'/'.$exam->id.'/132/409')->assertRedirect()->assertSessionHasNoErrors();
            $row=DB::table('students_marks')->where('id',$id)->first();
            $this->assertEquals($mark,json_decode($row->mark,true)[409][$type===2?'quize':'exam']);
            $this->assertSame($before,$record->fresh()->getRawOriginal());
        }
        $this->assertEquals(53,json_decode($row->result1,true)[409]['term1_result']);
    }

    public function test_import_report_lock_rolls_back_every_student_and_csrf_is_required()
    {
        $this->actingAs($this->teacher);$exam=$this->exam(2);$this->result($exam,15);$this->result($exam,10,['user_id'=>42]);
        $this->scaffold();$locked=$this->scaffold(42);
        DB::table('students_marks')->where('id',$locked)->update(['adjustable'=>1]);
        $before=DB::table('students_marks')->orderBy('id')->get()->toJson();
        $url='/SMARMANger/dashboard/teacher/export_exam/'.$exam->id.'/132/409';
        $this->postJson($url)->assertStatus(422);
        $this->assertSame($before,DB::table('students_marks')->orderBy('id')->get()->toJson());
        $this->app->bind(\App\Http\Middleware\VerifyCsrfToken::class,function($app) {
            return new class($app,$app['encrypter']) extends \App\Http\Middleware\VerifyCsrfToken {
                protected function runningUnitTests() { return false; }
            };
        });
        $this->postJson($url)->assertRedirect(route('login'));
        $this->assertSame($before,DB::table('students_marks')->orderBy('id')->get()->toJson());
    }

    public function test_legacy_assessment_edits_keep_results_and_question_rows()
    {
        $this->actingAs($this->teacher);
        $id=DB::table('lesson_teacher_room_term_exam')->insertGetId(['class_id'=>2,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,
            'teacher_id'=>166,'type'=>8,'type_file'=>2,'name_exam'=>'Test','start_time'=>'2026-10-20 09:00:00','end_time'=>'2026-10-21 09:00:00']);
        DB::table('exam_result')->insert(['exam_id'=>$id,'user_id'=>41,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'term_id'=>20,'type'=>8,'result'=>'12','status'=>1]);
        DB::table('exam_questions')->insert(['test_id'=>$id,'question_id'=>1]);
        $before=DB::table('exam_result')->get()->toJson();
        $controller=app(\App\Http\Controllers\TeacherController_New::class);
        $controller->exam_update(new \Illuminate\Http\Request(['exam_id'=>$id,'name'=>'Edited title',
            'start_time'=>'2026-10-20 09:00:00','end_time'=>'2026-10-21 09:00:00','room_id'=>133,'class_id'=>999,'type'=>5]));
        $this->assertSame($before,DB::table('exam_result')->get()->toJson());
        try {$controller->exam_delete(new \Illuminate\Http\Request(['exam_id'=>$id]));$this->fail('Deletion accepted');}
        catch (\Illuminate\Validation\ValidationException $e) {}
        $this->assertSame(1,DB::table('exam_questions')->count());
        $this->assertSame($before,DB::table('exam_result')->get()->toJson());
    }

    public function test_config_cannot_hide_or_rebind_a_used_component_and_ui_escapes_names()
    {
        $this->actingAs($this->teacher);$payload=$this->dynamic();$this->postJson($this->saveUrl,$payload)->assertOk();
        $old=Storage::get('gradebook/409_6.json');
        $components=GradebookConfigService::getConfig(409,6)->map(function($c){return (array)$c;})->all();
        $this->actingAs($this->admin);
        $url='/SMT/admin/gradebook/settings/update/409';
        $this->postJson($url,['components'=>array_slice($components,0,3)])->assertStatus(422);
        $components[3]['data_source']=101;$this->postJson($url,['components'=>$components])->assertStatus(422);
        $this->assertSame($old,Storage::get('gradebook/409_6.json'));
        $components[3]['data_source']=100;$components[3]['name']='<script>alert(1)</script>';
        $this->post($url,['components'=>$components])->assertRedirect()->assertSessionHasNoErrors();
        $response=$this->get('/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=409');
        $response->assertOk()->assertDontSee('<script>alert(1)</script>',false)->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;',false);
    }

    public function test_admin_student_card_uses_current_membership_not_first_historical_room()
    {
        DB::table('room_student')->insert(['student_id'=>41,'year_id'=>5,'room_id'=>93]);
        $this->result($this->exam(),'35');
        $this->result($this->exam(1,['room_id'=>93,'term_id'=>17]),'99');
        $view=app(\App\Http\Controllers\Admin\GradebookController::class)->viewStudentCard(new \Illuminate\Http\Request(['student_id'=>41]))->getData();
        $this->assertEquals(35,$view['studentMarks'][0]['term1']['total']);
        $this->assertEquals([132],$view['subjectGradebooks'][0]['gradebook']['assessments']->pluck('room_id')->unique()->all());
    }

    public function test_no_current_term_is_safe_and_zero_results_are_rendered()
    {
        $exam=$this->exam();$this->result($exam,'0');
        $this->actingAs($this->admin)->get('/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=409')->assertOk()->assertSee('>0</td>',false);
        DB::table('term_years')->where('id',20)->update(['current_term'=>0]);
        $this->get('/SMT/admin/gradebook/view/subject/subjects/132')->assertOk()->assertSee(__('gradebook.term_missing'));
        $this->actingAs($this->teacher)->getJson($this->teacherUrl)->assertStatus(422);
    }

    public function test_teacher_assessment_lists_keep_upcoming_active_ended_and_type_context()
    {
        $this->actingAs($this->teacher);
        foreach ([1,2] as $type) {
            foreach (['2026-10-10','2026-10-22','2026-10-30'] as $date) {
                $this->exam($type,['start_date'=>$date.' 08:00:00','end_date'=>$date.' 16:00:00']);
            }
            $this->exam($type,['room_id'=>133,'name'=>'Wrong section']);
            $this->exam($type,['term_id'=>17,'room_id'=>93,'name'=>'Old year']);
            $name=$type===1?'teacher_exam':'teacher_quize';
            $response=$this->get('/SMARMANger/dashboard/teacher/'.$name.'/132/166/409');
            $response->assertOk()->assertDontSee('Wrong section')->assertDontSee('Old year');
            $this->assertCount(3,$response->viewData($type===1?'exam':'quizes'));
        }
    }

    public function test_second_term_import_accepts_null_scaffold_and_preserves_first_term()
    {
        $this->timetablePeriod(166, 132, 409, 6, 21);
        $this->actingAs($this->teacher);$id=$this->scaffold();
        DB::table('term_years')->where('year_id',6)->update(['current_term'=>0]);
        DB::table('term_years')->where('id',21)->update(['current_term'=>1]);
        DB::table('students_marks')->where('id',$id)->update(['adjustable'=>1,'mark2'=>json_encode([409=>[
            'oral'=>null,'homework'=>null,'activities'=>null,'quize'=>null,'exam'=>null]])]);
        $first=DB::table('students_marks')->where('id',$id)->value('mark');
        foreach ([2=>0,1=>40] as $type=>$value) {
            $exam=$this->exam($type,['term_id'=>21]);$result=$this->result($exam,$value);$before=$result->getRawOriginal();
            $name=$type===2?'export_exam':'export_exam1';
            $this->post('/SMARMANger/dashboard/teacher/'.$name.'/'.$exam->id.'/132/409')->assertRedirect()->assertSessionHasNoErrors();
            $row=DB::table('students_marks')->where('id',$id)->first();
            $this->assertEquals($value,json_decode($row->mark2,true)[409][$type===2?'quize':'exam']);
            $this->assertSame($first,$row->mark);
            $this->assertSame($before,$result->fresh()->getRawOriginal());
        }
    }

    public function test_empty_dynamic_input_is_non_mutating_and_failed_insert_rolls_back_container()
    {
        $this->actingAs($this->teacher);$payload=$this->dynamic();
        $this->postJson($this->saveUrl,array_merge($payload,['value'=>null]))->assertOk()->assertJsonPath('total',null);
        $this->assertSame(0,Exams2::count());
        DB::statement("CREATE TRIGGER reject_test_result BEFORE INSERT ON exam_result2 BEGIN SELECT RAISE(ABORT, 'Isolated save failure'); END");
        $this->postJson($this->saveUrl,$payload)->assertStatus(500);
        $this->assertSame(0,Exams2::count());$this->assertSame(0,Exam_result2::count());
        DB::statement('DROP TRIGGER reject_test_result');
        $this->postJson($this->saveUrl,array_merge($payload,['value'=>20]))->assertOk()->assertJsonPath('total',20);
        $this->assertEquals(20,Exams2::first()->mark);
    }

    public function test_legacy_cascades_are_blocked_before_any_academic_or_assignment_deletion()
    {
        $this->actingAs($this->admin);$this->result($this->exam(),'0');
        $before=DB::table('exam_result2')->get()->toJson();
        $this->postJson('/SMT/admin/delete_student',['student_id'=>41,'password'=>'test-delete'])->assertStatus(422);
        $this->postJson('/SMT/admin/lessons/delete_lesson',['lesson_id_delete'=>409,'delete_code'=>'test-delete'])->assertStatus(422);
        $this->postJson('/SMT/admin/lesson/delete',['id'=>409])->assertStatus(422);
        $controller=app(\App\Http\Controllers\DashboardController::class);
        foreach (['class_delete_fun'=>2,'room_delete_fun'=>132,'lesson_delete_fun'=>409] as $method=>$id) {
            try {$controller->$method($id);$this->fail('Academic cascade accepted');}
            catch (\Illuminate\Validation\ValidationException $e) {}
        }
        $this->assertSame($before,DB::table('exam_result2')->get()->toJson());
        $this->assertSame(1,DB::table('teacher_room_lesson')->count());
        $this->assertSame(2,Student::count());
        DB::table('exam_result2')->delete(); // Isolated fixture: prove summary-only history is protected too.
        $this->scaffold();
        $this->postJson('/SMT/admin/lesson/delete',['id'=>409])->assertStatus(422);
        $this->assertSame(1,DB::table('students_marks')->count());
    }

    public function test_exact_teacher_assignment_pairs_and_non_null_term_conflicts_are_rejected()
    {
        $this->actingAs($this->teacher);$payload=$this->dynamic();
        DB::table('lessons')->insert(['id'=>410,'class_id'=>2,'name'=>'Other subject','max_mark'=>100]);
        DB::table('teacher_room_lesson')->insert(['teacher_id'=>166,'class_id'=>2,'room_id'=>133,'lesson_id'=>410,'year_id'=>6]);
        $this->postJson($this->saveUrl,array_merge($payload,['subject_id'=>410]))->assertStatus(403);
        $this->postJson($this->saveUrl,array_merge($payload,['room_id'=>133]))->assertStatus(403);
        $exam=$this->exam();$record=$this->result($exam,'12',['term_id'=>21]);$before=$record->getRawOriginal();
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark_quize',[
            'exam_id'=>$exam->id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'mark'=>15])->assertStatus(422);
        $this->assertSame($before,$record->fresh()->getRawOriginal());
        $this->actingAs($this->account(1,['teacher_id'=>999]))->getJson($this->teacherUrl)->assertStatus(403);
    }

    public function test_legacy_file_id_submission_blocks_delete_before_storage_is_touched()
    {
        $this->actingAs($this->teacher);Storage::fake('public');Storage::disk('public')->put('keep.pdf','isolated');
        $id=DB::table('lesson_teacher_room_term_exam')->insertGetId(['class_id'=>2,'room_id'=>132,'lesson_id'=>409,
            'teacher_id'=>166,'term_id'=>20,'type'=>4,'addition'=>'keep.pdf']);
        DB::table('student_lesson_teacher_room_term_exam')->insert(['student_id'=>41,'room_id'=>132,'file_id'=>$id,'file'=>'answer.pdf']);
        try {
            app(\App\Http\Controllers\TeacherController_New::class)->addition_delete(new \Illuminate\Http\Request(['id'=>$id]));
            $this->fail('File-backed history was deleted');
        } catch (\Illuminate\Validation\ValidationException $e) {}
        Storage::disk('public')->assertExists('keep.pdf');
        $this->assertSame(1,DB::table('student_lesson_teacher_room_term_exam')->count());
        $this->assertSame(1,DB::table('lesson_teacher_room_term_exam')->count());
    }

    public function test_duplicate_dynamic_containers_are_visible_but_excluded_from_summary()
    {
        $this->dynamic();
        $this->result($this->exam(1,['name'=>'Dynamic_Section_100']),'10');
        $this->result($this->exam(1,['name'=>'Dynamic_Section_100']),'20');
        $read=$this->read();
        $this->assertCount(2,$read['assessments']);$this->assertCount(2,$read['issues']);
        $this->assertNull($read['marks'][41][20]['total']);
        $this->assertSame(2,Exam_result2::count());
    }

    public function test_phase0b_complete_admin_exam_and_quiz_workflow_with_individual_bulk_and_reports()
    {
        $this->scaffold(41); $this->scaffold(42);
        foreach (['exam'=>1,'quize'=>2] as $kind=>$type) {
            $this->actingAs($this->admin)->post('/SMT/admin/class/room/'.$kind.'/store', [
                'class_id'=>2,'room_id'=>[132],'lesson_id'=>409,'content_name'=>'Acceptance '.$kind,
                'question_picker'=>2,'required_lectures'=>0,'is_file'=>1,'mark'=>100,'period'=>40,
                'start_date'=>'2026-10-23 08:00:00','end_date'=>'2026-10-24 08:00:00',
            ])->assertRedirect()->assertSessionHasNoErrors();
            $exam=Exams2::orderByDesc('id')->first();
            $this->assertEquals([2,132,409,20,$type],[$exam->class_id,$exam->room_id,$exam->lesson_id,$exam->term_id,$exam->type]);
            $this->actingAs($this->teacher)->get('/SMARMANger/dashboard/teacher/teacher_'.$kind.'/132/166/409')
                ->assertOk()->assertSee('Acceptance '.$kind);
            $row=['exam_id'=>$exam->id,'user_id'=>41,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'mark'=>0];
            $this->post('/SMARMANger/dashboard/teacher/student_save_mark_quize',$row)->assertRedirect()->assertSessionHasNoErrors();
            $this->post('/SMARMANger/dashboard/teacher/student_save_mark_bulk', ['kind'=>'exam2',
                'rows'=>json_encode([array_merge($row,['mark'=>100]),array_merge($row,['user_id'=>42])])])
                ->assertRedirect()->assertSessionHasNoErrors();
            $this->assertSame(2,Exam_result2::where('exam_id',$exam->id)->count());
            $this->assertDatabaseHas('exam_result2',['exam_id'=>$exam->id,'user_id'=>41,'result'=>100]);
            $this->assertDatabaseHas('exam_result2',['exam_id'=>$exam->id,'user_id'=>42,'result'=>0]);
            $before=Exam_result2::orderBy('id')->get()->toJson();
            $teacher=$this->get($this->teacherUrl)->assertOk()->viewData('gradebook');
            $admin=$this->actingAs($this->admin)->get('/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=409')
                ->assertOk()->viewData('gradebook');
            $this->assertSame($teacher['assessments']->all(),$admin['assessments']->all());
            $this->assertSame(100.0,$admin['assessments']->firstWhere('id',$exam->id)['results'][41]['value']);
            $this->assertSame(0.0,$admin['assessments']->firstWhere('id',$exam->id)['results'][42]['value']);
            // Legacy reports have narrower, pre-existing 40/20 caps. Do not rescale raw marks.
            $import=$type===1?'export_exam1':'export_exam';
            $this->actingAs($this->teacher)->postJson('/SMARMANger/dashboard/teacher/'.$import.'/'.$exam->id.'/132/409')->assertStatus(422);
            $this->assertSame($before,Exam_result2::orderBy('id')->get()->toJson());
            $reportValue=$type===1?40:20;
            $this->post('/SMARMANger/dashboard/teacher/student_save_mark_quize',array_merge($row,['mark'=>$reportValue]))
                ->assertRedirect()->assertSessionHasNoErrors();
            $before=Exam_result2::orderBy('id')->get()->toJson();
            $this->actingAs($this->teacher)->post('/SMARMANger/dashboard/teacher/'.$import.'/'.$exam->id.'/132/409')
                ->assertRedirect()->assertSessionHasNoErrors();
            $this->assertSame($before,Exam_result2::orderBy('id')->get()->toJson());
            $marks=json_decode(DB::table('students_marks')->where('student_id',41)->value('mark'),true);
            $this->assertEquals($reportValue,$marks[409][$type===1?'exam':'quize']);
        }
        $this->assertSame(4,Exam_result2::count());
    }

    public function test_phase0b_config_roundtrip_preserves_explicit_maximum_and_reports_saved_state()
    {
        $this->dynamic();
        $components=GradebookConfigService::getConfig(409,6)->map(function($c){return (array)$c;})->all();
        $components[3]['max_mark']=12;
        GradebookConfigService::saveConfig(409,6,$components);
        unset($components[3]['max_mark']); // The existing editor only submits names and weights.
        $this->actingAs($this->admin)->post('/SMT/admin/gradebook/settings/update/409',['components'=>$components])
            ->assertRedirect()->assertSessionHasNoErrors();
        $saved=GradebookConfigService::getConfig(409,6)->firstWhere('id','dynamic_a');
        $this->assertEquals(12,GradebookReadService::componentMaximum($saved,Lesson::find(409)));
        $this->get('/SMT/admin/gradebook/settings/subjects/132')->assertOk()->assertSee(__('gradebook.custom_configuration'));
        $this->actingAs($this->teacher)->postJson($this->saveUrl,['student_id'=>41,'room_id'=>132,'subject_id'=>409,'component_id'=>'dynamic_a','value'=>13])->assertStatus(422);
    }

    public function test_phase0b_config_validation_preserves_attempted_rows_and_shows_errors()
    {
        $url='/SMT/admin/gradebook/settings/edit/409';
        $this->actingAs($this->admin)->from($url)->post('/SMT/admin/gradebook/settings/update/409',[
            'components'=>[7=>['id'=>'','data_source'=>'','name'=>'Unsaved project','weight'=>101]],
        ])->assertRedirect($url)->assertSessionHasErrors('components.7.weight');
        $this->get($url)->assertOk()->assertSee('Unsaved project')->assertSee('role="alert"',false);
    }

    public function test_phase0b_all_admin_gradebook_get_screens_render_without_writes()
    {
        $this->actingAs($this->admin);
        $before=DB::table('students_marks')->get()->toJson();
        foreach (['','/view/options','/view/subject/classes','/view/subject/rooms/2','/view/subject/subjects/132',
            '/view/subject/grid?room_id=132&subject_id=409','/view/student/classes','/view/student/rooms/2',
            '/view/student/students/132','/view/student/card?student_id=41','/settings','/settings/rooms/2',
            '/settings/subjects/132','/settings/edit/409'] as $path) {
            $this->get('/SMT/admin/gradebook'.$path)->assertOk();
        }
        $this->assertSame($before,DB::table('students_marks')->get()->toJson());
        $this->assertSame(0,Exam_result2::count());
    }

    public function test_phase0b_unconfigured_year_returns_safe_gradebook_landing_not_null_crash()
    {
        DB::table('years')->update(['current_year'=>0]);
        $this->actingAs($this->admin);
        foreach (['/view/subject/rooms/2','/view/student/rooms/2','/settings','/settings/rooms/2','/settings/edit/409'] as $path) {
            $this->get('/SMT/admin/gradebook'.$path)->assertRedirect(route('admin.gradebook.index'))->assertSessionHas('error');
        }
    }

    public function test_phase0b_academic_record_preserves_zero_for_both_result_systems()
    {
        foreach (['certificates','school_data'] as $table) Schema::create($table,function(Blueprint $schema){
            $schema->increments('id'); $schema->integer('student_id')->nullable(); $schema->integer('room_id')->nullable();
        });
        $this->result($this->exam(), '0'); $this->result($this->exam(2),null);
        $markId=$this->scaffold();
        DB::table('lessons')->insert(['id'=>410,'class_id'=>2,'name'=>'Second term only','max_mark'=>100]);
        DB::table('students_marks')->where('id',$markId)->update(['mark2'=>json_encode([410=>['exam'=>0,'quize'=>18]])]);
        $legacy=DB::table('lesson_teacher_room_term_exam')->insertGetId(['class_id'=>2,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'type'=>8]);
        DB::table('exam_result')->insert(['exam_id'=>$legacy,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'result'=>'0','status'=>'1']);
        $this->actingAs($this->account(0,['student_id'=>41]));
        $placement=DB::table('student_academic_placements')->where('student_id',41)->value('id');
        $view=app(\App\Http\Controllers\studentscontroller::class)->academic_record_show($placement);
        $data=$view->getData();
        $this->assertSame(['0','0','غير مرصودة'],array_column($data['assessmentRows'],'result'));
        $second=collect($data['markRows'])->firstWhere('subject','Second term only');
        $this->assertSame(['18','0'],array_column($second['components'],'value'));
        $this->assertSame(__('gradebook.term_two').' - امتحان',$second['components'][1]['label']);
        $html=$view->render();
        $this->assertStringContainsString('data-label="الفصل الأول">0</td>',$html);
        $this->assertStringContainsString('data-label="الفصل الثاني">0</td>',$html);
        $this->assertStringContainsString('data-label="النتيجة السنوية"><strong>0</strong>',$html);
    }

    public function test_phase0b_settings_use_current_sections_and_exact_assignment_not_assessment_authors()
    {
        DB::table('teachers')->insert(['id'=>167,'first_name'=>'Wrong','last_name'=>'teacher']);
        DB::table('teacher_room_lesson')->insert(['teacher_id'=>167,'year_id'=>6,'class_id'=>2,'room_id'=>133,'lesson_id'=>409]);
        DB::table('teacher_room_lesson')->insert(['teacher_id'=>167,'year_id'=>5,'class_id'=>2,'room_id'=>93,'lesson_id'=>409]);
        $this->actingAs($this->admin);
        $index=$this->get('/SMT/admin/gradebook/settings')->assertOk();
        $this->assertEquals(2,$index->viewData('classes')->first()->room_count);
        $this->get('/SMT/admin/gradebook/settings/subjects/132')->assertOk()->assertSee('Isolated teacher')->assertDontSee('Wrong teacher');
        $this->get('/SMT/admin/gradebook/settings/subjects/93')->assertNotFound();
    }

    public function test_phase0b_student_card_explains_dynamic_total_and_resolved_context()
    {
        $this->dynamic();
        $this->result($this->exam(1,['name'=>'Dynamic_Section_100','mark'=>20]),'12');
        $response=$this->actingAs($this->admin)->get('/SMT/admin/gradebook/view/student/card?student_id=41')
            ->assertOk()->assertSee('Section 132')->assertSee('Grade 2')->assertSee('2026/2027')->assertSee(__('gradebook.additional_components'));
        $row=$response->viewData('studentMarks')[0]['term1'];
        $this->assertSame([['name'=>'مشروع','value'=>12.0]],$row['additional']);
        $this->assertSame(12.0,$row['total']);
    }

    public function test_phase0b_admin_creation_rejects_mixed_context_before_any_insert_and_is_atomic()
    {
        DB::table('classes')->insert(['id'=>3,'name'=>'Grade 3']);
        DB::table('lessons')->insert(['id'=>410,'class_id'=>3,'name'=>'Other curriculum','max_mark'=>100]);
        $payload=['class_id'=>2,'room_id'=>[132],'lesson_id'=>409,'content_name'=>'Validated assessment',
            'question_picker'=>2,'required_lectures'=>0,'is_file'=>1,'mark'=>20,'period'=>40,
            'start_date'=>'2026-10-23 08:00:00','end_date'=>'2026-10-24 08:00:00'];
        $this->actingAs($this->admin);
        foreach (['exam','quize'] as $kind) {
            $url='/SMT/admin/class/room/'.$kind.'/store';
            foreach ([['class_id'=>3],['lesson_id'=>410],['room_id'=>[132,93]],['room_id'=>[]],['room_id'=>[132,132]],['mark'=>0],['mark'=>'bad']] as $invalid) {
                $this->postJson($url,array_merge($payload,$invalid))->assertStatus(422);
                $this->assertSame(0,Exams2::count());
            }
        }
        Exams2::creating(function($exam){if ((int)$exam->room_id===133) throw new \RuntimeException('isolated insert failure');});
        foreach (['exam','quize'] as $kind) {
            $this->postJson('/SMT/admin/class/room/'.$kind.'/store',array_merge($payload,['room_id'=>[132,133]]))->assertStatus(500);
            $this->assertSame(0,Exams2::count());
        }
    }

    public function test_phase0b_replacing_teacher_revokes_old_access_without_reauthoring_results()
    {
        $result=$this->result($this->exam(),35);$before=$result->getRawOriginal();
        DB::table('teachers')->insert(['id'=>167,'first_name'=>'Replacement','last_name'=>'teacher']);
        DB::table('teacher_room_lesson')->where('teacher_id',166)->update(['teacher_id'=>167]);
        DB::table('lesson_room_teacher_lecture_time')->where('teacher_id',166)->update(['teacher_id'=>167]);
        DB::table('teachers')->where('id',167)->update(['active'=>0]);
        $this->actingAs($this->teacher)->getJson($this->teacherUrl)->assertForbidden();
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark_quize',[
            'exam_id'=>$result->exam_id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'mark'=>30])->assertForbidden();
        $this->actingAs($this->account(1,['teacher_id'=>167]))->get($this->teacherUrl)->assertOk()->assertSee('>35</td>',false);
        $this->assertSame($before,$result->fresh()->getRawOriginal());
    }

    public function test_phase1_explicit_identity_is_atomic_scoped_and_does_not_rewrite_results()
    {
        require_once database_path('migrations/2026_10_23_000001_create_assessment_equivalence_members.php');
        (new \CreateAssessmentEquivalenceMembers())->up();
        $service=app(\App\Services\AssessmentEquivalenceService::class);
        $a=$this->exam();$b=$this->exam(1,['room_id'=>133,'name'=>'Different title, verified same occurrence']);
        $result=$this->result($a,0);$before=$result->getRawOriginal();
        $this->actingAs($this->teacher);
        try {$service->verify([$a->id,$b->id],'Verified staging occurrence');$this->fail('Teacher mapped assessments');}
        catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {$this->assertEquals(403,$e->getStatusCode());}
        $this->actingAs($this->admin);
        foreach ([['mark'=>20],['term_id'=>21],['type'=>2],['room_id'=>93,'term_id'=>17]] as $conflict) {
            $other=$this->exam(1,array_merge(['room_id'=>133],$conflict));
            try {$service->verify([$a->id,$other->id],'Incompatible context');$this->fail('Incompatible mapping accepted');}
            catch (\Illuminate\Validation\ValidationException $e) {}
            $this->assertSame(0,DB::table('assessment_equivalence_members')->count());
        }
        $identity=$service->verify([$a->id,$b->id],'Explicitly verified assessment occurrence');
        $this->assertSame(2,DB::table('assessment_equivalence_members')->where('identity',$identity)->count());
        $this->assertSame($before,$result->fresh()->getRawOriginal());
        $this->assertSame(1,\App\Exam_result2::count());
        try {$service->verify([$a->id,$b->id],'Duplicate request');$this->fail('Identity replaced');}
        catch (\Illuminate\Validation\ValidationException $e) {}
        $this->assertSame(2,DB::table('assessment_equivalence_members')->count());
    }

    public function test_mysql_enum_status_bindings_use_labels_not_numeric_ordinals()
    {
        $this->actingAs($this->teacher);$payload=$this->dynamic();
        DB::enableQueryLog();
        $this->postJson($this->saveUrl,$payload)->assertOk();
        $queries=collect(DB::getQueryLog());
        $insert=$queries->first(function($q){return strpos($q['query'],'insert into "exam_result2"')===0;});
        $this->assertSame('1',$insert['bindings'][8]);
        $query=$queries->first(function($q){return strpos($q['query'],'from "exam_result"')!==false && strpos($q['query'],'"status" = ?')!==false;});
        $this->assertSame('1',end($query['bindings']));
    }

    private function activateContinuity()
    {
        require_once database_path('migrations/2026_10_23_000001_create_assessment_equivalence_members.php');
        (new \CreateAssessmentEquivalenceMembers())->up();
    }

    private function moveToB()
    {
        if (!Schema::hasTable('certificates')) Schema::create('certificates', function (Blueprint $t) {
            $t->increments('id'); $t->integer('student_id'); $t->integer('room_id')->nullable();
        });
        $this->actingAs($this->admin);
        $transfer = app(\App\Services\StudentTransferService::class);
        $transfer->handle(\Illuminate\Http\Request::create('/', 'POST', [
            'student_id'=>41, 'class_change_id'=>2, 'room_change_id'=>133,
        ]));
        $this->assertTrue($transfer->succeeded(), 'The real isolated transfer must succeed');
        $this->assertDatabaseHas('room_student', ['student_id'=>41,'year_id'=>6,'room_id'=>133]);
        DB::table('teacher_room_lesson')->insert(['teacher_id'=>166,'year_id'=>6,'class_id'=>2,'room_id'=>133,'lesson_id'=>409]);
        $this->timetablePeriod(166, 133, 409, 6);
    }

    public function test_phase1_shared_creation_real_transfer_and_all_four_receiving_views_preserve_originals()
    {
        $this->activateContinuity();
        $account=$this->account(0,['student_id'=>41]); $identity=$account->getRawOriginal();
        $student=Student::find(41)->getRawOriginal();
        $oldMark=$this->scaffold();
        $oldMarkSnapshot=DB::table('students_marks')->where('id',$oldMark)->first();
        $sources=[]; $targets=[];
        foreach (['exam'=>1,'quize'=>2] as $kind=>$type) {
            $this->actingAs($this->admin)->post('/SMT/admin/class/room/'.$kind.'/store', [
                'class_id'=>2,'room_id'=>[132,133],'lesson_id'=>409,'content_name'=>'Shared '.$kind,
                'question_picker'=>2,'required_lectures'=>0,'is_file'=>1,'mark'=>100,'period'=>40,
                'start_date'=>'2026-10-23 08:00:00','end_date'=>'2026-10-24 08:00:00',
            ])->assertRedirect()->assertSessionHasNoErrors();
            $a=Exams2::where('type',$type)->where('room_id',132)->firstOrFail();
            $b=Exams2::where('type',$type)->where('room_id',133)->firstOrFail();
            $sources[$kind]=$a; $targets[$kind]=$b;
            $this->assertSame(1,DB::table('assessment_equivalence_members')->whereIn('exam_id',[$a->id,$b->id])->distinct()->count('identity'));
            $this->actingAs($this->teacher)->post('/SMARMANger/dashboard/teacher/student_save_mark_quize',[
                'exam_id'=>$a->id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'mark'=>$type===1?80:0,
            ])->assertRedirect()->assertSessionHasNoErrors();
        }
        $original=Exam_result2::orderBy('id')->get()->toJson();
        $this->moveToB();
        foreach ($targets as $kind=>$target) {
            $response=$this->actingAs($this->teacher)->get('/SMARMANger/dashboard/teacher/teacher_'.$kind.'_students/133/166/409/'.$target->id)
                ->assertOk()->assertSee('data-continuity="carried"',false)->assertSee(__('gradebook.carried'));
            file_put_contents(sys_get_temp_dir().'/aladham-phase1-'.$kind.'-1.html',$response->getContent());
            $this->get('/SMARMANger/dashboard/teacher/quizestudent/0/'.$target->id.'/133')->assertOk()
                ->assertJsonFragment(['id'=>41])->assertSee('continuity_row');
            $this->get('/SMARMANger/dashboard/teacher/quizestudent/2/'.$target->id.'/133')->assertOk()
                ->assertJsonFragment(['id'=>41])->assertSee('continuity_row');
            foreach (['student_save_mark_quize','student_save_mark3'] as $save) {
                $this->postJson('/SMARMANger/dashboard/teacher/'.$save,[
                    'exam_id'=>$target->id,'user_id'=>41,'room_id'=>133,'lesson_id'=>409,'mark'=>99,
                ])->assertStatus(422)->assertJsonFragment(['assessment'=>[__('gradebook.carried_read_only')]]);
            }
            $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark_bulk', ['kind'=>'exam2','rows'=>json_encode([
                ['exam_id'=>$target->id,'user_id'=>41,'room_id'=>133,'lesson_id'=>409,'mark'=>99],
            ])])->assertStatus(422);
            app(TeacherAssessmentService::class)->participants($target->id,133,409,2,true,[]);
            $this->assertSame(0,Exam_result2::where('exam_id',$target->id)->where('user_id',41)->count());
            $this->getJson('/SMARMANger/dashboard/teacher/student_save_mark3')->assertStatus(405);
        }
        $teacher=$this->get('/SMARMANger/dashboard/teacher/gradebook/2/133/409')->assertOk()
            ->assertSee('data-continuity="carried"',false)->viewData('gradebook');
        $admin=$this->actingAs($this->admin)->get('/SMT/admin/gradebook/view/subject/grid?room_id=133&subject_id=409')->assertOk()
            ->assertSee('data-continuity="carried"',false)->viewData('gradebook');
        $this->assertSame($teacher['marks'][41][20],$admin['marks'][41][20]);
        $this->assertSame(80.0,$teacher['marks'][41][20]['total']);
        $this->assertCount(2,$teacher['assessments']);
        $this->assertSame(0.0,$teacher['assessments']->firstWhere('type','quiz')['results'][41]['value']);
        $this->get('/SMT/admin/gradebook/view/student/card?student_id=41')->assertOk()->assertSee(__('gradebook.carried'));
        $this->assertSame($original,Exam_result2::orderBy('id')->get()->toJson());
        $this->assertSame($identity,$account->fresh()->getRawOriginal());
        $this->assertSame($student,Student::find(41)->getRawOriginal());
        $this->assertEquals($oldMarkSnapshot,DB::table('students_marks')->where('id',$oldMark)->first());
        $this->assertDatabaseHas('student_academic_placements',['student_id'=>41,'room_id'=>132,'status'=>'closed']);
        $this->assertSame(1,DB::table('student_transfer_histories')->where('student_id',41)->count());
        $this->actingAs($this->teacher)->getJson('/SMARMANger/dashboard/exam/correct_exam1/'.$sources['exam']->id.'/41')->assertForbidden();
    }

    public function test_phase1_automated_forms_and_ajax_show_carried_rows_without_editable_inputs()
    {
        $this->activateContinuity(); $this->actingAs($this->admin);
        $targets=[];
        foreach ([1,2] as $type) {
            $a=$this->exam($type,['is_file'=>0]); $b=$this->exam($type,['room_id'=>133,'is_file'=>0]);
            $this->result($a,0,['created_at'=>now()->subHour()]);
            app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified same sitting');
            $targets[]=$b;
        }
        $this->moveToB(); $this->actingAs($this->teacher);
        foreach ($targets as $target) {
            $kind=(int)$target->type===1?'exam':'quize';
            $response=$this->get('/SMARMANger/dashboard/teacher/teacher_'.$kind.'_students/133/166/409/'.$target->id)
                ->assertOk()->assertSee('data-continuity-row="41"',false);
            file_put_contents(sys_get_temp_dir().'/aladham-phase1-'.$kind.'-0.html',$response->getContent());
            preg_match('/<tr data-continuity-row="41">(.*?)<\/tr>/s',$response->getContent(),$match);
            $this->assertStringNotContainsString('<input',$match[1]);
            $ajax=$this->get('/SMARMANger/dashboard/teacher/quizestudent/0/'.$target->id.'/133')->assertOk()->json();
            $this->assertStringContainsString('data-continuity="carried"',$ajax[0]['continuity_row']);
            $this->assertSame([],$ajax[0]['exam_result2']);
        }
    }

    public function test_phase1_missing_mapping_keeps_old_marks_separate_and_conflicts_are_not_counted()
    {
        $this->activateContinuity(); $a=$this->exam(); $b=$this->exam(1,['room_id'=>133]);
        $this->result($a,23); $this->moveToB();
        $read=app(GradebookReadService::class)->read(Room::find(133),Lesson::find(409),[41]);
        $this->assertNull($read['marks'][41][20]['total']);
        $this->assertCount(1,$read['historical']);
        $this->assertSame(23.0,$read['historical'][0]['value']);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Explicit retrospective verification');
        $this->result($b,23);
        $read=app(GradebookReadService::class)->read(Room::find(133),Lesson::find(409),[41]);
        $this->assertSame('conflict',$read['assessments'][0]['results'][41]['state']);
        $this->assertNull($read['marks'][41][20]['total']);
        $this->actingAs($this->teacher)->postJson('/SMARMANger/dashboard/teacher/student_save_mark_quize',[
            'exam_id'=>$b->id,'user_id'=>41,'room_id'=>133,'lesson_id'=>409,'mark'=>23,
        ])->assertStatus(422);
        $this->assertSame(2,Exam_result2::count());
    }

    public function test_phase1_mapping_ui_validates_context_confirmation_and_permissions()
    {
        $this->activateContinuity(); $a=$this->exam(); $b=$this->exam(1,['room_id'=>133]);
        $this->actingAs($this->admin)->get('/SMT/admin/gradebook/equivalence?year_id=6&lesson_id=409')
            ->assertOk()->assertSee('Section 133');
        $payload=['exam_ids'=>[$a->id,$b->id],'evidence'=>'Independently verified sitting','confirmed'=>1];
        $this->actingAs($this->teacher)->postJson('/SMT/admin/gradebook/equivalence',$payload)->assertStatus(302);
        $this->assertSame(0,DB::table('assessment_equivalence_members')->count());
        $this->actingAs($this->admin)->postJson('/SMT/admin/gradebook/equivalence',array_merge($payload,['confirmed'=>0]))->assertStatus(422);
        foreach ([['mark'=>20],['term_id'=>21],['lesson_id'=>999],['class_id'=>3],['room_id'=>93,'term_id'=>17]] as $bad) {
            DB::table('exams2')->where('id',$b->id)->update($bad);
            $this->postJson('/SMT/admin/gradebook/equivalence',$payload)->assertStatus(422);
            DB::table('exams2')->where('id',$b->id)->update(['mark'=>100,'term_id'=>20,'lesson_id'=>409,'class_id'=>2,'room_id'=>133]);
        }
        $this->post('/SMT/admin/gradebook/equivalence',$payload)->assertRedirect()->assertSessionHasNoErrors();
        $this->postJson('/SMT/admin/gradebook/equivalence',$payload)->assertStatus(422);
        $this->assertSame(2,DB::table('assessment_equivalence_members')->count());
        try {$b->mark=50;$b->save();$this->fail('Mapped context changed');} catch (\Illuminate\Validation\ValidationException $e) {}
    }

    public function test_phase1_stale_mapping_and_missing_placement_are_conflicts_not_guesses()
    {
        $this->activateContinuity(); $a=$this->exam();$b=$this->exam(1,['room_id'=>133]);$this->result($a,12);
        $this->actingAs($this->admin);app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified occurrence');
        $this->moveToB();$resolver=app(\App\Services\AssessmentContinuityService::class);
        $this->assertSame('carried',$resolver->resolve($b,[41])[41]['state']);
        foreach (['mark'=>50,'term_id'=>21,'class_id'=>3,'lesson_id'=>999,'room_id'=>93] as $field=>$value) {
            $old=$a->$field;DB::table('exams2')->where('id',$a->id)->update([$field=>$value]);
            $this->assertSame('conflict',$resolver->resolve($b,[41])[41]['state']);
            DB::table('exams2')->where('id',$a->id)->update([$field=>$old]);
        }
        DB::table('student_academic_placements')->where('student_id',41)->where('room_id',132)->delete(); // Isolated invalid fixture only.
        $this->assertSame('conflict',$resolver->resolve($b,[41])[41]['state']);
    }

    public function test_phase1_return_visit_resolver_preserves_single_result_but_operational_return_stays_blocked()
    {
        $this->activateContinuity();$a=$this->exam();$b=$this->exam(1,['room_id'=>133]);
        $this->result($a,0,['created_at'=>now()->subHour()]);$before=Exam_result2::first()->getRawOriginal();
        $this->actingAs($this->admin);app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified occurrence');
        $this->moveToB();
        $service=app(\App\Services\StudentTransferService::class);
        $service->handle(\Illuminate\Http\Request::create('/','POST',['student_id'=>41,'class_change_id'=>2,'room_change_id'=>132]));
        $this->assertFalse($service->succeeded());
        Carbon::setTestNow(now()->addHour());
        // Valid, non-overlapping A -> B -> A fixture; not a claim of operational return support.
        DB::table('student_academic_placements')->where('student_id',41)->where('status','active')->update(['status'=>'closed','effective_to'=>now()]);
        DB::table('student_academic_placements')->insert(['student_id'=>41,'year_id'=>6,'class_id'=>2,'room_id'=>132,'status'=>'active','effective_from'=>now()]);
        DB::table('room_student')->where('student_id',41)->update(['room_id'=>132,'updated_at'=>now()]);
        $read=$this->read([41]);
        $this->assertSame('carried',$read['assessments'][0]['results'][41]['state'], json_encode([
            'placements'=>DB::table('student_academic_placements')->where('student_id',41)->get(),
            'result'=>Exam_result2::first()->getRawOriginal(),
        ]));
        $this->assertSame(0.0,$read['marks'][41][20]['total']);
        $this->assertSame($before,Exam_result2::first()->getRawOriginal());
        $this->assertSame(1,Exam_result2::count());
    }

    public function test_phase1_migration_indexes_foreign_key_empty_rollback_and_populated_preservation()
    {
        $before=DB::table('exams2')->get()->toJson();$this->activateContinuity();
        $this->assertNotEmpty(DB::select('PRAGMA foreign_key_list(assessment_equivalence_members)'));
        $indexes=DB::select('PRAGMA index_list(assessment_equivalence_members)');
        $this->assertCount(2,array_filter($indexes,function($i){return (int)$i->unique===1;}));
        (new \CreateAssessmentEquivalenceMembers())->down();
        $this->assertFalse(Schema::hasTable('assessment_equivalence_members'));
        $this->activateContinuity();
        $this->assertSame($before,DB::table('exams2')->get()->toJson());
        $a=$this->exam();$b=$this->exam(1,['room_id'=>133]);$this->actingAs($this->admin);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified occurrence');
        DB::statement('PRAGMA foreign_keys = ON');
        try {DB::table('exams2')->where('id',$a->id)->delete();$this->fail('Mapped source deleted');}
        catch (\Illuminate\Database\QueryException $e) {}
        $member=(array)DB::table('assessment_equivalence_members')->first();unset($member['id']);
        try {DB::table('assessment_equivalence_members')->insert($member);$this->fail('Duplicate membership accepted');}
        catch (\Illuminate\Database\QueryException $e) {}
        try {(new \CreateAssessmentEquivalenceMembers())->down();$this->fail('Mapping history erased');}
        catch (\RuntimeException $e) {$this->assertStringContainsString('preservation plan',$e->getMessage());}
        $this->assertSame(2,DB::table('assessment_equivalence_members')->count());
    }

    public function test_phase1_multiple_occurrences_and_terms_never_merge_and_other_model_saves_are_protected()
    {
        $this->activateContinuity();$this->actingAs($this->admin);$targets=[];
        foreach ([[20,0],[20,50],[21,90]] as $case) {
            $a=$this->exam(2,['term_id'=>$case[0]]);$b=$this->exam(2,['room_id'=>133,'term_id'=>$case[0]]);
            $this->result($a,$case[1],['created_at'=>now()->subHour()]);
            app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified separate occurrence');
            $targets[]=$b;
        }
        $this->moveToB();$before=Exam_result2::orderBy('id')->get()->toJson();
        foreach ($targets as $target) {
            $result=new Exam_result2();$result->forceFill(['exam_id'=>$target->id,'user_id'=>41,'result'=>12]);
            try {$result->save();$this->fail('Other model writer duplicated carried mark');}
            catch (\Illuminate\Validation\ValidationException $e) {}
        }
        $read=app(GradebookReadService::class)->read(Room::find(133),Lesson::find(409),[41]);
        $this->assertCount(3,$read['assessments']);
        $this->assertSame(25.0,$read['marks'][41][20]['total']);
        $this->assertSame(90.0,$read['marks'][41][21]['total']);
        $current=app(GradebookReadService::class)->read(Room::find(133),Lesson::find(409),[41],[20]);
        $this->assertCount(2,$current['assessments']);
        $this->assertArrayNotHasKey(21,$current['marks'][41]);
        $this->assertSame($before,Exam_result2::orderBy('id')->get()->toJson());
        // A selected historical room still reads its originals, not the new placement.
        $old=$this->read([41]);$this->assertSame(25.0,$old['marks'][41][20]['total']);
        $this->assertArrayNotHasKey('state',$old['assessments'][0]['results'][41]);
    }

    public function test_phase1_mapping_existing_conflicting_attempts_is_rejected_without_rewriting_them()
    {
        $this->activateContinuity();$a=$this->exam();$b=$this->exam(1,['room_id'=>133]);
        $this->result($a,0);$this->result($b,50);$before=Exam_result2::orderBy('id')->get()->toJson();
        $this->actingAs($this->admin)->postJson('/SMT/admin/gradebook/equivalence',[
            'exam_ids'=>[$a->id,$b->id],'evidence'=>'Conflicting attempts need review','confirmed'=>1,
        ])->assertStatus(422);
        $this->assertSame(0,DB::table('assessment_equivalence_members')->count());
        $this->assertSame($before,Exam_result2::orderBy('id')->get()->toJson());
    }

    public function test_phase1_receiving_teacher_sees_only_authorized_current_roster_provenance()
    {
        $this->activateContinuity();$a=$this->exam();$b=$this->exam(1,['room_id'=>133]);
        $this->result($a,18);$this->result($a,92,['user_id'=>42]);
        $this->actingAs($this->admin);app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified occurrence');
        $this->moveToB();
        DB::table('teachers')->insert(['id'=>167,'first_name'=>'Receiving','last_name'=>'teacher']);
        DB::table('teacher_room_lesson')->where('room_id',133)->update(['teacher_id'=>167]);
        DB::table('lesson_room_teacher_lecture_time')->where('room_id',133)->update(['teacher_id'=>167]);
        DB::table('teachers')->where('id',167)->update(['active'=>0]);
        $receiver=$this->account(1,['teacher_id'=>167]);
        $read=$this->actingAs($receiver)->get('/SMARMANger/dashboard/teacher/gradebook/2/133/409')->assertOk()->viewData('gradebook');
        $this->assertSame(18.0,$read['assessments'][0]['results'][41]['value']);
        $this->assertArrayNotHasKey(42,$read['assessments'][0]['results']);
        $this->get('/SMARMANger/dashboard/teacher/teacher_exam_students/133/167/409/'.$b->id)->assertOk()->assertSee(__('gradebook.carried'));
        $this->getJson('/SMARMANger/dashboard/teacher/teacher_exam_students/132/166/409/'.$a->id)->assertForbidden();
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark_quize',[
            'exam_id'=>$a->id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'mark'=>50,
        ])->assertForbidden();
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark_quize',[
            'exam_id'=>$b->id,'user_id'=>42,'room_id'=>133,'lesson_id'=>409,'mark'=>50,
        ])->assertForbidden();
        $this->assertSame(2,Exam_result2::count());
    }

    public function test_phase1_legacy_ajax_writer_preserves_current_mark_updates_and_notifications()
    {
        $this->activateContinuity();$a=$this->exam();$b=$this->exam(1,['room_id'=>133]);
        $this->actingAs($this->admin);app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified occurrence');
        $controller=\Mockery::mock(\App\Http\Controllers\TeacherController_New::class)->makePartial();
        $controller->shouldReceive('send_notification')->twice()->andReturn(null);
        $this->app->instance(\App\Http\Controllers\TeacherController_New::class,$controller);
        $this->actingAs($this->teacher);
        $payload=['exam_id'=>$a->id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'mark'=>0];
        $url='/SMARMANger/dashboard/teacher/student_save_mark3';
        $this->postJson($url,$payload)->assertRedirect();
        $id=Exam_result2::firstOrFail()->id;
        $this->postJson($url,array_merge($payload,['exam_result_id'=>$id,'mark'=>25]))->assertRedirect();
        $this->assertSame(1,Exam_result2::count());
        $this->assertDatabaseHas('exam_result2',['id'=>$id,'result'=>25,'exam_id'=>$a->id]);
        $this->assertSame(2,DB::table('notifications')->where('student_id',41)->count());
        $this->getJson($url)->assertStatus(405);
        $this->app->bind(\App\Http\Middleware\VerifyCsrfToken::class,function($app) {
            return new class($app,$app['encrypter']) extends \App\Http\Middleware\VerifyCsrfToken {
                protected function runningUnitTests() { return false; }
            };
        });
        // The existing application handler redirects CSRF failures to login.
        $this->postJson($url,$payload)->assertRedirect(route('login'));
        $this->assertDatabaseHas('exam_result2',['id'=>$id,'result'=>25]);
        $this->assertSame(2,DB::table('notifications')->where('student_id',41)->count());
    }

    public function test_phase1_explicit_report_import_counts_carried_marks_once_and_never_rewrites_old_reports()
    {
        $this->activateContinuity();$this->scaffold();$targets=[];$this->actingAs($this->admin);
        DB::table('report_cards')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>132,'teacher_notes'=>'Original report','adjustable'=>0]);
        $oldReport=DB::table('report_cards')->where('room_id',132)->first();
        $oldMarks=DB::table('students_marks')->where('room_id',132)->first();
        foreach ([2=>10,1=>30] as $type=>$value) {
            $a=$this->exam($type);$b=$this->exam($type,['room_id'=>133]);$this->result($a,$value);
            app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified occurrence');$targets[$type]=$b;
        }
        $before=Exam_result2::orderBy('id')->get()->toJson();$this->moveToB();$this->actingAs($this->teacher);
        foreach ([1,2] as $repeat) foreach ($targets as $type=>$target) {
            $route=$type===2?'export_exam':'export_exam1';
            $this->post('/SMARMANger/dashboard/teacher/'.$route.'/'.$target->id.'/133/409')->assertRedirect()->assertSessionHasNoErrors();
        }
        $mark=DB::table('students_marks')->where('student_id',41)->where('room_id',133)->first();
        $this->assertEquals(10,json_decode($mark->mark,true)[409]['quize']);
        $this->assertEquals(30,json_decode($mark->mark,true)[409]['exam']);
        $this->assertEquals(40,json_decode($mark->result1,true)[409]['term1_result']);
        $this->assertEquals($oldMarks,DB::table('students_marks')->where('room_id',132)->first());
        $this->assertEquals($oldReport,DB::table('report_cards')->where('room_id',132)->first());
        $this->assertSame($before,Exam_result2::orderBy('id')->get()->toJson());
        DB::table('students_marks')->where('id',$mark->id)->update(['adjustable'=>1]);
        $this->postJson('/SMARMANger/dashboard/teacher/export_exam1/'.$targets[1]->id.'/133/409')->assertStatus(422);
        $this->assertSame($before,Exam_result2::orderBy('id')->get()->toJson());
    }
}
