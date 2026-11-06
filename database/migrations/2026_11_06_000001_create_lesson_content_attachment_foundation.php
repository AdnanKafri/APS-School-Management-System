<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLessonContentAttachmentFoundation extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('lesson_teacher_room_term_exam')
            || !Schema::hasColumn('lesson_teacher_room_term_exam', 'note')
            || collect(['upload_request_hash','upload_payload_hash','upload_revision','upload_deleted_at'])->contains(function ($column) {
                return Schema::hasColumn('lesson_teacher_room_term_exam', $column);
            })
            || Schema::hasTable('lesson_content_attachments')) {
            throw new RuntimeException('Review the existing lesson-content schema before applying this migration.');
        }
        if (DB::getDriverName() === 'mysql') {
            $parent = DB::selectOne("SELECT ENGINE AS engine FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam'");
            $id = DB::selectOne("SELECT COLUMN_TYPE AS column_type FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam' AND COLUMN_NAME='id'");
            if (!$parent || strcasecmp($parent->engine, 'InnoDB') !== 0 || !$id || !preg_match('/^int(?:\\(\\d+\\))?$/i', $id->column_type)) {
                throw new RuntimeException('Review parent engine and signed INT identity before creating attachment ownership.');
            }
        }
        Schema::table('lesson_teacher_room_term_exam', function (Blueprint $table) {
            $table->char('upload_request_hash', 64)->nullable();
            $table->char('upload_payload_hash', 64)->nullable();
            $table->unsignedInteger('upload_revision')->default(0);
            $table->timestamp('upload_deleted_at')->nullable();
            $table->unique('upload_request_hash', 'lesson_content_request_unique');
        });
        Schema::create('lesson_content_attachments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('content_id'); // Existing parent IDs are signed INT.
            $table->string('disk', 32);
            $table->string('path', 191);
            $table->string('original_name', 255);
            $table->string('mime_type', 127);
            $table->unsignedBigInteger('size_bytes');
            $table->char('sha256', 64);
            $table->unsignedSmallInteger('position');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('purged_at')->nullable();
            $table->timestamps();
            $table->unique(['content_id', 'position'], 'lesson_attachment_position_unique');
            $table->unique('path', 'lesson_attachment_path_unique');
            $table->foreign('content_id', 'lesson_attachment_content_fk')
                ->references('id')->on('lesson_teacher_room_term_exam')->onDelete('restrict');
        });
    }

    public function down()
    {
        if ((Schema::hasTable('lesson_content_attachments') && DB::table('lesson_content_attachments')->exists())
            || (Schema::hasColumn('lesson_teacher_room_term_exam', 'upload_request_hash')
                && DB::table('lesson_teacher_room_term_exam')->whereNotNull('upload_request_hash')->exists())) {
            throw new RuntimeException('Preserve lesson content and upload receipts before a reviewed rollback.');
        }
        Schema::dropIfExists('lesson_content_attachments');
        Schema::table('lesson_teacher_room_term_exam', function (Blueprint $table) {
            $table->dropUnique('lesson_content_request_unique');
            $table->dropColumn(['upload_request_hash', 'upload_payload_hash', 'upload_revision', 'upload_deleted_at']);
        });
    }
}
