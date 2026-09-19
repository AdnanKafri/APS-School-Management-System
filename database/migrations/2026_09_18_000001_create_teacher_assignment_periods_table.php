<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateTeacherAssignmentPeriodsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('teacher_assignment_periods')) {
            Schema::create('teacher_assignment_periods', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('teacher_room_lesson_id')->nullable()->index();
                $table->unsignedInteger('teacher_id')->index();
                $table->unsignedInteger('lesson_id')->index();
                $table->unsignedInteger('year_id')->index();
                $table->unsignedInteger('class_id')->nullable()->index();
                $table->unsignedInteger('room_id')->nullable()->index();
                $table->dateTime('effective_from')->index();
                $table->dateTime('effective_to')->nullable()->index();
                $table->string('source', 50)->default('teacher_room_lesson');
                $table->timestamps();

                $table->index(['teacher_id', 'year_id', 'room_id', 'lesson_id'], 'tap_teacher_context_index');
            });
        }

        // Existing assignments are only a baseline from feature activation.
        // Their earlier responsibility dates are not inferred.
        $activeYear = DB::table('years')->where('current_year', 1)->first();
        if (!$activeYear || !Schema::hasTable('teacher_room_lesson')) {
            return;
        }

        $activationTime = Carbon::now('Asia/Damascus');
        DB::table('teacher_room_lesson')->where('year_id', $activeYear->id)->orderBy('id')->each(function ($assignment) use ($activationTime) {
            $exists = DB::table('teacher_assignment_periods')
                ->where('teacher_room_lesson_id', $assignment->id)
                ->whereNull('effective_to')
                ->exists();

            if (!$exists) {
                DB::table('teacher_assignment_periods')->insert([
                    'teacher_room_lesson_id' => $assignment->id,
                    'teacher_id' => $assignment->teacher_id,
                    'lesson_id' => $assignment->lesson_id,
                    'year_id' => $assignment->year_id,
                    'class_id' => $assignment->class_id,
                    'room_id' => $assignment->room_id,
                    'effective_from' => $activationTime,
                    'source' => 'feature_activation_baseline',
                    'created_at' => $activationTime,
                    'updated_at' => $activationTime,
                ]);
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_assignment_periods');
    }
}
