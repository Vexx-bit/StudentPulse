<?php
require '../includes/core.php';
admin();
require '../config/database.php';

$sql = "SELECT * FROM events ORDER BY event_date DESC";
$result = mysqli_query($conn, $sql);

$ev = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ev[] = $row;
    }
}

$title = 'Manage Events';
$base = '../';
$adminMode = true;
include '../includes/header.php';
?>

<div class="head">
    <div>
        <h1>Manage Events</h1>
        <p>Admin-only event management control panel.</p>
    </div>
    <a class="btn" href="event_form.php">Create Event</a>
</div>

<div class="table">
    <table>
        <thead>
            <tr>
                <th>Event Title</th>
                <th>Date & Time</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($ev)): ?>
                <tr>
                    <td colspan="5">No events found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($ev as $x): ?>
                    <tr>
                        <td><b><?= e($x['title']) ?></b></td>
                        <td><?= e(date('d M Y H:i', strtotime($x['event_date']))) ?></td>
                        <td><?= e($x['category']) ?></td>
                        <td><span class="tag"><?= e(ucfirst($x['status'])) ?></span></td>
                        <td>
                            <a class="btn alt" href="event_form.php?id=<?= e($x['id']) ?>">Edit</a>
                            <form style="display:inline" method="post" action="delete.php" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                <input type="hidden" name="csrf" value="<?= e(token()) ?>">
                                <input type="hidden" name="id" value="<?= e($x['id']) ?>">
                                <button class="btn danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>