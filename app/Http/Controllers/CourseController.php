<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $allCourses = Course::orderBy('featured', 'desc')->latest()->get();

        // Dynamically compute unique categories with exact counts
        $categoryMap = [];
        foreach ($allCourses as $c) {
            $slug = $c->category_slug ?: Str::slug($c->category);
            if (!isset($categoryMap[$slug])) {
                $categoryMap[$slug] = [
                    'name' => $c->category,
                    'slug' => $slug,
                    'count' => 0
                ];
            }
            $categoryMap[$slug]['count']++;
        }
        $categories = array_values($categoryMap);

        // Fetch site settings
        $settings = SiteSetting::getAllSettings();

        // Also pass $courses for backwards compatibility if needed
        $courses = $allCourses;

        return view('courses.index', compact('allCourses', 'courses', 'categories', 'settings'));
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $relatedCourses = Course::where('id', '!=', $course->id)
            ->where('category_slug', $course->category_slug)
            ->take(3)
            ->get();

        $helplinePhone = SiteSetting::get('coursesPageHelplinePhone', SiteSetting::get('helplinePhone', '+880 1700-000000'));

        return view('courses.show', compact('course', 'relatedCourses', 'helplinePhone'));
    }
}
