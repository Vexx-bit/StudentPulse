<?php
require 'includes/core.php';

$err = [];
$email = '';
$user = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'config/database.php';
    check();

    $user = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (strlen($user) < 3 || strlen($user) > 50) {
        $err[] = 'Username must be 3–50 characters.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err[] = 'Enter a valid email address.';
    }
    if (strlen($pass) < 8) {
        $err[] = 'Password must be at least 8 characters.';
    }
    if ($pass !== $confirm) {
        $err[] = 'Passwords do not match.';
    }

    if (empty($err)) {
        // Clean values for procedural mysqli query
        $user_clean = mysqli_real_escape_string($conn, $user);
        $email_clean = mysqli_real_escape_string($conn, $email);

        // Check if username or email already exists
        $check_sql = "SELECT id FROM users WHERE username = '$user_clean' OR email = '$email_clean'";
        $check_res = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_res) > 0) {
            $err[] = 'Username or email already exists.';
        } else {
            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
            $insert_sql = "INSERT INTO users (username, email, password_hash, role) VALUES ('$user_clean', '$email_clean', '$pass_hash', 'student')";

            if (mysqli_query($conn, $insert_sql)) {
                flash('Account created successfully. Please log in.');
                go('login.php');
            } else {
                $err[] = 'Database error: ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | StudentPulse</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main class="auth">
    <section class="auth-art">
        <span class="eyebrow">Your campus. Your moments.</span>
        <h1>Never miss what matters.</h1>
        <p>Discover workshops, sports, clubs and social events.</p>
    </section>
    <section class="auth-form">
        <div class="auth-box">
            <a class="brand" href="index.php"><b>SP</b> StudentPulse</a>
            <h2>Create Account</h2>

            <?php if (!empty($err)): ?>
                <div class="error"><?= implode('<br>', array_map('e', $err)) ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="csrf" value="<?= e(token()) ?>">
                <div class="field">
                    <label>Username</label>
                    <input name="username" maxlength="50" required value="<?= e($user) ?>">
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" required value="<?= e($email) ?>">
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" minlength="8" required>
                </div>
                <div class="field">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm" required>
                </div>
                <button class="btn" type="submit">Create account</button>
            </form>
            <p>Already registered? <a href="login.php">Back to login</a></p>
        </div>
    </section>
</main>
</body>
</html>