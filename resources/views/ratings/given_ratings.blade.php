<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratings Given</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="container mt-4">
        <h2 class="text-center mb-4">Ratings Given</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Employee</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ratings as $rating)
                <tr>
                    <td>{{ $rating->date }}</td>
                    <td>{{ $rating->employee_name }}</td>
                    <td>
                        @if($rating->rating == 'Good')
                            <span class="badge bg-success">{{ $rating->rating }}</span>
                        @elseif($rating->rating == 'Satisfactory')
                            <span class="badge bg-warning text-dark">{{ $rating->rating }}</span>
                        @else
                            <span class="badge bg-danger">{{ $rating->rating }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No ratings given yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

</body>
</html>
