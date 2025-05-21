<!DOCTYPE html>
<html>
<head>
    <title>New Match</title>
    <style>
        .container { font-family: Arial, sans-serif; text-align: center; }
        .button { background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>New Match!</h1>
        <p>You have a new match with {{ $match->matchedUser->name }}!</p>
        <a href="{{ url('/matches/' . $match->id) }}" class="button">View Match</a>
    </div>
</body>
</html>