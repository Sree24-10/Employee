<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background: #1f2937; /* Dark Grayish */
            color: white;
            padding: 15px 20px;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .btn {
            transition: 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        tbody tr:nth-child(odd) {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar flex justify-between items-center shadow-md">
        <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn px-5 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 shadow-sm">
                Logout
            </button>
        </form>
    </nav>

    <div class="p-8">
        <!-- Buttons Section -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-700">User Management</h2>
            <div>
                <a href="{{ route('users.create') }}" class="btn px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 shadow-md">
                    Add User
                </a>
                <a href="{{ route('employee.summary') }}" class="btn px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 ml-3 shadow-md">
                    View Employee Summary
                </a>
            </div>
        </div>

        <!-- User Table -->
        <div class="card">
            <table class="w-full text-gray-700">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">Role</th>
                        <th class="py-3 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-300">
                            <td class="py-3 px-6">{{ $user->id }}</td>
                            <td class="py-3 px-6 font-medium">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6">
                                @if($user->is_admin)
                                    <span class="px-3 py-1 text-xs font-medium text-white bg-red-500 rounded-md shadow-md">Admin</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium bg-gray-300 rounded-md shadow-md">User</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 flex space-x-2">
                                @if(!$user->is_admin)
                                    <a href="{{ route('assign.manager.form', $user->id) }}" 
                                       class="btn px-3 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 shadow-sm">
                                        Assign Manager
                                    </a>
                                @endif
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 shadow-sm">
                                        Delete
                                    </button>
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
