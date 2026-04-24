<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Ajouter un utilisateur</h1>

    <?php
    if (isset($_GET["error"])) {
        echo "<p class='error'>Identifiant ou email déjà utilisé.</p>";
    }

    if (isset($_GET["success"])) {
        echo "<p style='color:green; font-weight:bold;'>Utilisateur ajouté avec succès.</p>";
    }
    ?>

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

    <a class="btn" href="dashboard_admin.php">Retour au dashboard admin</a>
</div>

</body>
</html>