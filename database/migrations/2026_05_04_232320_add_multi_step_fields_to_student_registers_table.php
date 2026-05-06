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
        if (!Schema::hasTable('student_register')) {
            return;
        }

        Schema::table('student_register', function (Blueprint $table) {
            if (!Schema::hasColumn('student_register', 'status')) {
                $table->integer('status')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'accepted_terms')) {
                $table->boolean('accepted_terms')->default(0);
            }
            if (!Schema::hasColumn('student_register', 'accepted_transport_terms')) {
                $table->boolean('accepted_transport_terms')->default(0);
            }
            if (!Schema::hasColumn('student_register', 'wants_transport')) {
                $table->boolean('wants_transport')->default(0);
            }
            if (!Schema::hasColumn('student_register', 'grade_level')) {
                $table->string('grade_level')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'registration_fee')) {
                $table->decimal('registration_fee', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('student_register', 'services_fee')) {
                $table->decimal('services_fee', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('student_register', 'transport_fee')) {
                $table->decimal('transport_fee', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('student_register', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('student_register', 'payment_method')) {
                $table->integer('payment_method')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'payment_status')) {
                $table->string('payment_status')->default('pending');
            }
            if (!Schema::hasColumn('student_register', 'payment_receipt')) {
                $table->string('payment_receipt')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'payment_date')) {
                $table->dateTime('payment_date')->nullable();
            }
            if (!Schema::hasColumn('student_register', 'current_step')) {
                $table->integer('current_step')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('student_register')) {
            return;
        }

        Schema::table('student_register', function (Blueprint $table) {
            $columns = [
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
                'current_step',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('student_register', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
