<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Fetch managers assigned to the employee
        $managers = $user->managers;

        // Fetch employees if the user is a manager
        $employees = $user->employees;

        // Fetch ratings given to the authenticated employee
        $ratings = Rating::where('employee_id', $user->id)
            ->with('manager') // Ensure a relationship exists in the Rating model
            ->orderBy('date', 'desc')
            ->get();

        return view('dashboard', compact('managers', 'employees', 'ratings'));
    }

    public function storeRatings(Request $request)
    {
        $request->validate([
            'ratings' => 'required|array',
            'ratings.*.rating' => 'required|in:Poor,Good,Satisfactory',
            'ratings.*.date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->ratings as $employeeId => $ratingData) {
                Rating::updateOrCreate(
                    [
                        'date' => $ratingData['date'],
                        'employee_id' => $employeeId,
                        'manager_id' => auth()->id(),
                    ],
                    [
                        'rating' => $ratingData['rating'],
                    ]
                );
            }

            DB::commit();
            return redirect()->back()->with('success', 'Ratings saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
