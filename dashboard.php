<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">

        <h1>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?></h1>

        <p>Choose a game and relax!</p>

        <div class="games">
            <a href="games/game1.php" class="btn">🧠 Game 1</a>
            <a href="games/game2.php" class="btn">🎯 Game 2</a>
            <a href="games/game3.php" class="btn">⚡ Game 3</a>
            <a href="games/game4.php" class="btn">🎵 Game 4</a>

        </div>

        <br>

        <button><a href="logout.php" class="btn btn-secondary" style="font-size: 16px;">Logout</a></button>

    </div>

</body>

</html>