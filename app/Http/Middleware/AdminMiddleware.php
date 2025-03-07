<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // ✅ Import Auth

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and is an admin
        if (!Auth::check() || Auth::user()->is_admin != 1) { // ✅ Strict comparison
            return redirect('/dashboard')->with('error', 'Access Denied.');
        }

        return $next($request);
    }
}
