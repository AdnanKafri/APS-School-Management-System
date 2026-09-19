<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFollowUpsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('student_follow_ups')) {
            return;
        }

        Schema::create('student_follow_ups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('student_id')->index();
            $table->unsignedInteger('teacher_id')->index();
            $table->unsignedInteger('lesson_id')->index();
            $table->unsignedInteger('year_id')->index();
            $table->unsignedInteger('term_id')->nullable()->index();
            $table->unsignedInteger('class_id')->nullable()->index();
            $table->unsignedInteger('room_id')->nullable()->index();
            $table->unsignedBigInteger('student_academic_placement_id')->nullable()->index();
            $table->unsignedBigInteger('teacher_assignment_period_id')->index();
            $table->string('level', 20)->nullable();
            $table->text('note')->nullable();
            $table->dateTime('observed_at')->index();
            $table->date('compliance_month')->index();
            $table->unsignedTinyInteger('compliance_half');
            $table->unsignedBigInteger('created_by_user_id')->index();
            $table->unsignedBigInteger('last_edited_by_user_id')->nullable()->index();
            $table->dateTime('edited_at')->nullable();
            $table->dateTime('voided_at')->nullable()->index();
            $table->unsignedBigInteger('voided_by')->nullable()->index();
            $table->text('void_reason')->nullable();
            $table->timestamps();

            $table->index(['teacher_id', 'year_id', 'room_id', 'lesson_id', 'observed_at'], 'sfu_teacher_context_index');
            $table->index(['student_id', 'year_id', 'observed_at'], 'sfu_student_year_date_index');
            $table->index(['year_id', 'compliance_month', 'compliance_half'], 'sfu_compliance_period_index');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_follow_ups');
    }
}
