<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}!</h2>
        <p class="text-gray-600">You are now logged in.</p>
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600">Logout</button>
        </form>
    </div>
</body>
</html>
