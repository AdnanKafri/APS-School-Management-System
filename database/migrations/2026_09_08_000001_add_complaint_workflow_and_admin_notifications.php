<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComplaintWorkflowAndAdminNotifications extends Migration
{
    public function up()
    {
        if (Schema::hasTable('complaints')) {
            Schema::table('complaints', function (Blueprint $table) {
                if (!Schema::hasColumn('complaints', 'resolved_at')) {
                    $table->timestamp('resolved_at')->nullable()->index();
                }

                if (!Schema::hasColumn('complaints', 'handled_by')) {
                    // Deliberately not a foreign key: legacy user deletion must remain safe.
                    $table->unsignedBigInteger('handled_by')->nullable()->index();
                }
            });
        }

        if (!Schema::hasTable('admin_complaint_notifications')) {
            Schema::create('admin_complaint_notifications', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('complaint_id');
                $table->unsignedBigInteger('admin_id');
                $table->timestamp('read_at')->nullable()->index();
                $table->timestamps();

                $table->unique(['complaint_id', 'admin_id']);
                $table->index(['admin_id', 'read_at']);
                $table->foreign('complaint_id')
                    ->references('id')->on('complaints')
                    ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('admin_complaint_notifications');

        if (Schema::hasTable('complaints')) {
            Schema::table('complaints', function (Blueprint $table) {
                if (Schema::hasColumn('complaints', 'handled_by')) {
                    $table->dropColumn('handled_by');
                }
                if (Schema::hasColumn('complaints', 'resolved_at')) {
                    $table->dropColumn('resolved_at');
                }
            });
        }
    }
}
