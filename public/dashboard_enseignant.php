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
/* =========================
   Sécurité & accès
========================= */
require_once "../utils/auth_check.php";

$allowed_role = "teacher";
require_once "../utils/role_check.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- =========================
         Meta & styles
    ========================== -->
    <meta charset="UTF-8">
    <title>Dashboard Enseignant</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="container">

    <!-- =========================
         Header / Profil
    ========================== -->
    <div class="card">
        <h1>Dashboard Enseignant</h1>

        <p>
            Bonjour <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?> !
        </p>

        <p>
            Rôle : <?php echo $_SESSION["role"]; ?>
        </p>
    </div>

    <!-- =========================
         Gestion des notes
    ========================== -->
    <div class="card">
        <h2>📝 Gestion des notes</h2>

        <p>Saisir et consulter les notes des étudiants par module.</p>

        <a class="btn" href="notes/notes.php">Accéder aux notes</a>
    </div>

    <!-- =========================
         Présences QR Code
    ========================== -->
    <div class="card">
        <h2>📱 Gestion des présences (QR Code)</h2>

        <p>Créer une session de présence et générer un QR code.</p>

        <a class="btn" href="qrview.php">Générer un QR Code</a>
    </div>

    <!-- =========================
         Annonces
    ========================== -->
    <div class="card">
        <h2>📢 Annonces</h2>

        <p>Publier et gérer les annonces pour vos étudiants.</p>

        <a class="btn" href="announcements/create.php">Créer une annonce</a>
        <a class="btn" href="announcements/list.php">Voir les annonces</a>
    </div>

    <!-- =========================
         Étudiants
    ========================== -->
    <div class="card">
        <h2>🎓 Étudiants</h2>

        <p>Voir la liste des étudiants inscrits dans vos modules.</p>

        <a class="btn" href="students_list.php">Voir les étudiants</a>
    </div>

    <!-- =========================
         Déconnexion
    ========================== -->
    <div class="card">
        <a class="btn" href="logout.php">Déconnexion</a>
    </div>

    <!-- =========================
         Réalisateurs (Bloc bas)
    ========================== -->
    <div class="students-block">
        <p class="students-label">Réalisé par</p>

        <div class="students-grid">

            <div class="student-entry">
                <span class="student-name">Bouderraz Maroua</span>
                <span class="student-meta">232335477206 <span class="student-group">Groupe 4</span></span>
            </div>

            <div class="student-entry">
                <span class="student-name">Abaoui Melissa Lyna</span>
                <span class="student-meta">212431859912 <span class="student-group">Groupe 2</span></span>
            </div>

            <div class="student-entry">
                <span class="student-name">Aissaoui Yousra</span>
                <span class="student-meta">232331413601 <span class="student-group">Groupe 4</span></span>
            </div>

            <div class="student-entry">
                <span class="student-name">Aitouamar Aya</span>
                <span class="student-meta">242431438719 <span class="student-group">Groupe 2</span></span>
            </div>

        </div>
    </div>

</div>

</body>
</html>