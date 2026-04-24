<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

/* Statistiques */
$count_students = 0;
$count_teachers = 0;
$count_admins = 0;
$count_modules = 0;

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'student'");
if ($row = mysqli_fetch_assoc($result)) {
    $count_students = $row["total"];
}

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'teacher'");
if ($row = mysqli_fetch_assoc($result)) {
    $count_teachers = $row["total"];
}

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'admin'");
if ($row = mysqli_fetch_assoc($result)) {
    $count_admins = $row["total"];
}

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM modules");
if ($row = mysqli_fetch_assoc($result)) {
    $count_modules = $row["total"];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
    <link rel="stylesheet" href="assets/style.css?v=6">
</head>
<body>

<div class="container">

    <h1>Dashboard Administrateur</h1>

    <div class="card">
        <h2>Bienvenue dans l'espace administrateur</h2>

        <p>
            Bonjour <?php echo htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["last_name"]); ?> !
        </p>

        <p>
            Rôle : <?php echo htmlspecialchars($_SESSION["role"]); ?>
        </p>
    </div>
<br> <br>
    <div class="card">
        <h2>📊 Statistiques </h2>
      <p>Consulter les statistiques générales des étudiants et des résultats.</p>
       <a class="btn" href="statistics_admin.php">Voir les statistiques</a> 
    </div>
<br> <br>
    <div class="card">
        <h2>📢 Annonces</h2>

        <p>Publier et gérer les annonces pour vos étudiants.</p>

        <a class="btn" href="announcements/create.php">Créer une annonce</a>
        <a class="btn" href="announcements/list.php">Voir les annonces</a>
    </div>
<br> <br>
    <div class="card">
        <h2>👥 Gestion des utilisateurs</h2>

        <p>Vous pouvez gérer les utilisateurs de l'application.</p>

        <a class="btn" href="add_user.php">Ajouter un utilisateur</a>
        <a class="btn" href="admins_list.php">Voir les administrateurs</a>
        <a class="btn" href="teachers_list.php">Voir les enseignants</a>
        <a class="btn" href="students_list.php">Voir les étudiants</a>
        <a class="btn" href="results_students.php">Résultats des étudiants</a>
        <a class="btn" href="student_report_admin.php">Relevé de notes étudiant</a>
    </div>
<br> <br>
    <div class="card">
        <h2>📚 Gestion des modules</h2>

        <p>Consulter et gérer les modules de la formation.</p>

        <a class="btn" href="modules_list.php">Voir les modules</a>
    </div>
    <br>
    <br>
    <a class="btn" href="logout.php">Déconnexion</a>

</div>

</body>
</html>