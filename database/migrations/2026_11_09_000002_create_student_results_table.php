<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->string('roll_no')->unique();
            $table->string('reg_no')->unique();
            $table->string('student_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('session');
            $table->string('trade');
            $table->string('center')->nullable();
            $table->string('institute_name');
            $table->string('exam_year');
            $table->string('issue_date');
            $table->decimal('gpa', 4, 2);
            $table->string('grade');
            $table->json('marks')->nullable(); // [{"subject": "Theory", "fullMarks": 100, "obtained": 88, "grade": "A+"}, ...]
            $table->string('verification_status')->default('VERIFIED');
            $table->string('qr_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};
