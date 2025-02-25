<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Register</h2>

        <!-- ✅ Success Message -->
        @if(session('success'))
            <p class="text-green-500 text-center">{{ session('success') }}</p>
        @endif

        <!-- ❌ Error Messages -->
        @if ($errors->any())
            <ul class="text-red-500 text-center">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('register') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
                <p class="text-sm text-gray-500 mt-1"> Minimum 6 characters required</p> 
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Register</button>
        </form>

        <p class="text-center text-gray-600 mt-4">Already have an account? 
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>
</body>
</html>
