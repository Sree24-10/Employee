<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rating History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>My Rating History</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Manager</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ratings as $rating)
                <tr>
                    <td>{{ $rating->date }}</td>
                    <td>{{ $rating->manager->name }}</td>
                    <td>{{ $rating->rating }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
