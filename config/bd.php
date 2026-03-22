<?php
$host = "localhost";
$bd_name = "university_portal_db";
$username = "root";  
$password = "";      

try {
    $conn = new PDO("mysql:host=$host;dbname=$bd_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>