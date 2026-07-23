<?php
$base = $base ?? '';
$title = $title ?? 'StudentPulse';
$adminMode = $adminMode ?? false;
$homeLink = $homeLink ?? ($adminMode ? 'events.php' : $base . 'dashboard.php');
$logoutLink = $logoutLink ?? ($adminMode ? 'logout.php' : $base . 'logout.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> | StudentPulse</title>
    <link rel="stylesheet" href="<?= $base ?>assets/style.css">
</head>

<body>
    <header>
        <a class="brand" href="<?= e($homeLink) ?>">
            <b>SP</b> StudentPulse
            <?= $adminMode ? '<small style="font-size: 0.75em; opacity: 0.8; margin-left: 4px;">[ADMIN]</small>' : '' ?>
        </a>
        <button onclick="document.querySelector('nav').classList.toggle('open')">☰</button>
        <nav>
                <?php if ($adminMode): ?>
                <a href="events.php">Events</a>
                <a href="messages.php">Messages</a>
                <a href="../dashboard.php" target="_blank">View Site</a>
                <a href="logout.php">Logout</a>
                <?php else: ?>
                <a href="<?= $base ?>dashboard.php">Dashboard</a>
                <a href="<?= $base ?>events.php">Events</a>
                <a href="<?= $base ?>contact.php">Contact Us</a>
                <a href="<?= $base ?>profile.php">Profile</a>
                <a href="<?= $base ?>logout.php">Logout</a>
                <?php endif; ?>
        </nav>
    </header>
    <main>
                <?php if ($message = $_SESSION['flash'] ?? null): ?>
                    <?php unset($_SESSION['flash']); ?>
            <div class="notice"><?= e($message) ?></div>
                <?php endif; ?>