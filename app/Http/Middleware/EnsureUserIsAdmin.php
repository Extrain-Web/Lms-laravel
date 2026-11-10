<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request. Only allow authenticated administrator users.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()
                ->route('login', ['role' => 'admin'])
                ->with('error', 'Please sign in as an Administrator to access the Control Center.');
        }

        if (!Auth::user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden. Administrator access required.'], 403);
            }

            return redirect()
                ->route('student.dashboard')
                ->with('error', 'Access denied: Administrator privileges are required.');
        }

        return $next($request);
    }
}
