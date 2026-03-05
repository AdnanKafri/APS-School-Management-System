<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradebookComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gradebook_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('year_id');
            $table->string('name');
            $table->integer('max_mark')->default(0);
            $table->integer('weight')->default(100);
            $table->integer('sort_order')->default(0);
            $table->string('data_source')->default('DYNAMIC'); 
            // data_source values: 'LEGACY_ORAL', 'LEGACY_HOMEWORK', 'LEGACY_EXAM', 'DYNAMIC'
            
            $table->timestamps();

            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->index(['lesson_id', 'year_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gradebook_components');
    }
}
