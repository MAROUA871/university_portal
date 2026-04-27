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
// public/logout.php
// Ce fichier sert à déconnecter l'utilisateur.

// Démarrer la session pour pouvoir la détruire
session_start();

// Supprimer toutes les variables de session
session_unset();

// Détruire complètement la session
session_destroy();

// Rediriger l'utilisateur vers la page de connexion
header("Location: index.php");
exit();
?>