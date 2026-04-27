<!--P14-->
<!--ABAOUI MELISSA LYNA 
212431859912
GROUPE 2
-->
<!--Bouderraz Maroua    
232335477206
GROUPE 4    
-->
<!--Aitouamar Aya
242431438719
GROUPE 2
-->
<!-- Aissaoui Yousra
 232331413601
 GROUPE 4
-->
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