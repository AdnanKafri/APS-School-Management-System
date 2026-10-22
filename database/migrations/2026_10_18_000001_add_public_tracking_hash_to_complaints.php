<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublicTrackingHashToComplaints extends Migration
{
    public function up()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->char('public_tracking_hash', 64)->nullable()->unique();
        });
    }

    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropUnique(['public_tracking_hash']);
            $table->dropColumn('public_tracking_hash');
        });
    }
}
