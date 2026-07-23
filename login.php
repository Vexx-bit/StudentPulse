<?php
require 'includes/core.php';

$error = '';
$flashMessage = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

if (!empty($_SESSION['student_id'])) {
    go('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'config/database.php';
    check();

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Escape string input for procedural mysqli query
    $email_clean = mysqli_real_escape_string($conn, $email);

    // Simple procedural mysqli query
    $sql = "SELECT id, username, password_hash, role FROM users WHERE email = '$email_clean' AND role = 'student'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['student_id'] = (int) $user['id'];
            $_SESSION['student_username'] = $user['username'];
            $_SESSION['student_role'] = $user['role'];
            go('dashboard.php');
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Invalid student credentials. Admins must log in at /admin/login.php';
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login | StudentPulse</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <main class="auth">
        <section class="auth-art">
            <span class="eyebrow">Student Events Portal</span>
            <h1>Your campus is happening now.</h1>
            <p>Explore events, reserve your place and stay connected.</p>
        </section>
        <section class="auth-form">
            <div class="auth-box">
                <a class="brand" href="index.php"><b>SP</b> StudentPulse</a>
                <h2>Welcome Back</h2>
                <p class="muted">Log in to your student account.</p>

                <?php if ($flashMessage): ?>
                    <div class="notice"><?= e($flashMessage) ?></div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="error"><?= e($error) ?></div>
                <?php endif; ?>

                <form method="post">
                    <input type="hidden" name="csrf" value="<?= e(token()) ?>">
                    <div class="field">
                        <label>Student Email</label>
                        <input type="email" name="email" required placeholder="student@studentpulse.test">
                    </div>
                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <button class="btn" type="submit">Log in</button>
                </form>
                <p>New student? <a href="register.php">Create account</a></p>
                <p>Are you an Administrator? <a href="admin/login.php">Admin Login</a></p>
            </div>
        </section>
    </main>
</body>

</html>