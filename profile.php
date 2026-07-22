<?php
require 'includes/core.php';
auth();
require 'config/database.php';

$student_id = (int)$_SESSION['student_id'];

$sql = "SELECT username, email, role, created_at FROM users WHERE id = $student_id";
$result = mysqli_query($conn, $sql);
$u = mysqli_fetch_assoc($result);

$title = 'Profile';
include 'includes/header.php';
?>

<div class="head">
    <div>
        <h1>Your Profile</h1>
        <p>Details retrieved from MySQL database using procedural mysqli.</p>
    </div>
</div>

<div class="panel">
    <p><b>Username</b><br><?= e($u['username'] ?? '') ?></p>
    <hr>
    <p><b>Email</b><br><?= e($u['email'] ?? '') ?></p>
    <hr>
    <p><b>Role</b><br><?= e(ucfirst($u['role'] ?? '')) ?></p>
    <hr>
    <p><b>Member Since</b><br><?= e(!empty($u['created_at']) ? date('d F Y', strtotime($u['created_at'])) : 'N/A') ?></p>
</div>

<?php include 'includes/footer.php'; ?>