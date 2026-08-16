<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStudentAcademicPlacementsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('student_academic_placements')) {
            Schema::create('student_academic_placements', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('student_id')->index();
                $table->unsignedBigInteger('year_id')->index();
                $table->unsignedBigInteger('class_id')->nullable()->index();
                $table->unsignedBigInteger('room_id')->nullable()->index();
                $table->unsignedBigInteger('term_id')->nullable()->index();
                $table->dateTime('effective_from');
                $table->dateTime('effective_to')->nullable();
                $table->string('status', 20)->default('active')->index();
                $table->string('reason', 50)->nullable();
                $table->string('action_source', 50)->nullable();
                $table->unsignedBigInteger('actioned_by')->nullable()->index();
                $table->timestamps();

                $table->index(['student_id', 'year_id', 'status']);
            });
        }

        // The legacy application uses the singular table name. A clean
        // Laravel install may not have that legacy table yet, so defer the
        // backfill rather than making this foundation migration fail.
        if (!Schema::hasTable('room_student') || DB::table('student_academic_placements')->exists()) {
            return;
        }

        $rows = DB::table('room_student as rs')
            ->leftJoin('rooms as r', 'r.id', '=', 'rs.room_id')
            ->select([
                'rs.id',
                'rs.student_id',
                'rs.year_id',
                'rs.room_id',
                'rs.created_at',
                'r.class_id',
            ])
            ->orderBy('rs.student_id')
            ->orderBy('rs.year_id')
            ->orderBy('rs.id')
            ->get();

        foreach ($rows->groupBy(function ($row) {
            return $row->student_id . ':' . $row->year_id;
        }) as $group) {
            $group = $group->values();

            foreach ($group as $index => $row) {
                $effectiveFrom = $row->created_at ?: now();
                $next = $group->get($index + 1);
                $isCurrent = $next === null;

                DB::table('student_academic_placements')->insert([
                    'student_id' => $row->student_id,
                    'year_id' => $row->year_id,
                    'class_id' => $row->class_id,
                    'room_id' => $row->room_id,
                    'effective_from' => $effectiveFrom,
                    'effective_to' => $next ? ($next->created_at ?: now()) : null,
                    'status' => $isCurrent ? 'active' : 'closed',
                    'reason' => 'legacy_import',
                    'action_source' => 'legacy_room_student',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('student_academic_placements');
    }
}
