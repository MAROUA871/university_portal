<?php
session_start();

// Vérifier connexion
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// Déterminer le dashboard selon le rôle
$dashboard = "dashboard_etudiant.php";

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] == "teacher") {
        $dashboard = "dashboard_enseignant.php";
    } elseif ($_SESSION["role"] == "admin") {
        $dashboard = "dashboard_admin.php";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Portal</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <div class="card">

        <!-- Logos -->
        <div class="top-logos">

            <div class="logo-side">
                <img src="assets/logo_university.png" class="side-logo">
            </div>

            <div class="logo-center">
                <img src="assets/university_portal_logo.png" class="university-portal-logo">
            </div>

            <div class="logo-side">
                <img src="assets/logo_faculty.png" class="side-logo">
            </div>

        </div>

        <!-- Title -->
        <h1 class="main-title">University Portal</h1>

        <!-- Description -->
        <p class="description-fr">
            Gestion des présences via QR Code pour les enseignants et les étudiants.
        </p>

        <p class="description-ar" dir="rtl">
            نظام تسجيل الحضور باستخدام رمز QR للأساتذة والطلبة
        </p>

        <!-- Teacher Section -->
        <div class="section-block">
            <h2 class="section-title">👨‍🏫 Enseignant</h2>

            <a href="start_session.php" class="role-btn teacher-btn">
                Démarrer une séance de présence
            </a>
        </div>

        <!-- Student Section -->
        <div class="section-block">
            <h2 class="section-title">🎓 Étudiant</h2>

            <p class="description-fr">
                Scannez le QR code fourni par votre enseignant pour enregistrer votre présence.
            </p>
        </div>

        <!-- ===== BOUTON RETOUR ===== -->
        <a href="<?php echo $dashboard; ?>" class="btn" style="margin-top:20px;">
            ⬅ Retour au tableau de bord
        </a>

    </div>
</div>

</body>
</html>