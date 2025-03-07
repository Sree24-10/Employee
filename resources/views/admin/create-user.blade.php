<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New User</h1>

    @if(session('success'))
        <p class="text-green-600">{{ session('success') }}</p>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        <label class="block mb-2">Name:</label>
        <input type="text" name="name" required class="border p-2 w-full mb-4">

        <label class="block mb-2">Email:</label>
        <input type="email" name="email" required class="border p-2 w-full mb-4">

        <label class="block mb-2">Password:</label>
        <input type="password" name="password" required class="border p-2 w-full mb-4">

        <label class="block mb-2">Role:</label>
        <select name="is_admin" class="border p-2 w-full mb-4">
            <option value="0">User</option>
            <option value="1">Admin</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add User</button>
    </form>
</body>
</html>
