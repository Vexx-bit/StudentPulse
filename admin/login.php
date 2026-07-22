<?php
require '../includes/core.php';

$error = '';
$flashMessage = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

if (!empty($_SESSION['admin_id'])) {
    go('events.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../config/database.php';
    check();

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Clean user input for procedural mysqli query
    $email_clean = mysqli_real_escape_string($conn, $email);

    // Query database for admin user
    $sql = "SELECT id, username, password_hash, role FROM users WHERE email = '$email_clean' AND role = 'admin'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int)$user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            go('events.php');
        } else {
            $error = 'Invalid admin password.';
        }
    } else {
        $error = 'Invalid admin email or account is not an administrator.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | StudentPulse</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<main class="auth">
    <section class="auth-art" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff;">
        <span class="eyebrow">Administration Portal</span>
        <h1>StudentPulse Admin</h1>
        <p>Manage campus events, control published items, and review student messages.</p>
    </section>
    <section class="auth-form">
        <div class="auth-box">
            <a class="brand" href="../index.php"><b>SP</b> Admin Panel</a>
            <h2>Admin Login</h2>
            <p class="muted">Enter administrative credentials.</p>

            <?php if ($flashMessage): ?>
                <div class="notice"><?= e($flashMessage) ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="csrf" value="<?= e(token()) ?>">
                <div class="field">
                    <label>Admin Email</label>
                    <input type="email" name="email" required placeholder="admin@studentpulse.test">
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button class="btn" type="submit">Log in to Admin Panel</button>
            </form>
            <p><a href="../login.php">&larr; Return to Student Login</a></p>
        </div>
    </section>
</main>
</body>
</html>
