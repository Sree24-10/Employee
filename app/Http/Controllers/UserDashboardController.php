<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('dashboard', [
            'managers' => $user->managers()->get(),  // Assigned managers
            'employees' => $user->employees()->get(), // Employees assigned to this manager
        ]);
    }
}
