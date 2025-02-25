<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



Route::get('/', function () {
    Log::info('Homepage visited', ['ip' => request()->ip()]);
    return view('home');
});


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/dashboard', function () {
    Log::info('Dashboard accessed', ['user_id' => Auth::id(), 'ip' => request()->ip()]);
    return view('dashboard');
})->middleware('auth')->name('dashboard');
