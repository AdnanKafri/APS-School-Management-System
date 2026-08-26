<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ExpandStudentIdentityTextColumns extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE `students` MODIFY `first_name` VARCHAR(40) NOT NULL');
        DB::statement('ALTER TABLE `students` MODIFY `father_name` VARCHAR(40) NULL');
        DB::statement('ALTER TABLE `students` MODIFY `mother_name` VARCHAR(40) NULL');
        DB::statement('ALTER TABLE `students` MODIFY `nationality` VARCHAR(60) NULL');
        DB::statement('ALTER TABLE `students` MODIFY `address` VARCHAR(200) NULL');
    }

    public function down()
    {
        if (
            DB::table('students')->whereRaw('CHAR_LENGTH(`first_name`) > 20')->exists()
            || DB::table('students')->whereRaw('CHAR_LENGTH(`father_name`) > 20')->exists()
            || DB::table('students')->whereRaw('CHAR_LENGTH(`mother_name`) > 20')->exists()
            || DB::table('students')->whereRaw('CHAR_LENGTH(`nationality`) > 30')->exists()
            || DB::table('students')->whereRaw('CHAR_LENGTH(`address`) > 100')->exists()
        ) {
            throw new RuntimeException('Cannot safely restore the previous student identity limits without truncating data.');
        }

        DB::statement('ALTER TABLE `students` MODIFY `first_name` VARCHAR(20) NOT NULL');
        DB::statement('ALTER TABLE `students` MODIFY `father_name` VARCHAR(20) NULL');
        DB::statement('ALTER TABLE `students` MODIFY `mother_name` VARCHAR(20) NULL');
        DB::statement('ALTER TABLE `students` MODIFY `nationality` VARCHAR(30) NULL');
        DB::statement('ALTER TABLE `students` MODIFY `address` VARCHAR(100) NULL');
    }
}
