<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('duration')->nullable();
            $table->string('highlight')->nullable();
            $table->string('bg_image')->nullable();
            $table->string('btn1_text')->default('Explore Programs');
            $table->string('btn1_link')->default('/courses');
            $table->string('btn2_text')->default('Apply for Admission');
            $table->string('btn2_link')->default('/register');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add additional rich course columns if not already present
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'short_description')) {
                $table->text('short_description')->nullable();
            }
            if (!Schema::hasColumn('courses', 'total_hours')) {
                $table->integer('total_hours')->default(360);
            }
            if (!Schema::hasColumn('courses', 'seats_remaining')) {
                $table->integer('seats_remaining')->default(8);
            }
            if (!Schema::hasColumn('courses', 'schedule')) {
                $table->string('schedule')->nullable()->default('Sunday - Thursday (9:00 AM - 1:00 PM)');
            }
            if (!Schema::hasColumn('courses', 'centers')) {
                $table->string('centers')->nullable()->default('All 64 District Regional Hubs');
            }
            if (!Schema::hasColumn('courses', 'admission_deadline')) {
                $table->string('admission_deadline')->nullable()->default('Open for Current Session');
            }
            if (!Schema::hasColumn('courses', 'learning_outcomes')) {
                $table->json('learning_outcomes')->nullable();
            }
            if (!Schema::hasColumn('courses', 'career_opportunities')) {
                $table->json('career_opportunities')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
