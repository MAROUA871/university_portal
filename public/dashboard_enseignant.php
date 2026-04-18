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

    <!-- Header -->
    <div class="card">
        <h1>Dashboard Enseignant</h1>

        <p>
            Bonjour <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?> !
        </p>

        <p>
            Rôle : <?php echo $_SESSION["role"]; ?>
        </p>
    </div>

    <!-- Notes -->
    <div class="card">
    <h2>📝 Gestion des notes</h2>

    <p>
        Saisir et consulter les notes des étudiants par module.
    </p>

    <a class="btn" href="../app/views/notes/teacher.php">
        Accéder aux notes
    </a>
</div>

    <!-- QR Attendance -->
    <div class="card">
        <h2>📱 Gestion des présences (QR Code)</h2>

        <p>Créer une session de présence et générer un QR code.</p>

        <a class="btn" href="start_session.php">Générer un QR Code</a>
    </div>

    <!-- Announcements (FIXED PATH) -->
    <div class="card">
        <h2>📢 Annonces</h2>

        <p>Publier et gérer les annonces pour vos étudiants.</p>

        <a class="btn" href="announcements/create.php">Créer une annonce</a>
        <a class="btn" href="announcements/list.php">Voir les annonces</a>
    </div>

    <!-- Students -->
    <div class="card">
        <h2>🎓 Étudiants</h2>

        <p>Voir la liste des étudiants inscrits dans vos modules.</p>

        <a class="btn" href="students/list.php">Voir les étudiants</a>
    </div>

    <!-- Logout -->
    <div class="card">
        <a class="btn" href="logout.php">Déconnexion</a>
    </div>

</div>

</body>
</html>