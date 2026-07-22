<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "studentpulse";

// Connect to MySQL database using simple procedural mysqli syntax
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Set character set
mysqli_set_charset($conn, "utf8mb4");

// Alias for compatibility
$mysqli = $conn;
?>