<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Course;
use App\Models\Resource;
use App\Models\SiteSetting;
use App\Models\StudentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentPortalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please sign in to access your Student Portal.');
        }

        $activeTab = $request->query('tab', 'courses');
        $allowedTabs = ['courses', 'marksheet', 'exams', 'idcard'];
        if (!in_array($activeTab, $allowedTabs, true)) {
            $activeTab = 'courses';
        }

        // Resolve the authentic student result & admission records
        $studentResult = null;
        $admission = null;

        if ($user->isAdmin()) {
            // Allow admins to preview a specific roll or the latest published student record
            $previewRoll = $request->query('roll');
            $studentResult = $previewRoll
                ? StudentResult::where('roll_no', $previewRoll)->first()
                : StudentResult::latest()->first();
            $rollNo = $studentResult->roll_no ?? $previewRoll;
        } else {
            $rollNo = $user->student_roll;
            if (!empty($rollNo)) {
                $studentResult = StudentResult::where('roll_no', $rollNo)->first();
            }
            $admission = Admission::query()
                ->when(!empty($rollNo), fn ($q) => $q->where('assigned_roll', $rollNo))
                ->when(!empty($user->email), fn ($q) => $q->orWhere('email', $user->email))
                ->latest()
                ->first();
        }

        $studentName = $studentResult->student_name
            ?? $admission->full_name
            ?? $user->name;

        $displayRoll = $studentResult->roll_no
            ?? $admission->assigned_roll
            ?? $user->student_roll
            ?? null;

        $tradeName = $studentResult->trade
            ?? $admission->trade
            ?? null;

        // Match the enrolled Course record in DB for real duration, curriculum, and certification
        $enrolledCourse = null;
        if (!empty($tradeName)) {
            $enrolledCourse = Course::where('title', $tradeName)->first()
                ?? Course::where('title', 'like', '%' . $tradeName . '%')->first();
        }

        // Fallback list of all available courses if student is not yet matched to a specific trade
        $availableCourses = Course::latest()->take(4)->get();
        $resources = Resource::latest()->take(12)->get();

        // Compute dynamic subject totals when Subject-Wise Marks exist
        $marksList = ($studentResult && is_array($studentResult->marks)) ? $studentResult->marks : [];
        $marksSummary = null;
        if (!empty($marksList)) {
            $totalFull = 0;
            $totalObtained = 0;
            foreach ($marksList as $m) {
                $totalFull += (int) ($m['fullMarks'] ?? 100);
                $totalObtained += (int) ($m['obtained'] ?? $m['obtainedMarks'] ?? 0);
            }
            $percentage = $totalFull > 0 ? round(($totalObtained / $totalFull) * 100, 2) : 0;
            $marksSummary = [
                'full' => $totalFull,
                'obtained' => $totalObtained,
                'percentage' => $percentage,
            ];
        }

        $userInitials = strtoupper(Str::substr(preg_replace('/\s+/', '', $studentName ?: 'ST'), 0, 2));

        $settings = [
            'instituteName' => SiteSetting::get('instituteName', 'Saikat Computer & Training Jubo Songhoton'),
            'helplinePhone' => SiteSetting::get('helplinePhone', '+880 1712-345678'),
            'helplineEmail' => SiteSetting::get('helplineEmail', 'support@jubounnayon.com'),
            'headquartersAddress' => SiteSetting::get('headquartersAddress', 'Youth Bhaban Complex, Mirpur-2, Dhaka-1216, Bangladesh'),
            'headerLogoImage' => SiteSetting::get('headerLogoImage', ''),
            'headerLogoText' => SiteSetting::get('headerLogoText', 'NYD'),
            'footerBrandTitle' => SiteSetting::get('footerBrandTitle', 'National Youth Development Platform'),
            'footerAccreditationBadge' => SiteSetting::get('footerAccreditationBadge', 'Govt. Reg. Affiliated Technical Directorate'),
            'currentSession' => SiteSetting::get('currentSession', 'January - June 2026'),
        ];

        return view('student.dashboard', compact(
            'user',
            'activeTab',
            'studentResult',
            'admission',
            'studentName',
            'displayRoll',
            'tradeName',
            'enrolledCourse',
            'availableCourses',
            'resources',
            'marksList',
            'marksSummary',
            'userInitials',
            'settings'
        ));
    }
}
