<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeManagerController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\EmployeeSummaryController;

// Homepage
Route::get('/', function () {
    Log::info('Homepage visited', ['ip' => request()->ip()]);
    return view('home');
});

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Dashboard (Protected Route)
Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Admin Dashboard (Protected Route)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// User Management
Route::resource('users', UserController::class);
Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/admin/users/store', [UserController::class, 'store'])->name('users.store');
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Assign Manager Routes
Route::get('/assign-manager/{employee_id}', [EmployeeManagerController::class, 'showAssignForm'])->name('assign.manager.form');
Route::post('/assign-manager', [EmployeeManagerController::class, 'storeAssignment'])->name('store.manager');
Route::delete('/remove-manager/{employee}/{manager}', [EmployeeManagerController::class, 'removeManager'])->name('remove.manager');

// Rating Routes
Route::post('/rate-employee', [RatingController::class, 'store'])->name('rate.employee');
Route::get('/ratings/history', [RatingController::class, 'getMonthlyRatings'])->name('ratings.history');
 // Employees can view past ratings
Route::get('/ratings/manage', [RatingController::class, 'managePastRatings'])->name('ratings.manage'); // Managers can edit past ratings
Route::post('/ratings/{id}/update', [RatingController::class, 'updatePastRating'])->name('ratings.update'); // Route to update past ratings
Route::get('/ratings/past', [UserDashboardController::class, 'viewPastRatings'])->name('past.ratings');
Route::get('/ratings/given', [RatingController::class, 'givenRatings'])->name('ratings.given');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/employee-summary', [EmployeeSummaryController::class, 'index'])->name('employee.summary');
});
