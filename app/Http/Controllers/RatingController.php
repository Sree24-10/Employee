<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'ratings' => 'required|array',
            'ratings.*.rating' => 'required|in:Poor,Good,Satisfactory',
            'ratings.*.date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction(); // Start transaction

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

            DB::commit(); // Commit transaction

            return redirect()->back()->with('success', 'Ratings saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on failure
            Log::error('Rating Store Error: ' . $e->getMessage()); // Log error for debugging

            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function getMonthlyRatings(Request $request)
{
    $user = auth()->user();
    $currentMonth = Carbon::now()->format('Y-m'); // Format: YYYY-MM

    // Check if user is an employee (fetch ratings they received)
    if ($user->role === 'employee') {
        $ratings = Rating::where('employee_id', $user->id)
            ->where('date', 'like', "$currentMonth%")
            ->with('manager') // Ensure manager relationship exists
            ->get();
    } else {
        // If user is a manager, fetch ratings they have given
        $ratings = Rating::where('manager_id', $user->id)
            ->where('date', 'like', "$currentMonth%")
            ->get();
    }

    return view('ratings.history', compact('ratings')); // Ensure correct view name
}



public function managePastRatings(Request $request)
{
    $managerId = auth()->id();

    $ratings = Rating::where('manager_id', $managerId)
        ->orderBy('date', 'desc')
        ->with('manager') // Load manager details
        ->get();

    return view('ratings.history', compact('ratings'));
}


    public function updatePastRating(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|in:Poor,Good,Satisfactory',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $rating = Rating::where('id', $id)->where('manager_id', auth()->id())->firstOrFail();
            $rating->update([
                'rating' => $request->rating,
                'date' => $request->date,
            ]);

            return redirect()->back()->with('success', 'Rating updated successfully!');
        } catch (\Exception $e) {
            Log::error('Update Past Rating Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function givenRatings()
{
    $managerId = auth()->id(); // Get logged-in manager ID

    $ratings = DB::table('ratings')
        ->where('manager_id', $managerId)
        ->join('users as employees', 'ratings.employee_id', '=', 'employees.id')
        ->select('ratings.*', 'employees.name as employee_name')
        ->orderBy('date', 'desc')
        ->get();

    return view('ratings.given_ratings', compact('ratings'));
}

}
