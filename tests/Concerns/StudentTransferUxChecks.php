<?php

namespace Tests\Concerns;

use App\Services\StudentTransferService;
use Illuminate\Support\Facades\DB;

trait StudentTransferUxChecks
{
    private function transferUxProjection($placementId)
    {
        DB::table('student_academic_placements')->where('id',$placementId)->update([
            'room_id'=>133,'effective_from'=>now()->subDays(5),'updated_at'=>now()->subDays(3)]);
        DB::table('room_student')->where('student_id',41)->update([
            'created_at'=>now()->subDays(4),'updated_at'=>now()->subDay()]);
    }

    private function transferUxPost(array $extra=[])
    {
        return $this->actingAs($this->admin)->from('/SMT/admin/students/student_details/41')
            ->post('/SMT/admin/students/change',array_merge([
                'student_id'=>41,'class_change_id'=>2,'room_change_id'=>133],$extra));
    }

    private function transferModalHtml($view, $hasHistory=true)
    {
        $source=file_get_contents(resource_path('views/admin/'.$view.'.blade.php'));
        $start=strpos($source,'<div class="modal fade changeStudentModal">');
        $end=strpos($source,'</form>',$start)+strlen('</form>');
        $file=storage_path('framework/views/transfer-ux-'.$view.'.blade.php');
        file_put_contents($file,substr($source,$start,$end-$start));
        $student=\App\Student::findOrFail(41);
        $student->setRelation('room',collect([\App\Room::findOrFail(132)]));
        return view()->file($file,['student'=>$student,'classes'=>\App\Classe::all(),
            'year2'=>\App\Year::find(6),'activeYear'=>\App\Year::find(6),'hasAcademicRecords'=>$hasHistory])->render();
    }

    public function test_transfer_ux_normal_modals_have_one_notice_one_confirmation_and_no_reconciliation_controls()
    {
        $this->historyFixture();$this->actingAs($this->admin);
        $notice='تنبيه: لدى الطالب سجلات دراسية سابقة. سيتم نقله إلى الشعبة المحددة مع الاحتفاظ بجميع علاماته ومتابعاته وسجلاته دون أي تغيير.';
        $this->assertSame($notice,__('student_transfer.notice'));
        foreach(['student','student_details']as$view) {
            $html=$this->transferModalHtml($view);
            $this->assertSame(1,substr_count($html,$notice));
            $this->assertSame(1,substr_count($html,'تأكيد النقل'));
            $this->assertStringNotContainsString('reconcile_',$html);
            $this->assertStringNotContainsString('observed_',$html);
            $this->assertStringNotContainsString('<textarea',$html);
            $this->assertStringNotContainsString('type="checkbox"',$html);
            $this->assertStringContainsString('name="_token"',$html);
            $this->assertStringContainsString('name="class_change_id"',$html);
        }
        $service=app(StudentTransferService::class);
        $this->assertTrue($service->hasAcademicRecords(41));$this->assertFalse($service->hasAcademicRecords(42));
        $this->get('/SMT/admin/students/student_detail_prev/41')->assertOk()->assertJson(['has_academic_records'=>true]);
        $this->assertStringContainsString(' hidden ', $this->transferModalHtml('student_details',false));
        $this->assertStringContainsString('.student-transfer-record-notice',file_get_contents(resource_path('views/admin/student.blade.php')));
    }

    public function test_transfer_ux_reliable_projection_reconciles_automatically_without_extra_inputs()
    {
        $f=$this->historyFixture();$this->activateVisits();$this->transferUxProjection($f['old']);
        $before=$this->historySnapshot();
        $this->transferUxPost()->assertRedirect('/SMT/admin/students/student_details/41')->assertSessionHas('success');
        $this->assertSame($before,$this->historySnapshot());
        $audit=DB::table('student_placement_reconciliations')->first();$snapshot=json_decode($audit->before_snapshot,true);
        $this->assertSame('automatic',$snapshot['verification_mode']);
        $this->assertSame('verified_legacy_current_projection',$snapshot['verification_evidence']['basis']);
        $this->assertSame('unknown',$snapshot['historical_transition_date']);
        $this->assertEquals($this->admin->id,$audit->actioned_by);
        $observation=DB::table('student_academic_placements')->where('id',$audit->observed_placement_id)->first();
        $this->assertSame($audit->confirmed_at,$observation->effective_from);
        $this->assertDatabaseHas('room_student',['student_id'=>41,'room_id'=>133]);
        $this->assertSame(0,DB::table('student_academic_visit_records')->where('placement_id',$observation->id)->count());
    }

    public function test_transfer_ux_missing_placement_with_sole_dated_enrollment_is_observed_now_not_backdated()
    {
        $this->historyFixture();$this->activateVisits();
        DB::table('student_academic_placements')->where('student_id',41)->delete();
        $before=$this->historySnapshot();
        $this->transferUxPost()->assertRedirect()->assertSessionHas('success');
        $this->assertSame($before,$this->historySnapshot());
        $audit=DB::table('student_placement_reconciliations')->first();$snapshot=json_decode($audit->before_snapshot,true);
        $this->assertSame('automatic',$snapshot['verification_mode']);
        $this->assertSame('sole_dated_enrollment_without_conflicting_placement_or_transfer',$snapshot['verification_evidence']['basis']);
        $this->assertNull($audit->from_placement_id);
        $this->assertSame($audit->confirmed_at,DB::table('student_academic_placements')->where('id',$audit->observed_placement_id)->value('effective_from'));
    }

    public function test_transfer_ux_uncertain_mismatch_stops_then_accepts_explicit_audited_review_without_textarea()
    {
        $f=$this->historyFixture();$this->activateVisits();
        DB::table('student_academic_placements')->where('id',$f['old'])->update(['room_id'=>133]);
        $before=$this->historySnapshot();$placements=DB::table('student_academic_placements')->get()->toJson();
        $this->transferUxPost()->assertRedirect(route('student_details',41))->assertSessionHas('warning')
            ->assertSessionHas('student_transfer_review',['student_id'=>41,'class_id'=>2,'room_id'=>133]);
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame($before,$this->historySnapshot());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $html=view('admin.students._transfer_review',['student'=>\App\Student::find(41),
            'enrollmentRoom'=>\App\Room::with('classes')->find(132),'targetRoom'=>\App\Room::with('classes')->find(133),
            'placements'=>\App\StudentAcademicPlacement::where('student_id',41)->where('status','active')->get()])->render();
        $this->assertStringContainsString('اعتماد الشعبة الحالية وتأكيد النقل',$html);
        $this->assertStringNotContainsString('<textarea',$html);$this->assertStringNotContainsString('type="checkbox"',$html);
        $this->assertStringNotContainsString('&amp;#',$html);
        $this->transferUxPost(['reconcile_confirmed'=>1,'observed_room_id'=>132,'observed_placement_ids'=>(string)$f['old']])
            ->assertRedirect()->assertSessionHas('success');
        $this->assertSame($before,$this->historySnapshot());
        $snapshot=json_decode(DB::table('student_placement_reconciliations')->value('before_snapshot'),true);
        $this->assertSame('manual',$snapshot['verification_mode']);
        $this->assertSame('unknown',$snapshot['historical_transition_date']);
        $this->assertNotEmpty(DB::table('student_placement_reconciliations')->value('reason'));
    }

    public function test_transfer_ux_later_transfer_and_prior_room_visit_prevent_automatic_inference()
    {
        $f=$this->historyFixture();$this->activateVisits();$this->transferUxProjection($f['old']);
        DB::table('student_transfer_histories')->insert(['student_id'=>41,'year_id'=>6,'created_at'=>now()]);
        $before=$this->historySnapshot();
        $this->transferUxPost()->assertSessionHas('warning');
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        DB::table('student_transfer_histories')->delete();
        DB::table('student_academic_placements')->insert(['student_id'=>41,'year_id'=>6,'class_id'=>2,'room_id'=>132,
            'status'=>'closed','effective_from'=>now()->subDays(10),'effective_to'=>now()->subDays(8)]);
        $this->transferUxPost()->assertSessionHas('warning');
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $this->assertSame($before,$this->historySnapshot());
        $this->assertDatabaseHas('room_student',['student_id'=>41,'room_id'=>132]);
    }

    public function test_transfer_ux_automatic_observation_and_transfer_roll_back_together()
    {
        $f=$this->historyFixture();$this->activateVisits();$this->transferUxProjection($f['old']);
        $before=$this->historySnapshot();$placements=DB::table('student_academic_placements')->get()->toJson();
        DB::statement("CREATE TRIGGER fixture_ux_failure BEFORE INSERT ON report_cards BEGIN SELECT RAISE(ABORT, 'fixture failure'); END");
        $this->transferUxPost()->assertSessionHas('warning');
        $this->assertSame($before,$this->historySnapshot());
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $this->assertSame(0,DB::table('student_academic_visit_records')->count());
    }

    public function test_transfer_ux_does_not_automatically_choose_between_multiple_active_placements()
    {
        $this->historyFixture();$this->activateVisits();
        DB::table('student_academic_placements')->insert(['student_id'=>41,'year_id'=>6,'class_id'=>2,
            'room_id'=>133,'status'=>'active','effective_from'=>now()->subDay()]);
        $placements=DB::table('student_academic_placements')->get()->toJson();
        $this->transferUxPost()->assertSessionHas('warning');
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $this->actingAs($this->teacher)->post('/SMT/admin/students/change',[
            'student_id'=>41,'class_change_id'=>2,'room_change_id'=>133,'reconcile_confirmed'=>1])->assertRedirect('/SMARMANger');
    }

    public function test_transfer_ux_normal_http_flow_supports_repeated_returns_without_reconciliation_inputs()
    {
        $this->historyFixture();$this->activateVisits();$before=$this->historySnapshot();
        $marks=DB::table('students_marks')->where('student_id',41)->first();
        $report=DB::table('report_cards')->where('student_id',41)->first();
        foreach ([133,132,133,132] as $room) {
            $this->transferUxPost(['room_change_id'=>$room])->assertRedirect()->assertSessionHas('success');
            $this->assertSame($before,$this->historySnapshot());
            $this->assertDatabaseHas('room_student',['student_id'=>41,'room_id'=>$room]);
            $this->assertSame(1,DB::table('student_academic_placements')->where('student_id',41)->where('status','active')->count());
        }
        $this->assertEquals($marks,DB::table('students_marks')->where('id',$marks->id)->first());
        $this->assertEquals($report,DB::table('report_cards')->where('id',$report->id)->first());
        $this->assertSame(4,DB::table('student_transfer_histories')->count());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
    }

    public function test_transfer_ux_cross_grade_mismatch_cannot_use_same_grade_projection_evidence()
    {
        $f=$this->historyFixture();$this->activateVisits();$this->transferUxProjection($f['old']);
        DB::table('rooms')->insert(['id'=>134,'class_id'=>3,'year_id'=>6,'name'=>'Other grade']);
        DB::table('student_academic_placements')->where('id',$f['old'])->update(['class_id'=>3,'room_id'=>134]);
        $before=$this->historySnapshot();$placements=DB::table('student_academic_placements')->get()->toJson();
        $this->transferUxPost()->assertSessionHas('warning')->assertSessionHas('student_transfer_review');
        $this->assertSame($before,$this->historySnapshot());
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
    }

    public function test_transfer_ux_future_placement_dates_are_not_automatically_reconciled()
    {
        $f=$this->historyFixture();$this->activateVisits();$this->transferUxProjection($f['old']);
        DB::table('student_academic_placements')->where('id',$f['old'])->update(['effective_from'=>now()->addDay()]);
        $before=$this->historySnapshot();$placements=DB::table('student_academic_placements')->get()->toJson();
        $this->transferUxPost()->assertSessionHas('warning');
        $this->assertSame($before,$this->historySnapshot());
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
        $this->transferUxPost(['reconcile_confirmed'=>1,'observed_room_id'=>132,'observed_placement_ids'=>(string)$f['old']])
            ->assertSessionHas('warning');
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame(0,DB::table('student_placement_reconciliations')->count());
    }
}
