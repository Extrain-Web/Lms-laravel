<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Resource;
use App\Models\StudentResult;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('featured', 'desc')->latest()->take(6)->get();
        $featuredCourses = $courses;
        $gallery = GalleryItem::latest()->take(6)->get();
        $notices = Resource::where('category', 'Notices')->latest()->take(5)->get();
        $testimonials = Testimonial::all();
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('order', 'asc')->get();
        
        $stats = [
            'totalStudents' => StudentResult::count() + 1450, // includes verified alumni
            'totalCourses' => Course::count(),
            'totalDivisions' => 8,
            'totalHubs' => 64,
        ];

        $settings = SiteSetting::getAllSettings();

        return view('home', compact('courses', 'featuredCourses', 'gallery', 'notices', 'stats', 'settings', 'testimonials', 'heroSlides'));
    }
}
