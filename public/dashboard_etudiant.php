<?php 
session_start();    
// verifier que l'utilisateur est connecté
require_once "../utils/auth_check.php"; 
// definir le rôle autorisé pour cette page
$allowed_role = "student"; 
// vérifier que l'utilisateur a le bon rôle
require_once "../utils/role_check.php";
// affichage de la page étudiant



?> <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Étudiant</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">

        <h2>Dashboard Étudiant</h2>
        <div class="card">
        <h1>Bienvenue dans l'espace étudiant</h1>

        <p>Bonjour <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?>!</p>
        <p>Rôle : <?php echo $_SESSION["role"]; ?></p>
        </div>
        <a class="btn" href="logout.php">Déconnexion</a>
    
    </div>
</body>
</html>