<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultiStepFieldsToStudentRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_register', function (Blueprint $table) {
            $table->string('status')->default('draft');
            $table->boolean('accepted_terms')->default(0);
            $table->boolean('accepted_transport_terms')->default(0);
            $table->boolean('wants_transport')->default(0);
            $table->string('grade_level')->nullable();
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->decimal('services_fee', 10, 2)->default(0);
            $table->decimal('transport_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_receipt')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->integer('current_step')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_register', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'accepted_terms',
                'accepted_transport_terms',
                'wants_transport',
                'grade_level',
                'registration_fee',
                'services_fee',
                'transport_fee',
                'total_amount',
                'payment_method',
                'payment_status',
                'payment_receipt',
                'payment_date',
                'current_step'
            ]);
        });
    }
}
