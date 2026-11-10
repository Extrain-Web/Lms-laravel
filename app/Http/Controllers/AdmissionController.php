<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Course;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function create(Request $request)
    {
        $courses = Course::all();
        $selectedTrade = $request->query('trade', '');
        return view('admissions.apply', compact('courses', 'selectedTrade'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'trade' => 'required|string',
            'district' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $admission = Admission::create($validated);

        return redirect()->route('admissions.apply')->with('success', 'Your admission application has been submitted successfully! Application Tracking ID: ADM-' . str_pad($admission->id, 5, '0', STR_PAD_LEFT) . '. Our admissions office will contact you soon.');
    }
}
