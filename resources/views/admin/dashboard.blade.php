<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <div>
        <form action="{{ route('logout') }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="px-4 py-2 bg-red-500 rounded-lg hover:bg-red-600">Logout</button>
</form>

        </div>
    </nav>

    <div class="p-6">
        <!-- Add User Button -->
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">User Management</h2>
            <a href="{{ route('users.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Add User</a>
        </div>

        <!-- User Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 border">ID</th>
                        <th class="py-2 px-4 border">Name</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">Role</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
    @foreach ($users as $user)
        <tr class="text-gray-700">
            <td class="py-2 px-4 border">{{ $user->id }}</td>
            <td class="py-2 px-4 border">{{ $user->name }}</td>
            <td class="py-2 px-4 border">{{ $user->email }}</td>
            <td class="py-2 px-4 border">
                @if($user->is_admin)
                    <span class="text-red-500 font-bold">Admin</span>
                @else
                    User
                @endif
            </td>
            <td class="py-2 px-4 border">
                <!-- Display Assigned Managers -->
                @if(!$user->is_admin)
                    <div class="mb-2">
                        <span class="font-semibold">Managers:</span>
                        @if ($user->managers->isEmpty())
                            <span class="text-gray-500">None</span>
                        @else
                            @foreach ($user->managers as $manager)
                                <span class="text-green-600">{{ $manager->name }}</span>{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        @endif
                    </div>

                    <!-- Assign Manager Button -->
                    <a href="{{ route('assign.manager.form', $user->id) }}" 
                       class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                        Assign Manager
                    </a>
                @endif

                <!-- Delete User Form -->
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>
    </div>
</body>
</html>
