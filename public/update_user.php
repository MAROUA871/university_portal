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
<?php
require_once "../utils/auth_check.php";

$allowed_role = "admin";
require_once "../utils/role_check.php";

require_once "../config/bd.php";

// Vérifier que le formulaire a été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $role = $_POST["role"];
    $identifier = trim($_POST["identifier"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);

    // Modifier l'utilisateur
    $sql = "UPDATE users
            SET identifier = ?, first_name = ?, last_name = ?, email = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $identifier, $first_name, $last_name, $email, $id);

    if (mysqli_stmt_execute($stmt)) {

        // Retour vers la bonne liste selon le rôle
        if ($role == "student") {
            header("Location: students_list.php?updated=1");
        } elseif ($role == "teacher") {
            header("Location: teachers_list.php?updated=1");
        } elseif ($role == "admin") {
            header("Location: admins_list.php?updated=1");
        }

        exit();

    } else {
        echo "Erreur lors de la modification.";
    }

    mysqli_stmt_close($stmt);

} else {
    echo "Accès non autorisé.";
}
?>