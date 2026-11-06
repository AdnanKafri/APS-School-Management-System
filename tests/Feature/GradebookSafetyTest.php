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
        config(['student_results.student_pages_enabled'=>true]);
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
        View::composer(['admin.master', 'admin.layouts.v2', 'teachers2.layouts.app', 'students.layouts.app4'], function ($view) {
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

    public function test_occurrence_columns_discover_admin_creation_before_start_without_config_changes()
    {
        $this->dynamic();
        $config = Storage::get('gradebook/409_6.json');
        $status = Storage::get('gradebook_status/2_20.json');
        $this->actingAs($this->admin);
        foreach (['exam' => 'exam', 'quize' => 'quiz'] as $kind => $label) {
            $this->post('/SMT/admin/class/room/'.$kind.'/store', [
                'class_id'=>2, 'room_id'=>[132], 'lesson_id'=>409, 'content_name'=>'Admin '.$label,
                'question_picker'=>2, 'required_lectures'=>0, 'is_file'=>1,
                'start_date'=>'2026-10-23 08:00:00', 'end_date'=>'2026-10-24 08:00:00',
                'mark'=>40, 'period'=>35, 'notes'=>'Original instructions',
            ])->assertRedirect()->assertSessionHasNoErrors();
        }
        $before = DB::table('exams2')->orderBy('id')->get()->toJson();
        $this->actingAs($this->teacher);
        $view = app(\App\Http\Controllers\Teacher\TeacherGradebookController::class)->index(2,132,409)->getData();
        $this->assertSame(['exam','quiz'], $view['assessmentColumns']->pluck('type')->all());
        $this->assertSame(['upcoming','upcoming'], $view['assessmentColumns']->pluck('window')->all());
        $this->assertSame([40.0,40.0], $view['assessmentColumns']->pluck('maximum')->all());
        $this->assertEquals([35,35], $view['assessmentColumns']->pluck('duration')->all());
        $response = $this->get($this->teacherUrl)->assertOk()->assertSee('Admin exam')->assertSee('Admin quiz');
        $response->assertSee(__('gradebook_occurrences.upcoming'))->assertSee(__('gradebook_occurrences.original_maximum'));
        $this->assertStringNotContainsString('<input', $this->occurrenceHtml($response->getContent()));
        $this->assertSame($before, DB::table('exams2')->orderBy('id')->get()->toJson());
        $this->assertSame(0, Exam_result2::count());
        $this->assertSame($config, Storage::get('gradebook/409_6.json'));
        $this->assertSame($status, Storage::get('gradebook_status/2_20.json'));
    }

    public function test_admin_quiz_list_uses_the_same_active_year_term_as_creation_and_teacher_columns()
    {
        $quiz=$this->exam(2,['name'=>'Current-year quiz']);
        $this->exam(2,['term_id'=>17,'name'=>'Wrong-year term quiz']);
        $this->actingAs($this->admin);
        $view=app(\App\Http\Controllers\DashboardController::class)->room_quizes(132)->getData();
        $this->assertSame([$quiz->id],$view['contents']->pluck('id')->all());
        $this->actingAs($this->teacher);
        $teacher=app(\App\Http\Controllers\Teacher\TeacherGradebookController::class)->index(2,132,409)->getData();
        $this->assertSame([$quiz->id],$teacher['assessmentColumns']->pluck('id')->all());
    }

    private function occurrenceHtml($html)
    {
        $dom = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors(); libxml_use_internal_errors($previous);
        $node = (new \DOMXPath($dom))->query('//section[contains(concat(" ",normalize-space(@class)," ")," gb-occurrences ")]')->item(0);
        $this->assertNotNull($node);
        return $dom->saveHTML($node);
    }

    public function test_occurrence_columns_preserve_all_sections_creation_and_exact_receiving_identity()
    {
        $this->actingAs($this->admin);
        foreach (['exams','quizes'] as $role) foreach ([132,133,93] as $room) {
            DB::table('classes_room_role_exams')->insert(['role_id'=>1,'room_id'=>$room,'roles'=>$role]);
        }
        foreach (['exam','quize'] as $kind) {
            $this->post('/SMT/admin/class/room/'.$kind.'/store', [
                'class_id'=>2,'room_id'=>[0],'my_room_id'=>132,'lesson_id'=>409,
                'content_name'=>'All sections '.$kind,'question_picker'=>2,'required_lectures'=>0,'is_file'=>0,
                'start_date'=>'2026-10-23 08:00:00','end_date'=>'2026-10-24 08:00:00','mark'=>20,'period'=>30,
            ])->assertRedirect()->assertSessionHasNoErrors();
        }
        $this->assertSame(4, Exams2::count());
        $this->assertEquals([132,133], Exams2::pluck('room_id')->unique()->values()->all());
        $this->timetablePeriod(166,133,409,6);
        $this->actingAs($this->teacher);
        foreach ([132,133] as $roomId) {
            $view = app(\App\Http\Controllers\Teacher\TeacherGradebookController::class)->index(2,$roomId,409)->getData();
            $this->assertCount(2,$view['assessmentColumns']);
            $this->assertEquals(Exams2::where('room_id',$roomId)->pluck('id')->all(), $view['assessmentColumns']->pluck('id')->all());
            $this->assertEquals([$roomId], $view['assessmentColumns']->pluck('room_id')->unique()->all());
            $this->assertEquals([20], $view['assessmentColumns']->pluck('term_id')->unique()->all());
        }
        $this->assertSame(0,Exam_result2::count());
    }

    public function test_occurrence_window_is_diagnostic_and_all_new_occurrence_writes_remain_denied()
    {
        $this->actingAs($this->teacher);
        $cases = [
            ['2026-10-23 09:00:00','2026-10-24 09:00:00','upcoming'],
            ['2026-10-22 09:00:00','2026-10-22 11:00:00','ongoing'],
            ['2026-10-20 09:00:00','2026-10-21 09:00:00','ended'],
            [null,null,'unknown'], ['bad','2026-10-22 11:00:00','unknown'],
            ['2026-02-31 09:00:00','2026-03-04 09:00:00','unknown'],
            ['2026-10-24 09:00:00','2026-10-23 09:00:00','unknown'],
        ];
        foreach ($cases as $case) $this->exam(1,['start_date'=>$case[0],'end_date'=>$case[1]]);
        GradebookStatusService::setStatus(2,20,'OPEN');
        $view = app(\App\Http\Controllers\Teacher\TeacherGradebookController::class)->index(2,132,409)->getData();
        $this->assertSame(array_column($cases,2), $view['assessmentColumns']->pluck('window')->all());
        foreach ($view['assessmentColumns'] as $column) {
            $payload = ['room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>0,'exam_id'=>$column['id']];
            $this->postJson($this->saveUrl,array_merge($payload,['component_id'=>$column['key']]))->assertNotFound();
            $this->postJson($this->saveUrl,array_merge($payload,['component_id'=>'legacy_exam']))->assertStatus(422);
        }
        $this->assertSame(0,Exam_result2::count());
    }

    public function test_occurrence_columns_scope_all_actual_terms_sections_years_and_subjects()
    {
        $first=$this->exam(2,['name'=>'Same title']); $second=$this->exam(2,['name'=>'Same title']);
        $makeup=$this->exam(1,['name'=>'Makeup <script>alert(1)</script> exam']);
        $zero=$this->result($first,0); $earned=$this->result($makeup,'19.5');
        $this->exam(1,['term_id'=>21,'name'=>'Other actual term']);
        $this->exam(1,['room_id'=>133,'name'=>'Other section']);
        $this->exam(1,['room_id'=>93,'term_id'=>17,'name'=>'Old year']);
        DB::table('lessons')->insert(['id'=>410,'class_id'=>2,'name'=>'Other subject','max_mark'=>100]);
        $this->exam(1,['lesson_id'=>410]);
        $this->dynamic(); $container=$this->exam(1,['name'=>'Dynamic_Section_100','mark'=>20]);
        $this->result($container,12);
        $this->actingAs($this->teacher);
        $view=app(\App\Http\Controllers\Teacher\TeacherGradebookController::class)->index(2,132,409)->getData();
        $columns=$view['assessmentColumns'];
        $this->assertSame([$first->id,$second->id,$makeup->id],$columns->pluck('id')->all());
        $this->assertSame(0.0,$columns[0]['results'][41]['value']);
        $this->assertEquals($zero->id,$columns[0]['results'][41]['result_id']);
        $this->assertArrayNotHasKey(41,$columns[1]['results']);
        $this->assertSame(19.5,$columns[2]['results'][41]['value']);
        $this->assertEquals($earned->id,$columns[2]['results'][41]['result_id']);
        $this->assertSame([$container->id],$view['sourceGradebook']['assessments']->pluck('id')->all());
        $all=$this->read(); // The shared reader still supports every actual term.
        $this->assertTrue($all['assessments']->contains('term_id',21));
        $response=$this->get($this->teacherUrl)->assertOk()->assertDontSee('Other actual term')
            ->assertDontSee('Other section')->assertDontSee('Old year')
            ->assertDontSee('Makeup <script>alert(1)</script> exam',false)
            ->assertSee('Makeup &lt;script&gt;alert(1)&lt;/script&gt; exam',false);
        $html=$this->occurrenceHtml($response->getContent());
        $this->assertSame(3,substr_count($html,'scope="col" data-assessment='));
        $this->assertStringNotContainsString('Dynamic_Section_100',$html);
        $this->assertStringNotContainsString('class="grade-input"',$html);
    }

    public function test_legacy_timing_gap_is_closed_for_traditional_teacher_writes()
    {
        $this->actingAs($this->teacher);
        foreach ([['2026-10-23 09:00:00','2026-10-24 09:00:00'], ['2026-10-20 09:00:00','2026-10-21 09:00:00']] as $dates) {
            $exam=$this->exam(1,['start_date'=>$dates[0],'end_date'=>$dates[1],'mark'=>20]);
            try {app(TeacherAssessmentService::class)->save($exam->id,41,132,409,0);$this->fail('Outside-window mark accepted');}
            catch (\Illuminate\Validation\ValidationException $exception) {$this->assertArrayHasKey('entry_window',$exception->errors());}
            $view=app(\App\Http\Controllers\Teacher\TeacherGradebookController::class)->index(2,132,409)->getData();
            $column=$view['assessmentColumns']->firstWhere('id',$exam->id);
            $this->assertFalse($column['entry_allowed']);
            $this->assertArrayNotHasKey(41,$column['results']);
        }
        $this->assertSame(0,Exam_result2::count());
    }

    public function test_occurrence_projection_uses_one_batch_query_without_changing_summary_or_raw_values()
    {
        $this->dynamic();
        foreach ([10,30,0] as $value) $this->result($this->exam(2,['mark'=>40]),$value);
        foreach ([40,60] as $value) $this->result($this->exam(1,['mark'=>80]),$value);
        $this->result($this->exam(1,['name'=>'Dynamic_Section_100','mark'=>20]),15);
        $read=$this->read(); $before=serialize($read);
        $records=DB::table('exam_result2')->orderBy('id')->get()->toJson();
        DB::enableQueryLog(); DB::flushQueryLog();
        $columns=app(\App\Services\TeacherGradebookAssessmentColumns::class)->forContext($read,Room::find(132),Lesson::find(409),\App\Term_year::find(20));
        $queries=DB::getQueryLog(); DB::disableQueryLog();
        $this->assertCount(4,$queries); // Three explicit fixture models + one batched definition read.
        $this->assertCount(5,$columns);
        $this->assertSame($before,serialize($read));
        $this->assertSame(['legacy_homework'=>13.3,'legacy_exam'=>60.0,'dynamic_a'=>15.0,'total'=>88.3],$read['marks'][41][20]);
        $this->assertNull($read['marks'][42][20]['total']);
        $this->assertSame($records,DB::table('exam_result2')->orderBy('id')->get()->toJson());
    }

    public function test_occurrence_discovery_does_not_relax_membership_or_timetable_authorization()
    {
        $exam=$this->exam(); $this->result($exam,12);
        $this->actingAs($this->teacher)->get($this->teacherUrl)->assertOk();
        DB::table('lesson_room_teacher_lecture_time')->where('teacher_id',166)->delete();
        $this->getJson($this->teacherUrl)->assertForbidden();
    }

    public function test_distribution_bound_changes_and_locking_preserve_existing_occurrence_results()
    {
        $this->actingAs($this->teacher); $payload=$this->dynamic();
        $this->postJson($this->saveUrl,$payload)->assertOk();
        $exam=$this->exam(2,['mark'=>40]); $this->result($exam,35);
        $config=Storage::get('gradebook/409_6.json');
        $before=DB::table('exam_result2')->orderBy('id')->get()->toJson();
        $components=GradebookConfigService::getConfig(409,6)->map(function($c){return (array)$c;})->all();
        $this->actingAs($this->admin);
        foreach ([10,30] as $weight) {
            $proposed=$components; $proposed[3]['weight']=$weight;
            $this->postJson('/SMT/admin/gradebook/settings/update/409',['components'=>$proposed])->assertStatus(422);
        }
        $this->assertSame($config,Storage::get('gradebook/409_6.json'));
        GradebookStatusService::setStatus(2,20,'LOCKED');
        $this->actingAs($this->teacher)->postJson($this->saveUrl,$payload)->assertForbidden();
        $this->get($this->teacherUrl)->assertOk()->assertSee($exam->name);
        $this->assertSame($before,DB::table('exam_result2')->orderBy('id')->get()->toJson());
        $this->assertEquals(40,$exam->fresh()->mark);
    }

    public function test_approved_window_boundaries_are_server_authoritative_and_inclusive()
    {
        $this->actingAs($this->teacher);
        $exam=$this->exam(1,['start_date'=>'2026-10-22 10:00:00','end_date'=>'2026-10-22 11:00:00']);
        GradebookStatusService::setStatus(2,20,'OPEN');
        foreach (['09:59:59'=>false,'10:00:00'=>true,'10:30:00'=>true,'11:00:00'=>true,'11:00:01'=>false] as $time=>$allowed) {
            Carbon::setTestNow(Carbon::parse('2026-10-22 '.$time,config('app.timezone')));
            $request=['student_id'=>41,'exam_id'=>$exam->id,'room_id'=>132,'subject_id'=>409,'value'=>0];
            $response=$this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',$request);
            if ($allowed) $response->assertOk()->assertJsonPath('total',0);
            else $response->assertStatus(422)->assertJsonValidationErrors('entry_window');
        }
        $this->assertSame(1,Exam_result2::count());
        $this->assertSame(1,DB::table('notifications')->count());
        Carbon::setTestNow(Carbon::parse('2026-10-22 07:00:00','UTC'));
        $this->assertTrue(app(\App\Services\AssessmentEntryWindow::class)->state($exam)['allowed']);
    }

    public function test_all_traditional_single_ajax_and_bulk_paths_enforce_the_shared_window()
    {
        $this->actingAs($this->teacher); $expired=$this->exam(2,['end_date'=>'2026-10-22 09:30:00']);
        $row=['exam_id'=>$expired->id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'mark'=>5];
        foreach (['student_save_mark_quize','student_save_mark2','student_save_mark3'] as $route) {
            $this->postJson('/SMARMANger/dashboard/teacher/'.$route,$row)->assertStatus(422)->assertJsonValidationErrors('entry_window');
        }
        $active=$this->exam(2); $first=array_merge($row,['exam_id'=>$active->id]);
        $bulk='/SMARMANger/dashboard/teacher/student_save_mark_bulk';
        $this->postJson($bulk,['kind'=>'exam2','rows'=>json_encode([$first,array_merge($row,['user_id'=>42])])])->assertStatus(422);
        $this->assertSame(0,Exam_result2::count());
        $this->post($bulk,['kind'=>'exam2','rows'=>json_encode([$first,array_merge($first,['user_id'=>42,'mark'=>0])])])
            ->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame(2,Exam_result2::count());
        foreach ([null,'bad','2026-02-31 09:00:00'] as $date) {
            $invalid=$this->exam(1,['start_date'=>$date]);
            $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark2',array_merge($row,['exam_id'=>$invalid->id]))->assertStatus(422);
        }
    }

    public function test_occurrence_entry_synchronizes_both_interfaces_and_retry_does_not_duplicate_results_or_notifications()
    {
        $this->actingAs($this->teacher); $exam=$this->exam(1,['question_picker'=>2]);
        GradebookStatusService::setStatus(2,20,'OPEN');
        $legacy=['exam_id'=>$exam->id,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'mark'=>0];
        $this->post('/SMARMANger/dashboard/teacher/student_save_mark_quize',$legacy)->assertRedirect()->assertSessionHasNoErrors();
        $id=Exam_result2::first()->id;
        $view=$this->get($this->teacherUrl)->assertOk()->assertSee('data-exam="'.$exam->id.'"',false);
        $this->assertSame(0.0,$view->viewData('assessmentColumns')->first()['results'][41]['value']);
        $url='/SMARMANger/dashboard/teacher/gradebook/assessment/save';
        $payload=['student_id'=>41,'exam_id'=>$exam->id,'room_id'=>132,'subject_id'=>409,'value'=>100];
        $this->postJson($url,$payload)->assertOk()->assertJsonPath('result_id',$id)->assertJsonPath('total',100);
        $this->postJson($url,$payload)->assertOk()->assertJsonPath('result_id',$id);
        $this->assertSame(1,Exam_result2::count()); $this->assertSame(2,DB::table('notifications')->count());
        $this->get('/SMARMANger/dashboard/teacher/teacher_exam_students/132/166/409/'.$exam->id)
            ->assertOk()->assertSee('value="100"',false);
        foreach ([null,-1,101] as $invalid) $this->postJson($url,array_merge($payload,['value'=>$invalid]))->assertStatus(422);
        $this->assertEquals(100,Exam_result2::first()->result);
        $this->result($exam,20);
        $this->postJson($url,$payload)->assertStatus(422);
        $this->assertSame(2,DB::table('notifications')->count());
    }

    public function test_automated_corrections_and_historical_boundaries_are_not_reinterpreted_as_new_gradebook_entry()
    {
        $this->actingAs($this->teacher);
        $exam=$this->exam(1,['is_file'=>0,'end_date'=>'2026-10-21 10:00:00']);
        $result=app(TeacherAssessmentService::class)->save($exam->id,41,132,409,12);
        $this->post('/SMARMANger/dashboard/exam/update_result1',[
            'exam_result_id'=>$result->id,'exam'=>$exam->id,'traditional_result'=>[3],'mark'=>[4],
        ])->assertRedirect();
        $this->assertEquals(7,$result->fresh()->result);
        GradebookStatusService::setStatus(2,20,'OPEN');
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'student_id'=>41,'exam_id'=>$exam->id,'room_id'=>132,'subject_id'=>409,'value'=>8,
        ])->assertStatus(422)->assertJsonValidationErrors('entry_window');
        $old=$this->exam(1,['room_id'=>93,'term_id'=>17]);
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark_quize',[
            'user_id'=>41,'exam_id'=>$old->id,'room_id'=>93,'lesson_id'=>409,'mark'=>12,
        ])->assertForbidden();
        $this->assertEquals(7,$result->fresh()->result);
    }

    public function test_new_occurrence_action_rejects_tampered_context_membership_and_locked_or_carried_entry()
    {
        $exam=$this->exam(); $this->actingAs($this->teacher); GradebookStatusService::setStatus(2,20,'OPEN');
        $url='/SMARMANger/dashboard/teacher/gradebook/assessment/save';
        $payload=['student_id'=>41,'exam_id'=>$exam->id,'room_id'=>132,'subject_id'=>409,'value'=>10];
        foreach ([['room_id'=>133],['student_id'=>999],['subject_id'=>999]] as $bad) {
            $response=$this->postJson($url,array_merge($payload,$bad));
            $this->assertContains($response->status(),[403,404]);
        }
        $other=$this->exam(1,['room_id'=>133]);
        $this->postJson($url,array_merge($payload,['exam_id'=>$other->id]))->assertForbidden();
        GradebookStatusService::setStatus(2,20,'LOCKED'); $this->postJson($url,$payload)->assertOk();
        GradebookStatusService::setStatus(2,20,'OPEN');
        DB::table('room_student')->where('student_id',41)->update(['room_id'=>133]);
        DB::table('student_academic_placements')->where('student_id',41)->update(['room_id'=>133]);
        $this->postJson($url,$payload)->assertForbidden();
        $this->assertContains($this->actingAs($this->admin)->postJson($url,$payload)->status(),[302,403]);
        $this->assertSame(1,Exam_result2::count()); // Original entry is independent of the manual lock.
    }

    public function test_admin_modal_input_round_trip_rejects_bad_dates_bounds_and_long_notes_without_partial_insert()
    {
        $this->actingAs($this->admin);
        $payload=['class_id'=>2,'my_room_id'=>132,'room_id'=>[132],'lesson_id'=>409,'content_name'=>'مذاكرة مراجعة',
            'question_picker'=>2,'required_lectures'=>'الفصل الأول','is_file'=>1,'mark'=>20,'period'=>40,
            'start_date'=>'2026-10-22T09:00','end_date'=>'2026-10-22T11:00:30','notes'=>'ملاحظات'];
        foreach (['exam','quize'] as $kind) {
            $url='/SMT/admin/class/room/'.$kind.'/store';
            foreach ([['end_date'=>'2026-10-22T08:00'],['end_date'=>'bad'],['start_date'=>'2026-02-31T09:00'],
                ['mark'=>2.5],['period'=>-1],['is_file'=>9],['notes'=>str_repeat('س',100)]] as $bad) {
                $this->postJson($url,array_merge($payload,$bad))->assertStatus(422);
            }
            $this->assertSame($kind === 'exam' ? 0 : 1,Exams2::count());
            $this->postJson($url,$payload)->assertOk()->assertJsonPath('success',true);
            $record=Exams2::orderByDesc('id')->first();
            $this->assertSame('2026-10-22 09:00:00',$record->start_date);
            $this->assertSame('2026-10-22 11:00:30',$record->end_date);
            $this->assertSame('ملاحظات',$record->notes);
            $page=$this->get('/SMT/admin/class/room/'.($kind === 'quize' ? 'quizes' : 'exams').'/132')->assertOk();
            $page->assertSee('id="assessment-create"',false)->assertSee('id="assessment-edit"',false)
                ->assertSee('assessment-editor.js')->assertDontSee('jquery-3.4.1.min.js')->assertDontSee('@include',false);
        }
    }

    public function test_admin_edit_protects_original_context_mode_maximum_and_requires_confirmation_to_reschedule_results()
    {
        $exam=$this->exam(2,['question_picker'=>2,'period'=>40,'required'=>'Work','notes'=>'Before','file'=>'keep.pdf']);
        $record=$this->result($exam,35); $before=$record->getRawOriginal();
        $this->actingAs($this->admin);
        $payload=['quize_id'=>$exam->id,'room_id'=>132,'lesson_id'=>409,'content_name'=>'Updated title',
            'question_picker'=>2,'required_lectures'=>'Updated work','is_file'=>1,'mark'=>100,'period'=>40,
            'start_date'=>'2026-10-22T09:00:00','end_date'=>'2026-10-22T11:00:00','notes'=>'After'];
        $url='/SMT/admin/class/room/quize/update';
        foreach ([['room_id'=>133],['mark'=>50],['mark'=>200],['is_file'=>0],['question_picker'=>1],['period'=>41]] as $bad) {
            $this->postJson($url,array_merge($payload,$bad))->assertStatus(422);
        }
        $this->postJson('/SMT/admin/class/room/exam/update',array_merge($payload,['exam_id'=>$exam->id]))->assertStatus(422);
        $this->postJson($url,$payload)->assertOk()->assertJsonPath('success',true);
        $this->assertSame('Updated title',$exam->fresh()->name);
        $this->assertSame('keep.pdf',$exam->fresh()->file);
        $reschedule=array_merge($payload,['end_date'=>'2026-10-22T12:00:00']);
        $this->postJson($url,$reschedule)->assertStatus(422)->assertJsonValidationErrors('confirm_window_change');
        $this->postJson($url,array_merge($reschedule,['confirm_window_change'=>1]))->assertOk();
        $this->assertSame('2026-10-22 12:00:00',$exam->fresh()->end_date);
        $this->assertSame($before,$record->fresh()->getRawOriginal());
    }

    private function adminCreationPayload()
    {
        return ['class_id'=>2,'my_room_id'=>132,'room_id'=>[132],'lesson_id'=>409,'content_name'=>'New original quiz',
            'question_picker'=>2,'required_lectures'=>'Work','is_file'=>1,'mark'=>50,'period'=>40,
            'start_date'=>'2026-10-22T09:00:16','end_date'=>'2026-10-22T11:00:21','notes'=>''];
    }

    public function test_quiz_modal_section_modes_preserve_single_multiple_and_permission_scoped_all_contexts()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        $payload=$this->adminCreationPayload();
        foreach (['quize'=>'quizes','exam'=>'exams'] as $kind=>$list) {
            $url='/SMT/admin/class/room/'.$kind.'/store';
            $page=$this->get('/SMT/admin/class/room/'.$list.'/132')->assertOk();
            $this->assertCount(0,$page->viewData('assessmentAllowedAllRooms'));
            $page->assertSee(__('assessment_entry.no_allowed_sections'));
            $this->postJson($url,array_merge($payload,['room_id'=>[0]]))->assertStatus(422)
                ->assertJsonValidationErrors('room_id')->assertJsonFragment(['room_id'=>[__('assessment_entry.no_allowed_sections')]]);
            $this->postJson($url,array_merge($payload,['room_id'=>[0,132]]))->assertStatus(422)
                ->assertJsonValidationErrors('room_id');
            foreach ([132,133,93] as $room) DB::table('classes_room_role_exams')->insert(['role_id'=>1,'room_id'=>$room,'roles'=>$list]);
            $page=$this->get('/SMT/admin/class/room/'.$list.'/132')->assertOk();
            $this->assertEquals([132,133],$page->viewData('assessmentAllowedAllRooms')->pluck('id')->all());
            $before=Exams2::count();
            foreach ([[132],[132,133],[0]] as $selection) {
                $this->postJson($url,array_merge($payload,['room_id'=>$selection]))->assertOk()->assertJsonPath('success',true);
            }
            $this->assertSame($before+5,Exams2::count());
            $this->assertSame(0,Exams2::where('room_id',93)->count());
        }
        $this->assertSame(8,DB::table('assessment_equivalence_members')->count());
        $this->assertSame(0,Exam_result2::count());
    }

    public function test_quiz_modal_precise_context_errors_preserve_valid_entered_values_without_creating_records()
    {
        $this->actingAs($this->admin);$payload=$this->adminCreationPayload();
        DB::table('classes')->insert(['id'=>3,'name'=>'Other class']);
        DB::table('lessons')->insert(['id'=>410,'class_id'=>3,'name'=>'Other subject']);
        DB::table('rooms')->insert(['id'=>134,'class_id'=>3,'year_id'=>6,'name'=>'Other section']);
        foreach (['quize','exam'] as $kind) {
            $url='/SMT/admin/class/room/'.$kind.'/store';
            foreach ([['lesson_id'=>410],['room_id'=>[134]],['room_id'=>[93]],['my_room_id'=>93],['class_id'=>3]] as $bad) {
                $this->postJson($url,array_merge($payload,$bad))->assertStatus(422);
            }
            $from='/SMT/admin/class/room/'.($kind==='quize'?'quizes':'exams').'/132';
            $this->from($from)->post($url,array_merge($payload,['_assessment_modal'=>'assessment-create','room_id'=>[0]]))
                ->assertRedirect($from)->assertSessionHasErrors('room_id')->assertSessionHasInput('content_name','New original quiz');
            $this->get($from)->assertOk()->assertSee('New original quiz')->assertSee('data-validation=',false);
        }
        DB::table('term_years')->where('year_id',6)->update(['current_term'=>0]);
        $this->postJson('/SMT/admin/class/room/quize/store',$payload)->assertStatus(422)->assertJsonValidationErrors('room_id');
        $this->assertSame(0,Exams2::count());
    }

    public function test_assessment_delete_uses_the_existing_account_code_not_a_different_login_password_and_never_flashes_it()
    {
        $account=$this->account(2,['role_id'=>1,'password'=>\Hash::make('different-login-fixture'),'view_password'=>'deletion-fixture']);
        $this->actingAs($account);$exam=$this->exam(2);$url='/SMT/admin/class/room/exam_quize/delete';
        foreach ([null,'different-login-fixture',['bad']] as $code) {
            $this->postJson($url,['content_id'=>$exam->id,'delete_code'=>$code])->assertStatus(422)->assertJsonValidationErrors('delete_code');
            $this->assertDatabaseHas('exams2',['id'=>$exam->id]);
        }
        $from='/SMT/admin/class/room/quizes/132';
        $this->from($from)->post($url,['content_id'=>$exam->id,'delete_code'=>'private-wrong-fixture'])
            ->assertRedirect($from)->assertSessionHasErrors('delete_code')->assertSessionMissing('_old_input.delete_code');
        $this->get($from)->assertOk()->assertSee('id="assessment-delete"',false)
            ->assertSee(__('assessment_entry.delete_invalid'))->assertDontSee('private-wrong-fixture')->assertDontSee('deletion-fixture');
        $this->postJson($url,['content_id'=>$exam->id,'delete_code'=>'deletion-fixture'])->assertOk()->assertJsonPath('success',true);
        $this->assertDatabaseMissing('exams2',['id'=>$exam->id]);
        $this->assertSame('deletion-fixture',$account->fresh()->view_password);
        $empty=$this->account(2,['role_id'=>1,'view_password'=>null]);$this->actingAs($empty);$exam=$this->exam(1);
        $this->postJson($url,['content_id'=>$exam->id,'delete_code'=>'x'])->assertStatus(422);
        $this->assertDatabaseHas('exams2',['id'=>$exam->id]);
    }

    public function test_assessment_deletion_feedback_retains_results_files_and_equivalence_and_authorization()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        $url='/SMT/admin/class/room/exam_quize/delete';
        $marked=$this->exam(2);$record=$this->result($marked,0);$snapshot=$record->getRawOriginal();
        $uploaded=$this->exam(2);DB::table('exams_files')->insert(['exam_id'=>$uploaded->id,'student_id'=>41,'file'=>'keep.pdf']);
        $a=$this->exam(2);$b=$this->exam(2,['room_id'=>133]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified originals');
        foreach ([$marked,$uploaded,$a] as $exam) {
            $this->postJson($url,['content_id'=>$exam->id,'delete_code'=>'test-delete'])->assertStatus(422)
                ->assertJsonFragment(['assessment'=>[__('assessment_entry.delete_protected')]]);
            $this->assertDatabaseHas('exams2',['id'=>$exam->id]);
        }
        $this->assertSame($snapshot,$record->fresh()->getRawOriginal());
        $this->assertSame(1,DB::table('exams_files')->count());$this->assertSame(2,DB::table('assessment_equivalence_members')->count());
        foreach ([$this->teacher,$this->account(8)] as $account) {
            $this->actingAs($account);$response=$this->postJson($url,['content_id'=>$a->id,'delete_code'=>'test-delete']);
            $this->assertContains($response->status(),[302,403]);
        }
        auth()->logout();$this->postJson($url,['content_id'=>$a->id,'delete_code'=>'test-delete'])->assertStatus(401);
        $this->assertDatabaseHas('exams2',['id'=>$a->id]);
        $this->actingAs($this->admin);
        $this->app->bind(\App\Http\Middleware\VerifyCsrfToken::class,function($app) {
            return new class($app,$app['encrypter']) extends \App\Http\Middleware\VerifyCsrfToken {
                protected function runningUnitTests() { return false; }
            };
        });
        $this->postJson($url,['content_id'=>$a->id,'delete_code'=>'test-delete'])->assertStatus(419)
            ->assertSessionMissing('_old_input.delete_code');
        $this->assertDatabaseHas('exams2',['id'=>$a->id]);
    }

    public function test_quiz_2428_conflict_is_row_scoped_and_independent_quizzes_keep_their_own_results()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        $quiz=$this->exam(2,['id'=>2428,'name'=>'Independent quiz']);$peer=$this->exam(2,['room_id'=>133]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$quiz->id,$peer->id],'Explicit sections');
        $different=$this->exam(2,['name'=>'Independent quiz']);
        DB::table('student_academic_placements')->where('student_id',42)->update(['room_id'=>133,'updated_at'=>now()->subHour()]);
        DB::table('room_student')->insert(['student_id'=>42,'year_id'=>6,'room_id'=>132,'updated_at'=>now()]);
        $this->actingAs($this->teacher);
        $url='/SMARMANger/dashboard/teacher/teacher_quize_students/132/166/409/2428';
        $response=$this->get($url)->assertOk()->assertSee(__('assessment_entry.placement_conflict'))
            ->assertSee(__('assessment_entry.conflict_read_only'))->assertDontSee(__('gradebook.carried_read_only'))
            ->assertSee('Grade 2')->assertSee('Section 132')->assertSee('English')->assertSee('Independent quiz');
        $this->assertCount(1,$this->traditionalEntryInputs($response->getContent()));
        $advanced=$this->get($this->teacherUrl)->assertOk();
        $column=$advanced->viewData('assessmentColumns')->firstWhere('id',2428);
        $this->assertSame('placement_context',$column['results'][42]['reason']);
        $this->assertSame('missing',$column['results'][41]['state']);
        $this->assertSame(0,Exam_result2::count());
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',[
            'exam_id'=>2428,'room_id'=>132,'lesson_id'=>409,'user_id'=>41,'mark'=>12,
        ])->assertOk();
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',[
            'exam_id'=>2428,'room_id'=>132,'lesson_id'=>409,'user_id'=>42,'mark'=>12,
        ])->assertStatus(422);
        $independent=$this->get($this->teacherUrl)->assertOk()->viewData('assessmentColumns')->firstWhere('id',$different->id);
        $this->assertArrayNotHasKey(41,$independent['results']);
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$different->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>0,
        ])->assertOk();
        $this->assertSame(2,Exam_result2::count());
        $this->assertEquals(12,Exam_result2::where('exam_id',2428)->value('result'));
        $this->assertEquals(0,Exam_result2::where('exam_id',$different->id)->value('result'));
    }

    public function test_quiz_and_exam_edit_confirmation_uses_canonical_seconds_and_only_retained_records()
    {
        $this->actingAs($this->admin);
        foreach ([1=>'exam', 2=>'quize'] as $type=>$kind) {
            $exam = $this->exam($type, ['question_picker'=>2, 'period'=>40, 'required'=>'Work',
                'start_date'=>'2026-10-22 09:03:45', 'end_date'=>'2026-10-22 11:00:58']);
            $payload = [$kind.'_id'=>$exam->id, 'room_id'=>132, 'lesson_id'=>409, 'content_name'=>'Normal edit',
                'question_picker'=>2, 'required_lectures'=>'Work', 'is_file'=>1, 'mark'=>100, 'period'=>40,
                'start_date'=>'2026-10-22T09:03:45', 'end_date'=>'2026-10-22T11:00:58'];
            $url = '/SMT/admin/class/room/'.$kind.'/update';
            $this->postJson($url,$payload)->assertOk();
            $payload['end_date'] = '2026-10-22T12:00:58';
            $this->postJson($url,$payload)->assertOk(); // No records: no confirmation.
            $record = $this->result($exam->fresh(), 0);
            $before = $record->getRawOriginal();
            $this->postJson($url,$payload)->assertOk(); // Unchanged, nonzero seconds.
            $payload['end_date'] = '2026-10-22T12:00:59';
            $this->postJson($url,$payload)->assertStatus(422)->assertJsonValidationErrors('confirm_window_change');
            $this->assertSame('2026-10-22 12:00:58',$exam->fresh()->end_date);
            $this->postJson($url,$payload+['confirm_window_change'=>1])->assertOk();
            $this->assertSame($before,$record->fresh()->getRawOriginal());
            // Stored local formats representing the same instant are not a reschedule.
            $definition = $exam->fresh();
            $definition->start_date = '2026-10-22T09:03:45';
            $definition->end_date = '2026-10-22 12:00:59';
            app(\App\Services\AdminAssessmentInput::class)->validate(new \Illuminate\Http\Request($payload),$type,$definition);
        }
    }

    public function test_teacher_correction_cannot_bypass_a_traditional_window_or_swap_definition_ids()
    {
        $exam=$this->exam(1,['end_date'=>'2026-10-22 09:30:00']); $record=$this->result($exam,20);
        $other=$this->exam(); $this->actingAs($this->teacher);
        $payload=['exam_result_id'=>$record->id,'exam'=>$exam->id,'traditional_result'=>[5],'mark'=>[4]];
        $url='/SMARMANger/dashboard/exam/update_result1';
        $this->postJson($url,$payload)->assertStatus(422)->assertJsonValidationErrors('entry_window');
        $this->postJson($url,array_merge($payload,['exam'=>$other->id]))->assertForbidden();
        $this->assertEquals(20,$record->fresh()->result);
    }

    public function test_teacher_question_authoring_does_not_reconfigure_traditional_admin_definitions()
    {
        $exam=$this->exam(); $before=$exam->getRawOriginal();
        $this->actingAs($this->teacher)->postJson('/SMARMANger/dashboard/teacher/exams/myquestions1',[
            'room_id'=>[$exam->id],'selected_ques1'=>[999],
        ])->assertForbidden();
        $this->assertSame($before,$exam->fresh()->getRawOriginal());
    }

    public function test_admin_modal_non_ajax_validation_restores_values_and_old_sections_are_not_operational()
    {
        $this->actingAs($this->admin);
        $url='/SMT/admin/class/room/quizes/132';
        $this->from($url)->post('/SMT/admin/class/room/quize/store',[
            '_assessment_modal'=>'assessment-create','class_id'=>2,'my_room_id'=>132,'room_id'=>[132],
            'lesson_id'=>409,'content_name'=>'اسم محفوظ','question_picker'=>2,'required_lectures'=>'عمل محفوظ',
            'is_file'=>1,'mark'=>20,'period'=>40,'start_date'=>'2026-10-22T10:00:00','end_date'=>'2026-10-22T09:00:00','notes'=>'ملاحظة محفوظة',
        ])->assertRedirect($url)->assertSessionHasErrors('end_date');
        $page=$this->get($url)->assertOk()->assertSee('اسم محفوظ')->assertSee('عمل محفوظ')->assertSee('ملاحظة محفوظة')
            ->assertSee('data-restore="1"',false)->assertSee('value="2026-10-22T10:00:00"',false);
        $this->assertSame(1,substr_count($page->getContent(),'data-restore="1"'));
        $this->assertSame(0,Exams2::count());
        foreach (['quizes','exams'] as $kind) $this->get('/SMT/admin/class/room/'.$kind.'/93')->assertNotFound();
    }

    public function test_unification_original_windows_ignore_manual_lock_but_manual_marks_do_not()
    {
        $manual = $this->dynamic();
        GradebookStatusService::setStatus(2,20,'LOCKED');
        $this->actingAs($this->teacher);
        $this->postJson($this->saveUrl,$manual)->assertForbidden();
        foreach ([1,2] as $type) {
            $exam = $this->exam($type);
            $response = $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
                'student_id'=>41,'exam_id'=>$exam->id,'room_id'=>132,'subject_id'=>409,'value'=>0]);
            $response->assertOk()->assertJsonPath('exam_id',$exam->id)->assertJsonPath('value',0);
            $this->get($this->teacherUrl)->assertOk()->assertSee('data-exam="'.$exam->id.'"',false);
            DB::table('exams2')->where('id',$exam->id)->update(['end_date'=>'2026-10-22 09:59:59']);
            $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
                'student_id'=>41,'exam_id'=>$exam->id,'room_id'=>132,'subject_id'=>409,'value'=>5])
                ->assertStatus(422)->assertJsonValidationErrors('entry_window');
            $this->assertDatabaseHas('exam_result2',['exam_id'=>$exam->id,'user_id'=>41,'result'=>0]);
        }
    }

    public function test_unification_legacy_ajax_bulk_is_atomic_and_non_json_fallback_survives()
    {
        $exam = $this->exam(2);
        $row = ['exam_id'=>$exam->id,'room_id'=>132,'lesson_id'=>409,'user_id'=>41,'mark'=>0];
        $url = '/SMARMANger/dashboard/teacher/student_save_mark_bulk';
        $this->actingAs($this->teacher);
        $this->postJson($url,['kind'=>'exam2','rows'=>json_encode([$row,$row])])->assertStatus(422);
        $this->assertSame(0,Exam_result2::count());
        $bad = array_merge($row,['user_id'=>42,'mark'=>101]);
        $this->postJson($url,['kind'=>'exam2','rows'=>json_encode([$row,$bad])])->assertStatus(422);
        $this->assertSame(0,Exam_result2::count());
        $second = array_merge($row,['user_id'=>42,'mark'=>25.5]);
        $response = $this->postJson($url,['kind'=>'exam2','rows'=>json_encode([$row,$second])]);
        $response->assertOk()->assertJsonPath('saved',2)->assertJsonCount(2,'rows');
        $ids = Exam_result2::orderBy('id')->pluck('id')->all();
        $this->postJson($url,['kind'=>'exam2','rows'=>json_encode([$row,$second])])->assertOk();
        $this->assertSame($ids,Exam_result2::orderBy('id')->pluck('id')->all());
        $this->post($url,['kind'=>'exam2','rows'=>json_encode([$second])])->assertRedirect();
        $this->postJson($url,['kind'=>'exam2','rows'=>'broken'])->assertStatus(422);
    }

    public function test_unification_single_json_response_and_retry_do_not_duplicate_notifications()
    {
        $exam = $this->exam(2);
        $payload = ['exam_id'=>$exam->id,'room_id'=>132,'lesson_id'=>409,'user_id'=>41,'mark'=>0];
        $this->actingAs($this->teacher);
        Storage::put('gradebook/409_6.json',json_encode(['components'=>[true]]));
        foreach (['student_save_mark_quize','student_save_mark3','student_save_mark2'] as $route) {
            $this->postJson('/SMARMANger/dashboard/teacher/'.$route,$payload)->assertOk()
                ->assertJsonPath('value',0)->assertJsonPath('student_id',41)->assertJsonPath('exam_id',$exam->id);
        }
        $this->assertSame(1,Exam_result2::count());
        $this->assertSame(1,DB::table('notifications')->count());
        $this->post('/SMARMANger/dashboard/teacher/student_save_mark_quize',$payload)->assertRedirect();
        $this->assertSame(1,DB::table('notifications')->count());
    }

    public function test_unification_manual_fields_require_real_source_and_lossless_integer_bound()
    {
        $manual = $this->dynamic();
        $this->actingAs($this->teacher);
        $manual['component_id'] = 'legacy_oral';
        $this->postJson($this->saveUrl,$manual)->assertStatus(422);
        $manual['component_id'] = 'dynamic_a';
        DB::table('lessons')->where('id',409)->update(['max_mark'=>37]); // 20% cannot materialize an integer maximum.
        $this->postJson($this->saveUrl,$manual)->assertStatus(422);
        $this->assertSame(0,Exams2::count());
    }

    private function account($type, array $attributes = [])
    {
        $id = DB::table('users')->insertGetId(array_merge(['name'=>'Isolated account','email'=>uniqid().'@test.local','password'=>'unused','type'=>$type], $attributes));
        return User::findOrFail($id);
    }

    private function studentUiFixture()
    {
        foreach (['school_data','student_details','certificates'] as $table) {
            if (!Schema::hasTable($table)) Schema::create($table,function(Blueprint $s) {
                $s->increments('id');$s->integer('student_id')->nullable();$s->integer('room_id')->nullable();
            });
        }
        return $this->account(0,['student_id'=>41]);
    }

    public function test_student_e2e_admin_original_teacher_first_save_edit_zero_and_compact_result_cards_for_both_types()
    {
        $student=$this->studentUiFixture();
        foreach (['quize'=>2,'exam'=>1] as $kind=>$type) {
            $this->actingAs($this->admin)->postJson('/SMT/admin/class/room/'.$kind.'/store',[
                'class_id'=>2,'my_room_id'=>132,'room_id'=>[132],'lesson_id'=>409,'content_name'=>'Student original '.$kind,
                'question_picker'=>2,'required_lectures'=>0,'is_file'=>1,'mark'=>50,'period'=>40,
                'start_date'=>'2026-10-22 09:00:00','end_date'=>'2026-10-22 11:00:00',
            ])->assertOk();
            $exam=Exams2::where('type',$type)->firstOrFail();
            $list='/SMARMANger/dashboard/student/room/'.($type===1?'main_exams':'main_quizes').'/132/41';
            $this->actingAs($this->teacher)->get('/SMARMANger/dashboard/teacher/teacher_'.($type===1?'exam':'quize').'/132/166/409')
                ->assertOk()->assertSee('Student original '.$kind);
            $before=Exam_result2::count();
            $response=$this->actingAs($student)->get($list)->assertOk()->assertSee('Student original '.$kind)
                ->assertSee(__('student_assessments.unentered'))->assertSee('English');
            $this->assertSame($before,Exam_result2::count());
            $this->assertStringNotContainsString('sp-assessment-card__meta',$response->getContent());
            $this->assertStringNotContainsString('sp-assessment-card__number',$response->getContent());
            $this->actingAs($this->teacher)->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
                'exam_id'=>$exam->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>0,
            ])->assertOk();
            $row=Exam_result2::where('exam_id',$exam->id)->firstOrFail();
            $this->assertEquals(1,$row->show_result);
            $this->actingAs($student)->get($list)->assertOk()->assertSee('0 / 50');
            $detail='/SMARMANger/dashboard/student/view/main_exam/'.$exam->id;
            $this->get($detail)->assertOk()->assertViewIs('students.assessment_result')->assertSee('0 / 50')->assertSee('English');
            $this->actingAs($this->teacher)->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',[
                'exam_id'=>$exam->id,'room_id'=>132,'lesson_id'=>409,'user_id'=>41,'exam_result_id'=>$row->id,'mark'=>23,
            ])->assertOk()->assertJsonPath('result_id',$row->id);
            $this->actingAs($student)->get($detail)->assertOk()->assertSee('23 / 50');
            $this->assertSame($row->id,Exam_result2::where('exam_id',$exam->id)->first()->id);
        }
        $this->assertSame(2,Exam_result2::count());
    }

    public function test_student_quiz_and_exam_routes_redact_published_cards_and_direct_results_for_both_flag_states()
    {
        $student = $this->studentUiFixture();
        foreach ([1 => 'main_exams', 2 => 'main_quizes'] as $type => $path) {
            $published = $this->exam($type, ['name'=>'Published '.$path, 'mark'=>900]);
            $this->result($published, '817.25');
            $unpublished = $this->exam($type, ['name'=>'Unpublished '.$path]);
            $this->result($unpublished, '83.75', ['show_result'=>0]);
            $incomplete = $this->exam($type, ['name'=>'Incomplete '.$path]);
            $this->result($incomplete, '72.125', ['status'=>0]);
            $other = $this->exam($type, ['name'=>'Other student '.$path]);
            $this->result($other, '941.125', ['user_id'=>42]);
            $before = DB::table('exam_result2')->orderBy('id')->get()->toJson();
            $this->actingAs($student);
            foreach ([false, true] as $enabled) {
                config(['student_results.student_pages_enabled'=>$enabled]);
                $url = '/SMARMANger/dashboard/student/room/'.$path.'/132/41';
                foreach ([false, true] as $json) {
                    $response = ($json ? $this->getJson($url) : $this->get($url))->assertOk()
                        ->assertSee('English')->assertSee($published->name)
                        ->assertDontSee('83.75')->assertDontSee('72.125')->assertDontSee('941.125');
                    $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
                    $card = $response->viewData('exams')->firstWhere('id', $published->id);
                    if ($enabled) {
                        $response->assertSee('817.25 / 900')
                            ->assertSee('/student/view/main_exam/'.$published->id, false);
                        $this->assertSame('earned', $card->result_state);
                    } else {
                        $response->assertDontSee('817.25')->assertSee(__('student_assessments.hidden'));
                        $this->assertNull($card->result_value);
                        $this->assertNull($card->result_exam_id);
                        $this->assertStringNotContainsString('817.25', json_encode($response->viewData('exams')));
                        $this->assertStringNotContainsString('/student/view/main_exam/', $response->getContent());
                    }
                    $detail = '/SMARMANger/dashboard/student/view/main_exam/'.$published->id;
                    $direct = ($json ? $this->getJson($detail) : $this->get($detail))->assertOk();
                    if ($enabled) $direct->assertSee('817.25');
                    else $direct->assertDontSee('817.25');
                }
                $this->get('/SMARMANger/dashboard/student/view/main_exam/'.$unpublished->id)->assertOk()->assertDontSee('83.75');
                $this->get('/SMARMANger/dashboard/student/view/main_exam/'.$incomplete->id)->assertOk()->assertDontSee('72.125');
                $this->get('/SMARMANger/dashboard/student/view/main_exam/'.$other->id)->assertNotFound();
            }
            $this->assertSame($before, DB::table('exam_result2')->orderBy('id')->get()->toJson());
        }
    }

    public function test_traditional_cards_have_no_disclosure_or_file_actions_while_automated_actions_remain()
    {
        $student = $this->studentUiFixture();
        $this->actingAs($student);
        config(['student_results.student_pages_enabled'=>false]);
        foreach ([1 => 'main_exams', 2 => 'main_quizes'] as $type => $path) {
            $traditional = $this->exam($type, ['name'=>'Traditional '.$path,
                'required'=>'Traditional instructions', 'file'=>'traditional-handout.pdf']);
            $automated = $this->exam($type, ['is_file'=>0, 'name'=>'Automated '.$path,
                'required'=>'Automated instructions', 'file'=>'automated-handout.pdf']);
            $this->result($automated, null, ['status'=>0]);
            $before = DB::table('exams2')->orderBy('id')->get()->toJson();
            $response = $this->get('/SMARMANger/dashboard/student/room/'.$path.'/132/41')
                ->assertOk()->assertSee('Traditional '.$path)->assertSee('Automated '.$path)
                ->assertSee('English')->assertDontSee('traditional-handout.pdf')
                ->assertDontSee('Traditional instructions')->assertDontSee('uploadFilesModal')
                ->assertDontSee('رفع الحل')->assertSee('automated-handout.pdf')
                ->assertSee('/student/start_main_exam/'.$automated->id, false);
            $dom = new \DOMDocument();
            $dom->loadHTML('<?xml encoding="UTF-8">'.$response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new \DOMXPath($dom);
            $traditionalCard = '//article[.//p[text()="Traditional '.$path.'"]]';
            $automatedCard = '//article[.//p[text()="Automated '.$path.'"]]';
            $this->assertSame(1, $xpath->query($traditionalCard)->length);
            $this->assertSame(0, $xpath->query($traditionalCard.'//details | '.$traditionalCard.'//summary | '.$traditionalCard.'//button')->length);
            $this->assertSame(1, $xpath->query($automatedCard.'//a[contains(@href,"/start_main_exam/")]')->length);
            $this->assertSame(1, $xpath->query($automatedCard.'//details')->length);
            $this->assertSame($before, DB::table('exams2')->orderBy('id')->get()->toJson());
            $this->assertTrue(app('router')->has('dashboard.student.upload_exam_files'));
        }
    }

    public function test_student_privacy_false_redacts_all_targeted_html_json_history_and_download_views_without_mutation()
    {
        $student=$this->studentUiFixture();$exam=$this->exam(2,['mark'=>900]);$this->result($exam,'817.25');
        $this->scaffold();
        DB::table('students_marks')->where('student_id',41)->update(['result1'=>json_encode([409=>'817.25'])]);
        DB::table('report_cards')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>132,'final_result'=>'817.25','student_attendance'=>'92%']);
        $placement=DB::table('student_academic_placements')->where('student_id',41)->value('id');
        $before=DB::table('exam_result2')->get()->toJson();$marks=DB::table('students_marks')->get()->toJson();
        config(['student_results.student_pages_enabled'=>false]);$this->actingAs($student);
        foreach (['/room/main_quizes/132/41','/room/main_exams/132/41','/view/main_exam/'.$exam->id,
            '/results/41','/medals/41','/view/report/card','/academic-record/'.$placement] as $suffix) {
            $url='/SMARMANger/dashboard/student'.$suffix;
            foreach ([false,true] as $json) {
                $response=$json?$this->getJson($url):$this->get($url);
                $response->assertOk()->assertDontSee('817.25');
                $this->assertStringContainsString('no-store',$response->headers->get('Cache-Control'));
            }
        }
        $this->get('/SMARMANger/dashboard/student/room/main_quizes/132/41')->assertSee('Assessment 2')->assertSee('English')->assertSee(__('student_assessments.hidden'));
        $history=$this->get('/SMARMANger/dashboard/student/academic-record/'.$placement)->assertOk();
        $this->assertCount(0,$history->viewData('quizResults'));
        $this->assertSame(__('student_assessments.hidden'),$history->viewData('assessmentRows')[0]['result']);
        $history->assertSee('92%');
        $this->get('/SMARMANger/dashboard/student/academic-record')->assertOk()->assertSee('2026/2027');
        $this->get('/SMARMANger/dashboard/student_exam')->assertOk();
        $this->assertSame($before,DB::table('exam_result2')->get()->toJson());
        $this->assertSame($marks,DB::table('students_marks')->get()->toJson());
        config(['student_results.student_pages_enabled'=>true]);
        $this->get('/SMARMANger/dashboard/student/view/main_exam/'.$exam->id)->assertOk()->assertSee('817.25');
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$placement)->assertOk()->assertSee('817.25');
    }

    public function test_student_result_identity_section_term_future_and_publication_boundaries_are_preserved()
    {
        $student=$this->studentUiFixture();$exam=$this->exam(2);$record=$this->result($exam,17);
        $this->actingAs($student);
        $snapshot=$record->getRawOriginal();
        $this->get('/SMARMANger/dashboard/student/start_main_exam/'.$exam->id)->assertForbidden();
        $this->post('/SMARMANger/dashboard/student/exam/save_main_exam',['content_id'=>$exam->id,'answer'=>[]])->assertForbidden();
        $this->assertSame($snapshot,$record->fresh()->getRawOriginal());
        $this->get('/SMARMANger/dashboard/student/room/main_quizes/133/41')->assertForbidden();
        $this->actingAs($this->account(0,['student_id'=>42]))->get('/SMARMANger/dashboard/student/view/main_exam/'.$exam->id)->assertNotFound();
        $this->actingAs($student)->get('/SMARMANger/dashboard/student/room/main_quizes/132/42')->assertRedirect('/SMARMANger');
        $this->actingAs($student);
        DB::table('exam_result2')->where('id',$record->id)->update(['show_result'=>0]);
        $this->getJson('/SMARMANger/dashboard/student/view/main_exam/'.$exam->id)->assertOk()->assertJsonPath('blocked',true);
        $this->get('/SMARMANger/dashboard/student/room/main_quizes/132/41')->assertOk()->assertSee(__('student_assessments.hidden'));
        DB::table('term_years')->where('id',20)->update(['current_term'=>0]);
        DB::table('term_years')->where('id',21)->update(['current_term'=>1]);
        $this->get('/SMARMANger/dashboard/student/room/main_quizes/132/41')->assertOk()->assertDontSee($exam->name);
        DB::table('years')->insert(['id'=>7,'name'=>'2027/2028','current_year'=>0]);
        $future=DB::table('student_academic_placements')->insertGetId(['student_id'=>41,'year_id'=>7,'class_id'=>2,'room_id'=>132,'status'=>'active']);
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$future)->assertNotFound();
        $this->assertSame(1,Exam_result2::count());
    }

    public function test_first_mark_obeys_original_publication_setting_without_overwriting_existing_decisions()
    {
        $student=$this->studentUiFixture();$exam=$this->exam(2,['has_traditional'=>1]);
        config(['student_results.student_pages_enabled'=>false]);
        $this->actingAs($this->teacher);
        $row=app(TeacherAssessmentService::class)->save($exam->id,41,132,409,0);
        $this->assertEquals(0,$row->show_result);
        $this->actingAs($this->admin)->get('/SMT/admin/gradebook/view/subject/grid?room_id=132&subject_id=409')->assertOk();
        config(['student_results.student_pages_enabled'=>true]);
        $this->actingAs($student)->get('/SMARMANger/dashboard/student/room/main_quizes/132/41')
            ->assertOk()->assertSee(__('student_assessments.hidden'))->assertDontSee('0 / 100');
        DB::table('exam_result2')->where('id',$row->id)->update(['show_result'=>1]);
        $this->actingAs($this->teacher);app(TeacherAssessmentService::class)->save($exam->id,41,132,409,25);
        $this->assertEquals(1,$row->fresh()->show_result);
        $this->actingAs($student)->get('/SMARMANger/dashboard/student/view/main_exam/'.$exam->id)->assertOk()->assertSee('25 / 100');
    }

    public function test_student_carried_result_uses_original_publication_and_missing_automated_participation_is_not_inferred()
    {
        $student=$this->studentUiFixture();$this->activateContinuity();$this->actingAs($this->admin);
        $a=$this->exam(2);$b=$this->exam(2,['room_id'=>133]);$row=$this->result($a,0,['created_at'=>now()->subHour()]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified original');
        $this->moveToB();$this->actingAs($student);
        $url='/SMARMANger/dashboard/student/room/main_quizes/133/41';
        $this->get($url)->assertOk()->assertSee('0 / 100')->assertSee('/view/main_exam/'.$a->id,false);
        $this->assertSame(0,Exam_result2::where('exam_id',$b->id)->count());
        DB::table('exam_result2')->where('id',$row->id)->update(['show_result'=>0]);
        $this->get($url)->assertOk()->assertDontSee('0 / 100')->assertSee(__('student_assessments.hidden'));
        $auto=$this->exam(2,['room_id'=>133,'is_file'=>0,'name'=>'Assigned automated only']);
        $this->get($url)->assertOk()->assertDontSee('Assigned automated only');
        $this->result($auto,null,['status'=>0]);
        $this->get($url)->assertOk()->assertSee('Assigned automated only')->assertSee('ابدأ التقييم')->assertSee(__('student_assessments.unentered'));
        $this->assertSame(2,Exam_result2::count());
    }

    public function test_results_policy_handles_fresh_and_cached_config_without_reading_changed_env_or_school_storage()
    {
        $cache=storage_path('framework/cache/student-results-fixture.php');
        $old=getenv('APP_CONFIG_CACHE');$oldFlag=getenv('STUDENT_RESULTS_PAGES_ENABLED');
        try {
            putenv('APP_CONFIG_CACHE='.$cache);$_ENV['APP_CONFIG_CACHE']=$cache;$_SERVER['APP_CONFIG_CACHE']=$cache;
            foreach ([false,true] as $enabled) {
                putenv('STUDENT_RESULTS_PAGES_ENABLED='.($enabled?'true':'false'));
                $_ENV['STUDENT_RESULTS_PAGES_ENABLED']=$enabled?'true':'false';$_SERVER['STUDENT_RESULTS_PAGES_ENABLED']=$_ENV['STUDENT_RESULTS_PAGES_ENABLED'];
                if (file_exists($cache)) unlink($cache);
                $app=new \Illuminate\Foundation\Application(base_path());
                $app->addAbsoluteCachePathPrefix(substr($cache,0,3));
                (new \Illuminate\Foundation\Bootstrap\LoadConfiguration())->bootstrap($app);
                $this->assertSame($enabled,$app['config']->get('student_results.student_pages_enabled'));
                $configuration=$app['config']->all();$configuration['student_results']['student_pages_enabled']=!$enabled;
                file_put_contents($cache,'<?php return '.var_export($configuration,true).';');
                $cached=new \Illuminate\Foundation\Application(base_path());
                $cached->addAbsoluteCachePathPrefix(substr($cache,0,3));
                (new \Illuminate\Foundation\Bootstrap\LoadConfiguration())->bootstrap($cached);
                $this->assertTrue($cached->configurationIsCached());
                $this->assertSame(!$enabled,$cached['config']->get('student_results.student_pages_enabled'));
            }
        } finally {
            if (file_exists($cache)) unlink($cache);
            putenv($old===false?'APP_CONFIG_CACHE':'APP_CONFIG_CACHE='.$old);unset($_ENV['APP_CONFIG_CACHE'],$_SERVER['APP_CONFIG_CACHE']);
            putenv($oldFlag===false?'STUDENT_RESULTS_PAGES_ENABLED':'STUDENT_RESULTS_PAGES_ENABLED='.$oldFlag);
            unset($_ENV['STUDENT_RESULTS_PAGES_ENABLED'],$_SERVER['STUDENT_RESULTS_PAGES_ENABLED']);
        }
        config(['student_results.student_pages_enabled'=>null]);
        $this->assertFalse(app(\App\Services\StudentResultsVisibility::class)->enabled());
        foreach (['false','0','unexpected'] as $value) {
            config(['student_results.student_pages_enabled'=>$value]);$this->assertFalse(app(\App\Services\StudentResultsVisibility::class)->enabled());
        }
    }

    public function test_legacy_mobile_privacy_blocks_direct_results_and_redacts_nested_earned_payloads_without_claiming_authentication()
    {
        $this->studentUiFixture();$exam=$this->exam(2);$this->result($exam,'817.25');
        config(['student_results.student_pages_enabled'=>false]);auth()->logout();
        foreach (['/api/dashboard/student/exam/view_quize/'.$exam->id.'/41','/api/dashboard/student/main_quize/132/41'] as $url) {
            $this->getJson($url)->assertOk()->assertJsonPath('blocked',true)->assertDontSee('817.25');
        }
        $payload=['name'=>'English','nested'=>[['result'=>'817.25','traditional_result'=>'817.25','medal'=>1,'user_answers'=>['grade'=>'817.25']]],
            'student_mark'=>['year_result'=>'817.25'],'year_result'=>'817.25','term_result'=>'817.25',
            'question'=>['mark'=>4,'student_mark'=>'817.25'],'attendance'=>92];
        $redacted=app(\App\Services\StudentResultsVisibility::class)->redactPayload($payload);
        $this->assertSame('English',$redacted['name']);$this->assertSame(92,$redacted['attendance']);
        $this->assertSame(4,$redacted['question']['mark']);
        $this->assertStringNotContainsString('817.25',json_encode($redacted));
        $this->scaffold();
        DB::table('students_marks')->where('student_id',41)->update(['year_result'=>'817.25']);
        $homework=DB::table('lesson_teacher_room_term_exam')->insertGetId(['class_id'=>2,'room_id'=>132,'lesson_id'=>409,
            'lecture_id'=>7,'term_id'=>20,'type'=>1,'namehomework'=>'Keep homework available',
            'start_time'=>'2026-10-22 09:00:00','end_time'=>'2026-10-22 11:00:00']);
        DB::table('exam_result')->insert(['exam_id'=>$homework,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,
            'result'=>'817.25','status'=>'1','show_result'=>1,'type'=>1]);
        $lessonUrl='/api/get_student_lesson_details/132/409/41/7/1';
        $this->getJson($lessonUrl)->assertOk()->assertSee('Keep homework available')->assertDontSee('817.25')
            ->assertJsonPath('student_mark',null)->assertJsonPath('lesson_details.0.result',null);
        config(['student_results.student_pages_enabled'=>true]);
        $this->getJson($lessonUrl)->assertOk()->assertJsonPath('lesson_details.0.result','817.25');
        DB::table('exam_result')->where('exam_id',$homework)->update(['show_result'=>0]);
        $this->getJson($lessonUrl)->assertOk()->assertJsonPath('lesson_details.0.result',-1);
        $unpublished=app(\App\Services\StudentResultsVisibility::class)->redactUnpublishedPayload(['rows'=>[
            ['status'=>'1','show_result'=>0,'result'=>'817.25','medal'=>1],
        ]]);
        $this->assertNull($unpublished['rows'][0]['result']);
        DB::table('exam_result2')->update(['show_result'=>0]);
        $this->getJson('/api/dashboard/student/exam/view_quize/'.$exam->id.'/41')->assertOk()->assertJsonPath('blocked',true)->assertDontSee('817.25');
    }

    public function test_student_certificate_download_views_are_gated_and_certificate_ids_cannot_select_another_student()
    {
        $student=$this->studentUiFixture();
        $own=DB::table('certificates')->insertGetId(['student_id'=>41,'room_id'=>132]);
        $other=DB::table('certificates')->insertGetId(['student_id'=>42,'room_id'=>132]);
        $this->actingAs($student);config(['student_results.student_pages_enabled'=>false]);
        foreach (['edit_2','newcertificate','new44','ncertificate12','newcerti12','certificate_22','new22'] as $route) {
            $this->get('/SMARMANger/dashboard/'.$route.'/'.$own)->assertOk()->assertViewIs('students.results_blocked');
            $this->get('/SMARMANger/dashboard/'.$route.'/'.$other)->assertNotFound();
        }
        config(['student_results.student_pages_enabled'=>true]);
        $this->get('/SMARMANger/dashboard/newcertificate/'.$other)->assertNotFound();
        $this->assertSame(2,DB::table('certificates')->count());
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
            'start_date'=>'2026-10-22 09:00:00','end_date'=>'2026-10-22 11:00:00'], $extra));
        return Exams2::findOrFail($id);
    }

    private function result($exam, $value, array $extra = [])
    {
        $id = DB::table('exam_result2')->insertGetId(array_merge(['exam_id'=>$exam->id,'user_id'=>41,'room_id'=>$exam->room_id,
            'class_id'=>$exam->class_id,'lesson_id'=>$exam->lesson_id,'term_id'=>$exam->term_id,'result'=>$value,'status'=>1,'show_result'=>1,'type'=>$exam->type], $extra));
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
        $this->assertSame(29, $routes->count());
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

    public function test_traditional_participation_is_additive_preserves_marks_and_notifies_only_new_students()
    {
        $this->actingAs($this->teacher);$exam=$this->exam(2);$result=$this->result($exam,'15');$snapshot=$result->getRawOriginal();
        $payload=['exam'=>$exam->id,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'all'=>1];
        $url='/SMARMANger/dashboard/teacher/add_quize_student';
        $this->post($url,$payload)->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame($snapshot,$result->fresh()->getRawOriginal());$this->assertSame(2,Exam_result2::count());
        $this->assertSame(1,DB::table('notifications')->count());
        $this->post($url,$payload)->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame(1,DB::table('notifications')->count());
        $this->postJson($url,array_merge($payload,['all'=>0,'student'=>[42]]))->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame($snapshot,$result->fresh()->getRawOriginal());
        $this->assertSame(2,Exam_result2::count());
        $blank=Exam_result2::where('exam_id',$exam->id)->where('user_id',42)->first();
        $blankSnapshot=$blank->getRawOriginal();
        DB::table('exams_files')->insert(['exam_id'=>$exam->id,'room_id'=>132,'lesson_id'=>409,'student_id'=>42,'file'=>'keep-submission.pdf']);
        $this->post($url,array_merge($payload,['all'=>0,'student'=>[]]))->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame($blankSnapshot,$blank->fresh()->getRawOriginal());
        $this->assertSame($snapshot,$result->fresh()->getRawOriginal());
        $this->assertDatabaseHas('exams_files',['student_id'=>42,'file'=>'keep-submission.pdf']);
        $this->assertSame(1,DB::table('notifications')->count());
        $this->postJson($url,array_merge($payload,['all'=>0,'student'=>[999]]))->assertStatus(403);
    }

    private function traditionalEntryInputs($html)
    {
        $dom = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors(); libxml_use_internal_errors($previous);
        return (new \DOMXPath($dom))->query('//table[@class="table1"]//input[@name="mark"]');
    }

    public function test_traditional_quiz_and_exam_rosters_need_no_participation_and_gets_never_write()
    {
        $this->actingAs($this->teacher);
        foreach ([1=>'exam',2=>'quize'] as $type=>$kind) {
            $exam=$this->exam($type);
            $url='/SMARMANger/dashboard/teacher/teacher_'.$kind.'_students/132/166/409/'.$exam->id;
            $response=$this->get($url)->assertOk()->assertSee(__('assessment_entry.ongoing'));
            $inputs=$this->traditionalEntryInputs($response->getContent());
            $this->assertCount(2,$inputs);
            foreach ($inputs as $input) $this->assertSame('',$input->getAttribute('value'));
            foreach ($inputs as $input) {
                $this->assertStringStartsWith('traditional-mark-',$input->getAttribute('form'));
                $this->assertSame('any',$input->getAttribute('step'));
            }
            $this->assertSame(0,Exam_result2::where('exam_id',$exam->id)->count());
            $this->assertSame(0,DB::table('notifications')->count());
            $zero=$this->result($exam,0);
            $placeholder=$this->result($exam,null,['user_id'=>42,'status'=>null]);
            DB::table('exams_files')->insert(['exam_id'=>$exam->id,'room_id'=>132,'lesson_id'=>409,'student_id'=>41,'file'=>'original.pdf']);
            DB::table('exams_files')->insert(['exam_id'=>$exam->id,'lesson_id'=>409,'student_id'=>41,'file'=>'legacy-null-section.pdf']);
            $other=$this->exam($type);
            DB::table('exams_files')->insert(['exam_id'=>$other->id,'room_id'=>132,'lesson_id'=>409,'student_id'=>41,'file'=>'unrelated-hidden.pdf']);
            $before=Exam_result2::orderBy('id')->get()->toJson();
            $files=DB::table('exams_files')->get()->toJson();
            $response=$this->get($url)->assertOk()->assertSee('original.pdf')->assertSee('legacy-null-section.pdf')->assertDontSee('unrelated-hidden.pdf');
            $this->get('/SMARMANger/dashboard/teacher/quizestudent/0/'.$exam->id.'/132')
                ->assertOk()->assertSee('legacy-null-section.pdf')->assertDontSee('unrelated-hidden.pdf');
            $inputs=$this->traditionalEntryInputs($response->getContent());
            $this->assertCount(2,$inputs);
            $this->assertSame('0',$inputs->item(0)->getAttribute('value'));
            $this->assertSame('',$inputs->item(1)->getAttribute('value'));
            $rows=$response->viewData($type===1?'exam_result':'quize_result');
            $this->assertEquals($zero->id,$rows->firstWhere('user_id',41)->id);
            $this->assertEquals($placeholder->id,$rows->firstWhere('user_id',42)->id);
            $this->assertSame($before,Exam_result2::orderBy('id')->get()->toJson());
            $this->assertSame($files,DB::table('exams_files')->get()->toJson());
        }
    }

    public function test_traditional_first_saves_and_advanced_edits_share_original_ids_without_enrollment()
    {
        $this->actingAs($this->teacher);
        GradebookStatusService::setStatus(2,20,'LOCKED');
        foreach ([1=>'exam',2=>'quize'] as $type=>$kind) {
            $exam=$this->exam($type);
            $entry='/SMARMANger/dashboard/teacher/teacher_'.$kind.'_students/132/166/409/'.$exam->id;
            $this->get($entry)->assertOk();
            $this->assertSame(0,Exam_result2::where('exam_id',$exam->id)->count());
            $payload=['exam_id'=>$exam->id,'room_id'=>132,'lesson_id'=>409,'user_id'=>41,'mark'=>0];
            $response=$this->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',$payload)->assertOk();
            $id=$response->json('result_id');
            $this->assertNotNull($id);
            $response=$this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
                'exam_id'=>$exam->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>19.5,
            ])->assertOk();
            $this->assertEquals($id,$response->json('result_id'));
            $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',array_merge($payload,[
                'exam_result_id'=>$id,'mark'=>20,
            ]))->assertOk()->assertJsonFragment(['result_id'=>$id]);
            // The student omitted from participation can also start in Advanced entry.
            $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
                'exam_id'=>$exam->id,'room_id'=>132,'subject_id'=>409,'student_id'=>42,'value'=>0,
            ])->assertOk();
            $response=$this->get($entry)->assertOk();
            $inputs=$this->traditionalEntryInputs($response->getContent());
            $this->assertSame('20',$inputs->item(0)->getAttribute('value'));
            $this->assertSame('0',$inputs->item(1)->getAttribute('value'));
            $this->assertSame(2,Exam_result2::where('exam_id',$exam->id)->count());
            $this->assertEquals($id,Exam_result2::where('exam_id',$exam->id)->where('user_id',41)->value('id'));
        }
    }

    public function test_automated_participation_still_guards_earned_results_and_removes_only_unused_placeholders()
    {
        $this->actingAs($this->teacher);
        $exam=$this->exam(2,['is_file'=>0]);
        $earned=$this->result($exam,0);$blank=$this->result($exam,null,['user_id'=>42,'status'=>null]);
        $before=$earned->getRawOriginal();
        $url='/SMARMANger/dashboard/teacher/add_quize_student';
        $payload=['exam'=>$exam->id,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'all'=>0,'student'=>[42]];
        $this->postJson($url,$payload)->assertStatus(422);
        $this->post($url,array_merge($payload,['student'=>[41]]))->assertRedirect()->assertSessionHasNoErrors();
        $this->assertSame($before,$earned->fresh()->getRawOriginal());
        $this->assertDatabaseMissing('exam_result2',['id'=>$blank->id]);
    }

    public function test_traditional_roster_keeps_transferred_results_and_placement_conflicts_read_only()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        $quiz=$this->exam(2);$other=$this->exam(2,['room_id'=>133]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$quiz->id,$other->id],'Verified sections');
        $this->enroll(43,133);
        $history=$this->result($quiz,12,['user_id'=>43]);$snapshot=$history->getRawOriginal();
        // Duplicate projections cannot establish one reliable entry interval.
        DB::table('student_academic_placements')->where('student_id',42)->update(['room_id'=>133,'updated_at'=>now()->subHour()]);
        DB::table('room_student')->insert(['student_id'=>42,'year_id'=>6,'room_id'=>132,'updated_at'=>now()]);
        $this->assertTrue(Student::currentMembership(6,132)->whereKey(42)->exists());
        $this->actingAs($this->teacher);
        $response=$this->get('/SMARMANger/dashboard/teacher/teacher_quize_students/132/166/409/'.$quiz->id)
            ->assertOk()->assertSee('data-continuity="conflict"',false);
        $this->assertCount(1,$this->traditionalEntryInputs($response->getContent()));
        $this->assertEquals([41,42],$response->viewData('quize_result')->pluck('user_id')->all());
        $payload=['exam_id'=>$quiz->id,'room_id'=>132,'lesson_id'=>409,'mark'=>5];
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',$payload+['user_id'=>43])->assertForbidden();
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',$payload+['user_id'=>42])->assertStatus(422);
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$quiz->id,'room_id'=>132,'subject_id'=>409,'student_id'=>42,'value'=>5,
        ])->assertStatus(422);
        $this->assertSame($snapshot,$history->fresh()->getRawOriginal());
        $this->assertSame(1,Exam_result2::count());
    }

    public function test_proven_stale_same_grade_projection_allows_both_entry_paths_and_original_result_edits_without_history_writes()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        DB::table('rooms')->insert(['id'=>134,'class_id'=>2,'year_id'=>6,'name'=>'Third section']);
        $quiz=$this->exam(2);$b=$this->exam(2,['room_id'=>133]);$c=$this->exam(2,['room_id'=>134]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$quiz->id,$b->id,$c->id],'Three verified sections');
        $independent=$this->exam(2,['name'=>$quiz->name]);
        foreach ([41=>133,42=>134] as $student=>$oldRoom) {
            DB::table('student_academic_placements')->where('student_id',$student)
                ->update(['room_id'=>$oldRoom,'updated_at'=>now()->subHours(2)]);
            DB::table('room_student')->where('student_id',$student)->update(['updated_at'=>now()->subHour()]);
        }
        $placements=DB::table('student_academic_placements')->orderBy('id')->get()->toJson();
        $enrollments=DB::table('room_student')->orderBy('id')->get()->toJson();
        $members=DB::table('assessment_equivalence_members')->orderBy('id')->get()->toJson();
        $this->actingAs($this->teacher);
        $url='/SMARMANger/dashboard/teacher/teacher_quize_students/132/166/409/'.$quiz->id;
        $view=$this->get($url)->assertOk()->assertDontSee('data-continuity="conflict"',false);
        $this->assertCount(2,$this->traditionalEntryInputs($view->getContent()));
        $advanced=$this->get($this->teacherUrl)->assertOk()->viewData('assessmentColumns')->firstWhere('id',$quiz->id);
        foreach ([41,42] as $student) $this->assertSame('missing',$advanced['results'][$student]['state']);
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',[
            'exam_id'=>$quiz->id,'room_id'=>132,'lesson_id'=>409,'user_id'=>41,'mark'=>0,
        ])->assertOk();
        $id=Exam_result2::where('exam_id',$quiz->id)->where('user_id',41)->value('id');
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$quiz->id,'room_id'=>132,'subject_id'=>409,'student_id'=>42,'value'=>23,
        ])->assertOk();
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$quiz->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>12,
        ])->assertOk()->assertJsonPath('result_id',$id);
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',[
            'exam_id'=>$quiz->id,'room_id'=>132,'lesson_id'=>409,'user_id'=>41,'exam_result_id'=>$id,'mark'=>0,
        ])->assertOk()->assertJsonPath('result_id',$id);
        $advanced=$this->get($this->teacherUrl)->assertOk()->viewData('assessmentColumns')->firstWhere('id',$quiz->id);
        foreach ([41,42] as $student) $this->assertSame('current',$advanced['results'][$student]['state']);
        $this->assertSame(0.0,$advanced['results'][41]['value']);
        $this->assertSame(23.0,$advanced['results'][42]['value']);
        $this->assertCount(2,$this->traditionalEntryInputs($this->get($url)->assertOk()->getContent()));
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$independent->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>9,
        ])->assertOk();
        $this->assertSame(3,Exam_result2::count());
        $this->assertSame(0,Exam_result2::whereIn('exam_id',[$b->id,$c->id])->count());
        $this->assertSame($placements,DB::table('student_academic_placements')->orderBy('id')->get()->toJson());
        $this->assertSame($enrollments,DB::table('room_student')->orderBy('id')->get()->toJson());
        $this->assertSame($members,DB::table('assessment_equivalence_members')->orderBy('id')->get()->toJson());
    }

    public function test_stale_projection_preserves_prior_equivalent_earned_zero_and_blocks_duplicate_entry()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        $target=$this->exam(2);$source=$this->exam(2,['room_id'=>133]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$target->id,$source->id],'Verified sections');
        DB::table('student_academic_placements')->where('student_id',41)
            ->update(['room_id'=>133,'updated_at'=>now()->subHours(2)]);
        DB::table('room_student')->where('student_id',41)->update(['updated_at'=>now()->subHour()]);
        $record=$this->result($source,0,['created_at'=>now()->subMinutes(90)]);$before=$record->getRawOriginal();
        $this->actingAs($this->teacher);
        $resolved=app(\App\Services\AssessmentContinuityService::class)->resolve($target,[41])[41];
        $this->assertSame('carried',$resolved['state']);$this->assertSame(0.0,$resolved['value']);
        $this->assertSame($record->id,$resolved['result_id']);$this->assertSame($source->id,$resolved['exam_id']);
        $this->get('/SMARMANger/dashboard/teacher/teacher_quize_students/132/166/409/'.$target->id)
            ->assertOk()->assertSee('data-continuity="carried"',false);
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$target->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>12,
        ])->assertStatus(422);
        $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark3',[
            'exam_id'=>$target->id,'room_id'=>132,'lesson_id'=>409,'user_id'=>41,'mark'=>12,
        ])->assertStatus(422);
        $this->assertSame($before,$record->fresh()->getRawOriginal());$this->assertSame(1,Exam_result2::count());
    }

    public function test_stale_projection_never_invents_ownership_for_unknown_pre_boundary_or_overlapping_results()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        $a=$this->exam(2);$b=$this->exam(2,['room_id'=>133]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified sections');
        DB::table('student_academic_placements')->where('student_id',41)
            ->update(['room_id'=>133,'updated_at'=>now()->subHours(2)]);
        DB::table('room_student')->where('student_id',41)->update(['updated_at'=>now()->subHour()]);
        $row=$this->result($a,12);$resolver=app(\App\Services\AssessmentContinuityService::class);
        foreach ([null,now()->subMinutes(90)] as $date) {
            DB::table('exam_result2')->where('id',$row->id)->update(['created_at'=>$date]);
            $this->assertSame('conflict',$resolver->resolve($a,[41])[41]['state']);
        }
        DB::table('exam_result2')->where('id',$row->id)->update(['created_at'=>now()]);
        $this->assertSame('current',$resolver->resolve($a,[41])[41]['state']);
        DB::table('student_academic_placements')->insert(['student_id'=>41,'year_id'=>6,'class_id'=>2,'room_id'=>132,
            'status'=>'closed','effective_from'=>now()->subDay(),'effective_to'=>now()->addMinute()]);
        $this->assertSame('conflict',$resolver->resolve($a,[41])[41]['state']);
        DB::table('student_academic_placements')->where('student_id',41)->where('status','closed')->delete();
        DB::table('exam_result2')->where('id',$row->id)->update(['exam_id'=>$b->id,'room_id'=>133]);
        $this->assertSame('conflict',$resolver->resolve($a,[41])[41]['state']); // Stale source after the boundary.
        $this->actingAs($this->teacher)->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$a->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>12,
        ])->assertStatus(422);
        $this->assertSame(1,Exam_result2::count());
    }

    public function test_competing_placements_enrollments_and_later_transfers_never_gain_compatibility_access()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        $a=$this->exam(2);$b=$this->exam(2,['room_id'=>133]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified sections');
        $placement=DB::table('student_academic_placements')->where('student_id',41)->first();
        DB::table('student_academic_placements')->where('id',$placement->id)->update(['room_id'=>133,'updated_at'=>now()->subHours(2)]);
        DB::table('room_student')->where('student_id',41)->update(['updated_at'=>now()->subHour()]);
        $this->actingAs($this->teacher);
        foreach (['active','enrollment','transfer','undated','cross_grade','future'] as $case) {
            if ($case==='active') DB::table('student_academic_placements')->insert(['student_id'=>41,'year_id'=>6,'class_id'=>2,'room_id'=>132,'status'=>'active','effective_from'=>now()->subDay()]);
            if ($case==='enrollment') DB::table('room_student')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>133,'updated_at'=>now()]);
            if (in_array($case,['transfer','undated'],true)) DB::table('student_transfer_histories')->insert(['student_id'=>41,'year_id'=>6,'created_at'=>$case==='transfer'?now():null]);
            if ($case==='cross_grade') DB::table('student_academic_placements')->where('id',$placement->id)->update(['class_id'=>3]);
            if ($case==='future') DB::table('room_student')->where('student_id',41)->update(['updated_at'=>now()->addDay()]);
            $contexts=app(\App\Services\CurrentStudentMembership::class)->assessmentEntryContexts([41],6,132);
            $this->assertNull($contexts[41]??null,$case);
            $response=$this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
                'exam_id'=>$a->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>12,
            ]);
            $this->assertSame($case==='future'?422:403,$response->status(),$case);
            DB::table('student_academic_placements')->where('student_id',41)->where('id','<>',$placement->id)->delete();
            DB::table('student_academic_placements')->where('id',$placement->id)->update(['class_id'=>2]);
            DB::table('room_student')->where('student_id',41)->where('room_id',133)->delete();
            DB::table('room_student')->where('student_id',41)->update(['updated_at'=>now()->subHour()]);
            DB::table('student_transfer_histories')->where('student_id',41)->delete();
        }
        $this->assertSame(0,Exam_result2::count());
    }

    public function test_empty_mapped_and_placeholder_assessments_stay_protected_until_an_audited_unlink_contract_exists()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        $a=$this->exam(2);$b=$this->exam(2,['room_id'=>133]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Retain verification evidence');
        $placeholderExam=$this->exam(2);$this->result($placeholderExam,null,['status'=>0,'show_result'=>1]);
        DB::table('notifications')->insert(['student_id'=>41,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'body'=>$placeholderExam->name]);
        $before=[];foreach (['exams2','exam_result2','assessment_equivalence_members','notifications'] as $table) $before[$table]=DB::table($table)->orderBy('id')->get()->toJson();
        foreach ([$a,$placeholderExam,$a] as $exam) {
            $this->postJson('/SMT/admin/class/room/exam_quize/delete',['content_id'=>$exam->id,'delete_code'=>'test-delete'])->assertStatus(422);
        }
        foreach ($before as $table=>$rows) $this->assertSame($rows,DB::table($table)->orderBy('id')->get()->toJson());
        DB::statement('PRAGMA foreign_keys = ON');
        try {DB::transaction(function() use ($a) {DB::table('exams2')->where('id',$a->id)->delete();});$this->fail('Unsafe mapped delete accepted');}
        catch (\Illuminate\Database\QueryException $e) {}
        $this->assertSame($before['assessment_equivalence_members'],DB::table('assessment_equivalence_members')->orderBy('id')->get()->toJson());
    }

    public function test_stale_projection_write_rollback_and_rejected_delete_preserve_original_group_and_automated_attempt_guard()
    {
        $this->activateContinuity();$this->actingAs($this->admin);
        $a=$this->exam(2);$b=$this->exam(2,['room_id'=>133]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$a->id,$b->id],'Verified sections');
        DB::table('student_academic_placements')->where('student_id',41)->update(['room_id'=>133,'updated_at'=>now()->subHours(2)]);
        DB::table('room_student')->where('student_id',41)->update(['updated_at'=>now()->subHour()]);
        $before=DB::table('assessment_equivalence_members')->orderBy('id')->get()->toJson();
        $delete='/SMT/admin/class/room/exam_quize/delete';
        $this->postJson($delete,['content_id'=>$a->id,'delete_code'=>'test-delete'])->assertStatus(422);
        $this->actingAs($this->teacher);
        $listener=function($row) {throw new \RuntimeException('Isolated post-save failure');};
        \Event::listen('eloquent.saved: '.Exam_result2::class,$listener);
        try {app(TeacherAssessmentService::class)->save($a->id,41,132,409,12);$this->fail('Fixture did not fail');}
        catch (\RuntimeException $e) {$this->assertSame('Isolated post-save failure',$e->getMessage());}
        \Event::forget('eloquent.saved: '.Exam_result2::class);
        $this->assertSame(0,Exam_result2::count());
        $this->assertSame($before,DB::table('assessment_equivalence_members')->orderBy('id')->get()->toJson());
        $id=app(TeacherAssessmentService::class)->save($a->id,41,132,409,12)->id;
        $this->assertSame($id,app(TeacherAssessmentService::class)->save($a->id,41,132,409,13)->id);
        $this->actingAs($this->admin)->postJson($delete,['content_id'=>$a->id,'delete_code'=>'test-delete'])->assertStatus(422);
        $this->assertDatabaseHas('exam_result2',['id'=>$id,'result'=>13]);
        $this->assertSame($before,DB::table('assessment_equivalence_members')->orderBy('id')->get()->toJson());
        // The model hook used by automated writers cannot create an equivalent duplicate.
        $attempt=new Exam_result2();$attempt->forceFill(['exam_id'=>$b->id,'user_id'=>41,'room_id'=>133,'result'=>15]);
        app(\App\Services\AssessmentContinuityService::class)->assertWritable($a,41);
        // Exercise that hook through the eligible receiving definition, as an automated flow would.
        $source=$this->exam(2,['room_id'=>133]);$target=$this->exam(2,['is_file'=>0]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$source->id,$target->id],'Separate automated occurrence');
        $this->result($source,0,['created_at'=>now()->subMinutes(90)]);
        $attempt->forceFill(['exam_id'=>$target->id,'room_id'=>132]);
        try {$attempt->save();$this->fail('Automated equivalent result duplicated');}
        catch (\Illuminate\Validation\ValidationException $e) {}
        $this->assertSame(0,Exam_result2::where('exam_id',$target->id)->count());
    }

    public function test_quiz_2423_window_equivalence_and_empty_results_do_not_require_placeholders()
    {
        $this->activateContinuity();
        Carbon::setTestNow(Carbon::parse('2026-11-05 19:35:00',config('app.timezone')));
        $this->actingAs($this->admin);
        $quiz=$this->exam(2,['id'=>2423,'mark'=>50,'start_date'=>'2026-11-04 19:13:44','end_date'=>'2026-11-15 19:13:47']);
        $other=$this->exam(2,['room_id'=>133,'mark'=>50,'start_date'=>'2026-11-08 19:13:44','end_date'=>'2026-11-15 19:13:47']);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$quiz->id,$other->id],'Explicit multi-section assessment creation');
        GradebookStatusService::setStatus(2,20,'LOCKED');
        $this->actingAs($this->teacher);
        $response=$this->get($this->teacherUrl)->assertOk();
        $column=$response->viewData('assessmentColumns')->firstWhere('id',2423);
        $this->assertTrue($column['entry_allowed']);
        $this->assertSame('missing',$column['results'][41]['state']);
        $this->assertStringContainsString('data-exam="2423"',$this->occurrenceHtml($response->getContent()));
        $this->assertSame(0,Exam_result2::count());
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>2423,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>0,
        ])->assertOk();
        $id=Exam_result2::where('exam_id',2423)->value('id');
        $this->get('/SMARMANger/dashboard/teacher/teacher_quize_students/132/166/409/2423')->assertOk();
        $this->assertSame(1,Exam_result2::count());
        foreach (['2026-11-04 19:13:43'=>422,'2026-11-04 19:13:44'=>200,
            '2026-11-15 19:13:47'=>200,'2026-11-15 19:13:48'=>422] as $now=>$status) {
            Carbon::setTestNow(Carbon::parse($now,config('app.timezone')));
            $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
                'exam_id'=>2423,'room_id'=>132,'subject_id'=>409,'student_id'=>42,'value'=>0,
            ])->assertStatus($status);
        }
        $this->assertEquals($id,Exam_result2::where('exam_id',2423)->where('user_id',41)->value('id'));
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
        $this->postJson($url)->assertStatus(419);
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
        Carbon::setTestNow(Carbon::parse('2026-10-23 09:00:00',config('app.timezone')));
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
        DB::table('exam_result')->insert(['exam_id'=>$legacy,'user_id'=>41,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'result'=>'0','status'=>'1','show_result'=>1]);
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
            ->assertOk()->assertSee('Section 132')->assertSee('Grade 2')->assertSee('2026/2027')->assertSee(__('gradebook_distribution.configured_maximum'))->assertSee('مشروع');
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
        $response=$this->actingAs($this->account(1,['teacher_id'=>167]))->get($this->teacherUrl)->assertOk();
        $response->assertSee('data-result="'.$result->id.'"',false)->assertSee('value="35"',false);
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
        Carbon::setTestNow(Carbon::parse('2026-10-23 09:00:00',config('app.timezone')));
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
        GradebookStatusService::setStatus(2,20,'OPEN');
        foreach ($targets as $kind=>$target) {
            $this->actingAs($this->teacher)->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
                'student_id'=>41,'exam_id'=>$target->id,'room_id'=>133,'subject_id'=>409,'value'=>10,
            ])->assertStatus(422);
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
        $this->postJson($url,$payload)->assertOk()->assertJsonPath('value',0);
        $id=Exam_result2::firstOrFail()->id;
        $this->postJson($url,array_merge($payload,['exam_result_id'=>$id,'mark'=>25]))->assertOk()->assertJsonPath('result_id',$id);
        $this->assertSame(1,Exam_result2::count());
        $this->assertDatabaseHas('exam_result2',['id'=>$id,'result'=>25,'exam_id'=>$a->id]);
        $this->assertSame(2,DB::table('notifications')->where('student_id',41)->count());
        $this->getJson($url)->assertStatus(405);
        $this->app->bind(\App\Http\Middleware\VerifyCsrfToken::class,function($app) {
            return new class($app,$app['encrypter']) extends \App\Http\Middleware\VerifyCsrfToken {
                protected function runningUnitTests() { return false; }
            };
        });
        // AJAX CSRF failures remain explicit errors, not successful login-page HTML.
        $this->postJson($url,$payload)->assertStatus(419);
        $this->assertDatabaseHas('exam_result2',['id'=>$id,'result'=>25]);
        $this->assertSame(2,DB::table('notifications')->where('student_id',41)->count());
    }

    public function test_phase2a_context_snapshot_preserves_existing_reader_and_controller_outputs()
    {
        $this->dynamic();
        DB::table('term_years')->insert(['id'=>22,'year_id'=>6,'type'=>1,'term'=>'Another actual term','current_term'=>0]);
        foreach (['certificates','school_data'] as $table) Schema::create($table, function (Blueprint $schema) {
            $schema->increments('id'); $schema->integer('student_id')->nullable(); $schema->integer('room_id')->nullable();
        });
        $quizA = $this->exam(2); $quizB = $this->exam(2);
        $exam = $this->exam(1); $termTwo = $this->exam(2, ['term_id'=>21]);
        $dynamic = $this->exam(1, ['name'=>'Dynamic_Section_100','mark'=>20]);
        $anotherTerm = $this->exam(2, ['term_id'=>22]);
        $resultIds = [$this->result($quizA, '0')->id, $this->result($quizB, '10')->id,
            $this->result($exam, '30')->id, $this->result($termTwo, '14')->id,
            $this->result($dynamic, null)->id, $this->result($anotherTerm, '0')->id];
        $this->scaffold();
        $placement = DB::table('student_academic_placements')->where('student_id',41)->value('id');
        $studentAccount = $this->account(0, ['student_id'=>41]);
        $renderReaders = function () use ($placement, $studentAccount) {
            $this->actingAs($this->admin);
            $admin = app(\App\Http\Controllers\Admin\GradebookController::class)->viewGridSimple(
                \Illuminate\Http\Request::create('/isolated', 'GET', ['room_id'=>132,'subject_id'=>409]));
            $adminData = $admin->getData()['gradebook'];
            $adminHtml = $admin->render();
            $this->actingAs($this->teacher);
            $teacher = app(\App\Http\Controllers\Teacher\TeacherGradebookController::class)->index(2,132,409);
            $teacherData = $teacher->getData()['gradebook'];
            $teacherHtml = $teacher->render();
            $this->actingAs($studentAccount);
            $record = app(\App\Http\Controllers\studentscontroller::class)->academic_record_show($placement);
            return [$adminHtml, $teacherHtml, $record->render(), $record->getData()['assessmentRows'],
                $adminData['marks'], $teacherData['marks'],
                $adminData['assessments']->pluck('key')->all(), $adminData['terms']->pluck('id')->all()];
        };
        $rowsBefore = Exam_result2::orderBy('id')->get()->toJson();
        $filesBefore = [Storage::get('gradebook/409_6.json'), Storage::get('gradebook_status/2_20.json')];
        $before = $renderReaders();
        $reader = app(\App\Services\Gradebook\GradebookContextReader::class);
        DB::enableQueryLog();
        DB::flushQueryLog();
        $started = microtime(true);
        $this->read();
        $baseline = ['fixture_students'=>2, 'fixture_assessments'=>6, 'fixture_terms'=>3,
            'shared_reader_queries'=>count(DB::getQueryLog()),
            'shared_reader_ms'=>round((microtime(true) - $started) * 1000, 3)];
        DB::flushQueryLog();
        foreach ([20,21] as $term) {
            $snapshot = $reader->resolve(new \App\Services\Gradebook\GradebookContext(6,409,$term,2,132));
            $this->assertEquals(GradebookConfigService::getConfig(409,6), $snapshot->components());
            $this->assertSame($term, $snapshot->context()->termId());
            $this->assertSame(20.0, GradebookReadService::componentMaximum(
                $snapshot->components()->firstWhere('id','dynamic_a'), Lesson::find(409)));
        }
        // Each contextual resolve uses six SELECTs; two explicit Lesson lookups above add two.
        $this->assertCount(14, DB::getQueryLog());
        $baseline['two_context_resolves_plus_two_lesson_lookups'] = count(DB::getQueryLog());
        DB::disableQueryLog();
        if (getenv('ALADHAM_TEST_STORAGE')) {
            file_put_contents(sys_get_temp_dir().'/gradebook-2a-read-baseline.json', json_encode($baseline));
        }
        // An inactive 2B publication must leave all three existing consumers byte-for-byte compatible.
        require_once base_path('database/migrations/2026_10_29_000001_create_gradebook_template_foundation.php');
        (new \CreateGradebookTemplateFoundation())->up();
        $this->actingAs($this->admin);
        $templates = app(\App\Services\Gradebook\GradebookTemplateService::class);
        $template = $templates->create(6,409,'Independent template');
        $template = $templates->save($template->id,1,['name_ar'=>'Independent template','components'=>[
            ['id'=>'','name_ar'=>'Independent component','maximum'=>999],
        ]]);
        $review = $templates->preview($template->id);
        $templates->publish($template->id,$review['revision'],$review['preview_token'],1);
        $this->assertSame(1,\App\GradebookTemplateVersion::count());
        $this->assertSame($before, $renderReaders());
        $this->assertSame(35.0, $before[4][41][20]['total']);
        $this->assertSame(14.0, $before[4][41][21]['total']);
        $this->assertSame(5.0, $before[4][41][20]['legacy_homework']);
        $this->assertArrayNotHasKey('dynamic_a', $before[4][41][20]);
        $this->assertArrayNotHasKey(21, $before[5][41]);
        $this->assertSame([20,21,22], array_map('intval', $before[7]));
        $this->assertCount(6, $before[6]);
        $this->assertSame($resultIds, Exam_result2::orderBy('id')->pluck('id')->all());
        $this->assertSame($rowsBefore, Exam_result2::orderBy('id')->get()->toJson());
        $this->assertSame($filesBefore, [Storage::get('gradebook/409_6.json'),Storage::get('gradebook_status/2_20.json')]);
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
