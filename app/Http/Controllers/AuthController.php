<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Show Login Page (For Website)
    public function showLogin()
    {
        return view('auth.login');
    }

    // Show Register Page (For Website)
    public function showRegister()
    {
        return view('auth.register');
    }

    // User Registration (Handles Both API & Web)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin') ? '1' : '0',
        ]);

        Log::info('New user registered', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip()
        ]);

        // Redirect after web registration
        if (!$request->expectsJson()) {
            return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
        }

        // API Response
        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user
        ], 201);
    }

    // User Login (Handles Both API & Web)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // API Login (JWT)
        if ($request->expectsJson()) {
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    Log::warning('Failed login attempt', [
                        'email' => $request->email,
                        'ip' => $request->ip()
                    ]);
                    return response()->json(['error' => 'Invalid credentials'], 401);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'Could not create token'], 500);
            }

            $user = Auth::user();
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ], 200);
        }

        // Web Login (Session-based)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'ip' => $request->ip()
            ]);

            // Redirect based on role
            return $user->is_admin
                ? redirect()->route('admin.dashboard')  // Redirect admin to admin dashboard
                : redirect()->route('dashboard');       // Redirect normal users to user dashboard
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    // Get Authenticated User (API Only)
    public function me(Request $request)
    {
        return response()->json(Auth::user());
    }

    // User Logout (Handles Both API & Web)
    public function logout(Request $request)
    {
        if ($request->expectsJson()) {
            try {
                JWTAuth::invalidate(JWTAuth::getToken());
                return response()->json(['message' => 'Logged out successfully'], 200);
            } catch (JWTException $e) {
                return response()->json(['error' => 'Failed to logout'], 500);
            }
        }

        // Session logout for website
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
