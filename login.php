<?php
session_start();
require_once "config/db.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {

        $stmt = $conn->prepare(
            "SELECT id, username, password FROM users WHERE email=?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                // Login success
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];

                header("Location: dashboard.php");
                exit();

            } else {
                $errors[] = "Invalid email or password.";
            }

        } else {
            $errors[] = "Invalid email or password.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h1>Login</h1>

    <?php if (isset($_GET["signup"])): ?>
        <p style="color:green;">Account created! Please login.</p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $e): ?>
                <p><?= $e ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn">Login</button>

    </form>

    <p style="margin-top:15px;">
        No account?
        <a href="signup.php">Sign Up</a>
    </p>

</div>

</body>
</html>
