<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentLifecycleFieldsAndEvents extends Migration
{
    public function up()
    {
        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                if (!Schema::hasColumn('students', 'lifecycle_status')) {
                    $table->string('lifecycle_status', 20)->default('active')->index();
                }
                if (!Schema::hasColumn('students', 'archived_at')) {
                    $table->dateTime('archived_at')->nullable()->index();
                }
                if (!Schema::hasColumn('students', 'archived_by')) {
                    $table->unsignedBigInteger('archived_by')->nullable()->index();
                }
                if (!Schema::hasColumn('students', 'archive_reason')) {
                    $table->text('archive_reason')->nullable();
                }
            });

            // Keep pre-existing students operational without changing any other field.
            Schema::getConnection()->table('students')
                ->whereNull('lifecycle_status')
                ->update(['lifecycle_status' => 'active']);
        }

        if (!Schema::hasTable('student_lifecycle_events')) {
            Schema::create('student_lifecycle_events', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('student_id')->index();
                $table->string('event_type', 20)->index();
                $table->dateTime('occurred_at')->index();
                $table->unsignedBigInteger('actioned_by')->nullable()->index();
                $table->text('reason')->nullable();
                $table->unsignedBigInteger('year_id')->nullable()->index();
                $table->unsignedBigInteger('placement_id')->nullable()->index();
                $table->unsignedBigInteger('room_student_id')->nullable()->index();
                $table->unsignedBigInteger('class_id')->nullable()->index();
                $table->unsignedBigInteger('room_id')->nullable()->index();
                $table->unsignedBigInteger('bus_id')->nullable()->index();
                $table->longText('before_state')->nullable();
                $table->longText('after_state')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('student_lifecycle_events');

        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                foreach (['archive_reason', 'archived_by', 'archived_at', 'lifecycle_status'] as $column) {
                    if (Schema::hasColumn('students', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
}
