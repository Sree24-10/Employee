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
    </style>
</head>
<body class="bg-gray-100">

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
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
            <h1 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Add New User</h1>

            <!-- Success Message -->
            @if(session('success'))
                <p class="text-green-600 mb-4 text-center">{{ session('success') }}</p>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <label class="block mb-2 font-medium">Name:</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="border p-2 w-full mb-4 rounded-md focus:ring focus:ring-blue-300">

                <label class="block mb-2 font-medium">Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="border p-2 w-full mb-4 rounded-md focus:ring focus:ring-blue-300">

                <label class="block mb-2 font-medium">Password:</label>
                <input type="password" name="password" required
                    class="border p-2 w-full mb-4 rounded-md focus:ring focus:ring-blue-300">

                <label class="block mb-2 font-medium">Confirm Password:</label>
                <input type="password" name="password_confirmation" required
                    class="border p-2 w-full mb-4 rounded-md focus:ring focus:ring-blue-300">

                <label class="block mb-2 font-medium">Role:</label>
                <select name="is_admin" required
                    class="border p-2 w-full mb-4 rounded-md focus:ring focus:ring-blue-300">
                    <option value="0" {{ old('is_admin') == '0' ? 'selected' : '' }}>User</option>
                    <option value="1" {{ old('is_admin') == '1' ? 'selected' : '' }}>Admin</option>
                </select>

                <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                    Add User
                </button>
            </form>
        </div>
    </div>

</body>
</html>
