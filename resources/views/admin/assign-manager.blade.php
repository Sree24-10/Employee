<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center">

    <!-- Navbar -->
   <!-- Navbar -->
<!-- Navbar -->
<!-- Navbar with Back Arrow -->
<!-- Full-Width Navbar -->
<!-- Navbar -->
<nav class="w-full bg-gray-800 text-white py-4 px-6 flex items-center shadow-lg">
    <!-- Back Button -->
    <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-medium hover:text-gray-300 transition">
        &#8592;
    </a>

    <!-- Page Title -->
    <h1 class="text-xl font-semibold flex-1 text-center">Assign Manager</h1>

    <!-- Empty space for layout balance -->
    <div class="w-6"></div>
</nav>



    <!-- Main Content -->
    <div class="bg-white p-8 rounded-lg shadow-2xl mt-10 w-full max-w-lg">
        <h2 class="text-2xl font-extrabold text-gray-800 text-center mb-6">
            Manage Managers for <span class="text-blue-500">{{ $employee->name }}</span>
        </h2>

        <!-- List of Assigned Managers -->
        <div class="mb-6">
            <h4 class="text-gray-700 font-semibold mb-2">Current Managers:</h4>
            <ul class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-2">
                @forelse ($currentManagers as $manager)
                    <li class="flex justify-between items-center py-2 px-4 bg-white rounded-lg shadow-sm border">
                        <span class="text-gray-800 font-medium">{{ $manager->name }}</span>
                        <form action="{{ route('remove.manager', [$employee->id, $manager->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 text-sm rounded hover:bg-red-600 transition-all">
                                Remove
                            </button>
                        </form>
                    </li>
                @empty
                    <p class="text-gray-500 italic text-center">No managers assigned.</p>
                @endforelse
            </ul>
        </div>

        <!-- Assign New Manager -->
        <form action="{{ route('store.manager') }}" method="POST">
            @csrf
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">

            <label class="block text-gray-600 font-semibold mb-1">Assign New Manager:</label>
            <select name="manager_id" class="w-full p-3 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4">
                @foreach ($managers as $manager)
                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg font-semibold shadow-lg hover:bg-blue-600 transition-all">
                Assign Manager
            </button>
        </form>
    </div>

</body>
</html>
