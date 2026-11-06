<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGradebookTemplateFoundation extends Migration
{
    public function up()
    {
        if (!in_array(DB::getDriverName(), ['mysql', 'sqlite'], true)) {
            throw new RuntimeException('Template immutability requires reviewed mysql/sqlite support.');
        }
        foreach (['gradebook_templates', 'gradebook_template_versions', 'gradebook_events'] as $table) {
            if (Schema::hasTable($table)) throw new RuntimeException('Template schema already exists; inspect before migration.');
        }
        if (DB::getDriverName() === 'mysql') {
            foreach (['years'=>'int', 'lessons'=>'int', 'classes'=>'int', 'users'=>'bigint unsigned'] as $table=>$type) {
                $status = DB::selectOne("SHOW TABLE STATUS LIKE '$table'");
                $id = DB::selectOne("SHOW COLUMNS FROM `$table` WHERE Field = 'id'");
                $actual = $id ? strtolower(preg_replace('/\(\d+\)/', '', $id->Type)) : null;
                if (!$status || strcasecmp($status->Engine, 'InnoDB') !== 0 || $actual !== $type) {
                    throw new RuntimeException('Template FK source is incompatible: '.$table);
                }
            }
        }
        Schema::create('gradebook_templates', function (Blueprint $t) {
            $t->engine = 'InnoDB';
            $t->bigIncrements('id');
            $t->uuid('identity')->unique();
            $t->integer('year_id');
            $t->integer('lesson_id');
            $t->integer('class_id');
            $t->unsignedBigInteger('created_by');
            $t->string('name', 200);
            $t->longText('draft_payload')->nullable();
            $t->unsignedInteger('draft_revision')->default(1);
            $t->unsignedInteger('draft_base_version')->nullable();
            $t->unsignedInteger('last_version')->default(0);
            $t->timestamps();
            $t->unique(['year_id', 'lesson_id'], 'gb_template_scope_unique');
            $t->foreign('year_id')->references('id')->on('years')->onDelete('restrict');
            $t->foreign('lesson_id')->references('id')->on('lessons')->onDelete('restrict');
            $t->foreign('class_id')->references('id')->on('classes')->onDelete('restrict');
            $t->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
        });
        Schema::create('gradebook_template_versions', function (Blueprint $t) {
            $t->engine = 'InnoDB';
            $t->bigIncrements('id');
            $t->unsignedBigInteger('template_id');
            $t->unsignedInteger('number');
            $t->unsignedInteger('draft_revision');
            $t->unsignedInteger('base_version')->nullable();
            $t->longText('payload');
            $t->char('content_hash', 64);
            $t->char('preview_token', 64);
            $t->unsignedBigInteger('published_by');
            $t->timestamp('published_at')->nullable();
            $t->unique(['template_id', 'number'], 'gb_version_number_unique');
            $t->unique(['template_id', 'draft_revision'], 'gb_version_revision_unique');
            $t->foreign('template_id')->references('id')->on('gradebook_templates')->onDelete('restrict');
            $t->foreign('published_by')->references('id')->on('users')->onDelete('restrict');
        });
        Schema::create('gradebook_events', function (Blueprint $t) {
            $t->engine = 'InnoDB';
            $t->bigIncrements('id');
            $t->unsignedBigInteger('template_id');
            $t->unsignedBigInteger('version_id')->nullable();
            $t->unsignedBigInteger('actor_id');
            $t->string('action', 48);
            $t->longText('metadata');
            $t->timestamp('created_at')->nullable();
            $t->index(['template_id', 'id']);
            $t->foreign('template_id')->references('id')->on('gradebook_templates')->onDelete('restrict');
            $t->foreign('version_id')->references('id')->on('gradebook_template_versions')->onDelete('restrict');
            $t->foreign('actor_id')->references('id')->on('users')->onDelete('restrict');
        });
        // Protect published content and audit history even from query-builder updates.
        foreach (['gradebook_template_versions'=>'gb_version', 'gradebook_events'=>'gb_event'] as $table=>$prefix) {
            foreach (['UPDATE', 'DELETE'] as $operation) {
                $name = $prefix.'_'.strtolower($operation).'_immutable';
                if (DB::getDriverName() === 'mysql') {
                    DB::unprepared("CREATE TRIGGER $name BEFORE $operation ON $table FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Gradebook published history is immutable'");
                } elseif (DB::getDriverName() === 'sqlite') {
                    DB::unprepared("CREATE TRIGGER $name BEFORE $operation ON $table BEGIN SELECT RAISE(ABORT, 'Gradebook published history is immutable'); END");
                } else {
                    throw new RuntimeException('Template immutability requires reviewed mysql/sqlite support.');
                }
            }
        }
    }

    public function down()
    {
        foreach (['gradebook_templates', 'gradebook_template_versions', 'gradebook_events'] as $table) {
            if (Schema::hasTable($table) && DB::table($table)->exists()) {
                throw new RuntimeException('Template history rollback requires an approved preservation plan.');
            }
        }
        foreach (['gradebook_events', 'gradebook_template_versions', 'gradebook_templates'] as $table) Schema::dropIfExists($table);
    }
}
