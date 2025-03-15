<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rating;
use Carbon\Carbon;

class EmployeeSummaryController extends Controller
{
    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
        $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

        $employees = User::where('is_admin', '0')->get();
        $ratings = Rating::whereBetween('date', [$startOfWeek . ' 00:00:00', $endOfWeek . ' 23:59:59'])->get();

        // Debugging: Check if employees exist
        if ($employees->isEmpty()) {
            return dd("No employees found!");
        }

        // Debugging: Check if ratings exist
        if ($ratings->isEmpty()) {
            return dd("No ratings found for this week!", [
                'startOfWeek' => $startOfWeek,
                'endOfWeek' => $endOfWeek,
                'ratings_found' => $ratings
            ]);
        }

        $summary = [];

        foreach ($employees as $employee) {
            $totalRatings = $ratings->where('employee_id', $employee->id)->count();
            $poorCount = $ratings->where('employee_id', $employee->id)->where('rating', 'Poor')->count();
            $goodCount = $ratings->where('employee_id', $employee->id)->where('rating', 'Good')->count();
            $satisfactoryCount = $ratings->where('employee_id', $employee->id)->where('rating', 'Satisfactory')->count();

            $summary[] = [
                'name' => $employee->name,
                'totalRatings' => $totalRatings,
                'poorPercentage' => $totalRatings > 0 ? round(($poorCount / $totalRatings) * 100, 2) : 0,
                'goodPercentage' => $totalRatings > 0 ? round(($goodCount / $totalRatings) * 100, 2) : 0,
                'satisfactoryPercentage' => $totalRatings > 0 ? round(($satisfactoryCount / $totalRatings) * 100, 2) : 0,
            ];
        }

        // Debugging: Ensure employees with ratings exist
        $employeeIdsWithRatings = $ratings->pluck('employee_id')->unique();
        $employeesWithRatings = User::whereIn('id', $employeeIdsWithRatings)->get();

        if ($employeesWithRatings->isEmpty()) {
            return dd("Employees exist, but none have ratings for this week!", [
                'startOfWeek' => $startOfWeek,
                'endOfWeek' => $endOfWeek,
                'ratings_found' => $ratings,
                'employees_found' => $employees
            ]);
        }

        return view('admin.employee-summary', compact('summary'));
    }
}
