<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; 

class AuthController extends Controller
{
    public function showRegister()
    {
        Log::info('Register page accessed', ['ip' => request()->ip()]);
        return view('auth.register');
    }

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
        ]);

        Log::info('New user registered', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip()
        ]);

        return redirect()->route('register')->with('success', 'Registered successfully. You can now login.');
    }

    public function showLogin()
    {
        Log::info('Login page accessed', ['ip' => request()->ip()]);
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            Log::info('User logged in successfully', [
                'user_id' => Auth::id(),
                'email' => $request->email,
                'ip' => $request->ip()
            ]);
            return redirect()->route('dashboard');
        }

        Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Log::info('User logged out', [
            'user_id' => Auth::id(),
            'ip' => request()->ip()
        ]);

        Auth::logout();
        return redirect()->route('login');
    }
}
