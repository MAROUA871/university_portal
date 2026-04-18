<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

    <h1>Dashboard Administrateur</h1>

    <div class="card">
        <h2>Bienvenue dans l'espace administrateur</h2>

        <p>
            Bonjour <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?> !
        </p>

        <p>
            Rôle : <?php echo $_SESSION["role"]; ?>
        </p>
    </div>

    <!-- Announcements (FIXED PATH) -->
    <div class="card">
        <h2>📢 Annonces</h2>

        <p>Publier et gérer les annonces pour vos étudiants.</p>

        <a class="btn" href="announcements/create.php">Créer une annonce</a>
        <a class="btn" href="announcements/list.php">Voir les annonces</a>
    </div>

    <div class="card">
        <h2>Gestion des utilisateurs</h2>

        <p>Vous pouvez gérer les utilisateurs de l'application.</p>

        <a class="btn" href="add_user.php">Ajouter un utilisateur</a>
         <br><br>
        <a class="btn" href="user_liste.php">Voir la liste des utilisateurs</a>
        <br><br>
        <a class="btn" href="admins_list.php">Voir les administrateurs</a>
        <br><br>
        <a class="btn" href="teachers_list.php">Voir les enseignants</a>
        <br><br>
         <a class="btn" href="students_list.php">Voir les étudiants</a>
    </div>

    <a class="btn" href="logout.php">Déconnexion</a>

</div>

</body>
</html>