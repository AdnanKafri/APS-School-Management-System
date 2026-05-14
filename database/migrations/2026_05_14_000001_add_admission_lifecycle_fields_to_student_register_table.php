<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAdmissionLifecycleFieldsToStudentRegisterTable extends Migration
{
    public function up()
    {
        Schema::table('student_register', function (Blueprint $table) {
            if (!Schema::hasColumn('student_register', 'admission_status')) {
                $table->string('admission_status', 50)->nullable()->index();
            }
            if (!Schema::hasColumn('student_register', 'admission_status_changed_at')) {
                $table->dateTime('admission_status_changed_at')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'admission_submitted_at')) {
                $table->dateTime('admission_submitted_at')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'admission_reviewed_at')) {
                $table->dateTime('admission_reviewed_at')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'admission_approved_at')) {
                $table->dateTime('admission_approved_at')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'admission_rejected_at')) {
                $table->dateTime('admission_rejected_at')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'admission_cancelled_at')) {
                $table->dateTime('admission_cancelled_at')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'admission_converted_at')) {
                $table->dateTime('admission_converted_at')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'admission_reviewed_by')) {
                $table->unsignedBigInteger('admission_reviewed_by')->nullable()->index();
            }
            if (!Schema::hasColumn('student_register', 'admission_converted_student_id')) {
                $table->unsignedBigInteger('admission_converted_student_id')->nullable()->index();
            }
            if (!Schema::hasColumn('student_register', 'admission_status_note')) {
                $table->longText('admission_status_note')->nullable();
            }
        });

        DB::table('student_register')
            ->where(function ($query) {
                $query->whereNull('probe')->orWhere('probe', 0);
            })
            ->whereNull('admission_status')
            ->whereNotNull('current_step')
            ->update([
                'admission_status' => 'draft',
                'admission_status_changed_at' => DB::raw('COALESCE(updated_at, created_at)'),
            ]);

        DB::table('student_register')
            ->where(function ($query) {
                $query->whereNull('probe')->orWhere('probe', 0);
            })
            ->whereNull('admission_status')
            ->whereNull('current_step')
            ->update([
                'admission_status' => 'pending_review',
                'admission_status_changed_at' => DB::raw('COALESCE(payment_date, updated_at, created_at)'),
                'admission_submitted_at' => DB::raw('COALESCE(payment_date, updated_at, created_at)'),
            ]);

        DB::table('student_register')
            ->whereNotNull('admission_converted_student_id')
            ->where('admission_status', 'approved')
            ->update([
                'admission_status' => 'converted_to_student',
            ]);
    }

    public function down()
    {
        Schema::table('student_register', function (Blueprint $table) {
            foreach ([
                'admission_status_note',
                'admission_converted_student_id',
                'admission_reviewed_by',
                'admission_converted_at',
                'admission_cancelled_at',
                'admission_rejected_at',
                'admission_approved_at',
                'admission_reviewed_at',
                'admission_submitted_at',
                'admission_status_changed_at',
                'admission_status',
            ] as $column) {
                if (Schema::hasColumn('student_register', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
