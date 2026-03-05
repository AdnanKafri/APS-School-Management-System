<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradebookConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gradebook_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('year_id');
            // Using integer for marks. If decimals needed, use float/decimal. 
            // School marks usually integers or halfs, but for 'Max' usually integer.
            $table->integer('oral_max')->default(0);
            $table->integer('homework_max')->default(0); 
            $table->integer('exam_max')->default(0);
            $table->timestamps();

            // Constraint: One config per subject per year
            $table->unique(['lesson_id', 'year_id'], 'gb_conf_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gradebook_configs');
    }
}
