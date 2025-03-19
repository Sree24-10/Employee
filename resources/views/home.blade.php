<?php
// home.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Performance Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <style>
        .navbar-title {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-gray-900 shadow-md p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white navbar-title">Employee Performance Tracker</h1>
            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">
                Login
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex flex-col items-center justify-center min-h-screen text-center p-6">
        <h1 class="text-5xl font-bold text-gray-900">Track & Improve Employee Performance</h1>
        <p class="text-gray-600 mt-3 text-lg max-w-2xl">
            Monitor and enhance productivity with real-time insights and analytics.
        </p>
        <img src='images/home1.png'
         alt="Performance Dashboard" class="mt-6 w-full max-w-3xl rounded-lg shadow-md">
    </section>

</body>
</html>
