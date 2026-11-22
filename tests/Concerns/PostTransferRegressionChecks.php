<?php

namespace Tests\Concerns;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/** Audit and corrective regression fixtures; no school database/storage is used. */
trait PostTransferRegressionChecks
{
    public function test_audit_never_transferred_traditional_creation_entry_edit_and_zero_with_visits_enabled()
    {
        $this->activateVisits();
        $this->test_student_e2e_admin_original_teacher_first_save_edit_zero_and_compact_result_cards_for_both_types();
    }

    public function test_audit_never_transferred_publication_and_privacy_with_visits_enabled()
    {
        $this->activateVisits();
        $this->test_student_quiz_and_exam_routes_redact_published_cards_and_direct_results_for_both_flag_states();
    }

    public function test_audit_never_transferred_bulk_grading_and_report_import_with_visits_enabled()
    {
        $this->activateVisits();
        $this->test_phase0b_complete_admin_exam_and_quiz_workflow_with_individual_bulk_and_reports();
    }

    public function test_audit_never_transferred_legacy_summaries_are_not_hidden_by_schema_activation()
    {
        $this->historyFixture();
        $before=[\App\Students_mark::orderBy('id')->get()->toJson(),\App\Report_card::orderBy('id')->get()->toJson()];
        $this->activateVisits();
        $this->assertSame($before,[\App\Students_mark::orderBy('id')->get()->toJson(),\App\Report_card::orderBy('id')->get()->toJson()]);
        $this->assertSame(0,DB::table('student_transfer_histories')->count());
    }

    public function test_audit_unused_automated_participation_can_still_remove_an_unattempted_current_placeholder()
    {
        $this->activateVisits();$this->actingAs($this->teacher);
        $exam=$this->exam(2,['is_file'=>0,'has_traditional'=>1]);
        $url='/SMARMANger/dashboard/teacher/add_quize_student';
        $payload=['exam'=>$exam->id,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'all'=>0,'student'=>[41,42]];
        $this->post($url,$payload)->assertRedirect()->assertSessionHasNoErrors();
        $blank=\App\Exam_result2::where('exam_id',$exam->id)->where('user_id',42)->firstOrFail();
        $this->assertNull($blank->result);$this->assertEquals(0,$blank->show_result);
        $this->assertDatabaseHas('student_academic_visit_records',['record_type'=>'modern_result','record_id'=>$blank->id]);
        $this->post($url,array_merge($payload,['student'=>[41]]))->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('exam_result2',['id'=>$blank->id]);
    }

    public function test_audit_certificates_create_display_and_freeze_in_original_visit()
    {
        $f=$this->historyFixture();
        Schema::table('certificates',function(Blueprint $t){
            foreach(['lesson_id','teacher_id','class_id','term']as$c)$t->integer($c)->nullable();
            $t->text('certificate')->nullable();$t->timestamps();
        });
        $this->activateVisits();
        $certificate=new \App\Certificate;
        foreach(['student_id'=>41,'room_id'=>132,'class_id'=>2,'teacher_id'=>166,'lesson_id'=>409,'term'=>20,'certificate'=>'Original certificate']as$k=>$v)$certificate->$k=$v;
        $certificate->save();$original=$certificate->getRawOriginal();
        $this->assertDatabaseHas('student_academic_visit_records',['record_type'=>'certificate','record_id'=>$certificate->id,'placement_id'=>$f['old']]);
        $certificate->certificate='Updated current certificate';$certificate->save();
        $original=$certificate->fresh()->getRawOriginal();
        $this->visitMove(133);
        $this->actingAs($f['student']);
        $page=$this->get('/SMARMANger/dashboard/student/academic-record/'.$f['old'])->assertOk();
        $this->assertCount(1,$page->viewData('certificateRows'));
        $this->assertSame($original,\App\Certificate::find($certificate->id)->getRawOriginal());
        try {$certificate->certificate='Historical edit';$certificate->save();$this->fail('Closed certificate changed');}
        catch(\Illuminate\Validation\ValidationException $e){$this->assertNotEmpty($e->errors());}
        $this->assertSame($original,\App\Certificate::find($certificate->id)->getRawOriginal());
    }

    public function test_audit_admin_unused_quiz_maintenance_does_not_treat_unattempted_current_participation_as_earned_history()
    {
        $this->activateVisits();$this->actingAs($this->teacher);
        $exam=$this->exam(2,['is_file'=>0,'has_traditional'=>1]);
        $this->post('/SMARMANger/dashboard/teacher/add_quize_student',[
            'exam'=>$exam->id,'room_id'=>132,'class_id'=>2,'lesson_id'=>409,'all'=>0,'student'=>[41],
        ])->assertRedirect()->assertSessionHasNoErrors();
        $record=\App\Exam_result2::where('exam_id',$exam->id)->firstOrFail();
        $this->assertFalse(\App\Services\AssessmentResultSafety::hasEarnedData($record));
        $this->actingAs($this->admin)->postJson('/SMT/admin/class/room/exam_quize/delete',[
            'content_id'=>$exam->id,'delete_code'=>'test-delete',
        ])->assertOk();
    }

    public function test_audit_archive_and_restore_keep_original_records_and_create_current_scaffolds()
    {
        $this->historyFixture();$this->activateVisits();$before=$this->historySnapshot();
        Schema::create('student_lifecycle_events',function(Blueprint $t){
            $t->increments('id');
            foreach(['student_id','event_type','occurred_at','actioned_by','reason','year_id','placement_id','room_student_id','class_id','room_id','bus_id','before_state','after_state']as$c)$t->text($c)->nullable();
            $t->timestamps();
        });
        Schema::create('exam_result_tester',function(Blueprint $t){
            $t->increments('id');$t->integer('user_id')->nullable();$t->integer('room_id')->nullable();
        });
        $this->actingAs($this->admin);
        $service=app(\App\Services\StudentLifecycleService::class);
        $service->archiveStudent(\App\Student::find(41),'Isolated audit',$this->admin->id);
        $this->assertDatabaseHas('students',['id'=>41,'lifecycle_status'=>'archived']);
        $this->assertSame(0,DB::table('room_student')->where('student_id',41)->count());
        $this->assertSame(1,DB::table('student_academic_placements')->where('student_id',41)->where('status','withdrawn')->count());
        $service->restoreStudent(\App\Student::find(41),6,2,133,'Isolated restore',$this->admin->id);
        $this->assertDatabaseHas('students',['id'=>41,'lifecycle_status'=>'active']);
        $this->assertDatabaseHas('room_student',['student_id'=>41,'room_id'=>133,'year_id'=>6]);
        $this->assertSame(2,DB::table('student_lifecycle_events')->count());
        $this->assertSame(1,\App\Students_mark::where('student_id',41)->count());
        foreach(['invoices','exam_result2','exam_result','exams_files','student_lesson_teacher_room_term_exam']as$table)
            $this->assertSame($before[$table],DB::table($table)->orderBy('id')->get()->toJson());
    }

    public function test_audit_legacy_mobile_upload_success_contract_across_visit_activation()
    {
        $this->studentUiFixture();Storage::fake('public');$exam=$this->exam(2);$evidence=[];
        foreach([false,true]as$enabled){
            if($enabled)$this->activateVisits();
            foreach(['upload_exam_files','upload_exam_files2']as$method){
                $many=$method==='upload_exam_files2';$before=Storage::disk('public')->allFiles();$rows=DB::table('exams_files')->count();
                $payload=['student_id'=>41,'item_id'=>$exam->id,
                    'file'=>$many?json_encode([base64_encode('isolated submission')]):base64_encode('isolated submission'),
                    'extension'=>$many?json_encode(['.txt']):'txt'];
                $response=$this->postJson('/api/dashboard/student/'.$method,$payload);
                if ($response->json('status')) {
                    $this->assertSame(20, (int)DB::table('exams_files')->orderByDesc('id')->value('term_id'));
                }
                $evidence[]=['visits_enabled'=>$enabled,'method'=>$method,'http'=>$response->getStatusCode(),
                    'created_files'=>count(array_diff(Storage::disk('public')->allFiles(),$before)),
                    'rows_before'=>$rows,'rows_after'=>DB::table('exams_files')->count(),
                    'response'=>$response->json()];
            }
        }
        file_put_contents(storage_path('mobile-upload-audit.json'),json_encode($evidence,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        foreach($evidence as$row){
            $this->assertSame(200,$row['http'],'Existing upload contract changed: '.json_encode($row,JSON_UNESCAPED_UNICODE));
            $this->assertTrue($row['response']['status']??false);
            $this->assertSame(1,$row['created_files']);
            $this->assertSame($row['rows_before']+1,$row['rows_after']);
        }
    }

    public function test_audit_gradebook_read_query_count_baseline_for_ordinary_students()
    {
        $exam=$this->exam(2);$ids=range(41,52);
        foreach($ids as$id){if($id>42)$this->enroll($id);$this->result($exam,$id===41?0:25,['user_id'=>$id]);}
        $measure=function($ids){DB::enableQueryLog();DB::flushQueryLog();$read=$this->read($ids);$log=DB::getQueryLog();DB::disableQueryLog();
            $this->assertSame(count($ids),count($read['marks']));
            return ['queries'=>count($log),'schema_queries'=>count(array_filter($log,function($q){return strpos($q['query'],'sqlite_master')!==false;}))];};
        $before=['one'=>$measure([41]),'twelve'=>$measure($ids)];$this->activateVisits();
        $after=['one'=>$measure([41]),'twelve'=>$measure($ids)];
        foreach(\App\Exam_result2::all()as$result)app(\App\Services\AcademicVisitRecords::class)->bind($result,
            \App\StudentAcademicPlacement::where('student_id',$result->user_id)->firstOrFail(),'isolated_audit_current_visit');
        $linked=['one'=>$measure([41]),'twelve'=>$measure($ids)];
        file_put_contents(storage_path('gradebook-query-audit.json'),json_encode(['schema_absent'=>$before,'schema_active_unattributed'=>$after,'schema_active_linked'=>$linked],JSON_PRETTY_PRINT));
        $this->assertLessThanOrEqual(10,$before['twelve']['queries']-$before['one']['queries'],
            'Per-student SQL growth even without visit schema: '.json_encode($before));
        $this->assertLessThanOrEqual(10,$after['twelve']['queries']-$after['one']['queries'],
            'Per-student SQL growth with visit schema: '.json_encode($after));
        $this->assertSame($linked['one']['queries'],$linked['twelve']['queries']);
        $this->assertSame($before['one']['queries'],$before['twelve']['queries']);
        $this->assertSame($after['one']['queries'],$after['twelve']['queries']);
    }
}
