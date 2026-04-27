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
// utils/role_check.php
// Ce fichier vérifie si l'utilisateur a le bon rôle.

// Cette variable doit être définie avant d'inclure ce fichier
if (!isset($allowed_role)) {
    die("Rôle autorisé non défini.");
}

// Vérifier si le rôle de l'utilisateur correspond au rôle autorisé
if ($_SESSION["role"] != $allowed_role) {
    echo "Accès refusé.";
    exit();
}
?>