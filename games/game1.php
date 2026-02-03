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
    <title>Reaction Game</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        .game-box {
            width: 100%;
            height: 250px;
            background: #ccc;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            cursor: pointer;
            user-select: none;
        }

        .waiting {
            background: #999;
        }

        .ready {
            background: #4CAF50;
            color: white;
        }

        .too-soon {
            background: #e74c3c;
            color: white;
        }

        .result {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>⚡ Reaction Time Game</h2>

        <p>Wait for green, then click fast!</p>

        <div id="box" class="game-box waiting">
            Click to Start
        </div>

        <div class="result" id="result"></div>

        <br>

        <a href="../dashboard.php" class="btn btn-secondary">⬅ Back</a>

    </div>

    <script src="../js/game1.js"></script>

</body>

</html>