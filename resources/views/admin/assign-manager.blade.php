<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Assign Manager to {{ $employee->name }}</h2>
        <form action="{{ route('store.manager') }}" method="POST">
    @csrf
    <input type="hidden" name="employee_id" value="{{ $employee->id }}">

    <label class="block text-gray-600">Select Manager:</label>
    <select name="manager_id" class="w-full p-2 border rounded mb-4">
        @foreach ($managers as $manager)
            <option value="{{ $manager->id }}">{{ $manager->name }}</option>
        @endforeach
    </select>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Assign</button>
</form>

    </div>
</body>
</html>
