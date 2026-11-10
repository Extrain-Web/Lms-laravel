<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'category',
        'category_slug',
        'duration',
        'seats',
        'fee',
        'level',
        'overview',
        'short_description',
        'total_hours',
        'seats_remaining',
        'schedule',
        'centers',
        'admission_deadline',
        'learning_outcomes',
        'career_opportunities',
        'curriculum',
        'prerequisites',
        'certification',
        'badge',
        'featured',
        'is_subsidized',
        'image',
    ];

    protected $casts = [
        'curriculum' => 'array',
        'learning_outcomes' => 'array',
        'career_opportunities' => 'array',
        'featured' => 'boolean',
        'is_subsidized' => 'boolean',
        'seats' => 'integer',
        'seats_remaining' => 'integer',
        'total_hours' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
            if (empty($course->category_slug)) {
                $course->category_slug = Str::slug($course->category);
            }
        });
    }
}
