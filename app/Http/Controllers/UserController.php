<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class UserController extends Controller
{
    /**
     * Display the form to create a new user.
     */
    public function create()
    {
        return view('admin.create-user'); // Ensure this view exists in resources/views/admin/
    }

    /**
     * Get all employees.
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Get a single employee.
     */
    public function show($id)
    {
        $user = User::find($id);

        abort_if(!$user, 404, 'User not found');

        return response()->json($user, 200);
    }

    /**
     * Store a new employee.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed', // Ensuring password confirmation
                'is_admin' => 'required|boolean',
            ]);

            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            // Return response based on request type (API or Web)
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'User created successfully',
                    'user' => $user
                ], 201);
            }

            return redirect()->route('admin.dashboard')->with('success', 'User added successfully!');
        } catch (ValidationException $e) {
            // Return JSON for API requests
            if ($request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            // Redirect back with errors for Web requests
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'An error occurred'], 500);
            }

            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    /**
     * Update an employee.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
                'password' => 'sometimes|min:6|confirmed', // Ensuring password confirmation in updates too
                'is_admin' => 'sometimes|required|boolean',
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'User updated successfully',
                    'user' => $user
                ], 200);
            }

            return redirect()->route('admin.dashboard')->with('success', 'User updated successfully!');
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'An error occurred'], 500);
            }

            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    /**
     * Delete an employee.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            if (request()->wantsJson()) {
                return response()->json(['message' => 'User deleted successfully'], 200);
            }

            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully!');
        } catch (Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'An error occurred'], 500);
            }

            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }
}
