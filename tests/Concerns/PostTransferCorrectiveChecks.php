<?php

namespace Tests\Concerns;

use App\Services\AcademicVisitRecords;
use App\Services\AcademicVisitReadContext;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait PostTransferCorrectiveChecks
{
    private function mobilePayload($exam, $multiple = true)
    {
        return ['student_id'=>41, 'item_id'=>$exam->id,
            'file'=>$multiple ? json_encode([base64_encode('first'),base64_encode('second')]) : base64_encode('first'),
            'extension'=>$multiple ? json_encode(['.txt','.txt']) : 'txt'];
    }

    public function test_corrective_mobile_uses_actual_assessment_term_and_rejects_old_year_and_wrong_membership_before_writing()
    {
        $student=$this->studentUiFixture();$this->activateVisits();Storage::fake('public');
        $this->actingAs($student);
        foreach ([20,21] as $term) {
            $exam=$this->exam(2,['term_id'=>$term]);
            $this->postJson('/api/dashboard/student/upload_exam_files',$this->mobilePayload($exam,false))
                ->assertOk()->assertExactJson(['status'=>true,'msg'=>'تم الترفيع بنجاح']);
            $this->assertDatabaseHas('exams_files',['exam_id'=>$exam->id,'student_id'=>41,'term_id'=>$term]);
        }
        $before=DB::table('exams_files')->get()->toJson();$files=Storage::disk('public')->allFiles();
        foreach ([['term_id'=>17],['room_id'=>93,'term_id'=>17],['room_id'=>133],['class_id'=>99]] as $context) {
            $exam=$this->exam(2,$context);
            $this->postJson('/api/dashboard/student/upload_exam_files2',$this->mobilePayload($exam))->assertOk()->assertJson(['status'=>false]);
            $this->assertSame($before,DB::table('exams_files')->get()->toJson());
            $this->assertSame($files,Storage::disk('public')->allFiles());
        }
        $exam=$this->exam(2);
        $this->postJson('/api/dashboard/student/upload_exam_files',array_replace($this->mobilePayload($exam,false),['student_id'=>42]))->assertForbidden();
        $this->assertSame($before,DB::table('exams_files')->get()->toJson());
    }

    public function test_corrective_mobile_database_failure_rolls_back_all_new_rows_links_and_files_but_keeps_earlier_uploads()
    {
        $this->studentUiFixture();$this->activateVisits();Storage::fake('public');$exam=$this->exam(2);
        $url='/api/dashboard/student/upload_exam_files2';
        $this->postJson($url,$this->mobilePayload($exam))->assertOk()->assertJson(['status'=>true]);
        $before=DB::table('exams_files')->orderBy('id')->get()->toJson();
        $links=DB::table(AcademicVisitRecords::TABLE)->orderBy('id')->get()->toJson();
        $files=Storage::disk('public')->allFiles();
        DB::unprepared("CREATE TRIGGER fail_second_mobile_file BEFORE INSERT ON exams_files WHEN (SELECT COUNT(*) FROM exams_files) >= 3 BEGIN SELECT RAISE(ABORT, 'fixture second insert'); END");
        $response=$this->postJson($url,$this->mobilePayload($exam))->assertOk()->assertJson(['status'=>false]);
        $this->assertSame(['status','msg'],array_keys($response->json()));
        $this->assertStringNotContainsString('fixture second insert',$response->getContent());
        $this->assertSame($before,DB::table('exams_files')->orderBy('id')->get()->toJson());
        $this->assertSame($links,DB::table(AcademicVisitRecords::TABLE)->orderBy('id')->get()->toJson());
        $this->assertSame($files,Storage::disk('public')->allFiles());
        foreach($files as $file)$this->assertContains(Storage::disk('public')->get($file),['first','second']);
    }

    public function test_corrective_mobile_failed_storage_write_is_compensated_including_partial_bytes()
    {
        $this->studentUiFixture();$this->activateVisits();Storage::fake('public');$disk=Storage::disk('public');
        $disk->put('filesstudents/earlier.txt','retained');$exam=$this->exam(2);
        $writes=0;$throws=false;$proxy=\Mockery::mock(\Illuminate\Contracts\Filesystem\Filesystem::class);
        $proxy->shouldReceive('put')->times(4)->andReturnUsing(function($path,$bytes)use($disk,&$writes,&$throws){
                $disk->put($path,$bytes);
                if(++$writes===2){if($throws)throw new \RuntimeException('fixture storage interruption');return false;}
                return true;
        });
        $proxy->shouldReceive('delete')->times(4)->andReturnUsing(function($path)use($disk){return $disk->delete($path);});
        Storage::shouldReceive('disk')->with('public')->andReturn($proxy);
        foreach([false,true] as $throws){
            $writes=0;
            $this->postJson('/api/dashboard/student/upload_exam_files2',$this->mobilePayload($exam))->assertOk()->assertJson(['status'=>false]);
            $this->assertSame(['filesstudents/earlier.txt'],$disk->allFiles());
            $this->assertSame('retained',$disk->get('filesstudents/earlier.txt'));
            $this->assertSame(0,DB::table('exams_files')->count());
            $this->assertSame(0,DB::table(AcademicVisitRecords::TABLE)->count());
        }
    }

    public function test_corrective_mobile_invalid_wire_payloads_keep_error_contract_without_files()
    {
        $this->studentUiFixture();Storage::fake('public');$exam=$this->exam(2);$payload=$this->mobilePayload($exam);
        foreach ([['file'=>'not-json'],['extension'=>json_encode(['.txt'])],['file'=>json_encode(['not base64!','bad'])],
            ['extension'=>json_encode(['../txt','.txt'])],['file'=>'null']] as $bad) {
            $response=$this->postJson('/api/dashboard/student/upload_exam_files2',array_replace($payload,$bad))->assertOk()->assertJson(['status'=>false]);
            $this->assertSame(['status','msg'],array_keys($response->json()));
            $this->assertSame(0,DB::table('exams_files')->count());
            $this->assertSame([],Storage::disk('public')->allFiles());
        }
        $this->postJson('/api/dashboard/student/upload_exam_files',['item_id'=>$exam->id])->assertExactJson(['status'=>false,'msg'=>' extension is required']);
    }

    public function test_corrective_unused_participation_never_removes_marks_attempts_submissions_or_completed_placeholders()
    {
        $this->activateVisits();$this->actingAs($this->teacher);
        \Illuminate\Support\Facades\Schema::create('exam_result_tester',function($t){$t->increments('id');$t->integer('exam_id');$t->integer('user_id');});
        foreach ([['result'=>0],['user_answers'=>'[]'],['start_time'=>'2026-10-22 10:00:00'],
            ['end_time'=>'2026-10-22 10:01:00'],['traditional_result'=>'0'],['selected_ques'=>'[]'],['status'=>1],['medal'=>1],['submission'=>true],['tester_submission'=>true]] as $activity) {
            $exam=$this->exam(2,['is_file'=>0,'has_traditional'=>1]);$submission=$activity['submission']??false;$tester=$activity['tester_submission']??false;unset($activity['submission'],$activity['tester_submission']);
            $row=$this->result($exam,null,array_replace(['status'=>0,'show_result'=>0],$activity));
            app(AcademicVisitRecords::class)->bind($row,\App\StudentAcademicPlacement::where('student_id',41)->first(),'fixture');
            if($submission)DB::table('exams_files')->insert(['exam_id'=>$exam->id,'student_id'=>41,'room_id'=>132,'term_id'=>20,'file'=>'retained.txt']);
            if($tester)DB::table('exam_result_tester')->insert(['exam_id'=>$exam->id,'user_id'=>41]);
            $before=$row->getRawOriginal();
            $this->postJson('/SMARMANger/dashboard/teacher/add_quize_student',[
                'exam'=>$exam->id,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'all'=>0,'student'=>[],
            ])->assertStatus(422);
            $this->assertSame($before,$row->fresh()->getRawOriginal());
            $this->assertDatabaseHas(AcademicVisitRecords::TABLE,['record_type'=>'modern_result','record_id'=>$row->id]);
            $this->actingAs($this->admin)->postJson('/SMT/admin/class/room/exam_quize/delete',[
                'content_id'=>$exam->id,'delete_code'=>'test-delete'])->assertStatus(422);
            $this->actingAs($this->teacher);
        }
    }

    public function test_corrective_unused_current_placeholder_removal_rolls_back_its_link_on_later_failure()
    {
        $this->activateVisits();$this->actingAs($this->teacher);$exam=$this->exam(2,['is_file'=>0,'has_traditional'=>0]);
        $service=app(\App\Services\TeacherAssessmentService::class);
        $service->participants($exam->id,132,409,2,false,[41]);
        $row=\App\Exam_result2::where('exam_id',$exam->id)->firstOrFail();
        DB::unprepared("CREATE TRIGGER fail_participant_notification BEFORE INSERT ON notifications BEGIN SELECT RAISE(ABORT, 'fixture notification failure'); END");
        try{$service->participants($exam->id,132,409,2,false,[42]);$this->fail('Expected rollback');}
        catch(\Illuminate\Database\QueryException $e){$this->assertStringContainsString('fixture notification failure',$e->getMessage());}
        $this->assertDatabaseHas('exam_result2',['id'=>$row->id,'user_id'=>41]);
        $this->assertDatabaseMissing('exam_result2',['exam_id'=>$exam->id,'user_id'=>42]);
        $this->assertDatabaseHas(AcademicVisitRecords::TABLE,['record_type'=>'modern_result','record_id'=>$row->id]);
        DB::unprepared('DROP TRIGGER fail_participant_notification');
        $service->participants($exam->id,132,409,2,false,[]);
        $this->assertDatabaseMissing('exam_result2',['id'=>$row->id]);
        $this->assertDatabaseMissing(AcademicVisitRecords::TABLE,['record_type'=>'modern_result','record_id'=>$row->id]);
    }

    public function test_corrective_closed_visit_placeholders_and_return_visit_ambiguity_remain_protected()
    {
        $this->historyFixture();$this->activateVisits();$exam=$this->exam(2,['is_file'=>0,'has_traditional'=>1]);
        $row=$this->result($exam,null,['status'=>0,'show_result'=>0]);
        app(AcademicVisitRecords::class)->bind($row,\App\StudentAcademicPlacement::where('student_id',41)->first(),'fixture');
        $this->visitMove(133);$this->visitMove(132);$this->actingAs($this->teacher);
        foreach([true,false] as $linked){
            if(!$linked)DB::table(AcademicVisitRecords::TABLE)->where('record_type','modern_result')->where('record_id',$row->id)->delete();
            $this->postJson('/SMARMANger/dashboard/teacher/add_quize_student',[
                'exam'=>$exam->id,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'all'=>0,'student'=>[]])->assertStatus(422);
            $this->assertDatabaseHas('exam_result2',['id'=>$row->id]);
        }
    }

    public function test_corrective_batched_visit_states_match_single_reads_and_do_not_cache_across_writes()
    {
        $this->historyFixture();$this->activateVisits();$exam=$this->exam(2);
        $rows=collect([$this->result($exam,0),$this->result($exam,null,['user_id'=>42,'status'=>0])]);
        foreach($rows as $row)app(AcademicVisitRecords::class)->bind($row,\App\StudentAcademicPlacement::where('student_id',$row->user_id)->first(),'fixture');
        $before=new AcademicVisitReadContext($rows);
        foreach($rows as$row)$this->assertSame(app(AcademicVisitRecords::class)->resultState($row),$before->resultState($row));
        $this->visitMove(133);$this->visitMove(132);
        $unlinked=$this->result($exam,10);$rows->push($unlinked);
        $nullable=$this->result($exam,4,['user_id'=>42,'room_id'=>null]);$rows->push($nullable);
        $after=new AcademicVisitReadContext($rows,[132]);
        foreach($rows as$row)$this->assertSame(app(AcademicVisitRecords::class)->resultState($row),$after->resultState($row));
        $this->assertSame('current',$before->resultState($rows[0]));
        $this->assertSame('carried',$after->resultState($rows[0]));
        $this->assertSame('conflict',$after->resultState($unlinked));
        $this->assertSame('Section 132',$after->roomName(132));
        DB::enableQueryLog();DB::flushQueryLog();
        foreach(range(1,100)as$i)foreach($rows as$row){$after->resultState($row);$after->link($row);$after->roomName(132);}
        $this->assertSame([],DB::getQueryLog());DB::disableQueryLog();
    }

    public function test_corrective_equivalent_and_legacy_gradebook_reads_are_batched_without_changing_component_values_or_original_ids()
    {
        $this->activateContinuity();$this->activateVisits();$this->dynamic();$this->actingAs($this->admin);
        $quiz=$this->exam(2);$peer=$this->exam(2,['room_id'=>133]);
        app(\App\Services\AssessmentEquivalenceService::class)->verify([$quiz->id,$peer->id],'Fixture equivalence');
        $final=$this->exam(1);$dynamic=$this->exam(1,['name'=>'Dynamic_Section_100','mark'=>20]);
        $term2=$this->exam(2,['term_id'=>21]);
        $legacy=DB::table('lesson_teacher_room_term_exam')->insertGetId(['class_id'=>2,'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'type'=>8,'name_exam'=>'Original oral']);
        $ids=range(41,80);$originalIds=[];
        foreach($ids as$id){
            if($id>42)$this->enroll($id);
            foreach([[$quiz,$id===41?0:15],[$final,35],[$dynamic,12],[$term2,null]] as[$exam,$value]){
                $row=$this->result($exam,$value,['user_id'=>$id]);$originalIds[$exam->id][$id]=$row->id;
                app(AcademicVisitRecords::class)->bind($row,\App\StudentAcademicPlacement::where('student_id',$id)->first(),'fixture');
            }
            $row=new \App\Exam_result;$row->forceFill(['exam_id'=>$legacy,'user_id'=>$id,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'term_id'=>20,'result'=>'5','status'=>'1'])->save();
        }
        $before=DB::table('exam_result2')->orderBy('id')->get()->toJson();
        $measure=function($ids){DB::enableQueryLog();DB::flushQueryLog();$read=$this->read($ids);$count=count(DB::getQueryLog());DB::disableQueryLog();return [$count,$read];};
        [$one]=$measure([41]);[$many,$read]=$measure($ids);
        $this->assertSame($one,$many,'Equivalence and legacy reads must also batch by roster');
        foreach($ids as$id){
            $this->assertSame(['legacy_oral'=>5.0,'legacy_homework'=>$id===41?0.0:15.0,'legacy_exam'=>35.0,'dynamic_a'=>12.0,'total'=>$id===41?52.0:67.0],$read['marks'][$id][20]);
            $this->assertSame(['total'=>null],$read['marks'][$id][21]);
            foreach([$quiz,$final,$dynamic,$term2]as$exam){
                $assessment=$read['assessments']->firstWhere('key','exams2:'.$exam->id);
                $this->assertSame($originalIds[$exam->id][$id],$assessment['results'][$id]['result_id']);
                $this->assertSame($exam->id,$assessment['id']);$this->assertSame((float)$exam->mark,$assessment['maximum']);
            }
        }
        $this->assertSame($before,DB::table('exam_result2')->orderBy('id')->get()->toJson());
        file_put_contents(storage_path('gradebook-equivalent-query-audit.json'),json_encode(['one'=>$one,'forty'=>$many]));
    }
}
