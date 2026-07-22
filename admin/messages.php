<?php
require '../includes/core.php';
admin();
require '../config/database.php';

$sql = "SELECT m.*, u.username FROM contact_messages m LEFT JOIN users u ON m.user_id = u.id ORDER BY m.created_at DESC";
$result = mysqli_query($conn, $sql);

$r = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $r[] = $row;
    }
}

$title = 'Message Submissions';
$base = '../';
$adminMode = true;
include '../includes/header.php';
?>

<div class="head">
    <div>
        <h1>Message Submissions</h1>
        <p>View student messages and inquiries submitted via Contact form.</p>
    </div>
</div>

<div class="table">
    <table>
        <thead>
            <tr>
                <th>Sender Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Submitted Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($r)): ?>
                <tr>
                    <td colspan="5">No messages received yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($r as $x): ?>
                    <tr>
                        <td><b><?= e($x['name']) ?></b> <?= $x['username'] ? '<small>('.e($x['username']).')</small>' : '' ?></td>
                        <td><?= e($x['email']) ?></td>
                        <td><?= e($x['subject']) ?></td>
                        <td><?= e($x['message']) ?></td>
                        <td><?= e(date('d M Y H:i', strtotime($x['created_at']))) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
