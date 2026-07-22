<?php
require '../includes/core.php';

unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);
unset($_SESSION['admin_role']);

flash('Admin logged out successfully.');
go('login.php');
?>
