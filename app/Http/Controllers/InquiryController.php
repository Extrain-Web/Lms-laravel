<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'inquiry_type' => 'required|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        Inquiry::create($validated);

        return back()->with('success', 'Thank you! Your inquiry has been submitted successfully.');
    }
}