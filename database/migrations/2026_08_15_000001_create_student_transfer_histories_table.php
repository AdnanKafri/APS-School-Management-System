<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTransferHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('student_transfer_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('year_id')->nullable()->index();
            $table->unsignedBigInteger('from_class_id')->nullable();
            $table->unsignedBigInteger('from_room_id')->nullable();
            $table->unsignedBigInteger('to_class_id')->nullable();
            $table->unsignedBigInteger('to_room_id')->nullable();
            $table->unsignedBigInteger('previous_room_student_id')->nullable();
            $table->unsignedBigInteger('previous_students_mark_id')->nullable();
            $table->unsignedBigInteger('previous_report_card_id')->nullable();
            $table->longText('previous_room_student_snapshot')->nullable();
            $table->longText('previous_students_mark_snapshot')->nullable();
            $table->longText('previous_report_card_snapshot')->nullable();
            $table->unsignedBigInteger('transferred_by_user_id')->nullable();
            $table->string('transfer_type')->default('cross_grade_current_year');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_transfer_histories');
    }
}
