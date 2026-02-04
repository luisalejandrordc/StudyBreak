<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Focus Click Challenge</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        .game-area {
            width: 100%;
            height: 300px;
            background: #f5f5f5;
            border-radius: 10px;
            position: relative;
            margin: 20px auto;
            border: 2px solid #ccc;
        }

        .target {
            width: 40px;
            height: 40px;
            background: #e74c3c;
            border-radius: 50%;
            position: absolute;
            cursor: pointer;
        }

        .info {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>🎵 Focus Click Challenge</h2>

    <p>Click as many targets as you can in 30 seconds!</p>

    <div class="info">
        <span>Time: <span id="time">30</span>s</span>
        <span>Score: <span id="score">0</span></span>
    </div>

    <div id="area" class="game-area"></div>

    <div id="result" class="result"></div>

    <br>

    <a href="../dashboard.php" class="btn btn-secondary">⬅ Back</a>

</div>

<script src="../js/game4.js"></script>

</body>
</html>
