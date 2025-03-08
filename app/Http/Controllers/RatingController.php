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

        // Retrieve only ratings for the current month
        $ratings = Rating::where('manager_id', $user->id)
            ->where('date', 'like', "$currentMonth%")
            ->get();

        return view('dashboard', compact('ratings'));
    }
}
