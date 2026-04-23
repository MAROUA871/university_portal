<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

// Récupérer seulement les administrateurs
$sql = "SELECT * FROM users WHERE role = 'admin' ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des administrateurs</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Liste des administrateurs</h1>

    <?php
    if (isset($_GET["success"])) {
        echo "<p style='color:green; font-weight:bold;'>Administrateur supprimé avec succès.</p>";
    }

    if (isset($_GET["updated"])) {
        echo "<p style='color:green; font-weight:bold;'>Administrateur modifié avec succès.</p>";
    }
    ?>

    <div class="card">
        <table border="1" width="100%" cellpadding="10" cellspacing="0">
            <tr>
                
                <th>Identifiant</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>

            <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                <tr>
                  
                    <td><?php echo $user["identifier"]; ?></td>
                    <td><?php echo $user["first_name"]; ?></td>
                    <td><?php echo $user["last_name"]; ?></td>
                    <td><?php echo $user["email"]; ?></td>

                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>"
                           style="color:blue; text-decoration:none;">
                          ✏️ Edit
                        </a>
                        <br>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>"
                           onclick="return confirm('Voulez-vous vraiment supprimer cet administrateur ?');"
                           style="color:red; text-decoration:none;">
                          🗑️ Delete
                        </a>
                </tr>
            <?php } ?>
        </table>
    </div>

    <a class="btn" href="dashboard_admin.php">Retour au dashboard</a>
</div>

</body>
</html>