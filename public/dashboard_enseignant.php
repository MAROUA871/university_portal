<?php
require_once "../utils/auth_check.php";

$allowed_role = "teacher";
require_once "../utils/role_check.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Enseignant</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

    <h1>Dashboard Enseignant</h1>

    <div class="card">
        <h2>Bienvenue dans l'espace enseignant</h2>

        <p>
            Bonjour <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?> !
        </p>

        <p>
            Rôle : <?php echo $_SESSION["role"]; ?>
        </p>
    </div>

    <div class="card">
        <h2>Actions disponibles</h2>

        <p>Vous pouvez consulter vos informations et gérer vos futures tâches pédagogiques.</p>

        <a class="btn" href="logout.php">Déconnexion</a>
    </div>

</div>

</body>
</html>