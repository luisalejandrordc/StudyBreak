<?php
session_start();

// If user is already logged in, send to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StudyBreak</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h1>🎮 StudyBreak</h1>

    <p>Relax, play, and track your progress!</p>

    <div class="buttons">
        <a href="login.php" class="btn">Login</a>
        <a href="signup.php" class="btn btn-secondary">Sign Up</a>
    </div>

</div>

</body>
</html>
