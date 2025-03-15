<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Matching Assign Manager Page */
        .navbar {
            background: linear-gradient(90deg, #2c3e50, #34495e); /* Dark gradient */
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Card Styling */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            margin: auto;
        }

        /* Back Arrow Button */
        .back-button {
            color: white;
            font-size: 24px;
            transition: 0.3s;
        }
        .back-button:hover {
            color: #cbd5e1;
        }
    </style>
</head>
<body>

    <!-- Navbar with Arrow Button -->
    <!-- Navbar -->
<nav class="w-full bg-gray-800 text-white py-4 px-6 flex items-center shadow-lg">
    <!-- Back Button -->
    <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-medium hover:text-gray-300 transition">
        &#8592;
    </a>

    <!-- Page Title -->
    <h1 class="text-xl font-semibold flex-1 text-center">Add User</h1>

    <!-- Empty space for layout balance -->
    <div class="w-6"></div>
</nav>


    <!-- Form Card -->
    <div class="mt-10 flex justify-center">
        <div class="card">
            <h1 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Add New User</h1>

            @if(session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <label class="block mb-2 font-medium">Name:</label>
                <input type="text" name="name" required class="border p-2 w-full mb-4 rounded-md focus:ring focus:ring-blue-300">

                <label class="block mb-2 font-medium">Email:</label>
                <input type="email" name="email" required class="border p-2 w-full mb-4 rounded-md focus:ring focus:ring-blue-300">

                <label class="block mb-2 font-medium">Password:</label>
                <input type="password" name="password" required class="border p-2 w-full mb-4 rounded-md focus:ring focus:ring-blue-300">

                <label class="block mb-2 font-medium">Role:</label>
                <select name="is_admin" class="border p-2 w-full mb-4 rounded-md focus:ring focus:ring-blue-300">
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>

                <button type="submit" class="btn w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Add User
                </button>
            </form>
        </div>
    </div>

</body>
</html>
