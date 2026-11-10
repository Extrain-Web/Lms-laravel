<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentPortalController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Matches Next.js routes exactly)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Courses
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

// Exam Results & Verification
Route::get('/results', [ResultController::class, 'index'])->name('results.index');
Route::match(['get', 'post'], '/results/search', [ResultController::class, 'search'])->name('results.search');
Route::get('/results/verify/{roll_no}', [ResultController::class, 'verify'])->name('results.verify');
Route::get('/results/print/{roll_no}', [ResultController::class, 'print'])->name('results.print');

// Register / Admission
Route::get('/register', [AdmissionController::class, 'create'])->name('register');
Route::post('/register', [AdmissionController::class, 'store'])->name('register.store');
Route::get('/apply', [AdmissionController::class, 'create'])->name('admissions.apply');
Route::post('/apply', [AdmissionController::class, 'store'])->name('admissions.store');

// Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Resources
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');

// Contact Us
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Directorate Admin Control Center
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(EnsureUserIsAdmin::class)->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.tab');

    Route::post('/courses', [AdminDashboardController::class, 'storeCourse'])->name('admin.courses.store');
    Route::post('/courses/{id}/update', [AdminDashboardController::class, 'updateCourse'])->name('admin.courses.update');
    Route::post('/courses/{id}/delete', [AdminDashboardController::class, 'deleteCourse'])->name('admin.courses.delete');

    Route::post('/results', [AdminDashboardController::class, 'storeResult'])->name('admin.results.store');
    Route::post('/results/{id}/update', [AdminDashboardController::class, 'updateResult'])->name('admin.results.update');
    Route::post('/results/{id}/delete', [AdminDashboardController::class, 'deleteResult'])->name('admin.results.delete');

    Route::post('/admissions/{id}/status', [AdminDashboardController::class, 'updateAdmissionStatus'])->name('admin.admissions.status');
    Route::post('/admissions/{id}/update', [AdminDashboardController::class, 'updateAdmission'])->name('admin.admissions.update');
    Route::post('/admissions/{id}/delete', [AdminDashboardController::class, 'deleteAdmission'])->name('admin.admissions.delete');

    Route::post('/inquiries/{id}/status', [AdminDashboardController::class, 'updateInquiryStatus'])->name('admin.inquiries.status');
    Route::post('/inquiries/{id}/delete', [AdminDashboardController::class, 'deleteInquiry'])->name('admin.inquiries.delete');

    Route::post('/resources', [AdminDashboardController::class, 'storeResource'])->name('admin.resources.store');
    Route::post('/resources/{id}/update', [AdminDashboardController::class, 'updateResource'])->name('admin.resources.update');
    Route::post('/resources/{id}/delete', [AdminDashboardController::class, 'deleteResource'])->name('admin.resources.delete');

    Route::post('/gallery', [AdminDashboardController::class, 'storeGallery'])->name('admin.gallery.store');
    Route::post('/gallery/{id}/update', [AdminDashboardController::class, 'updateGallery'])->name('admin.gallery.update');
    Route::post('/gallery/{id}/delete', [AdminDashboardController::class, 'deleteGallery'])->name('admin.gallery.delete');

    Route::post('/testimonials', [AdminDashboardController::class, 'storeTestimonial'])->name('admin.testimonials.store');
    Route::post('/testimonials/{id}/update', [AdminDashboardController::class, 'updateTestimonial'])->name('admin.testimonials.update');
    Route::post('/testimonials/{id}/delete', [AdminDashboardController::class, 'deleteTestimonial'])->name('admin.testimonials.delete');

    Route::post('/hero-slides', [AdminDashboardController::class, 'storeHeroSlide'])->name('admin.hero_slides.store');
    Route::post('/hero-slides/{id}/update', [AdminDashboardController::class, 'updateHeroSlide'])->name('admin.hero_slides.update');
    Route::post('/hero-slides/{id}/delete', [AdminDashboardController::class, 'deleteHeroSlide'])->name('admin.hero_slides.delete');

    Route::post('/settings', [AdminDashboardController::class, 'updateSettings'])->name('admin.settings.update');
});

/*
|--------------------------------------------------------------------------
| Student Portal
|--------------------------------------------------------------------------
*/
Route::prefix('student')->middleware('auth')->group(function () {
    Route::get('/', [StudentPortalController::class, 'index'])->name('student.dashboard');
    Route::get('/dashboard', [StudentPortalController::class, 'index'])->name('student.dashboard.tab');
});
