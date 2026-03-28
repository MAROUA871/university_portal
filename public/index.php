<?php
session_start();

// TEMPORARY FAKE LOGIN (remove later)
$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'admin';

echo "University Portal is running<br>";

// Database connection
include(__DIR__ . "/../config/bd.php");

echo "Database connected!";
?>