<?php
require 'includes/core.php';
auth();
require 'config/database.php';

$err = [];
$student_id = (int)$_SESSION['student_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check();

    $n = trim($_POST['name'] ?? '');
    $em = trim($_POST['email'] ?? '');
    $s = trim($_POST['subject'] ?? '');
    $m = trim($_POST['message'] ?? '');

    if (strlen($n) < 2) {
        $err[] = 'Enter your name.';
    }
    if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
        $err[] = 'Enter a valid email.';
    }
    if (strlen($s) < 3) {
        $err[] = 'Subject is too short.';
    }
    if (strlen($m) < 10 || strlen($m) > 2000) {
        $err[] = 'Message must be 10–2,000 characters.';
    }

    if (empty($err)) {
        $n_clean = mysqli_real_escape_string($conn, $n);
        $em_clean = mysqli_real_escape_string($conn, $em);
        $s_clean = mysqli_real_escape_string($conn, $s);
        $m_clean = mysqli_real_escape_string($conn, $m);

        $sql = "INSERT INTO contact_messages (user_id, name, email, subject, message) VALUES ($student_id, '$n_clean', '$em_clean', '$s_clean', '$m_clean')";

        if (mysqli_query($conn, $sql)) {
            flash('Message saved successfully.');
            go('contact.php');
        } else {
            $err[] = 'Database error: ' . mysqli_error($conn);
        }
    }
}

$title = 'Contact';
include 'includes/header.php';
?>

<div class="head">
    <div>
        <h1>Contact the Events Team</h1>
        <p>Questions and ideas are stored securely.</p>
    </div>
</div>

<div class="panel">
    <?php if (!empty($err)): ?>
        <div class="error"><?= implode('<br>', array_map('e', $err)) ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="csrf" value="<?= e(token()) ?>">
        <div class="fields">
            <div class="field">
                <label>Name</label>
                <input name="name" maxlength="100" required>
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="field full">
                <label>Subject</label>
                <input name="subject" maxlength="150" required>
            </div>
            <div class="field full">
                <label>Message</label>
                <textarea name="message" maxlength="2000" required></textarea>
            </div>
        </div>
        <button class="btn" type="submit">Send message</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>