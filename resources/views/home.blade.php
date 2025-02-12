<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-bold text-gray-800">Welcome to Employee Performance Tracker</h1>
        <p class="text-gray-600 mt-2">Choose an option below:</p>
        <div class="mt-6">
            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-2 rounded-md mr-2 hover:bg-blue-600">Login</a>
            <a href="{{ route('register') }}" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600">Register</a>
        </div>
    </div>
</body>
</html>
