<?php
// config/bd.php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "university_portal_db";

// créer la connexion
$conn = mysqli_connect($host, $username, $password, $dbname);

// vérifier la connexion
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
?>