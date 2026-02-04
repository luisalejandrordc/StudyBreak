<?php
session_start();
require_once "config/db.php";

/*
 Games:
 reaction → lower is better
 memory   → lower is better
 typing   → higher is better
 focus    → higher is better
*/

$games = [
    "reaction" => "Reaction Game",
    "memory"   => "Memory Game",
    "typing"   => "Typing Game",
    "focus"    => "Focus Game"
];

$selected = $_GET["game"] ?? "reaction";

if (!array_key_exists($selected, $games)) {
    $selected = "reaction";
}


// Sorting logic
if ($selected === "reaction" || $selected === "memory") {
    $order = "gs.score ASC";   // Lower is better
} else {
    $order = "gs.score DESC";  // Higher is better
}


// Query leaderboard
$sql = "
SELECT 
    u.username,
    gs.score,
    gs.time_played,
    gs.last_played
FROM game_stats gs
JOIN users u ON gs.user_id = u.id
WHERE gs.game_name = ?
ORDER BY $order
LIMIT 10
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selected);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #667eea;
            color: white;
        }

        .tabs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .tabs a {
            flex: 1;
            text-align: center;
            padding: 8px;
            text-decoration: none;
            background: #eee;
            color: #333;
            margin: 10px 3px;
            border-radius: 4px;
        }

        .tabs a.active {
            background: #667eea;
            color: white;
        }
    </style>
</head>
<body>

<div class="container", style="width: auto;">

    <h1>🏆 Leaderboard</h1>

    <!-- Game Tabs -->
    <div class="tabs">

        <?php foreach ($games as $key => $name): ?>

            <a href="leaderboard.php?game=<?= $key ?>"
               class="<?= $selected === $key ? 'active' : '' ?>">

                <?= $name ?>

            </a>

        <?php endforeach; ?>

    </div>


    <!-- Ranking Table -->
    <table>

        <tr>
            <th>Rank</th>
            <th>Player</th>
            <th>Score</th>
            <th>Plays</th>
            <th>Last Played</th>
        </tr>

        <?php
        $rank = 1;

        if ($result->num_rows > 0):

            while ($row = $result->fetch_assoc()):
        ?>

        <tr>
            <td><?= $rank++ ?></td>
            <td><?= htmlspecialchars($row["username"]) ?></td>
            <td><?= $row["score"] ?></td>
            <td><?= $row["time_played"] ?></td>
            <td><?= date("Y-m-d", strtotime($row["last_played"])) ?></td>
        </tr>

        <?php
            endwhile;

        else:
        ?>

        <tr>
            <td colspan="5">No scores yet</td>
        </tr>

        <?php endif; ?>

    </table>

    <br>

    <a href="dashboard.php" class="btn btn-secondary">⬅ Back</a>

</div>

</body>
</html>

