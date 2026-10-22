<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ExpandComplaintStudentIdentifier extends Migration
{
    public function up()
    {
        // SQLite does not enforce VARCHAR lengths; no table rebuild is necessary.
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        $column = DB::selectOne("SHOW FULL COLUMNS FROM `complaints` LIKE 'student_identifier'");
        if (!$column || !preg_match('/^varchar\((\d+)\)$/i', $column->Type, $matches)) {
            throw new RuntimeException('Unexpected complaints.student_identifier column definition.');
        }
        if ((int) $matches[1] >= 15) {
            return;
        }

        $collation = $column->Collation;
        if (!preg_match('/^[a-z0-9_]+$/i', $collation)) {
            throw new RuntimeException('Unexpected student identifier collation.');
        }
        DB::statement('ALTER TABLE `complaints` MODIFY `student_identifier` VARCHAR(15) COLLATE ' . $collation . ' NULL DEFAULT NULL');
    }

    public function down()
    {
        // Intentionally retain capacity: shrinking would truncate legitimate identifiers.
    }
}
