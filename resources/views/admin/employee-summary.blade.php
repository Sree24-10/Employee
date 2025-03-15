<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar with Back Arrow -->
    <nav class="bg-gray-800 text-white p-4 flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-medium hover:text-gray-300 transition">
            &#8592;
        </a>
        <h1 class="text-xl font-semibold flex-1 text-center">Employee Summary</h1>
        <div class="w-6"></div> <!-- Empty space for layout balance -->
    </nav>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 border">Employee Name</th>
                        <th class="py-2 px-4 border">Total Ratings</th>
                        <th class="py-2 px-4 border">Poor (%)</th>
                        <th class="py-2 px-4 border">Good (%)</th>
                        <th class="py-2 px-4 border">Satisfactory (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summary as $employee)
                        <tr class="text-gray-700">
                            <td class="py-2 px-4 border">{{ $employee['name'] }}</td>
                            <td class="py-2 px-4 border">{{ $employee['totalRatings'] }}</td>
                            <td class="py-2 px-4 border">{{ $employee['poorPercentage'] }}%</td>
                            <td class="py-2 px-4 border">{{ $employee['goodPercentage'] }}%</td>
                            <td class="py-2 px-4 border">{{ $employee['satisfactoryPercentage'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
