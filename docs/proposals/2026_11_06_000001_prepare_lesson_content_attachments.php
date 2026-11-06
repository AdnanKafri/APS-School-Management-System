<?php

// Approval draft only. Deliberately outside database/migrations.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PrepareLessonContentAttachments extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('lesson_teacher_room_term_exam')
            || Schema::hasColumn('lesson_teacher_room_term_exam', 'upload_request_hash')
            || Schema::hasTable('lesson_content_attachments')) {
            throw new RuntimeException('Review the lesson-content schema before applying this proposal.');
        }

        Schema::table('lesson_teacher_room_term_exam', function (Blueprint $table) {
            $table->char('upload_request_hash', 64)->nullable();
            $table->unique('upload_request_hash', 'lesson_content_request_unique');
        });
        Schema::create('lesson_content_attachments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            // The existing parent's primary key is signed INT, not BIGINT/UNSIGNED.
            $table->integer('content_id');
            $table->string('disk', 32);
            $table->string('path', 191);
            $table->string('original_name', 255);
            $table->string('mime_type', 127);
            $table->unsignedBigInteger('size_bytes');
            $table->char('sha256', 64);
            $table->unsignedSmallInteger('position');
            $table->timestamps();
            $table->unique(['content_id', 'position'], 'lesson_attachment_position_unique');
            $table->unique('path', 'lesson_attachment_path_unique');
            $table->foreign('content_id', 'lesson_attachment_content_fk')
                ->references('id')->on('lesson_teacher_room_term_exam')->onDelete('restrict');
        });
    }

    public function down()
    {
        // A normal rollback must not silently discard newly uploaded content metadata.
        if ((Schema::hasTable('lesson_content_attachments') && DB::table('lesson_content_attachments')->exists())
            || (Schema::hasColumn('lesson_teacher_room_term_exam', 'upload_request_hash')
                && DB::table('lesson_teacher_room_term_exam')->whereNotNull('upload_request_hash')->exists())) {
            throw new RuntimeException('Lesson attachments exist; preserve them before a reviewed rollback.');
        }
        Schema::dropIfExists('lesson_content_attachments');
        if (Schema::hasColumn('lesson_teacher_room_term_exam', 'upload_request_hash')) {
            Schema::table('lesson_teacher_room_term_exam', function (Blueprint $table) {
                $table->dropUnique('lesson_content_request_unique');
                $table->dropColumn('upload_request_hash');
            });
        }
    }
}
