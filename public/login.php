<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h2>Connexion</h2>
    

    <form method="POST" action="../app/controllers/AuthController.php">
        
        <label for="identifier">Identifiant :</label><br>
        <input type="text" name="identifier" id="identifier" required><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <button class="btn" type="submit">Se connecter</button>
       
    </form>
     <a class="small-link" href="accueil.php">Retour à l'accueil</a>
</div>
    <?php
// Afficher les messages d'erreur selon la valeur de error
if (isset($_GET["error"])) {
    if ($_GET["error"] == 1) {
        echo "<p style='color:red;'>Utilisateur non trouvé.</p>";
    } elseif ($_GET["error"] == 2) {
        echo "<p style='color:red;'>Mot de passe incorrect.</p>";
    } elseif ($_GET["error"] == 3) {
        echo "<p style='color:red;'>Rôle inconnu.</p>";
    }
}
?>
</body>
</html>