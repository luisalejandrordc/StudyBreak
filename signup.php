<?php
require_once "config/db.php";

$errors = [];

function isAtLeast12($birthdate) {
    if (empty($birthdate)) {
        return false;
    }

    try {
        $birthDate = new DateTime($birthdate);
        $today = new DateTime();

        $birthDate->modify('+12 years');

        return $today >= $birthDate;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $birthdate  = $_POST["birthdate"];
    $gender  = $_POST["gender"];
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];

    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (!isAtLeast12($birthdate)) {
        $errors[] = "You have to be at least 12 years old to create an account.";
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=? OR username=?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Username or Email already exists.";
    }

    $stmt->close();

    // If no errors → insert
    if (empty($errors)) {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (username, email, gender, birthdate, password) VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param("sssss", $username, $email, $gender, $birthdate, $hashed);

        if ($stmt->execute()) {
            header("Location: login.php?signup=success");
            exit();
        } else {
            $errors[] = "Registration failed.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">

        <h1>Create Account</h1>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $e): ?>
                    <p><?= $e ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <input type="text" name="username" placeholder="Username" required>

            <input type="email" name="email" placeholder="Email" required>

            <input type="date" name="birthdate" required>

            <div class="flex-container">
                <b>Gender:</b>
                <div class="radio-container"><input type="radio" name="gender" value="M" required> Male</div>

                <div class="radio-container"><input type="radio" name="gender" value="F"> Female</div>
            </div>

            <input type="password" name="password" placeholder="Password" required>

            <input type="password" name="confirm" placeholder="Confirm Password" required>

            <button type="submit" class="btn">Sign Up</button>

        </form>

        <p style="margin-top:15px;">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>

</body>

</html>