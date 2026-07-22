<?php
require 'includes/core.php';
auth();
require 'config/database.php';

$student_id = (int)$_SESSION['student_id'];

// Get all published upcoming events along with student RSVP status
$sql = "SELECT e.*, 
        EXISTS(SELECT 1 FROM rsvps r WHERE r.event_id = e.id AND r.user_id = $student_id) AS joined,
        (SELECT COUNT(*) FROM rsvps r WHERE r.event_id = e.id) AS total
        FROM events e 
        WHERE status = 'published' AND event_date >= NOW() 
        ORDER BY event_date ASC";

$result = mysqli_query($conn, $sql);

$ev = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ev[] = $row;
    }
}

$title = 'Events';
include 'includes/header.php';
?>

<div class="head">
    <div>
        <h1>Events Hub</h1>
        <p>Browse and reserve your place.</p>
    </div>
</div>

<div class="grid">
    <?php if (empty($ev)): ?>
        <p>No upcoming events found.</p>
    <?php else: ?>
        <?php foreach ($ev as $x): ?>
            <article class="card">
                <span class="tag"><?= e($x['category']) ?> &middot; <?= e($x['total']) ?> attending</span>
                <h3><?= e($x['title']) ?></h3>
                <p><?= e($x['description']) ?></p>
                <p>
                    <b><?= e($x['venue']) ?></b><br>
                    <?= e(date('d M Y H:i', strtotime($x['event_date']))) ?>
                </p>
                <div class="count" data-time="<?= e($x['event_date']) ?>"></div>
                <form class="actions" method="post" action="rsvp.php">
                    <input type="hidden" name="csrf" value="<?= e(token()) ?>">
                    <input type="hidden" name="event_id" value="<?= e($x['id']) ?>">
                    <button class="btn <?= $x['joined'] ? 'alt' : '' ?>" name="action" value="<?= $x['joined'] ? 'cancel' : 'join' ?>">
                        <?= $x['joined'] ? 'Cancel RSVP' : 'RSVP now' ?>
                    </button>
                </form>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>