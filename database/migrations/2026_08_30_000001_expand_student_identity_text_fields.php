<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ExpandStudentIdentityTextFields extends Migration
{
    private $columns = [
        'first_name' => [40, 80, false],
        'father_name' => [40, 80, true],
        'mother_name' => [40, 80, true],
        'address' => [200, 400, true],
        'nationality' => [60, 120, true],
    ];

    public function up()
    {
        foreach ($this->columns as $column => $lengths) {
            $this->resizeColumn($column, $lengths[1], $lengths[0]);
        }
    }

    public function down()
    {
        foreach ($this->columns as $column => $lengths) {
            $this->resizeColumn($column, $lengths[0], $lengths[1]);
        }
    }

    private function resizeColumn($column, $targetLength, $minimumCurrentLength)
    {
        $table = DB::getTablePrefix() . 'students';
        $database = DB::getDatabaseName();
        $info = DB::selectOne(
            'SELECT CHARACTER_MAXIMUM_LENGTH, CHARACTER_SET_NAME, COLLATION_NAME, IS_NULLABLE
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?',
            [$database, $table, $column]
        );

        if (!$info || (int) $info->CHARACTER_MAXIMUM_LENGTH !== $minimumCurrentLength) {
            return;
        }

        if ($targetLength < $minimumCurrentLength) {
            $maxLength = DB::selectOne(
                'SELECT MAX(CHAR_LENGTH(`' . $column . '`)) AS max_length FROM `' . str_replace('`', '``', $table) . '`'
            );
            if ($maxLength && (int) $maxLength->max_length > $targetLength) {
                return;
            }
        }

        $type = 'VARCHAR(' . (int) $targetLength . ')';
        $charset = $info->CHARACTER_SET_NAME ? ' CHARACTER SET `' . $info->CHARACTER_SET_NAME . '`' : '';
        $collation = $info->COLLATION_NAME ? ' COLLATE `' . $info->COLLATION_NAME . '`' : '';
        $nullable = strtoupper($info->IS_NULLABLE) === 'YES' ? ' NULL' : ' NOT NULL';

        DB::statement(
            'ALTER TABLE `' . str_replace('`', '``', $table) . '` MODIFY `' . $column . '` '
            . $type . $charset . $collation . $nullable
        );
    }
}
