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
    <title>Memory Game</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        .board {
            display: grid;
            grid-template-columns: repeat(4, 70px);
            gap: 12px;
            justify-content: center;
            margin: 20px 0;
        }

        .card {
            width: 70px;
            height: 70px;
            background: #667eea;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            color: white;
            cursor: pointer;
            user-select: none;
        }

        .card.flipped {
            background: white;
            color: #333;
            cursor: default;
        }

        .card.matched {
            background: #4CAF50;
            color: white;
            cursor: default;
        }

        .info {
            margin: 10px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>🧩 Memory Cards</h2>

    <p>Match all pairs as fast as possible!</p>

    <div class="info">
        Time: <span id="time">0</span>s
    </div>

    <div id="board" class="board"></div>

    <div id="result" class="result"></div>

    <br>

    <a href="../dashboard.php" class="btn btn-secondary">⬅ Back</a>

</div>

<script src="../js/game2.js"></script>

</body>
</html>
