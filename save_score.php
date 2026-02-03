<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION["user_id"])) {
    exit("Not logged in");
}

$user_id = $_SESSION["user_id"];

$game  = $_POST["game"] ?? "";
$score = intval($_POST["score"] ?? 0);

if (!$game || $score <= 0) {
    exit("Invalid data");
}


// Check if record exists
$stmt = $conn->prepare(
    "SELECT id FROM game_stats WHERE user_id=? AND game_name=?"
);

$stmt->bind_param("is", $user_id, $game);
$stmt->execute();
$stmt->store_result();


if ($stmt->num_rows > 0) {

    // Update best score
    $stmt->close();

    $stmt = $conn->prepare(
        "UPDATE game_stats
         SET score = LEAST(score, ?),
             time_played = time_played + 1,
             last_played = NOW()
         WHERE user_id=? AND game_name=?"
    );

    $stmt->bind_param("iis", $score, $user_id, $game);

} else {

    $stmt->close();

    $stmt = $conn->prepare(
        "INSERT INTO game_stats (user_id, game_name, score, time_played)
         VALUES (?, ?, ?, 1)"
    );

    $stmt->bind_param("isi", $user_id, $game, $score);
}


$stmt->execute();
$stmt->close();

echo "OK";
