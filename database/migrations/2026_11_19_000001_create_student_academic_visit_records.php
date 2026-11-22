<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStudentAcademicVisitRecords extends Migration
{
    public function up()
    {
        if (Schema::hasTable('student_academic_visit_records') || Schema::hasTable('student_placement_reconciliations')) {
            throw new RuntimeException('Visit foundation already or partially exists; review migration registration before proceeding.');
        }
        Schema::create('student_academic_visit_records', function (Blueprint $t) {
            $t->bigIncrements('id');
            $t->unsignedBigInteger('placement_id')->index();
            $t->unsignedBigInteger('student_id');
            $t->unsignedBigInteger('year_id');
            $t->unsignedBigInteger('room_id');
            $t->string('record_type', 30);
            $t->string('summary_type', 16)->nullable();
            $t->unsignedBigInteger('record_id');
            $t->string('evidence', 100);
            $t->timestamp('created_at')->nullable();
            $t->unique(['record_type', 'record_id'], 'visit_original_record_unique');
            $t->unique(['placement_id','summary_type'], 'visit_summary_unique');
            $t->index(['student_id','year_id','room_id','record_type'], 'visit_context_index');
        });
        Schema::create('student_placement_reconciliations', function (Blueprint $t) {
            $t->bigIncrements('id');
            $t->unsignedBigInteger('student_id')->index();
            $t->unsignedBigInteger('year_id');
            $t->unsignedBigInteger('actioned_by');
            $t->unsignedBigInteger('from_placement_id')->nullable();
            $t->unsignedBigInteger('observed_placement_id');
            $t->unsignedBigInteger('observed_room_id');
            $t->text('reason');
            $t->longText('before_snapshot');
            $t->dateTime('confirmed_at');
        });
        // No legacy backfill and no academic-row updates. Legacy identifiers have
        // mixed integer types; links are validated under the student lock in code.
    }

    public function down()
    {
        foreach (['student_academic_visit_records','student_placement_reconciliations'] as $table) {
            if (Schema::hasTable($table) && DB::table($table)->exists()) {
                throw new RuntimeException('Retained visit history prevents destructive rollback.');
            }
        }
        Schema::dropIfExists('student_academic_visit_records');
        Schema::dropIfExists('student_placement_reconciliations');
    }
}
