<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class EnsureLessonContentNoteUtf8mb4 extends Migration
{
    public function up()
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            throw new RuntimeException('This reviewed column migration requires MySQL/MariaDB.');
        }
        $column = DB::selectOne("SELECT COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT, CHARACTER_SET_NAME,
            COLLATION_NAME, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam' AND COLUMN_NAME='note'");
        if (!$column || strtolower($column->COLUMN_TYPE) !== 'text' || $column->IS_NULLABLE !== 'YES'
            || !in_array($column->COLUMN_DEFAULT, [null, 'NULL'], true) || $column->EXTRA !== '') {
            throw new RuntimeException('Unexpected lesson note definition. Review type, default and dependencies before proceeding.');
        }
        if (strtolower($column->CHARACTER_SET_NAME) === 'utf8mb4') {
            return; // Already compatible; do not change a site's existing utf8mb4 collation.
        }
        if (!in_array(strtolower($column->CHARACTER_SET_NAME), ['utf8', 'utf8mb3'], true)) {
            throw new RuntimeException('Unexpected lesson note source encoding; no automatic conversion is authorized.');
        }
        $engine = DB::selectOne("SELECT ENGINE FROM information_schema.TABLES
            WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam'");
        if (!$engine || strcasecmp($engine->ENGINE, 'InnoDB') !== 0
            || DB::selectOne("SELECT INDEX_NAME FROM information_schema.STATISTICS
                WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='lesson_teacher_room_term_exam' AND COLUMN_NAME='note' LIMIT 1")) {
            throw new RuntimeException('Review lesson table engine and indexed note dependencies before conversion.');
        }
        $connection = DB::selectOne('SELECT @@character_set_connection AS charset');
        if (!$connection || strtolower($connection->charset) !== 'utf8mb4'
            || !DB::selectOne("SELECT COLLATION_NAME FROM information_schema.COLLATIONS WHERE COLLATION_NAME='utf8mb4_unicode_ci'")) {
            throw new RuntimeException('An effective utf8mb4 connection and supported utf8mb4_unicode_ci collation are required.');
        }
        $comment = DB::connection()->getPdo()->quote($column->COLUMN_COMMENT);
        if ($comment === false) {
            throw new RuntimeException('Unable to preserve the existing lesson note comment.');
        }
        $wait = (int) DB::selectOne('SELECT @@SESSION.lock_wait_timeout AS seconds')->seconds;
        try {
            DB::statement('SET SESSION lock_wait_timeout=15');
            DB::statement('ALTER TABLE `lesson_teacher_room_term_exam` MODIFY COLUMN `note` TEXT '
                .'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '.$comment);
        } finally {
            DB::statement('SET SESSION lock_wait_timeout='.$wait);
        }
    }

    public function down()
    {
        // Downgrading could corrupt new supplementary Unicode notes. Preserve data.
        throw new RuntimeException('Unicode widening is intentionally irreversible. Do not narrow notes or restore over newer content.');
    }
}
