<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category');
            $table->string('category_slug');
            $table->string('duration');
            $table->integer('seats')->default(30);
            $table->string('fee')->default('Free');
            $table->string('level')->default('Beginner to Advanced');
            $table->text('overview');
            $table->json('curriculum')->nullable();
            $table->text('prerequisites')->nullable();
            $table->string('certification')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
