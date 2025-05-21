<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Unique.Love</title>
    <style>
        .container { font-family: Arial, sans-serif; text-align: center; }
        .button { background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, {{ $user->name }}!</h1>
        <p>Thanks for joining Dating App. Start finding matches today!</p>
        <a href="{{ url('/matches') }}" class="button">Explore Matches</a>
    </div>
</body>
</html>