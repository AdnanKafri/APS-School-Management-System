<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminOriginToStudentFollowUpsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('student_follow_ups') || Schema::hasColumn('student_follow_ups', 'created_by_admin_user_id')) return;
        Schema::table('student_follow_ups', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by_admin_user_id')->nullable()->index()->after('created_by_user_id');
            $table->string('created_via', 30)->nullable()->after('created_by_admin_user_id');
        });
    }

    public function down()
    {
        if (Schema::hasTable('student_follow_ups') && Schema::hasColumn('student_follow_ups', 'created_by_admin_user_id')) {
            Schema::table('student_follow_ups', function (Blueprint $table) { $table->dropColumn(['created_by_admin_user_id', 'created_via']); });
        }
    }
}
