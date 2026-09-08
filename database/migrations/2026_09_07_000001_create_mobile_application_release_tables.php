<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMobileApplicationReleaseTables extends Migration
{
    public function up()
    {
        Schema::create('mobile_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 50)->unique();
            $table->string('audience', 20)->index();
            // Intentionally not constrained here to avoid a circular deployment dependency.
            $table->unsignedBigInteger('current_release_id')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('mobile_application_releases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->string('version', 50);
            $table->string('file_path', 255);
            $table->string('original_filename', 255);
            $table->unsignedBigInteger('file_size');
            $table->string('mime_type', 100);
            $table->char('sha256', 64);
            $table->string('release_notes', 500)->nullable();
            $table->dateTime('published_at');
            $table->unsignedBigInteger('uploaded_by')->nullable()->index();
            $table->timestamps();

            $table->unique(['application_id', 'version']);
            $table->foreign('application_id')
                ->references('id')->on('mobile_applications')
                ->onDelete('restrict');
        });

        $now = now();
        foreach ([
            'parent' => 'public',
            'teacher' => 'staff',
            'transport_supervisor' => 'staff',
        ] as $key => $audience) {
            DB::table('mobile_applications')->updateOrInsert(
                ['key' => $key],
                ['audience' => $audience, 'updated_at' => $now, 'created_at' => $now]
            );
        }
    }

    public function down()
    {
        Schema::dropIfExists('mobile_application_releases');
        Schema::dropIfExists('mobile_applications');
    }
}
