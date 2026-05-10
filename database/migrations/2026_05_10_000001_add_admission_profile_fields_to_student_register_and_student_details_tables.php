<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdmissionProfileFieldsToStudentRegisterAndStudentDetailsTables extends Migration
{
    public function up()
    {
        Schema::table('student_register', function (Blueprint $table) {
            if (!Schema::hasColumn('student_register', 'permanent_address')) {
                $table->text('permanent_address')->nullable()->after('con_sch');
            }
            if (!Schema::hasColumn('student_register', 'current_address')) {
                $table->text('current_address')->nullable()->after('permanent_address');
            }
            if (!Schema::hasColumn('student_register', 'guardian_name')) {
                $table->string('guardian_name')->nullable()->after('current_address');
            }
            if (!Schema::hasColumn('student_register', 'guardian_relation')) {
                $table->string('guardian_relation')->nullable()->after('guardian_name');
            }
            if (!Schema::hasColumn('student_register', 'guardian_phone')) {
                $table->string('guardian_phone')->nullable()->after('guardian_relation');
            }
            if (!Schema::hasColumn('student_register', 'medical_notes')) {
                $table->longText('medical_notes')->nullable()->after('guardian_phone');
            }
            if (!Schema::hasColumn('student_register', 'chronic_diseases')) {
                $table->longText('chronic_diseases')->nullable()->after('medical_notes');
            }
            if (!Schema::hasColumn('student_register', 'allergies')) {
                $table->longText('allergies')->nullable()->after('chronic_diseases');
            }
            if (!Schema::hasColumn('student_register', 'fever_medicine_permission')) {
                $table->tinyInteger('fever_medicine_permission')->nullable()->after('allergies');
            }
            if (!Schema::hasColumn('student_register', 'custody_notes')) {
                $table->longText('custody_notes')->nullable()->after('fever_medicine_permission');
            }
        });

        Schema::table('student_details', function (Blueprint $table) {
            if (!Schema::hasColumn('student_details', 'permanent_address')) {
                $table->text('permanent_address')->nullable()->after('con_sch');
            }
            if (!Schema::hasColumn('student_details', 'current_address')) {
                $table->text('current_address')->nullable()->after('permanent_address');
            }
            if (!Schema::hasColumn('student_details', 'guardian_name')) {
                $table->string('guardian_name')->nullable()->after('current_address');
            }
            if (!Schema::hasColumn('student_details', 'guardian_relation')) {
                $table->string('guardian_relation')->nullable()->after('guardian_name');
            }
            if (!Schema::hasColumn('student_details', 'guardian_phone')) {
                $table->string('guardian_phone')->nullable()->after('guardian_relation');
            }
            if (!Schema::hasColumn('student_details', 'medical_notes')) {
                $table->longText('medical_notes')->nullable()->after('guardian_phone');
            }
            if (!Schema::hasColumn('student_details', 'chronic_diseases')) {
                $table->longText('chronic_diseases')->nullable()->after('medical_notes');
            }
            if (!Schema::hasColumn('student_details', 'allergies')) {
                $table->longText('allergies')->nullable()->after('chronic_diseases');
            }
            if (!Schema::hasColumn('student_details', 'fever_medicine_permission')) {
                $table->tinyInteger('fever_medicine_permission')->nullable()->after('allergies');
            }
            if (!Schema::hasColumn('student_details', 'custody_notes')) {
                $table->longText('custody_notes')->nullable()->after('fever_medicine_permission');
            }
        });
    }

    public function down()
    {
        Schema::table('student_register', function (Blueprint $table) {
            $columns = [
                'permanent_address',
                'current_address',
                'guardian_name',
                'guardian_relation',
                'guardian_phone',
                'medical_notes',
                'chronic_diseases',
                'allergies',
                'fever_medicine_permission',
                'custody_notes',
            ];
            $existing = array_values(array_filter($columns, function ($column) {
                return Schema::hasColumn('student_register', $column);
            }));
            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });

        Schema::table('student_details', function (Blueprint $table) {
            $columns = [
                'permanent_address',
                'current_address',
                'guardian_name',
                'guardian_relation',
                'guardian_phone',
                'medical_notes',
                'chronic_diseases',
                'allergies',
                'fever_medicine_permission',
                'custody_notes',
            ];
            $existing = array_values(array_filter($columns, function ($column) {
                return Schema::hasColumn('student_details', $column);
            }));
            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
}
