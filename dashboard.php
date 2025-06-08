
<?php
session_start();

// Optional: Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marvel Universe Dashboard</title>
    <link rel="stylesheet" href="signin.css">
    <link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <img src="OIP (1).jpg" alt="Marvel Logo" height="40">
        </div>
        <ul class="navbar-links">
            <li><a href="index.html">Home</a></li>
        </ul>
    </nav>
    <div class="hero">
        <section class="signup-section">
            <div class="signin-form" style="text-align:center;">
                <h2>Welcome to the Marvel Universe Dashboard!</h2>
                <p style="font-size:1.2rem;">You are successfully logged in.</p>
                <a href="index.html" class="cta" style="display:inline-block;margin-top:1.5rem;">Go to Home Page</a>
            </div>
        </section>
    </div>
</body>
</html>