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
   Session & sécurité
========================= */
session_start();

require_once "../utils/auth_check.php";

$allowed_role = "student";
require_once "../utils/role_check.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- =========================
         Meta & styles
    ========================== -->
    <meta charset="UTF-8">
    <title>Dashboard Étudiant</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="container">

    <!-- =========================
         Titre principal
    ========================== -->
    <h2>Dashboard Étudiant</h2>

    <!-- =========================
         Bienvenue / Profil
    ========================== -->
    <div class="card">
        <h1>Bienvenue</h1>

        <p>
            Bonjour <?= htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["last_name"]); ?>
        </p>

        <p>
            Rôle : <?= htmlspecialchars($_SESSION["role"]); ?>
        </p>
    </div>

    <!-- =========================
         Mes notes
    ========================== -->
    <div class="card">
        <h2>📝 Mes notes</h2>

        <p>Consultez vos notes TD, Examen, moyenne et statut par module.</p>

        <a class="btn" href="notes/my_notes.php">Voir mes notes</a>
    </div>

    <!-- =========================
         Annonces
    ========================== -->
    <div class="card">
        <h3>📢 Annonces</h3>

        <p>
            Consultez les annonces des enseignants et de l'administration.
        </p>

        <a class="btn" href="announcements/list.php">
            Voir les annonces
        </a>
    </div>
    <!-- ATTENDANCE CARD -->
    <div class="card">
        <h3>📷 Présence</h3>


        <p> Gérer votre présence aux séances.</p>

        <!-- VIEW ATTENDANCE -->
        <a class="btn" href="attendance_history.php">Voir ma présence</a>

        <br><br>

        <!-- RECORD ATTENDANCE -->
        <a class="btn" href="record_attendance.php">Enregistrer ma présence</a>
    </div>
    <!-- LOGOUT -->
    <a class="btn" href="logout.php">
        Déconnexion
    </a>

 <div class="students-block">
    

<!-- =========================
         Réalisate
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