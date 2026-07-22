<?php
require '../includes/core.php';

if (!empty($_SESSION['admin_id'])) {
    go('events.php');
} else {
    go('login.php');
}
?>
