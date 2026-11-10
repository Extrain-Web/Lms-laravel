<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\ContactInquiry;
use App\Models\Course;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Resource;
use App\Models\SiteSetting;
use App\Models\StudentResult;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'overview');
        $subTab = $request->query('subtab', 'home');
        $search = $request->query('search', '');

        $courses = Course::latest()->get();
        $results = StudentResult::latest()->get();
        $admissions = Admission::latest()->get();
        $inquiries = ContactInquiry::latest()->get();
        $resources = Resource::latest()->get();
        $gallery = GalleryItem::latest()->get();
        $testimonials = Testimonial::latest()->get();
        $heroSlides = HeroSlide::orderBy('order', 'asc')->get();

        $stats = [
            'totalCourses' => $courses->count(),
            'totalResults' => $results->count(),
            'pendingAdmissions' => $admissions->where('status', 'Pending')->count(),
            'newInquiries' => $inquiries->where('status', 'New')->count(),
            'totalStudents' => $results->count() + 1450,
            'totalTestimonials' => $testimonials->count(),
            'totalResources' => $resources->count(),
            'totalGallery' => $gallery->count(),
            'totalHeroSlides' => $heroSlides->count(),
        ];

        $settings = SiteSetting::getAllSettings();

        $existingGalleryCats = GalleryItem::select('category')->distinct()->pluck('category')->filter()->values();
        $defaultGalleryCats = collect(['Computer Labs', 'Workshops & Trades', 'Campus Events', 'Graduation Ceremonies', 'Women Empowerment', 'ICT & Digital']);
        $galleryCategories = $existingGalleryCats->concat($defaultGalleryCats)->unique()->values();

        return view('admin.dashboard', compact(
            'activeTab',
            'subTab',
            'search',
            'courses',
            'results',
            'admissions',
            'inquiries',
            'resources',
            'gallery',
            'galleryCategories',
            'testimonials',
            'heroSlides',
            'stats',
            'settings'
        ));
    }

    // ==========================================
    // Courses Actions
    // ==========================================
    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'duration' => 'required|string',
            'seats' => 'required|integer',
            'fee' => 'required|string',
            'level' => 'required|string',
            'badge' => 'nullable|string',
            'image' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|max:5120',
            'short_description' => 'nullable|string',
            'overview' => 'required|string',
            'prerequisites' => 'nullable|string',
            'certification' => 'nullable|string',
            'total_hours' => 'nullable|integer',
            'seats_remaining' => 'nullable|integer',
            'schedule' => 'nullable|string',
            'centers' => 'nullable|string',
            'admission_deadline' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            $filename = 'course_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/courses'), $filename);
            $validated['image'] = '/uploads/courses/' . $filename;
        }

        $validated['image'] = $validated['image'] ?: 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop';
        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(10, 99);
        $validated['category_slug'] = Str::slug($validated['category']);
        $validated['featured'] = $request->boolean('featured');
        $validated['is_subsidized'] = $request->boolean('is_subsidized');
        $validated['is_subsidized'] = $request->has('is_subsidized');

        if ($request->filled('curriculum_text')) {
            $lines = array_filter(array_map('trim', explode("\n", $request->input('curriculum_text'))));
            $modules = [];
            foreach ($lines as $line) {
                $modules[] = [
                    'title' => $line,
                    'topics' => []
                ];
            }
            $validated['curriculum'] = $modules;
        }

        if ($request->filled('learning_outcomes_text')) {
            $validated['learning_outcomes'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('learning_outcomes_text')))));
        }

        if ($request->filled('career_opportunities_text')) {
            $validated['career_opportunities'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('career_opportunities_text')))));
        }

        Course::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'courses'])->with('success', 'New course trade created successfully!');
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'duration' => 'required|string',
            'seats' => 'required|integer',
            'fee' => 'required|string',
            'level' => 'required|string',
            'badge' => 'nullable|string',
            'image' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|max:5120',
            'short_description' => 'nullable|string',
            'overview' => 'required|string',
            'prerequisites' => 'nullable|string',
            'certification' => 'nullable|string',
            'total_hours' => 'nullable|integer',
            'seats_remaining' => 'nullable|integer',
            'schedule' => 'nullable|string',
            'centers' => 'nullable|string',
            'admission_deadline' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            $filename = 'course_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/courses'), $filename);
            $validated['image'] = '/uploads/courses/' . $filename;
        } elseif (empty($validated['image'])) {
            $validated['image'] = $course->image;
        }

        $validated['category_slug'] = Str::slug($validated['category']);
        $validated['featured'] = $request->boolean('featured');
        $validated['is_subsidized'] = $request->boolean('is_subsidized');

        if ($request->filled('curriculum_text')) {
            $lines = array_filter(array_map('trim', explode("\n", $request->input('curriculum_text'))));
            $modules = [];
            foreach ($lines as $line) {
                $modules[] = [
                    'title' => $line,
                    'topics' => []
                ];
            }
            $validated['curriculum'] = $modules;
        }

        if ($request->filled('learning_outcomes_text')) {
            $validated['learning_outcomes'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('learning_outcomes_text')))));
        }

        if ($request->filled('career_opportunities_text')) {
            $validated['career_opportunities'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('career_opportunities_text')))));
        }

        $course->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'courses'])->with('success', 'Course details updated successfully!');
    }

    public function deleteCourse($id)
    {
        Course::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'courses'])->with('success', 'Course deleted successfully!');
    }

    // ==========================================
    // Results Actions
    // ==========================================
    public function storeResult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roll_no' => 'required|string|unique:student_results,roll_no',
            'reg_no' => 'required|string|unique:student_results,reg_no',
            'student_name' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'photo_file' => 'nullable|image|max:5120',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'session' => 'required|string',
            'course_code' => 'nullable|string|max:100',
            'trade' => 'required|string',
            'center' => 'nullable|string',
            'institute_name' => 'required|string',
            'exam_year' => 'required|string',
            'issue_date' => 'required|string',
            'gpa' => 'required|numeric|min:0|max:4.00',
            'result_score' => 'nullable|string|max:100',
            'grade' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard', ['tab' => 'results'])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        unset($validated['photo_file']);

        $validated['father_name'] = !empty($validated['father_name']) ? $validated['father_name'] : '-';
        $validated['mother_name'] = !empty($validated['mother_name']) ? $validated['mother_name'] : '-';
        $validated['center'] = !empty($validated['center']) ? $validated['center'] : ($validated['institute_name'] ?? 'Central Campus');

        if ($request->hasFile('photo_file')) {
            if (!is_dir(public_path('uploads/students'))) {
                @mkdir(public_path('uploads/students'), 0755, true);
            }
            $file = $request->file('photo_file');
            $filename = 'student_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/students'), $filename);
            $validated['photo'] = '/uploads/students/' . $filename;
        }

        $validated['verification_status'] = 'VERIFIED & AUTHENTIC';
        $validated['qr_url'] = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($validated['roll_no'] . '-VERIFIED-' . $validated['student_name']);

        $marks = [];
        if ($request->boolean('include_marks') && $request->has('marks') && is_array($request->input('marks'))) {
            foreach ($request->input('marks') as $m) {
                if (!empty($m['subject'])) {
                    $marks[] = [
                        'subject' => trim($m['subject']),
                        'fullMarks' => (int)($m['fullMarks'] ?? 100),
                        'obtained' => (int)($m['obtained'] ?? 80),
                        'grade' => trim($m['grade'] ?? 'A+'),
                    ];
                }
            }
        }

        $validated['marks'] = !empty($marks) ? $marks : null;

        StudentResult::create($validated);
        User::provisionStudentAccount($validated['roll_no'], $validated['student_name']);

        return redirect()->route('admin.dashboard', ['tab' => 'results'])->with('success', 'Student examination record & verified transcript saved successfully!');
    }

    public function updateResult(Request $request, $id)
    {
        $result = StudentResult::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'roll_no' => 'required|string|unique:student_results,roll_no,' . $id,
            'reg_no' => 'required|string|unique:student_results,reg_no,' . $id,
            'student_name' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'photo_file' => 'nullable|image|max:5120',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'session' => 'required|string',
            'course_code' => 'nullable|string|max:100',
            'trade' => 'required|string',
            'center' => 'nullable|string',
            'institute_name' => 'required|string',
            'exam_year' => 'required|string',
            'issue_date' => 'required|string',
            'gpa' => 'required|numeric|min:0|max:4.00',
            'result_score' => 'nullable|string|max:100',
            'grade' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard', ['tab' => 'results'])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        unset($validated['photo_file']);

        $validated['father_name'] = !empty($validated['father_name']) ? $validated['father_name'] : '-';
        $validated['mother_name'] = !empty($validated['mother_name']) ? $validated['mother_name'] : '-';
        $validated['center'] = !empty($validated['center']) ? $validated['center'] : ($validated['institute_name'] ?? 'Central Campus');

        if ($request->hasFile('photo_file')) {
            if (!is_dir(public_path('uploads/students'))) {
                @mkdir(public_path('uploads/students'), 0755, true);
            }
            $file = $request->file('photo_file');
            $filename = 'student_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/students'), $filename);
            $validated['photo'] = '/uploads/students/' . $filename;
        } elseif ($request->boolean('remove_photo')) {
            $validated['photo'] = null;
        } elseif (empty($validated['photo'])) {
            $validated['photo'] = $result->photo;
        }

        $validated['verification_status'] = $request->input('verification_status') ?: 'VERIFIED & AUTHENTIC';
        $validated['qr_url'] = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($validated['roll_no'] . '-VERIFIED-' . $validated['student_name']);

        if ($request->boolean('include_marks') && $request->has('marks') && is_array($request->input('marks'))) {
            $marks = [];
            foreach ($request->input('marks') as $m) {
                if (!empty($m['subject'])) {
                    $marks[] = [
                        'subject' => trim($m['subject']),
                        'fullMarks' => (int)($m['fullMarks'] ?? 100),
                        'obtained' => (int)($m['obtained'] ?? 80),
                        'grade' => trim($m['grade'] ?? 'A+'),
                    ];
                }
            }
            $validated['marks'] = !empty($marks) ? $marks : null;
        } else {
            $validated['marks'] = null;
        }

        $result->update($validated);
        User::provisionStudentAccount($validated['roll_no'], $validated['student_name']);

        return redirect()->route('admin.dashboard', ['tab' => 'results'])->with('success', 'Student academic record updated successfully!');
    }

    public function deleteResult($id)
    {
        StudentResult::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'results'])->with('success', 'Student result record deleted successfully!');
    }

    // ==========================================
    // Admissions Actions
    // ==========================================
    public function updateAdmissionStatus(Request $request, $id)
    {
        $admission = Admission::findOrFail($id);
        $status = $request->input('status', 'Approved');
        
        $assignedRoll = $admission->assigned_roll;
        if ($status === 'Approved' && empty($assignedRoll)) {
            $assignedRoll = 'NYD-' . date('Y') . '-' . rand(1300, 9999);
        }

        $admission->update([
            'status' => $status,
            'assigned_roll' => $assignedRoll,
        ]);

        if ($status === 'Approved' && !empty($assignedRoll)) {
            User::provisionStudentAccount($assignedRoll, $admission->full_name, $admission->email, $admission->phone);
        }

        return redirect()->route('admin.dashboard', ['tab' => 'admissions'])->with('success', 'Admission application updated! Official Student Roll: ' . ($assignedRoll ?? 'N/A'));
    }

    public function updateAdmission(Request $request, $id)
    {
        $admission = Admission::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'trade' => 'required|string',
            'district' => 'required|string',
            'status' => 'required|string',
            'assigned_roll' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'Approved' && empty($validated['assigned_roll'])) {
            $validated['assigned_roll'] = 'NYD-' . date('Y') . '-' . rand(1300, 9999);
        }

        $admission->update($validated);

        if ($validated['status'] === 'Approved' && !empty($validated['assigned_roll'])) {
            User::provisionStudentAccount($validated['assigned_roll'], $validated['full_name'], $validated['email'], $validated['phone']);
        }

        return redirect()->route('admin.dashboard', ['tab' => 'admissions'])->with('success', 'Admission candidate details updated successfully!');
    }

    public function deleteAdmission($id)
    {
        Admission::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'admissions'])->with('success', 'Admission application deleted successfully!');
    }

    // ==========================================
    // Inquiry Actions
    // ==========================================
    public function updateInquiryStatus(Request $request, $id)
    {
        $inquiry = ContactInquiry::findOrFail($id);
        $inquiry->update([
            'status' => $request->input('status', 'Replied')
        ]);
        return redirect()->route('admin.dashboard', ['tab' => 'inquiries'])->with('success', 'Inquiry status updated successfully!');
    }

    public function deleteInquiry($id)
    {
        ContactInquiry::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'inquiries'])->with('success', 'Inquiry deleted successfully!');
    }

    // ==========================================
    // Resource Actions
    // ==========================================
    public function storeResource(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'file_size' => 'nullable|string',
            'file_type' => 'nullable|string',
            'download_url' => 'nullable|string',
            'resource_file' => 'nullable|file|max:20480',
        ]);

        if ($request->hasFile('resource_file')) {
            $file = $request->file('resource_file');
            $bytes = $file->getSize();
            $extension = $file->getClientOriginalExtension() ?: 'pdf';
            $filename = 'resource_' . time() . '_' . Str::random(6) . '.' . $extension;

            $destination = public_path('uploads/resources');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            $validated['download_url'] = '/uploads/resources/' . $filename;
            if ($bytes >= 1048576) {
                $validated['file_size'] = round($bytes / 1048576, 1) . ' MB';
            } elseif ($bytes >= 1024) {
                $validated['file_size'] = round($bytes / 1024, 0) . ' KB';
            } else {
                $validated['file_size'] = $bytes . ' B';
            }
            $validated['file_type'] = strtoupper($extension);
        }

        $validated['file_size'] = $validated['file_size'] ?: '1.5 MB';
        $validated['file_type'] = $validated['file_type'] ?: 'PDF';
        $validated['download_url'] = $validated['download_url'] ?: '#';

        Resource::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'resources'])->with('success', 'Resource document uploaded successfully!');
    }

    public function updateResource(Request $request, $id)
    {
        $resource = Resource::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'file_size' => 'nullable|string',
            'file_type' => 'nullable|string',
            'download_url' => 'nullable|string',
            'resource_file' => 'nullable|file|max:20480',
        ]);

        if ($request->hasFile('resource_file')) {
            $file = $request->file('resource_file');
            $bytes = $file->getSize();
            $extension = $file->getClientOriginalExtension() ?: 'pdf';
            $filename = 'resource_' . time() . '_' . Str::random(6) . '.' . $extension;

            $destination = public_path('uploads/resources');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            $validated['download_url'] = '/uploads/resources/' . $filename;
            if ($bytes >= 1048576) {
                $validated['file_size'] = round($bytes / 1048576, 1) . ' MB';
            } elseif ($bytes >= 1024) {
                $validated['file_size'] = round($bytes / 1024, 0) . ' KB';
            } else {
                $validated['file_size'] = $bytes . ' B';
            }
            $validated['file_type'] = strtoupper($extension);
        } elseif (empty($validated['download_url'])) {
            $validated['download_url'] = $resource->download_url;
        }

        $resource->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'resources'])->with('success', 'Resource document updated successfully!');
    }

    public function deleteResource($id)
    {
        Resource::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'resources'])->with('success', 'Resource file deleted successfully!');
    }

    // ==========================================
    // Gallery Actions
    // ==========================================
    public function storeGallery(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'new_category' => 'nullable|string|max:100',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|max:10240',
            'description' => 'nullable|string',
            'caption' => 'nullable|string',
        ]);

        if ($request->filled('new_category')) {
            $validated['category'] = trim($request->input('new_category'));
        }

        if (empty($validated['category'])) {
            $validated['category'] = 'Computer Labs';
        }

        if ($request->filled('description')) {
            $validated['caption'] = $validated['description'];
        } elseif ($request->filled('caption')) {
            $validated['description'] = $validated['caption'];
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'gallery_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery'), $filename);
            $validated['image_url'] = '/uploads/gallery/' . $filename;
        }

        $validated['image_url'] = $validated['image_url'] ?: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=800&auto=format&fit=crop';

        GalleryItem::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'gallery'])->with('success', 'Gallery photo uploaded successfully!');
    }

    public function updateGallery(Request $request, $id)
    {
        $item = GalleryItem::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string',
            'new_category' => 'nullable|string|max:100',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|max:10240',
            'description' => 'nullable|string',
            'caption' => 'nullable|string',
        ]);

        if ($request->filled('new_category')) {
            $validated['category'] = trim($request->input('new_category'));
        }

        if (empty($validated['category'])) {
            $validated['category'] = $item->category;
        }

        if ($request->filled('description')) {
            $validated['caption'] = $validated['description'];
        } elseif ($request->filled('caption')) {
            $validated['description'] = $validated['caption'];
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'gallery_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery'), $filename);
            $validated['image_url'] = '/uploads/gallery/' . $filename;
        } elseif (empty($validated['image_url'])) {
            $validated['image_url'] = $item->image_url;
        }

        $item->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'gallery'])->with('success', 'Gallery photo updated successfully!');
    }

    public function deleteGallery($id)
    {
        GalleryItem::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'gallery'])->with('success', 'Gallery photo deleted successfully!');
    }

    // ==========================================
    // Testimonials Actions (Dynamic CRUD)
    // ==========================================
    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'batch' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'avatar' => 'nullable|string',
            'avatar_file' => 'nullable|image|max:5120',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        if ($request->hasFile('avatar_file')) {
            if (!is_dir(public_path('uploads/testimonials'))) {
                @mkdir(public_path('uploads/testimonials'), 0755, true);
            }
            $file = $request->file('avatar_file');
            $filename = 'testi_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/testimonials'), $filename);
            $validated['avatar'] = '/uploads/testimonials/' . $filename;
        } else {
            $validated['avatar'] = !empty($validated['avatar']) ? trim($validated['avatar']) : null;
        }

        $validated['rating'] = $validated['rating'] ?: 5;

        Testimonial::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'testimonials'])->with('success', 'Student testimonial created successfully!');
    }

    public function updateTestimonial(Request $request, $id)
    {
        $testi = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'batch' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'avatar' => 'nullable|string',
            'avatar_file' => 'nullable|image|max:5120',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        if ($request->hasFile('avatar_file')) {
            if (!is_dir(public_path('uploads/testimonials'))) {
                @mkdir(public_path('uploads/testimonials'), 0755, true);
            }
            $file = $request->file('avatar_file');
            $filename = 'testi_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/testimonials'), $filename);
            $validated['avatar'] = '/uploads/testimonials/' . $filename;
        } elseif ($request->boolean('remove_avatar')) {
            $validated['avatar'] = null;
        } else {
            $validated['avatar'] = !empty($validated['avatar']) ? trim($validated['avatar']) : null;
        }

        $validated['rating'] = $validated['rating'] ?: 5;

        $testi->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'testimonials'])->with('success', 'Student testimonial updated successfully!');
    }

    public function deleteTestimonial($id)
    {
        Testimonial::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'testimonials'])->with('success', 'Student testimonial deleted successfully!');
    }

    // ==========================================
    // Master Site Settings & Section Content Action
    // ==========================================
    public function updateSettings(Request $request)
    {
        $subTab = $request->input('current_cms_tab', 'home');

        $data = $request->except([
            '_token',
            'current_cms_tab',
            'hero_bg_image_file',
            'about_image_file',
            'chairman_image_file',
            'popup_image_file',
            'courses_hero_bg_file',
            'header_logo_file',
            'remove_header_logo',
        ]);

        // Handle File Uploads for Core Sections
        if ($request->hasFile('header_logo_file')) {
            $file = $request->file('header_logo_file');
            $filename = 'logo_' . time() . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $filename);
            $data['headerLogoImage'] = '/uploads/settings/' . $filename;
        } elseif ($request->boolean('remove_header_logo')) {
            $data['headerLogoImage'] = '';
        }

        if ($request->hasFile('courses_hero_bg_file')) {
            $file = $request->file('courses_hero_bg_file');
            $filename = 'courses_hero_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/hero'), $filename);
            $data['coursesPageHeroBg'] = '/uploads/hero/' . $filename;
        }
        if ($request->hasFile('hero_bg_image_file')) {
            $file = $request->file('hero_bg_image_file');
            $filename = 'hero_bg_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/hero'), $filename);
            $data['heroBgImage'] = '/uploads/hero/' . $filename;
        }

        if ($request->hasFile('about_image_file')) {
            $file = $request->file('about_image_file');
            $filename = 'about_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $filename);
            $data['aboutImage'] = '/uploads/settings/' . $filename;
        }

        if ($request->hasFile('chairman_image_file')) {
            $file = $request->file('chairman_image_file');
            $filename = 'chairman_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/chairman'), $filename);
            $data['chairmanImage'] = '/uploads/chairman/' . $filename;
        }

        if ($request->hasFile('popup_image_file')) {
            $file = $request->file('popup_image_file');
            $filename = 'popup_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $filename);
            $data['popupImage'] = '/uploads/settings/' . $filename;
        }

        // Checkbox values
        $data['showTopBar'] = $request->has('showTopBar') ? '1' : '0';
        $data['urgentNoticeEnabled'] = $request->has('urgentNoticeEnabled') ? '1' : '0';
        $data['popupEnabled'] = $request->has('popupEnabled') ? '1' : '0';

        // Automatically sync unified formatted office hours string
        if ($request->filled('officeOpeningTime') || $request->filled('officeClosingTime') || $request->filled('officeWeeklyDays')) {
            $days = trim((string)($data['officeWeeklyDays'] ?? 'Sun - Thu (Fri - Sat Closed)'));
            $open = trim((string)($data['officeOpeningTime'] ?? '9:00 AM'));
            $close = trim((string)($data['officeClosingTime'] ?? '5:00 PM'));
            $data['contactOfficeHours'] = "{$days} • {$open} - {$close}";
        }

        // Sync legacy facebookUrl / youtubeUrl from socialLinks JSON if present
        if (!empty($data['socialLinks'])) {
            $decodedSocials = json_decode($data['socialLinks'], true);
            if (is_array($decodedSocials)) {
                foreach ($decodedSocials as $item) {
                    if (isset($item['platform'], $item['url'])) {
                        if (strtolower($item['platform']) === 'facebook') {
                            $data['facebookUrl'] = $item['url'];
                        } elseif (strtolower($item['platform']) === 'youtube') {
                            $data['youtubeUrl'] = $item['url'];
                        }
                    }
                }
            }
        }

        foreach ($data as $key => $val) {
            SiteSetting::set($key, (string)$val);
        }

        return redirect()->route('admin.dashboard', ['tab' => 'settings', 'subtab' => $subTab])->with('success', 'All website content & visual sections updated successfully!');
    }

    // ==========================================
    // Hero Slides Actions
    // ==========================================
    public function storeHeroSlide(Request $request)
    {
        $validated = $request->validate([
            'badge' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'duration' => 'nullable|string|max:100',
            'highlight' => 'nullable|string|max:100',
            'bg_image' => 'nullable|string',
            'bg_image_file' => 'nullable|image|max:10240',
            'btn1_text' => 'nullable|string|max:100',
            'btn1_link' => 'nullable|string|max:255',
            'btn2_text' => 'nullable|string|max:100',
            'btn2_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('bg_image_file')) {
            $file = $request->file('bg_image_file');
            $filename = 'hero_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/hero'), $filename);
            $validated['bg_image'] = '/uploads/hero/' . $filename;
        }

        $validated['bg_image'] = $validated['bg_image'] ?: 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?q=80&w=1600&auto=format&fit=crop';
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? (HeroSlide::max('order') + 1);

        HeroSlide::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'settings', 'subtab' => 'home'])->with('success', 'New Hero Slide created successfully!');
    }

    public function updateHeroSlide(Request $request, $id)
    {
        $slide = HeroSlide::findOrFail($id);

        $validated = $request->validate([
            'badge' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'duration' => 'nullable|string|max:100',
            'highlight' => 'nullable|string|max:100',
            'bg_image' => 'nullable|string',
            'bg_image_file' => 'nullable|image|max:10240',
            'btn1_text' => 'nullable|string|max:100',
            'btn1_link' => 'nullable|string|max:255',
            'btn2_text' => 'nullable|string|max:100',
            'btn2_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('bg_image_file')) {
            $file = $request->file('bg_image_file');
            $filename = 'hero_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/hero'), $filename);
            $validated['bg_image'] = '/uploads/hero/' . $filename;
        } elseif (empty($validated['bg_image'])) {
            $validated['bg_image'] = $slide->bg_image;
        }

        $validated['is_active'] = $request->has('is_active');
        $slide->update($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'settings', 'subtab' => 'home'])->with('success', 'Hero Slide updated successfully!');
    }

    public function deleteHeroSlide($id)
    {
        HeroSlide::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'settings', 'subtab' => 'home'])->with('success', 'Hero Slide deleted successfully!');
    }
}
