<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class LessonAttachmentProposalTest extends TestCase
{
    private $migration;

    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        Schema::enableForeignKeyConstraints();
        Schema::create('lesson_teacher_room_term_exam', function (Blueprint $table) {
            $table->increments('id'); $table->text('addition')->nullable(); $table->text('note')->nullable();
        });
        DB::table('lesson_teacher_room_term_exam')->insert(['id'=>1,'addition'=>'filesteachers/legacy.pdf','note'=>'Existing instruction']);
        require_once base_path('docs/proposals/2026_11_06_000001_prepare_lesson_content_attachments.php');
        $this->migration = new \PrepareLessonContentAttachments();
    }

    public function test_proposal_is_additive_and_never_part_of_automatic_migrations()
    {
        $before=DB::table('lesson_teacher_room_term_exam')->first();
        $this->migration->up();
        $after=DB::table('lesson_teacher_room_term_exam')->first();
        $this->assertSame($before->addition,$after->addition);
        $this->assertSame($before->note,$after->note);
        $this->assertNull($after->upload_request_hash);
        $this->assertSame(0,DB::table('lesson_content_attachments')->count());
        $this->assertFalse(file_exists(database_path('migrations/2026_11_06_000001_prepare_lesson_content_attachments.php')));
        $this->assertSame($before->id,$after->id);
    }

    public function test_proposal_cannot_be_blindly_reapplied_or_rolled_back_with_live_metadata()
    {
        $this->migration->up();
        try { $this->migration->up(); $this->fail('Expected a schema review requirement'); }
        catch (\RuntimeException $e) { $this->assertStringContainsString('Review',$e->getMessage()); }
        DB::table('lesson_content_attachments')->insert(['content_id'=>1,'disk'=>'lesson_content_private',
            'path'=>'generated/one.pdf','original_name'=>'ملف.pdf','mime_type'=>'application/pdf',
            'size_bytes'=>10,'sha256'=>str_repeat('a',64),'position'=>0]);
        try { $this->migration->down(); $this->fail('Expected preservation guard'); }
        catch (\RuntimeException $e) { $this->assertStringContainsString('preserve',$e->getMessage()); }
        $this->assertSame(1,DB::table('lesson_content_attachments')->count());
        $this->assertDatabaseHas('lesson_teacher_room_term_exam',['id'=>1,'addition'=>'filesteachers/legacy.pdf']);
    }

    public function test_attachment_foreign_key_preserves_parent_instead_of_cascading_history()
    {
        $this->migration->up();
        DB::table('lesson_content_attachments')->insert(['content_id'=>1,'disk'=>'lesson_content_private',
            'path'=>'generated/one.pdf','original_name'=>'same.pdf','mime_type'=>'application/pdf',
            'size_bytes'=>10,'sha256'=>str_repeat('a',64),'position'=>0]);
        $this->expectException(\Illuminate\Database\QueryException::class);
        DB::table('lesson_teacher_room_term_exam')->where('id',1)->delete();
    }
}
