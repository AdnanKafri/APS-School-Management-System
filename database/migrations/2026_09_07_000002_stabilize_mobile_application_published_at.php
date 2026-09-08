<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StabilizeMobileApplicationPublishedAt extends Migration
{
    public function up()
    {
        if (Schema::hasTable('mobile_application_releases') && DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE mobile_application_releases MODIFY published_at DATETIME NOT NULL');
        }
    }

    public function down()
    {
        // DATETIME is safe for existing releases and avoids legacy MySQL's implicit ON UPDATE behavior.
    }
}
