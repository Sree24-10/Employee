<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Ratings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Past Ratings</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Employee ID</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ratings as $rating)
                <tr>
                    <form action="{{ route('ratings.update', $rating->id) }}" method="POST">
                        @csrf
                        <td>
                            <input type="date" name="date" value="{{ $rating->date }}" class="form-control" required>
                        </td>
                        <td>{{ $rating->employee_id }}</td>
                        <td>
                            <select name="rating" class="form-control" required>
                                <option value="Poor" {{ $rating->rating == 'Poor' ? 'selected' : '' }}>Poor</option>
                                <option value="Good" {{ $rating->rating == 'Good' ? 'selected' : '' }}>Good</option>
                                <option value="Satisfactory" {{ $rating->rating == 'Satisfactory' ? 'selected' : '' }}>Satisfactory</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </td>
                    </form>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
