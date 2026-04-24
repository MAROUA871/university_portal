<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

// Vérifier si l'id est présent
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Récupérer l'utilisateur
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if (!$user) {
        echo "Utilisateur non trouvé.";
        exit();
    }

} else {
    echo "ID non fourni.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier utilisateur</title>
    <link rel="stylesheet" href="assets/style.css?v=6">
</head>
<body>

<div class="container">
    <h1>Modifier un utilisateur</h1>

    <form method="POST" action="update_user.php">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <input type="hidden" name="role" value="<?php echo $user['role']; ?>">

        <label for="identifier">Identifiant :</label>
        <input type="text" name="identifier" id="identifier"
               value="<?php echo $user['identifier']; ?>" required>

        <label for="first_name">Prénom :</label>
        <input type="text" name="first_name" id="first_name"
               value="<?php echo $user['first_name']; ?>" required>

        <label for="last_name">Nom :</label>
        <input type="text" name="last_name" id="last_name"
               value="<?php echo $user['last_name']; ?>" required>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email"
               value="<?php echo $user['email']; ?>" required>

        <button class="btn" type="submit">Enregistrer les modifications</button>
    </form>

    <a class="small-link" href="dashboard_admin.php">Retour au dashboard</a>
</div>

</body>
</html>