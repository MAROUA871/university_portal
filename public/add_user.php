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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="container">

    <!-- =========================
         Titre
    ========================== -->
    <h1>Ajouter un utilisateur</h1>

    <!-- =========================
         Messages
    ========================== -->
    <?php
    if (isset($_GET["error"])) {
        echo "<p class='error'>Identifiant ou email déjà utilisé.</p>";
    }

    if (isset($_GET["success"])) {
        echo "<p style='color:green; font-weight:bold;'>Utilisateur ajouté avec succès.</p>";
    }
    ?>

    <!-- =========================
         Formulaire
    ========================== -->
    <div class="card">
        <form method="POST" action="insert_user.php">

            <label for="identifier">Identifiant :</label>
            <input type="text" name="identifier" id="identifier" required>

            <label for="first_name">Prénom :</label>
            <input type="text" name="first_name" id="first_name" required>

            <label for="last_name">Nom :</label>
            <input type="text" name="last_name" id="last_name" required>

            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="role">Rôle :</label>
            <select name="role" id="role">
                <option value="student">Étudiant</option>
                <option value="teacher">Enseignant</option>
                <option value="admin">Admin</option>
            </select>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <button class="btn" type="submit">Ajouter</button>

        </form>
    </div>

    <!-- =========================
         Retour
    ========================== -->
    <div class="card">
        <a class="btn" href="dashboard_admin.php">Retour au dashboard admin</a>
    </div>

    <!-- =========================
         Bloc étudiants
    ========================== -->
    <div class="students-block">
        <p class="students-label">Réalisé par</p>

        <div class="students-grid">

            <div class="student-entry">
                <span class="student-name">Bouderraz Maroua</span>
                <span class="student-meta">232335477206 <span class="student-group">Groupe 4</span></span>
            </div>

            <div class="student-entry">
                <span class="student-name">Abaoui Melissa</span>
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