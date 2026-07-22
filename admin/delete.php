<?php
require '../includes/core.php';
admin();
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check();

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        $sql = "DELETE FROM events WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            flash('Event deleted successfully.');
        } else {
            flash('Failed to delete event: ' . mysqli_error($conn));
        }
    }
}

go('events.php');
?>