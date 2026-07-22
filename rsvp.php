<?php
require 'includes/core.php';
auth();
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check();

    $student_id = (int)$_SESSION['student_id'];
    $event_id = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);
    $action = $_POST['action'] ?? '';

    if ($event_id) {
        if ($action === 'join') {
            $sql = "INSERT IGNORE INTO rsvps (user_id, event_id) VALUES ($student_id, $event_id)";
            if (mysqli_query($conn, $sql)) {
                flash('RSVP saved successfully.');
            }
        } elseif ($action === 'cancel') {
            $sql = "DELETE FROM rsvps WHERE user_id = $student_id AND event_id = $event_id";
            if (mysqli_query($conn, $sql)) {
                flash('RSVP cancelled.');
            }
        }
    }
}

go('events.php');
?>