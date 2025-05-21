<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matches for {{ $user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Matches for {{ $user->name }}</h1>
        <p>Gender: {{ $user->gender }}, Age: {{ $user->age }}</p>
        
        <div class="mb-4">
            <form method="GET" action="{{ url('/matches') }}" class="row g-3">
                <div class="col-auto">
                    <label for="user_id" class="visually-hidden">User ID</label>
                    <input type="number" class="form-control" id="user_id" name="user_id" placeholder="User ID" value="{{ $user->id }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">View Matches</button>
                </div>
            </form>
        </div>
        
        <div class="row">
            @if($matches->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Compatibility Score</th>
                            <th>Processed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matches as $match)
                            <tr>
                                <td>{{ $match->potentialMatch->id }}</td>
                                <td>{{ $match->potentialMatch->name }}</td>
                                <td>{{ $match->potentialMatch->gender }}</td>
                                <td>{{ $match->potentialMatch->age }}</td>
                                <td>{{ $match->compatibility_score }}%</td>
                                <td>{{ $match->processed_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">
                    No matches found for this user. Try running the profile matching job first.
                </div>
            @endif
        </div>
    </div>
</body>
</html>