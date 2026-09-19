<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFollowUpEditAuditsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('student_follow_up_edit_audits')) {
            return;
        }

        Schema::create('student_follow_up_edit_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_follow_up_id')->index();
            $table->unsignedBigInteger('edited_by_user_id')->index();
            $table->string('previous_level', 20)->nullable();
            $table->text('previous_note')->nullable();
            $table->string('new_level', 20)->nullable();
            $table->text('new_note')->nullable();
            $table->dateTime('edited_at')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_follow_up_edit_audits');
    }
}
