<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReconcileStudentTransferHistoriesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('student_transfer_histories')) {
            return;
        }

        Schema::table('student_transfer_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('student_transfer_histories', 'from_placement_id')) {
                $table->unsignedBigInteger('from_placement_id')->nullable()->index();
            }

            if (!Schema::hasColumn('student_transfer_histories', 'to_placement_id')) {
                $table->unsignedBigInteger('to_placement_id')->nullable()->index();
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('student_transfer_histories')) {
            return;
        }

        Schema::table('student_transfer_histories', function (Blueprint $table) {
            if (Schema::hasColumn('student_transfer_histories', 'from_placement_id')) {
                $table->dropColumn('from_placement_id');
            }

            if (Schema::hasColumn('student_transfer_histories', 'to_placement_id')) {
                $table->dropColumn('to_placement_id');
            }
        });
    }
}
