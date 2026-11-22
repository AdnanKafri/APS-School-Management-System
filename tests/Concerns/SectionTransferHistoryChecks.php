<?php

namespace Tests\Concerns;

use App\Services\StudentAcademicHistory;
use App\Services\StudentTransferService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/** Runs inside GradebookSafetyTest's SQLite memory DB and isolated storage. */
trait SectionTransferHistoryChecks
{
    private function historyFixture()
    {
        $student = $this->studentUiFixture();
        $this->activateContinuity();
        $this->scaffold();
        Schema::create('invoices', function (Blueprint $t) {
            $t->increments('id'); $t->integer('student_id'); $t->integer('class_id');
            $t->integer('year_id'); $t->integer('invoice_amount');
        });
        DB::table('report_cards')->insert(['student_id'=>41,'year_id'=>6,'room_id'=>132,'class'=>2,
            'teacher_notes'=>'Original report','student_attendance'=>'Present']);
        DB::table('invoices')->insert(['student_id'=>41,'class_id'=>2,'year_id'=>5,'invoice_amount'=>123]);
        $exam = $this->exam(2, ['name'=>'Source quiz']);
        $result = $this->result($exam, '0');
        $submission = DB::table('exams_files')->insertGetId(['student_id'=>41,'room_id'=>132,'class_id'=>2,
            'lesson_id'=>409,'term_id'=>20,'exam_id'=>$exam->id,'file'=>'filesstudents/my-work.txt']);
        $homework = DB::table('student_lesson_teacher_room_term_exam')->insertGetId(['student_id'=>41,
            'room_id'=>132,'lesson_id'=>409,'term_id'=>20,'exam_id'=>777,'file'=>'public/filesstudents/my-homework.txt']);
        Storage::fake('public');
        Storage::disk('public')->put('filesstudents/my-work.txt', 'Original student submission');
        Storage::disk('public')->put('filesstudents/my-homework.txt', 'Original student homework');
        $old = DB::table('student_academic_placements')->where('student_id',41)->value('id');
        return compact('student','exam','result','submission','homework','old');
    }

    private function historySnapshot()
    {
        $snapshot = [];
        foreach (['exam_result2','exam_result','exams_files','student_lesson_teacher_room_term_exam','invoices','users','students'] as $table) {
            $snapshot[$table] = DB::table($table)->orderBy('id')->get()->toJson();
        }
        return $snapshot;
    }

    public function test_section_transfer_earned_history_is_discoverable_without_reparenting_or_copying()
    {
        $f = $this->historyFixture();
        $before = $this->historySnapshot();
        $oldMarks = DB::table('students_marks')->where('room_id',132)->first();
        $oldCard = DB::table('report_cards')->where('room_id',132)->first();
        $this->moveToB();
        $this->assertSame($before, $this->historySnapshot());
        $this->assertEquals($oldMarks, DB::table('students_marks')->where('id',$oldMarks->id)->first());
        $this->assertEquals($oldCard, DB::table('report_cards')->where('id',$oldCard->id)->first());
        $this->assertDatabaseHas('student_academic_placements',['id'=>$f['old'],'status'=>'closed']);
        $new = DB::table('student_academic_placements')->where('student_id',41)->where('status','active')->first();
        $this->actingAs($f['student']);
        $list = $this->get('/SMARMANger/dashboard/student/academic-record')->assertOk();
        $this->assertCount(1, $list->viewData('placements'));
        $detail = $this->get('/SMARMANger/dashboard/student/academic-record/'.$new->id)->assertOk();
        $detail->assertSee(route('dashboard.student.academic_record.show',$f['old']), false);
        $this->assertCount(0, $detail->viewData('assessmentRows'));
        $old = $this->get('/SMARMANger/dashboard/student/academic-record/'.$f['old'])->assertOk();
        $this->assertSame('0', $old->viewData('assessmentRows')[0]['result']);
        $this->assertCount(2, $old->viewData('fileRows'));
        $this->assertCount(1, $old->viewData('reportRows'));
        $this->get('/SMARMANger/dashboard/student/view/main_exam/'.$f['exam']->id)->assertOk();
        $this->assertSame($before, $this->historySnapshot());
        $this->assertDatabaseHas('room_student',['student_id'=>42,'room_id'=>132]);
    }

    public function test_section_transfer_own_submissions_download_but_foreign_paths_and_future_history_do_not()
    {
        $f = $this->historyFixture();
        $this->moveToB();
        $this->actingAs($f['student']);
        $base = '/SMARMANger/dashboard/student/academic-record/'.$f['old'].'/submissions/';
        foreach (['exam'=>$f['submission'],'lesson'=>$f['homework']] as $kind=>$id) {
            $r = $this->get($base.$kind.'/'.$id)->assertOk();
            $this->assertStringContainsString('private', $r->headers->get('Cache-Control'));
            $this->assertStringContainsString('attachment;', $r->headers->get('Content-Disposition'));
        }
        DB::table('student_academic_placements')->where('id',$f['old'])->update(['status'=>'withdrawn']);
        $this->get($base.'exam/'.$f['submission'])->assertOk();
        DB::table('student_academic_placements')->where('id',$f['old'])->update(['status'=>'closed']);
        $foreign = DB::table('exams_files')->insertGetId(['student_id'=>42,'room_id'=>132,'file'=>'filesstudents/my-work.txt']);
        $this->get($base.'exam/'.$foreign)->assertNotFound();
        foreach (['../.env','filesstudents/../.env','filesteachers/private.txt','filesstudents/missing.txt','C:/secret.txt'] as $path) {
            DB::table('exams_files')->where('id',$f['submission'])->update(['file'=>$path]);
            $this->get($base.'exam/'.$f['submission'])->assertNotFound();
        }
        $otherPlacement = DB::table('student_academic_placements')->where('student_id',42)->value('id');
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$otherPlacement)->assertNotFound();
        DB::table('years')->insert(['id'=>7,'name'=>'2027/2028','current_year'=>0]);
        DB::table('rooms')->insert(['id'=>200,'year_id'=>7,'class_id'=>2,'name'=>'Future']);
        $future=DB::table('student_academic_placements')->insertGetId(['student_id'=>41,'year_id'=>7,'class_id'=>2,'room_id'=>200,'status'=>'active']);
        $this->get('/SMARMANger/dashboard/student/academic-record/'.$future)->assertNotFound();
        $this->assertCount(1,$this->get('/SMARMANger/dashboard/student/academic-record')->assertOk()->viewData('placements'));
    }

    public function test_section_transfer_historical_publication_and_privacy_flags_remain_authoritative()
    {
        $f = $this->historyFixture(); $this->moveToB(); $this->actingAs($f['student']);
        $url='/SMARMANger/dashboard/student/academic-record/'.$f['old'];
        DB::table('exam_result2')->where('id',$f['result']->id)->update(['show_result'=>0,'result'=>'87.25']);
        $this->assertSame(__('student_assessments.hidden'),$this->get($url)->assertOk()->viewData('assessmentRows')[0]['result']);
        DB::table('exam_result2')->where('id',$f['result']->id)->update(['show_result'=>1]);
        config(['student_results.student_pages_enabled'=>false]);
        $this->get($url)->assertOk()->assertDontSee('87.25');
        $this->get('/SMARMANger/dashboard/student/view/main_exam/'.$f['exam']->id)->assertOk()->assertDontSee('87.25');
        // Own submissions are not grades and stay accessible while grades are hidden.
        $this->get($url.'/submissions/exam/'.$f['submission'])->assertOk();
        config(['student_results.student_pages_enabled'=>true]);
        $this->assertSame('87.25',$this->get($url)->assertOk()->viewData('assessmentRows')[0]['result']);
    }

    public function test_section_transfer_blocks_inconsistent_placement_and_return_visits_without_mutations()
    {
        $this->historyFixture(); $this->actingAs($this->admin);
        $before=$this->historySnapshot();
        DB::table('student_academic_placements')->where('student_id',41)->update(['room_id'=>133]);
        $placements=DB::table('student_academic_placements')->get()->toJson();
        $service=app(StudentTransferService::class);
        $service->handle(\Illuminate\Http\Request::create('/','POST',['student_id'=>41,'class_change_id'=>2,'room_change_id'=>133]));
        $this->assertFalse($service->succeeded());
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame($before,$this->historySnapshot());
        DB::table('student_academic_placements')->where('student_id',41)->update(['room_id'=>132]);
        $this->moveToB(); $before=$this->historySnapshot();
        $service->handle(\Illuminate\Http\Request::create('/','POST',['student_id'=>41,'class_change_id'=>2,'room_change_id'=>132]));
        $this->assertFalse($service->succeeded());
        $this->assertDatabaseHas('room_student',['student_id'=>41,'room_id'=>133]);
        $this->assertSame(1,DB::table('student_transfer_histories')->count());
        $this->assertSame($before,$this->historySnapshot());
    }

    public function test_section_transfer_failure_after_projection_update_rolls_back_everything()
    {
        $this->historyFixture(); $this->actingAs($this->admin);
        DB::statement("CREATE TRIGGER fixture_transfer_failure BEFORE INSERT ON report_cards BEGIN SELECT RAISE(ABORT, 'fixture failure'); END");
        $before=$this->historySnapshot();
        $placements=DB::table('student_academic_placements')->get()->toJson();
        $marks=DB::table('students_marks')->get()->toJson();
        $service=app(StudentTransferService::class);
        $service->handle(\Illuminate\Http\Request::create('/','POST',['student_id'=>41,'class_change_id'=>2,'room_change_id'=>133]));
        $this->assertFalse($service->succeeded());
        $this->assertSame($before,$this->historySnapshot());
        $this->assertSame($placements,DB::table('student_academic_placements')->get()->toJson());
        $this->assertSame($marks,DB::table('students_marks')->get()->toJson());
        $this->assertDatabaseHas('room_student',['student_id'=>41,'room_id'=>132]);
        $this->assertSame(0,DB::table('student_transfer_histories')->count());
    }

    public function test_section_transfer_destination_scaffold_ignores_injected_marks()
    {
        $this->historyFixture(); $this->actingAs($this->admin);
        $service=app(StudentTransferService::class);
        $service->handle(\Illuminate\Http\Request::create('/','POST',['student_id'=>41,'class_change_id'=>2,
            'room_change_id'=>133,'oral'=>99,'homework'=>99,'activities'=>99,'quize'=>99,'exam'=>99]));
        $this->assertTrue($service->succeeded());
        $row=DB::table('students_marks')->where('student_id',41)->where('room_id',133)->first();
        $this->assertSame(['oral'=>null,'homework'=>null,'activities'=>null,'quize'=>null,'exam'=>null],json_decode($row->mark,true)[409]);
    }

    public function test_section_transfer_admin_bulk_route_deduplicates_selection_and_reports_each_failure()
    {
        $this->historyFixture(); $before=$this->historySnapshot();
        $response=$this->actingAs($this->admin)->from('/SMT/admin/students')
            ->post('/SMT/admin/students/bulk-transfer', ['student_ids'=>[41,41,999999],
                'class_change_id'=>2,'room_change_id'=>133])
            ->assertRedirect('/SMT/admin/students')->assertSessionHas('warning');
        $failures=session('student_transfer_failures');
        $this->assertCount(1,$failures);
        $this->assertSame(999999,$failures[0]['student_id']);
        $this->assertSame(__('student_transfer.validation.transfer_student_missing'),$failures[0]['reason']);
        $this->assertDatabaseHas('room_student',['student_id'=>41,'room_id'=>133]);
        $this->assertDatabaseHas('room_student',['student_id'=>42,'room_id'=>132]);
        $this->assertSame(1,DB::table('student_transfer_histories')->count());
        $this->assertSame($before,$this->historySnapshot());
        $this->actingAs($this->teacher)->post('/SMT/admin/students/bulk-transfer', ['student_ids'=>[42],
            'class_change_id'=>2,'room_change_id'=>133])->assertRedirect('/SMARMANger');
        $this->assertDatabaseHas('room_student',['student_id'=>42,'room_id'=>132]);
    }

    public function test_section_transfer_winter_clock_resolves_immediately_with_different_caller_timezone()
    {
        $this->historyFixture();
        \Carbon\Carbon::setTestNow(\Carbon\Carbon::parse('2026-11-19 10:00:00','Asia/Riyadh'));
        $this->moveToB();
        $membership=app(\App\Services\CurrentStudentMembership::class);
        $at=\Carbon\Carbon::now('Asia/Damascus');
        $original=$at->toIso8601String();
        $this->assertSame('2026-11-19 10:00:00',$membership->placementTime($at));
        $this->assertSame($original,$at->toIso8601String());
        $this->assertSame([41],$membership->studentsQuery(6,133,true,$at)->pluck('students.id')
            ->map(function ($id) { return (int) $id; })->all());
        $this->assertSame(133,(int)$membership->roomForStudent(41,6)->id);
    }

    public function test_section_transfer_normal_lesson_endpoints_reject_old_section_content()
    {
        $f=$this->historyFixture();
        Schema::table('lectures',function(Blueprint $t){
            foreach(['year_id','room_id','teacher_id','term_id'] as $c) $t->integer($c)->nullable();
            $t->text('lecture_time')->nullable();$t->text('name')->nullable();$t->integer('key')->nullable();
        });
        foreach([501=>132,502=>133] as $id=>$room) DB::table('lectures')->insert(['id'=>$id,'room_id'=>$room,'class_id'=>2,
            'lesson_id'=>409,'teacher_id'=>166,'year_id'=>6,'term_id'=>20,'lecture_time'=>now()->subHour(),'active'=>0,'key'=>0,'name'=>'Lesson '.$id]);
        $this->moveToB(); $this->actingAs($f['student']);
        $this->get('/SMARMANger/dashboard/student/lesson/lectures/409/132/41')->assertForbidden();
        $this->get('/SMARMANger/dashboard/student/lesson/lectures/409/133/41')->assertOk()
            ->assertSee('Lesson 502')->assertDontSee('Lesson 501');
        $this->get('/SMARMANger/dashboard/student/lesson/lecture/content/409/41/501')->assertForbidden();
        foreach(['extra_files','video','audio','homework','quize','exam'] as $category) {
            $this->get('/SMARMANger/dashboard/student/lesson/lecture/'.$category.'/409/41/501')->assertForbidden();
        }
        $lecture=app(\App\Services\LessonContentAccess::class)->studentLecture(502,409,41);
        $this->assertSame(133,(int)$lecture->room_id);
        $this->assertSame(133,(int)app(\App\Services\CurrentStudentMembership::class)->roomForStudent(41,6)->id);
    }
}
