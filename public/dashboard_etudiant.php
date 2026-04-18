<?php
session_start();

require_once "../utils/auth_check.php";

$allowed_role = "student";
require_once "../utils/role_check.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Étudiant</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

    <h2>Dashboard Étudiant</h2>

    <!-- WELCOME CARD -->
    <div class="card">
        <h1>Bienvenue</h1>

        <p>
            Bonjour <?= htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["last_name"]); ?>
        </p>

        <p>
            Rôle : <?= htmlspecialchars($_SESSION["role"]); ?>
        </p>
    </div>

    <!-- ANNOUNCEMENTS CARD -->
    <div class="card">
        <h3>📢 Annonces</h3>

        <p>
            Consultez les annonces des enseignants et de l'administration.
        </p>

        <!-- DIRECT LINK TO LIST.PHP -->
        <a class="btn" href="announcements/list.php">
            Voir les annonces
        </a>
    </div>

    <!-- LOGOUT -->
    <a class="btn" href="logout.php">
        Déconnexion
    </a>

</div>

</body>
</html>