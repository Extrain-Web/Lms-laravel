<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category'); // 'Syllabus', 'Forms', 'Notices', 'Books', 'Question Bank'
            $table->string('file_size')->default('1.2 MB');
            $table->string('file_type')->default('PDF');
            $table->string('download_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
