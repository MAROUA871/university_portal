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
header("Location: login.php");
exit();
?>