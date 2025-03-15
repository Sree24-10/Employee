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

        // Get currently assigned manager IDs
        $assignedManagers = DB::table('employee_manager')
                              ->where('employee_id', $employee_id)
                              ->pluck('manager_id')
                              ->toArray();

        // Get currently assigned managers with details
        $currentManagers = User::whereIn('id', $assignedManagers)->get();

        // Get available managers (excluding already assigned ones)
        $managers = User::where('is_admin', '0')
                        ->where('id', '!=', $employee_id)
                        ->whereNotIn('id', $assignedManagers)
                        ->get();

        return view('admin.assign-manager', compact('employee', 'managers', 'currentManagers', 'assignedManagers'));
    }
    public function storeAssignment(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:users,id',
        'manager_id' => 'required|exists:users,id',
    ]);

    DB::table('employee_manager')->insert([
        'employee_id' => $request->employee_id,
        'manager_id' => $request->manager_id,
    ]);

    return redirect()->route('assign.manager.form', $request->employee_id)
        ->with('success', 'Manager assigned successfully.');
}


    // Store Assigned Manager
    public function storeManager(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'manager_id' => 'required|exists:users,id',
        ]);

        DB::table('employee_manager')->insert([
            'employee_id' => $request->employee_id,
            'manager_id'  => $request->manager_id
        ]);

        return redirect()->route('admin.assign-manager', $request->employee_id)->with('success', 'Manager assigned successfully.');
    }

    // Remove Assigned Manager
    public function removeManager($employee_id, $manager_id)
    {
        DB::table('employee_manager')
            ->where('employee_id', $employee_id)
            ->where('manager_id', $manager_id)
            ->delete();

        return redirect()->route('assign.manager.form', $employee_id)->with('success', 'Manager removed successfully.');
    }
}
