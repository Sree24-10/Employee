<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold">{{ auth()->user()->name }}'s Dashboard</h1> 
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 px-4 py-2 rounded-md hover:bg-red-600 transition">
                Logout
            </button>
        </form>
    </nav>

    <!-- Main Container -->
    <div class="flex justify-center mt-10">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">

            <!-- Managers Section -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Your Managers</h3>
                <div class="bg-gray-50 p-4 rounded-md shadow-sm mt-2">
                    @if ($managers->isEmpty())
                        <p class="text-gray-500">No assigned managers.</p>
                    @else
                        <ul class="text-gray-700 space-y-1">
                            @foreach ($managers as $manager)
                                <li class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span> {{ $manager->name }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Employee Ratings (For Employees to View Ratings Given by Their Managers) -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Your Ratings (Today's Ratings)</h3>
                <div class="bg-gray-50 p-4 rounded-md shadow-sm mt-2">
                    @if ($todaysRatings->isEmpty())
                        <p class="text-gray-500">No ratings available for today.</p>
                    @else
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="p-2 text-left">Date</th>
                                    <th class="p-2 text-left">Manager</th>
                                    <th class="p-2 text-left">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($todaysRatings as $rating)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $rating->date }}</td>
                                        <td class="p-2">{{ $rating->manager->name }}</td>
                                        <td class="p-2 font-semibold">
                                            @if ($rating->rating == 'Good')
                                                <span class="text-green-600">Good</span>
                                            @elseif ($rating->rating == 'Satisfactory')
                                                <span class="text-yellow-600">Satisfactory</span>
                                            @else
                                                <span class="text-red-600">Poor</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- View Past Ratings Button -->
                <div class="mt-4">
                    <a href="{{route('past.ratings') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        View Past Ratings
                    </a>
                </div>
            </div>

            <!-- Employees Section (For Managers to Rate Employees) -->
            @if (!$employees->isEmpty())  
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Rate Your Employees ({{ \Carbon\Carbon::now()->format('F Y') }})</h3>
                    <div class="bg-gray-50 p-4 rounded-md shadow-sm mt-2">
                        <form action="{{ route('rate.employee') }}" method="POST">
                            @csrf
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="p-2 text-left">Employee</th>
                                        <th class="p-2 text-left">Date</th>
                                        <th class="p-2 text-left">Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        @php
                                            // Get the latest rating for the current month
                                            $previousRating = $todaysRatings->where('employee_id', $employee->id)
                                                                            ->where('manager_id', auth()->id())
                                                                            ->sortByDesc('date')
                                                                            ->first();
                                            
                                            // Default to today's date if no rating for this month
                                            $ratingDate = $previousRating ? $previousRating->date : now()->format('Y-m-d');
                                        @endphp

                                        <tr class="border-b">
                                            <td class="p-2">{{ $employee->name }}</td>
                                            <td class="p-2">
                                                <input type="date" name="ratings[{{ $employee->id }}][date]" class="border rounded-md p-1"
                                                    value="{{ $ratingDate }}">
                                            </td>
                                            <td class="p-2">
                                                <div class="flex gap-4">
                                                    <label class="flex items-center">
                                                        <input type="radio" name="ratings[{{ $employee->id }}][rating]" value="Poor" 
                                                            {{ $previousRating && $previousRating->rating == 'Poor' ? 'checked' : '' }} required> 
                                                        <span class="ml-1">Poor</span>
                                                    </label>
                                                    <label class="flex items-center">
                                                        <input type="radio" name="ratings[{{ $employee->id }}][rating]" value="Good"
                                                            {{ $previousRating && $previousRating->rating == 'Good' ? 'checked' : '' }}> 
                                                        <span class="ml-1">Good</span>
                                                    </label>
                                                    <label class="flex items-center">
                                                        <input type="radio" name="ratings[{{ $employee->id }}][rating]" value="Satisfactory"
                                                            {{ $previousRating && $previousRating->rating == 'Satisfactory' ? 'checked' : '' }}> 
                                                        <span class="ml-1">Satisfactory</span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4 flex justify-between">
    <!-- Save Ratings Button (Left) -->
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
        Save Ratings
    </button>

    <!-- View Given Ratings Button (Right) -->
    <a href="{{ route('ratings.given') }}" 
       class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 text-center inline-block">
        View Given Ratings
    </a>
</div>

                            
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>

</body>
</html>
