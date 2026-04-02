<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

// Requête pour récupérer tous les utilisateurs
$sql = "SELECT * FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Liste des utilisateurs</h1>

    <div class="card">
        <table border="1" width="100%" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Identifiant</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
            </tr>

            <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $user["id"]; ?></td>
                    <td><?php echo $user["identifier"]; ?></td>
                    <td><?php echo $user["first_name"]; ?></td>
                    <td><?php echo $user["last_name"]; ?></td>
                    <td><?php echo $user["email"]; ?></td>
                    <td><?php echo $user["role"]; ?></td>
                </tr>
            <?php } ?>

        </table>
    </div>

    <a class="btn" href="dashboard_admin.php">Retour au dashboard</a>
</div>

</body>
</html>