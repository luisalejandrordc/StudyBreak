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
    <title>Typing Speed Test</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        .text-box {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        textarea {
            width: 100%;
            height: 120px;
            resize: none;
            padding: 10px;
            font-size: 15px;
        }

        .stats {
            margin: 10px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>⌨️ Typing Speed Test</h2>

    <p>Type the text as fast and accurately as possible!</p>

    <div id="text" class="text-box"></div>

    <textarea id="input" placeholder="Start typing here..." disabled></textarea>

    <div class="stats">
        Time: <span id="time">0</span>s |
        WPM: <span id="wpm">0</span>
    </div>

    <div id="result" class="result"></div>

    <br>

    <a href="../dashboard.php" class="btn btn-secondary">⬅ Back</a>

</div>

<script src="../js/game3.js"></script>

</body>
</html>
