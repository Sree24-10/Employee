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
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
            
            <!-- Managers Section (Visible to all users) -->
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

            <!-- Employees Section (Only visible to managers) -->
            @if (!$employees->isEmpty())  
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Your Employees</h3>
                    <div class="bg-gray-50 p-4 rounded-md shadow-sm mt-2">
                        <ul class="text-gray-700 space-y-1">
                            @foreach ($employees as $employee)
                                <li class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span> {{ $employee->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </div>

</body>
</html>
