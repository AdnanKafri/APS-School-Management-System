<?php

namespace Tests\Feature;

use App\Lesson_room_teacher_lecture_time;
use App\Services\CurrentTeacherAssignments;
use App\TeacherAssignmentPeriod;
use App\Teacher_room_lesson;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class TimetableAuthorityTest extends TestCase
{
    use \Tests\Concerns\TimetableFixtures;

    private $admin;
    private $teacher;
    private $replacement;

    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        DB::connection()->getPdo()->sqliteCreateCollation('utf8_unicode_ci', 'strcmp');
        Carbon::setTestNow(Carbon::parse('2026-10-29 10:00:00', 'Asia/Damascus'));
        foreach (json_decode(file_get_contents(__DIR__.'/../Fixtures/gradebook-schema.json'), true) as $name => $columns) {
            Schema::create($name, function (Blueprint $table) use ($columns) {
                foreach ($columns as $column) {
                    if ($column['name'] === 'id') { $table->increments('id'); }
                    elseif (preg_match('/^(tiny|small|medium|big)?int/', $column['type'])) { $table->integer($column['name'])->nullable(); }
                    else { $table->text($column['name'])->nullable(); }
                }
            });
        }
        foreach (['messages'=>['teacher_id','type','view'], 'messages_super'=>['teacher_id','view'],
            'supervisor_teacher_items'=>['teacher_id','view'], 'objections'=>['teacher_id','view'],
            'teacher_events'=>['teacher_id'], 'student_fcm_tokens'=>['s_fk'], 'school_data'=>['name'],
            'student_schedule_tracer'=>['user_id','lecture_time_id','day_id']] as $name=>$columns) {
            Schema::create($name, function (Blueprint $t) use ($columns) {
                $t->increments('id'); foreach ($columns as $col) { $t->text($col)->nullable(); } $t->timestamps();
            });
        }
        DB::table('years')->insert([['id'=>5,'name'=>'2025/2026','current_year'=>0],['id'=>6,'name'=>'2026/2027','current_year'=>1]]);
        DB::table('term_years')->insert([
            ['id'=>17,'year_id'=>5,'current_term'=>1,'type'=>1],
            ['id'=>20,'year_id'=>6,'current_term'=>1,'type'=>1],
            ['id'=>21,'year_id'=>6,'current_term'=>0,'type'=>2],
        ]);
        DB::table('classes')->insert(['id'=>2,'name'=>'Grade 2']);
        foreach ([132,133] as $id) { DB::table('rooms')->insert(['id'=>$id,'year_id'=>6,'class_id'=>2,'name'=>'Section '.$id]); }
        DB::table('rooms')->insert(['id'=>93,'year_id'=>5,'class_id'=>2,'name'=>'Old section']);
        DB::table('lessons')->insert(['id'=>409,'class_id'=>2,'name'=>'Arabic']);
        DB::table('teachers')->insert([
            ['id'=>166,'first_name'=>'First','last_name'=>'Teacher'], ['id'=>167,'first_name'=>'Next','last_name'=>'Teacher'],
        ]);
        $this->createTimetableSchema();
        DB::table('teachers')->update(['active'=>0]);
        $this->admin = $this->account(2, null, 1);
        $this->teacher = $this->account(1, 166);
        $this->replacement = $this->account(1, 167);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function account($type, $teacher = null, $role = null)
    {
        return User::create(['name'=>'Isolated account','email'=>uniqid().'@example.test','password'=>'unused',
            'type'=>$type,'teacher_id'=>$teacher,'role_id'=>$role]);
    }

    private function savePeriod($teacher = 166, $day = 1, $scheduleId = null, $slotId = null)
    {
        if (!$slotId) {
            DB::table('days')->updateOrInsert(['id'=>$day],['name'=>'Day '.$day,'name_en'=>'Day '.$day]);
            $slotId = DB::table('lecture_times')->where('room_id',132)->value('id');
            if (!$slotId) { $slotId = DB::table('lecture_times')->insertGetId(['room_id'=>132,'type'=>1,'name'=>'First','start_time'=>'08:00:00','end_time'=>'08:40:00']); }
        }
        return $this->actingAs($this->admin)->postJson('/SMT/admin/save_schedule', [
            'room_id'=>132,'day_id'=>$day,'lecture_time_id'=>$slotId,'schedule_context'=>'exam',
            'lesson'=>[['lesson_id'=>409,'teacher_id'=>$teacher,'schedule_id'=>$scheduleId]],
        ]);
    }

    private function removePeriod($day = 1)
    {
        return $this->actingAs($this->admin)->post('/SMT/admin/dashboard/room/delete_lecture_time', [
            'room_id'=>132,'day_id'=>$day,'lecture_time_id'=>DB::table('lecture_times')->where('room_id',132)->value('id'),
        ]);
    }

    private function authority()
    {
        return app(CurrentTeacherAssignments::class);
    }

    public function test_pivot_only_never_grants_current_pages_or_forged_grade_posts()
    {
        $assignment = Teacher_room_lesson::create(['teacher_id'=>166,'year_id'=>6,'class_id'=>2,'room_id'=>132,'lesson_id'=>409]);
        $this->assertFalse($this->authority()->has(166,132,409));
        $this->assertSame(0,Teacher_room_lesson::currentTimetable()->count());
        $this->assertSame(0,TeacherAssignmentPeriod::count());
        $this->actingAs($this->teacher);
        foreach (['/SMARMANger/teacher_lessons2/132/166','/SMARMANger/teacher_marks_subjects/132/166',
            '/SMARMANger/dashboard/teacher/gradebook/2/132/409',
            '/SMARMANger/dashboard/teacher/student-follow-ups/assignments/'.$assignment->id] as $url) {
            $this->getJson($url)->assertForbidden();
        }
        DB::table('students')->insert(['id'=>41,'first_name'=>'Student','last_name'=>'Fixture','lifecycle_status'=>'active']);
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/save',[
            'room_id'=>132,'subject_id'=>409,'student_id'=>41,'component_id'=>'dynamic','value'=>5,
        ])->assertForbidden();
        $view = app(\App\Http\Controllers\TeacherController_New::class)->dashboard_teacher()->getData();
        $this->assertCount(0,$view['classes']);
        $this->assertCount(0,$view['teacher']->rooms);
    }

    public function test_real_admin_save_creates_projection_and_period_and_is_idempotent()
    {
        $this->savePeriod()->assertOk()->assertJson(['status'=>true]);
        $id = Lesson_room_teacher_lecture_time::value('id');
        $projection = Teacher_room_lesson::first();
        $this->assertTrue($this->authority()->has(166,132,409));
        $this->assertSame(1,Teacher_room_lesson::count());
        $this->assertSame(1,TeacherAssignmentPeriod::whereNull('effective_to')->count());
        $this->savePeriod(166,1,$id)->assertOk()->assertJson(['status'=>true]);
        $this->assertSame(1,Lesson_room_teacher_lecture_time::count());
        $this->assertSame(1,Teacher_room_lesson::count());
        $this->assertSame(1,TeacherAssignmentPeriod::count());
        $this->assertEquals($projection->id,Teacher_room_lesson::first()->id);
    }

    public function test_replacement_retires_access_without_deleting_pivot_or_historical_results()
    {
        $this->savePeriod()->assertOk();
        $pivot = Teacher_room_lesson::first();
        DB::table('exams2')->insert(['id'=>1,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'type'=>1,'mark'=>50,'name'=>'Historical exam']);
        DB::table('exam_result2')->insert(['id'=>1,'exam_id'=>1,'user_id'=>41,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'term_id'=>20,'result'=>31]);
        DB::table('students_marks')->insert(['student_id'=>41,'room_id'=>132,'year_id'=>6,'mark'=>'original']);
        DB::table('report_cards')->insert(['student_id'=>41,'room_id'=>132,'year_id'=>6]);
        $before = $this->academicSnapshot();
        $this->savePeriod(167,1,Lesson_room_teacher_lecture_time::value('id'))->assertOk()->assertJson(['status'=>true]);
        $this->assertFalse($this->authority()->has(166,132,409));
        $this->assertTrue($this->authority()->has(167,132,409));
        $this->assertNotNull(TeacherAssignmentPeriod::where('teacher_room_lesson_id',$pivot->id)->first()->effective_to);
        $this->assertDatabaseHas('teacher_room_lesson',['id'=>$pivot->id,'teacher_id'=>166]);
        $this->assertSame($before,$this->academicSnapshot());
        $this->actingAs($this->teacher)->getJson('/SMARMANger/teacher_marks_subjects/132/166')->assertForbidden();
        try { app(\App\Services\TeacherAssessmentService::class)->context(\App\Exams2::find(1)); $this->fail('Old Teacher retained grade access'); }
        catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) { $this->assertSame(403,$e->getStatusCode()); }
        $this->actingAs($this->replacement);
        $this->assertNotEmpty(app(\App\Services\TeacherAssessmentService::class)->context(\App\Exams2::find(1)));
    }

    public function test_removing_one_of_many_periods_keeps_grant_and_last_removal_closes_it()
    {
        $this->savePeriod()->assertOk();
        $this->savePeriod(166,2)->assertOk();
        $this->removePeriod(1)->assertRedirect();
        $this->assertTrue($this->authority()->has(166,132,409));
        $this->assertSame(1,TeacherAssignmentPeriod::whereNull('effective_to')->count());
        $this->removePeriod(2)->assertRedirect();
        $this->assertFalse($this->authority()->has(166,132,409));
        $this->assertSame(0,TeacherAssignmentPeriod::whereNull('effective_to')->count());
        $this->assertSame(1,Teacher_room_lesson::count());
    }

    public function test_two_teachers_and_other_sections_remain_independent()
    {
        $this->savePeriod()->assertOk();
        $this->savePeriod(167,2)->assertOk();
        $this->timetablePeriod(166,133,409,6,20,3);
        $this->authority()->synchronize(133);
        $this->removePeriod()->assertRedirect();
        $this->assertFalse($this->authority()->has(166,132,409));
        $this->assertTrue($this->authority()->has(167,132,409));
        $this->assertTrue($this->authority()->has(166,133,409));
    }

    public function test_all_four_timetable_views_use_the_same_row_ids()
    {
        $this->savePeriod()->assertOk();
        $this->savePeriod(166,2)->assertOk();
        $this->timetablePeriod(166,132,409,6,21,4);
        $expected = $this->authority()->schedule(166,132)->orderBy('id')->pluck('id')->all();
        $admin = app(\App\Http\Controllers\DashboardController::class);
        foreach ([$admin->workschedule(132),$admin->workschedule_exam(132),$admin->teacher_schedule(166)] as $view) {
            $this->assertEqualsCanonicalizing($expected,$view->getData()['schedule']->pluck('id')->all());
        }
        $this->actingAs($this->teacher);
        $view = app(\App\Http\Controllers\TeacherController_New::class)->teacher_schedule();
        $this->assertEqualsCanonicalizing($expected,$view->getData()['schedule']->pluck('id')->all());
        $dashboard = app(\App\Http\Controllers\TeacherController_New::class)->dashboard_teacher()->getData();
        $this->assertSame([132],$dashboard['teacher']->rooms->pluck('id')->all());
    }

    public function test_current_term_switch_closes_old_period_and_preserves_previous_term_schedule()
    {
        $this->savePeriod()->assertOk();
        $oldRows = DB::table('lesson_room_teacher_lecture_time')->where('term_id',20)->get()->toJson();
        $this->timetablePeriod(167,132,409,6,21);
        $this->actingAs($this->admin)->post('/SMT/admin/term_set_current',['term_id'=>21])->assertRedirect();
        $this->assertFalse($this->authority()->has(166,132,409));
        $this->assertTrue($this->authority()->has(167,132,409));
        $this->assertSame($oldRows,DB::table('lesson_room_teacher_lecture_time')->where('term_id',20)->get()->toJson());
        $this->assertSame(1,DB::table('term_years')->where('year_id',6)->where('current_term',1)->count());
        $this->actingAs($this->admin)->post('/SMT/admin/term_set_current',['term_id'=>21])->assertRedirect();
        $this->assertTrue($this->authority()->has(167,132,409));
        $this->assertSame(2,TeacherAssignmentPeriod::count());
    }

    public function test_no_current_term_or_only_old_year_schedule_never_falls_back()
    {
        $this->timetablePeriod(166,93,409,5,17);
        $this->timetablePeriod(166,132,409,6,21);
        $this->assertFalse($this->authority()->has(166,132,409));
        DB::table('term_years')->where('year_id',6)->update(['current_term'=>0]);
        $this->assertSame(0,$this->authority()->schedule()->count());
    }

    public function test_invalid_instructional_slot_class_teacher_and_day_do_not_grant_access()
    {
        $id = $this->timetablePeriod(166,132,409,6);
        $row = Lesson_room_teacher_lecture_time::find($id);
        $this->assertTrue($this->authority()->has(166,132,409));
        foreach ([['type'=>0],['room_id'=>133],['end_time'=>'07:59:00']] as $bad) {
            DB::table('lecture_times')->where('id',$row->lecture_time_id)->update(array_merge(['type'=>1,'room_id'=>132,'end_time'=>'08:40:00'],$bad));
            $this->assertFalse($this->authority()->has(166,132,409));
            $this->savePeriod(166,1,null,$row->lecture_time_id)->assertStatus(422);
        }
        DB::table('lecture_times')->where('id',$row->lecture_time_id)->update(['type'=>1,'room_id'=>132,'end_time'=>'08:40:00']);
        DB::table('teachers')->where('id',166)->update(['active'=>1]);
        $this->assertFalse($this->authority()->has(166,132,409));
        DB::table('teachers')->where('id',166)->update(['active'=>0]);
        DB::table('lessons')->where('id',409)->update(['class_id'=>3]);
        $this->assertFalse($this->authority()->has(166,132,409));
        DB::table('lessons')->where('id',409)->update(['class_id'=>2]);
        DB::table('days')->where('id',1)->delete();
        $this->assertFalse($this->authority()->has(166,132,409));
    }

    public function test_existing_slot_ids_from_another_editor_or_term_are_rejected()
    {
        $this->savePeriod()->assertOk();
        $staleId = Lesson_room_teacher_lecture_time::value('id');
        $this->removePeriod()->assertRedirect();
        $this->savePeriod(167)->assertOk();
        $before = DB::table('lesson_room_teacher_lecture_time')->get()->toJson();
        $this->savePeriod(166,1,$staleId)->assertStatus(422);
        $this->assertSame($before,DB::table('lesson_room_teacher_lecture_time')->get()->toJson());
        $otherTermId = $this->timetablePeriod(166,132,409,6,21,3);
        $this->savePeriod(166,1,$otherTermId)->assertStatus(422);
    }

    public function test_transaction_failure_rolls_back_schedule_projection_and_periods()
    {
        $this->savePeriod()->assertOk();
        $before = $this->assignmentSnapshot();
        Lesson_room_teacher_lecture_time::saving(function ($row) {
            if ((int) $row->teacher_id === 167) { throw new \RuntimeException('Isolated write failure'); }
        });
        $this->savePeriod(167,1,Lesson_room_teacher_lecture_time::value('id'))->assertJson(['status'=>false]);
        $this->assertSame($before,$this->assignmentSnapshot());
    }

    public function test_readding_teacher_opens_a_new_period_without_overwriting_the_closed_one()
    {
        $this->savePeriod()->assertOk();
        $this->removePeriod()->assertRedirect();
        $closed = TeacherAssignmentPeriod::first()->getRawOriginal();
        Carbon::setTestNow(Carbon::now()->addHour());
        $this->savePeriod()->assertOk();
        $this->assertSame($closed,TeacherAssignmentPeriod::orderBy('id')->first()->getRawOriginal());
        $this->assertSame(1,Teacher_room_lesson::count());
        $this->assertSame(2,TeacherAssignmentPeriod::count());
        $this->assertSame(1,TeacherAssignmentPeriod::whereNull('effective_to')->count());
    }

    public function test_admin_mutation_routes_reject_teacher_and_guests()
    {
        $this->actingAs($this->teacher)->postJson('/SMT/admin/save_schedule',[])->assertRedirect();
        auth()->logout();
        $this->postJson('/SMT/admin/save_schedule',[])->assertUnauthorized();
        $this->assertSame(0,Lesson_room_teacher_lecture_time::count());
    }

    public function test_api_contract_keeps_current_timetable_scope_and_rejects_stale_content_creation()
    {
        $this->savePeriod()->assertOk();
        auth()->logout();
        $this->getJson('/api/teacher_subjects/132/166')->assertOk()->assertJsonCount(1,'subjects');
        $this->actingAs($this->admin); $this->removePeriod()->assertRedirect(); auth()->logout();
        $this->getJson('/api/teacher_subjects/132/166')->assertOk()->assertJsonCount(0,'subjects');
        $this->postJson('/api/teacher/store/lecture',['teacher_id'=>166,'room_id'=>132,'lesson_id'=>409,'class_id'=>2])->assertForbidden();
    }

    public function test_direct_search_and_forged_content_context_require_a_current_scheduled_subject()
    {
        $this->actingAs($this->teacher)->getJson('/SMARMANger/teachers2/teacher_lessons/search_lecture?room_id=132&search=x')->assertForbidden();
        $this->savePeriod()->assertOk();
        DB::table('lessons')->insert(['id'=>410,'class_id'=>2,'name'=>'Unassigned subject']);
        $this->actingAs($this->teacher)->postJson('/SMARMANger/teachers2/teacher_lessons/store',[
            'room_id'=>132,'lesson_id'=>410,'class_id'=>2,'teacher_id'=>167,'name'=>'Forged',
        ])->assertForbidden();
        $this->getJson('/SMARMANger/dashboard/teacher/class/lessons/2')->assertOk()->assertJsonCount(1)
            ->assertJsonFragment(['id'=>409])->assertJsonMissing(['id'=>410]);
        $this->getJson('/SMARMANger/teachers2/teacher_lessons/search_lecturetime?room_id=132&lesson_id=410')->assertForbidden();
        $this->getJson('/SMARMANger/dashboard/teacher/room/go_to_stream/999/1/1/132/167')->assertNotFound();
    }

    public function test_valid_period_without_projection_still_conflicts_and_grants_timetable_context()
    {
        $this->timetablePeriod(166,133,409,6);
        $this->assertSame(0,Teacher_room_lesson::count());
        $this->assertTrue($this->authority()->has(166,133,409));
        $this->savePeriod(166,1)->assertJson(['status'=>0]);
        $this->assertSame(1,Lesson_room_teacher_lecture_time::count());
        $this->assertSame(0,Teacher_room_lesson::count());
        $this->savePeriod(166,2)->assertOk()->assertJson(['status'=>true]);
        $this->assertTrue($this->authority()->has(166,132,409));
    }

    private function assignmentSnapshot()
    {
        return collect(['lesson_room_teacher_lecture_time','teacher_room_lesson','teacher_assignment_periods'])
            ->mapWithKeys(function ($table) { return [$table=>DB::table($table)->orderBy('id')->get()->toJson()]; })->all();
    }

    public function test_slot_changes_retire_current_access_and_protect_other_term_history()
    {
        $this->savePeriod()->assertOk();
        $slot = DB::table('lecture_times')->value('id');
        $payload = ['id'=>$slot,'session_name'=>'First','start_time'=>'08:00','end_time'=>'08:40','type'=>2];
        $this->post('/SMT/admin/session_update',$payload)->assertRedirect();
        $this->assertFalse($this->authority()->has(166,132,409));
        $this->assertSame(0,TeacherAssignmentPeriod::whereNull('effective_to')->count());
        $this->post('/SMT/admin/session_update',array_merge($payload,['type'=>1]))->assertRedirect();
        $this->assertTrue($this->authority()->has(166,132,409));
        $this->timetablePeriod(167,132,409,6,21,1,$slot);
        $before = $this->assignmentSnapshot();
        $this->postJson('/SMT/admin/session_update',$payload)->assertStatus(422);
        $this->postJson('/SMT/admin/session_delete',['id'=>$slot])->assertStatus(422);
        $this->assertSame($before,$this->assignmentSnapshot());
        $this->assertEquals(1,DB::table('lecture_times')->value('type'));
    }

    private function academicSnapshot()
    {
        return collect(['exams2','exam_result2','students_marks','report_cards'])
            ->mapWithKeys(function ($table) { return [$table=>DB::table($table)->orderBy('id')->get()->toJson()]; })->all();
    }
}
