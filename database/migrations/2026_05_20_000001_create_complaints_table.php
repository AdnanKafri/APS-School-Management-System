<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->index();
            $table->string('student_name');
            $table->string('applicant_name');
            $table->string('phone', 50);
            $table->string('class_name');
            $table->string('section_name');
            $table->string('bus_number')->nullable();
            $table->text('complaint_text');
            $table->string('status', 20)->default('new')->index();
            $table->timestamp('viewed_at')->nullable()->index();
            $table->timestamp('archived_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}
