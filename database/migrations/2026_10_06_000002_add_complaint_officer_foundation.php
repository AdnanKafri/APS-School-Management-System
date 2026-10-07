<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddComplaintOfficerFoundation extends Migration
{
    public function up()
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            $column = DB::select("SHOW COLUMNS FROM users LIKE 'type'")[0];
            if (strpos($column->Type, 'enum(') === 0 && strpos($column->Type, "'8'") === false) {
                // Preserve any hosting-specific enum values and the original null/default semantics.
                $type = substr($column->Type, 0, -1) . ",'8')";
                $nullable = $column->Null === 'YES' ? ' NULL' : ' NOT NULL';
                $default = $column->Default === null ? ($column->Null === 'YES' ? ' DEFAULT NULL' : '')
                    : ' DEFAULT ' . DB::connection()->getPdo()->quote($column->Default);
                DB::statement('ALTER TABLE users MODIFY type ' . $type . $nullable . $default);
            }
        }
        if (!Schema::hasColumn('users', 'complaint_officer_active')) {
            Schema::table('users', function (Blueprint $table) { $table->boolean('complaint_officer_active')->default(true); });
        }
        if (!Schema::hasColumn('users', 'complaint_auth_version')) {
            Schema::table('users', function (Blueprint $table) { $table->unsignedInteger('complaint_auth_version')->default(1); });
        }
        if (Schema::hasTable('complaint_action_audits')) {
            return;
        }
        Schema::create('complaint_action_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('complaint_id')->index();
            $table->unsignedBigInteger('actor_id')->index();
            $table->string('action', 30);
            $table->string('previous_status', 20);
            $table->string('new_status', 20);
            $table->unsignedBigInteger('previous_handler_id')->nullable();
            $table->unsignedBigInteger('new_handler_id')->nullable();
            $table->timestamp('occurred_at');
        });
    }

    public function down()
    {
        // Removing officer identities or action history is deliberately not automatic.
        throw new \RuntimeException('Complaint officer foundation requires an explicit preservation plan before rollback.');
    }
}
