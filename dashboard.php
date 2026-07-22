<?php
require 'includes/core.php';
auth();
require 'config/database.php';

$student_id = (int)$_SESSION['student_id'];

// Get count of published upcoming events
$sql_events_count = "SELECT COUNT(*) AS total FROM events WHERE status = 'published' AND event_date >= NOW()";
$res_ec = mysqli_query($conn, $sql_events_count);
$row_ec = mysqli_fetch_assoc($res_ec);
$ec = $row_ec['total'] ?? 0;

// Get count of student's RSVPs
$sql_rsvp_count = "SELECT COUNT(*) AS total FROM rsvps WHERE user_id = $student_id";
$res_rc = mysqli_query($conn, $sql_rsvp_count);
$row_rc = mysqli_fetch_assoc($res_rc);
$rc = $row_rc['total'] ?? 0;

// Fetch upcoming published events
$sql_upcoming = "SELECT * FROM events WHERE status = 'published' AND event_date >= NOW() ORDER BY event_date ASC LIMIT 3";
$res_upcoming = mysqli_query($conn, $sql_upcoming);

$ev = [];
if ($res_upcoming) {
    while ($row = mysqli_fetch_assoc($res_upcoming)) {
        $ev[] = $row;
    }
}

$title = 'Dashboard';
include 'includes/header.php';
?>

<section class="hero">
    <div>
        <span class="eyebrow">Student Dashboard</span>
        <h1>Welcome, <?= e($_SESSION['student_username']) ?>.</h1>
        <p>Find your next campus experience and watch the countdown.</p>
    </div>
    <div class="big">
        <span>Upcoming events</span>
        <strong><?= $ec ?></strong>
    </div>
</section>

<div class="stats">
    <div class="stat">
        <strong><?= $ec ?></strong>
        <span>Published events</span>
    </div>
    <div class="stat">
        <strong><?= $rc ?></strong>
        <span>Your RSVPs</span>
    </div>
    <div class="stat">
        <strong><?= e(ucfirst($_SESSION['student_role'])) ?></strong>
        <span>Account role</span>
    </div>
    <div class="stat">
        <strong>5</strong>
        <span>Protected pages</span>
    </div>
</div>

<div class="head">
    <div>
        <h2>Coming up soon</h2>
        <p>Latest campus experiences.</p>
    </div>
    <a class="btn alt" href="events.php">View all</a>
</div>

<div class="grid">
    <?php if (empty($ev)): ?>
        <p>No upcoming events at the moment.</p>
    <?php else: ?>
        <?php foreach ($ev as $x): ?>
            <article class="card">
                <span class="tag"><?= e($x['category']) ?></span>
                <h3><?= e($x['title']) ?></h3>
                <p><?= e($x['venue']) ?> &middot; <?= e(date('d M Y H:i', strtotime($x['event_date']))) ?></p>
                <div class="count" data-time="<?= e($x['event_date']) ?>"></div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>