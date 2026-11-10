<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $settings = [
            'helplinePhone' => SiteSetting::get('helplinePhone', '+880 1712-345678'),
            'helplineEmail' => SiteSetting::get('helplineEmail', 'support@jubounnayon.com'),
            'instituteName' => SiteSetting::get('instituteName', 'Saikat Computer & Training Jubo Songhoton'),
        ];
        return view('contact.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'district' => 'nullable|string',
            'inquiry_type' => 'required|string',
            'message' => 'required|string',
        ]);

        ContactInquiry::create($validated);

        return back()->with('success', 'Your message has been sent successfully! We will contact you shortly.');
    }
}
