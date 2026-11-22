<?php

namespace Tests\Concerns;

use App\Services\AcademicVisitRecords;
use App\Services\StudentTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait AcademicVisitChecks
{
    private function activateVisits()
    {
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        require_once base_path('database/migrations/2026_11_19_000001_create_student_academic_visit_records.php');
        (new \CreateStudentAcademicVisitRecords)->up();
    }

    private function visitMove($room, array $extra = [])
    {
        $this->actingAs($this->admin);
        $service=app(StudentTransferService::class);
        $response=$service->handle(Request::create('/','POST',array_merge([
            'student_id'=>41,'class_change_id'=>2,'room_change_id'=>$room],$extra)));
        $this->assertTrue($service->succeeded(),session('warning') ?: 'Transfer rejected');
        return $response;
    }

    public function test_visits_return_multiple_times_with_distinct_summaries_and_unchanged_originals()
    {
        $f=$this->historyFixture();$this->activateVisits();$before=$this->historySnapshot();
        $mark=DB::table('students_marks')->where('student_id',41)->first();
        $card=DB::table('report_cards')->where('student_id',41)->first();
        $neighbor=DB::table('room_student')->where('student_id',42)->get()->toJson();
        foreach ([133,132,133,132] as $room) {
            $this->visitMove($room);
            $this->assertSame($before,$this->historySnapshot());
            $this->assertEquals($mark,DB::table('students_marks')->where('id',$mark->id)->first());
            $this->assertEquals($card,DB::table('report_cards')->where('id',$card->id)->first());
            $this->assertSame($room,(int)app(\App\Services\CurrentStudentMembership::class)->roomForStudent(41,6)->id);
            $this->assertSame(1,\App\Students_mark::where('student_id',41)->where('year_id',6)->count());
            $this->assertSame(1,\App\Report_card::where('student_id',41)->where('year_id',6)->count());
            $new=\App\Students_mark::where('student_id',41)->first();
            $this->assertNotEquals($mark->id,$new->id);
            $this->assertNull(json_decode($new->mark,true)[409]['exam']);
        }
        $this->assertSame(5,DB::table('students_marks')->where('student_id',41)->count());
        $this->assertSame(5,DB::table('report_cards')->where('student_id',41)->count());
        $this->assertSame(4,DB::table('student_transfer_histories')->count());
        $this->assertSame(1,DB::table('student_academic_placements')->where('student_id',41)->where('status','active')->count());
        $this->assertSame($neighbor,DB::table('room_student')->where('student_id',42)->get()->toJson());
        $this->assertDatabaseHas(AcademicVisitRecords::TABLE,['record_type'=>'modern_result','record_id'=>$f['result']->id,'placement_id'=>$f['old']]);
    }

    public function test_visits_old_zero_and_submissions_resolve_only_their_original_visit()
    {
        $f=$this->historyFixture();$this->activateVisits();$this->visitMove(133);$this->visitMove(132);
        $new=\App\StudentAcademicPlacement::where('student_id',41)->where('status','active')->first();
        $this->actingAs($f['student']);
        $old=$this->get('/SMARMANger/dashboard/student/academic-record/'.$f['old'])->assertOk();
        $this->assertSame('0',$old->viewData('assessmentRows')[0]['result']);
        $this->assertCount(2,$old->viewData('fileRows'));
        $current=$this->get('/SMARMANger/dashboard/student/academic-record/'.$new->id)->assertOk();
        $this->assertCount(0,$current->viewData('assessmentRows'));
        $this->assertCount(0,$current->viewData('fileRows'));
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$new->id.'/submissions/exam/'.$f['submission'])->assertNotFound();
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$f['old'].'/submissions/exam/'.$f['submission'])->assertOk();
        $this->assertCount(1,$this->get('/SMARMANger/dashboard/student/academic-record')->assertOk()->viewData('placements'));
    }

    public function test_visits_closed_rows_are_read_only_even_for_stale_models_and_bulk_writes()
    {
        $f=$this->historyFixture();$this->activateVisits();
        $stale=\App\Students_mark::where('student_id',41)->first();
        $this->visitMove(133);$this->visitMove(132);
        $before=$this->historySnapshot();
        foreach ([\App\Exam_result2::find($f['result']->id),$stale,
            \App\Report_card::withoutGlobalScope('academic_visit')->where('student_id',41)->orderBy('id')->first()] as $row) {
            $field=$row instanceof \App\Exam_result2?'result':($row instanceof \App\Students_mark?'mark':'teacher_notes');
            $row->$field='changed';
            try { $row->save();$this->fail('Closed original was writable'); }
            catch (\Illuminate\Validation\ValidationException $e) { $this->assertNotEmpty($e->errors()); }
        }
        $this->assertSame(0,\App\Exam_result2::whereKey($f['result']->id)->update(['result'=>99]));
        $this->assertSame(0,\App\Students_mark::withoutGlobalScope('academic_visit')->whereKey($stale->id)->update(['mark'=>'changed']));
        $this->assertSame(0,\App\Exam_file::whereKey($f['submission'])->delete());
        $this->assertSame($before,$this->historySnapshot());
        $new=\App\Students_mark::where('student_id',41)->first();
        $new->notes='Current visit';$new->save();
        $this->assertSame('Current visit',$new->fresh()->notes);
    }

    public function test_visits_independent_original_assessment_is_carried_not_overwritten_on_return()
    {
        $f=$this->historyFixture();$this->activateVisits();$this->visitMove(133);$this->visitMove(132);
        $this->actingAs($this->teacher);
        $projection=app(\App\Services\AssessmentContinuityService::class)->resolve($f['exam'],[41]);
        $this->assertSame('carried',$projection[41]['state']);
        $this->assertSame(0.0,$projection[41]['value']);
        $this->assertEquals($f['result']->id,$projection[41]['result_id']);
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$f['exam']->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>75])->assertStatus(422);
        $newExam=$this->exam(2,['name'=>'New visit quiz','is_file'=>1,'user_id'=>$this->admin->id,
            'start_date'=>now()->subHour(),'end_date'=>now()->addHour()]);
        $this->postJson('/SMARMANger/dashboard/teacher/gradebook/assessment/save',[
            'exam_id'=>$newExam->id,'room_id'=>132,'subject_id'=>409,'student_id'=>41,'value'=>25])->assertOk();
        $newResult=\App\Exam_result2::where('exam_id',$newExam->id)->firstOrFail();
        $newPlacement=\App\StudentAcademicPlacement::where('student_id',41)->where('status','active')->first();
        $this->assertDatabaseHas(AcademicVisitRecords::TABLE,['record_type'=>'modern_result','record_id'=>$newResult->id,'placement_id'=>$newPlacement->id]);
        $this->assertEquals('0',DB::table('exam_result2')->where('id',$f['result']->id)->value('result'));
        $read=app(\App\Services\GradebookReadService::class)->read(\App\Room::find(132),\App\Lesson::find(409),[41]);
        $this->assertSame('carried',$read['assessments']->firstWhere('id',$f['exam']->id)['results'][41]['state']);
        $this->assertSame(25.0,$read['assessments']->firstWhere('id',$newExam->id)['results'][41]['value']);
    }

    public function test_visits_mismatch_requires_explicit_admin_observation_and_audits_unknown_original_date()
    {
        $f=$this->historyFixture();$this->activateVisits();
        DB::table('student_academic_placements')->where('id',$f['old'])->update(['room_id'=>133]);
        $before=$this->historySnapshot();$placements=DB::table('student_academic_placements')->get()->toJson();
        $request=['student_id'=>41,'class_change_id'=>2,'room_change_id'=>133];
        $service=app(StudentTransferService::class);$this->actingAs($this->admin);
        $service->handle(Request::create('/','POST',$request));
        $this->assertFalse($service->succeeded());
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->visitMove(133,['reconcile_confirmed'=>1,'observed_room_id'=>132,
            'observed_placement_ids'=>(string)$f['old'],'reconcile_reason'=>'Verified the enrollment with the administrator.']);
        $this->assertSame($before,$this->historySnapshot());
        $audit=DB::table('student_placement_reconciliations')->first();
        $this->assertSame('unknown',json_decode($audit->before_snapshot,true)['historical_transition_date']);
        $this->assertTrue(json_decode($audit->before_snapshot,true)['confirmation_is_current_observation_only']);
        $this->assertEquals($this->admin->id,$audit->actioned_by);
        $observed=DB::table('student_academic_placements')->where('id',$audit->observed_placement_id)->first();
        $this->assertSame('verified_current_observation',$observed->reason);
        $this->assertEquals($audit->confirmed_at,$observed->effective_from);
        $this->assertSame('closed',$observed->status);
        $this->assertDatabaseHas('room_student',['student_id'=>41,'room_id'=>133]);
    }

    public function test_visits_reconciliation_rejects_stale_snapshot_and_unauthorized_confirmation()
    {
        $f=$this->historyFixture();$this->activateVisits();
        DB::table('student_academic_placements')->where('id',$f['old'])->update(['room_id'=>133]);
        $before=$this->historySnapshot();
        $data=['student_id'=>41,'class_change_id'=>2,'room_change_id'=>133,'reconcile_confirmed'=>1,
            'observed_room_id'=>132,'observed_placement_ids'=>'99999','reconcile_reason'=>'Verified with administrator, isolated test.'];
        $service=app(StudentTransferService::class);$this->actingAs($this->admin);
        $service->handle(Request::create('/','POST',$data));$this->assertFalse($service->succeeded());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $data['observed_placement_ids']=(string)$f['old'];$this->actingAs($this->teacher);
        $service->handle(Request::create('/','POST',$data));$this->assertFalse($service->succeeded());
        $this->assertSame($before,$this->historySnapshot());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
    }

    public function test_visits_transfer_failure_rolls_back_attribution_audit_and_fresh_summaries()
    {
        $this->historyFixture();$this->activateVisits();$before=$this->historySnapshot();
        $placements=DB::table('student_academic_placements')->get()->toJson();
        DB::statement("CREATE TRIGGER fixture_visit_failure BEFORE INSERT ON report_cards BEGIN SELECT RAISE(ABORT, 'fixture failure'); END");
        $this->actingAs($this->admin);$service=app(StudentTransferService::class);
        $service->handle(Request::create('/','POST',['student_id'=>41,'class_change_id'=>2,'room_change_id'=>133]));
        $this->assertFalse($service->succeeded());$this->assertSame($before,$this->historySnapshot());
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame(0,DB::table(AcademicVisitRecords::TABLE)->count());
        $this->assertSame(0,DB::table('student_transfer_histories')->count());
    }

    public function test_visits_unknown_legacy_attempts_remain_separate_and_read_only()
    {
        $f=$this->historyFixture();$this->activateVisits();$this->visitMove(133);$this->visitMove(132);
        $legacy=$this->exam(2,['name'=>'Unattributed legacy attempt']);$result=$this->result($legacy,19);
        $active=\App\StudentAcademicPlacement::where('student_id',41)->where('status','active')->first();
        $this->actingAs($f['student']);
        $url='/SMARMANger/dashboard/student/academic-record/'.$active->id;
        $this->get($url)->assertOk()->assertDontSee('Unattributed legacy attempt');
        $response=$this->get($url.'?legacy_context=1')->assertOk()->assertSee('Unattributed legacy attempt');
        $this->assertCount(1,$response->viewData('assessmentRows'));
        $this->assertSame('conflict',app(AcademicVisitRecords::class)->resultState($result));
        $read=app(\App\Services\GradebookReadService::class)->read(\App\Room::find(132),\App\Lesson::find(409),[41]);
        $this->assertNull($read['assessments']->firstWhere('id',$legacy->id)['results'][41]['value']);
        try { $result->result=20;$result->save();$this->fail('Unknown visit allowed write'); }
        catch (\Illuminate\Validation\ValidationException $e) {$this->assertNotEmpty($e->errors());}
        $this->assertEquals(19,DB::table('exam_result2')->where('id',$result->id)->value('result'));
    }

    public function test_visits_schema_activation_is_additive_and_refuses_destructive_rollback()
    {
        $this->historyFixture();$before=$this->historySnapshot();$this->activateVisits();
        $this->assertSame($before,$this->historySnapshot());
        $migration=new \CreateStudentAcademicVisitRecords;
        try {$migration->up();$this->fail('Existing table was recreated');}
        catch (\RuntimeException $e) {$this->assertStringContainsString('already or partially exists',$e->getMessage());}
        $this->visitMove(133);
        try {$migration->down();$this->fail('Retained history was dropped');}
        catch (\RuntimeException $e) {$this->assertStringContainsString('Retained visit history',$e->getMessage());}
        $this->assertGreaterThan(0,DB::table(AcademicVisitRecords::TABLE)->count());
    }

    public function test_visits_current_lessons_rosters_and_timetable_follow_each_destination_not_history()
    {
        $f=$this->historyFixture();$this->activateVisits();
        \Illuminate\Support\Facades\Schema::table('lectures',function($t){
            foreach(['year_id','room_id','teacher_id','term_id'] as $c)$t->integer($c)->nullable();
            $t->text('lecture_time')->nullable();$t->text('name')->nullable();$t->integer('key')->nullable();
        });
        \Illuminate\Support\Facades\Schema::create('about_us',function($t){$t->increments('id');$t->integer('time_zone');});
        DB::table('about_us')->insert(['time_zone'=>0]);
        foreach([501=>132,502=>133] as $id=>$room)DB::table('lectures')->insert(['id'=>$id,'room_id'=>$room,
            'class_id'=>2,'lesson_id'=>409,'teacher_id'=>166,'year_id'=>6,'term_id'=>20,'lecture_time'=>now()->subHour(),
            'active'=>0,'key'=>0,'name'=>'Lesson '.$id]);
        DB::table('teacher_room_lesson')->insert(['teacher_id'=>166,'year_id'=>6,'class_id'=>2,'room_id'=>133,'lesson_id'=>409]);
        $this->timetablePeriod(166,133,409,6);
        foreach([133,132,133,132] as $destination) {
            $this->visitMove($destination);$other=$destination===132?133:132;$lecture=$destination===132?501:502;
            $this->assertTrue(\App\Room::find($destination)->operationalStudents()->whereKey(41)->exists());
            $this->assertFalse(\App\Room::find($other)->operationalStudents()->whereKey(41)->exists());
            $this->actingAs($f['student']);
            $this->get('/SMARMANger/dashboard/student/lesson/lectures/409/'.$destination.'/41')->assertOk()->assertSee('Lesson '.$lecture);
            $this->get('/SMARMANger/dashboard/student/lesson/lectures/409/'.$other.'/41')->assertForbidden();
            $this->assertSame($destination,(int)app(\App\Services\LessonContentAccess::class)->studentLecture($lecture,409,41)->room_id);
            $data=app(\App\Http\Controllers\studentscontroller::class)->student_schedule($destination,41,0)->getData();
            $this->assertSame($destination,(int)$data['room_id']);
            $this->assertNotEmpty($data['schedule']->flatten(1));
            $this->assertSame([$destination],$data['schedule']->flatten(1)->pluck('room_id')->unique()->map(function($id){return(int)$id;})->all());
            $this->get('/SMARMANger/dashboard/students/room/view_schedule/'.$other.'/41/0')->assertForbidden();
        }
    }

    public function test_visits_ambiguous_legacy_summaries_are_retained_automatically_with_proven_current_membership()
    {
        $f=$this->historyFixture();$this->activateVisits();
        $duplicate=DB::table('students_marks')->insertGetId(['student_id'=>41,'room_id'=>132,'year_id'=>6,'mark'=>'{"409":{"exam":42}}']);
        $originals=DB::table('students_marks')->where('student_id',41)->get()->toJson();
        $this->visitMove(133);
        $audit=json_decode(DB::table('student_placement_reconciliations')->value('before_snapshot'),true);
        $this->assertSame('automatic',$audit['verification_mode']);
        $this->assertSame('matching_unique_placement_and_enrollment',$audit['verification_evidence']['basis']);
        $this->assertSame($originals,DB::table('students_marks')->where('student_id',41)->where('room_id',132)->get()->toJson());
        $this->assertSame(0,DB::table(AcademicVisitRecords::TABLE)->where('record_type','marks')->where('room_id',132)->count());
        $this->actingAs($f['student']);
        $r=$this->get('/SMARMANger/dashboard/student/academic-record/'.$f['old'].'?legacy_context=1')->assertOk();
        $this->assertCount(2,$r->viewData('markRows'));
        $this->assertSame(0,\App\Students_mark::withoutGlobalScope('academic_visit')->whereKey($duplicate)->update(['mark'=>'forbidden']));
    }

    public function test_visits_reconciliation_observation_does_not_claim_earlier_records_or_invent_missing_start_dates()
    {
        $f=$this->historyFixture();$this->activateVisits();
        DB::table('student_academic_placements')->where('student_id',41)->delete();
        $before=$this->historySnapshot();
        $this->visitMove(133,['reconcile_confirmed'=>1,'observed_room_id'=>132,'observed_placement_ids'=>'',
            'reconcile_reason'=>'Verified enrollment today; original placement start date is unknown.']);
        $this->assertSame($before,$this->historySnapshot());
        $observed=DB::table('student_placement_reconciliations')->first();
        $this->assertNull($observed->from_placement_id);
        $this->assertFalse(DB::table(AcademicVisitRecords::TABLE)->where('placement_id',$observed->observed_placement_id)->exists());
        $this->actingAs($f['student']);
        $url='/SMARMANger/dashboard/student/academic-record/'.$observed->observed_placement_id;
        $this->assertCount(0,$this->get($url)->assertOk()->viewData('assessmentRows'));
        $this->assertCount(1,$this->get($url.'?legacy_context=1')->assertOk()->viewData('assessmentRows'));
    }

    public function test_visits_admin_transfer_post_keeps_privacy_publication_and_ownership_rules()
    {
        $f=$this->historyFixture();$this->activateVisits();
        foreach([133,132]as$room)$this->actingAs($this->admin)->from('/SMT/admin/students')
            ->post('/SMT/admin/students/change',['student_id'=>41,'class_change_id'=>2,'room_change_id'=>$room])
            ->assertRedirect('/SMT/admin/students')->assertSessionHas('success');
        $this->actingAs($f['student']);$url='/SMARMANger/dashboard/student/academic-record/'.$f['old'];
        config(['student_results.student_pages_enabled'=>false]);
        $response=$this->get($url)->assertOk();
        $this->assertCount(0,$response->viewData('quizResults'));
        $this->assertCount(0,$response->viewData('marks'));
        $this->assertSame(__('student_assessments.hidden'),$response->viewData('assessmentRows')[0]['result']);
        config(['student_results.student_pages_enabled'=>true]);
        DB::table('exam_result2')->where('id',$f['result']->id)->update(['show_result'=>0]);
        $this->assertSame(__('student_assessments.hidden'),$this->get($url)->assertOk()->viewData('assessmentRows')[0]['result']);
        DB::table('exam_result2')->where('id',$f['result']->id)->update(['show_result'=>1]);
        $this->assertSame('0',$this->get($url)->assertOk()->viewData('assessmentRows')[0]['result']);
        $other=DB::table('student_academic_placements')->where('student_id',42)->value('id');
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$other)->assertNotFound();
    }

    public function test_visits_new_student_uploads_do_not_replace_old_submissions_or_files()
    {
        $f=$this->historyFixture();$this->activateVisits();$this->visitMove(133);$this->visitMove(132);
        $original=DB::table('exams_files')->where('id',$f['submission'])->first();
        $public=\Illuminate\Support\Facades\Storage::disk('public');
        config(['filesystems.disks.local.root'=>dirname($public->path(''))]);
        \Illuminate\Support\Facades\Storage::forgetDisk('local');
        $this->actingAs($f['student']);
        $this->post('/SMARMANger/dashboard/student/upload_exam_files',['exam_id'=>$f['exam']->id,
            'file'=>[\Illuminate\Http\UploadedFile::fake()->create('new-work.txt',1,'text/plain')]])->assertRedirect();
        $new=\App\Exam_file::orderByDesc('id')->firstOrFail();
        $this->assertNotEquals($original->id,$new->id);
        $this->assertNotEquals($original->file,$new->file);
        $this->assertSame(20,(int)$new->term_id);
        $this->assertEquals($original,DB::table('exams_files')->where('id',$original->id)->first());
        $this->assertSame('Original student submission',$public->get('filesstudents/my-work.txt'));
        $placement=\App\StudentAcademicPlacement::where('student_id',41)->where('status','active')->firstOrFail();
        $this->assertDatabaseHas(AcademicVisitRecords::TABLE,['record_type'=>'exam_submission','record_id'=>$new->id,'placement_id'=>$placement->id]);
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$placement->id.'/submissions/exam/'.$new->id)->assertOk();
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$f['old'].'/submissions/exam/'.$original->id)->assertOk();

        $count=\App\Exam_file::count();$paths=\Illuminate\Support\Facades\Storage::allFiles('public/filesstudents');
        DB::statement("CREATE TRIGGER fixture_submission_failure BEFORE INSERT ON student_academic_visit_records BEGIN SELECT RAISE(ABORT, 'fixture submission failure'); END");
        $this->post('/SMARMANger/dashboard/student/upload_exam_files',['exam_id'=>$f['exam']->id,
            'file'=>[\Illuminate\Http\UploadedFile::fake()->create('failed-work.txt',1,'text/plain')]])->assertStatus(500);
        $this->assertSame($count,\App\Exam_file::count());
        $this->assertSame($paths,\Illuminate\Support\Facades\Storage::allFiles('public/filesstudents'));
        $this->assertSame('Original student submission',$public->get('filesstudents/my-work.txt'));
    }

    public function test_visits_repeated_same_destination_post_is_idempotent()
    {
        $this->historyFixture();$this->activateVisits();$this->visitMove(133);
        $visits=DB::table('student_academic_placements')->get()->toJson();
        $links=DB::table(AcademicVisitRecords::TABLE)->get()->toJson();
        $service=app(StudentTransferService::class);
        $service->handle(Request::create('/','POST',['student_id'=>41,'class_change_id'=>2,'room_change_id'=>133]));
        $this->assertFalse($service->succeeded());
        $this->assertSame($visits,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame($links,DB::table(AcademicVisitRecords::TABLE)->get()->toJson());
        $this->assertSame(1,DB::table('student_transfer_histories')->count());
    }

    public function test_visits_explicit_equivalence_retains_the_original_result_once_through_returns()
    {
        $f=$this->historyFixture();$peer=$this->exam(2,['room_id'=>133]);$this->actingAs($this->admin);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$f['exam']->id,$peer->id],'Verified identical occurrence');
        $this->activateVisits();
        foreach([133,132,133,132]as$room) {
            $this->visitMove($room);$definition=$room===132?$f['exam']:$peer;
            $resolved=app(\App\Services\AssessmentContinuityService::class)->resolve($definition,[41])[41];
            $this->assertSame('carried',$resolved['state']);$this->assertSame(0.0,$resolved['value']);
            $this->assertEquals($f['result']->id,$resolved['result_id']);
            $this->assertEquals($f['exam']->id,$resolved['exam_id']);
            $this->assertSame(1,\App\Exam_result2::where('user_id',41)->count());
        }
    }

    public function test_visits_activation_after_a_legacy_transfer_recognizes_the_single_proven_original_visit()
    {
        $f=$this->historyFixture();$this->moveToB();$before=$this->historySnapshot();
        $this->activateVisits();$this->visitMove(132);
        $this->assertSame($before,$this->historySnapshot());
        $this->assertDatabaseHas(AcademicVisitRecords::TABLE,['record_type'=>'modern_result','record_id'=>$f['result']->id,'placement_id'=>$f['old']]);
        $this->actingAs($f['student']);
        $old=$this->get('/SMARMANger/dashboard/student/academic-record/'.$f['old'])->assertOk();
        $this->assertSame('0',$old->viewData('assessmentRows')[0]['result']);
        $this->assertCount(2,$old->viewData('fileRows'));
    }
}
