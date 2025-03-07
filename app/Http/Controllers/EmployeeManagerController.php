<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmployeeManagerController extends Controller
{
    // Show Assign Manager Form
    public function showAssignForm($employee_id)
{
    $employee = User::findOrFail($employee_id);

    // Fetch all users who are NOT admins and NOT the selected employee
    $managers = User::where('is_admin', '0') // Exclude Admins
                    ->where('id', '!=', $employee_id) // Exclude the employee themselves
                    ->get(); 

    return view('admin.assign-manager', compact('employee', 'managers'));
}


    // Store Manager Assignment
    public function storeAssignment(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:users,id',
        'manager_id' => 'required|exists:users,id',
    ]);

    // Insert into the employee_manager table
    DB::table('employee_manager')->insert([
        'employee_id' => $request->employee_id,
        'manager_id' => $request->manager_id
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Manager assigned successfully.');
}

public function adminDashboard()
{
    $users = User::with('managers')->get(); // Load managers for each user

    return view('admin.dashboard', compact('users'));
}


}

