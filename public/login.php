<?php
session_start();

$_SESSION['user_id'] = 2; // simulate student
echo "Logged in as student (ID = 2)";
echo "<br><a href='index.php'>Go to home</a>";
?>