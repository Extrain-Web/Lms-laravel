<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_results', function (Blueprint $table) {
            if (!Schema::hasColumn('student_results', 'photo')) {
                $table->string('photo')->nullable()->after('student_name');
            }
            if (!Schema::hasColumn('student_results', 'course_code')) {
                $table->string('course_code')->nullable()->after('session');
            }
            if (!Schema::hasColumn('student_results', 'result_score')) {
                $table->string('result_score')->nullable()->after('gpa');
            }
        });
    }

    public function down(): void
    {
        Schema::table('student_results', function (Blueprint $table) {
            $table->dropColumn(['photo', 'course_code', 'result_score']);
        });
    }
};
