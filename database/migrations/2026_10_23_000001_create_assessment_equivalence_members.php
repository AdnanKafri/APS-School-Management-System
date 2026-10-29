<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentEquivalenceMembers extends Migration
{
    public function up()
    {
        if (\Illuminate\Support\Facades\DB::connection()->getDriverName() === 'mysql') {
            // Check before DDL so an incompatible legacy source cannot leave a
            // half-created mapping table with an unapplied migration record.
            $source = \Illuminate\Support\Facades\DB::select("SHOW TABLE STATUS LIKE 'exams2'");
            $column = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM exams2 WHERE Field = 'id'");
            if (!$source || strcasecmp($source[0]->Engine, 'InnoDB') !== 0 || !$column
                || !preg_match('/^int(?:\(\d+\))?$/i', $column[0]->Type)) {
                throw new \RuntimeException('Assessment mapping requires an InnoDB exams2 table with signed INT id. Review schema before activation.');
            }
        }
        Schema::create('assessment_equivalence_members', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->uuid('identity');
            // Legacy exams2.id is a signed INT, including on the school MySQL schema.
            $table->integer('exam_id')->unique();
            $table->unsignedInteger('room_id');
            $table->unsignedInteger('year_id');
            $table->unsignedInteger('term_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('type');
            $table->decimal('maximum', 15, 4);
            $table->unsignedInteger('verified_by');
            $table->text('evidence');
            $table->timestamp('created_at');
            $table->unique(['identity', 'room_id']);
            $table->foreign('exam_id')->references('id')->on('exams2')->onDelete('restrict');
        });
    }

    public function down()
    {
        if (\Illuminate\Support\Facades\DB::table('assessment_equivalence_members')->exists()) {
            throw new \RuntimeException('Assessment identity rollback requires an approved preservation plan.');
        }
        Schema::dropIfExists('assessment_equivalence_members');
    }
}
