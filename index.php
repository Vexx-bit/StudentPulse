<?php
require 'includes/core.php';

if (!empty($_SESSION['admin_id'])) {
    go('admin/events.php');
}

if (!empty($_SESSION['student_id'])) {
    go('dashboard.php');
}

go('login.php');
?>