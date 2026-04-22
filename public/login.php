<?php
/*
    Récupérer le rôle depuis l'URL
    Exemple : login.php?role=student
*/
$role = isset($_GET['role']) ? $_GET['role'] : '';

if (empty($role)) {
    header("Location: index.php");
    exit();
}
/*
    Titre par défaut
*/
$titre = "Connexion";
$role_label = "";

/*
    Changer le titre selon le rôle
*/
if ($role == 'student') {
    $titre = "Student Portal";
    $role_label = "Role selected: Student";
} elseif ($role == 'teacher') {
    $titre = "Teacher Portal";
    $role_label = "Role selected: Teacher";
} elseif ($role == 'admin') {
    $titre = "Admin Portal";
    $role_label = "Role selected: Admin";
}

/*
    Gestion des erreurs
*/
$message_erreur = "";

if (isset($_GET["error"])) {
    if ($_GET["error"] == 1) {
        $message_erreur = "Utilisateur non trouvé.";
    } elseif ($_GET["error"] == 2) {
        $message_erreur = "Mot de passe incorrect.";
    } elseif ($_GET["error"] == 3) {
        $message_erreur = "Rôle inconnu.";
    } elseif ($_GET["error"] == 4) {
        $message_erreur = "Ce compte ne correspond pas au rôle sélectionné.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titre; ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="login-page">
    <div class="login-card">

        <div class="login-logo-box">
            <img src="assets/university_portal_logo.png" alt="Logo PROGRES" class="login-logo">
        </div>

        <!-- Texte arabe -->
        <p class="login-ar" dir="rtl">
            وزارة التعليم العالي والبحث العلمي
        </p>

        <!-- Texte français -->
        <p class="login-fr">
            Ministère de l’Enseignement Supérieur et de la Recherche Scientifique
        </p>

        <!-- Titre du portail -->
        <h2 class="login-title"><?php echo $titre; ?></h2>

        <!-- Rôle sélectionné -->
        <?php if (!empty($role_label)) : ?>
            <p class="role-badge"><?php echo $role_label; ?></p>
        <?php endif; ?>

        <!-- Message d'erreur -->
        <?php if (!empty($message_erreur)) : ?>
            <div class="error-message">
                <?php echo $message_erreur; ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire -->
        <form method="POST" action="../app/controllers/AuthController.php" class="login-form">

            <!-- Envoyer aussi le rôle au contrôleur -->
            <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>">

            <div class="form-group">
                <label for="identifier">Identifiant</label>
                <input type="text" name="identifier" id="identifier" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button class="login-submit-btn" type="submit">Se connecter</button>
        </form>

        <div class="login-links">
            <a class="small-link" href="index.php">Retour à l'accueil</a>
        </div>

    </div>
</div>

</body>
</html>