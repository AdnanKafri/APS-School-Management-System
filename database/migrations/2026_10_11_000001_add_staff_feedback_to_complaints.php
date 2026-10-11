<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddStaffFeedbackToComplaints extends Migration
{
    private const PARENT_FIELDS = ['student_name', 'applicant_name', 'class_name', 'section_name'];

    public function up()
    {
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            // SQLite tests create these columns nullable; its older ALTER cannot change nullability.
            foreach (DB::select('PRAGMA table_info(complaints)') as $column) {
                if (in_array($column->name, self::PARENT_FIELDS, true) && $column->notnull) {
                    throw new \RuntimeException('SQLite complaints parent fields must be nullable before this migration.');
                }
            }
        } elseif ($driver !== 'mysql') {
            throw new \RuntimeException('Unsupported complaints schema driver.');
        }

        Schema::table('complaints', function (Blueprint $table) {
            $table->string('source', 20)->default('parent')->index();
            $table->string('staff_name', 190)->nullable();
        });

        if ($driver === 'mysql') {
            foreach (self::PARENT_FIELDS as $field) {
                DB::statement("ALTER TABLE `complaints` MODIFY `{$field}` VARCHAR(255) NULL");
            }
        }
    }

    public function down()
    {
        if (DB::table('complaints')->where('source', 'staff')->exists()) {
            throw new \RuntimeException('Staff feedback exists; preserve it before reverting this migration.');
        }

        if (DB::getDriverName() === 'mysql') {
            foreach (self::PARENT_FIELDS as $field) {
                DB::statement("ALTER TABLE `complaints` MODIFY `{$field}` VARCHAR(255) NOT NULL");
            }
        }
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('staff_name');
            $table->dropIndex(['source']);
            $table->dropColumn('source');
        });
    }
}
