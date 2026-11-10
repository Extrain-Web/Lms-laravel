<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\StudentResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('student.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginInput = trim($request->input('login_id', $request->input('email', '')));
        $password = $request->input('password', '');
        $remember = $request->boolean('remember');

        if (empty($loginInput) || empty($password)) {
            return back()->withInput()->withErrors([
                'login_id' => 'Please provide your email / student roll and password.',
            ]);
        }

        // Check if input is email or student_roll
        $user = null;
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $loginInput)->first();
        } else {
            $user = User::where('student_roll', $loginInput)->first();
        }

        // Fallback search if not found
        if (!$user) {
            $user = User::where('email', $loginInput)->orWhere('student_roll', $loginInput)->first();
        }

        // Provision a student account on first login for already-published results or approved admissions
        if (!$user && in_array($password, ['student123', 'password123'], true)) {
            $matchedResult = StudentResult::where('roll_no', $loginInput)->orWhere('reg_no', $loginInput)->first();
            $matchedAdmission = !$matchedResult
                ? Admission::where('status', 'Approved')
                    ->where(function ($q) use ($loginInput) {
                        $q->where('assigned_roll', $loginInput)->orWhere('email', $loginInput);
                    })->first()
                : null;

            $provisionRoll = $matchedResult->roll_no ?? $matchedAdmission->assigned_roll ?? null;
            $provisionName = $matchedResult->student_name ?? $matchedAdmission->full_name ?? null;

            if (!empty($provisionRoll) && !empty($provisionName)) {
                $user = User::provisionStudentAccount(
                    $provisionRoll,
                    $provisionName,
                    $matchedAdmission->email ?? null,
                    $matchedAdmission->phone ?? null
                );
            }
        }

        if ($user) {
            // Check password - support password123, admin123, student123 or hashed check
            $valid = \Illuminate\Support\Facades\Hash::check($password, $user->password) 
                || ($user->isAdmin() && in_array($password, ['admin123', 'password123']))
                || ($user->isStudent() && in_array($password, ['student123', 'password123']));

            if ($valid) {
                Auth::login($user, $remember);
                $request->session()->regenerate();

                if ($user->isAdmin()) {
                    return redirect()->intended(route('admin.dashboard'));
                }
                return redirect()->intended(route('student.dashboard'));
            }
        }

        return back()->withInput()->withErrors([
            'login_id' => 'Invalid credentials. Please verify your Student Roll/Email and password.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
