<?php

namespace Tests\Concerns;

use App\Exam_result2;
use App\Services\AcademicVisitRecords;
use App\Services\AcademicWriteObservation;
use App\Services\AssessmentContinuityService;
use App\Services\TeacherAssessmentService;
use App\StudentAcademicPlacement;
use Illuminate\Support\Facades\DB;

trait AcademicWriteObservationChecks
{
    private function observedFixture($oldRoom = 130)
    {
        $this->studentUiFixture();
        $this->activateContinuity(); $this->activateVisits();
        foreach ([130,131,154] as $id) DB::table('rooms')->insert(['id'=>$id,'class_id'=>2,'year_id'=>6,'name'=>'Section '.$id]);
        $this->timetablePeriod(166,131,409,6);
        DB::table('room_student')->where('student_id',41)->update(['room_id'=>131,'updated_at'=>now()->subHour()]);
        DB::table('student_academic_placements')->where('student_id',41)->update(['room_id'=>$oldRoom,'updated_at'=>now()->subHours(2)]);
        $target=$this->exam(2,['room_id'=>131]); $source=$this->exam(2,['room_id'=>$oldRoom]);
        $this->actingAs($this->admin);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$target->id,$source->id],'Isolated current observation');
        $this->actingAs($this->teacher);
        return [$target,$source];
    }

    private function observedSave($exam, $value = 0)
    {
        return $this->postJson('/SMARMANger/dashboard/teacher/student_save_mark_quize',[
            'exam_id'=>$exam->id,'room_id'=>$exam->room_id,'lesson_id'=>409,'user_id'=>41,'mark'=>$value]);
    }

    public function test_observation_current_131_stale_130_or_154_saves_zero_and_audits_only_present_state()
    {
        [$exam]=$this->observedFixture();
        $old=StudentAcademicPlacement::where('student_id',41)->first();
        $enrollment=DB::table('room_student')->orderBy('id')->get()->toJson();
        $identity=DB::table('students')->orderBy('id')->get()->toJson();
        $this->get('/SMARMANger/dashboard/teacher/teacher_quize_students/131/166/409/'.$exam->id)->assertOk()->assertSee('traditional-mark-41');
        $this->observedSave($exam)->assertOk();
        $result=Exam_result2::where('exam_id',$exam->id)->firstOrFail();
        $active=StudentAcademicPlacement::where('student_id',41)->where('status','active')->firstOrFail();
        $this->assertEquals('0',$result->result); $this->assertEquals(131,$active->room_id);
        $this->assertSame('academic_write_observation',$active->action_source);
        $this->assertEquals(now(),$active->effective_from);
        $this->assertEquals($old->effective_from,$old->fresh()->effective_from);
        $this->assertSame('closed',$old->fresh()->status); $this->assertEquals(now(),$old->fresh()->effective_to);
        $this->assertDatabaseHas(AcademicVisitRecords::TABLE,['record_type'=>'modern_result','record_id'=>$result->id,'placement_id'=>$active->id]);
        $audit=DB::table('student_placement_reconciliations')->first();
        $snapshot=json_decode($audit->before_snapshot,true);
        $this->assertSame('unknown',$snapshot['historical_transition_date']);
        $this->assertSame('active',$snapshot['placements'][0]['status']);
        $this->assertEquals($this->teacher->id,$audit->actioned_by);
        $this->assertSame(0,DB::table('student_transfer_histories')->count());
        $this->assertSame($enrollment,DB::table('room_student')->orderBy('id')->get()->toJson());
        $this->assertSame($identity,DB::table('students')->orderBy('id')->get()->toJson());
        $this->observedSave($exam,12)->assertOk()->assertJsonPath('result_id',$result->id);
        $this->assertSame(1,DB::table('student_placement_reconciliations')->count());
        $this->assertSame(1,Exam_result2::count());
        $this->assertSame(1,\App\Students_mark::where('student_id',41)->count());
        $this->assertSame(1,\App\Report_card::where('student_id',41)->count());
        // A second, different stale section has the same proof, not a special case for 130.
        DB::table('room_student')->where('student_id',42)->update(['room_id'=>131,'updated_at'=>now()->subHour()]);
        DB::table('student_academic_placements')->where('student_id',42)->update(['room_id'=>154,'updated_at'=>now()->subHours(2)]);
        $saved=app(TeacherAssessmentService::class)->save($exam->id,42,131,409,23);
        $this->assertEquals(23,$saved->result);
        $this->assertSame(2,DB::table('student_placement_reconciliations')->count());
        $this->assertSame('current',app(AssessmentContinuityService::class)->resolve($exam,[41,42])[42]['state']);
    }

    public function test_observation_preserves_original_current_and_old_zeroes_and_publication_in_real_readers()
    {
        [$target,$source]=$this->observedFixture();
        $oldExam=$this->exam(2,['room_id'=>130]);
        $old=$this->result($oldExam,0,['created_at'=>now()->subHours(3)]);
        $currentExam=$this->exam(2,['room_id'=>131]); $peer=$this->exam(2,['room_id'=>130]);
        $this->actingAs($this->admin);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$currentExam->id,$peer->id],'Existing original current zero');
        $current=$this->result($currentExam,0,['created_at'=>now()->subMinutes(30)]);
        $originals=DB::table('exam_result2')->orderBy('id')->get()->toJson();
        $this->actingAs($this->teacher); $this->observedSave($target,15)->assertOk();
        $this->assertSame($originals,DB::table('exam_result2')->whereIn('id',[$old->id,$current->id])->orderBy('id')->get()->toJson());
        $projection=app(AssessmentContinuityService::class)->resolve($currentExam,[41])[41];
        $this->assertSame('current',$projection['state']); $this->assertSame(0.0,$projection['value']);
        $this->assertEquals($current->id,$projection['result_id']);
        $read=app(\App\Services\GradebookReadService::class)->read(\App\Room::find(131),\App\Lesson::find(409),[41]);
        $this->assertSame(0.0,$read['assessments']->firstWhere('id',$currentExam->id)['results'][41]['value']);
        $this->assertSame(15.0,$read['assessments']->firstWhere('id',$target->id)['results'][41]['value']);
        $student=$this->studentUiFixture(); $this->actingAs($student);
        $cards=$this->get('/SMARMANger/dashboard/student/room/main_quizes/131/41')->assertOk()->viewData('exams');
        $this->assertSame('earned',$cards->firstWhere('id',$target->id)->result_state);
        $active=StudentAcademicPlacement::where('student_id',41)->where('status','active')->first();
        $detail=$this->get('/SMARMANger/dashboard/student/academic-record/'.$active->id)->assertOk();
        $this->assertCount(2,$detail->viewData('assessmentRows'));
        $closed=StudentAcademicPlacement::where('student_id',41)->where('status','closed')->first();
        $this->assertCount(1,$this->get('/SMARMANger/dashboard/student/academic-record/'.$closed->id)->assertOk()->viewData('assessmentRows'));
        config(['student_results.student_pages_enabled'=>false]);
        $this->assertSame('hidden',$this->get('/SMARMANger/dashboard/student/room/main_quizes/131/41')->assertOk()->viewData('exams')->firstWhere('id',$target->id)->result_state);
    }

    public function test_observation_unresolved_original_context_rolls_back_and_is_not_reported_as_carried_grade()
    {
        [$exam]=$this->observedFixture();
        $other=$this->exam(2,['room_id'=>131]);
        $original=$this->result($other,10,['created_at'=>now()->subHours(3)]);
        $before=DB::table('student_academic_placements')->orderBy('id')->get()->toJson();
        $plan=app(AcademicWriteObservation::class)->plan(41,\App\Room::find(131));
        $this->assertFalse($plan['safe']); $this->assertSame('unresolved_original_context',$plan['reason']);
        $this->observedSave($exam)->assertStatus(422)->assertJsonValidationErrors('assessment')
            ->assertJsonPath('errors.assessment.0',__('gradebook.placement_inconsistent'));
        $this->assertSame($before,DB::table('student_academic_placements')->orderBy('id')->get()->toJson());
        $this->assertSame(1,Exam_result2::count()); $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $this->assertSame(0,DB::table(AcademicVisitRecords::TABLE)->count());
        $this->assertEquals(10,$original->fresh()->result);
    }

    public function test_observation_rolls_back_after_creation_error_then_retry_is_idempotent()
    {
        [$exam]=$this->observedFixture();
        $before=DB::table('student_academic_placements')->orderBy('id')->get()->toJson();
        DB::unprepared("CREATE TRIGGER reject_observation_report BEFORE INSERT ON report_cards BEGIN SELECT RAISE(ABORT, 'isolated report failure'); END");
        try { app(TeacherAssessmentService::class)->save($exam->id,41,131,409,0); $this->fail('Expected injected failure'); }
        catch (\Illuminate\Database\QueryException $e) { $this->assertStringContainsString('isolated report failure',$e->getMessage()); }
        $this->assertSame($before,DB::table('student_academic_placements')->orderBy('id')->get()->toJson());
        foreach (['exam_result2','students_marks','report_cards','student_placement_reconciliations',AcademicVisitRecords::TABLE] as $table) $this->assertSame(0,DB::table($table)->count());
        DB::unprepared('DROP TRIGGER reject_observation_report');
        $this->observedSave($exam)->assertOk(); $this->observedSave($exam)->assertOk();
        $this->assertSame(1,DB::table('student_placement_reconciliations')->count()); $this->assertSame(1,Exam_result2::count());
    }

    public function test_observation_participation_is_attributed_then_original_placeholder_accepts_zero()
    {
        [$exam]=$this->observedFixture();
        app(TeacherAssessmentService::class)->participants($exam->id,131,409,2,false,[41]);
        $blank=Exam_result2::where('exam_id',$exam->id)->firstOrFail();
        $this->assertNull($blank->result); $this->assertSame(1,DB::table('student_placement_reconciliations')->count());
        $this->assertSame('current',app(AcademicVisitRecords::class)->resultState($blank));
        $this->observedSave($exam)->assertOk()->assertJsonPath('result_id',$blank->id);
        $this->assertEquals('0',$blank->fresh()->result);
    }

    public function test_observation_submissions_keep_file_contract_and_fail_safely_without_an_authenticated_actor()
    {
        [$exam]=$this->observedFixture(); \Illuminate\Support\Facades\Storage::fake('public');
        $student=$this->studentUiFixture(); $this->actingAs($student);
        $this->postJson('/api/dashboard/student/upload_exam_files2',$this->mobilePayload($exam))->assertOk()->assertExactJson(['status'=>true,'msg'=>'تم الترفيع بنجاح']);
        $this->assertSame(2,DB::table('exams_files')->count());
        $this->assertSame(1,DB::table('student_placement_reconciliations')->count());
        $this->assertSame(2,DB::table(AcademicVisitRecords::TABLE)->where('record_type','exam_submission')->count());
        // A legacy unauthenticated request cannot invent an audit actor or repair another student.
        auth()->logout();
        DB::table('room_student')->where('student_id',42)->update(['room_id'=>131,'updated_at'=>now()->subHour()]);
        DB::table('student_academic_placements')->where('student_id',42)->update(['room_id'=>154,'updated_at'=>now()->subHours(2)]);
        $files=\Illuminate\Support\Facades\Storage::disk('public')->allFiles();
        $payload=array_replace($this->mobilePayload($exam),['student_id'=>42]);
        $this->postJson('/api/dashboard/student/upload_exam_files2',$payload)->assertOk()->assertJson(['status'=>false]);
        $this->assertSame($files,\Illuminate\Support\Facades\Storage::disk('public')->allFiles());
        $this->assertSame(0,DB::table('exams_files')->where('student_id',42)->count());
    }

    public function test_observation_does_not_bypass_carried_zero_permissions_or_repeat_visit_history()
    {
        [$target,$source]=$this->observedFixture();
        $sourceZero=$this->result($source,0,['created_at'=>now()->subHours(3)]);
        $this->observedSave($target,10)->assertStatus(422)->assertJsonPath('errors.assessment.0',__('gradebook.carried_read_only'));
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $new=$this->exam(2,['room_id'=>131]);
        $this->observedSave($new,15)->assertOk();
        $this->visitMove(132); $this->visitMove(131); $this->actingAs($this->teacher);
        $this->observedSave($new,20)->assertStatus(422)->assertJsonPath('errors.assessment.0',__('gradebook.carried_read_only'));
        $another=$this->exam(2,['room_id'=>131]); $this->observedSave($another,0)->assertOk();
        $this->assertEquals('0',$sourceZero->fresh()->result);
        $this->assertSame(1,DB::table('student_placement_reconciliations')->count());
        $this->assertSame(2,DB::table('student_transfer_histories')->where('student_id',41)->count());
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$another->id,'room_id'=>131,'subject_id'=>409,'student_id'=>42,'value'=>20])->assertForbidden();
    }

    public function test_observation_report_import_uses_fresh_summary_without_changing_source_summary_or_finance()
    {
        [$quiz]=$this->observedFixture();
        DB::table('students_marks')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>130,'mark'=>'{"409":{"quize":0}}','created_at'=>now()->subHours(3)]);
        DB::table('report_cards')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>130,'class'=>2,'teacher_notes'=>'Preserved report','created_at'=>now()->subHours(3)]);
        \Illuminate\Support\Facades\Schema::create('invoices',function($t){$t->increments('id');$t->integer('student_id');$t->integer('invoice_amount');});
        DB::table('invoices')->insert(['student_id'=>41,'invoice_amount'=>123]);
        $marks=DB::table('students_marks')->first(); $report=DB::table('report_cards')->first();
        $finance=DB::table('invoices')->get()->toJson();
        $this->observedSave($quiz,15)->assertOk();
        $exam=$this->exam(1,['room_id'=>131]);
        app(TeacherAssessmentService::class)->save($exam->id,41,131,409,30);
        foreach (['export_exam'=>$quiz,'export_exam1'=>$exam] as $path=>$definition) {
            $this->post('/SMARMANger/dashboard/teacher/'.$path.'/'.$definition->id.'/131/409')->assertRedirect()->assertSessionHasNoErrors();
        }
        $active=\App\Students_mark::where('student_id',41)->firstOrFail();
        $this->assertEquals(131,$active->room_id);
        $this->assertEquals(15,json_decode($active->mark,true)[409]['quize']);
        $this->assertEquals(30,json_decode($active->mark,true)[409]['exam']);
        $this->assertEquals(45,json_decode($active->result1,true)[409]['term1_result']);
        $this->assertEquals($marks,DB::table('students_marks')->where('id',$marks->id)->first());
        $this->assertEquals($report,DB::table('report_cards')->where('id',$report->id)->first());
        $this->assertSame($finance,DB::table('invoices')->get()->toJson());
        $this->assertEquals(131,\App\Report_card::where('student_id',41)->firstOrFail()->room_id);
    }

    public function test_observation_rejects_competing_context_or_unauthorized_teacher_without_any_observation()
    {
        [$exam]=$this->observedFixture();
        $before=DB::table('student_academic_placements')->get()->toJson();
        DB::table('lesson_room_teacher_lecture_time')->where('teacher_id',166)->where('room_id',131)->delete();
        $this->observedSave($exam)->assertForbidden();
        $this->timetablePeriod(166,131,409,6);
        DB::table('room_student')->insert(['student_id'=>41,'room_id'=>130,'year_id'=>6]);
        $this->observedSave($exam)->assertForbidden();
        $this->assertSame($before,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $this->assertSame(0,Exam_result2::count());
    }

    public function test_observation_existing_current_placeholders_and_summary_are_linked_without_rewriting_them()
    {
        [$exam]=$this->observedFixture();
        $other=$this->exam(2,['room_id'=>131]);
        $placeholder=$this->result($other,null,['status'=>0,'show_result'=>0,'created_at'=>now()->subMinutes(30)]);
        DB::table('students_marks')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>131,'mark'=>'{"409":{"exam":0}}','created_at'=>now()->subMinutes(30)]);
        DB::table('report_cards')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>131,'class'=>2,'teacher_notes'=>'Existing current report','created_at'=>now()->subMinutes(30)]);
        $summaries=[DB::table('students_marks')->get()->toJson(),DB::table('report_cards')->get()->toJson()];
        $blank=$placeholder->getRawOriginal();
        $this->observedSave($exam,10)->assertOk();
        $this->assertSame($blank,$placeholder->fresh()->getRawOriginal());
        $this->assertSame($summaries,[DB::table('students_marks')->get()->toJson(),DB::table('report_cards')->get()->toJson()]);
        $this->assertSame('current',app(AcademicVisitRecords::class)->resultState($placeholder));
        $saved=app(TeacherAssessmentService::class)->save($other->id,41,131,409,0);
        $this->assertEquals($placeholder->id,$saved->id);
        $this->assertSame(1,DB::table('students_marks')->count()); $this->assertSame(1,DB::table('report_cards')->count());
    }

    public function test_observation_unknown_dates_duplicate_summaries_and_wrong_record_context_stay_blocked()
    {
        [$exam]=$this->observedFixture();
        $other=$this->exam(2,['room_id'=>131]);
        $record=$this->result($other,0,['created_at'=>null]);
        $this->observedSave($exam)->assertStatus(422)->assertJsonPath('errors.assessment.0',__('gradebook.placement_inconsistent'));
        DB::table('exam_result2')->where('id',$record->id)->update(['created_at'=>now(),'term_id'=>17]);
        $this->observedSave($exam)->assertStatus(422);
        DB::table('exam_result2')->where('id',$record->id)->update(['term_id'=>20]);
        foreach ([1,2] as $n) DB::table('students_marks')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>131,'created_at'=>now()]);
        $plan=app(AcademicWriteObservation::class)->plan(41,\App\Room::find(131));
        $this->assertSame('duplicate_summary',$plan['reason']);
        $this->observedSave($exam)->assertStatus(422);
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $this->assertSame(1,Exam_result2::count());
    }

    public function test_observation_aligned_placements_do_not_create_a_reconciliation()
    {
        $this->studentUiFixture(); $this->activateVisits();
        $exam=$this->exam(2); $this->actingAs($this->teacher);
        $before=DB::table('student_academic_placements')->get()->toJson();
        $zero=app(TeacherAssessmentService::class)->save($exam->id,41,132,409,0);
        $this->assertEquals('0',$zero->result);
        $this->assertSame($before,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $this->assertSame(0,DB::table('students_marks')->count());
    }

    public function test_observation_dynamic_grade_entry_uses_the_same_guard_and_calculations()
    {
        $this->observedFixture(); $payload=$this->dynamic();
        $payload['room_id']=131; $payload['value']=0;
        $this->postJson($this->saveUrl,$payload)->assertOk()->assertJsonPath('total',0);
        $result=Exam_result2::where('user_id',41)->firstOrFail();
        $this->assertEquals(131,$result->room_id);
        $this->assertSame('current',app(AcademicVisitRecords::class)->resultState($result));
        $this->assertSame(1,DB::table('student_placement_reconciliations')->count());
        $payload['value']=12; $this->postJson($this->saveUrl,$payload)->assertOk()->assertJsonPath('total',12);
        $this->assertSame(1,Exam_result2::where('user_id',41)->count());
    }

    public function test_observation_legacy_grade_creation_preserves_original_definition_and_context()
    {
        $this->observedFixture();
        $id=DB::table('lesson_teacher_room_term_exam')->insertGetId(['class_id'=>2,'room_id'=>131,'lesson_id'=>409,'term_id'=>20,'type'=>8,'name_exam'=>'Legacy oral']);
        $definition=DB::table('lesson_teacher_room_term_exam')->where('id',$id)->first();
        $record=new \App\Exam_result();
        $record->forceFill(['user_id'=>41,'exam_id'=>$id,'room_id'=>131,'class_id'=>2,'lesson_id'=>409,'term_id'=>20,'type'=>8,'result'=>'0','status'=>'1'])->save();
        $this->assertSame('current',app(AcademicVisitRecords::class)->resultState($record));
        $this->assertEquals($definition,DB::table('lesson_teacher_room_term_exam')->where('id',$id)->first());
        $read=app(\App\Services\GradebookReadService::class)->read(\App\Room::find(131),\App\Lesson::find(409),[41]);
        $this->assertSame(0.0,$read['marks'][41][20]['total']);
    }

    public function test_observation_web_student_submissions_append_and_keep_own_history_rows_and_bytes()
    {
        $this->observedFixture(); $student=\App\User::where('student_id',41)->where('type',0)->firstOrFail();
        $id=DB::table('lesson_teacher_room_term_exam')->insertGetId(['class_id'=>2,'room_id'=>131,'lesson_id'=>409,'term_id'=>20,'type'=>2]);
        $this->actingAs($student);
        foreach (['first','second'] as $name) {
            $this->post('/SMARMANger/dashboard/student/upload_files',['item_id'=>$id,
                'file'=>[\Illuminate\Http\UploadedFile::fake()->create($name.'.txt',1,'text/plain')]])->assertRedirect()->assertSessionHasNoErrors();
        }
        $this->assertSame(2,DB::table('student_lesson_teacher_room_term_exam')->where('student_id',41)->count());
        $active=StudentAcademicPlacement::where('student_id',41)->where('status','active')->firstOrFail();
        $this->assertSame(2,DB::table(AcademicVisitRecords::TABLE)->where('record_type','lesson_submission')->count());
        $records=DB::table('student_lesson_teacher_room_term_exam')->where('student_id',41)->orderBy('id')->get();
        $before=$records->toJson();
        $this->visitMove(132); $this->actingAs($student);
        $this->assertSame($before,DB::table('student_lesson_teacher_room_term_exam')->where('student_id',41)->orderBy('id')->get()->toJson());
        $this->assertCount(2,$this->get('/SMARMANger/dashboard/student/academic-record/'.$active->id)->assertOk()->viewData('fileRows'));
        foreach ($records as $row) $this->assertTrue(\Illuminate\Support\Facades\Storage::disk('local')->exists($row->file));
        // Existing disk mapping: Web writes local/public/filesstudents, whereas
        // historical downloads read public/filesstudents on the public disk.
        // Keep the original bytes; do not change that unrelated storage contract.
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$active->id.'/submissions/lesson/'.$records->first()->id)->assertNotFound();
        $this->get('/SMARMANger/dashboard/student/lesson/lectures/409/131/41')->assertForbidden();
    }

    public function test_observation_keeps_student_follow_ups_from_both_sections_visible_and_unchanged()
    {
        [$exam]=$this->observedFixture();
        \Illuminate\Support\Facades\Schema::create('student_follow_ups',function($t){
            $t->increments('id');
            foreach (['student_id','teacher_id','lesson_id','year_id','term_id','class_id','room_id','student_academic_placement_id','compliance_half'] as $field) $t->integer($field)->nullable();
            foreach (['observed_at','compliance_month','level','note','voided_at'] as $field) $t->text($field)->nullable();
            $t->timestamps();
        });
        foreach ([130,131] as $room) DB::table('student_follow_ups')->insert(['student_id'=>41,'teacher_id'=>166,'lesson_id'=>409,
            'year_id'=>6,'term_id'=>20,'class_id'=>2,'room_id'=>$room,'level'=>'very_good','note'=>'Original section '.$room,
            'observed_at'=>now()->subMinutes(30),'created_at'=>now()->subMinutes(30),'compliance_month'=>'2026-10-01','compliance_half'=>2]);
        DB::table('student_follow_ups')->insert(['student_id'=>42,'year_id'=>6,'room_id'=>132,'compliance_month'=>'2026-10-01','note'=>'Other student']);
        $before=DB::table('student_follow_ups')->orderBy('id')->get()->toJson();
        $this->observedSave($exam,15)->assertOk();
        $this->actingAs(\App\User::where('type',0)->where('student_id',41)->firstOrFail());
        $page=$this->get('/SMARMANger/dashboard/student/follow-ups')->assertOk()->assertSee('Original section 130')->assertSee('Original section 131')->assertDontSee('Other student');
        $this->assertEquals([1,2],$page->viewData('followUps')->flatten(1)->pluck('id')->sort()->values()->all());
        $this->assertSame($before,DB::table('student_follow_ups')->orderBy('id')->get()->toJson());
    }

    public function test_observation_placement_and_closed_empty_participation_errors_do_not_claim_a_preserved_grade()
    {
        [$exam]=$this->observedFixture();
        DB::table('student_academic_placements')->insert(['student_id'=>41,'year_id'=>6,'class_id'=>2,'room_id'=>131,
            'status'=>'closed','effective_from'=>now()->subDays(3),'effective_to'=>now()->subDays(2)]);
        $this->observedSave($exam)->assertStatus(422)->assertJsonPath('errors.assessment.0',__('gradebook.placement_inconsistent'));
        DB::table('student_academic_placements')->where('student_id',41)->where('status','closed')->delete();
        $this->observedSave($exam)->assertOk();
        $automated=$this->exam(2,['room_id'=>131,'is_file'=>0,'has_traditional'=>1]);
        app(TeacherAssessmentService::class)->participants($automated->id,131,409,2,false,[41]);
        $blank=Exam_result2::where('exam_id',$automated->id)->firstOrFail();
        $before=$blank->getRawOriginal(); $this->visitMove(132); $this->visitMove(131); $this->actingAs($this->teacher);
        try { app(TeacherAssessmentService::class)->save($automated->id,41,131,409,0); $this->fail('Closed placeholder reused'); }
        catch (\Illuminate\Validation\ValidationException $e) { $this->assertSame([__('gradebook.historical_record_read_only')],$e->errors()['assessment']); }
        $this->assertSame($before,$blank->fresh()->getRawOriginal());
    }
}
