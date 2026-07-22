<?php
require 'includes/core.php';
auth();
require 'config/database.php';

$student_id = (int)$_SESSION['student_id'];

$sql = "SELECT name, email, subject, message, created_at FROM contact_messages WHERE user_id = $student_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$r = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $r[] = $row;
    }
}

$title = 'My Messages';
include 'includes/header.php';
?>

<div class="head">
    <div>
        <h1>My Sent Messages</h1>
        <p>Your message submission history.</p>
    </div>
</div>

<div class="table">
    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($r)): ?>
                <tr>
                    <td colspan="3">No messages submitted yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($r as $x): ?>
                    <tr>
                        <td><?= e($x['subject']) ?></td>
                        <td><?= e($x['message']) ?></td>
                        <td><?= e($x['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>