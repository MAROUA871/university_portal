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
<?php
// utils/auth_check.php
// Ce fichier vérifie si l'utilisateur est connecté.

// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["id"])) {
    // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
    header("Location: /university_portal/public/index.php");
    exit();
}
?>