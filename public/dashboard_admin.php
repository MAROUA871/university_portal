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
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

/* =========================
   Statistiques générales
========================= */
function getCount($conn, $query)
{
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row["total"];
    }

    return 0;
}

$count_students = getCount($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'student'");
$count_teachers = getCount($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'teacher'");
$count_admins   = getCount($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'admin'");
$count_modules  = getCount($conn, "SELECT COUNT(*) AS total FROM modules");
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

    <!-- Carte de bienvenue -->
    <div class="card">
        <h2>Bienvenue dans l'espace administrateur</h2>

        <p>
            Bonjour
            <?php echo htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["last_name"]); ?> !
        </p>

        <p>
            Rôle : <?php echo htmlspecialchars($_SESSION["role"]); ?>
        </p>
    </div>

    <!-- Statistiques -->
    <div class="card">
        <h2>📊 Statistiques</h2>

        <p>Consulter les statistiques générales des étudiants et des résultats.</p>

        <a class="btn" href="statistics_admin.php">Voir les statistiques</a>
    </div>

    <!-- Annonces -->
    <div class="card">
        <h2>📢 Annonces</h2>

        <p>Publier et gérer les annonces pour vos étudiants.</p>

        <a class="btn" href="announcements/create.php">Créer une annonce</a>
        <a class="btn" href="announcements/list.php">Voir les annonces</a>
    </div>

    <!-- Gestion des utilisateurs -->
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

    <!-- Gestion des modules -->
    <div class="card">
        <h2>📚 Gestion des modules</h2>

        <p>Consulter et gérer les modules de la formation.</p>

        <a class="btn" href="modules_list.php">Voir les modules</a>
    </div>

    <!-- Déconnexion -->
    <div class="card">
        <a class="btn" href="logout.php">Déconnexion</a>
    </div>

    <!-- Bloc étudiants réalisateurs -->
    <div class="students-block">
        <p class="students-label">Réalisé par</p>

        <div class="students-grid">

            <div class="student-entry">
                <span class="student-name">Bouderraz Maroua</span>
                <span class="student-meta">
                    232335477206
                    <span class="student-group">Groupe 4</span>
                </span>
            </div>

            <div class="student-entry">
                <span class="student-name">Abaoui Melissa</span>
                <span class="student-meta">
                    212431859912
                    <span class="student-group">Groupe 2</span>
                </span>
            </div>

            <div class="student-entry">
                <span class="student-name">Aissaoui Yousra</span>
                <span class="student-meta">
                    232331413601
                    <span class="student-group">Groupe 4</span>
                </span>
            </div>

            <div class="student-entry">
                <span class="student-name">Aitouamar Aya</span>
                <span class="student-meta">
                    242431438719
                    <span class="student-group">Groupe 2</span>
                </span>
            </div>

        </div>
    </div>

</div>

</body>
</html>